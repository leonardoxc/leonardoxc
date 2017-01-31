<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * ssh.php -- a class to execute remote commands over SSH
 *
 *	This file contains the files-based implementation of the SExec
 * class. This implementation relies on the usage of regular temporary
 * files to communicate with the remote end, thus avoiding several
 * drawbacks (mainly deadlocks) associated with pipes.
 *
 *	The SExec class provides methods to launch and control jobs and
 * transfer files over SSH.
 *
 * PHP versions 4 and 5
 *
 * LICENSE:
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @category	Net
 * @package	SExec
 * @author 	José R. Valverde <jrvalverde@acm.org>
 * @copyright 	José R. Valverde <jrvalverde@acm.org>
 * @license	doc/lic/lgpl.txt
 * @version	CVS: $Id: ssh.php,v 1.1 2007/02/23 15:04:59 manolis Exp $
 * @link	http://savannah.cern.ch/projects/GridGRAMM
 * @see		ssh(1), scp(1)
 * @since	File available since Release 1.0
 */


/** 
 * Allow for remote execution of commands using SSH
 *
 *	The SExec class provides a number of facilities for remote
 * command execution using SSH.
 *
 *	The name SExec comes after "rexec" (the remote execution library)
 * and the "exec" facilities available under PHP. As a matter of fact,
 * we try to mimic to some extent the execution facilities offered by
 * PHP over SSH: thus you will find ssh_popen() akin to popen(), etc.
 *
 * <b>RATIONALE</b>
 *
 *	The reason for this class is to allow executing code on a remote
 * back-end avoiding MITM spoofs in your communications. This allows you
 * to provide a web front-end (possibly redundant) and call a remote
 * back-end to execute the job.
 *
 *	Furthermore, you may have fallback features where if execution
 * on a remote back-end fails you can restart the command on a fallback
 * remote host, increasing reliability.
 *
 * <b>DEPENDENCIES</b>
 *
 *	The class relies on an underlying installation of SSH. It has
 * been tested with OpenSSH on Linux, but should work on other systems
 * with OpenSSH as well.
 *
 *	Further, the class in its current inception relies on OpenSSH
 * version being greater than 3.8. If you have an older SSH, please use
 * version 1.0 of this class instead.
 *
 * <b>DESIGN RATIONALE</b>
 *
 *	The reasons for the choices taken are simple: we might have
 * relied on an SSH library (like libSSH) and integrated it with PHP,
 * but then, any weakness/bug/change on said library would require a
 * recompilation of the library and PHP. This is a serious inconvenience.
 * More to that, it would require the maintenance of two simultaneous
 * SSH installations, viz. OpenSSH and the library, duplicating the work
 * of tracking security/bug issues.
 *
 *	By using the underlying SSH commands, we become independent of
 * them: if anything is discovered, you just have to update your system
 * SSH, and nothing else. Otherwise you would have a dependency on SSH
 * to remember, which is always forgotten. This way we avoid getting out
 * of sync with the system's SSH.
 *
 *	Better yet: this easies development, making this class a lot
 * simpler to write, understand, maintain and debug.
 *
 *	Finally, the dependency on SSH being OpenSSH 3.8 or greater is
 * due to efficiency reasons. Establishing an SSH connection is costly
 * in time. If you are going to make many, this would impose a heavy
 * cost on your scripts. We routinely launch several thousand remote 
 * jobs, and authentication delays soon proved unacceptable.
 *
 *	OpenSSH 3.8 introduced the possibility of sharing a single SSH
 * channel between many "connections". This means that only the first
 * (or master) instance (which will provide the shared channel) needs 
 * to authenticate, hence saving significant time.
 *
 *	The constructor then creates a master channel, leaves it idle
 * all the object's lifetime and closses it at the end. This channel
 * might be used as well, but we felt it wasn't such a big loss to keep
 * it idle, and furthermore, being the master, we didn't want to risk
 * getting into any trouble that might close it prematurely. So it stands.
 *
 *	All other routines (which actually do the work) simply hijack on
 * the master channel, hence avoiding the costly authentication step (and
 * executing significantly faster). The only exception are the "COPY" 
 * routines, which can not hijack the master channel and hence must do
 * authentication every time.
 *
 *	One more detail: some methods allow for interactive communication
 * with the remote end. We have simply used a terminal-less connection
 * for them, using regular files as the intermediate communication channels.
 * A pipe implementation is also possible, and works as well, but we have
 * found that dealing with pipes is tricky and error-prone, while using
 * files is simple and intuitive, so we opted for using files.
 *
 *	The difference has to do with the way you communicate with the
 * other end: using pipes you may block on read and/or write, and so
 * may the other end. Since there may occur errors in the process, that
 * implies that getting into a deadlock is trivial. Just picture this
 * scenarios:
 *
 * 	You send a command -> the remote ends starts the command and
 * prompts for input on stdout, hangs reding on stdin -> you read the 
 * prompt and send the input -> the remote end wakes and processes it.
 *
 *	You send a command -> the remote end fails, logs an error on
 * stderr, gets back the system prompt and hangs on reading stdin -> you
 * notice the prompt and read stderr... since you can't predict the 
 * length of the error message you must empty the pipe... and when doing it
 * you hang after reading the last char... -> deadlock
 *
 *	You send a command -> the remote end fails, logs an error on stderr,
 * gets back the system prompt and hangs on reading stdin -> you don't read
 * stderr to avoid hanging, so submit a new command... this goes on and on
 * until the remote side's stderr buffer fills, then the remote side locks
 * waiting for you to read stderr -> you can't know it hang, so you try
 * to submit a new command, and hang on writing waiting for the other end
 * to read your command -> deadlock
 *
 * 	More scenarios are possible, and since you (or the other side)
 * can't predict what's going to happen, it is very tricky to avoid them.
 *
 *	Now, using files, you don't have that problem: whenever you reach
 * the current end-of-file, you get an EOF, no need to hang waiting for
 * the other side to fill it in with data. The other side doesn't hang on
 * writing unless your disk space fills up. It's a lot simpler. 
 *
 *	Your problem with files is continuing reads after new data becomes
 * available: the safest way is to call flush() before reading and seeking
 * to the last position read to avoid having to re-read everything (which
 * implies that after finishing reading you must ftell() your position.
 *
 *	See the included test script for examples.
 *
 * <b>CUSTOMIZATION</b>
 *
 *	You <i>must</i> state to the class where your SSH executables (ssh and
 * scp) are located. This allows you to have them placed anywhere, but
 * also implies the responsability of using full pathnames to reduce
 * hacking dangers. It also allows you to use/test a new SSH implementation
 * installed in a non-standard place before switching to it, or even to
 * keep various SSH installations on the system (e.g. if the system's
 * SSH is not up-to-date, you may install one on your home and use it).
 *
 *	You may also indicate where to store temporary files. This must 
 * be a directory followed by a prefix to use when creating a temporal
 * directory. The parent directory must be writeable by the user who runs 
 * the class (usually it will be run by apache, www or some such). Most commonly 
 * the parent directory will be /tmp or $DocumentRoot/tmp or something similar.
 *
 *	The directory+prefix you state will be used to create a unique
 * temporary work directory for each object instantiated. Examples of
 * a valid specifications are "/tmp/phpSsh-" or "/tmp/". When the object is 
 * instantiated, a random string will be appended to this value to create
 * the actual temporary directory name.
 *	
 *	The reason for allowing specifying a prefix is so that debugging
 * may be easier by facilitating identification of temporaries generated
 * by this class.
 *
 * <b>DEBUGGING</b>
 *
 *	The class comes with extensive debugging aids. To enable them,
 * just set a global variable called $debug_sexec to TRUE. This will output
 * abundant debugging information and leave copies of communication log
 * files for your reference.
 *
 *	Additionally, there is a sample demo script that shows how to
 * use this class and may help you debug it. This script is included 
 * in the distribution (or should be) as 'ssh_debug.php'. See notes
 * and comments within it for more details.
 *
 * @category   	Net
 * @package	SExec
 * @author 	José R. Valverde <jrvalverde@acm.org>
 * @copyright 	José R. Valverde <jrvalverde@es.embnet.org>
 * @license	doc/lic/
 * @version    	Release: 2.1
 * @link	http://savannah.cern.ch/projects/GridGRAMM
 * @see		ssh(1), scp(1)
 * @since	File available since Release 1.0

 */
class SExec {

    // {{{ properties

    /**
     * The current version of the class
     *
     * @var string
     * @access public
     */
    var $version="2.2";
    
    /**
     * remote endpoint ([user@]host[:port])
     *
     * @var string
     * @access private
     */
    var $remote;
    
    /**
     * remote password 
     *
     * @var string
     * @access private
     */
    var $password;

    /**
     * location of ssh program
     *
     * @var string
     * @access private
     */
    var $ssh = "/usr/bin/ssh";
    
    /**
     * location of scp program
     *
     * @var string
     * @access private
     */
    var $scp = "/usr/bin/scp";
    
    /**
     * tmp. dir prefix specification
     *
     * @var string
     * @access private
     */
    var $workdir = "/tmp/phpSsh";
    
    /**
     * name of multiplexing socket
     *
     * @var string
     * @access private
     */
    var $mplex_socket = "/tmp/ssh.mplex";
    
    /**
     * handle to process controlling the master channel
     *
     * @var string
     * @access private
     */
    var $master;
    
    /**
     * stdin of process controlling the master channel
     *
     * @var string
     * @access private
     */
    var $master_input;

	// we set this i nthe custructor
	var $error=0;
    //}}}
    
    //{{{   instantiation
    
    /** Class constructor.
     *
     *	Generate a new instance of a remote execution environment.
     * The object returned allows you to invoke commands to be executed
     * remotely in a way similar to PHP exec commands (popen, proc_open...)
     * over SSH (so that your communications can be secure).
     *
     *	You may specify a remote endpoint and a password, a remote endpoint
     * alone, or nothing at all.
     *
     *	If you provide a remote endpoint and password they are used to drive
     * the communications and execute your commands.
     *
     *	If no password is provided, then a default of "xxyzzy" (the canonical
     * computer magic word) is used. Unless this is your password (not 
     * recommended), this means that the default password is useless unless
     * you are working in a trusted environment where it is not needed and
     * ignored. That may be the case if you enable trusting mechanisms with
     * .shosts/.rhosts or passphraseless RSA/DSA authentication. Not that
     * we endorse them either, but in these cases any password provided will
     * be ignored and it doesn't make sense to provide a real one: xxyzzy
     * can do as well as any other.
     *
     *	If no password and no remote end is provided, then "localhost" is
     * used as the remote end, assuming no password is required (as described
     * above). This is only useful if localhost is trusted, and you have reasons
     * to use SSH internally... Some people does.
     *
     *	Regarding the remote end specification, it can be any valid single-string
     * SSH remote end description: the basic format is
     *
     *	[username@]remote.host[:port]
     *
     *	- "username" is the remote user name to log in as. It is optional. If provided, 
     * 	  it must be separated from the remote host by an "@" sign. If it is not 
     *    provided, the remote username is assumed to be the same as the current local
     *    one.
     *
     *	- "remote.host" is a valid host specification, either a numeric IP address
     *    or a valid host name (which may require a full name or not depending on
     *    your settings).
     *
     * 	- "port" is the remote port where SSH is listening and which we want to
     *    connect to. It is optional, and if provided, must follow the remote host
     *    specification separated from it by a colon ":". If not provided, the
     *    default port (22) is used.
     *
     *	Examples of remote host specifications are "user@host.example.net:22",
     * "someone@host:22", "host.example.net:22", "host:22", 
     * "somebody@host.example.net", "user@host", "host.example.net", "host".
     *
     * Here is an example of how to use this constructor:
     * <code>
     *  require_once 'ssh.php';
     *
     *  $remote = "jruser@example.com";
     *  $password = "PASSWORD";
     *
     *  $rmt = new SExec($remote, $password);
     *   if (! $rmt)
     *  	echo "Couldn't connect to $remote\n";
     * </code>
     *
     *  @param string   The remote end to run the command, in
     *  	    	    the form 'user@host:port' (you may
     *	    	    	    omit the 'user@' or ':port' parts
     *	    	    	    if the default values [i.e. same user
     *	    	    	    or standard port] are OK).
     *
     *  @param string The remote password. Note that if direct
     *  	    	    RSA/DSA/.shosts/.rhosts login is enabled
     *  	    	    then the password will be ignored as
     *  	    	    SSH should not run the ASKPASS command).
     *
     *	@return SExec|false a new connection object with the remote end or
     *	    	    	    FALSE if the connection could not be established.
     *
     *	@access public
     *  @since Method available since Release 1.0
     */
    function SExec($remote="localhost", $password="xxyzzy")
    {
    	global $debug_sexec;
	
    	if ($debug_sexec) echo "\nSExec::SExec($remote, $password)\n";
	if ($debug_sexec) echo "--> Creating a new SExec\n";
    	$this->remote = $remote;
	$this->password = "$password";
	umask(0077);
	/* DESIGN
	 * In order to increase efficiency, we will create a master channel
	 * on class instantiation. The master channel should be closed by a
	 * corresponding class destructor!
	 *
	 * Creating a master channel has the advantage that subsequent SSH
	 * connections will use it and avoid repeating the slow authentication
	 * process: in other words, they will go much, much faster.
	 */
	 
	// first we must generate a unique UNIX socket address or we'll fail
	// We use a tricky trick: generate two random numbers and use them;
	// this is tricky since there might be a problem, but with very low
	// probability. BUT IT MAY STILL FAIL: there's a race condition between
	// the end of the while and the subsequent if.
	do {
	    mt_srand((double)microtime()*1000000 ) .
	    $this->workdir = "/tmp/phpSsh-" . mt_rand() .".". mt_rand();
	    if ($debug_sexec) echo "\nSExec: trying $this->workdir/ ...";
	    // CAUTION: this is potentially an endless loop (albeit with very
	    // low probability) if every possible file did exist.
	}
	while (file_exists($this->workdir));
	if (mkdir($this->workdir) == FALSE) {
	    // we can't continue. How can we cancel this?
	    // try these and then check what happens
	    unset($this);
		$this->error=1;
	   // $this = NULL;
	    return FALSE;
	}
	else 
	    if ($debug_sexec) echo " OK\n";
	// Now we have a place to put the socket... Mmm...
	// Come to think of it, we have a place to put ANY temporary
	// for the class... 
	// XXX Maybe we can change everywhere else to use this?
	$this->mplex_socket = $this->workdir."/mplex_socket";
	
	// Finally we can call SSH -M
	// Create SSH_ASKPASS script to provide the password
	$tmpfname = tempnam($this->workdir, 'SExec-');
	chmod($tmpfname, 0700);
	putenv("DISPLAY=none:0.");
	putenv("SSH_ASKPASS=$tmpfname");
	$fp = fopen($tmpfname, "w");
	fputs($fp, "#!/bin/sh\necho $this->password\n");
	if (!$debug_sexec) 
	    fputs($fp, "/bin/touch $tmpfname.called\n");
	else
	    fputs($fp, "/bin/rm -f $tmpfname\n");
	fclose($fp);
	
	// OK, we are ready. Now let's open a master shell
	$child_stdout = tempnam($this->workdir, "open_sh-O-");
	$child_stderr = tempnam($this->workdir, "open_sh-E-");
	$descriptorspec = array(
	    0 => array("pipe", "r"),  // connect child's stdin to the read end of a pipe
	    1 => array("file", $child_stdout, "a"),  // connect child's stdout to the write end of a pipe
	    2 => array("file", $child_stderr, "a")   // stderr is a pipe to read from
	);

	if ($debug_sexec) echo "$this->ssh -x -t -t ".
		     "-M -S $this->mplex_socket " .
		     "$this->remote\n";
	$this->master = proc_open("$this->ssh -x -t -t ".
		     "-M -S $this->mplex_socket " .
		     "$this->remote",
		     $descriptorspec,
		     $pipes);
	if ((! is_resource($this->master)) || ($this->master == FALSE)) {
		putenv("SSH_ASKPASS=dummy");
		unset($this);
		// $this = NULL;
		$this->error=2;
		return FALSE;
	}
	// we do not need to worry about the output log files, just the
	// input pipe for logout
	$this->master_input = $pipes[0];
	
	// Before going ahead, we need to ensure the control shell 
	// has started: wait for the socket to become available
	// note: there should be a timeout here to avoid a possibly
	// infinite loop XXX JR XXX
	$tm=0;
	do {
	    if ($debug_sexec) echo "waiting 0.1 sec\n";
	    usleep(100000);	// wait 0.1 seconds
		$tm+=0.1;
		if ($tm>10) { // 10 sec timeout
			// echo "SSH: Timout<BR>";
			unset($this);
			$this->error=3;
			return FALSE;
		}
	} while (! file_exists($this->mplex_socket));

	// and now we must register a destructor for the class
	// that will close the connection.
	//register_shutdown_function($this->destruct());
	
	return $this;
    }
    
    /** Class destructor
     *
     *	Destroy all working processes and data streams and structures
     * used by an instance of this class.
     *
     *	This method will send a termination message to the other end
     * of the master channel, close the control stream of the master
     * channel and terminate its controlling process, finally unsetting
     * the object and setting the object handle to NULL.
     *
     *	If a global $debug_sexec is not set to TRUE, then it will also remove
     * all communication traces of this object: i.e. all log files for
     * interactive and master sessions, communications socket, etc...
     *
     *	If global $debug_sexec is set to TRUE, then a copy of all log files
     * created during the lifetime of the object will be left on a
     * temporary directory for your perusal and reference.
     *
     *	@return integer exit status of the master channel control process.
     *
     *	@access public
     *  @since Method available since Release 1.0
     */
    function destruct()
    {
    	global $debug_sexec;
	
	if ($debug_sexec) echo "\nSExec::destruct()\n";
	if ($debug_sexec) echo "--> Destroying SExec master\n";
	if ($debug_sexec) print_r($this);
	if ($debug_sexec) echo "sending logout\n";
	// log out master process
	fputs($this->master_input, "\n\nlogout\n\n");
	// close master stdin
	fclose($this->master_input);
	// close master process
	$ret = proc_close($this->master);
	// remove temporaries
    	if (! $debug_sexec) system("/bin/rm -rf $this->workdir");
	// utterly destroy this instance
	unset($this);
//	$this = NULL;
	return $ret;
    }    
    
    //}}}
    
    //{{{ methods
    /**
     *  Copy a file or directory from one source to a destination
     *
     *  This function copies source to dest, where one of them is a
     * local filespec and the other a remote filespec of the form
     * [user@]host:path
     *
     *  If the original source is a directory, it will be copied
     * recursively to destination (hence easing file transfers).
     *
     *  The function returns TRUE on success or FALSE on failure.
     *
     * <b>EFFICIENCY NOTICE:</b>
     *
     *	The copy routines use 'scp' to do their actual work. Since
     * scp seems to be unable to hitchhike on the master channel,
     * we must do authentication for each copy operation (subroutine 
     * call). These routines are hence a lot more time-expensive 
     * than all the other ones.
     *
     *	You may want to consider whether you can group several
     * copies into one single call to reduce authentication 
     * overheads.
     *
     *	@note DEPRECATED (inconsistent with the class)
     *
     *	@see scp(1)
     *
     *	@param string	The origin path, of the form
     *	    	    	[user@][host][:port]path
     *	    	    	You may omit the optional sections if
     *	    	    	the default values (local username, local
     *	    	    	host, standard SSH port) are OK
     *
     *	@param string	The destination path, of the form
     *	    	    	[user@][host][:port:]path
     *	    	    	You may omit the optional sections if
     *	    	    	the default values (local username, local
     *	    	    	host, standard SSH port) are OK
     *
     *	@param string	The password to use to connect to the remote
     *	    	    	end of the copy (be it the origin or the
     *	    	    	destination, it's all the same). If connection
     *	    	    	is automatic by some means (.shosts or RSA/DSA
     *	    	    	authentication) then it should be ignored and
     *	    	    	any password should do.
     *
     *	@return bool TRUE if all went well, or FALSE on failure.
     *
     *	@access public
     *  @since Method available since Release 1.0
     *	@deprecated Method deprecated as of Release 2.1
     */
    function ssh_copy($origin, $destination, $password)
    {
    	global $debug_sexec;

    	if ($debug_sexec) echo "\nSExec::ssh_copy($origin, $destination, $password)\n";
	umask(0077);
	$tmpfname = tempnam($this->workdir, "copy-");
	chmod($tmpfname, 0700);
	putenv("DISPLAY=none:0.");
	putenv("SSH_ASKPASS=$tmpfname");
	$fp = fopen($tmpfname, "w");
	fputs($fp, "#!/bin/sh\necho $password\n");
	if (! $debug_sexec)  
	    fputs($fp, "/bin/touch $tmpfname.called\n");
	else
	    fputs($fp, "/bin/rm $tmpfname\n");
	fclose($fp);
	$out="";
	exec("$this->scp -pqrC $origin $destination", $out, $status);
	if ($status == 0)
	    return TRUE;
	else
	    return FALSE;
    }


    /**
     *  Copy a file or directory from a local source to a remote destination
     *
     *  This function copies source to dest, where first of them is a
     * local filespec and then comes a remote filespec as a normal
     * system path.
     *
     *	Both, local and remote paths may be absolute or relative.
     *
     *  If the original source is a directory, it will be copied
     * recursively to destination (hence easing file transfers).
     *
     *  The function returns TRUE on success or FALSE on failure.
     *
     *	@param string    The origin local path, either absolute or
     *			relative to the current working directory. 
     *			If it denotes a directory, the copy will 
     *			be recursive.
     *
     *	@param string   The destination path, either
     *			absolute or relative to the login home.
     *
     *	@param array   An optional array of strings to be appended the 
     *	    	    	copy operation's output for debugging/diagnostics.
     *
     *	@return bool TRUE if all went well, or FALSE on failure.
     *
     *	@access public
     *  @since Method available since Release 2.1
     */
    function ssh_copy_to($localpath, $remotepath, &$out)
    {
    	global $debug_sexec;

    	if ($debug_sexec) echo "\nSExec::ssh_copy_to($localpath, $remotepath)\n";

/*	This would be great if SCP could hijack the shared connection (sic)
	umask(0077);
	$tmpfname = tempnam($this->workdir, "copy-to-");
	chmod($tmpfname, 0700);
	putenv("DISPLAY=none:0.");
	putenv("SSH_ASKPASS=$tmpfname");
	$fp = fopen($tmpfname, "w");
	fputs($fp, "#!/bin/sh\necho $this->password\n");
	if (! $debug_sexec)  
	    fputs($fp, "/bin/touch $tmpfname.called\n");
	else
	    fputs($fp, "/bin/rm $tmpfname\n");
	fclose($fp);
	if ($debug_sexec) echo "$this->scp -pqrC $localpath $this->remote:$remotepath\n";
	$out = "";
	exec("$this->scp -pqrC $localpath $this->remote:$remotepath", $out, $status);
	if ($status == 0)
	    return TRUE;
	else {
	    if ($debug_sexec) echo $out . "\n";
	    return FALSE;
	}
*/
	// NOTE THAT WE NEED GNU TAR !!!
	$retval = $this->ssh_exec("test -d $remotepath 2>&1", $out);
	if ($retval == 0) {
	    // destination is a directory, copy $local inside it
	    if ($debug_sexec) echo "--> Remote is a directory\n";
	    $fn = basename($localpath);
	    $dn = dirname($localpath);
	    if ($debug_sexec) echo "--> Executing\n" .
	    	"/bin/tar -C $dn -cf - $fn | " .
		"ssh -x -T -C -S  $this->mplex_socket $this->remote " .
		"\"/bin/tar -C $remotepath -xf -\"\n";
	    exec("(/bin/tar -C $dn -cf - $fn | " .
	    	 "ssh -x -T -C -S  $this->mplex_socket $this->remote " .
		 "\"/bin/tar -C $remotepath -xf -\")2>&1", 
	    	$out, $retval);
	} else {
	    // destination is not a directory, copy _to_ it
	    if ($debug_sexec) 
	    	echo "--> remote is not a directory or does not exist\n";
	    if ((file_exists("$localpath/.")) && (is_dir("$localpath/."))) {
	    	// if local is a dir, try to create it remotely with new name
	    	$retval = $this->ssh_exec("/bin/mkdir -p $remotepath ", $out);
		if ($retval != 0) {
		    // we can't create it, either it already exists as a
		    // regular file or we don't have permissions, anyhow,
		    // we can't do the copy
	    	    if ($debug_sexec) print_r($out);
		    return FALSE;
		}
		// now cd lo local and copy over to remote
		if ($debug_sexec) echo "--> Executing \n" .
			"    /bin/tar -C $localpath -cf - . | \n" .
			"    $this->ssh -x -T -C -S $this->mplex_socket $this->remote \n" .
	    		"    /bin/tar -C $remotepath -xf -\n";
		exec("(/bin/tar -C $localpath -cf - . | " .
	    	    "$this->ssh -x -T -C -S $this->mplex_socket $this->remote " .
	    	    "/bin/tar -C $remotepath -xf -)2>&1", 
		    $out, $retval);
	    }
	    else {
	    	// non-dir: file, block-special, char-special, pipe, socket...
		if ($debug_sexec) echo "--> Executing \n" .
		    "    cat $localpath | \n" .
		    "    $this->ssh -x -T -C -S $this->mplex_socket $this->remote \n" .
		    "    \"cat > $remotepath\"\n";
	    	exec("(cat $localpath | " .
	    	    "$this->ssh -x -T -C -S $this->mplex_socket $this->remote " .
		    "\"cat > $remotepath\") 2>&1", $out, $retval);
	    }
	}
	if ($retval != 0) {
	    if ($debug_sexec) print_r($out);
    	    return FALSE;
	}
	else
	    return TRUE;
    }
    
    /**
     *  Copy a file or directory from a remote source to a local destination
     *
     *  This function copies source to dest, where first of them is a
     * remote filespec and then comes a local filespec, both specified 
     * as normal system paths.
     *
     *	Both, local and remote paths may be absolute or relative.
     *
     *  If the original source is a directory, it will be copied
     * recursively to destination (hence easing file transfers).
     *
     *  The function returns TRUE on success or FALSE on failure.
     *
     *	@param string   The origin remote path, either absolute or
     *			relative to the login home. If it denotes a 
     *			directory, the copy will be recursive.
     *
     *	@param string    The local destination path, either
     *			absolute or relative to the current working
     *			directory.
     *
     *	@param array   An optional array of strings to be appended the 
     *	    	    	copy operation's output for debugging/diagnostics.
     *
     *	@return bool TRUE if all went well, or FALSE on failure.
     *
     *	@access public
     *  @since Method available since Release 1.0
     */
    function ssh_copy_from($remotepath, $localpath, &$out)
    {
    	global $debug_sexec;

    	if ($debug_sexec) echo "SExec::ssh_copy_from($remotepath, $localpath)\n";

/*	This would be great if SCP could hijack the shared connection (sic)
	umask(0077);
	$tmpfname = tempnam($this->workdir, "copy-from-");
	chmod($tmpfname, 0700);
	putenv("DISPLAY=none:0.");
	putenv("SSH_ASKPASS=$tmpfname");
	$fp = fopen($tmpfname, "w");
	fputs($fp, "#!/bin/sh\necho $this->password\n");
	if (! $debug_sexec)  
	    fputs($fp, "/bin/touch $tmpfname.called\n");
	else
	    fputs($fp, "/bin/rm $tmpfname\n");
	fclose($fp);
	if ($debug_sexec) echo "$this->scp -pqrC $this->remote:$remotepath $localpath\n";
	$out = "";
	exec("$this->scp -pqrC $this->remote:$remotepath $localpath", $out, $status);
	if ($status == 0)
	    return TRUE;
	else {
	    if ($debug_sexec) echo $out . "\n";
	    return FALSE;
	}
*/  	
    	if ((file_exists("$localpath/.")) && (is_dir("$localpath/."))) {
	    // Local is a directory. Copy remote into it.
	    if ($debug_sexec) echo "--> $localpath/. is a dir\n";
    	    if ($debug_sexec) echo "--> Executing\n" .
	    "$this->ssh -x -T -C -S $this->mplex_socket $this->remote " .
	    	    "\"/bin/tar -C " .dirname($remotepath). 
	    		" -cf - ". basename($remotepath) ."\" | ".
	    		"/bin/tar -C $localpath -xf -\n";
    	    exec("($this->ssh -x -T -C -S $this->mplex_socket $this->remote " .
	    	    "\"/usr/local/bin/tar -C " .dirname($remotepath). 
	    		" -cf - ". basename($remotepath) ."\" | ".
	    		"/bin/tar -C $localpath -xf -) 2>&1",
		 $out, $res);
    	}
	else {
	    // either the local side does not exist or is not a directory
	    // if remote is a directory
	    //	    make local equivalent and copy contents (make will
	    //	    fail if local exists as a non-dir)
	    if ($debug_sexec) echo "--> $localpath is NOT a dir\n";
	    $res = $this->ssh_exec("test -d $remotepath 2>&1", $out);
	    if ($res == 0) {
	    	exec("/bin/mkdir -p $localpath 2>&1", $out, $res);
		if ($res != 0) {
		    // can't create the dir, either it is a regular file
		    // or we don't have privileges
		    if ($debug_sexec) print_r($out);
		    return FALSE;
		}
		// copy in the remote contents
		if ($debug_sexec) echo "-->Executing\n" .
		    "($this->ssh -x -T -C -S $this->mplex_socket $this->remote " .
		    "\"/bin/tar -C $remotepath -cf - .\" | " .
		    "/bin/tar -C $localpath -xf -)2>&1\n";
		exec("($this->ssh -x -T -C -S $this->mplex_socket $this->remote " .
		    "\"/bin/tar -C $remotepath -cf - .\" | " .
		    "/bin/tar -C $localpath -xf -)2>&1",
		    $out, $res);
		
	    } else {
	    	// remote is a non-dir: cat over local
		if ($debug_sexec) echo "-->Executing\n" .
		    "($this->ssh -x -T -C -S $this->mplex_socket $this->remote " .
		    "\"cat $remotepath\" | ".
		    " cat > $localpath) 2>&1\n";
	    	exec("($this->ssh -x -T -C -S $this->mplex_socket $this->remote " .
		    "\"cat $remotepath\" | ".
		    " cat > $localpath) 2>&1", $out, $res);
    	    }
    	}
	if ($res == 0) 
	    return TRUE;
	else {
	    if ($debug_sexec) print_r($out);
	    return FALSE;
	}
    }

    /**
     *	Execute a single command remotely
     *
     *  Execute a single command remotely using ssh and 
     * display its output, optionally returning its exit 
     * status (like passthru)
     *
     *	This function is intended to be used as a one-time
     * all-at-once non-interactive execution mechanism which
     * will run the command remotely and display its output.
     *
     *	If you try to issue an interactive command using this
     * function, all you will get is unneccessary trouble. So
     * don't!
     *
     *  This might be done as well using a pipe on /tmp and
     * making the command 'cat' the pipe: when ssh runs, it
     * runs the command 'cat' on the pipe and hangs on read.
     *  Then we just need a thread to open the pipe, put the
     * password and close the pipe.
     *
     *  This other way the password is never wirtten down.
     * But, OTOH, the file life is so ephemeral that most
     * of the time it will only exist in the internal system
     * cache, so this approach is not that bad either.
     *
     *	@see passthru()
     *
     *  @param string command  The command to execute on the remote end
     *  	    	    NOTE: if you want to use redirection, the
     *  	    	    entire remote command line should be 
     *  	    	    enclosed in additional quotes!
     *  @param integer status   Optional, this will hold the termination
     *  	    	    status of SSH after invocation, which
     *  	    	    should be the exit status of the remote
     *  	    	    command or 255 if an error occurred
     *  @return void
     *
     *	@access public
     *  @since Method available since Release 1.0
     */
    function ssh_passthru($command, &$status)
    {
    	global $debug_sexec;

    	if ($debug_sexec) echo "status = $status\n";
	// go
	if (isset($status)) {
	    if ($debug_sexec) echo "st: $this->ssh -x -t -t -S $this->mplex_socket $this->remote \"$command\"\n";
	    passthru("$this->ssh -x -t -t -S $this->mplex_socket $this->remote \"$command\"", $status);
	}
	else {
	    if ($debug_sexec) echo "~st: $this->ssh -x -t -t  -S $this->mplex_socket $this->remote \"$command\"\n";
	    passthru("$this->ssh -x -t -t  -S $this->mplex_socket $this->remote \"$command\"");
    	}
    }
    
    
    /**
     *	Execute a remote command using SSH
     *
     *	This function sort of mimics rexec(3) using SSH as the transport
     * protocol.
     *
     *	The function returns the exit status of the remote command, and
     * appends the remote job output to an optional argument.
     *
     *	This function is intended to be used as a one-time
     * all-at-once non-interactive execution mechanism which
     * will run the command remotely and return its output.
     *
     *	If you try to issue an interactive command using this
     * function, all you will get is unneccessary trouble. So
     * don't!
     *
     *  @param string command  The command to execute on the remote end
     *  	    	    NOTE: if you want to use redirection, the
     *  	    	    entire remote command line should be 
     *  	    	    enclosed in additional quotes!
     *	@param  array If the output argument is present, then the specified 
     *	    	    	    array will be filled with every line of output 
     *	    	    	    from the command. Line endings, such as \n, are 
     *	    	    	    not included in this array. Note that if the array 
     *	    	    	    already contains some elements, exec() will append 
     *	    	    	    to the end of the array. If you do not want the 
     *	    	    	    function to append elements, call unset() on the 
     *	    	    	    array before passing it to exec().
     *  @return integer status  will hold the termination
     *  	    	    status of SSH after invocation, which
     *  	    	    should be the exit status of the remote
     *  	    	    command or 255 if an error occurred
     *
     *	@access public
     *  @since Method available since Release 1.0
     */
    function ssh_exec($command, &$out)
    {
    	global $debug_sexec;

    	if ($debug_sexec) echo "SExec::ssh_exec($command, $out)\n";
	umask(0077);
	$tmpfname = tempnam($this->workdir, 'exec');
	chmod($tmpfname, 0700);
	if ($debug_sexec) echo $tmpfname . "\n";

	exec("$this->ssh -x -t -t -S $this->mplex_socket $this->remote \"$command\"", $out, $retval);
	return $retval;

    }
    
    /**
     *	Open an SSH connection to a remote site with a shell to run 
     * interactive commands
     *
     *	Connects to a remote host and opens an interactive shell session
     * with NO controlling terminal.
     *
     *	This routine creates communication streams with the remote shell,
     * and stores all output (standard and error) of the connection into
     * two separate local log files (one for stdout and one for stderr).
     *
     *	Returns a process_control array which contains the process resource
     * ID and an the standard file descriptors which the caller may use to
     * interact with the remote shell.
     *
     * The process control array contains:
     *
     *	'process' -- the process resource for the newly created connection
     *
     *	'std_in' -- handle to the standard input of the new connection
     *
     *	'std_out' -- handle to standard output of the new connection
     *
     *	'std_err' -- handle to standard error of the new connection
     *
     *	'stdout_file' -- actual filename of the local log file for the
     *		new connection standard output
     *
     *	'stderr_file' -- actual filename of the local log file for the
     *		new connection standard error
     *
     *	@return mixed|false a process control associative array or FALSE
     *	    	on failure.
     *
     *	@access public
     *  @since Method available since Release 1.0
     */
    function ssh_open_shell()
    {	
	global $debug_sexec;

	// Open a child process with the 'proc_open' function. 
	//
	// Some tricks: we must open the connection using '-x' to disable
	// X11 forwarding, and use '-t -t' to avoid SSH generating an error
	// because we are not connected to any terminal.
	//
	// NOTE: if the web server is trusted remotely (i.e. it's SSH public 
	// key is accepted in ~user@host:.ssh/authorized_keys) then any 
	// password will do.

	// Prepare I/O
	umask(0077);
	if ($debug_sexec) {
	    $child_stdout = tempnam($this->workdir, "open_sh-".getmypid()."-O-");
	    $child_stderr = tempnam($this->workdir, "open_sh-".getmypid()."-E-");
	} else {
	    $child_stdout = tempnam($this->workdir, "open_sh-");
	    $child_stderr = tempnam($this->workdir, "open_sh-");
	}
	$descriptorspec = array(
            0 => array("pipe", "r"),  // connect child's stdin to the read end of a pipe
            1 => array("file", $child_stdout, "a"),  // connect child's stdout to the write end of a pipe
            2 => array("file", $child_stderr, "a")   // stderr is a pipe to read from
	);
	if ($debug_sexec) echo "$this->ssh -x -t -t -S $this->mplex_socket $this->remote<br />\n";
	$process = proc_open("$this->ssh -x -t -t -S $this->mplex_socket $this->remote", 
	    		 $descriptorspec,
			 $pipes);
	
	// check status
	if ((!is_resource($process)) || ($process == FALSE)) 
	{
	    letal("SSH::connect", "cannot connect to the remote host");
	    return FALSE;
	}
	if ($debug_sexec) echo "proc_open done<br />\n";

	// $pipes now looks like this:
	//   0 => writeable handle connected to child stdin
	
	// Open child's stdin and stdout
	$pipes[1] = fopen($child_stdout, "r");
	$pipes[2] = fopen($child_stderr, "r");
	
	// Should we leave this to the user?
	// set to non-blocking and avoid having to call fflush
	//stream_set_blocking($pipes[0], FALSE);
	//stream_set_blocking($pipes[1], FALSE);
	//stream_set_blocking($pipes[2], FALSE);
	stream_set_write_buffer($pipes[0], 0);
	stream_set_write_buffer($pipes[1], 0);
	stream_set_write_buffer($pipes[2], 0);

	// We now have a connection to the remote SSH
	// Server which we may use to send commands/receive output
	$p = array('process' => $process
	    	    ,'std_in' => $pipes[0]
    	    	    ,'std_out' => $pipes[1]
		    ,'std_err' => $pipes[2] 
		    ,'stdout_file' => $child_stdout
		    ,'stderr_file' => $child_stderr
		   );
	if ($debug_sexec)  {
	    echo "process descriptor array is \n";
	    print_r($p);
	}
	return $p;
    }
    
    /**
     *	Open an SSH connection to run an interactive command on a remote
     * site
     *
     *	Connects to a remote host and runs an interactive command
     * with NO controlling terminal.
     *
     *	This routine creates communication streams with the remote shell,
     * and stores all output (standard and error) of the connection into
     * two separate local log files (one for stdout and one for stderr).
     *
     *	Returns a process_control array which contains the process resource
     * ID and an the standard file descriptors which the caller may use to
     * interact with the remote shell.
     *
     * The process control array contains:
     *
     *	'process' -- the process resource for the newly created connection
     *
     *	'std_in' -- handle to the standard input of the new connection
     *
     *	'std_out' -- handle to standard output of the new connection
     *
     *	'std_err' -- handle to standard error of the new connection
     *
     *	'stdout_file' -- actual filename of the local log file for the
     *		new connection standard output
     *
     *	'stderr_file' -- actual filename of the local log file for the
     *		new connection standard error
     *
     *	@param	string command to be executed interactively on the remote end
     *
     *	@return mixed|false a process control associative array or FALSE
     *	    	on failure.
     *
     *	@access public
     *  @since Method available since Release 1.0
     */
    function ssh_open_command($command)
    {	
	global $debug_sexec;

	// Open a child process with the 'proc_open' function. 
	//
	// Some tricks: we must open the connection using '-x' to disable
	// X11 forwarding, and use '-t -t' to avoid SSH generating an error
	// because we are not connected to any terminal.
	//
	// NOTE: if the web server is trusted remotely (i.e. it's SSH public 
	// key is accepted in ~user@host:.ssh/authorized_keys) then any 
	// password will do.

	// Prepare I/O
	umask(0077);
	if ($debug_sexec) {
	    $child_stdout = tempnam($this->workdir, "open_cmd-".getmypid()."-1-");
	    $child_stderr = tempnam($this->workdir, "open_cmd-".getmypid()."-2-");
	} else {
	    $child_stdout = tempnam($this->workdir, "open_cmd-");
	    $child_stderr = tempnam($this->workdir, "open_cmd-");
	}
	$descriptorspec = array(
            0 => array("pipe", "r"),  // connect child's stdin to the read end of a pipe
            #1 => array("pipe", "a"),  // connect child's stdout to the write end of a pipe
            #2 => array("pipe", "a")   // stderr is a pipe to read from
	    1 => array("file", $child_stdout, "a"),
	    2 => array("file", $child_stderr, "a")
	);

	if ($debug_sexec) echo "$this->ssh -x -t -t -S $this->mplex_socket $this->remote $command<br />\n";
	$process = proc_open("$this->ssh -x -t -t -S $this->mplex_socket $this->remote \"$command\"", 
	    		 $descriptorspec,
			 $pipes);
	
	// check status
	if ((!is_resource($process)) || ($process == FALSE)) 
	{
	    letal("SSH::connect", "cannot connect to the remote host");
	    return FALSE;
	}
	if ($debug_sexec) echo "proc_open done<br />\n";

	// $pipes now looks like this:
	//   0 => writeable handle connected to child stdin
	
	// Open child's stdin and stdout
	$pipes[1] = fopen($child_stdout, "r");
	$pipes[2] = fopen($child_stderr, "r");
	
	// Should we leave this to the user?
	// set to non-blocking and avoid having to call fflush
	#stream_set_blocking($pipes[0], FALSE);
	#stream_set_blocking($pipes[1], FALSE);
	#stream_set_blocking($pipes[2], FALSE);
	stream_set_write_buffer($pipes[0], 0);
	stream_set_write_buffer($pipes[1], 0);
	stream_set_write_buffer($pipes[2], 0);

	// We now have a connection to the remote SSH
	// Server which we may use to send commands/receive output
	$p = array('process' => $process
	    	    ,'std_in' => $pipes[0]
    	    	    ,'std_out' => $pipes[1]
		    ,'std_err' => $pipes[2] 
		    ,'stdout_file' => $child_stdout
		    ,'stderr_file' => $child_stderr
		   );
	if ($debug_sexec)  {
	    echo "process descriptor array is \n";
	    print_r($p);
	}
	return $p;
    }
    
    /**
     * Get output until we reach a given regular expression
     *
     *	@note EXPERIMENTAL, requires more thought and experience.
     */
    function ssh_out_expect($p, $expr="^# ")
    {
    	do {
    		flush();
		fseek($p["std_out"], $last);
	    	$line = fgets($p["std_out"], 1024);
	   	 #echo ">> ".$line;
		$last = ftell($p["std_out"]);
    	} while ((! feof($p["std_out"]) ) || (! ereg($expr, $line)));
    }

    /**
     * Close an SSH interactive session
     *
     *	This method terminates a previously open interactive remote 
     * session. It will send a termination notification to the
     * remote end, close the connection with control and communication
     * streams, and terminate the local control process.
     *
     *	Copies of the log files that contain the output and error
     * of the communication are left out for later reference and 
     * local peruse. If you don't need them any longer, you may
     * delete them or just leave them around until the class destructor
     * is called (which will remove all session traces),
     *
     *	@param mixed p an associative array with the description of the interactive
     *		session control process, obtained by a previous call to one
     *		of the interactive session creation methods ssh_open_shell()
     *		or ssh_open_command().
     *
     *	@return integer the exit status of the remote interactive session.
     *
     *	@access public
     *  @since Method available since Release 1.0
     */
    function ssh_close($p)
    {
    	global $debug_sexec;
	
	    fwrite($p['std_in'], "\n");
	    fwrite($p['std_in'], "logout\n");
	    fflush($p['std_in']);
	    fclose($p['std_in']); fclose($p['std_out']); fclose($p['std_err']);
	    if ($debug_sexec) echo "pipes/files closed\n";
	    // XXX we should delete the log files here...
	    return proc_close($p['process']);
    }
    
#    if ($php_version >= 5)
#    {
#	/**
#	 * send a signal to a running ssh_open_* process
#	 */
#	function ssh_signal($p, $signal)
#	{
#    	    return proc_terminate($p['process'], $signal);
#	}
#	/**
#	 * get info about a running ssh_open_* process
#	 */
#	function ssh_get_status($p)
#	{
#    	    return proc_get_status($p['process']);
#	}
#    }
    
    /**
     *	Execute a remote command and keep an unidirectional stream
     * contact with it.
     *
     *	This routine mimics 'popen()' but uses ssh to connect to
     * a remote host and run the requested command: in other words,
     * it opens a pipe to a remotely executed command. This pipe is
     * unidirectional, with the communications direction controlled
     * by a method parameter.
     *
     *	@see popen() for more details.
     *
     *	@param string command is the command to execute on the remote end
     *
     *	@param string mode specifies the communications direction for the 
     *		pipe: if set to "r" (read), then we will be able to
     *		collect command output only; if set to "w" (write)
     *		then we may only send input to the remote command.
     *
     *	@return resource a handle to the unidirectional communication stream,
     *		similar to that returned by fopen(), or FALSE on
     *		failure. This handle must be closed with ssh_pclose().
     *
     *	@access public
     *  @since Method available since Release 1.0
     */
    function ssh_popen($command, $mode)
    {
    	global $debug_sexec;

	// go
	return popen("$this->ssh -x -t -t -S $this->mplex_socket $this->remote \"$command\"", $mode);
    }
    
    /**
     * Close a piped remote execution command control pipe.
     *
     *	This routine accepts as input the handle for the control stream
     * of a remote command and closes it, terminating the command as well.
     * The handle must be valid and obtained through a call to ssh_popen().
     *
     *	@param resource f is the file handle associated with the pipe control stream
     *
     *	@return integer the termination status of the command that was run.
     *
     *	@access public
     *  @since Method available since Release 1.0
     */
    function ssh_pclose($f)
    {
    	return pclose($f);
    }

    //}}}
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */

?>

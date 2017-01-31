<?
/**
 * General utility functions
 *
 * This file contains convenience functions used throughout the package. 
 *
 * @author José R. Valverde <jrvalverde@cnb.uam.es>
 * @version 1.0
 * @copyright CSIC - GPL
 */

/**
 * include global configuration definitions
 */
require_once("./config.php");

// ------------- COMMODITY ROUTINES ----------------

/**
 * Start the display of a www page
 *
 * We have it as a function so we can customise all pages generated as
 * needed. This routine will open HTML, create the page header, and 
 * include any needed style sheets (if any) to provide a common 
 * look-and-feel for all pages generated.
 */
function set_header()
{
    global $app_name, $app_dir;
    // Start HTML vx.xx output
    echo "<html>";
    // Print headers
    echo "<head>";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=ISO-8859-1\">";
    echo "<meta name=\"DESCRIPTION\" content=\"a web interface to run TINKER molecular modelling on the EGEE grid\">";
    echo "<meta name=\"AUTHOR\" content=\"EMBnet/CNB\">";
    echo "<meta name=\"COPYRIGHT\" content=\"(c) 2004-5 by CSIC - Open Source Software\">";
    echo "<meta name=\"GENERATOR\" content=\"$app_name\">";
    echo "<link rel=\"StyleSheet\" href=\"$app_dir/style/style.css\" type=\"text/css\"/>";
    echo "<link rel=\"shortcut icon\" href=\"$app_dir/images/favicon.ico\"/>";
    echo "<title=\"$app_name\">";
    echo "</head>";
    // Prepare body
    echo "<body bgcolor=\"white\" background=\"$app_dir/images/6h2o-w-small.gif\" link=\"ffc600\" VLINK=\"#cc9900\" ALINK=\"#4682b4\">";
}

/**
 * close a web page
 *
 * Make sure we end the page with all the appropriate formulisms:
 * close the body, include copyright notice, state creator and
 * any needed details, and close the page.
 */
function set_footer()
{
	global $maintainer, $app_dir;
	// close body
	echo "</body><hr>";
	// footer
	echo "<center><table border=\"0\" width=\"90%\"><tr>";
	    // Copyright and author
	    echo "<td><A HREF=\"$app_dir/c/copyright.html\">&copy;</a>EMBnet/CNB</td>";
    	    // contact info
	    echo "<td align=\"RIGHT\"><A HREF=\"emailto:$maintainer\">$maintainer</a></td>";
	echo "</tr></table></center>";
	// Page
	echo "</html>";
}

/**
 * print a warning
 *
 * Prints a warning in a separate pop-up window.
 * A warning is issued when a non-critical problem has been detected.
 * Execution can be resumed using some defaults, but the user should
 * be notified. In order to not disrupt the web page we are displaying
 * we use a JavaScript pop-up alert to notify the user.
 *
 * @param msg the warning message to send the user
 */
function warning($msg)
{
    echo "<script language=\"JavaScript\">";
    echo "alert(\"WARNING:\n $msg\");";
    echo "</script>";
}

/**
 * print an error message and exit
 *
 * Whenever we detect something wrong, we must tell the user. This function
 * will take an error message as its argument, format it suitably and
 * spit it out.
 *
 * @note This might look nicer using javascript to pop up a nice window with
 * the error message. Style sheets would be nice too.
 *
 * @param where the name of the caller routine or the process where the
 * 		error occurred
 * @param what  a description of the abnormal condition that triggered
 *  		the error
 */

function error($where, $what)
{
	// format the message
	echo "<p></p><center><table border=\"2\">\n";
	echo "<tr><td><center><font color=\"red\"><strong>\n";

	// output the message
	echo "ERROR - HORROR\n";

	// close format
	echo "</strong></font></center></td></tr>\n";
	echo "<tr><td><center><b>$where</b></center></td></tr>\n";
	echo "<tr><td><center>$what</center></td></tr>\n";
	echo "</table></center><p></p>\n";
}

/**
 * print a letal error message and die
 *
 * This function is called whenever a letal error (one that prevents
 * further processing) is detected. The function will spit out an
 * error message, close the page and exit the program.
 * It should seldomly be used, since it may potentially disrupt the
 * page layout (e.g. amid a table) by not closing open tags of which
 * it is unaware.
 * Actually it is a wrapper for error + terminate.
 *
 * @param where location (physical or logical) where the error was
 * detected: a physical location (routine name/line number) may be
 * helpful for debugging, a logical location (during which part of
 * the processing it happened) will be more helful to the user.
 *
 * @param what a descrition of the abnormality detected.
 */
function letal($what, $where)
{
	error($what, $where);
	set_footer();
    	exit();
}

// ------------- SSH ROUTINES ----------------

/**
 *  Execute a single command remotely using ssh and 
 * return its entire output (like passthru)
 *
 *  This might be done as well using a pipe on /tmp and
 * making the command 'cat' the pipe: when ssh runs, it
 * runs the command 'cat' on the pipe and hangs on read.
 *  Then we just need a thread to open the pipe, put the
 * password and close the pipe.
 *  This other way the password is never wirtten down.
 * But, OTOH, the file life is so ephemeral that most
 * of the time it will only exist in the internal system
 * cache, so this approach is not that bad either.
 *
 *  @param remote   The remote end to run the command, in
 *  	    	    the form 'user@host' (or 'host' if the
 *  	    	    username is the same).
 *  @param password The remote password. Note that if direct
 *  	    	    RSA/DSA/.shosts/.rhosts login is enabled
 *  	    	    then the password should be ignored as
 *  	    	    SSH should not run the ASKPASS command).
 *  @param command  The command to execute on the remote end
 *  	    	    NOTE: if you want to use redirection, the
 *  	    	    entire remote command line should be 
 *  	    	    enclosed in additional quotes!
 *  @param status   Optional, this will hold the termination
 *  	    	    status of SSH after invocation, which
 *  	    	    should be the exit status of the remote
 *  	    	    command or 255 if an error occurred
 *  @return output  The output of the remote command.
 */
function ssh_passthru($remote, $password, $command, $status)
{
	umask(0077);
	$tmpfname = tempnam("/tmp", "egTinker");
	chmod($tmpfname, 0700);
	$fp = fopen($tmpfname, "w");
	fputs($fp, "#!/bin/sh\necho $password\n");
	fputs($fp, "rm -f $tmpfname\n");
	fclose($fp);
	putenv("DISPLAY=none:0.");
	putenv("SSH_ASKPASS=$tmpfname");
	return passthru("ssh -x -t -t $remote $command", $status);
}

// Do a remote scp connection with local password
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
 */
function ssh_copy($origin, $destination, $password)
{
	umask(0077);
	$tmpfname = tempnam("/tmp", "egTinker");
	chmod($tmpfname, 0700);
	$fp = fopen($tmpfname, "w");
	fputs($fp, "#!/bin/sh\necho $password\n");
	fputs($fp, "rm $tmpfname\n");
	fclose($fp);
	putenv("DISPLAY=none:0.");
	putenv("SSH_ASKPASS=$tmpfname");
	system("scp -pqrC $origin $destination", $status);
	if ($status == 0)
	    return TRUE;
	else
	    return FALSE;
}

function ssh_open($remote, $password)
{	
    global $php_version;
    global $debug;

    // Open a child process with the 'proc_open' function. 
    //
    // Some tricks: we must open the connection using '-x' to disable
    // X11 forwarding, and use '-t -t' to avoid SSH generating an error
    // because we are not connected to any terminal.
    // NOTE:
    //   We require users to have an account and password on
    //   the UI and provide their user/password through the web or
    //   otherwise (e.g. using myproxy)
    //
    // NOTE: if the web server is trusted remotely (i.e. it's SSH public 
    // key is accepted in ~user@host:.ssh/authorized_keys) then any 
    // password will do.
    if ($php_version < 5) {
	// Prepare I/O
	$descriptorspec = array(
            0 => array("pipe", "r"),  // connect child's stdin to the read end of a pipe
            1 => array("pipe", "w"),  // connect child's stdout to the write end of a pipe
            2 => array("pipe", "w")   // stderr is a pipe to read from
	);
	// prepare password
	putenv("DISPLAY=none:0.");
	putenv("SSH_ASKPASS=$tmpfname");
	umask(0077);
	$tmpfname = tempnam("/tmp", "egTinker");
	chmod($tmpfname, 0700);
	$fp = fopen($tmpfname, "w");
	fputs($fp, "#!/bin/sh\necho $password\n");
	fputs($fp, "rm $tmpfname\n");
	fclose($fp);

	$process = proc_open("ssh -x -t -t $remote", 
	    		 $descriptorspec,
			 $pipes);
	if ($debug) echo "ssh -x -t -t $remote<br />\n";
	// check status
	if (!is_resource($process)) 
	{
	    letal("SSH::connect", "cannot connect to the remote host");
	    return;
	}
	if ($debug) echo "proc_open<br />\n";

    }
    else { 	/* php5 -- we can use PTYs */
	    /* XXX -- untested -- probably unneeded */
	$descriptorspec = array(
	    0 => array("pty"),
	    1 => array("pty"),
	    2 => array("pty")
	);
	// prepare password
	putenv("DISPLAY=none:0.");
	putenv("SSH_ASKPASS=$tmpfname");
	umask(0077);
	$tmpfname = tempnam("/tmp", "egTinker");
	chmod($tmpfname, 0700);
	$fp = fopen($tmpfname, "w");
	fputs($fp, "#!/bin/sh\necho $password\n");
	fputs($fp, "rm $tmpfname\n");
	fclose($fp);

	$process = proc_open("ssh -x -t -t $remote", 
	    	    	 $descriptorspec,
			 $pipes);

	// check status
	if (!is_resource($process)) 
	{
	    letal("SSH::connect", "cannot connect to the remote host");
	    return;
	}

	$status = proc_get_status($process);
	if ($status->running == FALSE) {
	    fclose($pipes[0]); fclose($pipes[1]); fclose($pipes[2]);
	    proc_close($process);
	    letal("SSH::connect", "connection exited ".$status->exitcode);
	    return;
	}
	if ($status->signaled) {
	    fclose($pipes[0]); fclose($pipes[1]); fclose($pipes[2]);
	    proc_close($process);
	    letal("SSH::connect", "connection terminated by ".$status->termsig);
	    return;
	}
	if ($status->stopped) {
	    // Tell the user and hope for the best
	    warning("SSH::connect stopped by ".$status->stopsig.
	    " it may still have a chance though");
	}

    }

    // $pipes now looks like this:
    //   0 => writeable handle connected to child stdin
    //   1 => readable handle connected to child stdout

    // We now have a connection to the remote Grid User Interface
    // Server which we may use to send commands/receive output
    return array('stdin' => $pipes[0],
    	    	 'stdout' => $pipes[1],
		 'stderr' => $pipes[2] );
}

?>

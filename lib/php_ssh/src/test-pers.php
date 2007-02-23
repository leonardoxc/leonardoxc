<?php

$debug=TRUE;
$remote = "user@example.com";
$password = "password";
$workdir = "/tmp";

// Setup environment
umask(0077);
$tmpfname = tempnam($workdir, 'open-');
chmod($tmpfname, 0700);
if ($debug) echo $tmpfname."\n";

putenv("DISPLAY=none:0.");
putenv("SSH_ASKPASS=$tmpfname");

// make askpass command
$fp = fopen($tmpfname, "w");
fputs($fp, "#!/bin/sh\necho $password\n");
if (! $debug) 
    fputs($fp, "/bin/touch $tmpfname.called\n");
else
     fputs($fp, "/bin/rm -f $tmpfname\n");
fclose($fp);
// go

$child_stdout = tempnam($workdir, "open_sh-O-");
$child_stderr = tempnam($workdir, "open_sh-E-");

$descriptorspec = array(
    0 => array("pipe", "r"),  // connect child's stdin to the read end of a pipe
    1 => array("file", $child_stdout, "a"),  // connect child's stdout to the write end of a pipe
    2 => array("file", $child_stderr, "a")   // stderr is a pipe to read from
);

// Open master
if ($debug) echo "ssh -x -t -t -M -S /tmp/open-sock $remote\n";
$process = proc_open("ssh -x -t -t -M -S /tmp/open-sock $remote", 
	    	 $descriptorspec,
		 $pipes);


fwrite($pipes[0], "\necho Started\n");

do {
	echo "wait\n";
	usleep(100000);	// wait 0.1 seconds
} while (! file_exists("/tmp/open-sock"));

// there we go
	putenv("SSH_ASKPASS=");
	$f = popen("ssh -x -t -t -S /tmp/open-sock $remote ls", "w");
	pclose($f);



// finish
fwrite($pipes[0], "\necho Stopped\n");

// Close master
fwrite($pipes[0], "\nlogout\n");
fclose($pipes[0]);
proc_close($process);

?>

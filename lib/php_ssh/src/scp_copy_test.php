<?php
 
// To test the class from the command line we need a shell with no control
// terminal to avoid SSH from prompting interactively for the password:
// run this with ' ssh -x -T localhost "(cd `pwd` ; php ssh_test.php)" '

// To test on the web, just invoke this script.

$debug_sexec = TRUE;
require_once 'ssh.php';

$remote = "a@a.com";
$password = "pass";

echo "<pre>\n";

$rmt = new SExec($remote, $password);
if ($rmt == FALSE) {
    echo "Couldn't open the connection\n";
    exit;
}

echo "Created\n";

$debug_copy_to = TRUE;
if (isset($debug_copy_to)) {
    echo "\nCopy ldir ./test.txt to rdir $remote:k/.\n";
    $rmt->ssh_copy_to("./test.txt", "k", $out);
}

$rmt->destruct();


echo "</pre>\n\n";
exit;

?>

<?php

exit;
/**
 * SExec test routines
 *
 * @package SExec
 * @author José R. Valverde <jrvalverde@acm.org>
 * @version 1.0
 * @copyright José R. Valverde <jrvalverde@es.embnet.org>
 *
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
 */
 
// To test the class from the command line we need a shell with no control
// terminal to avoid SSH from prompting interactively for the password:
// run this with ' ssh -x -T localhost "(cd `pwd` ; php ssh_test.php)" '

// To test on the web, just invoke this script.

$debug_sexec = TRUE;

require_once 'ssh.php';

#$remote = "jruser@example.com";
#$password = "PASSWORD";

echo "<pre>\n";

$rmt = new SExec($remote, $password);
if ($rmt == FALSE) {
    echo "Couldn't open the connection\n";
    exit;
}

echo "Created\n";

#$debug_passthru = TRUE;
if (isset($debug_passthru)) {
    echo "Using passthru to send ls...\n\n";
    $rmt->ssh_passthru("ls", $status=0);
    echo "\nExit status was $status";
}

#$debug_exec = TRUE;
if (isset($debug_exec)) {
    $rmt->ssh_exec("ls", $out="");
#    $rmt->ssh_exec("ls");
    print_r($out);
    foreach ($out as $line)
    	echo $line . "\n";
}

#$debug_copy_to = TRUE;
if (isset($debug_copy_to)) {
    echo "\nCopy ldir ./CVS to rdir $remote:k/.\n";
    $rmt->ssh_copy_to("./CVS", "k", $out);
    echo "\nCopy lfile ./CVS/Entries to rdir $remote:k/.\n";
    $rmt->ssh_copy_to("./CVS/Entries", "k", $out);
    echo "\nCopy ldir ./CVS to rfile $remote:k/p\n";
    $rmt->ssh_copy_to("./CVS", "k/p", $out);
    echo "\nCopy lfile ./CVS/Entries to rfile $remote:k/p\n";
    $rmt->ssh_copy_to("./CVS/Entries", "k/p", $out);
}

#$debug_copy_from = TRUE;
if (isset($debug_copy_from)) {
    echo "\nCopy rdir ./k/CVS to ldir k/.\n";
    $rmt->ssh_copy_from("./k/CVS", "k", $out);
    echo "\nCopy rfile ./k/CVS/Entries to ldir k/.\n";
    $rmt->ssh_copy_from("./k/CVS/Entries", "k", $out);
    echo "\nCopy rdir ./k/CVS to lfile k/p\n";
    $rmt->ssh_copy_from("./k/CVS", "k/p", $out);
    echo "\nCopy rfile ./k/CVS/Entries to lfile k/p\n";
    $rmt->ssh_copy_from("./k/CVS/Entries", "k/p", $out);
    $rmt->destruct() ; exit;
}

#$debug_persistent_shell = TRUE;
if (isset($debug_persistent_shell))
{
    $p = $rmt->ssh_open_shell();
    
    echo "after open I got this\n";
    print_r($p);

    sleep(1);
    echo "[1] flushing stdout after login\n";
    do {
	$line = fgets($p["std_out"], 1024);
	echo "> ".$line;
    } while ((! feof($p["std_out"]) ) && (! ereg("bossa-nova", $line)));
    $last = ftell($p["std_out"]);

    echo "\n[2]sending hello\n";
    fwrite($p['std_in'], "./hello\n"); fflush($p['std_in']);
    sleep(1); flush();
    fseek($p["std_out"], $last); 
    echo "< ";
    print_r(fgets($p["std_out"], 1024));
    echo "< ";
    print_r(fgets($p["std_out"], 1024));
    echo "\n";
    $last = ftell($p["std_out"]);
    fwrite($p['std_in'], "Oh yes I do\n"); fflush($p['std_in']);
    sleep(2);

    echo "flushing files\n\tstdout\n";
    flush();
    fseek($p["std_out"], $last);
    do {
	$line = fgets($p["std_out"], 1024);
	echo ">> ".$line;
    } while (! feof($p["std_out"]) );
    #    echo "stderr\n";
    #    do {
    #	$line = fgets($p["std_err"], 1024);
    #	echo ">>> ".$line."\n";
    #    } while (! feof($p['std_err']) && (strlen($line) != 0));;

    $rmt->ssh_close($p);
}

#$debug_persistent_cmd = TRUE;
if (isset($debug_persistent_cmd))
{
    $p = $rmt->ssh_open_command("ls");
    
    echo "after open I got this\n";
    print_r($p);

    sleep(1);
    echo "flushing files\nstdout\n";
    flush();
    rewind($p["std_out"]);
    do {
	$line = fgets($p["std_out"], 1024);
	echo "> ".$line;
    } while (! feof($p["std_out"]) );;
    #    echo "stderr\n";
    #    do {
    #	$line = fgets($p["std_err"], 1024);
    #	echo ">> ".$line."\n";
    #    } while (! feof($p['std_err']) && (strlen($line) != 0));;

    $rmt->ssh_close($p);
}

#$debug_popen = TRUE;
if (isset($debug_popen)) {
    $cout = $rmt->ssh_popen("ls -C", "r");
    echo fread($cout, 8192);
    $rmt->ssh_pclose($cout);
    echo "\n";
    /*
    $cin = $rmt->ssh_popen("/usr/sbin/Mail -s test jr", "w");
       fputs($cin, "\nTest");
       fputs($cin, ".\n");
       fputs($cin, "\004");
    $rmt->ssh_pclose($cin);
    */
}

$rmt->destruct();


echo "</pre>\n\n";
exit;

?>

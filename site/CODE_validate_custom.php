<? 
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://leonardo.thenet.gr 											*/
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

$ok=0;

// first upload the igc to the server
$IGCabsPath=$this->getIGCFilename(0); // validate original file
DEBUG("VALIDATE_IGC",1,"Will use igc: $IGCabsPath<BR>");
// make an 8 chars filename
$tmpFilename=sprintf("%08d.igc",rand(0,99999999)); 


// SET these parameters
$remote = "manolis@vali.glidingcontest.org";
$v_olc="manolis";
$v_year="2007";

$cmd="scp -q $IGCabsPath $remote:$tmpFilename";
exec($cmd,$out,$res);

//echo "cmd:$cmd<BR>";
//echo "RES: $res, <BR>";
//print_r($out);

/*
// now the scp code
require_once $CONF_abs_path."/lib/php_ssh/src/ssh.php";
global $debug_sexec;
$debug_sexec=1;
$rmt = new SExec($remote, $password);
if ($rmt == FALSE || $rmt->error ) {
    DEBUG("VALIDATE_IGC",1,"Couldn't open the connection\n");
	return;
}

DEBUG("VALIDATE_IGC",1,"Connection Created");
DEBUG("VALIDATE_IGC",1,"Copy local: $IGCabsPath to remote: $tmpFilename \n");
$rmt->ssh_copy_to($IGCabsPath, $tmpFilename, $out);
$rmt->destruct();

DEBUG("VALIDATE_IGC",1,"Output: $out");
print_r($out);
*/

// done with that , call the url

$fl="http://vali.glidingcontest.org:81/cgi-bin/vali-gps.cgi?get=$tmpFilename&year=$v_year&olc=$v_olc";
DEBUG("VALIDATE_IGC",1,"Will use URL: $fl<BR>");
$contents =	split("\n",fetchURL($fl,30));

$ok=0; // not yet proccessed 
if ($contents) {	
	$ok=-1; // invalid 
	foreach ( $contents as $line) {
		DEBUG("VALIDATE_IGC",1,"valRes: $line<BR>");
		if (substr($line,0,20)=="ValiGPS: IGC file OK") {
			$ok=1; // valid
			break;
		} else if ( strpos($line,"igc file not found") === true ) {
			$ok=0; // not yet processed
			break;
		}
	}
}

?>

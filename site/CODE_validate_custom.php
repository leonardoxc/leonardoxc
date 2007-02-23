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

$ok=-1;

// first upload the igc to the server
$IGCabsPath=$CONF_abs_path."/".$this->getIGCRelPath(0); // validate original file
DEBUG("VALIDATE_IGC",1,"Will use igc: $IGCabsPath<BR>");
// make an 8 chars filename
$tmpFilename=sprintf("%08d.igc",rand(0,99999999)); 

// now the scp code

require_once $CONF_abs_path."/lib/php_ssh/src/ssh.php";

$remote = "leotest@vali.glidingcontest.org";
$password = "o23se7n2p";

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

// done with that , call the url

$fl="http://vali.glidingcontest.org:81/cgi-bin/vali-gps.cgi?get=$tmpFilename&year=2007&olc=holc";
DEBUG("VALIDATE_IGC",1,"Will use URL: $fl<BR>");
$contents =	split("\n",fetchURL($fl,30));

$ok=-1;
if ($contents) {	
	$ok=0;
	foreach ( $contents as $line) {
		DEBUG("VALIDATE_IGC",1,"valRes: $line<BR>");
		if (substr($line,0,20)=="ValiGPS: IGC file OK") {
			$ok=1;
			break;
		}
	}
}

?>
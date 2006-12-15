<? 
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://sourceforge.net/projects/leonardoserver                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

require_once dirname(__FILE__)."/EXT_config_pre.php";
require_once dirname(__FILE__)."/config.php";
require_once dirname(__FILE__)."/EXT_config.php";

require_once dirname(__FILE__)."/CL_flightData.php";
require_once dirname(__FILE__)."/FN_functions.php";	
require_once dirname(__FILE__)."/FN_UTM.php";
require_once dirname(__FILE__)."/FN_waypoint.php";	
require_once dirname(__FILE__)."/FN_output.php";
require_once dirname(__FILE__)."/FN_pilot.php";
require_once dirname(__FILE__)."/FN_flight.php";


/* 
format :

/webform1.aspx?name=georgex&latitude=37.875152&longitude=023.756822&
speed=0&msg=*&clearTrac=no&zoom=.005&crs=51&ver=1.43&alt=52&passwd=gps&Smap=no&wpCall=


The POST is used to send the postions.log file.
This is the file that stores reports if "LOG" in
on, or the PDA is unable to send because of lost
GPRS connection. The POST format is:

"postName=" & MyCall & "&postPword=" & password &
"&postStuff=" & bigStringFromLOGfile

*/

$lat=$_GET['latitude']+0;
$lon=$_GET['longitude']+0;

$alt=$_GET['alt'];
$username=$_GET['name'];
$pass=$_GET['passwd'];
$sog=$_GET['speed'];
$cog=$_GET['crs'];
$time=time();


$ip=$_SERVER['REMOTE_ADDR'];
$port=date("Yz");

// $port=$_SERVER['REMOTE_PORT'];
log_msg("^^^^^^^^^^^^^^^^^^^^^^^^^^^\n");
log_msg(date("y/m/d H:m:s")." ".$ip." \n");
log_msg("POST VARIABLES------------\n");
foreach($_POST as $pname=>$pval) {
	log_msg($pname."=".$pval."\n");
}
log_msg("GET VARIABLES------------\n");
foreach($_GET as $pname=>$pval) {
	log_msg($pname."=".$pval."\n");
}
log_msg("------------------------\n");

if ($lat!=0 || $lon !=0) {
	$query="INSERT INTO leonardo_live_data (ip,port,tm,username,passwd,lat,lon,alt,sog,cog) 
			VALUES ('$ip','$port','$time','$username','$pass','$lat','$lon','$alt','$sog','$cog') ";
	//echo $query;
	//exit;
	
	$res= $db->sql_query($query);
	if($res <= 0){
		echo("<H3> Error in query! $query </H3>\n");
		exit();
	}	
	echo "OK";
} else {
	// echo "Zero coordinates: will not log them";
	echo "OK";
}

function log_msg($somecontent ) {
	$filename=dirname(__FILE__)."/leo_live_track.txt";
	if (!$handle = fopen($filename, 'a')) {
		 echo "Cannot open file ($filename)";
		return 0;	
	}
	if (fwrite($handle, $somecontent) === FALSE) {
		echo "Cannot write to file ($filename)";
		return 0;
	}
	fclose($handle);
	return 1;
}
?>
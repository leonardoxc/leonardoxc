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

//require_once dirname(__FILE__)."/EXT_config_pre.php";
//require_once dirname(__FILE__)."/config.php";
//require_once dirname(__FILE__)."/EXT_config.php";
/*
require_once dirname(__FILE__)."/CL_flightData.php";
require_once dirname(__FILE__)."/FN_functions.php";	
require_once dirname(__FILE__)."/FN_UTM.php";
require_once dirname(__FILE__)."/FN_waypoint.php";	
require_once dirname(__FILE__)."/FN_output.php";
require_once dirname(__FILE__)."/FN_pilot.php";
require_once dirname(__FILE__)."/FN_flight.php";
*/

	define('IN_PHPBB', true);
	$phpbb_root_path = dirname(__FILE__).'/../../';
	//WAS
	// 		$phpbb_root_path = '../../';
	$prefix="phpbb";
	require($phpbb_root_path . 'extension.inc');
	require($phpbb_root_path . 'common.'.$phpEx);

/* 
format :

GET variables:
un=Manolis
pw=man123
cds=$GPGGA,112546.000,4036.1906,N,02257.1042,E,1,06,1.9,101.7,M,36.1,M,,0000*5E


/webform1.aspx?name=georgex&latitude=37.875152&longitude=023.756822&
speed=0&msg=*&clearTrac=no&zoom=.005&crs=51&ver=1.43&alt=52&passwd=gps&Smap=no&wpCall=


The POST is used to send the postions.log file.
This is the file that stores reports if "LOG" in
on, or the PDA is unable to send because of lost
GPRS connection. The POST format is:

"postName=" & MyCall & "&postPword=" & password &
"&postStuff=" & bigStringFromLOGfile

*/
$username=$_GET['un'];
$pass=$_GET['pw'];

$parts=explode(",",$_GET['cds']);
//         0    1           2      3     4      5 6  7  8   9   10  11 12 13  14  15 
// cds=$GPGGA,112546.000,4036.1906,N,02257.1042,E,1,06,1.9,101.7,M,36.1,M,,0000*5E
/*


http://www.gpsinformation.org/dale/nmea.htm#2.3

 $GPGGA,123519,4807.038,N,01131.000,E,1,08,0.9,545.4,M,46.9,M,,*47

Where:
     GGA          Global Positioning System Fix Data
1->  123519       Fix taken at 12:35:19 UTC
2,3->4807.038,N   Latitude 48 deg 07.038' N
4,5->01131.000,E  Longitude 11 deg 31.000' E
6->  1            Fix quality: 0 = invalid
                               1 = GPS fix (SPS)
                               2 = DGPS fix
                               3 = PPS fix
			       4 = Real Time Kinematic
			       5 = Float RTK
                               6 = estimated (dead reckoning) (2.3 feature)
			       7 = Manual input mode
			       8 = Simulation mode
7->  08           Number of satellites being tracked
8->  0.9          Horizontal dilution of position
9,10->545.4,M      Altitude, Meters, above mean sea level
11,12->46.9,M       Height of geoid (mean sea level) above WGS84
                      ellipsoid
13->  (empty field) time in seconds since last DGPS update
14->  (empty field) DGPS station ID number
15->  *47          the checksum data, always begins with *

If the height of geoid is missing then the altitude should be suspect. Some non-standard implementations report altitude with respect to the ellipsoid rather than geoid altitude. Some units do not report negative altitudes at all. This is the only sentence that reports altitude. 
*/

/*
  0      1        2    3      4    5       6  7     8     9    10 11
$GPRMC,122054.000,A,4036.2042,N,02257.1175,E,0.43,266.11,250507,,*06

RMC - NMEA has its own version of essential gps pvt (position, velocity, time) data. It is called RMC, The Recommended Minimum, which will look similar to:

$GPRMC,123519,A,4807.038,N,01131.000,E,022.4,084.4,230394,003.1,W*6A

Where:
0    RMC          Recommended Minimum sentence C
1     123519       Fix taken at 12:35:19 UTC
2     A            Status A=active or V=Void.
3,4   4807.038,N   Latitude 48 deg 07.038' N
5,6   01131.000,E  Longitude 11 deg 31.000' E
7    022.4        Speed over the ground in knots
8     084.4        Track angle in degrees True
9     230394       Date - 23rd of March 1994
10     003.1,W      Magnetic Variation
11     *6A          The checksum data, always begins with *

Note that, as of the 2.3 release of NMEA, there is a new field in the RMC sentence at the end just prior to the checksum. For more information on this field see here. 
*/
header("Date: 11/11/11",1);
header("Server: Apache",1);
header("X-Powered-By:php",1);
// header("aaa: dfdf ");

if ($parts[0]=='$GPGGA') {
	preg_match("/(\d\d)(\d\d)\.(\d+)/",$parts[2],$latParts);
	preg_match("/(\d\d\d)(\d\d)\.(\d+)/",$parts[4],$lonParts);
	// log_msg($parts[2]."=>".$latParts[1]."%".$latParts[2]."%".$latParts[3]."\n");
	
	$lat=abs( $latParts[1])  + $latParts[2]/60 + substr($latParts[3],0,3)/60000 ;
	if ($parts[3]=='S')  $lat=-$lat;
	
	$lon=abs( $lonParts[1])  + $lonParts[2]/60 + substr($lonParts[3],0,3)/60000 ;
	if ($parts[5]=='W')  $lon=-$lon;
			
	$alt=$parts[9];
	
	$sog=-1;
	$cog=-1;
	//$sog=$_GET['speed'];
	//$cog=$_GET['crs'];
	
	$tm=$parts[1];
	
	$time=time(mktime(substr($tm,0,2),substr($tm,2,2),substr($tm,4,2) ));
} 

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

if ($lat!=0 || $lon !=0 || 1) {
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
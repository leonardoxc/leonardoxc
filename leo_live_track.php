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


require_once "EXT_config_pre.php";
require_once "config.php";
require_once "EXT_config.php";

require_once "CL_flightData.php";
require_once "FN_functions.php";	
require_once "FN_UTM.php";
require_once "FN_waypoint.php";	
require_once "FN_output.php";
require_once "FN_pilot.php";
require_once "FN_flight.php";



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

$query="INSERT INTO leonardo_live_data (ip,port,tm,username,passwd,lat,lon,alt,sog,cog) 
		VALUES ('$ip','$port','$time','$username','$pass','$lat','$lon','$alt','$sog','$cog') ";
//echo $query;
//exit;

$res= $db->sql_query($query);
if($res <= 0){
	echo("<H3> Error in query! $query </H3>\n");
	exit();
}


?>
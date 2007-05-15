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
setDEBUGfromGET();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-7">
<style type="text/css">
<!--
body , p, table, td {font-family: Verdana, Arial, Helvetica, sans-serif;	font-size: 9pt;}
h1 {	font-size: 14pt;}
.header1 { background-color:#efefef;}
a:link, a:visited {	text-decoration:underline;	color:#006699;}
a:hover { 	background-color:#FFCC66; }
-->
</style>
<title>Leonardo Live !</title>
</head>
<body>
<h1>Leonardo Live</h1>

<?
$trackURL='http://'.$_SERVER['SERVER_NAME'].'/modules/leonardo/leo_live.php';
?>
<a href="<?='http://'.$_SERVER['SERVER_NAME'].'/modules/leonardo/leo_live_list.php'?>">Επιστροφή</a><BR><BR><?
$op=$_GET['op'];
$taskID=$_GET['taskID']+0;
if (!$taskID) {
	echo "<br><BR>Δεν επιλέγει κανένα task";
	exit;
}

if (!$op) $op="list";
if ($op=="list") {
	echo "<h2>TASK $taskID</h2>";
	echo "<a title='$title' href='$trackURL?taskID=$taskID'>Ζωντανή παρακολούθηση στο Google Earth</a><br><BR>";
	// get all the task waypoints into memory
	$query="SELECT * FROM  leonardo_live_waypoints WHERE taskID=$taskID ORDER BY ID ASC";
	//echo $query;
	$res= $db->sql_query($query);
	if($res <= 0){
		echo("<H3> Error in query! $query </H3>\n");
		exit();
	}
	$waypoints=array();
	$i=0;
	while  ($row = mysql_fetch_assoc($res)) { 
		$waypoints[$i]=new gpsPoint();
		$waypoints[$i]->lat=$row['lat'];
		$waypoints[$i]->lon=$row['lon'];
		$waypoints[$i]->waypointID=$row['ID'];
		$waypoints[$i]->name=$row['name'];
		$waypoints[$i]->wType=$row['wType'];
		$waypoints[$i]->radius=$row['radius'];
		$waypoints[$i]->distanceDiff=$row['distanceDiff'];
		$waypoints[$i]->distanceTotal=$row['distanceTotal'];
		$i++;
	}

	// print_r($waypoints);
	// get only tracks 10 hrs old
	$last_tm_limit=time()-3600*10;

	$query="SELECT username,lat,lon,alt,sog,cog, max(tm) as last_tm FROM  leonardo_live_data WHERE tm > $last_tm_limit GROUP BY username ORDER BY last_tm desc";
	//echo $query;
	$res= $db->sql_query($query);
	if($res <= 0){
		echo("<H3> Error in query! $query </H3>\n");
		exit();
	}
	echo "<table border=1 cellpadding=3>";
	echo "<tr><th>Πιλότος</th><th>Τελευταίο στίγμα</th><th>Τοποθεσιά</th><th>Ύψος</th><th>Ταχύτητα</th><th>Πορεία</th></tr>";
	$j=0;
	while  ($row = mysql_fetch_assoc($res)) { 
		$username =$row["username"];
		getUserInfoShort($username);
	}
	echo "</table>";
} 


function getCogDescr($cog){
	$dirs=array("N","NNE","NE","ENE","E","ESE","SE","SSE","S","SSW","SW","WSW","W","WNW","NW","NNW","N");
	$cog=$cog%360;
	$c=($cog-11.25)/22.5;
	$i=floor($c)+1;
	if ($i<0) $i=0;
	return $dirs[$i];
}

function getUserInfoShort($username) {
	global $waypoints,$db;
	global $trackURL;

	if (count($waypoints)==0) 
			$waypoints=getWaypoints();

	$query="SELECT * FROM  leonardo_live_data
			WHERE username='$username' 
			ORDER BY tm desc LIMIT 1";
	//echo $query;
	$res= $db->sql_query($query);
	if($res <= 0){
		echo("<H3> Error in query! $query </H3>\n");
		return 0;;
	}
	if  ($row = mysql_fetch_assoc($res)) { 
		$ip	  =$row["ip"];
		$time =$row["time"];
		$username =$row["username"];
		$lat =$row["lat"];
		$lon =$row["lon"];
		$alt =$row["alt"];
		$sog =$row["sog"];
		$cog =$row["cog"];
		$tm=$row['tm'];
		
		$last_time=date("d-m-Y H:i:s",$tm);
		$cogStr=getCogDescr($cog);
	
		$thisPoint=new gpsPoint();
		$thisPoint->lat=$lat;
		$thisPoint->lon=-$lon;
		
		// is this user live ?  300 secs -> 5 mins 
		if (time()-$tm <= 300 ) { // last point was within 5 mins
				//$liveStr="This user is LIVE. Click here to LIVE track him/her in Google Earth";
				$live_now="<img src='live/live_now_small.gif' border=0 align=absmiddle> ";
		} else { 
				//$liveStr="This user is not LIVE. Click here to see his/her last known position in Google Earth ";
				$live_now="";
		}

		// find the nearest  waypoint
		$takeoffIDTmp=0;
		$minTakeoffDistance=10000000;
		$i=0;

		foreach($waypoints as $waypoint) {
		   $takeoff_distance = $thisPoint->calcDistance($waypoint);
		   if ( $takeoff_distance < $minTakeoffDistance ) {
				$minTakeoffDistance = $takeoff_distance;
				$takeoffIDTmp=$waypoint->waypointID;
		   }
			$i++;
		}
		$nearestWaypoint=$waypoints[$takeoffIDTmp];

		$title="lat=$lat,lon=$lon";
		$timeStr=substr($time,0,4)."-".substr($time,4,2)."-".substr($time,6,2)." ".
		substr($time,8,2).":".substr($time,10,2).":".substr($time,12,2);
		$XML_str="$time  :: $alt m, $sog km/h, cog:$cog";
		echo "<tr class='header1'>";
		//echo "<td><b><a title='$title' href='$trackURL?user=$username'>$live_now$username</a></b></td>";
		echo "<td><b>$live_now$username</b></td>";
		echo "<td><strong>$last_time</strong></td>";
		echo "<td>".$nearestWaypoint->wType.'-'.$nearestWaypoint->name." [ ~ ".sprintf("%.1f",$minTakeoffDistance/1000)." km] ";
		echo "<td>$alt m</td>";
		echo "<td>$sog km/h</td>";
		echo "<td>$cogStr ($cog&deg;)</td>";
		echo "</tr>";	
	} else {
		echo "No results found";
		return 0;
	}
}
?>
</body>
</html>
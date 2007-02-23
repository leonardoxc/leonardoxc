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
?><head>
<link href="live.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">


<!--
body {
	background-color: #EDF3F1;
}
-->
</style>
<script language="javascript" src="<?=$moduleRelPath?>/js/DHTML_functions.js"></script>
<title>Leonardo Live !</title></head>


<p><img src="live/logo.jpg" width="574" height="94"></p>
<p><b><a href='leo_live_conf.php'>Configure your SymbianOS mobile HERE </a></b></p>
<p><a href="live/guide.html" target="_blank">Inctructions in Greek HERE</a> <BR>
  <BR>
  <a href="leo_live_rss.php"><img src="img/rss.gif" width="31" height="15" border="0" align="absmiddle"> RSS Feed HERE (Copy - Paste
  Link into your RSS Reader)</a></p>
  
  <div id="unknownTakeoffTipLayer" class="shadowBox" style="position: absolute; z-index: 10000; visibility: hidden; left: 0px; top: 0px; width: 10px">&nbsp;</div>


<script language="javascript">
	 function submitWindow(user,port,i) {	 
		MWJ_changeContents('takeoffBoxTitle',"Submit");
		document.getElementById('addTakeoffFrame').src='leo_live_submit.php?user='+user+'&port='+port;		
		MWJ_changeSize('addTakeoffFrame',265,150);
		MWJ_changeSize( 'takeoffAddID', 270,170 );
		toggleVisible('takeoffAddID','pos'+i,20,0,725,455);
	 }
</script>
<style type="text/css">
.dropBox {
	display:block;
	position:absolute;

	top:0px;
	left: -999em;
	width:auto;
	height:auto;
	
	visibility:hidden;

	border-style: solid; 
	border-right-width: 2px; border-bottom-width: 2px; border-top-width: 1px; border-left-width: 1px;
	border-right-color: #999999; border-bottom-color: #999999; border-top-color: #E2E2E2; border-left-color: #E2E2E2;
	border-right-color: #555555; border-bottom-color: #555555; border-top-color: #E2E2E2; border-left-color: #E2E2E2;
	
	background-color:#FFFFFF;
	padding: 1px 1px 1px 1px;
	margin-bottom:0px;
}

.takeoffOptionsDropDown {width:410px; }
</style>

<div id="takeoffAddID" class="dropBox takeoffOptionsDropDown" style="visibility:hidden;">
	<table width="100%" cellpadding="0" cellspacing="0">
	<tr><td class="infoBoxHeader" style="width:725px;" >
	<div align="left" style="display:inline; float:left; clear:left;" id="takeoffBoxTitle"><?=_ADD_WAYPOINT?></div>
	<div align="right" style="display:inline; float:right; clear:right;">
	<a href='#' onclick="toggleVisible('takeoffAddID','takeoffAddPos',14,-20,0,0);return false;"><img src='<? echo $moduleRelPath."/templates/".$PREFS->themeName ?>/img/exit.png' border=0></a></div>
	</td></tr></table>
	<div id='addTakeoffDiv'>
		<iframe name="addTakeoffFrame" id="addTakeoffFrame" width="700" height="320" frameborder=0 style='border-width:0px'></iframe>
	</div>
</div>

<?
$trackURL='http://'.$_SERVER['SERVER_NAME'].'/modules/leonardo/leo_live.php';
$op=$_GET['op'];
if (!$op) $op="list";
if ($op=="list") {

		// get all the waypoints into memory
		if (count($waypoints)==0) 
			$waypoints=getWaypoints();

	$query="SELECT username,lat,lon,alt,sog,cog, max(tm) as last_tm FROM  leonardo_live_data GROUP BY username ORDER BY last_tm desc";
	//echo $query;
	$res= $db->sql_query($query);
	if($res <= 0){
		echo("<H3> Error in query! $query </H3>\n");
		exit();
	}
	echo "<table border=1 cellpadding=3>";
	echo "<tr><th>Username</th><th>Last seen at</th><th>Location</th><th>lat</th><th>lon</th><th>altitude</th><th>speed</th><th>course</th></tr>";
	while  ($row = mysql_fetch_assoc($res)) { 
		$username =$row["username"];
		getUserInfoShort($username);

		// now display all the teracks from this user !!!	
		$query="SELECT *, count(*) as points_num, max(tm) as tm_max, min(tm) as tm_min FROM  leonardo_live_data 
					WHERE username='$username' GROUP BY port ORDER BY tm desc";
		//echo $query;
		$res2= $db->sql_query($query);
		if($res2 <= 0){
			echo("<H3> Error in query! $query </H3>\n");
			exit();
		}
		echo "<tr><td colspan=10 align=right><div align=right>";
	
		echo "<table  cellpadding='4' class='list_tracks'>";
		echo "<tr><th>Date</th><th>Start</th><th>End</th><th># of Points</th><th>Interval</th><th>Duration</th><th>ACTIONS</th></tr>";
		$i=0;
		while  ($row2 = mysql_fetch_assoc($res2)) { 
			$ip	  =$row2["ip"];
			$port=$row2["port"];
			$tm_max=$row2['tm_max'];
			$tm_min=$row2['tm_min'];
			$duration=$tm_max-$tm_min;

			$points_num=$row2['points_num'];
			$interval=floor($duration/$points_num);

			// round up to 5 secs
			$int_5=($interval%10);  //0-0.9
			$int_5_round=round($int_5/10)*10;
			$interval=$interval-$int_5+$int_5_round;

			$d_h=floor($duration/3600);
			$d_m=floor(($duration%3600)/60);
			$d_s=($duration%60);
	
			$d=	sprintf("%02d:%02d:%02d",$d_h,$d_m,$d_s);

			$start_date=date("d-m-Y",$tm_min);	
			$start_time=date("H:i:s",$tm_min);
			$end_time=date("H:i:s",$tm_max);
			$cogStr=getCogDescr($cog);

			if (time()-$tm_max <= 300 && $i==0) { // last point was within 5 mins
				$live_now="<img src='live/live_now.gif' border=0 align=middle><br>";
			} else $live_now="";

			if ($i==3) {
				echo "<tr class='$row'><td colspan=7><div align='right'><a href='javascript:toggleVisibility(\"showMore_$username\")'>See all live tracks of $username</a></div></td></tr>";
				echo "</table><table  align=right cellpadding='4' class='list_tracks all_tracks' id='showMore_$username'>";
			}
			$row="row".(($i%2)+1);
			echo "<tr class='$row'><td>$live_now$start_date</td><td>$start_time</td>
<td>$end_time</td>
<td width='90'><div align=right>$points_num</div></td>
<td width='60'>$interval secs</td><td>$d</td>";
			echo "<td >";
			echo "<a href='$trackURL?op=track&user=$username&port=$port'>Google Earth</a> :: ";
			echo "<a href='$trackURL?op=igc&user=$username&port=$port'>Get IGC</a> :: ";
		// 	if (! $live_now) echo "<a target='_blank' href='$trackURL?op=submit&user=$username&port=$port'>Submit to Leonardo</a>";
			if (! $live_now) echo "<a id='pos$i' href='javascript:submitWindow(\"$username\",$port,$i)'>Submit to Leonardo</a>";
			else echo "wait till landing";
			echo "</td></tr>";
			$i++;
		}
		echo "</table>";
	
		echo "</div></td></tr>";
	
	} // end while 
	
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
				$liveStr="This user is LIVE. Click here to LIVE track him/her in Google Earth";
				$live_now="<img src='live/live_now.gif' border=0 align=middle> ";
		} else { 
				$liveStr="This user is not LIVE. Click here to see his/her last known position in Google Earth ";
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
		$nearestWaypoint=new waypoint($takeoffIDTmp);
		$nearestWaypoint->getFromDB();


		$timeStr=substr($time,0,4)."-".substr($time,4,2)."-".substr($time,6,2)." ".
		substr($time,8,2).":".substr($time,10,2).":".substr($time,12,2);
		$XML_str="$time  :: $alt m, $sog km/h, cog:$cog";
		echo "<tr class='header1'>";
		echo "<td><b>$username</b></td>";
		echo "<td><strong>$last_time</strong></td>";
		echo "<td>".$nearestWaypoint->intName." - ".$nearestWaypoint->countryCode." [ ~ ".sprintf("%.1f",$minTakeoffDistance/1000)." km] ";
		echo "<td>$lat</td>";
		echo "<td>$lon</td>";
		echo "<td>$alt m</td>";
		echo "<td>$sog km/h</td>";
		echo "<td>$cogStr ($cog&deg;)</td>";
		echo "</tr>";	

		echo "<tr class='header2'><td colspan='8'><a title='$liveStr' href='$trackURL?user=$username'>$live_now$liveStr</a></td></tr>";
	} else {
		echo "No results found";
		return 0;
	}
}
?>
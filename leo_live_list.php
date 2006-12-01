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
</style><title>Leonardo Live !</title></head>


<p><img src="live/logo.jpg" width="574" height="94"></p>
<p><b><a href='leo_live_conf.php'>Configure your SymbianOS mobile HERE </a></b></p>
<p><a href="live/guide.html" target="_blank">Inctructions in Greek HERE</a> <BR>
  <BR>
  <a href="leo_live_rss.php"><img src="img/rss.gif" width="31" height="15" border="0" align="absmiddle"> RSS Feed HERE (Copy - Paste
  Link into your RSS Reader)</a></p>
<?
$trackURL='http://'.$_SERVER['SERVER_NAME'].'/modules/leonardo/leo_live.php';
$op=$_GET['op'];
if (!$op) $op="list";
if ($op=="list") {
	$query="SELECT username,lat,lon,alt,sog,cog, max(tm) as last_tm FROM  leonardo_live_data GROUP BY username ORDER BY last_tm desc";
	//echo $query;
	$res= $db->sql_query($query);
	if($res <= 0){
		echo("<H3> Error in query! $query </H3>\n");
		exit();
	}
	echo "<table border=1 cellpadding=3>";
	echo "<tr><th>Username</th><th>Last seen at</th><th>lat</th><th>lon</th><th>altitude</th><th>speed</th><th>course</th></tr>";
	while  ($row = mysql_fetch_assoc($res)) { 
		$ip	  =$row["ip"];
		$time =$row["time"];
		$username =$row["username"];
		$lat =$row["lat"];
		$lon =$row["lon"];
		$alt =$row["alt"];
		$sog =$row["sog"];
		$cog =$row["cog"];
		$tm=$row['last_tm'];
		
		$last_time=date("d-m-Y H:i:s",$tm);
		$cogStr=getCogDescr($cog);
	
		$thisPoint=new gpsPoint();
		$thisPoint->lat=$lat;
		$thisPoint->lon=$lon;
		
		$timeStr=substr($time,0,4)."-".substr($time,4,2)."-".substr($time,6,2)." ".
		substr($time,8,2).":".substr($time,10,2).":".substr($time,12,2);
		$XML_str="$time  :: $alt m, $sog km/h, cog:$cog";
		echo "<tr class='header1'>";
		echo "<td><b>$username</b></td>";
		echo "<td><a title='Click here to LIVE track this user' href='$trackURL?user=$username'>$last_time</a></td>";
		echo "<td>$lat</td>";
		echo "<td>$lon</td>";
		echo "<td>$alt m</td>";
		echo "<td>$sog km/h</td>";
		echo "<td>$cogStr ($cog&deg;)</td>";
		echo "</tr>";	
	
		// now display all the teracks from this user !!!	
		$query="SELECT *, count(*) as points_num, max(tm) as tm_max, min(tm) as tm_min FROM  leonardo_live_data 
					WHERE username='$username' GROUP BY port ORDER BY tm desc";
		//echo $query;
		$res2= $db->sql_query($query);
		if($res2 <= 0){
			echo("<H3> Error in query! $query </H3>\n");
			exit();
		}
		echo "<tr><td>&nbsp;</td><td colspan=8>";
	
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
				$live_now="<img src='live/live_now.gif' border=0 align=middle>";
			} else $live_now="";

			$row="row".(($i%2)+1);
			echo "<tr class='$row'><td>$live_now$start_date</td><td>$start_time</td><td>$end_time</td><td><div align=right>$points_num</div></td><td>$interval secs</td><td>$d</td>";
			echo "<td>";
			echo "<a href='$trackURL?op=track&user=$username&port=$port'>Google Earth</a> :: ";
			echo "<a href='$trackURL?op=igc&user=$username&port=$port'>Get IGC</a>";
			echo "</td></tr>";
			$i++;
		}
		echo "</table>";
	
		echo "</td></tr>";
	
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

?>
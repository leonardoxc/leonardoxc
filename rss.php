<?
//************************************************************************
// Leonardo XC Server, http://leonardo.thenet.gr
//
// Copyright (c) 2004-8 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: rss.php,v 1.16 2008/12/12 05:27:26 gus Exp $                                                                 
//
//************************************************************************
	
 	require_once dirname(__FILE__)."/EXT_config_pre.php";
	require_once "config.php";
 	require_once "EXT_config.php";

	require_once "CL_flightData.php";
	require_once "FN_functions.php";	
	require_once "FN_UTM.php";
	require_once "FN_waypoint.php";	
	require_once "FN_output.php";
	require_once "FN_pilot.php";
	setDEBUGfromGET();

	setVarFromRequest("lng",$PREFS->language); 

	$count = ( isset($HTTP_GET_VARS['c']) ) ? intval($HTTP_GET_VARS['c']) : 15;
	$count = ( $count == 0 ) ? 15 : $count;
	$count = ( $count > 50 ) ? 50 : $count;

	// GUS begin
	$category = ( isset($HTTP_GET_VARS['cat']) ) ? intval($HTTP_GET_VARS['cat']) : 0;
	// GUS end

	$countryCode = ( isset($HTTP_GET_VARS['country']) ) ? substr($HTTP_GET_VARS['country'],0,2) : "";
	$minOLCscore = ( isset($HTTP_GET_VARS['olcScore']) ) ? intval($HTTP_GET_VARS['olcScore']) : 0;
	$maxOLCscore = ( isset($HTTP_GET_VARS['olcMaxScore']) ) ? intval($HTTP_GET_VARS['olcMaxScore']) : 0; // GUS in

	$op=makeSane($_REQUEST['op']);
	if (!$op) $op="latest";	


	if (!in_array($op,array("latest")) ) return;

	// $encoding="iso-8859-1";
	
	$encoding=$langEncodings[$lng];
$encoding="utf-8";

	//require_once dirname(__FILE__)."/lib/ConvertCharset/ConvertCharset.class.php";

	if ($op=="latest") {
		 $where_clause="";
  		 $extra_tbl= "";
		 if ($countryCode) { 
			$where_clause.=" AND countryCode='".$countryCode."' AND $flightsTable.takeoffID=$waypointsTable.ID ";
			$extra_tbl= ", $waypointsTable";
		 }
		 if ($minOLCscore) { 
			$where_clause.=" AND FLIGHT_POINTS>=".$minOLCscore." ";
		 }
		 // GUS begin
		 if ($maxOLCscore) { 
			$where_clause.=" AND FLIGHT_POINTS<=".$maxOLCscore." ";
		 }

		if ($category) { 
			$where_clause.=" AND ( $flightsTable.cat & $category ) "; // bitwise AND category bits
		 }
		 // GUS end

		 $query="SELECT * , $flightsTable.Id as flightID FROM $flightsTable $extra_tbl WHERE  private=0 $where_clause ORDER BY dateAdded DESC LIMIT $count ";
		// echo $query;
		 $res= $db->sql_query($query);
		 if($res <= 0){
			 echo("<H3> Error in query! </H3>\n");
			 exit();
		 }
$RSS_str="<?xml version=\"1.0\" encoding=\"$encoding\" ?>
<rss version=\"0.92\">
<channel>
	<docs>http://leonardo.thenet.gr</docs>
	<title>Leonardo at ".$_SERVER['SERVER_NAME']." :: Latest flights</title>
	<link>http://".$_SERVER['SERVER_NAME'].getLeonardoLink(array('op'=>'list_flights'))."</link>
	<language>el</language>
	<description>Leonardo at ".$_SERVER['SERVER_NAME']." :: Latest flights</description>
	<managingEditor>".$CONF_admin_email."</managingEditor>
	<webMaster>".$CONF_admin_email."</webMaster>
	<lastBuildDate>". gmdate('D, d M Y H:i:s', time()) . " GMT</lastBuildDate>
<!-- BEGIN post_item -->
";

		while ($row = mysql_fetch_assoc($res)) { 
			 $nearestWaypoint=new waypoint($takeoffIDTmp);
			 $nearestWaypoint->getFromDB();


     $name=getPilotRealName($row["userID"],$row["userServerID"],0,2);
  //$name="33";
	 $takeoffName=getWaypointName($row["takeoffID"]);
	 $takeoffVinicity=$row["takeoffVinicity"];
	 $duration=sec2Time($row['DURATION'],1);

	$linKM=formatDistance($row["LINEAR_DISTANCE"],true);
	$openKM=formatDistance($row["FLIGHT_KM"],true);
	$score=formatOLCScore($row["FLIGHT_POINTS"],false);

//			$title="OLCscore: $score :: Pilot: $name :: takeoff: $takeoffName :: duration: $duration :: open distance: $linKM";
			$title="$score pts :: Open $linKM - OLC ".formatDistance($row['FLIGHT_KM']). " km :: T/off: $takeoffName";
			$title=str_replace("&nbsp;"," ",$title);

			// MANOLIS new way of writing URLS
			$link=htmlspecialchars ("http://".$_SERVER['SERVER_NAME'].
			getLeonardoLink(array('op'=>'show_flight','flightID'=>$row['flightID'])) );


		if ($row['takeoffVinicity'] > $takeoffRadious ) 
			$location=getWaypointName($row['takeoffID'])." [~".sprintf("%.1f",$row['takeoffVinicity']/1000)." km]"; 
		else $location=getWaypointName($row['takeoffID']);

		if ($row['landingVinicity'] > $landingRadious ) 
			$location_land=getWaypointName($row['landingID'])." [~".sprintf("%.1f",$row['landingVinicity']/1000)." km]"; 
		else $location_land=getWaypointName($row['landingID']);

$desc="Pilot:  $name".
"<br>Glider: ".$row['glider'].
"<br>Date - Time:    ".formatDate($row['DATE'],false)." - ".sec2Time($row['START_TIME'],1). 
"<br>Takeoff: $location".
"<br>Landing: ".$location_land.
"<br>&nbsp;<br>Straight Distance: ".formatDistance($row['LINEAR_DISTANCE']).
" km<br>Duration: ".sec2Time($row['DURATION'],1).
" (hh:mm)<br>Flight Type: ".formatOLCScoreType($row['BEST_FLIGHT_TYPE'],false).
"<br>OLC Km: ".formatDistance($row['FLIGHT_KM']).
" km<br>OLC score: ".sprintf("%.1f",$row['FLIGHT_POINTS']).
"<br>&nbsp;<br>Max speed: ".sprintf("%.2f km/h",$row['MAX_SPEED']).
"<br>Max vario: ".sprintf("%.1f m/sec",$row['MAX_VARIO']).
"<br>Min vario: ".sprintf("%.1f m/sec",$row['MIN_VARIO']).
"<br>Max Alt ASL: ".$row['MAX_ALT'].
" m<br>Min Alt ASL: ".$row['MIN_ALT'].
" m<br>Takeoff alt: ".$row['TAKEOFF_ALT'];
if ( $row['comments'] ) $desc.=" m<br>&nbsp;<br>Comments: ".$row['comments'];

//           1111111111
// 01234567890123456789    
// 0000-00-00 00:00:00
/*
$date = $row['dateAdded'];
$gyear  = substr($date,0,4);
$gmonth = substr($date,5,2);
$gday   = substr($date,8,2);
$ghour  = substr($date,11,2);
$gmin   = substr($date,14,2);
$gsec   = substr($date,17,2);
$utime = mktime($ghour,$gmin,$gsec,$gmonth,$gday,$gyear);
*/

$date = $row['DATE'];
$gyear  = substr($date,0,4);
$gmonth = substr($date,5,2);
$gday   = substr($date,8,2);

$date = $row['START_TIME'];
$ghour  = $date/3600;
$gmin   = ($date%3600)/60;
$gsec   = $date%60;
$utime = mktime($ghour,$gmin,$gsec,$gmonth,$gday,$gyear);

//
$desc=htmlspecialchars ($desc);
$desc=str_replace("&nbsp;"," ",$desc);

			$RSS_str.="<item>
<title>$title</title>
<guid isPermaLink=\"false\">".$row['flightID']."</guid>
<category>".formatOLCScoreType($row['BEST_FLIGHT_TYPE'],false)."</category>
<author>$name</author>
<pubDate>" . gmdate('D, d M Y H:i:s', $utime) . " GMT</pubDate>
<link>$link</link>
<description>

$desc 

</description>
</item>
";
		}

		$RSS_str.="<!-- END post_item -->
		</channel>
		</rss>
		";

		//$NewEncoding = new ConvertCharset;
		//$FromCharset=$langEncodings[$currentlang];
		//$RSS_str = $NewEncoding->Convert($RSS_str, $FromCharset, "utf-8", $Entities);


		if (!empty($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Apache/2'))
		{
			header ('Cache-Control: no-cache, pre-check=0, post-check=0, max-age=0');
		}
		else
		{
			header ('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
		}
		header ('Expires: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
		header ('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header ('Content-Type: text/xml');
		echo $RSS_str;
	}

?>
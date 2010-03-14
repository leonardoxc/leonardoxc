<?
//************************************************************************
// Leonardo XC Server, http://www.leonardoxc.net
//
// Copyright (c) 2004-2010 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: rss.php,v 1.19 2010/03/14 20:56:12 manolis Exp $                                                                 
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
	require_once dirname(__FILE__).'/CL_filter.php';
	setDEBUGfromGET();

	setVarFromRequest("lng",$PREFS->language); 

	$count = ( isset($_GET['c']) ) ? intval($_GET['c']) : 15;
	$count = ( $count == 0 ) ? 15 : $count;
	$count = ( $count > 50 ) ? 50 : $count;

	// GUS begin
	$category = ( isset($_GET['cat']) ) ? intval($_GET['cat']) : 0;
	
	if ( isset($_GET['takeOffs']) )
	{
		if ( $_GET['debug'] ) echo $_GET['takeOffs']."<br>";
		$takeOffs = mysql_real_escape_string(urldecode($_GET['takeOffs']));
		$takeOffs = myImplode("'", "'", ",", explode(",",$takeOffs));	
	}
	else
	{
		$takeOffs = '';
	}
	
	$box_min_lat = ( isset($_GET['min_lat']) ) ? floatval($_GET['min_lat']) : 0;
	$box_max_lat = ( isset($_GET['max_lat']) ) ? floatval($_GET['max_lat']) : 0;
	$box_min_lon = ( isset($_GET['min_lon']) ) ? floatval($_GET['min_lon']) : 0;
	$box_max_lon = ( isset($_GET['max_lon']) ) ? floatval($_GET['max_lon']) : 0;
	
	if ( $_GET['debug'] )
	{
		echo "$box_min_lat<br>$box_max_lat<br>$box_min_lon<br>$box_max_lon<br>";
	}
	
	// GUS end

	$countryCode = ( isset($_GET['country']) ) ? mysql_real_escape_string(substr($_GET['country'],0,2)) : "";
	$minOLCscore = ( isset($_GET['olcScore']) ) ? intval($_GET['olcScore']) : 0;
	$maxOLCscore = ( isset($_GET['olcMaxScore']) ) ? intval($_GET['olcMaxScore']) : 0; // GUS in

	$op=makeSane($_REQUEST['op']);
	if (!$op) $op="latest";	


	if (!in_array($op,array("latest")) ) return;

	// $encoding="iso-8859-1";
	
	$encoding=$langEncodings[$lng];
$encoding="utf-8";

$server_path = "http://".$_SERVER['SERVER_NAME'].$flightsWebPath;
$url_root = "http://".$_SERVER['SERVER_NAME'].$moduleRelPath;
$enclosure_gus = '<enclosure url="http://www.paraglidingforum.com/images/icon_clip.gif" length="71" type="image/gif"/>';

// MANOLIS
// all paths are now defined in $CONF['paths'] in config.php
$local_dir = $CONF['paths']['map_thumbs'];
$thumbsDirAbs=LEONARDO_ABS_PATH.'/'.$local_dir;
// $local_dir = "tmp_map_thumbs";
if (! is_dir($thumbsDirAbs) ) {
	// MANOLIS use the makeDir function of leonardo, it creates all parent dirs if they dont exist!
	makeDir($thumbsDirAbs);
	@chmod($thumbsDirAbs,0777);
}  

	//require_once dirname(__FILE__)."/lib/ConvertCharset/ConvertCharset.class.php";

	if ($op=="latest") {
		$where_clause="";
  		$extra_tbl= "";
		if ( $countryCode || $takeOffs || ( !empty($box_min_lat) && !empty($box_max_lat) && !empty($box_min_lon) && !empty($box_max_lon) ) )
		{ 
			if ( $countryCode ) $where_clause.=" AND countryCode='$countryCode' ";
			
			if ( $takeOffs) 	$where_clause.=" AND ( $waypointsTable.intName IN ($takeOffs) OR $waypointsTable.name IN ($takeOffs) OR $waypointsTable.intLocation IN ($takeOffs) OR $waypointsTable.Location IN ($takeOffs) ) ";
			
			if ( !empty($box_min_lat) && !empty($box_max_lat) && !empty($box_min_lon) && !empty($box_max_lon) )
								$where_clause.=" AND ( $waypointsTable.lat BETWEEN $box_min_lat AND $box_max_lat AND $waypointsTable.lon BETWEEN $box_min_lon AND $box_max_lon ) ";
								
			$extra_tbl= " LEFT JOIN $waypointsTable ON $flightsTable.takeoffID=$waypointsTable.ID ";
		}
		if ($minOLCscore) { 
			$where_clause.=" AND FLIGHT_POINTS>=$minOLCscore ";
		}
		// GUS begin
		if ($maxOLCscore) { 
			$where_clause.=" AND FLIGHT_POINTS<=$maxOLCscore ";
		}

		if ($category) { 
			$where_clause.=" AND ( $flightsTable.cat & $category ) "; // bitwise AND category bits
		}
		 // GUS end

		// now the filter!!!
		$fltr=$_SESSION['fltr'];
		if ($fltr) {
			$filter=new LeonardoFilter();
			$filter->parseFilterString($fltr);
			// echo "<PRE>";	print_r($filter->filterArray);	echo "</PRE>";	
			$filter_clause=$filter->makeClause();
			// echo $filter_clause;
					
			if ( ! strpos($filter_clause,$waypointsTable)=== false )  {
				$extra_tbl= " LEFT JOIN $waypointsTable ON $flightsTable.takeoffID=$waypointsTable.ID "; 
			}
			
			if ( ! strpos($filter_clause,$pilotsTable)=== false ) {
				$extra_tbl.= " LEFT JOIN $pilotsTable ON 
						($flightsTable.userID=$pilotsTable.pilotID AND 
						$flightsTable.userServerID=$pilotsTable.serverID) "; 
			}
	
			$where_clause=$filter_clause;
			
		}
		
			
		
		$query="SELECT * , $flightsTable.Id as flightID 
		 		FROM $flightsTable $extra_tbl 
				WHERE private=0 $where_clause 
				ORDER BY dateAdded DESC LIMIT $count";
		// echo $query;
		$res= $db->sql_query($query);
		if ( $_GET['debug'] ) exit($query);
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


	$userFullID = ($row["userServerID"]+0) ? $row['userServerID'] . "_" . $row['userID'] : $row['userID']; 

    $name=getPilotRealName($row["userID"],$row["userServerID"],0,2);
 	$name = str_replace(")","",$name);
 	$name = str_replace(" (","",$name);

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

$star="=";
$linear_stars = str_repeat($star,intval( $row['LINEAR_DISTANCE'] / 20000 ) );
$hour_stars = str_repeat($star,intval( $row['DURATION'] / 3600 ) );
$score_stars = str_repeat($star,intval( $row['FLIGHT_POINTS'] / 50 ) );
$olc_km_stars = str_repeat($star,intval( $row['FLIGHT_KM'] / 20000 ) );
$min_alt_stars = str_repeat($star,intval( $row['MIN_ALT'] / 500 ) );
$max_alt_stars = str_repeat($star,intval( $row['MAX_ALT'] / 500 ) );
$takeoff_stars = str_repeat($star,intval( $row['TAKEOFF_ALT'] / 500 ) );
$speed_stars = str_repeat($star,intval( $row['MAX_SPEED'] / 20 ) );

$desc="<font size=\"+1\">Pilot:  <b><font color=\"#ff0000\">$name</font></b></font>".
"<br>Glider: <b>".$row['glider'].
"</b><br><font color=\"#aa6600\">Date - Time: <b>".formatDate($row['DATE'],false)." - ".sec2Time($row['START_TIME'],1). 
"</b></font><br><font color=\"#00aa00\">Takeoff: <b>$location</b></font>".
"<br><font color=#006600>Landing: <b>".$location_land.

"</b></font><br>&nbsp;<br><font color=\"#ff0000\">Straight Distance: <b>".formatDistance($row['LINEAR_DISTANCE'])." km</b> $linear_stars</font>".
"<br><font color=\"#aa0000\">OLC Km: <b>".formatDistance($row['FLIGHT_KM'])." km $olc_km_stars</b></font>".
"<br><font color=\"#0000ff\">OLC score: <b>".sprintf("%.1f",$row['FLIGHT_POINTS'])."</b> $score_stars</font>".
"<br>Flight Type: <b>".formatOLCScoreType($row['BEST_FLIGHT_TYPE'],false)."</b>".

"<br><br>Duration: <b>".sprintf("%d hrs %d min",$row['DURATION']/3600,($row['DURATION']%3600)/60)."</b> $hour_stars".

"<br>&nbsp;<br><font color=\"#000000\">Max speed: <b>".sprintf("%.2f km/h",$row['MAX_SPEED']).
"</b> $speed_stars</font><br><font color=\"#006600\">Max vario: <b>+".sprintf("%.1f m/sec",$row['MAX_VARIO']).
"</b></font><br><font color=\"#aa0000\">Min vario: <b>".sprintf("%.1f m/sec",$row['MIN_VARIO'])."</b></font>".

"<br><font color=\"#006600\">Max Alt ASL: <b>".$row['MAX_ALT'].
" m </b>$max_alt_stars</font><br><font color=\"#aa0000\">Min Alt ASL: <b>".$row['MIN_ALT'].
" m </b>$min_alt_stars</font><br>Takeoff alt: <b>".$row['TAKEOFF_ALT']." m </b>$takeoff_stars";
if ( $row['comments'] ) 
{
	$row['comments'] = trim($row['comments']," \n\r");
	$row['comments'] = str_replace("  "," ",$row['comments']);
	$row['comments'] = str_replace(" />",">",$row['comments']);
	$row['comments'] = str_replace("/leonardo/js/fckeditor/","$url_root/js/fckeditor/",$row['comments']);
	
	$desc.='<br>&nbsp;<br>Comments: <font color="#000088"><i>"'.$row['comments'].'"</i> - '.$name.'</font>';
}

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




$desc .="<br><br>";

// $filename = str_replace(" ","kkenoo",$row['filename']);
$filename = urldecode($row['filename']);
/*
$originalURL = $row['originalURL'];
if ( ( $row['userServerID'] != 0 ) && ( ! $row['originalURL']) )
{
	if ( $CONF['servers']['list'][$row['userServerID']]['isLeo'] ==1  )
	{
	 	if (! $row['originalURL'] )
		{
			$originalURL='http://'.$CONF['servers']['list'][$row['userServerID']]['url'].
							'&op=show_flight&flightID='.$row['original_ID'];
		}
	}
}

*/

// MANOLIS official way to get the url of flight map
$localMapFull="http://".$_SERVER['SERVER_NAME'].$moduleRelPath.'/'.
			str_replace("%PILOTID%",$userFullID,str_replace("%YEAR%",$gyear,$CONF['paths']['map']) ).'/'.
			rawurlencode($filename).".jpg";				
// $localMapFull =  $server_path."/$userFullID/maps/$gyear/$filename.jpg";

// MANOLIS official way to get the absolute filename of flight map		
$localMap = LEONARDO_ABS_PATH.'/'.str_replace("%PILOTID%",$userFullID,str_replace("%YEAR%",$gyear,$CONF['paths']['map']) ).'/'.
			$filename.".jpg";			
// $localMap = "flights/$userFullID/maps/$gyear/$filename.jpg";

$localMapThumb = "$local_dir/thumb_$userFullID$gyear".str_replace(" ","_",$filename).".jpg";
$localMapThumbAbs= LEONARDO_ABS_PATH."/$local_dir/thumb_$userFullID$gyear".str_replace(" ","_",$filename).".jpg";

// MANOLIS START
if ( !file_exists($localMapThumbAbs) ) {
	makeSmallMapThumb($localMap,$localMapThumbAbs,300); 
}
$imageMap = "<a href=\"$localMapFull\"><img src=\"$url_root/$localMapThumb\"></a>";	
// MANOLIS END

/*
if ( ( $row['externalFlightType'] == 1 ) && ($CONF['servers']['list'][$row['userServerID']]['isLeo'] ==1) )
{
	$localMap = substr($originalURL,0,strpos($originalURL,"leonardo.php"))."modules/leonardo/".$row['userID']."/flights/maps/$gyear/$filename.jpg";
}
*/


if ( !file_exists($localMap) )
{
	$desc .=  "Map not created yet or no access.";
	$enclosure = "";
} else {
	$enclosure = $enclosure_gus;
	$desc .=  $imageMap;	
}

// MANOLIS official way to get the download link
$langArray=array("lng">=$currentlang);
$kmlLink="http://".$_SERVER['SERVER_NAME'].getDownloadLink(array('type'=>'kml_trk','flightID'=>$row['flightID'])+$langArray) ;
$desc .= "<br><a href='$kmlLink'>See flight in Google Earth</a><br>";
		
//$desc .= "<br><a href=\"$url_root/flight/".$row['flightID']."/kml/&lang=english&w=2&c=FFFFFF&an=1\">See flight in Google Earth</a><br>";

//
//$desc=htmlspecialchars ($desc);
//$desc=htmlentities( $desc , ENT_QUOTES );
$desc=str_replace("&nbsp;"," ",$desc);
//$desc=str_replace("kkenoo"," ",$desc);


			$RSS_str.="<item>
<title><![CDATA[$title]]></title>
<guid isPermaLink=\"false\">".$row['flightID']."</guid>
<category>".formatOLCScoreType($row['BEST_FLIGHT_TYPE'],false)."</category>
<author><![CDATA[$name]]></author>
<pubDate>" . gmdate('D, d M Y H:i:s', $utime) . " GMT</pubDate>
<link>$link</link>$enclosure
<description><![CDATA[<p>$desc</p>]]></description>
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


// MANOLIS START
function makeSmallMapThumb($sourceFile,$destFile,$width){
	if (!is_file($sourceFile)) return; 
	
	$t = ini_set('max_execution_time','300');
	$temp = imagecreatefromjpeg($sourceFile);
	$t = @ini_set('max_execution_time',$t);
	// header("Content-Type: image/jpeg");
	$height = imagesy($temp) * $width / imagesx($temp);
	$new = imagecreatetruecolor($width, $height);
	@imagecopyresampled($new, $temp, 0, 0, 0, 0, $width, $height, imagesx($temp), imagesy($temp) );
	@imagejpeg($new, $destFile, 80);
	//imagejpeg($new, NULL, 80);
}
// MANOLIS END

function myImplode($before, $after, $glue, $array){
    $nbItem = count($array);
    $i = 1;
    foreach($array as $item){
        if($i < $nbItem){
            $output .= "$before".mysql_real_escape_string($item)."$after$glue";
        }else $output .= "$before".mysql_real_escape_string($item)."$after";
        $i++;
    }
    return $output;
}


?>
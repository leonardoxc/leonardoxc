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
// $Id: GUI_EXT_flight_info.php,v 1.10 2008/11/29 22:46:07 manolis Exp $                                                                 
//
//************************************************************************

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
	require_once dirname(__FILE__)."/templates/".$PREFS->themeName."/theme.php";
	setDEBUGfromGET();
	require_once dirname(__FILE__)."/language/".CONF_LANG_ENCODING_TYPE."/lang-".$currentlang.".php";
	require_once dirname(__FILE__)."/language/".CONF_LANG_ENCODING_TYPE."/countries-".$currentlang.".php";


	$op=makeSane($_GET['op'],0);
	if (!$op) $op='sql';
	
	$flightID=makeSane($_GET['flightID'],1);
	if ($flightID<=0) exit;
		
if ($op=='photos'){
	$flight=new flight();
	$flight->getFlightFromDB($flightID);

	if ($flight->hasPhotos) {
		require_once dirname(__FILE__)."/CL_flightPhotos.php";
	
		$flightPhotos=new flightPhotos($flight->flightID);
		$flightPhotos->getFromDB();
			
		foreach ( $flightPhotos->photos as $photoNum=>$photoInfo) {
			
			if ($photoInfo['name']) {
				$imgIconRel=$flightPhotos->getPhotoRelPath($photoNum).".icon.jpg";
				$imgStr="<img src='$imgIconRel'  class=\"photos\" border=\"0\">";		
				echo "<a class='shadowBox imgBox' href='$imgBigRel' target=_blank>$imgStr</a>";		
			}		
		}
	}

} else if ($op=='comments'){
		$flight=new flight();
		$flight->getFlightFromDB($flightID);
//		echo "<table class='short_info' cellpadding='0' cellspacing='0' width='100%'>";
//		echo '<tr><td>'.$flight->comments.'</td></tr></table>';

		echo "<span class='short_info'>".$flight->comments.'</span>';
		
} else if ($op=='info_short'){
		$flight=new flight();
		$flight->getFlightFromDB($flightID);

	if ($CONF_use_utf) {		
		$CONF_ENCODING='utf-8';
	} else  {		
		$CONF_ENCODING=$langEncodings[$currentlang];
	}

	header('Content-type: application/text; charset="'.$CONF_ENCODING.'"',true);

//  echo "<pre class='short_info'>";
  echo "<table class='short_info' cellpadding='0' cellspacing='0' width='100%'>";
	echo "<TR><TD width=160>"._DATE_SORT."</td><td>". formatDate($flight->DATE)."<td></tr>\n";

	$gliderBrandImg=brands::getBrandText($flight->gliderBrandID,$flight->glider,$flight->cat);
	echo "<TR><TD>"._GLIDER."</td><td>"."<img src='".moduleRelPath()."/img/icon_cat_".$flight->cat.".png' align='absmiddle'> ".				$gliderBrandImg."<td></tr>\n";

 
	$flightHours=$flight->DURATION/3600;
	if ($flightHours) {
		$openDistanceSpeed=formatSpeed($flight->LINEAR_DISTANCE/($flightHours*1000));
		$maxDistanceSpeed=formatSpeed($flight->MAX_LINEAR_DISTANCE/($flightHours*1000));
		$olcDistanceSpeed=formatSpeed($flight->FLIGHT_KM/($flightHours*1000));
	} else {
		$openDistanceSpeed=0;
		$maxDistanceSpeed=0;
		$olcDistanceSpeed=0;	
	}
	
if ( $scoringServerActive ) {
		$olcScoreType=$flight->BEST_FLIGHT_TYPE;
		if ($olcScoreType=="FREE_FLIGHT") {
			$olcScoreTypeImg="icon_turnpoints.gif";
		} else if ($olcScoreType=="FREE_TRIANGLE") {
			$olcScoreTypeImg="icon_triangle_free.gif";
		} else if ($olcScoreType=="FAI_TRIANGLE") {
			$olcScoreTypeImg="icon_triangle_fai.gif";
		} else { 
			$olcScoreTypeImg="photo_icon_blank.gif";
		}

	echo "<TR class='hr'><TD>"._OLC_SCORE_TYPE."</td><td>".formatOLCScoreType($flight->BEST_FLIGHT_TYPE)." <img src='".moduleRelPath()."/img/$olcScoreTypeImg' align='absmiddle'>\n";
	echo "<TR><TD>"._OLC_DISTANCE."</td><td>".formatDistanceOpen($flight->FLIGHT_KM)." ($olcDistanceSpeed)\n";
	echo "<TR><TD>"._OLC_SCORING."</td><td>".formatOLCScore($flight->FLIGHT_POINTS)."<td></tr>\n";
	echo "<TR class='hr'><TD>"._OPEN_DISTANCE."</td><td>".formatDistanceOpen($flight->LINEAR_DISTANCE)." ($openDistanceSpeed)"."<td></tr>\n";		
	echo "<TR><TD>"._MAX_DISTANCE."</td><td>".formatDistanceOpen($flight->MAX_LINEAR_DISTANCE)." ($maxDistanceSpeed)\n";
	
} 

	
echo "<TR class='hr'><TD>"._TAKEOFF_LOCATION."</td><td>".formatLocation(getWaypointName($flight->takeoffID),$flight->takeoffVinicity,$takeoffRadious)."<td></tr>\n";
echo "<TR><TD>"._TAKEOFF_TIME."</td><td>".sec2Time($flight->START_TIME)."<td></tr>\n";
echo "<TR><TD>"._DURATION."</td><td>".sec2Time($flight->DURATION)."<td></tr>\n";

echo	"<TR class='hr'><TD>"._MAX_SPEED."</td><td>".formatSpeed($flight->MAX_SPEED)."<td></tr>\n";
echo    "<TR><TD>"._MAX_VARIO."</td><td>".formatVario($flight->MAX_VARIO)."<td></tr>\n";
echo   	"<TR><TD>"._MIN_VARIO."</td><td>".formatVario($flight->MIN_VARIO)."<td></tr>\n";

if ($flight->is3D()) {
	echo "<TR><TD>"._MAX_ALTITUDE."</td><td>".formatAltitude($flight->MAX_ALT)."<td></tr>\n";
	echo "<TR><TD>"._TAKEOFF_ALTITUDE."</td><td>".formatAltitude($flight->TAKEOFF_ALT)."<td></tr>\n";
}

if ($flight->comments) {
	echo "<TR class='hr'><TD>"._COMMENTS."</td><td>".$flight->comments."</td></tr>\n";
}

  echo "</table>";
 //  echo "</pre>";

} else if ($op=='sql'){
		$flight=new flight();
		$flight->getFlightFromDB($flightID);
	
		if (  !L_auth::isModerator($userID) ) {
			echo "go away";
			return;
		}
  ?><head>
  <meta http-equiv="Content-Type" content="text/html; charset=<?=$CONF_ENCODING?>">

<style type="text/css">
	 body, p, table,tr,td {font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px;}
	 td {border:1px solid #777777; }
	 body {margin:0px; background-color:#E9E9E9}
	.box {
		background-color:#F4F0D5;
		border:1px solid #555555;
		padding:3px; 
		margin-bottom:5px;
	}
	.boxTop {margin:0; }
</style>
</head>
<?
	$query="SELECT * from $flightsTable WHERE  ID=$flightID";
	$res= $db->sql_query($query);

	if(!$res > 0) { 
		echo "<h1> ERROR in query: $query</h1>";
		return;
	}
	
	if ( ! $row= mysql_fetch_assoc($res) ) { 
		echo "<h1> ERROR in getting flight from DB</h1>";
		return;	
	}
		
	echo "<table width='400'>";
	$fieldNum=count($row);

	$i=0;
	foreach ($row as $var_name=>$var_value) {
		echo "<tr>";
		echo "<td >$var_name</td><td >$var_value</td>";
		
		echo "</tr>\n";
		$i++;
	}		
	echo "</table>";
}
?>
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
// $Id: GUI_EXT_flight_info.php,v 1.18 2010/11/22 14:28:48 manolis Exp $                                                                 
//
//************************************************************************

 	require_once dirname(__FILE__)."/EXT_config_pre.php";
	require_once dirname(__FILE__)."/config.php";
 	require_once dirname(__FILE__)."/EXT_config.php";

	require_once dirname(__FILE__)."/CL_flightData.php";
	require_once dirname(__FILE__)."/CL_comments.php";
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


	$op=makeSane($_REQUEST['op'],0);
	if (!$op) $op='sql';
	
	$flightID=makeSane($_REQUEST['flightID'],1);
	if ($flightID<=0) exit;
		
if ($op=='photos'){
	$moduleRelPath=moduleRelPath(0); 
	$waypointsWebPath=$moduleRelPath."/".$waypointsRelPath;
		
	$flight=new flight();
	$flight->getFlightFromDB($flightID);

	if ($flight->hasPhotos) {
		require_once dirname(__FILE__)."/CL_flightPhotos.php";
	
		$flightPhotos=new flightPhotos($flight->flightID);
		$flightPhotos->getFromDB();

		$imagesHtml='';
		foreach ( $flightPhotos->photos as $photoNum=>$photoInfo) {
			
			if ($photoInfo['name222']) {
				$imgIconRel=$flightPhotos->getPhotoRelPath($photoNum).".icon.jpg";
				$imgStr="<img src='$imgIconRel'  class=\"photos\" border=\"0\">";		
				echo "<a class='shadowBox imgBox' href='$imgBigRel' target=_blank>$imgStr</a>";		
			}	
			
			
			if ($photoInfo['name']) {
				$imgIconRel=$flightPhotos->getPhotoRelPath($photoNum).".icon.jpg";
				$imgBigRel=$flightPhotos->getPhotoRelPath($photoNum);
		
				$imgIcon=$flightPhotos->getPhotoAbsPath($photoNum).".icon.jpg";
				$imgBig=$flightPhotos->getPhotoAbsPath($photoNum);
							
				if (file_exists($imgBig) ) {
					list($width, $height, $type, $attr) = getimagesize($imgBig);
					list($width, $height)=CLimage::getJPG_NewSize($CONF['photos']['mid']['max_width'], $CONF['photos']['mid']['max_height'], $width, $height);
					$imgStr="<img src='$imgIconRel'  onmouseover=\"trailOn('$imgBigRel','','','','','','1','$width','$height','','.');\" onmouseout=\"hidetrail();\"  class=\"photos\" border=\"0\">";
				} else 	if (file_exists($imgIcon) ) {
					list($width, $height, $type, $attr) = getimagesize($imgIcon);
					list($width, $height)=CLimage::getJPG_NewSize($CONF['photos']['mid']['max_width'], $CONF['photos']['mid']['max_height'], $width, $height);
					$imgStr="<img src='$imgIconRel'  onmouseover=\"trailOn('$imgIconRel','','','','','','1','$width','$height','','.');\" onmouseout=\"hidetrail();\"  class=\"photos\" border=\"0\">";
				} else {
					$imgStr="&nbsp;";
				}
		
				$imagesHtml.="<a class='shadowBox imgBox' href='$imgBigRel' target=_blank>$imgStr</a>";
			}			
			
				
		} 
		echo $imagesHtml;


	}

} else if ($op=='comments'){
		// $flight=new flight();
		// $flight->getFlightFromDB($flightID);
		
		$flightComments=new flightComments($flightID);
		$commentRow=$flightComments->getFirstFromDB();
//		echo "<table class='short_info' cellpadding='0' cellspacing='0' width='100%'>";
//		echo '<tr><td>'.$flight->comments.'</td></tr></table>';

		$comment=leoHtml::cutString($commentRow['text'],300);
		//$comment=$commentRow['text'];
		echo "<span class='short_info'>".$comment.'</span>';
		
} else if ($op=='info_short'){

	$extendedInfo=makeSane($_GET['ext'],1);
	
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
	echo "<TR><TD>"._GLIDER."</td><td>".leoHtml::img("icon_cat_".$flight->cat.".png",0,0,'absmiddle','','icons1','',0)." ".$gliderBrandImg."<td></tr>\n";

 
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

	echo "<TR class='hr'><TD>"._OLC_SCORE_TYPE."</td><td>".formatOLCScoreType($flight->BEST_FLIGHT_TYPE)." ".
			leoHtml::img($olcScoreTypeImg,0,0,'absmiddle','','icons1','',0)."\n";
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

if ($flight->commentsNum) {
	$flightComments=new flightComments($flightID);
	$commentRow=$flightComments->getFirstFromDB();
	$comment=leoHtml::cutString($commentRow['text'],300);
		
	echo "<TR class='hr'><TD>"._COMMENTS."</td><td>".$comment."</td></tr>\n";
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
} else if ($op=='takeoffInfo'){
	//$flightID=makeSane($_REQUEST['flightID'],1);
	//$flightID+=0;
 	$flight=new flight();
	if ( ! $flight->getFlightFromDB($flightID) ) {
  		echo "<br><div align='center'>No such flight exists</div><br><BR>";
		return;  
  	}
  
	
	 // $firstPoint=new gpsPoint($flight->FIRST_POINT,$flight->timezone);						
	$firstPoint=new gpsPoint('',$flight->timezone);
	$firstPoint->setLat($flight->firstLat);
	$firstPoint->setLon($flight->firstLon);
	$firstPoint->gpsTime=$flight->firstPointTM;	
//-------------------------------------------------------------------
// get from paraglidingearth.com
//-------------------------------------------------------------------
	$takoffsList=getExtrernalServerTakeoffs(1,$firstPoint->lat,-$firstPoint->lon,50,5);
	
	if (count($takoffsList) >0 ) {
		$linkToInfoHdr1="<a href='http://www.paraglidingearth.com/en-html/sites_around.php?lng=".-$firstPoint->lon."&lat=".$firstPoint->lat."&dist=20' target=_blank>";
	    $linkToInfoHdr1.="<img src='".$moduleRelPath."/img/paraglidingearth_logo.gif' border=0> "._FLYING_AREA_INFO."</a>";
		
		$linkToInfoStr1="<ul>";
		foreach ($takoffsList as $takeoffItem)  {
				$distance=$takeoffItem['distance']; 
				if ($takeoffItem['area']!='not specified')
					$areaStr=" - ".$takeoffItem['area'];
				else 
					$areaStr="";

				$takeoffLink="<a href='".$takeoffItem['url']."' target=_blank>".$takeoffItem['name']."$areaStr (".$takeoffItem['countryCode'].") [~".formatDistance($distance,1)."]</a>";

				$linkToInfoStr1.="<li>$takeoffLink";
		}
		$linkToInfoStr1.="</ul>";
  }
 // $xmlSites1=str_replace("<","&lt;",$xmlSites);
//-------------------------------------------------------------------
// get from paragliding365.com
//-------------------------------------------------------------------
  	$takoffsList=getExtrernalServerTakeoffs(2,$firstPoint->lat,-$firstPoint->lon,50,5);
	if (count($takoffsList) >0 ) {
		$linkToInfoHdr2="<a href='http://www.paragliding365.com/paragliding_sites.html?longitude=".-$firstPoint->lon."&latitude=".$firstPoint->lat."&radius=50' target=_blank>";
		$linkToInfoHdr2.="<img src='".$moduleRelPath."/img/paraglider365logo.gif' border=0> "._FLYING_AREA_INFO."</a>";
			
		$linkToInfoStr2="<ul>";
		foreach ($takoffsList as $takeoffItem)  {
				if ($takeoffItem['area']!='not specified')	$areaStr=" - ".$takeoffItem['area'];
				else $areaStr="";
				$linkToInfoStr2.="<li><a href='".$takeoffItem['url']."' target=_blank>".
									$takeoffItem['name']."$areaStr (".$takeoffItem['countryCode'].
									") [~".formatDistance($takeoffItem['distance'],1)."]</a>";
		}
		$linkToInfoStr2.="</ul>";
  }
  
  echo $linkToInfoHdr1.$linkToInfoStr1.$linkToInfoHdr2.$linkToInfoStr2;
  

}


?>
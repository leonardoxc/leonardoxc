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
// $Id: GUI_flight_show.php,v 1.108 2011/05/18 13:31:48 manolis Exp $                                                                 
//
//************************************************************************

	require_once $LeoCodeBase."/CL_image.php";
	require_once $LeoCodeBase."/CL_template.php";

	$Ltemplate = new LTemplate($LeoCodeBase.'/templates/'.$PREFS->themeName);

	$print=1;
  $flightID+=0;
  $flight=new flight();
  if ( ! $flight->getFlightFromDB($flightID) ) {
  	echo "<br><div align='center'>No such flight exists</div><br><BR>";
	return;  
  }
  
  if ( $flight->private && ! $flight->belongsToUser($userID) && ! L_auth::isAdmin($userID) ) {
		echo "<TD align=center>"._FLIGHT_IS_PRIVATE."</td>";
		return;
  }

  $flight->incViews();

  if ( $flight->externalFlightType & SYNC_INSERT_FLIGHT_LINK ){
	require dirname(__FILE__).'/GUI_flight_show_ext.php';
	return;
  }


	$Ltemplate ->set_filenames(array(
		'body' => 'flight_show_print.html'));

	$geUrl=getDownloadLink(array('type'=>'kml_trk','flightID'=>$flightID,'lang'=>$lng));
	// $moduleRelPath."/download.php?lang=$lng&type=kml_trk";

    $clientIP=getClientIpAddr();
	if ( $flight->belongsToUser($userID) || L_auth::isModerator($userID) || L_auth::canDownloadIGC($clientIP) ) {
		$directIGCLink=1;
		$base_name=md5(basename($flight->getIGCRelPath()));
		$_SESSION['di'.$base_name]=1;
		// echo 'downloadigc'+$base_name;
		$igcLink="<a href='".$flight->getIGCRelPath()."' >IGC</a>";
	} else {
		$directIGCLink=0;
		$igcLink=" <a href='javascript:nop()' onClick='toggleIgcDownload();return false;' id='IgcDownloadPos'>IGC</a>";
	}	

     
			  
//experiment with google static maps
if (0) {
	list($min_lat,$min_lon,$max_lat,$max_lon)=$flight->getBounds();
	
	$cLat=$min_lat+($max_lat-$min_lat)/2;
	$cLon=$min_lon+($max_lon-$min_lon)/2;
	
	$sLat=($max_lat-$min_lat)/2;
	$sLon=($max_lon-$min_lon)/2;
	echo "<img src='http://maps.google.com/staticmap?center=$cLat,$cLon&span=$sLat,$sLon&size=512x512&key=$CONF_google_maps_api_key&sensor=false&format=jpg&maptype=hybrid'><HR>";
	//exit;
}

?>

<script type="text/javascript" src="<?=$moduleRelPath ?>/js/tipster.js"></script>

<? echo makePilotPopup(); ?>
<? echo maketakeoffPopup(1,$userID); ?>
<script language="javascript">

function changeGEoptions() {

	var flightID= $("#flightID").val();
	var lineWidth= $("#lineWidth").val();
	var lineColor= $("#lineColor").val();

	$("#lineColor").css("background-color",lineColor);
		
	for (var i=0;i<=2;i++) {	
		var newURL= "<?=$geUrl?>&w="+lineWidth+"&c="+lineColor+"&an="+i;
		$("#ge_s"+i).attr("href",newURL);
	}	
}

var unknownTakeoffTip = new TipObj('unknownTakeoffTip');
with (unknownTakeoffTip)
{
	template = '<table bgcolor="#000000" cellpadding="0" cellspacing="0" width="%3%" border="0">' +
	'<tr><td class="infoBoxHeader" style="width:%3%px">%4%</td></tr>'+
	'<tr><td class="infoBox" style="width:%3%px">%5%</td></tr></table>';
	showDelay = 0;
	hideDelay = 2;
	doFades = false;
	tips.floating = new Array(150, 5, "attentionLinkPos", 350, '<?=_unknown_takeoff_tooltip_1?>','<?=_unknown_takeoff_tooltip_2?>');
	tipStick = 0;
}

</script>
<div id="unknownTakeoffTipLayer" class="shadowBox" style="position: absolute; z-index: 10000; visibility: hidden; left: 0px; top: 0px; width: 10px">&nbsp;</div>


<? if ( L_auth::isAdmin($userID) ) { ?>
<script language="javascript">
function add_takeoff(lat,lon,id) {	 
	takeoffTip.hide();
	var url='<?=getRelMainDir(1)?>GUI_EXT_waypoint_add.php?lat='+lat+'&lon='+lon+'&takeoffID='+id;
	popupBox('takeoffAdd','<?=_ADD_WAYPOINT?>',url,410,320,0,14);
}
	 
function edit_takeoff(id) {	 
	takeoffTip.hide();
	var url='<?=getRelMainDir(1)?>GUI_EXT_waypoint_edit.php?waypointIDedit='+id;
	popupBox('takeoffAdd','Change Takeoff',url,410,320,0,14);
}

function delete_takeoff(id) {	 
	takeoffTip.hide();
	var url='<?=getRelMainDir(1)?>GUI_EXT_waypoint_delete.php?waypointIDdelete='+id;
	popupBox('takeoffAdd',"Delete Takeoff",url,410,220,0,14);
}

function flight_db_info(id) {
	var url='<?=getRelMainDir(1)?>GUI_EXT_flight_info.php?flightID='+id;
	popupBox('setBounds',"Flight DB record",url,725,395,-670,18);
}
</script>
<? }  ?>
<script language="javascript">
	function flight_scores_info(id) {
		var url='<?=getRelMainDir(1)?>GUI_EXT_flight_scores_info.php?flightID='+id;
		popupBox('scoreInfo',"Optimization",url,360,195,-5,18);
	}

	function set_flight_bounds(id) {
		var url='<?=getRelMainDir(1)?>GUI_EXT_flight_set_bounds.php?flightID='+id;
		popupBox('setBounds',"Set Start - Stop time for flight",url,725,395,-670,18);
	}
	
	function user_add_takeoff(lat,lon,id) {	 
		var url='<?=getRelMainDir(1)?>GUI_EXT_user_waypoint_add.php?lat='+lat+'&lon='+lon+'&takeoffID='+id;
		popupBox('takeoffAdd','<?=_ADD_WAYPOINT?>',url,720,380,0,30);
	}

	function popupBox(prefix,title,url,width,height,x,y) {
		$(".dropBox").hide();
		
		$("#"+prefix+'BoxTitle').html(title);
		///$("#"+prefix+'Frame').load(url);
		 document.getElementById(prefix+'Frame').src=url;

		$("#"+prefix+'Frame').css("width",width);
		$("#"+prefix+'Frame').css("height",height);
	
		$("#"+prefix+'ID').css("width",width+10);
		$("#"+prefix+'ID').css("height",height+25);
		toggleDiv(prefix+'ID',prefix+'Pos',y,x);
	}

$(document).ready(function(){
	$(".closeButton").click(function(f) {
		$(this).parent().parent().hide();
	});

});

</script>

<? function makePopupBox($name) { 
	global $moduleRelPath,$PREFS;
?>
<div id="<?=$name ?>ID" class="dropBox" >
<div class="infoBoxHeader">
	<div id="<?=$name ?>BoxTitle" class='title'></div>
	<div class='closeButton'></div>        
</div>	
<div id='<?=$name ?>Div' class='content' style='padding:0'>
  <iframe name="<?=$name ?>Frame" id="<?=$name ?>Frame" width="700" height="320" frameborder=0 style='border-width:0px'></iframe>
</div>
</div>
<? } ?>

<?
 makePopupBox('scoreInfo'); 
 makePopupBox('setBounds'); 
 makePopupBox('takeoffAdd'); 
 if (!$directIGCLink) {
	 makePopupBox('IgcDownload'); 
 }	 

?>

<div id="geOptionsID" class="dropBox" >
<div class="infoBoxHeader">
	<div class='title'>Google Earth</div>
	<div class='closeButton'></div>        
</div>	
<div class='content'>
	Please choose the module to use<BR>for Google Earth Display<br />
    <? $icon_bullet_greenStr=leoHtml::img("icon_bullet_green.gif",0,0,'absmiddle','','icons1');?>
    
	<? if ($CONF['googleEarth']['igc2kmz']['active'] && ( $CONF['googleEarth']['igc2kmz']['visible'] || L_auth::isModerator($userID) )  ) { ?>
	    <?=$icon_bullet_greenStr?><?=leoHtml::img("icon_new.gif",0,0,'absmiddle','','icons1')?> <a id='ge_s2' href='<?=$geUrl?>&w=2&c=FFFFFF&an=2'><? echo 'IGC2KMZ (Most detailed, bigger size)'; ?></a>
	<br>
	<? } ?>

    <?=$icon_bullet_greenStr?> <a id='ge_s1' href='<?=$geUrl?>&w=2&c=FF0000&an=1'><? echo 'GPS2GE V2.0 (Many details, big size) '; ?></a>
	<br>
    <?=$icon_bullet_greenStr?> <a id='ge_s0' href='<?=$geUrl?>&w=2&c=FF0000&an=0'><? echo 'Simple (Only Task, very small)'; ?></a>
  <br />
	<?=_Line_Color?>	
	<select  id="lineColor" style="background-color:#ff0000" onChange="changeGEoptions()">
		<option value='FF0000' style='background-color: #FF0000'>&nbsp;&nbsp;&nbsp;</option>
		<option value='00FF00' style='background-color: #00FF00'>&nbsp;&nbsp;&nbsp;</option>
		<option value='0000FF' style='background-color: #0000FF'>&nbsp;&nbsp;&nbsp;</option>	
		<option value='FFD700' style='background-color: #FFD700'>&nbsp;&nbsp;&nbsp;</option>
		<option value='FF1493' style='background-color: #FF1493'>&nbsp;&nbsp;&nbsp;</option>
		<option value='FFFFFF' style='background-color: #FFFFFF'>&nbsp;&nbsp;&nbsp;</option>
		<option value='FF4500' style='background-color: #FF4500'>&nbsp;&nbsp;&nbsp;</option>
		<option value='8B0000' style='background-color: #8B0000'>&nbsp;&nbsp;&nbsp;</option>	
	</select> 

	<?=_Line_width?>	
	<select  id="lineWidth" onChange="changeGEoptions()">	
		<option value='1' >1</option>
		<option value='2' selected >2</option>
		<option value='3' >3</option>
		<option value='4' >4</option>
		<option value='5' >5</option>
	</select>         	
    <input type="hidden" id="flightID" value="<?=$flightID?>">
	</div>
</div>
<?
	$legendRight="";

	$inWindow=true;
	# martin jursa 24.06.2008/ peter wild: taking into account the setting for $CONF_new_flights_submit_window and editing only if flight date is inside the window
	//echo $CONF_new_flights_submit_window;
	if (isset($CONF_new_flights_submit_window) && $CONF_new_flights_submit_window>0) {
		$tsFlight=strtotime($flight->DATE);
		if ($tsFlight>0) {
			$inWindow=$tsFlight>(time()-$CONF_new_flights_submit_window*24*3600);
		}
	}
    if ( $inWindow  || L_auth::isAdmin($userID) ){   //P.Wild 29.6.2007 Admin override to edit outside time window
	//old if (  $flight->DATE	> date("Y-m-d", time() - $CONF_new_flights_submit_window*24*3600 ) ){ // P.Wild mod. 19.5.2008
		if ( $flight->belongsToUser($userID) || L_auth::isModerator($userID) ) {
			$legendRight.="<div id='setBoundsPos'></div><a href='javascript:set_flight_bounds($flightID)'><img src='".$moduleRelPath."/img/icon_clock.png' title='Set Start-Stop Time for flight' border=0 align=bottom></a> ";
		}

		if ( $flight->belongsToUser($userID) || L_auth::isModerator($userID) ) {
			$legendRight.="<a href='".getLeonardoLink(array('op'=>'delete_flight','flightID'=>$flightID))."'><img src='".$moduleRelPath."/img/x_icon.gif' border=0 align=bottom></a>
					   <a href='".getLeonardoLink(array('op'=>'edit_flight','flightID'=>$flightID))."'><img src='".$moduleRelPath."/img/change_icon.png' border=0 align=bottom></a>"; 
		}
	}


	if (  L_auth::isAdmin($userID) ) {
		$legendRight.="<a href='javascript:flight_db_info($flightID)'><img src='".$moduleRelPath."/img/icon_db.gif' title='DB record for the flight' border=0 align=bottom></a> ";
	}
	
	# martin jursa 24.06.2008: display scores info only if flight has not been optimized manually
	if (!$flight->autoScore) {
		$showScoreInfo="<a href='javascript:flight_scores_info($flightID)'><img src='".$moduleRelPath."/img/icon_olc_manual.gif' title='"._Show_Optimization_details."' border=0 align='absmiddle'>"._Show_Optimization_details."&nbsp;<img src='".$moduleRelPath."/img/icon_arrow_down.gif' title='"._Show_Optimization_details."' border=0 align=bottom></a> ";
	}else {
		$showScoreInfo='';
	}

	if ( $flight->private  & 0x01 ) { 
		$legendRight.="&nbsp;<img src='".$moduleRelPath."/img/icon_private.gif' align='bottom' width='13' height='13'>";
	} 

	if ( $flight->private & 0x02 ) { 
		$legendRight.="&nbsp;<img src='".$moduleRelPath."/img/icon_disabled.gif' align='bottom' width='13' height='13'>";
	}
	
	
	$legend=leoHtml::img("icon_cat_".$flight->cat.".png",0,0,'absmiddle','','icons1')." ".
			_PILOT.": <a href=\"javascript:pilotTip.newTip('inline', 60, 19, 'pilot_pos', 200, '".
			$flight->userServerID."_".$flight->userID."','".addslashes(prepare_for_js($flight->userName))."' )\"  onmouseout=\"pilotTip.hide()\">".
			$flight->userName."</a>&nbsp;&nbsp; "._DATE_SORT.": ".formatDate($flight->DATE);
	
	$legend=$flight->userName;
			
			
	$Ltemplate->assign_vars(array(
		'FLIGHT_DATE'=>formatDate($flight->DATE),
		'legend'=>$legend,
		'legendRight'=>$legendRight,
	));



  if (!$flight->active &&  (mktime() - datetime2UnixTimestamp($flight->dateAdded) > 5 ) )  {  //  5 secs
		$flight->activateFlight();
  } else if (!$flight->active) {
		open_tr();
		echo "<TD align=center>"._FLIGHT_WILL_BE_ACTIVATED_SOON."<a href=''>"._TRY_AGAIN."</a></td>";
  		close_tr(); 
		close_inner_table();  
		return;
  }

  if ($_REQUEST['updateMap']) $flight->getMapFromServer();		
  // if ($_REQUEST['updateMap3d']) $flight->getMapFromServer(1);		
  if ($_REQUEST['updateCharts']) $flight->updateCharts(1);		
  if ($_REQUEST['updateData'])  {
	$flight->getFlightFromIGC( $flight->getIGCFilename() );
	$flight->updateTakeoffLanding();

	$flight->createEncodedPolyline(1);
	$flight->makeJSON(1);

	$flight->putFlightToDB(1); // 1== UPDATE
  }

  $flight->updateAll(0);

  $location=formatLocation(getWaypointName($flight->takeoffID),$flight->takeoffVinicity,$takeoffRadious);


  // $firstPoint=new gpsPoint($flight->FIRST_POINT,$flight->timezone);						
	$firstPoint=new gpsPoint('',$flight->timezone);
	$firstPoint->setLat($flight->firstLat);
	$firstPoint->setLon($flight->firstLon);
	$firstPoint->gpsTime=$flight->firstPointTM;				


  if ($_REQUEST['updateScore'] || $flight->FLIGHT_POINTS==0) { 
		$flight->computeScore();
		// $flight->putFlightToDB(1); // 1== UPDATE
  }

  
  if ($CONF_use_validation) {
		if ($flight->grecord==0) $flight->validate(1);
		
		if ($flight->grecord<0) 		{ $vImg="icon_valid_nok.gif"; $vStr="Invalid or N/A"; }
		else if ($flight->grecord==0) 	{ $vImg="icon_valid_unknown.gif"; $vStr="Not yet processed"; }
		else if ($flight->grecord==1) 	{$vImg="icon_valid_ok.gif"; $vStr="Valid"; }
							
		$valiStr="&nbsp;".leoHtml::img($vImg,12,12,'absmiddle',$vStr,'icons1 listIcons');
  }

  if ($CONF_airspaceChecks) {
		if ($flight->airspaceCheck==0 || $flight->airspaceCheckFinal==0) $flight->checkAirspace(1);
  }

	if ($flight->autoScore) { // means that there is manual optimization present
		if (!$valiStr) $valiStr="&nbsp;";
		$vStr='This flight was optimized manually.';
		$valiStr.="<img class='listIcons' src='".$moduleRelPath."/img/icon_olc_manual.gif' align='absmiddle' title='$vStr' alt='$vStr' width='17' height='16' border='0' />";
		if ($flight->autoScore > $flight->FLIGHT_POINTS ) {
			$vStr="The manual optimization is worst than the auto optimization (Auto score:".$flight->autoScore.")";
			$valiStr.="<img class='listIcons' src='".$moduleRelPath."/img/icon_att1.gif' align='absmiddle' title='$vStr' alt='$vStr' width='17' height='17' border='0' />";				
		} else {
			$vStr="The manual optimization is better than the auto optimization (Auto score:".$flight->autoScore.")";
			$valiStr.="<img class='listIcons' src='".$moduleRelPath."/img/olc_icon_submited.gif' align='absmiddle' title='$vStr' alt='$vStr' width='16' height='16' border='0' />";
		}
	}
  
  DEBUG_END(); // flush debug here
	
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
	if ($print) {
		$takeoffLink=$location;
	} else {
	
		$takeoffLink="<div id='takeoffAddPos'><a href=\"javascript:takeoffTip.newTip('inline',0,13, 'takeoffAddPos', 250, '".$flight->takeoffID."','".str_replace("'","\'",$location)."',".$firstPoint->lat.",".$firstPoint->lon.")\"  onmouseout=\"takeoffTip.hide()\">$location</a>";
			
		if ($flight->takeoffVinicity>$takeoffRadious*2 ) {
			$takeoffLink.="<div id='attentionLinkPos' class='attentionLink'><a
				 href=\"javascript:user_add_takeoff(".$firstPoint->lat.",".$firstPoint->lon.",".$flight->takeoffID.")\" 
				 onmouseover='unknownTakeoffTip.show(\"floating\")'  onmouseout='unknownTakeoffTip.hide()'><img
				 src='$moduleRelPath/img/icon_att3.gif' border=0 align=absmiddle>"._Unknown_takeoff."<img 
				 src='$moduleRelPath/img/icon_att3.gif' border=0 align=absmiddle></a></div>";
		}
		$takeoffLink.="</div>";
	}

$Ltemplate->assign_vars(array(
	'TAKEOFF_LOCATION'=>$takeoffLink,
	'TAKEOFF_TIME'=>sec2Time($flight->START_TIME),
	'LANDING_LOCATION'=>formatLocation(getWaypointName($flight->landingID),$flight->landingVinicity,$landingRadious),
	'LANDING_TIME'=>sec2Time($flight->END_TIME),
	'LINEAR_DISTANCE'=>formatDistanceOpen($flight->LINEAR_DISTANCE)." ($openDistanceSpeed)",
	'DURATION'=>sec2Time($flight->DURATION),
	'VALI'=>$valiStr,
));

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
	$Ltemplate->assign_vars(array(
		'MAX_DISTANCE'=>formatDistanceOpen($flight->MAX_LINEAR_DISTANCE)." ($maxDistanceSpeed)",		
		'OLC_TYPE'=>formatOLCScoreType($flight->BEST_FLIGHT_TYPE)." ".leoHtml::img($olcScoreTypeImg,0,0,'absmiddle','','icons1'),
		'OLC_KM'=>formatDistanceOpen($flight->FLIGHT_KM)." ($olcDistanceSpeed)",
		'OLC_SCORE'=>formatOLCScore($flight->FLIGHT_POINTS),
		'SCORE_INFO_LINK'=>$showScoreInfo,
	));
} else {
	$Ltemplate->assign_vars(array(
		'MAX_DISTANCE'=>0,		
		'OLC_TYPE'=>0,
		'OLC_KM'=>0,
		'OLC_SCORE'=>0,
	));
}

$Ltemplate->assign_vars(array(
	'MAX_SPEED'=>formatSpeed($flight->MAX_SPEED),
    'MAX_VARIO'=>formatVario($flight->MAX_VARIO),  
   	'MEAN_SPEED'=>formatSpeed($flight->MEAN_SPEED),
   	'MIN_VARIO'=>formatVario($flight->MIN_VARIO),
));	

if ($flight->is3D()) {
	$Ltemplate->assign_vars(array(
		'MAX_ALT'=>formatAltitude($flight->MAX_ALT),
		'TAKEOFF_ALT'=>formatAltitude($flight->TAKEOFF_ALT),
		'MIN_ALT'=>formatAltitude($flight->MIN_ALT),
		'ALTITUDE_GAIN'=>formatAltitude($flight->MAX_ALT-$flight->TAKEOFF_ALT),
	));
} else {
	$Ltemplate->assign_vars(array(
		'MAX_ALT'=>0,
		'TAKEOFF_ALT'=>0,
		'MIN_ALT'=>0,
		'ALTITUDE_GAIN'=>0,
	));
}
 

/* 	$flight->filename
		echo "<div id='geOptionsPos' style='float:right'>";
		echo "<a href='javascript:nop()' onclick=\"toggleVisible('geOptionsID','geOptionsPos',14,-80,170,'auto');return false;\">Google Earth&nbsp;<img src='".$moduleRelPath."/img/icon_arrow_down.gif' border=0></a></div>";
*/


$linkURL=_N_A;
if ($flight->linkURL) {
	$linkURL="<a href='".formatURL($flight->linkURL,0)."' title='".formatURL($flight->linkURL,0)."' target=_blank>".
		formatURL($flight->linkURL,15)."</a>";
}

 	$flightBrandID=$row['gliderBrandID'];
 	//$flightBrandID=guessBrandID($flight->cat,$flight->glider);
	
	$gliderBrandImg=brands::getBrandImg($flight->gliderBrandID,$flight->glider,$flight->cat);
	
	$glider=$gliderBrandImg.' '.$flight->glider;


	$gliderCat = " [ ".leoHtml::img("icon_cat_".$flight->cat.".png",0,0,'absmiddle','','icons1')." ".$gliderCatList[$flight->cat]." ]";
 
 // now loaded dynamically via ajax on request
 
 /*
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
  $xmlSites1=str_replace("<","&lt;",$xmlSites);
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
  $xmlSites2=str_replace("<","&lt;",$xmlSites);
 */
 
$adminPanel="";
if (L_auth::isAdmin($userID) || $flight->belongsToUser($userID) ) {  //P. Wild 15.2.2008 extension
	$adminPanel="<b>"._TIMES_VIEWED.":</b> ".$flight->timesViewed."  ";
	$adminPanel.="<b>"._SUBMISION_DATE.":</b> ".$flight->dateAdded." :: ";


	// see all scoring:
	if (0) {
		require_once dirname(__FILE__).'/CL_flightScore.php';			
		$flightScore=new flightScore($flight->flightID);
		$flightScore->getFromDB();
		$adminPanel.="<PRE>".$flightScore->toSyncJSON()."</PRE>";
		$adminPanel.= "<hr><HR>";
		$adminPanel.="<PRE>".print_r($flightScore->scores,1)."</PRE>";
	}

	//	$adminPanel.='<pre>'.processIGC($flight->getIGCFilename());
	if (L_auth::isAdmin($userID)) {	
		// DEBUG TIMEZONE DETECTION 
		// $firstPoint=new gpsPoint($flight->FIRST_POINT);
		$firstPoint=new gpsPoint('',$flight->timezone);
		$firstPoint->setLat($flight->firstLat);
		$firstPoint->setLon($flight->firstLon);
		$firstPoint->gpsTime=$flight->firstPointTM;				
	
	
		// $time=substr($flight->FIRST_POINT,1,6);
		$time=date('H:i:s',$firstPoint->gpsTime);
		$zone= getUTMzoneLocal( $firstPoint->lon,$firstPoint->lat);
		$timezone1= ceil(-$firstPoint->lon / (180/12) );
	
		$timezone2=	 getTZ( $firstPoint->lat,$firstPoint->lon, $flight->DATE );
	
		$adminPanel.="<pre><b>UTM zone:</b> $zone ";
		$adminPanel.="<b>TZ (lat estimation):</b> $timezone1 ";
		$adminPanel.="<b>TZ (estimation 2):</b> $timezone2 ";
		$adminPanel.="<b>TZ (db):</b> ".$flight->timezone."\n";
		$adminPanel.="<b>First point time:</b> $time ";
		$adminPanel.="DATE : ".$flight->DATE." ";
		$adminPanel.='</pre>';
	}
	
	// display the trunpoints
	//echo "<hr> ";
	//for($k=1;$k<=5;$k++) { $vn="turnpoint$k"; echo " ".$flight->$vn." <BR>"; }

	
	if ($flight->airspaceCheckFinal==-1) { // problem
			
		$checkLines=explode("\n",$flight->airspaceCheckMsg);
		if (strrchr($flight->airspaceCheckMsg,"Punkte")){
			$adminPanel.="<br><strong>Deutschland Pokal</strong><BR>";		
			if ((strrchr($flight->airspaceCheckMsg,"HorDist"))) {
				$adminPanel.="<br><strong>Airspace PROBLEM (Deutschland Pokal)</strong><BR>";
			}
		} else{
			$adminPanel.= "<br><strong>Airspace PROBLEM</strong><BR>";
		}
		for($i=1;$i<count($checkLines); $i++) {
			$adminPanel.=$checkLines[$i]."<br>";
		}
	}
	
	if (L_auth::isAdmin($userID)) {
		if ($CONF_show_DBG_XML  ) {
			$adminPanel.="<div style='display:inline'><a href='javascript:toggleVisibility(\"xmlOutput\")';>See XML</a></div>";
		}
		

		$adminPanel.="<div style='display:inline'> :: <a href='javascript:toggleVisibility(\"adminPanel\")';>Admin options</a></div>";
		/*
		if ($CONF_show_DBG_XML) {
			$adminPanel.="<div id=xmlOutput style='display:none; text-align:left;'><hr>";
			$adminPanel.="XML from paraglidingEarth.com<br>";
			$adminPanel.="<pre>$xmlSites1</pre><hr>XML from paragliding365.com<br><pre>$xmlSites2</pre></div>";
		}
		*/
		
		$adminPanel.="<div id='adminPanel' style='display:none; text-align:center;'><hr>";
		$adminPanel.="<a href='".getLeonardoLink(array('op'=>'show_flight','flightID'=>$flightID,'updateData'=>'1'))."'>"._UPDATE_DATA."</a> | ";
		$adminPanel.="<a href='".getLeonardoLink(array('op'=>'show_flight','flightID'=>$flightID,'updateMap'=>'1'))."'>"._UPDATE_MAP."</a> | ";
		$adminPanel.="<a href='".getLeonardoLink(array('op'=>'show_flight','flightID'=>$flightID,'updateCharts'=>'1'))."'>"._UPDATE_GRAPHS."</a> | ";
		$adminPanel.="<a href='".getLeonardoLink(array('op'=>'show_flight','flightID'=>$flightID,'updateScore'=>'1'))."'>"._UPDATE_SCORE."</a> ";
	
		$adminPanel.=get_include_contents(dirname(__FILE__)."/site/admin_takeoff_info.php");
	}	
}


$commentsHtml="<div id='tabcomments0' class='tab_content0'>
	<div id='comments_iframe_div0' style='width:745px; height:auto; text-align:left;'>
		<iframe id='comments_iframe0' align='left'
		  SRC='http://".$_SERVER['SERVER_NAME'].getRelMainDir()."GUI_EXT_flight_comments.php?flightID=".
		$flight->flightID."&print=1' ".
	 " TITLE='Comments' width='100%' height='100%'  style='padding:0;margin:0;'
		  scrolling='auto' frameborder='0'>Sorry. If you're seeing this, your browser doesn't support IFRAMEs.	You should upgrade to a more current browser.
	</iframe>
	</div>
	</div>";

if ($flight->hasPhotos) {
	require_once dirname(__FILE__)."/CL_flightPhotos.php";

	$flightPhotos=new flightPhotos($flight->flightID);
	$flightPhotos->getFromDB();

	// get geoinfo
	$flightPhotos->computeGeoInfo();

	$imagesHtml="";
	foreach ( $flightPhotos->photos as $photoNum=>$photoInfo) {
		
		if ($photoInfo['name']) {
			$imgIconRel=$flightPhotos->getPhotoRelPath($photoNum).".icon.jpg";
			$imgBigRel=$flightPhotos->getPhotoRelPath($photoNum);
	
			$imgIcon=$flightPhotos->getPhotoAbsPath($photoNum).".icon.jpg";
			$imgBig=$flightPhotos->getPhotoAbsPath($photoNum);
			
			
			
			$imgStr="<img src='$imgBigRel'  width='355'  class=\"photos\" border=\"0\">";
			
			/*
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
	*/
			// $imagesHtml.="<a class='shadowBox imgBox' href='$imgBigRel' target=_blank>$imgStr</a>";
			$imagesHtml.="<a class='shadowBox imgBox' href='$imgBigRel' target=_blank>$imgStr</a>";
	
		}		
	}
}

// add support for google maps
// see the config options 
$localMap="";
$googleMap="";
if ( is_file($flight->getMapFilename() ) ) {
		$localMap="<img src='".$flight->getMapRelPath()."' border=0>";	
}

if ( $CONF_google_maps_track==1 && $PREFS->googleMaps ) {
	$flight->createEncodedPolyline();

	if ( $CONF_google_maps_api_key  ) {
		 $googleMap="<div id='gmaps_div' style='display:block; width:745px; height:610px;'><iframe id='gmaps_iframe' align='left'
		  SRC='http://".$_SERVER['SERVER_NAME'].getRelMainDir()."EXT_google_maps_track_print.php?id=".
		$flight->flightID."' ".
		 " TITLE='Google Map' width='100%' height='100%'
		  scrolling='no' frameborder='0'>
		Sorry. If you're seeing this, your browser doesn't support IFRAMEs.	You should upgrade to a more current browser.
		</iframe></div>";
	}
	
	if ($CONF_google_maps_track_only==1) { // use only google maps,  discard the local map server
		$localMap='';
	}

}

 

$mapImg0.='<ul class="tabs0">';
if ($localMap) {
	$mapImg0.='<li id="tabmapli"><a href="#tabmap">'._OLC_MAP.'</a></li>';
}
if ($googleMap) {
	$mapImg0.='<li id="tabgmapli"><a href="#tabgmap">Google Map</a></li>';
}	

$mapImg0.='<li id="tabcommentsli"><a href="#tabcomments">'._COMMENTS.' ('.$flight->commentsNum.')</a></li>';
	
if ($imagesHtml) {
	$mapImg0.='<li id="tabphotosli"><a href="#tabphotos">'._PHOTOS.'</a></li>';
}	
$mapImg0.='</ul>';

$mapImg0='';

	// use tabber 
	if ($googleMap)	$activeTabName='gmap';
	else if ($localMap) $activeTabName='map';
	else $activeTabName='comments';
	

	
	$mapImg="<div class='tab_container0'>\n";

	if ($googleMap) {
		$mapImg.="<div id='tabgmap' class='tab_content0'>$googleMap</div>";			 
	}	
	if ($localMap && !$print) {
		$mapImg.="<div id='tabmap' class='tab_content0'>$localMap</div>";
	}		

	ob_start();
	include "GUI_EXT_flight_comments.php";
	$commentsHtml = ob_get_contents();
	ob_end_clean();
	
	// always include the comments tab
	$mapImg.=$commentsHtml;

	if ($imagesHtml) {
		$mapImg.="<div id='tabphotos' class='tab_conten0t'>$imagesHtml</div>";
	}		  
	
	
	$mapImg.="</div>";


	
	if ($imagesHtml) 
		$mapImg.="<script type='text/javascript' src='$moduleRelPath/js/xns.js'></script>";
		
	$mapImg=$mapImg0.$mapImg;



if (!$print) {
	if ($flight->is3D() &&  is_file($flight->getChartfilename("alt",$PREFS->metricSystem))) 
		$chart1= "<br><br><img src='".$flight->getChartRelPath("alt",$PREFS->metricSystem)."'>";
	if ( is_file($flight->getChartfilename("takeoff_distance",$PREFS->metricSystem)) )
		$chart2="<br><br><img src='".$flight->getChartRelPath("takeoff_distance",$PREFS->metricSystem)."'>";
	if ( is_file($flight->getChartfilename("speed",$PREFS->metricSystem)) )
		$chart3="<br><br><img src='".$flight->getChartRelPath("speed",$PREFS->metricSystem)."'>";
	if ($flight->is3D() &&  is_file($flight->getChartfilename("vario",$PREFS->metricSystem))) 
		$chart4="<br><br><img src='".$flight->getChartRelPath("vario",$PREFS->metricSystem)."'>";

}

$extLinkLanguageStr="";
if ( $CONF['servers']['list'][$flight->serverID]['isLeo'] ) $extLinkLanguageStr="&lng=$currentlang";

$extFlightLegend=_Ext_text1." <i>".$CONF['servers']['list'][$flight->serverID]['name'].
		"</i>. <a href='".$flight->getOriginalURL().$extLinkLanguageStr."' target='_blank'>"._Ext_text3.
		leoHtml::img('icon_link.gif',0,0,'',_External_Entry,'icons1 flagIcon')."</a>";


$Ltemplate->assign_vars(array(
	'extFlightLegend'=> $extFlightLegend,
	
	'M_PATH'=> $moduleRelPath,
	'T_PATH'=> $moduleRelPath.'/templates/'.$PREFS->themeName,
	
	'ADMIN_PANEL'=>$adminPanel,
	'MAP_IMG'=>$mapImg,
	'activeTabName'=>$activeTabName,
	'CHART_IMG1'=>$chart1,
	'CHART_IMG2'=>$chart2,
	'CHART_IMG3'=>$chart3,
	'CHART_IMG4'=>$chart4,		


	'linkURL'=>$linkURL,
	'glider'=>$glider,
	'gliderCat'=>$gliderCat,
	'igcPath'=> $flight->getIGCRelPath(),
	'igcLink'=> $igcLink,
	'flightID'=>$flight->flightID,
	

));

if ($flight->externalFlightType &&  ! $CONF['servers']['list'][$flight->serverID]['treat_flights_as_local']) {
   	$Ltemplate->assign_block_vars('EXT_FLIGHT', array() );
}
if ($adminPanel) {
    $Ltemplate->assign_block_vars('ADMIN_PANEL', array() );
}

$Ltemplate->pparse('body');

?>
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
// $Id: FN_output.php,v 1.61 2012/10/04 05:59:26 manolis Exp $                                                                 
//
//************************************************************************

require_once dirname(__FILE__)."/CL_html.php";

function sec2Time($secs,$no_seconds=false) {
  if ($no_seconds)
    return sprintf("%d:%02d",$secs/3600,($secs%3600)/60);
  else 
    return '<span class="time_style">'.sprintf("%d:%02d:%02d",$secs/3600,($secs%3600)/60,$secs%60).'</span>';
}

function sec2Time24h($secs,$no_seconds=false) {
	if ($no_seconds)
    	return sprintf("%02d:%02d",$secs/3600,($secs%3600)/60);
	else 
		return sprintf("%02d:%02d:%02d",$secs/3600,($secs%3600)/60,$secs%60);
}


function fulldate2tm($dateStr) {
	// expecting YYYY-MM-DD HH:MM:SS
	$tm=0;
	if (preg_match("/(\d\d\d\d)-(\d\d)-(\d\d) (\d\d):(\d\d):(\d\d)/",$dateStr,$matches)) {
		$tm=mktime($matches[4],$matches[5],$matches[6],$matches[2],$matches[3],$matches[1]);
	}
	return $tm;
}

function fulldate2tmUTC($dateStr) {
	// expecting YYYY-MM-DD HH:MM:SS
	$tm=0;
	if (preg_match("/(\d\d\d\d)-(\d\d)-(\d\d) (\d\d):(\d\d):(\d\d)/",$dateStr,$matches)) {
		$tm=gmmktime($matches[4],$matches[5],$matches[6],$matches[2],$matches[3],$matches[1]);
	}
	return $tm;
}

function tm2fulldate($tm){
	// return YYYY-MM-DD HH:MM:SS
	return date("Y-m-d H:i:s",$tm);
}

function days2YearsMonths($days) {
   $years=floor($days/365);
   $months=ceil( ($days%365) / 30 );
   return array($years,$months);
}

function formatURL($linkURL,$numChars=0) {
	if ($numChars>0) {
		 if (strlen($linkURL) > $numChars - 3 )
		 $linkURL=substr($linkURL,0,$numChars)."...";
	}
	if ( substr($linkURL,0,7) == "http://" ) return $linkURL;
	else return "http://".$linkURL;
}

function trimText($text,$numChars=0) {
	global $CONF_use_utf;
	if ($numChars>0) {
		if ($CONF_use_utf) {
		 if (function_exists('mb_strlen')  ) {
			 if (mb_strlen($text,'UTF-8') > $numChars - 3 )
				 $text=mb_substr($text,0,$numChars,'UTF-8')."...";
		  } else {
			 $numChars*=2;
			 if (strlen($text) > $numChars - 3 )
				 $text=substr($text,0,$numChars)."...";		  
		  }		
		} else {
		 if (strlen($text) > $numChars - 3 )
			 $text=substr($text,0,$numChars)."...";
		}	 
	}
	return $text;	
}

function formatDate($date,$html_output=true) {
  // from 2002-07-14 -> 14/07/2004
  $dt_str=sprintf("%02d/%02d/%4d",substr($date,8,2),substr($date,5,2),substr($date,0,4));
  return $dt_str;
  //if ($html_output)
  //  return '<font color=#224488>'.$dt_str.'</font>';
  //else return $dt_str;
}

function formatOLCScoreType($type,$html_output=true) {
	$ret="#".$type."#";
	if ($type=="FREE_FLIGHT") $ret=_FREE_FLIGHT;
	else if ($type=="FREE_TRIANGLE") $ret=_FREE_TRIANGLE;
	else if ($type=="FAI_TRIANGLE") $ret=_FAI_TRIANGLE;
	if ($html_output)
		return '<span class="score_type_style">'.$ret.'</span>';
	else return $ret;
}

function formatDistance($distance,$showUnits=false) { // in meters
	global $PREFS;
	// 1 kilometer = 0.62 mil
	// 1 meter  =  3.28 feet
	if ($PREFS->metricSystem==2) { 
		$dis=($distance*0.62)/1000; 
		$units=_MI;
	} else { // km
		$dis=$distance/1000;
		$units=_KM;
	}
	// return sprintf("%.2f km",$distance/1000);
	return sprintf("%.1f&nbsp;%s",$dis,($showUnits)?$units:"");
}

function formatDistanceOpen($distance,$showKm=true) { // in meters
	return  formatDistance($distance,$showKm);
	// return '<font color=#4400aa>'.formatDistance($distance,$showKm).'</font>';
}

function formatDistanceOLC($distance,$showKm=true) { // in meters
	return '<span class="distance_style">'.formatDistance($distance,$showKm).'</span>';
}



function formatOLCScore($score,$html_output=true) { 
	return sprintf("%.2f",$score);
	//if ($html_output) return '<font color=#0000ff>'.sprintf("%.1f",$score).'</font>';
	//else return sprintf("%.1f",$score);
}

function formatAltitude($alt) { 
	global $PREFS;
	// 1 kilometer = 0.62 mil
	// 1 meter  =  3.28 feet
	if ($PREFS->metricSystem==2) { 
		$alt=$alt*3.28; //feet
		$units=_FT;
	} else { 
		$units=_M;
	}
	return '<span class="altitude_style">'.sprintf("%d&nbsp;%s",$alt,$units).'</span>';
}

function formatSpeed($speed) { // in km/h
	global $PREFS;
	// 1 kilometer = 0.62 mil
	// 1 meter  =  3.28 feet
	if ($PREFS->metricSystem==2) { 
		$speed=$speed*0.62; // ml/h
		$units=_MPH;
	} else { 
		$units=_KM_PER_HR;
	}
	return '<span class="speed_style">'.sprintf("%.1f&nbsp;%s",$speed,$units).'</span>';
}

function formatVario($vario) { // in m/sec
	global $PREFS;
	// 1 kilometer = 0.62 mil
	// 1 meter  =  3.28 feet
	if ($PREFS->metricSystem==2) { 
		$vario=$vario*3.28*60; // feet /min
		$units=_FPM;
		return '<span class="vario_style">'.sprintf("%.0f&nbsp;%s",$vario,$units).'</span>';
	} else { 
		$units=_M_PER_SEC;
		return '<span class="vario_style">'.sprintf("%.1f&nbsp;%s",$vario,$units).'</span>';
	}

}

function formatLocation($name,$vinicity,$radious) {
	global $PREFS;
	if ($PREFS->metricSystem==2) $dis=($vinicity*0.62)/1000; 
	else $dis=$vinicity/1000;

 if ($vinicity > 300000 ) $res_name="UNKNOWN";
 else if ($vinicity > $radious ) 
		$res_name=$name."&nbsp;[~".sprintf("%.1f",$dis)."]"; 
//		$res_name=$name."&nbsp;[~".sprintf("%.1f",$vinicity/1000)."&nbsp;km]"; 
 else $res_name=$name;

 $res_name=str_replace("&#039;","'",$res_name);
 return $res_name;
}


function datetime2UnixTimestamp($datestamp) {
    if ($datestamp!=0) {
        list($date, $time)=split(" ", $datestamp);
        list($year, $month, $day)=split("-", $date);
        list($hour, $minute, $second)=split(":", $time);		
        $stampeddate=mktime($hour,$minute,$second,$month,$day,$year);    
        return   $stampeddate ;
    }
}



function processIGC($filePath) {
	global $takeoffRadious;
	//echo $filePath."<br>";
	//echo filesize( $filePath)."<br>";
	$lines = file ($filePath); 
	$points=0;
	foreach($lines as $line) {
		$line=trim($line);
		if  (strlen($line)==0) continue;		
		if ($line{0}=='B') {
			$firstPoint=new gpsPoint($line);
			//$res.=_TAKEOFF_COORDS." ";
			//$res.=$firstPoint->lat." ";
			//$res.=$firstPoint->lon."<br>";

			$time=substr($line,1,6);
			$zone= getUTMzoneLocal( $firstPoint->lon,$firstPoint->lat);
			$timezone= ceil(-$firstPoint->lon / (180/12) );
			$res.="<b>UTM zone:</b> ".$zone." ";
			$res.="<b>Timezone:</b> ".$timezone." <b>First point time:</b> $time ";
			break;
		}
	}
	return $res;
}

function getUTMzoneLocal($lon, $lat)  {
	if ($lon < 0.0)  $lonTmp = 180 - $lon ;
	else $lonTmp = 180 - $lon ;

	$UTMzone=ceil($lonTmp/6);
	return $UTMzone;
}

function getUTMtimeOffset($lat,$lon, $theDate ) {
// $lon is the X (negative is EAST positive is WEST
// for now we return a very rough calculation
	DEBUG('flight',1,"getUTMtimeOffset: date-> $theDate <BR>");

	$timezone= ceil( -$lon / (180/12) );
	return $timezone;
}

function getTZ($lat,$lon, $theDate) {
	global $db,$waypointsTable;
	global $CONF_use_date_for_TZ_detection;

	// fall back to simple lon method in case of old php (4.4.1) 
	if (!$CONF_use_date_for_TZ_detection) 	return getUTMtimeOffset($lat,$lon, $theDate );

	$query="SELECT lat,lon,ABS($lat-lat) as dlat , ABS($lon- lon ) as dlon ,countryCode from $waypointsTable 
				WHERE ABS($lat-lat) < 1 AND ABS($lon- lon )  < 1
				ORDER BY dlat,dlon ASC";
	DEBUG('getTZ',128,"getTZ: $query<BR>");
	$res= $db->sql_query($query);
		
    if($res <= 0){
		DEBUG('getTZ',128,"getTZ: no waypont near by will try rough method<BR>");
		return  getUTMtimeOffset($lat,$lon, $theDate );
    }

	$i=0;
	$minTakeoffDistance=1000000;
	while ($row = mysql_fetch_assoc($res)) { 
		$i++;	  
		$this_distance = gpsPoint::calc_distance($row["lat"],$row["lon"],$lat,$lon);
		DEBUG('getTZ',128,"getTZ: ".$row["lat"]." , ".$row["lon"]." country-> ".$row["countryCode"]." distance-> $this_distance <BR>");
		if ( $this_distance < $minTakeoffDistance ) {
				$minTakeoffDistance = $this_distance;
				$countryCode=$row["countryCode"];
		}
    }     

	if (!$i) {
		DEBUG('getTZ',128,"getTZ: No waypont near by #2. Will try rough method<BR>");
		return  getUTMtimeOffset($lat,$lon, $theDate );
	}

	DEBUG('getTZ',128,"getTZ: Min dist: $minTakeoffDistance , country: $countryCode <BR>");
	if ($minTakeoffDistance > 50000 ) {
		DEBUG('getTZ',128,"getTZ: Nearest waypoint is too far. Will try rough method<BR>");
		return  getUTMtimeOffset($lat,$lon, $theDate );
	}

	// now we will try the getTZoffset()

	// make $tm from YYYY-MM-DD
	$tm=gmmktime(1,0,0,substr($theDate,5,2),substr($theDate,8,2),substr($theDate,0,4));

	// this will return  good results only for countries that have ONE timezone
	// else '' will be returned
	require_once dirname(__FILE__).'/FN_timezones.php';
	// $TZone=getTZforCountry($countryCode);
	global $Countries2timeZones;
	$TZone= $Countries2timeZones[strtoupper($countryCode)];

	if (strtoupper($countryCode)=='AU' ){
		DEBUG('getTZ',128,"getTZ: Australia timezones<BR>");
/* 
australia
http://www.statoids.com/tau.html
central - west is on 129E

central - east is on 
lon > 141E for lat < -26 (S)
lon > 138E for lat > -26 (S)

east - > Australia/Sydney
west
central
*/
		if ( $lon > -129 )  $TZone='Australia/Perth'; // West
		else if ( $lon > -138 && $lat  > -26 ) $TZone='Australia/Darwin';   // central north
		else if ( $lon > -141 && $lat  < -26 ) $TZone='Australia/Adelaide'; // central south
		else if ( $lat > -29) $TZone='Australia/Brisbane';  // queensland - North East
		else $TZone='Australia/Sydney';  //  South-East
	}

	if ($TZone=='') { 
		DEBUG('getTZ',128,"getTZ: Country $countryCode has more than one timezones.. Back to rough method<BR>");
		return  getUTMtimeOffset($lat,$lon, $theDate );
	}

	return getTZoffset($TZone,$tm)/3600;
}

function getTZoffset($TZone,$tm) {
	$oldTZ=getenv("TZ");
	// echo "old:$oldTZ";
	// DEBUG('getTZoffset',128,"getTZoffset: $TZone  ($tm) [server TZ=$oldTZ] ".date("T/Z/I/O")."<BR>");

	putenv("TZ=$TZone");
$offset=date('O',$tm);
	putenv("TZ=$TZone");
$offset=date('O',$tm);
	putenv("TZ=$TZone");
	$offset=date('O',$tm);

	$tTZ=getenv("TZ");
	DEBUG('getTZoffset',128,"getTZoffset: offset from GMT :$offset [getenv TZ= $tTZ] ".date("T/Z/I/O")."<BR>");

	putenv("TZ=$oldTZ");


	if ( preg_match("/([-+])(\d\d)(\d\d)/",$offset,$matches) ) {
		$secs=$matches[2]*3600+$matches[3]*60;
		if ($matches[1]=='-') $secs=-$secs;
	} else  {
		echo "FATAL error in flight offset";
		exit;
	}
	DEBUG('getTZoffset',128,"getTZoffset: $TZone  ($tm) = ".($secs /3600)."<BR>");
		
	return $secs;
}

function generate_flights_pagination($base_url, $num_items, $per_page, $start_item, $add_prevnext_text = TRUE,	$begin_end = 2,	$from_middle = 2)
{


/*
	By default, $begin_end is 3, and $from_middle is 1, so on page 6 in a 12 page view, it will look like this:

	a, d = $begin_end = 3
	b, c = $from_middle = 1

 "begin"        "middle"           "end"
    |              |                 |
    |     a     b  |  c     d        |
    |     |     |  |  |     |        |
    v     v     v  v  v     v        v
    1, 2, 3 ... 5, 6, 7 ... 10, 11, 12

	Change $begin_end and $from_middle to suit your needs appropriately
*/
//	$begin_end = 2;
//	$from_middle = 2;
	
	$total_pages = ceil($num_items/$per_page);

	if ( $total_pages == 1 )
	{
		return '';
	}

	$on_page = floor($start_item / $per_page) + 1;

	$page_string = '';
	if ( $total_pages > ((2*($begin_end + $from_middle)) + 2) )
	{
	//	$init_page_max = ( $total_pages > 3 ) ? 3 : $total_pages;
		$init_page_max = ( $total_pages > $begin_end ) ? $begin_end : $total_pages;


		for($i = 1; $i < $init_page_max + 1; $i++)
		{
			// $page_string .= ( $i == $on_page ) ? '<b>' . $i . '</b>' : '<a href="' . append_sid($base_url . "&amp;start=" . ( ( $i - 1 ) * $per_page ) ) . '">' . $i . '</a>';
			$page_string .= ( $i == $on_page ) ? '<div class="activePageNum">' . $i . '</div>' : '<a href="' . append_sid($base_url . "&amp;page_num=".$i ) . '">' . $i . '</a>';
			if ( $i <  $init_page_max )
			{
				$page_string .= ", ";
			}
		}

		//if ( $total_pages > 3 )
		if ( $total_pages > $begin_end )
		{
			if ( $on_page > 1  && $on_page < $total_pages )	{
				//$page_string .= ( $on_page > 5 ) ? ' ... ' : ', ';
				$page_string .= ( $on_page > ($begin_end + $from_middle + 1) ) ? ' ... ' : ', ';


				//$init_page_min = ( $on_page > 4 ) ? $on_page : 5;
				$init_page_min = ( $on_page > ($begin_end + $from_middle) ) ? $on_page : ($begin_end+ $from_middle + 1);
				//$init_page_max = ( $on_page < $total_pages - 4 ) ? $on_page : $total_pages - 4;
				$init_page_max = ( $on_page < $total_pages - ($begin_end + $from_middle) ) ? $on_page : $total_pages - ($begin_end + $from_middle);

//echo $init_page_min."#".$init_page_max."#".$on_page;
				//for($i = $init_page_min - 1; $i < $init_page_max + 2; $i++)
				for($i = $init_page_min - $from_middle; $i < $init_page_max + ($from_middle + 1); $i++)
				{
					$page_string .= ($i == $on_page) ? '<div class="activePageNum">' . $i . '</div>' : '<a href="' . append_sid($base_url . "&amp;page_num=$i").'">'.$i. '</a>';
					//if ( $i <  $init_page_max + 1 )
					if ( $i <  $init_page_max + $from_middle )
					{
						$page_string .= ', ';
					}
				}

				//$page_string .= ( $on_page < $total_pages - 4 ) ? ' ... ' : ', ';
				$page_string .= ( $on_page < $total_pages - ($begin_end + $from_middle) ) ? ' ... ' : ', ';


			} else {
				$page_string .= ' ... ';
			}

			//for($i = $total_pages - 2; $i < $total_pages + 1; $i++)
			for($i = $total_pages - ($begin_end - 1); $i < $total_pages + 1; $i++)
			{
				$page_string .= ( $i == $on_page ) ? '<div class="activePageNum">' . $i . '</div>'  : '<a href="' . append_sid($base_url . "&amp;page_num=$i").'">' . $i . '</a>';
				if( $i <  $total_pages )
					$page_string .= ", ";
			}
		}
	} else {
		for($i = 1; $i < $total_pages + 1; $i++)
		{
			$page_string .= ( $i == $on_page ) ? '<div class="activePageNum">' . $i . '</div>': '<a href="' . append_sid($base_url . "&amp;page_num=$i").'">'.$i.'</a>';
			if ( $i <  $total_pages )
				$page_string .= ', ';
		}
	}

	if ( $add_prevnext_text )
	{
		global $themeRelPath;
		$imgNext=leoHtml::img("icon_page_next.gif",0,0,'border','','icons1');	
		$imgPrev=leoHtml::img("icon_page_next.gif",0,0,'border','','icons1');
		if ( $on_page > 1 )
			$page_string = ' <a href="' . append_sid($base_url . "&amp;page_num=" . ( $on_page - 1 )  ) . '">'.$imgPrev.'</a>&nbsp;&nbsp;'.$page_string;

		if ( $on_page < $total_pages ) 
			$page_string .= '&nbsp;&nbsp;<a href="' . append_sid($base_url . "&amp;page_num=" . ($on_page+1)   ) . '">'.$imgNext.'</a>';

	}
	$page_string = '<div class="numeration">'.$page_string.'</div>';
	return $page_string;
}

function makeFlightActionsPopup() {
	global $moduleRelPath,$opMode;
	ob_start();

?>
<script language="javascript">
var flightActionTip = new TipObj('flightActionTip');
with (flightActionTip)
{
  template = '<table bgcolor="#000000" cellpadding="0" cellspacing="0" width="%3%" border="0">' +
  '<tr><td class="infoBoxHeader"><? echo "Actions"; ?></td></tr>'+
  '<tr><td class="infoBox">'+
  "<img src='<?=$moduleRelPath?>/img/change_icon.png' width='16' height='16' border='0' align='absmiddle'> <a href='<?=getLeonardoLink(array('op'=>'edit_flight','flightID'=>'%4%'))?>'><? echo _EDIT_FLIGHT; ?></a>"+
	'</td></tr>'+
    '<tr><td class="infoBox">'+
	"<img src='<?=$moduleRelPath?>/img/x_icon.gif'  width='16' height='16' border='0' align='absmiddle'> <a href='<?=getLeonardoLink(array('op'=>'delete_flight','flightID'=>'%4%'))?>'><? echo _DELETE_FLIGHT; ?></a>"+
	'</td></tr></table>';

 tipStick = 0;
 showDelay = 0;
 hideDelay = 700;
 doFades = false;
}
</script>
<div id="flightActionTipLayer" class="shadowBox" style="position: absolute; z-index: 10000; 
visibility: hidden; left: 0px; top: 0px; width: 10px">&nbsp;</div>
<?
	$c=ob_get_contents();
	ob_end_clean();
	return  $c;
}


function makeGoogleEarthPopup() {
	global $moduleRelPath,$opMode,$CONF, $userID;
	ob_start();

?>
<script language="javascript">
var geTip = new TipObj('geTip');
with (geTip)
{
	
	var showTitle=true;
	var title='<?=_choose_ge_module?>';
	var arrowDir = "right";
	var arrowLeft = -10;
	var arrowTop = -3;
	var shadowTop = -7;
	var shadowLeft = -7;
	
	arrowDir = "right";
	// arrowLeft = tipWidth;
	arrowTop = -1;
	
	if(document.all)
		arrowLeft -= 2;
			
	template=	"<div id='BT' class='BT_shadow0' >" +
		"<div class='BT_shadow1'>"+
		"<div class='BT_shadow2'>" +
		"<div id='BT_main' style='width:%3%px; top:"+shadowTop+"px; left:"+shadowLeft+"px;'>" +
			"<div id='BT_arrow_"+arrowDir+"' style='top: "+arrowTop+"px; left:%3%px;'></div>" +
			(showTitle?"<div id='BT_title'>"+title+"</div>":"") +
			"<div style='padding:5px'>" +
				"<div id='BT_content' style='line-height:140%'>"+

				<? $icon_bullet_greenStr=leoHtml::img("icon_bullet_green.gif",0,0,'absmiddle','','icons1');?>				
				<? if ($CONF['googleEarth']['igc2kmz']['active'] && ( $CONF['googleEarth']['igc2kmz']['visible'] || L_auth::isModerator($userID) )   ) { ?>
				"<?=$icon_bullet_greenStr?><?=leoHtml::img("icon_new.png",0,0,'absmiddle','','icons1')?> <a href='<?=getDownloadLink(array('type'=>'kml_trk','an'=>'2','flightID'=>'%4%','lng'=>'%5%'))?>'><? echo 'IGC2KMZ '._ge_module_advanced_1; ?></a>"+
	'<br>'+
				<? } ?>
  "<?=$icon_bullet_greenStr?> <a href='<?=getDownloadLink(array('type'=>'kml_trk','an'=>'1','flightID'=>'%4%','lng'=>'%5%'))?>'><? echo 'GPS2GE V2.0 '._ge_module_advanced_2; ?></a>"+
	'<br>'+

  "<?=$icon_bullet_greenStr?> <a href='<?=getDownloadLink(array('type'=>'kml_trk','an'=>'0','flightID'=>'%4%','lng'=>'%5%'))?>'><?=_ge_module_Simple ?></a>"+
  
					
				"</div>" +
			"</div>"+
			"<div id='BT_bottom_arrow_"+arrowDir+"' style='display:none; top: 30px; left:"+arrowLeft+"px;'></div>" +
		"</div></div></div></div>";

 tipStick = 0;
 showDelay = 0;
 hideDelay = 500;
 doFades = false;
}
</script>
<div id="geTipLayer" class="shadowBox" style="position: absolute; z-index: 10000; 
visibility: hidden; left: 0px; top: 0px; width: 10px">&nbsp;</div>
<?
	$c=ob_get_contents();
	ob_end_clean();
	return  $c;
}

function makePilotPopup() {
	global $moduleRelPath,$opMode;
	ob_start();

?>
<script language="javascript">
var pilotTip = new TipObj('pilotTip');
with (pilotTip)
{
  template = '<table bgcolor="#000000" cellpadding="0" cellspacing="0" width="250" border="0">' +
  '<tr><td class="infoBoxHeader">%5%</td></tr>'+
  '<tr><td class="infoBox">'+
  "<img src='<?=$moduleRelPath?>/img/icon_pilot.gif' border=0 align='absmiddle'> <a href='<?=getLeonardoLink(array('op'=>'pilot_profile','pilotIDview'=>'%4%')  )?>'><? echo _Pilot_Profile ?></a>"+
	'</td></tr>'+
    '<tr><td class="infoBox">'+

	"<img src='<?=$moduleRelPath?>/img/icon_magnify_small.gif' border=0 align='absmiddle'> <a href='<?=getLeonardoLink(array('op'=>'list_flights','pilotID'=>'%4%') ) ?>'><? echo _PILOT_FLIGHTS .' ('._MENU_FILTER.')'?></a>"+
	'</td></tr>'+
    '<tr><td class="infoBox">'+

	"<img src='<?=$moduleRelPath?>/img/icon_magnify_small.gif' border=0 align='absmiddle'> <a href='<?=getLeonardoLink(array('op'=>'list_flights','pilotID'=>'%4%',
	'year'=>'0','month'=>'0','takeoffID'=>'0','country'=>'0','cat'=>'0') ) ?>'><? echo _PILOT_FLIGHTS.' ('._ALL.')' ?></a>"+
	'</td></tr>'+
    '<tr><td class="infoBox">'+
	
	"<img src='<?=$moduleRelPath?>/img/icon_stats.gif' border=0 align='absmiddle'> <a href='<?=getLeonardoLink(array('op'=>'pilot_profile_stats','pilotID'=>'%4%')  )?>'><? echo _flights_stats ?></a>"+

	'</td></tr>'+
    '<tr><td class="infoBox">'+
	"<img src='<?=$moduleRelPath?>/img/icons1/rss.gif' alt='RSS pilot feed' width=16 height=16 border=0 align='absmiddle'> <a href='<?=$moduleRelPath."/rss.php?op=latest&pilot=%4%"?>'><? echo _RSS_of_pilots_flights ?></a>"+
	
	<?  if ($opMode==2)  { ?>// phpbb only 
	'</td></tr>'+
    '<tr><td class="infoBox">'+
	"<img src='<?=$moduleRelPath?>/img/icon_user.gif' alt='PM this user' width=16 height=16 border=0 align='absmiddle'> <a href='/privmsg.php?mode=post&u=%4%'><? echo "PM" ?></a>"+
    <? } ?>

	'</td></tr></table>';

 tipStick = 0;
 showDelay = 0;
 hideDelay = 0;
 doFades = false;
}

var pilotTipExt = new TipObj('pilotTipExt');
with (pilotTipExt)
{
  template = '<table bgcolor="#000000" cellpadding="0" cellspacing="0" width="250" border="0">' +
  '<tr><td class="infoBoxHeader">%5%</td></tr>'+
    '<tr><td class="infoBox">'+


	"<img src='<?=$moduleRelPath?>/img/icon_magnify_small.gif' border=0 align='absmiddle'> <a href='<?=getLeonardoLink(array('op'=>'list_flights','pilotID'=>'%4%') ) ?>'><? echo _PILOT_FLIGHTS .' ('._MENU_FILTER.')'?></a>"+
	'</td></tr>'+
    '<tr><td class="infoBox">'+

	"<img src='<?=$moduleRelPath?>/img/icon_magnify_small.gif' border=0 align='absmiddle'> <a href='<?=getLeonardoLink(array('op'=>'list_flights','pilotID'=>'%4%',
	'year'=>'0','month'=>'0','takeoffID'=>'0','country'=>'0','cat'=>'0') ) ?>'><? echo _PILOT_FLIGHTS.' ('._ALL.')' ?></a>"+
	'</td></tr>'+
    '<tr><td class="infoBox">'+
	

	"<img src='<?=$moduleRelPath?>/img/icon_stats.gif' border=0 align='absmiddle'> <a href='<?=getLeonardoLink(array('op'=>'pilot_profile_stats','pilotIDview'=>'%4%')  )?>'><? echo _flights_stats ?></a>"+


	'</td></tr></table>';

 tipStick = 0;
 showDelay = 0;
 hideDelay = 0;
 doFades = false;
}

</script>
<div id="pilotTipLayer" class="shadowBox" style="position: absolute; z-index: 10000; 
visibility: hidden; left: 0px; top: 0px; width: 10px">&nbsp;</div>

<div id="pilotTipExtLayer" class="shadowBox" style="position: absolute; z-index: 10000; 
visibility: hidden; left: 0px; top: 0px; width: 10px">&nbsp;</div>

<?
	$c=ob_get_contents();
	ob_end_clean();
	return  $c;
}

function makeTakeoffPopup($ext=0,$userID=0) {
	global $moduleRelPath;
	ob_start();

?>
<script language="javascript">
var takeoffTip = new TipObj('takeoffTip');
with (takeoffTip)
{
 template = '<table bgcolor="#000000" cellpadding="0" cellspacing="0" width="%3%" border="0">' +
  '<tr><td class="infoBoxHeader">%5%</td></tr>'+
  '<tr><td class="infoBox">'+
  
  
  	"<img src='<?=$moduleRelPath?>/img/icon_magnify_small.gif' align='absmiddle' border=0> <a href='<?=
	getLeonardoLink(array('op'=>'list_flights','takeoffID'=>'%4%')  )?>'><? echo  _See_flights_near_this_point.' ('._MENU_FILTER.')' ?></a>"+
	'</td></tr>'+
    '<tr><td  class="infoBox">'+
	
	"<img src='<?=$moduleRelPath?>/img/icon_magnify_small.gif' align='absmiddle' border=0> <a href='<?=
	getLeonardoLink(array('op'=>'list_flights','takeoffID'=>'%4%',
	'year'=>'0','month'=>'0','pilotID'=>'0','country'=>'0','cat'=>'0')  )?>'><? echo  _See_flights_near_this_point.' ('._ALL.')' ?></a>"+
	'</td></tr>'+
    '<tr><td  class="infoBox">'+
	
	"<img src='<?=$moduleRelPath?>/img/icon_pin.png' align='absmiddle' border=0> <a href='<?=getLeonardoLink(array('op'=>'show_waypoint','waypointIDview'=>'%4%'))?>'><? echo _SITE_INFO  ?></a>"+
	'</td></tr>'+
    '<tr><td  class="infoBox">'+
	"<img src='<?=$moduleRelPath?>/img/gearth_icon.png' align='absmiddle' border=0> <a href='<?=getDownloadLink(array('type'=>'kml_wpt','wptID'=>'%4%'))?>'><? echo _Navigate_with_Google_Earth ?></a>"+
	<? if ( $ext && L_auth::isAdmin($userID) ) { ?>
    '</td></tr><tr><td class="infoBox adminBox">'+
	 "<img src='<?=$moduleRelPath?>/img/icon_add.png' align='absmiddle' border=0> <a href='javascript:add_takeoff(%6%,%7%,%4%)'><?=_ADD_WAYPOINT?></a>"+

     '</td></tr><tr><td class="infoBox adminBox">'+
	 "<img src='<?=$moduleRelPath?>/img/change_icon.png' align='absmiddle' border=0> <a href='javascript:edit_takeoff(%4%)'><?=_EDIT_WAYPOINT?></a>"+

     '</td></tr><tr><td class="infoBox adminBox">'+
	 "<img src='<?=$moduleRelPath?>/img/x_icon.gif' align='absmiddle' border=0> <a href='javascript:delete_takeoff(%4%)'><?=_DELETE_WAYPOINT?></a>"+

	<? } ?>
	'</td></tr></table>';

 tipStick = 0;
 showDelay = 0;
 hideDelay = 0;
 doFades = false;
}
</script>
<div id="takeoffTipLayer" class="shadowBox" style="position: absolute; z-index: 10000; visibility: hidden; left: 0px; top: 0px; width: 10px">&nbsp;</div>
<?
	$c=ob_get_contents();
	ob_end_clean();
	return  $c;
}

function prepare_for_js($name) {
	$name=str_replace("&#039;","'",$name); 
	$name=str_replace("\"","'",$name); 
	// $name=str_replace("'","\'",$name);
	return $name;
}


function flush2Browser() {

// first version 
/*
  echo str_pad(" ",4096," ");
  flush();
  ob_flush();
  while (@ ob_end_flush());
*/

// second version 
	// ob_implicit_flush(1) ;

	/*for($i = 0; $i < 200; $i++){
		print "<!-- bufferme -->\n";
	}*/	

// third version
	?>
	<script language="javascript">		
		for(i=0;i<100;i++) {
			document.writeln("<!-- NULL -->");
		}		
	</script>
	<?
    flush();
	// this breaks in lighttpd
 	//while (@ob_end_flush()); 
	
	//ob_end_flush();
	//	ob_start();	

}
?>

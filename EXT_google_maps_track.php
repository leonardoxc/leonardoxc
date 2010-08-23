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
// $Id: EXT_google_maps_track.php,v 1.53 2010/08/23 09:21:51 manolis Exp $                                                                 
//
//************************************************************************

 	require_once dirname(__FILE__)."/EXT_config_pre.php";
	require_once dirname(__FILE__)."/config.php";
	$CONF_use_utf=1;
 	require_once dirname(__FILE__)."/EXT_config.php";

	require_once dirname(__FILE__)."/CL_flightData.php";
	require_once dirname(__FILE__)."/FN_functions.php";	
	require_once dirname(__FILE__)."/FN_waypoint.php";	
	require_once dirname(__FILE__)."/FN_output.php";
	require_once dirname(__FILE__)."/FN_pilot.php";
	//	setDEBUGfromGET();
	
	$flightID=makeSane($_GET['id'],1);
	if ($flightID<=0) exit;
	
	$flight=new flight();
	$flight->getFlightFromDB($flightID,0);
	
	$flight->makeJSON(0);  // no force

	// we dont use png files any more
	//$flight->updateCharts(0,1); // no force update, raw charts

	if ($flight->is3D() &&  is_file($flight->getChartfilename("alt",$PREFS->metricSystem,1))) {
		$chart1= $flight->getChartRelPath("alt",$PREFS->metricSystem,1);
		$title1=_Altitude.' ('.(($PREFS->metricSystem==1)?_M:_FT).')';
	} else if ( is_file($flight->getChartfilename("takeoff_distance",$PREFS->metricSystem,1)) ) {
		$chart1=$flight->getChartRelPath("takeoff_distance",$PREFS->metricSystem,1);
		$title1=_Distance_from_takeoff.' ('.(($PREFS->metricSystem==1)?_KM_PER_HR:_MPH).')';
	}

	$hlines=$flight->getRawHeader();
	foreach($hlines as $line) {
		if (strlen($line) == 0) continue;	  
		eval($line);
	}
	
	$START_TIME=$flight->START_TIME;
	$END_TIME=$flight->END_TIME;
	$DURATION=$END_TIME-$START_TIME;
	
//	$START_TIME=$min_time;
//	$END_TIME=$max_time;
//	$DURATION=$END_TIME-$START_TIME;

 
	$lang_enc='utf-8';

	# martin jursa 22.06.2008: enable configuration of map type
	$GMapType='G_SATELLITE_MAP';
	if ( in_array( $CONF['google_maps']['default_maptype'],
			 array('G_NORMAL_MAP', 'G_HYBRID_MAP', 'G_PHYSICAL_MAP', 'G_SATELLITE_MAP','G_SATELLITE_3D_MAP'))) {
		$GMapType= $CONF['google_maps']['default_maptype'];
	}

	if ( ( $CONF_airspaceChecks && L_auth::isAdmin($userID) ) || $CONF['thermals']['enable'] ) { 
		// find min/max lat/lon
		$filename=$flight->getIGCFilename();
		$lines = file ($filename); 
		if (!$lines) { echo "Cant read file"; return; }
		$i=0;
	
		// find bounding box of flight
		$min_lat=1000;
		$max_lat=-1000;
		$min_lon=1000;
		$max_lon=-1000;
		foreach($lines as $line) {
			$line=trim($line);
			if  (strlen($line)==0) continue;				
			if ($line{0}=='B') {
					if  ( strlen($line) < 23 ) 	continue;
					$thisPoint=new gpsPoint($line,0);
					if ( $thisPoint->lat  > $max_lat )  $max_lat =$thisPoint->lat  ;
					if ( $thisPoint->lat  < $min_lat )  $min_lat =$thisPoint->lat  ;
					if ( -$thisPoint->lon  > $max_lon )  $max_lon =-$thisPoint->lon  ;
					if ( -$thisPoint->lon  < $min_lon )  $min_lon =-$thisPoint->lon  ;
			}
		}
	}

?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lang_enc?>">
<title>Google Maps</title>
<link rel='stylesheet' type='text/css' href='<?=$themeRelPath?>/css/google_maps.css' />
<script src="http://maps.google.com/maps?file=api&v=2.x&key=<?=$CONF_google_maps_api_key ?>" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/DHTML_functions.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/AJAX_functions.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/google_maps/gmaps.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/google_maps/polyline.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/jquery.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/xns.js" type="text/javascript"></script>

<? if ( $CONF['thermals']['enable']  ) { ?>
<script src="<?=$moduleRelPath?>/js/ClusterMarkerCustomIcon.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/google_maps/thermals.js" type="text/javascript"></script>
<? } ?>
<? if ($CONF['airspace']['enable']) { ?>
<script src="<?=$moduleRelPath?>/js/google_maps/airspace.js" type="text/javascript"></script>
<? } ?>

<script src="js/chartFX/wz_jsgraphics.js"></script>
<script src='js/chartFX/excanvas.js'></script>
<script src='js/chartFX/chart.js'></script>
<script src="js/chartFX/jgchartpainter.js"></script>
<script src='js/chartFX/canvaschartpainter.js'></script>

<script type="text/javascript">
	function toogleGmapsFullScreen () {
		window.parent.toogleGmapsFullScreen() ;
	}
</script>

<link rel="stylesheet" type="text/css" href="js/chartFX/canvaschart.css">

</head>
<body  onUnload="GUnload()">

<table border="0" cellpadding="0" cellspacing="0" class="mapTable">
  <tr>
	<td colspan=2 valign="top"><div style="position: relative; width: 745px; height:120px;"> 
	  <div style="position: absolute; top: 6px; left: 40px; z-index: 100; 
	  				height:95px;  width:2px; background-color:#44FF44;" 
				  id="timeLine1"></div>
	   
	  <div style="position: absolute; float:right; right:4px; top: 0px; z-index: 150; padding-right:4px; text-align:right; height:12px; width:110px; border:0px solid #777777;  background-color:none; color:FF3333;" 
	  id="timeBar"><?=$title1?></div>

	  <div id="chart" class="chart" style="width: 745px; height: 120px;" ></div>
	</div></td>
	</tr>
	<tr>
		<td valign="top"><div id="map"></div></td>
		<td valign="top">
		<form name="form1" method="post" action="">
		<div style="display:block">
		

		<div style="position:relative; float:right; clear:both; margin-top:8px">
			<a href='javascript:toogleFullScreen();'><img src='img/icon_maximize.gif' border=0></a>
		</div>
		<br>
 		<fieldset class="legendBox"><legend><?=_Info?></legend><BR />
			<table align="center" cellpadding="2" cellspacing="0">
				<TR><td><div align="left"><?=_Time_Short?>:</div></td><TD width=75><span id="timeText1" class='infoString'>-</span></TD></TR>
				<TR><td><div align="left"><?=_Speed?>:</div></td><TD><span id='speed' class='infoString'>-</span></TD></TR>
				<TR><td><div align="left"><?=_Altitude_Short?>:</div></td><TD><span id='alt' class='infoString'>-</span></TD></TR>
				<TR><td><div align="left"><?=_Vario_Short?>:</div></td><TD><span id='vario' class='infoString'>-</span></TD></TR>
		</table>
		</fieldset>


		<fieldset class="legendBox"><legend><?=_Control?></legend><BR />
	
		<a href='javascript:zoomToFlight()'><?=_Zoom_to_flight?></a><hr />
		<div id="side_bar">
		</div> 
		<hr>
		<input type="checkbox" value="1" id='followGlider' onClick="toggleFollow(this)"><?=_Follow_Glider?><br>
		<input type="checkbox" value="1" checked id='showTask' onClick="toggleTask(this)"><?=_Show_Task?><br>
		<? if ($CONF_airspaceChecks && (L_auth::isAdmin($userID) || $flight->belongsToUser($userID))  ) { ?>
			<input type="checkbox" value="1"  checked="checked" id='airspaceShow' onClick="toggleAirspace('airspaceShow',true)"><?=_Show_Airspace?>
		<?  } ?>
		</fieldset>
        
		<? if ( $CONF['thermals']['enable']  ) { ?>
		<fieldset id='themalBox' class="legendBox"><legend><?=_Thermals?></legend>
         <div id='thermalLoad'><a href='javascript:loadThermals("<?=_Loading_thermals?><BR>")'><?=_Load_Thermals?></a></div>
         <div id='thermalLoading' style="display:none"></div>
         <div id='thermalControls' style="display:none">
	      <input type="checkbox" id="1_box" onClick="boxclick(this,'1')" /> A Class <BR>
          <input type="checkbox" id="2_box" onClick="boxclick(this,'2')" /> B Class<BR>
          <input type="checkbox" id="3_box" onClick="boxclick(this,'3')" /> C Class<BR>
          <input type="checkbox" id="4_box" onClick="boxclick(this,'4')" /> D Class<BR>
          <input type="checkbox" id="5_box" onClick="boxclick(this,'5')" /> E Class<BR>
         </div>
		</fieldset>
        <? } ?>
		</div>
    </form>
	</td>

  </tr>
</table>
<div id="pdmarkerwork"></div>

<div id="photoDiv" style="position:absolute;display:none;z-index:110;"></div>

<script type="text/javascript">

$(document).ready(function(){
	  $("#chart").bind('mousemove',
		function(e){ 
			// var x=e.clientX ;
			var x=e.pageX ;				
			CurrTime[1] = (x -marginLeft) * EndTime / (ImgW-marginLeft-marginRight);			
			SetTimer();
		});

});

var wpID=<?=$flight->takeoffID?>;
var relpath="<?=$moduleRelPath?>";
var polylineURL="<?=$flight->getPolylineRelPath() ?>";
// var jsonURL="<?=$flight->getJsonRelPath() ?>";
var markerBg="img/icon_cat_<?=$flight->cat?>.png";
var posMarker;

var followGlider=0;
var airspaceShow=1;
var showTask=1;
var taskLayer=[];

var metricSystem=<?=$PREFS->metricSystem?>;

var takeoffString="<? echo _TAKEOFF_LOCATION ?>";
var landingString="<? echo _LANDING_LOCATION ?>";

var altUnits="<? echo ' '.(($PREFS->metricSystem==1)?_M:_FT) ; ?>";
var speedUnits="<? echo ' '.(($PREFS->metricSystem==1)?_KM_PER_HR:_MPH) ; ?>";
var varioUnits="<? echo ' '.(($PREFS->metricSystem==1)?_M_PER_SEC:_FPM) ; ?>";

var ImgW = 745;
var StartTime = <?=$START_TIME?> ;
var EndTime = <?=$DURATION?> ;
var Duration = <?=$DURATION?> ;


var timeLine=new Array();
timeLine[1] = document.getElementById("timeLine1").style;

var marginLeft=37;
var marginRight=5;


var flight={ "time":[],"elev":[],"elevGnd":[],"lat":[],"lon":[],"speed":[],"vario":[],"distance":[] , "labels":[] };
	
var CurrTime=new Array();
CurrTime[1] = 0;
CurrTime[2] = EndTime;
DisplayCrosshair(1);

var lat=0;
var lon=0;
</script>

<script src="<?=$flight->getJsonRelPath()?>" type="text/javascript"></script>

<script type="text/javascript">
	
	var map = new GMap2(document.getElementById("map"),   {mapTypes:[G_HYBRID_MAP,G_PHYSICAL_MAP,G_SATELLITE_MAP,G_NORMAL_MAP,G_SATELLITE_3D_MAP]}); 

	//	    map.addMapType(G_PHYSICAL_MAP) ;
	map.addControl(new GLargeMapControl());
	map.addControl(new GMapTypeControl());
	map.setCenter (new GLatLng(0,0), 4, <?=$GMapType?>);
/*
TODO move to API v3 !!!!
*/

	//var kmlOverlay = new GGeoXml("http://pgforum.thenet.gr/modules/leonardo/download.php?type=kml_task&flightID=14142&t=a.kml");
	// var kmlOverlay = new GGeoXml("http://pgforum.thenet.gr/modules/leonardo/download.php?type=kml_trk&flightID=14722&lang=english&w=2&c=FF0000&an=1&t=a.kml");
	// var kmlOverlay = new GGeoXml("http://pgforum.thenet.gr/1.kml");
	// map.addOverlay(kmlOverlay);

	var tp = <? echo $flight->gMapsGetTaskJS(); ?> ;
	
	displayTask(tp);
	
	GDownloadUrl(polylineURL, process_polyline);
		
	function drawChart() {
		// trim off points before start / after end
		var j=0;
		flight.points_num=0;
		flight.max_alt=0;
		flight.min_alt=100000;
		
		for(i=0;i<flightArray.time.length;i++) {		
				if (flightArray.time[i]>=StartTime && flightArray.time[i]<= StartTime + Duration) {
					flight.time[j]=sec2Time(flightArray.time[i]);
					flight.elev[j]=flightArray.elev[i];
					flight.elevGnd[j]=flightArray.elevGnd[i];
					flight.lat[j]=flightArray.lat[i];
					flight.lon[j]=flightArray.lon[i];
					flight.speed[j]=flightArray.speed[i];
					flight.vario[j]=flightArray.vario[i];
					flight.distance[j]=flightArray.distance[i];

					// for testing
					// flight.elevGnd[j]=800;
					if (j==0) {
							lat=flight.lat[j]=flightArray.lat[i];
							lon=flight.lon[j]=flightArray.lon[i];
					}else {
                      	//P.Wild ground height hack  3.4.08
                    	if ( flight.elevGnd[j] == 0) flight.elevGnd[j] = (flight.elevGnd[j-1] *0.95 ) + (flight.elevGnd[j-1]* 0.1* (Math.random()));

					}

					if ( flight.elev[j] > flight.max_alt ) flight.max_alt=flight.elev[j];
					if ( flight.elevGnd[j] > flight.max_alt ) flight.max_alt=flight.elevGnd[j];
					if ( flight.elev[j] < flight.min_alt ) flight.min_alt=flight.elev[j];
					if ( flight.elevGnd[j] < flight.min_alt ) flight.min_alt=flight.elevGnd[j];
					flight.points_num++;
					j++;
				}
		}
		flight.label_num=flightArray.label_num;

		var nbPts=flight.time.length;
		var label_num=flight.label_num;
		var idx = 0;
		var step = Math.floor( (nbPts - 1) / (label_num - 1) );
		
		for (i = 0 ; i < label_num; i++) {
			flight.labels[i] = flight.time[idx];
			idx += step;
		}
		
		// flight.labels=flightArray.labels;
		
		// var flightArray = eval("(" + jsonString + ")");		

		// add some spaces to the last legend
		flight.labels[flight.labels.length-1]+='   ___';
		
		if (metricSystem==2) {
			for(i=0;i<flight.elev.length;i++) {
				flight.elev[i]*=3.28;
				flight.elevGnd[i]*=3.28;
			}
			flight.max_alt*=3.28;
			flight.min_alt*=3.28;
		}
		
		var min_alt=Math.floor( (flight.min_alt/100.0) )  * 100 ;
		var max_alt=Math.ceil( (flight.max_alt/100.0) ) * 100  ;
		
		var ver_label_num=5;
		// smart code to  compute vertival label num so to be mulitple of 100
		//if ( ( (max_alt-min_alt)/ver_label_num) != Math.floor((max_alt-min_alt)/  ver_label_num ) ) 
		//		ver_label_num++;

		var c = new Chart(document.getElementById('chart'));
		c.setDefaultType(CHART_LINE );

		c.setGridDensity(flight.label_num,ver_label_num);
		c.setVerticalRange( min_alt ,max_alt  );
		c.setShowLegend(false);
		c.setLabelPrecision(0);
		c.setHorizontalLabels(flight.labels);
		c.add('Altitude',     '#FF3333', flight.elev);
		c.add('Ground Elev',  '#C0AF9C', flight.elevGnd,CHART_AREA);
		c.draw();
	}



	drawChart();
	//	getAjax(jsonURL,null,drawChart );
	//window.onload = function() {
	//	ieCanvasInit('js/chartFX/iecanvas.htc');
	//	draw(); 
	//};
	
	// Creates a marker whose info window displays the given description 
	function createWaypoint(point, id , description, iconUrl, shadowUrl ) {
		if (iconUrl){
			var baseIcon = new GIcon();
			
			var sizeFactor;
			if (id==wpID) sizeFactor=1.1;
			else sizeFactor=1;
			
			baseIcon.iconSize=new GSize(24*sizeFactor,24*sizeFactor);
			baseIcon.shadowSize=new GSize(42*sizeFactor,24*sizeFactor);
			baseIcon.iconAnchor=new GPoint(12*sizeFactor,24*sizeFactor);
			baseIcon.infoWindowAnchor=new GPoint(12*sizeFactor,0);
			  
			var newIcon = new GIcon(baseIcon, iconUrl, null,shadowUrl);
				
			var marker = new GMarker(point,newIcon);
		} else {
			var marker = new GMarker(point);		
		}	

		GEvent.addListener(marker, "click", function() {
	  		getAjax('EXT_takeoff.php?op=get_info&wpID='+id,null,openMarkerInfoWindow);		
		});
	  
	  return marker;
	}

	function openMarkerInfoWindow(jsonString) {
		var results= eval("(" + jsonString + ")");			
		var i=results.takeoffID;
		var html=results.html;
		takeoffMarkers[i].openInfoWindowHtml(html);
	}
	
	var takeoffMarkers=[];
		
	function drawTakeoffs(jsonString){
	 	var results= eval("(" + jsonString + ")");		
		// document.writeln(results.waypoints.length);
		for(i=0;i<results.waypoints.length;i++) {	
			var takeoffPoint= new GLatLng(results.waypoints[i].lat, results.waypoints[i].lon) ;
			
			if (results.waypoints[i].id ==wpID ) {
				var iconUrl		= "http://maps.google.com/mapfiles/kml/pal2/icon5.png";
				var shadowUrl	= "http://maps.google.com/mapfiles/kml/pal2/icon5s.png";
			} else if (results.waypoints[i].type<1000) {
				var iconUrl		= "http://maps.google.com/mapfiles/kml/pal3/icon21.png";
				var shadowUrl	= "http://maps.google.com/mapfiles/kml/pal3/icon21s.png";
			} else {
				var iconUrl		= "http://maps.google.com/mapfiles/kml/pal2/icon13.png";
				var shadowUrl	= "http://maps.google.com/mapfiles/kml/pal2/icon13s.png";		
			}
			
			var takeoffMarker= createWaypoint(takeoffPoint,results.waypoints[i].id, results.waypoints[i].name,iconUrl,shadowUrl);
			takeoffMarkers[takeoffPoint,results.waypoints[i].id] = takeoffMarker;
			map.addOverlay(takeoffMarker);
		}	
	}

	getAjax('EXT_takeoff.php?op=get_nearest&lat='+lat+'&lon='+lon,null,drawTakeoffs);

	function hidePhoto() {
		$('#photoDiv').hide();
	}	
	function showPhoto(img,img2num,thw,thh){					
		var divWidth='';
		if ( parseInt(thw)+2 >2 ) divWidth='width:'+(parseInt(thw)+2)+'px;';
		var iconX=10;
		var iconY=10;			
		$('#photoDiv').html('<table><tr><td><div align="right"><a href="javascript:hidePhoto();"><img src="img/icon_x_white.gif" border="0"></a></div></td></tr><tr><td><div style="background-color: #000000; layer-background-color: #000000; border: 0pt none #000000; padding: 0pt; '+divWidth+'"><div style="background-color: #FFFFFF; layer-background-color: #FFFFFF; border: 1px solid #000000; background-image: url(images/img_load.gif); background-repeat: no-repeat;"><center><a border="0" href="'+img+'" target=_blank><img src="'+img+'" border="0" width="'+thw+'" height="'+thh+'"></a></center></div></div></td></tr></table>').css({left: iconX+"px", top: iconY+"px"}).show();

	}
	
	var photoMarkers=[];
	function createPhotoMarker(photoPoint,num,imgIcon,imgBig,width,height){
			var imgStr="<img id='photo$num' src='"+imgIcon+"' class=\"photos\" border=\"0\">";
			var html="<a class='shadowBox imgBox' href='javascript:showPhoto(\""+imgBig+"\","+num+","+width+","+height+");' >"+imgStr+"</a>";			
			
			var Icon = new GIcon(G_DEFAULT_ICON, 'img/icon_photo_pinned.png');
			Icon.iconSize=new GSize(32,32);
			Icon.shadowSize=new GSize(32,32);
			Icon.iconAnchor=new GPoint(16,32);
			Icon.infoWindowAnchor=new GPoint(16,0);
		
			var marker = new GMarker(photoPoint,Icon);
			GEvent.addListener(marker, "click", function() {
			   marker.openInfoWindowHtml(html);
			});	
			return marker;
			
	}
	function drawPhoto(lat,lon,num,imgIcon,imgBig,width,height){ 	
			var photoPoint= new GLatLng(lat, lon) ;			
			var photoMarker = createPhotoMarker(photoPoint,num,imgIcon,imgBig,width,height);
			photoMarkers[num] = photoMarker ;	
			map.addOverlay(photoMarker );

	}
<?
	// draw the photo positions if any
if ($flight->hasPhotos) {
	require_once dirname(__FILE__)."/CL_flightPhotos.php";

	$flightPhotos=new flightPhotos($flight->flightID);
	$flightPhotos->getFromDB();

	// get geoinfo
	$flightPhotos->computeGeoInfo();

	$imagesHtml="";
	foreach ( $flightPhotos->photos as $photoNum=>$photoInfo) {
		
		if ($photoInfo['lat'] && $photoInfo['lon'] ) {
			$imgIconRel=$flightPhotos->getPhotoRelPath($photoNum).".icon.jpg";
			$imgBigRel=$flightPhotos->getPhotoRelPath($photoNum);
	
			$imgIcon=$flightPhotos->getPhotoAbsPath($photoNum).".icon.jpg";
			$imgBig=$flightPhotos->getPhotoAbsPath($photoNum);

			if (file_exists($imgBig) ) {
				list($width, $height, $type, $attr) = getimagesize($imgBig);
				list($width, $height)=CLimage::getJPG_NewSize($CONF['photos']['mid']['max_width'], $CONF['photos']['mid']['max_height'], $width, $height);
				$imgTarget=$imgBigRel;
			} else 	if (file_exists($imgIcon) ) {
				list($width, $height, $type, $attr) = getimagesize($imgIcon);
				list($width, $height)=CLimage::getJPG_NewSize($CONF['photos']['mid']['max_width'], $CONF['photos']['mid']['max_height'], $width, $height);
				$imgTarget=$imgIconRel;
			} 

			echo " 	drawPhoto(".$photoInfo['lat'].",".$photoInfo['lon'].",$photoNum,'$imgIconRel','$imgTarget',$width,$height); \n";
		}		
	}
}
	
?>
	
	<? if ($CONF_airspaceChecks && (L_auth::isAdmin($userID) || $flight->belongsToUser($userID))  ) { ?>
	 // $("#airspaceShow").attr('checked', true);
	  // $("#airspaceShow").trigger('click');
	 // $("#airspaceShow").click();
		min_lat=<?=$min_lat?>;
		max_lat=<?=$max_lat?>;
		min_lon=<?=$min_lon?>;
		max_lon=<?=$max_lon?>;

		toggleAirspace("airspaceShow",false);
	<? } ?>	
</script>

</body>
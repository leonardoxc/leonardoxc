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
// $Id: EXT_google_maps_browser.php,v 1.6 2010/03/18 22:46:50 manolis Exp $                                                                 
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
	
 
	$lang_enc='utf-8';

	# martin jursa 22.06.2008: enable configuration of map type
	$GMapType='G_SATELLITE_MAP';
	if ( in_array( $CONF['google_maps']['default_maptype'],
			 array('G_NORMAL_MAP', 'G_HYBRID_MAP', 'G_PHYSICAL_MAP', 'G_SATELLITE_MAP','G_SATELLITE_3D_MAP'))) {
		$GMapType= $CONF['google_maps']['default_maptype'];
	}

	$min_lat=40;
	$max_lat=41;
	$min_lon=21;
	$max_lon=22;
		
	$lat=40.5;
	$lon=22.8;

?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lang_enc?>">
<title>Leonardo XC flights browser</title>
<link rel='stylesheet' type='text/css' href='<?=$themeRelPath?>/css/google_maps.css' />
<script src="http://maps.google.com/maps?file=api&v=2.x&key=<?=$CONF_google_maps_api_key ?>" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/DHTML_functions.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/AJAX_functions.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/google_maps/gmaps.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/google_maps/polyline.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/jquery.js" type="text/javascript"></script>

<? if ( $CONF['thermals']['enable']  ) { ?>
<script src="<?=$moduleRelPath?>/js/ClusterMarkerCustomIcon.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/google_maps/thermals.js" type="text/javascript"></script>
<? } ?>
<? if ($CONF['airspace']['enable']) { ?>
<script src="<?=$moduleRelPath?>/js/google_maps/airspace.js" type="text/javascript"></script>
<? } ?>

<script src="<?=$moduleRelPath?>/js/google_maps/radiusTool.js" type="text/javascript"></script>

<script src="js/chartFX/wz_jsgraphics.js"></script>
<script src='js/chartFX/excanvas.js'></script>
<script src='js/chartFX/chart.js'></script>
<script src="js/chartFX/jgchartpainter.js"></script>
<script src='js/chartFX/canvaschartpainter.js'></script>
<link rel="stylesheet" type="text/css" href="js/chartFX/canvaschart.css">

<script src="http://www.google.com/uds/api?file=uds.js&amp;v=1.0&key=ABQIAAAAxe4iZkOij75xEW-P40HsMRTNwwIDB3X2PJ0_br5ee44ut2pm8RRiA2ku6cwsTFtWlCY7kcRdnEPIDA" type="text/javascript"></script>

<script src="http://www.google.com/uds/solutions/localsearch/gmlocalsearch.js?adsense=pub-1227201690587661" type="text/javascript"></script>

<script type="text/javascript" language="JavaScript">

var localSearch = null;
var myQueryControl = null;

function toogleGmapsFullScreen () {
	window.parent.toogleGmapsFullScreen() ;
}
</script>




<style type="text/css">
<!--
  div#GQueryControl {
    background-color: white;
    width: 200;
  }
  
.gmap {
	left: 0px;
	top: 25px;
	width: 100%;
	height: 96%;
}

.gmap_controls {
	position: absolute;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 25px;
}


#more_inner {
	text-align:center;
	font-size:12px;
	background-color: #fff;
	color: #000;
	border: 1px solid #fff;
	border-right-color: #b0b0b0;
	border-bottom-color: #c0c0c0;
	width:7em;
	cursor: pointer;
}

#more_inner.highlight {
	font-weight: bold;
	border: 1px solid #483D8B;
	border-right-color: #6495ed;
	border-bottom-color: #6495ed;
}

#box {  position:absolute;
	top:20px; left:0px;
	margin-top:-1px;
	font-size:12px;
	padding: 6px 4px;
	width:120px;
	background-color: #fff;
	color: #000;
	border: 1px solid gray;
	border-top:1px solid #e2e2e2;
	display: none;
	cursor:default;
}

#box.highlight {
	width:119px;
	border-width:2px;
}

#boxlink { color: #a5a5a5;
	text-decoration: none;
	cursor: default;
	margin-left: 33px;
}

#boxlink.highlight { color: #0000cd;
	text-decoration: underline;
	cursor: pointer;
}

-->
</style>

</head>
<body  onUnload="GUnload()">
<div class="gmap" id="gmap"></div>


<div id="outer_more">

<form action="">
	<div id="box">
	
	<input name="mark" type="checkbox" onclick="switchLayer(this.checked, layers[0].obj)" /> Photos <br />
	<input name="mark" type="checkbox" onclick="switchLayer(this.checked, layers[1].obj)" /> Videos <br />
	<input name="mark" type="checkbox" onclick="switchLayer(this.checked, layers[2].obj)" /> Wikipedia <br />
	<input name="mark" type="checkbox" onclick="switchLayer(this.checked, layers[3].obj)" /> Webcams
	
	<hr style="width:92%;height:1px;border:1px;color:#e2e2e2;background-color:#e2e2e2;" />
	<a id="boxlink" href="javascript:void(0)" onclick="hideAll()">Hide all</a>
	
	</div></form>
</div>


<div class="gmap_controls" id="gmap_controls" >
	<div style="position:relative;">
		
		<div style="position:relative; float:left; clear:none; margin-top:2px">
		<? if ($CONF_airspaceChecks) { ?>
			<input type="checkbox" value="1" id='airspaceShow' onClick="toggleAirspace('airspaceShow',true)"><?=_Show_Airspace?>
			
		<?  } ?>
		<? if ( $CONF['thermals']['enable'] ) { ?>
		<fieldset id='themalBox' class="legendBox"><legend><?=_Thermals?></legend>
         <div id='thermalLoad'><a href='javascript:loadThermals("<?=_Loading_thermals?><BR>")'><?=_Load_Thermals?></a></div>
         <div id='thermalLoading' style="display:none"></div>
         <div id='thermalControls' style="display:none">
	      <input type="checkbox" id="1_box" onClick="boxclick(this,'1')" /> A Class 
          <input type="checkbox" id="2_box" onClick="boxclick(this,'2')" /> B Class 
          <input type="checkbox" id="3_box" onClick="boxclick(this,'3')" /> C Class
          <input type="checkbox" id="4_box" onClick="boxclick(this,'4')" /> D Class
          <input type="checkbox" id="5_box" onClick="boxclick(this,'5')" /> E Class
         </div>
		</fieldset>
        <? } ?>

		</div>
	
		
		<div style="position:relative; float:right; clear:none; margin-top:2px">
			<a href='javascript:toogleGmapsFullScreen();'><img src='img/icon_maximize.gif' border=0></a>
		</div>


	</div>	
</div>
<script type="text/javascript">

var markerBg="img/icon_cat_<?=$flight->cat?>.png";

var airspaceShow=1;
var metricSystem=<?=$PREFS->metricSystem?>;
var ImgW = 745;
var marginLeft=37;
var marginRight=5;

var lat=<?=$lat?>;
var lon=<?=$lon?>;

	
	var map = new GMap2(document.getElementById("gmap"),   {mapTypes:[G_HYBRID_MAP,G_PHYSICAL_MAP,G_SATELLITE_MAP,G_NORMAL_MAP,G_SATELLITE_3D_MAP]}); 

	//	    map.addMapType(G_PHYSICAL_MAP) ;
	// map.addControl(new GLargeMapControl());
	map.addControl(new GMapTypeControl());
	map.addControl(new GLargeMapControl3D());
	map.enableScrollWheelZoom();


	map.setCenter (new GLatLng(lat,lon), 8, <?=$GMapType?>);



//----------------------------------------------------------------------
// Dynamic load of flight tracks
//----------------------------------------------------------------------
	
function createFlightMarker(point, id , description) {
	var marker = new GMarker(point,flightTakeoffIcon);
	
	GEvent.addListener(marker, "click", function() {
	 	loadFlightTrack(id,point);
	 	flightMarkers[id].openInfoWindowHtml("<img src='img/ajax-loader.gif'>");	 
	 	$.ajax({ url: 'GUI_EXT_flight_info.php?op=info_short&flightID='+id, dataType: 'html',  		
			  success: function(data) { flightMarkers[id].openInfoWindowHtml(data);	}
		});
	});	
	return marker;
}
	
	
	var thisTrackColor;
	var taskPolylines=[];
	function loadFlightTrack(id,point) {
	    if ( taskPolylines[id] ) return;
		
		thisTrackColor='#'+getNextTrackColor();			
				
		$.getJSON('EXT_flight.php?op=get_task_json&flightID='+id, null , 
				function(task_json) { drawFlightTask(id,task_json,point);}		  
		);
		$.ajax({ url: 'EXT_flight.php?op=polylineURL&flightID='+id, dataType: 'text', 		  
				  success: function(polylineURL) {
				    drawFlightTrack(polylineURL);				
				}		  
		 });		
	}
	
	var polyline_color='';
	var do_process_waypoints=true;
	
	var trackColors = 
	[
	 'FF0000','00FF00','0000FF','FFFF00','FF00FF','00FFFF','EF8435','34A7F0','33F1A3','9EF133','808080',
	 'FFFFFF','000000','FFCC99', 'FFFF99' , 'CCFFFF', '99CCFF',
	 '993300','333300', '000080', '333399', '333333', '800000',
	 
	 '808000', '008000', '008080', '0000FF', '666699', '808080', 'FF0000', 'FF9900', '99CC00', '339966', 
	 '33CCCC', '3366FF', '800080', '999999', 'FF00FF', 'FFCC00', 'FFFF00', '00FF00', '00FFFF', '00CCFF', 
	 '993366', 'C0C0C0', 'FF99CC', 'FF6600'
	 ] ;
	 
	var trackColorID=-1;
	function getNextTrackColor() {
		trackColorID++;
		if (trackColorID>=trackColors.length) trackColorID=0;		
		return trackColors[trackColorID];	
	} 
 	
	 function drawFlightTask(id,task_json,point) {
		// var task= eval("(" + task_json + ")");		
		var task= eval( task_json );		
		// document.writeln(results.waypoints.length);
		
		var lines=[];
		var min_lat = 1000;
        var max_lat = -1000;
        var min_lon = 1000;
        var max_lon = -1000;
		
	 	lines[0]=point;
		for(i=0;i<task.turnpoints.length;i++) {	
			// if ( takeoffMarkers[task.turnpoints[i].id] ) continue;
		
			if (task.turnpoints[i].lat < min_lat ) min_lat = task.turnpoints[i].lat;
			if (task.turnpoints[i].lat > max_lat ) max_lat = task.turnpoints[i].lat;

			if (task.turnpoints[i].lon < min_lon ) min_lon = task.turnpoints[i].lon;
			if (task.turnpoints[i].lon > max_lon ) max_lon = task.turnpoints[i].lon;

			var takeoffPoint= new GLatLng(task.turnpoints[i].lat, task.turnpoints[i].lon) ;					
			lines[i+1]=takeoffPoint;
			/*
			var iconUrl		= "http://maps.google.com/mapfiles/kml/pal3/icon21.png";
			var shadowUrl	= "http://maps.google.com/mapfiles/kml/pal3/icon21s.png";
	
			var takeoffMarker= createWaypoint(takeoffPoint,task.turnpoints[i].id, task.turnpoints[i].name,iconUrl,shadowUrl);
			takeoffMarkers[task.turnpoints[i].id] = takeoffMarker;
			map.addOverlay(takeoffMarker);
			*/

		}
		
		color=thisTrackColor;			
		
		var polyline = new GPolyline(lines,color,1,0.5);
		map.addOverlay(polyline);
		taskPolylines[id]=polyline;
		
		center_lat=(max_lat+min_lat)/2;
		center_lon=(max_lon+min_lon)/2;
			
		bounds = new GLatLngBounds(new GLatLng(max_lat,min_lon ),new GLatLng(min_lat,max_lon));
		zoom=map.getBoundsZoomLevel(bounds);	
		map.setCenter(new GLatLng( center_lat,center_lon), zoom);
	}
	   
	
	function drawFlightTrack(polylineURL) {
		$.ajax({ url: polylineURL, dataType: 'text', 		  
				  success: function(polylineStr) {
				  	do_process_waypoints=false;
					polyline_color=thisTrackColor;
				    process_polyline(polylineStr);
				}
		  
		 });
		
	}
	
	var flightTakeoffIcon;
	var flightMarkers=[];
	function drawFlights(results){
	 	
		if (!flightTakeoffIcon) {
			var iconUrl		= "http://maps.google.com/mapfiles/kml/pal4/icon19.png";
			var shadowUrl	= "http://maps.google.com/mapfiles/kml/pal4/icon19s.png";
			var baseIcon = new GIcon();

			var sizeFactor=0.8;
			baseIcon.iconSize=new GSize(24*sizeFactor,24*sizeFactor);
			baseIcon.shadowSize=new GSize(42*sizeFactor,24*sizeFactor);
			baseIcon.iconAnchor=new GPoint(12*sizeFactor,24*sizeFactor);
			baseIcon.infoWindowAnchor=new GPoint(12*sizeFactor,0);
			  
			flightTakeoffIcon = new GIcon(baseIcon, iconUrl, null,shadowUrl);
		}	
			
		for(i=0;i<results.flights.length;i++) {	
			if ( flightMarkers[results.flights[i].flightID] ) continue;
			
			var takeoffPoint= new GLatLng(results.flights[i].firstLat, results.flights[i].firstLon) ;						
			var flightMarker= createFlightMarker(takeoffPoint,results.flights[i].flightID, results.flights[i].pilotName);
			flightMarkers[results.flights[i].flightID] = flightMarker;
			map.addOverlay(flightMarker);
		}	
	}
	
	
//----------------------------------------------------------------------
// Dynamic load of takeoffs
//----------------------------------------------------------------------
		
function createWaypoint(point, id , description, type) {
	var marker;
	if (type<1000) {
	  marker= new GMarker(point,waypointIcon1);	
	} else {
	  marker= new GMarker(point,waypointIcon2);
	}
				
	GEvent.addListener(marker, "click", function() {
		$.ajax({ url: 'EXT_takeoff.php?op=get_info&wpID='+id, dataType: 'html',  		
			  success: function(jsonString) { 			  
			 	var results= eval("(" + jsonString + ")");			
				var i=results.takeoffID;
				var html=results.html;
				takeoffMarkers[i].openInfoWindowHtml(html);
			  }
		});		
	});
	return marker;
}


var takeoffMarkers=[];
var waypointIcon1;
var waypointIcon2;
function drawTakeoffs(results){
	
	if (!waypointIcon1) {
		var baseIcon = new GIcon();			
		var sizeFactor;			
		sizeFactor=0.8;			
		baseIcon.iconSize=new GSize(24*sizeFactor,24*sizeFactor);
		baseIcon.shadowSize=new GSize(42*sizeFactor,24*sizeFactor);
		baseIcon.iconAnchor=new GPoint(12*sizeFactor,24*sizeFactor);
		baseIcon.infoWindowAnchor=new GPoint(12*sizeFactor,0);
		
		var iconUrl		= "http://maps.google.com/mapfiles/kml/pal3/icon21.png";
		var shadowUrl	= "http://maps.google.com/mapfiles/kml/pal3/icon21s.png";			
		waypointIcon1 = new GIcon(baseIcon, iconUrl, null,shadowUrl);
					
		iconUrl		= "http://maps.google.com/mapfiles/kml/pal2/icon13.png";
		shadowUrl	= "http://maps.google.com/mapfiles/kml/pal2/icon13s.png";	
		waypointIcon2 = new GIcon(baseIcon, iconUrl, null,shadowUrl);	
	}
		
	for(i=0;i<results.waypoints.length;i++) {	
		if ( takeoffMarkers[results.waypoints[i].id] ) continue;
	
		var takeoffPoint= new GLatLng(results.waypoints[i].lat, results.waypoints[i].lon) ;			
		var takeoffMarker= createWaypoint(takeoffPoint,results.waypoints[i].id, results.waypoints[i].name,results.waypoints[i].type);
		takeoffMarkers[results.waypoints[i].id] = takeoffMarker;
		map.addOverlay(takeoffMarker);
	}	
}

//----------------------------------------------------------------------
//----------------------------------------------------------------------
	var radiusKm=100;
	<? if ($PREFS->metricSystem==2) echo "metric = false; \n";
	?>

	$.getJSON('EXT_takeoff.php?op=get_nearest&lat='+lat+'&lon='+lon,null,drawTakeoffs);
	$.getJSON('EXT_flight.php?op=list_flights_json&lat='+lat+'&lon='+lon+'&distance='+radiusKm+'&from_tm=10',null,drawFlights);
	
	GEvent.addListener(map, "moveend", function() {
		var bounds = map.getBounds();
		var southWest = bounds.getSouthWest();
		var northEast = bounds.getNorthEast();
		var lngSpan = northEast.lng() - southWest.lng();
		var latSpan = northEast.lat() - southWest.lat();
		
		//lat = map.getCenter().lat();
		//lon= map.getCenter().lng(); 

		//$.getJSON('EXT_takeoff.php?op=get_nearest&lat='+lat+'&lon='+lon,null,drawTakeoffs);
		//$.getJSON('EXT_flight.php?op=list_flights_json&lat='+lat+'&lon='+lon+'&distance=200&from_tm=10',null,drawFlights);
	
	});
	  	
 // localSearch = new google.maps.LocalSearch();//{externalAds : document.getElementById("ads")});
 // map.addControl(localSearch);
  myQueryControl = new QueryControl();
  map.addControl(myQueryControl);
  
  createCircle(new GLatLng(lat, lon), radiusKm*1000);
  /*
	GEvent.addListener(map, "click", function(overlay, point) {
		if (point) {
		  singleClick = !singleClick;
		  setTimeout("if (singleClick) createCircle(new GLatLng("+ point.y + ", " + point.x +"), 250);", 300);
		}
	});
*/


	
</script>

</body>
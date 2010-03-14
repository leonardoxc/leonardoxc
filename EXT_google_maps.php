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
// $Id: EXT_google_maps.php,v 1.14 2010/03/14 20:56:10 manolis Exp $                                                                 
//
//************************************************************************

	//$module_name = basename(dirname(__FILE__));		
	//	$moduleAbsPath=dirname(__FILE__);
	//	$moduleRelPath=".";
	// require "config.php";
	
	require_once dirname(__FILE__)."/EXT_config_pre.php";
	require_once dirname(__FILE__)."/config.php";
	$CONF_use_utf=1;
 	require_once dirname(__FILE__)."/EXT_config.php";
	

	$wpLon=makeSane($_GET['lon'],1);
	$wpLat=makeSane($_GET['lat'],1);
	$wpName=makeSane($_GET['wpName']);
	$wpID=makeSane($_GET['wpID'],1);

	# martin jursa 22.06.2008: enable configuration of map type
	$GMapType='G_SATELLITE_MAP';
	if ( in_array( $CONF['google_maps']['default_maptype'],
					array('G_NORMAL_MAP', 'G_HYBRID_MAP', 'G_PHYSICAL_MAP', 'G_SATELLITE_MAP'))) {
		$GMapType= $CONF['google_maps']['default_maptype'];
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
  <head>
    <title>Google Maps</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script src="http://maps.google.com/maps?file=api&v=2&key=<?=$CONF_google_maps_api_key ?>" type="text/javascript"></script>
	<script src="<?=$moduleRelPath?>/js/AJAX_functions.js" type="text/javascript"></script>
	<style type="text/css">
	<!--
		body{margin:0}
	-->
	</style>
  </head>
<body>
<div name="map" id="map" style="width: 710px; height: 420px"></div>
<script type="text/javascript">
    //<![CDATA[
	if (GBrowserIsCompatible() ) {
		var lat=<?= $wpLat ?>;
		var lon=<?=$wpLon ?>;
		var wpID=<?=$wpID?>;
		
	// Creates a marker whose info window displays the given description 
	function createMarker(point, id , description, iconUrl, shadowUrl ) {
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
	  // Show this marker's index in the info window when it is clicked

	  
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
	
	var map = new GMap2(document.getElementById("map"),  {mapTypes:[G_NORMAL_MAP,G_HYBRID_MAP,G_PHYSICAL_MAP,G_SATELLITE_MAP]}); 

	//	map.addControl(new GSmallMapControl());
	map.addControl(new GLargeMapControl());
	map.addControl(new GMapTypeControl());
	map.addControl(new GOverviewMapControl(new GSize(200,120)));



	var takeoffPoint= new GLatLng(lat, lon) ;
	map.setCenter(takeoffPoint , 8, <?=$GMapType?>);

	var iconUrl		= "http://maps.google.com/mapfiles/kml/pal2/icon5.png";
	var shadowUrl	= "http://maps.google.com/mapfiles/kml/pal2/icon5s.png";	
			
	//	var takeoffMarker= createMarker(takeoffPoint,"<?= $wpName ?>",iconUrl,shadowUrl);
	//	map.addOverlay(takeoffMarker);
		
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
			
			var takeoffMarker= createMarker(takeoffPoint,results.waypoints[i].id, results.waypoints[i].name,iconUrl,shadowUrl);
			takeoffMarkers[takeoffPoint,results.waypoints[i].id] = takeoffMarker;
			map.addOverlay(takeoffMarker);
		}	
	}

	getAjax('EXT_takeoff.php?op=get_nearest&lat='+lat+'&lon='+lon,null,drawTakeoffs);
	

}
    //]]>
</script>
</body>
</html>
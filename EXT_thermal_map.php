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
// $Id: EXT_thermal_map.php,v 1.1 2009/02/10 16:07:50 manolis Exp $                                                                 
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
    <script src="<?=$moduleRelPath?>/js/ClusterMarker.js" type="text/javascript"></script>
  
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
		
		
		 var icon = new GIcon();
      icon.image = "http://labs.google.com/ridefinder/images/mm_20_red.png";
      icon.shadow = "http://labs.google.com/ridefinder/images/mm_20_shadow.png";
      icon.iconSize = new GSize(12, 20);
      icon.shadowSize = new GSize(22, 20);
      icon.iconAnchor = new GPoint(6, 20);
      icon.infoWindowAnchor = new GPoint(5, 1);      

      iconblue = new GIcon(icon,"http://labs.google.com/ridefinder/images/mm_20_blue.png"); 
      icongreen = new GIcon(icon,"http://labs.google.com/ridefinder/images/mm_20_green.png"); 
      iconyellow = new GIcon(icon,"http://labs.google.com/ridefinder/images/mm_20_yellow.png"); 


      function createMarker(point,name,html,class,icon) {
        var marker = new GMarker(point, {icon:icon});
        GEvent.addListener(marker, "click", function() {
          marker.openInfoWindowHtml(html);
        });
		marker.class = class;  
        return marker;
      }
	  
	        // == shows all markers of a particular category, and ensures the checkbox is checked ==
      function show(class) {
        for (var i=0; i<thermalMarkers.length; i++) {
          if (thermalMarkers[i].class == class) {
            thermalMarkers[i].show();
          }
        }
        // == check the checkbox ==
        document.getElementById(class+"_box").checked = true;
      }

      // == hides all markers of a particular category, and ensures the checkbox is cleared ==
      function hide(class) {
        for (var i=0; i<thermalMarkers.length; i++) {
          if (thermalMarkers[i].class == class) {
            thermalMarkers[i].hide();
          }
        }
        // == clear the checkbox ==
        document.getElementById(class+"_box").checked = false;
        // == close the info window, in case its open on a marker that we just hid
        map.closeInfoWindow();
      }
	  
	        // == a checkbox has been clicked ==
      function boxclick(box,class) {
        if (box.checked) {
          show(class);
        } else {
          hide(class);
        }       
      }
	  
	// Creates a marker whose info window displays the given description 
	function createMarker2(point, id , description, iconUrl, shadowUrl ) {
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

	  
	/*  GEvent.addListener(marker, "click", function() {
	  	getAjax('EXT_takeoff.php?op=get_info&wpID='+id,null,openMarkerInfoWindow);
		
	  });
	*/
	  return marker;
	}
/*
	function openMarkerInfoWindow(jsonString) {
		var results= eval("(" + jsonString + ")");			
		var i=results.takeoffID;
		var html=results.html;
		thermalMarkers[i].openInfoWindowHtml(html);
	}
	*/
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
	
	var thermalNum=new Array ();	
	
	var thermalMarkers=new Array ();


	for(i=1;i<=5;i++) { 
		thermalMarkers[i]=new Array();
		thermalNum[i]=0;
	}	
	
			
	function drawTakeoffs(jsonString){
	 	var results= eval("(" + jsonString + ")");		
		// document.writeln(results.waypoints.length);
		for(i=0;i<results.waypoints.length;i++) {	
			var takeoffPoint= new GLatLng(results.waypoints[i].lat, results.waypoints[i].lon) ;
			var icon2=icon;
			var class=results.waypoints[i].c;
			
			if (class=='A') {
				class=1;
				icon2=icon;
			} else if (class=='B') {
				class=2;
				icon2=icongreen;				
			} else if (class=='C') {
				class=3;
				icon2=iconblue;
			} else if (class=='D') {
				class=4;
				icon2=iconyellow;			
			} else {
				class=5;
				icon2=iconyellow;
				//continue;	
			}
			var climbmeters=results.waypoints[i].m;
			var climbseconds=results.waypoints[i].d;
			var climbrate=climbmeters/climbseconds;
			climbrate=climbrate.toFixed(1);
			var html="Class: " + results.waypoints[i].c+"<BR>"+
			"Climbrate: " +climbrate +" m/sec<BR>"+
			"Height Gain: " + climbmeters+" m<BR>"+
			"Duration: " + climbseconds+" secs";
			
			 var takeoffMarker = createMarker(takeoffPoint,class,html,class,icon2);
					
			//var takeoffMarker= createMarker(takeoffPoint,results.waypoints[i].id, results.waypoints[i].name,iconUrl,shadowUrl);
			thermalMarkers[class][ thermalNum[class]++ ] = takeoffMarker;
			// map.addOverlay(takeoffMarker);
		}	

		var cluster=[];
		for(i=1;i<=2;i++) { 
			cluster[i]=new ClusterMarker(map, { markers:thermalMarkers[i] } );
			cluster[i].intersectPadding=10;
			cluster[i].fitMapToMarkers();
		}	


		/*show("A");
		show("B");
        hide("C");
        hide("D");
    	hide("E");
		*/
	}

	getAjax('EXT_thermals.php?op=get_nearest&lat='+lat+'&lon='+lon,null,drawTakeoffs);
	

}
    //]]>
</script>
 <form action="#">
      > 3 m/s: <input type="checkbox" id="A_box" onclick="boxclick(this,'A')" /> &nbsp;&nbsp;
      > 2.5 m/s: <input type="checkbox" id="B_box" onclick="boxclick(this,'B')" /> &nbsp;&nbsp;
      > 1.7 m/s: <input type="checkbox" id="C_box" onclick="boxclick(this,'C')" /> &nbsp;&nbsp;
      > 1.2 m/s: <input type="checkbox" id="D_box" onclick="boxclick(this,'D')" />&nbsp;&nbsp
      > 0.5 m/s: <input type="checkbox" id="E_box" onclick="boxclick(this,'E')" /><br />
    </form>  
</body>
</html>
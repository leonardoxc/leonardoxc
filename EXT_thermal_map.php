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
// $Id: EXT_thermal_map.php,v 1.3 2010/03/14 20:56:10 manolis Exp $                                                                 
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
   	<script src="<?=$moduleRelPath?>/js/jquery.js" type="text/javascript"></script>
	<script src="<?=$moduleRelPath?>/js/AJAX_functions.js" type="text/javascript"></script>
    <script src="<?=$moduleRelPath?>/js/ClusterMarkerCustomIcon.js" type="text/javascript"></script>
  
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
		var lat=<?=$wpLat ?>;
		var lon=<?=$wpLon ?>;
		var wpID=<?=$wpID?>;

		var map = new GMap2(document.getElementById("map"),  {mapTypes:[G_NORMAL_MAP,G_HYBRID_MAP,G_PHYSICAL_MAP,G_SATELLITE_MAP]}); 

	//	map.addControl(new GSmallMapControl());
	map.addControl(new GLargeMapControl());
	map.addControl(new GMapTypeControl());
	map.addControl(new GOverviewMapControl(new GSize(200,120)));
	var takeoffPoint= new GLatLng(lat, lon) ;
	map.setCenter(takeoffPoint , 8, <?=$GMapType?>);
			
   
   
   
   
   
      function createThermalMarker(point,html,class) {
        var marker = new GMarker(point, {icon:classIcons[class]});
        GEvent.addListener(marker, "click", function() {
          marker.openInfoWindowHtml(html);
        });		
        return marker;
      }
	  	  
      function showThermalClass(class) {
	  	cluster[class].addMarkers( thermalMarkers[class] );
		cluster[class].refresh(true);
        document.getElementById(class+"_box").checked = true;
      }

      function hideThermalClass(class) {		
		cluster[class].removeMarkers();
		cluster[class].refresh(true);
        document.getElementById(class+"_box").checked = false;
        // == close the info window, in case its open on a marker that we just hid
        map.closeInfoWindow();
      }
	  
      function boxclick(box,class) {
        if (box.checked) {
          showThermalClass(class);
        } else {
          hideThermalClass(class);
        }       
      }
			
	var icon = new GIcon();
	icon.image = "img/thermals/class_1.png";
	icon.shadow = "img/thermals/class_shadow.png";
	icon.iconSize = new GSize(12, 20);
	icon.shadowSize = new GSize(22, 20);
	icon.iconAnchor = new GPoint(6, 20);
	icon.infoWindowAnchor = new GPoint(5, 1);           
	  
	var classIcons=[];
	var thermalNum=new Array ();	
	var thermalMarkers=new Array ();
	var cluster=[];

	for(i=1;i<=5;i++) { 
		thermalMarkers[i]=new Array();
		thermalNum[i]=0;
		cluster[i]=new ClusterMarker(map, { clusterClass: i,  minClusterSize:4 , clusterMarkerTitle:" Click to zoom to %count thermals" } );
		cluster[i].intersectPadding=10;
		
		classIcons[i]=new GIcon(icon,"img/thermals/class_"+i+".png"); 
	}	
	
		
	function importThermals(jsonString){
	 	var results= eval("(" + jsonString + ")");		
		// document.writeln(results.waypoints.length);
		for(i=0;i<results.waypoints.length;i++) {	
			var thermalPoint= new GLatLng(results.waypoints[i].lat, results.waypoints[i].lon) ;
			var icon2=icon;
			
			var class=results.waypoints[i].c;
			var climbmeters=results.waypoints[i].m;
			var climbseconds=results.waypoints[i].d;
			var climbrate=climbmeters/climbseconds;
			climbrate=climbrate.toFixed(1);
						
			if (class=='A') class=1;
			else if (class=='B') class=2;
			else if (class=='C') class=3;
			else if (class=='D') class=4;
			else class=5;				
			
			var html="Class: " + results.waypoints[i].c+"<BR>"+
			"Climbrate: " +climbrate +" m/sec<BR>"+
			"Height Gain: " + climbmeters+" m<BR>"+
			"Duration: " + climbseconds+" secs";
			
			var thermalMarker = createThermalMarker(thermalPoint,html,class);
			thermalMarkers[class][ thermalNum[class]++ ] = thermalMarker ;
			
		}	

		/*showThermalClass("1");
		hideThermalClass("2");
        hideThermalClass("3");
        hideThermalClass("4");
    	hideThermalClass("5");
		*/
		$("#thermalLoading").hide();
		$("#thermalLoad").hide();		
		$("#thermalControls").show();
	}


	function loadThermals() {		
		$("#thermalLoading").html("<?=_Loading_thermals?><BR><img src='img/ajax-loader.gif'>").show();
		getAjax('EXT_thermals.php?op=get_nearest&lat='+lat+'&lon='+lon,null,importThermals);
	}

}
    //]]>
</script>
		<fieldset id='themalBox' class="legendBox"><legend><?=_Thermals?></legend>
         <div id='thermalLoad'><a href='javascript:loadThermals()'><?=_Load_Thermals?></a></div>
         <div id='thermalLoading' style="display:none"></div>
         <div id='thermalControls' style="display:none">
	      <input type="checkbox" id="1_box" onClick="boxclick(this,'1')" /> A Class <BR>
          <input type="checkbox" id="2_box" onClick="boxclick(this,'2')" /> B Class<BR>
          <input type="checkbox" id="3_box" onClick="boxclick(this,'3')" /> C Class<BR>
          <input type="checkbox" id="4_box" onClick="boxclick(this,'4')" /> D Class<BR>
          <input type="checkbox" id="5_box" onClick="boxclick(this,'5')" /> E Class<BR>
         </div>
		</fieldset>
        
 
</body>
</html>
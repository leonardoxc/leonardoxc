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
// $Id: EXT_google_maps_browser.php,v 1.3 2010/03/16 21:26:25 manolis Exp $                                                                 
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
<? } ?>

<script src="js/chartFX/wz_jsgraphics.js"></script>
<script src='js/chartFX/excanvas.js'></script>
<script src='js/chartFX/chart.js'></script>
<script src="js/chartFX/jgchartpainter.js"></script>
<script src='js/chartFX/canvaschartpainter.js'></script>
<link rel="stylesheet" type="text/css" href="js/chartFX/canvaschart.css">

<script type="text/javascript">
	function toogleGmapsFullScreen () {
		window.parent.toogleGmapsFullScreen() ;
	}
	
</script>

<style type="text/css">
<!--
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

-->
</style>

</head>
<body  onUnload="GUnload()">
<div class="gmap" id="gmap"></div>

<div class="gmap_controls" id="gmap_controls" >
	<div style="position:relative;">
		
		<div style="position:relative; float:left; clear:none; margin-top:2px">
		<? if ($CONF_airspaceChecks) { ?>
			<input type="checkbox" value="1" checked id='airspaceShow' onClick="toggleAirspace(this)"><?=_Show_Airspace?>
			
		<?  } ?>
		<? if ( $CONF['thermals']['enable']  ) { ?>
		<fieldset id='themalBox' class="legendBox"><legend><?=_Thermals?></legend>
         <div id='thermalLoad'><a href='javascript:loadThermals()'><?=_Load_Thermals?></a></div>
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
	map.addControl(new GLargeMapControl());
	map.addControl(new GMapTypeControl());
	map.setCenter (new GLatLng(lat,lon), 8, <?=$GMapType?>);


	
	function createFlightMarker(point, id , description, iconUrl, shadowUrl ) {
		if (iconUrl){
			var baseIcon = new GIcon();
			
			var sizeFactor;
			sizeFactor=0.8;
			
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


/*	  
	  GEvent.addListener(marker, "click", function() {
		  loadFlightTrack(id);
	  });
*/
	  	
	 GEvent.addListener(marker, "click", function() {
		 flightMarkers[id].openInfoWindowHtml("<img src='img/ajax-loader.gif'>");	 
		 $.ajax({ url: 'GUI_EXT_flight_info.php?op=info_short&flightID='+id, dataType: 'html',  		
				  success: function(data) {
					flightMarkers[id].openInfoWindowHtml(data);	  
				  }
		  });
	  });
	  	
		
	  return marker;
	}
	
	function loadFlightTrack(id) {
		$.ajax({ url: 'EXT_flight.php?op=polylineURL&flightID='+id, dataType: 'text', 		  
				  success: function(polylineURL) {
				    drawFlightTrack(polylineURL);
					// GDownloadUrl(polylineURL, process_polyline);
				}
		  
		 });
		
	}
	
	function drawFlightTrack(polylineURL) {
		$.ajax({ url: polylineURL, dataType: 'text', 		  
				  success: function(polylineStr) {
				  	do_process_waypoints=false;
				    process_polyline(polylineStr);
				}
		  
		 });
		
	}
	
	function openFlightInfoWindow(htmlResult) {
		//var results= eval("(" + jsonString + ")");			
		//var i=results.flightID;
		//var html=results.html;
		//flightMarkers[i].openInfoWindowHtml(html);
		flightMarkers[i].openInfoWindowHtml(htmlResult);
	}
	
			
	// Creates a marker whose info window displays the given description 
	function createWaypoint(point, id , description, iconUrl, shadowUrl ) {
		if (iconUrl){
			var baseIcon = new GIcon();
			
			var sizeFactor;
			
			sizeFactor=0.8;
			
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
	  
	  GEvent.addListener(marker, "mouseover", function() {
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
			if ( takeoffMarkers[results.waypoints[i].id] ) continue;
		
			var takeoffPoint= new GLatLng(results.waypoints[i].lat, results.waypoints[i].lon) ;
			
		
			if (results.waypoints[i].type<1000) {
				var iconUrl		= "http://maps.google.com/mapfiles/kml/pal3/icon21.png";
				var shadowUrl	= "http://maps.google.com/mapfiles/kml/pal3/icon21s.png";
			} else {
				var iconUrl		= "http://maps.google.com/mapfiles/kml/pal2/icon13.png";
				var shadowUrl	= "http://maps.google.com/mapfiles/kml/pal2/icon13s.png";		
			}
			
			var takeoffMarker= createWaypoint(takeoffPoint,results.waypoints[i].id, results.waypoints[i].name,iconUrl,shadowUrl);
			takeoffMarkers[results.waypoints[i].id] = takeoffMarker;
			map.addOverlay(takeoffMarker);
		}	
	}

	var flightMarkers=[];
	function drawFlights(jsonString){
	 	var results= eval("(" + jsonString + ")");		
		// document.writeln(results.flights.length);
		for(i=0;i<results.flights.length;i++) {	
			if ( flightMarkers[results.flights[i].flightID] ) continue;
			
			var takeoffPoint= new GLatLng(results.flights[i].firstLat, results.flights[i].firstLon) ;						
			var iconUrl		= "http://maps.google.com/mapfiles/kml/pal4/icon19.png";
			var shadowUrl	= "http://maps.google.com/mapfiles/kml/pal4/icon19s.png";
			
			var flightMarker= createFlightMarker(takeoffPoint,results.flights[i].flightID, results.flights[i].pilotName,iconUrl,shadowUrl);
			flightMarkers[results.flights[i].flightID] = flightMarker;
			map.addOverlay(flightMarker);
		}	
	}


	getAjax('EXT_takeoff.php?op=get_nearest&lat='+lat+'&lon='+lon,null,drawTakeoffs);
	getAjax('EXT_flight.php?op=list_flights_json&lat='+lat+'&lon='+lon+'&distance=200&from_tm=10',null,drawFlights);
	
	GEvent.addListener(map, "moveend", function() {
		// Add 5 markers to the map at random locations
		// Note that we don't add the secret message to the marker's instance data
		var bounds = map.getBounds();
		var southWest = bounds.getSouthWest();
		var northEast = bounds.getNorthEast();
		var lngSpan = northEast.lng() - southWest.lng();
		var latSpan = northEast.lat() - southWest.lat();
		
		lat = map.getCenter().lat();
		lon= map.getCenter().lng(); 

		getAjax('EXT_takeoff.php?op=get_nearest&lat='+lat+'&lon='+lon,null,drawTakeoffs);
		getAjax('EXT_flight.php?op=list_flights_json&lat='+lat+'&lon='+lon+'&distance=200&from_tm=10',null,drawFlights);
	});
	  	

	/*
	$.ajax({ url: 'EXT_takeoff.php?op=get_nearest&lat='+lat+'&lon='+lon, dataType: 'json', 		  
			  success: function(json) {
				drawTakeoffs(json);				
			}
	  
	 });
	*/	 
	<? if ( $CONF['thermals']['enable']  ) { ?>
	
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

	for(var i=1;i<=5;i++) { 
		thermalMarkers[i]=new Array();
		thermalNum[i]=0;
		cluster[i]=new ClusterMarker(map, { clusterClass: i,  minClusterSize:4 , clusterMarkerTitle:" Click to zoom to %count thermals" } );
		cluster[i].intersectPadding=10;
		
		classIcons[i]=new GIcon(icon,"img/thermals/class_"+i+".png"); 
	}	
	


	  function createThermalMarker(point,html,thermalClass) {
        var marker = new GMarker(point, {icon:classIcons[thermalClass]});
        GEvent.addListener(marker, "click", function() {
          marker.openInfoWindowHtml(html);
        });		
        return marker;
      }
	  	  
      function showThermalClass(thermalClass) {
	  	cluster[thermalClass].addMarkers( thermalMarkers[thermalClass] );
		cluster[thermalClass].refresh(true);
        document.getElementById(thermalClass+"_box").checked = true;
      }

      function hideThermalClass(thermalClass) {		
		cluster[thermalClass].removeMarkers();
		cluster[thermalClass].refresh(true);
        document.getElementById(thermalClass+"_box").checked = false;
        // == close the info window, in case its open on a marker that we just hid
        map.closeInfoWindow();
      }
	   
	   function boxclick(box,thermalClass){
			if (box.checked) {
				showThermalClass(thermalClass);
			} else {
				hideThermalClass(thermalClass);
			}       
		}	
		
	function importThermals(jsonString){
	 	var results= eval("(" + jsonString + ")");		
		// document.writeln(results.waypoints.length);
		for(var i=0;i<results.waypoints.length;i++) {	
			var thermalPoint= new GLatLng(results.waypoints[i].lat, results.waypoints[i].lon) ;
			var icon2=icon;
			
			var thermalClass=results.waypoints[i].c;
			var climbmeters=results.waypoints[i].m;
			var climbseconds=results.waypoints[i].d;
			var climbrate=climbmeters/climbseconds;
			climbrate=climbrate.toFixed(1);
						
			if (thermalClass=='A') thermalClass=1;
			else if (thermalClass=='B') thermalClass=2;
			else if (thermalClass=='C') thermalClass=3;
			else if (thermalClass=='D') thermalClass=4;
			else thermalClass=5;				
			
			var html="Class: " + results.waypoints[i].c+"<BR>"+
			"Climbrate: " +climbrate +" m/sec<BR>"+
			"Height Gain: " + climbmeters+" m<BR>"+
			"Duration: " + climbseconds+" secs";
			
			var thermalMarker = createThermalMarker(thermalPoint,html,thermalClass);
			thermalMarkers[thermalClass][ thermalNum[thermalClass]++ ] = thermalMarker ;
			
		}	

		//showThermalClass("1");
		//hideThermalClass("2");
        //hideThermalClass("3");
        //hideThermalClass("4");
    	//hideThermalClass("5");
		
		
		showThermalClass("1");
		$("#thermalLoading").hide();
		$("#thermalLoad").hide();		
		$("#thermalControls").show();
	}


	function loadThermals() {		
		$("#thermalLoading").html("<?=_Loading_thermals?><BR><img src='img/ajax-loader.gif'>").show();
		// getAjax('EXT_thermals.php?op=get_nearest&lat='+lat+'&lon='+lon,null,importThermals);
		getAjax('EXT_thermals.php?op=get_nearest&<?="max_lat=$max_lat&max_lon=$max_lon&min_lat=$min_lat&min_lon=$min_lon"?>',null,importThermals);
	}
	
	<? } // thermals code ?>
	
</script>

<? if ($CONF_airspaceChecks) { ?>
<script language="javascript">

function toggleAirspace(radioObj) {
	if(!radioObj) return "";	
	if(radioObj.checked) {
		showAirspace=1;
        for (var i=0; i<polys.length; i++) {
			map.addOverlay(polys[i]);
        }
	} else {
		showAirspace=0;
        for (var i=0; i<polys.length; i++) {
			map.removeOverlay(polys[i]);
        }
	}
	refreshMap();
}

 var poly ;
 var pts;
<?
	require_once dirname(__FILE__).'/FN_airspace.php';	
	//  we have compted min/max in the start
	
	// echo "$min_lat,	$max_lat,$min_lon,	$max_lon<BR>";

	// now find the bounding boxes that have common points
	// !( A1<X0 || A0>X1 ) &&  !( B1<Y0 || B0>Y1 )
	// X,A -> lon
	// Y,B -> lat 
	// X0 -> $min_lon A0-> $area->minx
	// X1 -> $max_lon A1-> $area->maxx
	// Y0 -> $min_lat B0-> $area->miny
	// Y1 -> $max_lat B1-> $area->maxy
	
	// !( $area->maxx<$min_lon || $area->minx>$max_lon ) &&  !( $area->maxx<$min_lat || $area->miny>$max_lat )

	//in germany, pilots are allowed to fly in class E and class G airspace, and in gliding sectors when they are activated (class W). 
	// All others are forbidden - start by colouring particularly the CTRs, TMAs and Danger Areas (EDs) .
	// $airspace_arr= array("R",  "Q", "P", "A", "B", "C", "CTR","D", "GP", "W", "E", "F");
	$airspace_color= array( "RESTRICT"=>"#ff0000", "DANGER"=>"#ff0000", "PROHIBITED"=>"#ff0000", 
							"CLASSA"=>"#0000ff", "CLASSB"=>"#0000ff", "CLASSC"=>"#0000ff", 
							"CTR"=>"#ff0000","CLASSD"=>"#0000ff", "NOGLIDER"=>"#0000ff", "WAVE"=>"#00ff00", "CLASSE"=>"#00ff00", "CLASSF"=>"#0000ff");


	global $AirspaceArea,$NumberOfAirspaceAreas;

	echo "polys = [];\n";	
	echo "labels = [];\n";	


	//Mod. P. Wild 5.10.2009 - show a few more airspaces around track (increase proximity level)
	// show a bit more airspaces around the flight
	// Manolis 09.12.2009
	// put in the config variable $CONF['airspace']['zoom']
	if ( $CONF['airspace']['zoom'] && $CONF['airspace']['zoom']!=100  ) {
		// $zoom=102; //Percentage
		$zoom=$CONF['airspace']['zoom'];
		$min_lon=$min_lon+($min_lon*(100-$zoom))/100;
		$max_lon=$max_lon+($max_lon*($zoom-100))/100;
		$min_lat=$min_lat+($min_lat*(100-$zoom))/100;
		$max_lat=$max_lat+($max_lat*($zoom-100))/100;
	}
 
	getAirspaceFromDB($min_lon , $max_lon , $min_lat ,$max_lat);
	$NumberOfAirspaceAreas=count($AirspaceArea);
	// echo " // found( $NumberOfAirspaceAreas) areas  $min_lon , $max_lon , $min_lat ,$max_lat <BR>";	
	foreach ($AirspaceArea as $i=>$area) {
		echo "pts = [];\n";	
		if ($area->Shape==1) { // area 					
			for($j=0;$j<$area->NumPoints;$j++) {
				 echo " pts[$j] = new GLatLng(".$area->Points[$j]->Latitude.",".$area->Points[$j]->Longitude.");\n";
			}
		} else if ($area->Shape==2) { // cirle
			$points=CalculateCircle($area->Latitude,$area->Longitude,$area->Radius);
			for($j=0;$j<count($points);$j++) {
				 echo " pts[$j] = new GLatLng(".$points[$j]->lat.",".$points[$j]->lng.");\n";
			}
		}	
		echo " poly = new GPolygon(pts,'#000000',1,1,'".$airspace_color[$area->Type]."',0.25); \n";
		echo " polys.push(poly); \n";
		echo " labels.push('".$area->Name.' ['.$area->Type.'] ('.floor($area->Base->Altitude).'m-'.floor($area->Top->Altitude).'m)'."'); \n";
		echo " map.addOverlay(poly);\n";	
		
		echo " GEvent.addListener(poly,'click', function(point) { checkPoint(point); }  ); ";

	}
	


?>

      // === A method for testing if a point is inside a polygon
      // === Returns true if poly contains point
      // === Algorithm shamelessly stolen from http://alienryderflex.com/polygon/ 
      GPolygon.prototype.Contains = function(point) {
        var j=0;
        var oddNodes = false;
        var x = point.lng();
        var y = point.lat();
        for (var i=0; i < this.getVertexCount(); i++) {
          j++;
          if (j == this.getVertexCount()) {j = 0;}
          if (((this.getVertex(i).lat() < y) && (this.getVertex(j).lat() >= y))
          || ((this.getVertex(j).lat() < y) && (this.getVertex(i).lat() >= y))) {
            if ( this.getVertex(i).lng() + (y - this.getVertex(i).lat())
            /  (this.getVertex(j).lat()-this.getVertex(i).lat())
            *  (this.getVertex(j).lng() - this.getVertex(i).lng())<x ) {
              oddNodes = !oddNodes
            }
          }
        }
        return oddNodes;
      }

	function checkPoint(point) {
        if (point) {		
		  var infoStr='';
          for (var i=0; i<polys.length; i++) {
            if (polys[i].Contains(point)) {
				infoStr=infoStr+labels[i]+"<BR>";
            }
          }
		  if (infoStr!='') {
            map.openInfoWindowHtml(point,infoStr);
		  }
        }
	}
</script>
<? } ?>
</body>
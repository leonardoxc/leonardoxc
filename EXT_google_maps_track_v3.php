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
// $Id: EXT_google_maps_track_v3.php,v 1.3 2012/09/12 19:41:03 manolis Exp $                                                                 
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
	
	$flightIDstr=makeSane($_GET['id']);
	$flightsListTmp=explode(",",$flightIDstr);
	$flightsList=array();
	$i=0;
	foreach($flightsListTmp as $flightID) {
		$flightID+=0;
		if ($flightID) $flightsList[]=$flightID;
		$i++;
		if ($i>20) break;
	} 
	$flightsNum=count($flightsList);
	sort($flightsList);
	
	if ($flightsNum==0) exit;
	
	if ( $flightsNum==1) {
		$flight=new flight();
		$flight->getFlightFromDB($flightsList[0],0);
		$flightID=$flightsList[0];
		if ($flight->is3D() ) {		
			$title1=_Altitude.' ('.(($PREFS->metricSystem==1)?_M:_FT).')';
		} else  {		
			$title1=_Distance_from_takeoff.' ('.(($PREFS->metricSystem==1)?_KM_PER_HR:_MPH).')';
		}
		// print_r($flight);exit;
		$takeoffID=$flight->takeoffID;
		
		$isAdmin=L_auth::isAdmin($userID) || $flight->belongsToUser($userID);		
		$trackPossibleColors=array( "AB7224", "3388BE", "FF0000","00FF00","0000FF","FFFF00","FF00FF","00FFFF","EF8435","34A7F0","33F1A3","9EF133","808080");
	} else {
		
		$title1=_Altitude.' ('.(($PREFS->metricSystem==1)?_M:_FT).')';
		$flightID=0;
		$takeoffID=0;
		$trackPossibleColors=array( "FF0000","00FF00","0000FF","FFFF00","FF00FF","00FFFF","EF8435","34A7F0","33F1A3","9EF133","808080");
		$isAdmin=L_auth::isAdmin($userID) ;
	}
	
	$colotStr='';
	foreach ($trackPossibleColors as $color) {
		if ($colotStr) $colotStr.=',';
		$colotStr.=" '#$color'";		
	}
	
	$flightListStr='';
	foreach ($flightsList as $f) {
		if ($flightListStr) $flightListStr.=',';
		$flightListStr.="$f";		
	}
	

	/*
    ROADMAP displays the normal, default 2D tiles of Google Maps.
    SATELLITE displays photographic tiles.
    HYBRID displays a mix of photographic tiles and a tile layer for prominent features (roads, city names).
    TERRAIN displays physical relief tiles for displaying elevation and water features (mountains, rivers, etc.).
	*/	
	# martin jursa 22.06.2008: enable configuration of map type
	$GMapType='TERRAIN';
	if ( in_array( $CONF['google_maps']['default_maptype'],
			 array('ROADMAP', 'SATELLITE', 'HYBRID', 'TERRAIN','G_SATELLITE_3D_MAP'))) {
		$GMapType= $CONF['google_maps']['default_maptype'];
	}

	if ( $CONF_airspaceChecks && $isAdmin) { 
		$airspaceCheck=1;	
	} else {
		$airspaceCheck=0;
	}
	
	 $isAdmin=1;
	 $airspaceCheck=1;
	 $CONF['thermals']['enable'] =1;
	 $CONF['airspace']['enable'] =1;
	 
	 $is3dEnabled =0;
	 
	 $is3D=1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Leonardo Track</title>
<link rel='stylesheet' type='text/css' href='<?=$themeRelPath?>/css/google_maps_v3.css' />

<!-- sprites-->
<style type="text/css">
<!--
img.brands { background: url(<?=$moduleRelPath?>/img/sprite_brands.png) no-repeat left top; }
img.fl {   background: url(<?=$moduleRelPath?>/img/sprite_flags.png) no-repeat left top ; }
img.icons1 {   background: url(<?=$moduleRelPath?>/img/sprite_icons1.png) no-repeat left  top ; }
-->
</style>
<link rel="stylesheet" type="text/css" href="<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/sprites.css">

<script src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=geometry" type="text/JavaScript"></script>

<? if ( $is3dEnabled ) { ?> 
<script src="https://www.google.com/jsapi"></script>
<script src="<?=$moduleRelPath?>/js/google_maps/googleearth-compiled.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/google_maps/graticule.3x.js"></script>
<script src="<?=$moduleRelPath?>/js/google_maps/earth_map_typex.js"></script>
<? } ?>

<script src="<?=$moduleRelPath?>/js/google_maps/jquery.js" type="text/javascript"></script>

<script src="<?=$moduleRelPath?>/js/google_maps/gmaps_v3.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/google_maps/chart_v3.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/google_maps/polyline_v3.js" type="text/javascript"></script>

<? if ( $CONF['thermals']['enable']  ) { 
	// http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclustererplus/docs/reference.html
?>
<script src="<?=$moduleRelPath?>/js/google_maps/markerclusterer_v3.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/google_maps/thermals_v3.js" type="text/javascript"></script>
<? } ?>
<? if ($CONF['airspace']['enable']) { ?>
<script src="<?=$moduleRelPath?>/js/google_maps/airspace_v3.js" type="text/javascript"></script>
<? } ?>
 <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="<?=$moduleRelPath?>/js/flot/excanvas.min.js"></script><![endif]-->
<script src="<?=$moduleRelPath?>/js/flot/jquery.flot.js"></script>
<script src="<?=$moduleRelPath?>/js/flot/jquery.flot.resize.js"></script>
<script src="<?=$moduleRelPath?>/js/flot/jquery.flot.crosshair.js"></script>

</head>
<body>

<div id='chartDiv'>
	<div id="chart" class="chart"></div>  			 
</div>

<div style='display:none;'>
	<div id='control3d' class='controlButton'>
		<div class='controlButtonInner'>3D View</div>
	</div>
	
	<div id='controlSkyways' class='controlButton skywaysButton'>
		<div class='controlButtonInner'>Skyways</div>
	</div>
</div>
	
<div id='mapDiv'>  


	<div id='map'></div>  
	
	<div id='trackDetails'>
	  
		<div id='trackCompareFinder'>
			<div id="trackCompareFinderHeader">
			Find and Compare Flights >> 
			</div> 
			<div id="trackCompareFinderHeaderExpand" > 				
				<div id="trackCompareFinderHeaderClose">
				Close
				</div>			
				<div id="trackCompareFinderHeaderAct">
				Compare Selected Flights 
				</div>  
			</div>
			<div id="trackCompareFinderList">
				<div id="trackFinderTplMulti" class='trackInfoDisplay'>
				 	<div class="trackDisplayItem">
				 		<div class='trackListStr date'></div>
				 		<div class='trackListStr score'>-</div>	 			 	
						<div class='trackListStr info'>-</div>
						<div class='trackListStr glider'>-</div>
						<div class='trackListStr name'>-</div>	 	
						<div class='trackListStr tick'></div>	 		
				 	</div>
				</div>
			</div>
			<div id="trackCompareFinderHeaderMore">
				More...
			</div>
		</div>
		
		<div id="trackInfoTplMulti" class='trackInfoDisplay'>
		 	<div class="trackDisplayItem">
		 		<div class='trackStr color'></div>
		 		<div class='trackStr name'>-</div>	 			 	
				<div class='trackStr alt'>-</div>
				<div class='trackStr speed'>-</div>
		 		<div class='trackStr vario'>-</div>
		 	</div>
		</div>
	</div>


	<div id='placeDetails'>  
	<div style="display:block">
		<div style="position:relative; float:right; clear:both; margin-top:8px">
			<a href='javascript:toogleFullScreen();'><img src='img/icon_maximize.gif' border=0></a>
		</div>
		<br>
 		<fieldset id="trackInfoList" class="legendBox">
 		
 		<div id="trackInfoTpl" class='infoDisplay'>
	 		<div class="infoDisplayItem"><div class='infoDisplayText'><?=_Time_Short?></div><div class='infoString time'>-</div></div>
	 		<div class="infoDisplayItem"><div class='infoDisplayText'><?=_Speed?></div><div class='infoString speed'>-</div></div>
	 		<div class="infoDisplayItem"><div class='infoDisplayText'><?=_Altitude_Short?></div><div class='infoString alt'>-</div></div>
	 		<? if ($isAdmin) { ?>
	 		<div class="infoDisplayItem"><div class='infoDisplayText'><?=_Altitude_Short?> (Baro)</div><div class='infoString altV'>-</div></div>	                
	        <? } ?>
	 		<div class="infoDisplayItem"><div class='infoDisplayText'><?=_Vario_Short?></div><div class='infoString vario'>-</div></div>
		</div>
		</fieldset>

		<fieldset class="legendBox">	
			<a href='javascript:zoomToFlight()'><?=_Zoom_to_flight?></a>
			<div id="side_bar"></div> 
			
			<input type="checkbox" value="1" id='followGlider' name='followGlider' onClick="toggleFollow(this)">
			<label for='followGlider'><?=_Follow_Glider?></label><br>
			<input type="checkbox" value="1" checked id='showTask' name='showTask'  onClick="toggleTask(this)">
			<label for='showTask'><?=_Show_Task?></label><br>
			<? if ($CONF_airspaceChecks && $isAdmin ) { ?>
				<input type="checkbox" value="1"  checked="checked" name='airspaceShow' id='airspaceShow' onClick="toggleAirspace(true)">
				<label for='airspaceShow'><?=_Show_Airspace?></label>		
			<?  } ?>
		</fieldset>
	     
	    <fieldset class="legendBox">	  
	    <div id='animControl'>
		   <a href="javascript:;" onclick='ToggleTimer();'><img src='<?=$moduleRelPath?>/img/icon_anim_play.gif' border="0" title="<?=_Normal_Speed?>"></a>
		   <a href="javascript:;" onclick='resetTimer()'><img src='<?=$moduleRelPath?>/img/icon_anim_stop.gif' border="0" title="<?=_Stop?>"></a>
		   <button class="navbutt" onclick="TimeStep/=1.5;" title="<?=_Slower?>">-</button>
		   <button class="navbutt" onclick="TimeStep*=1.5;" title="<?=_Faster?>">+</button>
		</div>
 		</fieldset>
	  
	  
		<? if ( $CONF['thermals']['enable']  ) { ?>
		<fieldset id='themalBox' class="legendBox"><legend><?=_Thermals?></legend>
	         <div id='thermalLoad'><a href='javascript:loadThermals("<?=_Loading_thermals?><BR>")'><?=_Load_Thermals?></a></div>
	         <div id='thermalLoading' style="display:none"></div>
	         <div id='thermalControls' style="display:none">
	      		<input type="checkbox" id="1_box" onClick="boxclick(this,'1')" /><label for='1_box'> A Class<img src='img/thermals/class_1.png'></label><BR>
	          	<input type="checkbox" id="2_box" onClick="boxclick(this,'2')" /><label for='2_box'> B Class<img src='img/thermals/class_2.png'></label><BR>
	          	<input type="checkbox" id="3_box" onClick="boxclick(this,'3')" /><label for='3_box'> C Class<img src='img/thermals/class_3.png'></label><BR>
	          	<input type="checkbox" id="4_box" onClick="boxclick(this,'4')" /><label for='4_box'> D Class<img src='img/thermals/class_4.png'></label><BR>
	          	<input type="checkbox" id="5_box" onClick="boxclick(this,'5')" /><label for='5_box'> E Class<img src='img/thermals/class_5.png'></label><BR>
	         </div>
		</fieldset>
	    <? } ?>
        
		
        
		</div>
	</div>  
</div>  
    


<div id='msg'>DEBUG</div>

<div id="photoDiv" style="position:absolute;display:none;z-index:110;"></div>

<script type="text/javascript">

var trackColors= [ <?php  echo $colotStr; ?>] ;
var relpath="<?=$moduleRelPath?>";

var posMarker=[];
var posMarker2=[];
var tracksNum=0;

var followGlider=0;
var airspaceShow=1;
var showTask=1;
var taskLayer=[];
var infowindow ;

var mapType=google.maps.MapTypeId.<?php echo $GMapType ?>;
var metricSystem=<?=$PREFS->metricSystem?>;
var multMetric=1;
if (metricSystem==2) {
	multMetric=3.28;
}

var takeoffString="<? echo _TAKEOFF_LOCATION ?>";
var landingString="<? echo _LANDING_LOCATION ?>";

var AltitudeStr="<? echo _Altitude_Short ?>";
var AltitudeStrBaro="<? echo _Altitude_Short." (Baro)" ?>";

var altUnits="<? echo ' '.(($PREFS->metricSystem==1)?_M:_FT) ; ?>";
var speedUnits="<? echo ' '.(($PREFS->metricSystem==1)?_KM_PER_HR:_MPH) ; ?>";
var varioUnits="<? echo ' '.(($PREFS->metricSystem==1)?_M_PER_SEC:_FPM) ; ?>";

var flightList=[ <?php echo $flightListStr;?> ];
var flightsTotNum=<?php  echo $flightsNum ?>;
var takeoffID=<?php echo $takeoffID?>;
var flightID=<?php echo $flightID?>;
var compareUrlBase='<?php echo getLeonardoLink(array('op'=>'compare','flightID'=>$flightListStr));?>';
var TimeStep = 10000; //  in millisecs
var CurrTime=null;

var airspaceCheck=<?php echo $airspaceCheck; ?>;
<? if ( $isAdmin ) { ?>
	var baroGraph=true;
	userAccessPriv=true;
<? } else { ?>
	var baroGraph=false;
	var userAccessPriv=false;
<?php  } ?>

var skywaysVisible=0;
var map;
var googleEarth;   
var compareUrl=null;
var radiusKm=10
var queryString='';


$(document).ready(function(){
	initialize();
});

function initialize() {
	<?php  if ($is3dEnabled ) { ?>
	google.load('earth', '1'); 
	<?php  } ?>

	
	var reliefTypeOptions = {
	  getTileUrl: function(a,b) {
	    	return "http://maps-for-free.com/layer/relief/z" + b + "/row" + a.y + "/" + b + "_" + a.x + "-" + a.y + ".jpg";
	    },
	  maxZoom: 15,
	  minZoom: 0,
	  tileSize: new google.maps.Size(256, 256),
	  name: "Relief"
	};
	var reliefMapType = new google.maps.ImageMapType(reliefTypeOptions);
		
    var mapOptions= {
            zoom: 8,
            mapTypeControl: true,
            mapTypeControlOptions: {
                mapTypeIds: [
					"Relief",
					google.maps.MapTypeId.ROADMAP,
					google.maps.MapTypeId.SATELLITE,
					google.maps.MapTypeId.HYBRID,
					google.maps.MapTypeId.TERRAIN,
                    ],
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR
            },
            mapTypeIds: [
                google.maps.MapTypeId.ROADMAP,
                google.maps.MapTypeId.SATELLITE,
                google.maps.MapTypeId.HYBRID,
                google.maps.MapTypeId.TERRAIN,
             
               // 'Earth'
            ],
            mapTypeId: mapType
          };

    map = new google.maps.Map(document.getElementById('map'), mapOptions);
    map.mapTypes.set('Relief', reliefMapType);
    // map.setMapTypeId('Relief');

    skywaysOverlay= new google.maps.ImageMapType({
	    getTileUrl: function(tile, zoom) {
	    	var y= (1<<zoom)-tile.y-1;
    		return "http://thermal.kk7.ch/php/tile.php?typ=skyways&t=all&z="+zoom+"&x="+tile.x+"&y="+y; 
	    },
	    tileSize: new google.maps.Size(256, 256),
	    opacity:0.60,
	    isPng: true
	});

    map.overlayMapTypes.push(null); // create empty overlay entry 0 -> skyways
        
    if (flightsTotNum==1) {
		var controlButton=$("#control3d").get(0);
	    google.maps.event.addDomListener(controlButton , 'click', function() {
        	window.location.href="EXT_google_maps_track_3d.php?id="+flightID;
        });
	    controlButton.index = 1;
	    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(controlButton);
    }

    var controlButton=$("#controlSkyways").get(0);
    google.maps.event.addDomListener(controlButton , 'click', function() {
        if (skywaysVisible) {
        	map.overlayMapTypes.setAt("0",null); 
        	skywaysVisible=0;
        	$("#controlSkyways").removeClass('skywaysButtonPressed');
        } else {
    		map.overlayMapTypes.setAt("0",skywaysOverlay); 
    		skywaysVisible=1;
    		$("#controlSkyways").addClass('skywaysButtonPressed');
        }
    });
    controlButton.index = 5;
    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(controlButton);

    
    <?php  if ($is3dEnabled ) { ?>
  	googleEarth = new GoogleEarth(map);
    <?php  } ?>
    
	if (0) {
	    window.earth = new EarthMapType(map);
	    GM.event.addListener(earth, 'initialized', function (plugin_loaded) {
	      if (plugin_loaded) {
	        map.setMapTypeId('Earth');
	      }
	      window.earth.set('graticules', true);
	      var path = [
	        new GM.LatLng(32.86355, -117.25464),
	        new GM.LatLng(32.86604, -117.2542),
	        new GM.LatLng(32.86694, -117.2575),
	        new GM.LatLng(32.86716, -117.2574),
	        new GM.LatLng(32.86625, -117.2541),
	        new GM.LatLng(32.87175, -117.2530),
	        new GM.LatLng(32.87047, -117.2481),
	        new GM.LatLng(32.86427, -117.2478),
	      ];
	      path.push(path[0]);
	      var poly = new GM.Polygon({path: path});
	      poly.setMap(map);
    });
    
}

 
    infowindow = new google.maps.InfoWindow();
    google.maps.event.addListener(map, 'click', function() {
        infowindow.close();
    });
	
	map.setCenter (new google.maps.LatLng(0,0) );

	flightList.sort();
	for( var i in flightList ) {
		loadFlight(flightList[i]);
	}	

}

var flights=[];
var MIN_START=86000;
var MAX_END=0;

function loadFlight(flightID) {

	$.getJSON('EXT_flight.php?op=flight_info&flightID='+flightID, function(data) {
		flights[flightID]=[];
		
		flights[flightID]['data']=data;

		// display the kml track
		//flights[flightID]['kmlLayer'] =new google.maps.KmlLayer(data.flightKMZUrl);
		//flights[flightID]['kmlLayer'].setMap(map);

		var trackPoints=[];
		for(i=0;i<data.points.lat.length;i++) {
			trackPoints.push( new  google.maps.LatLng(data.points.lat[i],data.points.lon[i]) ) ;
		}

		var trackColor=trackColors[tracksNum];
		if (flightsTotNum==1) {
			trackColor=trackColors[2];
		}

		if (data.START_TIME < MIN_START)	MIN_START=data.START_TIME ;
		if (data.END_TIME  > MAX_END) 	MAX_END=data.END_TIME ;
		
		flights[flightID]['trackLayer'] = new google.maps.Polyline({
			  path: trackPoints,
	          strokeColor: trackColor,
	          strokeOpacity: 1.0,
	          strokeWeight: 2,
	          map:map
		});
		
		if (flightsTotNum>1) {
			if (tracksNum==0) {
				$("#trackInfoList").append("<div id='timeDiv'>00:00</div>");
			}			
			
			$('#trackInfoTplMulti').clone().attr('id', 'trackInfo'+(tracksNum)  ).appendTo("#trackDetails");
			// name of track
			$("#trackInfo"+tracksNum+" .name").html(data.pilotName);
			// color
			$("#trackInfo"+tracksNum+" .color").css('background-color',trackColor);
		} else {	
			// $("#trackDetails").hide();		
			$('#trackInfoTpl').clone().attr('id', 'trackInfo'+(tracksNum)  ).appendTo("#trackInfoList");			
		}

		posMarker[tracksNum] = new google.maps.Marker({
			position: new google.maps.LatLng(data.firstLat,data.firstLon),       
			map: map,
			icon: data.markerIconUrl
		});
		
		posMarker2[tracksNum] = new google.maps.Marker({
			position: new google.maps.LatLng(data.firstLat,data.firstLon),       
			map: map,
			icon: {
				path: google.maps.SymbolPath.CIRCLE,
		        scale: 18,		        
		        fillOpacity: 0.1,
		        fillColor: trackColor,		        
		        strokeWeight: 1,
		        strokeOpacity: 0.7,
		        strokeColor: trackColor
	          }
			//icon: data.markerIconUrl
		});

		
		// now the graph , redraw if it not the first time called
		// only draw it one at the end
		if (tracksNum==(flightsTotNum-1)) {
			drawChart();
		}

		// the photos 
		drawPhotos(data.photos); 		

		// the task tps		
		displayTask(data.task);		

		// general map stuff 
		//center_lat=(data.max_lat+data.min_lat)/2;
		//center_lon=(data.max_lon+data.min_lon)/2;	
				
		var newbounds = new google.maps.LatLngBounds(new google.maps.LatLng(data.max_lat,data.min_lon ),new google.maps.LatLng(data.min_lat,data.max_lon) );
		if (bounds ==null ) {
			bounds=newbounds;
		} else {
			bounds.union(newbounds);
		}
		map.fitBounds(bounds);

		// add takeoff and landing markers ( previously done on proccess_waypoints 
		var marker1 = createMarker(new google.maps.LatLng(data.takeoff_lat,data.takeoff_lon),takeoffString,takeoffString,"start");
		if (flightsTotNum==0 ) {
			$("#side_bar").append(side_bar_html); 
		}
		var marker2 = createMarker(new google.maps.LatLng(data.landing_lat,data.landing_lon),landingString,landingString,"stop");		
		if (flightsTotNum==0) { 
			$("#side_bar").append(side_bar_html);
		}

			
		// this is the last track! 
		// do some house keeping 
		if (tracksNum==(flightsTotNum-1) ) {			
			// get min max values from bounds obj
			computeMinMaxLatLon();
			if (airspaceCheck) {	
				toggleAirspace(false);
			}			
			
			$.get('EXT_takeoff.php?op=get_nearest&lat='+data.firstLat+'&lon='+data.firstLon, function(data) {
				drawTakeoffs(data);
			});	

			
		}
		
		tracksNum++;

	});
	
}
	
</script>

</body>
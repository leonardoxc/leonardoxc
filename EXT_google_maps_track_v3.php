<?
//************************************************************************
// Leonardo XC Server, https://github.com/leonardoxc/leonardoxc
//
// Copyright (c) 2004-2010 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: EXT_google_maps_track_v3.php,v 1.7 2012/10/17 09:45:24 manolis Exp $                                                                 
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

if ($_GET['deleted'] && L_auth::isAdmin($userID) ) {
    $flightsTable	=  $deletedFlightsTable;
    $deletedFlights=1;
}

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
	
	// $isAdmin=1;
	// $airspaceCheck=1;
	// $CONF['thermals']['enable'] =1;
	// $CONF['airspace']['enable'] =1;
	
	// use the google earth plugin directly, not the hack
	$useGE=1;	 
	$is3D=$_GET['3d']+0;
		
	if ($CONF_google_maps_api_key) {
		$googleApiKeyStr="&key=$CONF_google_maps_api_key";
	} else {
		$googleApiKeyStr='';
	}
	
	if ($is3D) {
		 $CONF['thermals']['enable'] =0;
		 $airspaceCheck=0;
	}
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

#control2d {
	position:absolute;
	top:5px;
	right:10px;
	dislay:block;
}

.control2dBig {
	position:absolute;
	top:5px;
	right:10px;
	dislay:block;
	font-size:25px;
	font-weight:bold;
	padding:10px;
}
#distanceDiv {
	position:absolute;
	top:5px;
	right:100px;
	dislay:block;
}

.solidBackground , #placeDetails.solidBackground , #trackDetails.solidBackground {
 background:#565656; 
 border-radius: 0;  
 -moz-border-radius: 0;  
 -webkit-border-radius: 0;  
}

#placeDetails.solidBackground {
	bottom:95px;
}
#trackDetails.solidBackground {
	bottom:65px;
}

#overlay {
	position:fixed; 
	top:0;
	left:0;
	width:100%;
	height:100%;
	background:#000;
	opacity:0.5;
	filter:alpha(opacity=50);
}

#modal {
	position:absolute;
	background:url(tint20.png) 0 0 repeat;
	background:rgba(0,0,0,0.2);
	border-radius:14px;
	padding:8px;
}

-->
</style>
<link rel="stylesheet" type="text/css" href="<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/sprites.css">
 
<? if ( $is3D ) { ?> 
<script src="https://www.google.com/jsapi?<?php echo $googleApiKeyStr ?>"></script>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=geometry<?php echo $googleApiKeyStr ?>" type="text/JavaScript"></script>
<script src="<?=$moduleRelPath?>/js/google_maps/extensions.pack.js" type="text/javascript"></script>
<? } else { ?>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=geometry<?php echo $googleApiKeyStr ?>" type="text/JavaScript"></script>
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
	

<div id='control2d' class='controlButton' style='display:none;'>
	<div class='controlButtonInner'>2D View</div>
</div>
	
<div id='distanceDiv' class='controlButton' style='display:none;'>
<strong>Distance: </strong><span id="distance">N/A</span>
</div>


<div id='mapDiv'>  


	<div id='map'></div>  
	
	<div id='trackDetails'>
	  
		<div id='trackCompareFinder'>
			<div id="trackCompareFinderHeader">
			<?php  echo _Find_and_Compare_Flights?> >> 
			</div> 
			<div id="trackCompareFinderHeaderExpand" > 				
				<div id="trackCompareFinderHeaderClose">
				<?php  echo _Close ?>
				</div>			
				<div id="trackCompareFinderHeaderAct">
				<?php  echo _Compare_Selected_Flights ?>
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
				<?php echo _More ?>...
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
	 		<div class="infoDisplayItem"><div class='infoDisplayText'><?=_Altitude_Short?> (GPS)</div><div class='infoString alt'>-</div></div>
	 		
	 		<div class="infoDisplayItem"><div class='infoDisplayText'><?=_Altitude_Short?> (Baro)</div><div class='infoString altV'>-</div></div>	                
	   
	 		<div class="infoDisplayItem"><div class='infoDisplayText'><?=_Vario_Short?></div><div class='infoString vario'>-</div></div>
	 		<div class="infoDisplayItem"><div class='infoDisplayText'><?=_OVER_GROUND?></div><div class='infoString gnd'>-</div></div> 
		</div>
		</fieldset>

		<fieldset class="legendBox">	
			<a href='javascript:zoomToFlight()'><?=_Zoom_to_flight?></a>
			<div id="side_bar"></div> 
						
			<?php  if ( $flightsNum>1) { ?>
			<input type="checkbox" value="1" id='syncStarts' onClick="toggleSyncStarts(this)">
			<label for='syncStarts'><?=_Sync_Start_Times?></label><br>
			
				<?php  if ( 0) { ?>
				<input type="checkbox" value="1" id='syncStartsTz' onClick="toggleSyncStartsTimezone(this)">
				<label for='syncStartsTz'><?=_Sync_Start_Timezones?></label><br>
				<?php  } ?>
			<?php  } ?>
			<input type="checkbox" value="1" id='followGlider' name='followGlider' onClick="toggleFollow(this)">
			<label for='followGlider'><?=_Follow_Glider?></label><br>
			<input type="checkbox" value="1" <?php echo (($flightsNum==1)?'checked':'') ?> id='showTask' name='showTask'  onClick="toggleTask(this)">
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
	         <div id='thermalClose' style="display:none"><a href='javascript:toggleThermals()'><?=_Close?></a></div>
	         <div id='thermalOpen' style="display:none"><a href='javascript:toggleThermals()'><?=_Load_Thermals?></a></div>
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
<div id='kk7Copyright' style='padding:3px;'>Skyways Layer &copy; <a href='http://thermal.kk7.ch' target='_blank'>thermal.kk7.ch</a></div>

<div id="photoDiv" style="position:absolute;display:none;z-index:110;"></div>

<script type="text/javascript">

var is3D=<?php  echo $is3D ?>;
var useGE=<?php  echo $useGE ?>; 
var trackColors= [ <?php  echo $colotStr; ?>] ;
var relpath="<?php echo $moduleRelPath?>";
var SERVER_NAME = '<?php  echo $_SERVER['SERVER_NAME'] ?>';
var posMarker=[];
var posMarker2=[];
var altMarker=[];
var varioMarker=[];
var speedMarker=[];

var tracksNum=0;

var followGlider=0;
var airspaceShow=1;
var showTask=1;
var taskLayer=[];
var infowindow ;

var mapType;

var metricSystem=<?=$PREFS->metricSystem?>;
var multMetric=1;
if (metricSystem==2) {
	multMetric=3.28;
}

var takeoffString="<? echo _TAKEOFF_LOCATION ?>";
var landingString="<? echo _LANDING_LOCATION ?>";

var GroundSfc="<? echo _GroundSFC ?>";
var AltitudeStr="<? echo _Altitude_Short." (GPS)" ?>";

var AltitudeStrBaro="<? echo _Altitude_Short." (Baro)" ?>";

var altUnits="<? echo ' '.(($PREFS->metricSystem==1)?_M:_FT) ; ?>";
var speedUnits="<? echo ' '.(($PREFS->metricSystem==1)?_KM_PER_HR:_MPH) ; ?>";
var varioUnits="<? echo ' '.(($PREFS->metricSystem==1)?_M_PER_SEC:_FPM) ; ?>";

var flightList=[ <?php echo $flightListStr;?> ];
var flightsTotNum=<?php  echo $flightsNum ?>;
var takeoffID=<?php echo $takeoffID?>;
var flightID=<?php echo $flightID?>;
var flightIDstr='<?php echo $flightIDstr?>';
var compareUrlBase='<?php echo getLeonardoLink(array('op'=>'compare'.($is3D?'3d':''),'flightID'=>$flightListStr));?>';
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
var ge;
var compareUrl=null;
var radiusKm=10
var queryString='';
var gex;


<?php  if ($is3D ) { ?>
google.load("earth", "1");
if (useGE) {
	google.setOnLoadCallback(initializeGE);	
} else {
	google.setOnLoadCallback(initialize0);
}	
// google.load("maps", "3", {other_params: "sensor=false"});
<?php  }  else { ?>

$(document).ready(function(){
	initialize();
});

//google.setOnLoadCallback(initialize);
//google.load("maps", "3", {other_params: "sensor=false"});
<?php  } ?>

function initialize0() {
	$.getScript("<?=$moduleRelPath?>/js/google_maps/googleearth_org.js").done(function(script, textStatus) {
		initialize();
	});
}

function initializeGE(){

	$("#control2d").show();
	$("#control2d").click(function(){
		window.location.href="EXT_google_maps_track_v3.php?id="+flightIDstr+"&3d=0";
	});
	// $("#distanceDiv").show();
	
	
	  
    var ge_problem='';
    var ge_problem_num=0;
    if (!google || !google.earth) {
    	ge_problem='google.earth not loaded';
    	ge_problem_num=1;
     }

     if (!google.earth.isSupported()) {
     	ge_problem='Google Earth Plugin is not supported on this system';
     	ge_problem_num=2;

     	$('#mapDiv').html('<iframe width="100%" height="100%" src="http://www.google.com/earth/plugin/error.html#error=ERR_UNSUPPORTED_PLATFORM" frameBorder="0">');
  	  	addShim($("#control2d").get(0)); 
  	  	$("#control2d").addClass('control2dBig'); 	
     }

     if (!google.earth.isInstalled()) {
    	  ge_problem='Google Earth Plugin is not installed on this system';
    	  ge_problem_num=3;
    	  $('#mapDiv').html('<iframe width="100%" height="100%" src="http://www.google.com/earth/plugin/error.html#error=ERR_NOT_INSTALLED" frameBorder="0">');
    	  addShim($("#control2d").get(0));
    	  $("#control2d").addClass('control2dBig'); 
     }

     if (ge_problem!='' || ge_problem_num>0 ) {
         if (ge_problem_num!=3 && ge_problem_num!=2 ) {
         	alert(ge_problem);
	         // modal.open({content: ge_problem});
         }        
      } else {
    	addShim($("#control2d").get(0));
    	addShim($("#distanceDiv").get(0));
    	addShim($("#trackDetails").get(0));
    	addShim($("#placeDetails").get(0));  
    	$("#trackDetails").addClass('solidBackground');
    	$("#placeDetails").addClass('solidBackground');
    	google.earth.createInstance("map", initCallback, failureCallback);    	
      } 
}

function initCallback(object) {
	ge = object;
	ge.getWindow().setVisibility(true);
	ge.getNavigationControl().setVisibility(ge.VISIBILITY_SHOW);
	ge.getNavigationControl().getScreenXY().setXUnits(ge.UNITS_PIXELS);
	ge.getNavigationControl().getScreenXY().setYUnits(ge.UNITS_INSET_PIXELS);
	ge.getNavigationControl().setVisibility(ge.VISIBILITY_AUTO);

	ge.getLayerRoot().enableLayerById(ge.LAYER_TERRAIN, true);
	ge.getLayerRoot().enableLayerById(ge.LAYER_BORDERS, true);
    ge.getLayerRoot().enableLayerById(ge.LAYER_ROADS, true);

    ge.getOptions().setScaleLegendVisibility(true); 	//Displays the current scale of the map.
    ge.getOptions().setStatusBarVisibility(true); 	//Displays a status bar at the bottom of the Earth window, containing geographic coordinates and altitude of the terrain below the current cursor position, as well as the range from which the user is viewing the Earth.
    //ge.getOptions().setOverviewMapVisibility(true); 	//Displays an inset map of the entire world in the bottom right corner. The current viewport is displayed on the inset map as a red rectangle.
    //ge.getOptions().setGridVisibility(true); 		//Displays the lines of latitude and longitude on the globe.
    //ge.getOptions().setAtmosphereVisibility(true); 	//Displays scattered light in the Earth's atmosphere.
    //ge.getSun().setVisibility(true);
        
    gex = new GEarthExtensions(ge);
    
	addOverlays();
	// addGEruler();
}

function failureCallback(object) {
}
  		
function initialize() {

	mapType=google.maps.MapTypeId.<?php echo $GMapType ?>;
	var reliefTypeOptions = {
	  getTileUrl: function(a,b) {
	    	return "http://maps-for-free.com/layer/relief/z" + b + "/row" + a.y + "/" + b + "_" + a.x + "-" + a.y + ".jpg";
	    },
	  maxZoom: 20,
	  minZoom: 0,
	  tileSize: new google.maps.Size(256, 256),
	  name: "Relief"
	};
	var reliefMapType = new google.maps.ImageMapType(reliefTypeOptions);
		
    var mapOptions= {
            zoom: 8,

			zoomControl: true,
			zoomControlOptions: {
				position: google.maps.ControlPosition.LEFT_CENTER
			},
			scaleControl: true,
			streetViewControl: true,
			streetViewControlOptions: {
				position: google.maps.ControlPosition.LEFT_CENTER
			},

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
    		return "http://thermal.kk7.ch/php/tile.php?typ=skyways&t=all&z="+zoom+"&x="+tile.x+"&y="+y+"&src="+SERVER_NAME; 
	    },
	    tileSize: new google.maps.Size(256, 256),
	    opacity:0.60,
	    isPng: true
	});

    map.overlayMapTypes.push(null); // create empty overlay entry 0 -> skyways

    
    var kk7Copyright=$("#kk7Copyright").get(0);
    kk7Copyright.index = 0; // used for ordering
    map.controls[google.maps.ControlPosition.BOTTOM_RIGHT].push(kk7Copyright);

       
    if (flightsTotNum==1 || 1) {
		var controlButton=$("#control3d").get(0);
	    google.maps.event.addDomListener(controlButton , 'click', function() {
        	window.location.href="EXT_google_maps_track_v3.php?id="+flightIDstr+"&3d=1";
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

    
    <?php  if ($is3D) { ?>
    var ge_problem='';
    if (!google || !google.earth) {
    	ge_problem='google.earth not loaded';
      }

      if (!google.earth.isSupported()) {
    	  ge_problem='Google Earth API is not supported on this system';
      }

      if (!google.earth.isInstalled()) {
    	  ge_problem='Google Earth API is not installed on this system';
      }

      if (ge_problem!='') {
          alert(ge_problem);
          addOverlays();
      } else {
    	googleEarth = new GoogleEarth(map);    	
    	google.maps.event.addListenerOnce(map, 'tilesloaded', addOverlays);
      }	
    <?php  } else { ?>
    addOverlays();    
    <?php  } ?>

   
    infowindow = new google.maps.InfoWindow();
    google.maps.event.addListener(map, 'click', function() {
        infowindow.close();
    });	
	map.setCenter (new google.maps.LatLng(0,0) );
	

}

function addGEruler() {

	 gex.util.lookAt([1, 1], { range: 800000, tilt: 40 });
	   
	    // create start and end placemark
	    var rulerColor = '#fc0';
	   
	    var placemarkOptions = {
	      style: {
	        icon: {
	          color: rulerColor,
	          stockIcon: 'paddle/wht-stars',
	          hotSpot: { left: '50%', bottom: 0 }
	        }
	      }
	    };
	   
	    var startPlacemark = gex.dom.addPointPlacemark([0, -1], placemarkOptions);
	    var endPlacemark = gex.dom.addPointPlacemark([0, 1], placemarkOptions);
	   
	    // create the distance updater function
	    var _updateDistance = function() {
	      document.getElementById('distance').innerHTML =
	          '~' +
	          (new geo.Point(startPlacemark.getGeometry()).distance(
	            new geo.Point(endPlacemark.getGeometry())) / 1609.344).toFixed(2) +
	          ' mi';
	    };
	   
	    // create the line placemark
	    var linePlacemark = gex.dom.addPlacemark({
	      lineString: {
	        path: [startPlacemark.getGeometry(),
	               endPlacemark.getGeometry()],
	        altitudeMode: ge.ALTITUDE_CLAMP_TO_GROUND,
	        tessellate: true
	      },
	      style: {
	        line: { color: rulerColor, opacity: 0.5, width: 10 }
	      }
	    });
	   
	    // make them draggable
	    var dragOptions = {
	      bounce: false,
	      dragCallback: function() {
	        linePlacemark.setGeometry(
	            gex.dom.buildLineString({
	              path: [startPlacemark.getGeometry(),
	                     endPlacemark.getGeometry()],
	              altitudeMode: ge.ALTITUDE_CLAMP_TO_GROUND,
	              tessellate: true
	            }));
	       
	        // update the distance on drag
	        _updateDistance();
	      }
	    };
	   
	    // show start distance
	    _updateDistance();
	   
	    gex.edit.makeDraggable(startPlacemark, dragOptions);
	    gex.edit.makeDraggable(endPlacemark, dragOptions);

		
}

var flights=[];
var MIN_START=86000;
var MAX_END=0;

var flightsList=[];

function addOverlays(){
	flightList.sort();
	for( var i in flightList ) {
		loadFlight(flightList[i]);
	}	
}


var tracksNum0=0;
var deleted=<? echo ($deletedFlights)?'1':'0'; ?>;

function loadFlight(flightID) {

	$.getJSON('EXT_flight.php?op=flight_info&flightID='+flightID+'&deleted='+deleted, function(data) {
        flightsList[tracksNum0]=flightID;
        tracksNum0++;

        flights[flightID]=[];
		flights[flightID]['data']=data;

		// display the kml track
		//flights[flightID]['kmlLayer'] =new google.maps.KmlLayer(data.flightKMZUrl);
		//flights[flightID]['kmlLayer'].setMap(map);

		var trackColor=trackColors[tracksNum];

		if (flightsTotNum==1) {
			trackColor=trackColors[2];
		}
        flights[flightID]['data']['color']=trackColor;


		if (data.START_TIME < MIN_START)	MIN_START=data.START_TIME ;
		if (data.END_TIME  > MAX_END) 	MAX_END=data.END_TIME ;

		
		
		if (is3D){
			var trackLayer = ge.createPlacemark('');
			var lineString = ge.createLineString('');
			trackLayer.setGeometry(lineString);
			var coords = lineString.getCoordinates();
			
			var lat=0;
			var lon=0;
			var alt=0;
			for(i=0;i<data.points.lat.length;i++) {
				  lon=+data.points.lon[i];
				  lat=+data.points.lat[i];
				  alt=+data.points.elev[i];
				  lineString.getCoordinates().pushLatLngAlt(lat,lon,alt);				 
			}
			lineString.setExtrude(false);
			lineString.setAltitudeMode(ge.ALTITUDE_ABSOLUTE);
			trackLayer.setStyleSelector(ge.createStyle(''));
			var lineStyle = trackLayer.getStyleSelector().getLineStyle();
			lineStyle.setWidth(2);
			lineStyle.getColor().set('ff'+rgb2bgr(trackColor));  // aabbggrr format
			ge.getFeatures().appendChild(trackLayer);
			flights[flightID]['trackLayer']=trackLayer;
		} else {
			var trackPoints=[];
			for(i=0;i<data.points.lat.length;i++) {
				trackPoints.push( new  google.maps.LatLng(data.points.lat[i],data.points.lon[i]) ) ;
			}
			flights[flightID]['trackLayer'] = new google.maps.Polyline({
				  path: trackPoints,
		          strokeColor: trackColor,
		          strokeOpacity: 1.0,
		          strokeWeight: 2,
		          map:map
			});
		}
		
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


		if (is3D) {

			var placemark = ge.createPlacemark('');
			// placemark.setName("placemark");			
			var icon = ge.createIcon('');
			icon.setHref(data.markerIconUrl);
			var style = ge.createStyle('');
			style.getIconStyle().setIcon(icon);
			placemark.setStyleSelector(style);

			// Create point
			var point = ge.createPoint('');
			point.set(+data.firstLat,+data.firstLon,0,ge.ALTITUDE_ABSOLUTE,false,false);
			placemark.setGeometry(point);

			ge.getFeatures().appendChild(placemark);
			posMarker[tracksNum] =placemark;
			
		} else {
			posMarker[tracksNum] = new google.maps.Marker({
				position: new google.maps.LatLng(data.firstLat,data.firstLon),       
				map: map,
				icon: data.markerIconUrl
			});

			altMarker[tracksNum]= new google.maps.Polyline({
				map: map,	          
	            strokeColor: trackColor,
	            strokeOpacity: 0.7,
	            strokeWeight: 3
			});
			
			varioMarker[tracksNum]= new google.maps.Polyline({
				map: map,	          
	            strokeColor: "#00ff00",
	            strokeOpacity: 0.7,
	            strokeWeight: 8
			});

			speedMarker[tracksNum]= new google.maps.Polyline({
				map: map,	          
	            strokeColor: trackColor,
	            strokeOpacity: 0.7,
	            strokeWeight: 5
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
			});
		}
		
		// now the graph , redraw if it not the first time called
		// only draw it one at the end
		if (tracksNum==(flightsTotNum-1)) {
			drawChart();
		}
		

		if (is3D) {
			// the task tps		
			displayTaskGE(data.task);		
			
			var bounds0 = gex.dom.computeBounds(flights[flightID]['trackLayer']);
			computeMinMaxLatLonGE(bounds0);
			
			if (bounds==null) {
				bounds=bounds0;
			} else {
				bounds.extend( new geo.Point([min_lat,max_lon]) );
				bounds.extend( new geo.Point([max_lat,min_lon]) );
			}
			
			if (tracksNum==(flightsTotNum-1) ) {	
				 
				computeMinMaxLatLonGE(bounds);
				gex.view.setToBoundsView(bounds, { aspectRatio: 1.0 });

				if (flightsTotNum==1) {				
					showTask=1;
					for (var i=0; i<taskLayer.length; i++) {	
						ge.getFeatures().appendChild(taskLayer[i]);
						
					}
				}
				
				if (airspaceCheck) {	
					toggleAirspace(false);
				}
				
			}
			
		} else {		
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
		}
				
		tracksNum++;

	});
	
}
	
</script>
</body>
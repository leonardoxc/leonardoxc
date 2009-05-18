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
// $Id: EXT_google_maps_track.php,v 1.44 2009/05/18 14:34:02 manolis Exp $                                                                 
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
		<? if ($CONF_airspaceChecks && L_auth::isAdmin($userID)  ) { ?>
			<input type="checkbox" value="1" checked id='airspaceShow' onClick="toggleAirspace(this)"><?=_Show_Airspace?>
		<?  } ?>
		</fieldset>
        
		<? if ( $CONF['thermals']['enable']  ) { ?>
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
        <? } ?>
		</div>
    </form>
	</td>

  </tr>
</table>
<div id="pdmarkerwork"></div>

<script src="<?=$moduleRelPath?>/js/google_maps/gmaps.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/google_maps/polyline.js" type="text/javascript"></script>

<script src="<?=$moduleRelPath?>/js/AJAX_functions.js" type="text/javascript"></script>

<? if ( $CONF['thermals']['enable']  ) { ?>
<script src="<?=$moduleRelPath?>/js/jquery.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/ClusterMarkerCustomIcon.js" type="text/javascript"></script>
<? } ?>

<script src="js/chartFX/wz_jsgraphics.js"></script>
<script src='js/chartFX/excanvas.js'></script>
<script src='js/chartFX/chart.js'></script>
<script src="js/chartFX/jgchartpainter.js"></script>
<script src='js/chartFX/canvaschartpainter.js'></script>
<link rel="stylesheet" type="text/css" href="js/chartFX/canvaschart.css">


<script type="text/javascript">
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

	//var kmlOverlay = new GGeoXml("http://pgforum.thenet.gr/modules/leonardo/download.php?type=kml_task&flightID=14142&t=a.kml");
	// var kmlOverlay = new GGeoXml("http://pgforum.thenet.gr/1.kml");
	//map.addOverlay(kmlOverlay);

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

<? if ($CONF_airspaceChecks && L_auth::isAdmin($userID)  ) { ?>
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
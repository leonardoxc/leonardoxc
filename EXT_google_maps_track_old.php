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
// $Id: EXT_google_maps_track_old.php,v 1.4 2010/03/14 20:56:10 manolis Exp $                                                                 
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
	$flight->updateCharts(0,1); // no force update, raw charts

	if ($flight->is3D() &&  is_file($flight->getChartfilename("alt",$PREFS->metricSystem,1))) {
		$chart1= $flight->getChartRelPath("alt",$PREFS->metricSystem,1);
		$title1="Altitude";
	} else if ( is_file($flight->getChartfilename("takeoff_distance",$PREFS->metricSystem,1)) ) {
		$chart1=$flight->getChartRelPath("takeoff_distance",$PREFS->metricSystem,1);
		$title1="Distance from takeoff";
	}

	$hlines=$flight->getRawHeader();
	foreach($hlines as $line) {
		if (strlen($line) == 0) continue;	  
		eval($line);
	}
	$START_TIME=$min_time;
	$END_TIME=$max_time;
	$DURATION=$END_TIME-$START_TIME;

?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$CONF_ENCODING?>">
<title>Google Maps</title>
<link rel='stylesheet' type='text/css' href='<?=$themeRelPath?>/css/google_maps.css' />
<script src="http://maps.google.com/maps?file=api&v=2&key=<?=$CONF_google_maps_api_key ?>" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/DHTML_functions.js" type="text/javascript"></script>
<? if (0) { ?>
<script src="<?=$moduleRelPath?>/js/google_maps/geo.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/google_maps/pdmarker.js" type="text/javascript"></script>
<? }?>

</head>
<body  onUnload="GUnload()">

<table border="0" cellpadding="0" cellspacing="0" class="mapTable">
  <tr>
	<td valign="top"><div style="position: relative; width: 600px; height:120px;"> 
	  <div style="position: absolute; top: 14px; left: 40px; z-index: 100; height:84px;  width:2px; background-color:#00FF00;" 
	  id="timeLine1"></div>
	   
	  <div style="position: absolute; float:right; right:20px; top: 1px; z-index: 50; padding-right:4px; text-align:right;
				 height:12px; width:130px; border:0px solid #777777; background-color:#F2F599;" 
	  id="timeBar"><?=$title1?></div>

	  <div id="chart" class="chart" style="width: 600px; height: 120px;"  onMouseMove="SetTimer(event)">
      <img style="position: absolute; top: 0px; left:0px; z-index: 0; cursor: crosshair;  border: 1px solid #999999;" 
	  id="imggraphs" src="<?=$chart1?>" onMouseMove="SetTimer(event)" alt="graphs" 
	  title="Move mouse to animate flight" border="0" 
	  height="120" width="600">
	  </div>
	</div></td>
	<td rowspan="2" valign="top">

	  <form name="form1" method="post" action="">
	  	<fieldset class="legendBox"><legend>Display</legend><BR />
			
			<a href='javascript:toogleFullScreen();'>Full screen On/Off</a>
		  
		</fieldset>
 		<fieldset class="legendBox"><legend>Info</legend><BR />
			<table align="right" cellpadding="2" cellspacing="0">
				<TR><td><div align="right">Time:</div></td><TD width=75><span id="timeText1" class='infoString'></span></TD></TR>
				<TR><td><div align="right">Speed:</div></td><TD><span id='speed' class='infoString'></span></TD></TR>
				<TR><td><div align="right">Alt:</div></td><TD><span id='alt' class='infoString'></span></TD></TR>
				<TR><td><div align="right">Vario:</div></td><TD><span id='vario' class='infoString'></span></TD></TR>
		</table>
		</fieldset>


		<fieldset class="legendBox"><legend>Control</legend><BR />
	
		<a href='javascript:zoomToFlight()'>Zoom to flight</a><hr />
		<div id="side_bar">
		</div> 
		<hr>
		<input type="checkbox" value="1" id='followGlider' onClick="toggleFollow(this)">Follow Glider<br>
		<input type="checkbox" value="1" checked id='showTask' onClick="toggleTask(this)">Show Task
		</fieldset>

		<? if ($CONF_airspaceChecks && auth::isAdmin($userID)  ) { ?>
				<fieldset class="legendBox"><legend>Admin</legend><BR />
				<input type="checkbox" value="1" checked id='airspaceShow' onClick="toggleAirspace(this)">Show Airspace
				</fieldset>
		<?  } ?>

    </form>
	</td>
  </tr>
  <tr>
	<td valign="top"><div id="map"></div></td>
  </tr>
</table>
<div id="pdmarkerwork"></div>

<script src="<?=$moduleRelPath?>/js/google_maps/gmaps.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/google_maps/polyline.js" type="text/javascript"></script>

<script src='js/chartFX/excanvas.js'></script>
<script src='js/chartFX/chart.js'></script>
<script src='js/chartFX/canvaschartpainter.js'></script>
<link rel="stylesheet" type="text/css" href="js/chartFX/canvaschart.css">


<script type="text/javascript">

var relpath="<?=$moduleRelPath?>";
var polylineURL="<?=$flight->getPolylineRelPath() ?>";
var jsonURL="http://<?=$_SERVER['SERVER_NAME'].'/modules/leonardo/'.$flight->getJsonRelPath() ?>";
var markerBg="img/icon_cat_<?=$flight->cat?>.png";
var posMarker;

var followGlider=0;
var airspaceShow=1;
var showTask=1;
var taskLayer=[];

var metricSystem=<?=$PREFS->metricSystem?>;

var altUnits="<? echo ' '.(($PREFS->metricSystem==1)?_M:_FT) ; ?>";
var speedUnits="<? echo ' '.(($PREFS->metricSystem==1)?_KM_PER_HR:_MPH) ; ?>";
var varioUnits="<? echo ' '.(($PREFS->metricSystem==1)?_M_PER_SEC:_FPM) ; ?>";

var ImgW = 600;
var StartTime = <?=$START_TIME?> ;
var EndTime = <?=$DURATION?> ;

var timeLine=new Array();
timeLine[1] = document.getElementById("timeLine1").style;

var marginLeft=40;
var marginRight=19;


var CurrTime=new Array();
CurrTime[1] = 0;
CurrTime[2] = EndTime;
DisplayCrosshair(1);

var lt=new Array();
var ln=new Array();
var d=new Array();
var a=new Array();
var s=new Array();
var v=new Array();
</script>

<script src="<?=$flight->getJsRelPath(1)?>" type="text/javascript"></script>

<script type="text/javascript">
//	var map = new GMap2(document.getElementById("map"),   {mapTypes:[G_HYBRID_MAP,G_SATELLITE_MAP,G_NORMAL_MAP]}); 
//	map.addControl(new GLargeMapControl());
//	map.addControl(new GMapTypeControl());
//	map.setCenter (new GLatLng(0,0), 4);

	// var kmlOverlay = new GGeoXml("http://pgforum.thenet.gr/modules/leonardo/download.php?type=kml_task&flightID=5251");
	// var kmlOverlay = new GGeoXml("http://pgforum.thenet.gr/1.kml");
	// map.addOverlay(kmlOverlay);

	var tp = <? echo $flight->gMapsGetTaskJS(); ?> ;
	
	// displayTask(tp);
	
	// GDownloadUrl(polylineURL, process_polyline);
	
	function drawChart(jsonString) {		
		var flightArray = eval("(" + jsonString + ")");		
		var c = new Chart(document.getElementById('chart'));
		c.setDefaultType(CHART_LINE );
		c.setGridDensity(5, 5);
		c.setVerticalRange(0, 100);
		c.setShowLegend(false);
		c.setHorizontalLabels(flightArray.time.label);
		c.add('Altitude',            '#FF3333', flightArray.elev);
		c.add('Ground Elev',        '#886D50', flightArray.elevGnd,CHART_AREA);
		c.draw();
	}

	function ajax(url, vars, callbackFunction){
        var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("MSXML2.XMLHTTP.3.0");
        request.open("GET", url, true);
		request.setRequestHeader("content-type","application/x-www-form-urlencoded");
        request.send(vars);
        request.onreadystatechange = function(){
			if (request.readyState == 4) {
				if (request.status == 200) {
					callbackFunction(request.responseText);
					//the_object = eval("(" + http_request.responseText + ")");
				} else {
					alert("There was a problem with the URL.");
				}
				request = null;
			}
		};
	}

	ajax(jsonURL,null,drawChart );

	window.onload = function() {
		//ieCanvasInit('includes/iecanvas.htc');
		// draw(); 
	};

</script>

<? if ($CONF_airspaceChecks && auth::isAdmin($userID)  ) { ?>
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

      GEvent.addListener(map, "click", function(overlay,point) {
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
      });

</script>
<? } ?>
</body>
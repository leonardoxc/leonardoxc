<? 
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
	$flight->getFlightFromDB($flightID);
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
<meta http-equiv="Content-Type" content="text/html; charset=<?=$lang['ENCODING']?>">
<title>Google Maps</title>
<style type="text/css">
 body, p, table,tr,td {font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px;}
 body {margin:0px; background-color:#E9E9E9}
.box {
	 background-color:#F4F0D5;
	 border:1px solid #555555;
	padding:3px; 
	margin-bottom:5px;
}
.boxTop {margin:0; }

.infoString{
	color:#FF6633;
	font-weight:bold;
}

#map { 
	 margin:0;
	 padding:0;
	 width:600px;
	 height:480px;
	 border: 1px solid #999999;
}
			 
#sidebar2 {   		
	  display:block; 
	  font-size: 11px;		  
	  border: 1px solid #999999;
	  height:100%;
	  margin-left:10px;
	  padding-left: 0.5em;
	  padding-right: 0.5em;
	  font-family: Helvetica, Arial, sans-serif;
}

.controls { margin: 0; padding: 0; font-size: 11px; text-align: left;  width: 100%;}
.controls button { font-size: 11px;	margin:0px;	padding:0px;	border:1px solid darkred; background-color: #eee;}
* html .controls button { margin: 0 2px 0 0px;  line-height: 12px; }

.info img { float: left; }
#zselect { padding-top: 1em; }
v\:* {
	  behavior:url(#default#VML);
}
     
div.markerTooltip, div.markerDetail {
	  color: black;
	  font-weight: bold;
	  background-color: white;
	  white-space: nowrap;
	  margin: 0;
	  padding: 2px 4px;
	  border: 1px solid black;
}

a:link, a:visited, a:active { font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; text-decoration:none;  }

fieldset.legendBox  { 
	height:auto;
	
	border-style: solid; 
	border-right-width: 2px; border-bottom-width: 2px; border-top-width: 1px; border-left-width: 1px;
	border-right-color: #999999; border-bottom-color: #999999; border-top-color: #E2E2E2; border-left-color: #E2E2E2;

	display:block;
	float:right;
	clear:both;

	padding:0;
	padding-left:3px; 	
	padding-bottom:4px;
	
	margin-bottom:0.5em;
	margin-right:0px;
	margin-left:3px;
	text-align:left;
	background-color:#f4f4f4;


	width:132px;
}


.legendBox legend {
	border:1px outset #E2E2E2;
	padding:0.2em 1.2em 0.2em 1.2em;
	margin:0;
	color:#000000;
	font-weight:bold;
	font-size:11px;
	background-color:#B7DEA8;
}

.imgBox {
	width:auto;
	display:block;
	float:right;
	clear:both;
	background-color:#F5F7F9;
	padding:3px;
	margin:3px;
}
.shadowBox {
	border-right-width: 2px; border-bottom-width: 2px; border-top-width: 1px; border-left-width: 1px;
	border-right-style: solid; border-bottom-style: solid; border-top-style: solid; border-left-style: solid;
	border-right-color: #999999; border-bottom-color: #999999; border-top-color: #E2E2E2; border-left-color: #E2E2E2;
}
</style>
<script src="http://maps.google.com/maps?file=api&v=2&key=<? echo $CONF_google_maps_api_key ?>" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/DHTML_functions.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/google_maps/geo.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/google_maps/pdmarker.js" type="text/javascript"></script>


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

      <img style="position: absolute; top: 0px; left:0px; z-index: 0; cursor: crosshair;  border: 1px solid #999999;" 
	  id="imggraphs" src="<?=$chart1?>" onMouseMove="SetTimer(event)" alt="graphs" 
	  title="Move mouse to animate flight" border="0" 
	  height="120" width="600">
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
		<input type="checkbox" value="1" id='followGlider' onclick="toggleFollow(this)">Follow Glider<br>
		<input type="checkbox" value="1" checked id='showTask' onclick="toggleTask(this)">Show Task
		</fieldset>

<? if ($CONF_airspaceChecks && auth::isAdmin($userID)  ) { ?>
 		<fieldset class="legendBox"><legend>Admin</legend><BR />
		<input type="checkbox" value="1" checked id='airspaceShow' onclick="toggleAirspace(this)">Show Airspace
		</fieldset>
<?  } ?>

    </form>
	<?
	/*
$images="";
for ( $photoNum=1;$photoNum<=$CONF_photosPerFlight;$photoNum++){
	$photoFilename="photo".$photoNum."Filename";
	if ($flight->$photoFilename) {
		$images.="<a class='shadowBox imgBox' href='".$flight->getPhotoRelPath($photoNum).
				"' target=_blank><img src='".$flight->getPhotoRelPath($photoNum).".icon.jpg' border=0></a>";
	}		
}

echo $images;
*/
?></td>
  </tr>
  <tr>
	<td valign="top"><div id="map"></div></td>
  </tr>
</table>
<div id="pdmarkerwork"></div>


<script type="text/javascript">
var relpath="<?=$moduleRelPath?>";
var fname="<?=$flight->getPolylineRelPath() ?>";
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

function moveMarker(){
	var pt =  posMarker.getPoint();
	var newpos= new GLatLng(pt.lat() + .001, pt.lng() + .001)
	posMarker.setPoint(newpos);
	// if (followGlider) map.setCenter(newpos, null);
}

function MWJ_findObj( oName, oFrame, oDoc ) {
	if( !oDoc ) { if( oFrame ) { oDoc = oFrame.document; } else { oDoc = window.document; } }
	if( oDoc[oName] ) { return oDoc[oName]; } if( oDoc.all && oDoc.all[oName] ) { return oDoc.all[oName]; }
	if( oDoc.getElementById && oDoc.getElementById(oName) ) { return oDoc.getElementById(oName); }
	for( var x = 0; x < oDoc.forms.length; x++ ) { if( oDoc.forms[x][oName] ) { return oDoc.forms[x][oName]; } }
	for( var x = 0; x < oDoc.anchors.length; x++ ) { if( oDoc.anchors[x].name == oName ) { return oDoc.anchors[x]; } }
	for( var x = 0; document.layers && x < oDoc.layers.length; x++ ) {
		var theOb = MWJ_findObj( oName, null, oDoc.layers[x].document ); if( theOb ) { return theOb; } }
	if( !oFrame && window[oName] ) { return window[oName]; } if( oFrame && oFrame[oName] ) { return oFrame[oName]; }
	for( var x = 0; oFrame && oFrame.frames && x < oFrame.frames.length; x++ ) {
		var theOb = MWJ_findObj( oName, oFrame.frames[x], oFrame.frames[x].document ); if( theOb ) { return theOb; } }
	return null;
}

	var ImgW = 600;
	var StartTime = <?=$START_TIME?> ;
	var EndTime = <?=$DURATION?> ;
	
	var timeLine=new Array();
	timeLine[1] = document.getElementById("timeLine1").style;
	
	var marginLeft=40;
	var marginRight=19;

	function getCurrentTime(ct) {
	   ct=ct/60;
	   h=Math.floor(ct/60);
  	   if (h<10) h="0"+h;
	   m=Math.floor(ct % 60);
	   if (m<10) m="0"+m;
	   return h+":"+m;
	}
	
	function MWJ_changeSize( oName, oWidth, oHeight, oFrame ) {
		var theDiv = MWJ_findObj( oName, oFrame ); if( !theDiv ) { return; }
		if( theDiv.style ) { theDiv = theDiv.style; }
		 var oPix = document.childNodes ? 'px' : 0;		
		 if( theDiv.resizeTo ) { theDiv.resizeTo( oWidth, oHeight ); }
		theDiv.width = oWidth + oPix; theDiv.pixelWidth = oWidth;
		theDiv.height = oHeight + oPix; theDiv.pixelHeight = oHeight;
	}

  function DisplayCrosshair(i){ // i=1 for the start , 2 end 	 
	   var Temp = Math.floor( (ImgW-marginLeft-marginRight) * CurrTime[i] / EndTime)
	   timeLine[i].left = marginLeft + Temp  + "px";
	   
		MWJ_changeContents('timeText'+i,getCurrentTime(StartTime + CurrTime[i]));
	  // timeText=document.getElementById("timeText"+i);
	  // timeText.value=;
	
	 //  timeTextSecs=document.getElementById("timeTextSecs"+i);
	 //  timeTextSecs.value=Math.floor(StartTime + CurrTime[i]);
 }

function refreshMap() {	
   // map.setMapType(G_NORMAL_MAP); 
   // map.setMapType(G_HYBRID_MAP);
}

function toggleFollow(radioObj) {
	if(!radioObj) return "";	
	if(radioObj.checked) followGlider=1;
	else followGlider=0;
}

function toggleTask(radioObj) {
	if(!radioObj) return "";	
	if(radioObj.checked) { 
		showTask=1;
	    for (var i=0; i<taskLayer.length; i++) {
			map.addOverlay(taskLayer[i]);
        }
	} else {
		showTask=0;
  		for (var i=0; i<taskLayer.length; i++) {
			map.removeOverlay(taskLayer[i]);
        }
	}
	refreshMap();	
}

function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	for(var ii = 0; ii < radioLength; ii++) {
		if(radioObj[ii].checked) {
			return radioObj[ii].value;
		}
	}
	return "";
}

function setValue(obj,target)
{		
//	var n = obj.selectedIndex;    // Which menu item is selected
	var val = obj.value;        // Return string value of menu item
	t=MWJ_findObj(target);
	t.value=val;	
}


function SetTimer(evt) {
   i=1; //getCheckedValue(document.forms[0].timeSel);
   if (typeof evt == "object") {
		if (evt.layerX > -1) {
		 CurrTime[i] = (evt.layerX -marginLeft) * EndTime / (ImgW-marginLeft-marginRight)
		} else if (evt.offsetX) {
		 CurrTime[i] = (evt.offsetX-marginLeft) * EndTime / (ImgW-marginLeft-marginRight)
		}
   }
  
	if ( CurrTime[1] <0 )  { CurrTime[1] =0; }
	if ( CurrTime[1] >= CurrTime[2]-4 )  { CurrTime[1] =CurrTime[2]-5; }
    DisplayCrosshair(i);

	// round up to 20secs..
	tm=Math.floor(CurrTime[1]/20)*20;

	// get the lat lon
	lat=lt[tm];
	lon=ln[tm];
	var newpos= new GLatLng(lat, lon);
	posMarker.setPoint(newpos);

	if (followGlider) map.setCenter(newpos, null);

	var speedStr=s[tm];
	var altStr=a[tm];
	var varioStr=v[tm];

	if (metricSystem==2) {
		speedStr*=0.62;
	}
	speedStr=Math.round(speedStr*10)/10;
	speedStr=speedStr+speedUnits;

	if (metricSystem==2) {
		altStr*=3.28;
	}
	altStr=Math.round(altStr);
	altStr=altStr+altUnits;

	if (metricSystem==2) {
		varioStr*=196.8;
		varioStr=Math.round(varioStr);
	} else {
		varioStr=Math.round(varioStr*10)/10;
	}
	varioStr=varioStr+varioUnits;

//	speed=document.getElementById("speed");
//    speed.value=speedStr;
	MWJ_changeContents('speed',speedStr);
	MWJ_changeContents('alt',altStr);
	MWJ_changeContents('vario',varioStr);

  }

  var CurrTime=new Array();
  CurrTime[1] = 0;
  CurrTime[2] = EndTime;
  DisplayCrosshair(1);
 // DisplayCrosshair(2);
   
	var lt=new Array();
	var ln=new Array();
	var d=new Array();
	var a=new Array();
	var s=new Array();
	var v=new Array();
</script>

<script src="<?=$flight->getJsRelPath(1)?>" type="text/javascript"></script>
<script language="javascript">
      // create the map
      var map = new GMap2(document.getElementById("map"),   {mapTypes:[G_HYBRID_MAP,G_SATELLITE_MAP,G_NORMAL_MAP]}); 
      map.addControl(new GLargeMapControl());
      map.addControl(new GMapTypeControl());
      map.setCenter(new GLatLng(0,0), 4);

	var taskicons=[];
          taskicons["s"]   = "img/icon_start.png";    
          taskicons["1"]   = "img/icon_1.png";
          taskicons["2"]   = "img/icon_2.png";
          taskicons["3"]   = "img/icon_3.png";
          taskicons["4"]   = "img/icon_4.png";
		  taskicons["5"]   = "img/icon_5.png";
          taskicons["e"]   = "img/icon_end.png";

      function createTaskMarker(point,name,ba) {      
			var Icon = new GIcon(G_DEFAULT_ICON, taskicons[ba]);
			Icon.iconSize=new GSize(16,24);
			//Icon.shadow = "http://maps.google.com/mapfiles/kml/pal3/icon61s.png";
			//Icon.shadowSize=new GSize(16,24);
			Icon.iconAnchor=new GPoint(3,20);
			Icon.infoWindowAnchor=new GPoint(16,0);

       		var marker = new GMarker(point,Icon,{title:name});

			posMarker=marker;
	        return marker;
      }

	// var kmlOverlay = new GGeoXml("http://pgforum.thenet.gr/modules/leonardo/download.php?type=kml_task&flightID=5251");
	//var kmlOverlay = new GGeoXml("http://pgforum.thenet.gr/1.kml");
	//map.addOverlay(kmlOverlay);
<? 
echo $flight->gMapsGetTaskJS(); 
?>
</script>
<script src="<?=$moduleRelPath?>/js/google_maps/polyline.js" type="text/javascript"></script>


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
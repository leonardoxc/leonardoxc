<? 
/*	$tmpDir=dirname(__FILE__);
	$tmpParts=split("/",str_replace("\\","/",$tmpDir));
	$module_name=$tmpParts[count($tmpParts)-1];
	$moduleAbsPath=dirname(__FILE__);
	$moduleRelPath=".";
	require_once dirname(__FILE__)."/config.php";
*/
 	require_once "EXT_config_pre.php";
	require_once "config.php";
 	require_once "EXT_config.php";

	require_once "CL_flightData.php";
	require_once "FN_functions.php";	
//	require_once "FN_UTM.php";
	require_once "FN_waypoint.php";	
	require_once "FN_output.php";
	require_once "FN_pilot.php";
//	require_once "FN_flight.php";
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

fieldset.legendBox { 
	width:130px;
	height:600px;
	border-style: solid; 
	border-right-width: 2px; border-bottom-width: 2px; border-top-width: 1px; border-left-width: 1px;
	border-right-color: #999999; border-bottom-color: #999999; border-top-color: #E2E2E2; border-left-color: #E2E2E2;

	padding:0 1em .5em 0.4em; 	
	margin-bottom:0.5em;
	margin-right:0px;
	margin-left:5px;
	text-align:left;
	background-color:#f4f4f4;
}
.legendBox legend {
	border:1px outset #E2E2E2;
	padding:0.2em 1.2em 0.2em 1.2em;
	margin:0;
	color:#000000;
	font-weight:bold;
	font-size:11px;
	background-color:#D9E9F1;
}

</style>
<script src="http://maps.google.com/maps?file=api&v=1&key=<? echo $CONF_google_maps_api_key ?>&amp;v=2" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/google_maps/geo.js" type="text/javascript"></script>
<script src="<?=$moduleRelPath?>/js/google_maps/pdmarker.js" type="text/javascript"></script>
</head>
<body  onUnload="GUnload()">

<? if (1) { ?>

<? } ?>
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
	  title="Click to set Time" border="0" 
	  height="120" width="600">
	</div></td>
	<td rowspan="2" valign="top">
		 <form name="form1" method="post" action="">
		<fieldset class="legendBox"><legend>Info</legend><BR />
	
		<a href='javascript:zoomToFlight()'>Zoom to flight</a><hr />
		<div id="side_bar">
		</div> 
		<hr>
	    <div align="right">Time: 
	        <input name="timeText1" id="timeText1" type="text" size="5" >
	    </div>
	    <div align="right">Speed: 
	        <input name="speed" id="speed" type="text" size="5" >
	    </div>
	    <div align="right">Alt: 
	        <input name="alt" id="alt" type="text" size="5" >
	    </div>
	    <div align="right">Vario: 
	        <input name="vario" id="vario" type="text" size="5" >
	    </div>
		</fieldset>
        </form></td>
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
 
function moveMarker(){
	var pt =  posMarker.getPoint();
	var newpos= new GLatLng(pt.lat() + .001, pt.lng() + .001)
	posMarker.setPoint(newpos);
	//map.setCenter(newpos, 17-5);
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
	   
	   timeText=document.getElementById("timeText"+i);
	   timeText.value=getCurrentTime(StartTime + CurrTime[i]);

	 //  timeTextSecs=document.getElementById("timeTextSecs"+i);
	 //  timeTextSecs.value=Math.floor(StartTime + CurrTime[i]);
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

	speed=document.getElementById("speed");
    speed.value=s[tm];
	alt=document.getElementById("alt");
    alt.value=a[tm];
	vario=document.getElementById("vario");
    vario.value=v[tm];

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
<? if (1) {?>
<script src="<?=$flight->getJsRelPath(1)?>" type="text/javascript"></script>
<? } ?>

<? if (1) {?>
<script src="<?=$moduleRelPath?>/js/google_maps/polyline.js" type="text/javascript"></script>
<? } ?>

</body>
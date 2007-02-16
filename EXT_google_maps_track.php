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
//	require_once "FN_functions.php";	
//	require_once "FN_UTM.php";
//	require_once "FN_waypoint.php";	
//	require_once "FN_output.php";
//	require_once "FN_pilot.php";
//	require_once "FN_flight.php";
//	setDEBUGfromGET();


?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Google Maps</title>
<style type="text/css">
.style1 { background-image:url(http://pgforum.thenet.gr/modules/leonardo/templates/basic/tpl/p19_logo.gif); width:142px; height:37px;}
#map { 
	 margin:0;
	 padding:0;
	 width:600px;
	 height:500px;
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
	width:115px;
	height:500px;
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
</head>
<body onunload="GUnload()">

<? if (0) { ?>
<div id="control" class="style1"><b><? $_SERVER['SERVER_NAME']?></b></div>
<a href="javascript:moveit()">move it </a>

 <div style="position: relative; width: 500px; height:100px;"> 
<div style="position: absolute; top: 5px; left: 0px; z-index: 100; height:100px; left: 0px; width:2px; background-color:#FF0000;" 
              id="timeLine"></div>
              <img style="position: absolute; top: 0px; left:0px; z-index: 0; cursor: crosshair;" 
              id="imggraphs" src="{AMIM_ALT_GRAPH_IMG}"  onmousemove="moveit()" alt="graphs" 
              title="{#_Click_to_set_Time}" border="0" 
              height="100" width="500"> </div> 
</div>
<? } ?>
<table border="0" cellpadding="0" cellspacing="0" class="mapTable">
  <tr>
	<td><div id="map"></div></td>
	<td valign="top"><fieldset class="legendBox"><legend>Info</legend><BR />
	
	<a href='javascript:zoomToFlight()'>Zoom to flight</a><hr /><div id="side_bar"></div></fieldset></td>
  </tr>

</table>
<div id="pdmarkerwork"></div>

<script type="text/javascript">
if(window.location.search) {
	// Was a file specified?
	var params = window.location.search.slice(1).split("&");
	var vals = new Array(params.length);
	for(var i = 0;i < params.length;i++) {
		var item = params[i].split("=");
		vals[item[0]] = item[1];
	}

	if(vals["file"]) {
		if(vals["zoom"]) {
			zoom = parseInt(vals["zoom"]);
		} else {
			zoom = 4;
		}
		var fname=vals["file"];  
		fname=fname.replace("\/\/","\/");
	}
}
var relpath="<?=$moduleRelPath?>";
</script>
<script src="<?=$moduleRelPath?>/js/google_maps/polyline.js" type="text/javascript"></script>

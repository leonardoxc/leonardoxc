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
// $Id: visugps.php,v 1.6 2008/11/29 22:46:07 manolis Exp $                                                                 
//
//************************************************************************

/***********************************************************************
This file is part of VisuGps

VisuGps is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

VisuGps is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

Copyright (c) 2007 Victor Berchet, <http://www.victorb.fr>
***********************************************************************/


 	require_once dirname(__FILE__)."/EXT_config_pre.php";
	require_once dirname(__FILE__)."/config.php";
 	require_once dirname(__FILE__)."/EXT_config.php";

	require_once dirname(__FILE__)."/CL_flightData.php";
	require_once dirname(__FILE__)."/FN_functions.php";	
	require_once dirname(__FILE__)."/FN_waypoint.php";	
	require_once dirname(__FILE__)."/FN_output.php";
	require_once dirname(__FILE__)."/FN_pilot.php";

	$moduleRelPath=moduleRelPath(0); 

	$flightID=makeSane($_GET['flightID'],1);
	if ($flightID<=0) exit;
	
	$flight=new flight();
	$flight->getFlightFromDB($flightID,0);

	require_once dirname(__FILE__).'/lib/visugps/php/vg_proxy.php';
	
	if (!is_file($flight->getJsonFilename()) ) {
		writeFile( $flight->getJsonFilename(), MakeTrack($flight->getIGCFilename(0) ) );
	}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Carte du Vol</title>

    <style type="text/css">
    v\:* { behavior:url(#default#VML);}
    html, body {width: 100%; height: 100%}
    body {margin: 0px;}

    #map2 {width: 100%; height: 80%}
    #load2 {width: 100%; height: 100%; top:0px; left:0px; position:absolute; z-index:3000;
           background: #4682b4 url("img/loading.gif") no-repeat center center;
           text-align: center; font:15px Verdana, Arial, sans-serif; color:black; font-weight:bold;}

    </style>

<link rel='stylesheet' type='text/css' href='lib/visugps/css/visugps.css' />
<link rel='stylesheet' type='text/css' href='js/chart/canvaschart.css' />
<script src='js/mootools/mootools.v1.11.js'></script>
<script src='js/visugps/charts.js'></script>
<script src='js/visugps/sliderprogress.js'></script>
<script src='js/visugps/visugps.js'></script>
<script src='js/chart/canvaschartpainter.js'></script>
<script src='js/chart/chart.js'></script>
<script src='js/chart/excanvas.js'></script>

<? if (1) { ?><script src='http://www.google.com/jsapi?key=<?=$CONF_google_maps_api_key?>'></script>
<? } else {?>
<script src="http://maps.google.com/maps?file=api&v=2&key=<? echo $CONF_google_maps_api_key ?>" type="text/javascript"></script>

<script src="js/google_maps/geo.js" type="text/javascript"></script>
<script src="js/google_maps/pdmarker.js" type="text/javascript"></script>

<? } ?>

<script>
	google.load('maps', '2.x');
	



	var kMap = null;
	window.addEvent('unload', cleanMap);	
	window.addEvent('domready', function() {
		kMap = new VisuGps(	
			{
			 //	proxyPath: 'lib/visugps/php/vg_proxy.php' 
			 //	elevTileUrl: ['<?=$_SERVER['SERVER_NAME'].getRelMainDir()."lib/visugps/php"?>']
			}	
		);
		
		kMap.tp = <? echo $flight->gMapsGetTaskJS(); ?> ;

		
		kMap.downloadTrack('http://<?=$_SERVER['SERVER_NAME'].getRelMainDir().$flight->getJsonRelPath();?>');	  
	});
	

	function cleanMap() {
		kMap.clean();
		kMap = null;
		// GUnload();
	}

</script>

</head>
<body  onUnload="google.maps.Unload()"> 
	<div id='map'></div>		
	<div id='vgps-chartcont'></div>	
	<div id='load'></div>
</body>
</html>
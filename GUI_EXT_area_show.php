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
// $Id: GUI_EXT_area_show.php,v 1.3 2010/03/14 20:56:10 manolis Exp $                                                                 
//
//************************************************************************
	
	require_once dirname(__FILE__)."/EXT_config_pre.php";
	require_once dirname(__FILE__)."/config.php";
	$CONF_use_utf=1;
 	require_once dirname(__FILE__)."/EXT_config.php";
 	require_once dirname(__FILE__)."/CL_area.php";
	

	$areaID=makeSane($_GET['areaID'],0);
?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
  <head>
    <title>Google Maps</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script src="http://maps.google.com/maps?file=api&v=2&key=<?=$CONF_google_maps_api_key ?>" type="text/javascript"></script>
	<script src="<?=$moduleRelPath?>/js/AJAX_functions.js" type="text/javascript"></script>
	
	
	<script src="<?=$moduleRelPath?>/js/jquery.js" type="text/javascript"></script>
	<script src="<?=$moduleRelPath?>/js/facebox/facebox.js" type="text/javascript"></script>
	<link href="js/facebox/facebox.css" media="screen" rel="stylesheet" type="text/css"/>
	<style type="text/css">
	<!--
		body{margin:0}
		
		table,td,tr { font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px; }
		
div#floatDiv , div#takeoffInfoDiv
{

  width: 20%;
  float: right;
  border: 1px solid #8cacbb;
  margin: 0.5em;
  background-color: #dee7ec;
  padding-bottom: 5px;
 
   position :fixed;
   right    :0.5em;
   top      :13em;
   width    :15em;

   display:none;
}

div#takeoffInfoDiv {
	float :left;
	left : 0.5em;
}

div#floatDiv h3, div#takeoffInfoDiv h3
{
	margin:0;
	font-size:12px;
	background-color:#336699;
	color:#FFFFFF;
}

#sidebar {
  cursor: pointer;
  text-decoration:underline;
  color: #4444ff;
  padding-right:0;
}

#sidebar a, #sidebar a:visited,  #sidebar div { 
  color: #4444ff;
  margin-bottom:5px;
  padding:4px;
  padding-right:0;
  line-height:15px;
}

#takeoffHeader {
width:100%;
background-color:#FF9933;
font-size:12px;
margin-bottom:5px;
color:#FFFFFF;
padding:5px;
padding-right:0;
}

#takeoffHeader a { 
color:#FFFFFF;
padding:5px;
}
	-->
	
	</style>
  </head>
<body>

<div id ='floatDiv'>
	<h3>Results</h3>
	<div id ='resDiv'><BR /><BR /></div>
</div>

<? 
$area=new area($areaID);
$area->getFromDB();
?>
<table border="0" cellpadding="0" cellspacing="0" width=720> 
<tr>
  <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="100"><div id='takeoffHeader'>Area</div></td>
      <td ><div id='takeoffHeader'><b><?=$area->name?></b></div></td>
    </tr>
    <tr>
      <td colspan="2"><?=$area->desc?></td>
      </tr>
	 <tr>
      <td colspan=2>&nbsp;</td>
    </tr>
  </table></td>
  </tr>
<tr>
	<td><div name="map" id="map" style="width:565px; height: 450px"></div></td>
		<td width = 150 valign="top" bgcolor="#F4F4EA" >
			<div id='takeoffHeader'>Takeoffs</div>
			<div id="sidebar"></div>		</td>
</tr>
<tr>
	<td  colspan=2>
		
		<div id="siteInfo"></div>	</td>
</tr>
</table>
<script type="text/javascript">
	$(document).ready(function(){
	  $('a[rel*=facebox]').facebox()
	})

    //<![CDATA[
	if (GBrowserIsCompatible() ) {
	
	var wpID=0;	
	var site_list_html = "";
		
	// Creates a marker whose info window displays the given description 
	function createMarker(point, id , description, iconUrl, shadowUrl ) {
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
		

		site_list_html += '<a href="javascript:openSite(' + id + ')">' + description + '</a><br>';
	
	    GEvent.addListener(marker, "click", function() {
	  	  getAjax('EXT_takeoff.php?op=get_info&inPageLink=1&wpID='+id,null,openMarkerInfoWindow);
	    });
	
	    return marker;
	}

	function openSite(id)	{
		getAjax('EXT_takeoff.php?op=get_info&inPageLink=1&wpID='+id,null,openMarkerInfoWindow);
		// gmarkers[i].openInfoWindowHtml(htmls[i]);
	}
	
	function show_waypoint(id) {
	
		 jQuery.facebox(
		 	function() {
			  jQuery.get("GUI_EXT_waypoint_info.php?wID="+id, function(data) {
				  jQuery.facebox (data )
		  			}
				)
		})
		//$("#siteInfo").load("GUI_EXT_waypoint_info.php?wID="+id);	
	}
	
	function openMarkerInfoWindow(jsonString) {
		var results= eval("(" + jsonString + ")");			
		var i=results.takeoffID;
		var html=results.html;
		takeoffMarkers[i].openInfoWindowHtml(html);
	}
	
	var map = new GMap2(document.getElementById("map"),  {mapTypes:[G_HYBRID_MAP,G_NORMAL_MAP,G_PHYSICAL_MAP,G_SATELLITE_MAP]}); 

	//	map.addControl(new GSmallMapControl());
	map.addControl(new GLargeMapControl());
	map.addControl(new GMapTypeControl());
	// map.addControl(new GOverviewMapControl(new GSize(200,120)));


	var takeoffPoint= new GLatLng(40, 22) ;
	map.setCenter(takeoffPoint , 8);
		
	var iconUrl		= "http://maps.google.com/mapfiles/kml/pal2/icon5.png";
	var shadowUrl	= "http://maps.google.com/mapfiles/kml/pal2/icon5s.png";	
			
		
	var takeoffMarkers=[];
	var bounds = new GLatLngBounds();

	function drawTakeoffs(jsonString){
	 	var results= eval("(" + jsonString + ")");		
		//$("#resDiv").html(results.waypoints.length);
		for(i=0;i<results.waypoints.length;i++) {	
			var takeoffPoint= new GLatLng(results.waypoints[i].lat, results.waypoints[i].lon) ;
			
			//$("#resDiv").append('#'+results.waypoints[i].lat+'#'+ results.waypoints[i].lon+'#'+results.waypoints[i].id+'#'+
			 //results.waypoints[i].name+'$');
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
			
			var takeoffMarker= createMarker(takeoffPoint,results.waypoints[i].id, results.waypoints[i].name,iconUrl,shadowUrl);
			takeoffMarkers[takeoffPoint,results.waypoints[i].id] = takeoffMarker;		
			map.addOverlay(takeoffMarker);
			bounds.extend(takeoffPoint);
		}	
		map.setZoom(map.getBoundsZoomLevel(bounds));
		map.setCenter(bounds.getCenter());

		//minimap.setZoom(minimap.getBoundsZoomLevel(bounds));
		//minimap.setCenter(bounds.getCenter());

		$("#sidebar").html(site_list_html);
	}

<? if(0) { ?>

 	// create the crosshair icon, which will indicate where we are on the minimap
    // Lets not bother with a shadow
      var Icon = new GIcon();
      Icon.image = "xhair.png";
      //Icon.shadow = "http://www.google.com/mapfiles/shadow50.png";
      Icon.iconSize = new GSize(21, 21);
      Icon.shadowSize = new GSize(0,0);
      Icon.iconAnchor = new GPoint(11, 11);
      Icon.infoWindowAnchor = new GPoint(11, 11);
      Icon.infoShadowAnchor = new GPoint(11, 11);

      // Create the minimap
      var minimap = new GMap(document.getElementById("minimap"));
	  minimap.addControl(new GScaleControl());
      minimap.centerAndZoom(new GPoint(0,0), 12);
      
      // Add the crosshair marker at the centre of the minimap and keep a reference to it
      
      var xhair = new GMarker(minimap.getCenterLatLng(), Icon);            
      minimap.addOverlay(xhair);
      
      
      // ====== Handle the Map movements ======
      
      // Variables that log whether we are currently causing the maps to be moved
    
      var map_moving = 0;
      var minimap_moving = 0;
    
      // This function handles what happens when the main map moves
      // If we arent moving it (i.e. if the user is moving it) move the minimap to match
      // and reposition the crosshair back to the centre
      function Move(){
        minimap_moving = true;
		if (map_moving == false) {
	
		  minimap.centerAtLatLng(map.getCenterLatLng());
		  xhair.point = map.getCenterLatLng();
		  xhair.redraw(true);
		}
		minimap_moving = false;
      }
	  
      // This function handles what happens when the mini map moves
      // If we arent moving it (i.e. if the user is moving it) move the main map to match
      // and reposition the crosshair back to the centre
      function MMove(){
        map_moving = true;
		if (minimap_moving == false) {
		  map.centerAtLatLng(minimap.getCenterLatLng());
		  xhair.point = minimap.getCenterLatLng();
		  xhair.redraw(true);
		}
		map_moving = false;
      }
      
      // Listen for when the user moves either map
      GEvent.addListener(map, 'move', Move);
      GEvent.addListener(minimap, 'moveend', MMove);
      
 <? } ?>	
 
	getAjax('EXT_takeoff.php?op=getTakeoffsForArea&areaID=<?=$areaID?>',null,drawTakeoffs);


}
    //]]>
</script>
</body>
</html>
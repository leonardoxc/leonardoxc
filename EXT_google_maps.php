<?
	$module_name = basename(dirname(__FILE__));		
	$moduleAbsPath=dirname(__FILE__);
	$moduleRelPath=".";

	require "config.php";

	$wpLon=makeSane($_GET[lon],1);
	$wpLat=makeSane($_GET[lat],1);
	$wpName=makeSane($_GET[wpName]);
?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
  <head>
    <title>Google Maps</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script src="http://maps.google.com/maps?file=api&v=2&key=<?=$CONF_google_maps_api_key ?>" type="text/javascript"></script>
	<style type="text/css">
	<!--
		body{margin:0}
	-->
	</style>
  </head>
<body>
<div name="map" id="map" style="width: 710px; height: 420px"></div>
<script type="text/javascript">
    //<![CDATA[
	if (GBrowserIsCompatible() ) {
		var lat=<?= $wpLat ?>;
		var lon=<?=$wpLon ?>;
		
			// Creates a marker whose info window displays the given description 
	function createMarker(point, id , description, iconUrl, shadowUrl ) {
		if (iconUrl){
			var baseIcon = new GIcon();
			baseIcon.iconSize=new GSize(24,24);
			baseIcon.shadowSize=new GSize(42,24);
			baseIcon.iconAnchor=new GPoint(12,24);
			baseIcon.infoWindowAnchor=new GPoint(12,0);
			  
			var newIcon = new GIcon(baseIcon, iconUrl, null,shadowUrl);
				
			var marker = new GMarker(point,newIcon);
		} else {
			var marker = new GMarker(point);		
		}	
	  // Show this marker's index in the info window when it is clicked
	  var html = "<b>" + description + "</b><br>";
	  html+="<img src='img/icon_magnify_small.gif' align='absmiddle' border=0> <a href='/<?=CONF_MODULE_ARG?>&op=list_flights&takeoffID="+id+"&year=0&month=0&pilotID=0&country=0&cat=0'><? echo  _See_flights_near_this_point ?></a>";
	  
	  GEvent.addListener(marker, "click", function() {
		marker.openInfoWindowHtml(html);
	  });
	
	  return marker;
	}


		// var map = new GMap(document.getElementById("map"),[  G_HYBRID_TYPE, G_PHYSICAL_MAP, G_SATELLITE_TYPE ,G_MAP_TYPE  ]);
		var map = new GMap2(document.getElementById("map"),  {mapTypes:[G_NORMAL_MAP,G_HYBRID_MAP,G_PHYSICAL_MAP,G_SATELLITE_MAP]}); 

		//	map.addControl(new GSmallMapControl());
		map.addControl(new GLargeMapControl());
		map.addControl(new GMapTypeControl());
		map.addControl(new GOverviewMapControl(new GSize(200,120)));



		var takeoffPoint= new GLatLng(lat, lon) ;
		map.setCenter(takeoffPoint , 8);
		
		var iconUrl		= "http://maps.google.com/mapfiles/kml/pal2/icon5.png";
		var shadowUrl	= "http://maps.google.com/mapfiles/kml/pal2/icon5s.png";	
			
	//	var takeoffMarker= createMarker(takeoffPoint,"<?= $wpName ?>",iconUrl,shadowUrl);
	//	map.addOverlay(takeoffMarker);
		
	function getTakeoffsAjax(url, vars, callbackFunction){
     	//  var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("MSXML2.XMLHTTP.3.0");
		// var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");	  
		
		if (window.XMLHttpRequest) {
		 	// browser has native support for XMLHttpRequest object
			var request= new XMLHttpRequest();
		} else if (window.ActiveXObject) {
		 	// try XMLHTTP ActiveX (Internet Explorer) version
			var request = new ActiveXObject("Microsoft.XMLHTTP");
			// alert("ie");
		} else   {
         alert('Your browser does not seem to support XMLHttpRequest.');
	    }

		// alert(url);
        request.open("GET", url, true);
        request.onreadystatechange = function(){
			if (request.readyState == 4 || request.readyState=='complete') {
				if (request.status == 200) {
					//  alert("OK  URL.");
					callbackFunction(request.responseText);
					//the_object = eval("(" + http_request.responseText + ")");
				} else {
					alert("There was a problem with the URL "+url);
				}
				request = null;
			}
		};
		// i have moved this below see
		// http://keelypavan.blogspot.com/2006/03/reusing-xmlhttprequest-object-in-ie.html
		// http://blog.davber.com/2006/08/22/ajax-and-ie-caching-problems/
		request.setRequestHeader("content-type","application/x-www-form-urlencoded");
	 	request.send(vars);
	}

	
	function drawTakeoffs(jsonString){
	 	var results= eval("(" + jsonString + ")");		
		// document.writeln(results.waypoints.length);
		for(i=0;i<results.waypoints.length;i++) {	
			var takeoffPoint= new GLatLng(results.waypoints[i].lat, results.waypoints[i].lon) ;
			

		if (results.waypoints[i].type<1000) {
			var iconUrl		= "http://maps.google.com/mapfiles/kml/pal3/icon21.png";
			var shadowUrl	= "http://maps.google.com/mapfiles/kml/pal3/icon21s.png";
		} else {
			var iconUrl		= "http://maps.google.com/mapfiles/kml/pal2/icon13.png";
			var shadowUrl	= "http://maps.google.com/mapfiles/kml/pal2/icon13s.png";		
		}
		
		var takeoffMarker= createMarker(takeoffPoint,results.waypoints[i].id, results.waypoints[i].name,iconUrl,shadowUrl);
			map.addOverlay(takeoffMarker);
		}	
	}
	getTakeoffsAjax('EXT_takeoff.php?op=get_nearest&lat='+lat+'&lon='+lon,null,drawTakeoffs);
	

}
    //]]>
</script>
</body>
</html>
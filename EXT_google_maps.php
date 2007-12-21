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

		// Creates a marker whose info window displays the given description 
		function createMarker(point, description ) {
		  var marker = new GMarker(point);
		
		  // Show this marker's index in the info window when it is clicked
		  var html = "<b>" + description + "</b>";
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
		map.addControl(new GOverviewMapControl());



		var takeoffPoint= new GLatLng(<?= $wpLat ?>, <?=$wpLon ?>) ;
		map.setCenter(takeoffPoint , 8);
		
		var takeoffMarker= createMarker(takeoffPoint,"<?= $wpName ?>");
		map.addOverlay(takeoffMarker);
		
}
    //]]>
</script>
</body>
</html>
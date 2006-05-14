<? 
	$tmpDir=dirname(__FILE__);
	$tmpParts=split("/",str_replace("\\","/",$tmpDir));
	$module_name=$tmpParts[count($tmpParts)-1];
	$moduleAbsPath=dirname(__FILE__);
	$moduleRelPath=".";

	require "config.php";

	$wpLon=$_GET[lon]+0;
	$wpLat=$_GET[lat]+0;
	$wpName=$_GET[wpName];
?>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Google Maps</title>
	<script src="http://maps.google.com/maps?file=api&v=1&key=<? echo $CONF_google_maps_api_key ?>" type="text/javascript"></script>
  </head>
<body>
<div name="map" id="map" style="width: 680px; height: 400px"></div>
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

		var map = new GMap(document.getElementById("map"),[  G_HYBRID_TYPE, G_SATELLITE_TYPE ,G_MAP_TYPE  ]);
	//	map.addControl(new GSmallMapControl());
		map.addControl(new GLargeMapControl());
		map.addControl(new GMapTypeControl());
	
		var takeoffPoint= new GPoint(<? echo $wpLon ?>, <? echo $wpLat ?> ) ;
	
		map.centerAndZoom(takeoffPoint , 4);
		takeoffMarker= createMarker(takeoffPoint,"<? echo $wpName ?>");
		map.addOverlay(takeoffMarker);
}
    //]]>
</script>
</body>
</html>

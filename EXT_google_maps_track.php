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

if (0) {
?>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Google Maps</title>
	<style type="text/css">
      .style1 {background-color:#ffffff;font-weight:normal;border:1px #006699 solid;}
    </style>
	<script src="http://maps.google.com/maps?file=api&v=1&key=<? echo $CONF_google_maps_api_key ?>&amp;v=2" type="text/javascript"></script>
  </head>
<body>
<div id="control" class="style1"><b>Leonardo at <? $_SERVER['SERVER_NAME']?></b></div>
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
/*
		var map = new GMap(document.getElementById("map"),[  G_HYBRID_TYPE, G_SATELLITE_TYPE ,G_MAP_TYPE  ]);
	//	map.addControl(new GSmallMapControl());
		map.addControl(new GLargeMapControl());
		map.addControl(new GMapTypeControl());
	
		var takeoffPoint= new GPoint(<? echo $wpLon ?>, <? echo $wpLat ?> ) ;
	
		map.centerAndZoom(takeoffPoint , 4);
		takeoffMarker= createMarker(takeoffPoint,"<? echo $wpName ?>");
		map.addOverlay(takeoffMarker);
*/
var map = new GMap2(document.getElementById("map"));
map.addControl(new GSmallMapControl());
map.addControl(new GMapTypeControl());
map.setCenter(new GLatLng(37.4419, -122.1419), 13);

// Download the data in data.xml and load it on the map. The format we
// expect is:
// <markers>
//   <marker lat="37.441" lng="-122.141"/>
//   <marker lat="37.322" lng="-121.213"/>
// </markers>
GDownloadUrl("/data.xml", function(data, responseCode) {
  var xml = GXml.parse(data);
  var markers = xml.documentElement.getElementsByTagName("marker");
  for (var i = 0; i < markers.length; i++) {
    var point = new GLatLng(parseFloat(markers[i].getAttribute("lat")),
                            parseFloat(markers[i].getAttribute("lng")));
    map.addOverlay(new GMarker(point));
  }
});

      var pos = new GControlPosition(G_ANCHOR_BOTTOM_LEFT, new GSize(60,6));
      pos.apply(document.getElementById("control"));
      map.getContainer().appendChild(document.getElementById("control"));
}
    //]]>
</script>
</body>
</html>
<? } else { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!-- arch-tag: f0db8795-3291-41bc-a66e-def764bfc8ef
     (do not change this comment) -->
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
  <head>
    <title>Gmap GPS Track Plotting</title>
	<script src="http://maps.google.com/maps?file=api&v=1&key=<? echo $CONF_google_maps_api_key ?>&amp;v=2" type="text/javascript"></script>
    <script src="<?=$moduleRelPath?>/js/google_maps/reqcache.js" type="text/javascript"></script>
    <script src="<?=$moduleRelPath?>/js/google_maps/gmapgpx.js" type="text/javascript"></script>

    <script src="<?=$moduleRelPath?>/js/google_maps/geo.js" type="text/javascript"></script>
    <script src="<?=$moduleRelPath?>/js/google_maps/colors.js" type="text/javascript"></script>
    <style type="text/css">
	  .style1 { background-image:url(http://pgforum.thenet.gr/modules/leonardo/templates/basic/tpl/p19_logo.gif); width:142px; height:37px;}
      #map { 
             height: 400px;
             border: 2px solid #000;
             margin-right: 260px;
             margin-left: 10px; }
      #info { position: absolute;
              top: 10px;
              right: 5px;
              width: 200px;
              font-size: 80%;
              border: 1px solid #000;
              padding-left: 1em;
              padding-right: 1em;
              font-family: Helvetica, Arial, sans-serif;
             }
      #title { text-align: center;
               font-family: Helvetica, Arial, sans-serif;
             }
      #intro {height: 250px;
              font-size: 80%;
              font-family: Helvetica, Arial, sans-serif;}
      .desc { text-align: center; }
      .info img { float: left; }
      #zselect { padding-top: 1em; }
      v\:* {
              behavior:url(#default#VML);
           }
    </style>
    <script type="text/javascript">
    //<![CDATA[
    var map = null;
    var speed_mult = 0;
    var fcancel = null;
    var maxZ = 0;

    function initialize(startpt) {
        map = new GMap(document.getElementById("map"));
        map.addControl(new GSmallMapControl());
        map.addControl(new GMapTypeControl());
        map.addControl(new GScaleControl());
        map.centerAndZoom(startpt, 13);

        // Start with animation disabled
        var e = document.getElementById("speed");
        e.options[0].selected = 1;
        speed_mult = 0;

        e = document.getElementById("zmax");
        e.disabled = true;
        e.options[0].selected = 1;
        maxZ = 0;

        e = document.getElementById("varcolor");
        e.checked = false;
        e.disabled = true;

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

                showtracks(vals["file"], zoom);
            }
        }
      var pos = new GControlPosition(G_ANCHOR_BOTTOM_LEFT, new GSize(200,0));
      pos.apply(document.getElementById("control"));
      map.getContainer().appendChild(document.getElementById("control"));
    }

    // Implement a "ballistic zoom" -- so called because it
    // simulates the view from a ballistic missile...
    function boom_zoom(map, zoom_end, dt, fdone) {
        var inc = (map.getZoomLevel() > zoom_end) ? -1 : 1;
        function run_it() {
            var zoom = map.getZoomLevel();
            if(zoom != zoom_end) {
                map.zoomTo(zoom+inc);
                setTimeout(run_it, dt);
            } else {
                if(fdone)
                    fdone();
            }
        }

        run_it();
    }

    function set_speed_mult(val) {
        // Disable elevation-based line coloring when
        // animation is disabled.
        var e = document.getElementById("varcolor");

        speed_mult = val;
        if(speed_mult == 0) {
            e.checked = false;
            e.disabled = true;
        } else {
            e.disabled = false;
        }
    }

    function show_elev(box) {
        var sel = document.getElementById("zmax");
        if(box.checked) {
            sel.disabled = false;
        } else {
            maxZ = 0;
            sel.options[0].selected = 1;
            sel.disabled = true;
        }
    }

    // Display all of the tracks from a GPX file at the specified
    // zoom level. Input from the UI determines whether we will
    // animate the track or display it statically.
    function showtracks(file, zoom) {
        var colors = ["#ff0000", "#00ff00", "#0000ff",
                      "#ffff00", "#00ffff", "#ff00ff",
                      "#000000", "#ffffff"];
        map.clearOverlays();


        // Setup function to center and zoom the map appropriately
        // to display the tracks
        var f_setup = function(gpx, f_next) {
          var bounds = get_bounds(gpx);
          var cx, cy;

          if(bounds) {
              cx = (bounds.maxX + bounds.minX)/2.;
              cy = (bounds.minY + bounds.maxY)/2.;
          } else {
              var node = gpxGetElements(gpx, "trkpt")[0];
              cx = parseFloat(node.getAttribute("lon"));
              cy = parseFloat(node.getAttribute("lat"));
          }

          map.setMapType(G_MAP_TYPE);
          map.centerAndZoom(new GPoint(cx, cy), 13);
 
          var cbox = document.getElementById("ballzoom");
          
          // Try to determine the best zoom level using the bounding-box
          // information from the file.
          if(bounds)
              zoom = best_zoom(bounds, document.getElementById("map"));

          // Ballistic zoom or normal zoom?
          if(cbox && cbox.checked)
              boom_zoom(map, zoom, 2500, function(){f_next(gpx);});
          else {
              map.zoomTo(zoom);
              setTimeout(function(){f_next(gpx);}, 2500);
          }
        }

        // Animate the tracks
        var f_animate = function(gpx) {
          try {
              map.setMapType(G_SATELLITE_TYPE);
          } catch (error) {
              map.setMapType(_SATELLITE_TYPE);
          }

          var segs = gpxGetElements(gpx, "trkseg");
          var segnum = 0;
          var n = colors.length;
          function animation () {
              fcancel = animate_segment(segs[segnum], map, 
                              {'scale' : speed_mult, 
                               'skip' : 2,
                               'color' : colors[segnum%n],
                               'zcolor' : maxZ,
                               'fdone' : function (){
                                             segnum++; 
                                             if(segnum < segs.length)
                                                 animation();
                                             else
                                                 alert("Animation done");
                                         }});
          }

          animation();
        };

        // Display the tracks.
        var f_display = function(gpx) {
            try {
                map.setMapType(G_SATELLITE_TYPE);
            } catch (error) {
                map.setMapType(_SATELLITE_TYPE);
            }

            plot_segments(gpx, map, 3, colors, 3);
            plot_waypoints(gpx, map, "<?=$moduleRelPath?>/js/google_maps/waypoint-ext.xsl");
        };

        
        if(speed_mult == 0)
            fetch_gpx(file, function(gpx) { f_setup(gpx, f_display); });
        else
            fetch_gpx(file, function(gpx) { f_setup(gpx, f_animate); });
    }

    //]]>
    </script>
  </head>
  <body onload="initialize(new GPoint(-95, 38))">
	<div id="control" class="style1"></div>
	<div id="map"></div>
    <div id="info">

      <p>Select animation speed:</p>
      <form>
        <select id="speed" name="speed" size="1"
	  onchange="set_speed_mult(this.options[this.selectedIndex].value)">
          <option value="0">no animation</option>
          <option value="1">real-time</option>

          <option value="2">2x</option>
          <option value="5" selected>5x</option>
          <option value="10">10x</option>
          <option value="20">20x</option>
          <option value="50">50x</option>
        </select>

        <div id="zselect">
        <input type="checkbox" name="varcolor" id="varcolor" 
	  onclick="show_elev(this)" />
        <span>Vary line color with elevation?</span>
        </div>
        <select id="zmax" name="zmax" size="1" disabled
	    onchange="maxZ=this.options[this.selectedIndex].value"
            title="Determines color scale for the track">
          <option value="0" selected>Select maximum elevation</option>
          <option value="50">50 meters</option>

          <option value="100">100 meters</option>
          <option value="200">200 meters</option>
          <option value="500">500 meters</option>
          <option value="1000">1000 meters</option>
        </select>
        <div id="zoomtype">
        <input type="checkbox" id="ballzoom" 
         title="Animated zoom, i.e. a ballistic missile view ;-)"/>

        <span>&quot;Ballistic&quot; zoom (try it)</span>
        </div>
      </form>
      <p>Animation/plotting will start  when you select the link. Use the STOP button to cancel the animation:</p>
      <ul>
	<li><a href="javascript:showtracks('/bikecommute.xml', 3)">Bike
        commute 2</a></li>
      </ul>
      <form>
        <input type="button" value="STOP ANIMATION" onclick="if(fcancel) fcancel()" />
      </form>
    </div>
  </body>
</html>
<? } ?>
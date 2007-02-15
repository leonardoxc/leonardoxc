
    if (GBrowserIsCompatible()) {
      // this variable will collect the html which will eventually be placed in the side_bar
      var side_bar_html = "";
    
      // arrays to hold copies of the markers and html used by the side_bar
      // because the function closure trick doesnt work there
      var gmarkers = [];
      var htmls = [];
      var i = 0;


      // A function to create the marker and set up the event window
      function createMarker(point,name,html) {
        var marker = new GMarker(point);
        GEvent.addListener(marker, "click", function() {
          marker.openInfoWindowHtml(html);
        });
        // save the info we need to use later for the side_bar
        gmarkers[i] = marker;
        htmls[i] = html;
        // add a line to the side_bar html
        side_bar_html += '<a href="javascript:myclick(' + i + ')">' + name + '</a><br>';
        i++;
        return marker;
      }


      // This function picks up the click and opens the corresponding info window
      function myclick(i) {
        gmarkers[i].openInfoWindowHtml(htmls[i]);
      }


      // create the map
      var map = new GMap2(document.getElementById("map"),   {mapTypes:[G_HYBRID_MAP,G_SATELLITE_MAP,G_NORMAL_MAP]}); 
		//GMap2.setMapType( G_HYBRID_MAP);
      map.addControl(new GLargeMapControl());
      map.addControl(new GMapTypeControl());
      map.setCenter(new GLatLng( -45.458619,100), 4);

      var side_bar_html = "";
      
	  process_polyline   = function(doc) {
        // === split the document into lines ===
        lines = doc.split("\n");
	    parts = lines[2].split(",");
        var min_lat = parseFloat(parts[0]);
        var max_lat = parseFloat(parts[1]);
        var min_lon = parseFloat(parts[2]);
        var max_lon = parseFloat(parts[3]);

		var center_lat=(max_lat+min_lat)/2;
		var center_lon=(max_lon+min_lon)/2;
		zoom=compute_zoom(max_lat,min_lat,max_lon,min_lon,document.getElementById("map"));
		map.setCenter(new GLatLng( center_lat,center_lon), zoom);

//		map.centerAndZoom(new GPoint(center_lat, center_lon), 8);

		process_waypoints();
		var encodedPolyline = new GPolyline.fromEncoded({
			color: "#FF0000",
			weight: 2,
			points: lines[3],
			levels: lines[4],
			zoomFactor: 10,
			numLevels:4
		});
		map.addOverlay(encodedPolyline);

	   }
      // === Define the function thats going to process the text file ===
      function process_waypoints(){
        for (var i=0; i<2; i++) {
          if (lines[i].length > 1) {
            // === split each line into parts separated by "|" and use the contents ===
            parts = lines[i].split("|");
            var lat = parseFloat(parts[0]);
            var lng = parseFloat(parts[1]);
            var html = parts[2];
            var label = parts[3];
            var point = new GLatLng(lat,lng);
            // create the marker
            var marker = createMarker(point,label,html);
            map.addOverlay(marker);
          }
        }
        // put the assembled side_bar_html contents into the side_bar div
        document.getElementById("side_bar").innerHTML = side_bar_html;
      /*   
          // ===== determine the zoom level from the bounds =====
          map.setZoom(map.getBoundsZoomLevel(bounds));

          // ===== determine the centre from the bounds ======
          var clat = (bounds.getNorthEast().lat() + bounds.getSouthWest().lat()) /2;
          var clng = (bounds.getNorthEast().lng() + bounds.getSouthWest().lng()) /2;
          map.setCenter(new GLatLng(clat,clng));
*/
      }          
          
	 //fname is derevied from args
      GDownloadUrl(fname, process_polyline);
    }

    else {
      alert("Sorry, the Google Maps API is not compatible with this browser");
    }
    // This Javascript is based on code provided by the
    // Blackpool Community Church Javascript Team
    // http://www.commchurch.freeserve.co.uk/   
    // http://www.econym.demon.co.uk/googlemaps/

function compute_zoom(maxX,minX,maxY,minY, mnode) {
    var width = mnode.offsetWidth;
    var height = mnode.offsetHeight;

    var dlat = Math.abs(maxY - minY);
    var dlon = Math.abs(maxX - minX);
    if(dlat == 0 && dlon == 0)
        return 4;
 
    // Center latitude in radians
    var clat = Math.PI*(minY + maxY)/360.;

    var C = 0.0000107288;
    var z0 = Math.ceil(Math.log(dlat/(C*height))/Math.LN2) + 1 ;
    var z1 = Math.ceil(Math.log(dlon/(C*width*Math.cos(clat)))/Math.LN2) + 1;

    return (z1 > z0) ? z1 : z0;
}

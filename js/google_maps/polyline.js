
    if (GBrowserIsCompatible()) {
      // this variable will collect the html which will eventually be placed in the side_bar
      var side_bar_html = "";
    
      // arrays to hold copies of the markers and html used by the side_bar
      // because the function closure trick doesnt work there
      var gmarkers = [];
      var htmls = [];
      var i = 0;

      var background = [];
          background["green"]  = "img/pin_1.png";
          background["red"]  = "img/pin_2.png";

      // A function to create the marker and set up the event window
      function createMarker(point,name,html,ba) {      
//	  	var mylabel = {"url":overlay[ov], "anchor":new GLatLng(4,4), "size":new GSize(12,12)};
//        var Icon = new GIcon(G_DEFAULT_ICON, background[ba], mylabel);
		        var Icon = new GIcon(G_DEFAULT_ICON, background[ba]);
        var marker = new GMarker(point,Icon,{title:name});
//        var marker = new GMarker(point,{title:name});
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
      map.addControl(new GLargeMapControl());
      map.addControl(new GMapTypeControl());
      map.setCenter(new GLatLng(0,0), 4);

      var side_bar_html = "";
      
	  var center_lat;
	  var center_lon;

	  process_polyline   = function(doc) {
        // === split the document into lines ===
        lines = doc.split("\n");
	    parts = lines[2].split(",");
        var min_lat = parseFloat(parts[0]);
        var max_lat = parseFloat(parts[1]);
        var min_lon = parseFloat(parts[2]);
        var max_lon = parseFloat(parts[3]);

		center_lat=(max_lat+min_lat)/2;
		center_lon=(max_lon+min_lon)/2;
			
		var bounds = new GLatLngBounds(new GLatLng(min_lon,min_lat ),new GLatLng(max_lon,max_lat));
		zoom=map.getBoundsZoomLevel(bounds);	
		map.setCenter(new GLatLng( center_lat,center_lon), zoom);

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







	  // Create our "tiny" marker icon
var icon = new GIcon();
icon.image = "http://labs.google.com/ridefinder/images/mm_20_red.png";
icon.shadow = "http://labs.google.com/ridefinder/images/mm_20_shadow.png";
icon.iconSize = new GSize(12, 20);
icon.shadowSize = new GSize(22, 20);
icon.iconAnchor = new GPoint(6, 20);
icon.infoWindowAnchor = new GPoint(5, 1);

	// marker = new PdMarker(new GLatLng(49.28124,-123.12035), {icon:icon, draggable: true});
	marker = new PdMarker(new GLatLng(49.28124,-123.12035), {draggable: true});

	marker.setTooltip("Vancouver");
	var html = "Visit <a href='http://www.yourvancouver.com'>Vancouver<\/a>";
	marker.setDetailWinHTML(html);
	marker.setHoverImage("http://www.google.com/mapfiles/dd-start.png");
	map.addOverlay(marker);










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
			var bg;
			if (i==0) bg="green";
			else bg="red";
            var marker = createMarker(point,label,html,bg);
            map.addOverlay(marker);
          }
        }
        // put the assembled side_bar_html contents into the side_bar div
		var curHtml=document.getElementById("side_bar").innerHTML;
        document.getElementById("side_bar").innerHTML =  curHtml + side_bar_html;
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


function zoomToFlight() {
//	map.setCenter(new GLatLng( center_lat,center_lon), zoom);
	map.setCenter(new GLatLng( 49.28124,-123.12035), zoom);
}
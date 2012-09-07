		

// this variable will collect the html which will eventually be placed in the side_bar
  var side_bar_html = "";

  // arrays to hold copies of the markers and html used by the side_bar
  // because the function closure trick doesnt work there
  var gmarkers = [];
  var htmls = [];
  var markers_num = 0;

     
  var center_lat;
  var center_lon;
  var bounds ;
  
  var polyline_color='';

  
  // A function to create the marker and set up the event window
  function createMarker(point,name,html,iconName,normalMarker) {    
	  return;
	  
	var iconUrl='';
	if (normalMarker){ 
		if (iconName=='start') {
			iconUrl= "http://maps.google.com/mapfiles/kml/pal4/icon61.png";
		} else {
			iconUrl= "http://maps.google.com/mapfiles/kml/pal4/icon53.png";
		}			
	} else {
		iconUrl=markerBg;
	}
	
	var marker = new google.maps.Marker({
		position: point,       
		map: map,
		icon: iconUrl,
		title:name
	});

	// save the info we need to use later for the side_bar
	if (normalMarker) {
		gmarkers[markers_num] = marker;
		htmls[markers_num] = html;

		google.maps.event.addListener(marker, 'click', function() {
		        infowindow.setContent(htmls[i]); 
		        infowindow.open(map,marker);
		});
		  
		//google.maps.Event.addListener(marker, "click", function() {
		//	marker.openInfoWindowHtml(htmls[i]);
		//});
		// add a line to the side_bar html
		side_bar_html += '<a href="javascript:myclick(' + markers_num + ')">' + name + '</a><br>';
		markers_num++;
	} else {
		posMarker=marker;
	}
	
	return marker;
  }


  function myclick(i) {
	  google.maps.event.trigger(gmarkers[i], "click");
	}
  

  // This function picks up the click and opens the corresponding info window
  function myclickxx(i) {
	  gmarkers[i].click();
	  
	// gmarkers[i].openInfoWindowHtml(htmls[i]);
  }

  function process_polyline(doc) {
	lines = doc.split("\n");
	parts = lines[2].split(",");
	var min_lat = parseFloat(parts[0]);
	var max_lat = parseFloat(parts[1]);
	var min_lon = parseFloat(parts[2]);
	var max_lon = parseFloat(parts[3]);

	center_lat=(max_lat+min_lat)/2;
	center_lon=(max_lon+min_lon)/2;
		
	bounds = new google.maps.LatLngBounds(new google.maps.LatLng(max_lat,min_lon ),new google.maps.LatLng(min_lat,max_lon));
	
	map.fitBounds(bounds);

	var color="#FF0000";
	if (polyline_color!='' ) {
		color=polyline_color;
	}
	
	 process_waypoints();
	
	
	if (0) {
		var decodedPoints=google.maps.geometry.encoding.decodePath(lines[3]);
		var trackPath = new google.maps.Polyline({
			  path: decodedPoints,
	          strokeColor: color,
	          strokeOpacity: 1.0,
	          strokeWeight: 2,
	          map:map
		});
  	}

   }
  
   
  function process_waypoints(){
	for (var j=0; j<2; j++) {
	  if (lines[j].length > 1) {
		// === split each line into parts separated by "|" and use the contents ===
		parts = lines[j].split("|");
		var lat = parseFloat(parts[0]);
		var lng = parseFloat(parts[1]);
		var html = parts[2];
		var label = parts[3];
		var point = new google.maps.LatLng(lat,lng);
		
		label=label.replace("Takeoff",takeoffString);
		label=label.replace("Landing",landingString);

		html=html.replace("Takeoff",takeoffString);
		html=html.replace("Landing",landingString);

		// create the marker
		var iconName;
		if (j==0) iconName="start";
		else iconName="stop";
		var marker = createMarker(point,label,html,iconName,1);
		// map.addOverlay(marker);
		
		if (j==0) { //create  also the running icon
			 var marker = createMarker(point,label,html,markerBg,0);
		}
	  }
	}
	// put the assembled side_bar_html contents into the side_bar div
	// var curHtml=document.getElementById("side_bar").innerHTML;
	// document.getElementById("side_bar").innerHTML =  curHtml + side_bar_html;
  }                   
  
var min_lat;
var max_lat;
var min_lon;
var max_lon;

  
function computeMinMaxLatLon(){
	var bounds = map.getBounds();		
	var southWest = bounds.getSouthWest();
	var northEast = bounds.getNorthEast();	
	if (northEast.lat() >  southWest.lat() ){
		min_lat=southWest.lat();
		max_lat=northEast.lat();
	} else {
		min_lat=northEast.lat();
		max_lat=southWest.lat();
	}
	if (northEast.lng() >  southWest.lng() ){
		min_lon=southWest.lng();
		max_lon=northEast.lng();
	} else {
		min_lon=northEast.lng();
		max_lon=southWest.lng();
	}	
	
}



// Creates a marker whose info window displays the given description 
function createWaypoint(point, id , description, iconUrl, shadowUrl ) {
	if (iconUrl){
		var marker = new google.maps.Marker({
			position: point,       
			map: map,
			icon: iconUrl,
			title:name
		});

	} else {
		var marker = new google.maps.Marker(point);	

		var marker = new google.maps.Marker({
			position: point,       
			map: map
		});
			
	}	

	google.maps.event.addListener(marker, 'click', function() {
		currMarker=marker;
		getAjax('EXT_takeoff.php?op=get_info&wpID='+id,null,openMarkerInfoWindow);	
	});
  
  	return marker;
}


function openMarkerInfoWindow(jsonString) {
	var results= eval("(" + jsonString + ")");			
	var i=results.takeoffID;
	var html=results.html;

    infowindow.setContent(html); 
    infowindow.open(map,currMarker);
    
	// takeoffMarkers[i].openInfoWindowHtml(html);
}

var currMarker;
var takeoffMarkers=[];
	
function drawTakeoffs(jsonString){
 	var results= eval("(" + jsonString + ")");		
	// document.writeln(results.waypoints.length);
	for(i=0;i<results.waypoints.length;i++) {	
		var takeoffPoint= new google.maps.LatLng(results.waypoints[i].lat, results.waypoints[i].lon) ;
		
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
		
		var takeoffMarker= createWaypoint(takeoffPoint,results.waypoints[i].id, results.waypoints[i].name,iconUrl,shadowUrl);
		takeoffMarkers[takeoffPoint,results.waypoints[i].id] = takeoffMarker;
		// map.addOverlay(takeoffMarker);
	}	
}
		

// this variable will collect the html which will eventually be placed in the side_bar
  var side_bar_html = "";

  // arrays to hold copies of the markers and html used by the side_bar
  // because the function closure trick doesnt work there
  var gmarkers = [];
  var htmls = [];
  var markers_num = 0;
   
  var bounds=null ;
  var center_lat;
  var center_lon;
  var min_lat;
  var max_lat;
  var min_lon;
  var max_lon;
  
  var currMarker;
  var takeoffMarkers=[];
  
  
  // A function to create the marker and set up the event window
function createMarker(point,name,html,iconName) {    
	var iconUrl='';
	if (iconName=='start') {
		iconUrl= "http://maps.google.com/mapfiles/kml/pal4/icon61.png";
	} else {
		iconUrl= "http://maps.google.com/mapfiles/kml/pal4/icon53.png";
	}			
	var marker = new google.maps.Marker({
		position: point,       
		map: map,
		icon: iconUrl,
		title:name
	});

	gmarkers[markers_num] = marker;
	htmls[markers_num] = html;

	google.maps.event.addListener(marker, 'click', function() {
	        infowindow.setContent(html); 
	        infowindow.open(map,marker);
	});
	  
	// add a line to the side_bar html
	side_bar_html = '<a href="javascript:myclick(' + markers_num + ')">' + name + '</a>';
	markers_num++;
	
	return marker;
}


function myclick(i) {
	  google.maps.event.trigger(gmarkers[i], "click");
}
  

  
function computeMinMaxLatLon(){
	var bounds0 = map.getBounds();
	if (bounds0==null) {
		if (bounds==null) return ;
			
		bounds0=bounds;
	}
	
	var southWest = bounds0.getSouthWest();
	var northEast = bounds0.getNorthEast();	
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
		$.get('EXT_takeoff.php?op=get_info&wpID='+id, function(data) {
			openMarkerInfoWindow(data);
		});
		
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

	
function drawTakeoffs(jsonString){
 	var results= eval("(" + jsonString + ")");		
	// document.writeln(results.waypoints.length);
	for(i=0;i<results.waypoints.length;i++) {	
		var takeoffPoint= new google.maps.LatLng(results.waypoints[i].lat, results.waypoints[i].lon) ;
		
		if (results.waypoints[i].id ==takeoffID ) {
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
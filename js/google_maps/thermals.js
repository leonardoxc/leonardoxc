

//-------------------------------------------------------------------

var icon = new GIcon();
icon.image = "img/thermals/class_1.png";
icon.shadow = "img/thermals/class_shadow.png";
icon.iconSize = new GSize(12, 20);
icon.shadowSize = new GSize(22, 20);
icon.iconAnchor = new GPoint(6, 20);
icon.infoWindowAnchor = new GPoint(5, 1);           
  
var classIcons=[];
var thermalNum=new Array ();	
var thermalMarkers=new Array ();
var cluster=[];
var init_thermals=false;

  function createThermalMarker(point,html,thermalClass) {
	var marker = new GMarker(point, {icon:classIcons[thermalClass]});
	GEvent.addListener(marker, "click", function() {
	  marker.openInfoWindowHtml(html);
	});		
	return marker;
  }
	  
  function showThermalClass(thermalClass) {
	cluster[thermalClass].addMarkers( thermalMarkers[thermalClass] );
	cluster[thermalClass].refresh(true);
	document.getElementById(thermalClass+"_box").checked = true;
  }

  function hideThermalClass(thermalClass) {		
	cluster[thermalClass].removeMarkers();
	cluster[thermalClass].refresh(true);
	document.getElementById(thermalClass+"_box").checked = false;
	// == close the info window, in case its open on a marker that we just hid
	map.closeInfoWindow();
  }
   
   function boxclick(box,thermalClass){
		if (box.checked) {
			showThermalClass(thermalClass);
		} else {
			hideThermalClass(thermalClass);
		}       
	}	
	
function importThermals(jsonString){
	// var results= eval("(" + jsonString + ")");	
	var results= eval(jsonString);	
	
	for(var i=0;i<results.waypoints.length;i++) {	
		var thermalPoint= new GLatLng(results.waypoints[i].lat, results.waypoints[i].lon) ;
		var icon2=icon;
		
		var thermalClass=results.waypoints[i].c;
		var climbmeters=results.waypoints[i].m;
		var climbseconds=results.waypoints[i].d;
		var climbrate=climbmeters/climbseconds;
		climbrate=climbrate.toFixed(1);
					
		if (thermalClass=='A') thermalClass=1;
		else if (thermalClass=='B') thermalClass=2;
		else if (thermalClass=='C') thermalClass=3;
		else if (thermalClass=='D') thermalClass=4;
		else thermalClass=5;				
		
		var html="Class: " + results.waypoints[i].c+"<BR>"+
		"Climbrate: " +climbrate +" m/sec<BR>"+
		"Height Gain: " + climbmeters+" m<BR>"+
		"Duration: " + climbseconds+" secs";
		
		var thermalMarker = createThermalMarker(thermalPoint,html,thermalClass);
		thermalMarkers[thermalClass][ thermalNum[thermalClass]++ ] = thermalMarker ;
		
	}	

	//showThermalClass("1");
	//hideThermalClass("2");
	//hideThermalClass("3");
	//hideThermalClass("4");
	//hideThermalClass("5");
	
	
	showThermalClass("1");
	
	$("#thermalLoading").hide();
	$("#thermalLoad").hide();		
	$("#thermalControls").show();
}

function initThermals() {
	if (init_thermals) return;
	for(var i=1;i<=5;i++) { 
		thermalMarkers[i]=new Array();
		thermalNum[i]=0;
		cluster[i]=new ClusterMarker(map, { clusterClass: i,  minClusterSize:4 , clusterMarkerTitle:" Click to zoom to %count thermals" } );
		cluster[i].intersectPadding=10;
		
		classIcons[i]=new GIcon(icon,"img/thermals/class_"+i+".png"); 
	}	
	init_thermals=true;	
}

function loadThermals(msg) {
	initThermals();
	
	computeMinMaxLatLon();
	$("#thermalLoading").html(msg+"<img src='img/ajax-loader.gif'>").show();
	$.ajax({ url: 'EXT_thermals.php?op=get_nearest&max_lat='+max_lat+'&max_lon='+max_lon+'&min_lat='+min_lat+'&min_lon='+min_lon, 
		dataType: 'json', 		  
		success: function(jsonString) {	importThermals(jsonString);	}		  
	});		
}
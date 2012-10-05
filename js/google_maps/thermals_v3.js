

var classIcons=[];
var thermalNum=new Array ();	
var thermalMarkers=new Array ();
var cluster=[];
var init_thermals=false;

function createThermalMarker(point,html,thermalClass) {
	var marker = new google.maps.Marker( {
		position: point,
		icon: classIcons[thermalClass]
	});
	
	google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(html); 
        infowindow.open(map,marker);
	});
		
	return marker;
  }
	  
  function showThermalClass(thermalClass) {
	cluster[thermalClass].addMarkers( thermalMarkers[thermalClass] );
	//cluster[thermalClass].refresh(true);
	document.getElementById(thermalClass+"_box").checked = true;
  }

  function hideThermalClass(thermalClass) {		
	cluster[thermalClass].clearMarkers();
	// cluster[thermalClass].refresh(true);
	document.getElementById(thermalClass+"_box").checked = false;
	// == close the info window, in case its open on a marker that we just hid
	infowindow.close();
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
		var thermalPoint= new google.maps.LatLng(results.waypoints[i].lat, results.waypoints[i].lon) ;
		
		// var icon2=icon;
		
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
	
	$("#thermalClose").show();
	
}

var styles=[];

styles[1]=               
  [{
    url: 'img/thermals/cluster_1_3.png',  height: 30, width: 30,    
    textColor: '#151515', textSize: 10
  }, {
    url: 'img/thermals/cluster_1_2.png', height: 50, width: 50,
    textColor: '#151515', textSize: 11
  }, {
    url: 'img/thermals/cluster_1.png', height: 90,   width: 90,    
    textColor: '#151515', textSize: 12
  }];

styles[2]=               
	  [{
	    url: 'img/thermals/cluster_2_3.png',  height: 30, width: 30,    
	    textColor: '#151515', textSize: 10
	  }, {
	    url: 'img/thermals/cluster_2_2.png', height: 50, width: 50,
	    textColor: '#151515', textSize: 11
	  }, {
	    url: 'img/thermals/cluster_2.png', height: 90,   width: 90,    
	    textColor: '#151515', textSize: 12
	  }];
styles[3]=               
	  [{
	    url: 'img/thermals/cluster_3_3.png',  height: 30, width: 30,    
	    textColor: '#151515', textSize: 10
	  }, {
	    url: 'img/thermals/cluster_3_2.png', height: 50, width: 50,
	    textColor: '#151515', textSize: 11
	  }, {
	    url: 'img/thermals/cluster_3.png', height: 90,   width: 90,    
	    textColor: '#151515', textSize: 12
	  }];

styles[4]=               
	  [{
	    url: 'img/thermals/cluster_4_3.png',  height: 30, width: 30,    
	    textColor: '#151515', textSize: 10
	  }, {
	    url: 'img/thermals/cluster_4_2.png', height: 50, width: 50,
	    textColor: '#151515', textSize: 11
	  }, {
	    url: 'img/thermals/cluster_4.png', height: 90,   width: 90,    
	    textColor: '#151515', textSize: 12
	  }];

styles[5]=               
	  [{
	    url: 'img/thermals/cluster_5_3.png',  height: 30, width: 30,    
	    textColor: '#151515', textSize: 10
	  }, {
	    url: 'img/thermals/cluster_5_2.png', height: 50, width: 50,
	    textColor: '#151515', textSize: 11
	  }, {
	    url: 'img/thermals/cluster_6.png', height: 90,   width: 90,    
	    textColor: '#151515', textSize: 12
	  }];

function initThermals() {
	if (init_thermals) return;
	
	var mcOptions = {
			gridSize: 50, 
			maxZoom: 15,
			title:" Click to zoom to thermals" ,
			gridSize: 40,
			minimumClusterSize:4 
	};
	
	for(var i=1;i<=5;i++) { 
		thermalMarkers[i]=new Array();
		thermalNum[i]=0;
		
		var mcOptions0= mcOptions;
		mcOptions0['styles']=styles[i];
		
		cluster[i] = new MarkerClusterer(map, [], mcOptions0);
		/*
		cluster[i]=new ClusterMarker(map, 
		{ 
			clusterClass: i, 
			minClusterSize:4 , 
			clusterMarkerTitle:" Click to zoom to %count thermals" } );
		cluster[i].intersectPadding=10;
		*/
		
		classIcons[i]="img/thermals/class_"+i+".png";
		
	}	
	init_thermals=true;	
}

function hideThermalsLayer() {
	for(var i=1;i<=5;i++) {
		hideThermalClass(i);
	}
	$("#thermalControls").hide();	
}

function showThermalsLayer() {
	$("#thermalControls").show();
	for(var i=1;i<=5;i++) {		
		if ( $("#"+i+"_box").attr('checked') ) {
			showThermalClass(i);
		}
	}
		
}

function toggleThermals() {
	
	if ( $("#thermalControls").is(':visible') ) {
		hideThermalsLayer();
		$("#thermalClose").hide();	
		$("#thermalOpen").show();	
	} else {
		showThermalsLayer();
		$("#thermalClose").show();	
		$("#thermalOpen").hide();	
	}
	
	
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
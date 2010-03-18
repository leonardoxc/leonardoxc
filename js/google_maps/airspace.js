

var airspace_polys=[];
var airspace_labels=[];


function loadAirspace(min_lat,max_lat,min_lon,max_lon) {		
	$.ajax({ url: 'EXT_airspace.php?op=get_airspace&max_lat='+max_lat+'&max_lon='+max_lon+'&min_lat='+min_lat+'&min_lon='+min_lon, 
		dataType: 'json', 		  
		success: function(jsonString) {	drawAirspaces(jsonString);	}		  
	 });		
}

function drawAirspaces(jsonString) {
	var airspacesList= eval(jsonString);
	for (var i=0; i<airspacesList.airspaces.length; i++) {
		drawAirspace(airspacesList.airspaces[i]);
    }
}

function drawAirspace(rec) {
	var pts=[];
	for(var j=0;j<rec.points.length;j+=2) {
		pts[j] = new GLatLng(rec.points[j],rec.points[j+1]);
	}	
	var poly = new GPolygon(pts,'#000000',1,1,rec.color,0.25); 
	airspace_polys.push(poly); 
	airspace_labels.push(rec.name+' ['+rec.type+'] ('+rec.base+'m-'+rec.top+'m)');
	map.addOverlay(poly);
	GEvent.addListener(poly,'click', function(point) { checkPoint(point); }  ); 
		
}


function clearAirspaces() {
	for (var i=0; i<airspace_polys.length; i++) {
		map.removeOverlay(airspace_polys[i]);
	}
	airspace_polys=[];
	airspace_labels=[];	
}

function toggleAirspace(radioObj) {
	if(!radioObj) return "";	
	if(!map) return "";	
	
	computeMinMaxLatLon();
	
	clearAirspaces();		
	loadAirspace(min_lat,max_lat,min_lon,max_lon);
	
	return;	
		
	if(radioObj.checked) {
		showAirspace=1;
        for (var i=0; i<polys.length; i++) {
			map.addOverlay(polys[i]);
        }
	} else {
		showAirspace=0;
        for (var i=0; i<polys.length; i++) {
			map.removeOverlay(polys[i]);
        }
	}
	refreshMap();
}
	

  // === A method for testing if a point is inside a polygon
  // === Returns true if poly contains point
  // === Algorithm shamelessly stolen from http://alienryderflex.com/polygon/ 
  GPolygon.prototype.Contains = function(point) {
	var j=0;
	var oddNodes = false;
	var x = point.lng();
	var y = point.lat();
	for (var i=0; i < this.getVertexCount(); i++) {
	  j++;
	  if (j == this.getVertexCount()) {j = 0;}
	  if (((this.getVertex(i).lat() < y) && (this.getVertex(j).lat() >= y))
	  || ((this.getVertex(j).lat() < y) && (this.getVertex(i).lat() >= y))) {
		if ( this.getVertex(i).lng() + (y - this.getVertex(i).lat())
		/  (this.getVertex(j).lat()-this.getVertex(i).lat())
		*  (this.getVertex(j).lng() - this.getVertex(i).lng())<x ) {
		  oddNodes = !oddNodes
		}
	  }
	}
	return oddNodes;
  }

function checkPoint(point) {
	if (point) {		
	  var infoStr='';
	  for (var i=0; i<airspace_polys.length; i++) {
		if (airspace_polys[i].Contains(point)) {
			infoStr=infoStr+airspace_labels[i]+"<BR>";
		}
	  }
	  if (infoStr!='') {
		map.openInfoWindowHtml(point,infoStr);
	  }
	}
}
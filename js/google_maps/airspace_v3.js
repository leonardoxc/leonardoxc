

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
		if (is3D) {			
			drawAirspace3D(airspacesList.airspaces[i]);
		} else {
			drawAirspace(airspacesList.airspaces[i]);
		}
    }
}

function drawAirspace3D(rec) {
	var top=+rec.top;
	var base=+rec.base;
		
	var pts=[];
	
	var trackLayer = ge.createPlacemark('');
	var lineString = ge.createPolygon('');
	var outer = ge.createLinearRing('');	
	var coords = outer.getCoordinates();
	var i=0;
	
	
	
	for(var j=0;j<rec.points.length;j+=2) {
		//var point = ge.createPoint('');
		//point.set(rec.points[j],rec.points[j+1],0,ge.ALTITUDE_CLAMP_TO_GROUND,false,false);				
		//pts[i]=point;
		coords.pushLatLngAlt(rec.points[j],rec.points[j+1],+top);
		i++;
	}	
	
	
	lineString.setExtrude(true);
	lineString.setAltitudeMode(ge.ALTITUDE_ABSOLUTE); // ALTITUDE_CLAMP_TO_GROUND
	trackLayer.setStyleSelector(ge.createStyle(''));
	var lineStyle = trackLayer.getStyleSelector().getLineStyle();
	lineStyle.setWidth(1);
	lineStyle.getColor().set('ff'+rgb2bgr(rec.color));  // aabbggrr format
	
	var polyStyle=	trackLayer.getStyleSelector().getPolyStyle();	
	polyStyle.getColor().set('2f'+rgb2bgr(rec.color));  // aabbggrr format

	lineString.setOuterBoundary(outer);    
	trackLayer.setGeometry(lineString);

	airspace_polys.push(trackLayer);
	ge.getFeatures().appendChild(trackLayer);
	airspace_labels.push(rec.name+' ['+rec.type+'] ('+rec.base+'m-'+rec.top+'m)');

	
	if (base>0) {
		var pts=[];
		
		var trackLayer = ge.createPlacemark('');
		var lineString = ge.createPolygon('');
		var outer = ge.createLinearRing('');	
		var coords = outer.getCoordinates();
		for(var j=0;j<rec.points.length;j+=2) {
			//var point = ge.createPoint('');
			//point.set(rec.points[j],rec.points[j+1],0,ge.ALTITUDE_CLAMP_TO_GROUND,false,false);				
			//pts[i]=point;
			coords.pushLatLngAlt(rec.points[j],rec.points[j+1],+base);
			i++;
		}	
				
		lineString.setExtrude(true);
		lineString.setAltitudeMode(ge.ALTITUDE_ABSOLUTE); // ALTITUDE_CLAMP_TO_GROUND
		trackLayer.setStyleSelector(ge.createStyle(''));
		var lineStyle = trackLayer.getStyleSelector().getLineStyle();
		lineStyle.setWidth(1);
		lineStyle.getColor().set('ffffffff');  // aabbggrr format
		
		var polyStyle=	trackLayer.getStyleSelector().getPolyStyle();	
		polyStyle.getColor().set('9fffffff');  // aabbggrr format

		lineString.setOuterBoundary(outer);    
		trackLayer.setGeometry(lineString);

		airspace_polys.push(trackLayer);	
		ge.getFeatures().appendChild(trackLayer);
	} 

	
	// google.maps.event.addListener(poly,'click', function(point) { checkPoint(point.latLng); }  ); 
		
}

function drawAirspace(rec) {
	var pts=[];
	
	var i=0;
	for(var j=0;j<rec.points.length;j+=2) {
		pts[i] = new google.maps.LatLng(rec.points[j],rec.points[j+1]);
		i++;
	}	
	
	var poly = new google.maps.Polygon({
		paths:pts,
		strokeColor:'#000000',
		strokeOpacity:1,
		strokeWeight:1,
		fillColor:  rec.color,
		fillOpacity:0.05,
		map:map
	}); 
	airspace_polys.push(poly); 
	airspace_labels.push(rec.name+' ['+rec.type+'] ('+rec.base+'m-'+rec.top+'m)');
	// poly.setMap(map);
	
	google.maps.event.addListener(poly,'click', function(point) { checkPoint(point.latLng); }  ); 
		
}


function clearAirspaces() {
	for (var i=0; i<airspace_polys.length; i++) {
		if (is3D) {
			ge.getFeatures().removeChild(airspace_polys[i]);
		} else {
			airspace_polys[i].setMap(null);
		}
	}
	airspace_polys=[];
	airspace_labels=[];	
}

function toggleAirspace(computeBounds) {
	
	if(!map && !ge) return ;	
	
	if( $("#airspaceShow").is(":checked") ) {
		showAirspace=1;
		if (computeBounds) {
			if (is3D) {
				var globeBounds = ge.getView().getViewportGlobeBounds();
				computeMinMaxLatLonGE2(globeBounds);
			} else {
				computeMinMaxLatLon();
			}
		}
		clearAirspaces();		
		loadAirspace(min_lat,max_lat,min_lon,max_lon);
	} else {
		showAirspace=0;
		clearAirspaces();
	}
	// refreshMap();
}
	

google.maps.Polygon.prototype.Contains = function(latLng) {
    var lat = latLng.lat();
    var lng = latLng.lng();
    var paths = this.getPaths();
    var path, pathLength, inPath, i, j, vertex1, vertex2;

    // Walk all the paths
    for (var p = 0; p < paths.getLength(); p++) {
        path = paths.getAt(p);
        pathLength = path.getLength();
        j = pathLength - 1;
        inPath = false;

        for (i = 0; i < pathLength; i++) {
            vertex1 = path.getAt(i);
            vertex2 = path.getAt(j);

            if (vertex1.lng() < lng && vertex2.lng() >= lng || vertex2.lng() < lng && vertex1.lng() >= lng) {
                if (vertex1.lat() + (lng - vertex1.lng()) / (vertex2.lng() - vertex1.lng()) * (vertex2.lat() - vertex1.lat()) < lat) {
                    inPath = !inPath;
                }
            }

            j = i;
        }
        if (inPath) {
            return true;
        }
    }
    return false;
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
		infowindow.setContent(infoStr); 
		infowindow.setPosition(point);
		infowindow.open(map);
		//map.openInfoWindowHtml(point,infoStr);
	  }
	}
}
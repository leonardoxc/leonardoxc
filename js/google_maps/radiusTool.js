 var metric = true;
  var singleClick = false;
  var queryCenterOptions = new Object();
  var queryLineOptions = new Object();

queryCenterOptions.icon = new GIcon();
queryCenterOptions.icon.image = "http://jfno.net/images/centerArrow.png";
queryCenterOptions.icon.iconSize = new GSize(20,20);
queryCenterOptions.icon.shadowSize = new GSize(0, 0);
queryCenterOptions.icon.iconAnchor = new GPoint(10, 10);
queryCenterOptions.draggable = true;
queryCenterOptions.bouncy = false;

queryLineOptions.icon = new GIcon();
queryLineOptions.icon.image = "http://jfno.net/images/resizeArrow.png";
queryLineOptions.icon.iconSize = new GSize(25,20);
queryLineOptions.icon.shadowSize = new GSize(0, 0);
queryLineOptions.icon.iconAnchor = new GPoint(12, 10);
queryLineOptions.draggable = true;
queryLineOptions.bouncy = false;

function createCircle(point, radius) {
  singleClick = false;
  geoQuery = new GeoQuery();
  geoQuery.initializeCircle(radius, point, map);
  myQueryControl.addGeoQuery(geoQuery);
  geoQuery.render();
}

function destination(orig, hdng, dist) {
  var R = 6371; // earth's mean radius in km
  var oX, oY;
  var x, y;
  var d = dist/R;  // d = angular distance covered on earth's surface
  hdng = hdng * Math.PI / 180; // degrees to radians
  oX = orig.x * Math.PI / 180;
  oY = orig.y * Math.PI / 180;

  y = Math.asin( Math.sin(oY)*Math.cos(d) + Math.cos(oY)*Math.sin(d)*Math.cos(hdng) );
  x = oX + Math.atan2(Math.sin(hdng)*Math.sin(d)*Math.cos(oY), Math.cos(d)-Math.sin(oY)*Math.sin(y));

  y = y * 180 / Math.PI;
  x = x * 180 / Math.PI;
  return new GLatLng(y, x);
}

function distance(point1, point2) {
  var R = 6371; // earth's mean radius in km
  var lon1 = point1.lng()* Math.PI / 180;
  var lat1 = point1.lat() * Math.PI / 180;
  var lon2 = point2.lng() * Math.PI / 180;
  var lat2 = point2.lat() * Math.PI / 180;

  var deltaLat = lat1 - lat2
  var deltaLon = lon1 - lon2

  var step1 = Math.pow(Math.sin(deltaLat/2), 2) + Math.cos(lat2) * Math.cos(lat1) * Math.pow(Math.sin(deltaLon/2), 2);
  var step2 = 2 * Math.atan2(Math.sqrt(step1), Math.sqrt(1 - step1));
  return step2 * R;
}

function GeoQuery() {

}

GeoQuery.prototype.CIRCLE='circle';
GeoQuery.prototype.COLORS=["#0000ff", "#00ff00", "#ff0000"];
var COLORI=0;

GeoQuery.prototype = new GeoQuery();
GeoQuery.prototype._map;
GeoQuery.prototype._type;
GeoQuery.prototype._radius;
GeoQuery.prototype._dragHandle;
GeoQuery.prototype._centerHandle;
GeoQuery.prototype._polyline;
GeoQuery.prototype._color ;
GeoQuery.prototype._control;
GeoQuery.prototype._points;
GeoQuery.prototype._dragHandlePosition;
GeoQuery.prototype._centerHandlePosition;


GeoQuery.prototype.initializeCircle = function(radius, point, map) {
    this._type = this.CIRCLE;
    this._radius = radius;
    this._map = map;
    this._dragHandlePosition = destination(point, 90, this._radius/1000);
    this._dragHandle = new GMarker(this._dragHandlePosition, queryLineOptions);
    this._centerHandlePosition = point;
    this._centerHandle = new GMarker(this._centerHandlePosition, queryCenterOptions);
    this._color = this.COLORS[COLORI++ % 3];
    map.addOverlay(this._dragHandle);
    map.addOverlay(this._centerHandle);
    var myObject = this;
    GEvent.addListener (this._dragHandle, "dragend", function() {myObject.updateCircle(1);});
    GEvent.addListener (this._dragHandle, "drag", function() {myObject.updateCircle(1);});
    GEvent.addListener(this._centerHandle, "dragend", function() {myObject.updateCircle(2);});
    GEvent.addListener(this._centerHandle, "drag", function() {myObject.updateCircle(2);});
}

GeoQuery.prototype.updateCircle = function (type) {
    this._map.removeOverlay(this._polyline);
    if (type==1) {
      this._dragHandlePosition = this._dragHandle.getPoint();
      this._radius = distance(this._centerHandlePosition, this._dragHandlePosition) * 1000;
      this.render();
    } else {
      this._centerHandlePosition = this._centerHandle.getPoint();
      this.render();
      this._dragHandle.setPoint(this.getEast());
    }
}

GeoQuery.prototype.render = function() {
  if (this._type == this.CIRCLE) {
    this._points = [];
    var distance = this._radius/1000;
    for (i = 0; i < 72; i++) {
      this._points.push(destination(this._centerHandlePosition, i * 360/72, distance) );
    }
    this._points.push(destination(this._centerHandlePosition, 0, distance) );
    //this._polyline = new GPolyline(this._points, this._color, 6);
    this._polyline = new GPolygon(this._points, this._color, 1, 1, this._color, 0.2);
    this._map.addOverlay(this._polyline)
    this._control.render();
  }
}

GeoQuery.prototype.remove = function() {
  this._map.removeOverlay(this._polyline);
  this._map.removeOverlay(this._dragHandle);
  this._map.removeOverlay(this._centerHandle);
}

GeoQuery.prototype.getRadius = function() {
    return this._radius;
}

GeoQuery.prototype.getHTML = function() {
  return "<span><font color='"+ this._color + "''>" + this.getDistHtml() + "</font></span>";
}

GeoQuery.prototype.getDistHtml = function() {
  result = "<img src='http://jfno.net/images/close.gif' onClick='myQueryControl.remove(" + this._control.getIndex(this) + ");'/>Radius ";
   result = "Radius ";
   
  if (metric) {
    if (this._radius < 1000) {
      result += "in meters : " + this._radius.toFixed(1);
    } else {
      result += "in kilometers : " + (this._radius / 1000).toFixed(1);
    }
  } else {
    var radius = this._radius * 3.2808399;
    if (radius < 5280) {
      result += "in feet : " + radius.toFixed(1);
    } else {
      result += "in miles : " + (radius / 5280).toFixed(1);
    }
  }
  return result;   
}

GeoQuery.prototype.getNorth = function() {
  return this._points[0];
}

GeoQuery.prototype.getSouth = function() {
  return this._points[(72/2)];
}

GeoQuery.prototype.getEast = function() {
  return this._points[(72/4)];
}

GeoQuery.prototype.getWest = function() {
  return this._points[(72/4*3)];
}

function QueryControl () {
 //  this._localSearch = localSearch;
}

QueryControl.prototype = new GControl();
QueryControl.prototype._geoQueries ;
QueryControl.prototype._mainDiv;
QueryControl.prototype._queriesDiv;
QueryControl.prototype._minStar;
QueryControl.prototype._minPrice;
QueryControl.prototype._maxPrice;
QueryControl.prototype._timeout;
//QueryControl.prototype._localSearch;

QueryControl.prototype.initialize = function(map) {
  this._mainDiv = document.createElement("div");
  this._mainDiv.id = "GQueryControl";
  titleDiv = document.createElement("div");
  titleDiv.id = "GQueryControlTitle";
  titleDiv.appendChild(document.createTextNode("Filter"));
  this._mainDiv.appendChild(titleDiv);
  this._queriesDiv = document.createElement("div");
  this._queriesDiv.id = "queriesDiv";
  this._mainDiv.appendChild(this._queriesDiv);

  map.getContainer().appendChild(this._mainDiv);
  this._geoQueries = new Array();
  return this._mainDiv;
}

QueryControl.prototype.getDefaultPosition = function() {
  return new GControlPosition(G_ANCHOR_TOP_LEFT, new GSize(50, 10));
}

QueryControl.prototype.addGeoQuery = function(geoQuery) {
  this._geoQueries.push(geoQuery);
  geoQuery._control = this;
  newDiv = document.createElement("div");
  newDiv.innerHTML = geoQuery.getHTML();
  this._queriesDiv.appendChild(newDiv);
 
}

QueryControl.prototype.render = function() {
  for (i = 0; i < this._geoQueries.length; i++) {
    geoQuery = this._geoQueries[i];
    this._queriesDiv.childNodes[i].innerHTML = geoQuery.getHTML();
  }
  if (this._timeout == null) {
    this._timeout = setTimeout(myQueryControl.query, 1000);
  } else {
    clearTimeout(this._timeout);
    this._timeout = setTimeout(myQueryControl.query, 1000);
  }
}

QueryControl.prototype.query = function() {
	lat=geoQuery._centerHandlePosition.lat();
	lon=geoQuery._centerHandlePosition.lng();
	if (geoQuery._radius!= null)
		radiusKm=Math.floor(geoQuery._radius/1000);
	
	$.getJSON('EXT_takeoff.php?op=get_nearest&lat='+lat+'&lon='+lon+'&distance='+radiusKm,null,drawTakeoffs);
	$.getJSON('EXT_flight.php?op=list_flights_json&lat='+lat+'&lon='+lon+'&distance='+radiusKm+'&from_tm=10',null,drawFlights);
	
}
/*
QueryControl.prototype.query = function() {
  listMarkers = myQueryControl._localSearch.markers.slice();
  for (i = 0; i < listMarkers.length; i++) {
    marker = listMarkers[i].marker;
    result = listMarkers[i].resultsListItem;
    listImage = marker.getIcon().image;
    inCircle = true;
    for (j = 0; j < myQueryControl._geoQueries.length; j++) {
      geoQuery = myQueryControl._geoQueries[j];
      dist = distance(marker.getLatLng(), geoQuery._centerHandlePosition); 
      if (dist > geoQuery._radius / 1000) {
        inCircle = false;
        break;
      }
    }
    if (inCircle) {
      marker.setImage(listImage);
      result.childNodes[1].style.color = '#0000cc';
    } else {
      var re = new RegExp(".*(marker.\.png)");
      marker.setImage(listImage.replace(re, "img/$1"));
      result.childNodes[1].style.color = '#b0b0cc';
    }
  }
}
*/

QueryControl.prototype.remove = function(index) {
  this._geoQueries[index].remove();
  this._queriesDiv.removeChild(this._queriesDiv.childNodes[index]);
  delete this._geoQueries[index];
  this._geoQueries.splice(index,1);
  this.render();
}

QueryControl.prototype.getIndex = function(geoQuery) {
  for (i = 0; i < this._geoQueries.length; i++) {
    if (geoQuery == this._geoQueries[i]) {
      return i;
    }
  }
  return -1;
}

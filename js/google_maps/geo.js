// arch-tag: ab5a84d1-fbb4-4bfc-86be-17ff1ea938f4
//
// Functions for geodetic calculations
//
// Copyright (c) 2005 Mike Kenney
// released under GPL

/**
 * Constructor for Ellipsoid object.
 *
 * @param  A  length of semi-major axis (meters).
 * @param  B  length of semi-minor axis (meters).
 */
function Ellipsoid(A, B) {
    var asq, bsq;

    this.A = A;
    this.B = B;
    asq = A*A;
    bsq = B*B;
    this.EC = (asq - bsq)/asq;
    this.EC2 = (asq - bsq)/bsq;
}

Ellipsoid.prototype.toString = function() {
    return "(" + this.A + "," + this.B + ")";
}

var WGS84 = new Ellipsoid(6378137., 6356752.314);

function deg2rad(d) {
    return d*Math.PI/180.;
}

function rad2deg(r) {
    return r*180./Math.PI;
}

/**
 * Convert a geodetic position (lat, lon) into the earth-centered, 
 * earth-fixed coordinate system (X, Y, Z).
 *
 * @param  lat    latitude in degrees.
 * @param  lon    longitude in degrees.
 * @param  h      height in meters (default 0).
 * @param  datum  Ellipsoid object (default WGS84).
 * @return      ECEF object
 */
function geo2ecef(lat, lon, h, datum) {
    var datum, s, c, N, obj;

    if(h == null)
        h = 0.;
    if(datum == null)
        datum = WGS84;

    lat = deg2rad(lat);
    lon = deg2rad(lon);
    s = [Math.sin(lat), Math.sin(lon)];
    c = [Math.cos(lat), Math.cos(lon)];
    N = datum.A/Math.sqrt(1. - datum.EC*s[0]*s[0]);
    obj = new Object();
    obj.X = (N + h)*c[0]*c[1];
    obj.Y = (N + h)*c[0]*s[1];
    obj.Z = (N*(1 - datum.EC) + h)*s[0];
    return obj;
}

/**
 * Calculate the (straight line) distance between two points in 
 * the ECEF coordinate system.    
 *
 * @param  p0  point to ECEF coordinate system
 * @param  p1  point to ECEF coordinate system
 * @return     distance in meters
 */
function ecef_distance(p0, p1) {
    var dx, dy, dz;

    dx = p1.X - p0.X;
    dy = p1.Y - p0.Y;
    dz = p1.Z - p0.Z;

    return Math.sqrt(dx*dx + dy*dy + dz*dz);
}

/**
 * Calculate the great-circle distance between two points in the
 * ECEF coordinate system. Calculates the angle between the
 * two points using the scalar product method:
 *
 * @param  p0  point in ECEF coordinate system
 * @param  p1  point in ECEF coordinate system
 * @return     distance in meters
 */
function ecef_gc_distance(p0, p1) {
    var r0, r1, theta, dprod;

    // Calculate radius at each point
    r0 = Math.sqrt(p0.X*p0.X + p0.Y*p0.Y + p0.Z*p0.Z);
    r1 = Math.sqrt(p1.X*p1.X + p1.Y*p1.Y + p1.Z*p1.Z);

    // Dot (scalar) product of the two vectors
    dprod = p0.X*p1.X + p0.Y*p1.Y + p0.Z*p1.Z;

    // Angle between the vectors
    theta = Math.acos(dprod/(r1*r0));

    // Use the average radius to calculate arc length
    return (r0 + r1)*theta/2.;
}

/**
 * Add some useful attributes to a GPoint
 *
 */
GPoint.prototype.addParasite = function(obj) {
    var key;
    this.parasite = new Array();
    for(key in obj) {
        this.parasite[key] = obj[key];
    }
};

/**
 * GLatLng replaces GPoint in version 2 of the API.
 */
try {
    GLatLng.prototype.addParasite = function(obj) {
        var key;
        this.parasite = new Array();
        for(key in obj) {
            this.parasite[key] = obj[key];
        }
    };
} catch(e) {
}

/**
 * Constructor for a class to implement a set of virtual "dividers"
 * to measure distances on a GMap. Inspired by the very nice
 * LengthFinder script at http://www.benno.id.au/map/length.html.
 *
 * @param   map   GMap object
 * @param   icon  GIcon to use for marker points (optional)
 * @param   cback callback function for each new marker. Should accept
 *                a single GOverlay argument. Called when the marker
 *                is clicked (optional)
 */
function Dividers(map, icon, cback) {
    this.ecef_pts = [];
    this.pts = [];
    this.overlays = [];
    this.nr_pts = 0;
    this.total = 0;
    this.last_seg = 0;
    this.map = map;
    this.icon = icon;
    this.phandler = cback;
    this.form_node = null;

    if(!this.icon) {
        this.icon = new GIcon();
        this.icon.image = "http://labs.google.com/ridefinder/images/mm_20_red.png";
	this.icon.shadow = "http://labs.google.com/ridefinder/images/mm_20_shadow.png";
	this.icon.iconSize = new GSize(12, 20);
	this.icon.shadowSize = new GSize(22, 20);
	this.icon.iconAnchor = new GPoint(6, 20);
	this.icon.infoWindowAnchor = new GPoint(5, 1);
    }

    this.display = function (table) {
        var node;
        for(var key in table) {
            node = document.getElementById(key);
	    if(node) {
                node.firstChild.nodeValue = table[key];
            }
        }
    };

    this.cvt = function(x) { return x; };

    var handle = null;
    this.activate = function() {
        handle = GEvent.bind(this.map, "click", this, this.measure)
    };

    this.deactivate = function() {
        if(handle)
            GEvent.removeListener(handle);
    };

    this.undo = function() {
        if(this.nr_pts > 0) {

	    // Remove the last marker
            this.map.removeOverlay(this.overlays.pop());

	    // Remove the last line segment
            if(this.nr_pts > 1)
                this.map.removeOverlay(this.overlays.pop());

            this.ecef_pts.pop();
            this.pts.pop();
            this.nr_pts--;
            this.total -= this.last_seg;

            var d = 0;
            if(this.nr_pts > 1) {
                var i0 = this.nr_pts-1;
                var i1 = this.nr_pts-2;
                d = ecef_distance(this.ecef_pts[i0], this.ecef_pts[i1]);
	        if(d > 10000) {
	            d = ecef_gc_distance(this.ecef_pts[i0], this.ecef_pts[i1]);
                }
            }

            this.last_seg = d;
            this.display({'dist': this.cvt(Math.floor(Math.round(d))),
                          'total' : this.cvt(Math.floor(Math.round(this.total)))});
        }
    };

}


/**
 * Reset the dividers and clear all markers.
 */
Dividers.prototype.reset = function() {
    for(var e in this.overlays) {
        this.map.removeOverlay(this.overlays[e]);
    }

    this.overlays = [];
    this.ecef_pts = [];
    this.pts = [];
    this.nr_pts = 0;
    this.total = 0;
};

/**
 * "Click" event handler for a GMap. Clicking a point on the map will draw
 * a marker and a line connecting it to the previous marker. Clicking on
 * an existing marker will open an InfoWindow and call the point-handler
 * function.
 */
Dividers.prototype.measure = function(ovlay, pt) {
    if(ovlay) {
        if(this.phandler) {
            this.phandler(ovlay);
        }

    } else if(pt) {
        
        // Convert each lat,lon to the ECEF coordinate system
        // for fast distance calculation. We calculate the
        // chord distance by default (earth's curvature is
        // ignored) but recalculate the great-circle distance
        // for distances greater than 10km.
        var  m, p, d, ecef;

        pt.addParasite({"ele" : 0.0,
                        "name" : "GMAP" + this.nr_pts,
                        "desc" : ""});
        m = new GMarker(pt, this.icon);
        this.overlays.push(m);
        this.map.addOverlay(m);
        ecef = geo2ecef(pt.y, pt.x);
        this.ecef_pts.push(ecef);
        this.pts.push(pt);
        this.nr_pts++;
        if(this.nr_pts > 1) {
            var i0 = this.nr_pts-1;
            var i1 = this.nr_pts-2;

            p = new GPolyline([this.pts[i0], this.pts[i1]],
                                         "#ff0000", 2);
            this.overlays.push(p);
            this.map.addOverlay(p);
            d = ecef_distance(this.ecef_pts[i0], this.ecef_pts[i1]);
	    if(d > 10000) {
	        d = ecef_gc_distance(this.ecef_pts[i0], this.ecef_pts[i1]);
            }
            this.last_seg = d;
            this.total += d;
            this.display({'dist': this.cvt(Math.floor(Math.round(d))),
                          'total' : this.cvt(Math.floor(Math.round(this.total)))});
        }
    }
}

/**
 * Set the conversion function for the segment length and total length
 *
 * @param  f  function which takes a single argument, a distance in meters.
 */
Dividers.prototype.setConvert = function(f) {
    this.cvt = f;
}

/**
 * Get the list of GPoint which comprise the route.
 *
 * @return  array of GPoint objects
 */
Dividers.prototype.getRoute = function() {
    return this.pts;
}

/**
 * Utility function to calculate the appropriate zoom level for a
 * given bounding box and map image size. Uses the formula described
 * in the Google Mapki (http://mapki.com/).
 *
 * @param  bounds  bounding box (GBounds instance)
 * @param  mnode   DOM element containing the map.
 * @return         zoom level.
 */
function best_zoom(bounds, mnode) {
    var width = mnode.offsetWidth;
    var height = mnode.offsetHeight;

    var dlat = Math.abs(bounds.maxY - bounds.minY);
    var dlon = Math.abs(bounds.maxX - bounds.minX);
    if(dlat == 0 && dlon == 0)
        return 4;
 
    // Center latitude in radians
    var clat = Math.PI*(bounds.minY + bounds.maxY)/360.;

    var C = 0.0000107288;
    var z0 = Math.ceil(Math.log(dlat/(C*height))/Math.LN2);
    var z1 = Math.ceil(Math.log(dlon/(C*width*Math.cos(clat)))/Math.LN2);

    return (z1 > z0) ? z1 : z0;
}

/**
 * Return an array of distances (in meters) between successive elements
 * of a GPoints array. distance[i] is the distance between point[i] and
 * point[i+1]
 *
 * @param  pts  array of GPoints
 * @return      array of distance measurements
 */
function distances(pts) {
    var d = [];
    var n = pts.length - 1;
    var p0, p1;

    for(var i = 0;i < n;i++) {
        p0 = geo2ecef(pts[i].y, pts[i].x);
        p1 = geo2ecef(pts[i+1].y, pts[i+1].x);
        d.push(ecef_gc_distance(p0, p1))
    }

    return d;
}

// Graticule for google.maps v3
//
// Adapted from Bill Chadwick 2006 http://www.bdcc.co.uk/Gmaps/BdccGmapBits.htm
// which is free for any use.
//
// This work is licensed under the Creative Commons Attribution 3.0 Unported
// License. To view a copy of this license, visit
// http://creativecommons.org/licenses/by/3.0/ or send a letter to Creative
// Commons, 171 Second Street, Suite 300, San Francisco, California, 94105,
// USA.
//
// Matthew Shen 2011
//
var Graticule = (function () {
  function _(map, sexagesimal) {
    // default to decimal intervals
    this.sex_ = sexagesimal || false;
    this.set('container', document.createElement('DIV'));

    this.show();

    this.setMap(map);
  }
  _.prototype = new google.maps.OverlayView();
  _.prototype.addDiv = function(div) {
    this.get('container').appendChild(div);
  },
  _.prototype.decToSex = function(d) {
    var degs = Math.floor(d);
    var mins = ((Math.abs(d) - degs) * 60.0).toFixed(2);
    if (mins == "60.00") { degs += 1.0; mins = "0.00"; }
    return [degs, ":", mins].join('');
  };
  _.prototype.onAdd = function () {
    var self = this;
    this.getPanes().mapPane.appendChild(this.get('container'));

    function redraw() {
      self.draw();
    }
    google.maps.event.addListener(this.getMap(), 'idle', redraw);

    function changeColor() {
      var color = _bestTextColor(self);
      var s = self.get('container').style;
      s.color = color;
      s.backgroundColor = color;
    }
    changeColor();
    google.maps.event.addListener(this.getMap(), 'maptypeid_changed', changeColor);
  };
  _.prototype.clear = function () {
    var container = this.get('container');
    while (container.hasChildNodes()) {
      container.removeChild(container.firstChild);
    }
  };
  _.prototype.onRemove = function() {
    this.getPanes().mapPane.removeChild(container);
  };
  _.prototype.show = function () {
    this.get('container').style.visibility = 'visible';
  };
  _.prototype.hide = function() {
    this.get('container').style.visibility = 'hidden';
  };

  function _bestTextColor(overlay) {
    var type = overlay.getMap().getMapTypeId();
    var GMM = google.maps.MapTypeId;
    if (type === GMM.HYBRID) return '#fff';
    if (type === GMM.ROADMAP) return '#000';
    if (type === GMM.SATELLITE) return '#fff';
    if (type === GMM.TERRAIN) return '#000';
    return '#fff';
  };

  function gridPrecision(dDeg) {
    if (dDeg < 0.01) return 3;
    if (dDeg < 0.1) return 2;
    if (dDeg < 1) return 1;
    return 0;
  }

  function leThenReturn(x, l, d) {
    for (var i = 0; i < l.length; i += 1) {
      if (x <= l[i]) {
        return l[i];
      }
    }
    return d;
  }

  var numLines = 10;
  var decmins = [
    0.06, // 0.001 degrees
    0.12, // 0.002 degrees
    0.3, // 0.005 degrees
    0.6, // 0.01 degrees
    1.2, // 0.02 degrees
    3, // 0.05 degrees
    6, // 0.1 degrees
    12, // 0.2 degrees
    30, // 0.5
    60, // 1
    60 * 2,
    60 * 5,
    60 * 10,
    60 * 20,
    60 * 30,
  ];
  var sexmins = [
    0.01, // minutes
    0.02,
    0.05,
    0.1,
    0.2,
    0.5,
    1.0,
    3, // 0.05 degrees
    6, // 0.1 degrees
    12, // 0.2 degrees
    30, // 0.5
    60, // 1
    60 * 2,
    60 * 5,
    60 * 10,
    60 * 20,
    60 * 30,
  ];

  function mins_list(overlay) {
    if (overlay.sex_) return sexmins;
    return decmins;
  }

  function latLngToPixel(overlay, lat, lng) {
    return overlay.getProjection().fromLatLngToDivPixel(
      new google.maps.LatLng(lat,lng));
  };

  // calculate rounded graticule interval in decimals of degrees for supplied
  // lat/lon span return is in minutes
  function gridInterval(dDeg, mins) {
    return leThenReturn(Math.ceil(dDeg / numLines * 6000) / 100, mins,
                        60 * 45) / 60;
  }

  function npx(n) {
    return n.toString() + 'px';
  }

  function makeLabel(x, y, text) {
    var d = document.createElement('DIV');
    var s = d.style;
    s.position = 'absolute';
    s.left = npx(x);
    s.top = npx(y);
    s.color = 'inherit';
    s.width = '3em';
    s.fontSize = '0.6em';
    s.whiteSpace = 'nowrap';
    d.innerHTML = text;
    return d;
  };

  function createLine(x, y, w, h) {
    var d = document.createElement('DIV');
    var s = d.style;
    s.position = 'absolute';
    s.overflow = 'hidden';
    s.backgroundColor = 'inherit';
    s.opacity = 0.3;
    var s = d.style;
    s.left = npx(x);
    s.top = npx(y);
    s.width = npx(w);
    s.height = npx(h);
    return d;
  };

  var span = 50000;
  function meridian(px) {
    return createLine(px, -span, 1, 2 * span);
  }
  function parallel(py) {
    return createLine(-span, py, 2 * span, 1);
  }
  function eqE(a, b, e) {
    if (!e) {
      e = Math.pow(10, -6);
    }
    if (Math.abs(a - b) < e) {
      return true;
    }
    return false;
  }

  // Redraw the graticule based on the current projection and zoom level
  _.prototype.draw = function () {
    this.clear();

    if (this.get('container').style.visibility != 'visible') {
      return;
    }

    // determine graticule interval
    var bnds = this.getMap().getBounds();
    if (!bnds) {
      // The map is not ready yet.
      return;
    }

    var sw = bnds.getSouthWest(),
        ne = bnds.getNorthEast();
    var l = sw.lng(),
        b = sw.lat(),
        r = ne.lng(),
        t = ne.lat();
    if (l == r) { l = -180.0; r = 180.0; }
    if (t == b) { b = -90.0; t = 90.0; }

    // grid interval in degrees
    var mins = mins_list(this);
    var dLat = gridInterval(t - b, mins);
    var dLng = gridInterval(r > l ? r - l : ((180 - l) + (r + 180)), mins);

    // round iteration limits to the computed grid interval
    l = Math.floor(l / dLng) * dLng;
    b = Math.floor(b / dLat) * dLat;
    t = Math.ceil(t / dLat) * dLat;
    r = Math.ceil(r / dLng) * dLng;
    if (r == l) l += dLng;
    if (r < l) r += 360.0;

    // lngs
    var crosslng = l + 2 * dLng;
    // labels on second column to avoid peripheral controls
    var y = latLngToPixel(this, b + 2 * dLat, l).y + 2;

    // lo<r to skip printing 180/-180
    for (var lo = l; lo < r; lo += dLng) {
      if (lo > 180.0) {
        r -= 360.0;
        lo -= 360.0;
      }
      var px = latLngToPixel(this, b, lo).x;
      this.addDiv(meridian(px));

      var atcross = eqE(lo, crosslng);
      this.addDiv(makeLabel(
        px + (atcross ? 17 : 3), y - (atcross ? 3 : 0),
        (this.sex_ ? this.decToSex(lo) : lo.toFixed(gridPrecision(dLng)))));
    }

    // lats
    var crosslat = b + 2 * dLat;
    // labels on second row to avoid controls
    var x = latLngToPixel(this, b, l + 2 * dLng).x + 3;

    for(; b <= t; b += dLat){
      var py = latLngToPixel(this, b, l).y;
      this.addDiv(parallel(py));

      this.addDiv(makeLabel(
        x, py + (eqE(b, crosslat) ? 7 : 2),
        (this.sex_ ? this.decToSex(b) : b.toFixed(gridPrecision(dLat)))));
    }
  };

  return _;
})();

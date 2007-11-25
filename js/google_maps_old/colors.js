// arch-tag: e20197f5-d07b-4b0f-896d-91ded300a340
//
// Javascript color conversion functions
//

function RGB(r, g, b) {
    this.r = r;
    this.g = g;
    this.b = b;

    this.parse = function(s) {
        this.r = parseInt(s.substr(1, 2), 16);
        this.g = parseInt(s.substr(3, 2), 16);
        this.b = parseInt(s.substr(5, 2), 16);
    };

    this.toString = function() {
        var s = [];
        var c;

        s.push("#");
        c = this.r.toString(16);
        s.push(c.length == 2 ? c : "0" + c);
        c = this.g.toString(16);
        s.push(c.length == 2 ? c : "0" + c);
        c = this.b.toString(16);
        s.push(c.length == 2 ? c : "0" + c);
        return s.join("");
    };
}

/**
 * Convert a color in HSV space to RGB space
 *
 * @param  h  hue [0, 360]
 * @param  s  saturation [0, 1.]
 * @param  v  value [0, 1.]
 * @return    RGB object
 */
function hsv2rgb(h, s, v) {
    var r, g, b;
    var f, p, q, t;
    var q = new Array(6);

    if(s == 0) {
        r = g = b = Math.floor(v*256);
    } else {
        h = (h % 360)/60.;
        i = Math.floor(h);
        f = h - i;

        q[0] = v*(1 - s);
        q[1] = q[0];
        q[2] = v*(1 - s*(1 - f));
        q[3] = v;
        q[4] = q[3];
        q[5] = v*(1 - s*f);
        r = q[(i+4)%6];
        g = q[(i+2)%6];
        b = q[i%6];
    }

    return new RGB(Math.floor(r*256),
                   Math.floor(g*256),
                   Math.floor(b*256));
}


/*----------------------------------------------------------------------------\
|                            Canvas Chart Painter                             |
|                  Based on Chart 1.0 created by Emil A Eklund                |
|                        (http://eae.net/contact/emil)                        |
|-----------------------------------------------------------------------------|
|                      Copyright (c) 2006 Emil A Eklund                       |
|             Copyright (c) 2007 Victor Berchet - MooTools usage              |
|- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -|
| This program is  free software;  you can redistribute  it and/or  modify it |
| under the terms of the MIT License.                                         |
|- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -|
| Permission  is hereby granted,  free of charge, to  any person  obtaining a |
| copy of this software and associated documentation files (the "Software"),  |
| to deal in the  Software without restriction,  including without limitation |
| the  rights to use, copy, modify,  merge, publish, distribute,  sublicense, |
| and/or  sell copies  of the  Software, and to  permit persons to  whom  the |
| Software is  furnished  to do  so, subject  to  the  following  conditions: |
| The above copyright notice and this  permission notice shall be included in |
| all copies or substantial portions of the Software.                         |
|- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -|
| THE SOFTWARE IS PROVIDED "AS IS",  WITHOUT WARRANTY OF ANY KIND, EXPRESS OR |
| IMPLIED,  INCLUDING BUT NOT LIMITED TO  THE WARRANTIES  OF MERCHANTABILITY, |
| FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE |
| AUTHORS OR  COPYRIGHT  HOLDERS BE  LIABLE FOR  ANY CLAIM,  DAMAGES OR OTHER |
| LIABILITY, WHETHER  IN AN  ACTION OF CONTRACT, TORT OR  OTHERWISE,  ARISING |
| FROM,  OUT OF OR  IN  CONNECTION  WITH  THE  SOFTWARE OR THE  USE OR  OTHER |
| DEALINGS IN THE SOFTWARE.                                                   |
|- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -|
|                         http://eae.net/license/mit                          |
\----------------------------------------------------------------------------*/

/*
Class: CanvasChartPainter
Internal class used by chart for painting.
*/

var CanvasChartPainter = new Class({
    calc : function(w, h, xlen, ymin, ymax, xgd, ygd) {
        this.range = ymax - ymin;
        this.xstep = w / (xlen - 1);
        this.xgrid = xgd?w / (xgd - 1):0;
        this.ygrid = ygd?h / (ygd - 1):0;
        this.ymin  = ymin;
        this.ymax  = ymax;
    },
    initialize : function(el, xlen, ymin, ymax, xgd, ygd, bLegendLabels) {
        this.el = el = $(el);
        el.empty();

        var dim = el.getCoordinates();
        this.w = this.chartw = dim.width;
        this.h = this.charth = dim.height;

        this.canvas = new Element('canvas', {'styles' : { 'width' : this.w,
                                                          'height' : this.h}
                                            }).injectInside(el);
        this.canvas.width  = this.w;
        this.canvas.height = this.h;

        /* Init explorercanvas emulation for IE */
        if ((!this.canvas.getContext) && (typeof G_vmlCanvasManager != "undefined")) {
            this.canvas = G_vmlCanvasManager.initElement(this.canvas);
        }

        this.ctx = this.canvas.getContext('2d');

        this.chartx = 0;
        this.charty = 0;

        this.xlen = xlen;
        this.ymin = ymin;
        this.ymax = ymax;
        this.xgd  = xgd;
        this.ygd  = ygd;
    
        this.calc(this.chartw, this.charth, xlen, ymin, ymax, xgd, ygd);
    },

    drawLegend : function(series) {
        var legend, list;
    
        legend = new Element('div', {'styles' : {'position' : 'absolute',
                                                 'right': 0},
                                     'class' : 'legend'
                                    });
    
        list = new Element('ul').injectInside(legend.injectInside(this.el));
    
        series.each(function(serie) {
            new Element('span', {'styles' : {'color' : 'black'}})
                .appendText(serie.label)
                .injectInside(new Element('li', {'styles': {'color' : serie.color}})
                                  .injectInside(list));
        });
    
        this.legend = legend.setStyle('top', this.charty + (this.charth - legend.offsetHeight ) / 2);
    
        /* Recalculate chart width and position based on labels and legend */
        this.chartw = this.w - (this.legend.offsetWidth + 5);
        
        this.calc(this.chartw, this.charth, this.xlen, this.ymin, this.ymax, this.xgd, this.ygd);
    },

    drawVerticalLabels: function(ygd, precision, labelPos) {
        var item, y, ty, pos;
    
        var xLblIn = (labelPos.x.toLowerCase() == 'in');
        var yLblIn = (labelPos.y.toLowerCase() == 'in');
    
        /* Calculate step size and rounding precision */
        var multiplier = Math.pow(10, precision);
        var step = this.range / (ygd - 1);
    
        /* Create container */
        var axis = new Element('div', {'styles' : {'position' : 'absolute',
                                                   'left' : yLblIn?10:0,
                                                   'top' : 0,
                                                   'textAlign' : 'right'}
                                      }).injectInside(this.el);
    
        /* Draw labels and points */
        this.ctx.fillStyle = 'black';
        var w = 0;
        var items = [];
        for (n = 0, i = this.ymax; (i > this.ymin) && (n < ygd - 1); i -= step, n++) {
            item = new Element('span')
                       .setText(parseInt(i * multiplier) / multiplier)
                       .injectInside(axis);
            items.push([i, item]);
            w = Math.max(w, item.offsetWidth);
        }
    
        /* Draw last label and point (lower left corner of chart) */
        item = new Element('span')
                   .setText(this.ymin)
                   .injectInside(axis);
        items.push([this.ymin, item]);
        w = Math.max(w, item.offsetWidth);
    
        /* Recalculate chart width and position based on labels and legend */
        var lblWidth = yLblIn?5:w + 5;
        var lblHeight = xLblIn?Math.max(item.offsetHeight / 2, 5):item.offsetHeight + 5;
        this.chartx = lblWidth;
        this.charty = item.offsetHeight / 2;
        this.charth = this.h - (lblHeight + this.charty);
        this.chartw = this.w - ((this.legend?this.legend.offsetWidth:0) + 5 + lblWidth);
        this.calc(this.chartw, this.charth, this.xlen, this.ymin, this.ymax, this.xgd, this.ygd);

        /* Set width of container to width of widest label */
        axis.setStyle('width', w + 10);

        /* Position labels on the axis */
        var n = this.range / this.charth;
        var yoffset = this.ymin / n;
        items.each(function(item) {
            label = item[1];
            pos = item[0];
            if (pos == this.ymin) { 
                y = this.charty + this.charth - 1; 
            } else {
                y = this.charty + (this.charth - (pos / n) + yoffset);
            }
            this.ctx.fillRect(this.chartx - 5, y, 5, 1);
            ty = y - (label.offsetHeight / 2);
            label.setStyles({'position' : 'absolute',
                             'top' : ty,
                             'background' : 'white'});
            label.setStyle(yLblIn?'left':'right', 0);
        }, this);
    },


    drawHorizontalLabels : function(xlen, labels, xgd, precision, labelPos) {
        var axis, item, step, x, tx;

        var xLblIn = (labelPos.x.toLowerCase() == 'in');

        /* Calculate offset, step size and rounding precision */
        var multiplier = Math.pow(10, precision);
        var n = this.chartw / (xgd - 1);
    
        /* Create container */
        axis = new Element('div', {'styles': {'position' : 'absolute',
                                              'left' : 0,
                                              'top' : this.charty + this.charth + 5,
                                              'width' : this.w }
                                  }).injectInside(this.el);
    
        /* Draw labels and points */
        this.ctx.fillStyle = 'black';
        for (i = 0; i < xgd; i++) {
            item = new Element('span')
                       .setText(labels[i])
                       .injectInside(axis);
            x = this.chartx + (n * i);
            tx = x - (item.offsetWidth / 2);
            tx = Math.max(tx, this.chartx);
            tx = Math.min(tx, this.chartx + this.chartw - item.offsetWidth)
            item.setStyles({'position' : 'absolute',
                            'left' : tx,
                            'top' : '0px'});
            this.ctx.fillRect(x, this.charty + this.charth, 1, 5);
        }
    
        if (xLblIn) {
            axis.setStyle('top', this.charty + this.charth - item.offsetHeight);
        }
    },

    drawAxis : function() {
        this.ctx.fillStyle = 'black';
        this.ctx.fillRect(this.chartx, this.charty, 1, this.charth-1);
        this.ctx.fillRect(this.chartx, this.charty + this.charth - 1, this.chartw+1, 1);
    },

    drawBackground : function() {
        this.ctx.fillStyle = 'white';
        this.ctx.fillRect(0, 0, this.w, this.h);
    },

    drawGrid : function() {
        this.ctx.fillStyle = 'silver';
        if (this.xgrid) {
            for (i = this.xgrid; i < this.chartw; i += this.xgrid) {
                this.ctx.fillRect(this.chartx + i, this.charty, 1, this.charth-1);
            }
        }
        if (this.ygrid) {
            for (i = this.charth - this.ygrid; i > 0; i -= this.ygrid) {
                this.ctx.fillRect(this.chartx + 1, this.charty + i, this.chartw, 1);
            }
            if ((this.ymin * this.ymax) < 0) {
                this.ctx.fillStyle = '#FFA07A';
                var y0 = this.ymax * this.charth / (this.ymax - this.ymin);
                this.ctx.fillRect(this.chartx + 1, this.charty + y0, this.chartw, 1);
            }
        }
    },

    drawArea : function(color, values) {
        var i, x, y;
    
        /* Determine distance between points and offset */
        var n = this.range / this.charth;
        var yoffset = (this.ymin / n);

        var len = values.length;
        if (len) {
            this.ctx.fillStyle = color;
    
            /* Begin line in lower left corner */
            x = this.chartx + 1;
            this.ctx.beginPath();
            this.ctx.moveTo(x, this.charty + this.charth - 1);
    
            /* Determine position of first point and draw it */
            y = this.charty + this.charth - (values[0] / n) + yoffset;
            this.ctx.lineTo(x, y);
    
            /* Draw lines to succeeding points */
            for (i = 1; i < len; i++) {
                y = this.charty + this.charth - (values[i] / n) + yoffset;
                x += this.xstep;
                this.ctx.lineTo(x, y);
            }
    
            /* Close path and fill it */
            this.ctx.lineTo(x, this.charty + this.charth - 1);
            this.ctx.closePath();
            this.ctx.fill();
        }   
    },

    drawLine : function(color, values) {
        var i, x, y;
    
        /* Determine distance between points and offset */
        var n = this.range / this.charth;
        var yoffset = (this.ymin / n);

        var len = values.length;
        if (len) {
            this.ctx.lineWidth   = 1;
            this.ctx.strokeStyle = color;
    
            /* Determine position of first point and draw it */
            x = this.chartx + 1;
            y = this.charty + this.charth - (values[0] / n) + yoffset;
            this.ctx.beginPath();
            this.ctx.moveTo(x, y);
    
            /* Draw lines to succeeding points */
            for (i = 1; i < len; i++) {
                y = this.charty + this.charth - (values[i] / n) + yoffset;
                x += this.xstep;
                this.ctx.lineTo(x, y);
            }
    
            /* Stroke path */
            this.ctx.stroke();
        }
    },

    drawBars : function(color, values, xlen, xoffset, width) {
        var i, x, y;
    
        /* Determine distance between points and offset */
        var n = this.range / this.charth;
        var yoffset = (this.ymin / n);

        var len = values.length;
        if (len > xlen) { len = xlen; }
        if (len) {
            this.ctx.fillStyle = color;
    
            /* Determine position of each bar and draw it */
            x = this.chartx + xoffset + 1;
            for (i = 0; i < len; i++) {
                y = this.charty + this.charth - (values[i] / n) + yoffset;
    
                this.ctx.beginPath();
                this.ctx.moveTo(x, this.charty + this.charth-1);
                this.ctx.lineTo(x, y );
                this.ctx.lineTo(x+width, y);
                this.ctx.lineTo(x+width, this.charty + this.charth-1);
                this.ctx.closePath();
                this.ctx.fill();
    
                x += this.xstep;
            }
        }
    },

    getCoordinates : function() {
        return {left: this.chartx,
                top: this.charty,
                width: this.chartw,
                height: this.charth};
    }
});


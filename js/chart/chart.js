/*----------------------------------------------------------------------------\
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

var CHART_LINE    =  1;
var CHART_AREA    =  2;
var CHART_BAR     =  4;
var CHART_STACKED =  8;

/*
Class: Chart
        Draw line, area, stacked and bar charts.
*/
var Chart = new Class({
    options : {
        xGridDensity : 0,
        yGridDensity : 0,
        defaultFlags : 0,
        labelPrecision : 0,
        labelPos : {'x': 'out', 'y': 'in'},
        xLabels : [],
        barWidth : 10,
        barDistance : 2,
        showLegend : false
    },
    /*
    Property: initialize
            Class constructor.

    Arguments:
            el - chart container
            options - an object representing Chart options. See Options below.

    Options:
        xGridDensity - number of labels on the x axis
        yGridDensity - number of labals on the y axis
        defaultFlags - default flags for data series
        labelPrecision - labels precision
        labelPos - object; set the label positions to be inside or outside the graph {'x' : 'in'/'out', 'y' : 'in'/'out'}
        xLabels - labels for the x axis
        barWidth - bar width
        barDistance - distance between bars
        showLegend - true to show the legend
    */
    initialize: function(el, options) {
        this.setOptions(options);
        this._cont = $(el);
        this._bar = 0;
        this._series = [];
        this._chartCoordinates = {};
    },
    /*
    Property: setLabelPrecision
            Set the numeric precision for the labels

    Arguments:
            p - precision
    */
    setLabelPrecision : function(p) {
        this.options.labelPrecision = p;
    },
    /*
    Property: setShowLegend
            Enable the legend

    Arguments:
            b - true to enable the legend
    */
    setShowLegend : function(b) {
        this.options.showLegend = b;
    },
    /*
    Property: setGridDensity
            Set the grid (and labels) density

    Arguments:
            dx - grid density on the x axis
            dy - grid density on the y axis
    */
    setGridDensity : function(dx, dy) {
        this.options.xGridDensity = dx;
        this.options.yGridDensity = dy;
    },
    /*
    Property: setHorizontalLabels
            Set the labels for the x axis

    Arguments:
            labels - array; label list
    */
    setHorizontalLabels : function(labels) {
        this.options.xLabels = labels;
    },
    /*
    Property: add
            Add a data serie to the graph

    Arguments:
            label - label for the serie
            color - color
            values - array; serie
            flags - options
    */
    add : function(label, color, values, flags) {
        var offset;
        var opt = this.options;
        flags = $pick(flags, this._flags);
        if (flags & CHART_BAR) {
            offset = opt.barDistance + this._bars * (opt.barWidth + opt.barDistance);
            this._bars++;
        } else {
            offset = 0;
        }

        this._series.push({'label' : label, 'color' : color, 'values' : values, 'flags' : flags, 'offset' : offset});
    },
    /*
    Property: draw
            Render the graph
    */
    draw : function() {
        var i, j, o, o2, len;

        if (!window.CanvasRenderingContext2D || !this._series) {
            return;
        }

        /* Initialize */
        var series = [];
        var xlen = 0;
        var ymin = this._series[0].values[0];
        var ymax = this._series[0].values[0];
        var opt = this.options;

        /* Separate stacked series (as they need processing). */
        this._series.each(function(serie) {
            if (serie.flags & CHART_STACKED) series.push(serie);
        });

        /* Calculate values for stacked series */
        for (i = series.length - 2; i >= 0; i--) {
            o  = series[i].values;
            o2 = series[i+1].values;
            len = Math.max(o2.length, o.length);
            for (j = 0; j < len; j++) {
                if ((o[j]) && (!o2[j])) { continue; }
                if ((!o[j]) && (o2[j])) { o[j] = o2[j]; }
                else { o[j] = parseInt(o[j]) + parseFloat(o2[j]); }
        }   }

        /* Append non-stacked series to list */
        this._series.each(function(serie) {
            if (!(serie.flags & CHART_STACKED)) series.push(serie);
        });

        /* Determine maximum number of values, ymin and ymax */
        series.each(function(serie) {
            xlen = Math.max(xlen, serie.values.length);
            for (i = serie.values.length - 1; i >= 0; i--) {
                o = serie.values[i];
                ymin = Math.min(ymin, o);
                ymax = Math.max(ymax, o);
            }
        });
        if (ymin == ymax) {
            ymin -= 1;
            ymax += 1;
        }

        /*
         * For bar only charts the number of charts is the same as the length of the
         * longest series, for others combinations it's one less. Compensate for that
         * for bar only charts.
         */
        if (this._series.length == this._bars) {
            xlen++;
            opt.xGridDensity++;
        }

        /*
         * Determine whatever or not to show the legend and axis labels
         * Requires density and labels to be set.
         */
        var bLabels = (opt.xGridDensity && opt.yGridDensity &&
                      (opt.xLabels.length >= opt.xGridDensity));

        var painter = new CanvasChartPainter(this._cont, xlen, ymin, ymax, opt.xGridDensity, opt.yGridDensity, bLabels);

        /* Draw chart */
        painter.drawBackground();

        /*
         * If labels and grid density where specified, draw legend and labels.
         * It's drawn prior to the chart as the size of the legend and labels
         * affects the size of the chart area.
         */
        if (opt.showLegend) {painter.drawLegend(series);}

        if (bLabels) {
            painter.drawVerticalLabels(opt.yGridDensity,
                                       opt.labelPrecision,
                                       opt.labelPos);
            painter.drawHorizontalLabels(xlen, opt.xLabels,
                                         opt.xGridDensity,
                                         opt.labelPrecision,
                                         opt.labelPos);
        }

        /* Draw chart */
        painter.drawGrid();

        /* Draw series */
        series.each(function(serie) {
            switch (serie.flags & ~CHART_STACKED) {
                case CHART_LINE:
                    painter.drawLine(serie.color, serie.values);
                    break;
                case CHART_AREA:
                    painter.drawArea(serie.color, serie.values);
                    break;
                case CHART_BAR:
                    painter.drawBars(serie.color, serie.values,
                                     xlen - 1, serie.offset,
                                     opt.barWidth);
                    break;
                default: ;
            };
        });

        /*
         * Draw axis (after the series since the anti aliasing of the lines may
         * otherwise be drawn on top of the axis)
         */
        painter.drawAxis();

        this._chartCoordinates = painter.getCoordinates();

    },
    /*
    Property: getCoordinates
            Return the chart coordinates
            
    Returns
        Object
            left - left position
            top - top position
            width - width
            height - height
    */
    getCoordinates : function() {
        return this._chartCoordinates;
    }

});

Chart.implement(new Options);

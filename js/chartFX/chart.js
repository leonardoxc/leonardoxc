/*----------------------------------------------------------------------------\
|                                  Chart 1.0                                  |
|-----------------------------------------------------------------------------|
|                          Created by Emil A Eklund                           |
|                        (http://eae.net/contact/emil)                        |
|-----------------------------------------------------------------------------|
| Client side chart painter, supports line, area and bar charts and stacking, |
| uses Canvas (mozilla,  safari,  opera) or SVG (mozilla, opera) for drawing. |
| Can be used with IECanvas to allow the canvas painter to be used in IE.     |
|-----------------------------------------------------------------------------|
|                      Copyright (c) 2006 Emil A Eklund                       |
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
|-----------------------------------------------------------------------------|
| Dependencies: canvaschartpainter.js  - Canvas chart painter implementation. |
|               canvaschart.css        - Canvas chart painter styles.         |
|           or: svgchartpainter.js     - SVG chart painter implementation.    |
|-----------------------------------------------------------------------------|
| 2006-01-03 | Work started.                                                  |
| 2006-01-05 | Added legend and axis labels. Changed the painter api slightly |
|            | to allow two-stage initialization (required for ie/canvas) and |
|            | added legend/axis related methods. Also updated bar chart type |
|            | and added a few options, mostly related to bar charts.         |
| 2006-01-07 | Updated chart size calculations to take legend and axis labels |
|            | into consideration.  Split painter implementations to separate |
|            | files.                                                         |
| 2006-01-10 | Fixed bug in automatic range calculation.  Also added explicit |
|            | cast to float for stacked series.                              |
| 2006-04-16 | Updated constructor to set painter factory  based on available |
|            | and supported implementations.                                 |
|-----------------------------------------------------------------------------|
| Created 2006-01-03 | All changes are in the log above. | Updated 2006-04-16 |
\----------------------------------------------------------------------------*/

var CHART_LINE    =  1;
var CHART_AREA    =  2;
var CHART_BAR     =  3;
var CHART_STACKED =  4;

/*----------------------------------------------------------------------------\
|                                    Chart                                    |
|- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -|
| Chart class, control class that's used to represent a chart. Uses a painter |
| class for the actual drawing.  This is the only  class that should be  used |
| directly, the other ones are internal.                                      |
\----------------------------------------------------------------------------*/

function Chart(el) {
	this._cont             = el;
	this._yMin             = null;
	this._yMax             = null;
	this._xGridDensity     = 0;
	this._yGridDensity     = 0;
	this._flags            = 0;
	this._series           = new Array();
	this._labelPrecision   = 0;
	this._horizontalLabels = new Array();
	this._barWidth         = 10;
	this._barDistance      = 2;
	this._bars             = 0;
	this._showLegend       = true;
	
	/*
	 * Determine painter implementation to use based on what's available and
	 * supported. CanvasChartPainter is the prefered one, JsGraphicsChartPainter
	 * the fallback one as it works in pretty much any browser. The
	 * SVGChartPainter implementation one will only be used if set explicitly as
	 * it's not up to pair with the other ones.
	 */
	if ((typeof CanvasChartPainterFactory != 'undefined') && (window.CanvasRenderingContext2D)) {
		this._painterFactory = CanvasChartPainterFactory;
	}
	else if (typeof JsGraphicsChartPainterFactory != 'undefined') {
		this._painterFactory = JsGraphicsChartPainterFactory;
	}
	else { this._painterFactory = null; }
}


Chart.prototype.setPainterFactory = function(f) {
	this._painterFactory = f;
};


Chart.prototype.setVerticalRange = function(min, max) {
	this._yMin = min;
	this._yMax = max;
};


Chart.prototype.setLabelPrecision = function(precision) {
	this._labelPrecision = precision;
};


Chart.prototype.setShowLegend = function(b) {
	this._showLegend = b;
};


Chart.prototype.setGridDensity = function(horizontal, vertical) {
	this._xGridDensity = horizontal;
	this._yGridDensity = vertical;
};


Chart.prototype.setHorizontalLabels = function(labels) {
	this._horizontalLabels = labels;
};


Chart.prototype.setDefaultType = function(flags) {
	this._flags = flags;
};


Chart.prototype.setBarWidth = function(width) {
	this._barWidth = width;
};


Chart.prototype.setBarDistance = function(distance) {
	this._barDistance = distance;
};


Chart.prototype.add = function(label, color, values, flags) {
	var o, offset;

	if (!flags) { flags = this._flags; }
	if ((flags & CHART_BAR) == CHART_BAR) { offset = this._barDistance + this._bars * (this._barWidth + this._barDistance); this._bars++; }
	else { offset = 0; }
	o = new ChartSeries(label, color, values, flags, offset);

	this._series.push(o);
};


Chart.prototype.draw = function() {
	var painter, i, o, o2, len, xlen, ymin, ymax, series, type, self, bLabels;
	
	if (!this._painterFactory) { return; }

	/* Initialize */
	series = new Array();
	stackedSeries = new Array();
	xlen = 0;
	ymin = this._yMin;
	ymax = this._yMax;

	/* Separate stacked series (as they need processing). */
	for (i = 0; i < this._series.length; i++) {
		o = this._series[i]
		if ((o.flags & CHART_STACKED) == CHART_STACKED) { series.push(o); }
	}

	/* Calculate values for stacked series */
	for (i = series.length - 2; i >= 0; i--) {
		o  = series[i].values;
		o2 = series[i+1].values;
		len = (o2.length > o.length)?o2.length:o.length;
		for (j = 0; j < len; j++) {
			if ((o[j]) && (!o2[j])) { continue; }
			if ((!o[j]) && (o2[j])) { o[j] = o2[j]; }
			else { o[j] = parseInt(o[j]) + parseFloat(o2[j]); }
	}	}

	/* Append non-stacked series to list */
	for (i = 0; i < this._series.length; i++) {
		o = this._series[i]
		if ((o.flags & CHART_STACKED) != CHART_STACKED) { series.push(o); }
	}

	/* Determine maximum number of values, ymin and ymax */
	for (i = 0; i < series.length; i++) {
		o = series[i]
		if (o.values.length > xlen) { xlen = o.values.length; }
		for (j = 0; j < o.values.length; j++) {
			if ((o.values[j] < ymin) || (ymin == null))  { ymin = o.values[j]; }
			if (o.values[j] > ymax) { ymax = o.values[j]; }
	}	}

	/*
	 * For bar only charts the number of charts is the same as the length of the
	 * longest series, for others combinations it's one less. Compensate for that
	 * for bar only charts.
	 */
	if (this._series.length == this._bars) {
		xlen++;
		this._xGridDensity++;
	}

	/*
	 * Determine whatever or not to show the legend and axis labels
	 * Requires density and labels to be set.
	 */
	bLabels = ((this._xGridDensity) && (this._yGridDensity) && (this._horizontalLabels.length >= this._xGridDensity));

	/* Create painter object */
	painter = this._painterFactory();
	painter.create(this._cont);

	/* Initialize painter object */
	painter.init(xlen, ymin, ymax, this._xGridDensity, this._yGridDensity, bLabels);

	/* Draw chart */
	painter.drawBackground();

	/*
	 * If labels and grid density where specified, draw legend and labels.
	 * It's drawn prior to the chart as the size of the legend and labels
	 * affects the size of the chart area.
	 */
	if (this._showLegend) { painter.drawLegend(series); }
	if (bLabels) {
		painter.drawVerticalAxis(this._yGridDensity, this._labelPrecision);
		painter.drawHorizontalAxis(xlen, this._horizontalLabels, this._xGridDensity, this._labelPrecision);
	}

	/* Draw chart */
	painter.drawChart();

	/* Draw series */
	for (i = 0; i < series.length; i++) {
		type = series[i].flags & ~CHART_STACKED;
		switch (type) {
			case CHART_LINE: painter.drawLine(series[i].color, series[i].values); break;
			case CHART_AREA: painter.drawArea(series[i].color, series[i].values); break;
			case CHART_BAR:  painter.drawBars(series[i].color, series[i].values, xlen-1, series[i].offset, this._barWidth); break;
			default: ;
		};
	}

	/*
	 * Draw axis (after the series since the anti aliasing of the lines may
	 * otherwise be drawn on top of the axis)
	 */
	painter.drawAxis();

};


/*----------------------------------------------------------------------------\
|                                 ChartSeries                                 |
|- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -|
| Internal class for representing a series.                                   |
\----------------------------------------------------------------------------*/

function ChartSeries(label, color, values, flags, offset) {
	this.label  = label;
	this.color  = color;
	this.values = values;
	this.flags  = flags;
	this.offset = offset;
}


/*----------------------------------------------------------------------------\
|                            AbstractChartPainter                             |
|- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -|
| Abstract base class defining the painter API. Can not be used directly.     |
\----------------------------------------------------------------------------*/

function AbstractChartPainter() {

};


AbstractChartPainter.prototype.calc = function(w, h, xlen, ymin, ymax, xgd, ygd) {
	this.range = ymax - ymin;
	this.xstep = w / (xlen - 1);
	this.xgrid = (xgd)?w / (xgd - 1):0;
	this.ygrid = (ygd)?h / (ygd - 1):0;
	this.ymin  = ymin;
	this.ymax  = ymax;
};


AbstractChartPainter.prototype.create = function(el) {};
AbstractChartPainter.prototype.init = function(xlen, ymin, ymax, xgd, ygd, bLabels) {};
AbstractChartPainter.prototype.drawLegend = function(series) {};
AbstractChartPainter.prototype.drawVerticalAxis = function(ygd, precision) {};
AbstractChartPainter.prototype.drawHorizontalAxis = function(xlen, labels, xgd, precision) {};
AbstractChartPainter.prototype.drawAxis = function() {};
AbstractChartPainter.prototype.drawBackground = function() {};
AbstractChartPainter.prototype.drawChart = function() {};
AbstractChartPainter.prototype.drawArea = function(color, values) {};
AbstractChartPainter.prototype.drawLine = function(color, values) {};
AbstractChartPainter.prototype.drawBars = function(color, values, xlen, xoffset, width) {};

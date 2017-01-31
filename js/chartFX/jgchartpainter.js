/*----------------------------------------------------------------------------\
|                                  Chart 1.0                                  |
|                       JavaScript Graphics Chart Painter                     |
|-----------------------------------------------------------------------------|
|                          Created by Emil A Eklund                           |
|                        (http://eae.net/contact/emil)                        |
|                           Modified by Ma Bingyao                            |
|                          (http://www.coolcode.cn)                           |
|-----------------------------------------------------------------------------|
| JavaScript Graphics implementation of the chart painter API.  jsGraphics is |
| used to  draw the chart,  html elements are used for  the legend  and  axis |
| labels as, at the time being.                                               |
|-----------------------------------------------------------------------------|
|                Copyright (c) 2006 Emil A Eklund & Ma Bingyao                |
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
| 2006-01-03 | Work started.                                                  |
| 2006-01-05 | Added legend and axis labels. Changed the painter api slightly |
|            | to allow two-stage initialization (required for ie/canvas) and |
|            | added legend/axis related methods. Also updated bar chart type |
|            | and added a few options, mostly related to bar charts.         |
| 2006-01-07 | Updated chart size calculations to take legend and axis labels |
|            | into consideration.  Split painter implementations to separate |
|            | files.                                                         |
| 2006-02-03 | Modified to use wz_jsgraphics instead of canvas by Ma Bingyao. |
|-----------------------------------------------------------------------------|
| Created 2006-01-03 | All changes are in the log above. | Updated 2006-02-03 |
\----------------------------------------------------------------------------*/

function JsGraphicsChartPainterFactory() {
	return new JsGraphicsChartPainter();
}


function JsGraphicsChartPainter() {
	this.base = AbstractChartPainter;
};


JsGraphicsChartPainter.prototype = new AbstractChartPainter;


JsGraphicsChartPainter.prototype.create = function(el) {
	while (el.firstChild) { el.removeChild(el.lastChild); }

	this.el = el;
	this.w = el.clientWidth;
	this.h = el.clientHeight;

	this.canvas = document.createElement('div');
	this.canvas.width  = this.w;
	this.canvas.height = this.h;
	this.canvas.style.width  = this.w + 'px';
	this.canvas.style.height = this.h + 'px';
	this.canvas.style.position = "relative";
	this.canvas.id = "canvas_" + el.id;
	this.canvas.onselectstart = function () { return false; };

	el.appendChild(this.canvas);
};


JsGraphicsChartPainter.prototype.init = function(xlen, ymin, ymax, xgd, ygd, bLegendLabels) {
	this.ctx = new jsGraphics(this.canvas.id);

	this.chartx = 0;
	this.chartw	= this.w;
	this.charth	= this.h;
	this.charty = 0;
	
	this.xlen = xlen;
	this.ymin = ymin;
	this.ymax = ymax;
	this.xgd  = xgd;
	this.ygd  = ygd;

	this.calc(this.chartw, this.charth, xlen, ymin, ymax, xgd, ygd);
};


JsGraphicsChartPainter.prototype.drawLegend = function(series) {
	var legend, list, item, label;

	legend = document.createElement('div');
	legend.className = 'legend';
	legend.style.position = 'absolute';
	list = document.createElement('ul');

	for (i = 0; i < series.length; i++) {
		item = document.createElement('li');
		item.style.color = series[i].color;
		label = document.createElement('span');
		label.appendChild(document.createTextNode(series[i].label));
		label.style.color = 'black';
		item.appendChild(label);
		list.appendChild(item);
	}
	legend.appendChild(list);
	this.el.appendChild(legend);
	legend.style.right = '0px';
	legend.style.top  = this.charty + (this.charth / 2) - (legend.offsetHeight / 2) + 'px';
	this.legend = legend;
	
	/* Recalculate chart width and position based on labels and legend */
	this.chartw	= this.w - (this.legend.offsetWidth + 5);
	
	this.calc(this.chartw, this.charth, this.xlen, this.ymin, this.ymax, this.xgd, this.ygd);
};


JsGraphicsChartPainter.prototype.drawVerticalAxis = function(ygd, precision) {
	var axis, item, step, y, ty, n, yoffset, value, multiplier, w, items, pos;

	/* Calculate step size and rounding precision */
	multiplier = Math.pow(10, precision);
	step       = this.range / (ygd - 1);

	/* Create container */
	axis = document.createElement('div');
	axis.style.position = 'absolute';
	axis.style.left  = '0px';
	axis.style.top   = '0px';
	axis.style.textAlign = 'right';
	this.el.appendChild(axis);

	/* Draw labels and points */
	this.ctx.setColor('black');
	w = 0;
	items = new Array();
	for (n = 0, i = this.ymax; (i > this.ymin) && (n < ygd - 1); i -= step, n++) {
		item = document.createElement('span');
		value = parseInt(i * multiplier) / multiplier;
		item.appendChild(document.createTextNode(value));
		axis.appendChild(item);
		items[items.length] = new Array(i, item);
		if (item.offsetWidth > w) { w = item.offsetWidth; }
	}

	/* Draw last label and point (lower left corner of chart) */
	item = document.createElement('span');
	item.appendChild(document.createTextNode(this.ymin));
	axis.appendChild(item);
	items[items.length] = new Array(this.ymin, item);
	if (item.offsetWidth > w) { w = item.offsetWidth; }
	
	/* Set width of container to width of widest label */
	axis.style.width = w + 'px';
	
	/* Recalculate chart width and position based on labels and legend */
	this.chartx = w + 5;
	this.charty = item.offsetHeight / 2;
	this.charth = this.h - ((item.offsetHeight * 1.5) + 5);
	this.chartw	= this.w - (((this.legend)?this.legend.offsetWidth:0) + w + 10);
	this.calc(this.chartw, this.charth, this.xlen, this.ymin, this.ymax, this.xgd, this.ygd);
	
	/* Position labels on the axis */
	n          = this.range / this.charth;
	yoffset    = (this.ymin / n);
	for (i = 0; i < items.length; i++) {
		item = items[i][1];
		pos = items[i][0];
		if (pos == this.ymin) { y = this.charty + this.charth - 1; }
		else { y = this.charty + (this.charth - (pos / n) + yoffset); }
		this.ctx.drawLine(this.chartx - 5, y, this.chartx, y);
		ty = y - (item.offsetHeight/2);
		item.style.position = 'absolute';
		item.style.right = '0px';
		item.style.top   = ty + 'px';
}	};

JsGraphicsChartPainter.prototype.drawHorizontalAxis = function(xlen, labels, xgd, precision) {
	var axis, item, step, x, tx, y1, y2, n, multiplier;

	/* Calculate offset, step size and rounding precision */
	multiplier = Math.pow(10, precision);
	n          = this.chartw / (xgd - 1);

	/* Create container */
	axis = document.createElement('div');
	axis.style.position = 'absolute';
	axis.style.left   = '0px';
	axis.style.top    = (this.charty + this.charth + 5) + 'px';
	axis.style.width  = this.w + 'px';
	this.el.appendChild(axis);

	/* Draw labels and points */
	this.ctx.setColor('black');
	y1 = this.charty + this.charth;
	y2 = this.charty + this.charth + 5;
	for (i = 0; i < xgd; i++) {
		item = document.createElement('span');
		item.appendChild(document.createTextNode(labels[i]));
		axis.appendChild(item);
		x = this.chartx + (n * i);
		tx = x - (item.offsetWidth/2)
		item.style.position = 'absolute';
		item.style.left = tx + 'px';
		item.style.top  = '0px';
		this.ctx.drawLine(x, y1, x, y2);
}	};


JsGraphicsChartPainter.prototype.drawAxis = function() {
    var x1, x2, y1, y2;
	this.ctx.setColor('black');
	x1 = this.chartx;
	x2 = this.chartx + this.chartw + 1;
	y1 = this.charty;
	y2 = this.charty + this.charth - 1;
	this.ctx.drawLine(x1, y1, x1, y2);
	this.ctx.drawLine(x1, y2, x2, y2);
	this.ctx.paint();
};


JsGraphicsChartPainter.prototype.drawBackground = function() {
	this.ctx.setColor('white');
	this.ctx.fillRect(0, 0, this.w, this.h);
};


JsGraphicsChartPainter.prototype.drawChart = function() {
	this.ctx.setColor('silver');
	if (this.xgrid) {
		for (i = this.xgrid; i < this.chartw; i += this.xgrid) {
			this.ctx.drawLine(this.chartx + i, this.charty, this.chartx + i, this.charty + this.charth - 1);
	}	}
	if (this.ygrid) {
		for (i = this.charth - this.ygrid; i > 0; i -= this.ygrid) {
			this.ctx.drawLine(this.chartx + 1, this.charty + i, this.chartx + this.chartw + 1, this.charty + i);
}	}	};


JsGraphicsChartPainter.prototype.drawArea = function(color, values) {
	var i, len, x, y, n, yoffset;
	var XPoints = new Array();
	var YPoints = new Array();

	/* Determine distance between points and offset */
	n = this.range / this.charth;
	yoffset = (this.ymin / n);

	len = values.length;
	if (len) {
		this.ctx.setColor(color);

		x = this.chartx + 1;
		y = this.charty + this.charth - 1;
		XPoints[XPoints.length] = x;
		YPoints[YPoints.length] = y;

		y = this.charty + this.charth - (values[0] / n) + yoffset;
		XPoints[XPoints.length] = x;
		YPoints[YPoints.length] = y;

		for (i = 1; i < len; i++) {
			y = this.charty + this.charth - (values[i] / n) + yoffset;
			x += this.xstep;
			XPoints[XPoints.length] = x;
			YPoints[YPoints.length] = y;
		}

		XPoints[XPoints.length] = x;
		YPoints[YPoints.length] = this.charty + this.charth - 1;
		
		this.ctx.fillPolygon(XPoints, YPoints);
}	};


JsGraphicsChartPainter.prototype.drawLine = function(color, values) {
	var i, len, x1, y1, x2, y2, n, yoffset;

	n = this.range / this.charth;
	yoffset = (this.ymin / n);

	len = values.length;
	if (len) {
		this.ctx.setStroke(1);
		this.ctx.setColor(color);
		x1 = this.chartx + 1;
		y1 = this.charty + this.charth - (values[0] / n) + yoffset;

		for (i = 1; i < len; i++) {
			y2 = this.charty + this.charth - (values[i] / n) + yoffset;
			x2 = x1 + this.xstep;
			this.ctx.drawLine(x1, y1, x2, y2);
			x1 = x2;
			y1 = y2;
		}

}	};


JsGraphicsChartPainter.prototype.drawBars = function(color, values, xlen, xoffset, width) {
	var i, len, x, y, n, yoffset;

	n = this.range / this.charth;
	yoffset = (this.ymin / n);

	len = values.length;
	if (len > xlen) { len = xlen; }
	if (len) {
		this.ctx.setColor(color);
		x = this.chartx + xoffset + 1;
		for (i = 0; i < len; i++) {
			y = this.charty + this.charth - (values[i] / n) + yoffset;
			this.ctx.fillRect(x, y, width, this.charty + this.charth - y);
			x += this.xstep;
}	}	};

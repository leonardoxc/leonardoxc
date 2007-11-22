/*
Script: cchart.js
        Cursor extension for chart.

License: GNU General Public License

This file is part of VisuGps

VisuGps is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

VisuGps is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with VisuGps; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

Copyright (c) 2007 Victor Berchet, <http://www.victorb.fr>

Credits:
        - This script extends a modified version of chart by WebFX.
          <http://webfx.eae.net/dhtml/chart/chart.html>

*/

/*
Class: CChart
        Extend the Chart class <http://webfx.eae.net/dhtml/chart/chart.html>
        by ading a moving cursor
*/
var CChart = Chart.extend({
    options: {
        cursor : true,
        onMouseMove: Class.empty,
        onMouseDown: Class.empty,
        onMouseWheel: Class.empty
    },
    /*
    Property: initialize
            Class constructor.

    Arguments:
            div - Chart container
            options - an object representing CChart options. See Options below.

    Options:
            cursor - true to show the cursor
            onMouseMove - event fired on mouse move
            onMouseDown - event fired on left click
            onMouseWheel - event fire on mouse wheel change 
    */           
    initialize: function(div, options) {
        this.setOptions(options);
        this.parent(div);
        this.chartDiv = $(div);
        if (this.options.cursor) {
            this.cursorDiv = new Element('div', {'styles' : { 'position' : 'absolute',
                                                              'border-left' : 'dashed 1px #508',
                                                              'width' : 0,
                                                              'z-index' : 50,
                                                              'visibility' : 'hidden'}
                                                }
                                        ).injectInside($(div))
                                         .addEvents({'mousedown' : this._down.bindWithEvent(this),
                                                     'mousewheel' : this._wheel.bindWithEvent(this)});
        }
        this.position = 0;
        // Add events to both divs
        $(div).addEvents({'mousemove' : this._move.bindWithEvent(this),
                          'mousedown' : this._down.bindWithEvent(this),
                          'mousewheel' : this._wheel.bindWithEvent(this)});
    },
    /*
    Property: draw
            Draw the chart
    */        
    draw: function() {
        this.parent();
        if (this.options.cursor) {
            var dim = this.getCoordinates();
            this.cursorDiv.setStyles({'top' : dim.top,
                                      'height': dim.height});
        }
    },
    /*
    Property: setCursor
            Set the cursor position
            
    Arguments:
            pos - position (0...1000)            
    */        
    setCursor: function(pos) {
        if (this.options.cursor) {
            var dim = this.getCoordinates();
            var left = dim.left + this.chartDiv.getLeft();
            var x = (pos * dim.width / 1000) + left;
            this.cursorDiv.setStyle('left', x);
            this.showCursor();
        }
    },
    /*
    Property: showCursor
            Set cursor visibity.
            
    Arguments:  
            visible - true to show to cursor (default)                       
    */    
    showCursor: function(visible) {
        if (this.options.cursor) {
            visible = $pick(visible, true);
            this.cursorDiv.setStyle('visibility', visible?'visible':'hidden');
        }
    },
    /*
    Property: clean
            Remove events to help with memory leaks           
    */     
    clean: function() {
        this.showCursor(false);
        this.chartDiv.removeEvents();
        if (this.options.cursor) this.cursorDiv.removeEvents();
    },    
    /*
    Property: _move (INTERNAL)
            Set the cursor to the mouse position and fire the 'onMouseMove' event           
    
    Arguments:
            event - event
    */    
    _move: function(event) {
        event.stop();
        var x = event.page.x;
        var dim = this.getCoordinates();
        var left = dim.left + this.chartDiv.getLeft();
        x = x < left?left:x;
        x = x > (left + dim.width)?left + dim.width:x;
        this.position = (1000 * (x - left) / dim.width).toInt();
        this.setCursor(this.position);
        this.fireEvent('onMouseMove', this.position);
    },
    /*
    Property: _down (INTERNAL)
            Fire the 'onMouseDown' event
    */
    _down: function(event) {
        this.fireEvent('onMouseDown', this.position);
    },
    /*
    Property: _wheel (INTERNAL)
            Fire the 'onMouseWheel' event
    */
    _wheel: function(event) {
        this.fireEvent('onMouseWheel', [this.position, event.wheel]);
    }
});

CChart.implement(new Events);

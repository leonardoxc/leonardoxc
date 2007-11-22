/*
Script: radio.js
        Radio button extension for Mootools.

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

*/

/*
Class: RadioBtn
        Provide radio button for MooTools
*/
var RadioBtn = new Class({
    options: {
        onSelect: Class.empty,
        classSelect: "btn-selected",
        initBtn: 0
    },
    /*
    Property: initialize
            Class constructor.

    Arguments:
            btns - Button list
            options - an object representing RadioBtn options. See Options below.

    Options:
            onSelect - function to call when selection changes
            classSelect - class to be added to the button when selected
            initBtn - index of the button to be initially selected 
    */        
    initialize: function(btns, options) {
        this.setOptions(options);
        this.selected = null;
        this.btns = btns.map(function(item, index) {
                                 var btn = $(item);
                                 btn.addEvent('click', this._select.bind(this, index));
                                 return btn;
                             }.bind(this));
        this._select(this.options.initBtn);
    },
    /*
    Property: _select (INTERNAL)
            Set buttons styles and fire the 'onSelect' event when a 
            button gets selected.

    Arguments:
            index - index of the button that is clicked
    */  
    _select: function(index) {
        if (index === this.selected) return;
        if (this.selected !== null) {
            // Remove the 'selected' class from the previously selected button
            this.btns[this.selected].removeClass(this.options.classSelect);
        };
        if (index !== null) {
            // Add the 'selected' class to the active button
            this.selected = index;
            this.btns[index].addClass(this.options.classSelect);
            // Fire the 'onSelect' event
            this.fireEvent('onSelect', [index, this.btns[index].getProperty('id')]);
        }
    }
});

RadioBtn.implement(new Events, new Options);

/*
Class: SliderProgress
    Creates a slider. Returns the value.

Arguments:
    element - slider container
    options - see Options below

Options:
    mode - either 'horizontal' or 'vertical'. defaults to horizontal.
    steps - the number of steps for your slider.
    color - bar color.
    opacity - bar opacity.
    border - slider border width.

Events:
    onChange - a function to fire when the value changes.
    onComplete - a function to fire when the value changes end.
*/

var SliderProgress = new Class({

    options: {
        onChange: Class.empty,
        onComplete: Class.empty,
        mode: 'horizontal',
        steps: 100,
        color: '#f00',
        border: 1,
        opacity: 0.6
    },

    initialize: function(el, options){
        this.setOptions(options);
        var opt = this.options;
        this.element = $(el);
        opt.border?this.element.setStyle('border-width', opt.border):opt.boder = 0;
        this.capture = false;
        this._mouseMoveWrapper = this._mouseMove.bindWithEvent(this);
        this._updateDim();
        switch(opt.mode){
            case 'horizontal':
                this.valStyle = 'width';
                this.valRef = 'left';
                this.valMod = 'x';
                this.max = this.dim.width;
                break;
            case 'vertical':
                this.valStyle = 'height';
                this.valRef = 'top';
                this.valMod = 'y';
                this.max = this.dim.height;
                break;
        }

        this.bar = new Element('div', {'styles' : {'height' : this.dim.height,
                                                   'width' : this.dim.width,
                                                   'float' : 'left',
                                                   'background' : opt.color,
                                                   'opacity' : opt.opacity}
                                      }).injectInside(this.element);

        this.value = 0;

        this.element.addEvents({'mouseup' : this._mouseUp.bindWithEvent(this),
                                'mouseleave' : this._mouseUp.bindWithEvent(this),
                                'mousedown' : this._mouseDown.bindWithEvent(this)});

        if (opt.initialize) opt.initialize.call(this);
    },
    /*
    Property: set
        The slider will get the step you pass.

    Arguments:
        step - one integer
    */
    set: function(value){
        this._checkValue(value);
        this._update(this._toPosition(this.value));
        return this;
    },

    _mouseDown: function(event){
        this._startCapture();
        this._updateDim();
        this._update(event.page[this.valMod] - this.dim[this.valRef]);
    },

    _mouseUp: function(event){
        if (!this.capture) {return;}
        this._endCapture();
        var position = event.page[this.valMod] - this.dim[this.valRef];
        this._update(position);
        var value = this._toStep(position);
        this._change('onChange', value);
        this._change('onComplete', value);
    },

    _mouseMove: function(event){
        var position = event.page[this.valMod] - this.dim[this.valRef];
        this._update(position);
        this._checkValue(this._toStep(position));
    },

    _checkValue: function(value) {
        if (this.value != value){
            this.value = value;
            this._change('onChange', value);
        }
    },

    _toStep: function(position){
        return Math.round(position / this.dim[this.valStyle] * this.options.steps);
    },

    _toPosition: function(value){
        return this.dim[this.valStyle] * value / this.options.steps;
    },

    _update : function(pos){
        this.bar.setStyle(this.valStyle, pos.limit(0, this.max));
    },

    _change : function(event, value) {
        this.fireEvent(event, value.limit(0, this.options.steps))
    },

    _startCapture : function() {
        this.element.addEvent('mousemove', this._mouseMoveWrapper);
        this.capture = true;
    },

    _endCapture : function() {
        this.element.removeEvent('mousemove', this._mouseMoveWrapper);
        this.capture = false;
    },

    _updateDim : function() {
        this.dim = this.element.getCoordinates();
        this.dim.width -= 2 * this.options.border;
        this.dim.height -= 2 * this.options.border;
    }

});

SliderProgress.implement(new Events, new Options);

/*
TIPSTER v3.1 RC (c) 2001-2006 Angus Turnbull, http://www.twinhelix.com
Altering this notice or redistributing this file is prohibited.
*/
// This is the full, commented script file, to use for reference purposes or if you feel
// like tweaking anything. I used the "CodeTrimmer" utility availble from my site
// (under 'Miscellaneous' scripts) to trim the comments out of this JS file.

// *** COMMON CROSS-BROWSER COMPATIBILITY CODE ***

// This is taken from the "Modular Layer API" available on my site.
// See that for the readme if you are extending this part of the script.

var isDOM=document.getElementById?1:0,
 isIE=document.all?1:0,
 isNS4=navigator.appName=='Netscape'&&!isDOM?1:0,
 isOp=self.opera?1:0,
 isDyn=isDOM||isIE||isNS4;

function getRef(i, p)
{
 p=!p?document:p.navigator?p.document:p;
 return isIE ? p.all[i] :
  isDOM ? (p.getElementById?p:p.ownerDocument).getElementById(i) :
  isNS4 ? p.layers[i] : null;
};

function getSty(i, p)
{
 var r=getRef(i, p);
 return r?isNS4?r:r.style:null;
};

if (!self.LayerObj) var LayerObj = new Function('i', 'p',
 'this.ref=getRef(i, p); this.sty=getSty(i, p); return this');
function getLyr(i, p) { return new LayerObj(i, p) };

function LyrFn(n, f)
{
 LayerObj.prototype[n] = new Function('var a=arguments,p=a[0],px=isNS4||isOp?0:"px"; ' +
  'with (this) { '+f+' }');
};
LyrFn('x','if (!isNaN(p)) sty.left=p+px; else return parseInt(sty.left)');
LyrFn('y','if (!isNaN(p)) sty.top=p+px; else return parseInt(sty.top)');
LyrFn('w','if (p) (isNS4?sty.clip:sty).width=p+px; ' +
 'else return (isNS4?ref.document.width:ref.offsetWidth)');
LyrFn('h','if (p) (isNS4?sty.clip:sty).height=p+px; ' +
 'else return (isNS4?ref.document.height:ref.offsetHeight)');
LyrFn('vis','sty.visibility=p');
LyrFn('write','if (isNS4) with (ref.document){write(p);close()} else ref.innerHTML=p');
LyrFn('alpha','var f=ref.filters,d=(p==null),o=d?"inherit":p/100; if (f) {' +
 'if (!d&&sty.filter.indexOf("alpha")==-1) sty.filter+=" alpha(opacity="+p+")"; ' +
 'else if (f.length&&f.alpha) with(f.alpha){if(d)enabled=false;else{opacity=p;enabled=true}} }' +
 'else if (isDOM)sty.opacity=sty.MozOpacity=o');

if (!self.page) var page = { win:self, minW:0, minH:0, MS:isIE&&!isOp };

page.db = function(p) { with (this.win.document) return (isDOM?documentElement[p]:0)||body[p]||0 };

page.winW=function() { with (this) return Math.max(minW, MS ? db('clientWidth') : win.innerWidth) };
page.winH=function() { with (this) return Math.max(minH, MS ? db('clientHeight') : win.innerHeight) };

page.scrollX=function() { with (this) return MS ? db('scrollLeft') : win.pageXOffset };
page.scrollY=function() { with (this) return MS ? db('scrollTop') : win.pageYOffset };



// *** MAIN TIP OBJECT CLASS ***

function TipObj(myName)
{
 // Holds the properties the functions above use.
 this.myName = myName;
 this.template = '';
 this.tips = new Array();

 this.parentObj = null;
 this.div = null;
 this.actTip = '';
 this.showTip = false;
 this.xPos = this.yPos = this.sX = this.sY = this.mX = this.mY = 0;

 this.trackTimer = this.fadeTimer = 0;
 this.alpha = 0;
 this.doFades = true;
 this.minAlpha = 0;
 this.maxAlpha = 100;
 this.fadeInSpeed = 20;
 this.fadeOutSpeed = 20;
 this.tipStick = 1;
 this.showDelay = 50;
 this.hideDelay = 250;
 this.IESelectBoxFix = 0;
 

 // Add to list of tip objects.
 TipObj.list[myName] = this;
};

// List of created tip objects.
TipObj.list = {};

// A quick reference to speed things up.
var ToPt = TipObj.prototype;


// *** TIP MOUSE HANDLER FUNCTIONS ***

// Called onmousemove by track() and also by show() to reposition the active tip.
// Passing 'true' forces a complete reposition regardless of tip type.
ToPt.position = function(forcePos) { with (this)
{
 // Can't position a tip if there isn't one available...
 if (!actTip) return;

 // Pull the window sizes from the page object.
 // In NS we size down the window a little as it includes scrollbars.
 var wW = page.winW(), wH = page.winH();
 if (!isIE||isOp) { wW-=16; wH-=16 }

 // Pull the compulsory information out of the tip array.
 var t=tips[actTip], tipX=eval(t[0]), tipY=eval(t[1]), tipW=div.w(), tipH=div.h(), adjY = 1;


 // manolis hack!
 // set mx and my to the positioning element x and y values
	var hackActive=false;
	if ( typeof(t[2])!='number') hackActive=true;	

	if (hackActive)
	{
		var posEl=getRef(t[2]);
		mX=0;
		mY=0;		
		posArr=MWJ_getPosition(posEl);
		mX=posArr[0];
		mY=posArr[1];
	}


 // Add mouse position onto relatively positioned tips.
 if (typeof(t[0])=='number') tipX += mX;
 if (typeof(t[1])=='number') tipY += mY;

 // Check the tip is not within 5px of the screen boundaries.
/*
 if (tipX + tipW + 5 > sX + wW) tipX = sX + wW - tipW - 5;
 if (tipY + tipH + 5 > sY + wH) tipY = sY + wH - tipH - 5;
 if (tipX < sX + 5) tipX = sX + 5;
 if (tipY < sY + 5) tipY = sY + 5;
*/

 // If the tip is currently invisible, show at the calculated position.
 // Also do this if we're passed the 'forcePos' parameter.
 if ((!showTip && (doFades ? !alpha : true)) || forcePos)
 {
  xPos = tipX;
  yPos = tipY;
 }

 // Otherwise move the tip towards the calculated position by the stickiness factor.
 // Low stickinesses will result in slower catchup times.
if (!hackActive) {
	xPos += (tipX - xPos) * tipStick;
	yPos += (tipY - yPos) * tipStick;
}

 div.x(xPos);
 div.y(yPos);
 return;
}};


// Called by the show() function when a new tip is being shown.
ToPt.replaceContent = function(tipN) { with (this)
{
 // Remember this tip number as active, for the other functions.
 actTip = tipN;

 // Set tip's onmouseover and onmouseout handlers for non-floating tips.
 if (tipStick == parseInt(tipStick))
 {
  var rE = '';
  if (isNS4)
  {
   div.ref.captureEvents(Event.MOUSEOVER | Event.MOUSEOUT);
   rE = '; return this.routeEvent(evt)';
  }
  // Remember to pass parent reference if needed, to maintain nesting rules.
  div.ref.onmouseover = new Function('evt', myName+'.show("' + tipN + '"' +
   (parentObj ? ','+parentObj.myName : '') + ')' + rE);
  div.ref.onmouseout = new Function('evt', myName + '.hide()' + rE);
 }

 // Go through and replace %0% with the array's 0 index, %1% with tips[tipN][1] etc...
 
 // MANOLIS
 // parameter 0 is the positiion emelemnt name (liek p_1 p_2 etc)
 
 var str = template;
 for (var i = 0; i < tips[tipN].length; i++)
  str = str.replace(new RegExp('%'+i+'%', 'g'), tips[tipN][i]);

 // Optional IE5.5+ SELECT box fix. Ouch. This is really dirty. IE does deserve it, though...
 if (window.createPopup && IESelectBoxFix)
 {
  // In case you're wondering, expression() is a great IE hack that I'm using to auto-set the
  // IFRAME's height equal to its parent. And the content is in there twice -- once to set the
  // div's dimensions, and again to actually show it within a filter.
  var filt = 'filter: progid:DXImageTransform.Microsoft.Alpha(opacity=';
  str += '<iframe src="about:blank" style="position: absolute; left: 0px; top: 0px; ' +
   'height: expression(' + myName + '.div.h()); z-index: 1; border: none; ' + filt + '0)"></iframe>' +
   '<div style="position: absolute; left: 0px; top: 0px; z-index: 2; ' + filt + '100)">' +
   str + '</div>';
 }

 // Write the proper content... the last <br> strangely helps IE5/Mac...?
 // IE4 requires a small width set otherwise tip divs expand to full body size.
 // We've hardcoded that inline, for decent browsers reset it to 'auto' like we should.
 // However 'decent' does not include Opera 7, which is quite buggy in this regard.
 if (isDOM&&!isOp) div.sty.width = 'auto';
 div.write(str + (isIE&&!isOp&&!window.external ? '<small><br /></small>' : ''));

 // Place it somewhere onscreen - pass true to force a complete reposition.
 position(true);
}};


// Called inline to show tips and cancel pending hides, passed a tip name (compulsory)
// and an optional parent tip object reference for nesting tips.
ToPt.show = function(tipN, par) { with (this)
{
 if (!isDyn) return;

 // Clear any pending hides.
 clearTimeout(fadeTimer);

 // If this tip is nested, record (or reset) the parent and call its show() function.
 // This will recurse back up the tip tree until it reaches the top.
 parentObj = par;
 if (par) par.show(par.actTip, par.parentObj);

 // My layer object we use.
 if (!div) div = getLyr(myName + 'Layer');
 if (!div) return;

 // For non-integer stickiness values, we need to use setInterval to animate the tip,
 // if it's 0 or 1 we can just use onmousemove to position it.
 clearInterval(trackTimer);
 if (tipStick != parseInt(tipStick)) trackTimer = setInterval(myName+'.position()', 50);

 // An executable string, to set the tip visibility as true, write new content if needed,
 // and then call the fade() function (which reads the showTip value).
 var showStr = 'with ('+myName+') { showTip = true; ' +
  (actTip!=tipN ? 'replaceContent("'+tipN+'"); ' : '') + 'fade() }';

 // Call that after a short delay or immediately.
 // If we have an active tip, just do the content swap now.
 if (showDelay && !actTip) fadeTimer = setTimeout(showStr, showDelay);
 else eval(showStr);
}};


// Inline tip creation support. Takes a tip name and then tips[] array parameters.
ToPt.newTip = function(tName) { with (this)
{
 // Create a new array in the tip object...
 if (!tips[tName]) tips[tName] = [];
 // ...and then sling the argument data into it, and show the tip.
 for (var i = 1; i < arguments.length; i++) tips[tName][i-1] = arguments[i];
 show(tName);
 return;
}};


// Called onmouseout inline to hide the active tip.
ToPt.hide = function() { with (this)
{
 // Cancel any pending timer activity.
 clearTimeout(fadeTimer);

 // We've got to be a DHTML-capable browser that has a tip currently active.
 if (!isDyn || !actTip || !div) return;

 // If the mouse position is within the tip boundaries, we know NS4 is telling us stories
 // as often it makes hide events unaccompanied by overs or in a weird order.
 // Only applies to static tips that we want the user to mouseover...
 if (isNS4 && tipStick==0 && xPos<=mX && mX<=xPos+div.w() && yPos<=mY && mY<=yPos+div.h())
  return;

 // If this tip is nested, call the 'hide' function of its parent too.
 // This will recurse the hide event up the tip hierarchy.
 with (tips[actTip]) if (parentObj) parentObj.hide();

 // Fade out after a delay so another mouseover can cancel this fade.
 // This allows the user to mouseover a static tip before its hides.
 fadeTimer = setTimeout('with (' + myName + ') { showTip=false; fade() }', hideDelay);
 return;
}};


// Called recursively to manage opacity fading and visibility settings.
ToPt.fade = function() { with (this)
{
 // Clear to stop existing fades.
 clearTimeout(fadeTimer);

 // Show it and optionally increment alpha from minAlpha to maxAlpha or back again.
 if (showTip)
 {
  div.vis('visible');
  if (doFades)
  {
   alpha += fadeInSpeed;
   if (alpha > maxAlpha) alpha = maxAlpha;
   div.alpha(alpha);
   // Call this function again shortly, fading tip in further.
   if (alpha < maxAlpha) fadeTimer = setTimeout(myName + '.fade()', 75);
  }
 }
 else
 {
  // Similar to before but counting down and hiding at the end.
  if (doFades && alpha > minAlpha)
  {
   alpha -= fadeOutSpeed;
   if (alpha < minAlpha) alpha = minAlpha;
   div.alpha(alpha);
   fadeTimer = setTimeout(myName + '.fade()', 75);
   return;
  }
  div.vis('hidden');
  // Clear the active tip flag so it is repositioned next time.
  actTip = '';
  // Stop any sticky-tip tracking if it's invisible.
  clearInterval(trackTimer);
 }
}};


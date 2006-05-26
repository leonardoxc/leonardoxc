/******************************************
    Generic DHTML do everything script
By Mark 'Tarquin' Wilton-Jones 28-29/9/2002
*******************************************

Please see http://www.howtocreate.co.uk/jslibs/ for details and a demo of this script
Please see http://www.howtocreate.co.uk/jslibs/termsOfUse.html for terms of use

To use:

Insert this into the head of your page:
	<script src="PATH_TO_SCRIPT/dhtmlapi.js" type="text/javascript" language="javascript1.2"></script>

To reference any frame, iframe, form, input, image or anchor (but not link) by its name, or
positioned element by its id in the current document - it can optionally scan through any frameset
structure to find it (searching in frames that have not loaded will cause an error):
theObject = MWJ_findObj( nameOrIdOfObject[, optional referenceToFrameToStartSearchingIn] );

To change the visibility of a positioned element - true for visible, false for hidden:
MWJ_changeVisibility( idOfPositionedElement, true/false[, optional referenceToFrameToStartSearchingIn] );

To change the position of a positioned element - true for relative to the document, false for
relative to its current position:
MWJ_changePosition( idOfPositionedElement, leftOffset, topOffset, true/false[, optional referenceToFrameToStartSearchingIn] );

To change the z-index of a positioned element:
MWJ_changeZIndex( idOfPositionedElement, z-index[, optional referenceToFrameToStartSearchingIn] );

To change the background colour of a positioned element:
MWJ_changeBackground( idOfPositionedElement, colour[, optional referenceToFrameToStartSearchingIn] );
You MUST have the background colour set with the inline background-color style, to prevent Gecko
engine and Opera 5 bugs.

To change the display style of any element, if it is supported:
MWJ_changeDisplay( nameOrIdOfElement, '' or 'block' or 'inline' or 'none'[, optional referenceToFrameToStartSearchingIn] );
Note: IE 4 does not understand 'inline' , so '' should be used. iCab does not understand '', so 'block' should be used.

To change the size of a positioned element:
MWJ_changeSize( idOfPositionedElement, width, height[, optional referenceToFrameToStartSearchingIn] )

To change the clip of an absolutely positioned element:
MWJ_changeClip( idOfPositionedElement, leftClip, topClip, bottomClip, rightClip[, optional referenceToFrameToStartSearchingIn] );

To change the contents of a positioned element - also rewrites iframe content if that is
provided as an alternative:
MWJ_changeContents( idOfPositionedElement, newContents[, optional nameOfIframe[, optional referenceToFrame]] )

To create a new positioned element (after the document has loaded) as a child of the document:
MWJ_createNew( null, width, newID[, optional referenceToWindowOrFrame] )
Or as a child of an existing positioned element:
MWJ_createNew( idOfPositionedElement, width, newID[, optional referenceToFrameToStartSearchingIn] )
If the browser can create it, the element will be hidden, will have no contents and may be positioned anywhere.
Use the other functions provided to write the contents and style the element.

To get the value of a particular style for a positioned element ('visibility', 'left', 'top', 'zIndex',
'background', 'display', 'size' and 'clip' permitted):
MWJ_getStyle( idOfPositionedElement, style[, optional referenceToFrame] )
Or to get the background colour for the document:
MWJ_getStyle( 'document'[, optional null, referenceToFrame] )
In each case, the style must have been set using inline style syntax or with script. With Opera 6, to get the
background colour for the document before it is set with script, some arbitrary colour style must be set for
the HTML tag in a standard stylesheet, even if that colour is not used by the body. If not set in either
way, or if the browser does not support it, the function assumes defaults. If background colour is set using
the 'background' style, some browsers may return more information than just the colour. Some browsers may
return the hex colour code, not the colour name. Measurements return integers, and assume pixels, even if
other units were used. 'visibility' returns true/false for visible/hidden. 'clip' returns an object with top,
bottom, right, and left properties. 'size' returns an array [width,height].
This line toggles the display style between '' (default) and 'none':
MWJ_changeDisplay( 'mySpan', MWJ_getStyle( 'mySpan', 'display' ) ? '' : 'none' );
This line toggles the visbility style between 'visible' and 'hidden':
MWJ_changeDisplay( 'mySpan', MWJ_getStyle( 'mySpan', 'visibility' ) ? false : true );

To change the background colour of the document, if supported:
MWJ_changeBody( colour[, optional referenceToFrame] );

To get the position of a link (or anchor only if the name attribute is set):
arrayXY = MWJ_getPosition( referenceToTheLinkOrAnchor );

To get the width and height of any window or frame (defaults to the current window):
arrayWidthHeight = MWJ_getSize([optional referenceToWindowOrFrame]);

To get the scrolling offset of any window or frame (defaults to the current window):
arrayXscrollYscroll = MWJ_getSize([optional referenceToWindowOrFrame]);

To monitor the position of the mouse:
MWJ_monitorMouse([optional referenceToYourOwnHandlerFunction]);
From then on, the mouse position will be constantly stored as [xPosition,yPosition] in window.MWJ_getMouse
If you specify a handler function, that will also be executed when the mouse moves, but will not be
passed any arguments. To cancel this mousemove detection, use:
document.onmousemove = null; if( document.releaseEvents ) { document.releaseEvents( Event.MOUSEMOVE ); }

To find the position of the mouse after a mouse event (not click):
arrayXposYpos = MWJ_getMouseCoords(firstArgumentPassedToEventHandlerFunction);
For example onmouseover="mouseCoords = MWJ_getMouseCoords(arguments[0]);"

To get any element that can detect key events to monitor what key was used to
keypress/keydown/keyup/click it (nameOfEvent is in the format 'mousedown'):
MWJ_monitorKey( referenceToObject, nameOfEvent, referenceToYourOwnHandlerFunction );
Your handler function will be passed four arguments; the first will be the normal argument passed to
handler functions in Netscape browsers, the second will be the key code number, the third will be
the keycode->key mapping provided by String.fromCharCode(). The 'this' keyword will not be available
in your handler function so the forth argument will be the element that triggered the event.

To get any element that can detect mouse events to monitor what mouse button was used
to dblclick/mousedown/mouseup it (nameOfEvent is in the format 'mousedown'):
MWJ_monitorButton( referenceToObject, nameOfEvent, referenceToYourOwnHandlerFunction );
Your handler function will be passed four arguments; the first will be the normal argument passed to
handler functions in Netscape browsers, the second will be the button code number, the third will be
either 'left' or 'right' depending on which button was used. The 'this' keyword will not be available
in your handler function so the forth argument will be the element that triggered the event.
______________________________________________________________________________________________________*/

function MWJ_findObj( oName, oFrame, oDoc ) {
	if( !oDoc ) { if( oFrame ) { oDoc = oFrame.document; } else { oDoc = window.document; } }
	if( oDoc[oName] ) { return oDoc[oName]; } if( oDoc.all && oDoc.all[oName] ) { return oDoc.all[oName]; }
	if( oDoc.getElementById && oDoc.getElementById(oName) ) { return oDoc.getElementById(oName); }
	for( var x = 0; x < oDoc.forms.length; x++ ) { if( oDoc.forms[x][oName] ) { return oDoc.forms[x][oName]; } }
	for( var x = 0; x < oDoc.anchors.length; x++ ) { if( oDoc.anchors[x].name == oName ) { return oDoc.anchors[x]; } }
	for( var x = 0; document.layers && x < oDoc.layers.length; x++ ) {
		var theOb = MWJ_findObj( oName, null, oDoc.layers[x].document ); if( theOb ) { return theOb; } }
	if( !oFrame && window[oName] ) { return window[oName]; } if( oFrame && oFrame[oName] ) { return oFrame[oName]; }
	for( var x = 0; oFrame && oFrame.frames && x < oFrame.frames.length; x++ ) {
		var theOb = MWJ_findObj( oName, oFrame.frames[x], oFrame.frames[x].document ); if( theOb ) { return theOb; } }
	return null;
}
function MWJ_changeVisibility( oName, oVis, oFrame ) {
	var theDiv = MWJ_findObj( oName, oFrame ); if( !theDiv ) { return; }
	if( theDiv.style ) { theDiv.style.visibility = oVis ? 'visible' : 'hidden'; } else { theDiv.visibility = oVis ? 'show' : 'hide'; }
}
function MWJ_changePosition( oName, oXPos, oYPos, oRel, oFrame ) {
	var theDiv = MWJ_findObj( oName, oFrame ); if( !theDiv ) { return; }
	if( theDiv.style ) { theDiv = theDiv.style; } var oPix = document.childNodes ? 'px' : 0;
	if( typeof( oXPos ) == 'number' ) { theDiv.left = ( oXPos + ( oRel ? 0 : parseInt( theDiv.left ) ) ) + oPix; }
	if( typeof( oYPos ) == 'number' ) { theDiv.top = ( oYPos + ( oRel ? 0 : parseInt( theDiv.top ) ) ) + oPix; }
}
function MWJ_changeZIndex( oName, ozInd, oFrame ) {
	var theDiv = MWJ_findObj( oName, oFrame ); if( !theDiv ) { return; }
	if( theDiv.style ) { theDiv = theDiv.style; } theDiv.zIndex = ozInd;
}
function MWJ_changeBackground( oName, oColour, oFrame ) {
	var theDiv = MWJ_findObj( oName, oFrame ); if( !theDiv ) { return; }
	if( theDiv.style ) { theDiv = theDiv.style; } if( typeof( theDiv.bgColor ) != 'undefined' ) {
		theDiv.bgColor = oColour; } else if( theDiv.backgroundColor ) { theDiv.backgroundColor = oColour; }
	else { theDiv.background = oColour; }
}
function MWJ_changeDisplay( oName, oDisp, oFrame ) {
	var theDiv = MWJ_findObj( oName, oFrame ); if( !theDiv ) { return; }
	if( theDiv.style ) { theDiv = theDiv.style; } if( typeof( oDisp ) == 'string' ) { oDisp = oDisp.toLowerCase(); }
	theDiv.display = ( oDisp == 'none' ) ? 'none' : ( oDisp == 'block' ) ? 'block' : ( oDisp == 'inline' ) ? 'inline' : '';
}
function MWJ_changeSize( oName, oWidth, oHeight, oFrame ) {
	var theDiv = MWJ_findObj( oName, oFrame ); if( !theDiv ) { return; }
	if( theDiv.style ) { theDiv = theDiv.style; } var oPix = document.childNodes ? 'px' : 0;
	if( theDiv.resizeTo ) { theDiv.resizeTo( oWidth, oHeight ); }
	theDiv.width = oWidth + oPix; theDiv.pixelWidth = oWidth;
	theDiv.height = oHeight + oPix; theDiv.pixelHeight = oHeight;

}
function MWJ_changeClip( oName, oLeft, oTop, oBottom, oRight, oFrame ) {
	var theDiv = MWJ_findObj( oName, oFrame ); if( !theDiv ) { return; }
	if( theDiv.clip ) { theDiv = theDiv.clip; theDiv.top = oTop; theDiv.right = oRight; theDiv.bottom = oBottom; theDiv.left = oLeft; }
	if( theDiv.style ) { theDiv.style.clip = 'rect('+oTop+'px '+oRight+'px '+oBottom+'px '+oLeft+'px)'; }
}
function MWJ_changeContents( oName, oContents, oIframe, oFrame ) {
	var theDiv = MWJ_findObj( oName, oFrame ); if( !theDiv ) { theDiv = new Object(); } if( !oFrame ) { oFrame = window; }
	if( typeof( theDiv.innerHTML ) != 'undefined' ) { theDiv.innerHTML = oContents; }
	else if( theDiv.document && theDiv.document != oFrame.document ) {
		theDiv = theDiv.document; theDiv.open(); theDiv.write( oContents ); theDiv.close(); }
	else if( oIframe && oFrame.frames && oFrame.frames.length && oFrame.frames[oIframe] ) {
		theDiv = oFrame.frames[oIframe].window.document; theDiv.open(); theDiv.write( oContents ); theDiv.close(); }
}
function MWJ_createNew( oName, oWidth, oNewID, oFrame ) {
	if( document.layers && window.Layer ) {
		var theOldLayer = oName ? MWJ_findObj( oName, oFrame ) : oFrame ? oFrame : window; if( !theOldLayer ) { return; }
		theOldLayer.document.layers[oNewID] = new Layer( oWidth, theOldLayer );
	} else {
		var theOldLayer = oName ? MWJ_findObj( oName, oFrame ) : oFrame ? oFrame.document.body : document.body; if( !theOldLayer ) { return; }
		var theString = '<div id="'+oNewID+'" style="position:absolute;width:'+oWidth+'px;visibility:hidden;"></div>';
		if( theOldLayer.insertAdjacentHTML ) { theOldLayer.insertAdjacentHTML('beforeEnd',theString);
		} else if( typeof( theOldLayer.innerHTML ) != 'undefined' ) { theOldLayer.innerHTML += theString; }
	}
}
function MWJ_getStyle( oName, oStyle, oFrame ) {
	if( oName == 'document' ) {
		var theBody = oFrame ? oFrame.document : window.document;
		if( theBody.documentElement && theBody.documentElement.style && theBody.documentElement.style.backgroundColor ) { return theBody.documentElement.style.backgroundColor; }
		if( theBody.body && theBody.body.style && theBody.body.style.backgroundColor ) { return theBody.body.style.backgroundColor; }
		if( theBody.documentElement && theBody.documentElement.style && theBody.documentElement.style.background ) { return theBody.documentElement.style.background; }
		if( theBody.body && theBody.body.style && theBody.body.style.background ) { return theBody.body.style.background; }
		if( theBody.bgColor ) { return theBody.bgColor; }
		return '#ffffff';
	}
	var theDiv = MWJ_findObj( oName, oFrame ); if( !theDiv ) { return null; } if( theDiv.style && oStyle != 'clip' ) { theDiv = theDiv.style; }
	switch( oStyle ) {
		case 'visibility':
			return ( ( theDiv.visibility && !( theDiv.visibility.toLowerCase().indexOf( 'hid' ) + 1 ) ) ? true : false );
		case 'left':
			return ( parseInt( theDiv.left ) ? parseInt( theDiv.left ) : 0 );
		case 'top':
			return ( parseInt( theDiv.top ) ? parseInt( theDiv.top ) : 0 );
		case 'zIndex':
			return ( isNaN( theDiv.zIndex ) ? 0 : theDiv.zIndex );
		case 'background':
			return ( theDiv.bgColor ? theDiv.bgColor : theDiv.background-color ? theDiv.background-color : theDiv.background );
		case 'display':
			return ( theDiv.display ? theDiv.display : '' );
		case 'size':
			if( typeof( theDiv.pixelWidth ) != 'undefined' ) { return [theDiv.pixelWidth,theDiv.pixelHeight]; }
			if( typeof( theDiv.width ) != 'undefined' ) { return [parseInt(theDiv.width),parseInt(theDiv.height)]; }
			if( theDiv.clip && typeof( theDiv.clip.bottom ) == 'number' ) { return [theDiv.clip.right,theDiv.clip.bottom]; }
			return [0,0];
		case 'clip':
			if( theDiv.clip ) { return theDiv.clip; }
			theDiv = ( theDiv.style && theDiv.style.clip ) ? theDiv.style.clip : 'rect()';
			theDiv = theDiv.substr( theDiv.indexOf( '(' ) + 1 ); var theClip = new Object();
			for( var x = 0, y = ['top','right','bottom','left']; x < 4; x++ ) {
				theClip[y[x]] = parseInt( theDiv ); if( isNaN( theClip[y[x]] ) ) { theClip[y[x]] = 0; }
				theDiv = theDiv.substr( theDiv.indexOf( ( theDiv.indexOf( ' ' ) + 1 ) ? ' ' : ( theDiv.indexOf( '	' ) + 1 ) ? '	' : ',' ) + 1 );
			} return theClip;
		default:
			return null;
	}
}
function MWJ_changeBody( oColour, oFrame ) { if( !oFrame ) { oFrame = window; }
	if( document.documentElement && document.documentElement.style ) {
		oFrame.document.documentElement.style.backgroundColor = oColour; }
	if( document.body && document.body.style ) { oFrame.document.body.style.backgroundColor = oColour; }
	oFrame.document.bgColor = oColour;
}
function MWJ_getPosition( oLink ) {
	if( oLink.offsetParent ) { for( var posX = 0, posY = 0; oLink.offsetParent; oLink = oLink.offsetParent ) {
		posX += oLink.offsetLeft; posY += oLink.offsetTop; } return [ posX, posY ];
	} else { if( !oLink.x && !oLink.y ) { return [0,0]; } else { return [ oLink.x, oLink.y ]; } }
}
function MWJ_getSize( oFrame ) {
	if( !oFrame ) { oFrame = window; } var myWidth = 0, myHeight = 0;
	if( typeof( oFrame.innerWidth ) == 'number' ) { myWidth = oFrame.innerWidth; myHeight = oFrame.innerHeight; }
	else if( oFrame.document.documentElement && ( oFrame.document.documentElement.clientWidth || oFrame.document.documentElement.clientHeight ) ) {
		myWidth = oFrame.document.documentElement.clientWidth; myHeight = oFrame.document.documentElement.clientHeight; }
	else if( oFrame.document.body && ( oFrame.document.body.clientWidth || oFrame.document.body.clientHeight ) ) {
		myWidth = oFrame.document.body.clientWidth; myHeight = oFrame.document.body.clientHeight; }
	return [myWidth,myHeight];
}
function MWJ_getScroll( oFrame ) {
	if( !oFrame ) { oFrame = window; } var scrOfX = 0, scrOfY = 0;
	if( typeof( oFrame.pageYOffset ) == 'number' ) { scrOfY = oFrame.pageYOffset; scrOfX = oFrame.pageXOffset; }
	else if( oFrame.document.documentElement && ( oFrame.document.documentElement.scrollLeft || oFrame.document.documentElement.scrollTop ) ) {
		scrOfY = oFrame.document.documentElement.scrollTop; scrOfX = oFrame.document.documentElement.scrollLeft; }
	else if( oFrame.document.body && ( oFrame.document.body.scrollLeft || oFrame.document.body.scrollTop ) ) {
		scrOfY = oFrame.document.body.scrollTop; scrOfX = oFrame.document.body.scrollLeft; }
	return [scrOfX,scrOfY];
}
function MWJ_monitorMouse(oFunc) {
	if( document.captureEvents && Event.MOUSEMOVE ) { document.captureEvents( Event.MOUSEMOVE ); }
	window.MWJ_getMouse = [0,0]; window.MWJstoreFunc = oFunc;
	document.onmousemove = function (e) { window.MWJ_getMouse = MWJ_getMouseCoords(e); if( window.MWJstoreFunc ) { window.MWJstoreFunc(); } };
}
function MWJ_getMouseCoords(e) {
	if( !e ) { e = window.event; } if( !e || ( typeof( e.pageX ) != 'number' && typeof( e.clientX ) != 'number' ) ) { return[0,0]; }
	if( typeof( e.pageX ) == 'number' ) { var xcoord = e.pageX; var ycoord = e.pageY; } else {
		var xcoord = e.clientX; var ycoord = e.clientY;
		if( !( ( window.navigator.userAgent.indexOf( 'Opera' ) + 1 ) || ( window.ScriptEngine && ScriptEngine().indexOf( 'InScript' ) + 1 ) || window.navigator.vendor == 'KDE' ) ) {
			if( document.documentElement && ( document.documentElement.scrollTop || document.documentElement.scrollLeft ) ) {
				xcoord += document.documentElement.scrollLeft; ycoord += document.documentElement.scrollTop;
			} else if( document.body && ( document.body.scrollTop || document.body.scrollLeft ) ) {
				xcoord += document.body.scrollLeft; ycoord += document.body.scrollTop;
			} } } return [xcoord,ycoord];
}
function MWJ_monitorKey( oOb, oEvent, oHandler ) {
	if( oOb.captureEvents && Event[oEvent.toUpperCase()] ) { oOb.captureEvents( Event[oEvent.toUpperCase()] ); }
	oOb['on'+oEvent.toLowerCase()] = function (e) { if( !e ) { e = window.event; }
		if( !e ) { return; } var oHandler = this['MWJ_'+e.type.toLowerCase()];
		e = ( typeof( e.which ) == 'number' ) ? e.which : ( ( typeof( e.keyCode ) == 'number' ) ? e.keyCode : ( ( typeof( e.charCode ) == 'number' ) ? e.charCode : 0 ) );
		if( oHandler ) { oHandler( arguments[0], e, String.fromCharCode( e ), this ); }
	}; oOb['MWJ_'+oEvent.toLowerCase()] = oHandler;
}
function MWJ_monitorButton( oOb, oEvent, oHandler ) {
	if( oOb.captureEvents && Event[oEvent.toUpperCase()] ) { oOb.captureEvents( Event[oEvent.toUpperCase()] ); }
	oOb['on'+oEvent.toLowerCase()] = function (e) { if( !e ) { e = window.event; }
		if( !e ) { return; } var oHandler = this['MWJ_'+e.type.toLowerCase()];
		if( typeof( e.which ) == 'number' ) { e = e.which; } else { e = e.button; }
		if( oHandler ) { oHandler( arguments[0], e, ( ( e < 2 ) ? 'left' : 'right' ), this ); }
	}; oOb['MWJ_'+oEvent.toLowerCase()] = oHandler;
}

function toggleVisible(elId,pos_elId,verOffset,horOffset,width,height) {	
	if (!verOffset) verOffset=28;
	if (!horOffset) horOffset=0;
	if (!width) width=300;
	if (!height)height=200;
	
	if ( MWJ_getStyle( elId ,'visibility') == true ) {
		MWJ_changeVisibility( elId , false );	
		MWJ_changeSize( elId ,1,1);
	} else {		
		MWJ_changeSize( elId ,width,height);
		
		oMC = MWJ_getPosition( MWJ_findObj(pos_elId) );
		MWJ_changePosition( elId,  oMC[0]+ horOffset ,  oMC[1] + verOffset , true );

		MWJ_changeVisibility( elId ,true );	
	}
}

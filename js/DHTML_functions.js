/******************************************
    Generic DHTML do everything script
By Mark 'Tarquin' Wilton-Jones 28-29/9/2002
*******************************************
Please see http://www.howtocreate.co.uk/jslibs/ for details and a demo of this script
Please see http://www.howtocreate.co.uk/jslibs/termsOfUse.html for terms of use
__________________________________________________________________________*/

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
function MWJ_changeContents( oName, oContents, oIframe, oFrame ) {
	var theDiv = MWJ_findObj( oName, oFrame ); if( !theDiv ) { theDiv = new Object(); } if( !oFrame ) { oFrame = window; }
	if( typeof( theDiv.innerHTML ) != 'undefined' ) { theDiv.innerHTML = oContents; }
	else if( theDiv.document && theDiv.document != oFrame.document ) {
		theDiv = theDiv.document; theDiv.open(); theDiv.write( oContents ); theDiv.close(); }
	else if( oIframe && oFrame.frames && oFrame.frames.length && oFrame.frames[oIframe] ) {
		theDiv = oFrame.frames[oIframe].window.document; theDiv.open(); theDiv.write( oContents ); theDiv.close(); }
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
function MWJ_getPosition( oLink ) {
	if( oLink.offsetParent ) { for( var posX = 0, posY = 0; oLink.offsetParent; oLink = oLink.offsetParent ) {
		posX += oLink.offsetLeft; posY += oLink.offsetTop; } return [ posX, posY ];
	} else { if( !oLink.x && !oLink.y ) { return [0,0]; } else { return [ oLink.x, oLink.y ]; } }
}
function toggleVisible(elId,pos_elId,verOffset,horOffset,width,height) {	
	if (!verOffset) verOffset=28;
	if (!horOffset) horOffset=0;
	if (!width) width=330;
	if (!height)height=220;
	
	if ( MWJ_getStyle( elId ,'visibility') == true ) {
		MWJ_changeVisibility( elId , false );	
		MWJ_changePosition( elId,  -999 ,  0 , true );
	//	MWJ_changeSize( elId ,1,1);
	} else {		
		//MWJ_changeSize( elId ,width,height);
		
		oMC = MWJ_getPosition( MWJ_findObj(pos_elId) );
		MWJ_changePosition( elId,  oMC[0]+ horOffset ,  oMC[1] + verOffset , true );

		MWJ_changeVisibility( elId ,true );	
	}
}

function toggleVisibility(elId) {	
//	if ( MWJ_getStyle( elId ,'visibility') == true ) {
		if ( MWJ_getStyle( elId ,'display') == "block") {
		MWJ_changeDisplay(elId,"none");
//		MWJ_changeVisibility( elId , false );	
	} else {		
			MWJ_changeDisplay(elId,"block");
//		MWJ_changeVisibility( elId ,true );	
	}
}

function nop()
{
}



	var iframeState='normal';
	var normalWidth=755;
	var normalHeight=610;

	function toogleFullScreen() {
		parent.resizeIframe('gmaps_iframe');
		var iframeEl = document.getElementById? document.getElementById('map'): document.all? document.all['map']: null;

		if (iframeEl) {
			iframeEl.style.height = "auto"; // helps resize (for some) if new doc shorter than previous
			iframeEl.style.width = "auto"; 
			// need to add to height to be sure it will all show
			if (iframeState=='normal') {
				var size=getParentSize();
				var new_w = (size.width-40);
				var new_h = (size.height-20);
				iframeState='max';
			} else {
				var new_w = normalWidth;
				var new_h =	normalHeight;
				iframeState='normal';
			}
			iframeEl.style.height = new_h-122 + "px";
			iframeEl.style.width = new_w-155 + "px";
		}
		zoomToFlight();
	}

	function resizeIframe(iframeName) {
		//var iframeWin = window.frames[iframeName];
		var iframeEl = document.getElementById? document.getElementById(iframeName): document.all? document.all[iframeName]: null;
		var gmaps_div = document.getElementById? document.getElementById('gmaps_div'): document.all? document.all['gmaps_div']: null;
		
		if (iframeEl) {
			iframeEl.style.height = "auto"; // helps resize (for some) if new doc shorter than previous
			iframeEl.style.width = "auto"; 
			// need to add to height to be sure it will all show
			if (iframeState=='normal') {
				var size=getSize();
				var new_w = (size.width-40);
				var new_h = (size.height-20);
				iframeState='max';

				gmaps_div.style.top = "10px";
				gmaps_div.style.left = "10px";
				gmaps_div.style.position='absolute';

			} else {
				var new_w = normalWidth;
				var new_h =	normalHeight;
				iframeState='normal';
				gmaps_div.style.top = "0px";
				gmaps_div.style.left = "0px";
				gmaps_div.style.position='relative';
			}
			iframeEl.style.height = new_h + "px";
			iframeEl.style.width = new_w + "px";
		}
	}

	function getSize() {
		var myHeight = 0;
		var myWidth = 0;
		if( typeof( window.innerWidth ) == 'number' ) {
			//Non-IE
			myHeight = window.innerHeight;
			myWidth = window.innerWidth;
		} else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
			//IE 6+ in standards compliant mode
			myHeight = document.documentElement.clientHeight;
			myWidth = document.documentElement.clientWidth;
		} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
			//IE 4 compatible
			myHeight = document.body.clientHeight;
			myWidth = document.body.clientWidth;
		}
		return {width : myWidth, height : myHeight};
	}

	function getParentSize() {
		var myHeight = 0;
		var myWidth = 0;
		if( typeof( parent.window.innerWidth ) == 'number' ) {
			//Non-IE
			myHeight = parent.window.innerHeight;
			myWidth = parent.window.innerWidth;
		} else if( parent.document.documentElement && ( parent.document.documentElement.clientWidth || parent.document.documentElement.clientHeight ) ) {
			//IE 6+ in standards compliant mode
			myHeight = parent.document.documentElement.clientHeight;
			myWidth = parent.document.documentElement.clientWidth;
		} else if( parent.document.body && ( parent.document.body.clientWidth || parent.document.body.clientHeight ) ) {
			//IE 4 compatible
			myHeight = parent.document.body.clientHeight;
			myWidth = parent.document.body.clientWidth;
		}
		return {width : myWidth, height : myHeight};
	}

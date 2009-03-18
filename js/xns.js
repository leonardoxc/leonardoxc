var ua = navigator.userAgent.toLowerCase();
var divw=0;
var divh=0;
var DescriptionStr='';
var TitleStr='';

if (document.getElementById || document.all)
	document.write('<div id="imgtrailer" style="position:absolute;visibility:hidden;z-index:110;"></div>')

function gettrailobject()
	{
	if (document.getElementById)
		return document.getElementById("imgtrailer")
	else if (document.all)
		return document.all.trailimagid
	}

function gettrailobj()
	{
	if (document.getElementById)
		return document.getElementById("imgtrailer").style
	else if (document.all)
		return document.all.trailimagid.style
	}

function truebody()
	{
	return (!window.opera && document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
	}

function hidetrail()
	{
	gettrailobject().innerHTML=" ";
	document.onmousemove='';
	gettrailobj().visibility="hidden";
	}

function trailOn(thumbimg,imgtitle,imgscription,imgsize,filesize,credit,level,thw,thh,flvvid,samplepath)
	{
	//if(ua.indexOf('opera') == -1 && ua.indexOf('safari') == -1)
		//{
		gettrailobj().left="-500px";
		divthw = parseInt(thw) + 2;
		
		if(flvvid){
			var vidsample = samplepath + flvvid;
			newHTML = "";
			newHTML = newHTML + '<div align="center" style="width:'+thw+'px; font-family: verdana; font-size: 11px; padding: 0px; border: 1px solid #333333; background-color: #FFFFFF; layer-background-color: #FFFFFF; background-image: url(images/img_load.gif); background-repeat: no-repeat;">';
			newHTML = newHTML +	'<object width="'+thw+'" height="'+thh+'" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0">';
			newHTML = newHTML + '<param name="movie" value="swf/flashthumb.swf">';
			newHTML = newHTML + '<param name="quality" value="best">';
			newHTML = newHTML + '<param name="loop" value="true">';	
			newHTML = newHTML + '<param name="FlashVars" value="myfile=' + vidsample + '">';
			newHTML = newHTML + '<EMBED SRC="swf/flashthumb.swf" LOOP="true" QUALITY="best" FlashVars="myfile=' + vidsample + '" WIDTH="'+thw+'" HEIGHT="'+thh+'">';
			newHTML = newHTML + '</object><div align="left" style="padding: 3px;"><b>'+TitleStr+' </b>'+imgtitle+'<br><b>'+DescriptionStr+' </b>'+imgscription+'</div></div>';
			gettrailobject().innerHTML = newHTML;
		} else {
			// document.writeln('<table><tr><td><div style="background-color: #000000; layer-background-color: #000000; border: 0pt none #000000; padding: 0pt; width:'+divthw+'px;"><div style="background-color: #FFFFFF; layer-background-color: #FFFFFF; border: 1px solid #000000; background-image: url(images/img_load.gif); background-repeat: no-repeat;"><center><img src="'+thumbimg+'" border="0" width="'+thw+'" height="'+thh+'"></center><div style="padding:3px"><b>'+TitleStr+' </b>'+imgtitle+'<br><b>'+DescriptionStr+' </b>'+imgscription+'<br></div></div></div></td></tr></table>');
			var divWidth='';
			if ( divthw+0 >0 ) divWidth='width:'+divthw+'px;';
			gettrailobject().innerHTML = '<table><tr><td><div style="background-color: #000000; layer-background-color: #000000; border: 0pt none #000000; padding: 0pt; '+divWidth+'"><div style="background-color: #FFFFFF; layer-background-color: #FFFFFF; border: 1px solid #000000; background-image: url(images/img_load.gif); background-repeat: no-repeat;"><center><img src="'+thumbimg+'" border="0" width="'+thw+'" height="'+thh+'"></center></div></div></td></tr></table>';

		}
		
		
		gettrailobj().visibility="visible";
		divw = parseInt(thw)+25;
		divh = parseInt(thh)+80;
		document.onmousemove=followmouse;
		//}
	}

function followmouse(e)
	{
	var docwidth=document.all? truebody().scrollLeft+truebody().clientWidth : pageXOffset+window.innerWidth-15
	var docheight=document.all? Math.min(truebody().scrollHeight, truebody().clientHeight) : Math.min(document.body.offsetHeight, window.innerHeight)
if(typeof e != "undefined")
	{
	if(docwidth < 15+e.pageX+divw)
		xcoord = e.pageX-divw-5;
	else
		xcoord = 15+e.pageX;
	if(docheight < 15+e.pageY+divh)
		ycoord = 15+e.pageY-Math.max(0,(divh + e.pageY - docheight - truebody().scrollTop - 30));
	else
		ycoord = 15+e.pageY;
	}
else if (typeof window.event != "undefined")
	{
	if(docwidth < 15+truebody().scrollLeft+event.clientX+divw)
		xcoord = truebody().scrollLeft-5+event.clientX-divw;
	else
		xcoord = truebody().scrollLeft+15+event.clientX;

	if(docheight < 15+truebody().scrollTop+event.clientY+divh)
		ycoord = 15+truebody().scrollTop+event.clientY-Math.max(0,(divh + event.clientY - docheight - 30));
	else
		ycoord = truebody().scrollTop+15+event.clientY;
	}
	gettrailobj().left=xcoord+"px"
	gettrailobj().top=ycoord+"px"
	}

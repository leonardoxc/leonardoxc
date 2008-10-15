/*
 * BetterTip
 * Created by Edgar Verle
 * BetterTip is made for the jQuery library.
 */

$(BT_init);

var BT_default_width=350;
var BT_open_wait = 500; //time in millis to wait before showing dialog
var BT_close_wait = 0; //time in millis to wait before closing dialog
var BT_cache_enabled = true;
var BT_events = new Array();
var BT_titles = new Array();

function BT_init(){
	
    $("a.betterTip").parent("div.betterTip")
    .hover(function(){BT_hoverIn($(this).children("a.betterTip")[0]); return false;},
    	   function(){BT_hoverOut($(this).children("a.betterTip")[0])})
    ;
    
    $("a.betterTip").filter(function(index){
    	return $(this).parent("div.betterTip").length == 0;
    })
    .hover(function(){BT_hoverIn(this)}, function(){BT_hoverOut(this)});
	//.click(function(){return false});	
}

function BT_setOptions(hash)
{
	if(hash["openWait"] != null)
		BT_open_wait = hash["openWait"];
	if(hash["closeWait"] != null)
		BT_close_wait = hash["closeWait"];
	if(hash["cacheEnabled"] != null)
		BT_cache_enabled = hash["cacheEnabled"];
}

function BT_hoverIn(a)
{
	var timeout = BT_open_wait;
	
	if($('#BT_cache_'+a.id).length > 0)
		timeout = 0;
	
	var title = a.title;
	
	if(!BT_titles[a.id])
	{
		if(!title || title.toLowerCase() == "$none")
			title = "";
		else if(title.toLowerCase() == "$content")
			title = $(a).text();
		
		BT_titles[a.id] = title;
		a.title = "";
	}
		
	BT_events[a.id] = 1;
	setTimeout(function(){BT_show(a.id)}, BT_open_wait);
}

function BT_hoverOut(a)
{
	BT_events[a.id] = 0;
	setTimeout(function(){BT_remove();}, BT_close_wait);
}

function BT_remove()
{
	$('#BT').remove();
}


function BT_show(id) {

	if(BT_events[id] == 0)
		return;

	var obj = $("#"+id);
	var url='';

	if ( typeof BT_base_urls != 'undefined' ) {
		var idParts = id.split("_", 2);
		var extID= idParts[1];		
		var idParts2 = idParts[0].split("a", 2);
		var BT_base_url2=BT_base_urls[idParts2[1]];
		url=BT_base_url2+extID;	
	} else if (BT_base_url!='') {
		var idParts = id.split("_", 2);
		var extID= idParts[1];
		url=BT_base_url+extID;	
	} else {	
		url = obj[0].href;
	}
	
	var title = BT_titles[id];
	
	$("#BT").remove();

	var parents = $("#"+id).parent("div.betterTip");
	
	if(parents.length > 0)
		id = $("#"+id).parent("div.betterTip")[0].id;

	obj = $("#"+id);
	
	var showTitle = true;

	if(title.length == 0)
		showTitle = false;
	
	var urlParts = url.split("\?", 2);
	var query = BT_parseQuery(urlParts[1]);
	urlParts[0] = urlParts[0].substr(urlParts[0].lastIndexOf('/')+1);
	
	if(!query["width"] || query["width"].length == 0)
		query["width"] = BT_default_width;
	
	var tipWidth = parseInt(query["width"]);
	
	var act_left = BT_getLeft(id);
	var act_width = BT_getWidth(id);
				
	var left = act_left + act_width + 12;
	var top = BT_getTop(id);

	
	var arrowDir = "left";
	
	var docWidth = self.innerWidth || (document.documentElement&&document.documentElement.clientWidth) || document.body.clientWidth;
	var right = act_left + act_width + 11 + tipWidth + 20;
	var arrowLeft = -10;
	var arrowTop = -3;
	var shadowTop = -7;
	var shadowLeft = -7;

	if(docWidth < right)
	{
		arrowDir = "right";
		left = act_left - 12 - tipWidth;
		arrowLeft = tipWidth;
		arrowTop = -1;
		
		if(document.all)
			arrowLeft -= 2;
	}
	else if(showTitle)
		arrowTop = -2;
	
	if(showTitle)
		arrowDir = "title_" +arrowDir;
	
	$("body").append(
		"<div id='BT' class='BT_shadow0' style='top:"+(top-shadowTop-8)+"px; left:"+(left-shadowLeft - 8)+"px;'>" +
		"<div class='BT_shadow1'>"+
		"<div class='BT_shadow2'>" +
		"<div id='BT_main' style='width:"+query["width"]+"px; top:"+shadowTop+"px; left:"+shadowLeft+"px;'>" +
			"<div id='BT_arrow_"+arrowDir+"' style='top: "+arrowTop+"px; left:"+arrowLeft+"px;'></div>" +
			(showTitle?"<div id='BT_title'>"+title+"</div>":"") +
			"<div style='padding:5px'>" +
				"<div id='BT_content'>" +
					"<div class='BT_loader'></div>" +
				"</div>" +
			"</div>"+
			"<div id='BT_bottom_arrow_"+arrowDir+"' style='display:none; top: 30px; left:"+arrowLeft+"px;'></div>" +
		"</div></div></div></div>");
	
	
	
	if(urlParts[0].charAt(0) == '$')
	{
		$('#BT_content').html($("#"+urlParts[0].substr(1)).html());
		$('#BT').show();
		BT_checkBounds();
	}
	else if(BT_cache_enabled)
	{
		if($('#BT_cache_'+id).length > 0)
			BT_loadCache(id);
		else
			$.post(url, {}, function(data){
				BT_createCacheElement(id, data);
			});
	}
	else
	{
		$.post(url, {}, function(data){
			$('#BT_content').html(data);
			$('#BT').show();
			BT_checkBounds();
		})
	}
	
}

function BT_checkBounds() {

	var window_scrollTop= $(window).scrollTop();
	var window_height= 	$(window).height();

	var h = $('#BT');

	var divHeight=h.height();	
	var offset= h.offset();
	
	var top=offset.top;
	
	if (window_scrollTop + window_height  <  divHeight+ offset.top  ) {				
		var oldTop=divHeight-35;
		top -=  divHeight - 31  ;
		$('#BT').css({top: top + 'px'}).addClass("viewport-bottom");

		$('#BT_arrow_left').hide();
		$('#BT_arrow_right').hide();

		$('#BT_bottom_arrow_left').show().css({top: oldTop + 'px'});
		$('#BT_bottom_arrow_right').show().css({top: oldTop + 'px'});
		
	}
		
}

function BT_createCacheElement(id, data)
{
	$("body").append("<div id='BT_cache_"+id+"' style='display:none'>"+
		data+"</div>");
	
	BT_loadCache(id);
}

function BT_loadCache(id)
{
	$('#BT_content').html($('#BT_cache_'+id).html());
	$('#BT').show();
	BT_checkBounds();
}

function BT_getWidth(id) {
	var x = document.getElementById(id);
	return x.offsetWidth;
}

function BT_getLeft(id) {
	
	var obj = $('#'+id)[0];
	var left = obj.offsetLeft;
	var parent = obj.offsetParent;
	
	while(parent) {
		left += parent.offsetLeft;
		parent = parent.offsetParent;
	}
	
	return left
}

function BT_getTop(id) {
	var obj = $('#'+id)[0];
	var top = obj.offsetTop;
	var parent = obj.offsetParent;
	
	while(parent) {
		top += parent.offsetTop;
		parent = parent.offsetParent;
	}
	
	return top;
}

function BT_parseQuery ( query ) {
	
	var params = new Object ();
   
	if ( ! query ) 
		return params;
		
	var pairs = query.split(/[;&]/);
	
	for ( var i = 0; i < pairs.length; i++ ) {
		
		var kv = pairs[i].split('=');
		
		if ( ! kv || kv.length != 2 ) 
			continue;
			
		var key = unescape( kv[0] );	
		var val = unescape( kv[1] );
		
		val = val.replace(/\+/g, ' ');
		params[key] = val;
	}
	
	return params;
}
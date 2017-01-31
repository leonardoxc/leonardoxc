<?
//************************************************************************
// Leonardo XC Server, http://www.leonardoxc.net
//
// Copyright (c) 2004-2010 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: MENU_fav.php,v 1.2 2012/09/17 22:33:49 manolis Exp $                                                                 
//
//************************************************************************
 

?>
<div id="dbg" style="position:absolute;top:0;left:0;width:100px;height:20px;display:none;"></div>

<script type="text/javascript">

var favList=[];
var favVisible=0;
var favSelectInit=0;
var compareUrlBase='<?php echo getLeonardoLink(array('op'=>'compare','flightID'=>'%FLIGHTS%'));?>';
var compareUrl='';

function toogleFav() {
	if (favVisible) {
		deactivateFavorites();
		favVisible=0;
	} else {
		activateFavorites();
		favVisible=1;
	}
	toogleMenu('fav');
}

function activateFavorites() {

	// $("#favFloatDiv").show("");
	if (favSelectInit) {
		$(".indexCell .selectTrack").show();
	} else {
		$(".indexCell").not('.SortHeader').append("<input class='selectTrack' type='checkbox' value='1' >");
		favSelectInit=1;
	}
}

function deactivateFavorites() {

	$(".indexCell .selectTrack").hide();

}

function loadFavs() {
	for( var flightID in favList) {
	//	addFavFav(flightID );
	}	
}

function addFav(flightID ){

	if ( $.inArray(flightID, favList)  >=0 ) { return; }
	
	
	var newrow=$("#row_"+flightID).clone().attr('id', 'fav_'+(flightID)  ).appendTo("#favList > tbody:last");

	
	$("#fav_"+flightID+" *").removeAttr('id').removeAttr("href");

	$("#fav_"+flightID+" a").contents().unwrap();

	$("#fav_"+flightID+" .dateHidden").removeClass('dateHidden');
	
	$("#fav_"+flightID+" .indexCell").remove();
	$("#fav_"+flightID+" .indexCell").remove();
	$("#fav_"+flightID+" .smallInfo").html("<div class='fav_remove' id='fav_remove_"+flightID+"'>"+
				"<?php echo leoHtml::img("icon_fav_remove.png",0,0,'absmiddle',_Remove_From_Favorites,'icons1','',0)?></div>");
	favList.push(flightID);

	updateLink();
	updateCookie();
	//$.getJSON('EXT_flight.php?op=list_flights_json&lat='+flights[i].data.firstLat+'&lon='+flights[i].data.firstLon+'&distance='+radiusKm+queryString,null,addFlightToFav);	
}

function removeFav(flightID ){

	if ( $.inArray(flightID, favList)  < 0  ) { return; }
	
	$("#fav_"+flightID).fadeOut(300,function() {
		$(this).remove();

		//remove from list
		favList = jQuery.grep(favList, function(value) {
			  return value != flightID;
		});
		updateLink();
		updateCookie();
	});

	
}

function updateCookie(){
	//return;
	var str='';
	var favListNum=0;
	for(var i in favList) {
		if (favListNum>0) str+=',';
		str+=favList[i];
		favListNum++;
	}
	
	$.cookie("favList", str );
	$.post("<?=$moduleRelPath?>/EXT_ajax_functions.php?op=storeFavs", { favHtml: $("#favListDiv").html() } );
	
}

function clearFavs(){
	$.cookie("favList", null );
	$.post("<?=$moduleRelPath?>/EXT_ajax_functions.php?op=storeFavs", { favHtml: '' } );
	$("#favList tr").remove();
	favList=[];
	updateLink();
}

function updateLink() {
	var str='';
	var  favListNum=0;
	for(var i in favList) {
		if (favListNum>0) str+=',';
		str+=favList[i];
		favListNum++;
	}
	if (favListNum>0) {
		$("#compareFavoritesLink").show();
		$("#compareFavoritesText").hide();
		
		compareUrl=compareUrlBase.replace("%FLIGHTS%",str);
		$("#compareFavoritesLink").attr('href',compareUrl);
	} else {
		$("#compareFavoritesLink").hide();
		$("#compareFavoritesText").show();
	}

	
}

$(document).ready(function(){

	var favListCookie=$.cookie("favList");
	if (favListCookie) {
		favList=favListCookie.split(',');		
		updateLink();		
	}

	
	$(".indexCell .selectTrack").live('click',function() {
		var row=$(this).parent().parent();
		var flightID=row.attr('id').substr(4);

		if ( $(this).is(':checked') ) {
			addFav(flightID);
		} else {
			removeFav(flightID);
		}
		//$("#dbg").html("id="+flightID+"@"+row.attr('id'));
		//row.css({background:"#ff0000",height:"100"});
	});

	$(".fav_remove").live('click',function() {
		var flightID=$(this).attr('id').substr(11);
		$("#row_"+flightID+" .selectTrack").attr('checked', false);
		removeFav(flightID);
	});



	
});


</script>

<div id="favDropDownID" class="secondMenuDropLayer"  >
<div class='closeButton closeLayerButton'></div>        
<div class='content' align="left">

	<div style='text-align:center;margin-top:10px;'>
		<span class='info' id='compareFavoritesText'>
		<h2><?php echo _Favorites ?></h2>
		<?php echo _Compare_flights_line_1 ?>
		<BR>
		<!-- Select Flights by clicking on the checkbox  -->	
		<?php echo _Compare_flights_line_2 ?>
			<!-- You can then compare all your selected flights in google maps -->	
			<br><BR>	
		</span>
		
		<a id='compareFavoritesLink' class='greenButton' href=''><?php echo _Compare_Favorite_Tracks ?></a>
		
		<a class='redButton smallButton' href='javascript:clearFavs()'><?php echo _Remove_all_favorites?></a>
		
		<hr>
	</div>	 
	<div id='favListDiv'>
		<?php  if (strlen($_SESSION['favHtml'])>30) { 
			echo $_SESSION['favHtml'];
		} else { ?>
		<table id='favList'>
			<tbody></tbody>
		</table>
		<?php  } ?>
	</div>
</div>
</div>
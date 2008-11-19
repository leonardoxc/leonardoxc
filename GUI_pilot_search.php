<?
/************************************************************************/
/* Leonardo: Gliding XC Server					                                */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://sourceforge.net/projects/leonardoserver                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/
?>
<link rel="stylesheet" href="<?=$moduleRelPath ?>/js/bettertip/jquery.bettertip.css" type="text/css" />

<script type="text/javascript" src="<?=$moduleRelPath ?>/js/tipster.js"></script>
<script type="text/javascript" src="<?=$moduleRelPath ?>/js/bettertip/jquery.bettertip.js"></script>
<script type="text/javascript" src="<?=$moduleRelPath ?>/js/jquery.autocomplete.js"></script>

<style type="text/css">
.ac_input {
	width: 200px;
}
.ac_results {
	padding: 0px;
	border: 1px solid WindowFrame;
	background-color: Window;
	overflow: hidden;
}

.ac_results ul {
	width: 100%;
	list-style-position: outside;
	list-style: none;
	padding: 0;
	margin: 0;
}

.ac_results iframe {
	display:none;/*sorry for IE5*/
	display/**/:block;/*sorry for IE5*/
	position:absolute;
	top:0;
	left:0;
	z-index:-1;
	filter:mask();
	width:3000px;
	height:3000px;
}

.ac_results li {
	margin: 0px;
	padding: 2px 5px;
	cursor: pointer;
	display: block;
	width: 100%;
	font: menu;
	font-size: 12px;
	overflow: hidden;
}
.ac_loading {
	background : url('<?=$moduleRelPath?>/img/ajax-loader.gif') right center no-repeat;
}
.ac_over {
	background-color: Highlight;
	color: HighlightText;
}
</style>

<script type="text/javascript">
var BT_base_url='<?=$moduleRelPath?>/GUI_EXT_pilot_info.php?op=info_short&pilotID=';
var BT_default_width=500;

function selectItem(li) {
	if (li.extra) {		
		var pilotID=li.extra[1].replace('u','_');
		
	var url1="<?=getLeonardoLink(array('op'=>'pilot_profile','pilotIDview'=>'%pilotID%'))?>";
	var url2="<?=getLeonardoLink(array('op'=>'list_flights','pilotID'=>'%pilotID%','year'=>'0',
	'country'=>'0','takeoffID'=>'0','cat'=>'0'))?>";
	var url3="<?=getLeonardoLink(array('op'=>'pilot_profile_stats','pilotIDview'=>'%pilotID%'))?>";
	
		var html=
		"<hr><b>"+li.selectValue+"</b><Br>"+
		"<img src='<?=$moduleRelPath?>/img/icon_pilot.gif' border=0 align='absmiddle'> <a href='"+
		url1.replace('%pilotID%',pilotID)+"'><? echo _Pilot_Profile ?></a><BR>"+
		"<img src='<?=$moduleRelPath?>/img/icon_magnify_small.gif' border=0 align='absmiddle'> <a href='"+
		url2.replace('%pilotID%',pilotID)+"'><? echo _PILOT_FLIGHTS ?></a><br>"+
		"<img src='<?=$moduleRelPath?>/img/icon_stats.gif' border=0 align='absmiddle'> <a href='"+
		url3.replace('%pilotID%',pilotID)+"'><? echo _flights_stats ?></a>";

		$("#pilotMenu").html(html);		
		
		$("#pilotNameStr").val(li.extra[1]);
		$("#pilotInfo").html("<img src='<?=$moduleRelPath?>/img/ajax-loader.gif'>");
  	    $("#pilotInfo").load("<?=$moduleRelPath?>/GUI_EXT_pilot_info.php?pilotID="+li.extra[1]); 
		
	}
}
function formatItem(row) {
	return row[1];
}
<?
$_SESSION['sessionHashCode']=makeHash('EXT_pilot_functions');

	if ($CONF_use_utf) {		
		$CONF_ENCODING='utf-8';
	} else  {		
		$CONF_ENCODING=$langEncodings[$currentlang];
	}
		
?>
$(document).ready(function() {
	$("#pilotName").autocomplete("<?=$moduleRelPath?>/EXT_pilot_functions.php?op=findPilot", { minChars:3, matchSubset:1, matchContains:1, cacheLength:10, onItemSelect:selectItem, formatItem:formatItem, selectOnly:1 , enc:'<?=$CONF_ENCODING?>' });

});

</script>
<?
	open_inner_table(_MENU_SEARCH_PILOTS,700,"icon_pilot.gif");

?>
Search for pilot: <BR />
Enter at least 3 letters of the First or Last Name
<BR /><BR>
Pilot Name: <input id="pilotName" name="pilotName" type="text" />
<input id="pilotNameStr" name="pilotNameStr" type="hidden" />

<div style="width:500px">
	<div id="pilotMenu">
	</div>
	<div id="pilotInfo">
	</div>
</div>
<BR /><BR />
<?
	close_inner_table();
  
?>

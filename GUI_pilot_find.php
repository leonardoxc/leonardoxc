<?
//************************************************************************
// Leonardo XC Server, https://github.com/leonardoxc/leonardoxc
//
// Copyright (c) 2004-2010 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: GUI_pilot_find.php,v 1.1 2012/09/12 19:41:03 manolis Exp $                                                                 
//
//************************************************************************
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

#resultsBox {
	position:relative;
	float:left;
	width:100%
}
	
#mainPilotInfo {
   float: left;  
	width:550px;
	height:auto;
	border-left:1px solid #c0c0c0;
	padding-left:10px;
}
	
#searchResultsBox {
   float: left;
   width: 157px;
   min-height:400px;
	padding:4px;
	padding-right:10px;
}
	
.pilotRow{
	background: none repeat scroll 0 0 #F8F8F8;
	border-bottom: 1px solid #CCCACA;
	cursor: pointer;
	margin-top: 2px;
	padding: 3px;
}

</style>

<script type="text/javascript">

<?
$_SESSION['sessionHashCode']=makeHash('EXT_pilot_functions');

	if ($CONF_use_utf) {		
		$CONF_ENCODING='utf-8';
	} else  {		
		$CONF_ENCODING=$langEncodings[$currentlang];
	}

	
?>
var pilots=[];
$(document).ready(function() {


	$(".pilotRow").live('click',function () {	  
		var userID=$(this).attr('id').substr(2);

		$.get('<?=$moduleRelPath?>/GUI_EXT_pilot_info.php?op=info_full&pilotID='+userID,function(data) {
			$("#mainPilotInfo").html(data);

			// Clean up unwnated stuf, jQuery rulez!!!!
			$('.pilotLink').remove();
			$('.indexCell').remove();

			// not for flightLink 
			$("#mainPilotInfo a").not(".flightLink").not('.pilotLinks a').removeAttr("href");
			
			$("#mainPilotInfo .class_pilotName").css({'width':'0px'}).html('');
			$("#mainPilotInfo .pilotTakeoffCell").css({'width':'100px'});
			$("#mainPilotInfo .displayCell").css({'width':'16px'}).html('');
			$("#mainPilotInfo .smallInfo").css({'width':'16px'});
			
			$(".listTable").css({'width':'565px'});
		});
	
		
	});
	
	$("#pilotName").keyup(function(){
		var searchStr=$("#pilotName").val();
		if (searchStr.length<3) return;
		
		// $("#searchResults").html('searching');		
		$.getJSON("<?=$moduleRelPath?>/EXT_pilot_functions.php",{
			'op': 'findPilot',
			'json': 1,
			'count': 30,
			'q': searchStr
			}, function(data) {
				pilots=[];
				$("#searchResults .pilotRow").remove();
				for( var i in data.pilots) {
					var p=data.pilots[i];
					pilots[p.userID]=p;
					
					$("#searchResults").append("<div class='pilotRow' id='p_"+p.userID+"'>"+p.flag+' '+p.name+' '+p.sex+"</div>");
				}
			}
		);	
	});
	
});

</script>
<?
	openMain(_MENU_SEARCH_PILOTS.' ('. _Pilot_search_instructions.')',0,"icon_pilot.gif");
?>


<div id='resultsBox'>
	<div id='searchResultsBox'>	
		<?=_PILOT_NAME?>
 		<input id="pilotName" name="pilotName" type="text" />
		<div id='searchResults'>
		</div>
	</div>
		
	<div id='mainPilotInfo' >

	</div>
</div>

<?
	closeMain();
?>
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

/**
 * Dialog to select one NAC-club
 * Modification Martin Jursa 22.05.2007 to work with MENU_nacclubs_simple
 */
 	require_once dirname(__FILE__)."/EXT_config_pre.php";
	require_once dirname(__FILE__)."/config.php";
 	require_once dirname(__FILE__)."/EXT_config.php";

	require_once dirname(__FILE__)."/CL_flightData.php";
	require_once dirname(__FILE__)."/FN_functions.php";	
	require_once dirname(__FILE__)."/FN_UTM.php";
	require_once dirname(__FILE__)."/FN_waypoint.php";	
	require_once dirname(__FILE__)."/FN_output.php";
	require_once dirname(__FILE__)."/FN_pilot.php";
	require_once dirname(__FILE__)."/FN_flight.php";
	require_once dirname(__FILE__)."/templates/".$PREFS->themeName."/theme.php";
	setDEBUGfromGET();
	require_once dirname(__FILE__)."/language/".CONF_LANG_ENCODING_TYPE."/lang-".$currentlang.".php";
	require_once dirname(__FILE__)."/language/".CONF_LANG_ENCODING_TYPE."/countries-".$currentlang.".php";

	require_once dirname(__FILE__)."/CL_NACclub.php";

	$clubID=$_GET['clubID']+0;
	$NAC_ID=$_GET['NAC_ID']+0;
	
	// print_r($clubList);
	// $charset=$langEncodings[$currentlang];

	# $_GET['option'] is to control scenario dependent options
	$option=empty($_GET['option']) ? 1 : $_GET['option'];
	# url parameters in case of option 2
	$params=empty($_GET['params']) ? '' : urldecode($_GET['params']);

	$withFlightsOnly=$option==2;
	$clubList=NACclub::getClubs($NAC_ID, $withFlightsOnly);

  ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"  >
<html>
<head>
  <title><?=_Select_Club?></title>
  <meta http-equiv="content-type" content="text/html; charset=<?=$CONF_ENCODING?>">

<style type="text/css">
	html {
		height: 100%;
	}
	body, p, table,tr,td {
		font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px;
	}
	body {
		margin:0px;
		background-color:#E9E9E9;
		height: 100%;
	}
	.box {
	 	background-color:#F4F0D5;
	 	border:1px solid #555555;
		padding:3px;
		margin-bottom:5px;
	}
	.boxTop {margin:0; }
</style>
<script type="text/javascript" language="javascript">
<!--
<? if ($option==1) { ?>
function refreshParent() {
  topWinRef=top.location.href;
  top.window.location.href=topWinRef;
}
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

function setValToMaster() {
	if (!window.opener) {
		alert('Parent window not available');
	}else {
		var NACclub_sel=MWJ_findObj("clubList");
		var selIndex	= NACclub_sel.selectedIndex;
		var club_id		= NACclub_sel.options[selIndex].value ;    // Which menu item is selected
		var club_name	= NACclub_sel.options[selIndex].text;

		var NACclub_fld=MWJ_findObj('NACclub','',window.opener.document);
		NACclub_fld.value=club_name;

		var NACclub_id_fld=MWJ_findObj('NACclubID','',window.opener.document);
		NACclub_id_fld.value=club_id;
	}
	window.close();
}
<? }elseif ($option==2) { ?>
function setValToMaster() {
	if (!window.opener) {
		alert('Parent window not available');
	}else {
		var masterDoc=window.opener.document;
		var pageUrl='<?=$params?>';
		if (pageUrl=='') {
			alert('Parameter params is missing.');
		}else {
			//var parts=masterDoc.location.href.split('?');
			var el=document.getElementById('clubList');
			if (el) {
				var nacclubId=el.options[el.selectedIndex].value;
				if (!nacclubId) nacclubId='0';
				// var hrefNew=parts[0]+'?'+urlParams+'&nacclubid='+nacclubId+'&nacid=<?=$NAC_ID?>';
				var hrefNew=pageUrl.replace('%nacclubid%',nacclubId).replace('%nacid%',<?=$NAC_ID?>);
				masterDoc.location.href=hrefNew;
			}
		}
	}
	window.close();
}
<? }else { ?>
function setValToMaster() {
	alert('Missing or invalid Parameter "option"');
}
<? } ?>//-->
</script>
</head>
<body style="height:100%;width:100%;">
<form name="form1" method="post" action="" style="height:100%;width:100%;">
	<table width="450" height="100%" border="0" align="center" cellpadding="2" class="shadowBox main_text">
	  <tr>
	    <td width="478" bgcolor="#CFE2CF">
	      <div align="center" style="height:100%">
			<select name="clubList" id="clubList" size="24"  style="height:90%">
		      <?
				if ($clubID==0) $sel=" selected ";
				else $sel="";
				echo "<option value='0' $sel></option>\n";
				foreach ($clubList as $clubID_list=>$clubName) {
						if ($clubID==$clubID_list) $sel=" selected ";
						else $sel="";
						echo "<option value='$clubID_list' $sel>$clubName</option>\n";
				}
			?>
		    </select>
		    <br>
		    <input type="button" name="Submit" value="<? echo _Select_Club ?>" onClick="setValToMaster()"/>
		    <input type="button" name="Submit2" value="<? echo _Close_window ?>"  onclick="window.close();" />
		  </div>
		 </td>
	  </tr>

	</table>
</form>
</body>
</html>
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
	require_once dirname(__FILE__)."/language/lang-".$currentlang.".php";
	require_once dirname(__FILE__)."/language/countries-".$currentlang.".php";
	require_once dirname(__FILE__)."/CL_NACclub.php";

	$clubID=$_GET['clubID']+0;
	$NAC_ID=$_GET['NAC_ID']+0;
	$clubList=NACclub::getClubs($NAC_ID);
	// print_r($clubList);

  ?>
<head>
<title><?=_Select_Club?></title>

</head>
<style type="text/css">
	 body, p, table,tr,td {font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px;}
	 body {margin:0px; background-color:#E9E9E9}
	.box {
		 background-color:#F4F0D5;
		 border:1px solid #555555;
		padding:3px; 
		margin-bottom:5px;
	}
	.boxTop {margin:0; }
</style>
<script language="javascript">
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
		alert('ERROR');
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

</script>
      <form name="form1" method="post" action="" >
<table width="450" border="0" align="center" cellpadding="2" class="shadowBox main_text">
              <tr>
                <td width="478" bgcolor="#CFE2CF">
                  <div align="center">
    <select name="clubList" size="24">
			      <?
					foreach ($clubList as $clubID_list=>$clubName) {
							if ($clubID==$clubID_list) $sel=" selected ";
							else $sel="";
							echo "<option value='$clubID_list' $sel>$clubName</option>\n";
					} 							 
				?>
                    </select>
    <br>
    <input type="submit" name="Submit" value="<? echo _Select_Club ?>" onclick="setValToMaster()"/>
    <input type="submit" name="Submit2" value="<? echo _Close_window ?>"  onclick="window.close();" />  
				  </div></td>
              </tr>
            
            </table>
      </form>    
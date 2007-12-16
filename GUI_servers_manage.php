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

if (! auth::isAdmin($userID)) {
	return;
}
	
require_once dirname(__FILE__)."/CL_server.php";
$servers=Server::getServers();

?>
<script language="javascript">
function serverAction(id,action,DBGlvl) {	 	
	//document.getElementById('takeoffBoxTitle').innerHTML = "Register Takeoff";	
// 	document.getElementById('addTakeoffFrame').src='<?=$moduleRelPath?>/GUI_EXT_server_action.php?id='+id+'&action='+action+'&DBGlvl='+DBGlvl;


	if (action==5) {
		var chunkSize=MWJ_findObj('chunkSize_'+id).value;
		var extraStr='&chunkSize='+chunkSize;
	} else if (action==9) {
		var chunkSize=MWJ_findObj('moveCounterBack_'+id).value;
		var extraStr='&moveCounterBack='+chunkSize;
	} else {
		var extraStr='';
	}
	document.getElementById('display_in_'+id).src='<?=$moduleRelPath?>/GUI_EXT_server_action.php?id='+id+'&action='+action+'&DBGlvl='+DBGlvl+extraStr;
	//MWJ_changeSize('addTakeoffFrame',410,320);
	//MWJ_changeSize( 'takeoffAddID', 410,350 );
	// toggleVisible('takeoffAddID','takeoffAddPos',14,0,410,320);
	MWJ_changeDisplay("display_"+id,"block");

}

function collapseAll() {
	for(i=0;i <100 ; i++) {
		MWJ_changeDisplay("action_"+i,"none");
	}
}

function expandAll() {
	for(i=0;i < 100 ; i++) {
		MWJ_changeDisplay("action_"+i,"block");
	}
}
</script>
<style type="text/css">

.actionsTable {
	display:none;
	border:1px solid #cccccc;
	padding:2px;
	background-color:#EEEAD2;
}

.actionsTable ul {
	margin-left:10px;
	padding:5px;
}

.actionRow1 {
	border:0;
	padding:0px;
	background-color:#D2DBEE;
}

.actionRow2 {
	border:0;
	padding:0px;
	background-color:#F2B6A4;
}


</style>
<? if (0) { ?>
<div id="takeoffAddID" class="dropBox takeoffOptionsDropDown" style="visibility:block;">
<table width="100%" >
<tr><td class="infoBoxHeader" >
<div align="left" style="display:block; float:left; clear:left;" id="takeoffBoxTitle">Server Info</div>
</td></tr></table>
<div id='addTakeoffDiv'>
<iframe id="addTakeoffFrame" width="100%" height="250" frameborder=0 style='border-width:0px'></iframe></div>
</div>
<? } ?>

<?
$legend="Manage external Servers";
echo  "<div class='tableTitle'>
<div class='titleDiv'>$legend <a href='javascript:collapseAll()'>Collapse All</a> <a href='javascript:expandAll()'>Expand All</a> </div>
</div>" ;

$i=0;

echo "<table class='main_text simpleTable' cellspacing=0 cellpadding=3><tr>";
echo "<th>ACTIONS</th><th>ID</th><th>URL</th><th>version</th><th>active</th><th>wpt exchange</th><th>isLeo</th><th>Type</th><th></th>";
echo "</tr>";
foreach ($servers as $server) {
	if ($server->installation_type==1) $type="phpNuke";
	else if ($server->installation_type==2) $type="phpBB";
	else if ($server->installation_type==3) $type="standalone";

	if ($server->gives_waypoints ) {
		$wpt="YES";
		if ( $server->waypoint_countries ) $wpt.=" (".$server->waypoint_countries.")";
	} else $wpt="NO";

	$url="<a href='http://".$server->url."' target='_blank'>".substr($server->url_base,0,50)."</a>";

//	echo "<td  >";
//	echo "";
//	echo "</td></tr>";

	$id=$server->ID;
	echo "<TR><td class='$actionRow' width='90' valign=top>

			<div align='left' ><a href='javascript:toggleVisibility(\"action_$id\")'>Actions <img src='$moduleRelPath/img/icon_arrow_down.gif' border=0></a></div>
			</td>".
			"<td valign=top>".$server->ID."</td>
			<td valign=top>".$url."</td>
			<td valign=top>".$server->leonardo_version."</td>
			<td valign=top> ".$server->is_active."</td>
			<td valign=top>".$wpt."</td>
			<td valign=top>".$server->isLeo."</td>
			<td valign=top>".$type."</td>
			<td valign=top></td>
		</tr>";

		echo "<TR height=0><td colspan='9' height=0 width=760>
			<div class='actionsTable' id='action_$id' width=100%><form name='syncForm'>
			<table width=100%>
				<tr>
					<TD><TABLE WIDTH=100% cellpadding=2 cellspacing=0 border=1 class='actionRow1'><TR>
						<td width=200  valign='top'><a href='javascript:serverAction(".$server->ID.",1,$DBGlvl);'>Info</a></td>
						<td width=100  valign='top'><a href='javascript:serverAction(".$server->ID.",2,$DBGlvl);'>Takeoffs</a></td>
						<td width=100 valign='top'><a href='javascript:serverAction(".$server->ID.",3,$DBGlvl);'>Flights</a></td>
						<td width=100 valign='top'><a href='javascript:serverAction(".$server->ID.",4,$DBGlvl);'>Update OP files</a></td>
						<td  valign='top'><a href='javascript:serverAction(".$server->ID.",99,$DBGlvl);'>Test</a>
						
					</TR></TD></TABLE>
				</tr>
				<tr>
					<TD><TABLE WIDTH=100% cellpadding=2 cellspacing=0 border=1 class='actionRow2'><TR>					
						<td width=150 valign='top'>
							<b><a href='javascript:serverAction(".$server->ID.",5,$DBGlvl);'>Sync (pull)</a></b>
							<input type=textbox id='chunkSize_$id' name='chunkSize_$id' value=10 size=3> entries
						</td>
						<td width=100 valign='top'><a href='javascript:serverAction(".$server->ID.",7,$DBGlvl);'>Guess Pilots</a></td>
						<td width=100 valign='top'><a href='javascript:serverAction(".$server->ID.",6,$DBGlvl);'>Delete all Flights</a></td>
						<td width=100 valign='top'><a href='javascript:serverAction(".$server->ID.",8,$DBGlvl);'>Delete all pilots</a></td>

						<td valign='top'><a href='javascript:serverAction(".$server->ID.",9,$DBGlvl);'>Move counter back</a>
								 <input type=textbox id='moveCounterBack_$id' name='moveCounterBack_$id' value=10 size=3> </td>
						<td width=30 valign='top'><a href='javascript:toggleVisibility(\"display_$id\")'>>></a></td>
					</TR></TD></TABLE>
				</tr>
	
				<TR >
				<td colspan='1' bgcolor='#ffffff' >
					<div style='display:none' id='display_$id' bgcolor='#ff0000'>
						<iframe id='display_in_$id' width='100%' height='250' frameborder=0 style='border-width:0px'></iframe>
					</div>
				</td>
				</tr>
				</table></form>
			</div>
			
		</td></tr>";			


		//	var $url_op;
		$i++;
}
echo "</table>";

?>
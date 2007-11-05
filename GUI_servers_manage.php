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
	document.getElementById('addTakeoffFrame').src='<?=$moduleRelPath?>/GUI_EXT_server_action.php?id='+id+'&action='+action+'&DBGlvl='+DBGlvl;
	//MWJ_changeSize('addTakeoffFrame',410,320);
	//MWJ_changeSize( 'takeoffAddID', 410,350 );
	// toggleVisible('takeoffAddID','takeoffAddPos',14,0,410,320);
}
</script>

<div id="takeoffAddID" class="dropBox takeoffOptionsDropDown" style="visibility:block;">
<table width="100%" >
<tr><td class="infoBoxHeader" >
<div align="left" style="display:block; float:left; clear:left;" id="takeoffBoxTitle">Server Info</div>
</td></tr></table>
<div id='addTakeoffDiv'>
<iframe id="addTakeoffFrame" width="100%" height="250" frameborder=0 style='border-width:0px'></iframe></div>
</div>


<?
$legend="Manage external Servers";
echo  "<div class='tableTitle'>
<div class='titleDiv'>$legend</div>
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

	echo "<TR><td><a href='javascript:serverAction(".$server->ID.",1,$DBGlvl);'>Info</a> :: 
<b><a href='javascript:serverAction(".$server->ID.",5,$DBGlvl);'>Sync (pull data)</a></b> ::
<a href='javascript:serverAction(".$server->ID.",2,$DBGlvl);'>Takeoffs</a> 
		:: <a href='javascript:serverAction(".$server->ID.",3,$DBGlvl);'>Flights</a> :: <a href='javascript:serverAction(".$server->ID.",4,$DBGlvl);'>Update OP files</a>
		:: <a href='javascript:serverAction(".$server->ID.",99,$DBGlvl);'>Test</a></td>".
			"<td>".$server->ID."</td><td>".$url."</td><td>".$server->leonardo_version."</td><td>".
			$server->is_active."</td><td>".$wpt."</td><td>".$server->isLeo."</td><td>".$type."</td><td></td></tr>";

//	var $url_op;
	$i++;
}
echo "</table>";

?>
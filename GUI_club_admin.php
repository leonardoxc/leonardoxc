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
// $Id: GUI_club_admin.php,v 1.11 2010/03/14 20:56:11 manolis Exp $                                                                 
//
//************************************************************************


if ( ! L_auth::isClubAdmin($userID,$clubID) && !L_auth::isAdmin($userID) ) { echo "go away"; return; }

$pilotsList=array();
$pilotsID=array();

//list($takeoffs,$takeoffsID)=getTakeoffList();
//list($countriesCodes,$countriesNames)=getCountriesList();

if ($_POST['formPosted']) {
//	$add_pilot_id=$_POST['add_pilot_id'];
	list($add_pilot_server_id,$add_pilot_id)=splitServerPilotStr($_POST['add_pilot_id']);

	$action=$_POST['AdminAction'];
	
	if ($add_pilot_id) $action="add_pilot";

	if ( $action=="add_pilot" ) {		
		$pilotName=getPilotRealName($add_pilot_id,$add_pilot_server_id);
		$resText="Pilot Name: $pilotName -> ";
		if ($pilotName) {
			$query="INSERT INTO $clubsPilotsTable (clubID,pilotID,pilotServerID) VALUES ($clubID,$add_pilot_id,$add_pilot_server_id )";
			$res= $db->sql_query($query);
			if($res <= 0){   
				$resText.="This pilot is already in the club";
			} $resText.="Pilot added ";
		} else {
			$resText.="No such pilot ID ";
		}
	} else if ( $action=="remove_pilot" ) {
		// $pilotToRemove=$_POST['pilotToRemove'];
		list($pilotToRemoveServerID,$pilotToRemove)=splitServerPilotStr($_POST['pilotToRemove']);
		$query="DELETE FROM $clubsPilotsTable WHERE clubID=$clubID AND pilotID=$pilotToRemove AND pilotServerID=$pilotToRemoveServerID ";
		$res= $db->sql_query($query);
		if($res <= 0){   
			$resText.="<H3> Error in removing pilot ! $query</H3>\n";
		} else $resText.="Pilot removed ";
	}
}

?>
<script language="javascript">


function addClubPilot() {
	// clubID,pilotID;
	document.clubAdmin.AdminAction.value="add_pilot";
	document.clubAdmin.submit();
/*
	url='/<?=$moduleRelPath?>/EXT_club_functions.php';
	pars='op=add_pilot&clubID='+clubID+'&flightID='+flightID;
	
	var myAjax = new Ajax.Updater('updateDiv', url, {method:'get',parameters:pars});

	newHTML="<a href=\"#\" onclick=\"removeClubFlight("+clubID+","+flightID+");return false;\"><img src='<?=$moduleRelPath?>/img/icon_club_remove.gif' width=16 height=16 border=0 align=bottom></a>";
	div=MWJ_findObj('fl_'+flightID);
	div.innerHTML=newHTML;
	
	//toggleVisible(divID,divPos);
*/
}

function removeClubPilot(pilotID) {
	document.clubAdmin.pilotToRemove.value=pilotID;
	document.clubAdmin.AdminAction.value="remove_pilot";
	document.clubAdmin.submit();
	/*
	url='/<?=$moduleRelPath?>/EXT_club_functions.php';
	pars='op=remove_pilot&clubID='+clubID+'&pilotID='+pilotID;
	
//	var myAjax = new Ajax.Updater('updateDiv', url, {method:'get',parameters:pars});

//	newHTML="<a href=\"#\" onclick=\"addClubFlight("+clubID+","+flightID+");return false;\"><img src='<?=$moduleRelPath?>/img/icon_club_add.gif' width=16 height=16 border=0 align=bottom></a>";
//	div=MWJ_findObj('pl_'+pilotID);
//	toggleVisible(div,divPos);
	MWJ_changeDisplay('pl_'+pilotID,"none");
//	div.innerHTML=newHTML;
	//toggleVisible(divID,divPos);
*/
}
</script>

<?
	$legend="Administer CLub/League";
	echo  "<div class='tableTitle'>
	<div class='titleDiv'>$legend</div>
	<div class='pagesDivSimple'>$legendRight</div>
	</div>" ;
	if ($resText) {
		echo "<div id='updateDiv' style='display:block; background-color:#EBE6DA;padding:5px; font-weight:bold;'>$resText</div>";
	}
?>
<form name="clubAdmin" method="post" action="">
<table width="100%" border="0" cellpadding="3" class="main_text">
  <tr>
    <td><p>
      <label>
        <input name="add_pilot_id" type="text" id="add_pilot_id" />
      </label>
      pilotID to add </p>
      <p>
        <label>
        <input name="Add pilot" type="button" id="Add pilot" value="Add pilot" onclick="javascript:addClubPilot();"/>
        </label>
      </p>
      <p><strong>Pilots in the club </strong></p>
      <?
  
	//echo "<BR>";
	//open_inner_table("Administer CLub/League",730,"icon_home.gif"); echo "<tr><td>";

	list($pilots,$pilotsID)=getPilotList($clubID);
	$i=0;
	foreach ($pilots as $pilotName ){
		$pilotID=$pilotsID[$i++];
		echo "<div id='pl_$pilotID'>$pilotName ($pilotID) : <a href='javascript:removeClubPilot(\"$pilotID\");'>Remove pilot</a></div>"; 
	}
?></td>
    <td><p>
      <label></label>
    </p>      </td>
  </tr>
</table>



<input name="formPosted" type="hidden" value="1" />
<input name="AdminAction" type="hidden" value="0" />
<input name="pilotToRemove" type="hidden" value="0" />

</form>

</div>
<?
//************************************************************************
// Leonardo XC Server, http://leonardo.thenet.gr
//
// Copyright (c) 2004-8 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: GUI_admin_pilot_map.php,v 1.10 2009/04/16 13:26:10 manolis Exp $                                                                 
//
//************************************************************************

 //test of pilot priority mapping
 /* 
 	require_once dirname(__FILE__).'/CL_logReplicator.php';
	 logReplicator::checkPilot(12,array(userID=>101678));
	exit; 
 */

	
  if ( !L_auth::isAdmin($userID) ) { echo "go away"; return; }
  
  $legend="Pilot Mapping Tables";
  openMain($legend,0,'');
  
  
	if ($_GET['moveFlights']) {
		$confirmMove=$_GET['confirmMoveFlights']+0;
		echo "MOVING ALL FLIGHTS FROM MAPPED EXTERNAL PILOTS TO THEIR LOCALY MAPPED ID<BR><BR>";
	
		if (!$confirmMove) {
			echo "The listing below is what will be moved. <a href='".CONF_MODULE_ARG."&op=admin_pilot_map&moveFlights=1&confirmMoveFlights=1'>***PRESS HERE TO CONFIRM ***</a><BR><BR>\n";
		}
		
		$compareField='hash';
		if (0) {
			$localServerOnlyClause=" AND  $remotePilotsTable.serverID  = 0 ";
		} else {
			$localServerOnlyClause=" AND  $remotePilotsTable.serverID  = 5 ";
		}
		
		$query="SELECT * , $remotePilotsTable.userID as localUserID, $remotePilotsTable.serverID as localServerID FROM $remotePilotsTable , $flightsTable WHERE 
					 $flightsTable.userID = $remotePilotsTable.remoteUserID AND 
					  $flightsTable.userServerID = $remotePilotsTable.remoteServerID  
					  $localServerOnlyClause
					ORDER BY remoteServerID ASC";
		 // echo "#count query#$query<BR>";
		$res= $db->sql_query($query);
		if($res <= 0){   
		 echo("<H3> Error in query: $query</H3>\n");
		 exit();
		}	

		echo "<pre>";
		echo "<table>";
		echo "<tr><td>#</td><td>FlightID</td><td>user</td><td>Name</td><td>localUser</td><td>Name</td></tr>\n";
		$i=1;
		while (	$row = $db->sql_fetchrow($res) ) {
			
			$pilotID1=$row['serverID'].'_'.$row['userID'];
			fillPilotInfo($pilotID1,$row['serverID'],$row['userID']);			
		
			$pilotID2=$row['localServerID'].'_'.$row['localUserID'];
			fillPilotInfo($pilotID2,$row['localServerID'],$row['localUserID']);
					
			echo "<tr><td>$i</td>
				<td><a href='".CONF_MODULE_ARG."&op=show_flight&flightID=".$row['ID']."'>".$row['ID']."</a></td>
				<td>".$pilotID1."</td>
			
			<td><a href='".CONF_MODULE_ARG."&op=list_flights&year=0&month=0&pilotID=$pilotID1'>".$pilotNames[$pilotID1]['lname']." ".$pilotNames[$pilotID1]['fname']." [ ".$pilotNames[$pilotID1]['country']." ] CIVLID: ".$pilotNames[$pilotID1]['CIVL_ID']."</td>
			<td>".$pilotID2."</td>		
			<td><a href='".CONF_MODULE_ARG."&op=list_flights&year=0&month=0&pilotID=$pilotID2'>".$pilotNames[$pilotID2]['lname']." ".$pilotNames[$pilotID2]['fname']." [ ".$pilotNames[$pilotID2]['country']." ] CIVLID: ".$pilotNames[$pilotID2]['CIVL_ID']."</td>
</tr>
		\n";
		
			// move the flight from one pilot to another:
			if ($confirmMove) {
				$flight2move=new flight();
				$flight2move->getFlightFromDB($row['ID']);
				$flight2move->changeUser($row['localUserID'],$row['localServerID']);
				if ($i>1000) {echo 'We are doing this in batches of 1000 , repeat unitil none left, exiting now !'; exit; }				
			}
			
			$i++;
		
		}		
		echo "</table><BR><BR>";
		echo "</pre>";
		closeMain();
		return;
	}
  	
//-----------------------------------------------------------------------------------------------------------
	
	
?>

<style type="text/css">
<!--
.mapTable td {padding:2px; }
.mapTable tr.alt  td { 	background-color:#FDFAEA; }
.mapTable tr.alt2 td { 	background-color:#FFFFFF; }

.mapTable td { border-bottom: 1px solid #CCCCCC; padding-bottom:4px; }

-->
</style>


<div id="stickyEl" style="position:fixed;bottom:0px;left:0px;z-index:3; background-color:#FFFFFF;width:250px;height:80px; display:none;">Results HERE</div>

<div id="pilotInfoDivExt" style=" position:absolute; display:none;background-color:#CCD2D9;width:750px;height:auto; padding:2px;">
<div align='right'><a href='javascript: hidePilotDiv()'>Close</a> </div>
<div id='updateDataDiv'></div>

<table><tr><td width="49%">
<div id="pilotInfoDiv1" style="position:relative; display:block;background-color:#EEECBF;width:100%;height:auto;">Results HERE</div>
</td><td width="49%">
<div id="pilotInfoDiv2" style=" position:relative;display:block;background-color:#EEECBF;width:100%;height:auto;">Results HERE</div>
</td></tr></table>
</div>

<script language="javascript">

function hidePilotDiv() {
	$("#pilotInfoDivExt").hide();
}

function getPilotsInfo(row_id,serverID1,pilotID1,serverID2,pilotID2) {

	$("#pilotInfoDivExt").css({
		left:$("#row_"+row_id).offset().left,
		top:$("#row_"+row_id).offset().top+16 					
	}).show();	
	
	$("#updateDataDiv").html("<a href='javascript: getPilotInfo("+serverID1+","+pilotID1+",\"pilotInfoDiv1\",1)'>Update Local DB</a>  \
:: <a href='javascript: getPilotInfo("+serverID1+","+pilotID1+",\"pilotInfoDiv1\",2)'>Update Local DB (delete all current data)</a>");

	getPilotInfo(serverID1,pilotID1,"pilotInfoDiv1",0) ;
	getPilotInfo(serverID2,pilotID2,"pilotInfoDiv2",0) ;

}

function getPilotInfo(serverID,pilotID,divName,update) {
    $("#"+divName).html("<img src='<?=$moduleRelPath?>/img/ajax-loader.gif'>").show();	
	$.get('<?=$moduleRelPath?>/EXT_pilot_functions.php',
		{ op:"getExternalPilotInfo","serverID":serverID,"pilotID":pilotID,"updateData":update}, 
		function(result){ 
			/*var jsonData = eval('(' + result + ')');
			
			var resStr='';
			for ( varName in jsonData['log'][0]['item'] ) {  
    			resStr+=varName+' : '+jsonData['log'][0]['item'][varName]+'<br>';  
			} */ 
			$("#"+divName).html(result).show();	
			$("#pilotInfoDivExt").show();	
			
		}
	);		
	
}

function showResults(textStr) {
  $("stickyEl").html(textStr); 
}

</script>



<?
	$query="SELECT *  FROM $remotePilotsTable ORDER BY remoteServerID,remoteUserID,serverID ASC";
	 // echo "#count query#$query<BR>";
	$res= $db->sql_query($query);
	if($res <= 0){   
	  echo("<H3> Error in query: $query</H3>\n");
	  exit();
	}	
	
	echo "<a href='".CONF_MODULE_ARG."&op=admin_pilot_map&moveFlights=1'>>> PRESS HERE TO MOVE ALL FLIGHTS FROM MAPPED EXTERNAL PILOTS TO THEIR LOCALY MAPPED ID</a><BR> By pressing the link above you will have the chance to review the flights before moving them to the local pilot ID";
	
	echo "<pre>";
	echo "<table class='mapTable'>";
	echo "<tr><td>#</td><td>Srv</td><td>UserID</td><td>Name</td><td>Cntry</td><td>CIVL</td>
			  <td></td><td>Srv</td><td>UserID</td><td>Name</td><td>Cntry</td><td>CIVL</td><td></td></tr>\n";
	$i=1;
	while (	$row = $db->sql_fetchrow($res) ) {
		$pilotID1=$row['serverID'].'_'.$row['userID'];
		fillPilotInfo($pilotID1,$row['serverID'],$row['userID']);			
		
		$pilotID2=$row['remoteServerID'].'_'.$row['remoteUserID'];
		fillPilotInfo($pilotID2,$row['remoteServerID'],$row['remoteUserID']);
		
		if ($i%2) $rowclass='alt';
		else $rowclass='alt2';
		
		echo "<tr class='$rowclass'><td id='row_$i'>$i</td>
			<td id='$pilotID1'>".$row['remoteServerID']."</td>		
			<td>".$row['remoteUserID']."</td>
			<td><a href='".CONF_MODULE_ARG."&op=list_flights&year=0&month=0&pilotID=$pilotID2'>".$pilotNames[$pilotID2]['lname']." ".$pilotNames[$pilotID2]['fname']."</td><td>".$pilotNames[$pilotID2]['country']."</td><td>".$pilotNames[$pilotID2]['CIVL_ID']."</td>
			<td> -> </td>
			<td id='$pilotID2'>".$row['serverID']."</td>
			<td>".$row['userID']."</td>
			
			<td><a href='".CONF_MODULE_ARG."&op=list_flights&year=0&month=0&pilotID=$pilotID1'>".$pilotNames[$pilotID1]['lname']." ".$pilotNames[$pilotID1]['fname']."</td><td> ".$pilotNames[$pilotID1]['country']."</td><td>".$pilotNames[$pilotID1]['CIVL_ID']."</td>";
			
			 echo "<td><a href='javascript:getPilotsInfo($i,".
			 $row['remoteServerID'].','.$row['remoteUserID'].','.
			 $row['serverID'].','.$row['userID'].")'>[INFO]</a></td>

</tr>
		\n";
		$i++;
	}
	echo "</table><BR><BR>";
	echo "</pre>";
	
	closeMain();
	return;

function fillPilotInfo($pilotID,$userServerID,$userID) {
	global $pilotNames,$CONF_use_utf;
	
	if ( ! $pilotNames[$pilotID]){
		$pilotInfo=getPilotInfo($userID,$userServerID );
		
		
		if (!$CONF_use_utf ) {
			$NewEncoding = new ConvertCharset;
			$lName=$NewEncoding->Convert($pilotInfo[0],$langEncodings[$nativeLanguage], "utf-8", $Entities);
			$fName=$NewEncoding->Convert($pilotInfo[1],$langEncodings[$nativeLanguage], "utf-8", $Entities);
		} else {
			$lName=$pilotInfo[0];
			$fName=$pilotInfo[1];
		}
		$pilotNames[$pilotID]['lname']=$lName;
		$pilotNames[$pilotID]['fname']=$fName;
		$pilotNames[$pilotID]['country']=$pilotInfo[2];
		$pilotNames[$pilotID]['sex']=$pilotInfo[3];
		$pilotNames[$pilotID]['birthdate']=$pilotInfo[4];
		$pilotNames[$pilotID]['CIVL_ID']=$pilotInfo[5];
		
		if ($pilotInfo[5]==-1) $pilotNames[$pilotID]['lname']="ERROR:NOT IN THE DB !!!";
	} 
	
}


?>
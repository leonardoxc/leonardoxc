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
// $Id: GUI_admin_pilot_map.php,v 1.9 2009/04/15 14:47:31 manolis Exp $                                                                 
//
//************************************************************************

 //test of pilot priority mapping
 /* 
 	require_once dirname(__FILE__).'/CL_logReplicator.php';
	 logReplicator::checkPilot(12,array(userID=>101678));
	exit; 
 */
 
  if ( !L_auth::isAdmin($userID) ) { echo "go away"; return; }
  

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
		return;
	}
  
	$compareField='hash';

	$query="SELECT *  FROM $remotePilotsTable ORDER BY remoteServerID,remoteUserID,serverID ASC";
	 // echo "#count query#$query<BR>";
	$res= $db->sql_query($query);
	if($res <= 0){   
	 echo("<H3> Error in query: $query</H3>\n");
	 exit();
	}	
	
//-----------------------------------------------------------------------------------------------------------
	
	$legend="Pilot Mapping Tables";
?>
<div id="stickyEl" style="position:fixed;bottom:0px;left:0px;z-index:3; background-color:#FFFFFF;width:250px;height:80px;">Results HERE</div>

<script type="text/javascript" src="<?=$moduleRelPath ?>/js/prototype.js"></script>
<script language="javascript">

function getPilotInfo(serverID,pilotID) {
	url='<?=$moduleRelPath?>/EXT_pilot_functions.php';
	pars='op=getExternalPilotInfo&serverID='+serverID+'&pilotID='+pilotID;
	var myAjax = new Ajax.Updater('stickyEl', url, {method:'get',parameters:pars});
	//div=MWJ_findObj(divID);
	// MWJ_changePosition('stickyEl',5,document.html.scrollTop+200);
	// div.style.top= document.documentElement.scrollTop+300+'px';
	
}

</script>

<script language="javascript" type="text/javascript" >

var ltop2=300;
var scrollSpeed2=20; //Screen refresh rate in msec.

function checkScrolled2() { //backTo Top link stays in lower right
  window.status=document.documentElement.scrollTop // show results
  document.getElementById('stickyEl').style.top =
      document.documentElement.scrollTop+ltop2+'px';
  setTimeout(checkScrolled2,scrollSpeed2) ;
}
  
function stickyInit(){
	showResults('Results Area');
	ltop2=parseInt(document.getElementById('stickyEl').style.top,10);
	checkScrolled2();
}

function showResults(textStr) {
  document.getElementById('stickyEl').innerHTML=textStr; 
}

 if (window.attachEvent) window.attachEvent("onload", stickyInit);
 stickyInit();
</script>  
<?
	echo  "<div class='tableTitle shadowBox'>
	<div class='titleDiv'>$legend</div>
	<div class='pagesDivSimple' style='white-space:nowrap'>$legendRight</div>
	</div>" ;

	echo "<BR><a href='".CONF_MODULE_ARG."&op=admin_pilot_map&moveFlights=1'>PRESS HERE TO MOVE ALL FLIGHTS FROM MAPPED EXTERNAL PILOTS TO THEIR LOCALY MAPPED ID</a>";
	
	echo "<pre>";
	echo "<table>";
	echo "<tr><td>#</td><td>Srv</td><td>UserID</td><td>Name</td><td></td><td>Srv</td><td>UserID</td><td>Name</td></tr>\n";
	$i=1;
	while (	$row = $db->sql_fetchrow($res) ) {
		$pilotID1=$row['serverID'].'_'.$row['userID'];
		fillPilotInfo($pilotID1,$row['serverID'],$row['userID']);			
		
		$pilotID2=$row['remoteServerID'].'_'.$row['remoteUserID'];
		fillPilotInfo($pilotID2,$row['remoteServerID'],$row['remoteUserID']);
		
		echo "<tr><td>$i</td>
			<td>".$row['remoteServerID']."</td>		
			<td>".$row['remoteUserID']."</td>
			<td><a href='".CONF_MODULE_ARG."&op=list_flights&year=0&month=0&pilotID=$pilotID2'>".$pilotNames[$pilotID2]['lname']." ".$pilotNames[$pilotID2]['fname']." [ ".$pilotNames[$pilotID2]['country']." ] CIVLID: ".$pilotNames[$pilotID2]['CIVL_ID']." <a href='javascript:getPilotInfo(\"".$row['remoteServerID'].','.$row['remoteUserID']."\")'>[INFO]</a></td>
			<td> -> </td>
			<td>".$row['serverID']."</td>
			<td>".$row['userID']."</td>
			
			<td><a href='".CONF_MODULE_ARG."&op=list_flights&year=0&month=0&pilotID=$pilotID1'>".$pilotNames[$pilotID1]['lname']." ".$pilotNames[$pilotID1]['fname']." [ ".$pilotNames[$pilotID1]['country']." ] CIVLID: ".$pilotNames[$pilotID1]['CIVL_ID']." <a href='javascript:getPilotInfo(\"$pilotID1\")'>[INFO]</a></td>

</tr>
		\n";
		$i++;
	}
	echo "</table><BR><BR>";
	echo "</pre>";
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
	} 
	
}
function printHeaderTakeoffs($width,$sortOrder,$fieldName,$fieldDesc,$query_str) {
  global $moduleRelPath;
  global $Theme;

  if ($width==0) $widthStr="";
  else  $widthStr="width='".$width."'";

  if ($fieldName=="intName") $alignClass="alLeft";
  else $alignClass="";

  if ($sortOrder==$fieldName) { 
   echo "<td $widthStr  class='SortHeader activeSortHeader $alignClass'>
			<a href='".CONF_MODULE_ARG."&op=admin_logs&sortOrder=$fieldName$query_str'>$fieldDesc<img src='$moduleRelPath/img/icon_arrow_down.png' border=0  width=10 height=10></div>
		</td>";
  } else {  
	   echo "<td $widthStr  class='SortHeader $alignClass'><a href='".CONF_MODULE_ARG."&op=admin_logs&sortOrder=$fieldName$query_str'>$fieldDesc</td>";
   } 
}

  
   $headerSelectedBgColor="#F2BC66";

  ?>
  <table class='simpleTable' width="100%" border=0 cellpadding="2" cellspacing="0">
  <tr>
  	<td width="25" class='SortHeader'>#</td>
 	<?
		printHeaderTakeoffs(100,$sortOrder,"actionTime","DATE",$query_str) ;
		printHeaderTakeoffs(0,$sortOrder,"ServerItemID","Server",$query_str) ;
		printHeaderTakeoffs(80,$sortOrder,"userID","userID",$query_str) ;

		printHeaderTakeoffs(100,$sortOrder,"ItemType","Type",$query_str) ;
		printHeaderTakeoffs(100,$sortOrder,"ItemID","ID",$query_str) ;
		printHeaderTakeoffs(100,$sortOrder,"ActionID","Action",$query_str) ;
		echo '<td width="100" class="SortHeader">Details</td>';
		printHeaderTakeoffs(100,$sortOrder,"Result","Result",$query_str) ;
		echo '<td width="100" class="SortHeader">ACTIONS</td>';
		
	?>
	
	</tr>
<?
   	$currCountry="";
   	$i=1;
	while ($row = $db->sql_fetchrow($res)) {  
		if ( L_auth::isAdmin($row['userID'])  ) $admStr="*ADMIN*";
		else $admStr="";

		if ($row['ServerItemID']==0) $serverStr="Local";
		else $serverStr=$row['ServerItemID'];
		
		$i++;
		echo "<TR class='$sortRowClass'>";	
	   	echo "<TD>".($i-1+$startNum)."</TD>";
		
		echo "<td>".date("d/m/y H:i:s",$row['actionTime'])."</td>\n";
		echo "<td>".$serverStr."</td>\n";
		echo "<td>".$row['userID']."$admStr<br>(".$row['effectiveUserID'].")</td>\n";
		echo "<td>".Logger::getItemDescription($row['ItemType'])."</td>\n";
		echo "<td>".$row['ItemID']."</td>\n";
		echo "<td>".Logger::getActionDescription($row['ActionID'])."</td>\n";
		echo "<td>";

		echo "<div id='sh_details$i'><STRONG><a href='javascript:toggleVisibility(\"details$i\");'>Show details</a></STRONG></div>";
			echo "<div id='details$i' style='display:none'><pre>".$row['ActionXML']."</pre></div>";
		echo "</td>\n";
		echo "<td>".$row['Result']."</td>\n";
		
		echo "<td>";
		if ($row['ItemType']==4) { // waypoint
				echo "<a href='".CONF_MODULE_ARG."&op=show_waypoint&waypointIDview=".$row['ItemID']."'>Display</a>";
		}
		
		echo "</td>\n";

		
		echo "</TR>";
   }     
   echo "</table>";
   $db->sql_freeresult($res);

?>
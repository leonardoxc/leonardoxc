<? 
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://sourceforge.net/projects/leonardoserver                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
//************************************************************************/
 
  if ( !L_auth::isAdmin($userID) ) { echo "go away"; return; }
  
  ?>
  
<script type="text/javascript" src="<?=$moduleRelPath ?>/js/prototype.js"></script>
<script language="javascript">

function mapPilot(divID,pilotID1,pilotID2) {
	url='<?=$moduleRelPath?>/EXT_pilot_functions.php';
	pars='op=mapPilot&pilotID1='+pilotID1+'&pilotID2='+pilotID2;
	
	var myAjax = new Ajax.Updater('updateDiv', url, {method:'get',parameters:pars});

	// newHTML="<a href=\"#\" onclick=\"removeClubFlight("+clubID+","+flightID+");return false;\"><?=$removeFromClubIcon?></a>";
	
	div=MWJ_findObj(divID);
	div.innerHTML='';

	//toggleVisible(divID,divPos);
}

</script>
  <?
  
  // first get the mappings
  $query="SELECT *  FROM $remotePilotsTable ";
  // echo "#count query#$query<BR>";
	$res= $db->sql_query($query);
	if($res <= 0){   
	 echo("<H3> Error in count items query! $query0</H3>\n");
	 exit();
	}	
	while (	$row = $db->sql_fetchrow($res) ) {
		$pilotID1=$row['serverID'].'_'.$row['userID'];
		$pilotID2=$row['remoteServerID'].'_'.$row['remoteUserID'];
		// only remote -> local 
		//$pilotMappingTable[$pilotID1]=$pilotID2;
		
		$pilotMappingTable[$pilotID2][$pilotID1]++;
	}		
  
	$compareField='hash';

	$query0="SELECT $compareField, count( $compareField) AS num FROM $flightsTable GROUP BY $compareField HAVING count( $compareField) >1  AND $compareField<>'' ORDER BY num DESC";
	 // echo "#count query#$query<BR>";
	$res0= $db->sql_query($query0);
	if($res0 <= 0){   
	 echo("<H3> Error in count items query! $query0</H3>\n");
	 exit();
	}	
	
//-----------------------------------------------------------------------------------------------------------
	
	$legend="Duplicate Flights";

	echo  "<div class='tableTitle shadowBox'>
	<div class='titleDiv'>$legend</div>
	<div class='pagesDiv' style='white-space:nowrap'>$legendRight</div>
	</div>" ;
	
	echo "<div id='updateDiv' style='display:block'>Result</div>";
		
	echo "<pre>";
	$i=0;
while ($row0 = $db->sql_fetchrow($res0)) {  
	$outStr="<b>".$row0[$compareField].': '.$row0['num'].'</b><hr>';
	$query="SELECT * FROM $flightsTable WHERE $compareField='".$row0[$compareField]."'";
	 // echo "#count query#$query<BR>";
	$res= $db->sql_query($query);
	if($res <= 0){   
	 echo("<H3> Error in query! $query</H3>\n");
	 exit();
	}
	
	$output2screen=false;
	
	$outStr.="<table>";
	$outStr.="<tr><td>Flight</td><td>serverID</td><td>orgID</td><td>PilotID</td><td>Pilot</td></tr>\n";

	$suggestedMappings=array();

	$pilots=array();
	$k=0;
	while (	$row = $db->sql_fetchrow($res) ) {
		$pilotID=$row['userServerID'].'_'.$row['userID'];
		$pilots[$pilotID]['serverID']=$row['userServerID'];
		$pilots[$pilotID]['userID']=$row['userID'];
		
		if ( ! $pilotNames[$pilotID]){
			$pilotInfo=getPilotInfo($row['userID'],$row['userServerID'] );
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
		
		$outStr.="<tr><td>ID: <a href='".CONF_MODULE_ARG."&op=show_flight&flightID=".$row['ID']."'>".$row['ID']."</a></td>
<td>".$row['serverID']."</td>
<td>".$row['original_ID']."</td>		
<td>$pilotID</td>
			<td><a href='".CONF_MODULE_ARG."&op=list_flights&year=0&month=0&pilotID=$pilotID'>".$pilotNames[$pilotID]['lname']." ".$pilotNames[$pilotID]['fname']." [ ".$pilotNames[$pilotID]['country']." ] CIVLID: ".$pilotNames[$pilotID]['CIVL_ID']."</td>
</tr>
		\n";
		$k++;
	}
	
	$outStr.= "</table>";
	
	$outStr.="Suggested Mappings: <BR>";
	$j=1;
	foreach($pilots as $pilotID1=>$pData1) {
		foreach($pilots as $pilotID2=>$pData2) {
			if ($pData1['serverID'] > $pData2['serverID'] ) {
				$div_id=$i.'_'.$j;
				$outStr.="<div id='map_$div_id'>$j : <a href='javascript:mapPilot(\"map_$div_id\",\"$pilotID1\",\"$pilotID2\")'>$pilotID1 <-> $pilotID2</a>";
				if ($pilotMappingTable[$pilotID2][$pilotID1] || $pilotMappingTable[$pilotID1][$pilotID2] ) {
					$outStr.= " * ALREADY MAPPED * ";
				} else { 
					$output2screen=true;
				}
				$outStr.=" </div>";
				$j++;
			}
		}		
	}
	//print_r($pilots);
	$outStr.="<BR><BR>";
	if ($output2screen) {
		echo $outStr;
	}
	$i++;
}
echo "</pre>";
return;

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
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
// $Id: GUI_admin_takeoffs.php,v 1.9 2010/03/14 20:56:11 manolis Exp $                                                                 
//
//************************************************************************

  if ( !L_auth::isAdmin($userID) ) { echo "go away"; return; }
  
 ?>
 <script language="javascript">

function edit_takeoff(id) {	 
	// takeoffTip.hide();
	 document.getElementById('takeoffBoxTitle').innerHTML = "Change Takeoff";		 
 	 document.getElementById('addTakeoffFrame').src='<?=$moduleRelPath?>/GUI_EXT_waypoint_edit.php?waypointIDedit='+id;
	 MWJ_changeSize('addTakeoffFrame',410,320);
	 MWJ_changeSize( 'takeoffAddID', 410,350 );
	 toggleVisible('takeoffAddID','takeoffAddPos',14,0,410,320);
 }

function delete_takeoff(id) {	 
	// takeoffTip.hide();
	 document.getElementById('takeoffBoxTitle').innerHTML = "Delete Takeoff";		 
 	 document.getElementById('addTakeoffFrame').src='<?=$moduleRelPath?>/GUI_EXT_waypoint_delete.php?waypointIDdelete='+id;
	 MWJ_changeSize('addTakeoffFrame',410,220);
	 MWJ_changeSize( 'takeoffAddID', 410,250 );
	 toggleVisible('takeoffAddID','takeoffAddPos',14,0,410,220);
 }

</script>
<style type="text/css">
.dropBox {
	display:block;
	position:absolute;

	top:0px;
	left: -999em;
	width:auto;
	height:auto;
	
	visibility:hidden;

	border-style: solid; 
	border-right-width: 2px; border-bottom-width: 2px; border-top-width: 1px; border-left-width: 1px;
	border-right-color: #999999; border-bottom-color: #999999; border-top-color: #E2E2E2; border-left-color: #E2E2E2;
	border-right-color: #555555; border-bottom-color: #555555; border-top-color: #E2E2E2; border-left-color: #E2E2E2;
	
	background-color:#FFFFFF;
	padding: 1px 1px 1px 1px;
	margin-bottom:0px;

}
.googleEarthDropDown { width:170px; }
.takeoffOptionsDropDown {width:410px; }

</style>

<div id="takeoffAddPos"></div>

 <div id="takeoffAddID" class="dropBox takeoffOptionsDropDown" style="visibility:hidden;">
	<table width="100%" cellpadding="0" cellspacing="0">
	<tr><td class="infoBoxHeader" style="width:725px;" >
	<div align="left" style="display:inline; float:left; clear:left;" id="takeoffBoxTitle">Register Takeoff</div>
	<div align="right" style="display:inline; float:right; clear:right;">
	<a href='#' onclick="toggleVisible('takeoffAddID','takeoffAddPos',14,-20,0,0);return false;"><img src='<? echo $moduleRelPath."/templates/".$PREFS->themeName ?>/img/exit.png' border=0></a></div>
	</td></tr></table>
	<div id='addTakeoffDiv'>
		<iframe name="addTakeoffFrame" id="addTakeoffFrame" width="700" height="320" frameborder=0 style='border-width:0px'></iframe>
	</div>
</div>
 <?
  $sortOrder=makeSane($_REQUEST["sortOrder"]);
  if ( $sortOrder=="")  $sortOrder="actionTime";

  //$page_num=$_REQUEST["page_num"]+0;
  //if ($page_num==0)  $page_num=1;

//-----------------------------------------------------------------------------------------------------------

  	$query="SELECT * FROM $waypointsTable ,$logTable 
			WHERE $logTable.ItemType=4 AND $logTable.itemID=$waypointsTable.ID
			ORDER BY $sortOrder DESC ";	
    // echo $query;
	$res= $db->sql_query($query);		
    if($res <= 0){
		echo "no log entries / takaeoffs found<br>";
		return ;
    }

	$legend="Manage Takeoffs";
	$legendRight="";
   echo  "<div class='tableTitle shadowBox'>
   <div class='titleDiv'>$legend</div>
   <div class='pagesDivSimple'>$legendRight</div>
   </div>" ;

function printHeaderTakeoffs($width,$sortOrder,$fieldName,$fieldDesc,$query_str) {
  global $moduleRelPath;
  global $Theme;

  if ($width==0) $widthStr="";
  else  $widthStr="width='".$width."'";

  if ($fieldName=="intName") $alignClass="alLeft";
  else $alignClass="";

  if ($sortOrder==$fieldName) { 
   echo "<td $widthStr  class='SortHeader activeSortHeader $alignClass'>
			<a href='".CONF_MODULE_ARG."&op=admin_takeoffs&sortOrder=$fieldName$query_str'>$fieldDesc<img src='$moduleRelPath/img/icon_arrow_down.png' border=0  width=10 height=10></div>
		</td>";
  } else {  
	   echo "<td $widthStr  class='SortHeader $alignClass'><a href='".CONF_MODULE_ARG."&op=admin_takeoffs&sortOrder=$fieldName$query_str'>$fieldDesc</td>";
   } 
}

  
   $headerSelectedBgColor="#F2BC66";

  ?>
  <table class='simpleTable' width="100%" border=0 cellpadding="2" cellspacing="0">
  <tr>
  	<td width="25" class='SortHeader'>#</td>
 	<?
		printHeaderTakeoffs(120,$sortOrder,"actionTime","DATE",$query_str) ;
		printHeaderTakeoffs(0,$sortOrder,"userID","userID",$query_str) ;
		printHeaderTakeoffs(40,$sortOrder,"ActionID","Action",$query_str) ;


		echo '<td width="300" class="SortHeader">Name</td>';
		echo '<td width="50" class="SortHeader">Details</td>';
		echo '<td width="200" class="SortHeader">ACTIONS</td>';
		
	?>
	
	</tr>
<?
	$takeoffs=array();
	while ($row = $db->sql_fetchrow($res)) {  
		$takeoffID=$row['ItemID'];
		$takeoffs[$takeoffID][$row['actionTime']]['ActionID']=$row['ActionID'];
		$takeoffs[$takeoffID][$row['actionTime']]['userID']=$row['userID'];
		$takeoffs[$takeoffID][$row['actionTime']]['intName']=$row['intName'];
		$takeoffs[$takeoffID][$row['actionTime']]['intLocation']=$row['intLocation'];
		$takeoffs[$takeoffID][$row['actionTime']]['countryCode']=$row['countryCode'];
		$takeoffs[$takeoffID][$row['actionTime']]['ActionXML']=$row['ActionXML'];
		
	}
   	
   	$i=1;
	foreach($takeoffs as $takeoffID=>$takeoff ) {
	
		echo "<tr><td colspan=7><strong>$takeoffID</strong></td><tr>";
		foreach($takeoff as $actionTime=>$details ) {
	
			if ( L_auth::isAdmin($details['userID'])  ) $admStr="*ADMIN*";
			else $admStr="";

			
			$i++;
			echo "<TR class='$sortRowClass'>";	
			echo "<TD>".($i-1+$startNum)."</TD>";
			
			echo "<td>".date("d/m/y H:i:s",$actionTime)."</td>\n";
			echo "<td>".$details['userID']."$admStr</td>\n";
			echo "<td>".Logger::getActionDescription($details['ActionID'])."</td>\n";
			
			echo "<td>".$details['intName']." (".$details['intLocation'].") [".$details['countryCode']."]</td>\n";

			echo "<td>";
			echo "<div id='sh_details$i'><STRONG><a href='javascript:toggleVisibility(\"details$i\");'>Details</a></STRONG></div>";
				echo "<div id='details$i' style='display:none'><pre>".$details['ActionXML']."</pre></div>";
			echo "</td>\n";
			
			echo "<td>";
					echo "<a href='".CONF_MODULE_ARG."&op=show_waypoint&waypointIDview=".takeoffID."'>Display</a> :: ";
					echo "<a href='".CONF_MODULE_ARG."&op=list_flights&takeoffID=$takeoffID&year=0&month=0&pilotID=0&country=0&cat=0'>Flights</a> :: ";
					echo "<a href='javascript:edit_takeoff($takeoffID)'>Edit</a> :: ";		
					echo "<a href='javascript:delete_takeoff($takeoffID)'>Del</a>";		
			echo "</td>\n";
	
			
			echo "</TR>";
		}
   }     
   echo "</table>";
   $db->sql_freeresult($res);

?>
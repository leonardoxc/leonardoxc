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
//************************************************************************/

 
	if ( !is_leo_admin($userID) ) { echo "Go away"; return; }
	
	$airspaceDir=dirname(__FILE__).'/data/airspace';
	
	
	$legend="Administer airspace files ";
	$legendRight="";
	echo  "<div class='tableTitle shadowBox'>
	<div class='titleDiv'>$legend</div>
	<div class='pagesDiv'>$legendRight</div>
	</div>" ;
	
	
	if ($_GET['act']=='delete_all') {
		DEBUG('AdminAirspace',1,"Deleting all airspace from DB<BR>");
		
		$query="TRUNCATE TABLE $airspaceTable	";
		$res= $db->sql_query($query);
		if(!$res ){
			echo "<BR><BR>Problem in Deleting all airspace from DB<BR><BR>";
		} else {
			echo "<BR><BR>All Airspace entries were deleted from DB<BR><BR>";
		}
		
	} else if ($_GET['act']=='check_flights') {	
	
		DEBUG('AdminAirspace',1,"Checking all flights for airspace violations<BR>");
		echo "Checking all flights for airspace violations<BR>";
		$query="SELECT ID,active from $flightsTable  WHERE airspaceCheck=0 OR airspaceCheckFinal=0 ";
		$res= $db->sql_query($query);
			
		if($res > 0){
			 echo "<br><br>";
			 $flight=new flight();
			 $i=0;
			 while ($row = mysql_fetch_assoc($res)) { 
				 // $flight=new flight();
				 $flight->getFlightFromDB($row["ID"]);		
				 if (! is_file( $flight->getIGCFilename() ) ) {
					 echo "[".$row['ID']."] IGC not found<BR>";		
				 } else {
					echo "[".$row['ID']."] ";
					flush2Browser();
					$flight->checkAirspace(1);
					echo " Checked: ".$flight->airspaceCheckMsg."<BR>";
					flush2Browser();
					
				 }
				$i++;
				if ($i>10) break;
			 }
		}
		echo "<BR><br><BR>DONE !!!<BR>";
	} else if ($_GET['importFile']) {
	
		$fileToImport=$_GET['importFile'];
		DEBUG('AdminAirspace',1,"Importing file $fileToImport<BR>");
		require_once dirname(__FILE__).'/FN_airspace_admin.php';
		
		ReadAirspace($airspaceDir.'/'.$fileToImport);
		if (!putAirspaceToDB()) {
			echo "<BR><BR>Problem in Importing airspace to DB<BR><BR>";
		}
	}
?>
 <table class='simpleTable' width="100%" border=0 cellpadding="2" cellspacing="0">
   <tr>
     <td colspan="3"><strong>Actions :: <a href="?name=<?=$module_name?>&op=admin_airspace&act=delete_all">Delete all airspace entries in the DB</a> :: 
	  <a href="?name=<?=$module_name?>&op=admin_airspace&act=check_flights">Check all (unchecked) flights</a></strong></td>
   </tr>
   <tr>
     <td colspan="3">&nbsp;</td>
   </tr>
   <tr>
     <td colspan="3"><strong>Available airspace files.</strong></td>
   </tr>
  
<?
    $current_dir = opendir($airspaceDir);
	while($entryname = readdir($current_dir )){
		
		$fname="$airspaceDir/$entryname";
		if( ! is_dir($fname) && ( strtolower(substr($fname,-4)) == ".txt" ) ){		
		  echo  '<tr>';
		  echo "<td>$entryname</td><td><a href='?name=$module_name&op=admin_airspace&importFile=$entryname'>Update / Import airspace into DB</a></td><td>&nbsp;</td>";
		  echo '</tr>';
		}
	

	}
?>
</table>
<br /><BR />
<hr />
<strong>Disabled Areas</strong><BR />
<script language="javascript">
function update_comment(area_id) {	 	
	document.getElementById('addTakeoffFrame').src='modules/<?=$module_name?>/GUI_EXT_airspace_update_comment.php?area_id='+area_id;
	MWJ_changeSize('addTakeoffFrame',270,105);
	MWJ_changeSize( 'takeoffAddID', 270,130 );
	toggleVisible('takeoffAddID','takeoffAddPos'+area_id,14,-50,410,320);
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
</style>
<div id="takeoffAddID" class="dropBox takeoffOptionsDropDown" style="visibility:hidden;">
	<table width="100%" cellpadding="0" cellspacing="0">
	<tr><td class="infoBoxHeader" style="width:725px;" >
	<div align="left" style="display:inline; float:left; clear:left;" id="takeoffBoxTitle">Update Comment</div>
	<div align="right" style="display:inline; float:right; clear:right;">
	<a href='#' onclick="toggleVisible('takeoffAddID','takeoffAddPos',14,-20,0,0);return false;"><img src='<? echo $moduleRelPath."/templates/".$PREFS->themeName ?>/img/exit.png' border=0></a></div>
	</td></tr></table>
	<div id='addTakeoffDiv'>
		<iframe name="addTakeoffFrame" id="addTakeoffFrame" width="700" height="320" frameborder=0 style='border-width:0px'></iframe>
	</div>
</div> 
<?
	$query="SELECT * FROM $airspaceTable WHERE disabled=1";		 
	$res= $db->sql_query($query);
		
	if(!$res) {
		echo "Error in getting disabled airspaces from DB: $query <BR>";
		return 0;
	}

	$i=0;
	while ($row = mysql_fetch_assoc($res)){
		$base=unserialize($row['Base']);
		$top=unserialize($row['Top']);
		echo " [ <a id='takeoffAddPos".$row['id']."' href='javascript:update_comment(".$row['id'].");'>Edit/activate</a> ] ";
		echo $row['Name']." [".$row['Type']."] (".floor($base->Altitude)."m - ".floor($top->Altitude)."m)- COMMENT: ".$row['Comments']."<BR>";


	}

?>
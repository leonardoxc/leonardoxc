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

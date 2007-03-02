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

$areaID=makeSane($_GET['areaID'],1);

$pilotsList=array();
$pilotsID=array();
list($pilotsList,$pilotsID)=getPilotList();
list($takeoffs,$takeoffsID)=getTakeoffList();
list($countriesCodes,$countriesNames)=getCountriesList();

if ( $_REQUEST["addTakeoffForm"] ) { // form submitted

	$takeoffToAdd=$_POST['takeoff_select']+0;
	
	$query="INSERT INTO $areasTakeoffsTable	(areaID,takeoffID) VALUES ($areaID,$takeoffToAdd)" ;
	// echo $query;
	$res= $db->sql_query($query);		
    if($res <= 0){
		echo "Problem in inserting takeoff to area";		
    } else {
		echo "Takeoff added to area<br>";
	}
	
} else { // form not submitted
	// copy session variables (if any) to local variables
		
}

 
 open_inner_table("Administer Area (group of takeoffs)",700); echo "<tr><td>";
?>

<form name="formFilter" method="post" action="">
  <br>
  <table class=main_text width="564"  border="0" align="center" cellpadding="1" cellspacing="1">
    <tr> 
      <td width="205" bgcolor="#FF9966"><div align="right"><span class="whiteLetter"><strong><? echo _SELECT_TAKEOFF ?></strong></span></div></td>
      <td width="352"><select name="takeoff_select" id="takeoff_select">
        <option></option>
        <? 
					for($k=0;$k<count($takeoffs);$k++) {
 					    $sel=($takeoffsID[$k]==$FILTER_takeoff1_select)?"selected":"";
						echo "<option value='".$takeoffsID[$k]."' $sel>".$takeoffs[$k]."</option>\n";
					}
				?>
      </select></td>
    </tr>
    <tr> 
      <td><div align="right"></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="2"><div align="center"> 
          <input type="submit" name="SubmitButton" id="SubmitButton" value="<? echo _ADD_TAKEOFF_TO_AREA ?>">
		  <input type="hidden" name="addTakeoffForm" value="1" />
          &nbsp; 

      </div></td>
    </tr>
  </table>
 
  
</form>
<table>
<?

  list($takeoffs,$takeoffsID)=getAreasTakeoffs($areaID);

  $i=0;
  foreach ($takeoffs as $name) {
	  $takeoffID=$takeoffsID[$i];
	  echo "<tr><td>$name</td><td><a href='GUI_area_remove_takeoff?areaId=$areaID&takeoffID=$takeoffID'>remove Takeoff from area</a></td></tr><br>";
	  $i++;
  }
  
?>
  </table>
<?
  close_inner_table();  

?>

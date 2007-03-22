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
/************************************************************************/

if ( !in_array($userID,$admin_users) ) { echo "go away"; return; }

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
 if ($_REQUEST["FILTER_dateType"])  { 
	echo "<center><a href='?name=".$module_name."&op=list_flights'>"._RETURN_TO_FLIGHTS."</a> :: </center><br><br>";
	// echo "<a href='$filterUrl'>Bookmark Filter</a><br></center><br><br>";
 }

?>

<form name="formFilter" method="post" action="">
  <br>
  <table class=main_text width="564"  border="0" align="center" cellpadding="1" cellspacing="1">
    <tr> 
      <td width="205" bgcolor="#FF9966"><div align="right"><span class="whiteLetter"><strong><? echo _SELECT_PILOT ?></strong></span></div></td>
      <td width="352">&nbsp;</td>
    </tr>
    <tr> 
      <td><div align="right"><? echo _THE_PILOT ?> </div></td>
      <td> <script language="JavaScript">
		function setVal(value1)
		{
			if (value1=='=') { 
				document.formFilter.FILTER_pilot2_select_pretext.value = '<? echo _OR ?>';
				document.formFilter.FILTER_pilot2_select_op.value = '<? echo _IS ?>';
				document.formFilter.FILTER_pilot3_select_pretext.value = '<? echo _OR ?>';
				document.formFilter.FILTER_pilot3_select_op.value = '<? echo _IS ?>';
			} else {
				document.formFilter.FILTER_pilot2_select_pretext.value = '<? echo _AND ?>';
				document.formFilter.FILTER_pilot2_select_op.value = '<? echo _IS_NOT ?>';
				document.formFilter.FILTER_pilot3_select_pretext.value = '<? echo _AND ?>';
				document.formFilter.FILTER_pilot3_select_op.value = '<? echo _IS_NOT ?>';
			}
		}

		function setVal2(value1)
		{
			if (value1=='=') { 
				document.formFilter.FILTER_takeoff2_select_pretext.value = '<? echo _OR ?>';
				document.formFilter.FILTER_takeoff2_select_op.value = '<? echo _IS ?>';
				document.formFilter.FILTER_takeoff3_select_pretext.value = '<? echo _OR ?>';
				document.formFilter.FILTER_takeoff3_select_op.value = '<? echo _IS ?>';
			} else {
				document.formFilter.FILTER_takeoff2_select_pretext.value = '<? echo _AND ?>';
				document.formFilter.FILTER_takeoff2_select_op.value = '<? echo _IS_NOT ?>';
				document.formFilter.FILTER_takeoff3_select_pretext.value = '<? echo _AND ?>';
				document.formFilter.FILTER_takeoff3_select_op.value = '<? echo _IS_NOT ?>';
			}
		}		

		function setVal3(value1)
		{
			if (value1=='=') { 
				document.formFilter.FILTER_country2_select_pretext.value = '<? echo _OR ?>';
				document.formFilter.FILTER_country2_select_op.value = '<? echo _IS ?>';
				document.formFilter.FILTER_country3_select_pretext.value = '<? echo _OR ?>';
				document.formFilter.FILTER_country3_select_op.value = '<? echo _IS ?>';
			} else {
				document.formFilter.FILTER_country2_select_pretext.value = '<? echo _AND ?>';
				document.formFilter.FILTER_country2_select_op.value = '<? echo _IS_NOT ?>';
				document.formFilter.FILTER_country3_select_pretext.value = '<? echo _AND ?>';
				document.formFilter.FILTER_country3_select_op.value = '<? echo _IS_NOT ?>';
			}
		}		
		</script>
		  <select name="FILTER_pilot1_select" id="FILTER_pilot1_select">
          <option></option>
          <? 
					for($k=0;$k<count($pilotsList);$k++) {
						$sel=($pilotsID[$k]==$FILTER_pilot1_select)?"selected":"";
						echo "<option value='".$pilotsID[$k]."' $sel>".$pilotsList[$k]."</option>\n";
					}
				?>
        </select> </td>
    </tr>
    <tr> 
      <td bgcolor="#FF9966"><div align="right"><span class="whiteLetter"><strong><? echo _SELECT_TAKEOFF ?></strong></span></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td><div align="right"><? echo _THE_TAKEOFF ?> </div></td>
      <td><select name="takeoff_select" id="takeoff_select">
          <option></option>
          <? 
					for($k=0;$k<count($takeoffs);$k++) {
 					    $sel=($takeoffsID[$k]==$FILTER_takeoff1_select)?"selected":"";
						echo "<option value='".$takeoffsID[$k]."' $sel>".$takeoffs[$k]."</option>\n";
					}
				?>
        </select> </td>
    </tr>
<tr> 
      <td bgcolor="#FF9966"><div align="right"><span class="whiteLetter"><strong><? echo _SELECT_COUNTRY ?></strong></span></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td><div align="right"><? echo _THE_COUNTRY  ?> </div></td>
      <td><select name="FILTER_country1_select" id="FILTER_country1_select">
          <option></option>
          <? 
					for($k=0;$k<count($countriesCodes);$k++) {
 					    $sel=($countriesCodes[$k]==$FILTER_country1_select)?"selected":"";
						echo "<option value='".$countriesCodes[$k]."' $sel>".$countriesNames[$k]." (".$countriesCodes[$k].")</option>\n";
					}
				?>
        </select> </td>
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
  <p>&nbsp;</p>
  
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

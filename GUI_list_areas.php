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

require_once dirname(__FILE__).'/CL_area.php';
  
$areaID=makeSane($_GET['areaID'],1);


open_inner_table("Flying Areas",730,'icon_takeoff.gif'); echo "<tr><td>";
  
?>

  <table class=main_text width="564"  border="0" align="center" cellpadding="3" cellspacing="1">
    <tr> 
      <td>Name of Area</td>
	  <td>&nbsp;</td>
   </tr>
<? 
	$query="SELECT * FROM $areasTable WHERE areaType=0 ORDER BY name";
	// echo $query;
	$res= $db->sql_query($query);		
	if($res <= 0){
		echo "No areas found <BR>";
	}
	
	while ($row = $db->sql_fetchrow($res)) { 
		echo "<tr> 
      <td>".$row['name']."</td>
	  <td> ";	  
	  echo "<a href='".CONF_MODULE_ARG."&op=area_show&areaID=".$row['ID']."'>See the details and takeoffs for this area</a>";	
	  echo "</td></tr> \n";

	}
	
	echo "</table>";
	close_inner_table();  
	return;

?>
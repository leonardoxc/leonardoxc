<?
//************************************************************************
// Leonardo XC Server, https://github.com/leonardoxc/leonardoxc
//
// Copyright (c) 2004-2010 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: GUI_list_areas.php,v 1.6 2010/03/14 20:56:11 manolis Exp $                                                                 
//
//************************************************************************

require_once dirname(__FILE__).'/CL_area.php';
  
$areaID=makeSane($_GET['areaID'],1);


openMain(_Flying_Areas,0,'icon_takeoff.gif'); 
  
?>

  <table class=main_text width="564"  border="0" align="center" cellpadding="3" cellspacing="1">
    <tr> 
      <td><?=_Name_of_Area?></td>
	  <td>&nbsp;</td>
   </tr>
<? 
	$query="SELECT * FROM $areasTable WHERE areaType=0 ORDER BY name";
	// $query="SELECT * FROM $areasTable ORDER BY name";
	// echo $query;
	$res= $db->sql_query($query);		
	if($res <= 0){
		echo "No areas found <BR>";
	}
	
	while ($row = $db->sql_fetchrow($res)) { 
		echo "<tr> 
      <td>".$row['name']."</td>
	  <td> ";	  
	  echo "<a href='".	getLeonardoLink(array('op'=>'area_show','areaID'=>$row['ID']))."'>"._See_area_details."</a>";	
	  echo "</td></tr> \n";

	}
	
	echo "</table>";
	closeMain();  
	return;

?>
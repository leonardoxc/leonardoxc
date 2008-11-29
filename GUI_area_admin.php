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
// $Id: GUI_area_admin.php,v 1.9 2008/11/29 22:46:07 manolis Exp $                                                                 
//
//************************************************************************

if ( !L_auth::isAdmin($userID) ) { echo "go away"; return; }

require_once dirname(__FILE__).'/CL_area.php';
  
$areaID=makeSane($_GET['areaID'],1);
$areaAction=makeSane($_GET['areaAction']);


if (!$areaID && $areaAction!='Add') { 
	open_inner_table("Administer Area (group of takeoffs)",800); echo "<tr><td>";
	
	echo "<a href='".CONF_MODULE_ARG."&op=area_admin&areaAction=Add&areaID=0'>Add new Area</a><BR><BR>";
	  
?>


  <table class=main_text width="564"  border="0" align="center" cellpadding="1" cellspacing="1">
    <tr> 
      <td>ID</td>
      <td>Name</td>
      <td>Type</td>
	  <td>Actions</td>
   </tr>
<? 
	$query="SELECT * FROM $areasTable	ORDER BY ID";
	// echo $query;
	$res= $db->sql_query($query);		
	if($res <= 0){
		echo "No areas found <BR>";
	}
	
	while ($row = $db->sql_fetchrow($res)) { 
		echo "<tr> 
	  <td>".$row['ID']."</td>
      <td>".$row['name']."</td>
      <td>".area::areaTypeText($row['areaType'])."</td>
	  <td> ";
	  
	  echo "<a href='".CONF_MODULE_ARG."&op=area_admin&areaAction=Edit&areaID=".$row['ID']."'>Edit</a> :: ";
	  echo "<a href='".CONF_MODULE_ARG."&op=area_admin&areaAction=Delete&areaID=".$row['ID']."'>Delete</a> ";

	  if ($row['areaType']==0) echo " :: <a href='".CONF_MODULE_ARG."&op=area_admin&areaAction=administerTakeoffs&areaID=".$row['ID']."'>Add/Remove takeoffs</a> ";
	  
	  echo "</td></tr> \n";

	}
	
	echo "</table>";
	close_inner_table();  
	return;

} else if (in_array($areaAction,array('Add','Edit','Delete') )  ) {
	open_inner_table("$areaAction Area # $areaID",800); echo "<tr><td>";

	echo "<div align=center><a href='".CONF_MODULE_ARG."&op=area_admin&areaAction=none&areaID=0'>RETURN TO LIST</a> </div><BR>";
	
	if ($_POST['formSubmitted'] ) { // do the action
		if ($areaAction=='Delete') {	
			$area=new area($areaID);
			$res=$area->deleteArea();
			if ($res) {
				echo "<BR>Area deleted! ";
			} else {
				echo "<BR>Problem in deleting Area ! ";
			}	
		} else {
			$area=new area($areaID);
			foreach ( $area->valuesArray as $varName) {
				$area->$varName=$_POST[$varName];
			}
			$area->ID= $areaID;
			
			$res=$area->putToDB( $areaID?1:0 );
			
			if ($res) {
				echo "<BR>Area updated! ";
			} else {
				echo "<BR>Problem in updating Area ! ";
			}	
			if ($areaAction=='Edit') 
				echo "<div align=center><a href='".CONF_MODULE_ARG."&op=area_admin&areaAction=Edit&areaID=$areaID'>RETURN TO AREA</a> </div><BR>";
		}
	

	} else {
		if (in_array($areaAction,array('Add','Edit','Delete') )  ) {
			$area=new area($areaID);
			if ($areaID) $area->getFromDB();
		 }
		?>
		<form id="areaForm" name="areaForm" method="post" action="">
		<table width="700" border="1" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="161">Area Name </td>
			<td width="533">
				  <input type="text" name="name" size="40" value="<?=$area->name?>"/>		</td>
		  </tr>
		  		  <tr>
			<td>Type</td>
			<td>
				<select name='areaType' id='areaType' >
				<? foreach ($areaTypeTextArray as $i=>$areaText) {
					if ($area->areaType == $i)  $sel='selected';
					else $sel='';
					echo "<option value='$i' $sel>$areaText</option>\n";
				}
				?>
				</select>			</td>
			 </tr>

		  <tr>
			<td>Description</td>
			<td> <? 
				  if ($areaAction!='Delete'){
				  	  require_once dirname(__FILE__).'/FN_editor.php';
					  createTextArea(0,0,'desc',$area->desc ,'takeoff_description','Leonardo',true,710,600);
				 }else {
				?>
				<input type="text" name="desc" size="40" value="<?=$area->desc?>"/>		
				<? } ?>
				</td>
				
		  </tr>
		  <tr>
			<td>Description (in english) </td>
			<td> 
			 <? 
				  if ($areaAction!='Delete'){
				  	  require_once dirname(__FILE__).'/FN_editor.php';
					  createTextArea(0,0,'descInt',$area->descInt ,'takeoff_description','Leonardo',true,710,600);
				 }else {
				?>
				<input type="text" name="descInt" size="40" value="<?=$area->desc?>"/>		
				<? } ?>             
						</td>
		  </tr>
		  
		  <tr>
			<td>Min Latitude </td>
			<td>              
				<input type="text" name="min_lat" size="40" value="<?=$area->min_lat?>"/>		</td>
		  </tr>
		  <tr>
			<td>Max Latitude</td>
			<td>              
				<input type="text" name="max_lat" size="40" value="<?=$area->max_lat?>"/>		</td>
		  </tr>
		  <tr>
			<td>Min Lontitude</td>
			<td>              
				<input type="text" name="min_lon" size="40" value="<?=$area->min_lon?>"/>		</td>
		  </tr>
		  <tr>
			<td>Max Lontitude</td>
			<td>              
				<input type="text" name="max_lon" size="40" value="<?=$area->max_lon?>"/>		</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>
			<input type="hidden" name="isInclusive" value="<?=$area->isInclusive?>" />
			<input type="hidden" name="center_lat" value="<?=$area->center_lat?>" />
			<input type="hidden" name="center_lon" value="<?=$area->center_lon?>" />
			<input type="hidden" name="radius" value="<?=$area->radius?>" />
			<input type="hidden" name="polygon" value="<?=$area->polygon?>" />
						
			<input type="hidden" name="formSubmitted" value=1 />
			<input type="submit" value="<?=$areaAction?> Area" />
			<?
				
			
			?></td>
		  </tr>
		</table>
		</form>	
<?
	}
	
	close_inner_table();  

} else if ($areaAction=='administerTakeoffs') {
	open_inner_table("Administer Takeoffs for Area # $areaID",800); echo "<tr><td>";

	echo "<div align=center><a href='".CONF_MODULE_ARG."&op=area_admin&areaAction=none&areaID=0'>RETURN TO LIST</a> </div><BR>";

?>

<script language="javascript">

	function removeTakeoffFromArea() {
		
	}
function  addTakeoffToArea ()  {		
	$("#resDiv").html("<img src='<?=$moduleRelPath?>/img/ajax-loader.gif'>");				
	
	var tID=$('#addList').val();
	var tName=$('#addList :selected').text();
	
	$("#resDiv").load("<?=$moduleRelPath?>/EXT_takeoff_functions.php?op=addToArea&aID=<?=$areaID?>&tID="+tID ); 			
	
	$("#takeoffList").append("<tr id='row_"+tID+"'><td>"+tName+"</td><td><div class='removeTakeoff' id='"+tID+"'>Remove Takeoff from area</div></td></tr>");
};


$(document).ready(function(){
   // Your code here
	$('.stripeMe tr:even:gt(0)').addClass('alt');
	$('.stripeMe tr:odd').addClass('alt2');


  
	$(".removeTakeoff").click(function() {		
		$("#resDiv").html("<img src='<?=$moduleRelPath?>/img/ajax-loader.gif'>");				
	  	$("#resDiv").load("<?=$moduleRelPath?>/EXT_takeoff_functions.php?op=removeFromArea&aID=<?=$areaID?>&tID="+$(this).attr("id") ); 
		
		$(this).parent().parent().addClass("deleted");
	});
	

});
</script>

<style type="text/css">
<!--

tr.alt td {
	background: #ecf6fc;
}
tr.alt2 td {
	background: #FFFFFF;
}

tr.over td {
	background: #bcd4ec;
}

tr.deleted td {
	display:none;
	background:#F6E4E9;
	text-decoration:line-through;
}

tr.marked td {
	background:#CDECBB;
}

div#floatDiv , div#takeoffInfoDiv
{
  width: 20%;
  float: right;
  border: 1px solid #8cacbb;
  margin: 0.5em;
  background-color: #dee7ec;
  padding-bottom: 5px;
 
   position :fixed;
   right    :0.5em;
   top      :13em;
   width    :15em;
}

div#takeoffInfoDiv {
	float :left;
	left : 0.5em;
}

div#floatDiv h3, div#takeoffInfoDiv h3
{
	margin:0;
	font-size:12px;
	background-color:#336699;
	color:#FFFFFF;
}

.takeoffLink {
  cursor: pointer;
  text-decoration:underline;
} 

.removeTakeoff
{
  cursor: pointer;
  text-decoration:underline;
} 
-->
</style>

<div id ='floatDiv'>
	<h3>Results</h3>
	<div id ='resDiv'><BR /><BR /></div>
</div>
<form name="formFilter" method="post" action="">
  <br>
  <table class=main_text width="564"  border="0" align="center" cellpadding="1" cellspacing="1">
    <tr> 
      <td width="205" bgcolor="#FF9966"><div align="right"><span class="whiteLetter"><strong><? echo _SELECT_TAKEOFF ?></strong></span></div></td>
      <td width="352"><select name="addList" id="addList">
        <option></option>
        <? 
			$countryCode="GR"; 
		$query="SELECT * from $waypointsTable WHERE type=1000 AND countryCode='$countryCode' ORDER BY name ASC";
		$res= $db->sql_query($query);	
		if($res <= 0){
			  echo("<H3>Error in geting takeoffs</H3>\n");
		}
	    while ($row = mysql_fetch_assoc($res)) { 
			echo "<option value='".$row['ID']."' >".$row['name']."</option>\n";
		  
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
          <input type="button" name="SubmitButton" id="SubmitButton" onclick='addTakeoffToArea()' value="Add takeoff to Area">
		  <input type="hidden" name="addTakeoffForm" value="1" />
          &nbsp; 

      </div></td>
    </tr>
  </table>
 
  
</form>
<h3>List of takeoffs that belong to this area</h3><BR />
<table class='stripeMe' id='takeoffList'>
<?

  list($takeoffs,$takeoffsID)=area::getTakeoffs($areaID);

  $i=0;
  foreach ($takeoffs as $name) {
	  $takeoffID=$takeoffsID[$i];
	  echo "<tr id='row_$takeoffID'><td>$name</td><td><div class='removeTakeoff' id='$takeoffID'>Remove Takeoff from area</div></td></tr>";
	  $i++;
  }
  
?>
</table>
<?
	echo "<div align=center><a href='".CONF_MODULE_ARG."&op=area_admin&areaAction=none&areaID=0'>RETURN TO LIST</a> </div><BR>";

  close_inner_table();  
}
?>
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

 
  if ( !auth::isAdmin($userID) ) { echo "go away"; return; }
  
?>

<style type="text/css">
<!--
  #actionDiv{
  cursor: pointer;
  
  text-decoration:underline;
} 
-->
</style>

<script language="javascript" src="<?=$moduleRelPath ?>/js/jquery.js"></script>

<script language="javascript">

$(document).ready(function(){
  
	$("#takeoffLink").click(function() {		
		
	  	$("#infoDiv").load("<?=$moduleRelPath?>/EXT_takeoff_functions.php?op=getTakeoffInfo&wpID="+$(this).html() ); 
		//var x = e.pageX - this.offsetLeft;
		//var y = e.pageY - this.offsetTop;

	});
		
	<? if ($_GET['admin_op']) { ?>
	 $("#compareMethod").val(<?=$_GET['admin_op']?>);
	<? } ?>
	
	<? if ($_GET['intName']) { ?>
	 $("#intName").attr("checked","checked");
	<? } ?>
		
	$("#ActionDiv").click(function() {	
		var methodID=$("#compareMethod").val();	
		var countryCode=$("#countryCode").val();
		var intName=$("#intName").val();

		var cStr='';
		if (countryCode) cStr='&countryCode='+countryCode;
		if (intName) cStr+='&intName=1';
		
		var linkStr='<?=CONF_MODULE_ARG?>&op=admin_takeoff_resolve&admin_op='+methodID+cStr;
		document.location=linkStr;	  
	});

});
</script>
<?
  $workTable="temp_leonardo_gliders";
  //  $workTable=$flightsTable;

  open_inner_table("ADMIN AREA :: Resolve Duplicate takeoffs",850);
  open_tr();
  echo "<td align=left>";	

	if (!auth::isAdmin($userID)) {
		echo "<br><br>You dont have access to this page<BR>";
		exitPage();
	}
	$admin_op=makeSane($_GET['admin_op']);

?>
	<form><BR />&nbsp;&nbsp;&nbsp;
    Method: 
<select name="compareMethod" id="compareMethod">
  <option value="1">Same Name</option>
  <option value="2">Soundex Similarity</option>      
  <option value="3">Location Proximity (very slow)</option>
</select> 
Select only takeoffs from country: <input type="text" name='countryCode' id='countryCode' size="5" 
value='<?=$_GET['countryCode']?>' /> (give country code)
<input name='intName' id='intName' type="checkbox" value='1' /> Use 'international Name'
</form>
	<?
	
	echo "<ul>";
	echo "<li><div id='ActionDiv'>Find similar takeoffs</div>";	
   	echo "</ul><hr>";


	if ($admin_op>=1 && $admin_op<=2 ) {
		 require_once dirname(__FILE__).'/GUI_admin_takeoff_resolve_1.php';
	} else if ($admin_op>0 ) {
		  require_once dirname(__FILE__).'/GUI_admin_takeoff_resolve_'.$admin_op.'.php';
	}

	echo "</td></tr>";
    close_inner_table();
	
	function execMysqlQuery($query) {
		global $db;
		$res= $db->sql_query($query);
		if(! $res ){
			echo "Problem in query :$query<BR>";
			exit;
		}
	}
?>
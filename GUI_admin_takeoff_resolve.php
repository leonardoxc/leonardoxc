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


	echo "<br>";
	echo "<ul>";
	
	
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin_takeoff_resolve&admin_op=1'>1. Detect Soundex similar takeoffs</a><BR>";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin_takeoff_resolve&admin_op=2'>2. Detect nearby takeoffs</a><BR>";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin_takeoff_resolve&admin_op=3'>3. </a><BR>";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin_takeoff_resolve&admin_op=4'>4. </a><BR>";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin_takeoff_resolve&admin_op=5'>5. </a><BR>";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin_takeoff_resolve&admin_op=6'>6. </a><BR>";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin_takeoff_resolve&admin_op=7'>7. </a><BR>";
	echo "<hr>";


	if ($admin_op>=1 && $admin_op<=10 ) {
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
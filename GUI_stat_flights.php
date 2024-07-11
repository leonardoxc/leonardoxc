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
// $Id: GUI_stat_flights.php,v 1.1 2012/01/16 07:31:04 manolis Exp $                                                                 
//
//************************************************************************

	$legend="";
	$legend="<b>"._MENU_FLIGHTS."</b> ";

	require_once dirname(__FILE__).'/SQL_list_flights.php';	
	//echo "<hr>queryCount: $queryCount<HR>";
	
	$res= $db->sql_query($queryCount);
	if($res <= 0){   
	 echo("<H3> Error in count items query! $queryCount</H3>\n");
	 exit();
	}	
	$row = $db->sql_fetchrow($res);
	$itemsNum=$row["itemNum"];   
	
	//echo "<hr>itemsNum: $itemsNum<HR>";
	
	$pilotIDview=$pilotID;
	
	require "GUI_pilot_profile_stats.php";


?>
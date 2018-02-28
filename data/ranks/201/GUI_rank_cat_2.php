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

//-----------------------------------------------------------------------
//-----------------------  custom league --------------------------------
//-----------------------------------------------------------------------
	// 	open class ,   category=2";
	// Some config
	$cat=1; // pg
	$dontShowDatesSelection=1;
	$dontShowSecondMenu=1;
	$allTime=1;
	
	$where_clause.=" AND category=2 AND takeoffID in (17005, 17009, 17006, 12477, 12478, 17010, 17011, 17015) ";
	require_once dirname(__FILE__)."/common_pre.php";

	$query = "SELECT $flightsTable.ID, userID, takeoffID , userServerID,
  				 gliderBrandID, $flightsTable.glider as glider, cat,
  				 MAX(FLIGHT_POINTS) as FLIGHT_POINTS, FLIGHT_KM, BEST_FLIGHT_TYPE  "
  		. " FROM $flightsTable,$pilotsTable "
        . " WHERE (userID!=0 AND  private=0) AND $flightsTable.userID=$pilotsTable.pilotID "
//			AND $flightsTable.userServerID=$pilotsTable.serverID
		." $where_clause ";

//var_dump($query);


require_once dirname(__FILE__)."/common.php";


?>

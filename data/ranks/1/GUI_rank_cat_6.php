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
     //  Junior PG
     // Some config
	$cat='1'; // pg
	
	$where_clause.=" AND (category=1 OR category=2 OR category=3) ";
	require_once dirname(__FILE__)."/common_pre.php";
	// pilots must younger than 28 at 15.09.2007 ie birthdate = 16.09.1979 or later
     $where_clause.=" AND Birthdate>='1979-09-16' ";
     //echo $where_clause;

	//TEST!!! $where_clause.=" AND leonardo_flights.NACclubID=4 AND NACid=1";

	$query = "SELECT $flightsTable.ID, userID, takeoffID , userServerID,
  				 gliderBrandID, $flightsTable.glider as glider,cat,
  				 FLIGHT_POINTS  , FLIGHT_KM, BEST_FLIGHT_TYPE  "
  		. " FROM $flightsTable,$pilotsTable "
        . " WHERE (userID!=0 AND  private=0) AND $flightsTable.userID=$pilotsTable.pilotID AND $flightsTable.userServerID=$pilotsTable.serverID $where_clause ";

/*if (in_array($userID, $admin_users)) {
	echo '<pre>'.$query.'</pre>';
}*/
require_once dirname(__FILE__)."/common.php";

?>
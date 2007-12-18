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
	// 	PG (cat=1) all categories !!
	// Some config
	// $cat=1; // hg flex -+ regid
	
	$where_clause.=" AND (cat=2 OR cat=4) "; // hg flex + rigid
	require_once dirname(__FILE__)."/common_pre.php";
/*	
	$query = "SELECT $flightsTable.ID, userID, takeoffID ,
  				 gliderBrandID, $flightsTable.glider as glider,cat,
  				 FLIGHT_POINTS  , FLIGHT_KM, BEST_FLIGHT_TYPE  "
  		. " FROM $flightsTable,$pilotsTable "
        . " WHERE (userID!=0 AND  private=0) AND $flightsTable.userID=$pilotsTable.pilotID $where_clause ";

	$query = "
	select clubID , userID, ID, FLIGHT_POINTS, takeoffID, gliderBrandID, glider AS glider
	from (
	   select $flightsTable.clubID,$flightsTable.ID, FLIGHT_POINTS, takeoffID ,gliderBrandID, $flightsTable.glider as glider, $flightsTable.userID,
		  @num := if(@clubID = $flightsTable.clubID, @num + 1, 1) as row_number,
		  @clubID := .$flightsTable.clubID as dummy
	  from $flightsTable,$pilotsTable
	  WHERE (userID!=0 AND  private=0) AND $flightsTable.userID=$pilotsTable.pilotID $where_clause
	  order by $flightsTable.clubID, FLIGHT_POINTS DESC
	) as x where x.row_number <= 6;
	";

	$query = "
	select clubID , userID, ID, FLIGHT_POINTS, takeoffID, gliderBrandID, glider AS glider
	from (
	   select $flightsTable.clubID,$flightsTable.ID, FLIGHT_POINTS, takeoffID ,gliderBrandID, $flightsTable.glider as glider, $flightsTable.userID,
			  $waypointsTable.CountryCode as takeoffCountryCode, 
		  @num := if(@clubID = $flightsTable.clubID, @num + 1, 1) as row_number,
		  @clubID := .$flightsTable.clubID as dummy
	  from $flightsTable,$pilotsTable,$waypointsTable
	  WHERE (userID!=0 AND  private=0) 
			AND $flightsTable.userID=$pilotsTable.pilotID 
			AND $flightsTable.clubID<>0 
			AND $flightsTable.takeoffID =$waypointsTable.ID 
			$where_clause
	  order by $flightsTable.clubID, FLIGHT_POINTS DESC
	) as x ;
	";
	*/
	$query = "
	 SELECT $flightsTable.NACclubID,$flightsTable.ID, ( FLIGHT_POINTS * ( 1 - ( 0.075*(cat-2)) )  ) as score, userServerID,
	 		takeoffID ,gliderBrandID, $flightsTable.glider as glider, $flightsTable.userID
	 FROM  $flightsTable,$pilotsTable
	 WHERE (userID!=0 AND  private=0) 
			AND $flightsTable.userID=$pilotsTable.pilotID 
			AND $flightsTable.userServerID=$pilotsTable.serverID
			AND $flightsTable.NACclubID<>0 
			$where_clause
	  order by $flightsTable.NACclubID, FLIGHT_POINTS DESC
	";

	require_once dirname(__FILE__)."/common.php";

?>
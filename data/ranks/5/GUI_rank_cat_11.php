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
 		// Martin Jursa 23.05.2007
	    // Newcomer HG (+Rigid)
        // No handicap  factor for rigid
		$cat='2';

		require dirname(__FILE__)."/common_pre.php";

		$y=$year ? $year : date('Y');
		$where_clause.=" AND FirstOlcYear=$y ";

		$where_clause2=substr($where_clause, 5);

		$cat='4';
		$where_clause="";
		require dirname(__FILE__)."/common_pre.php";
		$where_clause.=" AND FirstOlcYear=$y ";

		$where_clause4=substr($where_clause, 5);

		$query = "SELECT
						$flightsTable.ID, userID, takeoffID ,userServerID,
						gliderBrandID, $flightsTable.glider as glider, cat,
						FLIGHT_POINTS,
						FLIGHT_KM, BEST_FLIGHT_TYPE
					FROM $flightsTable,$pilotsTable
					WHERE
						(userID!=0 AND  private=0)
						AND $flightsTable.userID=$pilotsTable.pilotID	AND $flightsTable.userServerID=$pilotsTable.serverID 
						AND (($where_clause2) OR ($where_clause4))";


require_once dirname(__FILE__)."/common.php";

?>
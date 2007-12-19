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
	// 	sport class ,   category=1";
	// Some config

/*	 	$cat='1'; // pg
		$org_where_clause=$where_clause;

		$where_clause='';
		//	$where_clause.=" AND category=1 ";
		require dirname(__FILE__)."/common_pre.php";
		// pilots must younger than 28 at 15.09.2007 ie birthdate = 16.09.1988 or later
		//$where_clause.=" AND Sex='F'";
		//echo $where_clause;
		$where_clause2=substr($where_clause, 5);

		$cat='1';
		$where_clause="";
		//	$where_clause.=" AND category=1 ";
		require dirname(__FILE__)."/common_pre.php";
		// pilots must younger than 28 at 15.09.2007 ie birthdate = 16.09.1988 or later
		//$where_clause.=" AND Sex='F'";

		$where_clause4=substr($where_clause, 5);

		$query = "SELECT
					$flightsTable.ID, userID, takeoffID ,  userServerID,
					gliderBrandID, $flightsTable.glider as glider, cat,
					IF(cat=4, FLIGHT_POINTS*1, FLIGHT_POINTS) AS FLIGHT_POINTS,
					FLIGHT_KM, BEST_FLIGHT_TYPE
				FROM $flightsTable,$pilotsTable
		    	WHERE
		    		(userID!=0 AND  private=0)
		    		AND $flightsTable.userID=$pilotsTable.pilotID
					AND $flightsTable.userServerID=$pilotsTable.serverID
					$org_where_clause
		    		AND (($where_clause2) OR ($where_clause4))";

*/

		$cat='1';
		require dirname(__FILE__)."/common_pre.php";

		$query = "SELECT
					$flightsTable.ID, userID, takeoffID ,  userServerID,
					gliderBrandID, $flightsTable.glider as glider, cat,
					IF(cat=4, FLIGHT_POINTS*1, FLIGHT_POINTS) AS FLIGHT_POINTS,
					FLIGHT_KM, BEST_FLIGHT_TYPE
				FROM $flightsTable,$pilotsTable
		    	WHERE
		    		(userID!=0 AND  private=0)
		    		AND $flightsTable.userID=$pilotsTable.pilotID
					AND $flightsTable.userServerID=$pilotsTable.serverID
		    		$where_clause ";
					
require_once dirname(__FILE__)."/common.php";
?>
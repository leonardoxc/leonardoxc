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
	// 	open class ,  category=2";
	// Some config
	$cat=1; // pg
	// $year=2007; // flights from 1.10.2006 00:00 UTC - 30.09.2007
	if ($year)
  		$where_clause=" AND DATE >='".($year-1)."-10-1' AND DATE < '".$year."-10-1' "; 
	$where_clause.=" AND cat=$cat ";
	
	// open class
	$where_clause.=" AND category=2 ";
	
	// pilots must be NACid=1 (DHV) and NACmemberID>0
	$where_clause.=" AND NACid=1 AND NACmemberID>0 ";

	// The flgiht mus be validated
	$where_clause.=" AND validated=1 ";
	
	$query = "SELECT $flightsTable.ID, userID, takeoffID ,
  				 gliderBrandID, $flightsTable.glider as glider,cat,
  				 FLIGHT_POINTS  , FLIGHT_KM, BEST_FLIGHT_TYPE  "
  		. " FROM $flightsTable,$pilotsTable "
        . " WHERE (userID!=0 AND  private=0) AND $flightsTable.userID=$pilotsTable.pilotID $where_clause ";


require_once dirname(__FILE__)."/common.php";


?>
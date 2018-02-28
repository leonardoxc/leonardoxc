<?
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://sourceforge.net/projects/leonardoserver                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

/*
*  Martin Jursa 22.05.2007: Support for NAC club filtering added
*/
	if (!empty($nacid)) {
		if ($nacid!=1) $nacclubid=0;
	}
	$nacid=0; # force DHV
	$nacclubid=0;

    // OLC km's must be > 15
//	if ($season==2006)
//	    $where_clause.=" AND FLIGHT_KM>=15000 ";
   
	$where_clause.=" AND (cat=$cat) ";

	// pilots must be NACid=1 (DHV) and NACmemberID>0
	$where_clause.=" AND $pilotsTable.NACid=$nacid AND NACmemberID=0 AND countryCode='PL' ";

	// The flight mus be validated
	$where_clause.=" AND validated=1 ";

	// support for NACclub filtering
	if ($nacclubid) {
		$where_clause.=" AND $flightsTable.NACid=$nacid AND $flightsTable.NACclubID=$nacclubid ";
	}
	$where_clause.=" GROUP BY userID,takeoffID ";

?>

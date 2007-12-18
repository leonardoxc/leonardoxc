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

	// $year=2007; // flights from 1.10.2006 00:00 UTC - 30.09.2007
/**
 *  Martin Jursa 22.05.2007: Support for NAC club filtering added
 *  Odenwald Cup Filter added - P.Wild 30.07.2007
 */
	if (!empty($nacid)) {
		if ($nacid!=1) $nacclubid=0;
	}
	$nacid=1; // force DHV
    

    $where_clause.=" AND (cat=$cat) ";

	// pilots must be NACid=1 (DHV) and NACmemberID>0 and Mitglied eine Odenwalder Verein and Nationality=DE
	$where_clause.=" AND $pilotsTable.NACid=$nacid AND NACmemberID>0 AND ($pilotsTable.NACclubID=201 OR $pilotsTable.NACclubID=36 OR $pilotsTable.NACclubID=89 OR $pilotsTable.NACclubID=40 OR $pilotsTable.NACclubID=160 OR $pilotsTable.NACclubID=369 OR $pilotsTable.NACclubID=405 OR $pilotsTable.NACclubID=266 OR $pilotsTable.NACclubID=218 OR $pilotsTable.NACclubID=260) AND countryCode='DE' ";

    //Take off must be from an Odenwalder Start
    $where_clause.=" AND ($flightsTable.takeoffID=9340 OR $flightsTable.takeoffID=9447 OR $flightsTable.takeoffID=9299 OR $flightsTable.takeoffID=9917 OR $flightsTable.takeoffID=9852 OR $flightsTable.takeoffID=9502 OR $flightsTable.takeoffID=9384 OR $flightsTable.takeoffID=9707 OR $flightsTable.takeoffID=9777 OR $flightsTable.takeoffID=9563 OR $flightsTable.takeoffID=9776 OR $flightsTable.takeoffID=9965 OR $flightsTable.takeoffID=9732 OR $flightsTable.takeoffID=9689 OR $flightsTable.takeoffID=9891 OR $flightsTable.takeoffID=9412 OR $flightsTable.takeoffID=9629 OR $flightsTable.takeoffID=9448 OR $flightsTable.takeoffID=9807 OR $flightsTable.takeoffID=10134)";
    
    // The flight must be validated
	$where_clause.=" AND validated=1 ";

	// OLC km's must be > 15
	// $where_clause.=" AND FLIGHT_KM>=15000 ";

	// support for NACclub filtering
	if ($nacclubid) {
		$where_clause.=" AND $flightsTable.NACid=$nacid AND $flightsTable.NACclubID=$nacclubid";
	}



?>

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
	$NACid=2;


    // OLC km's must be > 15
    if ($season==2007)
   	 $where_clause.=" AND FLIGHT_KM>=15000 ";


	// pilots must be NACid=2 (OeAeC) and NACmemberID>0
	$where_clause.=" AND $pilotsTable.NACid=2 AND NACmemberID>0 AND countryCode='AT' ";

	// The flight must be validated
	 $where_clause.=" AND validated=1 ";




// see this for mysql 5 queries..
// http://www.xaprb.com/blog/2006/12/07/how-to-select-the-firstleastmax-row-per-group-in-sql/
/*

set @num := 0, @clubID := '';

select clubID,ID, FLIGHT_POINTS,
      @num := if(@clubID= clubID , @num + 1, 1) as row_number,
      @clubID := clubID as dummy
from leonardo_flights  force index(clubID)
group by clubID, FLIGHT_POINTS, ID
having row_number <= 2;

// WORKS !!!

set @num := 0, @clubID := '';

select clubID, ID, FLIGHT_POINTS
from (
   select clubID, ID, FLIGHT_POINTS,
      @num := if(@clubID = clubID, @num + 1, 1) as row_number,
      @clubID := clubID as dummy
  from leonardo_flights
  order by clubID, FLIGHT_POINTS DESC
) as x where x.row_number <= 5;

*/

?>

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
	$NACid=1;

	// $year=2007; // flights from 1.10.2006 00:00 UTC - 30.09.2007
	//	if ($year)
 	// 		$where_clause.=" AND DATE >='".($year-1)."-10-1' AND DATE < '".$year."-10-1' "; 

	
	// pilots must be NACid=1 (DHV) and NACmemberID>0
	//	$where_clause.=" AND NACid=1 AND NACmemberID>0 ";

	// The flgiht mus be validated
	//	$where_clause.=" AND validated=1 ";

	// OLC km's must be > 15
	// $where_clause.=" AND FLIGHT_KM>=15000 ";




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
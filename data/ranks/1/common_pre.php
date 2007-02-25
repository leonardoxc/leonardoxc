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
	if ($year)
  		$where_clause.=" AND DATE >='".($year-1)."-10-1' AND DATE < '".$year."-10-1' "; 

	$where_clause.=" AND cat=$cat ";
	
	// pilots must be NACid=1 (DHV) and NACmemberID>0
	$where_clause.=" AND NACid=1 AND NACmemberID>0 ";

	// The flgiht mus be validated
	$where_clause.=" AND validated=1 ";

	// OLC km's must be > 15
	$where_clause.=" AND FLIGHT_KM>=15000 ";


?>
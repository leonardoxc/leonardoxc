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
	// Some config
	$cat=1; // pg
	// $year=2007; // flights from 1.10.2006 00:00 UTC - 30.09.2007
	if ($year)
  		$where_clause=" AND DATE >='".($year-1)."-10-1' AND DATE < '".$year."-10-1' "; 
	$where_clause.=" AND cat=$cat ";
	$query = 'SELECT '.$flightsTable.'.ID, userID, username, takeoffID ,
  				 gliderBrandID,'.$flightsTable.'.glider as glider,cat,
  				 MAX_ALT , TAKEOFF_ALT, DURATION , LINEAR_DISTANCE, FLIGHT_POINTS  , FLIGHT_KM, BEST_FLIGHT_TYPE  '
  		. ' FROM '.$flightsTable.', '.$prefix.'_users' . $extra_table_str
        . ' WHERE (userID!=0 AND  private=0) AND '.$flightsTable.'.userID = '.$prefix.'_users.user_id '.$where_clause
        . ' ';

require_once dirname(__FILE__)."/common.php";

?>
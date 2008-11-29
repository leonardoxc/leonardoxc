<?
//************************************************************************
// Leonardo XC Server, http://leonardo.thenet.gr
//
// Copyright (c) 2004-8 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: INC_club_where_clause.php,v 1.7 2008/11/29 22:46:07 manolis Exp $                                                                 
//
//************************************************************************

	 $areaID=$clubsList[$clubID]['areaID'];
  	 $addManual=$clubsList[$clubID]['addManual'];

	if ( ! $clubsList[$clubID]['noSpecificMembers'] ) {
	  $where_clause.=" AND 	$flightsTable.userID=$clubsPilotsTable.pilotID AND 
							$flightsTable.userServerID=$clubsPilotsTable.pilotServerID AND 
				 			$clubsPilotsTable.clubID=$clubID ";
	  $extra_table_str.=",$clubsPilotsTable ";
	}
	
	if ( is_array($clubsList[$clubID]['countryCodes'])  ) {
		foreach ($clubsList[$clubID]['countryCodes'] as $cCode ) {
			$where_clause.=" AND $waypointsTable.countryCode='$cCode' ";
		}
		$countryCodeQuery=1;
		$where_clause_country="";
	}
	
	if ( is_array($clubsList[$clubID]['pilotNationality'])  ) {
	    $where_clause.="  AND $flightsTable.userID=$pilotsTable.pilotID AND $flightsTable.userServerID=$pilotsTable.serverID  ";	

		foreach ($clubsList[$clubID]['pilotNationality'] as $pCountryCode ) {
			$where_clause.=" AND $pilotsTable.countryCode='$pCountryCode ' ";
		}
		$extra_table_str.=",$pilotsTable ";
		$pilotsTableQueryIncluded=1;
	}
	
	if ( is_array($clubsList[$clubID]['gliderCat'])  ) {
		$where_clause.=" AND ( 0 ";
		foreach ($clubsList[$clubID]['gliderCat'] as $c_gliderCat ) {
			$where_clause.=" OR  $flightsTable.cat=$c_gliderCat ";
		}
		$where_clause.=" ) ";
	}
	
	// only locally submitted flights for this club ?
	if ( $clubsList[$clubID]['onlyLocalFlights']  ) {
		$where_clause.=" AND externalFlightType = 0 ";
	}
	
	if ($areaID) {
		require_once dirname(__FILE__)."/CL_area.php";
		$clubArea=new area($areaID);
		$clubArea->getFromDB();

		if ($clubArea->areaType==0 && 0) {
			 $where_clause.= " 	AND $areasTakeoffsTable.areaID=$areaID 
								AND $areasTakeoffsTable.takeoffID=$flightsTable.takeoffID  ";
			 $extra_table_str.=",$areasTakeoffsTable ";
		} else if ($clubArea->areaType==1) { // bounding box
			 $where_clause.= " 	AND firstLat >=".$clubArea->min_lat."
								AND firstLat <=".$clubArea->max_lat." 
								AND firstLon >=".$clubArea->min_lon."
								AND firstLon <=".$clubArea->max_lon."
								";

		}
	}
	

	if ($addManual) {
		 $clubFlights=getClubFlightsID($clubID);

		if (! $add_remove_mode ) { // select only spefici flights
		 $where_clause.= " 	AND $clubsFlightsTable.flightID=$flightsTable.ID 
							AND $clubsFlightsTable.clubID=$clubID ";
	 	 $extra_table_str.=",$clubsFlightsTable ";
		}
	}


  // SEASON MOD
  // we do a little trick here!
  // if the rank has custom seasons we just replace the global $CONF['seasons'] array 
  // since both have the same structure
  if ( $clubsList[$clubID]['useCustomSeasons'] ) { 
	  $CONF['seasons']=$clubsList[$clubID]['seasons'];
  }
/*
  if ( $ranksList[$rank]['useCustomYears'] ) { 
	  $CONF['years']=$clubsList[$clubID]['years'];
  }
*/
  $where_clause.= dates::makeWhereClause(0,$season,$year,$month,0 );

//$where_clause.= dates::makeWhereClause(0,$season,$year,$month,($CONF_use_calendar?$day:0) );


?>
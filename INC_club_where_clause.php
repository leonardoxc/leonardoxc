<?
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://leonardo.thenet.gr                                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

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
		$where_clause.=" AND $flightsTable.userID=$pilotsTable.pilotID ";
		foreach ($clubsList[$clubID]['pilotNationality'] as $pCountryCode ) {
			$where_clause.=" AND $pilotsTable.countryCode='$pCountryCode ' ";
		}
		$extra_table_str.=",$pilotsTable ";
		$pilotTableQuery=1;
	}
	
	if ( is_array($clubsList[$clubID]['gliderCat'])  ) {
		$where_clause.=" AND ( 0 ";
		foreach ($clubsList[$clubID]['gliderCat'] as $c_gliderCat ) {
			$where_clause.=" OR  $flightsTable.cat=$c_gliderCat ";
		}
		$where_clause.=" ) ";
	}
	
	
	if ($areaID) {
		 $where_clause.= " 	AND $areasTakeoffsTable.areaID=$clubsTable.areaID 
							AND $areasTakeoffsTable.takeoffID=$flightsTable.takeoffID  ";
	 	 $extra_table_str.=",$areasTakeoffsTable ";
	}

	
	if ($addManual) {
		 $clubFlights=getClubFlightsID($clubID);

		if (! $add_remove_mode ) { // select only spefici flights
		 $where_clause.= " 	AND $clubsFlightsTable.flightID=$flightsTable.ID 
							AND $clubsFlightsTable.clubID=$clubID ";
	 	 $extra_table_str.=",$clubsFlightsTable ";
		}
	}


?>
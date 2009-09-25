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
// $Id: SQL_list_flights.php,v 1.6 2009/09/25 13:51:15 manolis Exp $                                                                 
//
//************************************************************************



	// Version Martin Jursa 20.05.2007
	// Support for filtering by NACclubs via $_REQUEST[nacclub] added
	// computed column "SCORE_SPEED"=FLIGHT_KM/DURATION added
		
	$sortOrder=makeSane($_REQUEST["sortOrder"]);
	if ( $sortOrder=="")  $sortOrder="DATE";
	
	$page_num=$_REQUEST["page_num"]+0;
	if ($page_num==0)  $page_num=1;
	
	if ($cat==0) $where_clause="";
	else $where_clause=" AND cat=$cat ";
	
	$queryExtraArray=array();
	
	
	if ($filter01) { // we only display flights with photos
		$where_clause.= " AND hasPhotos>0 ";
	}
	
	// SEASON MOD
	if (! $clubID) { // if we are viewing a club, the dates will be taken care wit hthe CLUB code
		$where_clause.= dates::makeWhereClause(0,$season,$year,$month,($CONF_use_calendar?$day:0) );
	}
	
	// BRANDS MOD  
	$where_clause.= brands::makeWhereClause($brandID);
	
	// take care of exluding flights
	// 1-> first bit -> means flight will not be counted anywhere!!!
	$bitMask=1 & ~( $includeMask & 0x01 );
	$where_clause.= " AND ( excludeFrom & $bitMask ) = 0 ";

	if ($pilotID!=0) {
		$where_clause.=" AND userID='".$pilotID."'  AND userServerID=$serverID ";		
	} else {  // 0 means all flights BUT not test ones 
		$where_clause.=" AND userID>0 ";		
	}
	
	if ($takeoffID) {
		$where_clause.=" AND takeoffID='".$takeoffID."' ";
	}
	// Martin Jursa 18.05.2007
	// Support for NACclubs added
	if ($nacid && $nacclubid) {
		$where_clause.=" AND $flightsTable.NACid=$nacid AND $flightsTable.NACclubID=$nacclubid  ";
	}
	
	if ($country) {
		$where_clause_country.=" AND  $waypointsTable.countryCode='".$country."' ";
	}
	
	if ($class) {
		$where_clause.=" AND  $flightsTable.category='".$class."' ";
	}

	if ($xctype) {
		$where_clause.=" AND  $flightsTable.BEST_FLIGHT_TYPE='".$CONF_xc_types_db[$xctype]."' ";
	}

	
	if ($sortOrder=="dateAdded" && $year ) $sortOrder="DATE";

	# Martin Jursa 20.05.2007; have all possible descriptions in this array
	$sortDescArray=array(
		"DATE"=>_DATE_SORT,"pilotName"=>_PILOT_NAME, "takeoffID"=>_TAKEOFF,
		"DURATION"=>_DURATION, "MEAN_SPEED"=>_MEAN_SPEED1, "SCORE_SPEED"=>_MEAN_SPEED1,
		"LINEAR_DISTANCE"=>_LINEAR_DISTANCE,
		"FLIGHT_KM"=>_OLC_KM, "FLIGHT_POINTS"=>_OLC_SCORE , "dateAdded"=>_DATE_ADDED
	);


	$sortDesc=$sortDescArray[ $sortOrder];
	$ord="DESC";


	# Martin Jursa 20.05.2007; min 20' of flight, otherwise some weird results occur
	$scoreSpeedSql="IF (DURATION<1200, 0, FLIGHT_KM*3.6/DURATION)";


	$sortOrderFinal=$sortOrder;
	
	$pilotsTableQuery=0;
	$pilotsTableQuery2=0;
	
	$where_clause2="";
	$extra_table_str2="";
	if ($sortOrder=="pilotName") { 
	 if ($opMode==1) { 
		$sortOrderFinal="CONCAT(name,username) ";
	 } else {
		//if ($CONF_use_leonardo_names) $sortOrderFinal='username';
		//else $sortOrderFinal=$CONF_phpbb_realname_field;
		 $sortOrderFinal=$CONF['userdb']['user_real_name_field'];
	
		if ($PREFS->nameOrder==1) {
			$sortOrderFinal=" FirstName,LastName ";						
			// $sortOrderFinal="CONCAT(FirstName,' ',LastName) ";
		} else {
			$sortOrderFinal=" LastName,FirstName ";
			// $sortOrderFinal="CONCAT(LastName,' ',FirstName) ";
		}	
	 }
	
	 if ( $CONF['userdb']['use_leonardo_real_names'] ) { // use the leonardo_pilots table 
		 $pilotsTableQuery2=1;
	 } else {
		 $where_clause2="  AND ".$flightsTable.".userID=".$CONF['userdb']['users_table'].".".$CONF['userdb']['user_id_field'] ;
		 $extra_table_str2=",".$CONF['userdb']['users_table'];
	 }
	
	 $ord="ASC";
	}  else if ($sortOrder=="dateAdded") { 
	 $where_clause=" AND DATE_SUB(NOW(),INTERVAL 5 DAY) <  dateAdded  ";
	}  else if ($sortOrder=="DATE") { 
	 $sortOrderFinal="DATE DESC, FLIGHT_POINTS ";
	} else if ($sortOrder=="SCORE_SPEED") {
		$sortOrderFinal="$scoreSpeedSql DESC, FLIGHT_POINTS ";
	}
	
	if ( ! ($pilotID>0 && $pilotID==$userID ) && !L_auth::isAdmin($userID) ) {
		$where_clause.=" AND private=0 ";
	} 
	
	$filter_clause=$_SESSION["filter_clause"];
	//echo $filter_clause;
	if ( strpos($filter_clause,"countryCode")=== false )  $countryCodeQuery=0;	
	else {
			if ( strpos($filter_clause,$pilotsTable.".countryCode")=== false )  $countryCodeQuery=1;
			else {
				$pilotsTableQuery=1;
				if ( strpos($filter_clause," countryCode") )  $countryCodeQuery=1;
				else $countryCodeQuery=0;
			}
	}

	if ( ! strpos($filter_clause,$pilotsTable.".Sex")=== false )  $pilotsTableQuery=1;
	
	
	$where_clause.=$filter_clause;
	
	if ($clubID)   {
	 $add_remove_mode=makeSane($_REQUEST['admClub'],1);
	 $queryExtraArray+=array("admClub"=>$add_remove_mode);
	
	 require dirname(__FILE__)."/INC_club_where_clause.php";
	} 
	
	if ($countryCodeQuery || $country)   {
	 $where_clause.=" AND $flightsTable.takeoffID=$waypointsTable.ID ";
	 $extra_table_str.=",".$waypointsTable;
	} else $extra_table_str.="";

	$pilotIncludedFields="";
	
	if ($pilotsTableQuery2 && !$pilotsTableQueryIncluded){
		$where_clause2="  AND $flightsTable.userID=$pilotsTable.pilotID AND $flightsTable.userServerID=$pilotsTable.serverID  ";	 
		$extra_table_str2.=",$pilotsTable FORCE INDEX ( FirstName ) ";	
		$pilotIncludedFields=" $pilotsTable.countryCode, $pilotsTable.Sex, ";	
	}

	
	if ($pilotsTableQuery && !$pilotsTableQuery2 && !$pilotsTableQueryIncluded){
		$where_clause.="  AND $flightsTable.userID=$pilotsTable.pilotID AND $flightsTable.userServerID=$pilotsTable.serverID  ";	
		$extra_table_str.=",$pilotsTable";
		$pilotIncludedFields=" $pilotsTable.countryCode, $pilotsTable.Sex, ";
	}	 
	 		
	$where_clause.=$where_clause_country;
	
	
	$queryCount="SELECT count(*) as itemNum FROM $flightsTable".$extra_table_str."  WHERE (1=1) ".$where_clause." ";
	// echo "queryCount:$query#<BR>";


if (0) {
	$res= $db->sql_query($queryCount);
	if($res <= 0){   
	 echo("<H3> Error in count items query! $queryCount</H3>\n");
	 exit();
	}
	
	$row = $db->sql_fetchrow($res);
	$itemsNum=$row["itemNum"];   
	
	$startNum=($page_num-1)*$PREFS->itemsPerPage;
	$pagesNum=ceil ($itemsNum/$PREFS->itemsPerPage);
}
	
	$query="SELECT $flightsTable.* , $pilotIncludedFields
				$flightsTable.glider as flight_glider, 
				$flightsTable.takeoffID as flight_takeoffID, 
				$flightsTable.ID as ID,
				$scoreSpeedSql AS SCORE_SPEED
		FROM $flightsTable $extra_table_str $extra_table_str2
		WHERE (1=1) $where_clause $where_clause2
		ORDER BY $sortOrderFinal $ord "; 
		// no -> LIMIT $startNum,".$PREFS->itemsPerPage ;
		// we put this later on main file

	// echo "<!-- $query -->"; 
	// echo "$query"; 

?>
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
// $Id: CL_NACclub.php,v 1.8 2009/12/16 14:15:37 manolis Exp $
//
//************************************************************************


class NACclub {
	var $ID;
	var $name;
	var $intName;
	var $description;
	var $intDescription;
	var $countryCode;
	var $NAC_ID;
	var $location;
	var $intLocation;
	var $link;
	var $cat;

	var $valuesArray;
	var $gotValues;

	function NACclub() {
	}


	function getPilotClub($userID) {
		global $db,$NACclubsTable,$pilotsTable;
		$query="SELECT NACclubID,NACid FROM $pilotsTable WHERE pilotID=$userID ";
		$res= $db->sql_query($query);
		//echo $query;
  		if($res <= 0){
			 echo "Error getting club for pilot<BR>";
		     return 0;
	    }
		if ( $row=$db->sql_fetchrow($res) )
			return array($row['NACid'],$row['NACclubID']);
		else return 0;
    }

/**
 * Get Array of clubID=>clubName
 * Modification Martin Jursa, 22.05.2007: Option $withFlightsOnly to limit array to clubs having submitted flights
 *
 * @param int $NAC_ID
 * @param bool $withFlightsOnly
 * @return array
 */
	function getClubs($NAC_ID, $withFlightsOnly=false) {
		global $db,$NACclubsTable;
		if ($withFlightsOnly) {
			global $flightsTable;
			$query="SELECT clubID, clubName
				FROM $NACclubsTable c
					INNER JOIN $flightsTable f ON f.NACid=c.NAC_ID AND f.NACclubID=c.clubID
				WHERE c.NAC_ID=$NAC_ID
				GROUP BY  clubID, clubName
				ORDER BY clubName";
		}else {
			$query="SELECT * FROM $NACclubsTable WHERE NAC_ID=$NAC_ID ORDER BY clubName";
		}
		$res= $db->sql_query($query);
		// echo $query;
  		if($res <= 0){
			 echo "Error getting NAC clubs from DB<BR>";
		     return;
	    }
		$NACclubList=array();
		while ($row=$db->sql_fetchrow($res)) {
			$NACclubList[$row['clubID']]=$row['clubName'];
		}
		return $NACclubList;
    }

	function getClubName($NAC_ID,$clubID){
		global $db,$NACclubsTable;
		$query="SELECT clubName FROM $NACclubsTable WHERE NAC_ID=$NAC_ID AND clubID=$clubID ";
		$res= $db->sql_query($query);
		//echo $query;
  		if($res <= 0){
			 echo "Error getting NAC club from DB<BR>";
		     return;
	    }
		if ($row=$db->sql_fetchrow($res)) 	return $row['clubName'];
		else return "";
	}
/* OLD
	function updatePilotFlights($pilotID, $NAC_ID, $NACclubID, $year=0) {
		global $db, $flightsTable, $NACclubsTable, $CONF_NAC_list;

		if ($NAC_ID==0) return 1;

		$where_clause=" WHERE ";
		if (!$year) $year=$CONF_NAC_list[$NAC_ID]['current_year'];
		if ( $CONF_NAC_list[$NAC_ID]['periodIsNormal']) { // league start and end on 1/1
			$where_clause.=" DATE >='".$year."-01-01' AND DATE <= '".$year."-12-31'";
		} else {
			$where_clause.=" DATE >='".($year-1).$CONF_NAC_list[$NAC_ID]['periodStart']."' AND DATE < '".$year.$CONF_NAC_list[$NAC_ID]['periodStart']."'";
		 }

		// Martin Jursa 18.05.2007: Save the NACid too
		$query="UPDATE $flightsTable SET NACclubID=$NACclubID, NACid=$NAC_ID $where_clause AND userID=$pilotID";
		// echo $query;
		$res= $db->sql_query($query);
		if($res <= 0){
		  echo "Error updating NACclub to flights table for pilot $pilotID<BR>";
		  // echo $query;
		  return 0;
		}
		return 1;
	}
*/
/**
 * New version 27/5/2008 by Martin Jursa
 * Taking into account the configuration settings for each NAC-Club:
 * If club_change_period_active==false you can change the club in the pilot profile but the flights won't follow
 * Special handling of NACid=0: flights with NACid=0 get changed even if club_change_period_active is false
 *
 *
 * @param int $pilotID
 * @param int $newNACid
 * @param int $newNACclubID
 */
	function updatePilotFlights($pilotID, $newNACid, $newNACclubID) {
		global $db, $flightsTable, $NACclubsTable, $CONF_NAC_list;

		$now=time();
		$currYear=date('Y');
		$NACInfos=array();
		$minSeasonStart=$currYear.'-01-01';
		$maxSeasonEnd=($currYear+1).'-01-01';
		foreach ($CONF_NAC_list as $NACid=>$NACconf) {
			$periodStart=!empty($NACconf['periodIsNormal']) || empty($NACconf['periodStart']) ? '-01-01' : $NACconf['periodStart'];
			$SeasonStart=$currYear.$periodStart;
			$ts=strtotime($SeasonStart);
			if ($ts>$now) {
				$SeasonStart=($currYear-1).$periodStart;
				$SeasonEnd=($currYear).$periodStart;
			}else {
				$SeasonEnd=($currYear+1).$periodStart;
			}
			if ($SeasonStart<$minSeasonStart) $minSeasonStart=$SeasonStart;
			if ($SeasonEnd>$maxSeasonEnd) $maxSeasonEnd=$SeasonEnd;
			$NACInfos[$NACid]['SeasonStart']=$SeasonStart;
			$NACInfos[$NACid]['SeasonEnd']=$SeasonEnd;
			$NACInfos[$NACid]['UseClubs']=empty($NACconf['use_clubs']) ? 0 : 1;
			$NACInfos[$NACid]['AllowChangeClub']=empty($NACconf['club_change_period_active']) ? 0 : 1;
		}
		# virtual NAC to handle NACid==0
		$NACInfos[0]=array('SeasonStart'=>$minSeasonStart, 'SeasonEnd'=>$maxSeasonEnd, 'AllowChangeClub'=>1, 'UseClubs'=>1);

		$allNACs=array_keys($NACInfos);
		if (!in_array($newNACid, $allNACs)) return ;

		if ($NACInfos[$newNACid]['UseClubs']==0) $newNACclubID=0;

		$newSeasonStart=$NACInfos[$newNACid]['SeasonStart'];
		$newSeasonEnd=$NACInfos[$newNACid]['SeasonEnd'];
		$flightsClauses=array();
		foreach ($NACInfos as $NACid=>$Info) {
			if ($Info['AllowChangeClub']) {
				$flightsClause="NACid=$NACid";
				$flightsClause.=" AND DATE>='".$Info['SeasonStart']."' AND DATE<'".$Info['SeasonEnd']."'";
				$flightsClause.=" AND DATE>='$newSeasonStart'";
				$flightsClause.=" AND DATE<'$newSeasonEnd'";
				$flightsClauses[]='('.$flightsClause.')';
			}
		}
		$flightsClause=implode(' OR ', $flightsClauses);

		$generalClause="userID=$pilotID AND (NACclubID<>$newNACclubID OR NACid<>$newNACid)";

		$where_clause="($generalClause) AND ($flightsClause)";


		$query="UPDATE $flightsTable
	SET NACclubID=$newNACclubID, NACid=$newNACid
WHERE
	$where_clause ";
		//echo $query;

		$res= $db->sql_query($query);
		if(!$res){
			echo "Error updating NACclub to flights table for pilot $pilotID<BR>";
		}else {
			$count=$db->sql_affectedrows($res);
			if ($count>0) {
				echo '<b>'.$count.' flights updated</b><BR>';
			}
		}
	}

}

?>
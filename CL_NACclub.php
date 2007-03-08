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
	
	function getClubs($NAC_ID) {
		global $db,$NACclubsTable;
		$query="SELECT * FROM $NACclubsTable WHERE NAC_ID=$NAC_ID ORDER BY clubName";
		$res= $db->sql_query($query);
		//echo $query;
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

	function updatePilotFlights($pilotID,$NAC_ID,$NACclubID,$year=0) {
		global $db,$flightsTable, $NACclubsTable,$CONF_NAC_list;

		$where_clause=" WHERE ";
		if (!$year) $year=$CONF_NAC_list[$NAC_ID]['current_year'];
		if ( $CONF_NAC_list[$NAC_ID]['periodIsNormal']) { // league start and end on 1/1
			$where_clause.=" DATE >='".$year."-1-1' AND DATE <= '".$year."-12-31'";
		} else {
			$where_clause.=" DATE >='".($year-1).$CONF_NAC_list[$NAC_ID]['periodStart']."' AND DATE < '".$year.$CONF_NAC_list[$NAC_ID]['periodStart']."'";
		 }

		$query="UPDATE $flightsTable SET NACclubID=$NACclubID $where_clause AND userID=$pilotID";
		// echo $query;
	    $res= $db->sql_query($query);
	    if($res <= 0){
		  echo "Error updating NACclub to flights table for pilot $pilotID<BR>";
		 echo $query;
		  return 0;
	    }		
		return 1;
    }

}

?>
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

/*


*/


class area{
	var $areaID;
	var $name;
	var $descInt ;
	var $desc;

// 0-> list of takeoffs
// 1-> bounding box
// 2-> circle
// 3-> polygon
	var $areaType;
	var $min_lat;
	var $max_lat ;
	var $min_lon ;
	var $max_lon ;
	var $center_lat;
	var $center_lon;
	var $radius;
	var $polygon;
	var $isInclusive;


	var $valuesArray;
	var $gotValues;

	function area($id="") {
		if ($id!="") {
			$this->ID=$id;
		}
	    $this->valuesArray=array("ID","name","descInt","desc","areaType",
			"min_lat","max_lat","min_lon","max_lon","center_lat","center_lon","radius","polygon","isInclusive");
		$this->gotValues=0;
	}

	function getTakeoffs($areaID) {
		global $db;
		global $waypointsTable ,$areasTakeoffsTable;
	
		$query="SELECT * FROM $waypointsTable,$areasTakeoffsTable	
			WHERE $areasTakeoffsTable.takeoffID = $waypointsTable.ID AND $areasTakeoffsTable.areaID=$areaID";
		// echo $query;
		$res= $db->sql_query($query);		
		if($res <= 0){
			echo "No takeoffs found for area ID $areaID<BR>";
			return array( array (),array () );
		}
	
		$takeoffs=array();
		$takeoffsID=array();
		while ($row = $db->sql_fetchrow($res)) { 
			 $tnames[$row["takeoffID"]]=getWaypointName($row["takeoffID"],-1,1);
		}
		if (!empty($tnames)) {
			asort($tnames);
			foreach($tnames as $takeoffID=>$takeoffName) {
					 array_push($takeoffs,$takeoffName );
					 array_push($takeoffsID,$takeoffID );
			}
		}
		return array($takeoffs,$takeoffsID);
	
	}

	
	function getFromDB() {
		global $db,$areasTable ;

		$res= $db->sql_query("SELECT * FROM $areasTable WHERE ID=".$this->ID );
  		if($res <= 0){   
			 echo "Error getting club from DB<BR>";
		     return;
	    }

	    $row = $db->sql_fetchrow($res);
		foreach ($this->valuesArray as $valStr) {
			$this->$valStr=$row["$valStr"];					
		}
		$this->gotValues=1;
    }

	function putToDB($update=0) {
		global $db,$areasTable;

		if ($update) {
			$query="REPLACE INTO ";		
			$fl_id_1="ID,";
			$fl_id_2=$this->ID.", ";
		}else {
			$query="INSERT INTO ";		
			$fl_id_1="";
			$fl_id_2="";
		}


		$query.=" $areasTable  ( ";
		foreach ($this->valuesArray as $valStr) {
				$query.= $valStr.",";		
		}
		$query=substr($query,0,-1);

		$query.= " ) VALUES ( ";
		foreach ($this->valuesArray as $valStr) {
			$query.= "'".prep_for_DB($this->$valStr)."',";
		}
		$query=substr($query,0,-1);
		$query.= " ) ";
		// echo $query;
	    $res= $db->sql_query($query);
	    if($res <= 0){
		  echo "Error putting club to DB<BR>";
		  return 0;
	    }		
		$this->gotValues=1;			
		return 1;
    }

}

?>
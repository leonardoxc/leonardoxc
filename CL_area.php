<?
//************************************************************************
// Leonardo XC Server, https://github.com/leonardoxc/leonardoxc
//
// Copyright (c) 2004-2010 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: CL_area.php,v 1.7 2010/04/21 07:55:49 manolis Exp $                                                                 
//
//************************************************************************

/*


*/

$areaTypeTextArray=array(0=>"List of takeoffs",1=>"Bouding box",2=>"Bounding Circle",3=>"Bounding polygon" );


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

	// areaType=0 collection of takeoffs
	// areaType=1 , bounding box 
		
	
	function area($id="") {
		if ($id!="") {
			$this->ID=$id;
		}
	    $this->valuesArray=array("ID","name","descInt","desc","areaType",
			"min_lat","max_lat","min_lon","max_lon","center_lat","center_lon","radius","polygon","isInclusive");
		$this->gotValues=0;
	}

	function areaTypeText($id) {
		global $areaTypeTextArray;
		return $areaTypeTextArray[$id];
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


	function deleteArea() {
		global $db,$areasTable,$areasTakeoffsTable ;

		$res= $db->sql_query("DELETE FROM $areasTable WHERE ID=".$this->ID );
  		if($res <= 0){   
			 echo "Error deleting area from DB<BR>";
		     return 0;
	    }

		$res= $db->sql_query("DELETE FROM $areasTakeoffsTable WHERE areaID=".$this->ID );
  		if($res <= 0){   
			 echo "Error removing takeoffs from area <BR>";
		     return 0;
	    }

		$this->gotValues=0;
		return 1;
    }
	
	function getFromDB() {
		global $db,$areasTable ;

		$res= $db->sql_query("SELECT * FROM $areasTable WHERE ID=".$this->ID );
  		if($res <= 0){   
			 echo "Error getting area from DB<BR>";
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
				$query.= "`$valStr`,";		
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
		  echo "Error putting area to DB: $query<BR>";
		  return 0;
	    }		
		$this->gotValues=1;			
		return 1;
    }

}

?>
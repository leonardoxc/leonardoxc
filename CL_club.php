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
// $Id: CL_club.php,v 1.5 2008/11/29 22:46:06 manolis Exp $                                                                 
//
//************************************************************************

/*

A  "NAC /club / group" is a list of pilots

Group types: regarding membership

1) a pilot must be added/deleted manually to the group 
	Procedure :	Pilots can 
	a) request addition from the group admin
	b) add themsleves automatically to open groups
	c) be addded by the admin with no request and no way of declining 
	d) be addded by the admin with no request BUT with the option of declining / accepting
	
2) - a pilot can be added automatically to the group by any /all of the following
	a) nationallity
	b) membership to another group
	c) submitting a flight which is any /all of the following
		1) in a given county
		2) in a given area
		3) in a given takeoff
		4) in a given date - period
		
		
		
EVENTS / LEAGUES / CATEGORIES / COMPETITIONS

An event may be linked to 
1) Time : Year, Months , Dates, Periods,
2) Groups/ clubs


A group/club can have many events (or categories)


An event may include/exclude flights based on

1) Takeoff or area
2) Glider Category
3) Pilot experience
4) Date ( ie weekends)
5) Male / Female
6) Age
7) lat / lon of takeoff 
8) various metrics of the flight  like :
	1) Free distance
	2) Free Triangle
	3) FAI triangle
	4) OLC turnpoints
	5) Out and return
	7) duration
9) Brand of Glider

The  include/exclude can be 
1) automatic with no way tha pilot can decide
2) The club admin decides
3) the pilot decides



An event may have its own scoring formula

Inputs to the formula  will be 
1) Takeoff or area
2) Glider Category
3) Pilot experience
4) Date ( ie weekends)
5) Male / Female
6) Age
7) lat / lon of takeoff 
8) various metrics of the flight  like :
	1) Free distance
	2) Free Triangle
	3) FAI triangle
	4) OLC turnpoints
	5) Out and return
	6) Height
	7) duration
	8) Mean speed
	9) Max speed
	10) turnpoints reached
	11) distance form last turnpoint
	12) Time
	


OR use the stantard Leonardo scoring and layout 


*/


class club {
	var $ID;
	var $name;
	var $intName;
	var $description;
	var $intDescription;
	var $countryCode;
	var $location;
	var $intLocation;
	var $link;
	var $cat;
	var $formula;
	var $fomulaParameters;

	var $valuesArray;
	var $gotValues;
	function club($id="") {
		if ($id!="") {
			$this->ID=$id;
		}
	    $this->valuesArray=array("ID","name","intName","description","intDescription",
			"countryCode","location","intLocation","link","cat","formula","fomulaParameters");
		$this->gotValues=0;
	}

    function getAttribute($attrName,$forceIntl=-1) {
		global $db, $currentlang,$nativeLanguage,$CONFIG_forceIntl;
		if (!$this->gotValues) $this->getFromDB();
		
        if ($forceIntl==-1) $forceIntl=$CONFIG_forceIntl	;
		
		$intName="int".strtoupper( substr($attrName,0,1) ).substr($attrName,1);
		
		if ( countryHasLang($this->countryCode,$currentlang)  && !$forceIntl ) {
			$name=$attrName;
			if (!$this->{$name}) $name=$intName;
		} else {
			$name=$intName;
			if (!$this->{$name}) $name=$attrName;
		}

		return $this->{$name};
	}
	
	function getFromDB() {
		global $db,$clubsTable;
		$res= $db->sql_query("SELECT * FROM $clubsTable WHERE ID=".$this->ID );
  		if($res <= 0){   
			 echo "Error getting club from DB<BR>";
		     return;
	    }

	    $clubInfo = $db->sql_fetchrow($res);
		foreach ($this->valuesArray as $valStr) {
			$this->$valStr=$clubInfo["$valStr"];					
		}
		$this->gotValues=1;
    }

	function putToDB($update=0) {
		global $db,$clubsTable;

		if ($update) {
			$query="REPLACE INTO ";		
			$fl_id_1="ID,";
			$fl_id_2=$this->ID.", ";
		}else {
			$query="INSERT INTO ";		
			$fl_id_1="";
			$fl_id_2="";
		}


		$query.=" $clubsTable  ( ";
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
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
			$query.= "'".prep_for_DB($this->description)."',";
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
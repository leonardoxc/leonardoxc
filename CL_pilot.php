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


class pilot{
	var $pilotID,$serverID;

	var $valuesArray;
	var $gotValues;

	function pilot($serverID="",$pilotID="") {
		if ($pilotID!="") 	$this->pilotID=$pilotID;
		if ($serverID!="") 	$this->serverID=$serverID;

	    $this->valuesArray=array("pilotID", "serverID", "countryCode", "CIVL_ID", "NACid", "NACmemberID", "NACclubID", 
"olcBirthDate", "olcFirstName", "olcLastName", "olcCallSign", "olcFilenameSuffix", "olcAutoSubmit", 
"FirstName", "LastName", "clubID", "sponsor", "Sex", "Birthdate", "Occupation", "MartialStatus", "OtherInterests", 
"PersonalWebPage", "PilotLicence", "BestMemory", "WorstMemory", "Training", "personalDistance", "personalHeight",
 "glider", "FlyingSince", "HoursFlown", "HoursPerYear", "FavoriteLocation", "UsualLocation", "FavoriteBooks", 
"FavoriteActors", "FavoriteSingers", "FavoriteMovies", "FavoriteSite", "Sign", 
"Spiral", "Bline", "FullStall", "Sat", "AsymmetricSpiral", "Spin", "OtherAcro",
 "camera", "camcorder", "Vario", "GPS", "Harness", "Reserve", "Helmet", "PilotPhoto"
);
		$this->gotValues=0;
	}

	function pilotExists() {
		global $db,$pilotsTable;
		$query="SELECT * FROM $pilotsTable WHERE pilotID=".$this->pilotID." AND serverID=".$this->serverID ;
		$res= $db->sql_query($query);
  		if($res <= 0){   
			 echo "Error in pilotExists() $query<BR>";
		     return;
	    }
		if ($db->sql_numrows($res) ) return 1;
		else return 0;
	}

	function isPilotLocal() {
		global $CONF_server_id;
		if (! $this->serverID || $this->serverID==$CONF_server_id) return 1;
		else return 0;	
	}

	function createDirs() {
		global $flightsAbsPath,$CONF_server_id;
		if ( $this->isPilotLocal() ) $sPrefix='';
		else $sPrefix=$this->serverID.'_';
		$pilotPath=$flightsAbsPath.'/'.$sPrefix.$this->pilotID;
		@mkdir($pilotPath."/flights");
		@mkdir($pilotPath."/charts");
		@mkdir($pilotPath."/maps");
		@mkdir($pilotPath."/photos");
	}

	function getFromDB() {
		global $db,$pilotsTable;
		$res= $db->sql_query("SELECT * FROM $pilotsTable WHERE pilotID=".$this->pilotID." AND serverID=".$this->serverID );
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
		global $db,$pilotsTable;

		if ($update) {
			$query="REPLACE INTO ";		
			$fl_id_1="pilotID,serverID, ";
			$fl_id_2=$this->pilotID.", ".$this->serverID.",";
		}else {
			$query="INSERT INTO ";		
			$fl_id_1="";
			$fl_id_2="";
		}


		$query.=" $pilotsTable  ( ";
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
		  echo "Error putting pilot to DB : $query<BR>";
		  return 0;
	    }		
		$this->gotValues=1;			
		return 1;
    }

}

?>
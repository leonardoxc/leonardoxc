<?
//************************************************************************
// Leonardo XC Server, http://www.leonardoxc.net
//
// Copyright (c) 2004-2010 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: CL_pilot.php,v 1.16 2010/11/21 14:26:01 manolis Exp $                                                                 
//
//************************************************************************


class pilot{
	var $pilotID,$serverID;

	var $valuesArray;
	var $gotValues;

	function pilot($serverID="",$pilotID="") {
		global $CONF_server_id;
		if ($pilotID!="") 	$this->pilotID=$pilotID;
		if ($serverID!="") 	$this->serverID=$serverID;

		if ($this->serverID==$CONF_server_id) {
			$this->serverID=0;
		}

		$this->serverID=$this->serverID+0;
		
	    $this->valuesArray=array( "pilotID", "serverID", 
"FirstName", "LastName","countryCode", 
"NACid", "NACmemberID", "NACclubID", "CIVL_ID",
"sponsor",  "Birthdate", "BirthdateHideMask",
"Occupation", "MartialStatus", "OtherInterests", 
"PilotLicence","BestMemory", "WorstMemory", "Training", "personalDistance", "personalHeight",
"glider", "FlyingSince", "HoursFlown", "HoursPerYear", "FavoriteLocation", "UsualLocation", 
"FavoriteBooks", "FavoriteActors", "FavoriteSingers", "FavoriteMovies", "FavoriteSite", "Sign", 
"Spiral", "Bline", "FullStall", "Sat", "AsymmetricSpiral", "Spin", "OtherAcro",
"camera", "camcorder", "Vario", "GPS", "Harness",  "Helmet", "Reserve", 
"Sex","PilotPhoto", "PersonalWebPage", "FirstOlcYear",
"clubID", "commentsEnabled"
);
		
		
	    $this->valuesArray1=array( "pilotID", "serverID", 
			"FirstName", "LastName","countryCode", "NACid", "NACmemberID", "NACclubID", "CIVL_ID",
			 "Birthdate", "BirthdateHideMask","Sex","PilotPhoto", "FirstOlcYear","clubID", 
		);
		
	    $this->valuesArray2=array( "pilotID", "serverID", 
"sponsor","Occupation", "MartialStatus", "OtherInterests", 
"PilotLicence","BestMemory", "WorstMemory", "Training", "personalDistance", "personalHeight",
"glider", "FlyingSince", "HoursFlown", "HoursPerYear", "FavoriteLocation", "UsualLocation", 
"FavoriteBooks", "FavoriteActors", "FavoriteSingers", "FavoriteMovies", "FavoriteSite", "Sign", 
"Spiral", "Bline", "FullStall", "Sat", "AsymmetricSpiral", "Spin", "OtherAcro",
"camera", "camcorder", "Vario", "GPS", "Harness",  "Helmet", "Reserve", 
"PersonalWebPage","commentsEnabled" );

		$this->gotValues=0;
	}

	function pilotExists() {
		global $db,$pilotsTable;
		$query="SELECT pilotID FROM $pilotsTable WHERE pilotID=".$this->pilotID." AND serverID=".($this->serverID+0) ;
		$res= $db->sql_query($query);
  		if($res <= 0){   
			 echo "Error in pilotExists() $query<BR>";
		     return;
	    }   
		if ($row = $db->sql_fetchrow($res) ) return 1;
		else return 0;
	}

	
	function movePilotFlights($newServerID,$newUserID){
		$newPilot=new pilot($newServerID,$newUserID);
		if (!$newPilot->pilotExists()) {
			echo "movePilotFlights($newServerID,$newUserID): The target pilot does not exist<BR>";
			return 0;
		}
		
		global $db,$flightsTable;
		// first see if a mapping exists
		
		$query="SELECT ID FROM $flightsTable WHERE userID=".$this->pilotID.
				" AND userServerID=".$this->serverID." ";
		
			
		$res= $db->sql_query($query);		
		if($res <= 0){
			echo("<H3> Error in movePilotFlights query! $query</H3>\n");
			return 0;
		}	
		while (  $row = $db->sql_fetchrow($res) ) {	
			echo "moving flight ".$row['ID'].'<BR>';
			// continue;
			$flight2move=new flight();
			$flight2move->getFlightFromDB($row['ID']);
			$flight2move->changeUser($newUserID,$newServerID);
		}
		
	}
	
	function pilotMapping() {
		global $db,$pilotsTable,$remotePilotsTable;
		// first see if a mapping exists
		
		$query="SELECT * FROM $remotePilotsTable  
				WHERE	( serverID=".($this->serverID+0)." AND userID=".$this->pilotID ." ) OR 
						( remoteServerID=".($this->serverID+0)." AND remoteUserID=".$this->pilotID. " ) ";
		
		$res= $db->sql_query($query);		
		if($res <= 0){
			echo("<H3> Error in checkPilot query! $query</H3>\n");
			return array();
		}		

		$i=0;
		$map=array();
		while (  $row = $db->sql_fetchrow($res) ) {	
			$map[ $row['remoteServerID'] ][ $row['remoteUserID'] ] ++;
			$map[ $row['serverID'] ][ $row['userID'] ] ++;

			/*			
			if ($this->serverID==$row['serverID']  && $this->pilotID==$row['userID']) {
				$map[$i]['serverID']=$row['remoteServerID'];
				$map[$i]['userID']=$row['remoteUserID'];			
			} else {
				$map[$i]['serverID']=$row['serverID'];
				$map[$i]['userID']=$row['userID'];
			}				
			*/
			$i++;
		}
		
		return $map;
	}
	
	
	function isPilotLocal() {
		global $CONF_server_id;
		if (! $this->serverID || $this->serverID==$CONF_server_id) return 1;
		else return 0;	
	}

	function getPilotID() {
		if ($this->isPilotLocal()) $extra_prefix='';
		else  $extra_prefix=$this->serverID.'_';

		return $extra_prefix.$this->pilotID;
	}
	
	function getAbsPath() {
		global $CONF;				
		return LEONARDO_ABS_PATH.'/'.str_replace("%PILOTID%",$this->getPilotID(),$CONF['paths']['pilot'] );
	}

	function getRelPath() {
		global $moduleRelPath,$CONF;
		return $moduleRelPath.'/'.str_replace("%PILOTID%",$this->getPilotID(),$CONF['paths']['pilot'] );
	}

	function createDirs() {
		$pilotPath=$this->getAbsPath();
		if (! is_dir($pilotPath) ) makeDir($pilotPath);
	}

	function deletePilot($deleteFlights=0,$deleteFiles=0) {
		global $db,$pilotsTable,$pilotsInfoTable;
		
		$err=0;
		$sql="DELETE FROM $pilotsTable WHERE pilotID=".$this->pilotID." AND serverID=".($this->serverID+0);
		$res= $db->sql_query($sql);
  		if($res <= 0){   
			 echo "Error deleting pilot from DB $sql<BR>";
		     $err=1;
	    }
		
		$sql="DELETE FROM $pilotsInfoTable WHERE pilotID=".$this->pilotID." AND serverID=".($this->serverID+0) ;
		$res= $db->sql_query($sql);
  		if($res <= 0){   
			 echo "Error deleting pilot info from DB $sql<BR>";
		     $err=1;
	    }
		
		if ($deleteFiles) {
			$pilotPath=$this->getAbsPath();
			delDir($pilotPath);
		}		
		
		return $err;
	}
	
	function getFromDB() {
		global $db,$pilotsTable,$pilotsInfoTable;
		$query="SELECT * FROM $pilotsTable LEFT JOIN $pilotsInfoTable ON
				($pilotsTable.pilotID=$pilotsInfoTable.pilotID AND $pilotsTable.serverID=$pilotsInfoTable.serverID )
			WHERE 
				$pilotsTable.pilotID=".$this->pilotID." AND $pilotsTable.serverID=".($this->serverID+0) ;
		// "SELECT * FROM $pilotsTable WHERE pilotID=".$this->pilotID." AND serverID=".$this->serverID 	
			
		$res= $db->sql_query($query);
  		if($res <= 0){   
			 echo "Error getting pilot from DB<BR>";
		     return;
	    }

	    $row = $db->sql_fetchrow($res);
		foreach ($this->valuesArray as $valStr) {
			$this->$valStr=$row["$valStr"];					
		}
		$this->gotValues=1;
    }

	function putToDB($update=0) {
		$res1=$this->putToDB1($update);
		$res2=$this->putToDB2($update);
		return $res1 && $res2;
	}
	
	function putToDB1($update=0) {
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
		foreach ($this->valuesArray1 as $valStr) {
				$query.= $valStr.",";		
		}
		$query=substr($query,0,-1);

		$query.= " ) VALUES ( ";
		
		
		foreach ($this->valuesArray1 as $valStr) {
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

	function putToDB2($update=0) {
		global $db,$pilotsInfoTable;

		if ($update) {
			$query="REPLACE INTO ";		
			$fl_id_1="pilotID,serverID, ";
			$fl_id_2=$this->pilotID.", ".$this->serverID.",";
		}else {
			$query="INSERT INTO ";		
			$fl_id_1="";
			$fl_id_2="";
		}


		$query.=" $pilotsInfoTable  ( ";
		foreach ($this->valuesArray2 as $valStr) {
				$query.= $valStr.",";		
		}
		$query=substr($query,0,-1);

		$query.= " ) VALUES ( ";
		
		
		foreach ($this->valuesArray2 as $valStr) {
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
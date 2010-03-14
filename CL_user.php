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
// $Id: CL_user.php,v 1.3 2010/03/14 20:56:10 manolis Exp $                                                                 
//
//************************************************************************


class LeoUser {
	var $userID;

	var $valuesArray;
	var $gotValues;

	function LeoUser($userID="") {
		if ( $userID) 	$this->userID=$userID+0;

	    $this->valuesArray=array("pilotID", "serverID", "countryCode",
					 "CIVL_ID", "NACid", "NACmemberID", "NACclubID"
);
		$this->gotValues=0;
	}


	function changeEmail($userID,$newEmail) {	
		if ( function_exists('leoUser_changeEmail') ) {
			return leoUser_changeEmail($userID,$newEmail);
		} else return 0;
	}
	
	function changePassword($userID,$newPassword) {
		if ( function_exists('leoUser_changePassword') ) {
			return leoUser_changePassword($userID,$newPassword);
		} else return 0;
	}
	
	function userExists() {
		global $db,$pilotsTable;
		$query="SELECT * FROM $pilotsTable WHERE pilotID=".$this->pilotID." AND serverID=".($this->serverID+0) ;
		$res= $db->sql_query($query);
  		if($res <= 0){   
			 echo "Error in pilotExists() $query<BR>";
		     return;
	    }
		if ($db->sql_numrows($res) ) return 1;
		else return 0;
	}


	function deleteUser($deleteFlights=0,$deleteFiles=0) {
		global $db,$pilotsTable;
		
		$err=0;
		$sql="DELETE FROM $pilotsTable WHERE pilotID=".$this->pilotID." AND serverID=".$this->serverID ;
		$res= $db->sql_query($sql);
  		if($res <= 0){   
			 echo "Error deleting pilot from DB $sql<BR>";
		     $err=1;
	    }
		
		if ($deleteFiles) {
			$pilotPath=$this->getAbsPath();
			delDir($pilotPath);
		}		
		
		return $err;
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
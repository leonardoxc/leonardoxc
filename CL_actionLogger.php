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
// $Id: CL_actionLogger.php,v 1.19 2010/07/29 14:00:58 manolis Exp $                                                                 
//
//************************************************************************


/* 
transactionID  autoincrement

actionTime   the tm of the action
userID  - the user that commits the action
effectiveUserID  - the user for whom the action is taken
ItemType - on an item that is of type :

1 => flight
2 => pilot
4 => waypoint
8 => NAC / club  / group
16=> League / event 
32=> Area ( group of waypoints ) 

ItemID - the item 
ServerItemID - the server of the item -> those 2 define an item in the distributed DB network

ActionID  - what the user does 
1  => add
2  => edit
4  => delete
8  => Score  (flight only)
16 => Rename TrackLog (flight only)
32 => Create Map (flight only)
64 => 
128=>
256=>
512=>

ActionXML - XML that describes the action so it
			 can be reproduced later/in another server

Modifier
0=> nothing special
1=> Club ( ie   user adds pilot to club  )
2=> League / event  ( ie user adds flight to event ) 
4=> Area  ( ie   user adds waypoint to area )


ModifierID - ie clubId of LeagueID
ServerModifierID - the server on which the the extra item resides

Result 
0=> Problem  (initial)
1=> OK
2=> Pending

Result Description  - if any furthe info needs to logged (ie in cae of error)



--------------------------------------------------------------


Moderation
0=> not needed
1=> needs aproval
2=>
4=>

Moderation Result
0=> Pending Approve
1=> Approved
2=> Not Approved

ModerationTime
ModerationUserID - the user that aproved /disapproved
Moderation Comments

--------------------------------------------------------------
Distribution: 
- if we are a slave - propagation will be to the master only 
- if we are the MASTER we must propagate to all slaves. Not many cases this will happen

Distribution
0=> no action needed
1=> propagation needed and pending 


sourceServerID
destServerID
direction - client to Server OR server to client

excludeServer  the ids of the servers to exclude when acting as a master . 
				common use is to exclude the clinet that propagated info to us

DistributionResult
0=> pending
1=> propagation successfull 
2=> propagation failed - final

DistributionTime the time that the propagation occured


--------------------------------------------------------------

ObjectBefore -> blog serialized class
ObjectAfter  ->blog serialized class

*/

$itemTypes=array(
1 => "Flight",
2 => "Pilot",
4 => "Waypoint",
8 => "NAC / Club  / Group",
16=> "League / Event ",
32=> "Area  ",
);

$actionTypes=array(
1  => "Add",
2  => "Edit",
4  => "Delete",
8  => "Score",
16 => "Rename TrackLog",
32 => "Create Map",
);

class Logger { 
	var $transactionID ;
	var $actionTime ;
	var $userID  ;
	var $effectiveUserID  ;
	var $ItemType; 
	var $ItemID ;
	var $ServerItemID ;
	var $ActionID  ;
	var $ActionXML;
	var $Modifier;
	var $ModifierID ;
	var $ServerModifierID ;
	var $Result ;
	var $ResultDescription ;

	function Logger() {
	}

	function getItemDescription($it) {
		global 	$itemTypes;
		return $itemTypes[$it];
	}
	
	function getActionDescription($act) {
		global 	$actionTypes;
		return $actionTypes[$act];
	}
	
	function deleteLogsFromDB($type,$actionType=0){
		global $db, $logTable;
		
		if ($type)  {
			$where_clause=" WHERE ItemType=$type ";
			if ($actionType)  $where_clause.=" AND ActionID=$actionType ";

			// if (! $actionType) $where_clause.=" AND ServerItemID>1 ";
		}

		$query = "DELETE from $logTable $where_clause";
		// echo $query;
		$res = $db->sql_query($query);
		if ($res) return 1;
		else { 
			echo "Problem in deleting log entries from DB $query<br>";
			return 0;		
		}

	}
	
	function put(){
		global $db, $logTable, $userID, $CONF;

		// 
		if ( ! $CONF['log']['logActions'][$this->ItemType] || !$CONF['log']['logActionsType'][$this->ActionID]) {
			// logging is disabled for hthis actions type	
			return 1;
		}
		
		$userID+=0;
		# martin jursa 21.6.2008 to avoid error log flooding
		if (!empty($CONF['servers']['syncLog']['dontLog']) && is_array($CONF['servers']['syncLog']['dontLog'])) {
			//old: if ( @in_array($this->ServerItemID,$CONF['servers']['syncLog']['dontLog']) ) {
			if ( in_array($this->ServerItemID,$CONF['servers']['syncLog']['dontLog']) ) {
				// we dont put log entries for these servers
				return 1;
			}
		}

		$this->ActionXML=addslashes($this->ActionXML);
		$DBvars=array(	'actionTime',	'userID',	'effectiveUserID',
	'ItemType',	'ItemID',	'ServerItemID',	'ActionID',	'ActionXML',
	'Modifier',	'ModifierID',	'ServerModifierID',	'Result',	'ResultDescription' );

		$this->actionTime=time();
		$this->effectiveUserID=$userID;
		
		foreach ($DBvars as $varName) {
				$vars_list.="$varName,";
				if ($varName=='ActionXML') 
					$values_list.='"'.$this->$varName.'",';
				else 
					$values_list.="'".addslashes ($this->$varName)."',";
		}

		$vars_list=substr($vars_list,0,-1);
		$values_list=substr($values_list,0,-1);

		$query = "INSERT into $logTable ($vars_list ) VALUES ($values_list)";
		// echo $query;
		$res = $db->sql_query($query);
		if ($res) return $db->sql_nextid();
		else { 
			echo "Problem in inserting log entry into DB $query<br>";
			return 0;		
		}
		return 1;
	}
		

	function formatTime($time) {
		return date("Y/m/d H:i:s",$time);
	//	preg_match("/(\d\d\d\d)(\d\d)(\d\d)(\d\d)(\d\d)(\d\d)/",$time,$parts);
	//	return $parts[1]."/".$parts[2]."/".$parts[3]." ".$parts[4].":".$parts[5].":".$parts[6];
	}
	
} // end of class

?>
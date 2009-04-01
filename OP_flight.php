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
// $Id: OP_flight.php,v 1.16 2009/04/01 20:18:31 manolis Exp $                                                                 
//
//************************************************************************


$serverFunctions['flights.count']='flights_count';
function flights_count($arg) {
	global $db,$flightsTable;
	$sitePass=$arg[0];
	$from_tm=$arg[1];
	$limit=	$arg[2];

	if ( ! securityCheck($sitePass) ) return  new IXR_Error(4000, 'Access Denied');;

	$where_clause="AND dateAdded >= FROM_UNIXTIME(".$tm.") "; 
	
	if ($limit) $lim=" LIMIT 1,$limit ";
	else  $lim="";

	$query="SELECT count() as flights_num FROM $flightsTable WHERE private=0 $where_clause ORDER BY dateAdded DESC $lim ";
	//echo $query;
	$res= $db->sql_query($query);
	if($res <= 0) return  new IXR_Error(4000, 'Error in query! '.$query);
		
	$row = mysql_fetch_assoc($res);
	$flights_num=$row['flights_num'];
	return $flights_num; 
}


$serverFunctions['flights.find']='flights_find';
function flights_find($arg) {
		global $db,$flightsTable;
		global $takeoffRadious;
		require_once "FN_pilot.php";

		$sitePass=$arg[0];
		$lat=$arg[1];
		$lon=-$arg[2];
		$limit=	$arg[3];

		if ( ! securityCheck($sitePass) ) return  new IXR_Error(4000, 'Access Denied');;

		$firstPoint=new gpsPoint();
		$firstPoint->lat=$lat;
		$firstPoint->lon=$lon;

		// calc TAKEOFF - LANDING PLACES	
		if (count($waypoints)==0) 
			$waypoints=getWaypoints(0,1);
	
		$takeoffIDTmp=0;
		$minTakeoffDistance=10000000;
		$i=0;

		foreach($waypoints as $waypoint) {
		   $takeoff_distance = $firstPoint->calcDistance($waypoint);
		   if ( $takeoff_distance < $minTakeoffDistance ) {
				$minTakeoffDistance = $takeoff_distance;
				$takeoffIDTmp=$waypoint->waypointID;
		   }
			$i++;
		}

		 $nearestWaypoint=new waypoint($takeoffIDTmp);
		 $nearestWaypoint->getFromDB();

		 //$nearestWaypoint;
		 //$minTakeoffDistance;

		 if ($limit>0) $lim="LIMIT $limit";
		 else $lim="";
		 $where_clause ="AND takeoffID=$nearestWaypoint->waypointID";
		 $query="SELECT * FROM $flightsTable WHERE private=0 $where_clause ORDER BY FLIGHT_POINTS  DESC $lim ";
		 //echo $query;

		 $res= $db->sql_query($query);
		 if($res <= 0){
			return  new IXR_Error(4000, 'Error in query! '.$query);
		 }

		$flights=array();
		$i=0;
		while ($row = mysql_fetch_assoc($res)) { 
			$name=getPilotRealName($row["userID"],$row["serverID"]);
			$link=htmlspecialchars ("http://".$_SERVER['SERVER_NAME'].
										getLeonardoLink(array('op'=>'show_flight','flightID'=>$row['ID']))
									);
			$this_year=substr($row['DATE'],0,4);		
			$linkIGC=htmlspecialchars ("http://".$_SERVER['SERVER_NAME'].getRelMainDir().$flightsRelPath."/".$row[userID]."/flights/".$this_year."/".$row[filename] );  
			
			if ($row['takeoffVinicity'] > $takeoffRadious ) 
				$location=getWaypointName($row['takeoffID'])." [~".sprintf("%.1f",$row['takeoffVinicity']/1000)." km]"; 
			else $location=getWaypointName($row['takeoffID']);
	
			$flights[$i]['pilot']=htmlspecialchars($name);
			$flights[$i]['takeoff']=htmlspecialchars($location);
			$flights[$i]['date']=$row['DATE'];
			$flights[$i]['duration']=$row['DURATION'];
			$flights[$i]['openDistance']=$row['MAX_LINEAR_DISTANCE'];
			$flights[$i]['OLCkm']=$row['FLIGHT_KM'];
			$flights[$i]['OLCScore']=$row['FLIGHT_POINTS'];
			$flights[$i]['OLCtype']=$row['BEST_FLIGHT_TYPE'];
			$flights[$i]['displayLink']=$link;
			$i++;
		}

		return array($i,$flights);
		//return array($i,0);

}

/*$serverFunctions['flights.getIGCurl']='flights_getIGCurl';
function flights_getIGCurl($args) {
		global $db,$flightsTable;
		global $takeoffRadious;	

		$sitePass=$arg[0];
		$flightID=$arg[1];

		if ( ! securityCheck($sitePass) ) return  new IXR_Error(4000, 'Access Denied');;

		$flight=new flight();
		$flight->getFlightFromDB($flightID,0);		

}
*/

// this runs on the master so that slaves can upload flights
// !!!!!!!!!!!!!!!!!!!!!!!!!!!
// more security needed!!!!!!!!!!!!!!!!!!!!
// !!!!!!!!!!!!!!!!!!!!!!!!!!!
$serverFunctions['flights.submit']='flights_submit';
function flights_submit($args) {
	global $opMode;
	
	require_once dirname(__FILE__)."/FN_flight.php";

	$username=$args[0];
	$passwd=$args[1];
	$igcURL=$args[2];
	$igcFilename=$args[3];
	$private=$args[4];
	$cat=$args[5];
	$linkURL=$args[6];
	$comments=$args[7];
	$glider=$args[8];

	global $db,$CONF;
	
	if ($CONF['userdb']['password_users_table']) {
		$dbTable=$CONF['userdb']['password_users_table'];
	} else {
	
	
	}
	
	$sql = "SELECT ".$CONF['userdb']['user_id_field'].", ".$CONF['userdb']['username_field'].", ".$CONF['userdb']['password_field'].
			" FROM ".$CONF['userdb']['users_table']." WHERE LOWER(".$CONF['userdb']['username_field'].") = '".
			strtolower($username)."'";
	if ( !($result = $db->sql_query($sql)) ) {
		return  new IXR_Error(200, "Error in obtaining userdata for $username");
	}
	
	$passwordHashed='';
	
	if ($CONF['userdb']['password_users_table']) {
		
		$sql2 = "SELECT  ".$CONF['userdb']['password_username_field'].", ".$CONF['userdb']['password_password_field'].
			" FROM ".$CONF['userdb']['password_users_table']." WHERE LOWER(".$CONF['userdb']['password_username_field'].") = '".	strtolower($username)."'";
			
		if ( !($result2 = $db->sql_query($sql2)) ) {
			return  new IXR_Error(200, "Error in obtaining userdata2 for $username");
		}
		

		if( $row2 = $db->sql_fetchrow($result2) ) {
			$passwordHashed=$row2[$CONF['userdb']['password_password_field']];
		}	
	}
	
	//echo "$passwordHashed %";
	
	$passwdProblems=0;
	if( $row = $db->sql_fetchrow($result) ) {
		if (!$passwordHashed) {
			$passwordHashed=$row[$CONF['userdb']['password_field']];
		}
			
		if ( function_exists('leonardo_check_password') ) { // phpbb3 has custom way of hashing passwords
			if( ! leonardo_check_password($passwd,$passwordHashed)  ) $passwdProblems=1;			
		} else {
			if( md5($passwd) != $passwordHashed ) $passwdProblems=1;
		}	
	} else 	{		
		return  new IXR_Error(200, "Error in obtaining userdata for $username");
	}
	
	if ($passwdProblems) {
		return  new IXR_Error(201, "Error in password for $username");
	}


	$userID=$row['user_id'];
 
	$filename = dirname(__FILE__)."/flights/".$igcFilename;
	if (!$handle = fopen($filename, 'w')) { 
		return  new IXR_Error(202, "Cannot open file ($filename)");
	} 

	// $igcURL=html_entity_decode($igcURL);
	$igcURL=rawurldecode($igcURL);
	// return  new IXR_Error(203, "Cannot get igcURL ($igcURL)");
	
	$igcStr=fetchURL($igcURL,10); // timeout 10 secs
	if (!$igcStr) {
		return  new IXR_Error(203, "Cannot get igcURL ($igcURL)");
	}

	if (!fwrite($handle,$igcStr)) { 
		return  new IXR_Error(204, "Cannot write to file ($filename)");
	} 		
	@fclose($handle); 
	
	error_reporting(0);
	ob_start();
	

	list($errCode,$flightID)=addFlightFromFile($filename,0,	$userID, 
						array('private'=>$private,'cat'=>$cat,'category'=>1 , 
							  'linkURL'=>$linkURL,'comments'=>$comments,'glider'=>$glider) 
					) ;
	$errorBuffer=ob_get_contents();	
	ob_end_clean();
	
	$flightID+=0;	
	
	if ($errCode==1 && $flightID!=0) { // all ok 
		// return  new IXR_Error(500,htmlspecialchars("flightID:$flightID^errCode:$errCode^" ));
		return $flightID;
	} else {
	
		if ( $errCode==1 && $flightID==0) {
			$errStr="The IGC file did not contain a valid flight";
		} else {
			$errStr=htmlspecialchars(getAddFlightErrMsg($errCode,$flightID) ) ;		
		}	

		// $errStr.=htmlspecialchars("#----------\n".$errorBuffer);
		return  new IXR_Error(500,$errStr );
	}

}


?>
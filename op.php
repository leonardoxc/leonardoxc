<?php

require_once dirname(__FILE__)."/soap/IXR_Library.inc.php";


require_once dirname(__FILE__)."/config_op_mode.php";
require_once dirname(__FILE__)."/config_admin_email.php";

require_once dirname(__FILE__)."/EXT_config_pre.php";
require_once dirname(__FILE__)."/config.php";
require_once dirname(__FILE__)."/EXT_config.php";

require_once dirname(__FILE__)."/CL_flightData.php";
require_once dirname(__FILE__)."/FN_functions.php";	
require_once dirname(__FILE__)."/FN_UTM.php";
require_once dirname(__FILE__)."/FN_waypoint.php";	
require_once dirname(__FILE__)."/FN_output.php";

$moduleRelPath="modules/".$module_name;
$flightsWebPath=$moduleRelPath."/".$flightsRelPath;


function findTakeoff($args) {
	$sitePass=$args[0];
	$lat=$args[1];
	$lon=$args[2];
	if ( ! securityCheck($sitePass) ) return  new IXR_Error(4000, 'Access Denied');;

	$firstPoint=new gpsPoint();
	$firstPoint->lat=$lat;
	$firstPoint->lon=$lon;

	// calc TAKEOFF - LANDING PLACES	
	if (count($waypoints)==0) 
		$waypoints=getWaypoints();

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
	
	return array($nearestWaypoint,$minTakeoffDistance);
/*
	return array($nearestWaypoint->lat,$nearestWaypoint->lon,
			$minTakeoffDistance,
			$nearestWaypoint->countryCode,
			$nearestWaypoint->name,$nearestWaypoint->intName,
			$nearestWaypoint->location,$nearestWaypoint->intLocation,
			$nearestWaypoint->link,	$nearestWaypoint->description,
			$nearestWaypoint->modifyDate );
*/			
}

function takeoffs_findAll($arg) {
	$sitePass=$arg[0];
	
	if ( ! securityCheck($sitePass) )  return  new IXR_Error(4000, 'Access Denied');

	if (count($waypoints)==0) 
		$waypoints=getWaypoints();
	return array(count($waypoints),$waypoints);
}

function securityCheck($sitePass) {
	global $CONF_SitePassword;	
    return 1;
	if ( $sitePass!=$CONF_SitePassword || !$sitePass) return 0;
	return 1;	
}

function flights_find($arg) {
		global $db,$flightsTable;
		global $baseInstallationPath,$module_name,$takeoffRadious;
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
			$name=getPilotRealName($row["userID"]);
			$link=htmlspecialchars ("http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/modules.php?name=".$module_name."&op=show_flight&flightID=".$row['ID']);
			$this_year=substr($row['DATE'],0,4);		
			$linkIGC=htmlspecialchars ("http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/modules/".$module_name."/".$flightsRelPath."/".$row[userID]."/flights/".$this_year."/".$row[filename] );  
			
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

function flights_submit($args) {
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

	global $db,$prefix;
	$sql = "SELECT user_id, username, user_password 
			FROM ".$prefix."_users	WHERE username = '$username'";
	if ( !($result = $db->sql_query($sql)) ) {
		return  new IXR_Error(200, "Error in obtaining userdata for $username");
	}
	
	$passwdProblems=0;
	if( $row = $db->sql_fetchrow($result) ) {
		if( md5($passwd) != $row['user_password'] ) $passwdProblems=1;
	} else 	$passwdProblems=1;
	
	if ($passwdProblems) {
		return  new IXR_Error(201, "Error in password for $username");
	}


	$userID=$row['user_id'];
 
	$filename = dirname(__FILE__)."/flights/".$igcFilename;
	if (!$handle = fopen($filename, 'w')) { 
		return  new IXR_Error(202, "Cannot open file ($filename)");
	} 

	$igcStr=fetchURL(html_entity_decode($igcURL),10); // timeout 10 secs
	if (!$igcStr) {
		return  new IXR_Error(203, "Cannot get igcURL ($igcURL)");
	}

	if (!fwrite($handle,$igcStr)) { 
		return  new IXR_Error(204, "Cannot write to file ($filename)");
	} 		
	@fclose($handle); 

	list($errCode,$flightID)=addFlightFromFile($filename,0,	$userID,$private,$cat,$linkURL,$comments,$glider) ;
	if ($errCode==1) { // all ok 
		return $flightID;
	} else {
		$errStr=htmlspecialchars(getAddFlightErrMsg($errCode,$flightID) ) ;
		return  new IXR_Error(500,$errStr );
	}

}


function uploadFile($arg) {
	$sitePass=$arg[0];
	$remoteFile=$arg[1];
	$localFile=$arg[2];

	global $CONF_SitePassword;	

	if ($sitePass!=$CONF_SitePassword) return  new IXR_Error(4000, "Access denied");

	if ( ($fileStr=@file_get_contents($remoteFile)) === FALSE) 
		return  new IXR_Error(4001, "Cant access file ($remoteFile) to upload");	
	if ( ! (strpos($localFile,"..") === FALSE) ) 
		return  new IXR_Error(4002, "Invalid local file ($localFile)");	
	$f1=$fileStr;
	
	$filename=dirname(__FILE__)."/$localFile";
	if (!$handle = fopen($filename, 'w'))  
		return new IXR_Error(4003, "Cannot open file ($filename)");	

	if (fwrite($handle, $fileStr)===FALSE) 
		return new IXR_Error(4004, "Cannot write to file ($filename)");	

   	fclose($handle); 
	return 1;
}

function registerSlave($arg) {
	$installType=$arg[0];
	$url=$arg[1];
	$adminEmail=$arg[2];
	$sitePass=$arg[3];

	global $CONF_isMasterServer;	
	if (!$CONF_isMasterServer)	
		return new IXR_Error(5001, "Not a Master server");	

	$fileStr="$installType#$url#$adminEmail#$sitePass\n";
	$filename=dirname(__FILE__)."/clientServers.txt";
    if (!$handle = fopen($filename, 'a'))  
		return new IXR_Error(5002, "Cannot open file ($filename)");	

	if (fwrite($handle, $fileStr)===FALSE) 
		return new IXR_Error(5003, "Cannot write to file ($filename)");	
		
    fclose($handle); 
	return 1;
}

/* Create the server and map the XML-RPC method names to the relevant functions */
$server = new IXR_Server(array(
	'server.uploadFile'=>'uploadFile',
	'server.registerSlave'=>'registerSlave',
	'takeoffs.findTakeoff'=>'findTakeoff',
	'takeoffs.getAll'=>'takeoffs_findAll',
	'flights.find'=>'flights_find',
	'flights.submit'=>'flights_submit',
));

?>
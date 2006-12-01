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

/* Functions defining the behaviour of the server */

function getTime($args) {
    return date('H:i:s');
}

function add($args) {
    return $args[0] + $args[1];
}

function addArray($array) {
    $total = 0;
    foreach ($array as $number) {
        $total += $number;
    }
    return implode(' + ', $array).' = '.$total;
}

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
	
	if ( ! securityCheck($sitePass) ) return new soap_fault('Client','','Access denied');

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

/* Create the server and map the XML-RPC method names to the relevant functions */
$server = new IXR_Server(array(
    'test.getTime' => 'getTime',
    'test.add' => 'add',
    'test.addArray' => 'addArray',
	'test.findTakeoff'=>'findTakeoff',
	'takeoffs.getAll'=>'takeoffs_findAll',
	'flights.find'=>'flights_find'
));

?>
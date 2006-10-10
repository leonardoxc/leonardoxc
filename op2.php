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
	if ( $sitePass!=$CONF_SitePassword || !$sitePass) return 0;
	return 1;	
}

/* Create the server and map the XML-RPC method names to the relevant functions */
$server = new IXR_Server(array(
    'test.getTime' => 'getTime',
    'test.add' => 'add',
    'test.addArray' => 'addArray',
	'test.findTakeoff'=>'findTakeoff',
	'takeoffs.getAll'=>'takeoffs_findAll'
));

?>
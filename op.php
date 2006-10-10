<?

require_once dirname(__FILE__)."/soap/nusoap.php";

require_once dirname(__FILE__)."/config_op_mode.php";
require_once dirname(__FILE__)."/config_admin_email.php";

$server = new soap_server;
$server->register('uploadFile');
$server->register('registerServer');
$server->register('findTakeoff');

function uploadFile($sitePass,$remoteFile,$localFile) {
	global $CONF_SitePassword;	

	if ($sitePass!=$CONF_SitePassword) return new soap_fault('Client','','Access denied');
	if ( ($fileStr=@file_get_contents($remoteFile)) === FALSE) 
		return new soap_fault('Client','',"Cant access file ($remoteFile) to upload");
	if ( ! (strpos($localFile,"..") === FALSE) ) 
		return new soap_fault('Client','',"Invalid local file ($localFile) ");
	$f1=$fileStr;
	
	$filename=dirname(__FILE__)."/../$localFile";
	if (!$handle = fopen($filename, 'w'))  
		return new soap_fault('Client','',"Cannot open file ($filename)");

	if (fwrite($handle, $fileStr)===FALSE) 
		return new soap_fault('Client','',"Cannot write to file ($filename)");
		
    	fclose($handle); 
	return 1;
}

function registerServer($installType,$url,$adminEmail,$sitePass) {
	global $CONF_isMasterServer;	
	if (!$CONF_isMasterServer)	return new soap_fault('Client','','Not a Master server');

	$fileStr="$installType#$url#$adminEmail#$sitePass\n";
	$filename=dirname(__FILE__)."/clientServers.txt";
    if (!$handle = fopen($filename, 'a'))  
		return new soap_fault('Client','',"Cannot open file ($filename)");

	if (fwrite($handle, $fileStr)===FALSE) 
		return new soap_fault('Client','',"Cannot write to file ($filename)");
		
    fclose($handle); 
	return 1;
}

require_once dirname(__FILE__)."/EXT_config_pre.php";
require_once dirname(__FILE__)."/config.php";
require_once dirname(__FILE__)."/EXT_config.php";

require_once dirname(__FILE__)."/CL_flightData.php";
require_once dirname(__FILE__)."/FN_functions.php";	
require_once dirname(__FILE__)."/FN_UTM.php";
require_once dirname(__FILE__)."/FN_waypoint.php";	
require_once dirname(__FILE__)."/FN_output.php";


function findTakeoff($sitePass,$lat,$lon) {
//	global $CONF_SitePassword;	
//	if ($sitePass!=$CONF_SitePassword) return new soap_fault('Client','','Access denied');

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


$server->service($HTTP_RAW_POST_DATA);


?>
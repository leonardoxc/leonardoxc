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
// $Id: GUI_EXT_server_action.php,v 1.26 2010/03/14 20:56:10 manolis Exp $                                                                 
//
//************************************************************************
require_once dirname(__FILE__)."/EXT_config_pre.php";
require_once dirname(__FILE__)."/config.php";
require_once dirname(__FILE__)."/EXT_config.php";

require_once dirname(__FILE__)."/CL_server.php";
require_once dirname(__FILE__)."/FN_waypoint.php";	
require_once dirname(__FILE__)."/FN_functions.php";	
require_once dirname(__FILE__).'/CL_brands.php';


if (! L_auth::isAdmin($userID)) {
	return;
}

$id=makeSane($_GET['id'],1);
$action=makeSane($_GET['action']);
$DBGlvl=makeSane($_GET['DBGlvl'],1);
$server=new Server($id);
// $server->getFromDB();

// set to 1 for debug
if ($DBGlvl) $server->DEBUG=1;
?><head>

<style type="text/css">
body { background-color: #EDF3F1;}

body , p, table, td {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-style: normal;
	text-align:left;
	margin:0;
}
.ok { 
	font-weight:bold;
	color:#00CC33;
	display:inline;
}

.error { 
	font-weight:bold;
	color:#FF3300;
	display:inline;	
}

</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<?

if ($action==1) { // server info 
	list($server_version,$server_releaseDate, $server_opMode,
		 $server_isMasterServer, $server_admin_email,
		 $php_version, $mysql_server_info ,$mysql_client_info )=$server->getInfo();

	$server->getFromDB();
	echo "lastPullUpdateID: ".$server->lastPullUpdateID."<BR>\n";
	
	echo "Leonardo version: $server_version<br>
		version releaseDate:	$server_releaseDate<br>
		opMode: $server_opMode<br>
		isMasterServer: $server_isMasterServer<br>
		admin_email: $server_admin_email<br>
		php_version: $php_version<br>
		mysql_server_info: $mysql_server_info<BR>
		mysql_client_info: $mysql_client_info<BR>";
} else if ($action==2) {
	$takeoffsList=$server->getTakeoffs(0); // takeoffs from time 0
	echo "<HR>Takeoff list<hr>";
	//print_r($takeoffsList);
	foreach($takeoffsList as $takeoff){
		$takeoff=(object) $takeoff;
		echo "#".urldecode($takeoff->intName).
			"#".urldecode($takeoff->name).
"#<BR>";
	}

} else if ($action==3) { //flights 

} else if ($action==4) { //send op files
	$files_send=$server->sendOPfiles(); 
	echo "Send $files_send files to slave server <BR>";
} else if ($action==5) { // sync (pull data from server )
	$moduleRelPath=moduleRelPath(0);
	$waypointsWebPath=$moduleRelPath."/".$waypointsRelPath;

	$chunkSize=$_GET['chunkSize']+0;
	if (! $chunkSize ) $chunkSize=5;

	$server->sync($chunkSize);
} else if ($action==6) { // delete all external flights from this server
	$moduleRelPath=moduleRelPath(0);
	$waypointsWebPath=$moduleRelPath."/".$waypointsRelPath;

	$server->deleteAllSyncedFlights();

} else if ($action==7) { // guess identical pilots 
	$moduleRelPath=moduleRelPath(0);
	$waypointsWebPath=$moduleRelPath."/".$waypointsRelPath;

	$server->guessPilots();
} else if ($action==8) { // delete pilots -> only use if you know what you are doing , must be sed only after delete flights
	$server->deleteAllSyncedPilots();
	
} else if ($action==9) { // move sync pointer back (in effect will reprocess last n log entries next time
	$server->getFromDB();
	echo "Sync Pointer was ".$server->lastPullUpdateID;
	if ( $server->getProtocolVersion() == 2 ) {
		echo' Date: '.gmdate("Y-m-d H:i:s",$server->lastPullUpdateID).' GMT';
	}
	echo "<BR>";
	$server->moveSyncPointer($_GET['moveCounter']+0);
	echo "Sync Pointer is ".$server->lastPullUpdateID;
	if ( $server->getProtocolVersion() == 2 ) {
		echo' Date: '.gmdate("Y-m-d H:i:s",$server->lastPullUpdateID).' GMT';
	}
	echo "<BR>";
} else if ($action==91) { // set sync pointer to 
	$server->getFromDB();
	echo "Sync Pointer was ".$server->lastPullUpdateID;
	if ( $server->getProtocolVersion() == 2 ) {
		echo' Date: '.gmdate("Y-m-d H:i:s",$server->lastPullUpdateID).' GMT';
	}
	echo "<BR>";
	$server->setSyncPointer($_GET['setCounter']+0);
	echo "Sync Pointer is ".$server->lastPullUpdateID;
	if ( $server->getProtocolVersion() == 2 ) {
		echo' Date: '.gmdate("Y-m-d H:i:s",$server->lastPullUpdateID).' GMT';
	}
	echo "<BR>";
} else if ($action==92) { //quey e sync pointer
	$server->getFromDB();
	echo "Sync Pointer is  ".$server->lastPullUpdateID;
	if ( $server->getProtocolVersion() == 2 ) {
		echo' Date: '.gmdate("Y-m-d H:i:s",$server->lastPullUpdateID).' GMT';
	}
	echo "<BR>";
} else if ($action==10) { // exclude all flights from this server from apearing in leagues
	$query="UPDATE $flightsTable SET excludeFrom=(excludeFrom | 2) WHERE serverID=".$server->ID;
	$res= $db->sql_query($query);
	if ($res) echo "Flights updated OK $query";
	else  echo "Problem in updating flights: $query<BR> ";
} else if ($action==11) { // exclude all flights from this server from apearing in lists
	$query="UPDATE $flightsTable SET excludeFrom=(excludeFrom | 3) WHERE serverID=".$server->ID;
	$res= $db->sql_query($query);
	if ($res) echo "Flights updated OK $query";
	else  echo "Problem in updating flights: $query<BR> ";
} else if ($action==12) { // include all flights from this server from apearing in leagues
	$query="UPDATE $flightsTable SET excludeFrom=(excludeFrom & ( ~0x03&0xff) ) WHERE serverID=".$server->ID;
	$res= $db->sql_query($query);
	if ($res) echo "Flights updated OK $query";
	else  echo "Problem in updating flights: $query<BR> ";
} else if ($action==13) { // include all flights from this server from apearing in lists
	$query="UPDATE $flightsTable SET excludeFrom=(excludeFrom & ( ~0x01&0xff) ) WHERE serverID=".$server->ID;
	$res= $db->sql_query($query);
	if ($res) echo "Flights updated OK $query";
	else  echo "Problem in updating flights: $query<BR> ";
} else if ($action==14) { // include all flights from this server from apearing EVERYWHERE (reset)
	$query="UPDATE $flightsTable SET excludeFrom=0 WHERE serverID=".$server->ID;
	$res= $db->sql_query($query);
	if ($res) echo "Flights updated OK $query";
	else  echo "Problem in updating flights: $query<BR> ";

} else if ($action==99) { //test
	echo $server->data['url_op'];
	echo "<BR>$action<br>";
	
	
	$pilotsList=$server->getPilots( 3 );
	print_r($pilotsList);
	
	//list($nearestWaypoint,$minTakeoffDistance)=$server->findTakeoff(49.4619,-8.67848);
	//echo "wpt: ".$nearestWaypoint->intName. "~ $minTakeoffDistance<BR>";
}


?>

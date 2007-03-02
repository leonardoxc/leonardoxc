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
require_once dirname(__FILE__)."/EXT_config_pre.php";
require_once dirname(__FILE__)."/config.php";
require_once dirname(__FILE__)."/EXT_config.php";

require_once dirname(__FILE__)."/CL_server.php";
require_once dirname(__FILE__)."/FN_waypoint.php";	

$id=makeSane($_GET['id'],1);
$action=makeSane($_GET['action']);
$DBGlvl=makeSane($_GET['DBGlvl'],1);
$server=new Server($id);
$server->getFromDB();

// se to 1 for debug
if ($DBGlvl) $server->DEBUG=1;


if ($action==1) { // server info 
	list($server_version,$server_releaseDate, $server_opMode,
		 $server_isMasterServer, $server_admin_email,
		 $php_version, $mysql_server_info ,$mysql_client_info )=$server->getInfo();
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
	foreach($takeoffsList as $takeoff){
		$takeoff=(object) $takeoff;
		echo "#".urldecode($takeoff->intName)."<BR>";
	}

} else if ($action==3) { //flights 

} else if ($action==4) { //send op files
	$files_send=$server->sendOPfiles(); 
	echo "Send $files_send files to slave server <BR>";

} else if ($action==99) { //test
	echo $server->url_op;
	echo "<BR>$action<br>";
	
	list($nearestWaypoint,$minTakeoffDistance)=$server->findTakeoff(40,22);
	echo "wpt: ".$nearestWaypoint->intName. "~ $minTakeoffDistance<BR>";
}


?>

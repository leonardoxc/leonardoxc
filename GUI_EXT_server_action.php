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

$id=$_GET['id']+0;
$action=$_GET['action'];
$server=new Server($id);
$server->getFromDB();


if ($action==1) { // server info 
	list($server_version,$server_releaseDate, $server_opMode, $server_isMasterServer, $server_admin_email)=$server->getInfo();
	echo "Leonardo version: $server_version<br>
		version releaseDate:	$server_releaseDate<br>
		opMode: $server_opMode<br>
		isMasterServer: $server_isMasterServer<br>
		admin_email: $server_admin_email<br>";
} else if ($action==2) {


} else if ($action==3) { //flights 



} else if ($action==4) { //test
	echo $server->url_op;
	echo "<BR>$action<br>";
	
	list($nearestWaypoint,$minTakeoffDistance)=$server->findTakeoff(40,22);
	echo "wpt: ".$nearestWaypoint->intName. "~ $minTakeoffDistance<BR>";
}


?>
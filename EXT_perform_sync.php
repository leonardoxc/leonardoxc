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
// $Id: EXT_perform_sync.php,v 1.6 2008/11/29 22:46:06 manolis Exp $                                                                 
//
//************************************************************************

require_once dirname(__FILE__)."/EXT_config_pre.php";
require_once dirname(__FILE__)."/config.php";
require_once dirname(__FILE__)."/EXT_config.php";

$pass=makeSane($_GET['pass'],0);

if ($pass != $CONF_SitePassword || ! $pass) {
	return;
}

require_once dirname(__FILE__)."/CL_server.php";
require_once dirname(__FILE__)."/FN_waypoint.php";	
require_once dirname(__FILE__)."/FN_functions.php";	
require_once dirname(__FILE__).'/CL_brands.php';

$id=makeSane($_GET['id'],1);
$action=makeSane($_GET['action']);
$DBGlvl=makeSane($_GET['DBGlvl'],1);

$server=new Server($id);

// set to 1 for debug
if ($DBGlvl) $server->DEBUG=1;


function  initHtml () {
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
}

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
	$flightsWebPath=$moduleRelPath."/".$flightsRelPath;

	$chunkSize=$_GET['chunkSize']+0;
	if (! $chunkSize ) $chunkSize=5;

	$sParts=split("/",$server->data['url']);
	$serverName=$sParts[0];

	// make dirs and 

 	$logDir=dirname(__FILE__).'/site/sync/'.$serverName;
	$logFilename=$logDir.'/'.date("Y_m_d").".html";

	if ( ! is_dir($logDir) ) {
		mkdir($logDir);
	}

	$logStr='';
	if ( ! is_file($logFilename) ) {
		ob_start();
		initHtml();
		$logStr= ob_get_contents();
		ob_end_clean();
	}

	ob_start();
	list($result,$extra)=$server->sync($chunkSize,0);
	$outStr = ob_get_contents();
	ob_end_clean();


	if ($result==0) {
		$logStr.="<b>".date("d/m/Y H:i:s")."</b> No entries<BR>\n";
	} else {
		$logStr.="<hr><strong>".date("d/m/Y H:i:s")."</strong>";
		if ($result==1) {
			$logStr.=" <span class='ok'>OK</span> ";
		} else if ($result<0) {
			$logStr.=" <span class='error'>ERROR</span> ";
			$msg="<pre>".date("d/m/Y H:i:s")."<br>\r\nServer: ". $serverName." [".$server->ID."]<br>\r\nError code: $result<br>\r\nError: $extra <br></pre>\r\n ";
			sendMailToAdmin("Problem in syncing",$msg);
			// mail($CONF_admin_email,"Problem in sync of master ".$_SERVER['SERVER_NAME'],$msg);

		}
		$logStr.=$outStr;
	}

    if (!$handle = fopen($logFilename, 'a')) {
         echo "Cannot open file ($logFilename)";
         exit;
    }
    if (fwrite($handle, $logStr) === FALSE) {
        echo "Cannot write to file ($logFilename)";
        exit;
    } 
    fclose($handle);


} else if ($action==6) { // delete all external flights from this server
	$moduleRelPath=moduleRelPath(0);
	$waypointsWebPath=$moduleRelPath."/".$waypointsRelPath;
	$flightsWebPath=$moduleRelPath."/".$flightsRelPath;

	$server->deleteAllSyncedFlights();

} else if ($action==7) { // guess identical pilots 
	$moduleRelPath=moduleRelPath(0);
	$waypointsWebPath=$moduleRelPath."/".$waypointsRelPath;
	$flightsWebPath=$moduleRelPath."/".$flightsRelPath;

	$server->guessPilots();
} else if ($action==8) { // delete pilots -> only use if you know what you are doing , must be sed only after delete flights
	$server->deleteAllSyncedPilots();
	
} else if ($action==9) { // move sync pointer back (in effect will reprocess last n log entries next time
	$server->getFromDB();
	echo "Sync Pointer was ".$server->lastPullUpdateID."<BR>";
	$server->moveSyncPointer($_GET['moveCounterBack']+0);
	echo "Sync Pointer is ".$server->lastPullUpdateID."<BR>";
} else if ($action==99) { //test
	echo $server->data['url_op'];
	echo "<BR>$action<br>";
	
	
	$pilotsList=$server->getPilots( 3 );
	print_r($pilotsList);
	
	//list($nearestWaypoint,$minTakeoffDistance)=$server->findTakeoff(49.4619,-8.67848);
	//echo "wpt: ".$nearestWaypoint->intName. "~ $minTakeoffDistance<BR>";
}

echo "\n";

?>

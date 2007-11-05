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
	require_once "config.php";
 	require_once "EXT_config.php";

	require_once "CL_flightData.php";
	require_once "FN_functions.php";	
	require_once "FN_UTM.php";
	require_once "FN_waypoint.php";	
	require_once "FN_output.php";
	setDEBUGfromGET();

	$op=makeSane($_GET['op']);
	if (!in_array($op,array("find_wpt","get_latest")) ) return;

	if ($op=="find_wpt") {
		$lat=$_GET['lat']+0;
		$lon=$_GET['lon']+0;

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

		 header ('Content-Type: text/xml');
		 echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
		 echo "<search>\n";
		 echo $nearestWaypoint->exportXML();
		 echo "\n<distance>".sprintf("%.0f",$minTakeoffDistance)."</distance>\n";
		 echo "</search>\n";

	} else 	if ($op=="get_latest") {
		$tm=$_GET['tm']+0; // timestamp
		if (!$tm) $tm=time()-60*60*24*7; // 1 week back

		$query="SELECT * from $waypointsTable WHERE modifyDate>=FROM_UNIXTIME($tm) AND type=1000 ";
		$res= $db->sql_query($query);

		header ('Content-Type: text/xml');
		echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\" ?>";
		echo "<search>";
		
	    if($res <= 0){
		    echo "</search>";
			return;
    	}

		$i=0;
		while ($row = mysql_fetch_assoc($res)) { 
		  $resWaypoint=new waypoint($row["ID"]);
		  $resWaypoint->getFromDB();
		  echo $resWaypoint->exportXML();
		  $i++;	  
		}     

	    mysql_freeResult($res);
	    echo "</search>";

	}

?>
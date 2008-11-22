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

	$op=makeSane($_GET['op']);
	if ($op=="get_info") $CONF_use_utf=1;

 	require_once "EXT_config.php";

	require_once "CL_flightData.php";
	require_once "FN_functions.php";	
	require_once "FN_UTM.php";
	require_once "FN_waypoint.php";	
	require_once "FN_output.php";
	setDEBUGfromGET();

	$op=makeSane($_GET['op']);

	if (!in_array($op,array("find_wpt","get_nearest","get_latest","get_info","getTakeoffsForArea")) ) return;

	if ($op=="get_info") {
		$wpID=$_GET['wpID']+0;
		$inPageLink=$_GET['inPageLink']+0;
		
		echo '{ "takeoffID": '.$wpID.' , "html": "';
		
		$query="SELECT intName , countryCode from $waypointsTable WHERE ID=$wpID ";
		$res= $db->sql_query($query);
		if($res > 0){		
			if ($row = mysql_fetch_assoc($res)) {
				$description=$row['intName'];
			} else {
				echo "no results inquery :$query";			
			}
			
		} else {
			echo "error in query :$query";
		}

		if ($inPageLink) {
			echo "<b>".$description."</b><br><img src=\'img/icon_pin.png\' align=\'absmiddle\' border=0> <a href=\'javascript:show_waypoint($wpID);\' >"._SITE_INFO."</a><br>";
			
			// echo "<b>".$description."</b><br><img src='img/icon_pin.png' align='absmiddle' border=0> <a  href='GUI_EXT_waypoint_info.php?wID=$wpID' rel='facebox'>"._SITE_INFO."</a><br>";
		
		} else {
			echo "<b>".$description."</b><br><img src=\'img/icon_pin.png\' align=\'absmiddle\' border=0> <a  target=\'_top\' href=\'".
			getLeonardoLink(array('op'=>'show_waypoint','waypointIDview'=>$wpID)) 
			."\'>"._SITE_INFO."</a><br>";
		}	
		
	
		$query="SELECT  MAX(MAX_LINEAR_DISTANCE) as record_km, ID  FROM $flightsTable  WHERE takeoffID =".$wpID." GROUP BY ID ORDER BY record_km DESC ";
		
		$flightNum=0;
		$res= $db->sql_query($query);
		if($res > 0){
			$flightNum=mysql_num_rows($res);
			
			if ($flightNum>0) {
				echo "<img src=\'img/icon_magnify_small.gif\' align=\'absmiddle\' border=0> <a href=\'".
					getLeonardoLink(array('op'=>'list_flights','takeoffID'=>$wpID,'year'=>'0','month'=>'0',
											'season'=>'0','pilotID'=>'0','country'=>'0','cat'=>'0'
					))."\' target=\'_top\'>".
		_See_flights_near_this_point." [ ".$flightNum." ]</a><br>";
		echo "<img src=\'img/icon_trophy.gif\' align=\'absmiddle\' border=0> <b>"._SITE_RECORD."</b>:";

			$row = mysql_fetch_assoc($res);
		
			echo '<a target=\'_top\' href=\'http://'.$_SERVER['SERVER_NAME'].
				getLeonardoLink(array('op'=>'show_flight','flightID'=>$row['ID'])).'\'>'.
			formatDistance($row['record_km'],1).'</a>';
			} else {
				echo " No flights from this location";
			}
		} 
		echo ' " } ';
	} else if ($op=="getTakeoffsForArea") {
		$areaID=$_GET['areaID']+0;	
		$sql = "SELECT * FROM $waypointsTable,$areasTakeoffsTable	
			WHERE $areasTakeoffsTable.takeoffID = $waypointsTable.ID AND $areasTakeoffsTable.areaID=$areaID";

		$dbres= $db->sql_query($sql);
	    if($dbres <= 0){
		    echo '{ "waypoints": [ ]  }';
			return;
    	}
		
		$res='{ "waypoints": [ ';
		$i=0;
		while ($row = mysql_fetch_assoc($dbres)) { 
			if ($i>0)$res.=" ,\n";
			$res.=' { "id":'.$row[ID].', "lat":'.$row['lat'].', "lon":'.-$row['lon'].' , "name":"'.str_replace('"','\"',$row['intName']).'", "type":'.$row['type'].' } ';
		  $i++;	  
		}     
		
		$res.=' ]  }';
		echo $res;
	    mysql_freeResult($dbres);

	 
	} else if ($op=="get_nearest") {
		$lat=$_GET['lat']+0;
		$lon=-$_GET['lon']+0;
		
		$distance=$_GET['distance']+0;
		if ( $distance <= 0 ) $distance=100; 
		if ( $distance > 200 ) $distance=200;
		
		$limit=$_GET['limit']+0;
		if ( $limit <= 0 ) $limit=50; 
		if ( $limit > 200 ) $limit =200;
		
		
	$sql = "SELECT *,\n";
$sql .= "ROUND((ACOS((SIN(" . $lat . "/57.2958) * ";
$sql .= "SIN(lat/57.2958)) + (COS(" . $lat . "/57.2958) * ";
$sql .= "COS(lat/57.2958) * ";
$sql .= "COS(lon/57.2958 - " . $lon . "/57.2958)))) ";
$sql .= "* 6392 , 3) AS distance\n";
$sql .= "FROM  $waypointsTable\n";
$sql .= "WHERE ROUND((ACOS((SIN(" . $lat . "/57.2958) * ";
$sql .= "SIN(lat/57.2958)) + (COS(" . $lat . "/57.2958) * ";
$sql .= "COS(lat/57.2958) * ";
$sql .= "COS(lon/57.2958 - " . $lon . "/57.2958)))) ";
$sql .= "* 6392 , 3) <= " . $distance. " AND type >=1000 \n";
$sql .= "ORDER BY distance LIMIT $limit \n";

//  3963 for miles  6392 for km


		$dbres= $db->sql_query($sql);

		$res='{ "waypoints": [ ';
		
//		header ('Content-Type: text/xml');
//		echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\" ? >";
//		echo "<search>";
		
	    if($dbres <= 0){
		    echo "</search>";
			return;
    	}

		$i=0;
		while ($row = mysql_fetch_assoc($dbres)) { 
			if ($i>0)$res.=" ,\n";
			$res.=' { "id":'.$row[ID].', "lat":'.$row['lat'].', "lon":'.-$row['lon'].' , "name":"'.str_replace('"','\"',$row['intName']).'", "type":'.$row['type'].' } ';
			//print_r($row);
			//echo "<HR>";
		  //$resWaypoint=new waypoint($row["ID"]);
		  //$resWaypoint->getFromDB();
		  //echo $resWaypoint->exportXML('XML');
		  $i++;	  
		}     
		
		$res.=' ]  }';
		echo $res;
	    mysql_freeResult($dbres);
//	    echo "</search>";
	
	} else if ($op=="find_wpt") {
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
		 echo $nearestWaypoint->exportXML('XML');
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
		  echo $resWaypoint->exportXML('XML');
		  $i++;	  
		}     

	    mysql_freeResult($res);
	    echo "</search>";

	}

?>
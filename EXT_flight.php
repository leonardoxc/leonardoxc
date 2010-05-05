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
// $Id: EXT_flight.php,v 1.23 2010/05/05 14:00:04 manolis Exp $                                                                 
//
//************************************************************************

 	require_once dirname(__FILE__)."/EXT_config_pre.php";
	require_once "config.php";
 	require_once "EXT_config.php";

	require_once "CL_flightData.php";
	require_once "FN_functions.php";	
	require_once "FN_UTM.php";
	require_once "FN_waypoint.php";	
	require_once "FN_output.php";
	require_once "FN_pilot.php";
	require_once "FN_flight.php";
	setDEBUGfromGET();

	$op=makeSane($_REQUEST['op']);
	if (!$op) $op="list_flights";	

	if (!in_array($op,array("find_flights","list_flights","submit_flight","list_flights_json","get_info","polylineURL","get_task_json")) ) return;

	$encoding="iso-8859-1";
	if ($op=="find_flights") {
		$lat=makeSane($_GET['lat'],1);
		$lon=-makeSane($_GET['lon'],1);

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

		 $XML_str="<result>\n";
		$XML_str.="
			<title>Leonardo at ".$_SERVER['SERVER_NAME']." :: Flight list</title>
			<link>http://".$_SERVER['SERVER_NAME'].getLeonardoLink(array('op'=>'list_flights')) ."</link>		
			<date>". gmdate('D, d M Y H:i:s', time()) . " GMT</date>
		";

		 $XML_str.="<waypoints>\n";
		 $XML_str.=$nearestWaypoint->exportXML('XML');
		 $XML_str.="\n<distance>".sprintf("%.0f",$minTakeoffDistance)."</distance>\n";
		 $XML_str.="</waypoints>\n
";

		 $where_clause ="AND takeoffID=$nearestWaypoint->waypointID AND filename<>'' ";
		 $query="SELECT * FROM $flightsTable WHERE private=0 $where_clause ORDER BY FLIGHT_POINTS  DESC $lim ";
		 //echo $query;
		 //exit;
		 
		 $res= $db->sql_query($query);
		 if($res <= 0){
			 echo("<H3> Error in query! $query </H3>\n");
			 exit();
		 }

		$XML_str.="
		<flights>";

		while ($row = mysql_fetch_assoc($res)) { 
//			 $nearestWaypoint=new waypoint($takeoffIDTmp);
//			 $nearestWaypoint->getFromDB();
	
			$name=getPilotRealName($row["userID"],$row["userServerID"]);
			$link=htmlspecialchars ("http://".$_SERVER['SERVER_NAME'].
									getLeonardoLink(array('op'=>'show_flight','flightID'=>$row['ID'])) 
									);
			$this_year=substr($row[DATE],0,4);		
			$linkIGC=htmlspecialchars ("http://".$_SERVER['SERVER_NAME'].getRelMainDir().
						str_replace("%PILOTID%",getPilotID($row["userServerID"],$row["userID"]),str_replace("%YEAR%",$this_year,$CONF['paths']['igc']) ).'/'.
						$row['filename']);
			//	$flightsRelPath."/".$row[userID]."/flights/".$this_year."/".$row[filename] );  
			
			if ($row['takeoffVinicity'] > $takeoffRadious ) 
				$location=getWaypointName($row['takeoffID'])." [~".sprintf("%.1f",$row['takeoffVinicity']/1000)." km]"; 
			else $location=getWaypointName($row['takeoffID']);
	
			$XML_str.="<flight>
			<pilot>".htmlspecialchars($name)."</pilot>
			<takeoff>".htmlspecialchars($location)."</takeoff>\n";
//			$XML_str.="<flightID>".$row["ID"]."</flightID>
//			<flightUserID>".$row["userID"]."</flightUserID>
//			";
			$XML_str.="<date>".$row['DATE']."</date>\n";
			$XML_str.="<duration>".$row['DURATION']."</duration>\n";
			$XML_str.="<openDistance>".$row['MAX_LINEAR_DISTANCE']."</openDistance>\n";
			$XML_str.="<OLCkm>".$row['FLIGHT_KM']."</OLCkm>\n";
			$XML_str.="<OLCScore>".$row['FLIGHT_POINTS']."</OLCScore>\n";
			$XML_str.="<OLCtype>".$row['BEST_FLIGHT_TYPE']."</OLCtype>\n";
			$XML_str.="<displayLink>$link</displayLink>\n";

			$XML_str.="</flight>\n";
		}

		$XML_str.="</flights>\n";	
	    $XML_str.="</result>";
		send_XML($XML_str);
		
	} else if ($op=="polylineURL") {
		$flightID=$_REQUEST['flightID']+0;
		if ($flightID<=0) exit;	
		$flight=new flight();
		$flight->getFlightFromDB($flightID,0);
	
		$polylineURL=$flight->getPolylineRelPath();
		echo $polylineURL;		
	} else if ($op=="get_task_json") {
		$flightID=$_REQUEST['flightID']+0;
		if ($flightID<=0) exit;	
		$flight=new flight();
		$flight->flightID=$flightID;
		//$flight->getFlightFromDB($flightID,0);	
		echo $flight->gMapsGetTaskJS();
	} else if ($op=="get_info") {
		require_once dirname(__FILE__).'/lib/json/CL_json.php';
				
		$flightID=$_REQUEST['flightID']+0;
		if (!$flightID) return;
		
		 $query="SELECT * FROM $flightsTable WHERE ID=$flightID";
		 //echo $query;
		 $res= $db->sql_query($query);
		 if($res <= 0){
			 echo("<H3> Error in query! $query </H3>\n");
			 exit();
		 }

		$JSON_str="";
		if ($row = mysql_fetch_assoc($res)) { 
			 $nearestWaypoint=new waypoint($takeoffIDTmp);
			 $nearestWaypoint->getFromDB();
	
			$name=getPilotRealName($row["userID"],$row["userServerID"]);
			$link=htmlspecialchars ("http://".$_SERVER['SERVER_NAME'].
										getLeonardoLink(array('op'=>'show_flight','flightID'=>$row['ID'])) 
									);
										
			$this_year=substr($row['DATE'],0,4);		
			$linkIGC=htmlspecialchars ("http://".$_SERVER['SERVER_NAME'].getRelMainDir().
					str_replace("%PILOTID%",getPilotID($row["userServerID"],$row["userID"]),str_replace("%YEAR%",$this_year,$CONF['paths']['igc']) ).'/'.
					$row['filename'] );  
					//$flightsRelPath."/".$row[userID]."/flights/".$this_year."/".$row[filename] );  
			
			if ($row['takeoffVinicity'] > $takeoffRadious ) 
				$location=getWaypointName($row['takeoffID'])." [~".sprintf("%.1f",$row['takeoffVinicity']/1000)." km]"; 
			else $location=getWaypointName($row['takeoffID']);
	
			if ($i>0) $JSON_str.=", ";
			
			$JSON_str.=' {"flightID": "'.$row["ID"].'", "date": "'.json::prepStr($row["DATE"]).'", '.
					'"firstLat": "'.json::prepStr($row["firstLat"]).'", '.
					'"firstLon": "'.json::prepStr($row["firstLon"]).'", '.
					
					'"lastLat": "'.json::prepStr($row["lastLat"]).'", '.
					'"lastLon": "'.json::prepStr($row["lastLon"]).'", '.
					
					'"duration": "'.json::prepStr($row["lastLon"]).'", '.
					'"lastLon": "'.json::prepStr($row["lastLon"]).'", '.
					'"lastLon": "'.json::prepStr($row["lastLon"]).'", '.
					'"lastLon": "'.json::prepStr($row["lastLon"]).'", '.
					
					
					'"pilotName": "'.json::prepStr($name).'", '.
					'"takeoff": "'.json::prepStr($location).'"  } ';
			
		}

		//$JSON_str='{"totalCount":"'.$i.'","flights":[ '. $JSON_str."  ] } ";	
		$JSON_str='{ "flights":[ '. $JSON_str."  ] } ";	
		
		if (!empty($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Apache/2'))
		header ('Cache-Control: no-cache, pre-check=0, post-check=0, max-age=0');
		else header ('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
		header ('Expires: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
		header ('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header ('Content-Type: text/html');				


		echo $JSON_str;
		
	} else if ($op=="list_flights_json") {
		require_once dirname(__FILE__).'/lib/json/CL_json.php';
		
		$lat=$_REQUEST['lat']+0;
		$lon=$_REQUEST['lon']+0;
		$distance=$_REQUEST['distance']+0; // radious in km
		
		if ( $distance <= 0 ) $distance=100; 
		if ( $distance > 2500 ) $distance=2500;
		
		
		$where_clause=" 1 ";
		$pilotIDview=makeSane($_REQUEST['pilotIDview'],1);
		$serverID=makeSane($_REQUEST['serverID'],1);
		if ($pilotIDview!=0) {
			$where_clause.=" AND userID='".$pilotIDview."'  AND userServerID=$serverID "; 
		} 
		
		

		
		 $tm=makeSane($_REQUEST['from_tm'],1); // timestamp
		 //  $tm=time()-60*60*24*70; // 1 week back
		 if ($tm) {		 
			 $where_clause.=" AND dateAdded >= FROM_UNIXTIME($tm) "; 
		 }

		 $tm1=makeSane($_REQUEST['tm1'],1); // timestamp
		 $tm2=makeSane($_REQUEST['tm2'],1); // timestamp
		 
		 
		 $date1=makeSane($_REQUEST['date']); // date dd.mm.yyy format
		 if ($date1) {
			 $dateParts=split("\.",$date1);
			 $tm1=gmmktime(0,0,0,$dateParts[1],$dateParts[0],$dateParts[2]);			 
			 //$tm1=gmmktime(0,0,0,1,1,2007);
 			 $tm2=gmmktime(0,0,0,$dateParts[1],$dateParts[0]+1,$dateParts[2]);
		 }
		 
		 if ($tm1 && $tm2) {
			 $where_clause.=" AND `DATE` >= FROM_UNIXTIME($tm1,'%Y-%m-%d') AND `DATE` <= FROM_UNIXTIME($tm2,'%Y-%m-%d') "; 
		 }
		 
		 $count=makeSane($_REQUEST['count'],1); // timestamp
		 if (!$count)  {
			if ($CONF['db_browser']['maxTrackNum']) {
				$count=$CONF['db_browser']['maxTrackNum']; 
			} else {
				$count=50;
			}
		 }
		 
		 if ($count) $lim=" LIMIT $count ";
		 else  $lim="";
		

		
		// $distance*=1000;
		if ($lat && $lon && $distance ) {
			$select_clause.=",\n".
				"ROUND((ACOS((SIN(" . $lat . "/57.2958) * ".
				"SIN(firstLat/57.2958)) + (COS(" . $lat . "/57.2958) * ".
				"COS(firstLat/57.2958) * ".
				"COS(firstLon/57.2958 - " . $lon . "/57.2958)))) ".
				"* 6392 , 3) AS distance\n";
			
			$where_clause.=" AND ROUND((ACOS((SIN(" . $lat . "/57.2958) * ".
				"SIN(firstLat/57.2958)) + (COS(" . $lat . "/57.2958) * ".
				"COS(firstLat/57.2958) * ".
				"COS(firstLon/57.2958 - " . $lon . "/57.2958)))) ".
				"* 6392 , 3) <= " . $distance. " " ;
		}
		
		 $query="SELECT * $select_clause FROM $flightsTable WHERE $where_clause ORDER BY FLIGHT_POINTS DESC $lim ";  // , distance ASC , dateAdded DESC
		 //echo $query;
		 $res= $db->sql_query($query);
		 if($res <= 0){
			 echo("<H3> Error in query! $query </H3>\n");
			 exit();
		 }

		$JSON_str="";
		$i=0;
		while ($row = mysql_fetch_assoc($res)) { 
			 $nearestWaypoint=new waypoint($takeoffIDTmp);
			 $nearestWaypoint->getFromDB();
	
			$name=getPilotRealName($row["userID"],$row["userServerID"]);
			$link=htmlspecialchars ("http://".$_SERVER['SERVER_NAME'].
										getLeonardoLink(array('op'=>'show_flight','flightID'=>$row['ID'])) 
									);
										
			$this_year=substr($row[DATE],0,4);		
			$linkIGC=htmlspecialchars ("http://".$_SERVER['SERVER_NAME'].getRelMainDir().
					str_replace("%PILOTID%",getPilotID($row["userServerID"],$row["userID"]),str_replace("%YEAR%",$this_year,$CONF['paths']['igc']) ).'/'.
					$row['filename'] );  
					//$flightsRelPath."/".$row[userID]."/flights/".$this_year."/".$row[filename] );  
			
			if ($row['takeoffVinicity'] > $takeoffRadious ) 
				$location=getWaypointName($row['takeoffID'])." [~".sprintf("%.1f",$row['takeoffVinicity']/1000)." km]"; 
			else $location=getWaypointName($row['takeoffID']);
	
			if ($i>0) $JSON_str.=", ";
			
			$JSON_str.=' {"flightID": "'.$row["ID"].'", "date": "'.json::prepStr($row["DATE"]).'", '.
					'"firstLat": "'.json::prepStr($row["firstLat"]).'", '.
					'"firstLon": "'.json::prepStr($row["firstLon"]).'", '.
					
					'"lastLat": "'.json::prepStr($row["lastLat"]).'", '.
					'"lastLon": "'.json::prepStr($row["lastLon"]).'", '.
					
					'"pilotName": "'.json::prepStr($name).'", '.
					'"takeoff": "'.json::prepStr($location).'"  } ';
			$i++;
		}

		//$JSON_str='{"totalCount":"'.$i.'","flights":[ '. $JSON_str."  ] } ";	
		$JSON_str='{ "flights":[ '. $JSON_str."  ] } ";	
		
		if (!empty($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Apache/2'))
		header ('Cache-Control: no-cache, pre-check=0, post-check=0, max-age=0');
		else header ('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
		header ('Expires: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
		header ('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header ('Content-Type: text/html');				

		//$callbackFunction=$_GET['callback'];
		//echo $callbackFunction."(".$JSON_str.")";
		echo $JSON_str;

	} else if ($op=="list_flights") {
		$where_clause="";
		$flightID=makeSane($_GET['flightID'],1);
		if ($flightID!=0) {
			$where_clause.=" AND ID=$flightID "; 
		} else {
				 $tm=makeSane($_GET['from_tm'],1); // timestamp
				 // if (!$tm) $tm=time()-60*60*24*7; // 1 week back
				 $where_clause.=" AND dateAdded >= FROM_UNIXTIME(".$tm.") "; 
		
				 $count=makeSane($_GET['count'],1); // timestamp
				 if ($count) $lim=" LIMIT 1,$count ";
				 else  $lim="";
		}
		 $query="SELECT * FROM $flightsTable WHERE private=0 $where_clause ORDER BY dateAdded DESC $lim ";
		 //echo $query;
		 $res= $db->sql_query($query);
		 if($res <= 0){
			 echo("<H3> Error in query! $query </H3>\n");
			 exit();
		 }

		$XML_str="
		<result>
			<title>Leonardo at ".$_SERVER['SERVER_NAME']." :: Flight list</title>
			<link>http://".$_SERVER['SERVER_NAME'].	getLeonardoLink(array('op'=>'list_flights'))."</link>
			<description>Leonardo at ".$_SERVER['SERVER_NAME']." :: Flight list</description>
			<managingEditor>".$CONF_admin_email."</managingEditor>
			<webMaster>".$CONF_admin_email."</webMaster>
			<date>". gmdate('D, d M Y H:i:s', time()) . " GMT</date>
		";

		while ($row = mysql_fetch_assoc($res)) { 
			 $nearestWaypoint=new waypoint($takeoffIDTmp);
			 $nearestWaypoint->getFromDB();
	
			$name=getPilotRealName($row["userID"],$row["userServerID"]);
			$link=htmlspecialchars ("http://".$_SERVER['SERVER_NAME'].
										getLeonardoLink(array('op'=>'show_flight','flightID'=>$row['ID'])) 		
									);
			$this_year=substr($row[DATE],0,4);		
			$linkIGC=htmlspecialchars ("http://".$_SERVER['SERVER_NAME'].getRelMainDir().
						str_replace("%PILOTID%",getPilotID($row["userServerID"],$row["userID"]),str_replace("%YEAR%",$this_year,$CONF['paths']['igc']) ).'/'.
						$row['filename']);
					//$flightsRelPath."/".$row[userID]."/flights/".$this_year."/".$row[filename] );  
			
			if ($row['takeoffVinicity'] > $takeoffRadious ) 
				$location=getWaypointName($row['takeoffID'])." [~".sprintf("%.1f",$row['takeoffVinicity']/1000)." km]"; 
			else $location=getWaypointName($row['takeoffID']);
	
			$XML_str.="<flight>
			<flightPilot>".htmlspecialchars($name)."</flightPilot>
			<flightTakeoff>".htmlspecialchars($location)."</flightTakeoff>
			<flightID>".$row["ID"]."</flightID>
			<flightUserID>".$row["userID"]."</flightUserID>
			<linkIGC>$linkIGC</linkIGC>
			";
			if ($flightID!=0) {
				$XML_str.="<linkShow>$link</linkShow>
				";
				foreach($row as $name=>$val) {
					$XML_str.="<$name>".htmlspecialchars($val)."</$name>
					";
				}
			}
			$XML_str.="</flight>";
		}

		$XML_str.="</result>";	
		send_XML($XML_str);

	} // submit flight
	else	if ($op=="submit_flight") {
		return; // we dont really need this, is done vi XMLRPC now
		require_once dirname(__FILE__).'/lib/miniXML/minixml.inc.php';
		$XML_str="<result>\n";
		$XML_path=$_GET['XMLform'];
		$XML_str.="<debug>Getting submit info from $XML_path</debug>\n";

		$linesArray=file($XML_path);
		$lines=implode("",$linesArray);
		$xmlDoc = new MiniXMLDoc();
		$xmlDoc->fromString($lines);
		$formArray=$xmlDoc->toArray();
		foreach($formArray[FORM] as $field=>$value ){
			$FL_FORM[$field] =$value ;
			// echo "$field : ".$FL_FORM[$field]."<BR>";
		}

		$sql = "SELECT ".$CONF['userdb']['user_id_field'].", ".$CONF['userdb']['username_field'].", ".$CONF['userdb']['password_field'].
			" FROM ".$CONF['userdb']['users_table']." WHERE ".$CONF['userdb']['username_field']." = '" . str_replace("\\'", "''", $FL_FORM["username"] ). "'";

		if ( !($result = $db->sql_query($sql)) )
		{
			$XML_str.="<returnCode>-20</returnCode>\n";
			$XML_str.="<returnCodeDescription>Error in obtaining userdata for ".$FL_FORM["username"]."</returnCodeDescription>\n";
			$XML_str.="<flightID>0</flightID>\n";
			$XML_str.="</result>";	
			send_XML($XML_str);
			exit;
		}

		$passwdProblems=0;
		if( $row = $db->sql_fetchrow($result) ) {
			if( md5($FL_FORM[passwd]) != $row['user_password'] ) $passwdProblems=1;
		} else 	$passwdProblems=1;

		if ($passwdProblems) {
			$XML_str.="<returnCode>-21</returnCode>\n";
			$XML_str.="<returnCodeDescription>Error in password for ".$FL_FORM["username"]."</returnCodeDescription>\n";
			$XML_str.="<flightID>0</flightID>\n";
			$XML_str.="</result>";	
			send_XML($XML_str);
			exit;
		}
  	   $FL_FORM["userID"]=$row['user_id'];

	   $filename = "tmp/".$FL_FORM["igcFilename"];	   
	   if (!$handle = fopen($filename, 'w')) { 
			$XML_str.="<returnCode>-22</returnCode>\n";
			$XML_str.="<returnCodeDescription>Cannot open file ($filename)</returnCodeDescription>\n";
			$XML_str.="<flightID>0</flightID>\n";
			$XML_str.="</result>";	
			send_XML($XML_str);
			exit;
	   } 
	
	   // Write $somecontent to our opened file. 
	   if (!fwrite($handle, $FL_FORM["igc"])) { 
			$XML_str.="<returnCode>-23</returnCode>\n";
			$XML_str.="<returnCodeDescription>Cannot write to file ($filename)</returnCodeDescription>\n";
			$XML_str.="<flightID>0</flightID>\n";
		  $XML_str.="</result>";	
	 	  send_XML($XML_str);
		  exit;
	   } 		
	   fclose($handle); 
							

		list($errCode,$flightID)=addFlightFromFile($filename,0,$FL_FORM["userID"],
				array('private'=>$FL_FORM["private"],'cat'=>$FL_FORM["cat"],'linkURL'=>$FL_FORM["linkURL"],'comments'=>$FL_FORM["comments"] ) 
				) ;

		$XML_str.="<returnCode>$errCode</returnCode>\n";
		$XML_str.="<returnCodeDescription>".htmlspecialchars(getAddFlightErrMsg($errCode,$flightID))."</returnCodeDescription>\n";
		$XML_str.="<flightID>$flightID</flightID>\n";
		$XML_str.="</result>\n";	
		send_XML($XML_str);
	}

	function send_XML($XML_str) {
		if (!empty($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Apache/2'))
			header ('Cache-Control: no-cache, pre-check=0, post-check=0, max-age=0');
		else header ('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
		header ('Expires: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
		header ('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header ('Content-Type: text/xml');
		echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\" ?>\n";
		echo $XML_str;	
	}
?>
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
	require_once "FN_pilot.php";
	require_once "FN_flight.php";
	require_once $moduleRelPath."/templates/".$PREFS->themeName."/theme.php";
	setDEBUGfromGET();

	
	if ( !auth::isAdmin($userID) ) { echo "go away"; return; }

	$op=makeSane($_GET['op']);	

	if ($op=='deleteTakeoffs'){	
		 $toDeleteStr=$_GET['takeoffs'];
		 $toDeleteList=split('_',$toDeleteStr);

		 //echo "list is :";
		 //print_r($toDeleteList); 
		 $flightsNum=waypoint::deleteBulk($toDeleteList);
		 
		 echo "$flightsNum flights relocated<BR>";
		 foreach($toDeleteList as $waypointIDdelete) {
				echo "Takeoff #$waypointIDdelete deleted<BR>";		
		 }
		
	}  if ($op=='getTakeoffInfo'){	
	
	
	$wpID=$_GET['wpID']+0;
		
		echo "<b>$wpID</b><BR>";
		
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
		
		echo "<a  target='_blank' href='".getRelMainFileName()."&op=show_waypoint&waypointIDview=$wpID'>$description</a><br>";
		
		
	
		$query="SELECT  MAX(MAX_LINEAR_DISTANCE) as record_km, ID  FROM $flightsTable  WHERE takeoffID =".$wpID." GROUP BY ID ORDER BY record_km DESC ";
		
		$flightNum=0;
		$res= $db->sql_query($query);
		if($res > 0){
			$flightNum=mysql_num_rows($res);
			
			if ($flightNum>0) {
				echo "<b><a href='".getRelMainFileName().
		"&op=list_flights&takeoffID=".$wpID."&year=0&month=0&season=0&pilotID=0&country=0&cat=0' target='_blank'> Flights[ ".$flightNum." ]</a></b><br>";
		echo "<b>"._SITE_RECORD."</b>:";

			$row = mysql_fetch_assoc($res);
		
			echo '<a target=\'_top\' href=\'http://'.$_SERVER['SERVER_NAME'].getRelMainFileName().'&op=show_flight&flightID='.$row['ID'].'\'>'.
			formatDistance($row['record_km'],1).'</a>';
			} else {
				echo " No flights from this location";
			}
		} 
		// echo ' " } ';
	}
	

?>
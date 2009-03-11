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
// $Id: EXT_takeoff_functions.php,v 1.8 2009/03/11 16:12:22 manolis Exp $                                                                 
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
	require_once dirname(__FILE__)."/templates/".$PREFS->themeName."/theme.php";
	setDEBUGfromGET();

	
	if ( !L_auth::isAdmin($userID) ) { echo "go away"; return; }

	$op=makeSane($_GET['op']);	

	if ($op=='addToArea'){	
		$tID=makeSane($_GET['tID']);
		$aID=makeSane($_GET['aID']);

		$query="INSERT INTO $areasTakeoffsTable	(areaID,takeoffID) VALUES ($aID,$tID)" ;
		// echo $query;
		$res= $db->sql_query($query);		
		if($res <= 0){
			echo "Problem in inserting takeoff to area";		
		} else {
			echo "Takeoff added to area<br>";
		}
		
	} else if ($op=='removeFromArea'){	
		$tID=makeSane($_GET['tID']);
		$aID=makeSane($_GET['aID']);

		$query="DELETE FROM $areasTakeoffsTable	WHERE areaID=$aID AND takeoffID=$tID" ;
		// echo $query;
		$res= $db->sql_query($query);		
		if($res <= 0){
			echo "Problem in removing takeoff from  area QUERY";				
		} else {
			if (mysql_affected_rows() ) 
				echo "Takeoff removed from area<br>";
			else 
				echo "Problem in removing takeoff from  area";			
		}
		
	}else  if ($op=='deleteTakeoffs'){	
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
		
		echo "<a  target='_blank' href='".
						getLeonardoLink(array('op'=>'show_waypoint','waypointIDview'=>$wpID)) 
					."'>$description</a><br>";
		
		
	
		$query="SELECT  MAX(MAX_LINEAR_DISTANCE) as record_km, ID  FROM $flightsTable  WHERE takeoffID =".$wpID." GROUP BY ID ORDER BY record_km DESC ";
		
		$flightNum=0;
		$res= $db->sql_query($query);
		if($res > 0){
			$flightNum=mysql_num_rows($res);
			
			if ($flightNum>0) {
				echo "<b><a href='".
					getLeonardoLink(array('op'=>'list_flights','takeoffID'=>$wpID,
							'year'=>0,'month'=>'0','season'=>'0','pilotID'=>'0_0','country'=>'0','cat'=>'0'					
					))."' target='_blank'> Flights[ ".$flightNum." ]</a></b><br>";
				echo "<b>"._SITE_RECORD."</b>:";

				$row = mysql_fetch_assoc($res);
		
				echo '<a target=\'_top\' href=\'http://'.$_SERVER['SERVER_NAME'].
					getLeonardoLink(array('op'=>'show_flight','flightID'=>$row['ID'])).'\'>'.
					formatDistance($row['record_km'],1).'</a>';
			} else {
				echo " No flights from this location";
			}
		} 
		// echo ' " } ';
	}
	

?>
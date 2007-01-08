<?php
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

$serverFunctions['takeoffs.findTakeoff']='findTakeoff';
function findTakeoff($args) {
	$sitePass=$args[0];
	$lat=$args[1];
	$lon=$args[2];
	if ( ! securityCheck($sitePass) ) return  new IXR_Error(4000, 'Access Denied');;

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
	// echo "&^".$nearestWaypoint->name."&";
	
	return array($nearestWaypoint,$minTakeoffDistance);		
}


$serverFunctions['takeoffs.getAll']='takeoffs_findAll';
function takeoffs_findAll($arg) {
	$sitePass=$arg[0];
	
	if ( ! securityCheck($sitePass) )  return  new IXR_Error(4000, 'Access Denied');

	if (count($waypoints)==0) 
		$waypoints=getWaypoints();
	return array(count($waypoints),$waypoints);
}


?>
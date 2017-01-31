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
// $Id: EXT_airspace.php,v 1.1 2010/03/17 15:06:24 manolis Exp $                                                                 
//
//************************************************************************
	
require_once dirname(__FILE__)."/EXT_config_pre.php";
require_once "config.php";
$CONF_use_utf=1;
require_once "EXT_config.php";

require_once "CL_flightData.php";
require_once "FN_functions.php";	
require_once "FN_UTM.php";
require_once "FN_waypoint.php";	
require_once "FN_output.php";
require_once dirname(__FILE__).'/lib/json/CL_json.php';
setDEBUGfromGET();

$op=makeSane($_REQUEST['op']);

if (!in_array($op,array("get_airspace")) ) return;
 
if ($op=="get_airspace") {	
	require_once dirname(__FILE__).'/FN_airspace.php';		
	// echo "$min_lat,	$max_lat,$min_lon,	$max_lon<BR>";

	// now find the bounding boxes that have common points
	// !( A1<X0 || A0>X1 ) &&  !( B1<Y0 || B0>Y1 )
	// X,A -> lon
	// Y,B -> lat 
	// X0 -> $min_lon A0-> $area->minx
	// X1 -> $max_lon A1-> $area->maxx
	// Y0 -> $min_lat B0-> $area->miny
	// Y1 -> $max_lat B1-> $area->maxy
	
	// !( $area->maxx<$min_lon || $area->minx>$max_lon ) &&  !( $area->maxx<$min_lat || $area->miny>$max_lat )

	//in germany, pilots are allowed to fly in class E and class G airspace, and in gliding sectors when they are activated (class W). 
	// All others are forbidden - start by colouring particularly the CTRs, TMAs and Danger Areas (EDs) .
	// $airspace_arr= array("R",  "Q", "P", "A", "B", "C", "CTR","D", "GP", "W", "E", "F");
	$airspace_color= array( "RESTRICT"=>"#ff0000", "DANGER"=>"#ff0000", "PROHIBITED"=>"#ff0000", 
							"CLASSA"=>"#0000ff", "CLASSB"=>"#0000ff", "CLASSC"=>"#0000ff", 
							"CTR"=>"#ff0000","CLASSD"=>"#0000ff", "NOGLIDER"=>"#0000ff",
							"WAVE"=>"#00ff00", "CLASSE"=>"#00ff00", "CLASSF"=>"#0000ff");

	global $AirspaceArea,$NumberOfAirspaceAreas;

	$min_lon=$_REQUEST['min_lon'];
	$max_lon=$_REQUEST['max_lon'];			
	$min_lat=$_REQUEST['min_lat'];
	$max_lat=$_REQUEST['max_lat'];

	//Mod. P. Wild 5.10.2009 - show a few more airspaces around track (increase proximity level)
	// show a bit more airspaces around the flight
	// Manolis 09.12.2009
	// put in the config variable $CONF['airspace']['zoom']
	if ( $CONF['airspace']['zoom'] && $CONF['airspace']['zoom']!=100  ) {
		// $zoom=102; //Percentage
		$zoom=$CONF['airspace']['zoom'];
		$min_lon=$min_lon+($min_lon*(100-$zoom))/100;
		$max_lon=$max_lon+($max_lon*($zoom-100))/100;
		$min_lat=$min_lat+($min_lat*(100-$zoom))/100;
		$max_lat=$max_lat+($max_lat*($zoom-100))/100;
	}
 
	getAirspaceFromDB($min_lon , $max_lon , $min_lat ,$max_lat);
	$NumberOfAirspaceAreas=count($AirspaceArea);
	// echo " // found( $NumberOfAirspaceAreas) areas  $min_lon , $max_lon , $min_lat ,$max_lat <BR>";	
	$res='{ "airspaces": [ ';
	$i=0;
	foreach ($AirspaceArea as $i=>$area) {
		if ($i>0) $res.=" ,\n";
		
		$points="";
		if ($area->Shape==1) { // area 					
			for($j=0;$j<$area->NumPoints;$j++) {
				if ($j>0) $points.=" ,";
				$points.=$area->Points[$j]->Latitude.",".$area->Points[$j]->Longitude."";
			}
		} else if ($area->Shape==2) { // cirle
			$pointsArray=CalculateCircle($area->Latitude,$area->Longitude,$area->Radius);
			for($j=0;$j<count($pointsArray);$j++) {
				if ($j>0) $points.=" ,";
				 $points.=$pointsArray[$j]->lat.",".$pointsArray[$j]->lng;
			}
		}	
			
					
		$res.=' { "type":"'.json::prepStr($area->Type).'", "name":"'.json::prepStr($area->Name).			
			'", "base":"'.json::prepStr(floor($area->Base->Altitude)).
			'", "top":"'.json::prepStr(floor($area->Top->Altitude)).
			'", "color":"'.json::prepStr($airspace_color[$area->Type]).			
			'", "points": ['.$points.'] } ';
		
		$i++;

	}
	$res.=' ]  }';
	echo $res;
		
} 

?>
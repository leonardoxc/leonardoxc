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
// $Id: EXT_map.php,v 1.6 2008/11/29 22:46:06 manolis Exp $                                                                 
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




	$op=makeSane($_REQUEST['op'],0);

	if (!$op) $op="get_map";	

	if (!in_array($op,array("get_map","get_height")) ) return;

	$encoding="iso-8859-1";

	if ($op=="get_height") {
		require_once dirname(__FILE__)."/CL_dem.php";
		$latArray=split(",",$_GET['lat']);
		$lonArray=split(",",$_GET['lon']);

		foreach ($latArray as $i=>$lat) {
			$lon=$lonArray[$i];	
			//echo "$lon,$lat<BR>";
			$ground[$i]=DEM::getAlt($lat,$lon);
			if ($i>0) echo ",";
			echo $ground[$i];		
		}
		return;
	} else if ($op=="get_map") {
		require_once dirname(__FILE__)."/CL_map.php";

		$min_lat=$_GET[min_lat]+0;
		$max_lat=$_GET[max_lat]+0;
		$min_lon=$_GET[min_lon]+0;
		$max_lon=$_GET[max_lon]+0;
	
		$lat_diff=$max_lat-$min_lat;
		$lon_diff=$max_lon-$min_lon;
	
		DEBUG("MAP",1,"MAP  min_lat: $min_lat, min_lon: $min_lon, max_lat: $max_lat, max_lon: $max_lon <BR>");	
	
		if ($lat_diff > 20 || $lon_diff > 20 ) return; // too much 
		
		list($MAP_LEFT,$MAP_TOP,$UTMzone,$UTMlatZone)=utm(-$max_lon,$max_lat);
		list($MAP_RIGHT,$MAP_BOTTOM,$UTMzone2,$UTMlatZone2)=utm(-$min_lon,$min_lat);
		
		$totalWidth1=calc_distance($min_lat, $min_lon,$min_lat, $max_lon);
		$totalWidth2=calc_distance($max_lat, $min_lon,$max_lat, $max_lon);
		$totalWidth=max($totalWidth1,$totalWidth2);
		$totalWidth_initial=$totalWidth;
		$totalHeight=$MAP_TOP-$MAP_BOTTOM;
	
		DEBUG("MAP",1,"MAP (right, left) :".$MAP_RIGHT." [".$UTMzone2."] ,".$MAP_LEFT."[".$UTMzone."]<BR>");
		DEBUG("MAP",1,"MAP (top, bottom) :".$MAP_TOP." ,".$MAP_BOTTOM."<BR>");
		DEBUG("MAP",1,"MAP (witdh,height) :".$totalWidth.",".$totalHeight."<BR>");
		
		if ($totalWidth> $totalHeight ) {  
			// Landscape  style
			DEBUG("MAP",1,"Landscape style <BR>");		
			DEBUG("MAP",1,"totalWidth: $totalWidth, totalHeight: $totalHeight, totalHeight/totalWidth: ".( $totalHeight / $totalWidth)."<br>");
			if ( $totalHeight / $totalWidth < 3/4 ) $totalHeight = (3/4) *  $totalWidth ;			
		} else { 
			// portait style
			DEBUG("MAP",1,"Portait style <BR>");
			DEBUG("MAP",1,"totalWidth: $totalWidth, totalHeight: $totalHeight, totalWidth/totalHeight: ".( $totalWidth / $totalHeight)."<br>");
			if ( $totalWidth  / $totalHeight < 3/4 )  $totalWidth  = (3/4) * $totalHeight ;
		}
	
		$marginHor=2000  + floor ( $totalWidth / 20000 ) * 1000 +  ($totalWidth - ($totalWidth_initial))/2 ;   //in meters
		$marginVert=1000 + floor ( $totalHeight / 20000 ) * 1000 + ($totalHeight - ($MAP_TOP-$MAP_BOTTOM))/2;   //in meters
	
		if ($marginHor > $marginVert ) {  
			// landscape style ...
			if ( $marginVert / $marginHor < 3/4 ) $marginVert = (3/4) *  $marginHor  ;
		} else { 
			// portait style
			if ( $marginHor / $marginVert < 3/4 )  $marginHor = (3/4) * $marginVert ;
		}
		
		DEBUG("MAP",1,"marginHor: $marginHor, marginVert:$marginVert <br>");


		$flMap=new flightMap($UTMzone,$UTMlatZone, $MAP_TOP + $marginVert, $MAP_LEFT - $marginHor,$UTMzone2, $UTMlatZone2, $MAP_BOTTOM - $marginVert ,$MAP_RIGHT +$marginHor  , 600,800,"","", 0 );
		DEBUG("MAP",1,"MAP Required m/pixel = ".$flMap->metersPerPixel."<br>");
		$flMap->showTrack=0;
		$flMap->showWaypoints=0;
		header ('Content-Type: image/jpeg');
		$flMap->drawFlightMap();
	
	}

?>
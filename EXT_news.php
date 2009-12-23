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
// $Id: EXT_news.php,v 1.1 2009/12/23 14:02:17 manolis Exp $                                                                 
//
//************************************************************************

 	require_once dirname(__FILE__)."/EXT_config_pre.php";
	require_once "config.php";
 	require_once "EXT_config.php";

	require_once "FN_functions.php";	
	require_once "FN_waypoint.php";	
	require_once "FN_pilot.php";
	/*require_once "CL_flightData.php";	
	require_once "FN_UTM.php";	
	require_once "FN_output.php";	
	require_once "FN_flight.php";	
	*/
	// setDEBUGfromGET();
	
	
	if ( $CONF['news']['config']['showNews'] ) {	
		if ( count($CONF['news']['items']) ) {
			foreach($CONF['news']['items'] as $newsItemID=>$newsItem) {
				if (!$newsItem['active']) continue;
				$link=$newsItem['link'];
				if ($link==$newsItemID)  {
					$linkStr=" href='#' onclick='showNewsItem($newsItemID)' ";
				
				} else {
					$linkStr=" href='".$link."' ";
					if ( $newsItem['target'] ) {
						$linkStr.=" target='".$newsItem['target']."' ";
					}
				}					
				if ($newsItem['date']) {
					$dateStr="<span>".$newsItem['date']."</span>";
				} else {
					$dateStr='';
				}
				echo "<li>$dateStr<a $linkStr>".$newsItem['text']."</a></li>";
			}
		}	
	} 
	
	if ( $CONF['news']['config']['showBestFlights'] ){
		global $prefix, $db, $sitename, $user, $cookie, $flightsTable;			
		global $CONF_glider_types,$gliderCatList,$module_name;

		$count = 1;
	
		$content .="<li><b>Best scores for ".date("Y")."</b> </li>";
	
		foreach ( $CONF_glider_types as $gl_id=>$gl_type) {
	
			$query="SELECT * FROM $flightsTable
					WHERE DATE_FORMAT( DATE, '%Y' ) =".date("Y")." AND cat =".$gl_id."
					ORDER BY flight_points DESC
					LIMIT 1 ";
			$result1 = $db->sql_query($query);
		
			
			// Listing Topics
			while($row= $db->sql_fetchrow($result1)) {		
				 $flightID=$row["ID"];
				 $name=getPilotRealName($row["userID"],$row["serverID"],0,0,0);
				 $takeoffName=getWaypointName($row["takeoffID"]);
				 $takeoffVinicity=$row["takeoffVinicity"];
				 $takeoffNameFrm=	formatLocation($takeoffName,$takeoffVinicity,$takeoffRadious );
				 $flightDurationFrm=sec2Time($row['DURATION'],1);		
		
				$content .= "<li>:: <span>".$gliderCatList[$gl_id]."</span>";
				$content .= "<a href='".getLeonardoLink(array('op'=>'show_flight','flightID'=>$flightID))."'>";
				$content .= "$name</a> [ $takeoffName ] ".formatDate($row["DATE"]).
							//" "._DURATION.": $flightDurationFrm".
							" <a href='".getLeonardoLink(array('op'=>'show_flight','flightID'=>$flightID))."'>"._OLC_SCORING.":".formatOLCScore($row['FLIGHT_POINTS'])."</a> </li>";
				$count = $count + 1;
			}	
		}		
		echo $content;
	}
?>
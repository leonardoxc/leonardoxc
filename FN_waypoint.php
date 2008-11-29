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
// $Id: FN_waypoint.php,v 1.26 2008/11/29 22:46:07 manolis Exp $                                                                 
//
//************************************************************************
require_once dirname(__FILE__).'/FN_output.php';

function findNearestWaypoint($lat,$lon) {
	global $waypoints;

	$point=new GpsPoint();
	$point->setLat($lat);
	$point->setLon($lon);

	if (count($waypoints)==0) 
		$waypoints=getWaypoints();

	$nearestID=0;
	$minDistance=1000000;

	foreach($waypoints as $waypoint) {
	   $distance = $point->calcDistance($waypoint);
	   if ( $distance < $minDistance ) {
			$minDistance = $distance;
			$nearestID=$waypoint->waypointID;
	   }
	}
	return array($nearestID,$minDistance);
}

function getTakeoffsCountryContinent() {
	global $db;
	global $flightsTable,$waypointsTable;
	require_once dirname(__FILE__)."/FN_areas.php";

  	$query="SELECT DISTINCT takeoffID, $waypointsTable.countryCode 
			FROM $flightsTable,$waypointsTable WHERE takeoffID<>0 AND $waypointsTable.ID=$flightsTable.takeoffID";
	// echo $query;
	$res= $db->sql_query($query);		
    if($res <= 0){
		return array( array (),array ());
    }

	$takeoffsCountry=array();
	$takeoffsContinent=array();
	while ($row = $db->sql_fetchrow($res)) { 
		$id=$row["takeoffID"];
		$countryCode=$row["countryCode"];
		$takeoffsCountry[$id]=$countryCode;
		$takeoffsContinent[$id]=$countries2continent[$countryCode];
	}

	return array($takeoffsCountry,$takeoffsContinent);

}

function getTakeoffList() {
	global $db;
	global $flightsTable;

  	$query="SELECT DISTINCT takeoffID FROM $flightsTable WHERE takeoffID<>0";
	// echo $query;
	$res= $db->sql_query($query);		
    if($res <= 0){
		return array( array (),array () );
    }

	$takeoffs=array();
	$takeoffsID=array();
	while ($row = $db->sql_fetchrow($res)) { 
 		 $tnames[$row["takeoffID"]]=getWaypointName($row["takeoffID"],-1,1);
	}
	if (!empty($tnames)) {
		asort($tnames);
		foreach($tnames as $takeoffID=>$takeoffName) {
				 array_push($takeoffs,$takeoffName );
				 array_push($takeoffsID,$takeoffID );
		}
	}
	return array($takeoffs,$takeoffsID);

}



function getCountriesList($year=0,$month=0,$clubID=0,$pilotID=0) {
	global $db;
	global $flightsTable,$waypointsTable,$pilotsTable,$areasTakeoffsTable;
	global 	$clubsPilotsTable,$clubsFlightsTable,$moduleRelPath,$countries;	
	global $clubsList;

	$where_clause="";
	if ($clubID) {
		 require dirname(__FILE__)."/INC_club_where_clause.php";
		/*	if ( is_array($clubsList[$clubID]['countryCodes']) ) {			
			foreach ($clubsList[$clubID]['countryCodes'] as $cCode ) {
				$where_clause.=" AND countryCode='$cCode' ";
			}
		}	
		*/
	}	
	
  	$query="SELECT DISTINCT countryCode, count(*) as FlightsNum 
			FROM $flightsTable,$waypointsTable $extra_table_str  
			WHERE 
				$flightsTable.takeoffID=$waypointsTable.ID  
				AND $flightsTable.userID<>0 $where_clause
				GROUP BY countryCode ORDER BY countryCode ASC";	
	// echo $query;
	$res= $db->sql_query($query);		
    if($res <= 0){
		return array( array (),array () );
    }

	$countriesCodes=array();
	$countriesNames=array();
	$countriesFlightsNum=array();
//	while ($row = $db->sql_fetchrow($res)) { 
	while ($row = mysql_fetch_array($res)) { 
		$countriesN[$row["countryCode"]]= $countries[$row["countryCode"]];
		$countriesFNum[$row["countryCode"]]= $row["FlightsNum"];
	}
	if (!empty($countriesN) ){
		asort($countriesN);
		foreach($countriesN as $countryCode=>$countryName) {
				 array_push($countriesNames,$countryName );
				 array_push($countriesCodes,$countryCode );
				 array_push($countriesFlightsNum,$countriesFNum[$countryCode] );
				// echo $countriesFNum[$countryCode] ."->".$countryCode."<br>";
		}
	}
	
	return array($countriesCodes,$countriesNames,$countriesFlightsNum);
}

function getWaypoints($tm=0,$onlyTakeoffs=0,$utf=0) {
	global $db,$waypointsTable;
	set_time_limit(200);
	if ($onlyTakeoffs)
		$query="SELECT * from $waypointsTable WHERE type=1000";
	else 
		$query="SELECT * from $waypointsTable ".(($tm)?" WHERE modifyDate>=FROM_UNIXTIME($tm) AND type=1000 ":"");
	$res= $db->sql_query($query);
		
    if($res <= 0){
	  if (!$tm) {
	      echo("<H3>"._NO_KNOWN_LOCATIONS."</H3>\n");
    	  exit();
	  } else return array();
    }

	$waypoints=array();
	$i=0;
	// while ($row = $db->sql_fetchrow($res)) { 
	// $rows=$db->sql_fetchrowset($res);
	
    while ($row = mysql_fetch_assoc($res)) { 
	 //foreach($rows as $row) {
	  $waypoints[$i]=new gpsPoint();
 	  $waypoints[$i]->waypointID=$row["ID"];

	  if ($utf ) {
			$waypoints[$i]->name=urlencode(mb_convert_encoding($row["name"] ,'iso-8859-7', "UTF-8"));
			$waypoints[$i]->intName=urlencode(mb_convert_encoding($row["intName"] ,'iso-8859-1', "UTF-8"));

	  } else {
		  $waypoints[$i]->name=urlencode($row["name"]);
		  $waypoints[$i]->intName=urlencode($row["intName"]);
	  }
   	  $waypoints[$i]->lat=$row["lat"];
   	  $waypoints[$i]->lon=$row["lon"];
	  $waypoints[$i]->type=$row["type"];
  	  $i++;	  
    }     

    $db->sql_freeresult($res);
	return $waypoints;
}

function getWaypointFull($ID) {
	global $db,$waypointsTable;
	global $CONFIG_forceIntl;

	$query="SELECT * from $waypointsTable WHERE ID=".$ID;
	$res= $db->sql_query($query);			
	if($res <= 0) return array(0,"UNKNOWN","UNKNOWN","UNKNOWN");
	
	$row = $db->sql_fetchrow($res) ;
	$db->sql_freeresult($res);

	return array($ID,$row["name"],$row["intName"],$row["countryCode"]);
}

function getWaypointName($ID,$forceIntl=-1,$countryFirst=0,$maxChars=0) {
	global $db,$waypointsTable;
	global $CONFIG_forceIntl;

    if ($forceIntl==-1) $forceIntl=$CONFIG_forceIntl	;
		
	$query="SELECT * from $waypointsTable WHERE ID=".$ID;
	$res= $db->sql_query($query);			
	if($res <= 0) return "UNKNOWN";
	
	$row = $db->sql_fetchrow($res) ;
	$db->sql_freeresult($res);

	$tname=selectWaypointName($row["name"],$row["intName"],$row["countryCode"],$forceIntl);
	$tname=trimText($tname,$maxChars);
	
	if ($countryFirst)	return $row["countryCode"]." - ".$tname;	
	else return $tname." - ".$row["countryCode"];	
}

function selectWaypointName($name,$intName,$countryCode,$forceIntl=-1) {
	global $currentlang,$nativeLanguage;
	global $CONFIG_forceIntl;

    if ($forceIntl==-1) $forceIntl=$CONFIG_forceIntl	;
		
//	if ( $nativeLanguage==$currentlang || countryHasLang($countryCode,$currentlang)   ) $tname=$name;
	if ( countryHasLang($countryCode,$currentlang)  && !$forceIntl ) $tname=$name;
	else $tname=$intName;

	return $tname;
}

function selectWaypointLocation($name,$intName,$countryCode,$forceIntl=-1) {
	global $currentlang,$nativeLanguage;
	global $CONFIG_forceIntl;

    if ($forceIntl==-1) $forceIntl=$CONFIG_forceIntl	;
		
//	if ( $nativeLanguage==$currentlang || countryHasLang($countryCode,$currentlang)   ) $tname=$name;
	if ( countryHasLang($countryCode,$currentlang)  && !$forceIntl ) $tname=$name;
	else $tname=$intName;

	return $tname;
}

function countryCodeToLanguage($countryCode) {
	global $lang2iso;
	if ( ($lang=array_search(strtolower($countryCode),$lang2iso)) === NULL )  $lang='';
	return $lang;
}
function  countryHasLang($countryCode,$language) {
	 global $CONFIG_langsSpoken;

	 $countryCode=	strtolower($countryCode);
	 $language =	strtolower($language);

	 // if ($countryCode==$language) return 1;
	 if  ($CONFIG_langsSpoken[$language])
		 if ( in_array($countryCode, $CONFIG_langsSpoken[$language]) ) return 1;

	 return 0;
}

function  getKMLFilename($waypointID) {	
		global $waypointsAbsPath;
		return $waypointsAbsPath."/".$waypointID.".kml";  
}

function  getKMLrelPath($waypointID) {	
		global $waypointsWebPath;
		return $waypointsWebPath."/".$waypointID.".kml";  
}

function  makeKMLwaypoint($waypointID) {	
	global $langEncodings,$currentlang, $CONF_use_utf ;
  
	$placemarkString=makeWaypointPlacemark($waypointID) ;

//	$xml_text='<?xml version="1.0" encoding="'.$langEncodings[$currentlang].'"? >'.
	$xml_text='<?xml version="1.0" encoding="UTF-8"?>'.
'<kml xmlns="http://earth.google.com/kml/2.1">
'.$placemarkString.'
</kml>
';
	if (! $CONF_use_utf ) {
		require_once dirname(__FILE__)."/lib/ConvertCharset/ConvertCharset.class.php";
		$NewEncoding = new ConvertCharset;
		$FromCharset=$langEncodings[$currentlang];
		$xml_text = $NewEncoding->Convert($xml_text, $FromCharset, "utf-8", $Entities);
	}
	return $xml_text;
}

function  makeWaypointPlacemark($waypointID,$returnCountryCode=0) {	
	global $db, $waypointsTable;
	global $flightsTable,$countries,$CONF_mainfile,$moduleRelPath;

    $wpInfo =new waypoint($waypointID);
    $wpInfo->getFromDB();

    $wpName= selectWaypointName($wpInfo->name,$wpInfo->intName,$wpInfo->countryCode);
    $wpLocation = selectWaypointLocation($wpInfo->location,$wpInfo->intLocation,$wpInfo->countryCode);

	 $query="SELECT  MAX(MAX_LINEAR_DISTANCE) as record_km, ID FROM $flightsTable  WHERE takeoffID =".$waypointID." GROUP BY ID ORDER BY record_km DESC ";
	
	 $flightNum=0;
	 $res= $db->sql_query($query);
	 if($res > 0){
		$flightNum=mysql_num_rows($res);
		$row = $db->sql_fetchrow($res);
	
		$siteRecordLink="<a href='http://".$_SERVER['SERVER_NAME'].
			getLeonardoLink(array('op'=>'show_flight','flightID'=>$row['ID']))."'>".
			formatDistance($row['record_km'],1)."</a>";
	 } else $siteRecordLink="";
	
	 $pointFlightsLink="<a href='http://".$_SERVER['SERVER_NAME'].
		getLeonardoLink(array('op'=>'list_flights','takeoffID'=>$waypointID,'year'=>'0','season'=>'0'))
		."'>"._See_flights_near_this_point." [ ".$flightNum." ]</a>";
	 $countryFlightsLink="<a href='http://".$_SERVER['SERVER_NAME'].
		 getLeonardoLink(array('op'=>'list_flights','takeoffID'=>'0','year'=>'0','season'=>'0','country'=>$wpInfo->countryCode))
		."'>".$countries[$wpInfo->countryCode]."</a>";
	 if ($wpInfo->link) $siteLink='<a href="'.formatURL($wpInfo->link).'" target="_blank">'.formatURL($wpInfo->link).'</a>';
	 else $siteLink="-";

// "<?xml version='1.0' encoding='".$langEncodings[$currentlang]."'? >
// <?xml version="1.0" encoding="UTF-8"? >
$xml_text='<Placemark>
  <name>'.$wpName.'</name>
  <description><![CDATA[<table cellpadding=0 cellspacing=0 width=300>'.
	'<tr bgcolor="#D7E1EE"><td>'._SITE_REGION .': '.$wpLocation.' - '.$countryFlightsLink.'</td></tr>'.
	'<tr bgcolor="#CCCCCC"><td>'.$pointFlightsLink.'</td></tr>'.
	'<tr ><td>'._SITE_RECORD.' : '.$siteRecordLink.'</td></tr>'.
	'<tr bgcolor="#CCCCCC"><td>'._SITE_LINK .' : '.$siteLink.'</td></tr>'.
	'<tr ><td>'.$wpInfo->description.'</td></tr>'.
	'<tr ><td></td></tr>'.
	'</table>	
    ]]>
 </description>
  <LookAt>
    <longitude>'.(-$wpInfo->lon).'</longitude>
    <latitude>'.$wpInfo->lat.'</latitude>
    <range>10000</range>
    <tilt>0</tilt>
    <heading>0</heading>
  </LookAt>
  <styleUrl>root://styleMaps#default+nicon=0x307+hicon=0x317</styleUrl>
  <Style>
    <IconStyle>
      <scale>0.8</scale>
      <Icon>
        <href>root://icons/palette-4.png</href>
        <x>160</x>
        <y>128</y>
        <w>32</w>
        <h>32</h>
      </Icon>
    </IconStyle>
    <LabelStyle>
      <scale>0.8</scale>
    </LabelStyle>
  </Style>
  <Point>
    <coordinates>'.(-$wpInfo->lon).','.$wpInfo->lat.',0</coordinates>
  </Point>
</Placemark>';
	if ($returnCountryCode) {
		return array($xml_text,$wpInfo->countryCode);
	} else return $xml_text;

}
?>
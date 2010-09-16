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
// $Id: download.php,v 1.36 2010/09/16 09:44:26 manolis Exp $                                                                 
//
//************************************************************************
	
	if ($_GET["show_url"]) {
		$link=substr("http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'],0,-11);
		echo "The link to KML file is <br><a href='$link'>$link</a>";

		return;
	}

 	require_once dirname(__FILE__)."/EXT_config_pre.php";
	require_once dirname(__FILE__)."/config.php";
 	require_once dirname(__FILE__)."/EXT_config.php";

	require_once dirname(__FILE__)."/FN_functions.php";	
	require_once dirname(__FILE__)."/FN_UTM.php";
	require_once dirname(__FILE__)."/FN_pilot.php";
	require_once dirname(__FILE__)."/FN_waypoint.php";	
	require_once dirname(__FILE__)."/FN_output.php";
	require_once dirname(__FILE__)."/CL_flightData.php";
	require_once dirname(__FILE__)."/language/".CONF_LANG_ENCODING_TYPE."/lang-".$currentlang.".php";
	require_once dirname(__FILE__)."/language/".CONF_LANG_ENCODING_TYPE."/countries-".$currentlang.".php";

	setDEBUGfromGET();
	

	$type=makeSane($_REQUEST['type']);
	if (!in_array($type,array("kml_task","kml_trk","kml_trk_color","kml_wpt","sites","igc","explore_ge","explore")) ) return;

	$updateColor=makeSane($_REQUEST['updateColor']);
	if ($updateColor) $type='kml_trk_color';
	
	$attachmentMIME = "application/vnd.google-earth.kml+xml";
	if ($type=="igc") {
		$zip=makeSane($_REQUEST['zip'],1);
		
		$flightID=makeSane($_REQUEST['flightID'],1);
		$flight=new flight();
		$flight->getFlightFromDB($flightID);
			
		if (!$zip ) {
			$outputStr=implode("",file($flight->getIGCFilename(0)) );
			$outputFilename=$flight->filename;
			$attachmentMIME ='text/plain';
		} else {
			require_once dirname(__FILE__)."/lib/pclzip/pclzip.lib.php";
			$tmpZipFile="$flightID.zip";

			$archive = new PclZip($CONF_tmp_path.'/'.$tmpZipFile);
			$v_list = $archive->create(	array(
				array(	PCLZIP_ATT_FILE_NAME => "$flightID.igc",
						PCLZIP_ATT_FILE_CONTENT => implode("",file($flight->getIGCFilename() ) ) 
					  ), 
				array(	PCLZIP_ATT_FILE_NAME => "$flightID.saned.igc",
						PCLZIP_ATT_FILE_CONTENT => implode("",file($flight->getIGCFilename(1) )) 
                      )
				),					
				PCLZIP_OPT_REMOVE_ALL_PATH);

			$outputStr=implode("",file($CONF_tmp_path.'/'.$tmpZipFile) );
			@unlink($CONF_tmp_path.'/'.$tmpZipFile);
			$outputFilename=$tmpZipFile;
			$attachmentMIME ='application/zip';
		}
		
		// echo "$outputFilename <BR>";exit;
		
		
		header("Content-type: $attachmentMIME");
		header('Content-Disposition: inline; filename="'.$outputFilename.'"');
		header("Content-Transfer-Encoding: binary");
		header("Content-length: ".strlen($outputStr));
		echo $outputStr;
		return;
		
	} else if ($type=="kml_task") {
		//$isExternalFile=0;
		//setLeonardoPaths();

		$moduleRelPath=moduleRelPath(0); 
		$waypointsWebPath=$moduleRelPath."/".$waypointsRelPath;

		$flightID=makeSane($_REQUEST['flightID'],1);
		//echo $_SERVER['QUERY_STRING'];
		
		DEBUG("DL",1,"Will serve task for flight $flightID<BR>");

		$flight=new flight();
		$flight->getFlightFromDB($flightID);
	//	if ( $flight->userID!=$userID && ! L_auth::isAdmin($userID) && $flight->private) {
	//		echo _FLIGHT_IS_PRIVATE;
	//		return;
	//	}
		$xml=$flight->kmlGetTask();
		//$xml=$flight->createKMLfile("ff0000",1,2);

		$file_name=$flight->filename.".task.kml";	
		DEBUG("DL",1,"KML Filepath= $file_path<BR>");
	} else if ($type=="kml_trk_color") {
	
		$moduleRelPath=moduleRelPath(0); 
		$waypointsWebPath=$moduleRelPath."/".$waypointsRelPath;
		
		$flightID=makeSane($_REQUEST['flightID'],1);
		//echo $_SERVER['QUERY_STRING'];
		$w=makeSane($_GET['w'],1);
		$c=makeSane($_GET['c']);
		$ex=makeSane($_GET['ex'],1);
		$an=makeSane($_GET['an'],1);

		if (!$w) $w=2;
		if (!$c) $c="ff0000";
		if (!$ex) { $ex=1; }
		
		DEBUG("DL",1,"Will serve flight $flightID<BR>");

		$flight=new flight();
		$flight->getFlightFromDB($flightID);
		
		// $getFlightKML=$flight->getFlightKML()."&c=$c&ex=$ex&w=$w&an=$an";
		
		$getFlightKML="http://".str_replace('//','/',$_SERVER['SERVER_NAME']."/$baseInstallationPath/".$flight->getKMLRelPath(0));
				
			$KMLlineColor="ff".substr($c,4,2).substr($c,2,2).substr($c,0,2);
			
		$xml='<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://www.opengis.net/kml/2.2"
 xmlns:gx="http://www.google.com/kml/ext/2.2">
 '.
"<NetworkLinkControl>
  <Update>
    <targetHref>".str_replace("&","&amp;",$getFlightKML)."</targetHref>
    <Change>
      <Style targetId='#Track1'>	  					
		<LineStyle>
		  <color>$KMLlineColor</color>
		  <width>$w</width>
		</LineStyle>
	 </Style>
	 <Style targetId='#Track2'>	  					
		<LineStyle>
		  <color>$KMLlineColor</color>
		  <width>$w</width>
		</LineStyle>
	 </Style>
    </Change>
  </Update>
</NetworkLinkControl>
</kml>";
//echo $xml;
//exit;
	} else if ($type=="kml_trk") {
		$moduleRelPath=moduleRelPath(0); 
		$waypointsWebPath=$moduleRelPath."/".$waypointsRelPath;

		$flightID=makeSane($_REQUEST['flightID'],1);
		//echo $_SERVER['QUERY_STRING'];
		$w=makeSane($_GET['w'],1);
		$c=makeSane($_GET['c']);
		$ex=makeSane($_GET['ex'],1);
		$an=makeSane($_GET['an'],1);

		if (!$w) $w=2;
		if (!$c) $c="ff0000";
		if (!$ex) { $ex=1; }
		
		DEBUG("DL",1,"Will serve flight $flightID<BR>");

		$flight=new flight();
		$flight->getFlightFromDB($flightID);
	//	if ( $flight->userID!=$userID && ! L_auth::isAdmin($userID) && $flight->private) {
	//		echo _FLIGHT_IS_PRIVATE;
	//		return;
	//	}
		if ($an == 2) {
		    $xml=$flight->createKMZfile($c,$ex,$w,$an);
			
			$version=$CONF['googleEarth']['igc2kmz']['version'];
			$file_name=$flight->filename.".igc2kmz.$version.kmz";
		    // $file_name=$flight->filename.".kmz";
							
		    $attachmentMIME="application/vnd.google-earth.kmz";
		    DEBUG("DL",1,"KMZ Filepath= $file_name<BR>");
		} else {
		    $xml=$flight->createKMLfile($c,$ex,$w,$an);
		    //$xml=$flight->createKMLfile("ff0000",1,2);

		    $file_name=$flight->filename.".kml";	
		    DEBUG("DL",1,"KML Filepath= $file_name<BR>");
		    
		    //echo "<pre>$xml</pre>";
		    //DEBUG_END();
		    //exit;
		}
	} else if ($type=="gpx_trk") {
		$flightID=makeSane($_REQUEST['flightID'],1);
		//echo $_SERVER['QUERY_STRING'];
		DEBUG("DL",1,"Will serve flight $flightID<BR>");
		$flight=new flight();
		$flight->getFlightFromDB($flightID);
		$xml=$flight->createGPXfile();
		$file_name=$flight->filename.".xml";
		DEBUG("DL",1,"GPX Filepath= $file_path<BR>");
	} else 	if ($type=="kml_wpt") {		
		$waypointID=makeSane($_REQUEST['wptID'],1);
		
		$xml=makeKMLwaypoint($waypointID);
		$file_name=$waypointID.'.kml';
	} else	if ($type=="sites") {
		$sites=makeSane($_GET['sites']);
		$sitesList=explode(",",$sites);
//		$xml='<?xml version="1.0" encoding="'.$langEncodings[$currentlang].'"? >'.
		$xml='<?xml version="1.0" encoding="UTF-8"?>'.
		'<kml xmlns="http://earth.google.com/kml/2.1">\n
		<Folder>
		<name>Leonardo Site List</name>';

		foreach($sitesList as $waypointID) {		
			list($xml_str,$countryCode)=makeWaypointPlacemark($waypointID,1);
			if (!is_array($takeoffs[$countryCode]) ) $takeoffs[$countryCode]=array();
			array_push($takeoffs[$countryCode],$xml_str);

		}

		foreach($takeoffs as $countryCode=>$countrySites) {		
			$xml.="<Folder>\n<name>".$countries[$countryCode]."</name>\n";
			foreach ($countrySites as $siteXml) {
				$xml.=$siteXml;
			}
			$xml.="</Folder>";
		}
		
		$xml.="</Folder>\n</kml>\n";
		
		require_once dirname(__FILE__)."/lib/ConvertCharset/ConvertCharset.class.php";
		$NewEncoding = new ConvertCharset;
		$FromCharset=$langEncodings[$currentlang];
		$xml = $NewEncoding->Convert($xml, $FromCharset, "utf-8", $Entities);
		
		$file_name="Leonardo site guide.kml";
	
	} else if ($type=="explore_ge") {
		$baseUrl="http://".str_replace('//','/',$_SERVER['SERVER_NAME']."/$baseInstallationPath/$moduleRelPath");
	
		$fltr=$_GET['fltr'];
		if ($fltr) $fltr="&fltr=$fltr";
		$exploreKML="$baseUrl/download.php?type=explore$fltr";
		
		$logoUrl="$baseUrl/templates/basic/tpl/leonardo_logo.gif";
		
		$xml='<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://www.opengis.net/kml/2.2">
  <Folder>
    <name>Leonardo Flight Database</name>
    <visibility>1</visibility>
    <open>1</open>
    <description>Browse the entire Leonardo Database on Google Earth. This includes tracks,takeoff locations and photos</description>
    <NetworkLink>
      <name>Interactive Explorer</name>
	  <Snippet maxLines="0"></Snippet>
      <visibility>1</visibility>
      <open>1</open>
      <description>When you move to a new location all tracks,takeoffs and photos will be displayed on the map</description>
      <refreshVisibility>0</refreshVisibility>
      <flyToView>0</flyToView>
      <Link>
	   <viewFormat>BBOX=[bboxWest],[bboxSouth],[bboxEast],[bboxNorth]&amp;ALT=[cameraAlt]</viewFormat>
        <href><![CDATA['.$exploreKML.']]></href>
        <refreshInterval>0</refreshInterval>
        <viewRefreshMode>onStop</viewRefreshMode>
        <viewRefreshTime>1</viewRefreshTime>
      </Link>
    </NetworkLink>
  </Folder>
</kml>';

		$file_name="Leonardo Explorer.kml";
	} else if ($type=="explore") {
		// BBOX=[longitude_west, latitude_south, longitude_east, latitude_north]
		$cameraAlt=$_GET['ALT'];
		$box=$_GET['BBOX'];
		$parts=split(",",$box);


		$west	= $parts[0];
		$south	= $parts[1];
		$east	= $parts[2];
		$north	= $parts[3];

		$center_lon = (($east - $west) / 2) + $west;
		$center_lat = (($north - $south) / 2) + $south;

$styleTakeoff='
	<Style id="marker_takeoff_n">
		<IconStyle>
			<color>ff00aa00</color>
			<scale>1</scale>
			<Icon>
				<href>http://maps.google.com/mapfiles/kml/shapes/flag.png</href>
			</Icon>
			<hotSpot x="0.5" y="0" xunits="fraction" yunits="fraction"/>
		</IconStyle>
		<LabelStyle>
			<color>00ffffff</color>
		</LabelStyle>
		<ListStyle>
		</ListStyle>
	</Style>
	<Style id="marker_takeoff_h">
		<IconStyle>
			<color>ff00aa00</color>
			<scale>1</scale>
			<Icon>
				<href>http://maps.google.com/mapfiles/kml/shapes/flag.png</href>
			</Icon>
			<hotSpot x="0.5" y="0" xunits="fraction" yunits="fraction"/>
		</IconStyle>
		<LabelStyle>
			<color>ffffffff</color>
		</LabelStyle>
		<ListStyle>
		</ListStyle>
	</Style>
	 <StyleMap id="marker_takeoff">
    <Pair>
      <key>normal</key>
      <styleUrl>#marker_takeoff_n</styleUrl>
    </Pair>
    <Pair>
      <key>highlight</key>
      <styleUrl>#marker_takeoff_h</styleUrl>
    </Pair>
  </StyleMap>
	';
	
$stylePhoto='	
	<Style id="marker_photo">
		<IconStyle>
			<color>ff00ff00</color>
			<scale>0.8</scale>
			<Icon>
				<href>http://maps.google.com/mapfiles/kml/shapes/camera.png</href>
			</Icon>
			<hotSpot x="0.5" y="0" xunits="fraction" yunits="fraction"/>
		</IconStyle>
		<LabelStyle>
			<color>00ffffff</color>
		</LabelStyle>
		<ListStyle>
		</ListStyle>
		</Style>
	';
	
	$styleTrack='';
	foreach( $CONF_glider_types as $tmpcat=>$tmpcatname) {	  
		$styleTrack.='	
		<Style id="marker_cat_'.$tmpcat.'_n">
		<IconStyle>			
			<scale>0.8</scale>
			<Icon>
				<href>http://'.$_SERVER['SERVER_NAME'].getRelMainDir().'/img/icons1/icon_cat_'.$tmpcat.'.png</href>
			</Icon>
			<hotSpot x="0.5" y="0" xunits="fraction" yunits="fraction"/>
		</IconStyle>
		<LabelStyle>
			<color>00ffffff</color>
		</LabelStyle>
		<ListStyle>
		</ListStyle>
	</Style>
	<Style id="marker_cat_'.$tmpcat.'_h">
		<IconStyle>			
			<scale>0.8</scale>
			<Icon>
				<href>http://'.$_SERVER['SERVER_NAME'].getRelMainDir().'/img/icons1/icon_cat_'.$tmpcat.'.png</href>
			</Icon>
			<hotSpot x="0.5" y="0" xunits="fraction" yunits="fraction"/>
		</IconStyle>
		<LabelStyle>
			<color>ffffffff</color>
		</LabelStyle>
		<ListStyle>
		</ListStyle>
	</Style>
	<StyleMap id="marker_cat_'.$tmpcat.'">
    <Pair>
      <key>normal</key>
      <styleUrl>#marker_cat_'.$tmpcat.'_n</styleUrl>
    </Pair>
    <Pair>
      <key>highlight</key>
      <styleUrl>#marker_cat_'.$tmpcat.'_h</styleUrl>
    </Pair>
  </StyleMap>
		';
	
	}

	
		// add filter clauses

		$fltr=$_GET['fltr'];
		$filter_clause='';
		if ($fltr) {
			require_once dirname(__FILE__).'/CL_filter.php';
			$filter=new LeonardoFilter();
			$filter->parseFilterString($fltr);
			// echo "<PRE>";	print_r($filter->filterArray);	echo "</PRE>";	
			$filter_clause=$filter->makeClause();
			
			if ( ! strpos($filter_clause,$waypointsTable)=== false )  {
				$extra_tbl= " LEFT JOIN $waypointsTable ON $flightsTable.takeoffID=$waypointsTable.ID "; 
			}
			
			if ( ! strpos($filter_clause,$pilotsTable)=== false ) {
				$extra_tbl.= " LEFT JOIN $pilotsTable ON 
						($flightsTable.userID=$pilotsTable.pilotID AND 
						$flightsTable.userServerID=$pilotsTable.serverID) "; 
			}			
		}

		 $query="SELECT * FROM $flightsTable $extra_tbl WHERE 
				 firstLat>=$south &&  firstLat<=$north &&  
				 firstLon>=$west && firstLon<=$east $filter_clause
				 ORDER BY  FLIGHT_POINTS DESC LIMIT 100 ";  
		 //echo $query;
		 $res= $db->sql_query($query);
		 if($res <= 0){
			 echo("<H3> Error in query! $query </H3>\n");
			 exit();
		 }

		$i=0;
		$str='';
		while ($row = mysql_fetch_assoc($res)) { 

			$name=getPilotRealName($row["userID"],$row["userServerID"],0,0,0);
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
			
			$flight=new flight();
			$flight->getFlightFromDB($row['ID'],0,$row);
			$extendedInfo=0;
			$lineColor="ff0000";
			$exaggeration=1;
			$lineWidth=2;
			
			$getFlightKML=$flight->getFlightKML()."&c=$lineColor&w=$lineWidth&an=$extendedInfo";
			$desc=$flight->kmlGetDescription($extendedInfo,$getFlightKML,1);
			
			$snippet="<![CDATA[".formatDistance($flight->FLIGHT_KM,1).", "._DURATION.": ".sec2Time($flight->DURATION,1)."]]>";
			
			$str.="<Placemark>
				<name><![CDATA[$location]]></name>
				<styleUrl>#marker_cat_".$row['cat']."</styleUrl>
				<Snippet  maxLines='1'>$snippet</Snippet>
				".$desc."
				<Point>
				<coordinates>".$row['firstLon'].','.$row['firstLat']."</coordinates>
				</Point>
				</Placemark>			
			";
			$i++;
		}		
		$trackNum=$i;
		
		$incWaypoints=1;
		if ($cameraAlt>100000 ) $incWaypoints=0;
		
		if ($incWaypoints) {
			 $query="SELECT * FROM $waypointsTable WHERE 
				 type=1000 AND
				 lat>=$south AND lat<=$north AND 
				 lon<=".(-$west)." AND lon>=".(-$east)." ORDER BY ID";  
			 //echo $query;
			 $res= $db->sql_query($query);
			 if($res <= 0){
				 echo("<H3> Error in query! $query </H3>\n");
				 exit();
			 }
	
			require_once dirname(__FILE__).'/FN_waypoint.php';
			
			$i=0;
			$wpStr='';
			while ($row = mysql_fetch_assoc($res)) { 
				$wpStr.=makeWaypointPlacemark($row['ID'],0,0,0,"#marker_takeoff");		
				$i++;
			}
			$wpNum=$i;
		}
		
		$i=0;
		$photoStr='';
		$query="SELECT * FROM $photosTable WHERE 
			 lat>=$south AND lat<=$north AND 
			 lon>=".($west)." AND lon<=".($east)." ORDER BY ID";  
		 //echo $query;
		 $res= $db->sql_query($query);
		 if($res <= 0){
			 echo("<H3> Error in query! $query </H3>\n");
			 exit();
		 }
		
		require_once dirname(__FILE__).'/CL_flightPhotos.php';
		require_once dirname(__FILE__).'/FN_output.php';
		
		$i=0;
		$photoStr='';
		while ($row = mysql_fetch_assoc($res)) { 
		
			$imgTarget=$moduleRelPath.'/'.flightPhotos::getPath($row['path']).'/'.$row['name'];
			$imgTarget="http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/".$imgTarget;

			
		
			$lineColor="ff0000";		
			$lineWidth=2;			
			$getFlightKML="http://".$_SERVER['SERVER_NAME'].
					getDownloadLink( array('type'=>'kml_trk','flightID'=>$row['flightID']) ).
					"&c=$lineColor&w=$lineWidth&an=0";

			$photoStr.="<Placemark>
		    <name>Photo</name>
			<styleUrl>#marker_photo</styleUrl>
			<Snippet maxLines='0' ></Snippet>
			<description><![CDATA[<a href='$imgTarget'><img src='$imgTarget' width='".$CONF['photos']['mid']['max_width']."' border='0'>			
			</a><BR><BR>
			<strong><a href='$getFlightKML'>Load Track of this Photo</a></strong>
]]></description>
			<Point>
				<altitudeMode>$altitudeMode</altitudeMode>  	    
				<coordinates>".$row['lon'].",".$row['lat'].",".$row['alt']."</coordinates>
			</Point>
			</Placemark>";	
			$i++;
		}
		
		$photoNum=$i;
		
		$xml='<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://www.opengis.net/kml/2.2">
<Folder>  
  <Folder>  
  	'.$styleTrack.'  
    <name>Leonardo Tracks ('.$trackNum.')</name>
	<Snippet maxLines="0"></Snippet>
    <visibility>1</visibility>
    <open>1</open>
    <description><![CDATA[Leonardo Tracks ('.$trackNum.')]]></description>
	'.$str.'
  </Folder>';
  
  if ($incWaypoints) {
	$xml.='<Folder>
     '.$styleTakeoff.'  
    <name>Leonardo Takeoffs ('.$wpNum.')</name>
	<Snippet maxLines="0"></Snippet>
    <visibility>1</visibility>
    <open>1</open>
    <description>Leonardo Takeoffs ('.($wpNum).')</description>
	'.$wpStr.'
  </Folder>';
  }
  
$xml.='<Folder>
    '.$stylePhoto.'  
    <name>Leonardo Photos ('.$photoNum.')</name>
	<Snippet maxLines="0"></Snippet>
    <visibility>1</visibility>
    <open>1</open>
    <description>Leonardo Photos ('.$photoNum.')</description>
	'.$photoStr.'
  </Folder>
</Folder>
</kml>';


		$file_name="Leonardo Tracks Explorer.kml";
	}
		list($browser_agent,$browser_version)=getBrowser();

		if ($browser_agent == 'opera')
			$attachmentMIME = 'application/kml';
		else if ($browser_agent != 'ie' && $browser_agent != 'netscape' && $browser_agent != 'mozilla') 
			$attachmentMIME ="application/octet-stream";

		DEBUG("DL",1,"browser_agent=$browser_agent, browser version=$browser_version<BR>");

		// to debug
		//	DEBUG_END();exit;
		
	if (!headers_sent()) { /// martin jursa 19.6.2008
		header("Pragma: public"); // required
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false); // required for certain browsers 

		header("Content-type: $attachmentMIME");
		//header("Content-Disposition: attachment; filename=\"$kml_file_name\"", true);
		header('Content-Disposition: inline; filename="' . htmlspecialchars($file_name) . '"');
		header("Content-Transfer-Encoding: binary");

		$size = strlen($xml);
		header("Content-length: $size");
	}
		echo $xml;

?>
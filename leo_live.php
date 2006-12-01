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


 	require_once "EXT_config_pre.php";
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

	$op=$_REQUEST['op'];
	if (!$op) $op="ge";	
	$user=$_GET['user'];

	$encoding="iso-8859-1";
	if ($op=="ge") {
		$langEncodings[$currentlang]='iso-8859-1';
		
		$xml= '<?xml version="1.0" encoding="'.$langEncodings[$currentlang].'"?>
<kml xmlns="http://earth.google.com/kml/2.0">
<NetworkLink>
  <name>Leonardo Live for '.$user.'</name>
  <open>1</open>
  <description>User '.$user.' was last seen at</description>
  <Url>
    <href><![CDATA[http://'.$_SERVER['SERVER_NAME'].'/modules/leonardo/leo_live.php?op=pos&user='.$user.']]></href>
    <refreshMode>onInterval</refreshMode>
    <refreshInterval>10</refreshInterval>
    <viewRefreshMode>onStop</viewRefreshMode>
    <viewRefreshTime>10</viewRefreshTime>
  </Url>
</NetworkLink>
</kml>';
		
	} else	if ( $op=="pos" ) {

		$query="SELECT * FROM  leonardo_live_data WHERE username='$user' ORDER BY tm desc LIMIT 10 ";
		 //echo $query;
		 $res= $db->sql_query($query);
		 if($res <= 0){
			 echo("<H3> Error in query! $query </H3>\n");
			 exit();
		 }

		$XML_str="NO DATA - ERROR";
		while  ($row = mysql_fetch_assoc($res)) { 
			$ip	  =$row["ip"];
			$time =$row["time"];
			$username =$row["username"];
			$passwd =$row["passwd"];
			$lat =$row["lat"];
			$lon =$row["lon"];
			$alt =$row["alt"];
			$sog =$row["sog"];
			$cog =$row["cog"];
			

			$thisPoint=new gpsPoint();
			$thisPoint->lat=$lat;
			$thisPoint->lon=$lon;
			
			$timeStr=substr($time,0,4)."-".substr($time,4,2)."-".substr($time,6,2)." ".
			substr($time,8,2).":".substr($time,10,2).":".substr($time,12,2);
			$XML_str="$time  <BR>$alt m, $sog km/h, cog:$cog";
				
			break;
			
		} // end while 
		$name=$user;
		$xml=makeKMLpoint($lat,$lon,$alt,$name,$XML_str);
		
		// echo $XML_str;
		// send_XML($XML_str);
	} else if ($op=="track") {
		$user=$_GET['user'];
		$port=$_GET['port'];
		$query="SELECT * FROM  leonardo_live_data WHERE username='$user' AND port='$port' ORDER BY id ASC";
		 //echo $query;
		 $res= $db->sql_query($query);
		 if($res <= 0){
			 echo("<H3> Error in query! $query </H3>\n");
			 exit();
		 }
		 
		 
		 $iconNum=2;
		 $scale=0.2;

    	$icons = array (1 => array ("root://icons/palette-2.png", 224, 224), 
2 => array ("root://icons/palette-4.png", 0, 160),
3 => array ("root://icons/palette-3.png", 64, 192), 
4 => array ("root://icons/palette-3.png", 96, 192), 
5 => array ("root://icons/palette-3.png", 128, 192) );

		$xml= '<?xml version="1.0" encoding="'.$langEncodings[$currentlang].'"?>
<kml xmlns="http://earth.google.com/kml/2.0">
<Folder>
			  <Style id="markerPoint">
				<IconStyle>
				  <scale>'.$scale.'</scale>
				  <Icon>
					<href>'.$icons[$iconNum][0].'</href>
					<x>'.$icons[$iconNum][1].'</x>
					<y>'.$icons[$iconNum][2].'</y>
					<w>32</w>
					<h>32</h>
				  </Icon>
				</IconStyle>
				<LabelStyle>
					<scale>0.7</scale>
				</LabelStyle>
			  </Style>
';

		$XML_str="NO DATA - ERROR";
		$i=0;
		
		//$xml.=makeKMLtrack("ff0000",1,2,$res) ;
		$last_printed_tm=0;
		$last_printed_timeString=0;
		$last_alt=-999;
		
		while  ($row = mysql_fetch_assoc($res)) { 
			$ip	  =$row["ip"];
			$time =$row["time"];
			$tm=$row['tm'];
			$username =$row["username"];
			$passwd =$row["passwd"];
			$lat =$row["lat"];
			$lon =$row["lon"];
			$alt =$row["alt"];
			$sog =$row["sog"];
			$cog =$row["cog"];
			

			if ($i==0) { 
			
				$xml.= "<name>LeoLive for $user</name>
				<description><![CDATA[($time)]]></description>
				<Folder><name>Time Markers</name>";


				$lineColor="ff0000";
				$lineWidth=2;
				$KMLlineColor="ff".substr($lineColor,4,2).substr($lineColor,2,2).substr($lineColor,0,2);
		
				$i=0;

				$kml_file_contents.=
				"<Placemark >
				  <name>Track Line</name>				  
				  <Style>
					<LineStyle>
					  <color>".$KMLlineColor."</color>
					  <width>$lineWidth</width>
					</LineStyle>
				  </Style>
				";
		
				$kml_file_contents.=
				"<LineString>
				<altitudeMode>absolute</altitudeMode>
				<coordinates>";
		
			}
			
			$dt=$tm - $last_printed_tm;
			if ( ($dt) > 56 ) {  
				
				$thisPoint=new gpsPoint();
				$thisPoint->lat=$lat;
				$thisPoint->lon=$lon;
				if ($last_alt==-999) 
					$vario=0;
				else 
					$vario=sprintf("%0.1f",($alt-$last_alt)/$dt);
					
				$last_printed_tm=$tm;
				$last_alt=$alt;
				
				$timeStr=substr($time,0,4)."-".substr($time,4,2)."-".substr($time,6,2)." ".
				substr($time,8,2).":".substr($time,10,2).":".substr($time,12,2);
				$timeStr=substr($time,11);
				$XML_str="<br>$alt m , $sog km/h<br>1 min average vario : $vario m/sec";
	
				$name=$user;
				
				if ( ( $tm - $last_printed_timeString ) > 60*10-4 ) { // 10 minutes
					$timeStr1=substr($timeStr,0,5);
					$last_printed_timeString=$tm;
				} else {
					$timeStr1="";
				}
				$xml.=makeKMLpoint($lat,$lon,$alt,$timeStr1,$timeStr." ".$XML_str);
			}						


			$kml_file_contents.=$lon.",".$lat.",".$alt." ";
			if($i % 50==0) $kml_file_contents.="\n";
		
			$i++;
		} // end while 
		$kml_file_contents.="</coordinates>\n</LineString>\n</Placemark>";
		$xml.="\n</Folder>$kml_file_contents</Folder></kml>";

	}  else if ($op=="igc") {
		$user=$_GET['user'];
		$port=$_GET['port'];
		$query="SELECT * FROM  leonardo_live_data WHERE username='$user' AND port='$port' ORDER BY id ASC";
		 //echo $query;
		 $res= $db->sql_query($query);
		 if($res <= 0){
			 echo("<H3> Error in query! $query </H3>\n");
			 exit();
		 }
		$igc= '';

		$i=0;
		while  ($row = mysql_fetch_assoc($res)) { 
			$ip	  =$row["ip"];
			$time =$row["time"];
			$tm=$row["tm"];
			$username =$row["username"];
			$passwd =$row["passwd"];
			$lat =$row["lat"];
			$lon =$row["lon"];
			$alt =$row["alt"];
			$sog =$row["sog"];
			$cog =$row["cog"];
			

			if ($i==0) {
				$dateStr=substr($time,8,2).substr($time,5,2).substr($time,2,2);
				$igc.=
				"HFDTE$dateStr\r\n".
				"HFPLTPilot: $user \r\n".
				"HFTZOTimezone:2\r\n".
				"HFSITSite:\r\n".
				"HPGTYGliderType:\r\n".
				"HPGIDGliderID:\r\n".
				"HFDTM100DATUM:WGS-1984\r\n".
				"HFCIDCOMPETITIONID:\r\n".
				"HFCCLCOMPETITIONCLASS:\r\n".
				"HFFXA100\r\n".
				"HFRHWHARDWAREVERSION:1.00\r\n".
				"HFFTYFRTYPE:BT GPS\r\n";
				//"LeoLive for $user (time)<br>\n";
			}

			$thisPoint=new gpsPoint();
			$thisPoint->lat=$lat;
			$thisPoint->lon=-$lon;

			$thisPoint->gpsAlt=$alt;
			$thisPoint->gpsTime=$tm %(3600*24);

			$timeStr=substr($time,0,4)."-".substr($time,4,2)."-".substr($time,6,2)." ".
			substr($time,8,2).":".substr($time,10,2).":".substr($time,12,2);
			$timeStr=substr($time,11);
			$igc.=$thisPoint->to_IGC_Record()."\r\n";
			// $igc.="* $timeStr $alt m, $sog km/h <br>\n";

			$name=$user;
			$i++;
		} // end while

		$file_name="$user $time.igc";
		header("Pragma: public"); // required
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false); // required for certain browsers 

		$attachmentMIME ='application/octet-stream';
		header("Content-type: $attachmentMIME");
		//header("Content-Disposition: attachment; filename=\"$kml_file_name\"", true);
		header('Content-Disposition: inline; filename="' . htmlspecialchars($file_name) . '"');
		header("Content-Transfer-Encoding: binary");

		$size = strlen($igc);
		header("Content-length: $size");
		echo $igc;
 

		exit;
	}
	
		list($browser_agent,$browser_version)=getBrowser();

		if ($browser_agent == 'opera') $attachmentMIME = 'application/kml';
		else if ($browser_agent == 'ie'  || $browser_agent == 'netscape'   || $browser_agent == 'mozilla'  ) 
			$attachmentMIME ="application/vnd.google-earth.kml+xml";
		else $attachmentMIME ='application/octet-stream';

		DEBUG("DL",1,"browser_agent=$browser_agent, browser version=$browser_version<BR>");

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
		echo $xml;


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

	function makeKMLpoint($lat,$lon,$alt,$name="",$desc="") {

      $res = 
"<Placemark>".
"  <name><![CDATA[$name]]></name>".
"  <description><![CDATA[$desc]]></description>".
"  <styleUrl>#markerPoint</styleUrl>
  <Point> ".
//"		 <extrude>1</extrude>".
"      <tessellate>1</tessellate>".
//"		      <altitudeMode>relativeToGround</altitudeMode>".
"      <altitudeMode>absolute</altitudeMode>".
"      <coordinates>". $lon.",".$lat.",$alt</coordinates>
  </Point>
</Placemark>";
	  return $res;
	}
	
	
	function makeKMLtrack($lineColor="ff0000",$exaggeration=1,$lineWidth=2,$res) {
		global $module_name, $flightsAbsPath,$flightsWebPath, $takeoffRadious,$landingRadious;
		global $moduleRelPath,$baseInstallationPath;
		global $langEncodings,$currentlang;

		//if (file_exists($this->getKMLFilename())) return;
		$KMLlineColor="ff".substr($lineColor,4,2).substr($lineColor,2,2).substr($lineColor,0,2);
		
		$i=0;

		$kml_file_contents.="<Placemark >\n<name>Leo Live </name>";

		$kml_file_contents.=
		"<Style>
			<LineStyle>
			  <color>".$KMLlineColor."</color>
			  <width>$lineWidth</width>
			</LineStyle>
		  </Style>
		";

		$kml_file_contents.=
		"<LineString>
		<altitudeMode>absolute</altitudeMode>
		<coordinates>";

		while  ($row = mysql_fetch_assoc($res)) { 
			$ip	  =$row["ip"];
			$time =$row["time"];
			$username =$row["username"];
			$passwd =$row["passwd"];
			$lat =$row["lat"];
			$lon =$row["lon"];
			$alt =$row["alt"];
			$sog =$row["sog"];
			$cog =$row["cog"];
			

			$kml_file_contents.=$lon.",".$lat.",".$alt." ";
			$i++;
			if($i % 50==0) $kml_file_contents.="\n";
		}

		$kml_file_contents.="</coordinates>\n</LineString>";
		$kml_file_contents.="</Placemark>";
		return 		$kml_file_contents;
	}
?>
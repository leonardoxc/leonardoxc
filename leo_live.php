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

	function in_bounds($lat,$lon, $max_lat,$max_lon,$min_lat,$min_lon) {
		$lon=-$lon;
		if ( $lat<=$max_lat && $lat >=$min_lat && $lon<=$max_lon && $lon>=$min_lon ) return 1;
		return 0;
	}

	$colors=array("FF0000","00FF00","0000FF","FFFF00","FF00FF","00FFFF","EF8435","34A7F0","33F1A3","9EF133","808080");

	$op=$_REQUEST['op'];
	if (!$op) $op="ge";	
	$user=$_GET['user'];
	$taskID=$_GET['taskID']+0;
	$color=$_GET['color'];
	if (!$color) $color=$colors[0];

	$encoding="iso-8859-1";


	if ($taskID) {
		$live_waypointsTable='leonardo_live_waypoints';
		require_once dirname(__FILE__).'/leo_live_CL_task.php';

		$task=new task($taskID);
		$taskKML=$task->getTaskKML();
		$task->computeMapBoundaries();

		// add a small margin
		$task->max_lat+=0.2;
		$task->max_lon+=0.2;
		$task->min_lat-=0.2;
		$task->min_lon-=0.2;

		$xml= '<?xml version="1.0" encoding="UTF-8"?>
		<kml xmlns="http://earth.google.com/kml/2.1">
		<Folder>
		<open>1</open>
		<name>Live Task '.date("d/m/Y").'</name>
';
		$xml.=$taskKML;
		//$xml.="</Folder>\n";

		// get only live tracks from last 10 hrs
		$last_tm_limit=time()-3600*10;		
		$query="SELECT lat,lon,username,max(tm) as last_tm FROM  leonardo_live_data WHERE tm > $last_tm_limit GROUP BY username ORDER BY last_tm desc";
		//echo $query;
		$res= $db->sql_query($query);
		if($res <= 0){
			echo("<H3> Error in query! $query </H3>\n");
			exit();
		}

		$j=0;
		$xml.="<Folder>\n";
		$xml.="<open>1</open>\n";
		$xml.="<name>Live Tracks</name>\n";
		while  ($row = mysql_fetch_assoc($res)) { 
			if (! in_bounds($row['lat'],$row['lon'], $task->max_lat,$task->max_lon,$task->min_lat,$task->min_lon)	) continue;

			$username =$row["username"];
			list($lat,$lon,$time,$tm,$alt,$sog,$cog,$XML_str,$port)=getLastPoint($username);
			$color=$colors[$j%count($colors)];
			$xml.='<NetworkLink>
		  <name>'.$username.'</name>
		  <open>0</open>
		  <Url>
			<href><![CDATA[http://'.$_SERVER['SERVER_NAME'].'/modules/leonardo/leo_live.php?op=ge&user='.$username.'&port='.$port.'&color='.$color.']]></href>
		  </Url>
		</NetworkLink>
		';
			$j++;
		}
		$xml.="</Folder>\n";

		$xml.='</Folder>
		</kml>';

	} else if ($op=="ge") {
		$langEncodings[$currentlang]='iso-8859-1';
		$port=$_GET['port'];		

		$xml= '<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://earth.google.com/kml/2.1">
<Folder>
<open>0</open>
 <name>Leonardo Live for '.$user.'</name>
<NetworkLink>
  <name>Live Data</name>
  <open>1</open>
  <Url>
    <href><![CDATA[http://'.$_SERVER['SERVER_NAME'].'/modules/leonardo/leo_live.php?op=pos&user='.$user.'&color='.$color.']]></href>
  </Url>
</NetworkLink>';

if (!$port) list($lat,$lon,$time,$tm,$alt,$sog,$cog,$XML_str,$port)=getLastPoint($user);

$xml.= '
<NetworkLink>
  <name>Tracklog</name>
  <open>0</open>
  <Url>
    <href><![CDATA[http://'.$_SERVER['SERVER_NAME'].'/modules/leonardo/leo_live.php?op=track&user='.$user.'&port='.$port.'&points=0&color='.$color.']]></href>
  </Url>
</NetworkLink>';

$xml.='

<NetworkLink>
  <name>Update Position *</name>
  <open>0</open>
  <Link>
    <href><![CDATA[http://'.$_SERVER['SERVER_NAME'].'/modules/leonardo/leo_live.php?op=update&user='.$user.'&color='.$color.']]></href>
    <refreshMode>onInterval</refreshMode>
    <refreshInterval>10</refreshInterval>
  </Link>
</NetworkLink>
</Folder>
</kml>';
		
	} else	if ( $op=="pos" ) {
		$XML_str="NO DATA - ERROR";

		list($lat,$lon,$time,$tm,$alt,$sog,$cog,$XML_str,$portUsed)=getLastPoint($user);
		if ($time) {
			// $timeStr=substr($time,0,4)."-".substr($time,4,2)."-".substr($time,6,2)." ".substr($time,8,2).":".substr($time,10,2).":".substr($time,12,2);
			$XML_str="$time  <BR>$alt m, $sog km/h, cog:$cog";
		}			
		$name=$user;

		$xml = '<?xml version="1.0" encoding="UTF-8"?>';
		$xml.= '<kml xmlns="http://earth.google.com/kml/2.1">';
		
//		$xml.='<NetworkLinkControl> ';
//		$xml.= '  <cookie>'.$cookieStr.'</cookie>';
//		$xml.= '  <linkName>Track Animation start</linkName>';
//		$xml.='</NetworkLinkControl> ';	

		$xml.= '<Folder>';
		$xml.= '<name>Position</name>';
		$xml.= '<open>1</open>';
		
		
		//$xml.= '<Folder id="Position">';
		//$xml.= '<open>1</open>';
		//$xml.= '<name>Current Position</name>';
		$xml.=makeKMLpoint($lat,$lon,$alt,$name,$XML_str);
		//$xml.= '</Folder>';

		$xml.= '<Folder id="trackpoints">';
		$xml.= '<name>Track points</name>';	
		$xml.= makeMarkerXML(2,0.2,$color,"livePointStyle");
		$xml.= '</Folder>';
		
		$xml.= '<Folder id="trackline">';
		$xml.= '<name>Track line</name>';		
		$xml.= makeLineStyleXML($color);
		$xml.= '</Folder>';

		$xml.= '</Folder>';			
		$xml.='</kml>';

		
		
		// echo $XML_str;
		// send_XML($XML_str);
	} else	if ( $op=="update" ) {
		list($lat,$lon,$time,$tm1,$alt,$sog,$cog,$XML_str,$portUsed)=getLastPoint($user);
		list($lat2,$lon2,$time2,$tm2,$alt2,$sog2,$cog2,$XML_str2,$portUsed2)=getLastPoint($user,1);// previous point
		

		$last_tm=$_GET['tm'];
		$cookieStr="tm=$tm1";

		if ($last_tm==$tm1) $sametm=1;
		else $sametm=0;

		$dt=$tm1-$tm2;
		$gl_ratio="N/A";
		if ($dt) {
			$vario=sprintf("%.1f",($alt-$alt2)/$dt);
			if ($vario>=0) $vimg="<img align='middle' src='http://".$_SERVER['SERVER_NAME']."/modules/leonardo/live/icon_up.gif'>";
			else $vimg="<img src='http://".$_SERVER['SERVER_NAME']."/modules/leonardo/live/icon_down.gif'>";
			//km/h -> m/sec
			if ($vario<0) $gl_ratio=sprintf("%.1f", ($sog*1000/3600) / -$vario);

		} else $vario=0;

		$langEncodings[$currentlang]='iso-8859-1';
		$timeStr=substr($time,11);
		$infoStr="[ $alt m, $vario m/sec ]<BR>[ $sog km/h, cog:$cog, GR:$gl_ratio ]";
		$desc="$timeStr $infoStr<BR>";

		$xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
		$xml.= '<kml xmlns="http://earth.google.com/kml/2.1">'."\n";

		$xml.='<NetworkLinkControl> '."\n";
		$xml.= '  <cookie>'.$cookieStr.'</cookie>';
		$xml.= '  <linkName>Track Animation</linkName>'."\n";
$xml.='  <Update> 
	<targetHref><![CDATA[http://'.$_SERVER['SERVER_NAME'].'/modules/leonardo/leo_live.php?op=pos&user='.$user.'&color='.$color.']]></targetHref> 
	<Change> 
	  <Placemark targetId="myplacemark">
		  <description><![CDATA['.$desc.']]></description>".
	  </Placemark>
	  <Point targetId="mypoint"> 
		<coordinates>'.$lon.','.$lat.','.$alt.'</coordinates>
	  </Point> 
	</Change> 
</Update> 
';

if (!$sametm){
$xml.="\n<Update> 
<targetHref><![CDATA[http://".$_SERVER['SERVER_NAME']."/modules/leonardo/leo_live.php?op=pos&user=$user&color=$color]]></targetHref>
<Create>
	<Folder targetId='trackpoints'>
		<Placemark id='p_".$time."'> 
			<styleUrl>#livePointStyle</styleUrl>
			<description><![CDATA[<b>$user</b>: $timeStr<BR>$infoStr]]></description>
			<name></name>
			<Point>
				<altitudeMode>absolute</altitudeMode>
				<coordinates>$lon,$lat,$alt</coordinates> 
			</Point>
		</Placemark>
	</Folder> 
</Create> 

";

$xml.="\n
<Create>
    <Folder  targetId='trackline'>
	 	<Placemark id='l_".$time."'> 
			<styleUrl>#trackLine</styleUrl>
			<name></name>
			<LineString >	    
				<altitudeMode>absolute</altitudeMode>				
				<coordinates>
					$lon2,$lat2,$alt2
					$lon,$lat,$alt					
				</coordinates>
			</LineString> 
	  </Placemark>
	</Folder> 
</Create> 
</Update>
";
}		
		$xml.='</NetworkLinkControl> ';				
		$xml.='</kml>';

	} else if ($op=="track") {
		$user=$_GET['user'];
		$port=$_GET['port'];
		$showPoints=$_GET['points'];

		$lineColor=$_GET['color'];
		if (!$lineColor) $lineColor="ff0000";

		$query="SELECT * FROM  leonardo_live_data WHERE username='$user' AND port='$port' ORDER BY id ASC";
		 //echo $query;
		 $res= $db->sql_query($query);
		 if($res <= 0){
			 echo("<H3> Error in query! $query </H3>\n");
			 exit();
		 }
		 
		 $iconNum=2;
		 $scale=0.2;

		$xml= '<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://earth.google.com/kml/2.0">
<Folder>
';
		$xml.=makeMarkerXML($iconNum, $scale,$lineColor,"markerPoint");

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
				if ($showPoints) $xml.=makeKMLpoint($lat,$lon,$alt,$timeStr1,$timeStr." ".$XML_str);
			}						


			$kml_file_contents.=$lon.",".$lat.",".$alt." ";
			if($i % 50==0) $kml_file_contents.="\n";
		
			$i++;
		} // end while 
		$kml_file_contents.="</coordinates>\n</LineString>\n</Placemark>";
		$xml.="\n</Folder>$kml_file_contents</Folder></kml>";

	}  else if ($op=="submit") {
		// get some basic info
		$username=$_GET['user'];
		$port=$_GET['port'];
		$query="SELECT * FROM  leonardo_live_data WHERE username='$username' AND port='$port' ORDER BY tm ASC LIMIT 1";
		//echo $query;
		$res= $db->sql_query($query);
		if($res <= 0){
			 echo("<H3> Error in query! $query </H3>\n");
			 return 0;
		}

		$serverURL="http://pgforum.thenet.gr/modules/leonardo/op.php";
		$serverURL="http://pgforum.home/modules/leonardo/op.php";
		if ( $row = mysql_fetch_assoc($res) ) {
			$trackURL='http://'.$_SERVER['SERVER_NAME'].'/modules/leonardo/leo_live.php';
			$tm=$row["tm"];
			$passwd =$row["passwd"];

			$igcURL=htmlspecialchars( "$trackURL?op=igc&user=$username&port=$port");
			$igcFilename= htmlspecialchars(date("Y-m-d H-i-s",$tm).".igc" );
	
			$private=0;
			$cat=-1;
			$linkURL=0;
			$comments=0;
			$glider=0;
			submitFlightToServer($serverURL, $username, $passwd, $igcURL, $igcFilename, $private, $cat, $linkURL, $comments, $glider);
		}	else {
			echo "Cannot get DATA for user $username<br>";		
		}
		exit;

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

$file_name="kml.kml";
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
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
		echo $XML_str;	
	}

	function makeKMLpoint($lat,$lon,$alt,$name="",$desc="") {

      $res = 
"<Placemark id='myplacemark'>".
"  <name><![CDATA[$name]]></name>".
"  <description><![CDATA[$desc]]></description>".
"  
	<Style id='sn_icon_cat_1'>
		<IconStyle>
			<scale>0.5</scale>
			<Icon>
				<href>http://pgforum.thenet.gr/modules/leonardo/img/icon_cat_1.png</href>
			</Icon>
		</IconStyle>
	</Style>
	<styleUrl>#sn_icon_cat_1</styleUrl>
	<Point id='mypoint'> ".
"		 <extrude>1</extrude>".
"      <tessellate>1</tessellate>".
//"		      <altitudeMode>relativeToGround</altitudeMode>".
"      <altitudeMode>absolute</altitudeMode>".
"      <coordinates>". $lon.",".$lat.",$alt</coordinates>
  </Point>
</Placemark>";
	  return $res;
	}
	
	/*
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
*/
function getLastPoint($user,$offset=0){
	global $db;

	if ($offset) $limitStr="LIMIT $offset,1";
	else $limitStr="LIMIT 1";

	$query="SELECT * FROM  leonardo_live_data WHERE username='$user' ORDER BY tm desc $limitStr ";
	 //echo $query;
	 $res= $db->sql_query($query);
	 if($res <= 0){
		 echo("<H3> Error in query! $query </H3>\n");
		 exit();
	 }

	$XML_str="NO DATA - ERROR";
	if  ($row = mysql_fetch_assoc($res)) { 
		$ip	  =$row["ip"];
		$time =$row["time"];
		$tm =$row["tm"];
		$username =$row["username"];
		$passwd =$row["passwd"];
		$lat =$row["lat"];
		$lon =$row["lon"];
		$alt =$row["alt"];
		$sog =$row["sog"];
		$cog =$row["cog"];		
		$port=$row["port"];		

		/*
		$thisPoint=new gpsPoint();
		$thisPoint->lat=$lat;
		$thisPoint->lon=$lon;
		*/
		//$timeStr=substr($time,0,4)."-".substr($time,4,2)."-".substr($time,6,2)." ".substr($time,8,2).":".substr($time,10,2).":".substr($time,12,2);

		$XML_str="$time  <BR>$alt m, $sog km/h, cog:$cog";
		return array($lat,$lon,$time,$tm,$alt,$sog,$cog,$XML_str,$port);	
	} else {
		return array(0,0,0,0,0,0,0,"",0);	
	}
}

function makeMarkerXML($iconNum=2,$scale=0.2,$color="FF0000",$styleName="markerPoint") {
    	$icons = array (1 => array ("root://icons/palette-2.png", 224, 224), 
						2 => array ("root://icons/palette-4.png", 0, 160),
						3 => array ("root://icons/palette-3.png", 64, 192), 
						4 => array ("root://icons/palette-3.png", 96, 192), 
						5 => array ("root://icons/palette-3.png", 128, 192) );

	$KMLlineColor="ff".substr($color,4,2).substr($color,2,2).substr($color,0,2);		
	$xml='
<Style id="'.$styleName.'">
		<IconStyle>
		  <scale>'.$scale.'</scale>
		  <color>'.$KMLlineColor.'</color>
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
	return $xml;
}

function makeLineStyleXML($lineColor="FF0000",$lineWidth=3) {
	$KMLlineColor="ff".substr($lineColor,4,2).substr($lineColor,2,2).substr($lineColor,0,2);		
	$xml="
		<Style id='trackLine'>
			<LineStyle>
			  <color>".$KMLlineColor."</color>
			  <width>$lineWidth</width>
			</LineStyle>
		  </Style>
	";
	return $xml;
}

?>
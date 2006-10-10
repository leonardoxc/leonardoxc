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

	$encoding="iso-8859-1";
	if ($op=="ge") {
		$langEncodings[$currentlang]='iso-8859-1';
		
		$xml= '<?xml version="1.0" encoding="'.$langEncodings[$currentlang].'"?>
<kml xmlns="http://earth.google.com/kml/2.0">
<Folder>
<NetworkLink>
  <name>Leonrdo Live Tracking </name>
  <open>1</open>
  <description>Live tracking of </description>
  <Url>
    <href>http://'.$_SERVER['SERVER_NAME'].'/modules/leonardo/leo_live.php?op=pos</href>
    <refreshMode>onInterval</refreshMode>
    <refreshInterval>10</refreshInterval>
    <viewRefreshMode>onStop</viewRefreshMode>
    <viewRefreshTime>10</viewRefreshTime>
  </Url>
</NetworkLink>
</Folder>
</kml>';
		
	} else	if ( $op=="pos" ) {
/*		$lat=$_GET['lat']+0;
		$lon=-$_GET['lon']+0;

		$firstPoint=new gpsPoint();
		$firstPoint->lat=$lat;
		$firstPoint->lon=$lon;
*/
		 $query="SELECT * FROM  leonardo_live_tmp ORDER BY time desc LIMIT 10 ";
		 //echo $query;
		 $res= $db->sql_query($query);
		 if($res <= 0){
			 echo("<H3> Error in query! $query </H3>\n");
			 exit();
		 }

		$XML_str="NO DATA - ERROR";
		while  ($row = mysql_fetch_assoc($res)) { 
			$time  =$row["time"];
			$phone =$row["phone"];
			$msg   =$row["msg"];
			// !P03384852N<<091083W<<214<<0<<169
			if ( preg_match("/\!P03(.+)<<(.+)<<(.+)<<(.+)<<(.+)/",$msg,$matches))  {
				$lat=$matches[1];
				$lon=$matches[2];
				$alt=$matches[3];
				$speed=$matches[4];
				$cog=$matches[5];

				$d=substr($lat,0,2);
				$m=substr($lat,2,2);
				$s=substr($lat,4,2);
				$orientation=strtolower(substr($lat,6,1));

				$lat=$d+($m+$s/100)/60 ;
				if ($orientation=='s') $lat=-$lat;

				
				// now lon (West/East)
				$d=substr($lon,0,2);
				$m=substr($lon,2,2);
				$s=substr($lon,4,2);
				$orientation=strtolower(substr($lon,6,1));

				// $lon=$d+$m/100;//  + $s/60000
				$lon=$d+($m+$s/100)/60;
				if ($orientation=='w') $lon=-$lon;

				$thisPoint=new gpsPoint();
				$thisPoint->lat=$lat;
				$thisPoint->lon=$lon;
				
				$timeStr=substr($time,0,4)."-".substr($time,4,2)."-".substr($time,6,2)." ".
				substr($time,8,2).":".substr($time,10,2).":".substr($time,12,2);
				$XML_str="$time  :: $phone :: $msg -> $lat , $lon , $alt, $speed , $cog";
				
				break;
			}
			
		} // end while 
		$xml=makeKMLpoint($lat,$lon,"Last known Position $time");
		
		// echo $XML_str;
		// send_XML($XML_str);
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

	function makeKMLpoint($lat,$lon,$desc="") {

    	$icons = array (1 => array ("root://icons/palette-3.png", 0, 192), 
2 => array ("root://icons/palette-3.png", 32, 192), 3 => array ("root://icons/palette-3.png", 64, 192), 
4 => array ("root://icons/palette-3.png", 96, 192), 5 => array ("root://icons/palette-3.png", 128, 192) );

		$num=1;

      $res = "
      <Placemark>
      		 <name>".$desc."</name>".
      		/* "<Style>
      		  <IconStyle>
      			<scale>0.4</scale>
      			<Icon>
      			  <href>".$this->icons[$$num +1][0]."</href>
      			  <x>".$this->icons[$num +1][1]."</x>
      			  <y>".$this->icons[$num +1][2]."</y>
      			  <w>32</w>
      			  <h>32</h>
      			</Icon>
      		  </IconStyle>
			 
      		</Style>".
      	*/	
       "<Point>
			 <extrude>1</extrude>
		      <tessellate>1</tessellate>
		      <altitudeMode>relativeToGround</altitudeMode>
          <coordinates>". $lon.",".$lat.",0</coordinates>
        </Point>
      </Placemark>";
	  return $res;
	}
?>
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
	setDEBUGfromGET();

	$op=$_REQUEST['op'];
	if (!$op) $op="live";	


	if (!in_array($op,array("live")) ) return;

	$encoding="iso-8859-1";

	if ($op=="live") {
		 $query="SELECT username,lat,lon,alt,sog,cog, max(tm) as last_tm 
			FROM  leonardo_live_data  GROUP BY username ORDER BY last_tm desc";
	
		// echo $query;
		 $res= $db->sql_query($query);
		 if($res <= 0){
			 echo("<H3> Error in query! </H3>\n");
			 exit();
		 }
$RSS_str="<?xml version=\"1.0\" encoding=\"$encoding\" ?>
<rss version=\"0.92\">
<channel>
	<docs>http://pgforum.thenet.gr</docs>
	<title>Leo Live at ".$_SERVER['SERVER_NAME']."</title>
	<link>http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/modules/$module_name/leo_live_list.php</link>
	<language>el</language>
	<description>Leo Live at ".$_SERVER['SERVER_NAME']."</description>
	<managingEditor>".$CONF_admin_email."</managingEditor>
	<webMaster>".$CONF_admin_email."</webMaster>
	<lastBuildDate>". gmdate('D, d M Y H:i:s', time()) . " GMT</lastBuildDate>
<!-- BEGIN post_item -->
";

	while ($row = mysql_fetch_assoc($res)) { 
		$tm=$row['last_tm'];
		if (time()-$tm >= 900 ) { // last point was more than 15 mins
			continue;
		} 

		$ip	  =$row["ip"];
		$time =$row["time"];
		$username =$row["username"];
		$lat =$row["lat"];
		$lon =$row["lon"];
		$alt =$row["alt"];
		$sog =$row["sog"];
		$cog =$row["cog"];
		
		
		$last_time=date("d-m-Y H:i:s",$tm);
		$cogStr=getCogDescr($cog);
	
		$thisPoint=new gpsPoint();
		$thisPoint->lat=$lat;
		$thisPoint->lon=$lon;
		
		$timeStr=substr($time,0,4)."-".substr($time,4,2)."-".substr($time,6,2)." ".
		substr($time,8,2).":".substr($time,10,2).":".substr($time,12,2);
		$XML_str="$time  :: $alt m, $sog km/h, cog:$cog";


		$trackURL='http://'.$_SERVER['SERVER_NAME'].'/modules/leonardo/leo_live.php';

		$title="User $username is LIVE :: $last_time";
		$link=htmlspecialchars ("http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/modules/$module_name/leo_live_list.php");

$desc="Pilot:  $username".
"<br>Date - Time:   $last_time <br><a title='Click here to LIVE track this user' href='$trackURL?user=$username'>Click here to LIVE track this user</a>" ;

$desc=htmlspecialchars ($desc);

$RSS_str.="<item>
<title>$title</title>
<link>$link</link>
<description>
$desc
</description>
</item>
";
		}

		$RSS_str.="<!-- END post_item -->
		</channel>
		</rss>
		";

		if (!empty($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Apache/2'))
		{
			header ('Cache-Control: no-cache, pre-check=0, post-check=0, max-age=0');
		}
		else
		{
			header ('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
		}
		header ('Expires: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
		header ('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header ('Content-Type: text/xml');
		echo $RSS_str;
	}

function getCogDescr($cog){
	$dirs=array("N","NNE","NE","ENE","E","ESE","SE","SSE","S","SSW","SW","WSW","W","WNW","NW","NNW","N");
	$cog=$cog%360;
	$c=($cog-11.25)/22.5;
	$i=floor($c)+1;
	if ($i<0) $i=0;
	return $dirs[$i];
}

?>
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
	require_once "CL_server.php";

	setDEBUGfromGET();

	// the requesting server must authenticate first

	$op=makeSane($_REQUEST['op']);
	$type		= $_GET['type']+0;
	$startID 	= $_GET['startID']+0;
	$count 	 	= $_GET['c']+0;	

	$clientID	= makeSane($_GET['clientID'],1);	
	$clientPass	= makeSane($_GET['clientPass'],0);

	if ($count) $limit="LIMIT $count";
	else $limit="";

	$where_clause='';
	if ($type) $where_clause=" AND ItemType=$type ";


	if (!$op) $op="latest";	
	if (!in_array($op,array("latest")) ) return;

	$encoding="utf-8";
	$RSS_str="<?xml version=\"1.0\" encoding=\"$encoding\" ?>\n<log>";
	// authentication stuff
	// the client must be in the leonardo_servers table and the password he provided must match the serverPass field we have for him.
	if (!Server::checkServerPass($clientID,$clientPass)) {
		$RSS_str="<?xml version=\"1.0\" encoding=\"$encoding\" ?>\n<log>";
		$op='error';
		$RSS_str.="<error>Not authorized</error>\n";
	}
	
	

	if ($op=="latest") {
		
		 $query="SELECT * FROM $logTable  WHERE  transactionID>=$startID  AND result=1 $where_clause ORDER BY transactionID $limit";
		 // echo $query;
		 $res= $db->sql_query($query);
		 if($res <= 0){
			 echo("<H3> Error in query! </H3>\n");
			 exit();
		 }
		

		while ($row = mysql_fetch_assoc($res)) { 

			$desc=htmlspecialchars ($desc);

			$actionTime=$row['actionTime']-date('Z');
			$actionTimeStr=tm2fulldate($actionTime);

			$RSS_str.="<item>
<transactionID>".sprintf("%020d",$row['transactionID'])."</transactionID>			
<actionTimeUTC>".$actionTimeStr."</actionTimeUTC>
<serverUTCoffset>".date('Z')."</serverUTCoffset>
<type>".$row['ItemType']."</type>
<id>".$row['ItemID']."</id>
<serverId>".$row['ServerItemID']."</serverId>
<action>".$row['ActionID']."</action>
<userID>".$row['userID']."</userID>

<ActionXML>".$row['ActionXML']."</ActionXML>
</item>\n";
		}
		
		//$RSS_str=htmlspecialchars($RSS_str);

		//$NewEncoding = new ConvertCharset;
		//$FromCharset=$langEncodings[$currentlang];
		//$RSS_str = $NewEncoding->Convert($RSS_str, $FromCharset, "utf-8", $Entities);
	}

	$RSS_str.="</log>\n";
	if (!empty($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Apache/2'))	{
		header ('Cache-Control: no-cache, pre-check=0, post-check=0, max-age=0');
	} else	{
		header ('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
	}
	header ('Expires: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
	header ('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header ('Content-Type: text/xml');
	echo $RSS_str;

?>
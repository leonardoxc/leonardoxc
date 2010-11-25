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
// $Id: rss.php,v 1.21 2010/09/09 12:46:40 manolis E                                                                 
//
//************************************************************************

	if (!defined("IN_RSS") ) exit;

		$flightID = $_GET['flightID']+0;
		if ($flightID) $flightWhereClause=" AND $commentsTable.flightID=$flightID ";
		else $flightWhereClause='';
		
		$query="SELECT $commentsTable.* 
		 		FROM $commentsTable , $flightsTable
				WHERE $commentsTable.flightID = $flightsTable.ID
						AND $flightsTable.private=0
				$flightWhereClause
				ORDER BY $commentsTable.dateAdded DESC LIMIT $count";
		// echo $query;
		$res= $db->sql_query($query);
		if ( $_GET['debug'] ) exit($query);
		if($res <= 0){
			echo("<H3> Error in query! </H3>\n");
			exit();
		}
		
$encoding="utf-8";

$RSS_str="<?xml version=\"1.0\" encoding=\"$encoding\" ?>
<rss version=\"0.92\">
<channel>
	<docs>http://www.leonardoxc.net</docs>
	<title>Leonardo at ".$_SERVER['SERVER_NAME']." :: Latest comments</title>
	<link>http://".$_SERVER['SERVER_NAME'].
	str_replace("&","&amp;",
		getLeonardoLink(array('op'=>'list_flights',
						'year'=>'0','month'=>'0','pilotID'=>'0','takeoffID'=>'0',
						'xctype'=>'all','class'=>'all',
						'country'=>'0','cat'=>'0','clubID'=>'0','brandID'=>'0','nacclubid'=>'0','nacid'=>'0') )
	)						
	."</link>
	<language>el</language>
	<description>Leonardo at ".$_SERVER['SERVER_NAME']." :: Latest comments</description>
	<managingEditor>".$CONF_admin_email."</managingEditor>
	<webMaster>".$CONF_admin_email."</webMaster>
	<lastBuildDate>". gmdate('D, d M Y H:i:s', time()) . " GMT</lastBuildDate>
<!-- BEGIN post_item -->
";
	$pilotNames=array();

	while ($row = mysql_fetch_assoc($res)) { 
		if (!$row['userID'] ) {		
			$name=$row['guestName'];
		} else {
			$name=$pilotNames[$row["userID"]][$row["userServerID"]];
		 	if (!$name) {
		 		$name=getPilotRealName($row["userID"],$row["userServerID"],0,0,0);
		 		$pilotNames[$row["userID"]][$row["userServerID"]]=$name;
			}
	 	}	 
	 
		$link=htmlspecialchars ("http://".$_SERVER['SERVER_NAME'].
				getLeonardoLink(array('op'=>'show_flight','flightID'=>$row['flightID'])) );

	
		$RSS_str.="<item>
<title><![CDATA[$name on flight ".$row['flightID']."]]></title>
<guid isPermaLink=\"false\">".$row['commentID']."</guid>
<pubDate>". gmdate('D, d M Y H:i:s', strtotime($row['dateUpdated']) ) . " GMT</pubDate>
<link>$link</link>
<description><![CDATA[". $row['text']."]]></description>
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




?>
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
// $Id: sync_new.php,v 1.11 2012/01/16 07:21:23 manolis Exp $                                                                 
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
require_once "CL_server.php";

setDEBUGfromGET();

// the requesting server must authenticate first

$op=makeSane($_REQUEST['op']);
$type		= $_GET['type']+0;
$startID 	= $_GET['startID']+0;
$count 	 	= $_GET['c']+0;	

if ($count) $limit="LIMIT $count";
else $limit="";


$format		= makeSane($_GET['format'],0);	
if ( ! $format	) $format=$CONF['sync']['protocol']['format'];
$format=strtoupper($format);

$clientID	= makeSane($_GET['clientID'],1);	
$clientPass	= makeSane($_GET['clientPass'],0);

// authentication stuff
// the client must be in the leonardo_servers table and the password
//  he provided must match the serverPass field we have for him.
if ( !Server::checkServerPass($clientID,$clientPass)) {
	$op='error';
	if ($format=='XML') {
		$RSS_str="<?xml version=\"1.0\" encoding=\"$encoding\" ?>\n<log>";
		$RSS_str.="<error>Not authorized $clientID,$clientPass </error>\n";
	} else if ($format=='JSON') {
		$RSS_str='{ "error": "Not authorized '.$clientID.','.$clientPass.'" }';
	}
}
$where_clause='';

// check which servers to give / dont give 

$dont_give_servers=$CONF['servers']['list'][$clientID]['dont_give_servers'];
if ( is_array($dont_give_servers) ) {
	if (count($dont_give_servers) >0 ){
		replaceCurrentServerInArray($dont_give_servers);
		$where_clause.=" AND serverID NOT IN ( ";	
		foreach($dont_give_servers as $tmpServerID) {
			$where_clause.=$tmpServerID.', ';
		}
		$where_clause.=$clientID .' )';
	}	
}

$give_only_servers=$CONF['servers']['list'][$clientID]['give_only_servers'];
if ( is_array($give_only_servers) ) {
	if (count($give_only_servers) >0 ){
		replaceCurrentServerInArray($give_only_servers);
		$where_clause.=" AND serverID IN ( ";
		foreach($give_only_servers as $tmpServerID) {
			$where_clause.=$tmpServerID.', ';
		}
		$where_clause=substr($where_clause,0,-2);
		$where_clause.=' )';
	}	
}

if ( $_GET['getOnlyServersList'] ) {
	$getOnlyServersList=$_GET['getOnlyServersList'];
	$getOnlyServersList=preg_replace("/[^,\d]/","",$getOnlyServersList);	
	$getOnlyServersList=replaceCurrentServer($getOnlyServersList);
	
	$getOnlyServersListClause	= " AND serverID IN ( ".$_GET['getOnlyServersList']." ) " ;		
} else {
	$getOnlyServersListClause = '';
}

$where_clause.=	$getOnlyServersListClause;



if (!$op) $op="latest";	

if (!in_array($op,array("latest","get_hash","get_igc","error")) ) return;

$encoding="utf-8";



set_time_limit( 60 + floor($count/4) );

if ($op=="get_hash") {	

	if (!$CONF_use_utf) {
		require_once dirname(__FILE__).'/lib/ConvertCharset/ConvertCharset.class.php';
	}

	 $format='JSON';
	 $RSS_str='{ "log": [ ';
	
	 $query="SELECT ID, userID, serverID,hash, userServerID,originalUserID ,original_ID  FROM $flightsTable WHERE  hash<>'' ";
	  //$query.=" LIMIT 1000 "; 
	 $res= $db->sql_query($query);
	 if($res <= 0){
		 $RSS_str='{ "error": "Error in query!" }';
	 } else {
		$RSS_str='';
		 $item_num=0;
		 while ($row = mysql_fetch_assoc($res)) { 
				$pilotID=$row['userID'].'_'.$row['userServerID'];
				if ( ! $pilotNames[$pilotID]){
					$pilotInfo=getPilotInfo($row['userID'],$row['userServerID'] );
					if (!$CONF_use_utf ) {
						$NewEncoding = new ConvertCharset;
						$lName=$NewEncoding->Convert($pilotInfo[0],$langEncodings[$nativeLanguage], "utf-8", $Entities);
						$fName=$NewEncoding->Convert($pilotInfo[1],$langEncodings[$nativeLanguage], "utf-8", $Entities);
					} else {
						$lName=$pilotInfo[0];
						$fName=$pilotInfo[1];
					}
					$pilotNames[$pilotID]['lname']=$lName;
					$pilotNames[$pilotID]['fname']=$fName;
					$pilotNames[$pilotID]['country']=$pilotInfo[2];
					$pilotNames[$pilotID]['sex']=$pilotInfo[3];
					$pilotNames[$pilotID]['birthdate']=$pilotInfo[4];
					$pilotNames[$pilotID]['CIVL_ID']=$pilotInfo[5];
				} 

				if ($item_num>0) $RSS_str.=' , ';
				$RSS_str.=' { "item": {
"ID": '.$row['ID'].',
"serverID": '.$row['serverID'].',
"hash": "'.$row['hash'].'", '.
'
"pilot" : {
"userID":'.$row['userID'].',
"userServerID":'.$row['userServerID'].',
"lName":"'.$pilotNames[$pilotID]['lname'].'",
"fName":"'.$pilotNames[$pilotID]['fname'].'",
}	'.
/*
'
"pilot" : {
"userID": 	  '.$row['userID'].',
"userServerID": '.$row['userServerID'].',
"lName": "'.$pilotNames[$pilotID]['lname'].'",
"fName": "'.$pilotNames[$pilotID]['fname'].'",
"country": "'.$pilotNames[$pilotID]['country'].'",
"sex": "'.$pilotNames[$pilotID]['sex'].'",
"birthdate": "'.$pilotNames[$pilotID]['birthdate'].'",
"CIVL_ID": "'.$pilotNames[$pilotID]['CIVL_ID'].'"
}	'.
*/
'	}} ';
			$item_num++;
		}
	 }

	$RSS_str='{ "log_item_num": '.$item_num.', "log": [ '.$RSS_str.' ] } ';


} else if ($op=="latest") {

	$sync_type = makeSane($_GET['sync_type'],1);		 
	$getIGCfiles = $sync_type & SYNC_INSERT_FLIGHT_LOCAL ;
	
	$zip		= makeSane($_GET['use_zip'],1);			 
	if ($getIGCfiles) $zip=1;
	
	// hard limit	
	if (!$count ) $count=1000;
		
	$fromTm=$startID;
	$toTm=$_GET['toTm']+0;
	 
	$item_num=0;
	$flightsToServe =array();
	
	$format='JSON';
	$RSS_str='{ "protocol_version": 2,"log": [ ';
	
	$tableNames=array("active"=>$flightsTable,"deleted"=>$deletedFlightsTable);

	foreach($tableNames as $tableType=>$tableName ) {

		if ($tableType=='deleted') {
			$toTm=$lastActionTm;
			$limit=""; // no limit , we must have all the delete actions within this 'chunk'			
			$count=99999999; // a big number
		} else {	
			$limit=" LIMIT ".($count+200);
		}
		$query="SELECT * FROM $tableName  
			WHERE  ".
			// "UNIX_TIMESTAMP($tableName.dateUpdated) >= $fromTm ";
			" $tableName.dateUpdated >= '".gmdate("Y-m-d H:i:s",$fromTm)."'";
		if ($toTm) {
			$query.=" AND $tableName.dateUpdated <= '".gmdate("Y-m-d H:i:s",$toTm)."'";			
		}		
		
		// RULE #1
		// we must ensure that no transactions of the same second are split into 2 log batches
		// thats why we get 100 more entries and stop manually
		$query.="	$where_clause ORDER BY dateUpdated $limit";
		//if ($_GET['dbg']) {
		//	echo $query;
		//}
		
		$res= $db->sql_query($query);
		if($res <= 0){
			echo("<H3> Error in query! $query </H3>\n");
			exit();
		}
	
		$gotEntries=0;
		while ($row = mysql_fetch_assoc($res)) { 
			$actionTimeStr=$row['dateUpdated'];
			$actionTm=fulldate2tmUTC($actionTimeStr);
						
			$addedTimeStr=$row['dateAdded'];
			$addedTm=fulldate2tmUTC($addedTimeStr);
			
			if ($gotEntries>=$count) {  // we are over the limit
				// if this $actionTm differs from the last one 
				// we have forfilled RULE #1 , time to break the loop
				if ($actionTm!=$lastActionTm ) break;
			}
			
			// we must figure this out !
			// is it an add or update 
			if ($tableType=='deleted') {
				$actionID=4;
			} else if ( $addedTm >= $fromTm ) {  // the addition happened inside this chunk !
				$actionID=1;
			} else {
				$actionID=2; // 1-> add , 2->update, 4->delete
			}
								
			// prepare an array of files to send as well
			if ($getIGCfiles) {
				if (  $actionID==1 ) { // type is flight and action is add
					if (! in_array($row['ID'],$flightsToServe) ) 
						array_push($flightsToServe,$row['ID'] );
				}
			}
			$flight=new flight();
			$flight->getFlightFromDB($row['ID'],0,$row);
			
			if ($item_num>0) $RSS_str.=' , ';
			$RSS_str.=' { "item": {
"transactionID": "'.sprintf("%020d",$actionTm).'",
"actionTimeUTC": "'.$actionTimeStr.'",
"actionTmUTC": '.$actionTm.',
"serverUTCoffset": "'.date('Z').'",
"type": 	  1,  
"id": 		  '.$row['ID'].',
"serverID":   '.$row['serverID'].',
"action":     '.$actionID.',
"userID":	  '.$row['userID'].',
"actionData":  '.$flight->toXML('JSON').'
}} ';								
			$gotEntries++;
			$item_num++;
		} // end while
		
		if ($tableType!='deleted') {
			$lastActionTm=$actionTm;
			$lastActionTimeStr=$actionTimeStr;
		}

	} // end tableNames while
	
	$RSS_str.=' ] ';			
	$RSS_str.=' , "ItemCount": '.$item_num.', "lastTimeUTC": "'.$lastActionTimeStr.'", "lastTmUTC": '.($lastActionTm+0).' } ';			
	
	//$RSS_str=htmlspecialchars($RSS_str);
	if (!$CONF_use_utf) {
		require_once dirname(__FILE__).'/lib/ConvertCharset/ConvertCharset.class.php';
		$NewEncoding = new ConvertCharset;
		$RSS_str = $NewEncoding->Convert($RSS_str,$langEncodings[$nativeLanguage], "utf-8", $Entities);
	}

	if ($zip) {
		$filesToServe=array();
		require_once dirname(__FILE__)."/lib/pclzip/pclzip.lib.php";
		
		if ($getIGCfiles && count($flightsToServe) ) {
			$sql="select ID, DATE, userID, userServerID, filename from $flightsTable WHERE ID IN ( ";		
			for($i=0;$i<count($flightsToServe);$i++) {
				if ($i>0) $sql.=' , ';
				$sql.=$flightsToServe[$i];			
			}
			$sql.=" ) ";
		
			$res= $db->sql_query($sql);	
			# Error checking
			if($res <= 0){
				echo("<H3> Error in sync - get igc filenames query! $sql</H3>\n");
				exit();
			}		
			
			while  ( $row = $db->sql_fetchrow($res) ) {
				
				//if ($row['userServerID']) $extra_prefix=$row['userServerID'].'_';
				//else $extra_prefix='';
				//$filename=$flightsAbsPath.'/'.$extra_prefix.$row['userID'].'/flights/'.substr($row['DATE'],0,4).'/'.$row['filename'];
				$filename=LEONARDO_ABS_PATH.'/'.str_replace("%PILOTID%",getPilotID($row["userServerID"],$row["userID"]),str_replace("%YEAR%",substr($row['DATE'],0,4),$CONF['paths']['igc']) ).'/'.$row['filename'];
									
				if (is_file($filename ))
					array_push($filesToServe,
									array(	PCLZIP_ATT_FILE_NAME => $row['ID'].".igc",
											PCLZIP_ATT_FILE_CONTENT => implode("",file($filename ) ) 
									) 
							);
				if (is_file($filename.'saned.igc' ))	
					array_push($filesToServe,		
							array(	PCLZIP_ATT_FILE_NAME => $row['ID'].".saned.igc",
									PCLZIP_ATT_FILE_CONTENT => implode("",file($filename.'saned.igc' ) ) 
							) 
					);								
			}
		}				
		
		array_push($filesToServe,
						array(	PCLZIP_ATT_FILE_NAME => "sync.txt",
								PCLZIP_ATT_FILE_CONTENT => $RSS_str ) 
						)  ;

						
		
		$tmpZipFile="sync_".$clientID."_".time().".zip";

		$archive = new PclZip($CONF_tmp_path.'/'.$tmpZipFile);
		
		$v_list = $archive->create(	$filesToServe,PCLZIP_OPT_REMOVE_ALL_PATH);
		$outputStr=implode("", file($CONF_tmp_path.'/'.$tmpZipFile) );
		@unlink($CONF_tmp_path.'/'.$tmpZipFile);
		$outputFilename=$tmpZipFile;


		$attachmentMIME ='application/octet-stream';
		header("Pragma: public"); // required
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false); // required for certain browsers 
		header("Content-type: $attachmentMIME");
		header('Content-Disposition: inline; filename="'.$outputFilename.'"');
		header("Content-Transfer-Encoding: binary");
		header("Content-length: ".strlen($outputStr));
		echo $outputStr;
		return;
	}		
	
	
	//$RSS_str=htmlspecialchars($RSS_str);

	//$NewEncoding = new ConvertCharset;
	//$FromCharset=$langEncodings[$currentlang];
	//$RSS_str = $NewEncoding->Convert($RSS_str, $FromCharset, "utf-8", $Entities);
}



	
if (!empty($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Apache/2'))	{
	header ('Cache-Control: no-cache, pre-check=0, post-check=0, max-age=0');
} else	{
	header ('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
}
header ('Expires: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
header ('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
if ($format=='XML') 			header ('Content-Type: text/xml');
else if ($format=='JSON') 		header ('Content-Type: text/plain');

echo $RSS_str;

// search if the cussrent server id is in the list, and replace it by 0, 
// (0 is used in the DB for serverID for local flights)
function replaceCurrentServer($getOnlyServersList) {
	global $CONF_server_id;
	$getOnlyServersList=preg_replace("/[^,\d]/","",$getOnlyServersList);	
	$tmpList=split(",",$getOnlyServersList);
	$getOnlyServersList='';
	foreach($tmpList as $tmpServerItem) {
		$tmpServerItem +=0;
		if ( ! $tmpServerItem ) 
			continue;
		if ($tmpServerItem ==$CONF_server_id )	
			$tmpServerItem ="0";
		$getOnlyServersList.=$tmpServerItem.',';				
	}
	$getOnlyServersList=substr($getOnlyServersList,0,-1);
	return 	$getOnlyServersList;
}	
	
function replaceCurrentServerInArray(&$ServersList) {
	global $CONF_server_id;
		
	foreach($ServersList as $i=>$tmpServerItem) {
		$tmpServerItem +=0;		
		if ($tmpServerItem ==$CONF_server_id )
			$ServersList[$i]=0;	
	}
	return 	$ServersList;
}	
?>
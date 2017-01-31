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
// $Id: sync.php,v 1.32 2012/01/16 07:21:23 manolis Exp $                                                                 
//
//************************************************************************
	if ($_GET['version']==2 && ( $_GET['op']=="latest" || !$_GET['op'])	) {
		require_once dirname(__FILE__)."/sync_new.php";
		exit;
	}
	
	if ($_GET['version']!=2 && ( $_GET['op']=="latest" || !$_GET['op'])	) {
		echo "Sync protocol version 1 is inactive, please use version 2";
		exit;
	} 
	
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
	$format		= makeSane($_GET['format'],0);	
	if ( ! $format	) $format=$CONF['sync']['protocol']['format'];
	$format=strtoupper($format);

	$clientID	= makeSane($_GET['clientID'],1);	
	$clientPass	= makeSane($_GET['clientPass'],0);

	if ( $_GET['getOnlyServersList'] ) {
		$getOnlyServersListClause	= " AND ServerItemID IN ( ".$_GET['getOnlyServersList']." ) " ;		
	} else {
		$getOnlyServersListClause = '';
	}
	
	if ($count) $limit="LIMIT $count";
	else $limit="";

	$where_clause='';
	if ($type) $where_clause=" AND ItemType=$type ";

	$dont_give_servers=$CONF['servers']['list'][$clientID]['dont_give_servers'];
	
	$where_clause.=" AND ServerItemID NOT IN ( ";
	if ( is_array($dont_give_servers) ) {
		foreach($dont_give_servers as $tmpServerID) {
			$where_clause.=$tmpServerID.', ';
		}
	}
	$where_clause.=$clientID .' )';

	$where_clause.=	$getOnlyServersListClause;

	if (!$op) $op="latest";	
	if (!in_array($op,array("latest","get_hash","get_igc","pilot_info")) ) return;

	$encoding="utf-8";


	if ($format=='XML') 
		$RSS_str="<?xml version=\"1.0\" encoding=\"$encoding\" ?>\n<log>";
	else if ($format=='JSON') 
		$RSS_str='{ "log": [ ';

	// authentication stuff
	// the client must be in the leonardo_servers table and the password he provided must match the serverPass field we have for him.
	if ( !Server::checkServerPass($clientID,$clientPass)) {
		$op='error';
		if ($format=='XML') {
			$RSS_str="<?xml version=\"1.0\" encoding=\"$encoding\" ?>\n<log>";
			$RSS_str.="<error>Not authorized $clientID,$clientPass </error>\n";
		} else if ($format=='JSON') {
			$RSS_str='{ "error": "Not authorized '.$clientID.','.$clientPass.'" }';
		}
	}
	
	set_time_limit( 60 + floor($count/4) );
	
	if ($op=="pilot_info") {	

		if (!$CONF_use_utf) {
		 	require_once dirname(__FILE__).'/lib/ConvertCharset/ConvertCharset.class.php';
		}
			
		$pilotListStr=preg_replace("/[^_,\d]/","",$_GET['pilots']);	
		
		$pilotList=split(",",$pilotListStr);
		if (!count($pilotList)) {
			echo '{ "error": "No pilot id" }';
			exit;
		}
		
		//echo "*".$pilotList."**";
		// print_r($pilotList);

		$where_clause='';
		foreach($pilotList as $pIDstr) {				
			list($sID,$pID)=explode('_',$pIDstr);		

			// echo "@ $sID,$pID @";

			if (!$pID && !$sID ) {
				continue;
			}
			
			if (!$pID) {
				$pID=$sID;
				$sID=0;
			}
			$where_clause.=" OR ( pilotID=$pID AND serverID=$sID)  ";
		}

		 $format='JSON';
		 $query="SELECT * FROM $pilotsTable WHERE (1=0) $where_clause ";
		  //$query.=" LIMIT 1000 "; 
		 $res= $db->sql_query($query);
		 if($res <= 0){
			 $RSS_str='{ "error": "Error in query!" }';
		 } else {
			 $res_str='';
			 $item_num=0;
			 while ($row = mysql_fetch_assoc($res)) { 
			 
					$pilotID=$row['pilotID'].'_'.$row['serverID'];
					
					
					if ( ! $pilotNames[$pilotID]){
						$pilotInfo=getPilotInfo($row['pilotID'],$row['serverID'] );
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
					$res_str.=' { "item": {
"pilotID":'.$row['pilotID'].',
"serverID":'.($row['serverID']?$row['serverID']:$CONF_server_id).',
"LastName":"'.$pilotNames[$pilotID]['lname'].'",
"FirstName":"'.$pilotNames[$pilotID]['fname'].'",
"countryCode": "'.$pilotNames[$pilotID]['country'].'",
"Sex": "'.$pilotNames[$pilotID]['sex'].'",
"Birthdate": "'.$pilotNames[$pilotID]['birthdate'].'",
"CIVL_ID": "'.$pilotNames[$pilotID]['CIVL_ID'].'"
}} ';
				$item_num++;
			}
		 }

		$RSS_str='{ "log_item_num": '.$item_num.', ';
		// $RSS_str.=' "query": "'.$query.'", ';
		$RSS_str.=' "log": [ '.$res_str.' ] } ';

	
	} else if ($op=="get_hash") {	

		if (!$CONF_use_utf) {
		 	require_once dirname(__FILE__).'/lib/ConvertCharset/ConvertCharset.class.php';
		}

		 $format='JSON';
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
		 
		 $query="SELECT * FROM $logTable  WHERE  transactionID>=$startID  AND result=1 $where_clause ORDER BY transactionID $limit";
		 // echo $query;
		 $res= $db->sql_query($query);
		 if($res <= 0){
			 echo("<H3> Error in query! </H3>\n");
			 exit();
		 }
		
		$item_num=0;
		$flightsToServe =array();
		
		while ($row = mysql_fetch_assoc($res)) { 

			$desc=htmlspecialchars ($desc);

			$actionTime=$row['actionTime']-date('Z');
			$actionTimeStr=tm2fulldate($actionTime);

			// prepare an array of files to send as well
			if ($getIGCfiles) {
				if (  $row['ItemType']==1 && $row['ActionID']==1 ) { // type is flight and action is add
					if (! in_array($row['ItemID'],$flightsToServe) ) 
						array_push($flightsToServe,$row['ItemID'] );
				}
			}
			
			if ($format=='JSON') {
				if ($item_num>0) $RSS_str.=' , ';
				$RSS_str.=' { "item": {
"transactionID": "'.sprintf("%020d",$row['transactionID']).'",
"actionTimeUTC": "'.$actionTimeStr.'",
"serverUTCoffset": "'.date('Z').'",
"type": 	  '.$row['ItemType'].',
"id": 		  '.$row['ItemID'].',
"serverID":   '.$row['ServerItemID'].',
"action":     '.$row['ActionID'].',
"userID":	  '.$row['userID'].',
"actionData":  '.$row['ActionXML'].'
}} ';
									
			} else if ($format=='XML') {
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

			$item_num++;
		} // end while

		if ($format=='XML') 		$RSS_str.="</log>\n";
		else if ($format=='JSON') 	$RSS_str.=' ] } ';

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
				$sql="select ID, DATE, userID, filename from $flightsTable WHERE ID IN ( ";		
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
					// $filename=dirname(__FILE__).'/flights/'.$row['userID'].'/flights/'.substr($row['DATE'],0,4).'/'.$row['filename'];
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

?>
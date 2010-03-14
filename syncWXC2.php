<?php 
//************************************************************************
// Leonardo XC Server, http://www.leonardoxc.net
//
// Copyright (c) 2004-2010 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: syncWXC2.php,v 1.5 2010/03/14 20:56:12 manolis Exp $                                                                 
//
//************************************************************************
/********** implements CIVL WXC synchronization protocol  ***************/	
/************** Mon Jan 14 18:54:15 CET 2008, by mk *********************/
// Rewritten from scratch by Durval Henke 

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

if ($CONF_use_utf) $db->sql_query("SET NAMES utf8");   

$maxCountHardLimit=500;
$ServerId=$CONF_server_id;

$count=$_GET['c']+0;
if (!$count)  $count=$maxCountHardLimit;
if ( $count>$maxCountHardLimit)  $count=$maxCountHardLimit;


$fromTm=$_GET['from']+0;
if (!$fromTm)  $fromTm=gmmktime(0, 0, 0, 1, 1, 2007);

$toTm=$_GET['to']+0;
// if (!$toTm)  $toTm=time();

$zerocivl=0;
if (isset($_GET['zerocivl'])) { 
   $zerocivl=makeSane($_GET['zerocivl'],1);
}

// Authentication
$clientID   = makeSane($_GET['clientID'],1);    
$clientPass = makeSane($_GET['clientPass'],0);
if ( !Server::checkServerPass($clientID,$clientPass)) {
	echo "<?xml version=\"1.0\" encoding=\"$encoding\" ?>\n";
	echo "<error>Not authorized $clientID,$clientPass </error>\n";
	die();
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


$tableNames=array("active"=>$flightsTable,"deleted"=>$deletedFlightsTable);

$xRow=array();

$lastActionTm=0;

foreach($tableNames as $tableType=>$tableName ) {

	// echo "lastActionTm:$lastActionTm<HR>";
	if ($tableType=='deleted') {
		$NacStatusStr="d";
		
		$toTm=$lastActionTm;
		if (! $toTm) $toTm=$fromTm;
		
		$limit=""; // no limit , we must have all the delete actions within this 'chunk'	
		$count=99999999; // a big number		
	} else {	
		$NacStatusStr="o";
		
		$limit=" LIMIT ".($count+200);
	}
 
	//  echo "toTm:$toTm<HR>";
	$where_clause ="AND UNIX_TIMESTAMP($tableName.dateUpdated) >= $fromTm ";
	
	if ($toTm) {
		$where_clause.=" AND UNIX_TIMESTAMP($tableName.dateUpdated) <=$toTm ";
	}			
		
	$query="SELECT 
$tableName.ID as NacFlightId, 
'$NacStatusStr' as NacStatus,
$pilotsTable.pilotID as NacPilotId, 
$pilotsTable.CIVL_ID as CivlId,
$pilotsTable.FirstName as PilotFirstName,
$pilotsTable.LastName as PilotLastName ,
$pilotsTable.countryCode as PilotNation , 
$pilotsTable.Sex as PilotGender,
$tableName.filename,
$tableName.userID,
$tableName.userServerID,
$tableName.glider AS Glider,     
$tableName.gliderBrandID,
$tableName.cat,
$tableName.subcat,
$tableName.category,
$tableName.comments,  
(UNIX_TIMESTAMP($tableName.DATE) + $tableName.START_TIME) AS TakeoffTime,     
(UNIX_TIMESTAMP($tableName.DATE) + $tableName.END_TIME) AS LandingTime,
$tableName.hash AS IgcMd5,
leonardo_waypoints.intName as TakeoffName,
leonardo_waypoints.countryCode as TakeoffCountry,
UNIX_TIMESTAMP($tableName.dateAdded) as FirstTimestamp,
UNIX_TIMESTAMP($tableName.dateUpdated) as LastTimestamp, 
$tableName.dateAdded,
$tableName.dateUpdated, 
$tableName.serverID,
$tableName.originalURL,
$tableName.original_ID,
DATE_FORMAT($tableName.DATE,'%Y') as Year
 FROM $tableName,$pilotsTable,leonardo_waypoints      
 WHERE 
 	$tableName.userID =$pilotsTable.pilotID AND 
	$tableName.userServerID =$pilotsTable.serverID
	 AND leonardo_waypoints.ID = $tableName.takeoffID
	 $where_clause  
  ORDER BY $tableName.dateAdded $limit
 ";
	// print $query; // exit;
	$res= $db->sql_query($query);  
	if($res <= 0){
		echo("<H3> Error in query! <br>".$query." </H3>\n");  
		exit();
	}

	$gotEntries=0;
	while($row = mysql_fetch_assoc($res)) {
		//if ($row['userServerID']) $extra_prefix=$row['userServerID'].'_';
		//else $extra_prefix='';
		//$filename=$flightsAbsPath.'/'.$extra_prefix.$row['userID'].'/flights/'.$row['Year'].'/'.$row['filename'];
		
		$filename=LEONARDO_ABS_PATH.'/'.str_replace("%PILOTID%",getPilotID($row["userServerID"],$row["userID"]),str_replace("%YEAR%",substr($row['DATE'],0,4),$CONF['paths']['igc']) ).'/'.$row['filename'];
							
		if ($tableType=='active' && !file_exists($filename) ){
			// echo" igc not found :$actionTm <BR>";	
			 continue;	
		}
		
		//echo" igc FOUND !!!!!:$actionTm <BR>";	
		$actionTimeStr=$row['dateUpdated'];
		$actionTm=fulldate2tmUTC($actionTimeStr);
					
		$addedTimeStr=$row['dateAdded'];
		$addedTm=fulldate2tmUTC($addedTimeStr);
		
		if ($gotEntries>=$count) {  // we are over the limit
			// if this $actionTm differs from the last one 
			// we have forfilled RULE #1 , time to break the loop
			if ($actionTm!=$lastActionTm ) break;
		}
			
		$xRow[]=$row;
		$gotEntries++;
		$item_num++;
	}
	
	// print_r($xRow);
	if ($tableType!='deleted') {
		$lastActionTm=$actionTm;
		$lastActionTimeStr=$actionTimeStr;
	}
} 


$item_num=0;
$item_ok=0;
$max_time=0;

foreach ($xRow as $row) {  
	if(makeSane($row['CivlId'],1)>0 || $zerocivl) {
	
    	if($max_time < $row['LastTimestamp']){
        	$max_time=$row['LastTimestamp'];
        }
		  
		$row['CommentInternal']=htmlspecialchars(html_entity_decode($row['comments'],ENT_NOQUOTES,"UTF-8") );    
		$row['GliderCat']=convertCat($row['cat'],$row['category']);
		
		if (  $row['serverID']==0 || $row['serverID']==$CONF_server_id ) $isLocal=1;
		else $isLocal=0;
		
		if ($isLocal) {
			$row['FlightUrl']="http://".$_SERVER['SERVER_NAME'].getLeonardoLink(array('op'=>'show_flight','flightID'=>$row['NacFlightId']));			
		} else {			
			if ( $row['serverID'] != 0 && ! $row['originalURL']) {			
				if ( $CONF['servers']['list'][$row['serverID']]['isLeo'] ==1  ) {
					if (! $row['originalURL'] )  {
						 $row['originalURL']='http://'.$CONF['servers']['list'][$row['serverID']]['url'].'&op=show_flight&flightID='.$row['original_ID'];
					}
				}
			}		
			$row['FlightUrl']= $row['originalURL'];
		}
													
		$row['FlightUrl']=htmlspecialchars($row['FlightUrl']);
		
		$trackPath=getRelMainDir().str_replace("%PILOTID%",getPilotID($row["userServerID"],$row["userID"]),str_replace("%YEAR%",substr($row['DATE'],0,4),$CONF['paths']['igc']) ).'/'.rawurlencode($row['filename']);
					
		$row['IgcUrl']="http://".$_SERVER['SERVER_NAME'].$trackPath;						
		
		$WxcFields=Array('CivlId','PilotFirstName','PilotLastName','PilotNation','PilotGender',
		  'CivlIdApprovedBy','IgcUrl','IgcMd5','LastTimestamp','FirstTimestamp','NacStatus','NacPilotId','NacFlightId',
		  'GliderCat','Glider','TakeoffTime','LandingTime','TakeoffName','TakeoffCountry','CommentInternal','FlightUrl');
		foreach($row as $key => $value){
        	if(in_array($key,$WxcFields)){  
            	$FlighsXML[$item_ok].= '      '."<".$key.">".$value."</".$key.">"."\n";
      		}
      	}
      	$item_ok++;
	} // END IF
}

 
if (!empty($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Apache/2'))    {
	header ('Cache-Control: no-cache, pre-check=0, post-check=0, max-age=0');
} else    {
	header ('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
}

header ('Expires: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
header ('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header ('Content-Type: text/xml;');
echo '<?xml version="1.0" encoding="utf-8" ?>'."\n";
echo '<!DOCTYPE FlightSync PUBLIC "-//XCC Nonprofit Organisation//DTD FlightSync Library//EN" "http://www.xccomp.org/spec/xcc-flightsync.dtd">'."\n";
echo '<FlightSync version="0.7">'."\n";
echo '<SyncInfo>'."\n";
echo '    <ServerId>'.$ServerId.'</ServerId>'."\n";
echo '    <NumberOfItems>'.$item_ok.'</NumberOfItems>'."\n";
echo '    <LastTimestamp>'.$lastActionTm.'</LastTimestamp>'."\n";
echo '</SyncInfo>'."\n";

if($item_ok>0){
	$idx=0;
	foreach($FlighsXML as $flightxml){
		$idx++;
		echo '<FlightInfo Id="'.$idx.'">'."\n";
		echo $flightxml;
		echo  "</FlightInfo>"."\n";
	}
}
echo '</FlightSync>'."\n"; 



function convertCat($cat,$category) {
	switch ($cat){
		case "0":
			$GliderCat="0";
		break;
		case "1":
			$GliderCat="3";    
		break;
		case "2":
			$GliderCat="1";    
		break;
		case "4":
			$GliderCat="5";    
		break;
		default:
			$GliderCat="9";    // non free glider
	}
	
	switch ($category){	
		case "1":
			$GliderCat.="201";    
		break;
		case "2":
			$GliderCat.="901";    
		break;
		case "3":
			$GliderCat.="902";    
		break;			
		default :
			$GliderCat.="901";    
		break;	
	}

	return $GliderCat;
}

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
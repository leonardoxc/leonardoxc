<? 
/************************************************************************/
/* Leonardo: Gliding XC Server					        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://sourceforge.net/projects/leonardoserver                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/
/********** implements CIVL WXC synchronization protocol  ***************/	
/************** Mon Jan 14 18:54:15 CET 2008, by mk *********************/

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
require_once "lib/json/CL_json.php";

$ServerId=$CONF_server_id;//"Le0nard0"; // should get entry from from DB 
//echo "from=".(time()-3600*24*10)."&to=".time();
//exit;

if (isset($_GET['c'])) { 
  $count = (get_magic_quotes_gpc()) ? $_GET['c'] : addslashes($_GET['c']);
  if(!is_numeric($count)) 
    $count=6666666;
 }

if ( $count>100 )  $count=100;

$from=mktime(0, 0, 0, 1, 1, 2007);
if (isset($_GET['from'])) { 
  $from = (get_magic_quotes_gpc()) ? $_GET['from'] : addslashes($_GET['from']);
  if(!is_numeric($from)) 
    $from=mktime(0, 0, 0, 1, 1, 2007);
 }

$to=time();
if (isset($_GET['to'])) { 
  $to = (get_magic_quotes_gpc()) ? $_GET['to'] : addslashes($_GET['to']);
  if(!is_numeric($to)) 
    $to=time();
 }

$zerocivl=0;
if (isset($_GET['zerocivl'])) { 
   $zerocivl=makeSane($_GET['zerocivl'],1);
 }



$clientID	= makeSane($_GET['clientID'],1);	
$clientPass	= makeSane($_GET['clientPass'],0);

if ($count) $limit="LIMIT $count";
 else $limit="";

$where_clause=" AND ItemType=1 ";

if ( !Server::checkServerPass($clientID,$clientPass)) {
  echo "<?xml version=\"1.0\" encoding=\"$encoding\" ?>\n";
  echo "<error>Not authorized $clientID,$clientPass </error>\n";
  die();
 }




$query="select max(n) from (select count(actionTime) as n from $logTable where   actionTime>=$from  AND actionTime<$to AND result=1 $where_clause group by actionTime) as x";

$res= $db->sql_query($query);
if($res <= 0){
  echo("<H3> Error in query $query</H3>\n");
  exit();
 }
$row = mysql_fetch_assoc($res);
if($row["max(n)"]>$count) $count=$row["max(n)"]+0;


 
 
$query="SELECT * FROM $logTable  WHERE  actionTime>=$from  AND actionTime<$to AND result=1 $where_clause ORDER BY transactionID  $limit";

$res= $db->sql_query($query);
if($res <= 0){
  echo("<H3> Error in query! </H3>\n");
  exit();
 }

$item_num=0;
$item_ok=0;
while ($row = mysql_fetch_assoc($res)) { 
  
  // get some data from log database
  $actionTime=$row['actionTime'];
  $ItemID=$row['ItemID'];
  $action=$row['ActionID']; // i.e. 1-inset, 2-update, 4-delete
 

//  $Action=json::decode( utf8_encode( $row['ActionXML']) );



  $Action=json::decode( $row['ActionXML'] );


  if($Action){
    $flight = read_leonardo_json_flight($Action['flight']);

    // check if civl is given and >0
    if(makeSane($flight['CivlId'],1)>0 || $zerocivl) {
      $flight['LastTimestamp'] = $actionTime;
      $flight['NacFlightId'] = $ItemID;

      if($action=="4"){
	$flight['NacStatus'] = "d";
      }



      foreach($flight as $key => $value){
			$FlighsXML[$item_ok].= '      '."<".$key.">".$value."</".$key.">"."\n";
      }
      $item_ok++;
    }

  }else{
    $warnings[$item_num]= "failed to read ActionXML  at ".$item_num." dupa<br>\n";
  }
  $item_num++;
 }

if (!empty($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Apache/2'))	{
  header ('Cache-Control: no-cache, pre-check=0, post-check=0, max-age=0');
 } else	{
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


/////////////////////////////////////////////////


function read_leonardo_json_flight($flight){
	// print_r($flight);

  $CivlId= $flight['pilot']['civlID'];
  $CivlIdApprovedBy="0";
  $IgcUrl=htmlentities($flight['linkIGC']);
  $IgcMd5=$flight['validation']['hash'];
  $LastTimestamp="0";// actionTimeUTC" not in "flight"
  $FirstTimestamp=strtotime($flight['dateAdded']);

  if($flight['validation']['validated']=="1")
    $NacStatus="o";
  else
    $NacStatus="";

  $NacPilotId=$flight['pilot']['userID'];
  $NacFlightId="0";// $flight['id']; in "fligths"  item is the original, not master ID



  $PilotFirstName =  html_entity_decode($flight['pilot']['pilotFirstName']);
  $PilotLastName =  html_entity_decode($flight['pilot']['pilotLastName']);
  $PilotNation   =  strtoupper($flight['pilot']['pilotCountry']);
  $PilotGender   =  $flight['pilot']['pilotSex'];


  switch ($flight['info']['gliderCat']){
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

  switch ($flight['info']['cat']){

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




  $Glider=html_entity_decode($flight['info']['glider'],ENT_NOQUOTES,"UTF-8");
    
  $dte=$flight['time']['date'];
  $dte=explode("-",$dte);
 

  $TakeoffTime =  gmmktime(0, 0, 0, intval($dte[1]), intval($dte[2]), intval($dte[0]))+$flight['bounds']['firstTM'];
  $LandingTime =  gmmktime(0, 0, 0, intval($dte[1]), intval($dte[2]), intval($dte[0]))+$flight['bounds']['lastTM'];

  $TakeoffName=html_entity_decode($flight['location']['takeoffName'],ENT_NOQUOTES,"UTF-8");
  $TakeoffCountry=$flight['location']['takeoffCountry'];

  $CommentInternal=htmlspecialchars(html_entity_decode($flight['info']['comments'],ENT_NOQUOTES,"UTF-8") );
  
  $FlightUrl=$flight['linkDisplay'];

  return array( 
	       'CivlId'=>$CivlId,
	       'PilotFirstName'=>$PilotFirstName, 
	       'PilotLastName'=>$PilotLastName,  
	       'PilotNation'=>$PilotNation,    
	       'PilotGender'=>$PilotGender,     
	       'CivlIdApprovedBy'=>$CivlIdApprovedBy,
	       'IgcUrl'=>$IgcUrl,
	       'IgcMd5'=>$IgcMd5,
	       'LastTimestamp'=>$LastTimestamp,
	       'FirstTimestamp'=>$FirstTimestamp,
	       'NacStatus'=>$NacStatus,
	       'NacPilotId'=>$NacPilotId,
	       'NacFlightId'=>$NacFlightId,
	       'GliderCat'=>$GliderCat,
	       'Glider'=>$Glider,
	       'TakeoffTime'=>$TakeoffTime,
	       'LandingTime'=>$LandingTime,
	       'TakeoffName'=>$TakeoffName,
	       'TakeoffCountry'=>$TakeoffCountry,
	       'CommentInternal'=>$CommentInternal,
	       'FlightUrl'=>$FlightUrl
	       );
}



?>
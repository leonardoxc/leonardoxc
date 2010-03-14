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
// $Id: CL_server.php,v 1.40 2010/03/14 20:56:10 manolis Exp $                                                                 
//
//************************************************************************

require_once dirname(__FILE__).'/FN_functions.php';
require_once dirname(__FILE__).'/CL_logReplicator.php';
require_once dirname(__FILE__).'/CL_pilot.php';

class Server {
	var $ID;

	var $isLeo ;
	var $installation_type;
	var $leonardo_version;
	var $url;
	var $url_base;
	var $url_op;
	var $admin_email;
	var $site_pass;

	var $lastPullUpdateID;
	var $serverPass;
	var $clientPass;

	var $is_active;
	var $gives_waypoints;
	var $waypoint_countries;

	var $valuesArray;
	var $gotValues;
	var $DEBUG;

	function Server($id="") {
		global $CONF;
		if (!$id) {
			$this->gotValues=0;
			return;
		}

		$this->ID=$id;
/*
	    $this->valuesArray=array("ID","isLeo","installation_type","leonardo_version","url", "url_base",
			"sync_format", "sync_type", "use_zip",
			"url_op","admin_email","site_pass","lastPullUpdateID","serverPass","clientPass","is_active","gives_waypoints","waypoint_countries"
		);
*/
	    $this->valuesArray=array("ID","lastPullUpdateID");

		$this->data=$CONF['servers']['list'][$id];
		$this->gotValues=1;
		$this->DEBUG=0;
	}

	function uploadFile($filename,$remoteFilename) {
			require_once dirname(__FILE__)."/lib/xml_rpc/IXR_Library.inc.php";
	
			$serverURL="http://".$this->data['url_op'];
			$client = new IXR_Client($serverURL);
			if ($this->DEBUG) $client->debug=true;
		
			if ( ($fileStr=@file_get_contents($filename)) === FALSE) {
				echo 'uploadFile: Error, cannot get contents of '.$filename;
				return 0;
			}

			$fileStr_base64=base64_encode($fileStr);
			if ( ! $client->query('server.uploadFileInline',$this->data['site_pass'], $fileStr_base64,$remoteFilename) ) {
				echo 'uploadFile: Error '.$client->getErrorCode()." -> ".$client->getErrorMessage();
				return 0; 
			} else {
				return 1;
			}
	}

	function sendOPfiles() {
		$res=0;
		foreach (glob("OP_*.php") as $filename) {
			$res+=$this->uploadFile(dirname(__FILE__)."/".$filename,$filename);
		}	
		//return number of files uploaded
		return $res;
	}

	function version() {
		if ($this->data['isLeo']) {
			list($version,$sub_version,$revision)=explode(".",$this->leonardo_version);
			return array($version,$sub_version,$revision);
		} else return array(0,0,0);
    }
	
	function getInfo() {
		require_once dirname(__FILE__)."/lib/xml_rpc/IXR_Library.inc.php";

		$serverURL="http://".$this->data['url_op'];
		$client = new IXR_Client($serverURL);
		if ($this->DEBUG) $client->debug=true;
	
		if ( ! $client->query('server.info',$this->data['site_pass']) ) {
			echo 'server: info '.$client->getErrorCode()." -> ".$client->getErrorMessage();
			return 0;  // $client->getErrorCode();
		} else {
			$info= $client->getResponse();
			return $info;
		}

	}
	

	function getPilots($pilotIDarray) {
	
		global $CONF_server_id,$CONF_tmp_path,$db,$flightsTable;
		
		if (is_array($pilotIDarray) ) {
			// print_r($pilotIDarray);
			$pilotList="";
			foreach($pilotIDarray as $pID) {
			
			}
		} else {
			$pilotList=$pilotIDarray;
		}
		
		$urlToPull='http://'.$this->data['url_base'].'/sync.php?version='.$this->getProtocolVersion();
		$urlToPull.="&op=pilot_info&pilots=".$pilotList;
		$urlToPull.="&clientID=$CONF_server_id&clientPass=".$this->data['clientPass'];

		 // echo "Getting pilot info from $urlToPull ... ";
		
		
		$rssStr=fetchURL($urlToPull,120 );
		if (!$rssStr) {
			echo "Cannot get data from server<BR>";
			return array();
		}
		
		//return $rssStr;
		//echo " <div class='ok'>DONE</div><br>";
		//flush2Browser();

		//echo "^^$rssStr^^";
		// echo "<BR>Decoding log from JSON format ...";
		//flush2Browser();
		require_once dirname(__FILE__).'/lib/json/CL_json.php';
		$arr=json::decode($rssStr);
		//echo " <div class='ok'>DONE</div><br>";
		//flush2Browser();
		// print_r($arr);
		//exit;
		$entriesNum=0;
		$entriesNumOK=0;
		$pilotsList=array();
		if ( count($arr['log']) ) {
			$item_num=$arr['log_item_num'];
			//echo "<div class='ok'>GOT $item_num entries</div><br>";

			foreach ($arr['log'] as $i=>$logItem) {
				if (!is_numeric($i) ) {echo "$i not numeric "; continue;		}
				// print_r($logItem['item']) ;
				$pilotsList[]=$logItem['item'];
			}	
		}		
		
		return $pilotsList;
		/*
	
			require_once dirname(__FILE__)."/lib/xml_rpc/IXR_Library.inc.php";
	
			$serverURL="http://".$this->data['url_op'];
			$client = new IXR_Client($serverURL);
			if ($this->DEBUG) $client->debug=true;


			if ( ! $client->query('pilots.getPilots',$this->data['site_pass'], 11 ) ) {
				echo 'getPilots: Error '.$client->getErrorCode()." -> ".$client->getErrorMessage();
				return array();  // $client->getErrorCode();
			} else {
				$pilotsList = $client->getResponse();
				return $pilotsList;
			}
			*/
	}
	
	function getTakeoffs($tm) {
			require_once dirname(__FILE__)."/lib/xml_rpc/IXR_Library.inc.php";
	
			$serverURL="http://".$this->data['url_op'];
			$client = new IXR_Client($serverURL);
			if ($this->DEBUG) $client->debug=true;

			$onlyTakeoffs=1;
			if ( ! $client->query('takeoffs.getTakeoffs',$this->data['site_pass'], $tm ,$onlyTakeoffs) ) {
				echo 'getTakeoffs: Error '.$client->getErrorCode()." -> ".$client->getErrorMessage();
				return array(0,array());  // $client->getErrorCode();
			} else {
				list($takeoffsListNum,$takeoffsList)= $client->getResponse();
				return $takeoffsList;
			}
	}

	function findTakeoff($lat,$lon) {
		require_once dirname(__FILE__)."/CL_gpsPoint.php";
		list($version,$sub_version,$revision)=$this->version();
		if ($version>=2) { // new rpc method
			require_once dirname(__FILE__)."/lib/xml_rpc/IXR_Library.inc.php";
	
			$serverURL="http://".$this->data['url_op'];
			$client = new IXR_Client($serverURL);
			if ($this->DEBUG) $client->debug=true;
		
			if ( ! $client->query('takeoffs.findTakeoff',$this->data['site_pass'], $lat, $lon ) ) {
				echo 'findTakeoff: Error '.$client->getErrorCode()." -> ".$client->getErrorMessage();
				return array(0,-1);  // $client->getErrorCode();
			} else {
				list( $nearestWaypoint,$minTakeoffDistance)= $client->getResponse();
				$nearestWaypoint=(object) $nearestWaypoint;
				return array($nearestWaypoint,$minTakeoffDistance);
			}


		} else if ($version==1 && $sub_version >=4) { // use EXT_takeoff.php method
			require_once dirname(__FILE__)."/FN_functions.php";
			$serverURL="http://".$this->data['url_base']."/EXT_takeoff.php?op=find_wpt&lat=$lat&lon=$lon";
			//echo $serverURL;
			$contents=fetchURL($serverURL);
			if (!$contents) {
				echo "SERVER at: ".$this->data['url_base']." is NOT ACTIVE<br>"; 
				return array(0,-1);
			}
			//echo $contents;
			require_once dirname(__FILE__).'/lib/miniXML/minixml.inc.php';
			$xmlDoc = new MiniXMLDoc();
			$xmlDoc->fromString($contents);
			$xmlArray=$xmlDoc->toArray();

			$wpt=new waypoint();
			
			$wpt->waypointID=$xmlArray[search][waypoint][name];
			$wpt->name		=$xmlArray[search][waypoint][name];
			$wpt->intName	=$xmlArray[search][waypoint][intName];
			$wpt->location	=$xmlArray[search][waypoint][location];
			$wpt->intLocation=$xmlArray[search][waypoint][intLocation];
			$wpt->type		=$xmlArray[search][waypoint][type];
			$wpt->countryCode=$xmlArray[search][waypoint][countryCode];
			$wpt->lat		=$xmlArray[search][waypoint][lat];
			$wpt->lon		=$xmlArray[search][waypoint][lon];
			$wpt->link		=$xmlArray[search][waypoint][link];
			$wpt->description=$xmlArray[search][waypoint][description];
			$wpt->modifyDate=$xmlArray[search][waypoint][modifyDate];
			
			$distance=$xmlArray[search][distance];
			
			return array($wpt,$distance);
		} else if ( $version==0 && !$this->isLeo ) { // we are dealing with 'alien' servers
			require_once dirname(__FILE__)."/FN_functions.php";
			//the installation_type in this case point to the ID of the alien server			
			$takeoffsList=getExtrernalServerTakeoffs($this->data['installation_type'],$lat,$lon,1000,1);			
			$wpt=new waypoint();
			$distance=$takeoffsList[0]['distance'];

			$wpt->intName=$takeoffsList[0]['name'];
			$wpt->name=$takeoffsList[0]['name'];
			$wpt->location=$takeoffsList[0]['area'];
			$wpt->intLocation=$takeoffsList[0]['area'];
			$wpt->countryCode=$takeoffsList[0]['countryCode'];
			$wpt->link=$takeoffsList[0]['url'];
			$wpt->lat=$takeoffsList[0]['lat'];
			$wpt->lon=$takeoffsList[0]['lon'];
			
			return array($wpt,$distance);
		}
		
	}
	
	function registerServerToMaster() {
		global $CONF_master_server_id;

		require_once dirname(__FILE__)."/lib/xml_rpc/IXR_Library.inc.php";
		$masterServer=new Server($CONF_master_server_id);
		$masterServer->getFromDB();
		
		$masterServerURL="http://".$masterServer->data['url_op'];	
		$thisServerURL="http://".$this->data['url_op'];
		$client = new IXR_Client($masterServerURL);
		if ($this->DEBUG) $client->debug=true;
	
		if ( ! $client->query('server.registerSlave',$this->data['site_pass'], $lat, $lon ) ) {
			echo 'registerSlave: Error '.$client->getErrorCode()." -> ".$client->getErrorMessage();
			return 0;  // $client->getErrorCode();
		} else {
			$newServerID= $client->getResponse();
			return $newServerID;
		}
	}
	
	function getServers() {
		global $db,$serversTable,$CONF;
		$i=0;
		foreach($CONF['servers']['list'] as $sID=>$sInfo) {
			$servers[$i]=new Server($sID);
			$i++;
		}

/*
		$res= $db->sql_query("SELECT * FROM $serversTable order BY ID");
  		if($res <= 0){   	
			echo "Error getting all servers from DB<BR>";
		    return;
	    }

		$i=0;
	    while ($row= $db->sql_fetchrow($res) ) {
			$servers[$i]=new Server($row[$id]);
			foreach ($servers[$i]->valuesArray as $valStr) {
				$servers[$i]->$valStr=$row["$valStr"];
			}
			$servers[$i]->gotValues=1;
			$i++;
		}
*/
		return $servers;
	}

	function getFromDB($id=0) {
		if (!$id) $id=$this->ID;

		global $db,$serversTable;
		$res= $db->sql_query("SELECT * FROM $serversTable WHERE ID=".$id );
  		if($res <= 0){   
			 $query2="INSERT INTO $serversTable  ( ID, lastPullUpdateID)  VALUES ( $id, 0 ) ";
			 $res2= $db->sql_query($query2);
	  		 if($res <= 0){   
				 echo "Error in putting new server to DB $query2<BR>";
			 }
		     return;
	    }

	    $row= $db->sql_fetchrow($res);
		$this->lastPullUpdateID=$row["lastPullUpdateID"];
		//foreach ($this->valuesArray as $valStr) {
		//	$this->$valStr=$row["$valStr"];
		//}
		// $this->gotValues=1;
    }

	function getNextFreeID() {
		global $db,$serversTable;
		$res= $db->sql_query("SELECT max(ID) as maxid FROM $serversTable ");
  		if($res <= 0){   
			 echo "Error getting info for last server ID from DB<BR>";
		     return -1;
	    }
	    $row= $db->sql_fetchrow($res);
		$maxid=$row['maxid']+1;
		if ($maxid<100) $maxid=100;
		return $maxid;
	}

	function putToDB($update=0) {
		global $db,$serversTable;

		$query="REPLACE INTO $serversTable  ( ID, lastPullUpdateID)  VALUES ( $this->ID, $this->lastPullUpdateID ) ";
		$res= $db->sql_query($query);
		if($res <= 0){   
			echo "Error in putting new server to DB $query<BR>";
			return 0;
		}
		return 1;

/*
		if ($update) {
			$query="REPLACE INTO ";		
			$fl_id_1="ID,";
			$fl_id_2=$this->ID.", ";
		}else {
			$query="INSERT INTO ";		
			$fl_id_1="";
			$fl_id_2="";
		}


		$query.=" $serversTable  ( ";
		foreach ($this->valuesArray as $valStr) {
				$query.= $valStr.",";		
		}
		$query=substr($query,0,-1);

		$query.= " ) VALUES ( ";
		foreach ($this->valuesArray as $valStr) {
			$query.= "'".prep_for_DB($this->$valStr)."',";
		}
		$query=substr($query,0,-1);
		$query.= " ) ";
		// echo $query;
	    $res= $db->sql_query($query);
	    if($res <= 0){
		  echo "Error putting server to DB<BR>";
		  return 0;
	    }		
		$this->gotValues=1;			
		return 1;
*/
    }

	// serverPass -> the password that the client server with the speficic ID must provide
	// clientPass -> the password WE (the local server) uses when it wants to connect to server with ID

	// they are the same only in the entry of the local server

	function checkServerPass($serverID,$pass) {
		global $CONF;
		if ( $pass && $pass==$CONF['servers']['list'][$serverID]['serverPass']) return 1;
		
		return 0;
/*
		global $db,$serversTable;
		$res= $db->sql_query("SELECT * FROM $serversTable WHERE ID=$serverID AND serverPass='$pass' ");
  		if($res <= 0){   
			 echo "Error getting server from DB<BR>";
		     return;
	    }

	    if ( $row= $db->sql_fetchrow($res) ) {
			return 1;
		} else {
			return 0;
		}
*/
    }

	function deleteAllSyncedFlights() {
		global $db,$flightsTable;
		// if (!$this->gotValues) $this->getFromDB();
		
		$res= $db->sql_query("SELECT * FROM $flightsTable WHERE  serverID=$this->ID ");
  		if($res <= 0){   
			 echo "Error getting server's flights from local DB<BR>";
		     return;
	    }

	    while( $row= $db->sql_fetchrow($res) ) {
			  $flight=new flight();
			  $flight->getFlightFromDB($row['ID']);		
			  $flight->deleteFlight();
		} 

		//	reset the counter
		$this->lastPullUpdateID=0;
		$this->putToDB(1);

	}

	function deleteAllSyncedPilots() {
		global $db,$pilotsTable;
		// if (!$this->gotValues) $this->getFromDB();
		
		$res= $db->sql_query("SELECT * FROM $pilotsTable WHERE  serverID=$this->ID ");
  		if($res <= 0){   
			 echo "Error getting server's pilots from local DB<BR>";
		     return;
	    }

		echo "Deleting all pilots of server ".$this->ID." from local DB <HR>";
	    while( $row= $db->sql_fetchrow($res) ) {
			echo "Deleting pilot ".$row['pilotID']." : ".$row['FirstName'].' '.$row['LastName'] ."<BR>";
			 
			$pilotToDelete=new pilot($this->ID,$row['pilotID']);
			$pilotToDelete->deletePilot(0,1); // delete dir of pilot
		} 

		//	reset the counter
		//$this->lastPullUpdateID=0;
		// $this->putToDB(1);

	}
	
	function moveSyncPointer($count) {
		if ( !is_numeric($count) ) return 0;

		$this->lastPullUpdateID+=$count;
		if ($this->lastPullUpdateID<0 ) $this->lastPullUpdateID=0;
		$this->putToDB();
	}
	
	function setSyncPointer($newValue) {
		if ( !is_numeric($newValue) ) return 0;

		$this->lastPullUpdateID=$newValue;
		if ($this->lastPullUpdateID<0 ) $this->lastPullUpdateID=0;
		$this->putToDB();
	}
	
	function getProtocolVersion(){
		return $this->data['sync_protocol_version']+0;
	}
	
	function guessPilots($chunkSize=5) { // we pull data from this server
		global $CONF_server_id,$CONF_tmp_path,$db,$flightsTable;

		$urlToPull='http://'.$this->data['url_base'].'/sync.php?type=1&version='.$this->getProtocolVersion();
		$urlToPull.="&op=get_hash&format=".$this->data['sync_format'];
		$urlToPull.="&clientID=$CONF_server_id&clientPass=".$this->data['clientPass'].
					"&use_zip=".$this->data['use_zip'];

		echo "Getting flight hashes from $urlToPull ... ";
		flush2Browser();

		$rssStr=fetchURL($urlToPull,60+floor($chunkSize/5) );
		if (!$rssStr) {
			echo "<div class='error'>Cannot get data from server</div><BR>";
			return 0;
		}
		echo " <div class='ok'>DONE</div><br>";
		flush2Browser();


		echo "Decoding log from JSON format ...";
		flush2Browser();
		require_once dirname(__FILE__).'/lib/json/CL_json.php';
		$arr=json::decode($rssStr);
		echo " <div class='ok'>DONE</div><br>";
		flush2Browser();
		//print_r($arr);
		//exit;
		$entriesNum=0;
		$entriesNumOK=0;
		if ( count($arr['log']) ) {
			$item_num=$arr['log_item_num'];
			echo "<div class='ok'>GOT $item_num entries</div><br>";

			foreach ($arr['log'] as $i=>$logItem) {
				if (!is_numeric($i) ) {echo "$i not numeric "; continue;		}
				// echo ($entriesNum+1)." / $item_num  ";
			
				if (is_array($hashRemote[$logItem['item']['hash']]) ) {
					echo " <div class='error'>WARNING found hash from flight ".$logItem['item']['ID']." which already existed in flight ".$hashRemote[$logItem['item']['hash']] ['ID']." </div><br>";
				}

				$hashRemote[$logItem['item']['hash']]=array('ID'=>$logItem['item']['ID'],'pilot'=>$logItem['item']['pilot'] ) ;
				//$entryResult=$this->processSyncEntry($this->ID,$logItem['item']) ;
				//if (  $entryResult <= -128 ) { // if we got an error break the loop, the admin must solve the error
				//	echo "<div class'error'>Got fatal Error, will exit</div>";
				//	break;
				// } 
				
				if (  $entryResult >0 ) $entriesNumOK++;
				$entriesNum++;
			}
			// now get the local hashes

			 $query="SELECT ID, userID, serverID,hash, userServerID,originalUserID ,original_ID  FROM $flightsTable WHERE  hash<>'' ";
			 $res= $db->sql_query($query);
			 if($res <= 0){
				 echo "Error in query!" ;
			 } else {
				 while ($row = mysql_fetch_assoc($res)) { 
					$hashLocal[$row['hash']]=array('userID'=>$row['userID'], 'userServerID'=>$row['userServerID'] ) ;
				 }
			}

			// now compare them 
//print_r($hashLocal);
//echo "<hr><HR><HR>";
// print_r($hashRemote);

			foreach($hashRemote as $testHash=>$remoteInfo) {
				if (is_array($hashLocal[$testHash]) ) {
					// if we have this user in the local db continue
					if ($hashRemote[$testHash]['pilot']['userID']==$hashLocal[$testHash]['userID'] && $hashLocal[$testHash]['userServerID']==$this->ID) continue;

					$samePilots[ $hashRemote[$testHash]['pilot']['userID'] ] [$hashRemote[$testHash]['pilot']['userServerID'] ] [ $hashLocal[$testHash]['userID'] ] [ $hashLocal[$testHash]['userServerID'] ] ++; 
					
					$remotePilotNames[ $hashRemote[$testHash]['pilot']['userID'] ] [$hashRemote[$testHash]['pilot']['userServerID'] ] =$hashRemote[$testHash]['pilot']; 
					//echo "match REMOTE ".$hashRemote[$testHash]['userID']." [ ".$hashRemote[$testHash]['userServerID']." ] <=>  ".$hashLocal[$testHash]['userID']." [ ".$hashLocal[$testHash]['userServerID']." ] LOCAL<BR>"; 
				}
			}

		} else {
			echo "The sync-log returned error. Error: <br />";
			print_r($arr);
			echo "<hr><pre>$rssStr</pre>";
		}

		// print_r($samePilots);
		echo "<hr><pre>";
		echo "# ------------------------------------\n";
		echo "DELETE FROM leonardo_remote_pilots  WHERE remoteServerID=".$this->ID."; \n";

		foreach($samePilots as $remoteUserID=>$arr1) 
			foreach($arr1 as $remoteUserServerID=>$arr2) 
				foreach($arr2 as $localUserID=>$arr3)  
					foreach($arr3 as $localUserServerID=>$arr4)  {
						$counts=$arr4;
						$pilotInfo=getPilotInfo($localUserID,$localUserServerID );
						
						$remotePilotInfo=$remotePilotNames[$remoteUserID][$remoteUserServerID];

						if ($remoteUserServerID==0) $remoteUserServerID=$this->ID;
						echo "# ------------------------------------\n";
						echo "# REMOTE [ ".$remotePilotInfo['lName']." ".$remotePilotInfo['fName']." country: ".$remotePilotInfo['country']." sex: ".$remotePilotInfo['sex']." birthdate: ".$remotePilotInfo['birthdate']." CIVL ID: ".$remotePilotInfo['CIVL_ID']." ] \n";
						echo "# LOCAL [ ".$pilotInfo['0']." ".$pilotInfo['1']." country: ".$pilotInfo['2']." sex: ".$pilotInfo['3']." birthdate: ".$pilotInfo['4']." CIVL ID: ".$pilotInfo['5']." ] \n";
						echo "# $remoteUserServerID"."_$remoteUserID  $localUserServerID"."_$localUserID  = $counts \n";	
						echo "INSERT INTO leonardo_remote_pilots VALUES ( $remoteUserServerID,$remoteUserID,$localUserServerID,$localUserID);\n";	
					
					}
		echo "</pre>";
		echo "<div class='ok'>Finished guessing pilots</div><br>";
		echo "Proccessed $entriesNum flight's hashes out of $item_num<br>";

	}

	function sync($chunkSize=5,$verbose=1) { // we pull data from this server
		global $CONF_server_id,$CONF_tmp_path;
		global $DBGlvl;
		
		$this->getFromDB();
		// we need to take care for protocol version 2, 
		// in v21 the StartID is the last TM in UTC , we need to start again from the last TM 
		// in case 2 or more actions were preformed on the same second and we only 
		// proccessed them partially 
		
		// Problem: the last transaction gets pulled again and again !!!
		// we need to detect if the same transaction ID has been proccessed
		// at least 2 times, then we can move to the next ID without fear of loosing
		// transactions made in the same second.
		
		// we have enforced RULE #1 on the other server running protocol v2 
		// RULE #1
		// we  ensure that no transactions of the same second are split into 2 log batches
		// thats why we get 100 more entries and stop manually
		// so the following is not needed nay more , we always start +1 
		/*
		if ( $this->getProtocolVersion() == 2 ) 
			$startID=$this->lastPullUpdateID;
		else // old version
			$startID=$this->lastPullUpdateID+1;
		*/
		$startID=$this->lastPullUpdateID+1;
			
		if ( $this->data['isLeo'] )  {
			$urlToPull='http://'.$this->data['url_base'].'/sync.php?type=1&version='.$this->getProtocolVersion();
			$urlToPull.="&c=$chunkSize&startID=$startID&format=".$this->data['sync_format'];
			$urlToPull.="&clientID=$CONF_server_id&clientPass=".$this->data['clientPass'].
					"&sync_type=".$this->data['sync_type']."&use_zip=".$this->data['use_zip'];

		} else {
			$urlToPull='http://'.$this->data['url_sync']."count=$chunkSize&startID=$startID";
		}



		if ($verbose) echo "Getting <strong>".$this->data['sync_format']."</strong> sync-log from $urlToPull ... ";
		if ($verbose) flush2Browser();
		if ($verbose) flush2Browser();

		$timeout=60+floor($chunkSize/5);
		if ($this->data['sync_type'] & SYNC_INSERT_FLIGHT_LOCAL && $this->data['use_zip'] ) $timeout*=5;
		$rssStr=fetchURL($urlToPull,$timeout );
		
		if (!$rssStr) {
			echo "<div class='error'>Cannot get data from server</div><BR>";
			return array(-1,"Cannot get data from $urlToPull");
		}

		if ($verbose) echo " <div class='ok'>DONE</div><br>";
		if ($verbose) flush2Browser();

		if ($this->data['use_zip']) { // we have a zip file in $rssStr, unzip it
			if ($verbose) echo "Unziping sync-log ... ";
			$tmpZIPfolder=$CONF_tmp_path.'/'.$this->ID."_".time();
			makeDir($tmpZIPfolder);
			
			$zipFile="$tmpZIPfolder/sync_log.zip";
			writeFile($zipFile,$rssStr);
			
			require_once dirname(__FILE__)."/lib/pclzip/pclzip.lib.php";
			
			$archive = new PclZip($zipFile);
						
			$list 	 = $archive->extract(PCLZIP_OPT_PATH, $tmpZIPfolder,
											PCLZIP_OPT_REMOVE_ALL_PATH,
											PCLZIP_OPT_BY_PREG, "/(\.igc)|(\.olc)|(\.txt)$/i");
					
			if ($list) {
				if ($verbose) echo " <div class='ok'>DONE</div><br>";
				echo "<br><b>List of uploaded igc/olc/txt files</b><BR>";
				$f_num=1;
				foreach($list as $fileInZip) {
					echo "$f_num) ".$fileInZip['stored_filename']. ' ('.floor($fileInZip['size']/1024).'Kb)<br>';
					$f_num++;
				}
				if ($verbose) flush2Browser();
				
				if (is_file($tmpZIPfolder.'/sync.txt') ) {
					$rssStr=implode('',file($tmpZIPfolder.'/sync.txt') );
				} else {
					echo "Could not find sync.txt. <div class='error'>Aborting</div>";
					delDir($tmpZIPfolder);			
					return array(-2,"Could not find sync.txt");
				}
				
				//delDir($tmpZIPfolder);			
				//exit;		
		   } else {
				echo " <div class='error'>This is not a zip file (".$archive->errorInfo().")</div><br>";				
		   }

		}
		
	
		// 
		// getIGC
		// zip


		// for debugging json
		// writeFile(dirname(__FILE__).'/sync.txt',$rssStr);
		//return;

		// echo "<PRE>$rssStr</pre>";

		if ($this->data['sync_format']=='XML')	{	
			require_once dirname(__FILE__).'/lib/miniXML/minixml.inc.php';
			$xmlDoc = new MiniXMLDoc();
			$xmlDoc->fromString($rssStr);
			$xmlArray=$xmlDoc->toArray();
	
			//echo "<PRE>";
			//print_r($xmlArray);
			//echo "</PRE>";
	
			if ($xmlArray['log']['item']['_num']) {
				foreach ($xmlArray['log']['item'] as $i=>$logItem) {
					if (!is_numeric($i) ) continue;				
					if ( ! $this->processSyncEntry($this->ID,$logItem) ) { // if we got an error break the loop, the admin must solve the error
						break;
					}	
				}
			} else {
				$this->processSyncEntry($this->ID,$xmlArray['log']['item']);
			}
		} else if ($this->data['sync_format']=='JSON') {
			if ($verbose) echo "Decoding log from JSON format ...";
			if ($verbose) flush2Browser();
			require_once dirname(__FILE__).'/lib/json/CL_json.php';

			// is this needed ?
			// $rssStr=str_replace('\\\\"','\"',$rssStr);

			// for testing emply log
			// $rssStr='{ "log": [  ] }';

			// for testing bad log
			// $rssStr='{ "log": [   }';

			$arr=json::decode($rssStr);
					
			if ($verbose) echo " <div class='ok'>DONE</div><br>";
			if ($verbose) flush2Browser();

			if ($DBGlvl>0) {
				echo "<PRE>";
				print_r($arr);
				echo "</PRE>";
			}
			
			//exit;
			$entriesNum=0;
			$entriesNumOK=0;
			if ( count($arr['log']) ) {
			
				if ($verbose) echo "Log Entries: <div class='ok'>".count($arr['log'])."</div><br>";
				if ($verbose) flush2Browser();
			
				foreach ($arr['log'] as $i=>$logItem) {
					if (!is_numeric($i) ) continue;		
					echo ($entriesNum+1)." / $chunkSize ";

					// add path of temp folder into array
					$logItem['item']['tmpDir']=$tmpZIPfolder;
					
					$entryResult=$this->processSyncEntry($this->ID,$logItem['item'],$verbose) ;
					if (  $entryResult <= -128 ) { // if we got an error break the loop, the admin must solve the error
						echo "<div class'error'>Got fatal Error, will exit</div>";
						$errorInProccess=1;
						break;
					} 
					
					if (  $entryResult >0 ) $entriesNumOK++;
					$entriesNum++;
				}
			} else {
				if ( is_array($arr['log']) ) { // no log entries to proccess
					delDir($tmpZIPfolder);	
					echo "No new log entries to proccess<br />";
					return array(0,0);
				}

				if ($verbose) {
					echo "Sync-log format error:<br />";
					print_r($arr);
					echo "<hr><pre>$rssStr</pre>";
				} else {
					echo "Sync-log format error:<br><pre>$rssStr</pre><br>";
				}
				delDir($tmpZIPfolder);	
				return array(-4,"Sync-log format error: <pre>$rssStr</pre>");

			}

		}
		if ( $verbose || $entriesNum>0 ) {
			echo "<div class='ok'>Sync-log replication finished</div><br>";
			echo "Proccessed $entriesNum log entries ($entriesNumOK inserted OK) out of $chunkSize<br>";
		}

		// clean up
		delDir($tmpZIPfolder);	
		if ($errorInProccess) 
			return array(-3,$entriesNum);
		else
			return array(1,$entriesNum);

	}

	function processSyncEntry($ID,$logItem,$verbose=1) {
		echo "Processing entry ".($logItem['transactionID']+0)." ...  ";
		if ($verbose) flush2Browser();

		//	print_r($logItem);
		// return 1;

		list($result,$message)=logReplicator::processEntry($ID,$logItem,$this->data['sync_type']);
		if ($result < -10 ) {
			echo "<div class='error'>ERROR </div>: $message <BR>";
			return 0;
		} else {
			// update the pointer 
			// BUT only if it is > than the last one 
			if ( $logItem['transactionID'] > $this->lastPullUpdateID ) {
				$this->lastPullUpdateID=$logItem['transactionID']+0;
				$this->putToDB(1);
			}	
			echo "<div class='ok'>OK</div>: $message<BR>";
			return 1;
		}
	}
}

?>
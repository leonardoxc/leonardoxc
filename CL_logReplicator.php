<?
//************************************************************************
// Leonardo XC Server, http://leonardo.thenet.gr
//
// Copyright (c) 2004-8 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: CL_logReplicator.php,v 1.54 2010/01/02 22:54:55 manolis Exp $                                                                 
//
//************************************************************************

/* 
transactionID  autoincrement

actionTime   the tm of the action
userID  - the user that commits the action
effectiveUserID  - the user for whom the action is taken
ItemType - on an item that is of type :

1 => flight
2 => pilot
4 => waypoint
8 => NAC / club  / group
16=> League / event 
32=> Area ( group of waypoints ) 

ItemID - the item 
ServerItemID - the server of the item -> those 2 define an item in the distributed DB network

ActionID  - what the user does 
1  => add
2  => edit
4  => delete
8  => Score  (flight only)
16 => Rename TrackLog (flight only)
32 => Create Map (flight only)
64 => 
128=>
256=>
512=>

ActionXML - XML that describes the action so it
			 can be reproduced later/in another server

Modifier
0=> nothing special
1=> Club ( ie   user adds pilot to club  )
2=> League / event  ( ie user adds flight to event ) 
4=> Area  ( ie   user adds waypoint to area )


ModifierID - ie clubId of LeagueID
ServerModifierID - the server on which the the extra item resides

Result 
0=> Problem  (initial)
1=> OK
2=> Pending

Result Description  - if any furthe info needs to logged (ie in cae of error)



*/
require_once dirname(__FILE__).'/FN_functions.php';
require_once dirname(__FILE__).'/FN_flight.php';
require_once dirname(__FILE__).'/CL_pilot.php';


class logReplicator { 

	function logReplicator() {
	}


	function checkLocation($serverID,$locationArray,$bounds) {
		//  print_r($locationArray);

		// find nearest waypoint in local db
		list( $nearestTakeoffID,$nearestDistance )=findNearestWaypoint($bounds['firstLat'],$bounds['firstLon']);

		// echo "nearest takeoff :  $nearestTakeoffID,$nearestDistance <BR>";

		if ( $nearestDistance  < ( $locationArray['takeoffVinicity'] + 500 ) ) { 
			// we will use our waypoint if our local waypoint is nearest  ( + 500m margin )
			return array($nearestTakeoffID,$nearestDistance );
		} else { // we will import this takeoff and use that instead

			$newWaypoint =new waypoint();
			$newWaypoint->setLat($locationArray['takeoffLat']);
			$newWaypoint->setLon($locationArray['takeoffLon']);
			$newWaypoint->name =$locationArray['takeoffName'];
			$newWaypoint->type = 1000 ; // takeoff
			$newWaypoint->intName =$locationArray['takeoffNameInt'];
			$newWaypoint->location =$locationArray['takeoffLocation'];
			$newWaypoint->intLocation =$locationArray['takeoffLocationInt'];
			$newWaypoint->countryCode =$locationArray['takeoffCountry'];

			$newWaypoint->link ='';
			$newWaypoint->description ='';
			$newWaypoint->putToDB(0);

			 // also add it up to $waypoints because we use this array for subsequent queries
			global $waypoints;
			array_push($waypoints,$newWaypoint);

			return array($newWaypoint->waypointID,$locationArray['takeoffVinicity']);
		}
	}

	function checkPilot($serverID,$pilotArray){
		global $remotePilotsTable ,$db;
		/*  [pilot] => Array
			(
				[userID] => 347
				[civlid] => 0
				[userName] => 
				[pilotFirstName] => Γιώργος
				[pilotLastName] => Μερισιώτης
				[pilotCountry] => gr
				[pilotBirthdate] => 
				[pilotSex] => 
			)
		*/


		// first see if a mapping exists	
		$query="SELECT * FROM $remotePilotsTable  
		WHERE 		
				( serverID=".($serverID+0)." AND userID=".$pilotArray['userID'] ." ) OR 
				( remoteServerID=".($serverID+0)." AND remoteUserID=".$pilotArray['userID']. " ) ORDER BY serverID ASC" ;	
		$res= $db->sql_query($query);		
		if($res <= 0){
			echo("<H3> Error in checkPilot query! $query</H3>\n");
			return array(0,0);
		}		
		
		// if a mapping exists return the local user instead
		// we must take care for this case :
		// 1 : 12_101678 <-> 0_2527
		// 2 : 12_101678 <-> 5_3219
		// 3 : 5_3219 <-> 0_2527 

		// if we have 12_101678 and we are on server 1 (pgforum) we must map to 0_2527 instead of 5_3219
		// if we have 12_101678 and we are on server 10002 (dhv mirror) we must map to 5_3219 instead of 1_2527
		$map=array();
		while (  $row = $db->sql_fetchrow($res) ) {	
			if ($serverID==$row['serverID']  && $pilotArray['userID']==$row['userID']) {
				$map[$row['remoteServerID']]=$row['remoteUserID'];			
			} else {
				$map[$row['serverID']]=$row['userID'];				
			}	
		}
		if (count($map) ) {
			// print_r($map);
			uksort($map, "pilotServerCmp"); 
			$ar1=array_keys($map);
			$ar2=array_values($map);
			
			//echo $ar1[0] .", ".$ar2[0] ."<BR>";
			
			// a mapping is taking place, we must log this somehow when we return from this function!!!						
			return array( $ar1[0],$ar2[0] );
		}


		
		/*				 old way 
		if (  $row = $db->sql_fetchrow($res) ) {
			if ($row['userID']) 
				return array($row['serverID'],$row['userID']);		
		}
		*/
		
		// else we insert/update the external pilot
		$update=1;
		$pilot=new pilot($serverID,$pilotArray['userID']) ;
		$pilot->createDirs();

		if ( ! $pilot->pilotExists() ) {			
			$update=0;
		}

		$pilot->pilotID =$pilotArray['userID'];
		$pilot->CIVL_ID =$pilotArray['civlID'];

		//$pilot->FirstName=$pilotArray['userName'];
		$pilot->FirstName=$pilotArray['pilotFirstName'];
		$pilot->LastName=$pilotArray['pilotLastName'];
		$pilot->countryCode =$pilotArray['pilotCountry'];
		$pilot->Birthdate=$pilotArray['pilotBirthdate'];
		$pilot->Sex=$pilotArray['pilotSex'];

		$pilot->putToDB($update);
		
		return array( $serverID,$pilotArray['userID'] );
	}
	
	function findFlight($serverID,$flightIDoriginal) {
	  global $db,$flightsTable;
	  global $CONF_server_id;
	  
	  if ($serverID==$CONF_server_id) {
	  	$whereClause=" ( serverID=$serverID OR  serverID=0 ) ";
	  } else {
	  	$whereClause="  serverID=$serverID ";
	  }
	  // echo "find Flight $serverID,$flightIDoriginal ... ";
	  $query="SELECT ID FROM $flightsTable  WHERE original_ID=$flightIDoriginal AND $whereClause ";

	  $res= $db->sql_query($query);	
	  # Error checking
	  if($res <= 0){
		 echo("<H3> Error in findFlight query! $query</H3>\n");
		 exit();
	  }
		
	  if (! $row = $db->sql_fetchrow($res) ) {
		 // echo "not found <BR>";
		  return 0;	  
	  } else {
	  	 // echo "=>".$row['ID']."#<BR>";
	  	return $row['ID']+0;
	  }
	  
	}
	
	function processEntry($serverID,$e,$sync_mode=SYNC_INSERT_FLIGHT_LINK) {
		global $CONF;
		global $DBGcat,$DBGlvl;
		
		if ($DBGlvl>0) {
			echo "<PRE>";
			print_r($e);
			echo "</PRE>";
		}

		if ( is_array($e['ActionXML']) ) {
			$actionData=& $e['ActionXML'];
		} else 	if ( is_array($e['actionData']) ) {
			$actionData=& $e['actionData'];
		} else 	if ( is_array($e['flight']) ) {
			$actionData=& $e;
		} else {
			return array(0,"logReplicator::processEntry : actionData section not found");
		}

		// if this log entry is not for a flight of the specific server
		// then check if we are allowesd to accpet these flights from this server
		if ( isset($actionData['flight']['serverID']) ) {
			$thisEntryServerID=$actionData['flight']['serverID'];
		} else if ( isset($e['serverID']) ){
			$thisEntryServerID=$e['serverID'];
		} else {
			return array(0,"logReplicator::processEntry : ServerID for Log entry could not be determined ".$thisEntryServerID );			
		}

		if ($thisEntryServerID != $serverID ) { 
			$wrongServer=1;

			if ( is_array($CONF['servers']['list'][$serverID]['accept_also_servers'] ) ) {
			
				if (in_array($thisEntryServerID,$CONF['servers']['list'][$serverID]['accept_also_servers'] ) )
					$wrongServer=0;
					
			} 
			
			if ($wrongServer)
				return array(0,"logReplicator::processEntry : We dont accept flights originally from server ".$thisEntryServerID );			
		}	
		
		if ($e['type']=='1') { // flight

			if ($e['action']==4) {	// delete
				$flightIDlocal=logReplicator::findFlight($actionData['flight']['serverID'],$actionData['flight']['id']);
				if (!$flightIDlocal) {
					return array(0,"logReplicator::processEntry : Flight with serverID ".$actionData['flight']['serverID']." and original ID : ".
							$actionData['flight']['id']." is not found in the local DB -> Wont delete it");
				}
				// echo "Will delete flight $flightIDlocal<BR>";
				
				$extFlight=new flight();			
				$extFlight->getFlightFromDB($flightIDlocal,0);
				$extFlight->deleteFlight();			
				return array(1,"Flight with local ID: $flightIDlocal DELETED");
			}

			if ($e['action']==16) {	// rename tracklog
				$flightIDlocal=logReplicator::findFlight($e['serverID'],$e['id']);
				if (!$flightIDlocal) {
					return array(0,"logReplicator::processEntry : Flight with serverID ".$e['serverID']." and original ID : ".
							$e['id']." is not found in the local DB -> Wont rename tracklog<BR>");
				}
				$extFlight=new flight();			
				$extFlight->getFlightFromDB($flightIDlocal,0);		
				$extFlight->renameTracklog($actionData['newFilename'],$actionData['oldFilename']);
				return array(1,"Flight tracklog renamed for local ID $flightIDlocal");
			}

			if ($e['action']==8) {	// scoring info
			
				$flightIDlocal=logReplicator::findFlight($e['serverID'],$e['id']);
				if (!$flightIDlocal) {
					return array(0,"logReplicator::processEntry : Flight with serverID ".$e['serverID']." and original ID : ".
							$e['id']." is not found in the local DB -> Wont update scoring<BR>");
				}
								
				// echo "Will update scoring  info for flight $flightIDlocal<BR>";

				// no need to pull flight info
				//$extFlight=new flight();			
				//$extFlight->getFlightFromDB($flightIDlocal,0);					

				require_once dirname(__FILE__).'/CL_flightScore.php';			
				$flightScore=new flightScore($flightIDlocal);			
				// we have the score array in $actionData['score']				
				$sArr=& $actionData['score'];
				$flightScore->fromSyncArray($sArr);
				//put also in scores table, the flight is sure to be present in flights table
				$flightScore->putToDB(1,1);
				
				return array(1,"Flight Score was *pulled* for local ID $flightIDlocal");
			}
			
			// now deal with add/update
			$getValidationData=1;
			$getScoreData =1;		

			//	check 'alien' pilot  and insert him or update him anyway
			$userServerID=$actionData['flight']['serverID'];
			if ($userServerID==0)  $userServerID=$serverID;				

			list ($effectiveServerID,$effectiveUserID )= 
					logReplicator::checkPilot($userServerID,$actionData['flight']['pilot']);

			// check if a maping took place and LOG it!!
			if ($effectiveServerID != $userServerID || $effectiveUserID != $actionData['flight']['pilot']['userID'] ) {
				$orgUserIDstr= ($userServerID+0).'_'.$actionData['flight']['pilot']['userID'];
			} else {
				$orgUserIDstr='';
			}
			
					
			// $userIDstr=$userServerID.'_'.$actionData['flight']['pilot']['userID'];
			$userIDstr=$effectiveServerID.'_'.$effectiveUserID;
						
			list($nearestTakeoffID,$nearestDistance)=logReplicator::checkLocation($userServerID,
								$actionData['flight']['location'],$actionData['flight']['bounds']);

			list( $nearestLandingID,$nearestLandingDistance )=
					findNearestWaypoint($actionData['flight']['bounds']['lastLat'],$actionData['flight']['bounds']['lastLon']);

			// get only the first 2 bits
			$externalFlightType=$sync_mode & 0x03 ;

			$addFlightNote='';
			
			// if action ==update check to see if the flight exists !
			if ($e['action']==2) {
				$flightIDlocal=logReplicator::findFlight($actionData['flight']['serverID'],$actionData['flight']['id']);
				if (!$flightIDlocal) { // we then INSERT IT instead
					echo " [Not found,will insert] ";
					$e['action']=1;
				}
			} else if ($e['action']==1) {			
				// if action == insert we make an extra check to see if the fligh is there, if yes we UPDATE instead
				$flightIDlocal=logReplicator::findFlight($actionData['flight']['serverID'],$actionData['flight']['id']);
				if ($flightIDlocal) { // we then UPDATE IT instead
					echo " [Already here,will update] ";
					$e['action']=2;
				}
			}
			
			
			if ($e['action']==1) {	// add
				$igcFilename=$actionData['flight']['filename'];
				$igcFileURL	=$actionData['flight']['linkIGC'];
				$igcZipFileURL	=$actionData['flight']['linkIGCzip'];
				$tempFilename=LEONARDO_ABS_PATH.'/'.$CONF['paths']['tmpigc'].'/'.$igcFilename;

				$hash=$actionData['flight']['validation']['hash'];
				$sameHashIDarray=flight::findSameHash( $hash );
				if (count($sameHashIDarray)>0 ) {
					$isFlightDup=0;

					$markFlightAsDisabled=1;
					$msg='';
					
					if ($CONF['servers']['list'][$actionData['flight']['serverID']]['allow_duplicate_flights']) {
						foreach($sameHashIDarray as $sameHashFlightInfo) {
							if ( $sameHashFlightInfo['serverID'] == $actionData['flight']['serverID'] ) { // from same server
								$isFlightDup=1;
								$msg.=" local flight: ".$sameHashFlightInfo['serverID'].'_'.$sameHashFlightInfo['ID']." , new entry:".$actionData['flight']['serverID'].'_'.$actionData['flight']['id'];
								break;
							} else {
								// we have a flight with same hash that is not from this specific server.
								// HERE we must make the decision whether to mark this flight as DISABLED
								// WE always mark this new flight as DISABLED because :
								// the local flight takes precedence anyway.
							
								// ONE case 
								// we are DHV mirror , the new flight is from DHV and there is a dup from XContest
								// we should insert, 
								
								// SO INSERT TAKES PRECEDENCE OVER LINKED FLIGHTS
							}
						
						}
					
					} else {					
						$isFlightDup=1;
					}
					
					if ($isFlightDup) {
						return array(-1,"Flight already exists : $msg");
						continue;
					}
				} 
				
				/*
				if ($CONF['servers']['list'][$actionData['flight']['serverID']]['allow_duplicate_flights']) {
					$sameHashIDarray=flight::findSameHash( $hash , $actionData['flight']['serverID'] );
					if (count($sameHashIDarray)>0 )  {
						return array(-1,"Flight already exists in local with ID: $sameHashID (dups allowed)");
						continue;
					} else {
						// $addFlightNote="*(Duplicate Flight)*";
					}
				
				} else {
					$sameHashIDarray=flight::findSameHash( $hash );
					if (count($sameHashIDarray)>0 ) 	 {
						return array(-1,"Flight already exists in local with ID: $sameHashID");
						continue;
					}
				}
				*/
				
				
			} else if ($e['action']==2) {	// update
			
				// This is not needed , we have found $flightIDlocal earlier and if it didnt exist we will insert it instead 
				/*
				$flightIDlocal=logReplicator::findFlight($actionData['flight']['serverID'],$actionData['flight']['id']);
				if (!$flightIDlocal) {
					return array(0,"logReplicator::processEntry : Flight with serverID ".$actionData['flight']['serverID']." and original ID : ".
							$actionData['flight']['id']." is not found in the local DB -> Wont update<BR>");
				}
				*/
				
				// echo "Will update flight $flightIDlocal<BR>";
				
			}
			
				$thisCat=$actionData['flight']['info']['cat']+0;
				
				
				// when we get data from leonardo servers, we just ignore these fields 
				// since they can be computed on the fly
				$originalURL = htmlDecode($actionData['flight']['linkDisplay']);
				$originalKML = htmlDecode($actionData['flight']['linkGE']) ;	
				if ( $actionData['flight']['serverID'] != 0 ) {
					global $CONF;
					if ( $CONF['servers']['list'][$actionData['flight']['serverID']]['isLeo'] == 1  ) {
						$originalURL='';
						$originalKML='';				
					}
				}
				
				$argArray=array(						
						"private"	=>$actionData['flight']['info']['private']+0,
						"cat"		=>$actionData['flight']['info']['gliderCat']+0,
						"linkURL"	=>$actionData['flight']['info']['linkURL'],
						"comments"	=>$actionData['flight']['info']['comments'],
						"glider"	=>$actionData['flight']['info']['glider'],
						"gliderBrandID"	=>$actionData['flight']['info']['gliderBrandID']+0,
						"category"	=> ($thisCat>=0?$thisCat:0),

						"dateAdded"		=>$actionData['flight']['dateAdded'],
						"originalURL"	=>$originalURL,
						"originalKML"	=>$originalKML,
						"original_ID"	=>$actionData['flight']['id'],
						"serverID"		=>$actionData['flight']['serverID'],
						"userServerID"	=>$actionData['flight']['serverID'],
						// "originalUserID"=>$actionData['flight']['pilot']['userID'],
						"originalUserID"=>$orgUserIDstr,
						"externalFlightType"=> $externalFlightType	,
						"allowDuplicates"=>($CONF['servers']['list'][$actionData['flight']['serverID']]['allow_duplicate_flights']+0),
				);
				// print_r($argArray);


				if ($e['action']==1 && ($sync_mode & SYNC_INSERT_FLIGHT_LOCAL &  SYNC_INSERT_FLIGHT_REPROCESS_LOCALLY)  ) {
				
					if (!$igcFileStr=fetchURL($igcFileURL,20) ) {
						return array(0,"logReplicator::processEntry() : Cannot Fetch $igcFileURL");
					}
					writeFile($tempFilename,$igcFileStr);
					list( $res,$flightID)=addFlightFromFile($tempFilename,0,$userIDstr,
									// $is_private,$gliderCat,$linkURL,$comments,$glider, $category,
									$argArray);
					if ($res!=1) { 
						return array(-128,"Problem: ".getAddFlightErrMsg($res,$flightID));
					} 
					return array(1,"Flight *pulled* OK with local ID $flightID");

				} else { 
					// if ( ( $e['action']==1 && $sync_mode & SYNC_INSERT_FLIGHT_LINK  ) || $e['action']==2 ){
					// inserting in LINK / LOCAL mode or updates - NOT reproccess
					if ( $e['action']==1) {
						$extFlight=new flight();
						// get igc if required
						if ($sync_mode & SYNC_INSERT_FLIGHT_LOCAL) {
							echo " Geting IGC file : ";
							
							$igcFileTmp=$e['tmpDir'].'/'.$actionData['flight']['id'].'.igc';
							
							if ( ! is_file($igcFileTmp) ) {
								echo "NOT in zip -> will fetch ...";
								if (!$igcFileStr=fetchURL($igcFileURL,20) ) {
									return array(0,"logReplicator::processEntry() : Cannot Fetch $igcFileURL");
								}
								writeFile($igcFileTmp,$igcFileStr);
							
							} else {
								echo "IN zip -> will use that ...";								
							}				
						}						
						
					} else {
						$extFlight=new flight();
						$extFlight->getFlightFromDB($flightIDlocal,0);
					}

					$igcFilename=$actionData['flight']['filename'];
					$igcFileURL	=$actionData['flight']['linkIGC'];				
	
	
					if ( $CONF['servers']['list'][$actionData['flight']['serverID']]['exclude_from_list'] ) {
						$extFlight->excludeFrom |= 3;
					}					
					if ( $CONF['servers']['list'][$actionData['flight']['serverID']]['exclude_from_league'] ) {
						$extFlight->excludeFrom |= 2;
					}
	
					foreach($argArray as $fieldName=>$fieldValue) {
						// if the flight is already present 
						// we must tkae care to honor ONLY 
						// the 1st bit of 'private' , the others are used locally !!
						if ($fieldName=='private') {
							if ( $fieldValue & 0x01 ) {
								$fieldValue= $extFlight->private | 0x01 ;
							} else {
								$fieldValue= $extFlight->private & 0xFE  ;
							}							
						}
						$extFlight->$fieldName=$fieldValue;
					}

					// echo " gliderBrandID : $extFlight->gliderBrandID #<BR>";
					$extFlight->takeoffID = $nearestTakeoffID;
					$extFlight->takeoffVinicity = $nearestDistance ;

					$extFlight->landingID = $nearestLandingID;
					$extFlight->landingVinicity = $nearestLandingDistance ;
					
					// no userid will be assgined to this flight since it will not be inserted locally
					// so userID= userServerID;
					
					// $extFlight->userID=$extFlight->originalUserID;
					
					// now we take care of mapping between users
					$extFlight->userID=$effectiveUserID;
					$extFlight->userServerID=$effectiveServerID;
					
					$extFlight->dateAdded	=$actionData['flight']['dateAdded'];

					$extFlight->DATE 		=$actionData['flight']['time']['date'];
					$extFlight->timezone 	=$actionData['flight']['time']['Timezone']+0;
					$extFlight->START_TIME 	=$actionData['flight']['time']['StartTime']+0;
					$extFlight->DURATION 	=$actionData['flight']['time']['Duration']+0;
					$extFlight->END_TIME	=$extFlight->START_TIME+$extFlight->DURATION;
					$extFlight->forceBounds	=$actionData['flight']['bounds']['forceBounds']+0;

					$extFlight->firstLon=$actionData['flight']['bounds']['firstLon']+0;
					$extFlight->firstLat=$actionData['flight']['bounds']['firstLat']+0;
					$extFlight->firstPointTM=$actionData['flight']['bounds']['firstTM']+0 ;
					$extFlight->lastLon=$actionData['flight']['bounds']['lastLon']+0;
					$extFlight->lastLat=$actionData['flight']['bounds']['lastLat']+0;
					$extFlight->lastPointTM=$actionData['flight']['bounds']['lastTM']+0 ;
					
					$firstPoint=new  gpsPoint();				
					$firstPoint->setLon( 	$actionData['flight']['bounds']['firstLon']);
					$firstPoint->setLat(	$actionData['flight']['bounds']['firstLat']);
					$firstPoint->gpsTime=(	$actionData['flight']['bounds']['firstTM'] % 86400);

					$lastPoint=new  gpsPoint();
					$lastPoint->setLon(		$actionData['flight']['bounds']['lastLon']);
					$lastPoint->setLat(		$actionData['flight']['bounds']['lastLat']);
					$lastPoint->gpsTime=(	$actionData['flight']['bounds']['lastTM'] % 86400);

					// $extFlight->FIRST_POINT=$firstPoint->to_IGC_Record();
					// $extFlight->LAST_POINT=$lastPoint->to_IGC_Record();

// not used!!
/*
					if (	is_array($actionData['flight']['turnpoints']) ) {
						foreach ($actionData['flight']['turnpoints'] as $i=>$tp){
							$tpNum=$tp['id'];
							$tpPoint=new gpsPoint();
							$tpPoint->setLon($tp['lon']);
							$tpPoint->setLat($tp['lat']);
							$varname="turnpoint$tpNum" ;
							$extFlight->$varname = $tpPoint->getLatMin().' '.$tpPoint->getLonMin() ;
						}					
					}
									*/
					
					if ($getValidationData) {
						$extFlight->validated =$actionData['flight']['validation']['validated'];
						$extFlight->grecord =$actionData['flight']['validation']['grecord'];
						$extFlight->hash=$actionData['flight']['validation']['hash'];
						$extFlight->validationMessage =$actionData['flight']['validation']['validationMessage'];
						$extFlight->airspaceCheck =$actionData['flight']['validation']['airspaceCheck']+0;
						$extFlight->airspaceCheckFinal =$actionData['flight']['validation']['airspaceCheckFinal']+0;
						$extFlight->airspaceCheckMsg =$actionData['flight']['validation']['airspaceCheckMsg'];
					}
					
					$getScoreDataExtra=0;
					$getScoreDataExtraMissing=0;
					
					if ( $getScoreData ) {
						// we should get these from the [score] section  also 
						$extFlight->BEST_FLIGHT_TYPE=$actionData['flight']['stats']['FlightType'];
						$extFlight->FLIGHT_KM	=$actionData['flight']['stats']['XCdistance'];
						$extFlight->FLIGHT_POINTS=$actionData['flight']['stats']['XCscore'];

						$extFlight->LINEAR_DISTANCE	=$actionData['flight']['stats']['StraightDistance']+0;
						$extFlight->MAX_LINEAR_DISTANCE=$actionData['flight']['stats']['MaxStraightDistance']+0;

						$extFlight->MEAN_SPEED	=$actionData['flight']['stats']['MeanGliderSpeed']+0;
						$extFlight->MAX_SPEED	=$actionData['flight']['stats']['MaxSpeed']+0;
						$extFlight->MAX_VARIO	=$actionData['flight']['stats']['MaxVario']+0;
						$extFlight->MIN_VARIO	=$actionData['flight']['stats']['MinVario']+0;
						$extFlight->MAX_ALT		=$actionData['flight']['stats']['MaxAltASL']+0;
						$extFlight->MIN_ALT		=$actionData['flight']['stats']['MinAltASL']+0;
						$extFlight->TAKEOFF_ALT	=$actionData['flight']['stats']['TakeoffAlt']+0;
						
						
						if ( is_array( $actionData['flight']['score'] ) && count($actionData['flight']['score']) >0 ) {
							
							require_once dirname(__FILE__).'/CL_flightScore.php';			
							$flightScore=new flightScore($extFlight->flightID);			
							// we have the score array in $actionData['score']				
							$sArr=& $actionData['flight']['score'];
							$flightScore->fromSyncArray($sArr);
							
							$extFlight->flightScore=$flightScore;
							$getScoreDataExtra=1;							

							$extFlight->BEST_FLIGHT_TYPE=$flightScore->bestScoreType;
							$extFlight->FLIGHT_KM		=$flightScore->bestDistance*1000;
							$extFlight->FLIGHT_POINTS	=$flightScore->bestScore;

							// check for missing linear distance
							if ($extFlight->LINEAR_DISTANCE	==0 && $extFlight->MAX_LINEAR_DISTANCE>0 ){
								// echo "compute MAxtakeoffDistance";
								$extFlight->LINEAR_DISTANCE=$flightScore->computeMaxTakeoffDistance($firstPoint);								
							}
														
							//put also in scores table, the flight is sure to be present in flights table
							if ($e['action']==2) { // update so we already know the flightID
								$flightScore->putToDB(1,1);
							}
						} else {
							$getScoreDataExtraMissing=1;
						}
						
					}
					
					// we also have [gliderBrand] => GRADIENT													
					$extFlight->checkGliderBrand($actionData['flight']['info']['gliderBrand']);

					if ( $e['action']==1) {
						
						if ( $sync_mode & SYNC_INSERT_FLIGHT_LOCAL) {
							$tmpPilot=new pilot($effectiveServerID,$effectiveUserID);
							$tmpPilot->createDirs();
							
							$extFlight->filename=$igcFilename;
							$extFlight->checkDirs();
							if ($DBGlvl>0) echo "Moving file into place: ".$extFlight->getIGCFilename()."<BR>";
							while ( is_file($extFlight->getIGCFilename()) ) {
								if ($DBGlvl>0) echo "Same filename is already present<BR>";
								$extFlight->filename='_'.$extFlight->filename;
							}
							@rename($igcFileTmp, $extFlight->getIGCFilename() );
							
							$opString='*inserted*';
						}	else {
							$opString='*linked*';
						}		
						
						// insert flight
						$extFlight->putFlightToDB(0);
						
						// take care of sme flights (hide /unhide)
						$extFlight->hideSameFlights();
						
						if ($getScoreData && $getScoreDataExtra) {
							$flightScore->flightID=$extFlight->flightID;
							$flightScore->putToDB(1,1);
						} else if ( $getScoreDataExtraMissing &&
									$CONF['servers']['list'][$actionData['flight']['serverID']]['rescore_if_missing']  &&
									( $sync_mode & SYNC_INSERT_FLIGHT_LOCAL)   ) {		
								echo " [Re-score] ";					
								$extFlight->computeScore();									
							
						}
						
						return array(1,"Flight $opString OK $addFlightNote with local ID $extFlight->flightID");
					} else {
						//update flight
						$extFlight->putFlightToDB(1);
						if ( $getScoreDataExtraMissing &&
									$CONF['servers']['list'][$actionData['flight']['serverID']]['rescore_if_missing']  &&
									( $sync_mode & SYNC_INSERT_FLIGHT_LOCAL)   ) {
							echo " [Re-score] ";
							require_once dirname(__FILE__).'/CL_flightScore.php';			
							$flightScore=new flightScore($extFlight->flightID);									
							$flightScore->getFromDB();
							if ($flightScore->gotValues) 
								echo "[not needed] ";
							else 
								$extFlight->computeScore();									
						} 
						return array(1,"Flight with local ID $flightIDlocal UPDATED OK");
					}
				}

			
			return array(0,"Unknown error, we should have returned by this far...");
		}		 // if type==1

	}


} // end of class

?>
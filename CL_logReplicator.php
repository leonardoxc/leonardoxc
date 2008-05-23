<? 
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
		$query="SELECT * FROM $remotePilotsTable  WHERE remoteServerID=$serverID AND remoteUserID=".$pilotArray['userID'];	
		$res= $db->sql_query($query);		
		if($res <= 0){
			echo("<H3> Error in findFlight query! $query</H3>\n");
			return array(0,0);
		}		
		if (  $row = $db->sql_fetchrow($res) ) {
			if ($row['userID']) 
				return array($row['serverID'],$row['userID']);		
		}
		
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
	  
	  $query="SELECT * FROM $flightsTable  WHERE original_ID=$flightIDoriginal AND serverID=$serverID";

	  $res= $db->sql_query($query);	
	  # Error checking
	  if($res <= 0){
		 echo("<H3> Error in findFlight query! $query</H3>\n");
		 exit();
	  }
		
	  if (! $row = $db->sql_fetchrow($res) ) {
		  return 0;	  
	  } else {
	  	return $row['ID'];
	  }
	  
	}
	
	function processEntry($serverID,$e,$sync_mode=SYNC_INSERT_FLIGHT_LINK) {
		global $flightsAbsPath,$CONF;
		global $DBGcat,$DBGlvl;
		if ($DBGlvl>0) {
			echo "<PRE>";
			print_r($e);
			echo "</PRE>";
		}

		if ($e['type']=='1') { // flight

			if ($e['action']==4) {	// delete
				$flightIDlocal=logReplicator::findFlight($e['ActionXML']['flight']['serverID'],$e['ActionXML']['flight']['id']);
				if (!$flightIDlocal) {
					return array(0,"logReplicator::processEntry : Flight with serverID ".$e['ActionXML']['flight']['serverID']." and original ID : ".
							$e['ActionXML']['flight']['id']." is not found in the local DB -> Wont delete it");
				}
				// echo "Will delete flight $flightIDlocal<BR>";
				
				$extFlight=new flight();			
				$extFlight->getFlightFromDB($flightIDlocal,0);
				$extFlight->deleteFlight();			
				return array(1,"Flight with local ID: $flightIDlocal DELETED");
			}

			if ($e['action']==16) {	// rename tracklog
				$flightIDlocal=logReplicator::findFlight($e['serverId'],$e['id']);
				if (!$flightIDlocal) {
					return array(0,"logReplicator::processEntry : Flight with serverID ".$e['serverId']." and original ID : ".
							$e['id']." is not found in the local DB -> Wont rename tracklog<BR>");
				}
				$extFlight=new flight();			
				$extFlight->getFlightFromDB($flightIDlocal,0);		
				$extFlight->renameTracklog($e['ActionXML']['newFilename'],$e['ActionXML']['oldFilename']);
				return array(1,"Flight tracklog renamed for local ID $flightIDlocal");
			}

			if ($e['action']==8) {	// scoring info
			
				$flightIDlocal=logReplicator::findFlight($e['serverId'],$e['id']);
				if (!$flightIDlocal) {
					return array(0,"logReplicator::processEntry : Flight with serverID ".$e['serverId']." and original ID : ".
							$e['id']." is not found in the local DB -> Wont update scoring<BR>");
				}
								
				// echo "Will update scoring  info for flight $flightIDlocal<BR>";

				// no need to pull flight info
				//$extFlight=new flight();			
				//$extFlight->getFlightFromDB($flightIDlocal,0);					

				require_once dirname(__FILE__).'/CL_flightScore.php';			
				$flightScore=new flightScore($flightIDlocal);
			
				// we have the score array in $e['ActionXML']['score']
				// $sArr=$e['ActionXML']['score'];
				$sArr=$e['ActionXML']['score'];

				$flightScore->bestScoreType=$sArr['XCtype'];
				$flightScore->bestScore=$sArr['XCdistance'];
				$flightScore->bestDistance=$sArr['XCscore'];
				$flightScore->scores=array();
				foreach($sArr['scores'] as $i=>$score) {
					$mID=$score['XCscoreMethod'];
					$type=$flightScore->flightTypesID[ $score['XCtype'] ];

					$flightScore->scores[$mID][$type] =
						array (
							'isBest'=>$score['isBest'],
							'distance'=>$score['XCdistance'],
							'score'=>$score['XCscore'],
						);

					if ($score['isBest']) {
						$flightScore->scores[$mID]['bestScoreType'] = $type;
						$flightScore->scores[$mID]['bestScore'] = $score['XCscore'];
					}
					
					foreach($score['turnpoints'] as $j=>$tp) {
						$thisTP=new gpsPoint();
						$thisTP->setLat($tp['lat']);
						$thisTP->setLon($tp['lon']);
						$thisTP->gpsTime=$tp['UTCsecs'];
						
						$flightScore->scores[$mID][$type]['tp'][ $tp['id'] ] = $thisTP->to_IGC_Record();
					}

				}
/*
				echo "<pre>";
				print_r($flightScore->scores);
				echo "</pre>";
*/
				//put also in scores table, the flight is sure to be present in flights table
				$flightScore->putToDB(1,1);
		
		
				return array(1,"Flight Score was *pulled* for local ID $flightIDlocal");
			}
			
			// now deal with add/update
			$getValidationData=1;
			$getScoreData =1;		

			//	check 'alien' pilot  and insert him or update him anyway
			$userServerID=$e['ActionXML']['flight']['serverID'];
			if ($userServerID==0)  $userServerID=$serverID;				

			list ($effectiveServerID,$effectiveUserID )= 
					logReplicator::checkPilot($userServerID,$e['ActionXML']['flight']['pilot']);
					
			// $userIDstr=$userServerID.'_'.$e['ActionXML']['flight']['pilot']['userID'];
			$userIDstr=$effectiveServerID.'_'.$effectiveUserID;
						
			list($nearestTakeoffID,$nearestDistance)=logReplicator::checkLocation($userServerID,
								$e['ActionXML']['flight']['location'],$e['ActionXML']['flight']['bounds']);

			// get only the first 2 bits
			$externalFlightType=$sync_mode & 0x03 ;

			if ($e['action']==1) {	// add
				$igcFilename=$e['ActionXML']['flight']['filename'];
				$igcFileURL	=$e['ActionXML']['flight']['linkIGC'];
				$igcZipFileURL	=$e['ActionXML']['flight']['linkIGCzip'];
				$tempFilename=$flightsAbsPath.'/'.$igcFilename;

				$hash=$e['ActionXML']['flight']['validation']['hash'];
				$sameHashID=flight::findSameHash( $hash );
				if ($sameHashID>0) 	 {
					return array(-1,"Flight already exists in local with ID: $sameHashID");
					continue;
				}
			} else if ($e['action']==2) {	// update
				$flightIDlocal=logReplicator::findFlight($e['ActionXML']['flight']['serverID'],$e['ActionXML']['flight']['id']);
				if (!$flightIDlocal) {
					return array(0,"logReplicator::processEntry : Flight with serverID ".$e['ActionXML']['flight']['serverID']." and original ID : ".
							$e['ActionXML']['flight']['id']." is not found in the local DB -> Wont update<BR>");
				}
				// echo "Will update flight $flightIDlocal<BR>";
				
			}

				$argArray=array(
						"private"	=>$e['ActionXML']['flight']['info']['private'],
						"cat"		=>$e['ActionXML']['flight']['info']['gliderCat'],
						"linkURL"	=>$e['ActionXML']['flight']['info']['linkURL'],
						"comments"	=>$e['ActionXML']['flight']['info']['comments'],
						"glider"	=>$e['ActionXML']['flight']['info']['glider'],
						"gliderBrandID"	=>$e['ActionXML']['flight']['info']['gliderBrandID'],
						"category"	=>$e['ActionXML']['flight']['info']['cat'],

						"dateAdded"		=>$e['ActionXML']['flight']['dateAdded'],
						"originalURL"	=>$e['ActionXML']['flight']['linkDisplay'],
						"originalKML"	=>$e['ActionXML']['flight']['linkGE'],								
						"original_ID"	=>$e['ActionXML']['flight']['id'],
						"serverID"		=>$e['ActionXML']['flight']['serverID'],
						"userServerID"	=>$e['ActionXML']['flight']['serverID'],
						"originalUserID"=>$e['ActionXML']['flight']['pilot']['userID'],
						"externalFlightType"=> $externalFlightType	,

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
							
							$igcFileTmp=$e['tmpDir'].'/'.$e['ActionXML']['flight']['id'].'.igc';
							
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

					$igcFilename=$e['ActionXML']['flight']['filename'];
					$igcFileURL	=$e['ActionXML']['flight']['linkIGC'];				
	
					foreach($argArray as $fieldName=>$fieldValue) {
						$extFlight->$fieldName=$fieldValue;
					}

					// echo " gliderBrandID : $extFlight->gliderBrandID #<BR>";
					$extFlight->takeoffID = $nearestTakeoffID;
					$extFlight->takeoffVinicity = $nearestDistance ;

					// no userid will be assgined to this flight since it will not be inserted locally
					// so userID= userServerID;
					
					// $extFlight->userID=$extFlight->originalUserID;
					
					// now we take care of mapping between users
					$extFlight->userID=$effectiveUserID;
					$extFlight->userServerID=$effectiveServerID;
					
					$extFlight->dateAdded	=$e['ActionXML']['flight']['dateAdded'];

					$extFlight->DATE 		=$e['ActionXML']['flight']['time']['date'];
					$extFlight->timezone 	=$e['ActionXML']['flight']['time']['Timezone'];
					$extFlight->START_TIME 	=$e['ActionXML']['flight']['time']['StartTime'];
					$extFlight->DURATION 	=$e['ActionXML']['flight']['time']['Duration'];
					$extFlight->END_TIME	=$extFlight->START_TIME+$extFlight->DURATION;
					$extFlight->forceBounds	=$e['ActionXML']['flight']['bounds']['forceBounds'];

					$extFlight->firstPointLon=$e['ActionXML']['flight']['bounds']['firstLon']+0;
					$extFlight->firstPointLat=$e['ActionXML']['flight']['bounds']['firstLat']+0;
					$extFlight->firstPointTM=$e['ActionXML']['flight']['bounds']['firstTM']+0 ;
					$extFlight->lastPointLon=$e['ActionXML']['flight']['bounds']['lastLon']+0;
					$extFlight->lastPointLat=$e['ActionXML']['flight']['bounds']['lastLat']+0;
					$extFlight->lastPointTM=$e['ActionXML']['flight']['bounds']['lastTM'] ;
					
					$firstPoint=new  gpsPoint();
					$lastPoint=new  gpsPoint();
					$firstPoint->setLon( 	$e['ActionXML']['flight']['bounds']['firstLon']);
					$firstPoint->setLat(	$e['ActionXML']['flight']['bounds']['firstLat']);
					$firstPoint->gpsTime=(	$e['ActionXML']['flight']['bounds']['firstTM'] % 86400);
					
					$lastPoint->setLon(		$e['ActionXML']['flight']['bounds']['lastLon']);
					$lastPoint->setLat(		$e['ActionXML']['flight']['bounds']['lastLat']);
					$lastPoint->gpsTime=(	$e['ActionXML']['flight']['bounds']['lastTM'] % 86400);

					$extFlight->FIRST_POINT=$firstPoint->to_IGC_Record();
					$extFlight->LAST_POINT=$lastPoint->to_IGC_Record();

					foreach ($e['ActionXML']['flight']['turnpoints'] as $i=>$tp){
						$tpNum=$tp['id'];
						$tpPoint=new gpsPoint();
						$tpPoint->setLon($tp['lon']);
						$tpPoint->setLat($tp['lat']);
						$varname="turnpoint$tpNum" ;
						$extFlight->$varname = $tpPoint->getLatMin().' '.$tpPoint->getLonMin() ;
					}					

					if ($getValidationData) {
						$extFlight->validated =$e['ActionXML']['flight']['validation']['validated'];
						$extFlight->grecord =$e['ActionXML']['flight']['validation']['grecord'];
						$extFlight->hash=$e['ActionXML']['flight']['validation']['hash'];
						$extFlight->validationMessage =$e['ActionXML']['flight']['validation']['validationMessage'];
						$extFlight->airspaceCheck =$e['ActionXML']['flight']['validation']['airspaceCheck'];
						$extFlight->airspaceCheckFinal =$e['ActionXML']['flight']['validation']['airspaceCheckFinal'];
						$extFlight->airspaceCheckMsg =$e['ActionXML']['flight']['validation']['airspaceCheckMsg'];
					}
					
					if ( $getScoreData ) {
						$extFlight->BEST_FLIGHT_TYPE=$e['ActionXML']['flight']['stats']['FlightType'];
						$extFlight->LINEAR_DISTANCE	=$e['ActionXML']['flight']['stats']['StraightDistance']+0;
						$extFlight->MAX_LINEAR_DISTANCE=$e['ActionXML']['flight']['stats']['MaxStraightDistance']+0;
						$extFlight->FLIGHT_KM	=$e['ActionXML']['flight']['stats']['XCdistance'];
						$extFlight->FLIGHT_POINTS=$e['ActionXML']['flight']['stats']['XCscore'];
						$extFlight->MEAN_SPEED	=$e['ActionXML']['flight']['stats']['MeanGliderSpeed']+0;
						$extFlight->MAX_SPEED	=$e['ActionXML']['flight']['stats']['MaxSpeed'];
						$extFlight->MAX_VARIO	=$e['ActionXML']['flight']['stats']['MaxVario'];
						$extFlight->MIN_VARIO	=$e['ActionXML']['flight']['stats']['MinVario'];
						$extFlight->MAX_ALT		=$e['ActionXML']['flight']['stats']['MaxAltASL'];
						$extFlight->MIN_ALT		=$e['ActionXML']['flight']['stats']['MinAltASL'];
						$extFlight->TAKEOFF_ALT	=$e['ActionXML']['flight']['stats']['TakeoffAlt'];
					}
					
					$extFlight->checkGliderBrand();

					if ( $e['action']==1) {
						
						if ( $sync_mode & SYNC_INSERT_FLIGHT_LOCAL) {
							$tmpPilot=new pilot($effectiveServerID,$effectiveUserID);
							$tmpPilot->createDirs();
							
							$extFlight->filename=$igcFilename;
							$extFlight->checkDirs();
							if ($DBGlvl>0) echo "Moving file into place: ".$extFlight->getIGCFilename()."<BR>";	
							@rename($igcFileTmp, $extFlight->getIGCFilename() );
							
							$opString='*inserted*';
						}	else {
							$opString='*linked*';
						}		
						
						// insert flight
						$extFlight->putFlightToDB(0);

						return array(1,"Flight $opString OK with local ID $extFlight->flightID");
					} else {
						//update flight
						$extFlight->putFlightToDB(1);
						return array(1,"Flight with local ID $flightIDlocal UDDATED OK");
					}
				}

				/* now take care of photos 
				
					<photos>
						<photo>
						<id>1</id>
						<name>164_6443.jpg</name>
						<link>http://www.sky.gr/modules/leonardo/flights/11/photos/2004/164_6443.jpg</link>
						</photo>
					</photos>
				*/
			
			return array(0,"Unknown error, we should have returned by this far...");
		}		 // if type==1

	}


} // end of class

?>
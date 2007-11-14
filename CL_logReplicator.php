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
16 => Create charts (flight only)
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

define('SYNC_INSERT_FLIGHT_LINK',1);
define('SYNC_INSERT_FLIGHT_LOCAL',2);


class logReplicator { 

	function logReplicator() {
	}



	function checkLocation($serverID,$locationArray) {
/*
    [takeoffID] => 8869
    [serverID] => 1
    [takeoffVinicity] => 23.635354591202
    [takeoffName] => Torrey Pines
    [takeoffNameInt] => Torrey Pines
    [takeoffCountry] => US
	[firstLat] => 20.3
	[firstLon] => 40.34
	[takeoffLocation] => string
	[takeoffLocationInt] => string 
	[takeoffLat] => 20.5
	[takeoffLon] => 40.3
*/
		//  print_r($locationArray);

		list( $nearestTakeoffID,$nearestDistance )=findNearestWaypoint($locationArray['takeoffLat'],$locationArray['takeoffLon']);

		// echo "nearest takeoff :  $nearestTakeoffID,$nearestDistance <BR>";

		if ( $nearestDistance < $locationArray['takeoffVinicity'] ) { // we will use our waypoint
			return array($nearestTakeoffID,$nearestDistance );
		} else { // we will import this takeoff and use that instead
			$newWaypoint =new waypoint();
			$newWaypoint->lat =$locationArray['takeoffLat'];
			$newWaypoint->lon =$locationArray['takeoffLon'];
			$newWaypoint->name =$locationArray['takeoffName'];
			$newWaypoint->type = 1000 ; // takeoff
			$newWaypoint->intName =$locationArray['takeoffNameInt'];
			$newWaypoint->location =$locationArray['takeoffLocation'];
			$newWaypoint->intLocation =$locationArray['takeoffLocationInt'];
			$newWaypoint->countryCode =$locationArray['takeoffCountry'];

			$newWaypoint->link ='';
			$newWaypoint->description ='';
			$newWaypoint->putToDB(0);

			return array($newWaypoint->waypointID,$locationArray['takeoffVinicity']);
		}
	}

	function checkPilot($serverID,$pilotArray){
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
		global $flightsAbsPath;
		global $DBGcat,$DBGlvl;
		if ($DBGlvl>0) {
			echo "<PRE>";
			print_r($e);
			echo "</PRE>";
		}

		if ($e['type']=='1') { // flight
			
			$getValidationData=1;
			$getScoreData =1;
			

			//	check 'alien' pilot  and insert him or update him anyway
			$userServerID=$e['ActionXML']['flight']['serverID'];
			if ($userServerID==0)  $userServerID=$serverID;	
			$userIDstr=$userServerID.'_'.$e['ActionXML']['flight']['pilot']['userID'];

			logReplicator::checkPilot($userServerID,$e['ActionXML']['flight']['pilot']);
			list($nearestTakeoffID,$nearestDistance)=logReplicator::checkLocation($userServerID,$e['ActionXML']['flight']['location']);

			if ($e['action']==1) {	// add
				$igcFilename=$e['ActionXML']['flight']['filename'];
				$igcFileURL	=$e['ActionXML']['flight']['linkIGC'];
				$tempFilename=$flightsAbsPath.'/'.$igcFilename;
	
/*
				$is_private	=$e['ActionXML']['flight']['info']['private'];
				$gliderCat	=$e['ActionXML']['flight']['info']['gliderCat'];
				$linkURL	=$e['ActionXML']['flight']['info']['linkURL'];
				$comments	=$e['ActionXML']['flight']['info']['comments'];
				$glider		=$e['ActionXML']['flight']['info']['glider'];
				$category	=$e['ActionXML']['flight']['info']['cat'];
*/
				$argArray=array(
								"private"	=>$e['ActionXML']['flight']['info']['private'],
								"cat"		=>$e['ActionXML']['flight']['info']['gliderCat'],
								"linkURL"	=>$e['ActionXML']['flight']['info']['linkURL'],
								"comments"	=>$e['ActionXML']['flight']['info']['comments'],
								"glider"	=>$e['ActionXML']['flight']['info']['glider'],
								"category"	=>$e['ActionXML']['flight']['info']['cat'],

								"dateAdded"		=>$e['ActionXML']['flight']['dateAdded'],
								"originalURL"	=>$e['ActionXML']['flight']['linkDisplay'],
								"originalKML"	=>$e['ActionXML']['flight']['linkGE'],								
								"original_ID"	=>$e['ActionXML']['flight']['id'],
								"serverID"		=>$e['ActionXML']['flight']['serverID'],
								"userServerID"	=>$e['ActionXML']['flight']['serverID'],
								"originalUserID"=>$e['ActionXML']['flight']['pilot']['userID'],
								"gliderBrandID"	=>$e['ActionXML']['flight']['gliderBrandID'],
				);

				if ($sync_mode & SYNC_INSERT_FLIGHT_LOCAL  ) {
					if (!$igcFileStr=fetchURL($igcFileURL,20) ) {
						return array(0,"logReplicator::processEntry() : Cannot Fetch $igcFileURL");
					}
					writeFile($tempFilename,$igcFileStr);
					list( $res,$flightID)=addFlightFromFile($tempFilename,0,$userIDstr,
									// $is_private,$gliderCat,$linkURL,$comments,$glider, $category,
									$argArray);
					if ($res!=1) { 
						return array(0,"Problem: ".getAddFlightErrMsg($res,$flightID));
					} 
					return array(1,"Flight *pulled* OK with local ID $flightID");

				} else {
					$extFlight=new flight();

					$igcFilename=$e['ActionXML']['flight']['filename'];
					$igcFileURL	=$e['ActionXML']['flight']['linkIGC'];				
	
					foreach($argArray as $fieldName=>$fieldValue) {
						$extFlight->$fieldName=$fieldValue;
					}

					$extFlight->takeoffID = $nearestTakeoffID;
					$extFlight->takeoffVinicity = $nearestDistance ;

					// no userid will be assgined to this flight since it will not be inserted locally
					// so userID= userServerID;
					$extFlight->userID=$extFlight->originalUserID;

					$extFlight->DATE =$e['ActionXML']['flight']['time']['date'];
					$extFlight->timezone =$e['ActionXML']['flight']['time']['Timezone'];
					$extFlight->START_TIME =$e['ActionXML']['flight']['time']['StartTime'];
					$extFlight->DURATION =$e['ActionXML']['flight']['time']['Duration'];
					$extFlight->END_TIME=$extFlight->START_TIME+$extFlight->DURATION;
										
					if ($getValidationData) {
						$extFlight->validated =$e['ActionXML']['flight']['validation']['validated'];
						$extFlight->grecord =$e['ActionXML']['flight']['validation']['grecord'];
						$extFlight->validationMessage =$e['ActionXML']['flight']['validation']['validationMessage'];
						$extFlight->airspaceCheck =$e['ActionXML']['flight']['validation']['airspaceCheck'];
						$extFlight->airspaceCheckFinal =$e['ActionXML']['flight']['validation']['airspaceCheckFinal'];
						$extFlight->airspaceCheckMsg =$e['ActionXML']['flight']['validation']['airspaceCheckMsg'];
					}
					
					if ( $getScoreData ) {
						$extFlight->BEST_FLIGHT_TYPE=$e['ActionXML']['flight']['stats']['FlightType'];
						$extFlight->LINEAR_DISTANCE	=$e['ActionXML']['flight']['stats']['StraightDistance'];
						$extFlight->FLIGHT_KM	=$e['ActionXML']['flight']['stats']['XCdistance'];
						$extFlight->FLIGHT_POINTS=$e['ActionXML']['flight']['stats']['XCscore'];
						$extFlight->MAX_SPEED	=$e['ActionXML']['flight']['stats']['MaxSpeed'];
						$extFlight->MAX_VARIO	=$e['ActionXML']['flight']['stats']['MaxVario'];
						$extFlight->MIN_VARIO	=$e['ActionXML']['flight']['stats']['MinVario'];
						$extFlight->MAX_ALT		=$e['ActionXML']['flight']['stats']['MaxAltASL'];
						$extFlight->MIN_ALT		=$e['ActionXML']['flight']['stats']['MinAltASL'];
						$extFlight->TAKEOFF_ALT	=$e['ActionXML']['flight']['stats']['TakeoffAlt'];
					}
					
					$extFlight->checkGliderBrand();

					// insert flight
					$extFlight->putFlightToDB(0);

					return array(1,"Flight *linked* OK with local ID $extFlight->flightID");

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
				

			} else if ($e['action']==2) {	// edit / update
				$flightIDlocal=logReplicator::findFlight($e['ActionXML']['flight']['serverID'],$e['ActionXML']['flight']['id']);
				if (!$flightIDlocal) {
					return array(0,"logReplicator::processEntry : Flight with serverID ".$e['ActionXML']['flight']['serverID']." and original ID : ".
							$e['ActionXML']['flight']['id']." is not found in the local DB -> Wont update<BR>");
				}
				echo "Will update flight $flightIDlocal<BR>";
				
				$extFlight=new flight();
				$extFlight->getFlightFromDB($flightIDlocal);
				
				$extFlight->glider	=$e['ActionXML']['flight']['info']['glider'];
				$extFlight->gliderBrandID	=$e['ActionXML']['flight']['info']['gliderBrandID'];
				$extFlight->cat		=$e['ActionXML']['flight']['info']['gliderCat'];
				$extFlight->category=$e['ActionXML']['flight']['info']['cat'];
				$extFlight->linkURL =$e['ActionXML']['flight']['info']['linkURL'];
				$extFlight->private	=$e['ActionXML']['flight']['info']['private'];
				$extFlight->comments=$e['ActionXML']['flight']['info']['comments'];
				
				$extFlight->DATE =$e['ActionXML']['flight']['time']['date'];
				$extFlight->timezone =$e['ActionXML']['flight']['time']['Timezone'];
				$extFlight->START_TIME =$e['ActionXML']['flight']['time']['StartTime'];
				$extFlight->DURATION =$e['ActionXML']['flight']['time']['Duration'];
				$extFlight->END_TIME=$extFlight->START_TIME+$extFlight->DURATION;
				
				if ($getValidationData) {
					$extFlight->validated =$e['ActionXML']['flight']['validation']['validated'];
					$extFlight->grecord =$e['ActionXML']['flight']['validation']['grecord'];
					$extFlight->validationMessage =$e['ActionXML']['flight']['validation']['validationMessage'];
					$extFlight->airspaceCheck =$e['ActionXML']['flight']['validation']['airspaceCheck'];
					$extFlight->airspaceCheckFinal =$e['ActionXML']['flight']['validation']['airspaceCheckFinal'];
					$extFlight->airspaceCheckMsg =$e['ActionXML']['flight']['validation']['airspaceCheckMsg'];
				}
				
				if ( $getScoreData ) {
					$extFlight->BEST_FLIGHT_TYPE=$e['ActionXML']['flight']['stats']['FlightType'];
					$extFlight->LINEAR_DISTANCE	=$e['ActionXML']['flight']['stats']['StraightDistance'];
					$extFlight->FLIGHT_KM	=$e['ActionXML']['flight']['stats']['XCdistance'];
					$extFlight->FLIGHT_POINTS=$e['ActionXML']['flight']['stats']['XCscore'];
					$extFlight->MAX_SPEED	=$e['ActionXML']['flight']['stats']['MaxSpeed'];
					$extFlight->MAX_VARIO	=$e['ActionXML']['flight']['stats']['MaxVario'];
					$extFlight->MIN_VARIO	=$e['ActionXML']['flight']['stats']['MinVario'];
					$extFlight->MAX_ALT		=$e['ActionXML']['flight']['stats']['MaxAltASL'];
					$extFlight->MIN_ALT		=$e['ActionXML']['flight']['stats']['MinAltASL'];
					$extFlight->TAKEOFF_ALT	=$e['ActionXML']['flight']['stats']['TakeoffAlt'];
				}

				$extFlight->checkGliderBrand();

				$extFlight->putFlightToDB(1);
				return array(1,"Flight updated OK");				

			} else if ($e['action']==4) {	// delete
				$flightIDlocal=logReplicator::findFlight($e['ActionXML']['flight']['serverID'],$e['ActionXML']['flight']['id']);
				if (!$flightIDlocal) {
					return array(0,"logReplicator::processEntry : Flight with serverID ".$e['ActionXML']['flight']['serverID']." and original ID : ".
							$e['ActionXML']['flight']['id']." is not found in the local DB -> Wont delete it");
				}
				echo "Will delete flight $flightIDlocal<BR>";
				
				$extFlight=new flight();			
				$extFlight->deleteFlight();			
				return array(1,"Flight deleted OK");
			}
			return array(0,"Unknown error, this should not happen");
		}		 // if type==1

	}


} // end of class

?>
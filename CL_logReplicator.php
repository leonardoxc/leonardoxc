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

class logReplicator { 

	function logReplicator() {
	}



	function checkPilot($serverID,$pilotArray){
		/*  [pilot] => Array
			(
				[userID] => 347
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
		//$pilot->FirstName=$pilotArray['userName'];
		$pilot->FirstName=$pilotArray['pilotFirstName'];
		$pilot->LastName=$pilotArray['pilotLastName'];
		$pilot->countryCode =$pilotArray['pilotCountry'];
		$pilot->Birthdate=$pilotArray['pilotBirthdate'];
		$pilot->Sex=$pilotArray['pilotSex'];

		$pilot->putToDB($update);
	}

	function processEntry($serverID,$e) {
		global $flightsAbsPath;
		echo "<PRE>";
		print_r($e);
		echo "</PRE>";
		if ($e['type']=='1') { // flight
			$igcFilename=$e['ActionXML']['flight']['filename'];
			$igcFileURL	=$e['ActionXML']['flight']['linkIGC'];
			$tempFilename=$flightsAbsPath.'/'.$igcFilename;

			$userServerID=$e['ActionXML']['flight']['serverID'];
			if ($userServerID==0)  $userServerID=$serverID;

			$userID=$userServerID.'_'.$e['ActionXML']['flight']['pilot']['userID'];

			logReplicator::checkPilot($userServerID,$e['ActionXML']['flight']['pilot']);

			$is_private	=$e['ActionXML']['flight']['info']['private'];
			$gliderCat	=$e['ActionXML']['flight']['info']['gliderCat'];
			$linkURL	=$e['ActionXML']['flight']['info']['linkURL'];
			$comments	=$e['ActionXML']['flight']['info']['comments'];
			$glider		=$e['ActionXML']['flight']['info']['glider'];
			$category	=$e['ActionXML']['flight']['info']['cat'];
			if (!$igcFileStr=fetchURL($igcFileURL,20) ) {
				echo "logReplicator::processEntry() : Cannot Fetch $igcFileURL<BR>";
				return 0;
			}
			writeFile($tempFilename,$igcFileStr);
			list( $res,$flightID)=addFlightFromFile($tempFilename,0,$userID,$is_private,$gliderCat,$linkURL,$comments,$glider, $category);
			if ($res!=1) { 
				echo "Problem: ".getAddFlightErrMsg($res,$flightID)."<BR>";
			} else { 
				echo "flight pulled OK with local ID $flightID<BR>";
			}
		}		
	}


} // end of class

?>
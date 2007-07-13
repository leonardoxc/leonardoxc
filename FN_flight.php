<?
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://leonardo.thenet.gr                                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

require_once dirname(__FILE__).'/FN_functions.php';
require_once dirname(__FILE__).'/FN_output.php';
require_once dirname(__FILE__).'/CL_flightData.php';

define("ADD_FLIGHT_ERR_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE",-1);
define("ADD_FLIGHT_ERR_NO_SUCH_FILE",-2);
define("ADD_FLIGHT_ERR_FILE_DOESNT_END_IN_IGC",-3);
define("ADD_FLIGHT_ERR_THIS_ISNT_A_VALID_IGC_FILE",-4);
define("ADD_FLIGHT_ERR_SAME_DATE_FLIGHT",-5);
define("ADD_FLIGHT_ERR_SAME_FILENAME_FLIGHT",-6);
define("ADD_FLIGHT_ERR_DATE_IN_THE_FUTURE",-7);
define("ADD_FLIGHT_ERR_SAME_HASH_FLIGHT",-8);

//------------------- FLIGHT RELATED FUNCTIONS ----------------------------

function addTestFlightFromURL($filename_url) {
    global $flightsAbsPath ;
	$tmpPath=$flightsAbsPath."/-1/tmp"; 
	if (!is_dir($tmpPath)) mkdir($tmpPath,0755);

	$filename_parts=explode("/",$filename_url);
	$filename=$filename_parts[count($filename_parts)-1];
	$filename_tmp=$tmpPath."/".	$filename;
	$fp=fopen($filename_tmp,"w");

	$lines = file($filename_url); 
	foreach ($lines as $line) { 
	   fwrite($fp,$line);
	} 
	fclose($fp);

	addFlightFromFile($filename_tmp,0,-1,1);
}
 
function checkTrackFileName($filename) {
	$suffix=strtolower(substr($filename,-3));
	if (in_array($suffix ,array("igc")) ) return 1;
	else return 0;
	
}

function addFlightError($errMsg) {
	open_inner_table(_SUBMIT_FLIGHT_ERROR,600);
	open_tr();
		echo "<br><br><center>";
		echo $errMsg;
		echo "</center><br><br><br>";
	close_inner_table();
	exitPage();
}

function submitFlightToServer($serverURL, $username, $passwd, $igcURL, $igcFilename, $private, $cat, $linkURL, $comments, $glider) {

	require_once dirname(__FILE__)."/lib/xml_rpc/IXR_Library.inc.php";
	$client = new IXR_Client($serverURL);
	// $client->debug=true;
	// echo "$username, $passwd, $igcURL, $igcFilename, $private, $cat, $linkURL, $comments, $glider #<BR>";

	if ( ! $client->query('flights.submit',$username, $passwd, $igcURL, $igcFilename, $private, $cat, $linkURL, $comments, $glider ) ) {
		//echo 'submitFlightToServer: Error '.$client->getErrorCode()." -> ".$client->getErrorMessage();
		return array(0,$client->getErrorCode(),$client->getErrorMessage());
	} else {
		$flightID= $client->getResponse();
		return array($flightID,'','');
		// echo 'Flight was submited with id '.$flightID;
	}
	// return $flightID;
}

function addFlightFromFile($filename,$calledFromForm,$userIDstr,
		$is_private=0,$gliderCat=-1,$linkURL="",$comments="",$glider="", $category=1,
		$argArray=array() ) {
	global $flightsAbsPath,$CONF_default_cat_add, $CONF_photosPerFlight;
	global  $CONF_NAC_list,  $CONF_use_NAC, $CONF_use_validation,$CONF_airspaceChecks ;

	set_time_limit (120);

	global $CONF_server_id ;
	list($thisServerID,$userID) = splitServerPilotStr($userIDstr);
	if (!$thisServerID) $thisServerID=$CONF_server_id;

	require_once dirname(__FILE__).'/CL_actionLogger.php';
	$log=new Logger();
	$log->userID  	=$userID;
	$log->ItemType	=1 ; // flight; 
	$log->ItemID	= 0; // 0 at start will fill in later if successfull
	$log->ServerItemID	= $thisServerID ;
	$log->ActionID  = 1 ;  //1  => add  2  => edit;
	$log->ActionXML	= '';
	$log->Modifier	= 0;
	$log->ModifierID= 0;
	$log->ServerModifierID =0;
	$log->Result = 0;
	$log->ResultDescription ="";

	if (!$filename) {
		$log->ResultDescription=getAddFlightErrMsg(ADD_FLIGHT_ERR_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE,0);
		if (!$log->put()) echo "Problem in logger<BR>";
		return array(ADD_FLIGHT_ERR_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE,0);
	}

	// now is the time to remove bad chars from the filename!
	$newFilename=str_replace("'"," ",$filename);
	if ($newFilename!=$filename) {
		rename($filename,$newFilename);
		$filename=$newFilename;
	}

	if (! is_file ($filename) ) {
		$log->ResultDescription=getAddFlightErrMsg(ADD_FLIGHT_ERR_NO_SUCH_FILE,0);
		if (!$log->put()) echo "Problem in logger<BR>";
		return array(ADD_FLIGHT_ERR_NO_SUCH_FILE,0);
	}
	if ( strtolower(substr($filename,-4))!=".igc" ) {
		$log->ResultDescription=getAddFlightErrMsg(ADD_FLIGHT_ERR_FILE_DOESNT_END_IN_IGC,0);
		if (!$log->put()) echo "Problem in logger<BR>";
		return array(ADD_FLIGHT_ERR_FILE_DOESNT_END_IN_IGC,0);
	}

	checkPath($flightsAbsPath."/".$userIDstr);
	$tmpIGCPath=$filename;
	
	if ($gliderCat==-1) $gliderCat=$CONF_default_cat_add;
	$flight=new flight();
	if ($thisServerID!=$CONF_server_id) $flight->userServerID=$thisServerID;

	$flight->userID=$userID;
	$flight->cat=$gliderCat;
	$flight->private=$is_private;
	$flight->glider=$glider;
	$flight->category=$category;
	$flight->comments=$comments;
	$flight->glider=$glider;
	$flight->linkURL=$linkURL;
	if ( strtolower(substr($flight->linkURL,0,7)) == "http://" ) $flight->linkURL=substr($flight->linkURL,7);

	foreach ($argArray as $varName=>$varValue) {
		$flight->$varName=$varValue;
	}

	// check for mac newlines
	$lines=file($tmpIGCPath);
	$hash=md5( implode("\r\n",$lines)  );

	$flight->hash=$hash;

	if ( count ($lines)==1) {
		if ($lines[0]=preg_replace("/\r([^\n])/","\r\n\\1",$lines[0])) {		
			DEBUG('addFlightFromFile',1,"addFlightFromFile: MAC newlines found<BR>");
			if (!$handle = fopen($tmpIGCPath, 'w')) { 
				print "Cannot open file ($filename)"; 
				exit; 
			} 
			if (!fwrite($handle, $lines[0])) { 
			   print "Cannot write to file ($filename)"; 
			   exit; 
			} 
			fclose($handle); 
		} 
	}
	unset($lines);

	//  we must cope with some cases here
	//  1. more flights in the igc
	//  2. garmin saved paths -> zero time difference -> SOLVED!

	if ( ! $flight->getFlightFromIGC( $tmpIGCPath ) ) {
		$log->ResultDescription=getAddFlightErrMsg(ADD_FLIGHT_ERR_THIS_ISNT_A_VALID_IGC_FILE,0);
		if (!$log->put()) echo "Problem in logger<BR>";
		return array(ADD_FLIGHT_ERR_THIS_ISNT_A_VALID_IGC_FILE,0);
	}

	// echo $flight->DATE	." >  ". date("Y-m-d",time()+3600*10) ."<BR>";
	// check for dates in the furure
	if ( $flight->DATE	> date("Y-m-d",time()+3600*10)  ) {
		@unlink($flight->getIGCFilename(1));
		$log->ResultDescription=getAddFlightErrMsg(ADD_FLIGHT_ERR_DATE_IN_THE_FUTURE,0);
		if (!$log->put()) echo "Problem in logger<BR>";
		return array(ADD_FLIGHT_ERR_DATE_IN_THE_FUTURE,0);	
	}

	$oldFlightID= $flight->findSameFlightID();
	if ($oldFlightID>0) {
		@unlink($flight->getIGCFilename(1));
		$log->ResultDescription=getAddFlightErrMsg(ADD_FLIGHT_ERR_SAME_DATE_FLIGHT,0);
		if (!$log->put()) echo "Problem in logger<BR>";
		return array(ADD_FLIGHT_ERR_SAME_DATE_FLIGHT,$oldFlightID);	
	}

	$sameFilenameID=$flight->findSameFilename( basename($filename) );
	if ($sameFilenameID>0) 	 {
		@unlink($flight->getIGCFilename(1));
		$log->ResultDescription=getAddFlightErrMsg(ADD_FLIGHT_ERR_SAME_FILENAME_FLIGHT,0);
		if (!$log->put()) echo "Problem in logger<BR>";
		return array(ADD_FLIGHT_ERR_SAME_FILENAME_FLIGHT,$sameFilenameID);	
	}

	
	$sameHashID=$flight->findSameHash( $hash );
	if ($sameHashID>0) 	 {
		@unlink($flight->getIGCFilename(1));
		$log->ResultDescription=getAddFlightErrMsg(ADD_FLIGHT_ERR_SAME_HASH_FLIGHT,0);
		if (!$log->put()) echo "Problem in logger<BR>";
		return array(ADD_FLIGHT_ERR_SAME_HASH_FLIGHT,$sameHashID);	
	}



	// move the flight to corresponding year
	$yearPath=$flightsAbsPath."/".$userIDstr."/flights/".$flight->getYear(); 
	$maps_dir=$flightsAbsPath."/".$userIDstr."/maps/".$flight->getYear();
	$charts_dir=$flightsAbsPath."/".$userIDstr."/charts/".$flight->getYear();
	$photos_dir=$flightsAbsPath."/".$userIDstr."/photos/".$flight->getYear();

    if (!is_dir($yearPath))  	mkdir($yearPath,0755);
    if (!is_dir($maps_dir))  	mkdir($maps_dir,0755);
    if (!is_dir($charts_dir))	mkdir($charts_dir,0755);
    if (!is_dir($photos_dir))	mkdir($photos_dir,0755);
	
	@rename($tmpIGCPath, $flight->getIGCFilename() );
	// in case an olc file was created too
	@rename($tmpIGCPath.".olc", $flight->getIGCFilename().".olc" );
	@unlink($tmpIGCPath.".olc");
	@unlink($tmpIGCPath);
	
    if ($calledFromForm) {	
		
		for($i=1;$i<=$CONF_photosPerFlight;$i++) {
			$var_name="photo".$i."Filename";
			$photoName=$_FILES[$var_name]['name'];
			$photoFilename=$_FILES[$var_name]['tmp_name'];
			
			if ( $photoName ) {  
				if ( validJPGfilename($photoName) && validJPGfile($photoFilename) ) {
					$flight->$var_name=$photoName;
					if ( move_uploaded_file($photoFilename, $flight->getPhotoFilename($i) ) ) {
						resizeJPG(130,130, $flight->getPhotoFilename($i), $flight->getPhotoFilename($i).".icon.jpg", 15);
						resizeJPG(1280,1280, $flight->getPhotoFilename($i), $flight->getPhotoFilename($i), 15);
					} else { //upload not successfull
						$flight->$var_name="";
					}
				}
			}
		}  
    } // took care of photos

	// if we use NACclubs
	// get the NACclubID for userID
	// and see if the flight is in the current year (as defined in the NAclist array
	if ( $CONF_use_NAC ) {
		require_once dirname(__FILE__)."/CL_NACclub.php";
		list($pilotNACID,$pilotNACclubID)=NACclub::getPilotClub($userID);
		if ( $CONF_NAC_list[$pilotNACID]['use_clubs'] ) {
			// check year -> we only put the club for the current season , so that results for previous seasons cannot be affected 
			$currSeasonYear=$CONF_NAC_list[$pilotNACID]['current_year'];
			
			if ($CONF_NAC_list[$pilotNACID]['periodIsNormal']) {
				$seasonStart=($currSeasonYear-1)."-12-31";
				$seasonEnd=$currSeasonYear."-12-31";
			} else {
				$seasonStart=($currSeasonYear-1).$CONF_NAC_list[$pilotNACID]['periodStart'];
				$seasonEnd=$currSeasonYear.$CONF_NAC_list[$pilotNACID]['periodStart'];
			}

			if ($flight->DATE > $seasonStart  && $flight->DATE <= $seasonEnd ) { 			
				$flight->NACclubID=$pilotNACclubID;
			}
		}
	}
	
	if ($CONF_use_validation) {
		$ok=$flight->validate(0); // dont update DB
	}
	
	if ($CONF_airspaceChecks) {
		$flight->checkAirspace(0); // dont update DB
	}

	$flight->putFlightToDB(0);
	set_time_limit (200);
	$flight->getOLCscore();
	$flight->updateTakeoffLanding();
	$flight->putFlightToDB(1); // update
	
	return array(1,$flight->flightID); // ALL OK;
}

function getAddFlightErrMsg($result,$flightID) {
	global $module_name,$baseInstallationPath,$CONF_mainfile;
	$callingURL="http://".$_SERVER['SERVER_NAME']."$baseInstallationPath/$CONF_mainfile";

	switch ($result) {
		case ADD_FLIGHT_ERR_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE:
			$errMsg=_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE;
			break;
		case ADD_FLIGHT_ERR_NO_SUCH_FILE:
			$errMsg=_NO_SUCH_FILE;
			break;
		case ADD_FLIGHT_ERR_FILE_DOESNT_END_IN_IGC:
			$errMsg=_FILE_DOESNT_END_IN_IGC;
			break;						
		case ADD_FLIGHT_ERR_THIS_ISNT_A_VALID_IGC_FILE:
			$errMsg=_THIS_ISNT_A_VALID_IGC_FILE;
			break;
		case ADD_FLIGHT_ERR_SAME_DATE_FLIGHT:	
			$errMsg=_THERE_IS_SAME_DATE_FLIGHT."<br><br>"._IF_YOU_WANT_TO_SUBSTITUTE_IT." ".
							 "<a href='$callingURL?name=$module_name&op=show_flight&flightID=$flightID'>"._DELETE_THE_OLD_ONE."</a>";
			break;
		case ADD_FLIGHT_ERR_SAME_FILENAME_FLIGHT:
			$errMsg=_THERE_IS_SAME_FILENAME_FLIGHT."<br><br>"._IF_YOU_WANT_TO_SUBSTITUTE_IT." ".
						"<a href='$callingURL?name=$module_name&op=show_flight&flightID=$flightID'>"._DELETE_THE_OLD_ONE."</a><br><br>".
						_CHANGE_THE_FILENAME;
			break;
		case ADD_FLIGHT_ERR_SAME_HASH_FLIGHT:
			$errMsg=_THERE_IS_SAME_DATE_FLIGHT."<br><br>"._IF_YOU_WANT_TO_SUBSTITUTE_IT." ".
							 "<a href='$callingURL?name=$module_name&op=show_flight&flightID=$flightID'>"._DELETE_THE_OLD_ONE."</a>";
			break;
		case ADD_FLIGHT_ERR_DATE_IN_THE_FUTURE:	
			$errMsg="The date of the flight is in the future<BR>Please use the Year-month-day not the US Year-day-month format";
							 
			break;
	}

	return $errMsg;	
}

function getClubFlightsID($clubID) {
	global $db;
	global $clubsFlightsTable ;

  	$query="SELECT flightID FROM $clubsFlightsTable WHERE clubID=$clubID";
	// echo $query;
	$res= $db->sql_query($query);		
    if($res <= 0){
		// echo "No flights found for club ID $clubID<BR>";
		return array();
    }

	$flightsID=array();
	while ($row = $db->sql_fetchrow($res)) { 
 		 array_push($flightsID,$row["flightID"]);
	}
	return $flightsID;
}

?>
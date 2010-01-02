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
// $Id: FN_flight.php,v 1.54 2010/01/02 22:54:55 manolis Exp $                                                                 
//
//************************************************************************

require_once dirname(__FILE__).'/FN_functions.php';
require_once dirname(__FILE__).'/FN_output.php';
require_once dirname(__FILE__).'/CL_flightData.php';
require_once dirname(__FILE__).'/CL_image.php';
require_once dirname(__FILE__).'/CL_pilot.php';

define("ADD_FLIGHT_ERR_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE",-1);
define("ADD_FLIGHT_ERR_NO_SUCH_FILE",-2);
define("ADD_FLIGHT_ERR_FILE_DOESNT_END_IN_IGC",-3);
define("ADD_FLIGHT_ERR_THIS_ISNT_A_VALID_IGC_FILE",-4);
define("ADD_FLIGHT_ERR_SAME_DATE_FLIGHT",-5);
define("ADD_FLIGHT_ERR_SAME_FILENAME_FLIGHT",-6);
define("ADD_FLIGHT_ERR_DATE_IN_THE_FUTURE",-7);
define("ADD_FLIGHT_ERR_SAME_HASH_FLIGHT",-8);
define("ADD_FLIGHT_ERR_OUTSIDE_SUBMIT_WINDOW",-9);

//------------------- FLIGHT RELATED FUNCTIONS ----------------------------

function addTestFlightFromURL($filename_url) {
    //global $flightsAbsPath ;
	//$tmpPath=$flightsAbsPath."/-1/tmp"; 
	global $CONF ;
	$tmpPath=LEONARDO_ABS_PATH.'/'.$CONF['paths']['tmpigc'];
	
	// if (!is_dir($tmpPath)) makeDir($tmpPath,0755);

	$filename_parts=explode("/",$filename_url);
	$filename=$filename_parts[count($filename_parts)-1];
	$filename_tmp=$tmpPath."/".	$filename;
	$fp=fopen($filename_tmp,"w");

	$lines = file($filename_url); 
	foreach ($lines as $line) { 
	   fwrite($fp,$line);
	} 
	fclose($fp);

	addFlightFromFile($filename_tmp,0,-1, array('private'=>1,'cat'=>-1,'category'=>1) );

}
 
function checkTrackFileName($filename) {
	$suffix=strtolower(substr($filename,-3));
	if (in_array($suffix ,array("igc")) ) return 1;
	else return 0;
	
}

function addFlightError($errMsg) {
	/*
	open_inner_table(_SUBMIT_FLIGHT_ERROR,600);
	open_tr();
		echo "<br><br><center>";
		echo $errMsg;
		echo "</center><br><br><br>";
	close_inner_table();
	*/
	echo "<BR><BR><span class='alert'><strong>"._SUBMIT_FLIGHT_ERROR."</strong><br><BR>$errMsg</span>";
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
		// $is_private=0,$gliderCat=-1,$linkURL="",$comments="",$glider="", $category=1,
		$argArray=array()	 )  {

	global $CONF_default_cat_add, $CONF_photosPerFlight,$CONF;
	global $CONF_NAC_list,  $CONF_use_NAC, $CONF_use_validation,$CONF_airspaceChecks ,$CONF_server_id;
	global $userID,$CONF_new_flights_submit_window;
	global $flightsTable;

	set_time_limit (120);

	global $CONF_server_id ;
	list($thisServerID,$userIDforFlight) = splitServerPilotStr($userIDstr);
	if (!$thisServerID) $thisServerID=$CONF_server_id;

	require_once dirname(__FILE__).'/CL_actionLogger.php';
	$log=new Logger();
	$log->userID  	=$userID+0; // the userId that is logged in , not the one that the flight will be atrributed to 
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
	$newFilename=toLatin1($newFilename);

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

	$tmpIGCPath=$filename;
		
	$flight=new flight();

	if ($thisServerID!=$CONF_server_id) 
		$flight->userServerID=$thisServerID;
	$flight->userID=$userIDforFlight;

/*
	$flight->cat=$gliderCat;
	$flight->private=$is_private;
	$flight->category=$category;
	$flight->comments=$comments;
	$flight->glider=$glider;
	$flight->linkURL=$linkURL;
*/

	foreach ($argArray as $varName=>$varValue) {
		$flight->$varName=$varValue;
	}

	if ( strtolower(substr($flight->linkURL,0,7)) == "http://" ) $flight->linkURL=substr($flight->linkURL,7);

	if ($flight->cat==-1) $flight->cat=$CONF_default_cat_add;

	# martin jursa 22.06.2008:
	# in case the glider is not given otherwise, try to extract it from the IGC file
	if (empty($flight->glider)) {
		$flight->glider=extractGlider($lines);
	}
	// if no brand was given , try to detect
	$flight->checkGliderBrand();

	//  we must cope with some cases here
	//  1. more flights in the igc
	//  2. garmin saved paths -> zero time difference -> SOLVED!

	if ( ! $flight->getFlightFromIGC( $tmpIGCPath ) ) {
		$log->ResultDescription=getAddFlightErrMsg(ADD_FLIGHT_ERR_THIS_ISNT_A_VALID_IGC_FILE,0);
		if (!$log->put()) echo "Problem in logger<BR>";
		return array(ADD_FLIGHT_ERR_THIS_ISNT_A_VALID_IGC_FILE,0);
	}

	// Compute hash now
	$lines=file($tmpIGCPath);
	$hash=md5( implode('',$lines)  );
	$flight->hash=$hash;
	unset($lines);
	
	// check for mac newlines -> NOT USED NOW
	// we now use auto_detect_line_endings=true;
/*
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
*/



	// echo $flight->DATE	." >  ". date("Y-m-d",time()+3600*10) ."<BR>";
	// check for dates in the furure
	if ( $flight->DATE	> date("Y-m-d",time()+3600*10)  ) {
		@unlink($flight->getIGCFilename(1));
		@unlink($tmpIGCPath.".olc");
		@unlink($tmpIGCPath);
		$log->ResultDescription=getAddFlightErrMsg(ADD_FLIGHT_ERR_DATE_IN_THE_FUTURE,0);
		if (!$log->put()) echo "Problem in logger<BR>";
		return array(ADD_FLIGHT_ERR_DATE_IN_THE_FUTURE,0);	
	}
	
	
	// Two week time limit check - P.Wild
	/// Modification martin jursa 08.05.2007 cancel the upload if flight is too old
	if ($CONF_new_flights_submit_window>0) {
		if (! L_auth::isAdmin($userID) ) {
			if (  $flight->DATE	< date("Y-m-d", time() - $CONF_new_flights_submit_window*24*3600 )  ) {
				@unlink($flight->getIGCFilename(1));
				@unlink($tmpIGCPath.".olc");
				@unlink($tmpIGCPath);
				$log->ResultDescription=getAddFlightErrMsg(ADD_FLIGHT_ERR_OUTSIDE_SUBMIT_WINDOW,0);
				if (!$log->put()) echo "Problem in logger<BR>";
				return array(ADD_FLIGHT_ERR_OUTSIDE_SUBMIT_WINDOW,0);
			}
		}
	}
	// end martin / peter
	
	
	$sameFilenameID=$flight->findSameFilename( basename($filename) );
	if ($sameFilenameID>0) 	 {
		if ( $flight->allowDuplicates ) {
			while ( is_file($flight->getIGCFilename()) ) {
				$flight->filename='_'.$flight->filename;
			}
		} else {
			@unlink($flight->getIGCFilename(1));
			@unlink($tmpIGCPath.".olc");
			@unlink($tmpIGCPath);
			$log->ResultDescription=getAddFlightErrMsg(ADD_FLIGHT_ERR_SAME_FILENAME_FLIGHT,0);
			if (!$log->put()) echo "Problem in logger<BR>";
			return array(ADD_FLIGHT_ERR_SAME_FILENAME_FLIGHT,$sameFilenameID);	
		}
	}
	
	$sameFlightsArray= $flight->findSameTime();
	if (count($sameFlightsArray)>0) {

		if ( $flight->allowDuplicates ) { // we allow duplicates if they are from another server
			$dupFound=0;
			foreach($sameFlightsArray as $k=>$fArr){
				if ($fArr['serverID']==$flight->serverID)  {// if a same flight from this server is present we dont re-insert
					$dupFound=1;
					break;
				} else { // fill in ids of flights to 'disable'
					$disableFlightsList[$fArr['ID']]++;
				}

			}

		} else {
			$dupFound=1;
		}

		if ($dupFound) {
			@unlink($flight->getIGCFilename(1));
			@unlink($tmpIGCPath.".olc");
			@unlink($tmpIGCPath);
			$log->ResultDescription=getAddFlightErrMsg(ADD_FLIGHT_ERR_SAME_DATE_FLIGHT,0);
			if (!$log->put()) echo "Problem in logger<BR>";
			//	return  array( ADD_FLIGHT_ERR_SAME_DATE_FLIGHT,$sameFlightsArray[0]['serverID'].'_'. $sameFlightsArray[0]['ID']);
			return array(ADD_FLIGHT_ERR_SAME_DATE_FLIGHT,$sameFlightsArray[0]['ID']);
		} else {
			DEBUG("FLIGHT",1,"addFlightFromFile: Duplicate DATE/TIME flight will be inserted<br>");
		}
	}

	$sameFlightsArray= $flight->findSameHash( $hash );
	if (count($sameFlightsArray)>0) {
		if ( $flight->allowDuplicates ) { // we allow duplicates if they are from another server
			//echo "searching in dups ";
			//print_r($sameFlightsArray);
			$dupFound=0;
			
			$flightPilot= new pilot($flight->userServerID+0,$flight->userID+0); 
			$flightPilotMapTable=$flightPilot->pilotMapping();
			// print_r($flightPilotMapTable);
			
			foreach($sameFlightsArray as $k=>$fArr){
				if ($fArr['serverID'] == $flight->serverID )  {// if a same flight from this server is present we dont re-insert
					$dupFound=1;
					break;
				} else { 
					// check that the existing flight belongs to a pilot that is 'mapped' to 
					// $flight->userID + $flight->userServerID
					if ( ! $flightPilotMapTable[ $fArr['userServerID'] ][ $fArr['userID'] ] ) {
						DEBUG("FLIGHT",1,"addFlightFromFile: Same hash from external Server BUT from the pilot was not mapped into local <br>");
						// We allow the flight to be submitted but then we must check and disable all duplicates but one 
						//$dupFound=1;
						//break;
					}
					
					// fill in ids of flights to 'disable'					
					$disableFlightsList[$fArr['ID']]++;
				}
			}

		} else {
			// echo "no dups allowesd";
			$dupFound=1;
		}

		if ($dupFound) {
			@unlink($flight->getIGCFilename(1));
			@unlink($tmpIGCPath.".olc");
			@unlink($tmpIGCPath);
			$log->ResultDescription=getAddFlightErrMsg(ADD_FLIGHT_ERR_SAME_HASH_FLIGHT,0);
			if (!$log->put()) echo "Problem in logger<BR>";
			return array(ADD_FLIGHT_ERR_SAME_HASH_FLIGHT,$sameFlightsArray[0]['ID']);
		} else {
			DEBUG("FLIGHT",1,"addFlightFromFile: Duplicate HASH flight will be inserted<br>");
			// echo "addFlightFromFile: Duplicate HASH flight will be inserted<br>";
		}
	}
	
	// print_r($disableFlightsList);
/*
	if ( ! $flight->allowDuplicates ) {
		$sameHashIDArray=$flight->findSameHash( $hash );
		if (count($sameHashIDArray)>0) 	 {
			@unlink($flight->getIGCFilename(1));
			@unlink($tmpIGCPath.".olc");
			@unlink($tmpIGCPath);
			$log->ResultDescription=getAddFlightErrMsg(ADD_FLIGHT_ERR_SAME_HASH_FLIGHT,0);
			if (!$log->put()) echo "Problem in logger<BR>";
			return array(ADD_FLIGHT_ERR_SAME_HASH_FLIGHT,$sameHashIDArray[0]['serverID'].'_'.$sameHashIDArray[0]['ID']);	
		}
	}
*/

	//******************************************************
	// PASSED ALL TESTS , NOW DO SOME WORK WITH OUR FLIGHT
	//******************************************************
	
	// move the flight to corresponding year
	
	$flight->checkDirs();
	
	//$yearPath=$flightsAbsPath."/".$userIDstr."/flights/".$flight->getYear(); 
	//$maps_dir=$flightsAbsPath."/".$userIDstr."/maps/".$flight->getYear();
	//$charts_dir=$flightsAbsPath."/".$userIDstr."/charts/".$flight->getYear();
	//$photos_dir=$flightsAbsPath."/".$userIDstr."/photos/".$flight->getYear();

    //if (!is_dir($yearPath))  	mkdir($yearPath,0755);
    //if (!is_dir($maps_dir))  	mkdir($maps_dir,0755);
    //if (!is_dir($charts_dir))	mkdir($charts_dir,0755);
    //if (!is_dir($photos_dir))	mkdir($photos_dir,0755);
	
	
/**
 * Martin Jursa; to avoid error log flooding
 */
	if (file_exists($tmpIGCPath)) {
		@rename($tmpIGCPath, $flight->getIGCFilename() );
	}
	// in case an olc file was created too
	if (file_exists($tmpIGCPath.".olc")) {
		@rename($tmpIGCPath.".olc", $flight->getIGCFilename().".olc" );
	}
	// these commands seem redundant:
	//@unlink($tmpIGCPath.".olc");
	//@unlink($tmpIGCPath);

/*old:	@rename($tmpIGCPath, $flight->getIGCFilename() );
	// in case an olc file was created too
	@rename($tmpIGCPath.".olc", $flight->getIGCFilename().".olc" );
	@unlink($tmpIGCPath.".olc");
	@unlink($tmpIGCPath);
*/

	// if we use NACclubs
	// get the NACclubID for userID
	// and see if the flight is in the current year (as defined in the NAclist array
	if ( $CONF_use_NAC ) {
		require_once dirname(__FILE__)."/CL_NACclub.php";
		list($pilotNACID,$pilotNACclubID)=NACclub::getPilotClub($userIDforFlight);
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
				$flight->NACid=$pilotNACID;
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
	
	// now do the photos
	if ($calledFromForm) {	
		
		require_once dirname(__FILE__)."/CL_flightPhotos.php";
		$flightPhotos=new flightPhotos($flight->flightID);
		// $flightPhotos->getFromDB();
		$j=0;
		for($i=0;$i<$CONF_photosPerFlight;$i++) {
			$var_name="photo".$i."Filename";
			$photoName=$_FILES[$var_name]['name'];
			$photoFilename=$_FILES[$var_name]['tmp_name'];
			
			if ( $photoName ) {  
				if ( CLimage::validJPGfilename($photoName) && CLimage::validJPGfile($photoFilename) ) {
				
					// $newPhotoName=toLatin1($photoName);
					// Fix for same photo filenames 2009.02.03
					//global $flightsAbsPath;	
					global $CONF;
					$newPhotoName=flightPhotos::getSafeName(
						LEONARDO_ABS_PATH.'/'.str_replace("%PILOTID%",$flight->getPilotID(),str_replace("%YEAR%",$flight->getYear(),$CONF['paths']['photos']) ),
						$photoName);				
						//$flightsAbsPath.'/'.$flight->getPilotID()."/photos/".$flight->getYear() , 
						//$photoName	) ;
					
					$phNum=$flightPhotos->addPhoto($j,$flight->getPilotID()."/photos/".$flight->getYear(), $newPhotoName,$description);
					$photoAbsPath=$flightPhotos->getPhotoAbsPath($j);

					if ( move_uploaded_file($photoFilename, $photoAbsPath ) ) {
					
						CLimage::resizeJPG( $CONF['photos']['thumbs']['max_width'],
						 					$CONF['photos']['thumbs']['max_height'],
											$photoAbsPath, $photoAbsPath.".icon.jpg", 
											$CONF['photos']['compression']);
						CLimage::resizeJPG(
						 $CONF['photos']['normal']['max_width'],
						 $CONF['photos']['normal']['max_height'], $photoAbsPath, $photoAbsPath, 
						 $CONF['photos']['compression']
						 );
						 
						$flight->hasPhotos++;
						$j++;
					} else { //upload not successfull
						$flightPhotos->deletePhoto($j);						
					}
					

				}
			}
		}  
    } // took care of photos

	// now is a good time to disable duplicate flights we have found from other servers
	// AND are from the same user (using pilot's mapping table to find that out)
	global $db;
	if (0) {
		foreach ($disableFlightsList as $dFlightID=>$num) {
			$query="UPDATE $flightsTable SET private = private | 0x02 WHERE  ID=$dFlightID ";
			$res= $db->sql_query($query);	
			# Error checking
			if($res <= 0){
				echo("<H3> Error in query: $query</H3>\n");
			}
		}
	}	
	//or 
	$flight->hideSameFlights();
	
	
	set_time_limit (200);
	$flight->computeScore();
	$flight->updateTakeoffLanding();
	$flight->putFlightToDB(1); // update
	
	return array(1,$flight->flightID); // ALL OK;
}

/**
 * martin jursa, 22.06.2008
 * Extract the glider from the IGC file rows
 * @param array $lines
 * @return string
 */
function extractGlider($lines) {
	$glider='';
	if (count($lines)>0) {
		foreach ($lines as $line) {
			if (strpos($line, 'HOGTYGLIDERTYPE:')!==false) {
				$parts=explode(':', $line);
				$glider=trim($parts[1]);
				break;
			}
		}
	}
	return $glider;
}

function getAddFlightErrMsg($result,$flightID) {
	$callingURL="http://".$_SERVER['SERVER_NAME'];
	if (is_array($flightID) ) {
		$flightID=$flightID[0]['ID'];
	}
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
							 "<a href='$callingURL".
							 getLeonardoLink(array('op'=>'show_flight','flightID'=>$flightID)).
							 "'>"._DELETE_THE_OLD_ONE."</a>";
			break;
		case ADD_FLIGHT_ERR_SAME_FILENAME_FLIGHT:
			$errMsg=_THERE_IS_SAME_FILENAME_FLIGHT."<br><br>"._IF_YOU_WANT_TO_SUBSTITUTE_IT." ".
						"<a href='$callingURL".
						getLeonardoLink(array('op'=>'show_flight','flightID'=>$flightID)).
						"'>"._DELETE_THE_OLD_ONE."</a><br><br>".
						_CHANGE_THE_FILENAME;
			break;
		case ADD_FLIGHT_ERR_SAME_HASH_FLIGHT:
			$errMsg=_THERE_IS_SAME_DATE_FLIGHT." (HASH) <br><br>"._IF_YOU_WANT_TO_SUBSTITUTE_IT." ".
						"<a href='$callingURL".
						getLeonardoLink(array('op'=>'show_flight','flightID'=>$flightID)).
						"'>"._DELETE_THE_OLD_ONE."</a>";
			break;
		case ADD_FLIGHT_ERR_DATE_IN_THE_FUTURE:	
			$errMsg="The date of the flight is in the future<BR>Please use the Year-month-day not the US Year-day-month format";
							 
			break;
	    case ADD_FLIGHT_ERR_OUTSIDE_SUBMIT_WINDOW:
			$errMsg=_OUTSIDE_SUBMIT_WINDOW;
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

/**
 * Martin Jursa 28.5.2008
 * Function returning the javascript for form validation for add_flight and add_flight_from_zip
 *
 * @return string
 */
function getFormValidationJs() {
	global $CONF_require_glider, $CONF_addflight_js_validation;
	$js='';
	if (!empty($CONF_addflight_js_validation)) {
		$js="
var ok=true;
var el=document.forms[0].datafile;
if (ok) {
	if (el && !el.value) {
		el.focus();
		alert('"._FLIGHTADD_IGC_MISSING."');
		ok=false;
	}
}
if (ok) {
	el=document.forms[0].zip_datafile;
	if (el && !el.value) {
		el.focus();
		alert('"._FLIGHTADD_IGCZIP_MISSING."');
		ok=false;
	}
}
if (ok) {
	el=document.forms[0].category;
	if (el && el.options[el.selectedIndex].value=='0') {
		el.focus();
		alert('"._FLIGHTADD_CATEGORY_MISSING."');
		ok=false;
	}
}
";
		if (!empty($CONF_require_glider)) {
			$js.="
if (ok) {
	el=document.forms[0].gliderBrandID;
	if (el && el.options[el.selectedIndex].value=='0') {
		el.focus();
		alert('"._FLIGHTADD_BRAND_MISSING."');
		ok=false;
	}
}
if (ok) {
	el=document.forms[0].glider;
	if (!el.value) {
		el.focus();
		alert('"._FLIGHTADD_GLIDER_MISSING."');
		ok=false;
	}
}
";
		}
		$js.="
return ok;
";
	}
	return $js;
}

?>
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


define("ADD_FLIGHT_ERR_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE",-1);
define("ADD_FLIGHT_ERR_NO_SUCH_FILE",-2);
define("ADD_FLIGHT_ERR_FILE_DOESNT_END_IN_IGC",-3);
define("ADD_FLIGHT_ERR_THIS_ISNT_A_VALID_IGC_FILE",-4);
define("ADD_FLIGHT_ERR_SAME_DATE_FLIGHT",-5);
define("ADD_FLIGHT_ERR_SAME_FILENAME_FLIGHT",-6);

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
	//echo "$username, $passwd, $igcURL, $igcFilename, $private, $cat, $linkURL, $comments, $glider #<BR>";

	if ( ! $client->query('flights.submit',$username, $passwd, $igcURL, $igcFilename, $private, $cat, $linkURL, $comments, $glider ) ) {
		echo 'submitFlightToServer: Error '.$client->getErrorCode()." -> ".$client->getErrorMessage();
		return $client->getErrorCode();
	} else {
		$flightID= $client->getResponse();
		echo 'Flight was submited with id '.$flightID;
	}
	return 1;
}

function addFlightFromFile($filename,$calledFromForm,$userID,$is_private=0,$gliderCat=-1,$linkURL="",$comments="",$glider="") {
	global $flightsAbsPath,$CONF_default_cat_add, $CONF_photosPerFlight;

	set_time_limit (120);

	if (!$filename) return array(ADD_FLIGHT_ERR_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE,0);
	if (! is_file ($filename) ) return array(ADD_FLIGHT_ERR_NO_SUCH_FILE,0);
	if ( strtolower(substr($filename,-4))!=".igc") return array(ADD_FLIGHT_ERR_FILE_DOESNT_END_IN_IGC,0);

	checkPath($flightsAbsPath."/".$userID);
	$tmpIGCPath=$filename;
	
	if ($gliderCat==-1) $gliderCat=$CONF_default_cat_add;
	$flight=new flight();
	$flight->userID=$userID;
	$flight->cat=$gliderCat;
	$flight->private=$is_private;
	$flight->glider=$glider;

	//  we must cope with some cases here
	//  1. more flights in the igc
	//  2. garmin saved paths -> zero time difference
	
	if ( ! $flight->getFlightFromIGC( $tmpIGCPath ) ) 			
		return array(ADD_FLIGHT_ERR_THIS_ISNT_A_VALID_IGC_FILE,0);
	
	$oldFlightID= $flight->findSameFlightID();
	if ($oldFlightID>0) 		
		return array(ADD_FLIGHT_ERR_SAME_DATE_FLIGHT,$oldFlightID);	

	$sameFilenameID=$flight->findSameFilename( basename($filename) );
	if ($sameFilenameID>0) 	
		return array(ADD_FLIGHT_ERR_SAME_FILENAME_FLIGHT,$sameFilenameID);	

	if ($calledFromForm) {	
		$flight->comments=$_REQUEST["comments"];
		// check to see if the user has filled in a glider
		if ($_REQUEST["glider"]!='') $flight->glider=$_REQUEST["glider"];
		// else the glider will be found from the igc file 
		
		$flight->linkURL=$_REQUEST["linkURL"];
		if ( strtolower(substr($flight->linkURL,0,7)) == "http://" ) $flight->linkURL=substr($flight->linkURL,7);
	}

	// move the flight to corresponding year
	$yearPath=$flightsAbsPath."/".$flight->userID."/flights/".$flight->getYear(); 
	$maps_dir=$flightsAbsPath."/".$flight->userID."/maps/".$flight->getYear();
	$charts_dir=$flightsAbsPath."/".$flight->userID."/charts/".$flight->getYear();
	$photos_dir=$flightsAbsPath."/".$flight->userID."/photos/".$flight->getYear();

    if (!is_dir($yearPath))  	mkdir($yearPath,0755);
    if (!is_dir($maps_dir))  	mkdir($maps_dir,0755);
    if (!is_dir($charts_dir))	mkdir($charts_dir,0755);
    if (!is_dir($photos_dir))	mkdir($photos_dir,0755);

	
	rename($tmpIGCPath, $flight->getIGCFilename() );
	
    if ($calledFromForm) {		
		for($i=1;$i<=$CONF_photosPerFlight;$i++) {
			$var_name="photo".$i."Filename";
			if ($_FILES[$var_name]['name'] ) {  
				$flight->$var_name=$_FILES[$var_name]['name'];
				if ( move_uploaded_file($_FILES[$var_name]['tmp_name'],  $flight->getPhotoFilename($i) ) ) {
					resizeJPG(130,130, $flight->getPhotoFilename($i), $flight->getPhotoFilename($i).".icon.jpg", 15);
					resizeJPG(1280,1280, $flight->getPhotoFilename($i), $flight->getPhotoFilename($i), 15);
				} else { //upload not successfull
					$flight->$var_name="";
				}
			}
		}  
    } // took care of photos

	$flight->putFlightToDB(0);
	set_time_limit (200);
	$flight->getOLCscore();
	$flight->updateTakeoffLanding();
	$flight->putFlightToDB(1); // update

/*
	set_time_limit (200);
	$flight->updateAll(1);
	$flight->putFlightToDB(1); // update
*/

	return array(1,$flight->flightID); // ALL OK;
}

function getAddFlightErrMsg($result,$flightID) {
	global $module_name;
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
							 "<a href='?name=$module_name&op=show_flight&flightID=$flightID'>"._DELETE_THE_OLD_ONE."</a>";
			break;
		case ADD_FLIGHT_ERR_SAME_FILENAME_FLIGHT:
			$errMsg=_THERE_IS_SAME_FILENAME_FLIGHT."<br><br>"._IF_YOU_WANT_TO_SUBSTITUTE_IT." ".
						"<a href='?name=$module_name&op=show_flight&flightID=$flightID'>"._DELETE_THE_OLD_ONE."</a><br><br>".
						_CHANGE_THE_FILENAME;
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
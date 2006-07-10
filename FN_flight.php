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
 
function addFlightFromFile($filename,$calledFromForm,$userID,$is_private=0,$gliderCat=-1,$linkURL="",$comments="") {
	global $flightsAbsPath,$CONF_default_cat_add ;

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
		if ( substr($flight->linkURL,0,7) == "http://" ) $flight->linkURL=substr($flight->linkURL,7);
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
		$photo1Filename=$_FILES['photo1Filename']['name'];
		$photo2Filename=$_FILES['photo2Filename']['name'];
		$photo3Filename=$_FILES['photo3Filename']['name'];
		if ($photo1Filename) {		
			if ( move_uploaded_file($_FILES['photo1Filename']['tmp_name'],$flightsAbsPath."/".$userID."/photos/".$flight->getYear()."/".$photo1Filename ) ) {
				$flight->photo1Filename=$photo1Filename;
				resizeJPG(120,120, $flight->getPhotoFilename(1), $flight->getPhotoFilename(1).".icon.jpg", 15);
				resizeJPG(800,800, $flight->getPhotoFilename(1), $flight->getPhotoFilename(1), 15);
			}
		} 
		if ($photo2Filename) {
			if ( move_uploaded_file($_FILES['photo2Filename']['tmp_name'],$flightsAbsPath."/".$userID."/photos/".$flight->getYear()."/".$photo2Filename ) ) {
				$flight->photo2Filename=$photo2Filename;
				resizeJPG(120,120, $flight->getPhotoFilename(2), $flight->getPhotoFilename(2).".icon.jpg", 15);
				resizeJPG(800,800, $flight->getPhotoFilename(2), $flight->getPhotoFilename(2), 15);
			}
		}
		if ($photo3Filename) {		
			if ( move_uploaded_file($_FILES['photo3Filename']['tmp_name'],$flightsAbsPath."/".$userID."/photos/".$flight->getYear()."/".$photo3Filename ) ) {
				$flight->photo3Filename=$photo3Filename;
				resizeJPG(120,120, $flight->getPhotoFilename(3), $flight->getPhotoFilename(3).".icon.jpg", 15);
				resizeJPG(800,800, $flight->getPhotoFilename(3), $flight->getPhotoFilename(3), 15);
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

	// echo "<img src='?name=$module_name&op=postAddFlight&flightID=".$flight->flightID."' width=1 height=1 border=0 alt=''>";
	// echo "Flight ID=".$flight->flightID."<br>";
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
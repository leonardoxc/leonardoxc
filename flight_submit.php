<? 
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://sourceforge.net/projects/leonardoserver                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

 	require_once "EXT_config_pre.php";
	require_once "config.php";
 	require_once "EXT_config.php";

	require_once "CL_flightData.php";
	require_once "FN_functions.php";	
	require_once "FN_UTM.php";
	require_once "FN_waypoint.php";	
	require_once "FN_output.php";
	require_once "FN_pilot.php";
	require_once "FN_flight.php";
	setDEBUGfromGET();

	$moduleRelPath="modules/".$module_name;
	$waypointsWebPath=$moduleRelPath."/".$waypointsRelPath;
	$flightsWebPath=$moduleRelPath."/".$flightsRelPath;

	if (0) {
		foreach($_POST as $varName=>$varValue) {
			echo "$varName => $varValue<BR>";
		}
		exit;
	}	

	$user=str_replace("\\'", "''", $_POST['OLCvnolc'] );
	$pass=str_replace("\\'", "''", $_POST['na'] );

	$sql = "SELECT user_id, username, user_password
			FROM ".$prefix."_users	WHERE username = '$user'";
	if ( !($result = $db->sql_query($sql)) )
	{
		echo "Invalid user data<BR>";
		exit;
	}

	$passwdProblems=0;
	if( $row = $db->sql_fetchrow($result) ) {
		if( md5($pass) != $row['user_password'] ) $passwdProblems=1;
	} else 	$passwdProblems=1;

	if ($passwdProblems) {
		echo "Invalid user data<BR>";
		exit;
	}

   $userID=$row['user_id'];

   $filename = dirname(__FILE__)."/flights/".$_POST['igcfn'].".igc";	   
   if (!$handle = fopen($filename, 'w')) { 
		echo "Cannot open file ($filename) on server for writing<BR>";
		exit;
   } 

	// make the first line:
	$igcContents="OLCvnolc=$username&na=$username";
	foreach($_POST as $varName=>$varValue) {
		if ($varName !='IGCigcIGC' && $varName!='OLCvnolc' && $varName!='na' ) {
			$igcContents.="&$varName=$varValue";
		}
	}

   $igcContents.=$_POST['IGCigcIGC'];
   // Write $somecontent to our opened file. 
   if (!fwrite($handle, $igcContents)) { 		
		echo "Cannot write to file ($filename) on server <br>";
		exit;
   } 		
   fclose($handle); 
						

	$klasse=$_POST['klasse'];

	$cat=0;
	$category=1;

	if ($klasse==1) $cat=2 ; //flex
	else if ($klasse==2) $cat=4 ; //rigid
	else if ($klasse==3) { $cat=1 ;  $category=2; } // pg  open
	else if ($klasse==4) { $cat=1 ;  $category=1; } // pg sport
	else if ($klasse==5) { $cat=1 ;  $category=3; } // pg tandem

	list($errCode,$flightID)=addFlightFromFile($filename,0,$userID,0,$cat,"","","",$category) ;

	if ($errCode!=1) {
		echo "problem<br>";
		echo htmlspecialchars(getAddFlightErrMsg($errCode,$flightID));
	} else {
		echo "response=$flightID<br>";
		echo "flight scored<br>";

	}

?>
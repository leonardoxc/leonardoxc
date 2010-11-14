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
// $Id: EXT_comments_functions.php,v 1.2 2010/11/14 20:59:12 manolis Exp $                                                                 
//
//************************************************************************

 	require_once dirname(__FILE__)."/EXT_config_pre.php";
	require_once "config.php";
 	require_once "EXT_config.php";

	require_once "CL_flightData.php";
	require_once "CL_comments.php";
	require_once "FN_functions.php";	
	require_once "FN_UTM.php";
	require_once "FN_waypoint.php";	
	require_once "FN_output.php";
	require_once "FN_pilot.php";
	require_once "FN_flight.php";
	require_once dirname(__FILE__)."/templates/".$PREFS->themeName."/theme.php";
	setDEBUGfromGET();

	
	// if ( !L_auth::isAdmin($userID) ) { echo "go away"; return; }

	$op=makeSane($_POST['op']);	

	if ($op=='add'){	
		$flightID=makeSane($_POST['flightID']);
		$parentID=makeSane($_POST['parentID'])+0;
		$guestName=makeSane($_POST['guestName']);
		$guestEmail=makeSane($_POST['guestEmail']);
		$guestPass=makeSane($_POST['guestPass']);
		$commentText=$_POST['commentText'];
		$userID=makeSane($_POST['userID']);
		$userServerID=makeSane($_POST['userServerID']);
		$languageCode=makeSane($_POST['languageCode']);
		
		
		$flightComments=new flightComments($flightID);
		$flightComments->addComment(
				array(
					'parentID'=>$parentID,
					'userID'=>$userID,
					'userServerID'=>$userServerID,
					'guestName'=>$guestName,
					'guestPass'=>$guestPass,
					'guestEmail'=>$guestEmail,
					'text'=>$commentText,
					'languageCode'=>$languageCode
					)
		);			
								 
		echo " $flightID $parentID $name $email $commentText <BR>";
		echo "OK";
	} 

	

?>
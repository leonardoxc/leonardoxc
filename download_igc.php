<?
//************************************************************************
// Leonardo XC Server, https://github.com/leonardoxc/leonardoxc
//
// Copyright (c) 2004-2010 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: download_igc.php,v 1.1 2011/05/18 13:31:48 manolis Exp $                                                                 
//
//************************************************************************
 	require_once dirname(__FILE__)."/EXT_config_pre.php";
	require_once dirname(__FILE__)."/config.php";
 	require_once dirname(__FILE__)."/EXT_config.php";

	require_once dirname(__FILE__)."/FN_functions.php";	
	require_once dirname(__FILE__)."/FN_UTM.php";
	require_once dirname(__FILE__)."/FN_pilot.php";
	require_once dirname(__FILE__)."/FN_waypoint.php";	
	require_once dirname(__FILE__)."/FN_output.php";
	require_once dirname(__FILE__)."/CL_flightData.php";
	require_once dirname(__FILE__)."/language/".CONF_LANG_ENCODING_TYPE."/lang-".$currentlang.".php";
	require_once dirname(__FILE__)."/language/".CONF_LANG_ENCODING_TYPE."/countries-".$currentlang.".php";

	setDEBUGfromGET();
	
	if (!$type)  {
		$type=makeSane($_REQUEST['type']);
	}
	
	if (!in_array($type,array("igc")) ) return;


	if ($type=="igc") {
		session_start();
		if (!$flightID) {
			$flightID=makeSane($_REQUEST['flightID']);
		}	
		if (!$file) {
			$file=makeSane($_REQUEST['file'],2);
		}	
		
		$flightID+=0;

		$clientIP=getClientIpAddr();
		
		if ($flightID) {
			$flight=new flight();
	
			if ( ! $flight->getFlightFromDB($flightID) ) {
				echo "No such flight exists";
				return;  
			  }
	  
			if ( $flight->private && ! $flight->belongsToUser($userID) && 
				! L_auth::isModerator($userID) && !L_auth::canDownloadIGC($clientIP) ) {
				echo _FLIGHT_IS_PRIVATE;
				return;
			}
	
			$authOK=0;
			
			if ( $flight->belongsToUser($userID) ||  L_auth::isModerator($userID) || L_auth::canDownloadIGC($clientIP) ) {
				$authOK=1;
			} else {
				if (substr($_REQUEST['captchaStr'], 10) != $_SESSION['captchaCodes'][$_SESSION['captchaAnswer']]) {
					$authOK=0;
				} else {
					$authOK=1;
				}
			}
		} else if ($file) {
			$authOK=0;
			
			$base_name=md5(basename($file));
            if (  L_auth::isModerator($userID) || L_auth::canDownloadIGC($clientIP) ||  $_SESSION['di'.$base_name] ) {
				$authOK=1;
			} else {
				if (substr($_REQUEST['captchaStr'], 10) != $_SESSION['captchaCodes'][$_SESSION['captchaAnswer']]) {
					$authOK=0;
				} else {
					$authOK=1;
				}
			}
		
		}

		if (!$authOK) {
			echo "Authorization failed";
			return;
		}
		
		if ($flightID) {
			$filename=$flight->getIGCFilename();
		} else if ($file) {		
			if ($CONF['config']['pathsVersion']==1) {
				$filename=dirname(__FILE__).'/flights/'.str_replace("..","",$file);
			} else {	
				$filename=dirname(__FILE__).'/data/flights/'.str_replace("..","",$file);
			}	
		}
		
		
		if ( !is_file($filename) ) {
			echo "file not found $filename";
			return;
		}
		
		$outputStr=file_get_contents($filename);
		$outputFilename=basename($filename);
		// $attachmentMIME ='text/plain';
		$attachmentMIME ="application/octet-stream";
		// echo "$outputFilename <BR>";exit;
		
		header("Content-type: $attachmentMIME");
		header('Content-Disposition: inline; filename="'.$outputFilename.'"');
		header("Content-Transfer-Encoding: binary");
		header("Content-length: ".strlen($outputStr));
		echo $outputStr;
		return;
		

	}


?>
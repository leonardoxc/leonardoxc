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
// $Id: CL_statsLogger.php,v 1.6 2010/03/16 13:00:12 manolis Exp $                                                                 
//
//************************************************************************

require_once dirname(__FILE__)."/FN_functions.php";

class statsLogger { 
	function statsLogger() {
	}
	
	function log($executionTime){
		global $CONF;
		global $db, $statsTable, $userID,$op, $flightID,$PREFS;
			
		if (! $CONF['stats']['enable']) return;

		list($agent,$version,$os,$aol)=findBrowserOS();

		$query = "INSERT into $statsTable (tm,year,month,day,userID,sessionID,visitorID,op,flightID,
											executionTime,os,browser,browser_version) 
				  VALUES (".time().",".date('Y').",".date('n').",".date('j').",$userID,
							".$PREFS->sessionID.",".$PREFS->visitorID.",'$op',$flightID,
							$executionTime,'$os','$agent','$version')";
		// echo $query;
		$res = $db->sql_query($query);
		if (! $res) { 
			echo "Problem in inserting stats entry into DB $query<br>";
			return 0;		
		}
		return 1;
	}

} // end of class



?>
<?php
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

require_once dirname(__FILE__)."/FN_pilot.php";

$serverFunctions['pilots.getPilots']='pilots_getPilots';


function pilots_getPilots($args) {
	$sitePass=$args[0];

	if ( ! securityCheck($sitePass)  ) return  new IXR_Error(4000, 'Access Denied');;

	$pilotsList=array(0);
	for ($i=1;  $i<count($args); $i++) {
		$getPilotID=$args[$i];
		$pilotsList[$i]=getPilotInfo($getPilotID,0) ;
	}
	
	return $pilotsList;
}


?>
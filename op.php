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

require_once dirname(__FILE__)."/lib/xml_rpc/IXR_Library.inc.php";

require_once dirname(__FILE__)."/site/config_op_mode.php";

require_once dirname(__FILE__)."/EXT_config_pre.php";
require_once dirname(__FILE__)."/config.php";
require_once dirname(__FILE__)."/EXT_config.php";

require_once dirname(__FILE__)."/CL_flightData.php";
require_once dirname(__FILE__)."/FN_functions.php";	
require_once dirname(__FILE__)."/FN_UTM.php";
require_once dirname(__FILE__)."/FN_waypoint.php";	
require_once dirname(__FILE__)."/FN_output.php";

$moduleRelPath=moduleRelPath(0);
$flightsWebPath=$moduleRelPath."/".$flightsRelPath;

function securityCheck($sitePass) {
	global $CONF_SitePassword;
	if ( $sitePass!=$CONF_SitePassword || !$sitePass) return 0;
	return 1;	
}

foreach (glob("OP_*.php") as $filename) {
	@include dirname(__FILE__)."/$filename";
}


/* Create the server and map the XML-RPC method names to the relevant functions */
$server = new IXR_Server( $serverFunctions );


?>
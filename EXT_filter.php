<?php

/************************************************************************/
/* Leonardo: Gliding XC Server											*/
/* ============================================							*/
/*																		*/
/* Copyright (c) 2004-5 by Andreadakis Manolis							*/
/* http://sourceforge.net/projects/leonardoserver						*/
/*																		*/
/* This program is free software. You can redistribute it and/or modify	*/
/* it under the terms of the GNU General Public License as published by	*/
/* the Free Software Foundation; either version 2 of the License.		*/
/************************************************************************/

require_once dirname(__FILE__).'/EXT_config_pre.php';
require_once dirname(__FILE__).'/config.php';
require_once dirname(__FILE__).'/EXT_config.php';
require_once dirname(__FILE__).'/CL_flightData.php';
require_once dirname(__FILE__).'/FN_functions.php';
require_once dirname(__FILE__).'/FN_UTM.php';
require_once dirname(__FILE__).'/FN_waypoint.php';
require_once dirname(__FILE__).'/FN_output.php';
require_once dirname(__FILE__).'/FN_pilot.php';
require_once dirname(__FILE__).'/FN_flight.php';
require_once $moduleRelPath.'/templates/'.$PREFS->themeName.'/theme.php';
setDEBUGfromGET();
require_once dirname(__FILE__).'/GUI_filter.php';

?>
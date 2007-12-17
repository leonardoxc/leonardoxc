<?
/************************************************************************/
/* Leonardo: Gliding XC Server					                                */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://sourceforge.net/projects/leonardoserver                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

 	require_once dirname(__FILE__)."/EXT_config_pre.php";
	require_once dirname(__FILE__)."/config.php";
 	require_once dirname(__FILE__)."/EXT_config.php";

	require_once dirname(__FILE__)."/CL_flightData.php";
	require_once dirname(__FILE__)."/FN_functions.php";
	require_once dirname(__FILE__)."/FN_UTM.php";
	require_once dirname(__FILE__)."/FN_waypoint.php";
	require_once dirname(__FILE__)."/FN_output.php";
	require_once dirname(__FILE__)."/FN_pilot.php";
	require_once dirname(__FILE__)."/FN_flight.php";
	require_once dirname(__FILE__)."/templates/".$PREFS->themeName."/theme.php";
	setDEBUGfromGET();
	require_once dirname(__FILE__)."/language/".CONF_LANG_ENCODING_TYPE."/lang-".$currentlang.".php";
	require_once dirname(__FILE__)."/language/".CONF_LANG_ENCODING_TYPE."/countries-".$currentlang.".php";


	require_once dirname(__FILE__)."/CL_dialogfilter.php";
	$dlgfilter=new dialogfilter();
	

  ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"  >
<html>
<head>
<title><?=$dlgfilter->dialog_title()?></title>
<meta http-equiv="content-type" content="text/html; charset=<?=$CONF_ENCODING?>">

<style type="text/css">
	html {
		height: 100%;
	}
	body, p, table,tr,td {
		font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px;
	}
	body {
		margin:0px;
		background-color:#E9E9E9;
		height: 100%;
	}
	.box {
	 	background-color:#F4F0D5;
	 	border:1px solid #555555;
		padding:3px;
		margin-bottom:5px;
	}
	.boxTop {margin:0; }
</style>
<?

	echo $dlgfilter->dialog_js_functions();

?>
</head>
<body style="height:100%;width:100%;">
<form name="form1" method="post" action="" style="height:100%;width:100%;">
<?
	echo $dlgfilter->dialog_html();
?>
</form>
</body>
</html>
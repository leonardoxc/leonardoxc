<?
//************************************************************************
// Leonardo XC Server, http://leonardo.thenet.gr
//
// Copyright (c) 2004-8 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: EXT_config.php,v 1.21 2008/11/29 22:46:06 manolis Exp $                                                                 
//
//************************************************************************

	@session_start();
	setVarFromRequest("lng",$PREFS->language); 

	$currentlang=$lng;
	$lang=$currentlang;
	$language=$currentlang;

	if ( $opMode==1) {
		$newlang=$currentlang;
		$inside_mod =1;
		define('INSIDE_MOD',1);
		require_once("../../mainfile.php");

		// re-set $module_name;
		$tmpDir=dirname(__FILE__);
		$tmpParts=split("/",str_replace("\\","/",$tmpDir));
		$module_name=$tmpParts[count($tmpParts)-1];
	} else if ( $opMode==2) {
		// require_once "language/lang-".$currentlang.".php";
		define('IN_PHPBB', true);
		$phpbb_root_path = dirname(__FILE__).'/../../';		
		$prefix="phpbb";
		require($phpbb_root_path . 'extension.inc');
		require($phpbb_root_path . 'common.'.$phpEx);
	}


	if ( strlen($currentlang)==2) { 
		$currentlang=array_search($currentlang,$lang2iso);
		if (!$currentlang) $currentlang=$PREFS->language;
	}


	if ($CONF_use_utf) {
		define('CONF_LANG_ENCODING_TYPE','utf8');
		$CONF_ENCODING='utf-8';
	} else  {
		define('CONF_LANG_ENCODING_TYPE','iso');
		$CONF_ENCODING=$langEncodings[$currentlang];
	}
	if (is_array($lang) )
		$lang['ENCODING']=$CONF_ENCODING;

	require_once dirname(__FILE__)."/language/".CONF_LANG_ENCODING_TYPE."/lang-".$currentlang.".php";

	session_start();
	$userID = $_SESSION['userID'];

	if ($CONF_use_utf) $db->sql_query("SET NAMES utf8");
?>
<? 
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://leonardo.thenet.gr 											*/
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

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

	if ($CONF_use_utf) {
		define('CONF_LANG_ENCODING_TYPE','utf8');
		$lang['ENCODING']='utf-8';
	} else  {
		define('CONF_LANG_ENCODING_TYPE','iso');
		$lang['ENCODING']=$langEncodings[$currentlang];
	}

	require_once dirname(__FILE__)."/language/".CONF_LANG_ENCODING_TYPE."/lang-".$currentlang.".php";

	session_start();
	$userID = $_SESSION['userID'];

?>
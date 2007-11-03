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

	//	$currentlang="english";
	@session_start();
	setVarFromRequest("lng",$PREFS->language); 
	$currentlang=$lng;

	//	$currentlang=$PREFS->language;
	$lang=$currentlang;
	$language=$currentlang;

	
	if ( $opMode==2) {
		require_once "language/lang-".$currentlang.".php";
		define('IN_PHPBB', true);
		$phpbb_root_path = dirname(__FILE__).'/../../';
		//WAS
		// 		$phpbb_root_path = '../../';
		$prefix="phpbb";
		require($phpbb_root_path . 'extension.inc');
		require($phpbb_root_path . 'common.'.$phpEx);
	} else if ( $opMode==1) {
		$newlang=$currentlang;
		$inside_mod =1;
		define('INSIDE_MOD',1);
		require_once("../../mainfile.php");

		// re-set $module_name;
		$tmpDir=dirname(__FILE__);
		$tmpParts=split("/",str_replace("\\","/",$tmpDir));
		$module_name=$tmpParts[count($tmpParts)-1];
	}  else if ( $opMode==3 || $opMode==4 ) {
		$newlang=$currentlang;
		$inside_mod =1;
		define('INSIDE_MOD',1);
		// require_once dirname(__FILE__)."/includes/mainfile.php";
		require_once "language/lang-".$currentlang.".php";
		// re-set $module_name;
		$tmpDir=dirname(__FILE__);
		$tmpParts=split("/",str_replace("\\","/",$tmpDir));
		$module_name=$tmpParts[count($tmpParts)-1];
	}

/*
	$baseInstallationPath="";
	$parts=explode("/",$_SERVER['REQUEST_URI']);

	if ( count($parts)>1 )  {
		for($i=1;$i<count($parts);$i++) {
		   if ($parts[$i-1]=="modules") break;
		   if ($parts[$i-1]!='') $baseInstallationPath.="/".$parts[$i-1];	
		}
	}
*/
		
 session_start();
 $userID = $_SESSION['userID'];

?>
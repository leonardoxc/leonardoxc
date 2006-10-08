<?php

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

$currentlang=$lang=$language=$PREFS->language;		// "english"

switch ($opMode)
{
case 1:
	$newlang=$currentlang;
	$inside_mod=1;
	define('INSIDE_MOD',1);
	require_once '../../mainfile.php';
	$tmpDir=dirname(__FILE__);								// re-set $module_name;
	$tmpParts=split('/',str_replace("\\",'/',$tmpDir));
	$module_name=$tmpParts[count($tmpParts)-1];
	break;

case 2:
	require_once 'language/lang-'.$currentlang.'.php';
	define('IN_PHPBB',true);
	$phpbb_root_path='../../';
	$prefix='phpbb';
	require $phpbb_root_path.'extension.inc';
	require $phpbb_root_path.'common.'.$phpEx;
	break;

case 3:
	$newlang=$currentlang;
	$inside_mod=1;
	define('INSIDE_MOD',1);
	require_once 'mainfile.php';
	$tmpDir=dirname(__FILE__);								// re-set $module_name;
	$tmpParts=split('/',str_replace("\\",'/',$tmpDir));
	$module_name=$tmpParts[count($tmpParts)-1];
	break;
}

$baseInstallationPath='';

if (count($parts=explode('/',$_SERVER['REQUEST_URI']))>1)
{
	for ($i=1; $i<count($parts); $i++)
	{
		if ($parts[$i-1]=='modules')
			break;

		if ($parts[$i-1]!='')
			$baseInstallationPath.='/'.$parts[$i-1];
	}
}

?>
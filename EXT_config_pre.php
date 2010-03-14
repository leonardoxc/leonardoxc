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
// $Id: EXT_config_pre.php,v 1.12 2010/03/14 20:56:10 manolis Exp $                                                                 
//
//************************************************************************
//	define('EXT_CONFIG',1);
	
	//$tmpDir=dirname(__FILE__);
	//$tmpParts=split("/",str_replace("\\","/",$tmpDir));
	//$module_name=$tmpParts[count($tmpParts)-1]; 

//	$moduleAbsPath=dirname(__FILE__);
//	$moduleRelPath=".";

	$isExternalFile=1;	
    require_once dirname(__FILE__)."/site/config_op_mode.php";
	if ($opMode==5 && $CONF_use_own_template==1) { // Joomla
		define( '_JEXEC', 1 );
		define( 'DS', DIRECTORY_SEPARATOR );		
		
		require_once JPATH_BASE.DS.'includes'.DS.'defines.php';
		require_once JPATH_BASE.DS.'includes'.DS.'framework.php';
		$mainframe =& JFactory::getApplication('site');
		$user   =& JFactory::getUser();   
	}
/*

	if (!$baseInstallationPathSet) {
		$baseInstallationPath="";
		$baseInstallationPathSet=1;
		$parts=explode("/",$_SERVER['REQUEST_URI']);
	
		if ( count($parts)>1 )  {
			for($i=1;$i<count($parts);$i++) {
			   // if ($parts[$i-1]=="modules") break;
			   if ($parts[$i-1]!='') $baseInstallationPath.="/".$parts[$i-1];	
			}
		}
	}
*/
?>
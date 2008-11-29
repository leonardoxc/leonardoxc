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
// $Id: EXT_config_pre.php,v 1.10 2008/11/29 22:46:06 manolis Exp $                                                                 
//
//************************************************************************
//	define('EXT_CONFIG',1);
	
	//$tmpDir=dirname(__FILE__);
	//$tmpParts=split("/",str_replace("\\","/",$tmpDir));
	//$module_name=$tmpParts[count($tmpParts)-1]; 

//	$moduleAbsPath=dirname(__FILE__);
//	$moduleRelPath=".";

	$isExternalFile=1;
	/*
    require dirname(__FILE__)."/site/config_op_mode.php";


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
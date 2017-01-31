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
// $Id: OP_server.php,v 1.7 2010/03/14 20:56:11 manolis Exp $                                                                 
//
//************************************************************************


// this runs on the slave servers so that the master can upload updates
$serverFunctions['server.uploadFileFromUrl']='uploadFileFromUrl';
function uploadFileFromUrl($arg) {
	$sitePass=$arg[0];
	$remoteFile=$arg[1];
	$localFile=$arg[2];

	global $CONF_SitePassword;	

	if ( ! securityCheck($sitePass) ) return  new IXR_Error(4000, 'Access Denied');;

	if ( ($fileStr=@file_get_contents($remoteFile)) === FALSE) 
		return  new IXR_Error(4001, "Cant access file ($remoteFile) to upload");	
	if ( ! (strpos($localFile,"..") === FALSE) ) 
		return  new IXR_Error(4002, "Invalid local file ($localFile)");	
	$f1=$fileStr;
	
	$filename=dirname(__FILE__)."/$localFile";
	if (!$handle = fopen($filename, 'w'))  
		return new IXR_Error(4003, "Cannot open file ($filename)");	

	if (fwrite($handle, $fileStr)===FALSE) 
		return new IXR_Error(4004, "Cannot write to file ($filename)");	

   	fclose($handle); 
	return 1;
}

// this runs on the slave servers so that the master can upload updates
$serverFunctions['server.uploadFileInline']='uploadFileInline';
function uploadFileInline($arg) {
	$sitePass=$arg[0];
	$remoteFile_base64=$arg[1];
	$localFile=$arg[2];

	global $CONF_SitePassword;	
	if ( ! securityCheck($sitePass) ) return  new IXR_Error(4000, 'Access Denied');;

	if ( ! (strpos($localFile,"..") === FALSE) ) 
		return  new IXR_Error(4002, "Invalid local file ($localFile)");	

	$fileStr=base64_decode($remoteFile_base64);		
	$filename=dirname(__FILE__)."/$localFile";
	if (!$handle = fopen($filename, 'w'))  
		return new IXR_Error(4003, "Cannot open file ($filename)");	

	if (fwrite($handle, $fileStr)===FALSE) 
		return new IXR_Error(4004, "Cannot write to file ($filename)");	

   	fclose($handle); 
	return 1;
}

$serverFunctions['server.info']='server_info';
function server_info($arg) {
	$sitePass=$arg;
	global $CONF_SitePassword;	
	global $CONF_version,$CONF_releaseDate, $opMode, $CONF_isMasterServer, $CONF_admin_email;	
	if ( ! securityCheck($sitePass) ) return  new IXR_Error(4000, 'Access Denied');
	return array($CONF_version,$CONF_releaseDate, $opMode, $CONF_isMasterServer, 
				$CONF_admin_email,PHP_VERSION,mysql_get_server_info() ,mysql_get_client_info() );
}


$serverFunctions['server.module_info']='server_module_info';
function server_module_info($arg) {
	$sitePass=$arg;
	global $CONF_SitePassword;	
	global $CONF_version,$CONF_releaseDate, $opMode, $CONF_isMasterServer, $CONF_admin_email;
	
	if ( ! securityCheck($sitePass) ) return  new IXR_Error(4000, 'Access Denied');
	return array($CONF_version,$CONF_releaseDate, $opMode, $CONF_isMasterServer, $CONF_admin_email);
}

// this function runs only on the Master Server to register slave servers
require_once dirname(__FILE__).'/CL_server.php';
$serverFunctions['server.registerSlave']='registerSlave';
function registerSlave($arg) {
	$installType=$arg[0];
	$leonardo_version=$arg[1];
	$url=$arg[2];
	$url_base=$arg[3];
	$url_op=$arg[4];
	$adminEmail=$arg[5];
	$sitePass=$arg[6];

	global $CONF_isMasterServer;	
	if (!$CONF_isMasterServer)	
		return new IXR_Error(5001, "Not a Master server");	
if (0){
	$newServer=new Server();
	$newServer->ID= Server::getNextFreeID();
	$newServer->isLeo=1;
	$newServer->installation_type	=$installType;
	$newServer->leonardo_version	=$leonardo_version ;
	$newServer->url					=$url;
	$newServer->url_base			=$url_base;
	$newServer->url_op				=$url_op;
	$newServer->admin_email			=$adminEmail;
	$newServer->site_pass			=$sitePass;
	$newServer->is_active			=0;
	$newServer->gives_waypoints		=1;
	$newServer->waypoint_countries	='';

	$res=$newServer->putToDB();
}


	$fileStr="$installType#$leonardo_version#$url#$url_op#$adminEmail#$sitePass\n";
	$filename=dirname(__FILE__)."/DB_of_servers.txt";
    if (!$handle = fopen($filename, 'a'))  
		return new IXR_Error(5002, "Cannot open file ($filename)");	

	if (fwrite($handle, $fileStr)===FALSE) 
		return new IXR_Error(5003, "Cannot write to file ($filename)");	
		
    fclose($handle); 

	return 1;
}


?>
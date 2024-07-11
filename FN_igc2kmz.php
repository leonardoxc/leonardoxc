<?
//************************************************************************
// Leonardo XC Server, https://github.com/leonardoxc/leonardoxc
//
// Copyright (c) 2004-2010 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: FN_igc2kmz.php,v 1.19 2011/01/31 15:04:47 manolis Exp $                                                                 
//
//************************************************************************

function igc2kmz($file,$outputFile,$timezone,$flightID) {
	global $CONF,$CONF_tables_prefix,$baseInstallationPath,$db;
	$str="";

	$version=$CONF['googleEarth']['igc2kmz']['version'];
	
	$kmzFile=$outputFile.".$version.kmz";
	deleteOldKmzFiles($outputFile,$version);
	
	// exit;
	if ( is_file($kmzFile) ) return $version;

	$python=$CONF['googleEarth']['igc2kmz']['python'];
	putenv('PYTHON_EGG_CACHE='.dirname(__FILE__).'/data/tmp');
	
	// put some env for python2.5?
	// putenv("PATH=".$CONF['googleEarth']['igc2kmz']['python'] );
	putenv("PATH=/usr/local/bin/" );
	
	
	$path=realpath($CONF['googleEarth']['igc2kmz']['path']);
	if (! defined('SQL_LAYER') )  define('SQL_LAYER','mysql');
	
	
	
	global $phpbb3AbsPath, $dbhost,$dbname,$dbuser,$dbpasswd;
	$dbpasswdCon=$dbpasswd;
	if (!$dbpasswdCon) $dbpasswdCon=$db->password;
	
	$dbhostCon=$dbhost;
	if (!$dbhostCon) $dbhostCon=$db->server;
	if (!$dbhostCon) $dbhostCon='localhost';

	$engine=SQL_LAYER."://".$db->user.':'.$dbpasswdCon.'@'.$dbhostCon.'/'.$db->dbname;
	
	$cmd="$python $path/bin/leonardo2kmz.py";
	$cmd.=" --engine '$engine'";
	$cmd.=" --table-prefix=$CONF_tables_prefix";
	$cmd.=" --directory '".realpath(dirname(__FILE__))."'";
	// $cmd.=" --igcpath '".dirname(__FILE__).'/'.$CONF['paths']['intermediate']."'";
	// $cmd.=" --directory '".realpath(dirname(__FILE__).'/../..')."'";
	$cmd.=" --url 'http://".$_SERVER['SERVER_NAME']."$baseInstallationPath'";
	
// 	$cmd.=" --icon '$baseInstallationPath/templates/basic/tpl/leonardo_logo.gif' ";
//	$cmd.=" --photos_path '".$CONF['paths']['photos']."' ";
//	$cmd.=" --photos_url '$baseInstallationPath/'".$CONF['paths']['photos']."'' ";

	//DEFAULT_PHOTOS_PATH = 'data/flights/photos/%YEAR%/%PILOTID%'
	//DEFAULT_PHOTOS_URL = '/modules/leonardo/data/flights/photos/%YEAR%/%PILOTID%'
	
	$cmd.=" --output '$kmzFile'";
	$cmd.=" --tz-offset $timezone";
	$cmd.=" --igc-path=".$CONF['paths']['intermediate']." "; // data/flights/intermediate/%YEAR%/%PILOTID%
	$cmd.=" $flightID";
	
		
	DEBUG('igc2kmz',1,"igc2kmz: $cmd <BR>");


	exec($cmd,$res);
	
	
	if (0) {
		//echo "timezone: $timezone<br>";
		echo "cmd: $cmd<BR>";
		print_r($res);
		//print_r($db);
		//echo "$dbhost ,	$dbname ,$dbuser ,$dbpasswd @";
		exit;
	}	
	return $version;
}

function deleteOldKmzFiles($file,$version) {
	// echo "$file,$version #";
	$dir=dirname($file);
	$name=basename($file).'.';
	$namelen=strlen($name);

	if ( !is_dir($dir) ) return;

	$current_dir = opendir($dir);
	while($entryname = readdir($current_dir)){
		// echo "^ $entryname ^<BR> ";
		if (preg_match("/$name([\d\.]+)\.kmz$/",$entryname,$matches) ) {
			// print_r($matches);
			if ($matches[1] != $version ) {
		   		unlink("${dir}/${entryname}");
			}	
		}
	}
	closedir($current_dir);
	
}

?>

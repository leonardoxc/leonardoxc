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
// $Id: FN_igc2kmz.php,v 1.9 2008/12/04 22:45:24 manolis Exp $                                                                 
//
//************************************************************************

function igc2kmz($file,$timezone,$flightID) {
	global $CONF,$CONF_tables_prefix,$baseInstallationPath,$db;
	$str="";

	$version=$CONF['googleEarth']['igc2kmz']['version'];
	
	$kmzFile=$file.".igc2kmz.$version.kmz";
	deleteOldKmzFiles($file,$version);
	
	// exit;
	if ( is_file($kmzFile) ) return $version;

	$python=$CONF['googleEarth']['igc2kmz']['python'];
	$path=realpath($CONF['googleEarth']['igc2kmz']['path']);
	$engine=constant('SQL_LAYER')."://".$db->user.':'.$db->password.'@'.$db->server.'/'.$db->dbname;
	
	$cmd="$python $path/bin/leonardo2kmz.py";
	$cmd.=" --engine '$engine'";
	$cmd.=" --table-prefix=$CONF_tables_prefix";
	$cmd.=" --directory '".realpath(dirname(__FILE__).'/../..')."'";
	$cmd.=" --url 'http://".$_SERVER['SERVER_NAME']."$baseInstallationPath'";
	$cmd.=" --output '$kmzFile'";
	$cmd.=" --tz-offset $timezone";
	$cmd.=" $flightID";

	exec($cmd,$res);

	if (0) {
		echo "timezone: $timezone<br>";
		echo "cmd: $cmd<BR>";
		print_r($res);
		exit;
	}	
	return $version;
}

function deleteOldKmzFiles($file,$version) {
	// echo "$file,$version #";
	$dir=dirname($file);
	$name=basename($file).'.igc2kmz.';
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

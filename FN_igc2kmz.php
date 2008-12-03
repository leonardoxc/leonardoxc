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
// $Id: FN_igc2kmz.php,v 1.6 2008/12/03 10:33:14 tom Exp $                                                                 
//
//************************************************************************

function igc2kmz($file,$timezone,$flightID) {
	global $CONF;
	$str="";

	$version=$CONF['googleEarth']['igc2kmz']['version'];
	
	$kmzFile=$file.".igc2kmz.$version.kmz";
	deleteOldKmzFiles($file,$version);
	
	// exit;
	if ( is_file($kmzFile) ) return $version;

	$path=$CONF['googleEarth']['igc2kmz']['path'];
	
	$cmd="$path/bin/leonardo2kmz.py -o '$kmzFile' -z $timezone $flightID";
	exec($cmd,$res);

	if (0) {
		echo " $timezone,$pilot,$glider # ";
		echo $cmd;
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
		if (preg_match("/$name(\d)+/",$entryname,$matches) ) {
			// print_r($matches);
			if ($matches[1] != $version ) {
		   		unlink("${dir}/${entryname}");
			}	
		}
	}
	closedir($current_dir);
	
}

?>

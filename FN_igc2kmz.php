<?
/*
Copyright Tom Payne
http://github.com/twpayne/igc2kmz/wikis/quickstart

Usage: igc2kmz.py [options]

IGC to Google Earth converter

Options:
  -h, --help            show this help message and exit
  -o FILENAME, --output=FILENAME
  -z HOURS, --timezone-offset=HOURS
  -r FILENAME, --root=FILENAME

  Per-flight options:
    -i FILENAME, --igc=FILENAME
    -n STRING, --pilot-name=STRING
    -g STRING, --glider-type=STRING
    -c COLOR, --color=COLOR
    -w INTEGER, --width=INTEGER
    -x FILENAME, --xc=FILENAME

  Per-photo options:
    -p FILENAME, --photo=FILENAME
    -d STRING, --description=STRING
*/
function igc2kmz($file,$timezone,$pilot,$glider,$photos) {
	global $CONF;
	$str="";

	$version=$CONF['googleEarth']['igc2kmz']['version'];
	
	$kmzFile=$file.".igc2kmz.$version.kmz";
	deleteOldKmzFiles($file,$version);
	
	// exit;
	// if ( is_file($kmzFile) ) return $version;

	$path=$CONF['googleEarth']['igc2kmz']['path'];
	
	$photoStr='';
	if (count($photos)) {
		foreach($photos as $i=>$photo){
			$photoStr.=" -p \"$photo\" ";
		}
	}
	$cmd="cd $path/bin ; ./igc2kmz.py -i $file -o $kmzFile -z $timezone -n '$pilot' -g '$glider' $photoStr";
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
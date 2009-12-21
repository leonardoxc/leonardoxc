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
// $Id: GUI_admin_paths.php,v 1.1 2009/12/21 14:48:05 manolis Exp $                                                                 
//
//************************************************************************

	echo "<hr><h3>ADMIN: Move files to new path locations</h3>";

	if (! L_auth::isAdmin($userID) ) {
		echo "<BR><BR>Not authorized<BR><BR>";
		return;
	}
		
	
	$query="SELECT * FROM $flightsTable ";
	
	$res= $db->sql_query($query);
	if($res <= 0){
	 echo("<H3> Error in query! </H3>\n");
	 exit();
	}
	
	//echo "List of filenames<HR><pre>\r\n";

	global $CONF;	
	$output1='';
	$output2='';
	while ($row = $db->sql_fetchrow($res)) { 
		if (!$row['filename']) continue;	
		
		$userDir='';
		if ($row['userServerID']) {
			$userDir=$row['userServerID'].'_';
		}	
		$userDir.=$row['userID'];
			
		$year=substr($row['DATE'],0,4);
		$filename=$row['filename'];
			
		$files[$f][0]="$userDir/flights/$year/$filename";
		$files[$f][1]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$CONF['paths']['igc']) )."/$filename";
		$dirs[$d++]=dirname($files[$f][1]);
		$f++;
			
		$dirs[$d++]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$CONF['paths']['photos']) );
		$dirs[$d++]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$CONF['paths']['map']) );
		$dirs[$d++]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$CONF['paths']['charts']) );
		$dirs[$d++]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$CONF['paths']['kml']) );
		$dirs[$d++]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$CONF['paths']['js']) );
		$dirs[$d++]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$CONF['paths']['intermediate']) );
		
		
		foreach ($dirs as $dir ){
			$output2.="mkdir -p $dir\r\n";
		}
		foreach ($files as $f=>$farray ){
			$output1.=$farray[0].";";	
			$output2.="cp -a flights/".$farray[0]." ".$farray[1]."\r\n";	
		}
		$output1.="\r\n";	
		$output2.="\r\n";					
		$igcNum++;		

/*	
// the main IGC file
$CONF['paths']['igc']	='data/flights/tracks/%YEAR%/%PILOTID%';
// photo filenames
$CONF['paths']['photos']='data/flights/photos/%YEAR%/%PILOTID%';
// The rest can be ommited from Backup!!!
// *.jpg
$CONF['paths']['map']	='data/flights/maps/%YEAR%/%PILOTID%';
// *.png 16 files / flight
$CONF['paths']['charts']='data/flights/charts/%YEAR%/%PILOTID%';
// *.kmz
// *.man.kmz
// *.igc2kmz.[version].kmz
$CONF['paths']['kml']	='data/flights/kml/%YEAR%/%PILOTID%';
// *.json.js
$CONF['paths']['js']	='data/flights/js/%YEAR%/%PILOTID%';
// *.1.txt
// *.poly.txt
// *.saned.full.igc
// *.saned.igc
$CONF['paths']['intermediate']	='data/flights/intermediate/%YEAR%/%PILOTID%';
*/
		
		
	
	}		
	
	//echo $output;
	
	$filename='files_list.csv';
	$fp=fopen(dirname(__FILE__)."/$filename","w" );
	fwrite($fp,$output1);
	fclose($fp);
	
	$filename2='copy_files.sh';
	$fp2=fopen(dirname(__FILE__)."/$filename2","w" );
	fwrite($fp2,$output2);
	fclose($fp2);
	
	// echo "\r\n</pre><HR>";
	echo "Flights found : $igcNum<HR><BR>";
	
	echo "A file named $filename (and <a href='data/flights/$filename2' target='_blank'>$filename2</a> with the shell commands) has been created in leonardo/data/flights directory.
		 Check that the file is deleted on the server afterwards<BR>
	 Execute this command on a shell:<BR>";
	
	
	//echo "<hr>cd ".dirname(__FILE__)."/flights; rm -f tracks.tgz; sed 's/.$//' $filename  > ".$filename.
	//		".2 ; tar cfz tracks.tgz -T ".$filename.".2; rm -f export_* ; ls -la tracks.tgz <HR>";
	return;


?>
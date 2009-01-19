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
// $Id: GUI_flights_export.php,v 1.1 2009/01/19 13:21:19 manolis Exp $                                                                 
//
//************************************************************************

	
	function replace_spaces($str) {
		return str_replace(" ","&nbsp;",$str);
	}

	$legend="";
	$legend="<b>ADMIN: Export IGC Tracklogs</b> ";

	if (! L_auth::isAdmin($userID) ) {
		echo "<BR><BR>Not authorized<BR><BR>";
		return;
	}
		
	
	require_once dirname(__FILE__).'/SQL_list_flights.php';
	
	require_once dirname(__FILE__)."/MENU_second_menu.php";
	// now the real query	
	
	$query=str_replace("WHERE ","WHERE filename<>'' AND ",$query);
	
	$res= $db->sql_query($query);
	echo "ORIGINAL QUERY (Additional filtering is DONE in your PHP CODE )<HR><p>$query</p><br>";
	if($res <= 0){
	 echo("<H3> Error in query! </H3>\n");
	 exit();
	}
	
	//echo "List of filenames<HR><pre>\r\n";
	
	// define a bounding BOX
	if (false) {
		$boundBox['minLat']=43.1589;
		$boundBox['maxLat']=48.1717;
		
		$boundBox['minLon']=6.11194;
		$boundBox['maxLon']=13.5261;
	}
	$output='';
	while ($row = $db->sql_fetchrow($res)) { 
	
		// comment/ uncoment the filters below !!!!\
		
		// simple case , if not file exists ( NOT locally sunmiteed) continue
		if (!$row['filename']) continue;
		// drop flights with MAX distance  < 10km
		//if (  $row['MAX_LINEAR_DISTANCE'] < 10000 ) continue;		
		// drop flights with duration < 1 hr
		//if  ( $row['DURATION'] <3600  ) continue;
		// drop flights with heiught gain above takeoiff <100 m
		//if (  ( $row['MAX_ALT'] -$row['TAKEOFF_ALT'])  < 100  ) continue;
		// select specific dates
		//if ($row['DATE'] < '2008-06-01' || $row['DATE']  > '2008-08-31' ) continue;		

		// select a bounding box				
		if ($boundBox['minLat'] && $boundBox['maxLat']){
			if ($row['firstLat'] < $boundBox['minLat'] || $row['firstLat'] > $boundBox['maxLat'] ) continue;			
			if ($row['firstLon'] < $boundBox['minLon'] || $row['firstLon'] > $boundBox['maxLon'] ) continue;
		}		
		
		$igcPath='';
		if ($row['userServerID']) 
			$igcPath.=$row['userServerID'].'_';
		$igcPath.=$row['userID']."/flights/".substr($row['DATE'],0,4)."/".$row['filename'];
		if ( is_file(  dirname(__FILE__).'/flights/'.$igcPath ) ) {
			$output.=$igcPath."\r\n";				
			$igcNum++;		
		}	
	}		
	
	//echo $output;
	
	$filename='export_'.rand(1,999999);
	$fp=fopen(dirname(__FILE__)."/flights/$filename","w" );
	fwrite($fp,$output);
	fclose($fp);
	
	// echo "\r\n</pre><HR>";
	echo "Flights found : $igcNum<HR><BR>";
	
	echo "A file named $filename has been created in leonardo/flights directory.
		 Check that the file is deleted on the server afterwards<BR>
	 Execute this command on a shell:<BR>";
	
	
	echo "<hr>cd ".dirname(__FILE__)."/flights; rm -f tracks.tgz; sed 's/.$//' $filename  > ".$filename.
			".2 ; tar cfz tracks.tgz -T ".$filename.".2; rm -f export_* ; ls -la tracks.tgz <HR>";
	return;


?>
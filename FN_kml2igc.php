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
// $Id: FN_kml2igc.php,v 1.4 2010/03/14 20:56:10 manolis Exp $                                                                 
//
//************************************************************************

function kml2igc($filename){
	$l=file($filename);
	for($i=0;$i<count($l);$i++) {
		$l[$i]=trim($l[$i]);
	}
	$lines=implode(" ",$l);
	
	//echo $lines;
	//exit;
	
	if( ! preg_match("/<SecondsFromTimeOfFirstPoint>(.*)<\/SecondsFromTimeOfFirstPoint>/",$lines,$matches) ) {
		return 0;
	}
	
	//	echo "match<BR>";
	// echo $matches[1];
	$tm=explode(" ",trim($matches[1]));
	// echo count($tm).'<br>';
	
	// 	now search for this
	//	<FsInfo time_of_first_point="2007-04-05T09:51:50Z"
	//                hash="2E361EB937B9D7D6C92855F38D37B399B17292AD">
//	if( ! preg_match("/<FsInfo *time_of_first_point=\"([^\"]+)\" *hash=\"(.*)\">/i",$lines,$matches) ) {
//		return 0;
//	}
/*
this is the new format from kml
        <FsInfo time_of_first_point="2007-04-22T13:42:06Z"
                civl_pilot_id="4" comp_pilot_id="4"
                instrument="GPS 72 Software Version 2.30"
                downloaded="2007-04-29T12:39:49Z"
                hash="80F1FAC5CFFE4B97E202371EF6303BFCF83A6D78">
I'm a zero at the left in regular expressions, then i change a litle to 
this one...

*/

	if( ! preg_match("/<FsInfo.*time_of_first_point=\"([^\"]+)\".*hash=\"([^\"]+)\">/i",$lines,$matches) ) {
		return 0;
	}

	//echo "match start time<BR>";
	// echo $matches[1];
	$start_time_str=trim($matches[1]);
	$hash_str=trim($matches[2]);
	// echo "$start_time_str  # $hash_str<BR>";
				
	// now search for this
	/* <name>Tracklog</name>
		  <LineString>
			<altitudeMode>absolute</altitudeMode>
			<coordinates>
	*/	
	if(! preg_match("/<name>Tracklog<\/name> *<LineString> *<altitudeMode>absolute<\/altitudeMode> *<coordinates>(.*)<\/coordinates>/",$lines,$matches) ) {
		return 0;
	}
	
	//echo "match coordinates<BR>";
	// echo $matches[1];
	$coords=explode(" ",trim($matches[1]));
	//echo count($coords);			
	// print_r($coords);
	
	require_once dirname(__FILE__).'/CL_gpsPoint.php';
	// now make the igc file
	for($i=0;$i<count($coords);$i++){
		if ($i==0) {
			// igc date-> ddmmyy
			//              01234567890123456789
			// kml date -> "2007-04-05T09:51:50Z"
			$dateStr=substr($start_time_str,8,2).substr($start_time_str,5,2).substr($start_time_str,2,2);
			// echo substr($start_time_str,11,2)." ".substr($start_time_str,14,2)." ".substr($start_time_str,17,2);
			
			$startTimeSecs=substr($start_time_str,11,2)*3600+substr($start_time_str,14,2)*60+substr($start_time_str,17,2);
			$igc.=
			"HFDTE$dateStr\r\n".
			// "HFPLTPilot: $user \r\n".
			// "HFTZOTimezone:2\r\n".
			"HFSITSite:\r\n".
			"HPGTYGliderType:\r\n".
			"HPGIDGliderID:\r\n".
			"HFDTM100DATUM:WGS-1984\r\n".
			"HFCIDCOMPETITIONID:\r\n".
			"HFCCLCOMPETITIONCLASS:\r\n".
			"HFFXA100\r\n".
			"HFRHWHARDWAREVERSION:1.00\r\n".
			"HFFTYFRTYPE:Convert from GPSDump KML\r\n";
			
		}
		// echo $coords[$i].'<BR>';
		$thisPoint=new gpsPoint();
		list($lon,$lat,$alt)=explode(",",$coords[$i]);
		$thisPoint->lat=$lat+0;
		$thisPoint->lon=-$lon+0;
		$thisPoint->gpsAlt=$alt+0;
		$thisPoint->gpsTime=($startTimeSecs+$tm[$i]) %(3600*24);
		$igc.=$thisPoint->to_IGC_Record()."\r\n";				
	}	
	//echo $igc;

	// write the igc to disk
	// $igcfilename=substr($filename,0,-3).'igc';
	
	// overwrite the original
	$igcfilename=$filename;
	if (!$handle = fopen($igcfilename, 'w')) { 
		print "Cannot open file ($igcfilename)"; 
		return 0;; 
	} 
	
	// Write $somecontent to our opened file. 
	if (!fwrite($handle, $igc)) { 
	   print "Cannot write to file ($igcfilename)"; 
	   return 0; 
	} 
	fclose($handle); 	
	return 1;
	
}

?>
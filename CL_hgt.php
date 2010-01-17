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
// $Id: CL_hgt.php,v 1.6 2010/01/17 15:28:19 manolis Exp $                                                                 
//
//************************************************************************

/*
An HGT file covers an area of 1°x1°. Its south western corner can
 be deduced from its file name: for example, 

n51e002.hgt covers the area between 
N 51° E 2° and N 52° E 3°, 

and s14w077.hgt covers
S 14° W 77° to S 13° W 76°. 
The file size depends on the resolution.

If this is 1", there are 3601 rows of 3601 cells each; 

*** If it is 3", there are 1201 rows of 1201 cells each. 

The rows are laid out like text on a page, starting with the northernmost row, with each row reading 
from west to east. 

Each cell has two bytes, and the elevation at that cell is 256*(1st byte) + (2nd byte). 
It follows that a 3" HGT file  has a file length of 2 x 1201 x 1201. 

*/


//  This is the file used for 3d elevation

$openDEMfiles=array();
global $openDEMfiles,$CONF_DEMpath;

class hgt {

function getHeight($lat,$lon) {
	global $openDEMfiles,$CONF_DEMpath;

	if ($lat>=0) {
		$latSouth=floor($lat);
		//$latNorth=$latSouth+1;
		$latD=1-$lat+$latSouth;
		$latStr="N";
	} else {
		$latSouth=ceil(abs($lat));
		// $latNorth=$latSouth-1;
		$latD=-$lat-$latSouth+1;
		$latStr="S";
	}
	
	if ($lon>=0){
		$lonWest=floor($lon);
		//$lonEast=$lonWest+1;
		$lonD=$lon-$lonWest;
		$lonStr="E";
	} else {
		$lonWest=ceil(abs($lon));
		//$lonEast=$lonWest-1;
		$lonD=$lonWest+$lon;
		$lonStr="W";
	}

	// find the file to use!
	$demFile=sprintf("%s%02d%s%03d.hgt.zip",$latStr,$latSouth,$lonStr,$lonWest);

	if ( ! isset($openDEMfiles[$demFile])  )  {
		// echo "Getting DEM file: $demFile<BR>";
		if (!is_file($CONF_DEMpath.'/'.$demFile)) {
			// echo "#not found ".$CONF_DEMpath.'/'.$demFile."#";
			return 0;
		}
		
		require_once(dirname(__FILE__).'/lib/pclzip/pclzip.lib.php');
		$archive = new PclZip($CONF_DEMpath.'/'.$demFile);
		$list=$archive->extract(PCLZIP_OPT_EXTRACT_AS_STRING);
		if ( $list == 0) { 
			// 
			return 0;
			// die("Error : ".$archive->errorInfo(true));
		} else  {
			//	echo $list[0]['content'];	  
		}
		$openDEMfiles[$demFile]=$list[0]['content'];
	}
	  	
	// find x,y inside the file
	// 1 degree is 1201 points
	$x=floor($lonD*1201);
	$y=floor($latD*1201);
	
	// point offeset in file
	$pointOffset=($x+$y*1201)*2;
	// echo "$latD $lonD $x $y  $pointOffset<BR>";		

	$alt=ord($openDEMfiles[$demFile][$pointOffset])*256+ord($openDEMfiles[$demFile][$pointOffset+1]);
	if ($alt>10000) $alt=0;
	return $alt;
}

} // end of class


/* usage :
	$lat=40.4879667;
	$lon=23.1730500;
	// height =476 !!
	
	$alt=hgt::getHeight($lat,$lon);
	echo "$lat,$lon -> $alt<BR>";

	or test multiple lat/lon
for ($dlat=0;$dlat<100;$dlat++) 
	for ($dlon=0;$dlon<100;$dlon++)  {
		$lat=40.0+$dlat/100;
		$lon=23.1+$dlon/100;
		$alt=hgt::getHeight($lat,$lon);
		//echo "$lat,$lon -> $alt<BR>";
		echo "$alt, ";
	}
*/

?>
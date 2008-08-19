<? 
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://sourceforge.net/projects/leonardoserver                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


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

global $openDEMfiles,$missingDEMfiles;
$openDEMfiles=array();
$missingDEMfiles=array();

class DEM {

	function DEM() {
	
	}
	
	function getAlt($lat,$lon) {
		global $CONF_DEMpath,$openDEMfiles,$missingDEMfiles;
		
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
		// $demFile="N40E023";
		$demFile=sprintf("%s%02d%s%03d.hgt.zip",$latStr,$latSouth,$lonStr,$lonWest);
		
		$demZipFile=$CONF_DEMpath.'/'.$demFile;
		
		if ($missingDEMfiles[$demFile]) return -9999;
		
		// see if it already open
		if ( ! $openDEMfiles[$demFile] ) {
		
			  if (!is_file($demZipFile)) {			  
			  	$missingDEMfiles[$demFile]=1;
				return -9999;
			  }
				//	$openDEMfiles[$demFile]=file_get_contents($CONF_DEMpath.$demFile);
			  require_once dirname(__FILE__).'/lib/pclzip/pclzip.lib.php';
			  $archive = new PclZip($demZipFile);
			  $list=$archive->extract(PCLZIP_OPT_EXTRACT_AS_STRING);
			  if ( $list == 0) {
				DEBUG("DEM",255,"DEM::getAlt : ".$archive->errorInfo(true)."<BR>");
			  	return -9999;
				// die("Error : ".$archive->errorInfo(true));
			  } else  {
			    $openDEMfiles[$demFile]=$list[0]['content'];			  
			  }
		}
		
		// find x,y inside the file
		// 1 degree is 1201 points
		$x=floor($lonD*1201);
		$y=floor($latD*1201);
		
		// point offeset in file
		$pointOffset=($x+$y*1201)*2;
				
		$alt=ord($openDEMfiles[$demFile][$pointOffset])*256+ord($openDEMfiles[$demFile][$pointOffset+1]);

		if ($alt>10000) $alt=0;		
	
		DEBUG("DEM",255,"$latD $lonD $x $y  $pointOffset alt=$alt");		
		return $alt;	
	}

}

/*
$lat=40.4879667;
$lon=23.1730500;
// height =476 !!
*/

?>
<? 
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



$lat=40.4879667;
$lon=23.1730500;
// height =476 !!

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
$demFile=sprintf("%s%02d%s%03d.zip",$latStr,$latSouth,$lonStr,$lonWest);
echo $demFile;
exit;

  require_once('../../lib/pclzip/pclzip.lib.php');
  $archive = new PclZip($demFile);
  $list=$archive->extract(PCLZIP_OPT_EXTRACT_AS_STRING);
  if ( $list == 0) {
    die("Error : ".$archive->errorInfo(true));
  } else  {
  //	 echo $list[0]['content'];
  
  }
  
  
// $fl=file_get_contents($demFile);

// find x,y inside the file
// 1 degree is 1201 points
$x=floor($lonD*1201);
$y=floor($latD*1201);

// point offeset in file
$pointOffset=($x+$y*1201)*2;




$alt=ord($list[0]['content'][$pointOffset])*256+ord($list[0]['content'][$pointOffset+1]);


echo "$latD $lonD $x $y  $pointOffset<BR>";
echo $alt;


?>
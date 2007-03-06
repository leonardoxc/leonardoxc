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


$latSouth=floor($lat);
$lonWest=floor($lon);

$latNorth=$latSouth+1;
$lonEast=$lonWest+1;

$latD=$lat-$latSouth;
$lonD=$lon-$lonWest;


// find the file to use!
$demFile="N40E023".".hgt";


// find x,y inside the file
// 1 degree is 1201 points
$x=round((1-$lonD)*1201);
$y=round($latD*1201);

// point offeset in file
$pointOffset=$x+$y*1201;


$fl=file_get_contents($demFile);

$alt=$fl[$pointOffset]*256+$fl[$pointOffset];


echo "$latD $lonD $x $y <BR>";
echo $alt;


?>
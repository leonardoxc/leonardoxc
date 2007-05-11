<?
/*
manolis:man123|2    6d 61 6e 6f 6c 69 73 3a 6d 61 6e 31 32 33 7c 32
02|05|1.....#!P0    30 32 7c 30 35 7c 31 00 1f 00 00 00 23 21 50 30
3000000S<<000000    33 30 30 30 30 30 30 53 3c 3c 30 30 30 30 30 30
W<<0<<0<<0......    57 3c 3c 30 3c 3c 30 3c 3c 30 00 00 1f 00 00 00
#!P03000000S<<00    23 21 50 30 33 30 30 30 30 30 30 53 3c 3c 30 30
0000W<<0<<0<<0..    30 30 30 30 57 3c 3c 30 3c 3c 30 3c 3c 30 00 00
....#!P03000000S    1f 00 00 00 23 21 50 30 33 30 30 30 30 30 30 53
<<000000W<<0<<0<    3c 3c 30 30 30 30 30 30 57 3c 3c 30 3c 3c 30 3c
<0......#!P03000    3c 30 00 00 1f 00 00 00 23 21 50 30 33 30 30 30
000S<<000000W<<0    30 30 30 53 3c 3c 30 30 30 30 30 30 57 3c 3c 30
<<0<<0......#!P0    3c 3c 30 3c 3c 30 00 00 1f 00 00 00 23 21 50 30
3000000S<<000000    33 30 30 30 30 30 30 53 3c 3c 30 30 30 30 30 30
W<<0<<0<<0......    57 3c 3c 30 3c 3c 30 3c 3c 30 00 00 1f 00 00 00
#!P03000000S<<00    23 21 50 30 33 30 30 30 30 30 30 53 3c 3c 30 30
0000W<<0<<0<<0..    30 30 30 30 57 3c 3c 30 3c 3c 30 3c 3c 30 00 00
....#!P03000000S    1f 00 00 00 23 21 50 30 33 30 30 30 30 30 30 53
<<000000W<<0<<0<    3c 3c 30 30 30 30 30 30 57 3c 3c 30 3c 3c 30 3c
<0......#!P03000    3c 30 00 00 1f 00 00 00 23 21 50 30 33 30 30 30
000S<<000000W<<0    30 30 30 53 3c 3c 30 30 30 30 30 30 57 3c 3c 30 
<<0<<0..            3c 3c 30 3c 3c 30 00 00


....#!P03000000S<<000000W<<0<<0<<0..   1f 00 00 00 23 21 50 30 33 30 30 30 30 30 30 53 3c 3c 30 30 30 30 30 30 57 3c 3c 30 3c 3c 30 3c 3c 30 00 00

03403622N<<225718E
format

1-4 char 0
5-7	#!P
8-	03403622N


last 2 char -> 0
*/

if ( count($argv) != 4 ) {
	echo "Usage $argv[0] igcfile username pass\n";
	exit;
}
list($scriptname,$filename,$username,$pass)=$argv;

//$filename="test.igc";
//$username="manolis";
//$pass="man123";

$gsm1="202";
$gsm2="05";
$gsm3="1";

$server="dev.thenet.gr";
$serverPort=999;


function makeHeader() {
	global 	$username,$pass,$gsm1,$gsm2,$gsm3;
	$str=sprintf("%s:%s|%s|%s|%s%c",$username,$pass,$gsm1,$gsm2,$gsm3,0);
	return $str;
}

require_once "../../CL_gpsPoint.php";


function getLatMinDec($lat) {
	 $coord_tmp =$lat; 		
	 if ($coord_tmp >=0) $i=floor($coord_tmp); 		
	 else $i=ceil($coord_tmp); 		

	 $f=abs(($coord_tmp-$i)*60);
	return sprintf("%d%02d%02d%s", abs($i), floor($f), floor( ($f-floor($f)) *100 ), ($i>=0)?"N":"S");

}

function getLonMinDec($lon) {
	 $coord_tmp=$lon;
	 if ($coord_tmp >=0) $i=floor($coord_tmp); 		
	 else $i=ceil($coord_tmp); 		

	 $f=abs(($coord_tmp-$i)*60); 
	return sprintf("%d%02d%02d%s", abs($i), floor($f), floor( ($f-floor($f)) *100 ), ($i>=0)?"E":"W");
	
}
	
function makeLine($lat,$lon,$alt,$sog,$cog) {

	$latStr=getLatMinDec($lat);
	$lonStr=getLonMinDec($lon);
	return sprintf("%c%c%c%c#!P03%s<<%s<<%d<<%d<<%d%c%c",0x1f,0,0,0,$latStr,$lonStr,$alt,$sog,$cog,0,0);
}

function sendIGC($filename){
	$lines = @file ($filename); 
	if (!$lines) return;
	$timezone=0;
	
	$i=0;
	$day_offset =0; 
	foreach($lines as $line) {
		$deltaseconds=0;
		$line=trim($line);
		if  (strlen($line)==0) continue;				
		if ($line{0}=='B') {
			if  ( strlen($line) < 23 ) 	continue;
			$thisPoint=new gpsPoint($line,$timezone);
			$thisPoint->gpsTime+=$day_offset;

			if ($i>0) {						
				$distance = $lastPoint->calcDistance($thisPoint);			
				if ( ($lastPoint->getTime() - $thisPoint->getTime()  ) > 3600 )  { // more than 1 hour
					$day_offset = 86400; // if time seems to have gone backwards, add a day
					$thisPoint->gpsTime += 86400;
				} else if ( ($lastPoint->getTime() - $thisPoint->getTime()  ) > 0 ) {
					$lastPoint=new gpsPoint($line,$timezone);
					$lastPoint->gpsTime+=$day_offset;
					 continue;
				}	
				$deltaseconds = $thisPoint->getTime() - $lastPoint->getTime() ;	
				if ($deltaseconds) $speed = ($deltaseconds)?$distance*3.6/($deltaseconds):0.0; /* in km/h */
				else $speed =0;
				
				$alt=$thisPoint->getAlt();
				// compute cog;
				$cog=0;
				
			}	else  {
				$speed=0;
				$alt=0;
				$cog=0;
			}
			$lastPoint=new gpsPoint($line,$timezone);
			$lastPoint->gpsTime+=$day_offset;
			$i++;
			// send point 
			sleep($deltaseconds);
			sendString( makeLine($thisPoint->lat,-$thisPoint->lon,round($alt),round($speed),round($cog) ) );
		} 
	}
	
}

openSocket();
sendString(makeHeader());
sendIGC($filename);
closeSocket();


function sendString($str) {
	global $fp;
	echo $str;
	fputs ($fp, $str); 
}

function openSocket() {
	global $fp,	$server,$serverPort;
	$fp = fsockopen ($server, $serverPort , $errno, $errstr, 10); 
	if (!$fp)  {
	   echo "ERROR opening socket: $errstr ($errno)<br>\n"; 
	   exit;
	}
}

function closeSocket() {
	global $fp;
    fclose ($fp); 
}






?>
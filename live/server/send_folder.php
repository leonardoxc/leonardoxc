<?

if ( count($argv) != 3 ) {
	echo "Usage $argv[0] foldername pass\n";
	exit;
}
list($scriptname,$dirname,$pass)=$argv;

//$filename="test.igc";
//$username="manolis";
//$pass="man123";

$gsm1="202";
$gsm2="05";
$gsm3="1";

$server="dev.thenet.gr";
$serverPort=999;

require_once "../../CL_gpsPoint.php";

$dir = dirname(__FILE__).'/'.$dirname;
$dh  = opendir($dir);
while (false !== ($filename = readdir($dh))) {
   if ($filename!='..' && $filename!='.'  && $filename!='users.txt' ) $files[] = $filename;
}

//sort($files);
//print_r($files);

if (!is_file($dir.'/users.txt')) {
	echo "No users.txt file found \n";
	exit;
}


// read the pilot names
$lines=file($dir.'/users.txt');
foreach($lines as $line) {
	list($pilotName,$igcfile)=split(";",$line);
	$pilotName=trim($pilotName);
	$igcfile=trim($igcfile);
	$pilots[$igcfile]=$pilotName;
}

// print_r($pilots);


// now read the igc and store first b record time
foreach ($files as $file) {
	$fname=$dir.'/'.$file;
	$lines=file($fname);
	foreach($lines as $line){
		if ($line{0}=='B') {// found first b record
			// 0123456 
			// B184340 
			$time=substr($line,1,2)*3600+substr($line,3,2)*60+substr($line,5,2);
			$startTimes[$file]=$time;
			break;
		}
	}
}


//print_r($startTimes);
asort($startTimes);
//print_r($startTimes);

// now make the script file 

$prevTime=0;
$i=0;
foreach ($startTimes as $filename=>$startTime){
	if ($prevTime) {
		$sleeptime=$startTime-$prevTime;
		$res.="sleep $sleeptime\n";
	}
	$res.="php ./send_igc.php '$dirname$filename'  '".$pilots[$filename]."' $pass &\n";
	$prevTime=$startTime;
}


echo "php ./delete_points.php $pass\n";
echo $res;
?>

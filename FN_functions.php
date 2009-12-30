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
// $Id: FN_functions.php,v 1.68 2009/12/30 14:45:34 manolis Exp $                                                                 
//
//************************************************************************

require_once dirname(__FILE__)."/CL_auth.php"; 


function htmlDecode($encoded) {
	return strtr($encoded,array_flip(get_html_translation_table(HTML_ENTITIES)));
}


if( !function_exists('str_ireplace') ){
 function str_ireplace($search,$replace,$subject){
   $token = chr(1);
   $haystack = strtolower($subject);
   $needle = strtolower($search);
   while (($pos=strpos($haystack,$needle))!==FALSE){
     $subject = substr_replace($subject,$token,$pos,strlen($search));
     $haystack = substr_replace($haystack,$token,$pos,strlen($search));
   }
   $subject = str_replace($token,$replace,$subject);
   return $subject;
 }
} 

function safeFilename($str){
	$str=str_replace('"','_',$str);
	$str=str_replace("'",'_',$str);
	$str=str_replace("`",'_',$str);
	$str=str_replace('/','_',$str);
	$str=str_replace('\\','_',$str);
	return $str;
}

function toLatin1($str,$enc=""){
	if ( ! preg_match("/[^\w\.\-\@\!\#\$\%\^\&\*\?\[\]\{\}\.\+\/]/",$str) ) {
		return $str;
	}
	//echo "non latin char in name<BR>";

	$orgNum=substr_count($str,"?");

	// check utf
	require_once dirname(__FILE__)."/lib/utf8_to_ascii/utf8_to_ascii.php";
	$newString=utf8_to_ascii($str);

	$newNum=substr_count($newString,"?");
	if ($newNum<=$orgNum) { // no extra ? were added, this was a valid utf string
		return $newString;
	}

	global $langEncodings,$nativeLanguage;
	if ($enc=="" ) $enc=$langEncodings[$nativeLanguage];

	require_once dirname(__FILE__)."/lib/ConvertCharset/ConvertCharset.class.php";
	$NewEncoding = new ConvertCharset;
	$str_utf8 = $NewEncoding->Convert($str, $enc, "utf-8", $Entities);	

	return utf8_to_ascii($str_utf8);

}

function fetchURL( $url, $timeout=5) {
	$url_parsed = parse_url(str_replace(' ','%20',$url) );
   $host = $url_parsed["host"];
   $port = $url_parsed["port"];
   if ($port==0)
       $port = 80;
   $path =$url_parsed["path"];
   if ($url_parsed["query"] != "")
       $path .= "?".$url_parsed["query"];

	/* this breaks things if the string is already rawurlencode
		$dirName=dirname($path);
		$fileName=basename($path);
		//echo "% $dirName%$fileName %";
		$path="$dirName/".rawurlencode($fileName);
		echo "@$path@";
	*/
	
   $out = "GET $path HTTP/1.0\r\nHost: $host\r\n";
   $out.= "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1) Gecko/20061010 Firefox/2.0\r\n\r\n";

   $fp = @fsockopen($host, $port, $errno, $errstr, $timeout);
   if (!$fp) { return 0; }

   stream_set_timeout($fp,$timeout);

   if (fwrite($fp, $out)) {
	   $body = false;
	   while (!feof($fp)) {
		   if ( ! $s = fgets($fp, 1024) ) { 
				//echo "#"; 
				break; 
			}
		   if ( $body )
			   $in .= $s;
		   if ( $s == "\r\n" )
			   $body = true;
	   }
   }  else {
	//echo "$";
   }

   fclose($fp);
  
   return $in;
}

/**
 * Get a web file (HTML, XHTML, XML, image, etc.) from a URL.  Return an
 * array containing the HTTP server response header fields and content.
 */
function getWebpage( $url )
{
    $options = array(
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,    // don't return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_USERAGENT      => "spider", // who am i
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        CURLOPT_TIMEOUT        => 120,      // timeout on response
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
    );

    $ch      = curl_init( $url );
    curl_setopt_array( $ch, $options );
    $content = curl_exec( $ch );
    $err     = curl_errno( $ch );
    $errmsg  = curl_error( $ch );
    $header  = curl_getinfo( $ch );
    curl_close( $ch );

    $header['errno']   = $err;
    $header['errmsg']  = $errmsg;
    $header['content'] = $content;
    return $header;
}

function splitLines($line) {
 $max_line_len=35;
 $words=split(" ",$line);
 $sline="";
 $i=0;
 foreach($words as $word) {
    if ($i==0) $sep=""; else $sep=" ";
	$i++;
 	$tmp_sline = $sline.$sep.$word;
	if ($nl_pos=strrchr($tmp_sline, 10)) $tmp_sline = substr($tmp_sline ,$nl_pos ); 

	if (strlen($tmp_sline) > $max_line_len ) {
	   $sline=$sline."\n".$word;	
	   $i=0;  
	} else {
	   $sline=$sline.$sep.$word;
	}

 }
 
 return $sline;
}

if( !function_exists('delDir') ){
	function delDir($dir){
	 if ( !is_dir($dir) ) return;
	 $current_dir = opendir($dir);
	 while($entryname = readdir($current_dir)){
		if(is_dir("$dir/$entryname") and ($entryname != "." and $entryname!="..")){
		   deldir("${dir}/${entryname}");
		}elseif($entryname != "." and $entryname!=".."){
		   unlink("${dir}/${entryname}");
		}
	 }
	 closedir($current_dir);
	 @rmdir(${dir});
	}
}

function makeDir($path, $rights = 0777) {
  	$folder_path = array( strstr($path, '.') ? dirname($path) : $path);

	if (version_compare(PHP_VERSION, '5.0.0', '>=')) {
		return @mkdir($path,$rights,true);
	}
	
	// else for php 4
	while(!@is_dir(dirname(end($folder_path)))
          && dirname(end($folder_path)) != '/'
          && dirname(end($folder_path)) != '.'
          && dirname(end($folder_path)) != '') {
    	array_push($folder_path, dirname(end($folder_path)));
	}
	while($parent_folder_path = array_pop($folder_path)) {
    	if(!@mkdir($parent_folder_path, $rights)) return 0;
		//user_error("Can't create folder \"$parent_folder_path\".");
	}

	return 1;
}

function  checkPath($path){
  if (!is_dir($path))  makeDir($path,0755);
  if (!is_dir($path."/flights"))	makeDir($path."/flights",0755);
  if (!is_dir($path."/maps") )		makeDir($path."/maps",0755);
  if (!is_dir($path."/charts")) 	makeDir($path."/charts",0755);
  if (!is_dir($path."/photos")) 	makeDir($path."/photos",0755);
 
}


function getBrowser() {
	//
	// Determine the Browser the User is using, because of some nasty incompatibilities.
	// Most of the methods used in this function are from phpMyAdmin. :)
	//
	if (!empty($_SERVER['HTTP_USER_AGENT'])) 
	{
		$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
	} 
	else if (!empty($HTTP_SERVER_VARS['HTTP_USER_AGENT'])) 
	{
		$HTTP_USER_AGENT = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];
	}
	else if (!isset($HTTP_USER_AGENT))
	{
		$HTTP_USER_AGENT = '';
	}

	if (ereg('Opera(/| )([0-9].[0-9]{1,2})', $HTTP_USER_AGENT, $log_version)) 
	{
		$browser_version = $log_version[2];
		$browser_agent = 'opera';
	} 
	else if (ereg('MSIE ([0-9].[0-9]{1,2})', $HTTP_USER_AGENT, $log_version)) 
	{
		$browser_version = $log_version[1];
		$browser_agent = 'ie';
	} 
	else if (ereg('OmniWeb/([0-9].[0-9]{1,2})', $HTTP_USER_AGENT, $log_version)) 
	{
		$browser_version = $log_version[1];
		$browser_agent = 'omniweb';
	} 
	else if (ereg('Netscape([0-9]{1})', $HTTP_USER_AGENT, $log_version)) 
	{
		$browser_version = $log_version[1];
		$browser_agent = 'netscape';
	} 
	else if (ereg('Mozilla/([0-9].[0-9]{1,2})', $HTTP_USER_AGENT, $log_version)) 
	{
		$browser_version = $log_version[1];
		$browser_agent = 'mozilla';
	} 
	else if (ereg('Konqueror/([0-9].[0-9]{1,2})', $HTTP_USER_AGENT, $log_version)) 
	{
		$browser_version = $log_version[1];
		$browser_agent = 'konqueror';
	} 
	else 
	{
		$browser_version = 0;
		$browser_agent = 'other';
	}
	return array($browser_agent,$browser_version);
}

	function prep_for_DB($str) {
		return		str_replace("'","&#039;",$str);
	}
	function prep_from_DB($str) {
		return		str_replace("&#039;","'",$str);
	}


	function fill_year_month_array($first_month ,$last_month){
		$year_month_array=array();

		$start_year=substr($first_month,0,4);
		$start_month=substr($first_month,5,2);
		$end_year=substr($last_month,0,4);
		$end_month=substr($last_month,5,2);


		for($y=$start_year;$y<=$end_year;$y++) {
			for($m=1;$m<=12;$m++) {
				array_push($year_month_array,sprintf("%04d-%02d",$y,$m));
			}
		}
		return 		$year_month_array;
	}

	function DEBUG($debugCat,$debugLevel,$msg ) {
		global $DBGcat,$DBGlvl,$DEBUG_OUTPUT;
		if ( ($DBGcat == $debugCat || $DBGcat=='' ) && $DBGlvl & $debugLevel  ) 
			$DEBUG_OUTPUT.=$msg;
	}
	
	function DEBUG_END() {
		global $DEBUG_OUTPUT;
		if ($DEBUG_OUTPUT) { 
			echo "<div id='debugTitleDiv'><STRONG><a href='javascript:toggleVisibility(\"debugDiv\");'>DEBUG OUTPUT</a></STRONG></div>";
			echo "<div id='debugDiv'>$DEBUG_OUTPUT</div>";
			$DEBUG_OUTPUT="";
		}
	}

	function setDEBUGfromGET(){
		global $DBGcat,$DBGlvl;
		if ( $_GET['DBGcat'] ) $DBGcat=makeSane($_GET['DBGcat'] );
		if ( $_GET['DBGlvl'] ) $DBGlvl=makeSane($_GET['DBGlvl'],1) ;		
	}

	function getAvailableThemes() {
		 $res=array();
		 $dir=dirname(__FILE__)."/templates";
		 $current_dir = opendir($dir);
		 while($entryname = readdir($current_dir)){
			if( is_dir($dir ."/".$entryname) && ($entryname != "." and $entryname!=".." and strtolower($entryname)!="cvs" )){
			   array_push($res,$entryname);
			}
		 }
		 closedir($current_dir);
		 return $res;
	}

	# Compares versions of software
	# versions must must use the format ' x.y.z... ' 
	# where (x, y, z) are numbers in [0-9]
	function check_version($currentversion, $requiredversion)
	{
		list($majorC, $minorC, $editC) = split('[/.-]', $currentversion);
		list($majorR, $minorR, $editR) = split('[/.-]', $requiredversion);
		
		if ($majorC > $majorR) return true;
		if ($majorC < $majorR) return false;
		// same major - check ninor
		if ($minorC > $minorR) return true;
		if ($minorC < $minorR) return false;
		// and same minor
		if ($editC  >= $editR)  return true;
		return false;
	}

	/*  gets as string the normal screen output of php file  */
	function get_include_contents($filename) {
		if (is_file($filename)) {
			ob_start();
			include $filename;
			$contents = ob_get_contents();
			ob_end_clean();
			return $contents;
		}
		return "";
	}
	
	function getExtrernalServerTakeoffs($serverID,$lat,$lon,$limitKm,$limitNum ) {
		global $xmlSites;
		$takeoffServers=array(
			1=>array(
				/* calling  method */
				"callUrl"=>"http://www.paraglidingearth.com/takeoff_around.php?",
				"latArg"=>"lat",
				"lonArg"=>"lng",
				"limitKmArg"=>"distance",
				"limitNumArg"=>"limit",
				/* parsing of results */
				"XML_name"=>"name",
				"XML_distance"=>"distance",
				"XML_area"=>"area",
				"XML_countryCode"=>"countryCode",
				"XML_url"=>"pe_link",
				"XML_lat"=>"lat",
				"XML_lon"=>"lng",
				),
			2=>array(
				/* calling  method */
				"callUrl"=>"http://www.paragliding365.com/paragliding_sites_xml.html?type=mini&",
				"latArg"=>"latitude",
				"lonArg"=>"longitude",
				"limitKmArg"=>"radius",
				"limitNumArg"=>"notused",
				/* parsing of results */
				"XML_name"=>"name",
				"XML_distance"=>"distance",
				"XML_area"=>"location",
				"XML_countryCode"=>"iso",
				"XML_url"=>"link",						
				"XML_lat"=>"lat",
				"XML_lon"=>"lng",
			)
			

		);	
				
		
		$getXMLurl=$takeoffServers[$serverID]["callUrl"].
					$takeoffServers[$serverID]["latArg"]."=$lat&".
					$takeoffServers[$serverID]["lonArg"]."=$lon&".
					$takeoffServers[$serverID]["limitKmArg"]."=$limitKm&".
					$takeoffServers[$serverID]["limitNumArg"]."=$limitNum";
		
		//echo 	$getXMLurl;
		
		$xmlSites=fetchURL($getXMLurl);		
		if ($xmlSites) {
			require_once dirname(__FILE__).'/lib/miniXML/minixml.inc.php';
			$xmlDoc = new MiniXMLDoc();
			$xmlDoc->fromString($xmlSites);
			$xmlArray = $xmlDoc->toArray();

			$takeoffsNum=0;
			$takoffsList=array();
			// print_r($xmlArray);
			
			if ($serverID==1) { // paraglidingearth.com
				if (is_array($xmlArray['search'])) {
					if (is_array($xmlArray['search']['takeoff'][0])) 
						$arrayToUse=$xmlArray['search']['takeoff'];
					else
						$arrayToUse=$xmlArray['search'];
				} else {
					$arrayToUse=0;
				}
			} else if ($serverID==2) { //paragliding365.com
				if ($xmlArray['root']['flightareas']['flightarea']) {
					if ( is_array($xmlArray['root']['flightareas']['flightarea'][0] ) )
						$arrayToUse=$xmlArray['root']['flightareas']['flightarea'];
					else
						$arrayToUse=$xmlArray['root']['flightareas'];
				} else $arrayToUse=0;
			} else {
				$arrayToUse=0;
			}
	
			$takeoffsList=array();
			$takeoffsNum=0;
			if ($arrayToUse) {
				//echo "#";
				//print_r($arrayToUse);
				foreach ($arrayToUse as $flightareaNum=>$flightarea) {
					$XML_name=$takeoffServers[$serverID]["XML_name"];
					$XML_distance=$takeoffServers[$serverID]["XML_distance"];
					$XML_area=$takeoffServers[$serverID]["XML_area"];
					$XML_countryCode=$takeoffServers[$serverID]["XML_countryCode"];
					$XML_url=$takeoffServers[$serverID]["XML_url"];
					$XML_lat=$takeoffServers[$serverID]["XML_lat"];
					$XML_lon=$takeoffServers[$serverID]["XML_lon"];
					if ( $flightareaNum!=="_num" && $flightarea[$XML_name]) {							
							$distance=$flightarea[$XML_distance]; 
							if ($distance>$limitKm*1000) continue;
							$takeoffsList[$takeoffsNum]['distance']=$flightarea[$XML_distance]; 
							$takeoffsList[$takeoffsNum]['name']=$flightarea[$XML_name]; 
							$takeoffsList[$takeoffsNum]['area']=$flightarea[$XML_area]; 
							$takeoffsList[$takeoffsNum]['countryCode']=$flightarea[$XML_countryCode]; 
							$takeoffsList[$takeoffsNum]['url']=$flightarea[$XML_url]; 
							$takeoffsList[$takeoffsNum]['lat']=$flightarea[$XML_lat]; 
							$takeoffsList[$takeoffsNum]['lon']=$flightarea[$XML_lon]; 
							$takeoffsNum++;
							if ($takeoffsNum==$limitNum) break;
					}
				}
		  }

		  return $takeoffsList;
		} // if we have content
		return array();
	
	}
	
	// google maps polyline encoding
	function encodeNumber($num) {
		//    printf("%f = ", $num);
		$sgn_num = (int)($num * 100000);
		$sgn_num = ($sgn_num<<1);
		if ($num<0) {
			$sgn_num = ~$sgn_num;
		}
	
		while ($sgn_num >= 0x20) {
			$t = ( 0x20 | ($sgn_num & 0x1f)) + 63;
			$res.=sprintf("%c", $t);
			$sgn_num >>= 5;
		}
		$t = $sgn_num + 63;
		return $res.sprintf("%c", $t);
	}

function  writeFile($filename,$str){
	if (! $fp=fopen($filename,"w") ) return 0;
    if (!fwrite($fp,$str)) return 0;
	fclose($fp);
	return 1;
}

function splitServerPilotStr($str) {
	$serverID=0;
	if (  count($pilotPartsArray=split('_',$str)) >1 ) {
		$serverID=$pilotPartsArray[0];
		$pilotID=$pilotPartsArray[1];
	} else $pilotID=$str+0;

	return array($serverID,$pilotID);
}


// Color handling functions
function RGB($r, $g, $b) { return array($r, $g, $b);}

function AllocateColorMap($image, $array, &$colorMap) {
    for ($index = 0; $index < count($array); $index++) {
        $colorMap[$index] = imagecolorallocate($image,
                                               $array[$index]['R'],
                                               $array[$index]['G'],
                                               $array[$index]['B']);
    }
}

function InterpolateRGB(&$array, $startRGB, $endRGB, $startIdx, $endIdx)
{
    InterpolateArray($rArray, $startRGB[0], $endRGB[0], $startIdx, $endIdx);
    InterpolateArray($gArray, $startRGB[1], $endRGB[1], $startIdx, $endIdx);
    InterpolateArray($bArray, $startRGB[2], $endRGB[2], $startIdx, $endIdx);

    for ($index = $startIdx; $index < $endIdx; $index++) {
        $array[$index]['R'] = $rArray[$index];
        $array[$index]['G'] = $gArray[$index];
        $array[$index]['B'] = $bArray[$index];
    }
}

function InterpolateArray(&$array, $startVal, $endVal, $startIdx, $endIdx)
{
    if ($endIdx <= $startIdx) return;

    $step = ($endVal - $startVal) / ($endIdx - $startIdx);

    for ($index = $startIdx; $index < $endIdx; $index++) {
        $array[$index] = (int)round($startVal);
        $startVal += $step;
    }

    $array[$endIdx] = $endVal;
}



$dec2fracArray=array(
	'0.04'=>array(1,25),
	'0.05'=>array(1,20),
	'0.0666'=>array(1,15),
	'0.083'=>array(1,12),
	'0.111111111'=>array(1,9),
	'0.125'=>array(1,8),
	'0.142857143'=>array(1,7),
	'0.166666667'=>array(1,6),
	'0.2'=>array(1,5),
	'0.222222222'=>array(2,9),
	'0.25'=>array(1,4),
	'0.285714286'=>array(2,7),
	'0.333333333'=>array(1,3),
	'0.375'=>array(3,8),
	'0.4'=>array(2,5),
	'0.428571429'=>array(3,7),
	'0.444444444'=>array(4,9),
	'0.5'=>array(1,2),
	'0.555555556'=>array(5,9),
	'0.571428571'=>array(4,7),
	'0.6'=>array(3,5),
	'0.625'=>array(5,8),
	'0.666666667'=>array(2,3),
	'0.714285714'=>array(5,7),
	'0.75'=>array(3,4),
	'0.777777778'=>array(7,9),
	'0.8'=>array(4,5),
	'0.833333333'=>array(5,6),
	'0.857142857'=>array(6,7),
	'0.875'=>array(7,8),
	'0.888888889'=>array(8,9),
	'0.916666667'=>array(11,12),
);


$reduceArray=array();
$reduceArray[2][5]=array(1,0,0,1,0);
$reduceArray[3][5]=array(1,0,1,0,1);
$reduceArray[2][7]=array(1,0,0,0,1,0,0);
$reduceArray[3][7]=array(1,0,0,1,0,1,0);
$reduceArray[4][7]=array(1,0,1,0,1,0,1);
$reduceArray[5][7]=array(1,0,1,1,1,0,1);
$reduceArray[3][8]=array(1,0,0,1,0,0,1,0);
$reduceArray[5][8]=array(1,0,1,1,1,0,1,0);
$reduceArray[2][9]=array(1,0,0,0,1,0,0,0,0);
$reduceArray[4][9]=array(1,0,1,0,1,0,1,0,0);
$reduceArray[5][9]=array(1,0,1,0,1,1,0,1,0);
$reduceArray[7][9]=array(1,0,1,1,1,0,1,1,1);

function dec2frac($dec){
	global $dec2fracArray;
	$minD=1;
	$selD=0;
	foreach($dec2fracArray as $d=>$dArr){		
		//echo $d.'#';
		if ( abs($d-$dec) < $minD) {
			$minD=abs($d-$dec);
			$selD=$d;
		}
	}
	return array($dec2fracArray[$selD][0],$dec2fracArray[$selD][1]);
}

function getReduceArray($pointsNum,$maxPointsNum) {
	global $reduceArray;

	if ($pointsNum<=$maxPointsNum) return array(1);
	$ratio=$maxPointsNum/$pointsNum;
	list($n,$d)=dec2frac($ratio);

	//echo "$pointsNum / $maxPointsNum have ratio=$ratio, we selected ".($n/$d)." with $n/$d<BR>";
	//echo "it will result in ".$pointsNum*($n/$d)." points<BR>";

	$arr=array();
	if ($n==1) { //simple case mod $d
		$arr[0]=1;
		for ($i=1;$i<$d;$i++) {
			$arr[$i]=0;
		}
	} else if ( ($d-$n)==1) { // also simple fill in all slots with 1 except last
		for ($i=0;$i<$d-1;$i++) {
			$arr[$i]=1;
		}
		$arr[$d-1]=0;
	} else {
		if ( is_array($reduceArray[$n][$d]) ) {
			return $reduceArray[$n][$d];
		} else {
			echo "getReduceArray() internal error<BR>";
		}
	}

	return $arr;
}

function pilotServerCmp($a, $b) { 
	global $CONF;
	
	$aPos=$CONF['servers']['pilotServerOrder'][$a];
	if (!$aPos)  $aPos=999;
	$bPos=$CONF['servers']['pilotServerOrder'][$b];
	if (!$bPos)  $bPos=999;

	if ($aPos == $bPos) { 
	   if ($a == $b) return 0;
	   return ($a > $b) ? 1 : -1; 
   } 
   return ($aPos > $bPos) ? 1 : -1; 
} 

function sameFlightsCmp($a, $b) { 
	// we must disable all flights BUT one
	// rules: 
	// 1. locally submitted flights have priority
	// 2. between external flights , the full synced have priority over simple links
	// 3. between equal cases the first submitted has priority.

	// locally vs non-local
	if ($a['serverID'] ==0 && $b['serverID']!=0 ) return -1;	 // local flight  ($a) is better
	if ($b['serverID'] ==0 && $a['serverID']!=0 ) return 1; // local flight  ($b) is better

	// both locals	
	if ($a['serverID'] ==0 && $b['serverID']==0 ) {
		if ( $a['ID'] < $b['ID'] ) return -1; // smallest ID ($a) is better
		else return 1;
	}
	
	// both externals
	
	if ( $a['externalFlightType'] ==2 && $b['externalFlightType']!=2 ) return -1;	 // ext type 2 ($a) is better
	if ( $b['externalFlightType'] ==2 && $a['externalFlightType']!=2 ) return 1;	 // ext type 2 ($b) is better
	
	
	//final compare the ids again 
	if ( $a['ID'] < $b['ID'] ) return -1; // smallest ID ($a) is better
	else return 1;
	
}

function sendMail($to,$subject,$msg) {
	$headers ="MIME-Version: 1.0\r\n";
	$headers.="Content-type: text/html; charset=iso-8859-1\r\n";
	$headers.="From: $CONF_admin_email \r\n";
			
	mail($to,$_SERVER['SERVER_NAME'].": $subject",$msg,$headers);
}


function sendMailToAdmin($subject,$msg) {
	global  $CONF_admin_email;
	sendMail($CONF_admin_email,$subject,$msg) ;
	
}

function makeHash($scriptName)  {
	return md5($CONF_SitePassword.$scriptName);
}


function get_absolute_path($path) {
	$path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
	$parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
	$absolutes = array();
	foreach ($parts as $part) {
		if ('.' == $part) continue;
		if ('..' == $part) {
			array_pop($absolutes);
		} else {
			$absolutes[] = $part;
		}
	}
	if ($path{0}=='/') 
		return '/'.implode(DIRECTORY_SEPARATOR, $absolutes);
	else
		return implode(DIRECTORY_SEPARATOR, $absolutes);
}
	
// the method to use for links in the menu and other parts of leonardo
// 1 -> current old way, using &name=value args + session variables
// 2 -> same as 1 but all sessions vars are in the url, this means that the url 
// 3 -> SEO urls

function getLeonardoLink($argArray) {
	global $CONF,$lng, $lang2iso,$op;
	
	$linkType=	$CONF['links']['type'];
	
	if (in_array($argArray['op'],array('login','admin','conf_htaccess') ) ) {
		$linkType=1;
	}
	
	if ($linkType==1) {
		global $baseInstallationPath,$CONF_mainfile;
		
		foreach($argArray as $argName=>$argValue){
			if ($argValue!='useCurrent')
				$args.='&'.$argName.'='.($argValue!='skipValue'?$argValue:'');
		}	
		$lnk='';
		//echo "^^ $baseInstallationPath ^^ $CONF_mainfile ^^";
		if (!$baseInstallationPath ) $lnk='/';
		$lnk.=$baseInstallationPath.'/'.$CONF_mainfile.CONF_MODULE_ARG.$args;
		// echo $lnk;
		//return $lnk;
		return CONF_MODULE_ARG.$args;
	} else 	if ($linkType==2) {
		global $op,$rank,$subrank;
		global $year,$month,$day,$season,$pilotID,$takeoffID,$country,$cat,$clubID;
		global $nacid,$nacclubid;

		foreach($argArray as $argName=>$argValue){
			if ($argValue=='useCurrent') {
				global ${$argName};
				$args.='&'.$argName.'='.${$argName};
			} else {
				$args.='&'.$argName.'='.($argValue!='skipValue'?$argValue:'');
			}	
		}	
		
		$thisURL=CONF_MODULE_ARG.$args;
		if ($op=="comp") 
			$thisURL.="&rank=$rank&subrank=$subrank&year=$year&season=$season";
		else
			$thisURL.="&year=$year&month=$month&day=$day&season=$season&pilotID=$pilotID&takeoffID=$takeoffID&country=$country&cat=$cat&clubID=$clubID";
		# Martin Jursa 25.05.2007: support for nacclub-filtering
		if (!empty($CONF_use_NAC)) {
			if ($nacclubid && $nacid) {
				$thisURL.="&nacid=$nacid&nacclubid=$nacclubid";
			}
		}
		return $thisURL;
		
	} else 	if ($linkType==3) {
		global $op,$rank,$subrank;
		global $year,$month,$day,$season,$serverID,$pilotID,$pilotIDview;
		global $takeoffID,$country,$cat,$class,$xctype,$clubID;
		global $nacid,$nacclubid,$brandID;

		if ($argArray['op']=='useCurrent') {
			$argArray['op']=$op;
		}
			
		if ( isset($argArray['lng']) ){
			if (strpos($_SERVER['REQUEST_URI'],'&lng=') ) 
				return preg_replace('/&lng=(\w+)/','&lng='.$argArray['lng'],$_SERVER['REQUEST_URI']);
			else 
				return $_SERVER['REQUEST_URI'].'&lng='.$argArray['lng'];
			$lngCode= $lang2iso[$argArray['lng']];							
		} else {
			$lngCode= $lang2iso[$lng];
		}	
		
		// $args=$lngCode.'/';
		$args='';
		$opProccessed=1;
		
		//unset($argArray['lng']);
		//unset($argArray['newlang']);
		
		$opTmp=$argArray['op'];
		if ($opTmp=='list_flights') {
			$args.='tracks/';
		} else if ($opTmp=='list_pilots') {
			$args.='pilots/';
		} else if ($opTmp=='competition') {
			$args.='league/';
		} else if ($opTmp=='comp') {
			$args.='ranks/';
		} else if ($opTmp=='list_takeoffs') {
			$args.='takeoffs/';
			
		} else if ($opTmp=='pilot_profile') {			
			// if (!$argArray['pilotIDview']) $argArray['pilotIDview']=$pilotIDview;			
			$args.='pilot/'.$argArray['pilotIDview'];
			return $CONF['links']['baseURL'].'/'.$args;
						
		} else if ($opTmp=='pilot_profile_stats') {	
			$args.='pilot/'.$argArray['pilotIDview'].'/stats/';
			return $CONF['links']['baseURL'].'/'.$args;
			
		} else if ($opTmp=='show_waypoint') {
			$args.='takeoff/'.$argArray['waypointIDview'];
			return $CONF['links']['baseURL'].'/'.$args;
			
		} else if ($opTmp=='show_flight') {	
			$args.='flight/';	
			if ($argArray['flightID']!='skipValue') {
				$args.=$argArray['flightID'];
				unset($argArray['flightID']);
			}	
			// return $CONF['links']['baseURL'].'/'.$args;
		} else {
			$opProccessed=0;
		}
		
		
		$listings=array('list_flights','list_takeoffs','list_pilots','competition','comp');
		$args2process=array('year','month','day','season','country','rank','subrank','cat','class','xctype','brandID',
							'clubID','nacclubid','nacid','pilotID','takeoffID');
		$args2Array=array();
		
		$isListing=false;
		// add the date, country in the path
		if (in_array($opTmp ,$listings)) {
			$isListing=true;
			//see if we have some variables in the argArray		
			foreach($args2process as $argName) {
				if (isset($argArray[$argName])){
					$args2Array[$argName]=$argArray[$argName];				
				}else {				
					if ( $argName=='pilotID') {
						$args2Array[$argName]=($serverID+0).'_'.($pilotID);					
					}else {
						$args2Array[$argName]=${$argName};
					}	
				}
			}

			if ($opTmp=='comp') {
				if ($args2Array['rank']){
					$args.=$args2Array['rank'].'.'.$args2Array['subrank'].'/';
				} else {
					$args.='all/';
				}
				unset($argArray['clubID']);
				unset($argArray['nacid']);
				unset($argArray['nacclubid']);
			} else {
				if ($args2Array['country']){
					$args.=$args2Array['country'].'/';
				} else {
					$args.='world/';
				}			
			}
						
			if ($args2Array['season']) {
				$args.='season'.$args2Array['season'].'/';
			} else {
				if ($args2Array['year'] && $args2Array['month'] && $args2Array['day']) {
					//printf("date : %04d.%02d.%02d ***",
					//	$args2Array['year'],$args2Array['month'],$args2Array['day']);

						//$args.=sprintf("%04d.%02d.%02d",
						//$args2Array['year'],$args2Array['month'],$args2Array['day']).'/';
					$args.=$args2Array['year'].'.'.$args2Array['month'].'.'.$args2Array['day'].'/';
				} else if ($args2Array['year'] && $args2Array['month'])
					$args.=$args2Array['year'].'.'.$args2Array['month'].'/';
				else if ($args2Array['year']  )
					$args.=$args2Array['year'].'/';	
				else 
					$args.='alltimes/';
			}

			$args.='brand:'.($args2Array['brandID']?$args2Array['brandID']:'all').',';
			
			if ($opTmp=='comp') {
			
			} else {
				$args.='cat:'.$args2Array['cat'].',';
			}
			
			if ($opTmp!='list_takeoffs' && $opTmp!='comp') {
				$args.='class:'.($args2Array['class']?$args2Array['class']:'all').',';
				$args.='xctype:'.($args2Array['xctype']?$args2Array['xctype']:'all').',';
			}
						
			if ( $args2Array['nacid'] && $args2Array['nacclubid'] ) {
				$args.='club:'.$args2Array['nacid'].'.'.$args2Array['nacclubid'];
			} else {
				$args.='club:'.($args2Array['clubID']?'0.'.$args2Array['clubID']:'all');
			}
			
			if ($opTmp!='comp' &&  $opTmp!='competition') {
				
				if ($opTmp!='list_pilots')
					$args.=',pilot:'.($args2Array['pilotID']?$args2Array['pilotID']:'all');			
				if ( $opTmp!='list_takeoffs' )	
					$args.=',takeoff:'.($args2Array['takeoffID']?$args2Array['takeoffID']:'all');
			}
						
			unset($argArray['nacclubid']);
			unset($argArray['nacid']);
			unset($argArray['takeoffID']);
			unset($argArray['pilotID']);			
			unset($argArray['clubID']);
			unset($argArray['brandID']);
			unset($argArray['cat']);
			unset($argArray['class']);
			unset($argArray['xctype']);
			unset($argArray['season']);
			unset($argArray['year']);
			unset($argArray['month']);	
			unset($argArray['day']);
			unset($argArray['country']);
			unset($argArray['rank']);
			unset($argArray['subrank']);
		}

		if (!$opProccessed && isset($argArray['op'])  ) {
			$args.='page/'.$argArray['op'];
			unset($argArray['op']);
		}
		
		$i=0;
		foreach($argArray as $argName=>$argValue){
			if ($argName!='op' ) {
				// if (! $isListing || $i>0) $args.='&';
				$args.='&'.$argName.'='.($argValue!='skipValue'?($argValue):'');

			}	
		}
	
		return $CONF['links']['baseURL'].'/'.$args;
	}
}


// the method to use for download.php
// 1 -> current old way, using &name=value args + session variables
// 2 -> same as 1 but all sessions vars are in the url, this means that the url 
// 3 -> SEO urls

function getDownloadLink($argArray) {
	global $CONF,$lng, $lang2iso;
	
	if ($CONF['links']['type']==1 || $CONF['links']['type']== 2 ) {
	
		foreach($argArray as $argName=>$argValue){
			if ($argName!='type')
				$args.='&'.$argName.'='.($argValue!='skipValue'?$argValue:'');
		}	
		return getRelMainDir().'download.php?type='.$argArray['type'].$args;
		
	} else 	if ($CONF['links']['type']==3) {


		// $args=$lngCode.'/';
		$args='';
		$opProccessed=1;
		
		// "kml_task","kml_trk","kml_trk_color","kml_wpt","sites","igc"
		$opTmp=$argArray['type'];
		if ($opTmp=='igc') {
			$args.='flight/'.$argArray['flightID'].'/igc/';
			unset($argArray['flightID']);
		} else if ($opTmp=='kml_trk') {		
			$args.='flight/'.$argArray['flightID'].'/kml/';
			unset($argArray['flightID']);
		} else if ($opTmp=='kml_wpt') {		
			$args.='takeoff/'.$argArray['wptID'].'/kml/';
			unset($argArray['wptID']);
		} else {
		
			$opProccessed=0;
		}
			
		
		foreach($argArray as $argName=>$argValue){
			if ($argName!='type' || !$opProccessed )
				$args.='&'.$argName.'='.($argValue!='skipValue'?$argValue:'');
		}
	
		return $CONF['links']['baseURL'].'/'.$args;
	}
}
?>
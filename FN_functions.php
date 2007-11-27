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

require_once dirname(__FILE__)."/CL_auth.php"; 

function fetchURL( $url, $timeout=5) {
   $url_parsed = parse_url($url);
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

function makeDir($path, $rights = 0777) {
  	$folder_path = array( strstr($path, '.') ? dirname($path) : $path);

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
  if (!is_dir($path))  mkdir($path,0755);
  if (!is_dir($path."/flights"))	mkdir($path."/flights",0755);
  if (!is_dir($path."/maps") )		mkdir($path."/maps",0755);
  if (!is_dir($path."/charts")) 	mkdir($path."/charts",0755);
  if (!is_dir($path."/photos")) 	mkdir($path."/photos",0755);
 
}


function validJPGfilename($filename) {
	$filename=strtolower($filename);
	if ( strtolower(substr($filename,-4))==".jpg" || strtolower(substr($filename,-5))==".jpeg" ) return 1;
	return 0;
}

function validJPGfile($filename) {
	  $im = getimagesize($filename);
	  if ($im[0] && $im[1]) return 1;
	  else return 0;
}

function resizeJPG($forcedwidth, $forcedheight, $sourcefile, $destfile, $imgcomp)
{
	$g_imgcomp=100-$imgcomp;
	$g_srcfile=$sourcefile;
	$g_dstfile=$destfile;
	$g_fw=$forcedwidth;
	$g_fh=$forcedheight;
	if(file_exists($g_srcfile))
	{
	  $image_details = getimagesize($g_srcfile);
	  $source_width  = $image_details[0];
      $source_height = $image_details[1];

	  $dest_width_max   = $forcedwidth;
	  $dest_height_max  = $forcedheight;
	  // The two lines beginning with (int) are the super important magic formula part.
	  (int)$dest_width  = ($source_width <= $source_height) ? round(($source_width  * $dest_height_max)/$source_height) : $dest_width_max;
	  (int)$dest_height = ($source_width >  $source_height) ? round(($source_height * $dest_width_max) /$source_width)  : $dest_height_max;
  
   	   if ($dest_width > $source_width ) {
			$dest_width = $source_width;
			$dest_height = $source_height;
	   }

	   $img_src=imagecreatefromjpeg($g_srcfile);

	   if (function_exists("gd_info")) {
		   $gdinfo=gd_info();
		   if ( strpos($gdinfo["GD Version"],"2.") ===false ) $gd2=0;
		   else $gd2=1;
	   } else $gd2=false;

	   if ( $gd2 ) { 
		   $img_dst=imagecreatetruecolor($dest_width,$dest_height);
		   imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $dest_width, $dest_height,  $source_width, $source_height);
		} else {
		   $img_dst=imagecreate($dest_width,$dest_height);
		   imagecopyresized($img_dst, $img_src, 0, 0, 0, 0, $dest_width, $dest_height,  $source_width, $source_height);
		}

		imagejpeg($img_dst, $g_dstfile, $g_imgcomp);
		imagedestroy($img_dst);
		return true;
	}
	else
		return false;
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

?>
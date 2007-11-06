<?
require_once dirname(__FILE__)."/../config.php";
require_once dirname(__FILE__)."/../FN_functions.php";
require_once dirname(__FILE__)."/../lib/ConvertCharset/ConvertCharset.class.php";

// get the english file definitions
$baseLang='english';
$baseDefines=getDefinesAsArray("lang-$baseLang.php");


print_r($definesArray);
foreach($availableLanguages as $lang) {

	// if ($lang!='greek') continue;
	 if ( in_array($lang,array('chinese','hebrew') )  ) continue;
	
	$encFrom=$langEncodings[$lang];
	$encTo="utf-8";
	$Entities=0;
	
	$FileName = "lang-$lang.php";
	
	$langDefines=getDefinesAsArray("lang-$lang.php");
	$definesMissing=array();	
	foreach($baseDefines as $defineStr=>$translateStr) {
		if (! $langDefines[$defineStr]){
			$definesMissing[$defineStr]=$translateStr;
		}
	}

	
	$File = file($FileName);
	$File[0]=str_replace("charset=$encFrom","charset=utf-8",$File[0]);
	$FileText = implode("",$File);
	
	$NewEncoding = new ConvertCharset;
	$NewFileOutput = $NewEncoding->Convert($FileText, $encFrom, $encTo, $Entities);

	if ( count($definesMissing) ) {
		echo "There are ".count($definesMissing)." defines missing from $lang File<BR>";
		$NewFileOutput.="\r\n//--------------------------------------------------------\r\n";
		$NewFileOutput.="//--------------------------------------------------------\r\n";
		$NewFileOutput.="// Missing defines , autoreplaced values from '$baseLang' \r\n";		
		$NewFileOutput.="//--------------------------------------------------------\r\n";
		foreach($definesMissing as $defineStr=>$translateStr){
				$NewFileOutput.="define(\"$defineStr\",\"$translateStr\"); \r\n";
		}
	}
	
	$outFile='utf8/'.$FileName;
	writeFile($outFile,$NewFileOutput);
	
	
	$FileName = "countries-$lang.php";
	$File = file($FileName);
	str_replace("charset=$encFrom","charset=utf-8",$File[0]);
	$FileText = implode("",$File);
	
	$NewFileOutput = $NewEncoding->Convert($FileText, $encFrom, $encTo, $Entities);
	$outFile='utf8/'.$FileName;
	writeFile($outFile,$NewFileOutput);
	
	echo "Converted $lang<BR>";
	//break;
}


function getDefinesAsArray($file){
	if ( !$lines=@file($file) ) {
		echo "No defines found<br>";
		return array(array(),array());
	}
	$definesArray=array();
	$transArray=array();
	$i=0;
	foreach ($lines as $line) {
		if ( preg_match("/define\(\"(.+)\",\"(.+)\"\)\;/is",$line,$matches) ) {
			$definesArray[$matches[1]]=$matches[2];
			$i++;
		}
	}
	return array($definesArray);
}


?>
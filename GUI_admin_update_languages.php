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
//************************************************************************/

  	if (!auth::isAdmin($userID)) {
		echo "<br><br>You dont have access to this page<BR>";
		exitPage();
	}

	require_once dirname(__FILE__)."/lib/ConvertCharset/ConvertCharset.class.php";	
	$admin_op=makeSane($_GET['admin_op']);
		
	open_inner_table("ADMIN AREA :: Language translations",700);
	echo "<tr><td align=left>";	

	echo "<br>";
	echo "<ul>";
	
	
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin_languages&admin_op=update'>1. Proccess all language files and create/update files in 'utf8'/'iso' dirs</a><BR></a>";

	echo "</ul><HR><br>";
	define('LANG_ABS_PATH',dirname(__FILE__).'/language');
	
	if ($admin_op=='update') {

		// get the english file definitions
		$baseLang='english';
		$baseDefines=getDefinesAsArray("lang-$baseLang.php");		
		// print_r($baseDefines);
		
		foreach($availableLanguages as $lang) {
			 $convert_to_utf_manually=0;		
				
			 // if ( ! in_array($lang,array('greek','german','english')) ) continue;
			 if ( in_array($lang,array('chinese','hebrew') )  ) {
			 	$convert_to_utf_manually=1;
			 	continue;
			 }	
					
			$FileName = LANG_ABS_PATH."/lang-$lang.php";
			
			$langDefines=getDefinesAsArray("lang-$lang.php");
			$definesMissing=array();	
			foreach($baseDefines as $defineStr=>$translateStr) {
				//	echo " $defineStr => $translateStr<BR>";
				if (! $langDefines[$defineStr]){
					echo "@@ $defineStr => $translateStr<BR>";
					$definesMissing[$defineStr]=$translateStr;
				}
			}

					
			$File = file($FileName);
			$NewFileOutput = implode("",$File);			
			
		
			if ( count($definesMissing) ) {
				// remove the  last line containng ? > 
				$NewFileOutput=substr($NewFileOutput,0,-3);
				
				echo "There are ".count($definesMissing)." defines missing from $lang File<BR>";
				$NewFileOutput.="\r\n//--------------------------------------------------------\r\n";
				$NewFileOutput.="//--------------------------------------------------------\r\n";
				$NewFileOutput.="// Missing defines , autoreplaced values from '$baseLang' \r\n";		
				$NewFileOutput.="//--------------------------------------------------------\r\n";
				foreach($definesMissing as $defineStr=>$translateStr){
						$NewFileOutput.="define(\"$defineStr\",\"$translateStr\"); \r\n";
				}
				$NewFileOutput.="\r\n?>";
			}
			
			// write first the original iso encoding with any missing defines added
			writeFile(LANG_ABS_PATH."/iso/lang-$lang.php",$NewFileOutput);
			
			if (!	$convert_to_utf_manually) {
				// replace in first list the encoding
				$NewFileOutput=str_replace("charset=$encFrom","charset=utf-8",$NewFileOutput);
				// now convert to utf-8 and write also
				$NewEncoding = new ConvertCharset;
				$encFrom=$langEncodings[$lang];
				$encTo="utf-8";
				$Entities=0;
				$NewFileOutput = $NewEncoding->Convert($NewFileOutput, $encFrom, $encTo, $Entities);			
				writeFile(LANG_ABS_PATH."/utf8/lang-$lang.php",$NewFileOutput);
			}			
			
			// ----------------------------------
			// Now do the countries files
			// ----------------------------------
			
			$FileName = LANG_ABS_PATH."/countries-$lang.php";
			$File = file($FileName);
			$FileText = implode("",$File);
			
			writeFile(LANG_ABS_PATH."/iso/countries-$lang.php",$FileText);
			
			if (!	$convert_to_utf_mannually) {
				$FileText=str_replace("charset=$encFrom","charset=utf-8",$FileText);
				$FileText = $NewEncoding->Convert($FileText, $encFrom, $encTo, $Entities);
				writeFile(LANG_ABS_PATH."/utf8/countries-$lang.php",$FileText);
			}			
			
			echo "<strong>Converted $lang</strong><hr><BR>";
			//break;
		}
		
	} // end if admin_op

	echo "</td></tr>";
    close_inner_table();
	
	
function getDefinesAsArray($file){
	if ( !$lines=@file(dirname(__FILE__).'/language/'.$file) ) {
		echo "No defines found<br>";
		return array(array(),array());
	}
	$definesArray=array();
	$transArray=array();
	$i=0;
	foreach ($lines as $line) {
		if ( preg_match("/define\([\"\'](.+)[\"\'], *[\"\'](.+)[\"\']\)\;/is",$line,$matches) ) {
			$definesArray[$matches[1]]=$matches[2];
			$i++;
		}
	}
	return $definesArray;
}


?>
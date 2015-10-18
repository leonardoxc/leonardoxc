<?
//************************************************************************
// Leonardo XC Server, http://www.leonardoxc.net
//
// Copyright (c) 2004-2010 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: GUI_admin_update_languages.php,v 1.10 2010/03/14 20:56:11 manolis Exp $
//
//************************************************************************

  	if (!L_auth::isAdmin($userID)) {
		echo "<br><br>You dont have access to this page<BR>";
		exitPage();
	}

	require_once dirname(__FILE__)."/lib/ConvertCharset/ConvertCharset.class.php";
	$admin_op=makeSane($_GET['admin_op']);

	openMain("ADMIN AREA :: Language translations",0,'');

	echo "<br>";
	echo "<ul>";


	echo "<li><a href='".getLeonardoLink(array('op'=>'admin_languages','admin_op'=>'update') )."'>1. Proccess all language files and create/update files in 'utf8'/'iso' dirs</a><BR></a>";

	echo "</ul><HR><br>";
	define('LANG_ABS_PATH',dirname(__FILE__).'/language');

	if ($admin_op=='update') {

		// get the english file definitions
		$baseLang='english';
		$baseDefines=getDefinesAsArray("source/lang-$baseLang.php");		
		// print_r($baseDefines);
		//$availableLanguages=array('english', 'german');

		foreach($availableLanguages as $lang) {


			 $convert_to_utf_manually=0;

			// if ( ! in_array($lang,array('greek','german','english')) ) continue;
			// if ( ! in_array($lang,array('chinese')) ) continue;

			 /*if ( in_array($lang,array('hebrew') )  ) {
			 	$convert_to_utf_manually=1;
			 	continue;
			 }
			*/

			$FileName = LANG_ABS_PATH."/source/lang-$lang.php";

			$langDefines=getDefinesAsArray("source/lang-$lang.php");
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
						$translateStr=str_replace('"',"'",$translateStr);
						$NewFileOutput.="define(\"$defineStr\",\"$translateStr\"); \r\n";
				}
				$NewFileOutput.="\r\n?>";
			}

			// write first the original iso encoding with any missing defines added
			writeFile(LANG_ABS_PATH."/iso/lang-$lang.php",$NewFileOutput);

			if (!	$convert_to_utf_manually) {
				// replace in first list the encoding
				$encFrom=$langEncodings[$lang];
				if ($lang=='hebrew') $encFrom='iso-8859-8';
				$encTo="utf-8";
				$NewFileOutput=str_replace("charset=$encFrom","charset=utf-8",$NewFileOutput);


				// now convert to utf-8 and write also
				if ($lang=='chinese') {
					require_once dirname(__FILE__)."/lib/ConvertCharset/chinese/charset.class.php";
					$NewFileOutput= Charset::convert($NewFileOutput,'gb2312','utf-8');
				} else {
					$NewEncoding = new ConvertCharset;
					$Entities=0;
					$NewFileOutput = $NewEncoding->Convert($NewFileOutput, $encFrom, $encTo, $Entities);
				}
				writeFile(LANG_ABS_PATH."/utf8/lang-$lang.php",$NewFileOutput);
			}

			// ----------------------------------
			// Now do the countries files
			// ----------------------------------

			$FileName = LANG_ABS_PATH."/source/countries-$lang.php";
			$File = file($FileName);
			$FileText = implode("",$File);

			writeFile(LANG_ABS_PATH."/iso/countries-$lang.php",$FileText);

			if (!	$convert_to_utf_mannually) {
				$FileText=str_replace("charset=$encFrom","charset=utf-8",$FileText);

				if ($lang=='chinese') {
					require_once dirname(__FILE__)."/lib/ConvertCharset/chinese/charset.class.php";
					$FileText= Charset::convert($FileText,'gb2312','utf-8');
				} else {
					$FileText=str_replace("charset=$encFrom","charset=utf-8",$FileText);
					$FileText = $NewEncoding->Convert($FileText, $encFrom, $encTo, $Entities);
				}
				writeFile(LANG_ABS_PATH."/utf8/countries-$lang.php",$FileText);
			}

			echo "<strong>Converted $lang</strong><hr><BR>";
			//break;
		}

	} // end if admin_op


    closeMain();

/**
 * Get associative array of language constants, array key being the constant name
 * function modified by martin jursa 13.05.2009 to handle multiline defines too
 *
 * @param string $file
 * @return array
 */
function getDefinesAsArray($file){
	if ( !$lines=@file(dirname(__FILE__).'/language/'.$file) ) {
		echo "No defines found<br>";
		return array();
	}
	$definesArray=array();
	$i=0;
	$lCount=count($lines);
	while ($i<$lCount) {
		$line=$lines[$i];
		if ( preg_match("/define\([\"\'](.+)[\"\'], *[\"\'](.+)/is",$line,$matches) ) {
			$constName=$matches[1];
			$line=$matches[2];
			$text='';
			$matches=array();
			$match=preg_match("/(.+)[\"\']\)\;/is",$line,$matches);
			while (!$match && $i<$lCount-1) {
				$text.=$line;
				$i++;
				$line=$lines[$i];
				$match=preg_match("/(.+)[\"\']\)\;/is",$line,$matches);
			}
			if ($match) {
				$text.=$matches[1];
				$definesArray[$constName]=$text;
			}
		}
		$i++;
	}
	return $definesArray;
}


?>

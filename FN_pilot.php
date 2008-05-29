<?
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://leonardo.thenet.gr                                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


//------------------- PILOT RELATED FUNCTIONS ----------------------------
function getPilotList($clubID=0) {
	global $db;
	global $flightsTable;
	global	$clubsPilotsTable, $pilotsTable ;
	global $nativeLanguage,$currentlang,$opMode;
	
	if ($clubID) {
		$query="SELECT *, $clubsPilotsTable.pilotID as userID , $clubsPilotsTable.pilotServerID as userServerID 
			FROM  $clubsPilotsTable, $pilotsTable  
  			WHERE $clubsPilotsTable.pilotID=$pilotsTable.pilotID  
					AND $clubsPilotsTable.pilotServerID=$pilotsTable.serverID AND $clubsPilotsTable.clubID=$clubID";
	} else {
	  	$query="SELECT DISTINCT userID, userServerID FROM $flightsTable ";
	}
	
	// echo $query;
	$res= $db->sql_query($query);		
    if($res <= 0){
		echo "ERROR in selecting pilots";
//		echo $query;
		return array( array (),array () );
    }

	$pilots=array();
	$pilotsID=array();
	while ($row = $db->sql_fetchrow($res)) {
		$name = getPilotRealName($row["userID"],$row["userServerID"],0,2);
		$name=strtoupper(substr($name,0,1)).substr($name,1);
		$pnames[($row["userServerID"]+0).'_'.$row["userID"]]=$name;
	}
	if (!empty($pnames)) {
		asort($pnames);
		foreach($pnames as $userID=>$name) {
			 array_push($pilots,$name );
			 array_push($pilotsID,$userID);
		}
	}
	return array($pilots,$pilotsID);

}

function getUsedGliders($userID,$serverID=0) {
	global $db;
	global $flightsTable;

	$query="SELECT glider,gliderBrandID from $flightsTable WHERE userID=$userID AND userServerID=$serverID AND  ( glider <> '' OR gliderBrandID <>0 ) GROUP BY gliderBrandID,glider ORDER BY DATE DESC ";
	// echo $query;
	$res= $db->sql_query($query);		
    if($res <= 0){
		return array ();
    }

	$gliders=array();
	while ($row = $db->sql_fetchrow($res)) { 
			array_push($gliders,array($row['gliderBrandID'],$row['glider'])  );
	}
	return $gliders;
}

function transliterate($str,$enc) {
	// see this for hebraic-chinisee
	// http://www.derickrethans.nl/translit.php
	global $CONF_use_utf;

	if ($enc=='gb2312') {
		// echo "#### $str $enc ##";		

		if (! $CONF_use_utf )  {
			require_once dirname(__FILE__)."/lib/ConvertCharset/convert_gb2312.php";	
			return gb2312_to_latin($str);		
		} else {
			if (  substr( phpversion(),0,1 ) >=5 ) {
				require_once dirname(__FILE__)."/lib/ConvertCharset/chinese/charset.class.php";	
				$gb2312_str= Charset::convert($str,'utf-8','gb2312');
				$str2=Charset::PinYin($gb2312_str,'gb2312');
				// echo "^gb2312_str : $gb2312_str ^ ";			
				// echo "^str2: $str2 ^ ";
				return $str2;
			} else {
				return $str;
			}
		}
	}
	require_once dirname(__FILE__)."/lib/ConvertCharset/ConvertCharset.class.php";
	require_once dirname(__FILE__)."/lib/utf8_to_ascii/utf8_to_ascii.php";

	// if $CONF_use_utf it means the $str is already in utf
	// so  translitarate it directly
	if ($CONF_use_utf) return utf8_to_ascii($str);

	$NewEncoding = new ConvertCharset;
	$str_utf8 = $NewEncoding->Convert($str, $enc, "utf-8", $Entities);
	
	return utf8_to_ascii($str_utf8);
}

function getPilotInfo($pilotIDview,$serverID) {
	global $db,$pilotsTable,$opMode;
	global $currentlang,$nativeLanguage,$langEncodings,$lang2iso,$langEncodings;
	global $countries,$langEncodings;
	global $CONF_use_leonardo_names,$PREFS,$CONF;

	$query="SELECT Sex,Birthdate,LastName,FirstName,countryCode,CIVL_ID,serverID 
			FROM $pilotsTable WHERE pilotID=$pilotIDview  AND serverID=$serverID ";
	$res= $db->sql_query($query);
	// echo $query;


	// Get real name from leonardo_pilots
	// 
	// we must make sure the name can be displayed in the $currentlang encoding
	// 
	if ($res) {
		$pilot = $db->sql_fetchrow($res);
		$firstName=$pilot['FirstName'];
		$lastName=$pilot['LastName'];
		$pilotCountry=strtolower($pilot['countryCode']);
		$Sex=$pilot['Sex'];
		$Birthdate=$pilot['Birthdate'];
		$CIVL_ID=$pilot['CIVL_ID'];		

		if ( strlen($lastName)>1 && ($CONF_use_leonardo_names || $langEncodings[$currentlang]==$langEncodings[$nativeLanguage]) ) { // always return real name				
			// we have some info on how to tranlitarate
			// and the currentlang is not the native lang of the pilot.			
			$pilotLang=""; 			
			if ($pilotCountry && !countryHasLang($pilotCountry,$currentlang)  ) { 
				if ( ($pilotLang=array_search($pilotCountry,$lang2iso)) === NULL ) 
					$pilotLang=$nativeLanguage; 				
				//echo $pilotLang."#".$pilotCountry."$";			
			} 

			//	if all else fails translitarate using the nativeLangauge
			if (!$pilotCountry && !$pilotLang && $langEncodings[$nativeLanguage]!=$langEncodings[$currentlang]) $pilotLang=$nativeLanguage;
			// echo ">$realName ".$pilotLang."#".$pilotCountry."$<br>";	

			$enc=$langEncodings[$pilotLang];
			if ($enc) {
				$firstName=transliterate($firstName,$enc);
				$lastName=transliterate($lastName,$enc);
			}
			//echo $realName."@";
			// else return as is.


			return array($lastName,$firstName,$pilotCountry,$Sex,$Birthdate,$CIVL_ID);
			
		}
					
		/*
		if (strlen ($realName)>1) && $currentlang==$nativeLanguage) { // else realname is no good
			if ($getAlsoCountry ) return getNationalityDescription($pilot['countryCode'],1,0)."$realName"; 
			else return $realName; 
		}*/
		
	} 

    if ($opMode==1) { // phpNuke 
		$res= $db->sql_query("SELECT username,name FROM ".$CONF['userdb']['users_table']." WHERE ".$CONF['userdb']['user_id_field']."=".$pilotIDview ); 
		if ($res) {
			$row= $db->sql_fetchrow($res);
			if ($currentlang!=$nativeLanguage) { 
				 $realName=$row["username"]; 
			} else {
				 if ($row["name"]!='') $realName=$row["name"];
				 else $realName=$row["username"];
			}
			$str=$realName;		
		}		
	} else { // phpBB
		$res= $db->sql_query("SELECT ".$CONF['userdb']['user_real_name_field']." FROM  ".$CONF['userdb']['users_table']." WHERE ".$CONF['userdb']['user_id_field']."=".$pilotIDview ); 
		if ($res) {
			$row= $db->sql_fetchrow($res);
			$realName=$row[$CONF['userdb']['user_real_name_field']];

			$str=$realName;			
			// we have some info on how to tranlitarate
			// and the currentlang is not the native lang of the pilot.			
			$pilotLang=""; 			
			if ($pilotCountry && !countryHasLang($pilotCountry,$currentlang)  ) { 
				if ( ($pilotLang=array_search($pilotCountry,$lang2iso)) === NULL ) 
					$pilotLang=$nativeLanguage; 				
				//echo $pilotLang."#".$pilotCountry."$";			
			} 

			//	if all else fails translitarate using the nativeLangauge
			if (!$pilotCountry && !$pilotLang && $langEncodings[$nativeLanguage]!=$langEncodings[$currentlang]) $pilotLang=$nativeLanguage;
			// echo ">".$pilotLang."#".$pilotCountry."$";	

			$enc=$langEncodings[$pilotLang];
			if ($enc) $str=transliterate($str,$enc);
			//echo $realName."@";
			// else return as is.
		}
	}
	list($lastName,$firstName)=split(" ",$str,2);
	return array($lastName,$firstName,$pilotCountry,$Sex,$Birthdate,$CIVL_ID);

}

function getExternalLinkIconStr($serverID,$linkURL='',$typeOfLink=1) { 
	// $typeOfLink=1 img, 0->none, 2->text (*)
	global $CONF,$CONF_server_id,$moduleRelPath;
	if ( !$serverID || $serverID==$CONF_server_id || $typeOfLink==0 ||
		 $CONF['servers']['list'][$serverID]['treat_flights_as_local'] ) return '';
	else if ($typeOfLink==1) return "<img class='flagIcon' src='$moduleRelPath/img/icon_link.gif' border=0 title='"._External_Entry." $linkURL'>";
	else if ($typeOfLink==2) return " (*)";
	else if ($typeOfLink==3) {
		//$file="$moduleRelPath/img/servers/".sprintf("%03d",$serverID).".gif";
		//if (!is_file($file)) $file="$moduleRelPath/img/icon_link.gif";
		$file="$moduleRelPath/img/icon_link.gif";
		return "<img class='flagIcon' src='$file' border=0 title='"._External_Entry." $linkURL'>";
	}
}

function getPilotRealName($pilotIDview,$serverID,$getAlsoCountry=0,$getAlsoExternalIndicator=1,$gender=1) {
	global $db,$pilotsTable,$opMode;
	global $currentlang,$nativeLanguage,$langEncodings,$lang2iso,$langEncodings;
	global $countries,$langEncodings;
	global $CONF_use_leonardo_names,$PREFS,$CONF,$moduleRelPath;


	if ($PREFS->nameOrder==1) $nOrder="CONCAT(FirstName,' ',LastName)";
	else $nOrder="CONCAT(LastName,' ',FirstName)";
	
	$query="SELECT $nOrder as realName ,countryCode,serverID,Sex FROM $pilotsTable WHERE pilotID=$pilotIDview  AND serverID=$serverID";
	$res= $db->sql_query($query);
	// echo $query;


	// Get real name from leonardo_pilots
	// 
	// we must make sure the name can be displayed in the $currentlang encoding
	// 
	if ($res) {
		$pilot = $db->sql_fetchrow($res);
		$realName=$pilot['realName'];
		$pilotCountry=strtolower($pilot['countryCode']);

		if ( strlen($realName)>1 && ($CONF_use_leonardo_names || $langEncodings[$currentlang]==$langEncodings[$nativeLanguage]) ) { // always return real name		
			$str=$realName;
			
			// we have some info on how to tranlitarate
			// and the currentlang is not the native lang of the pilot.			
			$pilotLang=""; 			
			if ($pilotCountry && !countryHasLang($pilotCountry,$currentlang)  ) { 
				if ( ($pilotLang=array_search($pilotCountry,$lang2iso)) === NULL ) 
					$pilotLang=$nativeLanguage; 				
				//echo $pilotLang."#".$pilotCountry."$";			
			} 

			//	if all else fails translitarate using the nativeLangauge
			if (!$pilotCountry && !$pilotLang && $langEncodings[$nativeLanguage]!=$langEncodings[$currentlang]) $pilotLang=$nativeLanguage;
			// echo ">$realName#$pilotLang#$pilotCountry#<br>";	

			$enc=$langEncodings[$pilotLang];
			if ($enc) $str=transliterate($str,$enc);
			//echo $realName."@";
			// else return as is.

			if ($getAlsoCountry )  $str=getNationalityDescription($pilot['countryCode'],1,0).$str; 
			
			if ($gender==1 && $pilot['Sex']=='F') 
				$str.="<img src='$moduleRelPath/img/icon_female_small.gif' border=0 align='absmiddle'>";

			$str=$str.getExternalLinkIconStr($serverID,'',$getAlsoExternalIndicator);

			return $str;
		}
					
		/*
		if (strlen ($realName)>1) && $currentlang==$nativeLanguage) { // else realname is no good
			if ($getAlsoCountry ) return getNationalityDescription($pilot['countryCode'],1,0)."$realName"; 
			else return $realName; 
		}*/
		
	} 

    if ($opMode==1) { // phpNuke 
		$res= $db->sql_query("SELECT username,name FROM ".$CONF['userdb']['users_table']." WHERE ".$CONF['userdb']['user_id_field']."=".$pilotIDview ); 
		if ($res) {
			$row= $db->sql_fetchrow($res);
			if ($currentlang!=$nativeLanguage) { 
				 $realName=$row["username"]; 
			} else {
				 if ($row["name"]!='') $realName=$row["name"];
				 else $realName=$row["username"];
			}
			$str=$realName;		
		}		
	} else { // phpBB
		$res= $db->sql_query("SELECT ".$CONF['userdb']['user_real_name_field']." FROM  ".$CONF['userdb']['users_table']." WHERE ".$CONF['userdb']['user_id_field']."=".$pilotIDview ); 
		if ($res) {
							
			$row= $db->sql_fetchrow($res);
			$realName=$row[$CONF['userdb']['user_real_name_field']];

			$str=$realName;			
			// we have some info on how to tranlitarate
			// and the currentlang is not the native lang of the pilot.			
			$pilotLang=""; 			
			if ($pilotCountry && !countryHasLang($pilotCountry,$currentlang)  ) { 
				if ( ($pilotLang=array_search($pilotCountry,$lang2iso)) === NULL ) 
					$pilotLang=$nativeLanguage; 				
				//echo $pilotLang."#".$pilotCountry."$";			
			} 

			//	if all else fails translitarate using the nativeLangauge
			if (!$pilotCountry && !$pilotLang && $langEncodings[$nativeLanguage]!=$langEncodings[$currentlang]) $pilotLang=$nativeLanguage;
			 // echo "($str)>".$pilotLang."#".$pilotCountry."$";	

			$enc=$langEncodings[$pilotLang];
			if ($enc) $str=transliterate($str,$enc);
			//echo $realName."@";
			// else return as is.
		}
	}

	$str.=getExternalLinkIconStr($serverID,'',$getAlsoExternalIndicator);
	if ($getAlsoCountry ) $str=getNationalityDescription($pilot['countryCode'],1,0).$str; 
	
	if ($gender==1 && $pilot['Sex']=='F') 
		$str.="<img src='$moduleRelPath/img/icon_female_small.gif' border=0 align='absmiddle'>";

	return $str; 
}

function getPilotPhotoRelFilename($pilotID,$icon=0) {
	global 	$moduleRelPath;
	
	if ($icon) $suffix="icon.jpg";
	else $suffix=".jpg";
	return $moduleRelPath."/flights/".$pilotID."/PilotPhoto".$suffix;
}


function getPilotPhotoFilename($pilotID,$icon=0) {
	global $flightsAbsPath;
	if ($icon) $suffix="icon.jpg";
	else $suffix=".jpg";
	return $flightsAbsPath."/".$pilotID."/PilotPhoto".$suffix;
}

function getPilotStatsRelFilename($pilotID,$num) {
	global 	$moduleRelPath;	
	return $moduleRelPath."/flights/".$pilotID."/PilotStats_$num.png";
}
function getPilotStatsFilename($pilotID,$num) {
	global $flightsAbsPath;
	return $flightsAbsPath."/".$pilotID."/PilotStats_$num.png";
}

function getNationalityDescription($cCode,$img=1,$text=1) {
	global 	$moduleRelPath,$countries;	
	$cCode=strtolower($cCode);
	if (strlen($cCode) !=2) { 
		$cCode='unknown';
		$str='unknown';
	} else {
		$str=$countries[strtoupper($cCode)];
	}

	if ($img) $imgStr="<img class='flagIcon' src='$moduleRelPath/img/flags/$cCode.gif' border=0 title='$str'>";
	if ($text) $textStr=$str;
	return "$imgStr$textStr";
}

/**
 * Modification Martin Jursa 26.04.2007
 * Support for disabled added
 *
 * @param string $cCode
 * @param bool $disabled
 * @return string
 */
function getNationalityDropDown($cCode, $disabled=false) {
	global $countries;
	asort($countries);
	$disabled_attr=$disabled ? ' disabled' : '';
	$str="<select name='countriesList' $disabled_attr>";
	$str.="<option value=''></option>\n";
	foreach ($countries as $countrycode=>$countryName) {
		if ( strtolower($countrycode)==strtolower($cCode) ) $sel=" selected"; 
		else $sel="";
		$str.="<option value='$countrycode' $sel>$countryName</option>\n";
	}
	$str.='</Select>';
	return $str;
}

/**
 * Martin Jursa 26.04.2007
 *
 * @param string $sex
 * @param bool $disabled
 * @return string
 */
function getSexDropDown($sex, $disabled=false) {
	$disabled_attr=$disabled ? ' disabled' : '';
	if ($sex!='M' && $sex!='F') $sex='';
	$str="<select name='Sex' $disabled_attr>\n";
	$values=array(''=>'', 'M'=>_Male_short, 'F'=>_Female_short);
	foreach ($values as $value=>$desc) {
		$selected=$sex==$value ? ' selected ' : '';
		$str.="<option value='$value' $selected>$desc</option>\n";
	}
	$str.='</select>
';
	return $str;
}

function getPilotSexString($sex,$icon=true){
	global $moduleRelPath;

	if ($sex=='M') $str=_Male_short;
	else if ($sex=='F') $str=_Female_short;

	if ($icon) {
		if ($sex=='M') $str="<img src='$moduleRelPath/img/icon_male.gif' border=0 align='absmiddle'> ".$str;
		else if ($sex=='F') $str="<img src='$moduleRelPath/img/icon_female.gif' border=0 align='absmiddle'> ".$str;
	}

	return $str;

}
/**
 * Martin Jursa 26.04.2007
 * Save email and password to user table if the respective options are set
 * returns a resultmessage
 *
 * @param int $userID
 * @param string $newEmail
 * @param string $newPassword
 * @param string $newPasswordConfirmation
 * @return string
 */
function saveLoginData($userID, $newEmail, $newPassword, $newPasswordConfirmation) {
	global $db;
	global $CONF_edit_login;
	global $CONF_edit_email;
	global $CONF_password_minlength;
	$goodmsgs=array();
	$errmsgs=array();
	if (empty($CONF_edit_login)) {
		$errmsgs[]='saveLoginData requires turning on CONF_edit_login.';
	}elseif (empty($userID)) {
		$errmsgs[]='UserID is missing; cannot update login data.';
	}else  {
		if (!empty($CONF_edit_email)) {
			if (empty($newEmail)) {
				$errmsgs[]=_EmailEmpty;
			}else {
				$saved=false;
				$email=emailChecked($newEmail);
				if ($email=='') {
					$errmsgs[]=_EmailInvalid;
				}else {
					$sql='UPDATE '.USERS_TABLE." SET user_email='$email' WHERE user_id=$userID";
					$res=$db->sql_query($sql);
			  		if($res<=0){
			  			$errmsgs[]=_EmailSaveProblem;
			  		}else {
						//$goodmsgs[]=_EmailSaved;
						$saved=true;
			  		}
				}
	  			if (!$saved) $errmsgs[]=_EmailNotSaved;
			}
		}
		if (!empty($newPassword)) {
			$saved=false;
			$newPassword=trim($newPassword);
			$newPasswordConfirmation=trim($newPasswordConfirmation);
			$passwordMinLength=!empty($CONF_password_minlength) ? $CONF_password_minlength : 4;
			if ($newPasswordConfirmation=='') {
				$errmsgs[]=_PwdConfEmpty;
			}elseif (strlen($newPassword)<$passwordMinLength) {
				eval('$errmsgs[]="'._PwdTooShort.'";');
			}elseif ($newPassword!=$newPasswordConfirmation) {
				$errmsgs[]=_PwdAndConfDontMatch;
			}else {
				$pwd=md5($newPassword);
				$sql='UPDATE '.USERS_TABLE." SET user_password='$pwd' WHERE user_id=$userID";
				$res=$db->sql_query($sql);
		  		if($res<=0){
		  			$errmsgs[]=_PwdChangeProblem;
		  		}else {
		  			$goodmsgs[]=_PwdChanged;
	  				$saved=true;
		  		}
			}
	  		if (!$saved) $errmsgs[]=_PwdNotChanged;
		}
	}
	$message='';
	if (count($goodmsgs)>0) {
		$message.=implode('<br>', $goodmsgs);
	}
	if (count($errmsgs)>0) {
		$message.='<div style="color:red; margin:0">'.implode('<br>', $errmsgs).'</div>';
	}
	return $message;
}



?>
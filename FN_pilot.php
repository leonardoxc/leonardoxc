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
function getPilotList() {
	global $db;
	global $flightsTable,$prefix;
	global $nativeLanguage,$currentlang,$opMode;
	
  	$query="SELECT DISTINCT userID, ".(($opMode==1)?"name,":"")." username FROM $flightsTable,".$prefix."_users  WHERE ".$flightsTable.".userID=".$prefix."_users.user_id ".
			""; //"ORDER BY ".(($opMode==1)?"name,":"")." username ";

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
		$name =getPilotRealName($row["userID"]);
		$pnames[$row["userID"]]=$name;
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

function getUsedGliders($userID) {
	global $db;
	global $flightsTable;

	$query="SELECT glider from $flightsTable WHERE userID=$userID AND glider <> '' GROUP BY glider ORDER BY DATE DESC ";
// echo $query;
	$res= $db->sql_query($query);		
    if($res <= 0){
		return array ();
    }

	$gliders=array();
	while ($row = $db->sql_fetchrow($res)) { 
			array_push($gliders,$row["glider"] );
	}
	return $gliders;
}

function getPilotRealName($pilotIDview,$getAlsoCountry=0) {
	global $db,$pilotsTable,$prefix,$opMode;
	global $currentlang,$nativeLanguage;
	global $countries;
	global $CONF_phpbb_realname_field;

	$query="SELECT CONCAT(FirstName,' ',LastName) as realName ,countryCode FROM $pilotsTable WHERE pilotID=".$pilotIDview ;
	$res= $db->sql_query($query);
	// echo $query;

	if ($res) {
		$pilot = $db->sql_fetchrow($res);
		$realName=$pilot['realName'];
		if (strlen ($realName)>1 && $currentlang==$nativeLanguage) { // else realname is no good
			if ($getAlsoCountry ) return getNationalityDescription($pilot['countryCode'],1,0)."$realName"; 
			else return $realName; 
		}
	} 

    if ($opMode==1) { // phpNuke 
		$res= $db->sql_query("SELECT username,name FROM ".$prefix."_users WHERE user_id=".$pilotIDview ); 
		if ($res) {
			$row= $db->sql_fetchrow($res);
			if ($currentlang!=$nativeLanguage) { 
				 $realName=$row["username"]; 
			} else {
				 if ($row["name"]!='') $realName=$row["name"];
				 else $realName=$row["username"];
			}
		}		
	} else { // phpBB
		$res= $db->sql_query("SELECT $CONF_phpbb_realname_field FROM  ".$prefix."_users WHERE user_id=".$pilotIDview ); 
		if ($res) {
			$row= $db->sql_fetchrow($res);
			$realName=$row["$CONF_phpbb_realname_field"];
		}
	}
	if ($getAlsoCountry ) return getNationalityDescription($pilot['countryCode'],1,0)."$realName"; 
	else return $realName; 
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
	if (strlen($cCode) !=2) return "";

	if ($img) $imgStr="<img src='$moduleRelPath/img/flags/$cCode.gif' border=0 title='".$countries[strtoupper($cCode)]."'>";
	if ($text) $textStr=$countries[strtoupper($cCode)];
	return "$imgStr $textStr";
}

function getNationalityDropDown($cCode) {
	global $countries;
	$str="<Select name='countriesList'>";
	$str.="<option value=''></option>\n";
	foreach ($countries as $countrycode=>$countryName) {
		if ( strtolower($countrycode)==strtolower($cCode) ) $sel=" selected"; 
		else $sel="";
		$str.="<option value='$countrycode' $sel>$countryName</option>\n";
	}
	$str.='</Select>';
	return $str;
}



?>
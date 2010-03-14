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
// $Id: GUI_EXT_flight_scores_info.php,v 1.6 2010/03/14 20:56:10 manolis Exp $                                                                 
//
//************************************************************************

 	require_once dirname(__FILE__)."/EXT_config_pre.php";
	require_once dirname(__FILE__)."/config.php";
 	require_once dirname(__FILE__)."/EXT_config.php";

	require_once dirname(__FILE__)."/CL_flightScore.php";
	require_once dirname(__FILE__)."/CL_flightData.php";
	require_once dirname(__FILE__)."/FN_functions.php";	
	require_once dirname(__FILE__)."/FN_UTM.php";
	require_once dirname(__FILE__)."/FN_waypoint.php";	
	require_once dirname(__FILE__)."/FN_output.php";
	require_once dirname(__FILE__)."/FN_pilot.php";
	require_once dirname(__FILE__)."/FN_flight.php";
	require_once dirname(__FILE__)."/templates/".$PREFS->themeName."/theme.php";
	setDEBUGfromGET();
	require_once dirname(__FILE__)."/language/".CONF_LANG_ENCODING_TYPE."/lang-".$currentlang.".php";
	require_once dirname(__FILE__)."/language/".CONF_LANG_ENCODING_TYPE."/countries-".$currentlang.".php";

	$flightID=makeSane($_GET['flightID'],1);
	if ($flightID<=0) exit;
		
	$flight=new flight();
	$flight->getFlightFromDB($flightID);

		
//   if (  !L_auth::isModerator($userID) ) {
//		echo "go away";
//		return;
//   }


	$flightScore=new flightScore($flightID);
	$flightScore->getFromDB();
	
  ?><head>
  <meta http-equiv="Content-Type" content="text/html; charset=<?=$CONF_ENCODING?>">

<style type="text/css">
	 body, p, table,tr,td {font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px;}
	 td {border:1px solid #777777; }
	 body {margin:0px; background-color:#FFFFFF}
	.box {
		 background-color:#F4F0D5;
		 border:1px solid #555555;
		padding:3px; 
		margin-bottom:5px;
	}
	.boxTop {margin:0; }
	
	.header1 { background-color:#E2ECF8 }
	.header2 { background-color:#F9F8E1 }
	.header3 { background-color:#E6EEE7 }

	
</style>
</head>
<?
	//echo "<PRE>";
	//print_r($flightScore->scores);		
	//echo "</pre>";
	//return;
	
	echo "<table width='360'>";

	foreach ($flightScore->scores as $mID=>$mScores) {
		echo "<tr><td colspan=4 class='header1'>Scoring Factors Used: ".$CONF['scoring']['sets'][$mID]['name']."</td></tr>\n";
		echo "<tr><td class='header2'>Type of Flight</td><td class='header2'>Factor</td><td  class='header2' align='right'>XC distance</td><td  class='header2' align='right'>XC Score</td></tr>\n";
		foreach($mScores as $type=>$score) {
			$typeID=$flightScore->flightTypes[$type];
			if (!$typeID) continue;
			if (!$CONF['scoring']['sets'][$mID]['types'][$type]) continue;

			echo "<tr><td class='header3'>";
			if ($score['isBest']) echo "(*) ";
			echo $flightScore->flightTypesDescriptions[$typeID]."</td>";
			echo "<td>x".$CONF['scoring']['sets'][$mID]['types'][$type]."</td>";
			echo "<td align='right'>".sprintf('%2.3f ',$score['distance'])._KM."</td>";
			echo "<td align='right'>".sprintf('%2.3f',$score['score'])."</td>";
			echo "</tr>\n";
		}
	}		
	echo "</table>";
?>
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
// $Id: GUI_EXT_flight_comments.php,v 1.1 2010/11/12 12:28:21 manolis Exp $                                                                 
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

	if (!$flight->commentsNum) {
		// no comments
		return;
	}



	$flightComments=new flightComments($flight->flightID);
	$flightComments->getFromDB();
	// $comments=$flightComments->getThreadsOutput();
		 
	
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

	.comments {
		background-color:#EEECE8;
		border-bottom:#E8E9DC 1px solid;		
	}	
	
	.depth0 { margin-left:0px;}
	.depth1 { margin-left:20px;}
	.depth2 { margin-left:40px;}
	.depth3 { margin-left:60px;}
	.depth4 { margin-left:80px;}
	.depth5 { margin-left:100px;}
	.depth6 { margin-left:120px;}
	.depth7 { margin-left:140px;}
	.depth8 { margin-left:160px;}
	.depth9 { margin-left:180px;}
	
</style>
</head>
<?

		$str='';
		foreach($flightComments->threads as $thread) {		
			$commentData=$flightComments->comments[$thread['id']];			
			$str.="<div class='comments depth".$thread['depth']."'>";
			$str.=$commentData['text'];
			$str.="</div>";
		}
		echo  $str;
		


?>
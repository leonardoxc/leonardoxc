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
// $Id: GUI_EXT_flight_comments.php,v 1.14 2011/01/16 21:38:37 manolis Exp $                                                                 
//
//************************************************************************

// nice exmple in action 
//http://onerutter.com/open-source/jquery-facebook-like-plugin.html

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
	
	function isPFBRequest( $id, $checksum ) {//Added 02.12.2011 P. Wild
		$teststring = "PFB*45".$id."96*XPF";
		if ( md5($teststring) == strtolower($checksum) )
		{
			return True;
		} else return False;
	}

	$filename=makeSane($_REQUEST['file'],2);
	 $filename=str_replace('//','/',$filename);
//	 print_r($_SESSION);exit;
	
	$flightID=makeSane($_REQUEST['flightID'],1);
	if ($flightID<=0 && !$filename ) exit;

	$clientIP=getClientIpAddr();
	
	
	if (isPFBRequest($_GET["flightID"],$_GET["cs"])) {//Added 02.12.2011 P. Wild
		echo "PFB <br>";	
		$authOK=1;
		} else{
			
			
			
	if ( $flightID ) {
		$flight=new flight();
		$flight->getFlightFromDB($flightID);
			
		$authOK=0;		
		//echo "#userID:$userID<BR>";
		
		if ( $flight->belongsToUser($userID) || L_auth::isModerator($userID) || L_auth::canDownloadIGC($clientIP) ) {
			$authOK=1;
		}
	} else if ($filename){
		$authOK=0;		
		$base_name=md5(basename($filename));
		// echo $base_name."#";
		if ( L_auth::isModerator($userID) || L_auth::canDownloadIGC($clientIP) ||  $_SESSION['di'.$base_name]  ) {
			$authOK=1;
		}	
	
	}	
	}// end of PFB loop
	if ($authOK ) {
		$type='igc';
		require_once dirname(__FILE__).'/download_igc.php';
		return;
	}
				 	
  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$CONF_ENCODING?>">
<? if (!$authOK) {?>
<style type="text/css">
#igcLink {
	display:block;
	position:absolute;
	top:50px;
	left:100px;
	z-index:-100;
}
body, * {
margin:0;
padding:0;
}

</style>

<link href="<?=moduleRelPath()?>/js/sexy-captcha/css/styles.css" rel="stylesheet" type="text/css" media="all" />

<script type="text/javascript" src="<?=moduleRelPath()?>/js/jquery.js"></script>
<script type="text/javascript" src="<?=moduleRelPath()?>/js/sexy-captcha/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="<?=moduleRelPath()?>/js/sexy-captcha/jquery.sexy-captcha-0.1.js"></script>
<script language="javascript">


$(document).ready(function(){
 	$('.myCaptcha').sexyCaptcha('<?=moduleRelPath()?>/js/sexy-captcha/captcha.process.php');
	$('#downloadForm').submit(function() {
	  $("#captchaStr").val( $("#captcha").val() );
	  return true;
	});

});
</script>
<? } ?>
</head>
<body>
<form action="<?=$moduleRelPath?>/download_igc.php" method="post"  id="downloadForm">
<input type="hidden" id="captchaStr" name="captchaStr" value="" />
<input type="hidden" id="type" name="type" value="igc" />

<input type="hidden" id="file" name="file" value="<?=$filename?>" />
<input type="hidden" id="flightID" name="flightID" value="<?=$flightID?>" />
<div class="myCaptcha"></div>
<div id="igcLink"><input type="submit" class='submit' value="Download IGC File" /></div>
</form>

</div>
</body>
</html>

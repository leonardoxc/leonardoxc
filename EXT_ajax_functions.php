<?
//************************************************************************
// Leonardo XC Server, https://github.com/leonardoxc/leonardoxc
//
// Copyright (c) 2004-2010 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: EXT_ajax_functions.php,v 1.6 2012/09/11 19:27:11 manolis Exp $                                                                 
//
//************************************************************************

 	require_once dirname(__FILE__)."/EXT_config_pre.php";
	require_once "config.php";
 	require_once "EXT_config.php";

	/*require_once "CL_flightData.php";
	require_once "FN_functions.php";	
	require_once "FN_UTM.php";
	require_once "FN_waypoint.php";	
	require_once "FN_output.php";
	require_once "FN_pilot.php";
	require_once "FN_flight.php";	
	*/
	// setDEBUGfromGET();
	
	$op=makeSane($_REQUEST['op']);	
	if ($op=='getCategoriesForCertID'){	
		$gliderCertID=makeSane($_REQUEST['gliderCertID']);	
		$showAll=makeSane($_REQUEST['showAll']);
		$gliderCat=makeSane($_REQUEST['gliderCat']);	
		
		if ($gliderCat!=1) $showAll=1;
		
		$str=" { [";
		if (!empty($CONF_addflight_js_validation)) {
   			$str.=" [\"0\", \"-\"],";
			if ($CONF['gliderClasses'][$gliderCat]['classes']) {
				foreach ( $CONF['gliderClasses'][$gliderCat]['classes'] as $gl_id=>$gl_type) {
						if ($showAll || in_array($gl_id ,$CONF_cert_avalable_categories[$gliderCertID] )  )  {
							$str.=" [\"$gl_id\", \"$gl_type\"],";
						}
				}
			}	
		}else {
			if ($CONF['gliderClasses'][$gliderCat]['classes']) {
				foreach ( $CONF['gliderClasses'][$gliderCat]['classes'] as $gl_id=>$gl_type) {
					if ($CONF['gliderClasses'][$gliderCat]['default_class'] == $gl_id) $is_type_sel ="selected";
					else $is_type_sel ="";
					if ($showAll || in_array($gl_id ,$CONF_cert_avalable_categories[$gliderCertID] ) )  {
							$str.=" [\"$gl_id\", \"$gl_type\"],";
					}
				}
			}	
		}
		$str=substr($str,0,-1);
		$str.=" ] } ";
		echo $str;
	} else if ($op=='storeFavs') {
		
	
		$_SESSION['favHtml']=$_POST['favHtml'];
		echo "OK";
	} else if ($op=='getCountriesSelect') {
		require_once dirname(__FILE__)."/language/".CONF_LANG_ENCODING_TYPE."/countries-".$currentlang.".php";
		asort($countries);
		echo "<select>\n";
		foreach($countries as $cc=>$cname) {
			echo "<option value='$cc'>$cname</option>\n";
		}
		echo "</select>\n";
	}
?>
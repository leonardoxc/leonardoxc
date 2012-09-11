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
// $Id: GUI_flight_compare.php,v 1.1 2012/09/11 19:27:11 manolis Exp $                                                                 
//
//************************************************************************

	require_once $LeoCodeBase."/CL_image.php";
	require_once $LeoCodeBase."/CL_template.php";

	$Ltemplate = new LTemplate($LeoCodeBase.'/templates/'.$PREFS->themeName);
	
	$legend=_Compare_Flights;
 	openMain("<div style='width:50%;font-size:12px;clear:none;display:block;float:left'>
 	 $legend</div><div align='right' style='width:50%; text-align:right;clear:none;display:block;float:right' bgcolor='#eeeeee'>$legendRight</div>",0,'');
	
 
	$flights=$_GET['flightID'];
	
	if ( $CONF_google_maps_api_key  ) {
		 $googleMap="<div id='gmaps_div' style='display:block; width:745px; height:610px;'>
		 <iframe id='gmaps_iframe' align='left'
		  SRC='http://".$_SERVER['SERVER_NAME'].getRelMainDir()."EXT_google_maps_track_v3.php?id=".
		$flights."' TITLE='Google Map' width='100%' height='100%'
		  scrolling='no' frameborder='0'>
		Sorry. If you're seeing this, your browser doesn't support IFRAMEs.	
		You should upgrade to a more current browser.
		</iframe></div>";
		
		echo $googleMap;
	}
	closeMain();
	
?>
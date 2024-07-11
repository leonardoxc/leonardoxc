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
// $Id: GUI_browser.php,v 1.1 2010/03/16 21:26:25 manolis Exp $                                                                 
//
//************************************************************************

?>

<?
 $titleString=_FLIGHT_BROSWER;
 $imgStr="<img src='$moduleRelPath/img/icons1/geicon.gif' align='absmiddle'> ";
 openMain("<div style='width:100%;font-size:12px;clear:none;display:block;float:left'>$imgStr$titleString</div>",0,'');

?> 

<style type="text/css">
<!--
.gmaps_container {
	position: relative;
	height: 500px;
	width: 100%;
}

.gmaps_container-fullscreen {
	position: absolute;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
}
-->
</style>
<script type="text/javascript">
	function toogleGmapsFullScreen () {
		$("#gmaps_container").toggleClass("gmaps_container-fullscreen");
	}	
</script>

<div class='gmaps_container' id='gmaps_container'>
	<?  if ( $CONF_google_maps_api_key  ) { ?> 
	<iframe src="<? echo "http://".$_SERVER['SERVER_NAME'].getRelMainDir()."EXT_google_maps_browser.php"; ?>"
	  	title="Google Map" width="100%" height="100%" scrolling="no" frameborder="0">
	Sorry. If you're seeing this, your browser doesn't support IFRAMEs.
	You should upgrade to a more current browser.
	</iframe>
	<? } ?> 
</div>

<?
  closeMain();
?>
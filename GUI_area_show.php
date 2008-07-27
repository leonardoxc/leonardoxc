<? 
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://leonardo.thenet.gr                                            */
/* http://sourceforge.net/projects/leonardoserver                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/
?>  
<div align="center">
<?
$areaID=makeSane($_GET['areaID']);
if ( $CONF_google_maps_api_key  ) { ?> 
	<iframe align="center"
	  SRC="<? echo "http://".$_SERVER['SERVER_NAME'].getRelMainDir()."GUI_EXT_area_show.php?areaID=$areaID" ?>"
	  TITLE="Area Guide" width="750px" height="600px"
	  scrolling="yes" frameborder="0">
	Sorry. If you're seeing this, your browser doesn't support IFRAMEs.
	You should upgrade to a more current browser.
	</iframe>
	
<? } else { ?>	

<? } ?> 
</div>

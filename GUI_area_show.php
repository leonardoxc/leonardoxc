<?
//************************************************************************
// Leonardo XC Server, http://leonardo.thenet.gr
//
// Copyright (c) 2004-8 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: GUI_area_show.php,v 1.2 2008/11/29 22:46:07 manolis Exp $                                                                 
//
//************************************************************************
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

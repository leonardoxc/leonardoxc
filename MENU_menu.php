<? 
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://sourceforge.net/projects/leonardoserver                       */
/* http://leonardo.thenet.gr                                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/
?>
<? if (0) { ?>
<link rel="stylesheet" type="text/css" href="<?=$moduleRelPath?>/menu/themes/office_xp/office_xp.css">
<script type="text/javascript" src="<?=$moduleRelPath?>/menu/jsdomenu.js"></script>
<script type="text/javascript" src="<?=$moduleRelPath?>/menu/jsdomenubar.js"></script>

<script language="javascript">
	<? require_once $moduleRelPath."/jsdomenu.inc.js.php"; ?>
	window.onload = initjsDOMenu;
	// initjsDOMenu();
</script>
<? } else { ?>
	<link rel="stylesheet" type="text/css" href="<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/style_top_menu.css">
	<style type = "text/css">
	#nav li {
	   behavior: url('<? echo $moduleRelPath?>/topmenu.htc');
	}
	</style>
<?
	require_once dirname(__FILE__)."/MENU_top_menu.php";
 } ?>
<div class="main_text" align=center style="clear:both;">
<a name="top_of_page"></a>
<div id="staticMenuPos" align=left></div>

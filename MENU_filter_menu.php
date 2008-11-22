<?php
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
  
	$pilotLegend="";
	$allPilotsDisplay=0;
	if ($pilotID) {
		$pilotLegend=getPilotRealName($pilotID,$serverID);
	} else {
		$pilotLegend=_ALL_PILOTS;
		$allPilotsDisplay=1;
	}

	$takeoffLegend="";
	$allTakeoffDisplay=0;  
  	if ($takeoffID) {
		$takeoffLegend=getWaypointName($takeoffID);
	}  else {
		$takeoffLegend=_ALL_TAKEOFFS;
		$allTakeoffDisplay=1;
	}
  
	if ( $op=="list_pilots" && $comp) $isCompDisplay=1;
	else $isCompDisplay=0;

	// echo "$showNacClubSelection && $nacid && $nacclubid ##";

	// we must decide here if this menu row is to be displayed
	$displayFilterMenu=0;	
	// if no specific takeoff or piliot is sleected -> no display
	if ($allPilotsDisplay &&  $allTakeoffDisplay ) $displayFilterMenu=0;	
	
	if (! $allPilotsDisplay ) $displayFilterMenu|=0x01;	
	if (! $allTakeoffDisplay ) $displayFilterMenu|=0x02;

	if ( $op=='list_pilots' ) $displayFilterMenu&=~0x01;	
	if ( $op=='list_takeoffs' ) $displayFilterMenu&=~0x02;	
	
	// but if we have a club or nac club -> do display!
	if ($clubID  || ($showNacClubSelection && $nacid  && $nacclubid) ) 	$displayFilterMenu|=0x04;
	if ($op=='comp')$displayFilterMenu&=~0x04;
	
	if ( ! $displayFilterMenu) return;
	
	$catLegend="";
	$allCatDisplay=0;  
?>

<div class="mainBox" align="left" style="margin-top:0px; margin-bottom:4px;">  	

<? if ($showNacClubSelection && $nacid && $nacclubid ) {  ?>
  	    <div class="menu1" ><img src='<?=$moduleRelPath?>/img/icon_club.gif'  align="absmiddle" border=0>
  	    <?
  	    	echo "<b>$nacClubLegend</b>";
  	    	if (1) 
  	    		echo " <a href='".
				getLeonardoLink(array('op'=>'useCurrent','clubID'=>'0','nacid'=>'0','nacclubid'=>'0')).
				"'><img src='$moduleRelPath/templates/".$PREFS->themeName."/img/icon_x_white.gif' title='"._Display_ALL."' align='absmiddle' border=0></a>";
  	    ?>
  	    </div>
<? } ?>

<? if ($clubID) {  ?>
  	    <div class="menu1" ><img src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_club.gif'  align="absmiddle" border=0>
  	    <?
  	    	echo "<b>$clubName</b>";
  	    	if (!$noClubDisplay) 
  	    		echo " <a href='".getLeonardoLink(array('op'=>'useCurrent','clubID'=>'0'))."'><img src='$moduleRelPath/templates/".$PREFS->themeName."/img/icon_x_white.gif' title='"._Display_ALL."' align='absmiddle' border=0></a>";
  	    ?>
  	    </div>
<? } ?>


<? if ($op!='competition' && $op!='comp'  && $op!='list_pilots'  && !$isCompDisplay  && !$allPilotsDisplay) { ?>
<div class="menu1"><img src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_pilot.gif'  title='<?=_PILOT?>' align="absmiddle" border=0>
<?
	echo "<b>$pilotLegend</b>";
	if (!$allPilotsDisplay) 
		echo " <a href='".getLeonardoLink(array('op'=>'useCurrent','pilotID'=>'0'))."'><img src='$moduleRelPath/templates/".$PREFS->themeName."/img/icon_x_white.gif' title='"._Display_ALL."' align='absmiddle' border=0></a>";
?>
</div>		
<? } ?>


<? if ($op!='competition' && $op!='comp'  && $op!='list_takeoffs' &&  !$allTakeoffDisplay) { ?>
<div class="menu1"><img src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_takeoff.gif' title='<?=_TAKEOFF_LOCATION?>' align="absmiddle" border=0>
<?
	echo "<b>$takeoffLegend</b>";
	if (!$allTakeoffDisplay) 
		echo " <a href='".getLeonardoLink(array('op'=>'useCurrent','takeoffID'=>'0'))."'><img src='$moduleRelPath/templates/".$PREFS->themeName."/img/icon_x_white.gif' title='"._Display_ALL."' align='absmiddle' border=0></a>";
?>
</div>
<? } ?>  	


</div>
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
  if ($pilotID) $pilotLegend=getPilotRealName($pilotID,$serverID);
  else {
  	$pilotLegend=_ALL_PILOTS;
  	$allPilotsDisplay=1;
  }

  $takeoffLegend="";
  $allTakeoffDisplay=0;  
  if ($takeoffID) $takeoffLegend=getWaypointName($takeoffID);
  else {
		$takeoffLegend=_ALL_TAKEOFFS;
		$allTakeoffDisplay=1;
	}

  
  if ( $op=="list_pilots" && $comp) $isCompDisplay=1;
  else $isCompDisplay=0;

  if (!$clubID && $allPilotsDisplay &&  $allTakeoffDisplay ||
  		($op=='competition' || $op=='comp' || $op=='list_pilots' || $op=='list_takeoffs' || $isCompDisplay ) 
  		) return;

?>

<div class="mainBox" align="left" style="margin-top:0px; margin-bottom:4px;">  	
  	
		
<? if (0) {?>
    <div class="menu1" style="clear:none; float:left;" ><a href="#" onClick="toggleDiv('filterDropDownID','filterDropDownPos',18,-5);return false;"><img
	    id='filterDropDownPos' 	src='<?=$moduleRelPath?>/img/icon_filter_down.png' align="absmiddle" border=0 title=""></a>
    </div>
<? } ?>    

<? 

$arrDownImg="<img src='".$moduleRelPath."/img/icon_arrow_down.png' border=0>"; 
$arrDownImg="<img src='".$moduleRelPath."/img/icon_arrow_left.gif' border=0>";


  $catLegend="";
  $allCatDisplay=0;  

?>

<? if ($clubID) {  ?>
  	    <div class="menu1" ><img src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_club.gif'  align="absmiddle" border=0>
  	    <?
  	    	echo "<b>$clubName</b>";
  	    	if (!$noClubDisplay) 
  	    		echo " <a href='".getLeonardoLink(array('op'=>'useCurrent','clubID'=>'0'))."'><img src='$moduleRelPath/templates/".$PREFS->themeName."/img/icon_x_white.gif' title='"._Display_ALL."' align='absmiddle' border=0></a>";
  	    ?>
  	    </div>
<? } ?>


  	    <? if ($op!='competition' && $op!='comp'  && $op!='list_pilots' && $op!='list_takeoffs' && !$isCompDisplay  && !$allPilotsDisplay) { ?>
		<div class="menu1"><img src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_pilot.gif'  title='<?=_PILOT?>' align="absmiddle" border=0>
   	    <?
  	    	echo "<b>$pilotLegend</b>";
  	    	if (!$allPilotsDisplay) 
  	    		echo " <a href='".getLeonardoLink(array('op'=>'useCurrent','pilotID'=>'0'))."'><img src='$moduleRelPath/templates/".$PREFS->themeName."/img/icon_x_white.gif' title='"._Display_ALL."' align='absmiddle' border=0></a>";
  	    ?>
		</div>		
  	    <? } ?>
  	    <? if ($op!='competition' && $op!='comp' && $op!='list_pilots' && $op!='list_takeoffs' && !$isCompDisplay && !$allTakeoffDisplay) { ?>
		<div class="menu1"><img src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_takeoff.gif' title='<?=_TAKEOFF_LOCATION?>' align="absmiddle" border=0>
   	    <?
  	    	echo "<b>$takeoffLegend</b>";
  	    	if (!$allTakeoffDisplay) 
  	    		echo " <a href='".getLeonardoLink(array('op'=>'useCurrent','takeoffID'=>'0'))."'><img src='$moduleRelPath/templates/".$PREFS->themeName."/img/icon_x_white.gif' title='"._Display_ALL."' align='absmiddle' border=0></a>";
  	    ?>
		</div>
		<? } ?>  	

</div>

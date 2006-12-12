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



  //require_once dirname(__FILE__)."/MENU_dates.php";
  //require_once dirname(__FILE__)."/MENU_countries.php";
  
  $dateLegend="";
  $allTimesDisplay=0;
  if ($year && !$month ) $dateLegend.=$year;
  else if ($year && $month ) $dateLegend.=$monthList[$month-1]." ".$year;
  else if (! $year ) {
	$dateLegend.=_ALL_TIMES;
	$allTimesDisplay=1;
  }
  
  $countryLegend="";
  $allCountriesDisplay=0;
  if ($country) $countryLegend=$countries[$country];
  else {
  	$countryLegend=_WORLD_WIDE;
  	$allCountriesDisplay=1;
  }

  
  $pilotLegend="";
  $allPilotsDisplay=0;
  if ($pilotID) $pilotLegend=getPilotRealName($pilotID);
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

  
  $catLegend="";
  $allCatDisplay=0;  

  if (($isCompDisplay || $op=="competition") && !$cat) $cat=1;
  
  if ($cat) { 
    	$catLegend="<img src='".$moduleRelPath."/img/icon_cat_".$cat.".png' align='middle' border=0 title='"._GLIDER_TYPE.": ".$gliderCatList[$cat]."'>";
		//$gliderCatList[$cat]
  }	else {
		$allCatDisplay=1;  
		$catLegend="<img src='".$moduleRelPath."/img/icon_cat_".$cat.".png' align='middle' border=0 title='"._GLIDER_TYPE.": "._All_glider_types."'>";
  }

  

  	  // openBox("","100%","#f5f5f5");
  	   ?>
	   <div class="mainBox" align="left">  	
  	
		<? if ($_SESSION["filter_clause"]) {  ?>
   	    <div class="menu1" ><a href="?name=<?=$module_name?>&op=filter"><img 
		src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_filter.gif' align="absmiddle" border=0 title="<?=_THE_FILTER_IS_ACTIVE?>"></a>
		</div>
		<? } ?>

<? 
$arrDownImg="<img src='".$moduleRelPath."/img/icon_arrow_down.png' border=0>"; 

 if ( count($CONF_glider_types) > 1 ) { 
		$catLiStr="";

        $catLink="?name=".$module_name."&cat=0";
		$catImg="<img src='".$moduleRelPath."/img/icon_cat_0.png' border=0>";
		if ($cat==0) { 
			$tmpStyle="jsdomenubaritemoverICON";
			$current_catImg=$catImg;
		} else $tmpStyle="jsdomenubaritemICONS";
		$catLiStr.="<li><a href='$catLink'>$catImg "._All_glider_types."</a></li>\n";

		foreach( $CONF_glider_types as $tmpcat=>$tmpcatname) {
		  $catLink="?name=".$module_name."&cat=".$tmpcat;
		  $catImg="<img src='".$moduleRelPath."/img/icon_cat_".$tmpcat.".png' border=0>";
		  if ($cat==$tmpcat) { 
			$tmpStyle="jsdomenubaritemoverICON";
			$current_catImg=$catImg;
		  }
		  else $tmpStyle="jsdomenubaritemICONS";
		  $catLiStr.="<li><a href='$catLink'>$catImg ".$gliderCatList[$tmpcat]."</a></li>\n";
		} 	
?>

<ul id="nav" style="width:35px; height:22px; border: 1px solid #CA9F2A;" >
<li class="smallItem"><a class="smallItem" href='#'><? echo $catLegend;  // echo $current_catImg?></a>
	<ul>
	<? echo $catLiStr;?>
	</ul>
</li>

</ul>
<?
} // end if 
?> 



<? if (0) { ?>
   	    <div class="menu1" >
  	    <?
  	    	echo "<b>$catLegend</b>";
  	    	//if (!$allCatDisplay) 
  	    	//	echo "<a href='?name=$module_name&cat=0'><img src='modules/leonardo/templates/$PREFS->themeName/img/icon_remove.gif' title='"._Display_ALL."'  border=0></a>";
  	    ?>
  	    </div>
<? } ?>

		<? 
			
			if ($country) {
				$countryFlagImg="<img src='$moduleRelPath/img/flags/".strtolower($country).".gif'  title='"._MENU_COUNTRY."' align='absmiddle' style='margin-bottom:4px' border='0'>";
			} else {
				//$countryFlagImg="<img src='$moduleRelPath/templates/".$PREFS->themeName."/img/icon_country.gif'  title='"._MENU_COUNTRY."' align='absmiddle' border='0'>";
				$countryFlagImg="<img src='$moduleRelPath/img/globe.gif'  title='"._MENU_COUNTRY."' align='absmiddle' border='0'>";
			}
		?>
  	    <ul id="dropMenu">
			<li><a href="#"><?=$countryFlagImg?> <? echo "$countryLegend" ?> <?=$arrDownImg; ?></a>
				<ul>				
				 <li><?  require dirname(__FILE__)."/MENU_countries_simple.php"; ?></li>
				</ul>			
			</li>
			<li><a href="#"><img src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_date.gif' title='<?=_MENU_DATE?>' align="absmiddle" border=0> <? echo "$dateLegend";?> <? echo $arrDownImg; ?></a>
				<ul>
				 <?  require dirname(__FILE__)."/MENU_dates_simple.php"; ?>
				</ul>
			</li>
		</ul>
<? if (0) {?>
  	    <div class="menu1" >
			<a href="#selDate" class="supernote-hover-selDate note_link">
			<img src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_date.gif' title='<?=_MENU_DATE?>' align="absmiddle" border=0>
  	    	<?
  	    		echo "$dateLegend</a>";
  	    		if (!$allTimesDisplay) 
  	    			echo " <a href='?name=$module_name&year=0&month=0'><img src='$moduleRelPath/templates/".$PREFS->themeName."/img/icon_remove.gif' title='"._Display_ALL."' align='absmiddle' border=0></a>";
  	  		?>
  	    </div>
  	    
  	    <div class="menu1">
			<a href="#selCountry" class="supernote-hover-selCountry note_link">
			<img src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_country.gif'  title='<?=_MENU_COUNTRY?>' align="absmiddle" border=0>
   	    <?
  	    	echo "$countryLegend</a>";
  	    	if (!$allCountriesDisplay) 
  	    		echo " <a href='?name=$module_name&country=0'><img src='$moduleRelPath/templates/".$PREFS->themeName."/img/icon_remove.gif' title='"._Display_ALL."' align='absmiddle' border=0></a>";
  	    ?>
		</div>
<? } ?>

		<? if ($clubID) {  ?>
  	    <div class="menu1" ><img src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_club.gif'  align="absmiddle" border=0>
  	    <?
  	    	echo "<b>$clubName</b>";
  	    	if (!$noClubDisplay) 
  	    		echo " <a href='?name=$module_name&clubID=0'><img src='$moduleRelPath/templates/".$PREFS->themeName."/img/icon_remove.gif' title='"._Display_ALL."' align='absmiddle' border=0></a>";
  	    ?>
  	    </div>
  	    <? } ?>

  	    <? if ($op!='competition' && $op!='list_pilots' && $op!='list_takeoffs' && !$isCompDisplay  && !$allPilotsDisplay) { ?>
		<div class="menu1"><img src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_pilot.gif'  title='<?=_PILOT?>' align="absmiddle" border=0>
   	    <?
  	    	echo "<b>$pilotLegend</b>";
  	    	if (!$allPilotsDisplay) 
  	    		echo " <a href='?name=$module_name&pilotID=0'><img src='$moduleRelPath/templates/".$PREFS->themeName."/img/icon_remove.gif' title='"._Display_ALL."' align='absmiddle' border=0></a>";
  	    ?>
		</div>		
  	    <? } ?>
  	    <? if ($op!='competition' && $op!='list_pilots' && $op!='list_takeoffs' && !$isCompDisplay && !$allTakeoffDisplay) { ?>
		<div class="menu1"><img src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_takeoff.gif' title='<?=_TAKEOFF_LOCATION?>' align="absmiddle" border=0>
   	    <?
  	    	echo "<b>$takeoffLegend</b>";
  	    	if (!$allTakeoffDisplay) 
  	    		echo " <a href='?name=$module_name&takeoffID=0'><img src='$moduleRelPath/templates/".$PREFS->themeName."/img/icon_remove.gif' title='"._Display_ALL."' align='absmiddle' border=0></a>";
  	    ?>
		</div>
		<? } ?>  	
  	    <div class="menu1" >
		<a  href='<?
		echo "?name=$module_name&op=$op&year=$year&month=$month&pilotID=$pilotID&takeoffID=$takeoffID&country=$country&cat=$cat&clubID=$clubID";
		?>'><img src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_bookmark.gif' title='<?=_This_is_the_URL_of_this_page?>' align="absmiddle" border=0></a>

</div>

</div>
  	   <?   
  	   // closeBox();  	    

?>
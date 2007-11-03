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

	if ( $op!='comp' ) {
		if (! $CONF['seasons']['use_season_years'] ) $season=0;
	}

	if ($season) {
		$dateLegend.=_SEASON.' '.$season;
	} else {
	  if ($year && $month && $day && $op=="list_flights") $dateLegend.=sprintf("%02d.%02d.%04d",$day,$month,$year);
	  else if ($year && !$month ) $dateLegend.=$year;
	  else if ($year && $month ) $dateLegend.=$monthList[$month-1]." ".$year;
	  else if (! $year ) {
		// $dateLegend.=_ALL_TIMES;
		$dateLegend.=_SELECT_DATE;
		$allTimesDisplay=1;
	  }
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

?>
<div class="mainBox" align="left">  	
  	
		<? if ($_SESSION["filter_clause"]) {  ?>
   	    <div class="menu1" style="clear:none; float:left;" ><a href="<?=CONF_MODULE_ARG?>&op=filter"><img 
		src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_filter.gif' align="absmiddle" border=0 title="<?=_THE_FILTER_IS_ACTIVE?>"></a>
		</div>
		<? } ?>

<? 

$arrDownImg="<img src='".$moduleRelPath."/img/icon_arrow_down.png' border=0>"; 
$arrDownImg="<img src='".$moduleRelPath."/img/icon_arrow_left.gif' border=0>";


  $catLegend="";
  $allCatDisplay=0;  


if ( ! $dontShowCatSelection ) { 

if ( $clubID && is_array($clubsList[$clubID]['gliderCat']) ) {	
	if (($isCompDisplay || $op=="competition") && !$cat) { 
		$cat=$clubsList[$clubID]['gliderCat'][0];
	}
	
	if (!$cat) {
		// $cat=$clubsList[$clubID]['gliderCat'][0];		
	}
	
	$catLiStr="";

	if (count($clubsList[$clubID]['gliderCat']) >1 ) {
		$catLink=CONF_MODULE_ARG."&cat=0";
		$catImg="<img src='".$moduleRelPath."/img/icon_cat_0.png' border=0>";
		if ($cat==0) $current_catImg=$catImg;
		$catLiStr.="<li><a href='$catLink'>$catImg "._All_glider_types."</a></li>\n";	
	} else {
		$cat=$clubsList[$clubID]['gliderCat'][0];
	}
	
	foreach ($clubsList[$clubID]['gliderCat'] as $c_gliderCat ) {
		  $catLink=CONF_MODULE_ARG."&cat=".$c_gliderCat;
		  $catImg="<img src='".$moduleRelPath."/img/icon_cat_".$c_gliderCat.".png' border=0>";
		  if ($cat==$tmpcat) $current_catImg=$catImg;
		  
		  $catLiStr.="<li><a href='$catLink'>$catImg ".$gliderCatList[$c_gliderCat]."</a></li>\n";
		
	}		
} else {

	if (($isCompDisplay || $op=="competition") && !$cat) $cat=1;
	  
	if ( count($CONF_glider_types) > 1 ) { 
		$catLiStr="";
	
		$catLink=CONF_MODULE_ARG."&cat=0";
		$catImg="<img src='".$moduleRelPath."/img/icon_cat_0.png' border=0>";
		if ($cat==0) $current_catImg=$catImg;
		$catLiStr.="<li><a href='$catLink'>$catImg "._All_glider_types."</a></li>\n";
	
		foreach( $CONF_glider_types as $tmpcat=>$tmpcatname) {
		  $catLink=CONF_MODULE_ARG."&cat=".$tmpcat;
		  $catImg="<img src='".$moduleRelPath."/img/icon_cat_".$tmpcat.".png' border=0>";
		  if ($cat==$tmpcat) $current_catImg=$catImg;
		  
		  $catLiStr.="<li><a href='$catLink'>$catImg ".$gliderCatList[$tmpcat]."</a></li>\n";
		} 	
	}
}

 if ($cat) { 
    	$catLegend="<img src='".$moduleRelPath."/img/icon_cat_".$cat.".png' align='middle' border=0 title='"._GLIDER_TYPE.": ".$gliderCatList[$cat]."'>";
		//$gliderCatList[$cat]
  }	else {
		$allCatDisplay=1;  
		$catLegend="<img src='".$moduleRelPath."/img/icon_cat_".$cat.".png' align='middle' border=0 title='"._GLIDER_TYPE.": "._All_glider_types."'>";
  }
?>
<div id="nav2">
<ul id="nav" style="clear: none; width:auto; height:22px; border: 1px solid #d3cfe4; border-left:0; padding:0; margin:0; " >
<li class="smallItem"><a class="smallItem" href='#'><? echo $catLegend;  // echo $current_catImg?></a>
	<ul>
	<? echo $catLiStr;?>
	</ul>
</li>
</ul>
</div>
<? 
} // end of  $dontShowCatSelection  if 


if (! $dontShowCountriesSelection ) {
	list($countriesCodes,$countriesNames,$countriesFlightsNum)=getCountriesList(0,0,$clubID);
	$countriesNum=count($countriesNames);
	if ($countriesNum==1)  {
		$country=$countriesCodes[0];
		$countryLegend=$countries[$country];
	}
	if ($country) {
		$countryFlagImg="<img src='$moduleRelPath/img/flags/".strtolower($country).".gif'  title='"._MENU_COUNTRY."' align='absmiddle' style='margin-bottom:4px' border='0'>";
	} else {
		$countryFlagImg="<img src='$moduleRelPath/img/globe.gif'  title='"._MENU_COUNTRY."' align='absmiddle' border='0'>";
	}
}	
?>
<ul id="dropMenu">
<? if (! $dontShowCountriesSelection ) { ?>
	<li><a href="#"><?=$countryFlagImg?> <? echo "$countryLegend" ?> <? if ($countriesNum>1 ) echo $arrDownImg; ?></a>
		<? if ($countriesNum>1) { ?>
		<ul>				
		 <li><?  require dirname(__FILE__)."/MENU_countries_simple.php"; ?></li>
		</ul>			
		<? } ?>
	</li>
<? } ?>	
	<li><a href="#"><img src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_date.gif' title='<?=_MENU_DATE?>' align="absmiddle" border=0> <? echo "$dateLegend";?> <? echo $arrDownImg; ?></a>
		<ul>
		 <?  require dirname(__FILE__)."/MENU_dates_simple.php"; ?>
		</ul>
	</li>
</ul>
<? if ($CONF['brands']['filter_brands'] ) {  ?>
<div id="nav3">
<ul id="nav" style="clear: none; width:auto; height:22px; border: 1px solid #d3cfe4; border-left:0; padding:0; margin:0; " >
<li ><a href='#'>
<? 
	if (!$brandID) {
		echo _Select_Brand ;
		$brandImg='';
	} else { 
		$brandImg="<img src='$moduleRelPath/img/brands/".sprintf("%03d",$brandID).".gif' border=0 align='absmiddle'> ";
		echo $brandImg.'&nbsp;'.$CONF['brands']['list'][$brandID];		

		// echo $brandID;
	}
?></a>
	<ul>
  	    <?
			$brandsListFilter=brands::getBrandsList(1);
			echo "<li><a href='".CONF_MODULE_ARG."&brandID=0'>"._All_Brands."</a></li>";
  	    	foreach($brandsListFilter as $brandNameFilter=>$brandIDfilter) {
				echo "<li><a href='".CONF_MODULE_ARG."&brandID=$brandIDfilter'>$brandNameFilter</a></li>";
			}
  	    ?>

	</ul>
</li>
</ul>
</div>

<? }?>

<? if ($clubID) {  ?>
  	    <div class="menu1" ><img src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_club.gif'  align="absmiddle" border=0>
  	    <?
  	    	echo "<b>$clubName</b>";
  	    	if (!$noClubDisplay) 
  	    		echo " <a href='".CONF_MODULE_ARG."&clubID=0'><img src='$moduleRelPath/templates/".$PREFS->themeName."/img/icon_remove.gif' title='"._Display_ALL."' align='absmiddle' border=0></a>";
  	    ?>
  	    </div>
  	    <? } ?>

  	    <? if ($op!='competition' && $op!='comp'  && $op!='list_pilots' && $op!='list_takeoffs' && !$isCompDisplay  && !$allPilotsDisplay) { ?>
		<div class="menu1"><img src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_pilot.gif'  title='<?=_PILOT?>' align="absmiddle" border=0>
   	    <?
  	    	echo "<b>$pilotLegend</b>";
  	    	if (!$allPilotsDisplay) 
  	    		echo " <a href='".CONF_MODULE_ARG."&pilotID=0'><img src='$moduleRelPath/templates/".$PREFS->themeName."/img/icon_remove.gif' title='"._Display_ALL."' align='absmiddle' border=0></a>";
  	    ?>
		</div>		
  	    <? } ?>
  	    <? if ($op!='competition' && $op!='comp' && $op!='list_pilots' && $op!='list_takeoffs' && !$isCompDisplay && !$allTakeoffDisplay) { ?>
		<div class="menu1"><img src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_takeoff.gif' title='<?=_TAKEOFF_LOCATION?>' align="absmiddle" border=0>
   	    <?
  	    	echo "<b>$takeoffLegend</b>";
  	    	if (!$allTakeoffDisplay) 
  	    		echo " <a href='".CONF_MODULE_ARG."&takeoffID=0'><img src='$moduleRelPath/templates/".$PREFS->themeName."/img/icon_remove.gif' title='"._Display_ALL."' align='absmiddle' border=0></a>";
  	    ?>
		</div>
		<? } ?>  	
  	    <div class="menu1" >
		<? // display this url 	
			$thisURL=CONF_MODULE_ARG."&op=$op";
			if ($op=="comp") 
				$thisURL.="&rank=$rank&subrank=$subrank&year=$year&season=$season";
			else
				$thisURL.="&year=$year&month=$month&day=$day&season=$season&pilotID=$pilotID&takeoffID=$takeoffID&country=$country&cat=$cat&clubID=$clubID";
		?>
		<a  href='<? echo $thisURL;
		?>'><img src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_bookmark.gif' title='<?=_This_is_the_URL_of_this_page?>' align="absmiddle" border=0></a>
		</div>

</div>

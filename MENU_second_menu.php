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
// $Id: MENU_second_menu.php,v 1.46 2009/03/12 15:49:14 manolis Exp $                                                                 
//
//************************************************************************


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

	# Martin Jursa, 22.05.2007
	$showNacClubSelection=!empty($CONF_use_NAC) && empty($dontShowNacClubSelection);
	if ($showNacClubSelection) {
		$nacClubLegend=_ALL_NACCLUBS;
		if (!empty($forceNacId)) $nacid=$forceNacId; # just to make sure
		if ($nacid) {
			if ($nacclubid) {
				require_once(dirname(__FILE__)."/CL_NACclub.php");
				$nacClubLegend=NACclub::getClubName($nacid, $nacclubid);
				if ($nacClubLegend=='') {
					$nacclubid=0;
					$nacClubLegend=_ALL_NACCLUBS;
				}
			}
		}
	}
	

  if ( $op=="list_pilots" && $comp) $isCompDisplay=1;
  else $isCompDisplay=0;

$arrDownImg="<img src='".$moduleRelPath."/img/icon_arrow_down.png' border=0>"; 
$arrDownImg="<img src='".$moduleRelPath."/img/icon_arrow_left.gif' border=0>";

?>
<style type="text/css">

.secondMenuDropLayer { 
	display:none;	
	width:750px; 
	background-color:#D8CEAE;
	position:relative;
	margin:0;
	margin-left:3px;
	margin-bottom:10px;
	padding:3px;
	border:1px solid #d3cfe4;;
	
background-color: #ffb400;
background-image: url(<?=$moduleRelPath?>/img/toppanel_bg.png);

background-color:#B4C48D;
background-image: url(<?=$moduleRelPath?>/img/toppanel_bg2.png);

background-repeat: repeat-x;
background-position:top left;

}


.secondMenuDropLayer a,.secondMenuDropLayer a:link,.secondMenuDropLayer a:visited {
text-decoration:none; 
color:#031238;
line-height:130%;
padding:2px;
}

.secondMenuDropLayer a:hover {
background-color:#F8C90C;
text-decoration:underline;
}

.secondMenu {
padding-bottom:0;
margin-left:0;
margin-bottom:0px;
margin-top:8px;
}

.menuButton {
    display:block;
   	clear:none; 
	float:left;
	
	background-color: #f6f5fa;
	border: 1px solid #d3cfe4;
	padding: 3px 3px 3px 3px;
	margin-left:2px;
	margin-right:2px;
	margin-bottom:0px;
	margin-top:0px;	
}

.buttonLink {
border: 1px solid #333333;
border-top:none;
border-left:none;

display:inline;
padding:5px;
padding-bottom:2px;
padding-top:3px;

float:none;
clear:none;
}

.buttonLink , .buttonLink a, .buttonLink a:link, .buttonLink a:visited {
	background-color:#C4E379;
	background-color:#DDDC71;
}

.datesColumn {
	line-height: 1.5em;
	background:url(<?=$moduleRelPath ?>/img/toppanel_bg4.png) repeat-x top left;
}

.datesColumnHeader {
	background-color:#B6C58D;
	color:#FFFFFF;
	font-weight:bold;
	vertical-align:top;
	border-bottom:1px solid #ffffff;
}


.countryContinentLink {
display:block; clear:both;
padding:0;
padding-left:12px;
background:#ffffff no-repeat url(<?=$moduleRelPath ?>/img/icon_c1.gif);
}

.ContinentHeader { padding:3px; padding-top:4px; }

.ContinentHeader1 {	background-color:#B6C58D; }
.ContinentHeader2 {	background-color:#DABE74; }
.ContinentHeader3 {	background-color:#B0BED2; }
.ContinentHeader4 {	background-color:#BCA7A0; }
.ContinentHeader5 {	background-color:#B6C58D; }
.ContinentHeader6 {	background-color:#9791BD; }

.countryContinent { border-left:1px solid #CCCCCC;  }


.countryContinent a { display:block; clear:both; font-size:9px; }

.countryContinent1 {  background-color:#FAFAE4;  }
.countryContinent2 {  background-color:#E8ECDE; }
.countryContinent3 {  background-color:#FAFAE4; }
.countryContinent4 {  background-color:#E8ECDE; }
.countryContinent5 {  background-color:#FAFAE4; }
.countryContinent6 {  background-color:#E8ECDE; }

	
.menuButton a,.menuButton a:link,.menuButton a:visited {text-decoration:none; color:#333333;}

.menuButtonNormal {
background-color:#F6F5FA;
padding-bottom:3px;
border-bottom-style:solid;
}

.menuButtonActive {
/* yellow */
background-color:#ffb400;
/* green */
background-color:#E0E8CC;
padding-bottom:5px;
border-bottom-style:none;
}




.list_header {
	background:left top #7FAAD9  repeat-x scroll url(<?=$moduleRelPath ?>/img/list_header_c.gif);
	margin-top: 0px 0px 0px 0px;
	padding:0;
	height: 38px;
	color: white;
	display:block;
	position:relative;
	clear:both;
}

.list_header_l {
	background:left top repeat-x scroll url(<?=$moduleRelPath ?>/img/list_header_l.gif);
	float: left;
	width: 12px;
	height: 38px;
}

.list_header_r {
	background:left top  repeat-x scroll url(<?=$moduleRelPath ?>/img/list_header_r.gif);
	float: right;
	width: 12px;
	height: 38px;
}

.list_header h1 {
	float: none;
	display:block;
	position:absolute;
	top:0px;
	left:11px;
	margin:0;

	padding-top: 7px;
	padding-right: 0pt;
	padding-bottom: 0pt;
	padding-left: 10px;

	height: 16px;
	font-family: Verdana;
	color: white;
	font-size: 12px;
	font-weight: bold;
}

</style>
<script type="text/javascript" src="<?=$moduleRelPath ?>/js/jquery.livequery.js"></script>
<script language="javascript">
function changeBrand(sl) {
	// var sl=MWJ_findObj("brandSelect");
	var brandID= sl.options[sl.selectedIndex].value ;			
	var Url='<?=getLeonardoLink(array('op'=>'useCurrent','brandID'=>'%brandID%'))?>';
	Url=Url.replace('%brandID%',brandID);
	window.location=Url;
}
function changeCountry(sl) {
	var countryCode= sl.options[sl.selectedIndex].value ;			
	var Url='<?=getLeonardoLink(array('op'=>'useCurrent','country'=>'%country%'))?>';
	Url=Url.replace('%country%',countryCode);
	window.location=Url;
}


function resetFilter() {
	$("#filterResultDiv").load('<?=$moduleRelPath?>/EXT_filter_functions.php?filter_op=reset');
}


function toogleMenu(name) {
	// first hide/restore other open layers
	$(".menuButton").removeClass("menuButtonActive");
	$(".menuButton").addClass("menuButtonNormal");
	$(".secondMenuDropLayer").not("#"+name+"DropDownID").hide(200);
	
   if ( $("#"+name+"DropDownID").is(':visible') ) {	 	   
  		$("#"+name+"MenuID").removeClass("menuButtonActive");
		$("#"+name+"MenuID").addClass("menuButtonNormal");
   } else {
   		$("#"+name+"MenuID").removeClass("menuButtonNormal");
   		$("#"+name+"MenuID").addClass("menuButtonActive");
   }   
   $("#"+name+"DropDownID").slideToggle(200);

}

$(document).ready(function(){

	$(".closeButton").livequery('click', function(e) {
		// $(this).parent().parent().hide();
	});

	$(".closeLayerButton").livequery('click', function(e) {		
		$(this).parent().slideToggle(200);
		$(".menuButton").removeClass("menuButtonActive");
		$(".menuButton").addClass("menuButtonNormal");
	});


});

</script>


<div class="mainBox secondMenu" align="left">  	
  	

<? if ($op!='comp'  ) { // custom ranks ?>
<? if ($_SESSION["filter_clause"]) {  
		$filterIcon='icon_filter_active.png';
	} else {
		$filterIcon='icon_filter_down.png';
	}
?>
	<div id='filterMenuID' class="menuButton"><a href="#" onClick="toogleMenu('filter');return false;"><img src='<?=$moduleRelPath?>/img/<?=$filterIcon?>' title='' align="absmiddle" border=0><? echo $arrDownImg; ?></a>
    </div>	
<? } ?>
	
<? 

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
		$catLink=getLeonardoLink(array('op'=>'useCurrent','cat'=>'0')); 
		$catImg="<img src='".$moduleRelPath."/img/icon_cat_0.png' border=0>";
		if ($cat==0) $current_catImg=$catImg;
		$catLiStr.="<li><a href='$catLink'>$catImg "._All_glider_types."</a></li>\n";	
	} else {
		$cat=$clubsList[$clubID]['gliderCat'][0];
	}
	
	foreach ($clubsList[$clubID]['gliderCat'] as $c_gliderCat ) {
		  $catLink=getLeonardoLink(array('op'=>'useCurrent','cat'=>$c_gliderCat)); 
		  $catImg="<img src='".$moduleRelPath."/img/icon_cat_".$c_gliderCat.".png' border=0>";
		  if ($cat==$tmpcat) $current_catImg=$catImg;
		  
		  $catLiStr.="<li><a href='$catLink'>$catImg ".$gliderCatList[$c_gliderCat]."</a></li>\n";
		
	}		
} else {

	if (($isCompDisplay || $op=="competition") && !$cat) $cat=1;
	  
	if ( count($CONF_glider_types) > 1 ) { 
		$catLiStr="";
	
		$catLink=getLeonardoLink(array('op'=>'useCurrent','cat'=>'0')); 
		$catImg="<img src='".$moduleRelPath."/img/icon_cat_0.png' border=0>";
		if ($cat==0) $current_catImg=$catImg;
		$catLiStr.="<li><a href='$catLink'>$catImg "._All_glider_types."</a></li>\n";
	
		foreach( $CONF_glider_types as $tmpcat=>$tmpcatname) {
		  $catLink=getLeonardoLink(array('op'=>'useCurrent','cat'=>$tmpcat)); 		  
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
	$catLiStr="";

	$catLink=getLeonardoLink(array('op'=>'useCurrent','class'=>'0')); 
	$catLiStr.="<li><a href='$catLink'><img src='".$moduleRelPath."/img/icon_class_0.gif' border=0> All classes</a></li>\n";
		
   if ( count($CONF_category_types) > 1 ) { 
		foreach ( $CONF_category_types as $gl_id=>$gl_type) {
			$catLink=getLeonardoLink(array('op'=>'useCurrent','class'=>$gl_id)); 		  
			  $catImg="<img src='".$moduleRelPath."/img/icon_class_".$gl_id.".gif' border=0>";
			  if ($cat==$tmpcat) $current_catImg=$catImg;
		  
			  $catLiStr.="<li><a href='$catLink'>$catImg ".$gl_type."</a></li>\n";
		  
		}
	}
	
	if ($class) { 
    	$catLegend="<img src='".$moduleRelPath."/img/icon_class_".$class.".gif' align='middle' border=0 title='"._Category.": ".$CONF_category_types[$class]."'>";
		//$gliderCatList[$cat]
  }	else {		
		$catLegend="<img src='".$moduleRelPath."/img/icon_class_".$class.".gif' align='middle' border=0 title='"._Category.": "._All_glider_types."'>";
  }
  
?>
<div id="nav2">
<ul id="nav" style="clear: none; width:auto; height:22px; border: 1px solid #d3cfe4; border-left:0; padding:0; margin:0; " >
<li class="smallItem"><a  class="smallItem" href='#'><? echo $catLegend;  // echo $current_catImg?></a>
	<ul>
	<? echo $catLiStr;?>
	</ul>
</li>
</ul>
</div>

<?
$catLiStr="";

	$catLink=getLeonardoLink(array('op'=>'useCurrent','xctype'=>'0')); 
	$catLiStr.="<li><a href='$catLink'><img src='".$moduleRelPath."/img/icon_xctype_0.gif' border=0> All XC types</a></li>\n";
		
   if ( count($CONF_xc_types) > 1 ) { 
		foreach ( $CONF_xc_types as $gl_id=>$gl_type) {
			$catLink=getLeonardoLink(array('op'=>'useCurrent','xctype'=>$gl_id)); 		  
			  $catImg="<img src='".$moduleRelPath."/img/icon_xctype_".$gl_id.".gif' border=0>";			  		  
			  $catLiStr.="<li><a href='$catLink'>$catImg ".$gl_type."</a></li>\n";
		  
		}
	}
	
	if ($xctype) { 
    	$catLegend="<img src='".$moduleRelPath."/img/icon_xctype_".$xctype.".gif' align='middle' border=0 title='"._xctype.": ".$CONF_category_types[$class]."'>";
		//$gliderCatList[$cat]
  }	else {		
		$catLegend="<img src='".$moduleRelPath."/img/icon_xctype_".$xctype.".gif' align='middle' border=0 title='"._xctype.": "._All_xc_types."'>";
  }
  
?>
<div id="nav2">
<ul id="nav" style="clear: none; width:auto; height:22px; border: 1px solid #d3cfe4; border-left:0; padding:0; margin:0; " >
<li class="smallItem"><a  class="smallItem" href='#'><? echo $catLegend;  // echo $current_catImg?></a>
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
		$countryFlagImg="<img src='$moduleRelPath/img/icon_globe.gif'  title='"._MENU_COUNTRY."' align='absmiddle' border='0'>";
	}
}	

?>

<? if (! $dontShowCountriesSelection ) { ?>
    <div id='countryMenuID' class="menuButton"><a href="#" onClick="toogleMenu('country');return false;"><?=$countryFlagImg?> <? echo "$countryLegend" ?> <? if ($countriesNum>1 ) echo $arrDownImg; ?></a>
    </div>
<? } ?>	

    <div id='dateMenuID' class="menuButton"><a href="#" onClick="toogleMenu('date');return false;"><img src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_date.gif' title='<?=_MENU_DATE?>' align="absmiddle" border=0> <? echo "$dateLegend";?> <? echo $arrDownImg; ?></a>
    </div>	

<?	if ($showNacClubSelection || (count($clubsList) && $op!='comp')  ) { ?>
    <div id='clubMenuID' class="menuButton"><a href="#" onClick="toogleMenu('club');return false;">
    <img  src='<?=$moduleRelPath?>/img/icon_club.gif' align="absmiddle" border=0 title="<?=$nacClubLegend?>"><?=' '._Club.' '.$arrDownImg; ?></a>
    </div>
<? } ?>


<? if ($CONF['brands']['filter_brands'] ) {  

	if (!$brandID) {
		
		$brandImg="<img  src='$moduleRelPath/img/space.gif' height='16' width='2' align='absmiddle' border=0 title=''>";
		$brandLegend= $brandImg._Select_Brand ;
	} else { 
		$brandImg=brands::getBrandImg($brandID,'',$cat);	
		$brandLegend= $brandImg.'&nbsp;'.$CONF['brands']['list'][$brandID];		
	}
	
?>

    <div id='brandMenuID' class="menuButton">
		<div class='brandImageDiv'>
			<a href="#" onClick="toogleMenu('brand');return false;"><?=$brandLegend?> <? echo $arrDownImg; ?></a>
		</div>	
    </div>		

<? }?>

    <div id='bookmarkMenuID' class="menuButton">
			<a href="#" onClick="toogleMenu('bookmark');return false;">
			<img src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_bookmark.gif' title='<?=_This_is_the_URL_of_this_page?>' align="absmiddle" border=0>
			 <? echo $arrDownImg; ?></a>
    </div>	


</div>



<div id="bookmarkDropDownID" class="secondMenuDropLayer"  >
<div class='closeButton closeLayerButton'></div>        
<div class='content' style='padding:5px;'>
        <? // display this url 	, New way , all is taken care from getLeonardoLink()
            $thisURL=getLeonardoLink(array('op'=>'useCurrent','takeoffID'=>($takeoffID+0),
                                    'pilotID'=>$pilotID?($serverID+0).'_'.($pilotID+0):'0' ) );				
        ?>
        <a  href='<?=$thisURL?>'><img src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_bookmark.gif' title='<?=_This_is_the_URL_of_this_page?>' align="absmiddle" border=0> <?=_This_is_the_URL_of_this_page?></a>

</div>
</div>

<div id="filterDropDownID" class="secondMenuDropLayer"  >
<div class='closeButton closeLayerButton'></div>        
<div class='content' style='padding:5px;'>

	<? if ($_SESSION["filter_clause"]) {   ?>
    <img src='<?=$moduleRelPath?>/img/icon_filter.png' border=0 align="absmiddle"> <strong><?=_THE_FILTER_IS_ACTIVE?></strong>&nbsp;
    <div class='buttonLink'>		
    <a href="<?=getLeonardoLink(array('op'=>'filter') )?>"><?=_MENU_FILTER ?></a>
    </div>		&nbsp;
    <div class='buttonLink'>		
    <a href='javascript:resetFilter()'><?=_DEACTIVATE_FILTER?> </a>
    </div>	
    <?	} else { ?>
    <img src='<?=$moduleRelPath?>/img/icon_info.png' border=0> <?=_THE_FILTER_IS_INACTIVE?>&nbsp;
    <div class='buttonLink'>		
    <a href="<?=getLeonardoLink(array('op'=>'filter') )?>"><?=_MENU_FILTER ?></a>
    </div>
    <?  } ?>
    <div id='filterResultDiv'></div>

</div>
</div>


<div id="brandDropDownID" class="secondMenuDropLayer"  >
<div class='closeButton closeLayerButton'></div>        
<div class='content'>
<?
	$brandsListFilter=brands::getBrandsList(1);
	if ( count($brandsListFilter) > 10 ) {
?>

<table  cellpadding="0" cellspacing="0">
<tr>
	<td height=25 colspan=<?=$num_of_cols ?> class="main_text">
      
      <strong><?=_Select_Brand?>
      
      <?
      echo "<select name='selectBrand' id='selectBrand'  onchange='changeBrand(this)'>
						<option value=0>"._All_Brands."</option>";
				foreach($brandsListFilter as $brandNameFilter=>$brandIDfilter) {
					if ($brandIDfilter==$brandID) $sel='selected';
					else $sel='';
					echo "<option $sel value=$brandIDfilter>$brandNameFilter</option>";
				}
				echo "</select>\n";
                
                ?>
       <?=_OR?></strong>&nbsp;
    	<div class="buttonLink">
			<a style='text-align:center; text-decoration:underline;' href='<?=
					getLeonardoLink(array('op'=>'useCurrent','brandID'=>'0' ))	?>'><?=_Display_ALL?></a>
		</div>
	  
	</td>
</tr>
</table>
<?
	} else {
		echo "<ul>\n<li><a href='".$catLink=getLeonardoLink(array('op'=>'useCurrent','brandID'=>'0'))."'>"._All_Brands."</a></li>";
		foreach($brandsListFilter as $brandNameFilter=>$brandIDfilter) {
			echo "<li><a href='".
					$catLink=getLeonardoLink(array('op'=>'useCurrent','brandID'=>$brandIDfilter)).
					"'>$brandNameFilter</a></li>";
		}
		echo "</ul>\n";
	}
?>
</div>
</div>

<? 
require_once  dirname(__FILE__).'/MENU_clubs.php'; 

if ($countriesNum>1) 
	require_once  dirname(__FILE__).'/MENU_countries.php'; 

require dirname(__FILE__)."/MENU_dates.php";

require_once dirname(__FILE__).'/MENU_filter_menu.php'; 
?>

<div style='height:5px;clear:both; '></div>
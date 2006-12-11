<? if (0) { ?>
<script type="text/javascript"><!--//--><![CDATA[//><!--

sfHover = function() {
	var sfEls = document.getElementById("nav").getElementsByTagName("LI");	
	for (var i=0; i<sfEls.length; i++) {
	
		sfEls[i].onmouseover=function() {
			this.className+=" sfhover";
		}
		sfEls[i].onmouseout=function() {
			this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
		}
	}
}

// done through htc files
// if (window.attachEvent) window.attachEvent("onload", sfHover);

//--><!]]></script>
<? } ?>

<ul id="nav">

<? 

$arrDownImg="<img src='".$moduleRelPath."/img/icon_arrow_down.png' border=0>";
// http://www.htmldog.com/articles/suckerfish/dropdowns/
// http://www.htmldog.com/articles/suckerfish/dropdowns/example/

//also 
// http://www.seoconsultants.com/css/menus/horizontal/
// http://www.cssplay.co.uk/menus/final_drop.html

	 $iconLink="?name=".$module_name."&op=index_full";
	 $iconImg="<img src='".$moduleRelPath."/img/icon_home.gif' border=0>";
    // addMenuBarItem(new menuBarItem("<?=$iconImg? >", staticMenu8 ,"", true,"<?=$iconLink? >","jsdomenubaritemICONS","jsdomenubaritemoverICON","jsdomenubaritemoverICON"));
?>

<li class="smallItem"><a class="smallItem" href='#'><?=$iconImg?></a>
	<ul>
		<li><a href="?name=<?=$module_name?>&op=index_full"><?=_MENU_SUMMARY_PAGE ?></a></li>
<?	
	if (count($clubsList) >0) {
		echo "<li class='li_h1'>.:: Clubs ::.</li>\n";
		foreach( $clubsList as $clubsItem) {
			echo "<li><a href='?name=".$module_name."&op=list_flights&clubID=".$clubsItem['id']."'>".$clubsItem['desc']."</a></li>\n";
		}
	}

	if (count($apList) >0) {
		echo "<li class='li_h1'>.:: XC Leagues ::.</li>\n";
		foreach( $apList as $apName=>$apItem) {
			echo "<li><a href='?name=$module_name&ap=$apName'>".$apItem['desc']."</a></li>\n";
	    	//echo 'addMenuItem(new menuItem("'.$apItem['desc'].'","","?name='.$module_name.'&ap='.$apName.'"));';
		}
	}

	if (count($clubsList) >0 || count($apList) >0) {
		echo "<li class='li_space'></li>\n";
		echo "<li><a href='?name=$module_name&op=list_flights&clubID=0&ap=0'>"._Reset_to_default_view."</a></li>\n";
	}
?>

<? if (in_array($userID,$admin_users) ) { ?>
		<li class='li_h1'>----- <?=_MENU_ADMIN?> -----</li>
		<li><a href="?name=<?=$module_name?>&op=admin">ADMIN MENU</a></li>
		<li class='li_space'></li>
		<li><a href="?name=<?=$module_name?>&op=list_flights&sortOrder=takeoffVinicity&year=0&month=0&pilotID=0&takeoffID=0&country=0&cat=0&clubID=0">Flights with unknown takeoffs</a></li>
		<li><a href="?name=<?=$module_name?>&op=list_flights&pilotID=-1&year=0&month=0">Show test flights</a></li>
		<?  if ($DBGlvl==0)  { ?>
		<li><a href="?name=<?=$module_name?>&DBGlvl=255">Activate DEBUG</a></li>
		<? } else { ?>
		<li><a href="?name=<?=$module_name?>&DBGlvl=0">Deactivate DEBUG</a></li>
		<? } ?>
<? } ?>

	</ul>
</li>

<?
	$langLiStr="";
	foreach( $availableLanguages as $tmpLang) {	
	  $tmpLangStr=strtoupper($tmpLang{0}).substr($tmpLang,1);
	  $flagLink="?name=".$module_name."&lng=".$tmpLang;
	  $flagImg="<img src='".$moduleRelPath."/language/flag-".$tmpLang.".png' valign='middle' border=0>&nbsp;$tmpLangStr";
	  if ($currentlang==$tmpLang) {
		$current_flagImg="<img src='".$moduleRelPath."/language/flag-".$tmpLang.".png'  title='"._LANGUAGE."' valign='middle' border=0>";
	  }
	  $langLiStr.="<li><a href='$flagLink'>$flagImg</a></li>\n";
	} 
?>
<li class="smallItem short"><a class="smallItem"  href='#'><?=$current_flagImg?></a>
	<ul class="short" >
		<li class="li_h1 short_li_h1"><?=_LANGUAGE?></li>
		<? echo $langLiStr ?>
	</ul>
</li>
  

<? 
 if ( count($CONF_glider_types) > 1  && 0) { 
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
<li class="smallItem"><a class="smallItem" href='#'><?=$current_catImg?></a>
	<ul>
	<? echo $catLiStr;?>
	</ul>
</li>
<?
} // end if 
?> 


<li><a href="#"><?=_MENU_MAIN_MENU." ".$arrDownImg?></a>
	<ul>
  		<? if (is_user($user) || $userID>0)  { ?>
		<li><a href="?name=<?=$module_name?>&op=add_flight"><?=_MENU_SUBMIT_FLIGHT ?></a></li>
		<li><a href="?name=<?=$module_name?>&op=add_from_zip"><?=_MENU_SUBMIT_FROM_ZIP ?></a></li>
		<li class='li_space'></li>
		<li><a href="?name=<?=$module_name?>&op=list_flights&pilotID=<?=$userID ?>&takeoffID=0&country=0&year=0&month=0"><?=_MENU_MY_FLIGHTS ?></a></li>
		<li><a href="?name=<?=$module_name?>&op=pilot_profile&pilotIDview=<?=$userID ?>"><?=_MENU_MY_PROFILE ?></a></li>
		<li><a href="?name=<?=$module_name?>&op=pilot_profile_stats&pilotIDview=<?=$userID ?>"><?=_MENU_MY_STATS ?></a></li>
		<li class='li_space'></li>
		<? } ?>
		<li><a href="?name=<?=$module_name?>&op=user_prefs"><?=_MENU_MY_SETTINGS ?></a></li>
		<li class='li_space'></li>
		<li><a href="?name=<?=$module_name?>&op=stats"><?=_FLIGHTS_STATS ?></a></li>
		<li><a href="?name=<?=$module_name?>&op=program_info"><?=_PROJECT_INFO ?></a></li>
	</ul>
</li>

<li><a href="#"><?=_MENU_FLIGHTS." ".$arrDownImg?></a>
	<ul>
		<li><a href="?name=<?=$module_name?>&op=list_flights"><?=_MENU_FLIGHTS ?></a></li>
		<li><a href="?name=<?=$module_name?>&op=list_flights&sortOrder=dateAdded&year=0&month=0&takeoffID=0&country=0&pilotID=0"><?=_MENU_SHOW_LAST_ADDED ?></a></li>
		<li><a href="?name=<?=$module_name?>&op=filter"><?=_MENU_FILTER ?></a></li>
		<li class='li_space'></li>
		<li><a href="?name=<?=$module_name?>&op=list_flights&year=0&month=0&pilotID=0&takeoffID=0&country=0&cat=0&clubID=0"><?=_MENU_ALL_FLIGHTS ?></a></li>
	</ul>
</li>

<li><a href="#"><?=_MENU_TAKEOFFS." ".$arrDownImg ?></a>
	<ul>
		<li><a href="?name=<?=$module_name?>&op=sites"><?=_MENU_SITES_GUIDE ?></a></li>
		<li><a href="?name=<?=$module_name?>&op=list_takeoffs"><?=_MENU_TAKEOFFS ?></a></li>
	</ul>
</li>

<li><a href="#"><?=_MENU_SHOW_PILOTS." ".$arrDownImg?></a>
	<ul>
		<li><a href="?name=<?=$module_name?>&op=list_pilots&comp=0"><?=_MENU_SHOW_PILOTS ?></a></li>
		<li class='li_h1'>.:: Pilot Statistics ::.</li>
		<li><a href="?name=<?=$module_name?>&op=list_pilots&sortOrder=bestOlcScore&comp=1"><?=_MENU_OLC ?></a></li>
		<li><a href="?name=<?=$module_name?>&op=list_pilots&sortOrder=bestDistance&comp=1"><?=_MENU_OPEN_DISTANCE ?></a></li>
		<li><a href="?name=<?=$module_name?>&op=list_pilots&sortOrder=totalDuration&comp=1"><?=_MENU_DURATION ?></a></li>
		<li><a href="?name=<?=$module_name?>&op=list_pilots&sortOrder=totalFlights&comp=1"><?=_MENU_FLIGHTS ?></a></li>
	</ul>
</li>

<li><a href="#"><?=_MENU_XCLEAGUE." ".$arrDownImg?></a>
	<ul>
		<li><a href="?name=<?=$module_name?>&op=competition"><?=_MENU_COMPETITION_LEAGUE ?></a></li>
		<li class='li_space'></li>
		<li><a href="?name=<?=$module_name?>&op=competition&comp=0"><?=_MENU_OLC ?></a></li>
		<li><a href="?name=<?=$module_name?>&op=competition&comp=1"><?=_FAI_TRIANGLE ?></a></li>
		<li><a href="?name=<?=$module_name?>&op=competition&comp=2"><?=_MENU_OPEN_DISTANCE ?></a></li>
	</ul>
</li>
		
</ul>

function createjsDOMenu() {
	
  staticMenu2 = new jsDOMenu(200, "absolute");
  with (staticMenu2) {
    addMenuItem(new menuItem("<?=_MENU_COMPETITION_LEAGUE ?>", "", "?name=<?=$module_name?>&op=competition"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("<?=_MENU_OLC ?>", "", "?name=<?=$module_name?>&op=competition&comp=0"));
    addMenuItem(new menuItem("<?=_FAI_TRIANGLE ?>", "", "?name=<?=$module_name?>&op=competition&comp=1"));
    addMenuItem(new menuItem("<?=_MENU_OPEN_DISTANCE ?>", "", "?name=<?=$module_name?>&op=competition&comp=2"));
  }
    
  staticMenu9 = new jsDOMenu(200, "absolute");
  with (staticMenu9) {
    addMenuItem(new menuItem("<?=_MENU_SHOW_PILOTS ?>", "", "?name=<?=$module_name?>&op=list_pilots&comp=0"));
	addMenuItem(new menuItem(".:: Pilot Statistics ::.","","",true,"jsdomenuitemDIV","jsdomenuitemDIV"));
    addMenuItem(new menuItem("<?=_MENU_OLC ?>", "", "?name=<?=$module_name?>&op=list_pilots&sortOrder=bestOlcScore&comp=1"));
    addMenuItem(new menuItem("<?=_MENU_OPEN_DISTANCE ?>", "", "?name=<?=$module_name?>&op=list_pilots&sortOrder=bestDistance&comp=1"));
    addMenuItem(new menuItem("<?=_MENU_DURATION ?>", "", "?name=<?=$module_name?>&op=list_pilots&sortOrder=totalDuration&comp=1"));
    addMenuItem(new menuItem("<?=_MENU_FLIGHTS ?>", "", "?name=<?=$module_name?>&op=list_pilots&sortOrder=totalFlights&comp=1"));
  }
    
  staticMenu3 = new jsDOMenu(220, "absolute");
  with (staticMenu3) {
    // addMenuItem(new menuItem("<?=_MSG_MENU_CLUBS_MSG_ ?>", "", "?name=<?=$module_name?>&op=list_clubs")); 	
  <? if  (is_user($user) || $userID>0)  { ?>
    addMenuItem(new menuItem("<?=_MENU_SUBMIT_FLIGHT ?>", "", "?name=<?=$module_name?>&op=add_flight"));
    addMenuItem(new menuItem("<?=_MENU_SUBMIT_FROM_ZIP ?>", "", "?name=<?=$module_name?>&op=add_from_zip"));
	addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("<?=_MENU_MY_FLIGHTS ?>", "", "?name=<?=$module_name?>&op=list_flights&pilotID=<?=$userID ?>&takeoffID=0&country=0&year=0&month=0"));
    addMenuItem(new menuItem("<?=_MENU_MY_PROFILE ?>", "", "?name=<?=$module_name?>&op=pilot_profile&pilotIDview=<?=$userID ?>"));
    addMenuItem(new menuItem("<?=_MENU_MY_STATS ?>", "", "?name=<?=$module_name?>&op=pilot_profile_stats&pilotIDview=<?=$userID ?>"));
	addMenuItem(new menuItem("-"));
  <? } ?>
	 addMenuItem(new menuItem("<?=_MENU_MY_SETTINGS ?>", "", "?name=<?=$module_name?>&op=user_prefs"));
	 addMenuItem(new menuItem("-"));
	 addMenuItem(new menuItem("<?=_FLIGHTS_STATS ?>", "", "?name=<?=$module_name?>&op=stats"));
	 addMenuItem(new menuItem("<?=_PROJECT_INFO ?>", "", "?name=<?=$module_name?>&op=program_info"));
  }


  staticMenu4 = new jsDOMenu(220, "absolute");
  with (staticMenu4) {
    addMenuItem(new menuItem("<?=_MENU_FLIGHTS ?>", "", "?name=<?=$module_name?>&op=list_flights"));
    addMenuItem(new menuItem("<?=_MENU_SHOW_LAST_ADDED ?>", "", "?name=<?=$module_name?>&op=list_flights&sortOrder=dateAdded&year=0&month=0&takeoffID=0&country=0&pilotID=0"));
    addMenuItem(new menuItem("<?=_MENU_FILTER ?>", "", "?name=<?=$module_name?>&op=filter"));
	addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("<?=_MENU_ALL_FLIGHTS ?>", "", "?name=<?=$module_name?>&op=list_flights&year=0&month=0&pilotID=0&takeoffID=0&country=0&cat=0&clubID=0"));

  }
 
  staticMenu10 = new jsDOMenu(220, "absolute");
  with (staticMenu10) {
    addMenuItem(new menuItem("<?=_MENU_SITES_GUIDE ?>", "", "?name=<?=$module_name?>&op=sites")); 
    addMenuItem(new menuItem("<?=_MENU_TAKEOFFS ?>", "", "?name=<?=$module_name?>&op=list_takeoffs")); 
  }

 <? if (in_array($userID,$admin_users)) { ?>
 staticMenu5 = new jsDOMenu(150, "absolute");
  with (staticMenu5) {
   addMenuItem(new menuItem("ADMIN MENU", "", "?name=<?=$module_name?>&op=admin"));
   addMenuItem(new menuItem("-"));
   addMenuItem(new menuItem("Find flights with unknown takeoffs", "", "?name=<?=$module_name?>&op=list_flights&sortOrder=takeoffVinicity&year=0&month=0&pilotID=0&takeoffID=0&country=0&cat=0&clubID=0"));
   addMenuItem(new menuItem("-"));
   addMenuItem(new menuItem("Show test flights", "", "?name=<?=$module_name?>&op=list_flights&pilotID=-1&year=0&month=0"));
   addMenuItem(new menuItem("-"));
	<?  if ($DBGlvl==0)  { ?>
 	  addMenuItem(new menuItem("Activate DEBUG", "", "?name=<?=$module_name?>&DBGlvl=255"));
	<? } else { ?>
 	  addMenuItem(new menuItem("Deactivate DEBUG", "", "?name=<?=$module_name?>&DBGlvl=0"));
	<? } ?>
  }
 <? } ?>
  
  staticMenu6 = new jsDOMenu(150, "absolute");
  with (staticMenu6) {
<? 

	foreach( $availableLanguages as $tmpLang) {	
	  $tmpLangStr=strtoupper($tmpLang{0}).substr($tmpLang,1);
	  $flagLink="?name=".$module_name."&lng=".$tmpLang;
	  $flagImg="<img src='".$moduleRelPath."/language/flag-".$tmpLang.".png' border=0>&nbsp;$tmpLangStr";
	  if ($currentlang==$tmpLang) {
		$current_flagImg="<img src='".$moduleRelPath."/language/flag-".$tmpLang.".png' border=0>";
	  }
	  echo 'addMenuItem(new menuItem("'.$flagImg.'", "", "'.$flagLink.'") ) ; ';
	} 
?>
  }

<? if ( count($CONF_glider_types) > 1 ) { ?>
  staticMenu7 = new jsDOMenu(290, "absolute");
  with (staticMenu7) {
		<? 
        $catLink="?name=".$module_name."&cat=0";
		$catImg="<img src='".$moduleRelPath."/img/icon_cat_0.png' border=0>";
		if ($cat==0) { 
			$tmpStyle="jsdomenubaritemoverICON";
			$current_catImg=$catImg;
		} else $tmpStyle="jsdomenubaritemICONS";
		echo 'addMenuItem(new menuItem("'.$catImg.' '._All_glider_types.'",  "", "'.$catLink.'") ) ;';

		foreach( $CONF_glider_types as $tmpcat=>$tmpcatname) {
		  $catLink="?name=".$module_name."&cat=".$tmpcat;
		  $catImg="<img src='".$moduleRelPath."/img/icon_cat_".$tmpcat.".png' border=0>";
		  if ($cat==$tmpcat) { 
			$tmpStyle="jsdomenubaritemoverICON";
			$current_catImg=$catImg;
		  }
		  else $tmpStyle="jsdomenubaritemICONS";
		  echo 'addMenuItem(new menuItem("'.$catImg.' '.$gliderCatList[$tmpcat].'", "", "'.$catLink.'") ) ;';
		} 
		?>
  }
<? } // end if ?> 

  staticMenu8 = new jsDOMenu(300, "absolute");
  with (staticMenu8) {
    addMenuItem(new menuItem("<?=_MENU_SUMMARY_PAGE ?>", "", "?name=<?=$module_name?>&op=index_full"));
<?	
	if (count($clubsList) >0) {
    	echo 'addMenuItem(new menuItem(".:: Clubs ::.","","",true,"jsdomenuitemDIV","jsdomenuitemDIV"));';
		foreach( $clubsList as $clubsItem) {
	    	echo 'addMenuItem(new menuItem("'.$clubsItem['desc'].'","","?name='.$module_name.'&op=list_flights&clubID='.$clubsItem['id'].'"));';
		}
	}

	if (count($apList) >0) {
    	echo 'addMenuItem(new menuItem(".:: XC Leagues ::.","","",true,"jsdomenuitemDIV","jsdomenuitemDIV"));';
		foreach( $apList as $apName=>$apItem) {
	    	echo 'addMenuItem(new menuItem("'.$apItem['desc'].'","","?name='.$module_name.'&ap='.$apName.'"));';
		}
	}

	if (count($clubsList) >0 || count($apList) >0) {
		echo 'addMenuItem(new menuItem("-"));';
    	echo 'addMenuItem(new menuItem("'._Reset_to_default_view.'","","?name='.$module_name.'&op=list_flights&clubID=0&ap=0"));';
	}
?>
  }

<? 
	  $iconLink="?name=".$module_name."&op=index_full";
	  $iconImg="<img src='".$moduleRelPath."/img/icon_home.gif' border=0>";
//	  echo 'addMenuItem(new menuItem("'.$iconImg.'", "", "'.$iconLink.'") ) ; ';
?>

  staticMenu = new jsDOMenuBar("static", "staticMenuPos",false,"jsdomenubardiv",530<? 
	$addedMenuWidth=0;
	// $addedMenuWidth=count($availableLanguages)*18;
	// $addedMenuWidth+=(count($CONF_glider_types)+1)*18;
    if (in_array($userID,$admin_users)) $addedMenuWidth+=130;
	echo "+".$addedMenuWidth; 
	// echo "+230";
  ?>);
  

  with (staticMenu) {
    addMenuBarItem(new menuBarItem("<?=$iconImg?>", staticMenu8 ,"", true,"<?=$iconLink?>","jsdomenubaritemICONS","jsdomenubaritemoverICON","jsdomenubaritemoverICON"));
    addMenuBarItem(new menuBarItem("<?=$current_flagImg?>", staticMenu6,"", true,"","jsdomenubaritemICONS","jsdomenubaritemoverICON","jsdomenubaritemoverICON"));
<? if ( count($CONF_glider_types) > 1 ) { ?>
    addMenuBarItem(new menuBarItem("<?=$current_catImg?>", staticMenu7,"", true,"","jsdomenubaritemICONS","jsdomenubaritemoverICON","jsdomenubaritemoverICON"));
<? } // end if ?> 
    addMenuBarItem(new menuBarItem("<?=_MENU_MAIN_MENU?>", staticMenu3));
	addMenuBarItem(new menuBarItem("<?=_MENU_FLIGHTS?>", staticMenu4));
	addMenuBarItem(new menuBarItem("<?=_MENU_TAKEOFFS ?>", staticMenu10));
/*	addMenuBarItem(new menuBarItem("<?=_MENU_COUNTRY?>", staticMenu1)); */
    addMenuBarItem(new menuBarItem("<?=_MENU_SHOW_PILOTS?>", staticMenu9));   
    addMenuBarItem(new menuBarItem("<?=_MENU_XCLEAGUE?>", staticMenu2));   
    <? if (in_array($userID,$admin_users)) { ?>
	    addMenuBarItem(new menuBarItem("<b><?=_MENU_ADMIN?></b>", staticMenu5));   
    <? } ?>
  }
 
}
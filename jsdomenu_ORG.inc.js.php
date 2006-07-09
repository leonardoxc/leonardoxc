function createjsDOMenu() {
<? 
		$desired_items_per_page=12;
		list($countriesCodes,$countriesNames,$countriesFlightsNum)=getCountriesList();
		$countriesNum=count($countriesNames);
		$menu1_width=($countriesNum>$desired_items_per_page)?135:220;
?>  
  staticMenu1 = new jsDOMenu(<? echo $menu1_width?>, "absolute");
<?      
		echo 'staticMenu1.addMenuItem(new menuItem("<b>'._ALL_COUNTRIES.'</b>", "", "?name='.$module_name.'&country=")); ';
		
		$num_of_pages=ceil($countriesNum/$desired_items_per_page);
		//	echo "aprox num of pages: $num_of_pages [ $countriesNum ] <br>";
		$i=0;
		$ii=0;
		$pg_num=0;
		$start_letter=array();
	    $end_letter=array();
	    if (count($countriesNames)) {
			foreach($countriesNames as $countryName) {
				$firstLetter=substr($countryName,0,1);
	
				if ($i==0) $start_letter[$pg_num]="-";
				if ( $start_letter[$pg_num]=="-" && $firstLetter!=$end_letter[$pg_num-1]) $start_letter[$pg_num]=$firstLetter;
	
				if ( $i > $desired_items_per_page || $ii==($countriesNum-1) )  { // change page
					$pg_num++;
					$end_letter[$pg_num-1]=$firstLetter;
					$i=0;
				} else {
					$i++;
				}
				$ii++;
			}
		} else {

		}

	if (count($start_letter)>1) { // more than 1 page
		foreach($start_letter as $idx=>$lttr) {
			echo 'staticMenu1.addMenuItem(new menuItem("'.$start_letter[$idx].'-'.$end_letter[$idx].'", "item'.($idx+1).'", ""));';
		}

		foreach($start_letter as $idx=>$lttr) {
			echo 'staticMenu1_'.($idx+1).' = new jsDOMenu(220, "absolute");';
		}

		$i=0;
		foreach($countriesNames as $countryName) {
			$m_prefix="staticMenu1_1";

			$firstLetter=substr($countryName,0,1);
			for($k=0;$k<count($start_letter);$k++) {
				if ($firstLetter>=$start_letter[$k] && $firstLetter<=$end_letter[$k] ) {
					$m_prefix="staticMenu1_".($k+1);
					break;
				}
			}

			echo $m_prefix.'.addMenuItem(new menuItem("'.$countryName.' ('.$countriesFlightsNum[$i].')", "", "?name='.$module_name.'&country='.$countriesCodes[$i].'")); ';
			$i++;
		}

		foreach($start_letter as $idx=>$lttr) {
			echo 'staticMenu1.items.item'.($idx+1).'.setSubMenu(staticMenu1_'.($idx+1).');';
		}

  } else { 
	 if (count($countriesNames))
		foreach($countriesNames as $countryName) {
			$m_prefix="staticMenu1";
			echo 'staticMenu1.addMenuItem(new menuItem("'.$countryName.' ('.$countriesFlightsNum[$i].')", "", "?name='.$module_name.'&country='.$countriesCodes[$i].'")); ';
			$i++;
		}
  } ?>
  staticMenu2 = new jsDOMenu(200, "absolute");
  with (staticMenu2) {
    addMenuItem(new menuItem("<? echo _MENU_COMPETITION_LEAGUE ?>", "", "?name=<? echo $module_name?>&op=competition"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("<? echo _MENU_OLC ?>", "", "?name=<? echo $module_name?>&op=list_pilots&sortOrder=bestOlcScore&comp=1"));
    addMenuItem(new menuItem("<? echo _MENU_OPEN_DISTANCE ?>", "", "?name=<? echo $module_name?>&op=list_pilots&sortOrder=bestDistance&comp=1"));
    addMenuItem(new menuItem("<? echo _MENU_DURATION ?>", "", "?name=<? echo $module_name?>&op=list_pilots&sortOrder=totalDuration&comp=1"));
    addMenuItem(new menuItem("<? echo _MENU_FLIGHTS ?>", "", "?name=<? echo $module_name?>&op=list_pilots&sortOrder=totalFlights&comp=1"));
  }
    
  staticMenu3 = new jsDOMenu(220, "absolute");
  with (staticMenu3) {
    addMenuItem(new menuItem("<? echo _MENU_ALL_FLIGHTS ?>", "", "?name=<? echo $module_name?>&op=list_flights&year=0&month=0&pilotID=0&takeoffID=0&country=0&cat=0&clubID=0"));
    addMenuItem(new menuItem("<? echo _MENU_FLIGHTS ?>", "", "?name=<? echo $module_name?>&op=list_flights"));
    addMenuItem(new menuItem("<? echo _MENU_TAKEOFFS ?>", "", "?name=<? echo $module_name?>&op=list_takeoffs")); 
    // addMenuItem(new menuItem("<? echo _MSG_MENU_CLUBS_MSG_ ?>", "", "?name=<? echo $module_name?>&op=list_clubs")); 	
    addMenuItem(new menuItem("<? echo _MENU_SHOW_PILOTS ?>", "", "?name=<? echo $module_name?>&op=list_pilots&comp=0"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("<? echo _MENU_SHOW_LAST_ADDED ?>", "", "?name=<? echo $module_name?>&op=list_flights&sortOrder=dateAdded&year=0&month=0&takeoffID=0&country=0&pilotID=0"));
    addMenuItem(new menuItem("<? echo _MENU_FILTER ?>", "", "?name=<? echo $module_name?>&op=filter"));
    <? if  (is_user($user) || $userID>0)  { ?>
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("<? echo _MENU_SUBMIT_FLIGHT ?>", "", "?name=<? echo $module_name?>&op=add_flight"));
    addMenuItem(new menuItem("<? echo _MENU_SUBMIT_FROM_ZIP ?>", "", "?name=<? echo $module_name?>&op=add_from_zip"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("<? echo _MENU_MY_FLIGHTS ?>", "", "?name=<? echo $module_name?>&op=list_flights&pilotID=<? echo $userID ?>&takeoffID=0&country=0&year=0&month=0"));
    addMenuItem(new menuItem("<? echo _MENU_MY_PROFILE ?>", "", "?name=<? echo $module_name?>&op=pilot_profile&pilotIDview=<? echo $userID ?>"));
    addMenuItem(new menuItem("<? echo _MENU_MY_STATS ?>", "", "?name=<? echo $module_name?>&op=pilot_profile_stats&pilotIDview=<? echo $userID ?>"));

    <? } ?>
	 addMenuItem(new menuItem("-"));
	 addMenuItem(new menuItem("<? echo _MENU_MY_SETTINGS ?>", "", "?name=<? echo $module_name?>&op=user_prefs"));
	 addMenuItem(new menuItem("-"));
	 addMenuItem(new menuItem("<? echo _FLIGHTS_STATS ?>", "", "?name=<? echo $module_name?>&op=stats"));
	 addMenuItem(new menuItem("<? echo _PROJECT_INFO ?>", "", "?name=<? echo $module_name?>&op=program_info"));
  }
 
  staticMenu4 = new jsDOMenu(190, "absolute");
  with (staticMenu4) {
   addMenuItem(new menuItem("<? echo _SELECT_YEAR  ?>", "item1", ""));
   addMenuItem(new menuItem("<? echo _SELECT_MONTH ?>", "item2", ""));
   addMenuItem(new menuItem("-"));
   addMenuItem(new menuItem("<? echo _ALL_YEARS ?>", "", "?name=<?=$module_name?><?=$query_str?>&year=0&month=0"));
   addMenuItem(new menuItem("-"));
   addMenuItem(new menuItem("<? echo date("Y") ?>", "", "?name=<?=$module_name?><?=$query_str?>&year=<?=date("Y")?>&month=0"));
   addMenuItem(new menuItem("-"));
   <? 
	 $month_num=date("m");
	 $year_num=date("Y");
     for ($i=0;$i<6;$i++) {
	    echo 'addMenuItem(new menuItem("'.($monthList[$month_num-1]." ".$year_num).'", "", "?name='.($module_name.$query_str).'&year='.$year_num.'&month='.$month_num.'"));';
		$month_num--;
		if ($month_num==0) { $year_num--; $month_num=12; }
		$month_num=sprintf("%02s",$month_num);
	 }
   ?>

  }

  staticMenu4_1 = new jsDOMenu(120, "absolute");
  with (staticMenu4_1) {	
	 <? echo 'addMenuItem(new menuItem("<b>'._ALL_YEARS.'</b>", "", "?name='.$module_name.'&year=0"));';	  
		for($i=1998;$i<=date("Y");$i++)  
			echo 'addMenuItem(new menuItem("'.$i.'", "", "?name='.$module_name.'&year='.$i.'"));';	 
     ?>
  }
  staticMenu4.items.item1.setSubMenu(staticMenu4_1);

  staticMenu4_2 = new jsDOMenu(150, "absolute");
  with (staticMenu4_2) {
	 <? 
		echo 'addMenuItem(new menuItem("<b>'._ALL_THE_YEAR.'</b>", "", "?name='.$module_name.'&month=0"));';	  
		$i=1;
		 foreach ($monthList as $monthName)  {		 
			$k=sprintf("%02s",$i);
			echo 'addMenuItem(new menuItem("'.$monthName.'", "", "?name='.$module_name.'&month='.$k.'"));';	 
			$i++;
		 }
	   ?>
  }
  staticMenu4.items.item2.setSubMenu(staticMenu4_2);

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

  staticMenu = new jsDOMenuBar("static", "staticMenuPos",false,"jsdomenubardiv",480<? 
	$addedMenuWidth=0;
	// $addedMenuWidth=count($availableLanguages)*18;
	// $addedMenuWidth+=(count($CONF_glider_types)+1)*18;
    if (in_array($userID,$admin_users)) $addedMenuWidth+=120;
	echo "+".$addedMenuWidth; 
  ?>);
  
  staticMenu6 = new jsDOMenu(150, "absolute");
  with (staticMenu6) {
<? 

	foreach( $availableLanguages as $tmpLang) {
	  $flagLink="?name=".$module_name."&lng=".$tmpLang;
	  $flagImg="<img src='".$moduleRelPath."/language/flag-".$tmpLang.".png' border=0>&nbsp;$tmpLang";
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
    addMenuItem(new menuItem("<? echo _MENU_SUMMARY_PAGE ?>", "", "?name=<? echo $module_name?>&op=index_full"));
<?	
	if (count($clubsList) >0) {
    	echo 'addMenuItem(new menuItem(".:: Clubs ::.","","",true,"jsdomenuitemDIV"));';
		foreach( $clubsList as $clubsItem) {
	    	echo 'addMenuItem(new menuItem("'.$clubsItem['desc'].'","","?name='.$module_name.'&op=list_flights&clubID='.$clubsItem['id'].'"));';
		}
	}

	if (count($apList) >0) {
    	echo 'addMenuItem(new menuItem(".:: XC Leagues ::.","","",true,"jsdomenuitemDIV"));';
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
  

  with (staticMenu) {
    addMenuBarItem(new menuBarItem("<?=$iconImg?>", staticMenu8 ,"", true,"<?=$iconLink?>","jsdomenubaritemICONS","jsdomenubaritemoverICON","jsdomenubaritemoverICON"));
    addMenuBarItem(new menuBarItem("<?=$current_flagImg?>", staticMenu6,"", true,"","jsdomenubaritemICONS","jsdomenubaritemoverICON","jsdomenubaritemoverICON"));
<? if ( count($CONF_glider_types) > 1 ) { ?>
    addMenuBarItem(new menuBarItem("<?=$current_catImg?>", staticMenu7,"", true,"","jsdomenubaritemICONS","jsdomenubaritemoverICON","jsdomenubaritemoverICON"));
<? } // end if ?> 
    addMenuBarItem(new menuBarItem("<?=_MENU_MAIN_MENU?>", staticMenu3));
	addMenuBarItem(new menuBarItem("<?=_MENU_DATE?>", staticMenu4));	
	addMenuBarItem(new menuBarItem("<?=_MENU_COUNTRY?>", staticMenu1));
    addMenuBarItem(new menuBarItem("<?=_MENU_XCLEAGUE?>", staticMenu2));   
    <? if (in_array($userID,$admin_users)) { ?>
	    addMenuBarItem(new menuBarItem("<b><?=_MENU_ADMIN?></b>", staticMenu5));   
    <? } ?>
  }
 
}
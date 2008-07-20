<? 
/*
the doctype should be  (quirks mode )
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" >

not (standards mode)
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

*/


if ( $CONF_use_htc_ie_hack ) {  // may not work when server IP is in private network behind firewall ?>
<!--[if IE ]>
<style type = "text/css">
	#vnav li, #nav li , #dropMenu li , table.listTable tr {
	   behavior: url('<? echo $moduleRelPath?>/hover.htc');
	}
</style>
<![endif]-->
<? } else { ?>
<script type="text/javascript"><!--//--><![CDATA[//><!--
sfHover = function() {
	var sfEls = document.getElementById("nav").getElementsByTagName("LI");	
	for (var i=0; i<sfEls.length; i++) {
		sfEls[i].onmouseover=function() { this.className+=" sfhover";}
		sfEls[i].onmouseout=function()  { this.className=this.className.replace(new RegExp(" sfhover\\b"), ""); }
	}
	
	var sfMenu=document.getElementById("dropMenu");
	if (sfMenu) {
		var sfEls = sfMenu.getElementsByTagName("LI");	
		for (var i=0; i<sfEls.length; i++) {
			sfEls[i].onmouseover=function() { this.className+=" sfhover";}
			sfEls[i].onmouseout=function()  { this.className=this.className.replace(new RegExp(" sfhover\\b"), ""); }
		}
	}
	
	var sfMenu=document.getElementById("nav2");
	if (sfMenu) {
		var sfEls = sfMenu.getElementsByTagName("LI");	
		for (var i=0; i<sfEls.length; i++) {
			sfEls[i].onmouseover=function() { this.className+=" sfhover";}
			sfEls[i].onmouseout=function()  { this.className=this.className.replace(new RegExp(" sfhover\\b"), ""); }
		}
	}

	var sfMenu=document.getElementById("nav3");
	if (sfMenu) {
		var sfEls = sfMenu.getElementsByTagName("LI");	
		for (var i=0; i<sfEls.length; i++) {
			sfEls[i].onmouseover=function() { this.className+=" sfhover";}
			sfEls[i].onmouseout=function()  { this.className=this.className.replace(new RegExp(" sfhover\\b"), ""); }
		}
	}


}



 // done through htc files
 if (window.attachEvent) window.attachEvent("onload", sfHover);

//--><!]]></script>
<? } ?>



<ul id="nav">

<? 

$arrDownImg="<img src='".$moduleRelPath."/img/icon_arrow_down.png' border=0>";
$arrDownImg="<img src='".$moduleRelPath."/img/icon_arrow_left.gif' width='9' height='7' alt='select' border='0' \>";
// http://www.htmldog.com/articles/suckerfish/dropdowns/
// http://www.htmldog.com/articles/suckerfish/dropdowns/example/

//also 
// http://www.seoconsultants.com/css/menus/horizontal/
// http://www.cssplay.co.uk/menus/final_drop.html

	 $iconLink="".CONF_MODULE_ARG."&op=index_full";
	 $iconImg="<img src='".$moduleRelPath."/img/icon_home.gif' width='16' height='14' alt='home' border='0' \>";
    // addMenuBarItem(new menuBarItem("<?=$iconImg? >", staticMenu8 ,"", true,"<?=$iconLink? >","jsdomenubaritemICONS","jsdomenubaritemoverICON","jsdomenubaritemoverICON"));
?>

<li class="smallItem long"><a class="smallItem" href='#'><?=$iconImg?></a>
	<ul class="long">

<? if ( auth::isAdmin($userID) )  {  ?>
		<li><a href='#'><STRONG><?=_MENU_ADMIN." ".$arrDownImg ?></STRONG></a>
			<ul>
				<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=admin">ADMIN MENU</a></li>
				<? if ( auth::isAdmin($userID) && $opMode==3 )  {  ?>
				<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=users&page=admin">User Administration</a></li>
				<? } ?>
				<li class='li_space long'></li>
				<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=list_flights&sortOrder=takeoffVinicity&year=0&month=0&pilotID=0&takeoffID=0&country=0&cat=0&clubID=0">Flights with unknown takeoffs</a></li>
				<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=list_flights&pilotID=-1&year=0&month=0">Show test flights</a></li>
				<li class='li_space long'></li>
				<? if ($CONF_isMasterServer && 0) { ?>
					<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=servers_manage">Manage Leonardo Servers</a></li>
					<li><a href="<?=$moduleRelPath?>/site/sync"  target="_blank">See the Sync logs</a></li>
				<? } ?>
				<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=admin_languages">Administer Language Translations</a></li>
				<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=admin_airspace">Administer Airspace checking</a></li>
				<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=admin_takeoff_resolve">Administer Duplicate Takeoffs</a></li>				
				<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=admin_takeoffs">Administer the Takeoffs</a></li>
				<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=admin_logs">Display server's SyncLog</a></li>
				<li class='li_space long'></li>
				<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=admin_stats">Usage Statistics</a></li>
				<? if (0) { ?><li><a href="<?="".CONF_MODULE_ARG."" ?>&op=admin_areas">Administer the Areas</a></li><? } ?>

				<li class='li_space long'></li>
				<?  if ($includeMask==0)  { ?>
				<li><a href="<?="".CONF_MODULE_ARG."" ?>&includeMask=255">See Excluded flights</a></li>
				<? } else { ?>
				<li><a href="<?="".CONF_MODULE_ARG."" ?>&includeMask=0">Hide Excluded flights</a></li>
				<? } ?>

				<li class='li_space long'></li>
				<?  if ($DBGlvl==0)  { ?>
				<li><a href="<?="".CONF_MODULE_ARG."" ?>&DBGlvl=255">Activate DEBUG</a></li>
				<? } else { ?>
				<li><a href="<?="".CONF_MODULE_ARG."" ?>&DBGlvl=0">Deactivate DEBUG</a></li>
				<? } ?>
			</ul>
		</li>
		<? if ($CONF_isMasterServer) { ?>
		<li><a href='#'><STRONG>XCnet <?=_MENU_ADMIN." ".$arrDownImg ?></STRONG></a>
			<ul>
					<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=servers_manage">Manage Leonardo Servers</a></li>
					<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=admin_pilot_map">External Pilot Mapping</a></li>
					<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=admin_duplicates">Resolve Duplicate Flights</a></li>
					<li><a href="<?=$moduleRelPath?>/site/sync"  target="_blank">Sync logs of Slave-Servers</a></li>
			</ul>
		</li>
		<? } ?>

<? } ?>

		<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=index_full"><?=_MENU_SUMMARY_PAGE ?></a></li>
		<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=rss_conf"><img src='<?=$moduleRelPath?>/img/rss.gif'  align="absmiddle" border=0> RSS Feed</a></li>
<?	
	insertMenuItems('home','bottom'); 
	
	if (count($clubsList) >0) {
		echo "<li class='li_h1 long_li_h1'>.:: "._Clubs_Leagues." ::.</li>\n";
		foreach( $clubsList as $clubsItem) {
			if ( $clubsItem['id'] == $clubID ) $a_class="class='boldFont'";
			else $a_class="";
			echo "<li $a_class><a $a_class href='".CONF_MODULE_ARG."&op=list_flights&clubID=".$clubsItem['id']."'>".$clubsItem['desc']."</a></li>\n";
			if (  $clubsItem['id'] == $clubID && 
					(  ( $clubID  && (auth::isClubAdmin($userID,$clubID) )  || auth::isAdmin($userID))  	)	 
			    )  {  ?>
				<li style='background-color:#FF9933'><a href="<?="".CONF_MODULE_ARG."" ?>&op=club_admin&club_to_admin_id=<?=$clubID?>"><img 
				src="<?=$moduleRelPath?>/img/icon_arrow_up.png" border=0 align="absmiddle" /> Administer this Club</a></li>		
			<? } 
		}
	}

	if (count($apList) >0) {
		echo "<li class='li_h1 long_li_h1'>.:: XC Leagues ::.</li>\n";
		foreach( $apList as $apName=>$apItem) {
			echo "<li><a href='".CONF_MODULE_ARG."&ap=$apName'>".$apItem['desc']."</a></li>\n";
	    	//echo 'addMenuItem(new menuItem("'.$apItem['desc'].'","",CONF_MODULE_ARG.'&ap='.$apName.'"));';
		}
	}

	if (count($clubsList) >0 || count($apList) >0) {
		echo "<li class='li_space long'></li>\n";
		echo "<li><a href='".CONF_MODULE_ARG."&op=list_flights&clubID=0&ap=0'>"._Reset_to_default_view."</a></li>\n";
	}
?>
	</ul>
</li>

<?
	$langLiStr="";
	foreach( $availableLanguages as $tmpLang) {	
	  $tmpLangStr=strtoupper($tmpLang{0}).substr($tmpLang,1);
	  $flagLink="".CONF_MODULE_ARG."&lng=".$tmpLang;
 	  if ($opMode==1) $flagLink.="&newlang=".$tmpLang;
	  $flagImg="<img src='".$moduleRelPath."/language/flag-".$tmpLang.".png' width='18' height='12' valign='middle' border='0' />&nbsp;$tmpLangStr";
	  if ($currentlang==$tmpLang) {
		$current_flagImg="<img src='".$moduleRelPath."/language/flag-".$tmpLang.".png'  title='"._LANGUAGE."'  alt='"._LANGUAGE."' width='18' height='12' valign='middle' border='0' \>";
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
  
<li><a href="#"><?=_MENU_MAIN_MENU." ".$arrDownImg?></a>
	<ul>
		<? if ( $CONF_use_own_template ) { // we must put register/login menut items ?>
			<? 	if ( $userID <=0 ) { 
					if ($CONF_use_own_login) $login_url=str_replace("%module_name%",$module_name,$CONF['bridge']['login_url']);
					else $login_url="login.php?redirect=modules.php&name=$module_name";

					$register_url=str_replace("%module_name%",$module_name,$CONF['bridge']['register_url']);

			?>
			<li><a href="<?=$login_url?>"><img src='<?=$moduleRelPath?>/img/icon_login.gif' valign='middle' border=0> <?=_MENU_LOGIN ?></a></li>			
			<li><a href="<?=$register_url?>"><img src='<?=$moduleRelPath?>/img/icon_register.gif' valign='middle' border=0> <?=_MENU_REGISTER ?></a></li>
			<? } else { // user alredy logged in  
					if ($CONF_use_own_login) $logout_url=str_replace("%module_name%",$module_name,$CONF['bridge']['logout_url']);					
					else $logout_url="login.php?logout=true";
			?>
					<li><a href="<?=$logout_url?>"><img src='<?=$moduleRelPath?>/img/icon_login.gif' valign='middle' border=0> <?=_MENU_LOGOUT ?></a></li>			
			
			<? } ?>
			<li class='li_space'></li>
		<? } ?>
  		<? if (is_user($user) || $userID>0)  { ?>
		<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=add_flight"><?=_MENU_SUBMIT_FLIGHT ?></a></li>
		<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=add_from_zip"><?=_MENU_SUBMIT_FROM_ZIP ?></a></li>
		<li class='li_space'></li>
		<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=list_flights&pilotID=0_<?=$userID ?>&takeoffID=0&country=0&year=0&month=0"><?=_MENU_MY_FLIGHTS ?></a></li>
		<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=pilot_profile&pilotIDview=0_<?=$userID ?>"><?=_MENU_MY_PROFILE ?></a></li>
		<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=pilot_profile_stats&pilotIDview=0_<?=$userID ?>"><?=_MENU_MY_STATS ?></a></li>
        <? if ( auth::isAdmin($userID) )  {  ?>
   		<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=pilot_flights&pilotIDview=0_<?=$userID ?>"><img src='<?=$moduleRelPath?>/img/icon_new.png'  title=''  alt='' width='25' height='12' valign='middle' border='0' style='display:inline' />&nbsp;<?=_MENU_MY_FLIGHTS ?></a></li>
        <? } ?>
		<li class='li_space'></li>
		<? } ?>
		<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=user_prefs"><?=_MENU_MY_SETTINGS ?></a></li>
		<li class='li_space'></li>
		<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=stats"><?=_FLIGHTS_STATS ?></a></li>
		<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=program_info"><?=_PROJECT_INFO ?></a></li>
		<? insertMenuItems('main_menu','bottom'); ?>
	</ul>
</li>

<li><a href="#"><?=_MENU_FLIGHTS." ".$arrDownImg?></a>
	<ul>
		<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=list_flights"><?=_MENU_FLIGHTS ?></a></li>
		<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=list_flights&sortOrder=dateAdded&year=0&month=0&takeoffID=0&country=0&pilotID=0"><?=_MENU_SHOW_LAST_ADDED ?></a></li>
		<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=filter"><?=_MENU_FILTER ?></a></li>
		<li class='li_space'></li>
		<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=list_flights&year=0&month=0&pilotID=0&takeoffID=0&country=0&cat=0&clubID=0&brandID=0&nacclubid=0&nacid=0"><?=_MENU_ALL_FLIGHTS ?></a></li>
	</ul>
</li>

<li><a href="#"><?=_MENU_TAKEOFFS." ".$arrDownImg ?></a>
	<ul>
		<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=sites"><?=_MENU_SITES_GUIDE ?></a></li>
		<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=list_takeoffs"><?=_MENU_TAKEOFFS ?></a></li>
	</ul>
</li>

<li><a href="#"><?=_MENU_SHOW_PILOTS." ".$arrDownImg?></a>
	<ul>
		<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=list_pilots&comp=0"><?=_MENU_SHOW_PILOTS ?></a></li>
		<li class='li_h1'>.:: Pilot Statistics ::.</li>
		<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=list_pilots&sortOrder=bestOlcScore&comp=1"><?=_MENU_OLC ?></a></li>
		<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=list_pilots&sortOrder=bestDistance&comp=1"><?=_MENU_OPEN_DISTANCE ?></a></li>
		<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=list_pilots&sortOrder=totalDuration&comp=1"><?=_MENU_DURATION ?></a></li>
		<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=list_pilots&sortOrder=totalFlights&comp=1"><?=_MENU_FLIGHTS ?></a></li>
	</ul>
</li>

<li class="long lastItem"><a href="#"><?=_MENU_XCLEAGUE." ".$arrDownImg?></a>
	<ul class="long">
		<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=competition&clubID=0"><?=_MENU_XCLEAGUE ?></a></li>
		<? if (0) { ?>
			<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=competition"><?=_MENU_COMPETITION_LEAGUE ?></a></li>
			<li class='li_space long'></li>
			<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=competition&comp=0"><?=_MENU_OLC ?></a></li>
			<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=competition&comp=1"><?=_FAI_TRIANGLE ?></a></li>
			<li><a href="<?="".CONF_MODULE_ARG."" ?>&op=competition&comp=2"><?=_MENU_OPEN_DISTANCE ?></a></li>
		<? }?>
		<? 
			if ( count($ranksList) ) {
				echo "<li class='li_h1 long_li_h1'>.:: "._National_Rankings." ::.</li>";
				foreach($ranksList as $rankID=>$rankArray) {
					$rname=$rankArray['name'];
					if ($rankArray['localLanguage']==$lng) $rname=$rankArray['localName'];
					
					if  ($rankArray['menuYear']) {
						if ($rankArray['datesMenu']=='years' ) 
							$yearToForceStr="&year=".$rankArray['menuYear']."&month=0&season=0";
						else
							$yearToForceStr="&season=".$rankArray['menuYear'];

					}	else $yearToForceStr="";

					# Loop modified by Martin Jursa 24.05.2007 to obtain the first subrank-id from the array keys of the subranks-array					
					$subrankkeys=array_keys($rankArray['subranks']);
					$firstSubrank=$subrankkeys[0];
					// $firstSubrank=$rankArray['subranks'][0]['id'];
					echo "<li><a href='".CONF_MODULE_ARG."&op=comp&clubID=0&rank=$rankID&subrank=$firstSubrank$yearToForceStr'>".$rname."</a></li>";
				
				}			
			}
		?>
	<?
	if (count($clubsList) >0) {
		echo "<li class='li_h1 long_li_h1'>.:: "._Clubs_Leagues." ::.</li>\n";
		foreach( $clubsList as $clubsItem) {
			if ( $clubsItem['id'] == $clubID ) $a_class="class='boldFont'";
			else $a_class="";
			echo "<li $a_class><a $a_class href='".CONF_MODULE_ARG."&op=competition&clubID=".$clubsItem['id']."'>".$clubsItem['desc']."</a></li>\n";
		}
	}

	if (count($apList) >0) {
		echo "<li class='li_h1 long_li_h1'>.:: XC Leagues ::.</li>\n";
		foreach( $apList as $apName=>$apItem) {
			echo "<li><a href='".CONF_MODULE_ARG."&ap=$apName'>".$apItem['desc']."</a></li>\n";
	    	//echo 'addMenuItem(new menuItem("'.$apItem['desc'].'","",CONF_MODULE_ARG.'&ap='.$apName.'"));';
		}
	}

?>
	</ul>
</li>
		
</ul>


<?

function insertMenuItems($top_menu_item,$position) {
	global $CONF_MENU;
	include_once dirname(__FILE__).'/site/config_menu.php';

	if ($CONF_MENU[$top_menu_item][$position])
		foreach($CONF_MENU[$top_menu_item][$position] as $menuEntry) {
			if ($menuEntry['type']=='spacer') {
				echo "<li class='li_space ".$menuEntry['extra_class']."'></li>";
				continue;
			}

			echo '<li>';
			if ($menuEntry['linkType']=='leonardo') $hrefStr=CONF_MODULE_ARG."&".$menuEntry['link'];
			else $hrefStr=$menuEntry['link'];

			if ( $menuEntry['target'] ) 
				$targetStr=" target='".$menuEntry['target']."' ";
			else 
				$targetStr='';

			echo "<a href='$hrefStr' $targetStr>".$menuEntry['name']."</a>";
			echo '</li>';
		}

}

?>
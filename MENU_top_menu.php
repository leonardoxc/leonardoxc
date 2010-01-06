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
// $Id: MENU_top_menu.php,v 1.76 2010/01/06 21:27:17 manolis Exp $                                                                 
//
//************************************************************************

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

<?  if ($PREFS->showNews && $CONF['news']['config']['newsActive'] ) {?>
<ul id="ticker01"></ul> 
<? } ?>
<script type="text/javascript" src="<?=$moduleRelPath ?>/js/jquery.livequery.js"></script>
<script type="text/javascript" src="<?=$moduleRelPath ?>/js/jqModal.js"></script>
<script type="text/javascript"><!--//--><![CDATA[//><!--

$('#dialogWindow').jqm({modal:true,toTop: true});

function showClubDetails(clubID) {
	$('#dialogWindow').jqm({ajax: '<?=$moduleRelPath ?>/GUI_EXT_club_info.php?clubid='+clubID,
		ajaxText: '<img src=\'<?=$moduleRelPath ?>/img/ajax-loader.gif\'>'  });
	$('#dialogWindow').jqmShow();
}

function showNewsItem(itemID) {
	$('#dialogWindow').jqm({ajax: '<?=$moduleRelPath ?>/data/news/'+itemID+'/index.html',
		ajaxText: '<img src=\'<?=$moduleRelPath ?>/img/ajax-loader.gif\'>'  });
	$('#dialogWindow').jqmShow();
}

function showNewsSettings() {
	$('#dialogWindow').jqm({ajax: '<?=$moduleRelPath ?>/GUI_EXT_settings.php',
		ajaxText: '<img src=\'<?=$moduleRelPath ?>/img/ajax-loader.gif\'>' });
	$('#dialogWindow').jqmShow(); 	
}

function showUserSettings() {
	$('#dialogWindow').jqm({ajax: '<?=$moduleRelPath ?>/GUI_EXT_settings.php',
		ajaxText: '<img src=\'<?=$moduleRelPath ?>/img/ajax-loader.gif\'>' });
	$('#dialogWindow').jqmShow(); 	
}

<?  if ($PREFS->showNews && $CONF['news']['config']['newsActive']) {?>
$(function() { 
	$("#ticker01").liScroll({travelocity: 0.05,url: '<?=$moduleRelPath ?>/EXT_news.php' }); 
})

/*
$(".ticksettings").livequery('click', function(e) {
	$('#dialogWindow').jqm({ajax: '<?=$moduleRelPath ?>/GUI_EXT_settings.php' });
	$('#dialogWindow').jqmShow();
});
*/
<? } ?>
	  
//--><!]]></script>



<ul id="nav">

<? 

$arrDownImg="<img src='".$moduleRelPath."/img/icon_arrow_down.png' border=0>";
$arrDownImg="<img src='".$moduleRelPath."/img/icon_arrow_left.gif' width='9' height='7' alt='select' border='0' \>";
// http://www.htmldog.com/articles/suckerfish/dropdowns/
// http://www.htmldog.com/articles/suckerfish/dropdowns/example/

//also 
// http://www.seoconsultants.com/css/menus/horizontal/
// http://www.cssplay.co.uk/menus/final_drop.html

	 $iconLink=getLeonardoLink(array('op'=>'index_full'));
	 $iconImg="<img src='".$moduleRelPath."/img/icon_home.gif' width='16' height='14' alt='home' border='0' \>";
    // addMenuBarItem(new menuBarItem("<?=$iconImg? >", staticMenu8 ,"", true,"<?=$iconLink? >","jsdomenubaritemICONS","jsdomenubaritemoverICON","jsdomenubaritemoverICON"));
?>

<li class="smallItem long"><a class="smallItem" href='#'><?=$iconImg?></a>
	<ul class="long">

<? if ( L_auth::isAdmin($userID) )  {  ?>
		<li><a href='#'><STRONG><?=_MENU_ADMIN." ".$arrDownImg ?></STRONG></a>
			<ul>
				<li><a href="<?=getLeonardoLink(array('op'=>'admin')) ?>">ADMIN MENU</a></li>
				<? if ( L_auth::isAdmin($userID) && $opMode==3 )  {  ?>
				<li><a href="<?=getLeonardoLink(array('op'=>'users')) ?>">User Administration</a></li>
				<? } ?>
                <li class='li_space long'></li>
                <li><a href="<?=getLeonardoLink(array('op'=>'brands','page'=>'admin')) ?>">Brand Administration</a></li>               
				<li class='li_space long'></li>
				<li><a href="<?=getLeonardoLink(array('op'=>'list_flights',
				'sortOrder'=>'takeoffVinicity','year'=>'0','month'=>'0','pilotID'=>'0',
				'takeoffID'=>'0','country'=>'0','cat'=>'0>',
				'clubID'=>'0'))?>">Flights with unknown takeoffs</a></li>
				<li><a href="<?=getLeonardoLink(array('op'=>'list_flights','pilotID'=>'-1','year'=>'0','month'=>'0')) ?>">Show test flights</a></li>
				<li class='li_space long'></li>
   				<li><a href="<?=getLeonardoLink(array('op'=>'export_flights')) ?>">Export IGC Tracklogs</a></li>
				<li class='li_space long'></li>
				<? if ($CONF_isMasterServer && 0) { ?>
					<li><a href="<?=getLeonardoLink(array('op'=>'list_flights','pilotID'=>'-1','year'=>'0','month'=>'0')) ?>&op=servers_manage">Manage Leonardo Servers</a></li>
					<li><a href="<?=$moduleRelPath?>/site/sync"  target="_blank">See the Sync logs</a></li>
				<? } ?>
				<li><a href="<?=getLeonardoLink(array('op'=>'admin_languages')) ?>">Administer Language Translations</a></li>
				<li><a href="<?=getLeonardoLink(array('op'=>'admin_airspace')) ?>">Administer Airspace checking</a></li>
				<li><a href="<?=getLeonardoLink(array('op'=>'admin_takeoff_resolve')) ?>">Administer Duplicate Takeoffs</a></li>				
				<li><a href="<?=getLeonardoLink(array('op'=>'area_admin')) ?>">Administer Takeoff Areas</a></li>
				<li><a href="<?=getLeonardoLink(array('op'=>'admin_sites')) ?>">Administer Takeoffs</a></li>
				<li><a href="<?=getLeonardoLink(array('op'=>'admin_takeoffs')) ?>">See the Takeoff Log</a></li>
				<li><a href="<?=getLeonardoLink(array('op'=>'admin_logs')) ?>">Display server's SyncLog</a></li>
				<li class='li_space long'></li>
				<li><a href="<?=getLeonardoLink(array('op'=>'admin_stats')) ?>">Usage Statistics</a></li>
				<? if (0) { ?><li><a href="<?=getLeonardoLink(array('op'=>'admin_areas')) ?>">Administer the Areas</a></li><? } ?>

				<li class='li_space long'></li>
				<?  if ($includeMask==0)  { ?>
				<li><a href="<?=getLeonardoLink(array('includeMask='=>'255')) ?>">See Excluded flights</a></li>
				<? } else { ?>
				<li><a href="<?=getLeonardoLink(array('includeMask='=>'0')) ?>">Hide Excluded flights</a></li>
				<? } ?>

				<li class='li_space long'></li>
				<?  if ($DBGlvl==0)  { ?>
				<li><a href="<?=getLeonardoLink(array('DBGlvl'=>'255')) ?>">Activate DEBUG</a></li>
				<? } else { ?>
				<li><a href="<?=getLeonardoLink(array('DBGlvl'=>'0')) ?>">Deactivate DEBUG</a></li>
				<? } ?>
			</ul>
		</li>
		<li><a href='#'><STRONG>Configuration <?=$arrDownImg ?></STRONG></a>
			<ul>
				<li><a href="<?=getLeonardoLink(array('op'=>'conf_htaccess')) ?>">SEO Urls</a></li>
			</ul>
		</li>
		<? if ($CONF_isMasterServer) { ?>
		<li><a href='#'><STRONG>XCnet <?=_MENU_ADMIN." ".$arrDownImg ?></STRONG></a>
			<ul>
					<li><a href="<?=getLeonardoLink(array('op'=>'servers_manage')) ?>">Manage Leonardo Servers</a></li>
					<li><a href="<?=getLeonardoLink(array('op'=>'admin_pilot_map')) ?>">External Pilot Mapping</a></li>
					<li><a href="<?=getLeonardoLink(array('op'=>'admin_duplicates')) ?>">Resolve Duplicate Flights</a></li>
					<li><a href="<?=$moduleRelPath?>/site/sync"  target="_blank">Sync logs of Slave-Servers</a></li>
			</ul>
		</li>
		<? } ?>

<? } ?>

		<li><a href="<?=getLeonardoLink(array('op'=>'index_full')) ?>"><?=_MENU_SUMMARY_PAGE ?></a></li>
		<li><a href="<?=getLeonardoLink(array('op'=>'rss_conf')) ?>"><img src='<?=$moduleRelPath?>/img/rss.gif'  align="absmiddle" border=0> RSS Feed</a></li>
<?	
	insertMenuItems('home','bottom'); 
	
	if (count($clubsList) >0) {
		echo "<li class='li_h1 long_li_h1'>.:: "._Clubs_Leagues." ::.</li>\n";
		foreach( $clubsList as $clubsItem) {
			if ( $clubsItem['id'] == $clubID ) $a_class="class='boldFont'";
			else $a_class="";
			echo "<li $a_class><a $a_class href='".getLeonardoLink(array('op'=>'list_flights','clubID'=>$clubsItem['id'],'nacclubid'=>'0','nacid'=>'0'))."'>".$clubsItem['desc']."</a></li>\n";
			if (  $clubsItem['id'] == $clubID && 
					(  ( $clubID  && (L_auth::isClubAdmin($userID,$clubID) )  || L_auth::isAdmin($userID))  	)	 
			    )  {  ?>
				<li style='background-color:#FF9933'><a href="<?=getLeonardoLink(array('op'=>'club_admin','club_to_admin_id'=>$clubID )) ?>"><img 
				src="<?=$moduleRelPath?>/img/icon_arrow_up.png" border=0 align="absmiddle" /> Administer this Club</a></li>		
			<? } 
		}
	}

	if (count($apList) >0) {
		echo "<li class='li_h1 long_li_h1'>.:: XC Leagues ::.</li>\n";
		foreach( $apList as $apName=>$apItem) {
			echo "<li><a href='".getLeonardoLink(array('ap'=>apName ))."'>".$apItem['desc']."</a></li>\n";	
		}
	}

	if (count($clubsList) >0 || count($apList) >0) {
		echo "<li class='li_space long'></li>\n";
		echo "<li><a href='".getLeonardoLink(array('op'=>list_flights,'clubID'=>'0','ap'=>'0' ))."'>"._Reset_to_default_view."</a></li>\n";
	}
?>
	</ul>
</li>

<?
	$langLiStr="";
	foreach( $availableLanguages as $tmpLang) {	
	  $tmpLangStr=strtoupper($tmpLang{0}).substr($tmpLang,1);
	  $flagLink=getLeonardoLink(array('op'=>'useCurrent','lng'=>$tmpLang ));
	  
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
					if ($CONF_use_own_login) {
						if ( is_array($CONF['bridge']['login_url']) )
							$login_url=getLeonardoLink($CONF['bridge']['login_url']);
						else 
							$login_url=str_replace("%module_name%",$module_name,$CONF['bridge']['login_url']);
					} else {
						$login_url="login.php?redirect=modules.php&name=$module_name";
					}	

					if ( is_array($CONF['bridge']['register_url']) )
						$register_url=getLeonardoLink($CONF['bridge']['register_url']);
					else 
						$register_url=str_replace("%module_name%",$module_name,$CONF['bridge']['register_url']);

			?>
			<li><a href="<?=$login_url?>"><img src='<?=$moduleRelPath?>/img/icon_login.gif' valign='middle' border=0> <?=_MENU_LOGIN ?></a></li>			
			<li><a href="<?=$register_url?>"><img src='<?=$moduleRelPath?>/img/icon_register.gif' valign='middle' border=0> <?=_MENU_REGISTER ?></a></li>
            
			<? } else { // user alredy logged in  
					if ($CONF_use_own_login) {
						if ( is_array($CONF['bridge']['logout_url']) )
							$logout_url=getLeonardoLink($CONF['bridge']['logout_url']);
						else 
							$logout_url=str_replace("%module_name%",$module_name,$CONF['bridge']['logout_url']);
						if ($opMode==6) {					
							$logout_url.='&sid='.$user->data['session_id'];
						}	
					} else $logout_url="login.php?logout=true";
			?>
					<li><a href="<?=$logout_url?>"><img src='<?=$moduleRelPath?>/img/icon_login.gif' valign='middle' border=0> <?=_MENU_LOGOUT ?></a></li>			
			
			<? } ?>
			<li class='li_space'></li>
		<? } ?>
  		<? if (is_user($user) || $userID>0)  { ?>
		<li><a href="<?=getLeonardoLink(array('op'=>'add_flight')) ?>"><?=_MENU_SUBMIT_FLIGHT ?></a></li>
		<li><a href="<?=getLeonardoLink(array('op'=>'add_from_zip')) ?>"><?=_MENU_SUBMIT_FROM_ZIP ?></a></li>
		<li class='li_space'></li>
		<li><a href="<?=getLeonardoLink(array('op'=>'list_flights','pilotID'=>'0_'.$userID,'takeoffID'=>'0','country'=>'0','year'=>'0','month'=>'0','season'=>'0')) ?>"><?=_MENU_MY_FLIGHTS ?></a></li>
		<li><a href="<?=getLeonardoLink(array('op'=>'pilot_profile','pilotIDview'=>'0_'.$userID)) ?>"><?=_MENU_MY_PROFILE ?></a></li>
        
  		<? if ($opMode==3 && 0 ){ // not used . the changes  can now be done from the profile ?>
        <li><a href="<?=getLeonardoLink(array('op'=>'change_password')) ?>"><?=_MENU_CHANGE_PASSWORD?></a></li>
        <li><a href="<?=getLeonardoLink(array('op'=>'change_email')) ?>"><?=_MENU_CHANGE_EMAIL?></a></li>       
        <? } ?>
        
		<li><a href="<?=getLeonardoLink(array('op'=>'pilot_profile_stats','pilotIDview'=>'0_'.$userID)) ?>"><?=_MENU_MY_STATS ?></a></li>
        <? if ( L_auth::isAdmin($userID) && 0 )  {  ?>
   		<li><a href="<?=getLeonardoLink(array('op'=>'pilot_flights','pilotIDview'=>'0_'.$userID)) ?>"><img src='<?=$moduleRelPath?>/img/icon_new.png'  title=''  alt='' width='25' height='12' valign='middle' border='0' style='display:inline' />&nbsp;<?=_MENU_MY_FLIGHTS ?></a></li>
        <? } ?>
		<li class='li_space'></li>
		<? } ?>
		
		<li><a href="#" onclick="showUserSettings()"><?=_MENU_MY_SETTINGS ?></a></li>
		<?php  if (0) {?><li><a href="<?=getLeonardoLink(array('op'=>'user_prefs')) ?>"><?=_MENU_MY_SETTINGS ?></a></li><?php }?>
		<li class='li_space'></li>
		<li><a href="<?=getLeonardoLink(array('op'=>'stats')) ?>"><?=_FLIGHTS_STATS ?></a></li>
		<li><a href="<?=getLeonardoLink(array('op'=>'program_info')) ?>"><?=_PROJECT_INFO ?></a></li>
		<? insertMenuItems('main_menu','bottom'); ?>
	</ul>
</li>

<li><a href="#"><?=_MENU_FLIGHTS." ".$arrDownImg?></a>
	<ul>
		<li><a href="<?=getLeonardoLink(array('op'=>'list_flights') )?>"><?=_MENU_FLIGHTS ?></a></li>
		<li><a href="<?=getLeonardoLink(array('op'=>'list_flights','sortOrder'=>'dateAdded','takeoffID'=>'0','country'=>'0','year'=>'0','month'=>'0','season'=>'0','pilotID'=>'0')) ?>"><?=_MENU_SHOW_LAST_ADDED ?></a></li>
		<li><a href="<?=getLeonardoLink(array('op'=>'filter') )?>"><?=_MENU_FILTER ?></a></li>
		<li class='li_space'></li>
		<li><a href="<?=getLeonardoLink(array('op'=>'list_flights',
						'year'=>'0','month'=>'0','pilotID'=>'0','takeoffID'=>'0',
						'xctype'=>'all','class'=>'all',
						'country'=>'0','cat'=>'0','clubID'=>'0','brandID'=>'0','nacclubid'=>'0','nacid'=>'0') )?>"><?=_MENU_ALL_FLIGHTS ?></a></li>
	</ul>
</li>

<li><a href="#"><?=_MENU_TAKEOFFS." ".$arrDownImg ?></a>
	<ul>
		<li><a href="<?=getLeonardoLink(array('op'=>'sites') )?>"><?=_MENU_SITES_GUIDE ?></a></li>
		<li><a href="<?=getLeonardoLink(array('op'=>'list_areas') )?>"><?=_MENU_AREA_GUIDE?></a></li>
		<li><a href="<?=getLeonardoLink(array('op'=>'list_takeoffs') )?>"><?=_MENU_TAKEOFFS ?></a></li>
	</ul>
</li>

<li><a href="#"><?=_MENU_SHOW_PILOTS." ".$arrDownImg?></a>
	<ul>
		<li><a href="<?=getLeonardoLink(array('op'=>'list_pilots','comp'=>0) )?>"><?=_MENU_SHOW_PILOTS ?></a></li>
   		<li><a href="<?=getLeonardoLink(array('op'=>'pilot_search') )?>"><?=_MENU_SEARCH_PILOTS ?></a></li>
		<li class='li_h1'>.:: <?=_Pilot_Statistics?> ::.</li>
		<li><a href="<?=getLeonardoLink(array('op'=>'list_pilots','comp'=>1,'sortOrder'=>'bestOlcScore') )?>"><?=_MENU_OLC ?></a></li>
		<li><a href="<?=getLeonardoLink(array('op'=>'list_pilots','comp'=>1,'sortOrder'=>'bestDistance') )?>"><?=_MENU_OPEN_DISTANCE ?></a></li>
		<li><a href="<?=getLeonardoLink(array('op'=>'list_pilots','comp'=>1,'sortOrder'=>'totalDuration') )?>"><?=_MENU_DURATION ?></a></li>
		<li><a href="<?=getLeonardoLink(array('op'=>'list_pilots','comp'=>1,'sortOrder'=>'totalFlights') )?>"><?=_MENU_FLIGHTS ?></a></li>
	</ul>
</li>

<li class="long lastItem"><a href="#"><?=_MENU_XCLEAGUE." ".$arrDownImg?></a>
	<ul class="long">
		<li><a href="<?=getLeonardoLink(array('op'=>'competition') )?>"><?=_MENU_XCLEAGUE ?></a></li>
		<? 
			if ( count($ranksList) ) {
				echo "<li class='li_h1 long_li_h1'>.:: "._National_Rankings." ::.</li>";
				foreach($ranksList as $rankID=>$rankArray) {
					$rname=$rankArray['name'];
					if ($rankArray['localLanguage']==$lng) $rname=$rankArray['localName'];
					
					$rankArgArray=array();
					if  ($rankArray['menuYear']) {
						if ($rankArray['datesMenu']=='years' ) {
							$rankArgArray['year']=$rankArray['menuYear'];
							$rankArgArray['month']='0';
							$rankArgArray['season']='0';
							// $yearToForceStr="&year=".$rankArray['menuYear']."&month=0&season=0";
						}else {
							$rankArgArray['year']=$rankArray['menuYear'];
							$rankArgArray['month']='0';
							$rankArgArray['season']=$rankArray['menuYear'];						
							//$yearToForceStr="&season=".$rankArray['menuYear'];
						}
					}	else {
						// no action 
						// $yearToForceStr="";
					}
					# Loop modified by Martin Jursa 24.05.2007 to obtain the first subrank-id from the array keys of the subranks-array					
					$subrankkeys=array_keys($rankArray['subranks']);
					$firstSubrank=$subrankkeys[0];
					// $firstSubrank=$rankArray['subranks'][0]['id'];
					
					echo "<li><a href='".getLeonardoLink(
						array('op'=>'comp','clubID'=>'0',	'rank'=>$rankID,'subrank'=>$firstSubrank)+
						$rankArgArray ). "'>".$rname."</a></li>";
				
				}			
			}
		?>
	<?
	if (count($clubsList) >0 && 0) {
		echo "<li class='li_h1 long_li_h1'>.:: "._Clubs_Leagues." ::.</li>\n";
		foreach( $clubsList as $clubsItem) {
			if ( $clubsItem['id'] == $clubID ) $a_class="class='boldFont'";
			else $a_class="";
			echo "<li $a_class><a $a_class href='".getLeonardoLink(array('op'=>'competition','clubID'=>$clubsItem['id'],'nacclubid'=>'0','nacid'=>'0'))."'>".$clubsItem['desc']."</a></li>\n";
		}
	}

	if (count($apList) >0) {
		echo "<li class='li_h1 long_li_h1'>.:: XC Leagues ::.</li>\n";
		foreach( $apList as $apName=>$apItem) {
			echo "<li><a href='".getLeonardoLink(array('ap'=>$apName))."'>".$apItem['desc']."</a></li>\n";
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
			if ($menuEntry['linkType']=='leonardo') $hrefStr=getLeonardoLink($menuEntry['link']);
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
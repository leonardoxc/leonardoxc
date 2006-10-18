<?
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://leonardo.thenet.gr                                            */
/* http://sourceforge.net/projects/leonardoserver                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/
if ( file_exists(dirname(__FILE__)."/install.php") ) {
	echo "Please remove install.php from dir modules/leonardo in order to run Leonardo<br>";
	exit;
}

$pageStart=getmicrotime();

@session_start();

$module_name = basename(dirname(__FILE__));				

//$moduleAbsPath=dirname(__FILE__);
$moduleRelPath="modules/".$module_name;

require_once $moduleRelPath."/config.php";
setVarFromRequest("lng",$PREFS->language); 
$currentlang=$lng;
require_once("mainfile.php");

if (!eregi("modules.php", $_SERVER['PHP_SELF']) && ($opMode==1 || $opMode==2) ) {
    die ("You can't access this file directly...");
}

$pagetitle = _PAGE_TITLE;

require_once $moduleRelPath."/language/lang-".$currentlang.".php";
require_once $moduleRelPath."/language/countries-".$currentlang.".php";
require_once $moduleRelPath."/FN_UTM.php";
require_once $moduleRelPath."/FN_functions.php";	
require_once $moduleRelPath."/FN_waypoint.php";	
require_once $moduleRelPath."/FN_pilot.php";	
require_once $moduleRelPath."/FN_flight.php";	
require_once $moduleRelPath."/FN_output.php";
require_once $moduleRelPath."/CL_flightData.php";
require_once $moduleRelPath."/templates/".$PREFS->themeName."/theme.php";

if ($opMode==1 ) { // phpnuke 
	$user = $_REQUEST['user'];
	if ( is_user($user)) {
		cookiedecode($user);
		$userID=$cookie[0];
		$userName=$cookie[1];
	}
} else if ($opMode==2 ) { // phpBB 
	$userID=$userdata['user_id'];
	$userName=$userdata['username'];
} else if ($opMode==3 ) { // standalone
	$user = $_REQUEST['user'];
	if ( is_user($user)) {
		cookiedecode($user);
		$userID=$cookie[0];
		$userName=$cookie[1];
	}
}

// DEBUG
setVarFromRequest("DBGcat","");
setVarFromRequest("DBGlvl",0);

setVarFromRequest("waypointIDview",0);
setVarFromRequest("flightID",0);
setVarFromRequest("pilotIDview",0);
setVarFromRequest("year",date("Y")); 
setVarFromRequest("month",0); // date("m") for current month
setVarFromRequest("pilotID",0);
setVarFromRequest("takeoffID",0);
setVarFromRequest("country",$PREFS->viewCountry);
setVarFromRequest("op",$CONF_main_page);
setVarFromRequest("cat",$PREFS->viewCat);
setVarFromRequest("subcat","pg");
setVarFromRequest("comp",0);
setVarFromRequest("clubID",0);

if ($op=="main") $op=$CONF_main_page;
if ($op=="show_flight" && $flightID==0) $op=$CONF_main_page;

if ($opMode==3) 
	require_once $moduleRelPath."/GUI_header.php";

if ($opMode==1) include("header.php");

?>

<link href="<?=$moduleRelPath."/templates/".$PREFS->themeName."/style.css"; ?>" rel="stylesheet" type="text/css">

<?
if ($opMode==1) OpenTable();

$Theme =new Theme();
require_once $moduleRelPath."/BLOCKS_start.php";



$noClubDisplay=1;
if ($clubID) { 
   require_once  dirname(__FILE__)."/CL_club.php";
   //$currentClub=new club($clubID);
   //$clubName=$currentClub->getAttribute("name");			
   $clubName=$clubsList[$clubID]['desc'];
   $noClubDisplay=0;
} else {			
	$clubName=_No_Club;
}

require_once $moduleRelPath."/MENU_menu.php";
?>
<script type="text/javascript" src="<?=$moduleRelPath?>/DHTML_functions.js"></script>
<script type="text/javascript" src="<?=$moduleRelPath?>/supernote.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$moduleRelPath?>/supernote.css" />

<script language="javascript">

var supernote = new SuperNote('supernote',  { hideDelay: 100 });

// Available config options are:
//allowNesting: true/false    // Whether to allow triggers within triggers.
//cssProp: 'visibility'       // CSS property used to show/hide notes and values.
//cssVis: 'inherit'
//cssHid: 'hidden'
//IESelectBoxFix: true/false  // Enables the IFRAME select-box-covering fix.
//showDelay: 0                // Millisecond delays.
//hideDelay: 500
//animInSpeed: 0.1            // Animation speeds, from 0.0 to 1.0; 1.0 disables.
//animOutSpeed: 0.1

// You can pass several to your "new SuperNote()" command like so:
//{ name: value, name2: value2, name3: value3 }
</script>

<?
if (in_array($op,array("list_flights","list_pilots","list_takeoffs","competition"))) {
  require_once dirname(__FILE__)."/MENU_dates.php";
  require_once dirname(__FILE__)."/MENU_countries.php";
  
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
    	$catLegend="<img src='".$moduleRelPath."/img/icon_cat_".$cat.".png' border=0 title='"._GLIDER_TYPE.": ".$gliderCatList[$cat]."'>";
		//$gliderCatList[$cat]
  }	else {
		$allCatDisplay=1;  
		$catLegend="<img src='".$moduleRelPath."/img/icon_cat_".$cat.".png' border=0 title='"._GLIDER_TYPE.": "._All_glider_types."'>";
  }

  
  
  	   openBox("","100%","#f5f5f5");
  	   ?>
  	   <div align="center">  	
		<? if ($_SESSION["filter_clause"]) {  ?>
   	    <div class="menu1" ><a href="?name=<?=$module_name?>&op=filter"><img 
		src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_filter.gif' align="absmiddle" border=0 title="<?=_THE_FILTER_IS_ACTIVE?>"></a>
		</div>
		<? } ?>
   	    <div class="menu1" >
  	    <?
  	    	echo "<b>$catLegend</b>";
  	    	//if (!$allCatDisplay) 
  	    	//	echo "<a href='?name=$module_name&cat=0'><img src='modules/leonardo/templates/$PREFS->themeName/img/icon_remove.gif' title='"._Display_ALL."'  border=0></a>";
  	    ?>
  	    </div>
		<? if ($clubID) {  ?>
  	    <div class="menu1" ><img src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_club.gif'  align="absmiddle" border=0>
  	    <?
  	    	echo "<b>$clubName</b>";
  	    	if (!$noClubDisplay) 
  	    		echo " <a href='?name=$module_name&clubID=0'><img src='$moduleRelPath/templates/".$PREFS->themeName."/img/icon_remove.gif' title='"._Display_ALL."' align='absmiddle' border=0></a>";
  	    ?>
  	    </div>
  	    <? } ?>
  	    
  	    <div class="menu1" >
			<a href="#selDate" class="supernote-hover-selDate note_link">
			<img src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_date.gif' title='<?=_MENU_DATE?>' align="absmiddle" border=0>
  	    	<?
  	    		echo "<b>$dateLegend</b></a>";
  	    		if (!$allTimesDisplay) 
  	    			echo " <a href='?name=$module_name&year=0&month=0'><img src='$moduleRelPath/templates/".$PREFS->themeName."/img/icon_remove.gif' title='"._Display_ALL."' align='absmiddle' border=0></a>";
  	  		?>
  	    </div>
  	    
  	    <div class="menu1">
			<a href="#selCountry" class="supernote-hover-selCountry note_link">
			<img src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_country.gif'  title='<?=_MENU_COUNTRY?>' align="absmiddle" border=0>
   	    <?
  	    	echo "<b>$countryLegend</b></a>";
  	    	if (!$allCountriesDisplay) 
  	    		echo " <a href='?name=$module_name&country=0'><img src='$moduleRelPath/templates/".$PREFS->themeName."/img/icon_remove.gif' title='"._Display_ALL."' align='absmiddle' border=0></a>";
  	    ?>
		</div>
  	    <? if ($op!='competition' && $op!='list_pilots' && $op!='list_takeoffs' && !$isCompDisplay ) { ?>
		<div class="menu1"><img src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_pilot.gif'  title='<?=_PILOT?>' align="absmiddle" border=0>
   	    <?
  	    	echo "<b>$pilotLegend</b>";
  	    	if (!$allPilotsDisplay) 
  	    		echo " <a href='?name=$module_name&pilotID=0'><img src='$moduleRelPath/templates/".$PREFS->themeName."/img/icon_remove.gif' title='"._Display_ALL."' align='absmiddle' border=0></a>";
  	    ?>
		</div>		
  	    <? } ?>
  	    <? if ($op!='competition' && $op!='list_pilots' && $op!='list_takeoffs' && !$isCompDisplay) { ?>
		<div class="menu1"><img src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_takeoff.gif' title='<?=_TAKEOFF_LOCATION?>' align="absmiddle" border=0>
   	    <?
  	    	echo "<b>$takeoffLegend</b>";
  	    	if (!$allTakeoffDisplay) 
  	    		echo " <a href='?name=$module_name&takeoffID=0'><img src='$moduleRelPath/templates/".$PREFS->themeName."/img/icon_remove.gif' title='"._Display_ALL."' align='absmiddle' border=0></a>";
  	    ?>
		</div>
		<? } ?>  	    
		<div class="menuLvl2"><a href='<?
		echo "?name=$module_name&op=$op&year=$year&month=$month&pilotID=$pilotID&takeoffID=$takeoffID&country=$country&cat=$cat&clubID=$clubID";
		?>'><img src='<?=$moduleRelPath?>/templates/<?=$PREFS->themeName?>/img/icon_bookmark.gif' title='<?=_This_is_the_URL_of_this_page?>' align="absmiddle" border=0></a>
		</div>
  	   <?   
  	    closeBox();  	    
}

//---------------------------------------------
// MAIN SWITCH
//---------------------------------------------

if ($op=="users") { 
	if ($opMode==3) require $moduleRelPath."/USERS_index.php";
} else if ($op=="login") { 
	if ($opMode==2) require $moduleRelPath."/GUI_login.php";
} else if ($op=="index_full") { 
	require $moduleRelPath."/GUI_index_full.php";
// Clubs - areas admin
//--------------------------
} else if ($op=="club_admin") { 
	require $moduleRelPath."/GUI_club_admin.php";
} else if ($op=="area_admin") { 
	require $moduleRelPath."/GUI_area_admin.php";
// Listing output
//--------------------------
} else if ($op=="list_clubs") { 
	require $moduleRelPath."/GUI_list_clubs.php";
} else if ($op=="list_flights") { 
	require $moduleRelPath."/GUI_list_flights.php";
} else if ($op=="list_pilots" ) {  
	require $moduleRelPath."/GUI_list_pilots.php";
} else if ($op=="competition") {
    require $moduleRelPath."/GUI_list_comp.php";
} else if ($op=="list_takeoffs") {
	require $moduleRelPath."/GUI_list_takeoffs.php";	
} else if ($op=="sites") {
	require $moduleRelPath."/GUI_sites.php";	
//--------------------------
// "Flight" related actions
//--------------------------
} else if ($op=="show_flight" ) {  
    require $moduleRelPath."/GUI_flight_show.php";		
} else if ($op=="add_flight") {
	if ($userID>0) require $moduleRelPath."/GUI_flight_add.php";
	else echo "<center><br>You are not logged in. <br><br>Please login<BR><BR></center>";
} else if ($op=="add_from_zip") {
	require $moduleRelPath."/GUI_flight_add_from_zip.php";		
} else if ($op=="delete_flight") {
	require $moduleRelPath."/GUI_flight_delete.php";
} else if ($op=="edit_flight") {
	require $moduleRelPath."/GUI_flight_edit.php";	
}  else if ($op=="addTestFlightFromURL") {
	addTestFlightFromURL(urldecode ($_REQUEST[flightURL]) );
//--------------------------
// "Waypoints" related actions
//--------------------------
} else if ($op=="show_waypoint") {
	require $moduleRelPath."/GUI_waypoint_show.php";	
} else if ($op=="add_waypoint") {
    require $moduleRelPath."/GUI_waypoint_add.php";
} else if ($op=="edit_waypoint") {
    require $moduleRelPath."/GUI_waypoint_edit.php";
//--------------------------
// "Pilots" related actions
//--------------------------
} else if ($op=="pilot_profile") {
	if ($userID>0 || $CONF_showProfilesToGuests ) require $moduleRelPath."/GUI_pilot_profile.php";
	else echo "<center><br>You are not logged in. <br><br>Please login<BR><BR></center>";			
} else if ($op=="pilot_profile_edit") {
	require $moduleRelPath."/GUI_pilot_profile_edit.php";
} else if ($op=="pilot_olc_profile_edit") {
	require $moduleRelPath."/GUI_pilot_olc_profile_edit.php";
} else if ($op=="pilot_profile_stats") {
	require $moduleRelPath."/GUI_pilot_profile_stats.php";
} else if ($op=="user_prefs") { 
	require $moduleRelPath."/GUI_user_prefs.php";
//--------------------------
// OLC related actions
//--------------------------
} else if ($op=="olc_submit") {
	require $moduleRelPath."/FN_olc.php";
	open_inner_table("OLC",600);
	open_tr();
		echo "<div align=center>";
		olcSubmit($flightID); // $flightID
		echo "<br><BR>";
		echo "<a href='?name=$module_name&op=show_flight&flightID=".$flightID."'>"._RETURN_TO_FLIGHT."</a>";
		echo "<br><BR></div>";
    close_inner_table();  
} else if ($op=="olc_remove") {
	require $moduleRelPath."/FN_olc.php";	
	open_inner_table("OLC",600);
	open_tr();
		echo "<div align=center>";
		olcRemove($flightID);
		echo "<br><BR>";
		echo "<a href='?name=$module_name&op=show_flight&flightID=".$flightID."'>"._RETURN_TO_FLIGHT."</a>";
		echo "<br><BR>";
		echo "<br><BR></div>";
    close_inner_table();  
//--------------------------
// Misc related actions
//--------------------------
} else if ($op=="admin") {
	require $moduleRelPath."/GUI_admin.php";
} else if ($op=="reg_stats") {
	require $moduleRelPath."/registration_stats.php";
    $noFooterMenu=1;
} else if ($op=="filter") {
  require $moduleRelPath."/GUI_filter.php";
} else if ($op=="stats") {
  require $moduleRelPath."/GUI_stats.php";
} else if ($op=="program_info") {
  require $moduleRelPath."/GUI_program_info.php";
} 
	
exitPage(0);

// END OF OUTPUT to the browser

function exitPage($exitNow=1){
   global $module_name,$opMode,$noFooterMenu,$moduleRelPath,$PREFS;
   global $sqlQueriesDebug,$sqlFetchTime;
   global $pageStart;
   /*
   $sqlQueriesTime=0;
   $i=0;
   foreach ($sqlQueriesDebug as $tm) {
      $sqlQueriesTime+=$tm;
	  $i++;
   }
   echo "<hr> total sql query time: $sqlQueriesTime secs in $i queries <hr>";
   
   
   $sqlQueriesTime=0;
   $i=0;
   foreach ($sqlFetchTime as $tm) {
      $sqlQueriesTime+=$tm;
	  $i++;
   }
   echo "<hr> total sql fetch time: $sqlQueriesTime secs in $i fetches <hr>";
*/

   echo "<br>";
   if (!$noFooterMenu ) {
	 echo "<br><div class='main_text' align=center><a href='#top_of_page'>"._RETURN_TO_TOP."</a></div>";
   }
   echo "</div>";  

   require_once $moduleRelPath."/BLOCKS_end.php";
   if ($opMode==1) {   
		CloseTable();
		include("footer.php");
   }

	if ($opMode==3) 
		require_once $moduleRelPath."/GUI_footer.php";

   $pageEnd=getmicrotime();
   $pageTime=$pageEnd-$pageStart;
   echo "PAGE CREATION: $pageTime secs<BR>";
	
   if ($exitNow) exit;
}

?>
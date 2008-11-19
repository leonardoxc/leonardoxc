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

function leo_getmicrotime() {
   list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}

$pageStart=leo_getmicrotime();

@session_start();

$module_name = basename(dirname(__FILE__));				

//$moduleAbsPath=dirname(__FILE__);
// $moduleRelPath="modules/$module_name";

// ugly joomla 1.5 hack
@include dirname(__FILE__)."/site/predefined/5/globals_include.php";

require_once dirname(__FILE__)."/config.php";

// ugly joomla 1.5 hack
@include dirname(__FILE__)."/site/predefined/5/globals_include.php";


setVarFromRequest("lng",$PREFS->language); 
if ( strlen($lng)==2) { 
	$lng=array_search($lng,$lang2iso);
	if (!$lng) $lng=$PREFS->language;
}
$currentlang=$lng;

if ( !eregi($CONF_mainfile, $_SERVER['PHP_SELF'])  ) {
    die ("You can't access this file directly...");
}

if ($CONF_use_utf) define('CONF_LANG_ENCODING_TYPE','utf8');
else  define('CONF_LANG_ENCODING_TYPE','iso');


require_once dirname(__FILE__)."/language/".CONF_LANG_ENCODING_TYPE."/lang-".$currentlang.".php";
require_once dirname(__FILE__)."/language/".CONF_LANG_ENCODING_TYPE."/countries-".$currentlang.".php";
require_once dirname(__FILE__)."/FN_UTM.php";
require_once dirname(__FILE__)."/FN_functions.php";	
require_once dirname(__FILE__)."/FN_waypoint.php";	
require_once dirname(__FILE__)."/FN_brands.php";

require_once dirname(__FILE__)."/FN_pilot.php";	
require_once dirname(__FILE__)."/FN_flight.php";	
require_once dirname(__FILE__)."/FN_output.php";
require_once dirname(__FILE__)."/CL_flightData.php";
require_once dirname(__FILE__)."/CL_dates.php";
require_once dirname(__FILE__)."/CL_brands.php";
require_once dirname(__FILE__)."/CL_statsLogger.php";
require_once dirname(__FILE__)."/templates/".$PREFS->themeName."/theme.php";

 // if we use utf
if ($CONF_use_utf) {
		$db->sql_query("SET NAMES utf8");
}

$pagetitle = _PAGE_TITLE;

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
	$userID=$userdata['user_id'];
	$userName=$userdata['username'];
} else if ($opMode==4 ) { // discuz
	$userID=$userdata['user_id'];
	$userName=$userdata['username'];
} else if ($opMode==5 ) { // joomla
	$userID=$userdata['user_id'];
	$userName=$userdata['username'];
} else if ($opMode==6 ) { // phpbb3

	if ($user->data['user_type'] == 2) {
		$userID=0;
		$userName='guest';	
	} else {
		$userID=$user->data['user_id'];
		$userName=$user->data['username'];
	}	
}

$_SESSION['userID']=$userID;

if ($_GET['leoSeo']) {
	// inject some $_GET values
	$seoParamsOrg=split(',',$_GET['leoSeo']);
	foreach($seoParamsOrg as $seoParam) {
		$t1=split(':',$seoParam);
		$seoParams[$t1[0]]=$t1[1];
	}
	
	if (isset($seoParams['cat'])) {	
		$_REQUEST['cat']=$seoParams['cat'];
	}

	if (isset($seoParams['brand'])) {
		$_REQUEST['brandID']=$seoParams['brand'];
		if ($_REQUEST['brandID']=='all') $_REQUEST['brandID']=0;
	}
	
	if (isset($seoParams['takeoff'])) {
		$_REQUEST['takeoffID']=$seoParams['takeoff'];
		if ($_REQUEST['takeoffID']=='all') $_REQUEST['takeoffID']=0;
	}
	
	if (isset($seoParams['class'])) {
		$_REQUEST['class']=$seoParams['class'];
		if ($_REQUEST['class']=='all') $_REQUEST['class']=0;
	}
	
	if (isset($seoParams['xctype'])) {
		$_REQUEST['xctype']=$seoParams['xctype'];
		if ($_REQUEST['xctype']=='all') $_REQUEST['xctype']=0;
	}
	
	if (isset($seoParams['pilot'])) {
		$_REQUEST['pilotID']=$seoParams['pilot'];
		if ($_REQUEST['pilotID']=='all') $_REQUEST['pilotID']=0;
	}
	
	if (isset($seoParams['club'])) {
		if (strpos($seoParams['club'],'.')) {
			$tmpNac=split('\.',$seoParams['club']);			
			$_REQUEST['nacid']=$tmpNac[0];
			$_REQUEST['nacclubid']=$tmpNac[1];
			$_REQUEST['clubID']=0;
		} else {
			$_REQUEST['clubID']=$seoParams['club'];
			if ($_REQUEST['clubID']=='all') $_REQUEST['clubID']=0;
			$_REQUEST['nacid']=0;
			$_REQUEST['nacclubid']=0;
		}	
	}
}

// DEBUG
setVarFromRequest("DBGcat","");
setVarFromRequest("DBGlvl",0,1);

setVarFromRequest("includeMask",0);

setVarFromRequest("waypointIDview",0,1);
setVarFromRequest("flightID",0,1);
setVarFromRequest("pilotIDview",0,0);
setVarFromRequest("year",date("Y"),1); 
setVarFromRequest("month",0,1); // date("m") for current month
setVarFromRequest("day",0,1); // only used for flights_list

// SEASON MOD
setVarFromRequest("season",0,1); // only used for flights_list
setVarFromRequest("subseason",0,0); // can be text
if ($season) {
	setVar("year",0);
	setVar("month",0);
	setVar("day",0);
}

setVarFromRequest("l_date",-1);
if ($l_date=='alltimes'){
	setVar("year",0);
	setVar("month",0);
	setVar("day",0);
	setVar("season",0);
}else if ($l_date>=0) {
	if ( preg_match('/^(\d{4})\.(\d{2})\.(\d{2})$/',$l_date,$matches) ) {
		setVar("year",$matches[1]);
		setVar("month",$matches[2]);
		setVar("day",$matches[3]);				
		setVar("season",0);
	} else if ( preg_match('/^(\d{4})\.(\d{2})$/',$l_date,$matches) ) {
		setVar("year",$matches[1]);
		setVar("month",$matches[2]);
		setVar("day",0);				
		setVar("season",0);
	}else if ( preg_match('/^(\d{4})$/',$l_date,$matches) ) {
		setVar("year",$matches[1]);		
		setVar("month",0);
		setVar("day",0);				
		setVar("season",0);		
	} else if ( preg_match('/^season(\d{4})$/',$l_date,$matches) ) {
		setVar("year",0);
		setVar("month",0);
		setVar("day",0);				
		setVar("season",$matches[1]);
	}



}

/*
echo 'REQUEST_URI:'.$_SERVER['REQUEST_URI'];
echo 'QUERY_STRING:'.$_SERVER['QUERY_STRING'];
print_r($_REQUEST);
*/

// BRANDS MOD
setVarFromRequest("brandID",0,1); // numeric
if (! brands::isValidBrandForFilter($brandID) ) setVar("brandID",0);
setVarFromRequest("pilotID",0,0);
setVarFromRequest("takeoffID",0,1);
setVarFromRequest("country",$PREFS->viewCountry);
if ($country=='world') setVar('country',0);

setVarFromRequest("op",$CONF_main_page);
setVarFromRequest("cat",$PREFS->viewCat,1);
setVarFromRequest("class",0,1);
setVarFromRequest("xctype",0,1);
setVarFromRequest("subcat","pg");
setVarFromRequest("comp",0,1);
setVarFromRequest("rank",0,1);
setVarFromRequest("subrank",0,1);
setVarFromRequest("clubID",0,1);
/// Martin Jursa 17.05.2007 : values for nacclub filtering added
setVarFromRequest("nacclubid", 0, 1);
setVarFromRequest("nacid", 0, 1);

$serverID=0;
if ( count($pilotPartsArray=split('_',$pilotIDview)) > 1 ) {
	$serverID=$pilotPartsArray[0];
	$pilotIDview=$pilotPartsArray[1];
}

if (  count($pilotPartsArray=split('_',$pilotID)) >1 ) {
	$serverID=$pilotPartsArray[0];
	$pilotID=$pilotPartsArray[1];
}


if ($op=="main") $op=$CONF_main_page;
if ($op=="show_flight" && $flightID==0) $op=$CONF_main_page;

if ($op=="login") {  // do some output buffering so that cookies can be set later on
	ob_start();
}

if ($opMode==3 || $opMode==4 || $opMode==6)  // stand alone , we use phpbb3 as standalone too
	require_once dirname(__FILE__)."/GUI_header.php";

// phpnuke
if ($opMode==1) include("header.php");

?>

<link href="<?=$moduleRelPath."/templates/".$PREFS->themeName."/style.css"; ?>" rel="stylesheet" type="text/css">

<?
if ($opMode==1) OpenTable();

$Theme =new Theme();
require_once dirname(__FILE__)."/BLOCKS_start.php";



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

if ( ! $CONF['custom_top_menu'] ) {
	require_once dirname(__FILE__)."/MENU_menu.php";
} else {
	require_once dirname(__FILE__).'/MENU_'.$CONF['custom_top_menu'].'_top_menu.php';
}
?>
<script type="text/javascript" src="<?=$moduleRelPath?>/js/jquery.js"></script>
<script type="text/javascript" src="<?=$moduleRelPath?>/js/DHTML_functions.js"></script>
<?
if (in_array($op,array("list_flights","list_pilots","list_takeoffs","competition")) ) {
 // require_once dirname(__FILE__)."/MENU_second_menu.php";
}

		 
//---------------------------------------------
// MAIN SWITCH
//---------------------------------------------
$LeoCodeBase=dirname(__FILE__);

if ($op=="users") { 
	if ($opMode==3 ) require $LeoCodeBase."/USERS_index.php";
} else if ($op=="login") { 
	$noFooterMenu=1;
	if ($opMode==2 || $opMode==3 || $opMode==4 || $opMode==6 ) require $LeoCodeBase."/GUI_login.php";
} else if ($op=="register") { 
	echo "<BR><BR>Parameter Not used !!<BR>";
	// Not used 
	//	if ($opMode==2 || $opMode==3) require $LeoCodeBase."/GUI_register.php";
} else if ($op=="index_full") { 
	require $LeoCodeBase."/GUI_index_full.php";
} else if ($op=="index_help") {
	require $LeoCodeBase."/GUI_index_help.php";
} else if ($op=="index_news") {
	require $LeoCodeBase."/GUI_index_news.php";
// Clubs - areas admin
//--------------------------
} else if ($op=="club_admin") { 
	require $LeoCodeBase."/GUI_club_admin.php";
} else if ($op=="area_admin") { 
	require $LeoCodeBase."/GUI_area_admin.php";
} else if ($op=="admin_sites") { 
	require $LeoCodeBase."/GUI_admin_sites.php";
// Listing output
//--------------------------
} else if ($op=="list_clubs") { 
	require $LeoCodeBase."/GUI_list_clubs.php";
} else if ($op=="list_flights") { 
	require $LeoCodeBase."/GUI_list_flights.php";
} else if ($op=="list_pilots" ) {  
	require $LeoCodeBase."/GUI_list_pilots.php";
} else if ($op=="competition") {
    require $LeoCodeBase."/GUI_list_comp.php";
} else if ($op=="comp") {
    require $LeoCodeBase."/GUI_comp.php";
} else if ($op=="list_takeoffs") {
	require $LeoCodeBase."/GUI_list_takeoffs.php";	
} else if ($op=="sites") {
	require $LeoCodeBase."/GUI_sites.php";	
} else if ($op=="list_areas") {
	require $LeoCodeBase."/GUI_list_areas.php";	
} else if ($op=="area_show") {
	require $LeoCodeBase."/GUI_area_show.php";	

//--------------------------
// "Flight" related actions
//--------------------------
} else if ($op=="show_flight" ) {  
    require $LeoCodeBase."/GUI_flight_show.php";		
} else if ($op=="add_flight") {
	if ($userID>0) require $LeoCodeBase."/GUI_flight_add.php";
	else echo "<center><br>You are not logged in. <br><br>Please login<BR><BR></center>";
} else if ($op=="add_from_zip") {
	require $LeoCodeBase."/GUI_flight_add_from_zip.php";		
} else if ($op=="delete_flight") {
	require $LeoCodeBase."/GUI_flight_delete.php";
} else if ($op=="edit_flight") {
	require $LeoCodeBase."/GUI_flight_edit.php";	
}  else if ($op=="addTestFlightFromURL") {
	addTestFlightFromURL(urldecode ($_REQUEST[flightURL]) );
//--------------------------
// "Waypoints" related actions
//--------------------------
} else if ($op=="show_waypoint") {
	require $LeoCodeBase."/GUI_waypoint_show.php";	
} else if ($op=="add_waypoint") {
    require $LeoCodeBase."/GUI_waypoint_add.php";
} else if ($op=="edit_waypoint") {
    require $LeoCodeBase."/GUI_waypoint_edit.php";
//--------------------------
// "Pilots" related actions
//--------------------------
} else if ($op=="pilot_search") {
	require $LeoCodeBase."/GUI_pilot_search.php";
} else if ($op=="pilot_profile") {
	if ($userID>0 || $CONF_showProfilesToGuests ) require $LeoCodeBase."/GUI_pilot_profile.php";
	else echo "<center><br>You are not logged in. <br><br>Please login<BR><BR></center>";			
} else if ($op=="pilot_profile_edit") {
	require $LeoCodeBase."/GUI_pilot_profile_edit.php";
} else if ($op=="pilot_olc_profile_edit") {
	require $LeoCodeBase."/GUI_pilot_olc_profile_edit.php";
} else if ($op=="pilot_profile_stats") {
	require $LeoCodeBase."/GUI_pilot_profile_stats.php";
} else if ($op=="pilot_flights") {
	require $LeoCodeBase."/GUI_pilot_flights.php";
} else if ($op=="user_prefs") { 
	require $LeoCodeBase."/GUI_user_prefs.php";
//--------------------------
// Admin related actions
//--------------------------
} else if ($op=="admin") {
	require $LeoCodeBase."/GUI_admin.php";
} else if ($op=="admin_languages") {
	require $LeoCodeBase."/GUI_admin_update_languages.php";
} else if ($op=="admin_brands") {
	require $LeoCodeBase."/GUI_admin_brands.php";
} else if ($op=="admin_airspace") {
	require $LeoCodeBase."/GUI_admin_airspace.php";
} else if ($op=="admin_test") {
	require $LeoCodeBase."/GUI_admin_test.php";
} else if ($op=="admin_logs") {
	require $LeoCodeBase."/GUI_admin_logs.php";
} else if ($op=="admin_stats") {
	require $LeoCodeBase."/GUI_admin_stats.php";
} else if ($op=="admin_takeoffs") {
	require $LeoCodeBase."/GUI_admin_takeoffs.php";
} else if ($op=="admin_areas") {
	require $LeoCodeBase."/GUI_area_admin.php";
} else if ($op=="admin_takeoff_resolve") {
	require $LeoCodeBase."/GUI_admin_takeoff_resolve.php";
} else if ($op=="admin_duplicates") {
	require $LeoCodeBase."/GUI_admin_duplicates.php";
} else if ($op=="admin_pilot_map") {
	require $LeoCodeBase."/GUI_admin_pilot_map.php";
} else if ($op=="validation_review") {
	require $LeoCodeBase."/GUI_validation_review.php";
} else if ($op=="servers_manage") {
	require $LeoCodeBase."/GUI_servers_manage.php";
} else if ($op=="conf_htaccess") {
	require $LeoCodeBase."/GUI_conf_htaccess.php";
//--------------------------
//--------------------------
// Misc related actions
//--------------------------
} else if ($op=="filter") {
	require $LeoCodeBase."/GUI_filter.php";
} else if ($op=="rss_conf") {
	$noFooterMenu=1;
	require $LeoCodeBase."/GUI_rss_conf.php";
} else if ($op=="stats") {
	require $LeoCodeBase."/GUI_stats.php";
} else if ($op=="program_info") {
	require $LeoCodeBase."/GUI_program_info.php";
} 
	
exitPage(0);

// END OF OUTPUT to the browser

function exitPage($exitNow=1){
   global $opMode,$noFooterMenu,$moduleRelPath,$PREFS;
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

   $pageEnd=leo_getmicrotime();
   $pageTime=$pageEnd-$pageStart;
   DEBUG("MAIN",1,"PAGE CREATION: $pageTime secs<BR>");
   DEBUG_END();

   
   require_once dirname(__FILE__)."/BLOCKS_end.php";

   if ($opMode==1) {   
		CloseTable();
		include("footer.php");
   } else if ($opMode==3 || $opMode==4 || $opMode==6) {

		require_once dirname(__FILE__)."/GUI_footer.php";
   }
  
   statsLogger::Log($pageTime);
		
   if ($exitNow) exit;
}

?>
<? 
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://leonardo.thenet.gr 											*/
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/
require_once dirname(__FILE__)."/config_version.php";

// opMode 
// 1 = PHPnuke module
// 2 = phbb2 module
// 3 = standalone -- still work in progress
 $opMode= 2; 

 // admin_users 
 // put in this array the userID of the users you want ot grand admin status
 // YOU MUST PUT AT LEAST ONE ADMIN USER

 $admin_users=array(2,96,76,95,228);
 @include_once dirname(__FILE__)."/config_admin_users.php"; 

 // mod_users 
 // put in this array the userID of the users you want ot grand mod status
 // You can leave this blank
 $mod_users=array();

 $CONF_admin_email="your_mail@nowhere.com";

 $CONF_main_page="index_full";

 $apList=array(
 	"mx"=>array("desc"=>"Mexican XC League","lang"=>"mexican","theme"=>"mx","club"=>1,"header"=>"mx") ,
	"gr"=>array("desc"=>"Greek XC League","lang"=>"greek","theme"=>"gr","club"=>1, "header"=>"gr") ,
 );

 // club config
 @include_once dirname(__FILE__)."/config_clubs.php"; 

 // define the path where the maps reside
 // use this if you have the maps stored 
 // on the local server in a directory called maps/
 $mapsPath=dirname(__FILE__)."/maps";

 // use this if you have them on another windows drive
 // $mapsPath="E:\\maps";

 // or you can use an url if they are in a other server
 // $mapsPath="http://www.mapserver.com/my_maps";

 // CAUTION this will not work for importing the maps into the 
 // database, you should have already an workiing map db 
 // in order to use a url

 // the native language of the server
 $nativeLanguage="english";
 
 // if you intend to use google maps API to display fancy maps of takeoffs 
 // get one key for your server at 
 // http://www.google.com/apis/maps/signup.html
 // else leave it blank
 $CONF_google_maps_api_key="";

 // Available translations
 $availableLanguages=array("english","french","german","dutch","italian","spanish","mexican","portuguese","brazilian",
				    "greek","turkish","swedish","russian","croatian","polish");

 $langEncodings=array(
	"albanian"=>"iso-8859-2","arabic"=>"iso-8859-6","bulgarian"=>"iso-8859-5","brazilian"=>"iso-8859-1","catalan"=>"iso-8859-1",
	"croatian"=>"windows-1250","czech"=>"iso-8859-2","danish"=>"iso-8859-1","dutch"=>"iso-8859-1",
	"english"=>"iso-8859-1","estonian"=>"iso-8859-15","finnish"=>"iso-8859-1","french"=>"iso-8859-1",
	"german"=>"iso-8859-1","greek"=>"iso-8859-7","hebrew"=>"iso-8859-8","hungarian"=>"iso-8859-2",
	"icelandic"=>"iso-8859-1","italian"=>"iso-8859-1","latvian"=>"iso-8859-13","lithuanian"=>"iso-8859-13",
	"macedonian"=>"iso-8859-5","mexican"=>"iso-8859-1","norwegian"=>"iso-8859-1","polish"=>"iso-8859-2","portuguese"=>"iso-8859-1",
	"romanian"=>"iso-8859-2","russian"=>"windows-1251","serbian"=>"iso-8859-5","serbo-croatian"=>"iso-8859-2",
	"slovak"=>"iso-8859-2","slovenian"=>"iso-8859-2","spanish"=>"iso-8859-1","swedish"=>"iso-8859-1",
	"turkish"=>"iso-8859-9");

 $lang2iso=array("english"=>"en","german"=>"de","dutch"=>"nl","french"=>"fr", "italian"=>"it",
 			"spanish"=>"es","portuguese"=>"pt","brazilian"=>"br","greek"=>"gr","turkish"=>"tr",
			"swedish"=>"se","polish"=>"pl","bulgarian"=>"bg","russian"=>"ru","serbian"=>"cs",
			"croatian"=>"hr","mexican"=>"mx","polish"=>"pl" );

  $CONFIG_langsSpoken=array(
	"albanian"=>array("al"),"arabic"=>array("eg"),"bulgarian"=>array("bg"),
	"catalan"=>array("es"),"czech"=>array("cz"),"danish"=>array("dk"),
	"estonian"=>array("ee"),"finnish"=>array("fi"),"hebrew"=>array("il"),
	"hungarian"=>array("hu"),"icelandic"=>array("is"),"italian"=>array("it"),
	"latvian"=>array("lv"),"lithuanian"=>array("lt"),"macedonian"=>array("mk"),
	"norwegian"=>array("no"),"polish"=>array("pl"),"romanian"=>array("ro"),
	"russian"=>array("ru"),"serbian"=>array("cs"),"slovak"=>array("sk"),
	"slovenian"=>array("si"),"swedish"=>array("se"),"turkish"=>array("tr"),
	
	"croatian"=>array("hr","ba"),
	"dutch"=>array("be","nl"),
	"portuguese"=>array("br","pt"),
	"english"=>array("au","ca","gb","ie","nz","us"),
	"french"=>array("be","ca","fr","ch","re"),
	"german"=>array("at","de","ch"),
	"greek"=>array("cy","gr"),
	"spanish"=>array("ar","bo","cl","co","cr","ec","sv","gt","mx","ni","pa","py","pe","es","uy","ve")
  );		

 // If you have a waypoint database that has names in another language
 // than english but you want to diplay waypoint names in english 
 // set this to 1 to force that
 // if you have $nativeLanguage="english"; you will most probably want to
 // set it to 1 , else set it to 0
 $CONFIG_forceIntl=0;

 // set to 1 if you have an map server running
 // set to 0 if you dont know what a map server is ...
 // ... but you will not have the track plotted on the map 
 $mapServerActive=1;

 // set to 1 if you have an scoring server running
 // set to 0 if you dont know what a scoring server is ...
 // ... but you will not have the OLC score
 $scoringServerActive=1;

 // set to 1 if you have an working GD 2.0
 // set to 0 else 
 // ... but you will not have the flight's charts
 $chartsActive=1;

  // the OLC path 
 // this is needed for the automatic submission to OLC
 $olcServerURL = "http://olc.onlinecontest.org/olc-cgi/2006/holc-i/olc";

 // set this to 0 if you dont want to give the functionality of OLC submits
 // OLC scoring will be done even if you set this to 0. 
 // set $scoringServerActive=0 to disable the scoring.
 $enableOLCsubmission=1;

 // set this to 0 if you dont want to give the functionality of OLC submits
 // OLC scoring will be done even if you set this to 0. 
 // set $scoringServerActive=0 to disable the scoring.
 $enablePrivateFlights=0;


 // flightsTable
 // the name of the table holding the flights....
 // you should probably not change that unless you have 
 // many leonardo servers sharing the same database
  $CONF_tables_prefix="leonardo";
 $flightsTable	=  $CONF_tables_prefix."_flights";
 $pilotsTable	=  $CONF_tables_prefix."_pilots";
 $mapsTable		=  $CONF_tables_prefix."_maps";
 $waypointsTable=  $CONF_tables_prefix."_waypoints";
 $clubsTable	=  $CONF_tables_prefix."_clubs";
 $clubsPilotsTable	=  $CONF_tables_prefix."_clubs_pilots";
 // Mrsid tiles config
 $maxMrSidResolution=28.5; // m/pixel Smaller is better.
 $minMrSidResolution=28.5; // m/pixel

 // ------------------------
 //  various config
 // ------------------------
 $takeoffRadious= 500 ; // in m
 $landingRadious= 1000 ; // in m
 $CONF_itemsPerPage=50 ;
 $CONF_compItemsPerPage=50;
 $CONF_defaultThemeName="basic";
 $CONF_metricSystem=1; //  1=km,m     2=miles,feet

 // Debug leave it 0
 $CONF_show_DBG_XML=1;

 $CONF_countHowManyFlightsInComp=6;

 $CONF_showProfilesToGuests=1;

 // Available Types and subtypes of Gliders
 $CONF_glider_types=array(1=>"Paraglider",2=>"Flex wing FAI1",4=>"Rigid wind FAI5",8=>"Glider" );
// $CONF_glider_types=array(1=>"Paraglider");
 $CONF_default_cat_view=0; // pg
 $CONF_default_cat_add=1; //  the default category for submitting new flights 

//-----------------------------------------------------------------------------
// DONT EDIT BELOW THIS LINE --- EDIT last lines only
//-----------------------------------------------------------------------------

if ($opMode==1 || $opMode==2 ) $CONF_mainfile="modules.php";
else  $CONF_mainfile="index.php";

// detect if the installation in not on the root
$baseInstallationPath="";
$parts=explode("/",$_SERVER['REQUEST_URI']);

if ( count($parts)>1 )  {
	for($i=1;$i<count($parts);$i++) 
	   if ($parts[$i-1]!='') $baseInstallationPath.="/".$parts[$i-1];	
}

if (!isset($module_name))  {
	if (isset($_GET['name'])) $module_name=$_GET['name'];
	else $module_name="leonardo";
	$moduleAbsPath=dirname(__FILE__);
	if ($opMode==3) $moduleRelPath="./";
	else  $moduleRelPath="modules/".$module_name;
}
$flightsRelPath="flights";
$waypointsRelPath="waypoints";

$waypointsAbsPath=dirname(__FILE__)."/".$waypointsRelPath;
$waypointsWebPath=$moduleRelPath."/".$waypointsRelPath;

$flightsAbsPath=dirname(__FILE__)."/".$flightsRelPath;
$flightsWebPath=$moduleRelPath."/".$flightsRelPath;

function setVarFromRequest($varname,$def_value) {
	global $$varname; 
    //echo "SES:".$_SESSION[$varname]."#REQ:".$_REQUEST[$varname]."#".$varname."<BR>";
	if (isset($_REQUEST[$varname])) {
	  $$varname=$_REQUEST[$varname];
	  $_SESSION[$varname]=$$varname;
	} else if ( isset($_SESSION[$varname])  ) {
	  $$varname=$_SESSION[$varname];
	} else { // default value
	  $$varname=$def_value;
	  $_SESSION[$varname]=$$varname;
	}
}

function setVar($varname,$value) {
	global $$varname; 
    //echo "SES:".$_SESSION[$varname]."#REQ:".$_REQUEST[$varname]."#".$varname."<BR>";
	  $$varname=$value;
	  $_SESSION[$varname]=$$varname;
	 // $_GET[$varname]=$$varname;
	 // $_POST[$varname]=$$varname;
	 // $_REQUEST[$varname]=$$varname;
}

require_once dirname(__FILE__)."/CL_user_prefs.php";
$PREFS=new userPrefs();
if (! $PREFS->getFromCookie() ) {
	// echo "NO user prefs cookie found : puting default values<br>";
	$PREFS->themeName= $CONF_defaultThemeName;
	$PREFS->language=$nativeLanguage;
	$PREFS->viewCat=$CONF_default_cat_view;
	$PREFS->viewCountry=0;
	$PREFS->itemsPerPage=$CONF_itemsPerPage;
	$PREFS->metricSystem=$CONF_metricSystem;
}

if (isset($_REQUEST['updatePrefs'])) {// submit form 	   		
	$PREFS->themeName= $_POST['PREFS_themeName'];
	$PREFS->itemsPerPage=$_POST['PREFS_itemsPerPage'];
	$PREFS->metricSystem=$_POST['PREFS_metricSystem'];
	
	$PREFS->language=$_POST['PREFS_language'];
	$_SESSION["lng"]= $PREFS->language;
	$PREFS->viewCat=$_POST['PREFS_viewCat'];
	$_SESSION["cat"]= $PREFS->viewCat;
	$PREFS->viewCountry=$_POST['PREFS_viewCountry'];
	$_SESSION["country"]= $PREFS->viewCountry;
}

$PREFS->setToCookie();

//-----------------------------------------------------------------------------
// DO EDIT BELOW THIS LINE
//-----------------------------------------------------------------------------

 // you should probably set  $OLCScoringServerPath to the same server 
 // you have leonardo
 $OLCScoringServerPath="http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/modules/".$module_name."/server/scoreOLC.php";
 $OLCScoringServerPassword="mypasswd";

?>
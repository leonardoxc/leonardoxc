<?
//************************************************************************
// Leonardo XC Server, http://www.leonardoxc.net
//
// Copyright (c) 2004-2010 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: config.php,v 1.164 2012/11/05 07:37:13 manolis Exp $                                                                 
//
//************************************************************************

// set this to always use . in sprintf 
setlocale(LC_NUMERIC, 'en_US') ;
@ini_set('auto_detect_line_endings',true);

// This file contains default values and is overwritten on new updates -installs
// Dont edit this file, edit site/config_custom.php instead

  $CONF_version="4.0.0";
  $CONF_releaseDate="2012/11/05";

// opMode 
// 1 = PHPnuke module
// 2 = phbb2 module
// 3 = standalone -- still work in progress
 $opMode= 2; 
 require dirname(__FILE__)."/site/config_op_mode.php";

 // Here we define which server Id is the master server of the leonardo Network
 $CONF_master_server_id=1;

 // Our server ID -> usually 0 for non network operation
 $CONF_server_id=0;
 
 // various display parameters
 $CONF['display']['blocks']['right_side']=1;

 // if it is a phpbb module we can use our own template 
 // and not the onw of the forum 
 if ( !isset($CONF_use_own_template) ) $CONF_use_own_template=0;
 
 // for phpbb when  $CONF_use_own_template=1;
 if ( !isset($CONF_use_own_login) )  $CONF_use_own_login=0;
 
 // rely on  leonardo_pilits name flields  entirely
 $CONF_use_leonardo_names=0;
 
 // admin_users 
 // put in this array the userID of the users you want ot grand admin status
 // YOU MUST PUT AT LEAST ONE ADMIN USER

 $admin_users=array();
 // mod_users 
 // put in this array the userID of the users you want ot grand mod status
 // You can leave this blank
 $mod_users=array();

 // ***********************************************************
 // put your admin/mod users in this file !!!!!!!!!!!!!!!!!
 // ***********************************************************
 @include_once dirname(__FILE__)."/site/config_admin_users.php"; 

 $CONF_admin_email="your_mail@nowhere.com";
 require_once dirname(__FILE__)."/site/config_admin_email.php"; 
 
 $CONF_main_page="index_full";

 // club config
 $clubsList=array();
 @include_once dirname(__FILE__)."/site/config_clubs.php"; 

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

 // this is for the  DEM - 3d maps, to compute ground height 
 $CONF_DEMpath=dirname(__FILE__)."/maps/hgt/";


 // the native language of the server
 $nativeLanguage="english";
 
 // if you intend to use google maps API to display fancy maps of takeoffs 
 // get one key for your server at 
 // http://www.google.com/apis/maps/signup.html
 // else leave it blank
 $CONF_google_maps_api_key="";


 // use utf language files 
 // not yet ready !! dont use !
 $CONF_use_utf=1;
 
 // Available translations
 $availableLanguages=array("english","french","german","dutch","italian","spanish","mexican","portuguese","brazilian",
				    "greek","turkish","danish","swedish","finnish","russian","bulgarian","croatian","slovenian","polish","czech","hungarian","romanian","chinese","hebrew");

 $langEncodings=array(
	"albanian"=>"iso-8859-2","arabic"=>"iso-8859-6","bulgarian"=>"windows-1251","brazilian"=>"iso-8859-1",
	"catalan"=>"iso-8859-1", "chinese"=>"gb2312",
	"croatian"=>"windows-1250","czech"=>"iso-8859-2","danish"=>"iso-8859-1","dutch"=>"iso-8859-1",
	"english"=>"iso-8859-1","estonian"=>"iso-8859-15","finnish"=>"iso-8859-1","french"=>"iso-8859-1",
	"german"=>"iso-8859-1","greek"=>"iso-8859-7","hebrew"=>"iso-8859-8-i","hungarian"=>"iso-8859-2",
	"icelandic"=>"iso-8859-1","italian"=>"iso-8859-1","latvian"=>"iso-8859-13","lithuanian"=>"iso-8859-13",
	"macedonian"=>"iso-8859-5","mexican"=>"iso-8859-1","norwegian"=>"iso-8859-1","polish"=>"iso-8859-2","portuguese"=>"iso-8859-1",
	"romanian"=>"iso-8859-2","russian"=>"windows-1251","serbian"=>"iso-8859-5","serbo-croatian"=>"iso-8859-2",
	"slovak"=>"iso-8859-2","slovenian"=>"iso-8859-2","spanish"=>"iso-8859-1","swedish"=>"iso-8859-1",
	"turkish"=>"iso-8859-9");

 $lang2iso=array("english"=>"en","german"=>"de","dutch"=>"nl","french"=>"fr", "italian"=>"it",
 			"spanish"=>"es","portuguese"=>"pt","brazilian"=>"br","greek"=>"gr","turkish"=>"tr",
			"swedish"=>"se","finnish"=>"fi","polish"=>"pl","bulgarian"=>"bg","romanian"=>"ro","russian"=>"ru","serbian"=>"cs",
			"croatian"=>"hr","mexican"=>"mx","polish"=>"pl" ,"czech"=>"cz" ,"hungarian"=>"hu","slovenian"=>"si",
			"danish"=>"dk","chinese"=>"cn","hebrew"=>"il");

 $CONF['lang']['lang2countryFlag']=array(
			"english"=>"us","german"=>"de","dutch"=>"nl","french"=>"fr", "italian"=>"it",
 			"spanish"=>"es","portuguese"=>"pt","brazilian"=>"br","greek"=>"gr","turkish"=>"tr",
			"swedish"=>"se","finnish"=>"fi","polish"=>"pl","bulgarian"=>"bg","romanian"=>"ro","russian"=>"ru","serbian"=>"cs",
			"croatian"=>"hr","mexican"=>"mx","polish"=>"pl" ,"czech"=>"cz" ,"hungarian"=>"hu","slovenian"=>"si",
			"danish"=>"dk","chinese"=>"cn","hebrew"=>"il");


 $lang2isoEditor=array("english"=>"en","german"=>"de","dutch"=>"nl","french"=>"fr", "italian"=>"it",
 			"spanish"=>"es","portuguese"=>"pt","brazilian"=>"pt-br","greek"=>"el","turkish"=>"tr",
			"swedish"=>"sv","finnish"=>"fi","polish"=>"pl","bulgarian"=>"bg","romanian"=>"ro","russian"=>"ru","serbian"=>"cs",
			"croatian"=>"hr","mexican"=>"es","polish"=>"pl" ,"czech"=>"cz" ,"hungarian"=>"hu","slovenian"=>"si",
			"danish"=>"da","chinese"=>"zh","hebrew"=>"he");

 $lang2isoGoogle=array("english"=>"en","german"=>"de","dutch"=>"nl","french"=>"fr", "italian"=>"it",
 			"spanish"=>"es","portuguese"=>"pt","brazilian"=>"pt","greek"=>"el","turkish"=>"tr",
			"swedish"=>"sv","finnish"=>"fi","polish"=>"pl","bulgarian"=>"bg","romanian"=>"ro","russian"=>"ru","serbian"=>"sr",
			"croatian"=>"hr","mexican"=>"es","polish"=>"pl" ,"czech"=>"cs" ,"hungarian"=>"hu","slovenian"=>"sl",
			"danish"=>"da","chinese"=>"zh","hebrew"=>"he");
			
  $CONFIG_langsSpoken=array(
	"albanian"=>array("al"),"arabic"=>array("eg"),"bulgarian"=>array("bg"),
	"catalan"=>array("es"),"chinese"=>array("cn"),"czech"=>array("cz"),"danish"=>array("dk"),
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

 // dont use DEM for ground elevation by default
 $CONF['maps']['3d']=0;

 // Use google maps to display flight track ( needs a google maps key : see above  $CONF_google_maps_api_key )
 $CONF_google_maps_track=0;
 $CONF_google_maps_track_order=2; // will apear in the second tab
 $CONF_google_maps_track_only=0;  // use only google maps,  discard the local map server


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
 $enableOLCsubmission=0;


 // validate against the G-record
 $CONF_use_validation=1;
 $CONF['validation']['user_internal_server']=1;
 $CONF['validation']['server_url']="";
 
 
 // Membership of NAC (National Airsport Control, also referred as National Aero Club)
 $CONF_NAC_list=array();
 $CONF_use_NAC=0;
 // Allow pilots to assgin a different NAC club to each of their flights
 $CONF['NAC']['clubPerFlight'] =0;
 
 // set this to 0 if you dont want to give the functionality of OLC submits
 // OLC scoring will be done even if you set this to 0. 
 // set $scoringServerActive=0 to disable the scoring.
 $enablePrivateFlights=1;


 // flightsTable
 // the name of the table holding the flights....
 // you should probably not change that unless you have 
 // many leonardo servers sharing the same database
 $CONF_tables_prefix="leonardo";
 $flightsTable	=  $CONF_tables_prefix."_flights";
 $deletedFlightsTable=	$CONF_tables_prefix."_flights_deleted";
 $pilotsTable	=  $CONF_tables_prefix."_pilots";
 $pilotsInfoTable	=  $CONF_tables_prefix."_pilots_info";
 $mapsTable		=  $CONF_tables_prefix."_maps";
 $waypointsTable=  $CONF_tables_prefix."_waypoints";
 $clubsTable	=  $CONF_tables_prefix."_clubs";
 $NACclubsTable =  $CONF_tables_prefix."_nac_clubs";
 $clubsPilotsTable	=  $CONF_tables_prefix."_clubs_pilots";
 $clubsFlightsTable	=  $CONF_tables_prefix."_clubs_flights";
 $serversTable	=  $CONF_tables_prefix."_servers";
 $logTable		=  $CONF_tables_prefix."_log";
 $statsTable		=  $CONF_tables_prefix."_stats";
 $airspaceTable		=  $CONF_tables_prefix."_airspace";

 $areasTable	=		$CONF_tables_prefix."_areas";
 $areasTakeoffsTable=	$CONF_tables_prefix."_areas_takeoffs";
 $photosTable  	=		$CONF_tables_prefix."_photos";
 $remotePilotsTable =	$CONF_tables_prefix."_remote_pilots";
 $scoresTable		=  $CONF_tables_prefix."_flights_score";

 $thermalsTable		=  $CONF_tables_prefix."_thermals";
 $commentsTable		=  $CONF_tables_prefix."_comments";

 $jobsTable			= $CONF_tables_prefix."_queue";
 
 // Mrsid tiles config
 $maxMrSidResolution=28.5; // m/pixel Smaller is better.
 $minMrSidResolution=28.5; // m/pixel

 // ------------------------
 //  various config
 // ------------------------
 $takeoffRadious= 500 ; // in m
 $landingRadious= 1000 ; // in m
 $CONF_itemsPerPage=50 ;
 $CONF_compItemsPerPage=100;
 $CONF_defaultThemeName="basic";
 $CONF_metricSystem=1; //  1=km,m     2=miles,feet

 // Debug leave it 0
 $CONF_show_DBG_XML=1;

 $CONF_countHowManyFlightsInComp=6;

 $CONF_showProfilesToGuests=1;

 // Max is 6 
 $CONF_photosPerFlight=6;
 $CONF_max_photo_size=3000; // 3000 Kb

 // Available Types and subtypes of Gliders
 $CONF_glider_types=array(1=>"Paraglider",2=>"Flex wing FAI1",4=>"Rigid wing FAI5",8=>"Glider",
				16=>"Paramotor",32=>"Trike", 64=>"Powered flight",256=>"HG Mosquito" );
// $CONF_glider_types=array(1=>"Paraglider");


 $CONF['startTypes']=array(1=>"Foot",2=>"Winch",4=>"Microlight tow",8=>"E-motor" );
 $CONF['defaultStartType']=1;


 $CONF_glider_certification_categories =array(
 		1=>"LTF 1",2=>"LTF 1/2",4=>"LFT 2", 8=>"LFT 2/3" , 16=>"LFT 3" , 
 		32=>"EN A",64=>"EN B",128=>"EN C", 256=>"EN D" , 
 		1024=>"Proto");
 
 $CONF_cert_avalable_categories=array(
	0=>array(1,2,3,4), // ALL
 	1=>array(1,2,3,4), // ltf 1
 	2=>array(1,2,3),
 	4=>array(1,2,3),
 	8=>array(2,3),   // ltf 2/3
 	16=>array(2,3),  // ltf 3
 	32=>array(1,2,3,4), //en a
 	64=>array(1,2,3),  
 	128=>array(2,3),
 	256=>array(2,3),
 	1024=>array(2,3),
  );
 
 
 $CONF_xc_types=array(1=>"3 Turnpoints XC",2=>"Open Triangle",4=>"Closed Triangle");
 $CONF_xc_types_db=array(1=>"FREE_FLIGHT",2=>"FREE_TRIANGLE",4=>"FAI_TRIANGLE");				

 $CONF['gliderClasses']=array(
    // pg
 	1=>array( 
		'default_class'=>2,
		'classes'=>array(1=>"Sport",2=>"Open",3=>"Tandem"),		
	),
	2=>array( 
		'default_class'=>2,
		'classes'=>array(1=>"Kingpost",2=>"Topless"),
	),
 );	


 // these are no longer used! 
 //$CONF_category_types =array(1=>"Sport",2=>"Open",3=>"Tandem");
 //$gliderClassList=$CONF_category_types;

 // defaul values 
 $xcTypesList=$CONF_xc_types;

 $CONF_default_cat_view=0; // pg
 $CONF_default_cat_add=1; //  the default category for submitting new flights 
 $CONF_default_cat_pilots=1; // the default cat to display pilots for
 
 // The top 'dates' menu  will have years starting from $CONF_StartYear
 // Deprecated -  not use it anywherenow
 $CONF_StartYear=1998;


 // flights that were submitted these days ago will have a "new" icon
 // set to -1 to disable
 $CONF_new_flights_days_threshold=3;

 // Flights older than these days will not be accepted.
 // set to 0 to deactivate
 // Admins cat submit flights either way for any day in the past!
 $CONF_new_flights_submit_window=0;

 // this will allow the use of pre-calculated turnpoints for OLC score optimization
 // This is done by uploading an .OLC file
 $CONF_allow_olc_files=1;
 
 // this will allow an external program to upload a flight to this server.
 // the program must post a form to http://serveraddess/modules/leonardo/flight_submit.php
 $CONF_allow_direct_upload=1;

 // this will enable a calendar in flights_list to select individual days
 $CONF_use_calendar=1;
 
	// SEASON MOD
	// start of seasons config (2007-09-27)
	require_once dirname(__FILE__)."/CL_dates.php";
	
	$CONF['years']=array(
		'use_calendar_years'=>1,
		'start_year'=>1998,
		'end_year'=>date("Y")
		);
	
	
	// set this to 1 to enable seasons
	$CONF['seasons']['use_season_years']=0;	
	
	// IF this is set then all info on which sesons to display in hte menu
	//     will be taken forh the $CONF['seasons']['seasons']
	// ELSE 
	//    the menu will display season starting from $CONF['seasons']['start_season'] to $CONF['seasons']['end_season']
	//    BOTH VALUES MUST BE defined
	//    In this case also the season start/end will be defined from 
	//    $CONF['seasons']['season_default_start'] and $CONF['seasons']['season_default_end']	
	$CONF['seasons']['use_defined_seasons']=0;

	// Defined seasons
	// The next array will be used in case of 	$CONF['seasons']['show_only_defined_seasons']=1
	$CONF['seasons']['seasons']=array(
		2008=>array('start'=>'2007-10-1','end'=>'2008-09-30'),
		2007=>array('start'=>'2006-10-1','end'=>'2007-9-30',
					'subseasons'=>array(
						'winter'=>array('start'=>'2006-10-1','end'=>'2007-3-31','localName'=>'winterInLocalLanguage'),
						'summer'=>array('start'=>'2007-3-1','end'=>'2007-9-30','localName'=>'summerInLocalLanguage'),
					)					
				),
	
	);				

	// The next 4 values will be used in case of 	$CONF['seasons']['show_only_defined_seasons']=0
	$CONF['seasons']['season_default_start']='10-1';
	$CONF['seasons']['season_default_end']='9-31';		
	
	// ONLY ONE of the 3 next varibles canbe set to TRUE !!!
	// if the season 2007 is 2006-10-1 till  2007-9-30
	$CONF['seasons']['season_start_year_diff']=-1;
	$CONF['seasons']['season_end_year_diff']=0;

	// else if season 2007 is 2007-4-1 till  2008-3-31
	//$CONF['seasons']['season_start_year_diff']=0;
	//$CONF['seasons']['season_end_year_diff']=1;

	// else if season 2007 is 2007-1-1 till  2007-12-31
	//$CONF['seasons']['season_start_year_diff']=0;
	//$CONF['seasons']['season_end_year_diff']=0;

	$CONF['seasons']['start_season']=2006;
	$CONF['seasons']['end_season']= dates::getCurrentSeason(0);

 // end of seasons config
 				

 // start of BRANDS MOD
	$CONF['brands']['filter_brands'] = 0;
	$CONF['brands']['showAll']=0;
	$CONF['brands']['list']=array();
	$CONF['brands']['filterList']=array(1,2,4);

 // end of BRANDS MOD
	
 // this is the default setting for the user's -> "My settings"
 $CONF_googleMapsShow=1;
 
 // 1- > western -> firstName - LastName
 // 2- > eastern -> LastName - firstName 
 $CONF_defaultNameOrder=1; 
 
 // USE airspace checking
 $CONF_airspaceChecks=0; 
 // airspace infrigments will be show to admins and the owner of the track
 $CONF['airspace']['view']=='own';
 // display airspace in google maps
 $CONF['airspace']['enable']=1;
 
 $CONF['aispace']['list']['colors']=array(
	'CLASSC'=>'FF0008',
	'CLASSD'=>'FF0008',
 	'ALLOTHER'=>'FFFF00',
 );
					
 // Will use the date('0') together with the timezone name for TZ detection
 // This is buggy in php 4.4.1 and before .
 $CONF_use_date_for_TZ_detection=1;


  // use htc files for ie mouse over TR elements
  // May not work on servers behind firewalls
  $CONF_use_htc_ie_hack=1;

  $CONF['list_flights']['fields']['scoring'][0]='LINEAR_DISTANCE'; // LINEAR_DISTANCE or SCORE_SPEED

  $CONF['sync']['protocol']['format']='JSON';

  // dont enable statistics by default, it uses a lot of space !!!
  $CONF['stats']['enable']=0;

  // use a WYSIWYG editor for editing takeoff information
  $CONF['editor']['use_wysiwyg']['global']=1;
  $CONF['editor']['use_wysiwyg']['takeoff_description']=1;
  $CONF['editor']['use_wysiwyg']['flight_comments']=1;

  // default user prefs 
  $CONF['default_user_prefs']['useEditor']=1;
  
  //  live thumbnails 
  $CONF['photos']['mid']['max_width']=600;
  $CONF['photos']['mid']['max_height']=600;

  $CONF['photos']['normal']['max_width']=1600;
  $CONF['photos']['normal']['max_height']=1600;
  
  $CONF['photos']['thumbs']['max_width']=130;
  $CONF['photos']['thumbs']['max_height']=130;
  
  $CONF['photos']['tiny']['max_width']=60;
  $CONF['photos']['tiny']['max_height']=60;
  
  $CONF['photos']['compression']=20;
  
  // the scoring co-efficients 
  $CONF['scoring']['default_set']=1;
  $CONF['scoring']['sets']=array(
		1=>array('name'=>'XC scoring',
				 'code'=>'OLC',
				 'types'=>array('FREE_FLIGHT'=>1.5,
								'FREE_TRIANGLE'=>1.75,
								'FAI_TRIANGLE'=>2,
						)
			),

/*
Triangle conform to the FAI definition 
(the shortest leg of the triangle must be at least 28% of the total triangle)
*/
		2=>array('name'=>'FAI scoring',
				 'code'=>'FAI',
				 'types'=>array('FREE_FLIGHT'=>1,
								'FREE_TRIANGLE'=>1.2,
								'FAI_TRIANGLE'=>1.4,
						)
			),
	);
	
	
	if ( strpos(strtolower(PHP_OS), 'win')  === false ) $CONF['os']='linux';
	else $CONF['os']='windows';
		
	$CONF['thermals']['enable']=false;

	// choose how to send mail to users from the system
	
	$CONF['mail']['method']='system'; // use mail() function
	/*
	$CONF['mail']['method']='smtp';  // use an external mail server
	$CONF['mail']['smtp']['host']='';
	$CONF['mail']['smtp']['port']=25;
	$CONF['mail']['smtp']['ssl']=false;
	$CONF['mail']['smtp']['username']='';
	$CONF['mail']['smtp']['password']='';
	*/
	
	$CONF['site']['name']="LeonardoXC";
	
	$CONF_force_civlid=0;
	
    $CONF['NAC']['display_club_details_on_pilot_list']=0;
	
	$CONF['db_browser']['maxTrackNum']=50;
	
	$CONF['pdf']['pdfcreator']=dirname(__FILE__).'/lib/pdf/wkhtmltopdf   ';
	$CONF['pdf']['tmpPath']=dirname(__FILE__).'/data/pdf/tmp';
	$CONF['pdf']['tmpPathRel']="data/pdf/tmp";
	$CONF['pdf']['maxflightsPerPrint']=20;
	$CONF['pdf']['daysTokeepPdfOnServer']=3;
//-----------------------------------------------------------------------------
// DONT EDIT BELOW THIS LINE --- EDIT last lines only
//-----------------------------------------------------------------------------

function setVarFromRequest($varname,$def_value,$isNumeric=0) {
	if ($varname=='day' || $varname=='month' || $varname=='year' ) {
			if ( isset($_SESSION[$varname.'leo']))  $_SESSION[$varname]=$_SESSION[$varname.'leo'];
	}

	global $$varname;
	 // echo "SES:".$_SESSION[$varname].", REQ:".$_REQUEST[$varname].", varname:".$varname.", def_value: $def_value<BR>";
	 // first we see if this was passed as an arguemnt
	if (isset($_REQUEST[$varname])) {
	  $$varname=$_REQUEST[$varname];
	  $_SESSION[$varname]=$$varname;
	// then if it already existed in the SESSION 
	} else if ( isset($_SESSION[$varname])  ) {
	  $$varname=$_SESSION[$varname];
	// if nothing of the above, put the default value  
	} else { // default value
	  $$varname=$def_value;
	  $_SESSION[$varname]=$$varname;
	}
	
	// sanitize the variable!
	if ($isNumeric) { // just add 0, this should do the trick
	  $$varname=$$varname+0;
	} else { // is string : allow only  a-zA-Z0-9_
	  $$varname=preg_replace("/[^\w_\.]/","",$$varname);
	}
	$_SESSION[$varname]=$$varname;
	if ($varname=='day' || $varname=='month' || $varname=='year' )   $_SESSION[$varname.'leo']=$$varname;
	
	// echo "$varname=".$$varname."#";
}

function makeSane($str,$type=0) {
	if ($type==1) { // 1=> numeric just add 0, this should do the trick
		return $str+0;
	} else 	if ($type==0) { // is "strict" string : allow only  a-zA-Z0-9_-,.
		return preg_replace("/[^\w_\-\,\.]/","",$str);
	} else 	if ($type==2) { // is "relaxed" string : allow only  a-zA-Z0-9_
		return preg_replace('/\\\/',"",$str);
	} else {	// no sanitation
		return $str; 
	}

}

function setVar($varname,$value) {
	global $$varname; 
    //echo "SES:".$_SESSION[$varname]."#REQ:".$_REQUEST[$varname]."#".$varname."<BR>";
	  $$varname=$value;
	  $_SESSION[$varname]=$$varname;
	  if ($varname=='day' || $varname=='month' || $varname=='year' )   $_SESSION[$varname.'leo']=$$varname;
	 // $_GET[$varname]=$$varname;
	 // $_POST[$varname]=$$varname;
	 // $_REQUEST[$varname]=$$varname;
	 // echo "SETVAR: $varname=".$$varname."#";
}

// you should probably set  $OLCScoringServerPath to the same server 
// you have leonardo
$OLCScoringServerUseInternal=1;
// These are not needed if $OLCScoringServerUseInternal=1;
$OLCScoringServerPath="http://".$_SERVER['SERVER_NAME'].getRelMainDir()."/server/scoreOLC.php";
$OLCScoringServerPassword="mypasswd";


$CONF['paths_versions'][2]['tmpigc']='data/tmp';
$CONF['paths_versions'][2]['config']['pathsVersion']=2;

// the rss map thumbs
$CONF['paths_versions'][2]['map_thumbs']='data/cache/map_thumbs';

// the pilot dir
$CONF['paths_versions'][2]['pilot']	='data/pilots/%PILOTID%';
// the main IGC file
$CONF['paths_versions'][2]['igc']	='data/flights/tracks/%YEAR%/%PILOTID%';
// photo filenames
$CONF['paths_versions'][2]['photos']='data/flights/photos/%YEAR%/%PILOTID%';
// The rest can be ommited from Backup!!!
// *.jpg
$CONF['paths_versions'][2]['map']	='data/flights/maps/%YEAR%/%PILOTID%';
// *.png 16 files / flight
$CONF['paths_versions'][2]['charts']='data/flights/charts/%YEAR%/%PILOTID%';
// *.kmz
// *.man.kmz
// *.igc2kmz.[version].kmz
$CONF['paths_versions'][2]['kml']	='data/flights/kml/%YEAR%/%PILOTID%';
// *.json.js
$CONF['paths_versions'][2]['js']	='data/flights/js/%YEAR%/%PILOTID%';
// *.1.txt
// *.poly.txt
// *.saned.full.igc
// *.saned.igc
$CONF['paths_versions'][2]['intermediate']	='data/flights/intermediate/%YEAR%/%PILOTID%';


// the paths for pathsVersion=1
$CONF['paths_versions'][1]['tmpigc']='files/tmp';
// the rss map thumbs
$CONF['paths_versions'][1]['map_thumbs']='tmp_map_thumbs';

$CONF['paths_versions'][1]['config']['pathsVersion']=1;
// the pilot dir
$CONF['paths_versions'][1]['pilot']	='flights/%PILOTID%';
// the main IGC file
$CONF['paths_versions'][1]['igc']	='flights/%PILOTID%/flights/%YEAR%';
// photo filenames
$CONF['paths_versions'][1]['photos']='flights/%PILOTID%/photos/%YEAR%';
// *.jpg
$CONF['paths_versions'][1]['map']	='flights/%PILOTID%/maps/%YEAR%';
// *.png 16 files / flight
$CONF['paths_versions'][1]['charts']='flights/%PILOTID%/charts/%YEAR%';
// *.kmz
// *.man.kmz
// *.igc2kmz.[version].kmz
$CONF['paths_versions'][1]['kml']	='flights/%PILOTID%/flights/%YEAR%';
// *.json.js
$CONF['paths_versions'][1]['js']	='flights/%PILOTID%/flights/%YEAR%';
// *.1.txt
// *.poly.txt
// *.saned.full.igc
// *.saned.igc
$CONF['paths_versions'][1]['intermediate']	='flights/%PILOTID%/flights/%YEAR%';


$CONF['paths']=$CONF['paths_versions'][1];

$CONF['userPrefs']['defaults']=array(
	'showNews'=>1,
);


//---------------------------------------------------
// user profile options
//---------------------------------------------------

// the way to fill in the CIVL ID of the pilot
$CONF['profile']['CIVL_ID']['enter_url']='';
// example  for custom method : 
// $CONF['profile']['CIVL_ID_enter_url']=
// 			getRelMainDir()."/site/CIVL_ID_enter.php?id=check_membership&callingfield=CIVL_ID";
$CONF['profile']['CIVL_ID']['window_width']=700;
$CONF['profile']['CIVL_ID']['window_height']=550;

$CONF['takeoffAreas']['defaultCountry']='';

$CONF['db_browser']['default_area']=1;
$CONF['db_browser']['areas']=array(
	1=>array(
		'name'=>"Europe",
		'queryString'=>"",
		'min_lat'=>35,
		'max_lat'=>64,
		'min_lon'=>-11,
		'max_lon'=>30.5,
		'radius'=>1800,
	),

	2=>array(
		'name'=>"Alps",
		'queryString'=>"",
		'min_lat'=>44,
		'max_lat'=>47,
		'min_lon'=>6,
		'max_lon'=>14,
		'radius'=>350,
	),
	
	3=>array(
		'name'=>"Germany",
		'queryString'=>"",
		'min_lat'=>47,
		'max_lat'=>55,
		'min_lon'=>4.5,
		'max_lon'=>15,
		'radius'=>400,
	),
);



define("LEONARDO_ABS_PATH",dirname(__FILE__));
$CONF_abs_path=LEONARDO_ABS_PATH;

// news
$CONF['news']['items']=array();
@include_once dirname(__FILE__)."/site/config_news.php";

// The readonly fields on profile edit page - override in site/config_custom.php
$CONF['profile']['edit']['readonlyFields']=array();
	
// dont force the users to enter a civl id
$CONF['profile']['edit']['force_civl_id']=false;


$CONF['log']['logActions']=array(
// 1 => "Flight",
2 => "Pilot",
4 => "Waypoint",
8 => "NAC / Club  / Group",
16=> "League / Event ",
32=> "Area  ",
);

$CONF['log']['logActionsType']=array(
1  => "Add",
2  => "Edit",
4  => "Delete",
8  => "Score",
16 => "Rename TrackLog",
32 => "Create Map",
);
	
$CONF['comments']['guestComments']=true;

	
// we over ride the config values with our custom ones here 
@include_once dirname(__FILE__)."/site/config_custom.php";
@include_once dirname(__FILE__)."/site/config_ranks.php";
@include_once dirname(__FILE__)."/site/config_servers.php";

$CONF_tmp_path=$CONF_abs_path.'/'.$CONF['paths']['tmpigc']; // was  '/files/tmp';

// this loads predefined settings for userDB and  settings 
// to bridge to the users table of different forum/portal/cms systems
require_once dirname(__FILE__)."/site/predefined/$opMode/config.php";
setLeonardoPaths();

// time to load the user prefs from cookie
require_once dirname(__FILE__)."/CL_user_prefs.php";
$PREFS=new userPrefs();
if (! $PREFS->getFromCookie() || !$PREFS->themeName  || !$PREFS->itemsPerPage ) {
	// echo "NO user prefs cookie found : puting default values<br>";
	$PREFS->themeName= $CONF_defaultThemeName;
	$PREFS->language=$nativeLanguage;
	$PREFS->viewCat=$CONF_default_cat_view;
	$PREFS->viewCountry=0;
	$PREFS->itemsPerPage=$CONF_itemsPerPage;
	$PREFS->metricSystem=$CONF_metricSystem;

	$PREFS->nameOrder=$CONF_defaultNameOrder;
	$PREFS->googleMaps=$CONF_googleMapsShow;
	$PREFS->useEditor=$CONF['default_user_prefs']['useEditor'];
	
	
}

if ($PREFS->showNews==-1) {
	$PREFS->showNews=$CONF['userPrefs']['defaults']['showNews'];
}

if (isset($_REQUEST['updatePrefs1'])) {// submit form 	   		
	$PREFS->themeName= $_POST['PREFS_themeName'];
	$PREFS->itemsPerPage=$_POST['PREFS_itemsPerPage']+0;
	$PREFS->metricSystem=$_POST['PREFS_metricSystem']+0;
	$PREFS->googleMaps=$_POST['PREFS_googleMaps']+0;
	$PREFS->nameOrder=$_POST['PREFS_nameOrder']+0;
	$PREFS->useEditor=$_POST['PREFS_useEditor']+0;
	
	$PREFS->language=$_POST['PREFS_language'];
	$_SESSION["lng"]= $PREFS->language;
	$PREFS->viewCat=$_POST['PREFS_viewCat'];
	$_SESSION["cat"]= $PREFS->viewCat;
	$PREFS->viewCountry=$_POST['PREFS_viewCountry'];
	$_SESSION["country"]= $PREFS->viewCountry;
}

if ( !is_dir(dirname(__FILE__)."/templates/".$PREFS->themeName) || !$PREFS->themeName )
	$PREFS->themeName=$CONF_defaultThemeName;

$PREFS->setToCookie();

$themeRelPath=$moduleRelPath."/templates/".$PREFS->themeName;
$themeAbsPath=dirname(__FILE__)."/templates/".$PREFS->themeName;


	function getRelMainFileName() {
		global $baseInstallationPath, $CONF_mainfile ;		
		return  str_replace('//','/',"/$baseInstallationPath/$CONF_mainfile".CONF_MODULE_ARG);
	}

	function getArgList($str) {
		global  $module_name, $CONF_arg_name;		
		return "?$CONF_arg_name=$module_name$str";	
	}
	
	function getRelMainDir($noLeadingSlash=0,$noTrailingSlash=0) {
		global $baseInstallationPath, $moduleRelPath, $CONF;
		
		// / + modules/leonardo/
		// / + components/com_leonardo/
		// /leonardo + /./
		if ( $CONF['links']['type']==3 ) {
			return $CONF['links']['baseURL'].'/';
		}

		if ( $noLeadingSlash) 
			return str_replace('//','/',"$baseInstallationPath/$moduleRelPath/");
		else 
			return  str_replace('//','/',"/$baseInstallationPath/$moduleRelPath/");
	}

function setLeonardoPaths () {
	global	$baseInstallationPath,$baseInstallationPathSet;
	global 	$module_name,$moduleAbsPath,$moduleRelPath;
	global 	$waypointsRelPath,	$waypointsAbsPath,	$waypointsWebPath;
	global 	$flightsRelPath; 
	global  $CONF_arg_name,$CONF_mainfile,$CONF,$opMode;
	global 	$isExternalFile;


	if (!isset($module_name))  {
		if (isset($_GET[$CONF_arg_name])) $module_name=makeSane($_GET[$CONF_arg_name]);
		else {
			$tmpDir=dirname(__FILE__);
			$tmpParts=split("/",str_replace("\\","/",$tmpDir));
			$module_name=$tmpParts[count($tmpParts)-1]; 
			// $module_name="leonardo";
		}
	}
	
	$moduleRelPath=moduleRelPath($isExternalFile);
	// if ($opMode==3 || $opMode==4) $moduleRelPath="./";



	// detect if the installation in not on the root
	$baseInstallationPath="";
	$moduleRelPathTemp=moduleRelPath(!$isExternalFile);		

	// compute baseInstallationPath
	$parts=explode("/", str_replace($moduleRelPathTemp,'',dirname($_SERVER['SCRIPT_NAME']) )   );	
	// print_r($parts);	
	if ( count($parts)>1 )  {
		for($i=0;$i<count($parts);$i++) 
		   if ($parts[$i]!='') $baseInstallationPath.="/".$parts[$i];	
	}

	if (!defined('CONF_MODULE_ARG') ){
		if ($CONF['links']['type']==3 && $opMode!=2){		
			$preDir=$CONF['links']['baseURL'];
		} else {
			$preDir=$baseInstallationPath;
		}
		$lnk=$preDir.'/'.$CONF_mainfile."?$CONF_arg_name=$module_name";				
		define('CONF_MODULE_ARG',$lnk);
		//	setModuleArg();
	}

	if ( $CONF['links']['type']==3 ) {
		$baseInstallationPath="";
	}
		
if (0) {
	echo "@".substr($_SERVER['SCRIPT_NAME'],0,-$queryLen)."@";
	echo "queryLen : $queryLen#";
	echo "&& _SERVER['SCRIPT_NAME'] : ".$_SERVER['SCRIPT_NAME']."&&";
	echo dirname($_SERVER['SCRIPT_NAME']);
	echo "#moduleRelPath=$moduleRelPath#moduleRelPathTemp=$moduleRelPathTemp#";
	echo "baseInstallationPath=$baseInstallationPath#<BR>";
	echo "CONF_MODULE_ARG=".CONF_MODULE_ARG."<BR>";
}

	$moduleAbsPath=dirname(__FILE__);	
	
	$flightsRelPath="flights";
	$waypointsRelPath="waypoints";

	$waypointsAbsPath=dirname(__FILE__)."/".$waypointsRelPath;
	$waypointsWebPath=$moduleRelPath."/".$waypointsRelPath;

	$flightsAbsPath=dirname(__FILE__)."/".$flightsRelPath;
	// $flightsWebPath=$moduleRelPath."/".$flightsRelPath;

}

define('SYNC_INSERT_FLIGHT_LINK',1);
define('SYNC_INSERT_FLIGHT_LOCAL',2);

define('SYNC_INSERT_FLIGHT_REPROCESS_LOCALLY',64);

define('SYNC_INSERT_PILOT_LINK',4);
define('SYNC_INSERT_PILOT_LOCAL',8); 

define('SYNC_INSERT_WAYPOINT_LINK',16);
define('SYNC_INSERT_WAYPOINT_LOCAL',32);


if (!function_exists('str_ireplace')) {
    function str_ireplace($needle, $str, $haystack) {
        $needle = preg_quote($needle, '/');
        return preg_replace("/$needle/i", $str, $haystack);
    }
} 

//$CONF['sprites']

// list of takeoffs that will make all flights from them PRIVATE!
$CONF['takeoffs']['private']=array() ;

if ($db) {
	$db->sql_query("set sql_mode = ''");
}

?>
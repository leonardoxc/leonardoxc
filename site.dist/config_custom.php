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
// $Id: config_custom.php,v 1.10 2010/04/07 13:08:54 manolis Exp $                                                                 
//
//************************************************************************


 // Here we define which server Id is the master server of the leonardo Network
 $CONF_master_server_id=1;

 // Our server ID -> usually 0 for non network operation
 // Contact me at manolis@andreadakis.gr to assign you an offcial leonardo ID
 $CONF_server_id=999;
 
 // various display parameters
 $CONF['display']['blocks']['right_side']=1;

 
 // if it is a phpbb module we can use our own template 
 // and not the onw of the forum 
 $CONF_use_own_template=1;
 

 // for phpbb when  $CONF_use_own_template=1;
 $CONF_use_own_login=1;
 
  // rely on  leonardo_pilots name fields  entirely
 $CONF_use_leonardo_names=1;
 


 $CONF_main_page="index_full";

 
 //$CONF_main_page="list_takeoffs";
 //$CONF['custom_top_menu']='SITES';

 // use utf language files 
 $CONF_use_utf= 1;

 // the native language of the server
 $nativeLanguage="english";
 
 // if you intend to use google maps API to display fancy maps of takeoffs 
 // get one key for your server at 
 // http://www.google.com/apis/maps/signup.html
 // else leave it blank
 $CONF_google_maps_api_key="";

	
 // If you have a waypoint database that has names in another language
 // than english but you want to diplay waypoint names in english 
 // set this to 1 to force that
 // if you have $nativeLanguage="english"; you will most probably want to
 // set it to 1 , else set it to 0
 $CONFIG_forceIntl=0;

 // set to 1 if you have an map server running
 // set to 0 if you dont know what a map server is ...
 // ... but you will not have the track plotted on the map 
 $mapServerActive=0;

 // use  DEM for ground elevation in the altitude graph
 $CONF['maps']['3d']=1;

 // Use google maps to display flight track ( needs a google maps key : see above  $CONF_google_maps_api_key )
 $CONF_google_maps_track=1;
 $CONF_google_maps_track_order=1; // will apear in the first tab
 $CONF_google_maps_track_only=0;  // use only google maps,  discard the local map server

 $CONF['google_maps']['default_maptype']='G_PHYSICAL_MAP';

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
 $CONF_use_validation=0;
 $CONF_use_custom_validation=0;
 $CONF['validation']['user_internal_server']=1;
 $CONF['validation']['server_url']="http://".$_SERVER['SERVER_NAME'].getRelMainDir()."server/validate/validate.php";  
 
 // set this to 0 if you dont want to give the functionality of OLC submits
 // OLC scoring will be done even if you set this to 0. 
 // set $scoringServerActive=0 to disable the scoring.
 $enablePrivateFlights=1;

 // Mrsid tiles config
 $maxMrSidResolution=28.5; // m/pixel Smaller is better.
 $minMrSidResolution=28.5; // m/pixel

 // ------------------------
 //  various config
 // ------------------------
 $takeoffRadious= 500 ; // in m
 $landingRadious= 1000 ; // in m
 $CONF_itemsPerPage=50 ;
 $CONF_compItemsPerPage=25;
 $CONF_defaultThemeName="basic";
 $CONF_metricSystem=1; //  1=km,m     2=miles,feet


 
 // Debug leave it 0
 $CONF_show_DBG_XML=0;

 $CONF_countHowManyFlightsInComp=6;

 $CONF_showProfilesToGuests=1;

 // Max is 6 
 $CONF_photosPerFlight=10;
 
 // Available Types and subtypes of Gliders
 $CONF_glider_types=array(1=>"Paraglider",2=>"Flex wing FAI1",4=>"Rigid wind FAI5",8=>"Glider",
				16=>"Paramotor", 64=>"Powered flight" );
// $CONF_glider_types=array(1=>"Paraglider");
 $CONF_default_cat_view=0; // pg
 $CONF_default_cat_add=1; //  the default category for submitting new flights 

 // The top 'dates' menu  will have years starting from $CONF_StartYear
 // Deprecated -  not use it anywherenow
 $CONF_StartYear=2007;

 // you should probably set  $OLCScoringServerPath to the same server 
 // you have leonardo
 $OLCScoringServerUseInternal=1;
 $OLCScoringServerPath="http://".$_SERVER['SERVER_NAME'].getRelMainDir()."server/scoreOLC.php";
 $OLCScoringServerPassword="mypasswd";


 // 2007/03/07 ADDED
 
 // flights that were submitted these days ago will have a "new" icon
 // set to -1 to disable
 $CONF_new_flights_days_threshold=7;

 // Added 08.05.2007
 // Flight upload time limit in days
 // if <=0 limit checking is turned off
 $CONF_new_flights_submit_window=0;

 // Added 30.05.2007
 // max time gap in track in secs
 $CONF_max_allowed_time_gap=900;

 // Membership of NAC (National Airsport Control, also referred as National Aero Club)
 
 // sample of national clubs 
 $CONF_NAC_list=array();

 /*
 $CONF_NAC_list=array(
	1=>array(
		 'id'=>1,
		 'name'=>'DHV',
		 'localName'=>'DHV',
		 'localLanguage'=>'german',
		 'periodIsNormal'=>0 , // if league period doesnt start on 1/1 then =>0
		 'periodStart'=>"-10-01",	
		 'memberIDpublic'=>0,  // dont show member ID to others
		 
		 "external_input"=>1, // turning on/off the external input
         'external_fields'=>'NACmemberID,LastName,FirstName', //these fields will be set by the external tool
         
		  "input_url"=>getRelMainDir()."/site/NAC_1_enter_id.php?id=check_membership&callingfield=NACmemberID",
		 // or an external URL

		 // Use the NAC clubs. A pilot can be member only to one NAC club.
		"use_clubs"=>1,

		 // While this flag is 1 the pilots are allowd to change their club membership
		 // the admin must set this to 0 to finalise the memberships for the period.
		"club_change_period_active"=>1,
		
		 // While this flag is 1 the pilots are allowed to add themsleves as members of a club
		 // IF they havent done it before.
		 // the admin must set this to 0 when he wishes to stop pilots registering for clubs.
		 "add_to_club_period_active"=>1,
		 "current_year"=>2008,
	)	,
   24=>array(
    	'id'=>24,
		'name'=>'OeAeC',
		'localName'=>'OeAeC',
		'localLanguage'=>'german',
		'periodIsNormal'=>0 , // if league period doesnt start on 1/1 then =>0
		'periodStart'=>"-10-1",
		'memberIDpublic'=>0,  // dont show member ID to others
         //"id_input_method"=>"external", // not needed! 
		"external_input"=>0, // turning on/off the external input
		'external_fields'=>'',
		'input_url'=>'',

		// Use the NAC clubs. A pilot can be member only to one NAC club.
		"use_clubs"=>1,

		// While this flag is 1 the pilots are allowd to change their club membership
		// the admin must set this to 0 to finalise the memberships for the period.
		"club_change_period_active"=>1,

		// While this flag is 1 the pilots are allowed to add themsleves as members of a club
		// IF they havent done it before.
		// the admin must set this to 0 when he wishes to stop pilots registering for clubs.
		"add_to_club_period_active"=>1,
		"current_year"=>2009
	)					
 );
 */
 
 $CONF_use_NAC=0; 
 // use  $CONF_use_NAC=1; to actiave national clubs
 

/**
 * Martin Jursa 26.04.2007: Options for editing login data in pilot_profile_edit
 */
 // The following will allow changing the password in pilot_profile_edit
 $CONF_edit_login=1;
 // $CONF_edit_email lets you edit the email directly;
 // only effective if $CONF_edit_login!=0
 $CONF_edit_email=1;
/** End 26.4.2007 */



 // this will allow the use of pre-calculated turnpoints for OLC score optimization
 // This is done by uploading an .OLC file
 $CONF_allow_olc_files=1;
 
 // this will allow an external program  (maxpunkte) to upload a flight to this server.
 // the program must post a form to http://serveraddess/modules/leonardo/flight_submit.php
 // it works even if the  $CONF_allow_olc_files is set to 0 (server optimization is done instead  )
 $CONF_allow_direct_upload=1;
 
  // this will enable a calnder in flights_list to select individual days
 $CONF_use_calendar=1;
 
 // USE airspace checking
 $CONF_airspaceChecks=0; 

  // use htc files for ie mouse over TR elements
  // May not work on servers behind firewalls
  $CONF_use_htc_ie_hack=1;

  //  $CONF['list_flights']['fields']['scoring'][0]='SCORE_SPEED'; // LINEAR_DISTANCE or SCORE_SPEED
  
  $CONF['list_flights']['fields']['scoring'][0]='LINEAR_DISTANCE'; // LINEAR_DISTANCE or SCORE_SPEED
  
// SEASON MOD

	$CONF['years']=array(
		'use_calendar_years'=>1,
		'start_year'=>1998,
		'end_year'=>date("Y")
	);

	$CONF['seasons']['use_season_years']=1;	

	
	// IF this is set then all info on which sesons to display in hte menu
	//     will be taken forh the $CONF['seasons']['seasons']
	// ELSE 
	//    the menu will display season starting from $CONF['seasons']['start_season'] to $CONF['seasons']['end_season']
	//    BOTH VALUES MUST BE defined
	//    In this case also the season start/end will be defined from 
	//    $CONF['seasons']['season_default_start'] and $CONF['seasons']['season_default_end']	
	$CONF['seasons']['use_defined_seasons']=1;

	// Defined seasons
	// The next array will be used in case of 	$CONF['seasons']['show_only_defined_seasons']=1
	$CONF['seasons']['seasons']=array(		
		2008=>array('start'=>'2007-10-1','end'=>'2008-9-30'),
		2007=>array('start'=>'2006-10-1','end'=>'2007-9-30'),
	
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

	$CONF['seasons']['start_season']=2007;
	$CONF['seasons']['end_season']= dates::getCurrentSeason(0);

 // end of seasons config

 // start of BRANDS MOD
	$CONF['brands']['filter_brands'] = 1;
	$CONF['brands']['showAll']=1;
	$CONF['brands']['list']=array();
	$CONF['brands']['filterList']=array(1,2,4);

	// use a WYSIWYG editor for editing takeoff information
    $CONF['editor']['use_wysiwyg']['global']=1;
	$CONF['editor']['use_wysiwyg']['takeoff_description']=1;
	$CONF['editor']['use_wysiwyg']['flight_comments']=1;

	// for custom code to put on bottom of page , ie google analitics ...
	$CONF['footer']['custom_code']='';
	
/* 
	http://github.com/twpayne/igc2kmz/wikis/home
	
	1) make a dir in lib/ called igc2kmz/ 
		and do a 
	   git clone git://github.com/twpayne/igc2kmz.git
		to get it the first time or 
	   git pull 
	   to get the latest version
		
	2)	Install the python module SQLAlchemy (http://www.sqlalchemy.org/) and the
		 	Python MySQL bindings (http://sourceforge.net/projects/mysql-python) on the server.
*/ 

	$CONF['googleEarth']['igc2kmz']['active']	=true;
	$CONF['googleEarth']['igc2kmz']['visible'] = true;
	$CONF['googleEarth']['igc2kmz']['version']	= 1.01;
	$CONF['googleEarth']['igc2kmz']['python'] = '/usr/local/bin/python2.5';
	// for windows ...
	// $CONF['googleEarth']['igc2kmz']['python'] = 'c:\python25\python.exe';
	$CONF['googleEarth']['igc2kmz']['path']=dirname(__FILE__).'/../lib/igc2kmz';


	$CONF['mail']['method']='php'; //  use the php  mail() function
	/*
	$CONF['mail']['method']='smtp';  // use an external mail server ,
	
	$CONF['mail']['smtp']['port']=25;
	$CONF['mail']['smtp']['ssl']=false;
	

	$CONF['mail']['smtp']['host']='hostname_of_mail_server';
	$CONF['mail']['smtp']['username']='mailserver_username';
	$CONF['mail']['smtp']['password']='mailserver_password';
	*/
	
	$CONF['site']['name']="LeonardoXC";
	
	// this forces the use of CIVL ID
	$CONF_force_civlid=false;
	
	// display also the thermals DB in flight's display page
	$CONF['thermals']['enable']=false;

	//
	$CONF_require_glider=1;
	$CONF_addflight_js_validation=1;
	

	// not used any more, see just below
	//$CONF_category_types =array(1=>"Sport",2=>"Open",3=>"Tandem",4=>"Fun Cup");
	//$gliderClassList=$CONF_category_types;

	// you can override the categories here!
	$CONF['gliderClasses']=array(
		// pg
		1=>array( 
			'default_class'=>2,
			'classes'=>array(1=>"Sport",2=>"Open",3=>"Tandem",4=>"Fun Cup"),		
		),
		2=>array( 
			'default_class'=>2,
			'classes'=>array(1=>"Kingpost",2=>"Topless"),
		),
 	);	
 
	
	$CONF_glider_certification_categories =array(
 		1=>"LTF 1",2=>"LTF 1/2",
		4=>"LFT 2", 8=>"LFT 2/3" , 16=>"LFT 3" , 
		32=>"EN A", 64=>"EN B" , 128=>"EN C" , 256=>"EN D" ,
 		1024=>"Proto");
	
   $CONF_cert_avalable_categories=array(
	0=>array(1,2,3,4), // ALL
 	1=>array(1,2,3,4), // ltf 1
 	2=>array(1,2,3),   // LTF 1/2
 	4=>array(1,2,3),   // LTF 2
 	8=>array(2,3),     // LTF 2/3
 	16=>array(2,3),    // LTF 3

 	32=>array(1,2,3,4), //en A
 	64=>array(1,2,3),   //en B
 	128=>array(2,3),    //en C
 	256=>array(2,3),    //EN D
 	1024=>array(2,3),   // PROTO
  );
 
 
// Manolis 09.12.2009
// NEW config variables 
$CONF['airspace']['zoom']=100; // show a bit % more of the airspace  - good value is 102 (means 102%)

// Define the version of flights data scheme
// the default old one of flights/ dir is version 1

// USE this if you still have the flights on flights/ folder
$CONF['paths']=$CONF['paths_versions'][1];
// !!!! USE THIS ONLY AFTER YOU HAVE MIGRATED ALL FILES TO NEW POSITIONS !!!!
// $CONF['paths']=$CONF['paths_versions'][2];

// Set this to 1 if on search pilot you always get "Access denied"
$CONF['bugs']['badSessions']=0;

// define areas for google maps db browser
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

// The readonly fields on profile edit page
$CONF['profile']['edit']['readonlyFields']=array(); 
// $CONF['profile']['edit']['readonlyFields']=array('LastName', 'FirstName');

$CONF['profile']['edit']['force_civl_id']=false; 

?>
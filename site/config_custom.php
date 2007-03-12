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

 // Here we define which server Id is the master server of the leonardo Network
 $CONF_master_server_id=1;

 // Our server ID -> usually 0 for non network operation
 $CONF_server_id=0;
 
 // if it is a phpbb module we can use our own template 
 // and not the onw of the forum 
 $CONF_use_own_template=1;
 
 // for phpbb when  $CONF_use_own_template=1;
 $CONF_use_own_login=1;
 
  // rely on  leonardo_pilits name flields  entirely
 $CONF_use_leonardo_names=1;
 
 // mod_users 
 // put in this array the userID of the users you want ot grand mod status
 // You can leave this blank
 $mod_users=array();

 $CONF_main_page="index_full";


 // the native language of the server
 $nativeLanguage="english";
 
 // if you intend to use google maps API to display fancy maps of takeoffs 
 // get one key for your server at 
 // http://www.google.com/apis/maps/signup.html
 // else leave it blank
 $CONF_google_maps_api_key="";
 if ($_SERVER['SERVER_NAME']=='pgforum.thenet.gr') 
 	$CONF_google_maps_api_key="ABQIAAAAX8dZ6sFifmmWXGOjKHGxPhTjzsUiTe7EptkEoRMcB5oNJjdn9BRtnm44EUCFh4qu4TVmu34mpoR-Wg";
 else if ($_SERVER['SERVER_NAME']=='pgforum.home') 
	$CONF_google_maps_api_key="ABQIAAAAg1o4ozR4NUEP6EDKiQZQ8BReKpwmJUF9SRfvHw89FQlWBLDdWBRvaCZXB3H2e8Qqb1i64X_5ypyNFQ";
 
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

 // Use google maps to display flight track ( needs a google maps key : see above  $CONF_google_maps_api_key )
 $CONF_google_maps_track=0;
 $CONF_google_maps_track_order=1; // will apear in the second tab
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
 $CONF_use_custom_validation=1;
 $CONF_validation_server_url="http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/modules/".$module_name."/server/validate/validate.php";
  

 
 // set this to 0 if you dont want to give the functionality of OLC submits
 // OLC scoring will be done even if you set this to 0. 
 // set $scoringServerActive=0 to disable the scoring.
 $enablePrivateFlights=1;

 $CONF_phpbb_realname_field="username";
 // if you are running phpbb2 with the realanme mod , uncomment this instead
 // $CONF_phpbb_realname_field="user_realname";
 
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

 // Max is 6 
 $CONF_photosPerFlight=6;
 
 // Available Types and subtypes of Gliders
 $CONF_glider_types=array(1=>"Paraglider",2=>"Flex wing FAI1",4=>"Rigid wind FAI5",8=>"Glider",
				16=>"Paramotor", 64=>"Powered flight" );
// $CONF_glider_types=array(1=>"Paraglider");
 $CONF_default_cat_view=0; // pg
 $CONF_default_cat_add=1; //  the default category for submitting new flights 

 // The top 'dates' menu  will have years starting from $CONF_StartYear
 $CONF_StartYear=2007;

 // you should probably set  $OLCScoringServerPath to the same server 
 // you have leonardo
 $OLCScoringServerPath="http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/modules/".$module_name."/server/scoreOLC.php";
 $OLCScoringServerPassword="mypasswd";
 
 
 // 2007/03/07 ADDED
 
 // flights that were submitted these days ago will have a "new" icon
 // set to -1 to disable
 $CONF_new_flights_days_threshold=-1;


 // Membership of NAC (National Airsport Control, also referred as National Aero Club)
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
         
		  "input_url"=>"/modules/leonardo/site/NAC_1_enter_id.php?id=check_membership&callingfield=NACmemberID",
		 // use this for production 
		 // 'input_url'=>'/admin/odb/page.php?id=check_membership&field_mgnr=NACmemberID&field_name=LastName&field_vorname=FirstName',		 


		 // Use the NAC clubs. A pilot can be member only to one NAC club.
		"use_clubs"=>1,

		 // While this flag is 1 the pilots are allowd to change their club membership
		 // the admin must set this to 0 to finalise the memberships for the period.
		"club_change_period_active"=>1,
		
		 // While this flag is 1 the pilots are allowed to add themsleves as members of a club
		 // IF they havent done it before.
		 // the admin must set this to 0 when he wishes to stop pilots registering for clubs.
		 "add_to_club_period_active"=>1,
		 "current_year"=>2007,
	)	,
   2=>array(
    	'id'=>2,
		'name'=>'OeAeC',
		'localName'=>'OeAeC',
		'localLanguage'=>'german',
		'periodIsNormal'=>0 , // if league period doesnt start on 1/1 then =>0
		'periodStart'=>"-10-1",
		'memberIDpublic'=>0,  // dont show member ID to others
         /*"id_input_method"=>"external", // not needed! */
		"external_input"=>0, // turning on/off the external input
		'external_fields'=>'',
		'input_url'=>'',

		// Use the NAC clubs. A pilot can be member only to one NAC club.
		"use_clubs"=>0,

		// While this flag is 1 the pilots are allowd to change their club membership
		// the admin must set this to 0 to finalise the memberships for the period.
		"club_change_period_active"=>1,

		// While this flag is 1 the pilots are allowed to add themsleves as members of a club
		// IF they havent done it before.
		// the admin must set this to 0 when he wishes to stop pilots registering for clubs.
		"add_to_club_period_active"=>1,
		"current_year"=>2007
	)					
 );
 $CONF_use_NAC=1; 
 

 
?>
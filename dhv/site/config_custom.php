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

 // USE airspace checking
 $CONF_airspaceChecks=1;

 // mod_users
 // put in this array the userID of the users you want ot grand mod status
 // You can leave this blank
 $mod_users=array();

 $CONF_main_page="list_flights";

// The top 'dates' menu  will have years starting from $CONF_StartYear
 $CONF_StartYear=2007;

 // the native language of the server
 $nativeLanguage="german";

 // if you intend to use google maps API to display fancy maps of takeoffs
 // get one key for your server at
 // http://www.google.com/apis/maps/signup.html
 // else leave it blank
 $CONF_google_maps_api_key="ABQIAAAABX9AOB9vNKZLoyxwjtNb2BQbWXgff5VVL03ZCCz2OD-yObccYhTUr8XkBUqjpl8L2B2j34dRIH3CWg";

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
 $CONF_google_maps_track=1;
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

  // rely on  leonardo_pilits name flields  entirely
 $CONF_use_leonardo_names=1;



 // set this to 0 if you dont want to give the functionality of OLC submits
 // OLC scoring will be done even if you set this to 0.
 // set $scoringServerActive=0 to disable the scoring.
 $enableOLCsubmission=0;

 // validate against the G-record
 $CONF_use_validation=1;
 $CONF_use_custom_validation=1;
 // $CONF_valdation_server_url="http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/modules/".$module_name."/server/validate.php";


 // set this to 0 if you dont want to give the functionality of OLC submits
 // OLC scoring will be done even if you set this to 0.
 // set $scoringServerActive=0 to disable the scoring.
 $enablePrivateFlights=0;

 // for phpbb when $CONF_use_own_template=1;
 $CONF_use_own_login=1;


 // Membership of NAC (National Airsport Control, also referred as National Aero Club)
// $CONF_NAC_list=array(
// 	1=>array('name'=>'DHV', 'id_input_method'=>'external', 'input_url'=>'/admin/odb/page.php?id=check_membership&field_mgnr=NACmemberID&field_name=LastName&field_vorname=FirstName') /*,
// 	2=>array('name'=>'OeAeC', 'id_input_method'=>'internal')*/
// );

  // 2007/03/07 ADDED

 // flights that were submitted these days ago will have a "new" icon
 // set to -1 to disable
 $CONF_new_flights_days_threshold=-1;

 // Added 08.05.2007
 // Flight upload time limit in days
 // if <=0 limit checking is turned off
 $CONF_new_flights_submit_window=14;

 // Added 30.05.2007
 // max time gap in track
 $CONF_max_allowed_time_gap=900;


 // Membership of NAC (National Airsport Control, also referred as National Aero Club)

 #         'input_url'=>'/admin/odb/page.php?id=check_membership&field_mgnr=NACmemberID&field_name=LastName&field_vorname=FirstName',

 $CONF_NAC_list=array(
    1=>array(
         'id'=>1,
         'name'=>'DHV',
         'localName'=>'DHV',
         'localLanguage'=>'german',
         'periodIsNormal'=>0 , // if league period doesnt start on 1/1 then =>0
         'periodStart'=>"-10-1",
         'memberIDpublic'=>0,  // dont show member ID to others
         /*"id_input_method"=>"external", // not needed! */
         "external_input"=>1, // turning on/off the external input
         'external_fields'=>'NACmemberID,LastName,FirstName,Sex,Birthdate,countriesList', //these fields will be set by the external tool
         'input_url'=>'/admin/odb/page.php?id=check_membership&field_memberid=NACmemberID&field_lastname=LastName&field_firstname=FirstName&field_birthday=Birthdate&field_sex=Sex&field_country=countriesList',

          // use this for production
          // "input_url"=>"/modules/leonardo/site/NAC_1_enter_id.php?id=check_membership&callingfield=NACmemberID",

         // Use the NAC clubs. A pilot can be member only to one NAC club.
        "use_clubs"=>1,

         // While this flag is 1 the pilots are allowd to change their club membership
         // the admin must set this to 0 to finalise the memberships for the period.
        "club_change_period_active"=>1,

         // While this flag is 1 the pilots are allowed to add themsleves as members of a club
         // IF they havent done it before.
         // the admin must set this to 0 when he wishes to stop pilots registering for clubs.
         "add_to_club_period_active"=>1,
         "current_year"=>2007
    ),
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

		// use this for production
		// "input_url"=>"/modules/leonardo/site/NAC_1_enter_id.php?id=check_membership&callingfield=NACmemberID",

		// Use the NAC clubs. A pilot can be member only to one NAC club.
		"use_clubs"=>1,

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

 // this one is just for testing
 //"input_url"=>"/modules/leonardo/site/NAC_1_enter_id.php?id=check_membership&callingfield=NACmemberID",
 // comment the one above and uncooment this for production
 //

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
 // the program must post a form to
 //http://xc.dhv.de/modules/leonardo/flight_submit.php
 // it works even if the  $CONF_allow_olc_files is set to 0 (server optimization is done instead  )
 $CONF_allow_direct_upload=1;

  // this will enable a calnder in flights_list to select individual days
 $CONF_use_calendar=1;

 $CONF_phpbb_realname_field="username";
 // if you are running phpbb2 with the realanme mod , uncomment this instead
 // $CONF_phpbb_realname_field="user_realname";

 // Mrsid tiles config
 $maxMrSidResolution=14.25; // m/pixel Smaller is better.
 $minMrSidResolution=456; // m/pixel

 // ------------------------
 //  various config
 // ------------------------
 $takeoffRadious= 1500 ; // in m
 $landingRadious= 1000 ; // in m
 $CONF_itemsPerPage=50 ;
 $CONF_compItemsPerPage=250;
 $CONF_defaultThemeName="basic";
 $CONF_metricSystem=1; //  1=km,m     2=miles,feet

 // Debug leave it 0
 $CONF_show_DBG_XML=1;

 $CONF_countHowManyFlightsInComp=6;

 $CONF_showProfilesToGuests=1;

 // Max is 6
 $CONF_photosPerFlight=6;

 // Available Types and subtypes of Gliders
 $CONF_glider_types=array(1=>"Paraglider",2=>"Flex wing FAI1",4=>"Rigid wind FAI5");
//,8=>"Glider",				16=>"Paramotor", 64=>"Powered flight"
// $CONF_glider_types=array(1=>"Paraglider");
 $CONF_default_cat_view=0; // pg
 $CONF_default_cat_add=1; //  the default category for submitting new flights

 // you should probably set  $OLCScoringServerPath to the same server
 // you have leonardo
 $OLCScoringServerPath="http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/modules/".$module_name."/server/scoreOLC.php";
 $OLCScoringServerPassword="mypasswd";

?>
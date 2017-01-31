<?php

/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://leonardo.thenet.gr                                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/*                                                                      */
/* If you need to use double quotes (") remember to add a backslash (\),*/
/* so your entry will look like: This is \"double quoted\" text.        */
/* And, if you use HTML code, please double check it.                   */
/************************************************************************/

function setMonths() {
	global  $monthList,	$monthListShort, $weekdaysList;
	$monthList=array('January','February','March','April','May','June',
					'July','August','September','October','November','December');
	$monthListShort=array('JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC');
	$weekdaysList=array('Mon','Tue','Wed','Thu','Fri','Sat','Sun') ;
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","Free Flight");
define("_FREE_TRIANGLE","Free Triangle");
define("_FAI_TRIANGLE","FAI Triangle");

define("_SUBMIT_FLIGHT_ERROR","There was a problem submitting the flight");

// list_pilots()
define("_NUM","#");
define("_PILOT","Pilot");
define("_NUMBER_OF_FLIGHTS","Number of flights");
define("_BEST_DISTANCE","Best Distance");
define("_MEAN_KM","Mean # km per flight");
define("_TOTAL_KM","Total flight km");
define("_TOTAL_DURATION_OF_FLIGHTS","Total flight duration");
define("_MEAN_DURATION","Mean flight duration");
define("_TOTAL_OLC_KM","Total XC distance");
define("_TOTAL_OLC_SCORE","Total XC scoring");
define("_BEST_OLC_SCORE","Best XC score");
define("_From","from");

// list_flights()
define("_DURATION_HOURS_MIN","Dur (h:m)");
define("_SHOW","Display");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","The flight will be activated in 1-2 minutes. ");
define("_TRY_AGAIN","Please try again later");
define("_SEASON","Season");
define("_TAKEOFF_LOCATION","Takeoff");
define("_TAKEOFF_TIME","Takeoff time");
define("_LANDING_LOCATION","Landing");
define("_LANDING_TIME","Landing Time");
define("_OPEN_DISTANCE","Linear distance");
define("_MAX_DISTANCE","Max Distance");
define("_OLC_SCORE_TYPE","XC score type");
define("_OLC_DISTANCE","XC Distance");
define("_OLC_SCORING","XC score");
define("_MAX_SPEED","Max speed");
define("_MAX_VARIO","Max vario");
define("_MEAN_SPEED","Mean speed");
define("_MIN_VARIO","Min vario");
define("_MAX_ALTITUDE","Max alt (ASL)");
define("_TAKEOFF_ALTITUDE","Takeoff alt (ASL)");
define("_MIN_ALTITUDE","Min alt (ASL)");
define("_ALTITUDE_GAIN","Altitude gain");
define("_FLIGHT_FILE","Flight file");
define("_COMMENTS","Comments");
define("_RELEVANT_PAGE","Relevant page URL");
define("_GLIDER","Glider");
define("_PHOTOS","Photos");
define("_MORE_INFO","Extras");
define("_UPDATE_DATA","Update data");
define("_UPDATE_MAP","Update map");
define("_UPDATE_3D_MAP","Update 3D map");
define("_UPDATE_GRAPHS","Update charts");
define("_UPDATE_SCORE","Update scoring");

define("_TAKEOFF_COORDS","Takeoff coordinates:");
define("_NO_KNOWN_LOCATIONS","There are no known locations!");
define("_FLYING_AREA_INFO","Flying area info");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo XC");
define("_RETURN_TO_TOP","Return to top");
// list flight
define("_PILOT_FLIGHTS","Pilot's Flights");

define("_DATE_SORT","Date");
define("_PILOT_NAME","Pilot's Name");
define("_TAKEOFF","Takeoff");
define("_DURATION","Duration");
define("_LINEAR_DISTANCE","Open Distance");
define("_OLC_KM","XC km");
define("_OLC_SCORE","XC score");
define("_DATE_ADDED","Latest submissions");

define("_SORTED_BY","Sort by:");
define("_ALL_YEARS","All years");
define("_SELECT_YEAR_MONTH","Select year (and month)");
define("_ALL","All");
define("_ALL_PILOTS","Show all the pilots");
define("_ALL_TAKEOFFS","Show all the takeoffs");
define("_ALL_THE_YEAR","All the year");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","You have not supplied a flight file");
define("_NO_SUCH_FILE","The file you supplied cannont be found on the server");
define("_FILE_DOESNT_END_IN_IGC","The file does not have an .igc suffix");
define("_THIS_ISNT_A_VALID_IGC_FILE","This is not a valid .igc file");
define("_THERE_IS_SAME_DATE_FLIGHT","There is already a flight with the same date and time");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","If you wish to replace it you should first");
define("_DELETE_THE_OLD_ONE","delete the old one");
define("_THERE_IS_SAME_FILENAME_FLIGHT","There is already a flight with the same filename");
define("_CHANGE_THE_FILENAME","If this flight is a different one please change the filename and try again");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","Your flight has been submitted");
define("_PRESS_HERE_TO_VIEW_IT","Press here to view it");
define("_WILL_BE_ACTIVATED_SOON","(it will be activated in 1-2 minutes)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Submit multiple flights");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","Only the IGC files will be processed");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","Submit the ZIP file<br>containing the flights");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","Press here to submit the flights");

define("_FILE_DOESNT_END_IN_ZIP","The file you submitted doesnt have a .zip suffix");
define("_ADDING_FILE","Submiting file");
define("_ADDED_SUCESSFULLY","Submited sucessfully");
define("_PROBLEM","Problem");
define("_TOTAL","Total of ");
define("_IGC_FILES_PROCESSED","flights have been processed");
define("_IGC_FILES_SUBMITED","flights have been submited");

// info
define("_DEVELOPMENT","Development");
define("_ANDREADAKIS_MANOLIS","Andreadakis Manolis");
define("_PROJECT_URL","Project page");
define("_VERSION","Version");
define("_MAP_CREATION","Map creation");
define("_PROJECT_INFO","Project Info");

// menu bar 
define("_MENU_MAIN_MENU","Main Menu");
define("_MENU_DATE","Select Date");
define("_MENU_COUNTRY","Select Country");
define("_MENU_XCLEAGUE","XC League");
define("_MENU_ADMIN","Admin");

define("_MENU_COMPETITION_LEAGUE","League - all categories");
define("_MENU_OLC","XC");
define("_MENU_OPEN_DISTANCE","Open Distance");
define("_MENU_DURATION","Duration");
define("_MENU_ALL_FLIGHTS","Show all flights");
define("_MENU_FLIGHTS","Flights");
define("_MENU_TAKEOFFS","Takeoffs");
define("_MENU_FILTER","Filter");
define("_MENU_MY_FLIGHTS","My flights");
define("_MENU_MY_PROFILE","My profile");
define("_MENU_MY_STATS","My stats"); 
define("_MENU_MY_SETTINGS","My settings"); 
define("_MENU_SUBMIT_FLIGHT","Submit flight");
define("_MENU_SUBMIT_FROM_ZIP","Submit flights from zip");
define("_MENU_SHOW_PILOTS","Pilots");
define("_MENU_SHOW_LAST_ADDED","Show latest submissions");
define("_FLIGHTS_STATS","Flights Stats");

define("_SELECT_YEAR","Select year");
define("_SELECT_MONTH","Select month");
define("_ALL_COUNTRIES","Show all countries");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","ALL TIMES");
define("_NUMBER_OF_FLIGHTS","Number of flights");
define("_TOTAL_DISTANCE","Total distance");
define("_TOTAL_DURATION","Total duration");
define("_BEST_OPEN_DISTANCE","Best distance");
define("_TOTAL_OLC_DISTANCE","Total XC distance");
define("_TOTAL_OLC_SCORE","Total XC score");
define("_BEST_OLC_SCORE","Best XC score");
define("_MEAN_DURATION","Mean duration");
define("_MEAN_DISTANCE","Mean distance");
define("_PILOT_STATISTICS_SORT_BY","Pilots - Sort by");
define("_CATEGORY_FLIGHT_NUMBER","Category 'FastJoe' - Number of flights");
define("_CATEGORY_TOTAL_DURATION","Category 'DURACELL' - Total duration of flights");
define("_CATEGORY_OPEN_DISTANCE","Category 'Open Distance'");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","There are no pilots to display!");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","The flight has been deleted");
define("_RETURN","Return");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","CAUTION - You are about to delete this flight");
define("_THE_DATE","Date ");
define("_YES","YES");
define("_NO","NO");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","League results");
define("_N_BEST_FLIGHTS"," best flights");
define("_OLC","XC");
define("_OLC_TOTAL_SCORE","XC total score");
define("_KILOMETERS","Kilometers");
define("_TOTAL_ALTITUDE_GAIN","Total altitude gain");
define("_TOTAL_KM","Total km");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","is");
define("_IS_NOT","is not");
define("_OR","or");
define("_AND","and");
define("_FILTER_PAGE_TITLE","Filter flights");
define("_RETURN_TO_FLIGHTS","Return to flights");
define("_THE_FILTER_IS_ACTIVE","The filter is active");
define("_THE_FILTER_IS_INACTIVE","The filter is inactive");
define("_SELECT_DATE","Select date");
define("_SHOW_FLIGHTS","Display flights");
define("_ALL2","ALL");
define("_WITH_YEAR","With year");
define("_MONTH","Month");
define("_YEAR","Year");
define("_FROM","From");
define("_from","from");
define("_TO","To");
define("_SELECT_PILOT","Select Pilot");
define("_THE_PILOT","The pilot");
define("_THE_TAKEOFF","The takeoff");
define("_SELECT_TAKEOFF","Select Takeoff");
define("_THE_COUNTRY","The country");
define("_COUNTRY","Country");
define("_SELECT_COUNTRY","Select Country");
define("_OTHER_FILTERS","Other Filters");
define("_LINEAR_DISTANCE_SHOULD_BE","The linear distance should be");
define("_OLC_DISTANCE_SHOULD_BE","The XC distance should be");
define("_OLC_SCORE_SHOULD_BE","The XC score should be");
define("_DURATION_SHOULD_BE","The duration should be");
define("_ACTIVATE_CHANGE_FILTER","Activate / change FILTER");
define("_DEACTIVATE_FILTER","Deactivate FILTER");
define("_HOURS","hours");
define("_MINUTES","min");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","Submit flight");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(only the IGC file is  needed)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","Submit the<br>IGC file of the flight");
define("_NOTE_TAKEOFF_NAME","Please note the takeoff name location and country");
define("_COMMENTS_FOR_THE_FLIGHT","Comments for the flight");
define("_PHOTO","Photo");
define("_PHOTOS_GUIDELINES","Photos should be in jpg format and smaller than ");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","Press here to submit the flight");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","Do you want to submit many flights at once ?");
define("_PRESS_HERE","Click here");

define("_IS_PRIVATE","Dont show public");
define("_MAKE_THIS_FLIGHT_PRIVATE","Dont show public");
define("_INSERT_FLIGHT_AS_USER_ID","Insert flight as user ID");
define("_FLIGHT_IS_PRIVATE","This flight is private");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","Change flight data");
define("_IGC_FILE_OF_THE_FLIGHT","IGC file of the flight");
define("_DELETE_PHOTO","Delete");
define("_NEW_PHOTO","new photo");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","Press here to change the flight's data");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","The changes have been applied");
define("_RETURN_TO_FLIGHT","Return to flight");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","Return to flight");
define("_READY_FOR_SUBMISSION","Ready to submit");
define("_SUBMIT_TO_OLC","Submit to OLC");
define("_OLC_MAP","Map");
define("_OLC_BARO","Barograph");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","Pilot Profile");
define("_back_to_flights","back to flights");
define("_pilot_stats","pilot stats");
define("_edit_profile","edit profile");
define("_flights_stats","flights stats");
define("_View_Profile","View Profile");

define("_Personal_Stuff","Personal Stuff");
define("_First_Name"," First Name");
define("_Last_Name","Last Name");
define("_Birthdate","Birthdate");
define("_dd_mm_yy","dd.mm.yy");
define("_pilot_email","Email Address");
define("_Sign","Sign");
define("_Marital_Status","Marital Status");
define("_Occupation","Occupation");
define("_Web_Page","Web Page");
define("_N_A","N/A");
define("_Other_Interests","Other Interests");
define("_Photo","Photo");

define("_Flying_Stuff","Flying Stuff");
define("_note_place_and_date","if applicable note place-country and date");
define("_Flying_Since","Flying Since");
define("_Pilot_Licence","Pilot Licence");
define("_Paragliding_training","Paragliding training");
define("_Favorite_Location","Favorite Location");
define("_Usual_Location","Usual Location");
define("_Best_Flying_Memory","Best Flying Memory");
define("_Worst_Flying_Memory","Worst Flying Memory");
define("_Personal_Distance_Record","Personal Distance Record");
define("_Personal_Height_Record","Personal Height Record");
define("_Hours_Flown","Hours Flown");
define("_Hours_Per_Year","Hours Per Year");

define("_Equipment_Stuff","Equipment Stuff");
define("_Glider","Glider");
define("_Harness","Harness");
define("_Reserve_chute","Reserve chute");
define("_Camera","Camera");
define("_Vario","Vario");
define("_GPS","GPS");
define("_Helmet","Helmet");
define("_Camcorder","Camcorder");

define("_Manouveur_Stuff","Manouveur Stuff");
define("_note_max_descent_rate","if applicable note max descent rate achieved");
define("_Spiral","Spiral");
define("_Bline","Bline");
define("_Full_Stall","Full Stall");
define("_Other_Manouveurs_Acro","Other Manouveurs Acro");
define("_Sat","Sat");
define("_Asymmetric_Spiral","Asymmetric Spiral");
define("_Spin","Spin");

define("_General_Stuff","General Stuff");
define("_Favorite_Singer","Favorite Singer");
define("_Favorite_Movie","Favorite Movie");
define("_Favorite_Internet_Site","Favorite<br>Internet Site");
define("_Favorite_Book","Favorite Book");
define("_Favorite_Actor","Favorite Actor");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","Upload new photo or change old");
define("_Delete_Photo","Delete Photo");
define("_Your_profile_has_been_updated","Your profile has been updated");
define("_Submit_Change_Data","Submit - Change Data");

//--------------------------------------------
// Added by Martin Jursa, 26.04.2007 for pilot_profile and pilot_profile_edit
//--------------------------------------------
define("_Sex", "Sex");
define("_Login_Stuff", "Change Login-Data");
define("_PASSWORD_CONFIRMATION", "Confirm password");
define("_EnterPasswordOnlyToChange", "Only enter the password, if you want to change it:");

define("_PwdAndConfDontMatch", "Password and confirmation are different.");
define("_PwdTooShort", "The password is too short. It must have a length of at least $passwordMinLength characters.");
define("_PwdConfEmpty", "The password has not be confirmed.");
define("_PwdChanged", "The password was changed.");
define("_PwdNotChanged", "The password has NOT been changed.");
define("_PwdChangeProblem", "A problem occurred when changing the password.");

define("_EmailEmpty", "The email address must not be empty.");
define("_EmailInvalid", "The email address is invalid.");
define("_EmailSaved", "The email address was saved");
define("_EmailNotSaved", "The email address has not been saved.");
define("_EmailSaveProblem", "A problem occurred when saving the email address.");

// End 26.04.2007

//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","hh:mm");

define("_Totals","Totals");
define("_First_flight_logged","First flight logged");
define("_Last_flight_logged","Last flight logged");
define("_Flying_period_covered","Flying period covered");
define("_Total_Distance","Total Distance");
define("_Total_OLC_Score","Total XC Score");
define("_Total_Hours_Flown","Total Hours Flown");
define("_Total_num_of_flights","Total # of flights ");

define("_Personal_Bests","Personal Bests");
define("_Best_Open_Distance","Best Open Distance");
define("_Best_FAI_Triangle","Best FAI Triangle");
define("_Best_Free_Triangle","Best Free Triangle");
define("_Longest_Flight","Longest Flight");
define("_Best_OLC_score","Best XC score");

define("_Absolute_Height_Record","Absolute Height Record");
define("_Altitute_gain_Record","Altitute gain Record");
define("_Mean_values","Mean values");
define("_Mean_distance_per_flight","Mean distance per flight");
define("_Mean_flights_per_Month","Mean flights per Month");
define("_Mean_distance_per_Month","Mean distance per Month");
define("_Mean_duration_per_Month","Mean duration per Month");
define("_Mean_duration_per_flight","Mean duration per flight");
define("_Mean_flights_per_Year","Mean flights per Year");
define("_Mean_distance_per_Year","Mean distance per Year");
define("_Mean_duration_per_Year","Mean duration per Year");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","See flights near this point");
define("_Waypoint_Name","Waypoint Name");
define("_Navigate_with_Google_Earth","Navigate with Google Earth");
define("_See_it_in_Google_Maps","See it in Google Maps");
define("_See_it_in_MapQuest","See it in MapQuest");
define("_COORDINATES","Coordinates");
define("_FLIGHTS","Flights");
define("_SITE_RECORD","Site record");
define("_SITE_INFO","Site information");
define("_SITE_REGION","Region");
define("_SITE_LINK","Link to more information");
define("_SITE_DESCR","Site/takeoff Description");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","See more details");
define("_KML_file_made_by","KML file made by");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","Register takeoff");
define("_WAYPOINT_ADDED","The takeoff has been registered");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","Site Record<br>(open distance)");
	
//--------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","Glider type");

function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'Paraglider',2=>'Flex wing FAI1',4=>'Rigid wing FAI5',8=>'Glider');
	foreach ($CONF_glider_types as $gId=>$gName) if (!$gliderCatList[$gId]) $gliderCatList[$gId]=$gName;		
}
setGliderCats();

//--------------------------------------------
// class types
//--------------------------------------------
function setClassList() {
	$CONF_TEMP['gliderClasses'][1]['classes']=array(1=>"Sport",2=>"Open",3=>"Tandem");
	$CONF_TEMP['gliderClasses'][2]['classes']=array(1=>"Kingpost",2=>"Topless");
	global $CONF;
	foreach($CONF['gliderClasses'] as $i=>$gClass) {
		foreach($gClass['classes'] as $j=>$n) {
			if ( $CONF_TEMP['gliderClasses'][$i]['classes'][$j] ) {
				$CONF['gliderClasses'][$i]['classes'][$j] =$CONF_TEMP['gliderClasses'][$i]['classes'][$j] ;
			}
		}
	}
}
setClassList(); 
//--------------------------------------------
// xc types
//--------------------------------------------
function setXCtypesList() {
	global  $CONF_xc_types,$xcTypesList;
	$xcTypesList=array(1=>"3 Turnpoints XC",2=>"Open Triangle",4=>"Closed Triangle");
	foreach ($CONF_xc_types as $gId=>$gName) if (!$xcTypesList[$gId]) $xcTypesList[$gId]=$gName;
}
setXCtypesList(); 

//--------------------------------------------
// user prefs  & units
//--------------------------------------------

define("_Your_settings_have_been_updated","Your settings have been updated");

define("_THEME","Theme");
define("_LANGUAGE","Language");
define("_VIEW_CATEGORY","View category");
define("_VIEW_COUNTRY","View country");
define("_UNITS_SYSTEM" ,"Units system");
define("_METRIC_SYSTEM","Metric (km,m)");
define("_IMPERIAL_SYSTEM","Imperial (miles,feet)");
define("_ITEMS_PER_PAGE","Items per page");

define("_MI","mi");
define("_KM","km");
define("_FT","ft");
define("_M","m");
define("_MPH","mph");
define("_KM_PER_HR","km/h");
define("_FPM","fpm");
define("_M_PER_SEC","m/sec");

//--------------------------------------------
// index page
//--------------------------------------------

define("_WORLD_WIDE","World Wide");
define("_National_XC_Leagues_for","National XC Leagues for");
define("_Flights_per_Country","Flights per Country");
define("_Takeoffs_per_Country","Takeoffs per Country");
define("_INDEX_HEADER","Welcome to Leonardo XC League");
define("_INDEX_MESSAGE","You can use the &quot;Main menu&quot; to navigate or use the most common choices presented below.");

//--------------------------------------------
// NEW 
//--------------------------------------------
define("_MENU_SUMMARY_PAGE","First (Summary) Page");
define("_Display_ALL","Display ALL");
define("_Display_NONE","Display NONE");
define("_Reset_to_default_view","Reset to default view");
define("_No_Club","No Club");
define("_This_is_the_URL_of_this_page","This is the URL of this page");
define("_All_glider_types","All glider types");

define("_MENU_SITES_GUIDE","Flying Sites Guide");
define("_Site_Guide","Site Guide");

define("_Search_Options","Search Options");
define("_Below_is_the_list_of_selected_sites","Below is the list of selected sites");
define("_Clear_this_list","Clear this list");
define("_See_the_selected_sites_in_Google_Earth","See the selected sites in Google Earth");
define("_Available_Takeoffs","Available Takeoffs");
define("_Search_site_by_name","Search site by name");
define("_give_at_least_2_letters","give at least 2 letters");
define("_takeoff_move_instructions_1","You can move all availabe takeoffs to the selected list on the right panel by using >> or the selected one by using > ");
define("_Takeoff_Details","Takeoff Details");


define("_Takeoff_Info","Takeoff Info");
define("_XC_Info","XC Info");
define("_Flight_Info","Flight Info");

define("_MENU_LOGOUT","Logout");
define("_MENU_LOGIN","Login");
define("_MENU_REGISTER","Open an account");
define("_PROJECT_HELP","Help");
define("_PROJECT_NEWS","News");
define("_PROJECT_RULES","Regulations");



define("_Africa","Africa");
define("_Europe","Europe");
define("_Asia","Asia");
define("_Australia","Australia");
define("_North_Central_America","North/Central America");
define("_South_America","South America");

define("_Recent","Recent");


define("_Unknown_takeoff","Unknown takeoff");
define("_Display_on_Google_Earth","Display on Google Earth");
define("_Use_Man_s_Module","Use Man's Module");
define("_Line_Color","Line Color");
define("_Line_width","Line width");
define("_unknown_takeoff_tooltip_1","This flight has an uknown Takeoff");
define("_unknown_takeoff_tooltip_2","If you do know from which takeoff/launch this flight began please click to fill it in !");
define("_EDIT_WAYPOINT","Edit Takeoff Info");
define("_DELETE_WAYPOINT","Delete Takeoff");
define("_SUBMISION_DATE","Submission Date"); // the date a flight was submited to leonardo
define("_TIMES_VIEWED","Times Viewed"); // the times that this flight havs been viewed


define("_takeoff_add_help_1","You can enter the takeoff infomation if you know it. If not sure it is OK to close this window");
define("_takeoff_add_help_2","If the launch of your flight is the one displayed above the 'Unknown Takeoff' then there is no need to enter it again. Just close this window. ");
define("_takeoff_add_help_3","If you see the launch name below you can click on it to auto-fill the fields to the left.");
define("_Takeoff_Name","Takeoff Name");
define("_In_Local_Language","In Local Language");
define("_In_English","In English");

// New on 2007/02/20 - login screen
define("_ENTER_PASSWORD","Please enter your username and password to log in.");
define("_SEND_PASSWORD","I forgot my password");
define("_ERROR_LOGIN","You have specified an incorrect or inactive username, or an invalid password.");
define("_AUTO_LOGIN","Log me on automatically each visit");
define("_USERNAME","Username");
define("_PASSWORD","Password");
define("_PROBLEMS_HELP","If you have problems to log in contact the administrator");

define("_LOGIN_TRY_AGAIN","Click %sHere%s to try again");
define("_LOGIN_RETURN","Click %sHere%s to return to the Index");
// end 2007/02/20

define("_Category","Category");
define("_MEMBER_OF","Member of");
define("_MemberID","Member ID");
define("_EnterID","Enter ID");
define("_Clubs_Leagues","Clubs / Leagues");
define("_Pilot_Statistics","Pilot Statistics");
define("_National_Rankings","National Rankings");

// new on 2007/03/08
define("_Select_Club","Select Club");
define("_Close_window","Close window");
define("_EnterID","Enter ID");
define("_Club","Club");
define("_Sponsor","Sponsor");


// new on 2007/03/13
define("_Go_To_Current_Month","Go To Current Month");
define("_Today_is","Today is");
define("_Wk","Wk");
define("_Click_to_scroll_to_previous_month","Click to scroll to previous month. Hold mouse button to scroll automatically.");
define("_Click_to_scroll_to_next_month","Click to scroll to next month. Hold mouse button to scroll automatically.");
define("_Click_to_select_a_month","Click to select a month.");
define("_Click_to_select_a_year","Click to select a year.");
define("_Select_date_as_date.","Select [date] as date."); // do not replace [date], it will be replaced by date.
// end 2007/03/13


// New on 2007/05/18 (alternative GUI_filter)
define("_Filter_NoSelection", "No selection");
define("_Filter_CurrentlySelected", "Current selection");
define("_Filter_DialogMultiSelectInfo", "Press Ctrl for multiple selection.");

define("_Filter_FilterTitleIncluding","Only selected [items]");
define("_Filter_FilterTitleExcluding","Exclude [items]");
define("_Filter_DialogTitleIncluding","Select [items]");
define("_Filter_DialogTitleExcluding","Select [items]");

define("_Filter_Items_pilot", "pilots");
define("_Filter_Items_nacclub", "clubs");
define("_Filter_Items_country", "countries");
define("_Filter_Items_takeoff", "take offs");

define("_Filter_Button_Select", "Select");
define("_Filter_Button_Delete", "Delete");
define("_Filter_Button_Accept", "Accept selection");
define("_Filter_Button_Cancel", "Cancel");

# menu bar
define("_MENU_FILTER_NEW","Filter **NEW VERSION**");

// end 2007/05/18




// New on 2007/05/23
// second menu NACCclub selection
define("_ALL_NACCLUBS", "All Clubs");
// Note to translators: use the placeholder $nacname in your translation as it is, don"t translate it
define("_SELECT_NACCLUB", "Select [nacname]-Club");

// pilot profile
define("_FirstOlcYear", "First year of participation in an online XC contest");
define("_FirstOlcYearComment", "Please select the year of your first participation in any online XC contest, not just this one.<br/>This field is relevant for the &quot;newcomer&quot;-rankings.");

//end 2007/05/23

// New on 2007/11/06
define("_Select_Brand","Select Brand");
define("_All_Brands","All Brands");
define("_DAY","DAY");
define("_Glider_Brand","Glider Brand");
define("_Or_Select_from_previous","Or Select from previous");

define("_Explanation_AddToBookmarks_IE","Add these filter settings to your favourites");
define("_Msg_AddToBookmarks_IE","Click here to add these filter settings to your bookmarks.");
define("_Explanation_AddToBookmarks_nonIE","(Save this link to your bookmarks.)");
define("_Msg_AddToBookmarks_nonIE","To save these filter settings to your bookmarks, use the function Save to bookmarks of your browser.");

define("_PROJECT_HELP","Help");
define("_PROJECT_NEWS","News");
define("_PROJECT_RULES","Regulations 2007");
define("_PROJECT_RULES2","Regulations 2008");

//end 2007/11/06
define("_MEAN_SPEED1","Mean Speed");
define("_External_Entry","External Entry");

// New on 2007/11/25
define("_Altitude","Altitude");
define("_Speed","Speed");
define("_Distance_from_takeoff","Distance from takeoff");

// New on 2007/12/03
define("_LAST_DIGIT","last digit");

define("_Filter_Items_nationality","nationality");
define("_Filter_Items_server","server");

// New on 2007/12/15
define("_Ext_text1","This is a flight originally submited at ");
define("_Ext_text2","Link to full flight maps and charts");
define("_Ext_text3","Link to original flight");


// New on 2008/2/15
define("_Male_short","M");
define("_Female_short","F");
define("_Male","Male");
define("_Female","Female");
define("_Pilot_Statistics","Pilot Statistics");


// New on 2008/2/19
define("_Altitude_Short","Alt");
define("_Vario_Short","Vario");
define("_Time_Short","Time");
define("_Info","Info");
define("_Control","Control");

define("_Zoom_to_flight","Zoom to flight");
define("_Follow_Glider","Follow Glider");
define("_Show_Task","Show Task");
define("_Show_Airspace","Show Airspace");
define("_Thermals","Thermals");

// New on 2008/06/04
define("_Show_Optimization_details","Show Optimization Details");
define("_MENU_SEARCH_PILOTS","Search");

//New on 2008/05/17
define("_MemberID_Missing","Your member ID is missing");
define("_MemberID_NotNumeric","The member ID must be numeric");

define("_FLIGHTADD_CONFIRMATIONTEXT","By submitting this form I confirm that I have respected all legal obligations concerning this flight.");
define("_FLIGHTADD_IGC_MISSING","Please select your .igc-file");
define("_FLIGHTADD_IGCZIP_MISSING","Please select the zip-file containing your .igc-file");
define("_FLIGHTADD_CATEGORY_MISSING","Please select the category");
define("_FLIGHTADD_BRAND_MISSING","Please select the brand of your glider");
define("_FLIGHTADD_GLIDER_MISSING","Please enter the type of your glider");
define("_YOU_HAVENT_ENTERED_GLIDER","You have not entered brand or glider");

define("_BRAND_NOT_IN_LIST","Brand not in list");


/*------------------------------------------------------------
Durval Henke www.xcbrasil.org
------------------------------------------------------------*/
define("_Email_new_password","<p align='justify'>The server have sent a email to the pilot with the new password and activation key</p> <p align='justify'>Please, check your email box and follow the procedures in the email body</p>");
define("_informed_user_not_found","This user was not found in the database");
define("_impossible_to_gen_new_pass","<p align='justify'>We are sorry to inform you that is not possible to generate a new password for you at this time, there is already a request that will expire in <b>%s</b>. Only after the expiration time you can do a new request.</p><p align='justify'>If you do not have access to the email contact the server admin</p>");
define("_Password_subject_confirm","Confirmation email (new password)");
define("_request_key_not_found", "the request key that you have provided was not found!");
define("_request_key_invalid", "request key that you have provided is invalid!"); 
define("_Email_allready_yours","The provided email is allready yours, nothing to do");
define("_Email_allready_have_request","There is already an request for changing to this email, nothing to do");
define("_Email_used_by_other","This email is used by another pilot, nothing to do");
define("_Email_used_by_other_request","This email is used by another pilot in a pending request");
define("_Email_canot_change_quickly","You can not change your email right now, wait for the expiring time: %s");
define("_Email_sent_with_confirm","A confirmation email is send, please check you mailbox so that you can confirm the changing of email");
define("_Email_subject_confirm","Confirmation email (new email)");
define("_Email_AndConfDontMatch","Email and confirmation are different.");
define("_ChangingEmailForm"," Changing Email Form");
define("_Email_current","Current Email");
define("_New_email", "New Email Address");
define("_New_email_confirm","Confirm New Email");
define("_MENU_CHANGE_PASSWORD","Change my password");
define("_MENU_CHANGE_EMAIL","Change my email");
define("_New_Password","New Password");
define("_ChangePasswordForm","Change Password Form");
define("_lost_password","Lost Password Form");
define("_PASSWORD_RECOVERY_TOOL","Password Recovery Form");
define("_PASSWORD_RECOVERY_TOOL_MESSAGE","The Server will search in his entire database for the inserted text in the textbox, if and when the server find the user, email, or civlid, A mail will be sended for the registered email address with a new password and activation link.<br><br> note: only after activation of the new password through activation link inside mail body, the new password will be valid.<br><br>");
define("_username_civlid_email","Please fill with: CIVLID or User Name or Email Address");
define("_Recover_my_pass","Recover my Password"); 
define("_You_are_not_login","<BR><BR><center><br>You are not logged in. <br><br>Please Login<BR><BR></center>");
define("_Requirements","Requirements");
define("_Mandatory_CIVLID","Is mandatory tho have an valid <b>CIVLID</b>");
define("_Mandatory_valid_EMAIL","Is mandatory to provide a <b>Valid Email</b> for further comunications with admin server");
define("_Email_periodic","Periodically we will send you a confirmation e-mail to the provided e-mail address, if not answered, your registration account will be blocked");
define("_Email_asking_conf","We will send a confirmation e-mail to the provided email address");
define("_Email_time_conf","You will have only <b>3 hours </b> after the finishing the pre-registration to answer the email");
define("_After_conf_time"," After that time, your pre-registration will be <b>removed</b> from our database");
define("_Only_after_time","<b>And only after we remove your pre-registration, you can do the pre registration again</b>");
define("_Disable_Anti_Spam","<b>ATTENTION!! Disable</b> the anti spam for emails originated from <b>%s</b>");
define("_If_you_agree","If you agree with this requirements please go further.");
define("_Search_civl_by_name","%sSearch for your name in the CIVL database%s . When you click at this left link will be opened a new window , please fill only 3 letters from your First name or Last Name, then the CIVL will return your CIVLID, Name and FAI Nationality.");
define("_Register_civl_as_new_pilot","If you are not registered in the CIVL database, please  %sREGISTER-ME AS A NEW PILOT%s");
define("_NICK_NAME","Nick Name");
define("_LOCAL_PWD","Local Password");
define("_LOCAL_PWD_2","Repeat Local Password");
define("_CONFIRM","Confirm");
define("_REQUIRED_FIELD","Mandatory Fields");
define("_Registration_Form","Registration Form at %s (Leonardo)");
define("_MANDATORY_NAME","Is Mandatory to provide your name");
define("_MANDATORY_FAI_NATION","Is Mandatory to provide your FAI NATION");
define("_MANDATORY_GENDER", "Please provide your Sex");
define("_MANDATORY_BIRTH_DATE_INVALID","Birth Date Invalid");
define("_MANDATORY_CIVL_ID", "Please provide your CIVLID");
define("_Attention_mandatory_to_have_civlid","ATENTION!! For now one is Mandatory to have CIVLID in the %s database");
define("_Email_confirm_success","Your registration was successfully confirmed!");
define("_Success_login_civl_or_user","Success, now you can login using your CIVLID as username, or continue with your old username");
define("_Server_did_not_found_registration","Registration not found, please copy and paste in your browser address field the link provided in the email that was send to you, or maybe your registration time has expired");
define("_Pilot_already_registered","Pilot already registered with CIVLID %s and name %s");
define("_User_already_registered","User already registered with this email or name");
define("_Pilot_civlid_email_pre_registration","Hi %s This Civl ID and email is already used in a pre-registration");
define("_Pilot_have_pre_registration"," You already have a pre registration, but have not answered our mail, we resend the confirmation email for you, you have 3 hours after now to answer the email, if not you will be removed from pre registration. please read the email and follow the procedures described inside, thank you");
define("_Pre_registration_founded","We already have a pre-registration with this civlID and Email,wait for finishing the period of 3 hours until then this registration will be removed, in no hipotisis confirm the email that was send  because will be generated an double registration, and your old flights will not be transfered for the new user");            
define("_Civlid_already_in_use", "This CIVLID is used for another pilot, we can not have double CIVLID!");
define("_Pilot_email_used_in_reg_dif_civlid","Hi %s This Email is used in another register with different CIVLID");            
define("_Pilot_civlid_used_in_reg_dif_email","Hi %s This CIVLID is used in another register with different EMAIL");                       
define("_Pilot_email_used_in_pre_reg_dif_civlid","Hi %s This Email is used in another pre-register with different CIVLID");            
define("_Pilot_civlid_used_in_pre_reg_dif_email","Hi %s This CIVLID is used in another pre-register with different EMAIL");            
define("_Server_send_conf_email","The server have sended to the %s an email asking for confirmation, you have 3 hours from now to confirm your registration by clicking or copying and pasting the link that are in the email body in your browser addres");
define("_Pilot_confirm_subscription","===================================

%s Leonardo new user
                
Hi %s,

This is a verification email sent from %s
 
To finally create your account, you will need to click on link below to verify your email address:

http://%s?op=register&rkey=%s 

Regards,

--------
Note: This is auto-response. Do not send any email to this email address
--------");
define("_Pilot_confirm_change_email","===================================

%s Leonardo user
                
Hi %s,

This is a verification email sent from %s
 
To finally change your email address, you will need to click on link below to verify your email address:

http://%s?op=chem&rkey=%s

Regards,

--------
Note: This is auto-response. Do not send any email to this email address
--------");                  
define("_Password_recovery_email","===================================

%s (Leonardo) user
                
Hi %s,

This is a verification email sent from %s
                
With Password recovery for you
                
Username:%s
                
CIVLID:%s
                
NewPassword:%s
 
To activate your new password, you will need to click on link below to verify your email address:

http://%s?op=send_password&rkey=%s 

Regards,

--------
Note: This is auto-response. Do not send any email to this email address
--------");


// New on 2008/11/26
define("_MENU_AREA_GUIDE","Area Guide");
define("_All_XC_types","All XC types");
define("_xctype","XC type");


define("_Flying_Areas","Flying Areas");
define("_Name_of_Area","Name of Area");
define("_See_area_details","See the details and takeoffs for this area");

define("_choose_ge_module","Please choose the module to use<BR>for Google Earth Display");
define("_ge_module_advanced_1","(Most detailed, bigger size)");
define("_ge_module_advanced_2","(Many details, big size) ");
define("_ge_module_Simple","Simple (Only Task, very small)");

define("_Pilot_search_instructions","Enter at least 3 letters of the First or Last Name");

define("_All_classes","All classes");
define("_Class","Class");

/*

define("Show Optimization Details
define("Optimization
define("Scoring Factors Used: XC scoring

define("Type of Flight
define("Factor
define("XC distance	
define("XC Score

*/

// 2009-03-20 filter for photos
define("_Photos_filter_off","With/without photos");
define("_Photos_filter_on","With photos only");

define("_You_are_already_logged_in","You are already logged in");


// 2010-03-14
define("_See_The_filter","See the filter");
define("_PilotBirthdate","Pilot Birthdate");
define("_Start_Type","Start Type");
define("_GLIDER_CERT","Glider Certification");

// 2010-03-21
define("_MENU_BROWSER","Browse in Google Maps");
define("_FLIGHT_BROSWER","Search the flights and takeoff database with Google Maps");
define("_Load_Thermals","Load Thermals");
define("_Loading_thermals","Loading Thermals");
define("_Layers","Layers");
define("_Select_Area","Select Area");


//2010-11-20 commenting system
define("_Leave_a_comment","Leave a comment");
define("_Reply","Reply");
define("_Translate","Translate");
define("_Translate_to","Translate to");
define("_Submit_Comment","Submit Comment");
define("_Logged_in_as","Logged in as:");
define("_Name","Name");
define("_Email","Email");
define("_Will_not_be_displayed","(Will not be displayed)");
define("_Please_type_something","Please type something");
define("_Please_enter_your_name","Please enter your name / nickname");
define("_Please_give_your_email","Please give your email, it will not be displayed at any times");
define("_RSS_for_the_comments","This is the RSS link for this flight\'s comments<BR>Copy Paste it into your RSS reader");

// on profile
define("_Comments_are_enabled_by_default_for_new_flights","Comments are enabled by default for new flights");

define("_Comments_Enabled","Comments Enabled");
define("_Comments_are_enabled_for_this_flight","Comments are enabled for this flight");
define("_Comments_are_disabled_for_this_flight","Comments are disabled for this flight");
define("_ERROR_in_setting_the_comments_status","ERROR in setting the comments status");
define("_Save_changes","Save changes");
define("_Cancel","Cancel");
define("_Are_you_sure_you_want_to_delete_this_comment","Are you sure you want to delete this comment?");

define("_RSS_feed_for_comments","RSS feed for comments");
define("_RSS_feed_for_flights","RSS feed for flights");
define("_RSS_of_pilots_flights","RSS of pilot\'s flights");


define("_You_have_a_new_comment","You have a new comment on %s");
define("_New_comment_email_body","You have a new comment on %s<BR><BR><a href='%s'>Click here to read all comments</a><hr>%s");


define("_Remove_From_Favorites","Remove From Favorites");
define("_Favorites","Favorites");
define("_Compare_flights_line_1","Choose flights per Checkbox");
define("_Compare_flights_line_2","and compare them with each other in Google Maps");
define("_Compare_Favorite_Tracks","Compare Favorite Tracks");
define("_Remove_all_favorites","Remove all favorites");
 
define("_Find_and_Compare_Flights","Find and Compare Flights");
define("_Compare_Selected_Flights","Compare Selected Flights");
define("_More","More");
define("_Close","Close");



?>
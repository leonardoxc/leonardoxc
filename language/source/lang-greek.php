<? if (0) { ?><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-7"></head><? } ?><?

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
	$monthList=array('����������','�����������','�������','��������','�����','�������',
				'�������','���������','�����������','���������','���������','����������');
	$monthListShort=array('���','���','���','���','���','����','����','���','���','���','���','���');
	$weekdaysList=array('���','���','���','���','���','���','���') ;
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","�������� �����");
define("_FREE_TRIANGLE","������� ��������");
define("_FAI_TRIANGLE","������� FAI");

define("_SUBMIT_FLIGHT_ERROR","�������� ���� ��� ������� ��� ������");

// list_pilots()
define("_NUM","A/A");
define("_PILOT","�������");
define("_NUMBER_OF_FLIGHTS","������� �������");
define("_BEST_DISTANCE","�������� ��������");
define("_MEAN_KM","����� # km ��� �����");
define("_TOTAL_KM","�������� km �������");
define("_TOTAL_DURATION_OF_FLIGHTS","�������� �������� �������");
define("_MEAN_DURATION","���� �������� ������");
define("_TOTAL_OLC_KM","�������� XC ��������");
define("_TOTAL_OLC_SCORE","��������� XC ������");
define("_BEST_OLC_SCORE","��������� XC ������");
define("_From","���");

// list_flights()
define("_DURATION_HOURS_MIN","�������� (��:��)");
define("_SHOW","��������");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","� ����� �� ������������� �� 1-2 �����. ");
define("_TRY_AGAIN","������������� �� ����");
define("_SEASON","������");
define("_TAKEOFF_LOCATION","���������");
define("_TAKEOFF_TIME","��� ����������");
define("_LANDING_LOCATION","����������");
define("_LANDING_TIME","��� �����������");
define("_OPEN_DISTANCE","�������� �� ������");
// define("_DURATION","��������");
define("_MAX_DISTANCE","������� ��������");
define("_OLC_SCORE_TYPE","����� XC �����������");
define("_OLC_DISTANCE","�������� XC");
define("_OLC_SCORING","���������� XC");
define("_MAX_SPEED","������� ��������");
define("_MAX_VARIO","������� �������");
define("_MEAN_SPEED","���� ��������");
define("_MIN_VARIO","������� ��������");
define("_MAX_ALTITUDE","������o ����");
define("_TAKEOFF_ALTITUDE","���� ����������");
define("_MIN_ALTITUDE","�������� ����");
define("_ALTITUDE_GAIN","�������� �����");
define("_FLIGHT_FILE","������ ������");
define("_COMMENTS","������");
define("_RELEVANT_PAGE","������� ������");
define("_GLIDER","����������");
define("_PHOTOS","�����������");
define("_MORE_INFO","��������");
define("_UPDATE_DATA","�������� ���������");
define("_UPDATE_MAP","�������� �����");
define("_UPDATE_3D_MAP","�������� 3D �����");
define("_UPDATE_GRAPHS","�������� ����������");
define("_UPDATE_SCORE","�������� �����������");

define("_TAKEOFF_COORDS","������������� ����������:");
define("_NO_KNOWN_LOCATIONS","��� �������� ���� �� ����� ������� ����������!");
define("_FLYING_AREA_INFO","����������� ��������");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo XC");
define("_RETURN_TO_TOP","��������� ���� ����");
// list flight
define("_PILOT_FLIGHTS","������� �������");

define("_DATE_SORT","����������");
define("_PILOT_NAME","����� �������");
define("_TAKEOFF","���������");
define("_DURATION","��������");
define("_LINEAR_DISTANCE","������� ��������");
define("_OLC_KM","XC ���.");
define("_OLC_SCORE","XC ������");
define("_DATE_ADDED","��������� ��������");

define("_SORTED_BY","����������:");
define("_ALL_YEARS","���� �� �������");
define("_SELECT_YEAR_MONTH","�������� ����� � ��� ����");
define("_ALL","���");
define("_ALL_PILOTS","���� �� �������");
define("_ALL_TAKEOFFS","���� �� ����������");
define("_ALL_THE_YEAR","��� �� ����");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","��� ������ ������ ������");
define("_NO_SUCH_FILE","�� ������ ��� ��� ������ �� ������ (�������� ��� server)");
define("_FILE_DOESNT_END_IN_IGC","�� ������ ��� ���� �������� .igc");
define("_THIS_ISNT_A_VALID_IGC_FILE","�� ������ igc ��� ����� ������");
define("_THERE_IS_SAME_DATE_FLIGHT","������� ��� ��� ����� ��� �� ���� ��� ���������� ��� ���");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","�� ������ �� ��� ��������������� ������ ����� ��");
define("_DELETE_THE_OLD_ONE","������� ��� �����");
define("_THERE_IS_SAME_FILENAME_FLIGHT","������� ��� ��� ����� ��� �� to ���� ����� �������");
define("_CHANGE_THE_FILENAME","�� � ����� ����� ����������� ���� ������� �� ����� ��� ������� ��� ����������� �� ���������");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","�  ����� ��� ���� �����������");
define("_PRESS_HERE_TO_VIEW_IT","������� ��� ��� �� ��� �����");
define("_WILL_BE_ACTIVATED_SOON","(�� ������������� �� 1-2 �����)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","������ ������� �������");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","���� �� IGC ������ �� �������������");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","��������� �� ������ ZIP<br>��� �������� ��� �������");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","������� ��� ��� ������� ��� �������");

define("_FILE_DOESNT_END_IN_ZIP","�� ������ ��� ���� �������� .zip");
define("_ADDING_FILE","���������� ������");
define("_ADDED_SUCESSFULLY","� ���������� ���� ��������");
define("_PROBLEM","��������");
define("_TOTAL","��������");
define("_IGC_FILES_PROCESSED","������� ��������������");
define("_IGC_FILES_SUBMITED","������� �������������");

// info
define("_DEVELOPMENT","���������");
define("_ANDREADAKIS_MANOLIS","����������� �������");
define("_PROJECT_URL","������");
define("_VERSION","������");
define("_MAP_CREATION","���������� ������");
define("_PROJECT_INFO","����������� ��� �� ���������");

// menu bar 
define("_MENU_MAIN_MENU","������� ��������");
define("_MENU_DATE","����������");
define("_MENU_COUNTRY","����");
define("_MENU_XCLEAGUE","XC League");
define("_MENU_ADMIN","����������");


define("_MENU_COMPETITION_LEAGUE","�������� - ���� �� ����������");
define("_MENU_OLC","XC");
define("_MENU_OPEN_DISTANCE","������� ��������");
define("_MENU_DURATION","��������");
define("_MENU_ALL_FLIGHTS","���� �� �������");
define("_MENU_FLIGHTS","�������");
define("_MENU_TAKEOFFS","�����������");
define("_MENU_FILTER","�����������");
define("_MENU_MY_FLIGHTS","�� ������� ���");
define("_MENU_MY_PROFILE","�� ����������� ���");
define("_MENU_MY_STATS","�� ���������� ���"); 
define("_MENU_MY_SETTINGS","�� ��������� ���"); 
define("_MENU_SUBMIT_FLIGHT","������� ������");
define("_MENU_SUBMIT_FROM_ZIP","������� ������ ��� zip");
define("_MENU_SHOW_PILOTS","�������");
define("_MENU_SHOW_LAST_ADDED","���������� ���������");
define("_FLIGHTS_STATS","���������� �������");

define("_SELECT_YEAR","������� �����");
define("_SELECT_MONTH","������� ����");
define("_ALL_COUNTRIES","���� �� �����");

//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","���� �� �������");
define("_NUMBER_OF_FLIGHTS","������� �������");
define("_TOTAL_DISTANCE","�������� ��������");
define("_TOTAL_DURATION","�������� ��������");
define("_BEST_OPEN_DISTANCE","�������� ��������");
define("_TOTAL_OLC_DISTANCE","�������� XC ��������");
define("_TOTAL_OLC_SCORE","��������� XC ������");
define("_BEST_OLC_SCORE","��������� XC ������");
define("_MEAN_DURATION","���� ��������");
define("_MEAN_DISTANCE","���� ��������");
define("_PILOT_STATISTICS_SORT_BY","������� - ���������� ���");
define("_CATEGORY_FLIGHT_NUMBER","��������� 'FastJoe' - ������� �������");
define("_CATEGORY_TOTAL_DURATION","��������� 'DURACELL' - �������� �������� �������");
define("_CATEGORY_OPEN_DISTANCE","��������� 'Open Distance'");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","��� �������� ���� �� ����� ������� ������� !");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","� ����� ����������");
define("_RETURN","���������");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","������� - �� ���������� ��� �������� ����� ;");
define("_THE_DATE","����������");
define("_YES","���");
define("_NO","���");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","������������ ���������");
define("_N_BEST_FLIGHTS"," ��������� �������");
define("_OLC","XC");
define("_OLC_TOTAL_SCORE","XC �������� ����������");
define("_KILOMETERS","����������");
define("_TOTAL_ALTITUDE_GAIN","�������� �������� �����");
define("_TOTAL_KM","�������� ���.");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","�� �����");
define("_IS_NOT","�� ��� �����");
define("_OR","�");
define("_AND","���");
define("_FILTER_PAGE_TITLE","����������� ������� �� ��������");
define("_RETURN_TO_FLIGHTS","��������� ���� �������");
define("_THE_FILTER_IS_ACTIVE","�� ����������� ����� ������");
define("_THE_FILTER_IS_INACTIVE","�� ����������� ����� ��������");
define("_SELECT_DATE","������� �����������");
define("_SHOW_FLIGHTS","�� ����������� �� �������");
define("_ALL2","����");
define("_WITH_YEAR","�� �� ����");
define("_MONTH","�����");
define("_YEAR","����");
define("_FROM","���");
define("_from","���");
define("_TO","���");
define("_SELECT_PILOT","������� �������");
define("_THE_PILOT","� �������");
define("_THE_TAKEOFF","� ���������");
define("_SELECT_TAKEOFF","������� ����������");
define("_THE_COUNTRY","H ����");
define("_COUNTRY","����");
define("_SELECT_COUNTRY","�������� ����");
define("_OTHER_FILTERS","����� ��������");
define("_LINEAR_DISTANCE_SHOULD_BE","� �������� �� ������ �� �����");
define("_OLC_DISTANCE_SHOULD_BE","� �������� XC �� �����");
define("_OLC_SCORE_SHOULD_BE","� ���������� XC �� �����");
define("_DURATION_SHOULD_BE","� �������� �� �����");
define("_ACTIVATE_CHANGE_FILTER","������������ / ������ �������");
define("_DEACTIVATE_FILTER","�������������� �������");
define("_HOURS","����");
define("_MINUTES","�����");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","������� ������");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(���� �� IGC ������ ����� �����������)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","��������� �� ������<br>IGC ��� ������");
define("_NOTE_TAKEOFF_NAME","��������� ��� �������� ��� ����������");
define("_COMMENTS_FOR_THE_FLIGHT","������ ��� ��� �����");
define("_PHOTO","����������");
define("_PHOTOS_GUIDELINES","�� ����������� ������ �� ����� jpg ��� ����� ");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","������� ��� ��� ������� ��� ������");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","����� ������ ������� �� ��� ������ zip ?");
define("_PRESS_HERE","������� ���");

define("_IS_PRIVATE","��� ������� ���");
define("_MAKE_THIS_FLIGHT_PRIVATE","��� ������� ���");
define("_INSERT_FLIGHT_AS_USER_ID","�������� �� ������� (ID)");
define("_FLIGHT_IS_PRIVATE","� ����� ��� ����� �� ������� ���");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","������ ��������� ������");
define("_IGC_FILE_OF_THE_FLIGHT","������ IGC ��� ������");
define("_DELETE_PHOTO","��������");
define("_NEW_PHOTO","����������");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","������� ��� ��� ������ ��� ��������� ��� ������");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","�� ������� ��� �������� ����� �����");
define("_RETURN_TO_FLIGHT","��������� ���� �����");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","��������� ���� �����");
define("_READY_FOR_SUBMISSION","������ ���� �������");
define("_OLC_MAP","������");
define("_OLC_BARO","���������");


//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","������ �������");
define("_back_to_flights","���������");
define("_pilot_stats","���������� �������");
define("_edit_profile","�����������");
define("_flights_stats","���������� �������");
define("_View_Profile","�������� ������");

define("_Personal_Stuff","��������� ��������");
define("_First_Name","�����");
define("_Last_Name","�������");
define("_Birthdate","��. ��������");
define("_dd_mm_yy","��.��.��");
define("_Sign","�����");
define("_Marital_Status","������������ ���������");
define("_Occupation","���������");
define("_Web_Page","Web ������");
define("_N_A","N/A");
define("_Other_Interests","���� ������������");
define("_Photo","����������");

define("_Flying_Stuff","������� ��������");
define("_note_place_and_date","����� ��������� ��� �����");
define("_Flying_Since","���������� ������ ������");
define("_Pilot_Licence","������� �������");
define("_Paragliding_training","����������");
define("_Favorite_Location","��������� ���������");
define("_Usual_Location","����������� ���������");
define("_Best_Flying_Memory","�������� ��������");
define("_Worst_Flying_Memory","��������� ��������");
define("_Personal_Distance_Record","��������� ����� ���������");
define("_Personal_Height_Record","��������� ����� �����");
define("_Hours_Flown","��������� ���� ������");
define("_Hours_Per_Year","���� ��� ����");

define("_Equipment_Stuff","����������");
define("_Glider","����������");
define("_Harness","���� / �������");
define("_Reserve_chute","��������");
define("_Camera","���. ������");
define("_Vario","�����");
define("_GPS","GPS");
define("_Helmet","������");
define("_Camcorder","������������");

define("_Manouveur_Stuff","SIV - ����������");
define("_note_max_descent_rate","����� ������� ����� �������");
define("_Spiral","������");
define("_Bline","Bline");
define("_Full_Stall","Full Stall");
define("_Other_Manouveurs_Acro","����");
define("_Sat","Sat");
define("_Asymmetric_Spiral","��������� ������");
define("_Spin","����");

define("_General_Stuff","������");
define("_Favorite_Singer","���������� ������������");
define("_Favorite_Movie","��������� ������");
define("_Favorite_Internet_Site","��������� <br>Internet Site");
define("_Favorite_Book","���������� ������");
define("_Favorite_Actor","���������� ��������");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","����� ��� ��� ���������� � ������� ��� �����");
define("_Delete_Photo","�������� �����������");
define("_Your_profile_has_been_updated","�� ������ ��� ���� ��������");
define("_Submit_Change_Data","������ ���������");

//--------------------------------------------
// Added by Martin Jursa, 26.04.2007 for pilot_profile and pilot_profile_edit
//--------------------------------------------
define("_Sex", "����");
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

//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","��:��");

define("_Totals","��������");
define("_First_flight_logged","����� ����� ��� ������������");
define("_Last_flight_logged","��������� ����� ��� ������������");
define("_Flying_period_covered","������� ��������<br>������������� �������");
define("_Total_Distance","�������� ��������");
define("_Total_OLC_Score","�������� ���������� XC");
define("_Total_Hours_Flown","��������� ���� ������");
define("_Total_num_of_flights","��������� ������� �������");

define("_Personal_Bests","��������� �����");
define("_Best_Open_Distance","�������� ������� ��������");
define("_Best_FAI_Triangle","�������� FAI �������");
define("_Best_Free_Triangle","�������� �������� �������");
define("_Longest_Flight","���������� �������� ������");
define("_Best_OLC_score","�������� ���������� XC");
define("_Absolute_Height_Record","������� �������� ��� �������");
define("_Altitute_gain_Record","������� �������� ����� ��� ��� ���������");

define("_Mean_values","����� �����");
define("_Mean_distance_per_flight","���� �������� ��� �����");
define("_Mean_flights_per_Month","����� ������� ������� ��� ����");
define("_Mean_distance_per_Month","���� �������� ��� ����");
define("_Mean_duration_per_Month","���� �������� ��� ����");
define("_Mean_duration_per_flight","���� �������� ��� �����");
define("_Mean_flights_per_Year","����� ������� ������� ��� ����");
define("_Mean_distance_per_Year","���� �������� ��� ����");
define("_Mean_duration_per_Year","���� �������� ��� ����");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","����� ������� ��� ���� �� ������");
define("_Waypoint_Name","����� ����������");
define("_Navigate_with_Google_Earth","��� �� ��� Google_Earth");
define("_See_it_in_Google_Maps","��� �� ��� Google_Maps");
define("_See_it_in_MapQuest","��� �� ��� MapQuest");
define("_COORDINATES","�������������");
define("_FLIGHTS","�������");
define("_SITE_RECORD","����� ����������");
define("_SITE_INFO","����������� ����������");
define("_SITE_REGION","�������");
define("_SITE_LINK","������������ �����������");
define("_SITE_DESCR","��������� ����������/������");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","������������ �����������");
define("_KML_file_made_by","���������� KML �������: ");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","���������� ����������");
define("_WAYPOINT_ADDED","� ��������� ������������");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","����� ����������<br>(������� ��������)");
	
//--------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","����� �������� �������");
function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'���������',2=>'����� FAI1',4=>'����� FAI5',8=>'����������',
						16=>'���������',32=>'Trike',64=>'������������ �����');
	foreach ($CONF_glider_types as $gId=>$gName) if (!$gliderCatList[$gId]) $gliderCatList[$gId]=$gName;
}
setGliderCats();

//--------------------------------------------
// class types
//--------------------------------------------
function setClassList() {
	$CONF_TEMP['gliderClasses'][1]['classes']=array(1=>"Sport (��� ��� DHV 2)",2=>"Open (��� DHV 2/3)",3=>"�������");
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
	$xcTypesList=array(1=>"XC �� 3 �������",2=>"������� �������",4=>"������� FAI �������");
	foreach ($CONF_xc_types as $gId=>$gName) if (!$xcTypesList[$gId]) $xcTypesList[$gId]=$gName;
}
setXCtypesList(); 

//--------------------------------------------
// user prefs  & units
//--------------------------------------------

define("_Your_settings_have_been_updated","�� ��������� ��� ����� �����������");

define("_THEME","��������");
define("_LANGUAGE","������");
define("_VIEW_CATEGORY","����� ����������");
define("_VIEW_COUNTRY","����� �����");
define("_UNITS_SYSTEM" ,"������� �������");
define("_METRIC_SYSTEM","������� (���,�)");
define("_IMPERIAL_SYSTEM","Imperial (�����,�����)");
define("_ITEMS_PER_PAGE","������� ��� ������");

define("_MI","mi");
define("_KM","���");
define("_FT","ft");
define("_M","�");
define("_MPH","���");
define("_KM_PER_HR","���/�");
define("_FPM","fpm");
define("_M_PER_SEC","�/����");

//--------------------------------------------
// index page
//--------------------------------------------

define("_WORLD_WIDE","����������");
define("_National_XC_Leagues_for","������� ����������");
define("_Flights_per_Country","������� ��� ����");
define("_Takeoffs_per_Country","����������� �����");
define("_INDEX_HEADER","����� ������ ���� Leonardo XC League");
define("_INDEX_MESSAGE","�������� �� ��������������� �� ����� ��� ���� � �� ��������� ��� ��� ������������ �������� ��������");

//--------------------------------------------
// NEW 
//--------------------------------------------
define("_MENU_SUMMARY_PAGE","����� ������ (��������)");
define("_Display_ALL","�������� ����");
define("_Display_NONE","�������� ����");
define("_Reset_to_default_view","��������� ��� ������� ���������");
define("_No_Club","������ club/�����");
define("_This_is_the_URL_of_this_page","�� URL ����� ��� �������");
define("_All_glider_types","���� �� �������� ��������");


define("_MENU_SITES_GUIDE","������ �����������");
define("_Site_Guide","������ �����������");

define("_Search_Options","���������");
define("_Below_is_the_list_of_selected_sites","����� ��� ����������� �����������");
define("_Clear_this_list","���������� ��� ������");
define("_See_the_selected_sites_in_Google_Earth","������� ��� ����������� ��� Google Earth");
define("_Available_Takeoffs","���������� �����������");
define("_Search_site_by_name","��������� �� �����");
define("_give_at_least_2_letters","����� ����������� 2 ��������");
define("_takeoff_move_instructions_1","����������� ��� ���� ��� ���������� ����������� ���� ����� ����� �� �� >> � ���� ��� ���������� �� �� > ");
define("_Takeoff_Details","�������� ����������");


define("_Takeoff_Info","����������� ����������");
define("_XC_Info","����������� XC");
define("_Flight_Info","����������� ������");

define("_MENU_LOGOUT","����������");
define("_MENU_LOGIN","�������");
define("_MENU_REGISTER","������� �����������");


define("_Africa","������");
define("_Europe","������");
define("_Asia","����");
define("_Australia","���������");
define("_North_Central_America","������/�������� �������");
define("_South_America","����� �������");

define("_Recent","��������");


define("_Unknown_takeoff","������� ���������");
define("_Display_on_Google_Earth","������� ��� Google Earth");
define("_Use_Man_s_Module","�� �� Man's Module (��������� ����������)");
define("_Line_Color","����� �������");
define("_Line_width","����� �������");
define("_unknown_takeoff_tooltip_1","� ����� ���� �������� ��� �� ������������ ���������");
define("_unknown_takeoff_tooltip_2","��� ������ �� ����� ��� ���������� ������� ��� �� �� ������������ !");
define("_EDIT_WAYPOINT","������ ��������� ����������");
define("_DELETE_WAYPOINT","�������� ����������");
define("_SUBMISION_DATE","��/��� ��������"); // the date a flight was submited to leonardo
define("_TIMES_VIEWED","������� ��������"); // the times that this flight havs been viewed


define("_takeoff_add_help_1","�������� �� �������� ��� ����������� ��� ����� ��� ��������� ��� ��� ���������. ��� ��� ������� �� �������� ����");
define("_takeoff_add_help_2","��� � ��������� ��� �������� (���� ��� �� '������� ���������') ����� � ����� ���� <strong>��� ������ �� ��� ����������</strong>. ����� ������� �� �������� ����.");
define("_takeoff_add_help_3","��� ����� �� ����� ����� ��� ���������� ���� ��� ��� ������� ���� ��� ��� �� ������������ �������� �� ����� ��� ��������.");
define("_Takeoff_Name","����� ����������");
define("_In_Local_Language","��� ��������");
define("_In_English","��� �������");

// New on 2007/02/20 - login screen
define("_ENTER_PASSWORD","����� �� ����� ������ ��� ��� ������ ���.");
define("_SEND_PASSWORD","������ ��� ������ ���");
define("_ERROR_LOGIN","������ ����� ����� ������ � ������.");
define("_AUTO_LOGIN","�������� �������� ��� �� ���� ��������");
define("_USERNAME","�������");
define("_PASSWORD","�������");
define("_PROBLEMS_HELP","��� ����� ���������� ������� ������������� �� ��� �����������");

define("_LOGIN_TRY_AGAIN","������� %s���%s ��� �� ��������������");
define("_LOGIN_RETURN","������� %s���%s ��� �� �������� ���� ������ ������");
// end 2007/02/20

define("_Category","���������");
define("_MEMBER_OF","����� ");
define("_MemberID","�/� ������");
define("_EnterID","�������� �/�");
define("_Clubs_Leagues","������ / ����������");
define("_Pilot_Statistics","���������� �������");
define("_National_Rankings","������� ����������");


// new on 2007/03/08
define("_Select_Club","������� ������");
define("_Close_window","�������� ���������");
define("_Club","�����");
define("_Sponsor","���������");


// new on 2007/03/13
define("_Go_To_Current_Month","������� ��������� ����");
define("_Today_is","������ �����");
define("_Wk","���");
define("_Click_to_scroll_to_previous_month","������� ��� ������� ��� ������������ ����");
define("_Click_to_scroll_to_next_month","������� ��� ������� ��� �������� ����");
define("_Click_to_select_a_month","������� ��� ������� ����");
define("_Click_to_select_a_year","������� ��� ������� �����");
define("_Select_date_as_date.","������� [date] �� �����������"); // do not replace [date], it will be replaced by date.

// end 2007/03/13

// New on 2007/05/18 (alternative GUI_filter)
define("_Filter_NoSelection", "����� �������");
define("_Filter_CurrentlySelected", "�������� �������");
define("_Filter_DialogMultiSelectInfo", "�������� �������� �� Ctrl<BR>��� �� ��������� ����������� ��� ���.");

define('_Filter_FilterTitleIncluding', '������� [items]');
define('_Filter_FilterTitleExcluding', '����������� [items]');
define('_Filter_DialogTitleIncluding', '������� [items]');
define('_Filter_DialogTitleExcluding', '����������� [items]');

define("_Filter_Items_pilot", "�������");
define("_Filter_Items_nacclub", "������");
define("_Filter_Items_country", "�����");
define("_Filter_Items_takeoff", "�����������");

define("_Filter_Button_Select", "�������");
define("_Filter_Button_Delete", "��������");
define("_Filter_Button_Accept", "������� ��������");
define("_Filter_Button_Cancel", "�������");

# menu bar
define("_MENU_FILTER_NEW","Filter **NEW VERSION**");

// end 2007/05/18


// New on 2007/05/23
// second menu NACCclub selection
define("_ALL_NACCLUBS", "���� �� ������");
// Note to translators: use the placeholder $nacname in your translation as it is, don"t translate it
define("_SELECT_NACCLUB", '������� ������-[nacname]');

// pilot profile
define("_FirstOlcYear", "First year of participation in an online XC contest");
define("_FirstOlcYearComment", "Please select the year of your first participation in any online XC contest, not just this one.<br/>This field is relevant for the &quot;newcomer&quot;-rankings.");

//end 2007/05/23

// New on 2007/11/06
define("_Select_Brand","������� ���������");
define("_All_Brands","���� �� ���������");
define("_DAY","����");
define('_Glider_Brand','��������');
define('_Or_Select_from_previous','� �������� ��� �����������');

define('_Explanation_AddToBookmarks_IE', 'Add these filter settings to your favourites');
define('_Msg_AddToBookmarks_IE', 'Click here to add these filter settings to your bookmarks.');
define('_Explanation_AddToBookmarks_nonIE', '(Save this link to your bookmarks.)');
define('_Msg_AddToBookmarks_nonIE', 'To save these filter settings to your bookmarks, use the function Save to bookmarks of your browser.');

define('_PROJECT_HELP','�������');
define('_PROJECT_NEWS','���');
define('_PROJECT_RULES','������� 2007');
define('_PROJECT_RULES2','������� 2008');

//end 2007/11/06
define('_MEAN_SPEED1','���� ��������');
define('_External_Entry','����� ��� ���� server');

// New on 2007/11/25
define('_Altitude','��������');
define('_Speed','��������');
define('_Distance_from_takeoff','��������� ��� ���������');

// New on 2007/12/03
define('_LAST_DIGIT','��������� �����');

define('_Filter_Items_nationality','����������');
define('_Filter_Items_server','server');

// New on 2007/12/15
define('_Ext_text1','���� � ����� ���� ������ ��������� ��� ');
define('_Ext_text2','������� ��� ��� ���� ������ ��� �� ���������');
define('_Ext_text3','��������� ���� ��������� �����');

// New on 2008/2/15
define('_Male_short','�');
define('_Female_short','�');
define('_Male','������');
define('_Female','�������');
define('_Pilot_Statistics','���������� �������');

// New on 2008/2/19
define('_Altitude_Short','����');
define("_Vario_Short","Vario");
define("_Time_Short","���");
define("_Info","����/����");
define("_Control","�������");

define("_Zoom_to_flight","���� ���� �����");
define("_Follow_Glider","���������� �������");
define("_Show_Task","�������� ����");
define("_Show_Airspace","�������� Airspace");

// New on 2008/06/04
define("_Show_Optimization_details","��������� � �����������");

define("_MENU_SEARCH_PILOTS","������� �������");


// New on 2008/11/26
define('_MENU_AREA_GUIDE','�������� �������');
define('_All_XC_types','���� �� ����� XC');
define('_xctype','����� XC');

define('_Flying_Areas','�������� �������');
define('_Name_of_Area','����� ��������');
define('_See_area_details','����� ������������ ����������� ��� ��� ����������� ��� ��������');

define('_choose_ge_module','�������� ��� �����<BR>����������� ��� Google Earth');
define('_ge_module_advanced_1','(��������������, ������� �������)');
define('_ge_module_advanced_2','(����������, ������ �������) ');
define('_ge_module_Simple','����� (���� Task, ����� �������)');

define('_Pilot_search_instructions','�������������� ����������� 3 �������� ��� �� ����� � �� �������');

define('_All_classes','���� �� �������');
define('_Class','�����');

// 2009-03-20 filter for photos
define('_Photos_filter_off','��/����� �����������');
define('_Photos_filter_on','���� �� �����������');

// 2010-03-14
define('_See_The_filter','��������� ��� �������');
define('_PilotBirthdate','��. �������� �������');
define('_Start_Type','����� ����������');
define('_GLIDER_CERT','����������� ��������');

define('_MENU_BROWSER','������� �� Google Maps');
define('_FLIGHT_BROSWER','��������� ��� ����� ��� ������� ��� ����������� ���� Google Maps');
define('_Load_Thermals','�������� ��������');
define('_Loading_thermals','������������ ��������� ��������');

define('_Layers','��������� ������');
define('_Select_Area','������� ��������');


//2010-11-20 commenting system
define('_Leave_a_comment','���������');
define('_Reply','��������');
define('_Translate','���������');
define('_Translate_to','��������� ��');
define('_Submit_Comment','������� �������');
define('_Logged_in_as','����� ������������ ��:');
define('_Name','�����');
define('_Email','Email');
define('_Will_not_be_displayed','(��� �� ����������)');
define('_Please_type_something','������ �� ������ ���');
define('_Please_enter_your_name','����� �� �����/ ��������� ���');
define('_Please_give_your_email','����� �� email ���, ��� �� ���������� ������� ���� ������');
define('_RSS_for_the_comments','����� ����� � ������ ��� ��� ��� RSS ��� �� ������ ����� ��� ������<BR>����� �� Copy - Paste ���� ��������� RSS');

// on profile
define('_Comments_are_enabled_by_default_for_new_flights','�� ������ ����� �������������� ��� ��� ���� �������');

define('_Comments_Enabled','������ ��������������');
define('_Comments_are_enabled_for_this_flight','�� ������ ����� �������������� ��� ���� �� �����');
define('_Comments_are_disabled_for_this_flight','�� ������ ����� ���������������� ��� ���� �� �����');
define('_ERROR_in_setting_the_comments_status','�������� ����� ���� ����������');
define('_Save_changes','���������� �������');
define('_Cancel','�������');
define('_Are_you_sure_you_want_to_delete_this_comment','����� �������� ��� ������ �� ���������� ���� �� ������;');

define('_RSS_feed_for_comments','��� RSS ��� �� ������');
define('_RSS_feed_for_flights','��� RSS ��� ��� �������');
define('_RSS_of_pilots_flights','��� RSS ��� ��� ������� ��� �������');


define('_You_have_a_new_comment','����� ��� ��� ������ ��� %s');
define('_New_comment_email_body','����� ��� ��� ������ ��� %s<BR><BR><a href="%s">���� Click ��� ��� �� ��������� ��� �� ������</a><hr>%s');

define("_Thermals","�������"); 
define("_Remove_From_Favorites","�������� ��� ��� �����������"); 
define("_Favorites","����������� �������"); 
define("_Compare_flights_line_1","������� ��� ������� ����������� �� ������� ��� �������� ����"); 
define("_Compare_flights_line_2","���� ������� �� ��� ���������� ���� ���� �� Google Maps"); 
define("_Compare_Favorite_Tracks","�������� ����������� �������"); 
define("_Remove_all_favorites","�������� ���� ��� ��� �����������"); 
define("_Find_and_Compare_Flights","������ ��� �������� �������"); 
define("_Compare_Selected_Flights","�������� ����������� �������"); 
define("_More","�����������"); 
define("_Close","��������"); 

define("_BREAKDOWN_PER_TAKEOFF","Breakdown Per Takeoff");
define("_BREAKDOWN_PER_GLIDER","Breakdown Per Glider");
?>

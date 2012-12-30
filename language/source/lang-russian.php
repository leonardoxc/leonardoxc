<? if (0){?><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"></head><? } ?><?php
/**************************************************************************/
/*  Russian language translation by                                       */
/*  Andrei Orehov   (nd@large.ru)                                         */
/**************************************************************************/

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
	$monthList=array('������','�������','����','������','���','����',
					'����','������','��������','�������','������','�������');
	$monthListShort=array('JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC');
	$weekdaysList=array('Mon','Tue','Wed','Thu','Fri','Sat','Sun') ;
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","����� �� ���������");
define("_FREE_TRIANGLE","��������� �����������");
define("_FAI_TRIANGLE","����������� FAI");

define("_SUBMIT_FLIGHT_ERROR","��� ���������� ������ �������� ��������");

// list_pilots()
define("_NUM","#");
define("_PILOT","�����");
define("_NUMBER_OF_FLIGHTS","����� �������");
define("_BEST_DISTANCE","������ ���������");
define("_MEAN_KM","������� ���������");
define("_TOTAL_KM","��������� ���������");
define("_TOTAL_DURATION_OF_FLIGHTS","��������� �����");
define("_MEAN_DURATION","������� ����������������� ������");
define("_TOTAL_OLC_KM","��������� �������� ��������� OLC");
define("_TOTAL_OLC_SCORE","��������� ���� OLC");
define("_BEST_OLC_SCORE","������ ���� OLC");
define("_From","�");

// list_flights()
define("_DURATION_HOURS_MIN","����� (�:�)");
define("_SHOW","����������");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","����� ����� ����������� ����� 1-2 ������. ");
define("_TRY_AGAIN","����������, ���������� �������");

define("_TAKEOFF_LOCATION","����� ������");
define("_TAKEOFF_TIME","����� ������");
define("_LANDING_LOCATION","����� �������");
define("_LANDING_TIME","����� �������");
define("_OPEN_DISTANCE","�������� ���������");
define("_MAX_DISTANCE","����. ���������");
define("_OLC_SCORE_TYPE","��� � OLC");
define("_OLC_DISTANCE","��������� � OLC");
define("_OLC_SCORING","����� OLC");
define("_MAX_SPEED","����. ��������");
define("_MAX_VARIO","����. �����");
define("_MEAN_SPEED","������� ��������");
define("_MIN_VARIO","���. �����");
define("_MAX_ALTITUDE","����. ������ (ASL)");
define("_TAKEOFF_ALTITUDE","������ ������ (ASL)");
define("_MIN_ALTITUDE","���. ������ (ASL)");
define("_ALTITUDE_GAIN","����� ������");
define("_FLIGHT_FILE","���� � �������");
define("_COMMENTS","�����������");
define("_RELEVANT_PAGE","������ �� ��������");
define("_GLIDER","����������� �������");
define("_PHOTOS","����������");
define("_MORE_INFO","�������������");
define("_UPDATE_DATA","�������� ������");
define("_UPDATE_MAP","�������� �����");
define("_UPDATE_3D_MAP","�������� 3D-�����");
define("_UPDATE_GRAPHS","�������� �������");
define("_UPDATE_SCORE","�������� �����");

define("_TAKEOFF_COORDS","���������� ������:");
define("_NO_KNOWN_LOCATIONS","��� ����� �� ��������!");
define("_FLYING_AREA_INFO","�������� � �������");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","���������� ������ Leonardo");
define("_RETURN_TO_TOP","������");
// list flight
define("_PILOT_FLIGHTS","������ ������");

define("_DATE_SORT","����");
define("_PILOT_NAME","�����");
define("_TAKEOFF","�����");
define("_DURATION","������������");
define("_LINEAR_DISTANCE","�������� ���������");
define("_OLC_KM","��������� OLC");
define("_OLC_SCORE","����� OLC");
define("_DATE_ADDED","������� ����������");

define("_SORTED_BY","���������� ��:");
define("_ALL_YEARS","��� ����");
define("_SELECT_YEAR_MONTH","������� ��� (� �����)");
define("_ALL","���");
define("_ALL_PILOTS","�������� ���� �������");
define("_ALL_TAKEOFFS","�������� ��� ������");
define("_ALL_THE_YEAR","���� ���");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","�� �� ������� ���� � ������");
define("_NO_SUCH_FILE","��������� ���� ���� �� ������ �� �������");
define("_FILE_DOESNT_END_IN_IGC","���� �� ����� ���������� .igc");
define("_THIS_ISNT_A_VALID_IGC_FILE","��� �� ���� .igc");
define("_THERE_IS_SAME_DATE_FLIGHT","��� ���� ���� � ������ �� ����� � ��������");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","���� ������ �������� ���, �������");
define("_DELETE_THE_OLD_ONE","������� ������");
define("_THERE_IS_SAME_FILENAME_FLIGHT","��� ���� ���� � ����� �� ������");
define("_CHANGE_THE_FILENAME","���� ��� ������ �����, ���������� ������������ ���");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","��� ����� ������ � ����");
define("_PRESS_HERE_TO_VIEW_IT","������� ���� ��� ��� ���������");
define("_WILL_BE_ACTIVATED_SOON","(�� ����� ����������� ����� 1-2 ������)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","�������� ��������� �������");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","����� ���������� ������ ����� IGC");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","������� ��� ZIP-�����<br>� ��������");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","������� ���� ��� ������� �����");

define("_FILE_DOESNT_END_IN_ZIP","���� �� ����� ���������� .zip");
define("_ADDING_FILE","�������� �����");
define("_ADDED_SUCESSFULLY","���� ������� ��������");
define("_PROBLEM","��������");
define("_TOTAL","����� ");
define("_IGC_FILES_PROCESSED","������� ����������");
define("_IGC_FILES_SUBMITED","������� ���������");

// info
define("_DEVELOPMENT","����������");
define("_ANDREADAKIS_MANOLIS","������� �����������");
define("_PROJECT_URL","�������� �������");
define("_VERSION","������");
define("_MAP_CREATION","�������� ����");
define("_PROJECT_INFO","���������� � �������");

// menu bar 
define("_MENU_MAIN_MENU","������� ����");
define("_MENU_DATE","������");
define("_MENU_COUNTRY","������");
define("_MENU_XCLEAGUE","���������� ����");
define("_MENU_ADMIN","�����");

define("_MENU_COMPETITION_LEAGUE","���� - ��� ���������");
define("_MENU_OLC","OLC");
define("_MENU_OPEN_DISTANCE","�������� ���������");
define("_MENU_DURATION","�����");
define("_MENU_ALL_FLIGHTS","�������� ��� ������");
define("_MENU_FLIGHTS","������");
define("_MENU_TAKEOFFS","�����");
define("_MENU_FILTER","������");
define("_MENU_MY_FLIGHTS","��� ������");
define("_MENU_MY_PROFILE","��� �������");
define("_MENU_MY_STATS","��� ����������"); 
define("_MENU_MY_SETTINGS","��� ���������"); 
define("_MENU_SUBMIT_FLIGHT","�������� �����");
define("_MENU_SUBMIT_FROM_ZIP","�������� zip-���� � ��������");
define("_MENU_SHOW_PILOTS","������");
define("_MENU_SHOW_LAST_ADDED","������� ����������");
define("_FLIGHTS_STATS","���������� �������");

define("_SELECT_YEAR","������� ���");
define("_SELECT_MONTH","������� �����");
define("_ALL_COUNTRIES","�������� ��� ������");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","��� �����");
define("_NUMBER_OF_FLIGHTS","���-�� �������");
define("_TOTAL_DISTANCE","��������� ���������");
define("_TOTAL_DURATION","��������� �����");
define("_BEST_OPEN_DISTANCE","������ �������� ���������");
define("_TOTAL_OLC_DISTANCE","��������� ��������� OLC");
define("_TOTAL_OLC_SCORE","��������� ���� OLC");
define("_BEST_OLC_SCORE","������ ���� OLC");
define("_MEAN_DURATION","������� �����");
define("_MEAN_DISTANCE","������� ���������");
define("_PILOT_STATISTICS_SORT_BY","������ - ���������� ��");
define("_CATEGORY_FLIGHT_NUMBER","��������� '����������������' - ���������� �������");
define("_CATEGORY_TOTAL_DURATION","��������� 'DURACELL' - ��������� ����� � �������");
define("_CATEGORY_OPEN_DISTANCE","��������� '�������� ���������'");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","�� ������ ������!");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","����� ������");
define("_RETURN","�����");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","�������� - �� ������ ������� ���� �����");
define("_THE_DATE","���� ");
define("_YES","��");
define("_NO","���");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","���������� � ����");
define("_N_BEST_FLIGHTS"," ������ �������");
define("_OLC","OLC");
define("_OLC_TOTAL_SCORE","��������� ���� OLC");
define("_KILOMETERS","���������");
define("_TOTAL_ALTITUDE_GAIN","��������� ����� ������");
define("_TOTAL_KM","����� ��");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","");
define("_IS_NOT","��");
define("_OR","���");
define("_AND","�");
define("_FILTER_PAGE_TITLE","������������� ������");
define("_RETURN_TO_FLIGHTS","��������� � �������");
define("_THE_FILTER_IS_ACTIVE","������ �������");
define("_THE_FILTER_IS_INACTIVE","������ ���������");
define("_SELECT_DATE","������� ����");
define("_SHOW_FLIGHTS","�������� ������");
define("_ALL2","���");
define("_WITH_YEAR","���");
define("_MONTH","�����");
define("_YEAR","���");
define("_FROM","�");
define("_from","��");
define("_TO","��");
define("_SELECT_PILOT","������� ������");
define("_THE_PILOT","�����");
define("_THE_TAKEOFF","�����");
define("_SELECT_TAKEOFF","������� �����");
define("_THE_COUNTRY","������");
define("_COUNTRY","������");
define("_SELECT_COUNTRY","������� ������");
define("_OTHER_FILTERS","������ �������");
define("_LINEAR_DISTANCE_SHOULD_BE","�������� ���������");
define("_OLC_DISTANCE_SHOULD_BE","��������� OLC");
define("_OLC_SCORE_SHOULD_BE","���� OLC");
define("_DURATION_SHOULD_BE","�����������������");
define("_ACTIVATE_CHANGE_FILTER","������������ / �������� ������");
define("_DEACTIVATE_FILTER","�������������� ������");
define("_HOURS","�����");
define("_MINUTES","�����");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","�������� �����");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(����� ������ ���� IGC)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","������� ���<br>����� IGC");
define("_NOTE_TAKEOFF_NAME","����������, ������� �������� ������ � ������");
define("_COMMENTS_FOR_THE_FLIGHT","����������� � ������");
define("_PHOTO","����");
define("_PHOTOS_GUIDELINES","���������� ������ ���� � ������� jpg � ������ ");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","������� ���� ��� �������� ������");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","�� ������ �������� ����� ��������� �������?");
define("_PRESS_HERE","������� ����");

define("_IS_PRIVATE","������ �� ����������");
define("_MAKE_THIS_FLIGHT_PRIVATE","������ �� ����������");
define("_INSERT_FLIGHT_AS_USER_ID","�������� ����� ��� ������������");
define("_FLIGHT_IS_PRIVATE","���� ����� �� ��� ���������� ���������");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","�������� ������ � ������");
define("_IGC_FILE_OF_THE_FLIGHT","���� IGC");
define("_DELETE_PHOTO","�������");
define("_NEW_PHOTO","��� ����");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","������� ���� ��� ��������� ������ � ������");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","��������� ���������");
define("_RETURN_TO_FLIGHT","��������� � ������");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","��������� � ������");
define("_READY_FOR_SUBMISSION","��� ������ ��� ���������");
define("_OLC_MAP","�����");
define("_OLC_BARO","��������");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","������� ������");
define("_back_to_flights","����� � �������");
define("_pilot_stats","���������� ������");
define("_edit_profile","������������� �������");
define("_flights_stats","���������� �������");
define("_View_Profile","�������� �������");

define("_Personal_Stuff","������ ������");
define("_First_Name","���");
define("_Last_Name","�������");
define("_Birthdate","���� ��������");
define("_dd_mm_yy","��.��.��");
define("_Sign","���� �������");
define("_Marital_Status","�������� ���������");
define("_Occupation","�������");
define("_Web_Page","���-��������");
define("_N_A","��� ����������");
define("_Other_Interests","������ ��������");
define("_Photo","����");

define("_Flying_Stuff","�������� ������");
define("_note_place_and_date","��� �������, ������� ����� (������) � ����");
define("_Flying_Since","����� �");
define("_Pilot_Licence","�������� ������");
define("_Paragliding_training","��������");
define("_Favorite_Location","������� ����� �������");
define("_Usual_Location","������� ����� �������");
define("_Best_Flying_Memory","������ ������������ � ������");
define("_Worst_Flying_Memory","������ ������������ � ������");
define("_Personal_Distance_Record","������ ������ ���������");
define("_Personal_Height_Record","������ ������ ������");
define("_Hours_Flown","����� � �����");
define("_Hours_Per_Year","������� �����");

define("_Equipment_Stuff","������ � ����������");
define("_Glider","����������� �������");
define("_Harness","��������");
define("_Reserve_chute","�������");
define("_Camera","����������");
define("_Vario","�����");
define("_GPS","GPS");
define("_Helmet","����");
define("_Camcorder","�����������");

define("_Manouveur_Stuff","������ � ��������");
define("_note_max_descent_rate","��� �������, ������� ����. �������� ��������");
define("_Spiral","�������");
define("_Bline","B-����");
define("_Full_Stall","������ ����");
define("_Other_Manouveurs_Acro","������ ����-�������");
define("_Sat","���");
define("_Asymmetric_Spiral","������������� �������");
define("_Spin","���������� �������");

define("_General_Stuff","������");
define("_Favorite_Singer","������� ����� (������)");
define("_Favorite_Movie","������� �����");
define("_Favorite_Internet_Site","������� ���-����");
define("_Favorite_Book","������� �����");
define("_Favorite_Actor","������� ������(��)");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","��������� ����� ���� ��� �������� ������");
define("_Delete_Photo","������� ����");
define("_Your_profile_has_been_updated","��� ������� ��������");
define("_Submit_Change_Data","��������� ������");

//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","��:��");

define("_Totals","�����");
define("_First_flight_logged","������ ������������������ �����");
define("_Last_flight_logged","������� ������������������ �����");
define("_Flying_period_covered","���������� ������ �������");
define("_Total_Distance","��������� ���������");
define("_Total_OLC_Score","��������� ���� OLC");
define("_Total_Hours_Flown","��������� �����");
define("_Total_num_of_flights","��������� ���������� ������� ");

define("_Personal_Bests","������ �������");
define("_Best_Open_Distance","������ �������� ���������");
define("_Best_FAI_Triangle","������ ����������� FAI");
define("_Best_Free_Triangle","������ ��������� �����������");
define("_Longest_Flight","����� ������ �����");
define("_Best_OLC_score","������ ���� OLC");
define("_Absolute_Height_Record","���������� ������ ������");
define("_Altitute_gain_Record","������ ������ ������");

define("_Mean_values","������� ��������");
define("_Mean_distance_per_flight","������� ��������� ������");
define("_Mean_flights_per_Month","� ������� ������� � �����");
define("_Mean_distance_per_Month","������� ��������� � �����");
define("_Mean_duration_per_Month","������� ����� � �����");
define("_Mean_duration_per_flight","������� ������������ ������");
define("_Mean_flights_per_Year","� ������� ������� � ���");
define("_Mean_distance_per_Year","������� ��������� � ���");
define("_Mean_duration_per_Year","������� ����� � ���");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","�������� ������ ����� � ���� ������");
define("_Waypoint_Name","��� �����");
define("_Navigate_with_Google_Earth","���������� � Google Earth");
define("_See_it_in_Google_Maps","���������� � Google Maps");
define("_See_it_in_MapQuest","���������� �  MapQuest");
define("_COORDINATES","����������");
define("_FLIGHTS","������");
define("_SITE_RECORD","������ �����");
define("_SITE_INFO","���������� � �����");
define("_SITE_REGION","������");
define("_SITE_LINK","������ �� �����������");
define("_SITE_DESCR","�������� ����� (������)");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","��� �����������");
define("_KML_file_made_by","KML file ���� ������");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","������ ����� ����� (�����)");
define("_WAYPOINT_ADDED","����� ���������������");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","������ �����<br>(�������� ���������)");
	
//--------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","��� ��");
function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'��������',2=>'���������� FAI1',4=>'������� ����� FAI5',8=>'������');
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

define("_Your_settings_have_been_updated","���� ��������� ���������");

define("_THEME","����");
define("_LANGUAGE","����");
define("_VIEW_CATEGORY","�������� ���������");
define("_VIEW_COUNTRY","�������� ������");
define("_UNITS_SYSTEM" ,"������� ���");
define("_METRIC_SYSTEM","����������� (��, �)");
define("_IMPERIAL_SYSTEM","�������� (����, ����)");
define("_ITEMS_PER_PAGE","������� �� ��������");

define("_MI","mi");
define("_KM","��");
define("_FT","ft");
define("_M","�");
define("_MPH","mph");
define("_KM_PER_HR","��/�");
define("_FPM","fpm");
define("_M_PER_SEC","�/�");

//--------------------------------------------
// index page
//--------------------------------------------

define("_WORLD_WIDE","���� ���");
define("_National_XC_Leagues_for","������������ ���������� ���� ��");
define("_Flights_per_Country","������ �� �������");
define("_Takeoffs_per_Country","������ ����� �� �������");
define("_INDEX_HEADER","����� ���������� � ���������� ���� Leonardo");
define("_INDEX_MESSAGE","����������� &quot;������� ����&quot; ��� ��������� ��� ����������� �������� ���������� ������ �����.");


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
define('_Go_To_Current_Month','Go To Current Month');
define('_Today_is','Today is');
define('_Wk','Wk');
define('_Click_to_scroll_to_previous_month','Click to scroll to previous month. Hold mouse button to scroll automatically.');
define('_Click_to_scroll_to_next_month','Click to scroll to next month. Hold mouse button to scroll automatically.');
define('_Click_to_select_a_month','Click to select a month.');
define('_Click_to_select_a_year','Click to select a year.');
define('_Select_date_as_date.','Select [date] as date.'); // do not replace [date], it will be replaced by date.

// end 2007/03/13

define("_BREAKDOWN_PER_TAKEOFF","Breakdown Per Takeoff");
define("_BREAKDOWN_PER_GLIDER","Breakdown Per Glider");
?>

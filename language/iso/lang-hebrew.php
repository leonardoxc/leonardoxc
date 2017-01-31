<? if (0){?><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-8"></head><? }?><?php

/**************************************************************************/
/*  Translation to Hebrew by                                              */
/*  Dmitry N. Korogodin  (novanow@012.net.il)  NOVA ISRAEL TEL AVIV 2007  */
/**************************************************************************/


/************************************************************************/
/* Leonardo: Gliding XC Server	     	                              */
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
	$monthList=array('�����','������','���','�����','���','����',
					'����','������','������','�������','������','�����');
	$monthListShort=array('���','���','���','���','���','���','���','���','���','���','���','���');
	$weekdaysList=array('�','�','�','�','�','�','�') ;
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","���� ������");
define("_FREE_TRIANGLE","����� �����");
define("_FAI_TRIANGLE","FAI����� ");

define("_SUBMIT_FLIGHT_ERROR","����� ���� �� ������� ������ ");

// list_pilots()
define("_NUM","#");
define("_PILOT","����");
define("_NUMBER_OF_FLIGHTS","���� �����");
define("_BEST_DISTANCE","���� �����");
define("_MEAN_KM"," # ������ ��������� ��� ����");
define("_TOTAL_KM","����� ����� ,�������");
define("_TOTAL_DURATION_OF_FLIGHTS","����� �� ��� �����");
define("_MEAN_DURATION"," ����� �� ��� �����");
define("_TOTAL_OLC_KM","OLC ����� ����");
define("_TOTAL_OLC_SCORE","OLC ����� ������");
define("_BEST_OLC_SCORE","OLC ������� ����");
define("_From","���");

// list_flights()
define("_DURATION_HOURS_MIN","��� (�:�)");
define("_SHOW","�����");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","���� ����� ����� �������");
define("_TRY_AGAIN","�� ����� ����� ����");

define("_TAKEOFF_LOCATION","�����");
define("_TAKEOFF_TIME","��� �����");
define("_LANDING_LOCATION","�����");
define("_LANDING_TIME","����� ���");
define("_OPEN_DISTANCE","���� ����");
define("_MAX_DISTANCE","��� �����");
define("_OLC_SCORE_TYPE","OLC��� �� ������ ");
define("_OLC_DISTANCE","OLC ����");
define("_OLC_SCORING","OLC ������");
define("_MAX_SPEED", "��� �������");
define("_MAX_VARIO","��� �����");
define("_MEAN_SPEED","������ ������");
define("_MIN_VARIO","���� �����");
define("_MAX_ALTITUDE","��� ����� ��� ��� ���");
define("_TAKEOFF_ALTITUDE","���� ����� ��� ��� ���");
define("_MIN_ALTITUDE","���� ���� ��� ��� ���");
define("_ALTITUDE_GAIN","���� �����");
define("_FLIGHT_FILE","���� ����");
define("_COMMENTS","������");
define("_RELEVANT_PAGE","������� URL �� ");
define("_GLIDER","����");
define("_PHOTOS","������");
define("_MORE_INFO","���� ����");
define("_UPDATE_DATA","����� ������");
define("_UPDATE_MAP","����� ���");
define("_UPDATE_3D_MAP","����� ��� ���-�����");
define("_UPDATE_GRAPHS","����� �����");
define("_UPDATE_SCORE","����� ������");

define("_TAKEOFF_COORDS",": ����������� �����");
define("_NO_KNOWN_LOCATIONS","����� ���� ����!");
define("_FLYING_AREA_INFO","���� �� ���� ����");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","XC������� ");
define("_RETURN_TO_TOP","����� �����");
// list flight
define("_PILOT_FLIGHTS","����� �� ����");

define("_DATE_SORT","�����");
define("_PILOT_NAME","�� ����");
define("_TAKEOFF","�����");
define("_DURATION","��� ���");
define("_LINEAR_DISTANCE","���� ����");
define("_OLC_KM"," ���������OLC");
define("_OLC_SCORE","OLC ������");
define("_DATE_ADDED","���� �������");

define("_SORTED_BY",":���� ���");
define("_ALL_YEARS","�� �����");
define("_SELECT_YEAR_MONTH","�� ����� ��� (�� ����)");
define("_ALL","����");
define("_ALL_PILOTS","����� ��� �������");
define("_ALL_TAKEOFFS","����� ��� �������");
define("_ALL_THE_YEAR","��� �����");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","����� ���� ���� ����");
define("_NO_SUCH_FILE","���� ����� ���� ���� ����");
define("_FILE_DOESNT_END_IN_IGC",".igc ������ �� ���� ����� ���� ������ ��� ");
define("_THIS_ISNT_A_VALID_IGC_FILE","���� ����� .igc����� ");
define("_THERE_IS_SAME_DATE_FLIGHT","����� �� ���� ����� ���� ��� ����");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","����� ����� ����, ���� ���");
define("_DELETE_THE_OLD_ONE","����� ���� ����");
define("_THERE_IS_SAME_FILENAME_FLIGHT","����� �� ���� �� ��� ����");
define("_CHANGE_THE_FILENAME","����� ����� ���� ��� ���� ���� ��� ����� �� ��� ������ ���!");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","����� ���� ����� ������!");
define("_PRESS_HERE_TO_VIEW_IT","�� ����� ��� �����");
define("_WILL_BE_ACTIVATED_SOON","(���� ������ ���� ��� ����)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","����� ���� �����");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","IGC�� ������ ����� �� ����� ");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS"," ����� �����<br>ZIP ����� ����");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","�� ����� ��� ����� �����");

define("_FILE_DOESNT_END_IN_ZIP",".zip������ �� ���� ����� ���� ������ ��� ");
define("_ADDING_FILE","���� ����");
define("_ADDED_SUCESSFULLY","���� ������");
define("_PROBLEM","����");
define("_TOTAL","�����");
define("_IGC_FILES_PROCESSED","����� ��� �������");
define("_IGC_FILES_SUBMITED"," ����� ��� ������");

// info
define("_DEVELOPMENT","�����");
define("_ANDREADAKIS_MANOLIS","������ ���������");
define("_PROJECT_URL","�� ������� ����� �������");
define("_VERSION","�����");
define("_MAP_CREATION","����� ���");
define("_PROJECT_INFO","���� �� ������");

// menu bar 
define("_MENU_MAIN_MENU","����� �����");
define("_MENU_DATE","�� ����� �����");
define("_MENU_COUNTRY","����� ���");
define("_MENU_XCLEAGUE","XC����� ");
define("_MENU_ADMIN","����");

define("_MENU_COMPETITION_LEAGUE","����� � ��� ������");
define("_MENU_OLC","OLC");
define("_MENU_OPEN_DISTANCE","���� ����");
define("_MENU_DURATION","��� ���");
define("_MENU_ALL_FLIGHTS","����� ��� ������");
define("_MENU_FLIGHTS","�����");
define("_MENU_TAKEOFFS","������");
define("_MENU_FILTER","����");
define("_MENU_MY_FLIGHTS","����� ���");
define("_MENU_MY_PROFILE","������ ���");
define("_MENU_MY_STATS","��������� ���"); 
define("_MENU_MY_SETTINGS","������ ���"); 
define("_MENU_SUBMIT_FLIGHT","����� ���� ");
define("_MENU_SUBMIT_FROM_ZIP","ZIP ����� ���� ����� ");
define("_MENU_SHOW_PILOTS","������");
define("_MENU_SHOW_LAST_ADDED"," ����� �� ����� ������ ������� ");
define("_FLIGHTS_STATS","��������� �����");

define("_SELECT_YEAR","����� ���");
define("_SELECT_MONTH","����� ����");
define("_ALL_COUNTRIES","����� ��� ������");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","���� �� ����");
define("_NUMBER_OF_FLIGHTS","���� �����");
define("_TOTAL_DISTANCE","����� ����");
define("_TOTAL_DURATION","����� ��� ���");
define("_BEST_OPEN_DISTANCE","���� �����");
define("_TOTAL_OLC_DISTANCE","OLC ����� ����");
define("_TOTAL_OLC_SCORE","OLC����� ������ ");
define("_BEST_OLC_SCORE","OLC���� ������� ");
define("_MEAN_DURATION","������ ��� ���");
define("_MEAN_DISTANCE","������ ����");
define("_PILOT_STATISTICS_SORT_BY","������ � ����� ���");
define("_CATEGORY_FLIGHT_NUMBER","���� ����� 'FastJoe'-��� ");
define("_CATEGORY_TOTAL_DURATION","��� ���� �����'DURACELL' ��� -");
define("_CATEGORY_OPEN_DISTANCE","'Open Distance'��� -");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","��� ������ �����!");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","����� �����");
define("_RETURN","����� ����");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED"," ������! ��� ������ ����� �� �����? ");
define("_THE_DATE","�����");
define("_YES","��");
define("_NO","��");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","������� �� �����");
define("_N_BEST_FLIGHTS","���� ������");
define("_OLC","OLC");
define("_OLC_TOTAL_SCORE","OLC����� ������� ");
define("_KILOMETERS","���������");
define("_TOTAL_ALTITUDE_GAIN","����� ����� �����");
define("_TOTAL_KM","����� ����������");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","����");
define("_IS_NOT","���� ����");
define("_OR","��");
define("_AND","��");
define("_FILTER_PAGE_TITLE","�� ���� �����");
define("_RETURN_TO_FLIGHTS","�� ���� ������");
define("_THE_FILTER_IS_ACTIVE","����� �����");
define("_THE_FILTER_IS_INACTIVE","����� �����");
define("_SELECT_DATE","�� ����� �����");
define("_SHOW_FLIGHTS","�� ����� �����");
define("_ALL2","����");
define("_WITH_YEAR","����");
define("_MONTH","����");
define("_YEAR","���");
define("_FROM","���");
define("_from","���");
define("_TO","��");
define("_SELECT_PILOT","�� ����� ����");
define("_THE_PILOT","�����");
define("_THE_TAKEOFF","������");
define("_SELECT_TAKEOFF","�� ����� �� ������");
define("_THE_COUNTRY","����");
define("_COUNTRY","���");
define("_SELECT_COUNTRY","�� ����� �� ����");
define("_OTHER_FILTERS","������ �����");
define("_LINEAR_DISTANCE_SHOULD_BE","���� ���� �����");
define("_OLC_DISTANCE_SHOULD_BE"," �����OLC���� ");
define("_OLC_SCORE_SHOULD_BE","������ OLC������ ");
define("_DURATION_SHOULD_BE","��� ��� ����");
define("_ACTIVATE_CHANGE_FILTER","������\����� ����");
define("_DEACTIVATE_FILTER","���� ����");
define("_HOURS","����");
define("_MINUTES","����");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","����� ����");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(IGC ���� �� ����)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","<br>IGC ����� ���� ����");
define("_NOTE_TAKEOFF_NAME","��� ����� �� ���� ����� ����");
define("_COMMENTS_FOR_THE_FLIGHT","������ ����");
define("_PHOTO","�����");
define("_PHOTOS_GUIDELINES","������ �� ���� � jpg ������ ������ ����� ����� ���� ");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","������ ���� ��� ����� ���");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","��� ������ ����� ���� ������ ��� ��-����?");
define("_PRESS_HERE","��� ����� ���");

define("_IS_PRIVATE","�� ����� ������");
define("_MAKE_THIS_FLIGHT_PRIVATE","�� ����� ������");
define("_INSERT_FLIGHT_AS_USER_ID","���� �� ����� ��� ���� �����");
define("_FLIGHT_IS_PRIVATE","����� ��� ��� ���� �����");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","����� ����� ����");
define("_IGC_FILE_OF_THE_FLIGHT","IGC ���� ���� ");
define("_DELETE_PHOTO","�����");
define("_NEW_PHOTO","����� ����");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","������ ����� ���� �� ����� ���");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","������� ����� ������");
define("_RETURN_TO_FLIGHT","����� �����");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","����� �����");
define("_READY_FOR_SUBMISSION","���� �����");
define("_SUBMIT_TO_OLC","OLC����� �");
define("_OLC_MAP","���");
define("_OLC_BARO","���-���");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","������ ����");
define("_back_to_flights","�� ����� ������");
define("_pilot_stats","��������� ����");
define("_edit_profile","����� ������");
define("_flights_stats","��������� �����");
define("_View_Profile","����� ������");

define("_Personal_Stuff","���� ����");
define("_First_Name","�� ����");
define("_Last_Name","�� �����");
define("_Birthdate","����� ���� ");
define("_dd_mm_yy","dd.mm.yy");
define("_Sign","�����");
define("_Marital_Status","��� ������");
define("_Occupation","�����");
define("_Web_Page","�� ����");
define("_N_A","�� ����");
define("_Other_Interests","�������");
define("_Photo","�����");

define("_Flying_Stuff","���� �����");
define("_note_place_and_date","�� ������� �� ����� �� ������ ����� �����");
define("_Flying_Since","����� ���");
define("_Pilot_Licence","����� ����");
define("_Paragliding_training","������ �������");
define("_Favorite_Location","��� �����");
define("_Usual_Location","��� �����");
define("_Best_Flying_Memory","���� �������� ���");
define("_Worst_Flying_Memory"," �������� ��� ��������");
define("_Personal_Distance_Record","��� ���� ����");
define("_Personal_Height_Record","��� ���� ����");
define("_Hours_Flown","���� ������");
define("_Hours_Per_Year","���� ��� ����");

define("_Equipment_Stuff","���� ����");
define("_Glider","����");
define("_Harness","�����");
define("_Reserve_chute","���� �����");
define("_Camera","�����");
define("_Vario","����");
define("_GPS","����� ����� �������");
define("_Helmet","����");
define("_Camcorder","����� �����");

define("_Manouveur_Stuff","����� ����");
define("_note_max_descent_rate","�� ����� �� ����� ����� ����� ");
define("_Spiral","������ ");
define("_Bline","Bline");
define("_Full_Stall","������� ����");
define("_Other_Manouveurs_Acro","����� Acro�������� ");
define("_Sat","SAT");
define("_Asymmetric_Spiral","������ ��������");
define("_Spin","������ �������");

define("_General_Stuff","���� ����");
define("_Favorite_Singer","��� �����");
define("_Favorite_Movie","������ �����");
define("_Favorite_Internet_Site"," �����<br>��� ������� ");
define("_Favorite_Book","��� �����");
define("_Favorite_Actor","���� �����");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","������ ����� ���� �� ������  �� ������");
define("_Delete_Photo","����� �����");
define("_Your_profile_has_been_updated","������� ��� ��� ������ ������");
define("_Submit_Change_Data","����� � ����� �� �����");


//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","hh:mm");

define("_Totals","�����");
define("_First_flight_logged","���� ������ ������");
define("_Last_flight_logged","���� ������ ������");
define("_Flying_period_covered","��� ������ ���");
define("_Total_Distance","����� �����");
define("_Total_OLC_Score","OLC����� ������� ");
define("_Total_Hours_Flown","����� ���� ���");
define("_Total_num_of_flights","����� # ����� ");

define("_Personal_Bests","����� ������");
define("_Best_Open_Distance","���� ����� ����");
define("_Best_FAI_Triangle","FAI���� ������ ");
define("_Best_Free_Triangle","���� ������ �����");
define("_Longest_Flight","���� ���� ��� ����");
define("_Best_OLC_score","OLC���� ������� ");

define("_Absolute_Height_Record","��� ���� �����");
define("_Altitute_gain_Record","��� ���� ����");
define("_Mean_values","����� ���");
define("_Mean_distance_per_flight","����� ����� ��� ����");
define("_Mean_flights_per_Month","����� ����� ����� ��� ����");
define("_Mean_distance_per_Month","����� ����� ��� ����");
define("_Mean_duration_per_Month","����� ���� ��� ���� ��� ����");
define("_Mean_duration_per_flight","����� ���� ��� ���� ��� ���");
define("_Mean_flights_per_Year","����� ����� ����� ��� ���");
define("_Mean_distance_per_Year","����� ����� ��� ���");
define("_Mean_duration_per_Year","����� ���� ��� ���� ��� ���");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","����� ����� ������ ������ ���");
define("_Waypoint_Name","�� ����� ��������");
define("_Navigate_with_Google_Earth","Google Earth����� �");
define("_See_it_in_Google_Maps","Google Maps����� �");
define("_See_it_in_MapQuest","MapQuest����� �");
define("_COORDINATES","�����������");
define("_FLIGHTS","�����");
define("_SITE_RECORD","����� ����");
define("_SITE_INFO","���� ���");
define("_SITE_REGION","����");
define("_SITE_LINK","����� ��� ����� ����");
define("_SITE_DESCR","���� �����/����� ���");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","�� ����� ������ ������");
define("_KML_file_made_by"," ���� �� ���KML ����� ");

//--------------------------------------------
// add_waypoint.php WAY POINT IS NOT THE SAME THING THAT TAKEOFF!!!
//--------------------------------------------
define("_ADD_WAYPOINT","������ �� ����� �����");
define("_WAYPOINT_ADDED","������ ����� ������");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","���� �� ����� ����� <br>(open distance)");
	
//--------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","��� �� ����");
function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'���� �����',2=>'��� �������  FAI1',4=>'��� ��� FAI5',8=>'����');
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

define("_Your_settings_have_been_updated","������� ��� ��� �������� ������! ");

define("_THEME","����");
define("_LANGUAGE","���");
define("_VIEW_CATEGORY","����� ���");
define("_VIEW_COUNTRY","����� ���");
define("_UNITS_SYSTEM" ,"������ �����");
define("_METRIC_SYSTEM","���� (�������, ���");
define("_IMPERIAL_SYSTEM","��������� (�����,���) ");
define("_ITEMS_PER_PAGE","������ �����");

define("_MI","��");
define("_KM","��");
define("_FT","��");
define("_M","�");
define("_MPH","��\�");
define("_KM_PER_HR","��\�");
define("_FPM","��\�");
define("_M_PER_SEC","�\����");

//--------------------------------------------
// index page
//--------------------------------------------

define("_WORLD_WIDE","���� ����");
define("_National_XC_Leagues_for","XC������� ������� ");
define("_Flights_per_Country","����� ���� ���");
define("_Takeoffs_per_Country","������ ���� ���");
define("_INDEX_HEADER","XC������ ����� ������ ������� ");
define("_INDEX_MESSAGE"," ��� ����� �� ����� �����&quot;Main menu&quot;�� ������ �
");

//--------------------------------------------
// NEW 
//--------------------------------------------
define("_MENU_SUMMARY_PAGE","����� (�����) ��");
define("_Display_ALL","����� ����");
define("_Display_NONE","�� ����� ��� ���");
define("_Reset_to_default_view","������ ����� ����� ����");
define("_No_Club","��� ������");
define("_This_is_the_URL_of_this_page","��� ������ �� �� ���");
define("_All_glider_types","��� ����� �� ������");

define("_MENU_SITES_GUIDE","����� ������� �����");
define("_Site_Guide","����� ����");

define("_Search_Options","������ �����");
define("_Below_is_the_list_of_selected_sites","����� ������ �� ����� ������");
define("_Clear_this_list","����� �����");
define("_See_the_selected_sites_in_Google_Earth"," Google Earth ��� ������ �� ����� ������� � ");
define("_Available_Takeoffs","������ ������");
define("_Search_site_by_name","���� ��� ��� ���");
define("_give_at_least_2_letters","�� ����� ����� ��� ������");
define("_takeoff_move_instructions_1","
�� ������ ��� ������ ������ ��� ���� ������� ���� �� << �� �� ���� ����� ������� <");
define("_Takeoff_Details","����� ������");


define("_Takeoff_Info","���� ������");
define("_XC_Info","XC���� ");
define("_Flight_Info","���� ����");

define("_MENU_LOGOUT","���� �����");
define("_MENU_LOGIN","����� ������");
define("_MENU_REGISTER","����� �����");


define("_Africa","������");
define("_Europe","������");
define("_Asia","����");
define("_Australia","��������");
define("_North_Central_America","���� � ���� ������");
define("_South_America","���� ������");

define("_Recent","�������");


define("_Unknown_takeoff","���� ����� ���� ����!");
define("_Display_on_Google_Earth","Google Earth����� �");
define("_Use_Man_s_Module","Man's Module������ �");
define("_Line_Color","��� ��");
define("_Line_width","���� ��");
define("_unknown_takeoff_tooltip_1","����� ��� �� ���� ����� ���� ����");
define("_unknown_takeoff_tooltip_2","�� ���� �� ����� ����� �� ���� ��� �� ���� �����!");
define("_EDIT_WAYPOINT","����� ���� �����");
define("_DELETE_WAYPOINT","����� �����");
define("_SUBMISION_DATE","����� ����"); // the date a flight was submited to leonardo
define("_TIMES_VIEWED"," ���� ����� �� �����"); // the times that this flight havs been viewed


define("_takeoff_add_help_1"," OK�� ���� �� ���� �����, �� ���� �� ������. �� ��, �� ����� �� ������ �� ��� ���� �");
define("_takeoff_add_help_2"," ��� ���� ����� ���� ��� ���. �� ����� �� �����'���� ���� �����'�� ����� �� ����� ���� ������ ��� ");
define("_takeoff_add_help_3"," �� ����� �� ����� ���� ������ ���� �� ����� ���� ������ �������  .");
define("_Takeoff_Name","�� ���� �����");
define("_In_Local_Language","���� ������");
define("_In_English","�������");

// New on 2007/02/20 - login screen
define("_ENTER_PASSWORD","�� ����� �� ��� ����� ������ ���� ����� ������");
define("_SEND_PASSWORD","����� �� ������?");
define("_ERROR_LOGIN","������ ���� ����� ��� ����� �� ����� ���� �������");
define("_AUTO_LOGIN","����� ����� �������� ��� ����� ���");
define("_USERNAME","�� �����");
define("_PASSWORD","�����");
define("_PROBLEMS_HELP","�� ����� ����� �� ������ ����� �����");

define("_LOGIN_TRY_AGAIN","������� ����� %s���%s �� ����� ");
define("_LOGIN_RETURN"," ����� ������� %s���%s �� ����� ");
// end 2007/02/20

define("_Category","���");
define("_MEMBER_OF","��� �- ");
define("_MemberID","���� ��� ");
define("_EnterID","�� ������ ����");
define("_Clubs_Leagues","�������� / ������ ");
define("_Pilot_Statistics","��������� �� ����");
define("_National_Rankings","����� ����� ");

// new on 2007/03/08
define("_Select_Club","�� ����� �� �������");
define("_Close_window","�� ����� �� �����");
define("_EnterID","�� ������ ����");
define("_Club","�������");
define("_Sponsor"," ���� ����");


// new on 2007/03/13
define('_Go_To_Current_Month','����� ����� ������');
define('_Today_is','������ �� ���� ���');
define('_Wk','����');
define('_Click_to_scroll_to_previous_month',' ����� ����� ���� �� ����� ���.����� �������� �� ������ �� ���� ���� ');
define('_Click_to_scroll_to_next_month','���� ����� ��� �� ����� ���.����� �������� �� ������ �� ���� ���� ');
define('_Click_to_select_a_month','�� ����� ������ ���� �����');
define('_Click_to_select_a_year','.�� ����� ������ ��� ������');
define('_Select_date_as_date.','����� [date] �� ����� '); // do not replace [date], it will be replaced by date.
// end 2007/03/13

//--------------------------------------------------------
//--------------------------------------------------------
// Missing defines , autoreplaced values from 'english' 
//--------------------------------------------------------
define("_SEASON","Season"); 
define("_pilot_email","Email Address"); 
define("_Sex","Sex"); 
define("_Login_Stuff","Change Login-Data"); 
define("_PASSWORD_CONFIRMATION","Confirm password"); 
define("_EnterPasswordOnlyToChange","Only enter the password, if you want to change it:"); 
define("_PwdAndConfDontMatch","Password and confirmation are different."); 
define("_PwdTooShort","The password is too short. It must have a length of at least $passwordMinLength characters."); 
define("_PwdConfEmpty","The password has not be confirmed."); 
define("_PwdChanged","The password was changed."); 
define("_PwdNotChanged","The password has NOT been changed."); 
define("_PwdChangeProblem","A problem occurred when changing the password."); 
define("_EmailEmpty","The email address must not be empty."); 
define("_EmailInvalid","The email address is invalid."); 
define("_EmailSaved","The email address was saved"); 
define("_EmailNotSaved","The email address has not been saved."); 
define("_EmailSaveProblem","A problem occurred when saving the email address."); 
define("_MENU_SUMMARY_PAGE","First (Summary) Page"); 
define("_PROJECT_HELP","Help"); 
define("_PROJECT_NEWS","News"); 
define("_PROJECT_RULES","Regulations 2007"); 
define("_Filter_NoSelection","No selection"); 
define("_Filter_CurrentlySelected","Current selection"); 
define("_Filter_DialogMultiSelectInfo","Press Ctrl for multiple selection."); 
define("_Filter_FilterTitleIncluding","Only selected [items]"); 
define("_Filter_FilterTitleExcluding","Exclude [items]"); 
define("_Filter_DialogTitleIncluding","Select [items]"); 
define("_Filter_DialogTitleExcluding","Select [items]"); 
define("_Filter_Items_pilot","pilots"); 
define("_Filter_Items_nacclub","clubs"); 
define("_Filter_Items_country","countries"); 
define("_Filter_Items_takeoff","take offs"); 
define("_Filter_Button_Select","Select"); 
define("_Filter_Button_Delete","Delete"); 
define("_Filter_Button_Accept","Accept selection"); 
define("_Filter_Button_Cancel","Cancel"); 
define("_MENU_FILTER_NEW","Filter **NEW VERSION**"); 
define("_ALL_NACCLUBS","All Clubs"); 
define("_SELECT_NACCLUB","Select [nacname]-Club"); 
define("_FirstOlcYear","First year of participation in an online XC contest"); 
define("_FirstOlcYearComment","Please select the year of your first participation in any online XC contest, not just this one.<br/>This field is relevant for the &quot;newcomer&quot;-rankings."); 
define("_Select_Brand","Select Brand"); 
define("_All_Brands","All Brands"); 
define("_DAY","DAY"); 
define("_Glider_Brand","Glider Brand"); 
define("_Or_Select_from_previous","Or Select from previous"); 
define("_Explanation_AddToBookmarks_IE","Add these filter settings to your favourites"); 
define("_Msg_AddToBookmarks_IE","Click here to add these filter settings to your bookmarks."); 
define("_Explanation_AddToBookmarks_nonIE","(Save this link to your bookmarks.)"); 
define("_Msg_AddToBookmarks_nonIE","To save these filter settings to your bookmarks, use the function Save to bookmarks of your browser."); 
define("_PROJECT_RULES2","Regulations 2008"); 
define("_MEAN_SPEED1","Mean Speed"); 
define("_External_Entry","External Entry"); 
define("_Altitude","Altitude"); 
define("_Speed","Speed"); 
define("_Distance_from_takeoff","Distance from takeoff"); 
define("_LAST_DIGIT","last digit"); 
define("_Filter_Items_nationality","nationality"); 
define("_Filter_Items_server","server"); 
define("_Ext_text1","This is a flight originally submited at "); 
define("_Ext_text2","Link to full flight maps and charts"); 
define("_Ext_text3","Link to original flight"); 
define("_Male_short","M"); 
define("_Female_short","F"); 
define("_Male","Male"); 
define("_Female","Female"); 
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
define("_Show_Optimization_details","Show Optimization Details"); 
define("_MENU_SEARCH_PILOTS","Search"); 
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
define("_Email_new_password","<p align='justify'>The server have sent a email to the pilot with the new password and activation key</p> <p align='justify'>Please, check your email box and follow the procedures in the email body</p>"); 
define("_informed_user_not_found","This user was not found in the database"); 
define("_impossible_to_gen_new_pass","<p align='justify'>We are sorry to inform you that is not possible to generate a new password for you at this time, there is already a request that will expire in <b>%s</b>. Only after the expiration time you can do a new request.</p><p align='justify'>If you do not have access to the email contact the server admin</p>"); 
define("_Password_subject_confirm","Confirmation email (new password)"); 
define("_request_key_not_found","the request key that you have provided was not found!"); 
define("_request_key_invalid","request key that you have provided is invalid!"); 
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
define("_New_email","New Email Address"); 
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
define("_MANDATORY_GENDER","Please provide your Sex"); 
define("_MANDATORY_BIRTH_DATE_INVALID","Birth Date Invalid"); 
define("_MANDATORY_CIVL_ID","Please provide your CIVLID"); 
define("_Attention_mandatory_to_have_civlid","ATENTION!! For now one is Mandatory to have CIVLID in the %s database"); 
define("_Email_confirm_success","Your registration was successfully confirmed!"); 
define("_Success_login_civl_or_user","Success, now you can login using your CIVLID as username, or continue with your old username"); 
define("_Server_did_not_found_registration","Registration not found, please copy and paste in your browser address field the link provided in the email that was send to you, or maybe your registration time has expired"); 
define("_Pilot_already_registered","Pilot already registered with CIVLID %s and name %s"); 
define("_User_already_registered","User already registered with this email or name"); 
define("_Pilot_civlid_email_pre_registration","Hi %s This Civl ID and email is already used in a pre-registration"); 
define("_Pilot_have_pre_registration"," You already have a pre registration, but have not answered our mail, we resend the confirmation email for you, you have 3 hours after now to answer the email, if not you will be removed from pre registration. please read the email and follow the procedures described inside, thank you"); 
define("_Pre_registration_founded","We already have a pre-registration with this civlID and Email,wait for finishing the period of 3 hours until then this registration will be removed, in no hipotisis confirm the email that was send  because will be generated an double registration, and your old flights will not be transfered for the new user"); 
define("_Civlid_already_in_use","This CIVLID is used for another pilot, we can not have double CIVLID!"); 
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
define("_Photos_filter_off","With/without photos"); 
define("_Photos_filter_on","With photos only"); 
define("_You_are_already_logged_in","You are already logged in"); 
define("_See_The_filter","See the filter"); 
define("_PilotBirthdate","Pilot Birthdate"); 
define("_Start_Type","Start Type"); 
define("_GLIDER_CERT","Glider Certification"); 
define("_MENU_BROWSER","Browse in Google Maps"); 
define("_FLIGHT_BROSWER","Search the flights and takeoff database with Google Maps"); 
define("_Load_Thermals","Load Thermals"); 
define("_Loading_thermals","Loading Thermals"); 
define("_Layers","Layers"); 
define("_Select_Area","Select Area"); 
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
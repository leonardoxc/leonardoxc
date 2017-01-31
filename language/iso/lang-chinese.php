<? if (0){?><head><meta http-equiv="Content-Type" content="text/html; charset=gb2312"></head><? }?><?php

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
	$monthList=array('һ��','����','����','����','����','����',
					'����','����','����','ʮ��','ʮһ��','ʮ����');
	$monthListShort=array('JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC');
	$weekdaysList=array('Mon','Tue','Wed','Thu','Fri','Sat','Sun') ;
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","���ɷ���");
define("_FREE_TRIANGLE","�������Ǻ���");
define("_FAI_TRIANGLE","FAI���Ǻ���");

define("_SUBMIT_FLIGHT_ERROR","�ϴ����г�������");

// list_pilots()
define("_NUM","#");
define("_PILOT","����Ա");
define("_NUMBER_OF_FLIGHTS","���д���");
define("_BEST_DISTANCE","��Ѿ���");
define("_MEAN_KM","ÿ�η���ƽ��#������");
define("_TOTAL_KM","�����ܹ�����");
define("_TOTAL_DURATION_OF_FLIGHTS","�����ܳ���ʱ��");
define("_MEAN_DURATION","����ƽ������ʱ��");
define("_TOTAL_OLC_KM","OLC�ܾ���");
define("_TOTAL_OLC_SCORE","OLC�ܷ�");
define("_BEST_OLC_SCORE","OLC��ѷ�");
define("_From","��");

// list_flights()
define("_DURATION_HOURS_MIN","����ʱ��(h:m)");
define("_SHOW","��ʾ");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","�ϴ�������1-2��������Ч");
define("_TRY_AGAIN","���Ժ�����");

define("_TAKEOFF_LOCATION","��ɳ�");
define("_TAKEOFF_TIME","���ʱ��");
define("_LANDING_LOCATION","����");
define("_LANDING_TIME","����ʱ��");
define("_OPEN_DISTANCE","ֱ�߾���");
define("_MAX_DISTANCE","��Զ����");
define("_OLC_SCORE_TYPE","OLC�Ʒַ�ʽ");
define("_OLC_DISTANCE","OLC����");
define("_OLC_SCORING","OLC����");
define("_MAX_SPEED","����ٶ�");
define("_MAX_VARIO","��������ٶ�");
define("_MEAN_SPEED","ƽ���ٶ�");
define("_MIN_VARIO","����½��ٶ�");
define("_MAX_ALTITUDE","���߶ȣ�������");
define("_TAKEOFF_ALTITUDE","��ɸ߶ȣ�������");
define("_MIN_ALTITUDE","��͸߶ȣ�������");
define("_ALTITUDE_GAIN","��ȡ�߶�");
define("_FLIGHT_FILE","�����ļ�");
define("_COMMENTS","ע��");
define("_RELEVANT_PAGE","���URL��ҳ");
define("_GLIDER","����ɡ");
define("_PHOTOS","��Ƭ");
define("_MORE_INFO","������Ϣ");
define("_UPDATE_DATA","���ݸ���");
define("_UPDATE_MAP","��ͼ����");
define("_UPDATE_3D_MAP","3D��ͼ����");
define("_UPDATE_GRAPHS","��ͼ����");
define("_UPDATE_SCORE","��������");

define("_TAKEOFF_COORDS","��ɳ�����:");
define("_NO_KNOWN_LOCATIONS","��������!");
define("_FLYING_AREA_INFO","���п�����Ϣ");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","LeonardoԽҰ����");
define("_RETURN_TO_TOP","�ص�ҳ��");
// list flight
define("_PILOT_FLIGHTS","����Ա�ķ���");

define("_DATE_SORT","����");
define("_PILOT_NAME","����Ա����");
define("_TAKEOFF","���");
define("_DURATION","����ʱ��");
define("_LINEAR_DISTANCE","���ž���");
define("_OLC_KM","OLC������");
define("_OLC_SCORE","OLC����");
define("_DATE_ADDED","�����ϴ�");

define("_SORTED_BY","����:");
define("_ALL_YEARS","ȫ�����");
define("_SELECT_YEAR_MONTH","��ѡ���(�·�)");
define("_ALL","ȫ��");
define("_ALL_PILOTS","��ʾ���з���Ա");
define("_ALL_TAKEOFFS","��ʾȫ�����");
define("_ALL_THE_YEAR","ȫ��");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","����û���ṩ�����ļ�");
define("_NO_SUCH_FILE","�����ṩ���ļ��ڷ��������Ҳ���");
define("_FILE_DOESNT_END_IN_IGC","�����ṩ���ļ��ĺ�׺����.igc");
define("_THIS_ISNT_A_VALID_IGC_FILE","�ⲻ����ȷ��.igc�ļ�");
define("_THERE_IS_SAME_DATE_FLIGHT","ϵͳ���Ѿ�����ͬ����ʱ��ķ����ļ�");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","������滻��,������");
define("_DELETE_THE_OLD_ONE","ɾ�����ļ�");
define("_THERE_IS_SAME_FILENAME_FLIGHT","ϵͳ���Ѿ�����ͬһ�ļ����ķ���");
define("_CHANGE_THE_FILENAME","�������ͬһ����,������ļ���������");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","���ķ����Ѿ��ݽ�");
define("_PRESS_HERE_TO_VIEW_IT","�������ת��ۿ�");
define("_WILL_BE_ACTIVATED_SOON","(������1-2��������Ч)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","�ϴ���η���");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","ֻ������IGC�ļ�");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","�ϴ�������е�ZIP�ļ�<br>");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","��������ϴ��������");

define("_FILE_DOESNT_END_IN_ZIP","�����ϴ����ļ���׺����.zip");
define("_ADDING_FILE","�����ϴ��ļ�");
define("_ADDED_SUCESSFULLY","�ϴ��ɹ�");
define("_PROBLEM","����");
define("_TOTAL","�ܼ�");
define("_IGC_FILES_PROCESSED","�����Ѿ��������");
define("_IGC_FILES_SUBMITED","�����Ѿ��ϴ����");

// info
define("_DEVELOPMENT","��չ");
define("_ANDREADAKIS_MANOLIS","Andreadakis Manolis");
define("_PROJECT_URL","��Ŀҳ");
define("_VERSION","�汾");
define("_MAP_CREATION","���ɵ�ͼ");
define("_PROJECT_INFO","��Ŀ��Ϣ");

// menu bar 
define("_MENU_MAIN_MENU","���˵�");
define("_MENU_DATE","ѡ������");
define("_MENU_COUNTRY","ѡ�����");
define("_MENU_XCLEAGUE","XC����");
define("_MENU_ADMIN","����");

define("_MENU_COMPETITION_LEAGUE","����-ȫ���");
define("_MENU_OLC","OLC");
define("_MENU_OPEN_DISTANCE","���ž���");
define("_MENU_DURATION","����ʱ��");
define("_MENU_ALL_FLIGHTS","��ʾ���еķ���");
define("_MENU_FLIGHTS","����");
define("_MENU_TAKEOFFS","���");
define("_MENU_FILTER","����");
define("_MENU_MY_FLIGHTS","�ҵķ���");
define("_MENU_MY_PROFILE","�ҵĸ��˿ռ�");
define("_MENU_MY_STATS","�ҵ�ͳ��"); 
define("_MENU_MY_SETTINGS","�ҵ�����"); 
define("_MENU_SUBMIT_FLIGHT","�ϴ�����");
define("_MENU_SUBMIT_FROM_ZIP","��ZIP�ļ��ϴ�����");
define("_MENU_SHOW_PILOTS","����Ա");
define("_MENU_SHOW_LAST_ADDED","��ʾ�����ϴ�");
define("_FLIGHTS_STATS","����ͳ��");

define("_SELECT_YEAR","ѡ�����");
define("_SELECT_MONTH","ѡ���·�");
define("_ALL_COUNTRIES","��ʾ���й���");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","ȫʱ��");
define("_NUMBER_OF_FLIGHTS","���д���");
define("_TOTAL_DISTANCE","�ܾ���");
define("_TOTAL_DURATION","�ܳ���ʱ��");
define("_BEST_OPEN_DISTANCE","��Ѿ���");
define("_TOTAL_OLC_DISTANCE","��OLC����");
define("_TOTAL_OLC_SCORE","��OLC����");
define("_BEST_OLC_SCORE","���OLC����");
define("_MEAN_DURATION","ƽ������ʱ��");
define("_MEAN_DISTANCE","ƽ������");
define("_PILOT_STATISTICS_SORT_BY","����Ա-����Ϊ");
define("_CATEGORY_FLIGHT_NUMBER","��� 'FastJoe' - ���д���");
define("_CATEGORY_TOTAL_DURATION","��� 'DURACELL' - �ܷ��г���ʱ��");
define("_CATEGORY_OPEN_DISTANCE","��� '���ž���'");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","û�з���Ա����ʾ!");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","�����Ѿ���ɾ��");
define("_RETURN","�س�");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","ע��-����Ҫɾ���˴η���");
define("_THE_DATE","���� ");
define("_YES","��");
define("_NO","��");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","���˳ɼ�");
define("_N_BEST_FLIGHTS","��ѷ���");
define("_OLC","OLC");
define("_OLC_TOTAL_SCORE","OLC�ܷ�");
define("_KILOMETERS","����");
define("_TOTAL_ALTITUDE_GAIN","��ȡ���ܸ߶�");
define("_TOTAL_KM","�ܹ�����");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","��");
define("_IS_NOT","����");
define("_OR","��");
define("_AND","��");
define("_FILTER_PAGE_TITLE","ɸѡ����");
define("_RETURN_TO_FLIGHTS","���ص�����ҳ");
define("_THE_FILTER_IS_ACTIVE","ɸѡ�Ѿ�����");
define("_THE_FILTER_IS_INACTIVE","ɸѡû������");
define("_SELECT_DATE","ѡ������");
define("_SHOW_FLIGHTS","��ʾ����");
define("_ALL2","ȫ��");
define("_WITH_YEAR","������");
define("_MONTH","��");
define("_YEAR","��");
define("_FROM","��");
define("_from","��");
define("_TO","��");
define("_SELECT_PILOT","ѡ�����Ա");
define("_THE_PILOT","����Ա");
define("_THE_TAKEOFF","��ɳ�");
define("_SELECT_TAKEOFF","ѡ����ɳ�");
define("_THE_COUNTRY","����");
define("_COUNTRY","����");
define("_SELECT_COUNTRY","ѡ�����");
define("_OTHER_FILTERS","����ɸѡ");
define("_LINEAR_DISTANCE_SHOULD_BE","ֱ�߾�����");
define("_OLC_DISTANCE_SHOULD_BE","OLC������");
define("_OLC_SCORE_SHOULD_BE","OLC������");
define("_DURATION_SHOULD_BE","����ʱ����");
define("_ACTIVATE_CHANGE_FILTER","����/����ɸѡ");
define("_DEACTIVATE_FILTER","���ɸѡ");
define("_HOURS","Сʱ");
define("_MINUTES","����");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","�ϴ�����");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(ֻ��IGC�ļ�����)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","�ϴ�<br>IGC�����ļ�");
define("_NOTE_TAKEOFF_NAME","���¼��ɳ������ֺ͹���");
define("_COMMENTS_FOR_THE_FLIGHT","����ע��");
define("_PHOTO","��Ƭ");
define("_PHOTOS_GUIDELINES","��ƬӦ��jpg��ʽ��С��");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","�������ϴ�����");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","����һ���ϴ����������?");
define("_PRESS_HERE","�������");

define("_IS_PRIVATE","��Ҫ����չʾ");
define("_MAKE_THIS_FLIGHT_PRIVATE","��Ҫ����չʾ");
define("_INSERT_FLIGHT_AS_USER_ID","����ע���ʺŽ���˷���");
define("_FLIGHT_IS_PRIVATE","�˴η��б���");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","�޸ķ�������");
define("_IGC_FILE_OF_THE_FLIGHT","���е�IGC�ļ�");
define("_DELETE_PHOTO","ɾ��");
define("_NEW_PHOTO","����Ƭ");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","�������޸ķ�������");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","�޸��Ѿ���Ч");
define("_RETURN_TO_FLIGHT","���ش˷���");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","���ش˷���Return to flight");
define("_READY_FOR_SUBMISSION","׼�����ϴ�");
define("_SUBMIT_TO_OLC","�ϴ���OLC");
define("_OLC_MAP","��ͼ");
define("_OLC_BARO","�Զ���ѹ��");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","����Ա�ĸ��˿ռ�");
define("_back_to_flights","���ط���");
define("_pilot_stats","����Աͳ��");
define("_edit_profile","�༭���˿ռ�");
define("_flights_stats","����ͳ��");
define("_View_Profile","�鿴���˿ռ�");

define("_Personal_Stuff","������Ϣ");
define("_First_Name","��");
define("_Last_Name","��");
define("_Birthdate","����");
define("_dd_mm_yy","dd.mm.yy");
define("_Sign","ǩ��");
define("_Marital_Status","����״��");
define("_Occupation","ְҵ");
define("_Web_Page","��ҳ");
define("_N_A","N/A");
define("_Other_Interests","��������");
define("_Photo","��Ƭ");

define("_Flying_Stuff","������Ϣ");
define("_note_place_and_date","�ɸ�¼�ص㣬���Һ�����");
define("_Flying_Since","��һ�η���ʱ��");
define("_Pilot_Licence","����Աִ��");
define("_Paragliding_training","����ɡ��ѵ");
define("_Favorite_Location","��ϲ���ĳ���");
define("_Usual_Location","ͨ���ĳ���");
define("_Best_Flying_Memory","��õķ��м���");
define("_Worst_Flying_Memory","���ķ��м���");
define("_Personal_Distance_Record","���˾����¼");
define("_Personal_Height_Record","���˸߶ȼ�¼");
define("_Hours_Flown","����Сʱ");
define("_Hours_Per_Year","ÿ�����Сʱ");

define("_Equipment_Stuff","�豸��Ϣ");
define("_Glider","����ɡ");
define("_Harness","����");
define("_Reserve_chute","��ɡ");
define("_Camera","�����");
define("_Vario","�߶ȱ�");
define("_GPS","GPS");
define("_Helmet","ͷ��");
define("_Camcorder","��Яʽ�����");

define("_Manouveur_Stuff","�ؼ���Ϣ");
define("_note_max_descent_rate","�ɸ�¼����½��ٶ�");
define("_Spiral","����");
define("_Bline","B��ʧ��");
define("_Full_Stall","ȫʧ��");
define("_Other_Manouveurs_Acro","�����ؼ�");
define("_Sat","����");
define("_Asymmetric_Spiral","��������");
define("_Spin","Spin");

define("_General_Stuff","��ͨ��Ϣ");
define("_Favorite_Singer","��ϲ���ĸ���");
define("_Favorite_Movie","��ϲ���ĵ�Ӱ");
define("_Favorite_Internet_Site","��ϲ������ַ<br>");
define("_Favorite_Book","��ϲ������");
define("_Favorite_Actor","��ϲ������Ա");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","�ϴ�����Ƭ���������Ƭ");
define("_Delete_Photo","ɾ����Ƭ");
define("_Your_profile_has_been_updated","�����Ϣ���ϴ�");
define("_Submit_Change_Data","�ϴ�-��������");


//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","hh:mm");

define("_Totals","�ϼ�");
define("_First_flight_logged","��һƪ������־");
define("_Last_flight_logged","���һƪ������־");
define("_Flying_period_covered","��������");
define("_Total_Distance","�ܾ���");
define("_Total_OLC_Score","��OLC����");
define("_Total_Hours_Flown","�ܷ���Сʱ");
define("_Total_num_of_flights","�ܷ��д���");

define("_Personal_Bests","���˼�¼");
define("_Best_Open_Distance","��ѿ��ž���");
define("_Best_FAI_Triangle","���FAI���Ǻ���");
define("_Best_Free_Triangle","����������Ǻ���");
define("_Longest_Flight","�ʱ�����");
define("_Best_OLC_score","���OLC����");

define("_Absolute_Height_Record","���Ը߶ȼ�¼");
define("_Altitute_gain_Record","��ø߶ȼ�¼");
define("_Mean_values","ƽ��ֵ");
define("_Mean_distance_per_flight","����ƽ������");
define("_Mean_flights_per_Month","ÿ��ƽ�����д���");
define("_Mean_distance_per_Month","ÿ��ƽ������");
define("_Mean_duration_per_Month","ÿ��ƽ������ʱ��");
define("_Mean_duration_per_flight","����ƽ������ʱ��");
define("_Mean_flights_per_Year","ÿ��ƽ�����д���");
define("_Mean_distance_per_Year","ÿ��ƽ������");
define("_Mean_duration_per_Year","ÿ��ƽ������ʱ��");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","�鿴�˵㸽���ķ���");
define("_Waypoint_Name","����������");
define("_Navigate_with_Google_Earth","Google���򵼺�");
define("_See_it_in_Google_Maps","��Google��ͼ�ϲ鿴");
define("_See_it_in_MapQuest","��MapQuest�ϲ鿴");
define("_COORDINATES","Coordinates");
define("_FLIGHTS","����");
define("_SITE_RECORD","���ؼ�¼");
define("_SITE_INFO","������Ϣ");
define("_SITE_REGION","����");
define("_SITE_LINK","���Ӹ������Ϣ");
define("_SITE_DESCR","����/��ɳ�����");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","������ϸ��Ϣ");
define("_KML_file_made_by","KML�ļ�����");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","�Ǽ���ɳ�");
define("_WAYPOINT_ADDED","��ɳ��ѵǼ�");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","���ؼ�¼<br>�����ž���)");
	
//--------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","����ɡ����");
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

define("_Your_settings_have_been_updated","�趨���ϴ�");

define("_THEME","����");
define("_LANGUAGE","����");
define("_VIEW_CATEGORY","ͨ������鿴");
define("_VIEW_COUNTRY","ͨ�����Ҳ鿴");
define("_UNITS_SYSTEM" ,"��λϵͳ");
define("_METRIC_SYSTEM","����(km,m)");
define("_IMPERIAL_SYSTEM","Ӣ��(Ӣ��,Ӣ��)");
define("_ITEMS_PER_PAGE","ÿҳ����Ϣ");

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

define("_WORLD_WIDE","���緶Χ");
define("_National_XC_Leagues_for","����XC����");
define("_Flights_per_Country","ÿ�����ҷ�����");
define("_Takeoffs_per_Country","ÿ�����ҵĳ�����");
define("_INDEX_HEADER","��ӭ��Leonardo XC League");
define("_INDEX_MESSAGE","���ܹ�ʹ��&quot;Main menu&quot; ��������ʹ�������ṩ���κ���Դ");

//--------------------------------------------
// NEW 
//--------------------------------------------
define("_MENU_SUMMARY_PAGE","��ҳ(ժҪ)");
define("_Display_ALL","��ʾȫ��");
define("_Display_NONE","��ʾ��");
define("_Reset_to_default_view","������ȱʡֵ");
define("_No_Club","�޾��ֲ�");
define("_This_is_the_URL_of_this_page","���Ǵ�ҳ��URL");
define("_All_glider_types","ȫ������ɡ����");

define("_MENU_SITES_GUIDE","���г���ָ��");
define("_Site_Guide","����ָ��");

define("_Search_Options","����ѡ��");
define("_Below_is_the_list_of_selected_sites","�����ǿ�ѡ�����б�");
define("_Clear_this_list","�����б�");
define("_See_the_selected_sites_in_Google_Earth","��Google�����ϲ鿴��ѡ����");
define("_Available_Takeoffs","������е���ɳ�");
define("_Search_site_by_name","��������Ѱ����");
define("_give_at_least_2_letters","�������2����ĸ");
define("_takeoff_move_instructions_1","���������ұ������>>�����е�������г��������б�,����>�ƶ�һ��ѡ���ĳ���");
define("_Takeoff_Details","��ɳ���ϸ����");


define("_Takeoff_Info","��ɳ���Ϣ");
define("_XC_Info","XC��Ϣ");
define("_Flight_Info","������Ϣ");

define("_MENU_LOGOUT","�˳�");
define("_MENU_LOGIN","��¼");
define("_MENU_REGISTER","���ʺ�");


define("_Africa","����");
define("_Europe","ŷ��");
define("_Asia","����");
define("_Australia","����");
define("_North_Central_America","�б�����");
define("_South_America","������");

define("_Recent","�½���");


define("_Unknown_takeoff","δ֪��ɳ�");
define("_Display_on_Google_Earth","��Google��������ʾ");
define("_Use_Man_s_Module","Use Man's Module");
define("_Line_Color","������ò");
define("_Line_width","���߿��");
define("_unknown_takeoff_tooltip_1","�˴η��еĳ���δ֪");
define("_unknown_takeoff_tooltip_2","�����֪���˴η������Ǹ���ɳ�,���������д!");
define("_EDIT_WAYPOINT","�༭��ɳ���Ϣ");
define("_DELETE_WAYPOINT","ɾ����ɳ�");
define("_SUBMISION_DATE","�ϴ�����"); // the date a flight was submited to leonardo
define("_TIMES_VIEWED","�쿴����"); // the times that this flight havs been viewed


define("_takeoff_add_help_1","�����֪����ɳ���Ϣ,����д,�����̫���,��رմ˴���");
define("_takeoff_add_help_2","������ķ���������'δ֪��ɳ�'��ͬ,��û��Ҫ������д,��رմ˴���. ");
define("_takeoff_add_help_3","����������濴����ɳ�����,ֱ�ӵ�����Զ���д.");
define("_Takeoff_Name","��ɳ�����");
define("_In_Local_Language","�õ�������");
define("_In_English","��Ӣ��");

// New on 2007/02/20 - login screen
define("_ENTER_PASSWORD","�������û����������¼.");
define("_SEND_PASSWORD","��������");
define("_ERROR_LOGIN","���������û�����Ƿ�����.");
define("_AUTO_LOGIN","ÿ�η����Զ���¼");
define("_USERNAME","�û���");
define("_PASSWORD","����");
define("_PROBLEMS_HELP","���������������Ա��ϵ");

define("_LOGIN_TRY_AGAIN","��� %sHere%s ����һ��");
define("_LOGIN_RETURN","��� %sHere%s �ص�����");
// end 2007/02/20

define("_Category","���");
define("_MEMBER_OF","��Ա");
define("_MemberID","��ԱID");
define("_EnterID","����ID");
define("_Clubs_Leagues","���ֲ�/����");
define("_Pilot_Statistics","����Ա�ɼ�");
define("_National_Rankings","��������");

// new on 2007/03/08
define("_Select_Club","ѡ���ֲ�");
define("_Close_window","�رմ���");
define("_EnterID","����ID");
define("_Club","���ֲ�");
define("_Sponsor","������");


// new on 2007/03/13
define('_Go_To_Current_Month','ת����ǰ��');
define('_Today_is','������');
define('_Wk','Wk');
define('_Click_to_scroll_to_previous_month','���ת��ǰ��,��ס�Զ���ת.');
define('_Click_to_scroll_to_next_month','���ת������,��ס�Զ���ת.');
define('_Click_to_select_a_month','���ѡ���·�.');
define('_Click_to_select_a_year','���ѡ�����.');
define('_Select_date_as_date.','ѡ��[date]Ϊ����.'); // do not replace [date], it will be replaced by date.
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
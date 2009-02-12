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
	$monthList=array('一月','二月','三月','四月','五月','六月',
					'七月','八月','九月','十月','十一月','十二月');
	$monthListShort=array('JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC');
	$weekdaysList=array('Mon','Tue','Wed','Thu','Fri','Sat','Sun') ;
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","自由飞行");
define("_FREE_TRIANGLE","自由三角航线");
define("_FAI_TRIANGLE","FAI三角航线");

define("_SUBMIT_FLIGHT_ERROR","上传飞行出现问题");

// list_pilots()
define("_NUM","#");
define("_PILOT","飞行员");
define("_NUMBER_OF_FLIGHTS","飞行次数");
define("_BEST_DISTANCE","最佳距离");
define("_MEAN_KM","每次飞行平均#公里数");
define("_TOTAL_KM","飞行总公里数");
define("_TOTAL_DURATION_OF_FLIGHTS","飞行总持续时间");
define("_MEAN_DURATION","飞行平均持续时间");
define("_TOTAL_OLC_KM","OLC总距离");
define("_TOTAL_OLC_SCORE","OLC总分");
define("_BEST_OLC_SCORE","OLC最佳分");
define("_From","从");

// list_flights()
define("_DURATION_HOURS_MIN","持续时间(h:m)");
define("_SHOW","显示");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","上传飞行在1-2分钟内生效");
define("_TRY_AGAIN","请稍后再试");

define("_TAKEOFF_LOCATION","起飞场");
define("_TAKEOFF_TIME","起飞时间");
define("_LANDING_LOCATION","降落");
define("_LANDING_TIME","降落时间");
define("_OPEN_DISTANCE","直线距离");
define("_MAX_DISTANCE","最远距离");
define("_OLC_SCORE_TYPE","OLC计分方式");
define("_OLC_DISTANCE","OLC距离");
define("_OLC_SCORING","OLC分数");
define("_MAX_SPEED","最大速度");
define("_MAX_VARIO","最大上升速度");
define("_MEAN_SPEED","平均速度");
define("_MIN_VARIO","最大下降速度");
define("_MAX_ALTITUDE","最大高度（海拨）");
define("_TAKEOFF_ALTITUDE","起飞高度（海拨）");
define("_MIN_ALTITUDE","最低高度（海拨）");
define("_ALTITUDE_GAIN","获取高度");
define("_FLIGHT_FILE","飞行文件");
define("_COMMENTS","注释");
define("_RELEVANT_PAGE","相关URL网页");
define("_GLIDER","滑翔伞");
define("_PHOTOS","照片");
define("_MORE_INFO","更多信息");
define("_UPDATE_DATA","数据更新");
define("_UPDATE_MAP","地图更新");
define("_UPDATE_3D_MAP","3D地图更新");
define("_UPDATE_GRAPHS","海图更新");
define("_UPDATE_SCORE","分数更新");

define("_TAKEOFF_COORDS","起飞场资料:");
define("_NO_KNOWN_LOCATIONS","不明区域!");
define("_FLYING_AREA_INFO","飞行空域信息");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo越野飞行");
define("_RETURN_TO_TOP","回到页首");
// list flight
define("_PILOT_FLIGHTS","飞行员的飞行");

define("_DATE_SORT","日期");
define("_PILOT_NAME","飞行员姓名");
define("_TAKEOFF","起飞");
define("_DURATION","持续时间");
define("_LINEAR_DISTANCE","开放距离");
define("_OLC_KM","OLC公里数");
define("_OLC_SCORE","OLC分数");
define("_DATE_ADDED","最新上传");

define("_SORTED_BY","分类:");
define("_ALL_YEARS","全部年份");
define("_SELECT_YEAR_MONTH","所选年份(月份)");
define("_ALL","全部");
define("_ALL_PILOTS","显示所有飞行员");
define("_ALL_TAKEOFFS","显示全部起飞");
define("_ALL_THE_YEAR","全年");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","您还没有提供飞行文件");
define("_NO_SUCH_FILE","您所提供的文件在服务器上找不到");
define("_FILE_DOESNT_END_IN_IGC","您所提供的文件的后缀不是.igc");
define("_THIS_ISNT_A_VALID_IGC_FILE","这不是正确的.igc文件");
define("_THERE_IS_SAME_DATE_FLIGHT","系统中已经存在同日期时间的飞行文件");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","如果想替换它,您首先");
define("_DELETE_THE_OLD_ONE","删除旧文件");
define("_THERE_IS_SAME_FILENAME_FLIGHT","系统中已经存在同一文件名的飞行");
define("_CHANGE_THE_FILENAME","如果不是同一飞行,请更换文件名后再试");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","您的飞行已经递交");
define("_PRESS_HERE_TO_VIEW_IT","点击这里转入观看");
define("_WILL_BE_ACTIVATED_SOON","(它将在1-2分钟内生效)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","上传多次飞行");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","只能运行IGC文件");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","上传多个飞行的ZIP文件<br>");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","点击这里上传多个飞行");

define("_FILE_DOESNT_END_IN_ZIP","您所上传的文件后缀不是.zip");
define("_ADDING_FILE","正在上传文件");
define("_ADDED_SUCESSFULLY","上传成功");
define("_PROBLEM","问题");
define("_TOTAL","总计");
define("_IGC_FILES_PROCESSED","飞行已经处理完毕");
define("_IGC_FILES_SUBMITED","飞行已经上传完毕");

// info
define("_DEVELOPMENT","发展");
define("_ANDREADAKIS_MANOLIS","Andreadakis Manolis");
define("_PROJECT_URL","项目页");
define("_VERSION","版本");
define("_MAP_CREATION","生成地图");
define("_PROJECT_INFO","项目信息");

// menu bar 
define("_MENU_MAIN_MENU","主菜单");
define("_MENU_DATE","选择日期");
define("_MENU_COUNTRY","选择国家");
define("_MENU_XCLEAGUE","XC联盟");
define("_MENU_ADMIN","管理");

define("_MENU_COMPETITION_LEAGUE","联盟-全类别");
define("_MENU_OLC","OLC");
define("_MENU_OPEN_DISTANCE","开放距离");
define("_MENU_DURATION","持续时间");
define("_MENU_ALL_FLIGHTS","显示所有的飞行");
define("_MENU_FLIGHTS","飞行");
define("_MENU_TAKEOFFS","起飞");
define("_MENU_FILTER","过滤");
define("_MENU_MY_FLIGHTS","我的飞行");
define("_MENU_MY_PROFILE","我的个人空间");
define("_MENU_MY_STATS","我的统计"); 
define("_MENU_MY_SETTINGS","我的设置"); 
define("_MENU_SUBMIT_FLIGHT","上传飞行");
define("_MENU_SUBMIT_FROM_ZIP","由ZIP文件上传飞行");
define("_MENU_SHOW_PILOTS","飞行员");
define("_MENU_SHOW_LAST_ADDED","显示最新上传");
define("_FLIGHTS_STATS","飞行统计");

define("_SELECT_YEAR","选择年份");
define("_SELECT_MONTH","选择月份");
define("_ALL_COUNTRIES","显示所有国家");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","全时期");
define("_NUMBER_OF_FLIGHTS","飞行次数");
define("_TOTAL_DISTANCE","总距离");
define("_TOTAL_DURATION","总持续时间");
define("_BEST_OPEN_DISTANCE","最佳距离");
define("_TOTAL_OLC_DISTANCE","总OLC距离");
define("_TOTAL_OLC_SCORE","总OLC分数");
define("_BEST_OLC_SCORE","最佳OLC分数");
define("_MEAN_DURATION","平均持续时间");
define("_MEAN_DISTANCE","平均距离");
define("_PILOT_STATISTICS_SORT_BY","飞行员-分类为");
define("_CATEGORY_FLIGHT_NUMBER","类别 'FastJoe' - 飞行次数");
define("_CATEGORY_TOTAL_DURATION","类别 'DURACELL' - 总飞行持续时间");
define("_CATEGORY_OPEN_DISTANCE","类别 '开放距离'");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","没有飞行员可显示!");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","飞行已经被删除");
define("_RETURN","回车");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","注意-你正要删除此次飞行");
define("_THE_DATE","日期 ");
define("_YES","是");
define("_NO","否");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","联盟成绩");
define("_N_BEST_FLIGHTS","最佳飞行");
define("_OLC","OLC");
define("_OLC_TOTAL_SCORE","OLC总分");
define("_KILOMETERS","公里");
define("_TOTAL_ALTITUDE_GAIN","获取的总高度");
define("_TOTAL_KM","总公里数");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","是");
define("_IS_NOT","不是");
define("_OR","或");
define("_AND","和");
define("_FILTER_PAGE_TITLE","筛选飞行");
define("_RETURN_TO_FLIGHTS","返回到飞行页");
define("_THE_FILTER_IS_ACTIVE","筛选已经激活");
define("_THE_FILTER_IS_INACTIVE","筛选没有启动");
define("_SELECT_DATE","选择日期");
define("_SHOW_FLIGHTS","显示飞行");
define("_ALL2","全部");
define("_WITH_YEAR","相关年份");
define("_MONTH","月");
define("_YEAR","年");
define("_FROM","从");
define("_from","从");
define("_TO","至");
define("_SELECT_PILOT","选择飞行员");
define("_THE_PILOT","飞行员");
define("_THE_TAKEOFF","起飞场");
define("_SELECT_TAKEOFF","选择起飞场");
define("_THE_COUNTRY","国家");
define("_COUNTRY","国家");
define("_SELECT_COUNTRY","选择国家");
define("_OTHER_FILTERS","其它筛选");
define("_LINEAR_DISTANCE_SHOULD_BE","直线距离是");
define("_OLC_DISTANCE_SHOULD_BE","OLC距离是");
define("_OLC_SCORE_SHOULD_BE","OLC分数是");
define("_DURATION_SHOULD_BE","持续时间是");
define("_ACTIVATE_CHANGE_FILTER","激活/更换筛选");
define("_DEACTIVATE_FILTER","解除筛选");
define("_HOURS","小时");
define("_MINUTES","分钟");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","上传飞行");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(只有IGC文件可用)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","上传<br>IGC飞行文件");
define("_NOTE_TAKEOFF_NAME","请记录起飞场的名字和国家");
define("_COMMENTS_FOR_THE_FLIGHT","飞行注释");
define("_PHOTO","照片");
define("_PHOTOS_GUIDELINES","照片应是jpg格式并小于");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","按这里上传飞行");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","你想一次上传多个飞行吗?");
define("_PRESS_HERE","点击这里");

define("_IS_PRIVATE","不要公开展示");
define("_MAKE_THIS_FLIGHT_PRIVATE","不要公开展示");
define("_INSERT_FLIGHT_AS_USER_ID","请用注册帐号进入此飞行");
define("_FLIGHT_IS_PRIVATE","此次飞行保密");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","修改飞行数据");
define("_IGC_FILE_OF_THE_FLIGHT","飞行的IGC文件");
define("_DELETE_PHOTO","删除");
define("_NEW_PHOTO","新照片");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","按这里修改飞行数据");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","修改已经生效");
define("_RETURN_TO_FLIGHT","返回此飞行");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","返回此飞行Return to flight");
define("_READY_FOR_SUBMISSION","准备好上传");
define("_SUBMIT_TO_OLC","上传至OLC");
define("_OLC_MAP","地图");
define("_OLC_BARO","自动气压计");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","飞行员的个人空间");
define("_back_to_flights","返回飞行");
define("_pilot_stats","飞行员统计");
define("_edit_profile","编辑个人空间");
define("_flights_stats","飞行统计");
define("_View_Profile","查看个人空间");

define("_Personal_Stuff","个人信息");
define("_First_Name","名");
define("_Last_Name","姓");
define("_Birthdate","生日");
define("_dd_mm_yy","dd.mm.yy");
define("_Sign","签名");
define("_Marital_Status","婚姻状况");
define("_Occupation","职业");
define("_Web_Page","网页");
define("_N_A","N/A");
define("_Other_Interests","其它爱好");
define("_Photo","照片");

define("_Flying_Stuff","飞行信息");
define("_note_place_and_date","可附录地点，国家和日期");
define("_Flying_Since","第一次飞行时间");
define("_Pilot_Licence","飞行员执照");
define("_Paragliding_training","滑翔伞培训");
define("_Favorite_Location","最喜欢的场地");
define("_Usual_Location","通常的场地");
define("_Best_Flying_Memory","最好的飞行记忆");
define("_Worst_Flying_Memory","最差的飞行记忆");
define("_Personal_Distance_Record","个人距离记录");
define("_Personal_Height_Record","个人高度记录");
define("_Hours_Flown","飞行小时");
define("_Hours_Per_Year","每年飞行小时");

define("_Equipment_Stuff","设备信息");
define("_Glider","滑翔伞");
define("_Harness","座袋");
define("_Reserve_chute","付伞");
define("_Camera","照相机");
define("_Vario","高度表");
define("_GPS","GPS");
define("_Helmet","头盔");
define("_Camcorder","可携式摄像机");

define("_Manouveur_Stuff","特技信息");
define("_note_max_descent_rate","可附录最大下降速度");
define("_Spiral","螺旋");
define("_Bline","B组失速");
define("_Full_Stall","全失速");
define("_Other_Manouveurs_Acro","其它特技");
define("_Sat","土星");
define("_Asymmetric_Spiral","过顶螺旋");
define("_Spin","Spin");

define("_General_Stuff","普通信息");
define("_Favorite_Singer","最喜欢的歌手");
define("_Favorite_Movie","最喜欢的电影");
define("_Favorite_Internet_Site","最喜欢的网址<br>");
define("_Favorite_Book","最喜欢的书");
define("_Favorite_Actor","最喜欢的演员");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","上传新照片或更换旧照片");
define("_Delete_Photo","删除照片");
define("_Your_profile_has_been_updated","你的信息已上传");
define("_Submit_Change_Data","上传-更换数据");


//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","hh:mm");

define("_Totals","合计");
define("_First_flight_logged","第一篇飞行日志");
define("_Last_flight_logged","最后一篇飞行日志");
define("_Flying_period_covered","飞行周期");
define("_Total_Distance","总距离");
define("_Total_OLC_Score","总OLC分数");
define("_Total_Hours_Flown","总飞行小时");
define("_Total_num_of_flights","总飞行次数");

define("_Personal_Bests","个人记录");
define("_Best_Open_Distance","最佳开放距离");
define("_Best_FAI_Triangle","最佳FAI三角航线");
define("_Best_Free_Triangle","最佳自由三角航线");
define("_Longest_Flight","最长时间飞行");
define("_Best_OLC_score","最佳OLC分数");

define("_Absolute_Height_Record","绝对高度记录");
define("_Altitute_gain_Record","获得高度记录");
define("_Mean_values","平均值");
define("_Mean_distance_per_flight","飞行平均距离");
define("_Mean_flights_per_Month","每月平均飞行次数");
define("_Mean_distance_per_Month","每月平均距离");
define("_Mean_duration_per_Month","每月平均持续时间");
define("_Mean_duration_per_flight","飞行平均持续时间");
define("_Mean_flights_per_Year","每年平均飞行次数");
define("_Mean_distance_per_Year","每年平均距离");
define("_Mean_duration_per_Year","每年平均持续时间");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","查看此点附近的飞行");
define("_Waypoint_Name","航迹点名字");
define("_Navigate_with_Google_Earth","Google地球导航");
define("_See_it_in_Google_Maps","在Google地图上查看");
define("_See_it_in_MapQuest","在MapQuest上查看");
define("_COORDINATES","Coordinates");
define("_FLIGHTS","飞行");
define("_SITE_RECORD","场地记录");
define("_SITE_INFO","场地信息");
define("_SITE_REGION","区域");
define("_SITE_LINK","链接更多的信息");
define("_SITE_DESCR","场地/起飞场描述");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","见更详细信息");
define("_KML_file_made_by","KML文件生成");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","登记起飞场");
define("_WAYPOINT_ADDED","起飞场已登记");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","场地记录<br>（开放距离)");
	
//--------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","滑翔伞类型");
function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'Paraglider',2=>'Flex wing FAI1',4=>'Rigid wing FAI5',8=>'Glider');
	foreach ($CONF_glider_types as $gId=>$gName) if (!$gliderCatList[$gId]) $gliderCatList[$gId]=$gName;
}
setGliderCats();

//--------------------------------------------
// user prefs  & units
//--------------------------------------------

define("_Your_settings_have_been_updated","设定已上传");

define("_THEME","主题");
define("_LANGUAGE","语言");
define("_VIEW_CATEGORY","通过分类查看");
define("_VIEW_COUNTRY","通常国家查看");
define("_UNITS_SYSTEM" ,"单位系统");
define("_METRIC_SYSTEM","米制(km,m)");
define("_IMPERIAL_SYSTEM","英制(英里,英尺)");
define("_ITEMS_PER_PAGE","每页的信息");

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

define("_WORLD_WIDE","世界范围");
define("_National_XC_Leagues_for","国家XC联盟");
define("_Flights_per_Country","每个国家飞行数");
define("_Takeoffs_per_Country","每个国家的场地数");
define("_INDEX_HEADER","欢迎到Leonardo XC League");
define("_INDEX_MESSAGE","你能够使用&quot;Main menu&quot; 来导航或使用其所提供的任何资源");

//--------------------------------------------
// NEW 
//--------------------------------------------
define("_MENU_SUMMARY_PAGE","首页(摘要)");
define("_Display_ALL","显示全部");
define("_Display_NONE","显示无");
define("_Reset_to_default_view","重设至缺省值");
define("_No_Club","无俱乐部");
define("_This_is_the_URL_of_this_page","这是此页的URL");
define("_All_glider_types","全部滑翔伞类型");

define("_MENU_SITES_GUIDE","飞行场地指南");
define("_Site_Guide","场地指南");

define("_Search_Options","搜索选项");
define("_Below_is_the_list_of_selected_sites","以下是可选场地列表");
define("_Clear_this_list","跳过列表");
define("_See_the_selected_sites_in_Google_Earth","在Google地球上查看所选场地");
define("_Available_Takeoffs","允许飞行的起飞场");
define("_Search_site_by_name","按名字搜寻场地");
define("_give_at_least_2_letters","至少输个2个字母");
define("_takeoff_move_instructions_1","您可以用右边面板中>>将所有的允许飞行场地移至列表,或用>移动一个选定的场地");
define("_Takeoff_Details","起飞场详细资料");


define("_Takeoff_Info","起飞场信息");
define("_XC_Info","XC信息");
define("_Flight_Info","飞行信息");

define("_MENU_LOGOUT","退出");
define("_MENU_LOGIN","登录");
define("_MENU_REGISTER","打开帐号");


define("_Africa","非洲");
define("_Europe","欧洲");
define("_Asia","亚洲");
define("_Australia","澳洲");
define("_North_Central_America","中北美洲");
define("_South_America","南美洲");

define("_Recent","新近的");


define("_Unknown_takeoff","未知起飞场");
define("_Display_on_Google_Earth","在Google地球上显示");
define("_Use_Man_s_Module","Use Man's Module");
define("_Line_Color","航线外貌");
define("_Line_width","航线宽度");
define("_unknown_takeoff_tooltip_1","此次飞行的场地未知");
define("_unknown_takeoff_tooltip_2","如果您知道此次飞行在那个起飞场,请您点击填写!");
define("_EDIT_WAYPOINT","编辑起飞场信息");
define("_DELETE_WAYPOINT","删除起飞场");
define("_SUBMISION_DATE","上传日期"); // the date a flight was submited to leonardo
define("_TIMES_VIEWED","察看次数"); // the times that this flight havs been viewed


define("_takeoff_add_help_1","如果您知道起飞场信息,请填写,如果不太清楚,请关闭此窗口");
define("_takeoff_add_help_2","如果您的飞行与上列'未知起飞场'相同,则没必要重新填写,请关闭此窗口. ");
define("_takeoff_add_help_3","如果您在下面看到起飞场名字,直接点击会自动填写.");
define("_Takeoff_Name","起飞场名字");
define("_In_Local_Language","用当地语言");
define("_In_English","用英语");

// New on 2007/02/20 - login screen
define("_ENTER_PASSWORD","请输入用户名及密码登录.");
define("_SEND_PASSWORD","忘记密码");
define("_ERROR_LOGIN","输入错误的用户名或非法密码.");
define("_AUTO_LOGIN","每次访问自动登录");
define("_USERNAME","用户名");
define("_PASSWORD","密码");
define("_PROBLEMS_HELP","如有问题请与管理员联系");

define("_LOGIN_TRY_AGAIN","点击 %sHere%s 再试一次");
define("_LOGIN_RETURN","点击 %sHere%s 回到索引");
// end 2007/02/20

define("_Category","类别");
define("_MEMBER_OF","会员");
define("_MemberID","会员ID");
define("_EnterID","输入ID");
define("_Clubs_Leagues","俱乐部/联盟");
define("_Pilot_Statistics","飞行员成绩");
define("_National_Rankings","国家排名");

// new on 2007/03/08
define("_Select_Club","选俱乐部");
define("_Close_window","关闭窗口");
define("_EnterID","输入ID");
define("_Club","俱乐部");
define("_Sponsor","赞助商");


// new on 2007/03/13
define('_Go_To_Current_Month','转到当前月');
define('_Today_is','今天是');
define('_Wk','Wk');
define('_Click_to_scroll_to_previous_month','点击转入前月,按住自动翻转.');
define('_Click_to_scroll_to_next_month','点击转入下月,按住自动翻转.');
define('_Click_to_select_a_month','点击选择月份.');
define('_Click_to_select_a_year','点击选择年份.');
define('_Select_date_as_date.','选择[date]为日期.'); // do not replace [date], it will be replaced by date.
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

?>
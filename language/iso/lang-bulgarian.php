<? if (0) { ?><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"></head><? } ?><?php

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
	$monthList=array('Януари','Февруари','Март','Април','Май','Юни',
					'Юли','Август','Септември','Октомври','Ноември','Декември');
	$monthListShort=array('JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC');
	$weekdaysList=array('Mon','Tue','Wed','Thu','Fri','Sat','Sun') ;
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","Отворен прелет");
define("_FREE_TRIANGLE","Свободен триъгълник");
define("_FAI_TRIANGLE","FAI триъгълник");

define("_SUBMIT_FLIGHT_ERROR","При качването на полета възникна грешка");

// list_pilots()
define("_NUM","#");
define("_PILOT","Пилот");
define("_NUMBER_OF_FLIGHTS","Брой полети");
define("_BEST_DISTANCE","Най-добро разстояние");
define("_MEAN_KM","Средно разстояние за полет");
define("_TOTAL_KM","Сумарно разстояние");
define("_TOTAL_DURATION_OF_FLIGHTS","Сумарен нальот");
define("_MEAN_DURATION","Средна продължителност на полета");
define("_TOTAL_OLC_KM","Сумарно OLC разстояние");
define("_TOTAL_OLC_SCORE","Сумарни OLC точки");
define("_BEST_OLC_SCORE","Най-добър OLC резултат");
define("_From","от");

// list_flights()
define("_DURATION_HOURS_MIN","Време (ч:м)");
define("_SHOW","Покажи");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","Полета ще бъде активиран след 1-2 минути. ");
define("_TRY_AGAIN","Моля, опитайте отново по-късно");

define("_TAKEOFF_LOCATION","Място на старта");
define("_TAKEOFF_TIME","Време на  старта");
define("_LANDING_LOCATION","Място на приземяване");
define("_LANDING_TIME","Време на приземяване");
define("_OPEN_DISTANCE","Линейно разстояние");
define("_MAX_DISTANCE","Макс. разстояние");
define("_OLC_SCORE_TYPE","Тип OLC класиране");
define("_OLC_DISTANCE","OLC разстояние");
define("_OLC_SCORING","OLC точки");
define("_MAX_SPEED","Макс. скорост");
define("_MAX_VARIO","Макс. варио");
define("_MEAN_SPEED","Средна скорост");
define("_MIN_VARIO","Мин. варио");
define("_MAX_ALTITUDE","Макс. височина (н.м.в)");
define("_TAKEOFF_ALTITUDE","Височина на старта (н.м.в)");
define("_MIN_ALTITUDE","Мин. височина (н.м.в)");
define("_ALTITUDE_GAIN","Набрана височина");
define("_FLIGHT_FILE","Полетен Файл");
define("_COMMENTS","Коментари");
define("_RELEVANT_PAGE","Допълнителна страница");
define("_GLIDER","Летателен апарат");
define("_PHOTOS","Фотографии");
define("_MORE_INFO","Още информация");
define("_UPDATE_DATA","Обнови данните");
define("_UPDATE_MAP","Обнови картара");
define("_UPDATE_3D_MAP","Обнови 3D-карта");
define("_UPDATE_GRAPHS","Обнови графики");
define("_UPDATE_SCORE","Обнови оценяването");

define("_TAKEOFF_COORDS","Координати на старта:");
define("_NO_KNOWN_LOCATIONS","Неизвестно място ;-)");
define("_FLYING_AREA_INFO","Сведения за района");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo прелети");
define("_RETURN_TO_TOP","Връщане нагоре");
// list flight
define("_PILOT_FLIGHTS","Полети на пилота");

define("_DATE_SORT","Дата");
define("_PILOT_NAME","Име на пилота");
define("_TAKEOFF","Място на старта");
define("_DURATION","Продължителност");
define("_LINEAR_DISTANCE","Линейно разстояние");
define("_OLC_KM","OLC разстояние");
define("_OLC_SCORE","OLC точки");
define("_DATE_ADDED","Последно добавяне");

define("_SORTED_BY","Сортировка по:");
define("_ALL_YEARS","Всички години");
define("_SELECT_YEAR_MONTH","Избери година (и месец)");
define("_ALL","Всички");
define("_ALL_PILOTS","Покажи всички пилоти");
define("_ALL_TAKEOFFS","Покажи всички стартове");
define("_ALL_THE_YEAR","Всички години");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","Не сте указали полетен файл");
define("_NO_SUCH_FILE","Указания файл не може да бъде открит в сървъра");
define("_FILE_DOESNT_END_IN_IGC","Файлът няма .igc разширение");
define("_THIS_ISNT_A_VALID_IGC_FILE","Този файл не е .igc");
define("_THERE_IS_SAME_DATE_FLIGHT","Вече има файл с такава дата и време");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","Ако искате да го замените, първо");
define("_DELETE_THE_OLD_ONE","изтрийте стария");
define("_THERE_IS_SAME_FILENAME_FLIGHT","Вече има файл с такова име");
define("_CHANGE_THE_FILENAME","Ако този полет е различен, то моля сменете името му и опитайте отново");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","Вашия полет е записан в базата данни");
define("_PRESS_HERE_TO_VIEW_IT","Натиснете тук, за да го видите");
define("_WILL_BE_ACTIVATED_SOON","(ще бъде активен след 1-2 минути");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Публикувай няколко полета");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","Само IGC файлове се обработват");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","Запиши ZIP-файл<br>с полети");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","Натиснете тук за да публикувате полетите");

define("_FILE_DOESNT_END_IN_ZIP","Този файл не е с .zip разширение");
define("_ADDING_FILE","Добавяне на файла");
define("_ADDED_SUCESSFULLY","Успешно добавяне");
define("_PROBLEM","Проблем");
define("_TOTAL","Общо ");
define("_IGC_FILES_PROCESSED","полета са обработени");
define("_IGC_FILES_SUBMITED","полета са публикувани");

// info
define("_DEVELOPMENT","Разработка");
define("_ANDREADAKIS_MANOLIS","Манолис Андреадакис");
define("_PROJECT_URL","Страница на проекта");
define("_VERSION","Версия");
define("_MAP_CREATION","Създаване на карта");
define("_PROJECT_INFO","Информация за проекта");

// menu bar 
define("_MENU_MAIN_MENU","Главно меню");
define("_MENU_DATE","Избери дата");
define("_MENU_COUNTRY","Страна");
define("_MENU_XCLEAGUE","XC Лига");
define("_MENU_ADMIN","Админ");

define("_MENU_COMPETITION_LEAGUE","Лига - всички категории");
define("_MENU_OLC","XC");
define("_MENU_OPEN_DISTANCE","Oткрита дистанция");
define("_MENU_DURATION","Нальот");
define("_MENU_ALL_FLIGHTS","Покажи всички полети");
define("_MENU_FLIGHTS","Полети");
define("_MENU_TAKEOFFS","Места");
define("_MENU_FILTER","Филтър");
define("_MENU_MY_FLIGHTS","Мои полети");
define("_MENU_MY_PROFILE","Мой профил");
define("_MENU_MY_STATS","Моя статистика"); 
define("_MENU_MY_SETTINGS","Мои настройки"); 
define("_MENU_SUBMIT_FLIGHT","Добави полет");
define("_MENU_SUBMIT_FROM_ZIP","Добави zip-файл с полети");
define("_MENU_SHOW_PILOTS","Пилоти");
define("_MENU_SHOW_LAST_ADDED","Покажи последните добавени");
define("_FLIGHTS_STATS","Статистика на полетите");

define("_SELECT_YEAR","Избери година");
define("_SELECT_MONTH","Избери месец");
define("_ALL_COUNTRIES","Покажи всички страни");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","Всички времена");
define("_NUMBER_OF_FLIGHTS","Брой полети");
define("_TOTAL_DISTANCE","Сумарно разстояние");
define("_TOTAL_DURATION","Сумарнен налъот");
define("_BEST_OPEN_DISTANCE","Най-добра отворена дистанция");
define("_TOTAL_OLC_DISTANCE","Сумарно OLC разстояние");
define("_TOTAL_OLC_SCORE","Сумарни OLC точки");
define("_BEST_OLC_SCORE","Най-добра OLC оценка");
define("_MEAN_DURATION","Средна продължителност");
define("_MEAN_DISTANCE","Средно разстояние");
define("_PILOT_STATISTICS_SORT_BY","Пилоти - сортирай по");
define("_CATEGORY_FLIGHT_NUMBER","Категория 'Всеки ден на баира' - количество полети");
define("_CATEGORY_TOTAL_DURATION","Категория 'DURACELL' - сумарен нальот");
define("_CATEGORY_OPEN_DISTANCE","Категория 'Отворена дистанция'");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","Няма пилоти за показване!");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","Полета бе изтрит");
define("_RETURN","Назад");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","ВНИМАНИЕ - искате да изтриете този полет");
define("_THE_DATE","Дата ");
define("_YES","ДА");
define("_NO","НЕ");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","Резултати в лигата");
define("_N_BEST_FLIGHTS"," най-добри полети");
define("_OLC","XC");
define("_OLC_TOTAL_SCORE","Сумарни OLC точки");
define("_KILOMETERS","Километри");
define("_TOTAL_ALTITUDE_GAIN","Сумарен набор на височина");
define("_TOTAL_KM","Общо км");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","е");
define("_IS_NOT","не е");
define("_OR","или");
define("_AND","и");
define("_FILTER_PAGE_TITLE","Филтрирай полети");
define("_RETURN_TO_FLIGHTS","Върни се към полетите");
define("_THE_FILTER_IS_ACTIVE","Филтърът е активен");
define("_THE_FILTER_IS_INACTIVE","Филтърът е неактивен");
define("_SELECT_DATE","Избери дата");
define("_SHOW_FLIGHTS","Покажи полетите");
define("_ALL2","ВСИЧКИ");
define("_WITH_YEAR","година");
define("_MONTH","Месец");
define("_YEAR","Година");
define("_FROM","От");
define("_from","от");
define("_TO","до");
define("_SELECT_PILOT","Избери пилот");
define("_THE_PILOT","Пилот");
define("_THE_TAKEOFF","Старт");
define("_SELECT_TAKEOFF","Избери старт");
define("_THE_COUNTRY","Страна");
define("_COUNTRY","Страна");
define("_SELECT_COUNTRY","Избери страна");
define("_OTHER_FILTERS","Други филтри");
define("_LINEAR_DISTANCE_SHOULD_BE","Линейното разстояние трябва да е");
define("_OLC_DISTANCE_SHOULD_BE","OLC разстоянието трябва да е");
define("_OLC_SCORE_SHOULD_BE","OLC точките трябва да са");
define("_DURATION_SHOULD_BE","Продължителността трябва да е");
define("_ACTIVATE_CHANGE_FILTER","Активирай / промени филтър");
define("_DEACTIVATE_FILTER","Деактивирай филтър");
define("_HOURS","часа");
define("_MINUTES","минути");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","Добави полет");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(нужен е само IGC файл)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","Публикувай <br>IGC файла на полета");
define("_NOTE_TAKEOFF_NAME","Моля отбележете името на старта и страната");
define("_COMMENTS_FOR_THE_FLIGHT","Коментари за полета");
define("_PHOTO","Фото");
define("_PHOTOS_GUIDELINES","Снимките трябва да са  .jpg формат и не по-големи от ");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","Натиснете тук за да публикувате полета");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","Искате ли да публикувате повече полети наведнъж?");
define("_PRESS_HERE","Натиснете тук");

define("_IS_PRIVATE","Не показвай на друг");
define("_MAKE_THIS_FLIGHT_PRIVATE","Не показвай на друг");
define("_INSERT_FLIGHT_AS_USER_ID","Добавяне на полет като потребител ID");
define("_FLIGHT_IS_PRIVATE","Този полет не е за публично показване");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","Измени данните на полета");
define("_IGC_FILE_OF_THE_FLIGHT","IGC файл");
define("_DELETE_PHOTO","Изтрий");
define("_NEW_PHOTO","нова снимка");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","Натиснете тук, за да промените данните на полета");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","Запази промените");
define("_RETURN_TO_FLIGHT","Върни се към полета");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","Върни се към полета");
define("_READY_FOR_SUBMISSION","Готово за публикуване");
define("_OLC_MAP","Карта");
define("_OLC_BARO","Барограф");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","Профил на пилота");
define("_back_to_flights","назад към полетите");
define("_pilot_stats","статистика на пилота");
define("_edit_profile","редактиране на профила");
define("_flights_stats","статистика на полетите");
define("_View_Profile","прегледай профила");

define("_Personal_Stuff","Лични данни");
define("_First_Name","Име");
define("_Last_Name","Фамилия");
define("_Birthdate","Дата на рождане");
define("_dd_mm_yy","дд.мм.гг");
define("_Sign","Зодия");
define("_Marital_Status","Семейно положение");
define("_Occupation","Занятие");
define("_Web_Page","Уеб-страница");
define("_N_A","няма информация");
define("_Other_Interests","Други интереси");
define("_Photo","Фото");

define("_Flying_Stuff","Летателни данни");
define("_note_place_and_date","укажете страна и дата, където е уместно");
define("_Flying_Since","Летя от");
define("_Pilot_Licence","Лиценз на пилота");
define("_Paragliding_training","Обучение");
define("_Favorite_Location","Любимо място за летене");
define("_Usual_Location","Обичайно място за летене");
define("_Best_Flying_Memory","Най-добър летателен спомен");
define("_Worst_Flying_Memory","Най-лош летателен спомен");
define("_Personal_Distance_Record","Личен рекорд за разстояние");
define("_Personal_Height_Record","Личен рекорд за височина");
define("_Hours_Flown","Нальот в часове");
define("_Hours_Per_Year","Годишен нальот");

define("_Equipment_Stuff","Данни за екипировката");
define("_Glider","Производител и модел крило");
define("_Harness","Подвесна система");
define("_Reserve_chute","Запасен парашут");
define("_Camera","Фотокамера");
define("_Vario","Варио");
define("_GPS","GPS");
define("_Helmet","Шлем/Каска");
define("_Camcorder","Видеокамера");

define("_Manouveur_Stuff","Данни за маньоври");
define("_note_max_descent_rate","където е уместно, укажете достигнато максимално снижение");
define("_Spiral","Спирала");
define("_Bline","Б-срив");
define("_Full_Stall","Пълен срив");
define("_Other_Manouveurs_Acro","Други акро маньоври");
define("_Sat","САТ");
define("_Asymmetric_Spiral","Асиметрична спирала");
define("_Spin","Негативна спирала");

define("_General_Stuff","Общи данни");
define("_Favorite_Singer","Любим певец (певица)");
define("_Favorite_Movie","Любим филм");
define("_Favorite_Internet_Site","Любима интернет страница");
define("_Favorite_Book","Любима книга");
define("_Favorite_Actor","Любим актьор / актриса");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","Публикувайте нова снимка или променете старата");
define("_Delete_Photo","Изтрий снимка");
define("_Your_profile_has_been_updated","Вашия профил е обновен");
define("_Submit_Change_Data","Запиши промените");

//--------------------------------------------
// Added by Martin Jursa, 26.04.2007 for pilot_profile and pilot_profile_edit
//--------------------------------------------
define("_Sex", "Пол");
define("_Login_Stuff", "Промени данни за достъп (Login)");
define("_PASSWORD_CONFIRMATION", "Потвърди парола");
define("_EnterPasswordOnlyToChange", "Въведи парола само ако искаш да я промениш:");

define("_PwdAndConfDontMatch", "Паролата и потвърждението и са различни.");
define("_PwdTooShort", "Паролата е твърде кратка. Трябва да е с поне $passwordMinLength символа.");
define("_PwdConfEmpty", "паролата не е потвърдена.");
define("_PwdChanged", "Паролата беше променена.");
define("_PwdNotChanged", "Паролата НЕ Е променена.");
define("_PwdChangeProblem", "Появи се проблем при смяна на паролата.");

define("_EmailEmpty", "попълни e-mail адрес");
define("_EmailInvalid", "e-mail адресът е невалиден.");
define("_EmailSaved", "email адресът е записан");
define("_EmailNotSaved", "e-mail адресът не е записан.");
define("_EmailSaveProblem", "Появи се проблем при записване на  e-mail адреса.");

// End 26.04.2007



//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","чч:мм");

define("_Totals","Обобщение");
define("_First_flight_logged","Първи регистриран полет");
define("_Last_flight_logged","Последен регистриран полет");
define("_Flying_period_covered","Период на полетите");
define("_Total_Distance","Сумарно разстояние");
define("_Total_OLC_Score","Сумарни OLC точки");
define("_Total_Hours_Flown","Сумарен нальот");
define("_Total_num_of_flights","Сумарно количество полетов ");

define("_Personal_Bests","Лични рекорди");
define("_Best_Open_Distance","Най-добро линейно разстояние");
define("_Best_FAI_Triangle","Най-добър FAI триъгълник");
define("_Best_Free_Triangle","Най-добър свободен триъгълник");
define("_Longest_Flight","Най-дълъг полет");
define("_Best_OLC_score","Най-добра OLC оценка");
define("_Absolute_Height_Record","Абсолютен височинен рекорд");
define("_Altitute_gain_Record","Рекорд за набор на височина");

define("_Mean_values","Средни стойности");
define("_Mean_distance_per_flight","Средно разстояние за полет");
define("_Mean_flights_per_Month","Среден брой полети за месец");
define("_Mean_distance_per_Month","Средно разстояние за месец");
define("_Mean_duration_per_Month","Среднен нальот за месец");
define("_Mean_duration_per_flight","Среден нальот за полет");
define("_Mean_flights_per_Year","Среден брой полети за година");
define("_Mean_distance_per_Year","Средно разстояние за година");
define("_Mean_duration_per_Year","Среден нальот за година");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","Виж полети близо до тази точка");
define("_Waypoint_Name","Име на точката");
define("_Navigate_with_Google_Earth","Разгледай през Google Earth");
define("_See_it_in_Google_Maps","Виж в Google Maps");
define("_See_it_in_MapQuest","Виж в MapQuest");
define("_COORDINATES","Координати");
define("_FLIGHTS","Полети");
define("_SITE_RECORD","Рекорд за мястото");
define("_SITE_INFO","Информация за мястото");
define("_SITE_REGION","Регион");
define("_SITE_LINK","Връзки към повече информация");
define("_SITE_DESCR","Описание на място / старт");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","Виж още подробности");
define("_KML_file_made_by","KML файла е създаден от");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","Регистрирай старт");
define("_WAYPOINT_ADDED","Старта е регистриран");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","Рекорд на мястото<br>(открита дистанция)");
	
//--------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","Тип Крило");
function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'Парапланер',2=>'Делтапланер FAI1',4=>'Твърдо крило FAI5',8=>'Планер');
	foreach ($CONF_glider_types as $gId=>$gName) if (!$gliderCatList[$gId]) $gliderCatList[$gId]=$gName;
}
setGliderCats();


//--------------------------------------------
// class types
//--------------------------------------------
function setClassList() {
	$CONF_TEMP['gliderClasses'][1]['classes']=array(1=>"Спорт",2=>"Прототип",3=>"Тандем");
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
	$xcTypesList=array(1=>"Прелет през 3 точки",2=>"Отворен триъгълник",4=>"Затворен триъгълник");
	foreach ($CONF_xc_types as $gId=>$gName) if (!$xcTypesList[$gId]) $xcTypesList[$gId]=$gName;
}
setXCtypesList();

//--------------------------------------------
// user prefs  & units
//--------------------------------------------

define("_Your_settings_have_been_updated","Вашите настройки са обновени");

define("_THEME","Тема");
define("_LANGUAGE","Език");
define("_VIEW_CATEGORY","Виж категории");
define("_VIEW_COUNTRY","Виж страни");
define("_UNITS_SYSTEM" ,"Измервателна система");
define("_METRIC_SYSTEM","Метрична (км, м)");
define("_IMPERIAL_SYSTEM","Американска (мили, футове)");
define("_ITEMS_PER_PAGE","брой записи за страница");

define("_MI","mi");
define("_KM","км");
define("_FT","ft");
define("_M","м");
define("_MPH","mph");
define("_KM_PER_HR","км/ч");
define("_FPM","fpm");
define("_M_PER_SEC","м/с");

//--------------------------------------------
// index page
//--------------------------------------------

define("_WORLD_WIDE","Целия свят");
define("_National_XC_Leagues_for","Национални XC лиги за");
define("_Flights_per_Country","Полети за страна");
define("_Takeoffs_per_Country","Места за летене за страна");
define("_INDEX_HEADER","Добре дошли в Leonardo XC лига");
define("_INDEX_MESSAGE","Може да използвате &quot;Главно Меню&quot; за навигация или изпозвайте най-популярните връзки долу");

//--------------------------------------------
// NEW 
//--------------------------------------------
define("_MENU_SUMMARY_PAGE","Първа (Обща) Страница");
define("_Display_ALL","Покажи ВСИЧКИ");
define("_Display_NONE","Не показвай НИКОЙ");
define("_Reset_to_default_view","Възстанови стандартен изглед");
define("_No_Club","Без Клуб");
define("_This_is_the_URL_of_this_page","Това е URL адреса на тази страница");
define("_All_glider_types","Всички видове крила");

define("_MENU_SITES_GUIDE","Справочник за местата");
define("_Site_Guide","Справочник за местата");

define("_Search_Options","Опции за търсене");
define("_Below_is_the_list_of_selected_sites","Отдолу е списъка с избрани места");
define("_Clear_this_list","Изчисти този списък");
define("_See_the_selected_sites_in_Google_Earth","Виж избраните места в Google Earth");
define("_Available_Takeoffs","Налични стартове");
define("_Search_site_by_name","Търси място според името");
define("_give_at_least_2_letters","дай поне 2 букви");
define("_takeoff_move_instructions_1","Може да преместите всички налични стартове в избрания списък от десния панел, като използвате >> ");
define("_Takeoff_Details","Подробности за старта");


define("_Takeoff_Info","Информация за старта");
define("_XC_Info","XC инфо");
define("_Flight_Info","Инфо за полета");

define("_MENU_LOGOUT","Излез");
define("_MENU_LOGIN","Влез");
define("_MENU_REGISTER","Регистрирай потребител");
define("_PROJECT_HELP","Помощ");
define("_PROJECT_NEWS","Новини");
define("_PROJECT_RULES","Правила");



define("_Africa","Aфрика");
define("_Europe","Eвропа");
define("_Asia","Aзия");
define("_Australia","Aвстралия");
define("_North_Central_America","Северна/Централна Америка");
define("_South_America","Южна Америка");

define("_Recent","От скоро");


define("_Unknown_takeoff","Непознат старт");
define("_Display_on_Google_Earth","Покажи в Google Earth");
define("_Use_Man_s_Module","Use Man's Module");
define("_Line_Color","Цвят линия");
define("_Line_width","Дебелина на линия");
define("_unknown_takeoff_tooltip_1","Този полет е от непознат старт");
define("_unknown_takeoff_tooltip_2","ако знаете от кой старт е този полет, то моля го въведете!");

define("_EDIT_WAYPOINT","Редактирай информация за старт");
define("_DELETE_WAYPOINT","Изтрий точката на старта");
define("_SUBMISION_DATE","Дата на публикуване"); // the date a flight was submited to leonardo
define("_TIMES_VIEWED","пъти виждан"); // the times that this flight havs been viewed


define("_takeoff_add_help_1","Ако знаете повече информация за старта, можете да я въведете. Ако не сте сигурен може да затворите този прозорец");
define("_takeoff_add_help_2","Ако стартът на вашия полет е един от 'непознатите стартове', то няма нужда да го въвеждате отново. Просто затворете този прозорец.");
define("_takeoff_add_help_3","ако виждаш името на старта отдолу, натисни го за да попълни автоматично полетата в ляво.");
define("_Takeoff_Name","Име на старта");
define("_In_Local_Language","На местен език");
define("_In_English","На английски");

// New on 2007/02/20 - login screen
define("_ENTER_PASSWORD","Моля, въведи име и парола за да влезеш.");
define("_SEND_PASSWORD","Забравих си паролата");
define("_ERROR_LOGIN","Въвели сте неправилни или неактивни потребителско име или парола.");
define("_AUTO_LOGIN","Искам да влизам автоматично при всяко посещение");
define("_USERNAME","Име");
define("_PASSWORD","Парола");
define("_PROBLEMS_HELP","Ако имате проблем с влизането, моля обърнете се към администратора");

define("_LOGIN_TRY_AGAIN","Натисни %sТук%s за да опиташ отново");
define("_LOGIN_RETURN","Натисниk %sТук%s за да се върнеш към Началото");
// end 2007/02/20

define("_Category","Категория");
define("_MEMBER_OF","Член на");
define("_MemberID","Членски номер/ID");
define("_EnterID","Въведи номер/ID");
define("_Clubs_Leagues","Клубове / Лиги");
define("_Pilot_Statistics","Пилотска статистика");
define("_National_Rankings","Национални класации");




// new on 2007/03/08
define("_Select_Club","Избери Клуб");
define("_Close_window","Затвори прозорец");
define("_EnterID","Въведи номер/ID");
define("_Club","Клуб");
define("_Sponsor","Спонсор");


// new on 2007/03/13
define('_Go_To_Current_Month','Към текущия месец');
define('_Today_is','Днес е');
define('_Wk','седмица');
define('_Click_to_scroll_to_previous_month','Натиси за да отидеш към предишен месец. Задръж бутона на мишката за да превъртиш автоматично.');
define('_Click_to_scroll_to_next_month','Натисни за да отидеш към следващия месец. Задръж бутона на мишката, за да превъртиш автоматично.');
define('_Click_to_select_a_month','Натисни за да избереш месец.');
define('_Click_to_select_a_year','Натисни за да избереш година.');
define('_Select_date_as_date.','Избери [date] като дата.'); // do not replace [date], it will be replaced by date.
// end 2007/03/13


// New on 2007/05/18 (alternative GUI_filter)
define("_Filter_NoSelection", "Няма избор");
define("_Filter_CurrentlySelected", "Текущ избор");
define("_Filter_DialogMultiSelectInfo", "Натисни Ctrl за да избереш повече.");

define('_Filter_FilterTitleIncluding', 'Само избрани [неща]');
define('_Filter_FilterTitleExcluding', 'Изключи [неща]');
define('_Filter_DialogTitleIncluding', 'Избери  [неща]');
define('_Filter_DialogTitleExcluding', 'Избери [неща]');

define("_Filter_Items_pilot", "пилоти");
define("_Filter_Items_nacclub", "клубове");
define("_Filter_Items_country", "страни");
define("_Filter_Items_takeoff", "стартове");

define("_Filter_Button_Select", "Избери");
define("_Filter_Button_Delete", "Изтрий");
define("_Filter_Button_Accept", "Приеми селекцията");
define("_Filter_Button_Cancel", "Откажи");

# menu bar
define("_MENU_FILTER_NEW","Филтър **НОВА ВЕРСИЯ**");

// end 2007/05/18




// New on 2007/05/23
// second menu NACCclub selection
define("_ALL_NACCLUBS", "Всички Клубове");
// Note to translators: use the placeholder $nacname in your translation as it is, don"t translate it
define("_SELECT_NACCLUB", 'Избери [nacname]-Клуб');

// pilot profile
define("_FirstOlcYear", "Първа година участие в OLC");
define("_FirstOlcYearComment", "Моля изберете годината на първото ви участие в кое да е OLC, не само това.<br/>This field is relevant for the &quot;newcomer&quot;-rankings.");

//end 2007/05/23

// New on 2007/11/06
define("_Select_Brand","Избери марка");
define("_All_Brands","Всички марки");
define("_DAY","ДЕН");
define('_Glider_Brand','Марка крило');
define('_Or_Select_from_previous','или избери от предишните');

define('_Explanation_AddToBookmarks_IE', 'Добави тези настройки на филтъра, към любимите / favourites');
define('_Msg_AddToBookmarks_IE', 'Натисни тук, за да добавиш тези настройки на филтъра към твоите отметки / bookmarks.');
define('_Explanation_AddToBookmarks_nonIE', '(Запиши тази връзка към твоите отметки / bookmarks.)');
define('_Msg_AddToBookmarks_nonIE', 'За да запишеш тези настройки на филтъра, използвай Save to bookmarks в твоя браузър.');

define('_PROJECT_HELP','Помощ');
define('_PROJECT_NEWS','Новини');
define('_PROJECT_RULES','Правила  2007');
define('_PROJECT_RULES2','Правила 2008');

//end 2007/11/06
define('_MEAN_SPEED1','Средна скорост');
define('_External_Entry','Външно въвеждане / Entry');

// New on 2007/11/25
define('_Altitude','Височина');
define('_Speed','Скорост');
define('_Distance_from_takeoff','Разстояние от старта');

// New on 2007/12/03
define('_LAST_DIGIT','последна цифра');

define('_Filter_Items_nationality','националност');
define('_Filter_Items_server','сървър');

// New on 2007/12/15
define('_Ext_text1','Този полет първоначално е публикуван на ');
define('_Ext_text2','Връзка към пълни полетни карти');
define('_Ext_text3','Връзка към оригинален полет');


// New on 2008/2/15
define('_Male_short','M');
define('_Female_short','Ж');
define('_Male','Мъж');
define('_Female','Жена');
define('_Pilot_Statistics','Статистики на пилота');


// New on 2008/2/19
define('_Altitude_Short','Вис');
define("_Vario_Short","Варио");
define("_Time_Short","Време");
define("_Info","Инфо");
define("_Control","Контрол");

define("_Zoom_to_flight","Увеличи към полет");
define("_Follow_Glider","Следвай планер");
define("_Show_Task","Покажи задача");
define("_Show_Airspace","Покажи въздушно пространство");
define("_Thermals","Термики");

// New on 2008/06/04
define("_Show_Optimization_details","Покажи оптимизирани детайли");
define("_MENU_SEARCH_PILOTS","Търси");

//New on 2008/05/17
define('_MemberID_Missing', 'Липсва твоя членски номер / ID');
define('_MemberID_NotNumeric', 'Членския номер / ID трябва да е номер');

define('_FLIGHTADD_CONFIRMATIONTEXT', 'Чрез публикуване на тази форма, аз потвърждавам че спазвам всички законови изисквания засягащи този полет.');
define('_FLIGHTADD_IGC_MISSING', 'Моля, избери твоя .igc-file');
define('_FLIGHTADD_IGCZIP_MISSING', 'Моля, избери zip-файла съдържащ твоя .igc-файл');
define('_FLIGHTADD_CATEGORY_MISSING', 'Моля, избери категория');
define('_FLIGHTADD_BRAND_MISSING', 'Моля, избери марката на твоето крило');
define('_FLIGHTADD_GLIDER_MISSING', 'Моля, въведи типа на твоето крило');
define('_YOU_HAVENT_ENTERED_GLIDER', 'Не сте въвели марка на крилото');

define('_BRAND_NOT_IN_LIST', 'Марката не е в списъка');


/*------------------------------------------------------------
Durval Henke www.xcbrasil.org
------------------------------------------------------------*/
define("_Email_new_password","<p align='justify'>Сървърът изпрати писмо на пилота с новата парола и активационен ключ</p> <p align='justify'>Моля, провери си пощенската кутия и следвай инструкциите</p>");
define("_informed_user_not_found","Информираният потребител не е открит в нашата база данни");
define("_impossible_to_gen_new_pass","<p align='justify'>Съжаляваме, но не е възможно да генерираме парола за вас сега, защото вече има заявка която ще изтече <b>%s</b>. Може да направите нова заявка само след изтичане на определеното време.</p><p align='justify'>Ако нямате достъп до писмото, то се свържете с администратора на сървъра</p>");
define("_Password_subject_confirm","Писмо потвърждение (нова парола)");
define("_request_key_not_found", "the request key that you have informed was not found!");
define("_request_key_invalid", "request key that you have informed is invalid!"); 
define("_Email_allready_yours","The informed email is allready yours, nothing to do");
define("_Email_allready_have_request","There is already an request for changing to this email, nothing to do");
define("_Email_used_by_other","This email is used in another pilot, nothing to do");
define("_Email_used_by_other_request","This email are used in another pilot in a changing request mail");
define("_Email_canot_change_quickly","You can not change your email so quickly as you want, wait for the expiring time: %s");
define("_Email_sent_with_confirm","We send a email for you, where you must confirm the email changing");
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
define("_Requirements","Requeriments");
define("_Mandatory_CIVLID","Is mandatory tho have an valid <b>CIVLID</b>");
define("_Mandatory_valid_EMAIL","Is mandatory inform a <b>Valid Email</b> for further comunications with admin server");
define("_Email_periodic","Periodically we will send you a confirmation e-mail to the informed e-mail address, if not answered, your registration account will be blocked");
define("_Email_asking_conf","We will send a confirmation e-mail to the informed email address");
define("_Email_time_conf","You will have only <b>3 hours </b> after the finishing the pre-registration to answer the email");
define("_After_conf_time"," After that time, your pre-registration will be <b>removed</b> from our database");
define("_Only_after_time","<b>And only after we remove your pre-registration, you can do the pre registration again</b>");
define("_Disable_Anti_Spam","<b>ATTENTION!! Disable</b> the anti spam for emails originated from <b>%s</b>");
define("_If_you_agree","If you agree with this requirements please go further.");
define("_Search_civl_by_name","%sSearch for your name in the CIVL database%s . When you click at this left link will be opened a new window , please fill only 3 letters from your First name ou or Last Name, then the CIVL will return your CIVLID, Name and FAI Nationality.");
define("_Register_civl_as_new_pilot","If you are not founded in the CIVL database, please  %sREGISTER-ME AS A NEW PILOT%s");
define("_NICK_NAME","Nick Name");
define("_LOCAL_PWD","Local Password");
define("_LOCAL_PWD_2","Repeat Local Password");
define("_CONFIRM","Confirm");
define("_REQUIRED_FIELD","Mandatory Fields");
define("_Registration_Form","Registration Form at %s (Leonardo)");
define("_MANDATORY_NAME","Is Mandatory to inform your name");
define("_MANDATORY_FAI_NATION","Is Mandatory to inform your FAI NATION");
define("_MANDATORY_GENDER", "Please inform your Sex");
define("_MANDATORY_BIRTH_DATE_INVALID","Birth Date Invalid");
define("_MANDATORY_CIVL_ID", "Please Inform your CIVLID");
define("_Attention_mandatory_to_have_civlid","ATENTION!! For now one is Mandatory to have CIVLID in the %s database");
define("_Email_confirm_success","Your registration was successfully confirmed!");
define("_Success_login_civl_or_user","Success, now you can do your login using your CIVLID as username, or continue with your old username");
define("_Server_did_not_found_registration","Registration not founded, please copy and paste in your browser address field the link informed in the email that was sended to you, of maybee your registration time are expired");
define("_Pilot_already_registered","Pilot already registered with CIVLID %s and with name %s");
define("_User_already_registered","User already registered with this email or name");
define("_Pilot_civlid_email_pre_registration","Hi %s This Civl ID and email is already used in a pre-registration");
define("_Pilot_have_pre_registration"," You already have a pre registration, but have not answered our mail, we resend the confirmation email for you, you have 3 hours after now to answer the email, if not you will be removed from pre registration. please read the email and follow the procedures described inside, thank you");
define("_Pre_registration_founded","We already have a pre-registration with this civlID and Email,wait for finishing the period of 3 hours until then this registration will be removed, in no hipotisis confirm the email that was sended for you, because will be generated an double registration, and your old flights will not be transfered for the new user");            
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

http://%s?op=users&page=index&act=register&rkey=%s

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

http://%s?op=sdpw&rkey=%s

Regards,

--------
Note: This is auto-response. Do not send any email to this email address
--------");


// New on 2008/11/26
define('_MENU_AREA_GUIDE','Справочник за областите');
define('_All_XC_types','_Всички XC типове');
define('_xctype','XC типове');


define('_Flying_Areas','Летателни области');
define('_Name_of_Area','Име на областа');
define('_See_area_details','Виж подробности и стартове за тази област');

define('_choose_ge_module','Моля, избери модул за ползване <BR>за Google Earth Display');
define('_ge_module_advanced_1','(най-много подробности, по-голям размер)');
define('_ge_module_advanced_2','(много подробности, голям размер) ');
define('_ge_module_Simple','Simple (само полет, малък размер)');

define('_Pilot_search_instructions','Въведи поне 3 букви от Първото или Последното име');

define('_All_classes','Всички класове');
define('_Class','Клас');

/*

define('Show Optimization Details
define('Optimization
define('Scoring Factors Used: XC scoring

define('Type of Flight
define('Factor
define('XC distance	
define('XC Score

*/

// 2009-03-20 filter for photos
define("_Photos_filter_off","Със/без снимки");
define("_Photos_filter_on","Само със снимки");


define("_SEASON","Season"); 
define("_SUBMIT_TO_OLC","Submit to OLC"); 
define("_pilot_email","Email Address"); 
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

//--------------------------------------------------------
//--------------------------------------------------------
// Missing defines , autoreplaced values from 'english' 
//--------------------------------------------------------
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
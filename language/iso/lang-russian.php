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
	$monthList=array('Январь','Февраль','Март','Апрель','Май','Июнь',
					'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь');
	$monthListShort=array('JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC');
	$weekdaysList=array('Mon','Tue','Wed','Thu','Fri','Sat','Sun') ;
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","Полет на дальность");
define("_FREE_TRIANGLE","Свободный треугольник");
define("_FAI_TRIANGLE","Треугольник FAI");

define("_SUBMIT_FLIGHT_ERROR","При сохранении полета возникла проблема");

// list_pilots()
define("_NUM","#");
define("_PILOT","Пилот");
define("_NUMBER_OF_FLIGHTS","Всего полетов");
define("_BEST_DISTANCE","Лучшая дальность");
define("_MEAN_KM","Средняя дальность");
define("_TOTAL_KM","Суммарная дальность");
define("_TOTAL_DURATION_OF_FLIGHTS","Суммарный налет");
define("_MEAN_DURATION","Средняя продолжительность полета");
define("_TOTAL_OLC_KM","Суммарная зачетная дальность OLC");
define("_TOTAL_OLC_SCORE","Суммарный балл OLC");
define("_BEST_OLC_SCORE","Лучший балл OLC");
define("_From","с");

// list_flights()
define("_DURATION_HOURS_MIN","Время (ч:м)");
define("_SHOW","Посмотреть");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","Полет будет активирован через 1-2 минуты. ");
define("_TRY_AGAIN","Пожалуйста, попробуйте попозже");

define("_TAKEOFF_LOCATION","Место старта");
define("_TAKEOFF_TIME","Время старта");
define("_LANDING_LOCATION","Место посадки");
define("_LANDING_TIME","Время посадки");
define("_OPEN_DISTANCE","Линейная дальность");
define("_MAX_DISTANCE","Макс. дальность");
define("_OLC_SCORE_TYPE","Тип в OLC");
define("_OLC_DISTANCE","Дальность в OLC");
define("_OLC_SCORING","Баллы OLC");
define("_MAX_SPEED","Макс. скорость");
define("_MAX_VARIO","Макс. варио");
define("_MEAN_SPEED","Средняя скорость");
define("_MIN_VARIO","Мин. варио");
define("_MAX_ALTITUDE","Макс. высота (ASL)");
define("_TAKEOFF_ALTITUDE","Высота старта (ASL)");
define("_MIN_ALTITUDE","Мин. высота (ASL)");
define("_ALTITUDE_GAIN","Набор высоты");
define("_FLIGHT_FILE","Файл с полетом");
define("_COMMENTS","Комментарии");
define("_RELEVANT_PAGE","Ссылка на страницу");
define("_GLIDER","Летательный аппарат");
define("_PHOTOS","Фотографии");
define("_MORE_INFO","Дополнительно");
define("_UPDATE_DATA","Обновить данные");
define("_UPDATE_MAP","Обновить карту");
define("_UPDATE_3D_MAP","Обновить 3D-карту");
define("_UPDATE_GRAPHS","Обновить графики");
define("_UPDATE_SCORE","Обновить баллы");

define("_TAKEOFF_COORDS","Координаты старта:");
define("_NO_KNOWN_LOCATIONS","Это место не известно!");
define("_FLYING_AREA_INFO","Сведения о регионе");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Маршрутный сервер Leonardo");
define("_RETURN_TO_TOP","Наверх");
// list flight
define("_PILOT_FLIGHTS","Полеты пилота");

define("_DATE_SORT","Дата");
define("_PILOT_NAME","Пилот");
define("_TAKEOFF","Место");
define("_DURATION","Длительность");
define("_LINEAR_DISTANCE","Линейная дальность");
define("_OLC_KM","Дальность OLC");
define("_OLC_SCORE","Баллы OLC");
define("_DATE_ADDED","Крайние добавления");

define("_SORTED_BY","Сортировка по:");
define("_ALL_YEARS","Все годы");
define("_SELECT_YEAR_MONTH","Выбрать год (и месяц)");
define("_ALL","Все");
define("_ALL_PILOTS","Показать всех пилотов");
define("_ALL_TAKEOFFS","Показать все старты");
define("_ALL_THE_YEAR","Весь год");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","Вы не указали файл с треком");
define("_NO_SUCH_FILE","Указанный Вами файл не найден на сервере");
define("_FILE_DOESNT_END_IN_IGC","Файл не имеет расширения .igc");
define("_THIS_ISNT_A_VALID_IGC_FILE","Это не файл .igc");
define("_THERE_IS_SAME_DATE_FLIGHT","Уже есть файл с такими же датой и временем");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","Если хотите заменить его, сначала");
define("_DELETE_THE_OLD_ONE","удалите старый");
define("_THERE_IS_SAME_FILENAME_FLIGHT","Уже есть файл с таким же именем");
define("_CHANGE_THE_FILENAME","Если это другой полет, пожалуйста переименуйте его");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","Ваш полет внесен в базу");
define("_PRESS_HERE_TO_VIEW_IT","Нажмите сюда для его просмотра");
define("_WILL_BE_ACTIVATED_SOON","(он будет активирован через 1-2 минуты)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Добавить несколько полетов");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","Будут обработаны только файлы IGC");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","Введите имя ZIP-файла<br>с полетами");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","Нажмите сюда для закачки файла");

define("_FILE_DOESNT_END_IN_ZIP","Файл не имеет расширения .zip");
define("_ADDING_FILE","Загрузка файла");
define("_ADDED_SUCESSFULLY","Файл успешно загружен");
define("_PROBLEM","Проблема");
define("_TOTAL","Всего ");
define("_IGC_FILES_PROCESSED","полетов обработано");
define("_IGC_FILES_SUBMITED","полетов загружено");

// info
define("_DEVELOPMENT","Разработка");
define("_ANDREADAKIS_MANOLIS","Манолис Андреадакис");
define("_PROJECT_URL","Страница проекта");
define("_VERSION","Версия");
define("_MAP_CREATION","Создание карт");
define("_PROJECT_INFO","Информация о проекте");

// menu bar 
define("_MENU_MAIN_MENU","Главное меню");
define("_MENU_DATE","Период");
define("_MENU_COUNTRY","Страна");
define("_MENU_XCLEAGUE","Маршрутная лига");
define("_MENU_ADMIN","Админ");

define("_MENU_COMPETITION_LEAGUE","Лига - все категории");
define("_MENU_OLC","OLC");
define("_MENU_OPEN_DISTANCE","Открытая дальность");
define("_MENU_DURATION","Налет");
define("_MENU_ALL_FLIGHTS","Показать все полеты");
define("_MENU_FLIGHTS","Полеты");
define("_MENU_TAKEOFFS","Места");
define("_MENU_FILTER","Фильтр");
define("_MENU_MY_FLIGHTS","Мои полеты");
define("_MENU_MY_PROFILE","Мой профиль");
define("_MENU_MY_STATS","Моя статистика"); 
define("_MENU_MY_SETTINGS","Мои настройки"); 
define("_MENU_SUBMIT_FLIGHT","Добавить полет");
define("_MENU_SUBMIT_FROM_ZIP","Добавить zip-файл с полетами");
define("_MENU_SHOW_PILOTS","Пилоты");
define("_MENU_SHOW_LAST_ADDED","Крайние добавления");
define("_FLIGHTS_STATS","Статистика полетов");

define("_SELECT_YEAR","Выбрать год");
define("_SELECT_MONTH","Выбрать месяц");
define("_ALL_COUNTRIES","Показать все страны");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","ВСЕ ВРЕМЯ");
define("_NUMBER_OF_FLIGHTS","Кол-во полетов");
define("_TOTAL_DISTANCE","Суммарная дальность");
define("_TOTAL_DURATION","Суммарный налет");
define("_BEST_OPEN_DISTANCE","Лучшая открытая дальность");
define("_TOTAL_OLC_DISTANCE","Суммарная дальность OLC");
define("_TOTAL_OLC_SCORE","Суммарный балл OLC");
define("_BEST_OLC_SCORE","Лучший балл OLC");
define("_MEAN_DURATION","Среднее время");
define("_MEAN_DISTANCE","Средняя дальность");
define("_PILOT_STATISTICS_SORT_BY","Пилоты - Сортировка по");
define("_CATEGORY_FLIGHT_NUMBER","Категория 'КаждыйДеньНаГоре' - количество полетов");
define("_CATEGORY_TOTAL_DURATION","Категория 'DURACELL' - суммарное время в воздухе");
define("_CATEGORY_OPEN_DISTANCE","Категория 'Открытая дальность'");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","Ни одного пилота!");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","Полет удален");
define("_RETURN","Назад");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","ВНИМАНИЕ - Вы сейчас удалите этот полет");
define("_THE_DATE","Дата ");
define("_YES","ДА");
define("_NO","НЕТ");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","Результаты в лиге");
define("_N_BEST_FLIGHTS"," лучших полетов");
define("_OLC","OLC");
define("_OLC_TOTAL_SCORE","Суммарный балл OLC");
define("_KILOMETERS","Километры");
define("_TOTAL_ALTITUDE_GAIN","Суммарный набор высоты");
define("_TOTAL_KM","Всего км");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","");
define("_IS_NOT","НЕ");
define("_OR","или");
define("_AND","и");
define("_FILTER_PAGE_TITLE","Отфильтровать полеты");
define("_RETURN_TO_FLIGHTS","Вернуться к полетам");
define("_THE_FILTER_IS_ACTIVE","Фильтр активен");
define("_THE_FILTER_IS_INACTIVE","Фильтр неактивен");
define("_SELECT_DATE","Выбрать дату");
define("_SHOW_FLIGHTS","Показать полеты");
define("_ALL2","ВСЕ");
define("_WITH_YEAR","Год");
define("_MONTH","Месяц");
define("_YEAR","Год");
define("_FROM","С");
define("_from","из");
define("_TO","по");
define("_SELECT_PILOT","Выбрать пилота");
define("_THE_PILOT","Пилот");
define("_THE_TAKEOFF","Старт");
define("_SELECT_TAKEOFF","Выбрать старт");
define("_THE_COUNTRY","Страна");
define("_COUNTRY","Страна");
define("_SELECT_COUNTRY","Выбрать страну");
define("_OTHER_FILTERS","Другие фильтры");
define("_LINEAR_DISTANCE_SHOULD_BE","Линейная дальность");
define("_OLC_DISTANCE_SHOULD_BE","Дальность OLC");
define("_OLC_SCORE_SHOULD_BE","Балл OLC");
define("_DURATION_SHOULD_BE","Продолжительность");
define("_ACTIVATE_CHANGE_FILTER","Активировать / изменить ФИЛЬТР");
define("_DEACTIVATE_FILTER","Деактивировать ФИЛЬТР");
define("_HOURS","часов");
define("_MINUTES","минут");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","Добавить полет");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(нужен только файл IGC)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","Введите имя<br>файла IGC");
define("_NOTE_TAKEOFF_NAME","Пожалуйста, укажите название старта и страну");
define("_COMMENTS_FOR_THE_FLIGHT","Комментарии к полету");
define("_PHOTO","Фото");
define("_PHOTOS_GUIDELINES","Фотографии должны быть в формате jpg и меньше ");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","Нажмите сюда для загрузки полета");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","Вы хотите добавить сразу несколько полетов?");
define("_PRESS_HERE","Нажмите сюда");

define("_IS_PRIVATE","Никому не показывать");
define("_MAKE_THIS_FLIGHT_PRIVATE","Никому не показывать");
define("_INSERT_FLIGHT_AS_USER_ID","Добавить полет как пользователь");
define("_FLIGHT_IS_PRIVATE","Этот полет не для публичного просмотра");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","Изменить данные о полете");
define("_IGC_FILE_OF_THE_FLIGHT","Файл IGC");
define("_DELETE_PHOTO","Удалить");
define("_NEW_PHOTO","еще фото");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","Нажмите сюда для изменения данных о полете");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","Изменения сохранены");
define("_RETURN_TO_FLIGHT","Вернуться к полету");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","Вернуться к полету");
define("_READY_FOR_SUBMISSION","Все готово для включения");
define("_OLC_MAP","Карта");
define("_OLC_BARO","Барограф");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","Профиль пилота");
define("_back_to_flights","назад к полетам");
define("_pilot_stats","статистика пилота");
define("_edit_profile","редактировать профиль");
define("_flights_stats","статистика полетов");
define("_View_Profile","Просмотр профиля");

define("_Personal_Stuff","Личные данные");
define("_First_Name","Имя");
define("_Last_Name","Фамилия");
define("_Birthdate","Дата рождения");
define("_dd_mm_yy","дд.мм.гг");
define("_Sign","Знак зодиака");
define("_Marital_Status","Семейное положение");
define("_Occupation","Занятие");
define("_Web_Page","Веб-страница");
define("_N_A","нет информации");
define("_Other_Interests","Другие интересы");
define("_Photo","Фото");

define("_Flying_Stuff","Полетные данные");
define("_note_place_and_date","где уместно, укажите место (страну) и дату");
define("_Flying_Since","Летаю с");
define("_Pilot_Licence","Лицензия пилота");
define("_Paragliding_training","Обучение");
define("_Favorite_Location","Любимое место полетов");
define("_Usual_Location","Обычное место полетов");
define("_Best_Flying_Memory","Лучшее воспоминание о полете");
define("_Worst_Flying_Memory","Худшее воспоминание о полете");
define("_Personal_Distance_Record","Личный рекорд дальности");
define("_Personal_Height_Record","Личный рекорд высоты");
define("_Hours_Flown","Налет в часах");
define("_Hours_Per_Year","Годовой налет");

define("_Equipment_Stuff","Данные о снаряжении");
define("_Glider","Летательный аппарат");
define("_Harness","Подвеска");
define("_Reserve_chute","Запаска");
define("_Camera","Фотокамера");
define("_Vario","Варио");
define("_GPS","GPS");
define("_Helmet","Шлем");
define("_Camcorder","Видеокамера");

define("_Manouveur_Stuff","Данные о маневрах");
define("_note_max_descent_rate","где уместно, укажите макс. скорость снижения");
define("_Spiral","Спираль");
define("_Bline","B-свал");
define("_Full_Stall","Задний свал");
define("_Other_Manouveurs_Acro","Другие акро-маневры");
define("_Sat","САТ");
define("_Asymmetric_Spiral","Асимметричная спираль");
define("_Spin","Негативная спираль");

define("_General_Stuff","Разное");
define("_Favorite_Singer","Любимый певец (певица)");
define("_Favorite_Movie","Любимый фильм");
define("_Favorite_Internet_Site","Любимый веб-сайт");
define("_Favorite_Book","Любимая книга");
define("_Favorite_Actor","Любимый артист(ка)");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","Загрузить новое фото или заменить старое");
define("_Delete_Photo","Удалить фото");
define("_Your_profile_has_been_updated","Ваш профиль обновлен");
define("_Submit_Change_Data","Сохранить данные");

//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","чч:мм");

define("_Totals","Итого");
define("_First_flight_logged","Первый зарегистрированный полет");
define("_Last_flight_logged","Крайний зарегистрированный полет");
define("_Flying_period_covered","Охваченный период полетов");
define("_Total_Distance","Суммарная дальность");
define("_Total_OLC_Score","Суммарный балл OLC");
define("_Total_Hours_Flown","Суммарный налет");
define("_Total_num_of_flights","Суммарное количество полетов ");

define("_Personal_Bests","Личные рекорды");
define("_Best_Open_Distance","Лучшая открытая дальность");
define("_Best_FAI_Triangle","Лучший треугольник FAI");
define("_Best_Free_Triangle","Лучший свободный треугольник");
define("_Longest_Flight","Самый долгий полет");
define("_Best_OLC_score","Лучший балл OLC");
define("_Absolute_Height_Record","Абсолютный рекорд высоты");
define("_Altitute_gain_Record","Рекорд набора высоты");

define("_Mean_values","Средние значения");
define("_Mean_distance_per_flight","Средняя дальность полета");
define("_Mean_flights_per_Month","В среднем полетов в месяц");
define("_Mean_distance_per_Month","Средняя дальность в месяц");
define("_Mean_duration_per_Month","Средний налет в месяц");
define("_Mean_duration_per_flight","Средняя длительность полета");
define("_Mean_flights_per_Year","В среднем полетов в год");
define("_Mean_distance_per_Year","Средняя дальность в год");
define("_Mean_duration_per_Year","Средний налет в год");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","Показать полеты рядом с этой точкой");
define("_Waypoint_Name","Имя точки");
define("_Navigate_with_Google_Earth","Посмотреть в Google Earth");
define("_See_it_in_Google_Maps","Посмотреть в Google Maps");
define("_See_it_in_MapQuest","Посмотреть в  MapQuest");
define("_COORDINATES","Координаты");
define("_FLIGHTS","Полеты");
define("_SITE_RECORD","Рекорд места");
define("_SITE_INFO","Информация о месте");
define("_SITE_REGION","Регион");
define("_SITE_LINK","Ссылка на подробности");
define("_SITE_DESCR","Описание места (старта)");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","Еще подробности");
define("_KML_file_made_by","KML file файл создан");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","Внести новое место (старт)");
define("_WAYPOINT_ADDED","Старт зарегистрирован");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","Рекорд места<br>(открытая дальность)");
	
//--------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","Тип ЛА");
function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'Параплан',2=>'Дельтаплан FAI1',4=>'Жесткое крыло FAI5',8=>'Планер');
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

define("_Your_settings_have_been_updated","Ваши настройки сохранены");

define("_THEME","Тема");
define("_LANGUAGE","Язык");
define("_VIEW_CATEGORY","Просмотр категории");
define("_VIEW_COUNTRY","Просмотр страны");
define("_UNITS_SYSTEM" ,"Система мер");
define("_METRIC_SYSTEM","Метрическая (км, м)");
define("_IMPERIAL_SYSTEM","Дюймовая (мили, футы)");
define("_ITEMS_PER_PAGE","Записей на странице");

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

define("_WORLD_WIDE","Весь мир");
define("_National_XC_Leagues_for","Национальные маршрутные лиги за");
define("_Flights_per_Country","Полеты по странам");
define("_Takeoffs_per_Country","Летные места по странам");
define("_INDEX_HEADER","Добро пожаловать в маршрутную лигу Leonardo");
define("_INDEX_MESSAGE","Используйте &quot;Главное меню&quot; для навигации или используйте наиболее популярные ссылки внизу.");


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
//--------------------------------------------------------
//--------------------------------------------------------
// Missing defines , autoreplaced values from 'english' 
//--------------------------------------------------------
define("_SEASON","Season"); 
define("_IS_NOT","is not"); 
define("_SUBMIT_TO_OLC","Submit to OLC"); 
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
define("_Requirements","Requeriments"); 
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

?>
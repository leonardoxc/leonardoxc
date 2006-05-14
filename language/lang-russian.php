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
	global  $monthList;
	$monthList=array('Январь','Февраль','Март','Апрель','Май','Июнь',
					'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь');
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
define("_PHOTOS_GUIDELINES","Фотографии должны быть в формате jpg и меньше 100 КБ");
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
define("_SUBMIT_TO_OLC","Включить файл в OLC");
define("_YOUR_FLIGHT_HAS_BEEN_SUCCESSFULLY_SUBMITED_TO_THE_OLC","Полет включен в OLC");
define("_THE_OLC_REFERENCE_NUMBER_IS","Номер полета в OLC");
define("_THERE_WAS_A_PROBLEM_ON_OLC_SUBMISSION","Не получилось включить полет в OLC");
define("_LOOK_BELOW_FOR_THE_CAUSE_OF_THE_PROBLEM","Причина проблемы ниже");
define("_FLIGHT_SUCCESFULLY_REMOVED_FROM_OLC","Полет успешно удален из OLC");
define("_FLIGHT_NOT_SCORED","Полету не присвоен зачетный балл OLC");
define("_TOO_LATE","Прошел срок, в течение которого этот полет мог быть включен в OLC");
define("_CANNOT_BE_SUBMITTED","Прошел срок, в течение которого этот полет мог быть включен в OLC");
define("_NO_PILOT_OLC_DATA","<p><strong>Нет данных о пилоте, необходимых для OLC</strong><br>
  <br>
<b>Что такое OLC / зачем эти поля ?</b><br><br>
	OLC - On-Line Contest - онлайновое соревнование.</p>
	Для включения файла в OLC пилот должен быть уже зарегистрирован в системе OLC.</p>
 Это можно сделать <a href='http://www2.onlinecontest.org/olcphp/2005/ausw_wertung.php?olc=holc-i&spr=en' target='_blank'>
 здесь</a>, где Вы должны выбрать свою страну и затем 'Contest Registration'<br>
</p>
<p>После регистрации нужно зайти в 'Pilot Profile'->'Edit OLC info' и ввести там Вашу информацию В ТОЧНОСТИ так же, как при регистрации в OLC
</p>
<ul>
	<li><div align=left>Имя</div>
	<li><div align=left>Фамилия</div>
	<li><div align=left>Дата рождения</div>
	<li> <div align=left>Позывной</div>
	<li><div align=left>Если Вы уже вводили полеты в OLC, 4 буквы, которые Вы используете для имени IGC файла</div>
</ul>");
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
// pilot_пlc_profile_edit.php
//--------------------------------------------
define("_edit_OLC_info","Редактировать данные OLC");
define("_OLC_information","Информация OLC");
define("_callsign","Позывной");
define("_filename_suffix","Расширение файлов");
define("_OLC_Pilot_Info","Информация о пилоте OLC");
define("_OLC_EXPLAINED","<b>Что такое OLC / зачем эти поля?</b><br><br>
	Для регистрации полетов в OLC пилот должен быть уже зарегистрирован в системе OLC.</p>
<p> Это может быть сделано <a href='http://www2.onlinecontest.org/olcphp/2005/ausw_wertung.php?olc=holc-i&spr=en' target='_blank'>
  на этой странице</a>, где Вы должны выбрать свою страну и потом выбрать 'Contest Registration'<br>
</p>
<p>После регистрации Вы должны ввести здесь свои данные ТОЧНО ТАК ЖЕ, как Вы их ввели при регистрации в OLC
</p>
<ul>
	<li><div align=left>Имя</div>
	<li><div align=left>Фамилия</div>
	<li><div align=left>Дата рождения</div>
	<li> <div align=left>Ваш позывной</div>
	<li><div align=left>Если Вы уже регистрировали полеты в OLC, 4 буквы, которые Вы используете для файлов IGC</div>
</ul>
");

define("_OLC_SUFFIX_EXPLAINED","<b>Что такое 'расширение файла'?</b><br>Это четырехбуквенный идентификатор, который однозначно идентифицирует пилота или параплан. 
Если Вы совсем не знаете, что ввести, вот Вам несколько советов:<p>
<ul>
<li>Используйте 4 буквы Вашего имени/фамилии
<li>Попробуйте придумать достаточно необычную комбинацию. Это снизит вероятность того, что Ваше расширение совпадет с чьим-то еще
<li>Если у Вас возникнут проблемы с регистрацией полетов в OLC через Leonardo, дело может быть в расширении. Попробуйте поменять его и послать полет еще раз.
</ul>");
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
	global  $gliderCatList;
	$gliderCatList=array(1=>'Параплан',2=>'Дельтаплан FAI1',4=>'Жесткое крыло FAI5',8=>'Планер');
}
setGliderCats();

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

?>
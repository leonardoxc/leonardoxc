<? if (0){?><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><? }?><?php

/**************************************************************************/
/* Hungarian language translation by                                        */
/* Zsolt Röhberg (rohberg@vnet.hu)                               */
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
	$monthList=array('Január','Február','Március','Április','Május','Június',
					'Július','Augusztus','Szeptember','Október','November','December');
	$monthListShort=array('JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC');
	$weekdaysList=array('Mon','Tue','Wed','Thu','Fri','Sat','Sun') ;
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","Szabadtáv");
define("_FREE_TRIANGLE","Háromszög");
define("_FAI_TRIANGLE","FAI háromszög");

define("_SUBMIT_FLIGHT_ERROR","Probléma adódott a repülés beküldésénél");

// list_pilots()
define("_NUM","#");
define("_PILOT","Pilóta");
define("_NUMBER_OF_FLIGHTS","Repülések száma");
define("_BEST_DISTANCE","Legjobb táv");
define("_MEAN_KM","Átlag # km per repülés");
define("_TOTAL_KM","Összes repült km");
define("_TOTAL_DURATION_OF_FLIGHTS","Összes repült időtartam");
define("_MEAN_DURATION","Átlagos repült időtartam");
define("_TOTAL_OLC_KM","Összes OLC táv");
define("_TOTAL_OLC_SCORE","Összes OLC pont");
define("_BEST_OLC_SCORE","Legjobb OLC pont");
define("_From","tól");

// list_flights()
define("_DURATION_HOURS_MIN","Idő (ó:p)");
define("_SHOW","Megjelenítés");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","A repülés 1-2 percen belül aktiválódik. ");
define("_TRY_AGAIN","Kérem, próbálja meg később!");

define("_TAKEOFF_LOCATION","Starthely");
define("_TAKEOFF_TIME","Startidőpont");
define("_LANDING_LOCATION","Leszállás");
define("_LANDING_TIME","Leszállás időpontja");
define("_OPEN_DISTANCE","Egyenes távolság");
define("_MAX_DISTANCE","Max távolság");
define("_OLC_SCORE_TYPE","OLC pont típus");
define("_OLC_DISTANCE","OLC távolság");
define("_OLC_SCORING","OLC pont");
define("_MAX_SPEED","Max sebesség");
define("_MAX_VARIO","Max vario");
define("_MEAN_SPEED","Átlagsebesség");
define("_MIN_VARIO","Min vario");
define("_MAX_ALTITUDE","Max mag (ASL)");
define("_TAKEOFF_ALTITUDE","Start mag (ASL)");
define("_MIN_ALTITUDE","Min mag (ASL)");
define("_ALTITUDE_GAIN","Magasságnyerés");
define("_FLIGHT_FILE","Repülés fájl");
define("_COMMENTS","Megjegyzések");
define("_RELEVANT_PAGE","Kapcsolódó web-oldal (URL)");
define("_GLIDER","Siklóernyő");
define("_PHOTOS","Fotók");
define("_MORE_INFO","Egyebek");
define("_UPDATE_DATA","Adatok frissítése");
define("_UPDATE_MAP","Térkép frissítése");
define("_UPDATE_3D_MAP","3D térkép frissítése");
define("_UPDATE_GRAPHS","Diagrammok frissítése");
define("_UPDATE_SCORE","Pontozás frissítése");

define("_TAKEOFF_COORDS","Felszállás koordinátái:");
define("_NO_KNOWN_LOCATIONS","Nincsenek ismert helyek!");
define("_FLYING_AREA_INFO","Repülési terület infók");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo XC");
define("_RETURN_TO_TOP","Vissza a lap tetejére");
// list flight
define("_PILOT_FLIGHTS","Pilóta repülései");

define("_DATE_SORT","Dátum");
define("_PILOT_NAME","Pilóta neve");
define("_TAKEOFF","Starthely");
define("_DURATION","Időtartam");
define("_LINEAR_DISTANCE","Szabadtáv");
define("_OLC_KM","OLC km");
define("_OLC_SCORE","OLC pont");
define("_DATE_ADDED","Legutóbb beküldött repülések");

define("_SORTED_BY","Rendezés:");
define("_ALL_YEARS","Minden év");
define("_SELECT_YEAR_MONTH","Év (és hónap) kiválasztása");
define("_ALL","Összes");
define("_ALL_PILOTS","Összes pilóta megjelenítése");
define("_ALL_TAKEOFFS","Összes starthely megjelenítése");
define("_ALL_THE_YEAR","Egész év");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","Nem küldtél még be repülésfájlt");
define("_NO_SUCH_FILE","A megadott repülésfájlt nem találom a szerveren");
define("_FILE_DOESNT_END_IN_IGC","A fájl neve nem .igc -re végződik");
define("_THIS_ISNT_A_VALID_IGC_FILE","Ez nem egy érvényes .igc fájl");
define("_THERE_IS_SAME_DATE_FLIGHT","Van már egy repülés ugyanezzel a dátummal és időponttal");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","Ha ki akarod cserélni, akkor először");
define("_DELETE_THE_OLD_ONE","le kell törölnöd a régit");
define("_THERE_IS_SAME_FILENAME_FLIGHT","Van már egy repülés ugyanezzel a ugyanezzel a fájlnévvel");
define("_CHANGE_THE_FILENAME","Ha ez egy másik repülés, változtasd meg a fájl nevét és próbáld meg újra");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","A repülésed sikeresen beküldve");
define("_PRESS_HERE_TO_VIEW_IT","Kattints ide, ha meg akarod nézni");
define("_WILL_BE_ACTIVATED_SOON","(1-2 percen belül aktiválódik)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Több repülés együttes beküldése");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","Csak az IGC fájlok lesznek feldolgozva");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","Add meg a repüléseket<br>tartalmazó ZIP fájlt");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","A repülések beküldéséhez kattints ide");

define("_FILE_DOESNT_END_IN_ZIP","A fájl neve nem .zip -re végződik");
define("_ADDING_FILE","Fájl beküldése");
define("_ADDED_SUCESSFULLY","A beküldés sikeres");
define("_PROBLEM","Probléma");
define("_TOTAL","Összesen ");
define("_IGC_FILES_PROCESSED","repülés lett feldolgozva");
define("_IGC_FILES_SUBMITED","repülés lett beküldve");

// info
define("_DEVELOPMENT","Fejlesztő");
define("_ANDREADAKIS_MANOLIS","Andreadakis Manolis");
define("_PROJECT_URL","A projekt honlapja");
define("_VERSION","Verzió");
define("_MAP_CREATION","Térképek létrehozása");
define("_PROJECT_INFO","Projekt információ");

// menu bar 
define("_MENU_MAIN_MENU","Főmenü");
define("_MENU_DATE","Dátum");
define("_MENU_COUNTRY","Ország");
define("_MENU_XCLEAGUE","Verseny állása");
define("_MENU_ADMIN","Adminisztráció");

define("_MENU_COMPETITION_LEAGUE","Összesített OLC ponttábla");
define("_MENU_OLC","Legjobb OLC pontok");
define("_MENU_OPEN_DISTANCE","Legjobb távok");
define("_MENU_DURATION","Össz időtartam");
define("_MENU_ALL_FLIGHTS","Összes repülés");
define("_MENU_FLIGHTS","Repülések (szűrve)");
define("_MENU_TAKEOFFS","Starthelyek");
define("_MENU_FILTER","Szűrők");
define("_MENU_MY_FLIGHTS","Saját repülések");
define("_MENU_MY_PROFILE","Saját profil");
define("_MENU_MY_STATS","Saját statisztikák"); 
define("_MENU_MY_SETTINGS","Egyéb beállítások"); 
define("_MENU_SUBMIT_FLIGHT","Repülés beküldése");
define("_MENU_SUBMIT_FROM_ZIP","Több repülés beküldése");
define("_MENU_SHOW_PILOTS","Pilóták");
define("_MENU_SHOW_LAST_ADDED","Legfrissebb repülések");
define("_FLIGHTS_STATS","Repülési statisztikák");

define("_SELECT_YEAR","Év kiválasztása");
define("_SELECT_MONTH","Hónap kiválasztása");
define("_ALL_COUNTRIES","Összes ország megjelenítése");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","BÁRMIKOR");
define("_NUMBER_OF_FLIGHTS","Repülések száma");
define("_TOTAL_DISTANCE","Összes távolság");
define("_TOTAL_DURATION","Összes időtartam");
define("_BEST_OPEN_DISTANCE","Legnagyobb távolság");
define("_TOTAL_OLC_DISTANCE","Összes OLC távolság");
define("_TOTAL_OLC_SCORE","Összes OLC pont");
define("_BEST_OLC_SCORE","Legjobb OLC pont");
define("_MEAN_DURATION","Átlagos időtartam");
define("_MEAN_DISTANCE","Átlagos távolság");
define("_PILOT_STATISTICS_SORT_BY","Pilóták - Rendezés:");
define("_CATEGORY_FLIGHT_NUMBER","'VillámVili' kategória (repülések száma)");
define("_CATEGORY_TOTAL_DURATION","'DURACELL' kategória - (repülések össz időtartama)");
define("_CATEGORY_OPEN_DISTANCE","'Szabadtáv' kategória");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","Nincs ilyen pilóta!");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","A repülés törölve");
define("_RETURN","Vissza");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","FIGYELEM - Törölni akarod ezt a repülést");
define("_THE_DATE","Dátum ");
define("_YES","IGEN");
define("_NO","NEM");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","Liga eredmények");
define("_N_BEST_FLIGHTS"," legjobb repülés");
define("_OLC","OLC");
define("_OLC_TOTAL_SCORE","OLC össz pontszám");
define("_KILOMETERS","Kilométer");
define("_TOTAL_ALTITUDE_GAIN","Összes magasságnyerés");
define("_TOTAL_KM","Összes km");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","=");
define("_IS_NOT","nem =");
define("_OR","vagy");
define("_AND","és");
define("_FILTER_PAGE_TITLE","Repülések szűrése");
define("_RETURN_TO_FLIGHTS","Vissza a repülésekhez");
define("_THE_FILTER_IS_ACTIVE","A szűrő bekapcsolva");
define("_THE_FILTER_IS_INACTIVE","A szűrő nincs bekapcsolva");
define("_SELECT_DATE","Időszak kiválasztása");
define("_SHOW_FLIGHTS","Repülések megjelenítése eszerint");
define("_ALL2","ÖSSZES");
define("_WITH_YEAR","Az év");
define("_MONTH","Hónap");
define("_YEAR","Év");
define("_FROM","Tól");
define("_from","tól");
define("_TO","Ig");
define("_SELECT_PILOT","Pilóta kiválasztása");
define("_THE_PILOT","A pilóta");
define("_THE_TAKEOFF","A starthely");
define("_SELECT_TAKEOFF","A starthely kiválasztása");
define("_THE_COUNTRY","Az ország");
define("_COUNTRY","Ország");
define("_SELECT_COUNTRY","Ország kiválasztása");
define("_OTHER_FILTERS","További szűrők");
define("_LINEAR_DISTANCE_SHOULD_BE","Az egyenes távolság legyen");
define("_OLC_DISTANCE_SHOULD_BE","Az OLC távolság legyen");
define("_OLC_SCORE_SHOULD_BE","Az OLC pontszám legyen");
define("_DURATION_SHOULD_BE","Az időtartam legyen");
define("_ACTIVATE_CHANGE_FILTER","A SZŰRŐ bekapcsolása / módosítása");
define("_DEACTIVATE_FILTER","A SZŰRŐ kikapcsolása");
define("_HOURS","óra");
define("_MINUTES","perc");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","Repülés beküldése");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(csak az IGC fájl szükséges hozzá)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","Add meg a repülés<br>IGC fájlját");
define("_NOTE_TAKEOFF_NAME","Írd be legalább a starthely helyének nevét és az országot");
define("_COMMENTS_FOR_THE_FLIGHT","Megjegyzések a repüléshez");
define("_PHOTO","Fotó");
define("_PHOTOS_GUIDELINES","A fotók jpg formátumúak legyenek és kisebbek, mint ");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","A repülés beküldéséhez ezt nyomd meg");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","Több repülést szeretnél egyszerre beküldeni ?");
define("_PRESS_HERE","Kattints ide!");

define("_IS_PRIVATE","Ne mutasd meg másoknak");
define("_MAKE_THIS_FLIGHT_PRIVATE","Ne mutasd meg másoknak");
define("_INSERT_FLIGHT_AS_USER_ID","Repülés beszúrása ehhez a felhasználói azonosítóhoz (ID)");
define("_FLIGHT_IS_PRIVATE","Ez a repülés nem publikus");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","Repülési adatok módosítása");
define("_IGC_FILE_OF_THE_FLIGHT","A repülés IGC fájlja");
define("_DELETE_PHOTO","Törlés");
define("_NEW_PHOTO","új fotó");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","A repülési adatok módosításához ezt nyomd meg");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","A módosítások magtörténtek");
define("_RETURN_TO_FLIGHT","Vissza a repülésekhez");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","Vissza a repülésekhez");
define("_READY_FOR_SUBMISSION","Beküldésre kész");
define("_OLC_MAP","Térkép");
define("_OLC_BARO","Barográf");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","Pilóta adatai");
define("_back_to_flights","vissza a repülésekhez");
define("_pilot_stats","pilóta statisztikái");
define("_edit_profile","adatok szerkesztése");
define("_flights_stats","repülés statisztikái");
define("_View_Profile","Adatok megtekintése");

define("_Personal_Stuff","Személyes adatok");
define("_First_Name","Keresztnév");
define("_Last_Name","Vezetéknév");
define("_Birthdate","Születési dátum");
define("_dd_mm_yy","nn.hh.éé");
define("_Sign","Jel");
define("_Marital_Status","Családi állapot");
define("_Occupation","Foglalkozás");
define("_Web_Page","Honlap");
define("_N_A","<N/A>");
define("_Other_Interests","Egyéb érdeklődési kör");
define("_Photo","Fotó");

define("_Flying_Stuff","Repüléssel kapcsolatos adatok");
define("_note_place_and_date","ahol lehet, add meg a helyet, országot és dátumot");
define("_Flying_Since","Mióta repülsz");
define("_Pilot_Licence","Pilóta licenceszám");
define("_Paragliding_training","Silóernyős jogosítás");
define("_Favorite_Location","Kedvenc hely");
define("_Usual_Location","Szokott hely");
define("_Best_Flying_Memory","Legszebb repülési emlék");
define("_Worst_Flying_Memory","Legrosszabb repülési emlék");
define("_Personal_Distance_Record","Egyéni távrekord");
define("_Personal_Height_Record","Egyéni magasságrekord");
define("_Hours_Flown","Repült órák száma");
define("_Hours_Per_Year","Évente repült órák száma");

define("_Equipment_Stuff","Eszközökkel kapcsolatos adatok");
define("_Glider","Siklóernyő");
define("_Harness","Beülő");
define("_Reserve_chute","Mentőernyő");
define("_Camera","Fényképezőgép");
define("_Vario","Varió");
define("_GPS","GPS");
define("_Helmet","Sisak");
define("_Camcorder","Kamera");

define("_Manouveur_Stuff","Manőverek");
define("_note_max_descent_rate","ahol lehet, add meg a max. süllyedési sebességedet");
define("_Spiral","Spirál");
define("_Bline","B-stall");
define("_Full_Stall","Full-stall");
define("_Other_Manouveurs_Acro","Acro manőverek");
define("_Sat","Sat");
define("_Asymmetric_Spiral","Asszimmetrikus spirál");
define("_Spin","Negatív");

define("_General_Stuff","Egyéb adatok");
define("_Favorite_Singer","Kedvenc énekes");
define("_Favorite_Movie","Kedvenc film");
define("_Favorite_Internet_Site","Kedvenc<br>internet oldal");
define("_Favorite_Book","Kedvenc könyv");
define("_Favorite_Actor","Kedvenc színész");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","Új fotó feltöltése");
define("_Delete_Photo","Fotó törlése");
define("_Your_profile_has_been_updated","Az adataid frissítése megtörtént");
define("_Submit_Change_Data","A megváltoztatott adatok beküldése");

//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","óó:pp");

define("_Totals","Összesítés");
define("_First_flight_logged","Az első naplózott repülés");
define("_Last_flight_logged","A legutolsó naplózott repülés");
define("_Flying_period_covered","A teljes repülési időszak");
define("_Total_Distance","Összes távolság");
define("_Total_OLC_Score","Összes OLC pont");
define("_Total_Hours_Flown","Összes idő órákban");
define("_Total_num_of_flights","Repülések száma összesen");

define("_Personal_Bests","Egyéni legjobbak");
define("_Best_Open_Distance","Legjobb szabadtáv");
define("_Best_FAI_Triangle","Legjobb FAI háromszög");
define("_Best_Free_Triangle","Legjobb szabad háromszög");
define("_Longest_Flight","Leghosszabb repülés");
define("_Best_OLC_score","Legjobb OLC pontszám");

define("_Absolute_Height_Record","Abszolút magassági rekord");
define("_Altitute_gain_Record","Magasságnyerési rekord");
define("_Mean_values","Átlagértékek");
define("_Mean_distance_per_flight","Repülések átlagos hossza");
define("_Mean_flights_per_Month","Repülések átlagos száma havonta");
define("_Mean_distance_per_Month","Átlagos repülési távolság havonta");
define("_Mean_duration_per_Month","Átlagos repülési időtartam havonta");
define("_Mean_duration_per_flight","Átlagos időtartam repülésenként");
define("_Mean_flights_per_Year","Repülések átlagos száma évente");
define("_Mean_distance_per_Year","Átlagos repülési távolság évente");
define("_Mean_duration_per_Year","Átlagos repülési időtartam évente");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","E pont közelében történt repülések megjelenítése");
define("_Waypoint_Name","Útpont név");
define("_Navigate_with_Google_Earth","Navigálás a Google Earth segítségével");
define("_See_it_in_Google_Maps","Megjelenítés a Google Mapsben");
define("_See_it_in_MapQuest","Megjelenítés a MapQuestben");
define("_COORDINATES","Koordináták");
define("_FLIGHTS","Repülések");
define("_SITE_RECORD","Helyi rekord");
define("_SITE_INFO","Helyi információ");
define("_SITE_REGION","Regió");
define("_SITE_LINK","További információkra mutató link");
define("_SITE_DESCR","Hely/starthely bemutatása");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","Mutasd meg részletesebben");
define("_KML_file_made_by","KML fájl, készítette");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","Starthely regisztrációja");
define("_WAYPOINT_ADDED","A starthelyet már regisztrálták.");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","Helyi rekord<br>(szabadtáv)");
	
//--------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","Siklórepülő típus");
function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'Siklóernyő',2=>'Rugalmas szárny FAI1',4=>'Merevszárny FAI5',8=>'Vitorlázórepülő');
	foreach ($CONF_glider_types as $gId=>$gName) if (!$gliderCatList[$gId]) $gliderCatList[$gId]=$gName;
}
setGliderCats();

//--------------------------------------------
// user prefs  & units
//--------------------------------------------

define("_Your_settings_have_been_updated","A beállításaid frissültek.");

define("_THEME","Kinézet");
define("_LANGUAGE","Nyelv");
define("_VIEW_CATEGORY","Siklórepülő kategória");
define("_VIEW_COUNTRY","Ország");
define("_UNITS_SYSTEM" ,"Mértékegység rendszer");
define("_METRIC_SYSTEM","Metrikus (km,m)");
define("_IMPERIAL_SYSTEM","Angolszász (mérföld,láb)");
define("_ITEMS_PER_PAGE","Sorok száma laponként");

define("_MI","mi");
define("_KM","km");
define("_FT","ft");
define("_M","m");
define("_MPH","mph");
define("_KM_PER_HR","km/ó");
define("_FPM","fpm");
define("_M_PER_SEC","m/mp");

//--------------------------------------------
// index page
//--------------------------------------------

define("_WORLD_WIDE","Minden ország");
define("_National_XC_Leagues_for","Nemzeti XC ligák: ");
define("_Flights_per_Country","Repülések országonként");
define("_Takeoffs_per_Country","Starthelyek országonként");
define("_INDEX_HEADER","Üdvözlünk a Leonardo XC Ligában");
define("_INDEX_MESSAGE","A fenti menürendszer vagy a lentebb kiemelt menüpontok segítségével navigálhatsz a lehetőségek közt.");

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
define("_Zoom_to_flight","Zoom to<br>flight"); 
define("_Follow_Glider","Follow<br>Glider"); 
define("_Show_Task","Show<br>Task"); 
define("_Show_Airspace","Show<br>Airspace"); 
define("_Show_Optimization_details","Show Optimization Details"); 
define("_MENU_SEARCH_PILOTS","Search"); 

?>
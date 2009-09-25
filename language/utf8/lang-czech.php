<? if (0){?><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><? }?><?php

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
	$monthList=array('Leden','Unor','Brezen','Duben','Kveten','Cerven',               
					   'Cervenec','Srpen','Zari','Rijen','Listopad','Prosinec');

	$monthListShort=array('LED','UNO','BRE','DUB','KVE','CRN','CRC','SRP','ZAR','RIJ','LIS','PRO');
	$weekdaysList=array('Po','Ut','St','Ct','Pa','So','Ne') ;
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","Volne letani");
define("_FREE_TRIANGLE","Otevreny trojuhelnik");
define("_FAI_TRIANGLE","FAI trojuhelnik");

define("_SUBMIT_FLIGHT_ERROR","Byl problem s ulozenim letu");

// list_pilots()
define("_NUM","cislo");
define("_PILOT","Pilot");
define("_NUMBER_OF_FLIGHTS","Pocet letu");
define("_BEST_DISTANCE","Nejlepsi vzdalenost");
define("_MEAN_KM","Prumerny let Km");
define("_TOTAL_KM","Celkovy let Km");
define("_TOTAL_DURATION_OF_FLIGHTS","Celkove trvani letu");
define("_MEAN_DURATION","Prumerne trvani letu");
define("_TOTAL_OLC_KM","Celkova OLC vzdalenost");
define("_TOTAL_OLC_SCORE","Celkove OLC skore");
define("_BEST_OLC_SCORE","Nejlepsi OLC skore");
define("_From","z");

// list_flights()
define("_DURATION_HOURS_MIN","Trvani");
define("_SHOW","Ukaz");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","Let bude aktivovan behem nekolika minut. ");
define("_TRY_AGAIN","Prosim zkuste pozdeji");

define("_TAKEOFF_LOCATION","Misto vzletu");
define("_TAKEOFF_TIME","Cas vzletu");
define("_LANDING_LOCATION","Misto pristani");
define("_LANDING_TIME","Cas pristani");
define("_OPEN_DISTANCE","Prima vzdalenost");
define("_MAX_DISTANCE","Maximalni vzdalenost");
define("_OLC_SCORE_TYPE","OLC score type");
define("_OLC_DISTANCE","OLC vzdalenost");
define("_OLC_SCORING","OLC skore");
define("_MAX_SPEED","Max rychlost");
define("_MAX_VARIO","Max vario");
define("_MEAN_SPEED","Prumerna rychlost");
define("_MIN_VARIO","Min vario");
define("_MAX_ALTITUDE","Max nadmorska vyska");
define("_TAKEOFF_ALTITUDE","Nadmorska vyska na vzletu");
define("_MIN_ALTITUDE","Min nadmorska vyska");
define("_ALTITUDE_GAIN","Nastoupani");
define("_FLIGHT_FILE","Letovy soubor");
define("_COMMENTS","Pripominky");
define("_RELEVANT_PAGE","Podobna stranka URL");
define("_GLIDER","Kluzak");
define("_PHOTOS","Fotky");
define("_MORE_INFO","Informace navic");
define("_UPDATE_DATA","Osvezit udaje");
define("_UPDATE_MAP","Osvezit mapu");
define("_UPDATE_3D_MAP","Osvezit 3D mapu");
define("_UPDATE_GRAPHS","Osvezit grafy");
define("_UPDATE_SCORE","Osvezit skore");

define("_TAKEOFF_COORDS","Vzletove souradnice:");
define("_NO_KNOWN_LOCATIONS","Nezname oblasti!");
define("_FLYING_AREA_INFO","Informace o letove oblasti");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo XC server");
define("_RETURN_TO_TOP","Navrat na zacatek");
// list flight
define("_PILOT_FLIGHTS","Pilotovy lety");

define("_DATE_SORT","Datum");
define("_PILOT_NAME","Pilotovo jmeno");
define("_TAKEOFF","Vzlet");
define("_DURATION","Trvani");
define("_LINEAR_DISTANCE","Prima vzdalenost");
define("_OLC_KM","OLC km");
define("_OLC_SCORE","OLC skore");
define("_DATE_ADDED","Naposledy pridano");

define("_SORTED_BY","Utridit podle:");
define("_ALL_YEARS","Vsechny roky");
define("_SELECT_YEAR_MONTH","Vyber rok_mesic");
define("_ALL","Vsichni");
define("_ALL_PILOTS","Zobraz vsechny piloty");
define("_ALL_TAKEOFFS","Zobraz vsechny vzlety");
define("_ALL_THE_YEAR","Cely rok");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","Nepredlozil jsi soubor");
define("_NO_SUCH_FILE","Soubor ktery jsi predlozil nemuze byt nalezen");
define("_FILE_DOESNT_END_IN_IGC","Soubor nekonci priponou .igc ");
define("_THIS_ISNT_A_VALID_IGC_FILE","Toto neni platny .igc soubor");
define("_THERE_IS_SAME_DATE_FLIGHT","Let se stejnym datem a casem jiz existuje");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","Pokud jej chces zamenit, nejdrive");
define("_DELETE_THE_OLD_ONE","vymaz ten puvodni");
define("_THERE_IS_SAME_FILENAME_FLIGHT","Let se stejnym jmenem jiz existuje");
define("_CHANGE_THE_FILENAME","Pokud je to jiny let, zmen prosim nejdriv jmeno letu");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","Tvuj let byl ulozen");
define("_PRESS_HERE_TO_VIEW_IT","Klikni tady pro zobrazeni");
define("_WILL_BE_ACTIVATED_SOON","Bude aktivovano behem nekolika minut");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Predloz nekolik letu");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","Jenom IGC soubory budou zpracovany");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","Predloz ZIP soubor<br>s informaci o letech");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","Klikni tady pro zpracovani letu");

define("_FILE_DOESNT_END_IN_ZIP","Soubor ktery jsi predlozil nema priponu .zip");
define("_ADDING_FILE","Pridat soubor");
define("_ADDED_SUCESSFULLY","Pridan uspesne");
define("_PROBLEM","Problem");
define("_TOTAL","Dohromady ");
define("_IGC_FILES_PROCESSED","soubory byly zpracovany");
define("_IGC_FILES_SUBMITED","lety byly pridany");

// info
define("_DEVELOPMENT","Vytvoreni");
define("_ANDREADAKIS_MANOLIS","Andreadakis Manolis");
define("_PROJECT_URL","Projekt URL");
define("_VERSION","Verze");
define("_MAP_CREATION","Mapu vytvoril");
define("_PROJECT_INFO","Informace o projektu");

// menu bar 
define("_MENU_MAIN_MENU","Hlavni Menu");
define("_MENU_DATE","Vyber datum");
define("_MENU_COUNTRY","Vyber stat");
define("_MENU_XCLEAGUE","XC Liga");
define("_MENU_ADMIN","Admin");

define("_MENU_COMPETITION_LEAGUE","Liga-vsechny kategorie");
define("_MENU_OLC","OLC");
define("_MENU_OPEN_DISTANCE","otevrena vzdalenost");
define("_MENU_DURATION","trvani");
define("_MENU_ALL_FLIGHTS","zobraz vsechny lety");
define("_MENU_FLIGHTS","lety");
define("_MENU_TAKEOFFS","vzlety");
define("_MENU_FILTER","Filtr");
define("_MENU_MY_FLIGHTS","moje lety");
define("_MENU_MY_PROFILE","Muj profil");
define("_MENU_MY_STATS","Moje udaje"); 
define("_MENU_MY_SETTINGS","Moje zadani"); 
define("_MENU_SUBMIT_FLIGHT","predloz let");
define("_MENU_SUBMIT_FROM_ZIP","predloz lety ze zip");
define("_MENU_SHOW_PILOTS","Piloti");
define("_MENU_SHOW_LAST_ADDED","zobraz pridane naposledy");
define("_FLIGHTS_STATS","letove udaje");

define("_SELECT_YEAR","vyber rok");
define("_SELECT_MONTH","vyber mesic");
define("_ALL_COUNTRIES","zobraz vsechny zeme");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","vsechny casy");
define("_NUMBER_OF_FLIGHTS","pocet letu");
define("_TOTAL_DISTANCE","celkova vzdalenost");
define("_TOTAL_DURATION","celkove trvani");
define("_BEST_OPEN_DISTANCE","nejlepsi vzdalenost");
define("_TOTAL_OLC_DISTANCE","celkova OLC vzdalenost");
define("_TOTAL_OLC_SCORE","celkove OLC skore");
define("_BEST_OLC_SCORE","nejlepsi OLC skore");
define("_MEAN_DURATION","Prumerne trvani");
define("_MEAN_DISTANCE","Prumerna vzdalenost");
define("_PILOT_STATISTICS_SORT_BY","Piloti - utridit dle");
define("_CATEGORY_FLIGHT_NUMBER","kategorie 'FastJoe' - pocet letu");
define("_CATEGORY_TOTAL_DURATION","kategorie 'DURACELL' - celkove trvani letu");
define("_CATEGORY_OPEN_DISTANCE","kategorie 'Open Distance'");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","zadni piloti k zobrazeni!");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","let byl vymazan");
define("_RETURN","navrat");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","POZOR - tento let bude vymazan");
define("_THE_DATE","Datum ");
define("_YES","ano");
define("_NO","Ne");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","ligove vysledky");
define("_N_BEST_FLIGHTS"," nejlepsi lety");
define("_OLC","OLC");
define("_OLC_TOTAL_SCORE","OLC celkove hodnoceni");
define("_KILOMETERS","Kilometry");
define("_TOTAL_ALTITUDE_GAIN","celkove nastoupani");
define("_TOTAL_KM","celkem km");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","je");
define("_IS_NOT","neni");
define("_OR","nebo");
define("_AND","a");
define("_FILTER_PAGE_TITLE","Filtruj lety");
define("_RETURN_TO_FLIGHTS","navrat do letu");
define("_THE_FILTER_IS_ACTIVE","filtr je aktivni");
define("_THE_FILTER_IS_INACTIVE","filtr neni aktivni");
define("_SELECT_DATE","vyber datum");
define("_SHOW_FLIGHTS","zobraz lety");
define("_ALL2","vsechny");
define("_WITH_YEAR","s rokem");
define("_MONTH","mesic");
define("_YEAR","rok");
define("_FROM","z");
define("_from","z");
define("_TO","do");
define("_SELECT_PILOT","vyber pilota");
define("_THE_PILOT","pilot");
define("_THE_TAKEOFF","misto vzletu");
define("_SELECT_TAKEOFF","vyber misto vzletu");
define("_THE_COUNTRY","zeme");
define("_COUNTRY","zeme");
define("_SELECT_COUNTRY","vyber zemi");
define("_OTHER_FILTERS","jine filtry");
define("_LINEAR_DISTANCE_SHOULD_BE","Prima vzdalenost by mela byt");
define("_OLC_DISTANCE_SHOULD_BE","OLC vzdalenost by mela byt");
define("_OLC_SCORE_SHOULD_BE","OLC skore by melo byt");
define("_DURATION_SHOULD_BE","trvani by melo byt");
define("_ACTIVATE_CHANGE_FILTER","zaktivuj / zmen FILTR");
define("_DEACTIVATE_FILTER","deaktivuj filtr");
define("_HOURS","hodiny");
define("_MINUTES","minuty");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","predloz let");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(jenom IGC soubor je potreba)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","predloz IGC soubor pro let");
define("_NOTE_TAKEOFF_NAME","prosim zaznamenej jmeno mista vzletu a zeme");
define("_COMMENTS_FOR_THE_FLIGHT","pripominky k letu");
define("_PHOTO","foto");
define("_PHOTOS_GUIDELINES","fotografie by mely byt ve formatu JPEG a mensi nez 100Kb");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","tady klikni pro zapsani letu");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","chces predlozit mnoho letu najednou ?");
define("_PRESS_HERE","klikni tady");

define("_IS_PRIVATE","nezobrazuj verejne");
define("_MAKE_THIS_FLIGHT_PRIVATE","nezobrazuj verejne");
define("_INSERT_FLIGHT_AS_USER_ID","vloz let jako jmeno uzivatele");
define("_FLIGHT_IS_PRIVATE","Tento let neni verejny");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","zmen udaje o letu");
define("_IGC_FILE_OF_THE_FLIGHT","IGC soubor letu");
define("_DELETE_PHOTO","vymazat");
define("_NEW_PHOTO","nove foto");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","zmen let kliknutim zde");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","zmeny byly zaznamenany");
define("_RETURN_TO_FLIGHT","zpet k letu");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","zpet k letu");
define("_READY_FOR_SUBMISSION","pripravene k odeslani");
define("_SUBMIT_TO_OLC","odesli k OLC");
define("_YOUR_FLIGHT_HAS_BEEN_SUCCESSFULLY_SUBMITED_TO_THE_OLC","let byl uspesne odeslan do OLC");
define("_THE_OLC_REFERENCE_NUMBER_IS","OLC referencni cislo je");
define("_THERE_WAS_A_PROBLEM_ON_OLC_SUBMISSION","problem pri odeslani do OLC");
define("_LOOK_BELOW_FOR_THE_CAUSE_OF_THE_PROBLEM","duvod problemu popsan nize");
define("_FLIGHT_SUCCESFULLY_REMOVED_FROM_OLC","let byl uspesne vymazan z OLC");
define("_FLIGHT_NOT_SCORED","let nemuze byt zaznamenan, protoze nema OLC hodnoceni");
define("_TOO_LATE","tento let nemuze byt zaznamenan, protoze doba k jeho predlozeni uz vyprsela");
define("_CANNOT_BE_SUBMITTED","doba k predlozeni tohoto letu jiz vyprsela");
define("_NO_PILOT_OLC_DATA","<p><strong>chybejici OLC udaje pro tohoto pilota
  <br>
<b>What is OLC / what are these fields for ?</b><br><br>
	For a valid submission to OLC the pilot should already be registered in the OLC system.</p>
<p> This can be done <a href='http://www2.onlinecontest.org/olcphp/2005/ausw_wertung.php?olc=holc-i&spr=en' target='_blank'>
  at this web page</a>, where you must select your country and then select 'Contest Registration'<br>
</p>
<p>When the registration is done, you must go to 'Pilot Profile'->'Edit OLC info' and enter there your info EXACTLY as you entrered it at OLC registration
</p>
<ul>
	<li><div align=left>First/Given name</div>
	<li><div align=left>Surname</div>
	<li><div align=left>Date of birth</div>
	<li> <div align=left>Your callsign</div>
	<li><div align=left>If you have already submitted flights to OLC, the 4 letters you use for the IGC filename</div>
</ul>");
define("_OLC_MAP","Map");
define("_OLC_BARO","Barograph");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","profil pilota");
define("_back_to_flights","zpet k letum");
define("_pilot_stats","statistiky pilota");
define("_edit_profile","oprav profil");
define("_flights_stats","letove udaje");
define("_View_Profile","prohledni profil");

define("_Personal_Stuff","osobni udaje");
define("_First_Name"," jmeno");
define("_Last_Name","prijmeni");
define("_Birthdate","datum narozeni");
define("_dd_mm_yy","dd.mm.rr");
define("_Sign","znameni");
define("_Marital_Status","Marital Status");
define("_Occupation","zamestnani");
define("_Web_Page","internetova stranka");
define("_N_A","neni k dispozici");
define("_Other_Interests","jine zajmy");
define("_Photo","fotografie");

define("_Flying_Stuff","O letani");
define("_note_place_and_date","zaznamej misto-zemi a datum");
define("_Flying_Since","letam jiz od");
define("_Pilot_Licence","Pilotni Prukaz");
define("_Paragliding_training","Paraglidingovy trenink");
define("_Favorite_Location","oblibene misto");
define("_Usual_Location","obvykle misto");
define("_Best_Flying_Memory","nejlepsi vzpomonka z letani");
define("_Worst_Flying_Memory","nejhorsi vzpominka z letani");
define("_Personal_Distance_Record","Osobni vzdalenostni rekord");
define("_Personal_Height_Record","Osobni vyskovy rekord");
define("_Hours_Flown","Naletane hodiny");
define("_Hours_Per_Year","Hodin za rok");

define("_Equipment_Stuff","Udaje o vybaveni");
define("_Glider","Kridlo");
define("_Harness","Sedacka");
define("_Reserve_chute","Zalozni padak");
define("_Camera","Fotak");
define("_Vario","Vario");
define("_GPS","GPS");
define("_Helmet","Helma");
define("_Camcorder","Video kamera");

define("_Manouveur_Stuff","Udaje o manevrech");
define("_note_max_descent_rate","pokud se vztahuje-zaznamenej maximalni klesani ");
define("_Spiral","Spirala");
define("_Bline","Bline");
define("_Full_Stall","Full Stall");
define("_Other_Manouveurs_Acro","Ostatni Acro manevry");
define("_Sat","Sat");
define("_Asymmetric_Spiral","Asymmetricka Spirala");
define("_Spin","Spin");

define("_General_Stuff","Obecne udaje");
define("_Favorite_Singer","Oblibeny/a zpevak/ka, kapela");
define("_Favorite_Movie","Oblibeny film");
define("_Favorite_Internet_Site","Oblibena internetova stranka");
define("_Favorite_Book","Oblibena kniha");
define("_Favorite_Actor","Oblibeny herec/ka");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","Upload nove foto nebo zmen stare");
define("_Delete_Photo","Smazat foto");
define("_Your_profile_has_been_updated","Tvuj profil byl upraven");
define("_Submit_Change_Data","Predloz - Zmen Data");

//--------------------------------------------
// pilot_ďlc_profile_edit.php
//--------------------------------------------
define("_edit_OLC_info","Uprav OLC info");
define("_OLC_information","OLC informace");
define("_callsign","Callsign");
define("_filename_suffix","pripona souboru");
define("_OLC_Pilot_Info","OLC Pilot Info");
define("_OLC_EXPLAINED","<b>Co je OLC / K cemu jsou tyto udaje ?</b><br><br>
	Pro platne predlozeni udaju do OLC, pilot by jiz mel byt zaregistrovan.</p>
<p> To muze byt provedeno zde <a href='http://www2.onlinecontest.org/olcphp/2005/ausw_wertung.php?olc=holc-i&spr=en' target='_blank'>
  na teto internetove strance</a>, kde si musis vybrat zemi a kliknout 'Contest Registration'<br>
</p>
<p>Kdyz zapisujes informace o sobe, musis je zapsat PRESNE tak, jako v OLC registraci
</p>
<ul>
	<li><div align=left>First/Given name</div>
	<li><div align=left>Surname</div>
	<li><div align=left>Date of birth</div>
	<li> <div align=left>Your callsign</div>
	<li><div align=left>If you have already submitted flights to OLC, the 4 letters you use for the IGC filename</div>
</ul>
");

define("Vysvetleni OLC pripony","<b>Co je 'Pripona souboru?'</b><br>Je to identifikaceslozena ze 4 pismen, ktera unikatne identifikuje pilota nebo kridlo.
Jestlize opravdu nevis co sem zapsat, tady jsou nejake priklady:<p>
<ul>
<li>ouzij 4 pismena odvozena od tveho jmena / prijmeni.
<li>Pokus se najit kombinaci, ktera by se odlisila. Tim se zmensi pravdepodobnost, ze tvoje pripona by byla stejna, jako jineho pilota.
<li>Jestlize mas potize predlozit udaje do Leonarda, problem muze byt v pripone. Zkus ji zmenit a predlozit znovu.
</ul>");
//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","hh:mm");

define("_Totals","Dohromady");
define("_First_flight_logged","Prvni let zaznamenan");
define("_Last_flight_logged","Posledni let zaznamenan");
define("_Flying_period_covered","Doba letu zahrnuta");
define("_Total_Distance","Celkova vzdalenost");
define("_Total_OLC_Score","Celkove OLC skore");
define("_Total_Hours_Flown","Celkem hodin naletano");
define("_Total_num_of_flights","Celkovy pocet letu ");

define("_Personal_Bests","Nejlepsi osobni vykony");
define("_Best_Open_Distance","Nejlepsi otevrena vzdalenost");
define("_Best_FAI_Triangle","Nejlepsi FAI Trojuhelnik");
define("_Best_Free_Triangle","Nejlepsi otevreny trojuhelnik");
define("_Longest_Flight","Nejdelsi let");
define("_Best_OLC_score","Nejlepsi OLC skore");

define("_Absolute_Height_Record","Absolutni vyskovy rekord");
define("_Altitute_gain_Record","Rekord ve stoupani");
define("_Mean_values","Prumerne hodnoty");
define("_Mean_distance_per_flight","Prumerna vzdalenost na let");
define("_Mean_flights_per_Month","Prumerne letu za mesic");
define("_Mean_distance_per_Month","Prumerna vzdalenost za mesic");
define("_Mean_duration_per_Month","Prumerne trvani letu za mesic");
define("_Mean_duration_per_flight","Prumerne trvani letu");
define("_Mean_flights_per_Year","Prumerne letu za rok");
define("_Mean_distance_per_Year","Prumerna vzdalenost za rok");
define("_Mean_duration_per_Year","Prumerne trvani letu za rok");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","Prohledni lety blizko tohoto mista");
define("_Waypoint_Name","Waypoint-jmeno");
define("_Navigate_with_Google_Earth","Naviguj s Google Earth");
define("_See_it_in_Google_Maps","Prohledni v Google Maps");
define("_See_it_in_MapQuest","Prohledni v MapQuest");
define("_COORDINATES","Souradnice");
define("_FLIGHTS","Lety");
define("_SITE_RECORD","Mistni rekord");
define("_SITE_INFO","Mistni informace");
define("_SITE_REGION","Region");
define("_SITE_LINK","Odkaz na vice informaci");
define("_SITE_DESCR","Mistni udaje o startovacce");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","Prohledni vice detajlu");
define("_KML_file_made_by","KML soubor vytvoren ( kym )");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","Zaregistruj startovacku");
define("_WAYPOINT_ADDED","Startovacka byla zaregistrovana");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","Mistni rekord<br>(otevrena vzdalenost)");
	
//--------------------------------------------
// typy kluzaku
//--------------------------------------------
define("_GLIDER_TYPE","Typ Kluzaku");
function setGliderCats() {
	global  $gliderCatList;
	$gliderCatList=array(1=>'Padakovy kluzak',2=>'Rogalo flex',4=>'Rogalo rigid',8=>'Kluzak');
}
setGliderCats();

//--------------------------------------------
// user prefs  & units
//--------------------------------------------

define("_Your_settings_have_been_updated","Tvoje nastaveni byla upravena");

define("_THEME","tema");
define("_LANGUAGE","jazyk");
define("_VIEW_CATEGORY","prohledni kategorii");
define("_VIEW_COUNTRY","prohledni zemi");
define("_UNITS_SYSTEM" ,"jednotky mereni");
define("_METRIC_SYSTEM","Metricke (km,m)");
define("_IMPERIAL_SYSTEM","Imperialni (mile,stopy)");
define("_ITEMS_PER_PAGE","udaju na strance");

define("_MI","mile");
define("_KM","km");
define("_FT","stopy");
define("_M","m");
define("_MPH","m/h");
define("_KM_PER_HR","km/h");
define("_FPM","s/m");
define("_M_PER_SEC","m/s");

//--------------------------------------------
// index page
//--------------------------------------------

define("_WORLD_WIDE","Celosvetove");
define("_National_XC_Leagues_for","Narodni XC Ligy pro");
define("_Flights_per_Country","Letu za stat");
define("_Takeoffs_per_Country","Vzletu za stat");
define("_INDEX_HEADER","Vitej v Leonardo XC Lize");
define("_INDEX_MESSAGE","Muzes pouzit 'Hlavni Menu'k orientaci, nebo pouzit nejpouzivanejsi udaje dole.");

//--------------------------------------------
// NEW 
//--------------------------------------------
define("_MENU_SUMMARY_PAGE","Prvni strana ( ve strucnosti )");
define("_Display_ALL","Zobraz VSECHNO");
define("_Display_NONE","Nezobrazuj ZADNE");
define("_Reset_to_default_view","Nastav znovu do puvodni podoby");
define("_No_Club","Zadny klub");
define("_This_is_the_URL_of_this_page","Toto je URL teto stranky");
define("_All_glider_types","VSECHNY typy kluzaku");

define("_MENU_SITES_GUIDE","Prehled mist na letani");
define("Site_Guide","Mistni pruvodce");

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
define("_Site_Guide","Site Guide"); 
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
define("_informed_user_not_found","The informed user was not found in our database"); 
define("_impossible_to_gen_new_pass","<p align='justify'>We are sorry to inform you that is not possible gen a new password for you at this time, there is already a request that will expire in <b>%s</b>. Only after the expiration time you can do a new request.</p><p align='justify'>If you do not have access to the email contact the server admin</p>"); 
define("_Password_subject_confirm","Confirmation email (new password)"); 
define("_request_key_not_found","the request key that you have informed was not found!"); 
define("_request_key_invalid","request key that you have informed is invalid!"); 
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
define("_MANDATORY_GENDER","Please inform your Sex"); 
define("_MANDATORY_BIRTH_DATE_INVALID","Birth Date Invalid"); 
define("_MANDATORY_CIVL_ID","Please Inform your CIVLID"); 
define("_Attention_mandatory_to_have_civlid","ATENTION!! For now one is Mandatory to have CIVLID in the %s database"); 
define("_Email_confirm_success","Your registration was successfully confirmed!"); 
define("_Success_login_civl_or_user","Success, now you can do your login using your CIVLID as username, or continue with your old username"); 
define("_Server_did_not_found_registration","Registration not founded, please copy and paste in your browser address field the link informed in the email that was sended to you, of maybee your registration time are expired"); 
define("_Pilot_already_registered","Pilot already registered with CIVLID %s and with name %s"); 
define("_User_already_registered","User already registered with this email or name"); 
define("_Pilot_civlid_email_pre_registration","Hi %s This Civl ID and email is already used in a pre-registration"); 
define("_Pilot_have_pre_registration"," You already have a pre registration, but have not answered our mail, we resend the confirmation email for you, you have 3 hours after now to answer the email, if not you will be removed from pre registration. please read the email and follow the procedures described inside, thank you"); 
define("_Pre_registration_founded","We already have a pre-registration with this civlID and Email,wait for finishing the period of 3 hours until then this registration will be removed, in no hipotisis confirm the email that was sended for you, because will be generated an double registration, and your old flights will not be transfered for the new user"); 
define("_Civlid_already_in_use","This CIVLID is used for another pilot, we can not have double CIVLID!"); 
define("_Pilot_email_used_in_reg_dif_civlid","Hi %s This Email is used in another register with different CIVLID"); 
define("_Pilot_civlid_used_in_reg_dif_email","Hi %s This CIVLID is used in another register with different EMAIL"); 
define("_Pilot_email_used_in_pre_reg_dif_civlid","Hi %s This Email is used in another pre-register with different CIVLID"); 
define("_Pilot_civlid_used_in_pre_reg_dif_email","Hi %s This CIVLID is used in another pre-register with different EMAIL"); 
define("_Server_send_conf_email","The server have sended to the %s an email asking for confirmation, you have 3 hours from now to confirm your registration by clicking or copying and pasting the link that are in the email body in your browser addres"); 
define("_MENU_AREA_GUIDE","Area Guide"); 
define("_All_XC_types","_All XC types"); 
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

?>
<? if (0){?><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2"></head><? }?><?php

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
define("_Sync_Start_Times","Synchr. časy startů");

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
// pilot_�lc_profile_edit.php
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


?>

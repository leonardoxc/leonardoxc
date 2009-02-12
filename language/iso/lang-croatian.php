<? if (0){?><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1250"></head><? }?><?php

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
	$monthList=array('Siječanj','Veljača','Ožujak','Travanj','Svibanj','Lipanj',
					'Srpanj','Kolovoz','Rujan','Listopad','Studeni','Prosinac');
	$monthListShort=array('JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC');
	$weekdaysList=array('Mon','Tue','Wed','Thu','Fri','Sat','Sun') ;
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","Slobodni prelet");
define("_FREE_TRIANGLE","Jednostavan trokut");
define("_FAI_TRIANGLE","FAI trokut");

define("_SUBMIT_FLIGHT_ERROR","Došlo je do greške pri predaji leta");

// list_pilots()
define("_NUM","#");
define("_PILOT","Pilot");
define("_NUMBER_OF_FLIGHTS","Broj letova");
define("_BEST_DISTANCE","Najveća razdaljina");
define("_MEAN_KM","Prosječni broj km po letu");
define("_TOTAL_KM","Ukupno km");
define("_TOTAL_DURATION_OF_FLIGHTS","Ukupno sati");
define("_MEAN_DURATION","Prosječno vrijeme trajanja leta");
define("_TOTAL_OLC_KM","Ukupno OLC km");
define("_TOTAL_OLC_SCORE","Ukupno OLC bodova");
define("_BEST_OLC_SCORE","Najbolji OLC let");
define("_From","od");

// list_flights()
define("_DURATION_HOURS_MIN","Trajanje (h:m)");
define("_SHOW","Prikaži");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","Let će biti aktiviran za 1-2 minute. ");
define("_TRY_AGAIN","Molim vas pokušajte ponovno kasnije");

define("_TAKEOFF_LOCATION","Poletište");
define("_TAKEOFF_TIME","Vrijeme polijetanja");
define("_LANDING_LOCATION","Sletište");
define("_LANDING_TIME","Vrijeme slijetanja");
define("_OPEN_DISTANCE","Linearna razdaljina");
define("_MAX_DISTANCE","Najveća razdaljina");
define("_OLC_SCORE_TYPE","OLC tip bodovanja");
define("_OLC_DISTANCE","OLC razdaljina");
define("_OLC_SCORING","OLC bodovi");
define("_MAX_SPEED","Najveća brzina");
define("_MAX_VARIO","Najveće dizanje");
define("_MEAN_SPEED","Prosječna brzina");
define("_MIN_VARIO","Najveće propadanje");
define("_MAX_ALTITUDE","Najveća visina (nm)");
define("_TAKEOFF_ALTITUDE","Visina poletišta (nm)");
define("_MIN_ALTITUDE","Najmanja visina (nm)");
define("_ALTITUDE_GAIN","Dobivena visina");
define("_FLIGHT_FILE","Datoteka leta");
define("_COMMENTS","Komentari");
define("_RELEVANT_PAGE","Relevantna web stranica");
define("_GLIDER","Krilo");
define("_PHOTOS","Slike");
define("_MORE_INFO","Dodatne informacije");
define("_UPDATE_DATA","Osvježi podatke");
define("_UPDATE_MAP","Osvježi mapu");
define("_UPDATE_3D_MAP","Osvježi 3D mapu");
define("_UPDATE_GRAPHS","Osvježi grafikone");
define("_UPDATE_SCORE","Osvježi bodove");

define("_TAKEOFF_COORDS","Koordinate poletišta:");
define("_NO_KNOWN_LOCATIONS","Nema poznatih lokacija!");
define("_FLYING_AREA_INFO","Informacije o letačkom području");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo XC");
define("_RETURN_TO_TOP","Povratak na vrh");
// list flight
define("_PILOT_FLIGHTS","Letovi pilota");

define("_DATE_SORT","Datum");
define("_PILOT_NAME","Ime pilota");
define("_TAKEOFF","Poletište");
define("_DURATION","Trajanje");
define("_LINEAR_DISTANCE","Linearna razdaljina");
define("_OLC_KM","OLC km");
define("_OLC_SCORE","OLC bodovi");
define("_DATE_ADDED","Zadnje dodano");

define("_SORTED_BY","Sortiraj po:");
define("_ALL_YEARS","Sve godine");
define("_SELECT_YEAR_MONTH","Odaberi godinu (i mjesec)");
define("_ALL","Sve");
define("_ALL_PILOTS","Svi piloti");
define("_ALL_TAKEOFFS","Sva poletišta");
define("_ALL_THE_YEAR","Sve godine");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","Niste predali datoteku leta");
define("_NO_SUCH_FILE","Datoteka koju ste predali ne može biti pronađena na serveru");
define("_FILE_DOESNT_END_IN_IGC","Datoteka nema .igc nastavak");
define("_THIS_ISNT_A_VALID_IGC_FILE","Datoteka nije u .igc formatu");
define("_THERE_IS_SAME_DATE_FLIGHT","Već postoji let s istim datumom i vremenom");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","Ako ga želite zamijeniti, najprije trebate");
define("_DELETE_THE_OLD_ONE","obrisati stari.");
define("_THERE_IS_SAME_FILENAME_FLIGHT","Već postoji datoteka s istim imenom");
define("_CHANGE_THE_FILENAME","Ako se radi o drugom letu promijenite ime datoteke i pokušajte ponovno");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","Vaš let je prihvaćen");
define("_PRESS_HERE_TO_VIEW_IT","Kliknite ovdje za prikaz leta");
define("_WILL_BE_ACTIVATED_SOON","(bit će aktiviran za 1-2 minute)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Predaja više letova");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","Samo IGC datoteke će biti obrađene");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","ZIP datoteka<br>koja sadrži letove");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","Kliknite ovdje za predaju letova");

define("_FILE_DOESNT_END_IN_ZIP","Datoteka koju ste predali nema .zip nastavak");
define("_ADDING_FILE","Predaja datoteke");
define("_ADDED_SUCESSFULLY","Uspješno zaprimljeno");
define("_PROBLEM","Problem");
define("_TOTAL","Ukupno ");
define("_IGC_FILES_PROCESSED","letova je bilo obrađeno");
define("_IGC_FILES_SUBMITED","letova je bilo predano");

// info
define("_DEVELOPMENT","Razvoj");
define("_ANDREADAKIS_MANOLIS","Andreadakis Manolis");
define("_PROJECT_URL","URL projekta");
define("_VERSION","Verzija");
define("_MAP_CREATION","Kreiranje mapa");
define("_PROJECT_INFO","Info o projektu");

// menu bar 
define("_MENU_MAIN_MENU","Glavni izbornik");
define("_MENU_DATE","Odaberi datum");
define("_MENU_COUNTRY","Odaberi državu");
define("_MENU_XCLEAGUE","XC liga");
define("_MENU_ADMIN","Administracija");

define("_MENU_COMPETITION_LEAGUE","Liga - sve kategorije");
define("_MENU_OLC","OLC");
define("_MENU_OPEN_DISTANCE","Slobodan prelet");
define("_MENU_DURATION","Trajanje");
define("_MENU_ALL_FLIGHTS","Prikaži sve letove");
define("_MENU_FLIGHTS","Letovi");
define("_MENU_TAKEOFFS","Poletišta");
define("_MENU_FILTER","Filter");
define("_MENU_MY_FLIGHTS","Moji letovi");
define("_MENU_MY_PROFILE","Moj profil");
define("_MENU_MY_STATS","Moja statistika"); 
define("_MENU_MY_SETTINGS","Moje postavke"); 
define("_MENU_SUBMIT_FLIGHT","Predaja leta");
define("_MENU_SUBMIT_FROM_ZIP","Predaja više letova (zip)");
define("_MENU_SHOW_PILOTS","Piloti");
define("_MENU_SHOW_LAST_ADDED","Prikaz zadnje dodanih letova");
define("_FLIGHTS_STATS","Statistika letova");

define("_SELECT_YEAR","Odaberi godinu");
define("_SELECT_MONTH","Odaberi mjesec");
define("_ALL_COUNTRIES","Sve države");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","SVI LETOVI");
define("_NUMBER_OF_FLIGHTS","Broj letova");
define("_TOTAL_DISTANCE","Ukupna razdaljina");
define("_TOTAL_DURATION","Ukupno trajanje");
define("_BEST_OPEN_DISTANCE","Najbolji slobodni prelet");
define("_TOTAL_OLC_DISTANCE","Ukupna OLC razdaljina");
define("_TOTAL_OLC_SCORE","Ukupno OLC bodova");
define("_BEST_OLC_SCORE","Najbolji OLC let");
define("_MEAN_DURATION","Prosječno trajanje");
define("_MEAN_DISTANCE","Prosječna razdaljina");
define("_PILOT_STATISTICS_SORT_BY","Piloti - Sortiraj po");
define("_CATEGORY_FLIGHT_NUMBER","Kategorija 'FastJoe' - Broj letova");
define("_CATEGORY_TOTAL_DURATION","Kategorija 'DURACELL' - Ukupno trajanje");
define("_CATEGORY_OPEN_DISTANCE","Kategorija 'Slobodni prelet'");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","Nema pilota!");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","Let je obrisan");
define("_RETURN","Povratak");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","UPOZORENJE - Let će biti obrisan");
define("_THE_DATE","Datum ");
define("_YES","DA");
define("_NO","NE");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","Rezultati lige");
define("_N_BEST_FLIGHTS"," najboljih letova");
define("_OLC","OLC");
define("_OLC_TOTAL_SCORE","OLC ukupno bodova");
define("_KILOMETERS","Kilometara");
define("_TOTAL_ALTITUDE_GAIN","Ukupan dobitak na visini");
define("_TOTAL_KM","Ukupno km");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","je");
define("_IS_NOT","nije");
define("_OR","ili");
define("_AND","i");
define("_FILTER_PAGE_TITLE","Filtriranje letova");
define("_RETURN_TO_FLIGHTS","Povratak na letove");
define("_THE_FILTER_IS_ACTIVE","Filter je aktivan");
define("_THE_FILTER_IS_INACTIVE","Filter nije aktivan");
define("_SELECT_DATE","Odaberi datum");
define("_SHOW_FLIGHTS","Prikaži letove");
define("_ALL2","SVE");
define("_WITH_YEAR","S godinom");
define("_MONTH","Mjesec");
define("_YEAR","Godina");
define("_FROM","Od");
define("_from","od");
define("_TO","Do");
define("_SELECT_PILOT","Odaberi pilota");
define("_THE_PILOT","Pilot");
define("_THE_TAKEOFF","Poletište");
define("_SELECT_TAKEOFF","Odaberi poletište");
define("_THE_COUNTRY","Država");
define("_COUNTRY","Država");
define("_SELECT_COUNTRY","Odaberi državu");
define("_OTHER_FILTERS","Drugi filtri");
define("_LINEAR_DISTANCE_SHOULD_BE","Slobodan prelet treba biti");
define("_OLC_DISTANCE_SHOULD_BE","OLC razdaljina treba biti");
define("_OLC_SCORE_SHOULD_BE","OLC bodovi trebaju biti");
define("_DURATION_SHOULD_BE","Trajanje treba biti");
define("_ACTIVATE_CHANGE_FILTER","Aktiviraj / promijeni FILTER");
define("_DEACTIVATE_FILTER","Deaktiviraj FILTER");
define("_HOURS","sati");
define("_MINUTES","minute");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","Predaja leta");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(potrebna je samo IGC datoteka)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","Predaj<br>IGC datoteku leta");
define("_NOTE_TAKEOFF_NAME","Molimo naznačite ime poletišta i državu");
define("_COMMENTS_FOR_THE_FLIGHT","Komentari uz let");
define("_PHOTO","Slika");
define("_PHOTOS_GUIDELINES","Slike trebaju biti u jpg formatu i manje od ");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","Klikni ovdje za predaju leta");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","Želiš li predati više letova odjednom u ZIP datoteci?");
define("_PRESS_HERE","Klikni ovdje");

define("_IS_PRIVATE","Ne pokazivati svima");
define("_MAKE_THIS_FLIGHT_PRIVATE","Označi let privatnim");
define("_INSERT_FLIGHT_AS_USER_ID","Ubaci let kao korisnik s ID-jem");
define("_FLIGHT_IS_PRIVATE","Ovaj let je privatan");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","Promijeni podatke o letu");
define("_IGC_FILE_OF_THE_FLIGHT","IGC datoteka leta");
define("_DELETE_PHOTO","Obriši");
define("_NEW_PHOTO","nova slika");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","Klikni ovdje za promjenu podataka o letu");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","Promjene su spremljene");
define("_RETURN_TO_FLIGHT","Povratak na let");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","Povratak na let");
define("_READY_FOR_SUBMISSION","Spremno za predaju");
define("_OLC_MAP","Mapa");
define("_OLC_BARO","Barograf");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","Profil pilota");
define("_back_to_flights","natrag na letove");
define("_pilot_stats","statistika pilota");
define("_edit_profile","izmijeni profil");
define("_flights_stats","statistika letova");
define("_View_Profile","Pogledaj profil");

define("_Personal_Stuff","Osobne stvari");
define("_First_Name"," Ime");
define("_Last_Name","Prezime");
define("_Birthdate","Datum rođenja");
define("_dd_mm_yy","dd.mm.yy");
define("_Sign","Znak");
define("_Marital_Status","Bračni status");
define("_Occupation","Zanimanje");
define("_Web_Page","Web stranica");
define("_N_A","N/A");
define("_Other_Interests","Drugi interesi");
define("_Photo","Slika");

define("_Flying_Stuff","Letačke stvari");
define("_note_place_and_date","ako je primjenjivo naznači mjesto/državu i datum");
define("_Flying_Since","Letim od");
define("_Pilot_Licence","Pilotska dozvola");
define("_Paragliding_training","Paragliding obuka");
define("_Favorite_Location","Omiljene lokacije");
define("_Usual_Location","Uobičajene lokacije");
define("_Best_Flying_Memory","Najbolja letačka uspomena");
define("_Worst_Flying_Memory","Najgora letačka uspomena");
define("_Personal_Distance_Record","Najdulji prelet");
define("_Personal_Height_Record","Najveća visina");
define("_Hours_Flown","Broj sati u zraku");
define("_Hours_Per_Year","Sati na godinu");

define("_Equipment_Stuff","Oprema");
define("_Glider","Krilo");
define("_Harness","Sjedalo");
define("_Reserve_chute","Rezerva");
define("_Camera","Fotoaparat");
define("_Vario","Vario");
define("_GPS","GPS");
define("_Helmet","Kaciga");
define("_Camcorder","Video kamera");

define("_Manouveur_Stuff","Manevri");
define("_note_max_descent_rate","ako je primjenjivo naznačite maksimalnu brzinu propadanja");
define("_Spiral","Spirala");
define("_Bline","B-stall");
define("_Full_Stall","Full Stall");
define("_Other_Manouveurs_Acro","Drugi akro manevri");
define("_Sat","Sat");
define("_Asymmetric_Spiral","Asimetrična spirala");
define("_Spin","Negativa");

define("_General_Stuff","Opće stvari");
define("_Favorite_Singer","Omiljeni pjevač/grupa");
define("_Favorite_Movie","Omiljeni filmovi");
define("_Favorite_Internet_Site","Omiljene<br>web-stranice");
define("_Favorite_Book","Omiljene knjige");
define("_Favorite_Actor","Omiljeni glumci/glumice");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","Predaj novu sliku ili promijeni staru");
define("_Delete_Photo","Obriši sliku");
define("_Your_profile_has_been_updated","Vaš profil je promijenjen");
define("_Submit_Change_Data","Prihvati promjene");

//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","hh:mm");

define("_Totals","Totali");
define("_First_flight_logged","Prvi zabilježeni let");
define("_Last_flight_logged","Zadnji zabilježeni let");
define("_Flying_period_covered","Pokriveno razdoblje");
define("_Total_Distance","Ukupna razdaljina");
define("_Total_OLC_Score","Ukupno OLC bodova");
define("_Total_Hours_Flown","Ukupno sati leta");
define("_Total_num_of_flights","Ukupan broj letova ");

define("_Personal_Bests","Najbolji osobni rezultati");
define("_Best_Open_Distance","Najbolji slobodni prelet");
define("_Best_FAI_Triangle","Najbolji FAI trokut");
define("_Best_Free_Triangle","Najbolji trokut");
define("_Longest_Flight","Najdulji let");
define("_Best_OLC_score","Najbolji OLC rezultat");

define("_Absolute_Height_Record","Apsolutni visinski rekord");
define("_Altitute_gain_Record","Rekord dobivene visine");
define("_Mean_values","Prosječne vrijednosti");
define("_Mean_distance_per_flight","Prosječna razdaljina po letu");
define("_Mean_flights_per_Month","Prosječni broj letova po mjesecu");
define("_Mean_distance_per_Month","Prosječna razdaljina po mjesecu");
define("_Mean_duration_per_Month","Prosječno trajanje po mjesecu");
define("_Mean_duration_per_flight","Prosječno trajanje po letu");
define("_Mean_flights_per_Year","Prosječni broj letova po godini");
define("_Mean_distance_per_Year","Prosječna razdaljina po godini");
define("_Mean_duration_per_Year","Prosječno trajanje po godini");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","Pogledaj letove u blizini ove točke");
define("_Waypoint_Name","Ime točke");
define("_Navigate_with_Google_Earth","Google Earth");
define("_See_it_in_Google_Maps","Google Maps");
define("_See_it_in_MapQuest","MapQuest");
define("_COORDINATES","Koordinate");
define("_FLIGHTS","Letovi");
define("_SITE_RECORD","Rekord poletišta");
define("_SITE_INFO","Informacije o poletištu");
define("_SITE_REGION","Područje");
define("_SITE_LINK","Link za više informacija");
define("_SITE_DESCR","Opis poletišta");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","Više Detalja");
define("_KML_file_made_by","KML datoteku napravio");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","Zabilježi poletište");
define("_WAYPOINT_ADDED","Poletište je zabilježeno");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","Rekord poletišta<br>(slobodni prelet)");
	
//-------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","Tip letjelice");
function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'Paraglider',2=>'Flex wing FAI1',4=>'Rigid wing FAI5',8=>'Glider');
	foreach ($CONF_glider_types as $gId=>$gName) if (!$gliderCatList[$gId]) $gliderCatList[$gId]=$gName;
}
setGliderCats();

//--------------------------------------------
// user prefs  & units
//--------------------------------------------

define("_Your_settings_have_been_updated","Vaše postavke su promijenjene");

define("_THEME","Tema");
define("_LANGUAGE","Jezik");
define("_VIEW_CATEGORY","Pregledaj kategorije");
define("_VIEW_COUNTRY","Pregledaj države");
define("_UNITS_SYSTEM" ,"Mjerni sustav");
define("_METRIC_SYSTEM","Metrički (km,m)");
define("_IMPERIAL_SYSTEM","Imperial (miles,feet)");
define("_ITEMS_PER_PAGE","Podataka po stranici");

define("_MI","mi");
define("_KM","km");
define("_FT","ft");
define("_M","m");
define("_MPH","mph");
define("_KM_PER_HR","km/h");
define("_FPM","fpm");
define("_M_PER_SEC","m/s");

//--------------------------------------------
// index page
//--------------------------------------------

define("_WORLD_WIDE","Cijeli svijet");
define("_National_XC_Leagues_for","Nacionalna XC liga za");
define("_Flights_per_Country","Letova po državi");
define("_Takeoffs_per_Country","Poletišta po državi");
define("_INDEX_HEADER","Dobrodošli u Leonardo XC ligu");
define("_INDEX_MESSAGE","Koristite &quot;Glavni izbornik&quot; za navigaciju ili koristite najčešće opcije prikazane ispod.");

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
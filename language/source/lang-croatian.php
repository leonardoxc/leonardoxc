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
	$monthList=array('Sije�anj','Velja�a','O�ujak','Travanj','Svibanj','Lipanj',
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

define("_SUBMIT_FLIGHT_ERROR","Do�lo je do gre�ke pri predaji leta");

// list_pilots()
define("_NUM","#");
define("_PILOT","Pilot");
define("_NUMBER_OF_FLIGHTS","Broj letova");
define("_BEST_DISTANCE","Najve�a razdaljina");
define("_MEAN_KM","Prosje�ni broj km po letu");
define("_TOTAL_KM","Ukupno km");
define("_TOTAL_DURATION_OF_FLIGHTS","Ukupno sati");
define("_MEAN_DURATION","Prosje�no vrijeme trajanja leta");
define("_TOTAL_OLC_KM","Ukupno OLC km");
define("_TOTAL_OLC_SCORE","Ukupno OLC bodova");
define("_BEST_OLC_SCORE","Najbolji OLC let");
define("_From","od");

// list_flights()
define("_DURATION_HOURS_MIN","Trajanje (h:m)");
define("_SHOW","Prika�i");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","Let �e biti aktiviran za 1-2 minute. ");
define("_TRY_AGAIN","Molim vas poku�ajte ponovno kasnije");

define("_TAKEOFF_LOCATION","Poleti�te");
define("_TAKEOFF_TIME","Vrijeme polijetanja");
define("_LANDING_LOCATION","Sleti�te");
define("_LANDING_TIME","Vrijeme slijetanja");
define("_OPEN_DISTANCE","Linearna razdaljina");
define("_MAX_DISTANCE","Najve�a razdaljina");
define("_OLC_SCORE_TYPE","OLC tip bodovanja");
define("_OLC_DISTANCE","OLC razdaljina");
define("_OLC_SCORING","OLC bodovi");
define("_MAX_SPEED","Najve�a brzina");
define("_MAX_VARIO","Najve�e dizanje");
define("_MEAN_SPEED","Prosje�na brzina");
define("_MIN_VARIO","Najve�e propadanje");
define("_MAX_ALTITUDE","Najve�a visina (nm)");
define("_TAKEOFF_ALTITUDE","Visina poleti�ta (nm)");
define("_MIN_ALTITUDE","Najmanja visina (nm)");
define("_ALTITUDE_GAIN","Dobivena visina");
define("_FLIGHT_FILE","Datoteka leta");
define("_COMMENTS","Komentari");
define("_RELEVANT_PAGE","Relevantna web stranica");
define("_GLIDER","Krilo");
define("_PHOTOS","Slike");
define("_MORE_INFO","Dodatne informacije");
define("_UPDATE_DATA","Osvje�i podatke");
define("_UPDATE_MAP","Osvje�i mapu");
define("_UPDATE_3D_MAP","Osvje�i 3D mapu");
define("_UPDATE_GRAPHS","Osvje�i grafikone");
define("_UPDATE_SCORE","Osvje�i bodove");

define("_TAKEOFF_COORDS","Koordinate poleti�ta:");
define("_NO_KNOWN_LOCATIONS","Nema poznatih lokacija!");
define("_FLYING_AREA_INFO","Informacije o leta�kom podru�ju");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo XC");
define("_RETURN_TO_TOP","Povratak na vrh");
// list flight
define("_PILOT_FLIGHTS","Letovi pilota");

define("_DATE_SORT","Datum");
define("_PILOT_NAME","Ime pilota");
define("_TAKEOFF","Poleti�te");
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
define("_ALL_TAKEOFFS","Sva poleti�ta");
define("_ALL_THE_YEAR","Sve godine");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","Niste predali datoteku leta");
define("_NO_SUCH_FILE","Datoteka koju ste predali ne mo�e biti prona�ena na serveru");
define("_FILE_DOESNT_END_IN_IGC","Datoteka nema .igc nastavak");
define("_THIS_ISNT_A_VALID_IGC_FILE","Datoteka nije u .igc formatu");
define("_THERE_IS_SAME_DATE_FLIGHT","Ve� postoji let s istim datumom i vremenom");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","Ako ga �elite zamijeniti, najprije trebate");
define("_DELETE_THE_OLD_ONE","obrisati stari.");
define("_THERE_IS_SAME_FILENAME_FLIGHT","Ve� postoji datoteka s istim imenom");
define("_CHANGE_THE_FILENAME","Ako se radi o drugom letu promijenite ime datoteke i poku�ajte ponovno");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","Va� let je prihva�en");
define("_PRESS_HERE_TO_VIEW_IT","Kliknite ovdje za prikaz leta");
define("_WILL_BE_ACTIVATED_SOON","(bit �e aktiviran za 1-2 minute)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Predaja vi�e letova");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","Samo IGC datoteke �e biti obra�ene");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","ZIP datoteka<br>koja sadr�i letove");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","Kliknite ovdje za predaju letova");

define("_FILE_DOESNT_END_IN_ZIP","Datoteka koju ste predali nema .zip nastavak");
define("_ADDING_FILE","Predaja datoteke");
define("_ADDED_SUCESSFULLY","Uspje�no zaprimljeno");
define("_PROBLEM","Problem");
define("_TOTAL","Ukupno ");
define("_IGC_FILES_PROCESSED","letova je bilo obra�eno");
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
define("_MENU_COUNTRY","Odaberi dr�avu");
define("_MENU_XCLEAGUE","XC liga");
define("_MENU_ADMIN","Administracija");

define("_MENU_COMPETITION_LEAGUE","Liga - sve kategorije");
define("_MENU_OLC","OLC");
define("_MENU_OPEN_DISTANCE","Slobodan prelet");
define("_MENU_DURATION","Trajanje");
define("_MENU_ALL_FLIGHTS","Prika�i sve letove");
define("_MENU_FLIGHTS","Letovi");
define("_MENU_TAKEOFFS","Poleti�ta");
define("_MENU_FILTER","Filter");
define("_MENU_MY_FLIGHTS","Moji letovi");
define("_MENU_MY_PROFILE","Moj profil");
define("_MENU_MY_STATS","Moja statistika"); 
define("_MENU_MY_SETTINGS","Moje postavke"); 
define("_MENU_SUBMIT_FLIGHT","Predaja leta");
define("_MENU_SUBMIT_FROM_ZIP","Predaja vi�e letova (zip)");
define("_MENU_SHOW_PILOTS","Piloti");
define("_MENU_SHOW_LAST_ADDED","Prikaz zadnje dodanih letova");
define("_FLIGHTS_STATS","Statistika letova");

define("_SELECT_YEAR","Odaberi godinu");
define("_SELECT_MONTH","Odaberi mjesec");
define("_ALL_COUNTRIES","Sve dr�ave");
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
define("_MEAN_DURATION","Prosje�no trajanje");
define("_MEAN_DISTANCE","Prosje�na razdaljina");
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
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","UPOZORENJE - Let �e biti obrisan");
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
define("_SHOW_FLIGHTS","Prika�i letove");
define("_ALL2","SVE");
define("_WITH_YEAR","S godinom");
define("_MONTH","Mjesec");
define("_YEAR","Godina");
define("_FROM","Od");
define("_from","od");
define("_TO","Do");
define("_SELECT_PILOT","Odaberi pilota");
define("_THE_PILOT","Pilot");
define("_THE_TAKEOFF","Poleti�te");
define("_SELECT_TAKEOFF","Odaberi poleti�te");
define("_THE_COUNTRY","Dr�ava");
define("_COUNTRY","Dr�ava");
define("_SELECT_COUNTRY","Odaberi dr�avu");
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
define("_NOTE_TAKEOFF_NAME","Molimo nazna�ite ime poleti�ta i dr�avu");
define("_COMMENTS_FOR_THE_FLIGHT","Komentari uz let");
define("_PHOTO","Slika");
define("_PHOTOS_GUIDELINES","Slike trebaju biti u jpg formatu i manje od ");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","Klikni ovdje za predaju leta");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","�eli� li predati vi�e letova odjednom u ZIP datoteci?");
define("_PRESS_HERE","Klikni ovdje");

define("_IS_PRIVATE","Ne pokazivati svima");
define("_MAKE_THIS_FLIGHT_PRIVATE","Ozna�i let privatnim");
define("_INSERT_FLIGHT_AS_USER_ID","Ubaci let kao korisnik s ID-jem");
define("_FLIGHT_IS_PRIVATE","Ovaj let je privatan");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","Promijeni podatke o letu");
define("_IGC_FILE_OF_THE_FLIGHT","IGC datoteka leta");
define("_DELETE_PHOTO","Obri�i");
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
define("_Birthdate","Datum ro�enja");
define("_dd_mm_yy","dd.mm.yy");
define("_Sign","Znak");
define("_Marital_Status","Bra�ni status");
define("_Occupation","Zanimanje");
define("_Web_Page","Web stranica");
define("_N_A","N/A");
define("_Other_Interests","Drugi interesi");
define("_Photo","Slika");

define("_Flying_Stuff","Leta�ke stvari");
define("_note_place_and_date","ako je primjenjivo nazna�i mjesto/dr�avu i datum");
define("_Flying_Since","Letim od");
define("_Pilot_Licence","Pilotska dozvola");
define("_Paragliding_training","Paragliding obuka");
define("_Favorite_Location","Omiljene lokacije");
define("_Usual_Location","Uobi�ajene lokacije");
define("_Best_Flying_Memory","Najbolja leta�ka uspomena");
define("_Worst_Flying_Memory","Najgora leta�ka uspomena");
define("_Personal_Distance_Record","Najdulji prelet");
define("_Personal_Height_Record","Najve�a visina");
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
define("_note_max_descent_rate","ako je primjenjivo nazna�ite maksimalnu brzinu propadanja");
define("_Spiral","Spirala");
define("_Bline","B-stall");
define("_Full_Stall","Full Stall");
define("_Other_Manouveurs_Acro","Drugi akro manevri");
define("_Sat","Sat");
define("_Asymmetric_Spiral","Asimetri�na spirala");
define("_Spin","Negativa");

define("_General_Stuff","Op�e stvari");
define("_Favorite_Singer","Omiljeni pjeva�/grupa");
define("_Favorite_Movie","Omiljeni filmovi");
define("_Favorite_Internet_Site","Omiljene<br>web-stranice");
define("_Favorite_Book","Omiljene knjige");
define("_Favorite_Actor","Omiljeni glumci/glumice");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","Predaj novu sliku ili promijeni staru");
define("_Delete_Photo","Obri�i sliku");
define("_Your_profile_has_been_updated","Va� profil je promijenjen");
define("_Submit_Change_Data","Prihvati promjene");

//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","hh:mm");

define("_Totals","Totali");
define("_First_flight_logged","Prvi zabilje�eni let");
define("_Last_flight_logged","Zadnji zabilje�eni let");
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
define("_Mean_values","Prosje�ne vrijednosti");
define("_Mean_distance_per_flight","Prosje�na razdaljina po letu");
define("_Mean_flights_per_Month","Prosje�ni broj letova po mjesecu");
define("_Mean_distance_per_Month","Prosje�na razdaljina po mjesecu");
define("_Mean_duration_per_Month","Prosje�no trajanje po mjesecu");
define("_Mean_duration_per_flight","Prosje�no trajanje po letu");
define("_Mean_flights_per_Year","Prosje�ni broj letova po godini");
define("_Mean_distance_per_Year","Prosje�na razdaljina po godini");
define("_Mean_duration_per_Year","Prosje�no trajanje po godini");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","Pogledaj letove u blizini ove to�ke");
define("_Waypoint_Name","Ime to�ke");
define("_Navigate_with_Google_Earth","Google Earth");
define("_See_it_in_Google_Maps","Google Maps");
define("_See_it_in_MapQuest","MapQuest");
define("_COORDINATES","Koordinate");
define("_FLIGHTS","Letovi");
define("_SITE_RECORD","Rekord poleti�ta");
define("_SITE_INFO","Informacije o poleti�tu");
define("_SITE_REGION","Podru�je");
define("_SITE_LINK","Link za vi�e informacija");
define("_SITE_DESCR","Opis poleti�ta");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","Vi�e Detalja");
define("_KML_file_made_by","KML datoteku napravio");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","Zabilje�i poleti�te");
define("_WAYPOINT_ADDED","Poleti�te je zabilje�eno");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","Rekord poleti�ta<br>(slobodni prelet)");
	
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

define("_Your_settings_have_been_updated","Va�e postavke su promijenjene");

define("_THEME","Tema");
define("_LANGUAGE","Jezik");
define("_VIEW_CATEGORY","Pregledaj kategorije");
define("_VIEW_COUNTRY","Pregledaj dr�ave");
define("_UNITS_SYSTEM" ,"Mjerni sustav");
define("_METRIC_SYSTEM","Metri�ki (km,m)");
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
define("_Flights_per_Country","Letova po dr�avi");
define("_Takeoffs_per_Country","Poleti�ta po dr�avi");
define("_INDEX_HEADER","Dobrodo�li u Leonardo XC ligu");
define("_INDEX_MESSAGE","Koristite &quot;Glavni izbornik&quot; za navigaciju ili koristite naj�e��e opcije prikazane ispod.");

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
?>
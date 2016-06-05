<? if (0){?><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2"></head><? }?><?php

/************************************************************************/
/* Leonardo: Gliding XC Server				                 */
/* ============================================                          */
/*                                                                       */
/* Copyright (c) 2004-5 by Andreadakis Manolis                           */
/* http://leonardo.thenet.gr                                             */
/*                                                                       */
/* Niniejszy program jest wolnym oprogramowaniem. Mo�esz go rozprowadza� */
/* dalej i/lub modyfikowa� na warunkach Powszechnej Licencji Publicznej  */
/* GNU, wydanej przez Fundacj� Wolnego Oprogramowania - wed�ug           */
/* 2 wersji tej licencji lub kt�rej� z p��niejszych                      */
/*                                                                       */
/* Pami�taj, �e aby u�y� cudzys�owu (") nale�y poprzedzi� go lewym       */
/* uko�nikiem, aby nasz zapis wygl�da� tak: To jest \"cytowany\" tekst.  */
/* Pami�taj tak�e, aby sprawdzi� poprawno�� kodu HTML.                   */
/*************************************************************************/

function setMonths() {
	global  $monthList,	$monthListShort, $weekdaysList;
	$monthList=array('Stycze�','Luty','Marzec','Kwiecie�','Maj','Czerwiec',
					'Lipiec','Sierpie�','Wrzesie�','Pa�dziernik','Listopad','Grudzie�');
	$monthListShort=array('JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC');
	$weekdaysList=array('Mon','Tue','Wed','Thu','Fri','Sat','Sun') ;
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","Przelot otwarty");
define("_FREE_TRIANGLE","Tr�jk�t");
define("_FAI_TRIANGLE","Tr�jk�t FAI");

define("_SUBMIT_FLIGHT_ERROR","Wyst�pi� b��d podczas przesy�ania pliku!");

// list_pilots()
define("_NUM","#");
define("_PILOT","Pilot");
define("_NUMBER_OF_FLIGHTS","Liczba lot�w");
define("_BEST_DISTANCE","Najlepszy przelot");
define("_MEAN_KM","�redni dystans");
define("_TOTAL_KM","Suma km");
define("_TOTAL_DURATION_OF_FLIGHTS","Ca�kowity czas lot�w");
define("_MEAN_DURATION","�redni czas lotu");
define("_TOTAL_OLC_KM","Ca�kowity dystans OLC");
define("_TOTAL_OLC_SCORE","Ca�kowita punktacja OLC");
define("_BEST_OLC_SCORE","Najlepszy wynik OLC");
define("_From","od");

// list_flights()
define("_DURATION_HOURS_MIN","Czas (gg:mm)");
define("_SHOW","Poka�");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","Lot zostanie wy�wietlony za 1-2 minuty. ");
define("_TRY_AGAIN","Spr�buj ponownie p��niej");

define("_TAKEOFF_LOCATION","Miejsce startu");
define("_TAKEOFF_TIME","Godzina startu");
define("_LANDING_LOCATION","Miejsce l�dowania");
define("_LANDING_TIME","Godzina l�dowania");
define("_OPEN_DISTANCE","Dystans po prostej");
define("_MAX_DISTANCE","Dystans max");
define("_OLC_SCORE_TYPE","Rodzaj punktacji OLC");
define("_OLC_DISTANCE","Dystans OLC");
define("_OLC_SCORING","Punkty OLC");
define("_MAX_SPEED","Pr�dko�� max");
define("_MAX_VARIO","Wznoszenie max");
define("_MEAN_SPEED","Pr�dko�� �rednia");
define("_MIN_VARIO","Opadanie max");
define("_MAX_ALTITUDE","Wysoko�� max (n.p.m)");
define("_TAKEOFF_ALTITUDE","Wysoko�� startu (n.p.m.)");
define("_MIN_ALTITUDE","Wysoko�� min (n.p.m.)");
define("_ALTITUDE_GAIN","Przewy�szenie");
define("_FLIGHT_FILE","Plik lotu");
define("_COMMENTS","Komentarz");
define("_RELEVANT_PAGE","Strona www");
define("_GLIDER","Skrzyd�o");
define("_PHOTOS","Zdj�cia");
define("_MORE_INFO","Dodatkowe informacje");
define("_UPDATE_DATA","Aktualizuj dane");
define("_UPDATE_MAP","Aktualizuj map�");
define("_UPDATE_3D_MAP","Aktualizuj map� 3D");
define("_UPDATE_GRAPHS","Aktualizuj wykresy");
define("_UPDATE_SCORE","Aktualizuj punktacj�");

define("_TAKEOFF_COORDS","Koordynaty startu:");
define("_NO_KNOWN_LOCATIONS","Miejsce nieznane!");
define("_FLYING_AREA_INFO","Informacja o miejscu");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo XC");
define("_RETURN_TO_TOP","Do g�ry");
// list flight
define("_PILOT_FLIGHTS","Wszystkie loty");

define("_DATE_SORT","Data");
define("_PILOT_NAME","Pilot");
define("_TAKEOFF","Start");
define("_DURATION","Czas");
define("_LINEAR_DISTANCE","Dystans po prostej");
define("_OLC_KM","Km OLC");
define("_OLC_SCORE","Punktacja OLC");
define("_DATE_ADDED","Ostatnio dodane");

define("_SORTED_BY","Sortuj wed�ug:");
define("_ALL_YEARS","Wszystkie lata");
define("_SELECT_YEAR_MONTH","Wybierz rok (i miesi�c)");
define("_ALL","Wszystkie");
define("_ALL_PILOTS","Poka� wszystkich pilot�w");
define("_ALL_TAKEOFFS","Poka� wszystkie miejsca startu");
define("_ALL_THE_YEAR","Ca�y rok");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","Brak pliku lotu");
define("_NO_SUCH_FILE","Pliku nie mo�na odnale�� na serwerze");
define("_FILE_DOESNT_END_IN_IGC","Plik nie ma rozszerzenia .igc");
define("_THIS_ISNT_A_VALID_IGC_FILE","Wys�any plik .igc jest nieprawid�owy lub uszkodzony");
define("_THERE_IS_SAME_DATE_FLIGHT","Istnieje ju� lot z tak� sam� dat� i godzin�");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","Je�li chcesz go wymieni�, powiniene� najpierw");
define("_DELETE_THE_OLD_ONE","usun�� stary");
define("_THERE_IS_SAME_FILENAME_FLIGHT","Istnieje ju� plik o takiej samej nazwie");
define("_CHANGE_THE_FILENAME","Je�li jest to inny lot, nale�y zmieni� nazw� pliku i spr�bowa� ponownie");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","Lot zosta� dodany");
define("_PRESS_HERE_TO_VIEW_IT","Kliknij tutaj, aby zobaczy� lot");
define("_WILL_BE_ACTIVATED_SOON","(powinien on zosta� wy�wietlony za ok. 1-2 minuty)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Dodaj kilka lot�w");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","Przetwarzane b�d� tylko pliki IGC");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","Dodaj plik<br>ZIP z lotami");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","Kliknij tutaj, aby doda� loty");

define("_FILE_DOESNT_END_IN_ZIP","Plik nie ma rozszerzenia .zip");
define("_ADDING_FILE","Przesy�anie pliku");
define("_ADDED_SUCESSFULLY","Plik zosta� przes�any");
define("_PROBLEM","B��d");
define("_TOTAL","W sumie ");
define("_IGC_FILES_PROCESSED","lot�w zosta�o przetworzonych");
define("_IGC_FILES_SUBMITED","lot�w zosta�o przes�anych");

// info
define("_DEVELOPMENT","Autor");
define("_ANDREADAKIS_MANOLIS","Andreadakis Manolis");
define("_PROJECT_URL","Strona projektu");
define("_VERSION","Wersja");
define("_MAP_CREATION","Wykonanie map");
define("_PROJECT_INFO","Informacja o projekcie");

// menu bar 
define("_MENU_MAIN_MENU","Menu g��wne");
define("_MENU_DATE","Wybierz dat�");
define("_MENU_COUNTRY","Wybierz kraj");
define("_MENU_XCLEAGUE","Liga XC");
define("_MENU_ADMIN","Admin");

define("_MENU_COMPETITION_LEAGUE","Liga - wszystkie kategorie");
define("_MENU_OLC","OLC");
define("_MENU_OPEN_DISTANCE","Dystans otwarty");
define("_MENU_DURATION","Czas");
define("_MENU_ALL_FLIGHTS","Poka� wszystkie loty");
define("_MENU_FLIGHTS","Loty");
define("_MENU_TAKEOFFS","Miejsca startu");
define("_MENU_FILTER","Filtr");
define("_MENU_MY_FLIGHTS","Moje loty");
define("_MENU_MY_PROFILE","M�j profil");
define("_MENU_MY_STATS","Moje statystyki"); 
define("_MENU_MY_SETTINGS","Moje ustawienia"); 
define("_MENU_SUBMIT_FLIGHT","Dodaj lot");
define("_MENU_SUBMIT_FROM_ZIP","Dodaj lot z pliku zip");
define("_MENU_SHOW_PILOTS","Piloci");
define("_MENU_SHOW_LAST_ADDED","Poka� ostatnio dodane");
define("_FLIGHTS_STATS","Statystyki lot�w");

define("_SELECT_YEAR","Wybierz rok");
define("_SELECT_MONTH","Wybierz miesi�c");
define("_ALL_COUNTRIES","Poka� wszystkie kraje");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","WSZYSTKIE");
define("_NUMBER_OF_FLIGHTS","Liczba lot�w");
define("_TOTAL_DISTANCE","Dystans ca�kowity");
define("_TOTAL_DURATION","Czas ca�kowity");
define("_BEST_OPEN_DISTANCE","Najlepsza odleg�o��");
define("_TOTAL_OLC_DISTANCE","Ca�kowity dystans OLC");
define("_TOTAL_OLC_SCORE","Ca�kowita punktacja OLC");
define("_BEST_OLC_SCORE","Najlepszy wynik OLC");
define("_MEAN_DURATION","Czas �redni");
define("_MEAN_DISTANCE","Dystans �redni");
define("_PILOT_STATISTICS_SORT_BY","Piloci - Sortuj wed�ug");
define("_CATEGORY_FLIGHT_NUMBER","Kategoria 'FastJoe' - Liczba lot�w");
define("_CATEGORY_TOTAL_DURATION","Kategoria 'DURACELL' - Ca�kowity czas trwania lot�w");
define("_CATEGORY_OPEN_DISTANCE","Kategoria 'Przelot otwarty'");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","Brak pilot�w spe�niaj�cych kategorie!");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","Lot zosta� usuni�ty");
define("_RETURN","Powr�t");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","UWAGA! - Lot zostanie usuni�ty");
define("_THE_DATE","Data ");
define("_YES","TAK");
define("_NO","NIE");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","Wyniki ligowe");
define("_N_BEST_FLIGHTS","Najlepsze loty");
define("_OLC","OLC");
define("_OLC_TOTAL_SCORE","Ca�kowita puntacja OLC");
define("_KILOMETERS","Kilometry");
define("_TOTAL_ALTITUDE_GAIN","Suma przewy�sze�");
define("_TOTAL_KM","Total km");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","jest");
define("_IS_NOT","nie jest");
define("_OR","lub");
define("_AND","i");
define("_FILTER_PAGE_TITLE","Filtruj loty");
define("_RETURN_TO_FLIGHTS","Powr�t do lot�w");
define("_THE_FILTER_IS_ACTIVE","Filtr jest aktywny");
define("_THE_FILTER_IS_INACTIVE","Filtr jest nieaktywny");
define("_SELECT_DATE","Wybierz dat�");
define("_SHOW_FLIGHTS","Poka� loty");
define("_ALL2","Wszystkie");
define("_WITH_YEAR","Rok");
define("_MONTH","Miesi�c");
define("_YEAR","Rok");
define("_FROM","Od");
define("_from","od");
define("_TO","do");
define("_SELECT_PILOT","Wybierz pilota");
define("_THE_PILOT","Pilot");
define("_THE_TAKEOFF","Miejsce startu");
define("_SELECT_TAKEOFF","Wybierz miejsce startu");
define("_THE_COUNTRY","Kraj");
define("_COUNTRY","Kraj");
define("_SELECT_COUNTRY","Wybierz kraj");
define("_OTHER_FILTERS","Inne filtry");
define("_LINEAR_DISTANCE_SHOULD_BE","Odleg�o�� po prostej ma wynosi�");
define("_OLC_DISTANCE_SHOULD_BE","Dystans OLC ma wynosi�");
define("_OLC_SCORE_SHOULD_BE","Punktacja OLC ma wynosi�");
define("_DURATION_SHOULD_BE","Czas lotu ma wynosi�");
define("_ACTIVATE_CHANGE_FILTER","Aktywuj / zmie� FILTR");
define("_DEACTIVATE_FILTER","Dezaktywuj FILTR");
define("_HOURS","godzin");
define("_MINUTES","minut");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","Dodaj lot");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(wystarczy plik IGC)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","Prze�lij plik<br>IGC");
define("_NOTE_TAKEOFF_NAME","Podaj nazw� startowiska i kraj");
define("_COMMENTS_FOR_THE_FLIGHT","Komentarz");
define("_PHOTO","Zdj�cie");
define("_PHOTOS_GUIDELINES","Zdj�cia powinny by� w formacie jpg i nie wi�ksze ni� ");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","Kliknij, aby przes�a� lot");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","Chcesz przes�a� kilka lot�w za jednym razem?");
define("_PRESS_HERE","Kliknij");

define("_IS_PRIVATE","Ukryj lot");
define("_MAKE_THIS_FLIGHT_PRIVATE","Ukryj lot");
define("_INSERT_FLIGHT_AS_USER_ID","Oznacz lot tylko numerem identyfikacyjnym u�ytkownika");
define("_FLIGHT_IS_PRIVATE","Ten lot jest ukryty");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","Zmie� dane lotu");
define("_IGC_FILE_OF_THE_FLIGHT","Plik IGC");
define("_DELETE_PHOTO","Usu�");
define("_NEW_PHOTO","Nowe zdj�cie");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","Kliknij, aby zmieni� dane lotu");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","Zmiany zosta�y zapisane");
define("_RETURN_TO_FLIGHT","Powr�t do lotu");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","Powr�t do lotu");
define("_READY_FOR_SUBMISSION","Gotowy do wys�ania");
define("_OLC_MAP","Mapa");
define("_OLC_BARO","Barograf");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","Profil pilota");
define("_back_to_flights","powr�t do lot�w");
define("_pilot_stats","statystyki");
define("_edit_profile","edytuj profil");
define("_flights_stats","statystyki lot�w");
define("_View_Profile","Poka� profil");

define("_Personal_Stuff","Dane osobiste");
define("_First_Name","Imi�");
define("_Last_Name","Nazwisko");
define("_Birthdate","Data urodzenia");
define("_dd_mm_yy","dd.mm.rr");
define("_Sign","Znak zodiaku");
define("_Marital_Status","Stan cywilny");
define("_Occupation","Zaw�d");
define("_Web_Page","Strona www");
define("_N_A","N/D");
define("_Other_Interests","Inne zainteresowania");
define("_Photo","Zdj�cie");

define("_Flying_Stuff","Do�wiadczenie");
define("_note_place_and_date","w stosownych przypadkach wpisz miejsce (kraj) oraz dat�");
define("_Flying_Since","Latam od");
define("_Pilot_Licence","Licencja");
define("_Paragliding_training","Szkolenie");
define("_Favorite_Location","Ulubione miejsce");
define("_Usual_Location","Najcz��ciej odwiedzane miejsce");
define("_Best_Flying_Memory","Najlepsze wspomnienie z latania");
define("_Worst_Flying_Memory","Najgorsze wspomnienie z latania");
define("_Personal_Distance_Record","Rekord w przelocie");
define("_Personal_Height_Record","Rekord przewy�szenia");
define("_Hours_Flown","Wylatane godziny");
define("_Hours_Per_Year","Liczba godzin w sezonie");

define("_Equipment_Stuff","Sprz�t");
define("_Glider","Skrzyd�o");
define("_Harness","Uprz��");
define("_Reserve_chute","RSH");
define("_Camera","Aparat foto");
define("_Vario","Wario");
define("_GPS","GPS");
define("_Helmet","Kask");
define("_Camcorder","Kamera");

define("_Manouveur_Stuff","Figury");
define("_note_max_descent_rate","w stosownych przypadkach wpisz maksymalne opadanie");
define("_Spiral","Spirala");
define("_Bline","B-sztal");
define("_Full_Stall","Fulsztal");
define("_Other_Manouveurs_Acro","Inne figury akro");
define("_Sat","Sat");
define("_Asymmetric_Spiral","Spirala asymetryczna");
define("_Spin","Negatywka");

define("_General_Stuff","Og�lne");
define("_Favorite_Singer","Ulubiony piosenkarz");
define("_Favorite_Movie","Ulubiony film");
define("_Favorite_Internet_Site","Ulubiona<br>strona www");
define("_Favorite_Book","Ulubiona ksi��ka");
define("_Favorite_Actor","Ulubiony aktor");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","Prze�lij nowe zdj�cie lub wymie� stare");
define("_Delete_Photo","Usu� zdj�cie");
define("_Your_profile_has_been_updated","Profil zosta� uaktualniony");
define("_Submit_Change_Data","Prze�lij - Zmie� dane");

//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","gg:mm");

define("_Totals","Og�lne");
define("_First_flight_logged","Pierwszy lot");
define("_Last_flight_logged","Ostatni lot");
define("_Flying_period_covered","Obj�ty okres");
define("_Total_Distance","Ca�kowity dystans");
define("_Total_OLC_Score","Ca�kowita punktacja OLC");
define("_Total_Hours_Flown","Ca�kowita liczba godzin");
define("_Total_num_of_flights","Liczba lot�w");

define("_Personal_Bests","Rekordy �yciowe");
define("_Best_Open_Distance","Najlepszy przelot otwarty");
define("_Best_FAI_Triangle","Najlepszy tr�jk�t FAI");
define("_Best_Free_Triangle","Najlepszy przelot zamkni�ty");
define("_Longest_Flight","Najd�u�szy czas lotu");
define("_Best_OLC_score","Najlepszy wynik OLC");

define("_Absolute_Height_Record","Rekord wysoko�ci");
define("_Altitute_gain_Record","Rekord przewy�szenia");
define("_Mean_values","Warto�ci �rednie");
define("_Mean_distance_per_flight","�redni dystans");
define("_Mean_flights_per_Month","�rednia liczba lot�w na miesi�c");
define("_Mean_distance_per_Month","�rednia liczba km na miesi�c");
define("_Mean_duration_per_Month","�rednia liczba godzin w sezonie");
define("_Mean_duration_per_flight","�redni czas trwania lotu");
define("_Mean_flights_per_Year","�rednia liczba lot�w w roku");
define("_Mean_distance_per_Year","�rednia liczba km w sezonie");
define("_Mean_duration_per_Year","�rednia liczba godzin w sezonie ");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","Poka� loty w pobli�u tego miejsca");
define("_Waypoint_Name","Nazwa punktu");
define("_Navigate_with_Google_Earth","Przejd� do Google Earth");
define("_See_it_in_Google_Maps","Poka� w Google Maps");
define("_See_it_in_MapQuest","Poka� w MapQuest");
define("_COORDINATES","Koordynaty");
define("_FLIGHTS","Loty");
define("_SITE_RECORD","Rekord miejsca");
define("_SITE_INFO","Informacja o miejscu");
define("_SITE_REGION","Region");
define("_SITE_LINK","Wi�cej informacji");
define("_SITE_DESCR","Opis miejsca startu");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","Poka� wi�cej szczeg���w");
define("_KML_file_made_by","plik KML utworzony przez");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","Zarejestruj miejsce startu");
define("_WAYPOINT_ADDED","Miejsce startu zosta�o zarejestrowane");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","Rekord miejsca<br>(dystans po prostej)");
	
//--------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","Rodzaj skrzyd�a");
function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'Paralotnia',2=>'Lotnia FAI1',4=>'Skrzyd�o sztywne FAI5',8=>'Szybowiec');
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

define("_Your_settings_have_been_updated","Nowe ustawienia zosta�y zapisane");

define("_THEME","Temat");
define("_LANGUAGE","J�zyk");
define("_VIEW_CATEGORY","Poka� kategori�");
define("_VIEW_COUNTRY","Poka� kraj");
define("_UNITS_SYSTEM" ,"System miar");
define("_METRIC_SYSTEM","Metryczny (km,m)");
define("_IMPERIAL_SYSTEM","Brytyjski (mile,stopy)");
define("_ITEMS_PER_PAGE","Liczba wynik�w na stronie");

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

define("_WORLD_WIDE","Ca�y �wiat");
define("_National_XC_Leagues_for","Ligi narodowe");
define("_Flights_per_Country","Liczba lot�w na kraj");
define("_Takeoffs_per_Country","Miejsca startu wed�ug kraj�w");
define("_INDEX_HEADER","Witamy na serwerze Leonardo XC League");
define("_INDEX_MESSAGE","Do nawigacji s�u�y &quot;Menu g��wne&quot; powy�ej, a poni�ej znajduj� si� najcz��ciej u�ywane odno�niki.");

define("_Best_flights_for ","Najlepsze loty w ");
define("_Latest_flights","Najnowsze loty");


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

define("_BREAKDOWN_PER_TAKEOFF","Breakdown Per Takeoff");
define("_BREAKDOWN_PER_GLIDER","Breakdown Per Glider");
?>

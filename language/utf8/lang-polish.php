<? if (0){?><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><? }?><?php

/************************************************************************/
/* Leonardo: Gliding XC Server				                 */
/* ============================================                          */
/*                                                                       */
/* Copyright (c) 2004-5 by Andreadakis Manolis                           */
/* http://leonardo.thenet.gr                                             */
/*                                                                       */
/* Niniejszy program jest wolnym oprogramowaniem. Możesz go rozprowadzać */
/* dalej i/lub modyfikować na warunkach Powszechnej Licencji Publicznej  */
/* GNU, wydanej przez Fundację Wolnego Oprogramowania - według           */
/* 2 wersji tej licencji lub którejś z późniejszych                      */
/*                                                                       */
/* Pamiętaj, że aby użyć cudzysłowu (") należy poprzedzić go lewym       */
/* ukośnikiem, aby nasz zapis wyglądał tak: To jest \"cytowany\" tekst.  */
/* Pamiętaj także, aby sprawdzić poprawność kodu HTML.                   */
/*************************************************************************/

function setMonths() {
	global  $monthList,	$monthListShort, $weekdaysList;
	$monthList=array('Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec',
					'Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień');
	$monthListShort=array('STY','LUT','MAR','KWI','MAJ','CZE','LIP','SIE','WRZ','PAŹ','LIS','GRU');
	$weekdaysList=array('Pon','Wt','Śr','Czw','Pt','Sob','Nie') ;
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","Przelot otwarty");
define("_FREE_TRIANGLE","Trójkąt");
define("_FAI_TRIANGLE","Trójkąt FAI");

define("_SUBMIT_FLIGHT_ERROR","Wystąpił błąd podczas przesyłania pliku!");

// list_pilots()
define("_NUM","#");
define("_PILOT","Pilot");
define("_NUMBER_OF_FLIGHTS","Liczba lotów");
define("_BEST_DISTANCE","Najlepszy przelot");
define("_MEAN_KM","Średni dystans");
define("_TOTAL_KM","Suma km");
define("_TOTAL_DURATION_OF_FLIGHTS","Całkowity czas lotów");
define("_MEAN_DURATION","Średni czas lotu");
define("_TOTAL_OLC_KM","Całkowity dystans OLC");
define("_TOTAL_OLC_SCORE","Całkowita punktacja OLC");
define("_BEST_OLC_SCORE","Najlepszy wynik OLC");
define("_From","od");

// list_flights()
define("_DURATION_HOURS_MIN","Czas (gg:mm)");
define("_SHOW","Pokaż");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","Lot zostanie wyświetlony za 1-2 minuty. ");
define("_TRY_AGAIN","Spróbuj ponownie później");

define("_TAKEOFF_LOCATION","Miejsce startu");
define("_TAKEOFF_TIME","Godzina startu");
define("_LANDING_LOCATION","Miejsce lądowania");
define("_LANDING_TIME","Godzina lądowania");
define("_OPEN_DISTANCE","Dystans po prostej");
define("_MAX_DISTANCE","Dystans max");
define("_OLC_SCORE_TYPE","Rodzaj punktacji OLC");
define("_OLC_DISTANCE","Dystans OLC");
define("_OLC_SCORING","Punkty OLC");
define("_MAX_SPEED","Prędkość max");
define("_MAX_VARIO","Wznoszenie max");
define("_MEAN_SPEED","Prędkość średnia");
define("_MIN_VARIO","Opadanie max");
define("_MAX_ALTITUDE","Wysokość max (n.p.m)");
define("_TAKEOFF_ALTITUDE","Wysokość startu (n.p.m.)");
define("_MIN_ALTITUDE","Wysokość min (n.p.m.)");
define("_ALTITUDE_GAIN","Przewyższenie");
define("_FLIGHT_FILE","Plik lotu");
define("_COMMENTS","Komentarz");
define("_RELEVANT_PAGE","Strona www");
define("_GLIDER","Skrzydło");
define("_PHOTOS","Zdjęcia");
define("_MORE_INFO","Dodatkowe informacje");
define("_UPDATE_DATA","Aktualizuj dane");
define("_UPDATE_MAP","Aktualizuj mapę");
define("_UPDATE_3D_MAP","Aktualizuj mapę 3D");
define("_UPDATE_GRAPHS","Aktualizuj wykresy");
define("_UPDATE_SCORE","Aktualizuj punktację");

define("_TAKEOFF_COORDS","Koordynaty startu:");
define("_NO_KNOWN_LOCATIONS","Miejsce nieznane!");
define("_FLYING_AREA_INFO","Informacja o miejscu");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo XC");
define("_RETURN_TO_TOP","Do góry");
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

define("_SORTED_BY","Sortuj według:");
define("_ALL_YEARS","Wszystkie lata");
define("_SELECT_YEAR_MONTH","Wybierz rok (i miesiąc)");
define("_ALL","Wszystkie");
define("_ALL_PILOTS","Pokaż wszystkich pilotów");
define("_ALL_TAKEOFFS","Pokaż wszystkie miejsca startu");
define("_ALL_THE_YEAR","Cały rok");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","Brak pliku lotu");
define("_NO_SUCH_FILE","Pliku nie można odnaleźć na serwerze");
define("_FILE_DOESNT_END_IN_IGC","Plik nie ma rozszerzenia .igc");
define("_THIS_ISNT_A_VALID_IGC_FILE","Wysłany plik .igc jest nieprawidłowy lub uszkodzony");
define("_THERE_IS_SAME_DATE_FLIGHT","Istnieje już lot z taką samą datą i godziną");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","Jeśli chcesz go wymienić, powinieneś najpierw");
define("_DELETE_THE_OLD_ONE","usunąć stary");
define("_THERE_IS_SAME_FILENAME_FLIGHT","Istnieje już plik o takiej samej nazwie");
define("_CHANGE_THE_FILENAME","Jeśli jest to inny lot, należy zmienić nazwę pliku i spróbować ponownie");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","Lot został dodany");
define("_PRESS_HERE_TO_VIEW_IT","Kliknij tutaj, aby zobaczyć lot");
define("_WILL_BE_ACTIVATED_SOON","(powinien on zostać wyświetlony za ok. 1-2 minuty)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Dodaj kilka lotów");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","Przetwarzane będą tylko pliki IGC");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","Dodaj plik<br>ZIP z lotami");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","Kliknij tutaj, aby dodać loty");

define("_FILE_DOESNT_END_IN_ZIP","Plik nie ma rozszerzenia .zip");
define("_ADDING_FILE","Przesyłanie pliku");
define("_ADDED_SUCESSFULLY","Plik został przesłany");
define("_PROBLEM","Błąd");
define("_TOTAL","W sumie ");
define("_IGC_FILES_PROCESSED","lotów zostało przetworzonych");
define("_IGC_FILES_SUBMITED","lotów zostało przesłanych");

// info
define("_DEVELOPMENT","Autor");
define("_ANDREADAKIS_MANOLIS","Andreadakis Manolis");
define("_PROJECT_URL","Strona projektu");
define("_VERSION","Wersja");
define("_MAP_CREATION","Wykonanie map");
define("_PROJECT_INFO","Informacja o projekcie");

// menu bar 
define("_MENU_MAIN_MENU","Menu główne");
define("_MENU_DATE","Wybierz datę");
define("_MENU_COUNTRY","Wybierz kraj");
define("_MENU_XCLEAGUE","Liga XC");
define("_MENU_ADMIN","Admin");

define("_MENU_COMPETITION_LEAGUE","Liga - wszystkie kategorie");
define("_MENU_OLC","OLC");
define("_MENU_OPEN_DISTANCE","Dystans otwarty");
define("_MENU_DURATION","Czas");
define("_MENU_ALL_FLIGHTS","Pokaż wszystkie loty");
define("_MENU_FLIGHTS","Loty");
define("_MENU_TAKEOFFS","Miejsca startu");
define("_MENU_FILTER","Filtr");
define("_MENU_MY_FLIGHTS","Moje loty");
define("_MENU_MY_PROFILE","Mój profil");
define("_MENU_MY_STATS","Moje statystyki"); 
define("_MENU_MY_SETTINGS","Moje ustawienia"); 
define("_MENU_SUBMIT_FLIGHT","Dodaj lot");
define("_MENU_SUBMIT_FROM_ZIP","Dodaj lot z pliku zip");
define("_MENU_SHOW_PILOTS","Piloci");
define("_MENU_SHOW_LAST_ADDED","Pokaż ostatnio dodane");
define("_FLIGHTS_STATS","Statystyki lotów");

define("_SELECT_YEAR","Wybierz rok");
define("_SELECT_MONTH","Wybierz miesiąc");
define("_ALL_COUNTRIES","Pokaż wszystkie kraje");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","WSZYSTKIE");
define("_NUMBER_OF_FLIGHTS","Liczba lotów");
define("_TOTAL_DISTANCE","Dystans całkowity");
define("_TOTAL_DURATION","Czas całkowity");
define("_BEST_OPEN_DISTANCE","Najlepsza odległość");
define("_TOTAL_OLC_DISTANCE","Całkowity dystans OLC");
define("_TOTAL_OLC_SCORE","Całkowita punktacja OLC");
define("_BEST_OLC_SCORE","Najlepszy wynik OLC");
define("_MEAN_DURATION","Czas średni");
define("_MEAN_DISTANCE","Dystans średni");
define("_PILOT_STATISTICS_SORT_BY","Piloci - Sortuj według");
define("_CATEGORY_FLIGHT_NUMBER","Kategoria 'FastJoe' - Liczba lotów");
define("_CATEGORY_TOTAL_DURATION","Kategoria 'DURACELL' - Całkowity czas trwania lotów");
define("_CATEGORY_OPEN_DISTANCE","Kategoria 'Przelot otwarty'");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","Brak pilotów spełniających kategorie!");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","Lot został usunięty");
define("_RETURN","Powrót");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","UWAGA! - Lot zostanie usunięty");
define("_THE_DATE","Data ");
define("_YES","TAK");
define("_NO","NIE");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","Wyniki ligowe");
define("_N_BEST_FLIGHTS","Najlepsze loty");
define("_OLC","OLC");
define("_OLC_TOTAL_SCORE","Całkowita puntacja OLC");
define("_KILOMETERS","Kilometry");
define("_TOTAL_ALTITUDE_GAIN","Suma przewyższeń");
define("_TOTAL_KM","Total km");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","jest");
define("_IS_NOT","nie jest");
define("_OR","lub");
define("_AND","i");
define("_FILTER_PAGE_TITLE","Filtruj loty");
define("_RETURN_TO_FLIGHTS","Powrót do lotów");
define("_THE_FILTER_IS_ACTIVE","Filtr jest aktywny");
define("_THE_FILTER_IS_INACTIVE","Filtr jest nieaktywny");
define("_SELECT_DATE","Wybierz datę");
define("_SHOW_FLIGHTS","Pokaż loty");
define("_ALL2","Wszystkie");
define("_WITH_YEAR","Rok");
define("_MONTH","Miesiąc");
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
define("_LINEAR_DISTANCE_SHOULD_BE","Odległość po prostej ma wynosić");
define("_OLC_DISTANCE_SHOULD_BE","Dystans OLC ma wynosić");
define("_OLC_SCORE_SHOULD_BE","Punktacja OLC ma wynosić");
define("_DURATION_SHOULD_BE","Czas lotu ma wynosić");
define("_ACTIVATE_CHANGE_FILTER","Aktywuj / zmień FILTR");
define("_DEACTIVATE_FILTER","Dezaktywuj FILTR");
define("_HOURS","godzin");
define("_MINUTES","minut");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","Dodaj lot");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(wystarczy plik IGC)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","Prześlij plik<br>IGC");
define("_NOTE_TAKEOFF_NAME","Podaj nazwę startowiska i kraj");
define("_COMMENTS_FOR_THE_FLIGHT","Komentarz");
define("_PHOTO","Zdjęcie");
define("_PHOTOS_GUIDELINES","Zdjęcia powinny być w formacie jpg i nie większe niż ");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","Kliknij, aby przesłać lot");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","Chcesz przesłać kilka lotów za jednym razem?");
define("_PRESS_HERE","Kliknij");

define("_IS_PRIVATE","Ukryj lot");
define("_MAKE_THIS_FLIGHT_PRIVATE","Ukryj lot");
define("_INSERT_FLIGHT_AS_USER_ID","Oznacz lot tylko numerem identyfikacyjnym użytkownika");
define("_FLIGHT_IS_PRIVATE","Ten lot jest ukryty");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","Zmień dane lotu");
define("_IGC_FILE_OF_THE_FLIGHT","Plik IGC");
define("_DELETE_PHOTO","Usuń");
define("_NEW_PHOTO","Nowe zdjęcie");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","Kliknij, aby zmienić dane lotu");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","Zmiany zostały zapisane");
define("_RETURN_TO_FLIGHT","Powrót do lotu");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","Powrót do lotu");
define("_READY_FOR_SUBMISSION","Gotowy do wysłania");
define("_OLC_MAP","Mapa");
define("_OLC_BARO","Barograf");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","Profil pilota");
define("_back_to_flights","powrót do lotów");
define("_pilot_stats","statystyki");
define("_edit_profile","edytuj profil");
define("_flights_stats","statystyki lotów");
define("_View_Profile","Pokaż profil");

define("_Personal_Stuff","Dane osobiste");
define("_First_Name","Imię");
define("_Last_Name","Nazwisko");
define("_Birthdate","Data urodzenia");
define("_dd_mm_yy","dd.mm.rr");
define("_Sign","Znak zodiaku");
define("_Marital_Status","Stan cywilny");
define("_Occupation","Zawód");
define("_Web_Page","Strona www");
define("_N_A","N/D");
define("_Other_Interests","Inne zainteresowania");
define("_Photo","Zdjęcie");

define("_Flying_Stuff","Doświadczenie");
define("_note_place_and_date","w stosownych przypadkach wpisz miejsce (kraj) oraz datę");
define("_Flying_Since","Latam od");
define("_Pilot_Licence","Licencja");
define("_Paragliding_training","Szkolenie");
define("_Favorite_Location","Ulubione miejsce");
define("_Usual_Location","Najczęściej odwiedzane miejsce");
define("_Best_Flying_Memory","Najlepsze wspomnienie z latania");
define("_Worst_Flying_Memory","Najgorsze wspomnienie z latania");
define("_Personal_Distance_Record","Rekord w przelocie");
define("_Personal_Height_Record","Rekord przewyższenia");
define("_Hours_Flown","Wylatane godziny");
define("_Hours_Per_Year","Liczba godzin w sezonie");

define("_Equipment_Stuff","Sprzęt");
define("_Glider","Skrzydło");
define("_Harness","Uprząż");
define("_Reserve_chute","RSH");
define("_Camera","Aparat foto");
define("_Vario","Wario");
define("_GPS","GPS");
define("_Helmet","Kask");
define("_Camcorder","Kamera");

define("_Manouveur_Stuff","Figury");
define("_note_max_descent_rate","maksymalne opadanie");
define("_Spiral","Spirala");
define("_Bline","B-sztal");
define("_Full_Stall","Fulsztal");
define("_Other_Manouveurs_Acro","Inne figury akro");
define("_Sat","Sat");
define("_Asymmetric_Spiral","Spirala asymetryczna");
define("_Spin","Negatywka");

define("_General_Stuff","Ogólne");
define("_Favorite_Singer","Ulubiony piosenkarz");
define("_Favorite_Movie","Ulubiony film");
define("_Favorite_Internet_Site","Ulubiona<br>strona www");
define("_Favorite_Book","Ulubiona książka");
define("_Favorite_Actor","Ulubiony aktor");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","Prześlij nowe zdjęcie lub wymień stare");
define("_Delete_Photo","Usuń zdjęcie");
define("_Your_profile_has_been_updated","Profil został uaktualniony");
define("_Submit_Change_Data","Prześlij - Zmień dane");

//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","gg:mm");

define("_Totals","Ogólne");
define("_First_flight_logged","Pierwszy lot");
define("_Last_flight_logged","Ostatni lot");
define("_Flying_period_covered","Objęty okres");
define("_Total_Distance","Całkowity dystans");
define("_Total_OLC_Score","Całkowita punktacja OLC");
define("_Total_Hours_Flown","Całkowita liczba godzin");
define("_Total_num_of_flights","Liczba lotów");

define("_Personal_Bests","Rekordy życiowe");
define("_Best_Open_Distance","Najlepszy przelot otwarty");
define("_Best_FAI_Triangle","Najlepszy trójkąt FAI");
define("_Best_Free_Triangle","Najlepszy przelot zamknięty");
define("_Longest_Flight","Najdłuższy czas lotu");
define("_Best_OLC_score","Najlepszy wynik OLC");

define("_Absolute_Height_Record","Rekord wysokości");
define("_Altitute_gain_Record","Rekord przewyższenia");
define("_Mean_values","Wartości średnie");
define("_Mean_distance_per_flight","Średni dystans");
define("_Mean_flights_per_Month","Średnia liczba lotów na miesiąc");
define("_Mean_distance_per_Month","Średnia liczba km na miesiąc");
define("_Mean_duration_per_Month","Średnia liczba godzin w miesiącu");
define("_Mean_duration_per_flight","Średni czas trwania lotu");
define("_Mean_flights_per_Year","Średnia liczba lotów w roku");
define("_Mean_distance_per_Year","Średnia liczba km w sezonie");
define("_Mean_duration_per_Year","Średnia liczba godzin w sezonie ");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","Pokaż loty w pobliżu tego miejsca");
define("_Waypoint_Name","Nazwa punktu");
define("_Navigate_with_Google_Earth","Przejdź do Google Earth");
define("_See_it_in_Google_Maps","Pokaż w Google Maps");
define("_See_it_in_MapQuest","Pokaż w MapQuest");
define("_COORDINATES","Koordynaty");
define("_FLIGHTS","Loty");
define("_SITE_RECORD","Rekord miejsca");
define("_SITE_INFO","Informacja o miejscu");
define("_SITE_REGION","Region");
define("_SITE_LINK","Więcej informacji");
define("_SITE_DESCR","Opis miejsca startu");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","Pokaż więcej szczegółów");
define("_KML_file_made_by","plik KML utworzony przez");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","Zarejestruj miejsce startu");
define("_WAYPOINT_ADDED","Miejsce startu zostało zarejestrowane");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","Rekord miejsca<br>(dystans po prostej)");
	
//--------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","Rodzaj skrzydła");
function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'Paralotnia',2=>'Lotnia FAI1',4=>'Skrzydło sztywne FAI5',8=>'Szybowiec');
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

define("_Your_settings_have_been_updated","Nowe ustawienia zostały zapisane");

define("_THEME","Temat");
define("_LANGUAGE","Język");
define("_VIEW_CATEGORY","Pokaż kategorię");
define("_VIEW_COUNTRY","Pokaż kraj");
define("_UNITS_SYSTEM" ,"System miar");
define("_METRIC_SYSTEM","Metryczny (km,m)");
define("_IMPERIAL_SYSTEM","Brytyjski (mile,stopy)");
define("_ITEMS_PER_PAGE","Liczba wyników na stronie");

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

define("_WORLD_WIDE","Cały świat");
define("_National_XC_Leagues_for","Ligi narodowe");
define("_Flights_per_Country","Liczba lotów na kraj");
define("_Takeoffs_per_Country","Miejsca startu według krajów");
define("_INDEX_HEADER","Witamy na serwerze Leonardo XC League");
define("_INDEX_MESSAGE","Do nawigacji służy &quot;Menu główne&quot; powyżej, a poniżej znajdują się najczęściej używane odnośniki.");

define("_Best_flights_for ","Najlepsze loty w ");
define("_Latest_flights","Najnowsze loty");


//--------------------------------------------
// NEW 
//--------------------------------------------
define("_MENU_SUMMARY_PAGE","Strona główna (podsumowanie)");//First (Summary) Page");
define("_Display_ALL","Wyświetl wszystkie");//Display ALL");
define("_Display_NONE","Display NONE");
define("_Reset_to_default_view","Przywróć widok domyślny");//Reset to default view");
define("_No_Club","Bez klubu");//No Club");
define("_This_is_the_URL_of_this_page","To jest adres tej strony");//This is the URL of this page");
define("_All_glider_types","Wszystkie rodzaje");//All glider types");

define("_MENU_SITES_GUIDE","Przewodnik");//Flying Sites Guide");
define("_Site_Guide","Site Guide");

define("_Search_Options","Opcje wyszukiwania");//Search Options");
define("_Below_is_the_list_of_selected_sites","Poniżej znajduje się lista wybranych startowisk");//Below is the list of selected sites");
define("_Clear_this_list","Wyczyść listę");//Clear this list");
define("_See_the_selected_sites_in_Google_Earth","Zobacz wybrane startowiska w Google Earth");//See the selected sites in Google Earth");
define("_Available_Takeoffs","Dostępne startowiska");//Available Takeoffs");
define("_Search_site_by_name","Wyszukaj po nazwie");//Search site by name");
define("_give_at_least_2_letters","podaj co najmniej 2 litery");//give at least 2 letters");
define("_takeoff_move_instructions_1","Możesz przesunąć wszystkie dostępne startowiska do prawego panelu wykorzystując >> lub pojedynczokorzystając z > ");//You can move all availabe takeoffs to the selected list on the right panel by using >> or the selected one by using > ");
define("_Takeoff_Details","Szczegóły startowiska");//Takeoff Details");


define("_Takeoff_Info","Informacje o startowisku");//Takeoff Info");
define("_XC_Info","XC Info");
define("_Flight_Info","Informacje o locie");//Flight Info");

define("_MENU_LOGOUT","Wyloguj");//Logout");
define("_MENU_LOGIN","Zaloguj");//Login");
define("_MENU_REGISTER","Załóż konto");//Open an account");


define("_Africa","Afryka");//Africa");
define("_Europe","Europa");//Europe");
define("_Asia","Azja");//Asia");
define("_Australia","Australia");//Australia");
define("_North_Central_America","Ameryka Północna/Środkowa");//North/Central America");
define("_South_America","Południowa Ameryka");//South America");

define("_Recent","Ostatnie");//Recent");


define("_Unknown_takeoff","Nieznane startowisko");//Unknown takeoff");
define("_Display_on_Google_Earth","Wyświetl w Google Earth");//Display on Google Earth");
define("_Use_Man_s_Module","Use Man's Module");
define("_Line_Color","Kolor lini");//Line Color");
define("_Line_width","Grubość lini");//Line width");
define("_unknown_takeoff_tooltip_1","Ten lot został wykonany z nieznanego startowiska");//This flight has an uknown Takeoff");
define("_unknown_takeoff_tooltip_2","Jeśli wiesz skąd odbył się ten lot proszę uzupełnij dane!");//If you do know from which takeoff/launch this flight began please click to fill it in !");
define("_EDIT_WAYPOINT","Edytuj informacje o startowisku");//Edit Takeoff Info");
define("_DELETE_WAYPOINT","Usuń startowisko");//Delete Takeoff");
define("_SUBMISION_DATE","Data przesłania");//Submission Date"); // the date a flight was submited to leonardo
define("_TIMES_VIEWED","Ilość odsłon");//Times Viewed"); // the times that this flight havs been viewed


define("_takeoff_add_help_1","Możesz uzupełnić informacje o startowisku, jeśli nie jesteś pewien to możesz zamknąć to okno");//You can enter the takeoff infomation if you know it. If not sure it is OK to close this window");
define("_takeoff_add_help_2","Jeśli startowisko z Twojego lotu jest wyświetlane powyżej tekstu 'Nieznane startowisko' to nie trzeba wprowadzać go ponownie. Poprostu zamknij okno.");//If the launch of your flight is the one displayed above the 'Unknown Takeoff' then there is no need to enter it again. Just close this window. ");
define("_takeoff_add_help_3","Jeśli widzisz nazwę startowiska poniżej możesz kliknąć na nie w celu autmatycznego wypełnienia pól po prawej.");//If you see the launch name below you can click on it to auto-fill the fields to the left.");
define("_Takeoff_Name","Nazwa startowiska");//Takeoff Name");
define("_In_Local_Language","W lokalnym języku");//In Local Language");
define("_In_English","Po angielsku");//In English");

// New on 2007/02/20 - login screen
define("_ENTER_PASSWORD","Aby zalogować się podaj nazwę użytkownika i hasło");//Please enter your username and password to log in.");
define("_SEND_PASSWORD","Zapomnialem hasła");//I forgot my password");
define("_ERROR_LOGIN","Niepoprawna nazwa użytkownika lub błędne hasło");//You have specified an incorrect or inactive username, or an invalid password.");
define("_AUTO_LOGIN","Zapamiętaj mnie i loguj automatycznie przy każdej wizycie");//Log me on automatically each visit");
define("_USERNAME","Nazwa użytkownika");//Username");
define("_PASSWORD","Hasło");//Password");
define("_PROBLEMS_HELP","W przypadku problemów skontaktuj się z administratorem");//If you have problems to log in contact the administrator");

define("_LOGIN_TRY_AGAIN","Kliknij %sTutaj%s aby spróbować ponownie");//Click %sHere%s to try again");
define("_LOGIN_RETURN","Kliknij %sTutaj%s aby wrócić na stronę główną");//Click %sHere%s to return to the Index");
// end 2007/02/20

define("_Category","Kategoria");//Category");
define("_MEMBER_OF","Członek ");//Member of");
define("_MemberID","ID członka ");//Member ID");
define("_EnterID","Podaj ID");//Enter ID");
define("_Clubs_Leagues","Kluby / Ligi");//Clubs / Leagues");
define("_Pilot_Statistics","Statystyki Pilota");//Pilot Statistics");
define("_National_Rankings","Narodowe rankingi");//National Rankings");




// new on 2007/03/08
define("_Select_Club","Wybierz klub");//Select Club");
define("_Close_window","Zamknij okno");//Close window");
define("_EnterID","Podaj ID");//Enter ID");
define("_Club","Klub");//Club");
define("_Sponsor","Sponsor");


// new on 2007/03/13
define('_Go_To_Current_Month','Wybierz bieżący miesiac');//Go To Current Month');
define('_Today_is','Dzisiaj mamy');//Today is');
define('_Wk','Wk');
define('_Click_to_scroll_to_previous_month','Kliknij aby przewinąć do poprzedniego miesiąca. Przytrzymaj aby przewijać automatycznie.');//Click to scroll to previous month. Hold mouse button to scroll automatically.');
define('_Click_to_scroll_to_next_month','Kliknij aby przewinąć do następnego miesiaca. Przytrzymaj aby przewijać automatycznie.');//Click to scroll to next month. Hold mouse button to scroll automatically.');
define('_Click_to_select_a_month','Kliknij aby wybrać miesiąc');//Click to select a month.');
define('_Click_to_select_a_year','Kliknij aby wybrać rok');//Click to select a year.');
define('_Select_date_as_date.','Wybierz [date] jako datę');//Select [date] as date.'); // do not replace [date], it will be replaced by date.

// end 2007/03/13
//--------------------------------------------------------
//--------------------------------------------------------
// Missing defines , autoreplaced values from 'english' 
//--------------------------------------------------------
define("_SEASON","Sezon");//Season"); 
define("_SUBMIT_TO_OLC","Wyślij do OLC");//Submit to OLC"); 
define("_pilot_email","Adres email");//Email Address"); 
define("_Sex","Płeć");//Sex"); 
define("_Login_Stuff","Change Login-Data"); 
define("_PASSWORD_CONFIRMATION","Potwierdź hasło");//Confirm password"); 
define("_EnterPasswordOnlyToChange","Podaj wyłącznie hasło, jeśli chcesz je zmienić");//Only enter the password, if you want to change it:"); 
define("_PwdAndConfDontMatch","Hasło i potwierdzenie hasła różnią się.");//Password and confirmation are different."); 
define("_PwdTooShort","Hasło jest za krótkie. Powinno mieć co najmniej $passwordMinLength znaków.");//The password is too short. It must have a length of at least $passwordMinLength characters."); 
define("_PwdConfEmpty","Hasło nie zostało potwierdzone.");//The password has not be confirmed."); 
define("_PwdChanged","Hasło zostało zmienione.");//The password was changed."); 
define("_PwdNotChanged","Hasło NIE zostało zmienione.");//The password has NOT been changed."); 
define("_PwdChangeProblem","Wystąpił problem podczas zmiany hasła.");//A problem occurred when changing the password."); 
define("_EmailEmpty","Adres email nie może być pusty.");//The email address must not be empty."); 
define("_EmailInvalid","Adres email jest niepoprawny.");//The email address is invalid."); 
define("_EmailSaved","Adres email został zapisany.");//The email address was saved"); 
define("_EmailNotSaved","Adres email nie zostal zapisany.");//The email address has not been saved."); 
define("_EmailSaveProblem","Wystąpił problem podczas zapisywania adresu email.");//A problem occurred when saving the email address."); 
define("_PROJECT_HELP","Pomoc");//Help"); 
define("_PROJECT_NEWS","Nowości");//News"); 
define("_PROJECT_RULES","Zasady 2007");//Regulations 2007"); 
define("_Filter_NoSelection","Brak wyboru");//No selection"); 
define("_Filter_CurrentlySelected","Obecny wybór");//Current selection"); 
define("_Filter_DialogMultiSelectInfo","Naciśnij Ctrl aby dokonać wielokrotnego wyboru");//Press Ctrl for multiple selection."); 
define("_Filter_FilterTitleIncluding","Tylko wybrane elementy [items]");//Only selected [items]"); 
define("_Filter_FilterTitleExcluding","Wykluczone elementy [items]");//Exclude [items]"); 
define("_Filter_DialogTitleIncluding","Wybierz elementy [items]");//Select [items]"); 
define("_Filter_DialogTitleExcluding","Wybierz elementy [items]");//Select [items]"); 
define("_Filter_Items_pilot","piloci");//pilots"); 
define("_Filter_Items_nacclub","kluby");//clubs"); 
define("_Filter_Items_country","kraje");//countries"); 
define("_Filter_Items_takeoff","startowiska");//take offs"); 
define("_Filter_Button_Select","Wybierz");//Select"); 
define("_Filter_Button_Delete","Skasuj");//Delete"); 
define("_Filter_Button_Accept","Zatwierdź wybór");//Accept selection"); 
define("_Filter_Button_Cancel","Anuluj");//Cancel"); 
define("_MENU_FILTER_NEW","Filter **NEW VERSION**"); 
define("_ALL_NACCLUBS","Wszystkie kluby");//All Clubs"); 
define("_SELECT_NACCLUB","Wybierz [nacname] - klub");//Select [nacname]-Club"); 
define("_FirstOlcYear","Pierwszy rok uczestnictwa w internetowym konkursie przelotowym");//First year of participation in an online XC contest"); 
define("_FirstOlcYearComment","Wybierz rok w którym poraz pierwszy uczestniczyłeś w jakimkolwkiek konursie przelotowym online");//Please select the year of your first participation in any online XC contest, not just this one.<br/>This field is relevant for the &quot;newcomer&quot;-rankings."); 
//define("_FirstOlcYearComment","Please select the year of your first participation in any online XC contest, not just this one.<br/>This field is relevant for the &quot;newcomer&quot;-rankings."); 
define("_Select_Brand","Wybierz markę");//Select Brand"); 
define("_All_Brands","Wszystkie marki");//All Brands"); 
define("_DAY","Dzień");//DAY"); 
define("_Glider_Brand","Marka");//Glider Brand"); 
define("_Or_Select_from_previous","Lub wybierz z poprzednich");//Or Select from previous"); 
define("_Explanation_AddToBookmarks_IE","Dodaj obecne ustawienia filtra do ulubionych");//Add these filter settings to your favourites"); 
define("_Msg_AddToBookmarks_IE","Kliknij tutaj aby dodać te ustawienia filtra do swoich zakladek.");//Click here to add these filter settings to your bookmarks."); 
define("_Explanation_AddToBookmarks_nonIE","(Zapisz odnośnik w swoich zakładkach.)");//(Save this link to your bookmarks.)"); 
define("_Msg_AddToBookmarks_nonIE","Aby zapisać ten filtr w swoich zakładkach wykorzystaj funkcję Dodaj do zakładek swojej przeglądarki.");//To save these filter settings to your bookmarks, use the function Save to bookmarks of your browser."); 
define("_PROJECT_RULES2","Zasady 2008");//Regulations 2008"); 
define("_MEAN_SPEED1","Średnia prędkość");//Mean Speed"); 
define("_External_Entry","Zewnętrzny wpis");//External Entry"); 
define("_Altitude","Wysokość");//Altitude"); 
define("_Speed","Prędkość");//Speed"); 
define("_Distance_from_takeoff","Odległość od startowiska");//Distance from takeoff"); 
define("_LAST_DIGIT","ostatnia cyfra");//last digit"); 
define("_Filter_Items_nationality","narodowość");//nationality"); 
define("_Filter_Items_server","serwer");//server"); 
define("_Ext_text1","Ten lot został wgrany na ");//This is a flight originally submited at "); 
define("_Ext_text2","Odnośnik do pełnej mapy z lotem i wykresów");//Link to full flight maps and charts"); 
define("_Ext_text3","Odnośnik do oryginalnego lotu");//Link to original flight"); 
define("_Male_short","M"); 
define("_Female_short","K");//F"); 
define("_Male","Mężczyzna");//Male"); 
define("_Female","Kobieta");//Female"); 
define("_Altitude_Short","Wys.");//Alt"); 
define("_Vario_Short","Vario"); 
define("_Time_Short","Czas");//Time"); 
define("_Info","Info"); 
define("_Control","Sterowanie");//Control"); 
define("_Zoom_to_flight","Przybliżenie do lotu");//Zoom to flight"); 
define("_Follow_Glider","Podążaj za pilotem");//Follow Glider"); 
define("_Show_Task","Pokaż zadanie");//Show Task"); 
define("_Show_Airspace","Pokaż strefy");//Show Airspace"); 
define("_Thermals","Kominy");//Thermals"); 
define("_Show_Optimization_details","Pokaż szczegóły optymalizacji");//Show Optimization Details"); 
define("_MENU_SEARCH_PILOTS","Szukaj");//Search"); 
define("_MemberID_Missing","Brakuje Twojego ID");//Your member ID is missing"); 
define("_MemberID_NotNumeric","ID musi być numerem");//The member ID must be numeric"); 
define("_FLIGHTADD_CONFIRMATIONTEXT","Wgrywając ten lot gwarantuję, że przestrzegałem wszystkich regulacji prawnych powiązanych z lotem.");//By submitting this form I confirm that I have respected all legal obligations concerning this flight."); 
define("_FLIGHTADD_IGC_MISSING","Wybierz swój plik .igc");//Please select your .igc-file"); 
define("_FLIGHTADD_IGCZIP_MISSING","Wybierz plik zip zawierający Twoje pliki .igc");//Please select the zip-file containing your .igc-file"); 
define("_FLIGHTADD_CATEGORY_MISSING","Wybierz kategorię");//Please select the category"); 
define("_FLIGHTADD_BRAND_MISSING","Wybierz markę Twojej paralotni");//Please select the brand of your glider"); 
define("_FLIGHTADD_GLIDER_MISSING","Wybierz typ Twojej paralotni");//Please enter the type of your glider"); 
define("_YOU_HAVENT_ENTERED_GLIDER","Należy podać markę i typ");//You have not entered brand or glider"); 
define("_BRAND_NOT_IN_LIST","Marki nie ma na liście");//Brand not in list"); 
define("_Email_new_password","<p align='justify'>Serwer wysłał wiadomosć e-mail z nowym hasłem i kluczem aktywacyjnym</p> <p align='justify'>Proszę sprawdź pocztę i postępuj zgodnie ze wskazówkami</p>"); 
//define("_Email_new_password","<p align='justify'>The server have sent a email to the pilot with the new password and activation key</p> <p align='justify'>Please, check your email box and follow the procedures in the email body</p>"); 
define("_informed_user_not_found","Użytkownik nie został znaleziony w bazie danych");//This user was not found in the database"); 
define("_impossible_to_gen_new_pass","<p align='justify'>Niestety nie możemy wygenerować nowego hasła ponieważ istnieje już takie żądanie, które przedawni się w <b>%s</b>. Dopiero po przedawnieniu można poprosić o ponowne wygenerowanie hasła. Bardzo możliwe, że wiadomość trafiła do folderu ze spamem.</p><p align='justify'>Jeśli nie masz dostępu do swojej skrzynki mailowejskontaktuj się z administratorem swojego serwera</p>"); 
//define("_impossible_to_gen_new_pass","<p align='justify'>We are sorry to inform you that is not possible to generate a new password for you at this time, there is already a request that will expire in <b>%s</b>. Only after the expiration time you can do a new request.</p><p align='justify'>If you do not have access to the email contact the server admin</p>"); 
define("_Password_subject_confirm","Confirmation email (new password)"); 
define("_request_key_not_found","klucz jaki podałeś nie został znaleziony!");//the request key that you have provided was not found!"); 
define("_request_key_invalid","klucz jaki podałeś jest niepoprawny!");//request key that you have provided is invalid!"); 
define("_Email_allready_yours","Podany adres email jest Twój, nie będzie zmian");//The provided email is allready yours, nothing to do"); 
define("_Email_allready_have_request","Była prośba o zmianę na ten email, nie bedzie zmian");//There is already an request for changing to this email, nothing to do"); 
define("_Email_used_by_other","Ten adres email jest wykorzystywany przez innego pilota, nie będzie zmian");//This email is used by another pilot, nothing to do"); 
define("_Email_used_by_other_request","Ten adres email jest wykorzystywany przez innego pilota w oczekującym żądaniu");//This email is used by another pilot in a pending request"); 
define("_Email_canot_change_quickly","Nie możesz teraz zmienić swojego adresu email, poczekaj aż się przedawni: %s");//You can not change your email right now, wait for the expiring time: %s"); 
define("_Email_sent_with_confirm","Wiadomość z potwierdzeniem została wysłana, proszę sprawdź teraz swoją skrzynkę aby potwierdzić zmianę adresu email");//A confirmation email is send, please check you mailbox so that you can confirm the changing of email"); 
define("_Email_subject_confirm","Potwierdzenie adresu email (nowy email)");//Confirmation email (new email)"); 
define("_Email_AndConfDontMatch","Adres  email i potwierdzenie różnią sie.");//Email and confirmation are different."); 
define("_ChangingEmailForm"," Formularz zmiany adresu email");//Changing Email Form"); 
define("_Email_current","Bierzący adres email");//Current Email"); 
define("_New_email","Brak adresu email");//New Email Address"); 
define("_New_email_confirm","Potwierdź nowy adres email");//Confirm New Email"); 
define("_MENU_CHANGE_PASSWORD","Zmiana hasła");//Change my password"); 
define("_MENU_CHANGE_EMAIL","Zmiana adresu email");//Change my email"); 
define("_New_Password","Nowe hasło");//New Password"); 
define("_ChangePasswordForm","Formularz zmiany hasła");//Change Password Form"); 
define("_lost_password","Formularz zgubionego hasła");//Lost Password Form"); 
define("_PASSWORD_RECOVERY_TOOL","Formularz przywrócenia hasła");//Password Recovery Form"); 
define("_PASSWORD_RECOVERY_TOOL_MESSAGE","Baza danych serwera zostanie przeszukana pod kątem wpisanego teksu, jeśli zostanie odnaleziony użytkownik, adres email lub CIVLID wyślemy wiadomość z odnośnikiem aktywującym nowe hasło. <br><br> uwaga: tylko po aktywacji nowego hasła będzie można z niego korzystać.<br><br>"); 
//define("_PASSWORD_RECOVERY_TOOL_MESSAGE","The Server will search in his entire database for the inserted text in the textbox, if and when the server find the user, email, or civlid, A mail will be sended for the registered email address with a new password and activation link.<br><br> note: only after activation of the new password through activation link inside mail body, the new password will be valid.<br><br>"); 
define("_username_civlid_email","Proszę podaj: CIVLID, nazwę użytkownika lub adres email");//Please fill with: CIVLID or User Name or Email Address"); 
define("_Recover_my_pass","Przywróć moje hasło");//Recover my Password"); 
define("_You_are_not_login","<BR><BR><center><br>Nie jesteś zalogowany. <br><br>Proszę zaloguj się<br><br></center>");//<BR><BR><center><br>You are not logged in. <br><br>Please Login<BR><BR></center>"); 
define("_Requirements","Wymagania");//Requirements"); 
define("_Mandatory_CIVLID","Należy mieć poprawne <b>CIVLID</b>");//Is mandatory tho have an valid <b>CIVLID</b>"); 
define("_Mandatory_valid_EMAIL","Należy podać poprawny <b>adres email</b> w celu aktywacji konta");//Is mandatory to provide a <b>Valid Email</b> for further comunications with admin server"); 
define("_Email_periodic","Na podany adres e-mail wyślemy wiadomość, w przypadku braku reakcji konto zostanie zablokowane");//Periodically we will send you a confirmation e-mail to the provided e-mail address, if not answered, your registration account will be blocked"); 
define("_Email_asking_conf","Wyślemy wiadomosć aktywacyjną na podany adres email");//We will send a confirmation e-mail to the provided email address"); 
define("_Email_time_conf","W ciągu <b>3 godzin</b> należy wykonać instrukcje wiadomości aktywacyjnej wysłanej na podany adres email");//You will have only <b>3 hours </b> after the finishing the pre-registration to answer the email"); 
define("_After_conf_time"," Jeśli nie zdążysz tego zrobić dane jakie podałeś zostaną <b>usunięte</b> z naszej bazy danych");//After that time, your pre-registration will be <b>removed</b> from our database"); 
define("_Only_after_time","<b>Tylko po tym czasie będziesz mógł ponownie rozpocząć proces rejestracji</b>");//<b>And only after we remove your pre-registration, you can do the pre registration again</b>"); 
define("_Disable_Anti_Spam","<b>UWAGA!!! </b> wyłącz filtr anty spamowy dla wiadomości z adresu <b>%s</b>");//<b>ATTENTION!! Disable</b> the anti spam for emails originated from <b>%s</b>"); 
define("_If_you_agree","Jeśli zgadzasz sie, możesz kontynuować.");//If you agree with this requirements please go further."); 
define("_Search_civl_by_name","%sSzukaj swojego nazwiska w bazie CIVL%s . Gdy klikniesz na odnośnik po lewej otworzy się okno w którym musisz wpisać co najmniej 3 litery imienia bądź nazwiska, system CIVL zwróci Twoje CIVLID, nazwisko oraz narodowość FAI.");//%sSearch for your name in the CIVL database%s . When you click at this left link will be opened a new window , please fill only 3 letters from your First name or Last Name, then the CIVL will return your CIVLID, Name and FAI Nationality."); 
define("_Register_civl_as_new_pilot","Jeśli nie jesteś zarejestrowany w CIVL, możesz %szarejestrować się tam jako nowy pilot%s (jeśli nie chesz się tam rejestrować zacznij wypełniać formularz od pola pseudonim)");//If you are not registered in the CIVL database, please  %sREGISTER-ME AS A NEW PILOT%s"); 
define("_NICK_NAME","Pseudonim");//Nick Name"); 
define("_LOCAL_PWD","Hasło");//Local Password"); 
define("_LOCAL_PWD_2","Powtórz hasło");//Repeat Local Password"); 
define("_CONFIRM","Potwierdź");//Confirm"); 
define("_REQUIRED_FIELD","Wymagane pola");//Mandatory Fields"); 
define("_Registration_Form","Formularz rejestracyjny %s (Leonardo)");//Registration Form at %s (Leonardo)"); 
define("_MANDATORY_NAME","Musisz podać swoje imię / nazwisko");//Is Mandatory to provide your name"); 
define("_MANDATORY_FAI_NATION","Musisz podać swoją narodowość");//Is Mandatory to provide your FAI NATION"); 
define("_MANDATORY_GENDER","Proszę podaj swoją płeć");//Please provide your Sex"); 
define("_MANDATORY_BIRTH_DATE_INVALID","Data urodzin nieprawidłowa");//Birth Date Invalid"); 
define("_MANDATORY_CIVL_ID","Proszę podaj swój CIVLID");//Please provide your CIVLID"); 
define("_Attention_mandatory_to_have_civlid","UWAGA!!! Posiadanie CIVLID jest wymagane w bazie danych %s");//ATENTION!! For now one is Mandatory to have CIVLID in the %s database"); 
define("_Email_confirm_success","Twoja rejestracja została potwierdzona!");//Your registration was successfully confirmed!"); 
define("_Success_login_civl_or_user","Udało się, teraz możesz zalogowaćsie wykorzystując swój CIVLID jako nazwę użytkownika lub tradycyjną nazwą użytkownika");//Success, now you can login using your CIVLID as username, or continue with your old username"); 
define("_Server_did_not_found_registration","Nie znaleziono takiego konta, proszę upewnij się że dobrze skopiowałeś(aś) odnośnik który wysłaliśmi na Twoją skrzynkę pocztową. Możliwe, że uległ przedawnieniu");//Registration not found, please copy and paste in your browser address field the link provided in the email that was send to you, or maybe your registration time has expired"); 
define("_Pilot_already_registered","Pilot z takim CIVLID i nazwiskiem %s jest już zarejestrowany");//Pilot already registered with CIVLID %s and name %s"); 
define("_User_already_registered","Istnieje użytkownik z takim emailem lub nawzwą użytkownika");//User already registered with this email or name"); 
define("_Pilot_civlid_email_pre_registration","Cześć %s Ten CIVLID oraz email zostały już wykorzystane do wstępnej rejestracji");//Hi %s This Civl ID and email is already used in a pre-registration"); 
define("_Pilot_have_pre_registration"," Dokonałeś(aś) już wstępnej rejestracji, ale nie odpisałeś(aś) na naszą wiadomość - wysyłamy ponownie mail aktywacyjny, masz 3 godziny aby potwierdzić rejestrację. Jeśli tego nie zrobisz Twoje dane zostaną usunięte z portalu, proszę przeczytaj wiadomość i kolejne kroki wykonaj zgodnie z instrukcjami");// You already have a pre registration, but have not answered our mail, we resend the confirmation email for you, you have 3 hours after now to answer the email, if not you will be removed from pre registration. please read the email and follow the procedures described inside, thank you"); 
define("_Pre_registration_founded","We already have a pre-registration with this civlID and Email,wait for finishing the period of 3 hours until then this registration will be removed, in no hipotisis confirm the email that was send  because will be generated an double registration, and your old flights will not be transfered for the new user"); 
define("_Civlid_already_in_use","Ten nr CIVLID jest został wykorzystany przez innego pilota, nie możemy mieć dwóch różnych kont z takim samym CIVLID)");//This CIVLID is used for another pilot, we can not have double CIVLID!"); 
define("_Pilot_email_used_in_reg_dif_civlid","Cześć %s ten adres email został już wykorzystany z innym CIVLID");//Hi %s This Email is used in another register with different CIVLID"); 
define("_Pilot_civlid_used_in_reg_dif_email","Cześć %s ten CIVLID został wykorzystany już do rejestracji z innym adresem email");//Hi %s This CIVLID is used in another register with different EMAIL"); 
define("_Pilot_email_used_in_pre_reg_dif_civlid","Cześć %s ten adres email został już wykorzystany do wstępnej rejestracji z innym numerem CIVLID");//Hi %s This Email is used in another pre-register with different CIVLID"); 
define("_Pilot_civlid_used_in_pre_reg_dif_email","Cześć %s ten CIVLID został wykorzystany już do wstępnej rejestracji z innym adresem email");//Hi %s This CIVLID is used in another pre-register with different EMAIL"); 
define("_Server_send_conf_email","Serwer wysłał do %s wiadomość email z prośbąo potwierdzenie, masz trzy godziny na potwierdzenie rejestracji poprzez kliknięcie w odnośnik jaki został wysłany na podaną skrzynkę email");//The server have sended to the %s an email asking for confirmation, you have 3 hours from now to confirm your registration by clicking or copying and pasting the link that are in the email body in your browser addres"); 
define("_Pilot_confirm_subscription","===================================

%s Leonardo new user
                
Witaj %s,

To jest wiadomość aktywacyjna wysłana  z portalu %s
 
Aby dokończyć proces tworzenia konta, kliknij w poniższy odnośnik aby potwierdzić swoją rejestrację:

http://%s?op=register&rkey=%s 

Jeśli nie rejestrowałeś się w naszym portalu zignoruj tę wiadomość.

Z pozdrowieniami,
Zespół pgxc.pl

--------
Note: Mail został wysłany automatyznie. Nie odpowiadaj na niego!
--------"); 
define("_Pilot_confirm_change_email","===================================

%s Leonardo user
                
Witaj %s,

To jest  wiadomość weryfikująca wysłana z portalu %s
 
Aby dokończyć proces zmiany adresu email kliknij w odnośnik poniżej:

http://%s?op=chem&rkey=%s

Z pozdrowieniami,
Zespół pgxc.pl

--------
Note: Mail został wysłany automatycznie. Nie odpowiadaj na niego!
--------"); 
define("_Password_recovery_email","===================================

%s (Leonardo) user
                
Witaj %s,

To jest wiadomosć weryfikująca wysłana z portalu %s
                
Zawiera ona hasło tymczasowe i link aktywacyjny.
                
Nazwa użytkownika:%s
                
CIVLID:%s
                
Hasło tymczasowe:%s
 
Aby aktywować hasło kliknij w odnośnik poniżej:

http://%s?op=send_password&rkey=%s 

Po zalogowaniu się z hasłem tymczasowym z głównego menu wybierz pozycję \"Mój profil\", 
kliknij odnośnik \"edytuj profil\", podaj nowe hasło i zatwierdź je przyciskiem \"Prześlij - zmień dane\".

Z pozdrowieniami,
Zespół pgxc.pl

--------
Note: Mail został wysłany automatycznie. Nie odpowiadaj na niego!
--------"); 
define("_MENU_AREA_GUIDE","Przewodnik po okolicy");//Area Guide"); 
define("_All_XC_types","Wszystkie rodzaje przelotów");//All XC types"); 
define("_xctype","Rodzaje przelotów");//  XC type"); 
define("_Flying_Areas","Rejony do latania");//Flying Areas"); 
define("_Name_of_Area","Nazwa rejonu");//Name of Area"); 
define("_See_area_details","Zobacz szczegóły i startowiska dla tego rejonu"); //See the details and takeoffs for this area"); 
define("_choose_ge_module","Proszę wybrać moduł do wykorzystania<BR>w Google Earth"); //Please choose the module to use<BR>for Google Earth Display"); 
define("_ge_module_advanced_1","(Najbardziej szczegółowy, największy rozmiar)"); //(Most detailed, bigger size)"); 
define("_ge_module_advanced_2","(Dokładny, duży rozmiar)"); //(Many details, big size) "); 
define("_ge_module_Simple","Prosty (tylko task, bardoz mały)"); //Simple (Only Task, very small)"); 
define("_Pilot_search_instructions","Podaj co najmniej 3 litery nazwiska");//Enter at least 3 letters of the First or Last Name"); 
define("_All_classes","Wszystkie klasy");//All classes"); 
define("_Class","Klasa");//Class"); 
define("_Photos_filter_off","Z/bez zdjęć");//With/without photos"); 
define("_Photos_filter_on","Tylko ze zdjęciami");//With photos only"); 
define("_You_are_already_logged_in","Jesteś już zalogowany");//You are already logged in"); 
define("_See_The_filter","Zobacz ustawienia filtra");//See the filter"); 
define("_PilotBirthdate","Data urodzin pilota");//Pilot Birthdate"); 
define("_Start_Type","Rodzaj startu");//Start Type"); 
define("_GLIDER_CERT","Certyfikacja skrzydła");//Glider Certification"); 
define("_MENU_BROWSER","Zobacz w Google Maps");//Browse in Google Maps"); 
define("_FLIGHT_BROSWER","Przeszukaj loty i startowiska z Google Maps");//Search the flights and takeoff database with Google Maps"); 
define("_Load_Thermals","Załaduj kominy"); //Load Thermals"); 
define("_Loading_thermals","Ładowanie kominów"); //Loading Thermals"); 
define("_Layers","Warstwy");//Layers"); 
define("_Select_Area","Wybierz pole");//Select Area"); 
define("_Leave_a_comment","Skomentuj");//Leave a comment"); 
define("_Reply","Odpowiedz"); //Reply"); 
define("_Translate","Przetłumacz"); //Translate"); 
define("_Translate_to","Przetłumacz na"); //Translate to"); 
define("_Submit_Comment","Wyślij komentarz"); //Submit Comment"); 
define("_Logged_in_as","Zalogowany jako:"); //Logged in as:"); 
define("_Name","Imię"); //Name"); 
define("_Email","Email"); 
define("_Will_not_be_displayed","(Nie będzie wyświetlany)"); //(Will not be displayed)"); 
define("_Please_type_something","Proszę napisz coś"); //Please type something"); 
define("_Please_enter_your_name","Proszę  podaj swoje imię / ksywkę"); //Please enter your name / nickname"); 
define("_Please_give_your_email","Proszę podaj swój adres email, nigdzie nie będzie wyświetlony"); //Please give your email, it will not be displayed at any times"); 
define("_RSS_for_the_comments","To jest odnośnik do kanału RSS dla komentarzy tego lotu<BR>Skopiuj i wklej do swojego czntnika RSS"); //This is the RSS link for this flight\'s comments<BR>Copy Paste it into your RSS reader"); 
define("_Comments_are_enabled_by_default_for_new_flights","Komentarze są domyślnie włączone dla nowych lotów"); //Comments are enabled by default for new flights"); 
define("_Comments_Enabled","Komentarze włączone");  //Comments Enabled"); 
define("_Comments_are_enabled_for_this_flight","Komentarze dla tego lotu są włączone"); 
define("_Comments_are_disabled_for_this_flight","Komentarze dla tego lotu są wyłączone"); 
define("_ERROR_in_setting_the_comments_status","BŁĄD podczas ustawiania statusu komentarza"); 
define("_Save_changes","Zapisz zmiany"); 
define("_Cancel","Anuluj"); 
define("_Are_you_sure_you_want_to_delete_this_comment","Czy jesteś pewien że chcesz usunąć ten komentarz?"); 
define("_RSS_feed_for_comments","kanał RSS komentarzy"); 
define("_RSS_feed_for_flights","kanał RSS lotów"); 
define("_RSS_of_pilots_flights","kanał RSS lotów pilota"); 
define("_You_have_a_new_comment","Masz nowy komentarz dot. %s"); 
define("_New_comment_email_body","Masz nowy komentarz dot. %s<BR><BR><a href='%s'>Kliknij aby przeczytać wszystkie komentarze</a><hr>%s"); 
define("_Remove_From_Favorites","Usuń z ulubionych"); 
define("_Favorites","Ulubione"); 
define("_Compare_flights_line_1","Wybierz loty ptaszkiem"); 
define("_Compare_flights_line_2","i porównaj je między sobą w Google Maps"); 
define("_Compare_Favorite_Tracks","Porównaj ulubione loty"); 
define("_Remove_all_favorites","Usuń wszystkie ulubione"); 
define("_Find_and_Compare_Flights","Znajdź i porównaj loty"); 
define("_Compare_Selected_Flights","Porównaj wybrane loty"); 
define("_More","Więcej"); 
define("_Close","Zamknij"); 

//20160204 rgrubba
define("_ACCEPT_STATUTE","Akceptuję regulamin");
define("_MANDATORY_STATUTE","Musisz zaakceptować regulamin");
define("_Accept_statute","Rejestrując się w portalu musisz zaakceptować regulamin");

?>

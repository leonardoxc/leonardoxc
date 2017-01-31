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
	$monthList=array('Ianuarie','Februarie','Martie','Aprilie','Mai','Iunie',
                    'Iulie','August','Septembrie','Octombrie','Noiembrie','Decembrie');
	$monthListShort=array('JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC');
	$weekdaysList=array('Mon','Tue','Wed','Thu','Fri','Sat','Sun') ;
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","Zbor liber");
define("_FREE_TRIANGLE","Triunghi Liber");
define("_FAI_TRIANGLE","Triunghi FAI");

define("_SUBMIT_FLIGHT_ERROR","Eroare in inregistrarea zborului");

// list_pilots()
define("_NUM","#");
define("_PILOT","Pilot");
define("_NUMBER_OF_FLIGHTS","Numar de zboruri");
define("_BEST_DISTANCE","Record distanta");
define("_MEAN_KM","# mediu de km per zbor");
define("_TOTAL_KM","Total km de zbor");
define("_TOTAL_DURATION_OF_FLIGHTS","Durata totala de zbor");
define("_MEAN_DURATION","Durata medie de zbor");
define("_TOTAL_OLC_KM","Distanta totala OLC");
define("_TOTAL_OLC_SCORE","Scor total OLC");
define("_BEST_OLC_SCORE","Record OLC");
define("_From","de la");

// list_flights()
define("_DURATION_HOURS_MIN","Dur (h:m)");
define("_SHOW","Afiseaza");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","Zborul va fi activat in 1-2 minute. ");
define("_TRY_AGAIN","Va rugam incercati mai tarziu");

define("_TAKEOFF_LOCATION","Decolare");
define("_TAKEOFF_TIME","Ora decolare");
define("_LANDING_LOCATION","Aterizare");
define("_LANDING_TIME","Ora aterizare");
define("_OPEN_DISTANCE","Distanta in linie");
define("_MAX_DISTANCE","Distanta maxima");
define("_OLC_SCORE_TYPE","Tip scor OLC");
define("_OLC_DISTANCE","Distanta OLC");
define("_OLC_SCORING","Scor OLC");
define("_MAX_SPEED","Viteza maxima");
define("_MAX_VARIO","Vario maxim");
define("_MEAN_SPEED","viteza medie");
define("_MIN_VARIO","Vario minim");
define("_MAX_ALTITUDE","Alt max (ASL)");
define("_TAKEOFF_ALTITUDE","Altitudine decolare (ASL)");
define("_MIN_ALTITUDE","Alt min (ASL)");
define("_ALTITUDE_GAIN","Castig inaltime");
define("_FLIGHT_FILE","Fisier de zbor");
define("_COMMENTS","Comentarii");
define("_RELEVANT_PAGE","Relevant page URL");
define("_GLIDER","Parapanta");
define("_PHOTOS","Poze");
define("_MORE_INFO","Extra");
define("_UPDATE_DATA","Actualizeaza informatia");
define("_UPDATE_MAP","Actualizeaza harta");
define("_UPDATE_3D_MAP","Actualizeaza harta 3D");
define("_UPDATE_GRAPHS","Actualizeaza clasamentele");
define("_UPDATE_SCORE","Actualizeaza scorul");

define("_TAKEOFF_COORDS","Coordonate decolare:");
define("_NO_KNOWN_LOCATIONS","Nu s-au gasit locatii cunoscute!");
define("_FLYING_AREA_INFO","Info zona de zbor");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo XC");
define("_RETURN_TO_TOP","Revenire pagina sus");
// list flight
define("_PILOT_FLIGHTS","Zboruri pilot");

define("_DATE_SORT","Data");
define("_PILOT_NAME","Nume Pilot");
define("_TAKEOFF","Decolare");
define("_DURATION","Durata");
define("_LINEAR_DISTANCE","Open Distance");
define("_OLC_KM","Km OLC");
define("_OLC_SCORE","Scor OLC");
define("_DATE_ADDED","Ultimele inregistrari");

define("_SORTED_BY","Sortare dupa:");
define("_ALL_YEARS","Toti anii");
define("_SELECT_YEAR_MONTH","Selecteaza anul (si luna)");
define("_ALL","Toate");
define("_ALL_PILOTS","Afiseaza toti pilotii");
define("_ALL_TAKEOFFS","Afiseaza toate decolarile");
define("_ALL_THE_YEAR","Tot anul");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","Nu ati introdus un fisier de zbor");
define("_NO_SUCH_FILE","Fisierul introdus nu poate fi gasit pe server");
define("_FILE_DOESNT_END_IN_IGC","Fisierul nu are extensia .igc");
define("_THIS_ISNT_A_VALID_IGC_FILE","Acesta nu este un fisier de tip .igc");
define("_THERE_IS_SAME_DATE_FLIGHT","Exista deja un fisier cu aceeasi data si ora");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","Daca doriti sa-l inlocuiti trebuie sa-l");
define("_DELETE_THE_OLD_ONE","stergeti pe cel vechi");
define("_THERE_IS_SAME_FILENAME_FLIGHT","Exista deja un fisier cu acelasi nume");
define("_CHANGE_THE_FILENAME","Daca acest zbor este unul diferit, va rugam schimbati numele fisierului si incercati din nou");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","Zborul a fost inregistrat");
define("_PRESS_HERE_TO_VIEW_IT","Apasati aici pt a vizualiza");
define("_WILL_BE_ACTIVATED_SOON","(va fi activat in 1-2 minute)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Inregistrati zboruri multiple");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","Doar fisierele IGC vor fi procesate");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","Introduceti fisierul zip<br>care contine zborurile");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","Apasati aici pentru a inregistra zborurile");

define("_FILE_DOESNT_END_IN_ZIP","Fisierul introdus nu are extensia .zip");
define("_ADDING_FILE","Inregistrare fisier...");
define("_ADDED_SUCESSFULLY","Inregistrare reusita");
define("_PROBLEM","Problema");
define("_TOTAL","Un total de");
define("_IGC_FILES_PROCESSED","zboruri au fost procesate");
define("_IGC_FILES_SUBMITED","zboruri au fost inregistrate");

// info
define("_DEVELOPMENT","Dezvoltare");
define("_ANDREADAKIS_MANOLIS","Andreadakis Manolis");
define("_PROJECT_URL","Pagina proiect");
define("_VERSION","Versiune");
define("_MAP_CREATION","Creare harta");
define("_PROJECT_INFO","Info proiect");

// menu bar 
define("_MENU_MAIN_MENU","Meniu principal");
define("_MENU_DATE","Selecteaza data");
define("_MENU_COUNTRY","Selecteaza tara");
define("_MENU_XCLEAGUE","Liga XC");
define("_MENU_ADMIN","Admin");

define("_MENU_COMPETITION_LEAGUE","Liga - toate categoriile");
define("_MENU_OLC","OLC");
define("_MENU_OPEN_DISTANCE","Open Distance");
define("_MENU_DURATION","Durata");
define("_MENU_ALL_FLIGHTS","Afiseaza toate zborurile");
define("_MENU_FLIGHTS","Zboruri");
define("_MENU_TAKEOFFS","Decolari");
define("_MENU_FILTER","Filtru");
define("_MENU_MY_FLIGHTS","Zborurile mele");
define("_MENU_MY_PROFILE","Profilul meu");
define("_MENU_MY_STATS","Statisticile mele"); 
define("_MENU_MY_SETTINGS","Setarile mele"); 
define("_MENU_SUBMIT_FLIGHT","Inregistreaza zbor");
define("_MENU_SUBMIT_FROM_ZIP","Inregistreaza zboruri din zip");
define("_MENU_SHOW_PILOTS","Piloti");
define("_MENU_SHOW_LAST_ADDED","Arata ultimele inregistrari");
define("_FLIGHTS_STATS","Statisticile zborurilor");

define("_SELECT_YEAR","Selecteaza anul");
define("_SELECT_MONTH","Selecteaza luna");
define("_ALL_COUNTRIES","Arata toate tarile");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","Din toate timpurile");
define("_NUMBER_OF_FLIGHTS","Number of flights");
define("_TOTAL_DISTANCE","Distanta totala");
define("_TOTAL_DURATION","Durata totala");
define("_BEST_OPEN_DISTANCE","Cea mai buna distanta");
define("_TOTAL_OLC_DISTANCE","Distanta totala OLC");
define("_TOTAL_OLC_SCORE","Scor total OLC");
define("_BEST_OLC_SCORE","Cel mai bun scor OLC");
define("_MEAN_DURATION","Durata medie");
define("_MEAN_DISTANCE","Distanta medie");
define("_PILOT_STATISTICS_SORT_BY","Piloti - Sorteaza dupa");
define("_CATEGORY_FLIGHT_NUMBER","Categoria 'FastJoe' - Numar de zboruri");
define("_CATEGORY_TOTAL_DURATION","Categoria 'DURACELL' - Durata totala de zboruri");
define("_CATEGORY_OPEN_DISTANCE","Categoria 'Open Distance'");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","Nu au fost gasiti piloti!");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","Zborul a fost sters");
define("_RETURN","Inapoi");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","ATENTIE - Sunteti pe cale sa stergeti acest zbor");
define("_THE_DATE","Data ");
define("_YES","DA");
define("_NO","NU");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","Rezultate Liga");
define("_N_BEST_FLIGHTS"," cele mai bune zboruri");
define("_OLC","OLC");
define("_OLC_TOTAL_SCORE","Scor total OLC");
define("_KILOMETERS","Kilometri");
define("_TOTAL_ALTITUDE_GAIN","Castig total de altitudine");
define("_TOTAL_KM","Total km");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","este");
define("_IS_NOT","nu este");
define("_OR","sau");
define("_AND","si");
define("_FILTER_PAGE_TITLE","Filtru zboruri");
define("_RETURN_TO_FLIGHTS","Intoarcere la zboruri");
define("_THE_FILTER_IS_ACTIVE","Filtrul este activ");
define("_THE_FILTER_IS_INACTIVE","Filtrul este inactiv");
define("_SELECT_DATE","Selecteaza data");
define("_SHOW_FLIGHTS","Afiseaza zboruri");
define("_ALL2","TOATE");
define("_WITH_YEAR","Cu anul");
define("_MONTH","Luna");
define("_YEAR","Anul");
define("_FROM","De la");
define("_from","de la");
define("_TO","la");
define("_SELECT_PILOT","Selecteaza pilot");
define("_THE_PILOT","Pilotul");
define("_THE_TAKEOFF","Decolarea");
define("_SELECT_TAKEOFF","Selecteaza decolarea");
define("_THE_COUNTRY","Tara");
define("_COUNTRY","Tara");
define("_SELECT_COUNTRY","Selecteza tara");
define("_OTHER_FILTERS","Alte filtre");
define("_LINEAR_DISTANCE_SHOULD_BE","Distanta liniara ar trebui sa fie");
define("_OLC_DISTANCE_SHOULD_BE","Distanta OLC ar trebui sa fie");
define("_OLC_SCORE_SHOULD_BE","Scorul OLC ar trebui sa fie");
define("_DURATION_SHOULD_BE","Durata ar trebuie sa fie");
define("_ACTIVATE_CHANGE_FILTER","Activeaza / schimba FILTRUL");
define("_DEACTIVATE_FILTER","Dezactiveaza FILTRUL");
define("_HOURS","ore");
define("_MINUTES","min");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","Inregistreaza zborul");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(Este necesar doar fisierul IGC)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","Inregistreaza fisierul <br>IGC al zborului");
define("_NOTE_TAKEOFF_NAME","Va rugam notati tara si numele locatiei de decolare");
define("_COMMENTS_FOR_THE_FLIGHT","Comentarii despre zbor");
define("_PHOTO","Foto");
define("_PHOTOS_GUIDELINES","Fotografiile trebuie sa fie in format jpg si mai mici de ");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","Apasati aici pentru a inregistra zborul");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","Doriti sa inregistrati mai multe zboruri deodata ?");
define("_PRESS_HERE","Apasati aici");

define("_IS_PRIVATE","Nu afisa public");
define("_MAKE_THIS_FLIGHT_PRIVATE","Nu afisa public");
define("_INSERT_FLIGHT_AS_USER_ID","Introduceti zborul ca si ID utilizator");
define("_FLIGHT_IS_PRIVATE","Acest zbor este privat");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","Schimbati data zborului");
define("_IGC_FILE_OF_THE_FLIGHT","Fisierul IGC al zborului");
define("_DELETE_PHOTO","Sterge");
define("_NEW_PHOTO","Fotografie noua");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","Apasa aici pentru a schimba data zborului");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","Modificarile au fost aplicate");
define("_RETURN_TO_FLIGHT","Inapoi la zbor");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","Inapoi la zbor");
define("_READY_FOR_SUBMISSION","Gata pentru a fi inregistrat");
define("_OLC_MAP","Harta");
define("_OLC_BARO","Barograf");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","Profil Pilot");
define("_back_to_flights","Inapoi la zboruri");
define("_pilot_stats","Statistici pilot");
define("_edit_profile","editeaza profilul");
define("_flights_stats","statistici zboruri");
define("_View_Profile","Vizualizeaza profil");

define("_Personal_Stuff","Informatii personale");
define("_First_Name","Prenume");
define("_Last_Name","Nume");
define("_Birthdate","Data nasterii");
define("_dd_mm_yy","dd.mm.yy");
define("_Sign","Semn zodiacal");
define("_Marital_Status","Starea civila");
define("_Occupation","Ocupatie");
define("_Web_Page","Pagina WEB");
define("_N_A","N/A");
define("_Other_Interests","Alte interese");
define("_Photo","Fotografie");

define("_Flying_Stuff","Informatii despre zbor");
define("_note_place_and_date","daca este cazul notati locul-tara si data");
define("_Flying_Since","Zbor din");
define("_Pilot_Licence","Licenta de zbor");
define("_Paragliding_training","Paragliding training");
define("_Favorite_Location","Locatia preferata");
define("_Usual_Location","Locatia uzuala");
define("_Best_Flying_Memory","Cea mai frumoasa amintire de zbor");
define("_Worst_Flying_Memory","Cea mai neplacuta amintire de zbor");
define("_Personal_Distance_Record","Record personal de distanta");
define("_Personal_Height_Record","Record personal de inaltime");
define("_Hours_Flown","Ore de zbor");
define("_Hours_Per_Year","Ore pe an");

define("_Equipment_Stuff","Echipament de zbor");
define("_Glider","Parapanta");
define("_Harness","Seleta");
define("_Reserve_chute","Rezerva");
define("_Camera","Camera");
define("_Vario","Vario");
define("_GPS","GPS");
define("_Helmet","Casca");
define("_Camcorder","Camcorder");

define("_Manouveur_Stuff","Manevre de zbor");
define("_note_max_descent_rate","daca este cazul notati rata maxima de coborare atinsa");
define("_Spiral","Spirala");
define("_Bline","Bline");
define("_Full_Stall","Full Stall");
define("_Other_Manouveurs_Acro","Alte manevre acro");
define("_Sat","Sat");
define("_Asymmetric_Spiral","Spirala asimetrica");
define("_Spin","Spin");

define("_General_Stuff","Informatii generale");
define("_Favorite_Singer","Cantaret/ata favorit/a");
define("_Favorite_Movie","Film preferat");
define("_Favorite_Internet_Site","Site internet<br>preferat");
define("_Favorite_Book","Cartea preferata");
define("_Favorite_Actor","Actor/rita preferat/a");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","Adauga foto noua sau schimba una veche");
define("_Delete_Photo","Sterge foto");
define("_Your_profile_has_been_updated","Profilul a fost actializat");
define("_Submit_Change_Data","Inregistreaza - Schimba data");

//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","hh:mm");

define("_Totals","Totaluri");
define("_First_flight_logged","Primul zbor inregistrat");
define("_Last_flight_logged","Ultimul zbor inregistrat");
define("_Flying_period_covered","Perioada de zbor acoperita");
define("_Total_Distance","Distanta totala");
define("_Total_OLC_Score","Scor total OLC");
define("_Total_Hours_Flown","Total ore zburate");
define("_Total_num_of_flights","# total de zboruri ");

define("_Personal_Bests","Recorduri personale");
define("_Best_Open_Distance","Record Open Distance");
define("_Best_FAI_Triangle","Record Triunghi FAI");
define("_Best_Free_Triangle","Record Triunghi Liber");
define("_Longest_Flight","Cel mai lung zbor");
define("_Best_OLC_score","Cel mai bun scor OLC");

define("_Absolute_Height_Record","Record absolut de inaltime");
define("_Altitute_gain_Record","Record de castig in altitudine");
define("_Mean_values","Valori medii");
define("_Mean_distance_per_flight","Distanta medie pe zbor");
define("_Mean_flights_per_Month","Zboruri medii pe luna");
define("_Mean_distance_per_Month","Distanta medie pe luna");
define("_Mean_duration_per_Month","Durata medie pe luna");
define("_Mean_duration_per_flight","Durata medie pe zbor");
define("_Mean_flights_per_Year","Media de zboruri pe an");
define("_Mean_distance_per_Year","Distanta medie pe an");
define("_Mean_duration_per_Year","Durata medie pe an");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","Vezi zboruri langa acest punct");
define("_Waypoint_Name","Nume Waypoint");
define("_Navigate_with_Google_Earth","Navigheaza cu Google Earth");
define("_See_it_in_Google_Maps","Vezi in Google Maps");
define("_See_it_in_MapQuest","Vezi in MapQuest");
define("_COORDINATES","Coordinate");
define("_FLIGHTS","Zboruri");
define("_SITE_RECORD","Record Site");
define("_SITE_INFO","Informatii Site");
define("_SITE_REGION","Regiune");
define("_SITE_LINK","Link catre mai multe informatii");
define("_SITE_DESCR","Descriere Site/decolare");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","Vezi mai multe detalii");
define("_KML_file_made_by","Fisier KML creat de");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","Inregistreaza decolarea");
define("_WAYPOINT_ADDED","Decolarea a fost inregistrata");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","Record Site<br>(open distance)");
	
//--------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","Model Parapanta");
function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'Parapanta',2=>'Aripa flexibila FAI1',4=>'Aripa rigida FAI5',8=>'Aripa');
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

define("_Your_settings_have_been_updated","Setarile au fost actualizate");

define("_THEME","Tema");
define("_LANGUAGE","Limba");
define("_VIEW_CATEGORY","Vezi categoria");
define("_VIEW_COUNTRY","Vezi tara");
define("_UNITS_SYSTEM" ,"Sistem de masura");
define("_METRIC_SYSTEM","Metric (km,m)");
define("_IMPERIAL_SYSTEM","Imperial (mile, picioare)");
define("_ITEMS_PER_PAGE","Obiecte pe pagina");

define("_MI","mi");
define("_KM","km");
define("_FT","ft");
define("_M","m");
define("_MPH","mph");
define("_KM_PER_HR","km/h");
define("_FPM","fpm");
define("_M_PER_SEC","m/sec");

//--------------------------------------------
// index page
//--------------------------------------------

define("_WORLD_WIDE","In toata lumea");
define("_National_XC_Leagues_for","Ligi XC nationale pentru");
define("_Flights_per_Country","Zboruri per tara");
define("_Takeoffs_per_Country","Decolari per tara");
define("_INDEX_HEADER","Bine ati venit in Liga XC LEONARDO");
define("_INDEX_MESSAGE","Poti folsi &quot;Meniu principal&quot; ca sa navighezi sau foloseste cele mai utilizate alegeri prezentate mai jos.");

//--------------------------------------------
// NEW 
//--------------------------------------------
define("_MENU_SUMMARY_PAGE","Prima (Sumar) Pagina");
define("_Display_ALL","Afizeaza toate");
define("_Display_NONE","Nu afisa nici una");
define("_Reset_to_default_view","Reseteaza la imaginea implicita");
define("_No_Club","No Club");
define("_This_is_the_URL_of_this_page","This is the URL of this page");
define("_All_glider_types","Toate tipurile de parapante");

define("_MENU_SITES_GUIDE","Ghid de locuri de zbor");
define("_Site_Guide","Ghid de Site-uri");

define("_Search_Options","Optiuni de cautare");
define("_Below_is_the_list_of_selected_sites","Mai jos este lista locurilor de zbor selectate");
define("_Clear_this_list","Goleste aceasta lista");
define("_See_the_selected_sites_in_Google_Earth","Vezi site-urile selectate in Google Earth");
define("_Available_Takeoffs","Decolari disponibile");
define("_Search_site_by_name","Cauta site-uri dupa nume");
define("_give_at_least_2_letters","Scrieti cel putin 2 litere");
define("_takeoff_move_instructions_1","Poti muta toate decolarile disponibile in lista selectata din panelul din dreapta folosind >> sau cele selectate folosind > ");
define("_Takeoff_Details","Detalii decolare");


define("_Takeoff_Info","Info decolare");
define("_XC_Info","Info XC");
define("_Flight_Info","Info zbor");

define("_MENU_LOGOUT","Iesire");
define("_MENU_LOGIN","Intra in cont");
define("_MENU_REGISTER","Inregistreaza-te");


define("_Africa","Africa");
define("_Europe","Europa");
define("_Asia","Asia");
define("_Australia","Australia");
define("_North_Central_America","America de Nord/Centrala");
define("_South_America","America de Sud");

define("_Recent","Recent");


define("_Unknown_takeoff","Decolare necunoscuta");
define("_Display_on_Google_Earth","Afiseaza in Google Earth");
define("_Use_Man_s_Module","Foloseste modulul Man`s");
define("_Line_Color","Culoare linie");
define("_Line_width","Grosime linie");
define("_unknown_takeoff_tooltip_1","Acest zbor are o decolare necunoscuta");
define("_unknown_takeoff_tooltip_2","Daca stii de pe ce loc de decolare a inceput acest zbor, apasa  pentru a introduce datele !");
define("_EDIT_WAYPOINT","Editeaza informatiile despre decolare");
define("_DELETE_WAYPOINT","Sterge decolarea");
define("_SUBMISION_DATE","Data inregistrarii"); // the date a flight was submited to leonardo
define("_TIMES_VIEWED","Numar vizualizari"); // the times that this flight havs been viewed


define("_takeoff_add_help_1","Poti introduce datele despre decolare, daca le cunosti. Daca nu, este OK sa inchizi aceasta fereastra");
define("_takeoff_add_help_2","Daca decolarea zborului tau este cea afisata deasupra 'Decolare necunoscuta' atunci nu este cazul sa o introduci din nou. Poti inchide aceasta fereastra. ");
define("_takeoff_add_help_3","Daca vezi dedesupt numele locului de decolare poti apsa pe el pentru a auto-completa campurile din dreapta.");
define("_Takeoff_Name","Nume decolare");
define("_In_Local_Language","In limba locala");
define("_In_English","In engleza");

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
define("_Requirements","Requirements"); 
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

http://%s?op=register&rkey=%s 

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

http://%s?op=send_password&rkey=%s 

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
define("_Layers","Layers"); 
define("_Select_Area","Select Area"); 
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
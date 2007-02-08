<? if (0){?><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2"></head><? }?><?php

/************************************************************************/
/* Leonardo: Gliding XC Server                                          */
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
$monthList=array('Januar','Februar','Marec','April','Maj','Junij',
'Julij','Avgust','September','Oktober','November','December');
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","Prosti prelet");
define("_FREE_TRIANGLE","Trikotnik");
define("_FAI_TRIANGLE","FAI trikotnik");

define("_SUBMIT_FLIGHT_ERROR","Pojavila se je težava pri nalaganju leta");

// list_pilots()
define("_NUM","#");
define("_PILOT","Pilot");
define("_NUMBER_OF_FLIGHTS","Število letov");
define("_BEST_DISTANCE","Najdaljši prosti prelet");
define("_MEAN_KM","Povprečno št. km na let");
define("_TOTAL_KM","Skupaj preletenih km");
define("_TOTAL_DURATION_OF_FLIGHTS","Skupno trajanje letov");
define("_MEAN_DURATION","Povprečno trajanje leta");
define("_TOTAL_OLC_KM","Skupna OLC razdalja");
define("_TOTAL_OLC_SCORE","Skupaj OLC točk");
define("_BEST_OLC_SCORE","Najboljši OLC rezultat");
define("_From","od");

// list_flights()
define("_DURATION_HOURS_MIN","Trajanje (u:m)");
define("_SHOW","Prikaži");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","Let bo aktiviran v 1-2 minutah. ");
define("_TRY_AGAIN","Prosim, ponovno poskusi kasneje");

define("_TAKEOFF_LOCATION","Vzletišče");
define("_TAKEOFF_TIME","Čas vzleta");
define("_LANDING_LOCATION","Pristanek");
define("_LANDING_TIME","Čas pristanka");
define("_OPEN_DISTANCE","Ravna razdalja");
define("_MAX_DISTANCE","Navečja razdalja");
define("_OLC_SCORE_TYPE","OLC disciplina");
define("_OLC_DISTANCE","OLC razdalja");
define("_OLC_SCORING","OLC točke");
define("_MAX_SPEED","Največja hitrost");
define("_MAX_VARIO","Največje dviganje");
define("_MEAN_SPEED","Povprečna hitrost");
define("_MIN_VARIO","Največje spuščanje");
define("_MAX_ALTITUDE","Dosežena višina (nm)");
define("_TAKEOFF_ALTITUDE","Višina vzletišča (nm)");
define("_MIN_ALTITUDE","Najmanjša višina (nm)");
define("_ALTITUDE_GAIN","Pridobljena višina");
define("_FLIGHT_FILE","Datoteka z letom");
define("_COMMENTS","Komentarji");
define("_RELEVANT_PAGE","URL povezane strani");
define("_GLIDER","Krilo");
define("_PHOTOS","Fotografije");
define("_MORE_INFO","Dodatno");
define("_UPDATE_DATA","Osveži podatke");
define("_UPDATE_MAP","Posodobi zemljevid");
define("_UPDATE_3D_MAP","Posodobi 3D zemljevid");
define("_UPDATE_GRAPHS","Posodobi grafe");
define("_UPDATE_SCORE","Posodobi rezultate");

define("_TAKEOFF_COORDS","Koordinate vzletišča");
define("_NO_KNOWN_LOCATIONS","Ni znanih lokacij!");
define("_FLYING_AREA_INFO","Informacije o področju letenja");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo XC strežnik");
define("_RETURN_TO_TOP","Nazaj na vrh");
// list flight
define("_PILOT_FLIGHTS","Pilotovi leti");

define("_DATE_SORT","Datum");
define("_PILOT_NAME","Ime pilota");
define("_TAKEOFF","Vzletišče");
define("_DURATION","Trajanje");
define("_LINEAR_DISTANCE","Ravna razdalja");
define("_OLC_KM","OLC km");
define("_OLC_SCORE","OLC točke");
define("_DATE_ADDED","Zadnje prijave");

define("_SORTED_BY","Urejeno po:");
define("_ALL_YEARS","Vsa leta");
define("_SELECT_YEAR_MONTH","Izberi leto (in mesec)");
define("_ALL","Vse");
define("_ALL_PILOTS","Prikaži vse pilote");
define("_ALL_TAKEOFFS","Prikaži vsa vzletišča");
define("_ALL_THE_YEAR","Celo leto");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","Nisi dodal datoteke z letom");
define("_NO_SUCH_FILE","Tvoje datoteke ni na strežniku");
define("_FILE_DOESNT_END_IN_IGC","Datoteka nima končnice .igc");
define("_THIS_ISNT_A_VALID_IGC_FILE","To ni veljavna IGC datoteka");
define("_THERE_IS_SAME_DATE_FLIGHT","Let z enakim datumom in časom že obstaja");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","Če jo želiš zamenjati, moraš najprej");
define("_DELETE_THE_OLD_ONE","zbrisati staro");
define("_THERE_IS_SAME_FILENAME_FLIGHT","Let z enakim imenom že obstaja");
define("_CHANGE_THE_FILENAME","Če je to drug let, prosim spremeni ime in poskusi ponovno");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","Tvoj let je naložen");
define("_PRESS_HERE_TO_VIEW_IT","Za pregled klikni tu");
define("_WILL_BE_ACTIVATED_SOON","(aktiviran bo v 1-2 minutah)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Prijava več letov");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","Obdelane bodo le IGC datoteke");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","Predloži ZIP datoteko<br>z leti");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","Za nalagnje letov klikni tukaj");

define("_FILE_DOESNT_END_IN_ZIP","Predložena datoteka nima končnice ZIP");
define("_ADDING_FILE","Nalagam datoteko");
define("_ADDED_SUCESSFULLY","Uspešno prijavljeno");
define("_PROBLEM","Težava pri OLC prijavljanju");
define("_TOTAL","Skupaj ");
define("_IGC_FILES_PROCESSED","Leti so bili obdelani");
define("_IGC_FILES_SUBMITED","leti so predloženi");

// info
define("_DEVELOPMENT","Razvoj");
define("_ANDREADAKIS_MANOLIS","Andreadakis Manolis");
define("_PROJECT_URL","Stran Projekta");
define("_VERSION","Verzija");
define("_MAP_CREATION","Map creation");
define("_PROJECT_INFO","Info o Projektu");

// menu bar 
define("_MENU_MAIN_MENU","Glavni meni");
define("_MENU_DATE","Izberi datum");
define("_MENU_COUNTRY","Izberi državo");
define("_MENU_XCLEAGUE","XC Liga");
define("_MENU_ADMIN","Admin");

define("_MENU_COMPETITION_LEAGUE","Liga - vse kategorije");
define("_MENU_OLC","OLC");
define("_MENU_OPEN_DISTANCE","Ravna razdalja");
define("_MENU_DURATION","Trajanje");
define("_MENU_ALL_FLIGHTS","Prikaži vse lete");
define("_MENU_FLIGHTS","Leti");
define("_MENU_TAKEOFFS","Vzletišča");
define("_MENU_FILTER","Filter");
define("_MENU_MY_FLIGHTS","Moji leti");
define("_MENU_MY_PROFILE","Moj profil");
define("_MENU_MY_STATS","Moja statistika"); 
define("_MENU_MY_SETTINGS","Moje nastavitve"); 
define("_MENU_SUBMIT_FLIGHT","Prijava leta");
define("_MENU_SUBMIT_FROM_ZIP","Prijava letov iz zipa");
define("_MENU_SHOW_PILOTS","Piloti");
define("_MENU_SHOW_LAST_ADDED","Prikaži zadnje prijave");
define("_FLIGHTS_STATS","Statistika letov");

define("_SELECT_YEAR","Izberi leto");
define("_SELECT_MONTH","Izberi mesec");
define("_ALL_COUNTRIES","Prikaži vse države");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","VSI LETI");
define("_NUMBER_OF_FLIGHTS","Število letov");
define("_TOTAL_DISTANCE","Skupna razdalja");
define("_TOTAL_DURATION","Skupno trajanje");
define("_BEST_OPEN_DISTANCE","Najdaljši prelet");
define("_TOTAL_OLC_DISTANCE","Skupna OLC razdalja");
define("_TOTAL_OLC_SCORE","Skupaj OLC točk");
define("_BEST_OLC_SCORE","Najboljši OLC rezultat");
define("_MEAN_DURATION","Povprečno trajanje");
define("_MEAN_DISTANCE","Povprečna razdalja");
define("_PILOT_STATISTICS_SORT_BY","Piloti - razvrščeno");
define("_CATEGORY_FLIGHT_NUMBER","Kategorija 'FastJoe' - Število letov");
define("_CATEGORY_TOTAL_DURATION","Kategorija 'DURACELL' - Skupno trajanje vseh letov");
define("_CATEGORY_OPEN_DISTANCE","Kategorija 'Ravna razdalja'");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","Ni nobenega pilota za prikaz!");


//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","Ta let je bil zbrisan");
define("_RETURN","Nazaj");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","POZOR - ta let boš zbisal");
define("_THE_DATE","Date ");
define("_YES","DA");
define("_NO","NE");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","Rezultati lige");
define("_N_BEST_FLIGHTS"," najboljših letov");
define("_OLC","OLC");
define("_OLC_TOTAL_SCORE","Skupaj OLC točke");
define("_KILOMETERS","Kilometri");
define("_TOTAL_ALTITUDE_GAIN","Skupaj pridobljena višina");
define("_TOTAL_KM","Skupaj km");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","je");
define("_IS_NOT","ni");
define("_OR","ali");
define("_AND","in");
define("_FILTER_PAGE_TITLE","Filter letov");
define("_RETURN_TO_FLIGHTS","Nazaj na lete");
define("_THE_FILTER_IS_ACTIVE","Filter je vključen");
define("_THE_FILTER_IS_INACTIVE","Filter je izključen");
define("_SELECT_DATE","Izberi datum");
define("_SHOW_FLIGHTS","Prikaži lete");
define("_ALL2","VSE");
define("_WITH_YEAR","Leto");
define("_MONTH","Mesec");
define("_YEAR","Leto");
define("_FROM","Od");
define("_from","od");
define("_TO","To");
define("_SELECT_PILOT","Izberi pilota");
define("_THE_PILOT","Pilot");
define("_THE_TAKEOFF","Vzletišče");
define("_SELECT_TAKEOFF","Izberi vzletišče");
define("_THE_COUNTRY","Država");
define("_COUNTRY","Država");
define("_SELECT_COUNTRY","Izberi državo");
define("_OTHER_FILTERS","Ostali filtri");
define("_LINEAR_DISTANCE_SHOULD_BE","Ravna razdalja naj bo");
define("_OLC_DISTANCE_SHOULD_BE","OLC razdalja naj bo");
define("_OLC_SCORE_SHOULD_BE","OLC rezultat naj bo");
define("_DURATION_SHOULD_BE","Trajanje naj bo");
define("_ACTIVATE_CHANGE_FILTER","Vključi / spremeni FILTER");
define("_DEACTIVATE_FILTER","Izključi FILTER");
define("_HOURS","ur");
define("_MINUTES","min");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","Prijava leta");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(potrebna je le IGC datoteka)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","Predloži <br>IGC datoteko leta");
define("_NOTE_TAKEOFF_NAME","Prosim, zapiši ime in državo vzletišča");
define("_COMMENTS_FOR_THE_FLIGHT","Komentarji za ta let");
define("_PHOTO","Fotografija");
define("_PHOTOS_GUIDELINES","Fotografije naj bodo v jpg formatu in manjše od 100k");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","Za nalagnje leta klikni tukaj");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","Želiš predložiti več letov naenkrat?");
define("_PRESS_HERE","Klikni tukaj");

define("_IS_PRIVATE","Ne prikaži javno");
define("_MAKE_THIS_FLIGHT_PRIVATE","Ne prikaži javno");
define("_INSERT_FLIGHT_AS_USER_ID","Vstavi let kot uporabniški ID");
define("_FLIGHT_IS_PRIVATE","To je zasebni let");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","Spremeni podatke o letu");
define("_IGC_FILE_OF_THE_FLIGHT","IGC datoteka leta");
define("_DELETE_PHOTO","Zbriši");
define("_NEW_PHOTO","nova slika");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","Za spremembo podatkov o letu klikni tukaj");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","Spremembe so uveljavljene");
define("_RETURN_TO_FLIGHT","Nazaj na let");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","Nazaj na let");
define("_READY_FOR_SUBMISSION","Pripravljena za prijavo");
define("_SUBMIT_TO_OLC","Prijavi na OLC");
define("_YOUR_FLIGHT_HAS_BEEN_SUCCESSFULLY_SUBMITED_TO_THE_OLC","Ta let je bil uspešno prijavljen na OLC");
define("_THE_OLC_REFERENCE_NUMBER_IS","OLC referenčna številka je");
define("_THERE_WAS_A_PROBLEM_ON_OLC_SUBMISSION","Težava pri OLC prijavljanju");
define("_LOOK_BELOW_FOR_THE_CAUSE_OF_THE_PROBLEM","Poglej spodaj, kaj je vzrok težave");
define("_FLIGHT_SUCCESFULLY_REMOVED_FROM_OLC","Ta let je bil uspešno odstranjen z OLC");
define("_FLIGHT_NOT_SCORED","Ta let nima OLC točk in torej ne more biti prijavljen");
define("_TOO_LATE","Rok za ta let je potekel in torej ne more biti prijavljen");
define("_CANNOT_BE_SUBMITTED","Rok za ta let je potekel");
define("_NO_PILOT_OLC_DATA","<p><strong>Ni OLC podatkov za pilota</strong><br>
  <br>
<b>kaj je OLC / čemu so ta polja ?</b><br><br>
Za veljavno prijavo na OLC mora biti pilot že registriran v sistemu OLC.</p>
<p> To se lahko opravi <a href='http://www2.onlinecontest.org/olcphp/2005/ausw_wertung.php?olc=holc-i&spr=en' target='_blank'>
  na tej strani</a>, kjer moraš izbrati svojo državo in nato 'Contest Registration'<br>
</p>
<p>Ko je registracija opravljena, greš v Leonardu na 'Profil pilota'->'Uredi OLC info' in vnesi svoje podatke ENAKO kot si jih vnesel/vnesla ob registraciji v OLC
</p>
<ul>
<li><div align=left>Ime</div>
<li><div align=left>Priimek</div>
<li><div align=left>Rojstni datum</div>
<li> <div align=left>Klicni znak</div>
<li><div align=left>Če si že prijavljal/la lete na OLC, vpiši 4 črke, ki jih uporabljaš za lastno oznako v imenu IGC datoteke</div>
</ul>");
define("_OLC_MAP","Zemljevid");
define("_OLC_BARO","Barograf");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","Profil pilota");
define("_back_to_flights","Nazaj na lete");
define("_pilot_stats","Statistika pilota");
define("_edit_profile","Uredi profil");
define("_flights_stats","Statistika letov");
define("_View_Profile","View Profile");

define("_Personal_Stuff","Osebni podatki");
define("_First_Name","Ime");
define("_Last_Name","Priimek");
define("_Birthdate","Rojstni datum");
define("_dd_mm_yy","dd.mm.ll");
define("_Sign","Znak");
define("_Marital_Status","Zakonski stan");
define("_Occupation","Poklic");
define("_Web_Page","Spletna stran");
define("_N_A","Ni na voljo");
define("_Other_Interests","Ostali interesi");
define("_Photo","Fotografija");

define("_Flying_Stuff","O letenju");
define("_note_place_and_date","če se da, zapiši državo in datum");
define("_Flying_Since","Leti od");
define("_Pilot_Licence","Licenca pilota");
define("_Paragliding_training","Jadralnopadalsko urjenje");
define("_Favorite_Location","Najljubša lokacija");
define("_Usual_Location","Običajna lokacija");
define("_Best_Flying_Memory","Najboljši letalni spomin");
define("_Worst_Flying_Memory","Najslabši letalni spomin");
define("_Personal_Distance_Record","Osebni dolžinski rekord");
define("_Personal_Height_Record","Osebni višinski rekord");
define("_Hours_Flown","Ur letenja");
define("_Hours_Per_Year","Ur na leto");

define("_Equipment_Stuff","Oprema");
define("_Glider","Krilo");
define("_Harness","Sedež");
define("_Reserve_chute","Rezervno padalo");
define("_Camera","Kamera");
define("_Vario","Vario");
define("_GPS","GPS");
define("_Helmet","Čelada");
define("_Camcorder","Kamkorder");

define("_Manouveur_Stuff","Manevri");
define("_note_max_descent_rate","če se da, zapiši najhitrejše doseženo spuščanje");
define("_Spiral","Spirala");
define("_Bline","B Stall");
define("_Full_Stall","Full Stall");
define("_Other_Manouveurs_Acro","Ostali Akro manevri");
define("_Sat","SAT");
define("_Asymmetric_Spiral","Asimetrična spirala");
define("_Spin","Spin");

define("_General_Stuff","Splošno");
define("_Favorite_Singer","Naljubši/a pevec/ka");
define("_Favorite_Movie","Najljubši film");
define("_Favorite_Internet_Site","Najljubša<br>spletna stran");
define("_Favorite_Book","Najljubša knjiga");
define("_Favorite_Actor","Najljubši igralec/ka");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","Naloži novo sliko ali popravi staro");
define("_Delete_Photo","Zbriši sliko");
define("_Your_profile_has_been_updated","Tvoj profil je obnovljen");
define("_Submit_Change_Data","Podaj - spremeni podatke");

//--------------------------------------------
// pilot_ďlc_profile_edit.php
//--------------------------------------------
define("_edit_OLC_info","Uredi OLC info");
define("_OLC_information","OLC info");
define("_callsign","Klicni znak");
define("_filename_suffix","Končnica datoteke");
define("_OLC_Pilot_Info","OLC info o pilotu");
define("_OLC_EXPLAINED","<b>kaj je OLC / čemu so ta polja ?</b><br><br>
Za veljavno prijavo na OLC mora biti pilot že registriran v sistemu OLC.</p>
<p> To se lahko opravi <a href='http://www2.onlinecontest.org/olcphp/2005/ausw_wertung.php?olc=holc-i&spr=en' target='_blank'>
  na tej strani</a>, kjer moraš izbrati svojo državo in nato 'Contest Registration'<br>
</p>
<p>Ko je registracija opravljena, greš v Leonardu na 'Profil pilota'->'Uredi OLC info' in vnesi svoje podatke ENAKO kot si jih vnesel/vnesla ob registraciji v OLC
</p>
<ul>
<li><div align=left>Ime</div>
<li><div align=left>Priimek</div>
<li><div align=left>Rojstni datum</div>
<li> <div align=left>Klicni znak</div>
<li><div align=left>Če si že prijavljal/la lete na OLC, vpiši 4 črke, ki jih uporabljaš za lastno oznako v imenu IGC datoteke</div>
</ul>
");

define("_OLC_SUFFIX_EXPLAINED","<b>Kaj je 'končnica datoteke' (filename suffix)?</b><br>To je 4 znakovna unikatna oznaka vsakega pilota ali krila. 
Če res ne veš kaj vnesti, je tu nekaj namigov:<p>
<ul>
<li>Uporabi 4 črke svojega imena / priimka
<li>Poskusi najti kombinaciji, ki zveni dovolj nenavadno. To precej zmanjša možnosti da bi bila oznaka enaka kot pri kakem drugem pilotu
<li>Če imaš težave s prijavo leta na OLC skozi Leonarda, je to lahko zaradi oznake. Spremeni oznako in ponovno poskusi.
</ul>");

//
//
//
//
//
//
//
//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","uu:mm");

define("_Totals","Skupaj");
define("_First_flight_logged","Prvi zabeležen let");
define("_Last_flight_logged","Zadnji zabeležen let");
define("_Flying_period_covered","Zajeto obdobje");
define("_Total_Distance","Skupna razdalja");
define("_Total_OLC_Score","Skupaj OLC točk");
define("_Total_Hours_Flown","Skupaj preletenih ur");
define("_Total_num_of_flights","Skupno število letov ");

define("_Personal_Bests","Osebni dosežki");
define("_Best_Open_Distance","Najdaljša ravna razdalja");
define("_Best_FAI_Triangle","Najboljši FAI trikotnik");
define("_Best_Free_Triangle","Najboljši trikotnik");
define("_Longest_Flight","Najdaljši let");
define("_Best_OLC_score","Najboljši OLC rezultat");

define("_Absolute_Height_Record","Absolutni višinski rekord");
define("_Altitute_gain_Record","Rekord v pridobljeni višini");
define("_Mean_values","Povprečne vrednosti");
define("_Mean_distance_per_flight","Povprečna razdalja na let");
define("_Mean_flights_per_Month","Povprečno letov na mesec");
define("_Mean_distance_per_Month","Povprečna razdalja na mesec");
define("_Mean_duration_per_Month","Povprečno trajanje na mesec");
define("_Mean_duration_per_flight","Povprečno trajanje na let");
define("_Mean_flights_per_Year","Povprečno letov na leto");
define("_Mean_distance_per_Year","Povprečna razdalja na leto");
define("_Mean_duration_per_Year","Povprečno trajanje na leto");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","Poglej lete blizu te točke");
define("_Waypoint_Name","Waypoint Name");
define("_Navigate_with_Google_Earth","Poglej v Google Earth");
define("_See_it_in_Google_Maps","Poglej v Google Maps");
define("_See_it_in_MapQuest","Poglej v MapQuest");
define("_COORDINATES","Koordinate");
define("_FLIGHTS","Leti");
define("_SITE_RECORD","Rekord kraja");
define("_SITE_INFO","Informacije o kraju");
define("_SITE_REGION","Regija");
define("_SITE_LINK","Povezava do več informacij");
define("_SITE_DESCR","Opis vzletišča/kraja");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","Poglej podrobnosti");
define("_KML_file_made_by","KML je naredil");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","Registriraj vzletišče");
define("_WAYPOINT_ADDED","Vzletišče je bilo registrirano!");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","Rekord vzletišča<br>(ravna razdalja)");

//--------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","Vrsta krila");
function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'Jadralno padalo',2=>'Zmaj FAI1',4=>'Zmaj, trdokrilec FAI5',8=>'Jadralno letalo');
	foreach ($CONF_glider_types as $gId=>$gName) if (!$gliderCatList[$gId]) $gliderCatList[$gId]=$gName;
}
setGliderCats();

//--------------------------------------------
// user prefs  & units
//--------------------------------------------

define("_Your_settings_have_been_updated","Tvoje nastavitve so obnovljene");

define("_THEME","Tema");
define("_LANGUAGE","Jezik");
define("_VIEW_CATEGORY","Prikaz kategorije");
define("_VIEW_COUNTRY","Prikaz države");
define("_UNITS_SYSTEM" ,"Enotni sistem");
define("_METRIC_SYSTEM","Metrični (km, m)");
define("_IMPERIAL_SYSTEM","Imperialni (milje, čevlji)");
define("_ITEMS_PER_PAGE","Vrstic na stran");

define("_MI","mi");
define("_KM","km");
define("_FT","ft");
define("_M","m");
define("_MPH","mph");
define("_KM_PER_HR","km/h");
define("_FPM","fpm");
define("_M_PER_SEC","m/sek");

//--------------------------------------------
// index page
//--------------------------------------------

define("_WORLD_WIDE","Ves Svet");
define("_National_XC_Leagues_for","Nacionalna XC liga za");
define("_Flights_per_Country","Leti po državi");
define("_Takeoffs_per_Country","Vzletišča po državi");
define("_INDEX_HEADER","Dobrodošli v Leonardo XC ligo");
define("_INDEX_MESSAGE","Za navigacijo lahko uporabiš &quot;Glavni meni&quot; ali pa uporabi osnovne možnosti prikazane spodaj.");

//--------------------------------------------
// NEW 
//--------------------------------------------
define("_MENU_SUMMARY_PAGE","Prva (skupna) stran");
define("_Display_ALL","Prikaži VSE");
define("_Display_NONE","Ne prikaži NIČ");
define("_Reset_to_default_view","Povrni privzet pogled");
define("_No_Club","Brez kluba");
define("_This_is_the_URL_of_this_page","To je URL te strani");
define("_All_glider_types","Vse vrste kril");

define("_MENU_SITES_GUIDE","Vodič po letalnih področjih");
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

?>
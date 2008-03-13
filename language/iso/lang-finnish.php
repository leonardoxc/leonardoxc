<?php

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
	$monthList=array('Tammikuu','Helmikuu','Maaliskuu','Huhtikuu','Toukokuu','Kesäkuu',
					'Heinäkuu','Elokuu','Syyskuu','Lokakuu','Marraskuu','Joulukuu');
	$monthListShort=array('TAMMI','HELMI','MAALIS','HUHTI','TOUKO','KESÄ','HEINÄ','ELO','SYYS','LOKA','MARRAS','JOULU');
	$weekdaysList=array('Ma','Ti','Ke','To','Pe','La','Su') ;
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","Vapaa matkalento");
define("_FREE_TRIANGLE","Vapaa kolmio");
define("_FAI_TRIANGLE","FAI kolmio");

define("_SUBMIT_FLIGHT_ERROR","Lennon tallentamisessa tapahtui virhe");

// list_pilots()
define("_NUM","#");
define("_PILOT","Pilotti");
define("_NUMBER_OF_FLIGHTS","Matkalentojen lukumäärä");
define("_BEST_DISTANCE","Matkaennätys");
define("_MEAN_KM","Matkan keskipituus # km per lento");
define("_TOTAL_KM","Matkojen pituus yhteensä");
define("_TOTAL_DURATION_OF_FLIGHTS","Lentoaika yhteensä");
define("_MEAN_DURATION","Keskimääräinen lentoaika");
define("_TOTAL_OLC_KM","OLC matka yhteensä");
define("_TOTAL_OLC_SCORE","OLC yhteispisteet");
define("_BEST_OLC_SCORE","OLC piste-ennätys");
define("_From","Alkaen");

// list_flights()
define("_DURATION_HOURS_MIN","Lentoaika (h:m)");
define("_SHOW","Näytä");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","Lento aktivoituu 1-2 minuutin kuluessa. ");
define("_TRY_AGAIN","Yritä myöhemmin uudestaan.");
define("_SEASON","KAUSI");
define("_TAKEOFF_LOCATION","Lähtöpaikka");
define("_TAKEOFF_TIME","Lähtöaika");
define("_LANDING_LOCATION","Laskupaikka");
define("_LANDING_TIME","Laskuaika");
define("_OPEN_DISTANCE","Vapaa matka");
define("_MAX_DISTANCE","Maksimi matka");
define("_OLC_SCORE_TYPE","OLC tyyppi");
define("_OLC_DISTANCE","OLC matka");
define("_OLC_SCORING","OLC pisteet");
define("_MAX_SPEED","Suurin nopeus");
define("_MAX_VARIO","Suurin laskeva");
define("_MEAN_SPEED","Keskinopeus");
define("_MIN_VARIO","Suurin nouseva");
define("_MAX_ALTITUDE","Suurin korkeus (ASL)");
define("_TAKEOFF_ALTITUDE","Lähtökorkeus (ASL)");
define("_MIN_ALTITUDE","Pienin korkeus (ASL)");
define("_ALTITUDE_GAIN","Korkeuden lisäys");
define("_FLIGHT_FILE","Lennon tiedosto");
define("_COMMENTS","Huomautuksia");
define("_RELEVANT_PAGE","Lisätietoja (URL)");
define("_GLIDER","Liidin");
define("_PHOTOS","Valokuvia");
define("_MORE_INFO","Lisätietoja");
define("_UPDATE_DATA","Päivitä tiedot");
define("_UPDATE_MAP","Päivitä kartta");
define("_UPDATE_3D_MAP","Päivitä 3D kartta");
define("_UPDATE_GRAPHS","Päivitä kaaviot");
define("_UPDATE_SCORE","Päivitä pisteet");

define("_TAKEOFF_COORDS","Lentopaikan koordinaatit:");
define("_NO_KNOWN_LOCATIONS","Ei tunnettuja kohteita!");
define("_FLYING_AREA_INFO","Tietoja lentoalueesta");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo XC");
define("_RETURN_TO_TOP","Palaa ylös");
// list flight
define("_PILOT_FLIGHTS","Lennot");

define("_DATE_SORT","Pvm");
define("_PILOT_NAME","Pilotin nimi");
define("_TAKEOFF","Lentopaikka");
define("_DURATION","Lentoaika");
define("_LINEAR_DISTANCE","Vapaa matka");
define("_OLC_KM","OLC matka");
define("_OLC_SCORE","OLC pisteet");
define("_DATE_ADDED","Viimeksi tallennetut");

define("_SORTED_BY","Lajittele:");
define("_ALL_YEARS","Kaikki vuodet");
define("_SELECT_YEAR_MONTH","Valitse vuosi (ja kuukausi)");
define("_ALL","Kaikki");
define("_ALL_PILOTS","Näytä kaikki pilotit");
define("_ALL_TAKEOFFS","Näytä kaikki lentopaikat");
define("_ALL_THE_YEAR","Koko vuosi");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","Lennon tiedosto puuttuu");
define("_NO_SUCH_FILE","Tiedostoa ei löydy palvelimelta");
define("_FILE_DOESNT_END_IN_IGC","Tiedostopäätteen pitää olla .igc");
define("_THIS_ISNT_A_VALID_IGC_FILE","Tiedosto ei ole validi .igc tiedosto");
define("_THERE_IS_SAME_DATE_FLIGHT","Lento jolla on sama päivämäärä ja kellonaika on jo tallennettu");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","Jos haluat korvata sen uudella tiedostolla");
define("_DELETE_THE_OLD_ONE","niin poista ensin vanha tiedosto");
define("_THERE_IS_SAME_FILENAME_FLIGHT","Lento jolla on sama tiedostonimi on jo tallennettu");
define("_CHANGE_THE_FILENAME","Jos tämä on eri lento, niin vaihda tiedoston nimi ja yritä tallennusta uudestaan");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","Lentosi on tallennettu");
define("_PRESS_HERE_TO_VIEW_IT","Paina tästä katsoaksesi lentoa");
define("_WILL_BE_ACTIVATED_SOON","(lento aktivoituu 1-2 minuutin kuluessa)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Tallenna useita lentoja");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","Vain IGC tiedostot käsitellään");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","Tallenna ZIP tiedosto<br>jossa lennot ovat");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","Paina tästä tallentaaksesi lennot");

define("_FILE_DOESNT_END_IN_ZIP","Tiedostopäätteen pitää olla .zip");
define("_ADDING_FILE","Tiedostoa tallennetaan");
define("_ADDED_SUCESSFULLY","Tiedosto tallennettu");
define("_PROBLEM","Ongelmatilanne");
define("_TOTAL","Yhteensä ");
define("_IGC_FILES_PROCESSED","tiedostoa on käsitelty");
define("_IGC_FILES_SUBMITED","lentoa on tallennettu");

// info
define("_DEVELOPMENT","Kehittänyt");
define("_ANDREADAKIS_MANOLIS","Andreadakis Manolis");
define("_PROJECT_URL","Projektin sivut");
define("_VERSION","Versio");
define("_MAP_CREATION","Karttojen luonti");
define("_PROJECT_INFO","Tietoa projektista");

// menu bar 
define("_MENU_MAIN_MENU","Päävalikko");
define("_MENU_DATE","Valitse päivä");
define("_MENU_COUNTRY","Valitse maa");
define("_MENU_XCLEAGUE","XC Liiga");
define("_MENU_ADMIN","Admin");

define("_MENU_COMPETITION_LEAGUE","Liiga - kaikki luokat");
define("_MENU_OLC","OLC");
define("_MENU_OPEN_DISTANCE","Vapaa matka");
define("_MENU_DURATION","Lentoaika");
define("_MENU_ALL_FLIGHTS","Näytä kaikki lennot");
define("_MENU_FLIGHTS","Näytä lennot");
define("_MENU_TAKEOFFS","Näytä lentopaikat");
define("_MENU_FILTER","Valinnat");
define("_MENU_MY_FLIGHTS","Omat lennot");
define("_MENU_MY_PROFILE","Oma profiili");
define("_MENU_MY_STATS","Omat tilastot"); 
define("_MENU_MY_SETTINGS","Omat asetukset"); 
define("_MENU_SUBMIT_FLIGHT","Tallenna lento");
define("_MENU_SUBMIT_FROM_ZIP","Tallenna useita lentoja");
define("_MENU_SHOW_PILOTS","Näytä pilotit");
define("_MENU_SHOW_LAST_ADDED","Näytä viimeksi tallennetut");
define("_FLIGHTS_STATS","Lentotilastot");

define("_SELECT_YEAR","Valitse vuosi");
define("_SELECT_MONTH","Valitse kuukausi");
define("_ALL_COUNTRIES","Näytä kaikki maat");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","Kaikki yhteensä");
define("_NUMBER_OF_FLIGHTS","Lentojen lkm");
define("_TOTAL_DISTANCE","Matkat yhteensä");
define("_TOTAL_DURATION","Lentoaika yhteensä");
define("_BEST_OPEN_DISTANCE","Pisin matka");
define("_TOTAL_OLC_DISTANCE","OLC matka yhteensä");
define("_TOTAL_OLC_SCORE","OLC pisteet yhteensä");
define("_BEST_OLC_SCORE","Parhaat OLC pisteet");
define("_MEAN_DURATION","Keskimääräinen lentoaika");
define("_MEAN_DISTANCE","Keskimääräinen matka");
define("_PILOT_STATISTICS_SORT_BY","Pilotit - Lajittele");
define("_CATEGORY_FLIGHT_NUMBER","Lentojen lukumäärän mukaan");
define("_CATEGORY_TOTAL_DURATION","Lentojen yhteisajan mukaan");
define("_CATEGORY_OPEN_DISTANCE","Matkan pituuden mukaan");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","Pilotteja ei löytynyt");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","Lento on poistettu");
define("_RETURN","Takaisin");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","HUOM! - Olet poistamassa lentoa");
define("_THE_DATE","Pvm ");
define("_YES","POISTA");
define("_NO","PERUUTA");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","Liigan tulokset");
define("_N_BEST_FLIGHTS"," parasta lentoa");
define("_OLC","OLC");
define("_OLC_TOTAL_SCORE","OLC yhteispisteet");
define("_KILOMETERS","Kilometriä");
define("_TOTAL_ALTITUDE_GAIN","Korkeuden lisäys yhteensä");
define("_TOTAL_KM","Matka yhteensä");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","on");
define("_IS_NOT","ei ole");
define("_OR","tai");
define("_AND","ja");
define("_FILTER_PAGE_TITLE","Valitse lennot");
define("_RETURN_TO_FLIGHTS","Palaa lentoihin");
define("_THE_FILTER_IS_ACTIVE","Valinnat päällä");
define("_THE_FILTER_IS_INACTIVE","Valinnat pois päältä");
define("_SELECT_DATE","Valitse päivä");
define("_SHOW_FLIGHTS","Näytä lennot");
define("_ALL2","Kaikki");
define("_WITH_YEAR","Vuodesta");
define("_MONTH","Kuukausi");
define("_YEAR","Vuosi");
define("_FROM","Alkaen");
define("_from","alkaen");
define("_TO","Päättyen");
define("_SELECT_PILOT","Valitse pilotti");
define("_THE_PILOT","Pilotti");
define("_THE_TAKEOFF","Lentopaikka");
define("_SELECT_TAKEOFF","Valitse lentopaikka");
define("_THE_COUNTRY","Maa");
define("_COUNTRY","Maa");
define("_SELECT_COUNTRY","Valitse Maa");
define("_OTHER_FILTERS","Muut valinnat");
define("_LINEAR_DISTANCE_SHOULD_BE","Vapaa matka");
define("_OLC_DISTANCE_SHOULD_BE","OLC matka");
define("_OLC_SCORE_SHOULD_BE","OLC pisteet");
define("_DURATION_SHOULD_BE","Lentoaika");
define("_ACTIVATE_CHANGE_FILTER","Valinnat päälle");
define("_DEACTIVATE_FILTER","Valinnat pois");
define("_HOURS","tuntia");
define("_MINUTES","minuuttia");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","Tallenna lento");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(ainoastaan IGC tiedosto vaaditaan)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","Tallenna<br>lennon IGC tiedosto");
define("_NOTE_TAKEOFF_NAME","Merkitse lentopaikan nimi, sijainti ja maa");
define("_COMMENTS_FOR_THE_FLIGHT","Huomautuksia");
define("_PHOTO","Kuva");
define("_PHOTOS_GUIDELINES","Kuvien tulee olla jpg muodossa ja pienempiä kuin ");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","Paina tästä tallentaaksesi lennon");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","Haluatko tallentaa useita lentoja kerrallaan?");
define("_PRESS_HERE","Paina tästä");

define("_IS_PRIVATE","Älä julkaise");
define("_MAKE_THIS_FLIGHT_PRIVATE","Älä julkaise");
define("_INSERT_FLIGHT_AS_USER_ID","Tallenna lento käyttäjätunnuksella");
define("_FLIGHT_IS_PRIVATE","Älä julkaise");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","Muuta lennon tietoja");
define("_IGC_FILE_OF_THE_FLIGHT","Lennon IGC tiedosto");
define("_DELETE_PHOTO","Poista");
define("_NEW_PHOTO","uusi kuva");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","Paina tästä muuttaaksesi lennon tietoja");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","Muutokset tallennettu");
define("_RETURN_TO_FLIGHT","Palaa takaisin lennon tietoihin");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","Palaa takaisin lennon tietoihin");
define("_READY_FOR_SUBMISSION","Valmis tallentamaan");
define("_SUBMIT_TO_OLC","Tallenna OLC:hen");
define("_OLC_MAP","Kartta");
define("_OLC_BARO","Barografi");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","Pilotin tiedot");
define("_back_to_flights","palaa lentoihin");
define("_pilot_stats","pilotin tilastot");
define("_edit_profile","muuta tietoja");
define("_flights_stats","lentojen tilastot");
define("_View_Profile","Näytä tiedot");

define("_Personal_Stuff","Henkilötiedot");
define("_First_Name","Etunimi");
define("_Last_Name","Sukunimi");
define("_Birthdate","Syntymäaika");
define("_dd_mm_yy","pp.kk.vv");
define("_pilot_email","Sähköpostiosoite");
define("_Sign","Horoskooppimerkki");
define("_Marital_Status","Siviilisääty");
define("_Occupation","Ammatti");
define("_Web_Page","Web sivu");
define("_N_A","N/A");
define("_Other_Interests","Muut kiinnostuksen kohteet");
define("_Photo","Kuva");

define("_Flying_Stuff","Lentohistoria");
define("_note_place_and_date","lisää aika ja paikka tarpeen mukaan");
define("_Flying_Since","Aloittanut ilmailun");
define("_Pilot_Licence","Lentolupakirja");
define("_Paragliding_training","Koulutus liitimelle");
define("_Favorite_Location","Mieluiten lennän (paikka)");
define("_Usual_Location","Yleensä lennän (paikka)");
define("_Best_Flying_Memory","Paras lentomuistoni");
define("_Worst_Flying_Memory","Huonoin lentomuistoni");
define("_Personal_Distance_Record","Matkaennätys");
define("_Personal_Height_Record","Oma korkeusennätys");
define("_Hours_Flown","Tiimaa yhteensä");
define("_Hours_Per_Year","Tiimaa / vuosi");

define("_Equipment_Stuff","Varusteet");
define("_Glider","Liidin");
define("_Harness","Valjaat");
define("_Reserve_chute","Pelastusvarjo");
define("_Camera","Kamera");
define("_Vario","Variometri");
define("_GPS","GPS");
define("_Helmet","Kypärä");
define("_Camcorder","Videokamera");

define("_Manouveur_Stuff","Acroilut");
define("_note_max_descent_rate","lisää maksimi vajoama tarpeen mukaan");
define("_Spiral","Spiraali");
define("_Bline","B sakkaus");
define("_Full_Stall","Täyssakkaus");
define("_Other_Manouveurs_Acro","Muut Acro harjoitukset");
define("_Sat","Sat");
define("_Asymmetric_Spiral","Asymmetric Spiral");
define("_Spin","Spin");

define("_General_Stuff","Muuta");
define("_Favorite_Singer","Lempilaulaja/yhtye");
define("_Favorite_Movie","Lempielokuva");
define("_Favorite_Internet_Site","Lempi<br>Internet sivusto");
define("_Favorite_Book","Lempikirja");
define("_Favorite_Actor","Lempinäyttelijä");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","Tallenna uusi kuva tai muuta vanhaa");
define("_Delete_Photo","Poista kuva");
define("_Your_profile_has_been_updated","Tietosi on tallennettu");
define("_Submit_Change_Data","Vahvista");

//--------------------------------------------
// Added by Martin Jursa, 26.04.2007 for pilot_profile and pilot_profile_edit
//--------------------------------------------
define("_Sex", "Sukupuoli");
define("_Login_Stuff", "Muuta käyttäjätunnuksen tietoja");
define("_PASSWORD_CONFIRMATION", "Vahvista salasana");
define("_EnterPasswordOnlyToChange", "anna salasana vain jos haluat muuttaa sitä:");

define("_PwdAndConfDontMatch", "Salasana ei täsmää.");
define("_PwdTooShort", "Salasana on liian lyhyt. Salasanan pituus täytyy olla vähintään $passwordMinLength merkkiä.");
define("_PwdConfEmpty", "Vahvista salasana.");
define("_PwdChanged", "Salasana on muutettu.");
define("_PwdNotChanged", "Salasanaa EI OLE muutettu.");
define("_PwdChangeProblem", "Salasanan vaihdossa tapahtui virhe.");

define("_EmailEmpty", "Sähköpostiosoite täytyy antaa.");
define("_EmailInvalid", "Sähköpostiosoite ei ole validi.");
define("_EmailSaved", "Sähköpostiosoite on tallenettu");
define("_EmailNotSaved", "Sähköpostiosoitetta ei ole tallennettu.");
define("_EmailSaveProblem", "Sähköpostiosoitteen tallentamisessa tapahtui virhe.");

// End 26.04.2007

//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","hh:mm");

define("_Totals","Yhteenveto");
define("_First_flight_logged","Ensimmäinen lento tallennettu");
define("_Last_flight_logged","Viimeinen lento tallennettu");
define("_Flying_period_covered","Lentokausi");
define("_Total_Distance","Matkat yhteensä");
define("_Total_OLC_Score","OLC pisteet yhteensä");
define("_Total_Hours_Flown","Lentoaika yhteensä");
define("_Total_num_of_flights","Lentojen lkm yhteensä ");

define("_Personal_Bests","Henkilökohtaiset parhaat");
define("_Best_Open_Distance","Paras vapaa matka");
define("_Best_FAI_Triangle","Paras FAI kolmio");
define("_Best_Free_Triangle","Paras vapaa kolmio");
define("_Longest_Flight","Pisin lento");
define("_Best_OLC_score","Parhaat OLC pisteet");

define("_Absolute_Height_Record","Suurin absoluuttinen korkeus");
define("_Altitute_gain_Record","Suurin korkeuden lisäys");
define("_Mean_values","Keskiarvot");
define("_Mean_distance_per_flight","Matkan pituus per lento");
define("_Mean_flights_per_Month","Lentoja kuukaudessa");
define("_Mean_distance_per_Month","Matkan pituus kuukaudessa");
define("_Mean_duration_per_Month","Lentoaika kuukaudessa");
define("_Mean_duration_per_flight","Lentoaika per lento");
define("_Mean_flights_per_Year","Lentojen lkm vuodessa");
define("_Mean_distance_per_Year","Matkan pituus vuodessa");
define("_Mean_duration_per_Year","Lentoaika vuodessa");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","Näytä lennot lähellä tätä paikkaa");
define("_Waypoint_Name","Lentopaikan nimi");
define("_Navigate_with_Google_Earth","Suunnista käyttäen Google Earthia");
define("_See_it_in_Google_Maps","Näytä Google Maps ohjelmassa");
define("_See_it_in_MapQuest","Näytä MapQuest ohjelmassa");
define("_COORDINATES","Koordinaatit");
define("_FLIGHTS","Lennot");
define("_SITE_RECORD","Lentopaikan ennätys");
define("_SITE_INFO","Tietoja lentopaikasta");
define("_SITE_REGION","Alue");
define("_SITE_LINK","Lisätietoja tästä linkistä");
define("_SITE_DESCR","Lentopaikan kuvaus");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","Lisätietoja");
define("_KML_file_made_by","KML tiedoston tuotti");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","Lisää lentopaikka");
define("_WAYPOINT_ADDED","Lentopaikka on lisätty");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","Lentopaikan ennätys<br>(vapaa matka)");
	
//--------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","Liitimen tyyppi");
function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'Varjoliidin',2=>'Flex wing FAI1',4=>'Rigid wing FAI5',8=>'Muu liidin',16=>'Paramoottori');
	foreach ($CONF_glider_types as $gId=>$gName) if (!$gliderCatList[$gId]) $gliderCatList[$gId]=$gName;
}
setGliderCats();

//--------------------------------------------
// user prefs  & units
//--------------------------------------------

define("_Your_settings_have_been_updated","Your settings have been updated");

define("_THEME","Teema");
define("_LANGUAGE","Kieli");
define("_VIEW_CATEGORY","Näytä ryhmä");
define("_VIEW_COUNTRY","Näytä maa");
define("_UNITS_SYSTEM" ,"Mittajärjestelmä");
define("_METRIC_SYSTEM","Metrinen (km,m)");
define("_IMPERIAL_SYSTEM","Imperiaalinen (miles,feet)");
define("_ITEMS_PER_PAGE","Kohteita per sivu");

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

define("_WORLD_WIDE","Globaali");
define("_National_XC_Leagues_for","Kansalliset XC liigat");
define("_Flights_per_Country","Lentoja per maa");
define("_Takeoffs_per_Country","Lentopaikkoja per maa");
define("_INDEX_HEADER","Tervetuloa Leonardo XC liigaan");
define("_INDEX_MESSAGE","Kohdasta &quot;Main menu&quot; löydät tärkeimmät valinnat.");

//--------------------------------------------
// NEW 
//--------------------------------------------
define("_MENU_SUMMARY_PAGE","Yhteenveto tuloksista");
define("_Display_ALL","Näytä kaikki");
define("_Display_NONE","Piilota kaikki");
define("_Reset_to_default_view","Palauta oletusnäkymä");
define("_No_Club","Ei kerhoa");
define("_This_is_the_URL_of_this_page","Tämän sivun linkki(URL)");
define("_All_glider_types","Kaikki liidintyypit");

define("_MENU_SITES_GUIDE","Lentopaikkaopas");
define("_Site_Guide","Lentopaikkaopas");

define("_Search_Options","Hakuvalinnat");
define("_Below_is_the_list_of_selected_sites","Valitut lentopaikat");
define("_Clear_this_list","Tyhjennä lista");
define("_See_the_selected_sites_in_Google_Earth","Näytä valitut lentopaikat Google Earthissa");
define("_Available_Takeoffs","Listatut lentopaikat");
define("_Search_site_by_name","Hae lentopaikan nimellä");
define("_give_at_least_2_letters","Vähintään 2 merkkiä");
define("_takeoff_move_instructions_1","Voit siirtää listatut lentopaikat valitut lentopaikat listalle painamalla >> tai yksi kerrallaan painamalla > ");
define("_Takeoff_Details","Lentopaikan tarkat tiedot");


define("_Takeoff_Info","Tietoa lentopaikasta");
define("_XC_Info","Tietoa matkalennoista");
define("_Flight_Info","Tietoa lennoista");

define("_MENU_LOGOUT","Kirjaudu ulos");
define("_MENU_LOGIN","Kirjaudu sisään");
define("_MENU_REGISTER","Rekisteröidy");
define("_PROJECT_HELP","Kysymyksiä");
define("_PROJECT_NEWS","Uutta");
define("_PROJECT_RULES","Säännöt");



define("_Africa","Afrikka");
define("_Europe","Eurooppa");
define("_Asia","Aasia");
define("_Australia","Australia");
define("_North_Central_America","Pohjois/Keski Amerikka");
define("_South_America","Etelä Amerikka");

define("_Recent","Viimeisimmät");


define("_Unknown_takeoff","Tuntematon lentopaikka");
define("_Display_on_Google_Earth","Näytä Google Earthissa");
define("_Use_Man_s_Module","Käytä Man's Modulia");
define("_Line_Color","Rivin väri");
define("_Line_width","Rivin leveys");
define("_unknown_takeoff_tooltip_1","Tämän lennon lentopaikka ei ole tunnettu");
define("_unknown_takeoff_tooltip_2","Jos tiedät oikean lentopaikan, niin ole hyvä ja lisää se!");
define("_EDIT_WAYPOINT","Muuta lentopaikkaa");
define("_DELETE_WAYPOINT","Poista lentopaikka");
define("_SUBMISION_DATE","Tallennus pvm"); // the date a flight was submited to leonardo
define("_TIMES_VIEWED","Katsottu krt"); // the times that this flight havs been viewed


define("_takeoff_add_help_1","Lisää lentopaikka jos se on tiedossa. Jos et ole varma, niin voit sulkea tämän ikkunan");
define("_takeoff_add_help_2","Jos lentopaikka on se joka näkyy 'Unknown Takeoff' yläpuolella, niin sinun ei tarvitse antaa sitä uudelleen. Voit vain sulkea ikkunan. ");
define("_takeoff_add_help_3","Jos lentopaikan nimi näkyy alapuolella, niin klikkaamalla sitä voit täyttää vasemmalla olevat kentät automaattisesti.");
define("_Takeoff_Name","Lentopaikan nimi");
define("_In_Local_Language","Paikallisella kielellä");
define("_In_English","Englanniksi");

// New on 2007/02/20 - login screen
define("_ENTER_PASSWORD","Anna käyttäjätunnus ja salasana kirjautuaksesi sisään.");
define("_SEND_PASSWORD","Olen unohtanut salasanani");
define("_ERROR_LOGIN","Virheellinen käyttäjätunnus tai salasana.");
define("_AUTO_LOGIN","Kirjaudu sisään automaattisesti");
define("_USERNAME","Käyttäjätunnus");
define("_PASSWORD","Salasana");
define("_PROBLEMS_HELP","Ota yhteyttä ylläpitäjään jos sinulla on ongelmia sisäänkirjautumisessa");

define("_LOGIN_TRY_AGAIN","Yritä uudestaan painamalla %stästä%s");
define("_LOGIN_RETURN","Palaa alkuun painamalla %stästä%s");
// end 2007/02/20

define("_Category","Ryhmä");
define("_MEMBER_OF","Jäsenenä");
define("_MemberID","Jäsentunnus");
define("_EnterID","Anna tunnus");
define("_Clubs_Leagues","Kerhot / Liigat");
define("_Pilot_Statistics","Pilottitilastot");
define("_National_Rankings","Kansalliset rankingit");

// new on 2007/03/08
define("_Select_Club","Valitse kerho");
define("_Close_window","Sulje ikkuna");
define("_EnterID","Anna tunnus");
define("_Club","Kerho");
define("_Sponsor","Sponsori");


// new on 2007/03/13
define("_Go_To_Current_Month","Valitse kuluva kuukausi");
define("_Today_is","Tänään on");
define("_Wk","Vko");
define("_Click_to_scroll_to_previous_month","Selaa edelliseen kuukauteen. Pidä hiiren nappi painettuna selataksesi automaattisesti.");
define("_Click_to_scroll_to_next_month","Selaa seuraavaan kuukauteen. Pidä hiiren nappi painettuna selataksesi automaattisesti.");
define("_Click_to_select_a_month","Valitse kuukausi.");
define("_Click_to_select_a_year","Valitse vuosi.");
define("_Select_date_as_date.","Valitse [date] päivämääräksi."); // do not replace [date], it will be replaced by date.
// end 2007/03/13


// New on 2007/05/18 (alternative GUI_filter)
define("_Filter_NoSelection", "Ei valintoja");
define("_Filter_CurrentlySelected", "Nykyinen valinta");
define("_Filter_DialogMultiSelectInfo", "Paina Ctrl valitaksesi useita.");

define('_Filter_FilterTitleIncluding', 'Näytä valitut [items]');
define('_Filter_FilterTitleExcluding', 'Piilota valitut [items]');
define('_Filter_DialogTitleIncluding', 'Valitse [items]');
define('_Filter_DialogTitleExcluding', 'Valitse [items]');

define("_Filter_Items_pilot", "lentäjiä");
define("_Filter_Items_nacclub", "kerhoja");
define("_Filter_Items_country", "maita");
define("_Filter_Items_takeoff", "lentopaikkoja");

define("_Filter_Button_Select", "Valitse");
define("_Filter_Button_Delete", "Poista");
define("_Filter_Button_Accept", "Hyväksy valinta");
define("_Filter_Button_Cancel", "Peruuta");

# menu bar
define("_MENU_FILTER_NEW","Filter **NEW VERSION**");

// end 2007/05/18




// New on 2007/05/23
// second menu NACCclub selection
define("_ALL_NACCLUBS", "Kaikki kerhot");
// Note to translators: use the placeholder $nacname in your translation as it is, don"t translate it
define("_SELECT_NACCLUB", 'Valitse kerho [nacname]');

// pilot profile
define("_FirstOlcYear", "Online XC kilpailujen aloitusvuosi");
define("_FirstOlcYearComment", "Valitse vuosi jolloin osallistuit ensimmäisen kerran mihin tahansa Online XC kilpailuun, ei vain tähän.<br/>Tällä tiedolla on merkitystä &quot;aloittelija&quot;-rankingeissä.");

//end 2007/05/23

// New on 2007/11/06
define("_Select_Brand","Valitse valmistaja");
define("_All_Brands","Kaikki valmistajat");
define("_DAY","PVM");
define('_Glider_Brand','Liitimen valmistaja');
define('_Or_Select_from_previous','tai valitse edellisistä');

define('_Explanation_AddToBookmarks_IE', 'Lisää nämä valinnat kirjanmerkkeihin');
define('_Msg_AddToBookmarks_IE', 'Paina tästä lisätäksesi nämä valinnat selaimesi kirjanmerkkeihin.');
define('_Explanation_AddToBookmarks_nonIE', '(Tallenna kirjanmerkkeihin.)');
define('_Msg_AddToBookmarks_nonIE', 'Käytä selaimesi tallenna kirjanmerkkeihin - toimintoa tallentaaksesi nämä valinnat kirjanmerkkeihin.');

define('_PROJECT_HELP','Kysymyksiä');
define('_PROJECT_NEWS','Uutta');
define('_PROJECT_RULES','Säännöt 2007');
define('_PROJECT_RULES2','Säännöt 2008');

//end 2007/11/06
define('_MEAN_SPEED1','Keskinopeus');
define('_External_Entry','Ulkopuolinen osallistuminen');

// New on 2007/11/25
define('_Altitude','Korkeus (ASL) ');
define('_Speed','Nopeus');
define('_Distance_from_takeoff','Etäisyys lähtöpaikasta');

// New on 2007/12/03
define('_LAST_DIGIT','viimeinen desimaali');

define('_Filter_Items_nationality','kansallisuus');
define('_Filter_Items_server','palvelin');

// New on 2007/12/15
define('_Ext_text1','Tämä lento tallennettiin alunperin ');
define('_Ext_text2','Linkki lennon karttoihin ja kaavioihin');

//--------------------------------------------------------
//--------------------------------------------------------
// Missing defines , autoreplaced values from 'english' 
//--------------------------------------------------------
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

?>
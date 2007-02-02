<?php
/**************************************************************************/
/* Dutch language translation by                    	                  */
/* Ardy Brouwer (fly2high@xs4all.nl)				                      */
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
	global  $monthList;
	$monthList=array('January','February','March','April','May','June',
					'July','Augoust','September','October','November','December');
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","Vrije vlucht");
define("_FREE_TRIANGLE","Open Driehoek");
define("_FAI_TRIANGLE","FAI Driehoek");

define("_SUBMIT_FLIGHT_ERROR","Er is een probleem met het declareren van deze vlucht");

// list_pilots()
define("_NUM","Nr.");
define("_PILOT","Piloot");
define("_NUMBER_OF_FLIGHTS","Aantal vluchten");
define("_BEST_DISTANCE","Beste afstand");
define("_MEAN_KM","Gem. afstand per vlucht");
define("_TOTAL_KM","Totaal gevlogen km's");
define("_TOTAL_DURATION_OF_FLIGHTS","Totale vliegduur");
define("_MEAN_DURATION","Gem. vliegduur");
define("_TOTAL_OLC_KM","Totaal OLC afstand");
define("_TOTAL_OLC_SCORE","Totaal OLC score");
define("_BEST_OLC_SCORE","Beste OLC score");
define("_From","Van");

// list_flights()
define("_DURATION_HOURS_MIN","Duur (U:M))");
define("_SHOW","Bekijk");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","Deze vlucht zal binnen 1-2 min. geactiveerd worden. ");
define("_TRY_AGAIN","Probeer het later nog eens.");

define("_TAKEOFF_LOCATION","Startplaats");
define("_TAKEOFF_TIME","Starttijd");
define("_LANDING_LOCATION","Landingsplaats");
define("_LANDING_TIME","Landingstijd");
define("_OPEN_DISTANCE","Open afstand");
define("_MAX_DISTANCE","Max. Afstand");
define("_OLC_SCORE_TYPE","OLC score type");
define("_OLC_DISTANCE","OLC Afstand");
define("_OLC_SCORING","OLC Score");
define("_MAX_SPEED","Max. Snelheid");
define("_MAX_VARIO","Max. Stijging");
define("_MEAN_SPEED","Gem. Snelheid");
define("_MIN_VARIO","Max. Daling");
define("_MAX_ALTITUDE","Max. Hoogte (ASL)");
define("_TAKEOFF_ALTITUDE","Starthoogte (ASL)");
define("_MIN_ALTITUDE","Min.Hoogte  (ASL)");
define("_ALTITUDE_GAIN","Hoogte winst");
define("_FLIGHT_FILE","Vlucht Bestand");
define("_COMMENTS","Opmerkingen");
define("_RELEVANT_PAGE","Relevante Pagina");
define("_GLIDER","Scherm");
define("_PHOTOS","Foto's");
define("_MORE_INFO","Extra Info");
define("_UPDATE_DATA","Update Gegevens");
define("_UPDATE_MAP","Update Kaart");
define("_UPDATE_3D_MAP","Update 3D Kaart");
define("_UPDATE_GRAPHS","Update Grafieken");
define("_UPDATE_SCORE","Update score's");

define("_TAKEOFF_COORDS","Startplaats Coördinaten:");
define("_NO_KNOWN_LOCATIONS","Er is geen bekende locatie!");
define("_FLYING_AREA_INFO","Vlieggebied Info");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo XC server");
define("_RETURN_TO_TOP","Naar Boven");
// list flight
define("_PILOT_FLIGHTS","Vluchten van Piloot");

define("_DATE_SORT","Datum");
define("_PILOT_NAME","Naam Piloot");
define("_TAKEOFF","Start");
define("_DURATION","Duur");
define("_LINEAR_DISTANCE","Afstand Hemelsbreed");
define("_OLC_KM","OLC km");
define("_OLC_SCORE","OLC score");
define("_DATE_ADDED","Laatste aanvulling");

define("_SORTED_BY","Sorteer op:");
define("_ALL_YEARS","Alle Jaren");
define("_SELECT_YEAR_MONTH","Selecteer jaar (en maand)");
define("_ALL","Alles");
define("_ALL_PILOTS","Laat alle piloten zien");
define("_ALL_TAKEOFFS","Laat alle Startplaatsen zien");
define("_ALL_THE_YEAR","Gehele jaar");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","U heeft geen bestand ingevoerd");
define("_NO_SUCH_FILE","Het bestand dat u heeft ingevoerd is niet op de server gevonden");
define("_FILE_DOESNT_END_IN_IGC","Het bestand heeft geen .IGC exstensie");
define("_THIS_ISNT_A_VALID_IGC_FILE","Dit is geen geldig .IGC bestand");
define("_THERE_IS_SAME_DATE_FLIGHT","Er is al een vlucht met dezelfde datum en tijd");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","Als u deze vlucht wilt vervangen moet u eerst");
define("_DELETE_THE_OLD_ONE","de oude verwijderen");
define("_THERE_IS_SAME_FILENAME_FLIGHT","Er is al een vlucht met dezelfde bestandsnaam");
define("_CHANGE_THE_FILENAME","Als dit een andere vlucht is verander dan de naam voor een andere en probeer het nog eens");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","Uw vlucht is gedeclareerd");
define("_PRESS_HERE_TO_VIEW_IT","Klik hier om vlucht te bekijken");
define("_WILL_BE_ACTIVATED_SOON","(Hij zal binnen 1 tot 2 minuten geactiveerd worden)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Declareer meerdere vluchten");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","Alleen .IGC bestanden worden behandeld");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","Laad .ZIP file <br>met de vluchten");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","Klik hier om vluchten te declareren");

define("_FILE_DOESNT_END_IN_ZIP","Het bestand heeft geen .ZIP extensie");
define("_ADDING_FILE","Bestand wordt geladen");
define("_ADDED_SUCESSFULLY","Laden succesvol");
define("_PROBLEM","Probleem");
define("_TOTAL","Totaal van");
define("_IGC_FILES_PROCESSED","vluchten zijn behandeld");
define("_IGC_FILES_SUBMITED","Vluchten zijn gedeclareerd");

// info
define("_DEVELOPMENT","Ontwikkeld");
define("_ANDREADAKIS_MANOLIS","Andreadakis Manolis");
define("_PROJECT_URL","Project Pagina");
define("_VERSION","Versie");
define("_MAP_CREATION","Kaart Realisatie");
define("_PROJECT_INFO","Project Info");

// menu bar 
define("_MENU_MAIN_MENU","Hoofd Menu");
define("_MENU_DATE","Selecteer Datum");
define("_MENU_COUNTRY","Selecteer Land");
define("_MENU_XCLEAGUE","XC Divisie");
define("_MENU_ADMIN","Admin");

define("_MENU_COMPETITION_LEAGUE","Divisie - alle categorien");
define("_MENU_OLC","OLC");
define("_MENU_OPEN_DISTANCE","Open Afstand");
define("_MENU_DURATION","Duur");
define("_MENU_ALL_FLIGHTS","Laat alle vluchten zien");
define("_MENU_FLIGHTS","Vluchten");
define("_MENU_TAKEOFFS","Startplekken");
define("_MENU_FILTER","Filter");
define("_MENU_MY_FLIGHTS","Mijn Vluchten");
define("_MENU_MY_PROFILE","Mijn Profiel");
define("_MENU_MY_STATS","Mijn Statistieken"); 
define("_MENU_MY_SETTINGS","Mijn Voorkeuren"); 
define("_MENU_SUBMIT_FLIGHT","Laadt Vluchten");
define("_MENU_SUBMIT_FROM_ZIP","Laadt vluchten met .ZIP");
define("_MENU_SHOW_PILOTS","Piloten");
define("_MENU_SHOW_LAST_ADDED","Laat laatste toevoegingen zien");
define("_FLIGHTS_STATS","Vlucht Statistieken");

define("_SELECT_YEAR","Selecteer Jaar");
define("_SELECT_MONTH","Selecteer Maand");
define("_ALL_COUNTRIES","Laat alle landen zien");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","Alle tijden");
define("_NUMBER_OF_FLIGHTS","Aantal vluchten");
define("_TOTAL_DISTANCE","Totale afstand");
define("_TOTAL_DURATION","Total tijdsduur");
define("_BEST_OPEN_DISTANCE","Beste afstand");
define("_TOTAL_OLC_DISTANCE","Totale OLC afstand");
define("_TOTAL_OLC_SCORE","Totale OLC score");
define("_BEST_OLC_SCORE","Beste OLC score");
define("_MEAN_DURATION","Gem. tijdsduur");
define("_MEAN_DISTANCE","Gem. afstand");
define("_PILOT_STATISTICS_SORT_BY","Piloten - Sorteer op");
define("_CATEGORY_FLIGHT_NUMBER","Categorie 'Veel Vliegers' - Aantal vluchten");
define("_CATEGORY_TOTAL_DURATION","Categorie 'Stayers' - Totale tijdsduur vluchten");
define("_CATEGORY_OPEN_DISTANCE","Categorie 'Open afstand'");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","Er zijn geen piloten bekend!");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","De vlucht is verwijderd");
define("_RETURN","Terug");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","Pas op - U bent deze vlucht aan het verwijderen");
define("_THE_DATE","Datum ");
define("_YES","Ja");
define("_NO","Nee");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","Divisie resultaten");
define("_N_BEST_FLIGHTS"," Beste resultaten");
define("_OLC","OLC");
define("_OLC_TOTAL_SCORE","OLC totale score");
define("_KILOMETERS","Kilometers");
define("_TOTAL_ALTITUDE_GAIN","Totale hoogte winst");
define("_TOTAL_KM","Totale km's");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","is");
define("_IS_NOT","is niet");
define("_OR","of");
define("_AND","en");
define("_FILTER_PAGE_TITLE","Filter Vluchten");
define("_RETURN_TO_FLIGHTS","Terug naar vluchtens");
define("_THE_FILTER_IS_ACTIVE","The filter is active");
define("_THE_FILTER_IS_INACTIVE","Het filter is niet aktief");
define("_SELECT_DATE","Selecteer datum");
define("_SHOW_FLIGHTS","Laat vluchten zien");
define("_ALL2","Alles");
define("_WITH_YEAR","Met jaar");
define("_MONTH","Maand");
define("_YEAR","Jaar");
define("_FROM","Van");
define("_from","van");
define("_TO","To");
define("_SELECT_PILOT","Selecteet Piloot");
define("_THE_PILOT","De piloot");
define("_THE_TAKEOFF","De Startplaats");
define("_SELECT_TAKEOFF","Selecter Startplaats");
define("_THE_COUNTRY","Het Land");
define("_COUNTRY","Land");
define("_SELECT_COUNTRY","Selecteer land");
define("_OTHER_FILTERS","Andere Filters");
define("_LINEAR_DISTANCE_SHOULD_BE","De hemelsbreed afstand moet zijn");
define("_OLC_DISTANCE_SHOULD_BE","De OLC afstand moet zijn");
define("_OLC_SCORE_SHOULD_BE","De OLC score moet zijn");
define("_DURATION_SHOULD_BE","De tijdsduur moet zijn");
define("_ACTIVATE_CHANGE_FILTER","Activeer / wijzig FILTER");
define("_DEACTIVATE_FILTER","Deactiveer FILTER");
define("_HOURS","uren");
define("_MINUTES","min");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","Laadt vlucht");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(Alleen het .IGC bestand is nodig)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","Laadt<br>IGC bestand van vlucht");
define("_NOTE_TAKEOFF_NAME","Geef startplaats, naam locatie en land aan");
define("_COMMENTS_FOR_THE_FLIGHT","Opmerkingen over vlucht");
define("_PHOTO","Foto");
define("_PHOTOS_GUIDELINES","Foto's moeten in .JPG en kleiner dan 100Kb");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","Klik hier om vlucht te declareren");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","Wilt u meerdere vluchten tegelijk declareren ?");
define("_PRESS_HERE","Klik hier");

define("_IS_PRIVATE","Niet openbaar maken");
define("_MAKE_THIS_FLIGHT_PRIVATE","Niet openbaar maken");
define("_INSERT_FLIGHT_AS_USER_ID","Vluchten invoegen als gebruikers ID");
define("_FLIGHT_IS_PRIVATE","Deze vlucht is niet openbaar");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","Verander vlucht gegevens");
define("_IGC_FILE_OF_THE_FLIGHT",".IGC bestand van de vlucht");
define("_DELETE_PHOTO","Verwijder");
define("_NEW_PHOTO","Nieuwe foto");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","Klik hier om vluchtgegevens te veranderen");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","Veranderingen zijn uitgevoerd");
define("_RETURN_TO_FLIGHT","Terug naar vlucht");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","Terug naar vlucht");
define("_READY_FOR_SUBMISSION","Klaar om te declareren");
define("_SUBMIT_TO_OLC","Declareer bij OLC");
define("_YOUR_FLIGHT_HAS_BEEN_SUCCESSFULLY_SUBMITED_TO_THE_OLC","De vlucht is met succes gedeclareerd bij de OLC");
define("_THE_OLC_REFERENCE_NUMBER_IS","Het oude OLC referentie nummer is");
define("_THERE_WAS_A_PROBLEM_ON_OLC_SUBMISSION","Er is een probleem met OLC declaratie");
define("_LOOK_BELOW_FOR_THE_CAUSE_OF_THE_PROBLEM","kijk hieronder voor de oorzaak van het probleem");
define("_FLIGHT_SUCCESFULLY_REMOVED_FROM_OLC","De vlucht is met succes verwijderd van de OLC");
define("_FLIGHT_NOT_SCORED","De vlucht heeft geen OLC score en kan daarom niet gedeclareerd worden");
define("_TOO_LATE","De vervaldatum voor deze vlucht is gepasseed en kan daarom niet meer gedeclareerd worden");
define("_CANNOT_BE_SUBMITTED","De vervaldatum voor deze vlucht is gepasseerd");
define("_NO_PILOT_OLC_DATA","<p><strong>Geen OLC gegevens voor de piloot</strong><br>
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
define("_OLC_MAP","Kaart");
define("_OLC_BARO","Barograaf");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","Piloot profiel");
define("_back_to_flights","Terug naar vluchten");
define("_pilot_stats","Piloot statistieken");
define("_edit_profile","Verander Profiel");
define("_flights_stats","Vlucht statistieken");
define("_View_Profile","Bekijk Profiel");

define("_Personal_Stuff","Persoonlijke gegevens");
define("_First_Name"," Voornaam");
define("_Last_Name","Achternaam");
define("_Birthdate","Geboorte Datum");
define("_dd_mm_yy","dd.mm.yy");
define("_Sign","Sterrenbeeld");
define("_Marital_Status","Burgerlijke staat");
define("_Occupation","Beroep");
define("_Web_Page","Website");
define("_N_A","N.V.T");
define("_Other_Interests","Andere interesses");
define("_Photo","Foto");

define("_Flying_Stuff","Vlieg Info");
define("_note_place_and_date","Indien van toepassing noem plaats-land en datum");
define("_Flying_Since","Vliegt sinds");
define("_Pilot_Licence","Brevet");
define("_Paragliding_training","Paragliding opleiding");
define("_Favorite_Location","Favoriete Vlieg locatie");
define("_Usual_Location","Standaard vlieg locatie");
define("_Best_Flying_Memory","Mooiste vlieg ervaring");
define("_Worst_Flying_Memory","Slechtste vlieg ervaring");
define("_Personal_Distance_Record","Persoonlijk afstands record");
define("_Personal_Height_Record","Persoonlijk hoogte record");
define("_Hours_Flown","Totaal gevlogen uren");
define("_Hours_Per_Year","Gevlogen uren per jaar");

define("_Equipment_Stuff","Uitrusting");
define("_Glider","Scherm");
define("_Harness","Harnas");
define("_Reserve_chute","Noodchute");
define("_Camera","Fototoestel");
define("_Vario","Vario");
define("_GPS","GPS");
define("_Helmet","Helm");
define("_Camcorder","Videocamera");

define("_Manouveur_Stuff","Vliegfiguren");
define("_note_max_descent_rate","Max. bereikte daalsnelheid");
define("_Spiral","Steilspiraal");
define("_Bline","B-stall");
define("_Full_Stall","Full Stall");
define("_Other_Manouveurs_Acro","Andere Acro figuren");
define("_Sat","Sat");
define("_Asymmetric_Spiral","A-symetrische spiraal");
define("_Spin","Spin/Heli");

define("_General_Stuff","Algemene info");
define("_Favorite_Singer","Favoriete Zanger/Zangeres");
define("_Favorite_Movie","Favoriete Film");
define("_Favorite_Internet_Site","Favoriete<br>Internet Site");
define("_Favorite_Book","Favoriet Boek");
define("_Favorite_Actor","Favoriete Acteur/Actrice");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","Nieuwe foto laden of oude wijzigen");
define("_Delete_Photo","Verwijder foto");
define("_Your_profile_has_been_updated","Uw profiel is aangepast");
define("_Submit_Change_Data","laadt - gegevens aanpassen");

//--------------------------------------------
// pilot_ïlc_profile_edit.php
//--------------------------------------------
define("_edit_OLC_info","Verander OLC info");
define("_OLC_information","OLC informatie");
define("_callsign","Bijnaam");
define("_filename_suffix","Bestands code");
define("_OLC_Pilot_Info","OLC Piloot Info");
define("_OLC_EXPLAINED","<b>Wat is OLC / waar zijn deze velden voor ?</b><br><br>
	Om een vlucht bij de OLC te declareren moet je bij de OLC geregistreerd zijn.</p>
<p> Dit kan je doen op<a href='http://www2.onlinecontest.org/olcphp/2005/ausw_wertung.php?olc=holc-i&spr=en' target='_blank'>
  op deze pagina</a>, waar je bij 'select country' Netherlands moet selecteren en daarna 'Contest Registration'<br>
</p>
<p>Als je geregistreerd bent moet je hier je gegevens PRECIES hetzelfde als bij de OLC invoeren
</p>
<ul>
	<li><div align=left>First/Given name</div>
	<li><div align=left>Surname</div>
	<li><div align=left>Date of birth</div>
	<li> <div align=left>Your callsign</div>
	<li><div align=left>If you have already submitted flights to OLC, the 4 letters you use for the IGC filename</div>
</ul>
");

define("_OLC_SUFFIX_EXPLAINED","<b>Wat is de Bestandsnaam Code ?'</b><br>Dit is een 4 letter code die piloot of scherm identificeert. 
Als je niet precies weet wat je moet invullen dan zijn hier wat tips:<p>
<ul>
<li>Gebruik bijvoorbeeld de afkortingen van je voor en achternaam zodat je 4 letters krijgt.
<li>Probeer een code te vinden die niet al te voor de handliggend is om te voorkomen dat er meerdere piloten dezelfde code hebben. Je kan ook een andere code bedenken natuurlijk.
<li>Als je problemen hebt met declareren van je vlucht naar de OLC via LEONARDO, dan kan het aan deze code liggen. Verander deze code en probeer je vlucht opnieuw te declareren.
</ul>");
//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","uu:mm");

define("_Totals","Totalen");
define("_First_flight_logged","Eerst geregistreerde vlucht");
define("_Last_flight_logged","Laatst geregistreerde vlucht");
define("_Flying_period_covered","Vliegt sinds");
define("_Total_Distance","Totale afstand");
define("_Total_OLC_Score","Totale OLC Score");
define("_Total_Hours_Flown","Totaal Gevlogen uren");
define("_Total_num_of_flights","Totaal aantal vluchten");

define("_Personal_Bests","Personlijke records");
define("_Best_Open_Distance","Beste Vrije Afstand");
define("_Best_FAI_Triangle","Beste FAI Driehoek");
define("_Best_Free_Triangle","Beste Open Driehoek");
define("_Longest_Flight","Langste Vlucht");
define("_Best_OLC_score","Beste OLC score");

define("_Absolute_Height_Record","Max. bereikte hoogte");
define("_Altitute_gain_Record","Max. hoogte winst");
define("_Mean_values","Gem. Waardes");
define("_Mean_distance_per_flight","Gem. afstand per vlucht");
define("_Mean_flights_per_Month","Gem. aantal vluchten per maand");
define("_Mean_distance_per_Month","Gem. afstand per maand");
define("_Mean_duration_per_Month","Gem. vluchtduur per maand");
define("_Mean_duration_per_flight","Gem. vluchtduur per vlucht");
define("_Mean_flights_per_Year","Gem. aantal vluchten per jaar");
define("_Mean_distance_per_Year","Gem. afstand per jaar");
define("_Mean_duration_per_Year","Gem. vluchtduur per jaar");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","Bekijk andere vluchten in de omgeving zijn gevlogen");
define("_Waypoint_Name","Waypoint Naam");
define("_Navigate_with_Google_Earth","Bekijk met Google Earth");
define("_See_it_in_Google_Maps","Bekijk in Google Maps");
define("_See_it_in_MapQuest","Bekijk in MapQuest");
define("_COORDINATES","Coördinaten");
define("_FLIGHTS","Vluchten");
define("_SITE_RECORD","Startplaats record");
define("_SITE_INFO","Startplaats informatie");
define("_SITE_REGION","Regio");
define("_SITE_LINK","Link naar meer informatie");
define("_SITE_DESCR","Startplaats omschrijving");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","Bekijk meer details");
define("_KML_file_made_by","KML bestand gemaakt door");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","Registreer Startplaats");
define("_WAYPOINT_ADDED","De startplaats is geregistreerd");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","Startplaats reord<br>(open afstand)");
	
//--------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","Scherm type");
function setGliderCats() {
	global  $gliderCatList;
	$gliderCatList=array(1=>'Paraglider',2=>'Flex wing FAI1',4=>'Rigid wing FAI5',8=>'Glider');
}
setGliderCats();

//--------------------------------------------
// user prefs  & units
//--------------------------------------------

define("_Your_settings_have_been_updated","Je instellingen zijn veranderd");

define("_THEME","Thema");
define("_LANGUAGE","Taal");
define("_VIEW_CATEGORY","Bekijk categorie");
define("_VIEW_COUNTRY","Bekijk land");
define("_UNITS_SYSTEM" ,"Eenheden");
define("_METRIC_SYSTEM","Metrisch (km,m)");
define("_IMPERIAL_SYSTEM","Amerikaans (miles,feet)");
define("_ITEMS_PER_PAGE","Artikelen per pagina");

define("_MI","mi");
define("_KM","km");
define("_FT","ft");
define("_M","m");
define("_MPH","mpu");
define("_KM_PER_HR","km/u");
define("_FPM","fpm");
define("_M_PER_SEC","m/sec");

//--------------------------------------------
// index page
//--------------------------------------------

define("_WORLD_WIDE","Wereldwijd");
define("_National_XC_Leagues_for","Nationale XC Divisie voor");
define("_Flights_per_Country","Vluchten per land");
define("_Takeoffs_per_Country","Starts per land");
define("_INDEX_HEADER","Welkom bij de Leonardo XC Divisie");
define("_INDEX_MESSAGE","Je kan gebruik maken van de &quot;Main menu&quot; om te navigeren of via de meest gebruikte opties die hieronder zijn vermeld.");

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

?>
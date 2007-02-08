<?php
/**************************************************************************/
/*  German language translation by                                        */
/*  Torsen (www.paraglider365.com                                         */
/**************************************************************************/
/************************************************************************/
/* Leonardo: Gliding XC Server					        */
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
	$monthList=array('Januar','Februar','Maerz','April','Mai','Juni',
					'Juli','August','September','Oktober','November','Dezember');
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","Freier Flug");
define("_FREE_TRIANGLE","Freies Dreieck");
define("_FAI_TRIANGLE","FAI Dreieck");

define("_SUBMIT_FLIGHT_ERROR","Bei der Übermittlung des Fluges ist ein Fehler aufgetreten");

// list_pilots()
define("_NUM","#");
define("_PILOT","Pilot");
define("_NUMBER_OF_FLIGHTS","Anzahl Flüge");
define("_BEST_DISTANCE","Beste Distanz");
define("_MEAN_KM","Durchschnittliche # Kilometer pro Flug");
define("_TOTAL_KM","Summe Flugkilometer");
define("_TOTAL_DURATION_OF_FLIGHTS","Summe Flugdauer");
define("_MEAN_DURATION","Durschnittliche Flugdauer");
define("_TOTAL_OLC_KM","Summe OLC Distanz");
define("_TOTAL_OLC_SCORE","Summe OLC Punktzahl");
define("_BEST_OLC_SCORE","Beste OLC Punktzahl");
define("_From","von");

// list_flights()
define("_DURATION_HOURS_MIN","Dauer (h:m)");
define("_SHOW","Anzeigen");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","Der Flug wird in 1-2 Minuten aktiviert. ");
define("_TRY_AGAIN","Bitte versuche es später noch einmal");

define("_TAKEOFF_LOCATION","Startplatz");
define("_TAKEOFF_TIME","Startzeitpunkt");
define("_LANDING_LOCATION","Landeplatz");
define("_LANDING_TIME","Landezeitpunkt");
define("_OPEN_DISTANCE","Luftlinie");
define("_MAX_DISTANCE","Maximale Distanz");
define("_OLC_SCORE_TYPE","OLC Punkte Typ");
define("_OLC_DISTANCE","OLC Distanz");
define("_OLC_SCORING","OLC Punkte");
define("_MAX_SPEED","Maximale Geschwindigkeit");
define("_MAX_VARIO","Maximales Steigen");
define("_MEAN_SPEED","Durchschnittliche Geschwindkeit");
define("_MIN_VARIO","Maximales Sinken");
define("_MAX_ALTITUDE","Grösste Höhe (über NN)");
define("_TAKEOFF_ALTITUDE","Start Höhe (über NN)");
define("_MIN_ALTITUDE","Minimale Höhe (ner NN)");
define("_ALTITUDE_GAIN","Höhen Zugewinn");
define("_FLIGHT_FILE","FLug Datei");
define("_COMMENTS","Kommentare");
define("_RELEVANT_PAGE","relevante Webseiten URL");
define("_GLIDER","Drachentyp"); 
define("_PHOTOS","Fotos");
define("_MORE_INFO","Extras");
define("_UPDATE_DATA","Daten aktualisieren");
define("_UPDATE_MAP","Karte aktualisieren");
define("_UPDATE_3D_MAP","3D Karte aktualisieren");
define("_UPDATE_GRAPHS","Charts aktualisieren");
define("_UPDATE_SCORE","Punkte aktualisieren");

define("_TAKEOFF_COORDS","Start Koordinaten:");
define("_NO_KNOWN_LOCATIONS","Es gibt keine bekannten Fluggebiete!");
define("_FLYING_AREA_INFO","Fluggebiets Info"); 

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo XC");
define("_RETURN_TO_TOP","Zurück nach oben");
// list flight
define("_PILOT_FLIGHTS","Flüge des Piloten");

define("_DATE_SORT","Datum");
define("_PILOT_NAME","Name des Piloten");
define("_TAKEOFF","Startplatz");
define("_DURATION","Dauer");
define("_LINEAR_DISTANCE","Luftlinie");
define("_OLC_KM","OLC Kilometer");
define("_OLC_SCORE","OLC Punkte");
define("_DATE_ADDED","Letzte Übermittlungen");

define("_SORTED_BY","Sortiert nach:");
define("_ALL_YEARS","Alle Jahre");
define("_SELECT_YEAR_MONTH","Jahr (und Monat) auswählen");
define("_ALL","Alle");
define("_ALL_PILOTS","Alle Piloten anzeigen");
define("_ALL_TAKEOFFS","Alle Starts anzeigen");
define("_ALL_THE_YEAR","Alle JAhre anzeigen");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","Du hast keine Datei angegeben");
define("_NO_SUCH_FILE","Die angegebene Datei kann nicht gefunden werden");
define("_FILE_DOESNT_END_IN_IGC","Die angegebene Datei hat keine .igc Endung");
define("_THIS_ISNT_A_VALID_IGC_FILE","Keine gültige .igc Datei");
define("_THERE_IS_SAME_DATE_FLIGHT","Eine Datei mit dem selben Datum und Uhrzeit existiert bereits");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","Wenn Du diese Datei ersetzen möchtest, sollte Du zuerst");
define("_DELETE_THE_OLD_ONE","die Alte löschen");
define("_THERE_IS_SAME_FILENAME_FLIGHT","Eine Datei mit dem selben Nahmen exisitiert bereits");
define("_CHANGE_THE_FILENAME","Sollte dieser Flug unterschiedlich sein, dann ändere bitte den Dateinamen und versuche es noch einmal");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","Dein Flug wurde eingereicht");
define("_PRESS_HERE_TO_VIEW_IT","Zum ansehen hier clicken");
define("_WILL_BE_ACTIVATED_SOON","(er wird in 1-2 Minuten aktiviert)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Mehrere Flüge einreichen");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","Es werden nur IGC Datei verarbeitet");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","Übertrage die ZIP Datei<br>die die Flüge beinhaltet");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","Zum Einreichen der Flüge hier clicken");

define("_FILE_DOESNT_END_IN_ZIP","Die angebene Datei hat keine .zip Endung");
define("_ADDING_FILE","Datei wird übertragen");
define("_ADDED_SUCESSFULLY","Übertragung erfolgreich");
define("_PROBLEM","Problem");
define("_TOTAL","Ingesamt wurden ");
define("_IGC_FILES_PROCESSED","Flüge wurden verarbeitet");
define("_IGC_FILES_SUBMITED","Flüge wurden übertragen");

// info
define("_DEVELOPMENT","Entwicklung");
define("_ANDREADAKIS_MANOLIS","Andreadakis Manolis");
define("_PROJECT_URL","Projekt Webseite");
define("_VERSION","Version");
define("_MAP_CREATION","Karten Erstellung");
define("_PROJECT_INFO","Projekt Info");

// menu bar 
define("_MENU_MAIN_MENU","Hauptmenue");
define("_MENU_DATE","Datum auswählen");
define("_MENU_COUNTRY","Land auswählen");
define("_MENU_XCLEAGUE","XC League");
define("_MENU_ADMIN","Admin");

define("_MENU_COMPETITION_LEAGUE","League - Alle Kategorien");
define("_MENU_OLC","OLC");
define("_MENU_OPEN_DISTANCE","Offene Distanz");
define("_MENU_DURATION","Dauer");
define("_MENU_ALL_FLIGHTS","Alle Flüge anzeigen");
define("_MENU_FLIGHTS","Flüge");
define("_MENU_TAKEOFFS","Starts");
define("_MENU_FILTER","Filter");
define("_MENU_MY_FLIGHTS","Meine Flüge");
define("_MENU_MY_PROFILE","Mein Profil");
define("_MENU_MY_STATS","Meine Statistik"); 
define("_MENU_MY_SETTINGS","Meine Einstellungen"); 
define("_MENU_SUBMIT_FLIGHT","Flüge einreichen");
define("_MENU_SUBMIT_FROM_ZIP","Flüge mittels ZIP einreichen");
define("_MENU_SHOW_PILOTS","Piloten");
define("_MENU_SHOW_LAST_ADDED","Letzte Einreichungen anzeigen");

define("_SELECT_YEAR","Jahr auswählen");
define("_SELECT_MONTH","Monat auswählen");
define("_ALL_COUNTRIES","Alle Länder anzeigen");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","ALLE ZEITEN");
define("_NUMBER_OF_FLIGHTS","Anzahl Flüge");
define("_TOTAL_DISTANCE","Gesamt Distanz");
define("_TOTAL_DURATION","Gesamt Flugdauer");
define("_BEST_OPEN_DISTANCE","Beste Distanz");
define("_TOTAL_OLC_DISTANCE","Gesamt OLC Distanz");
define("_TOTAL_OLC_SCORE","Gesamt OLC Punkte");
define("_BEST_OLC_SCORE","Best OLC score");
define("_MEAN_DURATION","Durchschnittliche Flugdauer");
define("_MEAN_DISTANCE","Durchschnittliche Distanz");
define("_PILOT_STATISTICS_SORT_BY","Piloten - sortiert nach");
define("_CATEGORY_FLIGHT_NUMBER","Kategorie 'FastJoe' - Anzahl der Flüge");
define("_CATEGORY_TOTAL_DURATION","Kategorie 'DURACELL' - Gesamt Flugdauer aller Flüge");
define("_CATEGORY_OPEN_DISTANCE","Kategorie 'Offene Distanz'");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","Keine Piloten vorhanden !");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","Der Flug wurde gelöscht");
define("_RETURN","Zurück");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","Vorsicht - Möchtest Du den Flug wirklich löschen ?");
define("_THE_DATE","Datum ");
define("_YES","JA");
define("_NO","NEIN");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","League Ergebnis");
define("_N_BEST_FLIGHTS"," beste Flüge");
define("_OLC","OLC");
define("_OLC_TOTAL_SCORE","OLC Gesamtpunkte");
define("_KILOMETERS","Kilometer");
define("_TOTAL_ALTITUDE_GAIN","Gesamt Höhengewinn");
define("_TOTAL_KM","Gesamt Kilometer");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","gleich");
define("_IS_NOT","ungleich");
define("_OR","oder");
define("_AND","und");
define("_FILTER_PAGE_TITLE","Flüge Filtern");
define("_RETURN_TO_FLIGHTS","Zurück zu den Flügen");
define("_THE_FILTER_IS_ACTIVE","Der Filter ist aktiv");
define("_THE_FILTER_IS_INACTIVE","Der Filter ist inaktiv");
define("_SELECT_DATE","Datum auswählen");
define("_SHOW_FLIGHTS","Flüge anzeigen");
define("_ALL2","ALLE");
define("_WITH_YEAR","mit Jahr");
define("_MONTH","Monat");
define("_YEAR","Jahr");
define("_FROM","Von");
define("_from","von");
define("_TO","bis");
define("_SELECT_PILOT","Pilot auswählen");
define("_THE_PILOT","Der Pilot");
define("_THE_TAKEOFF","Der Startplatz");
define("_SELECT_TAKEOFF","Start auswählen");
define("_THE_COUNTRY","Das Land");
define("_COUNTRY","Land");
define("_SELECT_COUNTRY","Land auswählen");
define("_OTHER_FILTERS","Andere Filter");
define("_LINEAR_DISTANCE_SHOULD_BE","Die Luftlinie sollte ... sein");
define("_OLC_DISTANCE_SHOULD_BE","Die OLC Distanz sollte ... sein");
define("_OLC_SCORE_SHOULD_BE","Die OLC Punktzahl sollte ... sein");
define("_DURATION_SHOULD_BE","Die Flugdauer sollte ... sein");
define("_ACTIVATE_CHANGE_FILTER","Filter Aktivieren / Ändern");
define("_DEACTIVATE_FILTER","Filter deaktivieren");
define("_HOURS","Stunden");
define("_MINUTES","Minuten");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","Flug einreichen");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(nur das IGC File wird benötigt)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","Übertrage das<br>IGC File des Fluges");
define("_NOTE_TAKEOFF_NAME","Bitte beachte den Namen des Startplatzes /-gebietes und das Land");
define("_COMMENTS_FOR_THE_FLIGHT","Kommentare zum Flug");
define("_PHOTO","Foto");
define("_PHOTOS_GUIDELINES","Fotos sollten im jpg Format und kleiner als 100kb sein");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","Hier clicken um den Flug einzureichen");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","Möchtest Du mehrere Flüge auf einmal einreichen ?");
define("_PRESS_HERE","Hier clicken");

define("_IS_PRIVATE","Nicht öffentlich machen");
define("_MAKE_THIS_FLIGHT_PRIVATE","Nicht öffentlich machen");
define("_INSERT_FLIGHT_AS_USER_ID","Flug als User ID einfügen");
define("_FLIGHT_IS_PRIVATE","Dieser Flug ist nicht öffentlich");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","Flug Daten ändern");
define("_IGC_FILE_OF_THE_FLIGHT","IGC Datei des Fluges");
define("_DELETE_PHOTO","Löschen");
define("_NEW_PHOTO","neues Foto");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","Um die Flug Daten zu ändern bitte hier clicken");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","Die Änderungen wurden berücksichtigt");
define("_RETURN_TO_FLIGHT","Zurück zum Flug");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","Zurück zum Flug");
define("_READY_FOR_SUBMISSION","Fertig zur Übertragung");
define("_SUBMIT_TO_OLC","Übertragung zum OLC");
define("_YOUR_FLIGHT_HAS_BEEN_SUCCESSFULLY_SUBMITED_TO_THE_OLC","Der Flug wurde erfolgreich zum OLC übertragen");
define("_THE_OLC_REFERENCE_NUMBER_IS","Die OLC Referenz Nummer ist");
define("_THERE_WAS_A_PROBLEM_ON_OLC_SUBMISSION","Es ist ein Problem bei der Übertragung zum OLC augetreten");
define("_LOOK_BELOW_FOR_THE_CAUSE_OF_THE_PROBLEM","Bitte schaue nach unten für die mögliche Ursache des Problems");
define("_FLIGHT_SUCCESFULLY_REMOVED_FROM_OLC","Der Flug wurde erfolgreich vom OLC gelöscht");
define("_FLIGHT_NOT_SCORED","Der Flug hat keine OLC Punktzahl und kann daher nicht eingereicht werden");
define("_TOO_LATE","Der Abgabetermin ist überschritten, daher kann der Flug nicht eingereicht werden");
define("_CANNOT_BE_SUBMITTED","Der Abgabetermin für diesen Flug ist überschritten");
define("_NO_PILOT_OLC_DATA","<p><strong>Keine OLC Daten für diesen Piloten</strong><br>
  <br>
<b>Was ist OLC / Wofür sind die entsprechenden Felder ?</b><br><br>
	Für eine gültige Übertragung an OLC muss der Pilot im OLC System registriert sein.</p>
<p> Dies kannst Du auf dieser<a href='http://www2.onlinecontest.org/olcphp/2005/ausw_wertung.php?olc=holc-i&spr=en' target='_blank'>
   Webseite</a> tun. Dort must Du Dein Land auswählen und dann 'Contest Registration'<br>
</p>
<p>Wenn die Registrierung abgeschlossen ist, musst Du auf 'Pilot Profile'->'Edit OLC info' gehen um dort Deine Informationen EXCAKT so einzugeben wie bei der OLC Registrierung.
</p>
<ul>
	<li><div align=left>Vorname</div>
	<li><div align=left>Nachname</div>
	<li><div align=left>Geburtsdatum</div>
	<li> <div align=left>Dein Rufsignal</div>
	<li><div align=left>Wenn Du bereits Flüge beim OLC eingereicht hast, dann hier die 4 Buchstaben die Du für die IGC Dateien verwendest</div>
</ul>");
define("_OLC_MAP","Karte");
define("_OLC_BARO","Luftdruck");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","Piloten Profil");
define("_back_to_flights","zurück zu den Flügen");
define("_pilot_stats","Piloten Status");
define("_edit_profile","Proil bearbeiten");
define("_flights_stats","Flug Statistiken");
define("_View_Profile","Profil anzeigen");

define("_Personal_Stuff","Persönliche Angaben");
define("_First_Name"," Vorname");
define("_Last_Name","Nachname");
define("_Birthdate","Geburtstag");
define("_dd_mm_yy","tt.mm.jj");
define("_Sign","Rufsignal");
define("_Marital_Status","Familienstand");
define("_Occupation","Beruf");
define("_Web_Page","Webseite");
define("_N_A","N/A");
define("_Other_Interests","Andere Interessen");
define("_Photo","Foto");

define("_Flying_Stuff","Fliegerische Angaben");
define("_note_place_and_date","falls zutreffend bitte Ort und Datum eintragen");
define("_Flying_Since","Fliegen seit");
define("_Pilot_Licence","Piloten Lizenz");
define("_Paragliding_training","Paragliding Training");
define("_Favorite_Location","Lieblings Fluggebiet");
define("_Usual_Location","Häufigstes Fluggebiet");
define("_Best_Flying_Memory","Bester Flugmoment");
define("_Worst_Flying_Memory","Schlimmster Flugmoment");
define("_Personal_Distance_Record","Persönlicher Streckenrekord");
define("_Personal_Height_Record","Persönlicher Höhen Rekord");
define("_Hours_Flown","Anzahl Flugstunden");
define("_Hours_Per_Year","Flugstunden pro Jahr");

define("_Equipment_Stuff","Ausrüstungsangaben");
define("_Glider","Drachentyp"); 
define("_Harness","Gurtzeug");
define("_Reserve_chute","Rettungsschirm");
define("_Camera","Kamera");
define("_Vario","Vario");
define("_GPS","GPS");
define("_Helmet","Helm");
define("_Camcorder","Camcorder");

define("_Manouveur_Stuff","Flugfiguren Angaben");
define("_note_max_descent_rate","falls gemessen, max erreichtes Sinken");
define("_Spiral","Spirale");
define("_Bline","B-Stall");
define("_Full_Stall","Full Stall");
define("_Other_Manouveurs_Acro","andere Acro Figuren");
define("_Sat","SAT");
define("_Asymmetric_Spiral","Asymmetrische Spirale");
define("_Spin","Spin");

define("_General_Stuff","Allgemeine Angabe");
define("_Favorite_Singer","Lieblingssänger");
define("_Favorite_Movie","Lieblingsfilm");
define("_Favorite_Internet_Site","Lieblings<br>Internet Seite");
define("_Favorite_Book","Lieblingsbuch");
define("_Favorite_Actor","Lieblingsschauspieler");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","Neues Foto hochladen oder bisheriges ersetzen");
define("_Delete_Photo","Foto löschen");
define("_Your_profile_has_been_updated","Dein Profil wurde aktualisiert");
define("_Submit_Change_Data","Daten übertragen - aktualisieren");

//--------------------------------------------
// pilot_ïlc_profile_edit.php
//--------------------------------------------
define("_edit_OLC_info","OLC Info anpassen");
define("_OLC_information","OLC Information");
define("_callsign","Rufsignal");
define("_filename_suffix","Dateikennung");
define("_OLC_Pilot_Info","OLC Piloten Info");
define("_OLC_EXPLAINED","<b>Was ist OLC / Wofür sind die entsprechenden Felder ?</b><br><br>
	Für eine gültige Übertragung an OLC muss der Pilot im OLC System registriert sein.</p>
<p> Dies kannst Du auf dieser<a href='http://www2.onlinecontest.org/olcphp/2005/ausw_wertung.php?olc=holc-i&spr=en' target='_blank'>
   Webseite</a> tun. Dort must Du Dein Land auswählen und dann 'Contest Registration'<br>
</p>
<p>Wenn die Registrierung abgeschlossen ist, musst Du auf 'Pilot Profile'->'Edit OLC info' gehen um dort Deine Informationen EXCAKT so einzugeben wie bei der OLC Registrierung.
</p>
<ul>
	<li><div align=left>Vorname</div>
	<li><div align=left>Nachname</div>
	<li><div align=left>Geburtsdatum</div>
	<li> <div align=left>Dein Rufsignal</div>
	<li><div align=left>Wenn Du bereits Flüge beim OLC eingereicht hast, dann hier die 4 Buchstaben die Du für die IGC Dateien verwendest</div>
</ul>
");

define("_OLC_SUFFIX_EXPLAINED","<b>Was ist eine 'Dateikennung?'</b><br>Dies ist eine 4 Buchstabenkennung die einen Piloten oder Gleitschirm eindeutig identifiziert. 
Wenn Du wirklich nicht weisst was Du hier eintragen sollst, dann findest Du hier ein paar Tips:<p>
<ul>
<li>Leite 4 Buchstaben von Deinem Vor- und Nachnamen ab.
<li>Versuche eine ungewöhnliche Kombination zu finden. Dies verringert die Möglichkeit dass Deine Kennung die selbe ist wie die anderer Piloten.
<li>Solltest Du Probleme haben Deinen Flug über Leonardo beim OLC einzureichen, könnte dies an Deiner Kennung liegen. Ändere die Kennung und dann versuche es nochmal.
</ul>");
//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","hh:mm");

define("_Totals","Gesamtaufstellung");
define("_First_flight_logged","Erster aufgezeichneter Flug");
define("_Last_flight_logged","Letzter aufgezeichneter Flug");
define("_Flying_period_covered","Zeitraum");
define("_Total_Distance","Gesamt Distanz");
define("_Total_OLC_Score","Gesamt OLC Punktzahl");
define("_Total_Hours_Flown","Gesamt Flugstunden");
define("_Total_num_of_flights","Gesamt Anzahl Flüge ");

define("_Personal_Bests","Persönliche Bestleistungen");
define("_Best_Open_Distance","Beste Offene Distanz");
define("_Best_FAI_Triangle","Bestes FAI Dreieck");
define("_Best_Free_Triangle","Bestes Freies Dreieck");
define("_Longest_Flight","Längster Flug");
define("_Best_OLC_score","Beste OLC Punktzahl");

define("_Absolute_Height_Record","Absoluter Höhen Rekord");
define("_Altitute_gain_Record","Höhengewinn Rekord");
define("_Mean_values","Durchschnittswerte");
define("_Mean_distance_per_flight","Durchschnittliche Distanz pro Flug");
define("_Mean_flights_per_Month","Durchscnittliche Anzahl Flüge pro Monat");
define("_Mean_distance_per_Month","Durchschnittliche Distanz pro Monat");
define("_Mean_duration_per_Month","Durchschnittliche Flugdauer pro Monat");
define("_Mean_duration_per_flight","Durchschnittliche Flugdauer pro Flug");
define("_Mean_flights_per_Year","Durchschnittliche Anzahl Flüge pro Jahr");
define("_Mean_distance_per_Year","Durchschnittliche Distanz pro Jahr");
define("_Mean_duration_per_Year","Durchschnittliche Flugdauer pro Jahr");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","Flüge in der Nähe dieses Punktes anzeigen");
define("_Waypoint_Name","Wegepunkt Name");
define("_Navigate_with_Google_Earth","Mit Google Earth navigieren");
define("_See_it_in_Google_Maps","In Google Map anzeigen");
define("_See_it_in_MapQuest","In MapQuest anzeigen");
define("_COORDINATES","Koordinaten");
define("_FLIGHTS","Flüge");
define("_SITE_RECORD","Fluggebietsrekord");
define("_SITE_INFO","Fluggebietsinformation");
define("_SITE_REGION","Region");
define("_SITE_LINK","Link für mehr Information");
define("_SITE_DESCR","Fluggebiets/Startplatz Beschreibung");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","Mehr Details anzeigen");
define("_KML_file_made_by","KML File erstellt durch");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","Startplatz registrieren");
define("_WAYPOINT_ADDED","Startplatz wurde registriert");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","Fluggebietsrekord<br>(offene Distanz)");
	
//--------------------------------------------
// glider types
//--------------------------------------------

define("_GLIDER_TYPE","Fluggerätetyp"); 
function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'Gleitschirm',2=>'Flex wing FAI1',4=>'Starfl?gler FAI5',8=>'Drachen'); 
	foreach ($CONF_glider_types as $gId=>$gName) if (!$gliderCatList[$gId]) $gliderCatList[$gId]=$gName;
}
setGliderCats();

//--------------------------------------------
// user prefs  & units
//--------------------------------------------

define("_Your_settings_have_been_updated","Deine Einstellungen wurden aktualisiert");

define("_THEME","Theme");
define("_LANGUAGE","Sprache");
define("_VIEW_CATEGORY","Kategorie anzeigen");
define("_VIEW_COUNTRY","Land anzeigen");
define("_UNITS_SYSTEM" ,"Masssystem");
define("_METRIC_SYSTEM","Metrisches System (km,m)");
define("_IMPERIAL_SYSTEM","Britisches System (miles,feet)");
define("_ITEMS_PER_PAGE","Elemente pro Seite");

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

define("_WORLD_WIDE","Weltweit");
define("_National_XC_Leagues_for","Nationale XC Ligen für");
define("_Flights_per_Country","Fl?ge je Land");
define("_Takeoffs_per_Country","Starts je Land");
define("_INDEX_HEADER","Willkommen zur Leonardo XC Liga");
define("_INDEX_MESSAGE","Du kannst das Hauptmenu zur Navigation nutzen oder die unten angezeigten Favoriten.");

define("_Best_flights_for","Besten Flüge für ");

define("_Latest_flights","Latest flights");
define("_FLIGHTS_STATS","Flugstatistik"); 


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
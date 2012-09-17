<?php
/**************************************************************************/
/*  German language translation by                                        */
/*  Torsen (www.para365.com                                         */
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
	global  $monthList,	$monthListShort, $weekdaysList;
	$monthList=array('Januar','Februar','Maerz','April','Mai','Juni',
					'Juli','August','September','Oktober','November','Dezember');
	$monthListShort=array('JAN','FEB','MRZ','APR','MAI','JUN','JUL','AUG','SEP','OKT','NOV','DEZ');
	$weekdaysList=array('Mo','Di','Mi','Do','Fr','Sa','So') ;
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","Freier Flug");
define("_FREE_TRIANGLE","Flaches Dreieck");
define("_FAI_TRIANGLE","FAI Dreieck");

define("_SUBMIT_FLIGHT_ERROR","Bei der Übermittlung des Fluges ist ein Fehler aufgetreten");

// list_pilots()
define("_NUM","#");
define("_PILOT","Pilot");
define("_NUMBER_OF_FLIGHTS","Anzahl Flüge");
define("_BEST_DISTANCE","Beste Distanz");
define("_MEAN_KM","Durchschnittliche # Kilometer pro Flug");
define("_TOTAL_KM","Summe Flugkilometer");
define("_TOTAL_DURATION_OF_FLIGHTS","Summe Flugstunden");
define("_MEAN_DURATION","Durschnittliche Flugstunden");
define("_TOTAL_OLC_KM","Summe XC Kilometer");
define("_TOTAL_OLC_SCORE","Summe Punkte");
define("_BEST_OLC_SCORE","Beste XC Punkte");
define("_From","von");

// list_flights()
define("_DURATION_HOURS_MIN","Dauer (h:m)");
define("_SHOW","Anzeigen");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","Der Flug wird in 1-2 Minuten aktiviert. ");
define("_TRY_AGAIN","Bitte versuche es später noch einmal");
define("_SEASON","Saison");
define("_TAKEOFF_LOCATION","Startplatz");
define("_TAKEOFF_TIME","Startzeitpunkt");
define("_LANDING_LOCATION","Landeplatz");
define("_LANDING_TIME","Landezeitpunkt");
define("_OPEN_DISTANCE","Luftlinie");
define("_MAX_DISTANCE","Maximale Distanz");
define("_OLC_SCORE_TYPE","XC Punkte Typ");
define("_OLC_DISTANCE","XC Distanz");
define("_OLC_SCORING","DHV-XC Punkte");
define("_MAX_SPEED","Maximale Geschwindigkeit");
define("_MAX_VARIO","Maximales Steigen");
define("_MEAN_SPEED","Durchschnittsgeschw.(Luft)");
define("_MEAN_SPEED1","Durchschnitts km/h");

define("_MIN_VARIO","Maximales Sinken");
define("_MAX_ALTITUDE","Grösste Höhe (über NN)");
define("_TAKEOFF_ALTITUDE","Start Höhe (über NN)");
define("_MIN_ALTITUDE","Minimale Höhe (ner NN)");
define("_ALTITUDE_GAIN","Höhen Zugewinn");
define("_FLIGHT_FILE","Flug Datei");
define("_COMMENTS","Kommentare");
define("_RELEVANT_PAGE","relevante Webseiten URL");
define("_GLIDER","Hersteller/Gerät");
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
define("_OLC_KM","XC Kilometer");
define("_OLC_SCORE","XC Punkte");
define("_DATE_ADDED","Letzte Übermittlungen");

define("_SORTED_BY","Sortiert nach:");
define("_ALL_YEARS","Alle Jahre");
define("_SELECT_YEAR_MONTH","Jahr (und Monat) auswählen");
define("_ALL","Alle");
define("_ALL_PILOTS","Alle Piloten anzeigen");
define("_ALL_TAKEOFFS","Alle Starts anzeigen");
define("_ALL_THE_YEAR","Alle Jahre anzeigen");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","Du hast keine Datei angegeben");
define("_NO_SUCH_FILE","Die angegebene Datei kann nicht gefunden werden");
define("_FILE_DOESNT_END_IN_IGC","Die angegebene Datei hat keine .igc Endung");
define("_THIS_ISNT_A_VALID_IGC_FILE","Keine gültige .igc Datei");
define("_THERE_IS_SAME_DATE_FLIGHT","Eine Datei mit dem selben Datum und Uhrzeit existiert bereits");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","Wenn Du diese Datei ersetzen möchtest, sollte Du zuerst");
define("_OUTSIDE_SUBMIT_WINDOW","Wertungs-Einreichfrist bereits abgelaufen. (14 Tage bzw. 48 Std nach Saisonsende.)<br>Diese Flug kann nur unter Category -> Nur Flugbuch eingereicht werden.");
define("_DELETE_THE_OLD_ONE","die Alte löschen");
define("_THERE_IS_SAME_FILENAME_FLIGHT","Eine Datei mit dem selben Nahmen exisitiert bereits");
define("_CHANGE_THE_FILENAME","Sollte dieser Flug unterschiedlich sein, dann ändere bitte den Dateinamen und versuche es noch einmal");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","Dein Flug wurde eingereicht");
define("_PRESS_HERE_TO_VIEW_IT","Zum ansehen hier klicken");
define("_WILL_BE_ACTIVATED_SOON","(er wird in 1-2 Minuten aktiviert)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Mehrere Flüge einreichen");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","Flug Einreichfrist: 14 Tage.<br>Es werden nur IGC Datein in den ZIP verarbeitet");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","Übertrage die ZIP Datei<br>die die Flüge beinhaltet");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","Zum Einreichen der Flüge hier klicken");
define("_DHV_DISCLAIMER","Mit der Einreichung des Fluges bestätige ich, dass ich alle luftrechtlichen Bestimmungen eingehalten habe. Falls Freigaben für bestimmte Lufträume erforderlich waren, habe ich diese bei der zuständigen Stelle eingeholt.");
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
define("_PROJECT_HELP","Hilfe");
define("_PROJECT_NEWS","News");
define("_PROJECT_RULES","Ausschreibung 2007");

// menu bar
define("_MENU_MAIN_MENU","Piloten");
define("_MENU_DATE","Datum auswählen");
define("_MENU_COUNTRY","Land auswählen");
define("_MENU_XCLEAGUE","Wertungslisten");
define("_MENU_XCLEAGUE2","Top 6 (Weltweit)");

define("_MENU_ADMIN","Admin");

define("_MENU_COMPETITION_LEAGUE","Wertung - Alle Kategorien");
define("_MENU_OLC","DHV-XC Punkte");
define("_MENU_OPEN_DISTANCE","Offene Distanz");
define("_MENU_DURATION","Dauer");
define("_MENU_ALL_FLIGHTS","Alle Flüge anzeigen");
define("_MENU_FLIGHTS","Flüge");
define("_MENU_TAKEOFFS","Startplatz");
define("_MENU_FILTER","Filter");
define("_MENU_FILTER2","Filter: nur Flüge >15km");
define("_MENU_MY_FLIGHTS","Meine Flüge");
define("_MENU_MY_PROFILE","Mein Profil");
define("_MENU_MY_STATS","Meine Statistik");
define("_MENU_MY_SETTINGS","Meine Einstellungen");
define("_MENU_SUBMIT_FLIGHT","Flüge einreichen");
define("_MENU_SUBMIT_FROM_ZIP","Flüge mittels ZIP einreichen");
define("_MENU_SHOW_PILOTS","Statistik");
define("_MENU_SHOW_LAST_ADDED","Letzte Einreichungen anzeigen");

define("_SELECT_YEAR","Jahr auswählen");
define("_SELECT_MONTH","Monat auswählen");
define("_ALL_COUNTRIES","Alle Länder anzeigen");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","ALLE ZEITEN");
//already defined define("_NUMBER_OF_FLIGHTS","Anzahl Flüge");
define("_TOTAL_DISTANCE","Gesamt Distanz");
define("_TOTAL_DURATION","Gesamt Flugdauer");
define("_BEST_OPEN_DISTANCE","Beste Distanz");
define("_TOTAL_OLC_DISTANCE","Gesamt DHV-XC Distanz");
//already defined define("_TOTAL_OLC_SCORE","Gesamt DHV-XC (International) Punkte");
//already defined define("_BEST_OLC_SCORE","Best DHV-XC (International) score");
//already defined define("_MEAN_DURATION","Durchschnittliche Flugdauer");
define("_MEAN_DISTANCE","Durchschnittliche Distanz");
define("_PILOT_STATISTICS_SORT_BY","Piloten - sortiert nach");
define("_CATEGORY_FLIGHT_NUMBER","Kategorie Anzahl der Flüge");
define("_CATEGORY_TOTAL_DURATION","Kategorie Gesamt Flugdauer aller Flüge");
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

define("_LEAGUE_RESULTS","Rank");
define("_N_BEST_FLIGHTS"," beste Flüge");
define("_OLC","DHV-XC ");
define("_OLC_TOTAL_SCORE","DHV-XC Gesamtpunkte");
define("_KILOMETERS","Kilometer");
define("_TOTAL_ALTITUDE_GAIN","Gesamt Höhengewinn");
//already defined define("_TOTAL_KM","Gesamt Kilometer");

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
define("_SELECT_CLUB","Verein auswählen");
define("_THE_CLUB","Verein");

define("_THE_COUNTRY","Das Land");
define("_COUNTRY","Land*");
define("_SELECT_COUNTRY","Land auswählen");
define("_OTHER_FILTERS","Andere Filter");
define("_LINEAR_DISTANCE_SHOULD_BE","Die Luftlinie sollte ... sein");
define("_OLC_DISTANCE_SHOULD_BE","Die DHV-XC Distanz sollte ... sein");
define("_OLC_SCORE_SHOULD_BE","Die DHV-XC Punktzahl sollte ... sein");
define("_DURATION_SHOULD_BE","Die Flugdauer sollte ... sein");
define("_ACTIVATE_CHANGE_FILTER","Filter Aktivieren / Ändern");
define("_DEACTIVATE_FILTER","Filter deaktivieren");
define("_HOURS","Stunden");
define("_MINUTES","Minuten");
define("_Today_is","Heute ist");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","Flug einreichen");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","Wertungs Einreichfrist: 14 Tage.<br>Flüge werden außerhalb dieser Frist nur im Piloten Flugbuch angezeigt.");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","Übertrage das<br>IGC File des Fluges");
define("_NOTE_TAKEOFF_NAME","Bitte beachte den Namen des Startplatzes /-gebietes und das Land");
define("_COMMENTS_FOR_THE_FLIGHT","Kommentare zum Flug");
define("_PHOTO","Foto");
define("_PHOTOS_GUIDELINES","Fotos sollten im jpg Format und kleiner als ");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","Hier klicken um den Flug einzureichen");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","Möchtest Du mehrere Flüge auf einmal einreichen ?");
define("_PRESS_HERE","Hier klicken");

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
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","Um die Flug Daten zu ändern bitte hier klicken");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","Die Änderungen wurden berücksichtigt");
define("_RETURN_TO_FLIGHT","Zurück zum Flug");

//--------------------------------------------
// olc
//--------------------------------------------
//already defined define("_RETURN_TO_FLIGHT","Zurück zum Flug");
define("_READY_FOR_SUBMISSION","Fertig zur Übertragung");
define("_SUBMIT_TO_OLC","Übertragung zum FAI");
define("_YOUR_FLIGHT_HAS_BEEN_SUCCESSFULLY_SUBMITED_TO_THE_OLC","Der Flug wurde erfolgreich zum FAI übertragen");
define("_THE_OLC_REFERENCE_NUMBER_IS","Die FAI Referenz Nummer ist");
define("_THERE_WAS_A_PROBLEM_ON_OLC_SUBMISSION","Es ist ein Problem bei der Übertragung zum FAI augetreten");
define("_LOOK_BELOW_FOR_THE_CAUSE_OF_THE_PROBLEM","Bitte schaue nach unten für die mögliche Ursache des Problems");
define("_FLIGHT_SUCCESFULLY_REMOVED_FROM_OLC","Der Flug wurde erfolgreich vom FAI gelöscht");
define("_FLIGHT_NOT_SCORED","Der Flug hat keine DHV-XC Punkte und kann daher nicht eingereicht werden");
define("_TOO_LATE","Der Abgabetermin ist überschritten, daher kann der Flug nicht eingereicht werden");
define("_CANNOT_BE_SUBMITTED","Der Abgabetermin für diesen Flug ist überschritten");
define("_NO_PILOT_OLC_DATA","<p><strong>Keine FAI Daten für diesen Piloten</strong><br>
  <br>
<b>Was ist OLC / Wofür sind die entsprechenden Felder ?</b><br><br>
	Für eine gültige Übertragung an FAI muss der Pilot im FAI System registriert sein.</p>
<p> Dies kannst Du auf dieser<a href='http://www2.onlinecontest.org/olcphp/2005/ausw_wertung.php?olc=holc-i&spr=en' target='_blank'>
   Webseite</a> tun. Dort must Du Dein Land auswählen und dann 'Contest Registration'<br>
</p>
<p>Wenn die Registrierung abgeschlossen ist, musst Du auf 'Pilot Profile'->'Edit FAI info' gehen um dort Deine Informationen EXCAKT so einzugeben wie bei der FAI Registrierung.
</p>
<ul>
	<li><div align=left>Vorname</div>
	<li><div align=left>Nachname</div>
	<li><div align=left>Geburtsdatum</div>
	<li> <div align=left>Dein Rufsignal</div>
	<li><div align=left>Wenn Du bereits Flüge beim FAI eingereicht hast, dann hier die 4 Buchstaben die Du für die IGC Dateien verwendest</div>
</ul>");
define("_OLC_MAP","Karte");
define("_OLC_BARO","Luftdruck");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","Piloten Profil");
define("_back_to_flights","zurück zu den Flügen");
define("_pilot_stats","Piloten Status");
define("_edit_profile","Profil bearbeiten");
define("_flights_stats","Flug Statistiken");
define("_View_Profile","Profil anzeigen");

define("_Personal_Stuff","Persönliche Angaben - bitte nur echte Namen verwenden.<br>Anmeldungen mit Nicknames werden vom Administrator gelöscht.");
define("_First_Name"," Vorname*");
define("_Last_Name","Nachname*");
define("_Birthdate","Geburtstag*");
define("_dd_mm_yy","jjjj-mm-tt");
define("_Sign","Rufsignal");
define("_Sponsor","Sponsor");
define("_RESIDENCE","Wohnsitz");
define("_pilot_email","Email Adresse");
define("_pilot_password","Kennwort");

define("_hidden","************");
define("_Club","Verein");
define("_Select_CLub","Verein auswählen");
define("_Select_Club","Verein auswählen");
define("_Close_window","Schliessen");


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

define("_Equipment_Stuff","Angaben zur Ausrüstung");
define("_Glider","Hersteller/Gerät");
define("_Harness","Gurtzeug");
define("_Reserve_chute","Rettungsschirm");
define("_compulsory_entries","Beachte bitte das Felder, die mit einem * gekennzeichnet sind, Pflichteingaben sind.");

define("_Camera","Kamera");
define("_Vario","Vario");
define("_GPS","GPS");
define("_Helmet","Helm");
define("_Camcorder","Camcorder");

define("_Manouveur_Stuff","Flugfiguren Angaben");
define("_note_max_descent_rate", "falls gemessen, max erreichtes Sinken");
define("_Spiral", "Spirale");
define("_Bline", "B-Stall");
define("_Full_Stall", "Full Stall");
define("_Other_Manouveurs_Acro", "andere Acro Figuren");
define("_Sat", "SAT");
define("_Asymmetric_Spiral", "Asymmetrische Spirale");
define("_Spin", "Spin");

define("_General_Stuff","Allgemeine Angaben");
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
// Added by Martin Jursa, 26.04.2007 for pilot_profile and pilot_profile_edit
//--------------------------------------------
define('_Sex', 'Geschlecht');
define('_Login_Stuff', 'Login-Daten ändern');
define('_PASSWORD_CONFIRMATION', 'Bestätigung des Kennwortes');
define('_EnterPasswordOnlyToChange', 'Kennwort hier nur eingeben, wenn es geändert werden soll:');

define('_PwdAndConfDontMatch', 'Kennwort und Bestätigung stimmen nicht überein.');
define('_PwdTooShort', 'Das Kennwort ist zu kurz. Es muss mindestens $passwordMinLength Zeichen lang sein.');
define('_PwdConfEmpty', 'Das Kennwort wurde nicht bestätigt.');
define('_PwdChanged', 'Das Kennwort wurde geändert.');
define('_PwdNotChanged', 'Das Kennwort wurde NICHT geändert.');
define('_PwdChangeProblem', 'Es ist ein Problem beim Ändern des Kennwortes aufgetreten.');

define('_EmailEmpty', 'Die Email Adresse darf nicht leer sein.');
define('_EmailInvalid', 'Die Email Adresse ist ungültig.');
define('_EmailSaved', 'Die Email Adresse wurde gespeichert');
define('_EmailNotSaved', 'Die Email Adresse wurde nicht gespeichert.');
define('_EmailSaveProblem', 'Es ist ein Problem beim Speichern der Email Adresse aufgetreten.');

// End 26.04.2007



//--------------------------------------------
// pilot_ïlc_profile_edit.php
//--------------------------------------------
define("_edit_OLC_info","FAI Info anpassen");
define("_OLC_information","FAI Information");
define("_callsign","Rufsignal");
define("_filename_suffix","Dateikennung");
define("_OLC_Pilot_Info","FAI Piloten Info");
define("_OLC_EXPLAINED","<b>Was ist FAI / Wofür sind die entsprechenden Felder ?</b><br><br>
	Für eine gültige Übertragung an FAI muss der Pilot im FAI System registriert sein.</p>
<p> Dies kannst Du auf dieser<a href='http://www2.onlinecontest.org/olcphp/2005/ausw_wertung.php?olc=holc-i&spr=en' target='_blank'>
   Webseite</a> tun. Dort must Du Dein Land auswählen und dann 'Contest Registration'<br>
</p>
<p>Wenn die Registrierung abgeschlossen ist, musst Du auf 'Pilot Profile'->'Edit FAI info' gehen um dort Deine Informationen EXACKT so einzugeben wie bei der FAI Registrierung.
</p>
<ul>
	<li><div align=left>Vorname</div>
	<li><div align=left>Nachname</div>
	<li><div align=left>Geburtsdatum</div>
	<li> <div align=left>Dein Rufsignal</div>
	<li><div align=left>Wenn Du bereits Flüge beim FAI eingereicht hast, dann hier die 4 Buchstaben die Du für die IGC Dateien verwendest</div>
</ul>
");

define("_OLC_SUFFIX_EXPLAINED","<b>Was ist eine 'Dateikennung?'</b><br>Dies ist eine 4 Buchstabenkennung die einen Piloten oder Gleitschirm eindeutig identifiziert.
Wenn Du wirklich nicht weisst was Du hier eintragen sollst, dann findest Du hier ein paar Tips:<p>
<ul>
<li>Leite 4 Buchstaben von Deinem Vor- und Nachnamen ab.
<li>Versuche eine ungewöhnliche Kombination zu finden. Dies verringert die Möglichkeit dass Deine Kennung die selbe ist wie die anderer Piloten.
<li>Solltest Du Probleme haben Deinen Flug über Leonardo beim FAI einzureichen, könnte dies an Deiner Kennung liegen. Ändere die Kennung und dann versuche es nochmal.
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
define("_Total_OLC_Score","Gesamt DHV-XC Punktzahl");
define("_Total_Hours_Flown","Gesamt Flugstunden");
define("_Total_num_of_flights","Gesamt Anzahl Flüge ");

define("_Personal_Bests","Persönliche Bestleistungen");
define("_Best_Open_Distance","Beste Offene Distanz");
define("_Best_FAI_Triangle","Bestes FAI Dreieck");
define("_Best_Free_Triangle","Bestes Freies Dreieck");
define("_Longest_Flight","Längster Flug");
define("_Best_OLC_score","Beste DHV-XC Punktzahl");

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
	$gliderCatList=array(1=>'Gleitschirm',2=>'Drachen FAI1',4=>'Starrflügler FAI5',8=>'Starrflügler FAI2');
	foreach ($CONF_glider_types as $gId=>$gName) if (!$gliderCatList[$gId]) $gliderCatList[$gId]=$gName;
}
setGliderCats();


//--------------------------------------------
// class types
//--------------------------------------------
function setClassList() {
	$CONF_TEMP['gliderClasses'][1]['classes']=array(4=>"Fun Cup",5=>"Standard",1=>"Sport",3=>"Tandem",2=>"Performance");
	$CONF_TEMP['gliderClasses'][2]['classes']=array(1=>"Turmdrachen",2=>"Turmloser Drachen");
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
	$xcTypesList=array(1=>"Freie Strecke (3 WP)",2=>"Flaches Dreieck",4=>"FAI Dreieck");
	foreach ($CONF_xc_types as $gId=>$gName) if (!$xcTypesList[$gId]) $xcTypesList[$gId]=$gName;
}
setXCtypesList(); 
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
define("_National_XC_Leagues_for","Nationale XC Wertungen für");
define("_Flights_per_Country","Flüge je Land");
define("_Takeoffs_per_Country","Starts je Land");
define("_INDEX_HEADER","Willkommen zur DHV-XC");
define("_INDEX_MESSAGE","Du kannst das Hauptmenu zur Navigation nutzen oder die unten angezeigten Favoriten.");
define("_INDEX_HELP","<b>Kurzanleitung zur Registrierung und zum Login beim DHV-XC Server.</b><br>
<br>
<b>Registrierung:</b><br>
Unter dem Menü-Punkt  ´Piloten´ auf  ´Registrieren´ gehen <br>
Akzeptiere bitte die Teilnehmerbedingungen um zur Eingabseite zu gelangen<br>
Gib bitte Deinen Namen, Deine Email Adresse und ein Kennwort ein. Deine Email Adresse wird benötigt, um Dein Konto zu aktivieren<br>
Bestätige bitte den Registrierungs Code und klick auf ´Absenden´<br>
Ein Aktivierungs-Email wird an die angegebene Email Adresse versandt. Ruf bitte dieses Email auf und klick auf den Link der darin enthalten ist<br>
Deine Konto Aktivierung wird bestätigt<br>
<br>
<b>Login:</b><br>
Unter Menü-Punkt ´Piloten´ auf ´Login´ gehen
Gib bitte Deinen Namen und Dein Kennwort ein um einzuloggen<br>
Als erstes erscheint Dein aktuelles Piloten Profil (das am Anfang leer ist!)<br>
Klick bitte rechts oben auf ´Profil bearbeiten´ um die Felder auszufüllen<br>
Beachte bitte, dass die Felder, die mit einem * gekennzeichnet sind, Pflichteingaben sind<br>
Alle registrierte Piloten werden automatisch an der weltweiten XC Wertung teilnehmen<br>
Wenn Du an der Deutschen Streckenflugmeisterschaft (German National Scoring) teilnehmen willst, lies bitte weiter, ansonsten kannst Du jetzt schon Deine Flüge hochladen<br>
<br>
<b>Teilnahme an der Deutschen Streckenflugmeisterschaft</b><br>
Vorraussetzung:<br>
Erstens musst Du Mitglied des DHV sein<br>
Zweitens musst Du im DHV Admin Portal registriert sein<br>
Über das Admin Portal bietet der DHV seinen Mitglieder zunehmend viele Dienstleistungen an, z.B. die Verwaltung der eigenen Mitgliederdaten, privilegierten Zugang zum Forum etc..  <br>
Um an der Deutschen Streckenflugmeisterschaft teilzunehmen, muss in Deinem Piloten Profil unter dem Punkt ´Mitglied von´  den DHV auswählen<br>
Danach bitte auf den Link ´Mitgliedsnummer automatisch holen´ klicken<br>
Es öffnet sich  ein Fenster, in dem Du Deinen Admin Portal Benutzernamen und Dein Kennwort eingeben  musst<br>
Solltest Du noch keinen Admin Portal Benutzernamen und kein Kennwort haben, kannst Du Dich hier im DHV Admin Portal registrieren<br>
Wichtig - der Benutzername und das Kennwort für das Admin Portal ist nicht notwendigerweise gleich  mit dem Benuzternamen und dem Kennwort  des DHV Forums<br>
Nach erfolgreicher Überprüfung Deines Admin Portal Benutzernamens und Deines Kennworts, wird Deine DHV Mitgliedsnummer eingetragen, und Du bist Teilnahmer an der  Deutschen Streckenflugmeisterschaft <br>
<br>
<b>Flüge einreichen</b><br>
Jetzt kannst Du einzelne Flüge ab den 10.10.2006 in dem Menü-Punkt ´Piloten´  unter ´Flüge einreichen´ hochladen<br>
oder mehrere Flüge in einer ZIP Datei in dem Menü-Punkt  ´Piloten´ unter ´Flüge mittels ZIP einreichen´ hochladen<br>
<br>
Für Fragen bezüglich der Auswertung, kontaktiere bitte das Auswerter Team unter auswerter@xc.dhv.de<br>
Für Fragen bezüglich technische Probleme kontaktiere bitte den Administrator unter admin@xc.dhv.de<br>

");

define("_INDEX_NEWS","<b>News</b><br><br>
<b>Start 1.03.2007</b><br>
<b>Update 10.03.2007</b><br>

Folgende Modules sind Online und Funktionsfähig:<br>
Allgemeine Anmeldung<br>
Piloten Profil<br>
DHV Streckenflugmeisterschaft Anmeldung<br>
Tagesflugbuch<br>
Internationale Wertung (6 Flüge Weltweit)<br>
Deutsche Wertung (3 Flüge innerhalb Europa, davon ein Start in Deutschland)<br>
Leonardo Startplatzführer<br>
Leonardo Statistik<br>
Leonardo RSS Feed<br>
Google Maps<br>
Google Earth Export<br>
Language Auswahl<br>
Doppel Meldungen Verhindern<br>
G-Record Validierung<br>
Vereinsmeldung<br>
Vereinswertung<br>
Ausschreibung aktualisiert<br>
ÖAEC Drachenflieger Anmeldung<br>
ÖAEC Drachenflieger Wertung<br>
<br>
<b>Im Bearbeitung</b><br>
Damenwertung<br>
Juniorwertung<br>
Newcomerwertung<br>
Bundesliga Wertung<br>
<br>
<b>Anmerkung</b><br>
Leonardo arbeitet nur mit roh-Daten (igc Dateien) und nicht mit optimierten-Daten (olc Dateien).<br>
Alle Flüge werden nach dem Optimierungsschema von Leonardo ausgewertet .<br>
Um die Serverlast gering zu halten, haben wir uns am Anfang für eine einfache und schnelle Optimierung entschieden.
Aufwendigere Optimierungssoftware (z.B. SeeYou, CompeGPS oder MaxPunkte) wird daher möglicherweise zum unterschiedlichen Ergebnissen führen.
<br>
G-Record Validierung wird für die Bereits eingereichten Flüge nachgeholt. Validierung wird über nacht laufen, um Serverlast während des Tages gering zu halten.<br>

Um igc Rohdaten herunterzuladen, benutze bitte den Kontext Menu *Link Speichern unter* im Browser. Die jetzige Textausgabe ist für schnelle Problem Identifizierung gedacht.<br>
<br>
Bitte trägt im Piloten Profil die Verein oder National Aero Club Mitgliedschaft ein um in den Vereins- bzw. Österreichische Drachenwertung zu erscheinen.<br>
");

define("_Best_flights_for","Besten Flüge für ");

define("_Latest_flights","Neusten Flüge");
define("_FLIGHTS_STATS","Flugstatistik");


//--------------------------------------------
// NEW
//--------------------------------------------
define("_MENU_SUMMARY_PAGE","Zusammenfassung");
define("_Display_ALL","Alle Anzeigen");
define("_Display_NONE","Keine Anzeigen");
define("_Reset_to_default_view","Standardeinstellungen wiederherstellen");
define("_No_Club","Kein Verein");
define("_This_is_the_URL_of_this_page","Zur Favoriten hinzufügen");
define("_All_glider_types","Alle Geräte");

define("_MENU_SITES_GUIDE","Startplatz Fuhrer");
define("_Site_Guide","Startplatz Fuhrer");

define("_Search_Options","Suchoptionen");
define("_Below_is_the_list_of_selected_sites","Ausgewählte Startplätze");
define("_Clear_this_list","Liste löschen");
define("_See_the_selected_sites_in_Google_Earth","Ausgewählte Sites in Google Earth ansehen");
define("_Available_Takeoffs","Verfügbare Startplätze");
define("_Search_site_by_name","Startplatz Suche");
define("_give_at_least_2_letters","mind. 2 Buchstäbe!");
define("_takeoff_move_instructions_1","Alle Startplätze zum Auswahl-Liste mit >> oder einzeln Startpläte mit > ");
define("_Takeoff_Details","Startplatz Details");


define("_Takeoff_Info","Startplatz Info");
define("_XC_Info","DHV-XC Info");
define("_Flight_Info","Flug Info");

define("_MENU_LOGOUT","Logout");
define("_MENU_LOGIN","Login");
define("_MENU_REGISTER","Registrieren");


define("_Africa","Africa");
define("_Europe","Europe");
define("_Asia","Asia");
define("_Australia","Australia");
define("_North_Central_America","North/Central America");
define("_South_America","South America");

define("_Recent","Recent");

define("_Unknown_takeoff","Unbekannter Startplatz");
define("_Display_on_Google_Earth","Mit Google Earth anzeigen");
define("_Use_Man_s_Module","Berechnen mit Man's Module?");
define("_Line_Color","Trackfarbe");
define("_Line_width","Trackbreite");
define("_unknown_takeoff_tooltip_1","Unbekannter Startplatz");
define("_unknown_takeoff_tooltip_2","Falls Startplatz bekannt, bitte Ausfullen!");
define("_EDIT_WAYPOINT","Startplatz Info editieren");
define("_DELETE_WAYPOINT","Startplatz löschen");
define("_SUBMISION_DATE","Hochgeladen an"); // the date a flight was submited to leonardo
define("_TIMES_VIEWED","Anzahl Aufrufe"); // the times that this flight havs been viewed


define("_takeoff_add_help_1","Falls Startplatz bekannt, bitte Ausfullen, sonst kann diese Fenster geschlossen werden.");
define("_takeoff_add_help_2","Falls richtige Startplatz Angeziege, bitte diese Fenster schliessen - es mus nicht nochmal eingetragen werden.");
define("_takeoff_add_help_3","Falls der Startplatzname unten erscheint, kann es per Mausklick ausgewählt und übernommen werden.");
define("_Takeoff_Name","Startplatzname");
define("_In_Local_Language","Startplatzname (Ortssprache)");
define("_In_English","Startplatzname (englisch)");

// New on 2007/02/20 - login screen
define("_ENTER_PASSWORD","Einloggen mit Benutzername und Kennwort.");
define("_SEND_PASSWORD","Ich habe mein Kennwort vergessen");
define("_ERROR_LOGIN","Benutzername und/oder Kennwort falsch.");
define("_AUTO_LOGIN","Automatische Benutzeranmeldung");
define("_USERNAME","Benutzername");
define("_PASSWORD","Kennwort");
define("_PROBLEMS_HELP","Bei Anmeldeproblemen bitte den Administrator kontaktieren");

define("_LOGIN_TRY_AGAIN","%sHier%s klicken zum nochmal probieren.");
define("_LOGIN_RETURN","%sHier%s klicken für den Startseite");
// end 2007/02/20

define("_Category","Category");
define("_MEMBER_OF","Mitglied");
define("_MemberID","Mitgliedsnummer");
define("_EnterID","Mitgliedsnummer automatisch holen");
define("_Clubs_Leagues","Vereine / Wertung");
define("_Pilot_Statistics","Pilot Statistik");
define("_National_Rankings","National Wertung");


// New on 2007/05/18 (alternative GUI_filter)
define('_Filter_NoSelection', 'Keine Auswahl getroffen');
define('_Filter_CurrentlySelected', 'Aktuelle Auswahl');
define('_Filter_DialogMultiSelectInfo', 'Für Mehrfachauswahl Strg-Taste gedrückt halten.');

define('_Filter_FilterTitleIncluding', 'Nur bestimmte [items]');
// Note to translators: use the placeholder [items] in your translation as it is, don't translate it
define('_Filter_FilterTitleExcluding', '[items] ausschließen');
define('_Filter_DialogTitleIncluding', '[items] wählen');
define('_Filter_DialogTitleExcluding', '[items] wählen');

define('_Filter_Items_pilot', 'Piloten');
define('_Filter_Items_nacclub', 'Vereine');
define('_Filter_Items_country', 'Länder');
define('_Filter_Items_takeoff', 'Startplätze');

define('_Filter_Button_Select', 'Auswählen');
define('_Filter_Button_Delete', 'Löschen');
define('_Filter_Button_Accept', 'Auswahl übernehmen');
define('_Filter_Button_Cancel', 'Abbrechen');

# menu bar
define("_MENU_FILTER_NEW","Filter **NEUE VERSION**");

// end 2007/05/18


// New on 2007/05/23
// second menu NACCclub selection
define('_ALL_NACCLUBS', 'Alle Vereine');
// Note to translators: use the placeholder [nacname] in your translation as it is, don't translate it
define('_SELECT_NACCLUB', '[nacname]-Verein wählen');

// pilot profile
define('_FirstOlcYear', 'Erste Saison einer Online-XC-Teilnahme Teilnahme');
define('_FirstOlcYearComment', 'Relevant für die Newcomer-Wertung.');

//end 2007/05/23

// new on 2007/03/08
define("_Select_Club","Club auswählen");
define("_Close_window","Fenster schliessen");
define("_EnterID","ID eingeben");
define("_Club","Club");
define("_Sponsor","Sponsor");


// new on 2007/03/13
define('_Go_To_Current_Month','Gehe zu aktuellem Monat');
define('_Today_is','Heute ist');
define('_Wk','KW');
define('_Click_to_scroll_to_previous_month','Klicken um zum vorigen Monat zu gelangen. Gedruckt halten, um automatisch weiter zu scrollen.');
define('_Click_to_scroll_to_next_month','Klicken um zum nachsten Monat zu gelangen. Gedruckt halten, um automatisch weiter zu scrollen.');
define('_Click_to_select_a_month','Klicken um Monat auszuwahlen');
define('_Click_to_select_a_year','Klicken um Jahr auszuwahlen');
define('_Select_date_as_date.','Wahle [date] als Datum.'); // do not replace [date], it will be replaced by date.

// end 2007/03/13

// New on 2007/11/06

define('_Explanation_AddToBookmarks_IE', 'Diese Filtereinstellungen zu den Favoriten hinzufügen');
define('_Msg_AddToBookmarks_IE', 'Klicke auf diesen Link, um die Filtereinstellungen zu Deinen Favoriten hinzuzufügen.');
define('_Explanation_AddToBookmarks_nonIE', '(Diesen Link in den Lesezeichen speichern.)');
define('_Msg_AddToBookmarks_nonIE', 'Um diesen Link zu Deinen Lesezeichen hinzuzufügen, verwende die entsprechende Funktion Deines Browsers.');

define('_PROJECT_HELP','Hilfe');
define('_PROJECT_NEWS','News');
define('_PROJECT_RULES','Ausschreibung 2007');
define('_PROJECT_RULES2','Ausschreibung 2008');

define('_MEAN_SPEED1','Durchschnitts');
//end 2007/11/06

//--------------------------------------------------------
//--------------------------------------------------------
// Missing defines , autoreplaced values from 'english'
//--------------------------------------------------------
define("_NOTE_TAKEOFF_NAME","Startplatz Name und Land eingeben");
define("_Select_Brand","Hersteller wählen");
define("_All_Brands","Alle Hersteller");
define("_DAY","DAY");
define("_Glider_Brand","Hersteller");
define("_Or_Select_from_previous","Oder von vorigem Flug wählen");
define("_External_Entry","External Entry"); //??
define("_Altitude","Höhe");
define("_Speed","Speed");
define("_Distance_from_takeoff","Abstand vom Startplatz");
define("_LAST_DIGIT","last digit");
define("_Filter_Items_nationality","Nationalität");
define("_Filter_Items_server","server");
define("_Ext_text1","Dieser Flug ist ursprünglich eingereicht worden bei ");
define("_Ext_text2","Link zu ausführlichen Karten und Grafiken");//??
define("_Ext_text3","Link zum Ursprungsflug");//??

//--------------------------------------------------------
//--------------------------------------------------------
// Missing defines , autoreplaced values from 'english'
//--------------------------------------------------------
define("_Male_short","M");
define("_Female_short","F");
define("_Male","Mann");
define("_Female","Frau");
define("_Altitude_Short","Höhe");
define("_Vario_Short","Vario");
define("_Time_Short","Zeit");
define("_Info","Info");
define("_Control","Control");
define("_Zoom_to_flight","Zoom auf den Flug");
define("_Follow_Glider","Dem Gerät folgen");
define("_Show_Task","Task zeigen");
define("_Show_Airspace","Lufträume anzeigen");
define("_Show_Optimization_details","Optimierungsdetails zeigen");
define("_Thermals","Thermals");
define("_Load_Thermals","Thermik anzeigen");


//New on 2008/05/17
define('_MemberID_Missing', 'Die Mitgliedsnummer fehlt');
define('_MemberID_NotNumeric', 'Die Mitgliedsnummer muss eine Zahl sein');

define('_FLIGHTADD_CONFIRMATIONTEXT', 'Mit dem Abschicken dieser Daten bestätige ich, dass ich die für den eingereichten Flug geltenden luftrechtlichen Bestimmungen eingehalten habe und akzeptiere die <a href=/xc/modules/leonardo/index.php?name=leonardo&op=nutzung>"Nutzungsrechtvereinbarung"</a>');

define('_FLIGHTADD_IGC_MISSING', 'Bitte igc-Datei angeben');
define('_FLIGHTADD_IGCZIP_MISSING', 'Bitte das zip-Archiv mit der igc-Datei angeben');
define('_FLIGHTADD_CATEGORY_MISSING', 'Bitte die Klasse wählen');
define('_FLIGHTADD_BRAND_MISSING', 'Bitte Gerätehersteller wählen');
define('_FLIGHTADD_STARTTYPE_MISSING', 'Bitte Startart wählen');
define('_FLIGHTADD_GLIDER_MISSING', 'Bitte Gerät eingeben');
define('_YOU_HAVENT_ENTERED_GLIDER', 'Du hast vergessen den Gerätehersteller oder das Gerät anzugeben');

define('_BRAND_NOT_IN_LIST', 'Hersteller nicht gelistet');

//2010-11-20 commenting system
define('_Leave_a_comment','Kommentar schreiben');
define('_Reply','Antworten');
define('_Translate','Übersetzen');
define('_Translate_to','Übersetzen in');
define('_Submit_Comment','Kommentar einfügen');
define('_Logged_in_as','Eingelogged als:');
define('_Name','Name');
define('_Email','Email');
define('_Will_not_be_displayed','(wird nicht angezeigt)');
define('_Please_type_something','schreib bitte etwas');
define('_Please_enter_your_name','Name hinfügen');
define('_Please_give_your_email','Email Adresse hinfügen - es wird nie angezeigt');
define('_RSS_for_the_comments','RSS Feed für Kommentare zu diesen Flug<BR>Kopieren / Einfügen in einen RSS Reader');

// on profile
define('_Comments_are_enabled_by_default_for_new_flights','Kommentare sind standardmäßig aktiviert für neue Flüge');

define('_Comments_Enabled','Kommentare aktiviert');
define('_Comments_are_enabled_for_this_flight','Kommentare aktiviert für diesen Flug');
define('_Comments_are_disabled_for_this_flight','Kommentare deaktiviert für diesen Flug');
define('_ERROR_in_setting_the_comments_status','Kommentar Status FEHLER');
define('_Save_changes','Änderungen speichern');
define('_Cancel','Abbrechen');
define('_Are_you_sure_you_want_to_delete_this_comment','Soll diese Kommentar wirklich gelöscht werden?');

define('_RSS_feed_for_comments','RSS Feed für Kommentare');
define('_RSS_feed_for_flights','RSS Feed für Flüge');
define('_RSS_of_pilots_flights','RSS Feed für Flüge dieser Pilot');


define('_You_have_a_new_comment','Neue Kommentare hier: %s');
define('_New_comment_email_body','Neue Kommentare hier: %s<BR><BR><a href="%s">Hier klicken um alle Kommentare zu lesen</a><hr>%s');


//--------------------------------------------------------
//--------------------------------------------------------
// Added 13.05.2009 -- mod. P. Wild 14.05.09
//--------------------------------------------------------
define("_MENU_SEARCH_PILOTS","Suche nach");
define("_Email_new_password","<p align='justify'>Eine Email mit dem neuen Kennwort und dem Link zu seiner Aktivierung wurde versandt.</p> <p align='justify'>Wenn die Email nicht in Kürze in deinem Posteingang eintrifft, überprüfe bitte auch deinen Spam Ordner.</p>");
define("_informed_user_not_found", "Dieser Benutzer wurde nicht gefunden.");
define("_informed_user_found_but_duplicate", "Es wurden mehrere Benutzer gefunden die diesem Kriterium entsprechen. Bitte versuche eine andere Möglichkeit der Identifikation (Email, Benutzername, CIVL-ID).");
define("_impossible_to_gen_new_pass","<p align='justify'>Eine Registrierungsversuch läuft bereits. Ein neuer Versuch kann erst nach Ablauf der Aktivierungsperiode, d.h. nach <b>%s</b> gemacht werden.</p>");
define("_Password_subject_confirm","Bestaetigungsmail (neues Kennwort)");
define("_request_key_not_found","Aktivierungsschlussel nicht gefunden!");
define("_request_key_invalid","Aktivierungsschlussel ungültig!");
define("_Email_allready_yours","Error: Diese Emailadresse ist Deine.");
define("_Email_allready_have_request","Error: Eine Änderungsanfrage läuft bereits.");
define("_Email_used_by_other","Error: Diese Emailadresse wird bereits verwendet.");
define("_Email_used_by_other_request","Error: Diese Emailadresse wird bereits in eine Anfrage verwendet.");
define("_Email_canot_change_quickly","Eine Emailadress Änderung kann erst nach ablauf der Aktivierungsperiod stattfinden: %s");
define("_Email_sent_with_confirm","Eine Bestätigungsmail wurde versandt.");
define("_Email_subject_confirm","Bestätigungsmail (neue Emailadresse)");
define("_Email_AndConfDontMatch","Emailadresse and Bestätigungsadresse sind unterschiedlich.");
define("_ChangingEmailForm"," Emailadressänderung.");
define("_Email_current","Aktuelle Emailadresse");
define("_New_email","Neue Emailadresse");
define("_New_email_confirm","Neue Emailadresse bestätigen");
define("_MENU_CHANGE_PASSWORD","Kennwortänderung");
define("_MENU_CHANGE_EMAIL","Emailadressänderung");
define("_New_Password","Neue Kennwort");
define("_ChangePasswordForm","Kennwortänderung");
define("_lost_password","Kennwort vergessen");
define("_PASSWORD_RECOVERY_TOOL","Kennwortwiederherstellung");
define("_PASSWORD_RECOVERY_TOOL_MESSAGE","Sollte die Suche in Benutzername, Emailadressen oder CIVL-ID erfolgreich sein, wird eine neue Aktivierungsmail mit neuen Kennwort versandt.<br><br> Die neue Kennwort wird erst nach erneuten Aktivierung gültig.<br><br>");
define("_username_civlid_email","CIVLID, Benutzername oder Emailadress");
define("_Recover_my_pass","Kennwortwiederherstellung");
define("_You_are_not_login","<BR><BR><center><br>Nicht angemeldet. <br><br>Bitte einloggen<BR><BR></center>");
define("_Requirements","Voraussetzungen");
define("_Mandatory_CIVLID","Eine gültige <b>CIVLID</b>.");
define("_Mandatory_valid_EMAIL","Eine eigene gültige <b>Emailadresse</b> wird für die Aktivierung benötigt");
define("_Email_periodic","Diese Emailadresse wird gelegentlich kontrolliert.");
define("_Email_asking_conf","Eine Bestätigungsmail mit Aktivierungslink wurde an die angegebene E-Mail-Adresse versandt");
define("_Email_time_conf","Der Aktivierungslink hat eine Gültigkeitsdauer von drei Stunden");
define("_After_conf_time","Sollte der Anmeldeversuch nicht innerhalb der Gültigkeitsdauer mit dem Aktivierungslink bestätigt werden, werden die Daten vom Server entfernt");
define("_Only_after_time","<b>Erneute Anmeldeversuche können nur nach dem Entfernen abgebrochener Versuche vorgenommen werden</b>");
define("_Disable_Anti_Spam","<b>Achtung!</b> Spamfilter Einstellungen kontrollieren für <b>%s</b>");
define("_If_you_agree","Mit der Anmeldung erklärt sich der Benutzer einverstanden mit den o.g. Richtlinien.");
define("_Search_civl_by_name","%sNamenssuche in der CIVL Datenbank%s. Ein neues Fenster wird geöffnet: Suche mit mindestens 3 Buchstaben Vor- oder Nachname.");
define("_Register_civl_as_new_pilot"," %sNeue CIVL Registration%s");
define("_NICK_NAME","Nick Name");
define("_LOCAL_PWD","Kennwort");
define("_LOCAL_PWD_2","Kennwort bestätigen");
define("_CONFIRM","bestätigen");
define("_REQUIRED_FIELD","Pflichtfelder");
define("_Registration_Form","Anmeldung: %s ");
define("_MANDATORY_NAME","Pflichtfeld: NAME");
define("_MANDATORY_FAI_NATION","Pflichtfeld: NATIONALITÄT");
define("_MANDATORY_GENDER","Pflichtfeld: GESCHLECHT");
define("_MANDATORY_BIRTH_DATE_INVALID","Das Geburtsdatum ist ungültig");
define("_MANDATORY_CIVL_ID","Bitte die CIVL-ID angeben");
define("_Attention_mandatory_to_have_civlid","ACHTUNG!! Pflichtfeld: CIVLID ");
define("_Email_confirm_success","Deine Anmeldung wurde bestätigt!");
define("_Success_login_civl_or_user","Erfolg, bitte mit CIVLID oder Benutzername einloggen");
define("_Server_did_not_found_registration","Anmeldeversuch nicht gefunden, bitte erneut den Aktivierungslink benutzen");
define("_Pilot_already_registered","Pilot bereits angemeldet mit CIVLID %s und Name %s");
define("_User_already_registered","Benutzer bereits mit diesen Name oder Emailadresse angemeldet");
define("_Pilot_civlid_email_pre_registration"," %s Eine Anmeldeversuch läuft bereits mit diesen Emailadresse oder CIVLID");
define("_Pilot_have_pre_registration","Eine Anmeldeversuch läuft bereits aber die Aktivierungslink wurde nicht benutzt. Eine neue Bestätigungsmail mit Aktivierungslink wurde versandt. Nach 3 Stunden verlert diesen Aktivierungslink seine Gültigkeit.");
define("_Pre_registration_founded","Eine Anmeldeversuch läuft bereits mit diesen CIVLID und Emailadresse, bitte den Gültigkeitsperiodablauf abwarten, dass erneut versucht werden kann. Bitte nicht aktivieren, sonst wird ein Doppelkonto angelegt!");
define("_Civlid_already_in_use","Error: doppelte CIVLID!");
define("_Pilot_email_used_in_reg_dif_civlid","Error: Diese Emailadresse wird bereits für eine andere CIVLID Verwendet");
define("_Pilot_civlid_used_in_reg_dif_email","Error: Diese CIVLID wird bereits für eine andere Emailadresse Verwendet");
define("_Pilot_email_used_in_pre_reg_dif_civlid","Error: Diese Emailadresse wird bereits für eine Anmeldeversuch mit einen anderen CIVLID Verwendet");
define("_Pilot_civlid_used_in_pre_reg_dif_email","Error: Diese CIVLID wird bereits für eine Anmeldeversuch mit einen anderen Emailadresse Verwendet");
define("_Server_send_conf_email", "Eine Email zur Bestätigung dieser Registrierung wurde an %s gesandt.<br>Du hast nun 3 Stunden Zeit die Registrierung durch Klick auf den Link in der Email zu bestätigen.");
define("_Pilot_confirm_subscription_subject","Bestaetigungs-Email");
define("_Pilot_confirm_subscription","===================================

Hallo %s,

Das ist eine Email zur Bestätigung deiner Registrierung auf %s .

Bitte klicke auf folgenden Link um deine Registrierung zu bestätigen und einen neuen Benutzer entsprechend deiner zuvor gemachten Angaben anzulegen:

%s

Mit freundlichen Grüßen,
Das %s Team.

--------
Bitte beachten: Das ist eine automatisch generierte Email. Bitte nicht darauf antworten.
--------");
define("_Pilot_confirm_change_email","===================================

Hallo %s,

Das ist eine Email zur Bestätigung deiner Registrierung auf %s .

Bitte klicke auf folgenden Link um deine Registrierung zu bestätigen und einen neuen Benutzer entsprechend deiner zuvor gemachten Angaben anzulegen:

http://%s?op=chem&rkey=%s

Mit freundlichen Grüßen,
Das %s Team.

--------
Bitte beachten: Das ist eine automatisch generierte Email. Bitte nicht darauf antworten.
--------");
define("_Password_recovery_email","===================================

Hallo %s,

Diese Email wurde dir zugesandt weil du auf %s ein neues Kennwort angefordert hast.

Du bist registriert unter dem Benutzernamen: %s

Deine CIVL-ID lautet: %s

Dein neues Kennwort ist: %s

Bitte klicke auf folgenden Link um die Kennwortänderung zu bestätigen:

http://%s

Mit freundlichen Grüßen,
Das %s Team.

--------
Bitte beachten: Das ist eine automatisch generierte Email. Bitte nicht darauf antworten.
--------");
define("_MENU_AREA_GUIDE","Area Guide");
define("_All_XC_types","Alle XC Typen");
define("_xctype","XC Typ");
define("_Flying_Areas","Fluggebiete");
define("_Name_of_Area","Gebietsname");
define("_See_area_details","Details und Startplätze für diesen Gebiet");
define("_choose_ge_module","Google Earth Module auswählen");
define("_ge_module_advanced_1","(viele Details, groß)");
define("_ge_module_advanced_2","(einige Details, mittel) ");
define("_ge_module_Simple","Einfach (nur Aufgabe, klein)");
define("_Pilot_search_instructions","Mind. 3 Buchstaben der Vor- oder Nachname");
define("_All_classes","Alle Klassen");
define("_Class","Klasse");
define("_Photos_filter_off","Alle Flüge");
define("_Photos_filter_on","Nur Flüge mit Fotos");
define("_You_are_already_logged_in","Bereits eingelogged");

define("_MANDATORY_FIRSTNAME", "Bitte Vornamen angeben");
define("_MANDATORY_LASTNAME", "Bitte Nachnamen angeben");
define("_MANDATORY_USERNAME", "Bitte Benutzernamen angeben");
define("_MANDATORY_EMAIL_CONFIRM", "Bitte die Email Adresse bestätigen");

/**
 * Added 10.06.2009, Manolis
 */
define("_GLIDER_CERT","Zulassung");
define("_PLEASE_SELECT_YOUR_GLIDER_CERTIFICATION","Bitte Zulassung auswählen");
//added 23.07.09 P:Wild
define('_PG', 'Gleitschirm');
define('_HG', 'Drachenflieger');
define('_RG', 'Starrflügel');
define('_SHOW_NEWS', 'News Ticker');
define('_START_TYPE', 'Startart');
define('_Start_Type', 'Startart');
//added 26.03.2010 P. Wild
define('_See_The_filter', 'Filter Anschauen');
define('_PilotBirthdate', 'Geburtstag');
define('_Start_type', 'Startart');
define('_MENU_BROWSER', 'Überblick in Google Maps');
define('_FLIGHT_BROSWER', 'Google Maps Flug Suche');
define('_Loading_thermals', 'Thermik laden');
define('_Layers', 'Layers');
define('_Select_Area', 'Gebiet auswählen');

//config_menu extensions -- P.Wild 19.01.2011
define('_REGULATIONS','Ausschreibung');
define('_REGISTRATION','Anmeldung');
define('_FAQ','F.A.Q.');
define('_FORUM','Forum');
define('_PRIZES','Siegerehrung');
define('_STARTDB','Startplatz Datenbank');
define('_THERMIKDB','Thermik Datenbank');
define('_SHOP','Shop');
define('_RIGHTS','Nutzungsrechtvereinbarung');
define('_IMPRESSUM','Impressum');


define('_Kingpost', 'Turmdrachen');
define('_Topless', 'Turmloser Drachen');
// 08.06.2010 P. Wild
define('_Note', 'Hinweis: um einen Verein einzutragen muss zuerst die Mitgliedsnummer ausgefüllt sein ');
define('_FOOT', 'Fuß');
define('_WINCH', 'Winde');
define('_EMOTOR', 'E_Lift');
define('_ULTOW', 'UL_Schlepp');
define('_Print_a_pdf_booklet', 'PDF Erstellen ');
define('_PreviousJob', 'Diese Auftrag wurde bereits verschickt am');
define('_ReadyOn', 'Es wird nach Fertigstellen der PDF-Dateien ein Download-Link verschickt an');

define('_G_REC_VALI_FAIL', 'Der G-Record im IGC Tracklog konnte nicht validiert werden.<br>Dieser Flug erscheint nur im Flugbuch und wird nicht gewertet.');
define('_G_REC_MISSING', 'Der G-Record fehlt oder die IGC Datei ist beschädigt.<br>Erneutes Auslesen vom Vario und Hochladen zum DHVXC Server könnte dieses Problem beheben. ');
define('_VALI_SRV_NO_RESP', 'Der Validierungsserver ist offline. Eine neuer Validierungsversuch wird automatisch erfolgen. ');
define('_NO_VALI_EXE', 'Dieses Vario / dieser Logger wird derzeit nicht unterstützt.<br> Bitte dem DHVXC Admin melden.');
define('_Cat_Info', 'Fun Cup: LTF 1,A<br>Standard: LTF 1,1-2,A,B<br>Sport: LTF 1,1-2,2,A,B,C<br>Performance: LTF 1,1-2,2,2-3,3,A,B,C,D');

//17.09.2012 P.Wild
define('_Remove_From_Favorites', 'Flugvergleich Entfernen');
define('_Favorites', 'Flugvergleich');
define('_Compare_flights_line_1', 'Flüge auswählen per Checkbox');
define('_Compare_flights_line_2', 'und miteinander vergleichen in Google Maps');
define('_Compare_Favorite_Tracks', 'Flüge vergleichen');
define('_Remove_all_favorites', 'Alle Vergleichsflüge entfernen');
define('_Find_and_Compare_Flights', 'Flüge suchen und vergleichen');
define('_Compare_Selected_Flights', 'Ausgewählte Flüge vergleichen');
define('_More', 'mehr');
define('_Close', 'schliessen');

?>
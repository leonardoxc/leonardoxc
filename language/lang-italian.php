<?php

/**************************************************************************/
/* Italian language translation by                                        */
/* Benedetto Lo Tufo  (info@vololibero.net)                               */
/**************************************************************************/

/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://leonardo.thenet.gr 											*/
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/
/*                                                                        */
/* You need to change the second quoted phrase, not the capital one!      */
/*                                                                        */
/* If you need to use double quotes (") remember to add a backslash (\),  */
/* so your entry will look like: This is \"double quoted\" text.          */
/* And, if you use HTML code, please double check it.                     */
/**************************************************************************/

function setMonths() {
	global  $monthList;
	$monthList=array('Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno',
				'Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre');
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","Volo Libero");
define("_FREE_TRIANGLE","Triangolo Libero");
define("_FAI_TRIANGLE","Triangolo FAI");

define("_SUBMIT_FLIGHT_ERROR","C'è un problema nell'inserimento del volo");

// list_pilots()
define("_NUM","#");
define("_PILOT","Pilota");
define("_NUMBER_OF_FLIGHTS","Numero di voli");
define("_BEST_DISTANCE","Miglior Distanza");
define("_MEAN_KM","Media # km per volo");
define("_TOTAL_KM","Km totali del volo");
define("_TOTAL_DURATION_OF_FLIGHTS","Durata totale del volo");
define("_MEAN_DURATION","Durata media del volo");
define("_TOTAL_OLC_KM","Distanza OLC totale");
define("_TOTAL_OLC_SCORE","Punteggio OLC totale");
define("_BEST_OLC_SCORE","Punteggio OLC migliore");
define("_From","Da");

// list_flights()
define("_DURATION_HOURS_MIN","Durata (hh:mm)");
define("_SHOW","Mostra");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","Il volo sarà attivato tra 1-2 minuti. ");
define("_TRY_AGAIN","Prova di nuovo più tardi. Grazie.");

define("_TAKEOFF_LOCATION","Decollo");
define("_TAKEOFF_TIME","Ora del decollo");
define("_LANDING_LOCATION","Atterraggio");
define("_LANDING_TIME","Ora dell'atterraggio");
define("_OPEN_DISTANCE","Distanza lineare");
define("_MAX_DISTANCE","Distanza Max");
define("_OLC_SCORE_TYPE","Tipo punteggio OLC");
define("_OLC_DISTANCE","Distanza OLC");
define("_OLC_SCORING","Punteggio OLC");
define("_MAX_SPEED","Velocità massima");
define("_MAX_VARIO","Max vario");
define("_MEAN_SPEED","Velocità Media");
define("_MIN_VARIO","Min vario");
define("_MAX_ALTITUDE","Altezza massima (SLM)");
define("_TAKEOFF_ALTITUDE","Altezza decollo (SLM)");
define("_MIN_ALTITUDE","Altezza minima (SLM)");
define("_ALTITUDE_GAIN","Guadagno quota");
define("_FLIGHT_FILE","File del volo");
define("_COMMENTS","Commenti");
define("_RELEVANT_PAGE","Pagina web relativa");
define("_GLIDER","Ala");
define("_PHOTOS","Foto");
define("_MORE_INFO","Altre informazioni");
define("_UPDATE_DATA","Aggiorna dati");
define("_UPDATE_MAP","Aggiorna mappa");
define("_UPDATE_3D_MAP","Aggiorna mappa 3D");
define("_UPDATE_GRAPHS","Aggiorna grafici");
define("_UPDATE_SCORE","Aggiorna punteggio");

define("_TAKEOFF_COORDS","Coordinate decollo:");
define("_NO_KNOWN_LOCATIONS","Luogo sconosciuto!");
define("_FLYING_AREA_INFO","Flying area info");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo XC server");
define("_RETURN_TO_TOP","Torna su");
// list flight
define("_PILOT_FLIGHTS","Voli del pilota");

define("_DATE_SORT","Data");
define("_PILOT_NAME","Nome del pilota");
define("_TAKEOFF","Decollo");
define("_DURATION","Durata");
define("_LINEAR_DISTANCE","Distanza lineare");
define("_OLC_KM","Km OLC");
define("_OLC_SCORE","Punti OLC");
define("_DATE_ADDED","Ultimi inserimenti");

define("_SORTED_BY","Ordinati per:");
define("_ALL_YEARS","Tutti gli anni");
define("_SELECT_YEAR_MONTH","Scegli anno (e mese)");
define("_ALL","Tutti");
define("_ALL_PILOTS","Mostra tutti i piloti");
define("_ALL_TAKEOFFS","Mostra tutti i decolli");
define("_ALL_THE_YEAR","Tutto l'anno");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","Non hai fornito un file di volo");
define("_NO_SUCH_FILE","Il file che hai fornito non è stato trovato sul server");
define("_FILE_DOESNT_END_IN_IGC","Il file non ha l'estensione .igc");
define("_THIS_ISNT_A_VALID_IGC_FILE","Questo non è un file .igc valido");
define("_THERE_IS_SAME_DATE_FLIGHT","C'è già un volo con la stessa data e ora");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","Se vuoi sostituirlo dovrai prima");
define("_DELETE_THE_OLD_ONE","eliminare quello vecchio");
define("_THERE_IS_SAME_FILENAME_FLIGHT","C'è già un volo con lo stesso nome di file");
define("_CHANGE_THE_FILENAME","Se questo volo è un'altro allora cambia il nome del file e riprova");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","Il tuo volo è stato inserito");
define("_PRESS_HERE_TO_VIEW_IT","Clicca qui per vederlo");
define("_WILL_BE_ACTIVATED_SOON","(sarà attivato tra 1-2 minuti)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Inserisci più voli contemporaneamente");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","Solo i files IGC saranno elaborati");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","Inserisci il file ZIP<br>contenente i voli");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","Clicca qui per inserire i voli");

define("_FILE_DOESNT_END_IN_ZIP","Il file che hai inserito non ha un estensione .zip");
define("_ADDING_FILE","Sto inserendo il file");
define("_ADDED_SUCESSFULLY","Inserito con successo");
define("_PROBLEM","Problema");
define("_TOTAL","Un totale di ");
define("_IGC_FILES_PROCESSED","voli sono stati eleborati");
define("_IGC_FILES_SUBMITED","voli sono stati inseriti");

// info
define("_DEVELOPMENT","Sviluppo");
define("_ANDREADAKIS_MANOLIS","Andreadakis Manolis");
define("_PROJECT_URL","Pagina del Progetto");
define("_VERSION","Versione");
define("_MAP_CREATION","Creazione Mappe");
define("_PROJECT_INFO","Informazioni sul Progetto");

// menu bar 
define("_MENU_MAIN_MENU","Menu Principale");
define("_MENU_DATE","Seleziona Data");
define("_MENU_COUNTRY","Seleziona Paese");
define("_MENU_XCLEAGUE","XC League");
define("_MENU_ADMIN","Amministratore");

define("_MENU_COMPETITION_LEAGUE","<b>VLC</b> - Tutte le categorie");
define("_MENU_OLC","OLC");
define("_MENU_OPEN_DISTANCE","Distanza Libera");
define("_MENU_DURATION","Durata");
define("_MENU_ALL_FLIGHTS","Mostra tutti i voli");
define("_MENU_FLIGHTS","Voli");
define("_MENU_TAKEOFFS","Decolli");
define("_MENU_FILTER","Filtro");
define("_MENU_MY_FLIGHTS","I miei voli");
define("_MENU_MY_PROFILE","Mio profilo");
define("_MENU_MY_STATS","Mie statistiche"); 
define("_MENU_MY_SETTINGS","My settings"); 
define("_MENU_SUBMIT_FLIGHT","Inserisci volo");
define("_MENU_SUBMIT_FROM_ZIP","Inserisci voli da file ZIP");
define("_MENU_SHOW_PILOTS","Piloti");
define("_MENU_SHOW_LAST_ADDED","Mostra gli ultimi voli inseriti");
define("_FLIGHTS_STATS","Flights Stats");

define("_SELECT_YEAR","Seleziona anno");
define("_SELECT_MONTH","Seleziona mese");
define("_ALL_COUNTRIES","Mostra tutti i paesi");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","Tutto");
define("_NUMBER_OF_FLIGHTS","Numero di voli");
define("_TOTAL_DISTANCE","Distanza totale");
define("_TOTAL_DURATION","Durata totale");
define("_BEST_OPEN_DISTANCE","Miglior distanza");
define("_TOTAL_OLC_DISTANCE","Distanza OLC totale");
define("_TOTAL_OLC_SCORE","Punteggio OLC totale");
define("_BEST_OLC_SCORE","Punteggio OLC migliore");
define("_MEAN_DURATION","Durata media");
define("_MEAN_DISTANCE","Distanza media");
define("_PILOT_STATISTICS_SORT_BY","Piloti - Ordinati per");
define("_CATEGORY_FLIGHT_NUMBER","Categoria 'FastJoe' - Numero di voli");
define("_CATEGORY_TOTAL_DURATION","Categoria 'DURACELL' - Durata totale dei voli");
define("_CATEGORY_OPEN_DISTANCE","Categoria 'Open Distance'");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","Non ci sono piloti da mostrare!");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","Il volo è stato eliminato");
define("_RETURN","Ritorna");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","ATTENZIONE - Stai per eliminare questo volo");
define("_THE_DATE","Data ");
define("_YES","SI");
define("_NO","NO");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","Risultati");
define("_N_BEST_FLIGHTS","migliori voli");
define("_OLC","OLC");
define("_OLC_TOTAL_SCORE","punteggio OLC totale");
define("_KILOMETERS","Chilometri");
define("_TOTAL_ALTITUDE_GAIN","Guadagno totale di quota");
define("_TOTAL_KM","Km totali");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","è");
define("_IS_NOT","non è");
define("_OR","oppure");
define("_AND","e");
define("_FILTER_PAGE_TITLE","Filtra voli");
define("_RETURN_TO_FLIGHTS","Ritorna ai voli");
define("_THE_FILTER_IS_ACTIVE","Il filtro è attivo");
define("_THE_FILTER_IS_INACTIVE","Il filtro non è attivo");
define("_SELECT_DATE","Scegli Data");
define("_SHOW_FLIGHTS","Mostra voli");
define("_ALL2","TUTTI");
define("_WITH_YEAR","Con Anno");
define("_MONTH","Mese");
define("_YEAR","Anno");
define("_FROM","di");
define("_from","da");
define("_TO","A");
define("_SELECT_PILOT","Scegli Pilota");
define("_THE_PILOT","Il pilota");
define("_THE_TAKEOFF","Il decollo");
define("_SELECT_TAKEOFF","Scegli Decollo");
define("_THE_COUNTRY","Il paese");
define("_COUNTRY","Paese");
define("_SELECT_COUNTRY","Seleziona Paese");
define("_OTHER_FILTERS","Altri filtri");
define("_LINEAR_DISTANCE_SHOULD_BE","La distanza lineare sarebbe");
define("_OLC_DISTANCE_SHOULD_BE","La distanza OLC sarebbe");
define("_OLC_SCORE_SHOULD_BE","Il punteggio OLC sarebbe");
define("_DURATION_SHOULD_BE","La durata sarebbe");
define("_ACTIVATE_CHANGE_FILTER","Attiva / cambia FILTRO");
define("_DEACTIVATE_FILTER","Disattiva FILTRO");
define("_HOURS","ore");
define("_MINUTES","min");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","Inserisci volo");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(solo il file IGC è obbligatorio)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","Inserisci il<br>file IGC del volo");
define("_NOTE_TAKEOFF_NAME","IMPORTANTE! Scrivi anche il luogo del decollo e la provincia");  //  CHANGE
define("_COMMENTS_FOR_THE_FLIGHT","Commenti per il volo");
define("_PHOTO","Foto");
define("_PHOTOS_GUIDELINES","Le foto devono essere in formato jpg ed inferiori a 100Kb");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","Clicca qui per inserire il volo");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","Vuoi inserire molti voli in una volta?");
define("_PRESS_HERE","Clicca qui");

define("_IS_PRIVATE","Non rendere pubblico");
define("_MAKE_THIS_FLIGHT_PRIVATE","Non rendere pubblico");
define("_INSERT_FLIGHT_AS_USER_ID","Inserisci volo come userID");
define("_FLIGHT_IS_PRIVATE","Questo volo è privato");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","Cambia i dati del volo");
define("_IGC_FILE_OF_THE_FLIGHT","IGC file del volo");
define("_DELETE_PHOTO","Elimina");
define("_NEW_PHOTO","nuova foto");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","Clicca qui per cambiare i dati del volo");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","I cambiamenti sono stati applicati");
define("_RETURN_TO_FLIGHT","Ritorna al volo");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","Ritorna al volo");
define("_READY_FOR_SUBMISSION","Pronto per l'inserimento");
define("_SUBMIT_TO_OLC","Inserisci nel server OLC");
define("_YOUR_FLIGHT_HAS_BEEN_SUCCESSFULLY_SUBMITED_TO_THE_OLC","Il volo è stato inserito con successo nel server OLC");
define("_THE_OLC_REFERENCE_NUMBER_IS","Il numero di riferimento OLC è");
define("_THERE_WAS_A_PROBLEM_ON_OLC_SUBMISSION","C'è un problema con l'inserimento nel server OLC");
define("_LOOK_BELOW_FOR_THE_CAUSE_OF_THE_PROBLEM","Guarda sotto per la causa del problema");
define("_FLIGHT_SUCCESFULLY_REMOVED_FROM_OLC","Il volo è stato rimosso con successo dal server OLC");
define("_FLIGHT_NOT_SCORED","Il volo non ha punteggio OLC e perciò non può essere inserito");
define("_TOO_LATE","La deadline per questo volo è stata superata e perciò non può essere inserito");
define("_CANNOT_BE_SUBMITTED","La deadline per questo volo è stata superata");
define("_NO_PILOT_OLC_DATA","<p><strong>Non ci sono dati OLC per il pilota</strong><br>
  <br>
<b>Cosa è OLC / A cosa servono questi campi?</b><br><br>
	Per un inserimento valido nell'OLC il pilota dovrebbe essere già registrato sul server OLC.</p>
<p> La registrazione si può fare <a href='http://www2.onlinecontest.org/olcphp/2005/ausw_wertung.php?olc=holc-i&spr=en' target='_blank'>
  a questa pagina</a>, dove devi selezionare il tuo paese e poi scegliere 'Contest Registration'<br>
</p>
<p>Quando la registrazione è fatta devi inserire qui le tue informazioni ESATTAMENTE come le hai inserite nella registrazione OLC
</p>
<ul>
	<li><div align=left>Nome</div>
	<li><div align=left>Cognome</div>
	<li><div align=left>Data di nascita</div>
	<li> <div align=left>Firma</div>
	<li><div align=left>Se hai già inserito dei voli nell'OLC, le 4 lettere che usi per il nome del file IGC</div>
</ul>
");
define("_OLC_MAP","Mappa OLC");
define("_OLC_BARO","Barografo");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","Profilo Pilota");
define("_back_to_flights","torna ai voli");
define("_pilot_stats","statistiche pilota");
define("_edit_profile","cambia profilo");
define("_flights_stats","statistiche voli");
define("_View_Profile","Vedi Profilo");

define("_Personal_Stuff","Dati Personali");
define("_First_Name","Nome");
define("_Last_Name","Cognome");
define("_Birthdate","Data di nascita");
define("_dd_mm_yy","gg.mm.aa");
define("_Sign","Firma");
define("_Marital_Status","Stato Civile");
define("_Occupation","Occupazione");
define("_Web_Page","Pagina Web");
define("_N_A","N/A");
define("_Other_Interests","Altri Interessi");
define("_Photo","Foto");

define("_Flying_Stuff","Voli");
define("_note_place_and_date","annota, se puoi, luogo e data");
define("_Flying_Since","Vola da");
define("_Pilot_Licence","Licenza Pilota");
define("_Paragliding_training","Scuola di volo");
define("_Favorite_Location","Luogo preferito");
define("_Usual_Location","Luogo usuale");
define("_Best_Flying_Memory","Ricordo del miglior volo");
define("_Worst_Flying_Memory","Ricordo del peggior volo");
define("_Personal_Distance_Record","Record di Distanza");
define("_Personal_Height_Record","Record di Altezza");
define("_Hours_Flown","Ore volate");
define("_Hours_Per_Year","Ore per Anno");

define("_Equipment_Stuff","Equipaggiamento");
define("_Glider","Ala");
define("_Harness","Selletta");
define("_Reserve_chute","Emergenza");
define("_Camera","Fotocamera");
define("_Vario","Vario");
define("_GPS","GPS");
define("_Helmet","Casco");
define("_Camcorder","Videocamera");

define("_Manouveur_Stuff","Manovre");
define("_note_max_descent_rate","annota, se puoi, la massima discendenza");
define("_Spiral","Spirale");
define("_Bline","Stallo B");
define("_Full_Stall","Full Stall");
define("_Other_Manouveurs_Acro","Altre manovre acrobatiche");
define("_Sat","Sat");
define("_Asymmetric_Spiral","Spirale Asimmetrica");
define("_Spin","Spin");

define("_General_Stuff","Altro");
define("_Favorite_Singer","Cantante Preferito");
define("_Favorite_Movie","Film Preferito");
define("_Favorite_Internet_Site","Sito internet Preferito");
define("_Favorite_Book","Libro Preferito");
define("_Favorite_Actor","Attore Preferito");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","Carica nuova foto o cambiane una vecchia");
define("_Delete_Photo","Elimina Foto");
define("_Your_profile_has_been_updated","Il tuo profilo è stato aggiornato");
define("_Submit_Change_Data","Invia - Cambia i dati");

//--------------------------------------------
// pilot_ïlc_profile_edit.php
//--------------------------------------------
define("_edit_OLC_info","Edita informazioni OLC");
define("_OLC_information","Informazioni OLC");
define("_callsign","Firma");
define("_filename_suffix","Suffisso del nome del file");
define("_OLC_Pilot_Info","Informazioni Pilota OLC");
define("_OLC_EXPLAINED","<b>Cosa è OLC / A cosa servono questi campi?</b><br><br>
	Per un inserimento valido nell'OLC il pilota dovrebbe essere già registrato sul server OLC.</p>
<p> La registrazione si può fare <a href='http://www2.onlinecontest.org/olcphp/2005/ausw_wertung.php?olc=holc-i&spr=en' target='_blank'>
  a questa pagina</a>, dove devi selezionare il tuo paese e poi scegliere 'Contest Registration'<br>
</p>
<p>Quando la registrazione è fatta devi inserire qui le tue informazioni ESATTAMENTE come le hai inserite nella registrazione OLC
</p>
<ul>
	<li><div align=left>Nome</div>
	<li><div align=left>Cognome</div>
	<li><div align=left>Data di nascita</div>
	<li> <div align=left>Firma</div>
	<li><div align=left>Se hai già inserito dei voli nell'OLC, le 4 lettere che usi per il nome del file IGC</div>
</ul>
");

define("_OLC_SUFFIX_EXPLAINED","<b>Cos'è il 'Suffisso del nome del file?'</b><br>E' un identificatore di 4 lettere che identifica univocamente un pilota o un mezzo. 
Se non sai cosa inserire qui, leggi questi suggerimenti:<p>
<ul>
<li>Usa 4 lettere derivate dal tuo nome / cognome
<li>Cerca di trovare una combinazione che sia abbastanza strana. Questo escluderà la possibilità che il tuo suffisso sia uguale a quello di un'altro pilota
<li>Se hai problemi ad inserire il tuo volo nell'OLC tramite Leonardo, questo può essere dovuto al suffisso. Prova a cambiarlo e riprova.
</ul>");

//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","hh:mm");

define("_Totals","Totali");
define("_First_flight_logged","Primo volo inserito");
define("_Last_flight_logged","Ultimo volo inserito");
define("_Flying_period_covered","Periodo");
define("_Total_Distance","Distanza Totale ");
define("_Total_OLC_Score","Punteggio OLC Totale");
define("_Total_Hours_Flown","Totale Ore Volate");
define("_Total_num_of_flights","Totale # di voli ");

define("_Personal_Bests","Record Personali");
define("_Best_Open_Distance","Miglior Distanza Libera");
define("_Best_FAI_Triangle","Miglior Triangolo FAI");
define("_Best_Free_Triangle","Miglior Triangolo Libero");
define("_Longest_Flight","Volo più lungo");
define("_Best_OLC_score","Miglior punteggio OLC");

define("_Absolute_Height_Record","Record assoluto di altezza");
define("_Altitute_gain_Record","Record guadagno quota");
define("_Mean_values","Medie");
define("_Mean_distance_per_flight","Distanza per volo");
define("_Mean_flights_per_Month","Voli al mese");
define("_Mean_distance_per_Month","Distanza per mese");
define("_Mean_duration_per_Month","Durata per mese");
define("_Mean_duration_per_flight","Durata per volo");
define("_Mean_flights_per_Year","Voli all'anno");
define("_Mean_distance_per_Year","Distanze per anno");
define("_Mean_duration_per_Year","Durata per anno");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","Vedi decolli nei pressi di questo punto");
define("_Waypoint_Name","Nome Waypoint");
define("_Navigate_with_Google_Earth","Naviga con Google Earth");
define("_See_it_in_Google_Maps","Guardalo in Google Maps");
define("_See_it_in_MapQuest","Guardalo in MapQuest");
define("_COORDINATES","Coordinate");
define("_FLIGHTS","Voli");
define("_SITE_RECORD","Record del Sito");
define("_SITE_INFO","Site information");
define("_SITE_REGION","Region");
define("_SITE_LINK","Link to more information");
define("_SITE_DESCR","Site/takeoff Description");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","See more details");
define("_KML_file_made_by","KML file made by");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","Registra decollo");
define("_WAYPOINT_ADDED","Il decollo è stato registrato");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","Record del Sito<br>(distanza libera)");

//--------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","Mezzo");
function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'Parapendio',2=>'Ala Flessibile FAI1',4=>'Ala Rigida FAI5',8=>'Aliante');
	foreach ($CONF_glider_types as $gId=>$gName) if (!$gliderCatList[$gId]) $gliderCatList[$gId]=$gName;
}
setGliderCats();

//--------------------------------------------
// user prefs  & units
//--------------------------------------------

define("_Your_settings_have_been_updated","Your settings have been updated");

define("_THEME","Theme");
define("_LANGUAGE","Language");
define("_VIEW_CATEGORY","View category");
define("_VIEW_COUNTRY","View country");
define("_UNITS_SYSTEM" ,"Units system");
define("_METRIC_SYSTEM","Metric (km,m)");
define("_IMPERIAL_SYSTEM","Imperial (miles,feet)");
define("_ITEMS_PER_PAGE","Items per page");

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

define("_WORLD_WIDE","World Wide");
define("_National_XC_Leagues_for","National XC Leagues for");
define("_Flights_per_Country","Flights per Country");
define("_Takeoffs_per_Country","Takeoffs per Country");
define("_INDEX_HEADER","Welcome to Leonardo XC League");
define("_INDEX_MESSAGE","You can use the &quot;Main menu&quot; to navigate or use the most common choices presented below.");


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
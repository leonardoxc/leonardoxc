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
	global  $monthList,	$monthListShort, $weekdaysList;
	$monthList=array('Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno',
				'Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre');
	$monthListShort=array('GEN','FEB','MAR','APR','MAG','GIU','LUG','AGO','SET','OTT','NOV','DIC');
	$weekdaysList=array('Lun','Mar','Mer','Gio','Ven','Sab','Dom') ;
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","Volo Libero");
define("_FREE_TRIANGLE","Triangolo Libero");
define("_FAI_TRIANGLE","Triangolo FAI");

define("_SUBMIT_FLIGHT_ERROR","C&#39;&egrave; un problema nell&#39;inserimento del volo");

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
define("_From","di");

// list_flights()
define("_DURATION_HOURS_MIN","Durata (hh:mm)");
define("_SHOW","Mostra");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","Il volo sar&agrave; attivato tra 1-2 minuti. ");
define("_TRY_AGAIN","Prova di nuovo pi&ugrave; tardi. Grazie.");

define("_TAKEOFF_LOCATION","Decollo");
define("_TAKEOFF_TIME","Ora del decollo");
define("_LANDING_LOCATION","Atterraggio");
define("_LANDING_TIME","Ora dell&#39;atterraggio");
define("_OPEN_DISTANCE","Distanza lineare");
define("_MAX_DISTANCE","Distanza Max");
define("_OLC_SCORE_TYPE","Tipo punteggio OLC");
define("_OLC_DISTANCE","Distanza OLC");
define("_OLC_SCORING","Punteggio OLC");
define("_MAX_SPEED","Velocit&agrave; massima");
define("_MAX_VARIO","Max vario");
define("_MEAN_SPEED","Velocit&agrave; media");
define("_MIN_VARIO","Min vario");
define("_MAX_ALTITUDE","Altezza massima (SLM)");
define("_TAKEOFF_ALTITUDE","Altezza decollo (SLM)");
define("_MIN_ALTITUDE","Altezza minima (SLM)");
define("_ALTITUDE_GAIN","Guadagno quota");
define("_FLIGHT_FILE","File del volo");
define("_COMMENTS","Commenti");
define("_RELEVANT_PAGE","Pagina web relativa");
define("_GLIDER","Vela");
define("_PHOTOS","Foto");
define("_MORE_INFO","Altre informazioni");
define("_UPDATE_DATA","Aggiorna dati");
define("_UPDATE_MAP","Aggiorna mappa");
define("_UPDATE_3D_MAP","Aggiorna mappa 3D");
define("_UPDATE_GRAPHS","Aggiorna grafici");
define("_UPDATE_SCORE","Aggiorna punteggio");

define("_TAKEOFF_COORDS","Coordinate decollo:");
define("_NO_KNOWN_LOCATIONS","Luogo sconosciuto!");
define("_FLYING_AREA_INFO","Info sull&#39;area di volo");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo XC");
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
define("_ALL_THE_YEAR","Tutto l&#39;anno");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","Non hai fornito un file di volo");
define("_NO_SUCH_FILE","Il file che hai fornito non &egrave; stato trovato sul server");
define("_FILE_DOESNT_END_IN_IGC","Il file non ha l&#39;estensione .igc");
define("_THIS_ISNT_A_VALID_IGC_FILE","Questo non &egrave; un file .igc valido");
define("_THERE_IS_SAME_DATE_FLIGHT","C&#39;&egrave; gi&agrave; un volo con la stessa data e ora");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","Se vuoi sostituirlo dovrai prima");
define("_DELETE_THE_OLD_ONE","eliminare quello vecchio");
define("_THERE_IS_SAME_FILENAME_FLIGHT","C&#39;&egrave; gi&agrave; un volo con lo stesso nome di file");
define("_CHANGE_THE_FILENAME","Se questo volo &egrave; un&#39;altro allora cambia il nome del file e riprova");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","Il tuo volo &egrave; stato inserito");
define("_PRESS_HERE_TO_VIEW_IT","Clicca qui per vederlo");
define("_WILL_BE_ACTIVATED_SOON","(sar&agrave; attivato tra 1-2 minuti)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Inserisci pi&ugrave; voli contemporaneamente");
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
define("_MENU_MY_PROFILE","Il mio profilo");
define("_MENU_MY_STATS","Le mie statistiche"); 
define("_MENU_MY_SETTINGS","La mia configurazione"); 
define("_MENU_SUBMIT_FLIGHT","Inserisci volo");
define("_MENU_SUBMIT_FROM_ZIP","Inserisci voli da file ZIP");
define("_MENU_SHOW_PILOTS","Piloti");
define("_MENU_SHOW_LAST_ADDED","Mostra gli ultimi voli inseriti");
define("_FLIGHTS_STATS","Statistiche dei Voli");

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
define("_CATEGORY_FLIGHT_NUMBER","Categoria &#39;FastJoe&#39; - Numero di voli");
define("_CATEGORY_TOTAL_DURATION","Categoria &#39;DURACELL&#39; - Durata totale dei voli");
define("_CATEGORY_OPEN_DISTANCE","Categoria &#39;Open Distance&#39;");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","Non ci sono piloti da mostrare!");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","Il volo &egrave; stato eliminato");
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

define("_IS","&egrave;");
define("_IS_NOT","non &egrave;");
define("_OR","oppure");
define("_AND","e");
define("_FILTER_PAGE_TITLE","Filtra voli");
define("_RETURN_TO_FLIGHTS","Ritorna ai voli");
define("_THE_FILTER_IS_ACTIVE","Il filtro &egrave; attivo");
define("_THE_FILTER_IS_INACTIVE","Il filtro non &egrave; attivo");
define("_SELECT_DATE","Scegli Data");
define("_SHOW_FLIGHTS","Mostra voli");
define("_ALL2","TUTTI");
define("_WITH_YEAR","Con Anno");
define("_MONTH","Mese");
define("_YEAR","Anno");
define("_FROM","da");
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
define("_LINEAR_DISTANCE_SHOULD_BE","La distanza lineare deve essere");
define("_OLC_DISTANCE_SHOULD_BE","La distanza OLC deve essere");
define("_OLC_SCORE_SHOULD_BE","Il punteggio OLC deve essere");
define("_DURATION_SHOULD_BE","La durata deve essere");
define("_ACTIVATE_CHANGE_FILTER","Attiva / cambia FILTRO");
define("_DEACTIVATE_FILTER","Disattiva FILTRO");
define("_HOURS","ore");
define("_MINUTES","min");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","Inserisci volo");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(solo il file IGC &egrave; obbligatorio)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","Inserisci il<br>file IGC del volo");
define("_NOTE_TAKEOFF_NAME","IMPORTANTE! Scrivi anche il luogo del decollo e la provincia");  //  CHANGE
define("_COMMENTS_FOR_THE_FLIGHT","Commenti per il volo");
define("_PHOTO","Foto");
define("_PHOTOS_GUIDELINES","Le foto devono essere in formato jpg ed inferiori a ");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","Clicca qui per inserire il volo");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","Vuoi inserire molti voli in una volta?");
define("_PRESS_HERE","Clicca qui");

define("_IS_PRIVATE","Non rendere pubblico");
define("_MAKE_THIS_FLIGHT_PRIVATE","Non rendere pubblico");
define("_INSERT_FLIGHT_AS_USER_ID","Inserisci volo come userID");
define("_FLIGHT_IS_PRIVATE","Questo volo &egrave; privato");

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
define("_READY_FOR_SUBMISSION","Pronto per l&#39;inserimento");
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
define("_Your_profile_has_been_updated","Il tuo profilo &egrave; stato aggiornato");
define("_Submit_Change_Data","Invia - Cambia i dati");

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
define("_Longest_Flight","Volo pi&ugrave; lungo");
define("_Best_OLC_score","Miglior punteggio OLC");

define("_Absolute_Height_Record","Record assoluto di altezza");
define("_Altitute_gain_Record","Record guadagno quota");
define("_Mean_values","Medie");
define("_Mean_distance_per_flight","Distanza per volo");
define("_Mean_flights_per_Month","Voli al mese");
define("_Mean_distance_per_Month","Distanza per mese");
define("_Mean_duration_per_Month","Durata per mese");
define("_Mean_duration_per_flight","Durata per volo");
define("_Mean_flights_per_Year","Voli all&#39;anno");
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
define("_SITE_INFO","Informazioni sul Sito");
define("_SITE_REGION","Regione");
define("_SITE_LINK","Link per ulteriori informazioni");
define("_SITE_DESCR","Descrizione Sito/decollo");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","Ulteriori dettagli");
define("_KML_file_made_by","KML file creato da");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","Registra decollo");
define("_WAYPOINT_ADDED","Il decollo &egrave; stato registrato");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","Record del Sito<br>(distanza libera)");

//--------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","Tipo Vela");
function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'Parapendio',2=>'Ala Flessibile FAI1',4=>'Ala Rigida FAI5',8=>'Aliante');
	foreach ($CONF_glider_types as $gId=>$gName) if (!$gliderCatList[$gId]) $gliderCatList[$gId]=$gName;
}
setGliderCats();

//--------------------------------------------
// user prefs  & units
//--------------------------------------------

define("_Your_settings_have_been_updated","La tua configurazione &egrave; stata aggiornata");

define("_THEME","Tema");
define("_LANGUAGE","Lingua");
define("_VIEW_CATEGORY","Categoria");
define("_VIEW_COUNTRY","Paese");
define("_UNITS_SYSTEM" ,"Unit&agrave; di misura");
define("_METRIC_SYSTEM","Metrica (km,m)");
define("_IMPERIAL_SYSTEM","Imperiale (miglia,piedi)");
define("_ITEMS_PER_PAGE","Voli per pagina");

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

define("_WORLD_WIDE","Mondiale");
define("_National_XC_Leagues_for","Campionato XC Nazionale per");
define("_Flights_per_Country","Voli per Paese");
define("_Takeoffs_per_Country","Decolli per Paese");
define("_INDEX_HEADER","Benvenuto su Leonardo XC League");
define("_INDEX_MESSAGE","Puoi usare il &quot;Menu Principale&quot; per navigare o usare le scelte pi&ugrave; comuni che ti vengono presentate qui sotto.");


//--------------------------------------------
// NEW 
//--------------------------------------------
define("_MENU_SUMMARY_PAGE","Prima Pagina (Sommario)");
define("_Display_ALL","Visualizza TUTTO");
define("_Display_NONE","Visualizza NIENTE");
define("_Reset_to_default_view","Ritorna alla videata di default");
define("_No_Club","No Club");
define("_This_is_the_URL_of_this_page","Questo &egrave; l&#39;URL di questa pagina");
define("_All_glider_types","Tutti i tipi di ali");

define("_MENU_SITES_GUIDE","Guida ai Siti di Volo");
define("_Site_Guide","Guida dei Siti");

define("_Search_Options","Opzioni di Ricerca");
define("_Below_is_the_list_of_selected_sites","Lista dei siti scelti");
define("_Clear_this_list","Cancella questa lista");
define("_See_the_selected_sites_in_Google_Earth","Vedi i siti scelti in Google Earth");
define("_Available_Takeoffs","Decolli Disponibili");
define("_Search_site_by_name","Cerca un sito per nome");
define("_give_at_least_2_letters","scrivi almeno 2 lettere");
define("_takeoff_move_instructions_1","Puoi spostare tutti i decolli disponibili nella lista selezionata nel pannello a destra usando >> o quello selezionato usando > ");
define("_Takeoff_Details","Dettagli Decollo");


define("_Takeoff_Info","Info Decollo");
define("_XC_Info","XC Info");
define("_Flight_Info","Info Volo");

define("_MENU_LOGOUT","Logout");
define("_MENU_LOGIN","Login");
define("_MENU_REGISTER","Open an account");


define("_Africa","Africa");
define("_Europe","Europa");
define("_Asia","Asia");
define("_Australia","Australia");
define("_North_Central_America","Nord/Central America");
define("_South_America","Sud America");

define("_Recent","Recente");


define("_Unknown_takeoff","Decollo sconosciuto");
define("_Display_on_Google_Earth","Vedilo su Google Earth");
define("_Use_Man_s_Module","Usa Man&#39;s Module");
define("_Line_Color","Colore linea");
define("_Line_width","Larghezza linea");
define("_unknown_takeoff_tooltip_1","Questo volo ha un Decollo sconosciuto");
define("_unknown_takeoff_tooltip_2","Se sai da quale decollo &egrave; iniziato il volo clicca per inserirlo!");
define("_EDIT_WAYPOINT","Modifica Info Decollo");
define("_DELETE_WAYPOINT","Elimina Decollo");
define("_SUBMISION_DATE","Data di inserimento"); // the date a flight was submited to leonardo
define("_TIMES_VIEWED","volte visto"); // the times that this flight havs been viewed


define("_takeoff_add_help_1","Puoi inserire le informazioni sul decollo se ne sei a conoscenza. Altrimenti puoi tranquillamente chiudere questa finestra");
define("_takeoff_add_help_2","Se il decollo del tuo volo &egrave; visualizzato sopra &#39;Decollo Sconosciuto&#39; allora non c&#39;&egrave; bisogno di reinserirlo. Puoi chiudere questa finestra. ");
define("_takeoff_add_help_3","Se vedi il nome del decollo qui sotto puoi cliccarci sopra per riempire automaticamente i campi a sinistra.");
define("_Takeoff_Name","Nome Decollo");
define("_In_Local_Language","Nella Lingua Locale");
define("_In_English","In Inglese");

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

define("_Category","Categoria");
define("_MEMBER_OF","Membro di");
define("_MemberID","ID Utente");
define("_EnterID","Inserisci ID");
define("_Clubs_Leagues","Campionati");
define("_Pilot_Statistics","Statistiche Piloti");
define("_National_Rankings","Classifiche per Nazioni");




// new on 2007/03/08
define("_Select_Club","Scegli Club");
define("_Close_window","Chiudi finestra");
define("_EnterID","Inserisci ID");
define("_Club","Club");
define("_Sponsor","Sponsor");


// new on 2007/03/13
define("_Go_To_Current_Month","Vai al Mese Corrente");
define("_Today_is","Oggi &egrave;");
define("_Wk","Set");
define("_Click_to_scroll_to_previous_month","Clicca per passare al mese precedente. Tieni premuto per scorrere i vari mesi.");
define("_Click_to_scroll_to_next_month","Clicca per passare al mese successivo. Tieni premuto per scorrere i vari mesi.");
define("_Click_to_select_a_month","Clicca per scegliere il mese.");
define("_Click_to_select_a_year","Clicca per scegliere l&#39;anno.");
define("_Select_date_as_date.","Scegli [date] come data."); // do not replace [date], it will be replaced by date.

// end 2007/03/13

//--------------------------------------------------------
//--------------------------------------------------------
// Missing defines , autoreplaced values from 'english' 
//--------------------------------------------------------
define("_SEASON","Stagione"); 
define("_SUBMIT_TO_OLC","Invia a OLC"); 
define("_pilot_email","Indirizzo Email"); 
define("_Sex","Sesso"); 
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
define("_PROJECT_HELP","Aiuto"); 
define("_PROJECT_NEWS","Novit&agrave;"); 
define("_PROJECT_RULES","Regolamento 2007"); 
define("_Filter_NoSelection","Nessuna selezione"); 
define("_Filter_CurrentlySelected","Selezione corrente"); 
define("_Filter_DialogMultiSelectInfo","Premi Ctrl per selezioni multiple."); 
define("_Filter_FilterTitleIncluding","Solo [items] selezionati"); 
define("_Filter_FilterTitleExcluding","Escludi [items]"); 
define("_Filter_DialogTitleIncluding","Seleziona [items]"); 
define("_Filter_DialogTitleExcluding","Seleziona [items]"); 
define("_Filter_Items_pilot","piloti"); 
define("_Filter_Items_nacclub","clubs"); 
define("_Filter_Items_country","paesi"); 
define("_Filter_Items_takeoff","decolli"); 
define("_Filter_Button_Select","Seleziona"); 
define("_Filter_Button_Delete","Elimina"); 
define("_Filter_Button_Accept","Accetta selezione"); 
define("_Filter_Button_Cancel","Cancella"); 
define("_MENU_FILTER_NEW","Filtra **NUOVE VERSIONI**"); 
define("_ALL_NACCLUBS","Tutti Clubs"); 
define("_SELECT_NACCLUB","Seleziona [nacname]-Club"); 
define("_FirstOlcYear","Primo anno di partecipazione in un XC contest online"); 
define("_FirstOlcYearComment","Seleziona l'anno della tua prima partecipazione in un XC contest online, non solo questo.<br/>Questo campo &egrave; rilevante per i &quot;newcomer&quot;-rankings."); 
define("_Select_Brand","Seleziona Marca"); 
define("_All_Brands","Tutti i Marchi"); 
define("_DAY","GIORNO"); 
define("_Glider_Brand","Marca Vela"); 
define("_Or_Select_from_previous","O scegli una precedente"); 
define("_Explanation_AddToBookmarks_IE","Aggiungi questi filtri ai tuoi preferiti"); 
define("_Msg_AddToBookmarks_IE","Clicca qui per aggiungere questi filtri ai tuoi preferiti."); 
define("_Explanation_AddToBookmarks_nonIE","(Salva questo link nei tuoi preferiti.)"); 
define("_Msg_AddToBookmarks_nonIE","Per salvare questi filtri nei tuoi preferiti, usa la funzione Aggiungi a Preferiti del tuo browser."); 
define("_PROJECT_RULES2","Regolamento 2008"); 
define("_MEAN_SPEED1","Velocit&agrave; Media"); 
define("_External_Entry","External Entry"); 
define("_Altitude","Altitudine"); 
define("_Speed","Velocit&agrave;"); 
define("_Distance_from_takeoff","Distanza dal decollo"); 
define("_LAST_DIGIT","ultima cifra"); 
define("_Filter_Items_nationality","nazionalit&agrave;"); 
define("_Filter_Items_server","server"); 
define("_Ext_text1","Il volo originale &egrave; stato inserito su "); 
define("_Ext_text2","Link al volo completo di mappe"); 
define("_Ext_text3","Link al volo originale"); 
define("_Male_short","M"); 
define("_Female_short","F"); 
define("_Male","Maschio"); 
define("_Female","Femmina"); 
define("_Altitude_Short","Alt"); 
define("_Vario_Short","Vario"); 
define("_Time_Short","Tempo"); 
define("_Info","Info"); 
define("_Control","Controlli"); 
define("_Zoom_to_flight","Zoom al volo"); 
define("_Follow_Glider","Segui Vela"); 
define("_Show_Task","Mostra Task"); 
define("_Show_Airspace","Mostra Airspace"); 

//--------------------------------------------------------
//--------------------------------------------------------
// Missing defines , autoreplaced values from 'english' 
//--------------------------------------------------------
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
define("_informed_user_not_found","The informed user was not found in our database"); 
define("_impossible_to_gen_new_pass","<p align='justify'>We are sorry to inform you that is not possible gen a new password for you at this time, there is already a request that will expire in <b>%s</b>. Only after the expiration time you can do a new request.</p><p align='justify'>If you do not have access to the email contact the server admin</p>"); 
define("_Password_subject_confirm","Confirmation email (new password)"); 
define("_request_key_not_found","the request key that you have informed was not found!"); 
define("_request_key_invalid","request key that you have informed is invalid!"); 
define("_Email_allready_yours","The informed email is allready yours, nothing to do"); 
define("_Email_allready_have_request","There is already an request for changing to this email, nothing to do"); 
define("_Email_used_by_other","This email is used in another pilot, nothing to do"); 
define("_Email_used_by_other_request","This email are used in another pilot in a changing request mail"); 
define("_Email_canot_change_quickly","You can not change your email so quickly as you want, wait for the expiring time: %s"); 
define("_Email_sent_with_confirm","We send a email for you, where you must confirm the email changing"); 
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
define("_Requirements","Requeriments"); 
define("_Mandatory_CIVLID","Is mandatory tho have an valid <b>CIVLID</b>"); 
define("_Mandatory_valid_EMAIL","Is mandatory inform a <b>Valid Email</b> for further comunications with admin server"); 
define("_Email_periodic","Periodically we will send you a confirmation e-mail to the informed e-mail address, if not answered, your registration account will be blocked"); 
define("_Email_asking_conf","We will send a confirmation e-mail to the informed email address"); 
define("_Email_time_conf","You will have only <b>3 hours </b> after the finishing the pre-registration to answer the email"); 
define("_After_conf_time"," After that time, your pre-registration will be <b>removed</b> from our database"); 
define("_Only_after_time","<b>And only after we remove your pre-registration, you can do the pre registration again</b>"); 
define("_Disable_Anti_Spam","<b>ATTENTION!! Disable</b> the anti spam for emails originated from <b>%s</b>"); 
define("_If_you_agree","If you agree with this requirements please go further."); 
define("_Search_civl_by_name","%sSearch for your name in the CIVL database%s . When you click at this left link will be opened a new window , please fill only 3 letters from your First name ou or Last Name, then the CIVL will return your CIVLID, Name and FAI Nationality."); 
define("_Register_civl_as_new_pilot","If you are not founded in the CIVL database, please  %sREGISTER-ME AS A NEW PILOT%s"); 
define("_NICK_NAME","Nick Name"); 
define("_LOCAL_PWD","Local Password"); 
define("_LOCAL_PWD_2","Repeat Local Password"); 
define("_CONFIRM","Confirm"); 
define("_REQUIRED_FIELD","Mandatory Fields"); 
define("_Registration_Form","Registration Form at %s (Leonardo)"); 
define("_MANDATORY_NAME","Is Mandatory to inform your name"); 
define("_MANDATORY_FAI_NATION","Is Mandatory to inform your FAI NATION"); 
define("_MANDATORY_GENDER","Please inform your Sex"); 
define("_MANDATORY_BIRTH_DATE_INVALID","Birth Date Invalid"); 
define("_MANDATORY_CIVL_ID","Please Inform your CIVLID"); 
define("_Attention_mandatory_to_have_civlid","ATENTION!! For now one is Mandatory to have CIVLID in the %s database"); 
define("_Email_confirm_success","Your registration was successfully confirmed!"); 
define("_Success_login_civl_or_user","Success, now you can do your login using your CIVLID as username, or continue with your old username"); 
define("_Server_did_not_found_registration","Registration not founded, please copy and paste in your browser address field the link informed in the email that was sended to you, of maybee your registration time are expired"); 
define("_Pilot_already_registered","Pilot already registered with CIVLID %s and with name %s"); 
define("_User_already_registered","User already registered with this email or name"); 
define("_Pilot_civlid_email_pre_registration","Hi %s This Civl ID and email is already used in a pre-registration"); 
define("_Pilot_have_pre_registration"," You already have a pre registration, but have not answered our mail, we resend the confirmation email for you, you have 3 hours after now to answer the email, if not you will be removed from pre registration. please read the email and follow the procedures described inside, thank you"); 
define("_Pre_registration_founded","We already have a pre-registration with this civlID and Email,wait for finishing the period of 3 hours until then this registration will be removed, in no hipotisis confirm the email that was sended for you, because will be generated an double registration, and your old flights will not be transfered for the new user"); 
define("_Civlid_already_in_use","This CIVLID is used for another pilot, we can not have double CIVLID!"); 
define("_Pilot_email_used_in_reg_dif_civlid","Hi %s This Email is used in another register with different CIVLID"); 
define("_Pilot_civlid_used_in_reg_dif_email","Hi %s This CIVLID is used in another register with different EMAIL"); 
define("_Pilot_email_used_in_pre_reg_dif_civlid","Hi %s This Email is used in another pre-register with different CIVLID"); 
define("_Pilot_civlid_used_in_pre_reg_dif_email","Hi %s This CIVLID is used in another pre-register with different EMAIL"); 
define("_Server_send_conf_email","The server have sended to the %s an email asking for confirmation, you have 3 hours from now to confirm your registration by clicking or copying and pasting the link that are in the email body in your browser addres"); 
define("_MENU_AREA_GUIDE","Area Guide"); 
define("_All_XC_types","_All XC types"); 
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

?>
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
define("_GLIDER","Modello");
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
define("_PAGE_TITLE","VLXC");
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
define("_TO","a");
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
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(solo il file IGC &egrave; obbligatorio) ");
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
define("_GLIDER_TYPE","Mezzo");
function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'Parapendio',2=>'Ala Flessibile FAI1',4=>'Ala Rigida FAI5',8=>'Aliante');
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
define("_Click_to_select_a_year","Clicca per scegliere l&acute;anno.");
define("_Select_date_as_date.","Scegli [date] come data."); // do not replace [date], it will be replaced by date.

// end 2007/03/13//--------------------------------------------------------
//--------------------------------------------------------
// Missing defines , autoreplaced values from 'english' 
//--------------------------------------------------------
define("_SEASON","Stagione"); 
define("_SUBMIT_TO_OLC","Invia a OLC"); 
define("_pilot_email","Indirizzo Email"); 
define("_Sex","Sesso"); 
define("_Login_Stuff","Cambia Dati Login"); 
define("_PASSWORD_CONFIRMATION","Conferma password"); 
define("_EnterPasswordOnlyToChange","Inserisci solo la password, se vuoi cambiarla:"); 
define("_PwdAndConfDontMatch","Password e conferma sono diverse."); 
define("_PwdTooShort","La password &egrave; troppo corta. Deve avere una lunghezza di almeno $passwordMinLength caratteri."); 
define("_PwdConfEmpty","La password non &egrave; stata confermata."); 
define("_PwdChanged","La password &egrave; stata cambiata."); 
define("_PwdNotChanged","La password non &egrave; stata cambiata."); 
define("_PwdChangeProblem","C'&egrave; stato un problema durante il cambio della password."); 
define("_EmailEmpty","L'indirizzo email non deve essere vuoto."); 
define("_EmailInvalid","L'indirizzo email non &egrave; valido."); 
define("_EmailSaved","L'indirizzo email &egrave; stato salvato."); 
define("_EmailNotSaved","L'indirizzo email non &egrave; stato salvato."); 
define("_EmailSaveProblem","C'&egrave; stato un problema durante il salvataggio dell'indirizzo email."); 
define("_PROJECT_HELP","Aiuto"); 
define("_PROJECT_NEWS","Novit&agrave;"); 
define("_PROJECT_RULES","Regolamento 2007"); 
define("_Filter_NoSelection","Nessuna scelta"); 
define("_Filter_CurrentlySelected","Scelta corrente"); 
define("_Filter_DialogMultiSelectInfo","Premi Ctrl per selezioni multiple."); 
define("_Filter_FilterTitleIncluding","Scegli solo [items]");
define("_Filter_FilterTitleExcluding","Escludi [items]"); 
define("_Filter_DialogTitleIncluding","Scegli [items]"); 
define("_Filter_DialogTitleExcluding","Scegli [items]"); 
define("_Filter_Items_pilot","piloti"); 
define("_Filter_Items_nacclub","clubs"); 
define("_Filter_Items_country","Nazioni"); 
define("_Filter_Items_takeoff","decolli"); 
define("_Filter_Button_Select","Scegli"); 
define("_Filter_Button_Delete","Elimina"); 
define("_Filter_Button_Accept","Accetta");
define("_Filter_Button_Cancel","Annulla"); 
define("_MENU_FILTER_NEW","Filter **NEW VERSION**"); 
define("_ALL_NACCLUBS","All Clubs"); 
define("_SELECT_NACCLUB","Seleziona [nacname]-Club"); 
define("_FirstOlcYear","Primo anno di partecipazione in un online XC contest"); 
define("_FirstOlcYearComment","Scegli l'anno della tua prima partecipazione in qualche online XC contest, non solo questo.<br/>Questo campo &egrave; rilevante per i &quot;newcomer&quot;-rankings."); 
define("_Select_Brand","Scegli Marca"); 
define("_All_Brands","Tutte le Marche");
define("_DAY","GIORNO"); 
define("_Glider_Brand","Marca");
define("_Or_Select_from_previous","o scegline uno precedente");
define("_Explanation_AddToBookmarks_IE","Aggiungi questi filtri ai tuoi favoriti"); 
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
define("_Ext_text1","Questo volo &egrave; stato inserito su "); 
define("_Ext_text2","Collegamento al volo completo di mappe"); 
define("_Ext_text3","Collegamento al volo originale"); 
define("_Male_short","M"); 
define("_Female_short","F"); 
define("_Male","Maschio"); 
define("_Female","Femmina"); 
define("_Altitude_Short","Alt"); 
define("_Vario_Short","Vario"); 
define("_Time_Short","Tempo"); 
define("_Info","Info"); 
define("_Control","Controllo"); 
define("_Zoom_to_flight","Zooma al<br>volo intero"); 
define("_Follow_Glider","Segui<br>Glider"); 
define("_Show_Task","Mostra<br>Task"); 
define("_Show_Airspace","Mostra<br>Spazio Aereo"); 


//--------------------------------------------------------
//--------------------------------------------------------
// Missing defines , autoreplaced values from 'english'
//--------------------------------------------------------
define("_Thermals","Termiche");
define("_Show_Optimization_details","Mostra Dettagli Ottimizzazione");
define("_MENU_SEARCH_PILOTS","Cerca");
define("_MemberID_Missing","Manca il tuo member ID");
define("_MemberID_NotNumeric","Il member ID deve essere un numero");
define("_FLIGHTADD_CONFIRMATIONTEXT","Inviando questo modulo confermo di aver rispettato tutte le obbligazioni legali concernenti questo volo.");
define("_FLIGHTADD_IGC_MISSING","Scegli il tuo file .igc");
define("_FLIGHTADD_IGCZIP_MISSING","Scegli l'archivio ZIP contenente il tuo file .igc");
define("_FLIGHTADD_CATEGORY_MISSING","Scegli la categoria");
define("_FLIGHTADD_BRAND_MISSING","Scegli la marca del tuo mezzo");
define("_FLIGHTADD_GLIDER_MISSING","Scegli il modello del tuo mezzo");
define("_YOU_HAVENT_ENTERED_GLIDER","Non hai inserito la marca o il modello");
define("_BRAND_NOT_IN_LIST","Marca non presente");
define("_Email_new_password","<p align='justify'>Il server ha inviato un email al pilota con la nuova password e chiave di attivazione</p> <p align='justify'>Controlla la tua casella email e segui la procedura descritta nella email</p>");
define("_informed_user_not_found","L'utente informato non &grave; stato trovato nel nostro database");
define("_impossible_to_gen_new_pass","<p align='justify'>Ci dispiace informarti che non &grave; possibile generare una nuova password in questo momento, esiste una richiesta che scadr&agrave; il <b>%s</b>. Solo dopo la scadenza potrai fare una nuova richiesta.</p><p align='justify'>Se non riesci ad accedere alla email contatta l'amministratore del server</p>");
define("_Password_subject_confirm","Email di conferma (nuova password)");
define("_request_key_not_found","la chiave di richiesta non &egrave; stata trovata!");
define("_request_key_invalid","la chiave di richiesta non &egrave; valida!");
define("_Email_allready_yours","The informed email is allready yours, nothing to do");
define("_Email_allready_have_request","C'&egrave; gi&agrave; una richiesta di cambiamento a questa email, niente da fare");
define("_Email_used_by_other","Questa email viene utilizzata in un altro pilota, niente da fare");
define("_Email_used_by_other_request","Questa email &egrave; utilizzata in un'altro pilota in una richiesta di cambio email");
define("_Email_canot_change_quickly","Non puoi cambiare la tua email così rapidamente, attendi la scadenza: %s");
define("_Email_sent_with_confirm","Noi ti inviamo un'email, dove ci confermerai il cambio di email");
define("_Email_subject_confirm","Email di conferma (nuova email)");
define("_Email_AndConfDontMatch","Email e conferma sono diverse.");
define("_ChangingEmailForm"," Modulo di Cambio Email");
define("_Email_current","Email Attuale");
define("_New_email","Nuovo Indirizzo Email");
define("_New_email_confirm","Conferma Nuova Email");
define("_MENU_CHANGE_PASSWORD","Cambia la mia password");
define("_MENU_CHANGE_EMAIL","Cambia la mia email");
define("_New_Password","Nuova Password");
define("_ChangePasswordForm","Modulo Cambio Password");
define("_lost_password","Modulo Password Persa");
define("_PASSWORD_RECOVERY_TOOL","Modulo Recupero Password");
define("_PASSWORD_RECOVERY_TOOL_MESSAGE","Il server cercherà nel suo database per intero il testo inserito nella casella di testo, se e quando il server trova l'utente, e-mail, o civlid, Una mail saranno inviati per l'indirizzo di posta elettronica, con una nuova password e il link di attivazione. <Br > <br> Nota: solo dopo l'attivazione della nuova password tramite link di attivazione all'interno del corpo di posta elettronica, la nuova password sarà valida.<br><br>");
define("_username_civlid_email","Inserisci: CIVLID o Nome Utente o Indirizzo Email");
define("_Recover_my_pass","Recupera la mia Password");
define("_You_are_not_login","<BR><BR><center><br>Non sei loggato. <br><br>Fai il Login<BR><BR></center>");
define("_Requirements","Requisiti");
define("_Mandatory_CIVLID","E' obbligatorio avere un valido <b>CIVLID</b>");
define("_Mandatory_valid_EMAIL","E' obbligatorio inserire una <b>Email Valida</b> per ulteriori comunicazioni con l'amministratore del server");
define("_Email_periodic","Periodicamente invieremo una conferma via e-mail al vostro indirizzo e-mail, se non si risponde, l'account di registrazione verrà bloccato");
define("_Email_asking_conf","Invieremo una email di conferma all'indirizzo e-mail comunicato");
define("_Email_time_conf","Avrai solo <b>3 ore</b> dopo aver finito la pre-registrazione per rispondere alla email");
define("_After_conf_time"," Dopo questo tempo, la tua pre-registrazione sar&agrave; <b>rimossa</b> dal nostro database");
define("_Only_after_time","<b>E solo dopo che abbiamo rimosso la tua pre-registrazione, potrai pre-registrarti di nuovo</b>");
define("_Disable_Anti_Spam","<b>ATTENZIONE!! Disabilita</b> l'anti-spam per le email originate da <b>%s</b>");
define("_If_you_agree","Se siete d'accordo con questi requisiti, si prega di proseguire.");
define("_Search_civl_by_name","%sCerca il tuo nome nel database CIVL %s . Quando si fa clic su questo link a sinistra si aprirà una nuova finestra, ti preghiamo di compilare solo 3 lettere dal tuo Nome o Cognome, il CIVL ti dar&agrave; il tuo CIVLID, Nome e nazionalit&agrave; FAI.");
define("_Register_civl_as_new_pilot","Se non compari nel database CIVL, %sREGISTER-ME AS A NEW PILOT%s");
define("_NICK_NAME","Nick Name");
define("_LOCAL_PWD","Local Password");
define("_LOCAL_PWD_2","Ripeti Local Password");
define("_CONFIRM","Conferma");
define("_REQUIRED_FIELD","Campi obbligatori");
define("_Registration_Form","Modulo di Registrazione su %s (Leonardo)");
define("_MANDATORY_NAME","E' Obbligatorio comunicare il tuo nome");
define("_MANDATORY_FAI_NATION","E' Obbligatorio comunicare la tua NAZIONE FAI");
define("_MANDATORY_GENDER","Comunica il tuo Sesso");
define("_MANDATORY_BIRTH_DATE_INVALID","Data di nascita Non Valida");
define("_MANDATORY_CIVL_ID","Comunica il tuo CIVLID");
define("_Attention_mandatory_to_have_civlid","ATTENZIONE!! Per ora &egrave; Obbligatorio avere il CIVLID nel %s database");
define("_Email_confirm_success","La registrazione è stata confermata con successo!");
define("_Success_login_civl_or_user","Successo, ora si pu&ograve; fare il login con il tuo CIVLID come nome utente, o continuare con il vecchio nome utente");
define("_Server_did_not_found_registration","Registrazione non trovata, si prega di copiare e incollare nel vostro campo degli indirizzi del browser il link comunicato nell'e-mail che vi &egrave; stata inviata, forse il tempo di registrazione &egrave; scaduto");
define("_Pilot_already_registered","Pilota gi&agrave; registrato con CIVLID %s e con nome %s");
define("_User_already_registered","Utente già registrato con questa e-mail o nome");
define("_Pilot_civlid_email_pre_registration","Salve %s Questo Civl ID e l'e-mail &egrave; gi&agrave; utilizzato in una pre-registrazione");
define("_Pilot_have_pre_registration"," Avete gi&agrave; una registrazione preliminare, ma non avete risposto alla nostra mail, abbiamo nuovamente inviato l'email di conferma per voi, avete 3 ore da adesso per rispondere alla email, altrimenti verrete rimosso dalla registrazione preliminare. Si prega di leggere la posta elettronica e seguire le procedure descritte all'interno, grazie");
define("_Pre_registration_founded","Abbiamo gi&agrave; una pre-registrazione, con questo civlID ed e-mail, attendere 3 ore dopodich&egrave; tale registrazione verr&agrave; rimossa, per nessun motivo bisogna confermare l'email inviata, in quanto verrebe generata una doppia registrazione, ed i vecchi voli non saranno trasferiti al nuovo utente");
define("_Civlid_already_in_use","Questo CIVLID &egrave; usato un'altro pilota, non si possono avere CIVLID doppi!");
define("_Pilot_email_used_in_reg_dif_civlid","Salve %s Questa email &egrave; utilizzata in un altra registrazione con diverso CIVLID");
define("_Pilot_civlid_used_in_reg_dif_email","Salve %s Questa CIVLID &egrave; utilizzata in un altra registrazione con diverso EMAIL");
define("_Pilot_email_used_in_pre_reg_dif_civlid","Salve %s Questa email &egrave; utilizzata in un altra pre-registrazione con diverso CIVLID");
define("_Pilot_civlid_used_in_pre_reg_dif_email","Salve %s Questa CIVLID &egrave; utilizzata in un altra pre-registrazione con diverso EMAIL");
define("_Server_send_conf_email","Il server ha inviato al %s una e-mail per chiedere conferma, hai 3 ore da ora per confermare la registrazione cliccando o copiando e incollando il link che si trova nel corpo del email nel campo indirizzo del browser");
define("_MENU_AREA_GUIDE","Guida Aree");
define("_All_XC_types","Tutti i tipi di XC");
define("_xctype"," Tipo di XC");
define("_Flying_Areas","Aree di Volo");
define("_Name_of_Area","Nome dell'Area");
define("_See_area_details","Vedi i dettagli ed i decolli di quest'area");
define("_choose_ge_module","Scegli il modulo da usare<BR>per Google Earth");
define("_ge_module_advanced_1","(Pi&ugrave; dettagliato, molto grande)");
define("_ge_module_advanced_2","(Molti dettagli, grande) ");
define("_ge_module_Simple","Simple (Solo Task, molto piccolo)");
define("_Pilot_search_instructions","Inserisci almeno 3 lettere del Nome o Cognome");
define("_All_classes","Tutte le  classi");
define("_Class","Classe");
define("_Photos_filter_off","Con/senza foto");
define("_Photos_filter_on","Solo con foto");
define("_GLIDER_CERT","Certificazione");
define("_PLEASE_SELECT_YOUR_GLIDER_CERTIFICATION","Scegli la certificazione del tuo mezzo");
define("_SHOW_NEWS","Mostra News");



//--------------------------------------------------------
//--------------------------------------------------------
// Missing defines , autoreplaced values from 'english' 
//--------------------------------------------------------
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
define("_You_are_already_logged_in","You are already logged in"); 
define("_See_The_filter","See the filter"); 
define("_PilotBirthdate","Pilot Birthdate"); 
define("_Start_Type","Start Type"); 
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
<?php
/**************************************************************************/
/* French language translation by                                        */
/* Etienne Prade (http://www.prade.net)                                  */
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
	global  $monthList,	$monthListShort, $weekdaysList;
	$monthList=array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 
		'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'  );
	$monthListShort=array('JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC');
	$weekdaysList=array('Mon','Tue','Wed','Thu','Fri','Sat','Sun') ;
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","Vol Libre");
define("_FREE_TRIANGLE","Triangle Libre");
define("_FAI_TRIANGLE","Triangle FAI");

define("_SUBMIT_FLIGHT_ERROR","Un problème a été rencontré pendant le chargement du vol");

// list_pilots()
define("_NUM","#");
define("_PILOT","Pilote");
define("_NUMBER_OF_FLIGHTS","Nombre de Vols");
define("_BEST_DISTANCE","Meilleure Distance");
define("_MEAN_KM","Nombre moyen de kilomètres par vol");
define("_TOTAL_KM","Kilométrage total en vol");
define("_TOTAL_DURATION_OF_FLIGHTS","Durée totale de vol");
define("_MEAN_DURATION","Durée moyenne de vol");
define("_TOTAL_OLC_KM","Distance totale OLC");
define("_TOTAL_OLC_SCORE","Score total OLC");
define("_BEST_OLC_SCORE","Meilleur score OLC");
define("_From","de");

// list_flights()
define("_DURATION_HOURS_MIN","Durée (heures:minutes)");
define("_SHOW","Afficher");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","Le vol sera activé dans 1-2 minutes. ");
define("_TRY_AGAIN","Veuillez réessayer plus tard");

define("_TAKEOFF_LOCATION","Décollage");
define("_TAKEOFF_TIME","Heure du décollage");
define("_LANDING_LOCATION","Atterrissage");
define("_LANDING_TIME","Heure d\'atterrissage");
define("_OPEN_DISTANCE","Distance Linéaire");
define("_MAX_DISTANCE","Distance Maximum");
define("_OLC_SCORE_TYPE","Type de score OLC");
define("_OLC_DISTANCE","Distance OLC");
define("_OLC_SCORING","Score OLC");
define("_MAX_SPEED","Vitesse Maximum");
define("_MAX_VARIO","Vario Maximum");
define("_MEAN_SPEED","Vitesse Moyenne");
define("_MIN_VARIO","Vario Minimum");
define("_MAX_ALTITUDE","Altitude Maximum (ASL)");
define("_TAKEOFF_ALTITUDE","Altitude de Décollage (ASL)");
define("_MIN_ALTITUDE","Altitude Minimum (ASL)");
define("_ALTITUDE_GAIN","Gain d\'Altitude");
define("_FLIGHT_FILE","Fichier de vol");
define("_COMMENTS","Commentaires");
define("_RELEVANT_PAGE","Adresse URL correspondante");
define("_GLIDER","Planeur");
define("_PHOTOS","Photos");
define("_MORE_INFO","Extras");
define("_UPDATE_DATA","Actualiser les informations");
define("_UPDATE_MAP","Actualiser la carte");
define("_UPDATE_3D_MAP","Actualiser la carte 3D");
define("_UPDATE_GRAPHS","Actualiser les graphiques");
define("_UPDATE_SCORE","Actualiser le score");

define("_TAKEOFF_COORDS","Coordonnées du décollage:");
define("_NO_KNOWN_LOCATIONS","Aucun lieu répertorié!");
define("_FLYING_AREA_INFO","Infos sur la zone de vol");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo XC");
define("_RETURN_TO_TOP","Haut de page");
// list flight
define("_PILOT_FLIGHTS","Vols du pilote");

define("_DATE_SORT","Date");
define("_PILOT_NAME","Nom du pilote");
define("_TAKEOFF","Décollage");
define("_DURATION","Durée");
define("_LINEAR_DISTANCE","Distance linéaire");
define("_OLC_KM","Km OLC");
define("_OLC_SCORE","Score OLC");
define("_DATE_ADDED","Derniers ajouts");

define("_SORTED_BY","Trier par:");
define("_ALL_YEARS","Toutes les années");
define("_SELECT_YEAR_MONTH","Selectionner l\'année (et le mois)");
define("_ALL","Tout");
define("_ALL_PILOTS","Afficher tous les pilotes");
define("_ALL_TAKEOFFS","Afficher tous les décollages");
define("_ALL_THE_YEAR","Toute l\'année");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","Vous n'avez pas fourni de fichier de vol");
define("_NO_SUCH_FILE","Le fichier que vous avez fourni n'a pas été trouvé sur le serveur");
define("_FILE_DOESNT_END_IN_IGC","Le fichier n'a pas de suffixe en .igc");
define("_THIS_ISNT_A_VALID_IGC_FILE","Ce n'est pas un fichier .igc valide");
define("_THERE_IS_SAME_DATE_FLIGHT","Un vol avec la même date et la même heure existe déjà");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","Si vous voulez le remplacer vous devriez d'abord");
define("_DELETE_THE_OLD_ONE","effacer l'ancien");
define("_THERE_IS_SAME_FILENAME_FLIGHT","Un fichier avec le même nom existe déjà");
define("_CHANGE_THE_FILENAME","S'il s'agit d'un vol différent veuillez changer le nom et essayez à nouveau");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","Votre vol a été chargé");
define("_PRESS_HERE_TO_VIEW_IT","Pressez ici pour le visualiser");
define("_WILL_BE_ACTIVATED_SOON","(il sera activé dans 1-2 minutes)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Charger plusieurs vols");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","Seuls les fichiers IGC seront pris en compte");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","Charger le fichier ZIP <br> qui contient les vols");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","Pressez ici pour charger les vols");

define("_FILE_DOESNT_END_IN_ZIP","Le vol que vous proposez n'a pas de suffixe en .zip");
define("_ADDING_FILE","Chargement en cours");
define("_ADDED_SUCESSFULLY","Chargement terminé");
define("_PROBLEM","Problème");
define("_TOTAL","Total de ");
define("_IGC_FILES_PROCESSED","Les vols ont été traités");
define("_IGC_FILES_SUBMITED","Les vols ont été chargés");

// info
define("_DEVELOPMENT","Développement");
define("_ANDREADAKIS_MANOLIS","Andreadakis Manolis");
define("_PROJECT_URL","Adresse URL du projet");
define("_VERSION","Version");
define("_MAP_CREATION","Creation de la carte");
define("_PROJECT_INFO","Infos sur le projet");

// menu bar 
define("_MENU_MAIN_MENU","Menu principal");
define("_MENU_DATE","Selectionner Date");
define("_MENU_COUNTRY","Selectionner pays");
define("_MENU_XCLEAGUE","XC League");
define("_MENU_ADMIN","Admin");

define("_MENU_COMPETITION_LEAGUE","Ligue - toutes catégories");
define("_MENU_OLC","OLC");
define("_MENU_OPEN_DISTANCE","Distance libre");
define("_MENU_DURATION","Durée");
define("_MENU_ALL_FLIGHTS","Afficher tous les vols");
define("_MENU_FLIGHTS","Vols");
define("_MENU_TAKEOFFS","Décollages");
define("_MENU_FILTER","Filtrer");
define("_MENU_MY_FLIGHTS","Mes vols");
define("_MENU_MY_PROFILE","Mon profil");
define("_MENU_MY_STATS","Mes statistiques"); 
define("_MENU_MY_SETTINGS","Mes réglages"); 
define("_MENU_SUBMIT_FLIGHT","Charger des vols");
define("_MENU_SUBMIT_FROM_ZIP","Charger des vols depuis un zip");
define("_MENU_SHOW_PILOTS","Pilotes");
define("_MENU_SHOW_LAST_ADDED","Chargements récents");
define("_FLIGHTS_STATS","Statistiques des vols");

define("_SELECT_YEAR","Selectionner une année");
define("_SELECT_MONTH","Selectionner un mois");
define("_ALL_COUNTRIES","Afficher tous les pays");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","Tous les temps");
define("_NUMBER_OF_FLIGHTS","Nombre de vols");
define("_TOTAL_DISTANCE","Distance totale");
define("_TOTAL_DURATION","Durée totale");
define("_BEST_OPEN_DISTANCE","Meilleure distance");
define("_TOTAL_OLC_DISTANCE","Distance OLC totale");
define("_TOTAL_OLC_SCORE","Score OLC total");
define("_BEST_OLC_SCORE","Meilleur score OLC");
define("_MEAN_DURATION","Durée moyenne");
define("_MEAN_DISTANCE","Distance moyenne");
define("_PILOT_STATISTICS_SORT_BY","Pilotes - Trier par");
define("_CATEGORY_FLIGHT_NUMBER","Categorie 'FastJoe' - Nombre de vols");
define("_CATEGORY_TOTAL_DURATION","Categoryie 'DURACELL' - Durée totale des vols");
define("_CATEGORY_OPEN_DISTANCE","Categorie 'Distance Libre'");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","Il n'y a aucun pilote à afficher!");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","Le vol a été effacé");
define("_RETURN","Retour");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","ATTENTION - Vous êtes sur le point d'effacer ce vol");
define("_THE_DATE","Date ");
define("_YES","OUI");
define("_NO","NON");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","Resultats ligue");
define("_N_BEST_FLIGHTS"," Meilleurs vols");
define("_OLC","OLC");
define("_OLC_TOTAL_SCORE","Score total OLC");
define("_KILOMETERS","Kilomètres");
define("_TOTAL_ALTITUDE_GAIN","Gain d'altitude total");
define("_TOTAL_KM","Kilométrage total");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","est");
define("_IS_NOT","n'est pas");
define("_OR","ou");
define("_AND","et");
define("_FILTER_PAGE_TITLE","Filtrer les vols");
define("_RETURN_TO_FLIGHTS","Retour aux vols");
define("_THE_FILTER_IS_ACTIVE","Le filtre est actif");
define("_THE_FILTER_IS_INACTIVE","Le filtre est inactif");
define("_SELECT_DATE","Sélectionner une date");
define("_SHOW_FLIGHTS","Afficher les vols");
define("_ALL2","TOUT");
define("_WITH_YEAR","Avec l'année");
define("_MONTH","Mois");
define("_YEAR","Année");
define("_FROM","de");
define("_from","de");
define("_TO","à");
define("_SELECT_PILOT","Sélectionner Pilote");
define("_THE_PILOT","Le pilote");
define("_THE_TAKEOFF","Le décollage");
define("_SELECT_TAKEOFF","Sélectionner décollage");
define("_THE_COUNTRY","Le pays");
define("_COUNTRY","Pays");
define("_SELECT_COUNTRY","Sélectionner pays");
define("_OTHER_FILTERS","Autres Filtres");
define("_LINEAR_DISTANCE_SHOULD_BE","La distance linéaire devrait être");
define("_OLC_DISTANCE_SHOULD_BE","La distance OLC devrait être");
define("_OLC_SCORE_SHOULD_BE","Le score OLC devrait être");
define("_DURATION_SHOULD_BE","La durée devrait être");
define("_ACTIVATE_CHANGE_FILTER","Activer / changer FILTRE");
define("_DEACTIVATE_FILTER","Désactiver FILTRE");
define("_HOURS","heures");
define("_MINUTES","min");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","Charger vol");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(Seul le fichier IGC est demandé)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","Charger le <br>fichier IGC du vol");
define("_NOTE_TAKEOFF_NAME","Veuillez noter the nom, emplacement et pays du décollage");
define("_COMMENTS_FOR_THE_FLIGHT","Commentaires sur le vol");
define("_PHOTO","Photo");
define("_PHOTOS_GUIDELINES","Les photos doivent être au format jpg et faire moins de ");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","Cliquez ici pour charger le vol");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","Voulez-vous charger beaucoup de vols à la fois ?");
define("_PRESS_HERE","Cliquez ici");

define("_IS_PRIVATE","Ne pas montrer publiquement");
define("_MAKE_THIS_FLIGHT_PRIVATE","Ne pas montrer publiquement");
define("_INSERT_FLIGHT_AS_USER_ID","Ajouter vol sous une autre identité");
define("_FLIGHT_IS_PRIVATE","Ce vol est privé");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","Modifier les données de vol");
define("_IGC_FILE_OF_THE_FLIGHT","Fichier IGC du vol");
define("_DELETE_PHOTO","Effacer");
define("_NEW_PHOTO","Nouvelle photo");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","Cliquez ici pour modifier les données de vol");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","Les modifications ont été effectuées");
define("_RETURN_TO_FLIGHT","Revenir au vol");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","Revenir au vol");
define("_READY_FOR_SUBMISSION","Prêt à charger");
define("_OLC_MAP","Carte");
define("_OLC_BARO","Barographe");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","Profil du pilote");
define("_back_to_flights","Retour aux vols");
define("_pilot_stats","Statistiques pilote");
define("_edit_profile","Editer profil");
define("_flights_stats","Statistiques de vol");
define("_View_Profile","Visualiser Profil");

define("_Personal_Stuff","Personnel");
define("_First_Name"," Prénom");
define("_Last_Name","Nom");
define("_Birthdate","Date de naissance");
define("_dd_mm_yy","jj.mm.aa");
define("_Sign","Signer");
define("_Marital_Status","Situation Maritale");
define("_Occupation","Situation professionnelle");
define("_Web_Page","Page Web");
define("_N_A","Non disponible");
define("_Other_Interests","Autres Interêts");
define("_Photo","Photo");

define("_Flying_Stuff","Pratique de vol");
define("_note_place_and_date","si nécessaire noter le lieu / pays et la date");
define("_Flying_Since","Vole depuis");
define("_Pilot_Licence","Licence du pilote");
define("_Paragliding_training","Formation au parapente");
define("_Favorite_Location","Site de vol favori");
define("_Usual_Location","Site de vol habituel");
define("_Best_Flying_Memory","Meilleur souvenir de vol");
define("_Worst_Flying_Memory","Pire souvenir de vol");
define("_Personal_Distance_Record","Record personnel de distance");
define("_Personal_Height_Record","Record personnel d'altitude");
define("_Hours_Flown","Heures de vol");
define("_Hours_Per_Year","Heures de vol par an");

define("_Equipment_Stuff","Equipement");
define("_Glider","Voile");
define("_Harness","Sellette");
define("_Reserve_chute","Parachute de secours");
define("_Camera","Appareil photo");
define("_Vario","Vario");
define("_GPS","GPS");
define("_Helmet","Casque");
define("_Camcorder","Caméra");

define("_Manouveur_Stuff","Manoeuvres");
define("_note_max_descent_rate","Si possible noter le taux de descente max atteint");
define("_Spiral","Spirale");
define("_Bline","Décrochage aux B");
define("_Full_Stall","Décrochage dynamique");
define("_Other_Manouveurs_Acro","Autres Manoeuvres Acro");
define("_Sat","Sat");
define("_Asymmetric_Spiral","Spirale assymétrique");
define("_Spin","Vrille");

define("_General_Stuff","General");
define("_Favorite_Singer","Chanteur(/euse) préféré(e)");
define("_Favorite_Movie","Film préféré");
define("_Favorite_Internet_Site","Site <br>Internet favori");
define("_Favorite_Book","Livre préféré");
define("_Favorite_Actor","Acteur(/trice) préféré(e)");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","Charger une nouvelle photo ou changer l'ancienne");
define("_Delete_Photo","Effacer Photo");
define("_Your_profile_has_been_updated","Votre profil a été actualisé");
define("_Submit_Change_Data","Rentrer - Modifier les données");

//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","hh:mm");

define("_Totals","Totaux");
define("_First_flight_logged","Premier vol chargé");
define("_Last_flight_logged","Dernier vol chargé");
define("_Flying_period_covered","Période de vol couverte");
define("_Total_Distance","Distance Totale");
define("_Total_OLC_Score","Score Total OLC");
define("_Total_Hours_Flown","Heures de vol totales");
define("_Total_num_of_flights","Nombre total de vols ");

define("_Personal_Bests","Records Personnels");
define("_Best_Open_Distance","Meilleure distance libre");
define("_Best_FAI_Triangle","Meilleur Triangle FAI");
define("_Best_Free_Triangle","Meilleur Triangle Libre");
define("_Longest_Flight","Vol le plus long");
define("_Best_OLC_score","Meilleur score OLC");

define("_Absolute_Height_Record","Record d'altitude absolu");
define("_Altitute_gain_Record","Record de gain d'altitude");
define("_Mean_values","Valeurs moyennes");
define("_Mean_distance_per_flight","Distance moyenne par vol");
define("_Mean_flights_per_Month","Nombre de vols moyen par mois");
define("_Mean_distance_per_Month","Distance moyenne par mois");
define("_Mean_duration_per_Month","Durée moyenne par mois");
define("_Mean_duration_per_flight","Durée moyenne par vol");
define("_Mean_flights_per_Year","Nombre de vols moyen par an");
define("_Mean_distance_per_Year","Distance moyenne par an");
define("_Mean_duration_per_Year","Durée moyenne par an");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","Voir les vols près de ce point");
define("_Waypoint_Name","Nom du Waypoint");
define("_Navigate_with_Google_Earth","Naviguer avec Google Earth");
define("_See_it_in_Google_Maps","Afficher dans Google Maps");
define("_See_it_in_MapQuest","Afficher dans MapQuest");
define("_COORDINATES","Coordonnées");
define("_FLIGHTS","Vols");
define("_SITE_RECORD","Record du site");
define("_SITE_INFO","Informations sur le site");
define("_SITE_REGION","Région");
define("_SITE_LINK","Lien pour obtenir plus d'informations");
define("_SITE_DESCR","Description du site/décollage");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","Voir plus de détails");
define("_KML_file_made_by","Fichier KML créé par");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","Enregistrer un décollage");
define("_WAYPOINT_ADDED","Le décollage a été enregistré");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","Record du site<br>(distance libre)");
	
//--------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","Type de voile");
function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'Parapente',2=>'Delta (FAI 1)',4=>'Rigide (FAI 5) ',8=>'Planeur');
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

define("_Your_settings_have_been_updated","Vos paramètres ont été actualisés");

define("_THEME","Thème");
define("_LANGUAGE","Langue");
define("_VIEW_CATEGORY","Voir catégorie");
define("_VIEW_COUNTRY","Voir pays");
define("_UNITS_SYSTEM" ,"Systême d'unités");
define("_METRIC_SYSTEM","Métrique (km,m)");
define("_IMPERIAL_SYSTEM","Imperial (miles,feet)");
define("_ITEMS_PER_PAGE","Objets par page");

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

define("_WORLD_WIDE","Monde entier");
define("_National_XC_Leagues_for","Ligues nationales pour");
define("_Flights_per_Country","Vols par pays");
define("_Takeoffs_per_Country","Décollages par pays");
define("_INDEX_HEADER","Bienvenue dans Leonardo XC League");
define("_INDEX_MESSAGE","Vous pouvez utiliser le &quot;Menu principal&quot; pour naviguer ou utiliser les choix de catégories présentés ci-dessous.");

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
?>
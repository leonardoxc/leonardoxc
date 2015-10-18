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
//--------------------------------------------------------
//--------------------------------------------------------
// Missing defines , autoreplaced values from 'english' 
//--------------------------------------------------------
define("_SEASON","Season"); 
define("_IS_FRIENDS_ONLY_","Visible to Friends Only"); 
define("_friends_text1","Map and charts are visible to Friends Only"); 
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
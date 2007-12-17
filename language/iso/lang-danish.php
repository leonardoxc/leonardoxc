<? if (0){?><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head><? }?><?php

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
	$monthList=array('Januar','Februar','Marts','April','Maj','Juni',
					'Juli','August','September','Oktober','November','December');
	$monthListShort=array('JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC');
	$weekdaysList=array('Mon','Tue','Wed','Thu','Fri','Sat','Sun') ;
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","Fri flyvning");
define("_FREE_TRIANGLE","Fri trekant");
define("_FAI_TRIANGLE","FAI trekant");

define("_SUBMIT_FLIGHT_ERROR","Der skete en fejl under indsendelsen af flyvningen");

// list_pilots()
define("_NUM","#");
define("_PILOT","Pilot");
define("_NUMBER_OF_FLIGHTS","Antal flyvninger");
define("_BEST_DISTANCE","Bedste distance");
define("_MEAN_KM","Gennemsnitlig km per flyvning");
define("_TOTAL_KM","Totalt fløjet km");
define("_TOTAL_DURATION_OF_FLIGHTS","Total flyvetid");
define("_MEAN_DURATION","Gennemsnitlig flyvetid");
define("_TOTAL_OLC_KM","Total OLC distance");
define("_TOTAL_OLC_SCORE","Total OLC points");
define("_BEST_OLC_SCORE","Bedste OLC points");
define("_From","fra");

// list_flights()
define("_DURATION_HOURS_MIN","Flyvetid (t:m)");
define("_SHOW","Vis");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","Flyvningen vil blive aktiveret om 1-2 minutter. ");
define("_TRY_AGAIN","Prøv venligst igen lidt senere");

define("_TAKEOFF_LOCATION","Startsted");
define("_TAKEOFF_TIME","Start tidspunkt");
define("_LANDING_LOCATION","Landingssted");
define("_LANDING_TIME","Landingstidspunkt");
define("_OPEN_DISTANCE","Fri distance");
define("_MAX_DISTANCE","Max distance");
define("_OLC_SCORE_TYPE","OLC points-type");
define("_OLC_DISTANCE","OLC distance");
define("_OLC_SCORING","OLC points");
define("_MAX_SPEED","Max hastighed");
define("_MAX_VARIO","Max stig");
define("_MEAN_SPEED","Middel hastighed");
define("_MIN_VARIO","Max synk");
define("_MAX_ALTITUDE","Max højde (ASL)");
define("_TAKEOFF_ALTITUDE","Start højde (ASL)");
define("_MIN_ALTITUDE","Laveste højde (ASL)");
define("_ALTITUDE_GAIN","Højdevinding");
define("_FLIGHT_FILE","Flyvningens log fil");
define("_COMMENTS","Kommentarer");
define("_RELEVANT_PAGE","Relevant link (URL)");
define("_GLIDER","Glider");
define("_PHOTOS","Billeder");
define("_MORE_INFO","Ekstra");
define("_UPDATE_DATA","Opdatér data");
define("_UPDATE_MAP","Opdatér kort");
define("_UPDATE_3D_MAP","Opdatér 3D kort");
define("_UPDATE_GRAPHS","Opdatér grafer");
define("_UPDATE_SCORE","Opdatér points beregning");

define("_TAKEOFF_COORDS","Start koordinater:");
define("_NO_KNOWN_LOCATIONS","Der er ingen kendte lokationer!");
define("_FLYING_AREA_INFO","Information om flyveområdet");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo XC");
define("_RETURN_TO_TOP","Tilbage til toppen");
// list flight
define("_PILOT_FLIGHTS","Pilotens flyvninger");

define("_DATE_SORT","Dato");
define("_PILOT_NAME","Pilotens navn");
define("_TAKEOFF","Startsted");
define("_DURATION","Flyvetid");
define("_LINEAR_DISTANCE","Fri distance");
define("_OLC_KM","OLC km");
define("_OLC_SCORE","OLC points");
define("_DATE_ADDED","Seneste indberetning");

define("_SORTED_BY","Sortér efter:");
define("_ALL_YEARS","Alle år");
define("_SELECT_YEAR_MONTH","Vælg år (og måned)");
define("_ALL","Alle");
define("_ALL_PILOTS","Vis alle piloter");
define("_ALL_TAKEOFFS","Vis alle startsteder");
define("_ALL_THE_YEAR","Hele året");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","Du har ikke angivet nogen log fil for flyvningen");
define("_NO_SUCH_FILE","Den fil du har angivet kan ikke findes på serveren");
define("_FILE_DOESNT_END_IN_IGC","Filen er ikke en .igc fil");
define("_THIS_ISNT_A_VALID_IGC_FILE","Dette er ikke en gyldig .igc fil");
define("_THERE_IS_SAME_DATE_FLIGHT","Der findes allerede en flyvning med samme dato og tid");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","Hvis du vil erstatte den skal du først");
define("_DELETE_THE_OLD_ONE","slette den gamle");
define("_THERE_IS_SAME_FILENAME_FLIGHT","Der findes allerede en flyvning med samme filnavn");
define("_CHANGE_THE_FILENAME","Vær venlig at omdøbe filen hvis dette er en anden flyvning");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","Din flyvning er indsendt");
define("_PRESS_HERE_TO_VIEW_IT","Klik her for at se den");
define("_WILL_BE_ACTIVATED_SOON","(den bliver aktiveret om 1-2 minutter)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Indsend flere flyvninger");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","Kun IGC filer bliver behandlet");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","Indsend ZIP filen<br>med flyvningerne");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","Klik her for at indsende flyvningerne");

define("_FILE_DOESNT_END_IN_ZIP","Filen du indsendte er ikke en .zip fil");
define("_ADDING_FILE","Sender fil");
define("_ADDED_SUCESSFULLY","Indsendingen lykkedes");
define("_PROBLEM","Problem");
define("_TOTAL","Ialt ");
define("_IGC_FILES_PROCESSED","flyvninger er behandlet");
define("_IGC_FILES_SUBMITED","flyvninger er indsendt");

// info
define("_DEVELOPMENT","Udvikling");
define("_ANDREADAKIS_MANOLIS","Andreadakis Manolis");
define("_PROJECT_URL","Projekt side");
define("_VERSION","Version");
define("_MAP_CREATION","Kortgenerering");
define("_PROJECT_INFO","Projektinformation");

// menu bar 
define("_MENU_MAIN_MENU","Hovedmenu");
define("_MENU_DATE","Vælg dato");
define("_MENU_COUNTRY","Vælg land");
define("_MENU_XCLEAGUE","XC Liga");
define("_MENU_ADMIN","Administration");

define("_MENU_COMPETITION_LEAGUE","Liga - alle kategorier");
define("_MENU_OLC","OLC");
define("_MENU_OPEN_DISTANCE","Fri distance");
define("_MENU_DURATION","Flyvetid");
define("_MENU_ALL_FLIGHTS","Vis alle flyvninger");
define("_MENU_FLIGHTS","Flyvninger");
define("_MENU_TAKEOFFS","Startsteder");
define("_MENU_FILTER","Filter");
define("_MENU_MY_FLIGHTS","Mine flyvninger");
define("_MENU_MY_PROFILE","Min profil");
define("_MENU_MY_STATS","Min statistik"); 
define("_MENU_MY_SETTINGS","Mine indstillinger"); 
define("_MENU_SUBMIT_FLIGHT","Indsend flyvning");
define("_MENU_SUBMIT_FROM_ZIP","Indsend flyvninger fra zip fil");
define("_MENU_SHOW_PILOTS","Piloter");
define("_MENU_SHOW_LAST_ADDED","Vis seneste indsendelser");
define("_FLIGHTS_STATS","Statistik over flyvninger");

define("_SELECT_YEAR","Vælg år");
define("_SELECT_MONTH","Vælg måned");
define("_ALL_COUNTRIES","Vis alle lande");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","ALLE TIDER");
define("_NUMBER_OF_FLIGHTS","Antal flyvninger");
define("_TOTAL_DISTANCE","Total distance");
define("_TOTAL_DURATION","Total flyvetid");
define("_BEST_OPEN_DISTANCE","Bedste distance");
define("_TOTAL_OLC_DISTANCE","Total OLC distance");
define("_TOTAL_OLC_SCORE","Total OLC points");
define("_BEST_OLC_SCORE","Bedste OLC points");
define("_MEAN_DURATION","Middel flyvetid");
define("_MEAN_DISTANCE","Middel distance");
define("_PILOT_STATISTICS_SORT_BY","Piloter - Sortér efter");
define("_CATEGORY_FLIGHT_NUMBER","Kategori 'FastJoe' - Antal flyvninger");
define("_CATEGORY_TOTAL_DURATION","Kategory 'DURACELL' - Total flyvetid");
define("_CATEGORY_OPEN_DISTANCE","Kategory 'Fri distance'");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","Der er ingen piloter at vise!");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","Flyvningen er slettet");
define("_RETURN","Tilbage");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","ADVARSEL - Du er ved at slette denne flyvning");
define("_THE_DATE","Dato ");
define("_YES","JA");
define("_NO","NEJ");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","Liga resultater");
define("_N_BEST_FLIGHTS"," bedste flyvninger");
define("_OLC","OLC");
define("_OLC_TOTAL_SCORE","OLC total points");
define("_KILOMETERS","Kilometer");
define("_TOTAL_ALTITUDE_GAIN","Total højdevinding");
define("_TOTAL_KM","Total km");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","er");
define("_IS_NOT","er ikke");
define("_OR","eller");
define("_AND","og");
define("_FILTER_PAGE_TITLE","Filtrér flyvninger");
define("_RETURN_TO_FLIGHTS","Tilbage til flyvninger");
define("_THE_FILTER_IS_ACTIVE","Filteret er aktivt");
define("_THE_FILTER_IS_INACTIVE","Filteret er inaktivt");
define("_SELECT_DATE","Vælg dato");
define("_SHOW_FLIGHTS","Vis flyvninger");
define("_ALL2","ALLE");
define("_WITH_YEAR","Med år");
define("_MONTH","Måned");
define("_YEAR","År");
define("_FROM","Fra");
define("_from","fra");
define("_TO","Til");
define("_SELECT_PILOT","Vælg pilot");
define("_THE_PILOT","Piloten");
define("_THE_TAKEOFF","Startstedet");
define("_SELECT_TAKEOFF","Vælg startsted");
define("_THE_COUNTRY","Landet");
define("_COUNTRY","Land");
define("_SELECT_COUNTRY","Vælg land");
define("_OTHER_FILTERS","Andre filtre");
define("_LINEAR_DISTANCE_SHOULD_BE","Den fri distance skal være");
define("_OLC_DISTANCE_SHOULD_BE","OLC distancen skal være");
define("_OLC_SCORE_SHOULD_BE","OLC points skal være");
define("_DURATION_SHOULD_BE","Flyvetiden skal være");
define("_ACTIVATE_CHANGE_FILTER","Aktivér / ændre FILTER");
define("_DEACTIVATE_FILTER","Deaktivér FILTER");
define("_HOURS","timer");
define("_MINUTES","minutter");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","Indsend flyvning");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(kun IGC filen skal bruges)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","Indsend<br>flyvningens IGC fil");
define("_NOTE_TAKEOFF_NAME","Bemærk venligst navn og lokation på startstedet og landet");
define("_COMMENTS_FOR_THE_FLIGHT","Kommentarer til flyvningen");
define("_PHOTO","Billede");
define("_PHOTOS_GUIDELINES","Billeder skal være i jpg format og mindre end ");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","Klik her for at indsende flyvningen");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","Vil du indsende flere flyvninger samtidigt?");
define("_PRESS_HERE","Klik her");

define("_IS_PRIVATE","Vis ikke offentligt");
define("_MAKE_THIS_FLIGHT_PRIVATE","Vis ikke offentligt");
define("_INSERT_FLIGHT_AS_USER_ID","Indsæt flyvning som bruger ID");
define("_FLIGHT_IS_PRIVATE","Denne flyvning er privat");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","Ændre flyvedata");
define("_IGC_FILE_OF_THE_FLIGHT","Flyvningens IGC fil");
define("_DELETE_PHOTO","Slet");
define("_NEW_PHOTO","nyt billede");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","Klik her for at ændre flyvningens data");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","Ændringerne er gennemført");
define("_RETURN_TO_FLIGHT","Tilbage til flyvningen");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","Tilbage til flyvningen");
define("_READY_FOR_SUBMISSION","Klar til at indsende");
define("_OLC_MAP","Kort");
define("_OLC_BARO","Barograf");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","Pilot profil");
define("_back_to_flights","tilbage til flyvninger");
define("_pilot_stats","pilot statistik");
define("_edit_profile","ændre profil");
define("_flights_stats","statistik over flyvninger");
define("_View_Profile","Vis profil");

define("_Personal_Stuff","Personlige ting");
define("_First_Name"," Fornavn");
define("_Last_Name","Efternavn");
define("_Birthdate","Fødselsdag");
define("_dd_mm_yy","dd.mm.åå");
define("_Sign","Sign");
define("_Marital_Status","Ægteskabelig status");
define("_Occupation","Beskæftigelse");
define("_Web_Page","Hjemmeside");
define("_N_A","N/A");
define("_Other_Interests","Andre interesser");
define("_Photo","Billede");

define("_Flying_Stuff","Flyvemæssige ting");
define("_note_place_and_date","hvis relevant angiv sted, land og dato");
define("_Flying_Since","Har fløjet siden");
define("_Pilot_Licence","Pilot licens");
define("_Paragliding_training","Paragliding instruktion");
define("_Favorite_Location","Favorit sted");
define("_Usual_Location","Normalt sted");
define("_Best_Flying_Memory","Bedste flyveoplevelse");
define("_Worst_Flying_Memory","Værste flyveoplevelse");
define("_Personal_Distance_Record","Personlig distance rekord");
define("_Personal_Height_Record","Personlig højde rekord");
define("_Hours_Flown","Flyvetimer");
define("_Hours_Per_Year","Timer per år");

define("_Equipment_Stuff","Udstyrsmæssige ting");
define("_Glider","Glider");
define("_Harness","Seletøj");
define("_Reserve_chute","Reserveskærm");
define("_Camera","Kamera");
define("_Vario","Vario");
define("_GPS","GPS");
define("_Helmet","Hjelm");
define("_Camcorder","Videokamera");

define("_Manouveur_Stuff","Manøvremæssige ting");
define("_note_max_descent_rate","hvis relevant angiv maksimalt opnået synk");
define("_Spiral","Stejlspiral");
define("_Bline","B-stall");
define("_Full_Stall","Full stall");
define("_Other_Manouveurs_Acro","Andre acro manøvrer");
define("_Sat","Sat");
define("_Asymmetric_Spiral","Asymmetrisk spiral");
define("_Spin","Spin");

define("_General_Stuff","Generalle ting");
define("_Favorite_Singer","Favorit sanger");
define("_Favorite_Movie","Favorit film");
define("_Favorite_Internet_Site","Favorit<br>internet site");
define("_Favorite_Book","Favorit bog");
define("_Favorite_Actor","Favorit skuespiller");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","Indsende nyt billede eller ændre det gamle");
define("_Delete_Photo","Slet billede");
define("_Your_profile_has_been_updated","Din profil er blevet opdateret");
define("_Submit_Change_Data","Indsende - ændre oplysninger");

//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","tt:mm");

define("_Totals","Totaler");
define("_First_flight_logged","Første loggede flyvning");
define("_Last_flight_logged","Seneste loggede flyvning");
define("_Flying_period_covered","Flyve periode registreret");
define("_Total_Distance","Total distance");
define("_Total_OLC_Score","Total OLC points");
define("_Total_Hours_Flown","Total flyvetimer");
define("_Total_num_of_flights","Total antal flyvninger ");

define("_Personal_Bests","Personlig rekorder");
define("_Best_Open_Distance","Bedste fri distance");
define("_Best_FAI_Triangle","Bedste FAI trekant");
define("_Best_Free_Triangle","Bedste fri trekant");
define("_Longest_Flight","Længste flyvning");
define("_Best_OLC_score","Bedste OLC points");

define("_Absolute_Height_Record","Absolut højde rekord");
define("_Altitute_gain_Record","Højdevindingsrekord");
define("_Mean_values","Gennemsnitsværdier");
define("_Mean_distance_per_flight","Gennemsnitlig distance per flyvning");
define("_Mean_flights_per_Month","Gennemsnitlig flyvninger per måned");
define("_Mean_distance_per_Month","Gennemsnitlig distance per måned");
define("_Mean_duration_per_Month","Gennemsnitlig flyvetid per måned");
define("_Mean_duration_per_flight","Gennemsnitlig flyvetid per flyvning");
define("_Mean_flights_per_Year","Gennemsnitlig antal flyvninger per år");
define("_Mean_distance_per_Year","Gennemsnitlig distance per år");
define("_Mean_duration_per_Year","Gennemsnitlig flyvetid per år");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","Vis flyvninger nær dette punkt");
define("_Waypoint_Name","Waypoint navn");
define("_Navigate_with_Google_Earth","Navigér med Google Earth");
define("_See_it_in_Google_Maps","Vis i Google Maps");
define("_See_it_in_MapQuest","Vis i MapQuest");
define("_COORDINATES","Koordinater");
define("_FLIGHTS","Flyvninger");
define("_SITE_RECORD","Flyvested rekord");
define("_SITE_INFO","Flyvested information");
define("_SITE_REGION","Region");
define("_SITE_LINK","Link til mere information");
define("_SITE_DESCR","Flyvested/startsted beskrivelse");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","Vis flere detaljer");
define("_KML_file_made_by","KML fil lavet af");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","Registrer startsted");
define("_WAYPOINT_ADDED","Startstedet er registreret");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","Flyvested rekord<br>(fri distance)");
	
//--------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","Glider type");
function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'Paraglider',2=>'Flex wing FAI1',4=>'Rigid wing FAI5',8=>'Glider');
	foreach ($CONF_glider_types as $gId=>$gName) if (!$gliderCatList[$gId]) $gliderCatList[$gId]=$gName;
}
setGliderCats();

//--------------------------------------------
// user prefs  & units
//--------------------------------------------

define("_Your_settings_have_been_updated","Dine indstillinger er blevet opdateret");

define("_THEME","Tema");
define("_LANGUAGE","Sprog");
define("_VIEW_CATEGORY","Vis kategori");
define("_VIEW_COUNTRY","Vis land");
define("_UNITS_SYSTEM" ,"Enhedssystem");
define("_METRIC_SYSTEM","Metrisk (km,m)");
define("_IMPERIAL_SYSTEM","Imperial (miles,feet)");
define("_ITEMS_PER_PAGE","Ting/enheder per side");

define("_MI","mi");
define("_KM","km");
define("_FT","fod");
define("_M","m");
define("_MPH","mph");
define("_KM_PER_HR","km/t");
define("_FPM","fpm");
define("_M_PER_SEC","m/s");

//--------------------------------------------
// index page
//--------------------------------------------

define("_WORLD_WIDE","Hele verden");
define("_National_XC_Leagues_for","National XC liga for");
define("_Flights_per_Country","Flyvninger per land");
define("_Takeoffs_per_Country","Startsteder per land");
define("_INDEX_HEADER","Velkommen til Leonardo XC liga");
define("_INDEX_MESSAGE","Du kan bruge &quot;Hovedmenu&quot; til at navigere eller bruge de mest brugte muligheder herunder.");

//--------------------------------------------
// NEW 
//--------------------------------------------
define("_MENU_SUMMARY_PAGE","Oversigt");
define("_Display_ALL","Vis ALLE");
define("_Display_NONE","Vis INGEN");
define("_Reset_to_default_view","Reset til standard visning");
define("_No_Club","No Club");
define("_This_is_the_URL_of_this_page","Dette er URL'en til denne side");
define("_All_glider_types","Alle glider typer");

define("_MENU_SITES_GUIDE","Flyvested guide");
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

?>
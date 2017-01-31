<? if (0){?><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head><? }?><?php
/**************************************************************************/
/* Swedish language translation by                                        */
/* Jonas Svedberg 	(jonas_away@hotmail.com)	   	 					  */
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
	$monthList=array('Januari','Februari','Mars','April','Maj','Juni',
					'Juli','Augusti','September','Oktober','November','December');
	$monthListShort=array('JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC');
	$weekdaysList=array('Mon','Tue','Wed','Thu','Fri','Sat','Sun') ;
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","�ppen distans");
define("_FREE_TRIANGLE","Triangel");
define("_FAI_TRIANGLE","FAI-triangel");

define("_SUBMIT_FLIGHT_ERROR","Det blev fel vid inskickningen");

// list_pilots()
define("_NUM","#");
define("_PILOT","Pilot");
define("_NUMBER_OF_FLIGHTS","Antal flyg");
define("_BEST_DISTANCE","B�sta distans");
define("_MEAN_KM","medel # km per flyg");
define("_TOTAL_KM","Totalt flugna km");
define("_TOTAL_DURATION_OF_FLIGHTS","Total flygl�ngd");
define("_MEAN_DURATION","Medelflygl�ngd");
define("_TOTAL_OLC_KM","Total OLC-distans");
define("_TOTAL_OLC_SCORE","Total OLC-po�ng");
define("_BEST_OLC_SCORE","B�sta OLC-po�ng");
define("_From","fr�n");

// list_flights()
define("_DURATION_HOURS_MIN","L�ngd(t:m)");
define("_SHOW","Visa");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","Flyget kommer att aktiveras om 1-2 minuter. ");
define("_TRY_AGAIN","Var sn�ll och f�rs�k igen senare");

define("_TAKEOFF_LOCATION","Startplats");
define("_TAKEOFF_TIME","Starttid");
define("_LANDING_LOCATION","Landning");
define("_LANDING_TIME","Landningstid");
define("_OPEN_DISTANCE","F�gelv�g");
define("_MAX_DISTANCE","Max Distans");
define("_OLC_SCORE_TYPE","OLC-po�ngtyp");
define("_OLC_DISTANCE","OLC-distans");
define("_OLC_SCORING","OLC-po�ng");
define("_MAX_SPEED","Max fart");
define("_MAX_VARIO","Max stig");
define("_MEAN_SPEED","Medel fart");
define("_MIN_VARIO","Max sjunk");
define("_MAX_ALTITUDE","H�gsta h�jd (ASL)");
define("_TAKEOFF_ALTITUDE","Startplatsh�jd(ASL)");
define("_MIN_ALTITUDE","L�gsta h�jd (ASL)");
define("_ALTITUDE_GAIN","H�jdvinst");
define("_FLIGHT_FILE","Flygfil");
define("_COMMENTS","Kommentarer");
define("_RELEVANT_PAGE","Relevant URL");
define("_GLIDER","Farkost");
define("_PHOTOS","Bilder");
define("_MORE_INFO","Extrainfo");
define("_UPDATE_DATA","Uppdatera data");
define("_UPDATE_MAP","Uppdatera karta");
define("_UPDATE_3D_MAP","Uppdatera 3D karta");
define("_UPDATE_GRAPHS","Uppdatera grafer");
define("_UPDATE_SCORE","Updatera ber�kning");

define("_TAKEOFF_COORDS","Startplatskoordinater:");
define("_NO_KNOWN_LOCATIONS","Det finns inga k�nda platser!");
define("_FLYING_AREA_INFO","Flygomr�desinformation");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo XC");
define("_RETURN_TO_TOP","�terg� till h�gst upp");
// list flight
define("_PILOT_FLIGHTS","Pilotens flyg");

define("_DATE_SORT","Datum");
define("_PILOT_NAME","Pilotens namn");
define("_TAKEOFF","Startplats");
define("_DURATION","L�ngd(tid)");
define("_LINEAR_DISTANCE","F�gelv�g");
define("_OLC_KM","OLC km");
define("_OLC_SCORE","OLC-po�ng");
define("_DATE_ADDED","Senaste bidragen");

define("_SORTED_BY","Sortera med:");
define("_ALL_YEARS","Alla �r");
define("_SELECT_YEAR_MONTH","V�lj �r (och m�nad)");
define("_ALL","Alla");
define("_ALL_PILOTS","Visa alla piloter");
define("_ALL_TAKEOFFS","Visa alla  startplatser");
define("_ALL_THE_YEAR","Hela �ret");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","Du har inte angivit n�gon flygfil");
define("_NO_SUCH_FILE","File du angivit hittas inte p� servern");
define("_FILE_DOESNT_END_IN_IGC","Filen har inget .igc suffix");
define("_THIS_ISNT_A_VALID_IGC_FILE","Detta �r ingen giltig .igc fil");
define("_THERE_IS_SAME_DATE_FLIGHT","Det finns redan ett flyg med samma datum och tid");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","Om du vill byta ut flyget, skall du f�rst");
define("_DELETE_THE_OLD_ONE","ta bort det gamla");
define("_THERE_IS_SAME_FILENAME_FLIGHT","Det finns redan ett flyg med samma filnamn");
define("_CHANGE_THE_FILENAME","Om detta flyg �r ett annat, var god byt filnamn och prova igen");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","Ditt flyg har blivit inskickat");
define("_PRESS_HERE_TO_VIEW_IT","Tryck h�r f�r att se det");
define("_WILL_BE_ACTIVATED_SOON","(aktiveras om 1-2 minuter)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Skicka in flera-flyg");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","Bara IGC filer kommer att processas");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","Skicka in ZIP filen<br>som inneh�ller flygen");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","Tryck h�r f�r att skicka in flygen");

define("_FILE_DOESNT_END_IN_ZIP","Filen du skcikad in har inte  ett .zip suffix");
define("_ADDING_FILE","Skickar in fil");
define("_ADDED_SUCESSFULLY","Framg�ngsrikt inskickad");
define("_PROBLEM","Problem");
define("_TOTAL","Totalt ");
define("_IGC_FILES_PROCESSED","flyg har processats");
define("_IGC_FILES_SUBMITED","flyg har skickats in ");

// info
define("_DEVELOPMENT","Utveckling");
define("_ANDREADAKIS_MANOLIS","Andreadakis Manolis");
define("_PROJECT_URL","Projektsida");
define("_VERSION","Version");
define("_MAP_CREATION","Kartgenerering");
define("_PROJECT_INFO","Projektinformation");

// menu bar 
define("_MENU_MAIN_MENU","Huvudmeny");
define("_MENU_DATE","V�lj datum");
define("_MENU_COUNTRY","V�lj land");
define("_MENU_XCLEAGUE","Distansliga");
define("_MENU_ADMIN","Admin");

define("_MENU_COMPETITION_LEAGUE","Liga - alla kategorier");
define("_MENU_OLC","OLC");
define("_MENU_OPEN_DISTANCE","F�gelv�g");
define("_MENU_DURATION","tidsl�ngd");
define("_MENU_ALL_FLIGHTS","Visa alla flyg");
define("_MENU_FLIGHTS","Flyg");
define("_MENU_TAKEOFFS","Startplatser");
define("_MENU_FILTER","Filtrera");
define("_MENU_MY_FLIGHTS","Mina flyg");
define("_MENU_MY_PROFILE","Min profil");
define("_MENU_MY_STATS","Min statistik"); 
define("_MENU_MY_SETTINGS","Mina inst�llningar"); 
define("_MENU_SUBMIT_FLIGHT","S�nd in flyg");
define("_MENU_SUBMIT_FROM_ZIP","S�nd flyg fr�n zipfil");
define("_MENU_SHOW_PILOTS","Piloter");
define("_MENU_SHOW_LAST_ADDED","Visa senast ins�nt");
define("_FLIGHTS_STATS","Flygtatistik");

define("_SELECT_YEAR","V�lj �r");
define("_SELECT_MONTH","V�lj m�nad");
define("_ALL_COUNTRIES","Visa alla l�nder");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","ALLA TIDER");
define("_NUMBER_OF_FLIGHTS","Antal flyg");
define("_TOTAL_DISTANCE","Total distans");
define("_TOTAL_DURATION","Total tidsl�ngd");
define("_BEST_OPEN_DISTANCE","B�sta distans");
define("_TOTAL_OLC_DISTANCE","Total OLC distans");
define("_TOTAL_OLC_SCORE","Total OLC po�ng");
define("_BEST_OLC_SCORE","B�sta OLC po�ng");
define("_MEAN_DURATION","Medeltidsl�ngd");
define("_MEAN_DISTANCE","Medeldistans");
define("_PILOT_STATISTICS_SORT_BY","Piloter - Sortera efter");
define("_CATEGORY_FLIGHT_NUMBER","Category 'FastJoe' - Antal flyg");
define("_CATEGORY_TOTAL_DURATION","Category 'DURACELL' - Total tidsl�ngd f�r flyg");
define("_CATEGORY_OPEN_DISTANCE","Category '�ppen distans'");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","Det finns inga piloter att visa!");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","Flyget har raderats");
define("_RETURN","�terg�");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","Varning - Du h�ller p� att ta bort detta flyg");
define("_THE_DATE","Datum ");
define("_YES","Ja");
define("_NO","Nej");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","Ligaresultat");
define("_N_BEST_FLIGHTS"," b�sta flyg");
define("_OLC","OLC");
define("_OLC_TOTAL_SCORE","OLC totalpo�ng");
define("_KILOMETERS","Kilometer");
define("_TOTAL_ALTITUDE_GAIN","Total h�jdvinst");
define("_TOTAL_KM","Total km");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","�r");
define("_IS_NOT","�r inte");
define("_OR","eller");
define("_AND","och");
define("_FILTER_PAGE_TITLE","Filtrera flyg");
define("_RETURN_TO_FLIGHTS","�terg� till flyg");
define("_THE_FILTER_IS_ACTIVE","Detta filter �r aktivt");
define("_THE_FILTER_IS_INACTIVE","Detta filter �r inaktivt");
define("_SELECT_DATE","V�lj datum");
define("_SHOW_FLIGHTS","Visa flyg");
define("_ALL2","ALLA");
define("_WITH_YEAR","med �r");
define("_MONTH","M�nad");
define("_YEAR","�r");
define("_FROM","Fr�n");
define("_from","fr�n");
define("_TO","Till");
define("_SELECT_PILOT","V�lj pilot");
define("_THE_PILOT","Piloten");
define("_THE_TAKEOFF","Startplatsen");
define("_SELECT_TAKEOFF","V�lj Startplats");
define("_THE_COUNTRY","Landet");
define("_COUNTRY","Land");
define("_SELECT_COUNTRY","V�lj land");
define("_OTHER_FILTERS","Andra filter");
define("_LINEAR_DISTANCE_SHOULD_BE","F�gelv�gen borde vara");
define("_OLC_DISTANCE_SHOULD_BE","OLC-distansen borde vara");
define("_OLC_SCORE_SHOULD_BE","OLC-po�ngen borde vara");
define("_DURATION_SHOULD_BE","Tidsl�ngden borde vara");
define("_ACTIVATE_CHANGE_FILTER","Aktivera / byt FILTER");
define("_DEACTIVATE_FILTER","Avaktivera FILTER");
define("_HOURS","timmar");
define("_MINUTES","minuter");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","Skicka in flyg");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(bara IGC-filen beh�vs)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","Skicka in<br>IGC-filen f�r flyget");
define("_NOTE_TAKEOFF_NAME","Var god notera startplatsens namn, plats och land");
define("_COMMENTS_FOR_THE_FLIGHT","Kommentarer till flyget");
define("_PHOTO","Bild");
define("_PHOTOS_GUIDELINES","Bilder skall var i jpg format och mindre �n ");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","Tryck h�r f�r att skicka in flyget");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","Vill du skicka in m�nga flyg p� en g�ng?");
define("_PRESS_HERE","Klicka h�r");

define("_IS_PRIVATE","Visa inte publikt");
define("_MAKE_THIS_FLIGHT_PRIVATE","Visa inte publikt");
define("_INSERT_FLIGHT_AS_USER_ID","Stoppa in flyg some anv�ndar-ID");
define("_FLIGHT_IS_PRIVATE","Detta flyg �r privat");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","�ndra flygdata");
define("_IGC_FILE_OF_THE_FLIGHT","flygets IGC-fil");
define("_DELETE_PHOTO","Ta bort");
define("_NEW_PHOTO","ny bild");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","Tryck h�r f�r att �ndra flygets data");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","�ndringarna har applicerats");
define("_RETURN_TO_FLIGHT","�terg� till flyget");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","�terg� till flyget");
define("_READY_FOR_SUBMISSION","Klar att skicka in");
define("_OLC_MAP","Karta");
define("_OLC_BARO","Barograf");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","Pilotprofil");
define("_back_to_flights","�ter till flyg");
define("_pilot_stats","pilotstatistik");
define("_edit_profile","�ndra profile");
define("_flights_stats","flygstatistik");
define("_View_Profile","Se profil");

define("_Personal_Stuff","Personligt");
define("_First_Name"," F�rnamn");
define("_Last_Name","Efternamn");
define("_Birthdate","F�delsedag");
define("_dd_mm_yy","dd.mm.��");
define("_Sign","Sign");
define("_Marital_Status","Civilstatus");
define("_Occupation","Syssels�ttning");
define("_Web_Page","Webbsida");
define("_N_A","N/A");
define("_Other_Interests","Andra intressen");
define("_Photo","Bild");

define("_Flying_Stuff","Flygrelaterat");
define("_note_place_and_date","if applicable note place-country and date");
define("_Flying_Since","Flyger sedan");
define("_Pilot_Licence","Pilotlicens");
define("_Paragliding_training","Paragliding training");
define("_Favorite_Location","Favorit plats");
define("_Usual_Location","Vanligt flygst�ller");
define("_Best_Flying_Memory","B�sta flygminne");
define("_Worst_Flying_Memory","S�msta flygminner");
define("_Personal_Distance_Record","Personligt distansrekord");
define("_Personal_Height_Record","Personligt h�jdrekord");
define("_Hours_Flown","Flugna timmar");
define("_Hours_Per_Year","Timmar per �r ");

define("_Equipment_Stuff","Utrustningsrelaterat");
define("_Glider","Farkost");
define("_Harness","Sele");
define("_Reserve_chute","N�dsk�rm");
define("_Camera","Kamera");
define("_Vario","Variometer");
define("_GPS","GPS");
define("_Helmet","Hj�lm");
define("_Camcorder","Videokamera");

define("_Manouveur_Stuff","Man�vrer");
define("_note_max_descent_rate","om till�mpligt h�gsta uppn�dda sjunkhastighet");
define("_Spiral","Spiral");
define("_Bline","B-linor");
define("_Full_Stall","Fullstall");
define("_Other_Manouveurs_Acro","Andra acroman�vrar");
define("_Sat","SAT");
define("_Asymmetric_Spiral","Assymmetrisk spiral");
define("_Spin","Spinn");

define("_General_Stuff","Allm�nt");
define("_Favorite_Singer","Favorits�ngare");
define("_Favorite_Movie","Favoritfilm");
define("_Favorite_Internet_Site","Favoritsajt<br> p� Internet ");
define("_Favorite_Book","Favoritebok");
define("_Favorite_Actor","Favoritsk�despelare");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","Ladda upp ny bild (eller byt ut)");
define("_Delete_Photo","Ta bort bild");
define("_Your_profile_has_been_updated","Din profil har uppdaterats");
define("_Submit_Change_Data","Skicka in - �ndra data");

//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","tt:mm");

define("_Totals","Totalsummor");
define("_First_flight_logged","F�rsta loggade flyg");
define("_Last_flight_logged","Senast loggade flyg ");
define("_Flying_period_covered","flygperiod");
define("_Total_Distance","Totalsistans");
define("_Total_OLC_Score","Totad OLC-po�ng");
define("_Total_Hours_Flown","Totalt flugna timmar");
define("_Total_num_of_flights","Totalt # flyg ");

define("_Personal_Bests","Personliga rekord");
define("_Best_Open_Distance","B�sta �ppen distans");
define("_Best_FAI_Triangle","B�sta FAI-Triangel");
define("_Best_Free_Triangle","B�sta 'Fri'-Triangel");
define("_Longest_Flight","L�ngsta flyg");
define("_Best_OLC_score","B�sta OLC-po�ng");

define("_Absolute_Height_Record","Absolut h�jdrekord");
define("_Altitute_gain_Record","H�jdvinstrekord");
define("_Mean_values","Medelv�rden");
define("_Mean_distance_per_flight","Medeldistans per flyg");
define("_Mean_flights_per_Month","Medelantal flyg per m�nad");
define("_Mean_distance_per_Month","Medeldistans per m�nad");
define("_Mean_duration_per_Month","Medeltidsl�ngd per m�nad");
define("_Mean_duration_per_flight","Medeltidl�ngd per flyg");
define("_Mean_flights_per_Year","Medelantal flyg per �r");
define("_Mean_distance_per_Year","Medeldistans per �r");
define("_Mean_duration_per_Year","Medeltidsl�ngd per �r");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","Se flyg n�ra denna punkt");
define("_Waypoint_Name","v�ndpunktsnamn");
define("_Navigate_with_Google_Earth","Navigera med Google Earth");
define("_See_it_in_Google_Maps","Se det i Google Maps");
define("_See_it_in_MapQuest","Se det i MapQuest");
define("_COORDINATES","koordinater");
define("_FLIGHTS","Flyg");
define("_SITE_RECORD","Startplatsrekord");
define("_SITE_INFO","Startplatsinformation");
define("_SITE_REGION","Region");
define("_SITE_LINK","L�nk till mer information");
define("_SITE_DESCR","Startplatsbeskrivning");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","Se fler detaljer");
define("_KML_file_made_by","KML fil har skapats av");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","Registrera startplats");
define("_WAYPOINT_ADDED","Startplatsen har registrerats");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","startplatsrekord<br>(�ppen distans)");
	
//--------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","Farkosttyp");
function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'Flygsk�rm',2=>'H�ngglidare-FAI1',4=>'Stel vinge FAI5',8=>'Segelflygplan');
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

define("_Your_settings_have_been_updated","Dina inst�llningar har blivit uppdaterade");

define("_THEME","Tema");
define("_LANGUAGE","Spr�k");
define("_VIEW_CATEGORY","Se kategori");
define("_VIEW_COUNTRY","Se land");
define("_UNITS_SYSTEM" ,"Enhetssystem");
define("_METRIC_SYSTEM","Metriska (km,m)");
define("_IMPERIAL_SYSTEM","Imperial (miles,feet)");
define("_ITEMS_PER_PAGE","Saker per sida");

define("_MI","mi");
define("_KM","km");
define("_FT","fot");
define("_M","m");
define("_MPH","mph");
define("_KM_PER_HR","km/h");
define("_FPM","fot/min");
define("_M_PER_SEC","m/s");

//--------------------------------------------
// index page
//--------------------------------------------

define("_WORLD_WIDE","V�rldsomsp�nnande");
define("_National_XC_Leagues_for","Nationella distansligor f�r");
define("_Flights_per_Country","Flyg per land");
define("_Takeoffs_per_Country","Starter per land");
define("_INDEX_HEADER","V�lkommen till Leonardo Distansliga (XC)");
define("_INDEX_MESSAGE","Du kan anv�nda &quot;Main menu&quot; f�r att navigera eller anv�nd de vanligaste valen nedan.");


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
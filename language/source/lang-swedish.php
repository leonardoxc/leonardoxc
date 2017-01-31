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
?>
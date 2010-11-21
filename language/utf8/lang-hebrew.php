<? if (0){?><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><? }?><?php

/**************************************************************************/
/*  Translation to Hebrew by                                              */
/*  Dmitry N. Korogodin  (novanow@012.net.il)  NOVA ISRAEL TEL AVIV 2007  */
/**************************************************************************/


/************************************************************************/
/* Leonardo: Gliding XC Server	     	                              */
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
	$monthList=array('ינואר','פברואר','מרץ','אפריל','מאי','יוני',
					'יולי','אוגוסט','ספטמבר','אוקטובר','נובמבר','דצמבר');
	$monthListShort=array('ינו','פבר','מרס','אפר','מאי','יונ','יול','אוג','ספט','אוק','נוב','דצמ');
	$weekdaysList=array('ב','ג','ד','ה','ו','ש','א') ;
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","טיסה חופשית");
define("_FREE_TRIANGLE","משולש חופשי");
define("_FAI_TRIANGLE","FAIמשולש ");

define("_SUBMIT_FLIGHT_ERROR","הגישת טיסה לא הסתיימה בהצלחה ");

// list_pilots()
define("_NUM","#");
define("_PILOT","טייס");
define("_NUMBER_OF_FLIGHTS","מספר טיסות");
define("_BEST_DISTANCE","מיטב המרחק");
define("_MEAN_KM"," # ממוצעת קילומטרים לפי טיסה");
define("_TOTAL_KM","סיכום הטיסה ,קילומטר");
define("_TOTAL_DURATION_OF_FLIGHTS","סיכום של משך טיסות");
define("_MEAN_DURATION"," ממוצע של משך טיסות");
define("_TOTAL_OLC_KM","OLC סיכום מרחק");
define("_TOTAL_OLC_SCORE","OLC סיכום נקודות");
define("_BEST_OLC_SCORE","OLC הנקודות מיטב");
define("_From","מאת");

// list_flights()
define("_DURATION_HOURS_MIN","משך (ש:ד)");
define("_SHOW","להציג");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","טיסה תופעל בדקות הקרובות");
define("_TRY_AGAIN","נא לנסות מאוחר יותר");

define("_TAKEOFF_LOCATION","המראה");
define("_TAKEOFF_TIME","זמן המראה");
define("_LANDING_LOCATION","נחיתה");
define("_LANDING_TIME","נחיתה זמן");
define("_OPEN_DISTANCE","מרחק קווי");
define("_MAX_DISTANCE","מרב המרחק");
define("_OLC_SCORE_TYPE","OLCסוג של נקודות ");
define("_OLC_DISTANCE","OLC מרחק");
define("_OLC_SCORING","OLC נקודות");
define("_MAX_SPEED", "מרב המהירות");
define("_MAX_VARIO","מרב הוריו");
define("_MEAN_SPEED","מהירות ממוצעת");
define("_MIN_VARIO","מזער הוריו");
define("_MAX_ALTITUDE","מרב הגובה מעל פני הים");
define("_TAKEOFF_ALTITUDE","גובה המראה מעל פני הים");
define("_MIN_ALTITUDE","מזער גובה מעל פני הים");
define("_ALTITUDE_GAIN","גובה הרכוש");
define("_FLIGHT_FILE","קובץ טיסה");
define("_COMMENTS","תגובות");
define("_RELEVANT_PAGE","רלוונטי URL דף ");
define("_GLIDER","דאון");
define("_PHOTOS","תמונות");
define("_MORE_INFO","מידע נוסף");
define("_UPDATE_DATA","עדכון נתונים");
define("_UPDATE_MAP","עדכון מפה");
define("_UPDATE_3D_MAP","עדכון מפה תלת-ממדית");
define("_UPDATE_GRAPHS","עדכון תרשים");
define("_UPDATE_SCORE","עדכון נקודות");

define("_TAKEOFF_COORDS",": קואורדינטות המראה");
define("_NO_KNOWN_LOCATIONS","המקום אינו מוכר!");
define("_FLYING_AREA_INFO","מידע על אזור טיסה");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","XCלאונרדו ");
define("_RETURN_TO_TOP","לחזור למעלה");
// list flight
define("_PILOT_FLIGHTS","טיסות של טייס");

define("_DATE_SORT","תאריך");
define("_PILOT_NAME","שם טייס");
define("_TAKEOFF","המראה");
define("_DURATION","משך זמן");
define("_LINEAR_DISTANCE","מרחק פתוח");
define("_OLC_KM"," קילומטריםOLC");
define("_OLC_SCORE","OLC נקודות");
define("_DATE_ADDED","הגשה האחרונה");

define("_SORTED_BY",":נבחר לפי");
define("_ALL_YEARS","כל השנים");
define("_SELECT_YEAR_MONTH","נא לבחור שנה (גם חודש)");
define("_ALL","הכול");
define("_ALL_PILOTS","להציג כול הטייסים");
define("_ALL_TAKEOFFS","להציג כול ההמראות");
define("_ALL_THE_YEAR","כול השנים");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","הקובצ טיסה אינו סופק");
define("_NO_SUCH_FILE","קובץ הסופק אינו נמצא בשרת");
define("_FILE_DOESNT_END_IN_IGC",".igc הסיומת של קובץ הסופק אינו מתאימה ולא ");
define("_THIS_ISNT_A_VALID_IGC_FILE","אינו מתאים .igcהקובץ ");
define("_THERE_IS_SAME_DATE_FLIGHT","הטיסה עם אותו תאריך וזמן כבר נמצת");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","במקרה החלפת קובץ, קודם אנא");
define("_DELETE_THE_OLD_ONE","למחוק הישן יותר");
define("_THERE_IS_SAME_FILENAME_FLIGHT","הטיסה עם אותו שם כבר נמצת");
define("_CHANGE_THE_FILENAME","במקרה הטיסה הזאת היא טיסה אחרת אנא לשנות את השם ולנסות שוב!");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","הטיסה היתה הוגשה בהצלחה!");
define("_PRESS_HERE_TO_VIEW_IT","נא להקיש כאן לצפיה");
define("_WILL_BE_ACTIVATED_SOON","(תהיה מופעלת בתוך שתי דקות)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","להגיש מספר טיסות");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","IGCיש אפשרות להגיש רק קבציי ");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS"," שהכיל טיסות<br>ZIP להגיש קובץ");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","נא להקיש כאן להגשת טיסות");

define("_FILE_DOESNT_END_IN_ZIP",".zipהסיומת של קובץ הסופק אינו מתאימה ולא ");
define("_ADDING_FILE","הגשת קובץ");
define("_ADDED_SUCESSFULLY","הוגש בהצלחה");
define("_PROBLEM","בעיה");
define("_TOTAL","סיכום");
define("_IGC_FILES_PROCESSED","טיסות היו מעובדות");
define("_IGC_FILES_SUBMITED"," טיסות היו הוגשות");

// info
define("_DEVELOPMENT","פיתוח");
define("_ANDREADAKIS_MANOLIS","מנוליס אנדראדקיס");
define("_PROJECT_URL","דף אינטרנט מוקדש לפרויקט");
define("_VERSION","גירסה");
define("_MAP_CREATION","פיתוח מפה");
define("_PROJECT_INFO","מידע על פרויקט");

// menu bar 
define("_MENU_MAIN_MENU","תפריט ראשית");
define("_MENU_DATE","נא לבחור תאריך");
define("_MENU_COUNTRY","לבחור ארץ");
define("_MENU_XCLEAGUE","XCאגודה ");
define("_MENU_ADMIN","מנהל");

define("_MENU_COMPETITION_LEAGUE","אגודה  כול הסוגים");
define("_MENU_OLC","OLC");
define("_MENU_OPEN_DISTANCE","מרחק פתוח");
define("_MENU_DURATION","משך זמן");
define("_MENU_ALL_FLIGHTS","להציג כול הטיסות");
define("_MENU_FLIGHTS","טיסות");
define("_MENU_TAKEOFFS","המראות");
define("_MENU_FILTER","מסנן");
define("_MENU_MY_FLIGHTS","טיסות שלי");
define("_MENU_MY_PROFILE","פרופיל שלי");
define("_MENU_MY_STATS","סטטיסטיקה שלי"); 
define("_MENU_MY_SETTINGS","הגדרות שלי"); 
define("_MENU_SUBMIT_FLIGHT","להגיש טיסה ");
define("_MENU_SUBMIT_FROM_ZIP","ZIP להגיש טיסה מקובץ ");
define("_MENU_SHOW_PILOTS","טייסים");
define("_MENU_SHOW_LAST_ADDED"," להציג את טיסות הוגשות באחרונה ");
define("_FLIGHTS_STATS","סטטיסטיקה טיסות");

define("_SELECT_YEAR","לבחור שנה");
define("_SELECT_MONTH","לבחור חודש");
define("_ALL_COUNTRIES","להציג כול הארצות");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","במשך כל הזמן");
define("_NUMBER_OF_FLIGHTS","מספר טיסות");
define("_TOTAL_DISTANCE","סיכום מרחק");
define("_TOTAL_DURATION","סיכום משך זמן");
define("_BEST_OPEN_DISTANCE","מיטב המרחק");
define("_TOTAL_OLC_DISTANCE","OLC סיכום מרחק");
define("_TOTAL_OLC_SCORE","OLCסיכום נקודות ");
define("_BEST_OLC_SCORE","OLCמיטב הנקודות ");
define("_MEAN_DURATION","ממוצעת משך זמן");
define("_MEAN_DISTANCE","ממוצעת מרחק");
define("_PILOT_STATISTICS_SORT_BY","טייסים  בחירב לפי");
define("_CATEGORY_FLIGHT_NUMBER","מספר טיסות 'FastJoe'-סוג ");
define("_CATEGORY_TOTAL_DURATION","משך הזמן סיכום'DURACELL' סוג -");
define("_CATEGORY_OPEN_DISTANCE","'Open Distance'סוג -");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","אין טייסים להצגה!");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","הטיסה נמחקה");
define("_RETURN","לחזור חזרה");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED"," זהירות! האם ברצונך למחוק את הטיסה? ");
define("_THE_DATE","תאריך");
define("_YES","כן");
define("_NO","לא");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","התוצאות של אגודה");
define("_N_BEST_FLIGHTS","מיטב הטיסות");
define("_OLC","OLC");
define("_OLC_TOTAL_SCORE","OLCסיקום הנקודות ");
define("_KILOMETERS","קילומטרים");
define("_TOTAL_ALTITUDE_GAIN","סיכום הגובה מורוח");
define("_TOTAL_KM","סיכום הקילומטרים");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","נמצא");
define("_IS_NOT","אינו נמצא");
define("_OR","או");
define("_AND","גם");
define("_FILTER_PAGE_TITLE","נא לסנן טיסות");
define("_RETURN_TO_FLIGHTS","נא לשוב לטיסות");
define("_THE_FILTER_IS_ACTIVE","המסנן מופעל");
define("_THE_FILTER_IS_INACTIVE","המסנן מבוטל");
define("_SELECT_DATE","נא לבחור תאריך");
define("_SHOW_FLIGHTS","נא להציג טיסות");
define("_ALL2","הכול");
define("_WITH_YEAR","בשנה");
define("_MONTH","חודש");
define("_YEAR","שנה");
define("_FROM","מאת");
define("_from","מאת");
define("_TO","אל");
define("_SELECT_PILOT","נא לבחור טייס");
define("_THE_PILOT","הטייס");
define("_THE_TAKEOFF","ההמראה");
define("_SELECT_TAKEOFF","נא לבחור את ההמראה");
define("_THE_COUNTRY","הארץ");
define("_COUNTRY","ארץ");
define("_SELECT_COUNTRY","נא לבחור את הארץ");
define("_OTHER_FILTERS","מסננים אחרים");
define("_LINEAR_DISTANCE_SHOULD_BE","מרחק קווי הצפוי");
define("_OLC_DISTANCE_SHOULD_BE"," הצפויOLCמרחק ");
define("_OLC_SCORE_SHOULD_BE","צפויות OLCנקודות ");
define("_DURATION_SHOULD_BE","משך זמן צפוי");
define("_ACTIVATE_CHANGE_FILTER","להפעיל\לשנות מסנן");
define("_DEACTIVATE_FILTER","לבטל מסנן");
define("_HOURS","שעות");
define("_MINUTES","דקות");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","להגיש טיסה");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(IGC דרוש רק קובץ)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","<br>IGC להגיש קובץ טיסה");
define("_NOTE_TAKEOFF_NAME","אנא לציין שם מקום המראה וארץ");
define("_COMMENTS_FOR_THE_FLIGHT","תגובות טיסה");
define("_PHOTO","תמונה");
define("_PHOTOS_GUIDELINES","ובגודל לא יותר מ jpg תמונות חייבות להיות בקובץ מסוג ");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","להגדשת טיסה אנא להקיש כאן");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","האם ברצונך להגיש יותר מהטיסה אחת בו-זמני?");
define("_PRESS_HERE","אנא להקיש כאן");

define("_IS_PRIVATE","לא להציג לציבור");
define("_MAKE_THIS_FLIGHT_PRIVATE","לא להציג לציבור");
define("_INSERT_FLIGHT_AS_USER_ID","לשבץ את הטיסה כמו זהות משתמש");
define("_FLIGHT_IS_PRIVATE","הטיסה זאת היא טיסה פרטית");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","לשנות נתוני טיסה");
define("_IGC_FILE_OF_THE_FLIGHT","IGC קובץ טיסה ");
define("_DELETE_PHOTO","למחוק");
define("_NEW_PHOTO","תמונה חדשה");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","לשינוי נתוני טיסה נא להקיש כאן");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","השינוים נקלטו בהצלחה");
define("_RETURN_TO_FLIGHT","לחזור לטיסה");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","לחזור לטיסה");
define("_READY_FOR_SUBMISSION","מוכן להגשה");
define("_SUBMIT_TO_OLC","OLCלהגיש ל");
define("_OLC_MAP","מפה");
define("_OLC_BARO","רשם-לחץ");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","פרופיל טייס");
define("_back_to_flights","נא לחזור לטיסות");
define("_pilot_stats","סטטיסטיקת טייס");
define("_edit_profile","לערוך פרופיל");
define("_flights_stats","סטטיסטיקת טיסות");
define("_View_Profile","להציג פרופיל");

define("_Personal_Stuff","מידע פרטי");
define("_First_Name","שם פרטי");
define("_Last_Name","שם משפחה");
define("_Birthdate","תאריך לידה ");
define("_dd_mm_yy","dd.mm.yy");
define("_Sign","חתימה");
define("_Marital_Status","מצב משפחתי");
define("_Occupation","מקצוע");
define("_Web_Page","דף הבית");
define("_N_A","לא זמין");
define("_Other_Interests","תחביבים");
define("_Photo","תמונה");

define("_Flying_Stuff","מידע טיסתי");
define("_note_place_and_date","אם רלוונטי נא לציין את התאריך ומקום המראה");
define("_Flying_Since","בטיסה מאז");
define("_Pilot_Licence","רשיון טייס");
define("_Paragliding_training","למודים הנוכחים");
define("_Favorite_Location","אתר החביב");
define("_Usual_Location","אתר מקובל");
define("_Best_Flying_Memory","מיטב הזכרונות טיס");
define("_Worst_Flying_Memory"," הזכרונות טיס הקריטיים");
define("_Personal_Distance_Record","שיא מרחק פרטי");
define("_Personal_Height_Record","שיא גובה פרטי");
define("_Hours_Flown","שאות באוויר");
define("_Hours_Per_Year","שאות טיס בשנה");

define("_Equipment_Stuff","מידע ציוד");
define("_Glider","דאון");
define("_Harness","ריתמה");
define("_Reserve_chute","מצנח רזרבי");
define("_Camera","מצלמה");
define("_Vario","וריו");
define("_GPS","מערכת מיקום גלובלית");
define("_Helmet","קסדה");
define("_Camcorder","מצלמת וידאו");

define("_Manouveur_Stuff","תמרון מידע");
define("_note_max_descent_rate","אם אפשרי נא לציין מהרות ירידה ");
define("_Spiral","ספירלה ");
define("_Bline","Bline");
define("_Full_Stall","הזדקרות מלאה");
define("_Other_Manouveurs_Acro","אחרים Acroהתרמונים ");
define("_Sat","SAT");
define("_Asymmetric_Spiral","ספירלה אסימטרית");
define("_Spin","ספירלה נגטיבית");

define("_General_Stuff","מידע כללי");
define("_Favorite_Singer","זמר החביב");
define("_Favorite_Movie","קולנוע החביב");
define("_Favorite_Internet_Site"," החביב<br>אתר אינטרנט ");
define("_Favorite_Book","ספר החביב");
define("_Favorite_Actor","שחקן החביב");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","להעלות תמונה חדשה או להחליף  את הקודמת");
define("_Delete_Photo","למחוק תמונה");
define("_Your_profile_has_been_updated","הפרופיל שלך היה מעודכן בהצלחה");
define("_Submit_Change_Data","להגיש  לשנות את הנתון");


//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","hh:mm");

define("_Totals","סיכום");
define("_First_flight_logged","טיסה ראשונה הרשומה");
define("_Last_flight_logged","טיסה אחרונה הרשומה");
define("_Flying_period_covered","סקר התקופה טים");
define("_Total_Distance","סיקום המרחק");
define("_Total_OLC_Score","OLCסיכום הנקודות ");
define("_Total_Hours_Flown","סיכום שאות טיס");
define("_Total_num_of_flights","סיכום # טיסות ");

define("_Personal_Bests","שיאים אישיים");
define("_Best_Open_Distance","מיטב המרחק פתוח");
define("_Best_FAI_Triangle","FAIמיטב המשולש ");
define("_Best_Free_Triangle","מיטב המשולש חופשי");
define("_Longest_Flight","מיטב המשך זמן טיסה");
define("_Best_OLC_score","OLCמיטב הנקודות ");

define("_Absolute_Height_Record","שיא גובה מוחלט");
define("_Altitute_gain_Record","שיא גובה הושג");
define("_Mean_values","ממוצע ערך");
define("_Mean_distance_per_flight","ממוצע המרחק לפי טיסה");
define("_Mean_flights_per_Month","ממוצע המספר טיסות לפי חודש");
define("_Mean_distance_per_Month","ממוצע המרחק לפי חודש");
define("_Mean_duration_per_Month","ממוצע המשך זמן טיסה לפי חודש");
define("_Mean_duration_per_flight","ממוצע המשך זמן טיסה לפי שנה");
define("_Mean_flights_per_Year","ממוצע המספר טיסות לפי שנה");
define("_Mean_distance_per_Year","ממוצע המרחק לפי שנה");
define("_Mean_duration_per_Year","ממוצע המשך זמן טיסה לפי שנה");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","להציג טיסות קרובות לנקודה זאת");
define("_Waypoint_Name","שם נקודת התייחסות");
define("_Navigate_with_Google_Earth","Google Earthלנווט ב");
define("_See_it_in_Google_Maps","Google Mapsלצפות ב");
define("_See_it_in_MapQuest","MapQuestלצפות ב");
define("_COORDINATES","קואורדינטות");
define("_FLIGHTS","טיסות");
define("_SITE_RECORD","שיאים האתר");
define("_SITE_INFO","מידע אתר");
define("_SITE_REGION","אזור");
define("_SITE_LINK","קיצור דרך למידע נוסף");
define("_SITE_DESCR","מקום המראה/תיאור אתר");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","נא לצפות לפרטים נוספים");
define("_KML_file_made_by"," עשוי על ידיKML הקובץ ");

//--------------------------------------------
// add_waypoint.php WAY POINT IS NOT THE SAME THING THAT TAKEOFF!!!
//--------------------------------------------
define("_ADD_WAYPOINT","להוסיף את המקום המראה");
define("_WAYPOINT_ADDED","ההמראה רשומה בהצלחה");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","השיא של המקום המראה <br>(open distance)");
	
//--------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","סוג של דאון");
function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'מצנח רחיפה',2=>'כנף מתכופפת  FAI1',4=>'כנף קשה FAI5',8=>'גלשן');
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

define("_Your_settings_have_been_updated","ההגדרות שלך היו מעודכנות בהצלחה! ");

define("_THEME","נושא");
define("_LANGUAGE","שפה");
define("_VIEW_CATEGORY","להציג סוג");
define("_VIEW_COUNTRY","להציג ארץ");
define("_UNITS_SYSTEM" ,"יחידות מדידה");
define("_METRIC_SYSTEM","מטרי (קילומטר, מטר");
define("_IMPERIAL_SYSTEM","אימפריאלי (מילים,רגל) ");
define("_ITEMS_PER_PAGE","פריטים בעמוד");

define("_MI","מל");
define("_KM","קמ");
define("_FT","פט");
define("_M","מ");
define("_MPH","מל\ש");
define("_KM_PER_HR","קמ\ש");
define("_FPM","פט\מ");
define("_M_PER_SEC","מ\שניה");

//--------------------------------------------
// index page
//--------------------------------------------

define("_WORLD_WIDE","חובק עולם");
define("_National_XC_Leagues_for","XCהאגודות לאומיות ");
define("_Flights_per_Country","טיסות לכול ארץ");
define("_Takeoffs_per_Country","המראות לכול ארץ");
define("_INDEX_HEADER","XCברוכים הבאים לאגודה לאונרדו ");
define("_INDEX_MESSAGE"," כדי לנווט או לבחור מלמטה&quot;Main menu&quot;נא להשתמש ב
");

//--------------------------------------------
// NEW 
//--------------------------------------------
define("_MENU_SUMMARY_PAGE","ראשון (סיכום) דף");
define("_Display_ALL","להציג הכול");
define("_Display_NONE","לא להציג שום דבר");
define("_Reset_to_default_view","להחזיר תצוגה ברירת מחדל");
define("_No_Club","אין מועדון");
define("_This_is_the_URL_of_this_page","זאת הכתובת של דף הזה");
define("_All_glider_types","כול סוגים של דאונים");

define("_MENU_SITES_GUIDE","מדריך למקומות המראה");
define("_Site_Guide","מדריך לאתר");

define("_Search_Options","הגדרות חיפוש");
define("_Below_is_the_list_of_selected_sites","לפניך הרשימה של אתרים נבחרים");
define("_Clear_this_list","למחוק רשימה");
define("_See_the_selected_sites_in_Google_Earth"," Google Earth אנא להצפיע על אתרים הנבחרים ב ");
define("_Available_Takeoffs","המראות זמינות");
define("_Search_site_by_name","לחפש אתר לפי השם");
define("_give_at_least_2_letters","בא לציין לפחות שתי אותיות");
define("_takeoff_move_instructions_1","
יש להעביר כול הטיסות לרשימה בצד ימין באמצעות הקשה את << או רק טיסה נבחרת באמצעות <");
define("_Takeoff_Details","פרטים המראות");


define("_Takeoff_Info","מידע המראות");
define("_XC_Info","XCמידע ");
define("_Flight_Info","מידע טיסה");

define("_MENU_LOGOUT","יציא מערכת");
define("_MENU_LOGIN","כניסה למערכת");
define("_MENU_REGISTER","פתיחת חשבון");


define("_Africa","אפריקה");
define("_Europe","אירופה");
define("_Asia","אסיה");
define("_Australia","אוסטרליה");
define("_North_Central_America","צפון  מרכז אמריקה");
define("_South_America","דרום אמריקה");

define("_Recent","לאחרונה");


define("_Unknown_takeoff","מקום המראה אינו מוכר!");
define("_Display_on_Google_Earth","Google Earthלהציג ב");
define("_Use_Man_s_Module","Man's Moduleלהשתמש ב");
define("_Line_Color","צבע קו");
define("_Line_width","רוחב קו");
define("_unknown_takeoff_tooltip_1","לטיסה זאת יש מקום המראה אינו מוכר");
define("_unknown_takeoff_tooltip_2","אם ידוע לך המקום המראה של טיסה הזו נא למלא פרטים!");
define("_EDIT_WAYPOINT","לערוך מידע המראה");
define("_DELETE_WAYPOINT","למחוק המראה");
define("_SUBMISION_DATE","תאריך הגשה"); // the date a flight was submited to leonardo
define("_TIMES_VIEWED"," כמות צפיות על הטיסה"); // the times that this flight havs been viewed


define("_takeoff_add_help_1"," OKאם ידוע לך מידע המראה, נא למלא את הפרטים. אם לא, נא לסגור את החולון על ידי הקשה ב");
define("_takeoff_add_help_2"," אין צורך להגיש אותה עוד פעם. נא לסגור את החלון'טיסה אינה מוכרת'אם המראה של טיסתך נמצת ברשימה מעל ");
define("_takeoff_add_help_3"," אם המראה של טיסתך נמצת ברשימה למתה נא להקיש עליב למילוא אוטומטי  .");
define("_Takeoff_Name","שם מקום המראה");
define("_In_Local_Language","בשפה מקומית");
define("_In_English","באנגלית");

// New on 2007/02/20 - login screen
define("_ENTER_PASSWORD","נא להקיש את השם משתמש וסיסמה עבור כינסה למערכת");
define("_SEND_PASSWORD","שכחתה את סיסמתך?");
define("_ERROR_LOGIN","הסיסמה אינה נכונה ושם משתמש או סיסמה אינם מופעלים");
define("_AUTO_LOGIN","לאפשר כניסה אוטומטית כול ביקור שלי");
define("_USERNAME","שם משתמש");
define("_PASSWORD","סיסמה");
define("_PROBLEMS_HELP","אם נתקלת בבעיה נא להתקשר למנהל מערכת");

define("_LOGIN_TRY_AGAIN","לניסיון החוזר %sכאן%s נא להקיש ");
define("_LOGIN_RETURN"," לחזרה לאינדקס %sכאן%s נא להקיש ");
// end 2007/02/20

define("_Category","סוג");
define("_MEMBER_OF","חבר ב- ");
define("_MemberID","זהות חבר ");
define("_EnterID","נא להכניס זהות");
define("_Clubs_Leagues","מועדונים / אגודות ");
define("_Pilot_Statistics","סטטיסטיקה של טייס");
define("_National_Rankings","דירוג לאומי ");

// new on 2007/03/08
define("_Select_Club","נא לבחור את המועדון");
define("_Close_window","נא לסגור את החלון");
define("_EnterID","נא להכניס זהות");
define("_Club","המועדון");
define("_Sponsor"," נותן חסות");


// new on 2007/03/13
define('_Go_To_Current_Month','להניע לחודש הנוכחי');
define('_Today_is','התאריך של היום הוא');
define('_Wk','שבוע');
define('_Click_to_scroll_to_previous_month',' לעברה לחודש שעבר נא להקיש כאן.לעברה אוטומטית נא להחזיק את המקש עכבר ');
define('_Click_to_scroll_to_next_month','עברה לחודש הבא נא להקיש כאן.לעברה אוטומטית נא להחזיק את המקש עכבר ');
define('_Click_to_select_a_month','נא להקיש לבחירה חודש נוכחי');
define('_Click_to_select_a_year','.נא להקיש לבחירה שנה נוכחית');
define('_Select_date_as_date.','תאריך [date] נא לבחור '); // do not replace [date], it will be replaced by date.
// end 2007/03/13

//--------------------------------------------------------
//--------------------------------------------------------
// Missing defines , autoreplaced values from 'english' 
//--------------------------------------------------------
define("_SEASON","Season"); 
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
define("_MENU_SUMMARY_PAGE","First (Summary) Page"); 
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
define("_Requirements","Requeriments"); 
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
define("_New_comment_email_body","You have a new comment on $s<BR><BR><a href="%s">Click here to read all comments</a><hr>%s"); 

?>
<? if (0) { ?><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><? } ?><?

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
	$monthList=array('Ιανουάριος','Φεβρουάριος','Μαρτιος','Απρίλιος','Μαϊος','Ιούνιος',
				'Ιούλιος','Αύγουστος','Σεπτέμβριος','Οκτώβριος','Νοέμβριος','Δεκέμβριος');
	$monthListShort=array('ΙΑΝ','ΦΕΒ','ΜΑΡ','ΑΠΡ','ΜΑΙ','ΙΟΥΝ','ΙΟΥΛ','ΑΥΓ','ΣΕΠ','ΟΚΤ','ΝΟΕ','ΔΕΚ');
	$weekdaysList=array('Δευ','Τρι','Τετ','Πεμ','Παρ','Σαβ','Κυρ') ;
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","Ελεύθερη πτήση");
define("_FREE_TRIANGLE","Τρίγωνο ελεύθερο");
define("_FAI_TRIANGLE","Τρίγωνο FAI");

define("_SUBMIT_FLIGHT_ERROR","Πρόβλημα κατα την υποβολή της πτήσης");

// list_pilots()
define("_NUM","A/A");
define("_PILOT","Πιλότος");
define("_NUMBER_OF_FLIGHTS","Αριθμός πτήσεων");
define("_BEST_DISTANCE","Καλύτερη απόσταση");
define("_MEAN_KM","Μέσος # km ανά πτήση");
define("_TOTAL_KM","Συνολικά km πτήσεων");
define("_TOTAL_DURATION_OF_FLIGHTS","Συνολική Διάρκεια πτήσεων");
define("_MEAN_DURATION","Μέση διάρκεια πτήσης");
define("_TOTAL_OLC_KM","Συνολική XC απόσταση");
define("_TOTAL_OLC_SCORE","Συνολικοί XC βαθμοί");
define("_BEST_OLC_SCORE","Καλύτερος XC βαθμός");
define("_From","από");

// list_flights()
define("_DURATION_HOURS_MIN","Διάρκεια (ωω:λλ)");
define("_SHOW","Εμφάνιση");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","Η πτήση θα ενεργοποιηθεί σε 1-2 λεπτά. ");
define("_TRY_AGAIN","Ξαναδοκιμάστε σε λίγο");
define("_SEASON","Χρονιά");
define("_TAKEOFF_LOCATION","Απογείωση");
define("_TAKEOFF_TIME","Ώρα απογείωσης");
define("_LANDING_LOCATION","Προσγείωση");
define("_LANDING_TIME","Ώρα προσγείωσης");
define("_OPEN_DISTANCE","Απόσταση σε ευθεία");
// define("_DURATION","Διάρκεια");
define("_MAX_DISTANCE","Μέγιστη Απόσταση");
define("_OLC_SCORE_TYPE","Τύπος XC βαθμολογίας");
define("_OLC_DISTANCE","Απόσταση XC");
define("_OLC_SCORING","Βαθμολογία XC");
define("_MAX_SPEED","Μέγιστη ταχύτητα");
define("_MAX_VARIO","Μέγιστο ανοδικό");
define("_MEAN_SPEED","Μέση ταχύτητα");
define("_MIN_VARIO","Μέγιστο καθοδικό");
define("_MAX_ALTITUDE","Μέγιστo ύψος");
define("_TAKEOFF_ALTITUDE","Ύψος απογείωσης");
define("_MIN_ALTITUDE","Ελάχιστο ύψος");
define("_ALTITUDE_GAIN","Απόκτηση ύψους");
define("_FLIGHT_FILE","Αρχείο πτήσης");
define("_COMMENTS","Σχόλια");
define("_RELEVANT_PAGE","Σχετική σελίδα");
define("_GLIDER","Αλεξίπτωτο");
define("_PHOTOS","Φωτογραφίες");
define("_MORE_INFO","Πρόσθετα");
define("_UPDATE_DATA","Ανανέωση στοιχείων");
define("_UPDATE_MAP","Ανανέωση χάρτη");
define("_UPDATE_3D_MAP","Ανανέωση 3D χάρτη");
define("_UPDATE_GRAPHS","Ανανέωση γραφημάτων");
define("_UPDATE_SCORE","Ανανέωση βαθμολογίας");

define("_TAKEOFF_COORDS","Συντεταγμένες απογείωσης:");
define("_NO_KNOWN_LOCATIONS","Δεν υπάρχουν προς το παρόν γνωστές τοποθεσίες!");
define("_FLYING_AREA_INFO","Απογειώσεις περιοχής");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo XC");
define("_RETURN_TO_TOP","Επιστροφή στην αρχή");
// list flight
define("_PILOT_FLIGHTS","Πτήσεις πιλότου");

define("_DATE_SORT","Ημερομηνία");
define("_PILOT_NAME","Ονομα Πιλότου");
define("_TAKEOFF","Απογείωση");
define("_DURATION","Διάρκεια");
define("_LINEAR_DISTANCE","Ανοιχτή απόσταση");
define("_OLC_KM","XC χιλ.");
define("_OLC_SCORE","XC βαθμοί");
define("_DATE_ADDED","Πρόσφατες υποβολές");

define("_SORTED_BY","Ταξινόμηση:");
define("_ALL_YEARS","Όλες οι χρονιές");
define("_SELECT_YEAR_MONTH","Επιλέξτε χρόνο ή και μήνα");
define("_ALL","ΟΛΑ");
define("_ALL_PILOTS","Όλοι οι πιλότοι");
define("_ALL_TAKEOFFS","Όλες οι τοποθεσίες");
define("_ALL_THE_YEAR","Όλο το έτος");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","Δεν δώσατε αρχείο πτήσης");
define("_NO_SUCH_FILE","Το αρχείο σας δεν μπορει να βρεθεί (προβλημα του server)");
define("_FILE_DOESNT_END_IN_IGC","Το αρχείο δεν έχει κατάληξη .igc");
define("_THIS_ISNT_A_VALID_IGC_FILE","Το αρχείο igc δεν είναι έγκυρο");
define("_THERE_IS_SAME_DATE_FLIGHT","Υπάρχει ήδη μια πτήση σας με αυτή την ημερομηνία και ώρα");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","Αν θέλετε να την αντικαταστήσετε πρέπει πρώτα να");
define("_DELETE_THE_OLD_ONE","σβήσετε την παλιά");
define("_THERE_IS_SAME_FILENAME_FLIGHT","Υπάρχει ήδη μια πτήση σας με to ίδιο όνομα αρχείου");
define("_CHANGE_THE_FILENAME","Αν η πτήση είναι διαφορετική τότε αλλάξτε το όνομα του αρχείου που προσπαθείτε να υποβάλετε");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","Η  πτήση σας έχει καταχωρηθεί");
define("_PRESS_HERE_TO_VIEW_IT","Πατήστε εδώ για να την δείτε");
define("_WILL_BE_ACTIVATED_SOON","(θα ενεργοποιηθεί σε 1-2 λεπτά)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Μαζική υποβολή πτήσεων");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","Μόνο τα IGC αρχεία θα επεξεργαστουν");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","Υποβάλετε το αρχείο ZIP<br>που περιέχει τις πτήσεις");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","Πατήστε εδώ για υποβολή των πτήσεων");

define("_FILE_DOESNT_END_IN_ZIP","Το αρχείο δεν έχει κατάληξη .zip");
define("_ADDING_FILE","Καταχώρηση πτήσης");
define("_ADDED_SUCESSFULLY","Η καταχώρηση ήταν επιτυχής");
define("_PROBLEM","Πρόβλημα");
define("_TOTAL","Συνολικά");
define("_IGC_FILES_PROCESSED","πτήσεις επεξεργάστηκαν");
define("_IGC_FILES_SUBMITED","πτήσεις καταχωρήθηκαν");

// info
define("_DEVELOPMENT","Κατασκευή");
define("_ANDREADAKIS_MANOLIS","Ανδρεαδάκης Μανώλης");
define("_PROJECT_URL","Σελίδα");
define("_VERSION","Έκδοση");
define("_MAP_CREATION","Δημιουργία Χαρτών");
define("_PROJECT_INFO","Πληροφορίες για το πρόγραμμα");

// menu bar 
define("_MENU_MAIN_MENU","Βασικές επιλογές");
define("_MENU_DATE","Ημερομηνία");
define("_MENU_COUNTRY","Χώρα");
define("_MENU_XCLEAGUE","XC League");
define("_MENU_ADMIN","Διαχείρηση");


define("_MENU_COMPETITION_LEAGUE","Κατάταξη - όλες οι κατηγορίες");
define("_MENU_OLC","XC");
define("_MENU_OPEN_DISTANCE","Ανοιχτή απόσταση");
define("_MENU_DURATION","Διάρκεια");
define("_MENU_ALL_FLIGHTS","Όλες οι πτήσεις");
define("_MENU_FLIGHTS","Πτήσεις");
define("_MENU_TAKEOFFS","Απογειώσεις");
define("_MENU_FILTER","Φιλτράρισμα");
define("_MENU_MY_FLIGHTS","Οι πτήσεις μου");
define("_MENU_MY_PROFILE","Οι πληροφορίες μου");
define("_MENU_MY_STATS","Τα στατιστικά μου"); 
define("_MENU_MY_SETTINGS","Οι ρυθμίσεις μου"); 
define("_MENU_SUBMIT_FLIGHT","Υποβολή πτήσης");
define("_MENU_SUBMIT_FROM_ZIP","Υποβολή πτήσης από zip");
define("_MENU_SHOW_PILOTS","Πιλότοι");
define("_MENU_SHOW_LAST_ADDED","Τελευταίες προσθήκες");
define("_FLIGHTS_STATS","Στατιστικά πτήσεων");

define("_SELECT_YEAR","Επιλογή έτους");
define("_SELECT_MONTH","Επιλογή μήνα");
define("_ALL_COUNTRIES","Όλες οι χώρες");

//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","Όλες οι χρονιές");
define("_NUMBER_OF_FLIGHTS","Αριθμός πτήσεων");
define("_TOTAL_DISTANCE","Συνολική απόσταση");
define("_TOTAL_DURATION","Συνολική διάρκεια");
define("_BEST_OPEN_DISTANCE","Καλύτερη απόσταση");
define("_TOTAL_OLC_DISTANCE","Συνολική XC απόσταση");
define("_TOTAL_OLC_SCORE","Συνολικοί XC βαθμοί");
define("_BEST_OLC_SCORE","Καλύτερος XC βαθμός");
define("_MEAN_DURATION","Μέση διάρκεια");
define("_MEAN_DISTANCE","Μέση Απόσταση");
define("_PILOT_STATISTICS_SORT_BY","Πιλότοι - Ταξινόμηση ανά");
define("_CATEGORY_FLIGHT_NUMBER","Κατηγορία 'FastJoe' - Αριθμός πτήσεων");
define("_CATEGORY_TOTAL_DURATION","Κατηγορία 'DURACELL' - Συνολική διάρκεια πτήσεων");
define("_CATEGORY_OPEN_DISTANCE","Κατηγορία 'Open Distance'");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","Δεν υπάρχουν προς το παρόν ενεργοί πιλότοι !");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","Η πτήση διαγράφηκε");
define("_RETURN","Επιστροφή");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","ΠΡΟΣΟΧΗ - Θα διαγράψετε την παρακάτω πτήση ;");
define("_THE_DATE","Ημερομηνία");
define("_YES","ΝΑΙ");
define("_NO","ΟΧΙ");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","Αποτελέσματα Κατάταξης");
define("_N_BEST_FLIGHTS"," καλύτερες πτήσεις");
define("_OLC","XC");
define("_OLC_TOTAL_SCORE","XC Συνολική βαθμολογία");
define("_KILOMETERS","Χιλιόμετρα");
define("_TOTAL_ALTITUDE_GAIN","Συνολική απόκτηση ύψους");
define("_TOTAL_KM","Συνολικά χιλ.");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","να είναι");
define("_IS_NOT","να μην είναι");
define("_OR","ή");
define("_AND","και");
define("_FILTER_PAGE_TITLE","Φιλτράρισμα πτήσεων με κριτήρια");
define("_RETURN_TO_FLIGHTS","Επιστροφή στις πτήσεις");
define("_THE_FILTER_IS_ACTIVE","Το φιλτράρισμα είναι ενεργό");
define("_THE_FILTER_IS_INACTIVE","Το φιλτράρισμα είναι ανενεργό");
define("_SELECT_DATE","Επιλογή Ημερομηνίας");
define("_SHOW_FLIGHTS","Να εμφανιστούν οι πτήσεις");
define("_ALL2","ΟΛΕΣ");
define("_WITH_YEAR","με το έτος");
define("_MONTH","Μήνας");
define("_YEAR","Έτος");
define("_FROM","Από");
define("_from","από");
define("_TO","Έως");
define("_SELECT_PILOT","Επιλογή Πιλότου");
define("_THE_PILOT","Ο πιλότος");
define("_THE_TAKEOFF","Η απογείωση");
define("_SELECT_TAKEOFF","Επιλογή Απογείωσης");
define("_THE_COUNTRY","H χώρα");
define("_COUNTRY","Χώρα");
define("_SELECT_COUNTRY","Επιλέξτε χώρα");
define("_OTHER_FILTERS","Λοιπά στοιχεία");
define("_LINEAR_DISTANCE_SHOULD_BE","Η απόσταση σε ευθεία να είναι");
define("_OLC_DISTANCE_SHOULD_BE","Η απόσταση XC να είναι");
define("_OLC_SCORE_SHOULD_BE","Η βαθμολογία XC να είναι");
define("_DURATION_SHOULD_BE","Η διάρκεια να είναι");
define("_ACTIVATE_CHANGE_FILTER","Ενεργοποίηση / αλλαγή ΦΙΛΤΡΟΥ");
define("_DEACTIVATE_FILTER","Απενεργοποίηση ΦΙΛΤΡΟΥ");
define("_HOURS","ώρες");
define("_MINUTES","λεπτά");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","Υποβολή πτήσης");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(μόνο το IGC αρχείο είναι υποχρεωτικό)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","Υποβάλετε το αρχείο<br>IGC της πτήσης");
define("_NOTE_TAKEOFF_NAME","Αναφέρετε την ονομασία της απογείωσης");
define("_COMMENTS_FOR_THE_FLIGHT","Σχόλια για την πτήση");
define("_PHOTO","Φωτογραφία");
define("_PHOTOS_GUIDELINES","Οι φωτογραφίες πρέπει να είναι jpg και μέχρι ");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","Πατήστε εδώ για υποβολή της πτήσης");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","Εχετε πολλές πτήσεις σε ένα αρχείο zip ?");
define("_PRESS_HERE","Πατήστε εδώ");

define("_IS_PRIVATE","Όχι δημόσια θέα");
define("_MAKE_THIS_FLIGHT_PRIVATE","Όχι δημόσια θέα");
define("_INSERT_FLIGHT_AS_USER_ID","Εισαγωγή ως χρήστης (ID)");
define("_FLIGHT_IS_PRIVATE","Η πτήση δεν είναι σε δημόσια θέα");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","Αλλαγή στοιχείων πτήσης");
define("_IGC_FILE_OF_THE_FLIGHT","Αρχείο IGC της πτήσης");
define("_DELETE_PHOTO","Διαγραφή");
define("_NEW_PHOTO","καινούργια");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","Πατήστε εδώ για αλλαγή των στοιχείων της πτήσης");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","Οι αλλαγές στα στοιχεία έχουν γίνει");
define("_RETURN_TO_FLIGHT","Επιστροφή στην πτήση");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","Επιστροφή στην πτήση");
define("_READY_FOR_SUBMISSION","Ετοιμη προς υποβολή");
define("_OLC_MAP","Χάρτης");
define("_OLC_BARO","Βαρόγραμα");


//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","Προφίλ Πιλότου");
define("_back_to_flights","επιστροφή");
define("_pilot_stats","στατιστικά πιλότου");
define("_edit_profile","επεξεργασία");
define("_flights_stats","στατιστικά πτήσεων");
define("_View_Profile","Εμφάνιση προφίλ");

define("_Personal_Stuff","Προσωπικά στοιχεία");
define("_First_Name","Όνομα");
define("_Last_Name","Επώνυμο");
define("_Birthdate","Ημ. Γέννησης");
define("_dd_mm_yy","ηη.μμ.εε");
define("_Sign","Ζώδιο");
define("_Marital_Status","Οικογενειακή κατάσταση");
define("_Occupation","Επάγγελμα");
define("_Web_Page","Web σελίδα");
define("_N_A","N/A");
define("_Other_Interests","Άλλα ενδιαφέροντα");
define("_Photo","Φωτογραφία");

define("_Flying_Stuff","Πτητικά στοιχεία");
define("_note_place_and_date","Δώστε τοποθεσία και χρόνο");
define("_Flying_Since","Χρονολογία πρώτης πτήσης");
define("_Pilot_Licence","Δίπλωμα πιλότου");
define("_Paragliding_training","Εκπαιδεύση");
define("_Favorite_Location","Αγαπημένη τοποθεσία");
define("_Usual_Location","Συνηθισμένη τοποθεσία");
define("_Best_Flying_Memory","Καλύτερη ανάμνηση");
define("_Worst_Flying_Memory","Χειρότερη ανάμνηση");
define("_Personal_Distance_Record","Προσωπικό ρεκόρ απόστασης");
define("_Personal_Height_Record","Προσωπικό ρεκόρ ύψους");
define("_Hours_Flown","Συνολικές ώρες πτήσης");
define("_Hours_Per_Year","Ώρές ανα έτος");

define("_Equipment_Stuff","Εξοπλισμός");
define("_Glider","Αλεξίπτωτο");
define("_Harness","Ζώνη / Κάθισμα");
define("_Reserve_chute","Εφεδρικό");
define("_Camera","Φωτ. μηχανή");
define("_Vario","Βάριο");
define("_GPS","GPS");
define("_Helmet","Κράνος");
define("_Camcorder","Βίντεοκάμερα");

define("_Manouveur_Stuff","SIV - Ακροβατικά");
define("_note_max_descent_rate","δώστε μέγιστο βαθμό καδόθου");
define("_Spiral","Σπιράλ");
define("_Bline","Bline");
define("_Full_Stall","Full Stall");
define("_Other_Manouveurs_Acro","Άλλα");
define("_Sat","Sat");
define("_Asymmetric_Spiral","Ασύμμετρο σπιράλ");
define("_Spin","Σπίν");

define("_General_Stuff","Γενικά");
define("_Favorite_Singer","Αγαπημένος τραγουδιστής");
define("_Favorite_Movie","Αγαπημένη ταινία");
define("_Favorite_Internet_Site","Αγαπημένο <br>Internet Site");
define("_Favorite_Book","Αγαπημένος βιβλίο");
define("_Favorite_Actor","Αγαπημένος ηθοποιός");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","Δώστε μια νέα φωτογραφία ή αλλάξτε την παλιά");
define("_Delete_Photo","Διαγραφή φωτογραφίας");
define("_Your_profile_has_been_updated","Το προφίλ σας έχει αλλαχτεί");
define("_Submit_Change_Data","Αλλαγή στοιχείων");

//--------------------------------------------
// Added by Martin Jursa, 26.04.2007 for pilot_profile and pilot_profile_edit
//--------------------------------------------
define("_Sex", "Φύλο");
define("_Login_Stuff", "Change Login-Data");
define("_PASSWORD_CONFIRMATION", "Confirm password");
define("_EnterPasswordOnlyToChange", "Only enter the password, if you want to change it:");

define("_PwdAndConfDontMatch", "Password and confirmation are different.");
define("_PwdTooShort", "The password is too short. It must have a length of at least $passwordMinLength characters.");
define("_PwdConfEmpty", "The password has not be confirmed.");
define("_PwdChanged", "The password was changed.");
define("_PwdNotChanged", "The password has NOT been changed.");
define("_PwdChangeProblem", "A problem occurred when changing the password.");

define("_EmailEmpty", "The email address must not be empty.");
define("_EmailInvalid", "The email address is invalid.");
define("_EmailSaved", "The email address was saved");
define("_EmailNotSaved", "The email address has not been saved.");
define("_EmailSaveProblem", "A problem occurred when saving the email address.");

//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","ωω:λλ");

define("_Totals","Συνολικά");
define("_First_flight_logged","Πρώτη πτήση που καταχωρήθηκε");
define("_Last_flight_logged","Τελευταία πτήση που καταχωρήθηκε");
define("_Flying_period_covered","Πτήτική περίοδος<br>καταχωρημένων πτησεων");
define("_Total_Distance","Συνολική απόσταση");
define("_Total_OLC_Score","Συνολική βαθμολογία XC");
define("_Total_Hours_Flown","Συνολικές ώρες πτήσης");
define("_Total_num_of_flights","Συνολικός αριθμός πτήσεων");

define("_Personal_Bests","Προσωπικά ρεκόρ");
define("_Best_Open_Distance","Καλύτερη ανοιχτή απόσταση");
define("_Best_FAI_Triangle","Καλύτερο FAI Τρίγωνο");
define("_Best_Free_Triangle","Καλύτερο Ελέυθερο Τρίγωνο");
define("_Longest_Flight","Μεγαλύτερη διάρκεια πτήσης");
define("_Best_OLC_score","Καλύτερη βαθμολογία XC");
define("_Absolute_Height_Record","Μέγιστο υψόμετρο απο θάλασσα");
define("_Altitute_gain_Record","Μέγιστη απόκτηση ύψους απο την απογείωση");

define("_Mean_values","Μέσες τιμές");
define("_Mean_distance_per_flight","Μέση απόσταση ανα πτήση");
define("_Mean_flights_per_Month","Μέσος αριθμός πτήσεων ανα μήνα");
define("_Mean_distance_per_Month","Μέση απόσταση ανα μήνα");
define("_Mean_duration_per_Month","Μέση διάρκεια ανα μήνα");
define("_Mean_duration_per_flight","Μέση διάρκεια ανα πτήση");
define("_Mean_flights_per_Year","Μέσος αριθμός πτήσεων ανα έτος");
define("_Mean_distance_per_Year","Μέση απόσταση ανα έτος");
define("_Mean_duration_per_Year","Μέση διάρκεια ανα έτος");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","Δείτε πτήσεις από αυτό το σημείο");
define("_Waypoint_Name","Όνομα τοποθεσίας");
define("_Navigate_with_Google_Earth","Δες το στο Google_Earth");
define("_See_it_in_Google_Maps","Δες το στο Google_Maps");
define("_See_it_in_MapQuest","Δες το στο MapQuest");
define("_COORDINATES","Συντεταγμένες");
define("_FLIGHTS","Πτήσεις");
define("_SITE_RECORD","Ρεκόρ τοποθεσίας");
define("_SITE_INFO","Πληροφορίες απογείωσης");
define("_SITE_REGION","Περιοχή");
define("_SITE_LINK","Περισσότερες πληροφορίες");
define("_SITE_DESCR","Περιγραφή απογείωσης/μέρους");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","Περισσότερες πληροφορίες");
define("_KML_file_made_by","Δημιουργία KML αρχείου: ");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","Καταχώρηση απογείωσης");
define("_WAYPOINT_ADDED","Η απογείωση καταχωρήθηκε");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","Ρεκόρ απογείωσης<br>(ανοιχτή απόσταση)");
	
//--------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","Τύπος πτητικής μηχανής");
function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'Παραπέντε',2=>'Αετός FAI1',4=>'Αετός FAI5',8=>'Ανεμόπτερο',
						16=>'Παραμοτέρ',32=>'Trike',64=>'Μηχανοκίνητη πτήση');
	foreach ($CONF_glider_types as $gId=>$gName) if (!$gliderCatList[$gId]) $gliderCatList[$gId]=$gName;
}
setGliderCats();

//--------------------------------------------
// class types
//--------------------------------------------
function setClassList() {
	$CONF_TEMP['gliderClasses'][1]['classes']=array(1=>"Sport (έως και DHV 2)",2=>"Open (απο DHV 2/3)",3=>"Διθέσια");
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
	$xcTypesList=array(1=>"XC με 3 πυλώνες",2=>"Τρίγωνο Ανοιχτό",4=>"Τρίγωνο FAI κλειστό");
	foreach ($CONF_xc_types as $gId=>$gName) if (!$xcTypesList[$gId]) $xcTypesList[$gId]=$gName;
}
setXCtypesList(); 

//--------------------------------------------
// user prefs  & units
//--------------------------------------------

define("_Your_settings_have_been_updated","Οι ρυθμίσεις σας έχουν αποθηκευτεί");

define("_THEME","Εμφάνιση");
define("_LANGUAGE","Γλώσσα");
define("_VIEW_CATEGORY","Θέαση κατηγορίας");
define("_VIEW_COUNTRY","Θέαση χώρας");
define("_UNITS_SYSTEM" ,"Σύστημα μονάδων");
define("_METRIC_SYSTEM","Μετρικό (χιλ,μ)");
define("_IMPERIAL_SYSTEM","Imperial (μίλια,πόδια)");
define("_ITEMS_PER_PAGE","Πτήσεις ανά σελίδα");

define("_MI","mi");
define("_KM","χιλ");
define("_FT","ft");
define("_M","μ");
define("_MPH","μαο");
define("_KM_PER_HR","χιλ/ω");
define("_FPM","fpm");
define("_M_PER_SEC","μ/δευτ");

//--------------------------------------------
// index page
//--------------------------------------------

define("_WORLD_WIDE","Παγκοσμίως");
define("_National_XC_Leagues_for","Εθνικές κατατάξεις");
define("_Flights_per_Country","Πτήσεις ανα Χώρα");
define("_Takeoffs_per_Country","Απογειώσεις Χωρών");
define("_INDEX_HEADER","Καλώς ήλθατε στον Leonardo XC League");
define("_INDEX_MESSAGE","Μπορείτε να χρησιμοποιήσετε το μενού απο πάνω ή να επιλέξετε τις πιο συνηθισμένες επιλογές παρακάτω");

//--------------------------------------------
// NEW 
//--------------------------------------------
define("_MENU_SUMMARY_PAGE","Πρώτη Σελίδα (Περίληψη)");
define("_Display_ALL","Εμφάνιση ΟΛΩΝ");
define("_Display_NONE","Εμφάνιση ΟΛΩΝ");
define("_Reset_to_default_view","Επαναφορά της αρχικής εμφάνισης");
define("_No_Club","Κανένα club/ομάδα");
define("_This_is_the_URL_of_this_page","Το URL αυτής της σελίδας");
define("_All_glider_types","Όλες οι πτητικές συσκευές");


define("_MENU_SITES_GUIDE","Οδηγός απογειώσεων");
define("_Site_Guide","Οδηγός απογειώσεων");

define("_Search_Options","Αναζήτηση");
define("_Below_is_the_list_of_selected_sites","Λίστα των επιλεγμένων απογειώσεων");
define("_Clear_this_list","Καθαρισμός της λίστας");
define("_See_the_selected_sites_in_Google_Earth","Ανοιγμα των επιλεγμένων στο Google Earth");
define("_Available_Takeoffs","Διαθέσιμες απογειώσεις");
define("_Search_site_by_name","Αναζήτηση με όνομα");
define("_give_at_least_2_letters","δώστε τουλάχιστον 2 γράμματα");
define("_takeoff_move_instructions_1","Μετακινήστε τις όλες τις διαθέσιμες απογειώσεις στην λίστα δεξιά με το >> ή μόνο την επιλεγμένη με το > ");
define("_Takeoff_Details","Στοιχεία απογείωσης");


define("_Takeoff_Info","Πληροφορίες απογείωσης");
define("_XC_Info","Πληροφορίες XC");
define("_Flight_Info","Πληροφορίες Πτήσης");

define("_MENU_LOGOUT","Αποσύνδεση");
define("_MENU_LOGIN","Είσοδος");
define("_MENU_REGISTER","Άνοιγμα λογαριασμού");


define("_Africa","Αφρική");
define("_Europe","Ευρώπη");
define("_Asia","Ασία");
define("_Australia","Αυστραλία");
define("_North_Central_America","Βόρεια/Κεντρική Αμερική");
define("_South_America","Νότια Αμερική");

define("_Recent","Πρόσφατα");


define("_Unknown_takeoff","Άγνωστη απογείωση");
define("_Display_on_Google_Earth","Άνοιγμα στο Google Earth");
define("_Use_Man_s_Module","Με το Man's Module (αναλυτική απεικόνιση)");
define("_Line_Color","Χρώμα γραμμής");
define("_Line_width","Πάχος γραμμής");
define("_unknown_takeoff_tooltip_1","Η πτήση αυτή ξεκίνησε από μη καταχωρημένη απογείωση");
define("_unknown_takeoff_tooltip_2","Έαν ξέρετε το ονομα της απογείωσης πατήστε για να το συμπληρώσετε !");
define("_EDIT_WAYPOINT","Αλλαγή στοιχείων απογείωσης");
define("_DELETE_WAYPOINT","Διαγραφή απογείωσης");
define("_SUBMISION_DATE","Ημ/νια υποβολής"); // the date a flight was submited to leonardo
define("_TIMES_VIEWED","Αριθμός προβολών"); // the times that this flight havs been viewed


define("_takeoff_add_help_1","Μπορείτε να εισάγετε τις πληροφορίες για αυτήν την απογείωση εάν τις γνωρίζετε. Εάν όχι κλείστε το παράθυρο αυτό");
define("_takeoff_add_help_2","Έάν η απογείωση που φαίνεται (Πάνω απο το 'άγνωστη απογείωση') είναι η σωστή τότε <strong>δεν πρέπει να την ξαναβάλετε</strong>. Απλώς κλείστε το παράθυρο αυτό.");
define("_takeoff_add_help_3","Έάν δείτε το σωστό όνομα της απογείωσης κατω απο εδω πατήστε πάνω του για να συμπληρωθούν αυτόματα τα πεδία στα αριστερά.");
define("_Takeoff_Name","Όνομα απογείωσης");
define("_In_Local_Language","Στα ελληνικά");
define("_In_English","Στα αγγλικά");

// New on 2007/02/20 - login screen
define("_ENTER_PASSWORD","Δώστε το όνομα χρήστη και τον κωδικό σας.");
define("_SEND_PASSWORD","Ξέχασα τον κωδικό μου");
define("_ERROR_LOGIN","Δώσατε λάθος όνομα χρήστη ή κωδικό.");
define("_AUTO_LOGIN","Αυτόματη εισαγωγή μου σε κάθε επίσκεψη");
define("_USERNAME","Χρήστης");
define("_PASSWORD","Κωδικός");
define("_PROBLEMS_HELP","Εάν έχετε προβλήματα εισόδου επικοινωνήστε με τον διαχειριστή");

define("_LOGIN_TRY_AGAIN","Πατήστε %sΕδώ%s για να ξαναδοκιμάσετε");
define("_LOGIN_RETURN","Πατήστε %sΕδώ%s για να γυρίσετε στην αρχική σελίδα");
// end 2007/02/20

define("_Category","Κατηγορία");
define("_MEMBER_OF","Μέλος ");
define("_MemberID","Α/Α Μέλους");
define("_EnterID","Εισαγωγή Α/Α");
define("_Clubs_Leagues","Λέσχες / Κατατάξεις");
define("_Pilot_Statistics","Στατιστικά πιλότων");
define("_National_Rankings","Εθνικές κατατάξεις");


// new on 2007/03/08
define("_Select_Club","Επιλογή Λέσχης");
define("_Close_window","Κλείσιμο παραθύρου");
define("_Club","Λέσχη");
define("_Sponsor","Σπόνσορας");


// new on 2007/03/13
define("_Go_To_Current_Month","Επιλογή τρέχοντος μήνα");
define("_Today_is","Σήμερα είναι");
define("_Wk","Εβδ");
define("_Click_to_scroll_to_previous_month","Πατήστε για επιλογή του προηγούμενου μήνα");
define("_Click_to_scroll_to_next_month","Πατήστε για επιλογή του επόμενου μήνα");
define("_Click_to_select_a_month","Πατήστε για επιλογή μήνα");
define("_Click_to_select_a_year","Πατήστε για επιλογή έτους");
define("_Select_date_as_date.","Επιλογή [date] ως ημερομηνίας"); // do not replace [date], it will be replaced by date.

// end 2007/03/13

// New on 2007/05/18 (alternative GUI_filter)
define("_Filter_NoSelection", "Χωρίς επιλογή");
define("_Filter_CurrentlySelected", "Τρέχουσα επιλογή");
define("_Filter_DialogMultiSelectInfo", "Κρατήστε πατημένπ το Ctrl<BR>για να επιλέξετε περισσότερα απο ένα.");

define('_Filter_FilterTitleIncluding', 'Επιλογή [items]');
define('_Filter_FilterTitleExcluding', 'Αποκλεισμός [items]');
define('_Filter_DialogTitleIncluding', 'Επιλογή [items]');
define('_Filter_DialogTitleExcluding', 'Αποκλεισμός [items]');

define("_Filter_Items_pilot", "πιλότων");
define("_Filter_Items_nacclub", "λεσχών");
define("_Filter_Items_country", "χωρών");
define("_Filter_Items_takeoff", "απογειώσεων");

define("_Filter_Button_Select", "Επιλογή");
define("_Filter_Button_Delete", "Διαγραφή");
define("_Filter_Button_Accept", "Αποδοχή επιλογών");
define("_Filter_Button_Cancel", "Ακύρωση");

# menu bar
define("_MENU_FILTER_NEW","Filter **NEW VERSION**");

// end 2007/05/18


// New on 2007/05/23
// second menu NACCclub selection
define("_ALL_NACCLUBS", "Όλες οι λέσχες");
// Note to translators: use the placeholder $nacname in your translation as it is, don"t translate it
define("_SELECT_NACCLUB", 'Επιλογή λέσχης-[nacname]');

// pilot profile
define("_FirstOlcYear", "First year of participation in an online XC contest");
define("_FirstOlcYearComment", "Please select the year of your first participation in any online XC contest, not just this one.<br/>This field is relevant for the &quot;newcomer&quot;-rankings.");

//end 2007/05/23

// New on 2007/11/06
define("_Select_Brand","Επιλογή εταιρείας");
define("_All_Brands","Όλες οι εταιρείες");
define("_DAY","Μέρα");
define('_Glider_Brand','Εταιρεία');
define('_Or_Select_from_previous','Ή επιλέξτε απο προηγούμενα');

define('_Explanation_AddToBookmarks_IE', 'Add these filter settings to your favourites');
define('_Msg_AddToBookmarks_IE', 'Click here to add these filter settings to your bookmarks.');
define('_Explanation_AddToBookmarks_nonIE', '(Save this link to your bookmarks.)');
define('_Msg_AddToBookmarks_nonIE', 'To save these filter settings to your bookmarks, use the function Save to bookmarks of your browser.');

define('_PROJECT_HELP','Βοήθεια');
define('_PROJECT_NEWS','Νέα');
define('_PROJECT_RULES','Κανόνες 2007');
define('_PROJECT_RULES2','Κανόνες 2008');

//end 2007/11/06
define('_MEAN_SPEED1','Μέση ταχύτητα');
define('_External_Entry','Πτήση απο άλλο server');

// New on 2007/11/25
define('_Altitude','Υψόμετρο');
define('_Speed','Ταχύτητα');
define('_Distance_from_takeoff','Αππόσταση απο απογείωση');

// New on 2007/12/03
define('_LAST_DIGIT','τελευταίο ψηφίο');

define('_Filter_Items_nationality','εθνικότητα');
define('_Filter_Items_server','server');

// New on 2007/12/15
define('_Ext_text1','Αυτή η πτήση είχε αρχικά υποβληθεί στο ');
define('_Ext_text2','Πατήστε εδώ για τους χάρτες και τα γραφήματα');
define('_Ext_text3','Σύνδεσμος στην πρωτότυπη πτήση');

// New on 2008/2/15
define('_Male_short','Α');
define('_Female_short','Θ');
define('_Male','Άνδρας');
define('_Female','Γυνάικα');
define('_Pilot_Statistics','Στατιστικά Πιλότων');

// New on 2008/2/19
define('_Altitude_Short','Υψος');
define("_Vario_Short","Vario");
define("_Time_Short","Ώρα");
define("_Info","Πληρ/ρίες");
define("_Control","Έλεχγος");

define("_Zoom_to_flight","Ζουμ στην πτήση");
define("_Follow_Glider","Ακολούθηση πιλότου");
define("_Show_Task","Εμφάνιση Τασκ");
define("_Show_Airspace","Εμφάνιση Airspace");

// New on 2008/06/04
define("_Show_Optimization_details","Αναλυτικά η βαθμολόγηση");

define("_MENU_SEARCH_PILOTS","Εύρευση πιλότου");


// New on 2008/11/26
define('_MENU_AREA_GUIDE','Περιοχές πτήσεων');
define('_All_XC_types','Όλοι οι τύποι XC');
define('_xctype','Τύπος XC');

define('_Flying_Areas','Περιοχές πτήσεων');
define('_Name_of_Area','Όνομα περιοχής');
define('_See_area_details','Δείτε περισσότερες πληροφορίες και τις απογειώσεις της περιοχής');

define('_choose_ge_module','Επιλέξτε τον τρόπο<BR>απεικόνησης στο Google Earth');
define('_ge_module_advanced_1','(Αναλυτικότατος, μέγιστο μέγεθος)');
define('_ge_module_advanced_2','(Αναλυτικός, μεγάλο μέγεθος) ');
define('_ge_module_Simple','Απλός (Μόνο Task, μικρό μέγεθος)');

define('_Pilot_search_instructions','Πληκτρολογήστε τουλάχιστον 3 γράμματα απο το όνομα ή το επίθετο');

define('_All_classes','Όλες οι κλάσεις');
define('_Class','Κλάση');

// 2009-03-20 filter for photos
define('_Photos_filter_off','Με/χωρίς φωτογραφίες');
define('_Photos_filter_on','Μόνο με φωτογραφίες');

// 2010-03-14
define('_See_The_filter','Περιγραφή του φίλτρου');
define('_PilotBirthdate','Ημ. Γέννησης Πιλότου');
define('_Start_Type','Τύπος απογείωσης');
define('_GLIDER_CERT','Πιστοποίηση πτέρυγας');

define('_MENU_BROWSER','Πτήσεις σε Google Maps');
define('_FLIGHT_BROSWER','Αναζήτηση της βάσης των πτήσεων και απογειώσεων μέσω Google Maps');
define('_Load_Thermals','Εμφάνιση Θερμικών');
define('_Loading_thermals','Προετοιμασία εμφάνισης Θερμικών');

//--------------------------------------------------------
//--------------------------------------------------------
// Missing defines , autoreplaced values from 'english' 
//--------------------------------------------------------
define("_SUBMIT_TO_OLC","Submit to OLC"); 
define("_pilot_email","Email Address"); 
define("_Thermals","Thermals"); 
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

http://%s?op=users&page=index&act=register&rkey=%s

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

http://%s?op=sdpw&rkey=%s

Regards,

--------
Note: This is auto-response. Do not send any email to this email address
--------"); 
define("_You_are_already_logged_in","You are already logged in"); 

?>
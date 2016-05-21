<? if (0) { ?><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9"></head><? } 
?><?php
/**************************************************************************/
/* Turkish language translation by Ali Yucer   (yucer_ali@hotmail.com)    */
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
	$monthList=array('Ocak','�ubat','Mart','Nisan','May�s','Haziran',
				'Temmuz','A�ustos','Eyl�l','Ekim','Kas�m','Aral�k');
	$monthListShort=array('OCK','�BT','MRT','NSN','MYS','HZR','TMZ','A�U','EYL','EKM','KSM','ARL');
	$weekdaysList=array('Pzr','Pzts','Sal�','�r�','Pr�','Cuma','Cmrt') ;
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","Serbest u�u�");
define("_FREE_TRIANGLE","Serbest ��gen u�u�u");
define("_FAI_TRIANGLE","FAI ��gen u�u�u");

define("_SUBMIT_FLIGHT_ERROR","U�u� bilgilerini g�nderirken hata olu�tu");

// list_pilots()
define("_NUM","#");
define("_PILOT","Pilot");
define("_NUMBER_OF_FLIGHTS","U�u� Say�s�");
define("_BEST_DISTANCE","En iyi mesafe");
define("_MEAN_KM","U�u� ba��na ortalama kilometre");
define("_TOTAL_KM","Toplam U�u� km");
define("_TOTAL_DURATION_OF_FLIGHTS","Toplam U�u� S�resi");
define("_MEAN_DURATION","Ortalama U�u� S�resi");
define("_TOTAL_OLC_KM","Toplam OLC mesafesi");
define("_TOTAL_OLC_SCORE","Toplam OLC puan�");
define("_BEST_OLC_SCORE","En iyi OLC puan�");
define("_From","de");

// list_flights()
define("_DURATION_HOURS_MIN","S�re (ss:dd)");
define("_SHOW","G�ster");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","U�u� Kayd�n�z 1-2 dakika i�inde aktif 
olacakt�r. ");
define("_TRY_AGAIN","L�tfen az sonra tekrar deneyin");

define("_TAKEOFF_LOCATION","Kalk��");
define("_TAKEOFF_TIME","Kalk�� Zaman�");
define("_LANDING_LOCATION","�ni�");
define("_LANDING_TIME","�ni� Zaman�");
define("_OPEN_DISTANCE","Do�rusal Mesafe");
define("_MAX_DISTANCE","Maksimum Mesafe");
define("_OLC_SCORE_TYPE","OLC puan �e�idi");
define("_OLC_DISTANCE","OLC mesafe");
define("_OLC_SCORING","OLC puan");
define("_MAX_SPEED","Maksimum h�z");
define("_MAX_VARIO","Maksimum vario");
define("_MEAN_SPEED","Ortalama h�z");
define("_MIN_VARIO","Minimum vario");
define("_MAX_ALTITUDE","��k�lan En y�ksek irtifa");
define("_TAKEOFF_ALTITUDE","Kalk�� Pistinin Deniz Seviyesinden Y�ksekli�i");
define("_MIN_ALTITUDE","En d���k irtifa ");
define("_ALTITUDE_GAIN","Kazan�lan irtifa");
define("_FLIGHT_FILE","U�u� dosyas�");
define("_COMMENTS","Yorumlar");
define("_RELEVANT_PAGE","�lgili adres");
define("_GLIDER","Kanat");
define("_PHOTOS","Foto�raf");
define("_MORE_INFO","Ekstra");
define("_UPDATE_DATA","Veriyi G�ncelle");
define("_UPDATE_MAP","Haritay� g�ncelle");
define("_UPDATE_3D_MAP","3D haritay� g�ncelle");
define("_UPDATE_GRAPHS","Grafikleri G�ncelle");
define("_UPDATE_SCORE","Puan� g�ncelle");

define("_TAKEOFF_COORDS","Kalk�� Pisti koordinatlar�:");
define("_NO_KNOWN_LOCATIONS","U�u� b�lgeleri bilinmemekte!");
define("_FLYING_AREA_INFO","B�lge Bilgileri");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo XC");
define("_RETURN_TO_TOP","En Ba�a d�n");
// list flight
define("_PILOT_FLIGHTS","Pilot'un u�u�lar�");

define("_DATE_SORT","Tarih");
define("_PILOT_NAME","Pilot ismi");
define("_TAKEOFF","Kalk�� Pisti");
define("_DURATION","S�re");
define("_LINEAR_DISTANCE","A��k Mesafe");
define("_OLC_KM","OLC km.");
define("_OLC_SCORE","OLC puan");
define("_DATE_ADDED","En son Kaydedilen ucuslar");

define("_SORTED_BY","S�ralama Bi�imi:");
define("_ALL_YEARS","T�m Y�llar");
define("_SELECT_YEAR_MONTH","Y�l / ay se�");
define("_ALL","Hepsi");
define("_ALL_PILOTS","T�m Pilotlar� g�ster");
define("_ALL_TAKEOFFS","T�m kalk�� pistlerini g�ster");
define("_ALL_THE_YEAR","T�m y�l");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","Bir u�u� dosyas� g�ndermediniz");
define("_NO_SUCH_FILE","G�nderdi�iniz dosya sitede bulunam�yor");
define("_FILE_DOESNT_END_IN_IGC","Dosya IGC uzant�l� de�il");
define("_THIS_ISNT_A_VALID_IGC_FILE","Bu ge�erli bir IGC dosyas� de�il");
define("_THERE_IS_SAME_DATE_FLIGHT","Ayn� g�n ve tarihte zaten ba�ka bir u�u� kay�tl�");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","De�i�tirmek istiyorsan�z �nce eskisini silmelisiniz");
define("_DELETE_THE_OLD_ONE","Eski bir tane sil");
define("_THERE_IS_SAME_FILENAME_FLIGHT","Ayn� isimde zaten baska bir dosya var");
define("_CHANGE_THE_FILENAME","Bu u�u� baska bir u�u� ise l�tfen dosya ismini de�istirerek tekrar deneyin");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","U�u� kayd�n�z g�nderildi");
define("_PRESS_HERE_TO_VIEW_IT","G�rmek i�in buraya t�klay�n");
define("_WILL_BE_ACTIVATED_SOON","(U�u� kayd�n�z 1-2 dakika i�inde aktif olacakt�r)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Birden fazla u�u� kayd� g�nder");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED",".zip dosyas�n�n i�indeki sadece .igc dosyalar� i�lenir.");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","U�u�lar� i�eren<br>zip dosyas� g�nder");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","G�ndermek ��in T�klay�n");

define("_FILE_DOESNT_END_IN_ZIP","Y�kledi�iniz dosya ZIP uzant�s� de�il");
define("_ADDING_FILE","Dosya g�nderiliyor");
define("_ADDED_SUCESSFULLY","Ba�ar�yla g�nderildi");
define("_PROBLEM","Problem");
define("_TOTAL","Toplam da ");
define("_IGC_FILES_PROCESSED","U�u�lar ��leniyor");
define("_IGC_FILES_SUBMITED","U�u�lar g�nderildi");

// info
define("_DEVELOPMENT","Geli�tirme");
define("_ANDREADAKIS_MANOLIS","Andreadakis Manolis");
define("_PROJECT_URL","Proje sayfas�");
define("_VERSION","Versiyon");
define("_MAP_CREATION","Harita yap�m�");
define("_PROJECT_INFO","Proje bilgisi");

// menu bar
define("_MENU_MAIN_MENU","Ana Men�");
define("_MENU_DATE","Tarih Se�");
define("_MENU_COUNTRY","�lke Se�");
define("_MENU_XCLEAGUE","XC Lig");
define("_MENU_ADMIN","Admin");

define("_MENU_COMPETITION_LEAGUE","XC Lig - T�m Kategoriler");
define("_MENU_OLC","OLC");
define("_MENU_OPEN_DISTANCE","A��k Mesafe");
define("_MENU_DURATION","S�re");
define("_MENU_ALL_FLIGHTS","T�m U�u�lar");
define("_MENU_FLIGHTS","U�u�lar");
define("_MENU_TAKEOFFS","Kalk�� Pistleri");
define("_MENU_FILTER","Filtre");
define("_MENU_MY_FLIGHTS","U�u�lar�m");
define("_MENU_MY_PROFILE","Pilot Profilim");
define("_MENU_MY_STATS","�statistiklerim");
define("_MENU_MY_SETTINGS","Ayarlar�m"); 
define("_MENU_SUBMIT_FLIGHT","U�u� Kayd� G�nder");
define("_MENU_SUBMIT_FROM_ZIP","ZIP dosyas�yla g�nder");
define("_MENU_SHOW_PILOTS","Pilotlar");
define("_MENU_SHOW_LAST_ADDED","En Son Y�klenenler");
define("_FLIGHTS_STATS","U�u� �statistikleri");

define("_SELECT_YEAR","Y�l Se�");
define("_SELECT_MONTH","Ay Se�");
define("_ALL_COUNTRIES","T�m �lkeleri G�ster");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","T�m Zamanlar");
define("_NUMBER_OF_FLIGHTS","U�u� Say�s�");
define("_TOTAL_DISTANCE","Toplam Mesafe");
define("_TOTAL_DURATION","Toplam S�re");
define("_BEST_OPEN_DISTANCE","En iyi mesafe");
define("_TOTAL_OLC_DISTANCE","Toplam OLC mesafesi");
define("_TOTAL_OLC_SCORE","Toplam OLC puna�e");
define("_BEST_OLC_SCORE","En iyi OLC puna�");
define("_MEAN_DURATION","Ortamala S�re");
define("_MEAN_DISTANCE","Ortalama Mesafe");
define("_PILOT_STATISTICS_SORT_BY","Pilotlar - S�rala");
define("_CATEGORY_FLIGHT_NUMBER","Kategori 'FastJoe' - U�u� Say�s�");
define("_CATEGORY_TOTAL_DURATION","Kategori 'DURACELL' - Ucu�lar�n toplam 
s�resi");
define("_CATEGORY_OPEN_DISTANCE","Kategori'A��k Mesafe'");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","G�sterilecek pilot yok");


//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","U�u� kayd� silindi");
define("_RETURN","Geri D�n");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","DIKKAT - Bu u�u� kayd�n� silmek �zeresiniz");
define("_THE_DATE","Tarih ");
define("_YES","EVET");
define("_NO","HAYIR");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","Lig Sonu�lar�");
define("_N_BEST_FLIGHTS","En iyi U�u�");
define("_OLC","OLC");
define("_OLC_TOTAL_SCORE","OLC toplam puan");
define("_KILOMETERS","Kilometreler");
define("_TOTAL_ALTITUDE_GAIN","Toplam Irtifa Kazanc�");
define("_TOTAL_KM","Toplam Km");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","is");
define("_IS_NOT","is not");
define("_OR","veya");
define("_AND","ve");
define("_FILTER_PAGE_TITLE","U�u�lar� filtrele");
define("_RETURN_TO_FLIGHTS","U�u�lara d�n");
define("_THE_FILTER_IS_ACTIVE","Filtre a��k");
define("_THE_FILTER_IS_INACTIVE","Filtre kapal�");
define("_SELECT_DATE","Tarih se�");
define("_SHOW_FLIGHTS","U�u�lar� g�ster");
define("_ALL2","HEPSI");
define("_WITH_YEAR","Y�l ile");
define("_MONTH","Ay");
define("_YEAR","Y�l");
define("_FROM","From");
define("_from","from");
define("_TO","biti�");
define("_SELECT_PILOT","Pilot Se�");
define("_THE_PILOT","Pilot");
define("_THE_TAKEOFF","Kalk�� pisti");
define("_SELECT_TAKEOFF","Kalk�� pisti se�");
define("_THE_COUNTRY","�lke");
define("_COUNTRY","�lke");
define("_SELECT_COUNTRY","�lke Se�");
define("_OTHER_FILTERS","Di�er filtreler");
define("_LINEAR_DISTANCE_SHOULD_BE","Ku� U�u�u Mesafe");
define("_OLC_DISTANCE_SHOULD_BE","Ku� U�u�u Mesafe");
define("_OLC_SCORE_SHOULD_BE","OLC Puani");
define("_DURATION_SHOULD_BE","Mesafe");
define("_ACTIVATE_CHANGE_FILTER","Aktif / Filtre de�i�tir");
define("_DEACTIVATE_FILTER","Filtre kapal�");
define("_HOURS","saatler");
define("_MINUTES","dakika");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","U�u� Kayd� G�nder");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(Sadece .IGC dosyas� gerekli , di�er alanlar bo� b�rak�labilir<br><b> .igc dosyas� olu�turmakla ilgili rehber yaz�y� okumak i�in <a href=http://www.ypforum.com/viewtopic.php?t=226 target=_blank >T�klay�n</a></b>)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","IGC dosyas�n� se�iniz");
define("_NOTE_TAKEOFF_NAME","<font size=1>Kalk�� Pistinin ad�n� veya �lkeyi yazabilirsiniz</font>");
define("_COMMENTS_FOR_THE_FLIGHT","U�u� yorumlar�");
define("_PHOTO","Foto�raf");
define("_PHOTOS_GUIDELINES","Foto�raflar JPG ve belrtilen boyuttan k���k olmal� ->");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","Kayd� G�nder");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","Birden fazla u�u� kayd� girmek istiyormusunuz ?");
define("_PRESS_HERE","Buraya t�klay�n");

define("_IS_PRIVATE","Herkese a��k olmas�n");
define("_MAKE_THIS_FLIGHT_PRIVATE","Herkese a��k olmas�n");
define("_INSERT_FLIGHT_AS_USER_ID","U�u�u kullan�c� ID (kimligi) olarak gir");
define("_FLIGHT_IS_PRIVATE","Bu u�u� �zeldir");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","U�u� kayd�n� d�zenle");
define("_IGC_FILE_OF_THE_FLIGHT","U�u�un IGC dosyas�");
define("_DELETE_PHOTO","Sil");
define("_NEW_PHOTO","Yeni foto�raf");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","U�u� bilgilerini de�i�tirmek i�in buraya t�klay�n�z");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","De�i�iklikler kaydedildi");
define("_RETURN_TO_FLIGHT","U�u�a d�n");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","U�u�a d�n");
define("_READY_FOR_SUBMISSION","G�nderime haz�r");
define("_OLC_MAP","Harita");
define("_OLC_BARO","BAROMETRE");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","Pilot Profil");
define("_back_to_flights","U�u�lara d�n");
define("_pilot_stats","Pilot istatistikleri");
define("_edit_profile","Profili d�zenle");
define("_flights_stats","U�u�lar�n istatistikleri");
define("_View_Profile","Profil g�r�nt�le");

define("_Personal_Stuff","Ki�isel Bilgiler");
define("_First_Name"," Ad");
define("_Last_Name","Soyad");
define("_Birthdate","Do�um Tarihi");
define("_dd_mm_yy","gg.aa.yy");
define("_Sign","Bur�");
define("_Marital_Status","Evlilik Durumu");
define("_Occupation","Meslek");
define("_Web_Page","Web Sayfas�");
define("_N_A","N/A");
define("_Other_Interests","Di�er ilgi alanlar�");
define("_Photo","Foto�raf");

define("_Flying_Stuff","U�u� Bilgileri");
define("_note_place_and_date","yazabildi�iniz kadar doldurunuz");
define("_Flying_Since","U�u�a Ba�lang�� Y�l�");
define("_Pilot_Licence","Pilot Lisans�");
define("_Paragliding_training","E�itim al�nan yer");
define("_Favorite_Location","En sevdi�i u�u� b�lgesi");
define("_Usual_Location","Genelde u�tu�u yer");
define("_Best_Flying_Memory","En iyi u�u� hat�ras�");
define("_Worst_Flying_Memory","En k�t� u�u� hat�ras�");
define("_Personal_Distance_Record","Ki�isel Mesafe Rekoru");
define("_Personal_Height_Record","Ki�isel Y�kseklik rekoru");
define("_Hours_Flown","U�ulan saatler (genelde)");
define("_Hours_Per_Year","Senelik u�ulan saat ortalamasi");

define("_Equipment_Stuff","Malzeme Bilgileri");
define("_Glider","Kanat");
define("_Harness","Harnes");
define("_Reserve_chute","Yedek Para��t");
define("_Camera","Foto�raf Makinas�");
define("_Vario","Vario");
define("_GPS","GPS");
define("_Helmet","Kask");
define("_Camcorder","Video Kamera");

define("_Manouveur_Stuff","SIV Bilgileri");
define("_note_max_descent_rate","yap�ld� / yap�lmad� �eklinde yaz�n�z ");
define("_Spiral","Spiral");
define("_Bline","B-line");
define("_Full_Stall","Full Stall");
define("_Other_Manouveurs_Acro","Di�er Akrobasi hareketleri");
define("_Sat","Sat");
define("_Asymmetric_Spiral","Asimetrik Spiral");
define("_Spin","Spin");

define("_General_Stuff","Genel Bilgiler");
define("_Favorite_Singer","Favori �ark�c�s�");
define("_Favorite_Movie","Favori Filmi");
define("_Favorite_Internet_Site","Favori<br>Internet Sitesi");
define("_Favorite_Book","Favori Kitab�");
define("_Favorite_Actor","Favori Akt�r�");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","Yeni bir foto�raf ekle veya de�i�tir");
define("_Delete_Photo","Foto�raf� sil");
define("_Your_profile_has_been_updated","Profiliniz g�ncellendi");
define("_Submit_Change_Data","G�nder - Bilgi de�i�tir");

//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","ss:dd");

define("_Totals","Toplamlar");
define("_First_flight_logged","�lk U�u� Kayd�");
define("_Last_flight_logged","Son u�u� kayd�");
define("_Flying_period_covered","Ucus d�nemi dahildir ");
define("_Total_Distance","Toplam Mesafe");
define("_Total_OLC_Score","Toplam OLC puan");
define("_Total_Hours_Flown","Toplam u�u� saati");
define("_Total_num_of_flights","Toplam u�u� say�s� ");

define("_Personal_Bests","Ki�isel 'En iyi' leri");
define("_Best_Open_Distance","En iyi a��k mesafe");
define("_Best_FAI_Triangle","En iyi FAI ��gen u�u�u");
define("_Best_Free_Triangle","En iyi serbest ��gen u�u�u");
define("_Longest_Flight","En uzun U�u�");
define("_Best_OLC_score","En iyi OLC puan�");

define("_Absolute_Height_Record","En Yuksek ��k�lan Irtifa Rekoru");
define("_Altitute_gain_Record","En fazla kazan�lan irtifa rekoru");
define("_Mean_values","Ortalama De�erler");
define("_Mean_distance_per_flight","U�u� Ba��na Ortalama Mesafe");
define("_Mean_flights_per_Month","Ay ba��na u�ulan ortalama mesafe");
define("_Mean_distance_per_Month","Ay ba��na u�ulan ortalama mesafe");
define("_Mean_duration_per_Month","Ay ba��na u�ulan ortalama mesafe");
define("_Mean_duration_per_flight","U�u� Ba��na ortalama s�re");
define("_Mean_flights_per_Year","Senelik ortalama u�u� say�s�");
define("_Mean_distance_per_Year","Senelik ortalama u�ulan mesafe");
define("_Mean_duration_per_Year","Senelik ortalama u�ulan s�re");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","Bu b�lgeye yak�n u�u�lara bak�n�z");
define("_Waypoint_Name","Waypoint ismi");
define("_Navigate_with_Google_Earth","Google Earth ile U�u�unuzu �zleyiniz");
define("_See_it_in_Google_Maps","Google Maps ile U�tu�unuz yere bak�n�z");
define("_See_it_in_MapQuest","MapQuest ile U�tu�unuz yere bak�n�z");
define("_COORDINATES","Koordinatlar");
define("_FLIGHTS","U�u�lar");
define("_SITE_RECORD","B�lge Rekoru");
define("_SITE_INFO","B�lge Bilgileri");
define("_SITE_REGION","B�lge");
define("_SITE_LINK","Daha fazla bilgi i�in link");
define("_SITE_DESCR","B�lge/Kalk�� Pisti A��klamas�");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","Daha Fazla Detay");
define("_KML_file_made_by","KML dosyas� olu�turulma");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","Kalk�� Pistini Kay�t Et");
define("_WAYPOINT_ADDED","Kalk�� Pisti kay�t edildi");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","En iyi Mesafesi<br>(A��k Mesafe)");

//--------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","U�u� arac�");
function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'Yama�para��t�',2=>'YelkenKanat (esnek)',4=>'YelkenKanat (sert)',8=>'Plan�r'); 
	foreach ($CONF_glider_types as $gId=>$gName) if (!$gliderCatList[$gId]) $gliderCatList[$gId]=$gName;
}
setGliderCats();


//--------------------------------------------
// class types
//--------------------------------------------
function setClassList() {
	$CONF_TEMP['gliderClasses'][1]['classes']=array(1=>"Spor",2=>"Acik",3=>"Tandem");
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

define("_Your_settings_have_been_updated","Ayarlar�n�z Kay�t Edildi");

define("_THEME","Tema");
define("_LANGUAGE","Dil");
define("_VIEW_CATEGORY","Kategori");
define("_VIEW_COUNTRY","�lke");
define("_UNITS_SYSTEM" ,"Mesafe Birimi");
define("_METRIC_SYSTEM","Metric (km,m)");
define("_IMPERIAL_SYSTEM","Imperial (miles,feet)");
define("_ITEMS_PER_PAGE","Sayfa Ba��na U�u� G�sterim Adedi");

define("_MI","mi");
define("_KM","km");
define("_FT","ft");
define("_M","m");
define("_MPH","mph");
define("_KM_PER_HR","km/s");
define("_FPM","fpm");
define("_M_PER_SEC","m/san");

//--------------------------------------------
// index page
//--------------------------------------------

define("_WORLD_WIDE","D�nya");
define("_National_XC_Leagues_for","Ulusal XC Lig ");
define("_Flights_per_Country","�lke Ba��na U�u�lar");
define("_Takeoffs_per_Country","�lke Ba��na Kalk�� Pistleri");
define("_INDEX_HEADER","Leonardo XC Ligine Ho�geldiniz");
define("_INDEX_MESSAGE","&quot;Ana Men�y�&quot; kullanarak u�u�lara bakabilirsiniz..");

//--------------------------------------------
// NEW 
//--------------------------------------------
define("_MENU_SUMMARY_PAGE","Ana Sayfa");
define("_Display_ALL","Hepsini G�ster");
define("_Display_NONE","Hi�birini G�sterme");
define("_Reset_to_default_view","Varsay�lan G�r�n�me D�n");
define("_No_Club","Kul�p Yok");
define("_This_is_the_URL_of_this_page","Bu, bu sayfan�n adresidir ");
define("_All_glider_types","T�m U�u� Aletleri");

define("_MENU_SITES_GUIDE","U�u� B�lgeleri Rehberi");
define("_Site_Guide","Site Kullan�m Rehberi");

define("_Search_Options","Arama Ayarlar�");
define("_Below_is_the_list_of_selected_sites","Se�ilen B�lgeler");
define("_Clear_this_list","Listeyi Temizle");
define("_See_the_selected_sites_in_Google_Earth","Se�ilen Kalk�� Pistlerini Google Earth de G�ster");
define("_Available_Takeoffs","Uygun Kalk�� Pistleri");
define("_Search_site_by_name","Kalk�� Pisti Arama");
define("_give_at_least_2_letters","En az 2 karekter giriniz");
define("_takeoff_move_instructions_1","T�m se�ili kalk�� pistlerini >> e t�klayarak sa� panele alabilirsiniz veya > Karekterine t�klayarak tek tek alabilirsiniz");
define("_Takeoff_Details","Kalk�� Pisti Detaylar�");

define("_Takeoff_Info","Kalk�� Pisti Bilgileri");
define("_XC_Info","XC Bilgi");
define("_Flight_Info","U�u� Bilgi");

define("_MENU_LOGOUT","��k��");
define("_MENU_LOGIN","Giri� Yap");
define("_MENU_REGISTER","Kay�t Ol");


define("_Africa","Afrika");
define("_Europe","Avrupa");
define("_Asia","Asya");
define("_Australia","Avusturalya");
define("_North_Central_America","Kuzey Amerika");
define("_South_America","G�ney Amerika");

define("_Recent","Son G�nderilen");


define("_Unknown_takeoff","Bilinmeyen Kalk�� Pisti");
define("_Display_on_Google_Earth","Google Earth de G�ster");
define("_Use_Man_s_Module","Use Man's Module");
define("_Line_Color","�izgi Rengi");
define("_Line_width","�izgi Kal�nl���");
define("_unknown_takeoff_tooltip_1","Bu u�u� bilinmeyen kalk�� pistine ait");
define("_unknown_takeoff_tooltip_2","E�er Kalk��/ini� b�lgesini biliyorsan�z kay�t etmek i�in l�tfen t�klay�n ve bilgileri girin.");
define("_EDIT_WAYPOINT","Kalk�� Pisti Bilgilerini D�zenle");
define("_DELETE_WAYPOINT","Kalk�� Pistini Sil");
define("_SUBMISION_DATE","Siteye Kay�t Tarihi"); // the date a flight was submited to leonardo
define("_TIMES_VIEWED","�zlenme Say�s�"); // the times that this flight have been viewed


define("_takeoff_add_help_1","E�er kalk�� pistinin bilgilerini biliyorsan�z bilgileri girebilirsiniz , bilmiyorsan�z OK e t�klayarak pencereyi kapat�n.");
define("_takeoff_add_help_2","Eger yukar�da sizin kalk�� noktan�z ' bilinmeyen kalk�� pisti ' olarak gosteriliyorsa , tekrar bunu girmenize gerek yok. sadece pencereyi kapat�n yeter ");
define("_takeoff_add_help_3","E�er kalk�� noktas� ad�n� a�a��da g�r�yorsan�z soldaki bo� alana otomatik olarak yaz�lmasi i�in �zerine t�klay�n.");
define("_Takeoff_Name","Kalk�� Pisti Ad�");
define("_In_Local_Language","T�rk�e");
define("_In_English","�ngilizce");

// New on 2007/02/20 - login screen
define("_ENTER_PASSWORD","Giri� yapmak i�in kullan�c� ad�n�z� ve �ifrenizi giriniz.");
define("_SEND_PASSWORD","�ifremi unuttum");
define("_ERROR_LOGIN","Yanl�� kullan�c� ad� veya �ifre girdiniz");
define("_AUTO_LOGIN","Beni Hat�rla");
define("_USERNAME","Kullan�c� Ad�");
define("_PASSWORD","�ifre");
define("_PROBLEMS_HELP","Giri� yaparken sorun ya��yorsan�z admin ile irtibata ge�iniz");

define("_LOGIN_TRY_AGAIN","%sBuraya%s t�klayarak tekrar deneyebilirsiniz");
define("_LOGIN_RETURN","%sBuraya%s t�klayarak Ana Sayfaya d�nebilirsiniz");
// end 2007/02/20

define("_Category","Kategori");
define("_MEMBER_OF","Kullan�c�");
define("_MemberID","Kullan�c� ID");
define("_EnterID","ID Gir");
define("_Clubs_Leagues","Kul�p / Lig");
define("_Pilot_Statistics","Pilot �statistikleri");
define("_National_Rankings","Ulusal S�ralamalar");




// new on 2007/03/08
define("_Select_Club","Kul�p Se�");
define("_Close_window","Pencereyi Kapat");
define("_EnterID","ID Gir");
define("_Club","Kul�p");
define("_Sponsor","Sponsor");


// new on 2007/03/13
define('_Go_To_Current_Month','Bulundu�un tarihe d�n');
define('_Today_is','Bug�n - ');
define('_Wk','Wk');
define('_Click_to_scroll_to_previous_month','Click to scroll to previous month. Hold mouse button to scroll automatically.');
define('_Click_to_scroll_to_next_month','Click to scroll to next month. Hold mouse button to scroll automatically.');
define('_Click_to_select_a_month','Ay se�mek i�in t�klay�n.');
define('_Click_to_select_a_year','Y�l se�mek i�in t�klay�n.');
define('_Select_date_as_date.',' [date] tarih olarak se�in'); // do not replace [date], it will be replaced by date.

// end 2007/03/13

//--------------------------------------------------------
//--------------------------------------------------------
// Missing defines , autoreplaced values from 'english' 
//--------------------------------------------------------
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","U�u�unuz bir ka� dakika sonra aktif olacakt�r. "); 
define("_SEASON","Sezon"); 
define("_CATEGORY_TOTAL_DURATION","Category 'DURACELL' - Ucu�lar�n toplam 
s�resi"); 
define("_SUBMIT_TO_OLC","OLC ye g�nder"); 
define("_pilot_email","Email Adres"); 
define("_Sex","Cinsiyet"); 
define("_Login_Stuff","De�i�tir Giri�-Data"); 
define("_PASSWORD_CONFIRMATION","�ifreyi do�rulama"); 
define("_EnterPasswordOnlyToChange","De�i�tirmek istiyorsan�z sadece �ifreyi giriniz:"); 
define("_PwdAndConfDontMatch","�ifre ve �ifreyi do�rulama alanlar� uyu�muyor."); 
define("_PwdTooShort","�ifre �ok k�sa. �ifreniz $passwordMinLength karekterden fazla olmal�."); 
define("_PwdConfEmpty","�ifre do�ruland�."); 
define("_PwdChanged","�ifre de�i�ti."); 
define("_PwdNotChanged","�ifre de�i�medi."); 
define("_PwdChangeProblem","�ifre de�i�tirirken problem olu�tu."); 
define("_EmailEmpty","Email alan� bo� olamaz."); 
define("_EmailInvalid","Email hatal�."); 
define("_EmailSaved","Bu Email adresi �nceden sistemde kay�tl�"); 
define("_EmailNotSaved","Email adresi kay�t edilmedi."); 
define("_EmailSaveProblem","Email i kay�t ederken problem olu�tu."); 
define("_PROJECT_HELP","Yard�m"); 
define("_PROJECT_NEWS","Haberler"); 
define("_PROJECT_RULES","2007 D�zenlemeler"); 
define("_Filter_NoSelection","Se�im yap�lmam��"); 
define("_Filter_CurrentlySelected","Se�ilenler"); 
define("_Filter_DialogMultiSelectInfo","Ctrl ye bas�l� tutarak birdn fazla se�im yapabilirsiniz."); 
define("_Filter_FilterTitleIncluding","Se�ilenler [items]"); 
define("_Filter_FilterTitleExcluding","��kar [items]"); 
define("_Filter_DialogTitleIncluding","Se� [items]"); 
define("_Filter_DialogTitleExcluding","Se� [items]"); 
define("_Filter_Items_pilot","pilotlar"); 
define("_Filter_Items_nacclub","kul�b"); 
define("_Filter_Items_country","�lkeler"); 
define("_Filter_Items_takeoff","kalk�� pistleri"); 
define("_Filter_Button_Select","Se�"); 
define("_Filter_Button_Delete","Sil"); 
define("_Filter_Button_Accept","Se�imi kaydet"); 
define("_Filter_Button_Cancel","�ptal"); 
define("_MENU_FILTER_NEW","Filter **Yeni Versiyon**"); 
define("_ALL_NACCLUBS","T�m Kul�pler"); 
define("_SELECT_NACCLUB","Se�, [nacname]-Kul�b"); 
define("_FirstOlcYear","First year of participation in an online XC contest"); 
define("_FirstOlcYearComment","Please select the year of your first participation in any online XC contest, not just this one.<br/>This field is relevant for the &quot;newcomer&quot;-rankings."); 
define("_Select_Brand","Marka Se�"); 
define("_All_Brands","T�m Markalar"); 
define("_DAY","G�n"); 
define("_Glider_Brand","Marka"); 
define("_Or_Select_from_previous","ya da �ncekinden se�"); 
define("_Explanation_AddToBookmarks_IE","Bu filtre ayarlar�n� favorilerinize ekleyin"); 
define("_Msg_AddToBookmarks_IE","Bookmarks a bu filtre ayarlar�n� ekleyin"); 
define("_Explanation_AddToBookmarks_nonIE","(Bookmarks a bu linki kaydedin)"); 
define("_Msg_AddToBookmarks_nonIE","To save these filter settings to your bookmarks, use the function Save to bookmarks of your browser."); 
define("_PROJECT_RULES2","2008 D�zenlemeler"); 
define("_MEAN_SPEED1","Ortalama H�z"); 
define("_External_Entry","Ba�ka site girdisi"); 
define("_Altitude","Y�kseklik"); 
define("_Speed","H�z"); 
define("_Distance_from_takeoff","Kalk�� pistine olan mesafe"); 
define("_LAST_DIGIT",",son rakam�n� gizle"); 
define("_Filter_Items_nationality","ulus"); 
define("_Filter_Items_server","server"); 
define("_Ext_text1","Bu u�u�un orjinal adresi "); 
define("_Ext_text2","U�u�un t�m detaylar� i�in t�klay�n"); 
define("_Ext_text3","U�u�un orjinal linki");

// New on 2008/2/15
define('_Male_short','E');
define('_Female_short','K');
define('_Male','Erkek');
define('_Female','Kad�n');
define('_Pilot_Statistics','Pilot �statistikleri');

//--------------------------------------------------------
//--------------------------------------------------------
// Missing defines , autoreplaced values from 'english' 
//--------------------------------------------------------
define("_Altitude_Short","Alt"); 
define("_Vario_Short","Vario"); 
define("_Time_Short","S�re"); 
define("_Info","Bilgi"); 
define("_Control","Kontrol"); 
define("_Zoom_to_flight","U�u�a zoom"); 
define("_Follow_Glider","Kanad� izle"); 
define("_Show_Task","Task G�ster"); 
define("_Show_Airspace","Airspace G�ster"); 
define("_Thermals","Thermals"); 
define("_Show_Optimization_details","Show Optimization Details"); 
define("_MENU_SEARCH_PILOTS","Ara"); 
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
define("_Start_type","Kalk�� Tipi"); 
define("_GLIDER_CERT","Kanat Sertifikasyon"); 
define("_MENU_BROWSER","Google Map de g�r�nt�leme"); 
define("_FLIGHT_BROSWER","Search the flights and takeoff database with Google Maps"); 
define("_Load_Thermals","Load Thermals"); 
define("_Loading_thermals","Loading Thermals"); 
define("_Layers","Layers"); 
define("_Select_Area","B�lge Se�"); 


define("_BREAKDOWN_PER_TAKEOFF","Breakdown Per Takeoff");
define("_BREAKDOWN_PER_GLIDER","Breakdown Per Glider");
?>

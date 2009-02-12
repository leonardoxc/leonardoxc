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
	$monthList=array('Ocak','Şubat','Mart','Nisan','Mayıs','Haziran',
				'Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık');
	$monthListShort=array('OCK','ŞBT','MRT','NSN','MYS','HZR','TMZ','AĞU','EYL','EKM','KSM','ARL');
	$weekdaysList=array('Pzr','Pzts','Salı','Çrş','Prş','Cuma','Cmrt') ;
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","Serbest uçuş");
define("_FREE_TRIANGLE","Serbest üçgen uçuşu");
define("_FAI_TRIANGLE","FAI üçgen uçuşu");

define("_SUBMIT_FLIGHT_ERROR","Uçuş bilgilerini gönderirken hata oluştu");

// list_pilots()
define("_NUM","#");
define("_PILOT","Pilot");
define("_NUMBER_OF_FLIGHTS","Uçuş Sayısı");
define("_BEST_DISTANCE","En iyi mesafe");
define("_MEAN_KM","Uçuş başına ortalama kilometre");
define("_TOTAL_KM","Toplam Uçuş km");
define("_TOTAL_DURATION_OF_FLIGHTS","Toplam Uçuş Süresi");
define("_MEAN_DURATION","Ortalama Uçuş Süresi");
define("_TOTAL_OLC_KM","Toplam OLC mesafesi");
define("_TOTAL_OLC_SCORE","Toplam OLC puanı");
define("_BEST_OLC_SCORE","En iyi OLC puanı");
define("_From","de");

// list_flights()
define("_DURATION_HOURS_MIN","Süre (ss:dd)");
define("_SHOW","Göster");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","Uçuş Kaydınız 1-2 dakika içinde aktif 
olacaktır. ");
define("_TRY_AGAIN","Lütfen az sonra tekrar deneyin");

define("_TAKEOFF_LOCATION","Kalkış");
define("_TAKEOFF_TIME","Kalkış Zamanı");
define("_LANDING_LOCATION","İniş");
define("_LANDING_TIME","İniş Zamanı");
define("_OPEN_DISTANCE","Doğrusal Mesafe");
define("_MAX_DISTANCE","Maksimum Mesafe");
define("_OLC_SCORE_TYPE","OLC puan Çeşidi");
define("_OLC_DISTANCE","OLC mesafe");
define("_OLC_SCORING","OLC puan");
define("_MAX_SPEED","Maksimum hız");
define("_MAX_VARIO","Maksimum vario");
define("_MEAN_SPEED","Ortalama hız");
define("_MIN_VARIO","Minimum vario");
define("_MAX_ALTITUDE","Çıkılan En yüksek irtifa");
define("_TAKEOFF_ALTITUDE","Kalkış Pistinin Deniz Seviyesinden Yüksekliği");
define("_MIN_ALTITUDE","En düşük irtifa ");
define("_ALTITUDE_GAIN","Kazanılan irtifa");
define("_FLIGHT_FILE","Uçuş dosyası");
define("_COMMENTS","Yorumlar");
define("_RELEVANT_PAGE","İlgili adres");
define("_GLIDER","Kanat");
define("_PHOTOS","Fotoğraf");
define("_MORE_INFO","Ekstra");
define("_UPDATE_DATA","Veriyi Güncelle");
define("_UPDATE_MAP","Haritayı güncelle");
define("_UPDATE_3D_MAP","3D haritayı güncelle");
define("_UPDATE_GRAPHS","Grafikleri Güncelle");
define("_UPDATE_SCORE","Puanı güncelle");

define("_TAKEOFF_COORDS","Kalkış Pisti koordinatları:");
define("_NO_KNOWN_LOCATIONS","Uçuş bölgeleri bilinmemekte!");
define("_FLYING_AREA_INFO","Flying area info");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo XC");
define("_RETURN_TO_TOP","En Başa dön");
// list flight
define("_PILOT_FLIGHTS","Pilot'un uçuşları");

define("_DATE_SORT","Tarih");
define("_PILOT_NAME","Pilot ismi");
define("_TAKEOFF","Kalkış Pisti");
define("_DURATION","Süre");
define("_LINEAR_DISTANCE","Açık Mesafe");
define("_OLC_KM","OLC km.");
define("_OLC_SCORE","OLC puan");
define("_DATE_ADDED","En son Kaydedilen ucuslar");

define("_SORTED_BY","Sıralama Biçimi:");
define("_ALL_YEARS","Tüm Yıllar");
define("_SELECT_YEAR_MONTH","Yıl / ay seç");
define("_ALL","Hepsi");
define("_ALL_PILOTS","Tüm Pilotları göster");
define("_ALL_TAKEOFFS","Tüm kalkış pistlerini göster");
define("_ALL_THE_YEAR","Tüm yıl");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","Bir uçuş dosyası göndermediniz");
define("_NO_SUCH_FILE","Gönderdiğiniz dosya sitede bulunamıyor");
define("_FILE_DOESNT_END_IN_IGC","Dosya IGC uzantılı değil");
define("_THIS_ISNT_A_VALID_IGC_FILE","Bu geçerli bir IGC dosyası değil");
define("_THERE_IS_SAME_DATE_FLIGHT","Aynı gün ve tarihte zaten başka bir uçuş kayıtlı");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","Değiştirmek istiyorsanız önce eskisini silmelisiniz");
define("_DELETE_THE_OLD_ONE","Eski bir tane sil");
define("_THERE_IS_SAME_FILENAME_FLIGHT","Aynı isimde zaten baska bir dosya var");
define("_CHANGE_THE_FILENAME","Bu uçuş baska bir uçuş ise lütfen dosya ismini değistirerek tekrar deneyin");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","Uçuş kaydınız gönderildi");
define("_PRESS_HERE_TO_VIEW_IT","Görmek için buraya tıklayın");
define("_WILL_BE_ACTIVATED_SOON","(Uçuş kaydınız 1-2 dakika içinde aktif olacaktır)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Birden fazla uçuş kaydı gönder");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED",".zip dosyasının içindeki sadece .igc dosyaları işlenir.");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","Uçuşları içeren<br>zip dosyası gönder");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","Göndermek İçin Tıklayın");

define("_FILE_DOESNT_END_IN_ZIP","Yüklediğiniz dosya ZIP uzantısı değil");
define("_ADDING_FILE","Dosya gönderiliyor");
define("_ADDED_SUCESSFULLY","Başarıyla gönderildi");
define("_PROBLEM","Problem");
define("_TOTAL","Toplam da ");
define("_IGC_FILES_PROCESSED","Uçuşlar İşleniyor");
define("_IGC_FILES_SUBMITED","Uçuşlar gönderildi");

// info
define("_DEVELOPMENT","Geliştirme");
define("_ANDREADAKIS_MANOLIS","Andreadakis Manolis");
define("_PROJECT_URL","Proje sayfası");
define("_VERSION","Versiyon");
define("_MAP_CREATION","Harita yapımı");
define("_PROJECT_INFO","Proje bilgisi");

// menu bar
define("_MENU_MAIN_MENU","Ana Menü");
define("_MENU_DATE","Tarih Seç");
define("_MENU_COUNTRY","Ülke Seç");
define("_MENU_XCLEAGUE","XC Lig");
define("_MENU_ADMIN","Admin");

define("_MENU_COMPETITION_LEAGUE","XC Lig - Tüm Kategoriler");
define("_MENU_OLC","OLC");
define("_MENU_OPEN_DISTANCE","Açık Mesafe");
define("_MENU_DURATION","Süre");
define("_MENU_ALL_FLIGHTS","Tüm Uçuşlar");
define("_MENU_FLIGHTS","Uçuşlar");
define("_MENU_TAKEOFFS","Kalkış Pistleri");
define("_MENU_FILTER","Süzgeç");
define("_MENU_MY_FLIGHTS","Uçuşlarım");
define("_MENU_MY_PROFILE","Pilot Profilim");
define("_MENU_MY_STATS","İstatistiklerim");
define("_MENU_MY_SETTINGS","Ayarlarım"); 
define("_MENU_SUBMIT_FLIGHT","Uçuş Kaydı Gönder");
define("_MENU_SUBMIT_FROM_ZIP","ZIP dosyasıyla gönder");
define("_MENU_SHOW_PILOTS","Pilotlar");
define("_MENU_SHOW_LAST_ADDED","En Son Yüklenenler");
define("_FLIGHTS_STATS","Uçuş İstatistikleri");

define("_SELECT_YEAR","Yıl Seç");
define("_SELECT_MONTH","Ay Seç");
define("_ALL_COUNTRIES","Tüm Ülkeleri Göster");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","Tüm Zamanlar");
define("_NUMBER_OF_FLIGHTS","Uçuş Sayısı");
define("_TOTAL_DISTANCE","Toplam Mesafe");
define("_TOTAL_DURATION","Toplam Süre");
define("_BEST_OPEN_DISTANCE","En iyi mesafe");
define("_TOTAL_OLC_DISTANCE","Toplam OLC mesafesi");
define("_TOTAL_OLC_SCORE","Toplam OLC punaıe");
define("_BEST_OLC_SCORE","En iyi OLC punaı");
define("_MEAN_DURATION","Ortamala Süre");
define("_MEAN_DISTANCE","Ortalama Mesafe");
define("_PILOT_STATISTICS_SORT_BY","Pilotlar - Sırala");
define("_CATEGORY_FLIGHT_NUMBER","Kategori 'FastJoe' - Uçuş Sayısı");
define("_CATEGORY_TOTAL_DURATION","Kategori 'DURACELL' - Ucuşların toplam 
süresi");
define("_CATEGORY_OPEN_DISTANCE","Kategori'Açık Mesafe'");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","Gösterilecek pilot yok");


//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","Uçuş kaydı silindi");
define("_RETURN","Geri Dön");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","DIKKAT - Bu uçuş kaydını silmek üzeresiniz");
define("_THE_DATE","Tarih ");
define("_YES","EVET");
define("_NO","HAYIR");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","Lig Sonuçları");
define("_N_BEST_FLIGHTS","En iyi Uçuş");
define("_OLC","OLC");
define("_OLC_TOTAL_SCORE","OLC toplam puan");
define("_KILOMETERS","Kilometreler");
define("_TOTAL_ALTITUDE_GAIN","Toplam Irtifa Kazancı");
define("_TOTAL_KM","Toplam Km");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","is");
define("_IS_NOT","is not");
define("_OR","veya");
define("_AND","ve");
define("_FILTER_PAGE_TITLE","Uçuşları filtrele");
define("_RETURN_TO_FLIGHTS","Uçuşlara dön");
define("_THE_FILTER_IS_ACTIVE","Filtre açık");
define("_THE_FILTER_IS_INACTIVE","Filtre kapalı");
define("_SELECT_DATE","Tarih seç");
define("_SHOW_FLIGHTS","Uçuşları göster");
define("_ALL2","HEPSI");
define("_WITH_YEAR","Yıl ile");
define("_MONTH","Ay");
define("_YEAR","Yıl");
define("_FROM","From");
define("_from","from");
define("_TO","bitiş");
define("_SELECT_PILOT","Pilot Seç");
define("_THE_PILOT","Pilot");
define("_THE_TAKEOFF","Kalkış pisti");
define("_SELECT_TAKEOFF","Kalkış pisti seç");
define("_THE_COUNTRY","Ülke");
define("_COUNTRY","Ülke");
define("_SELECT_COUNTRY","Ülke Seç");
define("_OTHER_FILTERS","Diğer filtreler");
define("_LINEAR_DISTANCE_SHOULD_BE","Kuş Uçuşu Mesafe");
define("_OLC_DISTANCE_SHOULD_BE","Kuş Uçuşu Mesafe");
define("_OLC_SCORE_SHOULD_BE","OLC Puani");
define("_DURATION_SHOULD_BE","Mesafe");
define("_ACTIVATE_CHANGE_FILTER","Aktif / filtre değiştir");
define("_DEACTIVATE_FILTER","Filtre kapalı");
define("_HOURS","saatler");
define("_MINUTES","dakika");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","Uçuş Kaydı Gönder");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(Sadece .IGC dosyası gerekli , diğer alanlar boş bırakılabilir<br><b> .igc dosyası oluşturmakla ilgili rehber yazıyı okumak için <a href=http://www.ypforum.com/viewtopic.php?t=226 target=_blank >Tıklayın</a></b>)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","IGC dosyasını seçiniz");
define("_NOTE_TAKEOFF_NAME","<font size=1>Kalkış Pistinin adını veya ülkeyi yazabilirsiniz</font>");
define("_COMMENTS_FOR_THE_FLIGHT","Uçuş yorumları");
define("_PHOTO","Fotoğraf");
define("_PHOTOS_GUIDELINES","Fotoğraflar JPG ve belrtilen boyuttan küçük olmalı ->");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","Kaydı Gönder");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","Birden fazla uçuş kaydı girmek istiyormusunuz ?");
define("_PRESS_HERE","Buraya tıklayın");

define("_IS_PRIVATE","Herkese açık olmasın");
define("_MAKE_THIS_FLIGHT_PRIVATE","Herkese açık olmasın");
define("_INSERT_FLIGHT_AS_USER_ID","Uçuşu kullanıcı ID (kimligi) olarak gir");
define("_FLIGHT_IS_PRIVATE","Bu uçuş özeldir");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","Uçuş kaydını düzenle");
define("_IGC_FILE_OF_THE_FLIGHT","Uçuşun IGC dosyası");
define("_DELETE_PHOTO","Sil");
define("_NEW_PHOTO","Yeni fotoğraf");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","Uçuş bilgilerini değiştirmek için buraya tıklayınız");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","Değişiklikler kaydedildi");
define("_RETURN_TO_FLIGHT","Uçuşa dön");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","Uçuşa dön");
define("_READY_FOR_SUBMISSION","Gönderime hazır");
define("_OLC_MAP","Harita");
define("_OLC_BARO","BAROMETRE");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","Pilot Profil");
define("_back_to_flights","Uçuşlara dön");
define("_pilot_stats","pilot istatistikleri");
define("_edit_profile","Profili düzenle");
define("_flights_stats","Uçuşların istatistikleri");
define("_View_Profile","Profil görüntüle");

define("_Personal_Stuff","Kişisel Bilgiler");
define("_First_Name"," Ad");
define("_Last_Name","Soyad");
define("_Birthdate","Doğum Tarihi");
define("_dd_mm_yy","gg.aa.yy");
define("_Sign","Burç");
define("_Marital_Status","Evlilik Durumu");
define("_Occupation","Meslek");
define("_Web_Page","Web Sayfası");
define("_N_A","N/A");
define("_Other_Interests","Diğer ilgi alanları");
define("_Photo","Fotoğraf");

define("_Flying_Stuff","Uçuş Bilgileri");
define("_note_place_and_date","yazabildiğiniz kadar doldurunuz");
define("_Flying_Since","Uçuşa Başlangıç Yılı");
define("_Pilot_Licence","Pilot Lisansı");
define("_Paragliding_training","Eğitim alınan yer");
define("_Favorite_Location","En sevdiği uçuş bölgesi");
define("_Usual_Location","Genelde uçtuğu yer");
define("_Best_Flying_Memory","En iyi uçuş hatırası");
define("_Worst_Flying_Memory","En kötü uçuş hatırası");
define("_Personal_Distance_Record","Kişisel Mesafe Rekoru");
define("_Personal_Height_Record","Kişisel Yükseklik rekoru");
define("_Hours_Flown","Uçulan saatler (genelde)");
define("_Hours_Per_Year","Senelik uçulan saat ortalamasi");

define("_Equipment_Stuff","Malzeme Bilgileri");
define("_Glider","Kanat");
define("_Harness","Harnes");
define("_Reserve_chute","Yedek Paraşüt");
define("_Camera","Fotoğraf Makinası");
define("_Vario","Vario");
define("_GPS","GPS");
define("_Helmet","Kask");
define("_Camcorder","Video Kamera");

define("_Manouveur_Stuff","SIV Bilgileri");
define("_note_max_descent_rate","yapıldı / yapılmadı şeklinde yazınız ");
define("_Spiral","Spiral");
define("_Bline","B-line");
define("_Full_Stall","Full Stall");
define("_Other_Manouveurs_Acro","Diğer Akrobasi hareketleri");
define("_Sat","Sat");
define("_Asymmetric_Spiral","Asimetrik Spiral");
define("_Spin","Spin");

define("_General_Stuff","Genel Bilgiler");
define("_Favorite_Singer","Favori şarkıcısı");
define("_Favorite_Movie","Favori Filmi");
define("_Favorite_Internet_Site","Favori<br>Internet Sitesi");
define("_Favorite_Book","Favori Kitabı");
define("_Favorite_Actor","Favori Aktörü");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","Yeni bir fotoğraf ekle veya değiştir");
define("_Delete_Photo","Fotoğrafı sil");
define("_Your_profile_has_been_updated","Profiliniz güncellendi");
define("_Submit_Change_Data","Gönder - Bilgi değiştir");

//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","ss:dd");

define("_Totals","Toplamlar");
define("_First_flight_logged","İlk Uçuş Kaydı");
define("_Last_flight_logged","Son uçuş kaydı");
define("_Flying_period_covered","Ucus dönemi dahildir ");
define("_Total_Distance","Toplam Mesafe");
define("_Total_OLC_Score","Toplam OLC puan");
define("_Total_Hours_Flown","Toplam uçuş saati");
define("_Total_num_of_flights","Toplam uçuş sayısı ");

define("_Personal_Bests","Kişisel 'En iyi' leri");
define("_Best_Open_Distance","En iyi açık mesafe");
define("_Best_FAI_Triangle","En iyi FAI üçgen uçuşu");
define("_Best_Free_Triangle","En iyi serbest üçgen uçuşu");
define("_Longest_Flight","En uzun Uçuş");
define("_Best_OLC_score","En iyi OLC puanı");

define("_Absolute_Height_Record","En Yuksek Çıkılan Irtifa Rekoru");
define("_Altitute_gain_Record","En fazla kazanılan irtifa rekoru");
define("_Mean_values","Ortalama Değerler");
define("_Mean_distance_per_flight","Uçuş Başına Ortalama Mesafe");
define("_Mean_flights_per_Month","Ay başına uçulan ortalama mesafe");
define("_Mean_distance_per_Month","Ay başına uçulan ortalama mesafe");
define("_Mean_duration_per_Month","Ay başına uçulan ortalama mesafe");
define("_Mean_duration_per_flight","Uçuş Başına ortalama süre");
define("_Mean_flights_per_Year","Senelik ortalama uçuş sayısı");
define("_Mean_distance_per_Year","Senelik ortalama uçulan mesafe");
define("_Mean_duration_per_Year","Senelik ortalama uçulan sğre");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","Bu bölgeye yakın uçuşlara bakınız");
define("_Waypoint_Name","Waypoint ismi");
define("_Navigate_with_Google_Earth","Google Earth ile Uçuşunuzu İzleyiniz");
define("_See_it_in_Google_Maps","Google Maps ile Uçtuğunuz yere bakınız");
define("_See_it_in_MapQuest","MapQuest ile Uçtuğunuz yere bakınız");
define("_COORDINATES","Koordinatlar");
define("_FLIGHTS","Uçuşlar");
define("_SITE_RECORD","Bölge Rekoru");
define("_SITE_INFO","Bölge Bilgileri");
define("_SITE_REGION","Bölge");
define("_SITE_LINK","Daha fazla bilgi için link");
define("_SITE_DESCR","Bölge/Kalkış Pisti Açıklaması");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","Daha Fazla Detay");
define("_KML_file_made_by","KML dosyası oluşturulma");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","Kalkış Pistini Kayıt Et");
define("_WAYPOINT_ADDED","Kalkış Pisti kayıt edildi");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","En iyi Mesafesi<br>(Açık Mesafe)");

//--------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","Uçuş aracı");
function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'Yamaçparaşütü',2=>'YelkenKanat (esnek tip)',4=>'YelkenKanat (sert tip)',8=>'Planör'); 
	foreach ($CONF_glider_types as $gId=>$gName) if (!$gliderCatList[$gId]) $gliderCatList[$gId]=$gName;
}
setGliderCats();

//--------------------------------------------
// user prefs  & units
//--------------------------------------------

define("_Your_settings_have_been_updated","Ayarlarınız Kayıt Edildi");

define("_THEME","Tema");
define("_LANGUAGE","Dil");
define("_VIEW_CATEGORY","Kategori");
define("_VIEW_COUNTRY","Ülke");
define("_UNITS_SYSTEM" ,"Mesafe Birimi");
define("_METRIC_SYSTEM","Metric (km,m)");
define("_IMPERIAL_SYSTEM","Imperial (miles,feet)");
define("_ITEMS_PER_PAGE","Sayfa Başına Uçuş Gösterim Adedi");

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

define("_WORLD_WIDE","Dünya");
define("_National_XC_Leagues_for","Ulusal XC Lig ");
define("_Flights_per_Country","Ülke Başına Uçuşlar");
define("_Takeoffs_per_Country","Ülke Başına Kalkış Pistleri");
define("_INDEX_HEADER","Leonardo XC Ligine Hoşgeldiniz");
define("_INDEX_MESSAGE","&quot;Ana Menüyü&quot; kullanarak uçuşlara bakabilirsiniz..");

//--------------------------------------------
// NEW 
//--------------------------------------------
define("_MENU_SUMMARY_PAGE","Ana Sayfa");
define("_Display_ALL","Hepsini Göster");
define("_Display_NONE","Hiçbirini Gösterme");
define("_Reset_to_default_view","Varsayılan Görünüme Dön");
define("_No_Club","Kulüp Yok");
define("_This_is_the_URL_of_this_page","Bu, bu sayfanın adresidir ");
define("_All_glider_types","Tüm Uçuş Aletleri");

define("_MENU_SITES_GUIDE","Uçuş Bölgeleri Rehberi");
define("_Site_Guide","Site Kullanım Rehberi");

define("_Search_Options","Arama Ayarları");
define("_Below_is_the_list_of_selected_sites","Seçilen Bölgeler");
define("_Clear_this_list","Listeyi Temizle");
define("_See_the_selected_sites_in_Google_Earth","Seçilen Kalkış Pistlerini Google Earth de Göster");
define("_Available_Takeoffs","Uygun Kalkış Pistleri");
define("_Search_site_by_name","Kalkış Pisti Arama");
define("_give_at_least_2_letters","En az 2 karekter giriniz");
define("_takeoff_move_instructions_1","Tüm seçili kalkış pistlerini >> e tıklayarak sağ panele alabilirsiniz veya > Karekterine tıklayarak tek tek alabilirsiniz");
define("_Takeoff_Details","Kalkış Pisti Detayları");

define("_Takeoff_Info","Kalkış Pisti Bilgileri");
define("_XC_Info","XC Bilgi");
define("_Flight_Info","Uçuş Bilgi");

define("_MENU_LOGOUT","Çıkış");
define("_MENU_LOGIN","Giriş Yap");
define("_MENU_REGISTER","Kayıt Ol");


define("_Africa","Afrika");
define("_Europe","Avrupa");
define("_Asia","Asya");
define("_Australia","Avusturalya");
define("_North_Central_America","Kuzey Amerika");
define("_South_America","Güney Amerika");

define("_Recent","Son Gönderilen");


define("_Unknown_takeoff","Bilinmeyen Kalkış Pisti");
define("_Display_on_Google_Earth","Google Earth de Göster");
define("_Use_Man_s_Module","Use Man's Module");
define("_Line_Color","Çizgi Rengi");
define("_Line_width","Çizgi Kalınlığı");
define("_unknown_takeoff_tooltip_1","Bu uçuş bilinmeyen kalkış pistine ait");
define("_unknown_takeoff_tooltip_2","Eğer Kalkış/iniş bölgesini biliyorsanız kayıt etmek için lütfen tıklayın ve bilgileri girin.");
define("_EDIT_WAYPOINT","Kalkış Pisti Bilgilerini Düzenle");
define("_DELETE_WAYPOINT","Kalkış Pistini Sil");
define("_SUBMISION_DATE","Siteye Kayıt Tarihi"); // the date a flight was submited to leonardo
define("_TIMES_VIEWED","İzlenme Sayısı"); // the times that this flight have been viewed


define("_takeoff_add_help_1","Eğer kalkış pistinin bilgilerini biliyorsanız bilgileri girebilirsiniz , bilmiyorsanız OK e tıklayarak pencereyi kapatın.");
define("_takeoff_add_help_2","Eger yukarıda sizin kalkış noktanız ' bilinmeyen kalkış pisti ' olarak gosteriliyorsa , tekrar bunu girmenize gerek yok. sadece pencereyi kapatın yeter ");
define("_takeoff_add_help_3","Eğer kalkış noktası adını aşağıda görüyorsanız soldaki boş alana otomatik olarak yazılmasi için üzerine tıklayın.");
define("_Takeoff_Name","Kalkış Pisti Adı");
define("_In_Local_Language","Türkçe");
define("_In_English","İngilizce");

// New on 2007/02/20 - login screen
define("_ENTER_PASSWORD","Giriş yapmak için kullanıcı adınızı ve şifrenizi giriniz.");
define("_SEND_PASSWORD","Şifremi unuttum");
define("_ERROR_LOGIN","Yanlış kullanıcı adı veya şifre girdiniz");
define("_AUTO_LOGIN","Beni Hatırla");
define("_USERNAME","Kullanıcı Adı");
define("_PASSWORD","Şifre");
define("_PROBLEMS_HELP","Giriş yaparken sorun yaşıyorsanız admin ile irtibata geçiniz");

define("_LOGIN_TRY_AGAIN","%sBuraya%s tıklayarak tekrar deneyebilirsiniz");
define("_LOGIN_RETURN","%sBuraya%s tıklayarak Ana Sayfaya dönebilirsiniz");
// end 2007/02/20

define("_Category","Kategori");
define("_MEMBER_OF","Kullanıcı");
define("_MemberID","Kullanıcı ID");
define("_EnterID","ID Gir");
define("_Clubs_Leagues","Kulüp / Lig");
define("_Pilot_Statistics","Pilot İstatistikleri");
define("_National_Rankings","Ulusal Sıralamalar");




// new on 2007/03/08
define("_Select_Club","Kulüp Seç");
define("_Close_window","Pencereyi Kapat");
define("_EnterID","ID Gir");
define("_Club","Kulüp");
define("_Sponsor","Sponsor");


// new on 2007/03/13
define('_Go_To_Current_Month','Bulunduğun tarihe dön');
define('_Today_is','Bugün - ');
define('_Wk','Wk');
define('_Click_to_scroll_to_previous_month','Click to scroll to previous month. Hold mouse button to scroll automatically.');
define('_Click_to_scroll_to_next_month','Click to scroll to next month. Hold mouse button to scroll automatically.');
define('_Click_to_select_a_month','Ay seçmek için tıklayın.');
define('_Click_to_select_a_year','Yıl seçmek için tıklayın.');
define('_Select_date_as_date.',' [date] tarih olarak seçin'); // do not replace [date], it will be replaced by date.

// end 2007/03/13

//--------------------------------------------------------
//--------------------------------------------------------
// Missing defines , autoreplaced values from 'english' 
//--------------------------------------------------------
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","Uçuşunuz bir kaç dakika sonra aktif olacaktır. "); 
define("_SEASON","Sezon"); 
define("_CATEGORY_TOTAL_DURATION","Category 'DURACELL' - Ucuşların toplam 
süresi"); 
define("_SUBMIT_TO_OLC","OLC ye gönder"); 
define("_pilot_email","Email Adres"); 
define("_Sex","Cinsiyet"); 
define("_Login_Stuff","Değiştir Giriş-Data"); 
define("_PASSWORD_CONFIRMATION","Şifreyi doğrulama"); 
define("_EnterPasswordOnlyToChange","Değiştirmek istiyorsanız sadece şifreyi giriniz:"); 
define("_PwdAndConfDontMatch","Şifre ve şifreyi doğrulama alanları uyuşmuyor."); 
define("_PwdTooShort","Şifre çok kısa. Şifreniz $passwordMinLength karekterden fazla olmalı."); 
define("_PwdConfEmpty","Şifre doğrulandı."); 
define("_PwdChanged","Şifre değişti."); 
define("_PwdNotChanged","Şifre değişmedi."); 
define("_PwdChangeProblem","Şifre değiştirirken problem oluştu."); 
define("_EmailEmpty","Email alanı boş olamaz."); 
define("_EmailInvalid","Email hatalı."); 
define("_EmailSaved","Bu Email adresi önceden sistemde kayıtlı"); 
define("_EmailNotSaved","Email adresi kayıt edilmedi."); 
define("_EmailSaveProblem","Email i kayıt ederken problem oluştu."); 
define("_PROJECT_HELP","Yardım"); 
define("_PROJECT_NEWS","Haberler"); 
define("_PROJECT_RULES","2007 Düzenlemeler"); 
define("_Filter_NoSelection","Seçim yapılmamış"); 
define("_Filter_CurrentlySelected","Seçilenler"); 
define("_Filter_DialogMultiSelectInfo","Ctrl ye basılı tutarak birdn fazla seçim yapabilirsiniz."); 
define("_Filter_FilterTitleIncluding","Seçilenler [items]"); 
define("_Filter_FilterTitleExcluding","Çıkar [items]"); 
define("_Filter_DialogTitleIncluding","Seç [items]"); 
define("_Filter_DialogTitleExcluding","Seç [items]"); 
define("_Filter_Items_pilot","pilotlar"); 
define("_Filter_Items_nacclub","kulüb"); 
define("_Filter_Items_country","ülkeler"); 
define("_Filter_Items_takeoff","kalkış pistleri"); 
define("_Filter_Button_Select","Seç"); 
define("_Filter_Button_Delete","Sil"); 
define("_Filter_Button_Accept","Seçimi kaydet"); 
define("_Filter_Button_Cancel","İptal"); 
define("_MENU_FILTER_NEW","Filter **Yeni Versiyon**"); 
define("_ALL_NACCLUBS","Tüm Kulüpler"); 
define("_SELECT_NACCLUB","Seç, [nacname]-Kulüb"); 
define("_FirstOlcYear","First year of participation in an online XC contest"); 
define("_FirstOlcYearComment","Please select the year of your first participation in any online XC contest, not just this one.<br/>This field is relevant for the &quot;newcomer&quot;-rankings."); 
define("_Select_Brand","Marka Seç"); 
define("_All_Brands","Tüm Markalar"); 
define("_DAY","Gün"); 
define("_Glider_Brand","Marka"); 
define("_Or_Select_from_previous","ya da öncekinden seç"); 
define("_Explanation_AddToBookmarks_IE","Bu filtre ayarlarını favorilerinize ekleyin"); 
define("_Msg_AddToBookmarks_IE","Bookmarks a bu filtre ayarlarını ekleyin"); 
define("_Explanation_AddToBookmarks_nonIE","(Bookmarks a bu linki kaydedin)"); 
define("_Msg_AddToBookmarks_nonIE","To save these filter settings to your bookmarks, use the function Save to bookmarks of your browser."); 
define("_PROJECT_RULES2","2008 Düzenlemeler"); 
define("_MEAN_SPEED1","Ortalama Hız"); 
define("_External_Entry","Başka site girdisi"); 
define("_Altitude","Yükseklik"); 
define("_Speed","Hız"); 
define("_Distance_from_takeoff","Kalkış pistine olan mesafe"); 
define("_LAST_DIGIT",",son rakamını gizle"); 
define("_Filter_Items_nationality","ulus"); 
define("_Filter_Items_server","server"); 
define("_Ext_text1","Bu uçuşun orjinal adresi "); 
define("_Ext_text2","Uçuşun tüm detayları için tıklayın"); 
define("_Ext_text3","Uçuşun orjinal linki");

// New on 2008/2/15
define('_Male_short','E');
define('_Female_short','K');
define('_Male','Erkek');
define('_Female','kadın');
define('_Pilot_Statistics','Pilot Statistics');

//--------------------------------------------------------
//--------------------------------------------------------
// Missing defines , autoreplaced values from 'english' 
//--------------------------------------------------------
define("_CATEGORY_TOTAL_DURATION","Category 'DURACELL' - Total duration of flights"); 
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

?>
<?php
/**************************************************************************/
/* Portuguese language translation by                                     */
/* Paulo Reis   (Paulor100@gmail.com)                                     */
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
	$monthList=array('Janeiro','Fevereiro','Mar�o','Abril','Maio','Junho',
					'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
	$monthListShort=array('JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC');
	$weekdaysList=array('Mon','Tue','Wed','Thu','Fri','Sat','Sun') ;
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","Dist�ncia livre");
define("_FREE_TRIANGLE","Tri�ngulo livre");
define("_FAI_TRIANGLE","Tri�ngulo FAI");

define("_SUBMIT_FLIGHT_ERROR","Ocorreu um problema com o envio do voo");

// list_pilots()
define("_NUM","#");
define("_PILOT","Piloto");
define("_NUMBER_OF_FLIGHTS","N�mero de voos");
define("_BEST_DISTANCE","Melhor dist�ncia");
define("_MEAN_KM","Media # km por voo");
define("_TOTAL_KM","Km Totais voados");
define("_TOTAL_DURATION_OF_FLIGHTS","Dura��o total dos voos");
define("_MEAN_DURATION","Dura��o media dos voos");
define("_TOTAL_OLC_KM","Dist�ncia OLC total");
define("_TOTAL_OLC_SCORE","Pontua��o OLC total");
define("_BEST_OLC_SCORE","Melhor pontua��o OLC");
define("_From","de");

// list_flights()
define("_DURATION_HOURS_MIN","Dura��o (h:m)");
define("_SHOW","Mostrar");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","O voo ser� activado dentro de 1-2 minutos.");
define("_TRY_AGAIN","Por favor tente de novo");

define("_TAKEOFF_LOCATION","Descolagem");
define("_TAKEOFF_TIME","Hora de descolagem");
define("_LANDING_LOCATION","Aterragem");
define("_LANDING_TIME","Hora de aterragem");
define("_OPEN_DISTANCE","Dist�ncia livre");
define("_MAX_DISTANCE","Distancia m�ximo");
define("_OLC_SCORE_TYPE","Tipo de pontua��o OLC");
define("_OLC_DISTANCE","Dist�ncia OLC");
define("_OLC_SCORING","Pontua��o OLC");
define("_MAX_SPEED","Velocidade m�xima");
define("_MAX_VARIO","Vario M�ximo");
define("_MEAN_SPEED","Velocidade m�dia");
define("_MIN_VARIO","Vario m�nimo");
define("_MAX_ALTITUDE","Altitude m�xima");
define("_TAKEOFF_ALTITUDE","Altitude da descolagem");
define("_MIN_ALTITUDE","Altitude m�nima");
define("_ALTITUDE_GAIN","Ganho de de altitude");
define("_FLIGHT_FILE","Arquivo de voo");
define("_COMMENTS","Coment�rios");
define("_RELEVANT_PAGE","Endere�o da p�gina web relacionada");
define("_GLIDER","Asa");
define("_PHOTOS","Fotos");
define("_MORE_INFO","Informa��o adicional");
define("_UPDATE_DATA","Actualizar dados");
define("_UPDATE_MAP","Actualizar mapa");
define("_UPDATE_3D_MAP","Actualizar mapa 3D");
define("_UPDATE_GRAPHS","Actualizar gr�ficos");
define("_UPDATE_SCORE","Actualizar pontua��o");

define("_TAKEOFF_COORDS","Coordenadas da descolagem:");
define("_NO_KNOWN_LOCATIONS","N�o existem locais conhecidos!");
define("_FLYING_AREA_INFO","Informa��o do local de voo");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo XC");
define("_RETURN_TO_TOP","^Cima");
// list flight
define("_PILOT_FLIGHTS","Voos do piloto");

define("_DATE_SORT","Data");
define("_PILOT_NAME","Nome do piloto");
define("_TAKEOFF","Descolagem");
define("_DURATION","Dura��o");
define("_LINEAR_DISTANCE","Dist�ncia livre");
define("_OLC_KM","OLC km");
define("_OLC_SCORE","Pontua��o OLC");
define("_DATE_ADDED","�ltimo envio");

define("_SORTED_BY","Ordenar por:");
define("_ALL_YEARS","Todos os anos");
define("_SELECT_YEAR_MONTH","Selecionar ano e m�s");
define("_ALL","Todos");
define("_ALL_PILOTS","Mostrar todos os pilotos");
define("_ALL_TAKEOFFS","Mostrar todas as descolagens");
define("_ALL_THE_YEAR","Todos os anos");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","N�o enviaste um ficheiro de voo");
define("_NO_SUCH_FILE","O ficheiro enviado n�o pode ser encontrado no servidor");
define("_FILE_DOESNT_END_IN_IGC","O ficheiro n�o tem extens�o .igc");
define("_THIS_ISNT_A_VALID_IGC_FILE","Este n�o � um ficheiro v�lido .igc");
define("_THERE_IS_SAME_DATE_FLIGHT","J� existe um voo com a mesma data e hora");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","Se desejas substitui-lo deves primero");
define("_DELETE_THE_OLD_ONE","apagar o anterior");
define("_THERE_IS_SAME_FILENAME_FLIGHT","J� existe um voo arquivado com o mesmo nome");
define("_CHANGE_THE_FILENAME","Se este voo � diferente por favor muda o nome do ficheiro e tenta de novo");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","O voo foi enviado com sucesso");
define("_PRESS_HERE_TO_VIEW_IT","Carregar aqui para visualiar");
define("_WILL_BE_ACTIVATED_SOON","(Ser� activado dentro de 1-2 minutos)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Enviar v�rios voos");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","Apenas ser�o processados ficheiros IGC");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","Enviar ficheiro ZIP<br>contendo os voos");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","Carregar aqui para enviar os voos");

define("_FILE_DOESNT_END_IN_ZIP","O ficheiro enviado n�o tem extens�o .zip");
define("_ADDING_FILE","Enviando ficheiro");
define("_ADDED_SUCESSFULLY","Envio terminado");
define("_PROBLEM","Problema");
define("_TOTAL","Total");
define("_IGC_FILES_PROCESSED","Os voos foram processados");
define("_IGC_FILES_SUBMITED","Os voos foram enviados");

// info
define("_DEVELOPMENT","Desenvolvido por");
define("_ANDREADAKIS_MANOLIS","Andreadakis Manolis");
define("_PROJECT_URL","Website do projecto");
define("_VERSION","Vers�o");
define("_MAP_CREATION","Cria��o de mapas");
define("_PROJECT_INFO","Informa��o do projecto");

// menu bar 
define("_MENU_MAIN_MENU","Menu principal");
define("_MENU_DATE","Seleccionar data");
define("_MENU_COUNTRY","Seleccionar Pa�s");
define("_MENU_XCLEAGUE","Liga XC");
define("_MENU_ADMIN","Admin");

define("_MENU_COMPETITION_LEAGUE","Liga - todas as categorias");
define("_MENU_OLC","OLC");
define("_MENU_OPEN_DISTANCE","Dist�ncia livre");
define("_MENU_DURATION","Dura��o");
define("_MENU_ALL_FLIGHTS","Mostrar todos os voos");
define("_MENU_FLIGHTS","Voos");
define("_MENU_TAKEOFFS","Descolagem");
define("_MENU_FILTER","Filtro");
define("_MENU_MY_FLIGHTS","Meus voos");
define("_MENU_MY_PROFILE","Meu perfil");
define("_MENU_MY_STATS","Minhas estat�sticas"); 
define("_MENU_MY_SETTINGS","Minhas defini��es"); 
define("_MENU_SUBMIT_FLIGHT","Enviar voo");
define("_MENU_SUBMIT_FROM_ZIP","Enviar voos zip");
define("_MENU_SHOW_PILOTS","Pilotos");
define("_MENU_SHOW_LAST_ADDED","Mostrar envios recentes");
define("_FLIGHTS_STATS","Estat�sticas do voo");

define("_SELECT_YEAR","Seleccionar ano");
define("_SELECT_MONTH","Seleccionar m�s");
define("_ALL_COUNTRIES","Mostrar todos os pa�ses");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","TODOS");
define("_NUMBER_OF_FLIGHTS","N�mero de voos");
define("_TOTAL_DISTANCE","Dist�ncia total");
define("_TOTAL_DURATION","Dura��o total");
define("_BEST_OPEN_DISTANCE","Melhor dist�ncia");
define("_TOTAL_OLC_DISTANCE","Dist�ncia total OLC");
define("_TOTAL_OLC_SCORE","Pontua��o total OLC");
define("_BEST_OLC_SCORE","Melhor pontua��o OLC");
define("_MEAN_DURATION","Dura��o m�dia");
define("_MEAN_DISTANCE","Dist�ncia media");
define("_PILOT_STATISTICS_SORT_BY","Pilotos - Ordenar por");
define("_CATEGORY_FLIGHT_NUMBER","Categoria 'FastJoe' - N�mero de voos");
define("_CATEGORY_TOTAL_DURATION","Categoria 'Duracell' - Dura��o total");
define("_CATEGORY_OPEN_DISTANCE","Categor�a 'Dist�ncia livre'");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","N�o existem pilotos para mostrar!");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","O voo foi apagado");
define("_RETURN","Voltar");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","ATEN��O - O voo vai ser apagado");
define("_THE_DATE","Data");
define("_YES","SIM");
define("_NO","N�O");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","Resultados da liga");
define("_N_BEST_FLIGHTS","Melhores voos");
define("_OLC","OLC");
define("_OLC_TOTAL_SCORE","Pontua��o total OLC");
define("_KILOMETERS","Km");
define("_TOTAL_ALTITUDE_GAIN","Ganho total de altitude");
define("_TOTAL_KM","Km totais");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","�");
define("_IS_NOT","n�o �");
define("_OR","ou");
define("_AND","e");
define("_FILTER_PAGE_TITLE","Filtro de voos");
define("_RETURN_TO_FLIGHTS","Voltar aos voos");
define("_THE_FILTER_IS_ACTIVE","O filtro est� activo");
define("_THE_FILTER_IS_INACTIVE","O filtro est� inactivo");
define("_SELECT_DATE","Seleccionar data");
define("_SHOW_FLIGHTS","Mostrar voos");
define("_ALL2","TODOS");
define("_WITH_YEAR","Com ano");
define("_MONTH","M�s");
define("_YEAR","Ano");
define("_FROM","DE");
define("_from","de");
define("_TO","At�");
define("_SELECT_PILOT","Seleccionar piloto");
define("_THE_PILOT","O piloto");
define("_THE_TAKEOFF","A descolagem");
define("_SELECT_TAKEOFF","Seleccionar descolagem");
define("_THE_COUNTRY","O pa�s");
define("_COUNTRY","Pa�s");
define("_SELECT_COUNTRY","Seleccionar pa�s");
define("_OTHER_FILTERS","Outros filtros");
define("_LINEAR_DISTANCE_SHOULD_BE","A dist�ncia livre deve ser");
define("_OLC_DISTANCE_SHOULD_BE","A dist�ncia OLC deve ser");
define("_OLC_SCORE_SHOULD_BE","A pontua��o OLC deve ser");
define("_DURATION_SHOULD_BE","A dura��o deve ser");
define("_ACTIVATE_CHANGE_FILTER","Activar / mudar FILTRO");
define("_DEACTIVATE_FILTER","Desactivar FILTRO");
define("_HOURS","horas");
define("_MINUTES","minutos");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","Enviar voo");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(s� � necess�rio o ficheiro IGC)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","Enviar o<br>ficheiro IGC do voo");
define("_NOTE_TAKEOFF_NAME","Por favor escreva o nome da descolagem e pa�s");
define("_COMMENTS_FOR_THE_FLIGHT","Coment�rios sobre o voo");
define("_PHOTO","Foto");
define("_PHOTOS_GUIDELINES","As fotos devem estar em formato jpg e com um tamhno inferior a ");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","Carregar aqui para enviar o voo");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","�Pretende enviar diversos voos em simult�neo?");
define("_PRESS_HERE","Carregar aqui");

define("_IS_PRIVATE","N�o mostrar ao p�blico");
define("_MAKE_THIS_FLIGHT_PRIVATE","N�o mostrar ao p�blico");
define("_INSERT_FLIGHT_AS_USER_ID","Introduzir o voo como ID do utilizador");
define("_FLIGHT_IS_PRIVATE","Este voo � privado");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","Mudar dados do voo");
define("_IGC_FILE_OF_THE_FLIGHT","Ficheiro IGC do voo");
define("_DELETE_PHOTO","Apagar foto");
define("_NEW_PHOTO","Nova foto");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","Carregar aqui para modificar os dados do voo");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","As modifica��es foram efectuadas com sucesso");
define("_RETURN_TO_FLIGHT","Voltar ao voo");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","Voltar ao voo");
define("_READY_FOR_SUBMISSION","Pronto para envio");
define("_OLC_MAP","Mapa");
define("_OLC_BARO","Bar�grafo");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","Perfil do piloto");
define("_back_to_flights","^Cima");
define("_pilot_stats","estat�sticas do piloto");
define("_edit_profile","editar perfil");
define("_flights_stats","estat�sticas do voo");
define("_View_Profile","V�r perfil");

define("_Personal_Stuff","Dados pessoais");
define("_First_Name"," Nome");
define("_Last_Name","Apelido");
define("_Birthdate","Data de nascimento");
define("_dd_mm_yy","dd.mm.aa");
define("_Sign","Signo");
define("_Marital_Status","Estado C�vil");
define("_Occupation","Ocupa��o");
define("_Web_Page","P�gina Web");
define("_N_A","N/A");
define("_Other_Interests","Outros Interesses");
define("_Photo","Foto");

define("_Flying_Stuff","Dados de voo");
define("_note_place_and_date","se poss�vel acrescentar cidade-pa�s e data");
define("_Flying_Since","Piloto desde");
define("_Pilot_Licence","Licen�a de voo");
define("_Paragliding_training","Experi�ncia de voo");
define("_Favorite_Location","Local de voo favorito");
define("_Usual_Location","Local de voo habitual");
define("_Best_Flying_Memory","Melhor experi�ncia em voo");
define("_Worst_Flying_Memory","Pior experi�ncia em voo");
define("_Personal_Distance_Record","Recorde pessoal de dist�ncia");
define("_Personal_Height_Record","Recorde pessoal de altitude");
define("_Hours_Flown","Horas de voo");
define("_Hours_Per_Year","Horas voadas anualmente");

define("_Equipment_Stuff","Dados sobre o Equipamento");
define("_Glider","Asa");
define("_Harness","Arn�s");
define("_Reserve_chute","Paraquedas de emerg�ncia");
define("_Camera","C�mera fotogr�fica");
define("_Vario","V�rio");
define("_GPS","GPS");
define("_Helmet","Capacete");
define("_Camcorder","C�mera de video");

define("_Manouveur_Stuff","Dados sobre manobras de voo");
define("_note_max_descent_rate","se poss�vel acrescentar a taxa de queda m�xima alcan�ada");
define("_Spiral","Espiral");
define("_Bline","Bandas B");
define("_Full_Stall","P�rda");
define("_Other_Manouveurs_Acro","Outras manobras Acro");
define("_Sat","Sat");
define("_Asymmetric_Spiral","Espiral assim�trica");
define("_Spin","Negativa");

define("_General_Stuff","Dados gerais");
define("_Favorite_Singer","Cantor favorito");
define("_Favorite_Movie","Filme Favorito");
define("_Favorite_Internet_Site","Website favorito<br>na internet");
define("_Favorite_Book","Livro favorito");
define("_Favorite_Actor","Actor favorito");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","Inserir foto ou modificar a existente");
define("_Delete_Photo","Apagar foto");
define("_Your_profile_has_been_updated","O seu perfil foi actualizado");
define("_Submit_Change_Data","Enviar - Modificar dados");

//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","hh:mm");

define("_Totals","Totais");
define("_First_flight_logged","Primeiro voo introduzido");
define("_Last_flight_logged","�ltimo voo introduzido");
define("_Flying_period_covered","Periodo de voo coberto");
define("_Total_Distance","Dist�ncia total");
define("_Total_OLC_Score","Pontua��o total OLC");
define("_Total_Hours_Flown","Total de horas de voo");
define("_Total_num_of_flights","N�mero total de voos");

define("_Personal_Bests","Melhores resultados pessoais");
define("_Best_Open_Distance","Melhor dist�ncia livre");
define("_Best_FAI_Triangle","Melhor tri�ngulo FAI");
define("_Best_Free_Triangle","Mejor tri�ngulo livre");
define("_Longest_Flight","Voo mais longo");
define("_Best_OLC_score","Melhor pontua��o OLC");

define("_Absolute_Height_Record","Recorde de altitude absoluta");
define("_Altitute_gain_Record","Recorde de ganho de altitude");
define("_Mean_values","Valores m�dios");
define("_Mean_distance_per_flight","Dist�ncias m�dias por voo");
define("_Mean_flights_per_Month","M�dia de voos por m�s");
define("_Mean_distance_per_Month","M�dia de dist�ncia por m�s");
define("_Mean_duration_per_Month","M�dia da dura��o de voo por m�s");
define("_Mean_duration_per_flight","M�dia da dura��o por voo");
define("_Mean_flights_per_Year","M�dia de voos por ano");
define("_Mean_distance_per_Year","M�dia de dist�ncias por ano");
define("_Mean_duration_per_Year","M�dia de dura��o de voo por ano");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","V�r voos pr�ximos a este ponto");
define("_Waypoint_Name","Nome do Waypoint");
define("_Navigate_with_Google_Earth","Navegar com o Google Earth");
define("_See_it_in_Google_Maps","V�r no Google Maps");
define("_See_it_in_MapQuest","V�r no MapQuest");
define("_COORDINATES","Coordenadas");
define("_FLIGHTS","Voos");
define("_SITE_RECORD","Recorde do local de voo");
define("_SITE_INFO","Informa��o do local de voo");
define("_SITE_REGION","Regi�o");
define("_SITE_LINK","Link com mais informa��o");
define("_SITE_DESCR","Descri��o do local de voo/Descolagem");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","Veja mais detalhes");
define("_KML_file_made_by","Ficheiro KML feito por");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","Acrescentar descolagem");
define("_WAYPOINT_ADDED","A descolagem foi acrescentada");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","Recorde do local de voo<br>(dist�ncia livre)");
	
//--------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","Tipo de asa");
function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'Parapente',2=>'Asa delta FAI1',4=>'Asa r�gida FAI5',8=>'Planador');
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

define("_Your_settings_have_been_updated","Os seus dados foram actualizados");

define("_THEME","Tema");
define("_LANGUAGE","Linguagem");
define("_VIEW_CATEGORY","V�r categoria");
define("_VIEW_COUNTRY","V�r pa�s");
define("_UNITS_SYSTEM" ,"Unidades");
define("_METRIC_SYSTEM","Metrico (km,m)");
define("_IMPERIAL_SYSTEM","Imperial (milhas,p�s)");
define("_ITEMS_PER_PAGE","Items por p�gina");

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

define("_WORLD_WIDE","Geral Internacional");
define("_National_XC_Leagues_for","Ligas Nacionais");
define("_Flights_per_Country","Voos por Pa�s");
define("_Takeoffs_per_Country","Descolagens por Pa�s");
define("_INDEX_HEADER","Bem vindo � Liga XC Leonardo");
define("_INDEX_MESSAGE","Pode utilizar o &quot;M�nu Principal&quot; para navegar ou utilizar as prefer�ncias que se seguem.");

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
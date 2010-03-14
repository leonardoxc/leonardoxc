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
	$monthList=array('Janeiro','Fevereiro','Março','Abril','Maio','Junho',
					'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
	$monthListShort=array('JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC');
	$weekdaysList=array('Mon','Tue','Wed','Thu','Fri','Sat','Sun') ;
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","Distância livre");
define("_FREE_TRIANGLE","Triângulo livre");
define("_FAI_TRIANGLE","Triângulo FAI");

define("_SUBMIT_FLIGHT_ERROR","Ocorreu um problema com o envio do voo");

// list_pilots()
define("_NUM","#");
define("_PILOT","Piloto");
define("_NUMBER_OF_FLIGHTS","Número de voos");
define("_BEST_DISTANCE","Melhor distância");
define("_MEAN_KM","Media # km por voo");
define("_TOTAL_KM","Km Totais voados");
define("_TOTAL_DURATION_OF_FLIGHTS","Duração total dos voos");
define("_MEAN_DURATION","Duração media dos voos");
define("_TOTAL_OLC_KM","Distância OLC total");
define("_TOTAL_OLC_SCORE","Pontuação OLC total");
define("_BEST_OLC_SCORE","Melhor pontuação OLC");
define("_From","de");

// list_flights()
define("_DURATION_HOURS_MIN","Duração (h:m)");
define("_SHOW","Mostrar");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","O voo será activado dentro de 1-2 minutos.");
define("_TRY_AGAIN","Por favor tente de novo");

define("_TAKEOFF_LOCATION","Descolagem");
define("_TAKEOFF_TIME","Hora de descolagem");
define("_LANDING_LOCATION","Aterragem");
define("_LANDING_TIME","Hora de aterragem");
define("_OPEN_DISTANCE","Distância livre");
define("_MAX_DISTANCE","Distancia máximo");
define("_OLC_SCORE_TYPE","Tipo de pontuação OLC");
define("_OLC_DISTANCE","Distância OLC");
define("_OLC_SCORING","Pontuação OLC");
define("_MAX_SPEED","Velocidade máxima");
define("_MAX_VARIO","Vario Máximo");
define("_MEAN_SPEED","Velocidade média");
define("_MIN_VARIO","Vario mínimo");
define("_MAX_ALTITUDE","Altitude máxima");
define("_TAKEOFF_ALTITUDE","Altitude da descolagem");
define("_MIN_ALTITUDE","Altitude mínima");
define("_ALTITUDE_GAIN","Ganho de de altitude");
define("_FLIGHT_FILE","Arquivo de voo");
define("_COMMENTS","Comentários");
define("_RELEVANT_PAGE","Endereço da página web relacionada");
define("_GLIDER","Asa");
define("_PHOTOS","Fotos");
define("_MORE_INFO","Informação adicional");
define("_UPDATE_DATA","Actualizar dados");
define("_UPDATE_MAP","Actualizar mapa");
define("_UPDATE_3D_MAP","Actualizar mapa 3D");
define("_UPDATE_GRAPHS","Actualizar gráficos");
define("_UPDATE_SCORE","Actualizar pontuação");

define("_TAKEOFF_COORDS","Coordenadas da descolagem:");
define("_NO_KNOWN_LOCATIONS","Não existem locais conhecidos!");
define("_FLYING_AREA_INFO","Informação do local de voo");

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
define("_DURATION","Duração");
define("_LINEAR_DISTANCE","Distância livre");
define("_OLC_KM","OLC km");
define("_OLC_SCORE","Pontuação OLC");
define("_DATE_ADDED","Último envio");

define("_SORTED_BY","Ordenar por:");
define("_ALL_YEARS","Todos os anos");
define("_SELECT_YEAR_MONTH","Selecionar ano e mês");
define("_ALL","Todos");
define("_ALL_PILOTS","Mostrar todos os pilotos");
define("_ALL_TAKEOFFS","Mostrar todas as descolagens");
define("_ALL_THE_YEAR","Todos os anos");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","Não enviaste um ficheiro de voo");
define("_NO_SUCH_FILE","O ficheiro enviado não pode ser encontrado no servidor");
define("_FILE_DOESNT_END_IN_IGC","O ficheiro não tem extensão .igc");
define("_THIS_ISNT_A_VALID_IGC_FILE","Este não é um ficheiro válido .igc");
define("_THERE_IS_SAME_DATE_FLIGHT","Já existe um voo com a mesma data e hora");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","Se desejas substitui-lo deves primero");
define("_DELETE_THE_OLD_ONE","apagar o anterior");
define("_THERE_IS_SAME_FILENAME_FLIGHT","Já existe um voo arquivado com o mesmo nome");
define("_CHANGE_THE_FILENAME","Se este voo é diferente por favor muda o nome do ficheiro e tenta de novo");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","O voo foi enviado com sucesso");
define("_PRESS_HERE_TO_VIEW_IT","Carregar aqui para visualiar");
define("_WILL_BE_ACTIVATED_SOON","(Será activado dentro de 1-2 minutos)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Enviar vários voos");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","Apenas serão processados ficheiros IGC");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","Enviar ficheiro ZIP<br>contendo os voos");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","Carregar aqui para enviar os voos");

define("_FILE_DOESNT_END_IN_ZIP","O ficheiro enviado não tem extensão .zip");
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
define("_VERSION","Versão");
define("_MAP_CREATION","Criação de mapas");
define("_PROJECT_INFO","Informação do projecto");

// menu bar 
define("_MENU_MAIN_MENU","Menu principal");
define("_MENU_DATE","Seleccionar data");
define("_MENU_COUNTRY","Seleccionar País");
define("_MENU_XCLEAGUE","Liga XC");
define("_MENU_ADMIN","Admin");

define("_MENU_COMPETITION_LEAGUE","Liga - todas as categorias");
define("_MENU_OLC","OLC");
define("_MENU_OPEN_DISTANCE","Distância livre");
define("_MENU_DURATION","Duração");
define("_MENU_ALL_FLIGHTS","Mostrar todos os voos");
define("_MENU_FLIGHTS","Voos");
define("_MENU_TAKEOFFS","Descolagem");
define("_MENU_FILTER","Filtro");
define("_MENU_MY_FLIGHTS","Meus voos");
define("_MENU_MY_PROFILE","Meu perfil");
define("_MENU_MY_STATS","Minhas estatísticas"); 
define("_MENU_MY_SETTINGS","Minhas definições"); 
define("_MENU_SUBMIT_FLIGHT","Enviar voo");
define("_MENU_SUBMIT_FROM_ZIP","Enviar voos zip");
define("_MENU_SHOW_PILOTS","Pilotos");
define("_MENU_SHOW_LAST_ADDED","Mostrar envios recentes");
define("_FLIGHTS_STATS","Estatísticas do voo");

define("_SELECT_YEAR","Seleccionar ano");
define("_SELECT_MONTH","Seleccionar mês");
define("_ALL_COUNTRIES","Mostrar todos os países");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","TODOS");
define("_NUMBER_OF_FLIGHTS","Número de voos");
define("_TOTAL_DISTANCE","Distância total");
define("_TOTAL_DURATION","Duração total");
define("_BEST_OPEN_DISTANCE","Melhor distância");
define("_TOTAL_OLC_DISTANCE","Distância total OLC");
define("_TOTAL_OLC_SCORE","Pontuação total OLC");
define("_BEST_OLC_SCORE","Melhor pontuação OLC");
define("_MEAN_DURATION","Duração média");
define("_MEAN_DISTANCE","Distância media");
define("_PILOT_STATISTICS_SORT_BY","Pilotos - Ordenar por");
define("_CATEGORY_FLIGHT_NUMBER","Categoria 'FastJoe' - Número de voos");
define("_CATEGORY_TOTAL_DURATION","Categoria 'Duracell' - Duração total");
define("_CATEGORY_OPEN_DISTANCE","Categoría 'Distância livre'");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","Não existem pilotos para mostrar!");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","O voo foi apagado");
define("_RETURN","Voltar");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","ATENÇÃO - O voo vai ser apagado");
define("_THE_DATE","Data");
define("_YES","SIM");
define("_NO","NÃO");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","Resultados da liga");
define("_N_BEST_FLIGHTS","Melhores voos");
define("_OLC","OLC");
define("_OLC_TOTAL_SCORE","Pontuação total OLC");
define("_KILOMETERS","Km");
define("_TOTAL_ALTITUDE_GAIN","Ganho total de altitude");
define("_TOTAL_KM","Km totais");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","é");
define("_IS_NOT","não é");
define("_OR","ou");
define("_AND","e");
define("_FILTER_PAGE_TITLE","Filtro de voos");
define("_RETURN_TO_FLIGHTS","Voltar aos voos");
define("_THE_FILTER_IS_ACTIVE","O filtro está activo");
define("_THE_FILTER_IS_INACTIVE","O filtro está inactivo");
define("_SELECT_DATE","Seleccionar data");
define("_SHOW_FLIGHTS","Mostrar voos");
define("_ALL2","TODOS");
define("_WITH_YEAR","Com ano");
define("_MONTH","Mês");
define("_YEAR","Ano");
define("_FROM","DE");
define("_from","de");
define("_TO","Até");
define("_SELECT_PILOT","Seleccionar piloto");
define("_THE_PILOT","O piloto");
define("_THE_TAKEOFF","A descolagem");
define("_SELECT_TAKEOFF","Seleccionar descolagem");
define("_THE_COUNTRY","O país");
define("_COUNTRY","País");
define("_SELECT_COUNTRY","Seleccionar país");
define("_OTHER_FILTERS","Outros filtros");
define("_LINEAR_DISTANCE_SHOULD_BE","A distância livre deve ser");
define("_OLC_DISTANCE_SHOULD_BE","A distância OLC deve ser");
define("_OLC_SCORE_SHOULD_BE","A pontuação OLC deve ser");
define("_DURATION_SHOULD_BE","A duração deve ser");
define("_ACTIVATE_CHANGE_FILTER","Activar / mudar FILTRO");
define("_DEACTIVATE_FILTER","Desactivar FILTRO");
define("_HOURS","horas");
define("_MINUTES","minutos");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","Enviar voo");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(só é necessário o ficheiro IGC)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","Enviar o<br>ficheiro IGC do voo");
define("_NOTE_TAKEOFF_NAME","Por favor escreva o nome da descolagem e país");
define("_COMMENTS_FOR_THE_FLIGHT","Comentários sobre o voo");
define("_PHOTO","Foto");
define("_PHOTOS_GUIDELINES","As fotos devem estar em formato jpg e com um tamhno inferior a ");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","Carregar aqui para enviar o voo");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","¿Pretende enviar diversos voos em simultâneo?");
define("_PRESS_HERE","Carregar aqui");

define("_IS_PRIVATE","Não mostrar ao público");
define("_MAKE_THIS_FLIGHT_PRIVATE","Não mostrar ao público");
define("_INSERT_FLIGHT_AS_USER_ID","Introduzir o voo como ID do utilizador");
define("_FLIGHT_IS_PRIVATE","Este voo é privado");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","Mudar dados do voo");
define("_IGC_FILE_OF_THE_FLIGHT","Ficheiro IGC do voo");
define("_DELETE_PHOTO","Apagar foto");
define("_NEW_PHOTO","Nova foto");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","Carregar aqui para modificar os dados do voo");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","As modificações foram efectuadas com sucesso");
define("_RETURN_TO_FLIGHT","Voltar ao voo");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","Voltar ao voo");
define("_READY_FOR_SUBMISSION","Pronto para envio");
define("_OLC_MAP","Mapa");
define("_OLC_BARO","Barógrafo");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","Perfil do piloto");
define("_back_to_flights","^Cima");
define("_pilot_stats","estatísticas do piloto");
define("_edit_profile","editar perfil");
define("_flights_stats","estatísticas do voo");
define("_View_Profile","Vêr perfil");

define("_Personal_Stuff","Dados pessoais");
define("_First_Name"," Nome");
define("_Last_Name","Apelido");
define("_Birthdate","Data de nascimento");
define("_dd_mm_yy","dd.mm.aa");
define("_Sign","Signo");
define("_Marital_Status","Estado Cívil");
define("_Occupation","Ocupação");
define("_Web_Page","Página Web");
define("_N_A","N/A");
define("_Other_Interests","Outros Interesses");
define("_Photo","Foto");

define("_Flying_Stuff","Dados de voo");
define("_note_place_and_date","se possível acrescentar cidade-país e data");
define("_Flying_Since","Piloto desde");
define("_Pilot_Licence","Licença de voo");
define("_Paragliding_training","Experiência de voo");
define("_Favorite_Location","Local de voo favorito");
define("_Usual_Location","Local de voo habitual");
define("_Best_Flying_Memory","Melhor experiência em voo");
define("_Worst_Flying_Memory","Pior experiência em voo");
define("_Personal_Distance_Record","Recorde pessoal de distância");
define("_Personal_Height_Record","Recorde pessoal de altitude");
define("_Hours_Flown","Horas de voo");
define("_Hours_Per_Year","Horas voadas anualmente");

define("_Equipment_Stuff","Dados sobre o Equipamento");
define("_Glider","Asa");
define("_Harness","Arnês");
define("_Reserve_chute","Paraquedas de emergência");
define("_Camera","Câmera fotográfica");
define("_Vario","Vário");
define("_GPS","GPS");
define("_Helmet","Capacete");
define("_Camcorder","Câmera de video");

define("_Manouveur_Stuff","Dados sobre manobras de voo");
define("_note_max_descent_rate","se possível acrescentar a taxa de queda máxima alcançada");
define("_Spiral","Espiral");
define("_Bline","Bandas B");
define("_Full_Stall","Pêrda");
define("_Other_Manouveurs_Acro","Outras manobras Acro");
define("_Sat","Sat");
define("_Asymmetric_Spiral","Espiral assimétrica");
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
define("_Last_flight_logged","Último voo introduzido");
define("_Flying_period_covered","Periodo de voo coberto");
define("_Total_Distance","Distância total");
define("_Total_OLC_Score","Pontuação total OLC");
define("_Total_Hours_Flown","Total de horas de voo");
define("_Total_num_of_flights","Número total de voos");

define("_Personal_Bests","Melhores resultados pessoais");
define("_Best_Open_Distance","Melhor distância livre");
define("_Best_FAI_Triangle","Melhor triângulo FAI");
define("_Best_Free_Triangle","Mejor triângulo livre");
define("_Longest_Flight","Voo mais longo");
define("_Best_OLC_score","Melhor pontuação OLC");

define("_Absolute_Height_Record","Recorde de altitude absoluta");
define("_Altitute_gain_Record","Recorde de ganho de altitude");
define("_Mean_values","Valores médios");
define("_Mean_distance_per_flight","Distâncias médias por voo");
define("_Mean_flights_per_Month","Média de voos por mês");
define("_Mean_distance_per_Month","Média de distância por mês");
define("_Mean_duration_per_Month","Média da duração de voo por mês");
define("_Mean_duration_per_flight","Média da duração por voo");
define("_Mean_flights_per_Year","Média de voos por ano");
define("_Mean_distance_per_Year","Média de distâncias por ano");
define("_Mean_duration_per_Year","Média de duração de voo por ano");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","Vêr voos próximos a este ponto");
define("_Waypoint_Name","Nome do Waypoint");
define("_Navigate_with_Google_Earth","Navegar com o Google Earth");
define("_See_it_in_Google_Maps","Vêr no Google Maps");
define("_See_it_in_MapQuest","Vêr no MapQuest");
define("_COORDINATES","Coordenadas");
define("_FLIGHTS","Voos");
define("_SITE_RECORD","Recorde do local de voo");
define("_SITE_INFO","Informação do local de voo");
define("_SITE_REGION","Região");
define("_SITE_LINK","Link com mais informação");
define("_SITE_DESCR","Descrição do local de voo/Descolagem");

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
define("_SITE_RECORD_OPEN_DISTANCE","Recorde do local de voo<br>(distância livre)");
	
//--------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","Tipo de asa");
function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'Parapente',2=>'Asa delta FAI1',4=>'Asa rígida FAI5',8=>'Planador');
	foreach ($CONF_glider_types as $gId=>$gName) if (!$gliderCatList[$gId]) $gliderCatList[$gId]=$gName;
}
setGliderCats();

//--------------------------------------------
// user prefs  & units
//--------------------------------------------

define("_Your_settings_have_been_updated","Os seus dados foram actualizados");

define("_THEME","Tema");
define("_LANGUAGE","Linguagem");
define("_VIEW_CATEGORY","Vêr categoria");
define("_VIEW_COUNTRY","Vêr país");
define("_UNITS_SYSTEM" ,"Unidades");
define("_METRIC_SYSTEM","Metrico (km,m)");
define("_IMPERIAL_SYSTEM","Imperial (milhas,pés)");
define("_ITEMS_PER_PAGE","Items por página");

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
define("_Flights_per_Country","Voos por País");
define("_Takeoffs_per_Country","Descolagens por País");
define("_INDEX_HEADER","Bem vindo à Liga XC Leonardo");
define("_INDEX_MESSAGE","Pode utilizar o &quot;Ménu Principal&quot; para navegar ou utilizar as preferências que se seguem.");

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
define("_PilotBirthdate"," Pilot Birthdate"); 
define("_Start_Type","Start Type"); 
define("_GLIDER_CERT","Glider Certification"); 

?>
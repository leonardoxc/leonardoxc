<?php
/**************************************************************************/
/* Original Portuguese language translation by                            */
/* Paulo Reis   (Paulor100@gmail.com)                                     */
/* Adopted for Brazilian - Portuguese           						  */
/* Olympio  Faissol (http://ofaissol.blogspot.com)                        */
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
define("_NUMBER_OF_FLIGHTS","N�mero de v�os");
define("_BEST_DISTANCE","Melhor dist�ncia");
define("_MEAN_KM","M�dia km por v�o");
define("_TOTAL_KM","Km Totais voados");
define("_TOTAL_DURATION_OF_FLIGHTS","Dura��o total dos v�os");
define("_MEAN_DURATION","Dura��o m�dia dos v�os");
define("_TOTAL_OLC_KM","Dist�ncia OLC total");
define("_TOTAL_OLC_SCORE","Pontua��o OLC total");
define("_BEST_OLC_SCORE","Melhor pontua��o OLC");
define("_From","de");

// list_flights()
define("_DURATION_HOURS_MIN","Dura��o (h:m)");
define("_SHOW","Mostrar");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","O voo ser� ativado dentro de 1-2 minutos.");
define("_TRY_AGAIN","Por favor tente de novo");

define("_TAKEOFF_LOCATION","Decolagem");
define("_TAKEOFF_TIME","Hora da decolagem");
define("_LANDING_LOCATION","Pouso");
define("_LANDING_TIME","Hora do pouso");
define("_OPEN_DISTANCE","Dist�ncia livre");
define("_MAX_DISTANCE","Dist�ncia m�xima");
define("_OLC_SCORE_TYPE","Tipo de pontua��o OLC");
define("_OLC_DISTANCE","Dist�ncia OLC");
define("_OLC_SCORING","Pontua��o OLC");
define("_MAX_SPEED","Velocidade m�xima");
define("_MAX_VARIO","Maior Ascendente");
define("_MEAN_SPEED","Velocidade m�dia");
define("_MIN_VARIO","Maior descendente");
define("_MAX_ALTITUDE","Altitude m�xima");
define("_TAKEOFF_ALTITUDE","Altitude da decolagem");
define("_MIN_ALTITUDE","Altitude m�nima");
define("_ALTITUDE_GAIN","Ganho de altitude");
define("_FLIGHT_FILE","Arquivo do v�o");
define("_COMMENTS","Coment�rios");
define("_RELEVANT_PAGE","Endere�o da p�gina web relacionada");
define("_GLIDER","Asa");
define("_PHOTOS","Fotos");
define("_MORE_INFO","Informa��o adicional");
define("_UPDATE_DATA","Atualizar dados");
define("_UPDATE_MAP","Atualizar mapa");
define("_UPDATE_3D_MAP","Atualizar mapa 3D");
define("_UPDATE_GRAPHS","Atualizar gr�ficos");
define("_UPDATE_SCORE","Atualizar pontua��o");

define("_TAKEOFF_COORDS","Coordenadas da decolagem:");
define("_NO_KNOWN_LOCATIONS","N�o existem locais conhecidos!");
define("_FLYING_AREA_INFO","Informa��o do local de v�o");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo XC");
define("_RETURN_TO_TOP","Voltar para o in�cio");
// list flight
define("_PILOT_FLIGHTS","V�os do piloto");

define("_DATE_SORT","Data");
define("_PILOT_NAME","Nome do piloto");
define("_TAKEOFF","Decolagem");
define("_DURATION","Dura��o");
define("_LINEAR_DISTANCE","Dist�ncia em linha reta");
define("_OLC_KM","OLC km");
define("_OLC_SCORE","Pontua��o OLC");
define("_DATE_ADDED","�ltimo envio");

define("_SORTED_BY","Ordenar por:");
define("_ALL_YEARS","Todos os anos");
define("_SELECT_YEAR_MONTH","Selecionar ano e m�s");
define("_ALL","Todos");
define("_ALL_PILOTS","Mostrar todos os pilotos");
define("_ALL_TAKEOFFS","Mostrar todas as decolagens");
define("_ALL_THE_YEAR","Ano inteiro");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","Voc� n�o enviou um arquivo de v�o");
define("_NO_SUCH_FILE","O arquivo enviado n�o foi encontrado no servidor");
define("_FILE_DOESNT_END_IN_IGC","O arquivo n�o tem extens�o .igc");
define("_THIS_ISNT_A_VALID_IGC_FILE","Este n�o � um arquivo v�lido .igc");
define("_THERE_IS_SAME_DATE_FLIGHT","J� existe um v�o com a mesma data e hora");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","Se deseja substitui-lo dever� antes");
define("_DELETE_THE_OLD_ONE","apagar o anterior");
define("_THERE_IS_SAME_FILENAME_FLIGHT","J� existe um v�o arquivado com o mesmo nome");
define("_CHANGE_THE_FILENAME","Se este v�o � diferente mude o nome do arquivo e tente novamente");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","O v�o foi enviado com sucesso");
define("_PRESS_HERE_TO_VIEW_IT","Visualizar aqui");
define("_WILL_BE_ACTIVATED_SOON","(Ser� ativado dentro de 1-2 minutos)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Enviar v�rios v�os");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","Apenas ser�o processados arquivos IGC");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","Enviar arquivo ZIP contendo os v�os");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","Pressione aqui para enviar os v�os");

define("_FILE_DOESNT_END_IN_ZIP","O arquivo enviado n�o tem extens�o .zip");
define("_ADDING_FILE","Enviando arquivo");
define("_ADDED_SUCESSFULLY","Envio terminado");
define("_PROBLEM","Problema");
define("_TOTAL","Total");
define("_IGC_FILES_PROCESSED","Os v�os foram processados");
define("_IGC_FILES_SUBMITED","Os v�os foram enviados");

// info
define("_DEVELOPMENT","Desenvolvido por");
define("_ANDREADAKIS_MANOLIS","Andreadakis Manolis");
define("_PROJECT_URL","Website do projeto");
define("_VERSION","Vers�o");
define("_MAP_CREATION","Cria��o de mapas");
define("_PROJECT_INFO","Informa��o sobre o projeto");

// menu bar 
define("_MENU_MAIN_MENU","Menu principal");
define("_MENU_DATE","Selecionar data");
define("_MENU_COUNTRY","Selecionar Pa�s");
define("_MENU_XCLEAGUE","Liga XC");
define("_MENU_ADMIN","Admin");

define("_MENU_COMPETITION_LEAGUE","Liga - todas as categorias");
define("_MENU_OLC","OLC");
define("_MENU_OPEN_DISTANCE","Dist�ncia livre");
define("_MENU_DURATION","Dura��o");
define("_MENU_ALL_FLIGHTS","Mostrar todos os v�os");
define("_MENU_FLIGHTS","V�os");
define("_MENU_TAKEOFFS","Decolagem");
define("_MENU_FILTER","Filtro");
define("_MENU_MY_FLIGHTS","Meus v�os");
define("_MENU_MY_PROFILE","Meu perfil");
define("_MENU_MY_STATS","Minhas estat�sticas"); 
define("_MENU_MY_SETTINGS","Minhas defini��es"); 
define("_MENU_SUBMIT_FLIGHT","Enviar v�o");
define("_MENU_SUBMIT_FROM_ZIP","Enviar v�os zip");
define("_MENU_SHOW_PILOTS","Mostrar pilotos");
define("_MENU_SHOW_LAST_ADDED","Mostrar envios recentes");
define("_FLIGHTS_STATS","Estat�sticas do v�o");

define("_SELECT_YEAR","Selecionar ano");
define("_SELECT_MONTH","Selecionar m�s");
define("_ALL_COUNTRIES","Mostrar todos os pa�ses");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","Todos anos");
define("_NUMBER_OF_FLIGHTS","N�mero de v�os");
define("_TOTAL_DISTANCE","Dist�ncia total");
define("_TOTAL_DURATION","Dura��o total");
define("_BEST_OPEN_DISTANCE","Melhor dist�ncia");
define("_TOTAL_OLC_DISTANCE","Dist�ncia total OLC");
define("_TOTAL_OLC_SCORE","Pontua��o total OLC");
define("_BEST_OLC_SCORE","Melhor pontua��o OLC");
define("_MEAN_DURATION","Dura��o m�dia");
define("_MEAN_DISTANCE","Dist�ncia m�dia");
define("_PILOT_STATISTICS_SORT_BY","Pilotos - Ordenar por");
define("_CATEGORY_FLIGHT_NUMBER","Categoria - N�mero de voos");
define("_CATEGORY_TOTAL_DURATION","Categoria - Dura��o total");
define("_CATEGORY_OPEN_DISTANCE","Categor�a - Dist�ncia livre");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","N�o existem pilotos para mostrar!");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","O v�o foi apagado");
define("_RETURN","Voltar");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","ATEN��O - O v�o vai ser apagado");
define("_THE_DATE","Data");
define("_YES","SIM");
define("_NO","N�O");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","Resultados da liga");
define("_N_BEST_FLIGHTS","Melhores v�os");
define("_OLC","OLC");
define("_OLC_TOTAL_SCORE","Pontua��o total OLC");
define("_KILOMETERS","Kms");
define("_TOTAL_ALTITUDE_GAIN","Ganho total de altitude");
define("_TOTAL_KM","Kms totais");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","�");
define("_IS_NOT","n�o �");
define("_OR","ou");
define("_AND","e");
define("_FILTER_PAGE_TITLE","Filtro de v�os");
define("_RETURN_TO_FLIGHTS","Voltar aos v�os");
define("_THE_FILTER_IS_ACTIVE","O filtro est� ativo");
define("_THE_FILTER_IS_INACTIVE","O filtro est� inativo");
define("_SELECT_DATE","Seleccionar data");
define("_SHOW_FLIGHTS","Mostrar v�os");
define("_ALL2","TODOS");
define("_WITH_YEAR","Com ano");
define("_MONTH","M�s");
define("_YEAR","Ano");
define("_FROM","DE");
define("_from","de");
define("_TO","At�");
define("_SELECT_PILOT","Selecionar piloto");
define("_THE_PILOT","O piloto");
define("_THE_TAKEOFF","A decolagem");
define("_SELECT_TAKEOFF","Selecionar decolagem");
define("_THE_COUNTRY","O pa�s");
define("_COUNTRY","Pa�s");
define("_SELECT_COUNTRY","Selecionar pa�s");
define("_OTHER_FILTERS","Outros filtros");
define("_LINEAR_DISTANCE_SHOULD_BE","A dist�ncia livre deve ser");
define("_OLC_DISTANCE_SHOULD_BE","A dist�ncia OLC deve ser");
define("_OLC_SCORE_SHOULD_BE","A pontua��o OLC deve ser");
define("_DURATION_SHOULD_BE","A dura��o deve ser");
define("_ACTIVATE_CHANGE_FILTER","Ativar / mudar FILTRO");
define("_DEACTIVATE_FILTER","Desativar FILTRO");
define("_HOURS","horas");
define("_MINUTES","minutos");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","Enviar v�o");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(s� � necess�rio o arquivo IGC)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","Enviar o arquivo IGC do v�o");
define("_NOTE_TAKEOFF_NAME","Por favor escreva o nome da decolagem e pa�s");
define("_COMMENTS_FOR_THE_FLIGHT","Coment�rios sobre o v�o");
define("_PHOTO","Foto");
define("_PHOTOS_GUIDELINES","As fotos devem estar em formato jpg e ter tamhno inferior a ");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","Pressionar aqui para enviar o v�o");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","�Pretende enviar diversos v�os simultaneamente?");
define("_PRESS_HERE","Pressionar aqui");

define("_IS_PRIVATE","N�o mostrar ao p�blico");
define("_MAKE_THIS_FLIGHT_PRIVATE","N�o mostrar ao p�blico");
define("_INSERT_FLIGHT_AS_USER_ID","Introduzir o v�o como ID do utilizador");
define("_FLIGHT_IS_PRIVATE","Este v�o � privado");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","Mudar dados do v�o");
define("_IGC_FILE_OF_THE_FLIGHT","Arquivo IGC do v�o");
define("_DELETE_PHOTO","Apagar foto");
define("_NEW_PHOTO","Nova foto");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","Pressione aqui para modificar os dados do v�o");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","As modifica��es foram efetuadas com sucesso");
define("_RETURN_TO_FLIGHT","Voltar ao v�o");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","Voltar ao v�o");
define("_READY_FOR_SUBMISSION","Pronto para envio");
define("_OLC_MAP","Mapa");
define("_OLC_BARO","Bar�grafo");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","Perfil do piloto");
define("_back_to_flights","Voltar");
define("_pilot_stats","Estat�sticas do piloto");
define("_edit_profile","Editar perfil");
define("_flights_stats","Estat�sticas do voo");
define("_View_Profile","Ver perfil");

define("_Personal_Stuff","Dados pessoais");
define("_First_Name"," Nome");
define("_Last_Name","Sobrenome");
define("_Birthdate","Data de nascimento");
define("_dd_mm_yy","dd.mm.aa");
define("_Sign","Signo");
define("_Marital_Status","Estado Civil");
define("_Occupation","Ocupa��o");
define("_Web_Page","P�gina Web");
define("_N_A","N/A");
define("_Other_Interests","Outros Interesses");
define("_Photo","Foto");

define("_Flying_Stuff","Dados de v�o");
define("_note_place_and_date","se poss�vel acrescentar cidade, pa�s e data");
define("_Flying_Since","Voando desde");
define("_Pilot_Licence","Licen�a de v�o");
define("_Paragliding_training","Experi�ncia de v�o");
define("_Favorite_Location","Local de v�o favorito");
define("_Usual_Location","Local de v�o habitual");
define("_Best_Flying_Memory","Melhor experi�ncia em v�o");
define("_Worst_Flying_Memory","Pior experi�ncia em v�o");
define("_Personal_Distance_Record","Recorde pessoal de dist�ncia");
define("_Personal_Height_Record","Recorde pessoal de altitude");
define("_Hours_Flown","Horas de v�o");
define("_Hours_Per_Year","Horas voadas anualmente");

define("_Equipment_Stuff","Dados sobre o Equipamento");
define("_Glider","Asa");
define("_Harness","Selete");
define("_Reserve_chute","Paraquedas de emerg�ncia");
define("_Camera","C�mera fotogr�fica");
define("_Vario","V�rio");
define("_GPS","GPS");
define("_Helmet","Capacete");
define("_Camcorder","C�mera de v�deo");

define("_Manouveur_Stuff","Dados sobre manobras de v�o");
define("_note_max_descent_rate","se poss�vel acrescentar a taxa de queda m�xima alcan�ada");
define("_Spiral","Espiral");
define("_Bline","Estol de B");
define("_Full_Stall","Full Stall");
define("_Other_Manouveurs_Acro","Outras manobras Acro");
define("_Sat","Sat");
define("_Asymmetric_Spiral","Espiral assim�trica");
define("_Spin","Negativa");

define("_General_Stuff","Dados gerais");
define("_Favorite_Singer","Cantor favorito");
define("_Favorite_Movie","Filme Favorito");
define("_Favorite_Internet_Site","Website favorito<br>na internet");
define("_Favorite_Book","Livro favorito");
define("_Favorite_Actor","Ator favorito");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","Inserir foto ou modificar a existente");
define("_Delete_Photo","Apagar foto");
define("_Your_profile_has_been_updated","O seu perfil foi atualizado");
define("_Submit_Change_Data","Enviar - Modificar dados");

//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","hh:mm");

define("_Totals","Totais");
define("_First_flight_logged","Primeiro v�o introduzido");
define("_Last_flight_logged","�ltimo v�o introduzido");
define("_Flying_period_covered","Per�odo de v�o coberto");
define("_Total_Distance","Dist�ncia total");
define("_Total_OLC_Score","Pontua��o total OLC");
define("_Total_Hours_Flown","Total de horas de v�o");
define("_Total_num_of_flights","N�mero total de v�os");

define("_Personal_Bests","Melhores resultados pessoais");
define("_Best_Open_Distance","Melhor dist�ncia livre");
define("_Best_FAI_Triangle","Melhor tri�ngulo FAI");
define("_Best_Free_Triangle","Mejor tri�ngulo livre");
define("_Longest_Flight","V�o mais longo");
define("_Best_OLC_score","Melhor pontua��o OLC");

define("_Absolute_Height_Record","Recorde de altitude absoluta");
define("_Altitute_gain_Record","Recorde de ganho de altitude");
define("_Mean_values","Valores m�dios");
define("_Mean_distance_per_flight","Dist�ncias m�dias por v�o");
define("_Mean_flights_per_Month","M�dia de v�os por m�s");
define("_Mean_distance_per_Month","M�dia de dist�ncia por m�s");
define("_Mean_duration_per_Month","M�dia da dura��o de v�o por m�s");
define("_Mean_duration_per_flight","M�dia da dura��o por v�o");
define("_Mean_flights_per_Year","M�dia de v�os por ano");
define("_Mean_distance_per_Year","M�dia de dist�ncias por ano");
define("_Mean_duration_per_Year","M�dia de dura��o de v�o por ano");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","Ver v�os pr�ximos a este ponto");
define("_Waypoint_Name","Nome do Waypoint");
define("_Navigate_with_Google_Earth","Navegar com o Google Earth");
define("_See_it_in_Google_Maps","Ver no Google Maps");
define("_See_it_in_MapQuest","Ver no MapQuest");
define("_COORDINATES","Coordenadas");
define("_FLIGHTS","V�os");
define("_SITE_RECORD","Recorde local");
define("_SITE_INFO","Informa��o sobre o local de v�o");
define("_SITE_REGION","Regi�o");
define("_SITE_LINK","Link com mais informa��o");
define("_SITE_DESCR","Descri��o do local de v�o/Decolagem");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","Veja mais detalhes");
define("_KML_file_made_by","Arquivo KML feito por");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","Acrescentar waypoint");
define("_WAYPOINT_ADDED","O waypoint foi acrescentado");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","Recorde local de (dist�ncia livre)");
	
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

define("_Your_settings_have_been_updated","Os seus dados foram atualizados");

define("_THEME","Tema");
define("_LANGUAGE","Idioma");
define("_VIEW_CATEGORY","Ver categoria");
define("_VIEW_COUNTRY","Ver pa�s");
define("_UNITS_SYSTEM" ,"Unidades");
define("_METRIC_SYSTEM","M�trico (km,m)");
define("_IMPERIAL_SYSTEM","Imperial (milhas,p�s)");
define("_ITEMS_PER_PAGE","Itens por p�gina");

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
define("_Flights_per_Country","V�os por Pa�s");
define("_Takeoffs_per_Country","Descolagens por Pa�s");
define("_INDEX_HEADER","Bem vindo � Liga XC Leonardo");
define("_INDEX_MESSAGE","Utilize o menu principal para navegar ou as prefer�ncias a seguir.");

//--------------------------------------------
// NEW 
//--------------------------------------------
define("_MENU_SUMMARY_PAGE","Primeira (Resumo) P�gina");
define("_Display_ALL","Mostrar Tudo");
define("_Display_NONE","Esconder Tudo");
define("_Reset_to_default_view","Retornar � visualiza��o pr� definida");
define("_No_Club","Sem Clube");
define("_This_is_the_URL_of_this_page","Esta � a URL desta p�gina");
define("_All_glider_types","Todos os tiposde aeronaves");

define("_MENU_SITES_GUIDE","Guia de locais de v�o");
define("_Site_Guide","Guia de Locais");

define("_Search_Options","Op��es de busca");
define("_Below_is_the_list_of_selected_sites","Abaixo est� a lista de locais selecionada");
define("_Clear_this_list","Limpar a lista");
define("_See_the_selected_sites_in_Google_Earth","Ver os locais selecionados no Google Earth");
define("_Available_Takeoffs","Decolagens Registradas");
define("_Search_site_by_name","Procurar por nome");
define("_give_at_least_2_letters","d� ao menos 2 (duas) letras");
define("_takeoff_move_instructions_1","Voc� pode mover todas as decolagens registradas para a lista de sele��o � direita do painel ao usar >> ou selecione uma usando o s�mbolo > ");
define("_Takeoff_Details","Detalhes da decolagem");


define("_Takeoff_Info","Informa��o da Decolagem");
define("_XC_Info","Informa��es XC");
define("_Flight_Info","Informa��es do v�o");

define("_MENU_LOGOUT","Sair");
define("_MENU_LOGIN","Entrar");
define("_MENU_REGISTER","Abrir uma conta");


define("_Africa","�frica");
define("_Europe","Europa");
define("_Asia","�sia");
define("_Australia","Austr�lia");
define("_North_Central_America","Am�rica do Norte e Central");
define("_South_America","Am�rica do Sul");

define("_Recent","Recente");


define("_Unknown_takeoff","Decolagem desconhecida");
define("_Display_on_Google_Earth","Mostrar no Google Earth");
define("_Use_Man_s_Module","Usar o M�dulo Man's");
define("_Line_Color","Cor da linha");
define("_Line_width","Espessura da linha");
define("_unknown_takeoff_tooltip_1","V�o a partir de uma decolagem desconhecida");
define("_unknown_takeoff_tooltip_2","Se voce sabe de qual Decolagem/local este v�o come�ou, por favor clique para inserir o nome !");
define("_EDIT_WAYPOINT","Editar informa��es da Decolagem");
define("_DELETE_WAYPOINT","Remover Decolagem");
define("_SUBMISION_DATE","Data de Envio"); // the date a flight was submited to leonardo
define("_TIMES_VIEWED","Quantidade de visualiza��es"); // the times that this flight havs been viewed


define("_takeoff_add_help_1","Voc� pode entrar com as informa��es da decolagem se a conhecer. Se n�o estiver certo � seguro fechar esta janela");
define("_takeoff_add_help_2","Se o seu v�o � de uma destas decolagens acima da 'Decolagem desconhecida', ent�o n�o � necess�rio entrar com ela novamente. Somente feche esta janela. ");
define("_takeoff_add_help_3","Se voc� v� o nome da decolagem abaixo, clique sobre ele para auto preencher os campos � esquerda.");
define("_Takeoff_Name","Nome da decolagem");
define("_In_Local_Language","Em Portugu�s");
define("_In_English","Em Ingl�s");

// New on 2007/02/20 - login screen
define("_ENTER_PASSWORD","Indique seu usu�rio ou senha para entrar.");
define("_SEND_PASSWORD","Esqueci a senha");
define("_ERROR_LOGIN","Voc� indicou um nome de usuario incorreto / inativo ou senha inv�lida.");
define("_AUTO_LOGIN","Entrar automaticamente a cada visita");
define("_USERNAME","Usu�rio");
define("_PASSWORD","Senha");
define("_PROBLEMS_HELP","Se voc� tem problemas, entre em contato com o administrador");

define("_LOGIN_TRY_AGAIN","Clique %sAqui%s para tentar novamente");
define("_LOGIN_RETURN","Clique %sAqui%s para retornar ao �ndice");
// end 2007/02/20

define("_Category","Categorla");
define("_MEMBER_OF","Utilizador de");
define("_MemberID","ID do utilizador");
define("_EnterID","Entre com ID");
define("_Clubs_Leagues","Clubes / Ligas");
define("_Pilot_Statistics","Estat�sticas do piloto");
define("_National_Rankings","Ranking Nacional");




// new on 2007/03/08
define("_Select_Club","Selecionar Grupo");
define("_Close_window","Fechar Janela");
define("_EnterID","Entrar com a ID");
define("_Club","Clube");
define("_Sponsor","Patrocinador");


// new on 2007/03/13
define('_Go_To_Current_Month','M�s corrente');
define('_Today_is','Hoje �');
define('_Wk','Fd');
define('_Click_to_scroll_to_previous_month','Clique para ir ao m�s anterior. Clique e segure para ir automaticamente.');
define('_Click_to_scroll_to_next_month','Click para ir ao pr�ximo m�s. Segure o bot�o do mouse para navegar automaticamente.');
define('_Click_to_select_a_month','Selecionar o m�s.');
define('_Click_to_select_a_year','Selecionar o Ano.');
define('_Select_date_as_date.','Selecionar Data.'); // do not replace [date], it will be replaced by date.

// end 2007/03/13

define("_SEASON","Temporada"); 
define("_SUBMIT_TO_OLC","Submeter � OLC"); 
define("_pilot_email","Endere�o de E-mail"); 
define("_Sex","Sexo"); 
define("_Login_Stuff","Mudar dados de entrada"); 
define("_PASSWORD_CONFIRMATION","Confirmar senha"); 
define("_EnterPasswordOnlyToChange","Entre somente com a senha, se quiser mud�-la:"); 
define("_PwdAndConfDontMatch","Senha e confirma��o da senha n�o s�o iguais."); 
define("_PwdTooShort","A Senha � muito curta, Deverar ter ao menos $passwordMinLength caracteres."); 
define("_PwdConfEmpty","A senha n�o foi confirmada."); 
define("_PwdChanged","A Senha foi mudada."); 
define("_PwdNotChanged","A senha N�O foi mudada."); 
define("_PwdChangeProblem","Ocorreu um problema mudando a senha."); 
define("_EmailEmpty","O Endere�o de e-mail n�o pode ser vazio."); 
define("_EmailInvalid","O Endere�o de e-mail � inv�lido."); 
define("_EmailSaved","O Endere�o de e-mail foi salvo"); 
define("_EmailNotSaved","O endere�o de e-mail N�O foi salvo."); 
define("_EmailSaveProblem","Ocorreu um problema ao salvar o endere�o de e-mail."); 
define("_PROJECT_HELP","Ajuda"); 
define("_PROJECT_NEWS","Novidades"); 
define("_PROJECT_RULES","Regras 2007"); 
define("_Filter_NoSelection","Nada Selecionado"); 
define("_Filter_CurrentlySelected","Sele��o Corrente"); 
define("_Filter_DialogMultiSelectInfo","Pressione control para sele��o Multipla."); 
define("_Filter_FilterTitleIncluding","Somente [itens] Selecionados"); 
define("_Filter_FilterTitleExcluding","Excluir [itens]"); 
define("_Filter_DialogTitleIncluding","Selecionar [itens]"); 
define("_Filter_DialogTitleExcluding","Selecionar [itens]"); 
define("_Filter_Items_pilot","pilotos"); 
define("_Filter_Items_nacclub","clubes"); 
define("_Filter_Items_country","Pa�ses"); 
define("_Filter_Items_takeoff","Decolagens"); 
define("_Filter_Button_Select","Selecionar"); 
define("_Filter_Button_Delete","Remover"); 
define("_Filter_Button_Accept","Aceitar sele��o"); 
define("_Filter_Button_Cancel","Cancelar"); 
define("_MENU_FILTER_NEW","Filtrar **VERS�O NOVA**"); 
define("_ALL_NACCLUBS","Todos os Clubes"); 
define("_SELECT_NACCLUB","Selecione [nacname]-Clube"); 
define("_FirstOlcYear","Primeiro ano de participa��o em uma Competi��o de XC online"); 
define("_FirstOlcYearComment","Por favor, selecione o ano de sua primeira participa��o de uma competi��o de XC Online, que n�o esta.<br/>Este campo � relevante para &quot;newcomer&quot;-Classifica��o."); 
define("_Select_Brand","Selecione o cadastro"); 
define("_All_Brands","Todos os cadastrados"); 
define("_DAY","DIA"); 
define("_Glider_Brand","Aeronave cadastrada"); 
define("_Or_Select_from_previous","Ou selecione anteriores"); 
define("_Explanation_AddToBookmarks_IE","Adicionar estes filtros para os Favoritos no IE"); 
define("_Msg_AddToBookmarks_IE","Clique aqui para adicionar estas defini��es de filtro nos Favoritos do IE."); 
define("_Explanation_AddToBookmarks_nonIE","(Salvar este link nos Favoritos.)"); 
define("_Msg_AddToBookmarks_nonIE","Para salvar estas defini��es de filtro no seu livro de favoritos, use a fun��o Salvar nos favoritos do Navegador."); 
define("_PROJECT_RULES2","Regras 2008"); 
define("_MEAN_SPEED1","Velocidade m�dia"); 
define("_External_Entry","Entradas Externas"); 
define("_Altitude","Altitude"); 
define("_Speed","Velocidade"); 
define("_Distance_from_takeoff","Dist�ncia da decolagem"); 
define("_LAST_DIGIT","�ltimo d�gito");

define("_BREAKDOWN_PER_TAKEOFF","Breakdown Per Takeoff");
define("_BREAKDOWN_PER_GLIDER","Breakdown Per Glider");
?>

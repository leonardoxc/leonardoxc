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
define("_NUMBER_OF_FLIGHTS","Número de vôos");
define("_BEST_DISTANCE","Melhor distância");
define("_MEAN_KM","Média km por vôo");
define("_TOTAL_KM","Km Totais voados");
define("_TOTAL_DURATION_OF_FLIGHTS","Duração total dos vôos");
define("_MEAN_DURATION","Duração média dos vôos");
define("_TOTAL_OLC_KM","Distância OLC total");
define("_TOTAL_OLC_SCORE","Pontuação OLC total");
define("_BEST_OLC_SCORE","Melhor pontuação OLC");
define("_From","de");

// list_flights()
define("_DURATION_HOURS_MIN","Duração (h:m)");
define("_SHOW","Mostrar");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","O voo será ativado dentro de 1-2 minutos.");
define("_TRY_AGAIN","Por favor tente de novo");

define("_TAKEOFF_LOCATION","Decolagem");
define("_TAKEOFF_TIME","Hora da decolagem");
define("_LANDING_LOCATION","Pouso");
define("_LANDING_TIME","Hora do pouso");
define("_OPEN_DISTANCE","Distância livre");
define("_MAX_DISTANCE","Distância máxima");
define("_OLC_SCORE_TYPE","Tipo de pontuação OLC");
define("_OLC_DISTANCE","Distância OLC");
define("_OLC_SCORING","Pontuação OLC");
define("_MAX_SPEED","Velocidade máxima");
define("_MAX_VARIO","Maior Ascendente");
define("_MEAN_SPEED","Velocidade média");
define("_MIN_VARIO","Maior descendente");
define("_MAX_ALTITUDE","Altitude máxima");
define("_TAKEOFF_ALTITUDE","Altitude da decolagem");
define("_MIN_ALTITUDE","Altitude mínima");
define("_ALTITUDE_GAIN","Ganho de altitude");
define("_FLIGHT_FILE","Arquivo do vôo");
define("_COMMENTS","Comentários");
define("_RELEVANT_PAGE","Endereço da página web relacionada");
define("_GLIDER","Asa");
define("_PHOTOS","Fotos");
define("_MORE_INFO","Informação adicional");
define("_UPDATE_DATA","Atualizar dados");
define("_UPDATE_MAP","Atualizar mapa");
define("_UPDATE_3D_MAP","Atualizar mapa 3D");
define("_UPDATE_GRAPHS","Atualizar gráficos");
define("_UPDATE_SCORE","Atualizar pontuação");

define("_TAKEOFF_COORDS","Coordenadas da decolagem:");
define("_NO_KNOWN_LOCATIONS","Não existem locais conhecidos!");
define("_FLYING_AREA_INFO","Informação do local de vôo");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo XC");
define("_RETURN_TO_TOP","Voltar para o início");
// list flight
define("_PILOT_FLIGHTS","Vôos do piloto");

define("_DATE_SORT","Data");
define("_PILOT_NAME","Nome do piloto");
define("_TAKEOFF","Decolagem");
define("_DURATION","Duração");
define("_LINEAR_DISTANCE","Distância em linha reta");
define("_OLC_KM","OLC km");
define("_OLC_SCORE","Pontuação OLC");
define("_DATE_ADDED","Último envio");

define("_SORTED_BY","Ordenar por:");
define("_ALL_YEARS","Todos os anos");
define("_SELECT_YEAR_MONTH","Selecionar ano e mês");
define("_ALL","Todos");
define("_ALL_PILOTS","Mostrar todos os pilotos");
define("_ALL_TAKEOFFS","Mostrar todas as decolagens");
define("_ALL_THE_YEAR","Ano inteiro");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","Você não enviou um arquivo de vôo");
define("_NO_SUCH_FILE","O arquivo enviado não foi encontrado no servidor");
define("_FILE_DOESNT_END_IN_IGC","O arquivo não tem extensão .igc");
define("_THIS_ISNT_A_VALID_IGC_FILE","Este não é um arquivo válido .igc");
define("_THERE_IS_SAME_DATE_FLIGHT","Já existe um vôo com a mesma data e hora");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","Se deseja substitui-lo deverá antes");
define("_DELETE_THE_OLD_ONE","apagar o anterior");
define("_THERE_IS_SAME_FILENAME_FLIGHT","Já existe um vôo arquivado com o mesmo nome");
define("_CHANGE_THE_FILENAME","Se este vôo é diferente mude o nome do arquivo e tente novamente");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","O vôo foi enviado com sucesso");
define("_PRESS_HERE_TO_VIEW_IT","Visualizar aqui");
define("_WILL_BE_ACTIVATED_SOON","(Será ativado dentro de 1-2 minutos)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Enviar vários vôos");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","Apenas serão processados arquivos IGC");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","Enviar arquivo ZIP contendo os vôos");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","Pressione aqui para enviar os vôos");

define("_FILE_DOESNT_END_IN_ZIP","O arquivo enviado não tem extensão .zip");
define("_ADDING_FILE","Enviando arquivo");
define("_ADDED_SUCESSFULLY","Envio terminado");
define("_PROBLEM","Problema");
define("_TOTAL","Total");
define("_IGC_FILES_PROCESSED","Os vôos foram processados");
define("_IGC_FILES_SUBMITED","Os vôos foram enviados");

// info
define("_DEVELOPMENT","Desenvolvido por");
define("_ANDREADAKIS_MANOLIS","Andreadakis Manolis");
define("_PROJECT_URL","Website do projeto");
define("_VERSION","Versão");
define("_MAP_CREATION","Criação de mapas");
define("_PROJECT_INFO","Informação sobre o projeto");

// menu bar 
define("_MENU_MAIN_MENU","Menu principal");
define("_MENU_DATE","Selecionar data");
define("_MENU_COUNTRY","Selecionar País");
define("_MENU_XCLEAGUE","Liga XC");
define("_MENU_ADMIN","Admin");

define("_MENU_COMPETITION_LEAGUE","Liga - todas as categorias");
define("_MENU_OLC","OLC");
define("_MENU_OPEN_DISTANCE","Distância livre");
define("_MENU_DURATION","Duração");
define("_MENU_ALL_FLIGHTS","Mostrar todos os vôos");
define("_MENU_FLIGHTS","Vôos");
define("_MENU_TAKEOFFS","Decolagem");
define("_MENU_FILTER","Filtro");
define("_MENU_MY_FLIGHTS","Meus vôos");
define("_MENU_MY_PROFILE","Meu perfil");
define("_MENU_MY_STATS","Minhas estatísticas"); 
define("_MENU_MY_SETTINGS","Minhas definições"); 
define("_MENU_SUBMIT_FLIGHT","Enviar vôo");
define("_MENU_SUBMIT_FROM_ZIP","Enviar vôos zip");
define("_MENU_SHOW_PILOTS","Mostrar pilotos");
define("_MENU_SHOW_LAST_ADDED","Mostrar envios recentes");
define("_FLIGHTS_STATS","Estatísticas do vôo");

define("_SELECT_YEAR","Selecionar ano");
define("_SELECT_MONTH","Selecionar mês");
define("_ALL_COUNTRIES","Mostrar todos os países");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","Todos anos");
define("_NUMBER_OF_FLIGHTS","Número de vôos");
define("_TOTAL_DISTANCE","Distância total");
define("_TOTAL_DURATION","Duração total");
define("_BEST_OPEN_DISTANCE","Melhor distância");
define("_TOTAL_OLC_DISTANCE","Distância total OLC");
define("_TOTAL_OLC_SCORE","Pontuação total OLC");
define("_BEST_OLC_SCORE","Melhor pontuação OLC");
define("_MEAN_DURATION","Duração média");
define("_MEAN_DISTANCE","Distância média");
define("_PILOT_STATISTICS_SORT_BY","Pilotos - Ordenar por");
define("_CATEGORY_FLIGHT_NUMBER","Categoria - Número de voos");
define("_CATEGORY_TOTAL_DURATION","Categoria - Duração total");
define("_CATEGORY_OPEN_DISTANCE","Categoría - Distância livre");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","Não existem pilotos para mostrar!");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","O vôo foi apagado");
define("_RETURN","Voltar");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","ATENÇÃO - O vôo vai ser apagado");
define("_THE_DATE","Data");
define("_YES","SIM");
define("_NO","NÃO");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","Resultados da liga");
define("_N_BEST_FLIGHTS","Melhores vôos");
define("_OLC","OLC");
define("_OLC_TOTAL_SCORE","Pontuação total OLC");
define("_KILOMETERS","Kms");
define("_TOTAL_ALTITUDE_GAIN","Ganho total de altitude");
define("_TOTAL_KM","Kms totais");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","é");
define("_IS_NOT","não é");
define("_OR","ou");
define("_AND","e");
define("_FILTER_PAGE_TITLE","Filtro de vôos");
define("_RETURN_TO_FLIGHTS","Voltar aos vôos");
define("_THE_FILTER_IS_ACTIVE","O filtro está ativo");
define("_THE_FILTER_IS_INACTIVE","O filtro está inativo");
define("_SELECT_DATE","Seleccionar data");
define("_SHOW_FLIGHTS","Mostrar vôos");
define("_ALL2","TODOS");
define("_WITH_YEAR","Com ano");
define("_MONTH","Mês");
define("_YEAR","Ano");
define("_FROM","DE");
define("_from","de");
define("_TO","Até");
define("_SELECT_PILOT","Selecionar piloto");
define("_THE_PILOT","O piloto");
define("_THE_TAKEOFF","A decolagem");
define("_SELECT_TAKEOFF","Selecionar decolagem");
define("_THE_COUNTRY","O país");
define("_COUNTRY","País");
define("_SELECT_COUNTRY","Selecionar país");
define("_OTHER_FILTERS","Outros filtros");
define("_LINEAR_DISTANCE_SHOULD_BE","A distância livre deve ser");
define("_OLC_DISTANCE_SHOULD_BE","A distância OLC deve ser");
define("_OLC_SCORE_SHOULD_BE","A pontuação OLC deve ser");
define("_DURATION_SHOULD_BE","A duração deve ser");
define("_ACTIVATE_CHANGE_FILTER","Ativar / mudar FILTRO");
define("_DEACTIVATE_FILTER","Desativar FILTRO");
define("_HOURS","horas");
define("_MINUTES","minutos");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","Enviar vôo");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(só é necessário o arquivo IGC)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","Enviar o arquivo IGC do vôo");
define("_NOTE_TAKEOFF_NAME","Por favor escreva o nome da decolagem e país");
define("_COMMENTS_FOR_THE_FLIGHT","Comentários sobre o vôo");
define("_PHOTO","Foto");
define("_PHOTOS_GUIDELINES","As fotos devem estar em formato jpg e ter tamhno inferior a ");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","Pressionar aqui para enviar o vôo");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","¿Pretende enviar diversos vôos simultaneamente?");
define("_PRESS_HERE","Pressionar aqui");

define("_IS_PRIVATE","Não mostrar ao público");
define("_MAKE_THIS_FLIGHT_PRIVATE","Não mostrar ao público");
define("_INSERT_FLIGHT_AS_USER_ID","Introduzir o vôo como ID do utilizador");
define("_FLIGHT_IS_PRIVATE","Este vôo é privado");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","Mudar dados do vôo");
define("_IGC_FILE_OF_THE_FLIGHT","Arquivo IGC do vôo");
define("_DELETE_PHOTO","Apagar foto");
define("_NEW_PHOTO","Nova foto");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","Pressione aqui para modificar os dados do vôo");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","As modificações foram efetuadas com sucesso");
define("_RETURN_TO_FLIGHT","Voltar ao vôo");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","Voltar ao vôo");
define("_READY_FOR_SUBMISSION","Pronto para envio");
define("_OLC_MAP","Mapa");
define("_OLC_BARO","Barógrafo");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","Perfil do piloto");
define("_back_to_flights","Voltar");
define("_pilot_stats","Estatísticas do piloto");
define("_edit_profile","Editar perfil");
define("_flights_stats","Estatísticas do voo");
define("_View_Profile","Ver perfil");

define("_Personal_Stuff","Dados pessoais");
define("_First_Name"," Nome");
define("_Last_Name","Sobrenome");
define("_Birthdate","Data de nascimento");
define("_dd_mm_yy","dd.mm.aa");
define("_Sign","Signo");
define("_Marital_Status","Estado Civil");
define("_Occupation","Ocupação");
define("_Web_Page","Página Web");
define("_N_A","N/A");
define("_Other_Interests","Outros Interesses");
define("_Photo","Foto");

define("_Flying_Stuff","Dados de vôo");
define("_note_place_and_date","se possível acrescentar cidade, país e data");
define("_Flying_Since","Voando desde");
define("_Pilot_Licence","Licença de vôo");
define("_Paragliding_training","Experiência de vôo");
define("_Favorite_Location","Local de vôo favorito");
define("_Usual_Location","Local de vôo habitual");
define("_Best_Flying_Memory","Melhor experiência em vôo");
define("_Worst_Flying_Memory","Pior experiência em vôo");
define("_Personal_Distance_Record","Recorde pessoal de distância");
define("_Personal_Height_Record","Recorde pessoal de altitude");
define("_Hours_Flown","Horas de vôo");
define("_Hours_Per_Year","Horas voadas anualmente");

define("_Equipment_Stuff","Dados sobre o Equipamento");
define("_Glider","Asa");
define("_Harness","Selete");
define("_Reserve_chute","Paraquedas de emergência");
define("_Camera","Câmera fotográfica");
define("_Vario","Vário");
define("_GPS","GPS");
define("_Helmet","Capacete");
define("_Camcorder","Câmera de vídeo");

define("_Manouveur_Stuff","Dados sobre manobras de vôo");
define("_note_max_descent_rate","se possível acrescentar a taxa de queda máxima alcançada");
define("_Spiral","Espiral");
define("_Bline","Estol de B");
define("_Full_Stall","Full Stall");
define("_Other_Manouveurs_Acro","Outras manobras Acro");
define("_Sat","Sat");
define("_Asymmetric_Spiral","Espiral assimétrica");
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
define("_First_flight_logged","Primeiro vôo introduzido");
define("_Last_flight_logged","Último vôo introduzido");
define("_Flying_period_covered","Período de vôo coberto");
define("_Total_Distance","Distância total");
define("_Total_OLC_Score","Pontuação total OLC");
define("_Total_Hours_Flown","Total de horas de vôo");
define("_Total_num_of_flights","Número total de vôos");

define("_Personal_Bests","Melhores resultados pessoais");
define("_Best_Open_Distance","Melhor distância livre");
define("_Best_FAI_Triangle","Melhor triângulo FAI");
define("_Best_Free_Triangle","Mejor triângulo livre");
define("_Longest_Flight","Vôo mais longo");
define("_Best_OLC_score","Melhor pontuação OLC");

define("_Absolute_Height_Record","Recorde de altitude absoluta");
define("_Altitute_gain_Record","Recorde de ganho de altitude");
define("_Mean_values","Valores médios");
define("_Mean_distance_per_flight","Distâncias médias por vôo");
define("_Mean_flights_per_Month","Média de vôos por mês");
define("_Mean_distance_per_Month","Média de distância por mês");
define("_Mean_duration_per_Month","Média da duração de vôo por mês");
define("_Mean_duration_per_flight","Média da duração por vôo");
define("_Mean_flights_per_Year","Média de vôos por ano");
define("_Mean_distance_per_Year","Média de distâncias por ano");
define("_Mean_duration_per_Year","Média de duração de vôo por ano");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","Ver vôos próximos a este ponto");
define("_Waypoint_Name","Nome do Waypoint");
define("_Navigate_with_Google_Earth","Navegar com o Google Earth");
define("_See_it_in_Google_Maps","Ver no Google Maps");
define("_See_it_in_MapQuest","Ver no MapQuest");
define("_COORDINATES","Coordenadas");
define("_FLIGHTS","Vôos");
define("_SITE_RECORD","Recorde local");
define("_SITE_INFO","Informação sobre o local de vôo");
define("_SITE_REGION","Região");
define("_SITE_LINK","Link com mais informação");
define("_SITE_DESCR","Descrição do local de vôo/Decolagem");

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
define("_SITE_RECORD_OPEN_DISTANCE","Recorde local de (distância livre)");
	
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
define("_VIEW_COUNTRY","Ver país");
define("_UNITS_SYSTEM" ,"Unidades");
define("_METRIC_SYSTEM","Métrico (km,m)");
define("_IMPERIAL_SYSTEM","Imperial (milhas,pés)");
define("_ITEMS_PER_PAGE","Itens por página");

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
define("_Flights_per_Country","Vôos por País");
define("_Takeoffs_per_Country","Descolagens por País");
define("_INDEX_HEADER","Bem vindo à Liga XC Leonardo");
define("_INDEX_MESSAGE","Utilize o menu principal para navegar ou as preferências a seguir.");

//--------------------------------------------
// NEW 
//--------------------------------------------
define("_MENU_SUMMARY_PAGE","Primeira (Resumo) Página");
define("_Display_ALL","Mostrar Tudo");
define("_Display_NONE","Esconder Tudo");
define("_Reset_to_default_view","Retornar à visualização pré definida");
define("_No_Club","Sem Clube");
define("_This_is_the_URL_of_this_page","Esta é a URL desta página");
define("_All_glider_types","Todos os tiposde aeronaves");

define("_MENU_SITES_GUIDE","Guia de locais de vôo");
define("_Site_Guide","Guia de Locais");

define("_Search_Options","Opções de busca");
define("_Below_is_the_list_of_selected_sites","Abaixo está a lista de locais selecionada");
define("_Clear_this_list","Limpar a lista");
define("_See_the_selected_sites_in_Google_Earth","Ver os locais selecionados no Google Earth");
define("_Available_Takeoffs","Decolagens Registradas");
define("_Search_site_by_name","Procurar por nome");
define("_give_at_least_2_letters","dê ao menos 2 (duas) letras");
define("_takeoff_move_instructions_1","Você pode mover todas as decolagens registradas para a lista de seleção à direita do painel ao usar >> ou selecione uma usando o símbolo > ");
define("_Takeoff_Details","Detalhes da decolagem");


define("_Takeoff_Info","Informação da Decolagem");
define("_XC_Info","Informações XC");
define("_Flight_Info","Informações do vôo");

define("_MENU_LOGOUT","Sair");
define("_MENU_LOGIN","Entrar");
define("_MENU_REGISTER","Abrir uma conta");


define("_Africa","África");
define("_Europe","Europa");
define("_Asia","Ásia");
define("_Australia","Austrália");
define("_North_Central_America","América do Norte e Central");
define("_South_America","América do Sul");

define("_Recent","Recente");


define("_Unknown_takeoff","Decolagem desconhecida");
define("_Display_on_Google_Earth","Mostrar no Google Earth");
define("_Use_Man_s_Module","Usar o Módulo Man's");
define("_Line_Color","Cor da linha");
define("_Line_width","Espessura da linha");
define("_unknown_takeoff_tooltip_1","Vôo a partir de uma decolagem desconhecida");
define("_unknown_takeoff_tooltip_2","Se voce sabe de qual Decolagem/local este vôo começou, por favor clique para inserir o nome !");
define("_EDIT_WAYPOINT","Editar informações da Decolagem");
define("_DELETE_WAYPOINT","Remover Decolagem");
define("_SUBMISION_DATE","Data de Envio"); // the date a flight was submited to leonardo
define("_TIMES_VIEWED","Quantidade de visualizações"); // the times that this flight havs been viewed


define("_takeoff_add_help_1","Você pode entrar com as informações da decolagem se a conhecer. Se não estiver certo é seguro fechar esta janela");
define("_takeoff_add_help_2","Se o seu vôo é de uma destas decolagens acima da 'Decolagem desconhecida', então não é necessário entrar com ela novamente. Somente feche esta janela. ");
define("_takeoff_add_help_3","Se você vê o nome da decolagem abaixo, clique sobre ele para auto preencher os campos à esquerda.");
define("_Takeoff_Name","Nome da decolagem");
define("_In_Local_Language","Em Português");
define("_In_English","Em Inglês");

// New on 2007/02/20 - login screen
define("_ENTER_PASSWORD","Indique seu usuário ou senha para entrar.");
define("_SEND_PASSWORD","Esqueci a senha");
define("_ERROR_LOGIN","Você indicou um nome de usuario incorreto / inativo ou senha inválida.");
define("_AUTO_LOGIN","Entrar automaticamente a cada visita");
define("_USERNAME","Usuário");
define("_PASSWORD","Senha");
define("_PROBLEMS_HELP","Se você tem problemas, entre em contato com o administrador");

define("_LOGIN_TRY_AGAIN","Clique %sAqui%s para tentar novamente");
define("_LOGIN_RETURN","Clique %sAqui%s para retornar ao índice");
// end 2007/02/20

define("_Category","Categorla");
define("_MEMBER_OF","Utilizador de");
define("_MemberID","ID do utilizador");
define("_EnterID","Entre com ID");
define("_Clubs_Leagues","Clubes / Ligas");
define("_Pilot_Statistics","Estatísticas do piloto");
define("_National_Rankings","Ranking Nacional");




// new on 2007/03/08
define("_Select_Club","Selecionar Grupo");
define("_Close_window","Fechar Janela");
define("_EnterID","Entrar com a ID");
define("_Club","Clube");
define("_Sponsor","Patrocinador");


// new on 2007/03/13
define('_Go_To_Current_Month','Mês corrente');
define('_Today_is','Hoje é');
define('_Wk','Fd');
define('_Click_to_scroll_to_previous_month','Clique para ir ao mês anterior. Clique e segure para ir automaticamente.');
define('_Click_to_scroll_to_next_month','Click para ir ao próximo mês. Segure o botão do mouse para navegar automaticamente.');
define('_Click_to_select_a_month','Selecionar o mês.');
define('_Click_to_select_a_year','Selecionar o Ano.');
define('_Select_date_as_date.','Selecionar Data.'); // do not replace [date], it will be replaced by date.

// end 2007/03/13

define("_SEASON","Temporada"); 
define("_SUBMIT_TO_OLC","Submeter à OLC"); 
define("_pilot_email","Endereço de E-mail"); 
define("_Sex","Sexo"); 
define("_Login_Stuff","Mudar dados de entrada"); 
define("_PASSWORD_CONFIRMATION","Confirmar senha"); 
define("_EnterPasswordOnlyToChange","Entre somente com a senha, se quiser mudá-la:"); 
define("_PwdAndConfDontMatch","Senha e confirmação da senha não são iguais."); 
define("_PwdTooShort","A Senha é muito curta, Deverar ter ao menos $passwordMinLength caracteres."); 
define("_PwdConfEmpty","A senha não foi confirmada."); 
define("_PwdChanged","A Senha foi mudada."); 
define("_PwdNotChanged","A senha NÃO foi mudada."); 
define("_PwdChangeProblem","Ocorreu um problema mudando a senha."); 
define("_EmailEmpty","O Endereço de e-mail não pode ser vazio."); 
define("_EmailInvalid","O Endereço de e-mail é inválido."); 
define("_EmailSaved","O Endereço de e-mail foi salvo"); 
define("_EmailNotSaved","O endereço de e-mail NÃO foi salvo."); 
define("_EmailSaveProblem","Ocorreu um problema ao salvar o endereço de e-mail."); 
define("_PROJECT_HELP","Ajuda"); 
define("_PROJECT_NEWS","Novidades"); 
define("_PROJECT_RULES","Regras 2007"); 
define("_Filter_NoSelection","Nada Selecionado"); 
define("_Filter_CurrentlySelected","Seleção Corrente"); 
define("_Filter_DialogMultiSelectInfo","Pressione control para seleção Multipla."); 
define("_Filter_FilterTitleIncluding","Somente [itens] Selecionados"); 
define("_Filter_FilterTitleExcluding","Excluir [itens]"); 
define("_Filter_DialogTitleIncluding","Selecionar [itens]"); 
define("_Filter_DialogTitleExcluding","Selecionar [itens]"); 
define("_Filter_Items_pilot","pilotos"); 
define("_Filter_Items_nacclub","clubes"); 
define("_Filter_Items_country","Países"); 
define("_Filter_Items_takeoff","Decolagens"); 
define("_Filter_Button_Select","Selecionar"); 
define("_Filter_Button_Delete","Remover"); 
define("_Filter_Button_Accept","Aceitar seleção"); 
define("_Filter_Button_Cancel","Cancelar"); 
define("_MENU_FILTER_NEW","Filtrar **VERSÃO NOVA**"); 
define("_ALL_NACCLUBS","Todos os Clubes"); 
define("_SELECT_NACCLUB","Selecione [nacname]-Clube"); 
define("_FirstOlcYear","Primeiro ano de participação em uma Competição de XC online"); 
define("_FirstOlcYearComment","Por favor, selecione o ano de sua primeira participação de uma competição de XC Online, que não esta.<br/>Este campo é relevante para &quot;newcomer&quot;-Classificação."); 
define("_Select_Brand","Selecione o cadastro"); 
define("_All_Brands","Todos os cadastrados"); 
define("_DAY","DIA"); 
define("_Glider_Brand","Aeronave cadastrada"); 
define("_Or_Select_from_previous","Ou selecione anteriores"); 
define("_Explanation_AddToBookmarks_IE","Adicionar estes filtros para os Favoritos no IE"); 
define("_Msg_AddToBookmarks_IE","Clique aqui para adicionar estas definições de filtro nos Favoritos do IE."); 
define("_Explanation_AddToBookmarks_nonIE","(Salvar este link nos Favoritos.)"); 
define("_Msg_AddToBookmarks_nonIE","Para salvar estas definições de filtro no seu livro de favoritos, use a função Salvar nos favoritos do Navegador."); 
define("_PROJECT_RULES2","Regras 2008"); 
define("_MEAN_SPEED1","Velocidade média"); 
define("_External_Entry","Entradas Externas"); 
define("_Altitude","Altitude"); 
define("_Speed","Velocidade"); 
define("_Distance_from_takeoff","Distância da decolagem"); 
define("_LAST_DIGIT","Último dígito");
//--------------------------------------------------------
//--------------------------------------------------------
// Missing defines , autoreplaced values from 'english' 
//--------------------------------------------------------
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
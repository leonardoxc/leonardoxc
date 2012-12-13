<?php
/**************************************************************************/
/* Spanish language                                                       */
/* ================                                                       */
/* Initial translation by:                                                */
/*   * Ale Spitznagel (contacto@parapente.com.ar)                         */
/* Currently maintained by:                                               */
/*   * Fernando García (fernando.gs@gmail.com)                            */
/**************************************************************************/

/************************************************************************/
/* Leonardo: Gliding XC Server					                                */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://leonardo.thenet.gr 										                      	*/
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
	$monthList=array('Enero','Febrero','Marzo','Abril','Mayo','Junio',
					'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
	$monthListShort=array('ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC');
	$weekdaysList=array('Lun','Mar','Mie','Jue','Vie','Sab','Dom') ;
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","Distancia Libre");
define("_FREE_TRIANGLE","Triángulo Libre");
define("_FAI_TRIANGLE","Triángulo FAI");

define("_SUBMIT_FLIGHT_ERROR","Ocurrió un problema enviando el vuelo");
define("_SEASON","Temporada"); 

// list_pilots()
define("_NUM","#");
define("_PILOT","Piloto");
define("_NUMBER_OF_FLIGHTS","Número de vuelos");
define("_BEST_DISTANCE","Mejor Distancia");
define("_MEAN_KM","Media # km por vuelo");
define("_TOTAL_KM","Km Totales volados");
define("_TOTAL_DURATION_OF_FLIGHTS","Duración total de vuelos");
define("_MEAN_DURATION","Duración Media de vuelos");
define("_TOTAL_OLC_KM","Distancia Total OLC");
define("_From","de");

// list_flights()
define("_DURATION_HOURS_MIN","Dur (h:m)");
define("_SHOW","Mostrar");

// show flight
define("_FLIGHT_WILL_BE_ACTIVATED_SOON","El vuelo será activado en 1-2 minutos. ");
define("_TRY_AGAIN","Por favor probá de nuevamente luego");

define("_TAKEOFF_LOCATION","Despegue");
define("_TAKEOFF_TIME","Hora de Despegue");
define("_LANDING_LOCATION","Aterrizaje");
define("_LANDING_TIME","Hora de Aterrizaje");
define("_OPEN_DISTANCE","Distancia lineal");
define("_MAX_DISTANCE","Distancia Máx.");
define("_OLC_SCORE_TYPE","Tipo de puntuación OLC");
define("_OLC_DISTANCE","Distancia OLC");
define("_OLC_SCORING","Puntuación OLC");
define("_MAX_SPEED","Velocidad Máx.");
define("_MAX_VARIO","Vario Máx.");
define("_MEAN_SPEED","Velocidad media");
define("_MIN_VARIO","Vario Mín.");
define("_MAX_ALTITUDE","Alt. Máx. (SNM)");
define("_TAKEOFF_ALTITUDE","Alt. Despegue (SNM)");
define("_MIN_ALTITUDE","Alt. Mín. (SNM)");
define("_ALTITUDE_GAIN","Ganacia de altura");
define("_FLIGHT_FILE","Archivo de vuelo");
define("_COMMENTS","Comentarios");
define("_RELEVANT_PAGE","Sitio relacionado");
define("_GLIDER","Ala");
define("_PHOTOS","Fotos");
define("_MORE_INFO","Adicionales");
define("_UPDATE_DATA","Actualizar datos");
define("_UPDATE_MAP","Actualizar mapa");
define("_UPDATE_3D_MAP","Actualizar mapa 3D");
define("_UPDATE_GRAPHS","Actualizar gráficas");
define("_UPDATE_SCORE","Actualizar puntuación");

define("_TAKEOFF_COORDS","Coordenadas del despegue:");
define("_NO_KNOWN_LOCATIONS","¡No hay ubicaciones conocidas!");
define("_FLYING_AREA_INFO","Información de la zona");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo XC");
define("_RETURN_TO_TOP","^ subir ^");
// list flight
define("_PILOT_FLIGHTS","Vuelos del Piloto");

define("_DATE_SORT","Fecha");
define("_PILOT_NAME","Nombre del Piloto");
define("_TAKEOFF","Despegue");
define("_DURATION","Duración");
define("_LINEAR_DISTANCE","Distancia Libre");
define("_OLC_KM","OLC km");
define("_OLC_SCORE","Puntuación OLC");
define("_DATE_ADDED","Ultimo envio");

define("_SORTED_BY","Ordenar por:");
define("_ALL_YEARS","Todos los años");
define("_SELECT_YEAR_MONTH","Seleccionar año (y mes)");
define("_ALL","Todos");
define("_ALL_PILOTS","Mostrar todos los pilotos");
define("_ALL_TAKEOFFS","Mostrar todos los despegues");
define("_ALL_THE_YEAR","Todos los años");

// add flight
define("_YOU_HAVENT_SUPPLIED_A_FLIGHT_FILE","No has proporcionado un archivo de vuelo");
define("_NO_SUCH_FILE","El archivo que has proporcionado no puede ser encontrado en el servidor");
define("_FILE_DOESNT_END_IN_IGC","El archivo no tiene extensión .igc");
define("_THIS_ISNT_A_VALID_IGC_FILE","Este no es un archivo válido .igc");
define("_THERE_IS_SAME_DATE_FLIGHT","Existe ya un vuelo con la misma fecha y hora");
define("_IF_YOU_WANT_TO_SUBSTITUTE_IT","Si deseas reemplazarlo debes primero");
define("_DELETE_THE_OLD_ONE","borrar el anterior");
define("_THERE_IS_SAME_FILENAME_FLIGHT","Existe ya un vuelo con el mismo nombre de archivo");
define("_CHANGE_THE_FILENAME","Si este vuelo es uno diferente por favor cambiale el nombre de archivo e intentalo de nuevo");
define("_YOUR_FLIGHT_HAS_BEEN_SUBMITTED","Tu vuelo ha sido enviado");
define("_PRESS_HERE_TO_VIEW_IT","Pincha aquí para verlo");
define("_WILL_BE_ACTIVATED_SOON","(será activado en 1-2 minutos)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Enviar varios vuelos");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","Solo se procesarán archivos IGC");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","Enviar archivo ZIP<br>conteniendo los vuelos");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","Pincha aquí para enviar los vuelos");

define("_FILE_DOESNT_END_IN_ZIP","El archivo enviado no tiene extensión .zip");
define("_ADDING_FILE","Enviando archivo");
define("_ADDED_SUCESSFULLY","Envio finalizado");
define("_PROBLEM","Problema");
define("_TOTAL","Total de ");
define("_IGC_FILES_PROCESSED","vuelos han sido procesados");
define("_IGC_FILES_SUBMITED","vuelos han sido enviados");

// info
define("_DEVELOPMENT","Desarrollo");
define("_ANDREADAKIS_MANOLIS","Andreadakis Manolis");
define("_PROJECT_URL","Sitio del proyecto");
define("_VERSION","Versión");
define("_MAP_CREATION","Creación de Mapas");
define("_PROJECT_INFO","Información sobre LeonardoXC");

// menu bar 
define("_MENU_MAIN_MENU","Menú Principal");
define("_MENU_DATE","Seleccionar Fecha");
define("_MENU_COUNTRY","Seleccionar País");
define("_MENU_XCLEAGUE","Liga XC");
define("_MENU_ADMIN","Admin");

define("_MENU_COMPETITION_LEAGUE","Liga - todas las categorías");
define("_MENU_OLC","Por puntuación OLC");
define("_MENU_OPEN_DISTANCE","Por distancia Libre");
define("_MENU_DURATION","Por duración");
define("_MENU_ALL_FLIGHTS","Mostrar todos los vuelos");
define("_MENU_FLIGHTS","Por número de vuelos");
define("_MENU_TAKEOFFS","Despegues");
define("_MENU_FILTER","Filtrar");
define("_MENU_MY_FLIGHTS","Mis vuelos");
define("_MENU_MY_PROFILE","Mi perfil");
define("_MENU_MY_STATS","Mis estadísticas"); 
define("_MENU_MY_SETTINGS","Mis opciones de navegación"); 
define("_MENU_SUBMIT_FLIGHT","Enviar vuelo");
define("_MENU_SUBMIT_FROM_ZIP","Enviar vuelos desde zip");
define("_MENU_SHOW_PILOTS","Pilotos");
define("_MENU_SHOW_LAST_ADDED","Mostrar envios recientes");
define("_FLIGHTS_STATS","Estadísticas de todos los vuelos");

define("_SELECT_YEAR","Seleccionar año");
define("_SELECT_MONTH","Seleccionar mes");
define("_ALL_COUNTRIES","Mostrar todos los países");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","De todos los tiempos");
define("_NUMBER_OF_FLIGHTS","Número de vuelos");
define("_TOTAL_DISTANCE","Distacia total");
define("_TOTAL_DURATION","Duración total");
define("_BEST_OPEN_DISTANCE","Mejor distancia");
define("_TOTAL_OLC_DISTANCE","Distancia total OLC");
define("_TOTAL_OLC_SCORE","Puntuación total OLC");
define("_BEST_OLC_SCORE","Mejor puntuación OLC");
define("_MEAN_DURATION","Duración media");
define("_MEAN_DISTANCE","Distancia media");
define("_PILOT_STATISTICS_SORT_BY","Pilotos - Ordenar por");
define("_CATEGORY_FLIGHT_NUMBER","Categoría 'FastJoe' - Número de vuelos");
define("_CATEGORY_TOTAL_DURATION","Categoría 'DURACELL' - Duración total");
define("_CATEGORY_OPEN_DISTANCE","Categoría 'Distancia Libre'");
define("_THERE_ARE_NO_PILOTS_TO_DISPLAY","¡No hay pilotos para mostrar!");

	
//--------------------------------------------
// delete_flight.php
//--------------------------------------------

define("_THE_FLIGHT_HAS_BEEN_DELETED","El vuelo ha sido borrado");
define("_RETURN","Volver");
define("_CAUTION_THE_FLIGHT_WILL_BE_DELETED","PRECAUCION - Estas a punto de borrar este vuelo");
define("_THE_DATE","Fecha ");
define("_YES","SI");
define("_NO","NO");

//--------------------------------------------
// competition.php
//--------------------------------------------

define("_LEAGUE_RESULTS","Resultados de liga");
define("_N_BEST_FLIGHTS","mejores vuelos");
define("_OLC","OLC");
define("_OLC_TOTAL_SCORE","Puntuación total OLC");
define("_KILOMETERS","Kilómetros");
define("_TOTAL_ALTITUDE_GAIN","Ganacia total de altura");
define("_TOTAL_KM","Km totales");

//--------------------------------------------
// filter.php
//--------------------------------------------

define("_IS","es");
define("_IS_NOT","no es");
define("_OR","o");
define("_AND","y");
define("_FILTER_PAGE_TITLE","Filtro de vuelos");
define("_RETURN_TO_FLIGHTS","Volver a vuelos");
define("_THE_FILTER_IS_ACTIVE","El filtro está activo");
define("_THE_FILTER_IS_INACTIVE","El filtro está inactivo");
define("_SELECT_DATE","Seleccionar fecha");
define("_SHOW_FLIGHTS","Mostrar vuelos");
define("_ALL2","TODOS");
define("_WITH_YEAR","Con año");
define("_MONTH","Mes");
define("_YEAR","Año");
define("_FROM","De");
define("_from","de");
define("_TO","Hasta");
define("_SELECT_PILOT","Seleccionar piloto");
define("_THE_PILOT","El piloto");
define("_THE_TAKEOFF","El despegue");
define("_SELECT_TAKEOFF","Seleccionar despegue");
define("_THE_COUNTRY","El país");
define("_COUNTRY","País");
define("_SELECT_COUNTRY","Seleccionar país");
define("_OTHER_FILTERS","Otros filtros");
define("_LINEAR_DISTANCE_SHOULD_BE","La distancia lineal debe ser");
define("_OLC_DISTANCE_SHOULD_BE","La distancia OLC debe ser");
define("_OLC_SCORE_SHOULD_BE","La puntuación OLC debe ser");
define("_DURATION_SHOULD_BE","La duración debe ser");
define("_ACTIVATE_CHANGE_FILTER","Activar / Cambiar Filtro");
define("_DEACTIVATE_FILTER","Desactivar Filtro");
define("_HOURS","horas");
define("_MINUTES","min");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","Enviar vuelo");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(sólo es necesario el archivo IGC)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","Enviar el<br>archivo IGC del vuelo");
define("_NOTE_TAKEOFF_NAME","Por favor, escribe el nombre del despegue, la ubicación y el país");
define("_COMMENTS_FOR_THE_FLIGHT","Comentarios del vuelo");
define("_PHOTO","Foto");
define("_PHOTOS_GUIDELINES","Las fotos deben estar en formato jpg y con un tamaño menor a ");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","Pincha aquí para enviar el vuelo");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","¿Querés enviar varios vuelos juntos?");
define("_PRESS_HERE","Pincha aquí");

define("_IS_PRIVATE","No mostrar público");
define("_MAKE_THIS_FLIGHT_PRIVATE","No mostrar público");
define("_INSERT_FLIGHT_AS_USER_ID","Insertar vuelo como ID del usuario");
define("_FLIGHT_IS_PRIVATE","Este vuelo es privado");

//--------------------------------------------
// edit_flight.php
//--------------------------------------------

define("_CHANGE_FLIGHT_DATA","Cambiar datos del vuelo");
define("_IGC_FILE_OF_THE_FLIGHT","Archivo IGC del vuelo");
define("_DELETE_PHOTO","Borrar");
define("_NEW_PHOTO","nueva foto");
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","Pincha aquí para cambiar los datos del vuelo");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","Los cambios han sido aplicados");
define("_RETURN_TO_FLIGHT","Volver al vuelo");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","Volver al vuelo");
define("_READY_FOR_SUBMISSION","Listo para enviar");
define("_OLC_MAP","Mapa");
define("_OLC_BARO","Barograma");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","Perfil del piloto");
define("_back_to_flights","^ subir ^");
define("_pilot_stats","Estadísticas del piloto");
define("_edit_profile","Editar perfil");
define("_flights_stats","Estadísticas de vuelo");
define("_View_Profile","Ver perfil");

define("_Personal_Stuff","Datos Personales");
define("_First_Name"," Nombres");
define("_Last_Name","Apellidos");
define("_Birthdate","Fecha de Nacimiento");
define("_dd_mm_yy","dd.mm.aa");
define("_Sign","Signo");
define("_Marital_Status","Estado Civil");
define("_Occupation","Ocupación");
define("_Web_Page","Sitio Web");
define("_N_A","N/D");
define("_Other_Interests","Otros Intereses");
define("_Photo","Foto");

define("_Flying_Stuff","Datos de Vuelo");
define("_note_place_and_date","si es posible agregá lugar-país y fecha");
define("_Flying_Since","Volando Desde");
define("_Pilot_Licence","Licencia de Piloto");
define("_Paragliding_training","Entrenamiento en Parapente");
define("_Favorite_Location","Lugar Favorito");
define("_Usual_Location","Lugar Frecuente");
define("_Best_Flying_Memory","Mejor Experiencia en Vuelo");
define("_Worst_Flying_Memory","Peor Experiencia en Vuelo");
define("_Personal_Distance_Record","Record Personal de Distancia");
define("_Personal_Height_Record","Record Personal de Altura");
define("_Hours_Flown","Horas Voladas");
define("_Hours_Per_Year","Horas Voladas por Año");

define("_Equipment_Stuff","Datos del Equipo");
define("_Glider","Ala");
define("_Harness","Arnés");
define("_Reserve_chute","Paracaídas de Emergencia");
define("_Camera","Cámara");
define("_Vario","Vario");
define("_GPS","GPS");
define("_Helmet","Casco");
define("_Camcorder","Filmadora");

define("_Manouveur_Stuff","Datos de Maniobras");
define("_note_max_descent_rate","si es posible agregá la tasa de caída máxima alcanzada");
define("_Spiral","Espiral");
define("_Bline","Bandas B");
define("_Full_Stall","Pérdida");
define("_Other_Manouveurs_Acro","Otras Maniobras Acro");
define("_Sat","SAT");
define("_Asymmetric_Spiral","Asimétrico");
define("_Spin","Negativo");

define("_General_Stuff","Datos Generales");
define("_Favorite_Singer","Cantante Favorito");
define("_Favorite_Movie","Película Favorita");
define("_Favorite_Internet_Site","Sitio Favorito<br>En Internet");
define("_Favorite_Book","Libro Favorito");
define("_Favorite_Actor","Actor Favorito");

//--------------------------------------------
// pilot_profile_edit.php
//--------------------------------------------
define("_Upload_new_photo_or_change_old","Agregar Foto o cambiar la existente");
define("_Delete_Photo","Borrar Foto");
define("_Your_profile_has_been_updated","Tu perfil ha sido actualizado");
define("_Submit_Change_Data","Enviar - Cambiar Datos");

//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","hh:mm");

define("_Totals","Totales");
define("_First_flight_logged","Primer vuelo ingresado");
define("_Last_flight_logged","Ultimo vuelo ingresado");
define("_Flying_period_covered","Período de vuelo cubierto");
define("_Total_Distance","Distancia Total");
define("_Total_OLC_Score","Puntuación Total OLC");
define("_Total_Hours_Flown","Total de Horas de Vuelo");
define("_Total_num_of_flights","Cantidad de Vuelos ");

define("_Personal_Bests","Mejores Resultados Personales");
define("_Best_Open_Distance","Mejor Distancia Libre");
define("_Best_FAI_Triangle","Mejor Triángulo FAI");
define("_Best_Free_Triangle","Mejor Triángulo Libre");
define("_Longest_Flight","Vuelo Más Largo");
define("_Best_OLC_score","Mejor Puntuación OLC");

define("_Absolute_Height_Record","Record de Altura Absoluta");
define("_Altitute_gain_Record","Record en ganacia de Altura");
define("_Mean_values","Valores Promedio");
define("_Mean_distance_per_flight","Distancia Promedio por Vuelo");
define("_Mean_flights_per_Month","Vuelos Promedio por Mes");
define("_Mean_distance_per_Month","Distancia Promedio por Mes");
define("_Mean_duration_per_Month","Duración Promedio por Mes");
define("_Mean_duration_per_flight","Duración Promedio por Vuelo");
define("_Mean_flights_per_Year","Vuelos Promedio por Año");
define("_Mean_distance_per_Year","Distancia Promedio por Año");
define("_Mean_duration_per_Year","Duración Promedio por Año");

//--------------------------------------------
// show_waypoint.php
//--------------------------------------------
define("_See_flights_near_this_point","Ver vuelos cercanos a este punto");
define("_Waypoint_Name","Nombre de Waypoint");
define("_Navigate_with_Google_Earth","Navegar con Google Earth");
define("_See_it_in_Google_Maps","Ver en Google Maps");
define("_See_it_in_MapQuest","Ver en MapQuest");
define("_COORDINATES","Coordenadas");
define("_FLIGHTS","Vuelos");
define("_SITE_RECORD","Record de la zona");
define("_SITE_INFO","Información de la zona");
define("_SITE_REGION","Región");
define("_SITE_LINK","Enlace a mayor información");
define("_SITE_DESCR","Descripción del Sitio/Despegue");

//--------------------------------------------
// KML file
//--------------------------------------------
define("_See_more_details","Ver más detalles");
define("_KML_file_made_by","Fichero KML hecho por");

//--------------------------------------------
// add_waypoint.php
//--------------------------------------------
define("_ADD_WAYPOINT","Registrar despegue");
define("_WAYPOINT_ADDED","El despegue ha sido registrado");

//--------------------------------------------
// list_takeoffs.php
//--------------------------------------------
define("_SITE_RECORD_OPEN_DISTANCE","Record del lugar<br>(distancia libre)");
	
//--------------------------------------------
// glider types
//--------------------------------------------
define("_GLIDER_TYPE","Tipo de ala");
function setGliderCats() {
	global  $CONF_glider_types,$gliderCatList;
	$gliderCatList=array(1=>'Parapente',2=>'Ala flexible FAI1',4=>'Ala rígida FAI5',8=>'Planeador');
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

define("_Your_settings_have_been_updated","Tus opciones de navegación han sido actualizadas.");

define("_THEME","Apariencia");
define("_LANGUAGE","Idioma");
define("_VIEW_CATEGORY","Ver categoría");
define("_VIEW_COUNTRY","Ver país");
define("_UNITS_SYSTEM" ,"Sistema");
define("_METRIC_SYSTEM","Métrico (km,m)");
define("_IMPERIAL_SYSTEM","Imperial (miles,feet)");
define("_ITEMS_PER_PAGE","Elementos por página");

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

define("_WORLD_WIDE","En todo el mundo");
define("_National_XC_Leagues_for","Ligas XC Nacionales para");
define("_Flights_per_Country","Vuelos por País");
define("_Takeoffs_per_Country","Despegues por País");
define("_INDEX_HEADER","Bienvenidos/as a la Liga Leonardo XC");
define("_INDEX_MESSAGE","Puedes utilizar el &quot;Menú Principal&quot; para navegar o usar las opciones más comunes que te mostramos a continuación.");


//--------------------------------------------
// NEW 
//--------------------------------------------
define("_MENU_SUMMARY_PAGE","Página inicial (Sumario)");
define("_Display_ALL","Mostrar TODOS");
define("_Display_NONE","Mostrar NINGUNO");
define("_Reset_to_default_view","Restablecer vista por defecto");
define("_No_Club","Sin Club");
define("_This_is_the_URL_of_this_page","Esta es la URL de esta página");
define("_All_glider_types","Todos los tipos");

define("_MENU_SITES_GUIDE","Guía de Zonas de Vuelo");
define("_Site_Guide","Guía de Zona de Vuelo");

define("_Search_Options","Opciones de búsqueda");
define("_Below_is_the_list_of_selected_sites","Below is the list of selected sites");
define("_Clear_this_list","Clear this list");
define("_See_the_selected_sites_in_Google_Earth","See the selected sites in Google Earth");
define("_Available_Takeoffs","Despegues disponibles");
define("_Search_site_by_name","Buscar sitio por nombre");
define("_give_at_least_2_letters","give at least 2 letters");
define("_takeoff_move_instructions_1","You can move all availabe takeoffs to the selected list on the right panel by using >> or the selected one by using > ");
define("_Takeoff_Details","Detalles del Despegue");

define("_Takeoff_Info","Despegue/Aterrizaje");
define("_XC_Info","XC Info");
define("_Flight_Info","Información del vuelo");

define("_MENU_LOGOUT","Cerrar sesión");
define("_MENU_LOGIN","Iniciar sesión");
define("_MENU_REGISTER","Abrir una cuenta");

define("_Africa","África");
define("_Europe","Europa");
define("_Asia","Asia");
define("_Australia","Australia");
define("_North_Central_America","América del Norte/Central");
define("_South_America","America del Sur");

define("_Recent","Recientes");


define("_Unknown_takeoff","Despegue desconocido");
define("_Display_on_Google_Earth","Mostrar en Google Earth");
define("_Use_Man_s_Module","Usar módulo de Man");
define("_Line_Color","Color de la línea");
define("_Line_width","Anchura de la línea");
define("_unknown_takeoff_tooltip_1","Este vuelo tiene un despegue desconocido");
define("_unknown_takeoff_tooltip_2","Si conoces el despegue en el que comenzó este vuelo, por favor pincha aquí para meter sus datos");
define("_EDIT_WAYPOINT","Editar la información del despegue");
define("_DELETE_WAYPOINT","Borrar despegue");
define("_SUBMISION_DATE","Fecha de envío"); // the date a flight was submited to leonardo
define("_TIMES_VIEWED","Veces visto"); // the times that this flight havs been viewed


define("_takeoff_add_help_1","Puedes introducir la información del despegue si la conoces bien. Si no estás seguro/a puedes puedes cerrar esta ventana directamente.");
define("_takeoff_add_help_2","Si el despegue de tu vuelo es el que se muestra encima de 'Despegue desconocido' entonces no hay necesidad de meterlo de nuevo. Simplemente cierra esta ventana. ");
define("_takeoff_add_help_3","Si ves el nombre del despegue debajo, puedes pinchar en él para autocompletar los campos.");
define("_Takeoff_Name","Nombre del despegue");
define("_In_Local_Language","En el idioma local");
define("_In_English","En Inglés");

// New on 2007/02/20 - login screen
define("_ENTER_PASSWORD","Por favor introduce tu nombre de usuario y contraseña para iniciar sesión.");
define("_SEND_PASSWORD","He olvidado mi contraseña");
define("_ERROR_LOGIN","El nombre de usuario indicado no es correcto o está inactivo, o la contraseña es incorrecta.");
define("_AUTO_LOGIN","Iniciar sesión automáticamente en cada visita");
define("_USERNAME","Nombre de usuario");
define("_PASSWORD","Contraseña");
define("_PROBLEMS_HELP","Si tienes problemas para iniciar sesión ponte en contacto con nosotros.");
define("_LOGIN_TRY_AGAIN","Pincha %saquí%s para intentarlo de nuevo");
define("_LOGIN_RETURN","Pincha %saquí%s para volver al índice");

define("_Category","Categoría");
define("_MEMBER_OF","Miembro de");
define("_Clubs_Leagues","Clubs / Ligas");
define("_Pilot_Statistics","Estadísticas de Pilotos");
define("_National_Rankings","Rankings Nacionales");
define("_MemberID","ID");

// new on 2007/03/08
define("_Select_Club","Seleccionar Club");
define("_Close_window","Cerrar ventana");
define("_EnterID","Teclea ID");
define("_Club","Club");
define("_Sponsor","Sponsor");


// new on 2007/03/13
define('_Go_To_Current_Month','Ir al Mes Actual');
define('_Today_is','Hoy es');
define('_Wk','Sem');
define('_Click_to_scroll_to_previous_month','Presione para pasar al mes anterior. Deje presionado para pasar varios meses.');
define('_Click_to_scroll_to_next_month','Presione para pasar al siguiente mes. Deje presionado para pasar varios meses.');
define('_Click_to_select_a_month','Presione para seleccionar un mes');
define('_Click_to_select_a_year','Presione para seleccionar un ano');
define('_Select_date_as_date.','Seleccione [date] como fecha.'); // do not replace [date], it will be replaced by date.


define("_SUBMIT_TO_OLC","Mandar al OLC"); 
define("_pilot_email","Email"); 
define("_Sex","Sexo"); 
define("_Login_Stuff","Cambiar datos de acceso"); 
define("_PASSWORD_CONFIRMATION","Confirmar contraseña"); 
define("_PROJECT_HELP","Ayuda"); 
define("_PROJECT_NEWS","Noticias"); 
define("_PROJECT_RULES","Reglamento 2007"); 
define("_Filter_NoSelection","Sin selección actual"); 
define("_Filter_CurrentlySelected","Selección actual"); 
define("_Filter_DialogMultiSelectInfo","Presiona Ctrl para seleccionar más de una opción."); 
define("_Filter_FilterTitleIncluding","Sólo [items] seleccionados/as"); 
define("_Filter_FilterTitleExcluding","Excluir [items]"); 
define("_Filter_DialogTitleIncluding","Seleccionar [items]"); 
define("_Filter_DialogTitleExcluding","Excluir [items]"); 
define("_Filter_Items_pilot","pilotos"); 
define("_Filter_Items_country","paises"); 
define("_Filter_Items_takeoff","despegues"); 
define("_Filter_Button_Select","Seleccionar"); 
define("_Filter_Button_Delete","Borrar"); 
define("_Filter_Button_Accept","Aceptar selección"); 
define("_Filter_Button_Cancel","Cancelar"); 
define("_MENU_FILTER_NEW","Filtro **NUEVA VERSIÓN**"); 
define("_ALL_NACCLUBS","Todos los Clubs"); 
define("_FirstOlcYearComment","Por favor elige el año de tu primera participación en un torneo XC on-line (no sólo en este).<br/>Este campo es relevante para los rankings de &quot;pilotos noveles&quot;."); 
define("_Select_Brand","Seleccionar marca"); 
define("_All_Brands","Todas las marcas"); 
define("_DAY","DÍA"); 
define("_Glider_Brand","Marca del ala"); 
define("_MENU_SEARCH_PILOTS","Buscar piloto"); 
define("_FLIGHTADD_CONFIRMATIONTEXT","Enviando este vuelo confirmo que he respetado todas las obligaciones legales relacionas con el mismo."); 
define("_FLIGHTADD_IGC_MISSING","Por favor elige tu fichero .IGC"); 
define("_FLIGHTADD_IGCZIP_MISSING","Por favor elige el fichero .ZIP que contiene tu/s fichero/s .IGC"); 
define("_FLIGHTADD_CATEGORY_MISSING","Por favor elige la categoría"); 
define("_FLIGHTADD_BRAND_MISSING","Por favor elige la marca de tu ala"); 
define("_FLIGHTADD_GLIDER_MISSING","Por favor indica el tipo de ala"); 
define("_YOU_HAVENT_ENTERED_GLIDER","No has indicado la marca o modelo"); 
define("_BRAND_NOT_IN_LIST","No está en la lista"); 
define("_MANDATORY_GENDER","Por favor indica tu sexo"); 
define("_Pilot_search_instructions","mete al menos tres caracteres del nombre o apellido"); 
define("_See_The_filter","Ver el Filtro actual"); 
define("_PilotBirthdate","Fecha de nacimiento"); 
define("_Start_Type","Tipo de despegue"); 
define("_GLIDER_CERT","Certificación"); 
define("_MENU_BROWSER","Ver en Google Maps"); 
define("_Load_Thermals","Cargar térmicas"); 
define("_Loading_thermals","Cargando térmicas"); 
define("_Layers","Capas"); 
define("_Select_Area","Seleccionar área"); 
define("_Leave_a_comment","Dejar un comentario"); 
define("_Reply","Contestar"); 
define("_Translate","Traducir"); 
define("_Translate_to","Traducir a"); 
define("_Submit_Comment","Enviar comentario"); 
define("_Logged_in_as","Sesión iniciada como:"); 
define("_Name","Nombre"); 
define("_Will_not_be_displayed","(no será mostrado)"); 
define("_Please_type_something","Por favor escribe algo"); 
define("_SHOW_NEWS","Mostrar noticias");

define("_EnterPasswordOnlyToChange","Teclea la contraseña sólo si quieres cambiarla:"); 
define("_PwdAndConfDontMatch","La contraseña y su confirmación son diferentes."); 
define("_PwdTooShort","La contraseña es muy corta. Debe tener al menos $passwordMinLength caracteres."); 
define("_PwdConfEmpty","Falta la confirmación de la contraseña."); 
define("_PwdChanged","La contraseña ha sido cambiada."); 
define("_PwdNotChanged","La contraseña NO ha sido cambiada."); 
define("_PwdChangeProblem","Se produjo un problema mientras al cambiar la contraseña."); 
define("_EmailEmpty","La dirección de correo electrónico no puede estar vacía."); 
define("_EmailInvalid","La dirección de correo electrónico no es válida."); 
define("_EmailSaved","La dirección de correo electrónico ha sido guardada."); 
define("_EmailNotSaved","La dirección de correo electrónico NO ha sido guardada."); 
define("_EmailSaveProblem","Se produjo un problema al guardar la dirección de correo electrónico."); 
define("_Filter_Items_nacclub","clubs"); 
define("_SELECT_NACCLUB","Selecciona [nacname]-Club"); 
define("_FirstOlcYear","Primer año de participación en un campeonado de XC online"); 
define("_Or_Select_from_previous","O elige alguno/a de las anteriores"); 
define("_Explanation_AddToBookmarks_IE","Añadir estos ajustes del filtro a tus favoritos"); 
define("_Msg_AddToBookmarks_IE","Pincha aquí para añadir estos ajustes del filtro a tus marcadores."); 
define("_Explanation_AddToBookmarks_nonIE","(Guardar este enlace en tus marcadores.)"); 
define("_Msg_AddToBookmarks_nonIE","Para guardar estos ajustes del filtro entre tus marcadores utiliza la opción \'Guardar en marcadores\' de tu navegador."); 
define("_PROJECT_RULES2","Reglamento 2008"); 
define("_MEAN_SPEED1","Velocidad media"); 
define("_External_Entry","Entrada externa"); 
define("_Altitude","Altitud"); 
define("_Speed","Velocidad"); 
define("_Distance_from_takeoff","Distancia desde el despegue"); 
define("_LAST_DIGIT","último dígido"); 
define("_Filter_Items_nationality","nacionalidad"); 
define("_Filter_Items_server","servidor"); 
define("_Ext_text1","Este vuelo fue originalmente enviado el "); 
define("_Ext_text2","Enlace a todos los mapas y gráficas vuelo"); 
define("_Ext_text3","Enlace al vuelo original"); 
define("_Male_short","H"); 
define("_Female_short","M"); 
define("_Male","Hombre"); 
define("_Female","Mujer"); 
define("_Altitude_Short","Alt"); 
define("_Vario_Short","Vario"); 
define("_Time_Short","Tiempo"); 
define("_Info","Info"); 
define("_Control","Control"); 
define("_Zoom_to_flight","Zoom hasta el vuelo"); 
define("_Follow_Glider","Seguir vela"); 
define("_Show_Task","Mostrar prueba"); 
define("_Show_Airspace","Mostrar espacio aéreo"); 
define("_Thermals","Térmicas"); 
define("_Show_Optimization_details","Mostrar detalles de optimización"); 
define("_MemberID_Missing","Tu ID de miembro no ha sido encontrado"); 
define("_MemberID_NotNumeric","El ID de miembro debe ser numérico"); 
define("_Email_new_password","<p align='justify'>El servidor ha enviado un email al piloto con la nueva contraseña y clave de activación.</p> <p align='justify'>Por favor, comprueba tus correos electrónicos y sigue las instrucciones indicadas en el correo.</p>"); 
define("_informed_user_not_found","Este usuario no ha sido encontrado en la base de datos"); 
define("_impossible_to_gen_new_pass","<p align='justify'>Lamentamos informarte de que no es posible generar una nueva contraseña para ti, hay actualmente una petición de cambio que expirará en <b>%s</b>. Sólo después de que expire dicha petición podrás solicitar una nueva.</p><p align='justify'>Si no tienes acceso a tu correo electrónico, por favor, contacta con el administrador.</p>"); 
define("_Password_subject_confirm","Correo de confirmación (nueva contraseña)"); 
define("_request_key_not_found","La clave de confirmación que has facilitado no existe."); 
define("_request_key_invalid","La clave de confirmación que has facilitado no es válida."); 
define("_Email_allready_yours","La dirección de correo ya es tuya, nada que hacer."); 
define("_Email_allready_have_request","Ya hay una petición para cambiar este correo electrónico, nada que hacer."); 
define("_Email_used_by_other","Este correo electrónico está siendo usada por otro piloto, nada que hacer."); 
define("_Email_used_by_other_request","Este correo electrónico está solicitado por otro usuario"); 
define("_Email_canot_change_quickly","No puedes cambiar tu correo electrónico en este momento, tienes que esperar a que expire la solicitud de cambio anterior: %s"); 
define("_Email_sent_with_confirm","Un correo de confirmación ha sido enviado, por favor comprueba tu correo para confirmar el cambio de email"); 
define("_Email_subject_confirm","Correo de confirmación (nuevo email)"); 
define("_Email_AndConfDontMatch","El email facilitado y su confirmación son diferentes."); 
define("_ChangingEmailForm"," Formulario de cambio de correo electrónico"); 
define("_Email_current","Email actual"); 
define("_New_email","Nuevo Email"); 
define("_New_email_confirm","Confirma el nuevo Email"); 
define("_MENU_CHANGE_PASSWORD","Cambiar mi contraseña"); 
define("_MENU_CHANGE_EMAIL","Cambiar mi correo electrónico"); 
define("_New_Password","Nueva contraseña"); 
define("_ChangePasswordForm","Formulario de cambio de contraseña"); 
define("_lost_password","Formulario de recuperación de contraseña"); 
define("_PASSWORD_RECOVERY_TOOL","Formulario de recuperación de contraseña"); 
define("_PASSWORD_RECOVERY_TOOL_MESSAGE","El servidor buscará en la totalidad de la base de datos y cuando encuentre un nombre, correo o CIVL ID que coincida un email será mandado al piloto asociado con una nueva contraseña y enlace de activación.<br><br> NOTA: la nueva contraseña sólo será válida después de utilizar en enlace de activación.<br><br>"); 
define("_username_civlid_email","Por favor, rellenar con: CIVLID, nombre de usuario o Email"); 
define("_Recover_my_pass","Recuperar mi contraseña"); 
define("_You_are_not_login","<BR><BR><center><br>No estás identificado. <br><br>Por favor, inicia sesión<BR><BR></center>"); 
define("_Requirements","Requerimientos"); 
define("_Mandatory_CIVLID","Es obligatorio tener un <b>CIVLID</b> válido"); 
define("_Mandatory_valid_EMAIL","Es obligatorio facilitar un <b>Email válido</b> para futuras comunicaciones con el administrador del servidor"); 
define("_NICK_NAME","Mote"); 
define("_LOCAL_PWD","Contraseña local"); 
define("_LOCAL_PWD_2","Repite la contraseña local"); 
define("_CONFIRM","Confirmar"); 
define("_REQUIRED_FIELD","Campos obligatorios"); 
define("_Registration_Form","Formulario de registro en %s (Leonardo)"); 
define("_MANDATORY_NAME","Es obligatorio facilitar el nombre"); 
define("_MANDATORY_FAI_NATION","Es obligatorio facilitar tu país FAI"); 
define("_MANDATORY_BIRTH_DATE_INVALID","Fecha de nacimiento incorrecta"); 
define("_MANDATORY_CIVL_ID","Por favor, indica tu CIVLID"); 
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
define("_Server_send_conf_email","El servidor ha enviado al correo %s pidiendo confirmación. Tienes tres horas desde ahora para confirmar tu registro pinchando (o copiando y pegando en el navegador) en el enlace que verás en el cuerpo del mensaje.");
define("_Pilot_confirm_subscription","===================================

Nuevo usuario en %s
                
Hola %s,

Este es un correo de verificación enviado desde %s.
 
Para crear tu cuenta es necesario que valides tu correo visitando con tu navegador la siguiente dirección:

http://%s?op=register&rkey=%s 

Un saludo y buenos vuelos,

--------
Nota: Este es un correo automático. Por favor, no respondas a este correo.
--------"); 
define("_Pilot_confirm_change_email","===================================

Usuario de %s
                
Hola %s,

Este es un correo de verificación enviado desde %s.
 
Para cambiar tu correo electrónico es necesario que visites con tu navegador la siguiente dirección:

http://%s?op=chem&rkey=%s

Un saludo y buenos vuelos,

--------
Nota: Este es un correo automático. Por favor, no respondas a este correo.
--------"); 
define("_Password_recovery_email","===================================

Usuario de %s
                
Hola %s,

Este es un correo de verificación enviado desde %s.
                
Recuperación de contraseña
                
Nombre de usuario: %s
                
CIVLID: %s
                
Nueva contraseña: %s
 
Para activar tu nueva contraseña es necesario que visites con tu navegador la siguiente dirección:

http://%s?op=send_password&rkey=%s 

Un saludo y buenos vuelos,

--------
Nota: Este es un correo automático. Por favor, no respondas a este correo.
--------"); 
define("_MENU_AREA_GUIDE","Guía de la zona"); 
define("_All_XC_types","Todos los tipos de XC"); 
define("_xctype","Tipo de XC"); 
define("_Flying_Areas","Zonas de Vuelo"); 
define("_Name_of_Area","Nombre de la Zona"); 
define("_See_area_details","Ver detalles y despegues de esta zona"); 
define("_choose_ge_module","Por favor, escoge el tipo de fichero<BR>para mostrar en Google Earth"); 
define("_ge_module_advanced_1","(Más detallado, fichero más pesado)"); 
define("_ge_module_advanced_2","(Muchos detalles, fichero grande) "); 
define("_ge_module_Simple","Sencillo (Sólo el vuelo, fichero pequeño)"); 
define("_All_classes","Todos los tipos"); 
define("_Class","Clase"); 
define("_Photos_filter_off","Con/Sin fotos"); 
define("_Photos_filter_on","Sólo con fotos"); 
define("_You_are_already_logged_in","Ya tienes una sesión iniciada"); 
define("_FLIGHT_BROSWER","Buscar vuelos y despegues con Google Maps"); 
define("_Email","Email"); 
define("_Please_enter_your_name","Por favor, dinos tu nombre / mote"); 
define("_Please_give_your_email","Por favor, danos tu correo electrónico, no será mostrado nunca públicamente"); 
define("_RSS_for_the_comments","Este es el enlace RSS para los comentarios de este vuelo<BR>Copia y pégalo en tu lector de RSS"); 
define("_Comments_are_enabled_by_default_for_new_flights","Los comentarios están activos por defecto para nuevos vuelos"); 
define("_Comments_Enabled","Comentarios habilitados"); 
define("_Comments_are_enabled_for_this_flight","Los comentarios están habilitados para este vuelo"); 
define("_Comments_are_disabled_for_this_flight","Los comentarios están deshabilidados para este vuelo"); 
define("_ERROR_in_setting_the_comments_status","ERROR estableciendo el estado de los comentarios"); 
define("_Save_changes","Guardar cambios"); 
define("_Cancel","Cancelar"); 
define("_Are_you_sure_you_want_to_delete_this_comment","¿Estás seguro/a de que quieres borrar este comentario?"); 
define("_RSS_feed_for_comments","RSS feed de nuevos comentarios"); 
define("_RSS_feed_for_flights","RSS feed de vuelos nuevos vuelos"); 
define("_RSS_of_pilots_flights","RSS de vuelos del piloto"); 
define("_You_have_a_new_comment","Tienes un nuevo comentario en %s"); 
define("_New_comment_email_body","Tienes un nuevo comentario en %s<BR><BR><a href='%s'>Pincha aquí para leer todos los comentarios</a><hr>%s"); 
define("_Remove_From_Favorites","Eliminar de favoritos"); 
define("_Favorites","Favoritos"); 
define("_Compare_flights_line_1","Elige los vuelos en sus checks"); 
define("_Compare_flights_line_2","y compáralos con Google Maps"); 
define("_Compare_Favorite_Tracks","Comparar Tracks Favoritos"); 
define("_Remove_all_favorites","Eliminar todos los favoritos"); 
define("_Find_and_Compare_Flights","Busca y compara vuelos"); 
define("_Compare_Selected_Flights","Comparar vuelos seleccionados"); 
define("_More","Más"); 
define("_Close","Cerrar"); 
define("_Email_periodic","Mandaremos periódicamente correos de confirmación a la dirección facilitada, y si no recibimos respuesta finalmente la cuenta será bloqueada");
define("_Email_asking_conf","Mandaremos un email de confirmación a la dirección de correo facilitada");
define("_Email_time_conf","Sólo tendrás <b>3 horas</b> tras finalizar el pre-registro para contestar al correo");
define("_After_conf_time"," Tras ese tiempo, tu pre-registro será <b>eliminado</b> de nuestra base de datos");
define("_Only_after_time","<b>Y sólo después de que borremos tu pre-registro podrás realizarlo de nuevo</b>"); 
define("_Disable_Anti_Spam","<b>ATENCIÓN!!! Deshabilitar</b> el anti spam para correos procedentes de <b>%s</b>"); 
define("_If_you_agree","Si tu estás de acuerdo con estos requerimientos, por favor sigue adelante."); 
define("_Search_civl_by_name","%sBusca tu nombre en la base de datos de la CIVL%s . Cuando pinches en el enlace de la izquierda se abrirá una nueva ventana. Por favor, introduce sólo tres letras de tu nombre o apellido y la CIVL te devolverá tu CIVLID, nombre y nacionalidad FAI (posiblemente junto con la de otros pilotos."); 
define("_Register_civl_as_new_pilot","Si no estás registrado en la base de datos de la CIVL, por favor %sREGÍSTRAME COMO NUEVO PILOTO%s"); 

?>

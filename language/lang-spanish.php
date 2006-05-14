<?php
/**************************************************************************/
/* Spanish language translation by                                        */
/* Ale Spitznagel   (contacto@parapente.com.ar)                           */
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
	global  $monthList;
	$monthList=array('Enero','Febrero','Marzo','Abril','Mayo','Junio',
					'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
}
setMonths();

//--------------------------------------------
// output.php
//--------------------------------------------
define("_FREE_FLIGHT","Distancia Libre");
define("_FREE_TRIANGLE","Triángulo Libre");
define("_FAI_TRIANGLE","Triángulo FAI");

define("_SUBMIT_FLIGHT_ERROR","Ocurrió un problema enviando el vuelo");

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
define("_TOTAL_OLC_SCORE","Puntaje Total OLC");
define("_BEST_OLC_SCORE","Mejor puntaje OLC");
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
define("_OLC_SCORE_TYPE","Tipo de puntaje OLC");
define("_OLC_DISTANCE","Distancia OLC");
define("_OLC_SCORING","Puntaje OLC");
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
define("_UPDATE_SCORE","Actualizar puntaje");

define("_TAKEOFF_COORDS","Coordenadas del despegue:");
define("_NO_KNOWN_LOCATIONS","¡No hay ubicaciones conocidas!");
define("_FLYING_AREA_INFO","Flying area info");

//--------------------------------------------
// index.php
//--------------------------------------------
define("_PAGE_TITLE","Leonardo XC server");
define("_RETURN_TO_TOP","^arriba");
// list flight
define("_PILOT_FLIGHTS","Vuelos del Piloto");

define("_DATE_SORT","Fecha");
define("_PILOT_NAME","Nombre del Piloto");
define("_TAKEOFF","Despegue");
define("_DURATION","Duración");
define("_LINEAR_DISTANCE","Distancia Libre");
define("_OLC_KM","OLC km");
define("_OLC_SCORE","Puntaje OLC");
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
define("_PRESS_HERE_TO_VIEW_IT","Presioná aquí para verlo");
define("_WILL_BE_ACTIVATED_SOON","(será activado en 1-2 minutos)");

// add_from_zip
define("_SUBMIT_MULTIPLE_FLIGHTS","Enviar varios vuelos");
define("_ONLY_THE_IGC_FILES_WILL_BE_PROCESSED","Solo se procesarán archivos IGC");
define("_SUBMIT_THE_ZIP_FILE_CONTAINING_THE_FLIGHTS","Enviar archivo ZIP<br>conteniendo los vuelos");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHTS","Presioná aquí para enviar los vuelos");

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
define("_PROJECT_INFO","Información del proyecto");

// menu bar 
define("_MENU_MAIN_MENU","Menú Principal");
define("_MENU_DATE","Seleccionar Fecha");
define("_MENU_COUNTRY","Seleccionar País");
define("_MENU_XCLEAGUE","Liga XC");
define("_MENU_ADMIN","Admin");

define("_MENU_COMPETITION_LEAGUE","Liga - todas las categorías");
define("_MENU_OLC","OLC");
define("_MENU_OPEN_DISTANCE","Distancia Libre");
define("_MENU_DURATION","Duración");
define("_MENU_ALL_FLIGHTS","Mostrar todos los vuelos");
define("_MENU_FLIGHTS","Vuelos");
define("_MENU_TAKEOFFS","Despegues");
define("_MENU_FILTER","Filtro");
define("_MENU_MY_FLIGHTS","Mis vuelos");
define("_MENU_MY_PROFILE","Mi perfil");
define("_MENU_MY_STATS","Mis estadísticas"); 
define("_MENU_MY_SETTINGS","My settings"); 
define("_MENU_SUBMIT_FLIGHT","Enviar vuelo");
define("_MENU_SUBMIT_FROM_ZIP","Enviar vuelos desde zip");
define("_MENU_SHOW_PILOTS","Pilotos");
define("_MENU_SHOW_LAST_ADDED","Mostrar envios recientes");
define("_FLIGHTS_STATS","Flights Stats");

define("_SELECT_YEAR","Seleccionar año");
define("_SELECT_MONTH","Seleccionar mes");
define("_ALL_COUNTRIES","Mostrar todos los países");
//--------------------------------------------
// list_pilots.php
//--------------------------------------------

define("_ALL_TIMES","TODOS");
define("_NUMBER_OF_FLIGHTS","Número de vuelos");
define("_TOTAL_DISTANCE","Distacia total");
define("_TOTAL_DURATION","Duración total");
define("_BEST_OPEN_DISTANCE","Mejor distancia");
define("_TOTAL_OLC_DISTANCE","Distancia total OLC");
define("_TOTAL_OLC_SCORE","Puntaje total OLC");
define("_BEST_OLC_SCORE","Mejor puntaje OLC");
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
define("_OLC_TOTAL_SCORE","puntaje total OLC");
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
define("_OLC_SCORE_SHOULD_BE","El puntaje OLC debe ser");
define("_DURATION_SHOULD_BE","La duración debe ser");
define("_ACTIVATE_CHANGE_FILTER","Activar / cambiar FILTRO");
define("_DEACTIVATE_FILTER","Desactivar FILTRO");
define("_HOURS","horas");
define("_MINUTES","min");

//--------------------------------------------
// add_flight.php
//--------------------------------------------

define("_SUBMIT_FLIGHT","Enviar vuelo");
define("_ONLY_THE_IGC_FILE_IS_NEEDED","(sólo es necesario el archivo IGC)");
define("_SUBMIT_THE_IGC_FILE_FOR_THE_FLIGHT","Enviar el<br>archivo IGC del vuelo");
define("_NOTE_TAKEOFF_NAME","Por favor anotá el nombre del despegue, ubicación y país");
define("_COMMENTS_FOR_THE_FLIGHT","Comentarios del vuelo");
define("_PHOTO","Foto");
define("_PHOTOS_GUIDELINES","Las fotos deben estar en formato jpg y con un tamaño menor a 100Kb");
define("_PRESS_HERE_TO_SUBMIT_THE_FLIGHT","Presioná aquí para enviar el vuelo");
define("_DO_YOU_HAVE_MANY_FLIGHTS_IN_A_ZIPFILE","¿Querés enviar varios vuelos juntos?");
define("_PRESS_HERE","Cliqueá aquí");

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
define("_PRESS_HERE_TO_CHANGE_THE_FLIGHT","Presioná aquí para cambiar los datos del vuelo");
define("_THE_CHANGES_HAVE_BEEN_APPLIED","Los cambios han sido aplicados");
define("_RETURN_TO_FLIGHT","Volver al vuelo");

//--------------------------------------------
// olc
//--------------------------------------------
define("_RETURN_TO_FLIGHT","Volver al vuelo");
define("_READY_FOR_SUBMISSION","Listo para enviar");
define("_SUBMIT_TO_OLC","Enviar a OLC");
define("_YOUR_FLIGHT_HAS_BEEN_SUCCESSFULLY_SUBMITED_TO_THE_OLC","El vuelo ha sido enviado a el OLC");
define("_THE_OLC_REFERENCE_NUMBER_IS","El número de referencia OLC es");
define("_THERE_WAS_A_PROBLEM_ON_OLC_SUBMISSION","Ocurrió un error en el envio OLC");
define("_LOOK_BELOW_FOR_THE_CAUSE_OF_THE_PROBLEM","Mire abajo para ver la causa del problema");
define("_FLIGHT_SUCCESFULLY_REMOVED_FROM_OLC","El vuelo ha sido removido del el OLC");
define("_FLIGHT_NOT_SCORED","El vuelo no tiene puntaje OLC y por lo tanto no puede ser enviado");
define("_TOO_LATE","El plazo de envio de este vuelo ha terminado y por lo tanto no puede ser enviado");
define("_CANNOT_BE_SUBMITTED","El plazo de envio de este vuelo ha terminado");
define("_NO_PILOT_OLC_DATA","<p><strong>No hay datos OLC para este piloto</strong><br>
  <br>
<b>¿Qué es OLC / para qué son estos campos ?</b><br><br>
	Para validad el envio a el OLC el piloto debe estar registrado en el sistema OLC.</p>
<p> Esto podés hacerlo <a href='http://www2.onlinecontest.org/olcphp/2005/ausw_wertung.php?olc=holc-i&spr=es' target='_blank'>
  en este sitio</a>, donde deberás seleccionar tu país y luego 'Contest Registration'<br>
</p>
<p>Cuando hayas finalizado el registro, debes ir a tu 'Perfil del Piloto'->'Editar información OLC' e ingresar tu información EXACTAMENTE como la ingresaste en el registro OLC
</p>
<ul>
	<li><div align=left>Nombres</div>
	<li><div align=left>Apellidos</div>
	<li><div align=left>Fecha de nacimiento</div>
	<li> <div align=left>Apodo</div>
	<li><div align=left>Si ya has enviado vuelos al OLC, las 4 letras que utilizas para el nombre de archivo IGC</div>
</ul>");
define("_OLC_MAP","Mapa");
define("_OLC_BARO","Barograma");

//--------------------------------------------
// pilot_profile.php
//--------------------------------------------
define("_Pilot_Profile","Perfil del piloto");
define("_back_to_flights","^arriba");
define("_pilot_stats","estadísticas del piloto");
define("_edit_profile","editar perfil");
define("_flights_stats","estadísticas de vuelo");
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
// pilot_ïlc_profile_edit.php
//--------------------------------------------
define("_edit_OLC_info","Editar información OLC");
define("_OLC_information","información OLC");
define("_callsign","Apodo");
define("_filename_suffix","Sufijo de Archivo");
define("_OLC_Pilot_Info","Información OLC de Piloto");
define("_OLC_EXPLAINED","<b>¿Qué es OLC / para qué son estos campos ?</b><br><br>
	Para validad el envio a el OLC el piloto debe estar registrado en el sistema OLC.</p>
<p> Esto podés hacerlo <a href='http://www2.onlinecontest.org/olcphp/2005/ausw_wertung.php?olc=holc-i&spr=es' target='_blank'>
  en este sitio</a>, donde deberás seleccionar tu país y luego 'Contest Registration'<br>
</p>
<p>Cuando hayas completado el registro debes ingresar aquí la información EXACTAMENTE como la ingresaste en el registro OLC
</p>
<ul>
	<li><div align=left>Nombres</div>
	<li><div align=left>Apellido</div>
	<li><div align=left>Fecha de Nacimiento</div>
	<li> <div align=left>Apodo</div>
	<li><div align=left>Si ya has enviado vuelos al OLC, las 4 letras que utilizas para el nombre de archivo IGC</div>
</ul>
");

define("_OLC_SUFFIX_EXPLAINED","<b>¿Qué es el 'sufijo de archivo?'</b><br>Es un identificador de 4 letras que identifica únicamente a un piloto o ala. 
Si no estas seguro de que ingresar realmente aquí, aquí algunos tips:<p>
<ul>
<li>Usa 4 letras en derivadas de tu nombres / apellidos
<li>Intenta buscar una combinación que suene bastante extraña. Esto reducirá la posibilidad de que tu sufijo sea igual al de otros pilotos
<li>Si tienes problemas enviando tu vuelo al OLC por medio de Leonardo, puede ser el sufijo. Prueba cambiarlo y reenviarlo.
</ul>");
//--------------------------------------------
// pilot_profile_stats.php
//--------------------------------------------
define("_hh_mm","hh:mm");

define("_Totals","Totales");
define("_First_flight_logged","Primer vuelo ingresado");
define("_Last_flight_logged","Ultimo vuelo ingresado");
define("_Flying_period_covered","Período de vuelo cubierto");
define("_Total_Distance","Distancia Total");
define("_Total_OLC_Score","Puntaje Total OLC");
define("_Total_Hours_Flown","Total de Horas de Vuelo");
define("_Total_num_of_flights","Cantida de Vuelos ");

define("_Personal_Bests","Mejores Resultados Personales");
define("_Best_Open_Distance","Mejor Distancia Libre");
define("_Best_FAI_Triangle","Mejor Triángulo FAI");
define("_Best_Free_Triangle","Mejor Triángulo Libre");
define("_Longest_Flight","Vuelo Más Largo");
define("_Best_OLC_score","Mejor Puntaje OLC");

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
define("_See_more_details","See more details");
define("_KML_file_made_by","KML file made by");

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
	global  $gliderCatList;
	$gliderCatList=array(1=>'Parapente',2=>'Ala flexible FAI1',4=>'Ala rígida FAI5',8=>'Planeador');
}
setGliderCats();

//--------------------------------------------
// user prefs  & units
//--------------------------------------------

define("_Your_settings_have_been_updated","Your settings have been updated");

define("_THEME","Theme");
define("_LANGUAGE","Language");
define("_VIEW_CATEGORY","View category");
define("_VIEW_COUNTRY","View country");
define("_UNITS_SYSTEM" ,"Units system");
define("_METRIC_SYSTEM","Metric (km,m)");
define("_IMPERIAL_SYSTEM","Imperial (miles,feet)");
define("_ITEMS_PER_PAGE","Items per page");

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

define("_WORLD_WIDE","World Wide");
define("_National_XC_Leagues_for","National XC Leagues for");
define("_Flights_per_Country","Flights per Country");
define("_Takeoffs_per_Country","Takeoffs per Country");
define("_INDEX_HEADER","Welcome to Leonardo XC League");
define("_INDEX_MESSAGE","You can use the &quot;Main menu&quot; to navigate or use the most common choices presented below.");

?>
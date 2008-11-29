<?
//************************************************************************
// Leonardo XC Server, http://leonardo.thenet.gr
//
// Copyright (c) 2004-8 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: FN_timezones.php,v 1.4 2008/11/29 22:46:07 manolis Exp $                                                                 
//
//************************************************************************

function getTZforCountry($countryCode) {
	global $Countries2timeZones;
	return $Countries2timeZones[$countryCode];
}

//special cases
/*
Portugal 
Azores	UTC-1	UTC	From the last Sunday in March at 00:00 to the last Sunday in October at 01:00	Atlantic/Azores
Madeira	UTC	UTC+1	From the last Sunday in March at 01:00 to the last Sunday in October at 02:00	Atlantic/Madeira
Continental Portugal	UTC	UTC+1	From the last Sunday in March at 01:00 to the last Sunday in October at 02:00	Europe/Lisbon
Simple Rule  if lon < -20 ( - is W ) then TZ=Atlantic/Azores


Spain
Spain, except Canary Islands	UTC+1	UTC+2	From the last Sunday in March at 03:00 to the last Sunday in October at 02:00
Canary Islands	UTC	UTC+1	From the last Sunday in March at 01:00 to the last Sunday in October at 02:00
Canary Islands	Atlantic/Canary
Ceuta and Melilla	Africa/Ceuta
Spain (all other places)	Europe/Madrid

Simple Rule  if lon < -11  (- is W )  then TZ=Atlantic/Canary


new zeland
http://www.statoids.com/tnz.html  -> WILL USE Pacific/Auckland for all !!
Canada
http://www.statoids.com/tca.html
Brazil
http://www.statoids.com/tbr.html

australia
http://www.statoids.com/tau.html
central - west is on 129E

central - east is on 
lat > 141E for lon < -26 (S)
lat > 138E for lon > -26 (S)

east - > Australia/Sydney
west
central

equador
http://www.statoids.com/tec.html
argentina
http://www.statoids.com/tar.html
chile
http://www.statoids.com/tcl.html
mexico
http://www.statoids.com/tmx.html

*/

$Countries2timeZones=array(
// AFRICA 
'AO'=>'Africa/Luanda',
'BF'=>'Africa/Ouagadougou',
'BI'=>'Africa/Bujumbura',
'BJ'=>'Africa/Porto-Novo',
'BW'=>'Africa/Gaborone',
'CF'=>'Africa/Bangui',
'CG'=>'Africa/Brazzaville',
'CI'=>'Africa/Abidjan',
'CM'=>'Africa/Douala',
'DJ'=>'Africa/Djibouti',
'DZ'=>'Africa/Algiers',
'EG'=>'Africa/Cairo',
'EH'=>'Africa/El_Aaiun',
'ER'=>'Africa/Asmera',
'ES'=>'Africa/Ceuta',
'ET'=>'Africa/Addis_Ababa',
'GA'=>'Africa/Libreville',
'GH'=>'Africa/Accra',
'GM'=>'Africa/Banjul',
'GN'=>'Africa/Conakry',
'GQ'=>'Africa/Malabo',
'GW'=>'Africa/Bissau',
'KE'=>'Africa/Nairobi',
'LR'=>'Africa/Monrovia',
'LS'=>'Africa/Maseru',
'LY'=>'Africa/Tripoli',
'MA'=>'Africa/Casablanca',
'ML'=>'Africa/Bamako',
'MR'=>'Africa/Nouakchott',
'MW'=>'Africa/Blantyre',
'MZ'=>'Africa/Maputo',
'NA'=>'Africa/Windhoek',
'NE'=>'Africa/Niamey',
'NG'=>'Africa/Lagos',
'RW'=>'Africa/Kigali',
'SD'=>'Africa/Khartoum',
'SL'=>'Africa/Freetown',
'SN'=>'Africa/Dakar',
'SO'=>'Africa/Mogadishu',
'ST'=>'Africa/Sao_Tome',
'SZ'=>'Africa/Mbabane',
'TD'=>'Africa/Ndjamena',
'TG'=>'Africa/Lome',
'TN'=>'Africa/Tunis',
'TZ'=>'Africa/Dar_es_Salaam',
'UG'=>'Africa/Kampala',
'ZA'=>'Africa/Johannesburg',
'ZM'=>'Africa/Lusaka',
'ZW'=>'Africa/Harare',

// AMERICA
'AG'=>'America/Antigua',
'AI'=>'America/Anguilla',
'AN'=>'America/Curacao',
'AW'=>'America/Aruba',
'BB'=>'America/Barbados',
'BO'=>'America/La_Paz',
'BS'=>'America/Nassau',
'BZ'=>'America/Belize',
'CL'=>'America/Santiago',
'CO'=>'America/Bogota',
'CR'=>'America/Costa_Rica',
'CU'=>'America/Havana',
'DM'=>'America/Dominica',
'DO'=>'America/Santo_Domingo',
'EC'=>'America/Guayaquil',
'GD'=>'America/Grenada',
'GF'=>'America/Cayenne',
'GP'=>'America/Guadeloupe',
'GT'=>'America/Guatemala',
'GY'=>'America/Guyana',
'HN'=>'America/Tegucigalpa',
'HT'=>'America/Port-au-Prince',
'JM'=>'America/Jamaica',
'KN'=>'America/St_Kitts',
'KY'=>'America/Cayman',
'LC'=>'America/St_Lucia',
'MQ'=>'America/Martinique',
'MS'=>'America/Montserrat',
'NI'=>'America/Managua',
'PA'=>'America/Panama',
'PE'=>'America/Lima',
'PM'=>'America/Miquelon',
'PR'=>'America/Puerto_Rico',
'PY'=>'America/Asuncion',
'SR'=>'America/Paramaribo',
'SV'=>'America/El_Salvador',
'TC'=>'America/Grand_Turk',
'TT'=>'America/Port_of_Spain',
'UY'=>'America/Montevideo',
'VC'=>'America/St_Vincent',
'VE'=>'America/Caracas',
'VG'=>'America/Tortola',
'VI'=>'America/St_Thomas',

// EUROPE
'AD'=>'Europe/Andorra',
'AL'=>'Europe/Tirane',
'AT'=>'Europe/Vienna',
'AX'=>'Europe/Mariehamn',
'BA'=>'Europe/Sarajevo',
'BE'=>'Europe/Brussels',
'BG'=>'Europe/Sofia',
'BY'=>'Europe/Minsk',
'CH'=>'Europe/Zurich',
'CS'=>'Europe/Belgrade',
'CZ'=>'Europe/Prague',
'DE'=>'Europe/Berlin',
'DK'=>'Europe/Copenhagen',
'EE'=>'Europe/Tallinn',
'ES'=>'Europe/Madrid',
'FI'=>'Europe/Helsinki',
'FR'=>'Europe/Paris',
'GB'=>'Europe/London',
'GI'=>'Europe/Gibraltar',
'GR'=>'Europe/Athens',
'HR'=>'Europe/Zagreb',
'HU'=>'Europe/Budapest',
'IE'=>'Europe/Dublin',
'IT'=>'Europe/Rome',
'LI'=>'Europe/Vaduz',
'LT'=>'Europe/Vilnius',
'LU'=>'Europe/Luxembourg',
'LV'=>'Europe/Riga',
'MC'=>'Europe/Monaco',
'MD'=>'Europe/Chisinau',
'MK'=>'Europe/Skopje',
'MT'=>'Europe/Malta',
'NL'=>'Europe/Amsterdam',
'NO'=>'Europe/Oslo',
'PL'=>'Europe/Warsaw',
'PT'=>'Europe/Lisbon',
'RO'=>'Europe/Bucharest',
'SE'=>'Europe/Stockholm',
'SI'=>'Europe/Ljubljana',
'SK'=>'Europe/Bratislava',
'SM'=>'Europe/San_Marino',
'TR'=>'Europe/Istanbul',
'VA'=>'Europe/Vatican',

// Asia / pacific
'NZ'=>'Pacific/Auckland',

);

?>
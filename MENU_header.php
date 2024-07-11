<?
//************************************************************************
// Leonardo XC Server, https://github.com/leonardoxc/leonardoxc
//
// Copyright (c) 2004-2010 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: MENU_header.php,v 1.6 2010/03/14 20:56:11 manolis Exp $                                                                 
//
//************************************************************************

// NOT USED!!!
exit;

open_inner_table('',750);
echo '<tr><td>';

list($countriesCodes,$countriesNames,$countriesFlightsNum)=getCountriesList();
$countriesNum=count($countriesNames);

$i=0;
foreach ($countriesNames as $countryName)
{
	echo '<a href="'.CONF_MODULE_ARG.'&country='.$countriesCodes[$i].'">'.$countryName.'</a> :: ';
	++$i;
}

echo '</td></tr>';
close_inner_table();

?>
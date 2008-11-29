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
// $Id: MENU_header.php,v 1.4 2008/11/29 22:46:07 manolis Exp $                                                                 
//
//************************************************************************

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
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
// $Id: GUI_index_full.php,v 1.12 2008/11/29 22:46:07 manolis Exp $                                                                 
//
//************************************************************************

	require_once dirname(__FILE__)."/CL_template.php";
	$Ltemplate = new LTemplate(dirname(__FILE__).'/templates/'.$PREFS->themeName);

	$Ltemplate ->set_filenames(array(
		'body' => 'index_full.html')
	);


	list($countriesCodes,$countriesNames,$countriesFlightsNum)=getCountriesList();
	$countriesNum=count($countriesNames);
	require_once dirname(__FILE__)."/FN_areas.php";

	$i=0;
	foreach($countriesNames as $countryName) {
	
		$continentNum=$countries2continent[$countriesCodes[$i]];
		$lgStrings[$continentNum].="<li><a href='javascript:jumpToLeague(\"".$countriesCodes[$i]."\") '>$countryName </a></li>\n";
		


		
		$ctStrings[$continentNum].="<li><a href='javascript:jumpToFlights(\"".$countriesCodes[$i]."\") '>$countryName </a></li>\n";

		$tkStrings[$continentNum].="<li><a href='javascript:jumpToTakeoffs(\"".$countriesCodes[$i]."\") '>$countryName </a></li>\n";

		$Ltemplate->assign_block_vars('lg', array(	 	
			'link'=> "javascript:jumpToLeague('".$countriesCodes[$i]."')",
			'name'=>$countryName
		));

		$Ltemplate->assign_block_vars('ct', array(	 	
			'link'=> "javascript:jumpToFlights('".$countriesCodes[$i]."')",
			'name'=>$countryName,
			'flNum'=>$countriesFlightsNum[$i]
		));

		$Ltemplate->assign_block_vars('tk', array(	 	
			'link'=> "javascript:jumpToTakeoffs('".$countriesCodes[$i]."')",
			'name'=>$countryName			
		));
		$i++;
	}


$lgStr='<div class="vnav">
<ul>
  <li><a href="javascript:jumpToLeague(0)"><b>'._WORLD_WIDE.'</b></a></li>
   
';
$ctStr='<div class="vnav">
<ul>
  <li><a href="javascript:jumpToFlights(0)"><b>'._WORLD_WIDE.'</b></a></li>
';
$tkStr='<div class="vnav">
<ul>
  <li><a href="javascript:jumpToTakeoffs(0)"><b>'._WORLD_WIDE.'</b></a></li>
';

	for($c=1;$c<=6;$c++) {
		if ($lgStrings[$c]) $lgStr.="<li> <a href='#'>".$continents[$c]."</a><ul>\n".$lgStrings[$c]."</ul></li>";
		if ($ctStrings[$c]) $ctStr.="<li> <a href='#'>".$continents[$c]."</a><ul>\n".$ctStrings[$c]."</ul></li>";
		if ($tkStrings[$c]) $tkStr.="<li> <a href='#'>".$continents[$c]."</a><ul>\n".$tkStrings[$c]."</ul></li>";
	}

$lgStr.='
</ul>
</div>';

$ctStr.='
</ul>
</div>';

$tkStr.='
</ul>
</div>';
	
	$sel_years="";
	for($i=date("Y");$i>=2000;$i--) {
		 if($i==date("Y")) $sel=" selected";
		 else $sel="";
		 $sel_years.="<option value='$i' $sel>$i</option>\n";
	}

	$sel_cat="";
	foreach ( $CONF_glider_types as $gl_id=>$gl_type) {
		if ($gl_id==$CONF_default_cat_view) $is_type_sel ="selected";
		else $is_type_sel ="";
		$sel_cat.="<option $is_type_sel value=$gl_id>".$gliderCatList[$gl_id]."</option>\n";
	}

	if ( ! $CONF_use_htc_ie_hack ) { 
		$Ltemplate->assign_block_vars('ieHoverJS', array() );
	}

	if ($userID>0) {
		$Ltemplate->assign_block_vars('myMenu', array(	 	
			'LINK_MY_FLIGHTS' =>getLeonardoLink(array('op'=>'list_flights','pilotID'=>$userID,
						'takeoffID'=>'0','country'=>'0',
						'year'=>'0','month'=>'0','season'=>'0')),
			'LINK_MY_PROFILE' =>getLeonardoLink(array('op'=>'pilot_profile','pilotIDview'=>$userID)),
			'LINK_MY_STATS'   =>getLeonardoLink(array('op'=>'pilot_profile_stats','pilotIDview'=>$userID)),
			'LINK_MY_SETTINGS'=>getLeonardoLink(array('op'=>'user_prefs')),
		));
	}
	$Ltemplate->assign_vars( array(	 
		'lgStr'=>$lgStr,
		'ctStr'=>$ctStr,
		'tkStr'=>$tkStr,
		'YEARS_OPTION'=>$sel_years,
		'CATS_OPTION'=>$sel_cat,

		'LINK_SITES_GUIDE'=>getLeonardoLink(array('op'=>'sites')),
		'LINK_SHOW_LAST_ADDED'=>getLeonardoLink(array('op'=>'list_flights','sortOrder'=>'dateAdded',
						'year'=>'0','month'=>'0','season'=>'0',
						'country'=>'0','takeoffID'=>'0','pilotID'=>'0')),
		'LINK_SHOW_PILOTS'    =>getLeonardoLink(array('op'=>'list_pilots','comp'=>'0')),
		'LINK_SUBMIT_FLIGHT'  =>getLeonardoLink(array('op'=>'add_flight')),

		'SHOW_LEAGUE_URL'=> getLeonardoLink(array('op'=>'competition',
								'country'=>'%country%','year'=>'%year%','month'=>'0','cat'=>'%cat%')),
		'SHOW_FLIGHTS_URL'=> getLeonardoLink(array('op'=>'list_flights',
								'country'=>'%country%','year'=>'%year%','month'=>'0','cat'=>'%cat%',
								'takeoffID'=>'0','pilotID'=>'0')),
		'SHOW_TAKEOFFS_URL'=> getLeonardoLink(array('op'=>'list_takeoffs',
								'country'=>'%country%','takeoffID'=>'0','pilotID'=>'0','year'=>'0','month'=>'0','cat'=>'0')),
		
	));

   	$Ltemplate->pparse('body');
	$noFooterMenu=1;
	
?>
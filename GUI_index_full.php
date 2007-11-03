<? 
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://sourceforge.net/projects/leonardoserver                       */
/* http://leonardo.thenet.gr                                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

	require_once $moduleRelPath."/CL_template.php";
	$Ltemplate = new LTemplate($moduleRelPath.'/templates/'.$PREFS->themeName);

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
//			'link'=> CONF_MODULE_ARG.'&op=list_takeoffs&year=0&takeoffID=0&pilotID=0&country='.$countriesCodes[$i],
			'name'=>$countryName			
		));
		$i++;
	}


$lgStr='<div id="vnav">
<ul>
  <li><a href="javascript:jumpToLeague(0)"><b>'._WORLD_WIDE.'</b></a></li>
   
';
$ctStr='<div id="vnav">
<ul>
  <li><a href="javascript:jumpToFlights(0)"><b>'._WORLD_WIDE.'</b></a></li>
';
$tkStr='<div id="vnav">
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
	if ($userID>0) {
		$Ltemplate->assign_block_vars('myMenu', array(	 	
			'LINK_MY_FLIGHTS' =>"".CONF_MODULE_ARG."&op=list_flights&pilotID=$userID&takeoffID=0&country=0&year=0&month=0",
			'LINK_MY_PROFILE' =>"".CONF_MODULE_ARG."&op=pilot_profile&pilotIDview=$userID",
			'LINK_MY_STATS'   =>"".CONF_MODULE_ARG."&op=pilot_profile_stats&pilotIDview=$userID",
			'LINK_MY_SETTINGS'=>"".CONF_MODULE_ARG."&op=user_prefs",
		));
	}
	$Ltemplate->assign_vars( array(	 
		'lgStr'=>$lgStr,
		'ctStr'=>$ctStr,
		'tkStr'=>$tkStr,
		'YEARS_OPTION'=>$sel_years,
		'CATS_OPTION'=>$sel_cat,

		'LINK_SITES_GUIDE'=>"".CONF_MODULE_ARG."&op=sites",
		'LINK_SHOW_LAST_ADDED'=>"".CONF_MODULE_ARG."&op=list_flights&sortOrder=dateAdded&year=0&month=0&takeoffID=0&country=0&pilotID=0",
		'LINK_SHOW_PILOTS'    =>"".CONF_MODULE_ARG."&op=list_pilots&comp=0",
		'LINK_SUBMIT_FLIGHT'  =>"".CONF_MODULE_ARG."&op=add_flight",

		'SHOW_LEAGUE_URL'=> getRelMainFileName()."&op=competition",
		'SHOW_FLIGHTS_URL'=> getRelMainFileName()."&op=list_flights&takeoffID=0&pilotID=0",
		'SHOW_TAKEOFFS_URL'=> getRelMainFileName()."&op=list_takeoffs&pilotID=0"
	));

   	$Ltemplate->pparse('body');
	$noFooterMenu=1;
?>

<?  
/************************************************************************/
/* Leonardo: Gliding XC Server					                                */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://sourceforge.net/projects/leonardoserver                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

	$pilotsList=array();
	$pilotsID=array();
	
	list($takeoffs,$takeoffsID)=getTakeoffList();
	list($countriesCodes,$countriesNames)=getCountriesList();

	require_once $moduleRelPath."/CL_template.php";
	$Ltemplate = new LTemplate($moduleRelPath.'/templates/'.$PREFS->themeName);

	$Ltemplate ->set_filenames(array(
		'body' => 'admin_sites.html')
	);

	$COUNTRIES_OPTION_LIST="";
	for($k=0;$k<count($countriesCodes);$k++) {
		$sel=($countriesCodes[$k]==$FILTER_country1_select)?"selected":"";
		$COUNTRIES_OPTION_LIST.="<option value='".$countriesCodes[$k]."' $sel>".$countriesNames[$k]." (".$countriesCodes[$k].")</option>\n";
	}

	$TAKEOFF_OPTION_LIST="";
	for($k=0;$k<count($takeoffs);$k++) {
		$sel=($takeoffsID[$k]==$FILTER_takeoff1_select)?"selected":"";
		 $TAKEOFF_OPTION_LIST.="<option value='".$takeoffsID[$k]."' $sel>".$takeoffs[$k]."</option>\n";
	}

	
	$countriesNum=count($countriesNames);
	require_once dirname(__FILE__)."/FN_areas.php";

	$i=0;
	foreach($countriesNames as $countryName) {
		$continentNum=$countries2continent[$countriesCodes[$i]];
		// $tkStrings[$continentNum].="<li><a href='javascript:selCountry(\"".$countriesCodes[$i]."\") '>$countryName </a></li>\n";
		$tkStrings[$continentNum].="<option value='".$countriesCodes[$i]."'>$countryName</option>\n";
		$i++;
	}
/*
1=>"Europe ",
2=>"South America ",
3=>"North & Central America ",
4=>"Africa ",
5=>"Asia ",
6=>"Oceania "*/
	for($continentNum=1;$continentNum<=6;$continentNum++) {
		$continentString=$tkStrings[$continentNum];
		$Ltemplate->assign_vars( array(	 	
			// 'continent_'.$continentNum=>"<ul><li><a href='#'><strong>".$continents[$continentNum]."</strong></a></li>".$continentString."<ul>"
			'continent_'.$continentNum=>"<select name='c_$continentNum' id='c_$continentNum' onchange='selCountryAction(\"c_$continentNum\");' >
					<option value=0><strong>Select Country: </strong></option>\n".$continentString."</select>\n"

		) );
	}

	$Ltemplate->assign_vars( array(	 	
		'TAKEOFF_OPTION_LIST'=>$TAKEOFF_OPTION_LIST,
		'COUNTRIES_OPTION_LIST'=>$COUNTRIES_OPTION_LIST,
		'MODULE_REL_PATH'=>$moduleRelPath,		
		'TEMPLATE_REL_PATH'=>$moduleRelPath."/templates/".$PREFS->themeName ,
		'LANG'=>$currentlang,
	));

   	$Ltemplate->pparse('body');
?>

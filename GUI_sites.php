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

	require $moduleRelPath."/CL_template.php";
	$Ltemplate = new LTemplate($moduleRelPath.'/templates/'.$PREFS->themeName);

	$Ltemplate ->set_filenames(array(
		'body' => 'sites.html')
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

	$Ltemplate->assign_vars( array(	 	
		'TAKEOFF_OPTION_LIST'=>$TAKEOFF_OPTION_LIST,
		'COUNTRIES_OPTION_LIST'=>$COUNTRIES_OPTION_LIST,
		'MODULE_REL_PATH'=>$moduleRelPath,
	));

   	$Ltemplate->pparse('body');
?>

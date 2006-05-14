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

	require $moduleRelPath."/CL_template.php";
	$Ltemplate = new LTemplate($moduleRelPath.'/templates/'.$PREFS->themeName);

	$Ltemplate ->set_filenames(array(
		'body' => 'index_full.html')
	);


	list($countriesCodes,$countriesNames,$countriesFlightsNum)=getCountriesList();
	$countriesNum=count($countriesNames);

	$i=0;
	foreach($countriesNames as $countryName) {
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
//			'link'=>'?name='.$module_name.'&op=list_takeoffs&year=0&takeoffID=0&pilotID=0&country='.$countriesCodes[$i],
			'name'=>$countryName			
		));
		$i++;
	}

	$sel_years="";
	for($i=date("Y");$i>=2000;$i--) {
		 if($i==date("Y")) $sel=" selected";
		 else $sel="";
		 $sel_years.="<option $sel>$i</option>\n";
	}

	$sel_cat="";
	foreach ( $CONF_glider_types as $gl_id=>$gl_type) {
		if ($gl_id==$CONF_default_cat_view) $is_type_sel ="selected";
		else $is_type_sel ="";
		$sel_cat.="<option $is_type_sel value=$gl_id>".$gliderCatList[$gl_id]."</option>\n";
	}
	if ($userID>0) {
		$Ltemplate->assign_block_vars('myMenu', array(	 	
			'LINK_MY_FLIGHTS' =>"?name=$module_name&op=list_flights&pilotID=$userID&takeoffID=0&country=0&year=0&month=0",
			'LINK_MY_PROFILE' =>"?name=$module_name&op=pilot_profile&pilotIDview=$userID",
			'LINK_MY_STATS'   =>"?name=$module_name&op=pilot_profile_stats&pilotIDview=$userID",
			'LINK_MY_SETTINGS'=>"?name=$module_name&op=user_prefs",
		));
	}
	$Ltemplate->assign_vars( array(	 	
		'YEARS_OPTION'=>$sel_years,
		'CATS_OPTION'=>$sel_cat,

		'LINK_SHOW_LAST_ADDED'=>"?name=$module_name&op=list_flights&sortOrder=dateAdded&year=0&month=0&takeoffID=0&country=0&pilotID=0",
		'LINK_SHOW_PILOTS'    =>"?name=$module_name&op=list_pilots&comp=0",
		'LINK_SUBMIT_FLIGHT'  =>"?name=$module_name&op=add_flight",

		'SHOW_LEAGUE_URL'=> "$baseInstallationPath/$CONF_mainfile?name=$module_name&op=competition",
		'SHOW_FLIGHTS_URL'=> "$baseInstallationPath/$CONF_mainfile?name=$module_name&op=list_flights&takeoffID=0&pilotID=0",
		'SHOW_TAKEOFFS_URL'=> "$baseInstallationPath/$CONF_mainfile?name=$module_name&op=list_takeoffs&pilotID=0"
	));

   	$Ltemplate->pparse('body');
?>

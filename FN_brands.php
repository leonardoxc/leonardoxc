<?
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://leonardo.thenet.gr                                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


function guessBrandID($gliderType,$gliderDesc){
	global  $brandsList;
	if (!is_array($brandsList[$gliderType]) ) return 0;
	
	foreach($brandsList[$gliderType] as $brandID=>$brandName) {
		if (  ! ( strpos(strtolower(str_replace(" ","",$gliderDesc)),strtolower($brandName) ) === false ) ) {
			return $brandID;
		}
	
	}
	return 0;
}

//------------------- GLIDER BRANDS DEFINITIONS & RELATED FUNCTIONS ----------------------------
 $brandsList[1]=array(
	1=>"Advance",
	"Airwave",
	"Gin",
	"Icaro",
	"Nova",
	"Skywalk",
	"Swing",
	"UP",
	"SOL",
	"Gradient",	//10 
	"FreeX",
	"ProDesign",
	"MacPara",
	"UTurn",
	"Apco",		//15
	"Woc",
	"Windtech",
	"Sky",
	"Ozone",
	"Aerodyne", //20
	"Aircross",
	"Paratech",
	"Dudek",
	"Firebird",
	"FlightDesign", // 25 
	"Niviuk",
	"Independence",
	"Axis", 
	// to be added
//	"FlyingPlanet", // not found
//	"ADG",      // not found


 );
 /*
 $__brandsList=array(
	"Airwave",
	"Pegas",
	"Trekking",
	"Ozone",
	"MacPara",
	"UP",
	"Swing",
	"Paratech",
	"Nove",
	"Apco",
	"Sol",
	"Advance",
	"Windtech",
	"Aerodyne",
	"Sky Paragliders",
	"Perche",
	"Aeros",
	"FreeX",
	"Wings Of Change",
	"XIX",
	"Gradient",
	"ITV",
	"Firebird",
	"Nervures",
	"ProDesign",
	"Skywalk",
	"Icaro",
	"Dudek",
	"Independence",
	"U-Turn",
	"Gin",
	"Edel" );
	*/
?>
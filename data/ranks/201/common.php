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

   $res= $db->sql_query($query);
//echo "<BR><BR><BR>$query";
   if($res <= 0){
      echo("<H3> "._THERE_ARE_NO_PILOTS_TO_DISPLAY."</H3>\n");
      exit();
   }

$i=1;
$pilots=array(); // new method -> one multi array
list($takeoffsCountry,$takeoffsContinent)=getTakeoffsCountryContinent();

while ($row = $db->sql_fetchrow($res)) {
   	 $takeoffID=$row['takeoffID'];
	 $countryCode=$takeoffsCountry[$takeoffID];
	 $continentCode=$takeoffsContinent[$takeoffID];

	 $uID=$row["userServerID"].'_'.$row["userID"];
	 $flightID=$row["ID"];

	 if (!isset($pilots[$uID]['name'])){
		 $name=getPilotRealName($row["userID"],$row["userServerID"],1); 
		 $name=prepare_for_js($name);
	     $pilots[$uID]['name']=$name;
	 }
	 
	 // $flightBrandID=brands::guessBrandID($row['glider']);

	 /// Martin 30.4.2007
	 $pilots[$uID]['flights'][$flightID]['cat']=$row['cat'];
	 $flightBrandID=$row['gliderBrandID'];
	 // $flightBrandID=brands::guessBrandID($row['glider']);

	 $pilots[$uID]['flights'][$flightID]['glider']=$row['glider'];
	 $pilots[$uID]['flights'][$flightID]['brandID']=$flightBrandID;
	 $pilots[$uID]['flights'][$flightID]['type']=$row["BEST_FLIGHT_TYPE"];
	 $pilots[$uID]['flights'][$flightID]['country']=$countryCode;
	 $pilots[$uID]['flights'][$flightID]['continent']=$continentCode;
	 $pilots[$uID]['flights'][$flightID]['score']=$row["FLIGHT_POINTS"];
     $i++;
}

//	$sortbyList=array('score');
	$sortbyList=array('takeoffID');
	foreach ($sortbyList as $key) {
		$code = '$a=$a1["'.$key.'"]; $b=$b1["'.$key.'"]; if ($a==$b) return 0; return ($a < $b) ? 1 : -1;';
		$sort_funcs[$key] = create_function('$a1, $b1', $code);
		//print_r($sort_funcs[$key]);
	}

	$sortbyList_pilots=array('score');
	foreach ($sortbyList_pilots as $key) {
		$code2 = '$a=$a1["'.$key.'"]["sum"]; $b=$b1["'.$key.'"]["sum"]; if ($a==$b) return 0; return ($a < $b) ? 1 : -1;';
		$sort_funcs_pilots[$key] = create_function('$a1, $b1', $code2);
	}


//	$countHowMany= $CONF_countHowManyFlightsInComp;
	$countHowMany= 8; // german rule

	foreach ($pilots as $pilotID=>$pilotArray) {
		$flightsArray=&$pilots[$pilotID]['flights'];
		// now custom rule
		// sort by olc ,
		// keep only europe flights
		// if we are done , check the if at least one flight in german
		// if not  keep scanning and replace the last flight in the list!

		$key='score';
		$category='score';
		//print_r($flightsArray);
		uasort($flightsArray,$sort_funcs[$key]);
		$bestSUM=0;
		$i=0;
		$nationalFlights=0;
		foreach ($flightsArray as $flightID=>$flight) {
			if ($flight['continent']!=1)  continue;
			//var_dump($flight['country']);
			if ($flight['country']=='PL') $nationalFlights++;
			$pilots[$pilotID][$category]['flights'][$i]=$flightID;
			$lastVal=$flight[$key];
			$bestSUM+=$flight[$key];
			$i++;
			//print_r($lastVal.' ');
		 	//print_r($flightsArray);
			if ($i==$countHowMany &&  $countHowMany!=0) break;
		}

		if (!$nationalFlights &&  $i==$countHowMany) { // find first national flight ID and replace the last flight in the list
		//echo "<HR><HR>no national flight found ";
			foreach ($flightsArray as $flightID=>$flight) {
				if ($flight['country']=='PL') {
					$nationalFlights++;
					$pilots[$pilotID][$category]['flights'][$countHowMany-1]=$flightID;
					$bestSUM-=$lastVal;
					$bestSUM+=$flight[$key];
					break;
				}
			}
		}

		if (!$nationalFlights && $i==$countHowMany) { // there are no national flights -> delete last flight from list
			//	echo "<HR>no national flight found will delete last flight<BR>";
			$bestSUM-=$lastVal;
			unset($pilots[$pilotID][$category]['flights'][$countHowMany-1]);
		}

		$pilots[$pilotID][$category]['sum']=$bestSUM;


	}
//	 print_r($pilots);
?>

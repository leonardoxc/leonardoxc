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
	// echo "<BR><BR><BR>$query";

   if($res <= 0){
	   echo $query;
      echo("<H3> "._THERE_ARE_NO_PILOTS_TO_DISPLAY."</H3>\n");
      exit();
   }
	// echo mysql_num_rows($res);

$i=1;
$clubs=array(); // new method -> one multi array
list($takeoffsCountry,$takeoffsContinent)=getTakeoffsCountryContinent();

while ($row = $db->sql_fetchrow($res)) {
   	 $takeoffID=$row['takeoffID'];
	 $countryCode=$takeoffsCountry[$takeoffID];
	 $continentCode=$takeoffsContinent[$takeoffID];

	 $clubID=$row["NACclubID"];
	 // $uID=$row["userID"];
	 $uID=$row["userServerID"].'_'.$row["userID"];
	 $flightID=$row["ID"];

	 $flightBrandID=$row['gliderBrandID'];
	 // $flightBrandID=brands::guessBrandID($row['glider']);

	 $clubs[$clubID][$uID]['flights'][$flightID]['userID']=$uID;
	 $clubs[$clubID][$uID]['flights'][$flightID]['glider']=$row['glider'];

	 $clubs[$clubID][$uID]['flights'][$flightID]['brandID']=$flightBrandID;
	 $clubs[$clubID][$uID]['flights'][$flightID]['type']=$row["BEST_FLIGHT_TYPE"];
	 $clubs[$clubID][$uID]['flights'][$flightID]['country']=$countryCode;
	 $clubs[$clubID][$uID]['flights'][$flightID]['continent']=$continentCode;
	 $clubs[$clubID][$uID]['flights'][$flightID]['score']=$row["score"];
     $i++;
}

	$sortbyList=array('score');
	foreach ($sortbyList as $key) {
		$code = '$a=$a1["'.$key.'"]; $b=$b1["'.$key.'"]; if ($a==$b) return 0; return ($a < $b) ? 1 : -1;';
		$sort_funcs[$key] = create_function('$a1, $b1', $code);
	}

	$sortbyList_pilots=array('score');
	foreach ($sortbyList_pilots as $key) {
		$code2 = '$a=$a1["'.$key.'"]["sum"]; $b=$b1["'.$key.'"]["sum"]; if ($a==$b) return 0; return ($a < $b) ? 1 : -1;';
		$sort_funcs_pilots[$key] = create_function('$a1, $b1', $code2);
	}

	function compFuncFlights($a1,$b1) {
		$a=$a1["score"];
		$b=$b1["score"];
		if ($a==$b) return 0;
		return ($a < $b) ? 1 : -1;
	}

	function compFunc($a1,$b1) {
		$a=$a1["sum"];
		$b=$b1["sum"];
		if ($a==$b) return 0;
		return ($a < $b) ? 1 : -1;
	}


	$pilotsMax= 3; // german rule -> 3 pilots / club
	$pilotsMin=2; // minimum 2 pilots
	$countHowManyFlights= 3; // german rule

// print_r($clubs);
/*
reset($arr);
while (list($key, $value) = each($arr)) {
    echo "Key: $key; Value: $value<br />\n";
}
*/


	foreach ($clubs as $clubID=>$clubArray) {
		foreach($clubArray as $pilotID=>$pilot) {
			//sort each pilots flights
			$flightsArray=$clubs[$clubID][$pilotID]['flights'];

			//	$flightsArray=&$clubs[$clubID]['flights'];
			// now custom rule
			// sort by olc ,
			// keep only europe flights
			// if we are done , check the if at least one flight in german
			// if not  keep scanning and replace the last flight in the list!

			$key='score';
			$category='score';
			uasort($flightsArray,"compFuncFlights");
			$bestSUM=0;
			$i=0;
			$nationalFlights=0;
			foreach ($flightsArray as $flightID=>$flight) {
				// if ($flight['continent']!=1)  continue;
				if ($flight['country']!='GR') continue;
				
				if ($flight['country']=='GR') $nationalFlights++;
				$clubs[$clubID][$pilotID]['flights_sel'][$i]=$flightID;

//				$clubs[$clubID][$category]['flights'][$i]=$flightID;
				$lastVal=$flight[$key];
				$bestSUM+=$flight[$key];
				$i++;
				if ($i==$countHowManyFlights &&  $countHowManyFlights!=0) break;
			}

			if (!$nationalFlights &&  $i==$countHowManyFlights) { // find first national flight ID and replace the last flight in the list
			//echo "<HR><HR>no national flight found ";
				foreach ($flightsArray as $flightID=>$flight) {
					if ($flight['country']=='GR') {
						$nationalFlights++;
						$clubs[$clubID][$pilotID]['flights_sel'][$countHowManyFlights-1]=$flightID;
						// $clubs[$clubID][$category]['flights'][$countHowMany-1]=$flightID;
						$bestSUM-=$lastVal;
						$bestSUM+=$flight[$key];
						break;
					}
				}
			}

			if (!$nationalFlights && $i==$countHowManyFlights) { // there are no national flights -> delete last flight from list
				//	echo "<HR>no national flight found will delete last flight<BR>";
				$bestSUM-=$lastVal;
				if ($bestSUM<0) $bestSUM=0;
				// unset($clubs[$clubID][$category]['flights'][$countHowMany-1]);
				unset($clubs[$clubID][$pilotID]['flights_sel'][$countHowManyFlights-1]);
			}

			$clubs[$clubID][$pilotID]['sum']=$bestSUM;

			if ($bestSUM==0) unset($clubs[$clubID][$pilotID]);

			// FOR DEBUG ONLY!!
			//unset($clubs[$clubID][$pilotID]['flights']);


		} // done with all the pilots of this club!

		// now sort all pilots of the club accorinding to  $clubs[$clubID][$pilotID]['sum']
		uasort($clubs[$clubID],"compFunc");

		// get the first 3 pilots from the club.
		$clubScore=0;
		$clubPilotsNum=0;
		$pn=0;
		foreach($clubs[$clubID] as $pilotID=>$pilot){
			$clubScore+=$pilot['sum'];
			$clubPilotsNum++;
			if ($clubPilotsNum==3) break; // only top 3 pilots
		}
		if ($clubPilotsNum>=1)
			$clubs[$clubID]['sum']=$clubScore; // we need at least 1 pilot
		else
			$clubs[$clubID]['sum']=0;

	}  // done with clubs

	// now sort clubs accoring to sum
 	uasort($clubs,"compFunc");

	//  print_r($clubs);

?>
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

//-----------------------------------------------------------------------
//-----------------------  custom league --------------------------------
//-----------------------------------------------------------------------
  require_once dirname(__FILE__)."/FN_brands.php";

exit;
  $sortOrder=$_REQUEST["sortOrder"];
  if ( $sortOrder=="")  $sortOrder="bestOlcScore";

  $legend=_LEAGUE_RESULTS." ";

  if ($cat==0) { 
	if ( $clubID && is_array($clubsList[$clubID]['gliderCat']) ) {	
		$cat=$clubsList[$clubID]['gliderCat'][0];
	} else $cat=1;  	
  }
  $where_clause=" AND cat=$cat ";
  $legend.=" :: ".$gliderCatList[$cat]." ";

  $page_num=$_REQUEST["page_num"]+0;
  if ($page_num==0)  $page_num=1;

  if ($country) {
		$legend.=" :: ".$countries[$country]." ";				
  }

  if ($year && !$month) {
		$where_clause.=" AND DATE_FORMAT(DATE,'%Y') = ".$year." ";
		$legend.=" :: ".$year." ";
  }
  if ($year && $month) {
		$where_clause.=" AND DATE_FORMAT(DATE,'%Y%m') = ".$year.$month." ";
		$legend.=" :: ".$monthList[$month-1]." ".$year." ";
  }
  if (! $year ) {
	$legend.=" :: "._ALL_TIMES." ";
  }

   $sortDescArray=array("pilotName"=>_PILOT_NAME, "totalFlights"=>_CATEGORY_FLIGHT_NUMBER, "totalDistance"=>_TOTAL_DISTANCE, 
			     "totalDuration"=>_CATEGORY_TOTAL_DURATION, "bestDistance"=>_CATEGORY_OPEN_DISTANCE, 
			     "totalOlcKm"=>_TOTAL_OLC_DISTANCE, "totalOlcPoints"=>_TOTAL_OLC_SCORE, "bestOlcScore"=>_BEST_OLC_SCORE, 
				 "mean_duration"=>_MEAN_DURATION, "mean_distance"=>_MEAN_DISTANCE );
  
   $sortDesc=$sortDescArray[ $sortOrder];
   $ord="DESC";
	
  $sortOrderFinal=$sortOrder;
  //$legend.=$sortDesc;

  $query_str="";
  $query_str.="&comp=".$is_comp;

  $res= $db->sql_query("SELECT count(DISTINCT userID) as itemNum FROM $flightsTable  WHERE (userID!=0 AND  private=0) ".$where_clause." ");
  if($res <= 0){   
	 echo("<H3> Error in count items query! </H3>\n");
     exit();
  }

  $row = $db->sql_fetchrow($res);
  $itemsNum=$row["itemNum"];   

  $startNum=($page_num-1)*$CONF_compItemsPerPage;
  $pagesNum=ceil ($itemsNum/$CONF_compItemsPerPage);

  if ($country) {
		$where_clause_country.=" AND $waypointsTable.countryCode='".$country."' ";
  }

  if ($clubID)   {
	 require dirname(__FILE__)."/INC_club_where_clause.php";
/*	 $areaID=$clubsList[$clubID]['areaID'];
  	 $addManual=$clubsList[$clubID]['addManual'];

	 $where_clause.=" AND 	$flightsTable.userID=$clubsPilotsTable.pilotID AND 
				 			$clubsPilotsTable.clubID=$clubID ";
	$extra_table_str.=",$clubsPilotsTable ";

	if ($areaID) {
		 $where_clause.= " 	AND $areasTakeoffsTable.areaID=$clubsTable.areaID 
							AND $areasTakeoffsTable.takeoffID=$flightsTable.takeoffID  ";
	 	 $extra_table_str.=",$areasTakeoffsTable ";
	}	
	if ($addManual) {
		 $where_clause.= " 	AND $clubsFlightsTable.flightID=$flightsTable.ID 
							AND $clubsFlightsTable.clubID=$clubID ";
	 	 $extra_table_str.=",$clubsFlightsTable ";
	}
	*/
  } 
  
  if ($countryCodeQuery || $country)   {
	 $where_clause.=" AND $flightsTable.takeoffID=$waypointsTable.ID ";
	 $extra_table_str.=",".$waypointsTable;
  } else $extra_table_str.="";

  $where_clause.=$where_clause_country;
  
  echo  "<div class='tableTitle shadowBox'><div class='titleDiv'>$legend</div></div>" ;
  require_once dirname(__FILE__)."/MENU_second_menu.php";

  $query = 'SELECT '.$flightsTable.'.ID, userID, username, takeoffID ,
  				 gliderBrandID,'.$flightsTable.'.glider as glider,cat,
  				 MAX_ALT , TAKEOFF_ALT, DURATION , LINEAR_DISTANCE, FLIGHT_POINTS  , FLIGHT_KM, BEST_FLIGHT_TYPE  '
  		. ' FROM '.$flightsTable.', '.$prefix.'_users' . $extra_table_str
        . ' WHERE (userID!=0 AND  private=0) AND '.$flightsTable.'.userID = '.$prefix.'_users.user_id '.$where_clause
        . ' ';

   $res= $db->sql_query($query);
	//	echo $query;
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

	// if ( $continentCode != 1 ) continue;
	// if ($countryCode!='DE') continue;

	 $uID=$row["userID"];
	 $flightID=$row["ID"];

	 if (!isset($pilots[$uID]['name'])){
		 $name=getPilotRealName($uID,1); 
		 $name=prepare_for_js($name);
	     $pilots[$uID]['name']=$name;
	 }
	 
	 $brandID=guessBrandID($row['cat'],$row['glider']);

	 $pilots[$uID]['flights'][$flightID]['glider']=$row['glider'];
	 $pilots[$uID]['flights'][$flightID]['brandID']=$brandID;
	 $pilots[$uID]['flights'][$flightID]['type']=$row["BEST_FLIGHT_TYPE"];
	 $pilots[$uID]['flights'][$flightID]['country']=$countryCode;
	 $pilots[$uID]['flights'][$flightID]['continent']=$continentCode;

	 $pilots[$uID]['flights'][$flightID]['olc']=$row["FLIGHT_POINTS"];

	 $pilots[$uID]['flights'][$flightID]['open']=$row["LINEAR_DISTANCE"];
	 if ($row["BEST_FLIGHT_TYPE"] == "FAI_TRIANGLE") 
		$pilots[$uID]['flights'][$flightID]['fai_triagle']=$row["FLIGHT_KM"];

	 $pilots[$uID]['flights'][$flightID]['alt']=$row["MAX_ALT"];
	 $gain=$row["MAX_ALT"]- $row["TAKEOFF_ALT"];
	 $pilots[$uID]['flights'][$flightID]['gain']=$gain;
	 $pilots[$uID]['flights'][$flightID]['duration']=$row["DURATION"];

     $i++;
} 

	$sortbyList=array('olc','open','fai_triagle','gain','duration');
	foreach ($sortbyList as $key) {
		$code = '$a=$a1["'.$key.'"]; $b=$b1["'.$key.'"]; if ($a==$b) return 0; return ($a < $b) ? 1 : -1;';
		$sort_funcs[$key] = create_function('$a1, $b1', $code);
	}

	$sortbyList_pilots=array('olc','open','fai_triagle','gain','duration','german-olc');
	foreach ($sortbyList_pilots as $key) {
		$code2 = '$a=$a1["'.$key.'"]["sum"]; $b=$b1["'.$key.'"]["sum"]; if ($a==$b) return 0; return ($a < $b) ? 1 : -1;';
		$sort_funcs_pilots[$key] = create_function('$a1, $b1', $code2);
	}


	$countHowMany= $CONF_countHowManyFlightsInComp;

	foreach ($pilots as $pilotID=>$pilotArray) {
		$flightsArray=&$pilots[$pilotID]['flights'];

		foreach ($sortbyList as $key) {
			uasort($flightsArray,$sort_funcs[$key]);
			$bestSUM=0; 
			$i=0;
			foreach ($flightsArray as $flightID=>$flight) {
				$pilots[$pilotID][$key]['flights'][$i]=$flightID;
				$bestSUM+=$flight[$key];
				$i++;
				if ($i==$countHowMany &&  $countHowMany!=0) break;
			}
			$pilots[$pilotID][$key]['sum']=$bestSUM;	
		}

		// now custom rule 
		// sort by olc , 
		// keep only europe flights	
		// if we are done , check the if at least one flight in german
		// if not  keep scanning and replace the last flight in the list!

		$key='olc';
		$category='german-olc';
		uasort($flightsArray,$sort_funcs[$key]);
		$bestSUM=0; 
		$i=0;
		$nationalFlights=0;	
		foreach ($flightsArray as $flightID=>$flight) {
			if ($flight['continent']!=1)  continue;

			if ($flight['country']=='DE') $nationalFlights++;
			$pilots[$pilotID][$category]['flights'][$i]=$flightID;
			$lastVal=$flight[$key];
			$bestSUM+=$flight[$key];
			$i++;
			if ($i==$countHowMany &&  $countHowMany!=0) break;
		}

		if (!$nationalFlights) { // find first national flight ID and replace the last flight in the list
			foreach ($flightsArray as $flightID=>$flight) {
				if ($flight['country']=='DE') { 
					$nationalFlights++;
					$pilots[$pilotID][$category]['flights'][$countHowMany-1]=$flightID;
					$bestSUM-=$lastVal;
					$bestSUM+=$flight[$key];
					break;
				}
			}
		}

		if (!$nationalFlights) { // there are no national flights -> delete last flight from list
			$bestSUM-=$lastVal;
			unset($pilots[$pilotID][$category]['flights'][$countHowMany-1]);
		}

		$pilots[$pilotID][$category]['sum']=$bestSUM;	


	}
	// print_r($pilots);

	// was _KILOMETERS -> bug
	// and _TOTAL_KM
	if ($PREFS->metricSystem==1) {
		$FAI_TRIANGLE_str=_KM;
		$MENU_OPEN_DISTANCE_str=_TOTAL_DISTANCE." "._KM;
	} else  {
		$FAI_TRIANGLE_str=_MI;
		$MENU_OPEN_DISTANCE_str=_TOTAL_DISTANCE." "._MI;
	}

?>
<script type="text/javascript" src="<?=$moduleRelPath ?>/js/tipster.js"></script>
<? echo makePilotPopup();  ?>
<script type="text/javascript" src="<?=$moduleRelPath ?>/js/tabber.js"></script>
<link rel="stylesheet" href="<?=$themeRelPath ?>/tabber.css" TYPE="text/css" MEDIA="screen">
<link rel="stylesheet" href="<?=$themeRelPath ?>/tabber-print.css" TYPE="text/css" MEDIA="print">
<script type="text/javascript">
/* Optional: Temporarily hide the "tabber" class so it does not "flash" on the page as plain HTML. 
   After tabber runs, the class is changed to "tabberlive" and it will appear. */
document.write('<style type="text/css">.tabber{display:none;}<\/style>');
</script>
<div class="tabber" id="compTabber">
<?
  listCategory(_OLC." German",				_OLC_TOTAL_SCORE,"german-olc","olc","formatOLCScore");
  listCategory(_OLC,				_OLC_TOTAL_SCORE,"olc","olc","formatOLCScore");
  listCategory(_FAI_TRIANGLE, 		$FAI_TRIANGLE_str ,"fai_triagle","fai_triagle","formatDistance");   
  listCategory(_MENU_OPEN_DISTANCE,	$MENU_OPEN_DISTANCE_str,"open","open","formatDistance");
  listCategory(_DURATION,			_TOTAL_DURATION,"duration","duration","sec2Time"); 
  listCategory(_ALTITUDE_GAIN,		_TOTAL_ALTITUDE_GAIN,"gain","gain","formatAltitude"); 
?>
</div>
<?	
function listCategory($legend,$header, $category, $key, $formatFunction="") {
   global $pilots;
   global $Theme,$countries;
   global $module_name,$moduleRelPath;
   global $CONF_compItemsPerPage;
   global $page_num,$pagesNum,$startNum,$itemsNum;
   global $op,$cat;
   global $countHowMany;
   global $tabID;
   global $sort_funcs_pilots;

   uasort($pilots,$sort_funcs_pilots[$category]);

   $legendRight=""; // show all pilots up to  $CONF_compItemsPerPage
   if ($tabID ==  ($_GET['comp']+0) ) $defaultTabStr=" tabbertabdefault";
   else  $defaultTabStr="";
   
   $tabID++;
   echo "<div class='tabbertab $defaultTabStr' title='$legend'>";
   
   $legend.=" (".$countHowMany." "._N_BEST_FLIGHTS.")";
   echo "<br><table class='listTable listTableTabber' cellpadding='2' cellspacing='0'>
   			<tr><td class='tableTitleExtra' colspan='".($countHowMany+4)."'>$legend</td></tr>";
   
   ?>
   <tr>
   <td class="SortHeader" width="30"><? echo _NUM ?></td>
   <td class="SortHeader"><div align=left><? echo _PILOT ?></div></td>
   <td class="SortHeader" width="70"><? echo $header ?></td>
   <? for ($ii=1;$ii<=$countHowMany;$ii++) { ?>
   <td class="SortHeader" width="55">#<? echo $ii?></td>
   <? } ?>
   <td class="SortHeader" width="50">&nbsp;</td>
   </tr>
   <? 

	  $i=1;
   	  foreach ($pilots as $pilotID=>$pilot) {
  		 if ($i>$CONF_compItemsPerPage) break;
		 if (!$pilot[$category]['sum']) continue;

		 $sortRowClass=($i%2)?"l_row1":"l_row2"; 
 		 if ($i==1) $bg=" class='compFirstPlace'";
 		 else if ($i==2) $bg=" class='compSecondPlace'";
 		 else if ($i==3) $bg=" class='compThirdPlace'";
		 else $bg=" class='$sortRowClass'";
		 	 	     
	     $i++;
		 echo "<TR $bg>";
		 echo "<TD>".($i-1+$startNum)."</TD>"; 	
	     echo "<TD nowrap><div align=left id='$arrayName"."_$i'>".		 
				"<a href=\"javascript:pilotTip.newTip('inline', 0, 13, '$arrayName"."_$i', 200, '".$pilotID."','".
					addslashes($pilot['name'])."' )\"  onmouseout=\"pilotTip.hide()\">".$pilot['name']."</a>".
				"</div></TD>";
		 if ($formatFunction) $outVal=$formatFunction($pilot[$category]["sum"]);
		 else $outVal=$pilot[$category]["sum"];
   	     echo "<TD>".$outVal."</TD>"; 	 
		 

		$k=0;

		unset($pilotBrands);
		$pilotBrands=array();
		foreach ($pilot[$category]['flights'] as $flightID) {
			$val=$pilot['flights'][$flightID][$key];

			$glider=$pilot['flights'][$flightID]['glider'];
			$country=$countries[$pilot['flights'][$flightID]['country']];

			$thisFlightBrandID=$pilot['flights'][$flightID]['brandID'];
			if ($thisFlightBrandID) $pilotBrands[$thisFlightBrandID]++;

			if (!$val)  $outVal="-";
			else if ($formatFunction) $outVal=$formatFunction($val);
			else $outVal=$val;
			$descr=_GLIDER.": $glider, "._COUNTRY.": $country";
			if ($val) echo "<TD><a href='?name=$module_name&op=show_flight&flightID=".$flightID."' alt='$descr'  title='$descr'>".$outVal."</a></TD>"; 	 		  
			else echo "<TD>".$outVal."</TD>"; 	 		  
			$k++;
			if ($k>=$countHowMany) break;
		}

		if ($k!=$countHowMany) {
			for($j=$k;$j<$countHowMany;$j++) {
				echo "<TD>-</TD>"; 	 		  
			}
		}

		arsort($pilotBrands);
		$brandID=array_shift(array_keys($pilotBrands));
		$gliderBrandImg="<img src='$moduleRelPath/img/brands/$cat/".sprintf("%03d",$brandID).".gif' border=0 align=abs_middle>";
		echo "<td align='center'>$gliderBrandImg</td>";
   	}	// next pilot

	echo "</table>"; 
	echo '</div>';
} //end function

?>
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
//-----------------------  list pilots ---------------------------------
//-----------------------------------------------------------------------
  require_once dirname(__FILE__)."/FN_brands.php";

  $sortOrder=makeSane($_REQUEST["sortOrder"]);
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


  // SEASON MOD
  list($dates_where_clause,$dates_legend) = dates::makeWhereClause(0,$season,$year,$month,0 , 1);
  $where_clause.=$dates_where_clause;
  $legend.=$dates_legend;

   $sortDescArray=array("pilotName"=>_PILOT_NAME, "totalFlights"=>_CATEGORY_FLIGHT_NUMBER, "totalDistance"=>_TOTAL_DISTANCE, 
			     "totalDuration"=>_CATEGORY_TOTAL_DURATION, "bestDistance"=>_CATEGORY_OPEN_DISTANCE, 
			     "totalOlcKm"=>_TOTAL_OLC_DISTANCE, "totalOlcPoints"=>_TOTAL_OLC_SCORE, "bestOlcScore"=>_BEST_OLC_SCORE, 
				 "mean_duration"=>_MEAN_DURATION, "mean_distance"=>_MEAN_DISTANCE );
  
   $sortDesc=$sortDescArray[ $sortOrder];
   $ord="DESC";
	
  $sortOrderFinal=$sortOrder;
  //$legend.=$sortDesc;

  $query_str="";
  $query_str.="&comp=".$comp;

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
  
	// was _KILOMETERS -> bug
	// and _TOTAL_KM
	if ($PREFS->metricSystem==1) {
		$FAI_TRIANGLE_str=_KM;
		$MENU_OPEN_DISTANCE_str=_TOTAL_DISTANCE." "._KM;
	} else  {
		$FAI_TRIANGLE_str=_MI;
		$MENU_OPEN_DISTANCE_str=_TOTAL_DISTANCE." "._MI;
	}

	$leagueCategories=array(
		0=>array('select_fields'=>'FLIGHT_POINTS',
				'select_as'=>'FLIGHT_POINTS',
				'sortBy'=>'FLIGHT_POINTS',
				'where_clause'=>'',
				'legend'=>_OLC,
				'header'=>_OLC_TOTAL_SCORE,
		 		'arrayName'=>"olc_score",
				'formatFunction'=>"formatOLCScore"),
		1=>array('select_fields'=>'FLIGHT_KM',
				'select_as'=>'FLIGHT_KM',
				'sortBy'=>'FLIGHT_KM',
				'where_clause'=>' AND BEST_FLIGHT_TYPE="FAI_TRIANGLE" ',
				'legend'=>_FAI_TRIANGLE,	'header'=>$FAI_TRIANGLE_str, 		'arrayName'=>"triangleKm",		'formatFunction'=>"formatDistance"),
		2=>array('select_fields'=>'LINEAR_DISTANCE',
				'select_as'=>'LINEAR_DISTANCE',
				'sortBy'=>'LINEAR_DISTANCE',
				'where_clause'=>'',
				'legend'=>_MENU_OPEN_DISTANCE,'header'=>$MENU_OPEN_DISTANCE_str,'arrayName'=>"open_distance",	'formatFunction'=>"formatDistance"),
		3=>array('select_fields'=>'DURATION',
				'select_as'=>'DURATION',
				'sortBy'=>'DURATION',
				'where_clause'=>'',
				'legend'=>_DURATION,		'header'=>_TOTAL_DURATION, 			'arrayName'=>"duration",		'formatFunction'=>"sec2Time"),
		4=>array('select_fields'=>' ( MAX_ALT-TAKEOFF_ALT ) ',
				'select_as'=>'altGain',
				'sortBy'=>'altGain',
				'where_clause'=>'',
				'legend'=>_ALTITUDE_GAIN,	'header'=>_TOTAL_ALTITUDE_GAIN, 	'arrayName'=>"alt_gain",		'formatFunction'=>"formatAltitude"),

	);

	$leagueCategory=$_GET['comp']+0;
/*
  $query_count="SELECT count(DISTINCT userID) as itemNum FROM $flightsTable  WHERE (userID!=0 AND  private=0) ".$where_clause." ";
  $res= $db->sql_query( $query_count);
  // echo $query_count;
  if($res <= 0){   
	 echo("<H3> Error in count items query! $query_count</H3>\n");
     exit();
  }

  $row = $db->sql_fetchrow($res);
  
  $itemsNum=$row["itemNum"];   

  $startNum=($page_num-1)*$CONF_compItemsPerPage;
  $pagesNum=ceil ($itemsNum/$CONF_compItemsPerPage);
  $endNum=$startNum+$CONF_compItemsPerPage;
	
  $legendRight=generate_flights_pagination("?name=$module_name&op=competition$query_str", 
			$itemsNum,$CONF_compItemsPerPage,$page_num*$CONF_compItemsPerPage-1, TRUE); 
			

	if ($endNum>$itemsNum) $endNum=$itemsNum;
	$legendRight.=" [&nbsp;".($startNum+1)."-".$endNum."&nbsp;"._From."&nbsp;".$itemsNum ."&nbsp;]";
	if ($itemsNum==0) $legendRight="[ 0 ]";
*/

	$where_clause.=	 $leagueCategories[$leagueCategory]['where_clause'];
  $query = 'SELECT '.$flightsTable.'.ID, userID, '.$flightsTable.'.userServerID , 
  				 gliderBrandID,'.$flightsTable.'.glider as glider,cat, '.
				 $leagueCategories[$leagueCategory]['select_fields'].' as '.$leagueCategories[$leagueCategory]['select_as']
  		. ' FROM '.$flightsTable. $extra_table_str
        . ' WHERE (userID!=0 AND  private=0) '.$where_clause
        . ' ORDER BY  userID , userServerID, '.$leagueCategories[$leagueCategory]['sortBy'].' DESC ';
/*
  $query = 'SELECT '.$flightsTable.'.ID, userID, '.$flightsTable.'.userServerID , 
  				 gliderBrandID,'.$flightsTable.'.glider as glider,cat,
  				 MAX_ALT , TAKEOFF_ALT, DURATION , LINEAR_DISTANCE, FLIGHT_POINTS  , FLIGHT_KM, BEST_FLIGHT_TYPE  '
  		. ' FROM '.$flightsTable. $extra_table_str
        . ' WHERE (userID!=0 AND  private=0) '.$where_clause
        . ' ';
*/
   $res= $db->sql_query($query);
		// echo $query;
   if($res <= 0){
      echo("<H3> "._THERE_ARE_NO_PILOTS_TO_DISPLAY." $query </H3>\n");
      exit();
   }

   $i=1;
 /*  $duration=array();
   $triangleKm=array();
   $open_distance=array();
   $max_alt=array();
   $alt_gain=array();
   $olc_score=array();
   */
   $pilotNames=array();
   $pilotGliders=array();   
   $pilotGlidersMax=array();
   
	$arrayName= $leagueCategories[$leagueCategory]['arrayName'];
	${$arrayName}=array();

   while ($row = $db->sql_fetchrow($res)) { 
	 $uID=$row["userServerID"].'_'.$row["userID"];
	 $serverID=$row["userServerID"];

	 if (!isset($pilotNames[$uID])){
		 $name=getPilotRealName($row["userID"],$serverID,1); 
		 $name=prepare_for_js($name);
		 $pilotNames[$uID]=$name;
	 } 
	 
	 $brandID=guessBrandID($row['cat'],$row['glider']);
	 if ($brandID) {
		 if ( ! is_array($pilotGliders[$uID]) ) $pilotGliders[$uID]=array();
		 $pilotGliders[$uID][$brandID]++;
	 }

	 
	if ( ! is_array( ${$arrayName}[$uID] ) )  ${$arrayName}[$uID]=array();

	${$arrayName}[$uID][$row["ID"]]=$row[$leagueCategories[$leagueCategory]['select_as']];
/*
	 if  ( $row["BEST_FLIGHT_TYPE"] == "FAI_TRIANGLE" ) {
		if ( ! is_array ($triangleKm[$uID] ) )  $triangleKm[$uID]=array();
	 	$triangleKm[$uID][$row["ID"]]=$row["FLIGHT_KM"]; 
	}

	 if  (! is_array ($duration[$uID] )) $duration[$uID]=array();
	 $duration[$uID][$row["ID"]]=$row["DURATION"]; 
	 if  (! is_array ($open_distance[$uID] )) $open_distance[$uID]=array();
	 $open_distance[$uID][$row["ID"]]=$row["LINEAR_DISTANCE"];
	 if  (! is_array ($max_alt[$uID] )) $max_alt[$uID]=array();
	 $max_alt[$uID][$row["ID"]]=$row["MAX_ALT"];
	 $gain=$row["MAX_ALT"]- $row["TAKEOFF_ALT"];
	 if  (! is_array ($alt_gain[$uID] )) $alt_gain[$uID]=array();
	 $alt_gain[$uID][$row["ID"]]=$gain;
	 if  (! is_array ($olc_score[$uID] )) $olc_score[$uID]=array();
	 $olc_score[$uID][$row["ID"]]=$row["FLIGHT_POINTS"];
	 */
     $i++;
  } 

  // find the glider that was used most by each pilot
  foreach ( $pilotGliders as $pID=>$gliderArray) {
	  arsort($gliderArray);
	  $tmpArr=array_keys($gliderArray);
	  $pilotGlidersMax[$pID]= $tmpArr[0];
  }
	  // echo "#".$i."#";

  function cmp ($a1, $b1) { 
   $a=$a1["SUM"];
   $b=$b1["SUM"]; 
   if ($a == $b) { 
       return 0; 
   } 
   return ($a < $b) ? 1 : -1; 
  } 
  
  function sortArrayBest($arrayName,$countHowMany) {
	  global $$arrayName;
	
	  //get some stats now 
	  foreach (${$arrayName} as $pilotID=>$pilotArray) {
			// arsort($pilotArray);
			// arsort(${$arrayName}[$pilotID]);
			$i=0;
			$best3=0;
			foreach( $pilotArray as $element) {
				$best3+=$element;
				$i++;
				if ($i==$countHowMany &&  $countHowMany!=0) break;
			}
			${$arrayName}[$pilotID]["SUM"]=$best3;
			//echo "$".$best3;
	  }	  	
	  uasort(${$arrayName}, "cmp");
  }  

  $itemsNum=count(${$leagueCategories[$leagueCategory]['arrayName']});   

  $startNum=($page_num-1)*$CONF_compItemsPerPage;
  $pagesNum=ceil ($itemsNum/$CONF_compItemsPerPage);
  $endNum=$startNum+$CONF_compItemsPerPage;
	
  $legendRight=generate_flights_pagination("?name=$module_name&op=competition$query_str", 
			$itemsNum,$CONF_compItemsPerPage,$page_num*$CONF_compItemsPerPage-1, TRUE); 
			

	if ($endNum>$itemsNum) $endNum=$itemsNum;
	$legendRight.=" [&nbsp;".($startNum+1)."-".$endNum."&nbsp;"._From."&nbsp;".$itemsNum ."&nbsp;]";
	if ($itemsNum==0) $legendRight="[ 0 ]";

  echo  "<div class='tableTitle shadowBox'><div class='titleDiv'>$legend</div><div class='pagesDiv'>$legendRight</div></div>" ;
  require_once dirname(__FILE__)."/MENU_second_menu.php";
  
  $countHowMany= $CONF_countHowManyFlightsInComp;
  sortArrayBest($leagueCategories[$leagueCategory]['arrayName'],$countHowMany);
/*
  sortArrayBest("duration",$countHowMany);
  sortArrayBest("open_distance",$countHowMany);
  sortArrayBest("max_alt",$countHowMany);
  sortArrayBest("alt_gain",$countHowMany);
  sortArrayBest("olc_score",$countHowMany);
  sortArrayBest("triangleKm",$countHowMany); 
*/
?>
<script type="text/javascript" src="<?=$moduleRelPath ?>/js/tipster.js"></script>
<? echo makePilotPopup();  ?>

<? if (0) { ?>
<script type="text/javascript" src="<?=$moduleRelPath ?>/js/tabber.js"></script>
<link rel="stylesheet" href="<?=$themeRelPath ?>/tabber.css" TYPE="text/css" MEDIA="screen">
<link rel="stylesheet" href="<?=$themeRelPath ?>/tabber-print.css" TYPE="text/css" MEDIA="print">

<script type="text/javascript">

/* Optional: Temporarily hide the "tabber" class so it does not "flash"
   on the page as plain HTML. After tabber runs, the class is changed
   to "tabberlive" and it will appear. */

document.write('<style type="text/css">.tabber{display:none;}<\/style>');
</script>

<div class="tabber" id="compTabber">
<?
} else {
?>

<? 
	foreach($leagueCategories as $subcatID=>$subcatArray) {
		$subcatTitle=$subcatArray['legend'];			
		if ($subcatID==$leagueCategory) $style ="style='background-color:#E1E6F3;' ";
		else $style="";

		echo " <div class='menu1' $style ><a href='?name=$module_name&op=competition&comp=$subcatID'>$subcatTitle</a></div>";	
	}
	echo "<BR>";
}
  listCategory($leagueCategories[$leagueCategory]['legend'],$leagueCategories[$leagueCategory]['header'],
				$leagueCategories[$leagueCategory]['arrayName'],$leagueCategories[$leagueCategory]['formatFunction']);
/*
  listCategory(_OLC,				_OLC_TOTAL_SCORE,"olc_score","formatOLCScore");
  listCategory(_FAI_TRIANGLE, 		$FAI_TRIANGLE_str ,"triangleKm","formatDistance");   
  listCategory(_MENU_OPEN_DISTANCE,	$MENU_OPEN_DISTANCE_str,"open_distance","formatDistance");
  listCategory(_DURATION,			_TOTAL_DURATION,"duration","sec2Time"); 
  listCategory(_ALTITUDE_GAIN,		_TOTAL_ALTITUDE_GAIN,"alt_gain","formatAltitude"); 
*/
if (0) {
?>

</div>
<?	
}
function listCategory($legend,$header, $arrayName, $formatFunction="") {
   global $$arrayName;
   global $pilotNames,$pilotGlidersMax,$brandsList;
   
   global $Theme;
   global $module_name;
   global $moduleRelPath;

   global $CONF_compItemsPerPage;
   global $page_num,$pagesNum,$startNum,$itemsNum;
   global $op,$cat;

   global  $countHowMany;

   global    $tabID;
	
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
   	  foreach (${$arrayName} as $pilotID=>$pilotArray) {
	  	 if ($i< ( $startNum + 1) ) { $i++ ;  continue; }
		 if ($i>( $startNum  + $CONF_compItemsPerPage) ) break;
  		 // if ($i>$CONF_compItemsPerPage) break;


		 $sortRowClass=($i%2)?"l_row1":"l_row2"; 
 		 if ($i==1) $bg=" class='compFirstPlace'";
 		 else if ($i==2) $bg=" class='compSecondPlace'";
 		 else if ($i==3) $bg=" class='compThirdPlace'";
		 else $bg=" class='$sortRowClass'";
		 
	 	 $brandID=$pilotGlidersMax[$pilotID]+0;
		 $brandName=$brandsList[$cat][$brandID];
		 $gliderBrandImg="<img src='$moduleRelPath/img/brands/$cat/".sprintf("%03d",$brandID).".gif' alt='$brandName' title='$brandName' border=0 align=abs_middle>";
//		 if ($brandID) 
//		 else $gliderBrandImg="&nbsp;";
		 	     
	     
		 echo "<TR $bg>";
		 echo "<TD>".($i)."</TD>"; 	
	     echo "<TD nowrap><div align=left id='$arrayName"."_$i'>".		 
				"<a href=\"javascript:pilotTip.newTip('inline', 0, 13, '$arrayName"."_$i', 200, '".$pilotID."','".
					addslashes($pilotNames[$pilotID])."' )\"  onmouseout=\"pilotTip.hide()\">".$pilotNames[$pilotID]."</a>".
				"</div></TD>";
		 if ($formatFunction) $outVal=$formatFunction($pilotArray["SUM"]);
		 else $outVal=$pilotArray["SUM"];
   	     echo "<TD>".$outVal."</TD>"; 	 
		 $pilotArray["SUM"]=0;
		 
		 $i++;
		
		$k=0;
		foreach ($pilotArray as $flightID=>$val) {
			if (!$val)  $outVal="-";
			else if ($formatFunction) $outVal=$formatFunction($val);
			else $outVal=$val;

			if ($val) echo "<TD><a href='?name=$module_name&op=show_flight&flightID=".$flightID."'>".$outVal."</a></TD>"; 	 		  
			else echo "<TD>".$outVal."</TD>"; 	 		  
			$k++;
			if ($k>=$countHowMany) break;
		}

		if ($k!=$countHowMany) {
			for($j=$k;$j<$countHowMany;$j++) {
				echo "<TD>-</TD>"; 	 		  
			}
		}

		echo "<td align='center'>$gliderBrandImg</td>";
   	}	

	echo "</table>"; 
	echo '</div>';
} //end function

?>
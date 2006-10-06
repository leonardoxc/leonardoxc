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


  $sortOrder=$_REQUEST["sortOrder"];
  if ( $sortOrder=="")  $sortOrder="bestOlcScore";

  $legend=_LEAGUE_RESULTS." ";

  if ($cat==0) $cat=1;
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

  $row = mysql_fetch_assoc($res);
  $itemsNum=$row["itemNum"];   

  $startNum=($page_num-1)*$CONF_compItemsPerPage;
  $pagesNum=ceil ($itemsNum/$CONF_compItemsPerPage);

  if ($country) {
		$where_clause.=" AND $waypointsTable.countryCode='".$country."' ";
		$where_clause.=" AND $flightsTable.takeoffID=$waypointsTable.ID ";
		$extra_table_str=",".$waypointsTable;
  } else $extra_table_str="";

  if ($clubID)   {
	 $areaID=$clubsList[$clubID]['areaID'];
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
  } 

//  echo "<table  class=main_text border=0 width=650 bgcolor=#EAF0E4><tr><td><div align=left><b> $legend </b></div></td></tr></table><br>";
  
  echo  "<div class='tableTitle shadowBox'><div class='titleDiv'>$legend</div></div>" ;
  

  $query = 'SELECT '.$flightsTable.'.ID, userID, username,  MAX_ALT , TAKEOFF_ALT, DURATION , LINEAR_DISTANCE, FLIGHT_POINTS  , FLIGHT_KM, BEST_FLIGHT_TYPE  '
  		. ' FROM '.$flightsTable.', '.$prefix.'_users' . $extra_table_str
        . ' WHERE (userID!=0 AND  private=0) AND '.$flightsTable.'.userID = '.$prefix.'_users.user_id '.$where_clause
        . ' ';

   $res= $db->sql_query($query);
		
   if($res <= 0){
      echo("<H3> "._THERE_ARE_NO_PILOTS_TO_DISPLAY."</H3>\n");
      exit();
   }

   $i=1;
   $duration=array();
   $triangleKm=array();
   $open_distance=array();
   $max_alt=array();
   $alt_gain=array();
   $olc_score=array();
   
   $pilotNames=array();
   
   while ($row = mysql_fetch_assoc($res)) { 

     $name=getPilotRealName($row["userID"],1); 
	 $name=prepare_for_js($name);
	 $pilotNames[$row["userID"]]=$name;


	 if  ( $row["BEST_FLIGHT_TYPE"] == "FAI_TRIANGLE" ) {
		if ( ! is_array ($triangleKm[$row["userID"]] ) )  $triangleKm[$row["userID"]]=array();
	 	$triangleKm[$row["userID"]][$row["ID"]]=$row["FLIGHT_KM"]; 
	}

	 if  (! is_array ($duration[$row["userID"]] )) $duration[$row["userID"]]=array();
	 $duration[$row["userID"]][$row["ID"]]=$row["DURATION"]; 
	 if  (! is_array ($open_distance[$row["userID"]] )) $open_distance[$row["userID"]]=array();
	 $open_distance[$row["userID"]][$row["ID"]]=$row["LINEAR_DISTANCE"];
	 if  (! is_array ($max_alt[$row["userID"]] )) $max_alt[$row["userID"]]=array();
	 $max_alt[$row["userID"]][$row["ID"]]=$row["MAX_ALT"];
	 $gain=$row["MAX_ALT"]- $row["TAKEOFF_ALT"];
	 if  (! is_array ($alt_gain[$row["userID"]] )) $alt_gain[$row["userID"]]=array();
	 $alt_gain[$row["userID"]][$row["ID"]]=$gain;
	 if  (! is_array ($olc_score[$row["userID"]] )) $olc_score[$row["userID"]]=array();
	 $olc_score[$row["userID"]][$row["ID"]]=$row["FLIGHT_POINTS"];
	 
     $i++;
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
			arsort($pilotArray);
			arsort(${$arrayName}[$pilotID]);
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
  
  $countHowMany= $CONF_countHowManyFlightsInComp;
  sortArrayBest("duration",$countHowMany);
  sortArrayBest("open_distance",$countHowMany);
  sortArrayBest("max_alt",$countHowMany);
  sortArrayBest("alt_gain",$countHowMany);
  sortArrayBest("olc_score",$countHowMany);
  sortArrayBest("triangleKm",$countHowMany); 
?>
<script type="text/javascript" src="<?=$moduleRelPath ?>/tabber.js"></script>
<link rel="stylesheet" href="<?=$moduleRelPath ?>/example.css" TYPE="text/css" MEDIA="screen">
<link rel="stylesheet" href="<?=$moduleRelPath ?>/example-print.css" TYPE="text/css" MEDIA="print">

<script type="text/javascript">

/* Optional: Temporarily hide the "tabber" class so it does not "flash"
   on the page as plain HTML. After tabber runs, the class is changed
   to "tabberlive" and it will appear. */

document.write('<style type="text/css">.tabber{display:none;}<\/style>');
</script>
<script type="text/javascript" src="<?=$moduleRelPath ?>/tipster.js"></script>
<? echo makePilotPopup();  ?>
<div class="tabber" id="compTabber">
<?
  listCategory(_OLC,			_OLC_TOTAL_SCORE,"olc_score","formatOLCScore");
  listCategory(_FAI_TRIANGLE,	_KILOMETERS,"triangleKm","formatDistance");   
  listCategory(_MENU_OPEN_DISTANCE,_TOTAL_KM,"open_distance","formatDistance");
  listCategory(_DURATION,		_TOTAL_DURATION,"duration","sec2Time"); 
  listCategory(_ALTITUDE_GAIN,	_TOTAL_ALTITUDE_GAIN,"alt_gain","formatAltitude"); 
?>
</div>
<?	
function listCategory($legend,$header, $arrayName, $formatFunction="") {
   global $$arrayName;
   global $pilotNames;
   
   global $Theme;
   global $module_name;
   global $moduleRelPath;

   global $CONF_compItemsPerPage;
   global $page_num,$pagesNum,$startNum,$itemsNum;
   global $op;

   global  $countHowMany;

   global    $tabID;
	
   $legendRight=""; // show all pilots up to  $CONF_compItemsPerPage
   if ($tabID ==  ($_GET['comp']+0) ) $defaultTabStr=" tabbertabdefault";
   else  $defaultTabStr="";
   
   $tabID++;
   echo "<div class='tabbertab $defaultTabStr' title='$legend'>";
   
   $legend.=" (".$countHowMany." "._N_BEST_FLIGHTS.")";
   echo "<br><table class='listTable' width='100%' cellpadding='2' cellspacing='0'>
   			<tr><td class='tableTitleExtra' colspan='".($countHowMany+3)."'>$legend</td></tr>";
   
   ?>
   <tr>
   <td class="SortHeader" width="30"><? echo _NUM ?></td>
   <td class="SortHeader"><div align=left><? echo _PILOT ?></div></td>
   <td class="SortHeader" width="100"><? echo $header ?></td>
   <? for ($ii=1;$ii<=$countHowMany;$ii++) { ?>
   <td class="SortHeader" width="55">#<? echo $ii?></td>
   <? }

	  $i=1;
   	  foreach (${$arrayName} as $pilotID=>$pilotArray) {
  		 if ($i>$CONF_compItemsPerPage) break;


		 $sortRowClass=($i%2)?"l_row1":"l_row2"; 
		 if ($i==1) $bg=" bgcolor=#F5D523 ";
 		 else if ($i==2) $bg=" bgcolor=#F5F073 ";
 		 else if ($i==3) $bg=" bgcolor=#F3F0A5 ";

 		 if ($i==1) $bg=" class='compFirstPlace'";
 		 else if ($i==2) $bg=" class='compSecondPlace'";
 		 else if ($i==3) $bg=" class='compThirdPlace'";

		 else $bg=" class='$sortRowClass'";
		 
	     
	     $i++;
		 echo "<TR $bg>";
		 echo "<TD>".($i-1+$startNum)."</TD>"; 	
	     echo "<TD nowrap><div align=left>".
				"<a href='javascript:nop()' onclick=\"pilotTip.newTip('inline', 0, 0, 200, '".$pilotID."','".
					str_replace("'","\'",$pilotNames[$pilotID])."' )\"  onmouseout=\"pilotTip.hide()\">".$pilotNames[$pilotID]."</a>".
				"</div></TD>";
		 if ($formatFunction) $outVal=$formatFunction($pilotArray["SUM"]);
		 else $outVal=$pilotArray["SUM"];
   	     echo "<TD>".$outVal."</TD>"; 	 
		 $pilotArray["SUM"]=0;

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

   	}	
	echo "</tr></td></table>"; 
	echo '</div>';
} //end function

?>
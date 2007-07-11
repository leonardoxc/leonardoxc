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

 $sortOrder=makeSane($_REQUEST["sortOrder"]);
 if ( $sortOrder=="")  $sortOrder="bestOlcScore";

 $is_comp=$comp;

 if ($cat==0 && $is_comp) {  
	 if ( $clubID && is_array($clubsList[$clubID]['gliderCat']) ) {	
		$cat=$clubsList[$clubID]['gliderCat'][0];
	 } else $cat=1;
 }
 
 if ($cat==0) $where_clause.="";
 else $where_clause.=" AND cat=$cat ";

 $page_num=$_REQUEST["page_num"]+0;
 if ($page_num==0)  $page_num=1;
 
  $legend="";
  if ($year && !$month) {
		$where_clause.=" AND DATE_FORMAT(DATE,'%Y') = ".$year." ";
		//$legend.=" <b>[ ".$year." ]</b> ";
  }
  if ($year && $month) {
		$where_clause.=" AND DATE_FORMAT(DATE,'%Y%m') = ".sprintf("%04d%02d",$year,$month)." ";
		//$legend.=" <b>[ ".$monthList[$month-1]." ".$year." ]</b> ";
  }
  if (! $year ) {
	//$legend.=" <b>[ "._ALL_TIMES." ]</b> ";
  }
  
  if ($country) {
		$where_clause_country.=" AND  $waypointsTable.countryCode='".$country."' ";
			
  }


  if ($clubID)   {
	 require dirname(__FILE__)."/INC_club_where_clause.php";
	/* $areaID=$clubsList[$clubID]['areaID'];
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

  
 if (!$is_comp) {
	
	 $filter_clause=$_SESSION["filter_clause"];
	  if ( strpos($filter_clause,"countryCode")=== false )  $countryCodeQuery=0;	
	  else $countryCodeQuery=1;
	  $where_clause.=$filter_clause;	
		 
	 $sortDescArray=array("pilotName"=>_PILOT_NAME, "totalFlights"=>_NUMBER_OF_FLIGHTS, "totalDistance"=>_TOTAL_DISTANCE, 
					 "totalDuration"=>_TOTAL_DURATION, "bestDistance"=>_BEST_OPEN_DISTANCE, 
					 "totalOlcKm"=>_TOTAL_OLC_DISTANCE, "totalOlcPoints"=>_TOTAL_OLC_SCORE, "bestOlcScore"=>_BEST_OLC_SCORE, 
					 "mean_duration"=>_MEAN_DURATION, "mean_distance"=>_MEAN_DISTANCE );
	 
	 $sortDesc=$sortDescArray[ $sortOrder];
	 $ord="DESC";
	
	 $sortOrderFinal=$sortOrder;
	 if ($sortOrder=="pilotName") { 
		if ($opMode==1) $sortOrderFinal="CONCAT(name,username) ";
		else $sortOrderFinal="username";
  	    $ord="ASC";
	 }
	 $legend.=_PILOT_STATISTICS_SORT_BY." \"".$sortDesc."\"";
 } else { // comp
 	 $sortDescArray=array("pilotName"=>_PILOT_NAME, "totalFlights"=>_CATEGORY_FLIGHT_NUMBER, "totalDistance"=>_TOTAL_DISTANCE, 
			     "totalDuration"=>_CATEGORY_TOTAL_DURATION, "bestDistance"=>_CATEGORY_OPEN_DISTANCE, 
			     "totalOlcKm"=>_TOTAL_OLC_DISTANCE, "totalOlcPoints"=>_TOTAL_OLC_SCORE, "bestOlcScore"=>_BEST_OLC_SCORE, 
				 "mean_duration"=>_MEAN_DURATION, "mean_distance"=>_MEAN_DISTANCE );
 
	 
	 $sortDesc=$sortDescArray[ $sortOrder];
	 $ord="DESC";
	
	 $sortOrderFinal=$sortOrder;
	 $legend.=$sortDesc;
 }

  $query_str="";
  $query_str.="&comp=".$is_comp;


  if (! $pilotTableQuery ) { // we have NOT already put the pilot table in -> do it now 
  	$extra_table_str.=", $pilotsTable ";
	$where_clause.=" AND ".$pilotsTable.".pilotID=$flightsTable.userID";
  }
  $where_clause.=$where_clause_country;
   
 $query="SELECT count(DISTINCT userID) as itemNum FROM $flightsTable".$extra_table_str."  WHERE (userID!=0 AND  private=0) ".$where_clause." ";
 $res= $db->sql_query($query);
  if($res <= 0){   
	 echo("<H3> Error in count items query! $query</H3>\n");
     exit();
  }

  $row = $db->sql_fetchrow($res);
  $itemsNum=$row["itemNum"];   

  $startNum=($page_num-1)*$PREFS->itemsPerPage;
  $pagesNum=ceil ($itemsNum/$PREFS->itemsPerPage);


 if ($CONF_use_leonardo_names)  {
 	if ($PREFS->nameOrder==1) $nOrder="CONCAT(FirstName,' ',LastName)";
	else $nOrder="CONCAT(LastName,' ',FirstName)";
 $query = 'SELECT DISTINCT CONCAT(  '.$flightsTable.'.userServerID ,userID  ) , userID,
		  '.$flightsTable.'.userServerID, '.$nOrder.' as username,  '.$pilotsTable.'.countryCode , max( LINEAR_DISTANCE ) AS bestDistance,'
		. ' count( * ) AS totalFlights, sum( LINEAR_DISTANCE ) AS totalDistance, sum( DURATION ) AS totalDuration, '
		. ' sum( LINEAR_DISTANCE )/count( * ) as mean_distance, '
		. ' sum( DURATION )/count( * ) as mean_duration, '
		. ' sum( FLIGHT_KM ) as totalOlcKm, '
		. ' sum( FLIGHT_POINTS ) as totalOlcPoints, '
		. ' max( FLIGHT_POINTS ) as bestOlcScore '
        . ' FROM  '.$flightsTable.' ' .$extra_table_str
        . ' WHERE private=0  AND '.$pilotsTable.'.serverID= '.$flightsTable.'.userServerID '.$where_clause
        . ' GROUP BY '.$flightsTable.'.userServerID , userID '
        . ' ORDER BY '.$sortOrderFinal .' '.$ord.' LIMIT '.$startNum.','.$PREFS->itemsPerPage.' ';
} else { // default
 $query = 'SELECT DISTINCT CONCAT( '.$flightsTable.'.userServerID , userID ) , userID,  '.$flightsTable.'.userServerID,  '.$pilotsTable.'.countryCode , max( LINEAR_DISTANCE ) AS bestDistance,'
		. ' count( * ) AS totalFlights, sum( LINEAR_DISTANCE ) AS totalDistance, sum( DURATION ) AS totalDuration, '
		. ' sum( LINEAR_DISTANCE )/count( * ) as mean_distance, '
		. ' sum( DURATION )/count( * ) as mean_duration, '
		. ' sum( FLIGHT_KM ) as totalOlcKm, '
		. ' sum( FLIGHT_POINTS ) as totalOlcPoints, '
		. ' max( FLIGHT_POINTS ) as bestOlcScore '
        . ' FROM  '.$flightsTable.', '.$prefix.'_users' .$extra_table_str
        . ' WHERE private=0  AND '.$pilotsTable.'.serverID= '.$flightsTable.'.userServerID AND '.$flightsTable.'.userID = '.$prefix.'_users.user_id '.$where_clause
        . ' GROUP BY '.$flightsTable.'.userServerID , userID  '
        . ' ORDER BY '.$sortOrderFinal .' '.$ord.' LIMIT '.$startNum.','.$PREFS->itemsPerPage.' ';
}	
	$res= $db->sql_query($query);
		// echo $query;
    if($res <= 0){
      echo("<H3>"._THERE_ARE_NO_PILOTS_TO_DISPLAY."</H3>\n");
      exit();
    }
?>
<script type="text/javascript" src="<?=$moduleRelPath ?>/js/tipster.js"></script>
<? echo makePilotPopup() ?>

<?

	$legendRight=generate_flights_pagination("?name=$module_name&op=$op&sortOrder=$sortOrder$query_str", 
											 $itemsNum,$PREFS->itemsPerPage,$page_num*$PREFS->itemsPerPage-1, TRUE); 

	$endNum=$startNum+$PREFS->itemsPerPage;
	if ($endNum>$itemsNum) $endNum=$itemsNum;
	$legendRight.=" [&nbsp;".($startNum+1)."-".$endNum."&nbsp;"._From."&nbsp;".$itemsNum ."&nbsp;]";
	if ($itemsNum==0) $legendRight="[ 0 ]";

   echo  "<div class='tableTitle shadowBox'>
   <div class='titleDiv'>$legend</div>
   <div class='pagesDiv'>$legendRight</div>
   </div>" ;
	require_once dirname(__FILE__)."/MENU_second_menu.php";

    listPilots($res,$legend,$query_str,$sortOrder,$is_comp);

function printHeaderPilotsTotals($width,$sortOrder,$fieldName,$fieldDesc,$query_str,$is_comp) {
	global $moduleRelPath;
	global $Theme,$module_name;
	
	if ($width==0) $widthStr="";
    else  $widthStr="width='".$width."'";
  
	$cList="SortHeader";   
	$img="";
	if ($sortOrder==$fieldName) {
		$cList.=" activeSortHeader";
		$img="<img src='$moduleRelPath/img/icon_arrow_down.png' border=0>";
	}
	if ($fieldName=="pilotName") { 
		$cList.=" alLeft";
		$align="left";
	} else  {
		$cList.=" alRight";
		$align="right";
	}
	
	if ($is_comp) {
		echo "<td $widthStr align=$align class='$cList'><div align=$align>$fieldDesc$img</div></td>";
	} else {
		echo "<td $widthStr align=$align class='$cList'><a href='?name=$module_name&op=list_pilots&sortOrder=$fieldName$query_str'>$fieldDesc$img</a></td>";
	}
}

function listPilots($res,$legend,$query_str="",$sortOrder="bestDistance",$is_comp=0) {
   global $db,$Theme;
   global $module_name;
   global $moduleRelPath;
   global $PREFS;
   global $page_num,$pagesNum,$startNum,$itemsNum;
   global $op,$opMode;

   global $currentlang,$nativeLanguage;

   
   ?>
    <table class='listTable' width="100%"  cellpadding="2" cellspacing="0">
	<tr> 
		<td width="25" class='SortHeader'><? echo _NUM ?></td>
   <?
	// was _TOTAL_KM -> bug
	if ($PREFS->metricSystem==1) {
		$OPEN_DISTANCE_str=_TOTAL_DISTANCE." "._KM;
	} else  {
		$OPEN_DISTANCE_str=_TOTAL_DISTANCE." "._MI;
	}
   printHeaderPilotsTotals(0,$sortOrder,"pilotName",_PILOT,$query_str,$is_comp);
   printHeaderPilotsTotals(60,$sortOrder,"totalFlights",_NUMBER_OF_FLIGHTS,$query_str,$is_comp);
   printHeaderPilotsTotals(80,$sortOrder,"bestDistance",_BEST_DISTANCE,$query_str,$is_comp);
   if (!is_comp) printHeaderPilotsTotals(60,$sortOrder,"mean_distance",_MEAN_KM,$query_str,$is_comp);
   printHeaderPilotsTotals(80,$sortOrder,"totalDistance",$OPEN_DISTANCE_str,$query_str,$is_comp);
   printHeaderPilotsTotals(80,$sortOrder,"totalDuration",_TOTAL_DURATION_OF_FLIGHTS,$query_str,$is_comp);
   if (!is_comp) printHeaderPilotsTotals(60,$sortOrder,"mean_duration",_MEAN_DURATION,$query_str,$is_comp);
   if (!is_comp) printHeaderPilotsTotals(60,$sortOrder,"totalOlcKm",_TOTAL_OLC_KM,$query_str,$is_comp);
   printHeaderPilotsTotals(60,$sortOrder,"totalOlcPoints",_TOTAL_OLC_SCORE,$query_str,$is_comp);
   printHeaderPilotsTotals(60,$sortOrder,"bestOlcScore",_BEST_OLC_SCORE,$query_str,$is_comp);
   echo "</tr>";
   
   $i=1;
   while ($row = $db->sql_fetchrow($res)) { 

    $name=getPilotRealName($row["userID"],$row["userServerID"]);
    $name=prepare_for_js($name);

	$mean_duration=$row["totalDuration"]/$row["totalFlights"];
	$mean_distance=$row["totalDistance"]/$row["totalFlights"];

	$sortRowClass=($i%2)?"l_row1":"l_row2"; 
    $i++;

	echo "\n\n<tr class='$sortRowClass'>";
	echo "<TD>".($i-1+$startNum)."</TD>";
	echo "<TD><div align=left id='p_$i'>";

	echo getNationalityDescription($row["countryCode"],1,0);
	echo "<a href=\"javascript:pilotTip.newTip('inline',0,13, 'p_$i', 200,'".$row["userServerID"]."_".$row["userID"]."','".addslashes($name)."' )\"  
		 onmouseout=\"pilotTip.hide()\">$name</a></div></TD>";
			
	 echo "<TD>".$row["totalFlights"]."</TD>". 	 
 	      "<TD>".formatDistanceOpen($row["bestDistance"])."</TD>";
  	 if (!is_comp) echo " <TD>".formatDistanceOpen($mean_distance)."</TD>";
     echo "<TD>".formatDistanceOpen($row["totalDistance"])."</TD>".
   	      "<TD>".sec2Time($row["totalDuration"])."</TD>";
     if (!is_comp) echo "<TD>".sec2Time($mean_duration)."</TD>";
	 if (!is_comp) echo "<TD>".formatDistanceOLC($row["totalOlcKm"])."</TD>";
     echo "<TD>".formatOLCScore($row["totalOlcPoints"])."</TD>".
          "<TD>".formatOLCScore($row["bestOlcScore"])."</TD>";	 							   			   
  	 echo "</TR>";
   }     

   echo "</table>";
   $db->sql_freeresult($res);
}


?>

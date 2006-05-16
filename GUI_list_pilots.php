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

 $is_comp=$comp;

 if ($cat==0 && $is_comp) $cat=1;
 if ($cat==0) $where_clause="";
 else $where_clause=" AND cat=$cat ";

 $page_num=$_REQUEST["page_num"]+0;
 if ($page_num==0)  $page_num=1;
 
  $legend="";
  if ($year && !$month) {
		$where_clause.=" AND DATE_FORMAT(DATE,'%Y') = ".$year." ";
		//$legend.=" <b>[ ".$year." ]</b> ";
  }
  if ($year && $month) {
		$where_clause.=" AND DATE_FORMAT(DATE,'%Y%m') = ".$year.$month." ";
		//$legend.=" <b>[ ".$monthList[$month-1]." ".$year." ]</b> ";
  }
  if (! $year ) {
	//$legend.=" <b>[ "._ALL_TIMES." ]</b> ";
  }
  
  if ($country) {
		$where_clause.=" AND  countryCode='".$country."' ";
		// if ($sortOrder!="dateAdded") $legend.=" (".$countries[$country].") | ";				
  }

  if ($countryCodeQuery || $country)   {
		 $where_clause.=" AND $flightsTable.takeoffID=$waypointsTable.ID ";
		 $extra_table_str=",".$waypointsTable;
  } else $extra_table_str="";

  if ($clubID)   {
	 $where_clause.=" AND $flightsTable.userID=$clubsPilotsTable.pilotID AND $clubsPilotsTable.clubID=$clubID  ";
	 $extra_table_str.=",".$clubsPilotsTable;
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


 $query="SELECT count(DISTINCT userID) as itemNum FROM $flightsTable".$extra_table_str."  WHERE (userID!=0 AND  private=0) ".$where_clause." ";
 $res= $db->sql_query($query);
  if($res <= 0){   
	 echo("<H3> Error in count items query! $query</H3>\n");
     exit();
  }

  $row = mysql_fetch_assoc($res);
  $itemsNum=$row["itemNum"];   

  $startNum=($page_num-1)*$PREFS->itemsPerPage;
  $pagesNum=ceil ($itemsNum/$PREFS->itemsPerPage);

 $query = 'SELECT DISTINCT userID, username,  max( LINEAR_DISTANCE ) AS bestDistance,'
		. ' count( * ) AS totalFlights, sum( LINEAR_DISTANCE ) AS totalDistance, sum( DURATION ) AS totalDuration, '
		. ' sum( LINEAR_DISTANCE )/count( * ) as mean_distance, '
		. ' sum( DURATION )/count( * ) as mean_duration, '
		. ' sum( FLIGHT_KM ) as totalOlcKm, '
		. ' sum( FLIGHT_POINTS ) as totalOlcPoints, '
		. ' max( FLIGHT_POINTS ) as bestOlcScore '
        . ' FROM '.$flightsTable.', '.$prefix.'_users' .$extra_table_str
        . ' WHERE private=0 AND '.$flightsTable.'.userID = '.$prefix.'_users.user_id '.$where_clause
        . ' GROUP BY userID'
        . ' ORDER BY '.$sortOrderFinal .' '.$ord.' LIMIT '.$startNum.','.$PREFS->itemsPerPage.' ';
	
	$res= $db->sql_query($query);
		
    if($res <= 0){
      echo("<H3>"._THERE_ARE_NO_PILOTS_TO_DISPLAY."</H3>\n");
      exit();
    }

    listPilots($res,$legend,$query_str,$sortOrder,$is_comp);

function printHeaderPilotsTotals($width,$headerSelectedBgColor,$headerUnselectedBgColor,$sortOrder,$fieldName,$fieldDesc,$query_str,$is_comp) {
  global $moduleRelPath;
  global $Theme,$module_name;
  if ($is_comp) {
	  if ($sortOrder==$fieldName) { 
	   echo "<td width='$width' bgcolor='$headerSelectedBgColor'>
			<div class='whiteLetter' align=left>$fieldDesc<img src='$moduleRelPath/img/icon_arrow_down.png' border=0></div></td>";
	  } else {  
	   echo "<td width='$width' bgcolor='$headerUnselectedBgColor'>
			<div align=left>$fieldDesc</div></td>";
	   } 
  } else {
	  if ($sortOrder==$fieldName) { 
	   echo "<td width='$width' bgcolor='$headerSelectedBgColor'>
			<div class='whiteLetter' align=left>
			<a href='?name=$module_name&op=list_pilots&sortOrder=$fieldName$query_str'>$fieldDesc<img src='$moduleRelPath/img/icon_arrow_down.png' border=0></a></div></td>";
	  } else {  
	   echo "<td width='$width' bgcolor='$headerUnselectedBgColor'>
			<div align=left>
			<a href='?name=$module_name&op=list_pilots&sortOrder=$fieldName$query_str'>$fieldDesc</a></div></td>";
	   } 
  }
}

function listPilots($res,$legend,$query_str="",$sortOrder="bestDistance",$is_comp=0) {
   global $Theme;
   global $module_name;
   global $moduleRelPath;
   global $PREFS;
   global $page_num,$pagesNum,$startNum,$itemsNum;
   global $op,$opMode;

   global $currentlang,$nativeLanguage;

   $legendRight="";   
   if ($pagesNum>1) {
	 if  ($page_num>1 ) 
		 $legendRight.="<a href='?name=$module_name&op=$op&sortOrder=$sortOrder$query_str&page_num=".($page_num-1)."'><<</a>&nbsp;";
	 else $legendRight.="<<&nbsp;";
   
   for ($k=1;$k<=$pagesNum;$k++) {
		 if  ($k!=$page_num) 
			 $legendRight.="<a href='?name=$module_name&op=$op&sortOrder=$sortOrder$query_str&page_num=$k'>$k</a>&nbsp;";
	 	 else  $legendRight.="$k&nbsp;";

   } 
	 if  ($page_num<$pagesNum) 
		 $legendRight.="<a href='?name=$module_name&op=$op&sortOrder=$sortOrder$query_str&page_num=".($page_num+1)."'>>></a>&nbsp;";
	 else $legendRight.=">>&nbsp;";

   }
	 $endNum=$startNum+$PREFS->itemsPerPage;
	 if ($endNum>$itemsNum) $endNum=$itemsNum;
	 $legendRight.=" [ ".($startNum+1)."-".$endNum." "._from." ".$itemsNum ." ]";
   
   open_inner_table("<table class=main_text width=100%><tr><td>$legend</td><td width=300 align=right bgcolor=#eeeeee>$legendRight</td></tr></table>",750);

   $headerSelectedBgColor="#F2BC66";
   ?>
   <td width="25" bgcolor="<?=$Theme->color1?>"><div align=left><? echo _NUM ?></div></td>
   <?
   printHeaderPilotsTotals(190,$headerSelectedBgColor,$Theme->color0,$sortOrder,"pilotName",_PILOT,$query_str,$is_comp);
   printHeaderPilotsTotals(60,$headerSelectedBgColor,$Theme->color1,$sortOrder,"totalFlights",_NUMBER_OF_FLIGHTS,$query_str,$is_comp);
   printHeaderPilotsTotals(60,$headerSelectedBgColor,$Theme->color2,$sortOrder,"bestDistance",_BEST_DISTANCE,$query_str,$is_comp);
   if (!is_comp) printHeaderPilotsTotals(60,$headerSelectedBgColor,$Theme->color2,$sortOrder,"mean_distance",_MEAN_KM,$query_str,$is_comp);
   printHeaderPilotsTotals(60,$headerSelectedBgColor,$Theme->color2,$sortOrder,"totalDistance",_TOTAL_KM,$query_str,$is_comp);
   printHeaderPilotsTotals(60,$headerSelectedBgColor,$Theme->color3,$sortOrder,"totalDuration",_TOTAL_DURATION_OF_FLIGHTS,$query_str,$is_comp);
   if (!is_comp) printHeaderPilotsTotals(60,$headerSelectedBgColor,$Theme->color3,$sortOrder,"mean_duration",_MEAN_DURATION,$query_str,$is_comp);

   if (!is_comp) printHeaderPilotsTotals(60,$headerSelectedBgColor,$Theme->color5,$sortOrder,"totalOlcKm",_TOTAL_OLC_KM,$query_str,$is_comp);
   printHeaderPilotsTotals(60,$headerSelectedBgColor,$Theme->color5,$sortOrder,"totalOlcPoints",_TOTAL_OLC_SCORE,$query_str,$is_comp);
   printHeaderPilotsTotals(60,$headerSelectedBgColor,$Theme->color5,$sortOrder,"bestOlcScore",_BEST_OLC_SCORE,$query_str,$is_comp);

   $i=1;
   while ($row = mysql_fetch_assoc($res)) { 

    $name=getPilotRealName($row["userID"]);

	$mean_duration=$row["totalDuration"]/$row["totalFlights"];
	$mean_distance=$row["totalDistance"]/$row["totalFlights"];

    $sortRowBgColor=($i%2)?"#CCCACA":"#E7E9ED"; 
    $i++;

	 open_tr();
	   echo "  <TD><div align=left>".($i-1+$startNum)."</div></TD> 	   
		       <TD ".(($sortOrder=="pilotName")?"bgcolor=".$sortRowBgColor:"").">".
			"<div align=left>".
			"<a href='?name=$module_name&op=pilot_profile&pilotIDview=".$row["userID"]."'><img src='".$moduleRelPath."/img/icon_magnify_small.gif' border=0></a>". 	   
			"<a href='?name=$module_name&op=pilot_profile_stats&pilotIDview=".$row["userID"]."'><img src='".$moduleRelPath."/img/icon_stats.gif' border=0></a> ".
			"<a href='?name=$module_name&op=list_flights&pilotID=".$row["userID"]."'>$name</a>".
			"</div></TD>". 	   			   			   
   	           "<TD ".(($sortOrder=="totalFlights")?"bgcolor=".$sortRowBgColor:"")."><div align=right>".$row["totalFlights"]."</div></TD> 	 
 		       <TD ".(($sortOrder=="bestDistance")?"bgcolor=".$sortRowBgColor:"")."><div align=right>".formatDistanceOpen($row["bestDistance"])."</div></TD> ";
  	   if (!is_comp) echo "  <TD ".(($sortOrder=="mean_distance")?"bgcolor=".$sortRowBgColor:"")."><div align=right>".formatDistanceOpen($mean_distance)."</div></TD> 	";
   	   echo "  <TD ".(($sortOrder=="totalDistance")?"bgcolor=".$sortRowBgColor:"")."><div align=right>".formatDistanceOpen($row["totalDistance"])."</div></TD>
   	           <TD ".(($sortOrder=="totalDuration")?"bgcolor=".$sortRowBgColor:"")."><div align=right>".sec2Time($row["totalDuration"])."</div></TD>";
   	   if (!is_comp) echo "  <TD ".(($sortOrder=="mean_duration")?"bgcolor=".$sortRowBgColor:"")."><div align=right>".sec2Time($mean_duration)."</div></TD>";
	   if (!is_comp) echo "  <TD ".(($sortOrder=="totalOlcKm")?"bgcolor=".$sortRowBgColor:"")."><div align=right>".formatDistanceOLC($row["totalOlcKm"])."</div></TD>";
       echo "  <TD ".(($sortOrder=="totalOlcPoints")?"bgcolor=".$sortRowBgColor:"")."><div align=right>".formatOLCScore($row["totalOlcPoints"])."</div></TD> 	
               <TD ".(($sortOrder=="bestOlcScore")?"bgcolor=".$sortRowBgColor:"")."><div align=right>".formatOLCScore($row["bestOlcScore"])."</div></TD> 	
   	          ";	 							   			   
  	 close_tr();
   }     
   close_inner_table();       
   mysql_freeResult($res);
}


?>

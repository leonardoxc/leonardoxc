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
//************************************************************************/

 
  $sortOrder=$_REQUEST["sortOrder"];
  if ( $sortOrder=="")  $sortOrder="CountryCode";

  $page_num=$_REQUEST["page_num"]+0;
  if ($page_num==0)  $page_num=1;

  if ($cat==0) $where_clause="";
  else $where_clause=" AND cat=$cat ";

  $query_str="";
  $legend=_MENU_TAKEOFFS;
  if ($year && !$month ) {
		$where_clause.=" AND DATE_FORMAT(DATE,'%Y') = ".$year." ";
		//$legend.=" <b>[ ".$year." ]</b> ";
//		$query_str.="&year=".$year;
  }
  if ($year && $month ) {
		$where_clause.=" AND DATE_FORMAT(DATE,'%Y%m') = ".$year.$month." ";
		//$legend.=" <b>[ ".$monthList[$month-1]." ".$year." ]</b> ";
//		$query_str.="&year=".$year."&month=".$month;
  }
  if (! $year ) {
	//$legend.=" <b>[ ALL TIMES ]</b> ";
  }
  
  if ($country) {
		$where_clause.=" AND  countryCode='".$country."' ";
		//$legend.=" (".$countries[$country].") | ";
  }    

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

  
  $sortDescArray=array("countryCode"=>_DATE_SORT, "FlightsNum"=>_NUMBER_OF_FLIGHTS, "max_distance"=>_SITE_RECORD_OPEN_DISTANCE  );
 
  $sortDesc=$sortDescArray[ $sortOrder];
  $ord="DESC";
  if ($sortOrder =='CountryCode' || $sortOrder =='intName' )   $ord="ASC";

  $sortOrderFinal=$sortOrder;
  
  $filter_clause=$_SESSION["filter_clause"];
  $where_clause.=$filter_clause;


//-----------------------------------------------------------------------------------------------------------

  	$query="SELECT DISTINCT takeoffID, name, intName, countryCode, count(*) as FlightsNum, max(LINEAR_DISTANCE) as max_distance 
  			FROM $flightsTable,$waypointsTable $extra_table_str
  			WHERE $flightsTable.takeoffID=$waypointsTable.ID  
			AND $flightsTable.userID<>0 ".$where_clause." 
			GROUP BY takeoffID ORDER BY $sortOrderFinal ".$ord.",max_distance DESC";	
    // echo $query;
	$res= $db->sql_query($query);		
    if($res <= 0){
		echo "no takeoffs found<br>";
		return ;
    }

  listTakeoffs($res,$legend,$query_str,$sortOrder);
?>
<script type="text/javascript" src="<?=$moduleRelPath ?>/tipster.js"></script>
<? echo makeTakeoffPopup(); ?>
<?
function printHeaderTakeoffs($width,$sortOrder,$fieldName,$fieldDesc,$query_str) {
  global $moduleRelPath;
  global $Theme,$module_name;

  if ($width==0) $widthStr="";
  else  $widthStr="width='".$width."'";

  if ($fieldName=="intName") $alignClass="alLeft";
  else $alignClass="";

  if ($sortOrder==$fieldName) { 
   echo "<td $widthStr  class='SortHeader activeSortHeader $alignClass'>
			<a href='?name=$module_name&op=list_takeoffs&sortOrder=$fieldName$query_str'>$fieldDesc<img src='$moduleRelPath/img/icon_arrow_down.png' border=0  width=10 height=10></div>
		</td>";
  } else {  
	   echo "<td $widthStr  class='SortHeader $alignClass'><a href='?name=$module_name&op=list_takeoffs&sortOrder=$fieldName$query_str'>$fieldDesc</td>";
   } 
}

function listTakeoffs($res,$legend, $query_str="",$sortOrder="CountryCode") {
   global $db,$Theme, $module_name, $takeoffRadious, $userID, $moduleRelPath;
   global $admin_users, $PREFS;
   global $page_num,$pagesNum,$startNum,$itemsNum;
   global $currentlang,$nativeLanguage,$opMode, $countries;
	 
   $legendRight="";
   $headerSelectedBgColor="#F2BC66";

   echo  "<div class='tableTitle shadowBox'>
   <div class='titleDiv'>$legend</div>
   <div class='pagesDiv'>$legendRight</div>
   </div>" ;

  ?>
  <table class='listTable' width="100%" cellpadding="2" cellspacing="0">
  <tr>
  	<td width="25" class='SortHeader'><? echo _NUM ?></td>
 	<?
		printHeaderTakeoffs(100,$sortOrder,"CountryCode",_COUNTRY,$query_str) ;
		printHeaderTakeoffs(0,$sortOrder,"intName",_TAKEOFF,$query_str) ;
		printHeaderTakeoffs(80,$sortOrder,"FlightsNum",_NUMBER_OF_FLIGHTS,$query_str) ;
		printHeaderTakeoffs(100,$sortOrder,"max_distance",_SITE_RECORD_OPEN_DISTANCE,$query_str) ;
	?>
	</tr>
<?
   	$currCountry="";
   	$i=1;
	while ($row = $db->sql_fetchrow($res)) {  
		$takeoffName=selectWaypointName($row["name"],$row["intName"],$row["countryCode"]);	
		$sortRowClass="l_row1";
		if ( $countries[$row["countryCode"]] != $currCountry || $sortOrder!='CountryCode' ) {
			$currCountry=$countries[$row["countryCode"]] ;
			$country_str= "<a href='?name=$module_name&op=list_flights&country=".$row["countryCode"]."&takeoffID=0'>".$currCountry."</a>";

			if ($sortOrder=='CountryCode') $sortRowClass="l_row2";
			else $sortRowClass=($i%2)?"l_row1":"l_row2"; 
		} else {
			$country_str="&nbsp;";
		}

		$i++;
		echo "<TR class='$sortRowClass'>";	
	   	echo "<TD>".($i-1+$startNum)."</TD>";
		echo "<TD>$country_str</TD>";

$takeoffNameSafe=str_replace("'","\'",$takeoffName);
$takeoffNameSafe=str_replace('"','\"',$takeoffNameSafe);
$takeoffNameSafe=htmlspecialchars($takeoffName); 

		echo "<TD class='alLeft'><div align=left id='t_$i'>";
	//	echo "<a href='javascript:nop()' onclick=\"takeoffTip.newTip('inline', 0, 13, 't_$i', 250, '".$row["takeoffID"]."','".str_replace("'","\'",$takeoffName)."')\"  onmouseout=\"takeoffTip.hide()\">$takeoffName</a>";
		echo "<a href='javascript:nop()' onclick=\"takeoffTip.newTip('inline', 0, 13, 't_$i', 250, '".$row["takeoffID"]."','".str_replace("'","\'",$takeoffNameSafe)."')\"  onmouseout=\"takeoffTip.hide()\">$takeoffName</a>";
		
		echo "</div></TD>";

  		echo "<TD>".$row["FlightsNum"]."</TD>";
	   	echo "<TD>".formatDistanceOpen($row["max_distance"])."</TD>";
		echo "</TR>";
   }     
   echo "</table>";
   $db->sql_freeresult($res);
}

?>
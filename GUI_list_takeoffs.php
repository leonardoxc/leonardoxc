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

 
  $sortOrder=makeSane($_REQUEST["sortOrder"]);
  if ( $sortOrder=="")  $sortOrder="CountryCode";

  $page_num=$_REQUEST["page_num"]+0;
  if ($page_num==0)  $page_num=1;

  if ($cat==0) $where_clause="";
  else $where_clause=" AND cat=$cat ";

  $query_str="";
  $legend=_MENU_TAKEOFFS;
  
  // SEASON MOD
  $where_clause.= dates::makeWhereClause(0,$season,$year,$month,0 );

  // BRANDS MOD  
  $where_clause.= brands::makeWhereClause($brandID);

  if ($country) {
		$where_clause_country.=" AND  ".$waypointsTable.".countryCode='".$country."' ";
		//$legend.=" (".$countries[$country].") | ";
  }    

  if ($clubID)   {
   require dirname(__FILE__)."/INC_club_where_clause.php";
  } 
  
  /* not needed -->  is included by default in this list
  if ($countryCodeQuery || $country)   {
	 $where_clause.=" AND $flightsTable.takeoffID=$waypointsTable.ID ";
	 $extra_table_str.=",".$waypointsTable;
  } else $extra_table_str.="";
*/
  
  $sortDescArray=array("countryCode"=>_DATE_SORT, "FlightsNum"=>_NUMBER_OF_FLIGHTS, "max_distance"=>_SITE_RECORD_OPEN_DISTANCE  );
 
  $sortDesc=$sortDescArray[ $sortOrder];
  $ord="DESC";
  if ($sortOrder =='CountryCode' || $sortOrder =='intName' )   $ord="ASC";

  $sortOrderFinal=$sortOrder;
  
  $filter_clause=$_SESSION["filter_clause"];
  $where_clause.=$filter_clause;

	if ( strpos($filter_clause,$pilotsTable.".countryCode")=== false )  $pilotsTableQuery=0;
	else   $pilotsTableQuery=1;
	
	if ( ! strpos($filter_clause,$pilotsTable.".Sex")=== false )  $pilotsTableQuery=1;
	

	if ($pilotsTableQuery  && !$pilotsTableQueryIncluded  ){
		$where_clause.="  AND $flightsTable.userID=$pilotsTable.pilotID AND $flightsTable.serverID=$pilotsTable.serverID  ";	
		$extra_table_str.=",$pilotsTable ";
	}	

 $where_clause.=$where_clause_country;
//-----------------------------------------------------------------------------------------------------------

  	$query="SELECT DISTINCT takeoffID, name, intName, ".$waypointsTable.".countryCode, count(*) as FlightsNum, max(LINEAR_DISTANCE) as max_distance 
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
	$legendRight="";
   echo  "<div class='tableTitle shadowBox'>
   <div class='titleDiv'>$legend</div>
   <div class='pagesDiv'>$legendRight</div>
   </div>" ;
	require_once dirname(__FILE__)."/MENU_second_menu.php";

  listTakeoffs($res,$legend,$query_str,$sortOrder);
?>
<script type="text/javascript" src="<?=$moduleRelPath ?>/js/tipster.js"></script>
<? echo makeTakeoffPopup(); ?>
<?
function printHeaderTakeoffs($width,$sortOrder,$fieldName,$fieldDesc,$query_str) {
  global $moduleRelPath ,$Theme;

  if ($width==0) $widthStr="";
  else  $widthStr="width='".$width."'";

  if ($fieldName=="intName") $alignClass="alLeft";
  else $alignClass="";

  if ($sortOrder==$fieldName) { 
   echo "<td $widthStr  class='SortHeader activeSortHeader $alignClass'>
			<a href='".CONF_MODULE_ARG."&op=list_takeoffs&sortOrder=$fieldName$query_str'>$fieldDesc<img src='$moduleRelPath/img/icon_arrow_down.png' border=0  width=10 height=10></div>
		</td>";
  } else {  
	   echo "<td $widthStr  class='SortHeader $alignClass'><a href='".CONF_MODULE_ARG."&op=list_takeoffs&sortOrder=$fieldName$query_str'>$fieldDesc</td>";
   } 
}

function listTakeoffs($res,$legend, $query_str="",$sortOrder="CountryCode") {
   global $db,$Theme, $takeoffRadious, $userID, $moduleRelPath;
   global $PREFS;
   global $page_num,$pagesNum,$startNum,$itemsNum;
   global $currentlang,$nativeLanguage, $countries;
	 
   
   $headerSelectedBgColor="#F2BC66";

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
			$country_str= "<a href='".CONF_MODULE_ARG."&op=list_flights&country=".$row["countryCode"]."&takeoffID=0'>".$currCountry."</a>";

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
		echo "<a href=\"javascript:takeoffTip.newTip('inline', 0, 13, 't_$i', 250, '".$row["takeoffID"]."','".str_replace("'","\'",$takeoffNameSafe)."')\"  onmouseout=\"takeoffTip.hide()\">$takeoffName</a>";
		
		echo "</div></TD>";

  		echo "<TD>".$row["FlightsNum"]."</TD>";
	   	echo "<TD>".formatDistanceOpen($row["max_distance"])."</TD>";
		echo "</TR>";
   }     
   echo "</table>";
   $db->sql_freeresult($res);
}

?>
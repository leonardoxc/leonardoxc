<?
//************************************************************************
// Leonardo XC Server, http://leonardo.thenet.gr
//
// Copyright (c) 2004-8 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: GUI_list_takeoffs.php,v 1.32 2008/11/29 22:46:07 manolis Exp $                                                                 
//
//************************************************************************

 
  $sortOrder=makeSane($_REQUEST["sortOrder"]);
  if ( $sortOrder=="")  $sortOrder="CountryCode";

  $page_num=$_REQUEST["page_num"]+0;
  if ($page_num==0)  $page_num=1;

  if ($cat==0) $where_clause="";
  else $where_clause=" AND cat=$cat ";

  $queryExtraArray=array();
  $legend=_MENU_TAKEOFFS;
  
  // SEASON MOD
  $where_clause.= dates::makeWhereClause(0,$season,$year,$month,0 );

  // BRANDS MOD  
  $where_clause.= brands::makeWhereClause($brandID);

	// take care of exluding flights
	// 1-> first bit -> means flight will not be counted anywhere!!!
	$bitMask=1 & ~( $includeMask & 0x01 );
	$where_clause.= " AND ( excludeFrom & $bitMask ) = 0 ";

	if ($pilotID!=0) {
		$where_clause.=" AND userID='".$pilotID."'  AND userServerID=$serverID ";		
	} else {  // 0 means all flights BUT not test ones 
		$where_clause.=" AND userID>0 ";		
	}
	
  if ($country) {
		$where_clause_country.=" AND  ".$waypointsTable.".countryCode='".$country."' ";
		//$legend.=" (".$countries[$country].") | ";
  }    
  
  	if ($class) {
		$where_clause.=" AND  $flightsTable.category='".$class."' ";
	}

	if ($xctype) {
		$where_clause.=" AND  $flightsTable.BEST_FLIGHT_TYPE='".$CONF_xc_types_db[$xctype]."' ";
	}

  # Martin Jursa 23.05.2007: support for NacClub Filtering
  if (!empty($CONF_use_NAC)) {
	  if ($nacid && $nacclubid) {
	  		$where_clause.=" AND $flightsTable.NACid=$nacid AND $flightsTable.NACclubID=$nacclubid";
	  }
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
   if (0) echo  "<div class='tableTitle shadowBox'>
   <div class='titleDiv'>$legend</div>
   <div class='pagesDiv'>$legendRight</div>
   </div>" ;
	require_once dirname(__FILE__)."/MENU_second_menu.php";

   echo "<div class='list_header'>
				<div class='list_header_r'></div>
				<div class='list_header_l'></div>
				<h1>$legend</h1>
				<div class='pagesDiv'>$legendRight</div>
			</div>";
			
  listTakeoffs($res,$legend,$queryExtraArray,$sortOrder);
?>
<script type="text/javascript" src="<?=$moduleRelPath ?>/js/tipster.js"></script>
<? echo makeTakeoffPopup(); ?>
<?
function printHeaderTakeoffs($width,$sortOrder,$fieldName,$fieldDesc,$queryExtraArray) {
  global $moduleRelPath ,$Theme;

  if ($width==0) $widthStr="";
  else  $widthStr="width='".$width."'";

  if ($fieldName=="intName") $alignClass="alLeft";
  else $alignClass="";

  if ($sortOrder==$fieldName) { 
   echo "<td $widthStr  class='SortHeader activeSortHeader $alignClass'>
			$fieldDesc<img src='$moduleRelPath/img/icon_arrow_down.png' border=0  width=10 height=10></div>
		</td>";
  } else {  
	   echo "<td $widthStr  class='SortHeader $alignClass'><a href='".
	   		getLeonardoLink(array('op'=>'list_takeoffs','sortOrder'=>$fieldName)+$queryExtraArray)
			."'>$fieldDesc</td>";
   } 
}

function listTakeoffs($res,$legend, $queryExtraArray=array(),$sortOrder="CountryCode") {
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
		printHeaderTakeoffs(100,$sortOrder,"CountryCode",_COUNTRY,$queryExtraArray) ;
		printHeaderTakeoffs(0,$sortOrder,"intName",_TAKEOFF,$queryExtraArray) ;
		printHeaderTakeoffs(80,$sortOrder,"FlightsNum",_NUMBER_OF_FLIGHTS,$queryExtraArray) ;
		printHeaderTakeoffs(100,$sortOrder,"max_distance",_SITE_RECORD_OPEN_DISTANCE,$queryExtraArray) ;
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
			$country_str= "<a href='".getLeonardoLink(
					array('op'=>'list_flights','country'=>$row["countryCode"],'takeoffID'=>'0') )
					."'>".$currCountry."</a>";

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
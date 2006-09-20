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
<script language="javascript">

var takeoffTip = new TipObj('takeoffTip');
with (takeoffTip)
{
 // I'm using tables here for legacy NS4 support, but feel free to use styled DIVs.
 template = '<table bgcolor="#000000" cellpadding="0" cellspacing="0" width="%2%" border="1">' +
  '<tr><td><table cellpadding="3" cellspacing="1" width="100%" border="0" bgcolor="#F4F8E2" class="tipClass main_text">' +
  '<tr><td bgcolor="#DCDBCA" align=center> .:: <? echo _TAKEOFF ?>: <b>%4%</b> ::. </td></tr>'+
  '<tr><td align="left">'+
  
  	//echo 		"<a href='?name=$module_name&op=list_flights&takeoffID=".$row["takeoffID"]."'>$takeoffNameFrm</a>&nbsp;".			
		//	"<a href='?name=$module_name&op=show_waypoint&waypointIDview=".$row["takeoffID"]."'><img src='".$moduleRelPath."/img/icon_magnify_small.gif' border=0></a>".
	//		"<a href='".$moduleRelPath."/download.php?type=kml_wpt&wptID=".$row["takeoffID"]."'><img src='".$moduleRelPath."/img/gearth_icon.png' border=0></a>".

	"<img src='<?=$moduleRelPath?>/img/icon_magnify_small.gif' align='absmiddle' border=0> <a href='?name=<?=$module_name?>&op=list_flights&takeoffID=%3%'><? echo  _SHOW_FLIGHTS ?></a>"+
	'</td></tr>'+
    '<tr><td align="left">'+
	"<img src='<?=$moduleRelPath?>/img/icon_pin.png' align='absmiddle' border=0> <a href='?name=<?=$module_name?>&op=show_waypoint&waypointIDview=%3%'><? echo _SITE_INFO  ?></a>"+
	'</td></tr>'+
    '<tr><td align="left">'+

	"<img src='<?=$moduleRelPath?>/img/gearth_icon.png' align='absmiddle' border=0> <a href='<?=$moduleRelPath?>/download.php?type=kml_wpt&wptID=%3%'><? echo _Navigate_with_Google_Earth ?></a>"+

	'</td></tr>' +
  '</table></td></tr></table>';

 tipStick = 0;
 showDelay = 0;
 hideDelay = 0;
 doFades = false;
}


</script>

<div id="takeoffTipLayer" class="shadowBox" style="position: absolute; z-index: 10000; visibility: hidden;
 left: 0px; top: 0px; width: 10px">&nbsp;</div>

<?
function printHeaderTakeoffs($width,$headerSelectedBgColor,$headerUnselectedBgColor,$sortOrder,$fieldName,$fieldDesc,$query_str) {
  global $moduleRelPath;
  global $Theme,$module_name;

  if ($width==0) $widthStr="";
  else  $widthStr="width='".$width."'";

  if ($sortOrder==$fieldName) { 
   echo "<td $widthStr bgcolor='$headerSelectedBgColor'>
		<div class='whiteLetter' align=left>
		<a href='?name=$module_name&op=list_takeoffs&sortOrder=$fieldName$query_str'>$fieldDesc<img src='$moduleRelPath/img/icon_arrow_down.png' border=0  width=10 height=10></div></td>";
  } else {  
   echo "<td $widthStr bgcolor='$headerUnselectedBgColor'>
		<div align=left>
		<a href='?name=$module_name&op=list_takeoffs&sortOrder=$fieldName$query_str'>$fieldDesc</div></td>";
   } 
}

function listTakeoffs($res,$legend, $query_str="",$sortOrder="CountryCode") {
   global $Theme;
   global $module_name;
   global $takeoffRadious;
   global $userID;
   global $moduleRelPath;
   global $admin_users;
   global $PREFS;
   global $page_num,$pagesNum,$startNum,$itemsNum;
   global $currentlang,$nativeLanguage,$opMode;
   global $countries;
	 
   $legendRight="";

   $headerSelectedBgColor="#F2BC66";
     echo  "<div class='tableTitle shadowBox'>
   <div class='titleDiv'>$legend</div>
   <div class='pagesDiv'>$legendRight</div>
   </div>" ;
   //open_inner_table("<table class=main_text width=100%><tr><td>$legend</td><td width=300 align=right bgcolor=#eeeeee>$legendRight</td></tr></table>",750);
  ?>
  <table class='listTable shadowBox' width="100%">
  <td width="25" bgcolor="<?=$Theme->color1?>"><div align=left><? echo _NUM ?></div></td>
 <?

   printHeaderTakeoffs(120,$headerSelectedBgColor,$Theme->color0,$sortOrder,"CountryCode",_COUNTRY,$query_str) ;
   printHeaderTakeoffs(0,$headerSelectedBgColor,$Theme->color2,$sortOrder,"intName",_TAKEOFF,$query_str) ;
   printHeaderTakeoffs(80,$headerSelectedBgColor,$Theme->color3,$sortOrder,"FlightsNum",_NUMBER_OF_FLIGHTS,$query_str) ;
   printHeaderTakeoffs(100,$headerSelectedBgColor,$Theme->color4,$sortOrder,"max_distance",_SITE_RECORD_OPEN_DISTANCE,$query_str) ;

?>
</tr>
<?

   $currCountry="";
   $i=1;
   while ($row = mysql_fetch_assoc($res)) { 
  
	 $takeoffName=selectWaypointName($row["name"],$row["intName"],$row["countryCode"]);	
	 //	 $sortRowBgColor=($i%2)?"#CCCACA":"#E7E9ED"; 
     $sortRowBgColor="#E7E9ED"; 
     $bgcolor="";
	if ( $countries[$row["countryCode"]] != $currCountry || $sortOrder!='CountryCode' ) {
		$currCountry=$countries[$row["countryCode"]] ;
		$country_str= "<div align=left>".
			"<a href='?name=$module_name&op=list_flights&country=".$row["countryCode"]."&takeoffID=0'>".$currCountry."</a>". 	   
		    "</div>";
		if ($sortOrder=='CountryCode') $bgcolor="bgcolor=#DDDDDD"; 
		else $bgcolor=($i%2)?"bgcolor=#DDDDDD":"";
	} else {
		$country_str="";
	}

	 $i++;
	 echo "<TR $bgcolor align=right>";	
	   	echo "<TD $first_col_back_color ><div align=left>".($i-1+$startNum)."</div></TD>      ";
		echo "<TD valign=top>$country_str</TD>";

		echo "<TD ".(($sortOrder=="takeoffID")?"bgcolor=".$sortRowBgColor:"").">".
			 "<div align=left>";
			 
//			 "<a href='?name=$module_name&op=show_waypoint&waypointIDview=".$row["takeoffID"]."'><img src='".$moduleRelPath."/img/icon_magnify_small.gif' border=0></a>".
//			 "<a href='".$moduleRelPath."/download.php?type=kml_wpt&wptID=".$row["takeoffID"]."'><img src='".$moduleRelPath."/img/gearth_icon.png' border=0></a>&nbsp;".
//			 "<a href='?name=$module_name&op=list_flights&takeoffID=".$row["takeoffID"]."'>".$takeoffName."</a>".			
 			echo "<a href='#' onmouseover=\"takeoffTip.newTip('inline', 0, 0, 250, '".$row["takeoffID"]."','$takeoffName')\"  onmouseout=\"takeoffTip.hide()\">$takeoffName</a>";

		echo "</div></TD>";
  		echo "<TD ".(($sortOrder=="LINEAR_DISTANCE")?"bgcolor=".$sortRowBgColor:"")."><div align=right>".$row["FlightsNum"]."</div></TD>	";
	   	echo "<TD ".(($sortOrder=="LINEAR_DISTANCE")?"bgcolor=".$sortRowBgColor:"")."><div align=right>".formatDistanceOpen($row["max_distance"])."</div></TD>	";
  	 close_tr();
   }     
//   close_inner_table();       
   echo "</table>";
   mysql_freeResult($res);
}

?>

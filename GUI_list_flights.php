<? 
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://sourceforge.net/projects/leonardoserver                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

  function replace_spaces($str) {
		return str_replace(" ","&nbsp;",$str);
  }

  $legend="";
 
  $sortOrder=$_REQUEST["sortOrder"];
  if ( $sortOrder=="")  $sortOrder="DATE";

  $page_num=$_REQUEST["page_num"]+0;
  if ($page_num==0)  $page_num=1;

  if ($cat==0) $where_clause="";
  else $where_clause=" AND cat=$cat ";

  $query_str="";
  $legend="";
  $legend="<b>"._MENU_FLIGHTS."</b> ";
  if ($year && !$month ) {
		$where_clause.=" AND DATE_FORMAT(DATE,'%Y') = ".$year." ";
		//$legend.=" <b>[ ".$year." ]</b> ";
//		$query_str.="&year=".$year;
  }
  if ($year && $month ) {
		$where_clause.=" AND DATE_FORMAT(DATE,'%Y%m') = ".$year.$month." ";
		// $legend.=" <b>[ ".$monthList[$month-1]." ".$year." ]</b> ";
//		$query_str.="&year=".$year."&month=".$month;
  }
  if (! $year ) {
	//$legend.=" <b>[ "._ALL_TIMES." ]</b> ";
  }
  
  if ($pilotID) {
		$where_clause.=" AND userID='".$pilotID."' ";
		// $legend.="<a href='?name=$module_name&pilotID=0'><img src='$moduleRelPath/img/icon_x.png' border=0></a>&nbsp;"._PILOT_FLIGHTS." | ";
		//$query_str.="&pilotID=".$pilotID;
  }

  if ( ! ($pilotID>0 && $pilotID==$userID ) && !in_array($userID,$admin_users) ) {
		$where_clause.=" AND private=0 ";
  }

  if ($takeoffID) {
		$where_clause.=" AND takeoffID='".$takeoffID."' ";
		// $legend.=" <a href='?name=$module_name&takeoffID=0'><img src='$moduleRelPath/img/icon_x.png' border=0></a>&nbsp;".replace_spaces(getWaypointName($takeoffID))." | ";
		// $query_str.="&takeoffName=".$takeoffName;
  }

  if ($country) {
		$where_clause.=" AND  countryCode='".$country."' ";
		// if ($sortOrder!="dateAdded") $legend.=" ".replace_spaces($countries[$country])." | ";
		// $query_str.="&takeoffName=".$takeoffName;
  }
    

  if ($sortOrder=="dateAdded" && $year ) $sortOrder="DATE";

  $sortDescArray=array("DATE"=>_DATE_SORT,"pilotName"=>_PILOT_NAME, "takeoffID"=>_TAKEOFF,
			     "DURATION"=>_DURATION, "LINEAR_DISTANCE"=>_LINEAR_DISTANCE, 
				 "FLIGHT_KM"=>_OLC_KM, "FLIGHT_POINTS"=>_OLC_SCORE , "dateAdded"=>_DATE_ADDED );
 
  $sortDesc=$sortDescArray[ $sortOrder];
  $ord="DESC";

  $sortOrderFinal=$sortOrder;
  if ($sortOrder=="pilotName") { 
	 if ($opMode==1) $sortOrderFinal="CONCAT(name,username) ";
	 else $sortOrderFinal="username";
    $ord="ASC";
  }   else if ($sortOrder=="dateAdded") { 
	 $where_clause=" AND DATE_SUB(NOW(),INTERVAL 5 DAY) <  dateAdded  ";
  }  else if ($sortOrder=="DATE") { 
		$sortOrderFinal="DATE DESC, FLIGHT_POINTS ";
  }
  $filter_clause=$_SESSION["filter_clause"];
  if ( strpos($filter_clause,"countryCode")=== false )  $countryCodeQuery=0;	
  else $countryCodeQuery=1;

  $where_clause.=$filter_clause;
  if ($countryCodeQuery || $country)   {
	 $where_clause.=" AND $flightsTable.takeoffID=$waypointsTable.ID ";
	 $extra_table_str=",".$waypointsTable;
  } else $extra_table_str="";

  if ($clubID)   {
	 $areaID=$clubsList[$clubID]['areaID'];
  	 $addManual=$clubsList[$clubID]['addManual'];

	 $add_remove_mode=$_GET['a_r']+0;
	 $query_str.="&a_r=$add_remove_mode";
	 
	 $where_clause.=" AND 	$flightsTable.userID=$clubsPilotsTable.pilotID AND 
				 			$clubsPilotsTable.clubID=$clubID ";
	$extra_table_str.=",$clubsPilotsTable ";

	if ($areaID) {
		 $where_clause.= " 	AND $areasTakeoffsTable.areaID=$clubsTable.areaID 
							AND $areasTakeoffsTable.takeoffID=$flightsTable.takeoffID  ";
	 	 $extra_table_str.=",$areasTakeoffsTable ";
	}

	
	if ($addManual) {
		 $clubFlights=getClubFlightsID($clubID);

		if (! $add_remove_mode ) { // select only spefici flights
		 $where_clause.= " 	AND $clubsFlightsTable.flightID=$flightsTable.ID 
							AND $clubsFlightsTable.clubID=$clubID ";
	 	 $extra_table_str.=",$clubsFlightsTable ";
		}
	}

  } 


  $query="SELECT count(*) as itemNum FROM $flightsTable".$extra_table_str."  WHERE (1=1) ".$where_clause." ";
  $res= $db->sql_query($query);
  if($res <= 0){   
	 echo("<H3> Error in count items query! $query</H3>\n");
     exit();
  }

  $row = mysql_fetch_assoc($res);
  $itemsNum=$row["itemNum"];   

  $startNum=($page_num-1)*$PREFS->itemsPerPage;
  $pagesNum=ceil ($itemsNum/$PREFS->itemsPerPage);
  if ($pilotID>=0)
 	 $query="SELECT * , ".$pilotsTable.".countryCode as pilotCountryCode, $flightsTable.takeoffID as flight_takeoffID ,$flightsTable.ID as ID 
			FROM $pilotsTable, $flightsTable,".$prefix."_users".$extra_table_str." 
			WHERE ".$pilotsTable.".pilotID=".$prefix."_users.user_id  AND ".$flightsTable.".userID=".$prefix."_users.user_id ".$where_clause." 
			ORDER BY ".$sortOrderFinal ." ".$ord." LIMIT $startNum,".$PREFS->itemsPerPage;
     
  else  {
	 $query="SELECT * , ".$pilotsTable.".countryCode as pilotCountryCode,  $flightsTable.takeoffID as flight_takeoffID , $flightsTable.ID as ID 
			FROM $pilotsTable, $flightsTable ".$extra_table_str."  
			WHERE ".$pilotsTable.".pilotID=".$prefix."_users.user_id  ".$where_clause." 
			ORDER BY ".$sortOrderFinal ." ".$ord." LIMIT $startNum,".$PREFS->itemsPerPage ;
  }
 //  echo $query;
  $res= $db->sql_query($query);

  if($res <= 0){
     echo("<H3> Error in query! </H3>\n");
     exit();
  }
	
  //  $legend.=_SORTED_BY." ".$sortDesc;
//  $legend.=_SORTED_BY." <img src='$moduleRelPath/img/icon_sort.png' border=0 align=absmiddle>&nbsp;".replace_spaces($sortDesc);
  $legend.=" :: "._SORTED_BY."&nbsp;".replace_spaces($sortDesc);
  listFlights($res,$legend,	$query_str,$sortOrder);

?>

<script language="javascript">

function addClubFlight(clubID,flightID) {
	url='/<?=$moduleRelPath?>/EXT_club_functions.php';
//	url='modules.php';
//	url='modules.php?name=leonardo&op=filter';
	pars='op=add&clubID='+clubID+'&flightID='+flightID;
	
	var myAjax = new Ajax.Updater('updateDiv', url, {method:'get',parameters:pars});

	newHTML="<a href=\"#\" onclick=\"removeClubFlight("+clubID+","+flightID+");return false;\"><img src='<?=$moduleRelPath?>/img/icon_club_remove.gif' width=16 height=16 border=0 align=bottom></a>";
	div=MWJ_findObj('fl_'+flightID);
	div.innerHTML=newHTML;
	//toggleVisible(divID,divPos);
}

function removeClubFlight(clubID,flightID) {
	url='/<?=$moduleRelPath?>/EXT_club_functions.php';
//	url='modules.php';
//	url='modules.php?name=leonardo&op=filter';
	pars='op=remove&clubID='+clubID+'&flightID='+flightID;
	
	var myAjax = new Ajax.Updater('updateDiv', url, {method:'get',parameters:pars});

	newHTML="<a href=\"#\" onclick=\"addClubFlight("+clubID+","+flightID+");return false;\"><img src='<?=$moduleRelPath?>/img/icon_club_add.gif' width=16 height=16 border=0 align=bottom></a>";
	div=MWJ_findObj('fl_'+flightID);
	div.innerHTML=newHTML;
	//toggleVisible(divID,divPos);
}
</script>
<script type="text/javascript" src="<?=$moduleRelPath ?>/tipster.js"></script>
<? echo makePilotPopup(); ?>
<? echo makeTakeoffPopup(); ?>
<?

function printHeader($width,$sortOrder,$fieldName,$fieldDesc,$query_str) {
  global $moduleRelPath;
  global $Theme,$module_name;

  if ($width==0) $widthStr="";
  else  $widthStr="width='".$width."'";

  if ($fieldName=="pilotName") $alignClass="alLeft";
  else $alignClass="";
  
  if ($sortOrder==$fieldName) { 
   echo "<td class='SortHeader activeSortHeader $alignClass' $widthStr>	
		<a href='?name=$module_name&op=list_flights&sortOrder=$fieldName$query_str'>$fieldDesc<img src='$moduleRelPath/img/icon_arrow_down.png' border=0  width=10 height=10></td>";
  } else {  
   echo "<td class='SortHeader $alignClass' $widthStr>
		<a href='?name=$module_name&op=list_flights&sortOrder=$fieldName$query_str'>$fieldDesc</a></td>";
   } 
}

function listFlights($res,$legend, $query_str="",$sortOrder="DATE") {
   global $Theme;
   global $module_name;
   global $takeoffRadious;
   global $userID;
   global $clubID,$clubFlights,$clubsList, $add_remove_mode;
   global $moduleRelPath;
   global $admin_users;
   global $PREFS;
   global $page_num,$pagesNum,$startNum,$itemsNum;
   global $currentlang,$nativeLanguage,$opMode;
   
   $legendRight="";   
   if ($pagesNum>1) {
	 if  ($page_num>1 ) 
		 $legendRight.="<a href='?name=$module_name&op=list_flights&sortOrder=$sortOrder$query_str&page_num=".($page_num-1)."'><<</a>&nbsp;";
	 else $legendRight.="<<&nbsp;";
   
   for ($k=1;$k<=$pagesNum;$k++) {
		 if  ($k!=$page_num) 
			 $legendRight.="<a href='?name=$module_name&op=list_flights&sortOrder=$sortOrder$query_str&page_num=$k'>$k</a>&nbsp;";
	 	 else  $legendRight.="$k&nbsp;";

   } 
	 if  ($page_num<$pagesNum) 
		 $legendRight.="<a href='?name=$module_name&op=list_flights&sortOrder=$sortOrder$query_str&page_num=".($page_num+1)."'>>></a>&nbsp;";
	 else $legendRight.=">>&nbsp;";

   }

	 $legendRight=generate_flights_pagination("?name=$module_name&op=list_flights&sortOrder=$sortOrder$query_str", $itemsNum,$PREFS->itemsPerPage,$page_num*$PREFS->itemsPerPage-1, TRUE); 

	 $endNum=$startNum+$PREFS->itemsPerPage;
	 if ($endNum>$itemsNum) $endNum=$itemsNum;
	 $legendRight.=" [&nbsp;".($startNum+1)."-".$endNum."&nbsp;"._From."&nbsp;".$itemsNum ."&nbsp;]";
	 if ($itemsNum==0) $legendRight="[ 0 ]";
	 

   if ( $clubID  && (is_club_admin($userID,$clubID) || is_leo_admin($userID))  )  {
	 	echo  "<div class='tableInfo shadowBox'>You can administer this club ";
		if ( $clubsList[$clubID]['addManual'] ) {
			if ($add_remove_mode)
				echo "<a href='?name=$module_name&op=list_flights&sortOrder=$sortOrder$query_str&a_r=0'>Return to normal view</a>";
			else
				echo "<a href='?name=$module_name&op=list_flights&sortOrder=$sortOrder$query_str&a_r=1'>Add / remove flights</a>";

		}
		echo "<div id='updateDiv' style='display:block'></div>";
	 	echo  "</div>";
   }
   
  echo  "<div class='tableTitle'>
   <div class='titleDiv'>$legend</div>
   <div class='pagesDiv'>$legendRight</div>
   </div>" ;
  ?>
  	<table class='listTable' width="100%" cellpadding="2" cellspacing="0">
	<tr> 
	  <td class='SortHeader' width="25"><? echo _NUM ?></td>
		 <?
		   printHeader(70,$sortOrder,"DATE",_DATE_SORT,$query_str) ;
		   printHeader(160,$sortOrder,"pilotName",_PILOT,$query_str) ;
		   printHeader(0,$sortOrder,"takeoffID",_TAKEOFF,$query_str) ;
		   printHeader(40,$sortOrder,"DURATION",_DURATION_HOURS_MIN,$query_str) ;
		   printHeader(65,$sortOrder,"LINEAR_DISTANCE",_LINEAR_DISTANCE,$query_str) ;
		   printHeader(65,$sortOrder,"FLIGHT_KM",_OLC_KM,$query_str) ;
		   printHeader(40,$sortOrder,"FLIGHT_POINTS",_OLC_SCORE,$query_str) ;
		?>
	  <td width="18" class='SortHeader'>&nbsp;</td>
	  <td width="72" class='SortHeader alLeft'><? echo _SHOW ?></td>
  </tr>
<?
   $i=1;
   $currDate="";
   while ($row = mysql_fetch_assoc($res)) { 
     $is_private=$row["private"];
	 $flightID=$row['ID'];

     $name=getPilotRealName($row["userID"]);
     $name=str_replace("&#039;","'",$name);

	 $takeoffName=getWaypointName($row["flight_takeoffID"]);
	 $takeoffVinicity=$row["takeoffVinicity"];
	 $takeoffNameFrm=	formatLocation($takeoffName,$takeoffVinicity,$takeoffRadious );
	 
	 $sortRowClass=($i%2)?"l_row1":"l_row2"; 	 
	 $i++;
	 echo "\n\n<tr class='$sortRowClass'>";
	   $days_from_submission =	floor( ( mktime() - datetime2UnixTimestamp($row["dateAdded"]) ) / 86400 );  // 60*60*24 sec per day

	   if ( $is_private ) $first_col_back_color=" bgcolor=#33dd33 ";
	   else  $first_col_back_color="";
	   	   
  	   if ( $row["DATE"] != $currDate || $sortOrder!='DATE' ) {
  	   		 $currDate=$row["DATE"];  	   		
  	   		 $dateStr= formatDate($row["DATE"]);
  	   		
  	   } else {
  	   		$dateStr="&nbsp;";  	   		 
  	   }
  	   if ( $days_from_submission <= 3 ) $dateStr.="<img src='".$moduleRelPath."/img/icon_new.png' >";			
  	   
	   $duration=sec2Time($row['DURATION'],1);
	   $linearDistance=formatDistanceOpen($row["LINEAR_DISTANCE"]);
	   $olcDistance=formatDistanceOpen($row["FLIGHT_KM"]);
	   $olcScore=formatOLCScore($row["FLIGHT_POINTS"]);
	   
	   echo "<TD $first_col_back_color>".($i-1+$startNum)."</TD>";
	   echo "<TD><div align=right>$dateStr</div></TD>".
       "<TD width=300 colspan=2 ".$sortArrayStr["pilotName"].$sortArrayStr["takeoffID"].">".
		"<div align=left>";
		echo  getNationalityDescription($row["pilotCountryCode"],1,0);
		echo " <a href=\"javascript:nop()\" onclick=\"pilotTip.newTip('inline', -40, -40, 200, '".$row["userID"]."','".str_replace("'","\'",$name)."' )\"  onmouseout=\"pilotTip.hide()\">$name</a>".
		"</div>".
		"<div align=right>";
		echo "<a href=\"javascript:nop()\" onclick=\"takeoffTip.newTip('inline',-40,-40, 250, '".$row["takeoffID"]."','$takeoffName')\"  onmouseout=\"takeoffTip.hide()\">$takeoffNameFrm</a>".
			"</div></TD>".
	   "<TD>$duration</TD>".
	   "<TD>$linearDistance</TD>".
	   "<TD>$olcDistance</TD>".
	   "<TD>$olcScore</TD>".
	   "<TD><img src='".$moduleRelPath."/img/icon_cat_".$row["cat"].".png' border=0></td>".
	   "<TD align=left><a href='?name=$module_name&op=show_flight&flightID=".$row["ID"]."'><img src='".$moduleRelPath."/img/icon_magnify_small.gif' border=0 valign=top></a>";
	    echo "<a href='".$moduleRelPath."/download.php?type=kml_trk&flightID=".$row["ID"]."'><img src='".$moduleRelPath."/img/gearth_icon.png' border=0 valign=top></a>";
	
	   if ($row["photo1Filename"]) echo "<img src='".$moduleRelPath."/img/photo_icon.jpg' width=16 height=16 valign=top>";
	   else echo "<img src='".$moduleRelPath."/img/photo_icon_blank.gif' width=16 height=16>";
	   
	   if ($row["userID"]==$userID || in_array($userID,$admin_users) ) {  // admin IDS in $admin_users
			echo "<a href='?name=$module_name&op=delete_flight&flightID=".$row["ID"]."'><img src='".$moduleRelPath."/img/x_icon.gif' width=16 height=16 border=0 align=bottom></a>"; 
			echo "<a href='?name=$module_name&op=edit_flight&flightID=".$row["ID"]."'><img src='".$moduleRelPath."/img/change_icon.png' width=16 height=16 border=0 align=bottom></a>"; 
	   }			

			if ( ( is_club_admin($userID,$clubID) || is_leo_admin($userID) )&&  $add_remove_mode )  {
 				echo "<BR>";
				if (in_array($flightID,$clubFlights ) ){
					echo "<div id='fl_$flightID' style='display:inline'>
<a href=\"#\" onclick=\"removeClubFlight($clubID,$flightID);return false;\">
<img src='".$moduleRelPath."/img/icon_club_remove.gif' width=16 height=16 border=0 align=bottom title='Remove flight from this league'></a>
</div>
";
				} else {
					echo "<div id='fl_$flightID' style='display:inline'>
<a href=\"#\" onclick=\"addClubFlight($clubID,$flightID);return false;\">
<img src='".$moduleRelPath."/img/icon_club_add.gif' width=16 height=16 border=0 align=bottom title='Add flight to this league'></a>
</div>
";
				}
			
			} 
	   echo "</TD>";	  
  	   echo "</TR>";
   }  
   echo "</table>"  ;      
   mysql_freeResult($res);
}


?>
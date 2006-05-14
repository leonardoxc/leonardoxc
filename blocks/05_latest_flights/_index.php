<? 
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
  if ($year && !$month ) {
		$where_clause.=" AND DATE_FORMAT(DATE,'%Y') = ".$year." ";
		$legend.=" <b>[ ".$year." ]</b> ";
//		$query_str.="&year=".$year;
  }
  if ($year && $month ) {
		$where_clause.=" AND DATE_FORMAT(DATE,'%Y%m') = ".$year.$month." ";
		$legend.=" <b>[ ".$monthList[$month-1]." ".$year." ]</b> ";
//		$query_str.="&year=".$year."&month=".$month;
  }
  if (! $year ) {
	$legend.=" <b>[ "._ALL_TIMES." ]</b> ";
  }
  
  if ($pilotID) {
		$where_clause.=" AND userID='".$pilotID."' ";
		$legend.="<a href='?name=$module_name&pilotID=0'><img src='$moduleRelPath/img/icon_x.png' border=0></a>&nbsp;"._PILOT_FLIGHTS." | ";
		//$query_str.="&pilotID=".$pilotID;
  }

  if ( ! ($pilotID>0 && $pilotID==$userID ) && !in_array($userID,$admin_users) ) {
		$where_clause.=" AND private=0 ";
  }

  if ($takeoffID) {
		$where_clause.=" AND takeoffID='".$takeoffID."' ";
		$legend.=" <a href='?name=$module_name&takeoffID=0'><img src='$moduleRelPath/img/icon_x.png' border=0></a>&nbsp;".replace_spaces(getWaypointName($takeoffID))." | ";
		// $query_str.="&takeoffName=".$takeoffName;
  }

  if ($country) {
		$where_clause.=" AND  countryCode='".$country."' ";
		if ($sortOrder!="dateAdded") $legend.=" ".replace_spaces($countries[$country])." | ";
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

  $query="SELECT count(*) as itemNum FROM $flightsTable".$extra_table_str."  WHERE (1=1) ".$where_clause." ";
  $res= $db->sql_query($query);
  if($res <= 0){   
	 echo("<H3> Error in count items query!</H3>\n");
     exit();
  }

  $row = mysql_fetch_assoc($res);
  $itemsNum=$row["itemNum"];   

  $startNum=($page_num-1)*$PREFS->itemsPerPage;
  $pagesNum=ceil ($itemsNum/$PREFS->itemsPerPage);
  if ($pilotID>=0)
 	 $query="SELECT * ,$flightsTable.ID as ID FROM $flightsTable,".$prefix."_users".$extra_table_str."  WHERE ".$flightsTable.".userID=".$prefix."_users.user_id ".
						$where_clause." ORDER BY ".$sortOrderFinal ." ".$ord." LIMIT $startNum,".$PREFS->itemsPerPage;
     
  else  {
	 $query="SELECT * ,$flightsTable.ID as ID FROM $flightsTable ".$extra_table_str."  WHERE (1=1) ".
						$where_clause." ORDER BY ".$sortOrderFinal ." ".$ord." LIMIT $startNum,".$PREFS->itemsPerPage ;
  }
  //  echo $query;
  $res= $db->sql_query($query);

  if($res <= 0){
     echo("<H3> Error in query! </H3>\n");
     exit();
  }
	
  //  $legend.=_SORTED_BY." ".$sortDesc;
  $legend.="<img src='$moduleRelPath/img/icon_sort.png' border=0 align=absmiddle>&nbsp;".replace_spaces($sortDesc);
  listFlights($res,$legend,	$query_str,$sortOrder);

function printHeader($width,$headerSelectedBgColor,$headerUnselectedBgColor,$sortOrder,$fieldName,$fieldDesc,$query_str) {
  global $moduleRelPath;
  global $Theme,$module_name;

  if ($width==0) $widthStr="";
  else  $widthStr="width='".$width."'";

  if ($sortOrder==$fieldName) { 
   echo "<td $widthStr bgcolor='$headerSelectedBgColor'>
		<div class='whiteLetter' align=left>
		<a href='?name=$module_name&op=list_flights&sortOrder=$fieldName$query_str'>$fieldDesc<img src='$moduleRelPath/img/icon_arrow_down.png' border=0  width=10 height=10></div></td>";
  } else {  
   echo "<td $widthStr bgcolor='$headerUnselectedBgColor'>
		<div align=left>
		<a href='?name=$module_name&op=list_flights&sortOrder=$fieldName$query_str'>$fieldDesc</div></td>";
   } 
}

function listFlights($res,$legend, $query_str="",$sortOrder="DATE") {
   global $Theme;
   global $module_name;
   global $takeoffRadious;
   global $userID;
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
	 $endNum=$startNum+$PREFS->itemsPerPage;
	 if ($endNum>$itemsNum) $endNum=$itemsNum;
	 $legendRight.=" [ ".($startNum+1)."-".$endNum." "._From." ".$itemsNum ." ]";
	 if ($itemsNum==0) $legendRight="[ 0 ]";
	 
   $headerSelectedBgColor="#F2BC66";
   open_inner_table("<table class=main_text width=100%><tr><td>$legend</td><td valign=top width=400 align=right bgcolor=#eeeeee>$legendRight</td></tr></table>",750,-1);
  
  ?>
  <td width="25" bgcolor="<?=$Theme->color1?>"><div align=left><? echo _NUM ?></div></td>
 <?
   printHeader(80,$headerSelectedBgColor,$Theme->color0,$sortOrder,"DATE",_DATE_SORT,$query_str) ;
   printHeader(160,$headerSelectedBgColor,$Theme->color0,$sortOrder,"pilotName",_PILOT,$query_str) ;
   printHeader(0,$headerSelectedBgColor,$Theme->color1,$sortOrder,"takeoffID",_TAKEOFF,$query_str) ;
   printHeader(40,$headerSelectedBgColor,$Theme->color2,$sortOrder,"DURATION",_DURATION_HOURS_MIN,$query_str) ;
   printHeader(65,$headerSelectedBgColor,$Theme->color3,$sortOrder,"LINEAR_DISTANCE",_LINEAR_DISTANCE,$query_str) ;
   printHeader(65,$headerSelectedBgColor,$Theme->color3,$sortOrder,"FLIGHT_KM",_OLC_KM,$query_str) ;
   printHeader(40,$headerSelectedBgColor,$Theme->color3,$sortOrder,"FLIGHT_POINTS",_OLC_SCORE,$query_str) ;
?>
  <td width="18" bgcolor="<?=$Theme->color4?>">&nbsp;</td>
  <td width="72" bgcolor="<?=$Theme->color4?>"><div align=left><? echo _SHOW ?></div></td></tr>
<?
   $i=1;
   while ($row = mysql_fetch_assoc($res)) { 
     $is_private=$row["private"];

     $name=getPilotRealName($row["userID"]);
	 $takeoffName=getWaypointName($row["takeoffID"]);
	 $takeoffVinicity=$row["takeoffVinicity"];
	 $takeoffNameFrm=	formatLocation($takeoffName,$takeoffVinicity,$takeoffRadious );

	 $sortRowBgColor=($i%2)?"#CCCACA":"#E7E9ED"; 
	 $i++;
	 open_tr();
	   $days_from_submission =	floor( ( mktime() - datetime2UnixTimestamp($row["dateAdded"]) ) / 86400 );  // 60*60*24 sec per day

	   if ( $is_private ) $first_col_back_color=" bgcolor=#33dd33 ";
	   else  $first_col_back_color="";
	   echo  
		"<TD $first_col_back_color ><div align=left>".($i-1+$startNum)."</div></TD>      
	   <TD ".(($sortOrder=="DATE")?"bgcolor=".$sortRowBgColor:"").">
			<div align=right>";
	   
  	   if ( $days_from_submission <= 3 ) echo "<img src='".$moduleRelPath."/img/icon_new.png' >";		

	   echo formatDate($row["DATE"])."</div></TD>".
       "<TD width=300 colspan=2 valign=top ".(($sortOrder=="pilotName" || $sortOrder=="takeoffID")?"bgcolor=".$sortRowBgColor:"").">".
			"<div align=left>".
			"<a href='?name=$module_name&op=pilot_profile&pilotIDview=".$row["userID"]."'><img src='".$moduleRelPath."/img/icon_magnify_small.gif' border=0></a>". 	   
			"<a href='?name=$module_name&op=pilot_profile_stats&pilotIDview=".$row["userID"]."'><img src='".$moduleRelPath."/img/icon_stats.gif' border=0></a>&nbsp;".
			"<a href='?name=$module_name&op=list_flights&pilotID=".$row["userID"]."'>$name</a>".
		"</div><div align=right>".
		//    "</div></TD>". 	   
	   // "<TD ".(($sortOrder=="takeoffID")?"bgcolor=".$sortRowBgColor:"").">".
		//	"<div align=left>".
			"<a href='?name=$module_name&op=list_flights&takeoffID=".$row["takeoffID"]."'>$takeoffNameFrm</a>&nbsp;".			
			"<a href='?name=$module_name&op=show_waypoint&waypointIDview=".$row["takeoffID"]."'><img src='".$moduleRelPath."/img/icon_magnify_small.gif' border=0></a>".
			"<a href='".$moduleRelPath."/download.php?type=kml_wpt&wptID=".$row["takeoffID"]."'><img src='".$moduleRelPath."/img/gearth_icon.png' border=0></a>".

			"</div></TD>".
	   "<TD ".(($sortOrder=="DURATION")?"bgcolor=".$sortRowBgColor:"")."><div align=right>".sec2Time($row['DURATION'],1)."</div></TD>
	   <TD ".(($sortOrder=="LINEAR_DISTANCE")?"bgcolor=".$sortRowBgColor:"")."><div align=right>".formatDistanceOpen($row["LINEAR_DISTANCE"])."</div></TD>	
	   <TD ".(($sortOrder=="FLIGHT_KM")?"bgcolor=".$sortRowBgColor:"")."><div align=right>".formatDistanceOpen($row["FLIGHT_KM"])."</div></TD>	
	   <TD ".(($sortOrder=="FLIGHT_POINTS")?"bgcolor=".$sortRowBgColor:"")."><div align=right>".formatOLCScore($row["FLIGHT_POINTS"])."</div></TD>".
	   "<td><img src='".$moduleRelPath."/img/icon_cat_".$row["cat"].".png' border=0></td>".
	   "<TD align=left><a href='?name=$module_name&op=show_flight&flightID=".$row["ID"]."'><img src='".$moduleRelPath."/img/icon_magnify_small.gif' border=0></a>";
	   echo "<a href='".$moduleRelPath."/download.php?type=kml_trk&flightID=".$row["ID"]."'><img src='".$moduleRelPath."/img/gearth_icon.png' border=0></a>";

  	   if ($row["photo1Filename"]) echo "<img src='".$moduleRelPath."/img/photo_icon.jpg' width=16 height=16>";
  	   else echo "<img src='".$moduleRelPath."/img/photo_icon_blank.gif' width=16 height=16>";
	   if ($row["userID"]==$userID || in_array($userID,$admin_users) ) {  // admin IDS in $admin_users
			echo "<a href='?name=$module_name&op=delete_flight&flightID=".$row["ID"]."'><img src='".$moduleRelPath."/img/x_icon.gif' width=16 height=16 border=0 align=bottom></a>"; 
			echo "<a href='?name=$module_name&op=edit_flight&flightID=".$row["ID"]."'><img src='".$moduleRelPath."/img/change_icon.png' width=16 height=16 border=0 align=bottom></a>"; 
	   }
	 
	   echo "</TD>";	  
  	 close_tr();
   }     
   close_inner_table();       
   mysql_freeResult($res);
}



?>
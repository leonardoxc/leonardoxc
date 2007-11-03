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
  $legend=_MSG_MENU_CLUBS_MSG_;
  /*
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
	$legend.=" <b>[ ALL TIMES ]</b> ";
  }
  */
  if ($country) {
		$where_clause.=" AND  countryCode='".$country."' ";
		$legend.=" (".$countries[$country].") | ";
  }    

  $sortDescArray=array("countryCode"=>_DATE_SORT, "FlightsNum"=>_NUMBER_OF_FLIGHTS, "max_distance"=>_SITE_RECORD_OPEN_DISTANCE  );
 
  $sortDesc=$sortDescArray[ $sortOrder];
  $ord="DESC";
  if ($sortOrder =='CountryCode' || $sortOrder =='intName' )   $ord="ASC";

  $sortOrderFinal=$sortOrder;
  
  $filter_clause=$_SESSION["filter_clause"];
  $where_clause.=$filter_clause;


//-----------------------------------------------------------------------------------------------------------

  	$query="SELECT $clubsTable.*  , count($clubsPilotsTable.pilotID)  as pilotsCount
	FROM $clubsPilotsTable,$clubsTable  
	WHERE $clubsPilotsTable.clubID=$clubsTable.ID  
".$where_clause." GROUP BY $clubsTable.ID ORDER BY $sortOrderFinal ".$ord." ";	
    // echo $query;
	$res= $db->sql_query($query);		
    if($res <= 0){
		echo "no takeoffs found <br>";
		return ;
    }

  listTakeoffs($res,$legend,$query_str,$sortOrder);


function printHeaderTakeoffs($width,$headerSelectedBgColor,$headerUnselectedBgColor,$sortOrder,$fieldName,$fieldDesc,$query_str) {
  global $moduleRelPath;
  global $Theme,$module_name;

  if ($width==0) $widthStr="";
  else  $widthStr="width='".$width."'";

  if ($sortOrder==$fieldName) { 
   echo "<td $widthStr bgcolor='$headerSelectedBgColor'>
		<div class='whiteLetter' align=left>
		<a href='".CONF_MODULE_ARG."&op=list_takeoffs&sortOrder=$fieldName$query_str'>$fieldDesc<img src='$moduleRelPath/img/icon_arrow_down.png' border=0  width=10 height=10></div></td>";
  } else {  
   echo "<td $widthStr bgcolor='$headerUnselectedBgColor'>
		<div align=left>
		<a href='".CONF_MODULE_ARG."&op=list_takeoffs&sortOrder=$fieldName$query_str'>$fieldDesc</div></td>";
   } 
}

function listTakeoffs($res,$legend, $query_str="",$sortOrder="CountryCode") {
   global $db,$Theme;
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
   open_inner_table("<table class=main_text width=100%><tr><td>$legend</td><td width=300 align=right bgcolor=#eeeeee>$legendRight</td></tr></table>",750);
  ?>
  <td width="25" bgcolor="<?=$Theme->color1?>"><div align=left><? echo _NUM ?></div></td>
 <?

   printHeaderTakeoffs(120,$headerSelectedBgColor,$Theme->color0,$sortOrder,"CountryCode",_COUNTRY,$query_str) ;
   printHeaderTakeoffs(0,$headerSelectedBgColor,$Theme->color2,$sortOrder,"clubName",_CLUB_NAME,$query_str) ;
   printHeaderTakeoffs(120,$headerSelectedBgColor,$Theme->color3,$sortOrder,"FlightsNum",_NUMBER_OF_FLIGHTS,$query_str) ;
   printHeaderTakeoffs(100,$headerSelectedBgColor,$Theme->color4,$sortOrder,"max_distance",_SITE_RECORD_OPEN_DISTANCE,$query_str) ;

?>
</tr>
<?

   $currCountry="";
   $i=1;
   while ($row = $db->sql_fetchrow($res)) { 
  
	 $takeoffName=$row["name"];	
	 //	 $sortRowBgColor=($i%2)?"#CCCACA":"#E7E9ED"; 
     $sortRowBgColor="#E7E9ED"; 
     $bgcolor="";
	if ( $countries[$row["countryCode"]] != $currCountry || $sortOrder!='CountryCode' ) {
		$currCountry=$countries[$row["countryCode"]] ;
		$country_str= "<div align=left>".
			"<a href='".CONF_MODULE_ARG."&op=list_clubs&country=".$row["countryCode"]."'>".$currCountry."</a>". 	   
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
			 "<div align=left>".
			 "<a href='".CONF_MODULE_ARG."&op=show_club&clubIDview=".$row["ID"]."'><img src='".$moduleRelPath."/img/icon_magnify_small.gif' border=0></a>".
			"&nbsp;".
			 "<a href='".CONF_MODULE_ARG."&op=list_flights&clubID=".$row["ID"]."'>".$takeoffName."</a>".			
			 "</div></TD>";
  		echo "<TD ".(($sortOrder=="LINEAR_DISTANCE")?"bgcolor=".$sortRowBgColor:"")."><div align=right>".$row["FlightsNum"]." (<a href='".CONF_MODULE_ARG."&op=list_flights&clubID=".$row["ID"]."'>"._SHOW_FLIGHTS."</a>)</div></TD>	";
	   	echo "<TD ".(($sortOrder=="LINEAR_DISTANCE")?"bgcolor=".$sortRowBgColor:"")."><div align=right>".formatDistanceOpen($row["max_distance"])."</div></TD>	";
  	 close_tr();
   }     
   close_inner_table();       
   $db->sql_freeresult($res);
}

?>

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

	 $add_remove_mode=$_GET['a_r'];

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
 	 $query="SELECT * , $flightsTable.takeoffID as flight_takeoffID ,$flightsTable.ID as ID FROM $flightsTable,".$prefix."_users".$extra_table_str."  WHERE ".$flightsTable.".userID=".$prefix."_users.user_id ".
						$where_clause." ORDER BY ".$sortOrderFinal ." ".$ord." LIMIT $startNum,".$PREFS->itemsPerPage;
     
  else  {
	 $query="SELECT * , $flightsTable.takeoffID as flight_takeoffID , $flightsTable.ID as ID FROM $flightsTable ".$extra_table_str."  WHERE (1=1) ".
						$where_clause." ORDER BY ".$sortOrderFinal ." ".$ord." LIMIT $startNum,".$PREFS->itemsPerPage ;
  }
  // echo $query;
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

<script type="text/javascript" src="<?=$moduleRelPath ?>/tipster.js"></script>
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

// Here's a second demo tip object. Feel free to delete it if you're not using it!
// I've included a tip header here in this template, %3% is the header text and %4% is
// now the main text. As you can see you can basically format your tips any way you want.
// This tip also includes mouse event handlers to show a second-level tip, just like in
// the body of the page below, so you can nest tips within tips, and a 'tipStick' of 0 so
// it never follows the mouse.
var staticTip = new TipObj('staticTip');
with (staticTip)
{
 // I'm using tables here for legacy NS4 support, but feel free to use styled DIVs.
 template = '<table bgcolor="#000000" cellpadding="0" cellspacing="0" width="%2%" border="1">' +
  '<tr><td><table bgcolor="#F4F8E2" cellpadding="3" cellspacing="1" width="100%" border="0" class="tipClass main_text">' +
  '<tr><td bgcolor="#DCDBCA" align=center class="main_text"><b>%4%</b></td></tr>'+
  '<tr><td align="left">'+
	"<img src='<?=$moduleRelPath?>/img/icon_pilot.gif' border=0 align='absmiddle'> <a href='?name=<?=$module_name?>&op=pilot_profile&pilotIDview=%3%'><? echo _Pilot_Profile ?></a>"+
	'</td></tr>'+
    '<tr><td align="left">'+

	"<img src='<?=$moduleRelPath?>/img/icon_magnify_small.gif' border=0 align='absmiddle'> <a href='?name=<?=$module_name?>&op=list_flights&year=0&month=0&pilotID=%3%&takeoffID=0&country=0&cat=0&clubID=0'><? echo _PILOT_FLIGHTS ?></a>"+
	'</td></tr>'+
    '<tr><td align="left">'+

	"<img src='<?=$moduleRelPath?>/img/icon_stats.gif' border=0 align='absmiddle'> <a href='?name=<?=$module_name?>&op=pilot_profile_stats&pilotIDview=%3%'><? echo _flights_stats ?></a>"+

	<?  if ($opMode==2)  { ?>// phpbb only 
	'</td></tr>'+
    '<tr><td align="left">'+
	"<img src='<?=$moduleRelPath?>/img/icon_user.gif' alt='PM this user' width=16 height=16 border=0 align='absmiddle'> <a href='/privmsg.php?mode=post&u=%3%'><? echo "PM" ?></a>"+
    <? } ?>

	'</td></tr>' +
  '</table></td></tr></table>';

 tipStick = 0;
 showDelay = 0;
 hideDelay = 0;
 doFades = false;
}

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

	"<img src='<?=$moduleRelPath?>/img/icon_magnify_small.gif' align='absmiddle' border=0> <a href='?name=<?=$module_name?>&op=list_flights&takeoffID=%3%'><? echo  _See_flights_near_this_point ?></a>"+
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
<div id="staticTipLayer" class="shadowBox" style="position: absolute; z-index: 10000; visibility: hidden;
 left: 0px; top: 0px; width: 10px">&nbsp;</div>
<div id="takeoffTipLayer" class="shadowBox" style="position: absolute; z-index: 10000; visibility: hidden;
 left: 0px; top: 0px; width: 10px">&nbsp;</div>
<?

function printHeader($width,$sortOrder,$fieldName,$fieldDesc,$query_str) {
  global $moduleRelPath;
  global $Theme,$module_name;

  if ($width==0) $widthStr="";
  else  $widthStr="width='".$width."'";

  if ($sortOrder==$fieldName) { 
   echo "<td class='activeSortHeader' $widthStr>	
		<a href='?name=$module_name&op=list_flights&sortOrder=$fieldName$query_str'>$fieldDesc<img src='$moduleRelPath/img/icon_arrow_down.png' border=0  width=10 height=10></td>";
  } else {  
   echo "<td class='inactiveSortHeader' $widthStr>
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
	 
   $headerSelectedBgColor="#F2BC66";
  // openBox(

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
   
//   "<table class='main_text listTableTitle' width=100% cellpadding=0 cellspacing=0><tr><td>$legend</td><td valign=top width=400 align=right>$legendRight</td></tr></table>"
  echo  "<div class='tableTitle shadowBox'>
   <div class='titleDiv'>$legend</div>
   <div class='pagesDiv'>$legendRight</div>
   </div>" ;
  // ,750,"#ffffff");
 //  openBox($legendRight,750);
   // open_inner_table("<table class=main_text width=100%><tr><td>$legend</td><td valign=top width=400 align=right bgcolor=#eeeeee>$legendRight</td></tr></table>",750,-1);
  ?>
  	<table class='listTable shadowBox' width="100%">
	<tr> 

  <td  class='inactiveSortHeader alRight' width="25" bgcolor="<?=$Theme->color1?>"><? echo _NUM ?></td>
 <?
   printHeader(80,$sortOrder,"DATE",_DATE_SORT,$query_str) ;
   printHeader(160,$sortOrder,"pilotName",_PILOT,$query_str) ;
   printHeader(0,$sortOrder,"takeoffID",_TAKEOFF,$query_str) ;
   printHeader(40,$sortOrder,"DURATION",_DURATION_HOURS_MIN,$query_str) ;
   printHeader(65,$sortOrder,"LINEAR_DISTANCE",_LINEAR_DISTANCE,$query_str) ;
   printHeader(65,$sortOrder,"FLIGHT_KM",_OLC_KM,$query_str) ;
   printHeader(40,$sortOrder,"FLIGHT_POINTS",_OLC_SCORE,$query_str) ;
?>
  <td width="18" class='inactiveSortHeader'>&nbsp;</td>
  <td width="72" class='inactiveSortHeader'><div align=left><? echo _SHOW ?></div></td></tr>
<?
   $i=1;
   $currDate="";
   while ($row = mysql_fetch_assoc($res)) { 
     $is_private=$row["private"];
	 $flightID=$row['ID'];

     $name=getPilotRealName($row["userID"]);
	 $takeoffName=getWaypointName($row["flight_takeoffID"]);
	 $takeoffVinicity=$row["takeoffVinicity"];
	 $takeoffNameFrm=	formatLocation($takeoffName,$takeoffVinicity,$takeoffRadious );

	 $sortRowBgColor=($i%2)?"#CCCACA":"#E7E9ED"; 
	 
	 $sortRowClassSorted=($i%2)?"l_row1Sorted":"l_row2"; 
	 $sortRowClass=($i%2)?"l_row1":"l_row2"; 
	 
	 
	 global $sortDescArray;
	 foreach($sortDescArray as $sOrder=>$sName) {
	 	if ( $sOrder==$sortOrder ) $sortArrayStr[$sOrder]=" class='$sortRowClassSorted' ";
	 	else $sortArrayStr[$sOrder]="";
	 	
	 }
	 
	 $i++;
	 // open_tr();
	 echo "\n\n<tr class='$sortRowClass'>";
	   $days_from_submission =	floor( ( mktime() - datetime2UnixTimestamp($row["dateAdded"]) ) / 86400 );  // 60*60*24 sec per day

	   if ( $is_private ) $first_col_back_color=" bgcolor=#33dd33 ";
	   else  $first_col_back_color="";
	   echo  
		"<TD $first_col_back_color class='alRight' >".($i-1+$startNum)."</TD>      
	   <TD valign=top ".(($sortOrder=="DATE")?"bgcolor=".$sortRowBgColor:"").">
			<div align=right>";
	   
  	   

  	   	if ( $row["DATE"] != $currDate || $sortOrder!='DATE' ) {
  	   		 $currDate=$row["DATE"];  	   		
  	   		 $dateStr= formatDate($row["DATE"]);
  	   		
  	   	} else {
  	   		$dateStr="";  	   		 
  	   	}

  	   if ( $days_from_submission <= 3 ) $dateStr.="<img src='".$moduleRelPath."/img/icon_new.png' >";			
  	   

	   $duration=sec2Time($row['DURATION'],1);
	   $linearDistance=formatDistanceOpen($row["LINEAR_DISTANCE"]);
	   $olcDistance=formatDistanceOpen($row["FLIGHT_KM"]);
	   $olcScore=formatOLCScore($row["FLIGHT_POINTS"]);
	   echo $dateStr."</div></TD>".
       "<TD width=300 colspan=2 ".$sortArrayStr["pilotName"].$sortArrayStr["takeoffID"].">".
			"<div align=left>";
//			"<a href='?name=$module_name&op=pilot_profile&pilotIDview=".$row["userID"]."'><img src='".$moduleRelPath."/img/icon_magnify_small.gif' border=0></a>".
//			"<a href='?name=$module_name&op=pilot_profile_stats&pilotIDview=".$row["userID"]."'><img src='".$moduleRelPath."/img/icon_stats.gif' border=0></a>";
//			if ($opMode==2) // phpbb only 
//				echo "<a href='/privmsg.php?mode=post&u=".$row["userID"]."'><img src='".$moduleRelPath."/img/icon_user.gif' alt='PM this user' width=16 height=16 border=0 align=bottom></a>"; 

//			echo "&nbsp;<a href='?name=$module_name&op=list_flights&pilotID=".$row["userID"]."'>$name</a>".
//			echo "&nbsp;";
			echo "<a href=\"javascript:staticTip.newTip('inline', -40, -40, 200, '".$row["userID"]."','$name' )\" onclick=\"staticTip.newTip('inline', -40, -40, 200, '".$row["userID"]."','$name' )\"  onmouseout=\"staticTip.hide()\">$name</a>".
		"</div>".
		"<div align=right>";
		//    "</div></TD>". 	   
	   // "<TD ".(($sortOrder=="takeoffID")?"bgcolor=".$sortRowBgColor:"").">".
		//	"<div align=left>".
		
		//echo 		"<a href='?name=$module_name&op=list_flights&takeoffID=".$row["takeoffID"]."'>$takeoffNameFrm</a>&nbsp;".			
		//	"<a href='?name=$module_name&op=show_waypoint&waypointIDview=".$row["takeoffID"]."'><img src='".$moduleRelPath."/img/icon_magnify_small.gif' border=0></a>".
	//		"<a href='".$moduleRelPath."/download.php?type=kml_wpt&wptID=".$row["takeoffID"]."'><img src='".$moduleRelPath."/img/gearth_icon.png' border=0></a>".
			echo "<a href=\"javascript:takeoffTip.newTip('inline', -40,-40, 250, '".$row["takeoffID"]."','$takeoffName')\" onclick=\"takeoffTip.newTip('inline',-40,-40, 250, '".$row["takeoffID"]."','$takeoffName')\"  onmouseout=\"takeoffTip.hide()\">$takeoffNameFrm</a>".
			"</div></TD>".
	   "<TD ".$sortArrayStr["DURATION"].">$duration</TD>".
	   "<TD ".$sortArrayStr["LINEAR_DISTANCE"].">$linearDistance</TD>".
	   "<TD ".$sortArrayStr["FLIGHT_KM"].">$olcDistance</TD>".
	   "<TD ".$sortArrayStr["FLIGHT_POINTS"].">$olcScore</TD>".
	   "<td><img src='".$moduleRelPath."/img/icon_cat_".$row["cat"].".png' border=0></td>".
	   "<TD align=left><a href='?name=$module_name&op=show_flight&flightID=".$row["ID"]."'><img src='".$moduleRelPath."/img/icon_magnify_small.gif' border=0></a>";
		   	echo "<a href='".$moduleRelPath."/download.php?type=kml_trk&flightID=".$row["ID"]."'><img src='".$moduleRelPath."/img/gearth_icon.png' border=0></a>";
	
	  	   if ($row["photo1Filename"]) echo "<img src='".$moduleRelPath."/img/photo_icon.jpg' width=16 height=16>";
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
   //  close_inner_table();       
   // closeBox();       
   mysql_freeResult($res);
}


?>

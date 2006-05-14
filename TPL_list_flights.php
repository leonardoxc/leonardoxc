<?
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://leonardo.thenet.gr                                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

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

function getSortImage($width,$headerSelectedBgColor,$headerUnselectedBgColor,$sortOrder,$fieldName,$fieldDesc,$query_str) {
  global $moduleRelPath;
  global $Theme,$module_name;

  if ($width==0) $widthStr="";
  else  $widthStr="width='".$width."'";

  if ($sortOrder==$fieldName) { 
   return "<div class='whiteLetter' align=left><a href='?name=$module_name&op=list_flights&sortOrder=$fieldName$query_str'>$fieldDesc<img src='$moduleRelPath/img/icon_arrow_down.png' border=0  width=10 height=10></div>";
  } else {  
   return "<div align=left><a href='?name=$module_name&op=list_flights&sortOrder=$fieldName$query_str'>$fieldDesc</div>";
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

	global $cat;

	require $moduleRelPath."/CL_template.php";
	$Ltemplate = new LTemplate($moduleRelPath. '/templates/basic');

	$Ltemplate ->set_filenames(array(
		'body' => 'listFlights.php')
	);
	

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


	$Ltemplate->assign_vars(array(	
		'IMG_GEARTH'=> "<img src='".$moduleRelPath."/img/gearth_icon.png' border=0>",
		'IMG_LOOK'=>  "<img src='".$moduleRelPath."/img/icon_magnify_small.gif' border=0>",
		'IMG_STATS'=> "<img src='".$moduleRelPath."/img/icon_stats.gif' border=0>",
		'IMG_CAT'=> "<img src='".$moduleRelPath."/img/icon_cat_".$cat.".png' border=0>",

		'IMG_S1' =>   getSortImage(80,$headerSelectedBgColor,$Theme->color0,$sortOrder,"DATE",_DATE_SORT,$query_str) ,
		'IMG_S2' =>   getSortImage(160,$headerSelectedBgColor,$Theme->color0,$sortOrder,"pilotName",_PILOT,$query_str),
		'IMG_S3' =>   getSortImage(0,$headerSelectedBgColor,$Theme->color1,$sortOrder,"takeoffID",_TAKEOFF,$query_str) ,
		'IMG_S4' =>   getSortImage(40,$headerSelectedBgColor,$Theme->color2,$sortOrder,"DURATION",_DURATION_HOURS_MIN,$query_str) ,
		'IMG_S5' =>   getSortImage(50,$headerSelectedBgColor,$Theme->color3,$sortOrder,"LINEAR_DISTANCE",_LINEAR_DISTANCE,$query_str) ,
		'IMG_S6' =>   getSortImage(45,$headerSelectedBgColor,$Theme->color3,$sortOrder,"FLIGHT_KM",_OLC_KM,$query_str) ,
		'IMG_S7' =>   getSortImage(40,$headerSelectedBgColor,$Theme->color3,$sortOrder,"FLIGHT_POINTS",_OLC_SCORE,$query_str) ,

		"L_LEGEND"=>   $legend,
		"L_LEGEND_RIGHT"=>   $legendRight,		

	));
   

   $i=1;
   while ($row = mysql_fetch_assoc($res)) { 
    $is_private=$row["private"];

    $name=getPilotRealName($row["userID"]);

	 $takeoffName=getWaypointName($row["takeoffID"]);
	 $takeoffVinicity=$row["takeoffVinicity"];
	 $takeoffNameFrm=	formatLocation($takeoffName,$takeoffVinicity,$takeoffRadious );

	 $sortRowBgColor=($i%2)?"#D4D4D4":"#E7E9ED"; 
	 $i++;

  	 $days_from_submission =	floor( ( mktime() - datetime2UnixTimestamp($row["dateAdded"]) ) / 86400 );  // 60*60*24 sec per day

	 if ( $is_private ) $first_col_back_color=" bgcolor=#33dd33 ";
	 else  $first_col_back_color="";

	 if ( $days_from_submission <= 3 ) $new_icon= "<img src='".$moduleRelPath."/img/icon_new.png' width=12 height=12>";		
	 else $new_icon=="";

	 $catIcon="<img src='".$moduleRelPath."/img/icon_cat_".$row["cat"].".png' border=0>";
  	 if ($row["photo1Filename"]) $photoImg= "<img src='".$moduleRelPath."/img/photo_icon.jpg' width=16 height=16>";
  	 else $photoImg= "<img src='".$moduleRelPath."/img/photo_icon_blank.gif' width=16 height=16>";
	   
	 if ($row["userID"]==$userID || in_array($userID,$admin_users) ) {  // admin IDS in $admin_users
			$admin_op1="<a href='?name=$module_name&op=delete_flight&flightID=".$row["ID"]."'><img src='".$moduleRelPath."/img/x_icon.gif' width=16 height=16 border=0 align=bottom></a>"; 
			$admin_op2="<a href='?name=$module_name&op=edit_flight&flightID=".$row["ID"]."'><img src='".$moduleRelPath."/img/change_icon.png' width=16 height=16 border=0 align=bottom></a>"; 
	 } else {
		$admin_op1="";
		$admin_op2="";
 	 }
	

   	$Ltemplate->assign_block_vars('flightrow', array(	 	
		'NUM'=>($i-1+$startNum),
		'DATE' => formatDate($row["DATE"]),
		'PILOT_NAME'=> getPilotRealName($row["userID"]),
		'TAKEOFF'=> $takeoffNameFrm,
		'DURATION'=>	 sec2Time($row['DURATION'],1),
		'OPEN_DISTANCE'=>  formatDistance($row["LINEAR_DISTANCE"]),
		'OLC_DISTANCE'=> formatDistance($row["FLIGHT_KM"]),
		'OLC_SCORE'=> formatOLCScore($row["FLIGHT_POINTS"]),	
		'U_PILOT_PROFILE_VIEW'  => "?name=$module_name&op=pilot_profile&pilotIDview=".$row["userID"] ,
		'U_PILOT_PROFILE_STATS' => "?name=$module_name&op=pilot_profile_stats&pilotIDview=".$row["userID"] ,
		'U_PILOT_FLIGHTS' => "?name=$module_name&op=list_flights&pilotID=".$row["userID"],
		'U_WPT_SHOW'	 => "?name=$module_name&op=show_waypoint&waypointIDview=".$row["takeoffID"], 
		'U_WPT_KML'		 => $moduleRelPath."/download.php?type=kml_wpt&wptID=".$row["takeoffID"],
		'U_WPT_FLIGHTS'	 => "?name=$module_name&op=list_flights&takeoffID=".$row["takeoffID"],
		'U_FLIGHT_SHOW' =>	"?name=$module_name&op=show_flight&flightID=".$row["ID"],	

		'U_FLIGHT_KML' =>	$moduleRelPath."/download.php?type=kml_trk&flightID=".$row["ID"],	

		'BGCOLOR' => $sortRowBgColor ,
		'BGCOLOR_FIRST_ROW' => $first_col_back_color,
		'IMG_NEW' => $new_icon,
		'IMG_CAT' =>  $catIcon,
		'IMG_PHOTO' => $photoImg,
   
		'U_OP_1' => $admin_op1,
		'U_OP_2' => $admin_op2	
	));


   }      //for loop

	mysql_freeResult($res);  
   	$Ltemplate->pparse('body');

}

?>

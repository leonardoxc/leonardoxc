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


	// Version Martin Jursa 20.05.2007
	// Support for filtering by NACclubs via $_REQUEST[nacclub] added
	// computed column "SCORE_SPEED"=FLIGHT_KM/DURATION added



	require_once dirname(__FILE__)."/FN_brands.php";


	function replace_spaces($str) {
		return str_replace(" ","&nbsp;",$str);
	}

	$legend="";

	$sortOrder=makeSane($_REQUEST["sortOrder"]);
	if ( $sortOrder=="")  $sortOrder="DATE";

	$page_num=$_REQUEST["page_num"]+0;
	if ($page_num==0)  $page_num=1;

	if ($cat==0) $where_clause="";
	else $where_clause=" AND cat=$cat ";

	$query_str="";
	$legend="";
	$legend="<b>"._MENU_FLIGHTS."</b> ";

	if ($year && $month && $day &&  $CONF_use_calendar ) {
		$where_clause.=" AND DATE_FORMAT(DATE,'%Y%m%d') = ".sprintf("%04d%02d%02d",$year,$month,$day)." ";
	}else {
		if ($year && !$month ) {
			$where_clause.=" AND DATE >='".($year-1)."-10-10' AND DATE < '".$year."-10-10' ";
			//$where_clause.=" AND DATE_FORMAT(DATE,'%Y') = ".$year." ";
		}
		if ($year && $month ) {
			$where_clause.=" AND DATE_FORMAT(DATE,'%Y%m') = ".sprintf("%04d%02d",$year,$month)." ";
		}
	}

	if (! $year ) {
		//$legend.=" <b>[ "._ALL_TIMES." ]</b> ";
	}

	if ($pilotID!=0) {
		$where_clause.=" AND userID='".$pilotID."' ";
	}else {  // 0 means all flights BUT not test ones
		$where_clause.=" AND userID>0 ";
	}

	if ($takeoffID) {
		$where_clause.=" AND takeoffID='".$takeoffID."' ";
	}

	// Martin Jursa 18.05.2007
	// Support for NACclubs added
	if ($nacid && $nacclubid) {
		$where_clause.=" AND $flightsTable.NACid=$nacid AND $flightsTable.NACclubID=$nacclubid  ";
	}

	if ($country) {
		$where_clause_country.=" AND  $waypointsTable.countryCode='".$country."' ";
	}

	if ($sortOrder=="dateAdded" && $year ) $sortOrder="DATE";

	# Martin Jursa 20.05.2007; have all possible descriptions in this array
	$sortDescArray=array(
		"DATE"=>_DATE_SORT,"pilotName"=>_PILOT_NAME, "takeoffID"=>_TAKEOFF,
		"DURATION"=>_DURATION, "MEAN_SPEED"=>_MEAN_SPEED1, "SCORE_SPEED"=>_MEAN_SPEED1, "LINEAR_DISTANCE"=>_LINEAR_DISTANCE,
		"FLIGHT_KM"=>_OLC_KM, "FLIGHT_POINTS"=>_OLC_SCORE , "dateAdded"=>_DATE_ADDED
	);

	$sortDesc=$sortDescArray[ $sortOrder];
	$ord="DESC";


	# Martin Jursa 20.05.2007; min 20' of flight, otherwise some weird results occur
	$scoreSpeedSql="IF(DURATION<1200, 0, FLIGHT_KM*3.6/DURATION)";


	$sortOrderFinal=$sortOrder;

	$where_clause2="";
	$extra_table_str2="";
	if ($sortOrder=="pilotName") {
		if ($opMode==1) {
			$sortOrderFinal="CONCAT(name,username) ";
		}else {
			//if ($CONF_use_leonardo_names) $sortOrderFinal='username';
			//else $sortOrderFinal=$CONF_phpbb_realname_field;
			$sortOrderFinal=$CONF_phpbb_realname_field;
		}
		$where_clause2="  AND ".$flightsTable.".userID=".$prefix."_users.user_id ";
		$extra_table_str2=",".$prefix."_users";

		$ord="ASC";

	}else if ($sortOrder=="dateAdded") {
		$where_clause=" AND DATE_SUB(NOW(),INTERVAL 5 DAY) <  dateAdded  ";

	}else if ($sortOrder=="DATE") {
		$sortOrderFinal="DATE DESC, FLIGHT_POINTS ";

	}else if ($sortOrder=="SCORE_SPEED") {
		$sortOrderFinal="$scoreSpeedSql DESC, FLIGHT_POINTS ";
	}

	if ( ! ($pilotID>0 && $pilotID==$userID ) && !in_array($userID,$admin_users) ) {
		$where_clause.=" AND private=0 ";
	}
	//$filter_clause built

	$filter_clause=$_SESSION["filter_clause"];

	//  echo $filter_clause;
	//  echo ($NACclubID);
	//  print_r ($NACclubID);
	if ( strpos($filter_clause,"countryCode")=== false ) {
		$countryCodeQuery=0;
	}else {
		$countryCodeQuery=1;
	}

	$where_clause.=$filter_clause;

	if ($clubID)   {
		$add_remove_mode=makeSane($_GET['a_r'],1);
		$query_str.="&a_r=$add_remove_mode";

		require dirname(__FILE__)."/INC_club_where_clause.php";
	}

	if ($countryCodeQuery || $country)   {
		$where_clause.=" AND $flightsTable.takeoffID=$waypointsTable.ID ";
		$extra_table_str.=",".$waypointsTable;
	}else $extra_table_str.="";

	$where_clause.=$where_clause_country;


	$query="SELECT count(*) as itemNum FROM $flightsTable".$extra_table_str."  WHERE (1=1) ".$where_clause." ";
	//  echo "#count query#$query<BR>";
	$res= $db->sql_query($query);
	if($res <= 0){
		echo("<H3> Error in count items query! $query</H3>\n");
		exit();
	}

	$row = $db->sql_fetchrow($res);
	$itemsNum=$row["itemNum"];

	$startNum=($page_num-1)*$PREFS->itemsPerPage;
	$pagesNum=ceil($itemsNum/$PREFS->itemsPerPage);

/*
  if ($pilotID>=0 && 0) {
 	 $query="SELECT * , ".$pilotsTable.".countryCode as pilotCountryCode, $flightsTable.takeoffID as flight_takeoffID ,$flightsTable.ID as ID
			FROM $pilotsTable, $flightsTable,".$prefix."_users $extra_table_str
			WHERE ".$pilotsTable.".pilotID=".$prefix."_users.user_id  AND ".$flightsTable.".userID=".$prefix."_users.user_id ".$where_clause."
			ORDER BY ".$sortOrderFinal ." ".$ord." LIMIT $startNum,".$PREFS->itemsPerPage;

  } else  {
	 $query="SELECT * , ".$pilotsTable.".countryCode as pilotCountryCode,  $flightsTable.takeoffID as flight_takeoffID , $flightsTable.ID as ID
			FROM $pilotsTable, $flightsTable $extra_table_str
			WHERE ".$pilotsTable.".pilotID=".$prefix."_users.user_id  ".$where_clause."
			ORDER BY ".$sortOrderFinal ." ".$ord." LIMIT $startNum,".$PREFS->itemsPerPage ;
  }
*/

	/*
	if ($CONF_use_leonardo_names) {
		if ($PREFS->nameOrder==1) $nOrder="CONCAT(FirstName,' ',LastName)";
		else $nOrder="CONCAT(LastName,' ',FirstName)";
	} else {
		$nOrder='username';
	}
	*/
	$query="SELECT * , $flightsTable.takeoffID as flight_takeoffID , $flightsTable.ID as ID,$scoreSpeedSql AS SCORE_SPEED
		FROM $flightsTable $extra_table_str $extra_table_str2
		WHERE (1=1) $where_clause $where_clause2
		ORDER BY $sortOrderFinal $ord LIMIT $startNum,".$PREFS->itemsPerPage ;
	//echo $query;
	$res= $db->sql_query($query);

	if($res <= 0){
		echo("<H3> Error in query! </H3>\n");
		exit();
	}
/*

$pos = strpos($filter_clause, "NACclubID");

$chop = substr($filter_clause,$pos+14,3);
if ($chop{2}=="'"){$chop=substr($filter_clause,$pos+14,2);}
if ($chop{1}=="'"){$chop=substr($filter_clause,$pos+14,1);}

 if ($pos === false) {
  	$filter_name = "Alle Vereine";  }
         else      {
         $filter_name = $clubList[$chop];
         }
*/
	$legend.=" :: "._SORTED_BY."&nbsp;".replace_spaces($sortDesc); ///."&nbsp;"." :: ".($filter_name);
	$legendRight=generate_flights_pagination("?name=$module_name&op=list_flights&sortOrder=$sortOrder$query_str", $itemsNum,$PREFS->itemsPerPage,$page_num*$PREFS->itemsPerPage-1, TRUE);

	$endNum=$startNum+$PREFS->itemsPerPage;
	if ($endNum>$itemsNum) $endNum=$itemsNum;
	$legendRight.=" [&nbsp;".($startNum+1)."-".$endNum."&nbsp;"._From."&nbsp;".$itemsNum ."&nbsp;]";
	if ($itemsNum==0) $legendRight="[ 0 ]";

	echo  "<div class='tableTitle'>
	<div class='titleDiv'>$legend</div>
	<div class='pagesDiv' style='white-space:nowrap'>$legendRight</div>
	</div>" ;
	require_once dirname(__FILE__)."/MENU_second_menu.php";
	listFlights($res,$legend,	$query_str,$sortOrder);

?>
<style type="text/css">
TR .newDate {
	background-image:url(<?=$themeRelPath?>/img/bg_row.gif);
	background-repeat:repeat-x;
}

.checkedBy , td.checkedBy , div.checkedBy {
	font-size:9px;
	font-family:Arial, Helvetica, sans-serif;
	line-height:9px;
	background-color:#D6ECD5;
	border:0;
	padding:0px;
	padding-left:1px;
	padding-right:1px;
	margin:0px;
	width:auto;
	display:block;
	float:right;
	clear:both;
	text-align:right;
}

</style>
<script type="text/javascript" src="<?=$moduleRelPath ?>/js/tipster.js"></script>
<? echo makePilotPopup(); ?>
<? echo makeTakeoffPopup(); ?>
<?
# Martin Jursa 20.05.2007: Support for non-sortable fields added (using $sort==false)
function printHeader($width,$sortOrder,$fieldName,$fieldDesc,$query_str, $sort=true) {
	global $moduleRelPath;
	global $Theme,$module_name;

	if ($width==0) $widthStr="";
	else  $widthStr="width='".$width."'";

	if ($fieldName=="pilotName") $alignClass="alLeft";
	else $alignClass="";

	if ($sort) {
		if ($sortOrder==$fieldName) {
			echo "<td class='SortHeader activeSortHeader $alignClass' $widthStr>	\n
				<a href='?name=$module_name&op=list_flights&sortOrder=$fieldName$query_str'>$fieldDesc<img src='$moduleRelPath/img/icon_arrow_down.png' border='0' alt='Sort order' width='10' height='10' />
				</td>\n";
		}else {
			echo "<td class='SortHeader $alignClass' $widthStr>
			<a href='?name=$module_name&op=list_flights&sortOrder=$fieldName$query_str'>$fieldDesc</a>
			</td>\n";
		}
	}else {
		echo "<td class='SortHeader $alignClass' $widthStr>
			$fieldDesc
		</td>\n";
	}
}

function listFlights($res,$legend, $query_str="",$sortOrder="DATE") {
   global $db,$Theme;
   global $module_name;
   global $takeoffRadious;
   global $userID;
   global $NACclubID;
   global $clubID,$clubFlights,$clubsList, $add_remove_mode;
   global $moduleRelPath;
   global $admin_users;
   global $PREFS;
   global $page_num,$pagesNum,$startNum,$itemsNum;
   global $currentlang,$nativeLanguage,$opMode;
   global $CONF_photosPerFlight,$CONF_use_validation,$CONF_airspaceChecks;
   global $gliderCatList,$brandsList;

   if ( $clubID  && (is_club_admin($userID,$clubID) || is_leo_admin($userID))  )  {
?>
<script type="text/javascript" src="<?=$moduleRelPath ?>/js/prototype.js"></script>
<script language="javascript">

function addClubFlight(clubID,flightID) {
	url='/<?=$moduleRelPath?>/EXT_club_functions.php';
	pars='op=add&clubID='+clubID+'&flightID='+flightID;

	var myAjax = new Ajax.Updater('updateDiv', url, {method:'get',parameters:pars});

	newHTML="<a href=\"#\" onclick=\"removeClubFlight("+clubID+","+flightID+");return false;\"><img src='<?=$moduleRelPath?>/img/icon_club_remove.gif' width=16 height=16 border=0 align=bottom></a>";
	div=MWJ_findObj('fl_'+flightID);
	div.innerHTML=newHTML;
	//toggleVisible(divID,divPos);
}

function removeClubFlight(clubID,flightID) {
	url='/<?=$moduleRelPath?>/EXT_club_functions.php';
	pars='op=remove&clubID='+clubID+'&flightID='+flightID;

	var myAjax = new Ajax.Updater('updateDiv', url, {method:'get',parameters:pars});

	newHTML="<a href=\"#\" onclick=\"addClubFlight("+clubID+","+flightID+");return false;\"><img src='<?=$moduleRelPath?>/img/icon_club_add.gif' width=16 height=16 border=0 align=bottom></a>";
	div=MWJ_findObj('fl_'+flightID);
	div.innerHTML=newHTML;
	//toggleVisible(divID,divPos);
}
</script>
<?
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



  ?>
  	<table class='listTable' width="100%" cellpadding="2" cellspacing="0">
	<tr>
	  <td class='SortHeader' width="25"><? echo _NUM ?></td>
		 <?
		   printHeader(60,$sortOrder,"DATE",_DATE_SORT,$query_str) ;
		   printHeader(160,$sortOrder,"pilotName",_PILOT,$query_str) ;
		   printHeader(0,$sortOrder,"takeoffID",_TAKEOFF,$query_str) ;
		   printHeader(40,$sortOrder,"DURATION",_DURATION_HOURS_MIN,$query_str) ;
		   # Martin Jursa, 20.05.2007; DHV customisation
		   printHeader(60,$sortOrder,"SCORE_SPEED",_MEAN_SPEED1,$query_str) ;
		   printHeader(60,$sortOrder,"FLIGHT_KM",_OLC_KM,$query_str) ;
		   printHeader(65,$sortOrder,"FLIGHT_POINTS",_OLC_SCORE,$query_str) ;
		?>
	  <td width="18" class='SortHeader'>&nbsp;</td>
  	  <td width="50" class='SortHeader'>&nbsp;</td>
	  <td width="82" class='SortHeader alLeft'><? echo _SHOW ?></td>
  </tr>
<?
   $i=1;
   $currDate="";
   while ($row = $db->sql_fetchrow($res)) {
     $is_private=$row["private"];
	 $flightID=$row['ID'];

     $name=getPilotRealName($row["userID"],1);
	 $name=prepare_for_js($name);

	 $takeoffName= prepare_for_js(getWaypointName($row["flight_takeoffID"]) );
	 $takeoffVinicity=$row["takeoffVinicity"];
	 $takeoffNameFrm=	formatLocation($takeoffName,$takeoffVinicity,$takeoffRadious );

	 $sortRowClass=($i%2)?"l_row1":"l_row2";
	 $i++;

	   $days_from_submission =	floor( ( mktime() - datetime2UnixTimestamp($row["dateAdded"]) ) / 86400 );  // 60*60*24 sec per day

	   if ( $is_private ) $first_col_back_color=" bgcolor=#33dd33 ";
	   else  $first_col_back_color="";

  	   if ( $row["DATE"] != $currDate || $sortOrder!='DATE' ) {
  	   		 $currDate=$row["DATE"];
  	   		 $dateStr= formatDate($row["DATE"]);
			$rowStr=" newDate ";
  	   } else {
  	   		$dateStr="&nbsp;";
			$rowStr="";
  	   }
  	   if ( $days_from_submission <= $CONF_new_flights_days_threshold  ) $dateStr.="<br><img src='".$moduleRelPath."/img/icon_new.png' width='31' height='12' />";

		echo "\n\n<tr class='$sortRowClass $rowStr'>\n";

	  	$duration=sec2Time($row['DURATION'],1);
        $linearDistance=formatDistanceOpen($row["LINEAR_DISTANCE"]);
        $olcDistance=formatDistanceOpen($row["FLIGHT_KM"]);

        # Martin Jursa 20.05.2007
        $scoreSpeed=formatSpeed($row["SCORE_SPEED"]);

        $olcScore=formatOLCScore($row["FLIGHT_POINTS"]);
	   	$gliderType=$row["cat"]; // 1=pg 2=hg flex 4=hg rigid 8=glider

		// get the OLC score type
		$olcScoreType=$row['BEST_FLIGHT_TYPE'];
		if ($olcScoreType=="FREE_FLIGHT") {
			$olcScoreTypeImg="icon_turnpoints.gif";
		} else if ($olcScoreType=="FREE_TRIANGLE") {
			$olcScoreTypeImg="icon_triangle_free.gif";
		} else if ($olcScoreType=="FAI_TRIANGLE") {
			$olcScoreTypeImg="icon_triangle_fai.gif";
		} else {
			$olcScoreTypeImg="photo_icon_blank.gif";
		}

	   $brandID=guessBrandID($gliderType,$row['glider']);
	   if ($brandID) $gliderBrandImg="<img src='$moduleRelPath/img/brands/$gliderType/".sprintf("%03d",$brandID).".gif' width='50' height='24' border='0' />";
	   else $gliderBrandImg="&nbsp;";

	/*   if ($brandID) $gliderBrandImg="<img src='$moduleRelPath/img/brands/$gliderType/".sprintf("%03d",$brandID).".gif'
			title='".$row['glider']."' border='0' />";
	    else $gliderBrandImg="&nbsp;";
	*/

		$gliderBrandImg="<img src='$moduleRelPath/img/brands/$gliderType/".sprintf("%03d",$brandID).".gif'
			title='".$row['glider']."' border='0' />";

	   echo "\t<TD $first_col_back_color class='dateString'><div>".($i-1+$startNum)."</div></TD>";
	   echo "<TD class='dateString' valign='top'><div>$dateStr</div></TD>".
       "<TD width=300 colspan=2 ".$sortArrayStr["pilotName"].$sortArrayStr["takeoffID"].">".
		"<div id='p_$i' class='pilotLink'>";

		//echo  getNationalityDescription($row["pilotCountryCode"],1,0);
		echo " <a href=\"javascript:pilotTip.newTip('inline', 0, 13, 'p_$i', 200, '".$row["userID"]."','".addslashes($name)."' )\"  onmouseout=\"pilotTip.hide()\">$name</a>\n";
		echo "</div>";
		echo "<div id='t_$i' class='takeoffLink'>";
		echo "<a href=\"javascript:takeoffTip.newTip('inline',25, 13,'t_$i', 250, '".$row["takeoffID"]."','".addslashes($takeoffName)."')\"  onmouseout=\"takeoffTip.hide()\">$takeoffNameFrm</a>\n";

		# Martin Jursa 20.05.2007: DHV customisation using score speed
		# NOTE: is there really a css class called 'speed'????
		echo "</div></TD>".
	   "<TD>$duration</TD>".
            "<TD class='speed'>$scoreSpeed</TD>".
            "<TD class='distance'>$olcDistance</TD>".
            "<TD nowrap class='OLCScore'>$olcScore&nbsp;<img src='".$moduleRelPath."/img/$olcScoreTypeImg' alt='".formatOLCScoreType($olcScoreType,0)."' border='0' width='16' height='16' align='top' />";

		if ($CONF_use_validation) {
			$isValidated=$row['validated'];
			if ($isValidated==-1) $vImg="icon_valid_nok.gif";
			else if ($isValidated==0) $vImg="icon_valid_unknown.gif";
			else if ($isValidated==1) $vImg="icon_valid_ok.gif";

			$valStr="<img class='listIcons' src='".$moduleRelPath."/img/$vImg' width='12' height='12' border='0' />";
			echo $valStr;
		}
	   echo "</TD>";
	   echo "<TD><img src='".$moduleRelPath."/img/icon_cat_".$row["cat"].".png' alt='".$gliderCatList[$row["cat"]]."' width='16' height='16' border='0' /></td>".
   	   "\n\t<TD><div align='center'>$gliderBrandImg</div></td>";

		if ($CONF_airspaceChecks && in_array($userID,$admin_users) ) {
			if ( $row['airspaceCheckFinal']==-1 ) {
				$airspaceProblem=' bgcolor=#F7E5C9 ';
			} else
				$airspaceProblem='';
		}

	    echo "<TD $airspaceProblem align=left><a href='?name=$module_name&op=show_flight&flightID=".$row["ID"]."'><img class='listIcons' src='".$moduleRelPath."/img/icon_look.gif' border=0 valign=top title='"._SHOW."'  width='16' height='16' /></a>";
	    echo "<a href='".$moduleRelPath."/download.php?type=kml_trk&flightID=".$row["ID"]."&lang=$lng'><img class='listIcons' src='".$moduleRelPath."/img/gearth_icon.png' border=0 valign=top title='"._Navigate_with_Google_Earth."' width='16' height='16' /></a>";

		$photos_exist=0;
		for($photo_i=1;$photo_i<$CONF_photosPerFlight;$photo_i++) {
			if ($row["photo".$photo_i."Filename"]) {
				$photos_exist=1; break;
			}
		}
	   if ($photos_exist) echo "<img  class='listIcons'src='".$moduleRelPath."/img/icon_camera.gif' width='16' height='16' valign='top' />";
	   else echo "<img class='listIcons' src='".$moduleRelPath."/img/photo_icon_blank.gif' width='16' height='16' />";


	   if ($row["userID"]==$userID || in_array($userID,$admin_users) ) {  // admin IDS in $admin_users
			echo "<a href='?name=$module_name&op=delete_flight&flightID=".$row["ID"]."'><img src='".$moduleRelPath."/img/x_icon.gif' width='16' height='16' border='0' align='bottom' /></a>";
			echo "<a href='?name=$module_name&op=edit_flight&flightID=".$row["ID"]."'><img src='".$moduleRelPath."/img/change_icon.png' width='16' height='16' border='0' align='bottom' /></a>";
	   }

		$checkedByStr='';
		if ($row['checkedBy'] && in_array($userID,$admin_users)){
			$checkedByArray=explode(" ",$row['checkedBy']);
			$checkedByStr="<div class='checkedBy' align=right>".$checkedByArray[0]."</div>";
			echo $checkedByStr;
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


	   echo "</TD>\n";
  	   echo "</TR>";
   }
   echo "</table>\n\n"  ;
   $db->sql_freeresult($res);
}


?>
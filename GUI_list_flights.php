<?
//************************************************************************
// Leonardo XC Server, http://www.leonardoxc.net
//
// Copyright (c) 2004-2010 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: GUI_list_flights.php,v 1.125 2012/01/16 07:21:22 manolis Exp $                                                                 
//
//************************************************************************

	// Version Martin Jursa 20.05.2007
	// Support for filtering by NACclubs via $_REQUEST[nacclub] added
	// computed column "SCORE_SPEED"=FLIGHT_KM/DURATION added
	

	$legend="";
	$legend="<b>"._MENU_FLIGHTS."</b> ";

if (0) {	
	$sortOrder=makeSane($_REQUEST["sortOrder"]);
	if ( $sortOrder=="")  $sortOrder="DATE";
	
	$page_num=$_REQUEST["page_num"]+0;
	if ($page_num==0)  $page_num=1;
	
	if ($cat==0) $where_clause="";
	else $where_clause=" AND cat=$cat ";
	
	$queryExtraArray=array();
	$legend="";
	$legend="<b>"._MENU_FLIGHTS."</b> ";
	
	// SEASON MOD
	if (! $clubID) { // if we are viewing a club, the dates will be taken care wit hthe CLUB code
		$where_clause.= dates::makeWhereClause(0,$season,$year,$month,($CONF_use_calendar?$day:0) );
	}
	
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
	
	if ($class) {
		$where_clause.=" AND  $flightsTable.category='".$class."' ";
	}

	if ($xctype) {
		$where_clause.=" AND  $flightsTable.BEST_FLIGHT_TYPE='".$CONF_xc_types_db[$xctype]."' ";
	}

	
	if ($sortOrder=="dateAdded" && $year ) $sortOrder="DATE";

	# Martin Jursa 20.05.2007; have all possible descriptions in this array
	$sortDescArray=array(
		"DATE"=>_DATE_SORT,"pilotName"=>_PILOT_NAME, "takeoffID"=>_TAKEOFF,
		"DURATION"=>_DURATION, "MEAN_SPEED"=>_MEAN_SPEED1, "SCORE_SPEED"=>_MEAN_SPEED1,
		"LINEAR_DISTANCE"=>_LINEAR_DISTANCE,
		"FLIGHT_KM"=>_OLC_KM, "FLIGHT_POINTS"=>_OLC_SCORE , "dateAdded"=>_DATE_ADDED
	);


	$sortDesc=$sortDescArray[ $sortOrder];
	$ord="DESC";


	# Martin Jursa 20.05.2007; min 20' of flight, otherwise some weird results occur
	$scoreSpeedSql="IF (DURATION<1200, 0, FLIGHT_KM*3.6/DURATION)";


	$sortOrderFinal=$sortOrder;
	
	$pilotsTableQuery=0;
	$pilotsTableQuery2=0;
	
	$where_clause2="";
	$extra_table_str2="";
	if ($sortOrder=="pilotName") { 
	 if ($opMode==1) { 
		$sortOrderFinal="CONCAT(name,username) ";
	 } else {
		//if ($CONF_use_leonardo_names) $sortOrderFinal='username';
		//else $sortOrderFinal=$CONF_phpbb_realname_field;
		 $sortOrderFinal=$CONF['userdb']['user_real_name_field'];
	
		if ($PREFS->nameOrder==1) $sortOrderFinal="CONCAT(FirstName,' ',LastName) ";
		else $sortOrderFinal="CONCAT(LastName,' ',FirstName) ";
	 }
	
	 if ( $CONF['userdb']['use_leonardo_real_names'] ) { // use the leonardo_pilots table 
		 $pilotsTableQuery2=1;
	 } else {
		 $where_clause2="  AND ".$flightsTable.".userID=".$CONF['userdb']['users_table'].".".$CONF['userdb']['user_id_field'] ;
		 $extra_table_str2=",".$CONF['userdb']['users_table'];
	 }
	
	 $ord="ASC";
	}  else if ($sortOrder=="dateAdded") { 
	 $where_clause=" AND DATE_SUB(NOW(),INTERVAL 5 DAY) <  dateAdded  ";
	}  else if ($sortOrder=="DATE") { 
	 $sortOrderFinal="DATE DESC, FLIGHT_POINTS ";
	} else if ($sortOrder=="SCORE_SPEED") {
		$sortOrderFinal="$scoreSpeedSql DESC, FLIGHT_POINTS ";
	}
	
	if ( ! ($pilotID>0 && $pilotID==$userID ) && !L_auth::isAdmin($userID) ) {
		$where_clause.=" AND private=0 ";
	} 
	
	$filter_clause=$_SESSION["filter_clause"];
	//echo $filter_clause;
	if ( strpos($filter_clause,"countryCode")=== false )  $countryCodeQuery=0;	
	else {
			if ( strpos($filter_clause,$pilotsTable.".countryCode")=== false )  $countryCodeQuery=1;
			else {
				$pilotsTableQuery=1;
				if ( strpos($filter_clause," countryCode") )  $countryCodeQuery=1;
				else $countryCodeQuery=0;
			}
	}

	if ( ! strpos($filter_clause,$pilotsTable.".Sex")=== false )  $pilotsTableQuery=1;
	
	
	$where_clause.=$filter_clause;
	
	if ($clubID)   {
	 $add_remove_mode=makeSane($_REQUEST['admClub'],1);
	 $queryExtraArray+=array("admClub"=>$add_remove_mode);
	
	 require dirname(__FILE__)."/INC_club_where_clause.php";
	} 
	
	if ($countryCodeQuery || $country)   {
	 $where_clause.=" AND $flightsTable.takeoffID=$waypointsTable.ID ";
	 $extra_table_str.=",".$waypointsTable;
	} else $extra_table_str.="";

	 if ($pilotsTableQuery2 && !$pilotsTableQueryIncluded){
		$where_clause2="  AND $flightsTable.userID=$pilotsTable.pilotID AND $flightsTable.userServerID=$pilotsTable.serverID  ";	 
		$extra_table_str2.=",$pilotsTable";		
	}

	if ($pilotsTableQuery && !$pilotsTableQuery2 && !$pilotsTableQueryIncluded){
		$where_clause.="  AND $flightsTable.userID=$pilotsTable.pilotID AND $flightsTable.userServerID=$pilotsTable.serverID  ";	
		$extra_table_str.=",$pilotsTable";
	}	 
	 		
	$where_clause.=$where_clause_country;
	
	$query="SELECT count(*) as itemNum FROM $flightsTable".$extra_table_str."  WHERE (1=1) ".$where_clause." ";
	// echo "#count query#$query<BR>";

	$res= $db->sql_query($query);
	if($res <= 0){   
	 echo("<H3> Error in count items query! $query</H3>\n");
	 exit();
	}
	
	$row = $db->sql_fetchrow($res);
	$itemsNum=$row["itemNum"];   
	
	$startNum=($page_num-1)*$PREFS->itemsPerPage;
	$pagesNum=ceil ($itemsNum/$PREFS->itemsPerPage);
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
	$query="SELECT * , 
			$flightsTable.glider as flight_glider, 
			$flightsTable.takeoffID as flight_takeoffID , 
			$flightsTable.ID as ID ,
			$scoreSpeedSql AS SCORE_SPEED
		FROM $flightsTable $extra_table_str $extra_table_str2
		WHERE (1=1) $where_clause $where_clause2
		ORDER BY $sortOrderFinal $ord LIMIT $startNum,".$PREFS->itemsPerPage ;
	// echo "<!-- $query -->"; 
	
	
	} // end if (0) -> now use the SQL_list_flights
	
	
	
	require_once dirname(__FILE__).'/SQL_list_flights.php';
	$res= $db->sql_query($queryCount);
	if($res <= 0){   
	 echo("<H3> Error in count items query! $queryCount</H3>\n");
	 exit();
	}	
	$row = $db->sql_fetchrow($res);
	$itemsNum=$row["itemNum"];   
	
	$startNum=($page_num-1)*$PREFS->itemsPerPage;
	$pagesNum=ceil ($itemsNum/$PREFS->itemsPerPage);
	
	
	if ($_GET['igc_list'] && L_auth::isAdmin($userID) ) {
		require_once dirname(__FILE__)."/MENU_second_menu.php";
		// now the real query	
		$res= $db->sql_query($query);
		
		if($res <= 0){
		 echo("<H3> Error in query! </H3>\n");
		 exit();
		}
		
		echo "<pre>";
		
		$boundBox['minLat']=43.1589;
		$boundBox['maxLat']=48.1717;
		
		$boundBox['minLon']=6.11194;
		$boundBox['maxLon']=13.5261;

		
		while ($row = $db->sql_fetchrow($res)) { 
			if (! $row['filename'] ||
				  $row['MAX_LINEAR_DISTANCE'] < 10000 ||
				  $row['DURATION'] <3600 ||
				  ( $row['MAX_ALT'] -$row['TAKEOFF_ALT'])  < 100 
				) continue;
			
			//if ($row['firstLat'] < $boundBox['minLat'] || $row['firstLat'] > $boundBox['maxLat'] ) continue;			
			//if ($row['firstLon'] < $boundBox['minLon'] || $row['firstLon'] > $boundBox['maxLon'] ) continue;
			
			
			// if ($row['DATE'] < '2008-06-01' || $row['DATE']  > '2008-08-31' ) continue;
			
			//$igcPath=''; // $flightsAbsPath;
			//if ($row['userServerID']) 
			//	$igcPath.=$row['userServerID'].'_';
			//$igcPath.=$row['userID']."/flights/".substr($row['DATE'],0,4)."/".$row['filename']."\n";
			
			$igcPath=str_replace("%PILOTID%",getPilotID($row['userServerID'],$row['userID']),str_replace("%YEAR%",substr($row['DATE'],0,4),$CONF['paths']['igc']) ).'/'.$row['filename'];
			
			echo $igcPath;	
			$igcNum++;		
		}		
		echo "</pre>";
		echo "#flight found : $igcNum<BR>";
		exit;
	}
	
	if ($RUN['view']=='print' ) {
		
		 
		require_once dirname(__FILE__)."/CL_pdf.php";
		
		require_once dirname(__FILE__)."/MENU_second_menu.php";
		// now the real query	
		$res= $db->sql_query($query);
		
		if($res <= 0){
		 echo("<H3> Error in query! </H3>\n");
		 exit();
		}
		
		$tmpDir=md5($_SERVER['REQUEST_URI']);
		echo "START PDF\n";
		$num=0;
		
		$flightUrl=str_replace("list_flights","pilot_profile_stats","http://".$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]).'0';
		//$flightUrl="http://".$_SERVER['SERVER_NAME'].getLeonardoLink(array('op'=>'list_flights','print'=>1) );
		$flights[$num]=$flightUrl;
		
			
		// echo "<hr> url is ".$_SERVER['REQUEST_URI'].'<hr> path info is '.$_SERVER['PATH_INFO'].'<hr>';
		
		
		echo "PDF URL:$flightUrl\n";
		
		$num++;
		while ($row = $db->sql_fetchrow($res)) { 
			
			$flightUrl="http://".$_SERVER['SERVER_NAME'].getLeonardoLink(array('op'=>'show_flight','flightID'=>$row["ID"],'print'=>1) );
			$flights[$num]=$flightUrl;
			 
			echo "PDF URL:$flightUrl\n";
			
			$num++;
			if ($num>$CONF['pdf']['maxflightsPerPrint']) break;		
		}
		if ($RUN['remote']=='remote' ) {
			// no real proccess is done here
			echo "END PDF\n";
			exit;
		}
		
		//do {
		//	$tmpDir=rand(0,10000000);
		//} while (is_dir($CONF['pdf']['tmpPath'].'/'.$tmpDir)) ;
		// print_r($flights);
		$pdfFile=leoPdf::createPDFmulti($flights,$tmpDir);	

		// $pdfFile=$tmpDir.'/logbook.pdf';
		if ($pdfFile) {				
			echo "<a href='".$moduleRelPath.'/'.$CONF['pdf']['tmpPathRel'].'/'.$pdfFile."' target='_blank'>PDF is ready</a>";
			echo "\n\n".$moduleRelPath.'/'.$CONF['pdf']['tmpPathRel'].'/'.$pdfFile;
		} else {				
			echo "ERROR: PDF creation failed";
		}
		exit;
	}
	
	// Add the limit 
	$query.="LIMIT $startNum,".$PREFS->itemsPerPage;
	
	// now the real query	
	$res= $db->sql_query($query);
	
	if($res <= 0){
	 echo("<H3> Error in query! </H3>\n");
	 exit();
	}
	

	
	
	$legend.=" :: "._SORTED_BY."&nbsp;".replace_spaces($sortDesc);
	$legendRight=generate_flights_pagination(
			getLeonardoLink(array('op'=>'list_flights','sortOrder'=>$sortOrder)+$queryExtraArray),			
			$itemsNum,$PREFS->itemsPerPage,$page_num*$PREFS->itemsPerPage-1, TRUE); 

	$endNum=$startNum+$PREFS->itemsPerPage;
	if ($endNum>$itemsNum) $endNum=$itemsNum;
	$legendRight.=" [&nbsp;".($startNum+1)."-".$endNum."&nbsp;"._From."&nbsp;".$itemsNum ."&nbsp;]";
	if ($itemsNum==0) $legendRight="[ 0 ]";

	if (0)echo  "<div class='tableTitle'>
	<div class='titleDiv'>$legend</div>
	<div class='pagesDiv' style='white-space:nowrap'>$legendRight</div>
	</div>" ;

	require_once dirname(__FILE__)."/MENU_second_menu.php";
	
    echo "<div class='list_header'>
				<div class='list_header_r'></div>
				<div class='list_header_l'></div>
				<h1>$legend</h1>
				<div class='pagesDiv'>$legendRight</div>
			</div>";

	listFlights($res,$legend, $queryExtraArray,$sortOrder);
	//P.Wild 15.12.2008	
	echo "<div class='list_header list_header_bottom'>
				<div class='list_header_r list_header_r_bottom'></div>
				<div class='list_header_l list_header_l_bottom'></div>
				<h1>$legend</h1>
				<div class='pagesDiv'>$legendRight</div>
			</div>";

?>
<style type="text/css">
TR .newDate {
	background-image:url(<?=$themeRelPath?>/img/bg_row.gif);
	background-repeat:repeat-x;
}

.checkedBy1 , td.checkedBy1 , div.checkedBy1{
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
<link rel="stylesheet" href="<?=$moduleRelPath ?>/js/bettertip/jquery.bettertip.css" type="text/css" />

<script type="text/javascript" src="<?=$moduleRelPath ?>/js/bettertip/jquery.bettertip.js"></script>
<script type="text/javascript" src="<?=$moduleRelPath ?>/js/tipster.js"></script>
<script type='text/javascript' src='<?=$moduleRelPath ?>/js/xns.js'></script>
<script type="text/javascript">

var BT_base_urls=[];
BT_base_urls[0]='<?=$moduleRelPath?>/GUI_EXT_flight_info.php?op=info_short&flightID=';
BT_base_urls[1]='<?=$moduleRelPath?>/GUI_EXT_flight_info.php?op=photos&flightID=';
BT_base_urls[2]='<?=$moduleRelPath?>/GUI_EXT_flight_info.php?op=comments&flightID=';

var BT_displayOnSide=[];
BT_displayOnSide[0]='auto';
BT_displayOnSide[1]='left';
BT_displayOnSide[2]='left';

var BT_widths=[];
BT_widths[0]=400;
BT_widths[1]=450;
BT_widths[2]=450;

// BT_open_wait = 500; 
BT_close_wait = 400; 

</script>

<? echo makeGoogleEarthPopup() ?>
<? echo makePilotPopup(); ?>
<? echo makeTakeoffPopup(); ?>
<? echo makeFlightActionsPopup(); ?>

<?

function printHeader($width,$sortOrder,$fieldName,$fieldDesc,$queryExtraArray,$sort=1) {
  global $moduleRelPath;
  global $Theme;

  if ($width==0) $widthStr="";
  else  $widthStr="width='".$width."'";

  if ($fieldName=="pilotName") $alignClass="alLeft";
  else $alignClass="";
  
  if ($sort) {
	  if ($sortOrder==$fieldName) { 
	   echo "<td class='SortHeader activeSortHeader $alignClass' $widthStr>	\n
			<a href='".getLeonardoLink(array('op'=>'list_flights','sortOrder'=>$fieldName) )."'>$fieldDesc".
			leoHtml::img("icon_arrow_down.png",0,0,'','Sort order','icons1').			
			"</td>\n";
	  } else {  
	   echo "<td class='SortHeader $alignClass' $widthStr>
			<a href='".getLeonardoLink(array('op'=>'list_flights','sortOrder'=>$fieldName) )."'>$fieldDesc</a>
			</td>\n";
	  } 
   	}else {
		echo "<td class='SortHeader $alignClass' $widthStr>
			$fieldDesc
		</td>\n";
	}
}

function listFlights($res,$legend, $queryExtraArray=array(),$sortOrder="DATE") {
   global $db,$Theme;
   global $takeoffRadious;
   global $userID;
   global $NACclubID;
   global $clubID,$clubFlights,$clubsList, $add_remove_mode;
   global $moduleRelPath;
   global $PREFS,$CONF;
   global $page_num,$pagesNum,$startNum,$itemsNum;
   global $currentlang,$nativeLanguage,$opMode;
   global $CONF_photosPerFlight,$CONF_use_validation,$CONF_airspaceChecks;  
   global $CONF_new_flights_days_threshold; 
   global $gliderCatList;

$clubIcon	="<img src='".$moduleRelPath."/img/icon_club_small.gif' width=12 height=12 border=0 align='absmiddle' >";
$removeFromClubIcon	="<img src='".$moduleRelPath."/img/icon_club_remove.gif' width=22 height=12 border=0 align='absmiddle' title='Remove flight from this league'>";
$addToClubIcon		="<img src='".$moduleRelPath."/img/icon_club_add.gif' width=12 height=12 border=0 align='absmiddle' title='Add flight to this league'>";

   if ( $clubID  && (L_auth::isClubAdmin($userID,$clubID) || L_auth::isAdmin($userID))  )  {
?>

<script language="javascript">

function addClubFlight(clubID,flightID) {
	$("#updateDiv").load('<?=$moduleRelPath?>/EXT_club_functions.php?op=add&clubID='+clubID+'&flightID='+flightID);
	$('#fl_'+flightID).html("<a href=\"#\" onclick=\"removeClubFlight("+clubID+","+flightID+");return false;\"><?=$removeFromClubIcon?></a>");
	
}

function removeClubFlight(clubID,flightID) {
	$("#updateDiv").load('<?=$moduleRelPath?>/EXT_club_functions.php?op=remove&clubID='+clubID+'&flightID='+flightID);
	$('#fl_'+flightID).html("<a href=\"#\" onclick=\"addClubFlight("+clubID+","+flightID+");return false;\"><?=$addToClubIcon?></a>");
}
</script>

<?
	 	echo  "<div class='tableInfo shadowBox'>You can administer this club ";
		if ( $clubsList[$clubID]['addManual'] ) {
			if ($add_remove_mode){
				$queryExtraArray['admClub']='0';
				echo "<a href='".
					getLeonardoLink(array('op'=>'list_flights','sortOrder'=>$sortOrder)+
							$queryExtraArray)."'>Return to normal view</a>";
			} else {
				$queryExtraArray['admClub']='1';
				echo "<a href='".getLeonardoLink(array('op'=>'list_flights','sortOrder'=>$sortOrder)+
						$queryExtraArray )."'>Add / remove flights</a>";
			}
		}
		echo "<div id='updateDiv' style='display:block'></div>";
	 	echo  "</div>";
   }
   

  ?>
  	<table class='listTable' style='clear:both' width="100%" cellpadding="2" cellspacing="0">
	<tr> 
	  <td class='SortHeader' width="25"><? echo _NUM ?></td>
		 <?
		   printHeader(60,$sortOrder,"DATE",_DATE_SORT,$queryExtraArray) ;
		   printHeader(160,$sortOrder,"pilotName",_PILOT,$queryExtraArray) ;
		   printHeader(0,$sortOrder,"takeoffID",_TAKEOFF,$queryExtraArray) ;
		   printHeader(40,$sortOrder,"DURATION",_DURATION_HOURS_MIN,$queryExtraArray) ;
		   if ($CONF['list_flights']['fields']['scoring'][0]=='LINEAR_DISTANCE' ){
			   printHeader(60,$sortOrder,"LINEAR_DISTANCE",_LINEAR_DISTANCE,$queryExtraArray) ;
		   }else {
		   	   printHeader(60,$sortOrder,"SCORE_SPEED",_MEAN_SPEED1,$queryExtraArray) ;
		   }
		   printHeader(60,$sortOrder,"FLIGHT_KM",_OLC_KM,$queryExtraArray) ;
		   printHeader(65,$sortOrder,"FLIGHT_POINTS",_OLC_SCORE,$queryExtraArray) ;
		?>
	  <td width="18" class='SortHeader'>&nbsp;</td>
  	  <td width="50" class='SortHeader'>&nbsp;</td>
	  <td width="70" class='SortHeader alLeft'><? echo _SHOW ?></td>
  </tr>
<?
   $i=1;
   $currDate="";
   while ($row = $db->sql_fetchrow($res)) { 
     $is_private=$row["private"];
	 $flightID=$row['ID'];

	if ($pilotNames[ $row["userServerID"].'_'.$row["userID"] ] ) {
		$name=$pilotNames[ $row["userServerID"].'_'.$row["userID"] ];
	} else {
	    $name=getPilotRealName($row["userID"],$row["userServerID"],1);		    
		$pilotNames[ $row["userServerID"].'_'.$row["userID"] ]=$name;
	}	  
	
	$name=prepare_for_js($name);
	
	if ($takeoffNames[$row["flight_takeoffID"]]) {
		$takeoffName= $takeoffNames[ $row["flight_takeoffID"] ];
	} else {
		$takeoffName= prepare_for_js(getWaypointName($row["flight_takeoffID"],-1,0,20) ) ;
		$takeoffNames[$row["flight_takeoffID"]]=$takeoffName;
	}
	 

	 $takeoffVinicity=$row["takeoffVinicity"];
	 $takeoffNameFrm=	formatLocation($takeoffName,$takeoffVinicity,$takeoffRadious );
	 
	 $sortRowClass=($i%2)?"l_row1":"l_row2"; 	 
	 $i++;

	   $days_from_submission =	floor( ( mktime() - datetime2UnixTimestamp($row["dateAdded"]) ) / 86400 );  // 60*60*24 sec per day

	   if ( ! $is_private ) {
			$privateIcon='&nbsp;';
	   } else{
			$privateIcon='';
			if ( $is_private  & 0x01 ) { 
				$privateIcon.="<img src='".$moduleRelPath."/img/icon_private.gif' align='absmiddle' width='13' height='13'>";
		   	} 

			if ( $is_private & 0x02 ) { 
				$privateIcon.="<img src='".$moduleRelPath."/img/icon_disabled.gif' align='absmiddle' width='13' height='13'>";
			}
	   }
	   	   
  	   if ( $row["DATE"] != $currDate || $sortOrder!='DATE' ) {
  	   		 $currDate=$row["DATE"];  	   		
  	   		 $dateStr= formatDate($row["DATE"]);
			$rowStr=" newDate ";  	   		
  	   } else {
  	   		$dateStr="&nbsp;";  
			$rowStr="";
  	   }

	   $date2row="";	   
  	   if ( $days_from_submission <= $CONF_new_flights_days_threshold  )  {
			$newSubmissionStr=_SUBMIT_FLIGHT.': '.$row["dateAdded"].' GMT';
			$date2row.=leoHtml::img("icon_new.png",25,12,'absmiddle',$newSubmissionStr,'icons1');			
  	   } 

		if ($row['excludeFrom'] & 0x01 ) $date2row.="*";
		//$extLinkImgStr=getExternalLinkIconStr($row["serverID"],$row["originalURL"],3);
		//if ($extLinkImgStr) $extLinkImgStr="<a href='".$row["originalURL"]."' target='_blank'>$extLinkImgStr</a>";

		$date2row.=$extLinkImgStr;
		if ($date2row=='') $date2row.='&nbsp;';

		echo "\n\n<tr class='$sortRowClass $rowStr'>\n";

	   $duration=sec2Time($row['DURATION'],1);
	   $linearDistance=formatDistanceOpen($row["LINEAR_DISTANCE"]);
	   $olcDistance=formatDistanceOpen($row["FLIGHT_KM"]);
	   $olcScore=formatOLCScore($row["FLIGHT_POINTS"]);
	   $gliderType=$row["cat"]; // 1=pg 2=hg flex 4=hg rigid 8=glider

	   # Martin Jursa 20.05.2007
       $scoreSpeed=formatSpeed($row["SCORE_SPEED"]);


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

	    $gliderBrandImg=brands::getBrandImg($row["gliderBrandID"],$row['flight_glider'],$gliderType);


	   echo "\n<TD $first_col_back_color class='dateString'><div>".($i-1+$startNum)."</div>$privateIcon</TD>";
	   echo "<TD class='dateString' valign='top'><div>$dateStr</div>$date2row";

			if ( ( L_auth::isClubAdmin($userID,$clubID) || L_auth::isAdmin($userID) )&&  $add_remove_mode )  {
				// echo "<BR>";	   
				if (in_array($flightID,$clubFlights ) ){
					echo "<div id='fl_$flightID' style='display:inline;margin:0px;padding:0px'><a href=\"#\" onclick=\"removeClubFlight($clubID,$flightID);return false;\">$removeFromClubIcon</a></div>";
				} else {
					echo "<div id='fl_$flightID' style='display:inline'><a href=\"#\" onclick=\"addClubFlight($clubID,$flightID);return false;\">$addToClubIcon</a></div>";
				}				
			} 

		echo "</TD>";

	      echo  "<TD width=300 colspan=2 ".$sortArrayStr["pilotName"].$sortArrayStr["takeoffID"].">".
		"<div id='p_$i' class='pilotLink'>";
		
		//echo "<span class='fl sprite-gr'></span>";

		//echo  getNationalityDescription($row["pilotCountryCode"],1,0);
		$thisPilot=new pilot($row["userServerID"],$row["userID"]);
		if ( $thisPilot->isPilotLocal() || 	L_auth::isAdmin($userID)  ) {
			echo " <a href=\"javascript:pilotTip.newTip('inline', 0, 13, 'p_$i', 250, '".$row["userServerID"]."_".$row["userID"]."','".addslashes($name)."' )\"  onmouseout=\"pilotTip.hide()\">$name</a>\n";
		} else {
			echo " <a href=\"javascript:pilotTipExt.newTip('inline', 0, 13, 'p_$i', 200, '".$row["userServerID"]."_".$row["userID"]."','".addslashes($name)."' )\"  onmouseout=\"pilotTip.hide()\">$name</a>\n";
		}	
		
		echo "</div>";
		echo "<div id='t_$i' class='takeoffLink'>";
		echo "<a href=\"javascript:takeoffTip.newTip('inline',25, 13,'t_$i', 250, '".$row["takeoffID"]."','".addslashes($takeoffName)."')\"  onmouseout=\"takeoffTip.hide()\">$takeoffNameFrm</a>\n";
		echo "</div></TD>".
	   "<TD>$duration</TD>";
	   if ($CONF['list_flights']['fields']['scoring'][0]=='LINEAR_DISTANCE') {
	   		echo "<TD class='distance'>$linearDistance</TD>";
	   } else {
  		    echo "<TD class='speed'>$scoreSpeed</TD>";
	   }	
	   echo "<TD class='distance'>$olcDistance</TD>".
	   "<TD nowrap class='OLCScore'>$olcScore&nbsp;".leoHtml::img($olcScoreTypeImg,16,16,'top',formatOLCScoreType($olcScoreType,0),'icons1');

		if ($CONF_use_validation) {
			$isValidated=$row['validated'];
			if ($isValidated==-1) $vImg="icon_valid_nok.gif";
			else if ($isValidated==0) $vImg="icon_valid_unknown.gif";
			else if ($isValidated==1) $vImg="icon_valid_ok.gif";
			
			$valStr=leoHtml::img($vImg,12,12,'','','icons1 listIcons');		
			echo $valStr;
		}
	   echo "</TD>";
	   
	    
	   echo "<TD><div class='catInfo'>";
	   
	   $gliderTypeDesc=$gliderCatList[$row["cat"]];
	   if ($row["category"]) {
	   		$gliderTypeDesc.=" - ".$CONF['gliderClasses'][$row["cat"]]['classes'][$row["category"]];
	   		$categoryImg="<div class='categoryListIconDiv'>".leoHtml::img("icon_class_".$row["category"].".png",0,0,'top',$gliderTypeDesc,'icons1','')."</div>";	    	
	   } else {
	   		$categoryImg='';
	   }
	   
	   echo leoHtml::img("icon_cat_".$row["cat"].".png",0,0,'top',$gliderTypeDesc,'icons1 catListIcon'). $categoryImg;
	   
	   echo "</div></td>\n\t<TD><div align='center'>$gliderBrandImg</div></td>";

		if ($CONF_airspaceChecks && L_auth::isAdmin($userID) ) {
			if ( $row['airspaceCheckFinal']==-1 ) {
				//original: $airspaceProblem=' bgcolor=#F7E5C9 ';
				# peter Wild hack taking into account the deutschlandpokal-hack
				$tmpairspaceName=$row['airspaceCheckMsg'];
				if (strrchr( $tmpairspaceName,"Punkte"))
				{
					$airspaceProblem=' bgcolor=#009cff ';
					if (strrchr($tmpairspaceName,"HorDist")) {
						$airspaceProblem=' bgcolor=#FFFF00 ';
					}
					//mod.31.12.08 different colours for bad infringements. P. Wild
					if (strpos($tmpairspaceName, 'CLASSC')!==false) { 
						$airspaceProblem=' bgcolor=#FF0008 ';
					}
					if (strpos($tmpairspaceName, 'CLASSD')!==false) { 
						$airspaceProblem=' bgcolor=#FF0008 ';
					}
				} else {
					if (strpos($tmpairspaceName, 'CLASSC')!==false) { 
						$airspaceProblem=' bgcolor=#FF0008 ';
					} else if (strpos($tmpairspaceName, 'CLASSD')!==false) { 
						$airspaceProblem=' bgcolor=#FF0008 ';
					} else {
						$airspaceProblem=' bgcolor=#FFFF00 ';
					}	
				}
				# end hack
			} else
				$airspaceProblem='';
		}

		$isExternalFlight=$row['externalFlightType'];
		echo "<TD $airspaceProblem align=left valign='top'>";
		echo "<div class='smallInfo'>";

	    if ( $isExternalFlight == 0 || 
			$isExternalFlight ==2 || 
			$CONF['servers']['list'][$row['serverID']]['treat_flights_as_local']) { 
			// add class='betterTip' for tooltip
			echo "<a  id='tpa0_$flightID' href='".getLeonardoLink(array('op'=>'show_flight','flightID'=>$row["ID"]) )."'>".
			leoHtml::img("icon_look.gif",0,0,'top',_SHOW,'icons1 flightIcon')."</a>";
			
		    echo "<a href='javascript:nop()' onclick=\"geTip.newTip('inline', -315, -5, 'ge_$i', 300, '".$row["ID"].
					"' , '$currentlang')\"  onmouseout=\"geTip.hide()\">".
					leoHtml::img("geicon.gif",0,0,'top',_Navigate_with_Google_Earth,'icons1 geIcon','ge_'.$i)."</a>";

		} else {
			echo "<a  href='".getLeonardoLink(array('op'=>'show_flight','flightID'=>$row["ID"]) )."'>".
					leoHtml::img("icon_look.gif",0,0,'top',_SHOW,'icons1 flightIcon')."</a>";

			$originalKML=$row["originalKML"];
			global $CONF;
			if ( $CONF['servers']['list'][ $row["serverID"] ]['isLeo'] == 1  ) {
			 	if ( $row["original_ID"] )  {				
					$originalKML='http://'.$CONF['servers']['list'][ $row["serverID"] ]['url_base'].
										'/download.php?type=kml_trk&flightID='.$row["original_ID"];
				}			
			}
			
			if ($originalKML) 
			    echo "<a  href='".$originalKML."'>".
						leoHtml::img("geicon.gif",0,0,'top',_Navigate_with_Google_Earth,'icons1 geIcon')."</a>";
			else
				echo leoHtml::img("photo_icon_blank.gif",16,16,'','','icons1 geIcon');				
			
		}

		$photosNum=$row["hasPhotos"];
		if ($photosNum)
			echo "<span><a class='betterTip2' id='tpa1_$flightID' href='javascript:nop();'>".
				leoHtml::img("icon_camera.gif",0,0,'',$photosNum.' '._PHOTOS,'icons1 photoIcon2')."</a></span>";

		if ($row["commentsNum"]>0) {
			$hasComments=1;
			if ($row["commentsNum"]>1) {
				$commentsImgName="icon_comments_many.gif";
			} else {
				$commentsImgName="icon_comments.gif";
			}	
		} else {
			$hasComments=0;
		}	
	
		if ($hasComments ) 
				echo "<a class='betterTip' id='tpa2_$flightID' href='javascript:nop();'>".
						leoHtml::img($commentsImgName,0,0,'',$row["commentsNum"].' '._COMMENTS,'icons1 commentDiv','',1)."</a>";
		

		if ($isExternalFlight && ! $CONF['servers']['list'][$row['serverID']]['treat_flights_as_local'] ) {
 			 $extServerStr=$CONF['servers']['list'][$row['serverID']]['name'];
 			 $extServerStrShort=$CONF['servers']['list'][$row['serverID']]['short_name'];
			 
			 if ($isExternalFlight ==2 ) {
			 	 echo leoHtml::img("icon_link_dark.gif",0,0,'',_External_Entry.": $extServerStr",'icons1 extLink');				
				 echo "<div class='extLinkName'>$extServerStrShort</div>";
			 } else { 
				 
				 
				 if ( $CONF['servers']['list'][$row['serverID']]['isLeo'] ) {
				 	$url_flight=$CONF['servers']['list'][ $row['serverID'] ]['url_flight'];
					if ($url_flight) {					
						$extFlightLink='http://'.str_replace("%FLIGHT_ID%",$row['original_ID'],$url_flight)."&lng=$currentlang";
					} else {
						$extFlightLink='http://'.$CONF['servers']['list'][$row['serverID']]['url'].
									'&op=show_flight&flightID='.$row['original_ID']."&lng=$currentlang";
					}				
				 } else {
					 $extFlightLink=$row['originalURL'];
				 }	
	
	
				 echo "<a href='$extFlightLink' target='_blank' class='extLinkDiv' title='$extServerStr: "._Ext_text2."' >";
					 // also put the direct link in the place of the photo
					 echo "<img class='extServerLogo' src='".$moduleRelPath."/img/servers/".sprintf("%03d",$row['serverID']).".gif' width='16' height='16'  border='0'/>";
					 echo leoHtml::img("icon_link_dark.gif",0,0,'','','icons1 extLinkIcon');								 
					 echo "<div class='extLinkDescr'>$extServerStrShort</div>";
					 //echo "<span class='extLinkDescr'>$extServerStrShort</span>";
				 echo "</a>";
			}
						 
		}
			

		# P.Wild, martin jursa: considering $CONF_new_flights_days_threshold
		global $CONF_new_flights_submit_window; //P. Wild - edited to submit window (old version false)
		$inWindow=empty($CONF_new_flights_submit_window) ? true : $days_from_submission<=$CONF_new_flights_submit_window;
		if (($row["userID"]==$userID && $inWindow) || L_auth::isAdmin($userID) ) {
			echo "<div id='ac_$i' class='actionLink'>";
			echo "<a href=\"javascript:flightActionTip.newTip('inline', -100, 13, 'ac_$i', 120, ".$row["ID"]." )\"  onmouseout=\"flightActionTip.hide()\">".
				leoHtml::img("icon_action_select.gif",0,0,'bottom','','icons1')."</a>";
			echo "</div>";
	   }

		$checkedByStr='';
		if ($row['checkedBy'] && L_auth::isAdmin($userID)){
			$checkedByArray=explode(" ",$row['checkedBy']);
			$checkedByStr="<div class='checkedBy' align=right>".$checkedByArray[0]."</div>";
			echo $checkedByStr;
		}

		echo "</div>";


	   echo "</TD>\n";	  
  	   echo "</TR>";
   }  
   echo "</table>\n\n"  ;      
   $db->sql_freeresult($res);
}


?>
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
// $Id: GUI_comp.php,v 1.31 2011/05/18 13:31:48 manolis Exp $                                                                 
//
//************************************************************************

//-----------------------------------------------------------------------
//-----------------------  custom league --------------------------------
//-----------------------------------------------------------------------

  if (!$subrank)  $subrank=1;

  if ($lng==$ranksList[$rank]['localLanguage'])
	  $legend=$ranksList[$rank]['localName'];
  else 
  	  $legend=$ranksList[$rank]['name'];

  
  // SEASON MOD
  // we do a little trick here!
  // if the rank has custom seasons we just replace the global $CONF['seasons'] array 
  // since both have the same structure
  if ( $ranksList[$rank]['useCustomSeasons'] ) { 
	  $CONF['seasons']=$ranksList[$rank]['seasons'];
	  
	  if (is_array( $ranksList[$rank]['subranks'][$subrank]['seasons'] ) ) {
		  $CONF['seasons']=$ranksList[$rank]['subranks'][$subrank]['seasons'];
	  }
  }
  if ( $ranksList[$rank]['useCustomYears'] ) { 
	  $CONF['years']=$ranksList[$rank]['years'];
	  if (is_array( $ranksList[$rank]['subranks'][$subrank]['years'] ) ) {
		  $CONF['years']=$ranksList[$rank]['subranks'][$subrank]['years'];
	  }
  }
  $where_clause='';
  $where_clause.= dates::makeWhereClause(0,$season,$year,$month,0 );

  // BRANDS MOD  
  $where_clause.= brands::makeWhereClause($brandID);

	// take care of exluding flights
	// 1-> first bit -> means flight will not be counted anywhere!!!
	$bitMask=2 & ~( $includeMask & 0x03 );
	$where_clause.= " AND ( excludeFrom & $bitMask ) = 0 ";

  $dontShowCatSelection =$ranksList[$rank]['dontShowCatSelection'];
  $dontShowCountriesSelection=$ranksList[$rank]['dontShowCountriesSelection'];
  $dontShowManufacturers=$ranksList[$rank]['dontShowManufacturers']; //P.Wild 16.7.08
  
  
  	# Martin Jursa 22.05.2007 option NACclub Selection
	$dontShowNacClubSelection=1;
	$forceNacId=0;
	if (!empty($CONF_use_NAC) && empty($ranksList[$rank]['dontShowNacClubSelection'])) {
		require_once(dirname(__FILE__)."/CL_NACclub.php");
		$dontShowNacClubSelection=0;
		# to override any REQUEST/SESSION nacid value inside the nacclub second_menu
		$forceNacId=$ranksList[$rank]['forceNacId'];
		if ($forceNacId) $nacid=$forceNacId;
	}
  
  
  	//----------------------------------------------------------
	// Now the filter
	//----------------------------------------------------------		
	$filter_clause=$_SESSION["filter_clause"];
	// echo $filter_clause;
	if ( strpos($filter_clause,$pilotsTable) )  $pilotsTableQuery=1;
	if ( strpos($filter_clause,$waypointsTable) )  $countryCodeQuery=1;		
	$where_clause.=$filter_clause;
	//----------------------------------------------------------

	if ($countryCodeQuery)   {
		 $countryCodeQuery_clause.=" AND $flightsTable.takeoffID=$waypointsTable.ID ";
		 $extra_table_str1.=",$waypointsTable";
	} 
	if ($pilotsTableQuery ){
		$pilotsTableQuery_clause.="  AND $flightsTable.userID=$pilotsTable.pilotID AND $flightsTable.userServerID=$pilotsTable.serverID  ";	 
		$extra_table_str2.=",$pilotsTable  ";			
	}

  
  // show the current subranking
  require dirname(__FILE__)."/data/ranks/$rank/GUI_rank_cat_$subrank.php";

  
  
  if ($ranksList[$rank]['entity']=='club') $listClubs=1;
  else $listClubs=0;

  $clubID=0;
  
  /*
  $page_num=makeSane($_REQUEST["page_num"],1);
  if ($page_num==0)  $page_num=1;
  $startNum=($page_num-1)*$CONF_compItemsPerPage;
  $pagesNum=ceil ($itemsNum/$CONF_compItemsPerPage);
  */
  $page_num=$_REQUEST["page_num"]+0;
  if ($page_num==0)  $page_num=1;
  
   $itemsNum=count($pilots);   

  $startNum=($page_num-1)*$CONF_compItemsPerPage;
  $pagesNum=ceil ($itemsNum/$CONF_compItemsPerPage);
  $endNum=$startNum+$CONF_compItemsPerPage;
	
  $legendRight=generate_flights_pagination(
  			getLeonardoLink(array('op'=>'comp','rank'=>$rank,'subrank'=>$subrank)), 
			$itemsNum,$CONF_compItemsPerPage,$page_num*$CONF_compItemsPerPage-1, TRUE); 
			

	if ($endNum>$itemsNum) $endNum=$itemsNum;
	$legendRight.=" [&nbsp;".($startNum+1)."-".$endNum."&nbsp;"._From."&nbsp;".$itemsNum ."&nbsp;]";
	if ($itemsNum==0) $legendRight="[ 0 ]";

  echo  "<div class='tableTitle shadowBox'><div class='titleDiv'>$legend</div>";
  if (!$listClubs) echo "<div class='pagesDivSimple'>$legendRight</div>";
  
  echo "</div>" ;



  //echo  "<div class='tableTitle shadowBox'><div class='titleDiv'>$legend</div></div>" ;  
  require_once dirname(__FILE__)."/MENU_second_menu.php";

// show the general discription of the ranking

// show the different subrankings/categories menu
foreach($ranksList[$rank]['subranks'] as $subrankID=>$subrankArray) {
  if ($lng==$ranksList[$rank]['localLanguage'])
  		$subrankTitle=$subrankArray['localName'];
  else
  		$subrankTitle=$subrankArray['name'];
		
	if ($subrankID==$subrank) $style ="style='background-color:#E1E6F3;' ";
	else $style="";
	echo " <div class='menu1' $style ><a href='".getLeonardoLink(array('op'=>'comp','rank'=>$rank,'subrank'=>$subrankID))."'>$subrankTitle</a></div>";	
}
echo "<BR><BR>";


# Martin Jursa, 02.03.2009: Hook for custom menu generated somewhere in the ranks code
if (!empty($custom_ranks_menu)) {
	echo $custom_ranks_menu;
}


	// was _KILOMETERS -> bug
	// and _TOTAL_KM
	if ($PREFS->metricSystem==1) {
		$FAI_TRIANGLE_str=_KM;
		$MENU_OPEN_DISTANCE_str=_TOTAL_DISTANCE." "._KM;
	} else  {
		$FAI_TRIANGLE_str=_MI;
		$MENU_OPEN_DISTANCE_str=_TOTAL_DISTANCE." "._MI;
	}

?>
<link rel="stylesheet" href="<?=$moduleRelPath ?>/js/bettertip/jquery.bettertip.css" type="text/css" />


<script type="text/javascript" src="<?=$moduleRelPath ?>/js/bettertip/jquery.bettertip.js"></script>
<script type="text/javascript" src="<?=$moduleRelPath ?>/js/tipster.js"></script>

<script type="text/javascript">
var BT_base_urls=[];
BT_base_urls[0]='<?=$moduleRelPath?>/GUI_EXT_pilot_info.php?op=info_short&pilotID=';
BT_base_urls[1]='<?=$moduleRelPath?>/GUI_EXT_pilot_info.php?op=info_nac&pilotID=';
BT_base_urls[2]='<?=$moduleRelPath?>/GUI_EXT_flight_info.php?op=info_short&flightID=';

var BT_displayOnSide=[];
BT_displayOnSide[0]='auto';
BT_displayOnSide[1]='auto';
BT_displayOnSide[2]='auto';

var BT_widths=[];
BT_widths[0]=500;
BT_widths[1]=400;
BT_widths[2]=400;

var BT_default_width=500;
</script>

<? echo makePilotPopup();  ?>

<div class="tabber" id="compTabber">
<?
	# Martin Jursa 02.03.2009: Enable custom Title of display via specific ranks code (setting $customSubrankTitle)
	if (!empty($customSubrankTitle)) {
		$subrankTitle=$customSubrankTitle;
	}else {
	if ($lng==$ranksList[$rank]['localLanguage'])
		$subrankTitle=$ranksList[$rank]['subranks'][$subrank]['localName'];
	else
		$subrankTitle=$ranksList[$rank]['subranks'][$subrank]['name'];
	}
	
	if ($customFormatFunction) 
		$formatFunction=$customFormatFunction;
	else 
		$formatFunction="formatOLCScore";	
	
	if ($customRankHeader) 
		$rankHeader=$customRankHeader;
	else 
		$rankHeader=_OLC_TOTAL_SCORE;
			
	if ($listClubs) {			
		listClubs($subrankTitle, $rankHeader,"score","score",$formatFunction);
	} else {
	 	listCategory($subrankTitle, $rankHeader,"score","score",$formatFunction);
	}
	
	?>
</div>
<?	
function listCategory($legend,$header, $category, $key, $formatFunction="") {
   global $pilots;
   global $Theme,$countries;
   global $moduleRelPath;
   global $CONF_compItemsPerPage;
   global $page_num,$pagesNum,$startNum,$itemsNum;
   global $op,$cat;
   global $countHowMany;
   global $tabID;
   global $sort_funcs_pilots;
   global $CONF;
   global $dateLegend;

   uasort($pilots,$sort_funcs_pilots[$category]);

   $legendRight=""; // show all pilots up to  $CONF_compItemsPerPage
   if ($tabID ==  makeSane($_GET['comp'],1)  ) $defaultTabStr=" tabbertabdefault";
   else  $defaultTabStr="";
   
   $tabID++;
   echo "<div class='tabbertab $defaultTabStr' title='$legend'>";
   
   if ($countHowMany>0)  {
	   $legend.=" (".$countHowMany." "._N_BEST_FLIGHTS.")";
   } else {   
       $legend.=" (".$dateLegend.")";
   }
   echo "<table class='listTable listTableTabber' cellpadding='2' cellspacing='0'>
   			<tr><td class='tableTitleExtra' colspan='".($countHowMany+4)."'>$legend</td></tr>";
   
   ?>
   <tr>
   <td class="SortHeader" width="30"><? echo _NUM ?></td>
   <td class="SortHeader"><div align=left><? echo _PILOT ?></div></td>
   <td class="SortHeader" width="70"><? echo $header ?></td>
   <? for ($ii=1;$ii<=$countHowMany;$ii++) { ?>
   <td class="SortHeader" width="55">#<? echo $ii?></td>
   <? } ?>
   <td class="SortHeader" width="50">&nbsp;</td>
   </tr>
   <? 

	  $i=1;
   	  foreach ($pilots as $pilotID=>$pilot) {
	  	 if ($i< ( $startNum + 1) ) { $i++ ;  continue; }
		 if ($i>( $startNum  + $CONF_compItemsPerPage) ) break;
  		 // if ($i>$CONF_compItemsPerPage) break;
		 if (!$pilot[$category]['sum'] || ! count($pilot[$category]['flights'])) continue;

		 $sortRowClass=($i%2)?"l_row1":"l_row2"; 
 		 if ($i==1) $bg=" class='compFirstPlace'";
 		 else if ($i==2) $bg=" class='compSecondPlace'";
 		 else if ($i==3) $bg=" class='compThirdPlace'";
		 else $bg=" class='$sortRowClass'";
		 	 	     
	     $pilotIDinfo=str_replace("_","u",$pilotID);
		 echo "<TR $bg>";
		 echo "<TD>".($i)."</TD>"; 	
	     echo "<TD nowrap><div align=left id='$arrayName"."_$i' class='pilotLink'>".		 
				"<a class='betterTip' id='tpa0_$pilotIDinfo' href=\"javascript:pilotTip.newTip('inline', 0, 13, '$arrayName"."_$i', 200, '".$pilotID."','".
					addslashes($pilot['name'])."' )\"  onmouseout=\"pilotTip.hide()\">".$pilot['name']."</a>";
					
		if ($pilot['NACid'] && $pilot['NACmemberID'] && $pilot['NACclubID'] &&
				 $CONF['NAC']['display_club_details_on_pilot_list']
		) {	
			echo "&nbsp;<a class='betterTip' id='tpa1_$pilotIDinfo' href=\"javascript:nop();\"><img src='$moduleRelPath/img/icon_nac_member.gif' align='absmiddle' border=0></a>";
		}	
		 echo "</div></TD>";
		 if ($formatFunction) $outVal=$formatFunction($pilot[$category]["sum"]);
		 else $outVal=$pilot[$category]["sum"];
   	     echo "<TD>".$outVal."</TD>"; 	 
		 
		$i++;

		$k=0;

		unset($pilotBrands);
		$pilotBrands=array();
		if ($countHowMany>0) {
			foreach ($pilot[$category]['flights'] as $flightID) {
				$val=$pilot['flights'][$flightID][$key];
	
				$glider=$pilot['flights'][$flightID]['glider'];
				$country=$countries[$pilot['flights'][$flightID]['country']];
	
				$thisFlightBrandID=$pilot['flights'][$flightID]['brandID'];
				if ($thisFlightBrandID) $pilotBrands[$thisFlightBrandID]++;
	
				$flightComment=$pilot['flights'][$flightID]['comment'];
				
				if (!$val)  $outVal="-";
				else if ($formatFunction) $outVal=$formatFunction($val);
				else $outVal=$val;
				// $descr=_GLIDER.": $glider, "._COUNTRY.": $country";
				if ($val) {
					if ($flightComment) $flightCommentStr="<br>($flightComment)";
					else $flightCommentStr='';
					echo "<TD><a class='betterTip' id='tpa2_$flightID' href='".getLeonardoLink(array('op'=>'show_flight','flightID'=>$flightID))."' alt='$descr' title='$descr'>".$outVal.$flightCommentStr."</a>";
					
					//echo " <a class='betterTip' id='tpa2_$flightID' href='".$moduleRelPath."/GUI_EXT_flight_info.php?op=info_short&flightID=".$flightID."' title='$descr'>?</a>";
					echo "</TD>"; 	 		  
				} else echo "<TD>".$outVal."</TD>"; 	 		  
				$k++;
				if ($k>=$countHowMany) break;
			}
	
			if ($k!=$countHowMany) {
				for($j=$k;$j<$countHowMany;$j++) {
					echo "<TD>-</TD>"; 	 		  
				}
			}
		} else {
			//only detect most used glider brand
			foreach ($pilot[$category]['flights'] as $flightID) {				
				$thisFlightBrandID=$pilot['flights'][$flightID]['brandID'];
				if ($thisFlightBrandID) $pilotBrands[$thisFlightBrandID]++;
			}	
		
		}
		
		arsort($pilotBrands);
		$flightBrandID=array_shift(array_keys($pilotBrands));

		$gliderBrandImg=brands::getBrandImg($flightBrandID,'',$cat);	

		echo "<td align='center'>$gliderBrandImg</td>";
   	}	// next pilot

	echo "</table>"; 
	echo '</div>';
} //end function

function listClubs($legend,$header, $category, $key, $formatFunction="") {
   global $clubs,$NACid;
   global $Theme,$countries;
   global $moduleRelPath;
   global $CONF_compItemsPerPage;
   global $page_num,$pagesNum,$startNum,$itemsNum;
   global $op,$cat;
   global $countHowManyFlights,$pilotsMax,$pilotsMin;
   global $tabID;
   global $sort_funcs_pilots;

   require_once dirname(__FILE__)."/CL_NACclub.php";
   $clubNamesList=NACclub::getClubs($NACid);

   $legendRight=""; // show all pilots up to  $CONF_compItemsPerPage
    
  // $legend.=" (".$countHowMany." "._N_BEST_FLIGHTS.")";
   echo "<table class='listTable listTableTabber listTable2' cellpadding='2' cellspacing='0'>
   			<tr><td class='tableTitleExtra' colspan='".($pilotsMax+3)."'>$legend</td></tr>";
   
   ?>
   <tr>
   <td class="SortHeader" width="30"><? echo _NUM ?></td>
   <td class="SortHeader"><div align=left><? echo _Club ?></div></td>
   <? for ($ii=1;$ii<=$pilotsMax;$ii++) { ?>
   <td class="SortHeader" width="55"><div align=left><? echo _PILOT." #$ii" ;?></div></td>
   <? } ?>
   <td class="SortHeader" width="70"><? echo $header ?></td>
   </tr>
   <? 

	  $i=1;
   	  foreach ($clubs as $clubID=>$club) {
  		 // if ($i>$CONF_compItemsPerPage) break;
		 if (!$club['sum'] ) continue;

		 $sortRowClass=($i%2)?"l_row1":"l_row2"; 
 		 if ($i==1) $bg=" class='compFirstPlace'";
 		 else if ($i==2) $bg=" class='compSecondPlace'";
 		 else if ($i==3) $bg=" class='compThirdPlace'";
		 else $bg=" class='$sortRowClass'";
		 	 	     
	     $i++;
		 echo "<TR $bg>";
		 echo "<TD>".($i-1+$startNum)."</TD>"; 	
	     echo "<TD width='25%'><div align=left >".$clubNamesList[$clubID].
				"</div></TD>";
		 


		unset($pilotBrands);
		$pilotBrands=array();

		$j=0;
		foreach ($club as $pilotID=>$pilot) {
			$k=0;
			$pilotIDparts=split('_',$pilotID,2);
			if (!is_numeric( $pilotIDparts[1]) ) continue;
			// echo "#".$pilotID."#";

			$pilotName=getPilotRealName($pilotIDparts[1],$pilotIDparts[0],1); 


			$pilotName=prepare_for_js($pilotName);
			$pilotIDinfo=str_replace("_","u",$pilotID);
			
			echo "<TD width='20%'>";
			echo "<table width='100%' cellpadding='0' cellspacing='0' class='listTable3'><TR><TD colspan=3 id='$arrayName"."_$pilotID' class='pilotLink'>".
				"<a class='clubPilot betterTip' id='tpa0_$pilotIDinfo' href=\"javascript:pilotTip.newTip('inline', 0, 13, '$arrayName"."_$pilotID', 200, '".$pilotID."','".
					addslashes($pilotName)."' )\"  onmouseout=\"pilotTip.hide()\">".$pilotName."</a>".
			"</td></tr><tr>";
			foreach($pilot['flights_sel'] as $flightID) {
				$val=$pilot['flights'][$flightID]['score'];
	
				$glider=$pilot['flights'][$flightID]['glider'];
				$country=$countries[$pilot['flights'][$flightID]['country']];
	
				$thisFlightBrandID=$pilot['flights'][$flightID]['brandID'];
				if ($thisFlightBrandID) $pilotBrands[$thisFlightBrandID]++;
	
				if (!$val)  $outVal="&nbsp;";
				else if ($formatFunction) $outVal=$formatFunction($val);
				else $outVal=$val;
				
				
				// $descr=_PILOT.": $pilotName, "._GLIDER.": $glider, "._COUNTRY.": $country";
				$descr=_GLIDER.": $glider, "._COUNTRY.": $country";
				$descr='';
				if ($val) {
					echo "<TD width='33%'><a class='betterTip' id='tpa2_$flightID' href='".getLeonardoLink(array('op'=>'show_flight','flightID'=>$flightID))."' alt='$descr'  title='$descr'>".$outVal."</a></TD>"; 	 		  
				} else { 
					echo "<TD width='33%'>".$outVal."</TD>"; 	 		  
				}	
				$k++;
				if ($k>=$countHowManyFlights) break;
			}
			if ($k!=$countHowManyFlights) {
				for($kk=$k;$kk<$countHowManyFlights;$kk++) {
					echo "<TD >&nbsp;</TD>"; 	 		  
				}
			}
			echo "</tr></table></td>";
			$j++;
			if ($j>=$pilotsMax) break;
		}

		if ($j!=$pilotsMax) {
			for($jj=$j;$jj<$pilotsMax;$jj++) {
				echo "<TD width='20%'>-</TD>"; 
//				for($jjj=0;$jjj<$countHowManyFlights;$jjj++) {
//					echo "<TD>-</TD>"; 	 		  
//				}
			}
		}

		 if ($formatFunction) $outVal=$formatFunction($club["sum"]);
		 else $outVal=$club["sum"];
   	     echo "<TD>".$outVal."</TD>"; 	 


		echo "</tr>";
   	}	// next club

	echo "</table>"; 
//	echo '</div>';

} //end function

?>
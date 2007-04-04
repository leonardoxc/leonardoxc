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
/************************************************************************/

//-----------------------------------------------------------------------
//-----------------------  custom league --------------------------------
//-----------------------------------------------------------------------
  require_once dirname(__FILE__)."/FN_brands.php";

  if (!$subrank)  $subrank=1;

  if ($lng==$ranksList[$rank]['localLanguage'])
	  $legend=$ranksList[$rank]['localName'];
  else 
  	  $legend=$ranksList[$rank]['name'];

  $page_num=makeSane($_REQUEST["page_num"],1);
  if ($page_num==0)  $page_num=1;
  $startNum=($page_num-1)*$CONF_compItemsPerPage;
  $pagesNum=ceil ($itemsNum/$CONF_compItemsPerPage);

  echo  "<div class='tableTitle shadowBox'><div class='titleDiv'>$legend</div></div>" ;

  $dontShowCatSelection =$ranksList[$rank]['dontShowCatSelection'];
  $dontShowCountriesSelection=$ranksList[$rank]['dontShowCountriesSelection'];
  $datesMenu=$ranksList[$rank]['datesMenu'];
  $startYear=$ranksList[$rank]['startYear'];
  if ($ranksList[$rank]['entity']=='club') $listClubs=1;
  else $listClubs=0;
  
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
	echo " <div class='menu1' $style ><a href='?name=$module_name&op=comp&rank=$rank&subrank=$subrankID'>$subrankTitle</a></div>";	
}
echo "<BR><BR>";
// show the current subranking
require dirname(__FILE__)."/data/ranks/$rank/GUI_rank_cat_$subrank.php";


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
<script type="text/javascript" src="<?=$moduleRelPath ?>/js/tipster.js"></script>
<? echo makePilotPopup();  ?>

<div class="tabber" id="compTabber">
<?
	if ($lng==$ranksList[$rank]['localLanguage'])
		$subrankTitle=$ranksList[$rank]['subranks'][$subrank]['localName'];
	else
		$subrankTitle=$ranksList[$rank]['subranks'][$subrank]['name'];
		
	if ($listClubs) 		
	  listClubs($subrankTitle, _OLC_TOTAL_SCORE,"score","score","formatOLCScore");
	else
	  listCategory($subrankTitle, _OLC_TOTAL_SCORE,"score","score","formatOLCScore");

?>
</div>
<?	
function listCategory($legend,$header, $category, $key, $formatFunction="") {
   global $pilots;
   global $Theme,$countries;
   global $module_name,$moduleRelPath;
   global $CONF_compItemsPerPage;
   global $page_num,$pagesNum,$startNum,$itemsNum;
   global $op,$cat;
   global $countHowMany;
   global $tabID;
   global $sort_funcs_pilots;

   uasort($pilots,$sort_funcs_pilots[$category]);

   $legendRight=""; // show all pilots up to  $CONF_compItemsPerPage
   if ($tabID ==  makeSane($_GET['comp'],1)  ) $defaultTabStr=" tabbertabdefault";
   else  $defaultTabStr="";
   
   $tabID++;
   echo "<div class='tabbertab $defaultTabStr' title='$legend'>";
   
   $legend.=" (".$countHowMany." "._N_BEST_FLIGHTS.")";
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
  		 // if ($i>$CONF_compItemsPerPage) break;
		 if (!$pilot[$category]['sum'] || ! count($pilot[$category]['flights'])) continue;

		 $sortRowClass=($i%2)?"l_row1":"l_row2"; 
 		 if ($i==1) $bg=" class='compFirstPlace'";
 		 else if ($i==2) $bg=" class='compSecondPlace'";
 		 else if ($i==3) $bg=" class='compThirdPlace'";
		 else $bg=" class='$sortRowClass'";
		 	 	     
	     $i++;
		 echo "<TR $bg>";
		 echo "<TD>".($i-1+$startNum)."</TD>"; 	
	     echo "<TD nowrap><div align=left id='$arrayName"."_$i'>".		 
				"<a href=\"javascript:pilotTip.newTip('inline', 0, 13, '$arrayName"."_$i', 200, '".$pilotID."','".
					addslashes($pilot['name'])."' )\"  onmouseout=\"pilotTip.hide()\">".$pilot['name']."</a>".
				"</div></TD>";
		 if ($formatFunction) $outVal=$formatFunction($pilot[$category]["sum"]);
		 else $outVal=$pilot[$category]["sum"];
   	     echo "<TD>".$outVal."</TD>"; 	 
		 

		$k=0;

		unset($pilotBrands);
		$pilotBrands=array();
		foreach ($pilot[$category]['flights'] as $flightID) {
			$val=$pilot['flights'][$flightID][$key];

			$glider=$pilot['flights'][$flightID]['glider'];
			$country=$countries[$pilot['flights'][$flightID]['country']];

			$thisFlightBrandID=$pilot['flights'][$flightID]['brandID'];
			if ($thisFlightBrandID) $pilotBrands[$thisFlightBrandID]++;

			if (!$val)  $outVal="-";
			else if ($formatFunction) $outVal=$formatFunction($val);
			else $outVal=$val;
			$descr=_GLIDER.": $glider, "._COUNTRY.": $country";
			if ($val) echo "<TD><a href='?name=$module_name&op=show_flight&flightID=".$flightID."' alt='$descr'  title='$descr'>".$outVal."</a></TD>"; 	 		  
			else echo "<TD>".$outVal."</TD>"; 	 		  
			$k++;
			if ($k>=$countHowMany) break;
		}

		if ($k!=$countHowMany) {
			for($j=$k;$j<$countHowMany;$j++) {
				echo "<TD>-</TD>"; 	 		  
			}
		}

		arsort($pilotBrands);
		$brandID=array_shift(array_keys($pilotBrands));
		$gliderBrandImg="<img src='$moduleRelPath/img/brands/$cat/".sprintf("%03d",$brandID).".gif' border=0 align=abs_middle>";
		echo "<td align='center'>$gliderBrandImg</td>";
   	}	// next pilot

	echo "</table>"; 
	echo '</div>';
} //end function

function listClubs($legend,$header, $category, $key, $formatFunction="") {
   global $clubs,$NACid;
   global $Theme,$countries;
   global $module_name,$moduleRelPath;
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
			if (!is_numeric( $pilotID) ) continue;
			// echo "#".$pilotID."#";

			$pilotName=getPilotRealName($pilotID,1); 
			$pilotName=prepare_for_js($pilotName);
			echo "<TD width='20%'>";
			echo "<table width='100%' cellpadding='0' cellspacing='0' class='listTable3'><TR><TD colspan=3 id='$arrayName"."_$pilotID'>".
				"<a  class='clubPilot' href=\"javascript:pilotTip.newTip('inline', 0, 13, '$arrayName"."_$pilotID', 200, '".$pilotID."','".
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
				if ($val) echo "<TD width='33%'><a href='?name=$module_name&op=show_flight&flightID=".$flightID."' alt='$descr'  title='$descr'>".$outVal."</a></TD>"; 	 		  
				else echo "<TD width='33%'>".$outVal."</TD>"; 	 		  
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
<?
//************************************************************************
// Leonardo XC Server, http://leonardo.thenet.gr
//
// Copyright (c) 2004-8 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: GUI_filter.php,v 1.24 2010/02/26 14:30:40 manolis Exp $                                                                 
//
//************************************************************************

require_once dirname(__FILE__).'/CL_filter.php';

$filterUrl="http://".$_SERVER['SERVER_NAME'].getLeonardoLink(array('op'=>'filter','fl_url'=>'1'));
$redirectUrl="http://".$_SERVER['SERVER_NAME'].getLeonardoLink(array('op'=>'list_flights'));

require_once dirname(__FILE__).'/CL_dialogfilter.php';
$dlgfilters=array();
$dlgfilters['pilots_incl']=new dialogfilter('pilot', 'FILTER_pilots_incl');
/**
 * By suffixing _excl to the FILTER_xx variable, the dialogfilter excludes the selection from the query
 * Example:
 * $dlgfilters['pilots_excl']=new dialogfilter('pilot', 'FILTER_pilots_excl');
 */
if (!empty($CONF_use_NAC)) {
	if (!empty($CONF_NAC_list)) {
		foreach ($CONF_NAC_list as $nacid=>$nacdata) {
			if (!empty($nacdata['use_clubs'])) {
				$key='nacclubs'.$nacid.'_incl';
				$dlgfilters[$key]=new dialogfilter('nacclub', 'FILTER_'.$key, $nacid);
			}
		}
	}
}
$dlgfilters['countries_incl']=new dialogfilter('country', 'FILTER_countries_incl');
$dlgfilters['takeoffs_incl']=new dialogfilter('takeoff', 'FILTER_takeoffs_incl');
$dlgfilters['nationality_incl']=new dialogfilter('nationality', 'FILTER_nationality_incl');

if ( count($CONF['servers']['list']) ) {
	$dlgfilters['servers_incl']=new dialogfilter('server', 'FILTER_server_incl');
}

$filterkeys=array_keys($dlgfilters);

if ($_REQUEST["FILTER_dateType"] || $_GET['fl_url']==1) { // form submitted

	// copy form variables to session
	foreach ($_REQUEST as $key => $value ) {
		if (substr($key,0,7)=="FILTER_") {
			$_SESSION[$key]=$value;
			if ($value) $filterUrl.="&$key=".urlencode($value);
			$$key=$value;
		}
	}

	$filter_clause="";
	if ($_REQUEST['clearFilter']==1) {
		$_SESSION["filter_clause"]=$filter_clause;
	} else {

		if ($FILTER_dateType=="YEAR") {
			$filter_clause.=" AND DATE_FORMAT(DATE,'%Y') $FILTER_YEAR_select_op $FILTER_YEAR_select ";
		} else 	if ($FILTER_dateType=="MONTH_YEAR") {
			$filter_clause.=" AND ( DATE_FORMAT(DATE,'%Y%m') $FILTER_MONTH_YEAR_select_op $FILTER_MONTH_YEAR_select_YEAR$FILTER_MONTH_YEAR_select_MONTH ) ";
		} else if ($FILTER_dateType=="DATE_RANGE"){ // RANGE
			$from=substr($FILTER_from_day_text,6,4).substr($FILTER_from_day_text,3,2).substr($FILTER_from_day_text,0,2);
			$to=substr($FILTER_to_day_text,6,4).substr($FILTER_to_day_text,3,2).substr($FILTER_to_day_text,0,2);
			$filter_clause.=" AND ( DATE_FORMAT(DATE,'%Y%m%d') >=  $from AND DATE_FORMAT(DATE,'%Y%m%d') <= $to ) ";
		}

		$AND_clauses=array();
		$nacclub_clauses=array(); # nacclub filters will be OR-combined; this only works with including-filters; in case of excluding filters this code must be modified
		foreach ($filterkeys as $filterkey) {
			$clause=$dlgfilters[$filterkey]->filter_clause();
			// echo $clause;
			if ($clause!='') {
				if ($dlgfilters[$filterkey]->datakey=='nacclub') {
					$nacclub_clauses[]='('.$clause.')';
				}else {
					$AND_clauses[]='('.$clause.')';
				}
			}
		}
		if (count($nacclub_clauses)>0) {
			$AND_clauses[]='('.implode(' OR ', $nacclub_clauses).')';
		}
		if (count($AND_clauses)>0) {
			$filter_clause.=' AND '.implode(' AND ', $AND_clauses);
		}

		if ($FILTER_sex) 
			$filter_clause.=" AND $pilotsTable.Sex='$FILTER_sex' ";
		
		$FILTER_cat=0;	
		$FILTER_cat=$FILTER_cat1+$FILTER_cat2+$FILTER_cat4;
		if ($FILTER_cat){
			if ($FILTER_cat==7)	$filter_clause.="";
			if ($FILTER_cat==6)	$filter_clause.=" AND ($flightsTable.cat=2 OR $flightsTable.cat=4) ";
			if ($FILTER_cat==5)	$filter_clause.=" AND ($flightsTable.cat=1 OR $flightsTable.cat=4) ";
			if ($FILTER_cat==3)	$filter_clause.=" AND ($flightsTable.cat=1 OR $flightsTable.cat=2) ";
			if ($FILTER_cat==4)	$filter_clause.=" AND ($flightsTable.cat=4) ";
			if ($FILTER_cat==2)	$filter_clause.=" AND ($flightsTable.cat=2) ";
			if ($FILTER_cat==1)	$filter_clause.=" AND ($flightsTable.cat=1) ";
			//else $filter_clause.=" AND $flightsTable.cat=0 ";
		};
			
		

		if ($FILTER_linear_distance_select)
			$filter_clause.=" AND LINEAR_DISTANCE ".$FILTER_linear_distance_op." ".($FILTER_linear_distance_select*1000)." ";

		if ($FILTER_olc_distance_select)
			$filter_clause.=" AND FLIGHT_KM ".$FILTER_olc_distance_op." ".($FILTER_olc_distance_select*1000)." ";

		if ($FILTER_olc_score_select)
			$filter_clause.=" AND FLIGHT_POINTS ".$FILTER_olc_score_op." ".$FILTER_olc_score_select." ";

		if ($FILTER_olc_type) 
			$filter_clause.=" AND BEST_FLIGHT_TYPE='$FILTER_olc_type' ";


		if ($FILTER_duration_hours_select || $FILTER_duration_minutes_select ) {
			$dur=$FILTER_duration_hours_select*60*60 + $FILTER_duration_minutes_select*60;
			$filter_clause.=" AND DURATION ".$FILTER_duration_op." ".$dur." ";
		}

		$_SESSION["filter_clause"]=$filter_clause;
	      	 //echo "#".$filter_clause."#<br>";
	}

} else { // form not submitted
	// copy session variables (if any) to local variables
	foreach ($_SESSION as $key => $value ) {
		if (is_array($value) ) continue;
		if (substr($key,0,7)=="FILTER_")
			$$key=$value;
			if ($value && $key!="filter_clause") $filterUrl.="&$key=".urlencode($value);
	}

	// put default values
	if (!isset($FILTER_dateType) ) {
		$FILTER_dateType="ALL";
		$FILTER_YEAR_select_op="=";
		$FILTER_YEAR_select=date("Y");
		$FILTER_MONTH_YEAR_select_op="=";
		$FILTER_MONTH_YEAR_select_MONTH=date("m");
		$FILTER_MONTH_YEAR_select_YEAR=date("Y");
		$FILTER_from_day_text="";
		$FILTER_to_day_text="";

		$FILTER_linear_distance_op=">=";
		$FILTER_linear_distance_select="";
		$FILTER_olc_distance_op=">=";
		$FILTER_olc_distance_select="";
		$FILTER_olc_score_op=">=";
		$FILTER_olc_score_select="";
		$FILTER_duration_op=">=";
		$FILTER_duration_hours_select="";
		$FILTER_duration_minutes_select="";
	}

}

// echo "#".$filter_clause;

 openMain(_FILTER_PAGE_TITLE,0,''); 
 
 if ($_REQUEST["FILTER_dateType"])  {
	echo "<center><a href='".getLeonardoLink(array('op'=>'list_flights'))."'>"._RETURN_TO_FLIGHTS."</a> :: </center><br><br>";
	// echo "<a href='$filterUrl'>Bookmark Filter</a><br></center><br><br>";
 }
/* old: if ($_SESSION["filter_clause"]) {
	echo "<center><img src='".$moduleRelPath."/img/icon_filter.png' border=0>"._THE_FILTER_IS_ACTIVE."";
	echo " :: <a href='$filterUrl'>Bookmark Filter</a><br></center><br><br>";
 } else echo "<center><img src='".$moduleRelPath."/img/icon_p5.gif' border=0>"._THE_FILTER_IS_INACTIVE."</center>";
*/
 if ($_SESSION["filter_clause"]) {
	/// Martin Jursa 21.06.2007 add bookmark-javascript
 	$browser=getBrowser();
 	$agent=!empty($browser[0]) ? $browser[0] : '';
 	$is_ie=$agent=='ie';
 	$filterbasename=$_SERVER['SERVER_NAME'];
 	if ($is_ie) {
 		$js="
<script type=\"text/javascript\" language=\"JavaScript\">
<!--
function addFavorite() {
	if (document.all) {
		var url='$filterUrl';
		var title='$filterbasename Filter';
		window.external.AddFavorite(url, title);
	}
}
//   -->
</script>
";
 	}else {
 		$js='';
 	}
	if ($is_ie) {
		echo $js;
	}
	echo "<span class='ok'  style='margin-top:0;'><img src='".$moduleRelPath."/img/icon_filter.png' alinn='absmiddle' border=0> "._THE_FILTER_IS_ACTIVE."";
	if ($is_ie) {
		echo ' :: <a href="javascript:addFavorite();" title="'._Msg_AddToBookmarks_IE.'">'._Explanation_AddToBookmarks_IE.'</a><br></center><br><br>';
	}else {
		echo " :: <a href=\"$filterUrl\" title=\""._Msg_AddToBookmarks_nonIE."\" onclick=\"alert('".addslashes(_Msg_AddToBookmarks_nonIE)."'); return false;\">$filterbasename Filter</a> "._Explanation_AddToBookmarks_nonIE."<br></span><br><br>";
	}
	// end martin jursa 21.06.2007
 } else echo "<span class='note' style='margin-top:0;'>"._THE_FILTER_IS_INACTIVE."</span>";
 $calLang=$lang2iso[$currentlang];
?>
<? if ($_GET['fl_url']) { ?>
<script language='javascript'>
window.location = "<? echo  $redirectUrl ?>"
</script>
<? } ?>
<script language='javascript'>
	var imgDir = '<?=moduleRelPath(); ?>/js/cal/';

	var language = '<?=$calLang?>';
	var startAt = 1;		// 0 - sunday ; 1 - monday
	var visibleOnLoad=0;
	var showWeekNumber = 1;	// 0 - don't show; 1 - show
	var hideCloseButton=0;
	var gotoString 		= {<?=$calLang?> : '<?=_Go_To_Current_Month?>'};
	var todayString 	= {<?=$calLang?> : '<?=_Today_is?>'};
	var weekString 		= {<?=$calLang?> : '<?=_Wk?>'};
	var scrollLeftMessage 	= {<?=$calLang?> : '<?=_Click_to_scroll_to_previous_month?>'};
	var scrollRightMessage 	= {<?=$calLang?>: '<?=_Click_to_scroll_to_next_month?>'};
	var selectMonthMessage 	= {<?=$calLang?> : '<?=_Click_to_select_a_month?>'};
	var selectYearMessage 	= {<?=$calLang?> : '<?=_Click_to_select_a_year?>'};
	var selectDateMessage 	= {<?=$calLang?> : '<?=_Select_date_as_date?>' };
	var	monthName 		= {<?=$calLang?> : new Array(<? foreach ($monthList as $m) echo "'$m',";?>'') };
	var	monthName2 		= {<?=$calLang?> : new Array(<? foreach ($monthListShort as $m) echo "'$m',";?>'')};
	var dayName = {<?=$calLang?> : new Array(<? foreach ($weekdaysList as $m) echo "'$m',";?>'') };

</script>
<script language='javascript' src='<? echo $moduleRelPath ?>/js/cal/popcalendar.js'></script>

<form name="formFilter" method="post" action="">

  <table class=main_text width="564"  border="0" align="center" cellpadding="3" cellspacing="3">
    <tr>
      <td class='infoHeader'><div align="right"><strong><? echo _SELECT_DATE ?></strong></div></td>
      <td class='infoHeader'>&nbsp;</td>
    </tr>
    <tr>
      <td><div align="right"></div></td>
      <td><? echo _SHOW_FLIGHTS ?> </td>
    </tr>
    <tr>
      <td><div align="right">
          <input name="FILTER_dateType" type="radio" value="ALL" <? if ($FILTER_dateType=="ALL") echo "checked" ?> >
        </div></td>
      <td><? echo _ALL2 ?></td>
    </tr>
    <tr>
      <td><div align="right">
          <input name="FILTER_dateType" type="radio" value="YEAR" <? if ($FILTER_dateType=="YEAR") echo "checked" ?>>
        </div></td>
      <td> <? echo _WITH_YEAR ?>
        <select name="FILTER_YEAR_select_op">
          <option value="=" <? if ($FILTER_YEAR_select_op=="=") echo "selected" ?>>=</option>
          <option value=">=" <? if ($FILTER_YEAR_select_op==">=") echo "selected" ?>>&gt;=</option>
          <option value="<=" <? if ($FILTER_YEAR_select_op=="<=") echo "selected" ?>>&lt;=</option>
        </select> <select name="FILTER_YEAR_select">
          <?
			 for($i=$CONF_StartYear;$i<=date("Y");$i++)  {
			 	$sel=($i==$FILTER_YEAR_select)?"selected":"";
				echo  "<option value='$i' $sel>$i</option>";
			 }
		   ?>
        </select></td>
    </tr>
    <tr>
      <td><div align="right"> <? echo _OR ?>
          <input name="FILTER_dateType" type="radio" value="MONTH_YEAR" <? if ($FILTER_dateType=="MONTH_YEAR") echo "checked" ?> >
        </div></td>
      <td><select name="FILTER_MONTH_YEAR_select_op">
          <option value="="   <? if ($FILTER_MONTH_YEAR_select_op=="=") echo "selected" ?>>=</option>
          <option value=">="  <? if ($FILTER_MONTH_YEAR_select_op==">=") echo "selected" ?>>&gt;=</option>
          <option value="<="  <? if ($FILTER_MONTH_YEAR_select_op=="<=") echo "selected" ?>>&lt;=</option>
        </select>
        <? echo _MONTH ?>
        <select name="FILTER_MONTH_YEAR_select_MONTH">
          <? $i=1;

			 foreach ($monthList as $monthName)  {
			 $sel=($i==$FILTER_MONTH_YEAR_select_MONTH+0)?"selected":"";
			 	$k=sprintf("%02s",$i);
				echo  "<option value='$k' $sel>$monthName</option>";
				$i++;
			 }
		   ?>
        </select>
        <? echo _YEAR ?>
        <select name="FILTER_MONTH_YEAR_select_YEAR">
          <?
			 for($i=$CONF_StartYear;$i<=date("Y");$i++)  {
			 	$sel=($i==$FILTER_MONTH_YEAR_select_YEAR)?"selected":"";
				echo  "<option value='$i' $sel>$i</option>";
			 }
		   ?>
        </select></td>
    </tr>
    <tr>
      <td><div align="right"> <? echo _OR ?>
          <input name="FILTER_dateType" type="radio" value="DATE_RANGE" <? if ($FILTER_dateType=="DATE_RANGE") echo "checked" ?>>
        </div></td>
      <td><p><? echo _From ; ?>
          <input name="FILTER_from_day_text" type="text" size="10" maxlength="10" value="<?=$FILTER_from_day_text ?>" >
          <a href="javascript:showCalendar(document.formFilter.cal_from_button, document.formFilter.FILTER_from_day_text, 'dd.mm.yyyy','<? echo $calLang ?>',0,-1,-1)">
          <img name='cal_from_button' src="<? echo $moduleRelPath ?>/img/cal.gif" width="16" height="16" border="0"></a>
          <br>
          <? echo _TO ?>
          <input name="FILTER_to_day_text" type="text" size="10" maxlength="10" value="<?=$FILTER_to_day_text ?>" >
          <a href="javascript:showCalendar(document.formFilter.cal_to_button, document.formFilter.FILTER_to_day_text, 'dd.mm.yyyy','<? echo $calLang ?>',0,-1,-1)">
          <img name='cal_to_button' src="<? echo $moduleRelPath ?>/img/cal.gif" width="16" height="16" border="0"><br>
          </a></p></td>
    </tr>
<?

foreach ($filterkeys as $filterkey) {
	$html=$dlgfilters[$filterkey]->filter_html();
	echo $html;
}


?>

    <tr>
      <td class='infoHeader'><div align="right"><strong><? echo _OTHER_FILTERS ?></strong></div></td>
      <td class='infoHeader'>&nbsp;</td>
    </tr>

	<tr>
 		<td><div align="right"><? echo _Sex ?> </div></td>		
		<td><select name="FILTER_sex">
          <option value=""></option>
          <option value="M" <? if ($FILTER_sex=="M") echo "selected" ?>><?=_Male?></option>
          <option value="F" <? if ($FILTER_sex=="F") echo "selected" ?>><?=_Female?></option>
        </select>
		</td>
	</tr>
	<tr>
 		<td><div align="right"><? echo _Category ?> </div></td>		
		<td>
          <input type="checkbox" name="FILTER_cat1" value="1" checked> <?=_PG?>
   		  <input type="checkbox" name="FILTER_cat2" value="2" checked> <?=_HG?>
    	  <input type="checkbox" name="FILTER_cat4" value="4" checked> <?=_RG?>
        </td>
	</tr>
    <tr>
      <td><div align="right"><? echo _LINEAR_DISTANCE_SHOULD_BE ?> </div></td>
      <td><select name="FILTER_linear_distance_op">
          <option value=">=" <? if ($FILTER_linear_distance_op==">=") echo "selected" ?>>&gt;=</option>
          <option value="<=" <? if ($FILTER_linear_distance_op=="<=") echo "selected" ?>>&lt;=</option>
        </select> <input name="FILTER_linear_distance_select" type="text" size="5" value="<? echo $FILTER_linear_distance_select ?>">
        Km</td>
    </tr>
    <tr>
      <td><div align="right"><? echo _OLC_DISTANCE_SHOULD_BE ?> </div></td>
      <td><select name="FILTER_olc_distance_op">
          <option value=">=" <? if ($FILTER_olc_distance_op==">=") echo "selected" ?>>&gt;=</option>
          <option value="<=" <? if ($FILTER_olc_distance_op=="<=") echo "selected" ?>>&lt;=</option>
        </select> <input name="FILTER_olc_distance_select" type="text" size="5" value="<? echo $FILTER_olc_distance_select ?>">
        Km</td>
    </tr>
    <tr>
      <td><div align="right"><? echo _OLC_SCORE_SHOULD_BE ?> </div></td>
      <td><select name="FILTER_olc_score_op">
          <option value=">=" <? if ($FILTER_olc_score_op==">=") echo "selected" ?>>&gt;=</option>
          <option value="<=" <? if ($FILTER_olc_score_op=="<=") echo "selected" ?>>&lt;=</option>
        </select> <input name="FILTER_olc_score_select" type="text" size="5" value="<? echo $FILTER_olc_score_select ?>"></td>
    </tr>
	
	<tr>
 		<td><div align="right"><? echo _OLC_SCORE_TYPE ?> </div></td>		
		<td><select name="FILTER_olc_type">
          <option value=""></option>
          <option value="FREE_FLIGHT"   <? if ($FILTER_olc_type=="FREE_FLIGHT") echo "selected" ?>><?=_FREE_FLIGHT?></option>
          <option value="FREE_TRIANGLE" <? if ($FILTER_olc_type=="FREE_TRIANGLE") echo "selected" ?>><?=_FREE_TRIANGLE?></option>
		  <option value="FAI_TRIANGLE"  <? if ($FILTER_olc_type=="FAI_TRIANGLE") echo "selected" ?>><?=_FAI_TRIANGLE?></option>
        </select>
		</td>
	</tr>
	
    <tr>
      <td><div align="right"><? echo _DURATION_SHOULD_BE ?> </div></td>
      <td><select name="FILTER_duration_op">
          <option value=">=" <? if ($FILTER_duration_op==">=") echo "selected" ?>>&gt;=</option>
          <option value="<=" <? if ($FILTER_duration_op=="<=") echo "selected" ?>>&lt;=</option>
        </select> <input name="FILTER_duration_hours_select" type="text" size="2" value="<? echo $FILTER_duration_hours_select ?>">
        <? echo _HOURS ?> :
        <input name="FILTER_duration_minutes_select" type="text" size="2" value="<? echo $FILTER_duration_minutes_select ?>">
        <? echo _MINUTES ?></td>
    </tr>
    <tr>
      <td><div align="right"></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
          <input type="submit" name="SubmitButton" id="SubmitButton" value="<? echo _ACTIVATE_CHANGE_FILTER ?>">
          &nbsp;
          <input type="hidden" name="clearFilter" id="clearFilter" value="0">
          <input type="submit" name="clearFilterButton" id="clearFilterButton" value="<? echo _DEACTIVATE_FILTER ?>" onClick="document.formFilter.clearFilter.value=1">
        </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
<?
	closeMain();
?>
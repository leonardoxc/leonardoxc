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

$pilotsList=array();
$pilotsID=array();
list($pilotsList,$pilotsID)=getPilotList();
list($takeoffs,$takeoffsID)=getTakeoffList();
list($countriesCodes,$countriesNames)=getCountriesList();

$filterUrl="http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/".$CONF_mainfile."?name=".$module_name."&op=filter&fl_url=1";
$redirectUrl="http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/".$CONF_mainfile."?name=".$module_name."&op=list_flights&sortOrder=DATE&year=0&month=0&pilotID=0";

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
		
		$count=0;
		for ($i=1;$i<=3;$i++) {
			$varname="FILTER_pilot".$i."_select";
			$op_varname="FILTER_pilot".$i."_select_op";
			if ( $$varname ) {
				if ($count==0) { // open ( 
					$filter_clause.=" AND ( ";
					$first_op=$$op_varname;
					$inter_op=($first_op=="=")?" AND ":" OR ";
				} else {
					$filter_clause.=($first_op=="=")?" OR ":" AND ";
					
				}
				$this_op=$first_op;
				list($thisUserServerID,$thisUserID)=splitServerPilotStr($$varname);
				$filter_clause.=" ( userID $this_op $thisUserID $inter_op userServerID $this_op $thisUserServerID) ";
				$count++;
			}
		}
		if ($count) $filter_clause.=" ) ";
	
		$count=0;
		for ($i=1;$i<=3;$i++) {
			$varname="FILTER_takeoff".$i."_select";
			$op_varname="FILTER_takeoff".$i."_select_op";
			if ( $$varname>0 ) {
				if ($count==0) { // open ( 
					$filter_clause.=" AND ( ";
					$first_op=$$op_varname;
				} else {
					$filter_clause.=($first_op=="=")?" OR ":" AND ";
				}
				$this_op=$first_op;
				$filter_clause.=" ( takeoffID  ".$this_op." '".($$varname)."' ) ";
				$count++;
			}
		}
		if ($count) $filter_clause.=" ) ";
	
		$count=0;
		for ($i=1;$i<=3;$i++) {
			$varname="FILTER_country".$i."_select";
			$op_varname="FILTER_country".$i."_select_op";
			if ( $$varname!='' ) {
				if ($count==0) { // open ( 
					$filter_clause.=" AND ( ";
					$first_op=$$op_varname;
				} else {
					$filter_clause.=($first_op=="=")?" OR ":" AND ";
				}
				$this_op=$first_op;
				$filter_clause.=" ( countryCode  ".$this_op." '".($$varname)."' ) ";
				$count++;
			}
		}
		if ($count) $filter_clause.=" ) ";
	

		if ($FILTER_linear_distance_select)
			$filter_clause.=" AND LINEAR_DISTANCE ".$FILTER_linear_distance_op." ".($FILTER_linear_distance_select*1000)." ";

		if ($FILTER_olc_distance_select)
			$filter_clause.=" AND FLIGHT_KM ".$FILTER_olc_distance_op." ".($FILTER_olc_distance_select*1000)." ";

		if ($FILTER_olc_score_select)
			$filter_clause.=" AND FLIGHT_POINTS ".$FILTER_olc_score_op." ".$FILTER_olc_score_select." ";

		if ($FILTER_duration_hours_select || $FILTER_duration_minutes_select ) {
			$dur=$FILTER_duration_hours_select*60*60 + $FILTER_duration_minutes_select*60;
			$filter_clause.=" AND DURATION ".$FILTER_duration_op." ".$dur." ";
		}

		$_SESSION["filter_clause"]=$filter_clause;
		// echo "#".$filter_clause."#<br>";
	}
	
} else { // form not submitted
	// copy session variables (if any) to local variables
	foreach ($_SESSION as $key => $value ) {
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
		$FILTER_pilot1_select_op="=";
		$FILTER_pilot1_select="";
		$FILTER_pilot2_select_pretext=_OR;
		$FILTER_pilot2_select_op=_IS;
		$FILTER_pilot2_select="";
		$FILTER_pilot3_select_pretext=_OR;
		$FILTER_pilot3_select_op=_IS;
		$FILTER_pilot3_select="";
		$FILTER_takeoff1_select_op="=";
		$FILTER_takeoff1_select=0;
		$FILTER_takeoff2_select_pretext=_OR;
		$FILTER_takeoff2_select_op=_IS;
		$FILTER_takeoff2_select=0;
		$FILTER_takeoff3_select_pretext=_OR;
		$FILTER_takeoff3_select_op=_IS;
		$FILTER_takeoff3_select=0;

		$FILTER_country1_select_op="=";
		$FILTER_country1_select="";
		$FILTER_country2_select_pretext=_OR;
		$FILTER_country2_select_op=_IS;
		$FILTER_country2_select="";
		$FILTER_country3_select_pretext=_OR;
		$FILTER_country3_select_op=_IS;
		$FILTER_country3_select="";

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

	if ($FILTER_pilot1_select_op=="=") {
		$FILTER_pilot2_select_pretext=_OR;
		$FILTER_pilot2_select_op=_IS;
		$FILTER_pilot3_select_pretext=_OR;
		$FILTER_pilot3_select_op=_IS;
    } else {
		$FILTER_pilot2_select_pretext=_AND;
		$FILTER_pilot2_select_op=_IS_NOT;
		$FILTER_pilot3_select_pretext=_AND;
		$FILTER_pilot3_select_op=_IS_NOT;	
	}
	
	if ($FILTER_takeoff1_select_op=="=") {
		$FILTER_takeoff2_select_pretext=_OR;
		$FILTER_takeoff2_select_op=_IS;
		$FILTER_takeoff3_select_pretext=_OR;
		$FILTER_takeoff3_select_op=_IS;
    } else {
		$FILTER_takeoff2_select_pretext=_AND;
		$FILTER_takeoff2_select_op=_IS_NOT;
		$FILTER_takeoff3_select_pretext=_AND;
		$FILTER_takeoff3_select_op=_IS_NOT;	
	}
 
	if ($FILTER_country1_select_op=="=") {
		$FILTER_country2_select_pretext=_OR;
		$FILTER_country2_select_op=_IS;
		$FILTER_country3_select_pretext=_OR;
		$FILTER_country3_select_op=_IS;
    } else {
		$FILTER_country2_select_pretext=_AND;
		$FILTER_country2_select_op=_IS_NOT;
		$FILTER_country3_select_pretext=_AND;
		$FILTER_country3_select_op=_IS_NOT;	
	}
 
 open_inner_table(_FILTER_PAGE_TITLE,700); echo "<tr><td>";
 if ($_REQUEST["FILTER_dateType"])  { 
	echo "<center><a href='?name=".$module_name."&op=list_flights'>"._RETURN_TO_FLIGHTS."</a> :: </center><br><br>";
	// echo "<a href='$filterUrl'>Bookmark Filter</a><br></center><br><br>";
 }
 if ($_SESSION["filter_clause"]) { 
	echo "<center><img src='".$moduleRelPath."/img/icon_filter.png' border=0>"._THE_FILTER_IS_ACTIVE."";
	echo " :: <a href='$filterUrl'>Bookmark Filter</a><br></center><br><br>";
 } else echo "<center><img src='".$moduleRelPath."/img/icon_p5.gif' border=0>"._THE_FILTER_IS_INACTIVE."</center>";

 $calLang=$lang2iso[$currentlang];
?>
<? if ($_GET['fl_url']) { ?>
<script language='javascript'>
window.location = "<? echo  $redirectUrl ?>"
</script>
<? } ?>
<script language='javascript'>
	var imgDir = 'modules/<?=$module_name ?>/js/cal/';

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
  <br>
  <table class=main_text width="564"  border="0" align="center" cellpadding="1" cellspacing="1">
    <tr> 
      <td bgcolor="#FF9966"><div class='whiteLetter' align="right"><strong><? echo _SELECT_DATE ?></strong></div></td>
      <td>&nbsp;</td>
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
			 for($i=$CONF['years']['start_year'];$i<=$CONF['years']['end_year'];$i++)  {
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
 			 for($i=$CONF['years']['start_year'];$i<=$CONF['years']['end_year'];$i++)  {
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
    <tr> 
      <td bgcolor="#FF9966"><div align="right"><span class="whiteLetter"><strong><? echo _SELECT_PILOT ?></strong></span></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td><div align="right"><? echo _THE_PILOT ?> </div></td>
      <td> <script language="JavaScript">
		function setVal(value1)
		{
			if (value1=='=') { 
				document.formFilter.FILTER_pilot2_select_pretext.value = "<? echo _OR ?>";
				document.formFilter.FILTER_pilot2_select_op.value = "<? echo _IS ?>";
				document.formFilter.FILTER_pilot3_select_pretext.value = "<? echo _OR ?>";
				document.formFilter.FILTER_pilot3_select_op.value = "<? echo _IS ?>";
			} else {
				document.formFilter.FILTER_pilot2_select_pretext.value = "<? echo _AND ?>";
				document.formFilter.FILTER_pilot2_select_op.value = "<? echo _IS_NOT ?>";
				document.formFilter.FILTER_pilot3_select_pretext.value = "<? echo _AND ?>";
				document.formFilter.FILTER_pilot3_select_op.value = "<? echo _IS_NOT ?>";
			}
		}

		function setVal2(value1)
		{
			if (value1=='=') { 
				document.formFilter.FILTER_takeoff2_select_pretext.value = "<? echo _OR ?>";
				document.formFilter.FILTER_takeoff2_select_op.value = "<? echo _IS ?>";
				document.formFilter.FILTER_takeoff3_select_pretext.value = "<? echo _OR ?>";
				document.formFilter.FILTER_takeoff3_select_op.value = "<? echo _IS ?>";
			} else {
				document.formFilter.FILTER_takeoff2_select_pretext.value = "<? echo _AND ?>";
				document.formFilter.FILTER_takeoff2_select_op.value = "<? echo _IS_NOT ?>";
				document.formFilter.FILTER_takeoff3_select_pretext.value = "<? echo _AND ?>";
				document.formFilter.FILTER_takeoff3_select_op.value = "<? echo _IS_NOT ?>";
			}
		}		

		function setVal3(value1)
		{
			if (value1=='=') { 
				document.formFilter.FILTER_country2_select_pretext.value = "<? echo _OR ?>";
				document.formFilter.FILTER_country2_select_op.value = "<? echo _IS ?>";
				document.formFilter.FILTER_country3_select_pretext.value = "<? echo _OR ?>";
				document.formFilter.FILTER_country3_select_op.value = "<? echo _IS ?>";
			} else {
				document.formFilter.FILTER_country2_select_pretext.value = "<? echo _AND ?>";
				document.formFilter.FILTER_country2_select_op.value = "<? echo _IS_NOT ?>";
				document.formFilter.FILTER_country3_select_pretext.value = "<? echo _AND ?>";
				document.formFilter.FILTER_country3_select_op.value = "<? echo _IS_NOT ?>";
			}
		}		
		</script> <select name="FILTER_pilot1_select_op" onchange="setVal(this.value)" >
          <option value="="  <? if ($FILTER_pilot1_select_op=="=") echo "selected" ?>><? echo _IS ?></option>
          <option value="<>" <? if ($FILTER_pilot1_select_op=="<>") echo "selected" ?>><? echo _IS_NOT ?></option>
        </select> <select name="FILTER_pilot1_select" id="FILTER_pilot1_select">
          <option></option>
          <? 
					for($k=0;$k<count($pilotsList);$k++) {
						$sel=($pilotsID[$k]==$FILTER_pilot1_select)?"selected":"";
						echo "<option value='".$pilotsID[$k]."' $sel>".$pilotsList[$k]."</option>\n";
					}
				?>
        </select> </td>
    </tr>
    <tr> 
      <td><div align="right"> 
          <input name="FILTER_pilot2_select_pretext" type="text" size="4" disabled value="<? echo $FILTER_pilot2_select_pretext ?>">
        </div></td>
      <td>
		  <input text name="FILTER_pilot2_select_op" type="text" size="13" disabled value="<? echo $FILTER_pilot2_select_op?>">
		  <select name="FILTER_pilot2_select" id="FILTER_pilot2_select">
          <option></option>
          <? 
					for($k=0;$k<count($pilotsList);$k++) {
						$sel=($pilotsID[$k]==$FILTER_pilot2_select)?"selected":"";
						echo "<option value='".$pilotsID[$k]."' $sel>".$pilotsList[$k]."</option>\n";
					}
		  ?>
        </select> </td>
    </tr>
    <tr> 
      <td width="205"><div align="right"> 
          <input name="FILTER_pilot3_select_pretext" type="text" size="4" disabled value="<? echo $FILTER_pilot3_select_pretext ?>">
        </div></td>
      <td width="352"> <input text name="FILTER_pilot3_select_op" type="text" size="13" disabled value="<? echo $FILTER_pilot3_select_op?>"> 
        <select name="FILTER_pilot3_select" id="FILTER_pilot3_select">
          <option></option>
          <? 
					for($k=0;$k<count($pilotsList);$k++) {
					    $sel=($pilotsID[$k]==$FILTER_pilot3_select)?"selected":"";
						echo "<option value='".$pilotsID[$k]."' $sel>".$pilotsList[$k]."</option>\n";
					}
				?>
        </select> </td>
    </tr>
    <tr> 
      <td bgcolor="#FF9966"><div align="right"><span class="whiteLetter"><strong><? echo _SELECT_TAKEOFF ?></strong></span></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td><div align="right"><? echo _THE_TAKEOFF ?> </div></td>
      <td><select name="FILTER_takeoff1_select_op" onchange="setVal2(this.value)">
          <option value="="  <? if ($FILTER_takeoff1_select_op=="=") echo "selected" ?>><? echo _IS ?></option>
          <option value="<>" <? if ($FILTER_takeoff1_select_op=="<>") echo "selected" ?>><? echo _IS_NOT ?></option>
        </select> <select name="FILTER_takeoff1_select" id="FILTER_takeoff1_select">
          <option></option>
          <? 
					for($k=0;$k<count($takeoffs);$k++) {
 					    $sel=($takeoffsID[$k]==$FILTER_takeoff1_select)?"selected":"";
						echo "<option value='".$takeoffsID[$k]."' $sel>".$takeoffs[$k]."</option>\n";
					}
				?>
        </select> </td>
    </tr>
    <tr> 
      <td><div align="right"> 
          <input name="FILTER_takeoff2_select_pretext" type="text" size="4" disabled value="<? echo $FILTER_takeoff2_select_pretext ?>">
        </div></td>
      <td> 
  		  <input text name="FILTER_takeoff2_select_op" type="text" size="13" disabled value="<? echo $FILTER_takeoff2_select_op?>">
		  <select name="FILTER_takeoff2_select" id="FILTER_takeoff2_select">
          <option></option>
          <? 
					for($k=0;$k<count($takeoffs);$k++) {
 					    $sel=($takeoffsID[$k]==$FILTER_takeoff2_select)?"selected":"";
						echo "<option value='".$takeoffsID[$k]."' $sel>".$takeoffs[$k]."</option>\n";
					}
				?>
        </select> </td>
    </tr>
    <tr> 
      <td><div align="right"> 
          <input name="FILTER_takeoff3_select_pretext" type="text" size="4" disabled value="<? echo $FILTER_takeoff3_select_pretext ?>">
        </div></td>
      <td>   		  
	    <input text name="FILTER_takeoff3_select_op" type="text" size="13" disabled value="<? echo $FILTER_takeoff3_select_op?>">
        <select name="FILTER_takeoff3_select" id="FILTER_takeoff3_select">
          <option></option>
          <? 
					for($k=0;$k<count($takeoffs);$k++) {
						$sel=($takeoffsID[$k]==$FILTER_takeoff3_select)?"selected":"";
						echo "<option value='".$takeoffsID[$k]."' $sel>".$takeoffs[$k]."</option>\n";
					}
				?>
        </select> </td>
    </tr>
<tr> 
      <td bgcolor="#FF9966"><div align="right"><span class="whiteLetter"><strong><? echo _SELECT_COUNTRY ?></strong></span></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td><div align="right"><? echo _THE_COUNTRY  ?> </div></td>
      <td><select name="FILTER_country1_select_op" onchange="setVal3(this.value)">
          <option value="="  <? if ($FILTER_country1_select_op=="=") echo "selected" ?>><? echo _IS ?></option>
          <option value="<>" <? if ($FILTER_country1_select_op=="<>") echo "selected" ?>><? echo _IS_NOT ?></option>
        </select> <select name="FILTER_country1_select" id="FILTER_country1_select">
          <option></option>
          <? 
					for($k=0;$k<count($countriesCodes);$k++) {
 					    $sel=($countriesCodes[$k]==$FILTER_country1_select)?"selected":"";
						echo "<option value='".$countriesCodes[$k]."' $sel>".$countriesNames[$k]." (".$countriesCodes[$k].")</option>\n";
					}
				?>
        </select> </td>
    </tr>
    <tr> 
      <td><div align="right"> 
          <input name="FILTER_country2_select_pretext" type="text" size="4" disabled value="<? echo $FILTER_country2_select_pretext ?>">
        </div></td>
      <td> 
  		  <input text name="FILTER_country2_select_op" type="text" size="13" disabled value="<? echo $FILTER_country2_select_op?>">
		  <select name="FILTER_country2_select" id="FILTER_country2_select">
          <option></option>
          <? 
					for($k=0;$k<count($countriesCodes);$k++) {
 					    $sel=($countriesCodes[$k]==$FILTER_country2_select)?"selected":"";
						echo "<option value='".$countriesCodes[$k]."' $sel>".$countriesNames[$k]." (".$countriesCodes[$k].")</option>\n";
					}
				?>
        </select> </td>
    </tr>
    <tr> 
      <td><div align="right"> 
          <input name="FILTER_country3_select_pretext" type="text" size="4" disabled value="<? echo $FILTER_country3_select_pretext ?>">
        </div></td>
      <td>   		  
	    <input text name="FILTER_country3_select_op" type="text" size="13" disabled value="<? echo $FILTER_country3_select_op?>">
        <select name="FILTER_country3_select" id="FILTER_country3_select">
          <option></option>
          <? 
					for($k=0;$k<count($countriesCodes);$k++) {
						$sel=($countriesCodes[$k]==$FILTER_country3_select)?"selected":"";
						echo "<option value='".$countriesCodes[$k]."' $sel>".$countriesNames[$k]." (".$countriesCodes[$k].")</option>\n";
					}
				?>
        </select> </td>
    </tr>
    <tr> 
      <td bgcolor="#FF9966"><div align="right"><span class="whiteLetter"><strong><? echo _OTHER_FILTERS ?></strong></span></div></td>
      <td>&nbsp;</td>
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
          <option value=">=" <? if ($FILTER_YEAR_select_op==">=") echo "selected" ?>>&gt;=</option>
          <option value="<=" <? if ($FILTER_YEAR_select_op=="<=") echo "selected" ?>>&lt;=</option>
        </select> <input name="FILTER_olc_score_select" type="text" size="5" value="<? echo $FILTER_olc_score_select ?>"></td>
    </tr>
    <tr> 
      <td><div align="right"><? echo _DURATION_SHOULD_BE ?> </div></td>
      <td><select name="FILTER_duration_op">
          <option value=">=" <? if ($FILTER_YEAR_select_op==">=") echo "selected" ?>>&gt;=</option>
          <option value="<=" <? if ($FILTER_YEAR_select_op=="<=") echo "selected" ?>>&lt;=</option>
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
  close_inner_table();  

?>

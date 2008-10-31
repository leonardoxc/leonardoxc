<?php

/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://sourceforge.net/projects/leonardoserver                       */
/* http://leonardo.thenet.gr                                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

if ( $op!='comp' ) {
	if (! $CONF['seasons']['use_season_years'] ) $season=0;

	$tblWidth=240;
	if ($op=="list_flights" && $CONF_use_calendar) $tblWidth=495;
	
	if ($CONF['seasons']['use_season_years']) $tblWidth+=70;

?>

<table class="dropDownBox" width="<?=$tblWidth?>" cellpadding="2" cellspacing="0">
<tr>
	<td colspan=5 height=25 class="main_text" bgcolor="#40798C">
		<div class="style1" align="center"><strong><?=_SELECT_DATE?> <?=_OR?></strong></div>
	</td>
	
</tr>
<tr>
	<td colspan=5 height=20 class="dropDownBoxH2" >
		<div class="dropDownBoxH2">
			<a style='text-align:center; text-decoration:underline;' href='<?=getLeonardoLink(array('op'=>'useCurrent','season'=>'0','year'=>'0','month'=>'0','day'=>'0','season'=>'0'))?>'><?=_ALL_YEARS?></a>
		</div>
	</td>
</tr>
<tr>
<?
	if ($CONF['seasons']['use_season_years'] ) {
		echo '<td class="tableBox" valign="top" style="width:70px"><strong>SEASON</strong>';
	} else {
		echo '<td>';
	}
	echo '</td>';

	if ($op=="list_flights" &&  $CONF_use_calendar ) {
		echo '<td class="tableBox" valign="top" style="width:255px"><strong>'._DAY.'</strong>';
	} else { 
		echo '<td>';
	}
	echo '</td>';

?>

	<td class="tableBox" valign="top" style="width:60px">
		<strong><?=_YEAR?></strong>
	</td>
	<td class="tableBox" valign="top" style="width:90px">
		<strong><?=_MONTH?></strong>
	</td>
    <td class="tableBox" valign="top" style="width:110px"><strong><?=_Recent?></strong></td>
</tr>
<tr>
<?
if ($CONF['seasons']['use_season_years'] ) {
	echo '<td class="sp " valign="top">';
   	if ($season) $seasonLegend=_SEASON.' '.$season;
	else $seasonLegend=_SELECT_SEASON;

	$seasonStr="";
	
	if ($CONF['seasons']['use_defined_seasons']) {
	
		foreach ($CONF['seasons']['seasons'] as $thisSeason=>$seasonDetails) {
			$seasonStr.="<a href='".getLeonardoLink(array('op'=>'useCurrent','season'=>$thisSeason))."'>$thisSeason</a>\n";		
		}
	
	} else {
		for ( $thisSeason=$CONF['seasons']['end_season']; $thisSeason>=$CONF['seasons']['start_season'] ; $thisSeason--) {
			$seasonStr.="<a href='".getLeonardoLink(array('op'=>'useCurrent','season'=>$thisSeason))."'>$thisSeason</a>\n";
		}
	}	
	echo $seasonStr."";
	echo '</td>';
} else {
	echo '<td></td>';
}
?>

<? if ($op=="list_flights" && $CONF_use_calendar) {?>
	<td class="calBox" valign="top" style="width:255px">		
<? 
		$calLang=$lang2iso[$currentlang]; 
		if (!$day) $day=date("d");
		if (!$month) $month=date("m");
		if (!$year)  $year=date("Y");
		$dateStr=sprintf("%02d.%02d.%04d",$day,$month,$year);
 ?>
<script language='javascript'>
	var thisUrl= '<?=getLeonardoLink(array('op'=>'useCurrent','season'=>'0','year'=>'%year%','month'=>'%month%','day'=>'%day%'))?>';
	var imgDir = '<?=$moduleRelPath ?>/js/cal/';

	var language = '<?=$calLang?>';	
	var startAt = 1;		// 0 - sunday ; 1 - monday
	var visibleOnLoad=1;
	var showWeekNumber = 0;	// 0 - don't show; 1 - show
	var hideCloseButton=1;
	var gotoString 		= {'<?=$calLang?>' : '<?=_Go_To_Current_Month?>'};
	var todayString 	= {'<?=$calLang?>' : '<?=_Today_is?>'};
	var weekString 		= {'<?=$calLang?>' : '<?=_Wk?>'};
	var scrollLeftMessage 	= {'<?=$calLang?>' : '<?=_Click_to_scroll_to_previous_month?>'};
	var scrollRightMessage 	= {'<?=$calLang?>': '<?=_Click_to_scroll_to_next_month?>'};
	var selectMonthMessage 	= {'<?=$calLang?>' : '<?=_Click_to_select_a_month?>'};
	var selectYearMessage 	= {'<?=$calLang?>' : '<?=_Click_to_select_a_year?>'};
//	var selectYearMessage 	= '<?=_Click_to_select_a_year?>';
	var selectDateMessage 	= {'<?=$calLang?>' : '<?=_Select_date_as_date?>' };
	var	monthName 		= {'<?=$calLang?>' : new Array(<? foreach ($monthList as $m) echo "'$m',";?>'') };
	var	monthName2 		= {'<?=$calLang?>' : new Array(<? foreach ($monthListShort as $m) echo "'$m',";?>'')};
	var dayName = {'<?=$calLang?>' : new Array(<? foreach ($weekdaysList as $m) echo "'$m',";?>'') };

</script>
<script language='javascript' src='<? echo $moduleRelPath ?>/js/cal/popcalendar.js'></script>
<form name="formFilter" id="formFilter">
          <input id="DAY_SELECT" name="DAY_SELECT" type="text" size="10" maxlength="10" value="<?=$dateStr ?>" >
          <a href="javascript:showCalendar(document.formFilter.cal_from_button, document.formFilter.FILTER_from_day_text, 'dd.mm.yyyy','<? echo $calLang ?>',0,2,40)"> 
          <img name='cal_from_button' id='cal_from_button' src="<? echo $moduleRelPath ?>/img/cal.gif" width="16" height="16" border="0"></a> 
</form>
<script language='javascript'>

 init();
 showCalendar(this, document.formFilter.DAY_SELECT, 'dd.mm.yyyy','<? echo $calLang ?>',0,<? echo ($CONF['seasons']['use_season_years']?76:6)?>,67);
</script>
</td>
<? } else { ?>
<td></td>
<? } ?>

	<td class="sp " valign="top">
	<?  
			
		 for($i=$CONF['years']['end_year'];$i>=$CONF['years']['start_year'];$i--)  {
			echo "<a href='".getLeonardoLink(array('op'=>'useCurrent','season'=>'0','year'=>$i,'month'=>'0','day'=>'0'))."'>$i</a>";		
		}
	?>
	</td>
	<td valign="top">
	<?
		$i=1;
		foreach ($monthList as $monthName)  {		 
			$k=sprintf("%02s",$i);
			echo "<a href='".getLeonardoLink(array('op'=>'useCurrent','season'=>'0','month'=>$k,'day'=>'0'))."'>$monthName</a>";		
			$i++;
		 }
	?>
	</td>
    <td valign="top">
<? 
	 $month_num=date("m");
	 $year_num=date("Y");
     for ($i=0;$i<8;$i++) {
	    echo "<a href='".getLeonardoLink(array('op'=>'useCurrent','season'=>'0','year'=>$year_num,'month'=>$month_num,'day'=>'0'))."'>".($monthList[$month_num-1]." ".$year_num)."</a>";
		$month_num--;
		if ($month_num==0) { 
			$year_num--; 
			$month_num=12; 
		}
		$month_num=sprintf("%02s",$month_num);
	 }	 
	?>

	</td>
</tr>
</TABLE>
<? } else { 
//-----------------------------------------------
//-----------------------------------------------
// simple years / seasons dropdown for xc league
//-----------------------------------------------
//-----------------------------------------------
	$dWidth=10;
	if ($CONF['seasons']['use_season_years'] ) $dWidth+=70;
	if ($CONF['years']['use_calendar_years'] ) $dWidth+=70;
?>

<table class="dropDownBox" width="<=$dWidth?>" cellpadding="2" cellspacing="0">
<tr>
<?
	if ($CONF['seasons']['use_season_years'] ) {
		echo '<td class="tableBox" valign="top" style="width:70px"><strong>'._SEASON.'</strong></td>';
	} else {
		echo '<td></td>';
	}


	if ($CONF['years']['use_calendar_years'] ) {
		echo '<td class="tableBox" valign="top" style="width:70px"><strong>'._YEAR.'</strong></td>';
	} else {
		echo '<td></td>';
	}

	
?>
<tr>
<?
if ($CONF['seasons']['use_season_years'] ) {
	echo '<td class="sp " valign="top">';
   	if ($season) $seasonLegend=_SEASON.' '.$season;
	else $seasonLegend=_SELECT_SEASON;

	$seasonStr="";
			
	if ($CONF['seasons']['use_defined_seasons']) {
	
		foreach ($CONF['seasons']['seasons'] as $thisSeason=>$seasonDetails) {
			$seasonStr.="<a href='".getLeonardoLink(array('op'=>'useCurrent','season'=>$thisSeason,'year'=>'0','month'=>'0','day'=>'0'))."'>$thisSeason</a>\n";		
		}
	
	} else {
		for ( $thisSeason=$CONF['seasons']['end_season']; $thisSeason>=$CONF['seasons']['start_season'] ; $thisSeason--) {
			$seasonStr.="<a href='".getLeonardoLink(array('op'=>'useCurrent','season'=>$thisSeason,'year'=>'0','month'=>'0','day'=>'0'))."'>$thisSeason</a>\n";
		}
	}	
	echo $seasonStr."";
	echo '</td>';
} else {
	echo '<td></td>';
}

?>

    <? 	if ($CONF['years']['use_calendar_years'] ) { ?>
	<td class="sp " valign="top">
	<?  
		// echo "<a href='".CONF_MODULE_ARG."&year=0&month=0'>"._ALL_YEARS."</a>";		
		for($i=$CONF['years']['end_year'];$i>=$CONF['years']['start_year'];$i--)  {
			echo "<a href='".CONF_MODULE_ARG."&season=0&year=$i&month=0&day=0'>$i</a>";		
		}
	?>
	<a style='text-decoration:underline;' href='<?=CONF_MODULE_ARG?>&year=0&month=0&day=0&season=0'><?=_ALL_YEARS?></a>
	</td>
	<? } else { ?>
	
	<? } ?>
</tr>
</TABLE>


<? } ?>
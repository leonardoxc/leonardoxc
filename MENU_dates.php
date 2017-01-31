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
// $Id: MENU_dates.php,v 1.9 2010/03/14 20:56:11 manolis Exp $                                                                 
//
//************************************************************************
?>
<div id="dateDropDownID" class="secondMenuDropLayer"  >
<div class='closeButton closeLayerButton'></div>        
<div class='content'>
<?
if ( $op!='comp' ) {
	if (! $CONF['seasons']['use_season_years'] ) $season=0;

	$tblWidth=280;
	if ($op=="list_flights" && $CONF_use_calendar) $tblWidth+=255;
	
	if ($CONF['seasons']['use_season_years']) $tblWidth+=70;

	//$tblWidth="100%";
?>
<div style='height:4px;'></div>
<table  width="<?=$tblWidth?>" cellpadding="3" cellspacing="0">
<tr>
	<td colspan=5  class="main_text" >
		<strong>
			<?=_SELECT_DATE?> <?=_OR?>
		</strong>		
		<div class='buttonLink'>			
		<a href='<?=getLeonardoLink(array('op'=>'useCurrent','season'=>'0','year'=>'0','month'=>'0','day'=>'0','season'=>'0'))?>'><?=_ALL_YEARS?></a>
		</div>

	</td>
	
</tr>
<tr>
<?
	if ($CONF['seasons']['use_season_years'] ) {
		echo '<td class="datesColumnHeader" style="width:70px">'._SEASON;
	} else {
		echo '<td class="datesColumnHeader">';
	}
	echo '</td>';

	if ($op=="list_flights" &&  $CONF_use_calendar ) {
		echo '<td class="datesColumnHeader" valign="top" style="width:255px"><strong>'._DAY;
	} else { 
		echo '<td class="datesColumnHeader">';
	}
	echo '</td>';

?>

	<td class="datesColumnHeader" style="width:60px">
		<?=_YEAR?>
	</td>
	<td class="datesColumnHeader" style="width:90px">
		<?=_MONTH?>
	</td>
    <td class="datesColumnHeader" style="width:110px"><?=_Recent?></td>
</tr>
<tr>
<?
if ($CONF['seasons']['use_season_years'] ) {
	echo '<td class="datesColumn" valign="top">';
   	if ($season) $seasonLegend=_SEASON.' '.$season;
	else $seasonLegend=_SELECT_SEASON;

	$seasonStr="";
	
	if ($CONF['seasons']['use_defined_seasons']) {
	
		foreach ($CONF['seasons']['seasons'] as $thisSeason=>$seasonDetails) {
			$seasonStr.="<a href='".getLeonardoLink(array('op'=>'useCurrent','season'=>$thisSeason))."'>$thisSeason</a><BR>\n";		
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
	<td class="calBox datesColumn"" valign="top" style="width:255px">		
<? 

		$calLang=$lang2iso[$currentlang]; 

		$calDay=$day;
		$calMonth=$month;
		$calYear=$year;		
		if (!$calDay) $calDay=date("d");
		if (!$calMonth) $calMonth=date("m");
		if (!$calYear)  $calYear=date("Y");
		$dateStr=sprintf("%02d.%02d.%04d",$calDay,$calMonth,$calYear);
		
		// echo "$year $month, $day ####";exit;
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
<script language='javascript' src='<?=$moduleRelPath ?>/js/cal/popcalendar.js'></script>
<form name="formFilter" id="formFilter">
    <input style='visibility:hidden;' id="DAY_SELECT" name="DAY_SELECT" type="text" size="10" maxlength="10" value="<?=$dateStr ?>" >
</form>
<script language='javascript'>

 init();
 showCalendar(this, document.formFilter.DAY_SELECT, 'dd.mm.yyyy','<? echo $calLang ?>',0,<? echo ($CONF['seasons']['use_season_years']?81:11)?>,49);
</script>
</td>
<? } else {   ?>
<td></td>
<? } ?>

	<td class="datesColumn" valign="top">
	<?  
			
		 for($i=$CONF['years']['end_year'];$i>=$CONF['years']['start_year'];$i--)  {
			echo "<a href='".getLeonardoLink(array('op'=>'useCurrent','season'=>'0','year'=>$i,'month'=>'0','day'=>'0'))."'>$i</a><BR>";		
		}
	?>
	</td>
	<td class="datesColumn" valign="top">
	<?
		$i=1;
		foreach ($monthList as $monthName)  {		 
			$k=sprintf("%02s",$i);
			echo "<a href='".getLeonardoLink(array('op'=>'useCurrent','season'=>'0','month'=>$k,'day'=>'0'))."'>$monthName</a><BR>";		
			$i++;
		 }
	?>
	</td>
    <td class="datesColumn" valign="top">
<? 
	 $month_num=date("m");
	 $year_num=date("Y");
     for ($i=0;$i<8;$i++) {
	    echo "<a href='".getLeonardoLink(array('op'=>'useCurrent','season'=>'0','year'=>$year_num,'month'=>$month_num,'day'=>'0'))."'>".($monthList[$month_num-1]." ".$year_num)."</a><BR>";
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
<? } else {  // if ( $op!='comp' ) 
//-----------------------------------------------
//-----------------------------------------------
// simple years / seasons dropdown for xc league
//-----------------------------------------------
//-----------------------------------------------
	$dWidth=10;
	if ($CONF['seasons']['use_season_years'] ) $dWidth+=70;
	if ($CONF['years']['use_calendar_years'] ) $dWidth+=70;
?>

<table  width="<?=$dWidth?>" cellpadding="2" cellspacing="0">
<tr>
<?
	if ($CONF['seasons']['use_season_years'] ) {
		echo '<td class="tableBox" valign="top" style="width:70px"><strong>'._SEASON.'</strong></td>';
	} else if ($CONF['years']['use_calendar_years'] ) {
		echo '<td class="tableBox" valign="top" style="width:70px"><strong>'._YEAR.'</strong></td>';
	} else {
		echo '<td>&nbsp;</td>';
	}	
?>
</tr>
<?
if ($CONF['seasons']['use_season_years'] ) {
	
   	if ($season) $seasonLegend=_SEASON.' '.$season;
	else $seasonLegend=_SELECT_SEASON;

	$seasonStr="";
			
	if ($CONF['seasons']['use_defined_seasons']) {
	
		foreach ($CONF['seasons']['seasons'] as $thisSeason=>$seasonDetails) {
			$seasonStr.='<td class="datesColumn" valign="top">';
			$seasonStr.="<a href='".getLeonardoLink(array('op'=>'useCurrent','season'=>$thisSeason,'year'=>'0','month'=>'0','day'=>'0'))."'>$thisSeason</a>\n";	
			$seasonStr.='</td></tr>';	
		}
	
	} else {
		for ( $thisSeason=$CONF['seasons']['end_season']; $thisSeason>=$CONF['seasons']['start_season'] ; $thisSeason--) {
			$seasonStr.='<tr><td class="datesColumn" valign="top">';
			$seasonStr.="<a href='".getLeonardoLink(array('op'=>'useCurrent','season'=>$thisSeason,'year'=>'0','month'=>'0','day'=>'0'))."'>$thisSeason</a>\n";
			$seasonStr.='</td></tr>';
		}
	}	
	//echo '<td class="datesColumn" valign="top">';
	echo $seasonStr;
	//echo '</td>';
	
} else if ($CONF['years']['use_calendar_years'] ) { 
	for($i=$CONF['years']['end_year'];$i>=$CONF['years']['start_year'];$i--)  {
		echo '<tr><td class="datesColumn" valign="top">';
		echo "<a href='".
		getLeonardoLink(array('op'=>'useCurrent','season'=>0,'year'=>$i,'month'=>'0','day'=>'0'))
		."'>$i</a>";
		echo '</td></tr>';		
	}

	if (  ! $CONF['years']['dont_show_all_years'] ) { 
		echo '<tr><td class="datesColumn" valign="top">';
		?>
	<a style='text-decoration:underline;' href='<?=getLeonardoLink(array('op'=>'useCurrent','season'=>'0','year'=>'0','month'=>'0','day'=>'0'))?>'><?=_ALL_YEARS?></a>    
<? 
		echo '</td></tr>';
	 }
} 

?>
</TABLE>


<? } ?>
</div>
</div>
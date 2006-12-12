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

?>

<table class="dropDownBox" width="300" cellpadding="2" cellspacing="0">
<tr>
	<td colspan=3 height=25 class="main_text" bgcolor="#40798C">
		<div class="style1" align="center"><strong><?=_SELECT_DATE?> <?=_OR?></strong></div>
	</td>
	
</tr>
<tr>
	<td colspan=3 height=20 class="main_text" bgcolor="#E7F8E2">
		<div align="center" class="style1"><strong><a style='text-align:center; text-decoration:underline;' href='?name=<?=$module_name?>&year=0&month=0'><?=_ALL_YEARS?></a></strong></div>
	</td>
</tr>
<tr>
	<td class="tableBox" valign="top">
		<strong>Recent</strong>
	</td>
	<td class="tableBox" valign="top">
		<strong><?=_YEAR?></strong>
	</td>
	<td class="tableBox" valign="top">
		<strong><?=_MONTH?></strong>
	</td>
</tr>
<tr>
	<td valign="top">
	 
   <? 
	 $month_num=date("m");
	 $year_num=date("Y");
     for ($i=0;$i<8;$i++) {
	    echo "<a href='?name=".($module_name.$query_str)."&year=".$year_num."&month=".
				$month_num."'>".($monthList[$month_num-1]." ".$year_num)."</a>";
		$month_num--;
		if ($month_num==0) { 
			$year_num--; 
			$month_num=12; 
		}
		$month_num=sprintf("%02s",$month_num);
	 }	 
	?>
	</td>
	<td class="sp " valign="top">
	<?  
		// echo "<a href='?name=$module_name&year=0&month=0'>"._ALL_YEARS."</a>";		
		for($i=date("Y");$i>=1998;$i--)  
			echo "<a href='?name=$module_name&year=$i&month=0'>$i</a>";		
	?>
	</td>
	<td valign="top">
	<?
		$i=1;
		foreach ($monthList as $monthName)  {		 
			$k=sprintf("%02s",$i);
			echo "<a href='?name=$module_name&month=$k'>$monthName</a>";		
			$i++;
		 }
	?>
	</td>
</tr>
</TABLE>

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

	list($countriesCodes,$countriesNames,$countriesFlightsNum)=getCountriesList();
	$countriesNum=count($countriesNames);
	$num_of_cols=ceil($countriesNum/15);
	$num_of_rows=ceil($countriesNum/$num_of_cols);

	$countriesDivWidth=140;
	$countriesDivWidthTot=$countriesDivWidth*$num_of_cols;
	// echo "#$countriesNum#$num_of_cols#$num_of_rows#";

?>
<div id="supernote-note-selCountry" class="snp-triggeroffset notedefault" style="width:<?=$countriesDivWidthTot?>px">
<a name="selCountry"></a>
<table class="tableBox" width=100% cellpadding="2" cellspacing="0">
<tr>
	<td colspan=<?=$num_of_cols?> height=25 class="main_text" bgcolor="#40798C"><div align="center" class="style1"><strong><?=_SELECT_COUNTRY?></strong>
	  </div></td>
</tr>
<? 
$ii=0;
if ($countriesNum) {
	for( $r=0;$r<$num_of_rows;$r++) {
		$sortRowClass=($ii%2)?"l_row1":"l_row2"; 	
		$ii++; 
		echo "\n\n<tr class='$sortRowClass' style='text-align:left'>";
		for( $c=0;$c<$num_of_cols;$c++) {
			echo "<td style='width:".$countriesDivWidth."px'>";

			//compute which to show
			//echo "c=$c r=$r i=$i<br>";
			$i= $c * $num_of_rows +( $r % $num_of_rows);
			if ($i<$countriesNum) {
				$countryName=$countriesNames[$i];
				echo "<a href='?name=".$module_name."&country=".$countriesCodes[$i]."'>$countryName (".$countriesFlightsNum[$i].")</a>";
			}	 
			else echo "&nbsp;";

			echo "</td>";
		}
		echo '</tr>';
	}
} 
?>
</TABLE>
</div>
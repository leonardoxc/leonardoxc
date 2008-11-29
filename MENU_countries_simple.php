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
// $Id: MENU_countries_simple.php,v 1.17 2008/11/29 22:46:07 manolis Exp $                                                                 
//
//************************************************************************

if ( $countriesNum > 30 && 0 ) {
	$tblWidth=300;

?>
<table class="dropDownBox" width="<?=$tblWidth?>" cellpadding="1" cellspacing="0">
<tr>
	<td  height=25 class="main_text" bgcolor="#40798C"><div align="center" class="style1"><strong><?=_SELECT_COUNTRY?> <?=_OR?></strong>
	  </div>
	</td>
</tr>
<tr>
	<td class="dropDownBoxH2">
		<div class="dropDownBoxH2">
			<a style='text-align:center; text-decoration:underline;' href='<?=getLeonardoLink(array('op'=>'useCurrent','country'=>'0'))?>'><?=_Display_ALL?></a>
		</div>
	</td>
</tr>
<tr>
<td align="center" height=180 valign="top">
<div align="center" style="display:block; z-index:1000; height:180px; ">
<?
	echo "<select name='selectCountry' id='selectCountry' onchange='changeCountry(this)'>";
		echo "<option value=0>---- "._SELECT_COUNTRY." ----</option>";
//		echo "	<option value=0>"._Display_ALL."</option>";
	foreach($countriesCodes as $i=>$cCode) {
		$countryName=$countriesNames[$i];
		if ($cCode==$country) $sel='selected';
		else $sel='';
		echo "<option $sel value='".$cCode."'>$countryName</option>";
	}
	echo "</select>\n";
	
?></div>
</td></tr>
<tr>
	<td  height=8 class="main_text" ></td>
</tr>
</TABLE>
<?
} else {
			
	$num_of_cols=ceil($countriesNum/15);
	$num_of_rows=ceil($countriesNum/$num_of_cols);

	$countriesDivWidth=100;
	$countriesDivWidthTot=$countriesDivWidth*$num_of_cols;
	// echo "#$countriesNum#$num_of_cols#$num_of_rows#";
	$tblWidth=$num_of_cols*110;
	$tblWidth=600;

?>
<table class="dropDownBox" width="<?=$tblWidth?>" cellpadding="1" cellspacing="0">
<tr>
	<td height=25 colspan=<?=$num_of_cols ?> bgcolor="#40798C" class="main_text"><div align="center" class="style1"><strong><?=_SELECT_COUNTRY?> <?=_OR?></strong>
	  </div>
	</td>
</tr>
<tr>
	<td colspan=<?=$num_of_cols ?> class="dropDownBoxH2">
		<div class="dropDownBoxH2">
			<a style='text-align:center; text-decoration:underline;' href='<?=getLeonardoLink(array('op'=>'useCurrent','country'=>'0'))?>'><?=_Display_ALL?></a>
		</div>
	</td>
</tr>

<? 
//require_once dirname(__FILE__)."/FN_areas.php";

//echo "\n\n<tr style='text-align:left'><td>";
//echo "<div ><ul id='countriesList'>\n";

$ii=0;
if ($countriesNum) {
	$percent=floor(100/$num_of_cols);
	for( $r=0;$r<$num_of_rows;$r++) {
		$sortRowClass=($ii%2)?"l_row1":"l_row2"; 	
		$ii++; 
		echo "\n\n<tr class='$sortRowClass'>";
		for( $c=0;$c<$num_of_cols;$c++) {
			//	echo "<td style='width:".$countriesDivWidth."px'>";
			echo "<td class='countryList' width='$percent%'>";

			//compute which to show
			//echo "c=$c r=$r i=$i<br>";
			$i= $c * $num_of_rows +( $r % $num_of_rows);
			if ($i<$countriesNum) {
				$countryName=$countriesNames[$i];
				$countryName=trimText($countryName,20);
				$linkTmp=getLeonardoLink(array('op'=>'useCurrent','country'=>$countriesCodes[$i]));
				if ($currentlang=='hebrew')
					echo "<a href='$linkTmp'>(".$countriesFlightsNum[$i].") $countryName</a>\n";
				else
					echo "<a href='$linkTmp'>$countryName (".$countriesFlightsNum[$i].")</a>\n";
			}	 
			else echo "&nbsp;";

			echo "</td>";
		}
		echo '</tr>';
	}
} 
//echo "</ul></div>";
//echo "</td></tr>";
?>
<tr>
	<td colspan=<? echo $num_of_cols ; ?> height=8 class="main_text" ></td>
</tr>
</TABLE>
<style type="text/css">
<!--
.countryList a:link {
	font-size:80%;	
	display:inline;
	float:none;
	width:auto;
	white-space:normal;	
}
.countryList {
	white-space:normal;	
}
-->
</style>
<? } ?>
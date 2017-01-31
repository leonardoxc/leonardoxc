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
// $Id: MENU_countries.php,v 1.8 2010/03/14 20:56:11 manolis Exp $                                                                 
//
//************************************************************************
?>

<div id="countryDropDownID" class="secondMenuDropLayer"  >
<div class='closeButton closeLayerButton'></div>        
<div class='content' align="left">

<?
if ( $countriesNum > 30 &&0 ) {
	$tblWidth="400";

?>
<table  width="<?=$tblWidth?>" cellpadding="3" cellspacing="0">
<tr>
	<td  height=25 class="main_text" bgcolor="#40798C">
		<div align="center" class="style1">
			<strong><?=_SELECT_COUNTRY?> <?=_OR?></strong>
			<a href='<?=getLeonardoLink(array('op'=>'useCurrent','country'=>'0'))?>'><?=_Display_ALL?></a>
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
			
	$num_of_cols=ceil(($countriesNum+6)/17);
	// $num_of_cols=5;
	$num_of_rows=ceil(($countriesNum+6)/$num_of_cols);

	$countriesDivWidth=100;
	$countriesDivWidthTot=$countriesDivWidth*$num_of_cols;
	// echo "#$countriesNum#$num_of_cols#$num_of_rows#";
	$tblWidth=$num_of_cols*110;
	$tblWidth=740;

?>

<?
	require_once dirname(__FILE__)."/FN_areas.php";
	$i=0;
	foreach($countriesNames as $countryName) {	
		$continentNum=$countries2continent[$countriesCodes[$i]];	
		$continentArray[$continentNum][]=$i;
		$i++;
	}		
	
?>
<div style='height:4px;'></div>
<div align='left'>
<table  cellpadding="1" cellspacing="0"  >
<tr>
	<td height=25 colspan=<?=$num_of_cols ?> class="main_text">
		<strong><?=_SELECT_COUNTRY?> <?=_OR?>
		</strong>
		<div class="buttonLink">
			<a  href='<?=getLeonardoLink(array('op'=>'useCurrent','country'=>'0'))?>'><?=_Display_ALL?></a>
		</div>
	</td>
</tr>
<tr>
	<td colspan=<?=$num_of_cols ?> >

	</td>
</tr>


<? 

if ($countriesNum) {
	$percent=floor(100/$num_of_cols);
	$sortRowClass=($ii%2)?"l_row1":"l_row2"; 	
	$ii=0; 
	echo "\n\n<tr><td class='countryContinent countryContinent1'  valign='top' width='$percent%'>";
	
	for($c=1;$c<=6;$c++) {
		if (!count($continentArray[$c])) { 
			continue;
		}
		if ($ii>=$num_of_rows-1) {
				echo "</td><td class='countryContinent countryContinent1' valign='top' width='$percent%'>";
				$ii=0;
		}
		echo "<div class='datesColumnHeader ContinentHeader ContinentHeader$c'><strong>".$continents[$c]."</strong></div>";
		$ii++;
		if (count($continentArray[$c])>0) {
			foreach($continentArray[$c] as $i) {
				
				if ($ii>=$num_of_rows) {
					echo "</td><td class='countryContinent countryContinent1' valign='top' width='$percent%'>";
					$ii=0;
				}
				//$i=$continentArray[$c][$ii];	
				$countryName=$countriesNames[$i];
				$countryName=trimText($countryName,20);
				$linkTmp=getLeonardoLink(array('op'=>'useCurrent','country'=>$countriesCodes[$i]));
						
				echo "<div class='countryContinentLink ContinentHeader$c'><a class='countryContinent1' href='$linkTmp'>$countryName</a></div>\n";
				$ii++; 
			}	
		}	
	}
	echo "</tr>";
}	


$ii=0;
if ($countriesNum && 0) {



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
				
				echo "<a href='$linkTmp'>$countryName</a>\n";
				/*
				if ($currentlang=='hebrew')
					echo "<a href='$linkTmp'>(".$countriesFlightsNum[$i].") $countryName</a>\n";
				else
					echo "<a href='$linkTmp'>$countryName (".$countriesFlightsNum[$i].")</a>\n";
				*/
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
</div>


</div>
</div>
<style type="text/css">
<!--
.countryList a:link {
	
	display:inline;
	text-align:left;
	float:none;
	width:auto;
	white-space:normal;	
}
.countryList {
	white-space:normal;	
	text-align:left;
}
-->
</style>
<? } ?>
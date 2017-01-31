<? 
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://leonardo.thenet.gr                                            */
/* http://sourceforge.net/projects/leonardoserver                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

define ('MAIN_BG','#EDEEF1');   // more light blue
$imagesPrefix=$moduleRelPath."/img/";
global $imagesPrefix;

function open_box($title,$width,$icon,$bgcolor=MAIN_BG) {
global $imagesPrefix;
$width_tot=$width;
$width_2=$width_tot-11-15;
$width_header=$width_tot-17-12;

if (is_numeric($icon)) $icon_name="icon_cat_".$icon.".png" ;
else $icon_name=$icon;
?>
<table class=main_text border="0" cellpadding="0" cellspacing="0" width="<?=$width_tot ?>">
  <tbody>
    <tr>
      <td background="<?=$imagesPrefix ?>tbl_header_left.gif"  width="17" >
	  <? 
		if ($_SESSION["filter_clause"] && 0)   { // no filter icon 
		?> <a href='<?=CONF_MODULE_ARG?>&op=filter'><img src="<?=$imagesPrefix ?>icon_filter.png" border=0></a> <? } else { ?>
	  	<img src="<?=$imagesPrefix.$icon_name ?>" ><? }?></td>
      <td width=<? echo $width_header ?> valign=absmiddle background="<?=$imagesPrefix ?>tbl_header_middle.gif" height="20">
	  <?=$title ?></td>
	  <td width="12" background="<?=$imagesPrefix ?>tbl_header_right.gif"></td>
    </tr>
  </tbody>
</table>
<table width="<?=$width_tot ?>" border="0" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td height=1 width="11" background="<?=$imagesPrefix ?>tbl_main_top_left.gif"></td>
      <td height=1 background="<?=$imagesPrefix ?>tbl_main_top_middle.gif"></td>
      <td height=1 width="15" background="<?=$imagesPrefix ?>tbl_main_top_right.gif"></td>
    </tr>
    <tr>
      <td width="11" background="<?=$imagesPrefix ?>tbl_main_left.gif"></td>
      <td class="main_text" bgcolor="<?=$bgcolor?>" width="<? echo $width_2; ?>">
<? 
} 

function close_box() {
global $imagesPrefix;
?> </td>
      <td width="15" background="<?=$imagesPrefix ?>tbl_main_right.gif"></td>
    </tr>
    <tr>
  	  <td width="11" background="<?=$imagesPrefix ?>tbl_footer_left.gif"></td>
      <td>
	  <img src="<?=$imagesPrefix ?>tbl_footer_middle.gif" width="100%" height="13"></td>
      <td width="15" background="<?=$imagesPrefix ?>tbl_footer_right.gif"></td>
    </tr>
  </tbody>
</table>

<? 
} 


function open_inner_table($title="",$width=500,$icon=-1) {
global $imagesPrefix,$themeRelPath,$cat;
global $row_count;

if ($icon==-1) $icon=$cat;
$row_count=0;
echo "<center>";

open_box("<b>".$title."</b>",$width,$icon,MAIN_BG);
?>
	<table class=main_text width="100%" align="right">
	<tr>  
<?
}

function close_inner_table() {
?>
</tr>
</table>
<?
close_box();
echo "</center>";
}

function open_tr() {
 global $row_count;
 $bgcolor=(($row_count+1)%2)?"bgcolor=#DDDDDD":"";
 echo "<TR $bgcolor align=right>";
 //$rowNum=(($row_count+1)%2)?"1":"2";
 // echo "<TR class='row$rowNum'>";
 $row_count++;
}

function openBox($title,$width=640,$bgcolor="#DCE4E4"){ ?>
<table cellpadding="0" cellspacing="0" class="mainBox" width="<?=$width?>" align="center">
<? if ($title) { ?>
<tr>
  <td  class="main_text" ><?=$title?>
  </td>
</tr>
<? } ?>
<tr>
  	<td class="main_text" <? if ($bgcolor) echo "bgcolor='$bgcolor'"; ?> >
<?
}

function closeBox(){
?>
  </td>
</tr>
</table>
<?	
}


function close_tr(){
 echo "</TR>";
}
 
 
 
 
 
 
 
 
function openMain($title="",$width=0,$icon=-1) {
	global $imagesPrefix,$themeRelPath,$cat;
	global $row_count;
	
	if (!$width) $width="100%";		
	if ( is_numeric($width)	) $width.='px';
		
	if ($icon==-1) $icon=$cat;
	$icon_name='';
	if ($icon!=-1) {
		if (is_numeric($icon)) 
			$icon_name="<img src='".$imagesPrefix."icon_cat_".$icon.".png' align='absmiddle'>&nbsp;" ;
		else if ($icon!='')
			$icon_name="<img src='".$imagesPrefix.$icon."' align='absmiddle'>&nbsp;";
	}
	echo "<div align='center'><BR>\n";
	echo "<div align='left' style='width:".$width."; margin:0px; padding:0;' >\n";
	echo "<div style='font-size:13px; font-weight:bold; height:50px; background: url($themeRelPath/img/bg-header2.jpg) repeat-x; padding:10px; padding-bottom:0px'>$icon_name$title</div>\n";
	echo "<div align='left'  style='margin:0px; padding:10px;'>\n";
	return;

}

function closeMain() {
	echo "</div>\n";
	echo "</div>\n";
	echo "</div>\n";
	return;
}

class Theme {
 
  var $bg1;
  var $bg2;
  var $page_bg;
  var $fg1;
  var $fg2;
  var $over1;
  var $main_bg;
  var $table_cells_align="right";

	// 	var $bar0_bgcolor="#74D476";  //green
  	var $color0="#C5D0E1"; // light blue
//	var $bar1_bgcolor="#FFB055";  // orange
	var $color1="#6A8ACA";  // blue
	
	var $color2="#F8E880";   // yellow 
	var $color3="#74D476";   // green
	
//	var $color="#98C88C";   // green pal
	var $color4="#FDAD2F";   // orange
	var $color5="#BECEC6";   // green light
	var $color6="#F33143";   // red
	var $color7="#E296B2";   // 
	
	var $table_last_line="#FFFF99";

  function Theme(){
	$this->bg1="#F5F5F5";
	$this->bg2="#3366CC";
	$this->page_bg="#E1DED5";
	$this->fg1="#222222";
	$this->fg2="#FFFFFF";
	$this->over1="#7BA9CD";
	$this->main_bg=MAIN_BG;	
  }
    
}

?>
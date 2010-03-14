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
// $Id: CL_html.php,v 1.2 2010/03/14 20:56:10 manolis Exp $                                                                 
//
//************************************************************************

class leoHtml {
	function html() {

	}

function img($imgName,$width=0,$height=0,$align='',$title='',$class='',$id='',$type=1) {

	$str=" border='0' ";	
	if ($title) $str.=" title='$title'  alt='$title' ";
	if ($width) $str.=" width='$width' ";
	if ($height) $str.="  height='$height' ";
	if ($align) $str.="  align='$align' "; 
	if ($id) $str.="  id='$id' "; 
		
	if ($type==0) {
		if ($class) $strClass.=" class='$class' ";
		else $strClass.="";
		$imgStr="<img $strClass src='".moduleRelPath()."/img/$imgName' $str>";
	} else {
		$imgName=str_replace("\/","-",$imgName);
		$imgName=substr($imgName,0,-4);
		$imgStr="<img class='$class sprite-$imgName' src='".moduleRelPath()."/img/space.gif' $str>";
	}		
	return $imgStr;
}


}

?>
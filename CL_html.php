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
// $Id: CL_html.php,v 1.3 2010/03/16 13:00:12 manolis Exp $                                                                 
//
//************************************************************************

class leoHtml {
	function html() {

	}

function img($imgName,$width=0,$height=0,$align='',$title='',$class='',$id='',$type=1) {
	global $CLIENT;
	if ($CLIENT['browser'][0]=='MSIE') $type=0;
	
	$type=1;
	
	$str=" border='0' ";	
	if ($title) $str.=" title='$title'  alt='$title' ";
	if ($width) $str.=" width='$width' ";
	if ($height) $str.="  height='$height' ";
	if ($align) $str.="  align='$align' "; 
	if ($id) $str.="  id='$id' "; 
		
	if ($type==0) {
		$dir='';
		$strClass='';
		if ($class) {
			if (preg_match("/^(.+) (.+)$/",$class,$matches) ) {
				$dir=$matches[1].'/';
				$class=$matches[2];
				$strClass=" class='$class' ";
			} else $dir=$class.'/';
		} 
		
		$imgStr="<img $strClass src='".moduleRelPath()."/img/$dir$imgName' $str>";
	} else {
		$imgName=str_replace("\/","-",$imgName);
		$imgName=substr($imgName,0,-4);
		$imgStr="<img class='$class sprite-$imgName' src='".moduleRelPath()."/img/space.gif' $str>";
	}		
	return $imgStr;
}


}

?>
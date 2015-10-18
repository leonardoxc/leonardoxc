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
// $Id: CL_html.php,v 1.5 2010/11/21 14:26:01 manolis Exp $                                                                 
//
//************************************************************************
 
class leoHtml {
	function html() {

	}

function cutString($str,$len ) {
	if (mb_strlen($str) <=$len ) return $str;
	
	$str=strip_tags($str);
	if (mb_strlen($str) <=$len ) return $str;

	return mb_substr($str,0,$len)." ...";
}

function img($imgName,$width=0,$height=0,$align='',$title='',$class='',$id='',$type=1) {
	global $CLIENT,$moduleRelPath;

	//if ($CLIENT['browser'][0]=='MSIE') $type=0;	
	//$type=0;
    global $OVERRIDE;

	if (isset($OVERRIDE['imgtype'])){
        $type=$OVERRIDE['imgtype'];
    }

    if (isset($OVERRIDE['fullurl'])){
        $fullurl=$OVERRIDE['fullurl'];
    }
    $server_url='';
    if ($fullurl) {
        $server_url="http://".$_SERVER['SERVER_NAME'];
    }


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
		$imgUrl=$server_url.$moduleRelPath."/img/$dir$imgName";

        // this is a bad hack for misconfigured dhv server
        // has no impact on other servers
        $imgUrl=str_replace("http://xc.dhv.de.//img","http://xc.dhv.de/xc/modules/leonardo/img",$imgUrl);
        $imgUrl=str_replace("http://xc.dhv.de.//data","http://xc.dhv.de/xc/modules/leonardo/data",$imgUrl);


		$imgStr="<img $strClass src='$imgUrl' $str>";
	} else {
		$imgName=str_replace("\/","-",$imgName);
		$imgName=substr($imgName,0,-4);
		$imgStr="<img class='$class sprite-$imgName' src='".$server_url.$moduleRelPath."/img/space.gif' $str>";
	}		
	return $imgStr;
}


}

?>
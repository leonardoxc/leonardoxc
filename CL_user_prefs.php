<?php

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

class UserPrefs {
 var $themeName="basic";
 var $language="english";
 var $viewCat=0;
 var $viewCountry=0;
 var $itemsPerPage=35;
 var $metricSystem=1;

 function UserPrefs() {

 }
/*
 function getFromCookie() {
 }

 function setToCookie() {
	$cval=serialize($this);
	setcookie("leonardo_user_prefs",$cval,time()+60*60*24*365,"/" );
 }
*/
// Attention if the above code gives errors, comment it and uncoment the
// code below. By doing so ALL users of Leonardo will have to delete the
// "leonardo_user_prefs" cookie from their browsers the first time they use it


 function getFromCookie() {
 	$cval=$_COOKIE['leonardo_user_prefs'];							// to do: verify existance first!

 	$major_version=substr(PHP_VERSION,0,1)+0;
	if ($cval) {
		if ($major_version>4)  {
			preg_match_all("/&([^&=]*)=([^&=]*)/",$cval,$vars);
			foreach ($vars[1] as $id=>$var_name ) {
				$$var_name=$vars[2][$id];
			}
			$this->themeName =$themeName ;
			$this->language =$language ;
			$this->itemsPerPage =$itemsPerPage ;
			$this->metricSystem =$metricSystem ;
			$this->viewCountry=$viewCountry;
			$this->viewCat=$viewCat;
		} else {
			$newUserPrefs= unserialize($cval); 						// to do: handle unserialize error (old cookie version)
			$this->themeName =$newUserPrefs->themeName ;
			$this->language =$newUserPrefs->language ;
			$this->itemsPerPage =$newUserPrefs->itemsPerPage ;
			$this->metricSystem =$newUserPrefs->metricSystem ;
			$this->viewCountry=$newUserPrefs->viewCountry;
			$this->viewCat=$newUserPrefs->viewCat;

		}
		return true;
	} else {
		return false;
	}

 }

 function setToCookie() {
 	 $major_version=substr(PHP_VERSION,0,1)+0;
 	 if ($major_version>4)  {
		 $cookieStr="&themeName=".$this->themeName.
			"&language=".$this->language.
			"&itemsPerPage=".$this->itemsPerPage.
			"&metricSystem=".$this->metricSystem.
			"&viewCountry=".$this->viewCountry.
			"&viewCat=".$this->viewCat.
			"&" ;
 	 } else{
		$cookieStr=serialize($this);
 	 }
	 setcookie("leonardo_user_prefs",$cookieStr,time()+60*60*24*365,"/" );
 }

}


?>
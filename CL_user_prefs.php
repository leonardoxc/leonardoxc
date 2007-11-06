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

class UserPrefs {
 var $themeName="basic";
 var $language="english";
 var $viewCat=0;
 var $viewCountry=0;
 var $itemsPerPage=35;
 var $metricSystem=1;
 var $googleMaps=1;
 var $nameOrder=1; // western -> firstName - LastName
 
 var $visitorID=0;
 var $sessionID=0;

 function UserPrefs() {
	
 }

 function getFromCookie() {
	global $CONF_googleMapsShow,$CONF_defaultNameOrder;
	
 	$cval=$_COOKIE['leonardo_user_prefs'];							// to do: verify existance first!

 	$major_version=substr(PHP_VERSION,0,1)+0;
	if ($cval) {
		if ($major_version>4 || 1)  { // always use the new method
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
			
			if (isset($nameOrder))	$this->nameOrder=$nameOrder;
			else $this->nameOrder=$CONF_defaultNameOrder;

			if (isset($googleMaps))	$this->googleMaps=$googleMaps;
			else $this->googleMaps=$CONF_googleMapsShow;
			
		} else {
			$newUserPrefs= unserialize($cval); 						// to do: handle unserialize error (old cookie version)
			$this->themeName =$newUserPrefs->themeName ;
			$this->language =$newUserPrefs->language ;
			$this->itemsPerPage =$newUserPrefs->itemsPerPage ;
			$this->metricSystem =$newUserPrefs->metricSystem ;
			$this->viewCountry=$newUserPrefs->viewCountry;
			$this->viewCat=$newUserPrefs->viewCat;
			$visitorID=$newUserPrefs->visitorID;
		}
		# Martin Jursa 23.05.2007: check isset to avoid err-message on verbose apache installations
		$sessionID=isset($_COOKIE['leonardo_session']) ? $_COOKIE['leonardo_session'] : '';
		// $visitorID gets set form the cookie !
		$rNum=sprintf("%010d%04d",time(),rand(1,9999));		
		if ( !$visitorID ) $visitorID = $rNum;
		if ( !$sessionID ) $sessionID = $rNum;
		$this->visitorID=$visitorID;
		$this->sessionID=$sessionID;
		return true;
	} else {
		return false;
	}

 }

 function setToCookie() {
 	 $major_version=substr(PHP_VERSION,0,1)+0; 	
 	 if ($major_version>4 || 1)  { // always use the new method
		 $cookieStr="&themeName=".$this->themeName.
			"&language=".$this->language. 
			"&itemsPerPage=".$this->itemsPerPage. 
			"&metricSystem=".$this->metricSystem.
			"&viewCountry=".$this->viewCountry.
			"&viewCat=".$this->viewCat.
			"&googleMaps=".$this->googleMaps.
			"&nameOrder=".$this->nameOrder.
			"&visitorID=".$this->visitorID.
			
			"&" ;
 	 } else{
		$cookieStr=serialize($this);
 	 }
	 setcookie("leonardo_user_prefs",$cookieStr,time()+60*60*24*365,"/" );
	 setcookie("leonardo_session",$this->sessionID, 0 , "/");  // Session Cookie - ends on browser close!

 }

}


?>
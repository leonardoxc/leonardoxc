<?
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://sourceforge.net/projects/leonardoserver                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


class brands {

	function makeWhereClause($brandID,$returnLegend=0) {
		// global $CONF;
		if ( $brandID) {
			$where_clause=' AND gliderBrandID='.$brandID ;
			$legend='';
		}	else {
			$where_clause='';
			$legend='';
		}

		if ($returnLegend) 
			return array($where_clause,$legend);
		else
			return $where_clause;
	}

	function getBrandImg($brandID,$gliderName='',$glidetCat=0){
		global $moduleRelPath,$CONF;
		if ($brandID) {
			$brandName=$CONF['brands']['list'][$brandID];
	 		$gliderBrandImg="<img src='$moduleRelPath/img/brands/".sprintf("%03d",$brandID).".gif' title='$brandName $gliderName' alt='$brandName $gliderName'  border='0' />";
		} else 
	 		$gliderBrandImg="<img src='$moduleRelPath/img/brands/unknown_".sprintf("%03d",$glidetCat).".gif' title='$gliderName'  alt='$gliderName' border='0' />";
		return $gliderBrandImg;
	}

	function getBrandsList($forFilterUse=0){
		global $CONF;
		if ($forFilterUse && ! $CONF['brands']['showAll']) {	
			foreach( $CONF['brands']['filterList'] as $id ) {
					$brandsList[ $CONF['brands']['list'][$id] ]=$id;
			}
		} else {
			foreach( $CONF['brands']['list'] as $id=>$brand ) {
					$brandsList[$brand]=$id;
			}
		}
		ksort($brandsList);
		return  $brandsList;	
	}


	function guessBrandID($gliderDesc){
		global  $CONF;
		// if (!is_array($brandsList[$gliderType]) ) return 0;
		
		$gliderDesc=strtolower($gliderDesc);
		//$gliderDesc=str_replace(" ","",$gliderDesc);
		$gliderDesc=preg_replace('/[^\w]/','',$gliderDesc);
	
		foreach($CONF['brands']['list'] as $brandID=>$brandName) {
			if (  ! ( strpos($gliderDesc,strtolower($brandName) ) === false ) ) {
				return $brandID;
			}
		
		}
		return 0;
	}

}

?>
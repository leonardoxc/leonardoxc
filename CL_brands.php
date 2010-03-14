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
// $Id: CL_brands.php,v 1.13 2010/03/14 20:56:09 manolis Exp $                                                                 
//
//************************************************************************

require_once dirname(__FILE__).'/FN_brands.php';

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
	
	function getBrandText($brandID,$gliderName='',$glidetCat=0){
		global $moduleRelPath,$CONF_abs_path,$CONF;
				
		if (!$brandID) {
			$brandID=brands::guessBrandID($gliderName);	
			$brandName='';
		}
		
		if ($brandID) {
			if (!isset($brandName) ) $brandName=$CONF['brands']['list'][$brandID];
	 		$gliderBrandImg="$brandName $gliderName";
		} else 
	 		$gliderBrandImg="$gliderName";
			
		return $gliderBrandImg;
	}

	function getBrandImg($brandID,$gliderName='',$glidetCat=0){
		global $moduleRelPath,$CONF_abs_path,$CONF;
				
		if (!$brandID) {
			$brandID=brands::guessBrandID($gliderName);	
			$brandName='';
		}
		
		if ($brandID) {
			if (!isset($brandName) ) $brandName=$CONF['brands']['list'][$brandID];
			if (is_file("$CONF_abs_path/img/brands/".sprintf("%03d",$brandID).".gif") ) {
		 		$gliderBrandImg="<img align='absmiddle' src='$moduleRelPath/img/brands/".sprintf("%03d",$brandID).".gif' title='$brandName $gliderName' alt='$brandName $gliderName'  border='0' />";
		 		$gliderBrandImg="<img align='absmiddle' class='brands sprite-".sprintf("%03d",$brandID)."' src='$moduleRelPath/img/space.gif' title='$brandName $gliderName' alt='$brandName $gliderName'  border='0' />";

			} else {
	 			$gliderBrandImg="<img align='absmiddle' src='$moduleRelPath/img/space.gif' width=6 height=16 title='$brandName $gliderName' alt='$brandName $gliderName'  border='0' />";
			}
		} else 
	 		$gliderBrandImg="<img align='absmiddle'  src='$moduleRelPath/img/brands/unknown_".sprintf("%03d",$glidetCat).".gif' title='$gliderName'  alt='$gliderName' border='0' />";
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

	function isValidBrandForFilter($brandID) {
		global $CONF;
		if (!$CONF['brands']['filter_brands']) return 0;
		
		if ( in_array($brandID,$CONF['brands']['filterList']) || $CONF['brands']['showAll']   ) return 1;
		else return 0;
	}

	function guessBrandID($gliderDesc){		
		global  $CONF;
		// if (!is_array($brandsList[$gliderType]) ) return 0;
		
		$gliderDesc=strtolower($gliderDesc);
		//$gliderDesc=str_replace(" ","",$gliderDesc);
		$gliderDesc=preg_replace('/[^\w]/','',$gliderDesc);
	
		//echo "detect for $gliderDesc : ";
		foreach($CONF['brands']['list'] as $brandID=>$brandName) {
			//echo "trying  $brandID=>$brandName <BR>";
			if (  ! ( strpos($gliderDesc,strtolower($brandName) ) === false ) ) {
				// echo "found ID $brandID<BR>";
				return $brandID;
			}
		
		}
		return 0;
	}

	function sanitizeGliderName($gliderName) {
		$gliderNameNorm=trim( preg_replace("/[\/\-\,\.]/",' ',$gliderName) );
		$gliderNameNorm=preg_replace("/( )+/",' ',$gliderNameNorm);
		
		$gliderNameNorm=preg_replace("/(III)/",'3',$gliderNameNorm);
		$gliderNameNorm=preg_replace("/(II)/",'2',$gliderNameNorm);
		$gliderNameNorm=preg_replace("/[^\w](one)/",'1',$gliderNameNorm);
		$gliderNameNorm=preg_replace("/[^\w](two)/",'2',$gliderNameNorm);
		$gliderNameNorm=preg_replace("/[^\w](three)/",'3',$gliderNameNorm);
		$gliderNameNorm=preg_replace("/[^\w](four)/",'4',$gliderNameNorm);
		$gliderNameNorm=preg_replace("/[^\w](five)/",'5',$gliderNameNorm);
		$gliderNameNorm=preg_replace("/[^\w](six)/",'6',$gliderNameNorm);
		$gliderNameNorm=preg_replace("/[^\w](seven)/",'7',$gliderNameNorm);
		$gliderNameNorm=preg_replace("/[^\w](eight)/",'8',$gliderNameNorm);
		$gliderNameNorm=preg_replace("/[^\w](nine)/",'9',$gliderNameNorm);
		
		$gliderNameNorm=ucwords(strtolower($gliderNameNorm));
		return $gliderNameNorm;
	}

}

?>
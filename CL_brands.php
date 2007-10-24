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

	function getBrandsList(){
		global $CONF;
		foreach(	$CONF['brands']['list'] as $id=>$brand ) {
			$brandsList[$brand['brand']]=$id;
		}
		return  $brandsList;	
	}

}


?>
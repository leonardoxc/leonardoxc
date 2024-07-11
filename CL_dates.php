<?
//************************************************************************
// Leonardo XC Server, https://github.com/leonardoxc/leonardoxc
//
// Copyright (c) 2004-2010 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: CL_dates.php,v 1.6 2010/03/14 20:56:09 manolis Exp $                                                                 
//
//************************************************************************


class dates {

	function makeWhereClause($rankID,$season,$year,$month,$day,$returnLegend=0) {
		global $CONF;
		$where_clause='';
		$legend='';
		
		if (!$season) {
		  if ($year && $month && $day  ) {
				$where_clause=" AND DATE_FORMAT(DATE,'%Y%m%d') = ".sprintf("%04d%02d%02d",$year,$month,$day)." ";
				$legend.=" :: $year/$month/$day";
		  } else {
			  if ($year && !$month ) {
					$where_clause=" AND DATE_FORMAT(DATE,'%Y') = ".$year." ";
					$legend.=" :: ".$year." ";
			  }
			  if ($year && $month ) {
					$where_clause=" AND DATE_FORMAT(DATE,'%Y%m') = ".sprintf("%04d%02d",$year,$month)." ";
					$legend.=" :: ".$monthList[$month-1]." ".$year." ";
			  }
			  if (! $year ) {
					$legend.=" :: "._ALL_TIMES." ";
		  	  }
		  }		
		}  else {
			if ($CONF['seasons']['use_defined_seasons']) {
				if ( $CONF['seasons']['seasons'][$season] ) {
					$thisSeasonStart=$CONF['seasons']['seasons'][$season]['start'];
					$thisSeasonEnd	=$CONF['seasons']['seasons'][$season]['end'];
					$seasonValid=1;
				} else {
					$seasonValid=0;
				}
			} else {
				if ( $season>=$CONF['seasons']['start_season'] && $season<=$CONF['seasons']['end_season'] ) {
					
					$thisSeasonStart=($season+$CONF['seasons']['season_start_year_diff'])."-".$CONF['seasons']['season_default_start'];
					$thisSeasonEnd	=($season+$CONF['seasons']['season_end_year_diff']  )."-".$CONF['seasons']['season_default_end']; 						
					$seasonValid=1;
				} else {
					$seasonValid=0;
				}	  
			}	
			
			if 	($seasonValid) {
				$where_clause=" AND DATE >='$thisSeasonStart' AND DATE <= '$thisSeasonEnd' "; 
				$legend.=" :: ".SEASON." ".$season;
			}	
			
		}
		if ($returnLegend) 
			return array($where_clause,$legend);
		else
			return $where_clause;
	} // end of makeWhereClause
	
	function getCurrentSeason($rankID,$clubID=0) {
		global $ranksList,$clubsList,$CONF;
		$thisSeason=0;

		if ($rankID) {
			if ( $ranksList[$rankID]['useCustomSeasons'] ) 
				$conf=&$ranksList[$rankID]['seasons'];			
			else 
				$conf=&$CONF['seasons'];
		} else if ($clubID) {
			if ( $clubsList[$clubID]['useCustomSeasons'] ) 
				$conf=&$clubsList[$clubID]['seasons'];			
			else 
				$conf=&$CONF['seasons'];
		} else {
			$conf=&$CONF['seasons'];
		}
		
		if (! $conf['use_season_years'] ) return 0;
		
		if (!$conf['use_defined_seasons']) {
			$t1=split("-",$conf['season_default_start']);
			$m1=$t1[0]+0;
			$d1=$t1[1]+0;			
			$t2=split("-",$conf['season_default_end']);
			$m2=$t1[0]+0;
			$d2=$t1[1]+0;			
			
			$seasonTry=date("Y");	
			$seasonTryStart	=mktime(0,0,0,$m1,$d1,$seasonTry+$conf['season_start_year_diff']);
			$seasonTryEnd	=mktime(23,59,59,$m2,$d2,$seasonTry+$conf['season_end_year_diff']);
	
			$thisTM=time();
			if ($thisTM<$seasonTryStart) $thisSeason=$seasonTry-1;
			else if ($thisTM>$seasonTryEnd) $thisSeason=$seasonTry+1;
			else $thisSeason=$seasonTry;

		} else {
			foreach ($conf['seasons'] as $thisSeasonID=>$seasonDetails) {
				$t1=split("-",$seasonDetails['start']);
				$y1=$t1[0]+0;
				$m1=$t1[1]+0;
				$d1=$t1[2]+0;			
				$t2=split("-",$seasonDetails['end']);
				$y2=$t2[0]+0;
				$m2=$t2[1]+0;
				$d2=$t2[2]+0;							
				$seasonTryStart	=mktime(0,0,0,$m1,$d1,$y1);
				$seasonTryEnd	=mktime(23,59,59,$m2,$d2,$y2);		
				$thisTM=time();
				if ($thisTM>=$seasonTryStart && $thisTM<=$seasonTryEnd) $thisSeason=$thisSeasonID;
			}

		}

		return $thisSeason;
	}
	
	function getCurrentYear($rankID) {
	
	}
	
	function isSeasonValid($rankID,$season) {
	
	
	}
	
	function isYearValid($rankID,$year) {
	
	}

	// general utility functions
	function date2tm($date) { // date in yyyy-mm-dd format
		return mktime(0,0,0,substr($date,5,2),substr($date,8,2),substr($date,0,4) );
	}

	function moveDaysFromDate($date,$days) { // date in yyyy-mm-dd format
		$tm=dates::date2tm($date)+$days*3600*24;
		return date("Y-m-d",$tm);
	}

}
?>
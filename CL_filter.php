<?
//************************************************************************
// Leonardo XC Server, http://leonardo.thenet.gr
//
// Copyright (c) 2004-8 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: CL_filter.php,v 1.1 2010/02/26 14:30:40 manolis Exp $                                                                 
//
//************************************************************************

/*

this class compiles - decompiles a filter URL
to a more compact (binary?) format

FILTER_YEAR_select_op=%3E%3D
&FILTER_YEAR_select=2007
&FILTER_MONTH_YEAR_select_op=%3D
&FILTER_MONTH_YEAR_select_MONTH=02
&FILTER_MONTH_YEAR_select_YEAR=2010
&FILTER_dateType=DATE_RANGE
&FILTER_from_day_text=01.02.2010
&FILTER_to_day_text=15.02.2010
&FILTER_pilots_incl=3451%2C4220%2C4026%2C5717%2C2266%2C80%2C2784%2C7501%2C8803%2C
&FILTER_nacclubs101_incl=118%2C
&FILTER_countries_incl=DE%2CGR
&FILTER_takeoffs_incl=9705%2C9334%2C9888%2C9165%2C9014%2C9758%2C
&FILTER_nationality_incl=BB%2CBR%2CHR%2CFI%2CGR%2C
&FILTER_server_incl=1%2C2%2C4%2C8%2C
&FILTER_sex=M
&FILTER_cat1=1
&FILTER_cat2=2
&FILTER_linear_distance_op=%3E%3D
&FILTER_linear_distance_select=10
&FILTER_olc_distance_op=%3C%3D
&FILTER_olc_distance_select=100
&FILTER_olc_score_op=%3E%3D
&FILTER_olc_score_select=50
&FILTER_olc_type=FREE_FLIGHT
&FILTER_duration_op=%3E%3D
&FILTER_duration_hours_select=23
&FILTER_duration_minutes_select=12


add also 
- Extend Filter with checkbox categories for Paraglider LTF Class (LTF 1, 1-2, 2, 2-3, A, B, C, D, E, Open)
- Extend Filter with checkbox category for Hanggliders with Kingposts.
- Extend Filter page with Pilot Birthdate.
- Extend Filter page for Start type: foot, winch, microlight tow or e-motor (is to be included on GUI_flight_submit.php)

Integrate RSS Feed in Filterpage, to generate Feeds according to filter settings.
Ensure Filter bookmarks function correctly (check seasons mod).
Ensure Filter settings function correctly on all scoring lists.

*/

var $filterOps=array(
/*
the opID is a byte


4 left most bits for the type (0-15) 
+ 5 bits for the id ( 0 - 15 ) 

we have 
0000 -> reserved
0010 0x20 (+32) -> date related 
0100 0x40 (+64) -> multiple items 
0110 0x60 (+96) -> simple integer select
1000 0x80 (+128)-> greater then, less than , equal  items

*/

// date related filter
// greater then, less than , equal  items
/* opID + 1 byte for operator + 2 bytes per date
 the 2 leftmost bits  are the operator 
 00 ->  =  (equal)
 01 -> <=  (less than)
 10 -> >=  (greater then )
 11 -> between  (needs 2 extra bytes 
 
 year  -> 8 bits ( 1900 + value  we can get up to year 2256 .. this should be enough ?!) 
 month -> 4 bits ( 0-15 ) 
 day   -> 5 bits ( 0-31 ) 
 total 19 bits -> 3 bytes
 
*/
0x20=>"FILTER_YEAR_select_op",
0x21=>"FILTER_DATE",
0x22=>"FILTER_DATE_range",
0x23=>"FILTER_PilotBirthdate",

// multiple items 
/* 
  opID + byte array:
  
  
*/
0x40=>"FILTER_pilots_incl",
0x41=>"FILTER_countries_incl",
0x42=>"FILTER_takeoffs_incl",
0x43=>"FILTER_nationality_incl",
0x44=>"FILTER_server_incl",
0x45=>"FILTER_nacclubs_incl",

// simple select , or multiple choices 
/* opID + 2 bytes (32 bits) range 
*/
0x60=>"FILTER_sex",
0x61=>"FILTER_cat", 		// category pg,hg etc... 
0x62=>"FILTER_class",  		// class -> open, sport tandem etc...
0x63=>"FILTER_olc_type",
0x64=>"FILTER_glider_cert",	//
0x65=>"FILTER_start_type",	// Start type

// greater then, less than , equal  items
/* opID + 2 bytes (30 bits) range (0-16384) the 2 leftmost bits 
 are the operator 
 00 ->  =  (equal)
 01 -> <=  (less than)
 10 -> >=  (greater then )
*/
0x80=>"FILTER_linear_distance",
0x81=>"FILTER_olc_distance",
0x82=>"FILTER_olc_score",
0x83=>"FILTER_duration", // (in minutes)

);


class leonardoFilter {

	var $filterArray=array();

	function leonardoFilter() {

	}
	
	
	function getByte($filterStr,$start) {
		$valHex=substr($filterStr,$start,2);
		$val=hexdec($opHex);
		return $val;
	}
	
	function getShort($filterStr,$start){
	if strlen($filterStr) < ($start +4) )
		$valHex=substr($filterStr,$start,4);
		$val=hexdec($opHex);
		return $val;
	}
	
	function parseOp($filterStr,$start){
	  	$opHex=substr($filterStr,$start,2);
		$opID=hexdec($opHex)
	  
	  
		// all else failed
		return 0;
	}
	
	function parseFilterString($filterStr) {
		if (!$filterStr) return;
		
		$start=0;
		$filterStrLen=strlen($filterStr);
		
		do {
			$opLen=$parseOp($filterStr,$start);
			$start+=$opLen;
		} while ($start<$filterStrLen && $opLen>0) 
	
	}

}

?>
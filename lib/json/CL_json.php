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

class json {

	function encode($object) {
		if ( function_exists('json_encode') ) {
			return json_encode($object);
		} else {
			require_once dirname(__FILE__).'/json.php';
			$json=new Services_JSON( SERVICES_JSON_LOOSE_TYPE );
			return $json->encode($object);
		}
	}
	
	function decode($str) {
		if ( function_exists('json_decode') && 0 ) {	
			//echo "using native function";
			//echo $str;
			$arr=json_decode($str, true);
			// print_r($arr);
			return $arr;
		} else {
			//	echo "using services json function";
			require_once dirname(__FILE__).'/json.php';
			//echo $str;
			$json=new Services_JSON( SERVICES_JSON_LOOSE_TYPE );
			$arr=$json->decode($str);
			// print_r($arr);
			return $arr;
		}
	}
}
?>
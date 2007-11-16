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
		//$lib='native';
		$lib='services_JSON';
		// $lib='jsonrpc';
		
		// dirty trick to correct bad json for photos
		$str = preg_replace('/\t} {/','}, {', $str);
		// remove trailing , 
		$str = preg_replace('/,[ \r\n\t]+}/',' }', $str);

	    // echo "Using $lib<BR>";
		// echo $str;
		if ( function_exists('json_decode') && $lib=='native' ) {	
			$arr=json_decode($str, true);
		} else if ($lib=='services_JSON') {
			require_once dirname(__FILE__).'/json.php';
			$json=new Services_JSON( SERVICES_JSON_LOOSE_TYPE );
			$arr=$json->decode($str);
		} else if ($lib=='jsonrpc'){
			require_once dirname(__FILE__).'/jsonrpc/xmlrpc.php';
			require_once dirname(__FILE__).'/jsonrpc/jsonrpc.php';
			require_once dirname(__FILE__).'/jsonrpc/json_extension_api.php';
			$arr=json_decode($str, true);
			//	$value= php_jsonrpc_decode_json($str); 
			//if ($value) 
			//	$arr = (array)php_jsonrpc_decode($value, array('decode_php_objs'));
		}

		// print_r($arr);
		return $arr;
	}
}
?>
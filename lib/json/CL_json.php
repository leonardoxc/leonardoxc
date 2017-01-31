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

define('JSON_LIB_DECODE','jsonrpc');
define('JSON_LIB_ENCODE','services_JSON');

class json {
	// var $lib='native';
	// var $lib='services_JSON';


	function encode($object) {
		if ( function_exists('json_encode') && JSON_LIB_ENCODE=='native' ) {	
			return json_encode($object);
		} else if (JSON_LIB_ENCODE=='services_JSON') {
			require_once dirname(__FILE__).'/json.php';
			$json=new Services_JSON( SERVICES_JSON_LOOSE_TYPE );
			return $json->encode($object);
		} else if (JSON_LIB_ENCODE=='jsonrpc'){
			require_once dirname(__FILE__).'/jsonrpc/xmlrpc.php';
			require_once dirname(__FILE__).'/jsonrpc/jsonrpc.php';

			$GLOBALS['xmlrpc_internalencoding'] = 'UTF-8';
			$GLOBALS['xmlrpc_internalencoding'] = 'iso-8859-7';

			return php_jsonrpc_encode($value, array());
		}

	}

	function prepStr($str){
		global $CONF_use_utf,$langEncodings,$nativeLanguage;

		if (!$CONF_use_utf) {
		 	require_once dirname(__FILE__).'/../ConvertCharset/ConvertCharset.class.php';
			$NewEncoding = new ConvertCharset;
			$str = $NewEncoding->Convert($str,$langEncodings[$nativeLanguage], "utf-8", $Entities);
		}

		$newStr=json::encode($str);
		if ($newStr[0]=='"') {
			return substr($newStr,1,-1);
		} else {
			return $newStr;
		}
		// return str_replace('"','\"',$str);
	}

	function decode($str) {
		//$lib='native';
		// $lib='services_JSON';
		// $lib='jsonrpc';
		
		// dirty trick to correct bad json for photos
		//$str = preg_replace('/\t} {/','}, {', $str);
		// remove trailing , 
		//$str = preg_replace('/,[ \r\n\t]+}/',' }', $str);

	    // echo "Using $lib<BR>";
		// echo $str;
		if ( function_exists('json_decode') && JSON_LIB_DECODE=='native' ) {	
			$arr=json_decode($str, true);
		} else if (JSON_LIB_DECODE=='services_JSON') {
			require_once dirname(__FILE__).'/json.php';
			$json=new Services_JSON( SERVICES_JSON_LOOSE_TYPE );
			$arr=$json->decode($str);
		} else if (JSON_LIB_DECODE=='jsonrpc'){
			require_once dirname(__FILE__).'/jsonrpc/xmlrpc.php';
			require_once dirname(__FILE__).'/jsonrpc/jsonrpc.php';

			$GLOBALS['xmlrpc_internalencoding'] = 'UTF-8';

			//require_once dirname(__FILE__).'/jsonrpc/json_extension_api.php';
			//$arr=json_decode($str, true);
			
			$value= php_jsonrpc_decode_json($str); 
			if ($value) 
				$arr = php_jsonrpc_decode($value, array());

		}

		// print_r($arr);
		return $arr;
	}
}
?>
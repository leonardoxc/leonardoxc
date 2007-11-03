<?php

/************************************************************************/
/* PHP-NUKE: Advanced Content Management System                         */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2002 by Francisco Burzi                                */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/
/* NSN Groups                                           */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2004 by NukeScripts Network         */
/********************************************************/

$phpver = phpversion();

if (1) {

if ($phpver >= '4.0.4pl1' && strstr($HTTP_USER_AGENT,'compatible')) {
    if (extension_loaded('zlib')) {
        ob_end_clean();
        ob_start('ob_gzhandler');
    }
} else if ($phpver > '4.0') {
    if (strstr($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING'], 'gzip')) {
        if (extension_loaded('zlib')) {
            $do_gzip_compress = TRUE;
            ob_start();
            ob_implicit_flush(0);
            //header('Content-Encoding: gzip');
        }
    }
}

}


$phpver = explode(".", $phpver);
$phpver = "$phpver[0]$phpver[1]";
if ($phpver >= 41) {
    $PHP_SELF = $_SERVER['PHP_SELF'];
}

if (!ini_get("register_globals")) {
    import_request_variables('GPC');
}


foreach ($_GET as $secvalue) {
    if ((eregi("<[^>]*script*\"?[^>]*>", $secvalue)) ||
        (eregi("<[^>]*object*\"?[^>]*>", $secvalue)) ||
        (eregi("<[^>]*iframe*\"?[^>]*>", $secvalue)) ||
        (eregi("<[^>]*applet*\"?[^>]*>", $secvalue)) ||
        (eregi("<[^>]*meta*\"?[^>]*>", $secvalue)) ||
        (eregi("<[^>]*style*\"?[^>]*>", $secvalue)) ||
        (eregi("<[^>]*form*\"?[^>]*>", $secvalue)) ||
        (eregi("<[^>]*img*\"?[^>]*>", $secvalue)) ||
        (eregi("\([^>]*\"?[^)]*\)", $secvalue)) ||
        (eregi("\"", $secvalue))) {
        die ("I don't like you...");
    }
}

foreach ($_POST as $secvalue) {
    if ((eregi("<[^>]*script*\"?[^>]*>", $secvalue)) ||        (eregi("<[^>]*style*\"?[^>]*>", $secvalue))) {
        Header("Location: index.php");
        die();
    }
}

if (eregi("mainfile.php",$PHP_SELF)) {
    Header("Location: index.php");
    die();
}

	function append_sid($a,$b="") {
		return $a.$b;
	}
	
require_once dirname(__FILE__)."/mysql.php";
// Make the database connection.
$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);
if(!$db->db_connect_id){
   echo "Could not connect to the database<br>";
   exit;
}

require_once dirname(__FILE__)."/functions.php";
require_once dirname(__FILE__)."/common.php";


// standard session management 
// $userdata = session_pagestart($user_ip, PAGE_LEONARDO); 
// init_userprefs($userdata); 

// print_r($_COOKIE);

function daddslashes($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = daddslashes($val);
		}
	} else {
		$string = addslashes($string);
		
	}
	return $string;
}

function authcode ($string, $operation, $key = '') {
	global $_DCACHE;

	$discuz_auth_key = md5($_DCACHE['settings']['authkey'].$_SERVER['HTTP_USER_AGENT']);

	$key = md5($key ? $key : $discuz_auth_key);
	$key_length = strlen($key);


	$string = $operation == 'DECODE' ? base64_decode($string) : substr(md5($string.$key), 0, 8).$string;
	$string_length = strlen($string);

	$rndkey = $box = array();
	$result = '';

	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($key[$i % $key_length]);
		$box[$i] = $i;
	}

	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') {
		if(substr($result, 0, 8) == substr(md5(substr($result, 8).$key), 0, 8)) {
			return substr($result, 8);
		} else {
		return substr($result, 8);
			return '';
		}
	} else {
		return str_replace('=', '', base64_encode($result));
	}

}


// error_reporting(E_ERROR | E_WARNING | E_PARSE);
// error_reporting(0);

define('IN_DISCUZ', TRUE);
define('DISCUZ_ROOT', '../');

$timestamp = time();
$fidarray = array();

if(PHP_VERSION < '4.1.0') {
	$_GET = &$HTTP_GET_VARS;
	$_SERVER = &$HTTP_SERVER_VARS;
}

// require_once DISCUZ_ROOT.'/config.inc.php';
// require_once DISCUZ_ROOT.'/include/global.func.php';
// require_once DISCUZ_ROOT.'/include/db_'.$database.'.class.php';
require_once DISCUZ_ROOT.'/forumdata/cache/cache_settings.php';
//require_once DISCUZ_ROOT.'/forumdata/cache/cache_forums.php';
// require_once DISCUZ_ROOT.'/forumdata/cache/style_'.intval($_DCACHE['settings']['styleid']).'.php';

// print_r($_DCACHE);
$groupid = 7;
$discuz_uid = 0;
$discuz_user = $discuz_pw = $discuz_secques = '';

/*
if(!empty($_GET['auth'])) {
	list($uid, $fid, $auth) = explode("\t", authcode($_COOKIE[['cdb_auth'], 'DECODE', md5($_DCACHE['settings']['authkey'])));
	$query = $db->query("SELECT uid AS discuz_uid, username AS discuz_user, password AS discuz_pw, secques AS discuz_secques, groupid
		FROM {$tablepre}members WHERE uid='".intval($uid)."'");
	if($member = $db->fetch_array($query)) {
		if($auth == substr(md5($member['discuz_pw'].$member['discuz_secques']), 0, 8)) {
			extract($member);

		}
	}
}
*/


list($discuz_pw, $discuz_secques, $discuz_uid) = isset($_COOKIE['cdb_auth']) ? 
daddslashes(explode("\t", authcode($_COOKIE['cdb_auth'], 'DECODE')), 1) : array('', '', 0);


// echo "******* $discuz_pw, $discuz_secques, $discuz_uid ******88";

$discuz_uid = intval($discuz_uid);

if(isset($_COOKIE['cdb_auth']) && !$discuz_uid) {
	//clearcookies();
}

$userdata['user_id']=$discuz_uid;
$userdata['username']=$discuz_uid;


$lang['ENCODING']= $langEncodings[$currentlang];
// set page title 
$page_title = 'LEONARDO';


if (isset($_SESSION['user_id'])) {
  $userdata['user_id']  = $_SESSION['user_id'];
  $userdata['username'] = $_SESSION['username'];
}


function is_user($user) {
    global $prefix, $db, $user_prefix;
    if(!is_array($user)) {
        $user = base64_decode($user);
        $user = explode(":", $user);
        $uid = "$user[0]";
        $pwd = "$user[2]";
    } else {
        $uid = "$user[0]";
        $pwd = "$user[2]";
    }
    if ($uid != "" AND $pwd != "") {
        $sql = "SELECT user_password FROM ".$user_prefix."_users WHERE user_id='$uid'";
        $result = $db->sql_query($sql);
        $row = $db->sql_fetchrow($result);
        $pass = $row[user_password];
        if($pass == $pwd && $pass != "") {
            return 1;
        }
    }
    return 0;
}

function cookiedecode($user) {
    global $cookie, $prefix, $db, $user_prefix;
    $user = base64_decode($user);
    $cookie = explode(":", $user);

    $sql = "SELECT user_password FROM ".$user_prefix."_users WHERE username='$cookie[1]'";

	// echo $sql;
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $pass = $row[user_password];
    if ($cookie[2] == $pass && $pass != "") {
        return $cookie;
    } else {
        unset($user);
        unset($cookie);
    }
}



function removecrlf($str) {
    // Function for Security Fix by Ulf Harnhammar, VSU Security 2002
    // Looks like I don't have so bad track record of security reports as Ulf believes
    // He decided to not contact me, but I'm always here, digging on the net
    return strtr($str, "\015\012", ' ');
}

function session_pagestart($user_ip, $thispage_id)
{

}

?>

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


/*
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
*/


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
    if ((eregi("<[^>]*[^w]script*\"?[^>]*>", $secvalue)) ||        (eregi("<[^>]*style*\"?[^>]*>", $secvalue))) {
		if (!$_POST['leonardoAllowAll']) {
			//echo "BAD ~!!!!!";
			Header("Location: index.php");
			die();
		}
    }
}
/*
foreach ($_POST as $secvalue) {
    if ( eregi("<[^>]*script*\"?[^>]*>", $secvalue) ||   
			( eregi("<[^>]*style*\"?[^>]*>", $secvalue) && ! eregi("<[^>]*style=\"color:*\"?[^>]*>", $secvalue)  )
		) {
        Header("Location: index.php");
        die();
    }
}
*/

if (eregi("mainfile.php",$PHP_SELF)) {
    Header("Location: index.php");
    die();
}

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

$mainfile = 1;

function get_lang($module) {
    global $currentlang, $language;

    if (file_exists("modules/$module/language/lang-$currentlang.php")) {
        if ($module == admin) {
            include_once("admin/language/lang-$currentlang.php");
        } else {
            include_once("modules/$module/language/lang-$currentlang.php");
        }
    } else {
        if ($module == admin) {
            include_once("admin/language/lang-$currentlang.php");
        } else {
            include_once("modules/$module/language/lang-$language.php");
        }
    }
}

function is_admin($admin) {
    global $prefix, $db;
    if(!is_array($admin)) {
        $admin = base64_decode($admin);
        $admin = explode(":", $admin);
        $aid = "$admin[0]";
        $pwd = "$admin[1]";
    } else {
        $aid = "$admin[0]";
        $pwd = "$admin[1]";
    }
    if ($aid != "" AND $pwd != "") {
        $sql = "SELECT pwd FROM ".$prefix."_authors WHERE aid='$aid'";
        $result = $db->sql_query($sql);
        $row = $db->sql_fetchrow($result);
        $pass = $row[pwd];
        if($pass == $pwd && $pass != "") {
            return 1;
        }
    }
    return 0;
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


function selectlanguage() {
    global $useflags, $currentlang;
    if ($useflags == 1) {
    $title = _SELECTLANGUAGE;
    $content = "<center><font class=\"content\">"._SELECTGUILANG."<br><br>";
    $langdir = dir("language");
    while($func=$langdir->read()) {
        if(substr($func, 0, 5) == "lang-") {
                $menulist .= "$func ";
        }
    }
    closedir($langdir->handle);
    $menulist = explode(" ", $menulist);
    sort($menulist);
    for ($i=0; $i < sizeof($menulist); $i++) {
        if($menulist[$i]!="") {
            $tl = ereg_replace("lang-","",$menulist[$i]);
            $tl = ereg_replace(".php","",$tl);
            $altlang = ucfirst($tl);
            $content .= "<a href=\"index.php?newlang=$tl\"><img src=\"images/language/flag-$tl.png\" border=\"0\" alt=\"$altlang\" title=\"$altlang\" hspace=\"3\" vspace=\"3\"></a> ";
        }
    }
    $content .= "</font></center>";
    themesidebox($title, $content);
        } else {
    $title = _SELECTLANGUAGE;
    $content = "<center><font class=\"content\">"._SELECTGUILANG."<br><br></font>";
    $content .= "<form action=\"index.php\" method=\"get\"><select name=\"newlanguage\" onChange=\"top.location.href=this.options[this.selectedIndex].value\">";
            $handle=opendir('language');
            while ($file = readdir($handle)) {
                if (preg_match("/^lang\-(.+)\.php/", $file, $matches)) {
                    $langFound = $matches[1];
                    $languageslist .= "$langFound ";
                }
            }
            closedir($handle);
            $languageslist = explode(" ", $languageslist);
            sort($languageslist);
            for ($i=0; $i < sizeof($languageslist); $i++) {
                if($languageslist[$i]!="") {
        $content .= "<option value=\"index.php?newlang=$languageslist[$i]\" ";
                if($languageslist[$i]==$currentlang) $content .= " selected";
        $content .= ">".ucfirst($languageslist[$i])."</option>\n";
                }
    }
    $content .= "</select></form></center>";
    themesidebox($title, $content);
        }
}


function cookiedecode($user) {
    global $cookie, $prefix, $db, $user_prefix;
    $user = base64_decode($user);
    $cookie = explode(":", $user);
    $sql = "SELECT user_password FROM ".$user_prefix."_users WHERE username='$cookie[1]'";
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



function check_html ($str, $strip="") {
    /* The core of this code has been lifted from phpslash */
    /* which is licenced under the GPL. */
    include("config.php");
    if ($strip == "nohtml")
            $AllowableHTML=array('');
        $str = stripslashes($str);
        $str = eregi_replace("<[[:space:]]*([^>]*)[[:space:]]*>",
                         '<\\1>', $str);
               // Delete all spaces from html tags .
        $str = eregi_replace("<a[^>]*href[[:space:]]*=[[:space:]]*\"?[[:space:]]*([^\" >]*)[[:space:]]*\"?[^>]*>",
                         '<a href="\\1">', $str); # "
               // Delete all attribs from Anchor, except an href, double quoted.
        $str = eregi_replace("<[[:space:]]* img[[:space:]]*([^>]*)[[:space:]]*>", '', $str);
               // Delete all img tags
        $tmp = "";
        while (ereg("<(/?[[:alpha:]]*)[[:space:]]*([^>]*)>",$str,$reg)) {
                $i = strpos($str,$reg[0]);
                $l = strlen($reg[0]);
                if ($reg[1][0] == "/") $tag = strtolower(substr($reg[1],1));
                else $tag = strtolower($reg[1]);
                if ($a = $AllowableHTML[$tag])
                        if ($reg[1][0] == "/") $tag = "</$tag>";
                        elseif (($a == 1) || ($reg[2] == "")) $tag = "<$tag>";
                        else {
                          # Place here the double quote fix function.
                          $attrb_list=delQuotes($reg[2]);
                          // A VER
                          $attrb_list = ereg_replace("&","&amp;",$attrb_list);
                          $tag = "<$tag" . $attrb_list . ">";
                        } # Attribs in tag allowed
                else $tag = "";
                $tmp .= substr($str,0,$i) . $tag;
                $str = substr($str,$i+$l);
        }
        $str = $tmp . $str;
        return $str;
        exit;
        /* Squash PHP tags unconditionally */
        $str = ereg_replace("<\?","",$str);
        return $str;
}

function filter_text($Message, $strip="") {
    global $EditedMessage;
    check_words($Message);
    $EditedMessage=check_html($EditedMessage, $strip);
    return ($EditedMessage);
}

/*********************************************************/
/* formatting stories                                    */
/*********************************************************/

function formatTimestamp($time) {
    global $datetime, $locale;
    setlocale (LC_TIME, $locale);
    ereg ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $time, $datetime);
    $datetime = strftime(""._DATESTRING."", mktime($datetime[4],$datetime[5],$datetime[6],$datetime[2],$datetime[3],$datetime[1]));
    $datetime = ucfirst($datetime);
    return($datetime);
}



function removecrlf($str) {
    // Function for Security Fix by Ulf Harnhammar, VSU Security 2002
    // Looks like I don't have so bad track record of security reports as Ulf believes
    // He decided to not contact me, but I'm always here, digging on the net
    return strtr($str, "\015\012", ' ');
}


?>
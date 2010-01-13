<?php


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


require_once dirname(__FILE__)."/mysql.php";
// Make the database connection.
$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);
if(!$db->db_connect_id) {
   echo "Could not connect to the database<br>";
   exit;
}

// require_once dirname(__FILE__)."/sessions.php";
require_once dirname(__FILE__)."/functions.php";
require_once dirname(__FILE__)."/common.php";

// standard session management 
$userdata = session_pagestart($user_ip, PAGE_LEONARDO); 
// init_userprefs($userdata); 

$LEO_lang['ENCODING']= $langEncodings[$currentlang];
// set page title 
$page_title = 'LEONARDO';


$userdata['user_id']=$user->id;
$userdata['username']=$user->username;

if (isset($_SESSION['user_id'])) {
  $userdata['user_id']  = $_SESSION['user_id'];
  $userdata['username'] = $_SESSION['username'];
}


function is_user($user) {
    global $db, $user_prefix,$CONF;
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
        $sql = "SELECT ".$CONF['userdb']['password_field']." FROM ".$CONF['userdb']['users_table']." WHERE ".$CONF['userdb']['user_id_field']."='$uid'";
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
    global $cookie,  $db, $user_prefix;
    $user = base64_decode($user);
    $cookie = explode(":", $user);

    // $sql = "SELECT user_password FROM ".$user_prefix."_users WHERE username='$cookie[1]'";
    $sql = "SELECT ".$CONF['userdb']['password_field']." FROM ".$CONF['userdb']['users_table']." WHERE ".$CONF['userdb']['username_field']."='$cookie[1]'";

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

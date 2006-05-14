<?
/*********************************************************/
/********************************************************/
session_start();

$name=$_GET['name'];
if (isset($name)) {
	if (ereg("\.\.",$name) ) {
		echo "You are so cool...";
	} else {
		$conf_path = "modules/$name/config.php";
		if (file_exists($conf_path)) {
			require_once($conf_path );
		} else {
			die ("Sorry, such conf file doesn't exist...");
		}
	}    
} else {
    die ("Sorry, you can't access this file directly.");
}

// $currentlang=$nativeLanguage;
setVarFromRequest("lng",$nativeLanguage); 
$currentlang=$lng;
require_once("mainfile.php");
$module = 1;
$prefix="phpbb";

// standard session management 
$userdata = session_pagestart($user_ip, PAGE_LEONARDO); 
init_userprefs($userdata); 

$lang['ENCODING']= $langEncodings[$currentlang];
// set page title 
$page_title = 'LEONARDO'; 


// standard page header 
include($phpbb_root_path . 'includes/page_header.'.$phpEx); 

$name=$_GET['name'];
if (isset($name)) {
    global $nukeuser;
    $nukeuser = base64_decode($user);
	
	if (ereg("\.\.",$name) ) {
		echo "You are so cool...";
	} else {
		$modpath = "modules/$name/index.php";
		if (file_exists($modpath)) {
			include($modpath);
		} else {
			die ("Sorry, such file doesn't exist...");
		}
	}    
} else {
    die ("Sorry, you can't access this file directly...");
}

// standard page footer 
include($phpbb_root_path . 'includes/page_tail.'.$phpEx); 

?>
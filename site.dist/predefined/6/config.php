<?
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://leonardo.thenet.gr                                            */
/* http://sourceforge.net/projects/leonardoserver                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

// Specific settigns for phpBB3 module operation ($opMode=6)

// replace this with the basolute path of phpbb3 if you have placed the 'leonardo/' dir
// not in  the root path of phpbb3
$phpbb3AbsPath=realpath( dirname(__FILE__).'/../../../..' );

// for example :
// phpbb3 is installed on /phpbb3 
// leonardo/ is installed on /other/leonardo
// $phpbb3AbsPath=realpath( dirname(__FILE__).'/../../../../../phpbb3' );

// Path settings
$CONF['path']['direct_call']=1;

function moduleRelPath($forUtilityFiles=0){
	global $module_name;
	if ($forUtilityFiles) // for EXT_ files
		return "./";
	else 
		return "./";
}

// bridge to the users table of different forum/portal/cms systems
$CONF['userdb']['users_table']='phpbb_users';
$CONF['userdb']['user_id_field']='user_id';
$CONF['userdb']['username_field']='username';
$CONF['userdb']['password_field']='user_password';

$CONF['userdb']['use_leonardo_real_names']=1;

// if  $CONF['userdb']['use_leonardo_real_names']=0;
// then the following will be used to extract real names from the 'aplication' DB
$CONF['userdb']['has_realnames']=1;
$CONF['userdb']['user_real_name_field']='username';
// if you are running phpbb2 with the realanme mod , uncomment this instead
// $CONF['userdb']['user_real_name_field']='user_realname';

$CONF['userdb']['has_seperate_last_first_name']=0;
$CONF['userdb']['user_last_name_field']='';
$CONF['userdb']['user_first_name_field']='';


// bridge to the login system of different forum/portal/cms systems
$CONF['bridge']['login_url']="../ucp.php?mode=login";
$CONF['bridge']['logout_url']="../ucp.php?mode=logout";
// $CONF['bridge']['register_url']="?name=%module_name%&op=users&page=index&act=register";
$CONF['bridge']['register_url']="../ucp.php?mode=register";
$CONF['bridge']['forgot_password_url']='';
$CONF['bridge']['edit_profile_url']='';


$board_config['cookie_name']='phpbb3';
$board_config['cookie_path']='/';
$board_config['cookie_domain']=$_SERVER['SERVER_NAME'];
$board_config['cookie_secure']=0;
$board_config['session_length']=3600;

// various settings that depend on $opMode !
$CONF_mainfile="index.php";
$CONF_arg_name="name";

function setModuleArg() {
	global $CONF_arg_name,$module_name;
	define('CONF_MODULE_ARG',"?$CONF_arg_name=$module_name");
}

define('IN_PHPBB', true);
define('IN_CRON', true);
$phpEx = substr(strrchr(__FILE__, '.'), 1);

require_once $phpbb3AbsPath.'/common.php';

$board_config['sitename']=$_SERVER['SERVER_NAME'];

$lang['ENCODING']= $langEncodings[$currentlang];
// set page title 
$page_title = 'LEONARDO';

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();

$mode = request_var('mode', '');
// print_r($user);

if (! function_exists('is_user') ) {
	function  is_user($user) {
		if ( $user->data['userID'] ) return true;
		else return false;	
	}
}

require_once dirname(__FILE__).'/functions.php';


setVarFromRequest("clubID",0,1);
$clubID=makeSane($clubID,1);
if ($clubID) { // some things we do when first in club
	if ( is_array($clubsList[$clubID]['gliderCat']) ) {
		setVar("cat",0);
	}
	setVar("lng",$clubsList[$clubID]['lang']);
	$currentlang=$lng;
}
?>
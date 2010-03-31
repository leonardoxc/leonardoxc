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

// Specific settigns for discuz operation ($opMode=4)

function moduleRelPath($forUtilityFiles=0){
	global $module_name;
	if ($forUtilityFiles) // for EXT_ files
		return "./";
	else 
		return "./";
}
/*
$baseInstallationPath="/leonardo";
$baseInstallationPathSet=1;
*/

// bridge to the users table of different forum/portal/cms systems
$CONF['userdb']['users_table']='cdb_members';
$CONF['userdb']['user_id_field']='uid';
$CONF['userdb']['username_field']='username';
$CONF['userdb']['password_field']='user_password';

$CONF['userdb']['use_leonardo_real_names']=1;

// if  $CONF['userdb']['use_leonardo_real_names']=0;
// then the following will be used to extract real names from the 'aplication' DB
$CONF['userdb']['has_realnames']=1;
$CONF['userdb']['user_real_name_field']='username';

$CONF['userdb']['has_seperate_last_first_name']=0;
$CONF['userdb']['user_last_name_field']='';
$CONF['userdb']['user_first_name_field']='';


// bridge to the login system of different forum/portal/cms systems
//$CONF['bridge']['login_url']="?name=%module_name%&op=login";
$CONF['bridge']['login_url']="/logging.php?action=login";
$CONF['bridge']['register_url']="/register.php";
$CONF['bridge']['logout_url']="/logging.php?action=logout&formhash=1";

//$CONF['bridge']['register_url']="?name=%module_name%&op=users&page=index&act=register";
// $CONF['bridge']['register_url']="profile.php?mode=register";
$CONF['bridge']['forgot_password_url']='';
$CONF['bridge']['edit_profile_url']='';



// various settings that depend on $opMode !
$CONF_mainfile="index.php";
$CONF_arg_name="name";



// other settings that are needed
/*
$prefix = 'cdb';

$table_prefix = $prefix.'_';
$user_prefix  = $prefix ;
$users_table= $prefix."_members";

define('USERS_TABLE','cdb_members');
define('SESSIONS_TABLE','cdb_sessions');
define('ANONYMOUS',-1);

$board_config['sitename']=$_SERVER['SERVER_NAME'];
$board_config['cookie_name']='cdb';
$board_config['cookie_path']='/';
$board_config['cookie_domain']=$_SERVER['SERVER_NAME'];
$board_config['cookie_secure']=0;
$board_config['session_length']=3600;
*/	

// we need to get the db login information 
require_once $CONF_abs_path."/site/config_db.php";

// also load the required functions
require_once dirname(__FILE__)."/mainfile.php";

?>
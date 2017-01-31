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

// Specific settigns for standalone operation ($opMode=3)


global $module_name;
$module_name='leonardo';

function moduleRelPath($intendedUse=0){ 
// 0 normal , 1 for utlity files that are called directly, 2 the real path even when mod_rewrite
	global $module_name,$CONF;

	if ( $CONF['links']['type']==3 && $intendedUse!=2 ) {
		return $CONF['links']['baseURL'];
	} else  {
		return './';	
	}	
}

// bridge to the users table of different forum/portal/cms systems
$CONF['userdb']['users_table']='leonardo_users';
$CONF['userdb']['user_id_field']='user_id';
$CONF['userdb']['username_field']='username';
$CONF['userdb']['password_field']='user_password';
$CONF['userdb']['email_field']='user_email';
$CONF['userdb']['users_temp_table']="leonardo_temp_users";

$CONF['userdb']['edit']['enabled']=1;
$CONF['userdb']['edit']['edit_email']=1;
$CONF['userdb']['edit']['edit_password']=1;
$CONF['userdb']['edit']['password_minlength']=4;
$CONF['userdb']['edit']['password_change_expire_time']=3600*3; // 3 hrs

// the functions to change password/eamil
@include_once dirname(__FILE__)."/user_functions.php";
 
$CONF['userdb']['use_leonardo_real_names']=1;

// if  $CONF['userdb']['use_leonardo_real_names']=0;
// then the following will be used to extract real names from the 'aplication' DB
$CONF['userdb']['has_realnames']=1;
$CONF['userdb']['user_real_name_field']='username';

$CONF['userdb']['has_seperate_last_first_name']=0;
$CONF['userdb']['user_last_name_field']='';
$CONF['userdb']['user_first_name_field']='';


// bridge to the login system of different forum/portal/cms systems
$CONF['bridge']['login_url']=array('op'=>'login');
$CONF['bridge']['logout_url']=array('op'=>'login','logout'=>'true');
$CONF['bridge']['register_url']=array('op'=>'register');
// $CONF['bridge']['register_url']="?name=%module_name%&op=users&page=index&act=register";
// $CONF['bridge']['register_url']="profile.php?mode=register";
$CONF['bridge']['forgot_password_url']=array('op'=>'send_password');
$CONF['bridge']['edit_profile_url']='';



// various settings that depend on $opMode !
$CONF_mainfile="index.php";
$CONF_arg_name="name";

// other settings that are needed

$prefix = 'phpbb';
define('USERS_TABLE','leonardo_users');
define('SESSIONS_TABLE','leonardo_sessions');
define('ANONYMOUS',-1);

$board_config['sitename']=$_SERVER['SERVER_NAME'];
$board_config['cookie_name']='leonardo';
$board_config['cookie_path']='/';
$board_config['cookie_domain']=$_SERVER['SERVER_NAME'];
$board_config['cookie_secure']=0;
$board_config['session_length']=3600;

// we need to get the db login information 
require_once $CONF_abs_path."/site/config_db.php";

// also load the required functions
require_once dirname(__FILE__)."/mainfile.php";

?>
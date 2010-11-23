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

// Specific settigns for phpNuke module ($opMode=1)


function moduleRelPath($forUtilityFiles=0){
	global $module_name;
	if ($forUtilityFiles) // for EXT_ files
		return "./";
	else 
		return "modules/$module_name";
}

// bridge to the users table of different forum/portal/cms systems
$CONF['userdb']['users_table']='nuke_users';
$CONF['userdb']['user_id_field']='user_id';
$CONF['userdb']['username_field']='username';
$CONF['userdb']['password_field']='user_password';
$CONF['userdb']['email_field']='user_email';

$CONF['userdb']['use_leonardo_real_names']=1;

// if  $CONF['userdb']['use_leonardo_real_names']=0;
// then the following will be used to extract real names from the 'aplication' DB
$CONF['userdb']['has_realnames']=1;
$CONF['userdb']['user_real_name_field']='username';

$CONF['userdb']['has_seperate_last_first_name']=0;
$CONF['userdb']['user_last_name_field']='';
$CONF['userdb']['user_first_name_field']='';

// bridge to the login system of different forum/portal/cms systems
$CONF['bridge']['login_url']="?name=%module_name%&op=login";
$CONF['bridge']['logout_url']="?name=$module_name&op=login&logout=true";
$CONF['bridge']['register_url']="?name=%module_name%&op=users&page=index&act=register";
// $CONF['bridge']['register_url']="profile.php?mode=register";
$CONF['bridge']['forgot_password_url']='';
$CONF['bridge']['edit_profile_url']='';


// various settings that depend on $opMode !
$CONF_mainfile="modules.php";
$CONF_arg_name="name";

// this is missing from phpNuke so define it here
function append_sid($a,$b="") {
	return $a.$b;
}

?>
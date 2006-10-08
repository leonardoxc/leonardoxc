<?php

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

require $moduleRelPath.'/CL_template.php';
$Ltemplate=new LTemplate($moduleRelPath.'/templates/'.$PREFS->themeName);

$Ltemplate->set_filenames(array(
	'body'=>'header.html')
);

$Ltemplate->assign_vars(array(
	'STYLE_LINK'=>$moduleRelPath.'/templates/'.$PREFS->themeName.'/style.css',
	'IMG_PATH'	=>$moduleRelPath.'/templates/'.$PREFS->themeName.'/img/'
	));

$Ltemplate->assign_block_vars($userID ? 'SWITCH_LOGIN_USER' : 'SWITCH_ANON_USER',array());

if (in_array($userID,$admin_users))
	$Ltemplate->assign_block_vars('SWITCH_ADMIN',array());

$Ltemplate->pparse('body');




function docookie($setuid,$setusername,$setpass)
{
	setcookie('user',base64_encode("$setuid:$setusername:$setpass"),time()+60*60*24*30);	// ~1 month
}

?>
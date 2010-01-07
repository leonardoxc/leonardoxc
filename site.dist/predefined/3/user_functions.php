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

// user data change functions  for standalone operation ($opMode=3)

function leoUser_changeEmail($userID, $newEmail) {
	global $db,$CONF;
		
	if (!$userID || !$newEmail) {
		return -1;
	} 		
	$email=emailChecked($newEmail);
	if (! $email) {
		return -2;
	}
	
	$sql='UPDATE '.$CONF['userdb']['users_table'].' SET '.$CONF['userdb']['email_field'].'="'.$email.'" WHERE '.$CONF['userdb']['user_id_field']."=$userID";
	$res=$db->sql_query($sql);
	if($res<=0){
		return 0;
	}	
	return 1;
}


function leoUser_changePassword($userID, $newPassword) {

	global $db,$CONF;
		
	if (!$userID || !$newPassword ) {
		return -1;
	} 		
	
	$passwordMinLength=($CONF['userdb']['edit']['password_minlength'] ) ? 
							$CONF['userdb']['edit']['password_minlength'] : 4;
							
	if ( strlen($newPassword)<$passwordMinLength ) {
		return -2;
	}

	if ( function_exists('leonardo_hash') ) { 
		$newPassword=leonardo_hash($newPassword);
	} else {
		$newPassword=md5($newPassword);
	}
					
	$sql='UPDATE '.$CONF['userdb']['users_table'].' SET '.$CONF['userdb']['password_field'].'="'.$newPassword.'" WHERE '.$CONF['userdb']['user_id_field']."=$userID";
	$res=$db->sql_query($sql);
	if($res<=0){
		return 0;
	}	

	return 1;
		
}

?>
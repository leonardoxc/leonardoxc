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

class L_auth {
	function auth() {

	}

	function isAdmin($userID){
		global $admin_users;
		if (in_array($userID,$admin_users)) return 1;
		else return 0;
	}


	function isModerator($userID){
		global $admin_users,$mod_users;
		if (in_array($userID,$admin_users) || in_array($userID,$mod_users) )  return 1;
		else return 0;
	}

	function isClubAdmin($userID,$clubID) {
		global $clubsList;
		if ($clubsList[$clubID]['adminID']==$userID && $userID <>0 ) return 1;
		else return 0;
	}
	

}

?>
<?
//************************************************************************
// Leonardo XC Server, http://www.leonardoxc.net
//
// Copyright (c) 2004-2010 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: CL_auth.php,v 1.6 2010/03/14 20:56:09 manolis Exp $                                                                 
//
//************************************************************************

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
		if ($userID == 0 ) return 0;
		
		if (is_array($clubsList[$clubID]['adminID'])) {
			if ( in_array($userID ,$clubsList[$clubID]['adminID']) ) return 1;
			else return 0;			
		} 
		
		if ($clubsList[$clubID]['adminID']==$userID ) return 1;
		else return 0;
	}
	

}

?>
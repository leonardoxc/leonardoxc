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

	if ($userAction == "users") {
		 require_once dirname(__FILE__)."/GUI_user_list.php";	
	} else 	if ($userAction == "register") {
		 require_once dirname(__FILE__)."/GUI_user_register.php";	
	} else 	if ($userAction == "profile") {
		 require_once dirname(__FILE__)."/GUI_user_show.php";	
	} else 	if ($userAction == "login") {
		if ($_POST['loginForm']==1) {   //do login and set cookies

			$uname=$_POST['uname'];
			$upass=$_POST['upass'];
	
			$sql = "SELECT user_password, user_id FROM ".$user_prefix."_users WHERE username='$uname'";
			$result = $db->sql_query($sql);
			$setinfo = $db->sql_fetchrow($result);
	
			if ( $db->sql_numrows($result)==1 && $setinfo[user_password] != "" ) {
				$md5pass = md5($upass) ;
				if ($setinfo[user_password] != $md5pass  ) $loginMessage="Wrong Username/Password";
				else {  // succesful login
					docookie($setinfo[user_id], $uname, $md5pass );
					// important to set these
					$userID=$setinfo[user_id];
					$userName=$uname;					
					header("Location: http://".$_SERVER['SERVER_NAME'].getRelMainFileName()."&op=pilot_profile");
					exit;
				}
			} else {
				$loginMessage="Wrong Username/Password";
			}
			// In case of error redirect to form
			$newLocation="Location: http://".$_SERVER['SERVER_NAME'].getRelMainFileName()."&op=users&page=index&act=login&msg=".htmlspecialchars($loginMessage);			
			header($newLocation);
		} else {
			// show the login form instead
	  	    require_once dirname(__FILE__)."/GUI_user_login.php";	
		}

	} else 	if ($userAction == "logout") {
		  setcookie("user","",time()-3600);
		  $_COOKIE['user']="";
		  $userID=0;
		  $userName="";
		  header("Location: http://".$_SERVER['SERVER_NAME'].getRelMainFileName()."&op=main");
	}

?>


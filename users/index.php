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
// $Id: index.php,v 1.5 2010/04/06 13:45:39 manolis Exp $                                                                 
//
//************************************************************************

	if (! L_auth::isAdmin($userID)  ) {
		return;
	}

// 	require_once dirname(__FILE__).'/users.css';
	
	$userAction=$_GET['act'];
	if (!$userAction) $userAction = "users";
	
	openMain("User Admin Panel",0,'');
?>

 <table align="center" width="740"> 
   <tr> 
     <td bgcolor="#F9F6E1" class=header><center> 
         <font color="#005177"> :: 
         [ <a href="<?=getLeonardoLink(array('op'=>'users','act'=>'users'))?>">User List</a> ] ::          
         [ <a href="<?=getLeonardoLink(array('op'=>'register'))?>">Register (as a plain visitor)</a> ] 
         </font> 
        </center></td> 
   </tr> 
</table> 
<br>
<?
 
 if ($userAction == "users" ) {
	 require_once dirname(__FILE__)."/GUI_admin_list_users.php";
 } else if ($userAction == "edit" ) {
	 require_once dirname(__FILE__)."/GUI_admin_user_edit.php";
 }
 closeMain();

?> 
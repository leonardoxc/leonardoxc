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
         [ <a href="<?=getLeonardoLink(array('op'=>'users','act'=>'add'))?>">Add user</a> ] :: 
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
 } else if ($userAction == "add") {
	 require_once dirname(__FILE__)."/GUI_admin_user_add.php";
 } else  if ($userAction == "delete" ) {
	 require_once dirname(__FILE__)."/GUI_admin_user_delete.php";
 }

 closeMain();

?> 
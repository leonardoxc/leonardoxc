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

	if (!in_array($userID,$admin_users) ) {
		return;
	}

?>
 <table align="center" width="740"> 
  <tr> 
     <td class=header><font class="bigfont"> 
       <center> 
        <font color="#005177">User Admin Panel</font> 
      </center> 
       </font></td> 
   </tr> 
  <tr> 
     <td class=header><center> 
         <font color="#005177"> :: [ <a href="?op=users&page=admin&act=users">User
         Administration </a> ] :: [ <a href="?op=users&page=index&act=users">Show
         Users</a> ] :: [ <a href="?op=users&page=admin&act=add">Add user</a> ]
         :: </font> 
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
 } else {
?> 
<br>
<table align="center" width="600"> 
  <tr> 
    <td><table width="100%" align="center" bgcolor="#cccccc" cellpadding="2" cellspacing="1" class="header_logo"> 
        <tr> 
          <td bgcolor="#dcdcdc"> <p align="center"><br> 
              Welcome to the User Administration Panel. </p>
            <p align="center">Please choose your
            action for the menu above</p>
            <p align="center"><br> 
                </p></td> 
        </tr> 
      </table></td> 
  </tr> 
  <tr> 
    <td class=header>&nbsp; </td> 
  </tr> 
</table> 
<?
 }


?> 

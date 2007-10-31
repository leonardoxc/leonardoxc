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

?>
 <table align="center" width="600"> 
<tr> 
  <td><table width="100%" align="center" bgcolor="#cccccc" cellpadding="2" cellspacing="1" class="header_logo"> 
      <tr> 
        <td bgcolor="#dcdcdc"><div align="center"><br> 
            <strong>User Administration</strong><br> 
            <hr color="#cccccc"> 
            <table align="center" width="100%" cellpadding="2" cellspacing="1" bgcolor="#808080"> 
              <tr align="center" bgcolor="#cccccc"> 
                <td width=50>User ID</td> 
                <td width=140><b>User</b></td> 
                <td><b>Actions</b></td> 
              </tr> 
    <?
		$sql= "SELECT * from $users_table ORDER by user_id ";

		$result = $db->sql_query($sql);
		$i=0;
		while($disp_users = $db->sql_fetchrow($result) ) { 
	?> 
              <tr bgcolor="<? echo (($i%2)?"#E9E7F3":"#ffffff"); ?>" align="left"> 
                <td><? echo $disp_users['user_id'] ?></td> 
                <td> <font class=table_u><b><? echo $disp_users['username'] ?></b></td> 
                <td><font class=table_u>[ <a href="?op=users&page=admin&act=edit&editUserID=<? echo $disp_users['user_id'] ?>" title="Edit user: <? echo $disp_users['username'] ?>">Edit user</a> ]
                  - [ <a href="?op=users&page=admin&act=delete&user=<? echo $disp_users['username'] ?>" title="Delete user: <? echo $disp_users['username'] ?>">Delete
                  user</a> ] </td> 
              </tr> 
    <?
		$i++;
	}
	?> 
            </table> 
          </div></td> 
      </tr> 
    </table> 

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

$showUserID=$_GET['user_id_view']+0;

$sql= "SELECT * from $users_table WHERE user_id = $showUserID";
$result = $db->sql_query($sql);
$disp = $db->sql_fetchrow($result) ;

?>
 <table align="center" width="600" bgcolor="#808080" cellpadding="2" cellspacing="1"> 
  <tr> 
     <td background="images/bar.gif" colspan="2">&nbsp; </td> 
   </tr> 
  <tr> 
     <td bgcolor="#cccccc" colspan="2"> &nbsp; <b>Profile for user</b>: $user</td> 
   </tr> 
  <tr> 
     <td bgcolor="#a9a9a9" colspan="2">&nbsp; </td> 
   </tr> 
  <tr align="center" bgcolor="#cccccc"> 
     <td width="40%"> <u><b>First name</b></u></td> 
     <td class=header_logo>$disp[0]</td> 
   </tr> 
  <tr align="center" bgcolor="#cccccc"> 
     <td width="40%"><u><b>Last name</b></u></td> 
     <td class=header_logo>$disp[1] </td> 
   </tr> 
  <tr align="center" bgcolor="#cccccc"> 
     <td width="40%"> <u><b>Email</b></u></td> 
     <td class=header_logo><a href="?op=users&page=sendmail&to=$user&subject="><i>not
           available</i></a></td> 
   </tr> 
  <tr align="center" bgcolor="#cccccc"> 
     <td width="40%"> <u><b>ICQ</b></u></td> 
     <td class=header_logo>$disp[3] </td> 
   </tr> 
  <tr align="center" bgcolor="#cccccc"> 
     <td width="40%"> <u><b>Website</b></u></td> 
     <td class=header_logo>$disp[4] </td> 
   </tr> 
  <tr align="center" bgcolor="#cccccc"> 
     <td width="40%"> <b><u>Username</u></b></td> 
     <td class=header_logo> $disp[5]</td> 
   </tr> 
  <tr> 
     <td bgcolor="#a9a9a9" colspan="2">&nbsp; </td> 
   </tr> 
</table> 
<br> 
<br> 
</td> 
</tr> 
<tr> 
  <td class=header>&nbsp;</td> 
</tr> 
</table> 

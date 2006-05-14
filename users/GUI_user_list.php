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
 <table align="center" width="500" bgcolor="#a9a9a9" cellpadding="1" cellspacing="1"> 
  <tr> 
     <td background="images/bar.gif" colspan="3">&nbsp;</td> 
   </tr> 
  <tr bgcolor="#cccccc" align="center"> 
     <td width="33%"> <font class="header_logo" color="ff0000">&nbsp; Username&nbsp;</td> 
     <td width="33%"> <font class="header_logo" color="ff0000">&nbsp;Profile&nbsp;</td> 
     <td width="33%"><font class="header_logo" color="ff0000">&nbsp; Email&nbsp;</td> 
   </tr> 
  <tr> 
     <td colspan="3">&nbsp;</td> 
   </tr> 

  <?
	$sql= "SELECT * from $users_table ORDER BY user_id";
	$result = $db->sql_query($sql);

	while($list = $db->sql_fetchrow($result) ) { 
	?> 
  <tr bgcolor="#cccccc" align="center"> 
     <td>$list[5]</td> 
     <td><a href="?op=users&page=index&substr=4&act=profile&user=$list[5]"><img src="images/profile.jpg" border="0" alt="Click to see user's profile"></a></td> 
     <td><a href="?op=users&page=sendmail&to=$list[5]&subject="><img src="images/email.jpg" border="0" alt="Click to send email to the user"></a></td> 
   </tr> 
  <tr> 
     <td colspan="3"></td> 
   </tr> 
  <?
	}
?> 
</table> 
<br> 
<br> 
</td> 
</tr> 
<tr> 
  <td class=header>&nbsp;</td> 
</tr> 
</table> 

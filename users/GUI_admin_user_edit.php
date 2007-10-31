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
$userID_to_edit=$_GET['editUserID'];
$sql = "SELECT * from $users_table WHERE user_id = '$userID_to_edit'";
$result = $db->sql_query($sql);
$user_prefs = $db->sql_fetchrow($result);

$user_ex_pass = $user_prefs['user_password']; // puts default user password

?>

<form method="post" action="?op=users&page=admin&act=edit"> 
  <table align="center" width="500" cellpadding="2" cellspacing="1" bgcolor="#D8DCED"> 
     <tr bgcolor="#E9E7F3" >
       <td colspan="2"><div align="center" class="bigfont"><strong>Edit user: <?=$user_prefs['username']?>
       </strong></div></td>
    </tr>
     <tr bgcolor="#F4F5FA" class=header> 
      <td width="40%" bgcolor="#F4F5FA"><div align="right">
          <input type="hidden" name="uname" value="$user"> 
           <input type="hidden" name="default_pass" value="$user_ex_pass"> 
         <u>Username </u></div></td> 
      <td align="center" bgcolor="#F4F5FA"><div align="left">
        <input type="text" name="ufname" value="<?=$user_prefs['username']?>"> 
      </div></td> 
	 </tr>
     <tr bgcolor="#F4F5FA" class=header> 
      <td bgcolor="#F4F5FA"> <div align="right"><u>Email</u></div></td> 
      <td align="center"> <div align="left">
        <input name="uemail" type="text"  value="<?=$user_prefs['user_email']?>" size="30"> 
      </div></td> 
     <tr bgcolor="#F4F5FA" class=header> 
      <td bgcolor="#F4F5FA"> <div align="right"><u>New password</u></div></td> 
      <td align="center"><div align="left">
        <input type="password" name="unpass"> 
      </div></td> 
    </tr>
     <tr bgcolor="#F4F5FA" class=header>
       <td><input name="reset" type="reset" value="Default"></td>
       <td align="center"><div align="right">
          <input name="submit" type="submit" value="Change settings">
         </div></td>
     </tr> 
  </table> 
  <br> 
  <p align="right">
</form> 

<?

function ap_edit_user_2() {

include("db_connect.php");

GLOBAL $uname, $default_pass, $ufname, $ulname, $uemail, $uicq, $uwsite, $unpass;

$p_header = "<html><head><title>[-] MoJT Login System - Administration Panel</title>
<LINK REL=\"StyleSheet\" HREF=\"mojt.css\" TYPE=\"text/css\"></head>";

$p_body = "<body bgcolor=\"dcdcdc\"><br><br><br><table align=\"center\" width=\"50%\"><tr><td class=header><font class=\"bigfont\"><center>MoJT Login System [ADMIN]</center></font>
</td></tr><tr><td class=header><center><font class=content><font color=\"005177\">ADCPanel :: [ <a href=\"?op=users&page=admin&act=users\">Users</a> ] - [ <a href=\"?op=users&page=admin&act=settings\">Settings</a> ] - [ <a href=\"?op=users&page=admin&act=logout\">Logout</a> ] :: </font></center></td></tr><tr><td><table width=\"100%\" align=\"center\" bgcolor=\"cccccc\" cellpadding=\"2\" cellspacing=\"1\" class=\"header_logo\"><tr><td bgcolor=\"dcdcdc\">";

$p_body .= "<br><br><center>User succesfully edited!</center>";

$p_body .= "<br><br></td></tr></table></td></tr><tr><td class=header>&nbsp;</td></tr></table>";

$p_footer = "<br><br></td></tr></table></td></tr><tr><td class=header>&nbsp;</td></tr></table><br><font class=content><center>Powered by CsCPortal :: <a href=\"http://cscp.cs-centar.net\" target=_blank>http://cscp.cs-centar.net</a></center></body></html>";


if (empty($unpass)) {

$field_str .= " f_name = '$ufname', ";
$field_str .= " l_name = '$ulname', ";
$field_str .= " email = '$uemail', ";
$field_str .= " icq = '$uicq', ";
$field_str .= " website = '$uwsite', ";
$field_str .= " username = '$uname', ";
$field_str .= " password = '$default_pass', ";
$field_str .= " last_access = 'time()' ";

$edit_without_change = mysql_query("UPDATE cscp_mojt_users SET $field_str WHERE username = '$uname'");

echo $p_header;
echo $p_body;
echo $p_footer;

exit;

}

if (!empty($unpass)) {

$field_str .= " f_name = '$ufname', ";
$field_str .= " l_name = '$ulname', ";
$field_str .= " email = '$uemail', ";
$field_str .= " icq = '$uicq', ";
$field_str .= " website = '$uwsite', ";
$field_str .= " username = '$uname', ";
$field_str .= " password = '$unpass', ";
$field_str .= " last_access = 'time()' ";

$edit_with_change = mysql_query("UPDATE cscp_mojt_users SET $field_str WHERE username = '$uname'");

echo $p_header;
echo $p_body;
echo $p_footer;

exit;

	}

}
?> 

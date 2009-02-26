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
	
if ($_POST['formAdd']==1) {

	GLOBAL $ufname, $ulname, $uemail, $uemail2, $uicq, $uwsite, $uname, $upass, $upass2;
	
	
	$p_body = "<br><br><table align=\"center\" width=\"50%\"><tr><td class=header><font class=\"bigfont\"><center>MoJT Login System [ADMIN]</center></font></td></tr>
	<tr><td class=header><center><font class=content><font color=\"005177\">ADCPanel :: [ <a href=\"?op=users&page=admin&act=users\">Users</a> ] - [ <a href=\"?op=users&page=admin&act=settings\">Settings</a> ] - [ <a href=\"?op=users&page=admin&act=logout\">Logout</a> ] :: </font></center></td></tr><tr><td><table width=\"100%\" align=\"center\" bgcolor=\"cccccc\" cellpadding=\"2\" cellspacing=\"1\" class=\"header_logo\"><tr><td bgcolor=\"dcdcdc\">";
	
	$p_body .= "<br><br><center>User successfully added!</center>";
	
	$p_footer = "<br><br></td></tr></table></td></tr><tr><td class=header>&nbsp;</td></tr></table><br><font class=content><center>Powered by CsCPortal :: <a href=\"http://cscp.cs-centar.net\" target=_blank>http://cscp.cs-centar.net</a></center></body></html>";
	
	$query_usd = "INSERT into cscp_mojt_users VALUES('$ufname', '$ulname', '$uemail', '$uicq', '$uwsite', '$uname', '$upass', ' ')";
	
	// checking for errors
	
	if (empty($ufname) OR empty($uemail) OR empty($uemail2) OR empty($uname) OR empty($upass) OR empty($upass2)) {
		echo "<html><head></head><body bgcolor=\"dcdcdc\"><br><br>Please fill all fields!<br><a href=\"javascript:history.back(1)\">Back</a><br></body></html>";
		exit;
	}
	if ($uemail != $uemail2) {	
		echo "<html><head></head><body bgcolor=\"dcdcdc\"><br><br>Please enter same email addresses!<br><a href=\"javascript:history.back(1)\">Back</a><br></body></html>";
		exit;
	}
	if ($upass != $upass2) {
		echo "<html><head></head><body bgcolor=\"dcdcdc\"><br><br>Please enter same passwords!<br><a href=\"javascript:history.back(1)\">Back</a><br></body></html>";
		exit;
	}
	
	$add_it = mysql_query("$query_usd");
	echo $p_header;
	echo $p_body;
	echo $p_footer;

} // end if

?>
 <form method="post" action="?op=users&page=admin&act=add" name="add_user_form"> 
   <div align="center"></div>
  <table align="center" width="500" cellpadding="2" cellspacing="1" bgcolor="#D8DCED"> 
     <tr bgcolor="#E9E7F3" >
       <td colspan="2"><div align="center"><u><strong>Add user</strong></u> <strong>&nbsp;&nbsp; [Fields
           with <font color="ff0000">*</font> must
       be filled] </strong></div></td>
     </tr>
     <tr bgcolor="#F4F5FA" class=header> 
      <td width="40%"> <div align="right"><u>First Name</u> <font color="ff0000">*</font></div></td> 
      <td align="center" bgcolor="#F4F5FA"><div align="left">
        <input name="ufname" type="text" size="30">
      </div></td> 
    </tr> 
     <tr bgcolor="#F4F5FA" class=header> 
      <td> <div align="right"><u>Last Name</u><font color="ff0000"> *</font></div></td> 
      <td align="center" bgcolor="#F4F5FA"><div align="left">
        <input name="ulname" type="text" size="30"> 
      </div></td> 
    </tr> 
     <tr bgcolor="#F4F5FA" class=header> 
      <td><div align="right"><u>Email</u> <font color="ff0000">*</font> </div></td> 
      <td align="center" bgcolor="#F4F5FA"><div align="left">
        <input name="uemail" type="text" size="30">
      </div></td> 
    </tr> 
     <tr bgcolor="#F4F5FA" class=header> 
      <td> <div align="right"><u>Website</u> [Without http://]</div></td> 
      <td align="center" bgcolor="#F4F5FA"><div align="left">
        <input name="uwsite" type="text" size="30">
      </div></td> 
    </tr> 
     <tr bgcolor="#F4F5FA" class=header> 
      <td><div align="right"><u>Username</u> <font color="ff0000">*</font></div></td> 
      <td align="center" bgcolor="#F4F5FA"><div align="left">
        <input name="uname" type="text" size="30">
      </div></td> 
    </tr> 
     <tr bgcolor="#F4F5FA" class=header> 
      <td><div align="right"><u>Password</u> <font color="ff0000">*</font></div></td> 
      <td align="center" bgcolor="#F4F5FA"><div align="left">
        <input name="upass" type="password" size="30"> 
      </div></td> 
    </tr> 
     <tr bgcolor="#F4F5FA" class=header> 
      <td><div align="right"><u>Password again</u> <font color="ff0000">*</font> </div></td> 
      <td align="center" bgcolor="#F4F5FA"><div align="left">
        <input name="upass2" type="password" size="30">
      </div></td> 
    </tr>
     <tr bgcolor="#F4F5FA" class=header>
       <td>&nbsp;</td>
       <td align="center" bgcolor="#F4F5FA">
         <div align="right">
           <input name="formAdd" type="hidden" value="1">
           <input name="submit" type="submit" value="Add user">
       </div></td>
     </tr> 
   </table> 
  <br> 
</form> 
<br> 
<br> 

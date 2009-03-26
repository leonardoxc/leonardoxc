<?

echo "not used";
exit;

if(isset($_POST['changepw'])){
   $pw=trim($_POST['pwtochange']);
   $pw2=trim($_POST['pwtochange2']);    
    if($pw!=$pw2){
    $msg=_PwdAndConfDontMatch;//"Password do not Match";
    }else{
      if(strlen($pw)<$CONF_password_minlength){
      $msg=_PwdTooShort; //"Password to not have minimum length of $CONF_password_minlength";
      }else{
      $pw=md5($pw);
        $sql="update ".$CONF['userdb']['users_table']." set user_password='$pw' where user_id=$userID";
        $af=$db->sql_affectedrows($db->sql_query($sql));
        if($af>0){
        $msg=_PwdChanged;//"Password successfully updated";
        }else{
        $msg=_PwdNotChanged;//"Password was not changed";
        }  
      }
    }
   print "<br><br><div align='center'><b>".$msg."</b></div><br>";
 //user_new_email
// print $sql;
}
?><head><style type="text/css">
<!--
.alertMsg a{
    color: #FF0000;
    font-size: 11px;
}


.smalltext {
    font-size: 90%; FONT-SIZE: 11px;
    COLOR: #333333; 
    FONT-FAMILY: Verdana, Arial, Helvetica;
}
.tcat { background: #80A9EA url('img/bg_login_table.gif') repeat-x top left;  COLOR: #FFFFFF;     
font-style:normal; font-variant:normal; font-weight:normal; font-size:12px; font-family:Verdana, Tahoma
}
.logintext {
    border:1px solid #888888; COLOR: #000000;
    FONT-FAMILY: Verdana, Tahoma;
    FONT-SIZE: 11px;
    WIDTH: 150px;
    MARGIN: 0px;
    BACKGROUND: #FFFFFF url('img/icon_user.gif') no-repeat 1px 1px;
    padding-left:18px; vertical-align:middle; padding-right:2px; padding-top:3px; padding-bottom:2px; background-color:#FFFFFF
}
.loginpassword {    BACKGROUND-COLOR: #FFFFFF;
    COLOR: #000000;
    FONT-FAMILY: Verdana, Tahoma;
    FONT-SIZE: 11px;
    BORDER-STYLE: solid;
    BORDER-COLOR: #888888;
    BORDER-WIDTH: 1px;
    WIDTH: 150px;
    PADDING: 3px 2px 2px 2px;
    MARGIN: 0px;
    VERTICAL-ALIGN: middle;
}
.newmail {    BACKGROUND-COLOR: #FFFFFF;
    COLOR: #000000;
    FONT-FAMILY: Verdana, Tahoma;
    FONT-SIZE: 11px;
    BORDER-STYLE: solid;
    BORDER-COLOR: #888888;
    BORDER-WIDTH: 1px;
    WIDTH: 250px;
    PADDING: 3px 2px 2px 2px;
    MARGIN: 0px;
    VERTICAL-ALIGN: middle;
}
.checkmail {    BACKGROUND-COLOR: #FFFFFF;
    COLOR: #000000;
    BORDER-STYLE: solid;
    BORDER-COLOR: #888888;
    BORDER-WIDTH: 1px;
    PADDING: 3px 2px 2px 2px;
    MARGIN: 0px;
    VERTICAL-ALIGN: middle;
}
.submitButton {
BORDER: 0px solid #FFFFFF; BACKGROUND: url('img/bg_submitButton.gif') no-repeat; 
HEIGHT: 21px; WIDTH: 150px; COLOR: #000000; FONT-FAMILY: Verdana, Tahoma; FONT-SIZE: 11px;
MARGIN: 0px; padding-top: 3px; padding-bottom: 3px; ALIGN: center; vertical-align:middle;
text-align:center;
}
.tborder {    background-color: #FFFFFF;     color: #000000; border: 1px solid #6393DF; }
-->
</style>
 </head>


<form  id="loginform" name="loginform" action="" method="post" >



<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
  <tr> 
    <th height="25" class="thHead" nowrap="nowrap"><?=_ChangePasswordForm?></th>
  </tr>
  <tr> 
    <td class="row1">&nbsp;</td>
  </tr>
</table>



 <table width=350 align="center"  cellpadding="0" cellspacing="0" class="tborder">
   <tbody>
   <tr class="tcat">
    <td align="left" width="1"><img src="img/space.gif" height="21" width="1"></td>
    <td align="left" width="1"><img src="img/icon_blockarrow.gif" height="8" width="8"></td>
    <td align="left" valign="middle">&nbsp;<span class="smalltext"><strong>
    <font color="#ffffff"><?=_ChangePasswordForm?></font></strong></span></td>
    <td align="right" width="130"><span class="smalltext">&nbsp;</span></td>
  </tr>
  <tr>
    <td colspan="4" bgcolor="#f5f5f5">
    <table border="0" cellpadding="2" cellspacing="1" width="100%">
      <tbody>
      <tr>
        <td class="smalltext" width="100%" colspan="2" align="center"><?=_EnterPasswordOnlyToChange?></td>
      </tr>
      <tr>
        <td class="smalltext" width="46%" align="right"><?=_New_Password;?></td>
        <td width="54%">:<input name="pwtochange" class="loginpassword" value="" type="password"></td>
      </tr>
      <tr>
        <td class="smalltext" align="right"><?=_PASSWORD_CONFIRMATION;?></td>
        <td>:<input name="pwtochange2" class="loginpassword" value="" type="password"></td>
        </tr>
      <tr>
        <td class="smalltext" colspan="2" align="center">
          <input name="changepw" value="<?=_Login_Stuff?>" class="submitButton" type="submit"></td>
      </tr>
    </tbody>
    </table>        
  </tr>
</table> 

 <p>&nbsp;</p>
 <div align="center"><span class="alertMsg"><a href="mailto:<?=$adminMail?>" target="_self"><?=_PROBLEMS_HELP?></a></span>
 </div>
</form>
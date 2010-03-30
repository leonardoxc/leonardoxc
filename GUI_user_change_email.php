<?php

echo "not used";
exit;
//var_dump(get_defined_vars());

function _get_pilot_atributes(){
   global $db,$userdata,$pilotsTable;
   $sql="SELECT * FROM $pilotsTable WHERE pilotID=$userdata[user_id]";
   return mysql_fetch_assoc($db->sql_query($sql));  
} 
function _check_double_email($email,$type){
    global $userdata,$db,$CONF;
        if($type=='old')
        $sql="select user_email from ".$CONF['userdb']['users_table']." where user_email='$email' and user_id<>$userdata[user_id]";
        if($type=='new')
        $sql="select user_new_email from ".$CONF['userdb']['users_table']." where user_new_email='$email' and user_id<>$userdata[user_id]"; 
        $res=$db->sql_query($sql);
        $nr=$db->sql_numrows($res); 
        if($nr==0){
            return false;
        }else{
            return true; 
        }
}
function _update_user_new_mail($email,$actkey){
    global $userdata,$db,$CONF;    
    $sql="update ".$CONF['userdb']['users_table']." set user_emailtime=".time().",user_actkey='$actkey', user_new_email='$email' where user_id=$userdata[user_id]";  
    $af=$db->sql_affectedrows($db->sql_query($sql));
    if($af==1){
    return true;
    }
    return;
}
if(isset($_GET['rkey'])){
$rk=trim(addslashes($_GET['rkey']));
 if(strlen($rk)>10){
 $sql="update ".$CONF['userdb']['users_table']." set user_active=1, user_emailtime=0, user_actkey='',user_email=user_new_email, user_new_email=''  where user_actkey='$rk'";
 $db->sql_query($sql);
$ar=$db->sql_affectedrows($db);
 if($ar==1){
 $msg=_EmailSaved; 
  } else{
  $msg= _EmailSaveProblem ." " . _request_key_not_found;
 }
 }else{
 $msg=_EmailSaveProblem ." ". _request_key_invalid; 
 }
 print "<br><div align='center'><b>$msg</b></div><br>"; 
}else{ 
if(isset($_POST['changeem'])){
    $pilotdata =_get_pilot_atributes();
    $actkey=md5(uniqid(rand(), true));
 $msg=''; //_EmailInvalid
   $expiretime=date("d/M/Y H:i:s",$userdata['user_emailtime']+($CONF_expire_time));
   $email=trim($_POST['emtochange']);
   $email2=trim($_POST['emtochange2']);    
     if($email!=$email2){$msg=_Email_AndConfDontMatch; }// "Informed emails are not equal";
     if(strlen($msg)==0 && strlen($email)==0){$msg=_EmailEmpty;}  //"Email can not be empty!";
     if(strlen($msg)==0 && $email!=emailChecked($email)){$msg=_EmailInvalid; } // Invalid Email
     if(strlen($msg)==0 && $userdata['user_email']==$email){$msg=_Email_allready_yours;} //"The informed email is allready yours, nothing to do"
     if(strlen($msg)==0 && $userdata['user_new_email']==$email){$msg=_Email_allready_have_request;} //'There is already your request for changing to these email, nothing to do'   
     if(strlen($msg)==0 && _check_double_email($email,'old')){$msg=_Email_used_by_other;} //"this email are used in another pilot"
     if(strlen($msg)==0 && _check_double_email($email,'new')){$msg=_Email_used_by_other_request;} //"this email are used in another pilot in a changing request mail"
     if(strlen($msg)==0 && $userdata['user_emailtime'] +($CONF_expire_time)>time()){$msg=sprintf(_Email_canot_change_quickly,$expiretime);} 
     if(strlen($msg)==0 && _update_user_new_mail($email,$actkey)){ 
       strlen($pilotdata['NickName'])>0?$pn=($pilotdata['NickName']):$pn=($pilotdata['FirstName']." " .$pilotdata['LastName']);  
       $email_body=sprintf(_Pilot_confirm_change_email,$CONF['site']['name'], $pn ." " . $userdata['user_new_email'],
       $_SERVER["HTTP_HOST"], $_SERVER['HTTP_HOST'].$PHP_SELF, $actkey);
       print $userdata['user_actkey']."<br>";
       mail($userdata['user_new_email'], "[Leonardo] ".$CONF['site']['name']." -  "._Email_subject_confirm."",utf8_decode($email_body), "From:  $CONF_admin_email");
       $msg.=_Email_sent_with_confirm; //"We send a email for you, where you must confirm the email changing";  
     }
     print "<br><div align='center'><b>$msg</b></div><br>";    
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
    <th height="25" class="thHead" nowrap="nowrap"><?=_ChangingEmailForm?></th>
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
    <font color="#ffffff"><?=_ChangingEmailForm?></font></strong></span></td>
    <td align="right" width="130"><span class="smalltext">&nbsp;</span></td>
  </tr>
  <tr>
    <td colspan="4" bgcolor="#f5f5f5">
    <table border="0" cellpadding="2" cellspacing="1" width="100%">
      <tbody>
      <tr>
        <td class="smalltext" width="100%" colspan="2" align="center"><?=_Email_current;?>: <b><?=$userdata['user_email'];?></b></td>
      </tr>
      <tr>
        <td class="smalltext" width="46%" align="right"><?=_New_email;?></td>
        <td width="54%">:<input name="emtochange" class="loginpassword" value="" type="text"></td>
      </tr>
      <tr>
        <td class="smalltext" align="right"><?=_New_email_confirm;?></td>
        <td>:<input name="emtochange2" class="loginpassword" value="" type="text"></td>
        </tr>
      <tr>
        <td class="smalltext" colspan="2" align="center">
          <input name="changeem" value="<?=_Submit_Change_Data?>" class="submitButton" type="submit"></td>
      </tr>
    </tbody>
    </table>        
  </tr>
</table> 

 <p>&nbsp;</p>
 <div align="center"><span class="alertMsg"><a href="mailto:<?=$adminMail?>" target="_self"><?=_PROBLEMS_HELP?></a></span>
 </div>
</form>
<?}?>
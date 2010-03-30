<?php
/**
 * Modified to work by martin jursa, 25.05.2009
 */

require_once $LeoCodeBase."/CL_mail.php";
openMain(_PASSWORD_RECOVERY_TOOL,0,"");

if ($userID>0) {
	echo "<span class='note'>"._You_are_already_logged_in."</span>";
	closeMain();
	return;
}

if(isset($_GET['rkey'])){

    $rk=trim(addslashes($_GET['rkey']));
	if(strlen($rk)>10){
		$sql="update ".$CONF['userdb']['users_table']." set user_active=1, user_emailtime=0, user_actkey='',  user_password=user_newpasswd where user_actkey='$rk'";
		$db->sql_query($sql);
		$ar=$db->sql_affectedrows();
		if($ar==1){
			$msg=_PwdChanged;
			echo "<br><span class='ok'><b>$msg</b></span><br>";
		} else{
			$msg= _PwdNotChanged ." " . _request_key_not_found;
			echo "<br><span class='alert'><b>$msg</b></span><br>";
		}
	} else{
		$msg= _PwdNotChanged ." ". _request_key_invalid;
		echo "<br><span class='alert'><b>$msg</b></span><br>";
	}
	closeMain();
	return;
}



function generatePassword ($length ) {
	if (!$length ) $length = 6;
	$length +=2;

  // start with a blank password
  $password = "";
  // define possible characters
  $possible = "23456789abcdefghjkmnpqrstvwxyzABCDEFGHIJKLMNPQRSTUVXWYZ";
  // set up a counter
  $i = 0;
  // add random characters to $password until $length is reached
  while ($i < $length) {
    // pick a random character from the possible ones
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
    // we don't want this character if it's already in the password
    if (!strstr($password, $char)) {
      $password .= $char;
      $i++;
    }
  }
  // done!
  return $password;
}

function _search_user($str){  
	global $db,$CONF;
	$sql="select * from ".$CONF['userdb']['users_table']." where username='$str' or user_civlid='$str' or user_email='$str' ";
	$res=$db->sql_query($sql);
	$nr=$db->sql_numrows($res);
	if($nr>1){
		return false;
	}
	return $res;
}

if(isset($_POST['uce'])){
    
	$str=addslashes($_POST['uce']);
	//var_dump(_search_user($str));
	if($res=mysql_fetch_assoc(_search_user($str))) {
		$ltime=time();
		$emailtime=$res['user_emailtime'];
		 // gen a new password with 6 char long;
		 //$emailtime=0;
		if(($emailtime+($CONF['userdb']['edit']['password_change_expire_time'])) < $ltime){
			//  print "$emailtime | $ltime";
			$actkey=md5(uniqid(rand(), true));
			$newpass=generatePassword($CONF['userdb']['edit']['password_minlength']);
			$sql="UPDATE ".$CONF['userdb']['users_table']." set user_emailtime='".time()."', user_newpasswd='".md5($newpass)."',user_actkey='$actkey' where ".$CONF['userdb']['user_id_field']."=".$res['user_id'];
			
			if($db->sql_query($sql)){
				
				$msg=  "<span class='ok'><b>"._Email_new_password."</b></span>";
					  
				$email_body=sprintf(_Password_recovery_email,
									$CONF['site']['name'],
									$res['username'],$_SERVER['HTTP_HOST'],
									$res['username'],$res['user_civlid'],
									$newpass,
									$_SERVER['HTTP_HOST'].$PHP_SELF,
									$actkey
									);		
																						
				LeonardoMail::sendMail("[Leonardo] ".$CONF['site']['name']." - ". _Password_subject_confirm,
						utf8_decode($email_body),
						$res['user_email'],
						addslashes($_POST['name']) );
			
			}
		
		} else{
			$expiretime=date("d/M/Y H:i:s",$emailtime+($CONF['userdb']['edit']['password_change_expire_time']));
			$msg=  "<span class='alert'><b>".sprintf(_impossible_to_gen_new_pass,$expiretime)."</b></span>";
		}
	} else {
		$msg= "<span class='alert'><b>"._informed_user_not_found."</b></span>";
	}
}

?>
<style type="text/css">
<!--
.alertMsg a {
	color: #FF0000;
	font-size: 11px;
}
.smalltext {
	font-size: 90%;
	FONT-SIZE: 11px;
	COLOR: #333333;
	FONT-FAMILY: Verdana, Arial, Helvetica;
}
.tcat {
	background: #80A9EA url('img/bg_login_table.gif') repeat-x top left;
	COLOR: #FFFFFF;
	font-style:normal;
	font-variant:normal;
	font-weight:normal;
	font-size:12px;
	font-family:Verdana, Tahoma
}
.logintext {
	border:1px solid #888888;
	COLOR: #000000;
	FONT-FAMILY: Verdana, Tahoma;
	FONT-SIZE: 11px;
	WIDTH: 150px;
	MARGIN: 0px;
	BACKGROUND: #FFFFFF url('img/icon_user.gif') no-repeat 1px 1px;
	padding-left:18px;
	vertical-align:middle;
	padding-right:2px;
	padding-top:3px;
	padding-bottom:2px;
	background-color:#FFFFFF
}
.loginpassword {
	BACKGROUND-COLOR: #FFFFFF;
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
.submitButton {
	BORDER: 0px solid #FFFFFF;
	BACKGROUND: url('img/bg_submitButton.gif') no-repeat;
	HEIGHT: 21px;
	WIDTH: 150px;
	COLOR: #000000;
	FONT-FAMILY: Verdana, Tahoma;
	FONT-SIZE: 11px;
	MARGIN: 0px;
	padding-top: 3px;
	padding-bottom: 3px;
	ALIGN: center;
	vertical-align:middle;
	text-align:center;
}
.tborder {
	background-color: #FFFFFF;
	color: #000000;
	border: 1px solid #6393DF;
}
-->
</style>

<form  id="loginform" name="loginform" action="" method="post" >
  <table width="70%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">

    <tr>
      <td class="row1" align="justify"><?=$msg ? $msg : _PASSWORD_RECOVERY_TOOL_MESSAGE?></td>
    </tr>
  </table>
  <table width=350 align="center"  cellpadding="4" cellspacing="0" class="tborder">
    <tbody>
      <tr class="tcat">
        <td align="left" width="1"><img src="img/space.gif" height="21" width="1"></td>
        <td align="left" width="1"><img src="img/icon_blockarrow.gif" height="8" width="8"></td>
        <td align="left" valign="middle">&nbsp;<span class="smalltext"><strong><font color="#ffffff">
          <?=_lost_password?>
          </font></strong></span></td>
        <td align="right" width="130"><span class="smalltext">&nbsp;</span></td>
      </tr>
      <tr>
        <td colspan="4" bgcolor="#f5f5f5"><table border="0" cellpadding="2" cellspacing="1" width="100%">
            <tbody>
              <tr>
                <td class="smalltext" width="100%" colspan="2" align="center"><span class="gen">
                  <?=_username_civlid_email;?>
                  </span>:</td>
              </tr>
              <tr>
                <td width="100%" colspan="2"  align="center"><input name="uce" value="" type="text" size="40"></td>
              </tr>
              <tr>
                <td class="smalltext"  colspan="2"  align="center"><input name="recpass" value="<?=_Recover_my_pass?>" class="submitButton" type="submit"></td>
              </tr>
            </tbody>
          </table></td>
      </tr>
  </table>
  <p>&nbsp;</p>
  <div align="center"><span class="alertMsg"><a href="mailto:<?=$CONF_admin_email?>" target="_self">
    <?=_PROBLEMS_HELP?>
    </a></span> </div>
</form>

<?
  closeMain();

?>
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

/**
 * Find the user trying identification by email, username and civl-id
 *
 * @param string $str
 * @param string $msg
 * @return mixed array or false
 */
function _search_user($str, & $msg){
	global $db, $CONF, $pilotsTable;
	$msg='';
	if (is_numeric($str)) {
		$keys=array('civlid', 'username');
	}elseif (strpos($str, '@')!==false) {
		$keys=array('email', 'username');
	}else {
		$keys=array('username');
	}
	$res=false;
	foreach ($keys as $key) {
		switch ($key) {
			case 'username':
				$sql="select u.user_id, u.username, u.user_email, u.user_emailtime, p.CIVL_ID as user_civlid from ".$CONF['userdb']['users_table']." u INNER JOIN $pilotsTable p ON p.pilotID=u.user_id where u.username='".mysql_escape_string($str)."'";
				break;

			case 'email':
				$sql="select u.user_id, u.username, u.user_email, u.user_emailtime, p.CIVL_ID as user_civlid from ".$CONF['userdb']['users_table']." u INNER JOIN $pilotsTable p ON p.pilotID=u.user_id where u.user_email='".mysql_escape_string($str)."'";
				break;

			case 'civlid':
				$sql="select u.user_id, u.username, u.user_email, u.user_emailtime, p.CIVL_ID as user_civlid from ".$CONF['userdb']['users_table']." u INNER JOIN $pilotsTable p ON p.pilotID=u.user_id where p.CIVL_ID=".mysql_escape_string($str);
				break;
		}
		$res=$db->sql_query($sql);
		$nr=$db->sql_numrows($res);
		if ($nr==1) {
			break;
		}elseif ($nr>1) {
			$res=false;
			$msg=_informed_user_found_but_duplicate;
			break;
		}elseif ($nr<1) {
			$res=false;
		}
	}
	$row=false;
	if ($res) {
		$row=$db->sql_fetchrow($res);
	}
	if (!$row && !$msg) {
		$msg=_informed_user_not_found;
	}
	return $row;
}

if(isset($_POST['uce']) && !empty($_POST['uce'])){

	$str=addslashes($_POST['uce']);
	//var_dump(_search_user($str));
	$msg='';
	$row=_search_user($str, $msg);
	if($row) {
		$ltime=time();
		$emailtime=$row['user_emailtime'];
		if (empty($emailtime) || (($emailtime+$CONF['userdb']['edit']['password_change_expire_time']) < $ltime)) {
			//  print "$emailtime | $ltime";
			$actkey=md5(uniqid(rand(), true));
			$newpass=generatePassword($CONF['userdb']['edit']['password_minlength']);
			$sql="UPDATE ".$CONF['userdb']['users_table']." set user_emailtime='".time()."', user_newpasswd='".md5($newpass)."', user_actkey='$actkey' where user_id=".$row['user_id'];
			if($db->sql_query($sql)){
				$msg=_Email_new_password;
				$confirmUrl=$_SERVER['HTTP_HOST'].$PHP_SELF.'?name=leonardo&op=send_password&rkey='.$actkey;
				$email_body=sprintf(_Password_recovery_email,
										$row['username'],
										$CONF_server_short_name,
										$row['username'],
										$row['user_civlid'],
										$newpass,
										$confirmUrl,
										$CONF_server_short_name
									);

				//die($email_body);
				LeonardoMail::sendMail('[Leonardo] - '. _Password_subject_confirm,utf8_decode($email_body),$row['user_email'],'', $CONF_admin_email );
				//LeonardoMail::sendMail('[Leonardo] - '._Pilot_confirm_subscription_subject, utf8_decode($email_body),$_POST['email'], addslashes($_POST['name']), $CONF_admin_email);
			}
		}else{
			$expiretime=date("d/M/Y H:i:s", $emailtime+($CONF['userdb']['edit']['password_change_expire_time']));
			$msg=sprintf(_impossible_to_gen_new_pass, $expiretime);
		}
	}
	if ($msg) {
		$msg= "<span class='alert'><b>".$msg."</b></span>";
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
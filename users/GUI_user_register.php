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


if ($_POST['registerForm']==1) {

	foreach (array("ufname", "ulname", "uemail",  "uname", "upass", "upass2") as $a )
	{
		$$a=$_POST[$a];
	}

	// checking for errors
	if (empty($ufname) OR empty($uemail) OR empty($uname) OR empty($upass) OR empty($upass2)) {
		echo '<br><br>Please fill in all the fields!<br><a href="javascript:history.back(1)">Back</a><br>';
		exit;
	}

	if ($upass != $upass2) {
		echo '<br>The passwords are not the same. Please give them again!<br><a href="javascript:history.back(1)">Back</a><br>';
		exit;
	}

	// [send verification email]
$email_body = "===================================

Leonardo new user

Hi $ufname,

This is a verification email sent from ".$_SERVER['HTTP_HOST']."

To finally create your account, you will need to click on link below to verify your email address:

http://".$_SERVER['SERVER_NAME'].getRelMainFileName().
"&op=users&page=index&act=register&ufname=$ufname&ulname=$ulname&uemail=$uemail&uname=$uname&upass=$upass

Regards,

--------
 Note: This is auto-response. Do not send any email to this email address
--------";

	mail($uemail, "[Leonardo] - Confirmation email", $email_body, "From:  $CONF_admin_email");
?>
<br> 
<br> 
<table align="center" width="50%">  
  <tr> 
    <td><div align="center">
      <p><br> 
          Registration successfully finished !! <br> 
          <br> 
        Confirmation email was sent to: <b><? echo $uemail ?></b></p>
      <p>Please check your email and follow the instructions<br>
          </p>
    </div></td> 
  </tr> 
  <tr> 
    <td class=header>&nbsp;</td> 
  </tr> 
</table> 

<? 

} else if ( isset($_GET['uname']) && isset($_GET['upass']) && isset($_GET['uemail']) ) { // add the user

	$uname=$_GET['uname'];
	$upass=md5($_GET['upass']);
	$uemail=$_GET['uemail'];

	$sql="INSERT into $users_table (username,user_password,user_email) VALUES( '$uname', '$upass', '$uemail' )";
	$register_it = $db->sql_query($sql);	
	
?> 
<br> 
<br> 
<table align="center" width="50%"> 
  <tr> 
    <td><br>      <font class=content>      <center> 
        <b>Email confirmation successfull!</b> 
      </center> 
      <br>      <br>      <table align="center" width="70%"> 
        <tr class=header> 
          <td> <u>Email</u> </td> 
          <td><?=$uemail ?></td> 
        </tr> 
        <tr class=header> 
          <td> <u>Username</u> </td> 
          <td><?=$uname ?></td> 
        </tr> 
      </table> 
      <div align="center"><br> 
        <br> 
        <center> 
        <a href="?op=login">Login</a><br> 
        <br> 
      </div></td> 
  </tr> 
  <tr> 
    <td class=header>&nbsp;</td> 
  </tr> 
</table> 
<?
} else { // show the registration form
?> 
<br> 
<br> 
<table align="center" width="500"> 
  <tr> 
    <td><br>      
      <font class=content> Please fill in all the fields <br>      <br>      <form method="post" action="?op=users&page=index&act=register"> 
        <table align="center" width="70%"> 
          <tr class=header> 
            <td> <u>First Name</u> </td> 
            <td><input type="text" name="ufname"> 
              <font color="ff0000">*</font></td> 
          </tr> 
          <tr class=header> 
            <td> <u>Last Name</u> </td> 
            <td><input type="text" name="ulname">
            <font color="ff0000">*</font> </td> 
          </tr> 
          <tr class=header> 
            <td> <u>Email</u> </td> 
            <td><input type="text" name="uemail"> 
              <font color="ff0000">*</font> </td> 
          </tr> 
          <tr> 
            <td colspan="2"><hr color="a9a9a9"></td> 
          </tr> 
          <tr class=header> 
            <td> <u>Username</u> </td> 
            <td><input type="text" name="uname"> 
              <font color="ff0000">*</font></td> 
          </tr> 
          <tr class=header> 
            <td> <u>Password</u> </td> 
            <td><input type="password" name="upass"> 
              <font color="ff0000">*</font></td> 
          </tr> 
          <tr class=header> 
            <td> <u>Password again</u> </td> 
            <td><input type="password" name="upass2"> 
              <font color="ff0000">*</font> </td> 
          </tr> 
          <tr> 
            <td colspan="2"><br> 
              <p align="right"> 
                <input type="submit" value="Register !"> 
                <input name="registerForm" type="hidden" value="1"> 
                <br> 
            </td> 
          </tr> 
        </table> 
      </form></td> 
  </tr> 
  <tr> 
    <td class=header>&nbsp;</td> 
  </tr> 
</table> 
<? } // else  ?> 

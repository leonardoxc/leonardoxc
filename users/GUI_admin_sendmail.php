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

if ($_POST['sendmailForm']==1) {
	
	$sql= "SELECT * from $users_table WHERE username = '$sd_user'";
	$result = $db->sql_query($sql);
	$sd_f  = $db->sql_fetchrow($result) ;

	$mail_user = "============================

$SiteName

===========================

From: $sd_from
Subject: $sd_subject

---------------------------

Hi $sd_user,

$sd_from send you a email with message:

$sd_message


Regards,

$SiteName Team.";

	// checking for any errors
	if ($sd_f[5] != $sd_user) {
		echo "<br>Please enter correct username!<br><a href=\"javascript:history.back(1)\">Back</a><br>";
		exit;
	}
	
	if (empty($sd_user) || empty($sd_from) || empty($sd_subject) || empty($sd_message)) {
		echo "<br>Please fill all fields!<br><a href=\"javascript:history.back(1)\">Back</a><br>";
		exit;
	}
	
	// sending email
	mail($sd_f[2], "Contact from $SiteName", $mail_user, "From: $sd_from");
?>
 <br> 
<br> 
<table align="center" width="50%" bgcolor="a9a9a9" class=header> 
  <tr> 
    <td><br> 
      <br> 
      <center>
         Email sent to user $sd_user <br> 
        <br> 
        <br> 
        <br> 
        <a href="javascript:history.back(1)"><< Back</a> 
      </center> 
      <br> 
      <br></td> 
  </tr> 
</table> 
<br> 
<br> 

<? 
} else {
?> 
<br> 
<table align="center" width="500"> 
  <tr> 
    <td><br> 
      <br> 
      <font class=content>Send email to the member using this online email sender.<br> 
      <br> 
      <form method="post" action="?op=users&page=sendmail&act=send&type=plain"> 
        <table align="center" width="70%" border="0"> 
          <tr class=header> 
            <td> <b>To:</b> </td> 
            <td><input type="text" name="sd_user" value="$to"></td> 
          </tr> 
          <tr class=header> 
            <td> <b>From:</b> </td> 
            <td><input type="text" name="sd_from" value="<your email here>"></td> 
          </tr> 
          <tr class=header> 
            <td><b>Subject:</b> </td> 
            <td><input type="text" name="sd_subject" value="$subject"> </td> 
          </tr> 
          <tr class=header> 
            <td colspan="2"><b>Message:</b> </td> 
          </tr> 
          <tr> 
            <td colspan="2"><textarea name="sd_message" rows="8" cols="55"></textarea> </td> 
          </tr> 
          <tr> 
            <td colspan="2"><br> 
              <p align="right"> 
                <input type="submit" value="Send email"> 
                <input name="sendmailForm" type="hidden" value="1"> </td> 
          </tr> 
        </table> 
      </form></td> 
  </tr> 
  <tr> 
    <td class=header>&nbsp;</td> 
  </tr> 
</table> 
<? } // end if ?> 

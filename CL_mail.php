<?
//************************************************************************
// Leonardo XC Server, http://www.leonardoxc.net
//
// Copyright (c) 2004-2010 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: CL_mail.php,v 1.5 2010/11/21 14:26:01 manolis Exp $                                                                 
//
//************************************************************************

require_once dirname(__FILE__)."/lib/mail/class.phpmailer.php";

class LeonardoMail{

function sendMail($Subject,$Content,$toEmail,$toName,$fromMail='',$fromName=''){
	//echo " $Subject,$Content,$toEmail,$toName,$fromMail='',$fromName='' <BR>";
	global $CONF,$CONF_admin_email;
	
	if ($fromMail=='') $fromMail=$CONF_admin_email;
	if ($fromName=='') $fromName=$CONF['site']['name'];
	
	if ($CONF['mail']['method']!='smtp') {  // use mail() function	
		mail($toEmail,$Subject,$Content, "From: $fromMail");
	} else { // use an external mail server
		$mail = new PHPMailer(); 
		$mail->CharSet = "UTF-8";
		$mail->IsSMTP();
		$mail->SMTPAuth   = true;
		$mail->Host       = $CONF['mail']['smtp']['host'];      // sets GMAIL as the SMTP server
		if( $CONF['mail']['smtp']['ssl'] ){
			$mail->SMTPSecure = "ssl"; 
		}
		$mail->Port       = $CONF['mail']['smtp']['port'];      // set the SMTP port 
		$mail->Username   = $CONF['mail']['smtp']['username'];  // GMAIL username
		$mail->Password   = $CONF['mail']['smtp']['password'];  // GMAIL password
		$mail->SMTPDebug = 0;
		$mail->IsHTML(false);
		$mail->From     = $fromMail;
		$mail->FromName = $fromName;
		$mail->Subject  =  $Subject." ";
		$mail->Body     =  $Content;
		$mail->AddAddress($toEmail, $toName);
		
		if (!$mail->Send())	{
			return false;
		} else{
			return true;
		}  
	}
} // end of function

	
}

?>
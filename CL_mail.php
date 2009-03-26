<?
//************************************************************************
// Leonardo XC Server, http://leonardo.thenet.gr
//
// Copyright (c) 2004-8 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: CL_mail.php,v 1.2 2009/03/26 15:57:01 manolis Exp $                                                                 
//
//************************************************************************

require_once $LeoCodeBase."/lib/mail/class.phpmailer.php";

class LeonardoMail{

function sendMail($Subject,$Content,$toEmail,$toName,$fromMail='',$fromName=''){
	//echo " $Subject,$Content,$toEmail,$toName,$fromMail='',$fromName='' <BR>";
	global $CONF;
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
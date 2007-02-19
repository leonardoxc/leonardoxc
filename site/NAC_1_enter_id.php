<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" >
<html>
<head>
<title>dhv XC Server Admin Portal</title>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<meta name="author" content="Deutscher Hängegleiterverband (DHV), Gmund, Germany, www.dhv.de">
<meta name="copyright" content="Deutscher Hängegleiterverband (DHV), Gmund, Germany">
<meta name="generator" content="Online DB 4.2.1 Framework www.jursaconsulting.com">
<meta name="robots" content="index,follow">


<link rel="stylesheet" href="http://www.xcfc.de/admin/odbresources/dhv/css/dhvde2_2003.css" type="text/css">
</head>
<body style="margin-left:0px;margin-right:0px;margin-top:0px;margin-bottom:0px;">


<form name="standform" action="" method="POST" target="">


<input type="hidden" name="pposted"  value="1" >
<input type="hidden" name="ticket"  value="68c2ae129b" >


<div style="width:600">
<p>Deine Mitgliedschaft kann nu</p>

    <table cellspacing="0" cellpadding="2" border="0" width="100%" style="margin-top:10px">
      <tr>
        <td class="label" width="200px">DHV Admin Portal Benutzername: </td>
        <td class="data"><input type="text" name="uid"  value="" ></td>
      </tr>
      <tr>
        <td class="label" width="200px">DHV Admin Portal Kennwort: </td>
        <td class="data"><input type="password" name="pwd"  value="" ></td>
      </tr>
    </table>
    <p><br />
</p>
    <br/>
	
	<input type="button" name="okbutton"  value="insert ID"  onclick="
if (!window.opener) {
	alert('Die Seite, von welcher aus dieser Dialog aufgerufen wurde, ist nicht vorhanden.');
}else {
	var callingfield='DHVMGNr';
	if (callingfield=='') {
		alert('Aufrufendes Feld nicht gesetzt (Parameter callingfield).');
	}else {
		window.opener.document.forms[0].elements['<?=$_GET['callingfield']?>'].value='31857';
	}
}
window.close();
" ><input type="button" name="cancelbutton"  value="Abbrechen"  onclick="window.close();" >


<input type="button" name="loginbutton"  value="OK"  onclick="document.standform.submit();" ><input type="button" name="cancelbutton"  value="Abbrechen"  onclick="window.close();" ></p></div></form></td>
</body>
</html>

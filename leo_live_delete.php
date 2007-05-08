<?
	require_once "EXT_config_pre.php";
	require_once "config.php";
 	require_once "EXT_config.php";

	require_once "CL_flightData.php";
	require_once "FN_functions.php";	
	require_once "FN_UTM.php";
	require_once "FN_waypoint.php";	
	require_once "FN_output.php";
	require_once "FN_pilot.php";
	require_once "FN_flight.php";
	setDEBUGfromGET();
?>
<head>
<script language="javascript" src="<?=$moduleRelPath?>/js/DHTML_functions.js"></script>
<script language="javascript" >
function closeWin() {
  top.window.toggleVisible('takeoffAddID','takeoffAddPos',14,-20,0,0);
}
</script>
<style type="text/css">
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
.tcat { background: #80A9EA url('{IMG_PATH}bg_login_table.gif') repeat-x top left;  COLOR: #FFFFFF; 	
font-style:normal; font-variant:normal; font-weight:normal; font-size:12px; font-family:Verdana, Tahoma
}
.logintext {
	border:1px solid #888888; COLOR: #000000;
	FONT-FAMILY: Verdana, Tahoma;
	FONT-SIZE: 11px;
	WIDTH: 100px;
	MARGIN: 0px;
	BACKGROUND: #FFFFFF ;
	padding-left:3px; vertical-align:middle; padding-right:2px; padding-top:3px; padding-bottom:2px; background-color:#FFFFFF
}
.loginpassword {	BACKGROUND-COLOR: #FFFFFF;
	COLOR: #000000;
	FONT-FAMILY: Verdana, Tahoma;
	FONT-SIZE: 11px;
	BORDER-STYLE: solid;
	BORDER-COLOR: #888888;
	BORDER-WIDTH: 1px;
	WIDTH: 100px;
	PADDING: 3px 2px 2px 2px;
	MARGIN: 0px;
	VERTICAL-ALIGN: middle;
}

.submitButton {
BORDER: 1px solid #FFFFFF; 
HEIGHT: 21px; WIDTH: 230px; COLOR: #000000; FONT-FAMILY: Verdana, Tahoma; FONT-SIZE: 11px;
MARGIN: 0px; padding-top: 3px; padding-bottom: 3px; ALIGN: center; vertical-align:middle;
text-align:center;
}
.tborder {	background-color: #FFFFFF; 	color: #000000; border: 1px solid #6393DF; }

body, form{ margin:0; padding:0}
.smalltext1 {	font-size: 90%; FONT-SIZE: 11px;
    COLOR: #333333; 
    FONT-FAMILY: Verdana, Arial, Helvetica;
}
.smalltext2 {	font-size: 90%; FONT-SIZE: 11px;
    COLOR: #333333; 
    FONT-FAMILY: Verdana, Arial, Helvetica;
}
.smalltext3 {	font-size: 90%; FONT-SIZE: 11px;
    COLOR: #333333; 
    FONT-FAMILY: Verdana, Arial, Helvetica;
}
.smalltext4 {	font-size: 90%; FONT-SIZE: 11px;
    COLOR: #333333; 
    FONT-FAMILY: Verdana, Arial, Helvetica;
}
.submitButton1 {BORDER: 1px solid #FFFFFF; 
HEIGHT: 21px; WIDTH: 150px; COLOR: #000000; FONT-FAMILY: Verdana, Tahoma; FONT-SIZE: 11px;
MARGIN: 0px; padding-top: 3px; padding-bottom: 3px; ALIGN: center; vertical-align:middle;
text-align:center;
}
.smalltext5 {	font-size: 90%; FONT-SIZE: 11px;
    COLOR: #333333; 
    FONT-FAMILY: Verdana, Arial, Helvetica;
}
-->
</style>
</head> 
<body >
<?
	function exitPage($msg){
		global $moduleRelPath,$PREFS;
?>
<table width="320" height=100% align="center"  cellpadding="0" cellspacing="0" class="tborder">
   <tbody><tr class="tcat">
	<td align="left" width="1"><img src="{IMG_PATH}space.gif" height="21" width="1"></td>
	<td align="left" width="11">&nbsp;</td>
	<td width=270 align="left" valign="middle">&nbsp;<span class="smalltext"><strong><font color="#ffffff">Delete track from this list</font></strong></span></td>
	<td align="right" width="36"><div align=right class="smalltext"><a href='#' onClick="closeWin();"><img src='<? echo $moduleRelPath."/templates/".$PREFS->themeName ?>/img/exit.png' border=0></a></div></td>
  </tr>
  <tr>
	<td colspan="4" bgcolor="#f5f5f5" height="200"><?=$msg?>
</td></tr></tbody></table>
<?
	exit;
}


if ($_POST['formSubmit']==1) {

			  
		// get some basic info
		$username=$_POST['username'];
		$port=$_POST['port'];

		$trackpass	=$_POST['trackpass'];
		$glider		=$_POST['glider'];
		$comments	=$_POST['comments'];
		$glidertype	=$_POST['type']+0;
		$linkURL	=$_POST["url"];

		$user=$_POST['user'];
		$pass =$_POST["pass"];
		
		$query="SELECT * FROM  leonardo_live_data WHERE username='$username' AND port='$port' ORDER BY tm ASC LIMIT 1";
		// echo $query;
		$res= $db->sql_query($query);
		if($res <= 0){
			 echo("<H3> Error in query! $query </H3>\n");
			 return 0;
		}
		

		$row = mysql_fetch_assoc($res);
		if ($row) {
			if ($row['passwd']!=$trackpass) {
				exitPage("You haven't provided the correct password for the tracklog");
			}

			$query2="DELETE FROM  leonardo_live_data WHERE username='$username' AND port='$port' ";
			// echo $query;
			$res2= $db->sql_query($query2);
		
			if ($res2) $msg="Flight was deleted from Live server";
			else $msg="Error in deleting flight";
		}	else {
			exitPage("Cannot get DATA for user $username");		
		}
		exitPage($msg);


} else {		
	
?>
<form  id="loginform" name="loginform" method="post" >
<table width="450" height=100% align="center"  cellpadding="0" cellspacing="0" class="tborder">
   <tbody><tr class="tcat">
	<td align="left" width="1"><img src="{IMG_PATH}space.gif" height="21" width="1"></td>
	<td align="left" width="11">&nbsp;</td>
	<td width=202 align="left" valign="middle">&nbsp;&nbsp;<span class="smalltext5"><strong><font color="#ffffff">Delete track from this list</font></strong></span></td>
	<td align="right" width="36"><div align=right class="smalltext"><a href='#' onClick="closeWin();"><img src='<? echo $moduleRelPath."/templates/".$PREFS->themeName ?>/img/exit.png' border=0></a></div></td>
  </tr>
  <tr>
	<td colspan="4" bgcolor="#f5f5f5"><table border="0" cellpadding="2" cellspacing="1" width="100%">
	  <tbody>
	    <tr>
	      <td class="smalltext"><div align="left">Password of the tracklog:<span class="smalltext1">
	        <input name="trackpass" type="text" class="logintext" id="trackpass" value="" />
	        </span></div></td>
	      </tr>
	  <tr>
	    <td class="smalltext">
	      <div align="left">
	        <input name=formSubmit value=1 type=hidden />
	        <input name="username" value="<?=$_GET['user']?>" type=hidden />
	        <input name="port" value="<?=$_GET['port']+0?>" type=hidden />
	        <input name="submitButton" value="Delete tracklog from Live server" class="submitButton1" type="submit" />
	        </div></td>
	    </tr>
	</tbody></table>		
      <div align="center">
        <script language="Javascript">
			//document.loginform.username.focus();
	    </script>
	    </div></td>
  </tr>
</table> 
</form>
</body>
<? } ?>
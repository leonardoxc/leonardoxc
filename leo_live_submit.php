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

	
if ($_POST['formSubmit']==1) {

$servers=array(
  	          99=>"pgforum.home",
   	          98=>"pgforum.thenet.gr",
	          1=>"sky.gr",
	          2=>"paraglidingforum.com",
	          3=>"LIGA PORTUGUESA DE VOO LIVRE ",
	          4=>"XC Brasil"
			 );
			  
		// get some basic info
		$username=$_POST['username'];
		$port=$_POST['port'];
		$query="SELECT * FROM  leonardo_live_data WHERE username='$username' AND port='$port' ORDER BY tm ASC LIMIT 1";
		// echo $query;
		$res= $db->sql_query($query);
		if($res <= 0){
			 echo("<H3> Error in query! $query </H3>\n");
			 return 0;
		}
		
		$user=$_POST['user'];
		$pass =$_POST["pass"];


		$serverURL="http://pgforum.thenet.gr/modules/leonardo/op.php";
		$serverURL="http://".($servers[$_POST['serverID']+0])."/modules/leonardo/op.php";
		// echo 		$pass;
		if ( $row = mysql_fetch_assoc($res) ) {
			$trackURL='http://'.$_SERVER['SERVER_NAME'].'/modules/leonardo/leo_live.php';
			$tm=$row["tm"];
		

			$igcURL=htmlspecialchars( "$trackURL?op=igc&user=$username&port=$port");
			$igcFilename= htmlspecialchars(date("Y-m-d H-i-s",$tm).".igc" );
	
			$private=0;
			$cat=-1;
			$linkURL=0;
			$comments=0;
			$glider=0;
			submitFlightToServer($serverURL, $user, $pass, $igcURL, $igcFilename, $private, $cat, $linkURL, $comments, $glider);
		}	else {
			echo "Cannot get DATA for user $username<br>";		
		}
		exit;
} else {		
	
?>

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
	WIDTH: 150px;
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
	WIDTH: 150px;
	PADDING: 3px 2px 2px 2px;
	MARGIN: 0px;
	VERTICAL-ALIGN: middle;
}

.submitButton {
BORDER: 1px solid #FFFFFF; 
HEIGHT: 21px; WIDTH: 150px; COLOR: #000000; FONT-FAMILY: Verdana, Tahoma; FONT-SIZE: 11px;
MARGIN: 0px; padding-top: 3px; padding-bottom: 3px; ALIGN: center; vertical-align:middle;
text-align:center;
}
.tborder {	background-color: #FFFFFF; 	color: #000000; border: 1px solid #6393DF; }

body, form{ margin:0; padding:0}
-->
</style>

 
<form  id="loginform" name="loginform" method="post" >
<table width=250 align="center"  cellpadding="0" cellspacing="0" class="tborder">
   <tbody><tr class="tcat">
	<td align="left" width="1"><img src="{IMG_PATH}space.gif" height="21" width="1"></td>
	<td align="left" width="11">&nbsp;</td>
	<td width="242" align="left" valign="middle">&nbsp;<span class="smalltext"><strong><font color="#ffffff">Submit track to Leonardo at </font></strong></span></td>
	<td align="right" width="36"><span class="smalltext">&nbsp;</span></td>
  </tr>
  <tr>
	<td colspan="4" bgcolor="#f5f5f5"><table border="0" cellpadding="2" cellspacing="1" width="100%">
	  <tbody>
	    <tr>
	      <td colspan="2" class="smalltext"><select name="serverID">
  	          <option value="99">pgforum.home</option>
   	          <option value="98">pgforum.thenet.gr</option>
	          <option value="1">sky.gr</option>
	          <option value="2">paraglidingforum.com</option>
	          <option value="3">LIGA PORTUGUESA DE VOO LIVRE </option>
	          <option value="4">XC Brasil</option>
	          </select>
	        </td>
	      </tr>
	    <tr>
		<td class="smalltext" width="46%"><span class="gen">Username</span>:</td>
		<td width="54%"><input name="user" class="logintext" value="" type="text"></td>
	  </tr>
	  <tr>
		<td class="smalltext"><span class="gen">Password</span>:</td>
		<td><input name="pass" class="loginpassword" value="" type="password"></td>
		</tr>

	  <tr>
		<td class="smalltext">&nbsp;</td>
		<td class="smalltext"><div align="right">
			<input name=formSubmit value=1 type=hidden />
			<input name=username value="<?=$_GET['user']?>" type=hidden />
			<input name=port value="<?=$_GET['port']+0?>" type=hidden />
		  <input name="login" value="Submit" class="submitButton" type="submit">
		  </div></td>
	  </tr>
	</tbody></table>		
      <div align="center">
        <script language="Javascript">
			document.loginform.username.focus();
	    </script>
	    </div></td>
  </tr>
</table> 
</form>
<? } ?>
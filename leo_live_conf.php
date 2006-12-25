<style type="text/css">
<!--
.style3 {font-size: 12px}
-->
</style>
<p><a href="leo_live_list.php"><strong>RETURN TO LIVE TRACKS </strong></a><br>
</p>
<p><strong>STEP 1)</strong> Get and install <strong>gpspilot</strong> from <a href="http://www.gpspilot.biz" target="_blank"><strong>gpspilot.biz</strong></a> </p>
<p><strong>STEP 2)</strong> Fill in the dialog below to create your custom Config File </p>
<form name="form1" method="post" action="">
  <table width="600" border="0" cellspacing="0" cellpadding="3">
    <tr>
      <td width="278">Your Leonardo username</td>
      <td width="310"><input name="username" type="text" id="username" value="<?=$_POST['username']?>"></td>
    </tr>
    <tr>
      <td>Your Leonardo password</td>
      <td><input name="passwd" type="text" id="passwd" value="<?=$_POST['passwd']?>"></td>
    </tr>
    <tr>
      <td>Tracking Interval in secs<br>
        <span class="style3"><strong>GPRS costs:</strong> each gps position
        send<br> 
        consumes about 180 bytes </span></td>
      <td><input name="interval" type="text" id="interval" size="5" maxlength="3" value="<?=$_POST['interval']?>"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Create  my config file">
      <input type="hidden" name="formPosted" value="1"></td>
    </tr>
  </table>
</form>

<? 
if ($_POST['formPosted']==1) { // create config
	$cfgFilename="ConfigGeneral.xml";
	$user=$_POST['username'];
	$pass=$_POST['passwd'];
	$interval=$_POST['interval']+0;

	$errMsg="";
	if (!$user) $errMsg.="Not Valid username<BR>";
	if (!$pass) $errMsg.="Not Valid password<BR>";
	if ($interval<5 || $interval>300) $errMsg.="Not Valid time interval : use 5-300 secs<BR>";

	if ($errMsg) { 
?>
	<hr>
	<b>ERROR: </b><?=$errMsg?>
	<hr>
<?
	} else {

	$fl=file_get_contents(dirname(__FILE__)."/ConfigGeneral.tpl.xml");
	$fl=str_replace("__001__",$user,$fl);
	$fl=str_replace("__002__",$pass,$fl);
	$fl=str_replace("__003__",$interval,$fl);


	if (!$handle = fopen($cfgFilename, 'w')) {
		 echo "Cannot open file ($cfgFilename)";
		 exit;
	}
	if (fwrite($handle, $fl) === FALSE) {
		echo "Cannot write to file ($cfgFilename)";
		exit;
	}
	fclose($handle);
?>
	<hr>
	<b>Your config file has been created: </b><a href='ConfigGeneral.xml'>Get it here</a> (right click -> Save as...)
	<hr>
<?
	}
}
?>
<p><strong>STEP 3)</strong></p>
<ul>
  <li> Copy this file to 
    
    
    e:\others\Pilot\Config\<strong>ConfigGeneral.xml</strong></li>
  <li>Get <a href="live/leonardo.zip">Leonardo.zip</a> unzip it and put the folder &quot;leonardo&quot; in e:\others\Pilot\Config\</li>
</ul>
<p>Now each time you run &quot;<strong>Pilot</strong>&quot; from your smart phone
  your gps position<br> 
  will be send to <strong>LeoLive</strong> at the intervals that you have specified.</p>
<p>&nbsp;</p>
<p><strong>Best and tried sequence :</strong></p>
<p>1) Enable bluetooth on the mobile</p>
<p>2) Open GPS and let it aquire singals</p>
<p>3) Run &quot;pilot&quot; and select &quot;agree&quot; on the copyright message</p>
<p>4) Wait until you are presented with the  selection of GPRS connection to use. Select the correct one</p>
<p>5) if you plan not to use &quot;pilot&quot; for navigation, press the &quot;Red&quot; button to put &quot;pilot&quot; into the background (saves battery) </p>
<p>6) dont forget to close &quot;pilot&quot; after the flight in order to avoid extra GPRS costs. </p>
<p></p>
<p><strong>Common errors/mistakes</strong></p>
<p>1) Forget to enable bluetooth <strong>before</strong> running &quot;pilot&quot;. In order to be 100% sure, reboot the phone. This may not be nessacary<br />
for your phone. Some phones/gps combos need it.</p>
<p>2) You dont wait till the &quot;GPRS selection&quot; and put the phone in your pocket. The &quot;selection&quot; will timeout and no data will be transmitted. </p>
<p></p>
<p><strong>Problems in the field </strong></p>
<p>1) All your online friends callling you on the phone while trying to launch in nil wind and asking you why is it taking you so long to takeoff !!! </p>
<p> </p>
<p><strong>NOTE:</strong></p>
<p><strong> ******** Important ******** </strong>Whenever you run &quot;pilot&quot; it erases your incoming SMS messages. <br />
Please copy important SMS to other folder before runing </p>
<p>&nbsp;</p>
<p><a href="leo_live_list.php"><strong>RETURN TO LIVE TRACKS </strong></a></p>

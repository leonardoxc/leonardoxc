<? 
  error_reporting(E_ALL ^ E_NOTICE);
  ini_set('display_errors', 'on');

	$dirs2Check=array(dirname(__FILE__),dirname(__FILE__)."/flights", dirname(__FILE__)."/site",
						dirname(__FILE__)."/server/tmpFiles",dirname(__FILE__)."/maps");

	$allOK=1;
	// echo "Checking that dirs are writable<br>";
	foreach ($dirs2Check as $dirName) {
		
		if (!is_writable($dirName)) {			
			echo "Dir: $dirName  ->";
			echo "is not writeable (will try to fix it)<br>";
			chmodDir($dirName );
			if (is_writable($dirName)) {
				echo "Fixed OK<br>";
			}else {
				$allOK=0;			
				echo "Failed, please fix it manually by issuing the following command from the shell:<br>";
				echo "<pre>chmod -R a+rwx $dirName</pre><br>";
			}
		}else {
			// echo "OK<br>";
		}
	}

	$execFiles=array(dirname(__FILE__)."/server/olc",dirname(__FILE__)."/server/olc.exe");
	foreach ($execFiles as  $filename) {
		if (!setExecMode($filename)) {
			echo "File: $filename ->";
			echo "needs to be executable - please fix it manually by issuing the following command from the shell<br>";
			echo "<pre>chmod a+x $filename</pre><br>";
		}
	}



	if (!$allOK) {
		echo "<b> PROBLEM in permissions, fix them and rerun the install</b><br>";
		exit;
	}

    if (!$_POST['install_step']) {
?>

<form name="form1" method="post" action="">
  <table width="500" border="0" cellspacing="0" cellpadding="3">
    <tr>
      <td colspan="2" bgcolor="#D8E4E9"><div align="center">
        <p><strong>Leonardo Installation <br>
        </strong></p>
      </div></td>
    </tr>
    <tr>
      <td width="170">Installation Type </td>
      <td width="330"><select name="installType">
        <option value="1" selected>phpNuke</option>
        <option value="2">phpBB</option>
      </select></td>
    </tr>
    <tr>
      <td>Administrator email </td>
      <td><input type="text" name="adminEmail"></td>
    </tr>
    <tr>
      <td><p>Create Tables <br>
        (yes if this is the first run) </p>      </td>
      <td><input name="doDB" type="checkbox" id="doDB" value="1" checked></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Proceed to installation">
      <input type="hidden" name="install_step" value="1"></td>
    </tr>
  </table>
</form>

<? } else {

	$doDB=$_POST['doDB']+0;
	$adminEmail=$_POST['adminEmail'];
	$installType=$_POST['installType']+0;
	$opMode=$installType;

 	require_once dirname(__FILE__)."/EXT_config_pre.php";
	require_once dirname(__FILE__)."/config.php";
 	require_once dirname(__FILE__)."/EXT_config.php";

	$filesDir=dirname(__FILE__)."/doc/install";
	$tablesFile=$filesDir."/sql/leonardo.sql";
	$waypointsFile=$filesDir."/sql/waypoints.sql";

	echo "<b>Starting Installation</b><br><br>";

	if ($doDB){
		echo "Creating tables<br>";
		$tablesLines=file($tablesFile);
		$sqlLine="";
		foreach($tablesLines as $line ) {
			$line=trim($line);
			if ($line!="###") {
				$sqlLine.=trim($line);
			} else { // execute the sql 
				$sqlLine= str_replace("leonardo_", $CONF_tables_prefix."_",$sqlLine);
				$res= $db->sql_query($sqlLine);
				if($res <= 0){   
				  echo("<H3> Error in creating tables query: $sqlLine </H3>\n");
				  continue;
				}
				$sqlLine="";
			}
		}
	
		echo "Importing waypoints<br>";
		$tablesLines=file($waypointsFile);
		$sqlLine="";
		foreach($tablesLines as $line ) {
			$line=trim($line);
			if ($line) {
				$line= str_replace("leonardo_", $CONF_tables_prefix."_",$line);			
				$res= $db->sql_query($line);
				if($res <= 0){   
				  echo("<H3> Error in creating tables query: $line</H3>\n");
				  continue;
				}
			}
		}
	}

	$adminEmail=trim(stripslashes($adminEmail));
	$CONF_isMasterServer=0;
	
	$op_url=$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
	$op_url=substr($op_url,0,-11)."op.php";
	
	$url_base=$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
	$url_base=substr($url_base,0,-12);

	if ($opMode==1 || $opMode==2 ) $CONF_mainfile="modules.php";
	else  $CONF_mainfile="index.php";
	
	// detect if the installation in not on the root
	$baseInstallationPath="";
	$parts=explode("/",$_SERVER['REQUEST_URI']);
	// ie /modules/leonardo/install.php
	//		0        1         2
	$partsNum=count($parts);	
	$baseInstallationPath="/";
	if (
		for($i=0;$i<$partsNum-3;$i++)  {					  
			   $baseInstallationPath.=$parts[$i]."/";	
		}
	}	
	$url=$_SERVER['SERVER_NAME'].$baseInstallationPath."modules.php?name=".$parts[$partsNum-2];
	 
	 
	$CONF_SitePassword=md5($op_url.rand(1,9999999).time());

	write2File(dirname(__FILE__)."/site/config_op_mode.php",'<? $opMode='.$installType.'; $CONF_isMasterServer='.$CONF_isMasterServer.'; ?>');
	write2File(dirname(__FILE__)."/site/config_admin.php",'<? $CONF_admin_email="'.$adminEmail.'"; $CONF_SitePassword="'.$CONF_SitePassword.'"; ?>');
 
	$serverURL="http://www.paraglidingforum.com/modules/leonardo/op.php";
	require_once dirname(__FILE__)."/lib/xml_rpc/IXR_Library.inc.php";
	$client = new IXR_Client($serverURL);
	// $client->debug=true;

	if ( ! $client->query('server.registerSlave',
		$opMode, $leonardo_version, $url ,	$url_base, $op_url, $adminEmail, $CONF_SitePassword ) ) {
		echo 'Register server: Error '.$client->getErrorCode()." -> ".$client->getErrorMessage();
		return $client->getErrorCode();
	} else {		
		echo 'RPC-XML interface  OK<br>';
	}

/*	require_once dirname(__FILE__)."/soap/nusoap.php";
	$soapclient = new soapclient('http://www.paraglidingforum.com/modules/leonardo/soap/op.php');		
	if($err = $soapclient->getError()){
		echo "SOAP init error<br>";
	} else {
		$return_val =$soapclient->call(	'registerServer',array($installType,$op_url,$adminEmail,$CONF_SitePassword)  );
		if($err = $soapclient->getError()) echo "SOAP Online error: $err<br>";
		else echo "SOAP interface OK<br>";
	}
*/
	// Debug for SOAP
	//echo 'Request: <xmp>'.$soapclient->request.'</xmp>';
	//echo 'Response: <xmp>'.$soapclient->response.'</xmp>';
	//echo 'Debug log: <pre>'.$soapclient->debug_str.'</pre>';

	if ($opMode==1) { // phpNuke
		findAdminUsers(2);
?>
	<p><strong>You must preform this step manually before running leonardo</strong></p>
	<p>	Activate the leonardo module from the phpNuke administration panel</p>
<?
	
	} else 	if ($opMode==2) { // phpbb2
		copy($filesDir."/phpbb2Files/mainfile.php",dirname(__FILE__)."/../../mainfile.php");
		if ( ! is_file(dirname(__FILE__)."/../../mainfile.php") ) {
			echo "<BR>Copy of mainfile.php failed:<br>
				 Please copy this file manualy from the doc/install/phpbb2Files/mainfile.php
				 into the roor dir of your phpbb installation<BR>";
		}
		copy($filesDir."/phpbb2Files/modules.php",dirname(__FILE__)."/../../modules.php");
		if ( ! is_file(dirname(__FILE__)."/../../modules.php") ) {
			echo "<BR>Copy of modules.php failed:<br>
				 Please copy this file manualy from the doc/install/phpbb2Files/modules.php
				 into the roor dir of your phpbb installation<BR>";
		}

		findAdminUsers(1);
?>
<hr>
	<p><strong>You must preform this step manually before running leonardo</strong></p>
	<ul>
	  <li> Open the file includes/constants.php in your phpBB directory</li>
	  <li> Find 
		        define('PAGE_GROUPCP', -11);</li>
	  <li>After that add 
		          define('PAGE_LEONARDO', -1045);</li>
	  <li>Save the File</li>    
	</ul>
	    <?
	}

	$url="http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/modules.php?name=".$module_name;
?>

	<hr>
<p><strong>The installation is complete. 
  </strong><br>
<p> <a href='<?=$url?>'>The main URL of Leonardo</a></p>
<p> <a href='<?=$url?>&op=list_flights&sortOrder=DATE&year=0&month=0&pilotID=0&takeoffID=0'>To show all flights:</a></p>
<p> <a href='<?=$url?>&lng=french'>To start in (for example french)</a></p>

<p>have fun </p>
<p>&nbsp;</p>
<p> 
  <?
} // end main if

function chmodDir($dir){
 $current_dir = opendir($dir);
 while($entryname = readdir($current_dir)){
    if(is_dir("$dir/$entryname") and ($entryname != "." and $entryname!="..")){		
	  //	echo "${dir}/${entryname}#<br>";
		@chmod("${dir}/${entryname}",0777);       
		chmodDir("${dir}/${entryname}");
       
    }elseif($entryname != "." and $entryname!=".."){
	  // echo "${dir}/${entryname}@<br>";
      @chmod("${dir}/${entryname}",0777);
    }
 }
 @chmod($dir,0777);       
 closedir($current_dir);
}


function write2File($filename,$str) {
	   if (!$handle = fopen($filename, 'w')) { 
			print "Cannot open file $filename"; 
			exit; 
	   } 
	   if (!fwrite($handle, $str))  { 
		   print "Cannot write to file $filename"; 
		   exit; 
	   } 		
	   fclose($handle); 

}


function findAdminUsers($admLvl) {
		global $prefix,$db;

		$sql="select username, user_id FROM ".$prefix."_users where user_level=$admLvl";
		$res= $db->sql_query($sql);
		if($res <= 0){   
		  echo("<H3> Error in getting phpbb admins query: $sql</H3>\n");
		  continue;
		}
		echo "Will now try to find admin users: ";
		while ($row = $db->sql_fetchrow($res)) { 
			echo $row['username']." (".$row['user_id'].") ";
			$admStr.=$row['user_id'].",";
		}
		write2File(dirname(__FILE__)."/config_admin_users.php",'<? $admin_users=array('.substr($admStr,0,-1).'); ?>');
}


function setExecMode($filename) {
	if ( @chmod($filename,0777) ) return true;
	$mode=fileperms($filename);
	if ($mode & 00001) return true;
	return false;
}
?>
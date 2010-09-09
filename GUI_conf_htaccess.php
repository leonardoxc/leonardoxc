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
// $Id: GUI_conf_htaccess.php,v 1.17 2010/09/09 12:46:40 manolis Exp $                                                                 
//
//************************************************************************

 	if ( !L_auth::isAdmin($userID) ) { echo "<span class='alert'>go away</span>"; return; }
	
?> 

<script language="javascript">

function writeHtaccessFile(){
	$("#writeFile").val('1');
	//$("#confForm").submit();
	
	//document.confForm.writeFile=1;
	document.confForm.submit();
	return false;
}

function deleteHtaccessFile(){
	$("#writeFile").val('-1');
	//$("#confForm").submit();
	//document.confForm.writeFile='-1';
	document.confForm.submit();
	return false;
}

</script>

<h3> SEO URLS - uses mod_rewrite of apache </h3>
<?
if ($_POST['baseUrl']) {
	$baseUrl= $_POST['baseUrl'];
	$basePath=$_POST['basePath'];
	$virtPath=$_POST['virtPath'];
} else {
	$baseUrl= CONF_MODULE_ARG; // '/modules.php?name=leonardo';
	$basePath='/modules/leonardo';
	$virtPath=$CONF['links']['baseURL'];
}

$virtPath2='';

$str="
#
RewriteEngine On
RewriteBase ".$virtPath."

# various operations on a flight
RewriteRule ^".$virtPath2."flight/(\d*)/kml/(.*)$ $basePath/download.php?type=kml_trk&flightID=$1&$2 [L,NC]
RewriteRule ^".$virtPath2."flight/(\d*)/igc/(.*)$ $basePath/download.php?type=igc&flightID=$1&$2 [L,NC]
RewriteRule ^".$virtPath2."flight/(\d*)(.*)$ $baseUrl&op=show_flight&flightID=$1$2 [L,NC]

# various operations on a takeoff
RewriteRule ^".$virtPath2."takeoff/(\d*)/kml/?$ $basePath/download.php?type=kml_wpt&wptID=$1 [L,NC]
RewriteRule ^".$virtPath2."takeoff/(\d*)/?(.*)$ $baseUrl&op=show_waypoint&waypointIDview=$1$2 [L,NC]

# various operations on a pilot
RewriteRule ^".$virtPath2."pilot/([\d_]*)/stats/?(.*)$   $baseUrl&op=pilot_profile_stats&pilotIDview=$1$2 [L,NC]
RewriteRule ^".$virtPath2."pilot/([\d_]*)/flights/?(.*)$ $baseUrl&op=list_flights&pilotIDview=$1$2   [L,NC]
RewriteRule ^".$virtPath2."pilot/([\d_]*)/?(.*)$ $baseUrl&op=pilot_profile&pilotIDview=$1$2  [L,NC]

# all 'list' ops that are /opname/countryCode/date/....
RewriteRule ^".$virtPath2."tracks/(.*)/(.*)/(.*)$ $baseUrl&op=list_flights&country=$1&l_date=$2&leoSeo=$3 [L,NC]
RewriteRule ^".$virtPath2."ge/(.*)$     $basePath/download.php?type=explore_ge&leoSeo=$1 [L,NC]
RewriteRule ^".$virtPath2."pilots/(.*)/(.*)/(.*)$  $baseUrl&op=list_pilots&country=$1&l_date=$2&leoSeo=$3 [L,NC]
RewriteRule ^".$virtPath2."league/(.*)/(.*)/(.*)$  $baseUrl&op=competition&country=$1&l_date=$2&leoSeo=$3 [L,NC]
RewriteRule ^".$virtPath2."takeoffs/(.*)/(.*)/(.*)$  $baseUrl&op=list_takeoffs&country=$1&l_date=$2&leoSeo=$3 [L,NC]

RewriteRule ^".$virtPath2."ranks/(\d*)\.(\d*)/(.*)/(.*)$  $baseUrl&op=comp&rank=$1&subrank=$2&l_date=$3&leoSeo=$4 [L,NC]


RewriteRule ^".$virtPath2."page/(.*)$ $baseUrl&op=$1 [L,NC]

RewriteRule ^".$virtPath2."&(.*)$ $baseUrl&$1 [L,NC]

# RewriteRule ^".$virtPath2."?[^.]*$ $virtPath/tracks/world/%{TIME_YEAR}/ [R,NC]
RewriteRule ^".$virtPath2."/?$ tracks/world/%{TIME_YEAR}/ [N,NC]

RewriteRule ^".$virtPath2."(.*)$ $basePath/$1 [L,NC]
";



if ($_POST['htaccessFile']) {
	$htaccessFile= stripslashes($_POST['htaccessFile']);	
} else {
	$htaccessFileName=$CONF['os']=='linux'?'.htaccess':'htaccess.txt';
	$htaccessFile=get_absolute_path(dirname(__FILE__).'/../..'.$virtPath).'/'.$htaccessFileName;
}	


$htaccessFileParts=split('/',$htaccessFile);
array_pop($htaccessFileParts);

$htaccessFiledir=implode('/',$htaccessFileParts);
if ($htaccessFile{0}=='/') $htaccessFiledir='/'.$htaccessFiledir;

$mod_conf_File=dirname(__FILE__).'/site/config_mod_rewrite.php';
if ($_POST['writeFile']==1) {
	$conf_str='<?
	$CONF[\'links\'][\'type\']=3;
	$CONF[\'links\'][\'baseURL\']=\''.$virtPath.'\';
?>';

	if (writeFile($mod_conf_File,$conf_str) )
		echo "<span class='ok'>config_mod_rewrite.php updated</span>";
	else 
		echo "<span class='alert'>PROBLEM in updating config_mod_rewrite.php</span>";

	if (!is_dir($htaccessFiledir) ) {	
		echo "<span class='note'>Creating folder $htaccessFiledir</span>";
		makeDir($htaccessFiledir);
	}
	
	if (writeFile($htaccessFile,$str) )
		echo "<span class='ok'>htaccess file written</span>";
	else 
		echo "<span class='alert'>PROBLEM In writing htaccess file </span>";
		
	// echo "<script lang='javascript'>window.location=''	< /script>";
	echo "<span class='info'><a href='javascript:window.location=\"\";'>Click here to reload</a></span>";
	
} else if ($_POST['writeFile']==-1) {
	$conf_str='<?
	$CONF[\'links\'][\'type\']=1;
	$CONF[\'links\'][\'baseURL\']=\''.$virtPath.'\';
?>';

	if (writeFile($mod_conf_File,$conf_str) )
		echo "<span class='ok'>config_mod_rewrite.php updated</span>";
	else 
		echo "<span class='alert'>PROBLEM in updating config_mod_rewrite.php</span>";


	if (unlink($htaccessFile) )
		echo "<span class='ok'>htaccess file DELETED</span>";
	else 
		echo "<span class='alert'>PROBLEM In deleting htaccess file </span>";
		
	echo "<span class='info'><a href='javascript:window.location=\"\"';'>Click here to reload</a></span>";
}

// re-read configuration
@include $mod_conf_File;

?>

<span class='note'>
 SEO URLS are currently <strong><?=($CONF['links']['type']==3?"ON":'OFF') ?></strong>
</span>
 <hr />
<BR />
<FORM method="post" id='confForm' name='confForm'  >
  <table width="100%" border="0" cellpadding="6">
  <tr>
    <td valign="top" bgcolor="#EFF1E4"><p>Use the auto - detected values to prepare the htaccess file that will enable SEO URLS in Leonardo</p>
      </td>
    <td valign="top" bgcolor="#DCE2E4">
    
Copy and paste this configuration to the htaccess file located on the root directory of your installattion (forum/cms/ etc..)

<br />
or press the button below to write the file automatically.</td>
  </tr>
  <tr>
    <td bgcolor="#F8F9F2">

		File & params of running Leonardo<br />
		 <input type="text"  value='<?=$baseUrl?>' name ='baseUrl'  size="50"/>
		 <br />
		The path to Leonardo files<br />
		<input type="text"  value='<?=$basePath?>' name ='basePath' size="50"/>
		<br />
		The virtual path that will be used<br />
		<input type="text"  value='<?=$virtPath?>' name ='virtPath' size="50" />
		<br />
		<input name="submit" type="submit" value="Prepare htaccess file" />
		<br />
		
	</td>
    <td valign="top" bgcolor="#EDF0F1">Location of htaccess File<br />
	
	
	  <input type="hidden" id='writeFile' name="writeFile" value="0" />
      <input type="text"  value='<?=$htaccessFile?>' name ='htaccessFile' size="70" />
      <br />
      <br />
      <input name="button1" id='button1' type="submit" onclick='writeHtaccessFile();return false;' value="Write htaccess file to disk AND enable SEO urls"/>
      <br />
      <br />
      <input name="button2" id='button2' type="submit" onclick='deleteHtaccessFile();return false;' value="Delete htaccess file AND Disable SEO urls"/>
	
	  </td>
	  
  </tr>
</table>
  </FORM>
	  
<hr />
<?
echo "<pre>$str</pre>";
?>

<hr />

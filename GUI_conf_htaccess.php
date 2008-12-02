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
// $Id: GUI_conf_htaccess.php,v 1.9 2008/12/02 16:48:45 manolis Exp $                                                                 
//
//************************************************************************

 	if ( !L_auth::isAdmin($userID) ) { echo "go away"; return; }
?> 
<script language="javascript">
function writeHtaccessFile(){
	$("#writeFile").val('1');
	$("#htaccessConfForm").submit();
}

function deleteHtaccessFile(){
	$("#writeFile").val('-1');
	$("#htaccessConfForm").submit();
}

</script>
 <h3> SEO URLS - uses mod_rewrite of apache </h3>
 SEO URLS are currently <strong><?=($CONF['links']['type']==3?"ON":'OFF') ?></strong>
 <hr />
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

$str="
#
RewriteEngine On
RewriteBase /

# various operations on a flight
RewriteRule ^$virtPath/flight/(\d*)/kml/(.*)$ $basePath/download.php?type=kml_trk&flightID=$1&$2 [L,NC]
RewriteRule ^$virtPath/flight/(\d*)/igc/(.*)$ $basePath/download.php?type=igc&flightID=$1&$2 [L,NC]
RewriteRule ^$virtPath/flight/(\d*)(.*)$ $baseUrl&op=show_flight&flightID=$1$2 [L,NC]

# various operations on a takeoff
RewriteRule ^$virtPath/takeoff/(\d*)/kml/{0,1}$ $basePath/download.php?type=kml_wpt&wptID=$1 [L,NC]
RewriteRule ^$virtPath/takeoff/(\d*)/{0,1}$ $baseUrl&op=show_waypoint&waypointIDview=$1 [L,NC]

# various operations on a pilot
RewriteRule ^$virtPath/pilot/([\d_]*)/stats/$   $baseUrl&op=pilot_profile_stats&pilotIDview=$1 [L,NC]
RewriteRule ^$virtPath/pilot/([\d_]*)/flights/$ $baseUrl&op=list_flights&pilotIDview=$1   [L,NC]
RewriteRule ^$virtPath/pilot/([\d_]*)$ $baseUrl&op=pilot_profile&pilotIDview=$1  [L,NC]

# all 'list' ops that are /opname/countryCode/date/....
RewriteRule ^$virtPath/tracks/(.*)/(.*)/(.*)$ $baseUrl&op=list_flights&country=$1&l_date=$2&leoSeo=$3 [L,NC]
RewriteRule ^$virtPath/pilots/(.*)/(.*)/(.*)$  $baseUrl&op=list_pilots&country=$1&l_date=$2&leoSeo=$3 [L,NC]
RewriteRule ^$virtPath/league/(.*)/(.*)/(.*)$  $baseUrl&op=competition&country=$1&l_date=$2&leoSeo=$3 [L,NC]
RewriteRule ^$virtPath/takeoffs/(.*)/(.*)/(.*)$  $baseUrl&op=list_takeoffs&country=$1&l_date=$2&leoSeo=$3 [L,NC]

RewriteRule ^$virtPath/ranks/(\d*)\.(\d*)/(.*)/(.*)$  $baseUrl&op=comp&rank=$1&subrank=$2&l_date=$3&$4 [L,NC]



RewriteRule ^$virtPath/op:(.*)$ $baseUrl&op=$1 [L,NC]

RewriteRule ^$virtPath/&(.*)$ $baseUrl&$1 [L,NC]

RewriteRule ^$virtPath/?[^.]*$ /$virtPath/tracks/world/%{TIME_YEAR}/ [R,NC]

RewriteRule ^$virtPath/(.*)$ $basePath/$1 [L,NC]
";



if ($_POST['htaccessFile']) {
	$htaccessFile= $_POST['htaccessFile'];	
} else {
	$htaccessFileName=$CONF['os']=='linux'?'.htaccess':'htaccess.txt';
	$htaccessFile=realpath(dirname(__FILE__).'/../../').'/'.$htaccessFileName;
}	


$mod_conf_File=dirname(__FILE__).'/site/config_mod_rewrite.php';
if ($_POST['writeFile']==1) {
	$conf_str='<?
	$CONF[\'links\'][\'type\']=3;
	$CONF[\'links\'][\'baseURL\']=\''.$virtPath.'\';
?>';

	if (writeFile($mod_conf_File,$conf_str) )
		echo "<h3>config_mod_rewrite.php updated</h3>";
	else 
		echo "<h3>PROBLEM in updating config_mod_rewrite.php</h3>";


	if (writeFile($htaccessFile,$str) )
		echo "<h3>htaccess file written</h3>";
	else 
		echo "<h3>PROBLEM In writing htaccess file </h3>";
		
} else if ($_POST['writeFile']==-1) {
	$conf_str='<?
	$CONF[\'links\'][\'type\']=1;
	$CONF[\'links\'][\'baseURL\']=\''.$virtPath.'\';
?>';

	if (writeFile($mod_conf_File,$conf_str) )
		echo "<h3>config_mod_rewrite.php updated</h3>";
	else 
		echo "<h3>PROBLEM in updating config_mod_rewrite.php</h3>";


	if (unlink($htaccessFile) )
		echo "<h3>htaccess file DELETED</h3>";
	else 
		echo "<h3>PROBLEM In deleting htaccess file </h3>";
}

?>
<FORM method="post" name='htaccessConfForm' id='htaccessConfForm'>
Use the auto - detected values to create the htaccess file that will enable SEO URLS in Leonardo<BR /><BR />
<table width="100%" border="0" cellpadding="4">
  <tr>
    <td>File & params of running Leonardo<br />
      <input type="text"  value='<?=$baseUrl?>' name ='baseUrl'  size="50"/>
      <br />
The path to Leonardo files<br />
<input type="text"  value='<?=$basePath?>' name ='basePath' size="50"/>
<br />
The virtual path that will be used<br />
<input type="text"  value='<?=$virtPath?>' name ='virtPath' size="50" />
<br />
<input type="submit" value="Generate htaccess file" />
<br />
<input type="hidden" id='writeFile' name="writeFile" value="0" /></td>
    <td valign="top">
    
Copy and paste this configuration to the htaccess file located on the root directory of your installattion (forum/cms/ etc..)

<br />
or press the button below to write the file automatically.

<br /><br />Location of htaccess File<BR />
<input type="text"  value='<?=$htaccessFile?>' name ='htaccessFile' size="70" />
<br />
<input type="button" value="Write htaccess file to disk AND enable SEO urls" onclick='writeHtaccessFile()'/>
<br />
<BR />

<input type="button" value="Delete htaccess file AND Disable SEO urls" onclick='deleteHtaccessFile()'/><BR />

    </td>
  </tr>
</table>
<hr />
<?
echo "<pre>$str</pre>";
?>

<hr />
</FORM>
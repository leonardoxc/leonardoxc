<?  
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://sourceforge.net/projects/leonardoserver                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

 	if ( !L_auth::isAdmin($userID) ) { echo "go away"; return; }
?> 
<script language="javascript">
function writeHtaccessFile(){
	$("#writeFile").val('1');
	$("#htaccessConfForm").submit();
}
</script>
 <h3> SEO URLS - uses mod_rewrite of apache </h3>

<?
if ($_POST['baseUrl']) {
	$baseUrl= $_POST['baseUrl'];
	$basePath=$_POST['basePath'];
	$virtPath=$_POST['virtPath'];
} else {
	$baseUrl= $CONF_mainfile.CONF_MODULE_ARG; // '/modules.php?name=leonardo';
	$basePath='/modules/leonardo';
	$virtPath='leonardo';
}
?>
Use the auto - detected values to create the htaccess file that will enable SEO URLS in Leonardo<BR /><BR />
<FORM method="post" name='htaccessConfForm' id='htaccessConfForm'>
File & params of running Leonardo<BR />
<input type="text"  value='<?=$baseUrl?>' name ='baseUrl'  size="50"/><BR />
The path to Leonardo files<BR />
<input type="text"  value='<?=$basePath?>' name ='basePath' size="50"/><BR />
The virtual path that will be used<BR />
<input type="text"  value='<?=$virtPath?>' name ='virtPath' size="50" /><BR />
<input type="submit" value="Generate htaccess file" /><BR />
<input type="hidden" id='writeFile' name="writeFile" value="0" />
<hr />
<?
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

echo "<pre>$str</pre>";

if ($_POST['htaccessFile']) {
	$htaccessFile= $_POST['htaccessFile'];
} else {
	$htaccessFileName=$CONF['os']=='linux'?'.htaccess':'htaccess.txt';
	$htaccessFile=realpath(dirname(__FILE__).'/../../'.$htaccessFileName);
}	

if ($_POST['writeFile']==1) {
	writeFile($htaccessFile,$str);
	echo "<hr /><h3>htaccess file written</h3>";
}


?>

<hr />

Copy and paste this configuration to the htaccess file located on the root directory of your installattion (forum/cms/ etc..)

<br />
or press the button below to write the file automatically.

<br /><br />Location of htaccess File<BR />
<input type="text"  value='<?=$htaccessFile?>' name ='htaccessFile' size="70" />
<input type="button" value="Write htaccess file to disk" onclick='writeHtaccessFile()'/><BR />


</FORM>
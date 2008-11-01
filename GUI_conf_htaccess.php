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
<FORM method="post">
File & params of running Leonardo<BR />
<input type="text"  value='<?=$baseUrl?>' name ='baseUrl'  size="50"/><BR />
The path to Leonardo files<BR />
<input type="text"  value='<?=$basePath?>' name ='basePath' size="50"/><BR />
The virtual path that will be used<BR />
<input type="text"  value='<?=$virtPath?>' name ='virtPath' size="50" /><BR />
<input type="submit" value="Generate htaccess file" /><BR />

<hr />
<?
$str="
#
RewriteEngine On
RewriteBase /

# various operations on a flight
RewriteRule ^$virtPath/tracks/details/(\d*)$ $baseUrl&op=show_flight&flightID=$1 [L,NC]
RewriteRule ^$virtPath/tracks/ge/(\d*)$ $basePath/download.php?type=kml_trk&flightID=$1&lng=english&an=1 [L,NC]

# all 'list' ops that are /lang/opname/countryCode/date/....

RewriteRule ^$virtPath/tracks/(.*)/(.*)/(.*)$ $baseUrl&op=list_flights&country=$1&l_date=$2&$3 [L]
RewriteRule ^$virtPath/pilots/(.*)/(.*)/(.*)$  $baseUrl&op=list_pilots&country=$1&l_date=$2&$3 [L]
RewriteRule ^$virtPath/league/(.*)/(.*)/(.*)$  $baseUrl&op=competition&country=$1&l_date=$2&$3 [L]
RewriteRule ^$virtPath/ranks/(\d*)\.(\d*)/(.*)/(.*)$  $baseUrl&op=comp&rank=$1&subrank=$2&l_date=$3&$4 [L]
RewriteRule ^$virtPath/takeoffs/(.*)/(.*)/(.*)$  $baseUrl&op=list_takeoffs&country=$1&l_date=$2&$3 [L]


# various operations on a pilot
RewriteRule ^$virtPath/pilots/details/([\d_]*)$ $baseUrl&op=pilot_profile&pilotIDview=$1  [L,NC]
RewriteRule ^$virtPath/pilots/stats/([\d_]*)$   $baseUrl&op=pilot_profile_stats&pilotIDview=$1 [L,NC]
RewriteRule ^$virtPath/pilots/flights/([\d_]*)$ $baseUrl&op=list_flights&pilotIDview=$1   [L,NC]


RewriteRule ^$virtPath/&(.*)$ $baseUrl&$1 [L]


RewriteRule ^$virtPath/(.*)$ $basePath/$1
";

echo "<pre>$str</pre>";


?>

<hr />

Copy and paste this configuration to the htaccess file located on the roo directory of your installattion (forum/cms/ etc..)
</FORM>
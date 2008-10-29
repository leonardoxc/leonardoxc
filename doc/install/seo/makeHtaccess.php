<?

$baseUrl='/modules.php?name=leonardo';
$basePath='/modules/leonardo';

$virtPath='leonardo';

$str="
#
RewriteEngine On
RewriteBase /

# various operations on a flight
RewriteRule ^$virtPath/tracks/details/(\d*)$ $baseUrl&op=show_flight&flightID=$1 [L,NC]
RewriteRule ^$virtPath/tracks/ge/(\d*)$ $basePath/download.php?type=kml_trk&flightID=$1&lng=english&an=1 [L,NC]


RewriteRule ^$virtPath/tracks/(.*)$ $baseUrl&op=list_flights&$1 [L]

# various operations on a pilot
RewriteRule ^$virtPath/pilots/details/([\d_]*)$ $baseUrl&op=pilot_profile&pilotIDview=$1 [L,NC]
RewriteRule ^$virtPath/pilots/stats/([\d_]*)$   $baseUrl&op=pilot_profile_stats&pilotIDview=$1 [L,NC]
RewriteRule ^$virtPath/pilots/flights/([\d_]*)$ $baseUrl&op=list_flights&pilotIDview=$1 [L,NC]

RewriteRule ^$virtPath/pilots/(.*)$ $baseUrl&op=list_pilots&$1 [L]

RewriteRule ^$virtPath/ranks/(.*)$ $baseUrl&op=competition&$1 [L]


RewriteRule ^$virtPath/takeoffs/(.*)$ $baseUrl&op=list_takeoffs&$1 [L]

RewriteRule ^$virtPath/(.*)$ $basePath/$1
";

echo $str;

?>
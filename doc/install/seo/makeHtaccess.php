<?

$baseUrl='/modules.php?name=leonardo';
$basePath='/modules/leonardo';

$virtPath='leonardo';

$str="
#
RewriteEngine On
RewriteBase /

# various operations on a flight
RewriteRule ^$virtPath/(\w{2})/tracks/details/(\d*)$ $baseUrl&lng=$1&op=show_flight&flightID=$2 [L,NC]
RewriteRule ^$virtPath/(\w{2})/tracks/ge/(\d*)$ $basePath/download.php?type=kml_trk&flightID=$1&lng=english&an=1 [L,NC]

# all 'list' ops that are /lang/opname/countryCode/date/....

RewriteRule ^$virtPath/(\w{2})/tracks/(.*)/(.*)/(.*)$ $baseUrl&lng=$1&op=list_flights&country=$2&l_date=$3&$4 [L]
RewriteRule ^$virtPath/(\w{2})/pilots/(.*)/(.*)/(.*)$  $baseUrl&lng=$1&op=list_pilots&country=$2&l_date=$3&$4 [L]
RewriteRule ^$virtPath/(\w{2})/ranks/(.*)/(.*)/(.*)$  $baseUrl&lng=$1&op=competition&country=$2&l_date=$3&$4 [L]
RewriteRule ^$virtPath/(\w{2})/takeoffs/(.*)/(.*)/(.*)$  $baseUrl&lng=$1&op=list_takeoffs&country=$2&l_date=$3&$4 [L]


# various operations on a pilot
RewriteRule ^$virtPath/(\w{2})/pilots/details/([\d_]*)$ $baseUrl&op=pilot_profile&pilotIDview=$2&lng=$1 [L,NC]
RewriteRule ^$virtPath/(\w{2})/pilots/stats/([\d_]*)$   $baseUrl&op=pilot_profile_stats&pilotIDview=$2&lng=$1 [L,NC]
RewriteRule ^$virtPath/(\w{2})/pilots/flights/([\d_]*)$ $baseUrl&op=list_flights&pilotIDview=$2&lng=$1 [L,NC]


RewriteRule ^$virtPath/(\w{2})/&(.*)$ $baseUrl&lng=$1&$2 [L]


RewriteRule ^$virtPath/(.*)$ $basePath/$1
";

echo $str;

?>
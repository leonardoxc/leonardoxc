<?
if ( preg_match("/\.home$/",$_SERVER['SERVER_NAME'] ) ) {
	$dbhost = 'localhost';
	$dbname = 'pgforum2';
	$dbuser = 'pgforumftp';
	$dbpasswd = 'K7v#3E!2';
} else {
	$dbhost = 'localhost';
	$dbname = 'paraglidingforum';
	$dbuser = 'pgforumftp';
	$dbpasswd = 'K7v#3E!2';
}

?>
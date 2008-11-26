<?

if ( $_SERVER['SERVER_NAME'] =="pgforum.home" ) {
	$dbhost = 'localhost';
	$dbname = 'pgforum3';
	$dbuser = 'pgforumftp';
	$dbpasswd = 'K7v#3E!2';
} else if ( $_SERVER['SERVER_NAME'] =='discuz.home'  ) {
	$dbhost = 'localhost';
	$dbname = 'discuz';
	$dbuser = 'root';
	$dbpasswd = '321ox';
} else if ( $_SERVER['SERVER_NAME'] =='joomla.home'  ) {
	$dbhost = 'localhost';
	$dbname = 'joomla';
	$dbuser = 'root';
	$dbpasswd = '321ox';
} else {

	if ($opMode==5 || $opMode==6) {
		$dbhost = 'localhost';
		$dbname = 'joomla15';
		$dbuser = 'web_admin';
		$dbpasswd = '321ox';
	} else {
		$dbhost = 'localhost';
		$dbname = 'paraglidingforum4';
		$dbuser = 'pgforumftp';
		$dbpasswd = 'K7v#3E!2';
	}	
}
	


?>
<?

$dbhost = 'localhost';
$dbname = 'paraglidingforum';
$dbuser = 'pgforumftp';
$dbpasswd = 'K7v#3E!2';

$prefix = 'phpbb';

define('USERS_TABLE','phpbb_users');
define('SESSIONS_TABLE','phpbb_sessions');
define('ANONYMOUS',-1);

$board_config['sitename']=$_SERVER['SERVER_NAME'];
$board_config['cookie_name']='phpbb';
$board_config['cookie_path']='/';
$board_config['cookie_domain']=$_SERVER['SERVER_NAME'];
$board_config['cookie_secure']=0;
$board_config['session_length']=3600;

?>
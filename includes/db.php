<?php


$dbhost = '';
$dbname = '';
$dbuser = '';
$dbpasswd = ''

// DO NOT EDIT BELLOW THIS LINE 
$dbms = 'mysql';
$prefix = 'leonardo';
$table_prefix = $prefix.'_';
$user_prefix  = $prefix ;
$users_table= "leonardo_users";

require_once dirname(__FILE__)."/mysql.php";

// Make the database connection.
$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);

if(!$db->db_connect_id)
{
   echo "Could not connect to the database<br>";
   exit;
}

?>
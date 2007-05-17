<?
if ( count($argv) != 2 ) {
	echo "Usage $argv[0] pass\n";
	exit;
}
list($scriptname,$pass)=$argv;

require_once "../../EXT_config_pre.php";
require_once "../../config.php";
require_once "../../EXT_config.php";

//echo  count($argv) ;

$query="DELETE FROM  leonardo_live_data WHERE passwd='$pass'";
// echo $query;
$res= $db->sql_query($query);
if($res <= 0){
		echo("Error in query! $query \n");
		exit();
}






?>
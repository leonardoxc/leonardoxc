<?
// opMode 
// 1 = PHPnuke module
// 2 = phbb2 module
// 3 = standalone -- still work in progress
// 4 = discuz
// 5 = joomla
$opMode= 2; 

// override 
if ( defined('Leonardo_as_joomla_com') ) $opMode= 5; 

$CONF_isMasterServer=1; 
?>
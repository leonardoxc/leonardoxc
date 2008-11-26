<?
// opMode 
// 1 = PHPnuke module
// 2 = phbb2 module only phpBB2 NOT phpBB3
// 3 = standalone -- still work in progress
// 4 = discuz
// 5 = joomla  1.0 and 1.5
// 6 = phpbb3
$opMode= 6; 

// the method to use for links in the menu and other parts of leonardo
// 1 -> current old way, using &name=value args + session variables
// 2 -> same as 1 but all sessions vars are in the url, this means that the url 
// 3 -> SEO urls

//  NOTE !!!!!! SEO URLS are only compatible with opmodes 2 + 6 (phpbb)
$CONF['links']['type']=1;
$CONF['links']['baseURL']='/leonardo';

// override 
if ( defined('Leonardo_op_mode') ) $opMode= Leonardo_op_mode; 

$CONF_isMasterServer=1; 
?>
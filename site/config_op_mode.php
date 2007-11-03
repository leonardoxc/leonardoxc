<?
// opMode 
// 1 = PHPnuke module
// 2 = phbb2 module
// 3 = standalone -- still work in progress
// 4 = discuz
// 5 = joomla
$opMode= 5; 

if ($opMode==1)			$baseInstallationPath='';
else if ($opMode==2)	$baseInstallationPath='';
else if ($opMode==3)	$baseInstallationPath='/modules/leonardo';
else if ($opMode==4)	$baseInstallationPath='/leonardo';
else if ($opMode==5)	$baseInstallationPath='/';

$baseInstallationPathSet=1;

$CONF_isMasterServer=1; 
?>
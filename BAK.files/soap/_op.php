<?

require_once dirname(__FILE__)."/nusoap.php";

require_once dirname(__FILE__)."/../config_op_mode.php";
require_once dirname(__FILE__)."/../config_admin.php";

$server = new soap_server;
$server->register('uploadFile');

function uploadFile($sitePass,$remoteFile,$localFile) {
	global $CONF_SitePassword;	

	if ($sitePass!=$CONF_SitePassword) return new soap_fault('Client','','Access denied');
	if ( ($fileStr=@file_get_contents($remoteFile)) === FALSE) 
		return new soap_fault('Client','',"Cant access file ($remoteFile) to upload");
	if ( ! (strpos($localFile,"..") === FALSE) ) 
		return new soap_fault('Client','',"Invalid local file ($localFile) ");
	$f1=$fileStr;
	
	$filename=dirname(__FILE__)."/../$localFile";
	if (!$handle = fopen($filename, 'w'))  
		return new soap_fault('Client','',"Cannot open file ($filename)");

	if (fwrite($handle, $fileStr)===FALSE) 
		return new soap_fault('Client','',"Cannot write to file ($filename)");
		
    	fclose($handle); 
	return 1;
}

@include_once dirname(__FILE__)."/op_addons.php";

$server->service($HTTP_RAW_POST_DATA);

?>
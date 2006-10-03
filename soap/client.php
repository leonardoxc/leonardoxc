<? 
require_once dirname(__FILE__)."/IXR_Library.inc.php";

$client = new IXR_Client('http://pgforum.home/modules/leonardo/soap/server.php');
if ( ! $client->query('test.add', 4, 5) ) {
   die('An error occurred - '.$client->getErrorCode().":".$client->getErrorMessage());
}
print $client->getResponse();

?>
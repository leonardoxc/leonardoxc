<? 
require_once dirname(__FILE__)."/IXR_Library.inc.php";
$opServerUrl="http://pgforum.home/modules/leonardo/op2.php";
require_once dirname(__FILE__)."/../CL_gpsPoint.php";

$client = new IXR_Client($opServerUrl);

if ( ! $client->query('test.findTakeoff', "mypass",40.5667, -22.4) ) {
   die('An error occurred - '.$client->getErrorCode().":".$client->getErrorMessage());
} else {
	list($ar,$distance)= $client->getResponse();
	$nearestWaypoint=new waypoint();
	$nearestWaypoint->fillFromArray($ar);
	echo $nearestWaypoint->name;
	echo "#$distance<BR>";
}

/*
if ( ! $client->query('takeoffs.getAll', "mypass") ) {
   die('An error occurred - '.$client->getErrorCode().":".$client->getErrorMessage());
} else {
	list($num,$ar)= $client->getResponse();
	echo "GOT $num waypoints";
}
*/

?>
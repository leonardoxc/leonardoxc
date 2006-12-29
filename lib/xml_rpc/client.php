<? 
require_once dirname(__FILE__)."/IXR_Library.inc.php";
require_once dirname(__FILE__)."/../CL_gpsPoint.php";

$opServerUrl="http://pgforum.thenet.gr/modules/leonardo/op2.php";
$client = new IXR_Client($opServerUrl);

if ( ! $client->query('flights.find', "mypass",40.5667, -22.4, 0 ) ) {
   die('An error occurred - '.$client->getErrorCode().":".$client->getErrorMessage());
} else {
	list($flights_num,$flights)= $client->getResponse();
	if ($flights_num>0){
		foreach ($flights as $flight) {
			echo $flight['pilot']." ".$flight['takeoff']."<BR>";
		}
	}
}
exit;

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
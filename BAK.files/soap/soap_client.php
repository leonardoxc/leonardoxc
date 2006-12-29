<?
	require_once dirname(__FILE__)."/../CL_gpsPoint.php";
	
	$soapServerUrl="http://pgforum.home/modules/leonardo/op.php";
	require_once dirname(__FILE__)."/nusoap.php";
	$soapclient = new soapclient($soapServerUrl);
	if($err = $soapclient->getError()){
		echo "SOAP init error<br>";
	} else {
		list($ar,$distance)=$soapclient->call('findTakeoff',array($CONF_SitePassword,40.30,22.4)  );
		if($err = $soapclient->getError()) echo "SOAP Online error: $err<br>";
		else { 
			$nearestWaypoint=new waypoint();
			$nearestWaypoint->fillFromArray($ar);
			echo $nearestWaypoint->name;
			echo "#$distance<BR>";
		}
	}

?>
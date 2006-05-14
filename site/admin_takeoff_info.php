<? 

		echo '<div style=" background-color:#DDEEE1 ">';
		echo "<a href='http://www.flightlog.org/fl.html?rqtid=6&x=".-$firstPoint->lon."&y=".$firstPoint->lat."' target=_blank>flightlog.org</a> | ";

		echo "<a href='http://www.paragliding365.com/paragliding_sites.html?longitude=".-$firstPoint->lon."&latitude=".$firstPoint->lat."&radius=50' target=_blank>paragliding365.com</a> | ";
		// also
		// http://www.paragliding365.com/paragliding_sites_kml.html?longitude=13.9&latitude=47.4167&radius=50
		// for google earth

		echo "<a href='http://ozreport.com/sites-query.xml.php?lat=".$firstPoint->lat."&lon=".-$firstPoint->lon."&num=5' target=_blank>ozreport.com</a> | ";

		$leonardoServers=array("www.sky.gr","www.vololibero.net","xc.parapente.com.ar","www.ypforum.com","www.heidel.com.ar/xc");
		foreach ($leonardoServers as $leonardoServer) 
			echo "<a href='http://$leonardoServer/modules/leonardo/EXT_takeoff.php?op=find_wpt&lon=".$firstPoint->lon."&lat=".$firstPoint->lat."' target=_blank>".$leonardoServer."</a> | ";		
		echo "<BR>";
  	    echo "</div>";

?>
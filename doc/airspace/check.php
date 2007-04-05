<?
require_once dirname(__FILE__).'/../../CL_gpsPoint.php';

function checkFile($filename) {
	$lines = file ($filename); 
	if (!$lines) { echo "Cant read file"; return; }
	$i=0;

    // find bounding box of flight
	$min_lat=1000;
	$max_lat=-1000;
	$min_lon=1000;
	$max_lon=-1000;
	foreach($lines as $line) {
		$line=trim($line);
		if  (strlen($line)==0) continue;				
		if ($line{0}=='B') {
				if  ( strlen($line) < 23 ) 	continue;
				$thisPoint=new gpsPoint($line,0);
				if ( $thisPoint->lat  > $max_lat )  $max_lat =$thisPoint->lat  ;
				if ( $thisPoint->lat  < $min_lat )  $min_lat =$thisPoint->lat  ;
				if ( -$thisPoint->lon  > $max_lon )  $max_lon =-$thisPoint->lon  ;
				if ( -$thisPoint->lon  < $min_lon )  $min_lon =-$thisPoint->lon  ;
		}
	}
	// echo "$min_lat,	$max_lat,$min_lon,	$max_lon<BR>";

	// now find the bounding boxes that have common points
	// !( A1<X0 || A0>X1 ) &&  !( B1<Y0 || B0>Y1 )
	// X,A -> lon
	// Y,B -> lat 
	// X0 -> $min_lon A0-> $area->minx
	// X1 -> $max_lon A1-> $area->maxx
	// Y0 -> $min_lat B0-> $area->miny
	// Y1 -> $max_lat B1-> $area->maxy
	
	// !( $area->maxx<$min_lon || $area->minx>$max_lon ) &&  !( $area->maxx<$min_lat || $area->miny>$max_lat )

	global $AirspaceArea,$NumberOfAirspaceAreas;

	foreach($AirspaceArea as $i=>$area) {
		if ( !( $area->maxx<$min_lon || $area->minx>$max_lon ) &&
			 !( $area->maxy<$min_lat || $area->miny>$max_lat )
		) {
			if ($area->Shape==1) $shape="Area  "; else $shape="Circle";
			echo "Found $shape [$i] => ".$area->Name.'<BR>';
			// print_r($area);
			if ($area->Shape==1) {
				$area->Points[]=$area->Points[0];
				// $area->NumPoints=count($area->Points);
			}
			$selAirspaceArea[]=$area;
		}
	}

	$AirspaceArea=$selAirspaceArea;
	$NumberOfAirspaceAreas=count($AirspaceArea);
	echo '<HR>';
//print_r($AirspaceArea);
	echo '<HR>';
	echo '<HR>';
	$i=0;
	foreach($lines as $line) {
		$line=trim($line);
		if  (strlen($line)==0) continue;				
		if ($line{0}=='B') {
				if  ( strlen($line) < 23 ) 	continue;
				$thisPoint=new gpsPoint($line,0);
				$alt=$thisPoint->getAlt(1);	// prefer vario alt

				// $insideArea=-1;
				$insideAreas=array();
				$insideAreas=FindAirspaceArea(-$thisPoint->lon,$thisPoint->lat,$alt);
				if (count($insideAreas)>0) {
					echo "point [$i] INSIDE AIRSPACE areas: ";
					foreach($insideAreas as $areaInfo) echo $AirspaceArea[$areaInfo[0]]->Name." areaID[$areaInfo[0]] disInside[$areaInfo[1]] altInside[$areaInfo[2]]  ";
					echo "<BR>";
				} else { 
					// echo "OK<BR>";
				}
				$i++;
		}
	}		
$m1=memory_get_usage();
echo "ReadAltitude: mem usage: $m1 <BR>"; 


}

?>
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
	// X0 -> $min_lon A0-> $area->bounds->minx
	// X1 -> $max_lon A1-> $area->bounds->maxx
	// Y0 -> $min_lat B0-> $area->bounds->miny
	// Y1 -> $max_lat B1-> $area->bounds->maxy
	
	// !( $area->bounds->maxx<$min_lon || $area->bounds->minx>$max_lon ) &&  !( $area->bounds->maxx<$min_lat || $area->bounds->miny>$max_lat )

	global $AirspaceArea,$AirspaceCircle;

	foreach($AirspaceArea as $i=>$area) {
		if ( !( $area->bounds->maxx<$min_lon || $area->bounds->minx>$max_lon ) &&
			 !( $area->bounds->maxy<$min_lat || $area->bounds->miny>$max_lat )
		) {
			echo "Found area [$i] => ".$area->Name;
			print_r($area);

		}
	}
	foreach($AirspaceCircle as $i=>$area) {
		if ( !( $area->bounds->maxx<$min_lon || $area->bounds->minx>$max_lon ) &&  
			 !( $area->bounds->maxy<$min_lat || $area->bounds->miny>$max_lat )
		) {
			echo "Found  circle [$i] => ".$area->Name."<BR>";

		}
	}

return;
	foreach($lines as $line) {
		$line=trim($line);
		if  (strlen($line)==0) continue;				
		if ($line{0}=='B') {
				if  ( strlen($line) < 23 ) 	continue;
				$thisPoint=new gpsPoint($line,0);
				$alt=$thisPoint->getAlt(1);	// prefer vario alt

				$insideCircle=-1;
				$insideArea=-1;
				$insideCircle=FindAirspaceCircle(-$thisPoint->lon,$thisPoint->lat,$alt);
				$insideArea=FindAirspaceArea(-$thisPoint->lon,$thisPoint->lat,$alt);
				if ($insideCircle>=0 || $insideArea>=0) {
					echo "INSIDE AIRSPACE circle: $insideCircle , area: $insideArea <BR>";
				} else { 

					// echo "OK<BR>";
				}
				$i++;
		}
	}		

}

?>
<?
// circle functions

function RangeAirspaceCircle($longitude,$latitude,$i) {
	global $AirspaceArea;
	if ($AirspaceArea[$i]->Shape!=2) {
		echo "FATAL Error: accessing non circle area as circle<BR>";
		exit;
	}
	list($distance,$tmp1)= DistanceBearing($latitude,$longitude,$AirspaceArea[$i]->Latitude,$AirspaceArea[$i]->Longitude,1,0);
    return $distance-$AirspaceArea[$i]->Radius;
}

function InsideAirspaceCircle($longitude,$latitude,$i) {
	global $AirspaceArea;
	if ($AirspaceArea[$i]->Shape!=2) {
		echo "FATAL Error: accessing non circle area as circle<BR>";
		exit;
	}
	$range=RangeAirspaceCircle($longitude, $latitude, $i);
	if ( $range<0) {
		return -$range;
	}
	return 0;
}


function CheckAirspaceAltitude($Base, $Top,$alt) {
	// echo "# $Base, $Top, alt:$alt <BR>";
	 return 1;
	$a1= $alt - $Base ;
	$a2= $Top - $alt;
	if (  $a1 >0 && $a2>0 ) return min($a1,$a2);
	else return 0;
}

///////////////////////////////////////////////////

// Copyright 2001, softSurfer (www.softsurfer.com)
// This code may be freely used and modified for any purpose
// providing that this copyright notice is included with it.
// SoftSurfer makes no warranty for this code, and cannot be held
// liable for any real or imagined damage resulting from its use.
// Users of this code must verify correctness for their application.

//    a Point is defined by its coordinates {int x, y;}
//===================================================================

// isLeft(): tests if a point is Left|On|Right of an infinite line.
//    Input:  three points P0, P1, and P2
//    Return: >0 for P2 left of the line through P0 and P1
//            =0 for P2 on the line
//            <0 for P2 right of the line
//    See: the January 2001 Algorithm "Area of 2D and 3D Triangles and Polygons"
function isLeft( $P0, $P1, $P2 ) { // AIRSPACE_POINT P0
    return ( ($P1->Longitude - $P0->Longitude) * ($P2->Latitude - $P0->Latitude)
            - ($P2->Longitude - $P0->Longitude) * ($P1->Latitude - $P0->Latitude) );
}
//===================================================================

// wn_PnPoly(): winding number test for a point in a polygon
//      Input:   P = a point,
//               V[] = vertex points of a polygon V[n+1] with V[n]=V[0]
//      Return:  wn = the winding number (=0 only if P is outside V[])
function wn_PnPoly( $P, $areaNum)  //   AIRSPACE_POINT P, AIRSPACE_POINT* V
{
	global $AirspaceArea;

	$n=$AirspaceArea[$areaNum]->NumPoints ;
	$wn = 0;    // the winding number counter

    // loop through all edges of the polygon
    for ($i=0; $i<$n; $i++) {   // edge from V[$i] to V[$i+1]
        if ($AirspaceArea[$areaNum]->Points[$i]->Latitude <= $P->Latitude) {         // start y <= P.Latitude
            if ($AirspaceArea[$areaNum]->Points[$i+1]->Latitude > $P->Latitude)      // an upward crossing
                if (isLeft( $AirspaceArea[$areaNum]->Points[$i], $AirspaceArea[$areaNum]->Points[$i+1], $P) > 0) { // P left of edge
                    $wn++;            // have a valid up intersect
				}
        } else {                       // start y > P->Latitude (no test needed)
            if ($AirspaceArea[$areaNum]->Points[$i+1]->Latitude <= $P->Latitude)     // a downward crossing
                if (isLeft( $AirspaceArea[$areaNum]->Points[$i], $AirspaceArea[$areaNum]->Points[$i+1], $P) < 0) {  // P right of edge
                    $wn--;            // have a valid down intersect
				}
        }
    }
    return $wn;
}
//===================================================================

function InsideAirspaceArea($longitude,$latitude,$i) {
  $thispoint=new AIRSPACE_POINT() ;
  $thispoint->Longitude = $longitude;
  $thispoint->Latitude = $latitude;

  // it is within, so now do detailed polygon test
  if (wn_PnPoly($thispoint, $i ) != 0) {
      // we are inside the i'th airspace area

	  // now find the distance from the nearest eadge

      return 1;
  }
  return 0;
}


function RangeAirspaceArea($longitude,$latitude,$i) {
  global $AirspaceArea;

  // find nearest distance to line segment
  $dist=100000;
  $nearestdistance = $dist;
  for ($j=0; $j<$AirspaceArea[$i]->NumPoints; $j++) {
    $dist = CrossTrackError( $AirspaceArea[$i]->Points[$j]->Longitude, $AirspaceArea[$i]->Points[$j]->Latitude,
				 $AirspaceArea[$i]->Points[$j+1]->Longitude, $AirspaceArea[$i]->Points[$j+1]->Latitude,
/*
				 AirspacePoint[AirspaceArea[i].FirstPoint+j].Longitude,
				 AirspacePoint[AirspaceArea[i].FirstPoint+j].Latitude,
				 AirspacePoint[AirspaceArea[i].FirstPoint+j+1].Longitude,
				 AirspacePoint[AirspaceArea[i].FirstPoint+j+1].Latitude,
*/
				 $longitude, $latitude,
				 $lon4, $lat4);
    if ($dist<$nearestdistance) {
      $nearestdistance = $dist;
    }
  }

  return $nearestdistance;

}


// finds cross track error in meters and closest point p4 between p3 and
// desired track p1-p2.
// very slow function!
function CrossTrackError($lon1, $lat1, $lon2, $lat2,$lon3, $lat3, $lon4, $lat4) {

  list($dist_AD, $crs_AD)= DistanceBearing($lat1, $lon1, $lat3, $lon3, 1,1);
  $dist_AD/= (RAD_TO_DEG * 111194.9267); 
  $crs_AD*= DEG_TO_RAD;

 
  list($dist_AB, $crs_AB)=  DistanceBearing($lat1, $lon1, $lat2, $lon2, 1,1);
  $dist_AB/= (RAD_TO_DEG * 111194.9267); 
  $crs_AB*= DEG_TO_RAD;

  $lat1 *= DEG_TO_RAD;
  $lat2 *= DEG_TO_RAD;
  $lat3 *= DEG_TO_RAD;
  $lon1 *= DEG_TO_RAD;
  $lon2 *= DEG_TO_RAD;
  $lon3 *= DEG_TO_RAD;

 // double XTD; // cross track distance
 // double ATD; // along track distance

  //  The "along track distance", ATD, the distance from A along the
  //  course towards B to the point abeam D

  $sindist_AD = sin($dist_AD);

  $XTD = asin($sindist_AD*sin($crs_AD-$crs_AB));

  $sinXTD = sin($XTD);
  $ATD = asin(sqrt( $sindist_AD*$sindist_AD - $sinXTD*$sinXTD )/cos($XTD));
  /*
  if (lon4 && lat4) {
    IntermediatePoint(lon1, lat1, lon2, lat2, ATD, dist_AB,
		      lon4, lat4);
  }
*/
  // units
  $XTD *= (RAD_TO_DEG * 111194.9267);
 
   return abs($XTD);
}

function FindAirspaceArea($Longitude,$Latitude,$alt) {
  global $NumberOfAirspaceAreas,$AirspaceArea ;
  if($NumberOfAirspaceAreas == 0)  return -1;

  $areas=array();
  for($i=0;$i<$NumberOfAirspaceAreas;$i++) {
    if(  $altInside=CheckAirspaceAltitude($AirspaceArea[$i]->Base->Altitude, $AirspaceArea[$i]->Top->Altitude,$alt) ) {

	  if (($Latitude  > $AirspaceArea[$i]->miny) && ($Latitude  < $AirspaceArea[$i]->maxy) &&
		  ($Longitude > $AirspaceArea[$i]->minx) && ($Longitude < $AirspaceArea[$i]->maxx)) {

		if ($AirspaceArea[$i]->Shape==1) { // area
			if (InsideAirspaceArea($Longitude,$Latitude,$i)) {
			  $distanceInside=RangeAirspaceArea($Longitude,$Latitude,$i);
			  $areas[]=array($i,$distanceInside,$altInside);
			}
		} else {
			$distanceInside=InsideAirspaceCircle($Longitude,$Latitude,$i);
			if ($distanceInside) {
			  $areas[]=array($i,$distanceInside,$altInside);
			}
		}
	  }

    }
  }
  // not inside any airspace
  return $areas;
}


/////////////////////////////////////////////////////////////////////////////////

?>
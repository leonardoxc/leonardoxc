<?
//************************************************************************
// Leonardo XC Server, http://leonardo.thenet.gr
//
// Copyright (c) 2004-8 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: FN_airspace.php,v 1.8 2008/11/29 22:46:06 manolis Exp $                                                                 
//
//************************************************************************

/************************************************************************
	Airspace Code adapted from c++ from the xcsoar project 
	http://xcsoar.sourceforge.net/
************************************************************************/

define("abUndef",0);
define("abMSL",1);
define("abAGL",2);
define("abFL",3);

define("k_nLtAC",0);
define("k_nLtAN",1);
define("k_nLtAL",2);
define("k_nLtAH",3);
define("k_nLtV" ,4);
define("k_nLtDP",5);
define("k_nLtDB",6);
define("k_nLtDA",7);
define("k_nLtDC",8);

/////////////////////////////

define("TOFEET",3.281);
define("NAUTICALMILESTOMETRES",1851.96);
define("QNH",1013.2);
define("DEG_TO_RAD", 0.0174532925199432958);
define("RAD_TO_DEG", 57.2957795131 );
define("M_2PI", M_PI*2);

class AIRSPACE_ALT {
	var $Altitude;
	var $FL;
	var $Base;  // AirspaceAltBase_t 
}

class AIRSPACE_POINT {
	var $Latitude;
	var $Longitude;
}

class AIRSPACE_AREA {
  var $id;
  var $Name;
  var $Type;
  var $Shape; // 1 => area , 2=> circle
  var $Comments;
  var $Base; // AIRSPACE_ALT 
  var $Top; //AIRSPACE_ALT 
  var $minx;
  var $miny;
  var $maxx;
  var $maxy;
  var $NumPoints;
  var $Points; // array of AIRSPACE_POINT

	function AIRSPACE_AREA (){
		$this->Shape=1;
		$this->Points=array();
	}

}

class AIRSPACE_CIRCLE {
  var $Name;
  var $Type;
  var $Shape; // 1 => area , 2=> circle
  var $Comments;
  var $Base; // AIRSPACE_ALT 
  var $Top; // AIRSPACE_ALT 
  var $minx;
  var $miny;
  var $maxx;
  var $maxy;

  var $Latitude;
  var $Longitude;
  var $Radius;
	function AIRSPACE_CIRCLE (){
		$this->Shape=2;
	}
} 


  
function AltitudeToQNHAltitude($alt) {
  $k1=0.190263;
  $ps = pow( (44330.8-$alt)/4946.54 , 1.0/$k1);
  return StaticPressureToAltitude($ps);
}

function StaticPressureToAltitude($ps) {
   // http://wahiduddin.net/calc/density_altitude.htm
  $k1=0.190263;
  $k2=8.417286e-5;
  $h_gps0 = 0;

  $Pa = pow(
                  pow($ps-(QNH-1013.25)*100.0,$k1)
                  -($k2*$h_gps0)
                  ,(1.0/$k1));

  $altitude = 44330.8-4946.54*pow($Pa,$k1);
  return $altitude;
}

function FindLatitudeLongitude($Lat, $Lon, $Bearing, $Distance ,$calc_lat_out , $calc_lon_out) {

  $Lat *= DEG_TO_RAD;
  $Lon *= DEG_TO_RAD;
  $Bearing *= DEG_TO_RAD;
  $Distance = $Distance/6371000;

  $sinDistance = sin($Distance);
  $cosLat = cos($Lat);

  if ($calc_lat_out) {
    $result = asin(sin($Lat)*cos($Distance)+$cosLat*$sinDistance*cos($Bearing));
    $result *= RAD_TO_DEG;
    $lat_out = $result;
  }
  
  if ($calc_lon_out) {
    if($cosLat==0)
      $result = $Lon;
    else {
      $result = $Lon+asin(sin($Bearing)*$sinDistance/$cosLat);
      $result = fmod(($result+M_PI), M_2PI );
      $result = $result - M_PI;
    }
    $result *= RAD_TO_DEG;
    $lon_out = $result;
  }
  
  return array($lat_out, $lon_out );
}


function DistanceBearing($lat1, $lon1, $lat2, $lon2 ,$calcDistance , $calcBearing ) {

  $lat1 *= DEG_TO_RAD;
  $lat2 *= DEG_TO_RAD;
  $lon1 *= DEG_TO_RAD;
  $lon2 *= DEG_TO_RAD;

  $clat1 = cos($lat1);
  $clat2 = cos($lat2);
  $dlat  = $lat2-$lat1;
  $dlon  = $lon2-$lon1;
/*
The great circle distance d between two points with coordinates {lat1,lon1} and {lat2,lon2} is given by:

d=acos(sin(lat1)*sin(lat2)+cos(lat1)*cos(lat2)*cos(lon1-lon2))

A mathematically equivalent formula, which is less subject to rounding error for short distances is:

d=2*asin(sqrt((sin((lat1-lat2)/2))^2 + 
                 cos(lat1)*cos(lat2)*(sin((lon1-lon2)/2))^2))
*/
  if ($calcDistance) {
    $s1 = sin($dlat/2);
    $s2 = sin($dlon/2);
    $a= max(0.0,min(1.0,$s1*$s1+$clat1*$clat2*$s2*$s2));
    $c= 2.0*atan2(sqrt($a),sqrt(1.0-$a));
    $Distance = 6371000.0*$c;
  }
  /*

For starting points other than the poles:

IF sin(lon2-lon1)<0       
   tc1=acos((sin(lat2)-sin(lat1)*cos(d))/(sin(d)*cos(lat1)))    
ELSE       
   tc1=2*pi-acos((sin(lat2)-sin(lat1)*cos(d))/(sin(d)*cos(lat1)))    
ENDIF 

An alternative formula, not requiring the pre-computation of d, the distance between the points, is:

   tc1=mod(atan2(sin(lon1-lon2)*cos(lat2),
           cos(lat1)*sin(lat2)-sin(lat1)*cos(lat2)*cos(lon1-lon2)), 2*pi)
*/
  if ($calcBearing) {
    $slat1 = sin($lat1);
    $slat2 = sin($lat2);
    $y = sin($dlon)*$clat2;
    $x = $clat1*$slat2-$slat1*$clat2*cos($dlon);

    if (abs($x)>0.00000001 && abs($y)>0.00000001){
      $theta = atan2($y,$x)*RAD_TO_DEG;
    } else {
      $theta = 0;
    }

    while ($theta>360.0) {
      $theta-= 360.0;
    }
    while ($theta<0.0) {
      $theta+= 360.0;
    }
    $Bearing = $theta;
  }

  return array($Distance, $Bearing);
}

//--------------------------------------------------------------------
//--------------------------------------------------------------------
//
// Search functions
//
//--------------------------------------------------------------------
//--------------------------------------------------------------------


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
	// return 1;
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

// un commnet this for debug
/* 
if ( ! $P1->Longitude  || ! $P0->Longitude  || ! $P2->Latitude || ! $P0->Latitude 
 || !$P2->Longitude  || !$P1->Latitude )  {
	 echo "ERROR: lat or lon  is ZERO . ";
	 exit;
 } */
			
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

	$n=$AirspaceArea[$areaNum]->NumPoints  - 1 ;
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

global $near;
  // find nearest distance to line segment
  $dist=100000;
  $nearestdistance = $dist;
  for ($j=0; $j<$AirspaceArea[$i]->NumPoints-1 ; $j++) {
    $dist = CrossTrackError( $AirspaceArea[$i]->Points[$j]->Longitude, $AirspaceArea[$i]->Points[$j]->Latitude,
				 $AirspaceArea[$i]->Points[$j+1]->Longitude, $AirspaceArea[$i]->Points[$j+1]->Latitude,
				 $longitude, $latitude);
    if ($dist<$nearestdistance) {
      $nearestdistance = $dist;
	  $near[0]=$AirspaceArea[$i]->Points[$j]->Longitude;
	  $near[1]=$AirspaceArea[$i]->Points[$j]->Latitude;
	  $near[2]=$AirspaceArea[$i]->Points[$j+1]->Longitude;
	  $near[3]=$AirspaceArea[$i]->Points[$j+1]->Latitude;
	  $near[4]=$j;
    }
  }

  return $nearestdistance;

}


function dot($lon1, $lat1, $lon2, $lat2,$lon3, $lat3){
//	AB = new int[2];
//	BC = new int[2];

//	AB[0] = B[0]-A[0];

	$ab_lon=$lon2-$lon1;
//	AB[1] = B[1]-A[1];
	$ab_lat=$lat2-$lat1;

	$BC_lon=$lon3-$lon2;
	$BC_lat=$lat3-$lat2;
	//BC[0] = C[0]-B[0];
//	BC[1] = C[1]-B[1];
	// int $dot = AB[0] * BC[0] + AB[1] * BC[1];
	$dot = $ab_lon * $BC_lon + $ab_lat  * $BC_lat;
	return $dot;
}

// finds cross track error in meters and closest point p4 between p3 and
// desired track p1-p2.
// very slow function!
/*
Cross track error:

Suppose you are proceeding on a great circle route from A to B (course =crs_AB) and end up at D, perhaps off course. 
You can calculate the course from A to D (crs_AD) and the distance from A to D (dist_AD) using the formulae above. 
In terms of these the cross track error, XTD, (distance off course) is given by

           XTD =asin(sin(dist_AD)*sin(crs_AD-crs_AB))

(positive XTD means right of course, negative means left)
*/
function CrossTrackError($lon1, $lat1, $lon2, $lat2,$lon3, $lat3) {
  $dot1 = dot($lon1, $lat1, $lon2, $lat2,$lon3, $lat3);
  if($dot1 > 0) {
	list($dist_BD, $tmp1 )= DistanceBearing($lat2, $lon2, $lat3, $lon3, 1,0);
	return 	$dist_BD;
  }  
  $dot2 = dot($lon2, $lat2, $lon1, $lat1 ,$lon3, $lat3);
  if($dot2 > 0) {
    list($dist_AD, $crs_AD)= DistanceBearing($lat1, $lon1, $lat3, $lon3, 1,1);
	return $dist_AD;
  }

  list($dist_AD, $crs_AD)= DistanceBearing($lat1, $lon1, $lat3, $lon3, 1,1);
  $dist_AD/= (RAD_TO_DEG * 111194.9267); 
  $crs_AD*= DEG_TO_RAD;

 // list($dist_AB, $crs_AB)=  DistanceBearing($lat1, $lon1, $lat2, $lon2, 1,1);
  list($tmp1, $crs_AB)=  DistanceBearing($lat1, $lon1, $lat2, $lon2,0,1);
 // DEBUG("a1",1,"dist_AB : $dist_AB dist_AD:$dist_AD ");
  //$dist_AB_m=  $dist_AB;
  //$dist_AB/= (RAD_TO_DEG * 111194.9267); 
  $crs_AB*= DEG_TO_RAD;



 // $lat1 *= DEG_TO_RAD;
 // $lat2 *= DEG_TO_RAD;
 // $lat3 *= DEG_TO_RAD;
 // $lon1 *= DEG_TO_RAD;
 // $lon2 *= DEG_TO_RAD;
 // $lon3 *= DEG_TO_RAD;

 // double XTD; // cross track distance
 // double ATD; // along track distance

  //  The "along track distance", ATD, the distance from A along the
  //  course towards B to the point abeam D

  $sindist_AD = sin($dist_AD);

  $XTD = asin($sindist_AD*sin($crs_AD-$crs_AB));


  //$sinXTD = sin($XTD);
  //$ATD = asin(sqrt( $sindist_AD*$sindist_AD - $sinXTD*$sinXTD )/cos($XTD));
  /*
  if (lon4 && lat4) {
    IntermediatePoint(lon1, lat1, lon2, lat2, ATD, dist_AB,
		      lon4, lat4);
  }
*/
  // units
  $XTD *= (RAD_TO_DEG * 111194.9267);
 
  //$ATD *= (RAD_TO_DEG * 111194.9267);

 

/*
	//DEBUG("a1",1," XTD: $XTD , ATD: $ATD<BR>");
	if ($ATD > $dist_AB_m ) {
		list($dist_BD, $tmp1 )= DistanceBearing($lat2, $lon2, $lat3, $lon3, 1,0);
		$XTD = min($dist_AD_m ,$dist_BD);
		DEBUG("a1",1," special case: $dist_AD_m , $dist_BD<BR>");
	} else {
		DEBUG("a1",1,"XTD ($XTD) is ok ($ATD < $dist_AB_m )<BR>");
	}
*/
//   return abs($ATD);
    return abs($XTD);
}

function FindAirspaceArea($Longitude,$Latitude,$alt) {
  global $NumberOfAirspaceAreas,$AirspaceArea ;
  global $near;
  if($NumberOfAirspaceAreas == 0)  return array();

  $areas=array();
  for($i=0;$i<$NumberOfAirspaceAreas;$i++) {
    if(  $altInside=CheckAirspaceAltitude($AirspaceArea[$i]->Base->Altitude, $AirspaceArea[$i]->Top->Altitude,$alt) ) {

	  if (($Latitude  > $AirspaceArea[$i]->miny) && ($Latitude  < $AirspaceArea[$i]->maxy) &&
		  ($Longitude > $AirspaceArea[$i]->minx) && ($Longitude < $AirspaceArea[$i]->maxx)) {

		if ($AirspaceArea[$i]->Shape==1) { // area
			if (InsideAirspaceArea($Longitude,$Latitude,$i)) { 
			
			  $distanceInside=RangeAirspaceArea($Longitude,$Latitude,$i);

			  DEBUG("FindAirspaceArea",255, 
						sprintf("Inside Area [%03s] by %05sm [%03d] Point: %0.5f,%0.5f (%0.5f,%0.5f)-(%0.5f,%0.5f)<BR>",$i,floor($distanceInside),$near[4], $Longitude,$Latitude,$near[1],$near[0],$near[3],$near[2] )." ");
//			  DEBUG("FindAirspaceArea",255, "[".$near[4]."] Point: $Longitude,$Latitude segment at ".$near[4]." ". $near[1].",".$near[0]."-".$near[3].",".$near[2]."<BR>" );
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
// Final check function
/////////////////////////////////////////////////////////////////////////////////

require_once dirname(__FILE__).'/CL_gpsPoint.php';

function checkAirspace($filename) {
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

	getAirspaceFromDB($min_lon , $max_lon , $min_lat ,$max_lat);
	$NumberOfAirspaceAreas=count($AirspaceArea);
/*
	foreach($AirspaceArea as $i=>$area) {
		if ( !( $area->maxx<$min_lon || $area->minx>$max_lon ) &&
			 !( $area->maxy<$min_lat || $area->miny>$max_lat )
		) {
			if ($area->Shape==1) $shape="Area  "; else $shape="Circle";
			DEBUG("checkAirspace",1, "Found $shape [$i] => ".$area->Name.'<BR>');
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
*/
	

	//	echo '<HR>';
	// print_r($AirspaceArea);
	//	echo '<HR>';
	//	echo '<HR>';
	
	$violations=array();

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
					//echo "point [$i] INSIDE AIRSPACE areas: ";
					//foreach($insideAreas as $areaInfo) echo $AirspaceArea[$areaInfo[0]]->Name." areaID[$areaInfo[0]] disInside[$areaInfo[1]] altInside[$areaInfo[2]]  ";
					foreach($insideAreas as $areaInfo) {
						$areaID=$areaInfo[0];
						$disInside=$areaInfo[1];
						$altInside=$areaInfo[2];
						if ( $disInside > $violations[$areaID]['maxDistance']  )  $violations[$areaID]['maxDistance'] = $disInside; 
						if ( $altInside > $violations[$areaID]['maxAlt']  )  $violations[$areaID]['maxAlt'] = $altInside; 
					}
					//echo "<BR>";
				} else { 
					// echo "OK<BR>";
				}
				$i++;
		}
	}		

	$resStr='';
	$resStr1='';
	if (count($violations)>0) {
		foreach($violations as $i=>$violatedArea) {
			$resStr1.=$AirspaceArea[$i]->id.",";
			$resStr.="HorDist: ".floor($violatedArea['maxDistance'])."m, VertDist:".floor($violatedArea['maxAlt'])."m, ";
			$resStr.='Airspace: '. $AirspaceArea[$i]->Name. ' ['.$AirspaceArea[$i]->Type.'] '.floor($AirspaceArea[$i]->Base->Altitude).'-'.floor($AirspaceArea[$i]->Top->Altitude)."m\n"; // COMMENT: '.$AirspaceArea[$i]->Comment."\n";
		}
		if ($resStr1) {
			$resStr1=substr($resStr1,0,-1)."\n";
			$resStr=trim($resStr);
		}
	}
	//$m1=memory_get_usage();
	//echo "ReadAltitude: mem usage: $m1 <BR>"; 

	return $resStr1.$resStr;
}



/////////////////////////////////////////////////////////////////////////////////
// Loading airspace
/////////////////////////////////////////////////////////////////////////////////


function LoadAirspace() {
	if ( RestoreAirspace()) {
		DEBUG("checkAirspace",1,"Read airspace from dump");
		global  $AirspaceArea,$NumberOfAirspaceAreas;
		
		//print_r( $AirspaceArea);
		$NumberOfAirspaceAreas=count($AirspaceArea);
		//exit;
		return 1;
	} else {
		require_once dirname(__FILE__)."/FN_airspace_admin.php";
		// $openairFilename='Air_Germany.txt';
		// $openairFilename="OPENAIRD.TXT";
		// maxpunkte
		$openairFilename='Air_Europe 2006.txt';
		
		$fp = fopen(dirname(__FILE__)."/data/airspace/$openairFilename","r");
		if ($fp ) {
			ReadAirspace($fp);
			return 1;
		} else return 0;
	}

}

function  RestoreAirspace() {
	global $AirspaceArea;

	$filename=dirname(__FILE__)."/airspace.dump";
	if (is_file($filename)) {
		$lines=file($filename);
		$AirspaceArea=unserialize($lines[0]);
		return 1;
	}
	return 0;
}


function getAirspaceFromDB($min_lon , $max_lon , $min_lat ,$max_lat) {
	global $AirspaceArea,$NumberOfAirspaceAreas, $db,$airspaceTable ;
	$AirspaceArea=array();
	
	$query="SELECT * FROM $airspaceTable WHERE disabled=0 AND 
				 NOT ( maxx< $min_lon OR minx>$max_lon ) AND	 NOT ( maxy< $min_lat OR miny>$max_lat ) ";		 
	$res= $db->sql_query($query);
		
	if(!$res) {
		echo "Error in gettig airspace from DB: $query <BR>";
		return 0;
	}

	$i=0;
	while ($row = mysql_fetch_assoc($res)){
		if ($row['Shape']==1) $shape="Area"; else $shape="Circle";
		DEBUG("getAirspaceFromDB",1, "Found $shape => ".$row['Name'].'<BR>');
		$AirspaceArea[$i]->id		=$row['id'];		
		$AirspaceArea[$i]->Name		=$row['Name'];
		$AirspaceArea[$i]->Type		=$row['Type'];
		$AirspaceArea[$i]->Shape	=$row['Shape'];
		$AirspaceArea[$i]->Comments	=$row['Comments'];		
		$AirspaceArea[$i]->minx		=$row['minx'];
		$AirspaceArea[$i]->miny		=$row['miny'];		
		$AirspaceArea[$i]->maxx		=$row['maxx'];
		$AirspaceArea[$i]->maxy		=$row['maxy'];
		
		$AirspaceArea[$i]->Base		=unserialize($row['Base']);
		$AirspaceArea[$i]->Top		=unserialize($row['Top']);
		
		if ($row['Shape']==1) { // area
			$AirspaceArea[$i]->Points	=unserialize($row['Points']);			
		//	DEBUG("getAirspaceFromDB",1, "Area first point :  ".$AirspaceArea[$i]->Points[0]->Latitude.",".
		//			$AirspaceArea[$i]->Points[0]->Longitude.
		//			" last point :  ".$AirspaceArea[$i]->Points[count($AirspaceArea[$i]->Points)-1]->Latitude.",".
		//			$AirspaceArea[$i]->Points[count($AirspaceArea[$i]->Points)-1]->Longitude."<BR>");

			if ($AirspaceArea[$i]->Points[0] != $AirspaceArea[$i]->Points[count($AirspaceArea[$i]->Points)-1] ) {
				//DEBUG("getAirspaceFromDB",1, "Adding Last point == first point<BR>");
				$AirspaceArea[$i]->Points[]	=$AirspaceArea[$i]->Points[0];
			}
			$AirspaceArea[$i]->NumPoints=count($AirspaceArea[$i]->Points);
		} else {
			$AirspaceArea[$i]->Radius		=$row['Radius'];		
			$AirspaceArea[$i]->Latitude		=$row['Latitude'];
			$AirspaceArea[$i]->Longitude	=$row['Longitude'];		
		}
		// DEBUG("getAirspaceFromDB",1,"<pre>".print_r($AirspaceArea[$i],1). "</pre><BR>");
		$i++;
	}
	$NumberOfAirspaceAreas=count($AirspaceArea);
}

function CalculateCircle($lat,$lng,$radius) {
	$Rotation=1;

	$StartBearing=0;
	$EndBearing=360-8;
	list( $StartLat,$StartLon )= FindLatitudeLongitude($lat, $lng,0,$radius,1,1);
	list( $EndLat, $EndLon)= FindLatitudeLongitude($lat, $lng,$EndBearing,$radius,1,1);

	$points=array();
	$i=0;
	$points[$i]->lat=$StartLat;
	$points[$i]->lng=$StartLon;
	$i++;
 
  while(abs($EndBearing-$StartBearing) > 10) {
	  $StartBearing += $Rotation * 10 ;

	  if($StartBearing > 360)
		  $StartBearing -= 360;
	  if($StartBearing < 0)
		  $StartBearing += 360;
	
      list($lat_temp,$lng_temp)= FindLatitudeLongitude($lat, $lng, $StartBearing, $radius, 1,1 );
	  $points[$i]->lat=$lat_temp;
	  $points[$i]->lng=$lng_temp;
	  $i++;
  }

	$points[$i]->lat=$EndLat;
	$points[$i]->lng=$EndLon;
	$i++;
	$points[$i]->lat=$StartLat;
	$points[$i]->lng=$StartLon;
	return $points;
}

?>
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
// $Id: FN_UTM.php,v 1.2 2008/11/29 22:46:06 manolis Exp $                                                                 
//
//************************************************************************

   function calc_distance($lat1, $lon1,$lat2, $lon2) { // in metern 
	  // echo "calc_distance : ".$lat1." ".$lon1." ".$lat2." ".$lon2."<br>";
  	  $pi_div_180 = M_PI/180.0;
      $d_fak = 6371000.0;  // FAI Erdradius in Metern 
//      $d_fak = 6378137.0;
 //     $d_fak = 6356752.0;
	  //  Radius nautischen Meilen: ((double)1852.0)*((double)60.0)*((double)180.0)/((double)M_PI); 
      $d2    = 2.0;
      $latx = $lat1 * $pi_div_180; 
	  $lonx = $lon1 * $pi_div_180;
      $laty = $lat2 * $pi_div_180; 
	  $lony = $lon2 * $pi_div_180;
      $sinlat = sin(($latx-$laty)/$d2);
      $sinlon = sin(($lonx-$lony)/$d2);
      return $d2*asin(sqrt( $sinlat*$sinlat + $sinlon*$sinlon*cos($latx)*cos($laty)))*$d_fak;
   }

global  $EQ_RAD, $f, $ECC2, $ECC4, $ECC6, $ECC, $e1, $t_e2, $t_c1, $t_c2, $t_c3, $t_c4, $t_ic1, $t_ic2, $t_ic3, $t_ic4, $central_meridian,$map_scale_factor,$D2R ,$R2D;
$EQ_RAD= $f= $ECC2= $ECC4= $ECC6= $ECC= $e1= $t_e2= $t_c1= $t_c2= $t_c3= $t_c4= $t_ic1= $t_ic2= $t_ic3= $t_ic4= $central_meridian=0 ;

$D2R= M_PI / 180.0;
$R2D = 180.0 / M_PI;
// FOR  WGS84
$EQ_RAD = 6378137; // 	Equatorial Radius, meters 
// $f=1/297.257223563; // flattening;
$f=0.00335281067183099;
$map_scale_factor=0.9996;
$workingUTMzone=-1;

$NORTH=1;

/*
$lat=40.5010914;  // COMPEGPS x=  653978 NORTH => +   MINE => x=654040.35162953 y=4486678.0482354
$lon=22.8171769;  // y= 4484962 EAST => +   WEST =>-
list($x,$y,$zone,$latzone)=utm($lon,$lat);

echo "lon=".$lon." lat=".$lat." --><br>";
echo "x=$x , y=$y, zone=$zone latzone=$latzone <br>";


$x=653978;
$y=4484962;
$zone=34;

$x=768521;
$y=6635652;
$zone=55;
$latzone="J";
list($lon,$lat)=iutm($x,$y,$zone,$latzone);
echo "<br> x=$x , y=$y, zone=$zone    --> <br>";
echo "lon=".$lon." lat=".$lat."<br>";
*/

function d_sqrt($x) {
	return	( ($x<0) ? 0 : sqrt ($x) );
}

function copysign($x,$y) {
	return ( ($y < 0) ? -abs($x) : abs($x)) ;
}

function vtm ($lon0) {
	global $EQ_RAD, $f, $ECC2, $ECC4, $ECC6, $ECC, $e1, $t_e2, $t_c1, $t_c2, $t_c3, $t_c4, $t_ic1, $t_ic2, $t_ic3, $t_ic4, $central_meridian ,$map_scale_factor,$D2R;
	// Set up an TM projection  
	
	$ECC2 = 2 * $f - $f * $f;
	$ECC4 = $ECC2 * $ECC2;
	$ECC6 = $ECC2 * $ECC4;
	$ECC = d_sqrt ($ECC2);

	$e1 = (1.0 - d_sqrt (1.0 - $ECC2)) / (1.0 + d_sqrt (1.0 - $ECC2));
	$t_e2 = $ECC2 / (1.0 - $ECC2);
	$t_c1 = (1.0 - 0.25 * $ECC2 - 3.0 * $ECC4 / 64.0 - 5.0 * $ECC6 / 256.0);
	$t_c2 = (3.0 * $ECC2 / 8.0 + 3.0 * $ECC4 / 32.0 + 45.0 * $ECC6 / 1024.0);
	$t_c3 = (15.0 * $ECC4 / 256.0 + 45.0 * $ECC6 / 1024.0);
	$t_c4 = (35.0 * $ECC6 / 3072.0);
	$t_ic1 = (1.5 * $e1 - 27.0 * pow ($e1, 3.0) / 32.0);
	$t_ic2 = (21.0 * $e1 * $e1 / 16.0 - 55.0 * pow ($e1, 4.0) / 32.0);
	$t_ic3 = (151.0 * pow ($e1, 3.0) / 96.0);
	$t_ic4 = (1097.0 * pow ($e1, 4.0) / 512.0);

	$central_meridian = $lon0;
}

function tm ($lon, $lat) {
	/* Convert lon/lat to TM x/y */
	global $EQ_RAD, $f, $ECC2, $ECC4, $ECC6, $ECC, $e1, $t_e2, $t_c1, $t_c2, $t_c3, $t_c4, $t_ic1, $t_ic2, $t_ic3, $t_ic4, $central_meridian,$map_scale_factor ,$D2R;
	
	$dlon = $lon - $central_meridian;
	if (abs ($dlon) > 360.0) $dlon += copysign (360.0, - $dlon);
	if (abs ($dlon) > 180.0) $dlon = copysign (360.0 - abs ($dlon), -$dlon);
	
	$lat *= $D2R;
	$M = $EQ_RAD * ($t_c1 * $lat - $t_c2 * sin (2.0 * $lat)
		+ $t_c3 * sin (4.0 * $lat) - $t_c4 * sin (6.0 * $lat));

	if ( abs ($lat) == M_PI_2) {
		$x = 0.0;
		$y = $map_scale_factor * $M;
	}
	else {
		$N = $EQ_RAD / d_sqrt (1.0 - $ECC2 * pow (sin ($lat), 2.0));
		$tan_lat = tan ($lat);
		$cos_lat = cos ($lat);
		$T = $tan_lat * $tan_lat;
		$T2 = $T * $T;
		$C = $t_e2 * $cos_lat * $cos_lat;
		$A = $dlon * $D2R * $cos_lat;
		$A2 = $A * $A;	
		$A3 = $A2 * $A;	
		$A5 = $A3 * $A2;
		$x = $map_scale_factor * $N * ($A + (1.0 - $T + $C) * ($A3 * 0.16666666666666666667)
			+ (5.0 - 18.0 * $T + $T2 + 72.0 * $C - 58.0 * $t_e2) * ($A5 * 0.00833333333333333333));
		$A3 *= $A;	$A5 *= $A;
		$y = $map_scale_factor * ($M + $N * tan ($lat) * (0.5 * $A2 + (5.0 - $T + 9.0 * $C + 4.0 * $C * $C) * ($A3 * 0.04166666666666666667)
			+ (61.0 - 58.0 * $T + $T2 + 600.0 * $C - 330.0 * $t_e2) * ($A5 * 0.00138888888888888889)));
	}

	return array($x,$y);
}


function itm ($x, $y) {
	// Convert TM x/y to lon/lat 
	global $EQ_RAD, $f, $ECC2, $ECC4, $ECC6, $ECC, $e1, $t_e2, $t_c1, $t_c2, $t_c3, $t_c4, $t_ic1, $t_ic2, $t_ic3, $t_ic4, $central_meridian,$map_scale_factor ,$D2R ,$R2D ;	
	
	$M = $y / $map_scale_factor;
	$mu = $M / ($EQ_RAD * $t_c1);
	$phi1 = $mu + $t_ic1 * sin (2.0 * $mu) + $t_ic2 * sin (4.0 * $mu)
		+ $t_ic3 * sin (6.0 * $mu) + $t_ic4 * sin (8.0 * $mu);
	$cos_phi1 = cos ($phi1);
	$tan_phi1 = tan ($phi1);
	$C1 = $t_e2 * $cos_phi1 * $cos_phi1;
	$C12 = $C1 * $C1;
	$T1 = $tan_phi1 * $tan_phi1;
	$T12 = $T1 * $T1;
	$tmp = 1.0 - $ECC2 * (1.0 - $cos_phi1 * $cos_phi1);
	$tmp2 = d_sqrt ($tmp);
	$N1 = $EQ_RAD / $tmp2;
	$R1 = $EQ_RAD * (1.0 - $ECC2) / ($tmp * $tmp2);
	$D = $x / ($N1 * $map_scale_factor);
	$D2 = $D * $D;	
	$D3 = $D2 * $D;	
	$D5 = $D3 * $D2;
	
	$lon = $central_meridian + $R2D * ($D - (1.0 + 2.0 * $T1 + $C1) * ($D3 * 0.16666666666666666667) 
		+ (5.0 - 2.0 * $C1 + 28.0 * $T1 - 3.0 * $C12 + 8.0 * $t_e2 + 24.0 * $T12)
		* ($D5 * 0.00833333333333333333)) / cos ($phi1);
	$D3 *= $D;	
	$D5 *= $D;
	$lat = $phi1 - ($N1 * tan ($phi1) / $R1) * (0.5 * $D2 -
		(5.0 + 3.0 * $T1 + 10.0 * $C1 - 4.0 * $C12 - 9.0 * $t_e2) * ($D3 * 0.04166666666666666667)
		+ (61.0 + 90.0 * $T1 + 298 * $C1 + 45.0 * $T12 - 252.0 * $t_e2 - 3.0 * $C12) * ($D5 * 0.00138888888888888889));
	$lat *= $R2D;

	return array($lon,$lat);
}


/*
 *	TRANSFORMATION ROUTINES FOR THE UNIVERSAL TRANSVERSE MERCATOR PROJECTION (UTM)
 */
 
function initUTM ($UTMzone) {
	global $workingUTMzone;
	if ($UTMzone != $workingUTMzone ) {
		$lon0 = 180.0 + 6.0 * $UTMzone - 3.0;
		if ($lon0 >= 360.0) $lon0 -= 360.0;
		vtm($lon0);	/* Central meridian for this zone */
		$workingUTMzone=$UTMzone ;
	}
}

function utm($lon, $lat) {
	/* Convert lon/lat to UTM x/y */
	global $NORTH;
	global $workingUTMzone;

	// compute UTMzone
	list($UTMzone,$UTMlatZone)=getUTMzone($lon, $lat);
	//echo "$".$UTMzone."$";
	if ($UTMzone != $workingUTMzone ) initUTM($UTMzone) ;

	if ($lon < 0.0) $lon += 360.0;
	list($x,$y)= tm($lon, $lat);
	$x += 500000.0;
	if ($lat<0) $y += 10000000.0;	/* For S hemisphere, add 10^6 m */
	return array($x,$y,$UTMzone,$UTMlatZone);
}

function iutm($x, $y, $UTMzone,$UTMlatZone) {
	/* Convert UTM x/y to lon/lat */
	global $NORTH;
	global $workingUTMzone;

	if ($UTMzone != $workingUTMzone ) initUTM($UTMzone) ;

	$x -= 500000.0;

	//if ( $lat<0 ) $y -= 10000000.0;
	if ( ord( strtoupper($UTMlatZone) )  < ord ("N") ) 	$y -= 10000000.0;  // we are south
	list($lon,$lat) =itm ($x, $y);
	return array ($lon,$lat);
}

function getUTMzone($lon, $lat)  {
	if ($lon < 0.0) $lonTmp = 180 + $lon ;
	else $lonTmp = 180 + $lon ;

	$UTMlatZones=array(-9 =>'D' , -8=> 'E' ,-7=> 'F' ,-6=> 'G' ,-5=> 'H' ,-4=> 'J' ,-3=> 'K' ,-2=> 'L', -1=> 'M',0=>'-' ,'N' ,'P' ,'Q' ,'R' ,'S', 'T' ,'U' ,'V' ,'W' );

	if (abs($lat)<=72) { 
		if ( $lat>=0) $latZoneNum=floor($lat/8 + 1);
		else $latZoneNum=ceil($lat/8 - 1);
		$UTMlatZone=$UTMlatZones[$latZoneNum];
	} else $UTMlatZone="";
	$UTMzone=ceil($lonTmp/6);
	return array($UTMzone,$UTMlatZone);
}
function getInvLatUTMzone($letter)  {
	$UTMlatZones=array('D'=>0, 'E'=>1,'F'=>2 ,'G'=>3 ,'H'=>4 ,'J'=>5 ,'K'=>6 ,'L'=>7, 
			   'M'=>8,'N'=>9 ,'P'=>10 ,'Q'=>11 ,'R'=>12 ,'S'=>13, 'T'=>14 ,'U'=>15 ,'V'=>16 ,'W'=>17);
	//echo $letter."#".$UTMlatZones[$letter]."#";
	return $UTMlatZones[$letter]+0;
}

function getUTMZoneWidth($lat) {
// central meridian of zone ?
	$central=0;
	$zone_distance= calc_distance($lat, $central,$lat, $central+6);
	DEBUG("UTM",64,"Zone_distance at lat: $lat = $zone_distance<br>");
    return $zone_distance;
}

?>

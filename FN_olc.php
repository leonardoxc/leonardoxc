<?
/************************************************************************/
/* Leonardo: Gliding XC Server					                                */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://sourceforge.net/projects/leonardoserver                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

function olcSubmit($flightID) {
	global $db,$olcServerURL;
	if (!$flightID) return 0;
	set_time_limit (200);

	$flight=new flight();
	$flight->getFlightFromDB($flightID);

	//	olcBirthDate,olcFirstName,olcLastName , olcCallSign, olcFilenameSuffix
	list($geb,$OLCvnolc,$na,$gid,$olcFilenameSuffix )=$flight->getOLCpilotData();
	
	// are there olc data for this pilot ?
	if ($geb=='') { echo _NO_PILOT_OLC_DATA; return 0; }
	// is the OLC score computed ?
	if (! $flight->FLIGHT_POINTS ) {echo _FLIGHT_NOT_SCORED; return 0; }
	// Are we in the valid submit window ?
	if (! $flight->insideOLCsubmitWindow() )  {echo _TOO_LATE; return 0; }
	
	
	$olcFilenameSuffix =substr($olcFilenameSuffix,0,4);
	//	we got those from the pilot profile
	$OLCvnolc=urlencode($OLCvnolc);
	$na=urlencode($na);
	$geb=urlencode($geb);  // birth date
	$gid=urlencode($gid); // call sign

	$fixedThings="spr=en&olc=holc-i&OLChelp=";
	
	// $region="GR";
	$takeoffWaypoint=new waypoint($flight->takeoffID);
	$takeoffWaypoint->getFromDB();
	$region=strtoupper($takeoffWaypoint->countryCode);

	if ($flight->cat==1)	$klasse=3; // paraglider open
	else if ($flight->cat==2)	$klasse=1; // flex FAI cat 1
	else if ($flight->cat==4)	$klasse=2; // rigid FAI cat 5
	else $klasse=3; // paraglider open - default 


	// now get flight data
	$sta=urlencode( getWaypointName($flight->takeoffID,1) ); // takeoff place
	$gty=urlencode($flight->glider); // glider
	if (!$gty) $gty="UNKNOWN";

	$m=$flight->getMonth();
	$d=$flight->getDay();
	$ft= date_julian ($d,$m, $flight->getYear() ) - 2305814 ; //date_julian (1,1, 1601);

//YMDCXXXXF.IGC
// Year value 0-9 cycling every 10 years
// month value 1-9 then A=10 B=11 C=12
// D=DAY 1-9 
// ABCDEFGHIJKLMNOPQRSTUV
// 0123456789012345678901

	$olcIncNum=$flight->numOfFlightsSubmitedThisDay() + 1 ;

	$num2let=array(1=>"1","2","3","4","5","6","7","8","9","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V");
	$y1= $flight->getYear() % 10;
	$m1= $num2let[$m+0];
	$d1= $num2let[$d+0];
	$igcfn="$y1$m1$d1".	$olcFilenameSuffix.$olcIncNum.".IGC";

	$olddirect="acdefg123"; // must be present
	// $IGCigcIGC=urlencode(  	implode ( "", file($flight->getIGCFilename() ) ) );
	$IGCigcIGC=implode ( "", file($flight->getIGCFilename() ) ) ;
// echo $IGCigcIGC;
//  echo $igcfn."###";
	$request_data="OLCvnolc=$OLCvnolc&na=$na&geb=$geb&$fixedThings&sta=$sta&gid=$gid&region=$region&ft=$ft&gty=$gty&klasse=$klasse".
			"&igcfn=$igcfn&".
			makeTurnPoint($flight->turnpoint1,0)."&".
			makeTurnPoint($flight->turnpoint2,1)."&".
			makeTurnPoint($flight->turnpoint3,2)."&".
			makeTurnPoint($flight->turnpoint4,3)."&".
			makeTurnPoint($flight->turnpoint5,4)."&".
			"t0=".makeHMS_Time($flight->FIRST_POINT)."&".
			"s0=".makeHMS_Time($flight->FIRST_POINT)."&".
			"s4=".makeHMS_Time($flight->LAST_POINT)."&".
			"olddirect=$olddirect&".
			"score=Claim+flight&".
			"IGCigcIGC=$IGCigcIGC";

	$form_method = "POST";
	$url         = parse_url($olcServerURL);
	$form_method = strtoupper($form_method);
	$request     = $form_method." ";

	$request .= $url['path']." HTTP/1.1\r\n".
				  "Host: ".$url['host']."\r\n".
				  "Content-type: application/x-www-form-urlencoded\r\n".
				  "Content-length: ".strlen($request_data)."\r\n".
				  "Connection: close\r\n\r\n". 
				  $request_data."\r\n\r\n";
	
	// Open the connection 
	$fp = fsockopen($url['host'], 80, $err_num, $err_msg, 30); 
	if ($fp) 
	{
	   // Submit form
	   fputs($fp, $request);
	   
	   // Get the response 
	   while (!feof($fp)) 
		  $response .= fgets($fp, 1024);
	   fclose($fp);
	 
		$r=str_replace("\n","",$response);
		$r=str_replace("\r","",$r);
		if ( preg_match("/For questions cite the following reference number (.*)\.<BR>/i", $r, $matches ) ) {
			$flight->olcRefNum=$matches[1];
			$flight->olcDateSubmited = date("Y-m-d H:i:s"); 
			$flight->olcFilename=$igcfn;
			$flight->putFlightToDB(1);
			
			echo _YOUR_FLIGHT_HAS_BEEN_SUCCESSFULLY_SUBMITED_TO_THE_OLC ."<BR><BR>";
			echo _THE_OLC_REFERENCE_NUMBER_IS." ".$flight->olcRefNum."<BR><BR>";
		} else { // failure so we shall display the form to let the user see the error
			echo _THERE_WAS_A_PROBLEM_ON_OLC_SUBMISSION."<BR><BR>";
			echo _LOOK_BELOW_FOR_THE_CAUSE_OF_THE_PROBLEM."<BR><BR><hr>";
			// filter the response  
			preg_match("/<form(.*)form/i", $r, $matches ); 
			$isReadyToSubmit=0;
			if( preg_match("/value\=\"Claim flight\"/i", $r ) )   { 
				echo "<b>READY TO SUBMIT</b><br><BR>";
				$isReadyToSubmit=1;
			}
			echo "<form name=olcForm ".$matches[1]."form><br>"; 
		}

	}
	else
	{
	   echo 'Could not connect to OLC server <br>';
	   return 0;
	}
	
}

function makeHMS_Time($line) {
	$seconds = substr($line,5,2);
    $minutes = substr($line,3,2);
	$hours   = substr($line,1,2);  
	return urlencode($hours.":".$minutes.":".$seconds);
}

function makeTurnPoint($string,$turnPointNum) {
	// string -> N40:29.190 E23:10.327
	//           0    1  2   3  4   5
	// $turnPointNum -> 0-4
	$tok=array();
	$i=0;
	$tok[$i] = strtok($string," :.\n\t"); 
	while ($tok[$i]) { 
	  // echo "Word=$tok[$i]<br>"; 
	   $i++;
	   $tok[$i] = strtok(" :.\n\t"); 
	} 

	$res="w".$turnPointNum."bh=".substr($tok[0],0,1)."&w".$turnPointNum."bg=".substr($tok[0],1)."&w".$turnPointNum."bm=".$tok[1]."&w".$turnPointNum."bmd=".$tok[2]."&".
		 "w".$turnPointNum."lh=".substr($tok[3],0,1)."&w".$turnPointNum."lg=".substr($tok[3],1)."&w".$turnPointNum."lm=".$tok[4]."&w".$turnPointNum."lmd=".$tok[5]."";
	return $res;
}

// Date of the flight. The value (julian date) is given as the number of days after the 1.1.1601:
// Date_of_flight_Juilian = date_julian (Date of flight) - date_julian (1,1,1601)
// date_julian (d, m, y) = d + (153 * m - 457) / 5 + 365 * y + (y / 4) - (y / 100) + (y / 400) + 1721119 
function  date_julian ($d,$m,$y) {    

 // return unixtojd (mktime(1,1,1,$m,$d,$y));   
/* jd = ( 1461 * ( y + 4800 + ( m - 14 ) / 12 ) ) / 4 +
          ( 367 * ( m - 2 - 12 * ( ( m - 14 ) / 12 ) ) ) / 12 -
          ( 3 * ( ( y + 4900 + ( m - 14 ) / 12 ) / 100 ) ) / 4 +
          d - 32075*/
/* return round($d- 32075
	+ 1461 * floor ( ( $y+ 4800 -  floor(( 14 - $m) / 12) ) / 4 )
	+ 367 * floor(( $m- 2 + ( floor(( 14 - $m) / 12) ) * 12 ) / 12)
	- 3 * floor ( floor( ( $y+ 4900 -  floor (( 14 - $m) / 12) )  / 100 ) / 4  )
		);
*/
//	return  $d + floor ( (153 * $m - 457)/5) + 365 * $y + ceil($y / 4) - ceil($y / 100) + ceil($y / 400) + 1721119  ;


	$h=12;
	$mn=0; 
	$s=0;
	
	if( $m > 2 ) {
		$jy = $y;
		$jm = $m + 1;
	} else {
		$jy = $y - 1;
		$jm = $m + 13;
	}

	$intgr = floor( floor(365.25*$jy) + floor(30.6001*$jm) + $d + 1720995 );

	//check for switch to Gregorian calendar
    $gregcal = 15 + 31*( 10 + 12*1582 );
	if( $d + 31*($m + 12*$y) >= $gregcal ) {
		$ja = floor(0.01*$jy);
		$intgr += 2 - $ja + floor(0.25*$ja);
	}
	//correct for half-day offset
	$dayfrac = $h/24.0 - 0.5;
	if( $dayfrac < 0.0 ) {
		$dayfrac += 1.0;
		$intgr--;
	}
	//now set the fraction of a day
	$frac = $dayfrac + ($mn + $s/60.0)/60.0/24.0;

    //round to nearest second
    $jd0 = ($intgr + $frac)*100000;
    $jd  = floor($jd0);
    if( $jd0 - $jd > 0.5 ) $jd++;
    return $jd/100000;


}

function olcRemove($flightID) {
	global $db,$olcServerURL;
	if (!$flightID) return 0;
	set_time_limit (200);

	$flight=new flight();
	$flight->getFlightFromDB($flightID);

	//	olcBirthDate,olcFirstName,olcLastName , olcCallSign, olcFilenameSuffix
	list($geb,$OLCvnolc,$na,$gid,$olcFilenameSuffix )=$flight->getOLCpilotData();
	
	// are there olc data for this pilot ?
	if ($geb=='') {echo _NO_PILOT_OLC_DATA; return 0;}
	// Are we in the valid submit window ?
	if (! $flight->insideOLCsubmitWindow() ) { echo _TOO_LATE; return 0;}
		
	$OLCvnolc=urlencode($OLCvnolc);
	$na=urlencode($na);
	$geb=urlencode($geb);  // birth date
	
	$fixedThings="spr=en&olc=holc-i&OLChelp=";

	// $region="GR";
	$takeoffWaypoint=new waypoint($flight->takeoffID);
	$takeoffWaypoint->getFromDB();
	$region=strtoupper($takeoffWaypoint->countryCode);

	if ($flight->cat==1)	$klasse=3; // paraglider open
	else if ($flight->cat==2)	$klasse=1; // flex FAI cat 1
	else if ($flight->cat==4)	$klasse=2; // rigid FAI cat 5
	else $klasse=3; // paraglider open - default 


	// now get flight data
	$sta=urlencode( getWaypointName($flight->takeoffID,1) ); // takeoff place
	$gty=urlencode($flight->glider); // glider
	if (!$gty) $gty="UNKNOWN";

	$m=$flight->getMonth();
	$d=$flight->getDay();
	$ft= date_julian ($d,$m, $flight->getYear() ) - 2305814 ; //date_julian (1,1, 1601);

	$igcfn=$flight->olcFilename;
	$olddirect="acdefg123"; // must be present

	$request_data="OLCvnolc=$OLCvnolc&na=$na&geb=$geb&$fixedThings&sta=$sta&gid=$gid&region=$region&ft=$ft&gty=$gty&klasse=$klasse".
			"&igcfn=$igcfn&".
			makeTurnPoint($flight->turnpoint1,0)."&".
			makeTurnPoint($flight->turnpoint2,1)."&".
			makeTurnPoint($flight->turnpoint3,2)."&".
			makeTurnPoint($flight->turnpoint4,3)."&".
			makeTurnPoint($flight->turnpoint5,4)."&".
			"t0=".makeHMS_Time($flight->FIRST_POINT)."&".
			"s0=".makeHMS_Time($flight->FIRST_POINT)."&".
			"s4=".makeHMS_Time($flight->LAST_POINT)."&".
			"olddirect=$olddirect&".
			"adminname=".$flight->olcRefNum."&".
			"wert=TRUE&".	
			"loeschen=remove+flight&";
			//"IGCigcIGC=$IGCigcIGC";

	$form_method = "POST";
	$url         = parse_url($olcServerURL);
	$form_method = strtoupper($form_method);
	$request     = $form_method." ";

	$request .= $url['path']." HTTP/1.1\r\n".
				  "Host: ".$url['host']."\r\n".
				  "Content-type: application/x-www-form-urlencoded\r\n".
				  "Content-length: ".strlen($request_data)."\r\n".
				  "Connection: close\r\n\r\n". 
				  $request_data."\r\n\r\n";
	
	// Open the connection 
	$fp = fsockopen($url['host'], 80, $err_num, $err_msg, 30); 
	if ($fp) 
	{
	   // Submit form
	   fputs($fp, $request);
	   
	   // Get the response 
	   while (!feof($fp)) 
		  $response .= fgets($fp, 1024);
	   fclose($fp);
	 
	// echo $response;

		echo _FLIGHT_SUCCESFULLY_REMOVED_FROM_OLC."<BR><BR>";

		$flight->olcRefNum="";
		$flight->olcDateSubmited = "";
		$flight->olcFilename="";
		$flight->putFlightToDB(1);
	}
	else
	{
	   echo 'Could not connect to OLC server <br>';
	   return 0;
	}
	
}

?>

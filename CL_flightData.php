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

require_once dirname(__FILE__)."/CL_gpsPoint.php";
require_once dirname(__FILE__)."/FN_kml.php";

class flight {
	var $cat=1;
	var $subcat=1;
	var $active;
	var $timesViewed;
	var $dateAdded;

	var $flightID;
	var $private=0;
    var $filename;
    var $userID;  
	var $userName="";
	
    var $comments="";  
    var $glider="";  
	var $linkURL="";
	var $takeoffID=0;
	var $takeoffVinicity=0;
	var $landingID=0;
	var $landingVinicity=0;
	

var $timezone=0;

var $DATE;
var $MAX_SPEED =0;
var $MEAN_SPEED=0 ;
var $MAX_ALT =0;
var $MIN_ALT= 0 ;
var $TAKEOFF_ALT=0;
var $LANDING_ALT=0;
var $MAX_VARIO=0 ;
var $MIN_VARIO=0 ;
var $LINEAR_DISTANCE=0 ;
var $MAX_LINEAR_DISTANCE=0 ;
var $START_TIME=0;
var $END_TIME=0; 
var $DURATION=0;  
var $BEST_FLIGHT_TYPE="";
var $FLIGHT_KM=0;
var $FLIGHT_POINTS=0;

var $FIRST_POINT="";
var $LAST_POINT="";

var $turnpoint1="";
var $turnpoint2="";
var $turnpoint3="";
var $turnpoint4="";
var $turnpoint5="";

var $olcRefNum="";
var $olcFilename="";
var $olcDateSubmited;

// CONSTANTS
var	$maxAllowedSpeed=100;
var	$maxAllowedVario=13;
var $maxAllowedHeight=9000;

var $max_allowed_time_gap=1800; //  30 mins

var $maxPointNum=1000;
//---------------
// CONSTRUCTOR
    function flight() {
		
    }

	function setAllowedParams() {
		if ($this->cat==1 ) { // PG
			$this->maxAllowedSpeed=100;
			$this->maxAllowedVario=13;
			$this->maxAllowedHeight=9000;
		} else	if ($this->cat==2 ) { // flex wing HG
			$this->maxAllowedSpeed=150;
			$this->maxAllowedVario=15;
			$this->maxAllowedHeight=9000;
		} else	if ($this->cat==4 ) { // fixed wing HG
			$this->maxAllowedSpeed=170;
			$this->maxAllowedVario=17;
			$this->maxAllowedHeight=9000;
		} else	if ($this->cat==8 ) { // glider
			$this->maxAllowedSpeed=300;
			$this->maxAllowedVario=20;
			$this->maxAllowedHeight=9000;
		}

	}

    function resetData() {
		$this->DATE="";
		$this->MAX_SPEED =0;
		$this->MEAN_SPEED=0 ;
		$this->MAX_ALT =0;
		$this->MIN_ALT= 0 ;
		$this->TAKEOFF_ALT=0;
		$this->LANDING_ALT=0;
		$this->MAX_VARIO=0 ;
		$this->MIN_VARIO=0 ;
		$this->LINEAR_DISTANCE=0 ;
		//$this->MAX_LINEAR_DISTANCE=0 ;
		$this->START_TIME=0;
		$this->END_TIME=0; 
		$this->DURATION=0;  
		//$this->BEST_FLIGHT_TYPE="";
		//$this->FLIGHT_KM=0;
		//$this->FLIGHT_POINTS=0;
		
		$this->FIRST_POINT="";
		$this->LAST_POINT="";
	}

	function is3D() {
		if ( $this->MAX_ALT ==0 && $this->MIN_ALT == 0 ) return false;
		else return true;
	}

    function getTakeoffName() {
  	    return	getWaypointName($this->takeoffID);
    }
	
    function getLandingName() {
  	    return	getWaypointName($this->landingID);
    }
	
	function getYear() {
		return substr($this->DATE,0,4);
	}

	function getOLCYear() {
		$m=$this->getMonth();
		$d=$this->getDay();
		$y=$this->getYear();

		if ( ($m==10 && $d >=12) || $m>10 ) return $y+1;
		else return $y;
	}

	function getMonth() {
		return substr($this->DATE,5,2);
	}
	function getDay() {
		return substr($this->DATE,8,2);
	}

	function getMapWindowSize() {
		$dist=max($this->LINEAR_DISTANCE ,$this->MAX_LINEAR_DISTANCE );
		if ($dist > 50 ) $mult=1.5;
		else $mult=1.7;
	    $window_size=($dist * $mult)/1000;  
	    if ( $window_size < 20 ) $window_size=20;
	    return $window_size;
	}

	function getIGCRelPath($saned=0) {
		global $flightsWebPath;
		if ($saned) $suffix=".saned.igc";
		else $suffix="";
		return $flightsWebPath."/".$this->userID."/flights/".$this->getYear()."/".rawurlencode($this->filename).$suffix;  
	}

	function getKMLRelPath() {
		global $flightsWebPath;
		return $flightsWebPath."/".$this->userID."/flights/".$this->getYear()."/".rawurlencode($this->filename).".kml";  
	}

	function getMapRelPath($num=0) {
		global $flightsWebPath;
		if ($num) $suffix="3d";
		else $suffix="";
		return $flightsWebPath."/".$this->userID."/maps/".$this->getYear()."/".rawurlencode($this->filename).$suffix.".jpg";  
	}    
	function getChartRelPath($chartType,$unitSystem=1) {
		global $flightsWebPath;
		if ($unitSystem==2) $suffix="_2";
		else $suffix="";
		return $flightsWebPath."/".$this->userID."/charts/".$this->getYear()."/".rawurlencode($this->filename).".".$chartType.$suffix.".png";  
	} 
	function getPhotoRelPath($photoNum) {
		global $flightsWebPath;
		$t="photo".$photoNum."Filename";
		return $flightsWebPath."/".$this->userID."/photos/".$this->getYear()."/".$this->$t;  
	} 

	function getIGCFilename($saned=0) {
		global $flightsAbsPath;
		if ($saned) $suffix=".saned.igc";
		else $suffix="";
		return $flightsAbsPath."/".$this->userID."/flights/".$this->getYear()."/".$this->filename.$suffix;  
	}

	function getKMLFilename() {
		global $flightsAbsPath;
		return $flightsAbsPath."/".$this->userID."/flights/".$this->getYear()."/".$this->filename.".kml";  
	}

	function getMapFilename($num=0) {
		global $flightsAbsPath;
		if ($num) $suffix="3d";
		else $suffix="";
		return $flightsAbsPath."/".$this->userID."/maps/".$this->getYear()."/".$this->filename.$suffix.".jpg";  
	}    
	function getChartFilename($chartType,$unitSystem=1) {
		global $flightsAbsPath;
		if ($unitSystem==2) $suffix="_2";
		else $suffix="";
		return $flightsAbsPath."/".$this->userID."/charts/".$this->getYear()."/".$this->filename.".".$chartType.$suffix.".png";  
	} 
	function getPhotoFilename($photoNum) {
		global $flightsAbsPath;
		$t="photo".$photoNum."Filename";
		return $flightsAbsPath."/".$this->userID."/photos/".$this->getYear()."/".$this->$t;  
	} 

	function getFlightLinkURL() {
		global $baseInstallationPath,$module_name;
		global $CONF_mainfile;
		return "http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/".$CONF_mainfile."?name=".$module_name."&op=show_flight&flightID=".$this->flightID;
	}

	function getFlightKML() {
		global $baseInstallationPath,$module_name;
		global $CONF_mainfile;
		return "http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/modules/$module_name/download.php?type=kml_trk&flightID=".$this->flightID;
	}

   //require dirname(__FILE__)."/";

	function kmlGetDescription($ext,$getFlightKML) {
		if ($this->takeoffVinicity > $takeoffRadious ) 
			$location=getWaypointName($this->takeoffID,0)." [~".sprintf("%.1f",$this->takeoffVinicity/1000)." km]"; 
		else $location=getWaypointName($this->takeoffID,0);

		if ($this->landingVinicity > $landingRadious ) 
			$location_land=getWaypointName($this->landingID,0)." [~".sprintf("%.1f",$this->landingVinicity/1000)." km]"; 
		else $location_land=getWaypointName($this->landingID,0);

		$fl_url=$this->getFlightLinkURL();
		//$fl_url=str_replace("&","&#38;",$this->getFlightLinkURL());
		//$fl_url=str_replace("&nbsp;"," ",$fl_url);

		$str="<description><![CDATA[<table cellpadding=0 cellspacing=0>".
			"<tr bgcolor='#D7E1EE'><td></td><td><div align='right'><a href='$fl_url'><b>"._See_more_details."</b></a></div></td></tr>".
			"<tr bgcolor='#CCCCCC'><td>"._PILOT."</td><td>  ".htmlspecialchars($this->userName)."</td></tr>".
			"<tr><td>"._TAKEOFF_LOCATION."</td><td> ".$location."</td></tr>".
			"<tr bgcolor='#CCCCCC'><td>"._TAKEOFF_TIME."</td><td>    ".formatDate($this->DATE,false)." - ".sec2Time($this->START_TIME,1)."</td></tr>".
			"<tr><td>"._LANDING_LOCATION."</td><td> ".$location_land."</td></tr>".
			"<tr bgcolor='#CCCCCC'><td>"._OPEN_DISTANCE."</td><td> ".formatDistance($this->LINEAR_DISTANCE,1)."</td></tr>".
			"<tr><td>"._DURATION."</td><td> ".sec2Time($this->DURATION,1)."</td></tr>".
			"<tr bgcolor='#CCCCCC'><td>"._OLC_SCORE_TYPE."</td><td> ".htmlspecialchars(formatOLCScoreType($this->BEST_FLIGHT_TYPE,false))."</td></tr>".
			"<tr><td>"._OLC_DISTANCE."</td><td> ".formatDistance($this->FLIGHT_KM,1)."</td></tr>".
			"<tr bgcolor='#CCCCCC'><td>"._OLC_SCORING."</td><td> ".sprintf("%.1f",$this->FLIGHT_POINTS)."</td></tr>".
			"<tr><td>"._MAX_SPEED."</td><td> ".formatSpeed($this->MAX_SPEED)."</td></tr>".
			"<tr bgcolor='#CCCCCC'><td>"._MAX_VARIO."</td><td> ".formatVario($this->MAX_VARIO)."</td></tr>".
			"<tr><td>"._MIN_VARIO."</td><td> ".formatVario($this->MIN_VARIO)."</td></tr>".
			"<tr bgcolor='#CCCCCC'><td>"._MAX_ALTITUDE."</td><td> ".formatAltitude($this->MAX_ALT)."</td></tr>".
			"<tr><td>"._MIN_ALTITUDE."</td><td> ".formatAltitude($this->MIN_ALT)."</td></tr>".
			"<tr bgcolor='#CCCCCC'><td>"._TAKEOFF_ALTITUDE."</td><td> ".formatAltitude($this->TAKEOFF_ALT)."</td></tr>".
			"<tr><td>"._GLIDER."</td><td>".$this->glider."</td></tr>".
			"<tr bgcolor='#D7E1EE'><td></td><td><div align='right'>"._KML_file_made_by." <a href='http://leonardo.thenet.gr'>Leonardo</a></div></td></tr>";
			if($ext) $str.=	"<tr bgcolor='#D7E1EE'><td></td><td><div align='right'>Extra analysis module by  Man\'s <a href='http://www.parawing.net'>GPS2GE V2.0</a></div></td></tr>";
			$str.="<tr bgcolor='#D7E1EE'><td></td><td><div align='right'><a href='$getFlightKML&show_url=1'>URL of this KML file</div></td></tr>";	

			$str.="</table>]]></description>";
		return $str;
	}

	function kmlGetTask(){
		$kml_file_contents="";
		$kml_file_contents.="<Folder>
		<name>OLC Task</name>";
		
		$kml_file_contents.="<Placemark>
		<name>OLC Task</name>
		<LineStyle><color>ffff0000</color></LineStyle>
		<LineString>
		<altitudeMode>extrude</altitudeMode>
		<coordinates>
		";
		
		$icons=array(
		1=>array("root://icons/palette-3.png",0,192),
		2=>array("root://icons/palette-3.png",32,192),
		3=>array("root://icons/palette-3.png",64,192),
		4=>array("root://icons/palette-3.png",96,192),
		5=>array("root://icons/palette-3.png",128,192) );
		
		$j=0;
		for($i=1;$i<=5;$i++) {
			$varname="turnpoint$i";
			if ($this->{$varname}) {
				$pointString=explode(" ",$this->{$varname});
				// make this string 
				// B1256514029151N02310255EA0000000486
				// from N40:29.151 E23:10.255
				preg_match("/([NS])(\d+):(\d+)\.(\d+) ([EW])(\d+):(\d+)\.(\d+)/",$this->{$varname},$matches);
		
				$lat=preg_replace("/[NS](\d+):(\d+)\.(\d+)/","\\1\\2\\3",$pointString[0]);
				$lon=preg_replace("/[EW](\d+):(\d+)\.(\d+)/","\\1\\2\\3",$pointString[1]);
		
				$pointStringFaked=sprintf("B125959%02d%02d%03d%1s%03d%02d%03d%1sA0000000500",$matches[2],$matches[3],$matches[4],$matches[1],
					$matches[6],$matches[7],$matches[8],$matches[5] );
		
				$newPoint=new gpsPoint( $pointStringFaked ,$this->timezone );			
				$kml_file_contents.=-$newPoint->lon.",".$newPoint->lat.",0 ";
		
				$turnpointPlacemark[$j]="
		<Placemark>
				 <Style>
				  <IconStyle>
					<scale>0.4</scale>
					<Icon>
					  <href>".$icons[$j+1][0]."</href>
					  <x>".$icons[$j+1][1]."</x>
					  <y>".$icons[$j+1][2]."</y>
					  <w>32</w>
					  <h>32</h>
					</Icon>
				  </IconStyle>
				</Style>
		 <Point>
			<coordinates>".(-$newPoint->lon).",".$newPoint->lat.",0</coordinates>
		  </Point>
		</Placemark>";
				$j++;
		
			}
		}
		
		$kml_file_contents.="
		</coordinates>
		</LineString>
		</Placemark>";
		
		for ($i=0;$i<$j;$i++) 
			$kml_file_contents.=$turnpointPlacemark[$i];
		$kml_file_contents.="</Folder>";
	
		return $kml_file_contents;
	}

	function kmlGetTrack($lineColor="ff0000",$exaggeration=1,$lineWidth=2,$extended=1) {
		global $module_name, $flightsAbsPath,$flightsWebPath, $takeoffRadious,$landingRadious;
		global $moduleRelPath,$baseInstallationPath;
		global $langEncodings,$currentlang;

		$getFlightKML=$this->getFlightKML()."c=$lineColor&ex=$exaggeration&w=$lineWidth&an=$extended";
		if ($extended) {
			$kml_file_contents.="<Placemark >\n<name>".$this->filename."</name>".$this->kmlGetDescription($extended,$getFlightKML)."</Placemark>";
			$kml_file_contents.=kmlGetTrackAnalysis($this->getIGCFilename(0),$exaggeration);
			return $kml_file_contents;
		}

		//if (file_exists($this->getKMLFilename())) return;
		$KMLlineColor="ff".substr($lineColor,4,2).substr($lineColor,2,2).substr($lineColor,0,2);
		
		$filename=$this->getIGCFilename(0);  
		$lines = file ($filename); 
		if (!$lines) return;
		$i=0;

		$kml_file_contents.="<Placemark >\n<name>".$this->filename."</name>".$this->kmlGetDescription($extended,$getFlightKML);

		$kml_file_contents.=
		"<Style>
			<LineStyle>
			  <color>".$KMLlineColor."</color>
			  <width>$lineWidth</width>
			</LineStyle>
		  </Style>
		";

		$kml_file_contents.=
		"<LineString>
		<altitudeMode>absolute</altitudeMode>
		<coordinates>";

		//$kml_file_contents=str_replace("&","&#38;",$kml_file_contents);
		// $kml_file_contents=utf8_encode(str_replace("&nbsp;"," ",$kml_file_contents));
		$kml_file_contents=str_replace("&nbsp;"," ",$kml_file_contents);

		foreach($lines as $line) {
			$line=trim($line);
			if  (strlen($line)==0) continue;				
			if ($line{0}=='B') {
					if  ( strlen($line) < 23 ) 	continue;
					$thisPoint=new gpsPoint($line,$this->timezone);
					$data_alt[$i]=$thisPoint->getAlt();				
					if ( $thisPoint->getAlt() > $this->maxAllowedHeight ) continue;
					$kml_file_contents.=-$thisPoint->lon.",".$thisPoint->lat.",".($thisPoint->getAlt()*$exaggeration)." ";
					$i++;
					if($i % 50==0) $kml_file_contents.="\n";
			}
		}

		$kml_file_contents.="</coordinates>\n</LineString>";
		$kml_file_contents.="</Placemark>";
		
		return $kml_file_contents;
	}

	function createKMLfile($lineColor="ff0000",$exaggeration=1,$lineWidth=2,$extendedInfo=0) {
		global $module_name, $flightsAbsPath,$flightsWebPath, $takeoffRadious,$landingRadious;
		global $moduleRelPath,$baseInstallationPath;
		global $langEncodings,$currentlang;

		//if (file_exists($this->getKMLFilename())) return;

		//UTF-8 or 
		//".$langEncodings[$currentlang]."
		$kml_file_contents=
			"<?xml version='1.0' encoding='".$langEncodings[$currentlang]."'?>
			<kml xmlns=\"http://earth.google.com/kml/2.0\">
			<Folder>
			<open>1</open>";
			
		/*<LookAt>
			<longitude>-3.10135108046447</longitude>
			<latitude>52.9733850011146</latitude>
			<range>3000</range>
			<tilt>65</tilt>
			<heading>227.735584972338</heading>
		</LookAt>*/

	    $kml_file_contents.=$this->kmlGetTrack($lineColor,$exaggeration,$lineWidth,$extendedInfo);
		

		// create the start and finish points
		$kml_file_contents.=makeWaypointPlacemark($this->takeoffID);
		if ( $this->takeoffID!=$this->landingID)
			$kml_file_contents.=makeWaypointPlacemark($this->landingID);
	
		// create the OLC task
		$kml_file_contents.=$this->kmlGetTask();

		$kml_file_contents.="</Folder>\n</kml>";


		return $kml_file_contents;
	}

	function getAltValues() {
		global $flightsAbsPath;
		$this->setAllowedParams();

		$max_allowed_alt_diff=400;
		$max_allowed_speed_diff=70;
		$max_allowed_vario_diff=15;


		$data_time =array();
		$data_alt =array();
		$data_speed =array();
		$data_vario =array();
		$data_takeoff_distance=array();

		$filename=$this->getIGCFilename(1);  
		$lines = @file ($filename); 
		if (!$lines) return;
		$i=0;
		$day_offset =0; 

		foreach($lines as $line) {
			$line=trim($line);
			if  (strlen($line)==0) continue;				
			if ($line{0}=='B') {
					if  ( strlen($line) < 23 ) 	continue;
					$thisPoint=new gpsPoint($line,$this->timezone);
					$thisPoint->gpsTime+=$day_offset;
					$data_time[$i]=sec2Time($thisPoint->getTime(),1);
					$data_alt[$i]=$thisPoint->getAlt();				
					if ( $data_alt[$i] > $this->maxAllowedHeight ) continue;

					if ($i>0) {						
						$tmp = $lastPoint->calcDistance($thisPoint);			
						if ( ($lastPoint->getTime() - $thisPoint->getTime()  ) > 3600 )  { // more than 1 hour
                    		$day_offset = 86400; // if time seems to have gone backwards, add a day
		                    $thisPoint->gpsTime += 86400;
        		        } else if ( ($lastPoint->getTime() - $thisPoint->getTime()  ) > 0 ) {
							$lastPoint=new gpsPoint($line,$this->timezone);
							$lastPoint->gpsTime+=$day_offset;
							 continue;
						}	
						$deltaseconds = $thisPoint->getTime() - $lastPoint->getTime() ;	
						if ($deltaseconds) {
							$speed = ($deltaseconds)?$tmp*3.6/($deltaseconds):0.0; /* in km/h */
							$data_vario[$i] =($thisPoint->getAlt() - $lastPoint->getAlt() ) / $deltaseconds;
						} else {
							$speed =0;
							$data_vario[$i]=0;
						}
						// sanity checks	
						if ( $speed > $this->maxAllowedSpeed ) continue;
						if ( $data_vario[$i]  > $this->maxAllowedVario ) continue;

						$data_speed[$i]=$speed;
						$data_takeoff_distance[$i] = $takeoffPoint->calcDistance($thisPoint) /1000;
					}	else  {
						$data_speed[$i]=0;
						$data_vario[$i]=0;
						$takeoffPoint=new gpsPoint($line,$this->timezone);
						$data_takeoff_distance[$i]=0;
					}
					$lastPoint=new gpsPoint($line,$this->timezone);
					$lastPoint->gpsTime+=$day_offset;
					$i++;
			} 
		}

		return array($data_time,$data_alt,$data_speed,$data_vario,$data_takeoff_distance);
	}

	function getXYValues() {
		global $flightsAbsPath;

		$data_X =array();
		$data_Y =array();

		$filename=$this->getIGCFilename(1);  
		$lines = file ($filename); 
		$i=0;

		foreach($lines as $line) {
			$line=trim($line);
			if  (strlen($line)==0) continue;				
			if ($line{0}=='B') {
					$thisPoint=new gpsPoint($line,$this->timezone);
					$data_X[$i]=$thisPoint->lat;
					$data_Y[$i]=$thisPoint->lon;
					$i++;
			} 
		}
		return array($data_X,$data_Y);
	}

	function getNextPointPos($pointArray,$currentPos){
		for($i=$currentPos+1;$i<count($pointArray);$i++) {
			if ($pointArray[$i]{0}=='B') return $i;
		}
		return $i;
	}

	function getPrevPointPos($pointArray,$currentPos){
		for($i=$currentPos-1;$i>0;$i--) {
			if ($pointArray[$i]{0}=='B') return $i;
		}
		return $i;
	}

	function getFlightFromIGC($filename) {
	set_time_limit (100);
	$this->resetData();
	$this->setAllowedParams();
	$this->filename=basename($filename);
	
	$done=0;
	$try_no_takeoff_detection=0;	
	while(!$done) {	
	
		$lines = file ($filename); 
		$linesNum =count($lines);
		DEBUG("IGC",1,"File has total $linesNum lines<br>");
		$points=0;
		$outputBuffer="";

		// process points
		// filter bad ones
		$p=0;
		$Brecords=0;
		$getPointsNum=5 ; // + 4 points + this one 
		for($i=0;$i< count($lines)-10 ;$i++) {		
			$pointOK=1;
			$line=trim($lines[$i]);
			if  (strlen($line)==0) continue;
			if  ( $line{0}!='B' ) continue;
			$Brecords++;
			if  ( strlen($line)  < 23 ) { 
				$lines[$i]{1}='X';
				continue;
			}
			$neighboors=array();
			$nextPointPos=$i;
			for ($t1= 0 ;$t1 <  $getPointsNum ;$t1++ ) {
				$thisPoint=new gpsPoint( trim($lines[$nextPointPos]) ,$this->timezone );
				$neighboors[$t1] = $thisPoint;

				$nextPointPos=$this->getNextPointPos($lines,$nextPointPos);				
			} // got all next points

			// find mean values
			$mean_speed=0;
			$mean_vario=0;
			for ($t1= 1 ;$t1 < $getPointsNum ;$t1++ ) {  // for 4 (5-1) points in a row 
					// create arrays 
					$T_distance[$t1] = $neighboors[$t1]->calcDistance($neighboors[$t1-1]);
					$T_alt[$t1] = $neighboors[$t1]->getAlt();
					$T_deltaseconds[$t1] = $neighboors[$t1]->getTime() -  $neighboors[$t1-1]->getTime() ;						
					$T_speed[$t1] = ($T_deltaseconds[$t1])?$T_distance[$t1]*3.6/($T_deltaseconds[$t1]):0.0; /* in km/h */
					if ($T_deltaseconds[$t1]) $T_vario[$t1]=($T_alt[$t1]-$neighboors[$t1-1]->getAlt() ) / $T_deltaseconds[$t1];

					$mean_speed+=$T_speed[$t1];
					$mean_vario+=$T_vario[$t1];
			}
			$mean_speed = $mean_speed/($getPointsNum-1);
			$mean_vario = $mean_vario/($getPointsNum-1); // mean vario is wrong

			if ( ($neighboors[0]->getTime() - $neighboors[1]->getTime()  ) > 0   )  {  // the next point is more than one hour in the past
				 	// echo "#"; $pointOK=0;
			}

			if ($T_distance[1] < 0.5) {  // less than 0.5 m distance
			 	$pointOK=0;
				DEBUG("IGC",8,"[$Brecords-$p] Distance <0.5 m <br>");
				$REJ_T_distance++;

				// we dont go through the other tests
				//echo "{$lines[$i]} =>";
				$lines[$i]{1}='X';
				//echo "{$lines[$i]}<br>";
				continue;
				//echo $T_distance[1]."*<br>";
			}
			if ( abs ($mean_speed - $T_speed[1] ) > 40 ) { // diff more than 40 km/h
				$pointOK=0;
				$REJ_T_mean_speed++;
				DEBUG("IGC",8,"[$Brecords-$p] Mean speed > 40 km/h <br>");
				//echo "@";
			}
			//if ( abs ($mean_vario - $T_vario[1] ) > 6 ) {  // diff more than 6 m/sec
			//	$pointOK=0; 
				//echo "#";
			//}
			if ( $T_deltaseconds[1] == 0 ) {  
				$pointOK=0; 
				$REJ_T_zero_time_diff++;
				DEBUG("IGC",8,"[$Brecords-$p] No time Diff<br>");
			}
			if ( $T_alt[1]   > $this->maxAllowedHeight ) {  $pointOK=0;	$REJ_max_alt++; }
			if ( abs($T_speed[1])  > $this->maxAllowedSpeed ) { 
				 $pointOK=0; 
				 $REJ_max_speed++;
				 DEBUG("IGC",8,"[$Brecords-$p] > ".abs($T_speed[1])."km/h max allowed speed<br>");
				// echo "S"; 
			}
			if ( abs($T_vario[1])  > $this->maxAllowedVario ) {  $pointOK=0; $REJ_max_vario++;
				// echo "V";
			}
			if ( $p<5 && ! $try_no_takeoff_detection) { // first 10 points need special care 
				$takeoffMaxSpeed=$this->maxAllowedSpeed *0.5;
				DEBUG("IGC",8,"[$Brecords-$p] TAKEOFF sequence SPEED: ".abs($T_speed[1])." max:$takeoffMaxSpeed<br>");
				if ( abs($T_speed[1])  > $takeoffMaxSpeed ) {  
					$pointOK=0;	
					$REJ_max_speed_start++;
					// echo "s"; 
				}
				if ( abs($T_vario[1])  > ($this->maxAllowedVario *0.4) ) {  
					$pointOK=0; 
					$REJ_max_vario_start++;
					//echo "v"; 
				}
			}
			if (!$pointOK)  {
				$lines[$i]{1}='X';
			} else  {
				$p++;
				if ($p==5) DEBUG("IGC",1,"Passed the strict testing (p=5)<br>");
			}

		}


		DEBUG("IGC",1,"REJ: [$REJ_T_distance] <0.5 distance<br>");
		DEBUG("IGC",1,"REJ: [$REJ_T_zero_time_diff] zero_time_diff<br>");
		DEBUG("IGC",1,"REJ: [$REJ_T_mean_speed] mean_speed diff >40km/h<br>");
		DEBUG("IGC",1,"REJ: [$REJ_max_alt] >max_alt<br>");
		DEBUG("IGC",1,"REJ: [$REJ_max_speed] >max_speed<br>");
		DEBUG("IGC",1,"REJ: [$REJ_max_vario] >max_vario<br>");
		DEBUG("IGC",1,"REJ: [$REJ_max_speed_start] >max_speed_start<br>");
		DEBUG("IGC",1,"REJ: [$REJ_max_vario_start] >max_vario_start<br>");

		DEBUG("IGC",1,"Found $p valid B records out of $Brecords total<br>");
		
		if ($p>0) {
			$done=1;
		} else if ( $REJ_T_zero_time_diff/$Brecords > 0.9) { // more than 90% stopped points
			$lines = file ($filename); 
			$done=1;
			$garminSpecialCase=1;
			$p=$Brecords;
			DEBUG("IGC",1,"Many Stopped points, it is a Garmin Special Case<br>");
		} else if (	!$try_no_takeoff_detection ) {
			$try_no_takeoff_detection=1; 
			DEBUG("IGC",1,"Will try no_takeoff_detection<br>");
		} else { 
			$done=1;
		}
		
	} // while not done

		//	 
		if ($p==0)  {
			echo "NO VALID POINTS FOUND";
			return 0; // no valid points found
		}

		$mod=0;
		if ($p > $this->maxPointNum ){
			$mod= ceil( $p / $this->maxPointNum );
		}
		DEBUG("IGC",1,"will use a mod of $mod<br>");

		$alreadyInPoints=0;
		$stopReadingPoints=0;
		$this->timezone=1000;
		$day_offset =0;
		$foundNewTrack=0;

		$slow_points=0;
		$slow_points_dt=0;
		$stillOnGround=1;
		
		foreach($lines as $line) {
			if ($foundNewTrack) break;
			$outputLine=$line;
			$line=trim($line);
			if  (strlen($line)==0) continue;
			
			if (strtoupper(substr($line,0,5)) =="HFDTE"  || strtoupper(substr($line,0,5)) =="HPDTE"  ) {  // HFDTE170104  OR HPDTE310805
				if ( $alreadyInPoints && $points>0 ) {
					if ( $prevPoint->gpsTime < 86200 ) {
						// if last good point is > 86200 (200 secs before day change at 86400) we dont treat this as a new track					
						$stopReadingPoints=1;
						DEBUG("IGC",1,"[$points] $line<br>");
						DEBUG("IGC",1,"[$points] Found a new track (NEW HFDTE)<br>");
					}
				} else {

					$this->DATE=substr($line,5,6);
					$yr_last=substr($this->DATE,4,2);
					// case of YY=0 (1 digit) HFDTE08070 
					if ($yr_last=="0") $yr_last="00";
					if ($yr_last > 80 ) $yr="19".$yr_last;
					else $yr="20".$yr_last;
					$this->DATE=$yr."-".substr($this->DATE,2,2)."-".substr($this->DATE,0,2);				

					$alreadyInPoints=1;
				}
			} else if (strtoupper(substr($line,0,13)) =="HFTZOTIMEZONE" ) {  // HFTZOTimezone:3 OR HFTZOTimezone:-8  
				$this->timezone=substr($line,14)+0;
				// echo $this->timezone."#^^";
			} else if (strtoupper(substr($line,2,13)) =="GTYGLIDERTYPE" ) {  
				// HOGTYGLIDERTYPE: Gradient Bliss 26  OR  HPGTYGliderType:Gradient Nevada 
				$this->glider=trim(substr($line,16));
				// HFGTYGLIDERTYPE
				// HOGTYGLIDERTYPE
			} else 	if ($line{0}=='B' ) {
				if ($stopReadingPoints ) continue;
				if ($line{1}=='X') continue ; // MARKED BAD from BEFORE 
				if  ( strlen($line) < 23 || strlen($line) > 100  ) continue;
				
				if  ($points==0)  { // first point 
					//				echo "######## first point <br>";
					$firstPoint=new gpsPoint($line,$this->timezone);
					if ($this->timezone==1000) { // no timezone in the file
						// echo "calc timezone<br>";
						$this->timezone= getUTMtimeOffset( $firstPoint->lat,$firstPoint->lon, $this->DATE );
						// echo 	$this->timezone;
						$firstPoint->timezone=$this->timezone;
					}

					// sanity checks	
					if ( $firstPoint->getAlt()  > $this->maxAllowedHeight ) continue;

					$this->FIRST_POINT=$line;
					$this->TAKEOFF_ALT= $firstPoint->getAlt();
					$this->MIN_ALT= $firstPoint->getAlt();
					$this->START_TIME = $firstPoint->getTime();
					$prevPoint=new gpsPoint($line,$this->timezone);
				} else  {					
					$lastPoint=new gpsPoint($line,$this->timezone);
					$lastPoint->gpsTime+=$day_offset;

					$time_diff= $lastPoint->getTime() - $prevPoint->getTime() ;
					// echo "time diff: $time_diff # $line<br>";
					if (  $time_diff < 0 && $time_diff > -36000  )  { // if the time is less than 10 hours in the past  we just ignore it
                    		// $day_offset = 86400; // if time seems to have gone backwards, add a day
							DEBUG("IGC",1,"[$points] $line<br>");
							DEBUG("IGC",1,"[$points] Point in the past<br>");
							continue;
        		    } else 	if ( $time_diff < 0  )  {  // CHANGING DAY , means the flight is at night
						$lastPoint=$prevPoint;
						$foundNewTrack=1;
						DEBUG("IGC",1,"[$points] $line<br>");
						DEBUG("IGC",1,"[$points] Flight at night ????<br>");
						continue;	
        		    } else 	if (  $time_diff > $this->max_allowed_time_gap  )  {  // found time gap
						$lastPoint=$prevPoint;
						$foundNewTrack=1;
						DEBUG("IGC",1,"[$points] $line<br>");
						DEBUG("IGC",1,"[$points] Found a new track (Time diff of $time_diff secs)<br>");
						continue;	
					}
				
					$this->LAST_POINT=$line;
					// compute some things
					$tmp = $lastPoint->calcDistance($prevPoint);
					$alt = $lastPoint->getAlt();
					$deltaseconds = $lastPoint->getTime() - $prevPoint->getTime() ;						
					$speed = ($deltaseconds)?$tmp*3.6/($deltaseconds):0.0; /* in km/h */
					if ($deltaseconds) $vario=($alt-$prevPoint->getAlt() ) / $deltaseconds;

					if (!$garminSpecialCase) {
						if ( ($fast_points>5 || $fast_points_dt>30) && $stillOnGround) { // found 5 flying points or 30 secs
							$stillOnGround=0;
							DEBUG("IGC",1,"[$points] $line<br>");
							DEBUG("IGC",1,"[$points] Found Takeoff <br>");
						}
										
						if ($stillOnGround) { //takeoff scan
							if ($speed > 15 ) {					
								$fast_points++;		
								$fast_points_dt+=$deltaseconds;	
								DEBUG("IGC",1,"[$points] $line<br>");
								DEBUG("IGC",1,"[$points] Found a fast speed point <br>");																
							} else {
								DEBUG("IGC",1,"[$points] $line<br>");
								DEBUG("IGC",1,"[$points] takeoff scan: speed: $speed  time_diff: $time_diff<br>");																
	
								$fast_points=0;
								$fast_points_dt=0;
							}		
							$points=0;						
							continue;			
						} else { //landing  scan
							if ($speed < 5 ) {					
								$slow_points++;		
								$slow_points_dt+=$deltaseconds;	
								DEBUG("IGC",1,"[$points] $line<br>");
								DEBUG("IGC",1,"[$points] Found a slow speed point <br>");																
							} else {
								$slow_points=0;
								$slow_points_dt=0;
							}
						}					
	
	
						if ($slow_points>5 || $slow_points_dt>300) { // found landing 5 stopped points or 5 mins (300 secs)
							$foundNewTrack=1;
							DEBUG("IGC",1,"[$points] $line<br>");
							DEBUG("IGC",1,"[$points] Found a new track  /landing <br>");
						}

					}					

					// sanity checks	
					if ( $deltaseconds == 0 && !$garminSpecialCase) {  continue; }
					if ( $alt    > $this->maxAllowedHeight ) {  continue; }
					if ( abs($speed)  > $this->maxAllowedSpeed ) {  continue; }
					if ( abs($vario)  > $this->maxAllowedVario ) {  continue; }
					
					$takeoffDistance=$lastPoint->calcDistance($firstPoint);
					if ($takeoffDistance > $this->LINEAR_DISTANCE )  $this->LINEAR_DISTANCE=$takeoffDistance;
					
					// update maximum speed
					if ($speed > $this->MAX_SPEED)  $this->MAX_SPEED=$speed;
					$this->MEAN_SPEED +=$speed;
					
					// UPDATE MIN-MAX ALT											
					if ($alt> $this->MAX_ALT) $this->MAX_ALT=$alt;
					if ($alt< $this->MIN_ALT) $this->MIN_ALT=$alt;
					
					// UPDATE MIN-MAX VARIO											
					if ($vario > $this->MAX_VARIO) $this->MAX_VARIO=$vario;
					if ($vario < $this->MIN_VARIO) $this->MIN_VARIO=$vario;
					
					// end computing					
					$prevPoint=new gpsPoint($line,$this->timezone);
					$prevPoint->gpsTime+=$day_offset;
					if ($mod>1)  {
						if ( ($points % $mod) != 0  ) $outputLine="";
					}
				}
				$points++;		   
			}  // end else 
			$outputBuffer.=$outputLine;

		} // end main loop
		
		
		$path_igc=dirname($this->getIGCFilename(1));
		if ( !is_dir($path_igc) ) {
			@mkdir($path_igc,0755);
		} 
		// write saned IGC file
		$handle=fopen($this->getIGCFilename(1),"w");
		fwrite($handle, $outputBuffer) ;
		fclose($handle);

		$this->LANDING_ALT= $lastPoint->getAlt();
		$this->END_TIME =   $lastPoint->getTime();
		$this->DURATION =   $this->END_TIME - $this->START_TIME ;
		$this->MEAN_SPEED = $this->MEAN_SPEED / $points;
				
		return 1;	
	} // end function getFlightFromIGC()


	function getOLCscore() {
		global $OLCScoringServerPath, $scoringServerActive , $OLCScoringServerPassword;
		global $baseInstallationPath;

		if (! $scoringServerActive) return 0;

		// check if scorring server is respoding (timeout = 5 secs)
 	    //get hostname from  $OLCScoringServerPath first
		preg_match("/^(http:\/\/)?([^\/]+)/i", $OLCScoringServerPath, $matches);
		$ScoringServerHostName= $matches[2]; 
		$pos = strpos( $ScoringServerHostName,":"); 
		if ($pos === false) $ScoringServerPort=80;
		else  { 
			$ScoringServerPort= substr($ScoringServerHostName,$pos+1);
			$ScoringServerHostName=substr($ScoringServerHostName,0,$pos);
		}

		// echo "#".$ScoringServerHostName."#". $ScoringServerPort ."#";
		$fp = @fsockopen ($ScoringServerHostName, $ScoringServerPort, $errno, $errstr, 3); 
		if (!$fp)  { 
			// echo "SERVER NOT ACTIVE"; 
			return 0;
		} else fclose ($fp); 

		set_time_limit (240);
		$IGCwebPath=urlencode("http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/").$this->getIGCRelPath(1);

		// $IGCwebPath=rawurlencode($IGCwebPath);
		$fl= $OLCScoringServerPath."?pass=".$OLCScoringServerPassword."&file=".$IGCwebPath;
		DEBUG("OLC_SCORE",1,"Will use URL: $fl<BR>");
		$contents = file($fl); 

		$turnpointNum=1;
		foreach(  $contents  as $line) {	
			DEBUG("OLC_SCORE",1,"LINE: $line<BR>");
			$var_name  = strtok($line,' '); 
			$var_value = strtok(' '); 
			if ($var_name{0}=='p') {
				// sample line 
				// p0181 12:45:43 N53:20.898 W 1:48.558 
				// p0181 12:45:43 N53:20.898 W12:48.558 
				preg_match("/.+ .+ ([NS][ \d][^ ]+) ([WE][ \d][^ ]+)/i",$line,$line_parts);
				$var_name="turnpoint".$turnpointNum;
				$lat= str_replace(" ","0",trim($line_parts[1]));
				$lon= str_replace(" ","0",trim($line_parts[2]));
				$var_value =$lat." ".$lon;
				$turnpointNum++;
			};
			$this->$var_name=trim($var_value);
			DEBUG("OLC_SCORE",1,"#".$var_name."=".$var_value."#<br>");
		}		
		$this->FLIGHT_KM=$this->FLIGHT_KM*1000;
	}

	function getMapFromServer($num=0) {
		global $moduleRelPath,$mapServerActive;
		if (!$mapServerActive) return;
	
		require_once $moduleRelPath."/CL_map.php";
	
		$filename=$this->getIGCFilename(1);  
		$lines = @file ($filename); 
		if (!$lines ) return; 
	
		$i=0;
	
		$min_lat=1000;
		$max_lat=-1000;
		$min_lon=1000;
		$max_lon=-1000;
	
		foreach($lines as $line) {
			$line=trim($line);
			if  (strlen($line)==0) continue;				
			if ($line{0}=='B') {
					$thisPoint=new gpsPoint($line,$this->timezone);
					if ( $thisPoint->lat  > $max_lat )  $max_lat =$thisPoint->lat  ;
					if ( $thisPoint->lat  < $min_lat )  $min_lat =$thisPoint->lat  ;
					if ( $thisPoint->lon  > $max_lon )  $max_lon =$thisPoint->lon  ;
					if ( $thisPoint->lon  < $min_lon )  $min_lon =$thisPoint->lon  ;
					$i++;
			} 
		}
		if ($i==0) return; // no B records found
	
		$lat_diff=$max_lat-$min_lat;
		$lon_diff=$max_lon-$min_lon;
	
		DEBUG("MAP",1,"MAP  min_lat: $min_lat, min_lon: $min_lon, max_lat: $max_lat, max_lon: $max_lon <BR>");	
	
		if ($lat_diff > 20 || $lon_diff > 20 ) return; // too much 
		
		list($MAP_LEFT,$MAP_TOP,$UTMzone,$UTMlatZone)=utm(-$max_lon,$max_lat);
		list($MAP_RIGHT,$MAP_BOTTOM,$UTMzone2,$UTMlatZone2)=utm(-$min_lon,$min_lat);
		
		$totalWidth1=calc_distance($min_lat, $min_lon,$min_lat, $max_lon);
		$totalWidth2=calc_distance($max_lat, $min_lon,$max_lat, $max_lon);
		$totalWidth=max($totalWidth1,$totalWidth2);
		$totalWidth_initial=$totalWidth;
		$totalHeight=$MAP_TOP-$MAP_BOTTOM;
	
		DEBUG("MAP",1,"MAP (right, left) :".$MAP_RIGHT." [".$UTMzone2."] ,".$MAP_LEFT."[".$UTMzone."]<BR>");
		DEBUG("MAP",1,"MAP (top, bottom) :".$MAP_TOP." ,".$MAP_BOTTOM."<BR>");
		DEBUG("MAP",1,"MAP (witdh,height) :".$totalWidth.",".$totalHeight."<BR>");
		
		if ($totalWidth> $totalHeight ) {  
			// Landscape  style
			DEBUG("MAP",1,"Landscape style <BR>");		
			DEBUG("MAP",1,"totalWidth: $totalWidth, totalHeight: $totalHeight, totalHeight/totalWidth: ".( $totalHeight / $totalWidth)."<br>");
			if ( $totalHeight / $totalWidth < 3/4 ) $totalHeight = (3/4) *  $totalWidth ;			
		} else { 
			// portait style
			DEBUG("MAP",1,"Portait style <BR>");
			DEBUG("MAP",1,"totalWidth: $totalWidth, totalHeight: $totalHeight, totalWidth/totalHeight: ".( $totalWidth / $totalHeight)."<br>");
			if ( $totalWidth  / $totalHeight < 3/4 )  $totalWidth  = (3/4) * $totalHeight ;
		}
	
		$marginHor=2000  + floor ( $totalWidth / 20000 ) * 1000 +  ($totalWidth - ($totalWidth_initial))/2 ;   //in meters
		$marginVert=2000 + floor ( $totalHeight / 20000 ) * 1000 + ($totalHeight - ($MAP_TOP-$MAP_BOTTOM))/2;   //in meters
	
		if ($marginHor > $marginVert ) {  
			// landscape style ...
			if ( $marginVert / $marginHor < 3/4 ) $marginVert = (3/4) *  $marginHor  ;
		} else { 
			// portait style
			if ( $marginHor / $marginVert < 3/4 )  $marginHor = (3/4) * $marginVert ;
		}
		
		DEBUG("MAP",1,"marginHor: $marginHor, marginVert:$marginVert <br>");

		$flMap=new flightMap($UTMzone,$UTMlatZone, $MAP_TOP + $marginVert, $MAP_LEFT - $marginHor,$UTMzone2, $UTMlatZone2, $MAP_BOTTOM - $marginVert ,$MAP_RIGHT +$marginHor  , 600,800,$this->getIGCFilename(1),$this->getMapFilename(0),$this->is3D() );
		DEBUG("MAP",1,"MAP Required m/pixel = ".$flMap->metersPerPixel."<br>");
		$flMap->drawFlightMap();
	
	}

	function getFlightFromDB($flightID) {
	  global $db,$prefix;
  	  global $flightsTable;
	  global $nativeLanguage,$currentlang;
	  
	  $query="SELECT * FROM $flightsTable  WHERE ID=".$flightID." ";

	  $res= $db->sql_query($query);	
	  # Error checking
	  if($res <= 0){
		 echo("<H3> Error in FlightShow query! $query</H3>\n");
		 exit();
	  }
		
	  $row = $db->sql_fetchrow($res);
	  
		$this->flightID=$flightID;
		$name=getPilotRealName($row["userID"]);
		$this->userName=$name;		 

		$this->cat=$row["cat"];		
		$this->subcat=$row["subcat"];		
		$this->active=$row["active"];		
		$this->private=$row["private"];		

		$this->timesViewed=$row["timesViewed"];		
		$this->dateAdded=$row["dateAdded"];		
		$this->timezone=$row["timezone"];		

		$this->filename=$row["filename"];
		$this->userID=$row["userID"];
		$this->comments=$row["comments"];
		
		$this->glider=$row["glider"];  
		$this->linkURL=$row["linkURL"];

		$this->photo1Filename=$row["photo1Filename"];
		$this->photo2Filename=$row["photo2Filename"];
		$this->photo3Filename=$row["photo3Filename"];

		$this->takeoffID=$row["takeoffID"];
		$this->takeoffVinicity=$row["takeoffVinicity"];
		$this->landingID=$row["landingID"];
		$this->landingVinicity=$row["landingVinicity"];
		
		$this->DATE=$row["DATE"];
		$this->MAX_SPEED =$row["MAX_SPEED"];
		$this->MEAN_SPEED =$row["MEAN_SPEED"];
		$this->MAX_ALT =$row["MAX_ALT"];
		$this->MIN_ALT =$row["MIN_ALT"];
		$this->TAKEOFF_ALT=$row["TAKEOFF_ALT"]; 
		$this->MAX_VARIO =$row["MAX_VARIO"];
		$this->MIN_VARIO =$row["MIN_VARIO"];
		$this->LINEAR_DISTANCE =$row["LINEAR_DISTANCE"];
		$this->MAX_LINEAR_DISTANCE =$row["MAX_LINEAR_DISTANCE"];
		$this->START_TIME=$row["START_TIME"];
		$this->END_TIME=$row["END_TIME"];
		$this->DURATION=$row["DURATION"];
		$this->BEST_FLIGHT_TYPE=$row["BEST_FLIGHT_TYPE"];
		$this->FLIGHT_KM=$row["FLIGHT_KM"];
		$this->FLIGHT_POINTS=$row["FLIGHT_POINTS"];	  	  

		$this->FIRST_POINT=$row["FIRST_POINT"];
		$this->LAST_POINT=$row["LAST_POINT"];

		$this->turnpoint1=$row["turnpoint1"];		
		$this->turnpoint2=$row["turnpoint2"];		
		$this->turnpoint3=$row["turnpoint3"];		
		$this->turnpoint4=$row["turnpoint4"];		
		$this->turnpoint5=$row["turnpoint5"];		

		$this->olcRefNum=$row["olcRefNum"];
		$this->olcFilename=$row["olcFilename"];
		$this->olcDateSubmited =$row["olcDateSubmited"];
		
	  	$db->sql_freeresult($res);
		$this->updateTakeoffLanding();	
	}

	function updateTakeoffLanding($waypoints=array()) {
		global $db;
		global $flightsTable;

		$firstPoint=new gpsPoint($this->FIRST_POINT,$this->timezone);
		$lastPoint=new gpsPoint($this->LAST_POINT,$this->timezone);

		// calc TAKEOFF - LANDING PLACES	
		if (count($waypoints)==0) 
			$waypoints=getWaypoints();
	
		$takeoffIDTmp=0;
		$minTakeoffDistance=1000000;
		$landingIDTmp=0;
		$minLandingDistance=1000000;
	
		foreach($waypoints as $waypoint) {
		   $takeoff_distance = $firstPoint->calcDistance($waypoint);
		   $landing_distance = $lastPoint->calcDistance($waypoint);
		   if ( $takeoff_distance < $minTakeoffDistance ) {
				$minTakeoffDistance = $takeoff_distance;
				$takeoffIDTmp=$waypoint->waypointID;
		   }
		   if ( $landing_distance < $minLandingDistance ) {
				$minLandingDistance = $landing_distance;
				$landingIDTmp=$waypoint->waypointID;
		   }
		}

		if ( $this->takeoffID!=$takeoffIDTmp || $this->takeoffVinicity!=$minTakeoffDistance ||
	   		 $this->landingID!=$landingIDTmp || $this->landingVinicity!=$minLandingDistance ) 
		{
			  $query="UPDATE $flightsTable SET takeoffID='".$takeoffIDTmp."',  takeoffVinicity=".$minTakeoffDistance.", 
					  landingID='".$landingIDTmp."', landingVinicity=".$minLandingDistance."  WHERE ID=".$this->flightID." ";
		   	  // echo $query;

			  $res= $db->sql_query($query);	
			  # Error checking
			  if($res <= 0){
				 echo("<H3> Error in Update Takeoff - landing  query! </H3>\n");
				 exit();
			  }

		}
		
		$this->takeoffID=$takeoffIDTmp;
		$this->takeoffVinicity=$minTakeoffDistance;
		$this->landingID=$landingIDTmp;
		$this->landingVinicity=$minLandingDistance;

	}

	function deletePhoto($photoNum) {
		$var_name="photo".$photoNum."Filename";
		if ( is_file($this->getPhotoFilename($photoNum) )  ) {
				@unlink($this->getPhotoFilename($photoNum) ); 
				@unlink($this->getPhotoFilename($photoNum).".icon.jpg" ); 
		}
		$this->$var_name="";
	}

	function deleteFlight() {
 		global $db;
		global $flightsTable;

		$query="DELETE from $flightsTable  WHERE ID=".$this->flightID." ";
		// echo $query;

		$res= $db->sql_query($query);	
	    # Error checking
	    if($res <= 0){
		  echo("<H3> Error in delete Flight query! </H3>\n");
		  exit();
 	    }

		// Now delete the files

		unlink($this->getIGCFilename() ); 
		@unlink($this->getIGCFilename(1) ); 
		@unlink($this->getMapFilename() ); 

		@unlink($this->getChartFilename("alt") ); 
		@unlink($this->getChartFilename("speed") ); 
		@unlink($this->getChartFilename("vario") ); 
		@unlink($this->getChartFilename("takeoff_distance") ); 		

		@unlink($this->getChartFilename("alt",2) ); 
		@unlink($this->getChartFilename("speed",2) ); 
		@unlink($this->getChartFilename("vario",2)); 
		@unlink($this->getChartFilename("takeoff_distance",2)); 		

		for($i=1;$i<=3;$i++) {
			$this->deletePhoto($i);
		}

	}

    function putFlightToDB($update=0) {
		global $db;
		global $flightsTable;

		if ($update) {
			$query="REPLACE INTO ";		
			$fl_id_1="ID,dateAdded,";
			$fl_id_2=$this->flightID.",'".$this->dateAdded."',";
			$this->active=1;
		}else {
			$query="INSERT INTO ";		
			$fl_id_1="dateAdded,";
			$fl_id_2="now(),";
			$this->active=0;
			$this->dateAdded= date("Y-m-d H:i:s"); 
			$this->timesViewed=0;
		}

		$query.=" $flightsTable (".$fl_id_1."filename,userID,
		cat,subcat,active, private ,
		comments, glider, linkURL, timesViewed,
		photo1Filename,photo2Filename,photo3Filename,
		takeoffID, takeoffVinicity, landingID, landingVinicity,
		DATE,
		timezone,
		MAX_SPEED ,
		MEAN_SPEED ,
		MAX_ALT ,
		MIN_ALT ,
		TAKEOFF_ALT, 
		MAX_VARIO ,
		MIN_VARIO ,
		LINEAR_DISTANCE ,
		MAX_LINEAR_DISTANCE ,
		START_TIME,
		END_TIME,
		DURATION,
		BEST_FLIGHT_TYPE,
		FLIGHT_KM,
		FLIGHT_POINTS,
		FIRST_POINT,LAST_POINT,
		turnpoint1,turnpoint2,turnpoint3,turnpoint4,turnpoint5,
		olcRefNum,olcFilename,olcDateSubmited
		)
		VALUES (".$fl_id_2."'$this->filename',$this->userID,  
		$this->cat,$this->subcat,$this->active, $this->private,
		'".prep_for_DB($this->comments)."', '".prep_for_DB($this->glider)."', '".prep_for_DB($this->linkURL)."', $this->timesViewed ,
		'$this->photo1Filename','$this->photo2Filename','$this->photo3Filename',
		'$this->takeoffID', $this->takeoffVinicity, '$this->landingID', $this->landingVinicity,
		'$this->DATE',
		$this->timezone,
		$this->MAX_SPEED ,
		$this->MEAN_SPEED ,
		$this->MAX_ALT ,
		$this->MIN_ALT ,
		$this->TAKEOFF_ALT, 
		$this->MAX_VARIO ,
		$this->MIN_VARIO ,
		$this->LINEAR_DISTANCE ,
		$this->MAX_LINEAR_DISTANCE ,
		$this->START_TIME,
		$this->END_TIME,
		$this->DURATION,
		'$this->BEST_FLIGHT_TYPE',
		$this->FLIGHT_KM,
		$this->FLIGHT_POINTS,
		'$this->FIRST_POINT',
		'$this->LAST_POINT',
		'$this->turnpoint1','$this->turnpoint2','$this->turnpoint3','$this->turnpoint4','$this->turnpoint5',
		'$this->olcRefNum','$this->olcFilename','$this->olcDateSubmited'
		)";
	
		//echo $query;
		$result = $db->sql_query($query);

		//echo "UPDATE / INSERT RESULT ".$result ;
		if (!$update) $this->flightID=mysql_insert_id();

	}

	function activateFlight() {
		global $db;
		global $flightsTable;

		$query="UPDATE $flightsTable SET active=1 WHERE ID=$this->flightID";
		// echo $query;
		$result = $db->sql_query($query);

		$this->active=1;
	}

	function incViews() {
		global $db;
		global $flightsTable;

		$query="UPDATE $flightsTable SET  timesViewed=timesViewed+1 WHERE ID=$this->flightID";
		// echo $query;
		$result = $db->sql_query($query);
		$this->timesViewed++;
	}

	function updateAll($forceRefresh=0) {
 	    if (  !is_file( $this->getMapFilename() ) || $forceRefresh ) {
			 $this->getMapFromServer();		
	    } 	
	    $this->updateCharts($forceRefresh);
	}

    function updateCharts($forceRefresh=0) {
		global $moduleRelPath,$chartsActive;
		if (!$chartsActive ) return 0;

	 	$alt_img_filename=$this->getChartFilename("alt"); 
		$speed_img_filename=$this->getChartFilename("speed"); 
		$vario_img_filename=$this->getChartFilename("vario"); 
		$takeoff_distance_img_filename=$this->getChartFilename("takeoff_distance");  
	
 		$alt_img_filename2=$this->getChartFilename("alt",2); 
		$speed_img_filename2=$this->getChartFilename("speed",2); 
		$vario_img_filename2=$this->getChartFilename("vario",2); 
		$takeoff_distance_img_filename2=$this->getChartFilename("takeoff_distance",2);  

		if ( !is_file($alt_img_filename) ||  !is_file($speed_img_filename) ||  
			 !is_file($vario_img_filename) ||  !is_file($takeoff_distance_img_filename) || 
			 !is_file($alt_img_filename2) ||  !is_file($speed_img_filename2) ||  
			 !is_file($vario_img_filename2) ||  !is_file($takeoff_distance_img_filename2) ||  $forceRefresh) {
	
			list ($data_time,$data_alt,$data_speed,$data_vario,$data_takeoff_distance)=$this->getAltValues();
			if (!count($data_time) ) return; // empty timeseries

			if (is_dir($moduleRelPath) ) $pre=$moduleRelPath."/";
			else $pre="";
			require_once $pre."graph/jpgraph_gradient.php";
			require_once $pre."graph/jpgraph_plotmark.inc" ;
	
			require_once $pre."graph/jpgraph.php";
			require_once $pre."graph/jpgraph_line.php";


			$this->plotGraph("Height (m)",$data_time,$data_alt,$alt_img_filename);
			$this->plotGraph("Speed (km/h)",$data_time,$data_speed,$speed_img_filename);
			$this->plotGraph("Vario (m/sec)",$data_time,$data_vario,$vario_img_filename);
			$this->plotGraph("Takeoff distance (km)",$data_time,$data_takeoff_distance,$takeoff_distance_img_filename);	

			// now make the miles/ feet versions!!!
			// convert the arrays
			// 1 kilometer = 0.62 mil
			// 1 meter  =  3.28 feet
			foreach($data_time as $idx=>$val) {
				$data_alt[$idx]=$data_alt[$idx]*3.28;
				$data_speed[$idx]=$data_speed[$idx]*0.62;
				$data_vario[$idx]=$data_vario[$idx]*3.28*60;
				$data_takeoff_distance[$idx]=$data_takeoff_distance[$idx]*0.62;
			}

			$this->plotGraph("Height (feet)",$data_time,$data_alt,$alt_img_filename2);
			$this->plotGraph("Speed (mph)",$data_time,$data_speed,$speed_img_filename2);
			$this->plotGraph("Vario (fpm)",$data_time,$data_vario,$vario_img_filename2);
			$this->plotGraph("Takeoff distance (miles)",$data_time,$data_takeoff_distance,$takeoff_distance_img_filename2);	

		}

	}

	function plotGraph($title,$data_time,$yvalues,$img_filename) {
		if (count($data_time)==0) {
			$data_time[0]=0;
			$yvalues[0]=0;
		}

		$graph = new Graph(600,200,"auto");    
		$graph->SetScale("textlin");
		
		//$graph->title->SetFont(FF_ARIAL,FS_NORMAL,10); 
		//$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,8); 
		//$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8); 
		$graph->SetMarginColor("#C8C8D4");	
		$graph->img->SetMargin(40,20,20,30);
		$graph->title->Set($title);
		$graph->xaxis->SetTextTickInterval((count($data_time)/600)*60);
		$graph->xaxis->SetTextLabelInterval(1);
		$graph->xaxis->SetTickLabels($data_time);
		$graph->xaxis->SetPos("min");
	
		$graph->xgrid->Show();
		$graph->xgrid->SetLineStyle('dashed');
		
		$lineplot=new LinePlot($yvalues);
		$graph->Add($lineplot);
		$graph->Stroke($img_filename);
	}

	function findSameFlightID() {
		global $db;
		global $flightsTable;
		$query="SELECT ID FROM $flightsTable WHERE userID=".$this->userID." AND DATE='".$this->DATE."'  AND START_TIME=".$this->START_TIME." ";
		$res= $db->sql_query($query);
		if ($res<=0) return 0; // no duplicate found

		$row = $db->sql_fetchrow($res);
		return $row["ID"]; // found duplicate retrun the ID; 
	}

	function findSameFilename($filename) {
		global $db;
		global $flightsTable;
		$query="SELECT ID FROM $flightsTable WHERE userID=".$this->userID." AND filename=".$filename." ";
		$res= $db->sql_query($query);
		if ($res<=0) return 0; // no duplicate found

		$row = $db->sql_fetchrow($res);
		return $row["ID"]; // found duplicate retrun the ID; 
	}


	function getOLCpilotData() {
		global $db;
		global $pilotsTable;
		$query="SELECT * FROM $pilotsTable WHERE pilotID=".$this->userID ;
		
		$res= $db->sql_query($query);
		if ($res<=0) return array("","","","",""); // no pilot olc data

		$row = $db->sql_fetchrow($res);
		return array($row["olcBirthDate"],$row["olcFirstName"],$row["olcLastName"],
					 $row["olcCallSign"],$row["olcFilenameSuffix"] );
		
	}
	
	function numOfFlightsSubmitedThisDay() {		
		global $db;
		global $flightsTable;

		$query="SELECT count(*) as num FROM $flightsTable WHERE userID=".$this->userID." AND DATE='".
				$this->DATE."' AND ID <> ".$this->flightID." AND olcRefNum <> '' ";

		$res= $db->sql_query($query);
		if ($res<=0) return 0; // no duplicate found

		$row = $db->sql_fetchrow($res);
		return $row["num"]; // found duplicate retrun the ID; 
	}
	
	function insideOLCsubmitWindow() {
		// submit deadline 
		//	24:00 UTC on the Tuesday following a week after the flight
		$submitDeadline=mktime(11,59,0,$this->getMonth(),$this->getDay(),$this->getYear() );
		$submitDeadline+= 7*24*60*60 ; // one week after 
		$dayOfWeek=date("w",$tm); // 0=sunday ; 1=mon 2=tuesday 3=wensday
		
		if ( $dayOfWeek <= 2 )  $submitDeadline+= (2-$dayOfWeek)* 24*60*60;
		else $submitDeadline+= (6-$dayOfWeek +3 )* 24*60*60;

		// TO BE FIXED !!!!
		// should cater for UTC time 				
		$now=mktime();
		if ($submitDeadline > $now ) return 1;
		else return 0;		
	}
	
 } // end of class
?>
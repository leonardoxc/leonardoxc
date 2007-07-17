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
require_once dirname(__FILE__)."/FN_pilot.php";

class flight {
	var $cat=1;
	var $subcat=1;
	var $category=2; // 1=sport , 2=open ,3=tandem
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
	
	var $forceBounds=0;
	
	var $validated=0;
	var $grecord=0;
	var $validationMessage="";
	var $NACclubID=0;
	
	var $airspaceCheck=0; // not yet processed
	var $airspaceCheckFinal=0; // not yet processed
	var $airspaceCheckMsg="";
	var $checkedBy="";

	var $hash='';

	var $serverID=0;
	var $originalURL='';
	var $original_ID=0;

	var $originalUserID =0;
	var $userServerID=0;

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

var $autoScore=0;

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
	
	
	function toXML(){
		/*	maybe also include these	
		"forceBounds"		"autoScore"
		*/
		global $CONF_server_id,$CONF_photosPerFlight;
		
		$photosXML='';
		for($i=1;$i<=$CONF_photosPerFlight;$i++) {
			$var_name="photo".$i."Filename";
			if ($this->$var_name) {
				$photosXML.="<photo>\n<id>$i</id>\n<name>".$this->$var_name."</name>\n<link>http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/".$this->getPhotoRelPath($i)."</link>\n</photo>\n";
			}
		}
		if ($photosXML) $photosXML="<photos>\n$photosXML</photos>\n";
		list($wid,$takeoffName,$takeoffNameInt,$takeoffCountry)=getWaypointFull($this->takeoffID);
		list($lastName,$firstName,$pilotCountry,$Sex,$Birthdate,$CIVL_ID)=getPilotInfo($this->userID,$this->userServerID);

		$userServerID=$this->userServerID;
		if ($userServerID==0) $userServerID=$CONF_server_id;

		$dateAdded=$this->DATE;
		$dateAdded=tm2fulldate(fulldate2tm($dateAdded)-date('Z')); // convert to UTC 

		$xml=
"<flight>
<serverID>$CONF_server_id</serverID>
<id>$this->flightID</id>
<dateAdded>$this->dateAdded</dateAdded>
<filename>$this->filename</filename>
<linkIGC>".$this->getIGC_URL()."</linkIGC>
<linkDisplay>".htmlspecialchars($this->getFlightLinkURL())."</linkDisplay>

<info>
	<glider>$this->glider</glider>
	<gliderCat>$this->cat</gliderCat>
	<cat>$this->category</cat>
	<linkURL>$this->linkURL</linkURL>
	<private>$this->private</private>
	<comments>$this->comments</comments>
</info>

<time>
	<date>$dateAdded</date>
	<Timezone>$this->timezone</Timezone>
	<StartTime>$this->START_TIME</StartTime>
	<Duration>$this->DURATION</Duration>
</time>

<pilot>
	<userID>$this->userID</userID>
	<serverID>$userServerID</serverID>
	<CIVLID>$CIVL_ID</CIVLID>
	<userName>$this->userName</userName>
	<pilotFirstName>$firstName</pilotFirstName>
	<pilotLastName>$lastName</pilotLastName>
	<pilotCountry>$pilotCountry</pilotCountry>
	<pilotBirthdate>$Birthdate</pilotBirthdate>
	<pilotSex>$Sex</pilotSex>
</pilot>

<location>
	<takeoffID>$this->takeoffID</takeoffID>
	<serverID>$CONF_server_id</serverID>
	<takeoffVinicity>$this->takeoffVinicity</takeoffVinicity>
	<takeoffName>$takeoffName</takeoffName>
	<takeoffNameInt>$takeoffNameInt</takeoffNameInt>
	<takeoffCountry>$takeoffCountry</takeoffCountry>
</location>

<stats>
	<FlightType>$this->BEST_FLIGHT_TYPE</FlightType>
	<StraightDistance>$this->MAX_LINEAR_DISTANCE</StraightDistance>
	<XCdistance>$this->FLIGHT_KM</XCdistance>
	<XCscore>$this->FLIGHT_POINTS</XCscore>
	<MaxSpeed>$this->MAX_SPEED</MaxSpeed>
	<MaxVario>$this->MAX_VARIO</MaxVario>
	<MinVario>$this->MIN_VARIO</MinVario>
	<MaxAltASL>$this->MAX_ALT</MaxAltASL>
	<MinAltASL>$this->MIN_ALT</MinAltASL>
	<TakeoffAlt>$this->TAKEOFF_ALT</TakeoffAlt>
</stats>

<validation>
	<validated>$this->validated</validated>
	<grecord>$this->grecord</grecord>
	<hash>$this->hash</hash>
	<validationMessage>$this->validationMessage</validationMessage>
	<airspaceCheck>$this->airspaceCheck</airspaceCheck>
	<airspaceCheckFinal>$this->airspaceCheckFinal</airspaceCheckFinal>
	<airspaceCheckMsg>$this->airspaceCheckMsg</airspaceCheckMsg>
</validation>

$photosXML

</flight>\n";

		return $xml;
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
		} else if ($this->cat==16 ) { // paramotor
			$this->maxAllowedSpeed=120;
			$this->maxAllowedVario=13;
			$this->maxAllowedHeight=9000;
		} else if ($this->cat==32 ) { // trike
			$this->maxAllowedSpeed=120;
			$this->maxAllowedVario=13;
			$this->maxAllowedHeight=9000;
		} else if ($this->cat==64 ) { // other powered flight 
			$this->maxAllowedSpeed=400;
			$this->maxAllowedVario=20;
			$this->maxAllowedHeight=15000;
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

	function checkBound($time){
		if ($time >= $this->START_TIME &&  $time <= $this->END_TIME ) return 1;
		return 0;
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


	// ---------------------------------
	// Relative (web) paths
	// ---------------------------------
	function getPilotRelDir() {
		global $flightsWebPath;
		if ($this->userServerID) $extra_prefix=$this->userServerID.'_';
		else $extra_prefix='';

		return $flightsWebPath."/".$extra_prefix.$this->userID;
	}

	function getIGCRelPath($saned=0) {
		if ($saned) $suffix=".saned.igc";
		else $suffix="";

		return $this->getPilotRelDir()."/flights/".$this->getYear()."/".rawurlencode($this->filename).$suffix;  
	}

	function getKMLRelPath() {
		return $this->getPilotRelDir()."/flights/".$this->getYear()."/".rawurlencode($this->filename).".kml";  
	}

	function getGPXRelPath() {
		return $this->getPilotRelDir()."/flights/".$this->getYear()."/".rawurlencode($this->filename).".xml";  
	}
	function getPolylineRelPath() {
		return $this->getPilotRelDir()."/flights/".$this->getYear()."/".rawurlencode($this->filename).".poly.txt";  
	}

	function getMapRelPath($num=0) {
		if ($num) $suffix="3d";
		else $suffix="";
		return $this->getPilotRelDir()."/maps/".$this->getYear()."/".rawurlencode($this->filename).$suffix.".jpg";  
	}    

	function getChartRelPath($chartType,$unitSystem=1,$rawChart=0) {
		if ($unitSystem==2) $suffix="_2";
		else $suffix="";
		if ($rawChart) $suffix.=".raw";
		else $suffix.="";
		return $this->getPilotRelDir()."/charts/".$this->getYear()."/".rawurlencode($this->filename).".".$chartType.$suffix.".png";  
	} 
	function getPhotoRelPath($photoNum) {
		$t="photo".$photoNum."Filename";
		return $this->getPilotRelDir()."/photos/".$this->getYear()."/".$this->$t;  
	} 
	function getRelPointsFilename($timeStep=0) { // values > 0 mean 1-> first level of timestep, usually 20 secs, 2-> less details usually 30-40 secs
		if ($timeStep) $suffix=".".$timeStep;
		else $suffix="";
		return  $this->getPilotRelDir()."/flights/".$this->getYear()."/".$this->filename."$suffix.txt";
	}
	function getJsRelPath($timeStep=0) { // values > 0 mean 1-> first level of timestep, usually 20 secs, 2-> less details usually 30-40 secs
		if ($timeStep) $suffix=".".$timeStep;
		else $suffix="";
		return $this->getPilotRelDir()."/flights/".$this->getYear()."/".$this->filename."$suffix.js";
	}
	// ---------------------------------
	// now absolute filenames
	// ---------------------------------
	function getPilotAbsDir() {
		global $flightsAbsPath;
		if ($this->userServerID) $extra_prefix=$this->userServerID.'_';
		else $extra_prefix='';

		return $flightsAbsPath."/".$extra_prefix.$this->userID;
	}

	function getIGCFilename($saned=0) {
		if ($saned) $suffix=".saned.igc";
		else $suffix="";
		return $this->getPilotAbsDir()."/flights/".$this->getYear()."/".$this->filename.$suffix;  
	}
	function getKMLFilename() {
		return $this->getPilotAbsDir()."/flights/".$this->getYear()."/".$this->filename.".kml";  
	}
	function getGPXFilename() {
		return $this->getPilotAbsDir()."/flights/".$this->getYear()."/".$this->filename.".xml";  
	}
	function getPolylineFilename() {	
		return $this->getPilotAbsDir()."/flights/".$this->getYear()."/".$this->filename.".poly.txt";  
	}
	function getMapFilename($num=0) {
		if ($num) $suffix="3d";
		else $suffix="";
		return $this->getPilotAbsDir()."/maps/".$this->getYear()."/".$this->filename.$suffix.".jpg";  
	}    
	function getChartFilename($chartType,$unitSystem=1,$rawChart=0) {		
		if ($unitSystem==2) $suffix="_2";
		else $suffix="";

		if ($rawChart) $suffix.=".raw";
		else $suffix.="";

		return $this->getPilotAbsDir()."/charts/".$this->getYear()."/".$this->filename.".".$chartType.$suffix.".png";  
	} 
	function getPhotoFilename($photoNum) {
		$t="photo".$photoNum."Filename";
		return $this->getPilotAbsDir()."/photos/".$this->getYear()."/".$this->$t;  
	} 
	function getPointsFilename($timeStep=0) { // values > 0 mean 1-> first level of timestep, usually 20 secs, 2-> less details usually 30-40 secs
		if ($timeStep) $suffix=".".$timeStep;
		else $suffix="";
		return $this->getPilotAbsDir()."/flights/".$this->getYear()."/".$this->filename."$suffix.txt";
	}
	function getJsFilename($timeStep=0) { // values > 0 mean 1-> first level of timestep, usually 20 secs, 2-> less details usually 30-40 secs
		if ($timeStep) $suffix=".".$timeStep;
		else $suffix="";
		return $this->getPilotAbsDir()."/flights/".$this->getYear()."/".$this->filename."$suffix.js";
	}

	//---------------------------------------
	// Full url functions
	//----------------------------------------
	function getFlightLinkURL() {
		global $baseInstallationPath,$module_name;
		global $CONF_mainfile;
		return "http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/".$CONF_mainfile."?name=".$module_name."&op=show_flight&flightID=".$this->flightID;
	}

	function getIGC_URL($saned=0) {
		global $baseInstallationPath,$module_name;
		global $CONF_mainfile;
		return "http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/".$this->getIGCRelPath($saned);
	}

	function getFlightKML() {
		global $baseInstallationPath,$module_name;
		global $CONF_mainfile;
		return "http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/modules/$module_name/download.php?type=kml_trk&flightID=".$this->flightID;
	}

	function getFlightGPX() {
		global $baseInstallationPath,$module_name;
		global $CONF_mainfile;
		return "http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/modules/$module_name/download.php?type=gpx_trk&flightID=".$this->flightID;
	}

	//------------------------------
	// End of path functions
	//------------------------------


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

	function gMapsGetTaskJS(){
		

		
		$icons=array(
		1=>array("root://icons/palette-3.png",0,192),
		2=>array("root://icons/palette-3.png",32,192),
		3=>array("root://icons/palette-3.png",64,192),
		4=>array("root://icons/palette-3.png",96,192),
		5=>array("root://icons/palette-3.png",128,192) );
		$kml_file_contents="var polyline = new GPolyline([ \n";

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
				$kml_file_contents.=    ' new GLatLng('.$newPoint->lat.','.(-$newPoint->lon).'),';
		
				$name=$i;

				$turnpointPlacemark[$j]='					
		            var marker = createTaskMarker(new GLatLng('.$newPoint->lat.','.(-$newPoint->lon).'),"TP '.$name.'","'.$name.'");
        		    map.addOverlay(marker);
				';
				$j++;
		
			}
		}

		$kml_file_contents=substr($kml_file_contents,0,-1);
		$kml_file_contents.=' ], "#FFFFFF", 3,1); 
			map.addOverlay(polyline);
';

		for ($i=0;$i<$j;$i++) 
			$kml_file_contents.=$turnpointPlacemark[$i];

		return $kml_file_contents;
	}


	function kmlGetTask($completeKMLfile=0){
		if ($completeKMLfile) {
			$kml_file_contents="<?xml version='1.0' encoding='UTF-8'?>\n".
								"<kml xmlns=\"http://earth.google.com/kml/2.1\">\n";	
		} else {
			$kml_file_contents="";
		}

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
	
		if ($completeKMLfile) {
			$kml_file_contents="</kml>\n";
		}
		return $kml_file_contents;
	}

	function kmlGetTrack($lineColor="ff0000",$exaggeration=1,$lineWidth=2,$extended=1) {
		global $module_name, $flightsAbsPath,$flightsWebPath, $takeoffRadious,$landingRadious;
		global $moduleRelPath,$baseInstallationPath;
		global $langEncodings,$currentlang;

		$getFlightKML=$this->getFlightKML()."c=$lineColor&ex=$exaggeration&w=$lineWidth&an=$extended";
		if ($extended) {
			//$kml_file_contents.="<Placemark >\n<name>".$this->filename."</name>";
			// $kml_file_contents.=$this->kmlGetDescription($extended,$getFlightKML);
			//$kml_file_contents.="</Placemark>";
			kmlGetTrackAnalysis($this->getIGCFilename(0),$exaggeration);
			$kml_file_contents.="
<NetworkLink>
  <name>Extended analysis</name>
  <visibility>1</visibility>
  <open>1</open>
  <description> Extra analysis generation by  Man\'s GPS2GE V2.0 (http://www.parawing.net)</description>
  <refreshVisibility>0</refreshVisibility>
  <flyToView>0</flyToView>
  <Link>
	<href>http://".$_SERVER['SERVER_NAME']."/$baseInstallationPath/".$this->getIGCRelPath(0).".man.kmz</href>
  </Link>
</NetworkLink>";

			return $kml_file_contents;
		}
		

		$KMLlineColor="ff".substr($lineColor,4,2).substr($lineColor,2,2).substr($lineColor,0,2);
		$kmzFile=$this->getIGCFilename(0).".kmz";
		$kmlTempFile=$this->getIGCFilename(0).".kml";

		if ( !file_exists($kmzFile)  || 1) { // create the kmz file containg the points only

			$filename=$this->getIGCFilename(0);  
			$lines = file ($filename); 
			if ( $lines) {
				$i=0;
		
	$str="<?xml version='1.0' encoding='UTF-8'?>\n".
	"<kml xmlns=\"http://earth.google.com/kml/2.1\">\n";	
				$str.="<Document>									
				<Placemark>\n<name>Tracklog</name>\n".
				" <styleUrl>http://".$_SERVER['SERVER_NAME']."/$baseInstallationPath/".$this->getIGCRelPath(0).".kml#igcTrackLine</styleUrl>
				<Style ID='igcTrackLine'>
					<LineStyle>
					  <color>ff0000ff</color>
					  <width>2</width>
					</LineStyle>
			  </Style>
				<LineString>				
				<altitudeMode>absolute</altitudeMode>
				<coordinates>\n";
		
				//$kml_file_contents=str_replace("&","&#38;",$kml_file_contents);
				// $kml_file_contents=utf8_encode(str_replace("&nbsp;"," ",$kml_file_contents));
				$str=str_replace("&nbsp;"," ",$str);
		
				foreach($lines as $line) {
					$line=trim($line);
					if  (strlen($line)==0) continue;				
					if ($line{0}=='B') {
							if  ( strlen($line) < 23 ) 	continue;
							$thisPoint=new gpsPoint($line,$this->timezone);
							$data_alt[$i]=$thisPoint->getAlt();				
							if ( $thisPoint->getAlt() > $this->maxAllowedHeight ) continue;
							$str.=-$thisPoint->lon.",".$thisPoint->lat.",".($thisPoint->getAlt()*$exaggeration)." ";
							$i++;
							if($i % 50==0) $str.="\n";
					}
				}
		
				$str.="</coordinates>\n</LineString>\n";
				$str.="</Placemark>\n</Document>\n</kml>";
	
				writeFile($kmlTempFile,$str);
				// zip the file 
				require_once dirname(__FILE__)."/lib/pclzip/pclzip.lib.php";
				$archive = new PclZip($kmzFile);
				$v_list = $archive->create($kmlTempFile, PCLZIP_OPT_REMOVE_ALL_PATH);
				@unlink($kmlTempFile);
			}
		}

		
		$kml_file_contents.=
		"<Style ID='igcTrackLine'>
			<LineStyle>
			  <color>".$KMLlineColor."</color>
			  <width>$lineWidth</width>
			</LineStyle>
		  </Style>
		";
		//$kml_file_contents.="<Folder>\n<name>".$this->filename."</name>".$this->kmlGetDescription($extended,$getFlightKML);
//		$kml_file_contents.="<Placemark >\n<name>".$this->filename."</name>".$this->kmlGetDescription($extended,$getFlightKML);

			$kml_file_contents.="
<NetworkLink>
  <name>Tracklog</name>
  <visibility>1</visibility>
  <open>0</open> 
  <refreshVisibility>0</refreshVisibility>
  <flyToView>0</flyToView>
  <Link>
	<href>http://".$_SERVER['SERVER_NAME']."/$baseInstallationPath/".$this->getIGCRelPath(0).".kmz</href>
  </Link>
</NetworkLink>";

	//	$kml_file_contents.="</Folder>";


		return $kml_file_contents;
	}

	function gpxGetTrack() {
		global $module_name, $flightsAbsPath,$flightsWebPath, $takeoffRadious,$landingRadious;
		global $moduleRelPath,$baseInstallationPath;
		global $langEncodings,$currentlang;

		// $getFlightKML=$this->getFlightKML()."c=$lineColor&ex=$exaggeration&w=$lineWidth&an=$extended";

		$filename=$this->getIGCFilename(0);  
		$lines = file ($filename); 
		if (!$lines) return;
		$i=0;
		$kml_file_contents="<trk>\n
<name>".htmlspecialchars($this->userName)."</name>
<desc>Leonardo track</desc>
	<trkseg>\n";
	
		$min_lat=1000;
		$max_lat=-1000;
		$min_lon=1000;
		$max_lon=-1000;
	
		
		foreach($lines as $line) {
			$line=trim($line);
			if  (strlen($line)==0) continue;				
			if ($line{0}=='B') {
					if  ( strlen($line) < 23 ) 	continue;
					$thisPoint=new gpsPoint($line,$this->timezone);
					if ( $thisPoint->lat  > $max_lat )  $max_lat =$thisPoint->lat  ;
					if ( $thisPoint->lat  < $min_lat )  $min_lat =$thisPoint->lat  ;
					if ( -$thisPoint->lon  > $max_lon )  $max_lon =-$thisPoint->lon  ;
					if ( -$thisPoint->lon  < $min_lon )  $min_lon =-$thisPoint->lon  ;

					$data_alt[$i]=$thisPoint->getAlt();				
					if ( $thisPoint->getAlt() > $this->maxAllowedHeight ) continue;
					$kml_file_contents.='<trkpt lat="'.$thisPoint->lat.'" lon="'.-$thisPoint->lon.'">'."\n";
					$kml_file_contents.="  <ele>".$thisPoint->getAlt()."</ele>\n</trkpt>\n";
					$i++;
					//	if($i % 50==0) $kml_file_contents.="\n";
			}
		}		

		$kml_file_contents.="</trkseg>\n</trk>\n<bounds minlat=\"$min_lat\" minlon=\"".$min_lon."\" maxlat=\"$max_lat\" maxlon=\"".$max_lon."\" />\n";
		//echo "</trkseg>\n</trk>\n<bounds minLat=\"$min_lat\" minlon=\"$min_lon\" maxLat=\"$max_lat\" maxlon=\"$max_lon\" />\n";
		return $kml_file_contents;
	}

	function createEncodedPolyline() {
		global $module_name, $flightsAbsPath,$flightsWebPath, $takeoffRadious,$landingRadious;
		global $moduleRelPath,$baseInstallationPath;
		global $langEncodings,$currentlang;
		
		// if ( is_file($this->getPolylineFilename())  ) return ;

		$filename=$this->getIGCFilename(1);  
		$lines = file ($filename); 
		if (!$lines) return;
		$i=0;
		$kml_file_contents="";
	
		$min_lat=1000;
		$max_lat=-1000;
		$min_lon=1000;
		$max_lon=-1000;
	
		$prevLat=0;
		$prevLon=0;

		// compute num of B lines
		$numLines=0;
		foreach($lines as $line) {
			if ($line{0}=='B' && strlen($line) >= 23 ) $numLines++;
		}

		if ($numLines<200 ) {
			$mod=1; 
			$lvlArray="3"; // always 3
		} else 	if ($numLines>=200 && $numLines<400) {
			$mod=8; // max visible every 8 points
			$lvlArray="30102010"; // for mod 8
		} else 	if ($numLines>=400 && $numLines<600) {
			$mod=12;
			$lvlArray="300100200100";
		} else 	if ($numLines>=600) {
			$mod=18;
			$lvlArray="300100200100200100";
		}

		$lvlEncArray=array(0=>'?','@','A','B' );

		foreach($lines as $line) {
			$line=trim($line);
			if  (strlen($line)==0) continue;				
			if ($line{0}=='B') {
					if  ( strlen($line) < 23 ) 	continue;
					$thisPoint=new gpsPoint($line,$this->timezone);
					$lat=$thisPoint->lat;
					$lon=-$thisPoint->lon;
					if ($i==0) $ln="$lat|$lon|Takeoff|Takeoff\n";

					if ( $lat  > $max_lat )  $max_lat =$lat  ;
					if ( $lat  < $min_lat )  $min_lat =$lat  ;
					if ( $lon  > $max_lon )  $max_lon =$lon  ;
					if ( $lon  < $min_lon )  $min_lon =$lon  ;

					$kml_file_contents.=encodeNumber($lat-$prevLat).encodeNumber($lon-$prevLon);


					$thisLvl=$lvlEncArray[ $lvlArray[$i%$mod]+0 ];
//					$levels.="B";
					$levels.=$thisLvl;


					$prevLat=$lat;
					$prevLon=$lon;

					$i++;
			}
		}		
		$ln.="$lat|$lon|Landing|Landing\n";
		$ln.="$min_lat,$max_lat,$min_lon,$max_lon\n";
		// write to file
		$handle = fopen($this->getPolylineFilename(), "w");
		fwrite($handle, $ln.$kml_file_contents."\n".$levels);
		fclose($handle);
		return 1;
	}

	function createKMLfile($lineColor="ff0000",$exaggeration=1,$lineWidth=2,$extendedInfo=0) {
		global $module_name, $flightsAbsPath,$flightsWebPath, $takeoffRadious,$landingRadious;
		global $moduleRelPath,$baseInstallationPath;
		global $langEncodings,$currentlang;

		require_once dirname(__FILE__)."/lib/ConvertCharset/ConvertCharset.class.php";
		//if (file_exists($this->getKMLFilename())) return;

		$getFlightKML=$this->getFlightKML()."c=$lineColor&ex=$exaggeration&w=$lineWidth&an=$extendedInfo";
		//UTF-8 or 
		//".$langEncodings[$currentlang]."
$kml_file_contents=
//"<?xml version='1.0' encoding='".$langEncodings[$currentlang]."'? >".
"<?xml version='1.0' encoding='UTF-8'?>\n".
"<kml xmlns=\"http://earth.google.com/kml/2.1\">
<Document id='".$this->filename."'>
<name>".$this->filename."</name>".$this->kmlGetDescription($extendedInfo,$getFlightKML)."
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

		$kml_file_contents.="</Document>\n</kml>";

		$NewEncoding = new ConvertCharset;
		$FromCharset=$langEncodings[$currentlang];
		$kml_file_contents = $NewEncoding->Convert($kml_file_contents, $FromCharset, "utf-8", $Entities);

		return $kml_file_contents;
	}

	function createGPXfile($returnAlsoXML=0) {

		global $module_name, $flightsAbsPath,$flightsWebPath, $takeoffRadious,$landingRadious;
		global $moduleRelPath,$baseInstallationPath;
		global $langEncodings,$currentlang;

		if (file_exists($this->getGPXFilename()) && 0 ) {
			if (!$returnAlsoXML) return 1;
			$xml_file_contents=file_get_contents( $this->getGPXFilename() );
			return $xml_file_contents;
		}

		$xml_file_contents=
'<?xml version="1.0" encoding="UTF-8" standalone="no" ?>
<gpx xmlns="http://www.topografix.com/GPX/1/1" creator="byHand" version="1.1" 
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
    xsi:schemaLocation="http://www.topografix.com/GPX/1/1 http://www.topografix.com/GPX/1/1/gpx.xsd">
';
			
	    $xml_file_contents.=$this->gpxGetTrack();
		

		// create the start and finish points
//		$xml_file_contents.=makeWaypointPlacemark($this->takeoffID);
//		if ( $this->takeoffID!=$this->landingID)
//			$xml_file_contents.=makeWaypointPlacemark($this->landingID);
	
		// create the OLC task
		// $xml_file_contents.=$this->kmlGetTask();

		$xml_file_contents.="</gpx>";

		// write to file
		$handle = fopen($this->getGPXFilename(), "w");
		fwrite($handle, $xml_file_contents);
		fclose($handle);

		// return the xml
		if ($returnAlsoXML)		return $xml_file_contents;
		else return 1;
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
										
					// check for start of flight 
					if ($thisPoint->getTime()<$this->START_TIME) continue;
					// check for end of flight 
					if ($thisPoint->getTime()>$this->END_TIME) continue;
					
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

  function getRawValues($forceRefresh=0, $getAlsoXY=0) {
    $this->setAllowedParams();

    $data_time = array ();
    $data_alt = array ();
    $data_speed = array ();
    $data_vario = array ();
    $data_takeoff_distance = array ();
    $data_X =array();
    $data_Y =array();

	if ( ! is_file($this->getPointsFilename(1) ) || ! is_file($this->getJsFilename(1) ) || $forceRefresh ) 	$this->storeIGCvalues(); // if no file exists do the proccess now

    $lines = file($this->getPointsFilename(1)); // get the normalized with constant time step points array
    if (!$lines) return;
    $i = 0;

	// first 3 lines of pointsFile is reserved for info
	for($k=3;$k< count($lines);$k++){
		$line = trim($lines[$k]);
		if (strlen($line) == 0) continue;
		  
		eval($line);
		  
	//	if ($alt > $this->maxAllowedHeight)  continue;
    //    if ($speed > $this->maxAllowedSpeed) continue;
    //    if (abs($vario) > $this->maxAllowedVario) continue;

		if  ( $time<$lastPointTime ) continue;		
		$lastPointTime=$time;

        if ($time_in_secs) $data_time[$i] = $time;
        else $data_time[$i] = sec2Time($time, 1);
				
        $data_alt[$i] = $alt;
        $data_speed[$i] = $speed;
        $data_vario[$i] = $vario;
        if ($getAlsoXY) {
          $data_X[$i]=-$lon;
          $data_Y[$i]=$lat;
        }

        if ($i > 0) {
			// $t_dis=gpsPoint::calc_distance($lat,$lon,$firstLat,$firstLon) ;
			// $data_takeoff_distance[$i] = $t_dis/1000; //gpsPoint::calc_distance($lat,$lon,$firstLat,$firstLon) /1000;		
			$data_takeoff_distance[$i]=$dis;
        } else {
			$data_takeoff_distance[$i] = 0;
			$firstLat=$lat;
			$firstLon=$lon;
		}
		
        $i ++;
    } //end for loop
    
    if ($getAlsoXY)
      return array($data_time,$data_alt,$data_speed,$data_vario,$data_takeoff_distance,$data_X,$data_Y);
    else
      return array ($data_time, $data_alt, $data_speed, $data_vario, $data_takeoff_distance);

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
	
	function getRawHeader(){
		$handle = fopen($this->getPointsFilename(1), "r"); 
		$l=array();
		$l[0]= fgets($handle, 4096); 
		$l[1]= fgets($handle, 4096); 
		$l[2]= fgets($handle, 4096); 
		fclose ($handle); 
		return $l;
	}
	
	function storeIGCvalues() {
		global $flightsAbsPath;

		$data_time =array();
		$data_alt =array();
		$data_speed =array();
		$data_vario =array();
		$data_takeoff_distance=array();

		$filename=$this->getIGCFilename(0);  
		$lines = @file ($filename); 
		if (!$lines) return;

		$i=0;
		$day_offset =0; 

		$currentDate=0;
		$prevDate=0;
		
		foreach($lines as $line) {
			$line=trim($line);
			if  (strlen($line)==0) continue;		

			if (strtoupper(substr($line,0,5)) =="HFDTE"  || strtoupper(substr($line,0,5)) =="HPDTE"  ) {  // HFDTE170104  OR HPDTE310805
					$dt=substr($line,5,6);
					$yr_last=substr($dt,4,2);
					// case of YY=0 (1 digit) HFDTE08070 
					if ($yr_last=="0") $yr_last="00";
					if ($yr_last > 80 ) $yr="19".$yr_last;
					else $yr="20".$yr_last;
					
					$prevDate=$currentDate;					
					$currentDate=mktime(0,0,0,substr($dt,2,2),substr($dt,0,2),$yr);
					//echo "DATE cahnge : $currentDate  $prevDate <BR>";
					if ($prevDate>0 && ($currentDate-$prevDate)>86400) { // more than one day 
						break;
					}
			}
			
			if ($line{0}=='B') {
					if  ( strlen($line) < 23 ) 	continue;
					$thisPoint=new gpsPoint($line,$this->timezone);
					$thisPoint->gpsTime+=$day_offset;
					// $goodPoints[$i]['time']=sec2Time($thisPoint->getTime(),1);
					$goodPoints[$i]['time']=$thisPoint->getTime();
					$goodPoints[$i]['lon']=$thisPoint->lon;
					$goodPoints[$i]['lat']=$thisPoint->lat;
					
					$goodPoints[$i]['alt']=$thisPoint->getAlt();				

					if ($i>0) {						
						$tmp = $lastPoint->calcDistance($thisPoint);		
						
					$time_diff=  $thisPoint->getTime() - $lastPoint->getTime()  ;
					
					if (  $time_diff < 0 && $time_diff > -36000  )  { // if the time is less than 10 hours in the past  we just ignore it
						continue;
        		    } else 	if ( $time_diff < 0  )  {  // CHANGING DAY , means the flight is at night
						array_pop($goodPoints);
						break;
        		    } else 	if (  $time_diff > $this->max_allowed_time_gap *4 )  {  // found time gap
						array_pop($goodPoints);
						break;		
					}
						
					/*	if ( ($lastPoint->getTime() - $thisPoint->getTime()  ) > 3600 )  { // more than 1 hour
                    		$day_offset = 86400; // if time seems to have gone backwards, add a day
		                    $thisPoint->gpsTime += 86400;
        		        } else if ( ($lastPoint->getTime() - $thisPoint->getTime()  ) > 0 ) {
							$lastPoint=new gpsPoint($line,$this->timezone);
							$lastPoint->gpsTime+=$day_offset;
							continue;
						}	
						*/
						
						$deltaseconds = $thisPoint->getTime() - $lastPoint->getTime() ;	
						if ($deltaseconds) {
							$speed = ($deltaseconds)?$tmp*3.6/($deltaseconds):0.0; /* in km/h */
							$goodPoints[$i]['vario'] =($thisPoint->getAlt() - $lastPoint->getAlt() ) / $deltaseconds;
						} else {
							$speed =0;
							$data_vario[$i]=0;
						}

						$goodPoints[$i]['speed']=$speed;
						$goodPoints[$i]['dis']=  $takeoffPoint->calcDistance($thisPoint) /1000;
					}	else  {
						$goodPoints[$i]['speed']=0;
						$goodPoints[$i]['vario']=0;
						$takeoffPoint=new gpsPoint($line,$this->timezone);
						$goodPoints[$i]['dis']=0;
					}
					$lastPoint=new gpsPoint($line,$this->timezone);
					$lastPoint->gpsTime+=$day_offset;

					$i++;
			} 
		}
							
		$pointsNum=count($goodPoints);
	
		//echo "pointsNum : $pointsNum<br>";
		$min_time=floor($goodPoints[0]['time']/60)*60;
		$max_time=ceil($goodPoints[$pointsNum-1]['time']/60)*60;
		// echo "max / min time: $max_time $min_time<BR>"; 

		$interval=20;
		$k=0;
		for($i=$min_time;$i<=$max_time;$i=$i+$interval) {
			$normPoints[$k]=array();
			$normPoints[$k]['timeText']=sec2time($i);
			$normPoints[$k]['time']=$i;		
			$k++;
		}
	
		$org_array_pos=0;
		foreach($normPoints as $norm_array_pos=>$normPoint) { // for each point  in the timeline
			$timeval=$normPoint['time'];
			if ( $goodPoints[$org_array_pos]['time'] >= $timeval && $org_array_pos< count($goodPoints)  && 
				!($org_array_pos==0 && $goodPoints[0]['time'] < $timeval)   ) {  
	
				$normPoints[$norm_array_pos]['lon']=$goodPoints[$org_array_pos]['lon'];
				$normPoints[$norm_array_pos]['lat']=$goodPoints[$org_array_pos]['lat'];
	
				$normPoints[$norm_array_pos]['speed']=$goodPoints[$org_array_pos]['speed'];
				$normPoints[$norm_array_pos]['vario']=$goodPoints[$org_array_pos]['vario'];
				$normPoints[$norm_array_pos]['alt']=$goodPoints[$org_array_pos]['alt'];
				$normPoints[$norm_array_pos]['dis']=$goodPoints[$org_array_pos]['dis'];
				// if ($normPoints[$norm_array_pos]['alt']==0) $normPoints[$norm_array_pos]['alt']="-";
				
				while ($goodPoints[$org_array_pos]['time'] <  $timeval + $interval  && ($org_array_pos)< count($goodPoints) ) {
					$org_array_pos++;
				}
			} else {
				if ($norm_array_pos ) {
					$normPoints[$norm_array_pos]['lon']=$normPoints[$norm_array_pos-1]['lon'];
					$normPoints[$norm_array_pos]['lat']=$normPoints[$norm_array_pos-1]['lat'];
					$normPoints[$norm_array_pos]['speed']=$normPoints[$norm_array_pos-1]['speed'];
					$normPoints[$norm_array_pos]['vario']=$normPoints[$norm_array_pos-1]['vario'];
					$normPoints[$norm_array_pos]['alt']=$normPoints[$norm_array_pos-1]['alt'];
					$normPoints[$norm_array_pos]['dis']=$normPoints[$norm_array_pos-1]['dis'];
				}	else {
					$normPoints[$norm_array_pos]['lon']=$goodPoints[0]['lon'];
					$normPoints[$norm_array_pos]['lat']=$goodPoints[0]['lat'];
					$normPoints[$norm_array_pos]['speed']=$goodPoints[0]['speed'];
					$normPoints[$norm_array_pos]['vario']=$goodPoints[0]['vario'];
					$normPoints[$norm_array_pos]['alt']=$goodPoints[0]['alt'];
					$normPoints[$norm_array_pos]['dis']=$goodPoints[0]['dis'];
				}
	/*
				if ($org_array_pos>0) {
					$normPoints[$norm_array_pos]['speed']="-";
					$normPoints[$norm_array_pos]['vario']="-";
					$normPoints[$norm_array_pos]['alt']="-";
				} 
	*/
			}
	
	
		} // end foreach 

		// now write it to file
		$outputBuffer='$min_time='.$min_time.';$max_time='.$max_time.";\n\n\n";
		
		$jsOutput="";
		foreach ($normPoints as $point) {
			$outputBuffer.='$time='.$point['time'].'; $lat='.$point['lat'].'; $lon='.$point['lon'].
			'; $dis='.$point['dis'].'; $alt='.$point['alt'].'; $speed='.$point['speed'].'; $vario='.$point['vario'].";\n";
			$this_tm=$point['time']-$min_time;
			$jsOutput.=sprintf("lt[$this_tm]=%.6f;ln[$this_tm]=%.6f;d[$this_tm]=%d;a[$this_tm]=%d;s[$this_tm]=%0.1f;v[$this_tm]=%.2f;\n"
								,$point['lat'],-$point['lon'],$point['dis'],$point['alt'],$point['speed'],$point['vario']);
		}
		$path_igc = dirname($this->getPointsFilename(1));
		if (!is_dir($path_igc)) @mkdir($path_igc, 0755);

		// write saned js file		
		writeFile($this->getJsFilename(1),$jsOutput);
		// write saned IGC file
		writeFile($this->getPointsFilename(1),$outputBuffer);

//		$handle = fopen($this->getPointsFilename(1), "w");
//		fwrite($handle, $outputBuffer);
//		fclose($handle);

		return 1;

	}

	function getNextPointPos($pointArray,$currentPos){
		for($i=$currentPos+1; $i < count($pointArray);$i++) {
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

	function checkForOLCfile($filename) {
		$lines = file ($filename);
		$line=$lines[0];
		if (  strtoupper(substr($line,0,3))!='OLC' ) return 0; // not OLC file

		$mindist=0;
		if ( preg_match("/&mindist=(\d+)&/",$lines[0],$m) ) {
			$mindist=$m[1];
		}
		// echo "mindist: $mindist		<BR>";

		DEBUG("OLC",255,"First line starts with OLC, will search further");
		// if the first line begins with OLC we have an olc file		
		// we got an olc optimized file , get the 5 turnpoints
		if (preg_match(
	   "/&w0bh=([NnSs])&w0bg=(\d+)&w0bm=(\d+)&w0bmd=(\d+)&w0lh=([EeWw])&w0lg=(\d+)&w0lm=(\d+)&w0lmd=(\d+)".				
		"&w1bh=([NnSs])&w1bg=(\d+)&w1bm=(\d+)&w1bmd=(\d+)&w1lh=([EeWw])&w1lg=(\d+)&w1lm=(\d+)&w1lmd=(\d+)".
		"&w2bh=([NnSs])&w2bg=(\d+)&w2bm=(\d+)&w2bmd=(\d+)&w2lh=([EeWw])&w2lg=(\d+)&w2lm=(\d+)&w2lmd=(\d+)".
		"&w3bh=([NnSs])&w3bg=(\d+)&w3bm=(\d+)&w3bmd=(\d+)&w3lh=([EeWw])&w3lg=(\d+)&w3lm=(\d+)&w3lmd=(\d+)".
		"&w4bh=([NnSs])&w4bg=(\d+)&w4bm=(\d+)&w4bmd=(\d+)&w4lh=([EeWw])&w4lg=(\d+)&w4lm=(\d+)&w4lmd=(\d+)/",$lines[0],$matches)  || 
		
		preg_match(
	   "/&fai0bh=([NnSs])&fai0bg=(\d+)&fai0bm=(\d+)&fai0bmd=(\d+)&fai0lh=([EeWw])&fai0lg=(\d+)&fai0lm=(\d+)&fai0lmd=(\d+)".				
		"&fai1bh=([NnSs])&fai1bg=(\d+)&fai1bm=(\d+)&fai1bmd=(\d+)&fai1lh=([EeWw])&fai1lg=(\d+)&fai1lm=(\d+)&fai1lmd=(\d+)".
		"&fai2bh=([NnSs])&fai2bg=(\d+)&fai2bm=(\d+)&fai2bmd=(\d+)&fai2lh=([EeWw])&fai2lg=(\d+)&fai2lm=(\d+)&fai2lmd=(\d+)".
		"&fai3bh=([NnSs])&fai3bg=(\d+)&fai3bm=(\d+)&fai3bmd=(\d+)&fai3lh=([EeWw])&fai3lg=(\d+)&fai3lm=(\d+)&fai3lmd=(\d+)".
		"&fai4bh=([NnSs])&fai4bg=(\d+)&fai4bm=(\d+)&fai4bmd=(\d+)&fai4lh=([EeWw])&fai4lg=(\d+)&fai4lm=(\d+)&fai4lmd=(\d+)/",$lines[0],$matches)
		
		) {
			for($i1=0;$i1<=4;$i1++)  {
				$opt_point[$i1]=sprintf("%02d%02d%03d%s%03d%02d%03d%s",$matches[1+$i1*8+1],$matches[1+$i1*8+2],$matches[1+$i1*8+3],$matches[1+$i1*8+0],
								$matches[1+$i1*8+5],$matches[1+$i1*8+6],$matches[1+$i1*8+7],$matches[1+$i1*8+4]);
			}
			$manual_optimize=1;
			// echo "manual_optimize";			
			// print_r($matches);
			// print_r($p);
			
			//now confirm that the supplied points are indeed in the track.
			$opt_point_num=0;
			foreach($lines as $line) {		
				if (strtoupper($line[0])!='B') continue;
				$done=0;
				while(! $done){
					if ( substr($line,7,17)==$opt_point[$opt_point_num] ) { // found the point inside the track
						$opt_point_num++; // search for next turnpoint
						if ($opt_point_num==5) break;
					} else {
						$done=1;
					}
				}
				if ($opt_point_num==5) break;
			}
			
			//for($i=0;$i<=4;$i++)  {
			//	echo "#".$opt_point[$i]."<br>";		
			//}
			if ($opt_point_num==5) {			
				//echo "OPTIMIZATION POINTS confirmed";
				DEBUG("OLC",255,"OPTIMIZATION POINTS confirmed");
				// now compute best score
				for($i=0;$i<=4;$i++)  {
					$points[$i]=new gpsPoint("B120000".$opt_point[$i]."A0000000000");					
				}
				/*
					Explained by Thomas Kuhlmann
					
					You have 5 Points:
					Startpoint, First Waypoint, Second Waypoint, Third Waypoint, Endpoint
					given following distances
					a : distance from First to Second Waypoint
					b : distance from Second the Third Waypoint
					c : distance from Third to First Waypoint
					d : distance from End- To Startpoint
					Rule to have a triangle (it may be 20% open):
					
					  d <= 20% ( a+b+c )
					this is equivalent to:
					  d*5 <= a+b+c
					
					Now you have to check if this triangle fullfills the 28% FAI rule:
					  ( a >= 28% (a+b+c) )  AND  (b >= 28% (a+b+c))  AND (c>= 28% (a+b+c))
					this is quivalent to (28% = 7/25):
					  (25*a >= 7*(a+b+c))  AND (25*b >= 7*(a+b+c)) AND (25*c >= 7*(a+b+c))
					if using integers for calculation of distances in decimeters,
					 this formular generates no integer to float concerning problems. 
				*/	
				$a=$points[1]->calcDistance($points[2]);
				$b=$points[2]->calcDistance($points[3]);
				$c=$points[3]->calcDistance($points[1]);
				$d=$points[4]->calcDistance($points[0]);

				// echo "<br> triangle : $a $b $c $d<BR>";
				$u=$a+$b+$c;
				if ($d*5 <= ($u) ) { // we have a triangle
					if ( ( 25*$a >= 7*$u )  && ( 25*$b >= 7*$u ) && ( 25*$c >= 7*$u ) ) {
						$factor1=2; // fai triangle
					} else { 		
						$factor1=1.75; // open triangle
					}
					$km_triangle=($u-$d)/1000;
					$score_triangle=$km_triangle*$factor1;
				}
					
				//now for straight distance				
				$a=$points[0]->calcDistance($points[1]);
				$b=$points[1]->calcDistance($points[2]);
				$c=$points[2]->calcDistance($points[3]);
				$d=$points[3]->calcDistance($points[4]);

				$factor=1.5;
				$km_straight=($a+$b+$c+$d)/1000;
				$score_straight=$km_straight*$factor;
				//echo "$a $b $c $d<BR>";
				//echo "km_straight:$km_straight  score_straight:$score_straight <BR>";				
				//echo "km_triangle:$km_triangle  score_triangle:$score_triangle <BR>";
				
				$str="";
				for($i=0;$i<=4;$i++)  
					$str.=$opt_point[$i]."\n";
				
				// check if $mindist>0 and  the triangle km are < $mindist, then we check
				// if the straight distance km are > $mindist and use that instead	
				if ($km_triangle<$mindist) {
					if ($km_straight>=$mindist) $str.="$km_straight\n$score_straight\n$factor\n";
					else $str.="$km_triangle\n$score_triangle\n$factor1\n";
				} else {				
					if ($score_triangle>=$score_straight) 
						$str.="$km_triangle\n$score_triangle\n$factor1\n";
					else 
						$str.="$km_straight\n$score_straight\n$factor\n";
				}
					
				$str.="\n$mindist";
				writeFile($filename.".olc",$str);
			} // end if confirmed the 5 turnpoints
						
		} // end if the preg match
			
		// now write the IGC file stripping the first line
		// there might be a &IGCigcIGC= (maxpunkte) or not (compeGPS)
		// $lines[0]
		if ( preg_match("/&IGCigcIGC=(.*)/",$lines[0],$matches) ) {
			$lines[0]=$matches[1]."\n";
		} else { // just remove the line[0] for the array
			array_shift($lines);
		}

		// done write the stripped file to disk
		$str=implode("",$lines);
		writeFile($filename,$str);
		
		return 1;
	}
	
	function getFlightFromIGC($filename) {
	set_time_limit (100);
	if ($this->forceBounds) {
		$startTime=$this->START_TIME;
		$endTime=$this->END_TIME;
	}
	$this->resetData();
	if ($this->forceBounds) {
		$this->START_TIME=$startTime;
		$this->END_TIME=$endTime;
	}
	$this->setAllowedParams();
	$this->filename=basename($filename);

	$this->checkForOLCfile($filename);

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

			if ($T_distance[1] < 0.5 && $T_deltaseconds[1] >2 ) {  // less than 0.5 m distance
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
				 DEBUG("IGC",8,"[$Brecords-$p] > ".abs($T_vario[1]) ."m/sec  > max allowed vario<br>");
			}
			if ( $p<5 && ! $try_no_takeoff_detection && ! $this->forceBounds ) { // first 5 points need special care 
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
			DEBUG("IGC",1,"NO VALID POINTS FOUND");
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

			// if (strtoupper(substr($line,0,1)) !="B" ) echo "@$line<BR>";
			
			if (strtoupper(substr($line,0,3)) =="OLC"  ) continue; // it is an olc file , dont put the OLC... line in to the saned file
			
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
				if (!$this->glider ) $this->glider=trim(substr($line,16));
				// HFGTYGLIDERTYPE
				// HOGTYGLIDERTYPE
			} else 	if ($line{0}=='B' ) {
				if ($stopReadingPoints ) continue;
				if ($line{1}=='X') { 
					DEBUG("IGC",1,"[$points] BAD : $line<br>");
					continue ; // MARKED BAD from BEFORE 
				}
				if  ( strlen($line) < 23 || strlen($line) > 100  ) continue;
				

				if  ($points==0)  { // first point 
					//				echo "######## first point <br>";
					$firstPoint=new gpsPoint($line,$this->timezone);
					if ($this->timezone==1000) { // no timezone in the file
						// echo "calc timezone<br>";
						$this->timezone= getUTMtimeOffset( $firstPoint->lat,$firstPoint->lon, $this->DATE );
						$this->timezone= getTZ( $firstPoint->lat,$firstPoint->lon, $this->DATE );						
						// echo 	$this->timezone;
						$firstPoint->timezone=$this->timezone;
					}

					// sanity checks	
					if ( $firstPoint->getAlt()  > $this->maxAllowedHeight ) continue;
					// echo "times: ".$firstPoint->gpsTime.", ".$firstPoint->getTime()." start_time: ".$this->START_TIME ."<BR> ";
					if ( $this->forceBounds && ! $this->checkBound($firstPoint->getTime() ) ) continue; // not inside time window

					$this->FIRST_POINT=$line;
					$this->TAKEOFF_ALT= $firstPoint->getAlt();
					$this->MIN_ALT= $firstPoint->getAlt();
					if ( ! $this->forceBounds) $this->START_TIME = $firstPoint->getTime();
					$prevPoint=new gpsPoint($line,$this->timezone);
				} else  {					
					$lastPoint=new gpsPoint($line,$this->timezone);
					$lastPoint->gpsTime+=$day_offset;

					if ( $this->forceBounds && ! $this->checkBound($lastPoint->getTime() ) ) {
						 $lastPoint=$prevPoint; 
						 continue; // not inside time window
					}
					
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
						// if we are forceBounds check to see if inside window
						if ( ( $this->forceBounds && ! $this->checkBound($lastPoint->getTime() )  ) || !$this->forceBounds ) { 
							// not inside time window  OR not checking go ahead				
							$lastPoint=$prevPoint;
							$foundNewTrack=1;
							DEBUG("IGC",1,"[$points] $line<br>");
							DEBUG("IGC",1,"[$points] Found a new track (Time diff of $time_diff secs)<br>");
							continue;	
						} else { // inside the window, forced to continue 
						
						}
					}
				
					$this->LAST_POINT=$line;
					// compute some things
					$tmp = $lastPoint->calcDistance($prevPoint);
					$alt = $lastPoint->getAlt();
					$deltaseconds = $lastPoint->getTime() - $prevPoint->getTime() ;						
					$speed = ($deltaseconds)?$tmp*3.6/($deltaseconds):0.0; /* in km/h */
					if ($deltaseconds) $vario=($alt-$prevPoint->getAlt() ) / $deltaseconds;

					if (!$garminSpecialCase && ! $this->forceBounds) {
						if ( ($fast_points>=5 || $fast_points_dt>30) && $stillOnGround) { // found 5 flying points or 30 secs
							$stillOnGround=0;
							DEBUG("IGC",1,"[$points] $line<br>");
							DEBUG("IGC",1,"[$points] Found Takeoff <br>");
						}
										
						if ($stillOnGround) { //takeoff scan
							// either speed >= 15 or if we already have 2 fast points settle with speed>=10
							if ($speed >= 15 ||  ( $speed >= 10 && $fast_points>=2 ) ) { 
								$fast_points++;		
								$fast_points_dt+=$deltaseconds;	
								DEBUG("IGC",1,"[$points] $line<br>");
								DEBUG("IGC",1,"[$points] Found a fast speed point <br>");																
							} else { // reset takeoff scan
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
								DEBUG("IGC",1,"[$points] Found a slow speed point (speed, dt)=($speed,$deltaseconds)<br>");																
							} else {
								$slow_points=0;
								$slow_points_dt=0;
							}
						}					
	
						// found landing (5 stopped points and >2mins) or 5 mins (300 secs)
						if ( ($slow_points>5 && $slow_points_dt>180)  || $slow_points_dt>300) { 
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
		if (!$handle = fopen($this->getIGCFilename(1), 'w')) { 
			print "Cannot open file (".$this->getIGCFilename(1).")"; 		
		} 
		if (!fwrite($handle, $outputBuffer)) { 
		   print "Cannot write to file (".$this->getIGCFilename(1).")"; 
		} 
		fclose($handle); 
		
		//$handle=fopen($this->getIGCFilename(1),"w");
		//fwrite($handle, $outputBuffer) ;
		//fclose($handle);

		$this->LANDING_ALT= $lastPoint->getAlt();
		$this->END_TIME =   $lastPoint->getTime();
		$this->DURATION =   $this->END_TIME - $this->START_TIME ;
		$this->MEAN_SPEED = $this->MEAN_SPEED / $points;
				
		return 1;	
	} // end function getFlightFromIGC()

	function checkAirspace($updateFlightInDB=0) {
		global $CONF_airspaceChecks;
		if (!$CONF_airspaceChecks) return 1;

		require_once dirname(__FILE__).'/FN_airspace.php';
		set_time_limit (140);	
		
		$resStr=checkAirspace($this->getIGCFilename());
		DEBUG("checkAirspace",1,"Airspace check:");
		if (!$resStr) {
			DEBUG("checkAirspace",1,"CLEAR");
			$this->airspaceCheck=1;
			if ( $this->airspaceCheckFinal==0) $this->airspaceCheckFinal=1; // only set it if undefined
			$this->airspaceCheckMsg="";
		} else  {
			DEBUG("checkAirspace",1,$resStr);
			$this->airspaceCheck=-1;
			if ( $this->airspaceCheckFinal==0) $this->airspaceCheckFinal=-1; // only set it if undefined
			$this->airspaceCheckMsg=$resStr;
		}

		if ( $updateFlightInDB ) $this->putFlightToDB(1);
	}

	function validate($updateFlightInDB=1) {
		global $CONF_validation_server_url, $CONF_use_custom_validation, $DBGlvl;
		global $baseInstallationPath,$CONF_abs_path;

		global $alreadyValidatedInPage;
		if ($alreadyValidatedInPage) return;
		$alreadyValidatedInPage=1;

		set_time_limit (240);	
		$customValidationCodeFile=dirname(__FILE__)."/site/CODE_validate_custom.php";
		if (  $CONF_use_custom_validation && file_exists($customValidationCodeFile) ) { // we expect the result on $ok
			include $customValidationCodeFile;
		} else { //standard leoanrdo validation -> the server not yet working 
			$IGCwebPath=urlencode("http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/").$this->getIGCRelPath(0); // validate original file
			$fl= $CONF_validation_server_url."?file=".$IGCwebPath;
			if ($DBGlvl) $fl.="&dbg=1";
			DEBUG("VALIDATE_IGC",1,"Will use URL: $fl<BR>");
			$contents =	split("\n",fetchURL($fl,30));
			if (!$contents) return 0;
	
			foreach ( $contents as $line) DEBUG("VALIDATE",64,"$line");
			$ok=-1;
			if (trim($contents[0])=="OK") { 
				$ok=1;
				$valStr=trim($contents[1]);
			}
		}

		//	 -1 => invalid 0 => not yet proccessed  1 => valid
		// force ok=1 till we have a validation server ready
		// $ok=1;

		$this->grecord=$ok;
		$this->validated=$ok;
		$this->validationMessage=$valStr;
		if ( $updateFlightInDB ) $this->putFlightToDB(1);

		return $ok;
	}
	
	function getOLCscore() {
		global $OLCScoringServerPath, $scoringServerActive , $OLCScoringServerPassword;
		global $baseInstallationPath,$CONF_allow_olc_files;

		if (! $scoringServerActive) return 0;
		$manualScore=0;
		
		if ($CONF_allow_olc_files) {
			// see if there is an OLC file present
			$OLCfilename=$this->getIGCFilename().".olc";
	
			if (file_exists($OLCfilename) ) { 
				DEBUG("OLC_SCORE",1,"OLC pre-optimized is used instead");		
			
				$lines=file($OLCfilename);
	/*
	4624328N00805128E
	4632522N00819212E
	4617978N00733326E
	4609910N00755225E
	4609910N00755225E
	118.68765887809
	207.70340303666
	1.75
	*/
				$this->FLIGHT_KM=$lines[5]*1000;
				$this->FLIGHT_POINTS=$lines[6]+0;
				$factor=$lines[7]+0;
				if ($factor==1.5) 	$this->BEST_FLIGHT_TYPE="FREE_FLIGHT";
				if ($factor==1.75) 	$this->BEST_FLIGHT_TYPE="FREE_TRIANGLE";
				if ($factor==2) 	$this->BEST_FLIGHT_TYPE="FAI_TRIANGLE";
				
				DEBUG('OLC_SCORE',1,"MANUAL FLIGHT_KM: ".$this->FLIGHT_KM."<BR>");
				DEBUG('OLC_SCORE',1,"MANUAL FLIGHT_POINTS: ".$this->FLIGHT_POINTS."<BR>");
				DEBUG('OLC_SCORE',1,"MANUAL BEST_FLIGHT_TYPE: ".$this->BEST_FLIGHT_TYPE."<BR>");
				for($i=0;$i<5;$i++) {				
				    //              01234567890123456
					// must convert 4624328N00805128E to N54:54.097 W02:40.375 
					$str=substr($lines[$i],7,1) .substr($lines[$i],0,2).':'.substr($lines[$i],2,2).'.'.substr($lines[$i],4,3).' '.
						 substr($lines[$i],16,1).substr($lines[$i],8,3).':'.substr($lines[$i],11,2).'.'.substr($lines[$i],13,3);
					DEBUG('OLC_SCORE',1,"MANUAL TurnPoint ".($i+1).": $str<BR>");
					$this->{'turnpoint'.($i+1)}=$str;				
				}
				$manualScore=1;
			}
		}
				
		set_time_limit (240);	
		$IGCwebPath=urlencode("http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/").$this->getIGCRelPath(1); // score saned file

		$fl= $OLCScoringServerPath."?pass=".$OLCScoringServerPassword."&file=".$IGCwebPath;
		DEBUG("OLC_SCORE",1,"Will use URL: $fl<BR>");
		//$contents = file($fl); 
		$contents =	split("\n",fetchURL($fl,40));
		if (!$contents) return;
				
		$turnpointNum=1;
		foreach(  $contents  as $line) {	
			if (!$line) continue;		
			DEBUG("OLC_SCORE",1,"LINE: $line<BR>\n");
			$var_name  = strtok($line,' '); 
			$var_value = strtok(' '); 
			if ($var_name{0}=='p' ) {
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
			
			if (! $manualScore) {
				$this->$var_name=trim($var_value);				
			} else {				
				if ($var_name=='MAX_LINEAR_DISTANCE') $this->$var_name=trim($var_value);
				if ($var_name=='FLIGHT_POINTS') $this->autoScore=trim($var_value);
			}
			
			DEBUG("OLC_SCORE",1,"#".$var_name."=".$var_value."#<br>\n");
		}		
		if (! $manualScore) $this->FLIGHT_KM=$this->FLIGHT_KM*1000;
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
	  global $db,$prefix,$CONF_photosPerFlight;
  	  global $flightsTable;
	  global $nativeLanguage,$currentlang;
	  
	  $query="SELECT * FROM $flightsTable  WHERE ID=".$flightID." ";

	  $res= $db->sql_query($query);	
	  # Error checking
	  if($res <= 0){
		 echo("<H3> Error in FlightShow query! $query</H3>\n");
		 exit();
	  }
		
	  if (! $row = $db->sql_fetchrow($res) ) {
		  return 0;	  
	  }
	  
		$this->flightID=$flightID;
		$name=getPilotRealName($row["userID"],$row["userServerID"]);
		$this->userName=$name;		
		 
		$this->serverID=$row["serverID"];
		$this->originalURL=$row["originalURL"];
		$this->original_ID=$row["original_ID"];

		$this->originalUserID=$row["originalUserID"];
		$this->userServerID=$row["userServerID"];

		$this->NACclubID=$row["NACclubID"];
		$this->cat=$row["cat"];		
		$this->subcat=$row["subcat"];	
		$this->category=$row["category"];		
		$this->active=$row["active"];		
		$this->private=$row["private"];		

		$this->validated=$row["validated"];		
		$this->grecord=$row["grecord"];		
		$this->validationMessage=$row["validationMessage"];	

		$this->airspaceCheck=$row["airspaceCheck"]+0;
		$this->airspaceCheckFinal=$row["airspaceCheckFinal"]+0;
		$this->airspaceCheckMsg=$row["airspaceCheckMsg"];
		$this->checkedBy=$row["checkedBy"];

		$this->timesViewed=$row["timesViewed"];		
		$this->dateAdded=$row["dateAdded"];		
		$this->timezone=$row["timezone"];		

		$this->filename=$row["filename"];
		$this->userID=$row["userID"];
		$this->comments=$row["comments"];
		
		$this->glider=$row["glider"];  
		$this->linkURL=$row["linkURL"];

		for($i=1;$i<=$CONF_photosPerFlight;$i++) {
			$var_name="photo".$i."Filename";
			$this->$var_name=$row[$var_name];
		}

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
		$this->autoScore=$row["autoScore"];	

		$this->hash=$row["hash"];	

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
		return 1;	
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
		global $CONF_photosPerFlight,$CONF_server_id;

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
		@unlink($this->getPointsFilename(1) ) ;
		@unlink($this->getJsFilename(1) );
		@unlink($this->getIGCFilename(0).".olc" ); 
		@unlink($this->getIGCFilename(0).".kmz" ); 
		@unlink($this->getIGCFilename(0).".man.kmz" ); 
		@unlink($this->getIGCFilename(0).".poly.txt" ); 
		@unlink($this->getMapFilename() ); 

		for ($metric_system=1;$metric_system<=2;$metric_system++) {
			for ($raw=0;$raw<=1;$raw++) {
				@unlink($this->getChartFilename("alt",$metric_system,$raw) ); 
				@unlink($this->getChartFilename("speed",$metric_system,$raw) ); 
				@unlink($this->getChartFilename("vario",$metric_system,$raw) ); 
				@unlink($this->getChartFilename("takeoff_distance",$metric_system,$raw) ); 		
			}
		}

		for($i=1;$i<=$CONF_photosPerFlight;$i++) {
			$this->deletePhoto($i);
		}

		require_once dirname(__FILE__).'/CL_actionLogger.php';
		$log=new Logger();
		$log->userID  	=$this->userID;
		$log->ItemType	=1 ; // flight; 
		$log->ItemID	= $this->flightID; // 0 at start will fill in later if successfull
		$log->ServerItemID	=$CONF_server_id ;
		$log->ActionID  = 4 ;  //1  => add  2  => edit; 4  => delete
		$log->ActionXML	= $this->toXML();
		$log->Modifier	= 0;
		$log->ModifierID= 0;
		$log->ServerModifierID =0;
		$log->Result = 1;
		if (!$log->Result) $log->ResultDescription ="Problem in deleting flight  $query";
		if (!$log->put()) echo "Problem in logger<BR>";
	}

    function putFlightToDB($update=0) {
		global $db;
		global $flightsTable,$CONF_photosPerFlight,$CONF_server_id;

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
		
		for($i=1;$i<=$CONF_photosPerFlight;$i++) {
			$var_name="photo".$i."Filename";			
			$p1.="$var_name, ";
			$p2.="'".$this->$var_name."',";
		}
		
		$query.=" $flightsTable (".$fl_id_1."filename,userID,
		cat,subcat,category,active, private ,
		validated,grecord,validationMessage, 
		hash, serverID, originalURL, original_ID,
		originalUserID ,userServerID,

		airspaceCheck,airspaceCheckFinal,airspaceCheckMsg,checkedBy,
		NACclubID,
		comments, glider, linkURL, timesViewed,
		$p1
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
		autoScore,
		FIRST_POINT,LAST_POINT,
		turnpoint1,turnpoint2,turnpoint3,turnpoint4,turnpoint5,
		olcRefNum,olcFilename,olcDateSubmited
		)
		VALUES (".$fl_id_2."'$this->filename',$this->userID,  
		$this->cat,$this->subcat,$this->category,$this->active, $this->private,
		$this->validated, $this->grecord, '".prep_for_DB($this->validationMessage)."',
		'$this->hash',  $this->serverID, '$this->originalURL', $this->original_ID, 
		$this->originalUserID , $this->userServerID,

		$this->airspaceCheck, $this->airspaceCheckFinal, '".prep_for_DB($this->airspaceCheckMsg)."','".prep_for_DB($this->checkedBy)."',
		$this->NACclubID,
		'".prep_for_DB($this->comments)."', '".prep_for_DB($this->glider)."', '".prep_for_DB($this->linkURL)."', $this->timesViewed ,
		$p2
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
		$this->autoScore,
		'$this->FIRST_POINT',
		'$this->LAST_POINT',
		'$this->turnpoint1','$this->turnpoint2','$this->turnpoint3','$this->turnpoint4','$this->turnpoint5',
		'$this->olcRefNum','$this->olcFilename','$this->olcDateSubmited'
		)";
	
		//echo $query;
		$result = $db->sql_query($query);
		if (!$result) {
			echo "Problem in puting flight to DB $query<BR>";
		}
		//echo "UPDATE / INSERT RESULT ".$result ;
		if (!$update) $this->flightID=mysql_insert_id();


		require_once dirname(__FILE__).'/CL_actionLogger.php';
		$log=new Logger();
		$log->userID  	=$this->userID;
		$log->ItemType	=1 ; // flight; 
		$log->ItemID	= $this->flightID; // 0 at start will fill in later if successfull
		$log->ServerItemID	=$CONF_server_id ;
		$log->ActionID  = $update+1 ;  //1  => add  2  => edit;
		$log->ActionXML	= $this->toXML();
		$log->Modifier	= 0;
		$log->ModifierID= 0;
		$log->ServerModifierID =0;
		$log->Result = ($result?1:0);
		if (!$log->Result) $log->ResultDescription ="Problem in puting flight to DB $query";
		if (!$log->put()) echo "Problem in logger<BR>";
	}

	function makeLogEntry() {
		global $CONF_server_id ;
		require_once dirname(__FILE__).'/CL_actionLogger.php';
		$log=new Logger();
		$log->userID  	=$this->userID;
		$log->ItemType	=1 ; // flight; 
		$log->ItemID	= $this->flightID; // 0 at start will fill in later if successfull
		$log->ServerItemID	=$CONF_server_id ;
		$log->ActionID  = 1 ;  //1  => add  2  => edit;
		$log->ActionXML	= $this->toXML();
		$log->Modifier	= 0;
		$log->ModifierID= 0;
		$log->ServerModifierID =0;
		$log->Result = 1;
		
		if (!$log->put()) echo "Problem in logger<BR>";
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
 	    $this->updateCharts($forceRefresh,1);
	}

    function updateCharts($forceRefresh=0,$rawCharts=0) {
		global $moduleRelPath,$chartsActive;
		if (!$chartsActive ) return 0;

	 	$alt_img_filename=$this->getChartFilename("alt",1,$rawCharts); 
		$speed_img_filename=$this->getChartFilename("speed",1,$rawCharts); 
		$vario_img_filename=$this->getChartFilename("vario",1,$rawCharts); 
		$takeoff_distance_img_filename=$this->getChartFilename("takeoff_distance",1,$rawCharts);  
	
 		$alt_img_filename2=$this->getChartFilename("alt",2,$rawCharts); 
		$speed_img_filename2=$this->getChartFilename("speed",2,$rawCharts); 
		$vario_img_filename2=$this->getChartFilename("vario",2,$rawCharts); 
		$takeoff_distance_img_filename2=$this->getChartFilename("takeoff_distance",2,$rawCharts);  

		if ( !is_file($alt_img_filename) ||  !is_file($speed_img_filename) ||  
			 !is_file($vario_img_filename) ||  !is_file($takeoff_distance_img_filename) || 
			 !is_file($alt_img_filename2) ||  !is_file($speed_img_filename2) ||  
			 !is_file($vario_img_filename2) ||  !is_file($takeoff_distance_img_filename2) ||
			 !is_file($this->getJsFilename(1)) ||  $forceRefresh) {
	
			// list ($data_time,$data_alt,$data_speed,$data_vario,$data_takeoff_distance)=$this->getAltValues();
			
			if ($rawCharts)  {
				list ($data_time,$data_alt,$data_speed,$data_vario,$data_takeoff_distance)=$this->getRawValues($forceRefresh);
				//list ($data_time,$data_alt,$data_speed,$data_vario,$data_takeoff_distance,$data_X,$data_Y)=$this->getRawValues($forceRefresh,1);
			} else	
				list ($data_time,$data_alt,$data_speed,$data_vario,$data_takeoff_distance)=$this->getAltValues();

			if (!count($data_time) ) return; // empty timeseries


			require_once dirname(__FILE__)."/lib/graph/jpgraph_gradient.php";
			require_once dirname(__FILE__)."/lib/graph/jpgraph_plotmark.inc" ;
	
			require_once dirname(__FILE__)."/lib/graph/jpgraph.php";
			require_once dirname(__FILE__)."/lib/graph/jpgraph_line.php";

/*
require_once dirname(__FILE__)."/CL_dem.php";
$ground=array();
foreach ($data_time as $i=>$tm) {
	$ground[$i]=DEM::getAlt($data_Y[$i],$data_X[$i]);
	echo $ground[$i]."#";

}
*/
		 	$this->plotGraph("Height (m)",$data_time,$data_alt,$alt_img_filename,$rawCharts);
			//$this->plotGraph("Height (m)",$data_time,$ground,$alt_img_filename,$rawCharts);
			$this->plotGraph("Speed (km/h)",$data_time,$data_speed,$speed_img_filename,$rawCharts);
			$this->plotGraph("Vario (m/sec)",$data_time,$data_vario,$vario_img_filename,$rawCharts);
			$this->plotGraph("Takeoff distance (km)",$data_time,$data_takeoff_distance,$takeoff_distance_img_filename,$rawCharts);	

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

			$this->plotGraph("Height (feet)",$data_time,$data_alt,$alt_img_filename2,$rawCharts);
			$this->plotGraph("Speed (mph)",$data_time,$data_speed,$speed_img_filename2,$rawCharts);
			$this->plotGraph("Vario (fpm)",$data_time,$data_vario,$vario_img_filename2,$rawCharts);
			$this->plotGraph("Takeoff distance (miles)",$data_time,$data_takeoff_distance,$takeoff_distance_img_filename2,$rawCharts);	

		}

	}

	function plotGraph($title,$data_time,$yvalues,$img_filename,$raw=0) {
		
		if (count($data_time)==0) {
			$data_time[0]=0;
			$yvalues[0]=0;
		}
		if ($raw) {
			$graphWidth=600;
			$graphHeight=120;
			$mLeft=40;
			$mRight=20;
			$mTop=13;
			$mBottom=23;
			$titleSize=8;
			$labelSize=6;

		}	else {
			$graphWidth=600;
			$graphHeight=200;
			$mLeft=40;
			$mRight=20;
			$mTop=20;
			$mBottom=30;

			$titleSize=10;
			$labelSize=8;
		}

		$graph = new Graph($graphWidth,$graphHeight,"auto");    
		//$graph->SetScale("textlin",min($yvalues),max($yvalues));
		$graph->SetScale("textlin");

		if ($raw) {
			$graph->title->SetFont(FF_FONT1,FS_NORMAL,$titleSize); 
			$graph->legend->SetFont(FF_FONT1,FS_NORMAL,$titleSize); 
			$graph->xaxis->SetFont(FF_FONT1,FS_NORMAL,$labelSize); 
		}

		$graph->SetMarginColor("#C8C8D4");	
		// #DAE4E6

		// if only one point  add it twice ! 
		// we should nt be here at the first place !
		if (count($data_time)==1) {
			$yvalues[1]=$yvalues[0];
			$data_time[1]=$data_time[0];
		}
		//echo "$title -> max:".max($yvalues)." min: ".min($yvalues)." data_time_num: ".count($data_time)."<BR>";
		$lineplot=new LinePlot($yvalues);
		$graph->Add($lineplot);

		$graph->img->SetMargin($mLeft,$mRight,$mTop,$mBottom);
		if (!$raw) $graph->title->Set($title);
		
		$textTickInterval=floor((count($data_time)/($graphWidth-$mLeft-$mRight))*60-1);
		if ($textTickInterval<=0 ) $textTickInterval=1;
		
		$graph->xaxis->SetTextTickInterval($textTickInterval);
		$graph->xaxis->SetTextLabelInterval(1);
		$graph->xaxis->SetTickLabels($data_time);
		$graph->xaxis->SetPos("min");

		$graph->xgrid->Show();
		$graph->xgrid->SetLineStyle('dashed');
		

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
		$query="SELECT ID FROM $flightsTable WHERE userID=".$this->userID." AND filename=\"".$filename."\" ";
		// echo $query;
		$res= $db->sql_query($query);
		if ($res<=0) return 0; // no duplicate found

		$row = $db->sql_fetchrow($res);
		return $row["ID"]; // found duplicate retrun the ID; 
	}

	function findSameHash($hash) {
		global $db;
		global $flightsTable;
		$query="SELECT ID FROM $flightsTable WHERE hash='$hash' ";
		// echo $query;
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

	// assigns the flight to a new user
	function changeUser($newUserID,$newUserServerID) {
		global $flightsAbsPath,$CONF_photosPerFlight;

		$pilotDir=$this->getPilotAbsDir();
		
		if ($newUserServerID) $extra_prefix=$newUserServerID.'_';
		else $extra_prefix='';
		$newPilotDir=$flightsAbsPath."/".$extra_prefix.$newUserID;

		$flightYear=$this->getYear();
		$subdirs=array('flights','charts','maps');
		foreach ($subdirs as $subdir){
			$sourceDir="$pilotDir/$subdir/$flightYear";
			$targetDir="$newPilotDir/$subdir/$flightYear";
			
			if ($handle = opendir($sourceDir)) {
				while (false !== ($file = readdir($handle))) {
					if (  substr( $file,0,strlen($this->filename) )==$this->filename  ) {
						// echo "$file\n";
						$filesToMove[$sourceDir.'/'.$file]=$targetDir.'/'.$file;
					}
				}
				closedir($handle);
			}
		}

		for($i=1;$i<=$CONF_photosPerFlight;$i++) {
			$var_name="photo".$i."Filename";			
			$file=$this->$var_name;
			if ($file) {
				$sourceDir="$pilotDir/photos/$flightYear";
				$targetDir="$newPilotDir/photos/$flightYear";
				$filesToMove[$sourceDir.'/'.$file]=$targetDir.'/'.$file;
			}
		}

		array_push($subdirs,'photos');
		foreach ($subdirs as $subdir){
			makeDir("$newPilotDir/$subdir");
		}

		foreach ($filesToMove as $src=>$target){
			makeDir($target);
			@rename($src,$target);
		}

		$this->userID=$newUserID;
		$this->userServerID=$newUserServerID;
		$this->putFlightToDB(1);

	}


 } // end of class
?>
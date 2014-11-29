<?
//************************************************************************
// Leonardo XC Server, http://www.leonardoxc.net
//
// Copyright (c) 2004-2010 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: CL_flightData.php,v 1.196 2012/09/17 22:33:48 manolis Exp $
//
//************************************************************************

require_once dirname(__FILE__)."/CL_gpsPoint.php";
require_once dirname(__FILE__)."/CL_flightPhotos.php";
require_once dirname(__FILE__).'/CL_flightScore.php';
require_once dirname(__FILE__).'/CL_comments.php';
require_once dirname(__FILE__)."/CL_brands.php";
require_once dirname(__FILE__)."/CL_dates.php";
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
    var $commentsNum=0;
    var $glider="";
	var $gliderBrandID=0;

	var $startType=0;
	
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
	/// Martin Jursa, 17.05.2007
	var $NACid=0;

	var $airspaceCheck=0; // not yet processed
	var $airspaceCheckFinal=0; // not yet processed
	var $airspaceCheckMsg="";
	var $checkedBy="";

	var $hash='';

	var $serverID=0;
	var $excludeFrom=0;

	var $originalURL='';
	var $originalKML='';

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

var $START_TIME=0;
var $END_TIME=0;
var $DURATION=0;

//var $MAX_LINEAR_DISTANCE=0 ;
//var $BEST_FLIGHT_TYPE="";
//var $FLIGHT_KM=0;
//var $FLIGHT_POINTS=0;

//var $FIRST_POINT="";
//var $LAST_POINT="";

var $turnpoint1="";
var $turnpoint2="";
var $turnpoint3="";
var $turnpoint4="";
var $turnpoint5="";

var $autoScore=0;

var $olcRefNum="";
var $olcFilename="";
var $olcDateSubmited;

var $flightScore;
var $flightComments;
var $commentsEnabled=1;

/*
#externalFlightType
#	0 -> local flight
#	1- > SYNC_INSERT_FLIGHT_LINK (extllink  linked to external disply , only scroing info into DB)
#	2 -> SYNC_INSERT_FLIGHT_LOCAL (extflight IGC imported locally)
#isLive
#	0 -> not a live flight
#	1 -> in progress liveflight in progress, only basic info into db and link to actual display/server
#	2 -> finalized , liveflight finilized IGC imported locally
#
#forceBounds
#	1-> auto detect start/end
#	0-> set by user /admin
*/
var	$externalFlightType=0;
var $isLive=0;
var $firstPointTM=0;
var $firstLat=0;
var $firstLon=0;
var	$lastPointTM=0;
var $lastLat=0;
var $lastLon=0;

	var $hasPhotos=0;
	var $photos=array();

// CONSTANTS
var	$maxAllowedSpeed=100;
var	$maxAllowedVario=13;
var $maxAllowedHeight=9000;

var $max_allowed_time_gap=1800; //  30 mins

var $maxPointNum=1000;
//---------------
// CONSTRUCTOR
    function flight() {
		global $CONF;
		$this->startType=$CONF['defaultStartType'];
		
		$this->commentsEnabled=1;
		
    	# Martin Jursa, 30.05.2007: make time gap configurable
		global $CONF_max_allowed_time_gap;
		if (!empty($CONF_max_allowed_time_gap)) {
			$this->max_allowed_time_gap=$CONF_max_allowed_time_gap;
		}
    }

	function belongsToUser($userID) {
		global $CONF_server_id ;
		if ( 	$this->userID == $userID &&
				($this->userServerID==$CONF_server_id || $this->userServerID==0 )
			) return 1;
		else return 0;

	}

	function checkGliderBrand($gliderBrand='') {

		if (! $this->gliderBrandID ) {

			if ($gliderBrand) {
				$gliderBrandID=brands::guessBrandID($gliderBrand );
			}	else {
				$gliderBrandID=brands::guessBrandID($this->glider );
			}

			if ($gliderBrandID){
				global $CONF;
				if (!$gliderBrand) {
					if (!function_exists('str_ireplace')) {
						function str_ireplace($needle, $str, $haystack) {
							$needle = preg_quote($needle, '/');
							return preg_replace("/$needle/i", $str, $haystack);
						}
					}  else {
						$gliderName=str_ireplace($CONF['brands']['list'][$gliderBrandID],'',$this->glider);
					}
				} else {
					$gliderName=$this->glider;
				}

				$gliderName=brands::sanitizeGliderName($gliderName);
				$this->glider=$gliderName;
				$this->gliderBrandID=$gliderBrandID;
			}
		}
	}

	function checkDirs($userDir='',$year=0) {
		global $CONF;
		
		if ($userDir=='' || $year==0){
			$userDir=$this->getPilotID();
			$year=$this->getYear();
		}
		
		$d=0;
		$dirs=array();
		$dirs[$d++]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$CONF['paths']['igc']) );
		$dirs[$d++]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$CONF['paths']['photos']) );
		$dirs[$d++]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$CONF['paths']['map']) );
		$dirs[$d++]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$CONF['paths']['charts']) );
		$dirs[$d++]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$CONF['paths']['kml']) );
		$dirs[$d++]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$CONF['paths']['js']) );
		$dirs[$d++]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$CONF['paths']['intermediate']) );
		
		foreach($dirs as $dir) {
			$dirPath=LEONARDO_ABS_PATH.'/'.$dir;
			if (!is_dir($dirPath))  	makeDir($dirPath);
		}
	}

	function toXML($forceProtocol=''){
		/*	maybe also include these
		"forceBounds"		"autoScore"
		*/
		global $CONF_server_id,$CONF_photosPerFlight, $CONF;

		if ($CONF['sync']['protocol']['format']=='JSON' && $forceProtocol!='XML' || $forceProtocol=='JSON') {
			$useJSON=1;
			require_once dirname(__FILE__).'/lib/json/CL_json.php';
		} else $useJSON=0;

		if ($this->flightScore) {
			$flightScore=&$this->flightScore;
			if (!$flightScore->gotValues) {
				$flightScore->getFromDB();
			}
		}  else {
			$flightScore=new flightScore($this->flightID);
			$flightScore->getFromDB();
		}

		$defaultMethodID= $CONF['scoring']['default_set'];
		$scoreDetails=$flightScore->scores[$defaultMethodID][ $flightScore->bestScoreType ];

		$tpNum=0;
		$tpStr='';
		for($i=1;$i<=7;$i++) {
			if ($scoreDetails['tp'][$i]) {
				$newPoint=new gpsPoint($scoreDetails['tp'][$i]);
				if ($tpNum>0) $tpStr.=" ,\n		";
				$tpStr.=' {"id": '.$i.' , "lat": '.$newPoint->lat().', "lon": '.$newPoint->lon().', "UTCsecs": '.($newPoint->gpsTime+0).' } ';
				$tpNum++;
			}
		}


		$takeoff=new waypoint($this->takeoffID);
		$takeoff->getFromDB();

//		$firstPoint=new gpsPoint($this->FIRST_POINT,$this->timezone);
//		$lastPoint=new gpsPoint($this->LAST_POINT,$this->timezone);

		$firstPoint=new gpsPoint('',$this->timezone);
		$firstPoint->setLat($this->firstLat);
		$firstPoint->setLon($this->firstLon);
		$firstPoint->gpsTime=$this->firstPointTM;

		$lastPoint=new gpsPoint('',$this->timezone);
		$lastPoint->setLat($this->lastLat);
		$lastPoint->setLon($this->lastLon);
		$lastPoint->gpsTime=$this->lastPointTM;

		list($lastName,$firstName,$pilotCountry,$Sex,$Birthdate,$CIVL_ID)=getPilotInfo($this->userID,$this->userServerID);

		$userServerID=$this->userServerID;
		if ($userServerID==0) $userServerID=$CONF_server_id;

		// will be changed when dateAdded will be UTC
		$dateAdded=$this->dateAdded;

		// We changed this, dateAdded is in UTC from now on !!!!
		// So the conversion is not needed
		//$dateAdded=tm2fulldate(fulldate2tm($dateAdded)-date('Z')); // convert to UTC


		if (  $this->serverID==0 || $this->serverID==$CONF_server_id ) $isLocal=1;
		else $isLocal=0;

		if (!$useJSON) {
		$resStr=
"<flight>
<serverID>$CONF_server_id</serverID>
<id>$this->flightID</id>
<dateAdded>$dateAdded</dateAdded>
<filename>$this->filename</filename>
<linkIGC>".$this->getIGC_URL()."</linkIGC>
<linkIGCzip>".$this->getZippedIGC_URL()."</linkIGCzip>
<linkDisplay>".htmlspecialchars($this->getFlightLinkURL())."</linkDisplay>
<linkGE>".htmlspecialchars($this->getFlightKML(0))."</linkGE>

<info>
	<glider>$this->glider</glider>
	<gliderBrandID>$this->gliderBrandID</gliderBrandID>
	<gliderCat>$this->cat</gliderCat>
	<cat>$this->category</cat>
	<linkURL>$this->linkURL</linkURL>
	<private>$this->private</private>
	<comments>$this->comments</comments>
</info>

<time>
	<date>$this->DATE</date>
	<Timezone>$this->timezone</Timezone>
	<StartTime>$this->START_TIME</StartTime>
	<Duration>$this->DURATION</Duration>
</time>

<pilot>
	<userID>$this->userID</userID>
	<serverID>$userServerID</serverID>
	<civlID>$CIVL_ID</civlID>
	<userName>$this->userName</userName>
	<pilotFirstName>$firstName</pilotFirstName>
	<pilotLastName>$lastName</pilotLastName>
	<pilotCountry>$pilotCountry</pilotCountry>
	<pilotBirthdate>$Birthdate</pilotBirthdate>
	<pilotSex>$Sex</pilotSex>
</pilot>

<location>
	<firstLat>$firstPoint->lat</firstLat>
	<firstLon>".$firstPoint->lon()."</firstLon>
	<takeoffID>$this->takeoffID</takeoffID>
	<serverID>$CONF_server_id</serverID>
	<takeoffVinicity>$this->takeoffVinicity</takeoffVinicity>
	<takeoffName>$takeoff->name</takeoffName>
	<takeoffNameInt>$takeoff->intName</takeoffNameInt>
	<takeoffCountry>$takeoff->countryCode</takeoffCountry>
	<takeoffLocation>$takeoff->location</takeoffLocation>
	<takeoffLocationInt>$takeoff->intlocation</takeoffLocationInt>
	<takeoffLat>$takeoff->lat</takeoffLat>
	<takeoffLon>".$takeoff->lon()."</takeoffLon>
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


</flight>\n";
		} else {
$resStr='{
"flight": {
	"serverID": '. ( $this->serverID?$this->serverID:$CONF_server_id).',
	"id": '.($isLocal ? $this->flightID : $this->original_ID  ).',
	"dateAdded": "'.$dateAdded.'",
	"filename": "'.json::prepStr($this->filename).'",
	"linkIGC": "'.json::prepStr($this->getIGC_URL()).'",
	"linkIGCzip": "'.json::prepStr($this->getZippedIGC_URL()).'",
	"linkDisplay": "'.($isLocal ? 	json::prepStr($this->getFlightLinkURL()):
									json::prepStr($this->getOriginalURL()) ).'",
	"linkGE": "'.($isLocal ? json::prepStr($this->getFlightKML(0)) :
							 json::prepStr($this->getOriginalKML()) ).'",
	"isLive": '.$this->isLive.',

	"info": {
		"glider": "'.json::prepStr($this->glider).'",
		"gliderBrandID": '.$this->gliderBrandID.',
		"gliderBrand": "'.json::prepStr($CONF['brands']['list'][$this->gliderBrandID]).'",
		"gliderCat": '.$this->cat.',
		"cat": '.$this->category.',
		"linkURL": "'.json::prepStr($this->linkURL).'",
		"private": '.$this->private.',
		"comments": "'.json::prepStr($this->comments).'"
	},

	"time": {
		"date": "'.json::prepStr($this->DATE).'",
		"Timezone": "'.$this->timezone.'",
		"StartTime": "'.$this->START_TIME.'",
		"Duration": "'.$this->DURATION.'"
	},

	"bounds": {
		"forceBounds": '.$this->forceBounds.',
		"firstLat": '.$firstPoint->lat().',
		"firstLon": '.$firstPoint->lon().',
		"firstTM": '.($firstPoint->gpsTime+0).',
		"lastLat": '.$lastPoint->lat().',
		"lastLon": '.$lastPoint->lon().',
		"lastTM": '.($lastPoint->gpsTime+0).'
	},

	"pilot": {
		"userID": "'.$this->userID.'",
		"serverID": "'.$userServerID.'",
		"civlID": "'.$CIVL_ID.'",
		"userName": "'.json::prepStr($lastName.' '.$firstName).'",
		"pilotFirstName": "'.json::prepStr($firstName).'",
		"pilotLastName": "'.json::prepStr($lastName).'",
		"pilotCountry": "'.$pilotCountry.'",
		"pilotBirthdate": "'.json::prepStr($Birthdate).'",
		"pilotSex": "'.$Sex.'"
	},

	"location": {
		"takeoffID": "'.($this->takeoffID+0).'",
		"serverID": "'.$CONF_server_id.'",
		"takeoffVinicity": "'.$this->takeoffVinicity.'",
		"takeoffName": "'.json::prepStr($takeoff->name).'",
		"takeoffNameInt": "'.json::prepStr($takeoff->intName).'",
		"takeoffCountry": "'.$takeoff->countryCode.'",
		"takeoffLocation": "'.json::prepStr($takeoff->location).'",
		"takeoffLocationInt": "'.json::prepStr($takeoff->intlocation).'",
		"takeoffLat": "'.$takeoff->lat().'",
		"takeoffLon": "'.$takeoff->lon().'"
	},

	"stats":  {
		"FlightType": "'.$this->BEST_FLIGHT_TYPE.'",
		"MaxStraightDistance": '.($this->MAX_LINEAR_DISTANCE+0).',
		"StraightDistance": '.$this->LINEAR_DISTANCE.',
		"XCdistance": "'.($this->FLIGHT_KM+0).'",
		"XCscore": "'.($this->FLIGHT_POINTS+0).'",

		"MaxSpeed": "'.$this->MAX_SPEED.'",
		"MeanGliderSpeed": "'.$this->MEAN_SPEED.'",
		"MaxVario": "'.$this->MAX_VARIO.'",
		"MinVario": "'.$this->MIN_VARIO.'",
		"MaxAltASL": "'.$this->MAX_ALT.'",
		"MinAltASL": "'.$this->MIN_ALT.'",
		"TakeoffAlt": "'.$this->TAKEOFF_ALT.'"
	},

	'.$flightScore->toSyncJSON().' ,


	"turnpoints": [
		'.$tpStr.'
	] ,

	"validation": {
		"validated": "'.$this->validated.'",
		"grecord": "'.$this->grecord.'",
		"hash": "'.$this->hash.'",
		"validationMessage": "'.json::prepStr($this->validationMessage).'",
		"airspaceCheck": "'.json::prepStr($this->airspaceCheck).'",
		"airspaceCheckFinal": "'.json::prepStr($this->airspaceCheckFinal).'",
		"airspaceCheckMsg": "'.json::prepStr($this->airspaceCheckMsg).'"
	}


}
}';
		}
		return $resStr;
	}

	function setAllowedParams() {
		if ($this->cat==1 ) { // PG
			$this->maxAllowedSpeed=140;
			$this->maxAllowedVario=13;
			$this->maxAllowedHeight=9000;
		} else	if ($this->cat==2 ) { // flex wing HG
			$this->maxAllowedSpeed=200;
			$this->maxAllowedVario=15;
			$this->maxAllowedHeight=9000;
		} else	if ($this->cat==4 ) { // fixed wing HG
			$this->maxAllowedSpeed=200;
			$this->maxAllowedVario=17;
			$this->maxAllowedHeight=9000;
		} else	if ($this->cat==8 ) { // glider
			$this->maxAllowedSpeed=350;
			$this->maxAllowedVario=20;
			$this->maxAllowedHeight=9000;
		} else if ($this->cat==16 ) { // paramotor
			$this->maxAllowedSpeed=150;
			$this->maxAllowedVario=13;
			$this->maxAllowedHeight=9000;
		} else if ($this->cat==32 ) { // trike
			$this->maxAllowedSpeed=150;
			$this->maxAllowedVario=13;
			$this->maxAllowedHeight=9000;
		} else if ($this->cat==64 ) { // other powered flight
			$this->maxAllowedSpeed=500;
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

		//$this->FIRST_POINT="";
		//$this->LAST_POINT="";

		$this->firstPointTM=0;
		$this->firstLat=0;
		$this->firstLat=0;
		$this->firstLon=0;
		$this->lastPointTM=0;
		$this->lastLat=0;
		$this->lastLat=0;

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


	function getPilotID() {
		if ($this->userServerID) $extra_prefix=$this->userServerID.'_';
		else $extra_prefix='';
		return $extra_prefix.$this->userID;
	}

	//---------------------------------
	// external flights

	function getOriginalKML() {
		if ( $this->serverID  != 0 && ! $this->originalURL) {
			global $CONF;
			if ( $CONF['servers']['list'][$this->serverID]['isLeo'] ==1  ) {
			 	if (! $this->originalKML )  {
					$this->originalKML='http://'.$CONF['servers']['list'][$this->serverID]['url_base'].
										'/download.php?type=kml_trk&flightID='.$this->original_ID;
				}

			}
		}
		return $this->originalKML;
	}

	function getOriginalURL() {
		if ( $this->serverID  != 0 && ! $this->originalURL) {
			global $CONF;
			if ( $CONF['servers']['list'][$this->serverID]['isLeo'] ==1  ) {
			 	if (! $this->originalURL )  {
					$url_flight=$CONF['servers']['list'][$this->serverID]['url_flight'];
					if ($url_flight) {
						$this->originalURL='http://'.str_replace("%FLIGHT_ID%",$this->original_ID,$url_flight);
					} else {
						$this->originalURL='http://'.$CONF['servers']['list'][$this->serverID]['url'].
										'&op=show_flight&flightID='.$this->original_ID;
					}					
				}
			}
		}
		return $this->originalURL;
	}

	// ---------------------------------
	// Relative (web) paths
	// ---------------------------------
	/* 
	 // not used
	 function getPilotRelDir() {		
		global $flightsWebPath;
		if ($this->userServerID) $extra_prefix=$this->userServerID.'_';
		else $extra_prefix='';

		return $flightsWebPath."/".$extra_prefix.$this->userID;
	}
	*/
	
	function getIGCRelPath($saned=0) {
		global $moduleRelPath,$CONF;
		if ($saned) {
			if ($saned==2) $suffix=".saned.full.igc";
			else $suffix=".saned.igc";
			
			return $moduleRelPath.'/'.str_replace("%PILOTID%",$this->getPilotID(),str_replace("%YEAR%",$this->getYear(),$CONF['paths']['intermediate']) ).'/'.
				rawurlencode($this->filename).$suffix;
		} else { 
			$suffix="";
			return $moduleRelPath.'/'.str_replace("%PILOTID%",$this->getPilotID(),str_replace("%YEAR%",$this->getYear(),$CONF['paths']['igc']) ).'/'.
				rawurlencode($this->filename).$suffix;
		}
				
		// return $this->getPilotRelDir()."/flights/".$this->getYear()."/".rawurlencode($this->filename).$suffix;
	}

	function getKMLRelPath($method=0) {
		global $moduleRelPath,$CONF;
						
		if ($method==0) $suffix=".kmz";
		else if ($method==1) $suffix=".man.kmz";
		else if ($method==2) $suffix=".igc2kmz";
		
		return $moduleRelPath.'/'.str_replace("%PILOTID%",$this->getPilotID(),str_replace("%YEAR%",$this->getYear(),$CONF['paths']['kml']) ).'/'.
				rawurlencode($this->filename).$suffix;		
		//return $this->getPilotRelDir()."/flights/".$this->getYear()."/".rawurlencode($this->filename).".kml";
	}

	function getGPXRelPath() {
		global $moduleRelPath,$CONF;
		return $moduleRelPath.'/'.str_replace("%PILOTID%",$this->getPilotID(),str_replace("%YEAR%",$this->getYear(),$CONF['paths']['kml']) ).'/'.
				rawurlencode($this->filename).".xml";
		//return $this->getPilotRelDir()."/flights/".$this->getYear()."/".rawurlencode($this->filename).".xml";
	}
	function getPolylineRelPath() {
		global $moduleRelPath,$CONF;
		return $moduleRelPath.'/'.str_replace("%PILOTID%",$this->getPilotID(),str_replace("%YEAR%",$this->getYear(),$CONF['paths']['intermediate']) ).'/'.
				rawurlencode($this->filename).".poly.txt";
		// return $this->getPilotRelDir()."/flights/".$this->getYear()."/".rawurlencode($this->filename).".poly.txt";
	}

	function getMapRelPath($num=0) {
		global $moduleRelPath,$CONF;
		if ($num) $suffix="3d";
		else $suffix="";
		return $moduleRelPath.'/'.str_replace("%PILOTID%",$this->getPilotID(),str_replace("%YEAR%",$this->getYear(),$CONF['paths']['map']) ).'/'.
				rawurlencode($this->filename).$suffix.".png";
		//return $this->getPilotRelDir()."/maps/".$this->getYear()."/".rawurlencode($this->filename).$suffix.".jpg";
	}

	function getChartRelPath($chartType,$unitSystem=1,$rawChart=0) {
		global $moduleRelPath,$CONF;
		if ($unitSystem==2) $suffix="_2";
		else $suffix="";
		if ($rawChart) $suffix.=".raw";
		else $suffix.="";
				
		return $moduleRelPath.'/'.str_replace("%PILOTID%",$this->getPilotID(),str_replace("%YEAR%",$this->getYear(),$CONF['paths']['charts']) ).'/'.
				rawurlencode($this->filename).".".$chartType.$suffix.".png";				
		// return $this->getPilotRelDir()."/charts/".$this->getYear()."/".rawurlencode($this->filename).".".$chartType.$suffix.".png";
	}
	function getPhotoRelPath($photoNum) {
		global $moduleRelPath,$CONF;
		$t="photo".$photoNum."Filename";
		return $moduleRelPath.'/'.str_replace("%PILOTID%",$this->getPilotID(),str_replace("%YEAR%",$this->getYear(),$CONF['paths']['photos']) ).'/'.
				rawurlencode($this->filename).".".$chartType.$suffix.".png";				
		// return $this->getPilotRelDir()."/photos/".$this->getYear()."/".$this->$t;
	}
	function getRelPointsFilename($timeStep=0) { // values > 0 mean 1-> first level of timestep, usually 20 secs, 2-> less details usually 30-40 secs
		global $moduleRelPath,$CONF;
		if ($timeStep) $suffix=".".$timeStep;
		else $suffix="";
		return $moduleRelPath.'/'.str_replace("%PILOTID%",$this->getPilotID(),str_replace("%YEAR%",$this->getYear(),$CONF['paths']['intermediate']) ).'/'.
				rawurlencode($this->filename)."$suffix.txt";
		// return  $this->getPilotRelDir()."/flights/".$this->getYear()."/".$this->filename."$suffix.txt";
	}
	function getJsRelPath($timeStep=0) { // values > 0 mean 1-> first level of timestep, usually 20 secs, 2-> less details usually 30-40 secs
		global $moduleRelPath,$CONF;
		if ($timeStep) $suffix=".".$timeStep;
		else $suffix="";
		return $moduleRelPath.'/'.str_replace("%PILOTID%",$this->getPilotID(),str_replace("%YEAR%",$this->getYear(),$CONF['paths']['js']) ).'/'.
				rawurlencode($this->filename)."$suffix.js";
		//return $this->getPilotRelDir()."/flights/".$this->getYear()."/".$this->filename."$suffix.js";
	}

	function getJsonRelPath() { // values > 0 mean 1-> first level of timestep, usually 20 secs, 2-> less details usually 30-40 secs
		global $moduleRelPath,$CONF;
		return $moduleRelPath.'/'.str_replace("%PILOTID%",$this->getPilotID(),str_replace("%YEAR%",$this->getYear(),$CONF['paths']['js']) ).'/'.
				rawurlencode($this->filename).".json.js";
				
		// return str_replace('.//','',$this->getPilotRelDir())."/flights/".$this->getYear()."/".rawurlencode($this->filename).".json.js";
	}
	// ---------------------------------
	// now absolute filenames
	// ---------------------------------
	function getPilotAbsDir() {
		global $CONF;		
		return LEONARDO_ABS_PATH.'/'.str_replace("%PILOTID%",$this->getPilotID(),$CONF['paths']['pilot']);			
	}
	
	function getIGCFilename($saned=0) {
		global $CONF;
		if ($saned) {
			if ($saned==2) $suffix=".saned.full.igc";
			else $suffix=".saned.igc"; // $saned==1
			
			return LEONARDO_ABS_PATH.'/'.str_replace("%PILOTID%",$this->getPilotID(),str_replace("%YEAR%",$this->getYear(),$CONF['paths']['intermediate']) ).'/'.
			$this->filename.$suffix;
		} else { 
			$suffix="";
			return LEONARDO_ABS_PATH.'/'.str_replace("%PILOTID%",$this->getPilotID(),str_replace("%YEAR%",$this->getYear(),$CONF['paths']['igc']) ).'/'.
				$this->filename.$suffix;
		}
		//return $this->getPilotAbsDir()."/flights/".$this->getYear()."/".$this->filename.$suffix;
	}
	
	function getKMLFilename($method=0) {
		global $CONF;
		if ($method==0) $suffix=".kmz";
		else if ($method==1) $suffix=".man.kmz";
		else if ($method==2) $suffix=".igc2kmz";
		
		return LEONARDO_ABS_PATH.'/'.str_replace("%PILOTID%",$this->getPilotID(),str_replace("%YEAR%",$this->getYear(),$CONF['paths']['kml']) ).'/'.$this->filename.$suffix;
		//return $this->getPilotAbsDir()."/flights/".$this->getYear()."/".$this->filename.".kml";
	}
	function getGPXFilename() {
		global $CONF;
		return LEONARDO_ABS_PATH.'/'.str_replace("%PILOTID%",$this->getPilotID(),str_replace("%YEAR%",$this->getYear(),$CONF['paths']['kml']) ).'/'.$this->filename.".xml";
		//return $this->getPilotAbsDir()."/flights/".$this->getYear()."/".$this->filename.".xml";
	}
	function getPolylineFilename($suffix='') {
		global $CONF;
        if ($suffix) $suffix.='.';
		return LEONARDO_ABS_PATH.'/'.str_replace("%PILOTID%",$this->getPilotID(),str_replace("%YEAR%",$this->getYear(),$CONF['paths']['intermediate']) ).'/'.$this->filename.".poly".$suffix.".txt";
	}
	function getMapFilename($num=0) {
		global $CONF;
		if ($num) $suffix="3d";
		else $suffix="";
		return LEONARDO_ABS_PATH.'/'.str_replace("%PILOTID%",$this->getPilotID(),str_replace("%YEAR%",$this->getYear(),$CONF['paths']['map']) ).'/'.$this->filename.$suffix.".png";
	}
	function getChartFilename($chartType,$unitSystem=1,$rawChart=0) {
		global $CONF;
		if ($unitSystem==2) $suffix="_2";
		else $suffix="";

		if ($rawChart) $suffix.=".raw";
		else $suffix.="";

		return LEONARDO_ABS_PATH.'/'.str_replace("%PILOTID%",$this->getPilotID(),str_replace("%YEAR%",$this->getYear(),$CONF['paths']['charts']) ).'/'.$this->filename.".".$chartType.$suffix.".png";
	}
	function getPhotoFilename($photoNum) {
		global $CONF;
		$t="photo".$photoNum."Filename";
		return LEONARDO_ABS_PATH.'/'.str_replace("%PILOTID%",$this->getPilotID(),str_replace("%YEAR%",$this->getYear(),$CONF['paths']['photos']) ).'/'.$this->$t;
		// return $this->getPilotAbsDir()."/photos/".$this->getYear()."/".$this->$t;
	}
	function getPointsFilename($timeStep=0) { // values > 0 mean 1-> first level of timestep, usually 20 secs, 2-> less details usually 30-40 secs
		global $CONF;
		if ($timeStep) $suffix=".".$timeStep;
		else $suffix="";
		return LEONARDO_ABS_PATH.'/'.str_replace("%PILOTID%",$this->getPilotID(),str_replace("%YEAR%",$this->getYear(),$CONF['paths']['intermediate']) ).'/'.$this->filename."$suffix.txt";
		//return $this->getPilotAbsDir()."/flights/".$this->getYear()."/".$this->filename."$suffix.txt";
	}
	function getJsFilename($timeStep=0) { // values > 0 mean 1-> first level of timestep, usually 20 secs, 2-> less details usually 30-40 secs
		global $CONF;
		if ($timeStep) $suffix=".".$timeStep;
		else $suffix="";
		return LEONARDO_ABS_PATH.'/'.str_replace("%PILOTID%",$this->getPilotID(),str_replace("%YEAR%",$this->getYear(),$CONF['paths']['js']) ).'/'.$this->filename."$suffix.js";
		//return $this->getPilotAbsDir()."/flights/".$this->getYear()."/".$this->filename."$suffix.js";
	}

	function getJsonFilename() {
		global $CONF;
		return LEONARDO_ABS_PATH.'/'.str_replace("%PILOTID%",$this->getPilotID(),str_replace("%YEAR%",$this->getYear(),$CONF['paths']['js']) ).'/'.$this->filename.$suffix.".json.js";
		//return $this->getPilotAbsDir()."/flights/".$this->getYear()."/".$this->filename.".json.js";
	}
	//---------------------------------------
	// Full url functions
	//----------------------------------------
	function getFlightLinkURL() {
		return "http://".$_SERVER['SERVER_NAME'].
			getLeonardoLink(array('op'=>'show_flight','flightID'=>$this->flightID));
	}

	function getIGC_URL($saned=0) {
		global $baseInstallationPath;
		return "http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/".$this->getIGCRelPath($saned);
	}

	function getZippedIGC_URL() {
		return "http://".$_SERVER['SERVER_NAME'].
			getDownloadLink(array('type'=>'igc','zip'=>'1','flightID'=>$this->flightID)) ;
		// getRelMainDir()."download.php?type=igc&zip=1&flightID=".$this->flightID;
	}

	function getFlightKML($includeLang=1) {
		global $currentlang;
		if ($includeLang) $langArray=array("lng">=$currentlang);
		else  $langArray=array();

		return "http://".$_SERVER['SERVER_NAME'].
			getDownloadLink(array('type'=>'kml_trk','flightID'=>$this->flightID)+$langArray) ;
		// getRelMainDir()."download.php?type=kml_trk&flightID=".$this->flightID.$langStr;
	}

	function getFlightGPX() {
		return "http://".$_SERVER['SERVER_NAME'].
			getDownloadLink(array('type'=>'gpx_trk','flightID'=>$this->flightID)) ;
		//getRelMainDir()."download.php?type=gpx_trk&flightID=".$this->flightID;
	}

	//------------------------------
	// End of path functions
	//------------------------------


	function kmlGetDescription($ext,$getFlightKML,$loadTrackLink=0) {
		if ($this->takeoffVinicity > $takeoffRadious )
			$location=getWaypointName($this->takeoffID,0)." [~".sprintf("%.1f",$this->takeoffVinicity/1000)." km]";
		else $location=getWaypointName($this->takeoffID,0);

		if ($this->landingVinicity > $landingRadious )
			$location_land=getWaypointName($this->landingID,0)." [~".sprintf("%.1f",$this->landingVinicity/1000)." km]";
		else $location_land=getWaypointName($this->landingID,0);

		$fl_url=$this->getFlightLinkURL();
		//$fl_url=str_replace("&","&#38;",$this->getFlightLinkURL());
		//$fl_url=str_replace("&nbsp;"," ",$fl_url);

		$str="<description><![CDATA[<table cellpadding=0 cellspacing=0>";
		
		if ($loadTrackLink) 
			$str.="<tr bgcolor='#D7E1EE'><td></td><td><div align='right'><a href='$getFlightKML'><b>Load Track</b></a></div></td></tr>";					
		else 
			$str.="<tr bgcolor='#D7E1EE'><td></td><td><div align='right'><a href='$fl_url'><b>"._See_more_details."</b></a></div></td></tr>";
		
		$str.="<tr bgcolor='#CCCCCC'><td>"._PILOT."</td><td>  ".htmlspecialchars($this->userName)."</td></tr>".
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
			"<tr bgcolor='#D7E1EE'><td></td><td><div align='right'>"._KML_file_made_by." <a href='http://www.leonardoxc.net'>Leonardo</a></div></td></tr>";
			if($ext) $str.=	"<tr bgcolor='#D7E1EE'><td></td><td><div align='right'>Extra analysis module by  Man\'s <a href='http://www.parawing.net'>GPS2GE V2.0</a></div></td></tr>";
			$str.="<tr bgcolor='#D7E1EE'><td></td><td><div align='right'><a href='$getFlightKML&show_url=1'>URL of this KML file</div></td></tr>";

			$str.="</table>]]></description>";
		return $str;
	}


	function gMapsGetTaskJS($useJSapi=0){
		global  $CONF;

		$tpStr=' { "turnpoints":  [ ';

		$flightScore=new flightScore($this->flightID);
		$flightScore->getFromDB();

		$defaultMethodID= $CONF['scoring']['default_set'];
		$scoreDetails=$flightScore->scores[$defaultMethodID][ $flightScore->bestScoreType ];

		$tpNum=0;
		for($i=1;$i<=7;$i++) {
			if ($scoreDetails['tp'][$i]) {
				$newPoint=new gpsPoint($scoreDetails['tp'][$i],$this->timezone);
				if ($tpNum>0) $tpStr.=" ,\n		";
				$tpStr.=' {"id": "'.$i.'" , "name": "TP'.$i.'" , "lat": '.$newPoint->lat().', "lon": '.$newPoint->lon().', "secs": '.$newPoint->getTime().' } ';
				$tpNum++;
			}
		}

		/*
		$j=0;
		for($i=1;$i<=5;$i++) {
			$varname="turnpoint$i";
			if ($this->{$varname} ) {
				$pointString=explode(" ",$this->{$varname});
				// make this string
				// B1256514029151N02310255EA0000000486
				// from N40:29.151 E23:10.255
				preg_match("/([NS])(\d+):(\d+)\.(\d+) ([EW])(\d+):(\d+)\.(\d+)/",$this->{$varname},$matches);

				$lat=preg_replace("/[NS](\d+):(\d+)\.(\d+)/","\\1\\2\\3",$pointString[0]);
				$lon=preg_replace("/[EW](\d+):(\d+)\.(\d+)/","\\1\\2\\3",$pointString[1]);

				$pointStringFaked=sprintf("B125959%02d%02d%03d%1s%03d%02d%03d%1sA0000000500",
							$matches[2],$matches[3],$matches[4],$matches[1],
							$matches[6],$matches[7],$matches[8],$matches[5] );

				$newPoint=new gpsPoint( $pointStringFaked ,$this->timezone );

				$name=$i;

				if ($i> 1 ) $jsonStr.=' , ';
				$jsonStr.=' { "lat": '.$newPoint->lat().' , "lon": '.$newPoint->lon().
							', "name": "TP'.$name.'", "id": "'.$name.'"  } '."\n";

				$j++;

			}

		}
*/

		$tpStr.=' ] } ';
		return $tpStr;
	}


	function kmlGetTask($completeKMLfile=0){
		if ($completeKMLfile) {
			$kml_file_contents="<?xml version='1.0' encoding='UTF-8'?>\n".
								"<kml xmlns=\"http://earth.google.com/kml/2.1\">\n";
		} else {
			$kml_file_contents="";
		}

		$kml_file_contents.="<Folder>
		<name>XC Task</name>

		";


		$kml_file_contents.="<Placemark>
		<name>XC Task</name>
		<Style id='taskLine'>
			<LineStyle><color>ffffffff</color></LineStyle>
		</Style>
		<LineString>
			<altitudeMode>extrude</altitudeMode>
			<coordinates>
		";

		$icons=array(
		1=>array("http://maps.google.com/mapfiles/kml/paddle/grn-circle.png",32,1),
		2=>array("http://maps.google.com/mapfiles/kml/paddle/1.png",32,1),
		3=>array("http://maps.google.com/mapfiles/kml/paddle/2.png",32,1),
		4=>array("http://maps.google.com/mapfiles/kml/paddle/3.png",32,1),
		5=>array("http://maps.google.com/mapfiles/kml/paddle/purple-square.png",32,1) );


		global  $CONF;
		$tpStr=' { "turnpoints":  [ ';

		$flightScore=new flightScore($this->flightID);
		$flightScore->getFromDB();

		$defaultMethodID= $CONF['scoring']['default_set'];
		$scoreDetails=$flightScore->scores[$defaultMethodID][ $flightScore->bestScoreType ];

		$j=0;
		for($i=1;$i<=7;$i++) {
			if ($scoreDetails['tp'][$i]) {
				$newPoint=new gpsPoint($scoreDetails['tp'][$i],$this->timezone);
				$kml_file_contents.=$newPoint->lon().",".$newPoint->lat().",0 ";
				$turnpointPlacemark[$j]="
		<Placemark>
				 <Style>
				  <IconStyle>
					<scale>1.0</scale>
					<Icon>
					  <href>".$icons[$j+1][0]."</href>					 
					</Icon>
					<hotSpot x=\"32\" y=\"1\" xunits=\"pixels\" yunits=\"pixels\"/>
				  </IconStyle>
				</Style>
		 <Point>
			<coordinates>".$newPoint->lon().",".$newPoint->lat().",0</coordinates>
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
		global $takeoffRadious,$landingRadious;
		global $moduleRelPath,$baseInstallationPath;
		global $langEncodings,$currentlang;

		$getFlightKML=$this->getFlightKML()."&c=$lineColor&w=$lineWidth&an=$extended";

		// do some basic check for saned igc file
		if (! $this->checkSanedFiles() ) {
			return "";
		}

		if ($extended==1) {
			//$kml_file_contents.="<Placemark >\n<name>".$this->filename."</name>";
			// $kml_file_contents.=$this->kmlGetDescription($extended,$getFlightKML);
			//$kml_file_contents.="</Placemark>";
			require_once dirname(__FILE__)."/FN_kml.php";
			kmlGetTrackAnalysis($this->getKMLFilename(1),$this->getIGCFilename(2),1);
			$kml_file_contents="
<NetworkLink>
  <name>Extended analysis</name>
  <visibility>1</visibility>
  <open>1</open>
  <description> Extra analysis generation by  Man\'s GPS2GE V2.0 (http://www.parawing.net)</description>
  <refreshVisibility>0</refreshVisibility>
  <flyToView>0</flyToView>
  <Link>
	<href>http://".$_SERVER['SERVER_NAME']."/$baseInstallationPath/".$this->getKMLRelPath(1)."</href>
  </Link>
</NetworkLink>";

			return $kml_file_contents;
		}


		$KMLlineColor="ff".substr($lineColor,4,2).substr($lineColor,2,2).substr($lineColor,0,2);
		$kmzFile=$this->getKMLFilename(0);
		$kmlTempFile=$kmzFile.".tmp.kml";

// DEBUG MANOLIS force creation
		if ( !file_exists($kmzFile)  ) { // create the kmz file containg the points only

			$filename=$this->getIGCFilename(2);
			$lines = file ($filename);
			if ( $lines) {
				$i=0;

/*
new ge features

http://googlegeodevelopers.blogspot.com/2010/07/making-tracks-new-kml-extensions-in.html
http://google-latlong.blogspot.com/2010/06/relive-your-hiking-biking-and-other.html

****** !!!! ****
http://code.google.com/intl/el-GR/apis/kml/documentation/kmlreference.html#trackexample

http://sketchup.google.com/3dwarehouse/cldetails?mid=c166a0a48065f4403a426bad1ca64772&ct=mdcc&prevstart=0
*/

	$str='<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://www.opengis.net/kml/2.2"
 xmlns:gx="http://www.google.com/kml/ext/2.2">
 ';

		$str.="<Document>
		<name>Tracklog File</name>
		<Schema id=\"schema\">
		  <gx:SimpleArrayField name=\"Climb\" type=\"float\">
			  <displayName>CLimb (m/s)</displayName>
		  </gx:SimpleArrayField>
		</Schema>";
		
$strXXX.='<!-- Normal multiTrack style -->
    <Style id="Track_n">
      <LineStyle>
			<color>ff0000ff</color>
			<width>2</width>
      </LineStyle>
      <IconStyle>
        <Icon>
          <href>http://earth.google.com/images/kml-icons/track-directional/track-0.png</href>
        </Icon>
      </IconStyle>
    </Style>
<!-- Highlighted multiTrack style -->
    <Style id="Track_h">
      <LineStyle>
			<color>ff0000ff</color>
			<width>1</width>
      </LineStyle>
      <IconStyle>
        <scale>1.2</scale>
        <Icon>
          <href>http://earth.google.com/images/kml-icons/track-directional/track-0.png</href>
        </Icon>
      </IconStyle>
    </Style>
	
    <StyleMap id="TrackStyle">
      <Pair>
        <key>normal</key>
        <styleUrl>#Track_n</styleUrl>
      </Pair>
      <Pair>
        <key>highlight</key>
        <styleUrl>#Track_h</styleUrl>
      </Pair>
    </StyleMap>
	
	';

		$str.="<Placemark id='timeTrack'>
					<name>Tracklog</name>
					    <Style id='Track1'>
      <LineStyle>
			<color>ff0000ff</color>
			<width>2</width>
      </LineStyle>
      <IconStyle>
        <Icon>
          <href>http://earth.google.com/images/kml-icons/track-directional/track-0.png</href>
        </Icon>
      </IconStyle>
    </Style>";
	

				$str.="<gx:MultiTrack id=\"MultiTrack\">
				<gx:Track>					
				<altitudeMode>absolute</altitudeMode>\n\n";


				//$kml_file_contents=str_replace("&","&#38;",$kml_file_contents);
				// $kml_file_contents=utf8_encode(str_replace("&nbsp;"," ",$kml_file_contents));
				$str=str_replace("&nbsp;"," ",$str);
				$timeStampStr='';
				foreach($lines as $line) {
					$line=trim($line);
					if  (strlen($line)==0) continue;
					if ($line{0}=='B') {
							if  ( strlen($line) < 23 ) 	continue;
							// also check for bad points
							// 012345678901234567890123456789
							// B1522144902558N00848090EV0058400000
							if ($line{24}=='V') continue;

							$thisPoint=new gpsPoint($line,$this->timezone);
							$alt=$thisPoint->getAlt();
							$lon=-$thisPoint->lon;
							$lat=$thisPoint->lat;
							// $data_alt[$i]=$thisPoint->getAlt();
							if ( $alt > $this->maxAllowedHeight ) continue;
							// $str.=$lon.",".$lat.",".($alt*$exaggeration)." ";
							
							if ($tm0) {
								$dalt=$alt-$alt0;
								$dt=$thisPoint->getTime()-$tm0;
								$climb=sprintf("%.1f",$dalt/$dt);
								if (abs($climb) > 20 ) $climb=0;
							} else {
								$climb=0;
							} 							
							$tm0=$thisPoint->getTime();
							$alt0=$alt;
							
							$strWhen.="<when>".$this->DATE."T".sec2Time24h( ( $thisPoint->getTime() )%(3600*24) )."Z</when>\n";
					        $strCord.="<gx:coord>".sprintf("%.5f",$lon)." ".sprintf("%.5f",$lat)." ".round($alt)."</gx:coord>\n";
							$strClimb.="<gx:value>$climb</gx:value>\n";

							$simpleTrackStr.=sprintf("%.5f",$lon).",".sprintf("%.5f",$lat).",".round($alt)." ";
							if($i % 50==0) $simpleTrackStr.="\n";
							
							$i++;
					}
				}

				//$str.="</coordinates>\n</LineString>\n";
				$str.=$strWhen."\n\n".$strCord.
				"<ExtendedData>
		            <SchemaData schemaUrl=\"#schema\">
		              <gx:SimpleArrayData name=\"Climb\">
						".$strClimb."
						 </gx:SimpleArrayData>
					</SchemaData>
				  </ExtendedData>
				  ";

				$str.="	
					</gx:Track>
				</gx:MultiTrack>
						";
							
				$str.="</Placemark>";
				
				$str.=' <Placemark id="simpleTrack">
    <name>Simple Track</name>
	 <Style id="Track2">
      <LineStyle>
			<color>ff0000ff</color>
			<width>2</width>
      </LineStyle>
    </Style>
	
	<LineString >
  <extrude>0</extrude>
  <altitudeMode>absolute</altitudeMode> 
  <coordinates>'.$simpleTrackStr.'</coordinates>
</LineString>
</Placemark>';

$str.="
		<Style id='s_camera'>
		<IconStyle>
			<color>ff00ff00</color>
			<scale>0.8</scale>
			<Icon>
				<href>http://maps.google.com/mapfiles/kml/shapes/camera.png</href>
			</Icon>
			<hotSpot x='0.5' y='0' xunits='fraction' yunits='fraction'/>
		</IconStyle>
		<ListStyle>
		</ListStyle>
		</Style>";
		
// now the photos
if ($this->hasPhotos) {
	require_once dirname(__FILE__)."/CL_flightPhotos.php";
	global $CONF;

	$flightPhotos=new flightPhotos($this->flightID);
	$flightPhotos->getFromDB();

	// get geoinfo
	$flightPhotos->computeGeoInfo();

	$imagesHtml="";
	foreach ( $flightPhotos->photos as $photoNum=>$photoInfo) {
		
		if ($photoInfo['lat'] && $photoInfo['lon'] ) {
			$imgIconRel=$flightPhotos->getPhotoRelPath($photoNum).".icon.jpg";
			$imgBigRel=$flightPhotos->getPhotoRelPath($photoNum);
	
			$imgIcon=$flightPhotos->getPhotoAbsPath($photoNum).".icon.jpg";
			$imgBig=$flightPhotos->getPhotoAbsPath($photoNum);

			if (file_exists($imgBig) ) {
				list($width, $height, $type, $attr) = getimagesize($imgBig);
				list($width, $height)=CLimage::getJPG_NewSize($CONF['photos']['mid']['max_width'], $CONF['photos']['mid']['max_height'], $width, $height);
				$imgTarget=$imgBigRel;
			} else 	if (file_exists($imgIcon) ) {
				list($width, $height, $type, $attr) = getimagesize($imgIcon);
				list($width, $height)=CLimage::getJPG_NewSize($CONF['photos']['mid']['max_width'], $CONF['photos']['mid']['max_height'], $width, $height);
				$imgTarget=$imgIconRel;
			} 
			$imgIconRel="http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/".$imgIconRel;
			$imgTarget="http://".$_SERVER['SERVER_NAME'].str_replace('//','/',$baseInstallationPath."/".$imgTarget) ;

			$altitudeMode="absolute";
			if ($photoInfo['alt']==0) $altitudeMode="clampToGround";
			
			$str.="
			<Placemark>
		    <name>Photo</name>
			<styleUrl>#s_camera</styleUrl>
			<Snippet maxLines='0' ></Snippet>
			<description><![CDATA[<a href='$imgTarget'><img src='$imgTarget' width='".$CONF['photos']['mid']['max_width']."' border='0'></a>
]]></description>
			<Point>
				<altitudeMode>$altitudeMode</altitudeMode>  	    
				<coordinates>".$photoInfo['lon'].",".$photoInfo['lat'].",".$photoInfo['alt']."</coordinates>
			</Point>
			</Placemark>";
			 	
		}		
	}
}
	

				$str.="\n</Document>\n</kml>";

				writeFile($kmlTempFile,$str);
				// zip the file
				require_once dirname(__FILE__)."/lib/pclzip/pclzip.lib.php";
				$archive = new PclZip($kmzFile);
				$v_list = $archive->create($kmlTempFile, PCLZIP_OPT_REMOVE_ALL_PATH);
				$this->deleteFile($kmlTempFile);
			}
		}

		$getFlightKMLcolorUpdater=$this->getFlightKML()."&c=$lineColor&w=$lineWidth&an=$extended&updateColor=1";


		$kml_file_contents='';
		$kml_file_contents.="
<NetworkLink>
  <name>Tracklog</name>
  <visibility>1</visibility>
  <open>1</open>
  <refreshVisibility>1</refreshVisibility>
  <flyToView>1</flyToView>
  <Link>
	<href>http://".str_replace('//','/',$_SERVER['SERVER_NAME']."/$baseInstallationPath/".$this->getKMLRelPath(0) )."</href>
  </Link>
</NetworkLink>";

$kml_file_contents.="
<NetworkLink>
  <name>UpdateColor</name>
  <Link>
    <href>".
	//str_replace("&","&#38;",str_replace('kml_trk','kml_trk_color',$getFlightKML) ).
	str_replace("&","&#38;",$getFlightKMLcolorUpdater ).
	"</href>
	</Link>
</NetworkLink>
";
//echo "## $getFlightKMLcolorUpdater ## ";
//exit;

		return $kml_file_contents;
	}

	function getBounds() {
		$filename=$this->getIGCFilename(1);
		$lines = file ($filename);
		if (!$lines) return array(0,0,0,0);
		$i=0;

		$min_lat=1000;
		$max_lat=-1000;
		$min_lon=1000;
		$max_lon=-1000;

		foreach($lines as $line) {
			$line=trim($line);
			if  (strlen($line)==0) continue;
			if ($line{0}=='B') {
					if  ( strlen($line) < 23 ) 	continue;
					// also check for bad points
					// 012345678901234567890123456789
					// B1522144902558N00848090EV0058400000
					if ($line{24}=='V') continue;

					$thisPoint=new gpsPoint($line,$this->timezone);
					if ( $thisPoint->lat  > $max_lat )  $max_lat =$thisPoint->lat  ;
					if ( $thisPoint->lat  < $min_lat )  $min_lat =$thisPoint->lat  ;
					if ( -$thisPoint->lon  > $max_lon )  $max_lon =-$thisPoint->lon  ;
					if ( -$thisPoint->lon  < $min_lon )  $min_lon =-$thisPoint->lon  ;

					$i++;
			}
		}
		return array($min_lat,$min_lon,$max_lat,$max_lon);
	}

	function gpxGetTrack() {
		global $takeoffRadious,$landingRadious;
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
					// also check for bad points
					// 012345678901234567890123456789
					// B1522144902558N00848090EV0058400000
					if ($line{24}=='V') continue;

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

	function createEncodedPolyline($forceRefresh=0) {
		global $takeoffRadious,$landingRadious;
		global $moduleRelPath,$baseInstallationPath;
		global $langEncodings,$currentlang;

		if ( is_file($this->getPolylineFilename())  && !$forceRefresh ) return ;

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
			if ($line{0}=='B' && strlen($line) >= 23 && $line{24}!='V' ) $numLines++;
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
					// also check for bad points
					// 012345678901234567890123456789
					// B1522144902558N00848090EV0058400000
					if ($line{24}=='V') continue;

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

    function createStaticMap($forceRefresh=0) {

        $maxPoints=400;
        $width=350;
        $height=350;

        global $moduleRelPath,$baseInstallationPath;
        global $langEncodings,$currentlang;

        if ( is_file($this->getMapFilename())  && !$forceRefresh )  return $this->getMapRelPath();

        $filename=$this->getIGCFilename(1);
        $lines = file ($filename);
        if (!$lines) return;
        $i=0;
        $kml_file_contents="";


        $prevLat=0;
        $prevLon=0;


        $totLines=count($lines);
       // echo "tot line: ".$totLines;

        $mod0=0;
        if ($totLines > $maxPoints ){
            $reduceArray=getReduceArray($totLines ,$maxPoints);
            // print_r($recudeArray);
            $mod0=count($reduceArray);
            // $mod= ceil( $p / $this->maxPointNum );
        }


        // compute num of B lines
        $numLines=0;
        $points=0;
        $i++;
        foreach($lines as $line) {
            if ($line{0}=='B' && strlen($line) >= 23 && $line{24}!='V' ) {
                // real line
                $points++;
                if ($mod0>=1)  {
                    if ( $reduceArray[ $points % $mod0]  == 0  ) {
                        $lines[$i]{0}='X';
                        //unset($lines[$i]);
                        $i++;
                        continue;
                    }
                }
                $numLines++;
            } else {
                $lines[$i]{0}='X';
               // unset($lines[$i]);

            }
            $i++;
        }

        //echo "<BR>real b  lines: ".$numLines;
        //echo "<BR>lines left in arays: ".count($lines);

        foreach($lines as $line) {
            $line=trim($line);
            if  (strlen($line)==0) continue;
            if ($line{0}!='B') continue;
            if  ( strlen($line) < 23 ) 	continue;
            if ($line{24}=='V') continue;

            $thisPoint=new gpsPoint($line,$this->timezone);
            $lat=$thisPoint->lat;
            $lon=-$thisPoint->lon;

            $kml_file_contents.=encodeNumber($lat-$prevLat).encodeNumber($lon-$prevLon);

            $prevLat=$lat;
            $prevLon=$lon;

            $i++;
        }

        // write to file

        // echo "<br>encoded len: ".strlen ($kml_file_contents);

        $staticMap="https://maps.googleapis.com/maps/api/staticmap?path=color:0xff0000|weight:2|enc:$kml_file_contents&maptype=terrain&size=".$width."x".$height."&sensor=false";
        //echo "<br>".strlen($staticMap);

        // get from google
        $imgStr=file_get_contents($staticMap);
        //echo "<br>".strlen($imgStr);

        $handle = fopen($this->getMapFilename(), "w");
        fwrite($handle, $imgStr);
        fclose($handle);

        //echo "<img src='".$this->getMapRelPath()."'>";

        return $this->getMapRelPath();
    }

	function createKMLfile($lineColor="ff0000",$exaggeration=1,$lineWidth=2,$extendedInfo=0) {
		global $takeoffRadious,$landingRadious;
		global $moduleRelPath,$baseInstallationPath;
		global $langEncodings,$currentlang,	$CONF_use_utf;

		$exaggeration=1;
		//if (file_exists($this->getKMLFilename())) return;

		$getFlightKML=$this->getFlightKML()."&c=$lineColor&w=$lineWidth&an=$extendedInfo";
		//UTF-8 or
		//".$langEncodings[$currentlang]."
$kml_file_contents=
//"<?xml version='1.0' encoding='".$langEncodings[$currentlang]."'? >".
"<?xml version='1.0' encoding='UTF-8'?>\n".
"<kml xmlns=\"http://earth.google.com/kml/2.1\">
<Document>
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

		// create the XC task
		$kml_file_contents.=$this->kmlGetTask();

		$kml_file_contents.="</Document>\n</kml>";

		if (! $CONF_use_utf ) {
			require_once dirname(__FILE__)."/lib/ConvertCharset/ConvertCharset.class.php";
			$NewEncoding = new ConvertCharset;
			$FromCharset=$langEncodings[$currentlang];
			$kml_file_contents = $NewEncoding->Convert($kml_file_contents, $FromCharset, "utf-8", $Entities);
		}
		return $kml_file_contents;
	}

	function createKMZfile($c, $ex, $w, $an) {
		global $CONF;

		// do some basic check for saned igc file
		if (! $this->checkSanedFiles() ) {
			return "";
		}

		require_once dirname(__FILE__)."/FN_igc2kmz.php";
		$igc2kmzVersion=igc2kmz($this->getIGCFilename(0),$this->getKMLFilename(3),$this->timezone,$this->flightID);
		$version=$CONF['googleEarth']['igc2kmz']['version'];
		$file_name=$this->getKMLFilename(3).'.'.$version.'.kmz';
		return file_get_contents($file_name);
	}

	function createGPXfile($returnAlsoXML=0) {

		global $takeoffRadious,$landingRadious;
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

		
		$duration=$this->DURATION; // in secs
		$intervalSecs=floor($duration/600);
		if ($intervalSecs>20) $intervalSecs=20;
					
		foreach($lines as $line) {
			$line=trim($line);
			if  (strlen($line)==0) continue;
			if ($line{0}=='B') {
					if  ( strlen($line) < 23 ) 	continue;
					// also check for bad points
					// 012345678901234567890123456789
					// B1522144902558N00848090EV0058400000
					if ($line{24}=='V') continue;

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
						
						if ( ($thisPoint->getTime() - $lastPoint->getTime() ) < $intervalSecs  ) {
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


	function makeJSON($forceRefresh=0) {
		global  $CONF;

		// $forceRefresh=1;

		$filename=$this->getJsonFilename();
		if ( is_file($filename) && ! $forceRefresh ) {
			return;
		}

		// if no file exists do the proccess now
		if ( ! is_file($this->getPointsFilename(1) ) || $forceRefresh ) $this->storeIGCvalues();

		$lines = file($this->getPointsFilename(1)); // get the normalized with constant time step points array
		if (!$lines) return;
		$i = 0;

		$jsTrack['max_alt']=0;
		$jsTrack['min_alt']=100000;

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

			//if (! $time_in_secs ) {
			//	$time = sec2Time($time, 1);
			//}

			$jsTrack['time'][$i]	=$time;
			$jsTrack['elev'][$i]	=$alt;
			$jsTrack['elevV'][$i] 	= $altV;
			$jsTrack['lat'][$i] 	=sprintf('%0.6f',$lat);
			$jsTrack['lon'][$i]		= sprintf('%0.6f',-$lon);
			$jsTrack['speed'][$i] 	= sprintf('%.2f',$speed);
			$jsTrack['vario'][$i] 	= sprintf('%.2f',$vario);
			
			
			



			if ( $CONF['maps']['3d'] ) {
				require_once dirname(__FILE__).'/CL_hgt.php';
				$jsTrack['elevGnd'][$i] = $elevGnd[$i] = hgt::getHeight($lat,-$lon);
			} else  {
				$jsTrack['elevGnd'][$i] = 0 ;
			}

			if ( $jsTrack['elevGnd'][$i] > $jsTrack['max_alt'] ) $jsTrack['max_alt']=$jsTrack['elevGnd'][$i];
			if ( $jsTrack['elev'][$i]    > $jsTrack['max_alt'] ) $jsTrack['max_alt']=$jsTrack['elev'][$i];
			if ( $jsTrack['elevGnd'][$i] < $jsTrack['min_alt'] ) $jsTrack['min_alt']=$jsTrack['elevGnd'][$i];
			if ( $jsTrack['elev'][$i]    < $jsTrack['min_alt']) $jsTrack['min_alt']=$jsTrack['elev'][$i];


			if ($i == 0) {
				$dis =0;
				$firstLat=$lat;
				$firstLon=$lon;
			}
			$jsTrack['distance'][$i] =sprintf('%.3f',$dis);

			$i ++;
		}  //end for loop

		/*
		 Change the number of points to CHART_NBPTS
		for ($i = 0, $idx = 0, $step = ($nbPts - 1) / (CHART_NBPTS - 1); $i < CHART_NBPTS; $i++, $idx += $step) {
			$jsTrack['elev'][$i] = $track['elev'][$idx];
			$jsTrack['time']['hour'][$i] = $track['time']['hour'][$idx];
			$jsTrack['time']['min'][$i] = $track['time']['min'][$idx];
			$jsTrack['time']['sec'][$i] = $track['time']['sec'][$idx];
		}

		*/

		$nbPts=count( $jsTrack['time']);
		$label_num=8;
		for ($i = 0, $idx = 0, $step = ($nbPts - 1) / ($label_num - 1); $i < $label_num; $i++, $idx += $step) {
			$jsTrack['labels'][$i] = $jsTrack['time'][$idx];
		}
		// 			$jsTrack['labels']=array("11h40","12h6","12h29","12h52","13h15");

		$jsTrack['points_num'] = $nbPts;
		$jsTrack['nbChartPt'] = $nbPts;
		$jsTrack['label_num'] = $label_num;
		$jsTrack['date'] = $this->DATE;

		require_once dirname(__FILE__).'/lib/json/CL_json.php';

		$JSONstr = json::encode($jsTrack);

		writeFile( $filename, 'var flightArray='.$JSONstr );
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

	if ( ! is_file($this->getPointsFilename(1) ) ||  $forceRefresh )
		 	$this->storeIGCvalues(); // if no file exists do the proccess now

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

	function getXYValues($tmAlso=0,$altAlso=0) {		
		$data_X =array();
		$data_Y =array();

		$data_alt=array();
		$data_tm=array();
		 
		$filename=$this->getIGCFilename(1);
		$lines = file ($filename);
		$i=0;


		foreach($lines as $line) {
			$line=trim($line);
			if  (strlen($line)==0) continue;
			if ($line{0}=='B' && $line{24}!='V') {
					$thisPoint=new gpsPoint($line,$this->timezone);
					$data_X[$i]=$thisPoint->lat;
					$data_Y[$i]=$thisPoint->lon;
					if ($tmAlso) $data_tm[$i]=$thisPoint->gpsTime;
					if ($altAlso) $data_alt[$i]=$thisPoint->getAlt();
					
					$i++;
			}
		}
		if ($tmAlso && $altAlso ) 
			return array($data_X,$data_Y,$data_tm, $data_alt);
		else if ($tmAlso) 
			return array($data_X,$data_Y,$data_tm);
		else 
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

	function getPolyHeader(){
		$handle = fopen($this->getPolylineFilename(), "r");
		$l=array();
		$l[0]= fgets($handle, 4096);
		$l[1]= fgets($handle, 4096);
		$l[2]= fgets($handle, 4096);
		fclose ($handle);
		return $l;
	}

	function storeIGCvalues() {
		$data_time =array();
		$data_alt =array();
		$data_speed =array();
		$data_vario =array();
		$data_takeoff_distance=array();

		if (! $this->checkSanedFiles() ) {
			return;
		}

		$filename=$this->getIGCFilename(2);
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
					// also check for bad points
					// 012345678901234567890123456789
					// B1522144902558N00848090EV0058400000
					if ($line{24}=='V') continue;

					$thisPoint=new gpsPoint($line,$this->timezone);
					$thisPoint->gpsTime+=$day_offset;
					// $goodPoints[$i]['time']=sec2Time($thisPoint->getTime(),1);
					$goodPoints[$i]['time']=$thisPoint->getTime();
					$goodPoints[$i]['lon']=$thisPoint->lon;
					$goodPoints[$i]['lat']=$thisPoint->lat;

					$goodPoints[$i]['alt']=$thisPoint->getAlt();
					$goodPoints[$i]['altV']=$thisPoint->getAlt(true); // prefer vario Alt

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
				$normPoints[$norm_array_pos]['altV']=$goodPoints[$org_array_pos]['altV'];
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
					$normPoints[$norm_array_pos]['altV']=$normPoints[$norm_array_pos-1]['altV'];
					$normPoints[$norm_array_pos]['dis']=$normPoints[$norm_array_pos-1]['dis'];
				}	else {
					$normPoints[$norm_array_pos]['lon']=$goodPoints[0]['lon'];
					$normPoints[$norm_array_pos]['lat']=$goodPoints[0]['lat'];
					$normPoints[$norm_array_pos]['speed']=$goodPoints[0]['speed'];
					$normPoints[$norm_array_pos]['vario']=$goodPoints[0]['vario'];
					$normPoints[$norm_array_pos]['alt']=$goodPoints[0]['alt'];
					$normPoints[$norm_array_pos]['altV']=$goodPoints[0]['altV'];
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

		// $jsOutput="";
		foreach ($normPoints as $point) {
			$outputBuffer.='$time='.$point['time'].'; $lat='.$point['lat'].'; $lon='.$point['lon'].
			'; $dis='.$point['dis'].'; $alt='.$point['alt'].'; $altV='.$point['altV'].'; $speed='.$point['speed'].'; $vario='.$point['vario'].";\n";
			$this_tm=$point['time']-$min_time;

//$jsOutput.=sprintf("lt[$this_tm]=%.6f;ln[$this_tm]=%.6f;d[$this_tm]=%d;a[$this_tm]=%d;s[$this_tm]=%0.1f;v[$this_tm]=%.2f;\n"
	//							,$point['lat'],-$point['lon'],$point['dis'],$point['alt'],$point['speed'],$point['vario']);
		}
		$path_igc = dirname($this->getPointsFilename(1));
		if (!is_dir($path_igc)) makeDir($path_igc, 0755);

		// write saned js file
		// writeFile($this->getJsFilename(1),$jsOutput);

		// write saned IGC file
		writeFile($this->getPointsFilename(1),$outputBuffer);

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
				} else { // no triangle
					$km_triangle=0;
					$score_triangle=0;
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
					if ($km_straight>=$mindist || $km_triangle==0) $str.="$km_straight\n$score_straight\n$factor\n";
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


	/****************************************************************************************
	****************************************************************************************

		Core function of analizing an igc

	****************************************************************************************
	****************************************************************************************/
	function getFlightFromIGC($filename) {
		if ( !is_file($filename) ) {
			DEBUG("IGC",1,"getFlightFromIGC: File was not found:$filename<br>");
			return 0;
		}

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
		
		$tm1=time()+3600*24*30;
		$tm2=0;
		
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

				// also check for bad points
				// 012345678901234567890123456789
				// B1522144902558N00848090EV0058400000

				if  ( strlen($line)  < 23  || $line{24}=='V') {
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
				$mean_vario=( $neighboors[$getPointsNum-1]->getAlt() - $neighboors[0]->getAlt() ) / 
							( $neighboors[$getPointsNum-1]->getTime() - $neighboors[0]->getTime()  )	;
				//if ($mean_vario<0) {
				//		DEBUG("IGC",8,"[$Brecords-$p] mean_vario :$mean_vario <0 <br>");
				//}
							
				$data_speed[$i]=$mean_speed; 
				$data_vario[$i]=$mean_vario;			
				// $mean_vario = $mean_vario/($getPointsNum-1); // mean vario is wrong

				if ($neighboors[0]->getTime() < $tm1 ) $tm1=$neighboors[0]->getTime();
				if ($neighboors[0]->getTime() > $tm2 ) $tm2=$neighboors[0]->getTime();
				
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
			} else if ($Brecords>0 && ( $REJ_T_zero_time_diff/$Brecords > 0.9 ) ) { // more than 90% stopped points
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
			$reduceArray=getReduceArray($p ,$this->maxPointNum);
			// print_r($recudeArray);
			$mod=count($reduceArray);
			// $mod= ceil( $p / $this->maxPointNum );
		}
		DEBUG("IGC",1,"will use a reduce array of length $mod<br>");
		
		$duration=$tm2-$tm1;
		$intervalSecs=round($duration/$p);
		
		// echo "<hr>good points: $p duration:$duration, intervalSecs:$intervalSecs<hr>";
		
		$pointsNeededForTakeoff=5;
		
		if ($intervalSecs>=8) {			
			$pointsNeededForTakeoff=2;
		}
		
		
		$alreadyInPoints=0;
		$stopReadingPoints=0;
		$this->timezone=1000;
		$day_offset =0;
		$foundNewTrack=0;

		$slow_points=0;
		$slow_points_dt=0;
		$stillOnGround=1;

		$tmpDate=0;

		foreach($lines as $iii=>$line) {
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

					$tmpTime=$firstPoint->gpsTime + $this->timezone*3600;
					// Now also check if we are one day minus (for US flights )
					if ( $tmpTime < 0  && $tmpDate==0 ) { // one day before!
						$this->DATE=dates::moveDaysFromDate($this->DATE,-1);
						$tmpDate=1;
					}
					// take care of day change for timezones in australia/nz etc
					if (  $tmpTime > 86400  && $tmpDate==0 )  { // UTC date in the igc file  needs to be +1
						$this->DATE=dates::moveDaysFromDate($this->DATE,1);
						$tmpDate=1;
					}

					// sanity checks
					if ( $firstPoint->getAlt()  > $this->maxAllowedHeight ) continue;
					// echo "times: ".$firstPoint->gpsTime.", ".$firstPoint->getTime()." start_time: ".$this->START_TIME ."<BR> ";
					if ( $this->forceBounds && ! $this->checkBound($firstPoint->getTime() ) ) continue; // not inside time window

					//$this->FIRST_POINT=$line;
					$this->firstPointTM= $firstPoint->gpsTime;
					$this->firstLat=$firstPoint->lat();
					$this->firstLon=$firstPoint->lon();

					$this->TAKEOFF_ALT= $firstPoint->getAlt();
					$this->MIN_ALT= $firstPoint->getAlt();
					if ( ! $this->forceBounds) $this->START_TIME = $firstPoint->getTime();
					$prevPoint=new gpsPoint($line,$this->timezone);
					$prevPoint2=new gpsPoint($line,$this->timezone);
				} else  {
					$lastPoint=new gpsPoint($line,$this->timezone);
					$lastPoint->gpsTime+=$day_offset;

					if ( $this->forceBounds && ! $this->checkBound($lastPoint->getTime() ) ) {
						 $lastPoint=$prevPoint;
						 continue; // not inside time window
					}

					$time_diff= $lastPoint->getTime() - $prevPoint->getTime() ;
					$time_diff2= $lastPoint->getTime() - $prevPoint2->getTime() ;
					
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
							// if we are still on the ground  we dont care about time gap
							if ( !$stillOnGround ) {
								// not inside time window  OR not checking go ahead
								$lastPoint=$prevPoint;
								$foundNewTrack=1;
								DEBUG("IGC",1,"[$points] $line<br>");
								DEBUG("IGC",1,"[$points] Found a new track (Time diff of $time_diff secs)<br>");
								continue;
							}
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
						if ( ($fast_points>=$pointsNeededForTakeoff || $fast_points_dt>30) && $stillOnGround) { // found 5 flying points or 30 secs
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
						if ( ($slow_points>$pointsNeededForTakeoff && $slow_points_dt>180)  || $slow_points_dt>300) {
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

					if ($time_diff2>10) {
						$tmp = $lastPoint->calcDistance($prevPoint2);
						$alt = $lastPoint->getAlt();
						$deltaseconds = $time_diff2;
						$speed = ($deltaseconds)?$tmp*3.6/($deltaseconds):0.0; /* in km/h */
						if ($deltaseconds) $vario=($alt-$prevPoint2->getAlt() ) / $deltaseconds;
						$prevPoint2=new gpsPoint($line,$this->timezone);
						$prevPoint2->gpsTime+=$day_offset;
						
						// update maximum speed
						if ($speed > $this->MAX_SPEED)  $this->MAX_SPEED=$speed;
						$this->MEAN_SPEED +=$speed;
						$MEAN_SPEED_POINTS++;
						// UPDATE MIN-MAX VARIO
						if ($vario > $this->MAX_VARIO) $this->MAX_VARIO=$vario;
						if ($vario < $this->MIN_VARIO) $this->MIN_VARIO=$vario;
						
					}
					
					//$speed=$data_speed[$iii-1]+0; 
					// $vario=$data_vario[$iii-1]+0;					
					
					// UPDATE MIN-MAX ALT
					if ($alt> $this->MAX_ALT) $this->MAX_ALT=$alt;
					if ($alt< $this->MIN_ALT) $this->MIN_ALT=$alt;

					
					// end computing
					$prevPoint=new gpsPoint($line,$this->timezone);
					$prevPoint->gpsTime+=$day_offset;
					if ($mod>=1)  {
						if ( $reduceArray[ $points % $mod]  == 0  ) $outputLine="";
					}
				}
				$points++;
			}  // end else
			$outputBuffer.=$outputLine;

		} // end main loop

		// echo "<HR>MIN VARIO".$this->MIN_VARIO."<HR>";
		//
		if ($stillOnGround && $this->LINEAR_DISTANCE < 50 )  {
			DEBUG("IGC",1,"NO TAKEOFF FOUND: ");
			return 0; // no valid points found
		}

		$path_igc=dirname($this->getIGCFilename(1));
		if ( !is_dir($path_igc) ) {
			makeDir($path_igc,0755);
		}

		/*write the full saned file */
		$fullSanedFile='';
		foreach($lines as $line) {
			$line=trim($line);
			if  (strlen($line)==0) continue;
			if ($line{0}=='B' && $line{1}=='X') continue ; // MARKED BAD from BEFORE
			// if  ( strlen($line) < 23 || strlen($line) > 100  ) continue;
			$fullSanedFile.=$line."\n";
		}


		if (! writeFile($this->getIGCFilename(2),$fullSanedFile) ) {
		   echo "Problem writing to file (".$this->getIGCFilename(2).")";
		}
		// echo "<HR><HR>". $this->getIGCFilename(2) .strlen($fullSanedFile)."<HR><HR>";
		/* done wrting the full saned file */

		// write saned IGC file
		if (! writeFile($this->getIGCFilename(1),$outputBuffer) ) {
		   echo "Problem writing to file (".$this->getIGCFilename(1).")";
		}
		// done write saned IGC file

		if ($lastPoint) {
			$this->lastPointTM=$lastPoint->gpsTime;
			$this->lastLon=$lastPoint->lon();
			$this->lastLat=$lastPoint->lat();

			$this->LANDING_ALT= $lastPoint->getAlt();
			$this->END_TIME =   $lastPoint->getTime();
		} else {
			$this->lastPointTM=0;
			$this->lastLon=0;
			$this->lastLat=0;

			$this->LANDING_ALT= 0;
			$this->END_TIME =   0;
		}

		$this->DURATION =   $this->END_TIME - $this->START_TIME ;
		$this->MEAN_SPEED = $this->MEAN_SPEED / $MEAN_SPEED_POINTS;

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
		global $baseInstallationPath,$CONF_abs_path,$CONF;

		global $alreadyValidatedInPage;
		if ($alreadyValidatedInPage) return;
		$alreadyValidatedInPage=1;

		set_time_limit (240);
		$customValidationCodeFile=dirname(__FILE__)."/site/CODE_validate_custom.php";
		if (  $CONF_use_custom_validation && file_exists($customValidationCodeFile) ) { // we expect the result on $ok
			include $customValidationCodeFile;
		} else { //standard leoanrdo validation -> the server not yet working
			$IGCwebPath=urlencode("http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/").$this->getIGCRelPath(0); // validate original file
			$fl=  $CONF['validation']['server_url']."?file=".$IGCwebPath;
			if ($DBGlvl) $fl.="&dbg=1";
			DEBUG("VALIDATE_IGC",1,"Will use URL: $fl<BR>");
			$contents =	split("\n",fetchURL($fl,30));
			if (!$contents) return 0;

			$ok=-1;
			foreach ( $contents as $lnum=>$line) {
				DEBUG("VALIDATE",64,"$line");
			
				if (trim($contents[$lnum])=="VALI:OK") {
					$ok=1;
					$valStr=trim($contents[$lnum+1]);
				}
				if (trim($contents[$lnum])=="VALI:NOK") {
					$ok=-1;
					$valStr=trim($contents[$lnum+1]);
				}
				if (trim($contents[$lnum])=="VALI:NNOK") {
					$ok=-2;
					$valStr=trim($contents[$lnum+1]);
				}
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

	function checkSanedFiles() {
		// do some basic check for saned igc file
		if (!is_file($this->getIGCFilename(1)) || !is_file($this->getIGCFilename(2))   ) {
			// we have to create it
			DEBUG('checkSanedFiles',1,"Saned files are missing for flight: ".$this->flightID.", we will create it<BR>");
			if (!is_file($this->getIGCFilename(0) ) ) {
				DEBUG('checkSanedFiles',1,"Original file is missing for flight: ".$this->flightID." <BR>".$this->getIGCFilename(0)."<BR>");
				require_once dirname(__FILE__).'/CL_actionLogger.php';
				$log=new Logger();
				$log->userID  	=$this->userID;
				$log->ItemType	=1 ; // flight;
				$log->ItemID	= ( ( $this->serverID && $this->serverID!=$CONF_server_id ) ?$this->original_ID:$this->flightID ); // 0 at start will fill in later if successfull
				$log->ServerItemID	=  ( $this->serverID?$this->serverID:$CONF_server_id);
				$log->ActionID  = 8 ;  //1  => add  2  => edit , 8=score flight;
				$log->ActionXML	= "{ }";
				$log->Modifier	= 0;
				$log->ModifierID= 0;
				$log->ServerModifierID =0;
				$log->Result = 0;
				if (!$log->Result) $log->ResultDescription ="IGC file misssing";
				if (!$log->put()) echo "Problem in logger<BR>";
				return 0;
			}
			$this->getFlightFromIGC($this->getIGCFilename(0) ) ;
			if (!is_file($this->getIGCFilename(1)) || !is_file($this->getIGCFilename(2)) ) {
				 //saned file could no be created!!!
				echo "Saned files could no be created for flight: ".$this->flightID." <BR>".$this->getIGCFilename(0)."<BR>";
				require_once dirname(__FILE__).'/CL_actionLogger.php';
				$log=new Logger();
				$log->userID  	=$this->userID;
				$log->ItemType	=1 ; // flight;
				$log->ItemID	= ( ( $this->serverID && $this->serverID!=$CONF_server_id ) ?$this->original_ID:$this->flightID ); // 0 at start will fill in later if successfull
				$log->ServerItemID	=  ( $this->serverID?$this->serverID:$CONF_server_id);
				$log->ActionID  = 8 ;  //1  => add  2  => edit , 8=score flight;
				$log->ActionXML	= "{ }";
				$log->Modifier	= 0;
				$log->ModifierID= 0;
				$log->ServerModifierID =0;
				$log->Result = 0;
				if (!$log->Result) $log->ResultDescription ="Saned file could no be created";
				if (!$log->put()) echo "Problem in logger<BR>";
				return 0;
			}
		}

		return 1;
	}

	function computeScore() {
		global $OLCScoringServerUseInternal,$OLCScoringServerPath, $scoringServerActive , $OLCScoringServerPassword;
		global $baseInstallationPath,$CONF_allow_olc_files,$CONF,$CONF_server_id;

		if (! $scoringServerActive) return 0;

		set_time_limit (240);

		// do some basic check for saned igc file
		if (! $this->checkSanedFiles() ) {
			return 0;
		}

		$flightScore=new flightScore($this->flightID);
		if ($OLCScoringServerUseInternal ) {
			$results=$flightScore->getScore( $this->getIGCFilename(1) ,1  );
		} else {
			$results=$flightScore->getScore( $this->getIGCRelPath(1) , 0  );
		}
		$flightScore->parseScore($results);

		// make a second pass
		$flightScore->computeSecondPass($this->getIGCFilename(2));

		// now is the time to search for the OLC files, manually optimization
		// and 'inject' these values into the $flightScore object
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

				//$manualScoreInfo['FLIGHT_KM']=$lines[5]*1000;
				//$manualScoreInfo['FLIGHT_POINTS']=$lines[6]+0;

				$factor=$lines[7]+0;
				if ($factor==1.5) 	$this->BEST_FLIGHT_TYPE="FREE_FLIGHT";
				if ($factor==1.75) 	$this->BEST_FLIGHT_TYPE="FREE_TRIANGLE";
				if ($factor==2) 	$this->BEST_FLIGHT_TYPE="FAI_TRIANGLE";

				DEBUG('OLC_SCORE',1,"MANUAL FLIGHT_KM: ".$this->FLIGHT_KM."<BR>");
				DEBUG('OLC_SCORE',1,"MANUAL FLIGHT_POINTS: ".$this->FLIGHT_POINTS."<BR>");
				DEBUG('OLC_SCORE',1,"MANUAL BEST_FLIGHT_TYPE: ".$this->BEST_FLIGHT_TYPE."<BR>");

				$manualScoreTP=array();
				for($i=0;$i<5;$i++) {
				    //              01234567890123456
					// must convert 4624328N00805128E to N54:54.097 W02:40.375
					$str=substr($lines[$i],7,1) .substr($lines[$i],0,2).':'.substr($lines[$i],2,2).'.'.substr($lines[$i],4,3).' '.
						 substr($lines[$i],16,1).substr($lines[$i],8,3).':'.substr($lines[$i],11,2).'.'.substr($lines[$i],13,3);
					DEBUG('OLC_SCORE',1,"MANUAL TurnPoint ".($i+1).": $str<BR>");
					// $manualScoreTP[$i+1]=$str;
					$manualScoreTP[$i+1]=sprintf("B%02d%02d%02d%sA0000000000",00,00,00,$lines[$i]);

				}

				$defaultMethodID= $CONF['scoring']['default_set'];
				$defaultScore=$flightScore->scores[$defaultMethodID];
				$this->autoScore=$defaultScore['bestScore'];
				//echo "<pre>";
				//print_r($flightScore->scores);
				//echo "</pre>";

				foreach ( $flightScore->scores as $methodID=>$scoreForMethod) {
					$distance=$this->FLIGHT_KM/1000;
					$flightScore->scores[$methodID][$this->BEST_FLIGHT_TYPE]['distance']=$distance;
					$flightScore->scores[$methodID][$this->BEST_FLIGHT_TYPE]['score']=
							$distance * $CONF['scoring']['sets'][$methodID]['types'][$this->BEST_FLIGHT_TYPE] ;
					for($j=1;$j<=5;$j++) {
						$flightScore->scores[$methodID][$this->BEST_FLIGHT_TYPE]['tp'][$j]=$manualScoreTP[$j];
					}

					// update the best score, in case we have a new bestScoreType
					foreach($flightScore->scores[$methodID] as $scoreType=>$scoreDetails ) {
						//echo "<h1>$scoreType</h1>";
						if (!is_array($scoreDetails) ) { continue; }
						//echo $scoreDetails['score']." > ".$scoreForMethod['bestScore']." <BR>";
						if ($scoreDetails['score'] > $scoreForMethod['bestScore'] ) {
							//echo "FOUND BETTER SCORE !!!!!!!!!<BR><BR>";
							$flightScore->scores[$methodID]['bestScore']=$scoreDetails['score'];
							$flightScore->scores[$methodID]['bestScoreType']=$this->BEST_FLIGHT_TYPE;
							$flightScore->scores[$methodID]['bestDistance']=$scoreDetails['distance'];

						}
					}
				}
				//echo "<pre>";
				//print_r($flightScore->scores);
				//echo "</pre>";

				$manualScore=1;

			}
		}

		//put also in scores table, the flight is sure to be present in flights table
		$flightScore->putToDB(1,1);

		$defaultMethodID= $CONF['scoring']['default_set'];
		$defaultScore=$flightScore->scores[$defaultMethodID];

		$this->MAX_LINEAR_DISTANCE=$flightScore->MAX_LINEAR_DISTANCE;
		if ($manualScore) {
			// $this->autoScore=$defaultScore['bestScore'];
		} else {
			$this->BEST_FLIGHT_TYPE	=$defaultScore['bestScoreType'];
			$this->FLIGHT_POINTS	=$defaultScore['bestScore'];
			$this->FLIGHT_KM		=$defaultScore[ $defaultScore['bestScoreType'] ]['distance']*1000;
		}

		require_once dirname(__FILE__).'/CL_actionLogger.php';
		$log=new Logger();
		$log->userID  	=$this->userID;
		$log->ItemType	=1 ; // flight;
		$log->ItemID	= ( ( $this->serverID && $this->serverID!=$CONF_server_id ) ?$this->original_ID:$this->flightID ); // 0 at start will fill in later if successfull
		$log->ServerItemID	=  ( $this->serverID?$this->serverID:$CONF_server_id);
		$log->ActionID  = 8 ;  //1  => add  2  => edit , 8=score flight;
		$log->ActionXML	= "{\n". $flightScore->toSyncJSON()."\n}";
		$log->Modifier	= 0;
		$log->ModifierID= 0;
		$log->ServerModifierID =0;
		$log->Result = 1;
		// if (!$log->Result) $log->ResultDescription ="Problem in puting flight to DB $query";
		if (!$log->put()) echo "Problem in logger<BR>";
/*

		if ($OLCScoringServerUseInternal ) {
			$file=$this->getIGCFilename(1);

			$path=dirname( __FILE__ ).'/server';
			$igcFilename=tempnam($path."/tmpFiles","IGC.");  //urlencode($basename)
			@unlink($igcFilename);

			$lines=file($file);

			$cont="";
			foreach($lines as $line) {
				$cont.=$line;
			}


			if (!$handle = fopen($igcFilename, 'w')) exit;
			if (!fwrite($handle, $cont))    exit;
			fclose ($handle);

			@chmod ($path."/olc", 0755);
			if ($CONF['os']=='windows') $olcEXE='olc.exe';
			else $olcEXE='olc';

			$cmd=$path."/$olcEXE $igcFilename";
			DEBUG('OLC_SCORE',1,"cmd=$cmd");
			exec($cmd,$res);

			DEBUG('OLC_SCORE',1,"result has ".count($res)." lines<BR>");
			$contents=array();
			foreach($res as $line) {
					DEBUG('OLC_SCORE',1,$line.'<BR>');
					if (substr($line,0,4)=="OUT ") {
						// echo substr($line,4)."\n";
						$contents[]=substr($line,4);
					}
			}

			@unlink($igcFilename);

		} else {
			$IGCwebPath=urlencode("http://".$_SERVER['SERVER_NAME'].$baseInstallationPath."/").$this->getIGCRelPath(1); // score saned file

			$fl= $OLCScoringServerPath."?pass=".$OLCScoringServerPassword."&file=".$IGCwebPath;
			DEBUG("OLC_SCORE",1,"Will use URL: $fl<BR>");
			//$contents = file($fl);
			$contents =	split("\n",fetchURL($fl,40));
			if (!$contents) return;
		}

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
			}

			if (! $manualScore) {
				$this->$var_name=trim($var_value);
			} else {
				if ($var_name=='MAX_LINEAR_DISTANCE') $this->$var_name=trim($var_value);
				if ($var_name=='FLIGHT_POINTS') $this->autoScore=trim($var_value);
			}

			DEBUG("OLC_SCORE",1,"#".$var_name."=".$var_value."#<br>\n");
		}
		*/


	//		if (! $manualScore) $this->FLIGHT_KM=$this->FLIGHT_KM*1000;

	}

	function makeScoreLogEntry(){
		global $CONF_server_id;

		$flightScore=new flightScore($this->flightID);
		$flightScore->getFromDB();

		require_once dirname(__FILE__).'/CL_actionLogger.php';
		$log=new Logger();
		$log->userID  	=$this->userID;
		$log->ItemType	=1 ; // flight;
		$log->ItemID	= ( ( $this->serverID && $this->serverID!=$CONF_server_id ) ?$this->original_ID:$this->flightID ); // 0 at start will fill in later if successfull
		$log->ServerItemID	=  ( $this->serverID?$this->serverID:$CONF_server_id);
		$log->ActionID  = 8 ;  //1  => add  2  => edit , 8=score flight;
		$log->ActionXML	= "{\n". $flightScore->toSyncJSON()."\n}";
		$log->Modifier	= 0;
		$log->ModifierID= 0;
		$log->ServerModifierID =0;
		$log->Result = 1;
		// if (!$log->Result) $log->ResultDescription ="Problem in puting flight to DB $query";
		if (!$log->put()) echo "Problem in logger<BR>";
	}

	function getMapFromServerDEM($num=0) {
		global  $CONF;

		 $forceRefresh=1;

		$filename=$this->getMapFilename();
		if ( is_file($filename) && ! $forceRefresh ) {
			return;
		}

		// if no file exists do the proccess now
		if ( ! is_file($this->getPointsFilename(1) ) || $forceRefresh ) $this->storeIGCvalues();

		$lines = file($this->getPointsFilename(1)); // get the normalized with constant time step points array
		if (!$lines) return;
		$i = 0;

		$jsTrack['max_alt']=0;
		$jsTrack['min_alt']=100000;

		$min_lat=1000;
		$max_lat=-1000;
		$min_lon=1000;
		$max_lon=-1000;

		for($k=3;$k< count($lines);$k++){
			$line = trim($lines[$k]);
			if (strlen($line) == 0) continue;
			eval($line);
			$lon=-$lon;
			if ( $lat  > $max_lat )  $max_lat =$lat  ;
			if ( $lat  < $min_lat )  $min_lat =$lat  ;
			if ( $lon  > $max_lon )  $max_lon =$lon  ;
			if ( $lon  < $min_lon )  $min_lon =$lon  ;
			$lat_arr[]=$lat;
			$lon_arr[]=$lon;
		}
/*
		$max_lat+=0.01;
		$max_lon+=0.01;

		$min_lat-=0.01;
		$min_lon-=0.01;
*/
		$totalWidth1=calc_distance($min_lat, $min_lon,$min_lat, $max_lon);
		$totalWidth2=calc_distance($max_lat, $min_lon,$max_lat, $max_lon);
		$totalWidth=max($totalWidth1,$totalWidth2);

		$totalHeight1=calc_distance($min_lat, $min_lon,$max_lat, $min_lon);
		$totalHeight2=calc_distance($min_lat, $max_lon,$max_lat, $max_lon);
		$totalHeight=max($totalHeight1,$totalHeight2);

		if ($totalWidth> $totalHeight ) {
			// Landscape  style
			DEBUG("MAP",1,"Landscape style <BR>");
			DEBUG("MAP",1,"totalWidth: $totalWidth, totalHeight: $totalHeight, totalHeight/totalWidth: ".( $totalHeight / $totalWidth)."<br>");
			// if ( $totalHeight / $totalWidth < 3/4 ) $totalHeight = (3/4) *  $totalWidth ;
			$mapWidthPixels=600;
			$mapHeightPixels=$mapWidthPixels * ( $totalHeight / $totalWidth);

		} else {
			// portait style
			DEBUG("MAP",1,"Portait style <BR>");
			DEBUG("MAP",1,"totalWidth: $totalWidth, totalHeight: $totalHeight, totalWidth/totalHeight: ".( $totalWidth / $totalHeight)."<br>");
			// if ( $totalWidth  / $totalHeight < 3/4 )  $totalWidth  = (3/4) * $totalHeight ;
			$mapWidthPixels=300;
			$mapHeightPixels=$mapWidthPixels * ( $totalHeight / $totalWidth);
		}

		DEBUG("MAP",1,"MAP  min_lat: $min_lat, min_lon: $min_lon, max_lat: $max_lat, max_lon: $max_lon <BR>");

		require_once dirname(__FILE__).'/CL_hgt.php';


		$latStep= ($max_lat-$min_lat) /  $mapHeightPixels;
		$lonStep= ($max_lon-$min_lon) /  $mapWidthPixels ;


		$max_ground_elev  =0;

		$lon=$min_lon ;
		for ($x=0;$x<$mapWidthPixels;$x++) {

			$lat=$min_lat ;
			for ($y=0;$y<$mapHeightPixels;$y++) {

				// echo "lat:$lat lon:$lon<BR>";

				// $lon=$min_lon+ $x * ($max_lon-$min_lon) /  $mapWidthPixels;
				// $lat=$min_lat+ $y * ($max_lat-$min_lat) / $mapHeightPixels;
				$alt=hgt::getHeight($lat,$lon);
				//echo "$alt#";
				if ($alt >$max_ground_elev  ) $max_ground_elev  =$alt;
				$mapEvelGnd[$x][$y]=$alt;

				// $mapLatLon[$x][$y]="$lat,$lon";
				$lat+=$latStep;
			}
			$lon+=$lonStep;
		}

		// print_r($mapEvelGnd);
		// print_r($mapLatLon);

  		$img=imagecreatetruecolor($mapWidthPixels,$mapHeightPixels);

		$backColor =imagecolorallocate ($img,214,223,209);
		// $backColor =imagecolorallocate ($this->img,73,76,50);
		if ($backColor==-1) echo "FAILED TO allocate new color<br>";
		// imagefill($this->img,0,0, 1 );

		imagefilledrectangle($img, 0, 0, $mapWidthPixels-1, $mapHeightPixels-1, $backColor);

        // Allocate the color map
        InterpolateRGB($colorScale, RGB(  0,   0, 110), RGB(  0,   0, 110),   0, 255);
        InterpolateRGB($colorScale, RGB(  0, 100,   0), RGB(180, 180,  50),   1,  60);
        InterpolateRGB($colorScale, RGB(180, 180,  50), RGB(150, 110,  50),  60, 100);
        InterpolateRGB($colorScale, RGB(150, 110,  50), RGB(150, 150, 150), 100, 150);
        InterpolateRGB($colorScale, RGB(150, 150, 150), RGB(255, 255, 255), 150, 200);
        InterpolateRGB($colorScale, RGB(255, 255, 255), RGB(255, 255, 255), 200, 253);
        InterpolateRGB($colorScale, RGB(  0,   0,   0), RGB(  0,   0,   0), 254, 255);

        AllocateColorMap($img, $colorScale, $cMap);

		$factor= 256/$max_ground_elev;
		for ($x=0;$x<$mapWidthPixels;$x++) {
			for ($y=0;$y<$mapHeightPixels;$y++) {
				$color =$cMap[$mapEvelGnd[$x][$mapHeightPixels-$y] * $factor  - 1];
				imagesetpixel ( $img, $x, $y, $color );
			}
		}

		$track_color = imagecolorallocate($img, 255,0,0);

		for ($i=0;$i<count($lat_arr);$i++) {
			$lat=$lat_arr[$i];
			$lon=$lon_arr[$i];

			$x= ( $lon - $min_lon) * $mapWidthPixels/ ($max_lon-$min_lon) ;
			$y= ( $lat - $min_lat) * $mapHeightPixels/ ($max_lat-$min_lat) ;
			imagesetpixel ( $img, $x, $mapHeightPixels-$y, $track_color  );
		}

		imagefilter($img, IMG_FILTER_SMOOTH,200);

		imagejpeg($img, $filename , 85);
		imagedestroy($img);
		return;

	}

	function getMapFromServer($num=0) {
		global $moduleRelPath,$mapServerActive;
		if (!$mapServerActive) return;

		require_once dirname(__FILE__)."/CL_map.php";

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

	function getFlightFromDB($flightID,$updateTakeoff=1,$row=array()) {
	  global $db,$CONF_photosPerFlight;
  	  global $flightsTable;
	  global $nativeLanguage,$currentlang;

	  if ( count($row) ) $useData=true;
	  else $useData=false;

	  if (!$useData) {
		  $query="SELECT * FROM $flightsTable  WHERE ID=".$flightID." ";

		  $res= $db->sql_query($query);
		  # Error checking
		  if($res <= 0){
			 echo("<H3> Error in getFlightFromDB() query! $query</H3>\n");
			 exit();
		  }

		  if (! $row = $db->sql_fetchrow($res) ) {
		  echo "###### ERRROR ####$query###";
			  return 0;
		  }
	  }

		$this->flightID=$flightID;
		$name=getPilotRealName($row["userID"],$row["userServerID"]);
		$this->userName=$name;

		$this->serverID=$row["serverID"];
		$this->excludeFrom=$row["excludeFrom"];

		$this->originalURL=$row["originalURL"];
		$this->originalKML=$row["originalKML"];

		$this->original_ID=$row["original_ID"];

		$this->originalUserID=$row["originalUserID"];
		$this->userServerID=$row["userServerID"];

		$this->NACclubID=$row["NACclubID"];
		/// Martin Jursa, 17.05.2007
		$this->NACid=$row["NACid"];
		$this->cat=$row["cat"];
		$this->subcat=$row["subcat"];
		$this->category=$row["category"];
		$this->active=$row["active"];
		$this->private=$row["private"];

		$this->gliderCertCategory=$row["gliderCertCategory"];
		$this->startType=$row["startType"];

		$this->validated=$row["validated"];
		$this->grecord=$row["grecord"];
		$this->validationMessage=$row["validationMessage"];

		$this->airspaceCheck=$row["airspaceCheck"]+0;
		$this->airspaceCheckFinal=$row["airspaceCheckFinal"]+0;
		$this->airspaceCheckMsg=$row["airspaceCheckMsg"];
		$this->checkedBy=$row["checkedBy"];

		$this->timesViewed=$row["timesViewed"];
		$this->dateAdded=$row["dateAdded"];
		$this->dateUpdated=$row["dateUpdated"];
		$this->timezone=$row["timezone"];

		$this->filename=$row["filename"];
		$this->userID=$row["userID"];
		$this->comments=$row["comments"];
		$this->commentsNum=$row["commentsNum"]+0;
		$this->commentsEnabled=$row["commentsEnabled"]+0;

		$this->glider=$row["glider"];
		$this->gliderBrandID =$row["gliderBrandID"];
		$this->linkURL=$row["linkURL"];

		$this->hasPhotos=$row["hasPhotos"];
/*
		for($i=1;$i<=$CONF_photosPerFlight;$i++) {
			$var_name="photo".$i."Filename";
			$this->$var_name=$row[$var_name];
		}
*/

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

		$this->START_TIME=$row["START_TIME"];
		$this->END_TIME=$row["END_TIME"];
		$this->DURATION=$row["DURATION"];

		$this->MAX_LINEAR_DISTANCE =$row["MAX_LINEAR_DISTANCE"];
		$this->BEST_FLIGHT_TYPE=$row["BEST_FLIGHT_TYPE"];
		$this->FLIGHT_KM=$row["FLIGHT_KM"];
		$this->FLIGHT_POINTS=$row["FLIGHT_POINTS"];

		$this->autoScore=$row["autoScore"];

		$this->externalFlightType=$row["externalFlightType"];
		$this->isLive=$row["isLive"];
		$this->firstPointTM=$row["firstPointTM"];
		$this->firstLat=$row["firstLat"];
		$this->firstLon=$row["firstLon"];
		$this->lastPointTM=$row["lastPointTM"];
		$this->lastLat=$row["lastLat"];
		$this->lastLon=$row["lastLon"];
		$this->forceBounds=$row["forceBounds"];

		$this->hash=$row["hash"];

//to be deleted START
//		$this->FIRST_POINT=$row["FIRST_POINT"];
//		$this->LAST_POINT=$row["LAST_POINT"];

/*
		$this->turnpoint1=$row["turnpoint1"];
		$this->turnpoint2=$row["turnpoint2"];
		$this->turnpoint3=$row["turnpoint3"];
		$this->turnpoint4=$row["turnpoint4"];
		$this->turnpoint5=$row["turnpoint5"];
*/


//		$this->olcRefNum=$row["olcRefNum"];
//		$this->olcFilename=$row["olcFilename"];
//		$this->olcDateSubmited =$row["olcDateSubmited"];
//to be deleted END


		// now recompute the
		// $this->originalURL
		// $this->originalKML
		$this->getOriginalKML();
		$this->getOriginalURL();

		if (!$useData) {
	  		$db->sql_freeresult($res);
		}

		if ($this->filename && $updateTakeoff) $this->updateTakeoffLanding();
		return 1;
	}

	function updateTakeoffLanding() {
		global $db;
		global $flightsTable, $waypoints;

		$firstPoint=new gpsPoint('',$this->timezone);
		$firstPoint->setLat($this->firstLat);
		$firstPoint->setLon($this->firstLon);
		$firstPoint->gpsTime=$this->firstPointTM;

		$lastPoint=new gpsPoint('',$this->timezone);
		$lastPoint->setLat($this->lastLat);
		$lastPoint->setLon($this->lastLon);
		$lastPoint->gpsTime=$this->lastPointTM;

		//$firstPoint=new gpsPoint($this->FIRST_POINT,$this->timezone);
		//$lastPoint=new gpsPoint($this->LAST_POINT,$this->timezone);

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
			# martin jursa 28.05.2008: delete using the deleteFile() method to avoid log flooding
			$this->deleteFile($this->getPhotoFilename($photoNum) );
			$this->deleteFile($this->getPhotoFilename($photoNum).".icon.jpg" );
		}
		$this->$var_name="";
	}

	function renameTracklog($newName,$oldName='') {
		global $db;
		global $flightsTable;
		global $CONF_server_id;

		if ($oldName) {
			$orgFilename=$this->filename;
			$this->filename=$oldName;
		}

		$this->deleteSecondaryFiles();

		$this->deleteFile($this->getMapFilename() );

		for ($metric_system=1;$metric_system<=2;$metric_system++) {
			for ($raw=0;$raw<=1;$raw++) {
				$this->deleteFile($this->getChartFilename("alt",$metric_system,$raw) );
				$this->deleteFile($this->getChartFilename("speed",$metric_system,$raw) );
				$this->deleteFile($this->getChartFilename("vario",$metric_system,$raw) );
				$this->deleteFile($this->getChartFilename("takeoff_distance",$metric_system,$raw) );
			}
		}

		$oldFilename=$this->getIGCFilename() ;
		$oldFilenameSaned=$this->getIGCFilename(1) ;
		$oldFilenameSanedFull=$this->getIGCFilename(2) ;
		$oldOLCfile=$this->getIGCFilename(0).".olc";

		$this->filename=$newName;

		@rename($oldFilename,$this->getIGCFilename() );
		@rename($oldFilenameSaned,$this->getIGCFilename(1) );
		@rename($oldFilenameSanedFull,$this->getIGCFilename(2) );
		@rename($oldOLCfile,$this->getIGCFilename(0).".olc");


		$query="UPDATE $flightsTable SET filename='".$this->filename."' WHERE ID=".$this->flightID;
		// echo $query."<HR>";
		$res= $db->sql_query($query );
		if($res <= 0){
			 echo "Error renaming IGC file for flight ".$this->flightID." : $query<BR>";
		}

		require_once dirname(__FILE__).'/lib/json/CL_json.php';
		require_once dirname(__FILE__).'/CL_actionLogger.php';
		$log=new Logger();
		$log->userID  	=$this->userID;
		$log->ItemType	=1 ; // flight;
		$log->ItemID	= ( ( $this->serverID && $this->serverID!=$CONF_server_id ) ?$this->original_ID:$this->flightID ); // 0 at start will fill in later if successfull
		$log->ServerItemID	= ( $this->serverID?$this->serverID:$CONF_server_id) ;
		$log->ActionID  = 16 ;  //1  => add  2  => edit; 4  => delete ; 16 -> rename trackog
		$log->ActionXML	=
'{
	"serverID": '. ( $this->serverID?$this->serverID:$CONF_server_id).',
	"id": '.($isLocal ? $this->flightID : $this->original_ID  ).',
	"linkIGC": "'.$this->getIGC_URL().'",
	"linkIGCzip": "'.$this->getZippedIGC_URL().'",
	"newFilename": "'.json::prepStr($this->filename).'",
	"oldFilename": "'.json::prepStr($oldName).'"
}';
		$log->Modifier	= 0;
		$log->ModifierID= 0;
		$log->ServerModifierID =0;
		$log->Result = 1;
		if (!$log->Result) $log->ResultDescription ="Problem in deleting flight  $query";
		if (!$log->put()) echo "Problem in logger<BR>";
	}

	function deleteSecondaryFiles(){
		# martin jursa 28.05.2008: delete using the deleteFile() method to avoid log flooding		
		$this->deleteFile($this->getJsonFilename() ) ; // json.js
		$this->deleteFile($this->getPolylineFilename() ) ;// *.poly.txt
		$this->deleteFile($this->getPointsFilename(1) ) ;// *.1.txt
		$this->deleteFile($this->getKMLFilename(0) ); // kmz
		$this->deleteFile($this->getKMLFilename(1) ); // man.kmz
		require_once dirname(__FILE__).'/FN_igc2kmz.php';			
		deleteOldKmzFiles($this->getKMLFilename(3),'xxx'); // delete all versions igc2kmz
	}


/**
 * Martin Jursa 28.05.2008
 * Delete function avoiding the @unlink expression which throws warnings if error handling is turned on
 *
 * @param string $filename
 */
	function deleteFile($filename) {
		if (file_exists($filename)) {
			unlink($filename);
		}
	}

	function deleteFlight() {
 		global $db;
		global $flightsTable,$deletedFlightsTable;
		global $CONF_photosPerFlight,$CONF_server_id;

		$query="INSERT INTO $deletedFlightsTable SELECT $flightsTable.* from $flightsTable WHERE $flightsTable.ID=".$this->flightID." ";
		$res= $db->sql_query($query);

        $query="UPDATE $deletedFlightsTable Set dateUpdated='".gmdate("Y-m-d H:i:s")."' where ID=".$this->flightID." ";
	    $res= $db->sql_query($query);

		$query="DELETE from $flightsTable  WHERE ID=".$this->flightID." ";
		// echo $query;
		$res= $db->sql_query($query);
	    # Error checking
	    if($res <= 0){
		  echo("<H3> Error in delete Flight query! </H3>\n");
		  exit();
 	    }

		// save a copy
		$this->flightScore=new flightScore($this->flightID);
		$this->flightScore->getFromDB();

		$flightScore=new flightScore($this->flightID);
		$flightScore->deleteFromDB();
		// Now delete the files

		$this->deleteFile($this->getIGCFilename(0) );
		$this->deleteFile($this->getIGCFilename(0).".olc" );
		
		$this->deleteFile($this->getIGCFilename(1) );
		$this->deleteFile($this->getIGCFilename(2) );


		$this->deleteSecondaryFiles();

		$this->deleteFile($this->getMapFilename());

		for ($metric_system=1;$metric_system<=2;$metric_system++) {
			for ($raw=0;$raw<=1;$raw++) {
				# martin jursa 28.05.2008: delete using the deleteFile() method to avoid log flooding
				$this->deleteFile($this->getChartFilename("alt",$metric_system,$raw) );
				$this->deleteFile($this->getChartFilename("speed",$metric_system,$raw) );
				$this->deleteFile($this->getChartFilename("vario",$metric_system,$raw) );
				$this->deleteFile($this->getChartFilename("takeoff_distance",$metric_system,$raw) );
			}
		}

		if ($this->hasPhotos) {
			$flightPhotos=new flightPhotos($this->flightID);
			$flightPhotos->deleteAllPhotos(0);
		}
		
		if ($this->commentsNum) {
			require_once dirname(__FILE__).'/CL_comments.php';
			$comments=new flightComments($this->flightID);
			$comments->deleteAllComments(0); // dont update the flights table
		}
		
		// Now also hide/unhide same flights
		$this->hideSameFlights();

		require_once dirname(__FILE__).'/CL_actionLogger.php';
		$log=new Logger();
		$log->userID  	=$this->userID;
		$log->ItemType	=1 ; // flight;
		$log->ItemID	= ( ( $this->serverID && $this->serverID!=$CONF_server_id ) ?$this->original_ID:$this->flightID ); // 0 at start will fill in later if successfull
		$log->ServerItemID	= ( $this->serverID?$this->serverID:$CONF_server_id) ;
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

			$this->active=0;
			if (!$this->dateAdded )
				$this->dateAdded= gmdate("Y-m-d H:i:s");

			// $fl_id_2="now(),";
			$fl_id_2=" '".$this->dateAdded."',";

			$this->timesViewed=0;
		}

		$this->dateUpdated = gmdate("Y-m-d H:i:s");

	/*
		for($i=1;$i<=$CONF_photosPerFlight;$i++) {
			$var_name="photo".$i."Filename";
			$p1.="$var_name, ";
			$p2.="'".$this->$var_name."',";
		}
	*/

		// we dont store $originalURL $originalKML. for leonardo originated flights...

		$originalURL = $this->originalURL ;
		$originalKML = $this->originalKML ;
		if ( $this->serverID != 0 ) {
			global $CONF;
			if ( $CONF['servers']['list'][$this->serverID]['isLeo'] == 1  ) {
				$originalURL='';
				$originalKML='';
			}
		}

		// make sure it evaluates to something
		$this->gliderCertCategory+=0;

		/// Martin Jursa 17.05.2007: adding NACid
		$query.=" $flightsTable (".$fl_id_1."filename,userID, dateUpdated,
		cat,subcat,category,active, private ,
		gliderCertCategory, startType,
		validated,grecord,validationMessage,
		hash, serverID, originalURL, originalKML, original_ID,
		originalUserID ,userServerID,
		excludeFrom,

		airspaceCheck,airspaceCheckFinal,airspaceCheckMsg,checkedBy,
		NACclubID,NACid,
		comments, commentsNum, commentsEnabled, glider, gliderBrandID, linkURL, timesViewed,

		takeoffID, takeoffVinicity, landingID, landingVinicity,
		DATE,
		timezone,
		hasPhotos,
		MAX_SPEED ,
		MEAN_SPEED ,
		MAX_ALT ,
		MIN_ALT ,
		TAKEOFF_ALT,
		MAX_VARIO ,
		MIN_VARIO ,
		LINEAR_DISTANCE , ".
		"MAX_LINEAR_DISTANCE ,".
		"START_TIME,
		END_TIME,
		DURATION, ".
		"BEST_FLIGHT_TYPE,
		FLIGHT_KM,
		FLIGHT_POINTS,".

		"autoScore,
		forceBounds,
		externalFlightType,	isLive,
	
		firstPointTM, firstLat, firstLon,
		lastPointTM, lastLat, lastLon

		)
		VALUES (".$fl_id_2."'$this->filename',$this->userID, '$this->dateUpdated',
		$this->cat,$this->subcat,$this->category,$this->active, $this->private,
		$this->gliderCertCategory, $this->startType,
		$this->validated, $this->grecord, '".prep_for_DB($this->validationMessage)."',
		'$this->hash',  $this->serverID, '$originalURL', '$originalKML',  $this->original_ID,
		'$this->originalUserID' , $this->userServerID,
		$this->excludeFrom,

		$this->airspaceCheck, $this->airspaceCheckFinal, '".prep_for_DB($this->airspaceCheckMsg)."','".prep_for_DB($this->checkedBy)."',
		$this->NACclubID, $this->NACid,
		'".prep_for_DB($this->comments)."', ".($this->commentsNum+0).", ".($this->commentsEnabled+0).", '".prep_for_DB($this->glider)."',  ".($this->gliderBrandID+0)." , '".prep_for_DB($this->linkURL)."', $this->timesViewed ,

		'$this->takeoffID', $this->takeoffVinicity, '$this->landingID', $this->landingVinicity,
		'$this->DATE',
		$this->timezone,
		$this->hasPhotos,
		$this->MAX_SPEED ,
		$this->MEAN_SPEED ,
		$this->MAX_ALT ,
		$this->MIN_ALT ,
		$this->TAKEOFF_ALT,
		$this->MAX_VARIO ,
		$this->MIN_VARIO ,
		$this->LINEAR_DISTANCE , ".
		($this->MAX_LINEAR_DISTANCE +0).",".
		"$this->START_TIME,
		$this->END_TIME,
		$this->DURATION, ".
		"'$this->BEST_FLIGHT_TYPE',
		".($this->FLIGHT_KM+0).",
		".($this->FLIGHT_POINTS+0).",".
		"$this->autoScore,
		$this->forceBounds,
		$this->externalFlightType,	$this->isLive,
		
		".($this->firstPointTM+0).", $this->firstLat, $this->firstLon,
		".($this->lastPointTM+0).", $this->lastLat, $this->lastLon

		)";

		//echo $query;
		$result = $db->sql_query($query);
		if (!$result) {
			echo "Problem in puting flight to DB $query<BR>";
		}
		//echo "UPDATE / INSERT RESULT ".$result ;
		if (!$update) $this->flightID=$db->sql_nextid();


		require_once dirname(__FILE__).'/CL_actionLogger.php';
		$log=new Logger();
		$log->userID  	=$this->userID;
		$log->ItemType	=1 ; // flight;
		$log->ItemID	= ( ( $this->serverID && $this->serverID!=$CONF_server_id ) ?$this->original_ID:$this->flightID ); // 0 at start will fill in later if successfull
		$log->ServerItemID	=  ( $this->serverID?$this->serverID:$CONF_server_id);
		$log->ActionID  = $update+1 ;  //1  => add  2  => edit;
		$log->ActionXML	= $this->toXML();
		$log->Modifier	= 0;
		$log->ModifierID= 0;
		$log->ServerModifierID =0;
		$log->Result = ($result?1:0);
		if (!$log->Result) $log->ResultDescription ="Problem in puting flight to DB $query";
		if (!$log->put()) echo "Problem in logger<BR>";

		return $result;
	}

	function makeLogEntry() {
		global $CONF_server_id ;
		require_once dirname(__FILE__).'/CL_actionLogger.php';
		$log=new Logger();
		$log->userID  	=$this->userID;
		$log->ItemType	=1 ; // flight;
		$log->ItemID	= ( ( $this->serverID && $this->serverID!=$CONF_server_id ) ?$this->original_ID:$this->flightID ); // 0 at start will fill in later if successfull
		$log->ServerItemID	= ( $this->serverID?$this->serverID:$CONF_server_id);
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
		// Disable this count!
		// $result = $db->sql_query($query);
		$this->timesViewed++;
	}

	function updateAll($forceRefresh=0) {
		// chack for saned igc in case it wasnt created in the first place or if the flight was synced
	 	if (  !is_file( $this->getIGCFilename(1) ) || $forceRefresh ) {
			if (! $this->getFlightFromIGC($this->getIGCFilename(0) ) ) {
				$this->getFlightFromDB($this->flightID,0);
				return;
			}
		}

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
			 $forceRefresh) {

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

	function findSameFilename($filename) {
		global $db;
		global $flightsTable;
		$query="SELECT ID FROM $flightsTable WHERE userID=".$this->userID." AND userServerID=".$this->userServerID.
						" AND filename=\"".$filename."\" ";
		// echo $query;
		$res= $db->sql_query($query);
		if ($res<=0) return 0; // no duplicate found

		$row = $db->sql_fetchrow($res);
		return $row["ID"]; // found duplicate retrun the ID;
	}

	function findSameTime() {
		global $db;
		global $flightsTable;
		$query="SELECT serverID,ID FROM $flightsTable WHERE userID=".$this->userID." AND userServerID=".$this->userServerID.
					" AND DATE='".$this->DATE."'  AND
						(
							( ".$this->START_TIME." >= START_TIME AND ".$this->START_TIME." <= END_TIME )
							OR
							( ".$this->END_TIME." >= START_TIME AND ".$this->END_TIME." <= END_TIME )
						)
							";
		$res= $db->sql_query($query);
		if ($res<=0) return array(); // no duplicate found

		$i=0;
		$dup=array();
		while  ( $row = $db->sql_fetchrow($res) ) {
			$dup[$i]['ID']=$row["ID"];
			$dup[$i]['serverID']=$row["serverID"];
			$i++;
		}
		return $dup; // found duplicate return the array of IDs;

	}

	function findSameHash($hash,$serverIDtoCheck=0 ) {
		global $db;
		global $flightsTable;

		$where_clause='';
		if ($serverIDtoCheck) $where_clause=" AND serverID=$serverIDtoCheck ";

		$query="SELECT serverID,ID,userID,userServerID FROM $flightsTable WHERE hash='$hash' $where_clause ";
		// echo $query;
		$res= $db->sql_query($query);
		if ($res<=0) return array(); // no duplicate found

		$i=0;
		$dup=array();
		while  ( $row = $db->sql_fetchrow($res) ) {
			$dup[$i]['ID']=$row["ID"];
			$dup[$i]['serverID']=$row["serverID"];
			$dup[$i]['userServerID']=$row["userServerID"];
			$dup[$i]['userID']=$row["userID"];
			$i++;
		}
		return $dup; // found duplicate return the array of IDs;

	}

	function hideSameFlights() {
		// now is a good time to disable duplicate flights we have found from other servers
		// AND are from the same user (using pilot's mapping table to find that out)

		// addition: 2008/07/21 we search for all flight no only from same user/server
		global $db,$flightsTable;

		$query="SELECT serverID,ID,externalFlightType, FROM $flightsTable
					WHERE hash='".$this->hash."' AND userID=".$this->userID." AND userServerID=".$this->userServerID.
					" ORDER BY serverID ASC, ID ASC";

		$query="SELECT serverID,ID,externalFlightType,userID,userServerID FROM $flightsTable
			WHERE hash='".$this->hash."' ORDER BY serverID ASC, ID ASC";

		// echo $query;
		$res= $db->sql_query($query);
		if ($res<=0) {
			DEBUG("FLIGHT",1,"flightData: Error in query: $query<br>");
			return array(); // no duplicate found
		}

		// we must disable all flights BUT one
		// rules:
		// 1. locally submitted flights have priority
		// 2. between external flights , the full synced have priority over simple links
		// 3. between equal cases the first submitted has priority.

		$i=0;
		while  ( $row = $db->sql_fetchrow($res) ) {
			$fList[$i]=$row;
			$i++;
		}

		if ($i==0) {
			return array(); // no duplicate found
		}

		usort($fList, "sameFlightsCmp");

		$i=0;
		$msg='';
		foreach($fList as $i=>$fEntry) {
			if (0) {
				echo "<pre>";
				echo "-------------------------<BR>";
				print_r($fEntry);
				echo "-------------------------<BR>";
				echo "</pre>";
			}

			if ($i==0)  {// enable
				$msg.= " Enabling ";
				$query="UPDATE $flightsTable SET private = private & (~0x02 & 0xff ) WHERE  ID=".$fEntry['ID'];
			} else  {// disable
				$msg.= " Disabling ";
				$query="UPDATE $flightsTable SET private = private | 0x02 WHERE  ID=".$fEntry['ID'];
			}
			$msg.= " <a href='http://".$_SERVER['SERVER_NAME'].
				getLeonardoLink(array('op'=>'show_flight','flightID'=>$fEntry['ID'])).
				"'>Flight ".$fEntry['ID'].
			"</a> from <a href='http://".$_SERVER['SERVER_NAME'].
				getLeonardoLink(array('op'=>'pilot_profile','pilotIDview'=>$fEntry['userServerID'].'_'.$fEntry['userID'])).
				"'>PILOT ".
			$fEntry['userServerID'].'_'.$fEntry['userID']."</a><BR>\n";

			$res= $db->sql_query($query);
			# Error checking
			if($res <= 0){
				echo("<H3> Error in query: $query</H3>\n");
			}

			$i++;
		}

		// now also make a test to see if all flights are from same user (alien mapped  to local)
		// if not , send a mail to admin to warn him and suggest a new mapping
		$pList=array();
		foreach($fList as $i=>$fEntry) {
			$pList[$fEntry['userServerID'].'_'.$fEntry['userID']]++;
		}

		if ( count($pList) > 1  ) { // more than one pilot involved in this
			sendMailToAdmin("Duplicate flights",$msg);
			//echo "Duplicate flights".$msg;
		}

		/*
		foreach ($disableFlightsList as $dFlightID=>$num) {
			$query="UPDATE $flightsTable SET private = private | 0x02 WHERE  ID=$dFlightID ";
			$res= $db->sql_query($query);
			# Error checking
			if($res <= 0){
				echo("<H3> Error in query: $query</H3>\n");
			}
		}
		foreach ($enableFlightsList as $dFlightID=>$num) {
			$query="UPDATE $flightsTable SET private = private & (~0x02 & 0xff ) WHERE  ID=$dFlightID ";
			$res= $db->sql_query($query);
			# Error checking
			if($res <= 0){
				echo("<H3> Error in query: $query</H3>\n");
			}
		}*/

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
		global $CONF,$CONF_photosPerFlight;

		$pilotDir=$this->getPilotAbsDir();

		if ($newUserServerID) $extra_prefix=$newUserServerID.'_';
		else $extra_prefix='';
		$newPilotDir=LEONARDO_ABS_PATH.'/'.str_replace("%PILOTID%",$extra_prefix.$newUserID,$CONF['paths']['pilot']);			
		

		// delete non critical files
		$this->deleteFile($this->getIGCFilename(1) );
		$this->deleteFile($this->getIGCFilename(2) );
		$this->deleteSecondaryFiles();
		$this->deleteFile($this->getMapFilename());
		for ($metric_system=1;$metric_system<=2;$metric_system++) {
			for ($raw=0;$raw<=1;$raw++) {
				# martin jursa 28.05.2008: delete using the deleteFile() method to avoid log flooding
				$this->deleteFile($this->getChartFilename("alt",$metric_system,$raw) );
				$this->deleteFile($this->getChartFilename("speed",$metric_system,$raw) );
				$this->deleteFile($this->getChartFilename("vario",$metric_system,$raw) );
				$this->deleteFile($this->getChartFilename("takeoff_distance",$metric_system,$raw) );
			}
		}
		
		
		$flightYear=$this->getYear();
		$subdirs=array('flights','charts','maps');
		
		// create all dirs on the target user as well in case they are missing
		$this->checkDirs($extra_prefix.$newUserID,$flightYear); 
		
		/*
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

		//	this is old code, does not work nay more!
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
		*/
		
		// Take care of photos!
		if ($this->hasPhotos) {		
			$flightPhotos=new flightPhotos($this->flightID);
			$flightPhotos->getFromDB();
			
			// print_r($flightPhotos->photos );
			
			foreach ( $flightPhotos->photos as $photoNum=>$photoInfo) {			 
				$flightPhotos->changeUser($photoNum,getPilotID($newUserServerID,$newUserID) );
			}
			$flightPhotos->putToDB(0);
		}
		
		
		// store the original paths of the files
		$igcOrg=$this->getIGCFilename(0);		
				
		// store away the original userID
		$this->originalUserID=($this->userServerID+0).'_'.$this->userID;

		$this->userID=$newUserID;
		$this->userServerID=$newUserServerID;
		
		// now move the igc file (and optionally the olc if it exists
		@rename($igcOrg,$this->getIGCFilename(0));
		@rename($igcOrg.".olc",$this->getIGCFilename(0).".olc");
		//  echo "will put to db $newUserServerID $newUserID<BR>";
		$this->putFlightToDB(1);

		// take care of same flights (hide /unhide)
		$this->hideSameFlights();

		// now also log this action

	}


 } // end of class
?>

<?

/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://sourceforge.net/projects/leonardoserver                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

class task {

  var $ID;
  var $compID, $compName, $compHasAds;
  var $gliderCat;

  var $max_lat, $max_lon, $min_lat, $min_lon;

  var $taskDate, $name, $timezone;
  var $ResultsType, $StartType, $TaskType, $PositionType;
  var $Distance, $description;
  var $TakeoffOpen;
  var $SSOpen, $SSClose, $ESClose;
  var $TopScore, $TopSpeed, $TopDistance;
  var $PilotsLaunched, $PilotsTotal, $PilotsGoal, $PilotsES, $PilotsLO;
  var $AllDistances, $AverageDistance, $MinimumDistance;
  var $NominalDistance, $NominalTime, $NominalGoal;
  var $DayQualityScore, $DayQualityLaunch, $DayQualityDistance, $DayQualityTime;
  var $TaskWeight, $DistanceWeight;
  var $AvailScoreDistance, $AvailScoreTime, $AvailScoreDeparture, $AvailScoreArrival, $AvailScoreTotal;
  var $WinnerPoints;

  var $active, $grace_end_time, $submit_time;

  function task($taskID) {
    $this->ID = $taskID;
  }

  function getTaskAbsPath() {
    global $flightsRelPath;
    return dirname(__FILE__)."/$flightsRelPath/".$this->ID;
  }
  function getTaskRelPath() {
    global $flightsRelPath;
    global $flightsWebPath;
    return "$flightsWebPath/".$this->ID;
    //	return "$flightsRelPath/".$this->ID;
  }

  function getURL() {
		return "http://".$_SERVER['SERVER_NAME'].REL_COMPS_PATH."index.php?op=list_flights&taskID".$this->ID;
  } 

  function getTaskMapFilename() {
    return $this->getTaskAbsPath()."/taskBaseMap.jpg";
  }

  function getTaskMapRelPath() {
    return $this->getTaskRelPath()."/taskBaseMap.jpg";
  }

  function getTaskTurnpointsMapFilename() {
    return $this->getTaskAbsPath()."/taskTurnpointsMap.gif";
  }

  function getTaskTurnpointsMapRelPath() {
    return $this->getTaskRelPath()."/taskTurnpointsMap.gif";
  }

  function getTaskThumbFilename() {
    return $this->getTaskAbsPath()."/taskThumb.jpg";
  }

  function getTaskThumbRelPath() {
    return $this->getTaskRelPath()."/taskThumb.jpg";
  }

  function getTaskThumb($force = 0) {
    if (!@ filesize($this->getTaskThumbFilename()) || $force) {
      $w = 400;
      $h = 400;

      list ($width, $height, $type, $attr) = getimagesize($this->getTaskMapFilename());

      $src1 = imagecreatefromjpeg($this->getTaskMapFilename());
      $src2 = imagecreatefromgif($this->getTaskTurnpointsMapFilename());

      $source_width = $width;
      $source_height = $height;

      $dest_width_max = $w;
      $dest_height_max = $h;

      // the two lines beginning with (int) are the super important magic formula part.
      (int) $dest_width = ($source_width <= $source_height) ? round(($source_width * $dest_height_max) / $source_height) : $dest_width_max;

      (int) $dest_height = ($source_width > $source_height) ? round(($source_height * $dest_width_max) / $source_width) : $dest_height_max;

      if ($dest_width > $source_width) {
        $dest_width = $source_width;
        $dest_height = $source_height;
      }

      $dest = imagecreatetruecolor($dest_width, $dest_height);

      imagecopyresampled($dest, $src1, 0, 0, 0, 0, $dest_width, $dest_height, $source_width, $source_height);

      imagecopyresampled($dest, $src2, 0, 0, 0, 0, $dest_width, $dest_height, $source_width, $source_height);

      $filename = $this->getTaskThumbFilename();

      imagejpeg($dest, $filename, 85);
      imagedestroy($dest);
    }
  }
  
  function createDummyMap() {
      require_once dirname(__FILE__)."/FN_map.php";

//      list ($width, $height, $type, $attr) = getimagesize();

      list ($UTMzone, $UTMlatZone, $UTMzone2, $UTMlatZone2, $MAP_TOP, $MAP_LEFT, $MAP_BOTTOM, $MAP_RIGHT) = 
	  		computeMapBox($this->max_lat, $this->min_lat, $this->max_lon, $this->min_lon);

//		$flMap=new flightMap($UTMzone,$UTMlatZone, $MAP_TOP + $marginVert, $MAP_LEFT - $marginHor,$UTMzone2, $UTMlatZone2, 
//					$MAP_BOTTOM - $marginVert ,$MAP_RIGHT +$marginHor  , 600,800,"","","",$this->ID,0,"jpg");

		  $flMap = new flightMap($UTMzone, $UTMlatZone, $MAP_TOP, $MAP_LEFT, $UTMzone2, $UTMlatZone2, $MAP_BOTTOM, $MAP_RIGHT,
								 600, 800, $this->getTaskMapFilename(), "", "", $this->ID, 0, "jpg");
		  $flMap->drawFlightMap(1, 1);
		  $flMap->outputMap("jpg", $this->getTaskMapFilename());
		  touch($this->getTaskMapFilename().".tmp");

  }
  
  function getTaskMap($force = 0) {
	$remakeThumb =0;
    $this->computeMapBoundaries();
    if (! @filesize($this->getTaskMapFilename()) || $force || file_exists($this->getTaskMapFilename().".tmp")  ) {
		@unlink($this->getTaskMapFilename());
		
		// check if p19 is up
		$fp = @fsockopen ("www.paraglidingforum.com", 80, $errno, $errstr, 5); 
		if ($fp)  {  // active
			fclose ($fp); 	
			
			$MapServerPath = "http://www.paraglidingforum.com/modules/leonardo/EXT_map.php";
			$MapServerPath .= "?op=get_map";
			// $MapServerPath.="&DBGlvl=255";
			$MapServerPath .= "&min_lat=".$this->min_lat."&max_lat=".$this->max_lat."&min_lon=".$this->min_lon."&max_lon=".$this->max_lon;
			set_time_limit(240);
			
			// echo $MapServerPath;
			
			$contents = @file_get_contents($MapServerPath);
			if ($contents ) {
				$handle = fopen($this->getTaskMapFilename(), "wb");
				fwrite($handle, $contents);
				fclose($handle);
				if (file_exists($this->getTaskMapFilename().".tmp")) {
				    @unlink($this->getTaskMapFilename().".tmp");
					$remakeThumb=1;
					$this->getTaskThumb(1);
				}
			} else {
				DEBUG("task",1,"Failed file_get_contents(), Will create dummy map<BR>");
				$this->createDummyMap();			
			}
			
		} else  {
			DEBUG("task",1,"Will create dummy map<BR>");
			$this->createDummyMap();		
		}

    }

    if (!@ filesize($this->getTaskMapFilename())) {
      die("Could not load the task map");
    }

    // now create the turnpoint layer
    if (!@ filesize($this->getTaskTurnpointsMapFilename()) || $force ) {
      require_once dirname(__FILE__)."/FN_map.php";

      list ($width, $height, $type, $attr) = getimagesize($this->getTaskMapFilename());

      list ($UTMzone, $UTMlatZone, $UTMzone2, $UTMlatZone2, $MAP_TOP, $MAP_LEFT, $MAP_BOTTOM, $MAP_RIGHT) = computeMapBox($this->max_lat, $this->min_lat, $this->max_lon, $this->min_lon);

      $flMap = new flightMap($UTMzone, $UTMlatZone, $MAP_TOP, $MAP_LEFT, $UTMzone2, $UTMlatZone2, $MAP_BOTTOM, $MAP_RIGHT, $width, $height, $this->getTaskMapFilename(), "", "", $this->ID, 0, "gif");

      $flMap->drawFlightMap(1, 0);
      $flMap->drawWaypoints();
      $flMap->outputMap("gif", $this->getTaskTurnpointsMapFilename());
    }
  }

  function getTaskWaypoints() {
    global $db, $live_waypointsTable;

    //error_reporting(E_ALL);

    $query = "SELECT * from $live_waypointsTable WHERE taskID=".$this->ID." ORDER BY ID";
	// echo  $query."<BR>";
    $res = $db->sql_query($query);

    if ($res <= 0) {
      return array ();
    }

    $waypoints = array ();
    $i = 0;

    while ($row = $db->sql_fetchrow($res) ) {
      $waypoints[$i] = new taskTurnpoint();
      $waypoints[$i]->waypointID = $row["ID"];
      $waypoints[$i]->type = $row["type"];
      $waypoints[$i]->name = $row["name"];
      $waypoints[$i]->intName = $row["intName"];
      $waypoints[$i]->lat = $row["lat"];
      $waypoints[$i]->lon = $row["lon"];
      $waypoints[$i]->wType = $row["wType"];
      $waypoints[$i]->radius = $row["radius"];
      $waypoints[$i]->distanceDiff = $row["distanceDiff"];
      $waypoints[$i]->distanceTotal = $row["distanceTotal"];
	  if ($row["wType"]=='TAKEOFF')  $waypoints[$i]->description = "TAKEOFF";
	  else if ($row["wType"]=='GOAL')  $waypoints[$i]->description = "GOAL";
	  else if ($row["wType"]=='START')  $waypoints[$i]->description = "START";
	  else if ($row["wType"]=='WAYPT')  $waypoints[$i]->description = "WAYPT";

      // $waypoints[$i]->description = $row["description"];
      // echo '<pre>';print_r($waypoints[$i]);echo '</pre>';
      $i ++;
    }

    mysql_freeResult($res);
    return $waypoints;
  }

  function computeMapBoundaries() {
    $waypoints = $this->getTaskWaypoints();
    $max_lat = -1000;
    $max_lon = -1000;
    $min_lat = 1000;
    $min_lon = 1000;
	if ( count($waypoints)==1 ) {	
		$lon = $waypoints[0]->lon;
		$lat = $waypoints[0]->lat;

		if (! $this->TopDistance) $this->getTaskFromDB();
		$radius=$this->TopDistance*1000; // in m	
		
		list($x1,$y1,$UTMzone,$UTMlatZone)=utm($lon, $lat); //$centerPoint->getUTM();
		$x2=$x1+$radius;
		$y2=$y1+$radius;
		$x3=$x1-$radius;
		$y3=$y1-$radius;

		list($lon2,$lat2)=iutm($x2, $y2, $UTMzone,$UTMlatZone) ;
		list($lon3,$lat3)=iutm($x3, $y3, $UTMzone,$UTMlatZone) ;
		$max_lon =max($lon2,$lon3);
		$max_lat =max($lat2,$lat3);
		$min_lon =min($lon2,$lon3);
		$min_lat =min($lat2,$lat3);

	} else {
		foreach ($waypoints as $waypoint) {
		  if ($waypoint->lon > $max_lon)
			$max_lon = $waypoint->lon;
		  if ($waypoint->lon < $min_lon)
			$min_lon = $waypoint->lon;
		  if ($waypoint->lat > $max_lat)
			$max_lat = $waypoint->lat;
		  if ($waypoint->lat < $min_lat)
			$min_lat = $waypoint->lat;
		}
	}
	
    $this->max_lat = $max_lat;
    $this->max_lon = $max_lon;
    $this->min_lat = $min_lat;
    $this->min_lon = $min_lon;
  }

  function getTaskKML() {
     $kml_file_contents ="<Folder>";
	 $kml_file_contents .= "<name>Task</name>
	  <open>0</open>\n";
	
		$kml_file_contents .= "<Placemark>
		<name>Task Line</name>
		<LineStyle>
			<color>ffff0000</color>
			<width>1.5</width>
		</LineStyle>
		<LineString>
            
      		 <tessellate>1</tessellate>
             <altitudeMode>relativeToGround</altitudeMode>

		
		<coordinates>
		";

	$taskWaypoints = $this->getTaskWaypoints();
	$normalWaypoints=0;
	for ($i = 0; $i < count($taskWaypoints); $i++) {
		$newPoint = $taskWaypoints[$i];
		$kml_file_contents .= - $newPoint->lon.",".$newPoint->lat.",500 ";
		
		if ($newPoint->wType=='WAYPT') {		
			$normalWaypoints++;
			$iconNum=$normalWaypoints;
			$name = "TP $normalWaypoints";
		} else {
			$iconNum=10;
			$name = $newPoint->description;
		}
		$turnpointPlacemark[$i] = $newPoint->makeKMLpoint($iconNum,$name);
		$turnpointRadius[$i] = $newPoint->makeKMLradius($i,1);
		$turnpointRadiusSolid[$i] = $newPoint->makeKMLradius($i,0);
	}
	
	$kml_file_contents .= "
    </coordinates>
    </LineString>
    </Placemark>
	\n";


    $kml_file_contents .= "<Folder>
		<name>Turnpoints</name>\n";
    	for ($i = 0; $i < count($taskWaypoints); $i++)
	      $kml_file_contents .= $turnpointPlacemark[$i];
    $kml_file_contents .= "</Folder>";

    $kml_file_contents .= "<Folder>
		<name>Turnpoints Radius wired</name>
		<visibility>1</visibility>\n";
	    for ($i = 0; $i <count($taskWaypoints); $i ++)
    	  $kml_file_contents .= $turnpointRadius[$i];
    $kml_file_contents .= "</Folder>\n";
	
    $kml_file_contents .= "<Folder>
		<name>Turnpoints Radius Filled</name>
		 <visibility>0</visibility>\n";

	    for ($i = 0; $i <count($taskWaypoints); $i ++)
    	  $kml_file_contents .= $turnpointRadiusSolid[$i];
    $kml_file_contents .= "</Folder>\n";

    $kml_file_contents .= "</Folder>\n";
	return $kml_file_contents ;
  }

  function getTaskFromDB() {
    global $db;
    global $flightsTable, $tasksTable, $compsTable;

    $query = "SELECT $tasksTable.*, $compsTable.name as compName, $compsTable.ads as compHasAds ,$compsTable.gliderType as gliderCat FROM $tasksTable, $compsTable WHERE $tasksTable.ID=".$this->ID." AND $tasksTable.compID=$compsTable.ID";

    $res = $db->sql_query($query);
    # Error checking
    if ($res <= 0) {
      echo ("<H3> Error in get task query! $query</H3>\n");
      exit ();
    }

    $row = $db->sql_fetchrow($res);

    $this->compID = $row['compID'];
    $this->compName = $row['compName'];
    $this->compHasAds = $row['compHasAds'];
    $this->gliderCat = $row['gliderCat'];

    $this->active			= $row['active'];
	$this->grace_end_time 	= $row['grace_end_time'];
	$this->submit_time		= $row['submit_time'];
	
    $this->name = $row['name'];
    $this->taskDate = $row['taskDate'];
    $this->timezone = $row['timezone'];
    $this->ResultsType = $row['ResultsType'];
    $this->StartType = $row['StartType'];
    $this->taskType = $row['TaskType'];
    $this->PositionType = $row['PositionType'];
    $this->Distance = $row['Distance'];
    $this->description = $row['description'];
    $this->TakeoffOpen = $row['TakeoffOpen'];
    $this->SSOpen = $row['SSOpen'];
    $this->SSClose = $row['SSClose'];
    $this->ESClose = $row['ESClose'];
    $this->TopScore = $row['AvailScoreTotal'];
    $this->TopSpeed = $row['TopSpeed'];
    $this->TopDistance = $row['TopDistance'];
    $this->PilotsLaunched = $row['PilotsLaunched'];
    $this->PilotsTotal = $row['PilotsTotal'];
    $this->PilotsGoal = $row['PilotsGoal'];
    $this->PilotsES = $row['PilotsES'];
    $this->PilotsLO = $row['PilotsLO'];
    $this->AllDistances = $row['AllDistances'];
    $this->AverageDistance = $row['AverageDistance'];
    $this->MinimumDistance = $row['MinimumDistance'];
    $this->NominalDistance = $row['NominalDistance'];
    $this->NominalTime = $row['NominalTime'];
    $this->NominalGoal = $row['NominalGoal'];
    $this->DayQualityScore = $row['DayQualityScore'];
    $this->DayQualityLaunch = $row['DayQualityLaunch'];
    $this->DayQualityDistance = $row['DayQualityDistance'];
    $this->DayQualityTime = $row['DayQualityTime'];
    $this->TaskWeight = $row['TaskWeight'];
    $this->DistanceWeight = $row['DistanceWeight'];
    $this->AvailScoreDistance = $row['AvailScoreDistance'];
    $this->AvailScoreTime = $row['AvailScoreTime'];
    $this->AvailScoreDeparture = $row['AvailScoreDeparture'];
    $this->AvailScoreArrival = $row['AvailScoreArrival'];
    $this->AvailScoreTotal = $row['AvailScoreTotal'];
    $this->WinnerPoints = $row['WinnerPoints'];

  }

  function getTaskFlightsFromDB() {
    global $db;
    global $flightsTable;

    $query = "SELECT ID,pilotID,place,status,lastName,firstName,active FROM $flightsTable WHERE taskID=".$this->ID." ORDER BY place ASC";
    $res = $db->sql_query($query);
    # Error checking
    if ($res <= 0) {
      echo ("<H3> Error in get task flights query! $query</H3>\n");
      exit ();
    }

    while ($row = $db->sql_fetchrow($res) ) {
      $taskFlights[$row['pilotID']]['flightID'] = $row['ID'];
      $taskFlights[$row['pilotID']]['active'] =  $row['active'];
      $taskFlights[$row['pilotID']]['place'] = $row['place'];
      $taskFlights[$row['pilotID']]['status'] = $row['status'];
      $taskFlights[$row['pilotID']]['pilotName'] = $row['firstName']." ".$row['lastName'];
//      $taskFlightsActive[$row['pilotID']]['pilotID'] = $row['active'];
//      $taskFlightsPilotName[$row['pilotID']] = $row['active'];
//      $taskFlightsPlace[$row['pilotID']] = $row['place'];
    }
    return $taskFlights;
  }

  function get_mem() {
    return sprintf("%d", ((memory_get_usage() / 1024) / 1024));
  }

  /* returns:
   * - $result if processing was ok or not
   * - $taskFlights or $error if $isok is false
   */
  function processTaskXML($xmlFilename, $mgaFilename) {
    global $db, $tasksTable, $waypointsTable, $flightsTable;
    
    $taskAdded = false;
    $wayptsAdded = false;
    $flightsAdded = false;

    //echo "<<<1".$this->get_mem().">>><br/>";flush();

    $contents = implode("\n", file($xmlFilename));
    if (!$contents) {
      return array (false, "Could not read XML task description: $xmlFilename");
    }

    DEBUG("TASK_ADD", 2, "got xml<hr>");
    require_once dirname(__FILE__).'/miniXML/minixml.inc.php';
    $xmlDoc = new MiniXMLDoc();

    DEBUG("TASK_ADD", 2, "created parser<hr>");
    $xmlDoc->fromString($contents);

    DEBUG("TASK_ADD", 2, "read xml<hr>");
    $xmlArray = $xmlDoc->toArray();

    DEBUG("TASK ADD", 2, "reading MGA file...<br/>");
    require_once dirname(__FILE__)."/libraries/MGAParser.class.php";

    $mgaParser = new MGAParser($mgaFilename);
    list ($res, $error) = $mgaParser->parse();

    if (!$res) {
      DEBUG("TASK ADD", 2, "Error in MGA parser: $error<br/>");
      return array (false, $error);
    }

    $taskInfo = $xmlArray['task']['info']['_attributes'];

    $pilotsInfo = $xmlArray['task']['summary']['pilots']['_attributes'];
    $topsInfo = $xmlArray['task']['summary']['tops']['_attributes'];
    $formulaInfo = $xmlArray['task']['summary']['formula']['_attributes'];
    $dayQualityInfo = $xmlArray['task']['summary']['dayQuality']['_attributes'];
    $scoringInfo = $xmlArray['task']['summary']['scoring']['_attributes'];

    $taskDate = $taskInfo['date'];
  
    DEBUG("TASK ADD", 2, "XML date: ".$taskDate.", MGA date: ".$mgaParser->date."<br/>");

    $mgaDate = date('Y-m-d', strtotime($mgaParser->date));

    if ($taskDate != $mgaDate) {
      return array (false, "The date in the RACE xml file ($taskDate) differs from the date found in the"."CompeGPS task file (".$mgaDate."). Check the XML result file is for the same task.");
    }

    if (Tasks::tasksExists($this->compID, $taskDate) && $this->ID == 0 ) {
      return array (false, _MSG_Task_already_exists_MSG_);
    }

    $startTime = time2Sec($taskInfo['SSOpen']);
    $endTime   = time2Sec($taskInfo['ESClose']);

    DEBUG("TASK_ADD", 2, "ES Endtime : $endTime -> ".$taskInfo['ESClose']."<br>");
    DEBUG("TASK_ADD", 2, "Will insert new task date : $taskDate <BR>");

    $this->name = $taskInfo['name'];
    $this->taskDate = $taskInfo['date'];
    $this->timezone = $mgaParser->gmt;
    $this->ResultsType = $taskInfo['ResultsType'];
    $this->StartType = $taskInfo['StartType'];
    $this->taskType = $taskInfo['TaskType'];
    $this->PositionType = $taskInfo['PositionType'];
    $this->Distance = $taskInfo['Distance'];
    $this->description = $taskInfo['description'];
    $this->TakeoffOpen = $mgaParser->TakeoffOpen;
    $this->SSOpen = $taskInfo['SSOpen'];
    $this->SSClose = $taskInfo['SSClose'];
    $this->ESClose = $taskInfo['ESClose'];
    $this->TopScore = $scoringInfo['availableScoreTotal'];
    $this->TopSpeed = $topsInfo['topSpeed'];
    $this->TopDistance = $topsInfo['topDistance'];
    $this->PilotsLaunched = $pilotsInfo['launched'];
    $this->PilotsTotal = $pilotsInfo['total'];
    $this->PilotsGoal = $pilotsInfo['goal'];
    $this->PilotsES = $pilotsInfo['es'];
    $this->PilotsLO = $pilotsInfo['lo'];
    $this->AllDistances = $topsInfo['sumAllDistances'];
    $this->AverageDistance = $topsInfo['averageDistance'];
    $this->MinimumDistance = $formulaInfo['minimumDistance'];
    $this->NominalDistance = $formulaInfo['nominalDistance'];
    $this->NominalTime = $formulaInfo['nominalTime'];
    $this->NominalGoal = $formulaInfo['nominalGoal'];
    $this->DayQualityScore = $dayQualityInfo['cDayQuality'];
    $this->DayQualityLaunch = $dayQualityInfo['cLaunch'];
    $this->DayQualityDistance = $dayQualityInfo['cDistance'];
    $this->DayQualityTime = $dayQualityInfo['cDayQuality'];
    $this->TaskWeight = $scoringInfo['taskWeight'];
    $this->DistanceWeight = $scoringInfo['cDistanceWeight'];
    $this->AvailScoreDistance = $scoringInfo['availableScoreForDistance'];
    $this->AvailScoreTime = $scoringInfo['availableScoreForTime'];
    $this->AvailScoreDeparture = $scoringInfo['availableScoreForDeparture'];
    $this->AvailScoreArrival = $scoringInfo['availableScoreForArrival'];
    $this->AvailScoreTotal = $scoringInfo['availableScoreTotal'];
    $this->WinnerPoints = $scoringInfo['winnerPoints'];

    if ($this->ID == 0) {
      list ($result, $error) = $this->store();
    }
    else {
      list ($result, $error) = $this->update();
    }
    
    if (!$result) {
      task::rollback();
      return array(false, $error);
    }

    if ($this->ID == 0) {
      $taskID = $db->sql_nextid();
      $this->ID = $taskID;
      echo "New task created with ID: $taskID<BR>";
      
      $query = "select ID from $tasksTable where ID=$taskID";
  	  $actionTaken="add";
    }
    else {
      $taskID = $this->ID;
      echo "Updated task Info for task ID: $taskID<BR>";
	  $actionTaken="edit";
    }
    
    $taskAdded = true;

    //first delete all wypoints of this task (if present)
    $query = "DELETE FROM $waypointsTable WHERE taskID=$taskID";
    $res = $db->sql_query($query);
    
    if ($res <= 0) {
      // this is not a fatal error
      echo ("<H3> Error in deleting waypoints for task </H3>\n");
      $dberr = $db->sql_error();
      //return array(false, "Error in deleting waypoints for task: ".$dberr['message']);
    }

    $taskTP = $xmlArray['task']['turnpoints']['turnpoint'];
    $waypointNum = 0;
    $i = 0;
   
    foreach ($taskTP as $tp) {
		if ( isset($tp['_attributes']) ) $attrs = $tp['_attributes'];
		else $attrs = $tp;

      if ($attrs['tp']) {
        $mgatp = $mgaParser->waypoints[$i ++];
        
        DEBUG("TASK_ADD", 2, $attrs['tp']."#".$attrs['id']."#".$attrs['name']."#lat=".$attrs['lat']."#lon=".$attrs['lon'].
"#mgalat=".$mgatp->lat."#mgalon=".$mgatp->lon."<BR>");

        $attrs['lat'] = str_replace(",", ".", $attrs['lat']);
        $attrs['lon'] = str_replace(",", ".", $attrs['lon']);
        
		if (strtolower($attrs['posLat'])=="s") $attrs['lat']=-$attrs['lat'];
		if (strtolower($attrs['posLon'])=="w") $attrs['lon']=-$attrs['lon'];

		$thisLat=$attrs['lat'];
		$thisLon=$attrs['lon'];
		if (!$thisLat) $thisLat=$mgatp->lat;
		if (!$thisLon) $thisLon=-$mgatp->lon;

        $query = "INSERT INTO $waypointsTable (name,intName,lat,lon,type,taskID,description,"."wType,radius,distanceDiff,distanceTotal) 
        						VALUES ('".$attrs['tp']."','".$attrs['tp']."','".$thisLat."','".- $thisLon."','2000','".$taskID."','".$attrs['id']."','".$mgatp->turnpointType."','".$mgatp->radius."','".$attrs['distanceDiff']."','".$attrs['distanceTotal']."')";
        // echo "<pre>".$query."</pre>";
        
        $res = $db->sql_query($query);

        if ($res <= 0) {
          //echo ("<H3> Error in inserting waypoint query! $query</H3>\n");
          task::rollback();
          $dberr = $db->sql_error();
          return array(false, "Could not add waypoints for task: ".$dberr['message']);
        }
        else {
          DEBUG("TASK_ADD", 2, "Waypoint added<BR>");
          $waypointNum ++;
        }
      }
    }
    
    $wayptsAdded = true;

    echo "<HR>";
    echo "Added turnpoints<BR>";
    echo "<HR>";

	if ($actionTaken=="add") {
		//first delete all flights of this task (if present)
		$query = "DELETE FROM $flightsTable WHERE taskID=$taskID";
		$res = $db->sql_query($query);
	
		if ($res <= 0) { // not a fatal error
		  echo ("<H3> Error in deleting flights for task </H3>\n");
		  $dberr = $db->sql_error();
		  //return array(false, "Could not delete previous flights for task: ".$dberr['message']);
		}
	}
	
    $flightNum = 0;

    foreach ($xmlArray['task']['results']['result'] as $rs) {
      $attrs = $rs['_attributes'];

      if ($attrs['status']) {
        $field_str = "";
        $val_str = "";
        $attrs['distance'] = 1000 * str_replace(",", ".", $attrs['distance']);
        $attrs['speed'] = str_replace(",", ".", $attrs['speed']);
        $attrs['distanceScore'] = str_replace(",", ".", $attrs['distanceScore']);
        $attrs['departureScore'] = str_replace(",", ".", $attrs['departureScore']);
        $attrs['speedScore'] = str_replace(",", ".", $attrs['speedScore']);
        $attrs['arrivalScore'] = str_replace(",", ".", $attrs['arrivalScore']);
        $attrs['score'] = str_replace(",", ".", $attrs['score']);

		if ($actionTaken=="add") {

	        $field_str = "pilotID,taskID,firstName,lastName,sex,type,"."sponsor,glider,manufacturer,nation,status,turnpoints,".		
						 "SSTime,ESTime,time,speed,distance,realDistance,reachedES,".
						 "arrivalScore,departureScore,speedScore,distanceScore,score,"."placeES,place";

	        $val_str = "'".$attrs['pilotID']."','".$taskID."','".addslashes($attrs['firstName'])."','".
					addslashes($attrs['lastName'])."','".$attrs['sex']."','".$attrs['type']."','".
					addslashes($attrs['sponsor'])."','".addslashes($attrs['glider'])."','".addslashes($attrs['manufacturer'])."','".
					addslashes($attrs['nation'])."','".$attrs['status']."','".$attrs['turnpointsReached']."','".
					$attrs['SStime']."','".$attrs['EStime']."','".$attrs['time']."','".$attrs['speed']."','".
					$attrs['distance']."','".$attrs['distanceReal']."','".$attrs['reachedES']."','".$attrs['arrivalScore']."','".
					$attrs['departureScore']."','".$attrs['speedScore']."','".$attrs['distanceScore']."','".$attrs['score']."','".
					$attrs['placeES']."','".$attrs['place']."'";

	        $query = "INSERT INTO $flightsTable ($field_str ,gpsTrack) VALUES ($val_str ,0)";
		} else {
	        $query = "UPDATE $flightsTable SET 
firstName='".addslashes($attrs['firstName'])."',
lastName='".addslashes($attrs['lastName'])."',
sex='".$attrs['sex']."',
type='".$attrs['type']."',
sponsor='".addslashes($attrs['sponsor'])."',
glider='".addslashes($attrs['glider'])."',
manufacturer='".addslashes($attrs['manufacturer'])."',
nation='".addslashes($attrs['nation'])."',
status='".$attrs['status']."',
turnpoints='".$attrs['turnpointsReached']."',
SSTime='".$attrs['SStime']."',
ESTime='".$attrs['EStime']."',
time='".$attrs['time']."',
speed='".$attrs['speed']."',
distance='".$attrs['distance']."',
realDistance='".$attrs['distanceReal']."',
reachedES='".$attrs['reachedES']."',
arrivalScore='".$attrs['arrivalScore']."',
departureScore='".$attrs['departureScore']."',
speedScore='".$attrs['speedScore']."',
distanceScore='".$attrs['distanceScore']."',
score='".$attrs['score']."',
placeES='".$attrs['placeES']."',
place='".$attrs['place']."'

WHERE pilotID=".$attrs['pilotID']." AND taskID=".$taskID."	";
		}
        //echo $query;
        $res = $db->sql_query($query);

        if ($res <= 0) {
          echo ("<H3> Error in inserting flight query! $query</H3>\n");
          task::rollback();
          $dberr = $db->sql_error();
          return array(false, "Could not insert flight: ".$dberr['message']);
        }
        else {
          $flightID =  $db->sql_nextid();
          DEBUG("TASK_ADD", 2, "Flight added [$flightID] place: ".$attrs['place']."#".$attrs['firstName']." ".$attrs['lastName']." [pilotId: ".$attrs['pilotID']."]#<BR>");
          $taskFlights[$attrs['pilotID']] = $flightID;
          $flightNum ++;
        }
      }
    }
    
    $flightsAdded = true;

    echo "Imported $flightNum flights<br>";
    echo "Task Date: $taskDate<BR><hr>";

    return array (true, $taskFlights);
  }

  function update()
  {
	global $db,$tasksTable ;

    $query = "UPDATE $tasksTable SET ".
      "name='".$this->name."',".
      "compID='".$this->compID."',".
      "taskDate='".$this->taskDate."',".
      "timezone='".$this->timezone."',".
      "ResultsType='".$this->ResultsType."',".
      "StartType='".$this->StartType."',".
      "taskType='".$this->taskType."',".
      "PositionType='".$this->PositionType."',".
      "Distance='".$this->Distance."',".
      "description='".$this->description."',".
      "TakeoffOpen='".$this->TakeoffOpen."',".
      "SSOpen='".$this->SSOpen."',".
      "SSClose='".$this->SSClose."',".
      "ESClose='".$this->ESClose."',".
      "TopScore='".$this->TopScore."',".
      "TopSpeed='".$this->TopSpeed."',".
      "TopDistance='".$this->TopDistance."',".
      "PilotsLaunched='".$this->PilotsLaunched."',".
      "PilotsTotal='".$this->PilotsTotal."',".
      "PilotsGoal='".$this->PilotsGoal."',".
      "PilotsES='".$this->PilotsES."',".
      "PilotsLO='".$this->PilotsLO."',".
      "AllDistances='".$this->AllDistances."',".
      "AverageDistance='".$this->AverageDistance."',".
      "MinimumDistance='".$this->MinimumDistance."',".
      "NominalDistance='".$this->NominalDistance."',".
      "NominalTime='".$this->NominalTime."',".
      "NominalGoal='".$this->NominalGoal."',".
      "DayQualityScore='".$this->DayQualityScore."',".
      "DayQualityLaunch='".$this->DayQualityLaunch."',".
      "DayQualityDistance='".$this->DayQualityDistance."',".
      "DayQualityTime='".$this->DayQualityTime."',".
      "TaskWeight='".$this->TaskWeight."',".
      "DistanceWeight='".$this->DistanceWeight."',".
      "AvailScoreDistance='".$this->AvailScoreDistance."',".
      "AvailScoreTime='".$this->AvailScoreTime."',".
      "AvailScoreDeparture='".$this->AvailScoreDeparture."',".
      "AvailScoreArrival='".$this->AvailScoreArrival."',".
      "AvailScoreTotal='".$this->AvailScoreTotal."',".
      "WinnerPoints='".$this->WinnerPoints."' ".
      "WHERE ID=".$this->ID;

    $result = $db->sql_query($query);
    
    if ($result <= 0) {
      task::rollback();
      $dberr = $db->sql_error();
      return array(false, "Could not update task, got database error: ".$dberr['message']);
    }
	return array(true,"");

  }

  function store()
  {
	global $db,$tasksTable;

    $query = "INSERT INTO $tasksTable (compID,taskDate,name,timezone,".
      "ResultsType,StartType,TaskType,PositionType,Distance,description,".
      "TakeoffOpen,SSOpen,SSClose,ESClose,TopScore,TopSpeed,TopDistance,".
      "PilotsLaunched,PilotsTotal,PilotsGoal,PilotsES,PilotsLO,".
      "AllDistances,AverageDistance,MinimumDistance,NominalDistance,NominalTime,NominalGoal,".
      "DayQualityScore,DayQualityLaunch,DayQualityDistance,DayQualityTime,".
      "TaskWeight,DistanceWeight,AvailScoreDistance,AvailScoreTime,AvailScoreDeparture,".
      "AvailScoreArrival,AvailScoreTotal,WinnerPoints) values('".
      $this->compID."','".
      $this->taskDate."','".
      $this->name."','".
      $this->timezone."','".
      $this->ResultsType."','".
      $this->StartType."','".
      $this->TaskType."','".
      $this->PositionType."','".
      $this->Distance."','".
      $this->description."','".
      $this->TakeoffOpen."','".
      $this->SSOpen."','".
      $this->SSClose."','".
      $this->ESClose."','".
      $this->TopScore."','".
      $this->TopSpeed."','".
      $this->TopDistance."','".
      $this->PilotsLaunched."','".
      $this->PilotsTotal."','".
      $this->PilotsGoal."','".
      $this->PilotsES."','".
      $this->PilotsLO."','".
      $this->AllDistances."','".
      $this->AverageDistance."','".
      $this->MinimumDistance."','".
      $this->NominalDistance."','".
      $this->NominalTime."','".
      $this->NominalGoal."','".
      $this->DayQualityScore."','".
      $this->DayQualityLaunch."','".
      $this->DayQualityDistance."','".
      $this->DayQualityTime."','".
      $this->TaskWeight."','".
      $this->DistanceWeight."','".
      $this->AvailScoreDistance."','".
      $this->AvailScoreTime."','".
      $this->AvailScoreDeparture."','".
      $this->AvailScoreArrival."','".
      $this->AvailScoreTotal."','".
      $this->WinnerPoints."')";

    $result = $db->sql_query($query);
    
    if ($result <= 0) {
      task::rollback();
      $dberr = $db->sql_error();
      return array(false, "Could not store task, got database error: ".$dberr['message']);
    }
	return array(true,"");
  }

  function rollback() {
    global $taskAdded, $wayptsAdded, $flightsAdded, $taskID, $db;
    global $waypointsTable, $tasksTable;
    
    // assert taskID != null : "Invalid task ID"
    if ($taskID < 0) {
      return false;
    }
    
    // from bottom to top...
    if ($wayptsAdded) {
      $query = "DELETE FROM $waypointsTable WHERE taskID=$taskID";
      
      $res = $db->sql_query($query); // ignore if there was an error
    }
    
    if ($taskAdded) {
      $query = "DELETE FROM $tasksTable WHERE taskID=$taskID";
      
      $res = $db->sql_query($query); // ignore if there was an error
    }
  }

	function taskDelete() {
		global $db,$tasksTable,$waypointsTable,$flightsTable;
		global $userSpaceID;

		$taskID=$this->ID;
		delDir($this->getTaskAbsPath());
	
		$query="DELETE FROM $tasksTable WHERE ID=$taskID";
		$res = $db->sql_query($query);
		if($res <= 0){  echo("<H3> Error in deleting task $taskID $query</H3>\n"); }
	
		$query="DELETE FROM $waypointsTable WHERE taskID=$taskID";
		$res= $db->sql_query($query);
		if($res <= 0){  echo("<H3> Error in deleting task $taskID waypoints $query</H3>\n"); }
	
		$query="DELETE FROM $flightsTable WHERE taskID=$taskID";
		$res= $db->sql_query($query);
		if($res <= 0){  echo("<H3> Error in deleting task $taskID flights $query</H3>\n"); }

		Logger::put($userSpaceID,$this->compID,$this->ID,0,0,Logger::actionByID("Delete Task"),0,"",1);
	}

	function computeTaskPrice(){
		if ($this->PilotsLaunched<=20) $price=20;
		else  if ($this->PilotsLaunched<=100) $price=30;
		else $price=40;

		// see if it is "sponsor ads"		
		if ($this->compHasAds) $price=$price*1.5;
		return $price;
	}
	
	function activate() {
		global $db,$userSpaceID,$tasksTable ;
		$taskID=$this->ID;
		
		$this->active=1;
		$this->grace_end_time=0;

		if (!$this->submit_time) { // first time submit
			$q_add=",submit_time=".time();
		} else $q_add="";
		
		$query="UPDATE $tasksTable SET active=1,grace_end_time=0 $q_add WHERE ID=$taskID";
		$res = $db->sql_query($query);
		if($res <= 0) {  
			echo("<H3> Error in activating task ".$this->ID." $query</H3>\n"); 
			return 0;
		}	

		Logger::put($userSpaceID,0,$this->ID,0,0,Logger::actionByID("Credits"),0,"Activated task ".$this->ID,1);
		return 1;	
	}

	function deactivate() {	
		global $db,$userSpaceID,$tasksTable ;
		$taskID=$this->ID;
		if ($this->active==0) return;
		
		$this->active=0;
		$query="UPDATE $tasksTable SET active=0 WHERE ID=$taskID";
		$res = $db->sql_query($query);
		if($res <= 0) {  
			echo("<H3> Error in deactivating task $taskID $query</H3>\n"); 
			return 0;
		}	

		Logger::put($userSpaceID,0,$this->ID,0,0,Logger::actionByID("Credits"),0,"Deactivated task: ".$this->ID." Grace ended on: ".
		Logger::formatTime($this->grace_end_time),1);
		return 1;
	}
	
	function checkStatus() {
		if ( $this->grace_end_time ) { // we are still on grace period
			if ( time() > $this->grace_end_time  ) { // we got over !
				$this->deactivate();
			}
		}	
		return $this->active;
	}
	
	function give_grace() {
		global $db,$tasksTable;
		global $userSpaceID;
		$taskID=$this->ID;

		$this->grace_end_time=time()+60*60*24*2; // 2 days
		$this->active=1;
		if (!$this->submit_time) $this->submit_time=time();
	
		$query="UPDATE $tasksTable SET active=1, submit_time=".$this->submit_time.",grace_end_time=".$this->grace_end_time." WHERE ID=$taskID";
		$res = $db->sql_query($query);
		if($res <= 0) {  
			echo("<H3> Error in giving grace time for $taskID $query</H3>\n"); 
			return 0;
		}	
		Logger::put($userSpaceID,0,$taskID,0,0,Logger::actionByID("Credits"),0,"Task $taskID : Grace till ".Logger::formatTime($this->grace_end_time),1);
		return 1;
	}
	
} // end of class

class Tasks {
  function tasksExists($compID, $taskDate) {
    global $tasksTable, $db;

		$query="SELECT ID FROM $tasksTable WHERE compID=$compID AND taskDate='$taskDate'";
		$res = $db->sql_query($query);

		if($res <= 0){
      return false;
    }

    $result = $db->sql_numrows() > 0;
    
    return $result;
  }
}

class taskTurnpoint extends waypoint {
    var $icons = array (
		1 => array ("root://icons/palette-3.png", 0, 192), 
		2 => array ("root://icons/palette-3.png", 32, 192),
		3 => array ("root://icons/palette-3.png", 64, 192),
		4 => array ("root://icons/palette-3.png", 96, 192), 
		5 => array ("root://icons/palette-3.png", 128, 192),

		10 => array ("http://maps.google.com/mapfiles/kml/pal2/icon5.png", 0, 0),
		11 => array ("root://icons/palette-3.png", 128, 192),
		12 => array ("root://icons/palette-3.png", 128, 192),
	);

	function taskTurnpoint() {
	
	}

	function makeKMLradius($num,$outlineOnly=1) {
		require_once dirname(__FILE__)."/CL_gpsPoint.php";
		require_once dirname(__FILE__)."/FN_UTM.php";

		$forceVisible=1;

		$radius=$this->radius; // in m	
		$lon=-$this->lon;
		$lat=$this->lat;
		
		list($x1,$y1,$UTMzone,$UTMlatZone)=utm($lon, $lat); //$centerPoint->getUTM();
		$x2=$x1+$radius;
		$y2=$y1+$radius;

		$x2Inner=$x1+$radius-20;
		$y2Inner=$y1+$radius-20;

		// find the  diffs for lat/lon
		list($lon2,$lat2)=iutm($x2, $y2, $UTMzone,$UTMlatZone) ;
		list($lon2Inner,$lat2Inner)=iutm($x2Inner, $y2Inner, $UTMzone,$UTMlatZone) ;

		$dlon=abs($lon2-$lon);
		$dlat=abs($lat2-$lat);

		$dlonInner=abs($lon2Inner-$lon);
		$dlatInner=abs($lat2Inner-$lat);
		if ($radius<=1000 || !$outlineOnly)
			$NUM_LINES=40; // number of circle points
		else if ($radius<=10000) $NUM_LINES=80; 
		else $NUM_LINES=120; 

$dbg="$x1,$y1#$UTMzone,$UTMlatZone#$lon,$lat#$lon2,$lat2";

		$response .= '<Placemark>
  <name>'.$num.'</name>\n';
if (!$outlineOnly && !$forceVisible) $response .=  '<visibility>0</visibility>\n';

$response .=' <Style>
    <IconStyle>
      <color>ff0000ff</color>
    </IconStyle>
	<LineStyle>
	      <color>82e76259</color>
    </LineStyle>
    <PolyStyle>
	        <color>50ff3752</color>
			<fill>'.($outlineOnly?0:1).'</fill>
			<outline>'.($outlineOnly?1:0).'</outline>
    </PolyStyle>
  </Style>

  <Polygon>
      <extrude>1</extrude>
      <tessellate>1</tessellate>
      <altitudeMode>relativeToGround</altitudeMode>
    <outerBoundaryIs>
      <LinearRing >
        <coordinates>';
	for($i=0;$i<=$NUM_LINES;$i++){
		$xcoord = $dlon * cos($i*2*M_PI/$NUM_LINES);
		$ycoord = $dlat * sin($i*2*M_PI/$NUM_LINES);	
		$response .= ($lon+$xcoord).",".($lat+$ycoord).",1500 ";
	}
		$response .= '
        </coordinates>
      </LinearRing>
    </outerBoundaryIs>
';
if (!$outlineOnly ) {
	$response .= 
	'<innerBoundaryIs>
		  <LinearRing >
			<coordinates>';
		for($i=0;$i<=$NUM_LINES;$i++){
			$xcoord = $dlonInner * cos($i*2*M_PI/$NUM_LINES);
			$ycoord = $dlatInner * sin($i*2*M_PI/$NUM_LINES);	
			$response .= ($lon+$xcoord).",".($lat+$ycoord).",1500 ";
		}
			$response .= '
			</coordinates>
		  </LinearRing>
		</innerBoundaryIs>';
}
$response .='  </Polygon>';

$response .= '</Placemark>';
		return $response;
		
	}

	function makeKMLpoint($num,$name) {
      $res = "
      <Placemark>
      		 <name>".$name."</name>
      		 <Style>
      		  <IconStyle>
      			<scale>0.4</scale>
      			<Icon>
      			  <href>".$this->icons[$num ][0]."</href>";
if ($num<10) {
$res.=" 
      			  <x>".$this->icons[$num ][1]."</x>
      			  <y>".$this->icons[$num ][2]."</y>
      			  <w>32</w>
      			  <h>32</h>
";
}
$res.="
      			</Icon>
      		  </IconStyle>
			 
      		</Style>
       <Point>
			 <extrude>1</extrude>
		      <tessellate>1</tessellate>
		      <altitudeMode>relativeToGround</altitudeMode>
          <coordinates>". (- $this->lon).",".$this->lat.",500</coordinates>
        </Point>
      </Placemark>";
	  return $res;
	
	}

}

?>
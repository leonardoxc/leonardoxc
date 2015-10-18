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
// $Id: EXT_flight.php,v 1.29 2012/10/17 09:45:24 manolis Exp $                                                                 
//
//************************************************************************

 	require_once dirname(__FILE__)."/EXT_config_pre.php";
	require_once "config.php";
 	require_once "EXT_config.php";

	require_once "CL_flightData.php";
	require_once "FN_functions.php";	
	require_once "FN_UTM.php";
	require_once "FN_waypoint.php";	
	require_once "FN_output.php";
	require_once "FN_pilot.php";
	require_once "FN_flight.php";
	setDEBUGfromGET();

	$op=makeSane($_REQUEST['op']);
	if (!$op) $op="list_flights";	

	if (!in_array($op,array("flight_info","list_flights","submit_flight","list_flights_json",
	"list_takeoffs_json","list_pilots_json","get_info","polylineURL","get_task_json")) ) return;


	if ($op=="polylineURL") {
		$flightID=$_REQUEST['flightID']+0;
		if ($flightID<=0) exit;	
		$flight=new flight();
		$flight->getFlightFromDB($flightID,0);
	
		$polylineURL=$flight->getPolylineRelPath();
		echo $polylineURL;	

	} else if ($op=="list_takeoffs_json") {
		require_once dirname(__FILE__).'/CL_flightData.php';
		require_once dirname(__FILE__).'/lib/json/CL_json.php';
		
		$JSON_str= ' [ ';
		$wpName=makeSane($_GET['term'],2);
						
		$query="SELECT ID,lat ,lon ,type,intName , countryCode from $waypointsTable WHERE type=1000 AND intName LIKE '$wpName%' ";
		$res= $db->sql_query($query);
		if($res > 0){	
			$i=0;		
			while ($row = mysql_fetch_assoc($res)) {
				$label=json::prepStr($row['intName']).' - '.json::prepStr($row['countryCode']);
				$wpID=$row['ID'];
				if ($i>0) $JSON_str.=",\n";
				$JSON_str.= '{ "value": '.$wpID.' , "label": "'.$label.'" } ';				
				$i++;	
			} 			
		} else {
			$JSON_str="";
		}
				
		$JSON_str.= ' ] ';
		
		sendJson($JSON_str);
	} else if ($op=="list_pilots_json") {
		require_once dirname(__FILE__).'/lib/json/CL_json.php';
		
	
		$pilotName0=makeSane($_GET['term'],2);
		$pilotName0=trim($pilotName0);	
		$pilotName=str_replace(" ", "%",$pilotName0);
		
		$query="SELECT * FROM $pilotsTable WHERE 
			serverID=0 AND 
			(	FirstName LIKE '%$pilotName%' OR 
				LastName LIKE '%$pilotName%' OR 
				CONCAT(FirstName,' ',LastName) LIKE  '%$pilotName%'  OR 
				CONCAT(LastName,' ',FirstName) LIKE  '%$pilotName%'
			) 
			LIMIT 200";
		
		// echo "a|$query|0";
		//return;
		$res= $db->sql_query($query);
		
		if($res <= 0){   
			echo("<H3> Error in query: $query</H3>\n");
			return;			 
		} 
		while($row= $db->sql_fetchrow($res) ){
			if ($row['countryCode']) $flag=	strtolower($row['countryCode']);
			else $flag='unknown';
			
			$flagIcon="<img src='".moduleRelPath()."/img/fl/$flag.gif' border=0> ";
			//$flagIcon="<img class='fl fl.sprite-$tmpLang' src='".moduleRelPath()."/img/space.gif' border=0> ";
			
			if ($row['Sex']=='F') $sexIcon="<img src='".moduleRelPath()."/img/icon_female.gif' border=0> ";
			else $sexIcon='';
			
			
			$name=$row['FirstName'].' '.$row['LastName'];
			//$name=str_replace($pilotName,"<b>$pilotName</b>",$name);
			//$pilotName=strtoupper($pilotName{0}).substr($pilotName,1);
			//$name=str_replace($pilotName,"<b>$pilotName</b>",$name);

			$pilotName0=strtolower($pilotName0);
			
			$d1=levenshtein ($pilotName0,strtolower($row['FirstName'].' '.$row['LastName'] )  ); 
			$d2=levenshtein ($pilotName0,strtolower($row['LastName'].' '.$row['FirstName'])); 
			$d3=levenshtein ($pilotName0,strtolower($row['FirstName'])); 
			$d4=levenshtein ($pilotName0,strtolower($row['LastName']));

			$dmax=max(array($d1,$d2,$d3,$d4));
			// similar_text (strtolower($lastIntName),strtolower($row2['intName']),&$nameDistanceFromPrevious2);

	
			$html=$row['FirstName'].' '.$row['LastName'].'|'.$flagIcon.$sexIcon.$name.'|'.$row['serverID'].'u'.$row['pilotID']."\n";
			
			$serverIDview=$row["serverID"];
			$pilotIDview=$row["pilotID"];
			$photo='';	
			if ($row['PilotPhoto']>0) {
		
				//checkPilotPhoto($serverIDview,$pilotIDview);
	     		$imgBigRel=getPilotPhotoRelFilename($serverIDview,$pilotIDview);	
				$imgBig=getPilotPhotoFilename($serverIDview,$pilotIDview);	
				// echo $imgBig."<BR>";
				list($width, $height, $type, $attr) = getimagesize($imgBig);
				
				//echo $imgBig."  $CONF['photos']['mid']['max_width'], $CONF['photos']['mid']['max_height'], $width, $height <br>";
				list($width, $height)=CLimage::getJPG_NewSize($CONF['photos']['mid']['max_width'], $CONF['photos']['mid']['max_height'], $width, $height);
				
				
				$photo="<a href='$imgBigRel' target='_blank'><img src='".getPilotPhotoRelFilename($serverIDview,$pilotIDview,1)."'
			onmouseover=\"trailOn('$imgBigRel','','','','','','1','$width','$height','','.');\" onmouseout=\"hidetrail();\" 
			 border=0></a>";					
				
				$photo="<img src='".getPilotPhotoRelFilename($serverIDview,$pilotIDview,1)."'>";
			}
			
			$photo=json::prepStr($photo);
			
			$json0=' { "firstName":"'.json::prepStr($row["FirstName"]).'", "lastName":"'.json::prepStr($row["LastName"]).'", '.			
			' "name":"'.json::prepStr($name).'",'.
			' "flag":"'.json::prepStr($flagIcon).'",'.
			' "photo":"'.$photo.'", '.
			' "sex":"'.json::prepStr($sexIcon).'", "userID":"'.json::prepStr($row["serverID"].'u'.$row["pilotID"]).'" } ';
			
			$json=' { "value": "'.$serverIDview.'_'.$pilotIDview.'" , "label":"'.json::prepStr($name).'" }';
			
		    $pilots[]=array("score"=>$dmax,"text"=>$html,"json"=>$json);
			
			
		}

		function cmp($a0, $b0)
		{
			$a=$a0['score'];
			$b=$b0['score'];
		    if ($a == $b) {
		        return 0;
		    }
		    return ($a < $b) ? -1 : 1;
		}
				
		
		usort($pilots, "cmp");
		
		$i=0;
		$count=$_GET['count'];
		if (!$count) $count=15;
		
		
		$JSON_str= ' [ ';		
		foreach ($pilots as $pilot) {
			
			if ( $i>0) $JSON_str.=" ,\n";
			$JSON_str.=$pilot['json'];
			
		    $i++;
		    if ($i>$count) break;
		}

		$JSON_str.= " ] ";
		sendJson($JSON_str);
	
	} else if ($op=="get_task_json") {
		$flightID=$_REQUEST['flightID']+0;
		if ($flightID<=0) exit;	
		$flight=new flight();
		$flight->flightID=$flightID;
		//$flight->getFlightFromDB($flightID,0);	
		echo $flight->gMapsGetTaskJS();
		
	} else if ($op=="flight_info") {
		require_once dirname(__FILE__).'/CL_flightData.php';
		require_once dirname(__FILE__).'/lib/json/CL_json.php';
				
		$flightID=$_REQUEST['flightID']+0;
		if (!$flightID) return;
		
		$flight=new flight();
		$flight->getFlightFromDB($flightID,0);
	
		$flight->makeJSON(0);  // no force
		$flight->createEncodedPolyline(0); // no force
		
		$i=0;
		$JSON_str="";
		if (1) {
			//$nearestWaypoint=new waypoint($takeoffIDTmp);
			//$nearestWaypoint->getFromDB();
	
			$name=getPilotRealName($flight->userID,$flight->userServerID);
			$link=htmlspecialchars ("http://".$_SERVER['SERVER_NAME'].
										getLeonardoLink(array('op'=>'show_flight','flightID'=>$flightID)) 
									);
										
			$this_year=substr($flight->DATE,0,4);		
			$linkIGC=htmlspecialchars ("http://".$_SERVER['SERVER_NAME'].getRelMainDir().
					str_replace("%PILOTID%",getPilotID($flight->userServerID,$flight->userID),str_replace("%YEAR%",$this_year,$CONF['paths']['igc']) ).'/'.
					$flight->filename );  
					//$flightsRelPath."/".$row[userID]."/flights/".$this_year."/".$row[filename] );  
			
			if ($flight->takeoffVinicity > $takeoffRadious ) 
				$location=getWaypointName($flight->takeoffID)." [~".sprintf("%.1f",$flight->takeoffVinicity/1000)." km]"; 
			else $location=getWaypointName($flight->takeoffID);
	
				
			$START_TIME=$flight->START_TIME;
			$END_TIME=$flight->END_TIME;
			$DURATION=$END_TIME-$START_TIME;	
			
			$year=substr($flight->DATE,0,4);
			$month=substr($flight->DATE,5,2);
			$day=substr($flight->DATE,8,2);	
			$startTm=gmmktime(0,0,0,$month,$day,$year) ; // + $START_TIME; // + $flight->timezone*3600 +
			$startTm*=1000;	
			// echo "$month,$day,$year $startTm#$START_TIME#";exit;
					
	
			$polyFile=$flight->getPolylineFilename();
			$polyPath="http://".$_SERVER['SERVER_NAME'].getRelMainDir().$flight->getPolylineRelPath();
			
			$lines=$flight->getPolyHeader();
			
			 //[0] => 51.7671|14.295933333333|Takeoff|Takeoff 
		 //	[1] => 52.03905|15.095716666667|Landing|Landing 
		
			$parts = explode('|',$lines[0]);
			$takeoff_lat = $parts[0];
			$takeoff_lon = $parts[1];
			
			$parts = explode('|',$lines[1]);
			$landing_lat = $parts[0];
			$landing_lon = $parts[1];			
			
		 	$parts = explode(',',$lines[2]);
			$min_lat = $parts[0];
			$max_lat = $parts[1];
			$min_lon = $parts[2];
			$max_lon = $parts[3];
	
			$jsonGraphData="http://".$_SERVER['SERVER_NAME'].getRelMainDir().$flight->getJsonRelPath();
			
			$kmz=$_SERVER['SERVER_NAME']."/$baseInstallationPath/".$flight->getKMLRelPath(0);
			$kmz=str_replace('//','/', $kmz);
			$kmz=str_replace('//','/', $kmz);
			
			$flightKMZ="http://".$kmz;
			
			// access the kmz file and create it if it does not exists
			// $kmlStr=$flight->kmlGetTrack("ff0000",1,2,0);
			
			
			$markerIconUrl=$_SERVER['SERVER_NAME'].getRelMainDir()."/img/icon_cat_".$flight->cat.".png";
			$markerIconUrl=str_replace('//','/', $markerIconUrl);
			$markerIconUrl=str_replace('//','/', $markerIconUrl);
			$markerIconUrl="http://".$markerIconUrl;
			
			// remove the string  
			// var flightArray=
			// it is 16 bytes
			//$flightJsonStr=file_get_contents($flight->getJsonFilename());
			//$flightJsonStr=substr($flightJsonStr,16);

            $graphsStr=" [ ";

            $graphsStr.='{ "g1": "'.json::prepStr($flight->getChartRelPath(1,1,0)).'" },'."\n";

            $graphsStr.='{ "g2": "'.json::prepStr($flight->getChartRelPath(2,1,0)).'" },'."\n";
            $graphsStr.='{ "g3": "'.json::prepStr($flight->getChartRelPath(3,1,0)).'" },'."\n";
            $graphsStr.='{ "g4": "'.json::prepStr($flight->getChartRelPath(4,1,0)).'" }'."\n";

			$graphsStr.=" ] \n\n";

			$photosStr="";
			if ($flight->hasPhotos) {
				require_once dirname(__FILE__)."/CL_flightPhotos.php";
			
				$flightPhotos=new flightPhotos($flight->flightID);
				$flightPhotos->getFromDB();
			
				// get geoinfo
				$flightPhotos->computeGeoInfo();
			
				$imagesHtml="";
				foreach ( $flightPhotos->photos as $photoNum=>$photoInfo) {
					//$photoInfo['lat']=51.8;
					//$photoInfo['lon']=14.0;
					
					$pnum=0;
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
			
						// echo " 	drawPhoto(".$photoInfo['lat'].",".$photoInfo['lon'].",$photoNum,'$imgIconRel','$imgTarget',$width,$height); \n";
						
						if ($pnum>0) $photosStr.=" , \n";
						$photosStr.= ' { "lat":'.json::prepStr($photoInfo['lat']).', "lon":'.json::prepStr($photoInfo['lon']).
							', "num" : '.$photoNum.', "icon": "'.json::prepStr($imgIconRel).'" ,"photo":"'.json::prepStr($imgTarget).'", "width": '.$width.
							', "height": '.$height.' } ';
						
						 
						$pnum++;	
					}		
					
				}
				if ($pnum>0) {
					$photosStr="[".$photosStr ."]";				
				} else {
                    $photosStr=" [] ";
                }
			}
            $photosStr=" [] ";
			
				
			// print_r($lines);
			// if ($i>0) $JSON_str.=", ";
			
			$JSON_str.=' {"flightID": "'.$flightID.'", "date": "'.json::prepStr($flight->DATE).'", '.
					'"firstLat": "'.json::prepStr($flight->firstLat).'", '.
					'"firstLon": "'.json::prepStr($flight->firstLon).'", '.
					
					'"lastLat": "'.json::prepStr($flight->lastLat).'", '.
					'"lastLon": "'.json::prepStr($flight->lastLon).'", '.
							 
					'"TZoffset": "'.json::prepStr( $flight->timezone).'", '.
					//'"TZoffset": "'.json::prepStr( 1+ $flightID%2 ).'", '.
					'"DURATION": "'.json::prepStr($DURATION).'", '.
					'"START_TIME": "'.json::prepStr($START_TIME).'", '.
					'"END_TIME": "'.json::prepStr($END_TIME).'", '.
					'"startTm": "'.json::prepStr($startTm).'", '.
					
					//'"polyUrl": "'.json::prepStr($polyPath).'", '.
					//'"graphUrl": "'.json::prepStr($jsonGraphData).'", '.
					
					'"flightKMZUrl": "'.json::prepStr($flightKMZ).'", '.			
					'"markerIconUrl": "'.json::prepStr($markerIconUrl).'", '.
			
					// ARRAYS !!!
					'"task": '.$flight->gMapsGetTaskJS().', '.
	
					//'"points": '.$flightJsonStr.', '.
			
					'"photos": '.$photosStr.', '.

                    '"graphs": '.$graphsStr.', '.
			
					'"min_lat": "'.json::prepStr($min_lat).'", '.
					'"max_lat": "'.json::prepStr($max_lat).'", '.
					'"min_lon": "'.json::prepStr($min_lon).'", '.
					'"max_lon": "'.json::prepStr($max_lon).'", '.			
			
					'"takeoff_lat": "'.json::prepStr($takeoff_lat).'", '.
					'"takeoff_lon": "'.json::prepStr($takeoff_lon).'", '.
			
					'"landing_lat": "'.json::prepStr($landing_lat).'", '.
					'"landing_lon": "'.json::prepStr($landing_lon).'", '.	
			
					'"pilotName": "'.json::prepStr($name).'", '.
					'"takeoffID": "'.json::prepStr($flight->takeoffID).'"  } ';
					'"takeoff": "'.json::prepStr($location).'"  } ';
			
		}

		//$JSON_str='{"totalCount":"'.$i.'","flights":[ '. $JSON_str."  ] } ";	
		//$JSON_str='{ "flights":[ '. $JSON_str."  ] } ";	
			
		sendJson($JSON_str); 
			
		
	} else if ($op=="get_info") {
		require_once dirname(__FILE__).'/lib/json/CL_json.php';
				
		$flightID=$_REQUEST['flightID']+0;
		if (!$flightID) return;
		
		 $query="SELECT * FROM $flightsTable WHERE ID=$flightID";
		 //echo $query;
		 $res= $db->sql_query($query);
		 if($res <= 0){
			 echo("<H3> Error in query! $query </H3>\n");
			 exit();
		 }

		$JSON_str="";
		if ($row = mysql_fetch_assoc($res)) { 
			 $nearestWaypoint=new waypoint($takeoffIDTmp);
			 $nearestWaypoint->getFromDB();
	
			$name=getPilotRealName($row["userID"],$row["userServerID"]);
			$link=htmlspecialchars ("http://".$_SERVER['SERVER_NAME'].
										getLeonardoLink(array('op'=>'show_flight','flightID'=>$row['ID'])) 
									);
										
			$this_year=substr($row['DATE'],0,4);		
			$linkIGC=htmlspecialchars ("http://".$_SERVER['SERVER_NAME'].getRelMainDir().
					str_replace("%PILOTID%",getPilotID($row["userServerID"],$row["userID"]),str_replace("%YEAR%",$this_year,$CONF['paths']['igc']) ).'/'.
					$row['filename'] );  
					//$flightsRelPath."/".$row[userID]."/flights/".$this_year."/".$row[filename] );  
			
			if ($row['takeoffVinicity'] > $takeoffRadious ) 
				$location=getWaypointName($row['takeoffID'])." [~".sprintf("%.1f",$row['takeoffVinicity']/1000)." km]"; 
			else $location=getWaypointName($row['takeoffID']);
	
			if ($i>0) $JSON_str.=", ";
			
			$JSON_str.=' {"flightID": "'.$row["ID"].'", "date": "'.json::prepStr($row["DATE"]).'", '.
					'"firstLat": "'.json::prepStr($row["firstLat"]).'", '.
					'"firstLon": "'.json::prepStr($row["firstLon"]).'", '.
					
					'"lastLat": "'.json::prepStr($row["lastLat"]).'", '.
					'"lastLon": "'.json::prepStr($row["lastLon"]).'", '.
					
					'"duration": "'.json::prepStr($row["lastLon"]).'", '.
					'"lastLon": "'.json::prepStr($row["lastLon"]).'", '.
					'"lastLon": "'.json::prepStr($row["lastLon"]).'", '.
					'"lastLon": "'.json::prepStr($row["lastLon"]).'", '.
					
					
					'"pilotName": "'.json::prepStr($name).'", '.
					'"takeoff": "'.json::prepStr($location).'"  } ';
			
		}

		//$JSON_str='{"totalCount":"'.$i.'","flights":[ '. $JSON_str."  ] } ";	
		$JSON_str='{ "flights":[ '. $JSON_str."  ] } ";	
		
		sendJson($JSON_str);		
		
	} else if ($op=="list_flights_json") {
        global $OVERRIDE;
        $OVERRIDE['imgtype']=0;
        $OVERRIDE['fullurl']=1;
        require_once dirname(__FILE__).'/CL_flightData.php';
		require_once dirname(__FILE__).'/lib/json/CL_json.php';
		
		
		//error_reporting(-1); ini_set("display_errors", 1);
			
        if ($_REQUEST['flightID']) {
           $singleFlight=1;
			
           $where_clause=" ID=".($_REQUEST['flightID']+0) ." ";

        } else  {
            $singleFlight=0;
			
            $lat=$_REQUEST['lat']+0;
            $lon=$_REQUEST['lon']+0;
            $distance=$_REQUEST['distance']+0; // radious in km

            if ( $distance < 0 ) $distance=100;
            if ( $distance > 2500 ) $distance=2500;


            $where_clause=" 1 ";
			
			$pilotID=makeSane($_REQUEST['pilot0'],2);
			if ($pilotID ){
				list($serverID,$pilotIDview)=split("_",$pilotID);
			} else {
				$pilotIDview=makeSane($_REQUEST['pilotIDview'],1);
				$serverID=makeSane($_REQUEST['serverID'],1);
			}
			
            if ($pilotIDview!=0) {
                $where_clause.=" AND userID='".$pilotIDview."'  AND userServerID=$serverID ";
            }


            $takeoffID=makeSane($_REQUEST['takeoff0'],1);
			if ($takeoffID) {
				$where_clause.=" AND takeoffID='".$takeoffID."' ";
			}
			

            $startTime=makeSane($_REQUEST['startTime'],1); // secs from start of day
            $endTime=makeSane($_REQUEST['endTime'],1); // secs fro mstart of day

             $tm=makeSane($_REQUEST['from_tm'],1); // timestamp
             //  $tm=time()-60*60*24*70; // 1 week back
             if ($tm) {
                 $where_clause.=" AND dateAdded >= FROM_UNIXTIME($tm) ";
             }

             $tm1=makeSane($_REQUEST['tm1'],1); // timestamp
             $tm2=makeSane($_REQUEST['tm2'],1); // timestamp


             $date1=makeSane($_REQUEST['date']); // date dd.mm.yyyy format or dd/mm/yyyy
             if ($date1) {
                if  ( !$startTime  ) {
                    $dateParts=split("\.",$date1);
                    $tm1=gmmktime(0,0,0,$dateParts[1],$dateParts[0],$dateParts[2]);
                    //$tm1=gmmktime(0,0,0,1,1,2007);
                    $tm2=gmmktime(0,0,0,$dateParts[1],$dateParts[0]+1,$dateParts[2]);
                } else {
                    $dateParts=split("\-",$date1);

                    // $select_clause.="  , TIMEDIFF ( `DATE`, '$date1') as DAYDIFF ";
                }
             }

			 $date0=makeSane($_REQUEST['date0'],2); // date  dd/mm/yyyy
             if ($date0) {                
                    $dateParts=split("\/",$date0);
                    $date0str=$dateParts[2].'-'.$dateParts[1].'-'.$dateParts[0];                    
					$where_clause.=" AND `DATE` = '$date0str' ";
             }			 

             if ($tm1 && $tm2) {
                 $where_clause.=" AND `DATE` >= FROM_UNIXTIME($tm1,'%Y-%m-%d') AND `DATE` <= FROM_UNIXTIME($tm2,'%Y-%m-%d') ";
             }

             $count=makeSane($_REQUEST['count'],1); // timestamp
             if (!$count)  {
                if ($CONF['db_browser']['maxTrackNum']) {
                    $count=$CONF['db_browser']['maxTrackNum'];
                } else {
                    $count=25;
                }
             }

             if ($count) $lim=" LIMIT $count ";
             else  $lim="";

		 
             if ($startTime && $endTime  && $date1 ) {

                $select_clause.=", ABS( TO_DAYS(`DATE`) - TO_DAYS('$date1') ) as date_diff ,

                                ABS(START_TIME-$startTime) as  start_diff \n";

                $orderBy=" date_diff ASC , distance DESC , start_diff ASC ";
             }

            // $distance*=1000;
            if ($lat && $lon && $distance ) {
                $select_clause.=",\n".
                    "ROUND((ACOS((SIN(" . $lat . "/57.2958) * ".
                    "SIN(firstLat/57.2958)) + (COS(" . $lat . "/57.2958) * ".
                    "COS(firstLat/57.2958) * ".
                    "COS(firstLon/57.2958 - " . $lon . "/57.2958)))) ".
                    "* 6392 , 3) AS distance\n";

                $where_clause.=" AND ROUND((ACOS((SIN(" . $lat . "/57.2958) * ".
                    "SIN(firstLat/57.2958)) + (COS(" . $lat . "/57.2958) * ".
                    "COS(firstLat/57.2958) * ".
                    "COS(firstLon/57.2958 - " . $lon . "/57.2958)))) ".
                    "* 6392 , 3) <= " . $distance. " " ;
            }
        }

        // $orderBy=" FLIGHT_POINTS DESC ";
        $orderBy=" `DATE` DESC ";

		 $query="SELECT * $select_clause FROM $flightsTable WHERE $where_clause ORDER BY $orderBy $lim ";  // , distance ASC , dateAdded DESC
		// echo $query."<BR><BR>";
		 $res= $db->sql_query($query);
		 if($res <= 0){
			 echo("<H3> Error in query! $query </H3>\n");
			 exit();
		 }

		$JSON_str="";
		$i=0;
		while ($row = mysql_fetch_assoc($res)) { 
			$nearestWaypoint=new waypoint($takeoffIDTmp);
			$nearestWaypoint->getFromDB();
	
			$name=getPilotRealName($row["userID"],$row["userServerID"],1);
			$link=htmlspecialchars ("http://".$_SERVER['SERVER_NAME'].
										getLeonardoLink(array('op'=>'show_flight','flightID'=>$row['ID'])) 
									);
										
			$this_year=substr($row[DATE],0,4);		
			$linkIGC=htmlspecialchars ("http://".$_SERVER['SERVER_NAME'].getRelMainDir().
					str_replace("%PILOTID%",getPilotID($row["userServerID"],$row["userID"]),str_replace("%YEAR%",$this_year,$CONF['paths']['igc']) ).'/'.
					$row['filename'] );  
					//$flightsRelPath."/".$row[userID]."/flights/".$this_year."/".$row[filename] );  
			
			if ($row['takeoffVinicity'] > $takeoffRadious ) 
				$location=getWaypointName($row['takeoffID'])." [~".sprintf("%.1f",$row['takeoffVinicity']/1000)." km]"; 
			else $location=getWaypointName($row['takeoffID']);
	
			if ($i>0) $JSON_str.=", ";
			
			$START_TIME=sec2Time24h($row['START_TIME'],1);
			$END_TIME=sec2Time24h($row['END_TIME'],1);
			$duration=sec2Time($row['DURATION'],1);

			$linearDistance=formatDistanceOpen($row["LINEAR_DISTANCE"]);
			$olcDistance=formatDistanceOpen($row["FLIGHT_KM"]);
			$olcScore=formatOLCScore($row["FLIGHT_POINTS"]);
			$scoreSpeed=formatSpeed($row["SCORE_SPEED"]);
	
	
			// get the OLC score type
			$olcScoreType=$row['BEST_FLIGHT_TYPE'];
			if ($olcScoreType=="FREE_FLIGHT") {
				$olcScoreTypeImg="icon_turnpoints.gif";
			} else if ($olcScoreType=="FREE_TRIANGLE") {
				$olcScoreTypeImg="icon_triangle_free.gif";
			} else if ($olcScoreType=="FAI_TRIANGLE") {
				$olcScoreTypeImg="icon_triangle_fai.gif";
			} else { 
				$olcScoreTypeImg="photo_icon_blank.gif";
			}
	
			$olcScoreType=leoHtml::img($olcScoreTypeImg,16,16,'top',formatOLCScoreType($olcScoreType,0),'icons1','',0);
			
			$gliderType=$row["cat"]; // 1=pg 2=hg flex 4=hg rigid 8=glider
		    $gliderBrandImg=brands::getBrandImg($row["gliderBrandID"],$row['flight_glider'],$gliderType);
			
		   $gliderTypeDesc=$gliderCatList[$row["cat"]];
	   		if ($row["category"]) {
	   		$gliderTypeDesc.=" - ".$CONF['gliderClasses'][$row["cat"]]['classes'][$row["category"]];
	   		$categoryImg=leoHtml::img("icon_class_".$row["category"].".png",0,0,'top',$gliderTypeDesc,'icons1','',0);
		   } else {
		   		$categoryImg='';
		   }
		   
		   $gliderCat=leoHtml::img("icon_cat_".$row["cat"].".png",0,0,'top',$gliderTypeDesc,'icons1 catListIcon','',0);
		   
		   
		   $MAX_ALT=formatAltitude($row['MAX_ALT']);

		   $MAX_VARIO=formatVario($row['MAX_VARIO']);
           $MIN_VARIO=formatVario($row['MIN_VARIO']);

            if ($singleFlight) {
                $flightID=$row['ID']+0;
                $flight=new flight();
                $flight->getFlightFromDB($flightID,0);

                //$flight->makeJSON(0);  // no force
                $mapUrl=$flight->createStaticMap(0);
            }


            // $pref="http://xc.dhv.de/xc/modules/leonardo";
			$pref="http://".$_SERVER['SERVER_NAME'];
			
			
            $JSON_str.=' {"flightID": "'.$row["ID"].'", "date": "'.json::prepStr($row["DATE"]).'", '.

					'"DURATION": "'.json::prepStr($duration).'", '.
					'"START_TIME": "'.json::prepStr($START_TIME).'", '.
					'"END_TIME": "'.json::prepStr($END_TIME).'", '.
			
					'"MAX_ALT": "'.json::prepStr($MAX_ALT).'", '.
					'"MAX_VARIO": "'.json::prepStr($MAX_VARIO).'", ';
                    '"MIN_VARIO": "'.json::prepStr($MIN_VARIO).'", ';

				if ($singleFlight) {
					$JSON_str.=
						'"g1": "'.json::prepStr($pref.substr($flight->getChartRelPath('alt',1,0),0) ).'", '.
						'"g2": "'.json::prepStr($pref.substr($flight->getChartRelPath('vario',1,0),0) ).'" , '.
						'"g3": "'.json::prepStr($pref.substr($flight->getChartRelPath('speed',1,0),0)).'" , '.
						'"g4": "'.json::prepStr($pref.substr($flight->getChartRelPath('takeoff_distance',1,0),0)).'" , '.

							'"firstLat": "'.json::prepStr($row["firstLat"]).'", '.
							'"firstLon": "'.json::prepStr($row["firstLon"]).'", '.

							'"lastLat": "'.json::prepStr($row["lastLat"]).'", '.
							'"lastLon": "'.json::prepStr($row["lastLon"]).'", '.

						'"map": "'.json::prepStr($pref.substr($mapUrl,0)).'" , '
					;
				}

                $JSON_str.=
					'"linearDistance": "'.json::prepStr($linearDistance).'", '.
					'"olcDistance": "'.json::prepStr($olcDistance).'", '.
					'"olcScore": "'.json::prepStr($olcScore).'", '.
					'"scoreSpeed": "'.json::prepStr($scoreSpeed).'", '.
					'"olcScoreType": "'.json::prepStr($olcScoreType).'", '.


                    '"glider": "'.json::prepStr($row['glider']).'", '.
					'"gliderBrandImg": "'.json::prepStr($gliderBrandImg).'", '.
					'"gliderCat": "'.json::prepStr($gliderCat).'", '.
					'"categoryImg": "'.json::prepStr($categoryImg).'", '.

					'"pilotName": "'.json::prepStr($name).'", '.
					'"takeoff": "'.json::prepStr($location).'"  } ';
			$i++;
		}

		//$JSON_str='{"totalCount":"'.$i.'","flights":[ '. $JSON_str."  ] } ";	
		$JSON_str =	'{ '.
					// ' "query": "'.$date0.'#'.$query.'", '.
					' "flights":[ '. $JSON_str.'  ] } ';	
				

		sendJson($JSON_str);

	}

function sendJson($JSON_str) {
		if(ini_get('zlib.output_compression')){ 
				ini_set('zlib.output_compression', 'Off'); 
		}		

		$JSON_str=str_replace('http://dhv-xc.de.//','http://dhv-xc.de/xc/modules/leonardo/',$JSON_str);
		$JSON_str=str_replace('http:\/\/dhv-xc.de.\/\/','http:\/\/dhv-xc.de\/xc\/modules\/leonardo\/',$JSON_str);
		
		if (!empty($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Apache/2')) {
			header ('Cache-Control: no-cache, pre-check=0, post-check=0, max-age=0');
		} else { 
			header ('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
		}
		header ('Expires: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
		header ('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header ('Content-Type: text/html');				
		header ("Content-Length: " . strlen($JSON_str));

		header ("Access-Control-Allow-Origin: *");	
		//$callbackFunction=$_GET['callback'];
		//echo $callbackFunction."(".$JSON_str.")";
		echo $JSON_str;
}

?>
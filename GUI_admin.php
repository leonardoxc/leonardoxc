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


function chmodDir($dir){
 $current_dir = opendir($dir);
 while($entryname = readdir($current_dir)){
    if(is_dir("$dir/$entryname") and ($entryname != "." and $entryname!="..")){		
	  //	echo "${dir}/${entryname}#<br>";
		chmod("${dir}/${entryname}",0777);       
		chmodDir("${dir}/${entryname}");
       
    }elseif($entryname != "." and $entryname!=".."){
	  // echo "${dir}/${entryname}@<br>";
      chmod("${dir}/${entryname}",0777);
    }
 }
 chmod($dir,0777);       
 closedir($current_dir);
}
	
  open_inner_table("ADMIN AREA",650);
  open_tr();
  echo "<td align=left>";	

	if (!in_array($userID,$admin_users)) {
		echo "<br><br>You dont have access to this page<BR>";
		exitPage();
	}
	$admin_op=makeSane($_GET['admin_op']);


echo "<br><BR>";
echo "<ul>";
	echo "<li><a href='?name=".$module_name."&op=admin&admin_op=fixTakeoffNames'>Fix Takeoff names</a><BR>It will update the takeoff names 
where the local or english name is missing and put the existing name into the missing one <BR>i.e if the local name is missing the english/international name will be used as the local too. ";
	if ($CONF_use_validation)	echo "<li><a href='?name=".$module_name."&op=admin&admin_op=updateValidation'>Update G-Record Validation</a> <BR>
This is a *heavy* operation and will take long to complete<BR>It will check all unchecked flights for airspace violations";
	if ($CONF_use_NAC)			echo "<li><a href='?name=".$module_name."&op=admin&admin_op=updateNAC_Clubs'>Update/Fix NAC Club scoring</a> <BR>";
	echo "<li><a href='?name=".$module_name."&op=admin&admin_op=updateLocations'>Update takeoff/landing locations</a> ";
	echo "<li><a href='?name=".$module_name."&op=admin&admin_op=updateScoring'>Update OLC Scoring</a> ";
	echo "<li><a href='?name=".$module_name."&op=admin&admin_op=updateMaps'>Update Flight Maps</a> ";
echo "</ul>";

echo "<ul>";
	echo "<li><a href='?name=".$module_name."&op=admin&admin_op=importMaps'>Import Maps</a> ";
	echo "<li><a href='?name=".$module_name."&op=admin&admin_op=updateFilePerm'>Update file permissions</a>  ";
	echo "<li><a href='?name=".$module_name."&op=admin&admin_op=findMissingFiles'>Find missing IGC</a>  ";
echo "</ul><br><br>";

echo "<ul>";
	echo "<li><a href='?name=".$module_name."&op=admin&admin_op=findUnusedIGCfiles'>Find unused (rejected) IGC files</a> ";
echo "</ul><br><br>";

echo "<ul>";
	echo "<li><a href='?name=".$module_name."&op=admin&admin_op=makehash'>Make hashes for all flights</a> ";
echo "</ul><br>";
echo "<ul>";
	echo "<li><a href='?name=".$module_name."&op=admin&admin_op=cleanLog'>Clean sync-log </a> ";
	echo "<li><a href='?name=".$module_name."&op=admin&admin_op=remakeLog'>Remake sync-log</a> ";
echo "</ul><br>";

echo "<ul>";
	echo "<li><a href='?name=".$module_name."&op=admin&admin_op=clearBatchBit'>Clean the batch bits for all flights</a> ";
echo "</ul><br>";

echo "<ul>";
	echo "<li><a href='?name=".$module_name."&op=admin&admin_op=cleanPhotosTable'>Clean Photos Table</a> ";
	echo "<li><a href='?name=".$module_name."&op=admin&admin_op=makePhotosNew'>Migrate to new Photos table</a> ";
echo "</ul><br>";

    if ($admin_op=="findUnusedIGCfiles") {
		echo "<ol>";
		findUnusedIGCfiles(dirname(__FILE__)."/flights",0,0) ;
		echo "</ol>";
    } else if ($admin_op=="fixTakeoffNames") {
		$ar1=array('name'=>'intName','intName'=>'name','location'=>'intLocation','intLocation'=>'location');
		foreach ($ar1 as $n1=>$n2){
			$query="UPDATE $waypointsTable SET $n1=$n2 WHERE $n1='' ";
			$res= $db->sql_query($query);				
			if(!$res){
				echo "error in Update query: $query<BR>";
			}
		}
		echo "<BR><BR>Takeoff Names fixed<BR><BR>";
    } else if ($admin_op=="findMissingFiles") {
		$query="SELECT ID,active from $flightsTable ";
		$res= $db->sql_query($query);
			
		if($res > 0){
			 echo "<br><br>";
			 $flight=new flight();
			 while ($row = mysql_fetch_assoc($res)) { 
				 // $flight=new flight();
				 $flight->getFlightFromDB($row["ID"]);		

				 if ( is_file( $flight->getIGCFilename() ) ) $status="OK"; 
				 else {
					 $status=$flight->getIGCRelPath()." MISSING";
				     echo "Flight ID: ".$row["ID"]." [".$row["active"]."] $status <br>";
				 }
			 }
		}
		echo "<BR><br><BR>DONE !!!<BR>";
	} else if ($admin_op=="updateNAC_Clubs") {
		$query="SELECT $flightsTable.DATE , $flightsTable.ID as flightID, $pilotsTable.NACid  as NACid , $pilotsTable.NACclubID  as NACclubID from $flightsTable, $pilotsTable 
				WHERE $flightsTable.userID=$pilotsTable.pilotID AND $pilotsTable.NACid <> 0  AND $pilotsTable.NACclubID <> 0 ";
		$res= $db->sql_query($query);
			
		if($res > 0){
			 while ($row = mysql_fetch_assoc($res)) { 
			 	 $pilotNACID=$row['NACid'];
				 $pilotNACclubID=$row['NACclubID'];			
				 // if we use NACclubs
				// get the NACclubID for userID
				// and see if the flight is in the current year (as defined in the NAclist array
			 	if ( $CONF_NAC_list[$pilotNACID]['use_clubs'] ) {
					// check year -> we only put the club for the current season , so that results for previous seasons cannot be affected 
					$currYear=$CONF_NAC_list[$pilotNACID]['current_year'];
					
					if ($CONF_NAC_list[$pilotNACID]['periodIsNormal']) {
						$seasonStart=($currYear-1)."-12-31";
						$seasonEnd=$currYear."-12-31";
					} else {
						$seasonStart=($currYear-1).$CONF_NAC_list[$pilotNACID]['periodStart'];
						$seasonEnd=$currYear.$CONF_NAC_list[$pilotNACID]['periodStart'];
					}
					
					
					if ($row['DATE'] > $seasonStart  && $flight->DATE <= $seasonEnd ) { // yes -> put in the clubId in the flight
						 $query2="UPDATE $flightsTable SET NACclubID = $pilotNACclubID where ID=".$row['flightID'];
						 $res2= $db->sql_query($query2);
						 if (!$res2) echo "Problem in updating flight info: $query2<BR>";

					}
				}
				 				 
			 }
		} else 
			echo "Problem in query: $query<BR>";
			
		echo "<BR><br><BR>DONE !!!<BR>";		
	} else if ($admin_op=="updateValidation") {
		$query="SELECT ID from $flightsTable WHERE validated=0";
		$res= $db->sql_query($query);
			
		if($res > 0){
			 $waypoints=getWaypoints();
			 while ($row = mysql_fetch_assoc($res)) { 
				 $flight=new flight();
				 $flight->getFlightFromDB($row["ID"]);
				 $flight->validate();
			 }
		}
		echo "<BR><br><BR>DONE !!!<BR>";
	} else if ($admin_op=="updateLocations") {
		$query="SELECT ID from $flightsTable WHERE active=1";
		$res= $db->sql_query($query);
			
		if($res > 0){
			 $waypoints=getWaypoints();
			 while ($row = mysql_fetch_assoc($res)) { 
				 $flight=new flight();
				 $flight->getFlightFromDB($row["ID"]);
				 $flight->updateTakeoffLanding($waypoints);
				 $flight->putFlightToDB(1);
			 }
		}
		echo "<BR><br><BR>DONE !!!<BR>";
	} else if ($admin_op=="makehash") {
		global $flightsAbsPath;
		$query="SELECT ID, filename , userID , DATE  from $flightsTable WHERE hash='' ";
		$res= $db->sql_query($query);
		
		if($res > 0){
			 while ($row = mysql_fetch_assoc($res)) { 
					$files_total++;
					$year=substr($row['DATE'],0,4);
					$filename=$flightsAbsPath."/".$row['userID']."/flights/".$year."/".$row['filename'];  
					if (!is_file($filename) ) { 
						$file_not_found++ ; 
						continue;
					}

					$fileContents=implode("\r\n",file($filename));
					$hash=md5($fileContents);

					$query2="UPDATE $flightsTable SET hash='$hash' WHERE ID=".$row['ID']." ";
					$res2= $db->sql_query($query2);
					
					if(!$res2){
						echo "Problem in query:$query2<BR>";
						exit;
					}
			 }
		}
		echo "<BR><br><br>DONE !!!<BR>";
		echo "<BR><br>Files not found : $file_not_found <BR>";
		echo "<BR><br>Files total: $files_total<BR>";
		
	} else if ($admin_op=="updateScoring") {
		$query="SELECT ID from $flightsTable WHERE active=1 ORDER BY ID ASC";
		$res= $db->sql_query($query);
		
		if($res > 0){
			 $waypoints=getWaypoints();
			 while ($row = mysql_fetch_assoc($res)) { 
				  $flight=new flight();
				  $flight->getFlightFromDB($row["ID"]);

				  if ($flight->FLIGHT_POINTS==0) {
					  set_time_limit(200);
					  $flight->getOLCscore();
				  }	 			
				  $flight->putFlightToDB(1);
			 }
		}
		echo "<BR><br><br>DONE !!!<BR>";
	} else if ($admin_op=="cleanLog") {
		Logger::deleteLogsFromDB(1);
		clearBatchBit();
	} else if ($admin_op=="remakeLog") {

		$query="SELECT ID from $flightsTable WHERE active=1 AND batchOpProcessed=0 AND serverID=0 ORDER BY ID ASC";
		$res= $db->sql_query($query);
		
		if($res > 0){
			 while ($row = mysql_fetch_assoc($res)) { 
				  $flight=new flight();
				  $flight->getFlightFromDB($row["ID"]);
				  $flight->makeLogEntry();
				  setBatchBit($row["ID"]);
				  set_time_limit(300);
			 }
		}
		echo "<BR><br><br>DONE !!!<BR>";

	} else if ($admin_op=="cleanPhotosTable") {
		$query="DELETE from $photosTable ";
		$res= $db->sql_query($query);
		
		if(!$res){
			echo "Problem in empting $photosTable : $query<BR>";
		}
		clearBatchBit();
	} else if ($admin_op=="makePhotosNew") {

		$query="SELECT * from $flightsTable WHERE batchOpProcessed=0 ORDER BY ID ASC";
		$res= $db->sql_query($query);
		
		if($res > 0){
			 while ($row = mysql_fetch_assoc($res)) { 
				$hasPhotos=0;
				$photos=array();
				for($i=1;$i<=$CONF_photosPerFlight;$i++) {
					$var_name="photo".$i."Filename";
					if ($row[$var_name]) {
						$photos[]=$row[$var_name];
						$hasPhotos++;
					}
				}

				$year=substr($row['DATE'],0,4);
				$path=$row['ID']."/photos/$year";
				foreach($photos as $photo) {
					$query1="INSERT INTO $photosTable  (flightID,path,name) values (".$row['ID'].",'$path','$photo') ";
					$res1= $db->sql_query($query1);					
					if (!$res1) {
						echo "Problem in instering photo : $query1<BR>";
					}
					$photoNumTotal++;
				}

				if ($hasPhotos) {
					$query2="UPDATE $flightsTable SET hasPhotos=$hasPhotos WHERE ID=".$row['ID'];
					$res2= $db->sql_query($query2);
			
					if(!$res2 ){
						echo "Problem in updating hasPhotos : $query2<BR>";
					}
				}
				setBatchBit($row["ID"]);
				set_time_limit(30);
			}
		}

		echo "Migrated $photoNumTotal photos<BR>";
		echo "<BR><br><br>DONE !!!<BR>";

	} else if ($admin_op=="clearBatchBit") {
		clearBatchBit();
	} else if ($admin_op=="updateMaps") {
		$query="SELECT ID from $flightsTable WHERE active=1 ORDER BY ID ASC";
		$res= $db->sql_query($query);
		
		if($res > 0) {
			 while ($row = mysql_fetch_assoc($res)) { 
				  $flight=new flight();
				  $flight->getFlightFromDB($row["ID"]);		
				  set_time_limit(300);
				  // @unlink($flight->getMapFilename() );
				  $flight->getMapFromServer();
				  
				  echo "<BR>DONE id:".$row["ID"];
			 }	 										 
		}
		echo "<BR><br><br>DONE !!!<BR>";
	} else if ($admin_op=="updateFilePerm") {
		$path1=dirname(__FILE__)."/flights";
		// echo "<br>chmod to ".$path1."<br>";
		echo "<br>Changing all files in flights/ to 0777";
		chmodDir($path1,0777);
		echo "<BR><br><BR>DONE !!!<BR>";

	} else if ($admin_op=="importMaps") {
		 echo "<br><br>";
	 	 importMaps( $mapsPath ,1,0);
		 echo "<BR><br><BR>DONE IMPORTING MAPS!!!<BR>";
	}

	echo "</td></tr>";
    close_inner_table();

    function importMaps($dir,$rootLevel,$prefixRemoveCharsArg) {
		 global $db,$mapsTable ;
		 set_time_limit (160);
		 $i=0;
		 if ($rootLevel) $prefixRemoveChars=strlen( trim($dir,"/") ) + 1;
		 else $prefixRemoveChars=$prefixRemoveCharsArg;
		 
		 $current_dir = opendir($dir);
		 while($entryname = readdir($current_dir)){						   
			if( is_dir("$dir/$entryname") && $entryname != "." && $entryname!=".." ) {
			echo "<br>$dir/$entryname<br>";
				importMaps($dir."/".$entryname,0,$prefixRemoveChars);
			} else if( $entryname != "." && $entryname!=".." && strtolower(substr($entryname,-4))==".tab"  ){
				$filename="$dir/$entryname";
				$lines = file ($filename); 

				// example N-34-40_016_016.tab
				$filenameBase = basename ($filename,".tab"); 

				$mapFilename  =substr($filename,$prefixRemoveChars,-4).".jpg";
				$UTMzone=substr($filenameBase,2,2);

				// echo "Importing file ".$mapFilename."<br>";
				echo ".";
				$i++; 
				if ($i%100==0) echo "<BR>";
				flush();

				foreach ($lines as $line) {
					//if (preg_match("/^\((.+)\,(.+)\).+TopLeft.+/",$line)) {
					if (preg_match("/^.+\((.+)\, (.+)\) \(.+TopLeft.+/",$line,$matches)) {
						$top=str_replace (",",".",$matches[2]);
						$left=str_replace (",",".",$matches[1]);						
						
					} else if (preg_match("/^.+\((.+)\, (.+)\) \((.+)\, (.+)\).+BottomRight.+/",$line,$matches)) {
						$bottom=str_replace (",",".",$matches[2]);
						$right=str_replace (",",".",$matches[1]);
						$pixelWidth=$matches[3];
						$pixelHeight=$matches[4];
						$metersPerPixel=($right-$left) / $pixelWidth ;
						if ( $metersPerPixel < 22)  $metersPerPixel=14.25;
						else  if ( $metersPerPixel < 37)  $metersPerPixel=28.5;
						else  if ( $metersPerPixel < 80)  $metersPerPixel=57;
						else  if ( $metersPerPixel < 180)  $metersPerPixel=114;
						else  if ( $metersPerPixel < 300)  $metersPerPixel=228;
						else  if ( $metersPerPixel < 600)  $metersPerPixel=456;
						else $metersPerPixel=round($metersPerPixel);
						// 14.25  , 28.5 , 57 , 114 , 228 , 456
 
					} 
					
				}
				if ($top<0)	$top += 10000000.0;
				if ($bottom<0)	$bottom += 10000000.0;
				//echo $UTMzone."#".$top."#".$left."#".$bottom."#".$right."#".$pixelWidth."#".$pixelHeight."<br>";
 				$query="REPLACE $mapsTable SET filename='".$mapFilename."',  leftX=".$left.", 
					  rightX=".$right.", topY=".$top." , bottomY=".$bottom." , UTMzone=".$UTMzone.
					  " , pixelWidth=".$pixelWidth."  , pixelHeight=".$pixelHeight." , metersPerPixel=".$metersPerPixel." ";
		   	  	//echo $query;

			  	$res= $db->sql_query($query);	
			  	# Error checking
			  	if($res <= 0){  echo("<H3> Error in importing map query! </H3>\n");  }

			}
		 }      
		 closedir($current_dir);
	}


  function findUnusedIGCfiles($dir,$rootLevel,$prefixRemoveCharsArg) {
		 global $module_name,$flightsWebPath;

		 set_time_limit (160);
		 $i=0;
		 if ($rootLevel>1) return;

		 if ($rootLevel==0) $prefixRemoveChars=strlen( trim($dir,"/") ) + 1;
		 else $prefixRemoveChars=$prefixRemoveCharsArg;
		 
		 $current_dir = opendir($dir);
		 $dir_parts=explode("/",$dir);
		 $dir_last="flights/".$dir_parts[count($dir_parts)-1];
		 while($entryname = readdir($current_dir)){						   
			if( is_dir("$dir/$entryname") && $entryname != "." && $entryname!=".." ) {
				// echo "<br>$dir/$entryname<br>";
				findUnusedIGCfiles($dir."/".$entryname,$rootLevel+1,$prefixRemoveChars);
			} else if( $entryname != "." && $entryname!=".."  ){
				if (strtolower(substr($entryname,-4))!=".jpg" ) {
					if ( strtolower(substr($entryname,-4))==".igc" ) {
						$filename="$dir_last/$entryname";
						$pilotID=$dir_parts[count($dir_parts)-1];
						echo "<li> <a href='?name=$module_name&op=list_flights&pilotID=$pilotID&takeoffID=0&country=0&year=0&month=0'>USER</a> :: ". date ("Y/m/d H:i", filemtime("$dir/$entryname"))."&nbsp;<a href='modules/leonardo/".$filename."'>$filename</a> ::";
						echo " <a href='?name=$module_name&op=addTestFlightFromURL&flightURL=".urlencode("http://".$_SERVER['HTTP_HOST']."/".$flightsWebPath."/".$dir_parts[count($dir_parts)-1]."/".$entryname)."'>Check it</a>";
					}
				}
			}
		 }      
		 closedir($current_dir);
	}

function clearBatchBit() {
	global $db,$flightsTable ;
	$query="UPDATE $flightsTable SET batchOpProcessed=0";
	$res= $db->sql_query($query);
	
	if(!$res){
		echo "<BR>PROBLEM in clearing 'batch bit'!!!<BR>";
	} else {
		echo "<BR>Batch bits are now set to 0 for all flights!<BR>";
	}
}

function setBatchBit($flightID) {
	global $db,$flightsTable ;
	$query="UPDATE $flightsTable SET batchOpProcessed=1 WHERE ID=$flightID";
	$res= $db->sql_query($query);
	
	if(!$res){
		echo "<BR>PROBLEM in setting 'batch bit'!!! for flight $flightID<BR>";
	} 
}

?>
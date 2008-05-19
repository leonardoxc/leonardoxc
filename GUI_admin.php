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

?>
<script language="javascript">

function remakeLog(id,action,DBGlvl) {	 	
	var logEntries=MWJ_findObj('logEntries').value;
	var extraStr='&logEntries='+logEntries;	
	document.location='<?=CONF_MODULE_ARG?>&op=admin&admin_op=remakeLog'+extraStr;
}
</script>
	
<?
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

	if (!auth::isAdmin($userID)) {
		echo "<br><br>You dont have access to this page<BR>";
		exitPage();
	}
	$admin_op=makeSane($_GET['admin_op']);

	$logEntries=makeSane($_GET['logEntries'],1);	
	if ( $logEntries=='' ) {
		$logEntries=500; 
	}

//echo "<br>";

echo "<h3>Update operations</h3>";

echo "<ul>";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=fixTakeoffNames'>Fix Takeoff names</a><BR>It will update the takeoff names where the local or english name is missing and put the existing name into the missing one i.e if the local name is missing the english/international name will be used as the local too. ";
	if ($CONF_use_validation)	
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=updateValidation'>Update G-Record Validation</a> <BR>
This is a *heavy* operation and will take long to complete. It will check all unchecked flights for airspace violations";

	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=updateLocations'>Update takeoff/landing locations</a><br>
	This is a *heavy* operation and will take long to complete. It will re-compute  the takeoff/landing  for ALL flights ";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=updateScoring'>Update OLC Scoring</a><BR>
	This is a *heavy* operation and will take long to complete. It will re-compute Scoring for ALL flights either scored or not";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=updateMaps'>Update Flight Maps</a><br>
	This is a *heavy* operation and will take long to complete. It will re-draw the static Maps for ALL flights either present or not ";
echo "</ul>";

echo "<h3>Operations used at Installation time</h3>";
echo "<ul>";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=importMaps'>Import Maps</a> ";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=updateFilePerm'>Update file permissions</a>  ";
echo "</ul>";

echo "<h3>Troubleshoot operations</h3>";
echo "<ul>";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=findMissingFiles'>Find missing IGC</a><br> It will find flights that for some 'strange' reason dont have their IGC files present where they should have  ";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=findUnusedIGCfiles'>Find unused (rejected) IGC files</a><BR>It will find all IGC files that were rejected during submission BUT for some strange reason were not auto-clened by the system. ";
echo "</ul>";

echo "<h3>Clean up files</h3>";
echo "<ul>";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=cleanGEFiles'>Clean files related to Google Earth (kmz and kml files)</a>";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=cleanGMAPSfiles'>Clean files related to Google maps (use it after installing new 3d maps) </a>";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=cleanOldJSfiles'>Clean old js file (not used after v.2.9.0)</a>";
echo "</ul>";

echo "<h3>Migration to newer DB schemes operations</h3>";
echo "<ul>";
	if ($CONF_use_NAC)			
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=updateNAC_Clubs'>Update/Fix NAC Club scoring</a> <BR>";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=makehash'>Make hashes for all flights</a> ";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin_brands'>Detect / Guess glider brands</a> ";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=convertWaypoints'>Convert waypoints from iso -> UTF8 </a> ";
	echo "<hr>";	
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=cleanPhotosTable'>Clean Photos Table (NOT USED !!!)</a> ";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=makePhotosNew'>Migrate to new Photos table (NOT USED !!!)</a> ";
	echo "<hr>";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=updateStartPoints'>Update Takeoff coordinates to new format</a> ";
	echo "<hr>";	
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=convertTakeoffs'>Convert takeoffs from iso to utf8</a> ";
echo "</ul>";

echo "<h3>Sync Log oparations</h3>";
echo "<ul>";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=cleanLog'>Clean sync-log </a> ";
	echo "<li><a href='javascript:remakeLog()'>Remake sync-log </a>  Process <input type='textbox' size='4' id='logEntries' name='logEntries' value='$logEntries'> entries at a time (set -1 to proccess all)<br>
	Uses the 'batchProcessed' field  in flights DB so if the operation times out it can be resumed where it left of.
	You must use the 'Clean the batchProcessed' option in order to aply to all fligths from scratch!	";
echo "</ul>";

echo "<ul>";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=clearBatchBit'>Clean the batchProcessed field for all flights</a> ";
echo "</ul><br><hr>";





    if ($admin_op=="findUnusedIGCfiles") {
		echo "<ol>";
		findUnusedIGCfiles(dirname(__FILE__)."/flights",0,0) ;

		echo "</ol>";    

	} else if ($admin_op=="cleanGEFiles") {
		deleteFiles(dirname(__FILE__)."/flights",0,".kmz");
		deleteFiles(dirname(__FILE__)."/flights",0,".kml");
    } else if ($admin_op=="cleanGMAPSfiles") {
		deleteFiles(dirname(__FILE__)."/flights",0,".json.js");
    } else if ($admin_op=="cleanOldJSfiles") {
		deleteFiles(dirname(__FILE__)."/flights",0,".1.js");
    } else if ($admin_op=="convertTakeoffs") {
		$res= $db->sql_query('SET NAMES latin1');	
		// $query="SELECT * from $waypointsTable WHERE countryCode='RU'";
		$query="SELECT * from $waypointsTable order By countryCode ";

		//$query=" UPDATE leonardo_waypoints SET  name='Schwand', intName='Schwand', lat='47.0142', lon='-8.58312', type='1000', countryCode='CH', location='Brunnen', intLocation='Brunnen', link='http://paragliding.ch/index.php?id=129', description='Startplatz Schwand:   47° 00' 50'' N,8° 35' 05'' O 1250m Bisenstartplatz. In 15 minutigem Fussmarsch zu erreichen ab Bergstation. Gute Soaring Moglichkeiten bei Bise und Nordwind. Flug nach Seewen oder zuruck zur Talstation. Um zur Talstation zu fliegen nach dem Start rechts dem Hang entlang fliegen und vor der Hochspannungsleitung rechts ins Lee fliegen. Das zuruckfliegen im Lee ist bei nicht allzu starkem Wind kein Problem. ', modifyDate='2007-01-24' WHERE ID=9265";
		$res= $db->sql_query($query);
//echo "#$res#";
//return;
		echo "<pre>";
		while ($row = mysql_fetch_assoc($res)) { 	
			$convertInAction=0;
			$sqlStr="  UPDATE $waypointsTable SET ";
			$orgValues="# UPDATE $waypointsTable SET ";

			$enc=$langEncodings[ countryCodeToLanguage($row['countryCode']) ];
			if (!$enc) $enc='iso-8859-1';

			// $orgValues.=" [$enc] ";
			// echo "ecn: $enc <BR>";
			foreach($row as $varName=>$varVal ) {

				$varVal=str_replace("\r\n",'',trim($varVal));
				$varVal=str_replace("\n",'',trim($varVal));
				// $varVal=htmlspecialchars($varVal,ENT_QUOTES,"UTF-8");
				//$varVal=str_replace('&amp;','&',$varVal);
				// $varVal=str_replace('&quot;','"',$varVal);
				//$varVal=str_replace('&lt;','<',$varVal);
				//$varVal=str_replace('&gt;','>',$varVal);
				// $varVal=prep_for_DB($varVal);


				$varValUtf8=iconv($enc,'utf8',$varVal);
				if ($varValUtf8!=$varVal) $convertInAction=1;

//				$varValUtf8=str_replace("\r\n",'<br>',trim($varValUtf8));
//				$varValUtf8=str_replace("\n",'<br>',trim($varValUtf8));

				$varValUtf8=htmlspecialchars($varValUtf8,ENT_QUOTES,"UTF-8");
				// $varValUtf8=str_replace('&amp;','&',$varValUtf8);
				$varValUtf8=str_replace('&quot;','"',$varValUtf8);
				$varValUtf8=str_replace('&lt;','<',$varValUtf8);
				$varValUtf8=str_replace('&gt;','>',$varValUtf8);

				if ($varName!='ID') { 
					$sqlStr.=" $varName='".$varValUtf8."',";
					$orgValues.=" $varName='$varVal',";
				}
			}
			$sqlStr=substr($sqlStr,0,-1);
			$orgValues=substr($orgValues,0,-1);
			$sqlStr.=" WHERE ID=".$row['ID'];
			$orgValues.=" WHERE ID=".$row['ID'];
			//if ($convertInAction || $row['ID']==9265) echo "$orgValues\n$sqlStr;\n#\n";
			if ($convertInAction ) echo "$orgValues\n$sqlStr;\n#\n";
		}
		echo "</pre>";

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
		$query="SELECT ID,active,dateAdded from $flightsTable ";
		$res= $db->sql_query($query);
			
		if($res > 0){
			 echo "<br><br>";
			 $flight=new flight();
			$i=0;
			 while ($row = mysql_fetch_assoc($res)) { 
				 // $flight=new flight();
				 $flight->getFlightFromDB($row["ID"],0);		

				 if ( is_file( $flight->getIGCFilename() ) ) $status="OK"; 
				 else {
					 $i++;
					 $status=$flight->getIGCRelPath();
				     echo "$i. Flight ID: <a href='".getRelMainFileName()."&op=show_flight&flightID=".$row["ID"]."' target=_blank>".$row["ID"]."</a> [".$row["dateAdded"]."] $status <br>";
				 }
			 }
		}
		echo "<BR><br>IGC files missing: $i <hr><BR>";
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
						/// Martin Jursa, 17.05.2007: Update the NACid too
						$query2="UPDATE $flightsTable SET NACclubID = $pilotNACclubID, NACid=$pilotNACID  where ID=".$row['flightID'];
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
				 $flight->getFlightFromDB($row["ID"],0);
				 $flight->validate();
			 }
		}
		echo "<BR><br><BR>DONE !!!<BR>";
	} else if ($admin_op=="convertWaypoints") {
		$query="SELECT * from $waypointsTable ORDER BY ID ASC";
		$res= $db->sql_query($query);
			
		if($res > 0){
			 $i=0;
			 $waypoints=array();
			 while ($row = mysql_fetch_assoc($res)) { 

				$waypoints[$i]=array();
				foreach($row as $name=>$value){
					$waypoints[$i][$name]=$value;
				}

				$waypoints[$i]['name']=mb_convert_encoding($row["name"] ,'iso-8859-7', "UTF-8");
				$waypoints[$i]['intName']=mb_convert_encoding($row["intName"] ,'iso-8859-1', "UTF-8");			  

				foreach($waypoints[$i] as $name=>$value){
					echo "$name: $value, ";
				}
				echo "<BR>";
				$i++;
			 }
		}
		echo "<BR><br><BR>DONE !!!<BR>";

	} else if ($admin_op=="updateLocations") {
		$query="SELECT ID from $flightsTable WHERE active=1";
		$res= $db->sql_query($query);
			
		if($res > 0){
			global  $waypoints;
			 $waypoints=getWaypoints();
			 while ($row = mysql_fetch_assoc($res)) { 
				 $flight=new flight();
				 $flight->getFlightFromDB($row["ID"],1); // this computes takeoff/landing also
				 //$flight->updateTakeoffLanding();
				 //$flight->putFlightToDB(1);
			 }
		}
		echo "<BR><br><BR>DONE !!!<BR>";
	} else if ($admin_op=="updateStartPoints") {
		global $flightsAbsPath;
		// $query="SELECT ID, filename , userID , DATE  from $flightsTable WHERE hash='' ";
		$query="SELECT * from $flightsTable WHERE batchOpProcessed=0 ";
		$res= $db->sql_query($query);
		
		if($res > 0){
			 while ($row = mysql_fetch_assoc($res)) { 
					$files_total++;

					$firstPoint=new gpsPoint($row['FIRST_POINT'],$row['timezone']);

					$firstTime=$firstPoint->gpsTime+0;

					$query2="UPDATE $flightsTable SET firstLat=".$firstPoint->lat().",
							firstLon=".$firstPoint->lon().", firstPointTM=".$firstTime.", batchOpProcessed=1 WHERE ID=".$row['ID']." ";
					$res2= $db->sql_query($query2);
					
					if(!$res2){
						echo "Problem in query:$query2<BR>";
						exit;
					}
			 }
		}
		echo "<BR><br><br>DONE !!!<BR>";
		echo "<BR><br>Flights total: $files_total<BR>";
	} else if ($admin_op=="makehash") {
		global $flightsAbsPath;
		// $query="SELECT ID, filename , userID , DATE  from $flightsTable WHERE hash='' ";
		$query="SELECT ID, filename , userID , DATE  from $flightsTable WHERE  batchOpProcessed=0 ";
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

					$fileContents=implode('',file($filename));
					$hash=md5($fileContents);

					$query2="UPDATE $flightsTable SET hash='$hash' , batchOpProcessed=1 WHERE ID=".$row['ID']." ";
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
				  $flight->getFlightFromDB($row["ID"],0);

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
		if ($logEntries > 0) $limitStr= " LIMIT $logEntries ";
		else $limitStr='';
		
		$query="SELECT ID from $flightsTable WHERE active=1 AND batchOpProcessed=0 AND serverID=0 ORDER BY ID ASC $limitStr";
		$res= $db->sql_query($query);

		$i=0;
		if($res > 0){
			 while ($row = mysql_fetch_assoc($res)) { 
				  $flight=new flight();
				  $flight->getFlightFromDB($row["ID"],0); // dont update takeoff
				  $flight->makeLogEntry();
				  setBatchBit($row["ID"]);
				  $i++;
				  set_time_limit(300);
			 }
		}
		echo "<BR><br><br>DONE !!! processed $i flights<BR>";

	} else if ($admin_op=="cleanPhotosTable") {
		$query="TRUNCATE TABLE $photosTable ";
		$res= $db->sql_query($query);		
		if(!$res){
			echo "Problem in empting $photosTable : $query<BR>";
		}

		$query="UPDATE $flightsTable SET hasPhotos=0 ";
		$res= $db->sql_query($query);		
		if(!$res){
			echo "Problem in setting hasPhotos=0: $query<BR>";
		}
		echo "Cleared photos table<BR>";
		clearBatchBit();
	} else if ($admin_op=="makePhotosNew") {

		$query="SELECT * from $flightsTable WHERE batchOpProcessed=0 ORDER BY ID ASC";
		$res= $db->sql_query($query);
		
		if($res > 0){
			 $photoNumTotal=0;
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
		
				if ($row['userServerID']) $path=$row['userServerID'].'_';
				else $path='';
				
				$path.=$row['userID']."/photos/$year";

				$path=prep_for_DB($path);
				$name=prep_for_DB($name);
				
				foreach($photos as $photo) {
					$query1="INSERT INTO $photosTable  (flightID,path,name) values (".$row['ID'].",'$path','$photo') ";
					$res1= $db->sql_query($query1);					
					if (!$res1) {
						echo "Problem in inserting photo : $query1<BR>";
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
				  $flight->getFlightFromDB($row["ID"],0);		
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


  function deleteFiles($dir,$rootLevel,$suffix) {	
		 global $deletedFiles,$openedDirs,$entriesNum;

		 set_time_limit (160);
		
		 if ($rootLevel==0) {			
			$deletedFiles=0;
			$openedDirs=0;
		 }	 

		 $suffix_len=strlen($suffix);
		 $current_dir = opendir($dir);
		 // echo "open $dir<BR>";
		 $openedDirs++;

		 while (false !== ($entryname = readdir($current_dir))) {     	
			if( is_dir("$dir/$entryname") && $entryname != "." && $entryname!=".." ) {
				// echo "<br>$dir/$entryname<br>";
				deleteFiles($dir."/".$entryname,$rootLevel+1,$suffix);
			} else if( $entryname != "." && $entryname!=".."  ){
				// echo "$entryname::";
				if (strtolower( substr($entryname,-$suffix_len))==$suffix ) {
					$filename="$dir/$entryname";
					echo "[ $deletedFiles ] Delete file $filename<BR>";
					unlink($filename);
					$deletedFiles++;	
				}
			}
		 }      
		 closedir($current_dir);
		 if ($rootLevel==0) {
			echo "<hr>Found and deleted $deletedFiles files<BR><BR>";
			echo "opened Dirs: $openedDirs<br>";
		}
  }

  function findUnusedIGCfiles($dir,$rootLevel,$prefixRemoveCharsArg) {
		 global $flightsWebPath,$moduleRelPath;

		 set_time_limit (160);
		 $i=0;
		 if ($rootLevel>1) return;

		 if ($rootLevel==0) $prefixRemoveChars=strlen( trim($dir,"/") ) + 1;
		 else $prefixRemoveChars=$prefixRemoveCharsArg;
		 
		 $current_dir = opendir($dir);
		 $dir_parts=explode("/",$dir);
		 $dir_last="flights/".$dir_parts[count($dir_parts)-1];
		
		 while (false !== ($entryname = readdir($current_dir))) {     				   
			// while($entryname = readdir($current_dir)){			
			if( is_dir("$dir/$entryname") && $entryname != "." && $entryname!=".." ) {
				// echo "<br>$dir/$entryname<br>";
				findUnusedIGCfiles($dir."/".$entryname,$rootLevel+1,$prefixRemoveChars);
			} else if( $entryname != "." && $entryname!=".."  ){
				if (strtolower(substr($entryname,-4))!=".jpg" ) {
					if ( strtolower(substr($entryname,-4))==".igc" ) {
						$filename="$dir_last/$entryname";
						$pilotID=$dir_parts[count($dir_parts)-1];
						echo "<li> <a href='".CONF_MODULE_ARG."&op=list_flights&pilotID=$pilotID&takeoffID=0&country=0&year=0&month=0'>USER</a> :: ". date ("Y/m/d H:i", filemtime("$dir/$entryname"))."&nbsp;<a href='$moduleRelPath/".$filename."'>$filename</a> ::";
						echo " <a href='".CONF_MODULE_ARG."&op=addTestFlightFromURL&flightURL=".urlencode("http://".$_SERVER['HTTP_HOST']."/".$flightsWebPath."/".$dir_parts[count($dir_parts)-1]."/".$entryname)."'>Check it</a>";
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
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

require_once dirname(__FILE__)."/FN_functions.php";	

?>
<script language="javascript">

function remakeLog(id,action,DBGlvl) {	 	
	var logEntries=MWJ_findObj('logEntries').value;
	var extraStr='&logEntries='+logEntries;	
	document.location='<?=CONF_MODULE_ARG?>&op=admin&admin_op=remakeLog'+extraStr;
}

function remakeScoreLog(id,action,DBGlvl) {	 	
	var logScoreEntries=MWJ_findObj('logScoreEntries').value;
	var extraStr='&logScoreEntries='+logScoreEntries;	
	document.location='<?=CONF_MODULE_ARG?>&op=admin&admin_op=remakeScoreLog'+extraStr;
}

function scoreFlights(id,action,DBGlvl) {	 	
	var scoreFlightsNum=MWJ_findObj('scoreFlightsNum').value;
	var extraStr='&scoreFlightsNum='+scoreFlightsNum;	
	document.location='<?=CONF_MODULE_ARG?>&op=admin&admin_op=updateScoring'+extraStr;
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

	if (!L_auth::isAdmin($userID)) {
		echo "<br><br>You dont have access to this page<BR>";
		exitPage();
	}
	$admin_op=makeSane($_GET['admin_op']);

	$logEntries=makeSane($_GET['logEntries'],1);	
	if ( $logEntries=='' ) {
		$logEntries=500; 
	}

	$logScoreEntries=makeSane($_GET['logScoreEntries'],1);	
	if ( $logScoreEntries=='' ) {
		$logScoreEntries=2000; 
	}
	
	$scoreFlightsNum=makeSane($_GET['scoreFlightsNum'],1);	
	if ( $scoreFlightsNum=='' ) {
		$scoreFlightsNum=200; 
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
/*	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=updateScoring'>Update OLC Scoring</a><BR>
	This is a *heavy* operation and will take long to complete. It will re-compute Scoring for ALL flights either scored or not";
*/	
	echo "<li><a href='javascript:scoreFlights()'>Update XC Scoring</a>  Process <input type='textbox' size='4' id='scoreFlightsNum' name='scoreFlightsNum' value='$scoreFlightsNum'> flights at a time (set -1 to proccess all)<br>
	This is a *heavy* operation and will take long to complete. It will re-compute Scoring for ALL flights either scored or not<BR>
	Uses the 'batchProcessed' field  in flights DB so if the operation times out it can be resumed where it left of.
	You must use the 'Clean the batchProcessed' option in order to aply to all fligths from scratch!	";
	
	
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
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=findBadFilenames'>Find bad filenames (due to non-latin chars)</a><br>";
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
//	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=convertWaypoints'>Convert waypoints from iso -> UTF8 </a> ";
	echo "<hr>";	
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=convertTakeoffs'>Convert takeoffs from iso to utf8</a> Use it when you switch from running Leoanardo
from ISO to UTF encodings and takeoff names appear with bad characters.<BR>
This will output a list of SQL commands that you must manually copy and then execute inside MYSQL with your preferred tool.";

	echo "<li><b>Migrate to changes 2008/05/20</b>";	
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=cleanPhotosTable'>Clean Photos Table</a> ";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=makePhotosNew'>Migrate to new Photos table</a> ";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=updateStartPoints'>Update Takeoff coordinates to new format</a> ";	
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=convertNewlines'>Convert newlines to DOS format</a> ";
	
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=computeMaxTakeoffDistance'>Compute MaxTakeoffDistance for xcontest flights</a> ";
echo "</ul>";

echo "<h3>Sync Log oparations</h3>";
echo "<ul>";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=cleanLogFlights'>Clean local SyncLog (all flights entries) </a> ";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=cleanLogScores'>Clean local SyncLog (only scoring entries) </a> ";

	echo "<li><a href='javascript:remakeLog()'>Remake local SyncLog (flights) </a>  Process <input type='textbox' size='4' id='logEntries' name='logEntries' value='$logEntries'> entries at a time (set -1 to proccess all)<br>
	Uses the 'batchProcessed' field  in flights DB so if the operation times out it can be resumed where it left of.
	You must use the 'Clean the batchProcessed' option in order to aply to all fligths from scratch!	";
	
		echo "<li><a href='javascript:remakeScoreLog()'>Remake local SyncLog (ONLY scoring) </a>  Process <input type='textbox' size='4' id='logScoreEntries' name='logScoreEntries' value='$logScoreEntries'> entries at a time (set -1 to proccess all)<br>
	Uses the 'batchProcessed' field  as in  'Remake local SyncLog' above";

echo "</ul>";

echo "<ul>";
	echo "<li><a href='".CONF_MODULE_ARG."&op=admin&admin_op=clearBatchBit'>Clean the batchProcessed field for all flights</a> ";
echo "</ul><br><hr>";




	if ($admin_op=="computeMaxTakeoffDistance")  {
		
		$query="SELECT * from $flightsTable WHERE batchOpProcessed=0 AND serverID=8  AND LINEAR_DISTANCE=0 ";
		$res= $db->sql_query($query);

		$files_total=0;
		
		if($res > 0){
			 while ($row = mysql_fetch_assoc($res)) { 
				$files_total++;

				if (! $row['firstLat'] || ! $row['firstLon']) {
					$not_set++;
					continue;
				}
				
				$firstPoint=new gpsPoint();
				$firstPoint->setLat($row['firstLat']);
				$firstPoint->setLon($row['firstLon']);
	
				$flightScore=new flightScore($row['ID']);
				$flightScore->getFromDB();	
				$lDistance=$flightScore->computeMaxTakeoffDistance($firstPoint);
						
				$query2="UPDATE $flightsTable SET LINEAR_DISTANCE=$lDistance , batchOpProcessed=1 WHERE ID=".$row['ID'];
				$res2= $db->sql_query($query2);					
				if(!$res2){
					echo "Problem in query:$query2<BR>";
					exit;
				}
			 }
		}
		echo "<BR><br><br>DONE !!!<BR>";
		echo "<BR><br>Flights total: $files_total, not proccessed: $not_set<BR>";
		
	} else if ($admin_op=="findUnusedIGCfiles") {
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
    } else if ($admin_op=="convertNewlines") {
		$query="SELECT * from $flightsTable WHERE filename <> ''  ";
		$res= $db->sql_query($query);

		if($res > 0){
			 echo "<br><br>";

			 $i=0;
			 while ($row = mysql_fetch_assoc($res)) { 
				$year=substr($row['DATE'],0,4);
				$userServerID=$row['userServerID'];
				if ($userServerID) $srvStr=$userServerID.'_';
				else $srvStr='';
				$fdir=$flightsAbsPath."/".$srvStr.$row['userID']."/flights/".$year."/";				
				$filename =$fdir.$row['filename'];

				if (! is_file ($filename) ) continue;


				$handle = fopen ($filename, "rb"); 
				$contents = fread ($handle, 200); 
				fclose ($handle); 

				if (preg_match("/\r([^\n])/",$contents )) {		
					echo "MAC NEWLINES FOR FLIGHT <a href='modules.php?name=leonardo&op=show_flight&flightID=".$row['ID']."'>".$row['ID']."</a><br>";
					$mac++;
					
					$handle = fopen ($filename, "r"); 
					$contents = fread ($handle, filesize ($filename)); 
					fclose ($handle); 
					if ($contents=preg_replace("/\r([^\n])/","\r\n#\\1",$contents) ) {		
						$handle = fopen($filename.'.1', 'w');
						fwrite($handle, $contents);
						fclose($handle); 
					} 
		
				} else if (preg_match("/([^\r])\n/",$contents )) {		
					echo "UNIX NEWLINES FOR FLIGHT <a href='modules.php?name=leonardo&op=show_flight&flightID=".$row['ID']."'>".$row['ID']."</a><br>";

					$handle = fopen ($filename, "r"); 
					$contents = fread ($handle, filesize ($filename)); 
					fclose ($handle); 
					if ( $contents=preg_replace("/([^\r])\n/","\\1\r\n",$contents) ) {		
						$handle = fopen($filename.'.1', 'w');
						fwrite($handle, $contents);
						fclose($handle); 
					} 
					
					$unix++;
				}
		
			}
			echo "MAC $mac  , Unix $unix <BR>";
		}

    } else if ($admin_op=="findMissingFiles") {

		$query="SELECT * from $flightsTable WHERE filename <> ''  ";
		$res= $db->sql_query($query);
			
		require_once dirname(__FILE__)."/CL_server.php";

		if($res > 0){
			 echo "<br><br>";
			 // $flight=new flight();
			 $i=0;
			 	require_once dirname(__FILE__)."/lib/ConvertCharset/ConvertCharset.class.php";
			 while ($row = mysql_fetch_assoc($res)) { 
				 // $flight=new flight();
				 //$flight->getFlightFromDB($row["ID"],0);		

				$year=substr($row['DATE'],0,4);
				$userServerID=$row['userServerID'];
				if ($userServerID) $srvStr=$userServerID.'_';
				else $srvStr='';
				$fdir=$flightsAbsPath."/".$srvStr.$row['userID']."/flights/".$year."/";
				$rdir=$flightsRelPath."/".$srvStr.$row['userID']."/flights/".$year."/";
				$orgFilename=$fdir.$row['filename'];
						
				 if ( is_file( $orgFilename ) ){
				  	$status="OK"; 
					continue;
				 }	
				 
				 	$serverID=$row['serverID'];
					if ($serverID) {
						$server=new Server($serverID);
					}
					 $i++;
					 //$status=$flight->getIGCRelPath();
					 //$status.=" ".$row['original_ID'];
					 
				
					$NewEncoding = new ConvertCharset;
					$enc='iso-8859-1';
					$filenameUTF= $NewEncoding->Convert($row['filename'], 'iso-8859-1', "utf-8", $Entities);
					$filenameISO= $NewEncoding->Convert($row['filename'], "utf-8",'iso-8859-1' , $Entities);
					$filenameGR= $NewEncoding->Convert($filenameUTF, "utf-8", "iso-8859-7", $Entities);

						$oldFilename='';
						if (is_file($fdir.$filenameUTF) ) { 
							echo "[UTF]";
							$oldFilename=$filenameUTF;
						} 
						
						if (is_file($fdir.$filenameISO) ) { 
							echo "[ISO]";
							$oldFilename=$filenameISO;
						} 
						
						if (is_file($fdir.$row['filename']) ) { 
							echo "[ORG]";
							$oldFilename=$row['filename'];
						}
						
						if (is_file($fdir.$filenameGR) ) { 
							echo "[GR]";
							$oldFilename=$filenameGR;
						}
						
 					 $orgIgcURL= "http://".$server->data['url_base']."/download.php?type=igc&zip=0&flightID=".$row["original_ID"];
				     echo "$i. Flight ID: <a href='".getRelMainFileName()."&op=show_flight&flightID=".$row["ID"]."' target=_blank>".$row["ID"]."</a> [".$row["dateAdded"]."]  ";

//					 echo " [ ".$row['filename']." ] ";
					 echo " <a href='$moduleRelPath/$rdir/".$row['filename']."'>IGC</a> ";
					 
					 
					 if ($oldFilename || 1 ) {
					 	$newfilename=toLatin1($row['filename']) ;
						//$newfilename2=toLatin1($filenameUTF) ;
						//$newfilename3=toLatin1($filenameISO) ;
						
						echo "[ ".$row['filename']." ] -> [ $newfilename ]<br> ";
						if ($serverID) {						
						 	echo "<a href='$orgIgcURL'>ORG URL</a> <BR>";
							if (0){ 
								$webRes=getWebpage($orgIgcURL);
								// print_r($webRes);
								if ($webRes['http_code']=='200') {
									echo "Pulled OK !!!!!<BR>";
									writeFile($flight->getIGCFilename(),$webRes['content'] );
								} else {
									echo "Error #".$webRes['errno']." ( http_code:".$webRes['http_code'].") : ".$webRes['errmsg']."<BR>";
								}	
							}
						}
						
					}
					// echo "<BR>";
					 if ($i>400) break;
									
			 } //sql while loop
		}
		echo "<BR><br>IGC files missing: $i <hr><BR>";
		echo "<BR><br><BR>DONE !!!<BR>";
    } else if ($admin_op=="findBadFilenames") {

/*	
$fl_arr=array( 
2337 =>"2006-10-29-CGP-xYYY-01TSIKAS.IGC",
2428 =>"2006-11-18- TSIKAS.IGC", 
2439 =>"2006-11-19- TSIKAS.IGC", 
2440 =>"2006-11-20- TSIKAS.IGC", 
2446 =>"2006-11-26- TSIKAS.IGC", 
2461 =>"2006-12-01-TSIKAS.IGC", 
2464 =>"2006-12-03-Nikos.IGC", 
2492 =>"2006-12-13-TSIKAS.IGC",
2532 =>"2006-12-30- TSIKAS.IGC",
2556 =>"2007-01-06- TSIKAS.IGC",
2648 =>"2007-02-03-NIKOS TSIKAS.IGC",
2690 =>"2007-02-12-TSIKAS.IGC",
2722 =>"ASPRRAGGELOI.IGC",
2797 =>"2007-03-04-Nikos.IGC",
3294 =>"13-05-07 ASPRRAGGELOI.IGC",
786 =>"ASPRRAGGELOI 11-9-2005.IGC",


);

foreach($fl_arr as $fl_id=>$newname) {
		$flight=new flight();
		$flight->getFlightFromDB($fl_id,0);		
		$flight->renameTracklog($newname);	
}

return;*/

/*
$fl_arr=array( 

13265=>"2005-06-15-CGP-xYYY-01-Vlakherna.IGC",
13279=>"drama.IGC",
13295=>"2005-06-22-CGP-xYYY-01-Varupetro.IGC",
13332=>"2005-07-09-CGP-xYYY-01-%7EQiu%20golpIGC",
13391=>"2005-08-03-CGP-xYYY-01-Menidi.IGC",
13392=>"2005-08-07-CGP-xYYY-01-Exantheia.IGC",
);
foreach($fl_arr as $fl_id=>$newname) {
		$query="UPDATE $flightsTable SET filename='$newname' WHERE  ID=$fl_id  ";		
		$res= $db->sql_query($query);
}

return;
*/



		$query="SELECT ID, filename ,dateAdded, userID ,userServerID, DATE  from $flightsTable WHERE  filename <> ''  ";		
		$res= $db->sql_query($query);

		$i=0;
		$j=0;

$mNames=array(	
203  => "evora 12-08-05 1.IGC",
607  => "2006-04-24 ze manel.IGC",
1022 => "evora 19-08-06.IGC",
1093 => "02-APR-06 voo-sra-graca.IGC",
1226 => "evora-aljustrel 9-9-06.IGC",
1862 => "1 CURSO PARAPENTE - BARRA DO KWANZA 2007-02-17.IGC",
2218 => "Arrabida 2007-04-07.IGC",
3980 => "Alvaiazere 010907 a.igc",
5217 => "Arrabida 2008-01-20.IGC",
6194 => "covilha 23-03-08 LS1.IGC",
6032 => "2008-03-02-Rabacal - Madalena (patos).IGC",
6055 => "pocarica 3.IGC",
6057 => "15032008Poco d Cruz.IGC",
6763 => "Castelo de Vide 3 2008-04-27-.IGC",
6764 => "Castelo de Vide 2 2008-04-26.IGC",
7652 => "2008-06-15 - Canhas 1 Prova Regional.IGC",
7664 => "080614 Rabacal.igc",
);

/*
bad chars in 
http://www.sky.gr/modules.php?name=leonardo&op=show_flight&flightID=645
*/
		if($res > 0){
			 while ($row = mysql_fetch_assoc($res)) { 
				$newfilename=toLatin1($row['filename']) ;

				if ($mNames[$row["ID"]]) {
					$newfilename=$mNames[$row["ID"]];				
				}
				
				if ($newfilename=='') {
					echo "$j. Flight ID: <a href='".getRelMainFileName()."&op=show_flight&flightID=".$row["ID"]."' target=_blank>".$row["ID"]."</a> ";
					echo "Latin filename for [ ".$row['filename']." ] is NULL!!!!!<BR>";
					$j++;

					if ($mNames[$row["ID"]]) {
						$newfilename=$mNames[$row["ID"]];
						$latinAvailable=1;
					} else {
						$latinAvailable=0;
					}				
					
					// continue;				
				} else {
					$latinAvailable=1;
				}
				
				if ( $newfilename != $row['filename']){

						
						if ( ! is_file( $fdir.$row["filename"] )  ) {
							$year=substr($row['DATE'],0,4);
							$fdir=$flightsAbsPath."/".$row['userID']."/flights/".$year."/";
		
							require_once dirname(__FILE__)."/lib/ConvertCharset/ConvertCharset.class.php";
							$NewEncoding = new ConvertCharset;
		
		
							$filenameUTF= $NewEncoding->Convert($row['filename'], 'iso-8859-1', "utf-8", $Entities);
							$filenameISO= $NewEncoding->Convert($row['filename'], "utf-8",'iso-8859-1' , $Entities);
							$filenameGR= $NewEncoding->Convert($filenameUTF, "utf-8", "iso-8859-7", $Entities);

						$oldFilename='';
						if (is_file($fdir.$filenameUTF) ) { 
							echo "[UTF]";
							$oldFilename=$filenameUTF;
						} else if (is_file($fdir.$filenameISO) ) { 
							echo "[ISO]";
							$oldFilename=$filenameISO;
						} else if (is_file($fdir.$row['filename']) ) { 
							echo "[ORG]";
							$oldFilename=$row['filename'];
						} else if (is_file($fdir.$filenameGR) ) { 
							echo "[GR]";
							$oldFilename=$filenameGR;
						}

							$i++;
							$newfilename=safeFilename( $newfilename);
							echo "$i. Flight ID: <a href='".getRelMainFileName()."&op=show_flight&flightID=".$row["ID"]."' target=_blank>".$row["ID"]."</a> will rename [".$row["filename"]."] ( $oldFilename ) to [ $newfilename ]  <br>";
	
							if ( $latinAvailable && $newfilename ) {
								$flight=new flight();
								$flight->getFlightFromDB($row["ID"],0);		
								$flight->renameTracklog($newfilename,$oldFilename);
							}
							// if ($i>5 ) break;
							//break;
						}
				}
/*
					$files_total++;
					$year=substr($row['DATE'],0,4);
					$fdir=$flightsAbsPath."/".$row['userID']."/flights/".$year."/";
					$filename=$fdir.$row['filename'];  
					if (!is_file($filename) ) { 
						 $i++;
						 $status="/".$row['userID']."/flights/".$year."/".$row['filename'];



	require_once dirname(__FILE__)."/lib/ConvertCharset/ConvertCharset.class.php";
	$NewEncoding = new ConvertCharset;
	$enc='iso-8859-1';
	$filenameUTF= urlencode($NewEncoding->Convert($row['filename'], $enc, "utf-8", $Entities));
		if (is_file($fdir.$filenameUTF) ) { 
			echo "FOUND UTF !!!!!! :<HR>";
		}
						 $newfilename=toLatin1($row['filename']);
					     echo "$i. Flight ID: <a href='".getRelMainFileName()."&op=show_flight&flightID=".$row["ID"]."' target=_blank>".$row["ID"]."</a> [ $newfilename ] [".$row["dateAdded"]."] $status <br>";
						echo "$filenameUTF<BR>";
						continue;
					}
*/
			}
		}

		echo "<BR><br>Bad IGC filesnames: $i <hr><BR>";
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
    } else if ($admin_op=="convertTakeoffs") {
		$res= $db->sql_query('SET NAMES latin1');	
		$query="SELECT * from $waypointsTable order By countryCode ";

		//$query=" UPDATE leonardo_waypoints SET  name='Schwand', intName='Schwand', lat='47.0142', lon='-8.58312', type='1000', countryCode='CH', location='Brunnen', intLocation='Brunnen', link='http://paragliding.ch/index.php?id=129', description='Startplatz Schwand:   47° 00' 50'' N,8° 35' 05'' O 1250m Bisenstartplatz. In 15 minutigem Fussmarsch zu erreichen ab Bergstation. Gute Soaring Moglichkeiten bei Bise und Nordwind. Flug nach Seewen oder zuruck zur Talstation. Um zur Talstation zu fliegen nach dem Start rechts dem Hang entlang fliegen und vor der Hochspannungsleitung rechts ins Lee fliegen. Das zuruckfliegen im Lee ist bei nicht allzu starkem Wind kein Problem. ', modifyDate='2007-01-24' WHERE ID=9265";
		$res= $db->sql_query($query);
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

	} else if ($admin_op=="updateLocations") {
		$query="SELECT ID from $flightsTable WHERE  batchOpProcessed=0";
		$res= $db->sql_query($query);
			
		if($res > 0){
			global  $waypoints;
			 $waypoints=getWaypoints();
			 while ($row = mysql_fetch_assoc($res)) { 
				 $flight=new flight();
				 $flight->getFlightFromDB($row["ID"],1); // this computes takeoff/landing also
				 //$flight->updateTakeoffLanding();
				 //$flight->putFlightToDB(1);
				 unset($flight);
				 
				 $query2="UPDATE $flightsTable SET batchOpProcessed=1 WHERE ID=".$row['ID']." ";
				 $res2= $db->sql_query($query2);			
				 if(!$res2){
					echo "Problem in query:$query2<BR>";					
				 }
				 
			 }
		}
		echo "<BR><br><BR>DONE !!!<BR>";
	} else if ($admin_op=="updateStartPoints") {
		global $flightsAbsPath;
		// $query="SELECT ID, filename , userID , DATE  from $flightsTable WHERE hash='' ";
		$query="SELECT * from $flightsTable WHERE batchOpProcessed=0 AND  
			 (firstLat=0 or firstLon=0 or lastLon=0 or lastLat=0 )";
		$res= $db->sql_query($query);
		
		if($res > 0){
			 while ($row = mysql_fetch_assoc($res)) { 
					$files_total++;

					if (! $row['FIRST_POINT'] || ! $row['LAST_POINT']) {
						$not_set++;
						continue;
					}
					
					$firstPoint=new gpsPoint($row['FIRST_POINT'],$row['timezone']);
					$lastPoint=new gpsPoint($row['LAST_POINT'],$row['timezone']);

					$firstTime=$firstPoint->gpsTime+0;
					$lastTime=$lastPoint->gpsTime+0;
					
					$query2="UPDATE $flightsTable SET 
							firstLat=".$firstPoint->lat().",firstLon=".$firstPoint->lon().", firstPointTM=".$firstTime.",
							lastLat=".$lastPoint->lat().",lastLon=".$lastPoint->lon().", lastPointTM=".$lastTime.",
							 batchOpProcessed=1 WHERE ID=".$row['ID']." ";
					$res2= $db->sql_query($query2);
					
					if(!$res2){
						echo "Problem in query:$query2<BR>";
						exit;
					}
			 }
		}
		echo "<BR><br><br>DONE !!!<BR>";
		echo "<BR><br>Flights total: $files_total, not proccessed: $not_set<BR>";
	} else if ($admin_op=="makehash") {
		global $flightsAbsPath;
		// $query="SELECT ID, filename , userID , DATE  from $flightsTable WHERE hash='' ";
		$query="SELECT ID, filename , userID , DATE  from $flightsTable WHERE filename<>'' AND  batchOpProcessed=0 ";
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
					$hash='';
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
		if ($scoreFlightsNum > 0) $limitStr= " LIMIT $scoreFlightsNum ";
		else $limitStr='';
		
		$query="SELECT ID from $flightsTable WHERE  batchOpProcessed=0 AND filename<>'' ORDER BY ID ASC $limitStr";
		$res= $db->sql_query($query);

		$j=0;
		if($res > 0){
			 $waypoints=getWaypoints();
			 while ($row = mysql_fetch_assoc($res)) { 
				  $flight=new flight();
				  $flight->getFlightFromDB($row["ID"],0);

				  if ($flight->FLIGHT_POINTS==0 || true ) { // PROCCESS ALL , remove '|| true' to process only unscored
					  set_time_limit(200);
					  $flight->computeScore();
					  setBatchBit($row["ID"]);
					  $j++;
					  //$flight->putFlightToDB(1);
				  }	 			
				  
			 }
		}
		echo "<BR><br><br>$j Flights re-scored !!!<BR>";
	} else if ($admin_op=="cleanLogFlights") {
		Logger::deleteLogsFromDB(1);
		clearBatchBit();
	} else if ($admin_op=="cleanLogScores") {
		Logger::deleteLogsFromDB(1,8);
		clearBatchBit();
	} else if ($admin_op=="remakeLog") {
		if ($logEntries > 0) $limitStr= " LIMIT $logEntries ";
		else $limitStr='';
		
		$query="SELECT ID from $flightsTable WHERE  batchOpProcessed=0  ORDER BY ID ASC $limitStr";
		$res= $db->sql_query($query);

		$i=0;
		if($res > 0){
			 while ($row = mysql_fetch_assoc($res)) { 
				  $flight=new flight();
				  $flight->getFlightFromDB($row["ID"],0); // dont update takeoff
				  
				  // only proccess flights that we have their IGC files !
			  	  if (!is_file($flight->getIGCFilename() )   ) continue;
				  // now see if the scroing is present
				  $flight->flightScore=new flightScore($flight->flightID);
				  
				  $flight->flightScore->getFromDB();
				  if (!$flight->flightScore->gotValues) {
 					unset($flight->flightScore);
				  	set_time_limit(200);
					$flight->computeScore();
				  }
						  
				  $flight->makeLogEntry();
				  setBatchBit($row["ID"]);
				  $i++;
				  set_time_limit(300);
			 }
		}
		echo "<BR><br><br>DONE !!! processed $i flights<BR>";
	} else if ($admin_op=="remakeScoreLog") {
		if ($logEntries > 0) $limitStr= " LIMIT $logScoreEntries ";
		else $limitStr='';
		
		$query="SELECT ID from $flightsTable WHERE  batchOpProcessed=0 ORDER BY ID ASC $limitStr";
		$res= $db->sql_query($query);

		$i=0;
		if($res > 0){
			 while ($row = mysql_fetch_assoc($res)) { 
				  $flight=new flight();
				  $flight->getFlightFromDB($row["ID"],0); // dont update takeoff				 
				  $flight->makeScoreLogEntry();
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
		$query="SELECT ID from $flightsTable WHERE 1 ORDER BY ID ASC";
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
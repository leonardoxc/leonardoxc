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

    if ($admin_op=="findUnusedIGCfiles") {
		echo "<ol>";
		findUnusedIGCfiles(dirname(__FILE__)."/flights",0,0) ;
		echo "</ol>";
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
	} else if ($admin_op=="updateScoring") {
		$query="SELECT ID from $flightsTable WHERE active=1";
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
	} else if ($admin_op=="updateMaps") {
		$query="SELECT ID from $flightsTable WHERE active=1";
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
?>

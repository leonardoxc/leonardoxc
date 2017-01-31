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
// $Id: GUI_admin_paths.php,v 1.12 2010/04/28 10:52:40 manolis Exp $                                                                 
//
//************************************************************************

	echo "<hr><h3>ADMIN: Move files to new path locations</h3>";

	if (! L_auth::isAdmin($userID) ) {
		echo "<BR><BR>Not authorized<BR><BR>";
		return;
	}
		
	global $CONF;
	// we can migrate from any version of paths scheme to another 
	$oldPathsVersion=1;
	$newPathsVersion=2;
		
	$pathsOld=$CONF['paths_versions'][$oldPathsVersion];
	$pathsNew=$CONF['paths_versions'][$newPathsVersion];
	
	$copyMode=$_GET['copyMode']+0;
	
	$copyAllFiles=$_GET['copyAllFiles']+0;
	
	// 1-> files
	// 2-> photos
	$fileSet=$_GET['fileSet']+0;
	
	$output1='';
	$output2='';

	// $where_clause=" WHERE filename LIKE \"%`%\"";
	$where_clause=" WHERE filename <>'' ";

	if ($fileSet & 1 ) { // flights files
		// $query="SELECT * FROM $flightsTable WHERE filename LIKE \"%`%\" order by userServerID,userID ";	
		$query="SELECT * FROM $flightsTable $where_clause order by userServerID,userID ";	
		$res= $db->sql_query($query);
		if($res <= 0){
		 echo("<H3> Error in query! </H3>\n");
		 exit();
		}
		$dirlist=array();	
		while ($row = $db->sql_fetchrow($res)  ) { 
			if (!$row['filename']) continue;	
			if (!$row['userID']) continue;
			
			$userDir='';
			if ($row['userServerID']) {
				$userDir=$row['userServerID'].'_';
			}	
			$userDir.=$row['userID'];
				
			$year=substr($row['DATE'],0,4);
			$filename=$row['filename'];
				
			if ($copyMode==2) { // find mising igc files on new folders
				$oldIgcPath=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$pathsOld['igc']) )."/$filename";
				$newIgcPath=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$pathsNew['igc']) )."/$filename";
				
				$oldIgcPath=str_replace("`","\`",$oldIgcPath);
				$newIgcPath=str_replace("`","\`",$newIgcPath);
				
				if ( !is_file(LEONARDO_ABS_PATH.'/'.$newIgcPath)  ) {
						if ( is_file(LEONARDO_ABS_PATH.'/'.$oldIgcPath) ) $output1.="* ";
						$output1.=$oldIgcPath."\n";	
				}
				continue;
			}
			
					
			$d=0;
			$f=0;
			$files=array();
			$dirs=array();
			
			// $files[$f][0]="$userDir/flights/$year/$filename";
			$files[$f][0]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$pathsOld['igc']) )."/$filename";
			$files[$f][1]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$pathsNew['igc']) )."/$filename";
							
			if (!$dirlist[$userDir][$year]) {
				$dirs[$d++]=dirname($files[$f][1]);
				$dirs[$d++]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$pathsNew['photos']) );
				$dirs[$d++]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$pathsNew['map']) );
				$dirs[$d++]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$pathsNew['charts']) );
				$dirs[$d++]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$pathsNew['kml']) );
				$dirs[$d++]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$pathsNew['js']) );
				$dirs[$d++]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$pathsNew['intermediate']) );
	
				$dirlist[$userDir][$year]++;
			}
			
			$f++;
			
			if ($copyAllFiles) {
				$files[$f]  [0]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$pathsOld['map']) )."/$filename.jpg";
				$files[$f++][1]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$pathsNew['map']) )."/$filename.jpg";
			
				$files[$f]  [0]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$pathsOld['intermediate']) )."/$filename.saned.igc";
				$files[$f++][1]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$pathsNew['intermediate']) )."/$filename.saned.igc";
			
				$files[$f]  [0]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$pathsOld['intermediate']) )."/$filename.saned.full.igc";
				$files[$f++][1]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$pathsNew['intermediate']) )."/$filename.saned.full.igc";
			
				$files[$f]  [0]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$pathsOld['intermediate']) )."/$filename.poly.txt";
				$files[$f++][1]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$pathsNew['intermediate']) )."/$filename.poly.txt";
			
				$files[$f]  [0]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$pathsOld['intermediate']) )."/$filename.1.txt";
				$files[$f++][1]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$pathsNew['intermediate']) )."/$filename.1.txt";
				
				$files[$f]  [0]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$pathsOld['js']) )."/$filename.json.js";
				$files[$f++][1]=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$pathsNew['js']) )."/$filename.json.js";
			}
					
				
			foreach ($dirs as $dir ){
				$output2.="mkdir -p $dir\n";
			}
			foreach ($files as $f=>$farray ){
				$output1.=$farray[0].";";	
				$fname1=str_replace("`","\`",$farray[0]);
				$fname2=str_replace("`","\`",$farray[1]);
				// $output2.="cp -a \"flights/".$farray[0]."\" \"".$farray[1]."\"\n";	
				$output2.="cp -a \"".$fname1."\" \"".$fname2."\"\n";
			}
			$output1.="\n";	
			$output2.="\n";					
			$igcNum++;	
		}		
	} // end flights/
		
	//echo $output;

	if ($fileSet & 2 ) { // photos + pilot profiles
		// $extra_clause="AND ( name LIKE \"%`%\"  OR name LIKE \"%#039;%\") ";
		$extra_clause="";
		// NOW THE PHOTOS
		$query="SELECT * FROM $flightsTable,$photosTable 
			WHERE $photosTable.flightID=$flightsTable.ID
			$extra_clause
			order by userServerID,userID ";
		
		$res= $db->sql_query($query);
		if($res <= 0){
		 echo("<H3> Error in query $query</H3>\n");
		 exit();
		}
		while ($row = $db->sql_fetchrow($res) ) { 
			// if (!$row['filename']) continue;
			$userDir='';
			if ($row['userServerID']) {
				$userDir=$row['userServerID'].'_';
			}	
			$userDir.=$row['userID'];
				
			$year=substr($row['DATE'],0,4);
			$filename=$row['name'];
			
			$f1=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$pathsOld['photos']) )."/$filename";
			$f2path=str_replace("%PILOTID%","$userDir",str_replace("%YEAR%","$year",$pathsNew['photos']) )."/";
			$f2=$f2path.$filename;
	
			$f1=str_replace("`","\`",$f1);	
			$f1=str_replace("&#039;","'",$f1);
			
			$f2=str_replace("`","\`",$f2);	
			$f2=str_replace("&#039;","'",$f2);
				
			if ($copyMode==2)  {		
				if ( ! is_file(LEONARDO_ABS_PATH.'/'."$f2") ) {
					if ( is_file(LEONARDO_ABS_PATH.'/'."$f1") ) $output1.="* ";
					$output1.="$f2\n";
				}
				continue;
			}
				
			$output1.=$row['path']."/$filename\n";		
			$output2.='cp -a "'.$f1.'" "'.$f2.'"'."\n";
			$output2.='cp -a "'.$f1.'.icon.jpg" "'.$f2path.'"'."\n";
	
		}
			
		if ( $copyMode!=2) {
			// NOW the pilot photos	
			$query="SELECT * FROM $pilotsTable ";
			
			$res= $db->sql_query($query);
			if($res <= 0){
			 echo("<H3> Error in query $query </H3>\n");
			 exit();
			}
			while ($row = $db->sql_fetchrow($res) ) { 		
				$userDir='';
				if ($row['serverID']) {
					$userDir=$row['serverID'].'_';
				}	
				$userDir.=$row['pilotID'];
						
				$pilotDirOld=str_replace("%PILOTID%",$userDir,$pathsOld['pilot']);
				$pilotDirNew=str_replace("%PILOTID%",$userDir,$pathsNew['pilot']);
				if ( is_file(LEONARDO_ABS_PATH.'/'."$pilotDirOld/PilotPhoto.jpg") ) {
					$output2.="mkdir -p $pilotDirNew\n";
					$output2.="cp -a $pilotDirOld/PilotPhoto.jpg $pilotDirNew/\n";
					$output2.="cp -a $pilotDirOld/PilotPhotoicon.jpg $pilotDirNew/\n";		
				}		
			}
		}

	}	// end photos + pilot profiles
	
	/// NOW WRITE THE OUTPUT
	$filename="files_list_$fileSet.csv";
	$fp=fopen(dirname(__FILE__)."/$filename","w" );
	fwrite($fp,$output1);
	fclose($fp);
	
	$filename2="copy_files_$fileSet.sh";
	$fp2=fopen(dirname(__FILE__)."/$filename2","w" );
	fwrite($fp2,$output2);
	fclose($fp2);
	
	// echo "\n</pre><HR>";
	echo "Flights found : $igcNum<HR><BR>";
	
	echo "<pre>A file named $filename2 with the shell commands 
	(and a txt file  $filaneme with the igc paths for reference only) 
	have been created in leonardo/ directory.
	Check that theese files are deleted on the server afterwards<BR>
	Execute this command on a shell: \n\n";
	
	
	echo "cd ".dirname(__FILE__)."; chmod +x $filename2; nohup ./$filename2;\n\n";
	
	echo "NOTE: after the copy has finished it is important to chown all files to the apache user\n\n";
	echo "Use a command like :\nchown -R apache:apache data/ \n\n</pre>";
	return;


?>
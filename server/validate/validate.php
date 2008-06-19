<?

	$file=$_REQUEST['file'];

	if ($_GET['dbg']) $debugActive=1;
	else $debugActive=0;

	if ($file) {
		$file=str_replace("#","^$^$^",$file);
		$url=parse_url($file);
		$dirname=dirname($url[path]);
		$basename=basename($url[path]);
		$basename=str_replace("^$^$^","#",$basename);

		$file=$url[scheme]."://".$url[host]."/". $dirname."/".rawurlencode($basename);
		$path=dirname( __FILE__ );
	
		while(1) {
//			$igcFilename=tempnam($path,"IGC.");  
			$igcFilename=sprintf("%s/%08d.igc",$path,mt_rand (0,99999999) ); 
			$i++;
			if (!is_file($igcFilename) || $i>200 )  break;
		}
		@unlink($igcFilename);
		DEBUG("\n<br>igcFilename=$igcFilename");

		$lines=file($file);
		$cont="";
		foreach($lines as $line) {
			$cont.=$line;
		}	
		
		if (!$handle = fopen($igcFilename, 'w')) exit; 
	    if (!fwrite($handle, $cont))    exit; 
		fclose ($handle); 
		$ok=0;
		DEBUG("<pre>");

		$validatePrograms =array(
			"vali-xpg"			=>array("name"=>"","ok_result"=>0,"ok_string"=>"Valid IGC file"),	// ok ( fail -> 1  	IGC file is INVALID) 
	
			"vali-xmp"			=>array("name"=>"","ok_result"=>1,"ok_string"=>"Validation check passed"),	// ok ( fail -> 0  ) 
			"vali-xgd"			=>array("name"=>"","ok_result"=>0,"ok_string"=>"PASSED"),					// ok ( fail -> -1 )
			"vali-bra"			=>array("name"=>"","ok_result"=>0,"ok_string"=>"Data valid"), 			// ok ( fail -> 1 )
			"ValiGpsDump.exe"	=>array("name"=>"","ok_result"=>0,"ok_string"=>"PASSED"),				// ok ( fail -> -1 )
			"valiCompe"			=>array("name"=>"","ok_result"=>9999,"ok_string"=>"OK"),				// ok ( fail -> -1 )

			// "valig7to.exe"		=>array("name"=>"","ok_result"=>99,"ok_string"=>"Validation check passed"),  // 1->not valid 3->not present
			"vali-mun"			=>array("name"=>"","ok_result"=>99,"ok_string"=>"Validation check passed"),  // fail -> 0
			"vali-xmr"			=>array("name"=>"","ok_result"=>99,"ok_string"=>"Validation check passed"),	// fail -> 1		
			// "vali-cu"			=>array("name"=>"","ok_result"=>99,"ok_string"=>"Validation check passed"), // fail -> 67
			
			//"vali-ewa"			=>array("name"=>"","ok_result"=>99,"ok_string"=>"Validation check passed"), // fail -> 2
			//"vali-fil"			=>array("name"=>"","ok_result"=>99,"ok_string"=>"Validation check passed"), // fail -> 69
			//"vali-gcs"			=>array("name"=>"","ok_result"=>99,"ok_string"=>"Validation check passed"), // fail -> 68
			//"vali-lxn"			=>array("name"=>"","ok_result"=>99,"ok_string"=>"Validation check passed"), // fail -> 69
			//"vali-sch"			=>array("name"=>"","ok_result"=>99,"ok_string"=>"Validation check passed"), // fail -> 0
		);
			
		if ( strpos(strtolower(PHP_OS), 'win')  === false ) $CONF['os']='linux';
		else $CONF['os']='windows';

//exec("ls ",$output,$res);
//print_r($output);
//echo "#";

		foreach($validatePrograms as $valProgram=>$valArray) {
			@chmod ($path."/$valProgram", 0755);  
			if ( $CONF['os']=='linux') {
				$cmd="wine v:$valProgram v:".basename($igcFilename)." ";
				// $cmd="wine v:$valProgram v:output.txt ";
			} else 
				$cmd="$valProgram ".basename($igcFilename);

			DEBUG("<hr>cmd=$cmd");
			//echo "CMD: $cmd\n";
			unset($output);
			$res=-9999;
			exec($cmd,$output,$res);
			
			DEBUG("RESULT: $res");
			DEBUG("result has ".count($output)." lines");


			foreach($output as $line) {
				DEBUG($line);
			}

			if ($valArray['ok_result']==9999) { // search for string instead
				if (trim($output[0]==$valArray['ok_string']) ) {
					$ok=1;
					break;
				}
			} else {
				// ok found the correct val program
				if ($res==$valArray['ok_result']) {
					$ok=1;
					break;
				}
			}
		}
		DEBUG("</pre>");
		@unlink($igcFilename);
		if ($ok) echo "OK\n$valProgram";
		else echo "NOK";
		echo $dbgStr;
}

function DEBUG($msg) {
	global $debugActive,$dbgStr;
	if ($debugActive) $dbgStr.="$msg<br>";
}

?>
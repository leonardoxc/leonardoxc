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
	
		$igcFilename=tempnam($path,"IGC.");  //urlencode($basename)
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
			"ValiGpsDump.exe"	=>array("name"=>"","ok_result"=>0,"ok_string"=>"PASSED"),				// ok ( fail -> -1 )
			"valig7to.exe"		=>array("name"=>"","ok_result"=>99,"ok_string"=>"Validation check passed"),  // 1->not valid 3->not present
			"vali-bra"			=>array("name"=>"","ok_result"=>0,"ok_string"=>"Data valid"), 			// ok ( fail -> 1 )
			/*
-----------------------------------
---------- VALI-BRA V1.23 ---------
--- for use with IQ-COMPEO only ---
------- (c) Braeuniger GmbH -------
-----------------------------------


 Data valid!
			*/
			"vali-mun"			=>array("name"=>"","ok_result"=>99,"ok_string"=>"Validation check passed"),
			"vali-xgd"			=>array("name"=>"","ok_result"=>0,"ok_string"=>"PASSED"),					// ok ( fail -> -1 )
			"vali-xmp"			=>array("name"=>"","ok_result"=>1,"ok_string"=>"Validation check passed"),	// ok ( fail -> 0  ) 
			"vali-xmr"			=>array("name"=>"","ok_result"=>99,"ok_string"=>"Validation check passed"),
		);
			
		foreach($validatePrograms as $valProgram=>$valArray) {
			@chmod ($path."/validate/$valProgram", 0755);  
			$cmd="$valProgram ".basename($igcFilename);
			DEBUG("<hr>cmd=$cmd");
			//echo "CMD: $cmd\n";
			unset($output);
			$res=-9999;
			exec($cmd,$output,$res);
			
			DEBUG("RESULT: $res");
			// DEBUG("result has ".count($output)." lines");
			foreach($output as $line) {
				DEBUG($line);
			}

			// ok found the correct val program
			if ($res==$valArray['ok_result']) {
				$ok=1;
				break;
			}
		}
		DEBUG("</pre>");
		@unlink($igcFilename);
		if ($ok) echo "OK";
		else echo "NOK";
		echo $dbgStr;
}

function DEBUG($msg) {
	global $debugActive,$dbgStr;
	if ($debugActive) $dbgStr.="$msg<br>";
}

?>
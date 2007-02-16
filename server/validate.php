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
	
		$igcFilename=tempnam($path."/tmpFiles","IGC.");  //urlencode($basename)
		@unlink($igcFilename);
		DEBUG("igcFilename=$igcFilename");

		$lines=file($file);
		$cont="";
		foreach($lines as $line) {
			$cont.=$line;
		}	
		
		if (!$handle = fopen($igcFilename, 'w')) exit; 
	    if (!fwrite($handle, $cont))    exit; 
		fclose ($handle); 
		$ok=0;
		$validatePrograms =array("ValiGpsDump.exe","valig7to.exe");
		foreach($validatePrograms as $valProgram) {
			@chmod ($path."/validate/$valProgram", 0755);  
			$cmd="cd $path ; validate/$valProgram ".$igcFilename;
			DEBUG("cmd=$cmd");
			//echo "CMD: $cmd\n";
			exec($cmd,$output,$res);
			
			//echo "RESULT: $res<BR>";
			DEBUG("result has ".count($output)." lines");
			foreach($output as $line) {
				//echo $line."\n";
			}

			// ok found the correct val program
			if ($ok) break;
		}
		
		@unlink($igcFilename);
		if ($ok) echo "OK";
		else echo "NOK";
}

function DEBUG($msg) {
	global $debugActive;
	if ($debugActive) echo ">>$msg*<br>";
}

?>
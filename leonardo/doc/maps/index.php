<? 

$FORCE_CREATE=0;
$DEBUG=0;

$zoomFactor=1; 

// if original file is 28.5   m/pixel
// values  1  2  4  8 16
// 1 -> 28.5 m/pixel
// 2 -> 57 m/pixel
// 4 -> 114 m/pixel 
// 8 -> 228 m/pixel 
// 16 -> 456 m/pixel 

// if original file is 14.25   m/pixel
// values  1  2  4  8 16 32
// 1 -> 14.25 m/pixel
// 2 -> 28.5 m/pixel
// 4 -> 57 m/pixel
// 8 -> 114 m/pixel 
// 16 -> 228 m/pixel 
// 32 -> 456 m/pixel 


process_all_maps( dirname(__FILE__)."/mrsid_maps",1,0); 

function process_all_maps($dir,$rootLevel,$prefixRemoveCharsArg) {
	 set_time_limit (160);
	 $i=0;
	 if ($rootLevel) $prefixRemoveChars=strlen( trim($dir,"/") ) + 1;
	 else $prefixRemoveChars=$prefixRemoveCharsArg;
	 
	 $current_dir = opendir($dir);
	 while($entryname = readdir($current_dir)){						   
		if( is_dir("$dir/$entryname") && $entryname != "." && $entryname!=".." ) {
			// echo "<br>$dir/$entryname<br>";
			process_all_maps($dir."/".$entryname,0,$prefixRemoveChars);
		} else if( $entryname != "." && $entryname!=".." && strtolower(substr($entryname,-4))==".sid"  ){
			$filename=substr("$dir/$entryname",0,-4);
			echo "PROCESSING: $filename\n";
			// Time the execution
		    $tstart = getmicrotime(); 
			processMap($filename);
		    $tend = getmicrotime();;
		   	$totaltime = ($tend - $tstart);
			echo "$totaltime secs\n";
			flush();			
		}
	 }      
	 closedir($current_dir);
}

return ;
function processMap($filename) {
	global $FORCE_CREATE,$DEBUG;
	global $zoomFactor;

	$mrsid_base_name=basename($filename);
	//"S-50-20";
	// $mrsid_file=$mrsid_base_name."/".$mrsid_base_name.".sid";
	$mrsid_file=$filename.".sid";

	// system("tar xf ".$mrsid_base_name.".tar");
	
	ob_start();
		system("./mrsidinfo $mrsid_file");
		$res_str = ob_get_contents();
	ob_end_clean();
	
	$lines=explode("\n",$res_str );
	
	// we need the following info 
	//  format:            MRSID
	//  width:             27717
	//  height:            22140
	
	//  X UL:              73986.000000
	//  Y UL:              -2138298.000000
	//  X res:             28.500000
	
	//  Y res:             -28.500000
	
	foreach ($lines as $line) {
	//echo $line."<BR>";
		if ( preg_match("/format:(.*)/i", $line , $matches) ) {
			$format=trim($matches[1]);
		} else 	if ( preg_match("/width:(.*)/i", $line , $matches) ) {
			$tot_width=trim($matches[1])+0;
		} else 	if ( preg_match("/height:(.*)/i", $line , $matches) ) {
			$tot_height=trim($matches[1])+0;
		} else 	if ( preg_match("/X UL:(.*)/i", $line , $matches) ) {
			$X_UL=trim($matches[1])+0;
		} else 	if ( preg_match("/Y UL:(.*)/i", $line , $matches) ) {
			$Y_UL=trim($matches[1])+0;
		} else 	if ( preg_match("/X res:(.*)/i", $line , $matches) ) {
			$Xresolution=trim($matches[1])+0;
		} else 	if ( preg_match("/Y res:(.*)/i", $line , $matches) ) {
			$Yresolution=trim($matches[1])+0;
		}
	
	
	}
	
	if ($format!="MRSID") {
		echo "Not a Mrsid file\n";
		return;
	}
	
	$parts=explode("-",$mrsid_base_name) ;
	$UTMzone=$parts[1];
	$hemisphere=strtolower($parts[0]);
	if ( ($pos=strpos($parts[2],"_") ) === false ) $UTMzoneY=$parts[2];
	else  $UTMzoneY=substr($parts[2],0,$pos);
	
	if ($DEBUG) {
		echo "UTMzone  = $UTMzone \n";
		echo "UTMzoneY = $UTMzoneY \n";
		echo "hemisphere= $hemisphere<br>\n";
		
		echo "tot_width = $tot_width \n";
		echo "tot_height = $tot_height<br>\n";
		echo "X_UL = $X_UL \n";
		echo "Y_UL = $Y_UL<br>\n";
		echo "Xresolution = $Xresolution \n";
		echo "Yresolution = $Yresolution<br>\n";
	}	

	// 2048 max pixels  per tile
	$X_tiles_num=ceil ($tot_width / 2048);
	$Y_tiles_num=ceil ($tot_height / 2048 );
	
	$tiles_width=floor($tot_width/$X_tiles_num);
	$tiles_height=floor($tot_height/$Y_tiles_num);
	
	$last_X_tiles_width=  $tot_width - ($X_tiles_num -1)*$tiles_width;
	$last_Y_tiles_height= $tot_height - ($Y_tiles_num -1)*$tiles_height;
	
	if ($DEBUG) {
		echo "<hr>\n";
		echo "X_tiles_num = $X_tiles_num \n";
		echo "Y_tiles_num = $Y_tiles_num <br>\n";
		echo "tiles_width = $tiles_width \n";
		echo "tiles_height = $tiles_height <br>\n";
		echo "last_X_tiles_width = $last_X_tiles_width \n";
		echo "last_Y_tiles_height = $last_Y_tiles_height<br>\n";
		echo "<HR>\n";
	}
	
	$Xzoomed_resolution=$Xresolution*$zoomFactor;

	$res_str=str_replace(".","_",str_replace(",","_",abs($Xzoomed_resolution)) );
	$dir_prefix="mrsid_tiles/".$res_str."/UTM".trim($UTMzone)."/".trim($UTMzoneY).$hemisphere."/";
	$filename_prefix=strtoupper($hemisphere)."-".trim($UTMzone)."-".trim($UTMzoneY)."_";
	
	if ($DEBUG) {echo "PREFIX = ".$dir_prefix.$filename_prefix."<BR>\n"; }
	check_path($dir_prefix);

//	$X_tiles_num=1;
//	$Y_tiles_num=1;
	for ($x=0;$x<$X_tiles_num ;$x++) 
	 for ($y=0;$y<$Y_tiles_num ;$y++) {
	    $filename_base=sprintf("%s%s%03d_%03d",$dir_prefix,$filename_prefix,$x,$y);
		
		$jpg_filename=$filename_base.".jpg";
		$tab_filename=$filename_base.".tab";
	
		if ( !$FORCE_CREATE && file_exists($jpg_filename) &&  file_exists($tab_filename) ) continue;

		if ( $x < ($X_tiles_num-1) ) $this_tile_width =$tiles_width;
		else $this_tile_width =$last_X_tiles_width;
		if ( $y < ($Y_tiles_num-1) ) $this_tile_height =$tiles_height;
		else $this_tile_height =$last_Y_tiles_height;
	
		$this_UL_x=$X_UL + $x*$tiles_width*$Xresolution;
		$this_UL_y=$Y_UL + $y*$tiles_height*$Yresolution;
	
		$this_UL_pixels_x=$x*$tiles_width;
		$this_UL_pixels_y=$y*$tiles_height;

		$this_tile_width_zoomed=floor($this_tile_width/$zoomFactor);
		$this_tile_height_zoomed=floor($this_tile_height/$zoomFactor);
		$this_UL_pixels_x_zoomed =floor($this_UL_pixels_x/$zoomFactor);
		$this_UL_pixels_y_zoomed =floor($this_UL_pixels_y/$zoomFactor);
		//echo $filename_base." ($this_UL_x , $this_UL_y) ".$this_tile_width."x".$this_tile_height." <BR>";	
		if ($zoomFactor < 8 ) $z=($zoomFactor/2);
		else if ($zoomFactor ==8)  $z=3;
		else if ($zoomFactor ==16) $z=4;
		else if ($zoomFactor ==32) $z=5;
		
		$cmd_str="./mrsiddecode -quiet -wf -s $z -i $mrsid_file -o $jpg_filename -ulxy $this_UL_pixels_x_zoomed  $this_UL_pixels_y_zoomed -wh $this_tile_width_zoomed $this_tile_height_zoomed";
									
		// echo "$cmd_str <br>";
		system($cmd_str);

		make_tab_file($tab_filename,$jpg_filename, $this_UL_x , $this_UL_y, $this_tile_width ,$this_tile_height,$Xresolution,$Yresolution);
		
	
	 }
} // end function 

function make_tab_file($tab_filename,$jpg_filename, $this_UL_x , $this_UL_y, $this_tile_width ,$this_tile_height,$Xresolution,$Yresolution) {
	global $zoomFactor;

$txt=sprintf("!table
!version 300
!charset WindowsLatin1

Definition Table
 File '%s'
 Type \"RASTER\"
 (%0.2f, %0.2f) (0,0)Label \"TopLeft\",
 (%0.2f, %0.2f) (%d, 0) Label \"TopRight\",
 (%0.2f, %0.2f) (0, %d) Label \"BottomLeft\",
 (%0.2f, %0.2f) (%d, %d) Label \"BottomRight\"
 CoordSys NonEarth Units m
 Units m" ,$jpg_filename,
	$this_UL_x , $this_UL_y  ,
	$this_UL_x + $this_tile_width * $Xresolution , $this_UL_y , floor($this_tile_width / $zoomFactor ),
	$this_UL_x , $this_UL_y +$this_tile_height * $Yresolution  , floor($this_tile_height /$zoomFactor) ,
	$this_UL_x + $this_tile_width * $Xresolution , $this_UL_y + $this_tile_height * $Yresolution ,floor( $this_tile_width/$zoomFactor)  ,floor($this_tile_height /$zoomFactor)
 );


   if (!$handle = fopen($tab_filename, 'w')) { 
        print "Cannot open file ($tab_filename)"; 
        return 0; 
   }   
   if (!fwrite($handle, $txt)) { 
       print "Cannot write to file ($tab_filename)"; 
       return 0;
   }     
   fclose($handle); 
   return 1;
}

function check_path($dir_file) {
	//$last_seperator=strrpos($cache_file,"/");
	//$path_name=substr($dir_file,0,$last_seperator);
	// echo $path_name;
	exec("mkdir -p ".$dir_file);
}

function getmicrotime(){ 
   list($usec, $sec) = explode(" ",microtime()); 
   return ((float)$usec + (float)$sec); 
} 
?>

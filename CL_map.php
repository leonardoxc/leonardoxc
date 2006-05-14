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

global  $gd2;

class rasterUTM_Map {
	var $MAP_TOP;
	var $MAP_LEFT; 
	var $MAP_BOTTOM;
	var $MAP_RIGHT;
	var $UTMzoneUpLeft;
	var $UTMzoneBottomRight;
	var $UTMlatZoneUpLeft;
	var $UTMlatZoneBottomRight;

	var $pixelWidth, $pixelHeight;

	var $mapWidthMeters;
	var $mapHeightMeters;
	var $metersPerPixel;
	
	var $rasterFilename;
	var $img;

	var $min_lat;

	function rasterUTM_Map($UTMzoneUpLeft,$UTMlatZoneUpLeft,$MAP_TOP,$MAP_LEFT,$UTMzoneBottomRight,$UTMlatZoneBottomRight,$MAP_BOTTOM,$MAP_RIGHT,$rasterFilename,$pixelWidth=0,$pixelHeight=0) {	
		global $moduleRelPath, $mapsPath ;
		$this->MAP_TOP    =$MAP_TOP;
		$this->MAP_LEFT   =$MAP_LEFT;
		$this->MAP_BOTTOM =$MAP_BOTTOM;
		$this->MAP_RIGHT  =$MAP_RIGHT;
		$this->UTMzoneUpLeft		=$UTMzoneUpLeft;
		$this->UTMzoneBottomRight	=$UTMzoneBottomRight;
		$this->UTMlatZoneUpLeft		=$UTMlatZoneUpLeft;
		$this->UTMlatZoneBottomRight=$UTMlatZoneBottomRight;

		DEBUG("MAP",1,"new rasterUTM_Map(): (right, left) :".$MAP_RIGHT." [".$UTMzoneBottomRight."] ,".$MAP_LEFT."[".$UTMzoneUpLeft."]#<BR>");

		if ($this->UTMzoneUpLeft==$this->UTMzoneBottomRight	) {  // one UTM zone -> simple
			$this->mapWidthMeters=$this->MAP_RIGHT-$this->MAP_LEFT;
		} else { // transform to latlon
			list($max_lon,$max_lat )=iutm($MAP_LEFT,$MAP_TOP, $UTMzoneUpLeft,$UTMlatZoneUpLeft) ;
			list($min_lon,$min_lat)=iutm($MAP_RIGHT, $MAP_BOTTOM , $UTMzoneBottomRight,$UTMlatZoneBottomRight) ;

// TEST MANOLIS 
			$this->min_lat=$min_lat;

			$BottomRight_zoneWidth=getUTMZoneWidth($min_lat);
			$this->MAP_RIGHT =$this->MAP_RIGHT +$BottomRight_zoneWidth;
			$this->UTMzoneBottomRight= $this->UTMzoneUpLeft;

		DEBUG("MAP",1,"rasterUTM_Map: flight spans to multiple UTM zones<BR>");
		DEBUG("MAP",1,"rasterUTM_Map: min_lat:$min_lat, min_lon:$min_lon, max_lat:$max_lat, max_lon:$max_lon <BR>");
		DEBUG("MAP",1,"rasterUTM_Map: MAP (right, left) :".$this->MAP_RIGHT." [".$this->UTMzoneBottomRight."] ,".$MAP_LEFT."[".$UTMzoneUpLeft."]#<BR>");

			$totalWidth1=calc_distance($min_lat, $min_lon,$min_lat, $max_lon);
			$totalWidth2=calc_distance($max_lat, $min_lon,$max_lat, $max_lon);
			$totalWidth=max($totalWidth1,$totalWidth2);
			$this->mapWidthMeters=$totalWidth;
		}
		$this->mapHeightMeters=$this->MAP_TOP-$this->MAP_BOTTOM;
		
		if ($rasterFilename=="") {
			$this->pixelWidth =$pixelWidth;
			$this->pixelHeight=$pixelHeight;
		} else {
			$this->rasterFilename= $mapsPath."/".$rasterFilename;		
			$this->img =0;
			$this->img = @imagecreatefromjpeg($this->rasterFilename);		
			if (!$this->img ) {  // failed to open jpeg
				$this->pixelWidth=0;
				$this->pixelHeight=0;		
			} else {				
				$this->pixelWidth=imagesx($this->img);
				$this->pixelHeight=imagesy($this->img);		
			}
		}
		if ( $this->pixelWidth >0 ) $this->metersPerPixel = $this->mapWidthMeters / $this->pixelWidth ;
		else $this->metersPerPixel =0;
		// echo "metersPerPixel : ".$this->metersPerPixel."<BR>";
		
	}		

	function destroy() {
		if ($this->rasterFilename!="" && $this->img ) imagedestroy ($this->img);
	}	
	
	function lonlat2xy($lon, $lat) {
		list($UTMx, $UTMy,$zone,$UTMlatZone)=utm($lon, $lat);
		
		if ($zone==$this->UTMzoneUpLeft) {
			list($x,$y)=$this->UTM2xy($UTMx, $UTMy);
			DEBUG("MAP",32,"-");
		} else if ($zone==$this->UTMzoneBottomRight) {
			list($x,$y)=$this->UTM2xyFromBottomRight($UTMx, $UTMy);
			DEBUG("MAP",32,"+");
		} else if ($zone==($this->UTMzoneUpLeft+1)) {  
			// TRANSFORM the UTMx coorditnates from the the next zone to this
			// this is the WRONG but quick way to do it !!!!!
			DEBUG("MAP",32,"*");
			$UTMx+= getUTMZoneWidth($lat);
			//$UTMx+= getUTMZoneWidth($this->min_lat);
			list($x,$y)=$this->UTM2xy($UTMx, $UTMy);
			
		}
		DEBUG("MAP",32,"lonlat2xy: lon:".sprintf("%.4f",$lon).", lat:".sprintf("%.4f",$lat)." -> X:".floor($UTMx).", Y:".floor($UTMy).", zn:$zone (".$this->UTMzoneBottomRight."), latZn:$UTMlatZone
 -> x:".round($x).", y:".round($y)."<br>");
		return array(round($x),round($y));
	}

	function UTM2xy($UTMx, $UTMy)
	{  			
		$x = ( ( $UTMx - $this->MAP_LEFT ) / ($this->mapWidthMeters / $this->pixelWidth   ) );
		$y =  ( $UTMy - $this->MAP_BOTTOM) / ($this->mapHeightMeters / $this->pixelHeight  );	
		return array(round($x), round($y));
	}
	
	function UTM2xyFromBottomRight($UTMx, $UTMy)
	{  			
		$x = $this->pixelWidth   - ( ( $this->MAP_RIGHT - $UTMx ) / ($this->mapWidthMeters / $this->pixelWidth   ) );
		$y =  ( $UTMy - $this->MAP_BOTTOM) / ($this->mapHeightMeters / $this->pixelHeight  );	
		return array(round($x), round($y));
	}

	function isPointInsideMap($pointX,$pointY,$pointUTMzone, $pointUTMlatZone) {
		if ( $this->UTMzoneUpLeft == $pointUTMzone ) {
			 if ( $this->MAP_LEFT <=  $pointX &&  $this->MAP_RIGHT >= $pointX && 
				  $this->MAP_TOP  >=  $pointY  && $this->MAP_BOTTOM <= $pointY) return 1;
			 else return 0;
		} else if ( $pointUTMzone == ($this->UTMzoneUpLeft +1) ){			 
			 list($lon,$lat)=iutm($pointX, $point, $pointUTMzone, $pointUTMlatZone) ;
			 $pointX+= getUTMZoneWidth($lat);
			 if ( $this->MAP_LEFT <=  $pointX &&  $this->MAP_RIGHT >= $pointX && 
				  $this->MAP_TOP  >=  $pointY  && $this->MAP_BOTTOM <= $pointY) return 1;
			 else return 0;
		}
	    else return 0;	
	}
		
}

class flightMap extends rasterUTM_Map {
	var $IGCfilename;
	var $outputFilename;

	var $showTrack=1;
	var $showWaypoints=1;
	var $is3D=1;
	function flightMap($UTMzoneUpLeft,$UTMlatZoneUpLeft,$MAP_TOP,$MAP_LEFT,$UTMzoneBottomRight,$UTMlatZoneBottomRight,$MAP_BOTTOM,$MAP_RIGHT,$pixelWidth, $pixelHeight,$IGCfilename,$outputFilename,$is3D=1) {	
		DEBUG("MAP",1,"new flightMap(): (right, left) :".$MAP_RIGHT." [".$UTMzoneBottomRight."] ,".$MAP_LEFT."[".$UTMzoneUpLeft."]#<BR>");
		$this->rasterUTM_Map($UTMzoneUpLeft,$UTMlatZoneUpLeft,$MAP_TOP,$MAP_LEFT,$UTMzoneBottomRight,$UTMlatZoneBottomRight,$MAP_BOTTOM,$MAP_RIGHT,"",$pixelWidth,$pixelHeight);

		$this->IGCfilename=$IGCfilename;
		$this->outputFilename=$outputFilename;

		$this->is3D=$is3D;
		$this->showTrack=1;
		$this->showWaypoints=1;
	}
	
	function requiredMetersPerPixel() {
	  global  $maxMrSidResolution, $minMrSidResolution; 
	  //	note that $minMrSidResolution is >= $maxMrSidResolution

	  for ($i=$minMrSidResolution; $i>=$maxMrSidResolution;$i=$i/2) {
		 if ($this->metersPerPixel >= $i ) return $i;
	  }
	  // if all else fails return $maxMrSidResolution
	  return $maxMrSidResolution;

	}

	function findThisPointMap($pointX,$pointY,$pointUTMzone,$pointUTMlatZone) {
		global $db,$mapsTable ;
        global $minMrSidResolution; 
		$requiredMetersPerPixel=$this->requiredMetersPerPixel();
	    // echo "requiredMetersPerPixel=$requiredMetersPerPixel <BR>";

//		while ($requiredMetersPerPixel <= $minMrSidResolution )  {  
//		while ($requiredMetersPerPixel == $minMrSidResolution )  {  
			// FIND THE MAP THAT includes the given point 
			$query="select * FROM $mapsTable WHERE  ( ".$requiredMetersPerPixel."= metersPerPixel ) AND ( UTMzone=".$pointUTMzone."  OR UTMzone=".($pointUTMzone+1)." ) ";

			DEBUG("MAP",8,"query: $query<BR>");
			$res= $db->sql_query($query);	
			# Error checking
			$foundMap=0;

			//echo  " FLIGHT ## $this->UTMzoneUpLeft , $this->MAP_TOP , $this->MAP_LEFT , $this->MAP_BOTTOM , $this->MAP_RIGHT <BR>" ;
			if($res <= 0){  echo("<H3> Error in getting maps query! </H3>\n");  }
			while ($row = mysql_fetch_assoc($res)) { 			
				$filename=$row["filename"];
				$leftX	=$row["leftX"];
				$topY	=$row["topY"];
				$rightX	=$row["rightX"];
				$bottomY=$row["bottomY"];
				$UTMzone=$row["UTMzone"];
				$pixelHeight=$row["pixelHeight"];
				$pixelWidth=$row["pixelWidth"];
				$filenameParts=explode("/",$filename); 
				$lon=0;
				$lat=substr($filenameParts[2],0,2);
				if ( strtolower (substr($filenameParts[2],2,1) ) == 's' ) $lat=-$lat;
				// 28_5/UTM34/35n/N-34-35_009_011.jpg
				list($UTMzone2,$UTMlatZone)=getUTMzone($lon, $lat);
				//DEBUG("MAP",8,"Tile UTMlatZone=$UTMlatZone, looking for $pointUTMlatZone #$filename ");

				//echo " GOT ------> $UTMzone  , $UTMlatZone , $topY , $leftX, $bottomY , $rightX , $filename <br>";
				// echo " LOOKING --> $pointUTMzone $pointX , $pointY<br>";

$lz1=getInvLatUTMzone($UTMlatZone);
$lz2=getInvLatUTMzone($pointUTMlatZone) ;
				if (	$lz1!=$lz2 && $lz1!=($lz2+1) && $lz1!=($lz2-1)) { 
//DEBUG("MAP",64,"NOT equal<br>");
 continue; 
}
else { 
DEBUG("MAP",8,"Tile UTMlatZone=$UTMlatZone, ($lz1,$lz2) looking for $pointUTMlatZone #$filename <br>");

//DEBUG("MAP",8,"Correct UTMlatZone<br>");
 }

				//	find the map that has the upper left corner of the flight's rectangle
				if ( $UTMzone == $pointUTMzone ) {
					if ( $leftX <=  $pointX &&  $rightX >= $pointX && $topY >=  $pointY  && $bottomY <= $pointY ) {
						 $foundMap=1;
						DEBUG("MAP",8,"FOUND map 1::");
					}
				} else if ( ($pointUTMzone +1) == $UTMzone  ) {

					// echo "pointUTMzone = $pointUTMzone , UTMzone = $UTMzone <br>";
					list($this_lon_top,$this_lat_top)=iutm($rightX, min($topY,$this->MAP_TOP) , $UTMzone,$UTMlatZone) ;
					list($this_lon_bottom,$this_lat_bottom)=iutm($rightX, max($bottomY,$this->MAP_BOTTOM) , $UTMzone,$UTMlatZone) ;

					// get the middle lat of the tile
					$this_lat=$this_lat_bottom + ($this_lat_top - $this_lat_bottom) / 2; 
		
					$zoneWidth=getUTMZoneWidth($this_lat);
					$leftX+=$zoneWidth;
					$rightX+=$zoneWidth;

					if ( $leftX <=  $pointX &&  $rightX >= $pointX && $topY >=  $pointY  && $bottomY <= $pointY  ) {
						DEBUG("MAP",8,"FOUND map 2::");
						$UTMzone--;
						$foundMap=1;
					}
				}

				if ($foundMap) {
					DEBUG("MAP",8,"Found MAP --> ZONE: $UTMzone , $UTMlatZone ( $lat ) , TOP: $topY , LEFT: $leftX, BOTOM: $bottomY , RIGHT: $rightX , $filename <br>");
					// flush();
					// A UTM map has always the same $UTMzone for its corners
					$jpegMap=new rasterUTM_Map( $UTMzone, $UTMlatZone,$topY ,$leftX,$UTMzone,$UTMlatZone,$bottomY ,$rightX , $filename);
					if ($jpegMap->pixelWidth)  return $jpegMap;
					else { 
						DEBUG("MAP",2,"Could not Read Map $filename <br>");
						$jpegMap->destroy();
						return new rasterUTM_Map(0,"",0,0,0,"",0,0,"",0,0);
					}
					// break;
				}
			}

			// havent found anything so we look for less good maps
			// echo $requiredMetersPerPixel."<BR>";
			$requiredMetersPerPixel=$requiredMetersPerPixel*2;
//		} //end of while

		$jpegMap=new rasterUTM_Map(0,"",0,0,0,"",0,0,"",0,0);
		return $jpegMap;
	}

	function drawFlightMap() {	
		global $gd2;
	  	$source_width   = $this->mapWidthMeters;
	  	$source_height  = $this->mapHeightMeters;
		
		 // echo "## source_width= $source_width , source_height= $source_height <br>";

	  	$dest_width_max   = $this->pixelWidth;
	  	$dest_height_max  = $this->pixelHeight;
	  	// The two lines beginning with (int) are the super important magic formula part.
		// use this if you want the resulting image to fit both on 	$dest_width_max  AND 	$dest_height_max 
//	  	(int)$dest_width  = ($source_width <= $source_height) ? round(($source_width  * $dest_height_max)/$source_height) : $dest_width_max;
//	  	(int)$dest_height = ($source_width >  $source_height) ? round(($source_height * $dest_width_max) /$source_width)  : $dest_height_max;
		// WE ONLY WANT THE $dest_width_max 
	  	(int)$dest_width  = $dest_width_max;
	  	(int)$dest_height = round( ($source_height * $dest_width_max) / $source_width) ;
  
  
   		/*   
			// do not do magnification 	
			if ($dest_width > $source_width ) {
			$dest_width = $source_width;
			$dest_height = $source_height;
	   	}
		*/

		$this->pixelWidth =$dest_width;
		$this->pixelHeight=$dest_height;

		 // echo "FINAL widthx height $dest_width , $dest_height<br>";
// return;
		   if (function_exists("gd_info")) {
			   $gdinfo=gd_info();
			   if ( strpos($gdinfo["GD Version"],"2.") ) $gd2=true;
			   else $gd2=false;
		   } else $gd2=false;
	
		   if ( $gd2 )  $this->img=imagecreatetruecolor($dest_width,$dest_height);
		   else $this->img=imagecreate($dest_width,$dest_height);
		   
		$backColor =imagecolorallocate ($this->img,214,223,209);
		// $backColor =imagecolorallocate ($this->img,73,76,50);
		if ($backColor==-1) echo "FAILED TO allocate new color<br>";
		// imagefill($this->img,0,0, 1 );	
		imagefilledrectangle($this->img, 0, 0, $dest_width-1, $dest_height-1, $backColor);

		//echo "MAP coords : $this->MAP_TOP ,$this->MAP_BOTTOM , $this->MAP_LEFT $this->MAP_RIGHT <br>"; 
		//echo "DETAILS: $this->UTMzoneUpLeft,$this->UTMzoneBottomRight,$this->UTMlatZoneUpLeft,$this->UTMlatZoneBottomRight ,  $this->pixelWidth, $this->pixelHeight, $this->mapWidthMeters, $this->mapHeightMeters,$this->metersPerPixel, $this->rasterFilename ";

		$topCorner = $this->MAP_TOP ;
		$passedOneTimeVer=0;
		// if ($this->UTMzoneUpLeft != $this->UTMzoneBottomRight) $passedOneTimeVer=1;

		while ( ! $passedOneTimeVer  ) {

			if ( $topCorner < $this->MAP_BOTTOM ) $passedOneTimeVer=1;
			$mapHeight=0;
			$leftCorner = $this->MAP_LEFT ;
			$passedOneTimeHor=0;
			while ( ! $passedOneTimeHor ) {
				if ( $leftCorner > $this->MAP_RIGHT ) $passedOneTimeHor=1;
				$jpegMap= $this->findThisPointMap( $leftCorner, $topCorner ,$this->UTMzoneUpLeft,$this->UTMlatZoneUpLeft); 
				if ($jpegMap->pixelWidth !=0 ) {
					$this->plotMap($jpegMap);
					// $leftCorner += $jpegMap->mapWidthMeters;
					// better one this below ...
					$leftCorner = $jpegMap->MAP_RIGHT + 1;
					// $mapHeight=$jpegMap->mapHeightMeters;
					//  was wrong
					$mapHeight= $jpegMap->MAP_BOTTOM  -1; 
					$jpegMap->destroy();
				} else { // no map found here
					DEBUG("MAP",8,"no map found here ... scanning to the right<br>");
					$leftCorner +=5000 ; // scan 5000 m to the right
					$lll++;
					if ($lll>500) { DEBUG("MAP",64,"max reached<br>"); break; }
				}
			} 

			if ( $mapHeight==0) { 					
				 //echo "no map found here ... scanning to the bottom<br>";
				 $topCorner-=5000;
			} else {	
				 // echo "reducing  topCorner ($topCorner)  by $mapHeight ... (" .$this->MAP_BOTTOM." ) scanning to the bottom<br>";
				  // echo "reducing  topCorner ($topCorner)  setting it = $mapHeight <br>";
				 // $topCorner-=$mapHeight;
				 // was wrong see above
				 $topCorner=$mapHeight;
				 // echo "# $topCorner = $mapHeight #";
			}

		}

		if ( $this->showTrack ) {
			$this->makeGradient(150) ;
			$this->drawFlight();
		}
		if ($this->showWaypoints) $this->drawWaypoints();		
		if ( $this->showTrack && $this->is3D ) $this->drawGradientBar();

		imagejpeg($this->img, $this->outputFilename , 85);
		imagedestroy($this->img);

	}	
	
	function plotMap($map) {
		global $gd2;
		set_time_limit (200);
		if ($map->pixelHeight==0 || $map->pixelWidth==0 ) return;

		if ($this->UTMzoneUpLeft!=$this->UTMzoneBottomRight) {
			
			list($BottomRight_lon,$BottomRight_lat)=iutm($this->MAP_RIGHT, $this->MAP_BOTTOM, $this->UTMzoneBottomRight,$this->UTMlatZoneBottomRight) ;
			$BottomRight_zoneWidth=getUTMZoneWidth($BottomRight_lat);
			$mapRectLeft  	= max($this->MAP_LEFT,$map->MAP_LEFT); 
			$mapRectRight 	= min ($this->MAP_RIGHT+$BottomRight_zoneWidth,$map->MAP_RIGHT);

			$mapRectTop     = min($this->MAP_TOP,$map->MAP_TOP); 
			$mapRectBottom  = max($this->MAP_BOTTOM,$map->MAP_BOTTOM); 

			list($mapRectLeftPixels , $mapRectTopPixels)=$map->UTM2xy( $mapRectLeft,	$mapRectTop );		
			//list($mapRectRightPixels , $mapRectBottomPixels)=$map->UTM2xyFromBottomRight( $mapRectRight,	$mapRectBottom ); 
			list($mapRectRightPixels , $mapRectBottomPixels)=$map->UTM2xy( $mapRectRight,	$mapRectBottom ); 
			//$mapRectRightPixels=$mapRectLeftPixels+$map->pixelWidth;

			list($flightRectLeftPixels , $flightRectTopPixels)=$this->UTM2xy( $mapRectLeft,	$mapRectTop );
//			list($flightRectRightPixels , $flightRectBottomPixels)=$this->UTM2xyFromBottomRight( $mapRectRight,	$mapRectBottom );
			list($flightRectRightPixels , $flightRectBottomPixels)=$this->UTM2xy( $mapRectRight,	$mapRectBottom );

		} else {
			$mapRectLeft  	= max($this->MAP_LEFT,$map->MAP_LEFT); 
			$mapRectRight 	= min ($this->MAP_RIGHT,$map->MAP_RIGHT);

			$mapRectTop     = min($this->MAP_TOP,$map->MAP_TOP); 
			$mapRectBottom  = max($this->MAP_BOTTOM,$map->MAP_BOTTOM); 

			list($mapRectLeftPixels , $mapRectTopPixels)=$map->UTM2xy( $mapRectLeft,	$mapRectTop );			
			list($mapRectRightPixels , $mapRectBottomPixels)=$map->UTM2xy( $mapRectRight,	$mapRectBottom );

			list($flightRectLeftPixels , $flightRectTopPixels)=$this->UTM2xy( $mapRectLeft,	$mapRectTop );
			list($flightRectRightPixels , $flightRectBottomPixels)=$this->UTM2xy( $mapRectRight,	$mapRectBottom );

		}		
		
		//		list($mapRectRightPixels , $mapRectBottomPixels)=$map->UTM2xy( $mapRectRight,	$mapRectBottom );
		//		$mapRectRightPixels=$mapRectLeftPixels+$map->pixelWidth;
		//		$mapRectBottomPixels=$mapRectTopPixels-$map->pixelHeight;

		//echo "Ploting map: top   left   corner in pixels  $mapRectTopPixels , $mapRectLeftPixels <br>";
		// echo "Ploting map: bottom right corner in pixels  $mapRectBottomPixels , $mapRectRightPixels <br>";
		
		// $flightRectRightPixels=$flightRectLeftPixels+$this->pixelWidth;
		//echo "Ploting flight: top   left   corner in pixels  $flightRectTopPixels ,  $flightRectLeftPixels <br>";
		//echo "Ploting flight: bottom right corner in pixels  $flightRectBottomPixels , $flightRectRightPixels <br>";

		/*echo " %% $flightRectLeftPixels, ".( $this->pixelHeight -  $flightRectTopPixels).", 
		 $mapRectLeftPixels , ".($map->pixelHeight - $mapRectTopPixels).", 
		 ".($flightRectRightPixels-$flightRectLeftPixels)."	, ".( $flightRectTopPixels- $flightRectBottomPixels ).",   
		 ".($mapRectRightPixels - $mapRectLeftPixels	)."	,  ".($mapRectTopPixels- $mapRectBottomPixels). " %%<br> ";
		 */
		 	
		if ($gd2) {
			imagecopyresampled($this->img, $map->img, 
			 $flightRectLeftPixels, $this->pixelHeight -  $flightRectTopPixels, // dstX, int dstY 
			 $mapRectLeftPixels , $map->pixelHeight - $mapRectTopPixels,  //  srcX, int srcY
			 $flightRectRightPixels-$flightRectLeftPixels	, $flightRectTopPixels- $flightRectBottomPixels ,   // dstW, int dstH
			 $mapRectRightPixels - $mapRectLeftPixels		, $mapRectTopPixels- $mapRectBottomPixels); // srcW, int srcH 		
		} else {
			imagecopyresized($this->img, $map->img, 
			 $flightRectLeftPixels, $this->pixelHeight -  $flightRectTopPixels, // dstX, int dstY 
			 $mapRectLeftPixels , $map->pixelHeight - $mapRectTopPixels,  //  srcX, int srcY
			 $flightRectRightPixels-$flightRectLeftPixels	, $flightRectTopPixels- $flightRectBottomPixels ,   // dstW, int dstH
			 $mapRectRightPixels - $mapRectLeftPixels		, $mapRectTopPixels- $mapRectBottomPixels); // srcW, int srcH 		
		}

	}
	
	function drawWaypoints() {
		$waypointSize=3;
		$textwaypointColor =imagecolorallocate ($this->img, 255,255,255);
		$textShadowCol= imagecolorallocate ($this->img, 33,33,33);
		$waypoints=getWaypoints();
		foreach($waypoints as $waypoint) {
			list($UTMx, $UTMy,$zone,$UTMlatZone)=utm(-$waypoint->lon, $waypoint->lat);
			//x==lon
			//y==lat
			if ( $zone==$this->UTMzoneUpLeft &&	$this->MAP_TOP  >=	$UTMy &&  $this->MAP_LEFT  <= $UTMx && 
					$this->MAP_BOTTOM <=  $UTMy && $this->MAP_RIGHT >= $UTMx  ) {

				list($x,$y)= $this->UTM2xy($UTMx, $UTMy);
				$y=$this->pixelHeight-$y;

				$this->renderWaypoint($x,$y,$waypoint->type);
				// imagefilledrectangle($this->img,$x-$waypointSize,$y-$waypointSize,$x+$waypointSize,$y+$waypointSize,$waypointColor );		
				$this->putStringShadow( 2, $x,$y+$waypointSize +2, $waypoint->intName, $textwaypointColor ,$textShadowCol );	
			}
		}

	}

	function renderWaypoint($x,$y,$type) {
		if ($type>=1 && $type<=5 ) { // cities 1-small, 5-biggest )
			$waypointSize=3+$type*2;	 
			$waypointColor =imagecolorallocate ($this->img, 100,85,200);
			$shadowColor =imagecolorallocate ($this->img, 33,33,33);
			imagefilledellipse ($this->img,$x,$y, $waypointSize, $waypointSize, $shadowColor);
			imagefilledellipse ($this->img,$x-1,$y-1, $waypointSize, $waypointSize, $waypointColor);
		} else if ($type==1000 ) {
			$waypointSize=3;	 // real size = 3+3+1=7
			$waypointColor =imagecolorallocate ($this->img, 250,0,0);
			imagefilledrectangle($this->img,$x-$waypointSize,$y-$waypointSize,$x+$waypointSize,$y+$waypointSize,$waypointColor );		
		} else {
			$waypointColor =imagecolorallocate ($this->img, 250,235,50);
			$shadowColor =imagecolorallocate ($this->img, 33,33,33);

			$values=array($x-4,$y+3,$x,$y-3,$x+4,$y+3);
			imagefilledpolygon($this->img, $values, 3, $shadowColor ); 
			foreach ($values as $i=>$val) $values[$i]=$val-2;
			imagefilledpolygon($this->img, $values, 3, $waypointColor ); 
		}

	}

	function makeGradient($width) {
		global $gradientMap,$gradient_colors_num;

		$gradientMap=array();
		$gradient_colors_num=$width;
		$gradient_colors=array(
			array(255,0,0) ,array( 255,255,0) ,array( 0,255,0) ,
			array ( 0,255,255) ,array (0,0,255), array(255,255,255));

		//	4 colors -> 3 gradient bands
		$gradient_bands=count($gradient_colors)-1;
		$gradient_band_size=floor($gradient_colors_num/$gradient_bands);
		for ($i=0;$i<$gradient_bands ;$i++) {
			$start_indx=$i*	$gradient_band_size;
			$end_indx=($i+1)* $gradient_band_size-1;
			// echo "band #$i: from $start_indx to $end_indx <br>";
			for($k=$start_indx;$k<=$end_indx;$k++) {
				$start_r=$gradient_colors[$i][0];
				$start_g=$gradient_colors[$i][1];
				$start_b=$gradient_colors[$i][2];

				$end_r=$gradient_colors[$i+1][0];
				$end_g=$gradient_colors[$i+1][1];
				$end_b=$gradient_colors[$i+1][2];
				// compute rgb
				$r= $start_r + ($k-$start_indx) * ($end_r-$start_r)/ $gradient_band_size ;
				$g= $start_g + ($k-$start_indx) * ($end_g-$start_g)/ $gradient_band_size ;
				$b= $start_b + ($k-$start_indx) * ($end_b-$start_b)/ $gradient_band_size ;
				array_push ($gradientMap,imagecolorallocate ($this->img, $r,$g,$b) );
			}
		}
	
	}

	function putStringShadow( $fontNum , $x, $y  , $textString , $textCol, $textShadowCol ) {
		if ( $x + imagefontwidth($fontNum)*strlen($textString) >  $this->pixelWidth - 1 )
			$x= $this->pixelWidth - imagefontwidth($fontNum)*strlen($textString) - 1;
			
		for($i=-1;$i<=2;$i++)	
			for ($j=-2;$j<=2;$j++) {
				if ( $i==0 || $j==0) continue;
				imagestring ($this->img , $fontNum , $x+$i, $y+$j ,$textString , $textShadowCol );
			}
		imagestring ($this->img , $fontNum , $x, $y ,$textString , $textCol );
		
	}

	function drawGradientBar() {
		global $gradientMap,$gradient_colors_num;
		global $minAlt,$maxAlt;		

		$width=150;
		$height=16;				

		// from top left corner
		$x1=$this->pixelWidth - $width - 7;
		$y1=$this->pixelHeight - $height - 7;
		$borderCol= imagecolorallocate ($this->img, 0,0,0);
		$textCol= imagecolorallocate ($this->img, 255,255,255);
		$textShadowCol= imagecolorallocate ($this->img, 30,30,30);
		imagerectangle ($this->img ,  $x1,  $y1, $x1+$width, $y1+$height , $borderCol );

		for($i=1;$i<$width;$i++) {
			$gradCol=$gradientMap[ floor(  ($width /$gradient_colors_num) * $i ) ];
			imageline($this->img ,  $x1+$i,  $y1+1, $x1+$i, $y1+$height - 1 , $gradCol);
		}

		$this->putStringShadow( 2 , $x1-10, $y1-15 , $minAlt."m",  $textCol ,$textShadowCol );
		$this->putStringShadow(2, $x1 + $width - 25 , $y1-15 , $maxAlt."m",$textCol ,$textShadowCol );
		// draw the middle
		$middle_alt=floor($minAlt + ($maxAlt - $minAlt) /2);
		$this->putStringShadow(2,$x1 + floor($width /2)- 15 , $y1-15 , $middle_alt."m", $textCol,$textShadowCol );

	}

	
	function drawFlight() {
		global $gradientMap,$gradient_colors_num;
		global $minAlt,$maxAlt;

		$size=1;
		$startSize=10;
		$pointColor=  imagecolorallocate ($this->img, 255,0,0);
		$startColor=  imagecolorallocate ($this->img, 0,250,0);
		$endColor=  imagecolorallocate ($this->img, 252,250,66); // yellow
		$shadowColor=imagecolorallocate ($this->img, 0,0,0);
		
	
		$lines = file ($this->IGCfilename); 
		$points=0;
		$minAlt=10000;
		$maxAlt=0;

		//first pass to find min/max
		foreach($lines as $line) {
			$line=trim($line);
			if  (strlen($line)==0) continue;
			
			if ($line{0}=='B') {
				$thisPoint=new gpsPoint($line);
				$thisAlt=$thisPoint->getAlt();
				if ($thisAlt < $minAlt) $minAlt=$thisAlt;
				if ($thisAlt > $maxAlt) $maxAlt=$thisAlt; 
			}
		}

		// Make shadow first
		foreach($lines as $line) {
			// $line=trim($line);
			if  (strlen($line)==0) continue;
			
			if ($line{0}=='B') {
				$thisPoint=new gpsPoint($line);

				$thisColor= $gradientMap[ floor( ($gradient_colors_num -1) * $altRelPos ) ];

				list($ptX,$ptY) = $this->lonlat2xy( - $thisPoint->lon , $thisPoint->lat);
				//DEBUG("MAP",8,"lon:".$thisPoint->lon." lat:".$thisPoint->lat." -> X:$ptX, Y:$ptY <br>");
				$ptY=$this->pixelHeight-$ptY;

				if  ($points==0)  {
					$firstPoint=new gpsPoint($line);					
				} else  {
					list($lastptX,$lastptY) = $this->lonlat2xy(- $lastPoint->lon , $lastPoint->lat  );
					$lastptY=$this->pixelHeight-$lastptY;
					

					imageline($this->img,$lastptX-1,$lastptY-1,$ptX-1,$ptY-1,$shadowColor);
					imageline($this->img,$lastptX,$lastptY-1,$ptX,$ptY-1,$shadowColor);
					imageline($this->img,$lastptX+1,$lastptY-1,$ptX+1,$ptY-1,$shadowColor);	

					imageline($this->img,$lastptX-1,$lastptY,$ptX-1,$ptY,$shadowColor);
//					imageline($this->img,$lastptX,$lastptY,$ptX,$ptY,$shadowColor);
					imageline($this->img,$lastptX+1,$lastptY,$ptX+1,$ptY,$shadowColor);	

					imageline($this->img,$lastptX-1,$lastptY+1,$ptX-1,$ptY+1,$shadowColor);
					imageline($this->img,$lastptX,$lastptY+1,$ptX,$ptY+1,$shadowColor);
					imageline($this->img,$lastptX+1,$lastptY+1,$ptX+1,$ptY+1,$shadowColor);	
				}
				$lastPoint=new gpsPoint($line);				
				$points++;			   
			}
		}

		DEBUG("MAP",8,"<hr>");
		$points=0;
		foreach($lines as $line) {
			// $line=trim($line);
			if  (strlen($line)==0) continue;
			
			if ($line{0}=='B') {
				$thisPoint=new gpsPoint($line);

				if ( ($maxAlt-$minAlt)  ) $altRelPos= ($thisPoint->getAlt() - $minAlt ) / ($maxAlt-$minAlt) ;			
				else $altRelPos=0;
				$thisColor= $gradientMap[ floor( ($gradient_colors_num -1) * $altRelPos ) ];

				list($ptX,$ptY) = $this->lonlat2xy( - $thisPoint->lon , $thisPoint->lat);
				$ptY=$this->pixelHeight-$ptY;

				if  ($points==0)  {
					$firstPoint=new gpsPoint($line);					
				} else  {
					list($lastptX,$lastptY) = $this->lonlat2xy(- $lastPoint->lon , $lastPoint->lat  );
					$lastptY=$this->pixelHeight-$lastptY;
					
					imageline($this->img,$lastptX,$lastptY,$ptX,$ptY,$thisColor);			
					imageline($this->img,$lastptX,$lastptY+1,$ptX,$ptY+1,$thisColor);							

					// leave this for extra line width + shadow
					// imageline($this->img,$lastptX+1,$lastptY,$ptX+1,$ptY,$shadowColor);							

				}

				$lastPoint=new gpsPoint($line);				
				$points++;			   
			}
		}

		list($ptX,$ptY) = $this->lonlat2xy( - $firstPoint->lon , $firstPoint->lat);
		$ptY=$this->pixelHeight-$ptY;

		imagearc( $this->img,$ptX,$ptY ,$startSize, $startSize, 0,360, $startColor );		
		imagearc( $this->img,$ptX,$ptY ,$startSize-1, $startSize-1, 0,360, $startColor );		

		list($ptX,$ptY) = $this->lonlat2xy( - $lastPoint->lon , $lastPoint->lat);
		$ptY=$this->pixelHeight-$ptY;

		imagearc( $this->img,$ptX+1,$ptY+1 ,$startSize, $startSize, 0,360, $shadowColor );
		imagearc( $this->img,$ptX+1,$ptY+1 ,$startSize-1, $startSize-1, 0,360,$shadowColor );

		imagearc( $this->img,$ptX,$ptY ,$startSize, $startSize, 0,360, $endColor );
		imagearc( $this->img,$ptX,$ptY ,$startSize-1, $startSize-1, 0,360, $endColor );

	} // end function

} // end of class flightMap

?>

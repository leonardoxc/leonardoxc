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

// create img
$lat=$_GET['lat']+0.0;
$lon=$_GET['lon']+0.0;

  if ($_GET['type']=="small") $globeFilename="images/earth_340_170.jpg";
  else  $globeFilename="images/earth_2400_1200.jpg";
//  else  $globeFilename="images/earth_1280_640.jpg";
  $globalMap = imagecreatefromjpeg($globeFilename);
  $dotColor =imagecolorallocate ( $globalMap , 250,0,0);
  $waypointSize=3;
	  
	$zoomFactor=  $_GET['zoomFactor']+0;
	if (!$zoomFactor) $zoomFactor=1;
	
	if ($_GET['type']=="big") {
		$src_width=imagesx($globalMap);
		$src_height=imagesy($globalMap);
	
		  $x= imagesx($globalMap)/2 - (imagesx($globalMap)/360) * $lon;
		  $y= (imagesy($globalMap)/2 - (imagesy($globalMap)/180)* $lat);

		$dest_width=340;
		$dest_height=170;
		
		$zoom_window_width=$dest_width/$zoomFactor;
		$zoom_window_height=$dest_height/$zoomFactor;

		
		   if (function_exists("gd_info")) {
			   $gdinfo=gd_info();
			   if ( strpos($gdinfo["GD Version"],"2.") === false ) $gd2=0;
			   else $gd2=1;
		   } else $gd2=false;
	
		   if ( $gd2 )  $img=imagecreatetruecolor($dest_width,$dest_height);
		   else $img=imagecreate($dest_width,$dest_height);
		   
		   imagecopyresampled($img,$globalMap,0,0,$x-$zoom_window_width/2 , $y-$zoom_window_height/2, $dest_width, $dest_height,$zoom_window_width, $zoom_window_height);

		$x=$dest_width/2;
		$y=$dest_height/2;
		   imagefilledrectangle($img,$x-$waypointSize,$y-$waypointSize,$x+$waypointSize,$y+$waypointSize, $dotColor   );
		    Header( "Content-Type: image/jpeg");
		   imagejpeg($img,'',90 );
		   
  } else {	
	  $x= imagesx($globalMap)/2 - (imagesx($globalMap)/360) * $lon;
	  $y= (imagesy($globalMap)/2 - (imagesy($globalMap)/180)* $lat);
	  for ($i=0;$i<5;$i++) 
 	   imagearc($globalMap,$x,$y,$waypointSize*2+$i,$waypointSize*2+$i,0,360, $dotColor   );

	    Header( "Content-Type: image/jpeg");
   		imagejpeg($globalMap,'',90 );

  }
  


?>
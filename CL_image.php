<?
/************************************************************************/
/* Leonardo: Gliding XC Server					                        */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2004-5 by Andreadakis Manolis                          */
/* http://leonardo.thenet.gr                                            */
/* http://sourceforge.net/projects/leonardoserver                       */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

class CLimage {
	function CLimage() {

	}


	function validJPGfilename($filename) {
		$filename=strtolower($filename);
		if ( strtolower(substr($filename,-4))==".jpg" || strtolower(substr($filename,-5))==".jpeg" ) return 1;
		return 0;
	}
	
	function validJPGfile($filename) {
		  $im = getimagesize($filename);
		  if ($im[0] && $im[1]) return 1;
		  else return 0;
	}



	function getJPG_NewSize($forcedwidth, $forcedheight, $source_width, $source_height)
	{	
		$dest_width_max   = $forcedwidth;
		$dest_height_max  = $forcedheight;
		// The two lines beginning with (int) are the super important magic formula part.
		(int)$dest_width  = ($source_width <= $source_height) ? round(($source_width  * $dest_height_max)/$source_height) : $dest_width_max;
		(int)$dest_height = ($source_width >  $source_height) ? round(($source_height * $dest_width_max) /$source_width)  : $dest_height_max;
		
		if ($dest_width > $source_width ) {
			$dest_width = $source_width;
			$dest_height = $source_height;
		}
		return array($dest_width,$dest_height);
	}
	
	
	function resizeJPG($forcedwidth, $forcedheight, $sourcefile, $destfile, $imgcomp)
	{
		$g_imgcomp=100-$imgcomp;
		$g_srcfile=$sourcefile;
		$g_dstfile=$destfile;
		$g_fw=$forcedwidth;
		$g_fh=$forcedheight;
		if(file_exists($g_srcfile))
		{
		  $image_details = getimagesize($g_srcfile);
		  $source_width  = $image_details[0];
		  $source_height = $image_details[1];
	
		  $dest_width_max   = $forcedwidth;
		  $dest_height_max  = $forcedheight;
		  // The two lines beginning with (int) are the super important magic formula part.
		  (int)$dest_width  = ($source_width <= $source_height) ? round(($source_width  * $dest_height_max)/$source_height) : $dest_width_max;
		  (int)$dest_height = ($source_width >  $source_height) ? round(($source_height * $dest_width_max) /$source_width)  : $dest_height_max;
	  
		   if ($dest_width > $source_width ) {
				$dest_width = $source_width;
				$dest_height = $source_height;
		   }
	
		   $img_src=imagecreatefromjpeg($g_srcfile);
	
		   if (function_exists("gd_info")) {
			   $gdinfo=gd_info();
			   if ( strpos($gdinfo["GD Version"],"2.") ===false ) $gd2=0;
			   else $gd2=1;
		   } else $gd2=false;
	
		   if ( $gd2 ) { 
			   $img_dst=imagecreatetruecolor($dest_width,$dest_height);
			   imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $dest_width, $dest_height,  $source_width, $source_height);
			} else {
			   $img_dst=imagecreate($dest_width,$dest_height);
			   imagecopyresized($img_dst, $img_src, 0, 0, 0, 0, $dest_width, $dest_height,  $source_width, $source_height);
			}
	
			imagejpeg($img_dst, $g_dstfile, $g_imgcomp);
			imagedestroy($img_dst);
			return true;
		}
		else
			return false;
	}

}

?>
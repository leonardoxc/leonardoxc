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
		   		if ( $sourcefile == $destfile) { 
					// if the current image is small enough, 
					// and is an overright of it's self
					// dont do anything
					return true; 
				}
				$dest_width = $source_width;
				$dest_height = $source_height;
		   }
	
	
			// get exif info
			//require_once dirname(__FILE__).'/lib/phpexifrw/exifWriter.inc';
			//$exif = new phpExifWriter($g_srcfile);
			// $exif->getImageInfo();

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
			//$exif->writeImage($g_dstfile.'.exif.jpg');
			imagedestroy($img_dst);
			return true;
		}
		else
			return false;
	}



	/******************************************************************************
	*
	* Function:     get_jpeg_header_data
	*
	* Description:  Reads all the JPEG header segments from an JPEG image file into an
	*               array
	*
	* Parameters:   filename - the filename of the file to JPEG file to read
	*
	* Returns:      headerdata - Array of JPEG header segments
	*               FALSE - if headers could not be read
	*
	******************************************************************************/
	
	function getExifData( $filename )
	{
	
			// prevent refresh from aborting file operations and hosing file
			ignore_user_abort(true);
	
	
			// Attempt to open the jpeg file - the at symbol supresses the error message about
			// not being able to open files. The file_exists would have been used, but it
			// does not work with files fetched over http or ftp.
			$filehnd = @fopen($filename, 'rb');
	
			// Check if the file opened successfully
			if ( ! $filehnd  )
			{
					// Could't open the file - exit
					echo "<p>Could not open file $filename</p>\n";
					return FALSE;
			}
	
	
			// Read the first two characters
			$data = fread( $filehnd, 2 );
	
			// Check that the first two characters are 0xFF 0xDA  (SOI - Start of image)
			if ( $data != "\xFF\xD8" )
			{
					// No SOI (FF D8) at start of file - This probably isn't a JPEG file - close file and return;
					echo "<p>This probably is not a JPEG file</p>\n";
					fclose($filehnd);
					return FALSE;
			}
	
	
			// Read the third character
			$data = fread( $filehnd, 2 );
	
			// Check that the third character is 0xFF (Start of first segment header)
			if ( $data{0} != "\xFF" )
			{
					// NO FF found - close file and return - JPEG is probably corrupted
					fclose($filehnd);
					return FALSE;
			}
	
			// Flag that we havent yet hit the compressed image data
			$hit_compressed_image_data = FALSE;
	
	
			// Cycle through the file until, one of: 1) an EOI (End of image) marker is hit,
			//                                       2) we have hit the compressed image data (no more headers are allowed after data)
			//                                       3) or end of file is hit
	
			while ( ( $data{1} != "\xD9" ) && (! $hit_compressed_image_data) && ( ! feof( $filehnd ) ))
			{
					// Found a segment to look at.
					// Check that the segment marker is not a Restart marker - restart markers don't have size or data after them
					if (  ( ord($data{1}) < 0xD0 ) || ( ord($data{1}) > 0xD7 ) )
					{
							// Segment isn't a Restart marker
							// Read the next two bytes (size)
							$sizestr = fread( $filehnd, 2 );
	
							// convert the size bytes to an integer
							$decodedsize = unpack ("nsize", $sizestr);
	
							// Save the start position of the data
							$segdatastart = ftell( $filehnd );
	
							// Read the segment data with length indicated by the previously read size
							$segdata = fread( $filehnd, $decodedsize['size'] - 2 );
	
	
							// Store the segment information in the output array
							$headerdata[] = array(  "SegType" => ord($data{1}),
													"SegName" => $GLOBALS[ "JPEG_Segment_Names" ][ ord($data{1}) ],
													"SegDesc" => $GLOBALS[ "JPEG_Segment_Descriptions" ][ ord($data{1}) ],
													"SegDataStart" => $segdatastart,
													"SegData" => $segdata );
					}
	
	
					// If this is a SOS (Start Of Scan) segment, then there is no more header data - the compressed image data follows
					if ( $data{1} == "\xDA" )
					{
							// Flag that we have hit the compressed image data - exit loop as no more headers available.
							$hit_compressed_image_data = TRUE;
					}
					else
					{
							// Not an SOS - Read the next two bytes - should be the segment marker for the next segment
							$data = fread( $filehnd, 2 );
	
							// Check that the first byte of the two is 0xFF as it should be for a marker
							if ( $data{0} != "\xFF" )
							{
									// NO FF found - close file and return - JPEG is probably corrupted
									fclose($filehnd);
									return FALSE;
							}
					}
			}
	
			// Close File
			fclose($filehnd);
			// Alow the user to abort from now on
			ignore_user_abort(false);
	
			// Return the header data retrieved
			return $headerdata;
	}



	/******************************************************************************
	*
	* Function:     put_jpeg_header_data
	*
	* Description:  Writes JPEG header data into a JPEG file. Takes an array in the
	*               same format as from get_jpeg_header_data, and combines it with
	*               the image data of an existing JPEG file, to create a new JPEG file
	*               WARNING: As this function will replace all JPEG headers,
	*                        including SOF etc, it is best to read the jpeg headers
	*                        from a file, alter them, then put them back on the same
	*                        file. If a SOF segment wer to be transfered from one
	*                        file to another, the image could become unreadable unless
	*                        the images were idenical size and configuration
	*
	*
	* Parameters:   old_filename - the JPEG file from which the image data will be retrieved
	*               new_filename - the name of the new JPEG to create (can be same as old_filename)
	*               jpeg_header_data - a JPEG header data array in the same format
	*                                  as from get_jpeg_header_data
	*
	* Returns:      TRUE - on Success
	*               FALSE - on Failure
	*
	******************************************************************************/
	
	function putExifData( $old_filename, $new_filename, $jpeg_header_data )
	{
	
			// Change: added check to ensure data exists, as of revision 1.10
			// Check if the data to be written exists
			if ( $jpeg_header_data == FALSE )
			{
					// Data to be written not valid - abort
					return FALSE;
			}
	
			// extract the compressed image data from the old file
			$compressed_image_data = CLimage::getJpegData( $old_filename );
	
			// Check if the extraction worked
			if ( ( $compressed_image_data === FALSE ) || ( $compressed_image_data === NULL ) )
			{
					// Couldn't get image data from old file
					return FALSE;
			}
	
	
			// Cycle through new headers
			foreach ($jpeg_header_data as $segno => $segment)
			{
					// Check that this header is smaller than the maximum size
					if ( strlen($segment['SegData']) > 0xfffd )
					{
							// Could't open the file - exit
							echo "<p>A Header is too large to fit in JPEG segment</p>\n";
							return FALSE;
					}
			}
	
			ignore_user_abort(true);    ## prevent refresh from aborting file operations and hosing file
	
	
			// Attempt to open the new jpeg file
			$newfilehnd = @fopen($new_filename, 'wb');
			// Check if the file opened successfully
			if ( ! $newfilehnd  )
			{
					// Could't open the file - exit
					echo "<p>Could not open file $new_filename</p>\n";
					return FALSE;
			}
	
			// Write SOI
			fwrite( $newfilehnd, "\xFF\xD8" );
	
			// Cycle through new headers, writing them to the new file
			foreach ($jpeg_header_data as $segno => $segment)
			{
	
					// Write segment marker
					fwrite( $newfilehnd, sprintf( "\xFF%c", $segment['SegType'] ) );
	
					// Write segment size
					fwrite( $newfilehnd, pack( "n", strlen($segment['SegData']) + 2 ) );
	
					// Write segment data
					fwrite( $newfilehnd, $segment['SegData'] );
			}
	
			// Write the compressed image data
			fwrite( $newfilehnd, $compressed_image_data );
	
			// Write EOI
			fwrite( $newfilehnd, "\xFF\xD9" );
	
			// Close File
			fclose($newfilehnd);
	
			// Alow the user to abort from now on
			ignore_user_abort(false);
	
	
			return TRUE;
	
	}
	
	/******************************************************************************
	* End of Function:     put_jpeg_header_data
	******************************************************************************/

	
	/******************************************************************************
	*
	* Function:     get_jpeg_image_data
	*
	* Description:  Retrieves the compressed image data part of the JPEG file
	*
	* Parameters:   filename - the filename of the JPEG file to read
	*
	* Returns:      compressed_data - A string containing the compressed data
	*               FALSE - if retrieval failed
	*
	******************************************************************************/
	
	function getJpegData( $filename )
	{
	
			// prevent refresh from aborting file operations and hosing file
			ignore_user_abort(true);
	
			// Attempt to open the jpeg file
			$filehnd = @fopen($filename, 'rb');
	
			// Check if the file opened successfully
			if ( ! $filehnd  )
			{
					// Could't open the file - exit
					return FALSE;
			}
	
	
			// Read the first two characters
			$data = fread( $filehnd, 2 );
	
			// Check that the first two characters are 0xFF 0xDA  (SOI - Start of image)
			if ( $data != "\xFF\xD8" )
			{
					// No SOI (FF D8) at start of file - close file and return;
					fclose($filehnd);
					return FALSE;
			}
	
	
	
			// Read the third character
			$data = fread( $filehnd, 2 );
	
			// Check that the third character is 0xFF (Start of first segment header)
			if ( $data{0} != "\xFF" )
			{
					// NO FF found - close file and return
					fclose($filehnd);
					return;
			}
	
			// Flag that we havent yet hit the compressed image data
			$hit_compressed_image_data = FALSE;
	
	
			// Cycle through the file until, one of: 1) an EOI (End of image) marker is hit,
			//                                       2) we have hit the compressed image data (no more headers are allowed after data)
			//                                       3) or end of file is hit
	
			while ( ( $data{1} != "\xD9" ) && (! $hit_compressed_image_data) && ( ! feof( $filehnd ) ))
			{
					// Found a segment to look at.
					// Check that the segment marker is not a Restart marker - restart markers don't have size or data after them
					if (  ( ord($data{1}) < 0xD0 ) || ( ord($data{1}) > 0xD7 ) )
					{
							// Segment isn't a Restart marker
							// Read the next two bytes (size)
							$sizestr = fread( $filehnd, 2 );
	
							// convert the size bytes to an integer
							$decodedsize = unpack ("nsize", $sizestr);
	
							 // Read the segment data with length indicated by the previously read size
							$segdata = fread( $filehnd, $decodedsize['size'] - 2 );
					}
	
					// If this is a SOS (Start Of Scan) segment, then there is no more header data - the compressed image data follows
					if ( $data{1} == "\xDA" )
					{
							// Flag that we have hit the compressed image data - exit loop after reading the data
							$hit_compressed_image_data = TRUE;
	
							// read the rest of the file in
							// Can't use the filesize function to work out
							// how much to read, as it won't work for files being read by http or ftp
							// So instead read 1Mb at a time till EOF
	
							$compressed_data = "";
							do
							{
									$compressed_data .= fread( $filehnd, 1048576 );
							} while( ! feof( $filehnd ) );
	
							// Strip off EOI and anything after
							$EOI_pos = strpos( $compressed_data, "\xFF\xD9" );
							$compressed_data = substr( $compressed_data, 0, $EOI_pos );
					}
					else
					{
							// Not an SOS - Read the next two bytes - should be the segment marker for the next segment
							$data = fread( $filehnd, 2 );
	
							// Check that the first byte of the two is 0xFF as it should be for a marker
							if ( $data{0} != "\xFF" )
							{
									// Problem - NO FF foundclose file and return";
									fclose($filehnd);
									return;
							}
					}
			}
	
			// Close File
			fclose($filehnd);
	
			// Alow the user to abort from now on
			ignore_user_abort(false);
	
	
			// Return the compressed data if it was found
			if ( $hit_compressed_image_data )
			{
					return $compressed_data;
			}
			else
			{
					return FALSE;
			}
	}
	
	
	/******************************************************************************
	* End of Function:     get_jpeg_image_data
	******************************************************************************/

}

?>
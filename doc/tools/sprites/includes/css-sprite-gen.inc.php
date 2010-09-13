<?php
   class CssSpriteGen {
      protected $sImageLibrary;
      protected $aImageTypes = array();
      protected $aFormValues = array();
      protected $aFormErrors = array();
      protected $sZipFolder = '';
      protected $bTransparent;
      protected $sCss;
      protected $sTempSpriteName;
      protected $bValidImages;
      
      public function __construct() {
         // check which image library to use
         // Imagick (Image Magick) is preferable
         if (extension_loaded('imagick')) {
            $this->sImageLibrary = 'imagick';
            // echo "loaded imagick";
            // what image formats does the installed version of Imagick support
            // probably overkill to call as PNG, GIF, JPEG surely supported but done for completeness 
            try {
               // Fixes #473915 as queryformats no longer works as a static method.
               $oImagick = new Imagick();
               $aImageFormats = $oImagick->queryFormats();
            } catch (ImagickException $e) {
               error_log($e->getMessage());
            }
            
            // store supported formats for populating drop downs etc later
            if (in_array('PNG', $aImageFormats)) {
               $this->aImageTypes[] = 'PNG';
            }
            if (in_array('GIF', $aImageFormats)) {
               $this->aImageTypes[] = 'GIF';
            }
            if (in_array('JPG', $aImageFormats)) {
               $this->aImageTypes[] = 'JPG';
            }
         } else {
            // check for GD, if it fails here there is no point continuing as the tool can't generate sprite images
            // without either library
            if (!extension_loaded('gd')) {
               die('GD and Imagick extensions not loaded. This tool requires one of these to generate sprite graphics.');
            }
            
            $this->sImageLibrary = 'gd';
            
            // get info about installed GD library to get image types (some versions of GD don't include GIF support)
            $oGD = gd_info();
         
            // store supported formats for populating drop downs etc later
            if ($oGD['PNG Support']) {
               $this->aImageTypes[] = 'PNG';
            }
            if ($oGD['GIF Create Support']) {
               $this->aImageTypes[] = 'GIF';
            }
            if ($oGD['JPG Support']) {
               $this->aImageTypes[] = 'JPG';
            }
         }
      }
      
      public function GetImageTypes() {
         return $this->aImageTypes;
      }
      
      public function ProcessForm() {
         // include the validation library - this generically processes HTML forms
         require_once('validation.inc.php');
         
         // exclude these fields from the validation check
         $aFieldsToIgnore = array(
            'path',
            'sub'
         );

         // these fields don't have to be filled in
         $aOptionalFields = array(
            'wrap-columns',
            'background',
            'selector-prefix',
            'class-prefix',
            'selector-suffix',
            'file-regex',
            'use-transparency',
            'use-optipng'
         );

         // validation rules for fields which do need to be tested
         // array items refer to methods within the validation library
         $aRules = array(
            'build-direction' => array('IsBuildDirection'),
            'vertical-offset' => array('IsNumber'),
            'horizontal-offset' => array('IsNumber'),
            'background' => array('IsHex'),
            'image-output' => array('IsImageType'),
            'image-num-colours' => array('IsColour'),
            'image-quality' => array('IsNumber', 'IsPercent'),
            'width-resize' => array('IsNumber', 'IsPercent'),
            'height-resize' => array('IsNumber', 'IsPercent'),
            'ignore-duplicates' => array('IsIgnoreOption'),
            'class-prefix' => array('IsClassPrefix'),
//            'selector-prefix' => array('IsCss'),
            'selector-suffix' => array('IsCss')
         );
         
         // create a new instance of validation class and run against form
         $oValidation = new Validation($_POST, $aFieldsToIgnore, $aOptionalFields, $aRules);
         // get form values post validation
         $this->aFormValues = $oValidation->GetFormValues();
         // get error found in form submission data
         $this->aFormErrors = $oValidation->GetAllErrors();
         
		 // print_r( $this->aFormValues);
		 
         // did everything validate
         return $oValidation->FormOk();
      }
      
      public function ProcessFile() {

         // Get mimetype        
         if (function_exists('mime_content_type')){
            $sMimeType = mime_content_type($_FILES['path']['tmp_name']);
         }else{
            // This gets the mime_type and handles output like "application/zip; charset=binary" too.
            $aMimeType = explode(';', shell_exec(ConfigHelper::Get('/binaries/file').' -bi '.$_FILES['path']['tmp_name']));
            $sMimeType = trim($aMimeType[0]);
         }

         // check if a valid file has been uploaded - check for existence, type and file size
         if (
            isset($_FILES['path']['name']) && 
            substr($_FILES['path']['name'], strtolower(strlen($_FILES['path']['name']) - 4)) == '.zip' && 
            in_array($sMimeType, array('application/zip', 'application/x-zip')) && 
            $_FILES['path']['size'] <= ConfigHelper::Get('/upload/max_file_size')
         ) {
            // create MD5 hash of ZIP file - use for path of dir to hold ZIP contents
            // include the current time to prevent clashes when ZIP files of the same name
            // are uploaded by different users
            $sFileMD5 = md5($_FILES['path']['name'].time());
            $sFolderMD5 = ConfigHelper::Get('/cache/upload_dir')."$sFileMD5/";
            
            // create dir to hold ZIP contents if it doesn't already exist
            if (!is_dir($sFolderMD5)) {
               mkdir($sFolderMD5);
            }

            // create a temporary name for saving ZIP file
            $sTempName = "{$sFolderMD5}tmp.zip";

            // save the ZIP file
            if (move_uploaded_file($_FILES['path']['tmp_name'], $sTempName)) {
               // unzip - store the contents in the dir already created
               $this->UnZipFile($sTempName, $sFolderMD5);
               $this->sZipFolder = $sFileMD5;
               // if all went well return an MD5 of the dir containing ZIP contents
               return $sFolderMD5;
            }
            return false;
         } elseif ( // check if file was already uploaded (this happens if they resubmitted the form after tweaking some values)
            !empty($_POST['zip-folder']) &&
            !empty($_POST['zip-folder-hash']) && 
            md5($_POST['zip-folder'].ConfigHelper::Get('/checksum')) == $_POST['zip-folder-hash']
         ) {
            $this->sZipFolder = $_POST['zip-folder'];
            return ConfigHelper::Get('/cache/upload_dir')."$this->sZipFolder/";
         }
         // upload failed - no ZIP was uploaded or it was invalid (didn't contain images or was too large)
         return false;
      }
      
      protected function UnZipFile($sFile, $sFolderMD5) {
         // this probably won't work if PHP safe mode is enabled
         // you'll have to disable (no way round this)
         shell_exec(ConfigHelper::Get('/binaries/unzip')." -j $sFile -d $sFolderMD5");
         // delete the original ZIP file - we no longer need it
         // for future re-submissions of the form we'll use the unzipped folder
         unlink($sFile);
      }
      
      public function CreateSprite($sFolderMD5) {
	  
         // set up variable defaults used when calculating offsets etc
         $aFilesInfo = array();
         $aFilesMD5 = array();
         $bResize = false;
         if ($this->aFormValues['build-direction'] == 'horizontal') {
            $iRowCount = 1;
            $iTotalWidth = 0;
            $iTotalHeight = 0;
            $aMaxRowHeight = array();
            $iMaxVOffset = 0;
         } else {
            $iColumnCount = 1;
            $iTotalWidth = 0;
            $iTotalHeight = 0;
            $aMaxColumnWidth = array();
            $iMaxHOffset = 0;
         }
         $iMaxWidth = 0;
         $iMaxHeight = 0;
         $i = 0;
         $bValidImages = false;
         $sOutputFormat = strtolower($this->aFormValues['image-output']);

         // read the contents of the directory passed
         $oDir = dir($sFolderMD5);
         
         /*******************************************/
         /* this section calculates all offsets etc */
         /*******************************************/
         
         // loop through directory (files will be processed in whatever the OS's default file ordering scheme is)
         // save to array so we can sort alphabetically
         $aFiles = array();
         
         while (false !== ($sFile = $oDir->read())) {
            $aFiles[] = $sFile;
         }
         
         sort($aFiles);

         foreach ($aFiles as $sFile) {
            // do we want to scale down the source images
            // scaling up isn't supported as that would result in poorer quality images
            $bResize = ($this->aFormValues['width-resize'] != 100 && $this->aFormValues['height-resize'] != 100);
            
            // grab path information
            $sFilePath = $sFolderMD5.$sFile;
            $aPathParts = pathinfo($sFilePath);
            
            // are we matching filenames against a regular expression
            // if so it's likely not all images from the ZIP file will end up in the generated sprite image
            if (!empty($this->aFormValues['file-regex'])) {
               // forward slashes should be escaped - it's likely not doing this might be a security risk also
               // one might be able to break out and change the modifiers (to for example run PHP code)
               $this->aFormValues['file-regex'] = str_replace('/', '\/', $this->aFormValues['file-regex']);
               
               // if the regular expression matches grab the first match and store for use as the class name
               if (preg_match('/^'.$this->aFormValues['file-regex'].'$/i', $sFile, $aMatches)) {
                  $sFileClass = $aMatches[1];
               } else {
                  $sFileClass = '';
               }
            } else { // not using regular expressions - set the class name to the base part of the filename (excluding extension)
               $sFileClass = $aPathParts['basename'];
            }
            
            // format the class name - it should only contain certain characters
            // this strips out any which aren't
            $sFileClass = $this->FormatClassName($sFileClass);
            
            $iImageType = exif_imagetype($sFilePath);
			   
            // if we've got an empty class name then the file wasn't valid and shouldn't be included in the sprite image
            // the file also isn't valid if its extension doesn't match one of the image formats supported by the tool
            if (
               !empty($sFileClass) && 
               isset($aPathParts['extension']) && 
               in_array(strtoupper($aPathParts['extension']), $this->aImageTypes) && 
               in_array($iImageType, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG)) && 
               substr($sFile, 0, 1) != '.'
            ) {
               // grab the file extension
               $sExtension = $aPathParts['extension'];
            
               // get MD5 of file (this can be used to compare if a file's content is exactly the same as another's)
               $sFileMD5 = md5(file_get_contents($sFilePath));
               
               // check if this file's MD5 already exists in array of MD5s recorded so far
               // if so it's a duplicate of another file in the ZIP
               if (($sKey = array_search($sFileMD5, $aFilesMD5)) !== false) {
                  // do we want to drop duplicate files and merge CSS rules
                  // if so CSS will end up like .filename1, .filename2 { }
                  if ($this->aFormValues['ignore-duplicates'] == 'merge') {
                     if (isset($aFilesInfo[$sKey]['class'])) {
                        $aFilesInfo[$sKey]['class'] = $aFilesInfo[$sKey]['class'].
                           $this->aFormValues['selector-suffix'].', '.
                           $this->aFormValues['selector-prefix'].'.'.
                           $this->aFormValues['class-prefix'].$sFileClass;
                        continue;
                     }
                  }
               }
            
               // add MD5 to array to check future files against
               $aFilesMD5[$i] = $sFileMD5;
               // store generated class selector details
               $aFilesInfo[$i]['class'] = ".{$this->aFormValues['class-prefix']}$sFileClass";
            
               // store file path information and extension
               $aFilesInfo[$i]['path'] = $sFilePath;
               $aFilesInfo[$i]['ext'] = $sExtension;
               // get dimensions of image
               $aImageInfo = getimagesize($sFilePath);
               $iWidth = $aImageInfo[0];
               $iHeight = $aImageInfo[1];
               
               if ($this->aFormValues['build-direction'] == 'horizontal') {
                  // get the current width of the sprite image - after images processed so far
                  $iCurrentWidth = $iTotalWidth + $this->aFormValues['horizontal-offset'] + $iWidth;
                  
                  // store the maximum width reached so far
                  // if we're on a new column current height might be less than the maximum
                  if ($iMaxWidth < $iCurrentWidth) {
                     $iMaxWidth = $iCurrentWidth;
                  }                  
               } else {
                  // get the current height of the sprite image - after images processed so far
                  $iCurrentHeight = $iTotalHeight + $this->aFormValues['vertical-offset'] + $iHeight;
                  
                  // store the maximum height reached so far
                  // if we're on a new column current height might be less than the maximum
                  if ($iMaxHeight < $iCurrentHeight) {
                     $iMaxHeight = $iCurrentHeight;
                  }
               }
               
               // store the original width and height of the image
               // we'll need this later if the image is to be resized
               $aFilesInfo[$i]['original-width'] = $iWidth;
               $aFilesInfo[$i]['original-height'] = $iHeight;
            
               // store the width and height of the image
               // if we're resizing they'll be less than the original
               $aFilesInfo[$i]['width'] = $bResize ? round(($iWidth / 100) * $this->aFormValues['width-resize']) : $iWidth;
               $aFilesInfo[$i]['height'] = $bResize ? round(($iHeight / 100) * $this->aFormValues['height-resize']) : $iHeight;
               
               if ($this->aFormValues['build-direction'] == 'horizontal') {
                  // opera (9.0 and below) has a bug which prevents it recognising  offsets of less than -2042px
                  // all subsequent values are treated as -2042px
                  // if we've hit 2000 pixels and we care about this (as set in the interface) then wrap to a new row
                  // increment row count and reset current height
                  if (
                     ($iTotalWidth + $this->aFormValues['horizontal-offset']) >= 2000 && 
                     !empty($this->aFormValues['wrap-columns'])
                  ) {
                     $iRowCount++;
                     $iTotalWidth = 0;
                  }
                  
                  // if the current image is higher than any other in the current row then set the maximum height to that
                  // it will be used to set the height of the current row
                  if ($aFilesInfo[$i]['height'] > $iMaxHeight) {
                     $iMaxHeight = $aFilesInfo[$i]['height'];
                  }
                  
                  // keep track of the height of rows added so far
                  $aMaxRowHeight[$iRowCount] = $iMaxHeight;
                  // calculate the current maximum vertical offset so far
                  $iMaxVOffset = $this->aFormValues['vertical-offset'] * ($iRowCount - 1);
                  
                  // get the x position of current image in overall sprite
                  $aFilesInfo[$i]['x'] = $iTotalWidth;
                  $iTotalWidth += ($aFilesInfo[$i]['width'] + $this->aFormValues['horizontal-offset']);
                  // get the y position of current image in overall sprite
                  if ($iRowCount == 1) {
                     $aFilesInfo[$i]['y'] = 0;
                  } else {
                     $aFilesInfo[$i]['y'] = (
                        $this->aFormValues['vertical-offset'] * 
                        ($iRowCount - 1) + 
                        (array_sum($aMaxRowHeight) - $aMaxRowHeight[$iRowCount])
                     );
                  }
                  $aFilesInfo[$i]['currentCombinedWidth'] = $iTotalWidth;
                  $aFilesInfo[$i]['rowNumber'] = $iRowCount;   
               } else {
                  if (
                     // opera (9.0 and below) has a bug which prevents it recognising  offsets of less than -2042px
                     // all subsequent values are treated as -2042px
                     // if we've hit 2000 pixels and we care about this (as set in the interface) then wrap to a new column
                     // increment column count and reset current height
                     ($iTotalHeight + $this->aFormValues['vertical-offset']) >= 2000 && 
                     !empty($this->aFormValues['wrap-columns'])
                  ) {
                     $iColumnCount++;
                     $iTotalHeight = 0;
                  }
                  
                  // if the current image is wider than any other in the current column then set the maximum width to that
                  // it will be used to set the width of the current column
                  if ($aFilesInfo[$i]['width'] > $iMaxWidth) {
                     $iMaxWidth = $aFilesInfo[$i]['width'];
                  }
                  
                  // keep track of the width of columns added so far
                  $aMaxColumnWidth[$iColumnCount] = $iMaxWidth;
                  // calculate the current maximum horizontal offset so far
                  $iMaxHOffset = $this->aFormValues['horizontal-offset'] * ($iColumnCount - 1);
                  
                  // get the y position of current image in overall sprite
                  $aFilesInfo[$i]['y'] = $iTotalHeight;
                  $iTotalHeight += ($aFilesInfo[$i]['height'] + $this->aFormValues['vertical-offset']);
                  // get the x position of current image in overall sprite
                  if ($iColumnCount == 1) {
                     $aFilesInfo[$i]['x'] = 0;
                  } else {
                     $aFilesInfo[$i]['x'] = (
                        $this->aFormValues['horizontal-offset'] * 
                        ($iColumnCount - 1) + 
                        (array_sum($aMaxColumnWidth) - $aMaxColumnWidth[$iColumnCount])
                     );
                  }
                  $aFilesInfo[$i]['currentCombinedHeight'] = $iTotalHeight;
                  $aFilesInfo[$i]['columnNumber'] = $iColumnCount;
               }
            
               $i++;
            }
         }
         
         // close the dir handle
         $oDir->close();
         
         /*******************************************/
         /* this section generates the sprite image */
         /* and CSS rules                           */
         /*******************************************/
         // if $i is greater than 1 then we managed to generate enough info to create a sprite
         if ($i > 1) {
            // if Imagick throws an exception we want the script to terminate cleanly so that 
            // temporary files are cleaned up
            try {
               // get the sprite width and height
               if ($this->aFormValues['build-direction'] == 'horizontal') {
                  $iSpriteWidth = $iMaxWidth - $this->aFormValues['horizontal-offset'];
                  $iSpriteHeight = array_sum($aMaxRowHeight) + $iMaxVOffset;
               } else {
                  $iSpriteHeight = $iMaxHeight - $this->aFormValues['vertical-offset'];
                  $iSpriteWidth = array_sum($aMaxColumnWidth) + $iMaxHOffset;
               }
            
               // get background colour - remove # if added
               $sBgColour = str_replace('#', '', $this->aFormValues['background']);
               // convert 3 digit hex values to 6 digit equivalent
               if (strlen($sBgColour) == 3) {
                  $sBgColour = substr($sBgColour, 0, 1).
                     substr($sBgColour, 0, 1).
                     substr($sBgColour, 1, 1).
                     substr($sBgColour, 1, 1).
                     substr($sBgColour, 2, 1).
                     substr($sBgColour, 2, 1);
               }
               // should the image be transparent
               $this->bTransparent = (
                  !empty($this->aFormValues['use-transparency']) && 
                  in_array($this->aFormValues['image-output'], array('GIF', 'PNG'))
               );
               
               // if using Imagick library create new instance of library class
               if ($this->sImageLibrary == 'imagick') {
                  $oSprite = new Imagick();
                  
                  // create a new image - set background according to transparency
                  if (!empty($this->aFormValues['background'])) {
                     $oSprite->newImage($iSpriteWidth, $iSpriteHeight, new ImagickPixel("#$sBgColour"), $sOutputFormat);
                  } else {
                     if ($this->bTransparent) {
                        $oSprite->newImage($iSpriteWidth, $iSpriteHeight, new ImagickPixel('#000000'), $sOutputFormat);
                     } else {
                        $oSprite->newImage($iSpriteWidth, $iSpriteHeight, new ImagickPixel('#ffffff'), $sOutputFormat);
                     }
                  }
               } else { // using GD - do the same thing
                  if ($this->bTransparent && !empty($this->aFormValues['background'])) {
                     $oSprite = imagecreatetruecolor($iSpriteWidth, $iSpriteHeight);
                  } else {
                     $oSprite = imagecreatetruecolor($iSpriteWidth, $iSpriteHeight);
                  }
               }
               
               // check for transparency option
               if ($this->bTransparent) {
                  if ($this->sImageLibrary == 'imagick') {
                     // set background colour to transparent
                     // if no background colour use black
                     if (!empty($this->aFormValues['background'])) {
                        $oSprite->paintTransparentImage(new ImagickPixel("#$sBgColour"), 0.0, 0);
                     } else {
                        $oSprite->paintTransparentImage(new ImagickPixel("#000000"), 0.0, 0);
                     }
                  } else { // using GD - do the same thing
                     if (!empty($this->aFormValues['background'])) {
                        $iBgColour = hexdec($sBgColour);
                        $iBgColour = imagecolorallocate(
                           $oSprite, 
                           0xFF & ($iBgColour >> 0x10), 
                           0xFF & ($iBgColour >> 0x8), 
                           0xFF & $iBgColour
                        );
						//$trans_colour = imagecolorallocatealpha($im, 0, 0, 0, 127);
						imagefill($oSprite, 0, 0, $iBgColour);

                     } else {
                        $iBgColour = imagecolorallocate($oSprite, 0, 0, 0);
                     }
                     imagecolortransparent($oSprite, $iBgColour);
                  }
               } else {
                  // set background colour if not using transparency and using GD
                  if ($this->sImageLibrary != 'imagick') {
                     if (empty($sBgColour)) {
                        $sBgColour = 'ffffff';
                     }
                     $iBgColour = hexdec($sBgColour);
                     $iBgColour = imagecolorallocate(
                        $oSprite, 0xFF & ($iBgColour >> 0x10), 
                        0xFF & ($iBgColour >> 0x8), 
                        0xFF & $iBgColour
                     );
                     imagefill($oSprite, 0, 0, $iBgColour);
                  }
               }
            
               // initalise variable to store CSS rules
               $this->sCss = '';
            
               // loop through file info for valid images
               for ($i = 0; $i < count($aFilesInfo); $i++) {
                  // create a new image object for current file
                  if (!$oCurrentImage = $this->CreateImage($aFilesInfo[$i]['path'], $aFilesInfo[$i]['ext'])) {
                     // if we've got here then a valid but corrupt image was found
                     // at this stage we've already allocated space for the image so create 
                     // a blank one to fill the space instead
                     // this should happen very rarely
                     $oCurrentImage = new Imagick();
                     
                     $oCurrentImage->newImage(
                        $aFilesInfo[$i]['original-width'], 
                        $aFilesInfo[$i]['original-height'], 
                        new ImagickPixel('#ffffff')
                     );
                  }
               
                  // if resizing get image width and height and resample to new dimensions (percentage of original)
                  // and copy to sprite image
                  if ($bResize) {
                     if ($this->sImageLibrary == 'imagick') {
                        // resample image should work but doesn't seem to - using thumbnailImage instead 
                        // which achieves the same effect
                        $oCurrentImage->thumbnailImage($aFilesInfo[$i]['width'], $aFilesInfo[$i]['height']);
                     } else {
                        imagecopyresampled(
                           $oSprite, 
                           $oCurrentImage, 
                           $aFilesInfo[$i]['x'], 
                           $aFilesInfo[$i]['y'], 0, 0, 
                           $aFilesInfo[$i]['width'], 
                           $aFilesInfo[$i]['height'], 
                           $aFilesInfo[$i]['original-width'], 
                           $aFilesInfo['original-height']
                        );
                     }
                  }
                  
                  // copy image to sprite
                  if ($this->sImageLibrary == 'imagick') {
                     $oSprite->compositeImage(
                        $oCurrentImage, 
                        $oCurrentImage->getImageCompose(), 
                        $aFilesInfo[$i]['x'], 
                        $aFilesInfo[$i]['y']
                     );
                  } else {
                     // if using GD and already resized the image will have been copied as part of the resize
                     if (!$bResize) {
                        imagecopy(
                           $oSprite, 
                           $oCurrentImage, 
                           $aFilesInfo[$i]['x'], 
                           $aFilesInfo[$i]['y'], 
                           0, 0, 
                           $aFilesInfo[$i]['width'],  
                           $aFilesInfo[$i]['height']
                        );
                     }
                  }
               
                  // get CSS x & y values
                  $iX = $aFilesInfo[$i]['x'] != 0 ? '-'.$aFilesInfo[$i]['x'].'px' : '0';
                  $iY = $aFilesInfo[$i]['y'] != 0 ? '-'.$aFilesInfo[$i]['y'].'px' : '0';
               
                  // create CSS rules and append to overall CSS rules
                  $this->sCss .= "{$this->aFormValues['selector-prefix']}{$aFilesInfo[$i]['class']} {$this->aFormValues['selector-suffix']}{ background-position: $iX $iY; ";
             
                  // If add widths and heights the sprite image width and height are added to the CSS
                  if ($this->aFormValues['add-width-height-to-css'] == 'on'){
                     $this->sCss .= "width: {$aFilesInfo[$i]['width']}px; height: {$aFilesInfo[$i]['height']}px;";
                  }

                  $this->sCss .= " } \n";

                  // destroy object created for current image to save memory
                  if ($this->sImageLibrary == 'imagick') {
                     $oCurrentImage->destroy();
                  } else {
                     imagedestroy($oCurrentImage);
                  }
               }
            
               // create a unqiue filename for sprite image
               $this->sTempSpriteName = ConfigHelper::Get('/cache/sprite_dir').uniqid('csg-').".$sOutputFormat";
               // write image to file (deleted by cron script after a limited time period)
               $this->WriteImage($oSprite, $sOutputFormat, $this->sTempSpriteName);
               // destroy object created for sprite image to save memory
               if ($this->sImageLibrary == 'imagick') {
                  $oSprite->destroy();
               } else {
                  imagedestroy($oSprite);
               }
               
               // set flag to indicate valid images created
               $this->bValidImages = true;
            } catch (ImagickException $e) {
               error_log($e->getMessage());
            }
         }
      }
      
      protected function FormatClassName($sClassName) {
         $aExtensions = array();
         
         foreach ($this->aImageTypes as $sType) {
            $aExtensions[] = ".$sType";
         }
         
         return preg_replace("/[^a-z0-9_-]+/i", '', str_ireplace($aExtensions, '', $sClassName));
      }
      
      protected function CreateImage($sFile, $sExtension) {
         if ($this->sImageLibrary == 'imagick') {
            try {
               // Imagick auto detects file extension when creating object from image
               $oImage = new Imagick();
               
               $oImage->readImage($sFile);
               return $oImage;
            } catch (ImagickException $e) {
               return false;
            }
         } else {
            // we need to tell GD what type of image it's creating an object from
            switch ($sExtension) {
               case 'jpg':
               case 'jpeg':
                  return @imagecreatefromjpeg($sFile);
               case 'gif':
                  return @imagecreatefromgif($sFile);
               case 'png':
                  return @imagecreatefrompng($sFile);
            }
         }
      }
      
      protected function WriteImage($oImage, $sExtension, $sFilename) {
         if ($this->sImageLibrary == 'imagick') {
            try {
               // check if we want to resample image to lower number of colours (to reduce file size)
               if (in_array($sExtension, array('gif', 'png')) && $this->aFormValues['image-num-colours'] != 'true-colour') {
                  $oImage->quantizeImage($this->aFormValues['image-num-colours'], Imagick::COLORSPACE_RGB, 0, false, false);
               }
               // if we're creating a JEPG set image quality - 0% - 100%
               if (in_array($sExtension, array('jpg', 'jpeg'))) {
                  $oImage->setCompression(Imagick::COMPRESSION_JPEG);
                  $oImage->SetCompressionQuality($this->aFormValues['image-quality']);
               }
               // write out image to file
               $oImage->writeImage($sFilename);
            } catch (ImagickException $e) {
               error_log($e->getMessage());
            }
         } else {
            // check if we want to resample image to lower number of colours (to reduce file size)
            if (in_array($sExtension, array('gif', 'png'))  && $this->aFormValues['image-num-colours'] != 'true-colour') {
               imagetruecolortopalette($oImage, true, $this->aFormValues['image-num-colours']);
            }
            switch ($sExtension) {
               case 'jpg': 
               case 'jpeg':
                  // GD takes quality setting in main creation function
                  imagejpeg($oImage, $sFilename, $this->aFormValues['image-quality']);
                  break;
               case 'gif':
                  // force colour palette to 256 colours if saving sprite image as GIF
                  // this will happen anyway (as GIFs can't be more than 256 colours) 
                  // but the quality will be better if pre-forcing
                  if (
                     $this->bTransparent && 
                     (
                        $this->aFormValues['image-num-colours'] == -1 || 
                        $this->aFormValues['image-num-colours'] > 256
                     )
                  ) {
                     imagetruecolortopalette($oImage, true, 256);
                  }
                  imagegif($oImage, $sFilename);
                  break;
               case 'png':
                  imagepng($oImage, $sFilename);
                  break;
            }
         }
         
         // if using a PNG and option selected further compress sprite image using OptiPNG
         // this can result in more than 50% saving in file size with little loss in quality
         if (
            $sExtension == 'png' && 
            !empty($this->aFormValues['use-optipng']) && 
            ConfigHelper::Get('/binaries/optipng')
         ) {
            // this probably won't work with PHP safe mode enabled
            // no real alternative - you'll have to enable to use
            shell_exec(ConfigHelper::Get('/binaries/optipng')." $sFilename");
         }
      }
      
      public function ValidImages() {
         return $this->bValidImages;
      }
      
      public function GetSpriteFilename() {
         $aFileParts = pathinfo($this->sTempSpriteName);
         return $aFileParts['basename'];
      }
      
      public function GetSpriteHash() {
         return md5($this->GetSpriteFilename().ConfigHelper::Get('/checksum'));
      }
      
      public function GetCss() {
         return $this->sCss;
      }
      
      public function GetAllErrors() {
         return $this->aFormErrors;
      }
      
      public function GetZipFolder() {
         return $this->sZipFolder;
      }
      
      public function GetZipFolderHash() {
         return md5($this->sZipFolder.ConfigHelper::Get('/checksum'));
      }
   }
?>

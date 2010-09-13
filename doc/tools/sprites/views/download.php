<?php
   // check parameters haven't been modified, checksum is used to prevent people guessing the URL to saved images
   if (
      isset($_GET['file']) && 
      preg_match("/^csg-[a-f0-9]+\.(gif|png|jpg)$/", $_GET['file']) && 
      isset($_GET['hash']) && md5($_GET['file'].ConfigHelper::Get('/checksum')) == $_GET['hash']
   ) {
      $sFilename = ConfigHelper::Get('/cache/sprite_dir').$_GET['file'];
      
      // file may not exist as folder is cleaned up every 30 mins
      if (file_exists($sFilename)) {
         $aFileParts = pathinfo($sFilename);
      
         // set headers correctly so the user is prompted to download the generated image
         header("Content-type: image/{$aFileParts['extension']}");
         header("Content-Disposition: attachment; filename=\"{$aFileParts['basename']}\"");
         // output the generate image
         readfile($sFilename);
      } else {
         die('Sprite image no longer exists. Please re-upload your images through the tool.');
      }
   } else {
      die('Invalid parameters specified');
   }
?>

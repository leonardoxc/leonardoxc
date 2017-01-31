<?php
   class Version {
      private static $aLookup = array();
      
      public static function Get($sFilename) {
         if (!array_key_exists($sFilename, self::$aLookup)) {
            $sRealPath = realpath($_SERVER['DOCUMENT_ROOT']."/$sFilename");
            self::$aLookup[$sFilename] = file_exists($sRealPath) ? '.'.filemtime($sRealPath) : '';
         }
         return preg_replace('/^(\/.*?)\.(css|js|jpe?g|gif|png)$/', '\\1'.self::$aLookup[$sFilename].'.\\2', $sFilename);
      }
      
      public static function GetLink($sFilename) {
         return '<link rel="stylesheet" type="text/css" href="'.self::Get($sFilename).'">';
      }
      
      public static function GetScript($sFilename) {
         return '<script type="text/javascript" src="'.self::Get($sFilename).'"></script>';
      }
      
      public static function GetImage($sFilename, $iWidth, $iHeight, $sAlt = '') {
         return sprintf('<img src="%s" width="%d" height="%d" alt="%s">', self::Get($sFilename), $iWidth, $iHeight, $sAlt);
      }
   }
?>

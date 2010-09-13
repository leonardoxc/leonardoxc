<?php
   class ConfigHelper {
      protected static $aConfig;

		public static function SetConfig($aConfig) {
			self::$aConfig = $aConfig;
		}

		public static function CreateDir($sDir) {
			if (!is_dir($sDir)) {
      		@mkdir($sDir);
   		}
		}

		public static function CreateFile($sFile) {
			if (!file_exists($sFile)) {
         	@touch($sFile);
      	}
		}
      
      // derived from http://uk.php.net/manual/en/function.realpath.php#84012
      public static function GetAbsolutePath($sPath) {
         $aParts = array_filter(explode('/', $sPath), 'strlen');
         $aAbsolutes = array();
        
         foreach ($aParts as $sPart) {
            if ($sPart == '.') {
               continue;
            }
            if ($sPart == '..') {
               array_pop($aAbsolutes);
            } else {
               $aAbsolutes[] = $sPart;
            }
         }
         return '/'.implode('/', $aAbsolutes);
      }
      
      public static function Get($sProperty, $vDefaultValue = null) {
         $aCurrentConfig = self::$aConfig;
         $vSection = null;
         $aProperty = explode('/', trim($sProperty, '/'));
         
         for ($i = 0; $i < count($aProperty); $i++) {
            if (isset($aCurrentConfig[$aProperty[$i]])) {
               $vSection = $aCurrentConfig[$aProperty[$i]];
               
               if ($i < count($aProperty)) {
                  $aCurrentConfig = $aCurrentConfig[$aProperty[$i]];
               }
            }
         }
         
         if (!is_null($vSection)) {
            return $vSection;
         } else {
            return false;
         }
      }
   }
?>

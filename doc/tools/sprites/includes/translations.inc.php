<?php
   class Translations {
      protected $sLang;
      protected $sTranslationsCacheDir;
      protected $bTranslationsAllowShowKeys;
      protected $sFile;
      protected $sCacheFile;
      protected $aTranslations = array();
      
      public function __construct(
         $sLang = 'en', 
         $sTranslationsCacheDir = '../../cache/translations/',
         $bTranslationsAllowShowKeys = true
      ) {
         // set up file paths
         $this->sLang = $sLang;
         $this->sTranslationsCacheDir = $sTranslationsCacheDir;
         $this->bTranslationAllowShowKeys = $bTranslationsAllowShowKeys;
         $this->sFile = $this->sTranslationsDir.$sLang.'.txt';
         $this->sCacheFile = $this->sTranslationsCacheDir.md5($sLang).'.cache';
         
         // fallback to default language if current doesn't exist
         if (!file_exists($this->sFile)) {
            $this->sFile = '../translations/'.$this->sLang.'.txt';
         }
         
         // after first pass translations are stored in serialised PHP array for speed
         // does a cache exist for the selected language
         if (file_exists($this->sCacheFile)) {
            // grab current cache
            $aCache = unserialize(file_get_contents($this->sCacheFile));
            
            // if the recorded timestamp varies from the selected language file then the translations have changed
            // update the cache
            if (
               $aCache['timestamp'] == filemtime($this->sFile) && 
               (!isset($aCache['parent-filename']) || 
               $aCache['parent-timestamp'] == filemtime($aCache['parent-filename']))
            ) { // not changed
               $this->aTranslations = $aCache['translations'];
            } else { // changed
               $this->Process();
            }
         } else {
            $this->Process();
         }
      }
      
      protected function Process() {
         // create array for serialising
         $aCache = array();
         
         // read translation file into array
         $aFile = file($this->sFile);
         
         // does this translation file inherit from another
         $aInheritsMatches = array();
         if (isset($aFile[0]) && preg_match("/^\s*{inherits\s+([^}]+)}.*$/", $aFile[0], $aInheritsMatches)) {
            $sParentFile = $this->sTranslationsDir.trim($aInheritsMatches[1]).'.txt';
            // read parent file into array
            $aParentFile = file($sParentFile);
            // merge lines from parent file into main file array, lines in the main file override lines in the parent
            $aFile = array_merge($aParentFile, $aFile);
            // store filename of parent
            $aCache['parent-filename'] = $sParentFile;
            // store timestamp of parent
            $aCache['parent-timestamp'] = filemtime($sParentFile);
         }
         
         // read language array line by line
         foreach ($aFile as $sLine) {
            $aTranslationMatches = array();
            
            // match valid translations, strip comments - both on their own lines and at the end of a translation
            // literal hashes (#) should be escaped with a backslash
            if (preg_match("/^\s*([0-9a-z\._-]+)\s*=\s*((\\\\#|[^#])*).*$/iu", $sLine, $aTranslationMatches)) {
               $this->aTranslations[$aTranslationMatches[1]] = trim(str_replace('\#', '#', $aTranslationMatches[2]));
            }
         }
         // add current timestamp of translation file
         $aCache['timestamp'] = filemtime($this->sFile);
         // add translations
         $aCache['translations'] = $this->aTranslations;
         // write cache
         file_put_contents($this->sCacheFile, serialize($aCache));
      }
      
      public function Get($sKey) {
         $sTranslation = '';
         
         if (array_key_exists($sKey, $this->aTranslations)) { // key / value pair exists
            $sTranslation = $this->aTranslations[$sKey];
            
            // number of arguments can be variable as user can pass any number of substitution values
            $iNumArgs = func_num_args();
            if ($iNumArgs > 1) { // complex translation, substitution values to process
               $vFirstArg = func_get_arg(1);
               if (is_array($vFirstArg)) { // named substitution variables
                  foreach ($vFirstArg as $sKey => $sValue) {
                     $sTranslation = str_replace('{'.$sKey.'}', $sValue, $sTranslation);
                  }
               } else { // numbered substitution variables
                  for ($i = 1; $i < $iNumArgs; $i++) {
                     $sParam = func_get_arg($i);
                     // replace current substitution marker with value
                     $sTranslation = str_replace('{'.($i - 1).'}', $sParam, $sTranslation);
                  } 
               } 
            }
         
            // whilst translating the user has the option to switch out all values with the corresponding key
            // this helps to see what translated text will appear where
            // set ALLOW_SHOW_KEYS false to disable - might be preferable in production
            if (!$this->bTranslationsAllowShowKeys || !isset($_REQUEST['showKeys'])) {
               return $sTranslation;
            }
         }
         // key / value doesn't exist, show the key instead
         return $sKey;
      }
   }
?>
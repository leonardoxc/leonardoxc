<?php
   require('../ext/jsmin.inc.php');
   
   class Combine {
      protected $sDocRoot;
      protected $aConfig;
      protected $sCode;
      protected $sLastModified;
      protected $iEtag;
      
      public function __construct($aConfig) {
         $this->sDocRoot = $_SERVER['DOCUMENT_ROOT'];
         $this->aConfig = $aConfig;
      }
      
      public function Get() {
         /*
            if etag parameter is present then the script is being called directly, otherwise we're including it in 
            another script with require or include. If calling directly we return code othewise we return the etag 
            representing the latest files
         */
         if (!empty($_GET['v'])) {
            return $this->GetCode();
         } else {
            return $this->GetTimestamp();
         }
      }
      
      protected function Combine() {
         $this->iETag = (int)$_GET['v'];     
         $this->sLastModified = gmdate('D, d M Y H:i:s', $this->iETag).' GMT';
         
         // see if the user has an updated copy in browser cache
         if (
            (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && $_SERVER['HTTP_IF_MODIFIED_SINCE'] == $this->sLastModified) ||
            (isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] == $this->iETag)
         ) {
            header("{$_SERVER['SERVER_PROTOCOL']} 304 Not Modified");
            exit;
         }
         
         $this->CreateArchiveDir();
         
         $sMergedFilename = "$this->sDocRoot/".$this->aConfig['archive_folder']."/$this->iETag.cache";
         
         // get code from archive folder if it exists, otherwise grab latest files, merge and save in archive folder
         if ($this->aConfig['create_archive'] && file_exists($sMergedFilename)) {
            $this->sCode = file_get_contents($sMergedFilename);
         } else {
            // get and merge code
            $this->sCode = '';
            $aLastModifieds = array();
            
            foreach ($this->aConfig['files'] as $sFile) {
               $aLastModifieds[] = filemtime("$this->sDocRoot/$sFile");
               $this->sCode .= file_get_contents("$this->sDocRoot/$sFile");
            }
            
            // sort dates, newest first
            rsort($aLastModifieds);
            
            if ($this->aConfig['create_archive']) {
               // check for valid etag, we don't want invalid requests to fill up archive folder
               if ($this->iETag == $aLastModifieds[0]) {
                  if ($this->aConfig['file_type'] == 'text/javascript' && $this->aConfig['jsmin_compress']) {
                     if ($this->aConfig['jsmin_comments'] != '') {
                        $this->sCode = $this->aConfig['jsmin_comments']."\n\n".$this->sCode;
                     }
                     $this->sCode = JSMin::minify($this->sCode);
                  }
                  file_put_contents($sMergedFilename, $this->sCode);
               } else {
                  // archive file no longer exists or invalid etag specified
                  header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
                  exit;
               }
            }
         }
      }
      
      public function GetCode() {
         $this->Combine();
         $this->SetHeaders();
      
         // output merged code
         return $this->sCode;
      }
      
      public function GetTimestamp() {
         // get file last modified dates
         $aLastModifieds = array();
         
         foreach ($this->aConfig['files'] as $sFile) {
		 echo "#". $this->sDocRoot."#".$sFile."#<BR>";
            $aLastModifieds[] = filemtime("$this->sDocRoot/$sFile");
         }
         // sort dates, newest first
         rsort($aLastModifieds);
         
         // output latest timestamp
         return $aLastModifieds[0];
      }
      
      protected function CreateArchiveDir() {
         // create a directory for storing current and archive versions
         if ($this->aConfig['create_archive'] && !is_dir("$this->sDocRoot/".$this->aConfig['archive_folder'])) {
            mkdir("$this->sDocRoot/".$this->aConfig['archive_folder']);
         }
      }
      
      protected function SetHeaders() {
         // send HTTP headers to ensure aggressive caching
         header('Expires: '.gmdate('D, d M Y H:i:s', time() + $this->aConfig['cache_length']).' GMT'); // 1 year from now
         header('Content-Type: '.$this->aConfig['file_type']);
         header("Last-Modified: $this->sLastModified");
         header("ETag: $this->iETag");
         header('Cache-Control: max-age='.$this->aConfig['cache_length']);
      }
   }
?>

<?php
   class Template {
      protected $sTemplate;
      protected $sLang;
      protected $aTemplatePaths;
      protected $aVars = array();
      protected $aPostFilters = array();
      
      public function __construct(
         $sTemplate,
         $sLang = '',
         $aTemplatePaths = array('../templates/')
      ) {
         $this->sTemplate = $sTemplate;
         $this->sLang = $sLang;
         $this->aTemplatePaths = $aTemplatePaths;
      }
      
      public function Set(
         $sName,
         $vValue,
         $bStripHtml = true,
         $bConvertEntities = false,
         $sCharSet = 'UTF-8'
      ) {
         $this->aVars[$sName] = $vValue;
         
         // variable value might be a reference to a sub-template
         if (!($vValue instanceof Template) && is_scalar($vValue)) {
            if ($bStripHtml) {
               $this->aVars[$sName] = strip_tags($this->aVars[$sName]);
            }

            if ($bConvertEntities) {
               $this->aVars[$sName] = htmlentities($this->aVars[$sName], $sCharSet);
            }
         }
      }

      protected function IncTemplate(
			$sTemplate, 
			$aVariables = array() 
		) {
         $oTemplate = new Template($sTemplate, $this->sLang, $this->aTemplatePaths);
         $oTemplate->aVars = $this->aVars;
            
         if (count($aVariables)) {
            foreach ($aVariables as $sKey => $vValue) {
               $oTemplate->set($sKey, $vValue);
            }
         }

         echo $oTemplate->Display();
      }
      
      public function AddPostFilter($sFunctionName) {
         $this->aPostFilters[] = $sFunctionName;
      }
      
      public function Display() {
         $sOutput = '';
      
         // looping rather than using extract because we need to determine the value type before assigning
         foreach ($this->aVars as $sKey => &$vValue) {
            // is this variable a reference to a sub-template
            if ($vValue instanceof Template) {
               // pass variables from parent to sub-template but don't override variables in sub-template 
               // if they already exist as they are more specific
               foreach ($this->aVars as $sSubKey => $vSubValue) {
                  if (!($vSubValue instanceof Template) && !array_key_exists($sSubKey, $vValue->aVars)) {
                     $vValue->aVars[$sSubKey] = $vSubValue;
                  }
               }
               // disable caching for sub-template
               $vValue->bCacheSupport = false;
               // display sub-template and assign output to parent variable
               $$sKey = $vValue->Display();
            } else {
               $$sKey = $vValue;
            }
         }
         
         // use output buffers to capture data from require statement and store in variable
         ob_start();
         foreach ($this->aTemplatePaths as $sTemplatePath) {
            if ($this->sLang != '' && file_exists($sTemplatePath."locales/$this->sLang/".$this->sTemplate)) {
               require($sTemplatePath."locales/$this->sLang/".$this->sTemplate);
               break;
            } elseif (file_exists($sTemplatePath.$this->sTemplate)) {
               require($sTemplatePath.$this->sTemplate);
               break;
            }
         }
         $sOutput .= ob_get_clean();
      
         // process content against defined post filters
         foreach ($this->aPostFilters as $sPostFilter) {
            $sOutput = $sPostFilter($sOutput);
         }
         // is caching support available
         if ($this->bCacheSupport) {
            $this->oCache->Set($sOutput);
         }
         return $sOutput;
      }
   }
?>

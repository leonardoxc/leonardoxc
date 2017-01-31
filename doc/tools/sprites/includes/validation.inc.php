<?php
   class Validation {
      protected $aFormValues = array();
      protected $aFormErrors = array();
      protected $aFieldsToIgnore = array();
      protected $aOptionalFields = array();
      protected $aRules = array();
      
      public function __construct($aData, $aFieldsToIgnore, $aOptionalFields, $aRules) {
         $this->aFieldsToIgnore = $aFieldsToIgnore;
         $this->aOptionalFields = $aOptionalFields;
         $this->aRules = $aRules;
         
         $this->aFormErrors['missing'] = array();
         $this->aFormErrors['invalid'] = array();
         
         foreach ($aData as $sKey => $sValue) {
            if (!in_array($sKey, $this->aFieldsToIgnore)) {
               if (!empty($sValue) || in_array($sKey, $this->aOptionalFields)) {
                  $this->aFormValues[$sKey] = $sValue;
                  
                  if (!empty($sValue)) {
                     if (array_key_exists($sKey, $this->aRules)) {
                        foreach ($this->aRules[$sKey] as $sRule) {
                           if (!$this->$sRule($sKey)) {
                              break;
                           }
                        }
                     }
                  }
               } else {
                  $this->aFormErrors['missing'][] = $sKey;
               }
            }
         }
		 
      }
      
      protected function IsNumber($sKey) {
         if (empty($this->aFormValues[$sKey]) || !is_numeric($this->aFormValues[$sKey])) {
            $this->aFormErrors['invalid'][$sKey] = 'IsNumber';
            return false;
         }
         return true;
      }
      
      protected function IsHex($sKey) {
         if (!preg_match("/^#?([0-9a-f]{3}|[0-9a-f]{6})$/i", $this->aFormValues[$sKey])) {
            $this->aFormErrors['invalid'][$sKey] = 'IsHex';
            return false;
         }
         return true;
      }
      
      protected function IsImageType($sKey) {
         if (!in_array($this->aFormValues[$sKey], array('GIF', 'PNG', 'JPG'))) {
            $this->aFormErrors['invalid'][$sKey] = 'IsImageType';
            return false;
         }
         return true;
      }
      
      protected function IsPercent($sKey) {
         if ($this->aFormValues[$sKey] < 10 || $this->aFormValues[$sKey] > 100) {
            $this->aFormErrors['invalid'][$sKey] = 'IsPercent';
            return false;
         }
         return true;
      }
      
      protected function IsIgnoreOption($sKey) {
         if (!in_array($this->aFormValues[$sKey], array('ignore', 'merge'))) {
            $this->aFormErrors['invalid'][$sKey] = 'IsIgnoreOption';
            return false;
         }
         return true;
      }
      
      protected function IsClassPrefix($sKey) {
         if (!preg_match("/^[^0-9]{1}[a-z0-9_-]+$/i", $this->aFormValues[$sKey])) {
            $this->aFormErrors['invalid'][$sKey] = 'IsClassPrefix';
            return false;
         }
         return true;
      }
      
      protected function IsCss($sKey) {
         echo $sKey;
         if (!preg_match("/^[a-z0-9_\.\s\#-]+$/i", $this->aFormValues[$sKey])) {
            $this->aFormErrors['invalid'][$sKey] = 'IsCss';
            return false;
         }
         return true;
      }
      
      protected function IsColour($sKey) {
         if (empty($this->aFormValues[$sKey]) || (!is_numeric($this->aFormValues[$sKey]) && $this->aFormValues[$sKey] != 'true-colour')) {
            $this->aFormErrors['invalid'][$sKey] = 'IsColour';
            return false;
         }
         return true;
      }
      
      protected function IsBuildDirection($sKey) {
         if (!in_array($this->aFormValues[$sKey], array('horizontal', 'vertical'))) {
            $this->aFormErrors['invalid'][$sKey] = 'IsBuildDirection';
            return false;
         }
         return true;
      }
      
      public function FormOk() {
         return !count($this->aFormErrors['missing']) && !count($this->aFormErrors['invalid']);
      }
      
      public function GetFormValues() {
         return $this->aFormValues;
      }
      
      public function GetMissingFields() {
         return $this->aFormErrors['missing'];
      }
      
      public function GetInvalidFields() {
         return $this->aFormErrors['invalid'];
      }
      
      public function GetAllErrors() {
         return $this->aFormErrors;
      }
   }
?>

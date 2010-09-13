<?php
   class TemplateFunctions {
      protected $bFormPosted;
      protected $aFormErrors;
      
      public function __construct($bFormPosted = null, $aFormErrors = null) {
         $this->bFormPosted = $bFormPosted;
         $this->aFormErrors = $aFormErrors;
      }
      
      protected function HasError($sField) {
         if (
            $this->bFormPosted && (in_array($sField, $this->aFormErrors['missing']) || 
            array_key_exists($sField, $this->aFormErrors['invalid']))
         ) {
            return true;
         }
         return false;
      }

      protected function GetCurrentValue($sField, $sDefault) {
         if (isset($_POST[$sField])) {
            return htmlspecialchars($_POST[$sField]);
         }
         return $sDefault;
      }
      
      public function TextInput($sId, $sLabel, $vDefault = '', $iSize = null, $sHint = '', $bOptional = false) {
         $oTemplate = new Template('text-input.php', '', ConfigHelper::Get('/template/paths'));
         $oTemplate->Set('id', $sId);
         $oTemplate->Set('label', $sLabel);
         $oTemplate->Set('value', $this->GetCurrentValue($sId, $vDefault));
         $oTemplate->Set('size', $iSize);
         $oTemplate->Set('hint', $sHint);
         $oTemplate->Set('optional', $bOptional);
         $oTemplate->Set('error', $this->HasError($sId));
         
         return $oTemplate->Display();
      }
      
      public function SelectInput($sId, $sLabel, $aOptions, $vDefault = '', $sHint = '') {
         $oTemplate = new Template('select-input.php', '', ConfigHelper::Get('/template/paths'));
         $oTemplate->Set('id', $sId);
         $oTemplate->Set('label', $sLabel);
         $oTemplate->Set('options', $aOptions);
         $oTemplate->Set('value', $this->GetCurrentValue($sId, $vDefault));
         $oTemplate->Set('hint', $sHint);
         
         return $oTemplate->Display();
      }
      
      public function RadioInput($sName, $sId, $sLabel, $vValue, $vDefault) {
         $oTemplate = new Template('radio-input.php', '', ConfigHelper::Get('/template/paths'));
         $oTemplate->Set('name', $sName);
         $oTemplate->Set('id', $sId);
         $oTemplate->Set('label', $sLabel);
         $oTemplate->Set('value', $vValue);
         $oTemplate->Set('current', $this->GetCurrentValue($sName, $vDefault));
         
         return $oTemplate->Display();
      }
      
      public function ColourSelectInput($sId, $sLabel, $sTrueColourLabel, $vDefault = '', $sHint = '') {
         $aOptions = array();
         
         for ($i = 2; $i < 70000; $i = $i * 2) {
            $aOptions[$i] = $i;
         }
         $aOptions['true-colour'] = $sTrueColourLabel;
         
         return $this->SelectInput($sId, $sLabel, $aOptions, $vDefault, $sHint);
      }
      
      public function ConvertArrayToMulti($aArray) {
         $aMultiArray = array();
         
         foreach ($aArray as $sItem) {
            $aMultiArray[$sItem] = $sItem;
         }
         
         return $aMultiArray;
      }
      
      public function GetMenuUrl($sAppRoot, $sSection) {
			if ($sSection != 'home') {
		      if (ConfigHelper::Get('/urls/rewritten')) {
		         return $sAppRoot."section/$sSection";
		      } else {
		         return $sAppRoot."?view=$sSection";
		      }
			}
			return $sAppRoot;
      }
   }
?>

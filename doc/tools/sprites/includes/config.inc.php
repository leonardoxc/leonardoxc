<?php
   require('template.inc.php');
   require('template-functions.inc.php');
   require('translations.inc.php');
   require('css-sprite-gen.inc.php');
   require('version.inc.php');
   require('config-helper.inc.php');
   require('conf/app.inc.php');
   require('conf/languages.inc.php');
   
   $sBasename = dirname(__FILE__).'/';
   
   if (file_exists($sBasename.'conf/overrides.inc.php')) {
      require('conf/overrides.inc.php');
   }

	ConfigHelper::SetConfig($aConfig);
   
   if (!ConfigHelper::Get('/setup')) {
      $oTemplate = new Template('setup-config-error.php');
      $oTemplate->Set('config', $sConfig);
      $oTemplate->Set('basename', $sBasename);
      echo $oTemplate->Display();
      exit;
   }
   
   $sUploadDir = ConfigHelper::GetAbsolutePath(
		$sBasename.ConfigHelper::Get('/cache/upload_dir')
	);
   $sSpriteDir = ConfigHelper::GetAbsolutePath(
		$sBasename.ConfigHelper::Get('/cache/sprite_dir')
	);
   $sTranslationsCacheDir = ConfigHelper::GetAbsolutePath(
		$sBasename.ConfigHelper::Get('/cache/translations_dir')
	);

	$sCssCacheDir = ConfigHelper::GetAbsolutePath(
		$sBasename.ConfigHelper::Get('/cache/css_archive')
	);

	$sJsCacheDir = ConfigHelper::GetAbsolutePath(
		$sBasename.ConfigHelper::Get('/cache/js_archive')
	);
   
   ConfigHelper::CreateDir($sUploadDir);
   ConfigHelper::CreateDir($sSpriteDir);
   ConfigHelper::CreateDir($sTranslationsCacheDir);
	ConfigHelper::CreateDir($sCssCacheDir);
	ConfigHelper::CreateDir($sJsCacheDir);
   
	// This section is present for Project Fondue use only and can be safely removed */
   if (ConfigHelper::Get('/cache/tla/dir')) {
      $sTextLinkAdsDir = ConfigHelper::GetAbsolutePath(
			$sBasename.ConfigHelper::Get('/cache/tla/dir')
		);
      
      ConfigHelper::CreateDir($sTextLinkAdsDir);
      ConfigHelper::CreateFile($sTextLinkAdsDir.'/'.ConfigHelper::Get('/cache/tla/file'));
   }
	// End section //
   
   if (
      !is_writeable($sUploadDir) || 
      !is_writeable($sSpriteDir) || 
      !is_writeable($sTranslationsCacheDir) ||
		!is_writeable($sCssCacheDir) ||
		!is_writeable($sJsCacheDir)
   ) {
      $oTemplate = new Template('setup-permissions-error.php');
      $oTemplate->Set('uploadDir', $sUploadDir);
      $oTemplate->Set('spriteDir', $sSpriteDir);
      $oTemplate->Set('translationsCacheDir', $sTranslationsCacheDir);
		$oTemplate->Set('cssCacheDir', $sCssCacheDir);
		$oTemplate->Set('jsCacheDir', $sJsCacheDir);
      echo $oTemplate->Display();
      exit;
   }
?>

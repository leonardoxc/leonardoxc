<?php
   require_once('../includes/config.inc.php');
   require_once('../includes/combine.inc.php');
   
   $aConfig = array(
      'file_type' => 'text/css',
      'cache_length' => 31356000,
      'create_archive' => true,
      'archive_folder' => ConfigHelper::Get('/cache/css_archive'),
      'files' => array(
         'css/ie.css'
      )
   );
         
   $oCombine = new Combine($aConfig);
   echo $oCombine->Get();
?>
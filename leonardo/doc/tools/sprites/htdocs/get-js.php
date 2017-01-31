<?php
   require_once('../includes/config.inc.php');
   require_once('../includes/combine.inc.php');
   
   $aConfig = array(
      'file_type' => 'text/javascript',
      'cache_length' => 31356000,
      'create_archive' => true,
      'archive_folder' => ConfigHelper::Get('/cache/js_archive'),
      'jsmin_compress' => ConfigHelper::Get('/jsmin/compress'),
      'jsmin_comments' => ConfigHelper::Get('/jsmin/comments'),
      'files' => array(
         'js/yahoo.js',
         'js/dom.js',
         'js/event.js',
         'js/tool.js'
      )
   );
         
   $oCombine = new Combine($aConfig);
   echo $oCombine->Get();
?>

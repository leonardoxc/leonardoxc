<?php
   $aConfig = array();
   
   // set this option to true once you've finished setting up
   $aConfig['setup'] = true;

   // publically accessible document root
   $aConfig['app_root'] = dirname($_SERVER['PHP_SELF']) ; //'/standalone/doc/tools/sprites/htdocs/'; 
   
   // directory to store uploaded ZIP files
   $aConfig['cache']['upload_dir'] = '../cache/upload/';
   
   // file binary - used to check for a valid ZIP file
   $aConfig['binaries']['file'] = '/usr/bin/file';
   
   // easier to use a command line binary as many installs of PHP won't have ZIP libraries compiled in
   $aConfig['binaries']['unzip'] = '/usr/bin/unzip';
   
   // otipng binary - compresses PNG images
   $aConfig['binaries']['optipng'] = '/usr/local/bin/optipng';
   
   // location to store generated sprite images
   $aConfig['cache']['sprite_dir'] = '../cache/sprites/';
   
   // maximum file upload size - specified in bytes
   $aConfig['upload']['max_file_size'] = 524288;
   
   // secret used to check validity of download link request
   $aConfig['checksum'] = 'wwet34534y43';

	$aConfig['template']['paths'] = array(
		'../templates/'
	);
   
   // location of CSS, JS & images - set this if you want to load these from a separate virtual host
   // $aConfig['assets_dir'] = '/standalone/img/css1/htdocs/';
   
   // default translations language, this is what it'll use if none is specified
   $aConfig['translations']['default_lang'] = 'en';
   
   // once parsed translation files are cached, this specifies where to store the cache files
   $aConfig['cache']['translations_dir'] = '../cache/translations/';
   
   // determines whether or not adding showKeys=true parameter is active
   $aConfig['translations']['allow_show_keys'] = true;
   
   // url types
   $aConfig['urls']['rewrite'] = false;
   
   // language switching mechanism
   $aConfig['languages']['switch'] = 'host';
   
   // base URL to tool
   $aConfig['urls']['tool'] = 'ENTER_URL_TO_TOOL_HERE';
   
   // contact email address
   $aConfig['emails']['contact'] = 'ENTER_CONTACT_EMAIL_ADDRESS_HERE';
   
   
   // directory to store cached CSS files
   $aConfig['cache']['css_archive'] = '../cache/css/';
   
   // directory to store cached JS files
   $aConfig['cache']['js_archive'] = '../cache/js/';
   
   // jsmin compress JS
   $aConfig['jsmin']['compress'] = true;
   
   $aConfig['jsmin']['comments'] = '
      /*
         YUI:
         
         Copyright (c) 2009, Yahoo! Inc. All rights reserved.
         Code licensed under the BSD License:
         http://developer.yahoo.net/yui/license.txt
         version: 2.7.0
      
         tool.js
         
         Copyright (c) 2007-2009 Project Fondue. All Rights Reserved.
         Code licensed under the BSD License.
      */
   ';
?>
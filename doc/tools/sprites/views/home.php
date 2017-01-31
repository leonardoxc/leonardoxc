<?php

	// leonardo paths
	$leoBase=realpath(dirname(__FILE__).'/../../../..');
	$cssFile="$leoBase/templates/basic/sprites.css";
	$imgDir="$leoBase/img";
	
	$tmpImgDir=realpath(dirname(__FILE__).'/../cache/sprites');

	$WRITE_FILES=1; // use 0 for testing only
	//echo " $leoBase $cssFile $imgDir";

$leoSprites=array(

	'fl'=>array(
		'selector-prefix' => 'img.fl',
		'background' => '#00FF00',
		'horizontal-offset' => 20,
	    'vertical-offset' => 20,
		'use-transparency' => 'on',
	    'image-output' => 'PNG',
    	'image-num-colours' => '256',
		'add-width-height-to-css'=>'',
			
		'filename'=>'flags',
	),	
	
	'icons1'=>array(
		'selector-prefix' => 'img.icons1',
		'background' => '#FF7DF1',
		'horizontal-offset' => 40,
	    'vertical-offset' => 25,
		'file-regex' =>  '(.*).png',
		'use-transparency' => 'on',
	    'image-output' => 'PNG',
    	'image-num-colours' => '256',
	),
	
	'brands'=>array(
		'selector-prefix' => 'img.brands',
		'background' => '#FF7DF1',
		'horizontal-offset' => 85,
	    'vertical-offset' => 25,
		'use-transparency' => 'on',
	    'image-output' => 'PNG',
    	'image-num-colours' => '256',
	),
);

$extraCss=array(
'fl'=>
'
width:18px;
height:11px;	
margin-top:1px;
margin-left:2px;',
);


$cssStr='';

foreach($leoSprites as $dirName=>$dirOptions) {
   // create an intance of the sprite gen class 
   // (this does all the work of creating sprites and CSS)
   $_POST=array(
    'MAX_FILE_SIZE' => 524288,
    'zip-folder' => '6d64c93a3f812f546092f64a911176de',
    'zip-folder-hash' => '90520b09bec4b53e58f19b97ec4b11d5',
    'ignore-duplicates' => 'ignore',
    'width-resize' => 100,
    'height-resize' => 100,
    'build-direction' => 'vertical',
    'horizontal-offset' => 50,
    'vertical-offset' => 50,
    'wrap-columns' => 'on',
    'background' => '#FF7DF1',
    'use-transparency' => 'on',
    'image-output' => 'PNG',
    'image-num-colours' => 'true-colour',
	// 'image-num-colours' => '256',
    'image-quality' => '75',
    'use-optipng' => 'on',
    'selector-prefix' => 'img.fl',
   	// 'file-regex' =>  'icon-([0-9]+).png',
    'class-prefix' => 'sprite-',
    'selector-suffix' => '',
	'add-width-height-to-css'=>'on',
	);

   
   $oCssSpriteGen = new CssSpriteGen();
   foreach($dirOptions as $name=>$val) {
		$_POST[$name]=$val;   
   }
   
	$oCssSpriteGen->ProcessForm();
	$sFolderMD5 = $oCssSpriteGen->ProcessFile();
	// look into leonardo img folders instead
	$sFolderMD5="$imgDir/$dirName/";
	 
	$oCssSpriteGen->CreateSprite($sFolderMD5);
	
    $tmpImgFile= $tmpImgDir.'/'.$oCssSpriteGen->GetSpriteFilename();
	
	if ( $dirOptions['filename']) {
		$realImgFile="$imgDir/sprite_".$dirOptions['filename'].".png";
	} else {
		$realImgFile="$imgDir/sprite_$dirName.png";
	}
			
    $cssStrTmp=$oCssSpriteGen->GetCss();		 
	
	$cssStr.="
img.$dirName {
float:none;
display:inline-block;
*display:inline;
clear:none;".$extraCss[$dirName]."
}
".$cssStrTmp;
	

	echo "Moving sprite file  $tmpImgFile to $realImgFile<BR>";
	if ($WRITE_FILES) {
		@unlink( $realImgFile);
		rename($tmpImgFile,$realImgFile);
	}	
}

	
	// echo "<hr><pre>$cssStr</pre>";
	
	if ($WRITE_FILES){
		echo "<HR>Writing to sprite file: $cssFile<BR>";
		$fh = fopen($cssFile, 'w') or die("Can't open css file");
		fwrite($fh, $cssStr);
		fclose($fh);
	}

	exit;
	
		 
   // has the form been submitted
   $bFormPosted = !empty($_POST);
   
   if ($bFormPosted) {
      // process form and uploaded ZIP file
      $bFormError = !$oCssSpriteGen->ProcessForm();
      $bUploadError = !(bool)($sFolderMD5 = $oCssSpriteGen->ProcessFile());
      
      // check for error
      if (!$bUploadError) {
         // get ZIP folder and MD5 has to store in hidden form fields
         // these are used if the form is resubmitted (options changed) to prevent the 
         // need to re-upload the ZIP file
         $oTemplate->Set('zipFolder', $oCssSpriteGen->GetZipFolder());
         $oTemplate->Set('zipFolderHash', $oCssSpriteGen->GetZipFolderHash());
      }
      
      // if no form or upload errors then get parameters for sprite image
      if (!$bFormError && !$bUploadError) {
	
         $oCssSpriteGen->CreateSprite($sFolderMD5);
         $oTemplate->Set('filename', $oCssSpriteGen->GetSpriteFilename());
         $oTemplate->Set('hash', $oCssSpriteGen->GetSpriteHash());
         $oTemplate->Set('css', $oCssSpriteGen->GetCss());
         $oTemplate->Set('validImages', $oCssSpriteGen->ValidImages());
      } else {
         $oTemplate->Set('validImages', false);
      }
      
      // pass error flags to template
      $oTemplate->Set('formError', $bFormError);
      $oTemplate->Set('uploadError', $bUploadError);
   }
   
   // get all errors
   $aFormErrors = $oCssSpriteGen->GetAllErrors();
   
   // pass data to template
   $oTemplate->Set('title', $oTranslations->Get('page.title.home'));
   $oTemplate->Set('maxFileSize', (int)(ConfigHelper::Get('/upload/max_file_size')));
   $oTemplate->Set('imageTypes', TemplateFunctions::ConvertArrayToMulti($oCssSpriteGen->GetImageTypes()));
   $oTemplate->Set('formPosted', $bFormPosted);
   $oTemplate->Set('formErrors', $aFormErrors);
   $oTemplate->Set('useApi', !empty($_GET['use-api']));
   $oTemplate->Set('functions', new TemplateFunctions($bFormPosted, $aFormErrors));
?>

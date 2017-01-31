<?php if ($formPosted): ?>
   <?php if ($formError || $uploadError || !$validImages): ?>
      <div id="error">
         <h2><?php echo $translation->Get('form.errors.title'); ?></h2>
         <ul>
            <?php if ($uploadError): ?>
               <li><?php echo $translation->Get('form.errors.invalid-file'); ?></li>
            <?php endif; ?>
            <?php if (!$formError && !$uploadError && !$validImages): ?>
               <li><?php echo $translation->Get('form.errors.zip'); ?></li>
            <?php endif; ?>
            <?php if ($formError): ?>
               <?php foreach ($formErrors['missing'] as $error): ?>
                  <li><?php echo $translation->Get('form.errors.missing.'.strtolower($error)); ?></li>
               <?php endforeach; ?>
               <?php foreach ($formErrors['invalid'] as $key => $value): ?>
                  <li><?php echo $translation->Get('form.errors.invalid.'.strtolower($key).'.'.strtolower($value)); ?></li>
               <?php endforeach; ?>
            <?php endif; ?>
         </ul>
      </div>
   <?php endif; ?>
   <?php if ($validImages): ?>
      <div id="result">
         <a href="<?php echo $appRoot; ?>" class="close"><?php echo $translation->Get('form.result.reset'); ?></a>
         <h2><?php echo $translation->Get('form.result.title.css-rules'); ?></h2>
         <form ><div><textarea rows="10" cols="70" readonly="readonly"><?php echo $css; ?></textarea></div></form>
         <p><?php echo $translation->Get('form.result.dont-forget')?></p>
         <pre class="background-example"><code>#container li {
   background: url(<?php echo $filename; ?>) no-repeat top left;
}</code></pre>
         <h2><?php echo $translation->Get('form.result.title.sprite-image'); ?></h2>
         <p><a class="download" href="<?php echo $appRoot; ?>?view=download&amp;file=<?php echo $filename; ?>&amp;hash=<?php echo $hash; ?>"><?php echo $translation->Get('form.result.download'); ?></a></p>
      </div>
   <?php endif; ?>
<?php endif; ?>
<form action="<?php echo $appRoot; ?><?php if ($useApi) echo 'api.php'; ?>" method="post" enctype="multipart/form-data" id="options">
   <fieldset>
      <legend><?php echo $translation->Get('form.legend.source-files'); ?></legend>
      <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $maxFileSize; ?>">
      <?php if ($formPosted && !$uploadError): ?>
         <input type="hidden" name="zip-folder" id="zip-folder" value="<?php echo $zipFolder; ?>">
         <input type="hidden" name="zip-folder-hash" id="zip-folder-hash" value="<?php echo $zipFolderHash; ?>">
      <?php endif; ?>
      <label for="path"<?php if ($formPosted && $uploadError) echo ' class="error"'; ?>><?php echo $translation->Get('form.label.upload-images'); ?><?php if ($formPosted && $uploadError) echo ' *'; ?>:</label>
      <div id="file-container">
         <input type="file" name="path" id="path"><span><?php echo $translation->Get('form.hint.max-upload-size', $maxFileSize / 1024 / 1024); ?></span>
         <?php if ($formPosted && !$uploadError): ?>
            <p><?php echo $translation->Get('form.hint.file-selected'); ?></p>
         <?php endif; ?>
      </div>
   </fieldset>  
   <fieldset class="duplicates">
      <legend><?php echo $translation->Get('form.legend.image-duplicates'); ?></legend>
      <?php echo $functions->RadioInput('ignore-duplicates', 'duplicates1', $translation->Get('form.label.ignore-duplicates'), 'ignore', 'ignore'); ?>
      <?php echo $functions->RadioInput('ignore-duplicates', 'duplicates2', $translation->Get('form.label.merge-duplicates'), 'merge', 'ignore'); ?>
   </fieldset>
   <fieldset id="resize">
      <legend><?php echo $translation->Get('form.legend.resize-source-images'); ?></legend>
      <?php echo $functions->TextInput('width-resize', $translation->Get('form.label.width'), 100, 3, '%'); ?>
      <?php echo $functions->TextInput('height-resize', $translation->Get('form.label.height'), 100, 3, '%'); ?>
   </fieldset>
   <fieldset>
      <legend><?php echo $translation->Get('form.legend.image-output-options'); ?></legend>
      <?php 
         echo $functions->SelectInput(
            'build-direction', 
            $translation->Get('form.label.build-direction'), 
            array(
               'horizontal' => $translation->Get('form.value.build-direction.horizontal'), 
               'vertical' => $translation->Get('form.value.build-direction.vertical')
            ), 
            'vertical', ''
         ); 
      ?>
      <?php echo $functions->TextInput('horizontal-offset', $translation->Get('form.label.horizontal-offset'), 50, 5, 'px'); ?>
      <?php echo $functions->TextInput('vertical-offset', $translation->Get('form.label.vertical-offset'), 50, 5, 'px'); ?>
      <label for="wrap-columns"><?php echo $translation->Get('form.label.wrap-columns'); ?>:</label><input type="checkbox" name="wrap-columns" id="wrap-columns"<?php if (!$formPosted || isset($_POST['wrap-columns'])) echo ' checked="checked"'; ?>>

      <?php echo $functions->TextInput('background', $translation->Get('form.label.background-colour'), '', 7, $translation->Get('form.hint.transparency'), true); ?>
      <label for="use-transparency"><?php echo $translation->Get('form.label.use-transparency'); ?>:</label><input type="checkbox" name="use-transparency" id="use-transparency"<?php if (!$formPosted || isset($_POST['use-transparency'])) echo ' checked="checked"'; ?>>

      <?php echo $functions->SelectInput('image-output', $translation->Get('form.label.image-output-format'), $imageTypes, '', ''); ?> 
      <?php echo $functions->ColourSelectInput('image-num-colours', $translation->Get('form.label.image-output-num-colours'), $translation->Get('form.value.true-colour'), 'true-colour', ''); ?>
      <?php echo $functions->TextInput('image-quality', $translation->Get('form.label.image-output-quality'), 75, 3, '%'); ?>
      
      <label for="use-optipng"><?php echo $translation->Get('form.label.use-optipng'); ?>:</label><input type="checkbox" name="use-optipng" id="use-optipng"<?php if (isset($_POST['use-optipng'])) echo ' checked="checked"'; ?>> 
   </fieldset>
   <fieldset>
      <legend><?php echo $translation->Get('form.legend.css-output-options'); ?></legend>
      <?php echo $functions->TextInput('selector-prefix', $translation->Get('form.label.css-prefix'), '', null, $translation->Get('form.hint.css-prefix'), true); ?>
      <?php echo $functions->TextInput('file-regex', $translation->Get('form.label.filename-pattern-match'), '', null, $translation->Get('form.hint.filename-pattern-match'), true); ?>
      <?php echo $functions->TextInput('class-prefix', $translation->Get('form.label.class-prefix'), 'sprite-', null, $translation->Get('form.hint.class-prefix'), true); ?>
      <?php echo $functions->TextInput('selector-suffix', $translation->Get('form.label.css-suffix'), '', null, $translation->Get('form.hint.css-suffix'), true); ?>
   </fieldset>
   <p><input class="submit" type="submit" name="sub" value="<?php echo $translation->Get('form.button.create-sprite'); ?>"></p>
</form>

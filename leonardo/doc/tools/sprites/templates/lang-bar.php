<?php if (count($languages)): ?>
   <ul>
      <?php foreach ($languages as $code => $name): ?>
         <?php if ($languageSwitch == 'host'): ?>
            <?php if ($code == 'en'): ?>
               <li><a href="http://<?php echo $toolUrl; ?><?php echo $functions->GetMenuUrl('', $view); ?>"<?php if ($code == $language) echo ' class="selected"'; ?>><?php echo $name['native']; ?></a></li>
            <?php else: ?>
               <li><a href="http://<?php echo $code; ?>.<?php echo $toolUrl; ?><?php echo $functions->GetMenuUrl('', $view); ?>"<?php if ($code == $language) echo ' class="selected"'; ?>><?php echo $name['native']; ?></a></li>
            <?php endif; ?>
         <?php else: ?>
            <li><a href="<?php echo $appRoot; ?><?php echo $functions->GetMenuUrl('', $view); ?>&lang=<?php echo $code; ?>"<?php if ($code == $language) echo ' class="selected"'; ?>><?php echo $name['native']; ?></a></li>
         <?php endif; ?>
      <?php endforeach; ?>
   </ul>
<?php endif; ?>

<div>
   <label for="<?php echo $id; ?>"<?php if ($optional): ?> class="optional<?php if ($error): ?> error<?php endif; ?>"<?php elseif ($error): ?> class="error"<?php endif; ?>><?php echo $label; ?><?php if ($error): ?> *<?php endif; ?>:
   </label>
   <input type="text" name="<?php echo $id; ?>" value="<?php echo $value; ?>" id="<?php echo $id; ?>"
   <?php if (!is_null($size)): ?> 
      size="<?php echo $size; ?>" maxlength="<?php echo $size; ?>"
   <?php endif; ?>
   <?php if ($error): ?>
      class="error"
   <?php endif; ?>>
   <?php if (!empty($hint)): ?>
      <span<?php if ($hint != '%' && $hint != 'px'): ?> class="help"<?php endif; ?>><?php echo $hint; ?></span>
   <?php endif; ?>
</div>
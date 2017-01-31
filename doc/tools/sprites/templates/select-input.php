<div>
   <label for="<?php echo $id; ?>"><?php echo $label; ?>:</label>
   <select name="<?php echo $id; ?>" id="<?php echo $id; ?>">
      <?php foreach ($options as $key => $label): ?>
         <option value="<?php echo $key; ?>"<?php if ($key == $value): ?> selected="selected"<?php endif; ?>>
         <?php echo $label; ?></option>
      <?php endforeach; ?>
   </select>
</div>
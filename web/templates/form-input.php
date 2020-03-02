<input type="<?php print $vars['type'] ?>" name="<?php print $vars['name'] ?>"

  <?php if (!empty($vars['placeholder'])): ?>
      placeholder="<?php print $vars['placeholder'] ?>"
  <?php endif; ?>

  <?php if (!empty($vars['value'])): ?>
       value="<?php print $vars['value'] ?>
<?php endif; ?>
">
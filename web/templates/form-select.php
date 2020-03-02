<select name="<?php print $vars['name'] ?>">

  <?php foreach ($vars['info'] as $value): ?>

      <option name="<?php print $value ?>"> <?php print $value ?></option>

  <?php endforeach; ?>

</select>
<form action="<?php print $vars['action'] ?>" method="<?php print $vars['method'] ?>">

  <?php foreach ($vars['content'] as $content): ?>
    <?php print $content ?>
  <?php endforeach; ?>

</form>
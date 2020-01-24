<?php

function template_load($template, $vars) {
  ob_start();
  include $template;
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}

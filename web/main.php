<?php

function template_load($template, $vars)
{
  ob_start();
  include $template;
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}


function system_init($allow_any = FALSE)
{
  if (!$allow_any) {
    $current_user = system_user();
    if ($current_user !== NULL) {
      return;
    }
    header('Refresh: 0; URL=login.php');
    exit();
  }
}


function system_user()
{
  session_start();
  if (isset($_SESSION['userid'])) {
    return [
      'email' => $_SESSION['email'],
      'userid' => $_SESSION['userid'],
    ];
  } else {
    return NULL;
  }
}


function db_selects($select, $tabelle, $conditions)
{
  $pdo = new PDO('mysql:host=localhost;dbname=stepbystep', 'root', '');
  $statement = $pdo->prepare("SELECT " . db_set_alias($select) . " FROM $tabelle WHERE " . db_condition_builder($placeholders, ' AND ', $conditions));
  $statement->execute($placeholders);
  print_r($statement->errorInfo());
  return $statement->fetchAll(PDO::FETCH_ASSOC);
}


function db_set_alias($select)
{
  $return = [];
  foreach ($select as $alias => $field) {
    if (is_string($alias)) {
      $return[] = $field . ' ' . 'AS' . ' ' . $alias;
    } else {
      $return[] = $field;
    }
  }
  return implode(', ', $return);
}


function db_condition_builder(&$bag, $connector, $conditions)
{
  $changed = [];
  foreach ($conditions as $item) {
    if ($item['operator'] === 'IN') {
      $value = implode(', ', $item['value']);
      $item['value'] = $value;
      $changed[] = $item['field'] . ' ' . $item['operator'] . ' (:' . $item['field'] . ')';

    } else {
      $changed[] = $item['field'] . ' ' . $item['operator'] . ' :' . $item['field'];
    }
    $bag[':' . $item['field']] = $item['value'];
  }
  return implode($connector, $changed);
}


function db_insert($field, $tabelle, $values)
{
  $pdo = new PDO('mysql:host=localhost;dbname=stepbystep', 'root', '');
  $statement = $pdo->prepare("INSERT INTO $tabelle ($field) VALUES ($values)");
  $statement->execute();
  print_r($statement->errorInfo());
  return $statement->fetchAll(PDO::FETCH_ASSOC);
}
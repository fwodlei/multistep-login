<?php

// TABELLE

require_once ('main.php');

$a = [[
  '250',
  'Email',
  'Vorname',
  'Nachname',
  'Info',
],
[
  '251',
  'Email',
  'Vorname',
  'Nachname',
  'Info',
]];

$body = template_load('templates/tabelle.php',[
  'columns' => [
    'id' => 'ID',
    'email' => 'Email',
    'vorname' => 'Vorname',
    'nachname' => 'Nachname',
    'info' => 'Info'
  ],
  'rows' => $a,
]);
print template_load('templates/html.php',[
    'body' => $body,
    'pagetitle' => 'Registrierung',
  ]
);

########################################################################################################################

// FORM

$input = template_load('templates/form-input.php',[
  'type' => 'text',
  'name' => 'name',
  'placeholder' => 'Name',
]);

$select = template_load('templates/form-select.php',[
  'selectname' => '',
  'name' => '',
  'text' => ''
]);

print template_load('templates/form.php',[
  'content' => $input,
  'action' => './addentry.php',
  'method' => 'post',
  ]
);
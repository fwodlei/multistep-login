<?php
//
// TABELLE
//
//require_once ('main.php');
//
//$a = [[
//  '250',
//  'Email',
//  'Vorname',
//  'Nachname',
//  'Info',
//],
//[
//  '251',
//  'Email',
//  'Vorname',
//  'Nachname',
//  'Info',
//]];
//
//$body = template_load('templates/tabelle.php',[
//  'columns' => [
//    'id' => 'ID',
//    'email' => 'Email',
//    'vorname' => 'Vorname',
//    'nachname' => 'Nachname',
//    'info' => 'Info'
//  ],
//  'rows' => $a,
//]);
//print template_load('templates/html.php',[
//    'body' => $body,
//    'pagetitle' => 'Registrierung',
//  ]
//);
//
//########################################################################################################################
//
//// FORM
//
//$input = template_load('templates/form-input.php',[
//  'type' => 'text',
//  'name' => 'name',
//  'placeholder' => 'Name',
//]);
//
//$input2 = template_load('templates/form-input.php',[
//  'type' => 'text',
//  'name' => 'name',
//  'placeholder' => 'Vorname',
//]);
//
//$input3 = template_load('templates/form-input.php',[
//  'type' => 'text',
//  'name' => 'name',
//  'placeholder' => 'Email',
//]);
//
//$select = template_load('templates/form-select.php',[
//  'name' => '',
//  'options' => [
//    'a' => 'A',
//    'c' => 'C',
//    'b' => 'B',
//    'd' => 'D',
//    'e' => 'E'
//  ],
//]);
//
//print template_load('templates/form.php',[
//    'content' => $input,
//    'action' => './addentry.php',
//    'method' => 'post',
//  ]
//);
//
//print template_load('templates/form.php',[
//    'content' => $select,
//    'action' => './addentry.php',
//    'method' => 'post',
//  ]
//);

require_once('classtest.php');

$max = new User();
$max->setName("Max Mustermann");
$max->setEmail("max@muster.de");

$lisa = new User();
$lisa->setName("Lisa Meier");
$lisa->setEmail("lisa@meier.de");

print_r($max->getName());
echo '</br >';
print_r($max->getEmail());
echo '<hr>';
print_r($lisa->getName());
echo '</br >';
print_r($lisa->getEmail());


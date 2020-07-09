<?php

require_once('main.php');
system_init();


$email = 0;
$pdo = new PDO('mysql:host=localhost;dbname=stepbystep', 'root', '');

$id = 0;

$statement = $pdo->prepare("SELECT u_id FROM info");
$result = $statement->execute(array(':id' => $id));
$result = $statement->fetchAll();

$statementuser = $pdo->prepare("SELECT id FROM users");
$resultuser = $statementuser->execute(array(':id' => $id));
$resultuser = $statementuser->fetchAll();


if ($result = $resultuser) {
  header('Refresh: 0; URL=private.php');
  echo 'Sie werden weitergeleitet, falls dies nicht der Fall sein sollte klicken Sie <a href="private.php">HIER</a>';
} else {
  echo 'AN ERROR OCCOURED';
}
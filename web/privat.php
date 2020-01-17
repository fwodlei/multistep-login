<?php
session_start();

  $pdo = new PDO('mysql:host=localhost;dbname=stepbystep', 'root', '');
  $id = 0;

  $statement = $pdo->prepare("SELECT * from info");
  $result = $statement->execute(array(':id' => $id));
  $result = $statement->fetchAll();

  print_r($result);

  print (

  );
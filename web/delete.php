<?php

require_once('main.php');

system_init();

session_start();

$u_id = $_SESSION['userid'];
$id = ($_POST['id']);

if ($u_id != 53) {
  $pdo = new PDO('mysql:host=localhost;dbname=stepbystep', 'root', '');
  $statement = $pdo->prepare("DELETE FROM info WHERE u_id = $u_id AND id = $id");
  $statement->execute(array(1));
} elseif ($u_id = 53) {
  $pdo = new PDO('mysql:host=localhost;dbname=stepbystep', 'root', '');
  $statement = $pdo->prepare("DELETE FROM info WHERE id = $id ");
  $statement->execute(array(1));
}

echo '<a href="private.php">Zurück in den privaten Bereich</a>';
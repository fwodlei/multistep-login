<?php
$email = 0;
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=stepbystep', 'root', '');

$id = 0;

$statement = $pdo->prepare("SELECT u_id FROM info");
$result = $statement->execute(array(':id' => $id));
$result = $statement->fetchAll();

$statementuser = $pdo->prepare("SELECT id FROM users");
$resultuser = $statementuser->execute(array(':id' => $id));
$resultuser = $statementuser->fetchAll();


if ($result = $resultuser){
  echo 'Sie werden weitergeleitet, falls dies nicht der Fall sein sollte klicken Sie <a href="private.php">HIER</a>';
  header('Refresh: 0; URL=private.php');
}
else {
  echo 'A MISTAKE OCCURRED';
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Registrierung</title>
</head>
<body>
</body>
</html>

<?php
  session_start();

  $u_id = $_SESSION['userid'];

$pdo = new PDO('mysql:host=localhost;dbname=stepbystep', 'root', '');
$statement = $pdo->prepare("UPDATE info SET email = DEFAULT, vorname = DEFAULT, nachname = DEFAULT, info = DEFAULT WHERE u_id = $u_id ");
$statement->execute(array(1));

  echo 'Daten erfolgreich gelöscht';
  echo '</br></br>';
  echo '<a href="private.php">Zurück zum privaten Bereich.</a>';




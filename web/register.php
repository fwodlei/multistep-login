<?php

use Couchbase\PasswordAuthenticator;

session_start();
  $pdo = new PDO('mysql:host=localhost;dbname=stepbystep', 'root', '');
?>

<!DOCTYPE html>
<html>
<head>
  <title>Registrierung</title>
</head>
<body>

<?php


$showFormular = TRUE;

if (isset($_GET['register'])) {
  $error = FALSE;
  $email = $_POST['email'];
  $passwort = $_POST['passwort'];
  $passwort2 = $_POST['passwort2'];

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'Bitte geben Sie eine gültige Email an';
    $error = TRUE;
  }

  if (strlen($passwort) == 0) {
    echo 'Geben Sie ein Passwort ein';
    $error = TRUE;
  }

  if ($passwort != $passwort2) {
    echo 'Die Passwörter müssen überstimmen';
    $error = TRUE;
  }

  if (!$error) {
    $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();


    if ($user !== FALSE) {
      echo 'Diese E-Mail ist bereits vergeben';
      $error = TRUE;
    }


  }

  if (!$error) {
    $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);
    $statement = $pdo->prepare("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'stepbystep' AND TABLE_NAME = 'users';");
    $statement->execute();
    $current_auto_increment = $statement->fetch();

    $statement = $pdo->prepare('INSERT INTO users (email, passwort) VALUES (:email, :passwort)');
    $result = $statement->execute(array('email' => $email, 'passwort' => $passwort_hash));

    $statement = $pdo->prepare('INSERT INTO info (u_id) VALUES (:u_id)');
    $result = $statement->execute(array('u_id' => $current_auto_increment['AUTO_INCREMENT']));

    if ($result) {
      $showFormular = FALSE;
      $login = TRUE;
      $_SESSION['login'] = [
            'login' => $login,
          ];
    } else {
      echo 'Beim Abspeichern ist leider ein Fehler aufgetreten';
    }
    if ($_SESSION['login']) {
      echo 'Sie werden weitergeleitet, falls dies nicht der Fall sein sollte klicken Sie <a href="in.php">HIER</a>';
      header('Refresh: 2; URL=in.php');
    }
  }
}

if ($showFormular) {
  ?>

      <form action="?register=1" method="post" style="margin: 100px 42.5%">
        E-Mail:<br>
        <input type="email" size="40" maxlength="250" name="email"><br><br>
        Dein Passwort:<br>
        <input type="password" size="40" maxlength="250" name="passwort"><br>
        Passwort wiederholen:<br>
        <input type="password" size="40" maxlength="250" name="passwort2"><br><br>

        <input type="submit" value="Abschicken">
      </br></br>
          <a href="login.php">LOGIN</a>
      </form>

      <?php
    }
    ?>
</body>
</html>
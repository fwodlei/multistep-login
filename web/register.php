<?php

use Couchbase\PasswordAuthenticator;

session_start();
  $pdo = new PDO('mysql:host=localhost;dbname=stepbystep', 'root', '');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrierung</title>
    <link rel="stylesheet" href="styles/register.css">
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
    $statement->execute();
    $current_auto_increment = $statement->fetch();

    $statement = $pdo->prepare('INSERT INTO users (email, passwort) VALUES (:email, :passwort)');
    $result = $statement->execute(array('email' => $email, 'passwort' => $passwort_hash));

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

     $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
     $result = $statement->execute(array('email' => $email));
     $user = $statement->fetch();
     $_SESSION['userid'] = $user['id'];

      echo 'Sie werden weitergeleitet, falls dies nicht der Fall sein sollte klicken Sie <a href="in.php">HIER</a>';
      header('Refresh: 2; URL=in.php');
    }
  }
}

if ($showFormular) {
  ?>
    <div class="main">
        <div class="actions-box">
            <div class="actions-box__left">

            </div>
            <div class="actions-box__right">
                <form class="actions-box__form" action="?register=1" method="post">
                    <div class="actions-box__inputs">
                    <div class="actions-box__login">
                        <span class="actions-box__label">Email:</span>
                        <input type="email" size="40" maxlength="250" name="email" class="actions-box__text-input">
                    </div>
                    <div class="actions-box__password">
                        <span class="actions-box__label">Password:</span>
                        <input type="password" size="40" maxlength="250" name="passwort" class="actions-box__text-input">
                    </div>
                    <div class="actions-box__password">
                        <span class="actions-box__label">Repeat Password:</span>
                        <input type="password" size="40" maxlength="250" name="passwort2" class="actions-box__text-input">
                    </div>
                <input type="submit" value="Abschicken">
                        <a href="login.php"><input type="button" value="Zum Login"></a>
            </form>
        </div>
    </div>

      <?php
    }
    ?>
</body>
</html>
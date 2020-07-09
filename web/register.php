<?php

require_once('main.php');

system_init(TRUE);

session_start();
$pdo = new PDO('mysql:host=localhost;dbname=stepbystep', 'root', '');

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

    $result = db_selects(
      [
        '*',
      ],
      'users',
      [
        [
          'value' => $email,
          'field' => 'email',
          'operator' => '=',
        ],
      ]
    );

    $user = array_shift($result);

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

  $register = template_load('templates/register.php', '');

  print template_load('templates/html.php', [
      'body' => template_load('templates/page.php', [
        'content' => $register,
      ]),
      'pagetitle' => 'Register',
    ]
  );
}
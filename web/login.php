<?php

require_once('main.php');

session_start();
$pdo = new PDO('mysql:host=localhost;dbname=stepbystep', 'root', '');

if (isset($_GET['login'])) {
  $email = $_POST['email'];
  $passwort = $_POST['passwort'];

  $test = 1;

  $result = db_selects(
    [
      ### ERSTER WERT ALIAS ###
      'e' => 'email',
      'passwort',
      'id',
    ],
    'users',
    [
      [
        'value' => $email,
        'field' => 'email',
        'operator' => '=',
      ],
      [
        'operator' => 'IN',
        'field' => 'id',
        'value' => [53, 54, 55],
      ],
    ]
  );


  $_SESSION['email'] = $email;

  $user = array_shift($result);

  if (isset($user) && password_verify($passwort, $user['passwort'])) {
    $_SESSION['userid'] = $user['id'];
    header('Refresh: 1; URL=in.php');
    print('Login erfolgreich. Weiter zu <a href="in.php">internen Bereich</a>');
  } else {
    $errorMessage = "E-Mail oder Passwort war ungültig<br>";
  }
}

if (isset($errorMessage)) {
  echo $errorMessage;
}


$login = template_load('templates/login.php', []);
print template_load('templates/html.php', [
    'body' => template_load('templates/page.php', [
      'content' => $login,
    ]),
    'pagetitle' => 'Login',
  ]
);
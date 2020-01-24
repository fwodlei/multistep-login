<?php

require_once('main.php');


session_start();
$pdo = new PDO('mysql:host=localhost;dbname=stepbystep', 'root', '');

if (isset($_GET['login'])) {
  $email = $_POST['email'];
  $passwort = $_POST['passwort'];

  $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
  $result = $statement->execute(array('email' => $email));
  $user = $statement->fetch();


  if ($user !== false && password_verify($passwort, $user['passwort'])) {
    $_SESSION['userid'] = $user['id'];
    header('Refresh: 1; URL=in.php');
    die('Login erfolgreich. Weiter zu <a href="in.php">internen Bereich</a>');
  }
  else {
    $errorMessage = "E-Mail oder Passwort war ungültig<br>";
  }
}

if(isset($errorMessage)) {
  echo $errorMessage;
}


$login = template_load('templates/login.php',[]);
print template_load('templates/html.php',[
      'body' => template_load('templates/page.php',[
      'content' => $login,
    ]),
    'pagetitle' => 'Login',
  ]
);




<?php
session_start();

$u_id = $_SESSION['userid'];
$a = 0;

  if (empty($_SESSION['id'])) {
    $pdo = new PDO('mysql:host=localhost;dbname=stepbystep', 'root', '');
    $statement = $pdo->prepare("INSERT INTO info (id, email, vorname, nachname, info, u_id) VALUES ( LAST_INSERT_ID(), '', '', '', '', $u_id)");
    $statement->execute(array());

    $statement = $pdo->prepare("SELECT (id) FROM info WHERE u_id = $u_id ORDER BY id DESC LIMIT 1");
    $statement->execute(array());
    $id = $statement->fetch();

    $_SESSION['id'] = $id;
  } else {
    $id = $_SESSION['id'];
  }

$db = mysqli_connect("localhost", "root", "", "stepbystep");
if(!$db)
{
  exit("Verbindungsfehler: ".mysqli_connect_error());
}
$results = [];
$allvalues = [
  'name',
  'vorname',
  'email',
  'step-1',

  'info',
  'step-2',
];

foreach ($allvalues as $key) {
  if (isset($_POST[$key]) &&  $_POST[$key] != '') {
    $results[$key] = $_POST[$key];
    $_SESSION[$key] = $_POST[$key];
  } else {
    $results[$key] ='';
  }

};

if (!empty($_SESSION['step-1']) && !empty($_SESSION['step-2'])) {
  $filtered_array = array_filter($_SESSION, function ($a) {
    if (is_array($a)) {
      return FALSE;
    }
    return (strpos($a, 'Senden') !== 0) && !is_numeric($a);
  });
  $eintrag = "UPDATE info SET email='" . $filtered_array['email'] . "', vorname='" . $filtered_array['vorname'] . "', nachname='" . $filtered_array['name'] . "', info='" . $filtered_array['info'] . "' WHERE id = " . $id['id'];
  mysqli_query($db, $eintrag);
  mysqli_close($db);
  print_r($eintrag);
}

if (!empty($_SESSION['step-1']) && !empty($_SESSION['step-2'])) {
  unset( $_SESSION['name']);
  unset( $_SESSION['vorname']);
  unset( $_SESSION['email']);
  unset( $_SESSION['step-1']);
  unset( $_SESSION['info']);
  unset( $_SESSION['step-2']);
  unset( $_SESSION['id']);
}



?>

  <!DOCTYPE html>
  <html lang="de">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Multistepform</title>
  </head>
  <body>

  <?php if (empty($_SESSION['step-1']) ): ?>
    <div class="step-1">
      <form action="./addentry.php" method="post">
        <input name="name" placeholder="Name" type="text">
        <input name="vorname" placeholder="Vorname" type="text">
        <input name="email" placeholder="Email" type="email">
        <input name="step-1" type="submit">
        <a href="private.php">Zurück zum privaten Bereich.</a>
      </form>
    </div>
  <?php endif; ?>

  <?php if (empty($_SESSION['step-2']) && ! empty($_SESSION['step-1'])): ?>
    <div class="step-2">
      <form action="./addentry.php" method="post">
        <select name="info">
          <option name="Party">Party</option>
          <option name="Arbeit">Arbeit</option>
          <option name="Kirche">Kirche</option>
        </select>
        <input name="step-2" type="submit">
      </form>
    </div>
  <?php endif; ?>
  </body>
  </html>

<?php

if(isset($_GET['d'])){
  unset( $_SESSION['name']);
  unset( $_SESSION['vorname']);
  unset( $_SESSION['email']);
  unset( $_SESSION['step-1']);
  unset( $_SESSION['info']);
  unset( $_SESSION['step-2']);
  unset( $_SESSION['id']);
}
?>
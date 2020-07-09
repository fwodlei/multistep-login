<?php

require_once('main.php');

system_init();

$pdo = new PDO('mysql:host=localhost;dbname=stepbystep', 'root', '');
$u_id = $_SESSION['userid'];

if ($u_id == 53) {

  $fieldLabels = [
    'id' => 'ID',
    'email' => 'Email',
    'vorname' => 'Vorname',
    'nachname' => 'Nachname',
    'info' => 'Info'
  ];

  $db = new PDO('mysql:host=localhost;dbname=stepbystep;charset=utf8', 'root', '');

  $sql = "
    SELECT " . implode(', ', array_keys($fieldLabels)) . " FROM info";

  $customers = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

  header('Content-Type: text/html; charset=utf-8');

  $private = template_load('templates/tabelle.php', [
    'columns' => [
      'id' => 'ID',
      'email' => 'Email',
      'vorname' => 'Vorname',
      'nachname' => 'Nachname',
      'info' => 'Info'
    ],
    'rows' => $customers,
  ]);

  if (isset($_POST['text'])) {
    $statement = $pdo->prepare("SELECT email, nachname, vorname, info FROM info");
    $result = $statement->execute();
  }

  print template_load('templates/html.php', [
      'body' => template_load('templates/page.php', [
        'content' => $private,
      ]),
      'pagetitle' => 'Private',
    ]
  );


} elseif ($u_id != 53) {


  $fieldLabels = [
    'id' => 'ID',
    'email' => 'Email',
    'vorname' => 'Vorname',
    'nachname' => 'Nachname',
    'info' => 'Info',
  ];

  $db = new PDO('mysql:host=localhost;dbname=stepbystep;charset=utf8', 'root', '');

  $sql = "SELECT " . implode(', ', array_keys($fieldLabels)) . " FROM info WHERE u_id = $u_id ";

  $customers = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

  header('Content-Type: text/html; charset=utf-8');

  $private = template_load('templates/tabelle.php', [
    'columns' => [
      'id' => 'ID',
      'email' => 'Email',
      'vorname' => 'Vorname',
      'nachname' => 'Nachname',
      'info' => 'Info'
    ],
    'rows' => $customers,
  ]);

  if (isset($_POST['text'])) {
    $statement = $pdo->prepare("SELECT email, nachname, vorname, info FROM info WHERE u_id = $u_id ");
    $result = $statement->execute();
  }

  print template_load('templates/html.php', [
      'body' => template_load('templates/page.php', [
        'content' => $private,
      ]),
      'pagetitle' => 'Privat',
    ]
  );
}

echo '<a href="logout.php">     LOGOUT     </a><br><a href="addentry.php">     ADD ENTRY     </a>';



<?php
session_start();

require_once('main.php');

template_load('', '');

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

$addentry = template_load('templates/register.php',[]);
print template_load('templates/html.php',[
    'body' => template_load('templates/page.php',[
      'content' => $addentry,
    ]),
    'pagetitle' => 'Eintrag hinufügen',
  ]
);


if(isset($_GET['d'])){
  unset( $_SESSION['name']);
  unset( $_SESSION['vorname']);
  unset( $_SESSION['email']);
  unset( $_SESSION['step-1']);
  unset( $_SESSION['info']);
  unset( $_SESSION['step-2']);
  unset( $_SESSION['id']);
}


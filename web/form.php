<?php
$a=0;

session_start();

$user['id'] = $_SESSION['userid'];

$u_id = $user['id'];

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
    return (strpos($a, 'Senden') !== 0) && !is_numeric($a);
  });
  $eintrag = "UPDATE info SET email='" . $filtered_array['email'] . "', vorname='" . $filtered_array['vorname'] . "', nachname='" . $filtered_array['name'] . "', info='" . $filtered_array['info'] . "' WHERE u_id = " . $u_id;
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
  header('Refresh: 0; URL=private.php');
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
        <form action="./form.php" method="post">
            <input name="name" placeholder="Name" type="text">
            <input name="vorname" placeholder="Vorname" type="text">
            <input name="email" placeholder="Email" type="email">
            <input name="step-1" type="submit">
        </form>
    </div>
<?php endif; ?>

<?php if (empty($_SESSION['step-2']) && ! empty($_SESSION['step-1'])): ?>
    <div class="step-2">
        <form action="./form.php" method="post">
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
}
?>
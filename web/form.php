<?php
$a=0;
session_start();
$db = mysqli_connect("localhost", "root", "", "Multistepform");
if(!$db)
{
  exit("Verbindungsfehler: ".mysqli_connect_error());
}
if (!empty($_SESSION['step-1']) && !empty($_SESSION['step-2']) && !empty($_SESSION['step-3'])){
  $filtered_array = array_filter($_SESSION, function ($a) {
    return (strpos($a, 'Senden') !== 0) && !is_numeric($a);
  });
  $eintrag = "INSERT INTO MultiStepForm (Nname, Vorname, Email, Datum, Aktivität, Strasse, Hausnummer, PLZ, Ort) VALUES ( '" . implode("', '", $filtered_array) ."');";
  mysqli_query($db, $eintrag);
  mysqli_close($db);

  $empfaenger = $_SESSION['email'];
  $betreff = $_SESSION['datum'];
  $nname = $_SESSION['name'];
  $from = "From: Oettinger Jr. <oettinger.jr@oettinger.de>\r\n";
  $from .= "Reply-To: antwort@domain.de\r\n";
  $from .= "Content-Type: text/html\r\n";
  $text = "Sehr geerehter Herr/Frau" . $nname . ", warum schmecken die Dinger eigentlich so scheisse?" ;
  print implode('</br>', [ $empfaenger, $betreff, $text, $from]) . "</br>";


  $mail = mail($empfaenger, $betreff, $text, $from);

  if ($mail) {
    print "Worked";
  } else {
    print "failed";
  }

  print '</br><a href="privat.php">HEHEHEH</a>';

}
$results = [];
$allvalues = [
  'name',
  'vorname',
  'email',
  'step-1',

  'datum',
  'activity',
  'step-2',

  'strasse',
  'hausnummer',
  'plz',
  'ort',
  'step-3',

];
foreach ($allvalues as $key) {
  if (isset($_POST[$key]) &&  $_POST[$key] != '') {
    $results[$key] = $_POST[$key];
    $_SESSION[$key] = $_POST[$key];
  } else {
    $results[$key] ='';
  }

}

if(isset($_GET['d'])){
  session_destroy();
};

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
    <form action="form.php" method="post">
      <input name="name" placeholder="Name" type="text">
      <input name="vorname" placeholder="Vorname" type="text">
      <input name="email" placeholder="Email" type="email">
      <input name="step-1" type="submit">
    </form>
  </div>
<?php endif; ?>

<?php if (empty($_SESSION['step-2']) && ! empty($_SESSION['step-1'])): ?>
  <div class="step-2">
    <form action="form.php" method="post">
      <input name="datum" placeholder="Datum" type="date">
      <select name="activity">
        <option name="Party">Party</option>
        <option name="Arbeit">Arbeit</option>
        <option name="Kirche">Kirche</option>
      </select>
      <input name="step-2" type="submit">
    </form>
  </div>
<?php endif; ?>

<?php if (empty($_SESSION['step-3']) && ! empty($_SESSION['step-2']) ): ?>
  <div class="step-3">
    <form action="form.php" method="post">
      <input name="strasse" placeholder="Straße" type="text">
      <input name="hausnummer" placeholder="Hausnummer" type="text">
      <input name="plz" placeholder="PLZ" type="text">
      <input name="ort" placeholder="Ort" type="text">
      <input name="step-3" type="submit">
    </form>
  </div>
<?php endif; ?>
</body>
</html>
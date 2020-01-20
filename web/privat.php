<?php
session_start();

  $pdo = new PDO('mysql:host=localhost;dbname=stepbystep', 'root', '');
  $id = 0;
  $u_id = $_SESSION['userid'];

  $statement = $pdo->prepare("SELECT email, nachname, vorname, info FROM info WHERE u_id=' " . $u_id . " ' ");
  $result = $statement->execute(array('id' => $id));
  $result = $statement->fetchAll();

  $email = $result[0]['email'];
  $vorname = $result[0]['vorname'];
  $nachname = $result[0]['nachname'];
  $info = $result[0]['info'];
?>

<!DOCTYPE html>
<html>
<head>
  <title>PRIVAT</title>
</head>
<body>
<table>
  <thead style="text-align: center">
    <td style="width: 100px">EMAIL</td>
    <td style="width: 100px">-----</td>
    <td style="width: 100px">VORNAME</td>
    <td style="width: 100px">-----</td>
    <td style="width: 100px">NACHNAME</td>
    <td style="width: 100px">-----</td>
    <td style="width: 100px">INFO</td>
  </thead>
  <tbody style="text-align: center">
    <td style="width: 100px"><?php print $email; ?></td>
    <td style="width: 100px">-----</td>
    <td style="width: 100px"><?php print $vorname; ?></td>
    <td style="width: 100px">-----</td>
    <td style="width: 100px"><?php print $nachname; ?></td>
    <td style="width: 100px">-----</td>
    <td style="width: 100px"><?php print $info; ?></td>
  </tbody>
</table>

<a href="logout.php">LOGOUT</a>
<a href="delete.php">DELETE</a>

</body>
</html>
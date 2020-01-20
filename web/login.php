<?php
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

?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>

<?php
if(isset($errorMessage)) {
  echo $errorMessage;
}
?>

<form action="?login=1" method="post">
  E-Mail:<br>
  <input type="email" size="40" maxlength="250" name="email"><br><br>

  Dein Passwort:<br>
  <input type="password" size="40"  maxlength="250" name="passwort"><br>

  <input type="submit" value="Abschicken">
</form>
</br></br>
<a href="register.php"> Registrieren</a>

</body>
</html>

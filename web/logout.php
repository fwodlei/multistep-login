<?php
session_start();
session_destroy();

echo "Logout erfolgreich";
echo '</br>';
echo '<a href="login.php">Hier geht´s zum Login.</a>'
?>
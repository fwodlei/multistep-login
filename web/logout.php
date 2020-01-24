<?php

require_once('main.php');

session_start();
session_destroy();

echo"Logout erfolgreich <br> <a href=\"login.php\">Hier geht´s zum Login.</a>";


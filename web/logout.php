<?php

require_once('main.php');

session_start();
session_destroy();

system_init();

echo "Logout erfolgreich <br> <a href=\"login.php\">Hier geht´s zum Login.</a>";


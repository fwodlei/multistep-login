<?php

session_start();

  if (isset($_SESSION['userid'])) {
    $u_id = $_SESSION['userid'];
  } else {
   $u_id = '';
  }

  if ($u_id != NULL) {
    header('Refresh: 0; URL=private.php');
  } else {
    header('Refresh: 0; URL=login.php');
  }
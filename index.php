<?php
  require_once './includes/db.php';
  require_once './includes/session.php';


  if ($loggedIn) {
    $_SESSION['info'] = "Logged in as " . $_SESSION['username'];
    header('Location: ./home.php');
  } else {
    header('Location: ./login.php');
  }
?>
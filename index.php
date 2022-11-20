<?php
  require_once "./includes/db.php";
  session_start();
  if (
    isset($_SESSION['username']) &&
    isset($_SESSION['password'])
  ) {
    sql_query()

    header('Location: ./home.php');
  } else {
    header('Location: ./login.php');
  }
?>
<?php
  include "db.php";

  $email = $_POST['email'];
  $password = md5($_POST['password']);

  $result = $connection->query("SELECT * FROM `users2` WHERE Email = '$email' AND Password = '$password' LIMIT 1")->fetch_assoc();

  if ($result != null) {
      session_start();
      //$_SESSION['ID'] = $result['ID'];
      header("Location: ../backend/index.php");
  } else {
    header("Location: index.php?session=404 Not Found");
  }
  // header("Location: index.php");
?>

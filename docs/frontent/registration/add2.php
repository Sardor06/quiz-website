<?php
  include "db.php";

  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = md5($_POST['pass']);

  $connection->query("INSERT INTO `users2`(`ID`, `Name`, `Email`, `Password`) VALUES (null, '$name', '$email', '$password')");

  header("Location: index.php");
?>

<?php
require_once "../autoloader.php"; 
if (isset($_POST["log"])) {
  $username = $_POST["uname"];
  $password = $_POST["pass"];
  $login = new Login();
  $login->authenticate($username, $password);
} else {
  echo "Invalid request.";
}

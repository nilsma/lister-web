<?php
require 'functions.php';
sec_session_start();
require 'db_connect.php';
require 'tools.php';
 
if(isset($_POST['email'], $_POST['p'])) { 
   $email = $_POST['email'];
   $password = $_POST['p']; // The hashed password.
   if(login($email, $password, $mysqli) == true) {
      // Login success
      $_SESSION['logged_in'] = True;
      header('Location: ../member-lists.php');
   } else {
      // Login failed
      header('Location: ../index.php?error=1');
   }
} else { 
   // The correct POST variables were not sent to this page.
   echo 'Invalid Request';
}
?>

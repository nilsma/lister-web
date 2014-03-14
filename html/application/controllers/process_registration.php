<?php
session_start();
require_once $_SESSION['config'];
require ROOT . BASE . LIBS . 'db-connect.php';
require ROOT . BASE . LIBS . 'functions.php';

$user = htmlspecialchars($_POST['username']);
$email = htmlspecialchars($_POST['email']);
$pwd1 = htmlspecialchars($_POST['password1']);
$pwd2 = htmlspecialchars($_POST['password2']);

if(!empty($user) && !empty($email) && !empty($pwd1) && !empty($pwd2)) {
  if(!checkUserExistence($mysqli, $user, $email)) {
    if($pwd1 == $pwd2) {
      addNewUser($mysqli, $user, $email, $pwd1);
      unset($_SESSION['fail']);
      $_SESSION['failed_reg'] = False;
      $_SESSION['username'] = $user;
      header('Location: ' . BASE . VIEWS .  'index.php');
    } else {
      $_SESSION['failed_reg'] = True;
      $_SESSION['fail'] = 'password mismatch';
      header('Location: ' . BASE . VIEWS . 'register.php');
    }
  } else {
    $_SESSION['failed_reg'] = True;
    $_SESSION['fail'] = 'user existence fail';
    header('Location: ' . BASE . VIEWS . 'register.php');
  }
} else {
  $_SESSION['failed_reg'] = True;
  $_SESSION['fail'] = 'empty string fail';
  header('Location: ' . BASE . VIEWS . 'register.php');
}

?>
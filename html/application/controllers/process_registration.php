<?php
session_start();
require_once $_SESSION['config'];
require ROOT . BASE . LIBS . 'db_connect.php';
require ROOT . BASE . LIBS . 'functions.php';

$user = htmlspecialchars($_POST['username']);
$pwd1 = htmlspecialchars($_POST['password1']);
$pwd2 = htmlspecialchars($_POST['password2']);

if(!empty($user) && !empty($pwd1) && !empty($pwd2)) {
  if(!checkUserExistence($mysqli, $user)) {
    if($pwd1 == $pwd2) {
      addNewUser($mysqli, $user, $pwd1);
      unset($_SESSION['fail']);
      $_SESSION['failed_reg'] = False;
      $_SESSION['username'] = $user;
      header('Location: ' . BASE . VIEWS .  'member.php');
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
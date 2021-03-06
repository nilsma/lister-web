<?php
session_start();
require_once $_SESSION['config'];
require ROOT . BASE . LIBS . 'db-connect.php';
require ROOT . BASE . LIBS . 'functions.php';
require ROOT . BASE . LIBS . 'member-functions.php';

$user = html(trim($_POST['username']));
$email = html(trim($_POST['email']));
$pwd1 = html($_POST['password1']);
$pwd2 = html($_POST['password2']);

if(!empty($user) && !empty($email) && !empty($pwd1) && !empty($pwd2)) {
  if(!checkUserExistence($mysqli, $user, $email)) {
    if($pwd1 == $pwd2) {
      addNewUser($mysqli, $user, $email, $pwd1);
      unset($_SESSION['fail']);
      $_SESSION['failed_reg'] = False;
      $_SESSION['username'] = $user;
      $_SESSION['user_id'] = getUserId($mysqli, $_SESSION['username']);
      addInitialList($mysqli, $_SESSION['user_id']);
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
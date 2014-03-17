<?php
session_start();
require_once $_SESSION['config'];
include ROOT . BASE . LIBS . 'db-connect.php';
include ROOT . BASE . LIBS . 'functions.php';

if(!empty($_POST['username']) && !empty($_POST['password'])) {
  $username = html(trim($_POST['username']));
  $password = html($_POST['password']);
  
  if(checkLogin($mysqli, $username, $password)) {
    $_SESSION['username'] = $username;
    $_SESSION['authenticated'] = True;
    $_SESSION['failed_auth'] = False;
    header('Location: ' . BASE . VIEWS . 'member.php');
  } else {
    $_SESSION['authenticated'] = False;
    $_SESSION['failed_auth'] = True;
    header('Location: ../../index.php');
  }
}
?>
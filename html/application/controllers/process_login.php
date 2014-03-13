<?php
session_start();
require_once $_SESSION['config'];
include ROOT . BASE . LIBS . 'db_connect.php';
include ROOT . BASE . LIBS . 'functions.php';

if(!empty($_POST['username']) && !empty($_POST['password'])) {
  $username = htmlspecialchars($_POST['username']);
  $password = htmlspecialchars($_POST['password']);
  
  if(checkLogin($mysqli, $username, $password)) {
    $_SESSION['username'] = $username;
    $_SESSION['failed_auth'] = False;
    header('Location: ' . BASE . VIEWS . 'member.php');
  } else {
    $_SESSION['failed_auth'] = True;
    header('Location: ../../index.php');
  }
}
?>
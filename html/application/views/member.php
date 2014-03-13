<?php
session_start();
require_once $_SESSION['config'];
include ROOT . BASE . LIBS . 'functions.php';
include ROOT . BASE . LIBS . 'db_connect.php';

$username = $_SESSION['username'];
$_SESSION['user_id'] = getUserId($mysqli, $username);
$user_id = $_SESSION['user_id'];

?>
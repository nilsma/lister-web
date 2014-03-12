<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/functions.php';
sec_session_start();

//require_once 'functions.php';
sec_session_start();

$current_user = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

$return_data = array();

$return_data['current_user'] = $current_user;
$return_data['user_id'] = $user_id;

header('Content-type: application/json');
echo json_encode($return_data);

?>

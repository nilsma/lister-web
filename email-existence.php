<?php
require_once 'functions.php';
sec_session_start();
require_once 'tools.php';

$email = $_POST['mail'];

$existence = emailExistence($email);

$return_data['existence'] = $existence;

header('Content-type: application/json');
echo json_encode($return_data);

?>

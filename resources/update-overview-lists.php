<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/functions.php';
sec_session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/tools.php';

$user_id = $_SESSION['user_id'];
$return_data = array();

$lists = buildOverviewLists($user_id);

$return_data['overviewlists'] = $lists;

header('Content-type: application/json');
echo json_encode($return_data);

?>


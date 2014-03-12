<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/functions.php';
sec_session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/tools.php';

$user_id = $_SESSION['user_id'];

return getInvitationLists($user_id);

?>
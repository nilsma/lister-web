<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/functions.php';
sec_session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/tools.php';

$user_id = $_SESSION['user_id'];

$num_invites = getNumberOfInvites($user_id);

echo <<<EOF
<p>Invitations [$num_invites]</p>
EOF;

?>
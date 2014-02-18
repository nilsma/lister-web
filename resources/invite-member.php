<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/functions.php';
sec_session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/tools.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/db_connect.php';

$user = $_POST['inv'];
$invite_user = htmlspecialchars($user, ENT_COMPAT | ENT_HTML5, 'UTF-8');
$list_id = $_POST['i'];
$inviter_id = $_SESSION['user_id'];

if($mysqli->connect_error) {
    die("$mysqli->connect_errno: $mysqli->connect_error");
}

  $invitee_id = getUserId($invite_user);

  $query = mysqli_real_escape_string($mysqli, "INSERT INTO invites VALUES(?,?,?)");

  $stmt = $mysqli->stmt_init();
  if(!$stmt->prepare($query)) {
     print("Failed to prepare statement (invite-member)");
  } else {
     $stmt->bind_param('iii', $invitee_id, $list_id, $inviter_id);
     $stmt->execute();
  }

mysqli_stmt_close($stmt);
mysqli_close($mysqli);


?>

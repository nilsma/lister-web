<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/functions.php';
sec_session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/db_connect.php';

$user_id = $_SESSION['user_id'];
$list_id = $_POST['listid'];

require 'db_connect.php';

   if($mysqli->connect_error) {
      die("$mysqli->connect_errno: $mysqli->connect_error");
   }

   $query = "DELETE FROM invites WHERE user_id=? AND list_id=?";

   $stmt = $mysqli->stmt_init();
   if(!$stmt->prepare($query)) {
      print("Failed to prepare statement! (accept invite)");
   } else {
      $stmt->bind_param('ii', $user_id, $list_id);
      $stmt->execute();
   }

mysqli_stmt_close($stmt);
mysqli_close($mysqli);

?>

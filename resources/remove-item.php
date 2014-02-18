<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/functions.php';
sec_session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/db_connect.php';

$itemtoremove = $_POST['product'];
$list_id = $_POST['list'];

if($mysqli->connect_error) {
   die("$mysqli->connect_errno: $mysqli->connect_error");
}

$query = "DELETE FROM products WHERE list_id=? AND name=?";

$stmt = $mysqli->stmt_init();
if(!$stmt->prepare($query)) {
   print("Failed to prepare statement!");
} else {
   $stmt->bind_param('is', $list_id, $itemtoremove);
   $stmt->execute();
}

mysqli_stmt_close($stmt);
mysqli_close($mysqli);

?>

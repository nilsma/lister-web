<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/functions.php';
sec_session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/db_connect.php';

$i = $_POST['item'];
$itemtoadd = htmlspecialchars($i, ENT_COMPAT | ENT_HTML5, 'UTF-8');
$list_id = $_POST['list'];

if($mysqli->connect_error) {
   die("$mysqli->connect_errno: $mysqli->connect_error");
}

$query = mysqli_real_escape_string($mysqli, "INSERT INTO products VALUES(?,?)");

$stmt = $mysqli->stmt_init();
if(!$stmt->prepare($query)) {
   print("Failed to prepare statement!");
} else {
   $stmt->bind_param('is', $list_id, $itemtoadd);
   $stmt->execute();
}

mysqli_stmt_close($stmt);
mysqli_close($mysqli);

?>

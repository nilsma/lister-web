<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/functions.php';
sec_session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/db_connect.php';

$title = $_POST['list'];
$listtoadd = htmlspecialchars($title, ENT_COMPAT | ENT_HTML5, 'UTF-8');
$user_id = $_SESSION['user_id'];

if($mysqli->connect_error) {
   die("$mysqli->connect_errno: $mysqli->connect_error");
}

//add list to database table 'lists'
$query = mysqli_real_escape_string($mysqli, "INSERT INTO lists VALUES(null, ?)");

$stmt = $mysqli->stmt_init();
if(!$stmt->prepare($query)) {
   print("Failed to prepare statement!");
} else {
   $stmt->bind_param('s', $listtoadd);
   $stmt->execute();
}

//add current users ownership of above list to database table 'owners'
$query = mysqli_real_escape_string($mysqli, "INSERT INTO owners VALUES(LAST_INSERT_ID(), ?)");

$stmt = $mysqli->stmt_init();
if(!$stmt->prepare($query)) {
   print("Failed to prepare statement!");
} else {
   $stmt->bind_param('i', $user_id);
   $stmt->execute();
}

mysqli_stmt_close($stmt);
mysqli_close($mysqli);

?>

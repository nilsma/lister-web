<?php
include $_SERVER['DOCUMENT_ROOT'] . '/lib/sel_connect.php';
$email = $_POST['mail'];

if($mysqli->connect_error) {
  die("$mysqli->connect_errno: $mysqli->connect_error");
}

$query = mysqli_real_escape_string($mysqli, "SELECT 1 FROM users WHERE email=?");

$stmt = $mysqli->stmt_init();

if(!$stmt->prepare($query)) {
  print("Failed to prepare statement!");
} else {

  $stmt->bind_param('s', $email);
  $stmt->execute();
  $stmt->store_result();

  if($stmt->fetch()) {
      $existence = True;
   } else {
      $existence = False;
   }
}

mysqli_stmt_close($stmt);
mysqli_close($mysqli);

$return_data = array();

$return_data['existence'] = $existence;

header('Content-type: application/json');
echo json_encode($return_data);

?>

<?php
/**
 * An application resource file that adds an entry to the 
 * list table in the application database
 * @author Nils Martinussen
 */

session_start();

require_once $_SESSION['config'];
require_once ROOT . BASE . LIBS . 'db-connect.php';
require_once ROOT . BASE . LIBS . 'functions.php';
require_once ROOT . BASE . LIBS . 'member-functions.php';

$item = html(trim($_POST['item']));
$user_id = $_SESSION['user_id'];
$list_id = $_SESSION['cur_id'];


if(checkOwnership($mysqli, $user_id, $list_id)) {
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }

  $query = "INSERT INTO products VALUES(NULL, ?, ?)";

  $stmt = $mysqli->stmt_init();

  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement in remove-item.php() ...");
  } else {
    $stmt->bind_param('is', $list_id, $item);
    $stmt->execute();
  }
  $stmt->close();
  $mysqli->close();

}

?>
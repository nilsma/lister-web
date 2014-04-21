<?php
/**
 * An application resource file that removes an entry
 * from the products table in the application database
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

//TODO add owner/membership check
if (mysqli_connect_errno()) {
  printf("Connect failed: %s\n", mysqli_connect_error());
  exit();
}

$query = "DELETE FROM products WHERE name=? AND list_id=? LIMIT 1";

$stmt = $mysqli->stmt_init();

if(!$stmt->prepare($query)) {
  print("Failed to prepare statement in remove-item.php() ...");
} else {
  $stmt->bind_param('si',$item, $list_id);
  $stmt->execute();
}
$stmt->close();
$mysqli->close();

?>
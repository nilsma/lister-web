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

if (mysqli_connect_errno()) {
  printf("Connect failed: %s\n", mysqli_connect_error());
  exit();
}

$query = "DELETE FROM products WHERE name=? AND list_id=? AND (SELECT u.id FROM users as u, owners as o, lists as l WHERE u.id=? AND u.id=o.user_id AND o.list_id=l.id AND l.id=?) LIMIT 1";

$stmt = $mysqli->stmt_init();

if(!$stmt->prepare($query)) {
  print("Failed to prepare statement in remove-item.php() ...");
} else {
  $stmt->bind_param('siii',$item, $list_id, $user_id, $list_id);
  $stmt->execute();
}
$stmt->close();
$mysqli->close();

?>
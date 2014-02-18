<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/functions.php';
sec_session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/db_connect.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/tools.php';

$current_user = $_SESSION['username'];
$list_id = $_POST['listid'];

if(checkListOwnership($current_user, $list_id)) {
   $query = "SELECT p.name FROM products as p, owners as o, users as u WHERE p.list_id=o.list_id AND o.list_id=? AND o.member_id=u.id AND u.username=?";
   } else {
   $query = "SELECT p.name FROM products as p, members as m, users as u WHERE p.list_id=m.list_id AND m.list_id=? AND m.user_id=u.id AND u.username=?";
   }

$stmt = $mysqli->stmt_init();

if(!$stmt->prepare($query)) {
    print("Failed to prepare statement");
} else {
    $stmt->bind_param('is', $list_id, $current_user);
    $stmt->execute();
    $stmt->bind_result($product_name);
    $stmt->store_result();
    $product_count = $stmt->num_rows;

if($product_count >= 1) {
echo '<table class="shopping_table">';
while($stmt->fetch()) {
buildRow($list_id, $product_name);
}
echo '</table>';
} else {
echo '<p>There are no items yet!</p>';
}
}
 

?>      

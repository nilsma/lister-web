<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/tools.php';
include $_SERVER['DOCUMENT_ROOT'] . '/lib/db_connect.php';

$current_user = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

//find and display the first of the lists that the current user owns
$query = "SELECT l.name,l.id FROM lists as l, owners as o, users as m WHERE l.id=o.list_id AND o.member_id=m.id AND m.username=? LIMIT 1";

$stmt = $mysqli->stmt_init();
if(!$stmt->prepare($query)) {
   print("Failed to prepare statement!");
} else {
   $stmt->bind_param('s', $current_user);
   $stmt->execute();
   $stmt->bind_result($list_name, $list_id);
   $stmt->store_result();
   $row_count = $stmt->num_rows;

   $_SESSION['listid'] = $list_id;

   if($row_count >= 1) {

   $row = $stmt->fetch();
echo <<<EOF
	  <section id="member_lists">
EOF;
buildList($list_id, $list_name, $current_user);
   } else {
      $query = "SELECT l.name,l.id FROM lists as l, members as m, users as u WHERE l.id=m.list_id AND m.user_id=u.id AND u.username=? LIMIT 1";

      if(!$stmt->prepare($query)) {
	 print("Failed to prepare statement!");
      } else {
         $stmt->bind_param('s', $current_user);
	 $stmt->execute();
         $stmt->bind_result($list_name, $list_id);
         $stmt->store_result();
         $row_count = $stmt->num_rows;


         if($row_count >= 1) {
            $row = $stmt->fetch();
echo <<<EOF
	  <section id="member_lists">
EOF;
buildList($list_id, $list_name, $current_user);

      } else { //if the current user does not own any lists and is not a member of any lists
echo <<<EOF
	  <section id="member_lists">
	    <h3>You havent made any lists yet.</h3>
	    <p>Make a New List in the Menu</p>

EOF;

      }
   }
}
echo <<<EOF
	  </section> <!--- end member_lists -->
EOF;
mysqli_stmt_close($stmt);
mysqli_close($mysqli);
}

?>

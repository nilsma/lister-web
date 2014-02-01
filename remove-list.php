<?php
require_once 'functions.php';
require_once 'tools.php';
sec_session_start();

$current_user = $_SESSION['username'];
$listid = $_POST['listid'];

if(checkListOwnership($current_user, $listid)) {
  if(deleteListFromOwners($listid)) {
      deleteListFromLists($listid);
  } 
} else {
  deleteListFromMembers($current_user, $listid);
}


?>

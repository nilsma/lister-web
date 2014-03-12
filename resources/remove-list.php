<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/functions.php';
sec_session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/tools.php';

$current_user = $_SESSION['username'];
$listid = $_SESSION['current_list'];

if(checkListOwnership($current_user, $listid)) {
  if(deleteListFromOwners($listid)) {
      deleteListFromLists($listid);
  } 
} else {
  deleteListFromMembers($current_user, $listid);
}


?>

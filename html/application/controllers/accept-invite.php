<?php
/**
 * An application resource file that adds an entry
 * to the members table in the application database
 * upon accepting an invite
 * @author Nils Martinussen
 */
session_start();
require_once $_SESSION['config'];
require_once ROOT . BASE . LIBS . 'db-connect.php';
require_once ROOT . BASE . LIBS . 'functions.php';
require_once ROOT . BASE . LIBS . 'member-functions.php';

$user_id = $_SESSION['user_id'];
$sender = $_POST['sender'];
$title = $_POST['title'];

$sender_id = getUserId($mysqli, $sender);
$inv_list_id = getListId($mysqli, $title, $sender_id);

if(!membershipExists($mysqli, $user_id, $inv_list_id)) {
    try {
      $mysqli->autocommit(FALSE);

      $query = "INSERT INTO members VALUES(NULL, '$user_id', '$inv_list_id')";

      $result = $mysqli->query($query);
      if(!$result) {
        $result->free();
        throw new Exception($mysqli->error);
      }

      $last_id = $mysqli->insert_id;

      $query = "DELETE FROM invites WHERE sender_id='$sender_id' AND receiver_id='$user_id' AND list_id='$inv_list_id'";
      $result = $mysqli->query($query);
      if(!$result) {
        $result->free();
        throw new Exception($mysqli->error);
      }
      $mysqli->commit();
      $mysqli->autocommit(TRUE);
    }

    catch(Exception $e) {
      $mysqli->rollback();
      $mysqli->autocommit(TRUE);
    }
    header('Location: ' . BASE . VIEWS . 'member.php');
  } else {
    removeInvite($mysqli, $sender_id, $user_id, $inv_list_id);
}


?>
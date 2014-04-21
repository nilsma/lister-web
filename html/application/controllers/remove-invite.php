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

if (mysqli_connect_errno()) {
  printf("Connect failed: %s\n", mysqli_connect_error());
  exit();
}

$query = "DELETE FROM invites WHERE sender_id=? AND receiver_id=? AND list_id=?";

$stmt = $mysqli->stmt_init();

if(!$stmt->prepare($query)) {
  print("Failed to prepare statement in removeInvite() ...");
} else {
  $stmt->bind_param('iii', $sender_id, $user_id, $inv_list_id);
  $stmt->execute();
}

$stmt->close();
$mysqli->close();

header('Location: ' . BASE . VIEWS . 'member.php');

?>
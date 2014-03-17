<?php 
/**
 * An application resource file that adds an entry 
 * to the invites table in the application database
 * @author Nils Martinussen
 */

session_start();

require_once $_SESSION['config'];
require_once ROOT . BASE . LIBS . 'db-connect.php';
require_once ROOT . BASE . LIBS . 'functions.php';
require_once ROOT . BASE . LIBS . 'member-functions.php';

$title = html(trim($_POST['title']));
$receiver = html(trim($_POST['receiver']));
$sender_id = $_SESSION['user_id'];
$user_lists = $_SESSION['user_lists'];
$list_id = $user_lists[$title];
 
if(usernameExists($mysqli, $receiver)) {
  $receiver_id = getUserId($mysqli, $receiver);
  if(($receiver_id != $sender_id) && (!inviteExists($mysqli, $sender_id, $receiver_id, $list_id))) {

    if (mysqli_connect_errno()) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();
    }

    $query = "INSERT INTO invites VALUES(NULL, ?, ?, ?)";
 
    $stmt = $mysqli->stmt_init();

    if(!$stmt->prepare($query)) {
      print("Failed to prepare statement! (titleExists)");
    } else {
      $stmt->bind_param('iii', $sender_id, $receiver_id, $list_id);
      $stmt->execute();
    }
    $stmt->close();
    $mysqli->close();

    header('Location: ' . BASE . VIEWS . 'member.php');

  } else {
    header('Location: ' . BASE . VIEWS . 'member.php');
  }

}
?>
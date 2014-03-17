<?php
/**
 * An application resource file that deletes an entry
 * from the lists table in the application database
 * @author Nils Martinussen
 */

session_start();

require_once $_SESSION['config'];
require_once ROOT . BASE . LIBS . 'db-connect.php';
require_once ROOT . BASE . LIBS . 'functions.php';
require_once ROOT . BASE . LIBS . 'member-functions.php';

$user_id = $_SESSION['user_id'];
$del_list_id = getListId($mysqli, html(trim($_POST['title'])), $user_id);

if(checkOwnership($mysqli, $user_id, $del_list_id)) {

  try {
    $mysqli->autocommit(FALSE);

    $query = "DELETE FROM owners WHERE user_id='$user_id' AND list_id='$del_list_id'";

    $result = $mysqli->query($query);
    if(!$result) {
      $result->free();
      throw new Exception($mysqli->error);
    }

    $query = "DELETE FROM products WHERE list_id='$del_list_id'";
    $result = $mysqli->query($query);
    if(!$result) {
      $result->free();
      throw new Exception($mysqli->error);
    }

    $query = "DELETE FROM lists WHERE id='$del_list_id'";
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

}

?>
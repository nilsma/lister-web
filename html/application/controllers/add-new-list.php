<?php
/**
 * An application resource file that adds an entry to the 
 * list table in the application database
 * @author Nils Martinussen
 */

session_start();

require_once $_SESSION['config'];
include ROOT . BASE . LIBS . 'db-connect.php';
include ROOT . BASE . LIBS . 'functions.php';
include ROOT . BASE . LIBS . 'member-functions.php';

$title = html(trim($_POST['title']));
$user_id = $_SESSION['user_id'];

if(!titleExists($mysqli, $user_id, $title)) {

  try {
    $mysqli->autocommit(FALSE);

    $query = "INSERT INTO lists VALUES(NULL, '$title')";

    $result = $mysqli->query($query);
    if(!$result) {
      $result->free();
      throw new Exception($mysqli->error);
    }

    $last_id = $mysqli->insert_id;

    $query = "INSERT INTO owners VALUES(NULL, '$user_id', '$last_id')";
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

}

?>
<?php
session_start();

//store last displayed list's title to echo later
$last_title = $_SESSION['cur_title'];

//set new currently displayed list
$user_lists = $_SESSION['user_lists'];
$new_list = $_POST['new_list'];
$new_id = $user_lists[$new_list];
$_SESSION['cur_title'] = $new_list;
$_SESSION['cur_id'] = $new_id;

//return last displayed list's title
echo $last_title;

?>
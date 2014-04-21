<?php
session_start();

if(!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] != True) {
  header('Location: index.php');
}

require_once $_SESSION['config'];
include ROOT . BASE . LIBS . 'member-functions.php';
include ROOT . BASE . LIBS . 'db-connect.php';

$css_path = BASE . CSS;
$js_path = BASE . JS;
$ctrls_path = BASE . CONTROLLERS;
$mods_path = BASE . MODELS;
$libs_path = BASE . LIBS;
$views_path = ROOT . BASE . VIEWS;
$pics_path = BASE . PICS;

$username = $_SESSION['username'];
$_SESSION['user_id'] = getUserId($mysqli, $username);
$user_id = $_SESSION['user_id'];

$_SESSION['owner_lists'] = getOwnerLists($mysqli, $_SESSION['user_id']);
$_SESSION['member_lists'] = getMemberLists($mysqli, $_SESSION['user_id']);

$owner_lists = $_SESSION['owner_lists'];
$member_lists = $_SESSION['member_lists'];

//handle owner_lists
if(count($owner_lists) >= 1) {
  ksort($owner_lists);
}

$_SESSION['owner_lists'] = $owner_lists;
if(count($owner_lists) >= 1) {
  $cur_title = key($owner_lists);
  $cur_id = $owner_lists[$cur_title];
  $_SESSION['cur_title'] = $cur_title;
  $_SESSION['cur_id'] = $cur_id;
}

//handle member_lists
if(count($member_lists) >= 1) {
  ksort($member_lists);
}

$_SESSION['member_lists'] = $member_lists;
//if(count($member_lists) >= 1) {
//  $cur_title = key($member_lists);
//  $cur_id = $member_lists[$cur_title];
//  $_SESSION['cur_title'] = $cur_title;
//  $_SESSION['cur_id'] = $cur_id;
//}

//handle user_lists 

$user_lists = mergeLists($owner_lists, $member_lists);
if(count($user_lists) >= 1) {
  ksort($user_lists);
}

$_SESSION['user_lists'] = $user_lists;
//if(count($user_lists) >= 1) {
//  $cur_title = key($user_lists);
//  $cur_id = $user_lists[$cur_title];
//  $_SESSION['cur_title'] = $cur_title;
//  $_SESSION['cur_id'] = $cur_id;
//}

$myInvites = getInvites($mysqli, $user_id);
$num_inv = count($myInvites);

?>
<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="keywords" content="information, science, web, design, development, student, bachelor, nils, martinussen"/>
    <meta name="author" content="Nils Martinussen"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0;"/>
    <link href="http://fonts.googleapis.com/css?family=Pompiere" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Advent+Pro:300" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php echo $css_path . 'general.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo $css_path . 'member.css' ?>">
    <link rel="stylesheet" type="text/css" media="screen and (min-width: 320px) and (max-width: 359px) and (orientation: portrait)" href="<?php echo $css_path . 'iphone-portrait.css'?> ">
    <link rel="stylesheet" type="text/css" media="screen and (min-width: 360px) and (max-width: 479px) and (orientation: portrait)" href="<?php echo $css_path . 'sg-portrait.css'?> ">
    <link rel="stylesheet" type="text/css" media="screen and (min-width: 568px) and (max-width: 599px) and (orientation: landscape)" href="<?php echo $css_path . 'sg-landscape.css'?> ">
    <script type="text/javascript" src="<?php echo $js_path . 'general.js' ?>"></script>
    <script type="text/javascript" src="<?php echo $js_path . 'jquery-2.0.2.js' ?>"></script>
    <script type="text/javascript" src="<?php echo $js_path . 'listeners.js' ?>"></script>
  </head>
  <body id="member">
    
    <?php include $views_path . 'parts/header.php'; ?>

    <div id="outer_container">

      <?php include $views_path . 'parts/menu-panel.php'; ?>

      <div id="left_column">

	<?php require $views_path . 'parts/menu.php'; ?>

      </div> <!-- end left_column -->
      <div id="inner_container" class="general_panel">
        <section id="member_status">
          <h2 id="welcome">Logged in as <span id="user"><?php echo $username ?></span></h2>
        </section> <!-- end member_status -->

	<section id="member_lists">

	  <?php if(count($user_lists) >= 1) { require ROOT . $ctrls_path . 'get-list.php'; }?>
	
	</section> <!-- end member_lists -->
      </div> <!-- end inner_container -->
      <div id="right_column">

	<!-- build lists overview -->
	<?php require ROOT . $ctrls_path . 'get-lists-overview.php'; ?>

      </div> <!-- end right_column -->
    </div> <!-- end outer_container -->
  </body>
</html>

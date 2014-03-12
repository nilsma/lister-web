<?php
require_once 'lib/functions.php';
sec_session_start();
if(!isset($_SESSION['logged_in'])) {
   header('Location: index.php');
}

require_once 'lib/db_connect.php';

$current_user = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

echo <<<EOF
<!doctype html>
<html lang="en">
  <head>
    <title>ListShopper</title>
    <meta charset="UTF-8">
    <meta name="description" content="An Experimental List Application">
    <meta name="author" content="Nils Martinussen">
    <meta name="keywords" content="information, science, web, design, development, student, bachelor, nils, martinussen"/>
    <meta name="author" content="Nils Martinussen"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0;"/>
    <link href="http://fonts.googleapis.com/css?family=Pompiere" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Advent+Pro:300" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="style/general.css">
    <link rel="stylesheet" href="style/member.css">
    <link rel="stylesheet" type="text/css" media="screen and (min-width: 320px) and (max-width: 339px) and (orientation: portrait)" href="style/iphone-portrait.css">
    <link rel="stylesheet" type="text/css" media="screen and (min-width: 340px) and (max-width: 567px) and (orientation: portrait)" href="style/sg-portrait.css">
    <link rel="stylesheet" type="text/css" media="screen and (min-width: 568px) and (max-width: 640px) and (orientation: landscape)" href="style/sg-landscape.css">
    <script type="text/javascript" src="js/jquery-2.0.2.js"></script>
    <script type="text/javascript" src="js/general.js"></script>
    <script type="text/javascript" src="js/listeners.js"></script>
  </head>
  <body id="member">
      <section id="header">
	<h1>Lister</h1>
      </section> <!-- end header -->
	  <div id="outer_container">
	    <div class="general_panel" id="menu_panel">
	      <ul>
		<li><h3 id="menu_button" class="menu_entry"><a href="#" onclick="openMenu()">Menu</a></h3></li>
		<li><h3 id="lists_button" class="menu_entry"><a href="#" onclick="openLists()">Lists</a></h3></li>
	      </ul>
	    </div> <!-- end menu_panel -->
	    <div id="left_column">
EOF;

require_once 'parts/menu.php';

echo <<<EOF
	  
	  </div> <!-- end left_column -->
	    <div id="inner_container" class="general_panel">
	      <section id="member_status">
		<h2 id="welcome">Logged in as <span id="user">$current_user</span></h2>
	      </section> <!-- end member_status -->
EOF;

require_once 'resources/get-list.php';

echo <<<EOF

	  </div> <!-- end inner_container -->
	    <div id="right_column">
<!--	      <h3 id="lists_button" class="list_name"><a href="#" onclick="openLists()">Lists Button</a></h3> -->
EOF;
buildOverviewLists($user_id, $mysqli);
echo <<<EOF
	  </div> <!-- end right_column -->
	  </div> <!-- end outer_container -->
EOF;
?>

  </body>
</html>

<?php
session_start();
require_once $_SESSION['config'];
$css_path = BASE . CSS;
$js_path = BASE . JS;
$ctrls_path = BASE . CONTROLLERS;
$libs_path = BASE . LIBS;
$views_path = BASE . VIEWS;
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
    <link rel="stylesheet" type="text/css" href="<?php echo $css_path . 'index.css' ?>">
    <link rel="stylesheet" type="text/css" media="screen and (min-width: 320px) and (max-width: 359px) and (orientation: portrait)" href="<?php echo $css_path . 'iphone-portrait.css'?> ">
    <link rel="stylesheet" type="text/css" media="screen and (min-width: 360px) and (max-width: 479px) and (orientation: portrait)" href="<?php echo $css_path . 'sg-portrait.css'?> ">
    <link rel="stylesheet" type="text/css" media="screen and (min-width: 568px) and (max-width: 599px) and (orientation: landscape)" href="<?php echo $css_path . 'sg-landscape.css'?> ">
    <script type="text/javascript" src="<?php echo $js_path . 'general.js' ?>"></script>
  </head>
  <body id="index">
    <section id="container">
      <section id="header">
	<h1>Lister</h1>
      </section> <!-- end #header -->
      <section id="inner_container">
	<form action="<?php echo $ctrls_path . 'process-login.php' ?>"  method="post" name="login_form"><br/>
	  <fieldset>
	    <legend>Login form</legend>
	    <label id="login_username">Username: </label><br/><input class="itemtoadd" type="text" name="username" /><br/><br/>
	    <label id="login_password">Password: </label><br/><input class="itemtoadd" type="password" name="password"/><br/><br/>
            <input name="submit" type="submit" class="add_button" value="Login"/>
	  </fieldset>
	</form>
	<p>Or <a href="<?php echo $views_path . 'register.php' ?>">Sign up!</a></p>
      </section> <!-- end #inner_container -->
    </section> <!-- end #container -->
  </body>
</html>

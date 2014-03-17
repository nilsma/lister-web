<?php
session_start();
require_once $_SESSION['config'];
$css_path = BASE . CSS;
$js_path = BASE . JS;
$libs_path = BASE . LIBS;
$ctrl_path = BASE . CONTROLLERS;
$views_path = BASE . VIEWS;
?>
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
  <body>
    <?php
       if(isset($_SESSION['failed_reg']) && $_SESSION['failed_reg'] == True) {
	 echo 'Registration failed: ';
	 if(isset($_SESSION['fail'])) {
	   echo $_SESSION['fail'];
	 }
       }
       ?>
    <form action="<?php echo $ctrl_path . 'process-registration.php'; ?>" method="POST">
      <fieldset>
	<legend>Register form</legend><br/>
      <label>Username:</label><br/><input class="itemtoadd" name="username" type="text" <?php if(isset($_SESSION['username']) && !empty($_SESSION['username'])) { echo 'value="' . $_SESSION['username']  . '"';} else {echo 'placeholder="Enter username ..."';}; ?> autofocus></input><br/><br/>
      <label>Email:</label><br/><input class="itemtoadd" name="email" type="text" placeholder="Enter email ..."></input><br/><br/>
      <label>Password:<br/></label><input class="itemtoadd" name="password1" type="password" placeholder="Enter password ..."></input><br/><br/>
      <label>Re-type password:<br/></label><input class="itemtoadd" name="password2" type="password" placeholder="Re-enter password ..."></input><br/><br/>
      <p><input class="add_button" name="submit" type="submit" value="Register"></p>
      </fieldset>
    </form>
    <p>Or Go <a href="<?php echo $views_path . 'index.php'; ?>">Back to Login</a></p>
  </body>
</html>

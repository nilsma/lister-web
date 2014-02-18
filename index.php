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
    <link rel="stylesheet" type="text/css" href="style/general.css">
    <link rel="stylesheet" type="text/css" href="style/index.css">
    <link rel="stylesheet" type="text/css" media="screen and (min-width: 320px) and (max-width: 359px) and (orientation: portrait)" href="style/iphone-portrait.css">
    <link rel="stylesheet" type="text/css" media="screen and (min-width: 360px) and (max-width: 479px) and (orientation: portrait)" href="style/sg-portrait.css">
    <link rel="stylesheet" type="text/css" media="screen and (min-width: 480px) and (max-width: 567px) and (orientation: landscape)" href="style/iphone-landscape.css">
    <link rel="stylesheet" type="text/css" media="screen and (min-width: 568px) and (max-width: 599px) and (orientation: landscape)" href="style/sg-landscape.css">
    <script type="text/javascript" src="js/sha512.js"></script>
    <script type="text/javascript" src="js/forms.js"></script>
    <script type="text/javascript" src="js/general.js"></script>
  </head>
  <body id="index">
    <section id="container">
      <section id="header">
	<h1>Lister</h1>
      </section> <!-- end #header -->
      <section id="inner_container">
	<?php
	   if(isset($_GET['error'])) { 
	   echo 'Error Logging In!';
	   }
	   ?>
	<form action="lib/process_login.php" method="post" name="login_form">
	  <p id="login_email">Email: </p><input class="itemtoadd" type="text" name="email" /><br/><br/>
	  <p id="login_password">Password: </p><input class="itemtoadd" type="password" name="password" id="password"/><br/><br/><br/>
          <input id="login" class="add_button" type="button" value="Login" onclick="formhash(this.form, this.form.password);"/>
	  <input id="register" class="add_button" type="button" onclick="location.href='registration.php'" value="Sign Up"/>
	</form>
      </section> <!-- end #inner_container -->
    </section> <!-- end #container -->
  </body>
</html>

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
    <link rel="stylesheet" type="text/css" href="style/registration.css">
    <link rel="stylesheet" type="text/css" media="screen and (min-width: 320px) and (max-width: 568px) and (orientation: portrait)" href="style/sg-portrait.css">
    <script type="text/javascript" src="js/jquery-2.0.2.js"></script>
    <script type="text/javascript" src="js/registration.js"></script>
    <script type="text/javascript" src="js/sha512.js"></script>
    <script type="text/javascript" src="js/forms.js"></script>
  </head>
  <body id="registration">
    <section id="container">
      <section id="header">
	<h1>Lister</h1>
      </section> <!-- end #header -->
      <section id="inner_container">
	<form action="lib/process_registration.php" method="post" name="login_form">
	  <p id="login_email">Email: </p><input class="itemtoadd" type="text" id="email" name="email" onblur="checkRegistrationEmail(email.value)" onfocus="resetInputField(this)"/><br />
	  <p class="input_feedback" id="checked-email">Email already in use!</p>
	  <p id="login_username">Username: </p><input class="itemtoadd" type="text" name="username" id="username" onblur="checkRegistrationUser(username.value)" onfocus="resetInputField(this)"/><br />
	  <p class="input_feedback" id="checked-username">Username already in use!</p>
	  <p id="login_password">Password: </p><input class="itemtoadd" type="password" name="password" id="password"/><br />
	  <br/>
	  <input id="register" class="add_button" type="button" value="Register" onclick="formhash(this.form, this.form.password);"/>
	</form>
	<button id="back" class="add_button" type="button" onclick="location.href='index.php'">Back</button>
      </section> <!-- end #inner_container -->
    </section> <!-- end #container -->
  </body>
</html>

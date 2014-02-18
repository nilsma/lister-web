<?php
require $_SERVER['DOCUMENT_ROOT'] . '/lib/functions.php';
sec_session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/lib/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/lib/tools.php';

if(isset($_POST['email'],$_POST['username'],$_POST['p'])) {

if( ($_POST['email'] !== '') && ($_POST['username'] !== '') ) {

  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = $_POST['p'];
  $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
  $password = hash('sha512',$password.$random_salt);

  $query = mysqli_real_escape_string($mysqli, "INSERT INTO users (username, email, password, salt) VALUES (?, ?, ?, ?)");

  if($stmt = $mysqli->prepare($query)) {
    $stmt->bind_param('ssss', $username, $email, $password, $random_salt);
    $stmt->execute();
    $registered = True;
  } else {
    $registered = False;
  }  

  if($registered) {
echo <<<EOF
<p>You have been successfully registered.</p>
<p>return to <a href="../index.php">the front page</a> to login with your new login credentials.</p>
EOF;
  } 

}else {
echo <<<EOF
<p>failed registration process!</p>
<p>return to <a href="registration.php">the registration page</a> to try again.</p>
EOF;
  }



}

?>

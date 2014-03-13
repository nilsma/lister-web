<?php

/**
 * A function that takes a password and hashes it
 * @param string password - the given password to hash
 * @return string hashed - returns the hashed password
 */
function hashPassword($password) {
  $cost = 10;
  $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
  $salt = sprintf("$2a$%02d$", $cost) . $salt;
  $hashed = crypt($password, $salt);
  return $hashed;
}

/**
 * A function to add a new user to the users table in the database
 * @param mysqli mysqli - a mysqli object for database connection
 * @param string username - the username to add to the database
 * @param string password - the usernames corresponding password
 * @return boolean - returns true if the given data was added to the database, false otherwise
 */
function addNewUser($mysqli, $username, $password) {
  
  //hash the password
  $hashed = hashPassword($password);

  //check connection
  if(mysqli_connect_errno()) {
    printf("Connection failed: %s\n", mysqli_connect_error());
    exit();
  }

  //define query
  $query = "INSERT INTO users VALUES(NULL, ?, ?)";

  //initialize query
  $stmt = $mysqli->stmt_init();

  //prepare and execute the query
  if(!$stmt->prepare($query)) {
    printf("Failed to prepare statement!");
  } else {
    $stmt->bind_param('ss',$username, $hashed);
    $stmt->execute();
    
  }
}

/**
 * A function to check whether the given username already exists in the database
 * @param mysqli mysqli - a mysqli object for database connection
 * @param string username - the username to check whether exists or not
 * @return boolean - returns true if the given username exists, false otherwise
 */
function checkUserExistence($mysqli, $username) {
  // check connection
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }

  //define query
  $query = "SELECT username FROM users WHERE username=? LIMIT 1";
 
  //initiatlize query
  $stmt = $mysqli->stmt_init();

  //prepare and execute query
  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement!");
  } else {
    $stmt->bind_param('s',$username);
    $stmt->execute();
    $num_rows = $stmt->num_rows;
    if($num_rows >= 1) {
      return True;
    } else {
      return False;
    }
  }
}

/**
 * A function to check whether the given user credentials is valid
 * according to the database
 * @param mysqli mysqli - a mysqli object for database connection
 * @param string username - the username to check whether exists or not
 * @param string password - the users corresponding password
 * @return boolean - returns true if the username exists and has a corresponding password and
 *                   that password matches the password found in the database, false otherwise
 */
function checkLogin($mysqli, $username, $password) {
  // check connection
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }

  //define query
  $query = "SELECT password FROM users WHERE username=? LIMIT 1";
 
  //initiatlize query
  $stmt = $mysqli->stmt_init();

  //prepare and execute query
  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement");
  } else {
    $stmt->bind_param('s',$username);
    $stmt->execute();
    $stmt->bind_result($db_pwd);
    $stmt->store_result();
    $num_rows = $stmt->num_rows;
    if($num_rows >= 1) {
      while($stmt->fetch()) {
	if(crypt($password, $db_pwd) == $db_pwd) {
	  return True;
	} else {
	  return False;
	}
      }
    } else {
      return False;
    }

  }

}
?>
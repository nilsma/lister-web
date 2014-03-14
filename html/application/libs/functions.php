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
function addNewUser($mysqli, $username, $email, $password) {
  
  //hash the password
  $hashed = hashPassword($password);

  //check connection
  if(mysqli_connect_errno()) {
    printf("Connection failed: %s\n", mysqli_connect_error());
    exit();
  }

  //define query
  $query = "INSERT INTO users VALUES(NULL, ?, ?, ?)";

  //initialize query
  $stmt = $mysqli->stmt_init();

  //prepare and execute the query
  if(!$stmt->prepare($query)) {
    printf("Failed to prepare statement! (addNewUser)");
  } else {
    $stmt->bind_param('sss',$username, $email, $hashed);
    $stmt->execute();
    
  }
}

/**
 * A function to check whether the given username and email already exists in the database
 * @param mysqli mysqli - a mysqli object for database connection
 * @param string username - the username to check whether exists or not
 * @param string email - the email to check whether exists or not
 * @return boolean - returns false if the given username and email does not exists, true otherwise
 */
function checkUserExistence($mysqli, $user, $email) {
  $exists = True;
  if(!usernameExists($mysqli, $user) && (!emailExists($mysqli, $email))) {
    $exists = False;
  }
  return $exists;
}

/**
 * A function to check whether the given username already exists in the database
 * @param mysqli mysqli - a mysqli object for database connection
 * @param string username - the username to check whether exists or not
 * @return boolean - returns true if the given username exists, false otherwise
 */
function usernameExists($mysqli, $username) {
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
    print("Failed to prepare statement! (usernameExists)");
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
  $stmt->close();
  $mysqli->close();
}

/**
 * A function to check whether the given email already exists in the database
 * @param mysqli mysqli - a mysqli object for database connection
 * @param string email - the email to check whether exists or not
 * @return boolean - returns true if the given username exists, false otherwise
 */
function emailExists($mysqli, $email) {
  // check connection
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }

  //define query
  $query = "SELECT username FROM users WHERE email=? LIMIT 1";
 
  //initiatlize query
  $stmt = $mysqli->stmt_init();

  //prepare and execute query
  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement! (emailExists)");
  } else {
    $stmt->bind_param('s',$email);
    $stmt->execute();
    $num_rows = $stmt->num_rows;
    if($num_rows >= 1) {
      return True;
    } else {
      return False;
    }
  }
  $stmt->close();
  $mysqli->close();
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
    print("Failed to prepare statement! (checkLogin)");
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
<?php
/********************************************************************
 * A file holding the functions used by members after being logged in
 * @author Nils Martinussen
 ********************************************************************/

/**
 * A function to display the waiting invites for the given user_id in the applications menu section by
 * echoing an approprite HTML section based on whether the number of invites are 1 or more, or not
 * @param mysqli_object mysqli - the object for database the connection as defined in db-connect.php
 * @param array user_lists - an assoc array holding the invites for the user with sender_id as key and list_id as value
 */
function invDisplay($user_lists) {
  $num = count($user_lists);

  //if there are any invites
  if($num >= 1) {
    foreach($user_lists as $sender => $list) {
      //echo the following HTML section
echo <<<EOF
	     <div class="invitationFeedback">
	       <p>$sender has invited you to the list:</p>
	       <p>$list</p>
	       <button id="accept_btn" class="add_button">Accept</button><button id="decline_btn" class="add_button">Decline</button>
	     </div>

EOF;
    }
  } else {
    //if there are no invites
    //echo the following HTML section
echo <<<EOF
	     <div class="invitationFeedback">
	       <p>There are no waiting invites at the moment.</p>
	     </div>

EOF;
  }
}

/**
 * A function to build the HTML option elements for the invite to list section in the application menu
 * @param array $user_lists - an associative array with the list title as key and the list id in the DB as value
 */
function invOptions($user_lists) {
  foreach($user_lists as $key => $val) {
echo <<<EOF
             <option id="$key">$key</option>

EOF;
  }
}

/**
 * A function to get an assoc array containing the invites for the given user_id
 * @param mysqli_object mysqli - the object for database the connection as defined in db-connect.php
 * @param int user_id - the database user_id for the given user of which to get the number of waiting invites
 * @return array myInvites - assoc array with sender_id's username as key and list_id's title as value
 */
function getInvites($mysqli, $user_id) {

  if($mysqli->connect_error) {
    die("$mysqli->connect_errno: $mysqli->connect_error");
  }

  $query = mysqli_real_escape_string($mysqli, "SELECT u.username, l.title FROM invites as i, users as u, lists as l WHERE i.sender_id=u.id AND i.list_id=l.id AND receiver_id=?");

  $stmt = $mysqli->stmt_init();

  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement in getInvites() ...");
  } else {
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->bind_result($sender, $list);
    $stmt->store_result();
    
    $myInvites = array();

    while($stmt->fetch()) {
      $myInvites[$sender] = $list;
    }

    return $myInvites;
  }
  mysqli_stmt_close($stmt);
  mysqli_close($mysqli);
}

/**
 * A function to get the lists that the given user_id is owner
 * @param mysqli $mysqli - the mysqli connection object to the database
 * @param string user_id - the user_id of the user of which to get the lists
 * @return array $user_lists - an associative array holding the lists of which the given user, assoc id=>title
 */
function getLists($mysqli, $user_id) {

  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }

  $query = mysqli_real_escape_string($mysqli, "SELECT l.id, l.title FROM lists as l, owners as o, users as u WHERE l.id=o.list_id AND o.user_id=u.id AND u.id=?");

  $stmt = $mysqli->stmt_init();

  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement in getLists() ...");
  } else {
    $stmt->bind_param('i',$user_id);
    $stmt->execute();
    $stmt->bind_result($id, $title);

    $user_lists = array();

    while($result = $stmt->fetch()) {
      $user_lists[$title] = $id;
    }
    
    return $user_lists;
  }
  $stmt->close();
  $mysqli->close();
}

/**
 * A function to get the user_id of the corresponding given username
 * @param mysqli $mysqli - the mysqli connection object to the database
 * @param string $username - the username of which to get the corresponding user id
 * @return string $user_id - the user_id corresponding to the given username
 */
function getUserId($mysqli, $username) {
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }

  $query = mysqli_real_escape_string($mysqli, "SELECT id FROM users WHERE username=? LIMIT 1");

  $stmt = $mysqli->stmt_init();

  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement in getUserId() ...");
  } else {
    $stmt->bind_param('s',$username);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();

    return $user_id;
  }
  $stmt->close();
  $mysqli->close();
}

?>

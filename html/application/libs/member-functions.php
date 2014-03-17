<?php
/********************************************************************
 * A file holding the functions used by members after being logged in
 * @author Nils Martinussen
 ********************************************************************/

/**
 * A function to check whether a given user id is the owner of a list
 * @param mysqli_object mysqli - the object for database the connection as defined in db-connect.php
 * @param int user_id - the user id of the user 
 * @param int list_id - the list id of the list
 */
function checkOwnership($mysqli, $user_id, $list_id) {

  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }

  $query = "SELECT COUNT(*) FROM lists as l, owners as o, users as u WHERE u.id=? AND u.id=o.user_id AND o.list_id=l.id AND l.id=?";
 
  $stmt = $mysqli->stmt_init();

  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement in checkOwnership() ...");
  } else {
    $stmt->bind_param('ii',$user_id, $list_id);
    $stmt->execute();
    $stmt->store_result();
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
 * A function to remove an invite from the database
 * @param mysqli_object mysqli - the object for database the connection as defined in db-connect.php
 * @param int user_id - the user id of the user to add as member
 * @param int list_id - the list id to add the user as member to
 */
function removeInvite($mysqli, $sender_id, $receiver_id, $list_id) {

  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }

  $query = "DELETE FROM invites WHERE sender_id=? AND receiver_id=? AND list_id=?";

  $stmt = $mysqli->stmt_init();

  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement in removeInvite() ...");
  } else {
    $stmt->bind_param('iii', $sender_id, $receiver_id, $list_id);
    $stmt->execute();

  }
  $stmt->close();
  $mysqli->close();
}

/**
 * A function to add a given user_id as member to the given list_id
 * @param mysqli_object mysqli - the object for database the connection as defined in db-connect.php
 * @param int user_id - the user id of the user to add as member
 * @param int list_id - the list id to add the user as member to
 */
function addListMember($mysqli, $user_id, $list_id) {

  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }

  $query = "INSERT INTO members VALUES(null, ?, ?)";
 
  $stmt = $mysqli->stmt_init();

  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement in addListMember() ...");
  } else {
    $stmt->bind_param('ii', $user_id, $list_id);
    $stmt->execute();

  }
  $stmt->close();
  $mysqli->close();
}

/**
 * A function to get the list id of the given list title belonging to the given owners user_id
 * @param mysqli_object mysqli - the object for database the connection as defined in db-connect.php
 * @param string title - the title of the list of which to get the id
 * @param int owner - the user_id of the owner of the list
 * @return int list_id - the list id of the corresponding list
 */
function getListId($mysqli, $title, $owner) {
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }

  $query = "SELECT l.id FROM lists as l, owners as o, users as u WHERE title=? AND l.id=o.list_id AND o.user_id=u.id AND u.id=?";
 
  $stmt = $mysqli->stmt_init();

  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement in getListId() ...");
  } else {
    $stmt->bind_param('si',$title, $owner);
    $stmt->execute();
    $stmt->bind_result($id);
    $stmt->fetch();

    return $id;

  }
  $stmt->close();
  $mysqli->close();
}

/**
 * A function to get the corresponding username for the given user_id
 * @param mysqli_object mysqli - the object for database the connection as defined in db-connect.php
 * @param int user_id - the given users user_id
 * @return string - the given user_ids corresponding username
 */
function getUsername($mysqli, $user_id) {
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }

  $query = "SELECT username FROM users WHERE id=?";
 
  $stmt = $mysqli->stmt_init();

  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement in getUsername() ...");
  } else {
    $stmt->bind_param('i',$user_id);
    $stmt->execute();
    $stmt->bind_result($name);
    $stmt->fetch();

    return $name;

  }
  $stmt->close();
  $mysqli->close();
}

/**
 * A function to check whether the given member has already been invited to a given list by that user
 * @param mysqli_object mysqli - the object for database the connection as defined in db-connect.php
 * @param string member - the username to check whether exists or not
 * @return boolean - returns true if the member exists, false otherwise
 */
function membershipExists($mysqli, $user_id, $list_id) {

  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }

  $query = "SELECT * FROM members WHERE user_id=? AND list_id=?";
 
  $stmt = $mysqli->stmt_init();

  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement in membershipExists() ...");
  } else {
    $stmt->bind_param('ii',$user_id, $list_id);
    $stmt->execute();
    $stmt->store_result();
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
 * A function to check whether the given members username exists
 * @param mysqli_object mysqli - the object for database the connection as defined in db-connect.php
 * @param string member - the username to check whether exists or not
 * @return boolean - returns true if the member exists, false otherwise
 */
function inviteExists($mysqli, $list_id, $receiver_id) {

  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }

  $query = "SELECT * FROM invites WHERE list_id=? AND receiver_id=?";
 
  $stmt = $mysqli->stmt_init();

  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement in inviteExists() ...");
  } else {
    $stmt->bind_param('ii',$list_id,$receiver_id);
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
 * A function to check whether the given list title already exists for the given user id
 * @param mysqli_object mysqli - the object for database the connection as defined in db-connect.php
 * @param string title - the title to check whether exists or not
 * @param string user_id - the user id to check if already has the given list title
 * @return boolean existence - returns true if the title already exists for the given user, false otherwise
 */
function titleExists($mysqli, $user_id, $title) {

  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }

  $query = "SELECT * FROM lists as l, owners as o, users as u WHERE u.id=o.user_id AND o.list_id=l.id AND l.title=?";
 
  $stmt = $mysqli->stmt_init();

  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement! (titleExists)");
  } else {
    $stmt->bind_param('s',$title);
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
 * A function to build a li item to for the ul holding a 
 * members lists and echos back that HTML
 * @param string title - the title of the list
 */
function buildList($title) {
echo <<<EOF

    <li class="user_list_overview">$title</li>
EOF;
}

/**
 * A function to build the HTML to represent a product in the members currently
 * displayed list. The function builds each product in a table row element and
 * echos that HTML code back to the caller
 * @param string product - the name of the product
 */
function buildProduct($product) {
echo <<<EOF

          <tr>
            <td>$product</td>
            <td>
              <form name="remove_item" method="post" class="remove_item" action="javascript:removeItem('$product')"/>
                <input type="submit" class="remove_button" name="removeitem" value="remove"/>
              </form>
            </td>
          </tr>
EOF;
}

/**
 * A function to get all the products from a given list id (cur_id) and puts them in an assoc
 * array with the product id as key and product name as value
 * @param mysqli_object mysqli - the object for database the connection as defined in db-connect.php
 * @param string cur_id - the list_id of which to get the products
 * @return array myProducts - an assoc array with product id as key and product name as value
 */
function getProducts($mysqli, $cur_id) {
  if($mysqli->connect_error) {
    die("$mysqli->connect_errno: $mysqli->connect_error");
  }

  $query = mysqli_real_escape_string($mysqli, "SELECT p.id, p.name FROM products as p, lists as l WHERE p.list_id=l.id AND l.id=?");

  $stmt = $mysqli->stmt_init();

  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement in getProducts() ...");
  } else {
    $stmt->bind_param('i', $cur_id);
    $stmt->execute();
    $stmt->bind_result($id, $name);
    $stmt->store_result();
    
    $myProducts = array();

    while($row = $stmt->fetch()) {
      $myProducts[$id] = $name;
    }

    return $myProducts;
  }
  mysqli_stmt_close($stmt);
  mysqli_close($mysqli);
}

/**
 * A function to display the waiting invites for the given user_id in the applications menu section by
 * echoing an approprite HTML section based on whether the number of invites are 1 or more, or not
 * @param mysqli_object mysqli - the object for database the connection as defined in db-connect.php
 * @param array user_lists - an assoc array holding the invites for the user with sender_id as key and list_id as value
 * @param string path - base path for the models folder, according to the config file for the application
 */
function invDisplay($user_lists, $path) {
  $num = count($user_lists);

  if($num >= 1) {
    foreach($user_lists as $sender => $list) {

echo <<<EOF
	     <div class="invitationFeedback">
	       <form method="POST" action="{$path}handle-invite.php" name="handle_invite" class="remove_item">
		 <p>$sender has invited you to the list:</p>
		 <p>$list</p>
		 <input type="hidden" name="sender" value="{$sender}"/>
		 <input type="hidden" name="list" value="{$list}"/>
		 <input type="submit" class="add_button" value="Accept" name="accept" /><input type="submit" class="add_button" value="Decline" name="decline" />
	       </form>
	     </div>

EOF;
    }
  } else {

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

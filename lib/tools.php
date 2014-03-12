<?php
/**
* A function to get the number of invites waiting for a given user
* @param user_id int the database user_id for the given user of which to get the number of waiting invites
* @param mysqli mysqli the object for database the connection as defined in db_connect.php
* @return string string a concatenation of the prefix 'invitations ' and the number of invitations
*/
function getInvQty($user_id, $mysqli) {

   if($mysqli->connect_error) {
      die("$mysqli->connect_errno: $mysqli->connect_error");
   }

   $query = mysqli_real_escape_string($mysqli, "SELECT COUNT(DISTINCT list_id) as qty FROM invites WHERE user_id=?");

   $stmt = $mysqli->stmt_init();
   if(!$stmt->prepare($query)) {
      print("Failed to prepare statement!");
   } else {
      $stmt->bind_param('s', $user_id);
      $stmt->execute();
      $stmt->bind_result($col1);
      while($stmt->fetch()) {
         $result = $col1;
      }
      $string = "Invitations [".$result."]";
      return $string;
   }
   mysqli_stmt_close($stmt);
   mysqli_close($mysqli);
}

/**
* A function that echos an option eleement for each of the lists 
* that the given user_id is registered as owner in the database
* @param user_id int the database user_id for the given user of which to get the number of waiting invites
* @param mysqli mysqli the object for database the connection as defined in db_connect.php
*/
function getListSummary($user_id, $mysqli) {

   if($mysqli->connect_error) {
      die("$mysqli->connect_errno: $mysqli->connect_error");
   }
   $query = "SELECT l.id, l.name FROM lists as l, owners as o, users as u WHERE u.id=? AND u.id=o.member_id AND o.list_id=l.id";
   $stmt = $mysqli->stmt_init();
   if(!$stmt->prepare($query)) {
      print("Failed to prepare statement!");
   } else {
      $stmt->bind_param('s', $user_id);
      $stmt->execute();
      $stmt->bind_result($list_id, $list_name);
      while($stmt->fetch()) {
echo <<<EOF
<option id="list_sum_$list_id">$list_name</option>

EOF;
      }
   } 
   mysqli_stmt_close($stmt);
   mysqli_close($mysqli);
}

/**
* A function that echos the list_container section-element that contains the list that the
* user is currently viewing with all of its contents/items
* @param list_id int the database id for the given list of which to get contents of
* @param list_name string the database name for the given list of which to get contents of
* @param current_id string the database username for the given user whom is registered as owner of the list 
*/
function buildList($list_id, $list_name, $current_user) {
include 'db_connect.php';
echo <<<EOF

	    <section class="list_container">
	      <section class="list_header">
		<h3 id="current_list" class="list_name">$list_name</h3>
EOF;
if(checkListOwnership($current_user, $list_id)) {
echo <<<EOF
<!--	  <h3 class="remove_list" id="remove_list">delete</h3> -->
		<h3 class="remove_list"><a onclick="javascript:deleteList(this)">delete</a></h3>
	      </section> <!-- end list_header -->
EOF;
} else {
echo <<<EOF
		    <h3 class="remove_list"><a onclick="javascript:deleteList(this)">remove</a></h3>
	      </section> <!-- end list_header -->
EOF;
}
   if($mysqli->connect_error) {
      die("$mysqli->connect_errno: $mysqli->connect_error");
   }

   if(checkListOwnership($current_user, $list_id)) {
      $query = "SELECT p.name FROM products as p, owners as o, users as u WHERE p.list_id=o.list_id AND o.list_id=? AND o.member_id=u.id AND u.username=?";
      } else {
      $query = "SELECT p.name FROM products as p, members as m, users as u WHERE p.list_id=m.list_id AND m.list_id=? AND m.user_id=u.id AND u.username=?";
      }

   $stmt = $mysqli->stmt_init();
   if(!$stmt->prepare($query)) {
      print("Failed to prepare statement!");
   } else {
      $stmt->bind_param('ss', $list_id, $current_user);
      $stmt->execute();
      $stmt->bind_result($product_name);
      $stmt->store_result();
      $row_cnt = $stmt->num_rows;

      if($row_cnt >= 1) {

echo <<<EOF
	  <section id="list_id_$list_id" class="shopping_list">
	    <table class="shopping_table">
EOF;
         while($stmt->fetch()) {	 
echo <<<EOF
	  <tr>
	    <td>$product_name</td>
	    <td>
	      <form name="remove_item" method="post" class="remove_item" action="javascript:removeItem('$list_id', '$product_name')">
		<input type="hidden" name="itemtoremove" value="$product_name"/>
		<input type="hidden" name="list_to_alter" value="$list_id" />
		<input type="submit" class="remove_button" name="removeitem" value="remove" />
	      </form>
	    </td>
	  </tr>
EOF;
        }
echo <<<EOF
	  </table>
	    <form class="add_item" name="add_item" method="post" action="javascript:addItem(this.add_item[0], $list_id)">
	      <span id="add_item_label"><normal>Add item: </normal></span>
	      <input name="itemtoadd" type="text" class="itemtoadd"  />
	      <input type="hidden" name="list_to_alter" value="$list_id" />
	      <input type="submit" name="additem" class="add_button" value="Add" />
	    </form>
	  </section> <!-- end shopping_list -->
EOF;
      } else {
echo <<<EOF
	  <section id="list_id_$list_id" class="shopping_list">
	    <table class="shopping_table">
	      <tr>
		<td>You haven't added anything to the list yet!</td>
	      </tr>
	    </table>
	    <form class="add_item" name="add_item" method="post" action="javascript:addItem(this.add_item[0], $list_id)">
	      <span id="add_item_label"><normal>Add item: </normal></span>
	      <input name="itemtoadd" type="text" class="itemtoadd" />
	      <input type="hidden" name="list_to_alter" value="$list_id" />
	      <input type="submit" name="additem" class="add_button" value="Add" />
	    </form>
	  </section> <!-- end shopping_list -->
EOF;

      }
echo <<<EOF
  	  </section> <!-- end list_container -->
EOF;
   }
}

/**
* A function that builds and echos the lists_overview section-element and subsequently the lists
* that the given user owns as well as those that the user is a member of
* @param user_id int the user_id of the given user of whom to get the lists
*/
function buildOverviewLists($user_id) {

$owner_lists = getOwnerLists($user_id);
$member_lists = getMemberLists($user_id);

$owner_list_count = $owner_lists[0];
$member_list_count = $member_lists[0];

echo <<<EOF
	  <section id="lists_overview" class="general_panel">
	    <img id="close_lists" onclick="closeLists()" src="media/close_window_w.png"></img>
	    <section class="list_header">
	      <h3 class="list_name">my lists</h3>
	    </section> <!-- end list_header -->
EOF;
if($owner_list_count >= 1 || $member_list_count >= 1) {
echo <<<EOF
	    <ul id="lists">
EOF;
if($owner_list_count >= 1) {
for($x=0; $x<$owner_list_count; $x++) {
$list_name = $owner_lists[$x+1][0];
$list_id = $owner_lists[$x+1][1];
echo <<<EOF

	      <li class="user_list_overview" id="list_id_$list_id" onclick="javascript:focusList(this)">$list_name</li>
EOF;

} 
}
if($member_list_count >= 1) {
for($y=0; $y<$member_list_count; $y++) {
$list_name = $member_lists[$y+1][0];
$list_id = $member_lists[$y+1][1];
echo <<<EOF

	  <li class="user_list_overview" id="list_id_$list_id" onclick="javascript:focusList(this)">$list_name</li>
EOF;
}
}
echo <<<EOF
	  
	    </ul> <!-- end lists -->
	  </section> <!-- end lists_overview -->
EOF;
} else {
echo <<<EOF
	  <ul id="empty_list">
	    <li class="empty_user_list_overview">Your lists will appear here.</li>
	  <ul>
	  </section> <!-- end lists_overview -->
EOF;
}
}

/**
* A function to get the database lists which the given user is an owner
* @param user_id int the user_id of the given user of whom to get the lists
* @return return_data array an array that contains the number of lists found at index[0] and
*                           subsequently it contains arrays containing the lists id and name at 
*                           index[0] and index[1] respectively
*/
function getOwnerLists($user_id) {
require 'db_connect.php';

   if($mysqli->connect_error) {
      die("$mysqli->connect_errno: $mysqli->connect_error");
   }

   $query = "SELECT l.id,l.name FROM lists as l, owners as o, users as u WHERE u.id=? AND u.id=o.member_id AND o.list_id=l.id";

   $return_data = array();

   $stmt = $mysqli->stmt_init();
   if(!$stmt->prepare($query)) {
      print($stmt->error);
   } else {
      $stmt->bind_param('i', $user_id);
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($colo1,$colo2);
      $num_rows = $stmt->num_rows;
      $return_data[] = $num_rows;

      while($stmt->fetch()) {
        $temp_array = array();
	$temp_array[] = $colo2;
	$temp_array[] = $colo1;
        $return_data[] = $temp_array;
      }

      return $return_data;
   }

mysqli_stmt_close($stmt);
mysqli_close($mysqli);

}

/**
* A function to get the database lists which the given user is a member
* @param user_id int the user_id of the given user of whom to get the lists
* @return return_data array an array that contains the number of lists found at index[0] and
*                           subsequently it contains arrays containing the lists id and name at 
*                           index[0] and index[1] respectively
*/
function getMemberLists($user_id) {
require 'db_connect.php';

   if($mysqli->connect_error) {
      die("$mysqli->connect_errno: $mysqli->connect_error");
   }

   $query = "SELECT l.id,l.name FROM lists as l, members as m, users as u WHERE u.id=? AND u.id=m.user_id AND m.list_id=l.id";

   $return_data = array();

   $stmt = $mysqli->stmt_init();
   if(!$stmt->prepare($query)) {
      print($stmt->error);
   } else {
      $stmt->bind_param('i', $user_id);
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($colm1,$colm2);
      $num_rows = $stmt->num_rows;
      $return_data[] = $num_rows;

      while($stmt->fetch()) {
        $temp_array = array();
	$temp_array[] = $colm2;
	$temp_array[] = $colm1;
        $return_data[] = $temp_array;
      }

      return $return_data;
   }

mysqli_stmt_close($stmt);
mysqli_close($mysqli);

}

/**
* A function that echos a table row-element for the given list and product in 
* the current list being displayed
* @param list_id int the database list_id of the given list
* @param product_name string the name of the given product
*/
function buildRow($list_id, $product_name) {

echo <<<EOF
     <tr>
       <td>$product_name</td>
       <td>
	 <form name="remove_item" method="post" class="remove_item" action="javascript:removeItem('$list_id', '$product_name')">
	   <input type="hidden" name="itemtoremove" value="$product_name"/>
	   <input type="hidden" name="list_to_alter" value="$list_id" />
	   <input type="submit" class="remove_button" name="removeitem" value="remove" />
	 </form>
       </td>
     </tr>
EOF;

}

/**
* A function to check whether the given user has database registered ownership
* of the given list
* @param current_user string the database username of the user to check
* @param list_id int the database list_id of the list to check
* @return owner boolean returns true if the user has ownership of the list, false otherwise
*/
function checkListOwnership($current_user, $list_id) {
require 'db_connect.php';
   if($mysqli->connect_error) {
      die("$mysqli->connect_errno: $mysqli->connect_error");
   }

   $query="SELECT COUNT(*) FROM owners as o, users as u, lists as l WHERE o.list_id=l.id AND l.id=? AND o.member_id=u.id AND u.username=?";

   $stmt = $mysqli->stmt_init();
   if(!$stmt->prepare($query)) {
      print("Failed to prepare statement! (checkListOwnership)");
   } else {
      $stmt->bind_param('is', $list_id, $current_user);
      $stmt->execute();
      $stmt->bind_result($count);
      $stmt->fetch();

      if($count >= 1) {
         $owner = True;
      } else {
         $owner = False;
      }
      return $owner;
   }
mysqli_stmt_close($stmt);
mysqli_close($mysqli);
}

/**
* A function to delete the given users database-registered membership with the given list
* from the database
* @param current_user string the database username of the given user
* @param listid int the database list_id of the given list
*/
function deleteListFromMembers($current_user, $listid) {
require 'db_connect.php';
   if($mysqli->connect_error) {
      die("$mysqli->connect_errno: $mysqli->connect_error");
   }

   $query = "DELETE FROM members WHERE list_id=? AND user_id=(SELECT id FROM users WHERE username=?)";

   $stmt = $mysqli->stmt_init();
   if(!$stmt->prepare($query)) {
      print("Failed to prepare statement! (deleteListFromOwners)");
   } else {
      $stmt->bind_param('is', $listid, $current_user);
      $stmt->execute();
   }

mysqli_stmt_close($stmt);
mysqli_close($mysqli);
}

/**
* A function to delete the given users database-registered ownership with the given list
* from the database
* @param listid int the database list_id of the given list of which to delete ownership
*/
function deleteListFromOwners($listid) {
require 'db_connect.php';
   if($mysqli->connect_error) {
      die("$mysqli->connect_errno: $mysqli->connect_error");
   }

   $query = "DELETE FROM owners WHERE list_id=?";

   $stmt = $mysqli->stmt_init();
   if(!$stmt->prepare($query)) {
      print("Failed to prepare statement! (deleteListFromOwners)");
   } else {
      $stmt->bind_param('i', $listid);
      $stmt->execute();
   }

mysqli_stmt_close($stmt);
mysqli_close($mysqli);

}

/**
* A function to delete a given list from the database lists table
* @param listid int the database id of the list to delete from the database table
*/
function deleteListFromLists($listid) {
require 'db_connect.php';
   if($mysqli->connect_error) {
      die("$mysqli->connect_errno: $mysqli->connect_error");
   }

   $query = "DELETE FROM owners WHERE list_id=?";
   $query = "DELETE FROM lists WHERE id=?";

   $stmt = $mysqli->stmt_init();
   if(!$stmt->prepare($query)) {
      print("Failed to prepare statement! (deleteListFromLists)");
   } else {
      $stmt->bind_param('i', $listid);
      $stmt->execute();
   }

mysqli_stmt_close($stmt);
mysqli_close($mysqli);

}

/**
* A function to get the database id for the given username
* @param theGivenUsername string the username of the user of which to get the database id
* @return result int the database id of the given username
*/
function getUserId($theGivenUsername) {
require 'db_connect.php';
    if($mysqli->connect_error) {
       die("$mysqli->connect_errno: $mysqli->connect_error");
    }

    $query = "SELECT id FROM users WHERE username=?";
    $result = 0;

    $stmt = $mysqli->stmt_init();
    if(!$stmt->prepare($query)) {
       print("Failed to prepare statement! (getUserId)");
    } else {
       $stmt->bind_param('s', $theGivenUsername);
       $stmt->execute();
       $stmt->bind_result($id);
       
       while($stmt->fetch()) {
           $result = $id;
       }

       return $result;
    }

mysqli_stmt_close($stmt);
mysqli_close($mysqli);
   
}

/**
* A function to check whether the given username exists in the database
* @param username string the database username of the given user
* @return boolean will return true if the given username exists in the database, false otherwise
*/
function userExistence($username) {
require 'db_connect.php';

  if($mysqli->connect_error) {
    die("$mysqli->connect_errno: $mysqli->connect_error");
  }

  $query = mysqli_real_escape_string($mysqli, "SELECT 1 FROM users WHERE username=?");

  $stmt = $mysqli->stmt_init();

  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement!");
  } else {

    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
  
     if($stmt->fetch()) {
        return True;
     } else {
        return False;
     }

  }

  mysqli_stmt_close($stmt);
  mysqli_close($mysqli);

}

/**
* A function to check whether the given email exists in the database
* @param email string the database entry of the given email address
* @return boolean will return true if the given email exists in the database, false otherwise
*/
function emailExistence($email) {
require 'db_connect.php';

  if($mysqli->connect_error) {
    die("$mysqli->connect_errno: $mysqli->connect_error");
  }

  $query = mysqli_real_escape_string($mysqli, "SELECT 1 FROM users WHERE email=?");

  $stmt = $mysqli->stmt_init();

  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement! (email-existence)");
  } else {

    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
  
     if($stmt->fetch()) {
        return True;
     } else {
        return False;
     }

  }

  mysqli_stmt_close($stmt);
  mysqli_close($mysqli);

}

/**
* A function that echos an invitationFeedback div-element for each invitation waiting
* for the given user
* @param user_id int the database id of the given user of which to get the related invitations for
*/
function getInvitationLists($user_id) {
require 'db_connect.php';

  if($mysqli->connect_error) {
    die("$mysqli->connect_errno: $mysqli->connect_error");
  }

  $query = "SELECT u.username, l.name, l.id FROM invites as i, users as u, lists as l WHERE l.id=i.list_id AND i.inviter_id=u.id AND i.user_id=?";

  $stmt = $mysqli->stmt_init();

  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement! (getInvitationLists)");
  } else {

    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->bind_result($inviter, $list_name, $list_id);
    $stmt->store_result();
    $num_invites = $stmt->num_rows;
  
    if($num_invites > 0) {
      while($stmt->fetch()) {
echo <<<EOF
	  <div class="invitationFeedback">
	    <p>$inviter has invited you to the list:</p>
	    <p>$list_name</p>
	    <div id="list_id_$list_id" class="button_holder">
	      <button class="accept_button add_button" onclick="javascript:acceptInvite(this)">Accept</button><button class="add_button" onclick="javascript:removeInvite(this)">Decline</button>
	    </div>
	  </div>
EOF;

      }
    } else {
echo <<<EOF
	  <div class="invitationFeedback">
	    <p class="empty_invites">There are no invites for you at the moment.</p>
	  </div>
EOF;
    }
  }

  mysqli_stmt_close($stmt);
  mysqli_close($mysqli);

}  

/**
* A function to get the number of invites registered for the given user in the database
* @param user_id int the database id of the given user
* @return num_invites int the number of invites
*/
function getNumberOfInvites($user_id) {
require 'db_connect.php';

  if($mysqli->connect_error) {
    die("$mysqli->connect_errno: $mysqli->connect_error");
  }

  $query = "SELECT u.username, l.name, l.id FROM invites as i, users as u, lists as l WHERE l.id=i.list_id AND i.inviter_id=u.id AND i.user_id=?";

  $stmt = $mysqli->stmt_init();

  if(!$stmt->prepare($query)) {
    print("Failed to prepare statement! (getNumberOfInvites)");
  } else {

  $stmt->bind_param('i', $user_id);
  $stmt->execute();
  $stmt->store_result();
  $num_invites = $stmt->num_rows;
    
  return $num_invites;
  }
}

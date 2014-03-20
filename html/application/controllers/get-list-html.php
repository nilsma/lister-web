<?php
session_start();
require_once $_SESSION['config'];
include ROOT . BASE . LIBS . 'member-functions.php';
include ROOT . BASE . LIBS . 'db-connect.php';

$user_id = $_SESSION['user_id'];
$user_lists = $_SESSION['user_lists'];

if(isset($_POST['title'])) {
  $cur_title = $_POST['title'];
  $cur_id = $user_lists[$cur_title];
  $_SESSION['cur_id'] = $cur_id;
} else {
  $cur_title = key($user_lists);
  $cur_id = $user_lists[$cur_title];
  $_SESSION['cur_id'] = $cur_id;
}

$products = getProducts($mysqli, $cur_id);

echo <<<EOF
	  <section class="list_container">
	    <section class="list_header">
	      <h3 id="current_list" class="list_name">$cur_title</h3>
	      <h3 id="delete_button" class="remove_list">delete</h3>
            </section> <!-- end list_header -->
	    <section class="shopping_list">
	      <table class="shopping_table">
EOF;

if(count($products) >= 1 ) {
  foreach($products as $product) {
    buildProduct($product);
  }
} else {
echo <<<EOF
  <td>You havent added anything to the list yet!</td>
EOF;
}

echo <<<EOF
          </table>
           <form class="add_item" name="add_item_form" method="post" action="javascript:addItem(this.add_item_form.itemtoadd.value)">
              <span id="add_item_label"><normal>Add item: </normal></span>
              <input id="itemtoadd" name="itemtoadd" type="text" class="itemtoadd"  />
              <input id="add_item" type="submit" name="additem" class="add_button" value="Add" />
            </form>
          </section> <!-- end shopping_list -->
        </section> <!-- end list_container -->
EOF;



?>

<?php

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
           <form class="add_item" name="add_item_form" method="post" action="javascript:addItem(this)">
              <span id="add_item_label"><normal>Add item: </normal></span>
              <input id="itemtoadd" name="itemtoadd" type="text" class="itemtoadd"  />
              <input id="add_item" type="submit" name="additem" class="add_button" value="Add" />
            </form>
          </section> <!-- end shopping_list -->
        </section> <!-- end list_container -->
EOF;



?>

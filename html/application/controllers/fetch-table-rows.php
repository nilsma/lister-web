<?php
/**
 * An application resource file that fetches new rows
 * of products from the products table in the application database
 * @author Nils Martinussen
 */

session_start();

require_once $_SESSION['config'];
require_once ROOT . BASE . LIBS . 'db-connect.php';
require_once ROOT . BASE . LIBS . 'functions.php';
require_once ROOT . BASE . LIBS . 'member-functions.php';

$cur_id = $_SESSION['cur_id'];
$products = getProducts($mysqli, $cur_id);

if(count($products) >= 1 ) {
  foreach($products as $product) {
    buildProduct($product);
  }
} else {
echo <<<EOF
    <td>You havent added anything to the list yet!</td>
EOF;
}

?>
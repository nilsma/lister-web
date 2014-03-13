<?php

/**
 * Database configuration
 */
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'lister');
define('DB_USER', 'root');
define('DB_PASS', '8kMkyg()');

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

?>
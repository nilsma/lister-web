<?php

/**
 * Database configuration
 */
defined('DB_TYPE') || define('DB_TYPE', 'mysql');
defined('DB_HOST') || define('DB_HOST', 'localhost');
defined('DB_NAME') || define('DB_NAME', 'lister');
defined('DB_USER') || define('DB_USER', 'root');
defined('DB_PASS') || define('DB_PASS', '8kMkyg()');

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

?>
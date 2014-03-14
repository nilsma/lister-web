<?php

/**
 * PHP configuration
 * Enable error reporting
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Application base URL
 */
define('URL', 'http://127.0.1.1/login/html/');

/**
 * Folder paths
 */
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('BASE', '/lister-web/html/');
define('CONFIGS', 'application/configs/');
define('CONTROLLERS', 'application/controllers/');
define('LIBS', 'application/libs/');
define('MODELS', 'application/models/');
define('VIEWS', 'application/views/');
define('CSS', 'public/css/');
define('JS', 'public/js/');
define('PICS', 'public/media/pics/');

/**
 * Cookie configuration
 */
//set cookie runtime to 1209600 seconds = 2 weeks
define('COOKIE_RUNTIME', 1209600);
define('COOKIE_DOMAIN', '.127.0.1.1');
?>

<?php
session_start();
require 'application/configs/config.php';
$_SESSION['config'] = ROOT . '/' . CONFIGS . 'config.php';
header('Location: application/views/index.php');
?>
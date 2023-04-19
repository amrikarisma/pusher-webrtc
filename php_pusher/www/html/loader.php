<?php
// Loader
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once('db.php');
require_once('functions.php');

if (!isset($_SESSION['user_id']) && $_SERVER['REQUEST_URI'] != '/login.php' && $_SERVER['REQUEST_URI'] != '/register.php') {
    header("Location: login.php");
} elseif (isset($_SESSION['redirect_login'])  || (isset($_SESSION['user_id']) && $_SERVER['REQUEST_URI'] == '/login.php')) {
    unset($_SESSION['redirect_login']);
    header("Location: index.php");
}

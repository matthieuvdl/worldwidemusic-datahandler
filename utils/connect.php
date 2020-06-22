<?php

// Errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// DB
if($_SERVER['HTTP_HOST'] === 'localhost') // Local Server
{
    define('DB_HOST', 'localhost');
    define('DB_PORT', '3306');
    define('DB_USER', 'dbuser');
    define('DB_PASS', 'password');
}
else if($_SERVER['HTTP_HOST'] === 'host.fr') // Remote Server
{
    define('DB_HOST', 'host.fr');
    define('DB_PORT', '3306');
    define('DB_USER', 'dbuser');
    define('DB_PASS', 'password');
}
define('DB_NAME', 'dbname');

$pdo = new PDO('mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME, DB_USER, DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Set Token
$token = 'kEdAOaZzCWtapUMqxnrnKITLtjHluBOZfncHTxZC';

// Set Headers for CURL
$header = array();
$header[] = 'Authorization: Discogs token='.$token;
$header[] = 'Content-type: application/json';
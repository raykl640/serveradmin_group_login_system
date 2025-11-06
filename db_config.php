<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'ray');
define('DB_PASS', 'lukorito');
define('DB_NAME', 'GROUP1');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>

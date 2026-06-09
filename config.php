<?php

$host = getenv('DB_HOST') ?: 'localhost';
$db   = getenv('DB_NAME') ?: 'shop_db';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';

$db_name = "mysql:host=$host;dbname=$db";

$conn = new PDO($db_name, $user, $pass);

?>
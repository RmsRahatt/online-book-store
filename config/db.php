<?php

$host       = "127.0.0.1";
$dbuser     = "root";
$dbpassword = "";
$dbname     = "book_store";

function getConnection() {
    global $host, $dbuser, $dbpassword, $dbname;
    $dsn = "mysql:host=$host;dbname=$dbname";
    $pdo = new PDO($dsn, $dbuser, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}
<?php
$host       = "127.0.0.1";
$dbuser     = "root";
$dbpassword = "";
$dbname     = "book_store";

// For Task 1 (User Auth) - PDO
function getConnection(){
    global $host, $dbuser, $dbpassword, $dbname;
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbuser, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

// For Task 2 (Admin Model) - PDO
function getPDO(){
    global $host, $dbuser, $dbpassword, $dbname;
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbuser, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}
?>

<?php
$host       = "127.0.0.1";
$dbuser     = "root";
$dbpassword = "";
$dbname     = "online_book_store"; // Fixed database name

// For Task 1 (User Auth)
function getConnection(){
    global $host, $dbuser, $dbpassword, $dbname;
    $con = mysqli_connect($host, $dbuser, $dbpassword, $dbname);
    return $con;
}

// For Task 2 (Admin Model)
function getPDO(){
    global $host, $dbuser, $dbpassword, $dbname;
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbuser, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}
?>
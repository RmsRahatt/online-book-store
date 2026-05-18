<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['csrf_token'])){
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Book Store</title>

<link rel="stylesheet"
href="../public/css/style.css">

<script src="../public/js/auth.js"></script>
<script src="../public/js/ajax.js"></script>

</head>
<body>

<nav>
    <a href="home.php">Home</a>
    <a href="profile.php">Profile</a>
    
    <a href="../index.php?page=search">Search Books</a>
    <a href="../index.php?page=cart">Cart</a>

    <?php
    if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
    ?>
        <a href="admin/dashboard.php">Admin Panel</a>
    <?php
    }
    ?>

    <a href="../controller/logout.php">Logout</a>
</nav>

<hr>
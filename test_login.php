<?php
session_start();
$_SESSION['role'] = 'admin';
$_SESSION['name'] = 'Admin User';
$_SESSION['user_id'] = 1;

header("Location: view/admin/dashboard.php");
exit();
?>
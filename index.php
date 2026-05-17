<?php
session_start();
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') {
        header('location: view/home.php');
    } else {
        header('location: view/home.php');
    }
} else {
    header('location: view/login.php');
}
exit();
?>

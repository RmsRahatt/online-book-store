<?php
<<<<<<< HEAD
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
=======
    session_start();
    if(isset($_SESSION['role'])){
        if($_SESSION['role'] == 'admin'){
            header('location: view/admin/dashboard.php');
        } else {
            header('location: view/home.php');
        }
    } else {
        header('location: view/login.php');
    }
    exit();
?>
>>>>>>> 3f77ff73afc8e48e1d9871dfa4165e1d4976c479

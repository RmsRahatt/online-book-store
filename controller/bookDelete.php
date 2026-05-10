<?php
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
        header('location: ../view/admin/dashboard.php');
        exit();
    }
    require_once('../model/adminModel.php');

    if(isset($_GET['id'])){
        $id     = $_GET['id'];
        $result = deleteBook($id);

        if($result == "blocked"){
            $_SESSION['error'] = "Cannot delete! This book is in a pending order.";
        } else {
            $_SESSION['success'] = "Book deleted successfully!";
        }

        header('location: ../view/admin/book_list.php');
        exit();

    } else {
        header('location: ../view/admin/book_list.php');
        exit();
    }
?>

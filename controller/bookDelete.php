<?php
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
        header('location: ../index.php');
        exit();
    }
    require_once('../model/adminModel.php');

    if(isset($_POST['id'])){
        $id     = $_POST['id'];
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

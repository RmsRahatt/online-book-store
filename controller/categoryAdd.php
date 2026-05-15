<?php
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
        header('location: ../index.php');
        exit();
    }
    require_once('../model/adminModel.php');

    if(isset($_POST['submit'])){
        $name = trim($_POST['name']);

        if($name == ""){
            $_SESSION['error'] = "Category name is required!";
            header('location: ../view/admin/category_list.php');
            exit();
        }

        addCategory($name);
        $_SESSION['success'] = "Category added successfully!";
        header('location: ../view/admin/category_list.php');
        exit();

    } else {
        header('location: ../view/admin/category_list.php');
        exit();
    }
?>

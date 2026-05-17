<?php
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
        header('location: ../index.php');
        exit();
    }
    require_once('../model/adminModel.php');

    if(isset($_POST['submit'])){
        $id   = $_POST['id'];
        $name = trim($_POST['name']);

        if($name == ""){
            $_SESSION['error'] = "Category name is required!";
            header('location: ../view/admin/category_list.php');
            exit();
        }

        updateCategory($id, $name);
        $_SESSION['success'] = "Category updated successfully!";
        header('location: ../view/admin/category_list.php');
        exit();

    } else {
        header('location: ../view/admin/category_list.php');
        exit();
    }
?>

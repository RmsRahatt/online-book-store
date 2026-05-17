<?php
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
        header('location: ../index.php');
        exit();
    }
    require_once('../model/adminModel.php');

    if(isset($_POST['submit'])){

        $id          = $_POST['id'];
        $title       = trim($_POST['title']);
        $author      = trim($_POST['author']);
        $desc        = trim($_POST['description']);
        $price       = $_POST['price'];
        $category_id = $_POST['category_id'];
        $stock       = $_POST['stock'];

        if($title == "" || $author == "" || $desc == ""){
            $_SESSION['error'] = "Title, Author and Description are required!";
            header('location: ../view/admin/book_edit.php?id=' . $id);
            exit();
        }

        if($price <= 0){
            $_SESSION['error'] = "Price must be greater than 0!";
            header('location: ../view/admin/book_edit.php?id=' . $id);
            exit();
        }

        if($category_id == ""){
            $_SESSION['error'] = "Please select a category!";
            header('location: ../view/admin/book_edit.php?id=' . $id);
            exit();
        }

        if($stock < 0){
            $_SESSION['error'] = "Stock cannot be negative!";
            header('location: ../view/admin/book_edit.php?id=' . $id);
            exit();
        }

        $old        = getBookById($id);
        $image_path = $old['image_path'];

        if(isset($_FILES['image']) && $_FILES['image']['size'] > 0){
            $allowed = ['image/jpeg', 'image/png'];
            $max     = 2 * 1024 * 1024;

            if(!in_array($_FILES['image']['type'], $allowed)){
                $_SESSION['error'] = "Only JPEG and PNG images are allowed!";
                header('location: ../view/admin/book_edit.php?id=' . $id);
                exit();
            }
            if($_FILES['image']['size'] > $max){
                $_SESSION['error'] = "Image size must be less than 2MB!";
                header('location: ../view/admin/book_edit.php?id=' . $id);
                exit();
            }

            $src     = $_FILES['image']['tmp_name'];
            $ext     = explode('.', $_FILES['image']['name']);
            $newName = time() . "." . end($ext);
            $des     = 'public/uploads/books/' . $newName;

            if(move_uploaded_file($src, '../' . $des)){
        
                if($image_path != "" && file_exists('../' . $image_path)){
                    unlink('../' . $image_path);
                }
                $image_path = $des;
            }
        }

        updateBook($id, $title, $author, $desc, $price, $category_id, $image_path, $stock);
        $_SESSION['success'] = "Book updated successfully!";
        header('location: ../view/admin/book_list.php');
        exit();

    } else {
        header('location: ../view/admin/book_list.php');
        exit();
    }
?>

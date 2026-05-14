<?php

session_start();

require_once "../model/userModel.php";

if(isset($_POST['update'])){

    if(
        !isset($_POST['csrf_token'])
        ||
        $_POST['csrf_token'] != $_SESSION['csrf_token']
    ){

        die("CSRF Token Invalid");
    }

    $id = $_SESSION['user_id'];

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);

    if(
        $name == "" ||
        $email == "" ||
        $address == "" ||
        $phone == ""
    ){

        $_SESSION['error'] =
        "All Fields Required";

        header("location: ../view/profile.php");

        exit();
    }

    $picture = "";

    if($_FILES['picture']['name'] != ""){

        $allowed = [
            'image/jpeg',
            'image/png'
        ];

        $type = $_FILES['picture']['type'];

        $size = $_FILES['picture']['size'];

        if(!in_array($type, $allowed)){

            $_SESSION['error'] =
            "Only JPG and PNG Allowed";

            header("location: ../view/profile.php");

            exit();
        }

        if($size > 2000000){

            $_SESSION['error'] =
            "File Too Large";

            header("location: ../view/profile.php");

            exit();
        }

        $picture = time() .
        $_FILES['picture']['name'];

        move_uploaded_file(
            $_FILES['picture']['tmp_name'],
            "../public/uploads/" . $picture
        );
    }

    updateProfile(
        $id,
        $name,
        $email,
        $address,
        $phone,
        $picture
    );

    $_SESSION['success'] =
    "Profile Updated Successfully";

    header("location: ../view/profile.php");

    exit();
}

?>
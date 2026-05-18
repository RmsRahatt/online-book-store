<?php

session_start();

require_once "../model/userModel.php";

if(isset($_POST['signup'])){

    if(
        !isset($_POST['csrf_token'])
        ||
        $_POST['csrf_token'] != $_SESSION['csrf_token']
    ){
        die("CSRF Token Invalid");
    }

    $name    = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $password= trim($_POST['password']);
    $role    = trim($_POST['role']);
    $address = trim($_POST['address']);
    $phone   = trim($_POST['phone']);

    if(
        $name == "" ||
        $email == "" ||
        $password == "" ||
        $role == "" ||
        $address == "" ||
        $phone == ""
    ){
        $_SESSION['error'] = "All Fields Required";
        header("location: ../view/signup.php");
        exit();
    }

    if(strlen($password) < 8){
        $_SESSION['error'] = "Password Must Be 8 Characters";
        header("location: ../view/signup.php");
        exit();
    }

    $check = checkEmail($email); // returns array (PDO)

    if(count($check) > 0){  // ✅ PDO array check
        $_SESSION['error'] = "Email Already Exists";
        header("location: ../view/signup.php");
        exit();
    }

    registerUser($name, $email, $password, $role, $address, $phone);

    $_SESSION['success'] = "Registration Successful";
    header("location: ../view/login.php");
    exit();
}
?>

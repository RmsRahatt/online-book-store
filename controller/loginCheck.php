<?php

session_start();

require_once "../model/userModel.php";

if(isset($_POST['login'])){

    if(
        !isset($_POST['csrf_token'])
        ||
        $_POST['csrf_token'] != $_SESSION['csrf_token']
    ){
        die("CSRF Token Invalid");
    }

    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    $result = loginUser($email); // returns array (PDO)

    if(count($result) > 0){  // ✅ PDO array check

        $user = $result[0];  // ✅ PDO: first row is $result[0]

        if(password_verify($password, $user['password_hash'])){

            $_SESSION['status']  = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name']    = $user['name'];
            $_SESSION['role']    = $user['role'];

            if(isset($_POST['remember'])){

                $token = bin2hex(random_bytes(32));

                setcookie("remember_token", $token, time() + (86400 * 7), "/");
                setcookie("remember_id", $user['id'], time() + (86400 * 7), "/");
            }

            header("location: ../view/home.php");
            exit();

        } else {

            $_SESSION['error'] = "Invalid Password";
            header("location: ../view/login.php");
            exit();
        }

    } else {

        $_SESSION['error'] = "User Not Found";
        header("location: ../view/login.php");
        exit();
    }
}
?>

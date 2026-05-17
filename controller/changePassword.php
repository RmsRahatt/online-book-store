<?php

session_start();

require_once "../model/userModel.php";

if(
    !isset($_POST['csrf_token'])
    ||
    $_POST['csrf_token'] != $_SESSION['csrf_token']
){

    die("CSRF Token Invalid");
}

$id = $_SESSION['user_id'];

$current = $_POST['current_password'];
$new = $_POST['new_password'];

if($current == "" || $new == ""){

    $_SESSION['error'] =
    "All Fields Required";

    header("location: ../view/profile.php");

    exit();
}

if(strlen($new) < 8){

    $_SESSION['error'] =
    "New Password Must Be 8 Characters";

    header("location: ../view/profile.php");

    exit();
}

$result = getUserById($id);

$user = mysqli_fetch_assoc($result);

if(password_verify(
    $current,
    $user['password_hash']
)){

    changePassword(
        $id,
        $new
    );

    $_SESSION['success'] =
    "Password Changed";
}
else{

    $_SESSION['error'] =
    "Current Password Incorrect";
}

header("location: ../view/profile.php");

exit();

?>
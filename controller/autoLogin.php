<?php

require_once "../model/userModel.php";

if(
    !isset($_SESSION['status'])
    &&
    isset($_COOKIE['remember_token'])
    &&
    isset($_COOKIE['remember_id'])
){

    $id = intval($_COOKIE['remember_id']);

    $result = getUserById($id);

    if(mysqli_num_rows($result) > 0){

        $user = mysqli_fetch_assoc($result);

        $_SESSION['status'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
    }
}

?>
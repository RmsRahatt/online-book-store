<?php

require_once "../model/userModel.php";

if(
    !isset($_SESSION['status'])
    &&
    isset($_COOKIE['remember_token'])
    &&
    isset($_COOKIE['remember_id'])
){
    $id     = intval($_COOKIE['remember_id']);
    $result = getUserById($id); // returns array (PDO)

    if(count($result) > 0){  // ✅ PDO array check

        $user = $result[0];  // ✅ PDO: first row is $result[0]

        $_SESSION['status']  = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name']    = $user['name'];
        $_SESSION['role']    = $user['role'];
    }
}
?>

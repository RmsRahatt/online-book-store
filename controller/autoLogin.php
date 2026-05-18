<?php

require_once "../model/userModel.php";

if (
    !isset($_SESSION['status'])
    && isset($_COOKIE['remember_token'])
    && isset($_COOKIE['remember_id'])
) {
    $id     = intval($_COOKIE['remember_id']);
    $rows   = getUserById($id);

    if (count($rows) > 0) {
        $user = $rows[0];
        $_SESSION['status']  = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name']    = $user['name'];
        $_SESSION['role']    = $user['role'];
    }
}

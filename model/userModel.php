<?php

require_once "../config/db.php";

function checkEmail($email){

    $con = getConnection();

    $sql = "SELECT * FROM users
            WHERE email=?";

    $stmt = mysqli_prepare($con, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "s",
        $email
    );

    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}

function registerUser(
    $name,
    $email,
    $password,
    $role,
    $address,
    $phone
){

    $con = getConnection();

    $hashPassword = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    $sql = "INSERT INTO users
            (name,email,password_hash,role,address,phone)

            VALUES
            (?,?,?,?,?,?)";

    $stmt = mysqli_prepare($con, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssssss",
        $name,
        $email,
        $hashPassword,
        $role,
        $address,
        $phone
    );

    return mysqli_stmt_execute($stmt);
}

function loginUser($email){

    $con = getConnection();

    $sql = "SELECT * FROM users
            WHERE email=?";

    $stmt = mysqli_prepare($con, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "s",
        $email
    );

    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}

function updateRememberToken(
    $id,
    $token
){

    $con = getConnection();

    $sql = "UPDATE users
            SET remember_token=?
            WHERE id=?";

    $stmt = mysqli_prepare($con, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "si",
        $token,
        $id
    );

    return mysqli_stmt_execute($stmt);
}

function getUserByToken($token){

    $con = getConnection();

    $sql = "SELECT * FROM users
            WHERE remember_token=?";

    $stmt = mysqli_prepare($con, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "s",
        $token
    );

    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}

function getUserById($id){

    $con = getConnection();

    $sql = "SELECT * FROM users
            WHERE id=?";

    $stmt = mysqli_prepare($con, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $id
    );

    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}

function updateProfile(
    $id,
    $name,
    $email,
    $address,
    $phone,
    $picture
){

    $con = getConnection();

    $sql = "UPDATE users
            SET
            name=?,
            email=?,
            address=?,
            phone=?,
            profile_picture=?
            WHERE id=?";

    $stmt = mysqli_prepare($con, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sssssi",
        $name,
        $email,
        $address,
        $phone,
        $picture,
        $id
    );

    return mysqli_stmt_execute($stmt);
}

function changePassword(
    $id,
    $password
){

    $con = getConnection();

    $hashPassword = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    $sql = "UPDATE users
            SET password_hash=?
            WHERE id=?";

    $stmt = mysqli_prepare($con, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "si",
        $hashPassword,
        $id
    );

    return mysqli_stmt_execute($stmt);
}

?>
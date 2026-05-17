<?php

require_once "../config/db.php";

function checkEmail($email) {
    $pdo  = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function registerUser($name, $email, $password, $role, $address, $phone) {
    $pdo          = getConnection();
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare(
        "INSERT INTO users (name, email, password_hash, role, address, phone)
         VALUES (?, ?, ?, ?, ?, ?)"
    );
    return $stmt->execute([$name, $email, $hashPassword, $role, $address, $phone]);
}

function loginUser($email) {
    $pdo  = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getUserById($id) {
    $pdo  = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateProfile($id, $name, $email, $address, $phone, $picture) {
    $pdo  = getConnection();
    $stmt = $pdo->prepare(
        "UPDATE users SET name = ?, email = ?, address = ?, phone = ?, profile_picture = ?
         WHERE id = ?"
    );
    return $stmt->execute([$name, $email, $address, $phone, $picture, $id]);
}

function changePassword($id, $password) {
    $pdo          = getConnection();
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
    return $stmt->execute([$hashPassword, $id]);
}

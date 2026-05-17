<?php

require_once "../config/db.php";

function getCategories() {
    $pdo  = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM categories");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getFeaturedBooks() {
    $pdo  = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM books ORDER BY RAND() LIMIT 4");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getBooksByCategory($id) {
    $pdo  = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM books WHERE category_id = ?");
    $stmt->execute([$id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

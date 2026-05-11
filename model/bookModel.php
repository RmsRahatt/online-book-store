<?php

require_once "../config/db.php";

function getCategories(){

    $con = getConnection();

    $sql = "SELECT * FROM categories";

    $stmt = mysqli_prepare($con, $sql);

    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}

function getFeaturedBooks(){

    $con = getConnection();

    $sql = "SELECT * FROM books
            ORDER BY RAND()
            LIMIT 4";

    $stmt = mysqli_prepare($con, $sql);

    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}

function getBooksByCategory($id){

    $con = getConnection();

    $sql = "SELECT * FROM books
            WHERE category_id=?";

    $stmt = mysqli_prepare($con, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $id
    );

    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}

?>
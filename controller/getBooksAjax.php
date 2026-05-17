<?php

header("Content-Type: application/json");

require_once "../model/bookModel.php";

if(isset($_GET['id'])){

    $id = intval($_GET['id']);

    $result = getBooksByCategory($id);

    $data = [];

    while($row = mysqli_fetch_assoc($result)){

        $data[] = $row;
    }

    echo json_encode([
        "status" => "success",
        "books" => $data
    ]);
}
else{

    echo json_encode([
        "status" => "error",
        "message" => "No category selected"
    ]);
}

?>
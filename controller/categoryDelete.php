<?php
    header('Content-Type: application/json');
    session_start();

    if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit();
    }

    require_once('../model/adminModel.php');

    if(isset($_POST['id'])){
        $id     = $_POST['id'];
        $result = deleteCategory($id);

        if($result == "blocked"){
            echo json_encode(['success' => false, 'message' => 'Cannot delete! Books exist under this category.']);
        } else {
            echo json_encode(['success' => true, 'message' => 'Category deleted successfully!']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
    }
?>

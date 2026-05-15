<?php
    header('Content-Type: application/json');
    session_start();

    if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit();
    }

    require_once('../model/adminModel.php');

    if(isset($_POST['order_id']) && isset($_POST['status'])){
        $order_id = $_POST['order_id'];
        $status   = $_POST['status'];

        $allowed = ['pending', 'confirmed', 'shipped', 'delivered'];
        if(!in_array($status, $allowed)){
            echo json_encode(['success' => false, 'message' => 'Invalid status value']);
            exit();
        }

        $result = updateOrderStatus($order_id, $status);

        if($result){
            echo json_encode(['success' => true, 'message' => 'Order status updated to ' . $status . '!', 'status' => $status]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Update failed. Try again.']);
        }

    } else {
        echo json_encode(['success' => false, 'message' => 'Missing order_id or status']);
    }
?>

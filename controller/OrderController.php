<?php
header('Content-Type: application/json');

require_once '../config/db.php';
require_once '../model/OrderModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $orderModel = new OrderModel($conn);

    $address = isset($_POST['address']) ? strip_tags($_POST['address']) : '';
    $payment = isset($_POST['payment_method']) ? strip_tags($_POST['payment_method']) : '';
    
    $user_id = 1; 
    $total_price = 500.00; 

    if (empty($address) || empty($payment)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required!']);
        exit;
    }

    $order_id = $orderModel->createOrder($user_id, $total_price, $payment, $address);

    if ($order_id) {
        echo json_encode(['success' => true, 'order_id' => $order_id]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save order in database.']);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid Request.']);
}
?>

<?php
error_reporting(0); 
header('Content-Type: application/json');

$conn = mysqli_connect('localhost', 'root', '', 'book_store');

if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'DB Connection Failed']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment = isset($_POST['payment_method']) ? mysqli_real_escape_string($conn, $_POST['payment_method']) : '';
    
    $user_id = 1; 
    $total = 500.00; 
    $status = 'pending';

    $sql = "INSERT INTO orders (user_id, total_amount, status, payment_method) 
            VALUES ('$user_id', '$total', '$status', '$payment')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode([
            'success' => true, 
            'order_id' => mysqli_insert_id($conn)
        ]);
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'SQL Error: ' . mysqli_error($conn)
        ]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid Request']);
}
?>
<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../config/db.php';
$conn = getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment = isset($_POST['payment_method']) ? mysqli_real_escape_string($conn, $_POST['payment_method']) : '';
    
    // 1. Get real user ID
    $user_id = $_SESSION['user_id']; 
    
    // 2. Calculate real total from their specific cart
    $cart_query = mysqli_query($conn, "SELECT c.quantity, b.price FROM cart c JOIN books b ON c.book_id = b.id WHERE c.user_id = '$user_id'");
    $total = 0;
    while($item = mysqli_fetch_assoc($cart_query)) {
        $total += ($item['price'] * $item['quantity']);
    }

    if($total == 0) {
        echo json_encode(['success' => false, 'message' => 'Your cart is empty!']);
        exit;
    }

    $status = 'pending';
    $sql = "INSERT INTO orders (user_id, total_amount, status, payment_method) VALUES ('$user_id', '$total', '$status', '$payment')";

    if (mysqli_query($conn, $sql)) {
        $order_id = mysqli_insert_id($conn);
        
        // 3. Clear the user's cart after successful checkout!
        mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'");

        echo json_encode(['success' => true, 'order_id' => $order_id]);
    } else {
        echo json_encode(['success' => false, 'message' => 'SQL Error']);
    }
}
?>